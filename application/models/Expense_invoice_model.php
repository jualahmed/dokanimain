<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

	class Expense_invoice_model extends CI_model{
		
		
		function invoiceSoldProduct($invoiceId){
			$this -> db -> order_by("product_name", "asc");
			$this -> db -> select('* , SUM(sale_quantity) AS sale_quantity_sum');
			$this -> db -> from('sale_details, product_info');
			$this -> db -> where('product_info.product_id = sale_details.product_id');
			$this -> db -> where('sale_details_status', 1);
			$this -> db -> where('sale_details.invoice_id = "'.$invoiceId.'"');
			$this -> db -> group_by('sale_details.sale_details_id');
			return $this -> db -> get();
		}
		
		
		function invoiceTempProduct($invoiceId){
			$this -> db -> order_by("product_name", "asc");
			$this -> db -> select('* , SUM(sale_quantity) AS sale_quantity_sum');
			$this -> db -> from('temp_sale_info, product_info,temp_sale_details');
			$this -> db -> where('product_info.product_id = temp_sale_details.product_id');
			$this -> db -> where('temp_sale_details.temp_sale_details_status', 1);
			$this -> db -> where('temp_sale_info.temp_sale_id = temp_sale_details.temp_sale_id');
			$this -> db -> where('temp_sale_info.temp_sale_id = "'.$invoiceId.'"');
			$this -> db -> group_by('product_info.product_id');
			return $this -> db -> get();
		}
		
		/***************************************************
		 * Fatch individul Product Id For Individual Product
		 ***************************************************/
		function get_individual_details($invoice_id)
		{
			$query = $this ->db -> select('product_name,  sale_details.unit_sale_price, sale_details.unit_buy_price,
										   product_info.product_id, count( product_info.product_name ) as number_of_quantity')
				                -> from('product_info, purchase_info, stock_info,invoice_info, sale_details')
								-> where('product_info.product_id = purchase_info.product_id')
								-> where('stock_info.purchase_id = purchase_info.purchase_id')
								-> where('stock_info.stock_id = sale_details.stock_id')
								-> where('sale_details.product_specification = "individual"')
								-> where('invoice_info.shop_id', $this->tank_auth->get_shop_id())
								-> where('sale_details.invoice_id = "'.$invoice_id.'"')
								-> group_by('product_info.product_id')
								-> get();
			return $query;
		}
		
		/*************************************************
		 * Make All The Sold Product Stock Id as A String
		 ************************************************/
		 function get_individual_stock_id( $stock_sale , $invoice_id)
		 {
		 	//$index = 0;
		 	foreach( $stock_sale -> result() as $field ):
				$product_id = $field -> product_id;
				$query = $this -> db -> select('sale_details.stock_id, stock_info.serial_no')
									 -> from('sale_details, stock_info ,invoice_info,purchase_info,product_info')
									 -> where('stock_info.stock_id = sale_details.stock_id')
									 -> where('stock_info.purchase_id = purchase_info.purchase_id')
									 -> where('product_info.product_id = purchase_info.product_id')
									 -> where('invoice_info.shop_id', $this->tank_auth->get_shop_id())
									 -> where('sale_details.product_specification = "individual"')
									 -> where('product_info.product_id = "'.$product_id.'"')
									 -> where('invoice_info.invoice_id = "'.$invoice_id.'"')
									 -> get();
				$data[ $product_id ] = 'S/I : ';
				foreach($query -> result() as $string):
					//$data[ $product_id ] = $data[ $product_id ].''.$string -> stock_id.', ';
					$data[ $product_id ] = $data[ $product_id ].''.$string -> stock_id.', ';
				endforeach;
				//$index++;
			endforeach;
			
			if($stock_sale -> num_rows > 0 ) return $data;
		 }
		 
		 /***********************************
		  * Get All bulk Sale Of An Invoice
		  ***********************************/
		  function get_bulk_details( $invoice_id )
		  {

/******************** 	Previous Query
							$query = $this ->db -> select('product_name,  sale_details.unit_sale_price, sale_details.unit_buy_price,
											   product_info.product_id, count( sale_details.stock_id ) as number_of_quantity')
									-> from('product_info , sale_details,invoice_info')
									-> where('sale_details.invoice_id = "'.$invoice_id.'"')
									-> where('invoice_info.shop_id', $this->tank_auth->get_shop_id())
									-> where('sale_details.invoice_id = invoice_info.invoice_id')
									-> where('product_info.product_id = sale_details.product_id')
									-> where('sale_details.product_specification = "bulk"')
									-> group_by('sale_details.stock_id')
									-> get();
        Current Query By Kawsar Ahmed****************************/
		  
				$query = $this ->db -> select('product_name,  sale_details.unit_sale_price, sale_details.unit_buy_price,
											   product_info.product_id, sale_details.sale_quantity as number_of_quantity')
									-> from('product_info , sale_details,invoice_info')
									-> where('sale_details.invoice_id = "'.$invoice_id.'"')
									-> where('invoice_info.shop_id', $this->tank_auth->get_shop_id())
									-> where('sale_details.invoice_id = invoice_info.invoice_id')
									-> where('product_info.product_id = sale_details.product_id')
									-> where('sale_details.product_specification = "bulk"')
									-> group_by('sale_details.product_id')
									-> get();
				/* $row=$query->result_array();
				print_r($row); */
				return $query;
		  }
		  
		  /**************************************
		   * Get All details Of a Specific invoice 
		   **************************************/
		   function get_invoice_details( $invoice_id )
		   {
			   $query = $this -> db -> select('invoice_id,total_price,discount,grand_total,total_paid,payment_mode,
			                                    invoice_creator,customer_name,customer_contact_no,customer_address,return_money,
			                                    invoice_doc,invoice_dom, point_discount, customer_info.customer_id AS cus_id, users.username, cash_commision, discount_type,discount_amount')
									-> from('invoice_info,customer_info,users')
									-> where('invoice_info.invoice_id = "'.$invoice_id.'"')
									-> where('invoice_info.shop_id', $this->tank_auth->get_shop_id())
									-> where('invoice_info.customer_id = customer_info.customer_id')
									-> where('invoice_info.invoice_creator = users.id')
									-> get();
				return $query;	    
		   }
		   
		   
		  /**************************************
		   * Get All details Of a Specific Temporary Invoice 
		   **************************************/
		   function get_temporary_invoice_details( $invoice_id )
		   {
			   $query = $this -> db -> select('temp_sale_info.*,users.*,SUM(temp_sale_details.actual_sale_price) AS grand_total')
									-> from('temp_sale_info,users,temp_sale_details')
									-> where('temp_sale_info.temp_sale_id = "'.$invoice_id.'"')
									-> where('temp_sale_info.temp_sale_shop_id', $this->tank_auth->get_shop_id())
									-> where('temp_sale_info.temp_sale_creator = users.id')
									-> where('temp_sale_info.temp_sale_id = temp_sale_details.temp_sale_id')
									-> get();
				return $query;	    
		   }
		 /*************************
		 * Convert Number To Text
		 *************************/
		 function convert_number_to_words( $number )
		 {
		    $hyphen      = '-';
		    $conjunction = ' AND ';
		    $separator   = ', ';
		    $negative    = 'NEGATIVE ';
		    $decimal     = ' POINT ';
		    $dictionary  = array(
		        0                   => 'ZERO',
		        1                   => 'ONE',
		        2                   => 'TWO',
		        3                   => 'THREE',
		        4                   => 'FOUR',
		        5                   => 'FIVE',
		        6                   => 'SIX',
		        7                   => 'SEVEN',
		        8                   => 'EIGHT',
		        9                   => 'NINE',
		        10                  => 'TEN',
		        11                  => 'ELEVEN',
		        12                  => 'TWELVE',
		        13                  => 'THIRTEEN',
		        14                  => 'FOURTEEN',
		        15                  => 'FIFTEEN',
		        16                  => 'SIXTEEN',
		        17                  => 'SEVENTEEN',
		        18                  => 'EIGHTEEN',
		        19                  => 'NINETEEN',
		        20                  => 'TWENTY',
		        30                  => 'THIRTY',
		        40                  => 'FOURTY',
		        50                  => 'FIFTY',
		        60                  => 'SIXTY',
		        70                  => 'SEVENTY',
		        80                  => 'EIGHTY',
		        90                  => 'NINETY',
		        100                 => 'HUNDRED',
		        1000                => 'THOUSAND',
		        1000000             => 'MILLION',
		        1000000000          => 'BILLION',
		        1000000000000       => 'TRILLION',
		        1000000000000000    => 'QUADRILLION',
		        1000000000000000000 => 'QUINTILLION'
		    );
		   
		    if (!is_numeric($number)) {
		        return false;
		    }
		   
		    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
		        // overflow
		        trigger_error(
		            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
		            E_USER_WARNING
		        );
		        return false;
		    }
		
		    if ($number < 0) {
		        return $negative . $this -> convert_number_to_words(abs($number));
		    }
		   
		    $string = $fraction = null;
		   
		    if (strpos($number, '.') !== false) {
		        list($number, $fraction) = explode('.', $number);
		    }
		   
		    switch (true) {
		        case $number < 21:
		            $string = $dictionary[$number];
		            break;
		        case $number < 100:
		            $tens   = ((int) ($number / 10)) * 10;
		            $units  = $number % 10;
		            $string = $dictionary[$tens];
		            if ($units) {
		                $string .= $hyphen . $dictionary[$units];
		            }
		            break;
		        case $number < 1000:
		            $hundreds  = $number / 100;
		            $remainder = $number % 100;
		            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
		            if ($remainder) {
		                $string .= $conjunction . $this -> convert_number_to_words($remainder);
		            }
		            break;
		        default:
		            $baseUnit = pow(1000, floor(log($number, 1000)));
		            $numBaseUnits = (int) ($number / $baseUnit);
		            $remainder = $number % $baseUnit;
		            $string = $this -> convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
		            if ($remainder) {
		                $string .= $remainder < 100 ? $conjunction : $separator;
		                $string .= $this -> convert_number_to_words($remainder);
		            }
		            break;
		    }
		   
		    if (null !== $fraction && is_numeric($fraction)) {
		        $string .= $decimal;
		        $words = array();
		        foreach (str_split((string) $fraction) as $number) {
		            $words[] = $dictionary[$number];
		        }
		        $string .= implode(' ', $words);
		    }
		   
		    return $string;
		}
        
        
		/* to fatch all expense id*/
		function fatch_all_expense_id_for_transaction_purpose()
		{
			$query_2 = $this -> db -> select('expense_type,expense_id')
			                     -> from('expense_info')
			                     -> where('total_paid < expense_amount')
			                     -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
								 
				$data[''] =  'Select An ID';				 
				foreach ($query_2 -> result() as $field_2)
				{	
					$expense_type = $field_2 -> expense_type;
					$expense_id = $field_2 -> expense_id;
					
					if($expense_type != 'Transport Cost For Purchase')
					{
						$this->db->order_by("expense_id", "asc");
						$query = $this -> db -> select('expense_id,expense_type,expense_amount,service_provider_info.service_provider_name as username')
											 -> from('expense_info,service_provider_info')
											 -> where('total_paid < expense_amount')
											 -> where('expense_info.service_provider_id = service_provider_info.service_provider_id')
											 -> where('expense_id = "'.$expense_id.'"')
											 -> where('expense_info.shop_id', $this->tank_auth->get_shop_id())
											 -> get();
											 
						
						foreach ($query -> result() as $field)
						{
							 $segment_3 = $this -> uri -> segment(3);
							 //~ $data[base_url().'index.php/account/transaction_entry/'.$segment_3.'/expense/'.$field->expense_id] = $field -> expense_id.
											//~ ' ( '.'# ' .$field -> expense_type. ' )'.' Name: ( '.': ' .$field -> service_provider_name. ' )';
							$data[base_url().'index.php/account/transaction_entry/'.$segment_3.'/expense/'.$field->expense_id] = $field -> expense_type.' : ( '.$field -> username. ' ) '.' Amount: '.$field -> expense_amount;
						}
					
					}
					else
					{
						$this->db->order_by("expense_id", "asc");
						$query = $this -> db -> select('expense_id,expense_type,service_provider_id')
											 -> from('expense_info')
											 -> where('total_paid < expense_amount')
											 -> where('expense_id = "'.$expense_id.'"')
											 -> where('shop_id', $this->tank_auth->get_shop_id())
											 -> get();
											 
						//$data[''] =  'Select An ID';
						
						foreach ($query -> result() as $field)
						{
							 $segment_3 = $this -> uri -> segment(3);
							 //~ $data[base_url().'index.php/account/transaction_entry/'.$segment_3.'/expense/'.$field->expense_id] = $field -> expense_id.
											//~ ' ( '.'# ' .$field -> expense_type. ' ) '.' Receipt ID: ( '.$field -> service_provider_id. ' )'; 
							 $data[base_url().'index.php/account/transaction_entry/'.$segment_3.'/expense/'.$field->expense_id] = $field -> expense_type.' Receipt ID: ( '.'# ' .$field -> service_provider_id. ' )'.' ID: '.$field -> expense_id;
						}
					}
				}
				return $data;
		}
		
		/* to fatch all invoice id which are still due*/
        function fatch_all_invoiceID_not_paid_yet_for_transaction_purpose()
        {
			$this->db->order_by("invoice_id", "asc");
			$query = $this -> db -> select('invoice_id,customer_name,customer_address,customer_contact_no,grand_total,total_paid,invoice_creator,invoice_doc')
			                     -> from('invoice_info,customer_info')
			                     -> where('customer_info.customer_id = invoice_info.customer_id')
			                     -> where('total_paid < grand_total')
			                     -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
								 					 
			$data[''] =  'Select An ID';
			foreach ($query -> result() as $field)
			{
				$segment_3 = $this -> uri -> segment(3);
				//$data[base_url().'index.php/account/transaction_entry/'.$segment_3.'/sale/'.$field->invoice_id] = $field -> invoice_id;
				$data[base_url().'index.php/account/transaction_entry/'.$segment_3.'/sale/'.$field->invoice_id] = $field -> invoice_id
								.nbs(5).' ( Name: ' .$field -> customer_name. ' )'.nbs(5).'Contact :  ( '.$field -> customer_contact_no. ' )';
			}

			return $data;
			
		}
				/* to fatch all invoice id which are still due*/
        function fatch_all_customerID_not_paid_yet_for_transaction_purpose()
        {
			$this->db->order_by("customer_info.customer_id", "asc");
			$query = $this -> db -> select('invoice_id,customer_info.customer_id,customer_name,customer_address,customer_contact_no,grand_total,total_paid,invoice_creator,invoice_doc')
			                     -> from('invoice_info,customer_info')
			                     -> where('customer_info.customer_id = invoice_info.customer_id')
			                     -> where('total_paid < grand_total')
			                     -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> group_by('invoice_info.customer_id')
								 -> get();
								 					 
			$data[''] =  'Select A Customer';
			foreach ($query -> result() as $field)
			{
				$segment_3 = $this -> uri -> segment(3);
				//$data[base_url().'index.php/account/transaction_entry/'.$segment_3.'/sale/'.$field->invoice_id] = $field -> invoice_id;
				$data[base_url().'index.php/account/transaction_entry/'.$segment_3.'/sale_customer/'.$field->customer_id] = $field -> customer_id
								.nbs(5).' ( Name: ' .$field -> customer_name. ' )'.nbs(5).'Contact :  ( '.$field -> customer_contact_no. ' )';
			}

			return $data;
			
		}
		/* this will fatch reamining due of a specific Customers*/
		function fatch_all_reamaining_due_list_for_specific_customer($customer_id)
		{
			$query = $this -> db -> select('customer_name,customer_address,invoice_info.customer_id')
								 -> select_sum('grand_total')
								 -> select_sum('total_paid')
			                     -> from('invoice_info,customer_info')
			                     -> where('total_paid < grand_total')
								 -> where('invoice_info.customer_id = "'.$customer_id.'" ')
								 -> where('customer_info.customer_id = invoice_info.customer_id')
			                     -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
		    if($query->num_rows() > 0){
				$row = $query->row_array();
				$total_due = $row['grand_total'] - $row['total_paid'];
				return $total_due;
			}
			else{
				return 0;
			}
		}
		
		/* this will fatch reamining due of a specific Customers*/
		function reamaining_due_invoice_list_for_specific_customer($customer_id)
		{
			$query = $this -> db -> select('invoice_id, customer_name, grand_total, total_paid, customer_address,   invoice_info.customer_id')
			                     -> from('invoice_info,customer_info')
			                     -> where('total_paid < grand_total')
								 -> where('invoice_info.customer_id = "'.$customer_id.'" ')
								 -> where('customer_info.customer_id = invoice_info.customer_id')
			                     -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> order_by('invoice_info.invoice_doc','asc')
								 -> get();
		   /*  if($query->num_rows() > 0){
				$row = $query->row_array();
				$total_due = $row['grand_total'] - $row['total_paid'];
				return $total_due;
			}
			else{
				return 0;
			} */
			
			return $query;
		}
		/* this will fatch reamining due of All Customers*/
		function fatch_all_reamaining_due_list_for_customer()
		{
			$creator = $this->tank_auth->get_user_id();
		
			$query = $this -> db -> select('customer_name,customer_address,invoice_info.customer_id')
								 -> select_sum('grand_total')
								 -> select_sum('total_paid')
			                     -> from('invoice_info,customer_info')
			                     //-> where('payment_mode = "credit" ')
			                     //-> where('invoice_id = "'.$invoice_id.'"')
			                     -> where('total_paid < grand_total')
								 -> where('customer_info.customer_id = invoice_info.customer_id')
			                     -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> group_by('customer_info.customer_id')
								 -> get();
		    return $query;		
		}
		
		/* this will fatch reamining due of a specific invoice id*/
		function fatch_invoice_reamaining_due( $invoice_id)
		{
			$creator = $this->tank_auth->get_user_id();	
			//echo $invoice_id;
		
			$query = $this -> db -> select('invoice_id,grand_total,total_paid')
			                     -> from('invoice_info')
			                     //-> where('payment_mode = "credit" ')
			                     -> where('invoice_id = "'.$invoice_id.'"')
			                     -> where('total_paid < grand_total')
			                     -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
			
			/*$due_amount = 0;					 
			if($query -> num_rows() >0)
			{
				foreach($query -> result() as $field):
				   $due_amount = $field -> grand_total - $field -> total_paid;
				endforeach;		           
			}*/
		    return $query;		
		}
		/* this will fatch reamining due of a specific expense id*/
		function fatch_expense_reamaining_due($expense_id )
	    {
		    $creator = $this->tank_auth->get_user_id();	
			
			$query = $this -> db -> select('expense_id,expense_amount,total_paid')
			                     -> from('expense_info')
			       			     -> where('expense_id = "'.$expense_id.'"')
			                     //-> where('total_paid < expense_amount')
			                     -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();	
			/*$due_amount = 0;					 
			if($query -> num_rows() >0)
			{
				foreach($query -> result() as $field):
				   $due_amount = $field -> expense_amount - $field -> total_paid;
				endforeach;		                 
			}*/
		    return $query;		
		}
		/* this will fatch reamining due of a specific purchase receipt id*/
		function fatch_purchase_reamaining_due_for_specific_purchase_receipt_id($purchase_receipt_id)
		{
		    $creator = $this->tank_auth->get_user_id();	
			//echo 'prct_id: '.$purchase_receipt_id;
			$query = $this -> db -> select('receipt_id,grand_total,total_paid')
			                     -> from('purchase_receipt_info')
			                     -> where('receipt_id = "'.$purchase_receipt_id.'"') 
			                     //-> where('total_paid < grand_total')
			                     -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();	
			/*$due_amount = 0;					 
			if($query -> num_rows() >0)
			{
				foreach($query -> result() as $field):
				   $due_amount = $field -> grand_total - $field -> total_paid;
				endforeach;		           
			}*/
		    return $query;	
		}
		/***************************************************
		 * delete_transaction_details_of_an_specific_invoice
		 ************************************************** */
		 /*function delete_transaction_details_of_an_specific_invoice($invoice_id)
		 {
			$query =  $this -> db -> query("SELECT transaction_ref_details_id 
											FROM transaction_ref_details
											WHERE ref_id = '".$invoice_id."'
											AND transaction_purpose = 'sale'	
								");	
			  
		    $query = $this -> db -> select('transaction_ref_details_id')
								   -> from('transaction_ref_details')
								   -> where('ref_id = "'.$invoice_id.'"')
								   -> where('transaction_purpose = "sale" ')
								   -> get();	
		
			if($query -> num_rows() >0)
			{
				foreach($query -> result() as $field):
				  echo  $transaction_reference_id = $field -> transaction_ref_details_id;
				endforeach;		           
			}
			$this -> db -> query("DELETE  FROM transaction_ref_details WHERE transaction_ref_details.ref_id = ".$invoice_id." ");	
			$this -> db -> query("DELETE  FROM transaction_details WHERE transaction_details.transaction_reference_id = ".$transaction_reference_id." ");	
			return true;				  
		 }*/
		 
		
		/* to fatch all invesment id*/
		function fatch_all_investment_id_for_transaction_purpose()
		{
			$this->db->order_by("investment_id", "asc");
			$query = $this -> db -> select('investment_id,investor_name,investor_contact_no')
			                     -> from('investor_info,investment_info')
			                     -> where('total_paid < investment_amount')
			                     -> where('investment_info.investor_id = investor_info.investor_id')
			                     -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();
								 
			$data[''] =  'Select An ID';
			foreach ($query -> result() as $field)
			{
				 $segment_3 = $this -> uri -> segment(3);
				 $data[base_url().'index.php/account/transaction_entry/'.$segment_3.'/investment/'.$field->investment_id] = $field -> investor_name. '  '.' Mob : '.$field -> investor_contact_no;
			}
			return $data;
		}
		/* this will fatch reamining due of a specific investment id*/
		function fatch_investment_remaining_due($investment_id )
	    {
		    $creator = $this->tank_auth->get_user_id();	
			
			$query = $this -> db -> select('investment_id,investment_amount,total_paid')
			                     -> from('investment_info')
			       			     -> where('investment_id = "'.$investment_id.'"')
			                     //-> where('total_paid < expense_amount')
			                     -> where('shop_id', $this->tank_auth->get_shop_id())
								 -> get();	
			/*$due_amount = 0;					 
			if($query -> num_rows() >0)
			{
				foreach($query -> result() as $field):
				   $due_amount = $field -> expense_amount - $field -> total_paid;
				endforeach;		                 
			}*/
		    return $query;		
		}
		
		/* this will fatch all investor information*/
		function fatch_all_investor_information()
		{
			$this->db->order_by("investor_id", "asc");
			$query = $this -> db -> select('*')
			                     -> from('investor_info')
								 -> get();	
								 
			$data[''] =  'Select An ID';
			foreach ($query -> result() as $field)
			{
				 $segment_3 = $this -> uri -> segment(3);
				 $data[base_url().'index.php/account/transaction_entry/'.$segment_3.'/Withdrawal/'.$field->investor_id] = $field -> investor_name. ' '.' Mob : '.$field -> investor_contact_no;
				 
			}					 
			return $data;
		}
		/* this will fatch all investor information by specific investor id*/
		function specific_investor_information($investor_id)
		{
			$query = $this -> db -> select('*')
			                     -> from('investor_info')
			                     -> where('investor_id = "'.$investor_id.'"')
								 -> get();	
								 
			return $query;
		}
		function get_invoice_details_customer( $customer_id )
		   {
			   $query = $this -> db -> select('invoice_info.invoice_id,total_price,invoice_info.discount,grand_total,total_paid,payment_mode,
			                                    invoice_creator,invoice_info.customer_id,customer_name,customer_contact_no,customer_address,return_money,
			                                    invoice_doc,invoice_dom, point_discount, customer_info.customer_id, users.username, cash_commision, invoice_info.discount_type,discount_amount,product_name, sale_details.unit_sale_price, sale_details.unit_buy_price,
											   product_info.product_id, sale_details.sale_quantity as number_of_quantity,sale_details.exact_sale_price')
									-> from('invoice_info,customer_info,users,product_info,sale_details')
									-> where('invoice_info.customer_id = "'.$customer_id.'"')
									-> where('invoice_info.shop_id', $this->tank_auth->get_shop_id())
									-> where('invoice_info.customer_id = customer_info.customer_id')
									-> where('product_info.product_id = sale_details.product_id')
									-> where('sale_details.invoice_id = invoice_info.invoice_id')
									-> where('invoice_info.invoice_creator = users.id')
									-> get();
				return $query;	
		   }
	}
		
