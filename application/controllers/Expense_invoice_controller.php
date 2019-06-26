<<<<<<< HEAD
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Expense_invoice_controller extends CI_controller{
		public function __construct()
		{
			parent::__construct();
			$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
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
		
		/*************************************** 
		 * Creating An Invoice for Print Purpose
		 ***************************************/
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
				redirect('report_controller/old_invoice/no_invoice_found');
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

		/***********************************
		 * Print A Copy of Invoice
		 ***********************************/
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
		/***********************************
		 * Print A Copy of Invoice
		 ***********************************/
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
		
		
		/***********************************
		 * Print A Copy of Temporary(Price Quotation) Invoice
		 ***********************************/
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
		
		
	     /* type_info entry*/
	    function type_entry()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'expense_invoice_controller', 'expense_type_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
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
			else redirect('account_controller/account/noaccess');
		 }
		 /* create type entry form*/
		/* function create_type()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'expense_invoice_controller', 'expense__type_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['sale_status'] = '';
		
				$this -> load -> library('form_validation');
				//$this -> form_validation -> set_rules('type_name', 'Type Name','required');
				$this -> form_validation -> set_rules('type_type', 'Expense Type','required');
				
				//$this -> form_validation -> set_rules('transaction_type', 'Transaction Type','required');
				//$this -> form_validation -> set_rules('cheque_ref_purpose', 'cheque Reference Purpose','required');
			
		
				$data['user_type'] = $this->tank_auth->get_usertype();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['alarming_level'] = FALSE;
				$data['main_content'] = 'type_entry_form_view';
				$data['tricker_content'] = 'tricker_account_view';
			 
				$data['bd_date'] = $bd_date;
				if($this -> form_validation -> run() ==  FALSE)
				{
					$data['status'] = 'error';
				}
				else
				{
					if($this -> input -> post('type_type') == 'Expense Type')
					{
						$data['status'] = 'failed';
					}
					else 
					{
						$type_name = $this -> input ->post('type_type');
																	// table_name   ,  field name,      element
						$exists = $this -> product_model -> redundancy_check('type_info', 'type_type', $type_name);
						if($exists == true)
						{
							$data['status'] = 'exists';
							//echo 'exist';
							//$this -> load -> view('include/template', $data);
						}
						else if($this -> expense_invoice_model -> create_type())
						{
							$data['status'] = 'successful';
							//echo 'success';
						}
						else
						{
							$data['status'] = 'failed';
							//echo 'error';
						}
						
					}
				}
				//$this -> load -> view('include/template', $data);
			}
			//else redirect('account_controller/account/noaccess');
		 } */
		
		

		/* barcode printing : 02-07-2014*/
		function print_barcode()
		{
			/*$invoice_id = $this -> uri -> segment(3);
			//$invoice_id = $this -> input -> post('invoice_id');
			$data['individual_product'] = $this -> expense_invoice_model -> get_individual_details($invoice_id);
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
			endforeach;*/
			
			//$data['discount'] = ( $data['show_discount'] * 100.00 ) / $data['total_price'];
			//$data['invoice_id'] = $invoice_id;
			/*if($data['discount'] > 0)
			{
				$data['nil_discount'] = ( 100.00 / ( 100.00 - $data['discount'] )); 
			}
			else*/ 
			$data['nil_discount'] = 1;
			//$data['number_to_text'] = $this -> expense_invoice_model -> convert_number_to_words( $data['grand_total'] );

			
			$this -> load -> view('barcode_print_view', $data);
			//redirect('sale_controller/sale');

		}


		function print_barcode_by_id()
		{
			$invoice_id = $this -> uri -> segment(3);
			//$invoice_id = $this -> input -> post('invoice_id');
			$data['individual_product'] = $this -> expense_invoice_model -> get_individual_details($invoice_id);
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
			//$data['discount'] = ( $data['show_discount'] * 100.00 ) / $data['total_price'];
			//$data['invoice_id'] = $invoice_id;
			/*if($data['discount'] > 0)
			{
				$data['nil_discount'] = ( 100.00 / ( 100.00 - $data['discount'] )); 
			}
			else*/ $data['nil_discount'] = 1;
			//$data['number_to_text'] = $this -> expense_invoice_model -> convert_number_to_words( $data['grand_total'] );
			$this -> load -> view('barcode_print_view_by_id', $data);
			//redirect('sale_controller/sale');

		}
		/* barcode printing : 17-07-2014*/
		function print_barcode_by_search()
		{
			$data['nil_discount'] = 1;
		
			$data['listed_product'] = $this -> site_model -> get_barcode_all_listed_product();
			
			
			//$this -> load -> view('barcode_print_view_by_search', $data);
			$this -> load -> view('barcode_print_view_by_search_label_printer', $data);
		}
		
	}
=======
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Expense_invoice_controller extends CI_controller{
		public function __construct()
		{
			parent::__construct();
			$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
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
		
		/*************************************** 
		 * Creating An Invoice for Print Purpose
		 ***************************************/
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
				redirect('report_controller/old_invoice/no_invoice_found');
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

		/***********************************
		 * Print A Copy of Invoice
		 ***********************************/
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
		/***********************************
		 * Print A Copy of Invoice
		 ***********************************/
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
		
		
		/***********************************
		 * Print A Copy of Temporary(Price Quotation) Invoice
		 ***********************************/
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
		
		
	     /* type_info entry*/
	    function type_entry()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'expense_invoice_controller', 'expense_type_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
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
			else redirect('account_controller/account/noaccess');
		 }
		 /* create type entry form*/
		/* function create_type()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'expense_invoice_controller', 'expense__type_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['sale_status'] = '';
		
				$this -> load -> library('form_validation');
				//$this -> form_validation -> set_rules('type_name', 'Type Name','required');
				$this -> form_validation -> set_rules('type_type', 'Expense Type','required');
				
				//$this -> form_validation -> set_rules('transaction_type', 'Transaction Type','required');
				//$this -> form_validation -> set_rules('cheque_ref_purpose', 'cheque Reference Purpose','required');
			
		
				$data['user_type'] = $this->tank_auth->get_usertype();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['alarming_level'] = FALSE;
				$data['main_content'] = 'type_entry_form_view';
				$data['tricker_content'] = 'tricker_account_view';
			 
				$data['bd_date'] = $bd_date;
				if($this -> form_validation -> run() ==  FALSE)
				{
					$data['status'] = 'error';
				}
				else
				{
					if($this -> input -> post('type_type') == 'Expense Type')
					{
						$data['status'] = 'failed';
					}
					else 
					{
						$type_name = $this -> input ->post('type_type');
																	// table_name   ,  field name,      element
						$exists = $this -> product_model -> redundancy_check('type_info', 'type_type', $type_name);
						if($exists == true)
						{
							$data['status'] = 'exists';
							//echo 'exist';
							//$this -> load -> view('include/template', $data);
						}
						else if($this -> expense_invoice_model -> create_type())
						{
							$data['status'] = 'successful';
							//echo 'success';
						}
						else
						{
							$data['status'] = 'failed';
							//echo 'error';
						}
						
					}
				}
				//$this -> load -> view('include/template', $data);
			}
			//else redirect('account_controller/account/noaccess');
		 } */
		
		

		/* barcode printing : 02-07-2014*/
		function print_barcode()
		{
			/*$invoice_id = $this -> uri -> segment(3);
			//$invoice_id = $this -> input -> post('invoice_id');
			$data['individual_product'] = $this -> expense_invoice_model -> get_individual_details($invoice_id);
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
			endforeach;*/
			
			//$data['discount'] = ( $data['show_discount'] * 100.00 ) / $data['total_price'];
			//$data['invoice_id'] = $invoice_id;
			/*if($data['discount'] > 0)
			{
				$data['nil_discount'] = ( 100.00 / ( 100.00 - $data['discount'] )); 
			}
			else*/ 
			$data['nil_discount'] = 1;
			//$data['number_to_text'] = $this -> expense_invoice_model -> convert_number_to_words( $data['grand_total'] );

			
			$this -> load -> view('barcode_print_view', $data);
			//redirect('sale_controller/sale');

		}


		function print_barcode_by_id()
		{
			$invoice_id = $this -> uri -> segment(3);
			//$invoice_id = $this -> input -> post('invoice_id');
			$data['individual_product'] = $this -> expense_invoice_model -> get_individual_details($invoice_id);
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
			//$data['discount'] = ( $data['show_discount'] * 100.00 ) / $data['total_price'];
			//$data['invoice_id'] = $invoice_id;
			/*if($data['discount'] > 0)
			{
				$data['nil_discount'] = ( 100.00 / ( 100.00 - $data['discount'] )); 
			}
			else*/ $data['nil_discount'] = 1;
			//$data['number_to_text'] = $this -> expense_invoice_model -> convert_number_to_words( $data['grand_total'] );
			$this -> load -> view('barcode_print_view_by_id', $data);
			//redirect('sale_controller/sale');

		}
		/* barcode printing : 17-07-2014*/
		function print_barcode_by_search()
		{
			$data['nil_discount'] = 1;
		
			$data['listed_product'] = $this -> site_model -> get_barcode_all_listed_product();
			
			
			//$this -> load -> view('barcode_print_view_by_search', $data);
			$this -> load -> view('barcode_print_view_by_search_label_printer', $data);
		}
		
	}
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
