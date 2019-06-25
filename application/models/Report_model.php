<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	class Report_model extends CI_model{
		
		private $shop_id;
		function __construct()
		{
			$this->shop_id = $this->tank_auth->get_shop_id();
		}
		/**********************
		 * Shop Information
		 * 23-11-2013
		 * Arafat Mamun
		 **********************/
		function shop_information($specific, $shop_id)
		{
			if($specific) $this -> db -> where('shop_id', $shop_id);
			$this -> db -> where('shop_status', 1);
			return $this -> db -> get('shop_setup');
		}
		
		/*******************************
		 * System For vission Express
		 * Product Transfer Log
		 * 14-12-2013
		 * Arafat Mamun
		********************************/
		function product_transfer_log($selected_product_id, $selected_shop_id, $transfer_mode, $start_date, $end_date)
		{
			$specific_product = '';
			if($selected_product_id != 'notSelected')
				$specific_product = 'AND product_id ='.$selected_product_id;

			
			$in_mode = '';
			$from_shop = '';
			$out_mode = '';
			$to_shop = '';
			if($transfer_mode == 'inProducts')
			{
				if($selected_shop_id != 'notSelected')
				{
					$from_shop = 'AND from_shop='.$selected_shop_id; //*
					$to_shop = 'AND from_shop ='.$selected_shop_id;
				}
				$in_mode = 'AND to_shop ='.$this -> shop_id;//*
				$out_mode = 'AND to_shop ='.$this -> shop_id;
			}
			else if($transfer_mode == 'outProducts')
			{
				if($selected_shop_id != 'notSelected')
				{
					$to_shop = 'AND to_shop ='.$selected_shop_id;//*
					$from_shop = 'AND to_shop='.$selected_shop_id;
				}
				$out_mode = 'AND from_shop ='.$this -> shop_id;//*
				$in_mode = 'AND from_shop ='.$this -> shop_id;
			}
			else
			{
				if($selected_shop_id != 'notSelected')
					$from_shop = 'AND from_shop ='.$selected_shop_id;
				$in_mode = 'AND to_shop ='.$this -> shop_id;
				if($selected_shop_id != 'notSelected')
					$to_shop = 'AND to_shop ='.$selected_shop_id;
				$out_mode = 'AND from_shop ='.$this -> shop_id;
			}
				
			$query = $this -> db -> query("
											SELECT  transfer_id, product_info.product_id,product_name,
													from_shop, transfered_from,
													transfered_to,to_shop , transfer_amount ,
													unit_buy_price, transferred_by, transfer_date
			
			
											FROM	product_info,(  SELECT  transfer_id, product_id,
																			from_shop, transfered_from,
																			shop_name as  transfered_to,
																			to_shop , transfer_amount ,
																			unit_buy_price, transferred_by, transfer_date
																	
																	FROM shop_setup,(	SELECT  transfer_id, product_id,
																								from_shop, shop_name as transfered_from,
																								to_shop , transfer_amount ,
																								unit_buy_price, transferred_by, transfer_date
																											
																						FROM 	product_transfer_log, shop_setup
																						WHERE   shop_id = from_shop		 
																						AND     (transfer_date BETWEEN '".$start_date."' AND '".$end_date."')
																						".$specific_product."
																						".$out_mode."
																						".$to_shop."
																					) AS temp1
																	WHERE shop_id = to_shop
																UNION
																	SELECT  transfer_id, product_id,
																			from_shop, shop_name as  transfered_from,
																			transfered_to,
																			to_shop , transfer_amount ,
																			unit_buy_price, transferred_by, transfer_date
																	
																	FROM shop_setup,(	SELECT  transfer_id, product_id,
																								from_shop, shop_name as transfered_to,
																								to_shop , transfer_amount ,
																								unit_buy_price, transferred_by, transfer_date
																											
																						FROM 	product_transfer_log, shop_setup
																						WHERE   shop_id = to_shop	 
																						AND     (transfer_date BETWEEN '".$start_date."' AND '".$end_date."')
																						".$specific_product."
																						".$in_mode."
																						".$from_shop."
																					) AS temp2
																	WHERE shop_id = from_shop
																) AS all_info
											WHERE product_info.product_id = all_info.product_id
											ORDER BY transfer_date asc
										");
			return $query;
		}
		/********************************
		 *  Get All Stock Info For Report *
		 * ******************************/
		 function get_all_stock_report()
		 {
			$this -> db -> order_by("product_info.product_name", "asc");
			$query = $this -> db -> select('product_info.product_id, product_info.product_name, product_info.unit_name,
												bulk_stock_info.stock_amount, bulk_stock_info.bulk_unit_sale_price AS unit_sale_price,
												bulk_stock_info.bulk_unit_buy_price')
									 -> from('product_info, bulk_stock_info')
									 -> where('bulk_stock_info.shop_id', $this -> shop_id)
									 -> where('product_info.product_id = bulk_stock_info.product_id')
									 -> group_by('product_info.product_name')
		                  			 -> get();
			 return $query;
		 }
		 
		 
		 
		  /********************************************
		  *  All Buy Details Of AN Individual Product  *
		  *********************************************/
		  function fatch_all_buy_details( $product_id)
		  {
			$this -> db -> select('unit_buy_price, distributor_name, distributor_info.distributor_id,purchase_receipt_info.receipt_id,
								   receipt_date, SUM(purchase_quantity) AS purchase_quantity, purchase_creator');
			//$this -> db -> from('catagory_info,  company_info, product_info, purchase_info, stock_info, sale_price_info,  bulk_stock_info');
			$this -> db -> from('purchase_receipt_info, purchase_info,  distributor_info');
			$this -> db -> where('purchase_info.product_id = "'.$product_id.'"');
			//$this -> db -> where('bulk_stock_info.product_id = product_info.product_id');
			//$this -> db -> where('catagory_info.catagory_name = product_info.catagory_name');
			$this -> db -> where('purchase_receipt_info.distributor_id = distributor_info.distributor_id');
			//$this -> db -> where('product_info.product_id = purchase_info.product_id');
			$this -> db -> where('purchase_info.purchase_receipt_id = purchase_receipt_info.receipt_id');
			//$this -> db -> where('product_info.product_id = sale_price_info.product_id');
			$this -> db -> group_by('purchase_info.purchase_receipt_id');
			$query = $this -> db -> get();
			return $query;
		}
		/************************************************
		 *  Select Invoice ID of a Specific Date ********
		 * *********************************************/
		function invoice_id_of_a_specific_date(  $start, $end )
		{
			$query = $this -> db -> select('invoice_id, invoice_doc, customer_name,grand_total,total_paid')
								 -> from('invoice_info,customer_info')
								 -> where('customer_info.customer_id = invoice_info.customer_id')
								 -> where('invoice_doc >= "'.$start.'"')
								 -> where('invoice_doc <= "'.$end.'"')
								 -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			return $query;
		}
		/************************************************
		 *  Select Sale Return ID of a Specific Date ********
		 * *********************************************/
		function sale_return_id_of_a_specific_date(  $start, $end )
		{
			$start = $start.' 00:00:00';
			$end = $end.' 59:59:59';
		
			$query = $this -> db -> select('invoice_info.invoice_id, invoice_doc, customer_name,grand_total,total_paid,sale_return_details.product_id,	return_quantity,exact_sale_price,return_amount,DOC,DOM,username,product_name')
								 -> from('product_info,users,sale_return_details')
								 -> where('sale_return_details.product_id = product_info.product_id')
								 -> where('sale_return_details.creator = users.id')
								 -> where('sale_return_details.DOC >= "'.$start.'"')
								 -> where('sale_return_details.DOC <= "'.$end.'"')
								 -> join('invoice_info','sale_return_details.invoice_id = invoice_info.invoice_id AND invoice_info.shop_id = "'.$this->tank_auth->get_shop_id().'"','left')
								 -> join('customer_info','customer_info.customer_id = invoice_info.customer_id','left')
								 -> get();
			return $query;
		}
		
		/************************************************
		 *  Select Sale Return ID of a Specific Invoice ********
		 * *********************************************/
		function sale_return_id_of_a_specific_invoice(  $invoice_id )
		{
			$query = $this -> db -> select('invoice_info.invoice_id, invoice_doc, customer_name,grand_total,total_paid,sale_return_details.product_id,	return_quantity,exact_sale_price,return_amount,DOC,DOM,username,product_name')
								 -> from('invoice_info,customer_info,product_info,users,sale_return_details')
								 -> where('customer_info.customer_id = invoice_info.customer_id')
								 -> where('sale_return_details.invoice_id = invoice_info.invoice_id')
								 -> where('sale_return_details.product_id = product_info.product_id')
								 -> where('sale_return_details.creator = users.id')
								 -> where('sale_return_details.invoice_id = "'.$invoice_id.'"')
								 -> where('invoice_info.shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			return $query;
		}
		
		/**************************************************
		 * Calculate Sale Price of a Specific date     **
		  * *********************************************/
		function todays_sale( $start, $end )
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "sale"')
								 -> where('transaction_info.date >= "'.$start.'"')
								 -> where('transaction_info.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$total_sale = $result -> amount;
			endforeach;
			return $total_sale;
		}
		function todays_delivery_charge( $start, $end )
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "delivery_charge"')
								 -> where('transaction_info.date >= "'.$start.'"')
								 -> where('transaction_info.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_delivery_charge = $result -> amount;
			endforeach;
			return $todays_delivery_charge;
		}
		function sale_return_info( $start, $end )
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "sale_return"')
								 -> where('transaction_info.date >= "'.$start.'"')
								 -> where('transaction_info.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$sale_return = $result -> amount;
			endforeach;
			return $sale_return;
		}
		function purchase_return_info( $start, $end )
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "purchase_return"')
								 -> where('transaction_info.date >= "'.$start.'"')
								 -> where('transaction_info.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$purchase_return = $result -> amount;
			endforeach;
			return $purchase_return;
		}
		function delivery_charge_info( $start, $end )
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "delivery_charge"')
								 -> where('transaction_info.date >= "'.$start.'"')
								 -> where('transaction_info.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$sale_return = $result -> amount;
			endforeach;
			return $sale_return;
		}
		function todays_grand( $start, $end )
		{
			$query = $this -> db -> select_sum('invoice_info.grand_total')
								 -> from('invoice_info')
								 -> where('invoice_info.invoice_doc >= "'.$start.'"')
								 -> where('invoice_info.invoice_doc <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$total_grand = $result -> grand_total;
			endforeach;
			return $total_grand;
		}
		function todays_paid( $start, $end )
		{
			$query = $this -> db -> select_sum('invoice_info.total_paid')
								 -> from('invoice_info')
								 -> where('invoice_info.invoice_doc >= "'.$start.'"')
								 -> where('invoice_info.invoice_doc <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$total_paid = $result -> total_paid;
			endforeach;
			return $total_paid;
		}
		function todays_invoice_return( $start, $end )
		{
			$query = $this -> db -> select_sum('invoice_info.return_money')
								 -> from('invoice_info')
								 -> where('invoice_info.invoice_doc >= "'.$start.'"')
								 -> where('invoice_info.invoice_doc <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$return_money = $result -> return_money;
			endforeach;
			return $return_money;
		}
		
		function todays_collection_in( $start, $end )
		{
			$query = $this -> db -> select_sum('cash_book.amount')
								 -> from('cash_book')
								 -> where('cash_book.transaction_type = "in"')
								 -> where('cash_book.date >= "'.$start.'"')
								 -> where('cash_book.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_collection_cash_in = $result -> amount;
			endforeach;
			return $todays_collection_cash_in;
		}
		function todays_collection_out( $start, $end )
		{
			$query2 = $this -> db -> select_sum('cash_book.amount')
								 -> from('cash_book')
								 -> where('cash_book.transaction_type = "out"')
								 -> where('cash_book.date >= "'.$start.'"')
								 -> where('cash_book.date <= "'.$end.'"')
								 -> get();
			foreach($query2 -> result() as $result):
					$todays_collection_cash_out = $result -> amount;
			endforeach;
			return $todays_collection_cash_out;
		}
		function todays_collection_cash( $start, $end )
		{
			/* $query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('(transaction_info.transaction_purpose = "collection" AND transaction_info.transaction_mode = "card") OR (transaction_info.transaction_purpose = "collection" AND transaction_info.transaction_mode = "cheque")')
								 -> where('transaction_info.date >= "'.$start.'"')
								 -> where('transaction_info.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_collection_cash = $result -> amount;
			endforeach;
			return $todays_collection_cash; */
			$query = $this -> db -> select_sum('cash_book.amount')
								 -> from('cash_book')
								 -> where('cash_book.transaction_type = "in"')
								 -> where('cash_book.date >= "'.$start.'"')
								 -> where('cash_book.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_collection_cash_in = $result -> amount;
			endforeach;
			$query2 = $this -> db -> select_sum('cash_book.amount')
								 -> from('cash_book')
								 -> where('cash_book.transaction_type = "out"')
								 -> where('cash_book.date >= "'.$start.'"')
								 -> where('cash_book.date <= "'.$end.'"')
								 -> get();
			foreach($query2 -> result() as $result):
					$todays_collection_cash_out = $result -> amount;
			endforeach;
			return $todays_collection_cash_in - $todays_collection_cash_out;
		}
		function todays_collection_bank( $start, $end )
		{
			/* $query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('(transaction_info.transaction_purpose = "collection" AND transaction_info.transaction_mode = "card") OR (transaction_info.transaction_purpose = "collection" AND transaction_info.transaction_mode = "cheque")')
								 -> where('transaction_info.date >= "'.$start.'"')
								 -> where('transaction_info.date <= "'.$end.'"')
								 -> get(); */
			$query = $this -> db -> select_sum('bank_book.amount')
								 -> from('bank_book')
								 -> where('bank_book.transaction_type = "in"')
								 -> where('bank_book.date >= "'.$start.'"')
								 -> where('bank_book.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_collection_bank_in = $result -> amount;
			endforeach;
			$query2 = $this -> db -> select_sum('bank_book.amount')
								 -> from('bank_book')
								 -> where('bank_book.transaction_type = "out"')
								 -> where('bank_book.date >= "'.$start.'"')
								 -> where('bank_book.date <= "'.$end.'"')
								 -> get();
			foreach($query2 -> result() as $result):
					$todays_collection_bank_out = $result -> amount;
			endforeach;
			return $todays_collection_bank_in - $todays_collection_bank_out;
		}
		function todays_credit_collection_cash( $start, $end )
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "credit_collection"')
								 -> where('transaction_info.transaction_mode = "cash"')
								 -> where('transaction_info.date >= "'.$start.'"')
								 -> where('transaction_info.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_credit_collection_cash = $result -> amount;
			endforeach;
			return $todays_credit_collection_cash;
		}
		function cash_credit_collection_opening($start)
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "credit_collection"')
								 -> where('transaction_info.transaction_mode = "cash"')
								 -> where('transaction_info.date < "'.$start.'"')
								 -> get();
			foreach($query -> result() as $result):
					$cash_credit_collection_opening = $result -> amount;
			endforeach;
			return $cash_credit_collection_opening;
		}
		function bank_credit_collection_opening( $start)
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info,bank_book')
								 -> where('(transaction_info.transaction_purpose = "credit_collection" AND transaction_info.transaction_mode = "card") OR (transaction_info.transaction_purpose = "credit_collection" AND transaction_info.transaction_mode = "cheque")')
								 -> where('bank_book.transaction_id = transaction_info.transaction_id')
								 -> where('bank_book.status = "active"')
								 -> where('bank_book.cheque_date <= "'.$start.'"')
								 -> get();
			foreach($query -> result() as $result):
					$bank_credit_collection_opening = $result -> amount;
			endforeach;
			return $bank_credit_collection_opening;
		}
		function todays_credit_collection_bank( $start, $end )
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info,bank_book')
								 -> where('(transaction_info.transaction_purpose = "credit_collection" AND transaction_info.transaction_mode = "card") OR (transaction_info.transaction_purpose = "credit_collection" AND transaction_info.transaction_mode = "cheque")')
								 -> where('bank_book.transaction_id = transaction_info.transaction_id')
								 -> where('bank_book.status = "active"')
								 -> where('bank_book.cheque_date >= "'.$start.'"')
								 -> where('bank_book.cheque_date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_credit_collection_bank = $result -> amount;
			endforeach;
			return $todays_credit_collection_bank;
		}
		function todays_purchase( $start, $end )
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "purchase"')
								 -> where('transaction_info.date >= "'.$start.'"')
								 -> where('transaction_info.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_purchase = $result -> amount;
			endforeach;
			return $todays_purchase;
		}
		function todays_purchase_payment_cash( $start, $end )
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "payment"')
								 -> where('transaction_info.transaction_mode = "cash"')
								 -> where('transaction_info.date >= "'.$start.'"')
								 -> where('transaction_info.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_purchase_payment_cash = $result -> amount;
			endforeach;
			return $todays_purchase_payment_cash;
		}
		function cash_purchase_payment_opening($start)
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "payment"')
								 -> where('transaction_info.transaction_mode = "cash"')
								 -> where('transaction_info.date <= "'.$start.'"')
								 -> get();
			foreach($query -> result() as $result):
					$cash_purchase_payment_opening = $result -> amount;
			endforeach;
			return $cash_purchase_payment_opening;
		}
		function bank_purchase_payment_opening($start)
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "payment"')
								 -> where('transaction_info.transaction_mode = "cheque"')
								 -> where('transaction_info.date <= "'.$start.'"')
								 -> get();
			foreach($query -> result() as $result):
					$bank_purchase_payment_opening = $result -> amount;
			endforeach;
			return $bank_purchase_payment_opening;
		}
		function todays_purchase_payment_bank( $start, $end )
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info,bank_book')
								 -> where('(transaction_info.transaction_purpose = "payment" AND transaction_info.transaction_mode = "card") OR (transaction_info.transaction_purpose = "payment" AND transaction_info.transaction_mode = "cheque")')
								 -> where('bank_book.transaction_id = transaction_info.transaction_id')
								 -> where('bank_book.status = "active"')
								 -> where('bank_book.cheque_date >= "'.$start.'"')
								 -> where('bank_book.cheque_date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_purchase_payment_bank = $result -> amount;
			endforeach;
			return $todays_purchase_payment_bank;
		}
		function todays_expense( $start, $end )
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "expense"')
								 -> where('transaction_info.date >= "'.$start.'"')
								 -> where('transaction_info.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_expense = $result -> amount;
			endforeach;
			return $todays_expense;
		}
		function todays_expense_payment_cash( $start, $end )
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "expense_payment"')
								 -> where('transaction_info.transaction_mode = "cash"')
								 -> where('transaction_info.date >= "'.$start.'"')
								 -> where('transaction_info.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_expense_payment_cash = $result -> amount;
			endforeach;
			return $todays_expense_payment_cash;
		}
		function cash_expense_payment_opening( $start)
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "expense_payment"')
								 -> where('transaction_info.transaction_mode = "cash"')
								 -> where('transaction_info.date <= "'.$start.'"')
								 -> get();
			foreach($query -> result() as $result):
					$cash_expense_payment_opening = $result -> amount;
			endforeach;
			return $cash_expense_payment_opening;
		}
		function bank_expense_payment_opening( $start)
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "expense_payment"')
								 -> where('transaction_info.transaction_mode = "cheque"')
								 -> where('transaction_info.date <= "'.$start.'"')
								 -> get();
			foreach($query -> result() as $result):
					$bank_expense_payment_opening = $result -> amount;
			endforeach;
			return $bank_expense_payment_opening;
		}
		function todays_expense_payment_bank( $start, $end )
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info,bank_book')
								 -> where('(transaction_info.transaction_purpose = "expense_payment" AND transaction_info.transaction_mode = "card") OR (transaction_info.transaction_purpose = "expense_payment" AND transaction_info.transaction_mode = "cheque")')
								 -> where('bank_book.transaction_id = transaction_info.transaction_id')
								 -> where('bank_book.status = "active"')
								 -> where('bank_book.cheque_date >= "'.$start.'"')
								 -> where('bank_book.cheque_date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_expense_payment_bank = $result -> amount;
			endforeach;
			return $todays_expense_payment_bank;
		}
		function todays_cash_book( $start, $end )
		{
			$query1 = $this -> db -> select_sum('cash_book.amount')
								 -> from('cash_book')
								 -> where('cash_book.transaction_type = "in"')
								 -> where('cash_book.date <=',$start)
								 -> get();
			foreach($query1 -> result() as $result):
					$todays_cash_book_in = $result -> amount;
			endforeach;
			$query2 = $this -> db -> select_sum('cash_book.amount')
								 -> from('cash_book')
								 -> where('cash_book.transaction_type = "out"')
								 -> where('cash_book.date <=',$start)
								 -> get();
			foreach($query2 -> result() as $result):
					$todays_cash_book_out = $result -> amount;
			endforeach;
			return $todays_cash_book = $todays_cash_book_in - $todays_cash_book_out;
		}
		function todays_cash_in( $start, $end )
		{
			$query1 = $this -> db -> select_sum('cash_book.amount')
								 -> from('cash_book')
								 -> where('cash_book.transaction_type = "in"')
								 -> get();
			foreach($query1 -> result() as $result):
					$todays_cash_book_in = $result -> amount;
			endforeach;
			return $todays_cash_book_in;
		}
		function todays_cash_out( $start, $end )
		{
			$query2 = $this -> db -> select_sum('cash_book.amount')
								 -> from('cash_book')
								 -> where('cash_book.transaction_type = "out"')
								 -> get();
			foreach($query2 -> result() as $result):
					$todays_cash_book_out = $result -> amount;
			endforeach;
			return $todays_cash_book_out;
		}
		function todays_bank_book( $start, $end )
		{
			$query1 = $this -> db -> select_sum('bank_book.amount')
								 -> from('bank_book')
								 -> where('bank_book.transaction_type = "in"')
								 -> where('bank_book.status = "active"')
								// -> where('bank_book.cheque_date >= "'.$start.'"')
								// -> where('bank_book.cheque_date <= "'.$end.'"')
								 -> get();
			foreach($query1 -> result() as $result):
					$todays_bank_book_in = $result -> amount;
			endforeach;

			$query2 = $this -> db -> select_sum('bank_book.amount')
								 -> from('bank_book')
								 -> where('bank_book.transaction_type = "out"')
								 -> where('bank_book.status = "active"')
								// -> where('bank_book.cheque_date >= "'.$start.'"')
								// -> where('bank_book.cheque_date <= "'.$end.'"')
								 -> get();
			foreach($query2 -> result() as $result):
					$todays_bank_book_out = $result -> amount;
			endforeach;
			return $todays_bank_book = $todays_bank_book_in - $todays_bank_book_out;
		}
		function todays_sale_return( $start, $end )
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "sale_return"')
								 //-> where('transaction_info.transaction_mode = "cash"')
								 -> where('transaction_info.date >= "'.$start.'"')
								 -> where('transaction_info.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_sale_return = $result -> amount;
			endforeach;
			return $todays_sale_return;
		}
		
		function total_sale_all()
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "sale"')
								 -> get();
			foreach($query -> result() as $result):
					$total_sale = $result -> amount;
			endforeach;

			return $total_sale;
		}
		function total_receivable_all()
		{
			$this->db->select_sum('transaction_info.amount');
			$this->db->from('transaction_info');			
			$this->db->where('(transaction_info.transaction_purpose = "collection" OR transaction_info.transaction_purpose = "credit_collection")');
			$query_data = $this->db->get();
			foreach($query_data -> result() as $result):
					$total_collection = $result -> amount;
			endforeach;
			
			return $total_collection ;
		}
		function total_purchase_all()
		{
			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "purchase"')
								 -> get();
			foreach($query -> result() as $result):
					$total_purchase = $result -> amount;
			endforeach;

			return $total_purchase;
		}
		function total_payment_all()
		{
			$this->db->select_sum('transaction_info.amount');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose = "payment"');
			$query_data = $this->db->get();
			foreach($query_data -> result() as $result):
					$total_payment = $result -> amount;
			endforeach;
			
			return $total_payment ;
		}
		/******************************************
		* Calculate Discount of Specific date      **
		* *****************************************/
		function specific_date_discount_calculation( $start, $end )
		{
			$query = $this -> db -> select_sum( 'discount' )
								 -> from('invoice_info')
								 -> where('invoice_doc >= "'.$start.'"')
								 -> where('invoice_doc <= "'.$end.'"')
								 -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			$total_dicount = 0;
			foreach($query -> result() as $result):
					$total_dicount = $result -> discount;
			endforeach;
			return $total_dicount;
		}
		/******************************************
		* Calculate Comission of Specific Month      **
		* *****************************************/
		function specific_date_comission_calculation( $start, $end )
		{
			$year = date('Y');
			$start = new \DateTime($start);
			$month1 = $start->format('m');
			
			$end = new \DateTime($end);
			$month2 = $end->format('m');
			$query = $this -> db -> select_sum( 'com_amount' )
								 -> from('commison_info')
								 -> where('com_year = "'.$year.'"')
								 -> where('com_month >= "'.$month1.'"')
								 -> where('com_month <= "'.$month2.'"')
								 -> get();
			$total_comission = 0;
			foreach($query -> result() as $result):
					$total_comission = $result -> com_amount;
			endforeach;
			return $total_comission;
		}
		function specific_date_cash_discount_calculation( $start, $end )
		{
			$query = $this -> db -> select_sum( 'discount_amount' )
								 -> from('invoice_info')
								 -> where('invoice_doc >= "'.$start.'"')
								 -> where('invoice_doc <= "'.$end.'"')
								 -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			$total_dicount = 0;
			foreach($query -> result() as $result):
					$total_dicount = $result -> discount_amount;
			endforeach;
			return $total_dicount;
		}

		

	    /***********************************************************
		**************Fatch All Purchase Receipt ID*****************
		************************************************************/
	    function all_purchase_receipt()
		{
			$this->db->order_by("receipt_id", "desc");
			$query = $this -> db -> select('receipt_id, distributor_name,distributor_info.distributor_id')
								 -> from('purchase_receipt_info, distributor_info')
								 -> where('purchase_receipt_info.distributor_id = distributor_info.distributor_id')
								 -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			return $query;
		}
			
		/************************************************
		 *  Select Purchase Receipt ID of a Specific Date*
		 * **********************************************/
		function purchase_id_of_a_specific_date(  $start, $end )
		{
			$this -> db -> order_by("receipt_id", "asc");
			$query = $this -> db -> select('receipt_id, distributor_name, receipt_date,
											total_paid, receipt_creator, grand_total')
								 -> from('purchase_receipt_info, distributor_info')
								 -> where('receipt_date >= "'.$start.'"')
								 -> where('receipt_date <= "'.$end.'"')
								 -> where('purchase_receipt_info.distributor_id = distributor_info.distributor_id')
								 -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			return $query;
		}
			
		/*************************************************
		  *  General Details OF a Purchase Receipt                  *
		  * ***********************************************/
		function specific_purchase_receipt_general($receipt_id)
		{
			$query = $this->db->select('receipt_id, purchase_receipt_info.distributor_id, grand_total,grand_total2, purchase_amount, receipt_creator, receipt_status, total_paid ,receipt_date ,
											distributor_name, user_full_name, username, transport_cost, gift_on_purchase,SUM(purchase_quantity * unit_buy_price) as total_listing')
			->from('purchase_receipt_info,purchase_info, distributor_info, users')
			->where('receipt_id = "'.$receipt_id.'"')
			->where('purchase_receipt_info.receipt_id = purchase_info.purchase_receipt_id')
			->where('purchase_receipt_info.distributor_id = distributor_info.distributor_id')
			->where('purchase_receipt_info.receipt_creator = users.id')
			->where('purchase_receipt_info.shop_id', $this->tank_auth->get_shop_id())
			->get();

			return $query;

		}
		
		public function get_total_purchase_amount($purchase_receipt_id)
		{
			$this->db->select('SUM(purchase_quantity * unit_buy_price) as total_purchase_amount')
			->from('purchase_info')
			->where('purchase_receipt_id', $purchase_receipt_id);
			$query = $this->db->get()->row();

			return $query->total_purchase_amount;
		}

		/*************************************************
		*  Details of A Specific Purchase Receipt   *
		* ***********************************************/
		function specific_purchase_receipt( $receipt_id)
		{
		$this -> db -> order_by("purchase_id", "asc");
		$query = $this -> db -> select('product_name, purchase_info.product_id,product_info.product_specification, purchase_quantity AS number_of_quantity,purchase_id, unit_buy_price, purchase_expire_date')
							 -> from('purchase_info,product_info,purchase_receipt_info')
							 -> where('purchase_receipt_id = "'.$receipt_id.'"')
							 -> where('purchase_info.product_id = product_info.product_id')
							 -> where('purchase_info.purchase_receipt_id = purchase_receipt_info.receipt_id')
							 -> where('shop_id', $this->tank_auth->get_shop_id())
							 //-> group_by('product_info.product_id')
							 -> get();
		return $query;
		}
			  
		
		/***********************************
		 * Date wise Financial Statement *
		 * ********************************/
		function date_wise_financial_statement_calculation( $start ,  $end)
		{
			/* $query = $this -> db -> query("SELECT DISTINCT transaction_details.transaction_id,transaction_details.transaction_type,transaction_ref_details.ref_id,
											transaction_details.transaction_amount, transaction_details.transaction_mode, 
											transaction_ref_details.transaction_purpose,transaction_details.transaction_doc	
											
											FROM transaction_details,transaction_ref_details

											WHERE transaction_details.transaction_doc >= '".$start."' AND transaction_details.transaction_doc <= '".$end."'
											AND transaction_details.transaction_mode = 'cash'
											AND transaction_details.transaction_amount <> 0
											AND transaction_details.transaction_reference_id = transaction_ref_details.transaction_ref_details_id
											AND transaction_details.transaction_type = transaction_ref_details.transaction_type
										");
										
			$query2= $this -> db -> query("SELECT DISTINCT transaction_details.transaction_id,transaction_details.transaction_type,
											transaction_details.transaction_amount, transaction_details.transaction_mode, 
											cheque_reference_info.cheque_ref_purpose,transaction_details.transaction_doc,cheque_reference_info.ref_id	
											
											FROM cheque_reference_info,transaction_details,cheque_info

											WHERE transaction_details.transaction_doc >= '".$start."' AND transaction_details.transaction_doc <= '".$end."'
											AND transaction_details.transaction_mode = 'cheque'
											AND transaction_details.transaction_amount <> 0
											AND transaction_details.transaction_reference_id = cheque_reference_info.cheque_ref_id
											AND cheque_reference_info.cheque_id = cheque_info.cheque_id
											AND cheque_info.cheque_status = 'honored'
											AND transaction_details.transaction_type = cheque_reference_info.transaction_type	
										"); */
										
			$query = $this -> db -> query("SELECT transaction_info.transaction_id,transaction_info.transaction_purpose,
											transaction_info.amount, transaction_info.transaction_mode,transaction_info.doc	

											FROM transaction_info

											WHERE transaction_info.doc >= '".$start."' AND transaction_info.doc <= '".$end."'
											AND transaction_info.transaction_mode = 'cash'
											AND transaction_info.amount <> 0
										");
										
			$query2= $this -> db -> query("SELECT transaction_info.transaction_id,transaction_info.transaction_purpose,
											transaction_info.amount, transaction_info.transaction_mode,transaction_info.doc	

											FROM transaction_info

											WHERE transaction_info.doc >= '".$start."' AND transaction_info.doc <= '".$end."'
											AND transaction_info.transaction_mode = 'cheque'
											AND transaction_info.amount <> 0
										");
								
			$query3 = array(
				'cash' => $query,
				'cheque' => $query2
			);						
													
			return $query3;
			
		}
		/*  payable_financial_statement */
		function payable_receivable_financial_statement( $start ,  $end)
		{	
			/*$query2= $this -> db -> select(' SUM(expense_amount) AS grand_total,SUM(total_paid) AS total_paid')
								 -> from('expense_info')
								 -> where('total_paid < expense_amount ')
								 //-> where('expense_type !=  "Transport Cost For Purchase" ')
								 -> where('expense_doc >= "'.$start.'"')
								 -> where('expense_doc <= "'.$end.'"')
								 -> get();*/
			/*$query_5= $this -> db -> select('SUM(expense_amount) AS grand_total')
								 -> from('expense_info')
								 -> where('expense_doc >= "'.$start.'"')
								 -> where('expense_doc <= "'.$end.'"')
								 -> get();
								 */
			/*$query_7 = $this -> db -> select('SUM(expense_amount) AS grand_total')
								 -> from('expense_info')
								 -> where('expense_type =  "Transport Cost For Purchase" ')
								 -> where('expense_doc >= "'.$start.'"')
								 -> where('expense_doc <= "'.$end.'"')
								 -> get();		
								 */							 													 
			/*$query = $this -> db -> select('SUM(purchase_receipt_info.grand_total) AS grand_total,SUM(purchase_receipt_info.total_paid) AS total_paid')
								 -> from('purchase_receipt_info')
								 -> where('purchase_receipt_info.receipt_status = "unpaid" ')
								 -> where('receipt_doc >= "'.$start.'"')
								 -> where('receipt_doc <= "'.$end.'"')
								 -> get();							 
			$query_6 = $this -> db -> select('SUM(purchase_receipt_info.grand_total) AS grand_total')
								   -> from('purchase_receipt_info')
								   -> where('receipt_doc >= "'.$start.'"')
								   -> where('receipt_doc <= "'.$end.'"')
								   -> get();	
								   		
			$query_4 = $this -> db -> select('SUM(gift_amount) AS grand_total,SUM(total_paid) AS total_paid')
								   -> from('gift_details')	
								   -> where('total_paid < gift_amount ')	
								   -> where('gift_doc >= "'.$start.'"')
								   -> where('gift_doc <= "'.$end.'"')
								   -> get();					 
				 					 			 
			$query_8 = $this -> db -> select('SUM(gift_amount) AS grand_total')
								   -> from('gift_details')	
								   -> where('gift_doc >= "'.$start.'"')
								   -> where('gift_doc <= "'.$end.'"')
								   -> get();					
								
			*/					   
					   	
			/*$query_3 = $this -> db -> select('SUM(grand_total) AS grand_total,SUM(total_paid) AS total_paid')
								   -> from('cashmemo_info')
								   -> where('total_paid < grand_total ')
								   -> where('cashmemo_info_doc >= "'.$start.'"')
								   -> where('cashmemo_info_doc <= "'.$end.'"')
								   -> get();	
			*/
			
			$query_3 = $this -> db -> select('SUM(grand_total) AS grand_total,SUM(total_paid) AS total_paid')
								   -> from('invoice_info')
								   -> where('total_paid < grand_total ')
								   -> where('invoice_doc >= "'.$start.'"')
								   -> where('invoice_doc <= "'.$end.'"')
								   -> get();


			$query_12= $this -> db -> select('SUM(transaction_info.amount) AS total_investment')
								   -> from('transaction_info')
								   -> where('transaction_info.transaction_purpose ="investment"')
								   -> get();
								   					   						   				 		//~ 
			/* $query_12= $this -> db ->  query("
												SELECT  temp_one.transaction_id,temp_one.transaction_doc,
												SUM(temp_one.transaction_amount) AS total_investment

												FROM 

												(
												SELECT 	transaction_details.transaction_id,transaction_doc,
												transaction_details.transaction_amount AS transaction_amount,transaction_mode,
												transaction_details.transaction_creator

												FROM transaction_details,cheque_reference_info,cheque_info
												WHERE cheque_reference_info.cheque_ref_purpose = 'investment'
												AND transaction_details.transaction_reference_id = cheque_reference_info.cheque_ref_id
												AND cheque_reference_info.cheque_id = cheque_info.cheque_id
												AND transaction_details.transaction_amount <> 0
												AND transaction_details.transaction_doc >=  '".$start."'
												AND transaction_details.transaction_doc <=  '".$end."'
														


												UNION 

												SELECT transaction_details.transaction_id,transaction_doc,
												transaction_details.transaction_amount AS transaction_amount,transaction_mode,
												transaction_details.transaction_creator

												FROM transaction_ref_details,transaction_details
												WHERE  transaction_ref_details.transaction_purpose = 'investment'
												AND transaction_details.transaction_amount <> 0
												AND transaction_details.transaction_reference_id = transaction_ref_details.transaction_ref_details_id
												AND transaction_details.transaction_doc >=  '".$start."'
												AND transaction_details.transaction_doc <=  '".$end."'
		

												) AS temp_one
												
											");  */
								   					   						   				 		
			$query_9 = $this -> db -> query("SELECT SUM( expense_info.expense_amount) AS total_expense_amount,
													SUM( CASE WHEN expense_type = 'Transport Cost For Purchase' THEN expense_amount END ) AS transport_cost, 
													SUM( CASE WHEN expense_type = 'Withdrawal' THEN expense_amount END ) AS total_withdrawal,
													SUM(CASE WHEN total_paid < expense_amount THEN expense_amount  END ) AS unpaid_grand_total,
													SUM(CASE WHEN total_paid < expense_amount THEN total_paid END ) AS total_paid_amount
												FROM expense_info
												WHERE expense_doc >= '".$start."'
												AND expense_doc <= '".$end."'
										    ");	
			$query_10 = $this -> db -> query("SELECT SUM(purchase_receipt_info.grand_total) AS total_purchase_amount,
													SUM( CASE WHEN purchase_receipt_info.receipt_status = 'unpaid'  THEN total_paid END ) AS total_paid_amount, 
													SUM( CASE WHEN purchase_receipt_info.receipt_status = 'unpaid'  THEN grand_total END ) AS unpaid_grand_total										
												FROM purchase_receipt_info
												WHERE receipt_date >= '".$start."'
												AND receipt_date <= '".$end."'
										    ");	
			$query_100 = $this -> db -> query("SELECT SUM(purchase_receipt_info.transport_cost) AS total_transport_amount,
													SUM( CASE WHEN purchase_receipt_info.receipt_status = 'unpaid'  THEN total_paid END ) AS total_paid_amount, 
													SUM( CASE WHEN purchase_receipt_info.receipt_status = 'unpaid'  THEN grand_total END ) AS unpaid_grand_total										
												FROM purchase_receipt_info
												WHERE receipt_date >= '".$start."'
												AND receipt_date <= '".$end."'
										    ");	 
			$query_11 = $this -> db -> query("SELECT SUM(gift_amount) AS total_gift_amount,
													SUM( CASE WHEN total_paid < gift_amount THEN gift_amount END ) - 
													SUM( CASE WHEN total_paid < gift_amount THEN total_paid END ) AS unpaid_gift_amount								
												FROM gift_details
												WHERE gift_doc >= '".$start."'
												AND gift_doc <= '".$end."'
										    ");	


			$query_13 = $this -> db -> query("SELECT SUM(loan_amount) AS total_loan_amount,
												    SUM( CASE WHEN (loan_mode = 1) THEN (total_paid) ELSE 0 END ) as payable_loan, 
												    SUM( CASE WHEN (loan_mode = 2) THEN (total_paid)  ELSE 0 END ) as receivable_loan 

												FROM loan_details_info

												WHERE doc >= '".$start."'
												AND doc <= '".$end."'
										    ");	


										    
										    		 						 
			$query_final = array(
				'sale' => $query_3,
				'updated_expense' => $query_9,
				'updated_purchase' => $query_10,
				'updated_transport' => $query_100,
				'updated_gift' => $query_11,
				'investment' => $query_12,
				'loan_details' => $query_13
								
				//'gift' => $query_4,
				//'gift_total_amount' => $query_8,
				//'purchase_total_amount' => $query_6,
				//'purchase' => $query,
				//'expense' => $query2,
				//'expense_total_amount' => $query_5,
				//'purchase_total_amount_for_transport' => $query_7,
			);						
			return $query_final;							 
		}
		
		/*********************
		*All Expenses*
		**********************/
		function expense_financial_statement( $start ,  $end)
		{	
					   					   						   				 		
			$query_99 = $this -> db -> query("SELECT SUM(expense_info.expense_amount) AS total_expense_amount_electric	
												FROM expense_info
												WHERE expense_type = '1' AND expense_doc >= '".$start."' AND expense_doc <= '".$end."'
										    ");	
			$query_100 = $this -> db -> query("SELECT SUM(expense_info.expense_amount) AS total_expense_amount_salary	
												FROM expense_info
												WHERE expense_type = '8' AND expense_doc >= '".$start."' AND expense_doc <= '".$end."'
										    ");	
			$query_110 = $this -> db -> query("SELECT SUM(expense_info.expense_amount) AS total_expense_amount_house_rent	
												FROM expense_info
												WHERE expense_type = '6' AND expense_doc >= '".$start."' AND expense_doc <= '".$end."'
										    ");	
			$query_120 = $this -> db -> query("SELECT SUM(expense_info.expense_amount) AS total_expense_amount_internet	
												FROM expense_info
												WHERE expense_type = '9' AND expense_doc >= '".$start."' AND expense_doc <= '".$end."'
										    ");
			$query_130 = $this -> db -> query("SELECT SUM(expense_info.expense_amount) AS total_expense_amount_others	
												FROM expense_info
												
												WHERE expense_doc >= '".$start."' 
												AND expense_doc <= '".$end."'
												AND	expense_type != '1' 
												AND expense_type != '8'
												AND expense_type != '6'
												AND expense_type != '9' 
												AND expense_type != '10' 
										    ");					    
										    		 						 
			$query_final = array(
				//'sale' => $query_3,
				'updated_expense_electric' => $query_99,
				'updated_expense_salary' => $query_100,
				'updated_expense_house_rent' => $query_110,
				'updated_expense_internet' => $query_120,
				'updated_expense_other' => $query_130,
				//'updated_gift' => $query_11,
				//'investment' => $query_12,
				//'loan_details' => $query_13
								
				//'gift' => $query_4,
				//'gift_total_amount' => $query_8,
				//'purchase_total_amount' => $query_6,
				//'purchase' => $query,
				//'expense' => $query2,
				//'expense_total_amount' => $query_5,
				//'purchase_total_amount_for_transport' => $query_7,
			);						
			return $query_final;							 
		}
		
		function get_other_expense_details($start_date,$end_date){

			$this->db->select('expense_amount,expense_type,expense_doc,type_info.*');
			$this->db->from('expense_info,type_info');
			$this->db->where('expense_info.expense_type=type_info.type_id');
			$this->db->where('expense_info.expense_type != "1"');
			$this->db->where('expense_info.expense_type != "8"');
			$this->db->where('expense_info.expense_type != "6"');
			$this->db->where('expense_info.expense_type != "9"');
			$this->db->where('expense_info.expense_type != "10"');
			if($start_date!=''){$this->db->where('expense_info.expense_doc >= "'.$start_date.'"');}
			if($end_date!=''){$this->db->where('expense_info.expense_doc <= "'.$end_date.'"');}
			$query1 = $this->db->get();
					
			return $query1;
		}
		
		/****************************
		 * All Registered Customer  *
		 ****************************/
		function all_registerd_customer()
		{
			$query =  $this -> db -> order_by("customer_name", "asc")
								  -> select('*')
								  -> from('customer_info')
								  -> where('customer_mode = "registered"')
								  -> get();
			return $query;
		}
		function all_type_customer()
		{
			$query =  $this -> db -> order_by("customer_name", "asc")
								  -> select('*')
								  -> from('customer_info')
								  -> get();
			return $query;
		}
		function total_point_discount_datewise($start_date  ,  $end_date)
		{
		$endd=explode('-',$end_date);
		$dd=$endd[2]+1;
		$end_date=$endd[0].'-'.$endd[1].'-'.$dd;
		
					$query = $this -> db -> select_sum('point_discount')
								  -> from('invoice_info')
								  -> where('invoice_info.invoice_dom >= "'.$start_date.'"')
								  -> where('invoice_info.invoice_dom <= "'.$end_date.'"')
								  -> get();
					if($query->num_rows>0){
					$row=$query->row_array();
					return $row;
					}
					else {
					$row['point_discount']=0;
					return $row;
					}
			
		}
		
		/************************************
		 * All Distributor ******************
		 * **********************************/
		function distributor_info()
		{
			$this -> db -> order_by("distributor_name", "asc");
			return $this -> db -> get('distributor_info');
		}
		
		/******************************************
		 *  All Supply By a Specific Distributor  *
		 ******************************************/
		function supply_by_distributor( $distributor_id )
		{
			$this -> db -> order_by("product_name", "asc");
		    $query = $this -> db -> select('product_info.product_id, product_info.product_name, distributor_name,distributor_info.distributor_id,
											distributor_address, distributor_contact_no,
											bulk_stock_info.stock_amount, sale_price_info.unit_sale_price, bulk_stock_info.bulk_unit_buy_price')
								 -> from('product_info, bulk_stock_info, sale_price_info, purchase_info,purchase_receipt_info, distributor_info')
								 -> where('distributor_info.distributor_id = "'.$distributor_id.'"')
								 -> where('product_info.product_id = bulk_stock_info.product_id')
								 -> where('product_info.product_id = sale_price_info.product_id')
								 -> where('product_info.product_id = purchase_info.product_id')
								 -> where('purchase_info.purchase_receipt_id = purchase_receipt_info.receipt_id')
								 -> where('distributor_info.distributor_id = purchase_receipt_info.distributor_id')
								 -> group_by('product_info.product_id')
								 -> get();
			 return $query;
		}
		/******************************************
		 *  Invoice of a Specific Product         *
		 ******************************************/
		function invoice_of_specific_product( $product_id, $start_date, $end_date, $is_individual )
		{
			$this -> db -> order_by("invoice_doc","asc");
			if(!$is_individual)
			{
				$this -> db -> select('customer_name, invoice_doc,customer_contact_no, invoice_info.invoice_id,
								       sale_quantity as number_of_quantity');
				$this -> db -> from('invoice_info,sale_details,customer_info');
				$this -> db -> where('customer_info.customer_id = invoice_info.customer_id');
				$this -> db -> where('invoice_info.invoice_id = sale_details.invoice_id');
				$this -> db -> where('invoice_doc >= "'.$start_date.'"');
				$this -> db -> where('invoice_doc <= "'.$end_date.'"');
				$this -> db -> where('sale_details.product_id = "'.$product_id.'"');
				$this -> db -> where('invoice_info.shop_id', $this -> shop_id);
				$this -> db -> where('sale_details.product_specification = "bulk"');
				$this -> db -> group_by('invoice_id');
				$query = $this -> db -> get();
				return $query;
			}
			else if( $is_individual)
			{
				$this -> db -> select('customer_name, invoice_doc,customer_contact_no, invoice_info.invoice_id,
								       count( sale_details.stock_id ) as number_of_quantity');
				$this -> db -> from('product_info, purchase_info, stock_info, sale_details,invoice_info,customer_info');
				$this -> db -> where('invoice_info.invoice_id = sale_details.invoice_id');
				$this -> db -> where('customer_info.customer_id = invoice_info.customer_id');
				$this -> db -> where('stock_info.stock_id = sale_details.stock_id');
				$this -> db -> where('stock_info.purchase_id = purchase_info.purchase_id');
				$this -> db -> where('product_info.product_id = purchase_info.product_id');
				$this -> db -> where('invoice_doc >= "'.$start_date.'"');
				$this -> db -> where('invoice_doc <= "'.$end_date.'"');
				$this -> db -> where('invoice_info.shop_id', $this -> shop_id);
				$this -> db -> where('product_info.product_id = "'.$product_id.'"');
				$this -> db -> where('sale_details.product_specification = "individual"');
				$this -> db -> group_by('invoice_id');
				$query = $this -> db -> get();
				return $query;
			}
			
		/* 	if(!$is_individual)
			{
				$this -> db -> select('customer_name, invoice_doc,customer_contact_no, invoice_info.invoice_id,
								       sum(sale_quantity) as number_of_quantity,sum(exact_sale_price) as tot_sale,product_name');
				$this -> db -> from('invoice_info,sale_details,customer_info,product_info');
				$this -> db -> where('customer_info.customer_id = invoice_info.customer_id');
				$this -> db -> where('invoice_info.invoice_id = sale_details.invoice_id');
				$this -> db -> where('product_info.product_id = sale_details.product_id');
				$this -> db -> where('invoice_doc >= "'.$start_date.'"');
				$this -> db -> where('invoice_doc <= "'.$end_date.'"');
				//$this -> db -> where('sale_details.product_id = "'.$product_id.'"');
				$this -> db -> where('invoice_info.shop_id', $this -> shop_id);
				$this -> db -> where('sale_details.product_specification = "bulk"');
				$this -> db -> group_by('sale_details.product_id');
				$query = $this -> db -> get();
				return $query;
			} */
			
			
		}
		/******************************
		 * Cash in bank ,, Cash in hand 
		 * ****************************/
		function cash_status_report_result_calculation($start_date,$end_date)
		{
			
								 
			$query = $this -> db -> query("SELECT bank_book_info.bank_id,bank_info.bank_name,SUM(bank_book_info.amount) AS total_amount
												FROM bank_book_info,bank_info
												WHERE bank_info.bank_id = bank_book_info.bank_id 
												AND (transaction_type = 'ToBank' 
												OR transaction_type = 'in')
												AND  bank_book_doc >= '".$start_date."' 
												AND bank_book_doc <= '".$end_date."'
										");					 			
			$query_2 = $this -> db -> query("SELECT bank_book_info.bank_id,bank_info.bank_name,SUM(bank_book_info.amount) AS total_amount
												FROM bank_book_info,bank_info
												WHERE bank_info.bank_id = bank_book_info.bank_id 
												AND (transaction_type = 'FromBank' 
												OR transaction_type = 'out')
												AND  bank_book_doc >= '".$start_date."' 
												AND bank_book_doc <= '".$end_date."'
											");								 
		
			$query_7 = $this -> db -> query("SELECT bank_book_info.bank_id, bank_info.bank_name,
												SUM( CASE WHEN transaction_type = 'ToBank' || transaction_type = 'in' THEN amount END ) AS total_in, 
												SUM(CASE WHEN transaction_type = 'FromBank' || transaction_type = 'out' THEN amount END ) AS total_out, 
												SUM(CASE WHEN transaction_type = 'ToBank' || transaction_type = 'in' THEN amount END ) - 
												SUM(CASE WHEN transaction_type = 'FromBank' || transaction_type = 'out' THEN amount END ) AS total_amount
											FROM bank_info, bank_book_info
											WHERE bank_book_info.bank_id = bank_info.bank_id
											AND  bank_book_doc >= '".$start_date."' 
											AND bank_book_doc <= '".$end_date."'
											GROUP BY bank_book_info.bank_id
										    ");
										    
			$query_8 = $this -> db -> query("SELECT bank_book_info.bank_id, bank_info.bank_name,
												SUM( CASE WHEN transaction_type = 'ToBank' || transaction_type = 'in' THEN amount END ) AS total_in, 
												SUM(CASE WHEN transaction_type = 'FromBank' || transaction_type = 'out' THEN amount END ) AS total_out, 
												SUM(CASE WHEN transaction_type = 'ToBank' || transaction_type = 'in' THEN amount END ) - 
												SUM(CASE WHEN transaction_type = 'FromBank' || transaction_type = 'out' THEN amount END ) AS total_amount
												FROM bank_info, bank_book_info
												WHERE bank_book_info.bank_id = bank_info.bank_id
												AND  bank_book_doc >= '".$start_date."' 
												AND bank_book_doc <= '".$end_date."'
											");	
											
													
			$query_9 = $this -> db -> query("
											SELECT DISTINCT transaction_details.transaction_id,transaction_details.transaction_type, transaction_details.transaction_mode, 
											transaction_details.transaction_doc,
											SUM( CASE WHEN (transaction_type = 'in' OR transaction_type = 'FromBank' ) THEN transaction_amount END ) AS total_in,
											SUM( CASE WHEN (transaction_type = 'out' OR transaction_type = 'ToBank' ) THEN transaction_amount END ) AS total_out
											
											FROM transaction_details
											WHERE transaction_details.transaction_mode = 'cash' 
											AND transaction_details.transaction_doc >= '".$start_date."' 
											AND transaction_details.transaction_doc <= '".$end_date."'
										");								
															    
	 
			$query_final = array(
				'InBank' => $query,
				'InBank_2' => $query_2,
				//'cash' => $query_3,
				//'cheque' => $query_4,
				//'extra_cash_in_purpose' => $query_5,
				//'extra_cash_out_purpose' => $query_6,
				'details_by_bank' => $query_7,
				'cash_in_bank' => $query_8,
				'total_in_out_cash_status' => $query_9
			);						
			return $query_final;	
		}
		/*transaction details by specific transaction id*/
		function specific_transaction_details($transaction_id)
		{
			$seg_3 = $this -> uri -> segment(3);
			$seg_4 = $this -> uri -> segment(4);
			$seg_5 = $this -> uri -> segment(5);
			$seg_6 = $this -> uri -> segment(6);
			$query = 0;$query_2 = 0;$query_3 = 0;			
			if($seg_3 == 'Cheque_Dishonor')
			{
				if($seg_6 == 'cash')
				{
					$seg_7 = $this -> uri -> segment(7);
					/*$query = $this -> db -> query("SELECT DISTINCT transaction_details.transaction_id,cheque_reference_info.cheque_id, cheque_reference_info.cheque_ref_purpose,
														cheque_reference_info.transaction_amount,cheque_reference_info.cheque_ref_doc
													FROM cheque_reference_info,transaction_ref_details,cheque_info,transaction_details
													WHERE cheque_info.cheque_status = 'dishonored'
													AND transaction_ref_details.transaction_purpose = 'Cheque_Dishonor' 
													AND transaction_ref_details.ref_id = cheque_reference_info.cheque_id
													AND transaction_details.transaction_reference_id = transaction_ref_details.transaction_ref_details_id
													AND transaction_details.transaction_id = '".$transaction_id."'
											");*/
											
					$query = $this -> db -> query("SELECT DISTINCT transaction_details.transaction_id,cheque_info.cheque_no, transaction_ref_details.transaction_purpose,
															transaction_details.transaction_amount,transaction_details.transaction_doc,transaction_details.transaction_mode,
															transaction_details.transaction_type
													FROM transaction_ref_details,cheque_info,transaction_details
													WHERE transaction_ref_details.ref_id = '".$seg_7."'
													AND transaction_details.transaction_id =  '".$transaction_id."'
													AND transaction_details.transaction_reference_id = transaction_ref_details.transaction_ref_details_id
													AND transaction_ref_details.transaction_purpose = 'Cheque_Dishonor'
													AND transaction_ref_details.ref_id = cheque_info.cheque_id
													AND transaction_details.shop_id = '".$this->tank_auth->get_shop_id()."'
												");
				}
				else if($seg_6 == 'cheque')
				{
					$seg_7 = $this -> uri -> segment(7);
					/*$query = $this -> db -> query("SELECT DISTINCT transaction_details.transaction_id,cheque_reference_info.cheque_id, 
													cheque_reference_info.cheque_ref_purpose,cheque_reference_info.transaction_amount,
													cheque_reference_info.cheque_ref_doc
													FROM cheque_reference_info,cheque_info,transaction_details
													WHERE cheque_info.cheque_status = 'dishonored'
													AND cheque_reference_info.cheque_id = '".$seg_7."'
													AND transaction_details.transaction_id =  '".$transaction_id."'
											");*/
											
					$query = $this -> db -> query("SELECT  
													transaction_details.transaction_id,cheque_reference_info.transaction_type,cheque_reference_info.cheque_ref_purpose AS transaction_purpose,
													cheque_reference_info.transaction_amount,transaction_details.transaction_doc,transaction_details.transaction_mode,
													(SELECT cheque_no FROM cheque_info
													 WHERE cheque_id = (SELECT DISTINCT cheque_reference_info.cheque_id												
																			FROM cheque_reference_info,cheque_info,transaction_details
																			WHERE  cheque_reference_info.ref_id = '".$seg_7."'
																			AND transaction_details.transaction_id = '".$transaction_id."'
																			AND transaction_details.shop_id = '".$this->tank_auth->get_shop_id()."'
																			AND  transaction_details.transaction_reference_id = cheque_reference_info.cheque_ref_id)) AS normal_cheque_no,
													(SELECT  cheque_no FROM cheque_info 
													 WHERE cheque_id = (SELECT DISTINCT cheque_reference_info.ref_id												
																			FROM cheque_reference_info,cheque_info,transaction_details
																			WHERE  cheque_reference_info.ref_id = '".$seg_7."'
																			AND transaction_details.transaction_id = '".$transaction_id."'
																			AND transaction_details.shop_id = '".$this->tank_auth->get_shop_id()."'
																			AND  transaction_details.transaction_reference_id = cheque_reference_info.cheque_ref_id)) AS dishonored_cheque_no
													FROM cheque_reference_info,cheque_info,transaction_details
													WHERE  cheque_reference_info.ref_id =  '".$seg_7."'
													AND transaction_details.transaction_id = '".$transaction_id."'
													AND transaction_details.shop_id = '".$this->tank_auth->get_shop_id()."'
													AND  transaction_details.transaction_reference_id = cheque_reference_info.cheque_ref_id
													AND cheque_info.cheque_id = cheque_reference_info.cheque_id
												");						
				}					
			}
			if($seg_6 == 'cash' && $seg_3 != 'Cheque_Dishonor')
			{
			$query_2 = $this -> db -> query("SELECT DISTINCT transaction_details.transaction_id,transaction_details.transaction_type,transaction_ref_details.ref_id,
											transaction_details.transaction_amount, transaction_details.transaction_mode, 
											transaction_ref_details.transaction_purpose,transaction_details.transaction_doc	
											
											FROM transaction_details,transaction_ref_details

											WHERE transaction_details.transaction_mode = 'cash'
											AND transaction_details.transaction_reference_id = transaction_ref_details.transaction_ref_details_id
											AND transaction_details.transaction_type = transaction_ref_details.transaction_type
											AND transaction_details.transaction_id = '".$transaction_id."'
											AND transaction_details.shop_id = '".$this->tank_auth->get_shop_id()."'
										");
			}
			if($seg_6 == 'cheque' && $seg_3 != 'Cheque_Dishonor')
			{
			$query_3 = $this -> db -> query("SELECT DISTINCT transaction_details.transaction_id,transaction_details.transaction_type,
											transaction_details.transaction_amount, transaction_details.transaction_mode, 
											cheque_reference_info.cheque_ref_purpose,transaction_details.transaction_doc	
											
											FROM cheque_reference_info,transaction_details,cheque_info

											WHERE transaction_details.transaction_mode = 'cheque'
											
											AND transaction_details.transaction_reference_id = cheque_reference_info.cheque_ref_id
											AND cheque_reference_info.cheque_id = cheque_info.cheque_id
											AND cheque_info.cheque_status = 'honored'
											AND transaction_details.transaction_type = cheque_reference_info.transaction_type	
											AND transaction_details.transaction_id = '".$transaction_id."'
											AND transaction_details.shop_id = '".$this->tank_auth->get_shop_id()."'
										");
			}
			
			$query_final = array(
				'Cheque_Dishonor' => $query,
				'cash' => $query_2,
				'cheque' => $query_3
			);						
			return $query_final;
		}
		/* get_transaction_details_by_purpose */
		function get_transaction_details_by_purpose($ref_id,$purpose)
		{
			$query = 0;$query_2 = 0;$query_3 = 0;$query_4 = 0;
			if($purpose == 'sale' || $purpose == 'Cheque_Dishonor' )
			{
				$query = $this -> db -> query("SELECT DISTINCT customer_name,customer_contact_no
											  FROM invoice_info,transaction_ref_details,transaction_details, customer_info
											  WHERE invoice_info.invoice_id = transaction_ref_details.ref_id
											  AND invoice_info.customer_id = customer_info.customer_id
											  AND invoice_info.invoice_id = '".$ref_id."'
											  AND invoice_info.shop_id = '".$this->tank_auth->get_shop_id()."'
											");
				
			}
			if($purpose == 'expense' || $purpose == 'Cheque_Dishonor' )
			{
				$query_2 = $this -> db -> query("SELECT DISTINCT service_provider_info.service_provider_name
											    FROM service_provider_info,transaction_ref_details,transaction_details,expense_info
												WHERE expense_info.expense_id = transaction_ref_details.ref_id
												AND expense_info.service_provider_id = service_provider_info.service_provider_id
												AND expense_info.expense_id = '".$ref_id."'
												AND expense_info.shop_id = '".$this->tank_auth->get_shop_id()."'
											");
				
			}
			if($purpose == 'gift')
			{
				$query_3 = $this -> db -> query("SELECT DISTINCT distributor_info.distributor_name,distributor_info.distributor_contact_no
												FROM gift_details,distributor_info,transaction_ref_details,transaction_details
											    WHERE gift_details.gift_id = transaction_ref_details.ref_id
												AND gift_details.gift_from = distributor_info.distributor_id
											    AND gift_details.gift_id = '".$ref_id."'
											    AND gift_details.shop_id = '".$this->tank_auth->get_shop_id()."'
											");
				
			}
			if($purpose == 'purchase' || $purpose == 'Cheque_Dishonor' )
			{
				$query_4 = $this -> db -> query("SELECT DISTINCT distributor_info.distributor_name,distributor_info.distributor_contact_no
												FROM purchase_receipt_info,transaction_ref_details,transaction_details,distributor_info
												WHERE purchase_receipt_info.receipt_id = transaction_ref_details.ref_id
												AND purchase_receipt_info.distributor_id= distributor_info.distributor_id
												AND purchase_receipt_info.receipt_id = '".$ref_id."'
												AND purchase_receipt_info.shop_id = '".$this->tank_auth->get_shop_id()."'
											");
				
			}	
			$query_final = array(
				'sale' => $query,
				'expense' => $query_2,
				'gift' => $query_3,
				'purchase' => $query_4
			);						
			return $query_final;
		}
		/*************************************************
		 *  All Transaction with a Specific Distributor  *
		 *************************************************/
		function transaction_with_distributor( $distributor_id )
		{
			$this->db->order_by("receipt_id", "asc");
		    $query = $this -> db -> select('distributor_name, distributor_info.distributor_id, receipt_id,
											grand_total,total_paid,receipt_status,
											receipt_doc, receipt_creator')
								 -> from('purchase_receipt_info, distributor_info')
								 -> where('distributor_info.distributor_id = "'.$distributor_id.'"')
								 -> where('distributor_info.distributor_id = purchase_receipt_info.distributor_id')
								 -> where('purchase_receipt_info.shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			 return $query;
		}
		
		/****************************************************
		 * Select Random Products lower Then Alarming level *
		 ****************************************************/
		function product_under_alarming_level()
		{
			$this -> db -> select("product_info.product_name, product_info.product_id,stock_amount,alarming_stock,
								   bulk_unit_buy_price, unit_sale_price");		
			$this -> db -> from('product_info, bulk_stock_info, sale_price_info');
			$this -> db -> where('product_info.product_id = bulk_stock_info.product_id');
			$this -> db -> where('product_info.product_id = sale_price_info.product_id');
			$this -> db -> where('bulk_stock_info.shop_id = sale_price_info.shop_id');
			$this -> db -> where('sale_price_info.shop_id', $this -> shop_id);
			$this -> db -> where('stock_amount <= alarming_stock');
			$this -> db -> where('product_status = "active"');
			$this -> db -> order_by('alarming_stock','desc');
			//$this -> db -> order_by('product_info.product_id','random');
			//$this -> db -> limit(5);
			$query = $this -> db ->get();
			return $query;
		}
		
		/**********************************
		 * Get Best Seling Products       *
		 **********************************/
		function best_sale( $start_date , $end_date , $limit_level)
		{
			/* Will be working for only Bulk*/
			/* $this -> db -> order_by('SUM( sale_details.sale_quantity )','desc');
			$this -> db -> select('product_info.product_id, product_info.product_name ,  SUM( sale_details.sale_quantity ) AS total_quantity_sale');
			$this -> db -> from('product_info, invoice_info, sale_details, sale_price_info');
			
			$this -> db -> where('product_info.product_id = sale_details.product_id');
			$this -> db -> where('invoice_info.invoice_id = sale_details.invoice_id');
			$this -> db -> where('product_info.product_id = sale_price_info.product_id');
			$this -> db -> where('sale_price_info.shop_id', $this -> shop_id);
			$this -> db -> where('sale_details.product_specification = "bulk"');
			$this -> db -> where('invoice_doc >= "'.$start_date.'"');
			$this -> db -> where('invoice_doc <= "'.$end_date.'"');
			$this -> db -> where('product_status = "active"');
			
			$this -> db -> group_by('sale_details.product_id');
			
			$this -> db -> limit($limit_level);
			$query = $this -> db ->get();
			return $query; */
			
			/* Will be working for only Bulk*/
			$this -> db -> order_by('SUM( sale_details.sale_quantity )','desc');
			$this -> db -> select('product_info.product_id, product_info.product_name ,  SUM( sale_details.sale_quantity ) AS total_quantity_sale');
			$this -> db -> from('product_info, invoice_info, sale_details, sale_price_info');
			
			$this -> db -> where('product_info.product_id = sale_details.product_id');
			$this -> db -> where('invoice_info.invoice_id = sale_details.invoice_id');
			$this -> db -> where('product_info.product_id = sale_price_info.product_id');
			$this -> db -> where('sale_price_info.shop_id', $this -> shop_id);
			$this -> db -> where('sale_details.product_specification = "bulk"');
			$this -> db -> where('invoice_doc >= "'.$start_date.'"');
			$this -> db -> where('invoice_doc <= "'.$end_date.'"');
			$this -> db -> where('product_status = "active"');
			
			$this -> db -> group_by('sale_details.product_id');
			
			$this -> db -> limit($limit_level);
			$query = $this -> db ->get();
			return $query;
		}
		/**********************************
		 * Slow   Seling Products       *
		 **********************************/
		function slow_sale( $start_date , $end_date , $limit_level)
		{
			/* Will be working for only Bulk*/
			/* $this -> db -> order_by('SUM( sale_details.sale_quantity )','asc');
			$this -> db -> select('product_info.product_id, product_info.product_name , SUM( sale_details.sale_quantity ) AS total_quantity_sale');
			$this -> db -> from('product_info, invoice_info, sale_details, sale_price_info');
			
			$this -> db -> where('product_info.product_id = sale_details.product_id');
			$this -> db -> where('invoice_info.invoice_id = sale_details.invoice_id');
			$this -> db -> where('product_info.product_id = sale_price_info.product_id');
			$this -> db -> where('sale_price_info.shop_id', $this -> shop_id);
			$this -> db -> where('sale_details.product_specification = "bulk"');
			$this -> db -> where('invoice_doc >= "'.$start_date.'"');
			$this -> db -> where('invoice_doc <= "'.$end_date.'"');
			$this -> db -> where('product_status = "active"');
			
			$this -> db -> group_by('sale_details.product_id');
			
			$this -> db -> limit($limit_level);
			$query = $this -> db ->get();
			return $query; */
			/* Will be working for only Bulk*/
			$this -> db -> order_by('SUM( sale_details.sale_quantity )','asc');
			$this -> db -> select('product_info.product_id, product_info.product_name ,  SUM( sale_details.sale_quantity ) AS total_quantity_sale');
			$this -> db -> from('product_info, invoice_info, sale_details, sale_price_info');
			
			$this -> db -> where('product_info.product_id = sale_details.product_id');
			$this -> db -> where('invoice_info.invoice_id = sale_details.invoice_id');
			$this -> db -> where('product_info.product_id = sale_price_info.product_id');
			$this -> db -> where('sale_price_info.shop_id', $this -> shop_id);
			$this -> db -> where('sale_details.product_specification = "bulk"');
			$this -> db -> where('invoice_doc >= "'.$start_date.'"');
			$this -> db -> where('invoice_doc <= "'.$end_date.'"');
			$this -> db -> where('product_status = "active"');
			
			$this -> db -> group_by('sale_details.product_id');
			
			$this -> db -> limit($limit_level);
			$query = $this -> db ->get();
			return $query;
		}
		/********************************
		 *  Get All Stock Total Amount *
		 * ******************************/
		 function get_all_stock_amount()
		 {
			$query = $this -> db -> select( '(bulk_unit_buy_price *  stock_amount) AS stock_asset' )
								 -> from('bulk_stock_info')
								 -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			$stock = 0;
			foreach($query -> result() as $result):
					$stock += $result -> stock_asset;
			endforeach;
			return $stock;
		 }
		/**********************************************
		* Calculate Transport Cost for Purchase     **
		* ********************************************/
		function specific_date_transport_cost_calculation( $start, $end )
		{
			$query = $this -> db -> select_sum( 'expense_amount' )
								 -> from('expense_info')
								 -> where('expense_doc >= "'.$start.'"')
								 -> where('expense_doc <= "'.$end.'"')
								 -> where('expense_type = "Transport Cost For Purchase"')
								 -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			foreach($query -> result() as $result):
					$total_expense = $result -> expense_amount;
			endforeach;
			return $total_expense;
		}
		/*********************************************
		 * Stock Status on a Specific Date           *
		 *********************************************/
		function stock_status_on_specific_date( $query_date, $current_date )
		{
			$present_stock_amount = $this -> get_all_stock_amount();
			$purchase_amount = $this -> specific_date_purchase_amount_calculation( $query_date, $current_date );
			$sale_amount = $this -> specific_date_buy_price_calculation( $query_date, $current_date );
			$sale_return_amount = $this -> specific_date_sale_return_buy_price_calculation( $query_date, $current_date );
			//$transport_cost = $this -> specific_date_transport_cost_calculation( $query_date, $current_date );
			$result = ( $present_stock_amount + $sale_amount ) -  $purchase_amount - $sale_return_amount;
			$result = round($result, 2);
			if($result == round($result, 0))
				$result = $result.'.00';
			else if(round($result, 1) == round($result, 2))
				$result = $result.'0';
			
			return $result;
		}
		
		function stock_status_on_opening_specific_date( $query_date, $current_date )
		{
			//$present_stock_amount = $this -> get_all_stock_amount();
			$purchase_amount = $this -> specific_date_purchase_amount_before( $query_date, $current_date );
			
			//echo $query_date;
			
			$sale_amount = $this -> specific_date_buy_price_before( $query_date, $current_date );
			//$transport_cost = $this -> specific_date_transport_cost_calculation( $query_date, $current_date );
			$result = ( $purchase_amount -  $sale_amount ) ;
			if($result < 0){
				$result = 0;
			}
			$result = round($result, 2);
			if($result == round($result, 0))
				$result = $result.'.00';
			else if(round($result, 1) == round($result, 2))
				$result = $result.'0';
			
			return $result;
		}
		
		function specific_date_purchase_amount_before( $start, $end )
		{
			//echo $start;
			$query = $this -> db -> select( 'SUM( grand_total + transport_cost ) AS grand_total' )
								 -> from('purchase_receipt_info')
								 -> where('receipt_date < "'.$start.'"')
								// -> where('receipt_date <= "'.$end.'"')
								 -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			$grand_total = 0;
			foreach($query -> result() as $result):
					$grand_total = $result -> grand_total;
			endforeach;
			return $grand_total;
		}
		
		function specific_date_purchase_amount_after( $start, $end )
		{
			//echo $start;
			$query = $this -> db -> select( 'SUM( grand_total + transport_cost ) AS grand_total' )
								 -> from('purchase_receipt_info')
								 -> where('receipt_date <= "'.$start.'"')
								// -> where('receipt_date <= "'.$end.'"')
								 -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			$grand_total = 0;
			foreach($query -> result() as $result):
					$grand_total = $result -> grand_total;
			endforeach;
			return $grand_total;
		}
		
		function stock_status_on_closing_specific_date( $query_date, $current_date )
		{
			//$present_stock_amount = $this -> get_all_stock_amount();
			$purchase_amount = $this -> specific_date_purchase_amount_after( $current_date, $current_date );
			
			//echo $query_date;
			
			$sale_amount = $this -> specific_date_buy_price_after( $current_date, $current_date );
			//$transport_cost = $this -> specific_date_transport_cost_calculation( $query_date, $current_date );
			$result = ( $purchase_amount -  $sale_amount ) ;
			if($result < 0){
				$result = 0;
			}
			$result = round($result, 2);
			if($result == round($result, 0))
				$result = $result.'.00';
			else if(round($result, 1) == round($result, 2))
				$result = $result.'0';
			
			return $result;
		}
		
		function specific_date_buy_price_after( $start, $end  )
		{
			$query = $this -> db -> select( 'unit_buy_price,sale_quantity' )
								 -> from('sale_details,invoice_info')
								 -> where('invoice_doc <= "'.$start.'"')
								// -> where('invoice_doc <= "'.$end.'"')
								 -> where('invoice_info.invoice_id = sale_details.invoice_id' )
								 -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			
			$total_buy=0;
			foreach($query -> result() as $result):
					$total_buy = $result -> unit_buy_price * $result -> sale_quantity + $total_buy;
			endforeach;
			return $total_buy;
		
		}
		
		function specific_date_buy_price_before( $start, $end  )
		{
			$query = $this -> db -> select( 'unit_buy_price,sale_quantity' )
								 -> from('sale_details,invoice_info')
								 -> where('invoice_doc < "'.$start.'"')
								// -> where('invoice_doc <= "'.$end.'"')
								 -> where('invoice_info.invoice_id = sale_details.invoice_id' )
								 -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			
			$total_buy=0;
			foreach($query -> result() as $result):
					$total_buy = $result -> unit_buy_price * $result -> sale_quantity + $total_buy;
			endforeach;
			return $total_buy;
		
		}
		
		
		
		/****************************************************************************************
		 * all Service Provider information 
		 * 
		 * Section: Accounts & Report
		 * **************************************************************************************/
		function all_service_providers_information($specific,$service_provider_id)
		{
			$this -> db -> order_by("service_provider_name", "asc");
			$this -> db -> select('service_provider_name,service_provider_id,service_provider_type,service_provider_contact');
			$this -> db -> from('service_provider_info');	 
			if($specific) $this -> db ->where('service_provider_id',$service_provider_id);
			return $this -> db -> get();
		}

		
		function loan_payment_details($loan_details_id){
			$this->db->select('loan_receiving_info.*');
			$this->db->from('loan_receiving_info');
			$this->db->where('loan_details_id',$loan_details_id);
			$this->db->order_by('receive_doc','desc');
			$query = $this->db->get();
			return $query;
		}
		

		
		/* ***********************************************************
		 * this will fatch all  stock (2016-12-17) ovi
		 *
		 * ***********************************************************/
		function all_staff_list()
		{
			$this->db->select('*');
			$this->db->from('employee_info');
			$query = $this->db->get();
			return $query;
		}
		
		
		function get_card_info_by_multi(){

			$card_id= $this->input->post('card_id');

			$this->db->select('bank_card_info.card_name, bank_card_info.card_id, bank_card_info.status,bank_info.bank_name');
			$this->db->from('bank_card_info,bank_info');
			$this->db->where('bank_card_info.bank_id = bank_info.bank_id');
			if($card_id!=''){$this->db->where('bank_card_info.card_id = "'.$card_id.'" ');}
			$query = $this->db->get();
			
			return $query;
			
		}
			function all_select_list_2($table_name,$value_field,$option_field)
			{
				$query = $this->db->from($table_name)
								  -> get();
				if($option_field == 'bank_name'){
					$select[''] = 'Select Bank';
				}

				if($query->num_rows() > 0){
					foreach($query->result() as $field){
						$select[$field->$value_field] = $field->$option_field;
					}
				}
				return $select;
			}
			
			function specific_card_new( $card_id )
			 {
				$this->db->select('bank_card_info.card_name, bank_card_info.card_id, bank_card_info.status,bank_info.bank_name,bank_info.bank_id');
				$this->db->from('bank_card_info,bank_info');
				$this->db->where('bank_card_info.bank_id = bank_info.bank_id');
				$this->db->where('bank_card_info.card_id = "'.$card_id.'"');
				$query = $this -> db -> get();
				return $query->row();
			 }
			 function save_card_info_edit($hid)
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$new_update_data = array(		
					'bank_id' => $this -> input ->post('bank_id'),
					'card_name' => $this -> input ->post('card_name'),
					'status' => $this -> input ->post('status'),
					'dom' => $bd_date
				);
			
				$this->db->where('card_id', $hid);
				$this -> db -> update('bank_card_info', $new_update_data);
			
				return true;
			}
			
			 

		function all_stock_report_by_barcode($barcode)
		{

			$barcode2= rawurlencode($barcode);
			$barcode1 = rawurldecode($barcode2);

			$this->db->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price,general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_info.product_specification,product_type,product_size');
			$this->db->from('product_info');
			$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
			//$this->db->where('bulk_stock_info.stock_amount > 0'); 
			$this->db->where('product_info.barcode = "'.$barcode1.'" ');
			$this->db->order_by('product_info.product_id','asc'); 
			$this->db->order_by('product_info.product_name','asc'); 
			$query = $this->db->get();
			return $query;
		} 
		
		function get_stock_info_by_multi()
		{
			$catagory_name= $this->input->post('catagory_name');
			$product_id= $this->input->post('product_id');
			$company_name=$this->input->post('company_name');
			$type_wise=$this->input->post('type_wise');
			$product_amount=$this->input->post('product_amount');
			//$start_date=$this->input->post('start_date');
			//$end_date=$this->input->post('end_date');
			
			$category1 = rawurldecode($catagory_name);
			$company1 = rawurldecode($company_name);
			
			if($type_wise !='')
			{
				if($type_wise =='available')
				{
					$this->db->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price,general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_info.product_specification,product_type,product_size');
					$this->db->from('product_info');
					$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
					$this->db->where('bulk_stock_info.stock_amount > 0'); 
					if($product_id!=''){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
					if($category1!=''){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
					if($company1!=''){$this->db->where('product_info.company_name = "'.$company1.'" ');}
					if($product_amount!=''){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
					/* if($start_date!=''){$this->db->where('bulk_stock_info.stock_doc >= "'.$start_date.'"');}

					if($end_date!='')
					{
						$this->db->where('bulk_stock_info.stock_doc <= "'.$end_date.'"');
					}
					else if($start_date!=''){
						$this->db->where('bulk_stock_info.stock_doc <= "'.$start_date.'"');
					} */
					
					//$this->db->limit(5);
					$this->db->order_by('product_info.product_id','asc'); 
					$this->db->order_by('product_info.product_name','asc'); 
					$query = $this->db->get();
					return $query;
				}
				else if($type_wise =='not_available')
				{
					$this->db->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price,general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_info.product_specification,product_type,product_size');
					$this->db->from('product_info');
					$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
					$this->db->where('bulk_stock_info.stock_amount <= 0'); 
					if($product_id!=''){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
					if($category1!=''){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
					if($company1!=''){$this->db->where('product_info.company_name = "'.$company1.'" ');}
					if($product_amount!=''){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
					/* if($start_date!=''){$this->db->where('bulk_stock_info.stock_doc >= "'.$start_date.'"');}

					if($end_date!='')
					{
						$this->db->where('bulk_stock_info.stock_doc <= "'.$end_date.'"');
					}
					else if($start_date!=''){
						$this->db->where('bulk_stock_info.stock_doc <= "'.$start_date.'"');
					} */
					
					//$this->db->limit(5);
					$this->db->order_by('product_info.product_id','asc'); 
					$this->db->order_by('product_info.product_name','asc'); 
					$query = $this->db->get();
					return $query;
				}
				else if($type_wise =='all')
				{
					$this->db->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price, general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_info.product_specification,product_type,product_size');
					$this->db->from('product_info,bulk_stock_info');
					$this->db->where('product_info.product_id = bulk_stock_info.product_id');
					//$this->db->where('bulk_stock_info.stock_amount <= 0'); 
					if($product_id!=''){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
					if($category1!=''){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
					if($company1!=''){$this->db->where('product_info.company_name = "'.$company1.'" ');}
					if($product_amount!=''){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
					/* if($start_date!=''){$this->db->where('bulk_stock_info.stock_doc >= "'.$start_date.'"');}

					if($end_date!='')
					{
						$this->db->where('bulk_stock_info.stock_doc <= "'.$end_date.'"');
					}
					else if($start_date!=''){
						$this->db->where('bulk_stock_info.stock_doc <= "'.$start_date.'"');
					} */
					
					//$this->db->limit(5);
					$this->db->order_by('product_info.product_id','asc'); 
					$this->db->order_by('product_info.product_name','asc'); 
					$query = $this->db->get();
					return $query;
				}
			}
			else
			{
					$this->db->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price, general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_info.product_specification,product_type,product_size');
					$this->db->from('product_info,bulk_stock_info');
					$this->db->where('product_info.product_id = bulk_stock_info.product_id');
					if($product_id!=''){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
					if($category1!=''){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
					if($company1!=''){$this->db->where('product_info.company_name = "'.$company1.'" ');}
					if($product_amount!=''){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
					/* if($start_date!=''){$this->db->where('bulk_stock_info.stock_doc >= "'.$start_date.'"');}

					if($end_date!='')
					{
						$this->db->where('bulk_stock_info.stock_doc <= "'.$end_date.'"');
					}
					else if($start_date!=''){
						$this->db->where('bulk_stock_info.stock_doc <= "'.$start_date.'"');
					} */
					
					//$this->db->limit(5);
					$this->db->order_by('product_info.product_id','asc'); 
					$this->db->order_by('product_info.product_name','asc'); 
					$query = $this->db->get();
					return $query;
			}
		} 
		
		function print_data_stock()
		{
			$barcode = $this -> uri -> segment(3);
			$product_id = $this -> uri -> segment(4);
			$category = $this -> uri -> segment(5);
			$company = $this -> uri -> segment(6);
			$type_wise = $this -> uri -> segment(7);
			$product_amount = $this -> uri -> segment(8);
			$start_date=$this -> uri -> segment(9);
			$end_date=$this -> uri -> segment(10);
			
			$barcode1 = rawurldecode($barcode);
			$category1 = rawurldecode($category);
			$company1 = rawurldecode($company);
			
			if($type_wise !='' && $type_wise !='null')
			{
				if($type_wise =='available')
				{
					$this->db->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price, general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_info.product_specification,product_type,product_size');
					$this->db->from('product_info');
					$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
					$this->db->where('bulk_stock_info.stock_amount > 0'); 
					if($barcode1!='' && $barcode1 !='null'){$this->db->where('product_info.barcode = "'.$barcode1.'" ');} 
					if($product_id!='' && $product_id !='null'){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
					if($category1!='' && $category1 !='null'){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
					if($company1!='' && $company1 !='null'){$this->db->where('product_info.company_name = "'.$company1.'" ');}
					if($product_amount!='' && $product_amount !='null'){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
					/* if($start_date!='' && $start_date !='null'){$this->db->where('bulk_stock_info.stock_doc >= "'.$start_date.'"');}

					if($end_date!='' && $end_date !='null')
					{
						$this->db->where('bulk_stock_info.stock_doc <= "'.$end_date.'"');
					}
					else if($start_date!='' && $start_date !='null'){
						$this->db->where('bulk_stock_info.stock_doc <= "'.$start_date.'"');
					} */
					
					//$this->db->limit(5);
					$this->db->order_by('product_info.product_id','asc'); 
					$this->db->order_by('product_info.product_name','asc'); 
					$query = $this->db->get();
					return $query;
				}
				else if($type_wise =='not_available')
				{
					$this->db->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price,general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_info.product_specification,product_type,product_size');
					$this->db->from('product_info');
					$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
					$this->db->where('bulk_stock_info.stock_amount <= 0'); 
					if($barcode1!='' && $barcode1 !='null'){$this->db->where('product_info.barcode = "'.$barcode1.'" ');} 
					if($product_id!='' && $product_id !='null'){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
					if($category1!='' && $category1 !='null'){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
					if($company1!='' && $company1 !='null'){$this->db->where('product_info.company_name = "'.$company1.'" ');}
					if($product_amount!='' && $product_amount !='null'){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
					/* if($start_date!='' && $start_date !='null'){$this->db->where('bulk_stock_info.stock_doc >= "'.$start_date.'"');}

					if($end_date!='' && $end_date !='null')
					{
						$this->db->where('bulk_stock_info.stock_doc <= "'.$end_date.'"');
					}
					else if($start_date!='' && $start_date !='null'){
						$this->db->where('bulk_stock_info.stock_doc <= "'.$start_date.'"');
					} */
					
					//$this->db->limit(5);
					$this->db->order_by('product_info.product_id','asc'); 
					$this->db->order_by('product_info.product_name','asc'); 
					$query = $this->db->get();
					return $query;
				}
				else if($type_wise =='all')
				{
					$this->db->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price, general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_info.product_specification,product_type,product_size');
					$this->db->from('product_info,bulk_stock_info');
					$this->db->where('product_info.product_id = bulk_stock_info.product_id');
					//$this->db->where('bulk_stock_info.stock_amount <= 0'); 
					if($barcode1!='' && $barcode1 !='null'){$this->db->where('product_info.barcode = "'.$barcode1.'" ');} 
					if($product_id!='' && $product_id !='null'){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
					if($category1!='' && $category1 !='null'){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
					if($company1!='' && $company1 !='null'){$this->db->where('product_info.company_name = "'.$company1.'" ');}
					if($product_amount!='' && $product_amount !='null'){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
					/* if($start_date!='' && $start_date !='null'){$this->db->where('bulk_stock_info.stock_doc >= "'.$start_date.'"');}

					if($end_date!='' && $end_date !='null')
					{
						$this->db->where('bulk_stock_info.stock_doc <= "'.$end_date.'"');
					}
					else if($start_date!='' && $start_date !='null'){
						$this->db->where('bulk_stock_info.stock_doc <= "'.$start_date.'"');
					}
					 */
					//$this->db->limit(5);
					$this->db->order_by('product_info.product_id','asc'); 
					$this->db->order_by('product_info.product_name','asc'); 
					$query = $this->db->get();
					return $query;
				}
			}
			else
			{
				$this->db->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price, general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_info.product_specification,product_type,product_size');
				$this->db->from('product_info');
				$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');

				if($barcode1!='' && $barcode1 !='null'){$this->db->where('product_info.barcode = "'.$barcode1.'" ');} 
				if($product_id!='' && $product_id !='null'){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
				if($category1!='' && $category1 !='null'){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
				if($company1!='' && $company1 !='null'){$this->db->where('product_info.company_name = "'.$company1.'" ');}
				if($product_amount!='' && $product_amount !='null'){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
				/* if($start_date!='' && $start_date !='null'){$this->db->where('bulk_stock_info.stock_doc >= "'.$start_date.'"');}

				if($end_date!='' && $end_date !='null')
				{
					$this->db->where('bulk_stock_info.stock_doc <= "'.$end_date.'"');
				}
				else if($start_date!='' && $start_date !='null'){
					$this->db->where('bulk_stock_info.stock_doc <= "'.$start_date.'"');
				} */
				
				//$this->db->limit(5);
				$this->db->order_by('product_info.product_id','asc'); 
				$this->db->order_by('product_info.product_name','asc'); 
				$query = $this->db->get();
				return $query;
			}
		}
		function get_warranty_stock_info_by_multi()
		{
			$catagory_name= '';$this->input->post('catagory_name');
			$product_id= 1446;$this->input->post('product_id');
			$company_name='';$this->input->post('company_name');
			$category1 = rawurldecode($catagory_name);
			$company1 = rawurldecode($company_name);

			$this->db->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price,general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_info.product_specification,product_type,product_size');
			$this->db->from('product_info,bulk_stock_info');
			$this->db->where('product_info.product_id = bulk_stock_info.product_id');
			$this->db->where('product_info.product_specification=2'); 
			if($product_id!=''){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
			if($category1!=''){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
			if($company1!=''){$this->db->where('product_info.company_name = "'.$company1.'" ');}
			
			$this->db->order_by('product_info.product_id','asc'); 
			$this->db->order_by('product_info.product_name','asc'); 
			$query = $this->db->get();
			return $query;
		} 
		function get_warranty_stock($product_id)
		{
			$this->db->select('*');
			$this->db->from('warranty_product_list');
			$this->db->where('warranty_product_list.product_id = "'.$product_id.'" ');
			$this->db->group_by('warranty_product_list.ip_id'); 
			$this->db->order_by('warranty_product_list.ip_id','asc'); 
			$query = $this->db->get();
			return $query;
		} 
		function get_purchase_info_by_multi()
		{

			$receipt_id= $this->input->post('receipt_id');
			$product_id= $this->input->post('product_id');
			$catagory_name= $this->input->post('catagory_name');
			$company_name=$this->input->post('company_name');
			$distributor_id=$this->input->post('distributor_id');
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			
			$category1 = rawurldecode($catagory_name);
			$company1 = rawurldecode($company_name);
			
			$this->db->select('product_info.product_name, product_info.company_name, product_info.catagory_name,purchase_info.purchase_receipt_id,product_info.product_type,purchase_receipt_info.receipt_id,distributor_info.distributor_name, purchase_receipt_info.receipt_date,purchase_info.purchase_doc,purchase_receipt_info.grand_total,purchase_receipt_info.total_paid,purchase_receipt_info.receipt_status, purchase_receipt_info.receipt_creator, purchase_info.unit_buy_price,purchase_info.purchase_quantity,bulk_stock_info.bulk_unit_sale_price');
			
			$this->db->from('product_info,purchase_receipt_info,distributor_info,purchase_info');
			$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
			//$this->db->where('product_info.product_id = bulk_stock_info.product_id');
			$this->db->where('purchase_receipt_info.distributor_id = distributor_info.distributor_id');
			$this->db->where('purchase_receipt_info.receipt_id = purchase_info.purchase_receipt_id');
			$this->db->where('purchase_info.product_id = product_info.product_id');
			
			if($receipt_id!=''){$this->db->where('purchase_receipt_info.receipt_id',$receipt_id);} 
			if($product_id!=''){$this->db->where('product_info.product_id',$product_id);}
			if($category1!=''){$this->db->where('product_info.catagory_name',$category1);}
			if($company1!=''){$this->db->where('product_info.company_name',$company1);}
			if($distributor_id!=''){$this->db->where('distributor_info.distributor_id',$distributor_id);}
			if($start_date!=''){$this->db->where('purchase_receipt_info.receipt_date >= "'.$start_date.'"');}

			if($end_date!='')
			{
				$this->db->where('purchase_receipt_info.receipt_date <= "'.$end_date.'"');
			}
			else if($start_date!=''){
				$this->db->where('purchase_receipt_info.receipt_date <= "'.$start_date.'"');
			}
			//$this->db->limit(5);
			$this->db->group_by('purchase_info.purchase_id'); 
			$this->db->group_by('purchase_receipt_info.receipt_id'); 
			$this->db->order_by('purchase_receipt_info.receipt_id','asc'); 
			$this->db->order_by('purchase_receipt_info.receipt_date','asc'); 
			$query = $this->db->get();
			
			return $query;
			
		} 	
		
		function print_data_purchase()
		{
			$receipt = $this -> uri -> segment(3);
			$product = $this -> uri -> segment(4);
			$category = $this -> uri -> segment(5);
			$company = $this -> uri -> segment(6);
			$distributor_id = $this -> uri -> segment(7);
			$start_date = $this -> uri -> segment(8);
			$end_date = $this -> uri -> segment(9);

			$category1 = rawurldecode($category);
			$company1 = rawurldecode($company);
			
			$this->db->select('product_info.product_name, product_info.company_name, product_info.catagory_name,purchase_info.purchase_receipt_id,product_info.product_type,purchase_receipt_info.receipt_id,distributor_info.distributor_name, purchase_receipt_info.receipt_date,purchase_info.purchase_doc,purchase_receipt_info.total_paid,purchase_receipt_info.receipt_status, purchase_receipt_info.receipt_creator, purchase_info.unit_buy_price,purchase_receipt_info.grand_total,purchase_info.purchase_quantity,bulk_stock_info.bulk_unit_sale_price');
			
			$this->db->from('product_info,purchase_receipt_info,distributor_info,purchase_info');
			$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
			//$this->db->where('product_info.product_id = bulk_stock_info.product_id');
			$this->db->where('purchase_receipt_info.distributor_id = distributor_info.distributor_id');
			$this->db->where('purchase_receipt_info.receipt_id = purchase_info.purchase_receipt_id');
			$this->db->where('purchase_info.product_id = product_info.product_id');
			
			
			if($receipt!='' && $receipt !='null'){$this->db->where('purchase_info.purchase_receipt_id',$receipt);} 
			if($product!='' && $product !='null'){$this->db->where('product_info.product_id',$product);}
			if($category1!='' && $category1 !='null'){$this->db->where('product_info.catagory_name',$category1);}
			if($company1!='' && $company1 !='null'){$this->db->where('product_info.company_name',$company1);}
			if($distributor_id!='' && $distributor_id !='null'){$this->db->where('distributor_info.distributor_id',$distributor_id);}
			if($start_date!='' && $start_date !='null'){$this->db->where('purchase_receipt_info.receipt_date >= "'.$start_date.'" ');}
			if($end_date!='' && $end_date !='null'){$this->db->where('purchase_receipt_info.receipt_date <= "'.$end_date.'" ');}
			else if($start_date!='' && $start_date !='null'){$this->db->where('purchase_receipt_info.receipt_date <= "'.$start_date.'" ');}

			//$this->db->limit(5);
			$this->db->group_by('purchase_info.purchase_id'); 
			$this->db->group_by('purchase_receipt_info.receipt_id');
			$this->db->order_by('purchase_receipt_info.receipt_id','asc'); 
			$this->db->order_by('purchase_receipt_info.receipt_date','asc'); 
			$query = $this->db->get();
			
			return $query;
		}
		
		
		
		
		function get_sale_info_by_multi()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
				
			$invoice_id= $this->input->post('invoice_id');
			$customer_id= $this->input->post('customer_id');
			$product_id= $this->input->post('product_id');
			$catagory_name= $this->input->post('catagory_name');
			$company_name=$this->input->post('company_name');
			$type_wise=$this->input->post('type_wise');
			$seller_id=$this->input->post('id');
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');

			$category1 = rawurldecode($catagory_name);
			$company1 = rawurldecode($company_name);
			
			if($type_wise !='')
			{
				if($type_wise =='invoice')
				{
					$this->db->select('customer_info.customer_name, invoice_info.invoice_id,invoice_info.delivery_charge,invoice_info.payment_mode,invoice_info.total_paid,invoice_info.grand_total,invoice_info.sale_return_amount,invoice_info.total_price,invoice_info.invoice_doc,invoice_info.discount_amount,users.username');
					$this->db->from('invoice_info,customer_info,users');
					$this -> db -> where('customer_info.customer_id = invoice_info.customer_id');
					//$this->db->join('bank_book_info','invoice_info.invoice_id = bank_book_info.reference_id','left');
					$this -> db -> where('invoice_info.invoice_creator = users.id');
					if($invoice_id!=''){$this->db->where('invoice_info.invoice_id',$invoice_id);} 
					if($seller_id!=''){$this->db->where('invoice_info.invoice_creator',$seller_id);}
					if($customer_id!=''){$this->db->where('invoice_info.customer_id',$customer_id);} 
					if($start_date!=''){$this -> db -> where('invoice_info.invoice_doc >= "'.$start_date.'"');}
					if($end_date!=''){$this -> db -> where('invoice_info.invoice_doc <= "'.$end_date.'"');}
					else if($start_date!=''){
						$this->db->where('invoice_info.invoice_doc <= "'.$start_date.'"');
					}
					$this->db->group_by('invoice_info.invoice_id'); 
					$this->db->order_by('invoice_info.invoice_id','asc'); 
					$this->db->order_by('invoice_info.invoice_doc','asc'); 
					
					$query = $this->db->get();
					return $query;
				}
				else if($type_wise =='product')
				{
					$this->db->select('customer_info.customer_name,product_info.product_name, product_info.company_name, product_info.catagory_name,product_info.product_type,invoice_info.invoice_id,sum(sale_quantity) as number_of_quantity,sum(exact_sale_price) as tot_sale,sale_details.unit_buy_price,sale_details.unit_sale_price,sale_details.exact_sale_price,invoice_info.invoice_doc,users.username');
					$this->db->from('invoice_info,sale_details,customer_info,product_info,users');
					$this -> db -> where('customer_info.customer_id = invoice_info.customer_id');
					$this -> db -> where('invoice_info.invoice_id = sale_details.invoice_id');
					$this -> db -> where('invoice_info.invoice_creator = users.id');
					$this -> db -> where('product_info.product_id = sale_details.product_id');
					if($invoice_id!=''){$this->db->where('invoice_info.invoice_id',$invoice_id);} 
					if($customer_id!=''){$this->db->where('invoice_info.customer_id',$customer_id);} 
					if($product_id!=''){$this->db->where('product_info.product_id',$product_id);}
					if($category1!=''){$this->db->where('product_info.catagory_name',$category1);}
					if($company1!=''){$this->db->where('product_info.company_name',$company1);}
					//if($product_type1!=''){$this->db->where('product_info.product_type',$product_type1);}
					if($seller_id!=''){$this->db->where('invoice_info.invoice_creator',$seller_id);}
					if($start_date!=''){$this -> db -> where('invoice_info.invoice_doc >= "'.$start_date.'"');}
					if($end_date!=''){$this -> db -> where('invoice_info.invoice_doc <= "'.$end_date.'"');}
					else if($start_date!=''){
						$this->db->where('invoice_info.invoice_doc <= "'.$start_date.'"');
					}
					$this->db->group_by('product_info.product_id');
					$this->db->order_by('product_info.product_name','asc'); 
					
					$query = $this->db->get();
					return $query;
				}
				else if($type_wise =='invoice_product')
				{
					$this->db->select('customer_info.customer_name,product_info.product_name, product_info.company_name, product_info.catagory_name,product_info.product_type,invoice_info.invoice_id,sale_quantity,exact_sale_price,sale_details.unit_buy_price,sale_details.unit_sale_price,invoice_info.invoice_doc,users.username');
					$this->db->from('invoice_info,sale_details,customer_info,product_info,users');
					$this -> db -> where('customer_info.customer_id = invoice_info.customer_id');
					$this -> db -> where('invoice_info.invoice_id = sale_details.invoice_id');
					$this -> db -> where('invoice_info.invoice_creator = users.id');
					$this -> db -> where('product_info.product_id = sale_details.product_id');
					if($invoice_id!=''){$this->db->where('invoice_info.invoice_id',$invoice_id);} 
					if($customer_id!=''){$this->db->where('invoice_info.customer_id',$customer_id);} 
					if($product_id!=''){$this->db->where('product_info.product_id',$product_id);}
					if($category1!=''){$this->db->where('product_info.catagory_name',$category1);}
					if($company1!=''){$this->db->where('product_info.company_name',$company1);}
					//if($product_type1!=''){$this->db->where('product_info.product_type',$product_type1);}
					if($seller_id!=''){$this->db->where('invoice_info.invoice_creator',$seller_id);}
					if($start_date!=''){$this -> db -> where('invoice_info.invoice_doc >= "'.$start_date.'"');}
					if($end_date!=''){$this -> db -> where('invoice_info.invoice_doc <= "'.$end_date.'"');}
					else if($start_date!=''){
						$this->db->where('invoice_info.invoice_doc <= "'.$start_date.'"');
					}
					//$this->db->group_by('product_info.product_id');
					$this->db->order_by('invoice_info.invoice_doc','asc'); 
					
					$query = $this->db->get();
					return $query;
				}
			}
			else
			{
				$this->db->select('customer_info.customer_name,product_info.product_name, product_info.company_name, product_info.catagory_name,product_info.product_type,invoice_info.invoice_id,sum(sale_quantity) as number_of_quantity,sum(exact_sale_price) as tot_sale,sale_details.unit_buy_price,sale_details.unit_sale_price,sale_details.exact_sale_price,invoice_info.invoice_doc,users.username');
				
				$this->db->from('invoice_info,sale_details,customer_info,product_info,users');
				$this -> db -> where('customer_info.customer_id = invoice_info.customer_id');
				$this -> db -> where('invoice_info.invoice_id = sale_details.invoice_id');
				$this -> db -> where('invoice_info.invoice_creator = users.id');
				$this -> db -> where('product_info.product_id = sale_details.product_id');
				
				if($invoice_id!=''){$this->db->where('invoice_info.invoice_id',$invoice_id);} 
				if($customer_id!=''){$this->db->where('invoice_info.customer_id',$customer_id);} 
				if($product_id!=''){$this->db->where('product_info.product_id',$product_id);}
				if($category1!=''){$this->db->where('product_info.catagory_name',$category1);}
				if($company1!=''){$this->db->where('product_info.company_name',$company1);}
				//if($product_type1!=''){$this->db->where('product_info.product_type',$product_type1);}
				if($seller_id!=''){$this->db->where('invoice_info.invoice_creator',$seller_id);}
				if($start_date!=''){$this -> db -> where('invoice_info.invoice_doc >= "'.$start_date.'"');}
				if($end_date!=''){$this -> db -> where('invoice_info.invoice_doc <= "'.$end_date.'"');}
				else if($start_date!=''){
					$this->db->where('invoice_info.invoice_doc <= "'.$start_date.'"');
				}
				//$this->db->group_by('invoice_info.invoice_id');
				$this->db->group_by('product_info.product_id');
				$this->db->order_by('invoice_info.invoice_id','asc'); 
				$this->db->order_by('invoice_info.invoice_doc','asc'); 
				$query = $this->db->get();
				
				return $query;
			}
			
		}
		
		function print_data_sale()
		{
			$invoice = $this -> uri -> segment(3);
			$product = $this -> uri -> segment(4);
			$category = $this -> uri -> segment(5);
			$company = $this -> uri -> segment(6);
			$customer = $this -> uri -> segment(7);
			$type_wise = $this -> uri -> segment(8);
			$seller = $this -> uri -> segment(9);
			$start_date = $this -> uri -> segment(10);
			$end_date = $this -> uri -> segment(11);
			
			$category1 = rawurldecode($category);
			$company1 = rawurldecode($company);
			
			if($type_wise !='' && $type_wise !='null')
			{
				if($type_wise=='invoice')
				{
					$this->db->select('customer_info.customer_name, invoice_info.invoice_id,invoice_info.payment_mode,invoice_info.delivery_charge,invoice_info.total_paid,invoice_info.grand_total,invoice_info.sale_return_amount,invoice_info.total_price,invoice_info.invoice_doc,invoice_info.discount_amount,users.username');
					$this->db->from('invoice_info,customer_info,users');
					$this -> db -> where('customer_info.customer_id = invoice_info.customer_id');
					//$this->db->join('bank_book_info','invoice_info.invoice_id = bank_book_info.reference_id','left');
					$this -> db -> where('invoice_info.invoice_creator = users.id');
					
					if($invoice!='' && $invoice!='null'){$this->db->where('invoice_info.invoice_id',$invoice);} 
					if($start_date!='' && $start_date !='null'){$this -> db -> where('invoice_info.invoice_doc >= "'.$start_date.'"');}
					if($end_date!='' && $end_date!='null'){$this -> db -> where('invoice_info.invoice_doc <= "'.$end_date.'"');}
					else if($start_date!='' && $start_date!='null'){
						$this->db->where('invoice_info.invoice_doc <= "'.$start_date.'"');
					}
					//$this->db->group_by('invoice_info.invoice_id');
					$this->db->order_by('invoice_info.invoice_id','asc');  
					$this->db->order_by('invoice_info.invoice_doc','asc');  
					
					$query = $this->db->get();
					return $query;
				}
				else if($type_wise=='product')
				{
					$this->db->select('customer_info.customer_name,product_info.product_name, product_info.company_name, product_info.catagory_name,product_info.product_type,invoice_info.invoice_id,sum(sale_quantity) as number_of_quantity,sum(exact_sale_price) as tot_sale,sale_details.unit_buy_price,sale_details.unit_sale_price,invoice_info.invoice_doc,users.username');
					$this->db->from('invoice_info,sale_details,customer_info,product_info,users');
					$this -> db -> where('customer_info.customer_id = invoice_info.customer_id');
					$this -> db -> where('invoice_info.invoice_id = sale_details.invoice_id');
					$this -> db -> where('invoice_info.invoice_creator = users.id');
					$this -> db -> where('product_info.product_id = sale_details.product_id');
					if($start_date!='' && $start_date!='null'){$this -> db -> where('invoice_info.invoice_doc >= "'.$start_date.'"');}
					if($end_date!='' && $end_date!='null'){$this -> db -> where('invoice_info.invoice_doc <= "'.$end_date.'"');}
					else if($start_date!='' && $start_date!='null'){
						$this->db->where('invoice_info.invoice_doc <= "'.$start_date.'"');
					}
					$this->db->group_by('product_info.product_id');
					$this->db->order_by('product_info.product_name','asc'); 
					
					$query = $this->db->get();
					return $query;
				}
				else if($type_wise=='invoice_product')
				{
					$this->db->select('customer_info.customer_name,product_info.product_name, product_info.company_name, product_info.catagory_name,product_info.product_type,invoice_info.invoice_id,sale_quantity,exact_sale_price,sale_details.unit_buy_price,sale_details.unit_sale_price,invoice_info.invoice_doc,users.username');
					$this->db->from('invoice_info,sale_details,customer_info,product_info,users');
					$this -> db -> where('customer_info.customer_id = invoice_info.customer_id');
					$this -> db -> where('invoice_info.invoice_id = sale_details.invoice_id');
					$this -> db -> where('invoice_info.invoice_creator = users.id');
					$this -> db -> where('product_info.product_id = sale_details.product_id');
					if($product!='' && $product!='null'){$this->db->where('product_info.product_id',$product);}
					if($start_date!='' && $start_date!='null'){$this -> db -> where('invoice_info.invoice_doc >= "'.$start_date.'"');}
					if($end_date!='' && $end_date!='null'){$this -> db -> where('invoice_info.invoice_doc <= "'.$end_date.'"');}
					else if($start_date!='' && $start_date!='null'){
						$this->db->where('invoice_info.invoice_doc <= "'.$start_date.'"');
					}
					//$this->db->group_by('product_info.product_id');
					$this->db->order_by('invoice_info.invoice_doc','asc'); 
					
					$query = $this->db->get();
					return $query;
				}
			}
			else
			{
				$this->db->select('customer_info.customer_name,product_info.product_name, product_info.company_name, product_info.catagory_name,product_info.product_type,invoice_info.invoice_id,sum(sale_quantity) as number_of_quantity,sum(exact_sale_price) as tot_sale,sale_details.unit_buy_price,sale_details.unit_sale_price,invoice_info.invoice_doc,users.username');
				
				$this->db->from('invoice_info,sale_details,customer_info,product_info,users');
				$this -> db -> where('customer_info.customer_id = invoice_info.customer_id');
				$this -> db -> where('invoice_info.invoice_id = sale_details.invoice_id');
				$this -> db -> where('invoice_info.invoice_creator = users.id');
				$this -> db -> where('product_info.product_id = sale_details.product_id');
				
				if($invoice!='' && $invoice!='null'){$this->db->where('invoice_info.invoice_id',$invoice);} 
				if($customer!='' && $customer!='null'){$this->db->where('invoice_info.customer_id',$customer);} 
				if($product!='' && $product!='null'){$this->db->where('product_info.product_id',$product);}
				if($category1!='' && $category1!='null'){$this->db->where('product_info.catagory_name',$category1);}
				if($company1!='' && $company1!='null'){$this->db->where('product_info.company_name',$company1);}
				if($seller!='' && $seller!='null'){$this->db->where('invoice_info.invoice_creator',$seller);}
				if($start_date!='' && $start_date!='null'){$this -> db -> where('invoice_info.invoice_doc >= "'.$start_date.'"');}
				if($end_date!='' && $end_date!='null'){$this -> db -> where('invoice_info.invoice_doc <= "'.$end_date.'"');}
				else if($start_date!='' && $start_date!='null'){
					$this->db->where('invoice_info.invoice_doc <= "'.$start_date.'"');
				}
				$this->db->group_by('product_info.product_id');
				$this->db->order_by('invoice_info.invoice_id','asc'); 
				$this->db->order_by('invoice_info.invoice_doc','asc'); 
				$query = $this->db->get();
				
				return $query;
			}
			
		}
		
		
		function get_card_sale_info_by_multi()
		{

			$card_id= $this->input->post('card_id');
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			
			$this->db->select('bank_book.amount,bank_book.date,bank_card_info.card_name, bank_info.bank_name');
			
			$this->db->from('bank_book,bank_card_info,bank_info');
			$this->db->where('bank_book.bank_id = bank_info.bank_id');
			$this->db->where('bank_book.card_id = bank_card_info.card_id');
			$this->db->where('bank_book.transaction_type = "in"');
			
			if($card_id!=''){$this->db->where('bank_book.card_id',$card_id);} 
			if($start_date!=''){$this -> db -> where('bank_book.date >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('bank_book.date <= "'.$end_date.'"');}
			else if($start_date!=''){
				$this->db->where('bank_book.date <= "'.$start_date.'"');
			}
			$this->db->order_by('bank_book.date','asc'); 
			$this->db->order_by('bank_card_info.card_name','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		}
		function print_data_card_sale()
		{
			$card_id = $this -> uri -> segment(3);
			$start_date = $this -> uri -> segment(4);
			$end_date = $this -> uri -> segment(5);
			
			$this->db->select('bank_book.amount,bank_book.date,bank_card_info.card_name, bank_info.bank_name');
			
			$this->db->from('bank_book,bank_card_info,bank_info');
			$this->db->where('bank_book.bank_id = bank_info.bank_id');
			$this->db->where('bank_book.card_id = bank_card_info.card_id');
			$this->db->where('bank_book.transaction_type = "in"');
			
			if($card_id!='' && $card_id!='null'){$this->db->where('bank_book.card_id',$card_id);} 
			if($start_date!='' && $start_date!='null'){$this -> db -> where('bank_book.date >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!='null'){$this -> db -> where('bank_book.date <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!='null'){
				$this->db->where('bank_book.date <= "'.$start_date.'"');
			}
			$this->db->order_by('bank_book.date','asc'); 
			$this->db->order_by('bank_card_info.card_name','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		}
		
		function get_discount_info_by_multi()
		{
			$barcode= rawurlencode($this->input->post('barcode'));
			$product_name= rawurlencode($this->input->post('product_name'));
			$catagory_name= $this->input->post('catagory_name');
			$company_name=$this->input->post('company_name');
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			
			$barcode1 = rawurldecode($barcode);
			$product_name1 = rawurldecode($product_name);
			$category1 = rawurldecode($catagory_name);
			$company1 = rawurldecode($company_name);
			
			$this->db->select('product_info.product_id,product_info.product_name, product_info.company_name, product_info.catagory_name,product_info.barcode,discount_info.discount_info_id,discount_info.validate_quantity,discount_info.start_date,discount_info.end_date,discount_info.doc');
			
			$this->db->from('discount_info,customer_info,product_info');
			//$this -> db -> where('discount_info.discount_info_id = discount_details.discount_info_id');
			$this -> db -> where('product_info.product_id = discount_info.product_id');
			
			if($barcode1!=''){$this->db->where('product_info.barcode',$barcode1);} 
			if($product_name1!=''){$this->db->where('product_info.product_name',$product_name1);}
			if($category1!=''){$this->db->where('product_info.catagory_name',$category1);}
			if($company1!=''){$this->db->where('product_info.company_name',$company1);}
			if($start_date!=''){$this -> db -> where('discount_info.doc >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('discount_info.doc <= "'.$end_date.'"');}
			else if($start_date!=''){
				$this->db->where('discount_info.doc <= "'.$start_date.'"');
			}
			//$this->db->limit(5);
			$this->db->group_by('discount_info.discount_info_id');
			$this->db->order_by('discount_info.discount_info_id','asc'); 
			$this->db->order_by('discount_info.doc','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		}
		
		function print_data_discount(){
			$barcode = $this -> uri -> segment(3);
			$product = $this -> uri -> segment(4);
			$category = $this -> uri -> segment(5);
			$company = $this -> uri -> segment(6);
			$start_date = $this -> uri -> segment(7);
			$end_date = $this -> uri -> segment(8);
			
			
			$barcode1 = rawurldecode($barcode);
			$product_name1 = rawurldecode($product);
			$category1 = rawurldecode($category);
			$company1 = rawurldecode($company);

			$this->db->select('product_info.product_id,product_info.product_name, product_info.company_name, product_info.catagory_name,product_info.barcode,discount_info.discount_info_id,discount_info.validate_quantity,discount_info.start_date,discount_info.end_date,discount_info.doc');
			
			$this->db->from('discount_info,discount_details,customer_info,product_info');
			//$this -> db -> where('discount_info.discount_info_id = discount_details.discount_info_id');
			$this -> db -> where('product_info.product_id = discount_info.product_id');
			
			if($barcode1!='' && $barcode1!= 'null'){$this->db->where('product_info.barcode',$barcode1);} 
			if($product_name1!='' && $product_name1!= 'null'){$this->db->where('product_info.product_name',$product_name1);}
			if($category1!='' && $category1!= 'null'){$this->db->where('product_info.catagory_name',$category1);}
			if($company1!='' && $company1!= 'null'){$this->db->where('product_info.company_name',$company1);}
			if($start_date!='' && $start_date!= 'null'){$this -> db -> where('discount_info.doc >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!= 'null'){$this -> db -> where('discount_info.doc <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!= 'null'){
				$this->db->where('discount_info.doc <= "'.$start_date.'"');
			}
			$this->db->group_by('discount_info.discount_info_id');
			$this->db->order_by('discount_info.discount_info_id','asc'); 
			$this->db->order_by('discount_info.doc','asc'); 
			$query = $this->db->get();
			
			return $query;	
		}
		
		function get_damage_info_by_multi()
		{

			$pro_id= $this->input->post('pro_id');
			$catagory_name= $this->input->post('catagory_name');
			$company_name=$this->input->post('company_name');
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');

			$category1 = rawurldecode($catagory_name);
			$company1 = rawurldecode($company_name);
			
			$this->db->select('product_info.product_id,product_info.product_name, product_info.company_name, product_info.catagory_name,damage_product.damage_id,damage_product.damage_quantity,damage_product.doc,damage_product.unit_buy_price');
			$this->db->from('damage_product,product_info');
			$this->db->where('product_info.product_id = damage_product.product_id');
			
			if($pro_id!=''){$this->db->where('product_info.product_id',$pro_id);}
			if($category1!=''){$this->db->where('product_info.catagory_name',$category1);}
			if($company1!=''){$this->db->where('product_info.company_name',$company1);}
			if($start_date!=''){$this -> db -> where('damage_product.doc >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('damage_product.doc <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('damage_product.doc <= "'.$start_date.'"');}

			$this->db->group_by('damage_product.damage_id');
			$this->db->order_by('damage_product.damage_id','asc'); 
			$this->db->order_by('damage_product.doc','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		} 	
		
		function print_data_damage()
		{
			$pro_id = $this -> uri -> segment(3);
			$catagory_name = $this -> uri -> segment(4);
			$company_name = $this -> uri -> segment(5);
			$start_date = $this -> uri -> segment(6);
			$end_date = $this -> uri -> segment(7);

			$category1 = rawurldecode($catagory_name);
			$company1 = rawurldecode($company_name);
			
			$this->db->select('product_info.product_id,product_info.product_name, product_info.company_name, product_info.catagory_name,damage_product.damage_id,damage_product.damage_quantity,damage_product.doc,damage_product.unit_buy_price');
			$this->db->from('damage_product,product_info');
			$this->db->where('product_info.product_id = damage_product.product_id');
			
			if($pro_id!='' && $pro_id!= 'null'){$this->db->where('product_info.product_id',$pro_id);}
			if($category1!='' && $category1!= 'null'){$this->db->where('product_info.catagory_name',$category1);}
			if($company1!='' && $company1!= 'null'){$this->db->where('product_info.company_name',$company1);}
			if($start_date!='' && $start_date!= 'null'){$this -> db -> where('damage_product.doc >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!= 'null'){$this -> db -> where('damage_product.doc <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!= 'null'){$this -> db -> where('damage_product.doc <= "'.$start_date.'"');}

			$this->db->group_by('damage_product.damage_id');
			$this->db->order_by('damage_product.damage_id','asc'); 
			$this->db->order_by('damage_product.doc','asc'); 
			$query = $this->db->get();
			
			return $query;	
		}	
		function get_delivery_charge_info_by_multi()
		{
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			
			$this->db->select('*');
			$this->db->from('transaction_info');
			$this->db->where('transaction_purpose= "delivery_charge"');
			if($start_date!=''){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}

			$this->db->group_by('transaction_info.transaction_id');
			$this->db->order_by('transaction_info.transaction_id','asc'); 
			$this->db->order_by('transaction_info.date','asc'); 
			$query = $this->db->get();
			
			return $query;	
		} 	
		function print_data_delivery_charge(){
			$start_date = $this -> uri -> segment(3);
			$end_date = $this -> uri -> segment(4);
			
			$this->db->select('*');
			$this->db->from('transaction_info');
			$this->db->where('transaction_purpose= "delivery_charge"');
			if($start_date!='' && $start_date!= 'null'){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!= 'null'){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!= 'null'){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}

			$this->db->group_by('transaction_info.transaction_id');
			$this->db->order_by('transaction_info.transaction_id','asc'); 
			$this->db->order_by('transaction_info.date','asc'); 
			$query = $this->db->get();
			return $query;		
		}	
		function get_return_info_by_multi()
		{
			$pro_id= $this->input->post('product_id');
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			$type=$this->input->post('type');
			if($type=='direct')
			{
				$this->db->select('product_info.product_name,sale_return_details_tbl.sale_return_id,sale_return_details_tbl.product_id,sale_return_details_tbl.return_quantity,sale_return_details_tbl.unit_sale_price,sale_return_details_tbl.return_doc,sale_return_receipt_tbl.status');
				$this->db->from('product_info,sale_return_details_tbl,sale_return_receipt_tbl');
				$this->db->where('sale_return_details_tbl.sale_return_id = sale_return_receipt_tbl.sale_return_id');
				$this->db->where('sale_return_details_tbl.product_id = product_info.product_id');
				$this->db->where('sale_return_receipt_tbl.status="'.$type.'"');
			
				if($pro_id!=''){$this->db->where('product_info.product_id',$pro_id);}
				if($start_date!=''){$this -> db -> where('sale_return_details_tbl.return_doc >= "'.$start_date.'"');}
				if($end_date!=''){$this -> db -> where('sale_return_details_tbl.return_doc <= "'.$end_date.'"');}
				else if($start_date!=''){$this -> db -> where('sale_return_details_tbl.return_doc <= "'.$start_date.'"');}

				//$this->db->group_by('sale_return_details_tbl.id');
				$this->db->order_by('sale_return_details_tbl.id','asc'); 
				$this->db->order_by('sale_return_details_tbl.return_doc','asc'); 
				$query = $this->db->get();
				
				return $query;	
			}
			else if($type=='indirect')
			{
				$this->db->select('product_info.product_name,sale_return_details_tbl.sale_return_id,sale_return_details_tbl.product_id,sale_return_details_tbl.return_quantity,sale_return_details_tbl.unit_sale_price,sale_return_details_tbl.return_doc,sale_return_receipt_tbl.status');
				$this->db->from('product_info,sale_return_details_tbl,sale_return_receipt_tbl');
				$this->db->where('sale_return_details_tbl.sale_return_id = sale_return_receipt_tbl.sale_return_id');
				$this->db->where('sale_return_details_tbl.product_id = product_info.product_id');
				$this->db->where('sale_return_receipt_tbl.status="'.$type.'"');
				
				if($pro_id!=''){$this->db->where('product_info.product_id',$pro_id);}
				if($start_date!=''){$this -> db -> where('sale_return_details_tbl.return_doc >= "'.$start_date.'"');}
				if($end_date!=''){$this -> db -> where('sale_return_details_tbl.return_doc <= "'.$end_date.'"');}
				else if($start_date!=''){$this -> db -> where('sale_return_details_tbl.return_doc <= "'.$start_date.'"');}

				//$this->db->group_by('sale_return_details_tbl.id');
				$this->db->order_by('sale_return_details_tbl.id','asc'); 
				$this->db->order_by('sale_return_details_tbl.return_doc','asc'); 
				$query = $this->db->get();
				
				return $query;	
			
			} 	
			else
			{
				$this->db->select('product_info.product_name,sale_return_details_tbl.sale_return_id,sale_return_details_tbl.product_id,sale_return_details_tbl.return_quantity,sale_return_details_tbl.unit_sale_price,sale_return_details_tbl.return_doc,sale_return_receipt_tbl.status');
				$this->db->from('product_info,sale_return_details_tbl,sale_return_receipt_tbl');
				$this->db->where('sale_return_details_tbl.sale_return_id = sale_return_receipt_tbl.sale_return_id');
				$this->db->where('sale_return_details_tbl.product_id = product_info.product_id');

				if($pro_id!=''){$this->db->where('product_info.product_id',$pro_id);}
				if($start_date!=''){$this -> db -> where('sale_return_details_tbl.return_doc >= "'.$start_date.'"');}
				if($end_date!=''){$this -> db -> where('sale_return_details_tbl.return_doc <= "'.$end_date.'"');}
				else if($start_date!=''){$this -> db -> where('sale_return_details_tbl.return_doc <= "'.$start_date.'"');}

				$this->db->group_by('sale_return_details_tbl.id');
				$this->db->order_by('sale_return_details_tbl.id','asc'); 
				$this->db->order_by('sale_return_details_tbl.return_doc','asc'); 
				$query = $this->db->get();
				
				return $query;	
			
			} 	
		} 	
		
		function print_data_return(){
			$pro_id = $this -> uri -> segment(3);
			$start_date = $this -> uri -> segment(4);
			$end_date = $this -> uri -> segment(5);
			$type = $this -> uri -> segment(6);
			if($type=='direct')
			{
				$this->db->select('product_info.product_name,sale_return_details_tbl.sale_return_id,sale_return_details_tbl.product_id,sale_return_details_tbl.return_quantity,sale_return_details_tbl.unit_sale_price,sale_return_details_tbl.return_doc,sale_return_receipt_tbl.status');
				$this->db->from('product_info,sale_return_details_tbl,sale_return_receipt_tbl');
				$this->db->where('sale_return_details_tbl.sale_return_id = sale_return_receipt_tbl.sale_return_id');
				$this->db->where('sale_return_details_tbl.product_id = product_info.product_id');
				$this->db->where('sale_return_receipt_tbl.status="'.$type.'"');
			
				if($pro_id!='' && $pro_id!= 'null'){$this->db->where('product_info.product_id',$pro_id);}
				if($start_date!='' && $start_date!= 'null'){$this -> db -> where('sale_return_details_tbl.return_doc >= "'.$start_date.'"');}
				if($end_date!='' && $end_date!= 'null'){$this -> db -> where('sale_return_details_tbl.return_doc <= "'.$end_date.'"');}
				else if($start_date!='' && $start_date!= 'null'){$this -> db -> where('sale_return_details_tbl.return_doc <= "'.$start_date.'"');}

				//$this->db->group_by('sale_return_details_tbl.id');
				$this->db->order_by('sale_return_details_tbl.id','asc'); 
				$this->db->order_by('sale_return_details_tbl.return_doc','asc'); 
				$query = $this->db->get();
				
				return $query;	
			}
			else if($type=='indirect')
			{
				$this->db->select('product_info.product_name,sale_return_details_tbl.sale_return_id,sale_return_details_tbl.product_id,sale_return_details_tbl.return_quantity,sale_return_details_tbl.unit_sale_price,sale_return_details_tbl.return_doc,sale_return_receipt_tbl.status');
				$this->db->from('product_info,sale_return_details_tbl,sale_return_receipt_tbl');
				$this->db->where('sale_return_details_tbl.sale_return_id = sale_return_receipt_tbl.sale_return_id');
				$this->db->where('sale_return_details_tbl.product_id = product_info.product_id');
				$this->db->where('sale_return_receipt_tbl.status="'.$type.'"');
				
				if($pro_id!='' && $pro_id!= 'null'){$this->db->where('product_info.product_id',$pro_id);}
				if($start_date!='' && $start_date!= 'null'){$this -> db -> where('sale_return_details_tbl.return_doc >= "'.$start_date.'"');}
				if($end_date!='' && $end_date!= 'null'){$this -> db -> where('sale_return_details_tbl.return_doc <= "'.$end_date.'"');}
				else if($start_date!='' && $start_date!= 'null'){$this -> db -> where('sale_return_details_tbl.return_doc <= "'.$start_date.'"');}

				//$this->db->group_by('sale_return_details_tbl.id');
				$this->db->order_by('sale_return_details_tbl.id','asc'); 
				$this->db->order_by('sale_return_details_tbl.return_doc','asc'); 
				$query = $this->db->get();
				
				return $query;	
			
			} 
			else
			{
				$this->db->select('product_info.product_name,sale_return_details_tbl.sale_return_id,sale_return_details_tbl.product_id,sale_return_details_tbl.return_quantity,sale_return_details_tbl.unit_sale_price,sale_return_details_tbl.return_doc,sale_return_receipt_tbl.status');
				$this->db->from('product_info,sale_return_details_tbl,sale_return_receipt_tbl');
				$this->db->where('sale_return_details_tbl.sale_return_id = sale_return_receipt_tbl.sale_return_id');
				$this->db->where('sale_return_details_tbl.product_id = product_info.product_id');

				if($pro_id!='' && $pro_id!= 'null'){$this->db->where('product_info.product_id',$pro_id);}
				if($start_date!='' && $start_date!= 'null'){$this -> db -> where('sale_return_details_tbl.return_doc >= "'.$start_date.'"');}
				if($end_date!='' && $end_date!= 'null'){$this -> db -> where('sale_return_details_tbl.return_doc <= "'.$end_date.'"');}
				else if($start_date!='' && $start_date!= 'null'){$this -> db -> where('sale_return_details_tbl.return_doc <= "'.$start_date.'"');}

				//$this->db->group_by('sale_return_details_tbl.id');
				$this->db->order_by('sale_return_details_tbl.id','asc'); 
				$this->db->order_by('sale_return_details_tbl.return_doc','asc'); 
				$query = $this->db->get();
				
				return $query;	
			
			} 				
		}	
		function get_purchase_return_info_by_multi($distributor_id,$start_date,$end_date)
		{
			$this -> db -> select("product_info.product_id,product_info.product_name,distributor_info.distributor_name,purchase_return_main_product.*");
			$this -> db -> from("distributor_info,product_info,purchase_return_main_product");
			$this -> db -> where("purchase_return_main_product.produ_id=product_info.product_id");
			$this -> db -> where("purchase_return_main_product.distri_id=distributor_info.distributor_id");

			if($distributor_id!='' && $distributor_id!='null'){$this->db->where('purchase_return_main_product.distri_id',$distributor_id);}
			if($start_date!='' && $start_date!='null'){$this -> db -> where('purchase_return_main_product.doc >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!='null'){$this -> db -> where('purchase_return_main_product.doc <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!='null'){$this -> db -> where('purchase_return_main_product.doc <= "'.$start_date.'"');}

			$this->db->group_by('purchase_return_main_product.prmp_id');
			$this->db->order_by('purchase_return_main_product.prmp_id','asc'); 
			$this->db->order_by('purchase_return_main_product.doc','asc'); 
			$query = $this->db->get();
			
			return $query;	
		}
		function return_warranty_product($produ_id,$prmp_id)
		{
			$this -> db -> select("*");
			$this -> db -> from("purchase_return_warranty_product");
			$this -> db -> where("purchase_return_warranty_product.prmp_id",$prmp_id);
			$this -> db -> where("purchase_return_warranty_product.product_id",$produ_id);
			$this->db->group_by('purchase_return_warranty_product.prwp_id');
			$query = $this -> db -> get();

			return $query;
		}
		function get_product_exchange_info_by_multi()
		{
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');

			$this->db->select('exchange_return_tbl.exchange_return_doc,exchange_return_tbl.total_amount_ex,exchange_return_tbl.total_amount_re,exchange_return_details_tbl.*');
			$this->db->from('exchange_return_tbl,exchange_return_details_tbl');
			$this->db->where('exchange_return_tbl.exchange_return_id = exchange_return_tbl.exchange_return_id');

			if($start_date!=''){$this-> db -> where('exchange_return_tbl.exchange_return_doc >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('exchange_return_tbl.exchange_return_doc <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('exchange_return_tbl.exchange_return_doc <= "'.$start_date.'"');}
			
			

			$this->db->group_by('exchange_return_details_tbl.product_id');
			$this->db->order_by('exchange_return_tbl.exchange_return_id','asc'); 
			$this->db->order_by('exchange_return_tbl.exchange_return_doc','asc'); 
			$query = $this->db->get();
			
			return $query;	
		} 	
		
		function print_product_exchange()
		{
			$start_date=$this -> uri -> segment(3);
			$end_date=$this -> uri -> segment(4);

			$this->db->select('exchange_return_tbl.exchange_return_doc,exchange_return_tbl.total_amount_ex,exchange_return_tbl.total_amount_re,exchange_return_details_tbl.*');
			$this->db->from('exchange_return_tbl,exchange_return_details_tbl');
			$this->db->where('exchange_return_tbl.exchange_return_id = exchange_return_tbl.exchange_return_id');

			if($start_date!='' && $start_date!='null'){$this-> db -> where('exchange_return_tbl.exchange_return_doc >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!='null'){$this -> db -> where('exchange_return_tbl.exchange_return_doc <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!='null'){$this -> db -> where('exchange_return_tbl.exchange_return_doc <= "'.$start_date.'"');}

			$this->db->group_by('exchange_return_details_tbl.product_id');
			$this->db->order_by('exchange_return_tbl.exchange_return_id','asc'); 
			$this->db->order_by('exchange_return_tbl.exchange_return_doc','asc'); 
			$query = $this->db->get();
			
			return $query;	
		} 		
		function get_expense_info_by_multi()
		{
			$type_type= $this->input->post('expense_name');
			$employee_id= $this->input->post('employee_id');
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			$expense_type = rawurldecode($type_type);
			
			$this->db->select('service_provider_info.service_provider_name,expense_info.expense_id,expense_info.expense_type,expense_info.total_paid,expense_info.expense_amount,expense_info.expense_doc,expense_info.total_paid');
			$this->db->from('expense_info,service_provider_info');
			$this->db->where('expense_info.service_provider_id = service_provider_info.service_provider_id');
			
			if($expense_type!=''){$this->db->where('expense_info.expense_type',$expense_type);}
			if($service_provider_id!=''){$this->db->where('expense_info.service_provider_id',$service_provider_id);}
			if($start_date!=''){$this -> db -> where('expense_info.expense_doc >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('expense_info.expense_doc <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('expense_info.expense_doc <= "'.$start_date.'"');}

			$this->db->group_by('expense_info.expense_id');
			$this->db->order_by('expense_info.expense_id','asc'); 
			$this->db->order_by('expense_info.expense_doc','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		} 	
		
		function print_data_expense(){
			$type_type = $this -> uri -> segment(3);
			$start_date = $this -> uri -> segment(4);
			$end_date = $this -> uri -> segment(5);
			$service_provider_id = $this -> uri -> segment(6);
			$expense_type = rawurldecode($type_type);
			
			$this->db->select('service_provider_info.service_provider_name,expense_info.expense_id,expense_info.expense_type,expense_info.total_paid,expense_info.expense_amount,expense_info.expense_doc,expense_info.total_paid');
			$this->db->from('expense_info,service_provider_info');
			$this->db->where('expense_info.service_provider_id = service_provider_info.service_provider_id');
			
			if($expense_type!='' && $expense_type!= 'null'){$this->db->where('expense_info.expense_type',$expense_type);}
			if($service_provider_id!='' && $service_provider_id!= 'null'){$this->db->where('expense_info.service_provider_id',$service_provider_id);}
			if($start_date!='' && $start_date!= 'null'){$this -> db -> where('expense_info.expense_doc >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!= 'null'){$this -> db -> where('expense_info.expense_doc <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!= 'null'){$this -> db -> where('expense_info.expense_doc <= "'.$start_date.'"');}

			$this->db->group_by('expense_info.expense_id');
			$this->db->order_by('expense_info.expense_id','asc'); 
			$this->db->order_by('expense_info.expense_doc','asc'); 
			$query = $this->db->get();
			
			return $query;	
		}	
		
		
		function get_expense_info_by_multi_new()
		{
			$type_id= $this->input->post('expense_name');
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			
			$this->db->select('expense_info.expense_id,expense_info.expense_type,expense_info.total_paid,expense_info.expense_amount,expense_info.expense_doc,expense_info.total_paid,type_info.type_type');
			$this->db->from('expense_info,type_info');
			$this->db->where('expense_info.expense_type = type_info.type_id');
			if($type_id!=''){$this->db->where('expense_info.expense_type',$type_id);}
			if($start_date!=''){$this->db->where('expense_info.expense_doc >= "'.$start_date.'"');}
			if($end_date!=''){$this->db->where('expense_info.expense_doc <= "'.$end_date.'"');}
			else if($start_date!=''){$this->db->where('expense_info.expense_doc <= "'.$start_date.'"');}
			$this->db->group_by('expense_info.expense_id');
			$this->db->order_by('expense_info.expense_id','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		} 
		function get_credit_collection_info_by_multi()
		{
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			
			$this->db->select('transaction_info.transaction_id,transaction_info.ledger_id,transaction_info.date_time,transaction_info.transaction_mode,transaction_info.amount,customer_info.customer_name,users.user_full_name');
			$this->db->from('transaction_info,customer_info,users');
			$this->db->where('transaction_info.ledger_id = customer_info.customer_id');
			$this->db->where('transaction_info.creator = users.id');
			$this->db->where('transaction_info.transaction_purpose = "credit_collection"');
			if($start_date!=''){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}

			//$this->db->group_by('transaction_info.expense_id');
			$this->db->order_by('transaction_info.transaction_id','asc'); 
			$this->db->order_by('transaction_info.date','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		} 	
		
		function all_credit_collection()
		{
			$start_date = $this -> uri -> segment(3);
			$end_date = $this -> uri -> segment(4);
			
			$this->db->select('transaction_info.transaction_id,transaction_info.ledger_id,transaction_info.date_time,transaction_info.transaction_mode,transaction_info.amount,customer_info.customer_name,users.user_full_name');
			$this->db->from('transaction_info,customer_info,users');
			$this->db->where('transaction_info.ledger_id = customer_info.customer_id');
			$this->db->where('transaction_info.creator = users.id');
			$this->db->where('transaction_info.transaction_purpose = "credit_collection"');
			
			if($start_date!='null'){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!='null'){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!='null'){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}

			//$this->db->group_by('transaction_info.expense_id');
			$this->db->order_by('transaction_info.transaction_id','asc'); 
			$this->db->order_by('transaction_info.date','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		}	
		function print_data_catagory()
		{
			$this->db->select('catagory_info.*');
			$this->db->from('catagory_info');
			$this->db->group_by('catagory_info.catagory_id'); 
			$this->db->order_by('catagory_info.catagory_name','asc'); 
			$query = $this->db->get();
			return $query;
		}
		function print_data_company()
		{
			$this->db->select('company_info.*');
			$this->db->from('company_info');
			$this->db->group_by('company_info.company_id'); 
			$this->db->order_by('company_info.company_name','asc'); 
			$query = $this->db->get();
			return $query;
		}
		function print_data_distributor()
		{
			$this->db->select('distributor_info.*');
			$this->db->from('distributor_info');
			$this->db->group_by('distributor_info.distributor_id'); 
			$this->db->order_by('distributor_info.distributor_name','asc'); 
			$query = $this->db->get();
			return $query;
		}
		function print_data_customer()
		{
			$this->db->select('customer_info.*');
			$this->db->from('customer_info');
			$this->db->group_by('customer_info.customer_id'); 
			$this->db->order_by('customer_info.customer_name','asc'); 
			$query = $this->db->get();
			return $query;
		}
		
		/***************************************************
		* Calculate Purchase Amount of Specific date      **
		* **************************************************/
		function specific_date_purchase_amount_calculation( $start, $end )
		{
			$query = $this -> db -> select( 'SUM( grand_total + transport_cost ) AS grand_total' )
								 -> from('purchase_receipt_info')
								 -> where('receipt_date >= "'.$start.'"')
								 -> where('receipt_date <= "'.$end.'"')
								 -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			$grand_total = 0;
			foreach($query -> result() as $result):
					$grand_total = $result -> grand_total;
			endforeach;
			return $grand_total;
		}
		/**************************************************
		 * Calculate Sale Price of a Specific date     **
		  * *********************************************/
		public function from_bank($start,$end)
		{
			$this->db->select_sum('transaction_info.amount');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose = "from_bank"');
			$this->db->where('transaction_info.date >= "'.$start.'"');
			$this->db->where('transaction_info.date <= "'.$end.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$total_from_bank = $result -> amount;
			endforeach;
			return $total_from_bank;
		}
		public function from_bank_opening($start)
		{
			$this->db->select_sum('transaction_info.amount');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose = "from_bank"');
			$this->db->where('transaction_info.date <="'.$start.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$from_bank_opening = $result -> amount;
			endforeach;
			return $from_bank_opening;
		}
		public function to_bank($start,$end)
		{
			$this->db->select_sum('transaction_info.amount');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose = "to_bank"');
			$this->db->where('transaction_info.date >= "'.$start.'"');
			$this->db->where('transaction_info.date <= "'.$end.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$total_to_bank = $result -> amount;
			endforeach;
			return $total_to_bank;
		}
		public function to_bank_opening($start)
		{
			$this->db->select_sum('transaction_info.amount');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose = "to_bank"');
			$this->db->where('transaction_info.date <="'.$start.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$to_bank_opening = $result -> amount;
			endforeach;
			return $to_bank_opening;
		}
		public function from_owner($start,$end)
		{
			$this->db->select_sum('transaction_info.amount');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose = "from_owner"');
			$this->db->where('transaction_info.date >= "'.$start.'"');
			$this->db->where('transaction_info.date <= "'.$end.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$total_from_owner = $result -> amount;
			endforeach;
			return $total_from_owner;
		}
		public function from_owner_bank($start,$end)
		{
			$this->db->select_sum('transaction_info.amount');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose = "from_owner"');
			$this->db->where('transaction_info.transaction_mode = "cheque"');
			$this->db->where('transaction_info.date >= "'.$start.'"');
			$this->db->where('transaction_info.date <= "'.$end.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$from_owner_bank = $result -> amount;
			endforeach;
			return $from_owner_bank;
		}
		public function from_owner_bank_opening($start)
		{
			$this->db->select_sum('transaction_info.amount');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose = "from_owner"');
			$this->db->where('transaction_info.transaction_mode = "cheque"');
			$this->db->where('transaction_info.date <="'.$start.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$from_owner_bank = $result -> amount;
			endforeach;
			return $from_owner_bank;
		}
		public function from_owner_opening($start)
		{
			$this->db->select_sum('transaction_info.amount');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose = "from_owner"');
			$this->db->where('transaction_info.date <="'.$start.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$from_owner_opening = $result -> amount;
			endforeach;
			return $from_owner_opening;
		}
		public function to_owner($start,$end)
		{
			$this->db->select_sum('transaction_info.amount');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose = "to_owner"');
			$this->db->where('transaction_info.date >= "'.$start.'"');
			$this->db->where('transaction_info.date <= "'.$end.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$total_to_owner = $result -> amount;
			endforeach;
			return $total_to_owner;
		}
		public function to_owner_bank($start,$end)
		{
			$this->db->select_sum('transaction_info.amount');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose = "to_owner"');
			$this->db->where('transaction_info.transaction_mode = "cheque"');
			$this->db->where('transaction_info.date >= "'.$start.'"');
			$this->db->where('transaction_info.date <= "'.$end.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$to_owner_bank = $result -> amount;
			endforeach;
			return $to_owner_bank;
		}
		public function to_owner_bank_opening($start)
		{
			$this->db->select_sum('transaction_info.amount');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose = "to_owner"');
			$this->db->where('transaction_info.transaction_mode = "cheque"');
			$this->db->where('transaction_info.date <= "'.$start.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$to_owner_bank = $result -> amount;
			endforeach;
			return $to_owner_bank;
		}
		public function to_owner_opening($start)
		{
			$this->db->select_sum('transaction_info.amount');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose = "to_owner"');
			$this->db->where('transaction_info.date <="'.$start.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$to_owner_opening = $result -> amount;
			endforeach;
			return $to_owner_opening;
		}
		public function cash_sale($start,$end)
		{
			$this->db->select_sum('invoice_info.grand_total');
			$this->db->from('invoice_info');			
			$this->db->where('invoice_info.payment_mode = "cash"');
			$this->db->where('invoice_info.invoice_doc >= "'.$start.'"');
			$this->db->where('invoice_info.invoice_doc <= "'.$end.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$cash_sale = $result -> grand_total;
			endforeach;
			return $cash_sale;
		}
		public function card_sale($start,$end)
		{
			$this->db->select_sum('invoice_info.grand_total');
			$this->db->from('invoice_info');			
			$this->db->where('invoice_info.payment_mode = "card"');
			$this->db->where('invoice_info.invoice_doc >= "'.$start.'"');
			$this->db->where('invoice_info.invoice_doc <= "'.$end.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$card_sale = $result -> grand_total;
			endforeach;
			return $card_sale;
		}
		public function cash_sale_opening($start)
		{
			$this->db->select_sum('invoice_info.grand_total');
			$this->db->from('invoice_info');			
			$this->db->where('invoice_info.payment_mode = "cash"');
			$this->db->where('invoice_info.invoice_doc <="'.$start.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$cash_sale_opening = $result -> grand_total;
			endforeach;
			return $cash_sale_opening;
		}
		public function card_sale_opening($start)
		{
			$this->db->select_sum('invoice_info.grand_total');
			$this->db->from('invoice_info');			
			$this->db->where('invoice_info.payment_mode = "card"');
			$this->db->where('invoice_info.invoice_doc <="'.$start.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$card_sale_opening = $result -> grand_total;
			endforeach;
			return $card_sale_opening;
		}
		public function cash_delivery_charge($start,$end)
		{
			$this->db->select_sum('invoice_info.delivery_charge');
			$this->db->from('invoice_info');			
			$this->db->where('invoice_info.payment_mode = "cash"');
			$this->db->where('invoice_info.invoice_doc >= "'.$start.'"');
			$this->db->where('invoice_info.invoice_doc <= "'.$end.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$delivery_charge = $result -> delivery_charge;
			endforeach;
			return $delivery_charge;
		}
		public function card_delivery_charge($start,$end)
		{
			$this->db->select_sum('invoice_info.delivery_charge');
			$this->db->from('invoice_info');			
			$this->db->where('invoice_info.payment_mode = "card"');
			$this->db->where('invoice_info.invoice_doc >= "'.$start.'"');
			$this->db->where('invoice_info.invoice_doc <= "'.$end.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$delivery_charge = $result -> delivery_charge;
			endforeach;
			return $delivery_charge;
		}
		public function card_delivery_charge_opening($start)
		{
			$this->db->select_sum('invoice_info.delivery_charge');
			$this->db->from('invoice_info');			
			$this->db->where('invoice_info.payment_mode = "card"');
			$this->db->where('invoice_info.invoice_doc <="'.$start.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$card_delivery_charge_opening = $result -> delivery_charge;
			endforeach;
			return $card_delivery_charge_opening;
		}
		public function cash_delivery_charge_opening($start)
		{
			$this->db->select_sum('invoice_info.delivery_charge');
			$this->db->from('invoice_info');			
			$this->db->where('invoice_info.payment_mode = "cash"');
			$this->db->where('invoice_info.invoice_doc <="'.$start.'"');
			$query_data = $this->db->get();
			
			foreach($query_data -> result() as $result):
					$cash_delivery_charge_opening = $result -> delivery_charge;
			endforeach;
			return $cash_delivery_charge_opening;
		}
		public function cash_sale_return($start,$end)
		{

			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "sale_return"')
								 -> where('transaction_info.transaction_mode = "cash"')
								 -> where('transaction_info.date >= "'.$start.'"')
								 -> where('transaction_info.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$cash_sale_return = $result -> amount;
			endforeach;
			return $cash_sale_return;
		
		}
		public function bank_sale_return($start,$end)
		{

			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "sale_return"')
								 -> where('transaction_info.transaction_mode = "cheque"')
								 -> where('transaction_info.date >= "'.$start.'"')
								 -> where('transaction_info.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$bank_sale_return = $result -> amount;
			endforeach;
			return $bank_sale_return;
		
		}
		public function cash_sale_return_opening($start)
		{

			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "sale_return"')
								 -> where('transaction_info.transaction_mode = "cash"')
								 -> where('transaction_info.date <="'.$start.'"')
								 -> get();
			foreach($query -> result() as $result):
					$cash_sale_return_opening = $result -> amount;
			endforeach;
			return $cash_sale_return_opening;
		
		}
		public function bank_sale_return_opening($start)
		{

			$query = $this -> db -> select_sum('transaction_info.amount')
								 -> from('transaction_info')
								 -> where('transaction_info.transaction_purpose = "sale_return"')
								 -> where('transaction_info.transaction_mode = "cheque"')
								 -> where('transaction_info.date <="'.$start.'"')
								 -> get();
			foreach($query -> result() as $result):
					$bank_sale_return_opening = $result -> amount;
			endforeach;
			return $bank_sale_return_opening;
		
		}
		function specific_date_buy_price_calculation( $start, $end  )
		{
			/*
			foreach($query -> result() as $field):
				$invoice_id = $field -> invoice_id;
				$details = $this -> db -> select_sum( 'unit_buy_price')
														   -> from('sale_details')
														   -> where('invoice_id = "'.$invoice_id.'"')
														   -> get();
														   
				$data[ $invoice_id ] = $details;
				//$sale_price = 0;
			//	$buy_price = 0;
				//foreach($details -> result() as $calculate)
					//$sale_price += $calculate -> unit_sale_price;
				//endforeach;
			endforeach;
			if($query -> num_rows > 0) return $data;
			*/
			/* Previous */
			$query = $this -> db -> select( 'unit_buy_price,sale_quantity' )
								 -> from('sale_details,invoice_info')
								 -> where('invoice_doc >= "'.$start.'"')
								 -> where('invoice_doc <= "'.$end.'"')
								 -> where('invoice_info.invoice_id = sale_details.invoice_id' )
								 -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			
		
			/*******************
			 * For Link Traders
			 * 21-11-2013
			 * Arafat Mamun
			 *******************
			$query = $this -> db -> select_sum( 'product_buy_price')
								 -> from('gate_pass_details,gate_pass_info')
								 -> where('gate_pass_issue_date >= "'.$start.'"')
								 -> where('gate_pass_issue_date <= "'.$end.'"')
								  -> where('gate_pass_details.product_status', 4)
								 ->where('gate_pass_details.gate_pass_id = gate_pass_info.gate_pass_id' )
								 -> get();
			*/
			$total_buy=0;
			foreach($query -> result() as $result):
					$total_buy = $result -> unit_buy_price * $result -> sale_quantity + $total_buy;
			endforeach;
			return $total_buy;
		
		}
		function specific_date_sale_return_buy_price_calculation( $start, $end  )
		{
			$query = $this -> db -> select('unit_buy_price,return_quantity' )
								 -> from('sale_return_details_tbl')
								 -> where('return_doc >= "'.$start.'"')
								 -> where('return_doc <= "'.$end.'"')
								 -> get();
			
		
			$total_buy=0;
			foreach($query -> result() as $result):
					$total_buy = $result -> unit_buy_price * $result -> return_quantity + $total_buy;
			endforeach;
			return $total_buy;
		
		}
		
		
	}




















