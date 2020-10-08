<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Expense_invoice_model extends CI_model{
	function invoiceSoldProduct($invoiceId)
	{
		$this->db->order_by("product_name", "asc");
		$this->db->select('* , SUM(sale_quantity) AS sale_quantity_sum');
		$this->db->from('sale_details, product_info');
		$this->db->where('product_info.product_id = sale_details.product_id');
		$this->db->where('sale_details_status', 1);
		$this->db->where('sale_details.invoice_id = "'.$invoiceId.'"');
		$this->db->group_by('sale_details.sale_details_id');
		return $this->db->get();
	}
	
	function invoiceTempProduct($invoiceId)
	{
		$this->db->order_by("product_name", "asc");
		$this->db->select('* , SUM(sale_quantity) AS sale_quantity_sum');
		$this->db->from('temp_sale_info, product_info,temp_sale_details');
		$this->db->where('product_info.product_id = temp_sale_details.product_id');
		$this->db->where('temp_sale_details.temp_sale_details_status', 1);
		$this->db->where('temp_sale_info.temp_sale_id = temp_sale_details.temp_sale_id');
		$this->db->where('temp_sale_info.temp_sale_id = "'.$invoiceId.'"');
		$this->db->group_by('product_info.product_id');
		return $this->db->get();
	}
	
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
	
	function get_individual_stock_id( $stock_sale , $invoice_id)
	{
	 	foreach( $stock_sale -> result() as $field ):
			$product_id = $field -> product_id;
			$query = $this->db->select('sale_details.stock_id, stock_info.serial_no')
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
				$data[ $product_id ] = $data[ $product_id ].''.$string -> stock_id.', ';
			endforeach;
		endforeach;
		if($stock_sale -> num_rows > 0 ) return $data;
	}
	 
	function get_bulk_details( $invoice_id )
	{
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
			return $query;
	}
	  
	function get_invoice_details( $invoice_id )
	{
	   $query = $this->db->select('invoice_id,total_price,discount,grand_total,total_paid,payment_mode,
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
	   
    function get_temporary_invoice_details( $invoice_id )
    {
	   $query = $this->db->select('temp_sale_info.*,users.*,SUM(temp_sale_details.actual_sale_price) AS grand_total')
							-> from('temp_sale_info,users,temp_sale_details')
							-> where('temp_sale_info.temp_sale_id = "'.$invoice_id.'"')
							-> where('temp_sale_info.temp_sale_shop_id', $this->tank_auth->get_shop_id())
							-> where('temp_sale_info.temp_sale_creator = users.id')
							-> where('temp_sale_info.temp_sale_id = temp_sale_details.temp_sale_id')
							-> get();
		return $query;	    
    }
    
	function fatch_all_expense_id_for_transaction_purpose()
	{
		$query_2 = $this->db->select('expense_type,expense_id')
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
					$query = $this->db->select('expense_id,expense_type,expense_amount,service_provider_info.service_provider_name as username')
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
					$query = $this->db->select('expense_id,expense_type,service_provider_id')
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
	
    function fatch_all_invoiceID_not_paid_yet_for_transaction_purpose()
    {
		$this->db->order_by("invoice_id", "asc");
		$query = $this->db->select('invoice_id,customer_name,customer_address,customer_contact_no,grand_total,total_paid,invoice_creator,invoice_doc')
		                     -> from('invoice_info,customer_info')
		                     -> where('customer_info.customer_id = invoice_info.customer_id')
		                     -> where('total_paid < grand_total')
		                     -> where('shop_id', $this->tank_auth->get_shop_id())
							 -> get();
		$data[''] =  'Select An ID';
		foreach ($query -> result() as $field)
		{
			$segment_3 = $this -> uri -> segment(3);
			$data[base_url().'index.php/account/transaction_entry/'.$segment_3.'/sale/'.$field->invoice_id] = $field -> invoice_id
							.nbs(5).' ( Name: ' .$field -> customer_name. ' )'.nbs(5).'Contact :  ( '.$field -> customer_contact_no. ' )';
		}
		return $data;
	}

    function fatch_all_customerID_not_paid_yet_for_transaction_purpose()
    {
		$this->db->order_by("customer_info.customer_id", "asc");
		$query = $this->db->select('invoice_id,customer_info.customer_id,customer_name,customer_address,customer_contact_no,grand_total,total_paid,invoice_creator,invoice_doc')
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

	function fatch_all_reamaining_due_list_for_specific_customer($customer_id)
	{
		$query = $this->db->select('customer_name,customer_address,invoice_info.customer_id')
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
	
	function reamaining_due_invoice_list_for_specific_customer($customer_id)
	{
		$query = $this->db->select('invoice_id, customer_name, grand_total, total_paid, customer_address,   invoice_info.customer_id')
		                     -> from('invoice_info,customer_info')
		                     -> where('total_paid < grand_total')
							 -> where('invoice_info.customer_id = "'.$customer_id.'" ')
							 -> where('customer_info.customer_id = invoice_info.customer_id')
		                     -> where('shop_id', $this->tank_auth->get_shop_id())
							 -> order_by('invoice_info.invoice_doc','asc')
							 -> get();
		return $query;
	}

	function fatch_all_reamaining_due_list_for_customer()
	{
		$creator = $this->tank_auth->get_user_id();
		$query = $this->db->select('customer_name,customer_address,invoice_info.customer_id')
							 -> select_sum('grand_total')
							 -> select_sum('total_paid')
		                     -> from('invoice_info,customer_info')
		                     -> where('total_paid < grand_total')
							 -> where('customer_info.customer_id = invoice_info.customer_id')
		                     -> where('shop_id', $this->tank_auth->get_shop_id())
							 -> group_by('customer_info.customer_id')
							 -> get();
	    return $query;		
	}
	
	function fatch_invoice_reamaining_due( $invoice_id)
	{
		$creator = $this->tank_auth->get_user_id();	
		$query = $this->db->select('invoice_id,grand_total,total_paid')
		                     -> from('invoice_info')
		                     -> where('invoice_id = "'.$invoice_id.'"')
		                     -> where('total_paid < grand_total')
		                     -> where('shop_id', $this->tank_auth->get_shop_id())
							 -> get();
	    return $query;		
	}

	function fatch_expense_reamaining_due($expense_id )
    {
	    $creator = $this->tank_auth->get_user_id();	
		$query = $this->db->select('expense_id,expense_amount,total_paid')
		                     -> from('expense_info')
		       			     -> where('expense_id = "'.$expense_id.'"')
		                     -> where('shop_id', $this->tank_auth->get_shop_id())
							 -> get();	
	    return $query;		
	}

	function fatch_purchase_reamaining_due_for_specific_purchase_receipt_id($purchase_receipt_id)
	{
	    $creator = $this->tank_auth->get_user_id();	
		$query = $this->db->select('receipt_id,grand_total,total_paid')
		                     -> from('purchase_receipt_info')
		                     -> where('receipt_id = "'.$purchase_receipt_id.'"') 
		                     -> where('shop_id', $this->tank_auth->get_shop_id())
							 -> get();	
	    return $query;	
	}

	function fatch_all_investment_id_for_transaction_purpose()
	{
		$this->db->order_by("investment_id", "asc");
		$query = $this->db->select('investment_id,investor_name,investor_contact_no')
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

	function fatch_investment_remaining_due($investment_id )
    {
	    $creator = $this->tank_auth->get_user_id();	
		$query = $this->db->select('investment_id,investment_amount,total_paid')
		                     -> from('investment_info')
		       			     -> where('investment_id = "'.$investment_id.'"')
		                     -> where('shop_id', $this->tank_auth->get_shop_id())
							 -> get();	
	    return $query;		
	}
	
	function fatch_all_investor_information()
	{
		$this->db->order_by("investor_id", "asc");
		$query = $this->db->select('*')
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

	function specific_investor_information($investor_id)
	{
		$query = $this->db->select('*')
		                     -> from('investor_info')
		                     -> where('investor_id = "'.$investor_id.'"')
							 -> get();	
		return $query;
	}

	function get_invoice_details_customer( $customer_id )
    {
	   $query = $this->db->select('invoice_info.invoice_id,total_price,invoice_info.discount,grand_total,total_paid,payment_mode,
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
		
