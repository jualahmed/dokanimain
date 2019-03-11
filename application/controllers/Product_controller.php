<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
class Product_controller extends CI_controller{
	
	private $shop_id;
	/*********************************
	 * $temp = preg_replace('/\s+/', '~',$field->catagory_name);
	 **********************/
	public function __construct()
	{
		parent::__construct();
		
		
		$this -> shop_id = $this -> tank_auth -> get_shop_id();
		$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		
		$this->is_logged_in();
	}
	/* checking login status */
	public function is_logged_in()
	{
		$this->load->library('tank_auth');
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login','refresh');
		}
	}
	
	function report_results()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'catagory_entry'))
		{
			$data['sale_status'] = '';
			$data['alarming_level'] = FALSE;
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$this -> load -> view('report_results_form_view', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}
	
	
	
	
	
	
	/****************************
	 * Vision Express
	 * Transfer Product
	 * 10-12-2013
	 * Arafat Mamun
	******************************/
	function transfer_product()
	{
		$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['sale_status'] = '';
			$data['status'] = "";
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['alarming_level'] = FALSE;
			
			/********* Sale Status ********/
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
			/********* End Sale Status ********/
			
			$data['running_my_sales'] = $this -> sale_model -> running_my_sales($this->tank_auth->get_user_id(), $this->tank_auth->get_shop_id());
			$data['currrent_temp_sale_id'] = $this -> tank_auth -> get_current_temp_sale();
			
			$this -> load -> library('form_validation');
			$this->form_validation->set_rules('current_shop_id', ' ', 'trim|required|xss_clean|numeric');
			$this->form_validation->set_rules('selected_product_id', ' ', 'trim|required|xss_clean|numeric');
			$this->form_validation->set_rules('selected_shop_id', 'Select Shop', 'trim|required|xss_clean|numeric');
			$this->form_validation->set_rules('selected_product_quantity', 'Product Quantity', 'trim|required|xss_clean|numeric');
			
			if($this->form_validation->run())
			{
				if($this -> product_model -> transfer_product(
					$this->form_validation->set_value('current_shop_id'),
					$this->form_validation->set_value('selected_product_id'),
					$this->form_validation->set_value('selected_shop_id'),
					$this->form_validation->set_value('selected_product_quantity')))
				$data['status'] = "successful";
			}
			if(!$this->form_validation->run()) $data['status'] = 'validation_msg';
			
			
			$query = $this -> product_model -> specific_shop_products($this -> tank_auth -> get_shop_id(), FAlSE, 0);
			$product[''] = 'Select A Product';
			foreach($query -> result() as $field):
				$product[ base_url().'index.php/product_controller/transfer_product/'.$field -> product_id ] = $field -> product_name;
			endforeach;
			$data['all_product'] = $product;
			
			if($data['selected_product'] = $this -> uri -> segment(3))
			{
				$data['general_details'] = $this -> product_model -> specific_shop_products($this -> tank_auth -> get_shop_id(), TRUE, $data['selected_product']);
				$data['shop_wise_product'] = $this -> product_model -> shop_wise_product($data['selected_product'], TRUE);
			}
			
			$data['current_shop'] = $this -> shop_id;
			
			$query = $this -> report_model -> shop_information(FALSE, 0);
			$temp[''] = 'Select Shop';
			if($query -> num_rows < 1) $temp[ '' ] = 'No Shop is listed Yet!';
			foreach($query -> result() as $field):
				if($field -> shop_id == $this -> shop_id) continue;
				$temp[ $field -> shop_id ] = $field -> shop_name.' ( '.$field -> shop_address .' )';
			endforeach;
			$data['all_shop'] = $temp;
			
			$data['main_content'] = 'transfer_product_view';
			$data['tricker_content'] = 'tricker_product_view';
			$this -> load -> view('include/template', $data);
	}
	
	/* product  */
	function product()
	{
		//* for sale Running Status */
		$data['sale_status'] = '';
		/* end of Sale running Status*/
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		$data['access_status'] = $this -> uri -> segment(3);
		$data['alarming_level'] = FALSE;
		$data['main_content'] = 'product_view';
		$data['tricker_content'] = 'tricker_product_view';
		$this -> load -> view('include/template', $data);
	}
	
	/* create a setup_entry */
	function setup_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'catagory_entry'))
		{
			$data['sale_status'] = '';
			$data['alarming_level'] = FALSE;
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$this -> load -> view('setup_entry_form_view', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}
	function modify_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'catagory_entry'))
		{
			$data['sale_status'] = '';
			$data['alarming_level'] = FALSE;
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$this -> load -> view('modify_entry_form_view', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}
	function purchase_entry_view_details()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'catagory_entry'))
		{
			$data['sale_status'] = '';
			$data['alarming_level'] = FALSE;
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$this -> load -> view('purchase_entry_form_view_details', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}
	function catagory_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'catagory_entry'))
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			$data['alarming_level'] = FALSE;
			//$data['main_content'] = 'catagory_entry_form_view';
			//$data['tricker_content'] = 'tricker_product_view';
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			//$this -> load -> view('include/template', $data);
			//$data['main_content'] = 'shop_setup_view';
				//$data['tricker_content'] = 'tricker_registration_view';
				$this -> load -> view('catagory_entry_form_view', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}
	
	/* create catagory */
	function create_catagory()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'catagory_entry'))
		{
			$data['sale_status'] = '';
			$data['status'] = '';
			$this -> load -> library('form_validation');
			$this -> form_validation -> set_rules('catagory_name', 'Catagory Name','required');
			$this -> form_validation -> set_rules('catagory_description', 'Catagory Description');
			$data['user_name'] = $this->tank_auth->get_username();
			
			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
			}
			else
			{
				$this -> load -> model('product_model');
				$catagory_name = $this -> input ->post('catagory_name');
																	// table_name   ,  field name,      element
				$exists = $this -> product_model -> redundancy_check('catagory_info', 'catagory_name', $catagory_name);
				if($exists == true)
				{
					$data['status'] = 'exists';
					$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissible" style="background:#f39c12;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Already Exist</h4>
				</div>');
				}
				else if($this -> product_model -> create_catagory())
					{
						$data['status'] = 'successful';
						$this->session->set_flashdata('msg1', '<div class="alert alert-success alert-dismissible" style="background:#00a65a;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Success</h4>
				</div>');
					}
				else
				{
					$data['status'] = 'failed';
					$this->session->set_flashdata('msg2', '<div class="alert alert-danger alert-dismissible" style="background:#dd4b39;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Failed</h4>
				</div>');
				}
			}
			$this -> load -> view('catagory_entry_form_view', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}

	/* product entry form */
	function product_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			$data['alarming_level'] = FALSE;
			$data['last_id'] = $this->product_model->getLastInserted();
			//$data['main_content'] = 'product_entry_form_view';
			//$data['tricker_content'] = 'tricker_product_view';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['status'] = '';
			$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id();
			$data['distributor_info'] = $this -> product_model -> distributor_info();
			$data['company_name'] = $this -> product_model -> company_name();
			$data['catagory_name'] = $this -> product_model -> catagory_name();
			$data['product_specification'] = $this -> product_model -> product_specification();
			$data['unit_name'] = $this -> product_model -> unit_name();
			$this -> load -> view('product_entry_form_view', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}
	
	/* create product */
	function create_product()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
		{

			$data['sale_status'] = '';
			$data['status'] = '';

			$this -> load -> library('form_validation');
			$this -> form_validation -> set_rules('product_specification', 'Product Specification', 'required');
			$this -> form_validation -> set_rules('catagory_name', 'Catagory Name','required');
			$this -> form_validation -> set_rules('company_name', 'Company Name','required');
			/* $this -> form_validation -> set_rules('product_type', 'Product Type','required');
			$this -> form_validation -> set_rules('product_size', 'Product Size', 'required');
			$this -> form_validation -> set_rules('product_model', 'Product Model','required'); */
			$this -> form_validation -> set_rules('customProductName', 'Product Model','required');
			$this -> form_validation -> set_rules('product_description', 'Product Description');
			//$this -> form_validation -> set_rules('receipt_id', 'Purchase Recipt ID','required');
			//$this -> form_validation -> set_rules('purchase_quantity', 'Purchase Quantity','required|numeric');
			//$this -> form_validation -> set_rules('unit_buy_price', 'Buy Price', 'required|numeric');
			//$this -> form_validation -> set_rules('bulkUnitSalePrice', 'Sale Price Price', 'required|numeric');
			$this -> form_validation -> set_rules('alarming_stock', 'Alarming Stock', 'numeric');
			
			$data['user_name'] = $this->tank_auth->get_username();
			$data['alarming_level'] = FALSE;
			//$data['main_content'] = 'product_entry_form_view';
			//$data['tricker_content'] = 'tricker_product_view';
			$this -> load -> model('product_model');
			$data['product_specification'] = $this -> product_model -> product_specification();
			$data['unit_name'] = $this -> product_model -> unit_name();
			$data['company_name'] = $this -> product_model -> company_name_1();
			$data['catagory_name'] = $this -> product_model -> catagory_name();
			//$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id();
			$data['distributor_info'] = $this -> product_model -> distributor_info();
			$data['last_id'] = $this->product_model->getLastInserted();												
			$exists = $this -> product_model -> redundancy_check_for_new_product();
			if($exists)
			{
				$data['status'] = 'exists';
				//$this -> load -> view('include/template', $data);
			}
			else if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
				//$this -> load -> view('include/template', $data);
			}
			else
			{
				$this -> load -> model('product_model');	
				if($this -> product_model -> create_product())
				{
					
					$data['status'] = 'successful';
				}
				else
				{
					$data['status'] = 'failed';
				}
			}
			$this -> load -> view('product_entry_form_view', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}
	/* card entry form */
	function card_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['sale_status'] = '';
			$data['alarming_level'] = FALSE;
			$data['last_id'] = $this->product_model->getLastInserted();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['status'] = '';
			$data['bank'] = $this -> my_variables_model -> fatch_all_bank();
			$data['service_provider_info'] = $this -> my_variables_model -> fatch_service_provider_info();	
			$this -> load -> view('card_entry_form_view', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}
	
	/* create product */
	function create_card()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
		{

			$data['sale_status'] = '';
			$data['status'] = '';

			$data['user_name'] = $this->tank_auth->get_username();
			$data['alarming_level'] = FALSE;
			$this -> load -> model('my_variables_model');
			$data['bank'] = $this -> my_variables_model -> fatch_all_bank();												

				$this -> load -> model('product_model');	
				if($this -> product_model -> create_card())
				{
					
					$data['status'] = 'successful';
				}
				else
				{
					$data['status'] = 'failed';
				}
			$this -> load -> view('card_entry_form_view', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}

	/* call purchase entry form */
	function purchase_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'purchase_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			$data['status'] = '';
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'purchase_entry_form_view';
			$data['tricker_content'] = 'tricker_product_view';
			$data['user_name'] = $this->tank_auth->get_username();
			$this -> load -> model('product_model');
			$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id();
			//$data['product_info'] = $this -> product_model -> product_info();
			$query = $this -> joy_model -> productInfoGeneral(FALSE, 0);
			$product[''] = 'Select A Product';
			foreach($query -> result() as $field):
			 $product[base_url().'product_controller/purchase_entry/'.$field -> product_id] = $field -> product_name;
			endforeach;
			$data['product_info'] = $product;
			$data['distributor_info'] = $this -> product_model -> distributor_info();
			
			if($this->uri->segment(3)){
				$data['productInfoDetails'] =  $this -> joy_model -> productInfoDetails_for_purchase(TRUE, $this -> uri -> segment(3));
			}
			$this -> load -> view('include/template', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}
    
        function purchase_entry1(){
           if($this->input->post()){
           $key=$this->input->post('keyupvalu');
           $forjson=array();
            $this->db->like('product_name', $key); 
			
            //$this->db->limit(10);
            $query = $this->db->get('product_info');
              foreach ($query->result() as $row)
                {
                    $arays['product_name']=$row->product_name;
                    $arays['product_id']=$row->product_id;
                    $arays['catagory_name']=$row->catagory_name;
                    $arays['company_name']=$row->company_name;
                    $arays['group_name']=$row->group_name;
                    array_push($forjson,$arays);
                }
                
                echo json_encode($forjson);
                
              }else{
                echo 'Erro 404';
              }
            
        }
		
		function purchase_entry2(){
           if($this->input->post()){
           $key=$this->input->post('keyupvaluu');
           $forjson=array();
            $this->db->like('product_name', $key); 
			
            //$this->db->limit(10);
            $query = $this->db->get('product_info');
              foreach ($query->result() as $row)
                {
                    $arays['product_name']=$row->product_name;
                    $arays['product_id']=$row->product_id;
                    $arays['catagory_name']=$row->catagory_name;
                    $arays['company_name']=$row->company_name;
                    $arays['group_name']=$row->group_name;
                    array_push($forjson,$arays);
                }
                
                echo json_encode($forjson);
                
              }else{
                echo 'Erro 404';
              }
            
        }
		
		function discount_entry1(){
           if($this->input->post()){
           $key=$this->input->post('keyupvalu');
           $forjson=array();
            $this->db->like('product_name', $key); 
			
            //$this->db->limit(10);
            $query = $this->db->get('product_info');
              foreach ($query->result() as $row)
                {
                    $arays['product_name']=$row->product_name;
                    $arays['product_id']=$row->product_id;
                    $arays['catagory_name']=$row->catagory_name;
                    $arays['company_name']=$row->company_name;
                    $arays['group_name']=$row->group_name;
                    array_push($forjson,$arays);
                }
                
                echo json_encode($forjson);
                
              }else{
                echo 'Erro 404';
              }
            
        }
		function warranty_entry1(){
           if($this->input->post()){
           $key=$this->input->post('keyupvalu');
           $forjson=array();
            $this->db->like('product_name', $key); 
			
            //$this->db->limit(10);
            $query = $this->db->get('product_info');
              foreach ($query->result() as $row)
                {
                    $arays['product_name']=$row->product_name;
                    $arays['product_id']=$row->product_id;
                    $arays['catagory_name']=$row->catagory_name;
                    $arays['company_name']=$row->company_name;
                    $arays['group_name']=$row->group_name;
                    array_push($forjson,$arays);
                }
                
                echo json_encode($forjson);
                
              }else{
                echo 'Erro 404';
              }
            
        }
	
	/* Create a new purchase */
	function create_purchase()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'purchase_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			
			$this -> load -> library('form_validation');
			$this -> form_validation -> set_rules('receipt_id', 'Purchase Recipt ID','required');
			$this -> form_validation -> set_rules('product_id', 'Product Name','required');
			//$this -> form_validation -> set_rules('distributor_id', 'Distributor Name','required');
			$this -> form_validation -> set_rules('purchase_quantity', 'Purchase Quantity','required|numeric');
			$this -> form_validation -> set_rules('unit_buy_price', 'Buy Price', 'required|numeric');
			$this -> form_validation -> set_rules('unit_sale_price', 'Sale Price', 'required|numeric');
			$this -> form_validation -> set_rules('purchase_expire_date', 'Expiry Date');
			//$this -> form_validation -> set_rules('product_description', 'Product Description');
			$data['product_id'] =  $this -> input -> post('product_id');
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'purchase_entry_result_view';
			$data['tricker_content'] = 'tricker_product_view';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['status'] = '';

			$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id();
			$query = $this -> joy_model -> productInfoGeneral(FALSE, 0);
			foreach($query -> result() as $field):
			 $product[base_url().'product_controller/purchase_entry/'.$field -> product_id] = $field -> product_name;
			endforeach;
			$data['product_info'] = $product;
			//$data['distributor_info'] = $this -> product_model -> distributor_info();



			/* Barcode Integration Starts Here : 02-07-2014 */

			$pro_id = $this -> input -> post('product_id');

				
			$this -> load -> library('pagination');
			$this -> load -> library('table');
			$this -> load -> library('javascript');
			$this -> table -> set_heading('Serial','Stock ID','Purchase Date');
			$config['base_url'] = base_url().'index.php/product_controller/create_purchase'. $pro_id ;
			$config['per_page'] = 15;
		    $config['num_links'] = 5;
			$config['uri_segment'] = 4;
			$config['full_tag_open'] = '<div id="pagination">';
			$config['full_tag_close'] = '</div>';


			$this -> load -> add_package_path(APPPATH.'third_party/Zend_framework');
			$this -> load -> library('zend_framework');


			if($this -> site_model -> product_specification( $pro_id )) // this function returns true if the product is an individual one.
			{
				$config['total_rows'] = $this -> site_model -> by_product_name_result_no_of_row($pro_id) ;
				$data['records'] = $this -> site_model -> unitSalePrice($pro_id);
				$data['stock_element'] = true;
				//$data['pro_specification'] = 'Individual';
			}
			else
			{
				$config['total_rows'] = 1;
				$data['records'] = $this -> site_model -> unitSalePrice($pro_id);
				$data['bulk_element'] = true;
				//$data['pro_specification'] = 'Bulk';
			}
			
			foreach ($data['records'] ->result() as $field):
				$ForBarcodeUnitSalePrice = $field -> bulk_unit_sale_price; //using for barcode generate
			endforeach;
			
			if($data['records'] -> num_rows() < 1) $ForBarcodeUnitSalePrice = '';


			if($this -> input -> post('product_id', true))
			{	
				/*
				$barcodeOptions = array('text' => 'A');
				$rendererOptions = array(
										'text' => '3588',
										'barHeight' => '100'
									);
				$data['barcode'] = Zend_Barcode::factory('code39', 'image', $barcodeOptions, $rendererOptions)->render();
				*/
				/*
				$config = new Zend_Config(array(
											'barcode'        => 'code39',
											'barcodeParams'  => array(
																	'text' => 'AC-15896',
																	'barHeight' => '20',
																	'font' => '2',
																	'barThickWidth' => 3,
																	'withBorder' => true,
																	'factor' => 1,
																	'height' => '100px',
																	'width' => '200px',
																	'withQuietZones' => true,
																	'drawText' => true,
																	'stretchText' => true,
																),
											'renderer'       => 'image',
											'rendererParams' => array('imageType' => 'jpg'),
										));
				$data['action'] = Zend_Barcode::factory($config) -> render();
				*/
				///$name = $this -> input -> post('product_id');
				//$productID = $name;


				$barcodeOptions = array('text' => $pro_id );
	 
				$bc = Zend_Barcode::factory(
					'code39',
					'image',
					$barcodeOptions,
					array()
				);
				/* @var $bc Zend_Barcode */
				$res = $bc->draw();
				$filename = './images/barcode/'.$pro_id;
				imagepng($res, $filename);


				$pro_info=$this -> product_model -> fatch_product_info_forprint($pro_id);

				if($pro_info -> num_rows() > 0 )
				{    
					foreach ($pro_info -> result() as $field):
					 $pro_name= $field ->product_name;
					 $data['pro_specification'] = $field ->product_specification;
					endforeach;
				}

				$this->session->set_userdata(array(
						'product_id'	=> $pro_id,
						'purchase_quantity' => $this -> input -> post('purchase_quantity'),
						'product_name' => $pro_name,
						'pro_specification' => $data['pro_specification'],
						'product_price' => $ForBarcodeUnitSalePrice
						));
			}
           /*---------------END-------For print and barcode generate ---------------------------------*/





			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
				$this -> load -> view('include/template', $data);
			}
			else
			{
				$serial = $this -> input ->post('serial');
				if($query = $this -> product_model -> create_purchase()) 			// required
				{
					if($last_purchase_id = mysql_insert_id())
					{
						$this -> product_model -> create_stock();					// required
						$data['end'] = mysql_insert_id() ;
						$data['status'] = 'successful';
						$data['original'] = $quantity = $this -> input ->post('purchase_quantity');
						/* individual product system enabled on 28-06-14 */
						if($serial == 'yes' && $this -> product_model -> get_product_specification( $this -> input -> post('product_id') ))
						{
								$data['stock_id'] =$data['end']  - $quantity + 1;
								$pro_id = $this -> input -> post('product_id');
								$data['last_purchase_id'] = $last_purchase_id;
								$data['quantity'] = $quantity - 1;
								$data['product_name'] =  $this -> product_model -> specific_product_name($pro_id);
								$data['main_content'] = 'product_serial_no_view';
								$data['tricker_content'] = 'tricker_product_view';
								//$this -> load -> view('include/template', $data);

								if($data['pro_specification'] == "individual")
								{
									$data['start'] = $data['end'] - $quantity + 1;

									for($i=$data['start'] ; $i<=$data['end']; $i++)
									{
										$barcodeOptions = array('text' => $i );
							 
										$bc = Zend_Barcode::factory(
											'code39',
											'image',
											$barcodeOptions,
											array()
										);
										/* @var $bc Zend_Barcode */
										$res = $bc->draw();
										$filename = './images/barcode/'.$i;
										imagepng($res, $filename);
									}


									$pro_info=$this -> product_model -> fatch_product_info_forprint($pro_id);

									if($pro_info -> num_rows() > 0 )
									{    
										foreach ($pro_info -> result() as $field):
										 $pro_name= $field ->product_name;
										endforeach;
									}

									$this->session->set_userdata(array(
											'product_id'	=> $pro_id,
											'purchase_quantity' => $this -> input -> post('purchase_quantity'),
											'product_name' => $pro_name,
											'pro_specification' => $data['pro_specification'],
											'stock_start' => $data['start'],
											'stock_end' => $data['end'],
											));		
								}		
								
								
						}
						else
						{
							if( $this -> product_model -> get_product_specification( $this -> input -> post('product_id')))
							{
								
								if($data['pro_specification'] == "individual")
								{
									$data['start'] = $data['end'] - $quantity + 1;

									for($i=$data['start'] ; $i<=$data['end']; $i++)
									{
										$barcodeOptions = array('text' => $i );
							 
										$bc = Zend_Barcode::factory(
											'code39',
											'image',
											$barcodeOptions,
											array()
										);
										/* @var $bc Zend_Barcode */
										$res = $bc->draw();
										$filename = './images/barcode/'.$i;
										imagepng($res, $filename);
									}


									$pro_info=$this -> product_model -> fatch_product_info_forprint($pro_id);

									if($pro_info -> num_rows() > 0 )
									{    
										foreach ($pro_info -> result() as $field):
										 $pro_name = $field ->product_name;
										endforeach;
									}

									$this->session->set_userdata(array(
											'product_id'	=> $pro_id,
											'purchase_quantity' => $this -> input -> post('purchase_quantity'),
											'product_name' => $pro_name,
											'pro_specification' => $data['pro_specification'],
											'stock_start' => $data['start'],
											'stock_end' => $data['end'],
											));		
								}		
							}
							else
							{
								$data['end'] = 'Applicable';
								$data['start'] = 'Not';
							}
							
							//$this -> load -> view('include/template', $data);
						} 
						/* individual product system enabled on 28-06-14 */
						$this -> load -> view('include/template', $data);
					}
					else
					{
						$data['status'] = 'failed';
						$this -> load -> view('product_entry_form_view');
					}
				}
			}
		}
	    else redirect('product_controller/product/noaccess');
	}

	/* Entry Product Serial Number */ 
	function update_serial()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'purchase_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			$this -> load -> library('form_validation');
			$this -> form_validation -> set_rules('serial_no', 'Serial No', 'required');	
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$this -> load -> model('product_model');
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'product_serial_no_view';
			$data['tricker_content'] = 'tricker_product_view';
			$data['product_id'] =  $this -> input -> post('product_id');
			$data['original'] = $this -> input ->post('original');
			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
				$data['stock_id'] = $this -> input -> post('stock_id');
				$data['last_purchase_id'] = $this -> input -> post('last_purchase_id');
				$data['quantity'] = $this -> input ->post('quantity');
				$data['product_name'] =  $this -> input -> post('product_name');
				$this -> load -> view('include/template', $data);
			}
			else
			{
				if($this -> product_model -> serial_no_check($this -> input -> post('product_id'), $this -> input -> post('serial_no')))
				{
					$data['status'] = 'exists';
					$data['stock_id'] = $this -> input -> post('stock_id');
					$data['last_purchase_id'] = $this -> input -> post('last_purchase_id');
					$data['quantity'] = $this -> input ->post('quantity');
					$data['product_name'] =  $this -> input -> post('product_name');
					$this -> load -> view('include/template', $data);
				}
				else if($query = $this -> product_model -> update_serial_no())
				{
					$quantity = $this -> input ->post('quantity');
					$data['status'] = 'successful';
					if($quantity > 0)
					{
						$data['stock_id'] = $this -> input -> post('stock_id') + 1;
						$data['last_purchase_id'] = $this -> input -> post('last_purchase_id');
						$data['quantity'] = $quantity - 1;
						$data['product_name'] =  $this -> input -> post('product_name');
						$this -> load -> view('include/template', $data);
					}
					else
					{
						$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id();
						$data['end'] = $this -> input -> post('stock_id') ;
						$data['start'] = $this -> input -> post('stock_id') - $data['original'] + 1;
						//$data['main_content'] = 'purchase_entry_form_view';
						$data['main_content'] = 'purchase_entry_result_view';
						$data['user_name'] = $this->tank_auth->get_username();
						$this -> load -> model('product_model');
						$data['product_info'] = $this -> product_model -> product_info();
						$data['distributor_info'] = $this -> product_model -> distributor_info();
						$this -> load -> view('include/template', $data);
					}

				}
				else
				{
					$data['status'] = 'failed';
					$this -> load -> view('include/template', $data);
				}
			}
		}
	    else redirect('product_controller/product/noaccess');
	}

	/* Sale price */
	function sale_price()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'sale_price'))
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			$this -> load -> model('product_model');
			$temp = $this -> product_model -> product_info_onclick();
			$product[''] = 'Select A Product';
			foreach($temp -> result() as $field):
				$product[ base_url().'index.php/product_controller/sale_price/'.$field -> product_id ] = $field -> product_name;
			endforeach;
			$data['product_info'] = $product; 
			if($this -> uri -> segment(3))
			{
				$data['product_general'] = $this -> product_model -> product_general_details();
			}

			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'sale_price_entry_view';
			$data['tricker_content'] = 'tricker_product_view';
			$this -> load -> view('include/template', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}

	/* Sale Price Entry */
	function sale_price_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'sale_price'))
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			$this -> load -> library('form_validation');
			$this -> form_validation -> set_rules('product_id', 'Product Name','numeric|required');
			$this -> form_validation -> set_rules('unit_sale_price', 'Sale Price','trim|required|numeric');
			$data['user_name'] = $this->tank_auth->get_username();
			$this -> load -> model('product_model');
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'sale_price_entry_view';
			$data['tricker_content'] = 'tricker_product_view';
			
			$temp = $this -> product_model -> product_info_onclick();
			$product[''] = 'Select A Product';
			foreach($temp -> result() as $field):
				$product[ base_url().'index.php/product_controller/sale_price/'.$field -> product_id ] = $field -> product_name;
			endforeach;
			$data['product_info'] = $product; 
			if($this -> uri -> segment(3))
			{
				$data['product_general'] = $this -> product_model -> product_general_details();
			}
			
			if($this -> form_validation -> run() ==  FALSE)
				$data['status'] = 'error';
			else 
			{
				$pro_id = $this -> input -> post('product_id');
				
				$run = $this -> product_model -> sale_price_entry();
				if($run)
					$data['status'] = 'successful';
				else
					$data['status'] = 'failed';
				
			}
			$this -> load -> view('include/template', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}
    /* for Shelf setup*/
	function shelf_set_up()
	{
		/*$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'shelf_set_up'))
		{*/
			$data['sale_status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['main_content'] = 'shelf_set_up_view';
			$data['tricker_content'] = 'tricker_product_view';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['status'] = '';
			$this -> load -> model('product_model');
			$data['company_name'] = $this -> product_model -> company_name();
			$data['catagory_name'] = $this -> product_model -> catagory_name();
			$data['product_specification'] = $this -> product_model -> product_specification();
			$data['alarming_level'] = FALSE;
			$this -> load -> view('include/template', $data);
		/*}
	    else redirect('product_controller/product/noaccess');*/
	}
	/* Create a new shelf */
	function create_shelf()
	{
		$data['sale_status'] = '';
		$this -> load -> library('form_validation');
		$this -> load -> model('product_model');
		
		$this -> form_validation -> set_rules('shelf_no', 'Shelf No','required');
		$this -> form_validation -> set_rules('row', 'Now Of Rows','required');
		$this -> form_validation -> set_rules('column', 'No Of Column','required');
		$this -> form_validation -> set_rules('shelf_description', 'Shelf Description');
		
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		
		$data['alarming_level'] = FALSE;
		$data['main_content'] = 'shelf_set_up_view';
		$data['tricker_content'] = 'tricker_product_view';
		
	
															// table_name   ,  field name,      element
		$exists = $this -> product_model -> redundancy_check('shelf_info', 'shelf_no', $this -> input -> post('shelf_no'));
		if($exists)
		{
			$data['status'] = 'exists';
			$this -> load -> view('include/template', $data);
		}
		else if($this -> form_validation -> run() ==  FALSE)
		{
			$data['status'] = 'error';
			$this -> load -> view('include/template', $data);
		}
		else
		{
				
			if($this -> product_model -> create_shelf())
			{
				$data['status'] = 'successful';
				$this -> load -> view('include/template', $data);
			}
			else
			{
				$data['status'] = 'failed';
				$this -> load -> view('include/template', $data);
			}
		}
	}
     /* for store in shelf entry*/
	function store_in_shelf_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'store_in_shelf_entry'))
		{
			$data['sale_status'] = '';
			$data['main_content'] = 'store_in_shelf_entry_view';
			$data['tricker_content'] = 'tricker_product_view';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['status'] = '';
			$this -> load -> model('product_model');
			$data['company_name'] = $this -> product_model -> company_name();
			$data['catagory_name'] = $this -> product_model -> catagory_name();
			$data['all_shelf_no'] = $this -> product_model -> all_shelf_no_onlick();
			$data['alarming_level'] = FALSE;
			$shelf_no = $this -> uri -> segment(3);
			if($shelf_no == 'successful') $data['status'] = 'successful';
			if($shelf_no != 'successful' )
			{
				/* facth row ,col quantity of a specific shelf */
				$data['row_col_quantity'] = $this -> product_model -> fatch_no_of_row_col();
			}
			$data['product_info'] = $this -> product_model -> product_info();
			$this -> load -> view('include/template', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}
	
	/* to store a specific product in a spefic location*/
	function create_store_in_shelf_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'store_in_shelf_entry'))
		{
			$data['sale_status'] = '';
			$this -> load -> library('form_validation');
			$this -> load -> model('product_model');
			
			$this -> form_validation -> set_rules('shelf_no', 'Shelf No','required');
			//$this -> form_validation -> set_rules('row', 'Now Of Rows','required');
			//$this -> form_validation -> set_rules('column', 'No Of Column','required');
			$this -> form_validation -> set_rules('product_id', 'Product name','required');
			
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['alarming_level'] = FALSE;
			
			$data['main_content'] = 'store_in_shelf_entry_view';
			$data['tricker_content'] = 'tricker_product_view';
			$data['all_shelf_no'] = $this -> product_model -> all_shelf_no_onlick();
			$data['row_col_quantity'] = $this -> product_model -> fatch_no_of_row_col();
																// table_name   ,  field name,      element
			//$exists = $this -> product_model -> redundancy_check('shelf_info', 'shelf_no', $this -> input -> post('shelf_no'));
			
			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
				$data['product_info'] = $this -> product_model -> product_info();
				$this -> load -> view('include/template', $data);
			}
			else
			{
					
				if($this -> product_model -> create_store_in_shelf())
				{
					$data['status'] = 'successful';
					$this -> load -> view('include/template', $data);
					redirect('product_controller/store_in_shelf_entry/successful');
				}
				else
				{
					$data['status'] = 'failed';
					$data['product_info'] = $this -> product_model -> product_info();
					$this -> load -> view('include/template', $data);
				}
			}
		}
	    else redirect('product_controller/product/noaccess');
	}

	/**********************************************
	 * Select Product Avibality Status of a product
	 **********************************************/
	function change_product_status_form()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'change_product_status'))
		{
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$temp = $this -> product_model -> product_info_onclick();
			$product[''] = 'Select A Product';
			foreach($temp -> result() as $field):
				$product[ base_url().'index.php/product_controller/change_product_status_form/'.$field -> product_id ] = $field -> product_name;
			endforeach;
			$data['product_info'] = $product; 
			if($this -> uri -> segment(3))
			{
				$data['product_general'] = $this -> product_model -> product_general_details();
			}
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'change_product_status_view';
			$data['tricker_content'] = 'tricker_product_view';
			$this -> load -> view('include/template', $data);
		}
	    else redirect('product_controller/product/noaccess');
	 }
	 
	 /**********************************************
	 * Change Product Avibality Status of a product
	 **********************************************/
	function change_product_status()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'change_product_status'))
		{
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$temp = $this -> product_model -> product_info_onclick();
			$product[''] = 'Select A Product';
			foreach($temp -> result() as $field):
				$product[ base_url().'index.php/product_controller/change_product_status_form/'.$field -> product_id ] = $field -> product_name;
			endforeach;
			$data['product_info'] = $product; 
			if($this -> uri -> segment(3))
			{
				$data['product_general'] = $this -> product_model -> product_general_details();
			}
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'change_product_status_view';
			$data['tricker_content'] = 'tricker_product_view';
			$this -> load -> library('form_validation');
			$this -> form_validation -> set_rules('product_id', 'Product Name','required');
			$this -> form_validation -> set_rules('product_status', 'Product Status','required');
			
			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
			}
			else
			{
				if( $this -> product_model -> change_product_status() )
					$data['status'] = 'successful';
				else $data['status'] = 'failed';
			}
			$this -> load -> view('include/template', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}
	
	/*******************************************************
	 * Form to Set Minimum Level for a Product to Show Notificarions
	 ********************************************************/
	function alarming_level()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'alarming_level'))
		{
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$temp = $this -> product_model -> product_info_onclick();
			$product[''] = 'Select A Product';
			foreach($temp -> result() as $field):
				$product[ base_url().'index.php/product_controller/alarming_level/'.$field -> product_id ] = $field -> product_name;
			endforeach;
			$data['product_info'] = $product; 
			if($this -> uri -> segment(3))
			{
				$data['product_general'] = $this -> product_model -> product_general_details();
			}
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'alarming_level_form_view';
			$data['tricker_content'] = 'tricker_product_view';
			$this -> load -> view('include/template', $data);
		}
	    else redirect('product_controller/product/noaccess');
	 }

	/*******************************************************
	 * Set Minimum Level for a Product to Show Notificarions
	 ********************************************************/
	function set_alarming_level()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'alarming_level'))
		{
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
					$temp = $this -> product_model -> product_info_onclick();
			$product[''] = 'Select A Product';
			foreach($temp -> result() as $field):
				$product[ base_url().'index.php/product_controller/alarming_level/'.$field -> product_id ] = $field -> product_name;
			endforeach;
			$data['product_info'] = $product; 
			if($this -> uri -> segment(3))
			{
				$data['product_general'] = $this -> product_model -> product_general_details();
			}
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'alarming_level_form_view';
			$data['tricker_content'] = 'tricker_product_view';
			$this -> load -> library('form_validation');
			$this -> form_validation -> set_rules('product_id', 'Product Name','required');
			$this -> form_validation -> set_rules('alarming_stock', 'Product Status','required|numeric');
			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
			}
			else
			{
				if( $this -> product_model -> set_alarming_level() )
					$data['status'] = 'successful';
				else $data['status'] = 'failed';
			}
			
			$this -> load -> view('include/template', $data);
		}
	    else redirect('product_controller/product/noaccess');
	 }
	 
	 /***************************
	  * Warranty period Entry  *
	  ***************************/
	function warranty_period()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'warranty_period'))
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			$this -> load -> model('product_model');
			$temp = $this -> product_model -> product_info_onclick();
			$product[''] = 'Select A Product';
			foreach($temp -> result() as $field):
				$product[ base_url().'index.php/product_controller/warranty_period/'.$field -> product_id ] = $field -> product_name;
			endforeach;
			$data['product_info'] = $product; 
			if($this -> uri -> segment(3))
			{
				$data['product_general'] = $this -> product_model -> product_general_details();
			}
			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['alarming_level'] = FALSE;
			//$data['main_content'] = 'warranty_period_entry_view';
			//$data['tricker_content'] = 'tricker_product_view';
			$this -> load -> view('warranty_period_entry_view', $data);
		}
	    else redirect('product_controller/product/noaccess');
	}
	
	function search_product()
	{

	            $key			= $this->input->post('term');
	            $flag 			= (int)$this->input->post('flag');
	            $field_name 	= "";

	            if($flag == 1){
	            	$field_name 	= 'product_name';
	            }
				$data 	= $this->product_model->get_product($key, $field_name);
				
				$info 	= array();
				$stock 	= 0;
				
				if($data != false){
					foreach($data->result() as $tmp){
						if($tmp->stock_amount == '')$stock = 0;
						else $stock = $tmp->stock_amount;

						$info[] = array(
							'id' 						=> $tmp->product_id,
							'product_name' 				=> $tmp->product_name,
							'company_name' 				=> $tmp->company_name,
							'catagory_name' 			=> $tmp->catagory_name,
							'sale_price' 				=> $tmp->bulk_unit_sale_price,
							'buy_price' 				=> $tmp->bulk_unit_buy_price,
							'stock' 					=> $stock,
							'generic_name' 				=> $tmp->group_name,
							'barcode' 					=> $tmp->barcode,
							'product_specification' 	=> $tmp->product_specification,
							'temp_pro_data' 			=> 	$tmp->product_id . '<>' . 
															$tmp->product_name . '<>' .
															$tmp->stock_amount . '<>' .
															$tmp->bulk_unit_sale_price . '<>' .
															$tmp->bulk_unit_buy_price . '<>' .
															$tmp->product_specification
							);
					}
				}
				else{
					$info[] = array(
							'id' 						=> '',
							'product_name' 				=> 'Nothing Found',
							'company_name' 				=> '',
							'catagory_name' 			=> '',
							'sale_price' 				=> '',
							'buy_price' 				=> '',
							'stock' 					=> '',
							'generic_name' 				=> '',
							'barcode' 					=> '',
							'product_specification' 	=> '',
							'temp_pro_data' 			=> ''
							);
				}
				echo json_encode($info);
			
	}
	
	/***************************
	 * Set Up  Warranty period *
	 ***************************/
	function warranty_period_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'warranty_period'))
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			$this -> load -> library('form_validation');
			$this -> form_validation -> set_rules('product_id', 'Product Name','numeric|required');
			$this -> form_validation -> set_rules('warranty_period', 'Warranty','trim|required|numeric');
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$this -> load -> model('product_model');
			$data['alarming_level'] = FALSE;
			//$data['main_content'] = 'warranty_period_entry_view';
			//$data['tricker_content'] = 'tricker_product_view';
			
			$temp = $this -> product_model -> product_info_onclick();
			$product[''] = 'Select A Product';
			foreach($temp -> result() as $field):
				$product[ base_url().'index.php/product_controller/warranty_period/'.$field -> product_id ] = $field -> product_name;
			endforeach;
			$data['product_info'] = $product; 
			if($this -> uri -> segment(3))
			{
				$data['product_general'] = $this -> product_model -> product_general_details();
			}
			
			if($this -> form_validation -> run() ==  FALSE)
				$data['status'] = 'error';
			else 
			{
				$pro_id = $this -> input -> post('product_id');
				$exists = $this -> product_model -> redundancy_check('sale_price_info', 'product_id', $pro_id);
				if($exists) $run = $this -> product_model -> warranty_period_entry('update');
					else $run = $this -> product_model -> warranty_period_entry('insert');
				if($run)
					$data['status'] = 'successful';
				else
					$data['status'] = 'failed';
			}
			$this -> load -> view('warranty_period_entry_view', $data);
		}
	    else redirect('product_controller/product/noaccess');

	}
	/*
	 * Sale Price Entry
	 * 06-05-2014 // imported from joy shatya on 01-07-2014
	 * Arafat Mamun
	 */
	function salePriceEntry(){
		
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
		
		$this -> load -> library('form_validation');
		//$this->form_validation->set_rules('selectedProduct',  'Product Name',  'trim|xss_clean|required|numeric|greater_than[0]');
		$this->form_validation->set_rules('bulkUnitSalePrice', 'Sale Price',  'trim|xss_clean|required|numeric|greater_than[-1]');
		//$this->form_validation->set_rules('generalUnitSalePrice', 'General Sale Price',  'trim|xss_clean|required|numeric|greater_than[-1]');
		//echo $this->form_validation->set_value('selectedProduct').'/'.$this->form_validation->set_value('bulkUnitSalePrice');
		
		$selectedProduct = $this->uri->segment(3);
		$bulkUnitSalePrice = $this->input->post('bulkUnitSalePrice');
		
		/* if($this->form_validation->run())
		{
			if($this -> joy_model -> salePriceEntry($this->form_validation->set_value('selectedProduct'),
												   $this->form_validation->set_value('bulkUnitSalePrice')
												))
				$data['status'] = 'successful';
			else $data['status'] = 'error';

		} */
		if($this->form_validation->run())
		{
			if($this -> joy_model -> salePriceEntry($selectedProduct, $bulkUnitSalePrice))
			{
				$data['status'] = 'successful';
			}
			else
			{ 
				$data['status'] = 'error';
			}

		}
		$query = $this -> joy_model -> productInfoGeneral(FALSE, 0);
		$product[base_url().'product_controller/salePriceEntry/'.$this -> uri -> segment(3)] = 'Select A Product';
		foreach($query -> result() as $field):
			 $product[base_url().'product_controller/salePriceEntry/'.$field -> product_id] = $field -> product_name;
		endforeach;
		$data['productInfoGeneral'] = $product;
		
		if($this -> uri -> segment(3))
			$data['productInfoDetails'] =  $this -> joy_model -> productInfoDetails(TRUE, $this -> uri -> segment(3));

		$this -> load -> view('salePriceEntryView', $data);
	}
		function my_sale_add()
		{
			$barcode = $this -> input -> post('barcode');
			$this->db->select('product_id');
			$this->db->from('product_info');
			$this->db->where('barcode',$barcode);
			$quer=$this->db->get();
			if($quer->num_rows >0){ 
				foreach($quer -> result() as $field):
					$inputValue = $field -> product_id;
				endforeach;
				}
			if($inputValue >=  10000){
				$query = $this -> sale_model -> stockProductDetails( $inputValue );
				foreach($query -> result() as $field):
					$productId = $field -> product_id;
				endforeach;
				redirect('sale_controller/my_sale/add/'.$productId.'/'.$this -> input -> post('product_id'));
			}
			else redirect('product_controller/purchase_entry/'.$inputValue);
		}
		function sale_price_entry_barcode()
		{
			$barcode = $this -> input -> post('barcode');
			$this->db->select('product_id');
			$this->db->from('product_info');
			$this->db->where('barcode',$barcode);
			$quer=$this->db->get();
			if($quer->num_rows >0){ 
				foreach($quer -> result() as $field):
					$inputValue = $field -> product_id;
				endforeach;
				}
			if($inputValue >=  10000){
				$query = $this -> sale_model -> stockProductDetails( $inputValue );
				foreach($query -> result() as $field):
					$productId = $field -> product_id;
				endforeach;
				//redirect('sale_controller/my_sale/add/'.$productId.'/'.$this -> input -> post('product_id'));
			}
			else redirect('product_controller/salePriceEntry/'.$inputValue);
		}
		
		function advance_search_barcode()
		{
			$barcode = $this -> input -> post('barcode');
			$this->db->select('product_id');
			$this->db->from('product_info');
			$this->db->where('barcode',$barcode);
			$quer=$this->db->get();
			if($quer->num_rows >0){ 
				foreach($quer -> result() as $field):
					$inputValue = $field -> product_id;
				endforeach;
				}
			if($inputValue >=  10000){
				$query = $this -> sale_model -> stockProductDetails( $inputValue );
				foreach($query -> result() as $field):
					$productId = $field -> product_id;
				endforeach;
				//redirect('sale_controller/my_sale/add/'.$productId.'/'.$this -> input -> post('product_id'));
			}
			else redirect('site_controller/by_name_result/'.$inputValue);
		}
		
		function search_barcode_barcode()
		{
			$barcode = $this -> input -> post('barcode');
			$this->db->select('product_id');
			$this->db->from('product_info');
			$this->db->where('barcode',$barcode);
			$quer=$this->db->get();
			if($quer->num_rows >0){ 
				foreach($quer -> result() as $field):
					$inputValue = $field -> product_id;
				endforeach;
				}
			if($inputValue >=  10000){
				$query = $this -> sale_model -> stockProductDetails( $inputValue );
				foreach($query -> result() as $field):
					$productId = $field -> product_id;
				endforeach;
				//redirect('sale_controller/my_sale/add/'.$productId.'/'.$this -> input -> post('product_id'));
			}
			else redirect('site_controller/searchBarcode/'.$inputValue);
		}
		
		function all_stock_for_damage_entry()
		{
			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$this -> load -> view('all_stock_view_for_damage_entry',$data);	
		}
		
		function create_damage()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();	
			$data['status'] = '';
			
			
			$damage_id = $this -> product_model -> create_damage();

			if($damage_id!='')
			{
				$data['status'] = 'success';
				redirect('product_controller/all_stock_for_damage_entry/success');
			}
			else
			{
				$data['status'] = 'failed';
				redirect('product_controller/all_stock_for_damage_entry/failed');
			}	
		}
		function all_damage_stock()
		{

			$data['sale_stock'] = $this -> sale_model -> by_product_code_result();


			/* end of Sale running Status*/
			$this -> load -> library('pagination');
		    $this -> load -> library('table');
		    $this -> load -> library('javascript');
			//$this -> table -> set_heading('Serial','Stock ID','Purchase Date');
				
			$config['base_url'] = base_url().'index.php/product_controller/all_damage_stock/';
			$this -> load -> model('site_model');
			$config['total_rows'] = $this -> site_model -> all_damage_stock_no_of_rows();
	        $config['per_page'] = 15;
	        $config['num_links'] = 5;
			$config['uri_segment'] = 3;
			$config['full_tag_open'] = '<div id="pagination">';
			$config['full_tag_close'] = '</div>';
			$this -> pagination -> initialize($config);
			
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();
			$this -> load -> model('site_model');
			$data['records'] = $this -> site_model -> all_damage_stock( $config['per_page'] );
			$data['alarming_level'] = FALSE;
			$query = $this -> sale_model -> products_info(FALSE, 0, $this -> tank_auth -> get_shop_id());
			$temp[''] = 'Select A Product';
			foreach($query -> result() as $field):
				 $temp[base_url().'product_controller/all_damage_stock/'.$field->product_id] = $field -> product_name;
			endforeach;
			$data['product_info'] = $temp;
			
			$data['main_content'] =  'all_damage_stock_view';
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);	
		}
		
		function check_product() {

		  $product_name =strtolower(preg_replace('/\+/', '', $this->input->post('customProductName')));
		//preg_replace('/\s\s+/', ' ', $str);
		//$shop_name = strtolower($this->input->post('shop_name'));

		  $query=$this -> db -> select('*')
							-> from('product_info')
							//-> where('LOWER('product_name')',$product_name))
							->like('LOWER(product_name)',$product_name)
							->get();
		  //$user_count = $data[0];
		  
		  if($query -> num_rows() >0) {
			  echo 'Product Name Not Available';
		  }
		  else{
			  echo 'Product Name Available';
		  }
		}
		
		 /* Starting 	: new purchase entry (Added by Arun) */
    
    public function newPurchaseListing()
    {
    	date_default_timezone_set("Asia/Dhaka");
		$bd_date 						= date('Y-m-d');
		$data['user_type'] 				= $this -> tank_auth -> get_usertype();
		$data['user_name'] 				= $this -> tank_auth -> get_username();
		$data['bd_date'] 				= date ('Y-m-d');
		$data['total_amount'] 			= '';
		$data['previous_date'] 			= date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 30, date("y")));
		$data['purchase_receipt_info'] 	= $this ->product_model-> fatch_all_purchase_receipt_id();
		$data['company_name'] 			= $this -> product_model -> company_name();
		$data['catagory_name'] 			= $this -> product_model -> catagory_name();
		$data['product_specification'] 	= $this -> product_model -> product_specification();
		$data['unit_name'] 				= $this -> product_model -> unit_name();
		$data['last_id'] 				= $this->product_model->getLastInserted();
		$data['distributor_info'] 		= $this -> product_model -> distributor_info();

    	$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
    }

    /* Ending 		: new purchase entry (Added by Arun) */
    
    /* Starting: newCreatePurchaseReceipt */
    public function newCreatePurchaseReceipt()
    {
    	$data['user_type'] 	= $this->tank_auth->get_usertype();
		$data['user_name'] 	= $this -> tank_auth -> get_username();		
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'purchase_receipt_entry'))
		{	
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');

			$data['user_name'] 	= $this->tank_auth->get_username();

			$distributor_id 	= $this -> input -> post('distributor_id');
			$purchase_amount   	= (float)$this -> input -> post('purchase_amount');
			$transport_cost   	= (float)$this -> input -> post('transport_cost'); 		// 12-0613
			$discount  			= (float)$this -> input -> post('discount'); 				// 12-0613
			$grand_total 		= (float)$this -> input -> post('final_amount');
			$doc 				= date('Y-m-d', strtotime($this->input->post('date')));
			$creator 			= $this->tank_auth->get_user_id();	
				
			if($data['receipt_id'] = $this->account_model->newCreatePurchaseReceipt($distributor_id, $purchase_amount, $transport_cost, $discount, $grand_total, $doc, $creator ))
			{
				$data['purchase_receipt_info'] 	= $this ->product_model-> fatch_all_purchase_receipt_id();
				$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
					
			}
			// $this -> load -> view('include/template', $data);
		}
		else echo 'noaccess';
    }
    /* Ending: newCreatePurchaseReceipt */

    /* Starting: searchProduct() */
    
    public function searchProduct(){
    	$requested_item 	= $this->input->post('term');
    	$flag 				= (int)$this->input->post('flag');
    	$field_name 		= "";
    	
    	if($flag == 1)$field_name 		= "product_name";
    	else if($flag == 2)$field_name 	= "barcode";
		
    	$data = $this->product_model->search_product($requested_item, $field_name);

    	$info = array();

    	if($data != FALSE){
    		foreach($data->result() as $tmp){
    			$info[] = array(
    				'id' 						=> $tmp->product_id,
    				'name' 						=> $tmp->product_name,
    				'catagory_name' 			=> $tmp->catagory_name,
    				'company_name'				=> $tmp->company_name,
    				'group_name'				=> $tmp->group_name,
    				'bulk_unit_buy_price'		=> $tmp->bulk_unit_buy_price,
    				'unit_buy_price'			=> $tmp->unit_buy_price,
    				'bulk_unit_sale_price'		=> $tmp->bulk_unit_sale_price,
    				'general_unit_sale_price'	=> $tmp->general_unit_sale_price
					
    				);
    		}
    	}
    	else{
    		$info[] = array(
    				'id' 				=> '',
    				'name' 				=> 'Nothing Found...',
    				'catagory_name' 	=> '',
    				'company_name'		=> '',
    				'group_name'		=> '',
					'bulk_unit_buy_price'		=> '',
					'unit_buy_price'			=> '',
    				'bulk_unit_sale_price'		=> '',
    				'general_unit_sale_price'		=> ''
    				);
    	}
    	echo json_encode($info);
    } 
	public function searchProduct_2(){
    	$requested_item 	= $this->input->post('term');
    	$flag 				= (int)$this->input->post('flag');
    	$field_name 		= "";
    	
    	if($flag == 1)$field_name 		= "product_name";
    	else if($flag == 2)$field_name 	= "barcode";
		
    	$data = $this->product_model->search_product($requested_item, $field_name);

    	$info = array();

    	if($data != FALSE){
    		foreach($data->result() as $tmp)
			{
				
				$unit_buy_price = $this->product_model->get_latest_unit_buy_price($tmp->product_id);
				
				
    			$info[] = array(
    				'id' 						=> $tmp->product_id,
    				'name' 						=> $tmp->product_name,
    				'catagory_name' 			=> $tmp->catagory_name,
    				'company_name'				=> $tmp->company_name,
    				'product_size'				=> $tmp->product_size,
    				'product_model'				=> $tmp->product_model,
    				'group_name'				=> $tmp->group_name,
    				'bulk_unit_buy_price'		=> $tmp->bulk_unit_buy_price,
    				'unit_buy_price'			=> $unit_buy_price,
    				'bulk_unit_sale_price'		=> $tmp->bulk_unit_sale_price,
    				'general_unit_sale_price'	=> $tmp->general_unit_sale_price
					
    				);
    		}
    	}
    	else{
    		$info[] = array(
    				'id' 				=> '',
    				'name' 				=> 'Nothing Found...',
    				'catagory_name' 	=> '',
    				'company_name'		=> '',
    				'group_name'		=> '',
    				'product_size'		=> '',
    				'product_model'		=> '',
					'bulk_unit_buy_price'		=> '',
					'unit_buy_price'			=> '',
    				'bulk_unit_sale_price'		=> '',
    				'general_unit_sale_price'		=> ''
    				);
    	}
    	echo json_encode($info);
    }

    /* Ending: searchProduct() */
	
	/* Starting: addProductToList() [old create_purchase()]*/
	public function addProductToList()
	{	
		$pur_recpt_id					= $this->input->post('purchase_receipt_id');
		$pro_name 						= $this->input->post('pro_name');
		$pro_id							= $this->input->post('pro_id');
		$pur_qnty						= $this->input->post('qnty');
		$ex_date						= $this->input->post('ex_date');
		$ttl_buy_pric					= $this->input->post('total_buy_price');
		$gnrl_sal_pric					= $this->input->post('general_sale_price');		// $unit_sale_price
		$unit_buy_pric					= $this->input->post('unit_buy_price');
		$exclu_sal_pric					= $this->input->post('exclusive_sale_price');
		
		$grand_total 					= $this->input->post('grand_total');
		$total_purchase_amount 			= $this->input->post('total_purchase_amount');

		$data['user_type'] 				= 	$this->tank_auth->get_usertype();
		

		$data['purchase_receipt_id']	= $pur_recpt_id;
		$data['product_name']  			= $pro_name;		
		$data['product_id']  			= $pro_id;		
		$data['quantity']  				= $pur_qnty;		
		$data['expaire_date']  			= $ex_date;		
		$data['total_buy_price']  		= $ttl_buy_pric;	
		$data['general_sale_price']  	= $gnrl_sal_pric;	
		$data['unit_buy_price']  		= $unit_buy_pric;
		$data['exclusive_sale_price'] 	= $exclu_sal_pric; 


		if($this->input->post('exclusive_sale_price') == '')$exclu_sal_pric = 0;
		
		//if($this->access_control_model->my_access($data['user_type'], 'product_controller', 'purchase_entry'))
		//{	
			if(is_numeric($pur_qnty) && is_numeric($ttl_buy_pric) && is_numeric($gnrl_sal_pric) && is_numeric($unit_buy_pric) && is_numeric($exclu_sal_pric))
			{	

				$pur_recpt_id 		= (int)$pur_recpt_id;
				$pro_name 			= (string)$pro_name;
				$pro_id 			= (int)$pro_id;
				$pur_qnty 			= abs((float)$pur_qnty);
				$ex_date 			= $ex_date;
				$ttl_buy_pric 		= abs((float)$ttl_buy_pric);
				$gnrl_sal_pric 		= abs((float)$gnrl_sal_pric);
				$unit_buy_pric 		= abs((float)$unit_buy_pric);
				$exclu_sal_pric 	= abs((float)$exclu_sal_pric);

				// $data['purchase_receipt_id']	= $pur_recpt_id;
				// $data['product_name']  			= $pro_name;		
				// $data['product_id']  			= $pro_id;		
				// $data['quantity']  				= $pur_qnty;		
				// $data['expaire_date']  			= $ex_date;		
				// $data['total_buy_price']  		= $ttl_buy_pric;	
				// $data['general_sale_price']  	= $gnrl_sal_pric;	
				// $data['unit_buy_price']  		= $unit_buy_pric;
				// $data['exclusive_sale_price'] 	= $exclu_sal_pric; 
				
				if($query = $this->product_model->newCreatePurchase($pur_recpt_id, $pro_id, $pur_qnty, $unit_buy_pric, $grand_total, $total_purchase_amount))
				{	
					if($query == true)
					{	$lst_purch_id = $this->db->insert_id();
						if($this->product_model->newCreateStock($pur_qnty, $gnrl_sal_pric, $pro_id, $pur_recpt_id, $unit_buy_pric, $lst_purch_id, $exclu_sal_pric))
						{
							$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
						}
					}
					else
					{	$purchase_id = $query;
						
						if($this->product_model->newCreateStock($pur_qnty, $gnrl_sal_pric, $pro_id, $pur_recpt_id, $unit_buy_pric, $purchase_id, $exclu_sal_pric))
						{
							$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
						}
					}
				}
			}	
		//}
	 	//else redirect(''); noaccess

	}
	/* Ending: addProductToList()*/	
	

		function check_shop() {
		
		$shop_name =strtolower(preg_replace('/\+/', '', $this->input->post('shop_name')));
		
		//preg_replace('/\s\s+/', ' ', $str);
		//$shop_name = strtolower($this->input->post('shop_name'));

		  $query=$this -> db -> select('*')
							-> from('shop_setup')
							//-> where('LOWER('product_name')',$product_name))
							->like('LOWER(shop_name)',$shop_name)
							->get();
		  //$user_count = $data[0];
		  
		  if($query -> num_rows() >0) {
			  echo 'Shop Name Not Available';
		  }
		  else{
			  echo 'Shop Name Available';
		  }
		
		}
		function check_catagory() {
		
		
		$catagory_name =strtolower(preg_replace('/\+/', '', $this->input->post('catagory_name')));
		//preg_replace('/\s\s+/', ' ', $str);
		//$shop_name = strtolower($this->input->post('shop_name'));

		  $query=$this -> db -> select('*')
							-> from('catagory_info')
							//-> where('LOWER('product_name')',$product_name))
							->like('LOWER(catagory_name)',$catagory_name)
							->get();
		  //$user_count = $data[0];
		  
		  if($query -> num_rows() >0) {
			  echo 'Catagory Name Not Available';
		  }
		  else{
			  echo 'Catagory Name Available';
		  }
		
		}
		function check_company() {
		
		
		$company_name =strtolower(preg_replace('/\+/', '', $this->input->post('company_name')));
		//preg_replace('/\s\s+/', ' ', $str);
		//$shop_name = strtolower($this->input->post('shop_name'));

		  $query=$this -> db -> select('*')
							-> from('company_info')
							//-> where('LOWER('product_name')',$product_name))
							->like('LOWER(company_name)',$company_name)
							->get();
		  //$user_count = $data[0];
		  
		  if($query -> num_rows() >0) {
			  echo 'Company Name Not Available';
		  }
		  else{
			  echo 'Company Name Available';
		  }
		
		}
		function check_distributor() {
		
		
		$distributor_name =strtolower(preg_replace('/\+/', '', $this->input->post('distributor_name')));
		//preg_replace('/\s\s+/', ' ', $str);
		//$shop_name = strtolower($this->input->post('shop_name'));

		  $query=$this -> db -> select('*')
							-> from('distributor_info')
							//-> where('LOWER('product_name')',$product_name))
							->like('LOWER(distributor_name)',$distributor_name)
							->get();
		  //$user_count = $data[0];
		  
		  if($query -> num_rows() >0) {
			  echo 'Distributor Name Not Available';
		  }
		  else{
			  echo 'Distributor Name Available';
		  }
		
		}
		function check_barcode_1() {
		
		
		$barcode =strtolower(preg_replace('/\+/', '', $this->input->post('barcode')));
		//preg_replace('/\s\s+/', ' ', $str);
		//$shop_name = strtolower($this->input->post('shop_name'));

		  $query=$this -> db -> select('*')
							-> from('product_info')
							//-> where('LOWER('product_name')',$product_name))
							->like('LOWER(barcode)',$barcode)
							->get();
		  //$user_count = $data[0];
		  
		  if($query -> num_rows() >0) {
			  echo 'Barcode Not Available';
		  }
		  else{
			  echo 'Barcode Available';
		  }
		
		}
		
		function check_product_1() {
		
		
		$product_name =strtolower(preg_replace('/\+/', '', $this->input->post('product_name')));
		//preg_replace('/\s\s+/', ' ', $str);
		//$shop_name = strtolower($this->input->post('shop_name'));

		  $query=$this -> db -> select('*')
							-> from('product_info')
							//-> where('LOWER('product_name')',$product_name))
							->like('LOWER(product_name)',$product_name)
							->get();
		  //$user_count = $data[0];
		  
		  if($query -> num_rows() >0) {
			  echo 'Product Name Not Available';
		  }
		  else{
			  echo 'Product Name Available';
		  }
		
		}
		
		function check_product_2() {
		
		
		$product_name =strtolower(preg_replace('/\+/', '', $this->input->post('product_name')));
		//preg_replace('/\s\s+/', ' ', $str);
		//$shop_name = strtolower($this->input->post('shop_name'));

		  $query=$this -> db -> select('*')
							-> from('product_info')
							//-> where('LOWER('product_name')',$product_name))
							->like('LOWER(product_name)',$product_name)
							->get();
		  //$user_count = $data[0];
		  
		  if($query -> num_rows() >0) {
			  echo 'Product Name Not Available';
		  }
		  else{
			  echo 'Product Name Available';
		  }
		
		}
		
		function check_customer_1() {
		
		
		$customer_name =strtolower(preg_replace('/\+/', '', $this->input->post('customer_name')));
		//preg_replace('/\s\s+/', ' ', $str);
		//$shop_name = strtolower($this->input->post('shop_name'));

		  $query=$this -> db -> select('*')
							-> from('customer_info')
							//-> where('LOWER('product_name')',$product_name))
							->like('LOWER(customer_name)',$customer_name)
							->get();
		  //$user_count = $data[0];
		  
		  if($query -> num_rows() >0) {
			  echo 'Customer Name Not Available';
		  }
		  else{
			  echo 'Customer Name Available';
		  }
		
		}
		
		function check_customer_2() {
		
		
		$customer_name =strtolower(preg_replace('/\+/', '', $this->input->post('customer_name')));
		//preg_replace('/\s\s+/', ' ', $str);
		//$shop_name = strtolower($this->input->post('shop_name'));

		  $query=$this -> db -> select('*')
							-> from('customer_info')
							//-> where('LOWER('product_name')',$product_name))
							->like('LOWER(customer_name)',$customer_name)
							->get();
		  //$user_count = $data[0];
		  
		  if($query -> num_rows() >0) {
			  echo 'Customer Name Not Available';
		  }
		  else{
			  echo 'Customer Name Available';
		
			}
		}
	
	
	
	/* Starting: updateExistsProduct() */
	public function updateExistsProduct()
	{
		$pur_recpt_id					= $this->input->post('purchase_receipt_id');
		$pro_name 						= $this->input->post('pro_name');
		$pro_id							= $this->input->post('pro_id');
		$pur_qnty						= $this->input->post('qnty');
		$ex_date						= $this->input->post('ex_date');
		$ttl_buy_pric					= $this->input->post('total_buy_price');
		$gnrl_sal_pric					= $this->input->post('general_sale_price');		// $unit_sale_price
		$unit_buy_pric					= $this->input->post('unit_buy_price_purchase');
		$exclu_sal_pric					= $this->input->post('exclusive_sale_price');
		$grand_total 					= $this->input->post('grand_total');
		$total_purchase_amount 			= $this->input->post('total_purchase_amount');
		
		$data['user_type'] 				= 	$this->tank_auth->get_usertype();

		if($this->input->post('exclusive_sale_price') == ''){
			$exclu_sal_pric = 0;
		}
		
		//if($this->access_control_model->my_access($data['user_type'], 'product_controller', 'purchase_entry'))
		//{	
			if(is_numeric($pur_qnty) && is_numeric($ttl_buy_pric) && is_numeric($gnrl_sal_pric) && is_numeric($unit_buy_pric) && is_numeric($exclu_sal_pric))
			{	
				$pur_recpt_id 		= (int)$pur_recpt_id;
				$pro_name 			= (string)$pro_name;
				$pro_id 			= (int)$pro_id;
				$pur_qnty 			= abs((float)$pur_qnty);
				$ex_date 			= $ex_date;
				$ttl_buy_pric 		= abs((float)$ttl_buy_pric);
				$gnrl_sal_pric 		= abs((float)$gnrl_sal_pric);
				$unit_buy_pric 		= abs((float)$unit_buy_pric);
				$exclu_sal_pric 	= abs((float)$exclu_sal_pric);

				if($query = $this->product_model->newCreatePurchase($pur_recpt_id, $pro_id, $pur_qnty, $unit_buy_pric, $grand_total, $total_purchase_amount))
				{	
					if($lst_purch_id = $this->db->insert_id())
					{	
						if($this->product_model->newCreateStock($pur_qnty, $gnrl_sal_pric, $pro_id, $pur_recpt_id, $unit_buy_pric, $lst_purch_id, $exclu_sal_pric))
						{
							$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
						}
					}
					else if($query != false){
						$purchase_id 	= $query;
						$this->product_model->newCreateStock($pur_qnty, $gnrl_sal_pric, $pro_id, $pur_recpt_id, $unit_buy_pric, $purchase_id, $exclu_sal_pric);
					}
				}
			}
		//}
	}	
	/* Ending 			: updateExistsProduct() */
	/* Starting 		: removeProductFromPurchase() */
	public function removeProductFromPurchase()
	{
		$purchase_receipt_id  	= $this->input->post('purchase_receipt_id');
		$product_id 			= $this->input->post('pro_id');
		
		echo 'OKLLL';
		
		if($purchase_receipt_id != '' && $product_id != '' && is_numeric($purchase_receipt_id) && is_numeric($product_id))
		{	
			$is_accessible 		= $this->access_control_model->my_access($this->tank_auth->get_usertype(), __CLASS__, __FUNCTION__);
			if($is_accessible)
			{
				$this->product_model->removeProductFromPurchase($purchase_receipt_id, $product_id);
				echo 'OKK';
			}
		}
	}
	/* Ending 		: removeProductFromPurchase() */
	/* Starting 	: editPruchaseProduct() */
	public function editPruchaseProduct()
	{
		$purchase_receipt_id  	= $this->input->post('purchase_receipt_id');
		$product_id 			= $this->input->post('pro_id');
		$qnty 					= $this->input->post('qty');
		$unit_buy_price 		= $this->input->post('u_b_p');
		$shop_id 				= $this->tank_auth->get_shop_id();

		if($purchase_receipt_id != '' && $product_id != '' && $qnty != '' && $unit_buy_price != '' && 
			is_numeric($unit_buy_price) && is_numeric($qnty) && is_numeric($purchase_receipt_id) && is_numeric($product_id))
		{
			/* $is_accessible 		= $this->access_control_model->my_access($this->tank_auth->get_usertype(), __CLASS__, __FUNCTION__);
			if($is_accessible)
			{ */
				echo $this->product_model->editPruchaseProduct($purchase_receipt_id, $product_id, $qnty, $unit_buy_price, $shop_id);
			//}
		}

	}
	/* Ending 		: editPruchaseProduct() */

	public function search_product_by_barcode()
	{
		$barcode =  $this->input->post('barcode');

		if($barcode != '')
		{
			$tmp_data = $this->product_model->search_product_by_barcode($barcode);
			
			if($tmp_data != false)
			{
				$unit_buy_price = $this->product_model->get_latest_unit_buy_price($tmp_data->product_id);
				$tmp_arr['product_id'] 				= $tmp_data->product_id;
				$tmp_arr['product_name'] 			= $tmp_data->product_name;	
				$tmp_arr['unit_buy_price'] 			= $unit_buy_price;	
				$tmp_arr['bulk_unit_buy_price'] 	= $tmp_data->bulk_unit_buy_price;	
				$tmp_arr['bulk_unit_sale_price'] 	= $tmp_data->bulk_unit_sale_price;	
				$tmp_arr['general_unit_sale_price'] = $tmp_data->general_unit_sale_price;	
				
				echo json_encode($tmp_arr);
			}

		}
	}

}
