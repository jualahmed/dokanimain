<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

	class Site_controller extends CI_controller{
		public function __construct()
		{
	        parent::__construct();
	
			$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
			$this->is_logged_in();
		}
	
		public function is_logged_in()
		{
			
			
			$query = $this->db->get('software_expire_date');
			if($query->num_rows > 0){
							$timezone = "Asia/Dhaka";
							date_default_timezone_set($timezone);
							$bd_date = date ('Y-m-d');
							$row = $query -> row_array();
							$output = false;
							$key = '12e435034534898345';
							$iv = md5(md5($key));
							$output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($row['expire_date']), MCRYPT_MODE_CBC, $iv);
							$decrypted = rtrim($output, "");
							if($bd_date > $decrypted){
								redirect('auth/login');
							}
			}
			if(!$this->tank_auth->is_logged_in())
			{
				redirect('auth/login');
			}
		}
		// controlling home page
		function main_site()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			//if($data['user_type']!='seller'){
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['previous_date'] = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 30, date("y")));
			//$data[ 'best_sale_info' ] = $this -> report_model -> best_sale( $data['previous_date']  ,  $data['bd_date'] , 5 );
		    //$data[ 'slow_sale_info' ] = $this -> report_model -> slow_sale( $data['previous_date']  ,  $data['bd_date'] , 5 );
		    
		    
			$data[ 'todays_sale' ] = $this -> report_model -> todays_sale(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_delivery_charge' ] = $this -> report_model -> todays_delivery_charge(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_grand' ] = $this -> report_model -> todays_grand(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_paid' ] = $this -> report_model -> todays_paid(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_invoice_return' ] = $this -> report_model -> todays_invoice_return(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_collection_in' ] = $this -> report_model -> todays_collection_in(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_collection_out' ] = $this -> report_model -> todays_collection_out(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_collection_cash' ] = $this -> report_model -> todays_collection_cash(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_collection_bank' ] = $this -> report_model -> todays_collection_bank(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_credit_collection_cash' ] = $this -> report_model -> todays_credit_collection_cash(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_credit_collection_bank' ] = $this -> report_model -> todays_credit_collection_bank(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_purchase' ] = $this -> report_model -> todays_purchase(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_purchase_payment_cash' ] = $this -> report_model -> todays_purchase_payment_cash(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_purchase_payment_bank' ] = $this -> report_model -> todays_purchase_payment_bank(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_expense' ] = $this -> report_model -> todays_expense(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_expense_payment_cash' ] = $this -> report_model -> todays_expense_payment_cash(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_expense_payment_bank' ] = $this -> report_model -> todays_expense_payment_bank(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_cash_book' ] = $this -> report_model -> todays_cash_book(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_cash_in' ] = $this -> report_model -> todays_cash_in(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_cash_out' ] = $this -> report_model -> todays_cash_out(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_bank_book' ] = $this -> report_model -> todays_bank_book(  $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'todays_sale_return' ] = $this -> report_model -> todays_sale_return(  $data['bd_date']  ,  $data['bd_date']  );
			
			$data[ 'total_sale_all' ] = $this -> report_model -> total_sale_all();
			$data[ 'total_receivable_all' ] = $this -> report_model -> total_receivable_all();
			$data[ 'total_purchase_all' ] = $this -> report_model -> total_purchase_all();
			$data[ 'total_payment_all' ] = $this -> report_model -> total_payment_all();

			$data['total_stock_price'] = $this -> site_model -> total_stock_price();
			$data['total_stock_sale_price'] = $this -> site_model -> total_stock_sale_price();
			$data['total_stock_quantity'] = $this -> site_model -> total_stock_quantity();
			
			
			$data['user_name'] = $this -> tank_auth -> get_username();	
			$this -> load -> view('include/home', $data);
	/* 		}
			else{
				redirect('sale_controller/my_sale');
			} */
		}
		function all_payable_report_find()
		{
			$temp = array();

			$this->db->select('*');
			$this->db->from('distributor_info');
			$temp = $this->db->get();
			$temp = $temp->result_array();

			$i=0;
			foreach($temp as $field)
			{
				$distributor_id = $field['distributor_id'];
				$receipt_purchase_total_amount = $this->account_model->receipt_purchase_total_amount($distributor_id);
				$temp[$i]['receipt_purchase_total_amount'] = $receipt_purchase_total_amount->result_array();
				
				$receipt_payment_total_amount = $this->account_model->receipt_payment_total_amount($distributor_id);
				$temp[$i]['receipt_payment_total_amount'] = $receipt_payment_total_amount->result_array();
				
				$receipt_payment_delete_total_amount = $this->account_model->receipt_payment_delete_total_amount($distributor_id);
				$temp[$i]['receipt_payment_delete_total_amount'] = $receipt_payment_delete_total_amount->result_array();
				
				$receipt_balance_total_amount_distributor = $this->account_model->receipt_balance_total_amount_distributor($distributor_id);
				$temp[$i]['receipt_balance_total_amount'] = $receipt_balance_total_amount_distributor->result_array();
				
				$i++;
			}
			echo json_encode(array("payable"=>$temp));
		}
		function all_receive_report_find()
		{
			$temp2 = array();

			$this->db->select('*');
			$this->db->from('customer_info');
			$temp2 = $this->db->get();
			$temp2 = $temp2->result_array();

			$i=0;
			foreach($temp2 as $field)
			{
				$customer_id = $field['customer_id'];
				
				$receipt_sale_total_amount = $this->account_model->receipt_sale_total_amount($customer_id);
				$temp2[$i]['receipt_sale_total_amount'] = $receipt_sale_total_amount->result_array();
				
				$receipt_collection_total_amount = $this->account_model->receipt_collection_total_amount($customer_id);
				$temp2[$i]['receipt_collection_total_amount'] = $receipt_collection_total_amount->result_array();
				$receipt_delivery_total_amount = $this->account_model->receipt_delivery_total_amount($customer_id);
				$temp2[$i]['receipt_delivery_total_amount'] = $receipt_delivery_total_amount->result_array();
				$receipt_sale_return_total_amount = $this->account_model->receipt_sale_return_total_amount($customer_id);
				$temp2[$i]['receipt_sale_return_total_amount'] = $receipt_sale_return_total_amount->result_array();
				
				$receipt_balance_total_amount_customer = $this->account_model->receipt_balance_total_amount_customer($customer_id);
				$temp2[$i]['receipt_balance_total_amount'] = $receipt_balance_total_amount_customer->result_array();
				
				$i++;
			}
			echo json_encode(array("receive"=>$temp2));
		}
		
		function todays_statement()
		{

			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['previous_date'] = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 30, date("y")));
			//$data[ 'best_sale_info' ] = $this -> report_model -> best_sale( $data['previous_date']  ,  $data['bd_date'] , 5 );
		    //$data[ 'slow_sale_info' ] = $this -> report_model -> slow_sale( $data['previous_date']  ,  $data['bd_date'] , 5 );
		    
		    
			$data[ 'sale_price_info' ] = $this -> report_model -> specific_date_sale_price_calculation(  $data['bd_date']  ,  $data['bd_date']  );
		    $data[ 'buy_price_info' ] = $this -> report_model -> specific_date_buy_price_calculation(  $data['bd_date']  ,  $data['bd_date'] );
		    $data[ 'cash_info' ] = $this -> report_model -> specific_date_cash_calculation( $data['bd_date']  ,  $data['bd_date']  );
			$data[ 'cash_return_info' ] = $this -> report_model -> specific_date_cash_return_calculation( $data['bd_date']  ,  $data['bd_date']  );
		    $data[ 'purchase_info' ] = $this -> report_model -> specific_date_purchase_amount_calculation( $data['bd_date']  ,  $data['bd_date']  );
		    $data[ 'expense_info' ] = $this -> report_model -> specific_date_expense_amount_calculation( $data['bd_date']  ,  $data['bd_date']  );

			$data['user_type'] = $this -> tank_auth -> get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();	
			$this -> load -> view('include/home2', $data);
		}
		
		// controlling search options view
		function search_option()
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			$data['number_of_products'] = 0;
			$data ['total_buy_price'] = 0;
			$data ['total_sale_price'] = 0;
			$data ['total_profit'] = 0;
			$data['discount_on'] = false;
			/*
			$data['sale_stock'] = $this -> sale_model -> by_product_code_result();
			if($data['sale_stock'] ->  num_rows() > 0)
			{
				
				$data['sale_status'] = 'running';
				$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
				$buy_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$buy_amount = $buy_amount + $field -> unit_buy_price;
				endforeach;
				$data ['total_buy_price'] += $buy_amount;
				$sale_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$sale_amount = $sale_amount + $field -> unit_sale_price;
				endforeach;
				$data ['total_sale_price'] += $sale_amount;
				$data ['total_profit'] += $sale_amount - $buy_amount;
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			$data['sale_bulk'] = $this -> sale_model -> by_product_code_result_bulk();
			if($data['sale_bulk'] ->  num_rows() > 0)
			{ 
				$data['sale_status'] = 'running';
				$quantity = 0; // bulk product amount
				foreach($data['sale_bulk'] -> result() as $field):
					$quantity = $quantity + $field -> bulk_sale_quantity;
				endforeach;
				$data['number_of_products'] += $quantity;
				$buy_amount = 0; // bulk buy price
				foreach($data['sale_bulk'] -> result() as $field):
					$buy_amount = $buy_amount + ( $field -> unit_buy_price *  $field -> bulk_sale_quantity );
				endforeach;
				//$data ['total_buy_price'] += ( $buy_amount * $quantity);
				$data ['total_buy_price'] += ( $buy_amount );
				$sale_amount = 0;
				foreach($data['sale_bulk'] -> result() as $field):
					$sale_amount = $sale_amount + ( $field -> unit_sale_price  *  $field -> bulk_sale_quantity );				
				endforeach;
				//$data ['total_sale_price'] += ( $sale_amount * $quantity );
				$data ['total_sale_price'] += ( $sale_amount  );
				$data ['total_profit'] += ( $sale_amount - $buy_amount);
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			/* end of Sale running Status*/
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
			$data['alarming_level'] = FALSE;
			$data['main_content'] =  'search_option_view';
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);
		}
		
		/* to show all available stocks */
		function all_stock()
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			$data['number_of_products'] = 0;
			
			/* end of Sale running Status*/
			
			//$this -> table -> set_heading('Serial','Stock ID','Purchase Date');
				
			$config['base_url'] = base_url().'index.php/site_controller/all_stock/';
			
			$config['total_rows'] = $this -> site_model -> all_stock_no_of_rows();
	        $config['per_page'] = 15;
	        $config['num_links'] = 5;
			$config['uri_segment'] = 3;
			$config['full_tag_open'] = '<div id="pagination">';
			$config['full_tag_close'] = '</div>';
			$this -> pagination -> initialize($config);
			
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
			
			$data['records'] = $this -> site_model -> all_stock( $config['per_page'] );
			$data['total_stock_price'] = $this -> site_model -> total_stock_price();
			$data['total_stock_quantity'] = $this -> site_model -> total_stock_quantity();
			$data['alarming_level'] = FALSE;
			$query = $this -> sale_model -> products_info(FALSE, 0, $this -> tank_auth -> get_shop_id());
			$temp[''] = 'Select A Product';
			foreach($query -> result() as $field):
				 $temp[base_url().'site_controller/by_name_result/'.$field->product_id] = $field -> product_name;
			endforeach;
			$data['product_info'] = $temp;
			
			$data['main_content'] =  'all_stock_view';
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);	
		}
		
		/* to show all available stocks */
		function all_stock_details()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date']=date('Y-m-d');
			$data['start_date'] = $this->uri->segment(3);
			$data['end_date'] = $this->uri->segment(4);
			
			
			if(($data['start_date'] == 'x') && ($data['end_date'] == 'x')){
				$data['start_date'] = date('Y-m').'-01';
				$data['end_date'] = date('Y-m').'-'.date("t");
			}
			
			$data['sale_status'] = '';
			$data['number_of_products'] = 0;
			
			/* end of Sale running Status*/
			
			//$this -> table -> set_heading('Serial','Stock ID','Purchase Date');
			
			if($data['start_date'] == 'x' && $data['end_date'] == 'x'){
				$config['base_url'] = base_url().'index.php/site_controller/all_stock_details/x/x/';
			}
			else if($data['start_date'] == '' && $data['end_date'] == ''){
				$config['base_url'] = base_url().'index.php/site_controller/all_stock_details/x/x/';
			}
			else{
				$config['base_url'] = base_url().'index.php/site_controller/all_stock_details/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/';
			}
			
			$config['total_rows'] = $this -> site_model -> all_stock_no_of_rows();
	        $config['per_page'] = 15;
	        $config['num_links'] = 5;
			$config['uri_segment'] = 5;
			$config['full_tag_open'] = '<div id="pagination">';
			$config['full_tag_close'] = '</div>';
			$this -> pagination -> initialize($config);
			
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
			
			$data['records'] = $this -> site_model -> all_stock( $config['per_page'] );
			$data['records'] = $data['records'] -> result();
			$i=0;
			
			$data['total_buy_quan'] = $this -> site_model -> exact_total_buy_quantity($data['start_date'],$data['end_date']);
			$data['total_sale_quan'] = $this -> site_model -> exact_total_sale_quantity($data['start_date'],$data['end_date']);
			$data['total_sale_prices'] = $this -> site_model -> exact_total_sale_price($data['start_date'],$data['end_date']);
			$data['total_stock_quantity'] = $this -> site_model -> total_stock_quantity();
			
			foreach($data['records'] as $fild){
				$data['records'][$i]->total_buy_quantity = $this -> site_model -> total_buy_quantity($data['start_date'],$data['end_date'],$fild->product_id,1);
				$data['records'][$i]->avg_buy_price = $this -> site_model -> total_buy_quantity($data['start_date'],$data['end_date'],$fild->product_id,2);
				$data['records'][$i]->total_sale_quantity = $this -> site_model -> total_sale_quantity($data['start_date'],$data['end_date'],$fild->product_id,1);
				/* $data['records'][$i]->avg_sale_price =  */
				$i++;
			}
			$data['total_stock_price'] = $this -> site_model -> total_stock_price();
			$data['alarming_level'] = FALSE;
			$query = $this -> sale_model -> products_info(FALSE, 0, $this -> tank_auth -> get_shop_id());
			$temp[''] = 'Select A Product';
			foreach($query -> result() as $field):
				 $temp[base_url().'site_controller/by_name_result/'.$field->product_id] = $field -> product_name;
			endforeach;
			$data['product_info'] = $temp;
			
			$data['main_content'] =  'all_stock_details_view';
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);	
		}
		
		/******************************
		 *  Print All Available Stock     *
		 ******************************/
		 function print_all_stock_details()
		 {
			 $timezone = "Asia/Dhaka";
			 date_default_timezone_set($timezone);
			 $data['bd_date'] = date ('Y-m-d');
			 $data['start_date'] = $this->uri->segment(3);
			 $data['end_date'] = $this->uri->segment(4);
			 $data['all_stock'] = $this -> report_model -> get_all_stock_report();
			 $data['all_stock'] = $data['all_stock']->result();
			 $i=0;
			 foreach($data['all_stock'] as $fild){
				$data['all_stock'][$i]->total_buy_quantity = $this -> site_model -> total_buy_quantity($data['start_date'],$data['end_date'],$fild->product_id,1);
				$data['all_stock'][$i]->avg_buy_price = $this -> site_model -> total_buy_quantity($data['start_date'],$data['end_date'],$fild->product_id,2);
				$data['all_stock'][$i]->total_sale_quantity = $this -> site_model -> total_sale_quantity($data['start_date'],$data['end_date'],$fild->product_id,1);
				/* $data['all_stock'][$i]->avg_sale_price =  */
				$i++;
			}
			 $this -> load -> view('all_stock_print_details_view', $data);
		 }
		
		/*****************************************
		 *  Search By Catagory Name                        *
		 * ***************************************/
		function by_catagory()
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			$data['number_of_products'] = 0;
			$data ['total_buy_price'] = 0;
			$data ['total_sale_price'] = 0;
			$data ['total_profit'] = 0;
			$data['discount_on'] = false;
			$data['sale_stock'] = $this -> sale_model -> by_product_code_result();
			if($data['sale_stock'] ->  num_rows() > 0)
			{
				
				$data['sale_status'] = 'running';
				$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
				$buy_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$buy_amount = $buy_amount + $field -> unit_buy_price;
				endforeach;
				$data ['total_buy_price'] += $buy_amount;
				$sale_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$sale_amount = $sale_amount + $field -> unit_sale_price;
				endforeach;
				$data ['total_sale_price'] += $sale_amount;
				$data ['total_profit'] += $sale_amount - $buy_amount;
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			$data['sale_bulk'] = $this -> sale_model -> by_product_code_result_bulk();
			if($data['sale_bulk'] ->  num_rows() > 0)
			{ 
				$data['sale_status'] = 'running';
				$quantity = 0; // bulk product amount
				foreach($data['sale_bulk'] -> result() as $field):
					$quantity = $quantity + $field -> bulk_sale_quantity;
				endforeach;
				$data['number_of_products'] += $quantity;
				$buy_amount = 0; // bulk buy price
				foreach($data['sale_bulk'] -> result() as $field):
					$buy_amount = $buy_amount + ( $field -> unit_buy_price *  $field -> bulk_sale_quantity );
				endforeach;
				//$data ['total_buy_price'] += ( $buy_amount * $quantity);
				$data ['total_buy_price'] += ( $buy_amount );
				$sale_amount = 0;
				foreach($data['sale_bulk'] -> result() as $field):
					$sale_amount = $sale_amount + ( $field -> unit_sale_price  *  $field -> bulk_sale_quantity );				
				endforeach;
				//$data ['total_sale_price'] += ( $sale_amount * $quantity );
				$data ['total_sale_price'] += ( $sale_amount  );
				$data ['total_profit'] += ( $sale_amount - $buy_amount);
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			/* end of Sale running Status*/
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
			
			$query = $this -> site_model -> all_catagory();
			$catagory[''] =  'Select a Catagory';
			foreach ($query-> result() as $field)
			{
					$temp = preg_replace('/\s+/', '~',$field->catagory_name);
					$catagory[base_url().'index.php/site_controller/by_catagory/'.$temp] = $field -> catagory_name;
			}
			$data['catagory_id'] = $catagory;
			$data['main_content'] = 'search_by_catagory_view';
			$catagory_name = $this -> uri -> segment(3);
			if($catagory_name)
			{
				$data['records'] = $this -> site_model -> advance_search_result();
			}
			$data['alarming_level'] = FALSE;
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);
		}
		 
		 
	
		/* Search by name */
		function by_name()
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			$data['number_of_products'] = 0;
			$data ['total_buy_price'] = 0;
			$data ['total_sale_price'] = 0;
			$data ['total_profit'] = 0;
			$data['discount_on'] = false;
			$data['sale_stock'] = $this -> sale_model -> by_product_code_result();
			if($data['sale_stock'] ->  num_rows() > 0)
			{
				
				$data['sale_status'] = 'running';
				$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
				$buy_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$buy_amount = $buy_amount + $field -> unit_buy_price;
				endforeach;
				$data ['total_buy_price'] += $buy_amount;
				$sale_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$sale_amount = $sale_amount + $field -> unit_sale_price;
				endforeach;
				$data ['total_sale_price'] += $sale_amount;
				$data ['total_profit'] += $sale_amount - $buy_amount;
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			$data['sale_bulk'] = $this -> sale_model -> by_product_code_result_bulk();
			if($data['sale_bulk'] ->  num_rows() > 0)
			{ 
				$data['sale_status'] = 'running';
				$quantity = 0; // bulk product amount
				foreach($data['sale_bulk'] -> result() as $field):
					$quantity = $quantity + $field -> bulk_sale_quantity;
				endforeach;
				$data['number_of_products'] += $quantity;
				$buy_amount = 0; // bulk buy price
				foreach($data['sale_bulk'] -> result() as $field):
					$buy_amount = $buy_amount + ( $field -> unit_buy_price *  $field -> bulk_sale_quantity );
				endforeach;
				//$data ['total_buy_price'] += ( $buy_amount * $quantity);
				$data ['total_buy_price'] += ( $buy_amount );
				$sale_amount = 0;
				foreach($data['sale_bulk'] -> result() as $field):
					$sale_amount = $sale_amount + ( $field -> unit_sale_price  *  $field -> bulk_sale_quantity );				
				endforeach;
				//$data ['total_sale_price'] += ( $sale_amount * $quantity );
				$data ['total_sale_price'] += ( $sale_amount  );
				$data ['total_profit'] += ( $sale_amount - $buy_amount );
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			/* end of Sale running Status*/
			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
			$data['main_content'] = 'search_by_product_name_view';
			
			$data['product_info'] = $this -> product_model -> product_info();
			
			$query = $this -> sale_model -> products_info(FALSE, 0, $this -> tank_auth -> get_shop_id());
			$temp[''] = 'Select A Product';
			foreach($query -> result() as $field):
				 $temp[base_url().'site_controller/by_name_result/'.$field->product_id] = $field -> product_name;
			endforeach;
			$data['product_name'] = $temp;
			
			$data['alarming_level'] = FALSE;
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);
		}
		
		/** Stocked list of a specific product */
        function by_name_result()
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			$data['number_of_products'] = 0;
			$data ['total_buy_price'] = 0;
			$data ['total_sale_price'] = 0;
			$data ['total_profit'] = 0;
			$data['discount_on'] = false;
			$data['sale_stock'] = $this -> sale_model -> by_product_code_result();
			if($data['sale_stock'] ->  num_rows() > 0)
			{
				
				$data['sale_status'] = 'running';
				$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
				$buy_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$buy_amount = $buy_amount + $field -> unit_buy_price;
				endforeach;
				$data ['total_buy_price'] += $buy_amount;
				$sale_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$sale_amount = $sale_amount + $field -> unit_sale_price;
				endforeach;
				$data ['total_sale_price'] += $sale_amount;
				$data ['total_profit'] += $sale_amount - $buy_amount;
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			$data['sale_bulk'] = $this -> sale_model -> by_product_code_result_bulk();
			if($data['sale_bulk'] ->  num_rows() > 0)
			{ 
				$data['sale_status'] = 'running';
				$quantity = 0; // bulk product amount
				foreach($data['sale_bulk'] -> result() as $field):
					$quantity = $quantity + $field -> bulk_sale_quantity;
				endforeach;
				$data['number_of_products'] += $quantity;
				$buy_amount = 0; // bulk buy price
				foreach($data['sale_bulk'] -> result() as $field):
					$buy_amount = $buy_amount + ( $field -> unit_buy_price *  $field -> bulk_sale_quantity );
				endforeach;
				//$data ['total_buy_price'] += ( $buy_amount * $quantity);
				$data ['total_buy_price'] += ( $buy_amount );
				$sale_amount = 0;
				foreach($data['sale_bulk'] -> result() as $field):
					$sale_amount = $sale_amount + ( $field -> unit_sale_price  *  $field -> bulk_sale_quantity );				
				endforeach;
				//$data ['total_sale_price'] += ( $sale_amount * $quantity );
				$data ['total_sale_price'] += ( $sale_amount  );
				$data ['total_profit'] += ( $sale_amount - $buy_amount );
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			/* end of Sale running Status*/
			$data['alarming_level'] = FALSE;
			$data['stock_element'] = false;
			$data['bulk_element'] = false;
			$data['user_type'] = $this->tank_auth->get_usertype();
			
			$this -> form_validation -> set_rules('product_id', 'Product Name','required|numeric');
			if($this -> form_validation -> run() ==  FALSE && !$this -> uri -> segment(3))
			{
				$data['status'] = 'error';	
				$data['user_name'] = $this -> tank_auth -> get_username();
				$data['main_content'] = 'search_by_product_name_view';
				
				$data['product_info'] = $this -> product_model -> product_info();
				if( $this -> input -> post('flag'))
				{
					$data['status'] = 'validation';	
					$data['main_content'] = 'search_by_product_id_view';
				}
				$data['tricker_content'] = 'tricker_search_option_view';
				$this -> load -> view('include/template',$data);
			}
			else
			{
				
				/* as it call itself we are passing data to get PRODUCT_ID*/
				$p = $this -> uri -> segment(3);
				if($p)
					$pro_id = $this -> uri -> segment(3);
				else
				{
				  	 $pro_id = $this -> input -> post('product_id');
				}
				
				$this -> table -> set_heading('Serial','Stock ID','Purchase Date');
				$config['base_url'] = base_url().'site_controller/by_name_result/'. $pro_id ;
				$config['per_page'] = 15;
			    $config['num_links'] = 5;
				$config['uri_segment'] = 4;
				$config['full_tag_open'] = '<div id="pagination">';
				$config['full_tag_close'] = '</div>';
				if($this -> site_model -> product_specification( $pro_id ))
				{
					$config['total_rows'] = $this -> site_model -> by_product_name_result_no_of_row($pro_id) ;
					$data['records'] = $this -> site_model -> by_product_name_result($pro_id, $config['per_page']);
					$data['stock_element'] = true;
				}
				else
				{
					$config['total_rows'] = 1;
					$data['records'] = $this -> site_model -> by_product_name_bulk_result($pro_id, $config['per_page']);
					$data['bulk_element'] = true;
				}
				$this -> pagination -> initialize($config);
				$data['product_id'] = $pro_id;
				$data['user_name'] = $this -> tank_auth -> get_username();
				$data['shelf_info'] = $this -> site_model -> get_shelf_info_of_a_product( $pro_id );
				$data['main_content'] = 'by_product_name_result_view';
				$data['tricker_content'] = 'tricker_search_option_view';
				$this -> load -> view('include/template',$data);
			}
		    
		}
		
		/* Search By Serial number */
		function by_serial_no()
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			$data['number_of_products'] = 0;
			$data ['total_buy_price'] = 0;
			$data ['total_sale_price'] = 0;
			$data ['total_profit'] = 0;
			$data['discount_on'] = false;
			$data['sale_stock'] = $this -> sale_model -> by_product_code_result();
			if($data['sale_stock'] ->  num_rows() > 0)
			{
				
				$data['sale_status'] = 'running';
				$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
				$buy_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$buy_amount = $buy_amount + $field -> unit_buy_price;
				endforeach;
				$data ['total_buy_price'] += $buy_amount;
				$sale_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$sale_amount = $sale_amount + $field -> unit_sale_price;
				endforeach;
				$data ['total_sale_price'] += $sale_amount;
				$data ['total_profit'] += $sale_amount - $buy_amount;
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			$data['sale_bulk'] = $this -> sale_model -> by_product_code_result_bulk();
			if($data['sale_bulk'] ->  num_rows() > 0)
			{ 
				$data['sale_status'] = 'running';
				$quantity = 0; // bulk product amount
				foreach($data['sale_bulk'] -> result() as $field):
					$quantity = $quantity + $field -> bulk_sale_quantity;
				endforeach;
				$data['number_of_products'] += $quantity;
				$buy_amount = 0; // bulk buy price
				foreach($data['sale_bulk'] -> result() as $field):
					$buy_amount = $buy_amount + ( $field -> unit_buy_price *  $field -> bulk_sale_quantity );
				endforeach;
				//$data ['total_buy_price'] += ( $buy_amount * $quantity);
				$data ['total_buy_price'] += ( $buy_amount );
				$sale_amount = 0;
				foreach($data['sale_bulk'] -> result() as $field):
					$sale_amount = $sale_amount + ( $field -> unit_sale_price  *  $field -> bulk_sale_quantity );				
				endforeach;
				//$data ['total_sale_price'] += ( $sale_amount * $quantity );
				$data ['total_sale_price'] += ( $sale_amount  );
				$data ['total_profit'] += ( $sale_amount - $buy_amount );
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			/* end of Sale running Status*/
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'search_by_serial_no_view';
			$data['tricker_content'] = 'tricker_search_option_view';
			$data['flag'] = false;
			$this -> load -> view('include/template',$data);
		}
		
			/* Search by Product ID */
		function by_product_id()
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			$data['number_of_products'] = 0;
			$data ['total_buy_price'] = 0;
			$data ['total_sale_price'] = 0;
			$data ['total_profit'] = 0;
			$data['discount_on'] = false;
			$data['sale_stock'] = $this -> sale_model -> by_product_code_result();
			if($data['sale_stock'] ->  num_rows() > 0)
			{
				
				$data['sale_status'] = 'running';
				$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
				$buy_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$buy_amount = $buy_amount + $field -> unit_buy_price;
				endforeach;
				$data ['total_buy_price'] += $buy_amount;
				$sale_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$sale_amount = $sale_amount + $field -> unit_sale_price;
				endforeach;
				$data ['total_sale_price'] += $sale_amount;
				$data ['total_profit'] += $sale_amount - $buy_amount;
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			$data['sale_bulk'] = $this -> sale_model -> by_product_code_result_bulk();
			if($data['sale_bulk'] ->  num_rows() > 0)
			{ 
				$data['sale_status'] = 'running';
				$quantity = 0; // bulk product amount
				foreach($data['sale_bulk'] -> result() as $field):
					$quantity = $quantity + $field -> bulk_sale_quantity;
				endforeach;
				$data['number_of_products'] += $quantity;
				$buy_amount = 0; // bulk buy price
				foreach($data['sale_bulk'] -> result() as $field):
					$buy_amount = $buy_amount + ( $field -> unit_buy_price *  $field -> bulk_sale_quantity );
				endforeach;
				//$data ['total_buy_price'] += ( $buy_amount * $quantity);
				$data ['total_buy_price'] += ( $buy_amount );
				$sale_amount = 0;
				foreach($data['sale_bulk'] -> result() as $field):
					$sale_amount = $sale_amount + ( $field -> unit_sale_price  *  $field -> bulk_sale_quantity );				
				endforeach;
				//$data ['total_sale_price'] += ( $sale_amount * $quantity );
				$data ['total_sale_price'] += ( $sale_amount  );
				$data ['total_profit'] += ( $sale_amount - $buy_amount );
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			/* end of Sale running Status*/
			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
			$data['main_content'] = 'search_by_product_id_view';
			
			//$data['product_info'] = $this -> product_model -> product_info();
			$data['alarming_level'] = FALSE;
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);
		}
		
		/* Search By Serial number  result*/
		function by_serial_no_result()
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			$data['number_of_products'] = 0;
			$data ['total_buy_price'] = 0;
			$data ['total_sale_price'] = 0;
			$data ['total_profit'] = 0;
			$data['discount_on'] = false;
			$data['sale_stock'] = $this -> sale_model -> by_product_code_result();
			if($data['sale_stock'] ->  num_rows() > 0)
			{
				
				$data['sale_status'] = 'running';
				$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
				$buy_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$buy_amount = $buy_amount + $field -> unit_buy_price;
				endforeach;
				$data ['total_buy_price'] += $buy_amount;
				$sale_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$sale_amount = $sale_amount + $field -> unit_sale_price;
				endforeach;
				$data ['total_sale_price'] += $sale_amount;
				$data ['total_profit'] += $sale_amount - $buy_amount;
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			$data['sale_bulk'] = $this -> sale_model -> by_product_code_result_bulk();
			if($data['sale_bulk'] ->  num_rows() > 0)
			{ 
				$data['sale_status'] = 'running';
				$quantity = 0; // bulk product amount
				foreach($data['sale_bulk'] -> result() as $field):
					$quantity = $quantity + $field -> bulk_sale_quantity;
				endforeach;
				$data['number_of_products'] += $quantity;
				$buy_amount = 0; // bulk buy price
				foreach($data['sale_bulk'] -> result() as $field):
					$buy_amount = $buy_amount + ( $field -> unit_buy_price *  $field -> bulk_sale_quantity );
				endforeach;
				//$data ['total_buy_price'] += ( $buy_amount * $quantity);
				$data ['total_buy_price'] += ( $buy_amount );
				$sale_amount = 0;
				foreach($data['sale_bulk'] -> result() as $field):
					$sale_amount = $sale_amount + ( $field -> unit_sale_price  *  $field -> bulk_sale_quantity );				
				endforeach;
				//$data ['total_sale_price'] += ( $sale_amount * $quantity );
				$data ['total_sale_price'] += ( $sale_amount  );
				$data ['total_profit'] += ( $sale_amount - $buy_amount );
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			/* end of Sale running Status*/
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
				
			$data['result'] = $this -> site_model -> by_serial_no_result();
			$data['flag'] = true;
			$data['alarming_level'] = FALSE;
		    $data['main_content'] = 'search_by_serial_no_view';	
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);	
		}
		
		/* By Stock ID */
		function by_stock_id()
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			$data['number_of_products'] = 0;
			$data ['total_buy_price'] = 0;
			$data ['total_sale_price'] = 0;
			$data ['total_profit'] = 0;
			$data['discount_on'] = false;
			$data['sale_stock'] = $this -> sale_model -> by_product_code_result();
			if($data['sale_stock'] ->  num_rows() > 0)
			{
				
				$data['sale_status'] = 'running';
				$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
				$buy_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$buy_amount = $buy_amount + $field -> unit_buy_price;
				endforeach;
				$data ['total_buy_price'] += $buy_amount;
				$sale_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$sale_amount = $sale_amount + $field -> unit_sale_price;
				endforeach;
				$data ['total_sale_price'] += $sale_amount;
				$data ['total_profit'] += $sale_amount - $buy_amount;
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			$data['sale_bulk'] = $this -> sale_model -> by_product_code_result_bulk();
			if($data['sale_bulk'] ->  num_rows() > 0)
			{ 
				$data['sale_status'] = 'running';
				$quantity = 0; // bulk product amount
				foreach($data['sale_bulk'] -> result() as $field):
					$quantity = $quantity + $field -> bulk_sale_quantity;
				endforeach;
				$data['number_of_products'] += $quantity;
				$buy_amount = 0; // bulk buy price
				foreach($data['sale_bulk'] -> result() as $field):
					$buy_amount = $buy_amount + ( $field -> unit_buy_price *  $field -> bulk_sale_quantity );
				endforeach;
				//$data ['total_buy_price'] += ( $buy_amount * $quantity);
				$data ['total_buy_price'] += ( $buy_amount );
				$sale_amount = 0;
				foreach($data['sale_bulk'] -> result() as $field):
					$sale_amount = $sale_amount + ( $field -> unit_sale_price  *  $field -> bulk_sale_quantity );				
				endforeach;
				//$data ['total_sale_price'] += ( $sale_amount * $quantity );
				$data ['total_sale_price'] += ( $sale_amount  );
				$data ['total_profit'] += ( $sale_amount - $buy_amount );
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			/* end of Sale running Status*/
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'search_by_stock_id_view';
			$data['tricker_content'] = 'tricker_search_option_view';
			$data['flag'] = false;
			$this -> load -> view('include/template',$data);
		}
		
		
		function fatch_product_id( $records)
		{
			foreach ($records->result() as $field):
				$data = $field -> product_id;
			endforeach;
			return $data;
		}
		
		/* By Stock ID Result */
		function by_stock_id_result()
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			$data['number_of_products'] = 0;
			$data ['total_buy_price'] = 0;
			$data ['total_sale_price'] = 0;
			$data ['total_profit'] = 0;
			$data['discount_on'] = false;
			$data['sale_stock'] = $this -> sale_model -> by_product_code_result();
			if($data['sale_stock'] ->  num_rows() > 0)
			{
				
				$data['sale_status'] = 'running';
				$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
				$buy_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$buy_amount = $buy_amount + $field -> unit_buy_price;
				endforeach;
				$data ['total_buy_price'] += $buy_amount;
				$sale_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$sale_amount = $sale_amount + $field -> unit_sale_price;
				endforeach;
				$data ['total_sale_price'] += $sale_amount;
				$data ['total_profit'] += $sale_amount - $buy_amount;
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			$data['sale_bulk'] = $this -> sale_model -> by_product_code_result_bulk();
			if($data['sale_bulk'] ->  num_rows() > 0)
			{ 
				$data['sale_status'] = 'running';
				$quantity = 0; // bulk product amount
				foreach($data['sale_bulk'] -> result() as $field):
					$quantity = $quantity + $field -> bulk_sale_quantity;
				endforeach;
				$data['number_of_products'] += $quantity;
				$buy_amount = 0; // bulk buy price
				foreach($data['sale_bulk'] -> result() as $field):
					$buy_amount = $buy_amount + ( $field -> unit_buy_price *  $field -> bulk_sale_quantity );
				endforeach;
				//$data ['total_buy_price'] += ( $buy_amount * $quantity);
				$data ['total_buy_price'] += ( $buy_amount );
				$sale_amount = 0;
				foreach($data['sale_bulk'] -> result() as $field):
					$sale_amount = $sale_amount + ( $field -> unit_sale_price  *  $field -> bulk_sale_quantity );				
				endforeach;
				//$data ['total_sale_price'] += ( $sale_amount * $quantity );
				$data ['total_sale_price'] += ( $sale_amount  );
				$data ['total_profit'] += ( $sale_amount - $buy_amount );
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			/* end of Sale running Status*/
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
				
			$data['result'] = $this -> site_model -> by_stock_id_result();
			if($data['result'] -> num_rows() )
			{
				$data['product_id'] = $this -> fatch_product_id( $data['result'] );
				$data['no_of_stock'] = $this -> site_model -> by_product_name_result_no_of_row($data['product_id']);
			}
			$data['flag'] = true;
			$data['alarming_level'] = FALSE;
		    $data['main_content'] = 'search_by_stock_id_view';	
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);	
		}

		function fatch_catagory_type($records)
		{
			foreach ($records -> result() as $field):
				$data = $field->product_type;
			endforeach;
			return $data;	
		}
		
		/* Advance Search */
		function advance_search()
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			$data['number_of_products'] = 0;
			$data ['total_buy_price'] = 0;
			$data ['total_sale_price'] = 0;
			$data ['total_profit'] = 0;
			$data['discount_on'] = false;
			$data['sale_stock'] = $this -> sale_model -> by_product_code_result();
			if($data['sale_stock'] ->  num_rows() > 0)
			{
				
				$data['sale_status'] = 'running';
				$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
				$buy_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$buy_amount = $buy_amount + $field -> unit_buy_price;
				endforeach;
				$data ['total_buy_price'] += $buy_amount;
				$sale_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$sale_amount = $sale_amount + $field -> unit_sale_price;
				endforeach;
				$data ['total_sale_price'] += $sale_amount;
				$data ['total_profit'] += $sale_amount - $buy_amount;
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			$data['sale_bulk'] = $this -> sale_model -> by_product_code_result_bulk();
			if($data['sale_bulk'] ->  num_rows() > 0)
			{ 
				$data['sale_status'] = 'running';
				$quantity = 0; // bulk product amount
				foreach($data['sale_bulk'] -> result() as $field):
					$quantity = $quantity + $field -> bulk_sale_quantity;
				endforeach;
				$data['number_of_products'] += $quantity;
				$buy_amount = 0; // bulk buy price
				foreach($data['sale_bulk'] -> result() as $field):
					$buy_amount = $buy_amount + ( $field -> unit_buy_price *  $field -> bulk_sale_quantity );
				endforeach;
				//$data ['total_buy_price'] += ( $buy_amount * $quantity);
				$data ['total_buy_price'] += ( $buy_amount );
				$sale_amount = 0;
				foreach($data['sale_bulk'] -> result() as $field):
					$sale_amount = $sale_amount + ( $field -> unit_sale_price  *  $field -> bulk_sale_quantity );				
				endforeach;
				//$data ['total_sale_price'] += ( $sale_amount * $quantity );
				$data ['total_sale_price'] += ( $sale_amount  );
				$data ['total_profit'] += ( $sale_amount - $buy_amount );
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			/* end of Sale running Status*/
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
			
			$query = $this -> site_model -> all_catagory();
			$catagory[''] =  'Select a Catagory';
			foreach ($query-> result() as $field)
			{
					$temp = preg_replace('/\s+/', '~',$field -> catagory_name);// $url_title = url_title($field->catagory_name, '_');
					//$data['http://localhost/inventory_management/index.php/site_controller/advance_search/'.$field->catagory_name] = $field -> catagory_name;
				    $catagory[base_url().'index.php/site_controller/advance_search/'.$temp] = $field -> catagory_name;
		    }
			$data['catagory_id'] = $catagory;
			
			$catagory_name = $this -> uri -> segment(3);
			if($catagory_name)
			{
				$data['product_type'] = $this -> site_model -> product_type();
			}
			
			$catagory_type = $this -> uri -> segment(4);
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'advance_search_view';
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);
		}
		
		/* Advance Search Result */
		function advance_search_result()
		{
			
			//* for sale Running Status */
			$data['sale_status'] = '';
			$data['number_of_products'] = 0;
			$data ['total_buy_price'] = 0;
			$data ['total_sale_price'] = 0;
			$data ['total_profit'] = 0;
			$data['discount_on'] = false;
			$data['sale_stock'] = $this -> sale_model -> by_product_code_result();
			if($data['sale_stock'] ->  num_rows() > 0)
			{
				
				$data['sale_status'] = 'running';
				$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
				$buy_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$buy_amount = $buy_amount + $field -> unit_buy_price;
				endforeach;
				$data ['total_buy_price'] += $buy_amount;
				$sale_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$sale_amount = $sale_amount + $field -> unit_sale_price;
				endforeach;
				$data ['total_sale_price'] += $sale_amount;
				$data ['total_profit'] += $sale_amount - $buy_amount;
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			$data['sale_bulk'] = $this -> sale_model -> by_product_code_result_bulk();
			if($data['sale_bulk'] ->  num_rows() > 0)
			{ 
				$data['sale_status'] = 'running';
				$quantity = 0; // bulk product amount
				foreach($data['sale_bulk'] -> result() as $field):
					$quantity = $quantity + $field -> bulk_sale_quantity;
				endforeach;
				$data['number_of_products'] += $quantity;
				$buy_amount = 0; // bulk buy price
				foreach($data['sale_bulk'] -> result() as $field):
					$buy_amount = $buy_amount + ( $field -> unit_buy_price *  $field -> bulk_sale_quantity );
				endforeach;
				//$data ['total_buy_price'] += ( $buy_amount * $quantity);
				$data ['total_buy_price'] += ( $buy_amount );
				$sale_amount = 0;
				foreach($data['sale_bulk'] -> result() as $field):
					$sale_amount = $sale_amount + ( $field -> unit_sale_price  *  $field -> bulk_sale_quantity );				
				endforeach;
				//$data ['total_sale_price'] += ( $sale_amount * $quantity );
				$data ['total_sale_price'] += ( $sale_amount  );
				$data ['total_profit'] += ( $sale_amount - $buy_amount );
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			/* end of Sale running Status*/
			
			
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
			$data['records'] = $this -> site_model -> advance_search_result();
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'advance_search_result_view';
			$data['link_content'] = 'link_admin_view';
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);
		}
        /* for edit  product_name & update product_info,catagory_info,company_info */
     /*   function edit_product_name()
		{
					// have controlled in MODIFY CONTROLLER
		}*/
		
		/****************************
		 * Show All Distributor List
		 ****************************/
		function all_distributor()
		{
			$data['sale_status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
			
			$config['base_url'] = base_url().'index.php/site_controller/all_distributor/';
			
			$config['total_rows'] = $this -> site_model -> num_of_distributors();
	        $config['per_page'] = 15;
	        $config['num_links'] = 5;
			$config['uri_segment'] = 3;
			$config['full_tag_open'] = '<div id="pagination">';
			$config['full_tag_close'] = '</div>';
			$this -> pagination -> initialize($config);
			$data['all_distributor'] = $this -> site_model -> all_distributor( $config['per_page'] );
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'all_distributor_view';	
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);
		}

		/****************************
		 * Show All Company List
		 ****************************/
		function all_company()
		{
			$data['sale_status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
			
			$config['base_url'] = base_url().'index.php/site_controller/all_company/';
			
			$config['total_rows'] = $this -> site_model -> num_of_companys();
	        $config['per_page'] = 15;
	        $config['num_links'] = 5;
			$config['uri_segment'] = 3;
			$config['full_tag_open'] = '<div id="pagination">';
			$config['full_tag_close'] = '</div>';
			$this -> pagination -> initialize($config);
			$data['all_company'] = $this -> site_model -> all_company( $config['per_page'] );
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'all_company_view';	
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);
			
		}
		
		/****************************
		 * Show All Catagory List
		 ****************************/
		function all_catagory()
		{
			$data['sale_status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
			
			$config['base_url'] = base_url().'index.php/site_controller/all_catagory/';
			
			$config['total_rows'] = $this -> site_model -> num_of_catagory();
	        $config['per_page'] = 15;
	        $config['num_links'] = 5;
			$config['uri_segment'] = 3;
			$config['full_tag_open'] = '<div id="pagination">';
			$config['full_tag_close'] = '</div>';
			$this -> pagination -> initialize($config);
			$data['all_catagory'] = $this -> site_model -> all_catagory_pagination( $config['per_page'] );
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'all_catagory_view';	
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);
			
		}
		
		/************************************
		 * Show All Registerd Customer List *
		 ************************************/
		function all_registerd_customer()
		{
			$data['sale_status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
		
			$config['base_url'] = base_url().'index.php/site_controller/all_registerd_customer/';
		
			$config['total_rows'] = $this -> site_model -> num_of_registerd_customer();
	        $config['per_page'] = 15;
	        $config['num_links'] = 5;
			$config['uri_segment'] = 3;
			$config['full_tag_open'] = '<div id="pagination">';
			$config['full_tag_close'] = '</div>';
			$this -> pagination -> initialize($config);
			$data['all_registerd_customer'] = $this -> site_model -> all_registerd_customer_pagination( $config['per_page'] );
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'all_registerd_customer_view';	
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);
			
		}
		function all_customer()
		{
			$data['sale_status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
			
			$config['base_url'] = base_url().'index.php/site_controller/all_customer/';
			
			$config['total_rows'] = $this -> site_model -> num_of_all_type_customer();
	        $config['per_page'] = 25;
	        $config['num_links'] = 5;
			$config['uri_segment'] = 3;
			$config['full_tag_open'] = '<div id="pagination">';
			$config['full_tag_close'] = '</div>';
			$this -> pagination -> initialize($config);
			$data['all_customer'] = $this -> site_model -> all_type_customer( $config['per_page'] );
			$data['alarming_level'] = FALSE;
			
			$query = $this -> site_model -> all_customer_info();

			foreach($query -> result() as $field):
				 $temp[base_url().'site_controller/all_customer/0/'.$field->customer_id] = $field -> customer_name;
			endforeach;
			$data['customer_info'] = $temp;
			if($this->uri->segment(4)){
				$data['specific_customer'] = $this -> site_model -> specific_customer_info($this->uri->segment(4));
			}
			foreach($query -> result() as $fielded):
				 $tempo[base_url().'site_controller/all_customer/0/0/'.$fielded->customer_id] = $fielded -> customer_define_id;
			endforeach;
			$data['customer_define_info'] = $tempo;
			if($this->uri->segment(5)){
				$data['specific_customer'] = $this -> site_model -> specific_customer_info($this->uri->segment(5));
			}
			$data['main_content'] = 'all_type_customer_view';	
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);
		}
		
		function point_view()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['sale_status'] = '';
			$data['status'] = '';
			
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
		/* 	$this -> load -> library('pagination');
		    $this -> load -> library('table');
		    $this -> load -> library('javascript');
			$config['base_url'] = base_url().'index.php/site_controller/all_registerd_customer/';
			$this -> load -> model('site_model');
			$config['total_rows'] = $this -> site_model -> num_of_registerd_customer();
	        $config['per_page'] = 15;
	        $config['num_links'] = 5;
			$config['uri_segment'] = 3;
			$config['full_tag_open'] = '<div id="pagination">';
			$config['full_tag_close'] = '</div>';
			$this -> pagination -> initialize($config); */
			
		//	$data['all_registerd_customer'] = $this -> site_model -> all_registerd_customer_pagination( $config['per_page'] );
		$data['all_point_customer_all']=$this -> site_model -> all_point_customer_all();

		if($this -> input -> post('submit2') || $this -> input -> post('submit1')) { 
			if( $this -> input -> post('submit1'))
			{
			   $data['start_date'] = $this -> input -> post('specific_date');
			   $data['end_date'] = $this -> input -> post('specific_date');
			}
			elseif( $this -> input -> post('submit2')){
				$data['start_date'] = $this -> input -> post('start_date');
				$data['end_date'] = $this -> input -> post('end_date');
			}
			$data['all_point_customer']=$this -> site_model -> all_point_customer($data['start_date'] , $data['end_date'] );
			
			}
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'point_search_form_view';
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);
			
		}
		function point_result_view(){
			
			$data['main_content'] = 'point_search_form_view';	
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);
		}
		
		
		/* ---------------15-07-2014----------------
        *  For Barcode printing  
        *   
        *  Section : Accounts
		*--------------------------------------------*/
		function searchBarcode()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['user_id'] = $this -> tank_auth -> get_user_id();
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();	
			$data['shop_name'] = $this -> tank_auth -> get_shopname();
			$data['shop_address'] = $this -> tank_auth -> get_shopaddress();
			$data['access_status'] = '';
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['alarming_level'] = FALSE;
		    $query = $this -> sale_model -> productsss_info(FALSE, 0, $this -> tank_auth -> get_shop_id());
			$temp[''] = 'Select A Product';
			foreach($query -> result() as $field):
				 $temp[base_url().'site_controller/searchBarcode/'.$field->product_id] = $field -> product_name;
			endforeach;
			$data['product_info'] = $temp;
			
			$data['product_type'] = 'nil';
			if($this -> input -> post('productId'))
		    	$product_ID = $this -> input -> post('productId'); // from submission
			else $product_ID = $this -> uri -> segment(3) ; // from url

			$query_two = $this -> site_model -> products_special_information($product_ID, $this -> tank_auth -> get_shop_id());
			
			foreach($query_two -> result() as $field):
				 $data['product_name'] = $field -> product_name;
				 $data['available_stock'] = $field -> available_stock;
				 $data['product_type'] = $field -> product_specification;
				 $data['buy_price'] = $field -> bulk_unit_buy_price;
				 $data['sale_price'] = $field -> bulk_unit_sale_price;
				 $data['general_sale_price'] = $field -> general_unit_sale_price;
			endforeach;

			if($this -> uri -> segment(3))
			{
				$this->form_validation->set_rules('product_id', ' ', 'trim|required|xss_clean');
				if( $data['product_type'] == 'bulk')
						$this->form_validation->set_rules('Quantity', ' ', 'trim|required|xss_clean|numeric');
			}
			else
			{
				$this->form_validation->set_rules('productId', ' ', 'trim|required|xss_clean');

				if( $data['product_type'] == 'bulk')
					$this->form_validation->set_rules('Quantity', ' ', 'trim|required|xss_clean|numeric');
				else $this->form_validation->set_rules('special_for_individual', ' ', 'trim|required|xss_clean|numeric');
			}
			$data['find_all_stock_id']= $this -> site_model -> find_all_stock_id($product_ID, $this -> tank_auth -> get_shop_id());

			if($this->form_validation->run())
			{
				$data['status'] = 'successful';
				$SALE_price = $this -> input -> post('unit_sale_price');
				$g_price = $this -> input -> post('general_sale_price');
				$PRODUCT_NAME = $this -> input -> post('PRODUCT_NAME');
				$this -> site_model -> makeBarcode($product_ID,$PRODUCT_NAME,$data['product_type'],$SALE_price,$g_price,$data['find_all_stock_id']);
			}
			
			$data['listed_product'] = $this -> site_model -> get_barcode_all_listed_product();
			
			//$data['main_content'] = 'searchBarcodeview';
			//$data['tricker_content'] = 'tricker_search_option_view';
			//$this -> load -> view('include/template', $data);
			$this -> load -> view('searchBarcodeview', $data);
		}
		
		function return_by_barcode(){
			
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['alarming_level'] = FALSE;
			$data['status'] = '';
			if($this->uri->segment(4)){
				$data['status'] = $this->uri->segment(4);
			}
			
			if($this->uri->segment(3)!='' && $this->uri->segment(3)!='mm'){
				
				$this->db->where('barcode',$this->uri->segment(3));
				$que = $this->db->get('product_info');
				$row = $que -> row_array();
				$data['product_id'] = $row['product_id'];

				$data['sold_product_details'] = $this -> site_model -> specific_sold_product_details_bulk(  $data['product_id']);
				foreach ( $data['sold_product_details'] -> result() as $field):
					$data['unit_buy_price'] = $field -> bulk_unit_buy_price;
					$data['exact_sale_price'] =$field -> bulk_unit_sale_price;
				endforeach;
			}
			
			$data['tricker_content'] = 'tricker_modify_view';
			$data['main_content'] = 'return_by_barcode_view';
			$this -> load -> view('include/template', $data);
		}
		function download_database(){
			
			$temp = $this -> registration_model -> backup_database();
			echo json_encode($temp);
		}

        
	}
