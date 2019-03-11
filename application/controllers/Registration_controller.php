<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

	class Registration_controller extends CI_controller{
			
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
				redirect('auth/login','refresh');
			}
		}
		
		/***************************
		 * Employee Transfer
		 * 24-11-2013
		 * Arafat Mamun
		 ***************************/
		function transfer_employee()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			if($data['user_type'] == 'superadmin' || $data['user_type'] == 'admin' || $data['user_type'] == 'manager' )
			{
				$data['sale_status'] = '';
				$data['status'] = '';
				
				$data['alarming_level'] = FALSE;
				$data['main_content'] = 'user_modification_form_view';
				
				$this -> form_validation -> set_rules('selected_user', ' ', 'xss_clean|required|numeric');
				$this -> form_validation -> set_rules('new_assigned_shop', ' ','required|xss_clean|numeric');
				if($this -> form_validation -> run())
				{
					$this -> registration_model -> transfer_employee(
							$this->form_validation->set_value('selected_user'),
							$this->form_validation->set_value('new_assigned_shop')
						);
					$data['status'] = 'successful';
				}
				
				$data['user_info'] = $this -> registration_model -> all_general_user();
				$data['specific_user'] = $this -> login_model -> specific_user( $this -> uri -> segment(3) );
				
				$data['change_mood'] = $this -> registration_model -> specific_user();
				$query = $this -> report_model -> shop_information(FALSE, 0);
				if($query -> num_rows < 1) $temp[ '' ] = 'No Shop is listed Yet!';
				foreach($query -> result() as $field):
					$temp[ $field -> shop_id ] = $field -> shop_name.' ( '.$field -> shop_address .' )';
				endforeach;
				$data['all_shop'] = $temp;
				
				$data['main_content'] = 'transfer_employee_view';
				$data['tricker_content'] = 'tricker_registration_view';
				$this -> load -> view('include/template', $data);
			}
			else redirect('registration_controller/registration/noaccess');
		}
		/***************************
		 * Shop Setup
		 * 22-11-2013
		 * Arafat Mamun
		 ***************************/
		/* function shop_setup()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'shop_setup'))
			{
				$data['sale_status'] = '';
				$data['status'] = '';
				$data['user_name'] = $this->tank_auth->get_username();
				$data['alarming_level'] = FALSE;
				
				$this -> form_validation -> set_rules('shopName', ' ', 'xss_clean|required');
				$this -> form_validation -> set_rules('shopType', ' ','required|xss_clean');
				$this -> form_validation -> set_rules('shopAddress', ' ','required|xss_clean');
				$this -> form_validation -> set_rules('shopContact', ' ','requiredxss_clean');
				if($this -> form_validation -> run())
				{
					$this -> registration_model -> shop_setup(
							$this->form_validation->set_value('shopName'),
							$this->form_validation->set_value('shopType'),
							$this->form_validation->set_value('shopAddress'),
							$this->form_validation->set_value('shopContact')
						);
					$data['status'] = 'successful';
				}
				
				$data['main_content'] = 'shop_setup_view';
				$data['tricker_content'] = 'tricker_registration_view';
				$this -> load -> view('include/template', $data);
			}
			else redirect('product_controller/product/noaccess');
		} */
		
		function shop_setup()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'shop_setup'))
			{
				$data['sale_status'] = '';
				$data['status'] = '';
				$data['user_name'] = $this->tank_auth->get_username();
				$data['alarming_level'] = FALSE;
				
				$this -> load -> library('form_validation');
				$this -> form_validation -> set_rules('shopName', ' ', 'xss_clean|required');
				$this -> form_validation -> set_rules('shopType', ' ','required|xss_clean');
				$this -> form_validation -> set_rules('shopAddress', ' ','required|xss_clean');
				$this -> form_validation -> set_rules('shopContact', ' ','required|xss_clean');
				if($this -> form_validation -> run())
				{
						$this -> registration_model -> shop_setup(
							$this->form_validation->set_value('shopName'),
							$this->form_validation->set_value('shopType'),
							$this->form_validation->set_value('shopAddress'),
							$this->form_validation->set_value('shopContact')
						);
					$data['status'] = '';
					$data['status'] = 'successful';
					$this->session->set_flashdata('msg1', '<div class="alert alert-success alert-dismissible" style="background:#00a65a;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Success</h4></div>');
					
				}
				else
				{
					$data['status'] = '';
					$data['status'] = 'failed';
					$this->session->set_flashdata('msg2', '<div class="alert alert-danger alert-dismissible" style="background:#dd4b39;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Failed</h4></div>');
				}
				
				//$data['main_content'] = 'shop_setup_view';
				//$data['tricker_content'] = 'tricker_registration_view';
				$this -> load -> view('shop_setup_view', $data);
				//redirect('registration_controller/shop_setup',$data);
			}
		}
		
		/* User Registration Home */
		function registration()
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['access_status'] = $this -> uri -> segment(3);
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'registration_view';
			$data['tricker_content'] = 'tricker_registration_view';
			$this -> load -> view('include/template', $data);
		}
		
		
		function change_password()
		{
			//* for sale Running Status */
			$data['sale_status'] = '';
			/*$data['number_of_products'] = 0;
			$data ['total_buy_price'] = 0;
			$data ['total_sale_price'] = 0;
			$data ['total_profit'] = 0;
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
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $data ['total_sale_price']);
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
					$buy_amount = $buy_amount + $field -> unit_buy_price;
				endforeach;
				$data ['total_buy_price'] += ( $buy_amount * $quantity);
				$sale_amount = 0;
				foreach($data['sale_bulk'] -> result() as $field):
					$sale_amount = $sale_amount + $field -> unit_sale_price;				
				endforeach;
				$data ['total_sale_price'] += ( $sale_amount * $quantity );
				$data ['total_profit'] += (( $sale_amount * $quantity ) - ( $buy_amount * $quantity));
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $data ['total_sale_price']);
			}*/
			/* end of Sale running Status*/
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['main_content'] = 'auth/change_password_form';
			$data['tricker_content'] = 'tricker_registration_view';
			$this -> load -> view('include/template', $data);
		}
		/* Company Register Form */
		function company_registration()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'company_registration'))
			{
				$data['sale_status'] = '';
				$data['status'] = '';
				$data['status'] = '';
				$data['user_name'] = $this -> tank_auth -> get_username();
				$data['alarming_level'] = FALSE;
				$this -> load -> view('company_registration_form_view', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		
		/* Create a New Company */
        function create_company()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'company_registration'))
			{
				$data['sale_status'] = '';
				$data['status'] = '';
				$data['user_name'] = $this->tank_auth->get_username();
				
				$this -> form_validation -> set_rules('company_name', 'Company Name','required|xss_clean');
				$data['alarming_level'] = FALSE;
				$companyname = $this -> input -> post('company_name');
				if($this -> form_validation -> run() ==  FALSE)
				{
					$data['status'] = 'error';
				}
				else
				{
					
					$exists = $this -> product_model -> redundancy_check('company_info', 'company_name', $companyname);
					if($exists)
					{
						$data['status'] = 'exists';
						$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissible" style="background:#f39c12;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Already Exist</h4>
				</div>');
					}
					else if($this -> registration_model -> create_company())
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
				$this -> load -> view('company_registration_form_view', $data);
			}
			else redirect('product_controller/product/noaccess');
		}

		/* Distributor Entry Form */
		function distributor_registration()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'distributor_registration'))
			{
				$data['sale_status'] = '';
				$data['status'] = '';
				$data['user_name'] = $this->tank_auth->get_username();
				$data['alarming_level'] = FALSE;
				$this -> load -> view('distributor_registration_form_view', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		
		/* Create a New Distributor */
        function create_distributor()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'distributor_registration'))
			{
				$data['sale_status'] = '';
				$data['user_type'] = $this->tank_auth->get_usertype();
				$data['user_name'] = $this->tank_auth->get_username();
				
				$this -> form_validation -> set_rules('distributor_name', 'Distributor Name','required|xss_clean');
				$data['alarming_level'] = FALSE;
				$distributorname = $this -> input -> post('distributor_name');
				if($this -> form_validation -> run() ==  FALSE)
				{
					$data['status'] = 'error';
				}
				else
				{
					
					$exists = $this -> product_model -> redundancy_check('distributor_info', 'distributor_name', $distributorname);
					if($exists)
					{
						$data['status'] = 'exists';
						$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissible" style="background:#f39c12;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Already Exist</h4>
				</div>');
					}
					else if($this -> registration_model -> create_distributor())
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
				$this -> load -> view('distributor_registration_form_view', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		
		/* Starting: newCreateDistributor (12-12-16)*/
		public function newCreateDistributor()
		{
			$timezone 				= "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date 				= date('Y-m-d');
			$data['bd_date'] 		= $bd_date;
			$data['sale_status'] 	= '';
			$data['status'] 		= "";
			$data['user_type'] 		= $this->tank_auth->get_usertype();
			$data['user_name'] 		= $this->tank_auth->get_username();
			$name 					= $this->input->post('name');
			$phn 					= $this->input->post('phn');
			$mail 					= $this->input->post('mail');
			$address 				= $this->input->post('address');
			$description 			= $this->input->post('des');

			$data['user_type'] = $this -> tank_auth -> get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'distributor_registration'))
			{
				$data['user_type'] 	= $this->tank_auth->get_usertype();
				$data['user_name'] 	= $this->tank_auth->get_username();
				$exists 			= $this->product_model->redundancy_check('distributor_info', 'distributor_name', $name);

				if($exists)
				{
					echo 1;
				}
				else
				{
					$this->registration_model->newCreateDistributor($name, $phn, $mail, $address, $description);
					$data['distributor_info'] 	= $this -> product_model -> distributor_info();
					$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
				}

			}
			else{

			}

			//$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);

		}
		/* Ending: newCreateDistributor (12-12-16) */
		/* Service Provider Entry Form */
		
		/* Service Provider Entry Form */
		function service_provider_registration()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'service_provider_registration'))
			{
				//* for sale Running Status */
				$data['sale_status'] = '';
				/* end of Sale running Status*/
				$data['status'] = '';
				$data['user_name'] = $this->tank_auth->get_username();
				$data['alarming_level'] = FALSE;
				//$data['main_content'] = 'service_provider_registration_form_view';
				//$data['tricker_content'] = 'tricker_account_view';
				$this -> load -> view('service_provider_registration_form_view', $data);
			}
			else redirect('account_controller/account/noaccess');
		}
		/* Create a New service Provider */
		/* function create_service_provider()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'service_provider_registration'))
			{
				//* for sale Running Status */
				//$data['sale_status'] = '';
				/* end of Sale running Status
				$data['user_name'] = $this->tank_auth->get_username();
				
				$this -> form_validation -> set_rules('service_provider_name', 'Service Provider Name','required|xss_clean');
				$this -> form_validation -> set_rules('service_provider_address', 'Service Provider Address','required|xss_clean');
				$this -> form_validation -> set_rules('service_provider_contact', 'Phone Number','required|xss_clean|numeric');
				//$this -> form_validation -> set_rules('service_provider_email', 'Email Address','required|valid_email');
				$this -> form_validation -> set_rules('service_provider_type', 'Description','max_length[250]|xss_clean');
				$data['alarming_level'] = FALSE;		
				$data['main_content'] = 'service_provider_registration_form_view';
				$data['tricker_content'] = 'tricker_account_view';	
				$service_provider_name = $this -> input -> post('service_provider_name');
				if($this -> form_validation -> run() ==  FALSE)
				{
					$data['status'] = 'error';
					$this -> load -> view('include/template', $data);
				}
				else
				{
					$exists = $this -> product_model -> redundancy_check('service_provider_info', 'service_provider_name', $service_provider_name);
					if($exists)
					{
						$data['status'] = 'exists';
						$this -> load -> view('include/template', $data);
					}
					else if($this -> registration_model -> create_service_provider())
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
			else redirect('account_controller/account/noaccess');
		} */
		
		function create_service_provider()
		{
			
			$this -> form_validation -> set_rules('service_provider_name', 'Service Provider Name','required|xss_clean');
			//$this -> form_validation -> set_rules('service_provider_address', 'Service Provider Address','required|xss_clean');
			//$this -> form_validation -> set_rules('service_provider_contact', 'Phone Number','required|xss_clean|numeric');
			//$this -> form_validation -> set_rules('service_provider_email', 'Email Address','required|valid_email');
			//$this -> form_validation -> set_rules('service_provider_type', 'Description','max_length[250]|xss_clean');
			if($this -> form_validation -> run() ==  FALSE)
			{
				echo json_encode(array('mssage'=>'error'));
			}
			else
			{
				$service_provider_name = $this -> input ->post('service_provider_name');
																					//table_name   ,  field name,      element
				$exists = $this -> product_model -> redundancy_check('service_provider_info', 'service_provider_name', $service_provider_name);
				if($exists == true)
				{
					echo 'exist';
				}
				else if($this -> registration_model -> create_service_provider())
				{
					echo 'success';
				}
				else
				{
					echo 'error';
				}
			}
		}
		function create_owner()
		{
			
			$this -> form_validation -> set_rules('owner_name', 'Owner Name','required|xss_clean');
			if($this -> form_validation -> run() ==  FALSE)
			{
				echo json_encode(array('mssage'=>'error'));
			}
			else
			{
				$owner_name = $this -> input ->post('owner_name');
																					//table_name   ,  field name,      element
				$exists = $this -> product_model -> redundancy_check('owner_info', 'owner_name', $owner_name);
				if($exists == true)
				{
					echo 'exist';
				}
				else if($this -> registration_model -> create_owner())
				{
					echo 'success';
				}
				else
				{
					echo 'error';
				}
			}
		}
		function create_new_client()
		{
			
			$this -> form_validation -> set_rules('customer_name', 'Customer Name','required|xss_clean');
			if($this -> form_validation -> run() ==  FALSE)
			{
				echo json_encode(array('mssage'=>'error'));
			}
			else
			{
				$customer_name = $this -> input ->post('customer_name');
																					//table_name   ,  field name,      element
				$exists = $this -> product_model -> redundancy_check('customer_info', 'customer_name', $customer_name);
				if($exists == true)
				{
					echo 'exist';
				}
				else if($id=$this -> registration_model -> create_new_client())
				{
					//echo 'success';
					echo $id;
				}
				else
				{
					echo 'error';
				}
			}
		}
		
		
	    function customer_registration()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'customer_registration'))
			{
				$data['sale_status'] = '';
				$data['status'] = '';
				$data['user_name'] = $this->tank_auth->get_username();
				$data['customer_info'] = $this -> registration_model -> customer_info();
				$data['customer_mode'] = $this -> registration_model -> customer_mode();
				
				$data['alarming_level'] = FALSE;
				$this -> load -> view('customer_registration_form_view', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		/* Create a New customer */
		function create_customer()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'customer_registration'))
			{
				$data['sale_status'] = '';
				$this -> form_validation -> set_rules('customer_name', 'Customer Name','required');
				$this -> form_validation -> set_rules('customer_contact_no', 'Customer Contact No','numeric|required');
				$this -> form_validation -> set_rules('customer_type', 'Customer Type','required');
				$this -> form_validation -> set_rules('customer_mode', 'Customer Mode','required');
				
				$data['alarming_level'] = FALSE;
				$data['status'] = '';
				$data['user_type'] = $this->tank_auth->get_usertype();
				$data['user_name'] = $this->tank_auth->get_username();
				$customername = $this -> input -> post('customer_name');
				$customer_contact = $this -> input -> post('customer_contact_no');
				
				$data['customer_info'] = $this -> registration_model -> customer_info();
				$data['customer_mode'] = $this -> registration_model -> customer_mode();
				
				if($this -> form_validation -> run() ==  FALSE)
				{
					$data['status'] = 'error';
				}
				else
				{
					
					$exists = $this -> product_model -> redundancy_check('customer_info', 'customer_contact_no', $customer_contact);
					if($exists)
					{
						$data['status'] = 'exists';
						$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissible" style="background:#f39c12;">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Already Exist</h4>
				</div>');
					}
					else if($this -> registration_model -> create_customer())
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
				$this->load->view('customer_registration_form_view', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
				
		
		/* User Modification */
		function user_modification()
		{
			
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			if($data['user_type'] == 'superadmin' || $data['user_type'] == 'admin' || $data['user_type'] == 'manager' )
			{
				$data['sale_status'] = '';
				$data['status'] = '';
				
				$data['alarming_level'] = FALSE;
				//$data['main_content'] = 'user_modification_form_view';
				$data['user_info'] = $this -> registration_model -> all_user();
				//if($this -> uri -> segment(3))
				$data['change_mood'] = $this -> registration_model -> specific_user();
				//$data['tricker_content'] = 'tricker_registration_view';
				//$this -> load -> view('include/template', $data);
				$this -> load -> view('user_modification_form_view', $data);
			}
			else redirect('registration_controller/registration/noaccess');
		}

        function update_user()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			if($data['user_type'] == 'superadmin' || $data['user_type'] == 'admin' || $data['user_type'] == 'manager' )
			{
				//* for sale Running Status */
				$data['sale_status'] = '';
				/* end of Sale running Status*/	
					
				$this -> form_validation -> set_rules('user_address', 'User Address','required|xss_clean');
				$this -> form_validation -> set_rules('email', 'Phone Number','numeric|required|xss_clean');
				//$this-> form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
				//$this-> form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');
				$data['alarming_level'] = FALSE;
				$data['errors'] = array();
				$data['status']='';
				
				if ($this->form_validation->run(TRUE)) 
				{
					$this->tank_auth->change_password_special($this->form_validation->set_value('new_password'), $this->input->post('ch_id'));
					$this -> registration_model -> update_user();
					$data['status'] = 'success';
					$data['user_type'] = $this->tank_auth->get_usertype();
					$data['user_name'] = $this->tank_auth->get_username();
					$data['user_info'] = $this -> registration_model -> all_user();
					$data['change_mood'] = $this -> registration_model -> specific_user();
					$this -> load -> view('user_modification_form_view', $data);
					
				}
				else
				{
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
					$data['status'] = 'error';
					$data['user_type'] = $this->tank_auth->get_usertype();
					$data['user_name'] = $this->tank_auth->get_username();
					$data['user_info'] = $this -> registration_model -> all_user();
					$data['change_mood'] = $this -> registration_model -> specific_user();
					$this -> load -> view('user_modification_form_view', $data);
				}
			}
			else redirect('registration_controller/registration/noaccess');
		}
		/*investor entry*/
		function investor_registration()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['alarming_level'] = FALSE;
			//$data['main_content'] = 'investor_registration_form_view';
			//$data['tricker_content'] = 'tricker_account_view';
			$this -> load -> view('investor_registration_form_view', $data);
		}
		function create_investor()
		{
			
			$this -> form_validation -> set_rules('investor_name', 'Investor Name','required|xss_clean');
			$this -> form_validation -> set_rules('investor_address', 'Investor Address','required|xss_clean');
			$this -> form_validation -> set_rules('investor_contact_no', 'Phone Number','required|xss_clean|numeric');
			//$this -> form_validation -> set_rules('investor_email', 'Investor Email','required|valid_email');
			$this -> form_validation -> set_rules('investor_description', 'Description','max_length[250]|xss_clean');
			if($this -> form_validation -> run() ==  FALSE)
			{
				echo json_encode(array('mssage'=>'error'));
			}
			else
			{
				$investor_name = $this -> input -> post('investor_name');
																    //table_name   ,  field name1, field name2,  element1,  element2 
				$exists = $this -> product_model -> redundancy_check('investor_info', 'investor_name', $investor_name);
				if($exists == true)
				{
					echo 'exist';
				}
				else if($this -> registration_model -> create_investor())
				{
					echo 'success';
				}
				else
				{
					echo 'error';
				}
			}
		}
		
		
		
		/***********************
		* Employee Salary Setup
		* 19-01-2014
		* Arafat Mamun
		************************/
		function employee_salary_setup()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'employee_salary_setup'))
			{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['sale_status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['access_status'] = '';
			$data['status'] = '';
			
			
			$this->form_validation->set_rules('selectedUserId', ' ', 'trim|required|xss_clean|numeric');
			$this->form_validation->set_rules('salaryAmount', ' ', 'trim|required|xss_clean|numeric');
			$this->form_validation->set_rules('extraPayment', ' ', 'trim|xss_clean|numeric');
			$this->form_validation->set_rules('reducedAmount', ' ', 'trim|xss_clean|numeric');
			$this->form_validation->set_rules('salaryMonth', ' ', 'trim|xss_clean|required');
			$this->form_validation->set_rules('salaryYear', ' ', 'trim|xss_clean|required|numeric');
			if($this->form_validation->run())
			{
				
				if($this -> registration_model -> employee_salary_setup(
					$this->form_validation->set_value('selectedUserId'),
					$this->form_validation->set_value('salaryAmount'),
					$this->form_validation->set_value('extraPayment'),
					$this->form_validation->set_value('reducedAmount'),
					$this->form_validation->set_value('salaryMonth'),
					$this->form_validation->set_value('salaryYear')
				   ))
					$data['status'] = 'successful';
				else $data['status'] = 'error';
			}
			
			$query = $this -> registration_model -> userInformation(FALSE, 0);
			$all_employee[''] = 'Select An Employee';
			foreach($query -> result() as $field):
				$all_employee[ base_url().'registration_controller/employee_salary_setup/'.$field -> id] = $field -> username.' ( '.$field -> user_full_name.' )';
			endforeach;
			$data['user_info'] = $all_employee;
			
			$data['specific_user'] = $this -> registration_model -> userInformation( TRUE, $this -> uri -> segment(3) );
			
			$prev_date = date("d",strtotime(date("Y-m-d", strtotime($data['bd_date'])) . " -1 year"));
			$prev_month = date("m",strtotime(date("Y-m-d", strtotime($data['bd_date'])) . " -1 year"));
			$prev_year = date("Y",strtotime(date("Y-m-d", strtotime($data['bd_date'])) . " -1 year"));
			$temp_date = date("Y-m-d",strtotime($prev_year.'-'.$prev_month.'-'.$prev_date));
			
			$data['specific_user_salary'] = $this -> registration_model -> userSalaryInformation(TRUE, $this -> uri -> segment(3), TRUE, $temp_date, $data['bd_date']);
			$data['alarming_level'] = FALSE;
			
			//$data['main_content'] = 'employee_salary_setup_view';
			//$data['tricker_content'] = 'tricker_registration_view';
			//$this -> load -> view('include/template', $data);
			$this -> load -> view('employee_salary_setup_view', $data);
			}
			else redirect('registration_controller/registration/noaccess');
		}
			
	}
