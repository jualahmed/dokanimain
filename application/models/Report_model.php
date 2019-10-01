<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Report_model extends CI_model{
	
	private $shop_id;
	function __construct()
	{
		$this->shop_id = $this->tank_auth->get_shop_id();
	}

	public function get_stock_info_by_multi($category1='',$product_id='',$company1='',$type_wise='',$product_amount='')
	{
		if($type_wise !=0)
		{
			if($type_wise =='available')
			{
				$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
				$this->db->where('bulk_stock_info.stock_amount > 0'); 
				if($product_id!=0){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
				if($category1!=0){$this->db->where('product_info.catagory_id = "'.$category1.'" ');}
				if($company1!=0){$this->db->where('product_info.company_name = "'.$company1.'" ');}
				if($product_amount!=0){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
				$this->db->order_by('product_info.product_id','asc'); 
				$this->db->order_by('product_info.product_name','asc'); 
				$query = $this->db->get('product_info');
				return $query;
			}
			else if($type_wise =='not_available')
			{
				$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
				$this->db->where('bulk_stock_info.stock_amount <= 0'); 
				if($product_id!=0){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
				if($category1!=0){$this->db->where('product_info.catagory_id = "'.$category1.'" ');}
				if($company1!=0){$this->db->where('product_info.company_id = "'.$company1.'" ');}
				if($product_amount!=0){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
				$this->db->order_by('product_info.product_id','asc'); 
				$this->db->order_by('product_info.product_name','asc'); 
				$query = $this->db->get('product_info');
				return $query;
			}
			else if($type_wise =='all')
			{
				$this->db->select('product_name, company_id, catagory_id, product_info.product_id, bulk_unit_sale_price, general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_info.product_specification,product_type,product_size');
				$this->db->from('product_info,bulk_stock_info');
				$this->db->where('product_info.product_id = bulk_stock_info.product_id');
				if($product_id!=0){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
				if($category1!=0){$this->db->where('product_info.catagory_id = "'.$category1.'" ');}
				if($company1!=0){$this->db->where('product_info.company_id = "'.$company1.'" ');}
				if($product_amount!=0){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
				$this->db->order_by('product_info.product_id','asc'); 
				$this->db->order_by('product_info.product_name','asc'); 
				$query = $this->db->get();
				return $query;
			}
		}
		else
		{
			$this->db->from('product_info,bulk_stock_info');
			$this->db->where('product_info.product_id = bulk_stock_info.product_id');
			if($product_id!=0)$this->db->where('product_info.product_id = ',$product_id);
			if($category1!=0){$this->db->where('product_info.catagory_id = "'.$category1.'" ');}
			if($company1!=0){$this->db->where('product_info.company_id = "'.$company1.'" ');}
			if($product_amount!=0){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
			$this->db->order_by('product_info.product_id','asc'); 
			$this->db->order_by('product_info.product_name','asc'); 
			$query = $this->db->get();
			return $query;
		}
	}	

	public function stock_details($value='')
	{	
		$this->db->where('status', 1);
		$this->db->join('product_info', 'product_info.product_id = warranty_product_list.product_id');
		$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
		$this->db->join('catagory_info','catagory_info.catagory_id = product_info.catagory_id','left');	
		$this->db->join('company_info','company_info.company_id = product_info.company_id','left');	
		$this->db->join('purchase_receipt_info','purchase_receipt_info.receipt_id = warranty_product_list.purchase_receipt_id');
		return $this->db->get('warranty_product_list')->result();
	}

	public function get_purchase_info_by_multi($receipt_id='',$product_id='',$distributor_id='',$start_date='',$end_date='',$category1='',$company1='')
	{	
		$this->db->join('product_info', 'product_info.product_id = purchase_info.product_id', 'left');
		$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
		$this->db->join('catagory_info','catagory_info.catagory_id = product_info.catagory_id','left');	
		$this->db->join('company_info','company_info.company_id = product_info.company_id','left');	
		$this->db->join('purchase_receipt_info','purchase_receipt_info.receipt_id = purchase_info.purchase_receipt_id','left');
		$this->db->join('distributor_info','distributor_info.distributor_id = purchase_receipt_info.distributor_id');
		if($receipt_id!=0){$this->db->where('purchase_receipt_info.receipt_id',$receipt_id);} 
		if($product_id!=0){$this->db->where('product_info.product_id',$product_id);}
		if($category1!=0){$this->db->where('product_info.catagory_id',$category1);}
		if($company1!=0){$this->db->where('product_info.company_id',$company1);}
		if($distributor_id!=0){$this->db->where(' distributor_info.distributor_id',$distributor_id);}
		if($start_date!=0){$this->db->where('purchase_receipt_info.receipt_date >= "'.$start_date.'"');}
		if($end_date!=0){$this->db->where('purchase_receipt_info.receipt_date <= "'.$end_date.'"');}
		if($start_date!=''){$this->db->where('purchase_receipt_info.receipt_date <= "'.$start_date.'"');}
		$query = $this->db->get('purchase_info');
		return $query;	
	} 

	public function get_sale_info_by_multi($invoice_id='',$customer_id='',$product_id='',$seller_id='',$start_date='',$end_date='',$company_id='',$category_id='')
	{
		$this->db->select('users.username,company_info.company_name,catagory_info.catagory_name,product_info.*,sale_details.*,customer_info.*,invoice_info.*, invoice_info.invoice_id as sid');
		$this->db->join('customer_info', 'invoice_info.customer_id = customer_info.customer_id');
		$this->db->join('sale_details', 'sale_details.invoice_id = invoice_info.invoice_id');
		$this->db->join('product_info', 'product_info.product_id = sale_details.product_id');
		$this->db->join('users', 'users.id = invoice_info.invoice_creator');
		$this->db->join('company_info', 'company_info.company_id = product_info.company_id');
		$this->db->join('catagory_info', 'catagory_info.catagory_id = product_info.catagory_id');

		if($invoice_id!=0){$this->db->where('invoice_info.invoice_id',$invoice_id);} 
		if($company_id!=0){$this->db->where('product_info.company_id',$company_id);} 
		if($category_id!=0){$this->db->where('product_info.catagory_id',$category_id);} 
		if($customer_id!=0){$this->db->where('invoice_info.customer_id',$customer_id);} 
		if($product_id!=0){$this->db->where('product_info.product_id',$product_id);}
		if($seller_id!=0){$this->db->where('invoice_info.invoice_creator',$seller_id);}
		if($start_date!=0){$this->db->where('invoice_info.date >="'.$start_date.'"');}
		if($end_date!=0){$this->db->where('invoice_info.date <= "'.$end_date.'"');}
		$this->db->order_by('invoice_info.invoice_id','asc'); 
		$query = $this->db->get('invoice_info')->result();
		return $query;
	}

	public function get_sale_info_by_multi1($invoice_id='',$customer_id='',$seller_id='',$start_date='',$end_date='')
	{
		$this->db->select('users.username,customer_info.*,invoice_info.*, invoice_info.invoice_id as sid');
		$this->db->join('customer_info', 'invoice_info.customer_id = customer_info.customer_id');
		$this->db->join('users', 'users.id = invoice_info.invoice_creator');
		if($invoice_id!=0){$this->db->where('invoice_info.invoice_id',$invoice_id);} 
		if($seller_id!=0){$this->db->where('invoice_info.invoice_creator',$seller_id);}
		if($start_date!=0){$this->db->where('invoice_info.date >="'.$start_date.'"');}
		if($end_date!=0){$this->db->where('invoice_info.date <= "'.$end_date.'"');}
		$this->db->order_by('invoice_info.invoice_id','asc'); 
		$query = $this->db->get('invoice_info')->result();
		return $query;
	}


	/**************************************************
	 * Calculate Sale Price of a Specific date     **
	  * *********************************************/
	public function todays_sale($start,$end)
	{
		$query=$this->db->select_sum('transaction_info.amount')
						->from('transaction_info')
						->where('transaction_info.transaction_purpose = "sale"')
						->where('transaction_info.date >= "'.$start.'"')
						->where('transaction_info.date <= "'.$end.'"')
						->get();
		foreach($query -> result() as $result):
				$total_sale = $result->amount;
		endforeach;
		return $total_sale;
	}

	public function sale_return_info( $start, $end )
	{
		$query = $this->db->select_sum('transaction_info.amount')
							->from('transaction_info')
							->where('transaction_info.transaction_purpose = "sale_return"')
							->where('transaction_info.date >= "'.$start.'"')
							->where('transaction_info.date <= "'.$end.'"')
							->get();
		foreach($query -> result() as $result):
				$sale_return = $result->amount;
		endforeach;
		return $sale_return;
	}

	public function purchase_return_info( $start, $end )
	{
		$query = $this->db->select_sum('transaction_info.amount')
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

	public function todays_credit_collection_cash( $start, $end )
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

	public function cash_credit_collection_opening($start)
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

	public function bank_credit_collection_opening( $start)
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

	public function todays_credit_collection_bank( $start, $end )
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

	public function todays_purchase( $start, $end )
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

	public function todays_purchase_payment_cash( $start, $end )
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

	public function cash_purchase_payment_opening($start)
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

	public function bank_purchase_payment_opening($start)
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

	public function todays_purchase_payment_bank( $start, $end )
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

	public function todays_expense( $start, $end )
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

	public function todays_expense_payment_cash( $start, $end )
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

	public function cash_expense_payment_opening( $start)
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

	public function bank_expense_payment_opening( $start)
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

	public function todays_expense_payment_bank( $start, $end )
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

	public function todays_cash_book( $start, $end )
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

    /***********************************************************
	**************Fatch All Purchase Receipt ID*****************
	************************************************************/
    public function all_purchase_receipt()
	{
		$this->db->order_by("receipt_id", "desc");
		$query = $this -> db -> select('receipt_id, distributor_name,distributor_info.distributor_id')
							 -> from('purchase_receipt_info, distributor_info')
							 -> where('purchase_receipt_info.distributor_id = distributor_info.distributor_id')
							 -> where('shop_id', $this->tank_auth->get_shop_id())
							 -> get();
		return $query;
	}
	
	public function payable_receivable_financial_statement( $start ,  $end)
	{	
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
		$query_9 = $this -> db -> query("SELECT SUM( expense_info.expense_amount) AS total_expense_amount,
												SUM( CASE WHEN expense_type = 'Transport Cost For Purchase' THEN expense_amount END ) AS transport_cost, 
												SUM( CASE WHEN expense_type = 'Withdrawal' THEN expense_amount END ) AS total_withdrawal,
												SUM(CASE WHEN total_paid < expense_amount THEN expense_amount  END ) AS unpaid_grand_total,
												SUM(CASE WHEN total_paid < expense_amount THEN total_paid END ) AS total_paid_amount
											FROM expense_info
											WHERE expense_doc >= '".$start."'
											AND expense_doc <= '".$end."'
									    ");	
		$query_10 = $this -> db -> query("SELECT SUM(purchase_receipt_info.final_amount) AS total_purchase_amount,
												SUM( CASE WHEN purchase_receipt_info.receipt_status = 'unpaid'  THEN total_paid END ) AS total_paid_amount, 
												SUM( CASE WHEN purchase_receipt_info.receipt_status = 'unpaid'  THEN final_amount END ) AS unpaid_grand_total										
											FROM purchase_receipt_info
											WHERE receipt_date >= '".$start."'
											AND receipt_date <= '".$end."'
									    ");	
		$query_100 = $this -> db -> query("SELECT SUM(purchase_receipt_info.transport_cost) AS total_transport_amount,
												SUM( CASE WHEN purchase_receipt_info.receipt_status = 'unpaid'  THEN total_paid END ) AS total_paid_amount, 
												SUM( CASE WHEN purchase_receipt_info.receipt_status = 'unpaid'  THEN final_amount END ) AS unpaid_grand_total										
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
		);						
		return $query_final;							 
	}
	

	public function get_other_expense_details($start_date,$end_date){

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

	/****************************************************
	 * Select Random Products lower Then Alarming level *
	 ****************************************************/
	public function product_under_alarming_level()
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
		$query = $this -> db ->get();
		return $query;
	}



	public function get_warranty_stock_info_by_multi()
	{
		$catagory_name= '';$this->input->post('catagory_name');
		$product_id= 1446;$this->input->post('product_id');
		$company_name='';$this->input->post('company_name');
		$category1 = rawurldecode($catagory_name);
		$company1 = rawurldecode($company_name);
		$this->db->select('product_name, company_id, catagory_id, product_info.product_id, bulk_unit_sale_price,general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_info.product_specification,product_type,product_size');
		$this->db->from('product_info,bulk_stock_info');
		$this->db->where('product_info.product_id = bulk_stock_info.product_id');
		$this->db->where('product_info.product_specification=2'); 
		if($product_id!=''){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
		if($category1!=''){$this->db->where('product_info.catagory_id = "'.$category1.'" ');}
		if($company1!=''){$this->db->where('product_info.company_id = "'.$company1.'" ');}
		$this->db->order_by('product_info.product_id','asc'); 
		$this->db->order_by('product_info.product_name','asc'); 
		$query = $this->db->get();
		return $query;
	}

	public function get_warranty_stock($product_id)
	{
		$this->db->select('*');
		$this->db->from('warranty_product_list');
		$this->db->where('warranty_product_list.product_id = "'.$product_id.'" ');
		$this->db->group_by('warranty_product_list.ip_id'); 
		$this->db->order_by('warranty_product_list.ip_id','asc'); 
		$query = $this->db->get();
		return $query;
	} 
	
	public function get_damage_info_by_multi()
	{
		$pro_id= $this->input->post('pro_id');
		$catagory_id= $this->input->post('catagory_id');
		$company_id=$this->input->post('company_id');
		$start_date=$this->input->post('start_date');
		$end_date=$this->input->post('end_date');
		$end_date=date("Y-m-d",strtotime($end_date.'+1 day'));
		$this->db->select('product_info.product_id,product_info.product_name, product_info.company_id, product_info.catagory_id,damage_product.damage_id,damage_product.damage_quantity,damage_product.doc,damage_product.unit_buy_price');
		$this->db->from('damage_product,product_info');
		$this->db->where('product_info.product_id = damage_product.product_id');
		if($pro_id!=''){$this->db->where('product_info.product_id',$pro_id);}
		if($catagory_id!=''){$this->db->where('product_info.catagory_id',$catagory_id);}
		if($company_id!=''){$this->db->where('product_info.company_id',$company_id);}
		if($start_date!=''){$this->db->where('damage_product.doc >= "'.$start_date.'"');}
		if($end_date!=''){$this->db->where('damage_product.doc <= "'.$end_date.'"');}
		$query = $this->db->get();
		return $query;	
	} 	
	
	public function print_data_damage()
	{
		$pro_id = $this->uri->segment(3);
		$catagory_name = $this->uri->segment(4);
		$company_name = $this->uri->segment(5);
		$start_date = $this->uri->segment(6);
		$end_date = $this->uri->segment(7);
		$end_date=date("Y-m-d",strtotime($end_date."+1 day"));
		$category1 = rawurldecode($catagory_name);
		$company1 = rawurldecode($company_name);
		$this->db->select('product_info.product_id,product_info.product_name, product_info.company_id, product_info.catagory_id,damage_product.damage_id,damage_product.damage_quantity,damage_product.doc,damage_product.unit_buy_price');
		$this->db->from('damage_product,product_info');
		$this->db->where('product_info.product_id = damage_product.product_id');
		if($pro_id!='' && $pro_id!= 'null'){$this->db->where('product_info.product_id',$pro_id);}
		if($category1!='' && $category1!= 'null'){$this->db->where('product_info.catagory_id',$category1);}
		if($company1!='' && $company1!= 'null'){$this->db->where('product_info.company_id',$company1);}
		if($start_date!='' && $start_date!= 'null'){$this->db->where('damage_product.doc >= "'.$start_date.'"');}
		if($end_date!='' && $end_date!= 'null'){$this->db->where('damage_product.doc <= "'.$end_date.'"');}
		else if($start_date!='' && $start_date!= 'null'){$this->db->where('damage_product.doc <= "'.$start_date.'"');}
		$this->db->group_by('damage_product.damage_id');
		$this->db->order_by('damage_product.damage_id','asc'); 
		$this->db->order_by('damage_product.doc','asc'); 
		$query = $this->db->get();
		return $query;	
	}	

	public function get_delivery_charge_info_by_multi()
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

	public function get_return_info_by_multi()
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
	
	public function get_purchase_return_info_by_multi($distributor_id,$start_date,$end_date)
	{
		$this->db->select("product_info.product_id,product_info.product_name,distributor_info.distributor_name,purchase_return_main_product.*");
		$this->db->from("distributor_info,product_info,purchase_return_main_product");
		$this->db->where("purchase_return_main_product.produ_id=product_info.product_id");
		$this->db->where("purchase_return_main_product.distri_id=distributor_info.distributor_id");

		if($distributor_id!='' && $distributor_id!='null'){$this->db->where('purchase_return_main_product.distri_id',$distributor_id);}
		if($start_date!='' && $start_date!='null'){$this->db->where('purchase_return_main_product.doc >= "'.$start_date.'"');}
		if($end_date!='' && $end_date!='null'){$this->db->where('purchase_return_main_product.doc <= "'.$end_date.'"');}
		else if($start_date!='' && $start_date!='null'){$this->db->where('purchase_return_main_product.doc <= "'.$start_date.'"');}

		$this->db->group_by('purchase_return_main_product.prmp_id');
		$this->db->order_by('purchase_return_main_product.prmp_id','asc'); 
		$this->db->order_by('purchase_return_main_product.doc','asc'); 
		$query = $this->db->get();
		
		return $query;	
	}

	public function return_warranty_product($produ_id,$prmp_id)
	{
		$this->db->select("*");
		$this->db->from("purchase_return_warranty_product");
		$this->db->where("purchase_return_warranty_product.prmp_id",$prmp_id);
		$this->db->where("purchase_return_warranty_product.product_id",$produ_id);
		$this->db->group_by('purchase_return_warranty_product.prwp_id');
		$query = $this->db->get();
		return $query;
	}

	public function get_expense_info_by_multi()
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

	public function get_expense_info_by_multi_new()
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

	public function get_credit_collection_info_by_multi()
	{
		$start_date=$this->input->post('start_date');
		$end_date=$this->input->post('end_date');
		$this->db->select('*');
		$this->db->from('transaction_info,customer_info,users');
		$this->db->where('transaction_info.ledger_id = customer_info.customer_id');
		$this->db->where('transaction_info.creator = users.id');
		$this->db->where('transaction_info.transaction_purpose = "credit_collection"');
		if($start_date!=''){$this->db->where('transaction_info.date >= "'.$start_date.'"');}
		if($end_date!=''){$this->db->where('transaction_info.date <= "'.$end_date.'"');}
		else if($start_date!=''){$this->db->where('transaction_info.date <= "'.$start_date.'"');}
		$this->db->order_by('transaction_info.transaction_id','asc'); 
		$this->db->order_by('transaction_info.date','asc'); 
		$query = $this->db->get();
		return $query;	
	} 	
	
	public function all_credit_collection()
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
	/***************************************************
	* Calculate Purchase Amount of Specific date      **
	* **************************************************/
	public function specific_date_purchase_amount_calculation( $start, $end )
	{
		$query = $this -> db -> select( 'SUM( final_amount + transport_cost ) AS grand_total' )
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

	public function specific_date_buy_price_calculation( $start, $end  )
	{
		$query = $this -> db -> select( 'unit_buy_price,sale_quantity' )
							 -> from('sale_details,invoice_info')
							 -> where('invoice_doc >= "'.$start.'"')
							 -> where('invoice_doc <= "'.$end.'"')
							 -> where('invoice_info.invoice_id = sale_details.invoice_id' )
							 -> where('shop_id', $this->tank_auth->get_shop_id())
							 -> get();
		$total_buy=0;
		foreach($query -> result() as $result):
				$total_buy = $result -> unit_buy_price * $result -> sale_quantity + $total_buy;
		endforeach;
		return $total_buy;
	}
	
}