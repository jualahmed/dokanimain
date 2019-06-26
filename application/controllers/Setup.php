<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
class Setup extends CI_controller{
	
	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id=$this->tank_auth->get_shop_id();
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
	
	/****************************
	 * 2018-01-06
	 * Prasanta Bhattacharjee
	******************************/
	/* Company Setup Form */
		function company_setup()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			$data['status'] = '';
			$data['user_name'] = $this -> tank_auth -> get_username();
			$this -> load -> view('Setup/company_registration_form_view', $data);
		}
		
		/* Create a New Company */
        function create_company()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$this -> form_validation -> set_rules('company_name', 'Company Name','required|xss_clean');
			$companyname = $this -> input -> post('company_name');
			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
				redirect('Setup/company_setup/error');
			}
			else
			{
				$exists = $this -> setup_model -> redundancy_check('company_info', 'company_name', $companyname);
				
				if($exists == true)
				{
					$data['status'] = 'exist';
					redirect('Setup/company_setup/exist');
				}
				else
				{
				
					$company_id = $this -> setup_model -> create_company();
					
					if($company_id!='')
					{
						$data['status'] = 'success';
						redirect('Setup/company_setup/success');
					}
					else
					{
						$data['status'] = 'failed';
						redirect('Setup/company_setup/failed');
					}
				}
			}
		}
		/* Distributor Entry Form */
		function distributor_setup()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$this -> load -> view('Setup/distributor_registration_form_view', $data);
		}
		
		/* Create a New Distributor */
        function create_distributor()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
				
			$this -> form_validation -> set_rules('distributor_name', 'Distributor Name','required|xss_clean');
			$distributorname = $this -> input -> post('distributor_name');
			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
				redirect('Setup/distributor_setup/error');
			}
			else
			{
				$exists = $this -> setup_model -> redundancy_check('distributor_info', 'distributor_name', $distributorname);
				
				if($exists == true)
				{
					$data['status'] = 'exist';
					redirect('Setup/distributor_setup/exist');
				}
				else
				{
				
					$company_id = $this -> setup_model -> create_distributor();
					
					if($company_id!='')
					{
						$data['status'] = 'success';
						redirect('Setup/distributor_setup/success');
					}
					else
					{
						$data['status'] = 'failed';
						redirect('Setup/distributor_setup/failed');
					}
				}
			}
		}

	/* product entry form */
	function product_setup()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date = date('Y-m-d');
		$data['bd_date'] = $bd_date;
		$data['last_id'] = $this->product_model->getLastInserted();
		$data['user_name'] = $this->tank_auth->get_username();
		$data['status'] = '';
		$data['company_name'] = $this -> product_model -> company_name();
		$data['catagory_name'] = $this -> product_model -> catagory_name();
		$data['product_specification'] = $this -> product_model -> product_specification();
		$data['unit_name'] = $this -> product_model -> unit_name();
		$this -> load -> view('Setup/product_entry_form_view', $data);
	}
	
	/* create product */
	function create_product()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['status'] = '';

		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('product_specification', 'Product Specification', 'required');
		$this -> form_validation -> set_rules('catagory_name', 'Catagory Name','required');
		$this -> form_validation -> set_rules('company_name', 'Company Name','required');
		$this -> form_validation -> set_rules('customProductName', 'Product Model','required');
		$this -> form_validation -> set_rules('product_description', 'Product Description');
		$this -> form_validation -> set_rules('alarming_stock', 'Alarming Stock', 'numeric');
		
		$data['user_name'] = $this->tank_auth->get_username();
		$data['product_specification'] = $this -> setup_model -> product_specification();
		$data['unit_name'] = $this -> setup_model -> unit_name();
		$data['company_name'] = $this -> setup_model -> company_name_1();
		$data['catagory_name'] = $this -> setup_model -> catagory_name();
		$data['last_id'] = $this->setup_model->getLastInserted();												
		
		if($this -> form_validation -> run() ==  FALSE)
		{
			$data['status'] = 'error';
			redirect('Setup/product_setup/error');
		}
		else
		{
			$exists = $this -> setup_model -> redundancy_check_for_new_product();
			if($exists == true)
			{
				$data['status'] = 'exist';
				redirect('Setup/product_setup/exist');
			}
			else
			{
				$product_id = $this -> setup_model -> create_product();
				
				if($product_id!='')
				{
					$data['status'] = 'success';
					redirect('Setup/product_setup/success');
				}
				else
				{
					$data['status'] = 'failed';
					redirect('Setup/product_setup/failed');
				}
			}
		}
	}
	
	function create_new_product()
	{
		$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
		    $creator = $this->tank_auth->get_user_id();
			
			$new_product_insert_data = array(			
				'product_name' => mysql_real_escape_string(strtoupper($this -> input ->post('customProductName'))),
				'catagory_name' => rawurldecode($this -> input ->post('catagory_name')),
				'company_name' => rawurldecode($this -> input ->post('company_name')),
				'product_type' => 'N/A',
				'product_size' => strtoupper($this -> input ->post('product_size')),
				'product_model' => strtoupper($this -> input ->post('product_model')),
				'product_specification' => 'BULK',
				'unit_name' => $this -> input -> post('unit_name'),
				'barcode' => strtoupper($this -> input ->post('barcode')),
				'product_status' => 'active',		
				'product_creator' => $creator,
				'product_doc' => $bd_date,
				'product_dom' => $bd_date
			);
			$this -> db -> insert('product_info', $new_product_insert_data);
			
			$new_product_id = $this->db->insert_id() ;
			
			$shop_id = $this -> tank_auth -> get_shop_id();
			
			$new_sale_price_info_data = array(
				'product_id' => $new_product_id,
				'bulk_alarming_stock' => $this -> input ->post('alarming_stock'),
				'stock_amount' => 0,
				'shop_id' => $shop_id,
				'bulk_unit_buy_price' => 0,
				'bulk_unit_sale_price' => 0,
				'general_unit_sale_price' => 0,
				'last_buy_price' => 0,
				'stock_doc' => $bd_date,
				'stock_dom' => $bd_date
			);
			
			$this -> db -> insert('bulk_stock_info', $new_sale_price_info_data);
		
			$this->db->select('product_info.product_name,bulk_stock_info.*');
			$this->db->from('product_info,bulk_stock_info');
			$this->db->where('product_info.product_id=bulk_stock_info.product_id');
			$this->db->where('bulk_stock_info.product_id',$new_product_id);
			$query = $this->db->get();
			
			echo json_encode($query->row());
		
	}
	function create_new_product_serial()
	{
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date=date('Y-m-d');
		$creator = $this->tank_auth->get_user_id();
		
		$product_type2 =  rawurldecode($this->input->post('product_type'));
		$product_id = $this->input->post('product_id');
		$purchase_receipt_id = $this->input->post('purchase_receipt_id');
		$unit_buy_price = $this->input->post('unit_buy_price');
		
		$product_type_1 = explode("product_type=",$product_type2);
		
		$k = 0;
		
		foreach($product_type_1 AS $product_type_12){
			if($k != 0){
				$product_type_2[$k] = str_replace('&','',$product_type_12);
			}
			$k++;
		}
		
		$this->db->select('receipt_date');
		$this->db->from('purchase_receipt_info');
		$this->db->where('purchase_receipt_info.receipt_id',$purchase_receipt_id);
		$query = $this->db->get();
		$field= $query->row();
		$receipt_date =$field->receipt_date;
		
		$this->db->select('product_warranty');
		$this->db->from('product_info');
		$this->db->where('product_info.product_id',$product_id);
		$query2 = $this->db->get();
		$field2= $query2->row();
		$warranty_period =$field2->product_warranty;

		$i=1;
		
		foreach($product_type_2 as $product) 
		{
			$data_product= array(
				'product_id' => $product_id,
				'sl_no' => $product,
				'purchase_receipt_id' => $purchase_receipt_id,
				'status' => 1,
				'purchase_date' => $receipt_date,
				'purchase_price' => $unit_buy_price,
				'warranty_period' => $warranty_period,
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$this->db->insert('warranty_product_list', $data_product);
			
			/* $data_product2= array(
				'product_id' => $product_id,
				'sl_no' => $product,
				'purchase_receipt_id' => $purchase_receipt_id,
				'status' => 1,
				'purchase_date' => $receipt_date,
				'purchase_price' => $unit_buy_price,
				'warranty_period' => $warranty_period,
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$this->db->insert('warranty_product_sale_details', $data_product2); */
			$i++;
		}
		
		
		echo json_encode('Success');
	}
	function update_new_product_serial()
	{
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date=date('Y-m-d');
		$creator = $this->tank_auth->get_user_id();
		
		$product_type2 =  rawurldecode($this->input->post('product_type'));
		$product_id = $this->input->post('product_id');
		$new_temp_sale_id = $this->input->post('new_temp_sale_id');
		//$unit_buy_price = $this->input->post('unit_buy_price');
		
		$product_type_1 = explode("product_type=",$product_type2);
		
		$k = 0;
		
		foreach($product_type_1 AS $product_type_12){
			if($k != 0){
				$product_type_2[$k] = str_replace('&','',$product_type_12);
			}
			$k++;
		}
		$i=1;
		
		foreach($product_type_2 as $product) 
		{
			$data_product= array(
				'invoice_id' => $new_temp_sale_id,
				'status' => 2,
				'dom' => $bd_date
			);
			$this->db->where('ip_id', $product);
			$this->db->where('product_id', $product_id);
			$this->db->update('warranty_product_list', $data_product);
			
			/* $data_product2= array(
				'invoice_id' => $new_temp_sale_id,
				'status' => 2,
				'dom' => $bd_date
			);
			$this->db->where('ip_id', $product);
			$this->db->where('product_id', $product_id);
			$this->db->update('warranty_product_sale_details', $data_product2); */
			$i++;
		}
		
		
		echo json_encode('Success');
	}
	/* card entry form */
	function card_setup()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		$data['status'] = '';
		$data['bank'] = $this -> setup_model -> fatch_all_bank();
		$this -> load -> view('Setup/card_entry_form_view', $data);
	}
	
	/* create card */
	function create_card()
	{
		$card_id = $this -> setup_model -> create_card();
		if($card_id!='')
		{
			$data['status'] = 'success';
			redirect('Setup/card_setup/success');
		}
		else
		{
			$data['status'] = 'failed';
			redirect('Setup/card_setup/failed');
		}
	}

		function customer_setup()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['customer_info'] = $this -> setup_model -> customer_info();
			$data['customer_mode'] = $this -> setup_model -> customer_mode();
			$this -> load -> view('Setup/customer_registration_form_view', $data);
		}
		/* Create a New customer */
		function create_customer()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			$this -> form_validation -> set_rules('customer_name', 'Customer Name','required');
			$this -> form_validation -> set_rules('customer_contact_no', 'Customer Contact No','numeric|required');
			$this -> form_validation -> set_rules('customer_type', 'Customer Type','required');
			$this -> form_validation -> set_rules('customer_mode', 'Customer Mode','required');
			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$customername = $this -> input -> post('customer_name');
			$customer_contact = $this -> input -> post('customer_contact_no');
			
			$data['customer_info'] = $this -> setup_model -> customer_info();
			$data['customer_mode'] = $this -> setup_model -> customer_mode();
			
			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
				redirect('Setup/customer_setup/error');
			}
			else
			{
				$exists = $this -> setup_model -> redundancy_check('customer_info', 'customer_contact_no', $customer_contact);
				if($exists == true)
				{
					$data['status'] = 'exist';
					redirect('Setup/customer_setup/exist');
				}
				else
				{
					$customer_id = $this -> setup_model -> create_customer();
					
					if($customer_id!='')
					{
						$data['status'] = 'success';
						redirect('Setup/customer_setup/success');
					}
					else
					{
						$data['status'] = 'failed';
						redirect('Setup/customer_setup/failed');
					}
				}
			}
		}
	
		function damage_setup()
		{
			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$this -> load -> view('Setup/damage_entry',$data);	
		}
		
		function create_damage()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();	
			$data['status'] = '';
			$damage_id = $this -> setup_model -> create_damage();

			if($damage_id!='')
			{
				$data['status'] = 'success';
				redirect('Setup/damage_setup/success');
			}
			else
			{
				$data['status'] = 'failed';
				redirect('Setup/damage_setup/failed');
			}	
		}
		
		function employee_setup()
		{
			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['customer_info'] = $this -> setup_model -> customer_info();
			$data['customer_mode'] = $this -> setup_model -> customer_mode();
			$this -> load -> view('Setup/employee_setup',$data);	
		}
		
		function create_employee()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();	
			$data['status'] = '';
			$employee_id = $this -> setup_model -> create_employee();

			if($employee_id!='')
			{
				$data['status'] = 'success';
				redirect('Setup/employee_setup/success');
			}
			else
			{
				$data['status'] = 'failed';
				redirect('Setup/employee_setup/failed');
			}	
		}
}
