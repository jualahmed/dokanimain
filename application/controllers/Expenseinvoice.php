<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Expenseinvoice extends CI_controller{
	public function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$data['user_type'] = $this->tank_auth->get_usertype();
	}

	public function is_logged_in()
	{
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login');
		}
	}
	

	function generate_invoice( $invoice_id )
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		
		$data['running_my_sales']       = $this -> sale_model -> running_my_sales($this->tank_auth->get_user_id(), $this->tank_auth->get_shop_id());
		$data['currrent_temp_sale_id']  = $this -> tank_auth -> get_current_temp_sale();
		
		$this -> tank_auth -> set_current_temp_sale('');
		if($this -> input -> post('invoice_id'))
			$invoice_id = $this -> input -> post('invoice_id');
		else if($this ->uri -> segment(4))
			$invoice_id = $this ->uri -> segment(4);	
		
		$data['invoice_details'] = $this -> expense_invoice_model -> get_invoice_details( $invoice_id );
		if( $data['invoice_details'] -> num_rows < 1 )
			redirect('Report/old_invoice/no_invoice_found');
		$data['invoiceSoldProduct'] = $this -> expense_invoice_model -> invoiceSoldProduct($invoice_id);
		$data['individual_product'] = $this -> expense_invoice_model -> get_individual_details($invoice_id);
		$data['individual_product_stock_id'] = $this -> expense_invoice_model -> get_individual_stock_id( $data['individual_product'] , $invoice_id);
		$data['bulk_product'] = $this -> expense_invoice_model ->get_bulk_details( $invoice_id );
		
		foreach($data['invoice_details'] -> result() as $field):
				$data['invoice_creator'] = $field -> invoice_creator;
				$data['customer_name'] = $field -> customer_name;
				$data['customer_contact_no'] = $field -> customer_contact_no;
				$data['customer_address'] = $field -> customer_address;
				$data['invoice_doc'] = $field -> invoice_doc;
				$data['total_price'] = $field -> total_price;
				$data['total_paid'] = $field -> total_paid;
				$data['total_due'] = $field -> grand_total - $field -> total_paid;
				$data['grand_total'] = $field -> grand_total;
				$data['return_money'] = $field -> return_money;
			    $data['show_discount'] = $field -> discount;
				$data['cash_commision'] = $field -> cash_commision;
				$data['discount_type'] = $field -> discount_type;
				$data['discount_amount'] = $field -> discount_amount;
				$data['customer_id'] = $field -> cus_id;
		endforeach;
		if(!$data['total_price']) $temp_total_price = 1;
		else $temp_total_price = $data['total_price'];
		//$data['discount'] = ( $data['show_discount'] * 100.00 ) / $temp_total_price;
		$data['invoice_id'] = $invoice_id;
		/*if($data['discount'] > 0)
		{
			$data['nil_discount'] = ( 100.00 / ( 100.00 - $data['discount'] )); 
		}
		else*/ $data['nil_discount'] = 1;
		$data['number_to_text'] = $this -> expense_invoice_model -> convert_number_to_words( $data['grand_total'] );
		
		
		$data['status'] = '';
		$data['discount_on'] = false;
		$data['sale_status'] = '';
		$data['alarming_level'] = FALSE;
		$data['main_content'] = 'invoice_view';
		$data['tricker_content'] = 'tricker_sale_view';
		$this -> load -> view('include/template', $data);
		//$this -> load -> view('invoice_view', $data);
	}


	function print_invoice()
	{
		$invoice_id = $this -> uri -> segment(3);
		//$invoice_id = $this -> input -> post('invoice_id');
		$data['individual_product'] = $this -> expense_invoice_model -> get_individual_details($invoice_id);
		$data['invoiceSoldProduct'] = $this -> expense_invoice_model -> invoiceSoldProduct($invoice_id);
		$data['individual_product_stock_id'] = $this -> expense_invoice_model -> get_individual_stock_id( $data['individual_product'] , $invoice_id);
		$data['bulk_product'] = $this -> expense_invoice_model ->get_bulk_details( $invoice_id );
		$data['invoice_details'] = $this -> expense_invoice_model -> get_invoice_details( $invoice_id );
		foreach($data['invoice_details'] -> result() as $field):
				$data['invoice_creator'] = $field -> invoice_creator;
				$data['customer_name'] = $field -> customer_name;
				$data['customer_contact_no'] = $field -> customer_contact_no;
				$data['customer_address'] = $field -> customer_address;
				$data['invoice_doc'] = $field -> invoice_doc;
				$data['total_price'] = $field -> total_price;
				$data['total_paid'] = $field -> total_paid;
				$data['total_due'] = $field -> grand_total - $field -> total_paid;
				$data['grand_total'] = $field -> grand_total;
			    $data['show_discount'] = $field -> discount;
		endforeach;
		$data['discount'] = ( $data['show_discount'] * 100.00 ) / $data['total_price'];
		$data['invoice_id'] = $invoice_id;
		/*if($data['discount'] > 0)
		{
			$data['nil_discount'] = ( 100.00 / ( 100.00 - $data['discount'] )); 
		}
		else*/ $data['nil_discount'] = 1;
		$data['number_to_text'] = $this -> expense_invoice_model -> convert_number_to_words( $data['grand_total'] );
		$this -> load -> view('invoice_print_view', $data);
		//redirect('sale_controller/sale');

	}

	function print_pos_invoice()
	{
		$this -> tank_auth -> set_current_temp_sale('');
	
		$invoice_id = $this -> uri -> segment(3);
		//$invoice_id = $this -> input -> post('invoice_id');
		$data['individual_product'] = $this -> expense_invoice_model -> get_individual_details($invoice_id);
		$data['invoiceSoldProduct'] = $this -> expense_invoice_model -> invoiceSoldProduct($invoice_id);
		$data['individual_product_stock_id'] = $this -> expense_invoice_model -> get_individual_stock_id( $data['individual_product'] , $invoice_id);
		$data['bulk_product'] = $this -> expense_invoice_model ->get_bulk_details( $invoice_id );
		$data['invoice_details'] = $this -> expense_invoice_model -> get_invoice_details( $invoice_id );
		foreach($data['invoice_details'] -> result() as $field):
				$data['invoice_creator'] = $field -> username;
				$data['customer_name'] = $field -> customer_name;
				$data['customer_contact_no'] = $field -> customer_contact_no;
				$data['customer_address'] = $field -> customer_address;
				$data['invoice_doc'] = $field -> invoice_doc;
				$data['total_price'] = $field -> total_price;
				$data['total_paid'] = $field -> total_paid;
				$data['total_due'] = $field -> grand_total - $field -> total_paid;
				$data['grand_total'] = $field -> grand_total;
				$data['return_money'] = $field -> return_money;
				$data['show_discount'] = $field -> discount;
				$data['cash_commision'] = $field -> cash_commision;
				$data['discount_type'] = $field -> discount_type;
				$data['discount_amount'] = $field -> discount_amount;
		endforeach;
		$data['discount'] = ( $data['show_discount'] * 100.00 ) / $data['total_price'];
		$data['invoice_id'] = $invoice_id;
		/*if($data['discount'] > 0)
		{
			$data['nil_discount'] = ( 100.00 / ( 100.00 - $data['discount'] )); 
		}
		else*/ $data['nil_discount'] = 1;
		$data['number_to_text'] = $this -> expense_invoice_model -> convert_number_to_words( $data['grand_total'] );
		$this -> load -> view('pos_invoice_print_view', $data);
		//redirect('sale_controller/sale');

	}
	
	function print_price_quotation()
	{
		$temp_invoice_id = $this -> uri -> segment(3);
		if($temp_invoice_id == ''){
			$temp_invoice_id = $this -> tank_auth -> get_current_temp_sale();
		}
		$data['invoiceSoldProduct'] = $this -> expense_invoice_model -> invoiceTempProduct($temp_invoice_id);
		$data['invoice_details'] = $this -> expense_invoice_model -> get_temporary_invoice_details( $temp_invoice_id );
		foreach($data['invoice_details'] -> result() as $field):
				$data['invoice_creator'] = $field -> username;
				$data['invoice_doc'] = $field -> temp_sale_doc;
				$data['invoice_id'] = $field -> temp_sale_id;
				$data['grand_total'] = $field -> grand_total;
		endforeach;
		$data['nil_discount'] = 1;
		$data['number_to_text'] = $this -> expense_invoice_model -> convert_number_to_words( $data['grand_total'] );
		
		$this -> sale_model -> my_sale_cancle($temp_invoice_id);
		$this -> tank_auth -> set_current_temp_sale('');
		
		$this -> load -> view('price_quotation_view', $data);
	}

    function type_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'expense_invoice_controller', 'expense_type_entry'))
		{
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['alarming_level'] = FALSE;
			//$data['main_content'] = 'type_entry_form_view';
			//$data['tricker_content'] = 'tricker_account_view';
			$this -> load -> view('type_entry_form_view', $data);
		}
		else redirect('account/account/noaccess');
	 }
	
}
