<?php if(! defined('BASEPATH')) exit('No direct script access allowed'); 
	class Modify_controller extends CI_controller{
		public function __construct()
		{
	        parent::__construct();
			
			$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
			$this->is_logged_in();
			
		}	
		public function is_logged_in()
		{
			if(!$this->tank_auth->is_logged_in())
			{
				redirect('auth/login');
			}
		}
		
		/***********************
		* Shop Modify
		* 2016-12-24
		* Ovi
		************************/

		public function shop_modify_new()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['shop_data'] = $this->modify_model->get_shop_info_modify();
			
			$this->load->view('Modify/shop_modify_new',$data);
		}
		public function get_shop_info(){
			$shop_id = $this->input->post('shop_id');
			$this->db->where('shop_id',$shop_id);
			$query = $this->db->get('shop_setup');
			echo json_encode($query->row());
		}
		public function update_shop_info()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$shop_name = $this -> input ->post('shop_name');
			if($this -> modify_model -> update_shop())
			{
				$data['status'] = 'successful';
				$this->session->set_flashdata('msg1', '<div class="alert alert-success alert-dismissible" style="background:#00a65a;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Success</h4></div>');
			}
			else
			{
				$data['status'] = 'failed';
				$this->session->set_flashdata('msg2', '<div class="alert alert-danger alert-dismissible" style="background:#dd4b39;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-check"></i> Failed</h4></div>');
			}
			$data['shop_data'] = $this->modify_model->get_shop_info_modify();
			$this -> load -> view('Modify/shop_modify_new', $data);
		}
		/***********************
		* Shop Modify
		* 2016-12-24
		* Ovi
		************************/
		/***********************
		* Invoice Modify
		* 2018-02-01
		* Ovi
		************************/
		public function invoice_modify_new()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$this->load->view('Modify/invoice_modify_new',$data);
		}
		public function get_invoice_info_modify()
		{
            $records = $this -> modify_model -> get_invoice_info_modify();
            echo json_encode($records->result());
        }
		public function modify_single_invoice()
		{
			$invoice_id = $this->uri->segment(3);
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
            $data['invoice_record'] = $this -> modify_model -> get_single_invoice_info_modify($invoice_id);
            $data['invoice_product_record'] = $this -> modify_model -> get_single_invoice_product_info_modify($invoice_id);
			$data['return_id'] 			= $this->modify_model->getReturnId($invoice_id);
			$data['return_adjust'] 		= $this->modify_model->getReturnAdjustAmount($invoice_id);
			$data['customer_info'] 	= $this->sale_model->getAllCustomerInfo();
            $this->load->view('Modify/modify_single_invoice',$data);
        }
		
		/***********************
		* Invoice Modify
		* 2018-02-01
		* Ovi
		************************/
		/***********************
		* Category / Group Modify
		* 2016-12-24
		* Ovi
		************************/
		public function catagory_modify_new()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$this->load->view('Modify/catagory_modify_new',$data);
		}
		public function get_catagory_info_modify()
		{
            $records = $this -> modify_model -> get_catagory_info_modify();
            echo json_encode($records->result());
        }
		function catagory_info_edit()
		{
			$id = $this->input->post('id');
			if($id!='')
			{
				$d['records'] = $this -> modify_model -> specific_catagory_new($id);
			}
			echo json_encode($d);
		}
		function save_catagory_info_edit()
		{
			$hid = $this->input->post('hid');
			
			$this->modify_model->save_catagory_info_edit($hid);
			$d = $this -> modify_model -> specific_catagory_new($hid);
			echo json_encode($d);
		}

		function delete_catagory()
		{
			$catagory_id = $this->input->post('id');
			$d = $this -> modify_model -> delete_catagory($catagory_id);
			echo json_encode($d);
				
		}

		/***********************
		* Category / Group Modify
		* 2016-12-24
		* Ovi
		************************/
		/***********************
		* Company Modify
		* 2016-12-24
		* Ovi
		************************/
		public function company_modify_new()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$this->load->view('Modify/company_modify_new',$data);
		}
		public function get_company_info_modify()
		{
            $records = $this -> modify_model -> get_company_info_modify();
            echo json_encode($records->result());
        }
		function company_info_edit()
		{
			$id = $this->input->post('id');
			if($id!='')
			{
				$d['records'] = $this -> modify_model -> specific_company_new($id);
			}
			echo json_encode($d);
		}
		function save_company_info_edit()
		{
			$hid = $this->input->post('hid');
			
			$this->modify_model->save_company_info_edit($hid);
			$d = $this -> modify_model -> specific_company_new($hid);
			echo json_encode($d);
		}

		function delete_company()
		{
			$company_id = $this->input->post('id');
			$d = $this -> modify_model -> delete_company($company_id);
			echo json_encode($d);
				
		}

		/***********************
		* Company Modify
		* 2016-12-24
		* Ovi
		************************/
		/***********************
		* Distributor Modify
		* 2016-12-24
		* Ovi
		************************/
		public function distributor_modify_new()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$this->load->view('Modify/distributor_modify_new',$data);
		}
		public function get_distributor_info_modify()
		{
            $records = $this -> modify_model -> get_distributor_info_modify();
            echo json_encode($records->result());
        }
		function distributor_info_edit()
		{
			$id = $this->input->post('id');
			if($id!='')
			{
				$d['records'] = $this -> modify_model -> specific_distributor_new($id);
			}
			echo json_encode($d);
		}
		function save_distributor_info_edit()
		{
			$hid = $this->input->post('hid');
			
			$this->modify_model->save_distributor_info_edit($hid);
			$d = $this -> modify_model -> specific_distributor_new($hid);
			echo json_encode($d);
		}

		function delete_distributor()
		{
			$distributor_id = $this->input->post('id');
			$d = $this -> modify_model -> delete_distributor($distributor_id);
			echo json_encode($d);
				
		}
		/***********************
		* Distributor Modify
		* 2016-12-24
		* Ovi
		************************/
		/***********************
		* Customer Modify
		* 2016-12-24
		* Ovi
		************************/
		public function customer_modify_new()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$this->load->view('Modify/customer_modify_new',$data);
		}
		public function get_customer_info_modify()
		{
            $records = $this -> modify_model -> get_customer_info_modify();
            echo json_encode($records->result());
        }
		function customer_info_edit()
		{
			$id = $this->input->post('id');
			if($id!='')
			{
				$d['records'] = $this -> modify_model -> specific_customer_new($id);
			}
			echo json_encode($d);
		}
		function save_customer_info_edit()
		{
			$hid = $this->input->post('hid');
			
			$this->modify_model->save_customer_info_edit($hid);
			$d = $this -> modify_model -> specific_customer_new($hid);
			echo json_encode($d);
		}

		function delete_customer()
		{
			$customer_id = $this->input->post('id');
			$d = $this -> modify_model -> delete_customer($customer_id);
			echo json_encode($d);
				
		}
		/***********************
		* Customer Modify
		* 2016-12-24
		* Ovi
		************************/
		
		/***********************
		* Staff Modify
		* 2018-06-11
		* Ovi
		************************/
		function staff_info_edit()
		{
			$staff_id = $this->input->post('id');
			if($staff_id!='')
			{
				$d['records'] = $this -> modify_model -> specific_staff_new($staff_id);
			}
			echo json_encode($d);
		}
		function save_staff_info_edit()
		{
			$hid = $this->input->post('hid');
			
			$this->modify_model->save_staff_info_edit($hid);
			$d = $this -> modify_model -> specific_staff_new($hid);
			echo json_encode($d);
		}

		function delete_staff()
		{
			$staff_id = $this->input->post('id');
			$d = $this -> modify_model -> delete_staff($staff_id);
			echo json_encode($d);
				
		}
		/***********************
		* Staff Modify
		* 2016-06-11
		* Ovi
		************************/
		/***********************
		* Damage Modify
		* 2016-12-24
		* Ovi
		************************/
		public function damage_modify_new()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$this->load->view('Modify/damage_modify_new',$data);
		}
		public function get_damage_info_modify()
		{
            $records = $this -> modify_model -> get_damage_info_modify();
            echo json_encode($records->result());
        }
		function damage_info_edit()
		{
			$id = $this->input->post('id');
			if($id!='')
			{
				$d['records'] = $this -> modify_model -> specific_damage_new($id);
			}
			echo json_encode($d);
		}
		function save_damage_info_edit()
		{
			$hid = $this->input->post('hid');
			
			$this->modify_model->save_damage_info_edit($hid);
			$d = $this -> modify_model -> specific_damage_new($hid);
			echo json_encode($d);
		}

		function delete_damage()
		{
			$damage_id = $this->input->post('id');
			$quantity = $this->input->post('quantity');
			$product_id = $this->input->post('product_id');
			$d = $this -> modify_model -> delete_damage($damage_id,$quantity,$product_id);
			echo json_encode($d);
				
		}
		/***********************
		* Damage Modify
		* 2016-12-24
		* Ovi
		************************/
		/***********************
		* Product Modify
		* 2016-12-24
		* Ovi
		************************/
		function product_report()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['status'] = '';
			$data['temp'] = '';
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['sale_status'] = '';
			$data['alarming_level'] = FALSE;
			$data['company_name'] = $this -> product_model -> company_name();
			$data['catagory_name'] = $this -> product_model -> catagory_name();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['status'] = '';
			$this -> load -> view('Modify/all_product_report_new', $data);
		}
		 public function search_product()
		 {
    		
			$key			= $this->input->post('term');
			$flag 			= (int)$this->input->post('flag');
			$field_name 	= "";

			if($flag == 1){
				$field_name 	= 'product_name';
			}
			$data 	= $this->modify_model->search_and_get_product($key, $field_name);
			
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
		function  all_stock_report_by_barcode()
		{
			$barcode = $this->input->post('barcode');
			$temp 	 = $this->modify_model->all_stock_report_by_barcode($barcode);
			
			echo json_encode($temp->result());

		}
		
		function all_product_report_find()
		{

			$temp22 = $this->modify_model->get_product_info_by_multi();
			
			echo json_encode($temp22->result());

		}
		public function get_product_info()
		{
			$product_id = $this->input->post('product_id');
			$this->db->select('*');
			$this->db->from('temp_sale_details');
			$this->db->where('temp_sale_details.product_id',$product_id);
			$data_temp = $this->db->get();
			//print_r($data_temp);
			if($data_temp->num_rows== 0)
			{
				$this->db->select('product_info.product_name,product_info.unit_name, product_info.company_name, product_info.catagory_name, product_info.product_id,bulk_stock_info.bulk_unit_sale_price, bulk_stock_info.bulk_unit_buy_price,bulk_stock_info.bulk_alarming_stock,bulk_stock_info.stock_amount,bulk_stock_info.general_unit_sale_price,product_info.barcode,product_info.product_size,product_info.product_model');
				$this->db->from('product_info,bulk_stock_info');
				$this->db->where('product_info.product_id = bulk_stock_info.product_id');
				$this->db->where('product_info.product_id',$product_id);
				$query = $this->db->get();
				echo json_encode($query->row());
				//$pre = 'Not Pre Listed';
				//echo json_encode($pre);
			} 
			else
			{
				$pre = 'Pre Listed';
				echo json_encode($pre);
			}
		} 
		public function get_all_product_report()
		{
			$barcode = $this->input->post('barcode');
			$product = $this->input->post('product');
			$catagory = $this->input->post('catagory');
			$company = $this->input->post('company');
			$this->db->select('product_info.product_name,product_info.unit_name, product_info.company_name, product_info.catagory_name, product_info.product_id,bulk_stock_info.bulk_unit_sale_price, bulk_stock_info.bulk_unit_buy_price,bulk_stock_info.bulk_alarming_stock,bulk_stock_info.stock_amount,bulk_stock_info.general_unit_sale_price,product_info.barcode,product_info.product_size,product_info.product_model');
			$this->db->from('product_info,bulk_stock_info');
			$this->db->where('product_info.product_id = bulk_stock_info.product_id');
			if($product!='' && $product!='null'){$this->db->where('product_info.product_id',$product);}
			if($barcode!='' && $barcode!='null'){$this->db->where('product_info.barcode',$barcode);}
			if($catagory!='' && $catagory!='null'){$this->db->where('product_info.catagory_name',$catagory);}
			if($company!='' && $company!='null'){$this->db->where('product_info.company_name',$company);}
			$query = $this->db->get();
			echo json_encode($query->result());
		} 
		
		public function get_all_company_info(){
			$this->db->select('distinct(company_name)');
			$this->db->order_by('company_name','asc');
			$query = $this->db->get('product_info');
			echo json_encode($query->result());
		}
		public function get_all_catagory_info(){
			$this->db->select('distinct(catagory_name)');
			$this->db->order_by('catagory_name','asc');
			$query = $this->db->get('catagory_info');
			echo json_encode($query->result());
		} 
		public function get_all_unit_info(){
			$this->db->select('distinct(unit_name)');
			$this->db->order_by('unit_name','asc');
			$query = $this->db->get('unit_info');
			echo json_encode($query->result());
		} 
		
		public function update_product_info()
		{
			$data['temp']=$this -> modify_model -> update_product_new();
		}
		function product_info_edit()
		{
			$id = $this->input->post('id');
			
			$d['catagory_records'] = $this -> modify_model -> all_select_list('catagory_info','catagory_name','catagory_name');
			$d['company_records'] = $this -> modify_model -> all_select_list('company_info','company_name','company_name');
			$d['unit_records'] = $this -> modify_model -> all_select_list('unit_info','unit_name','unit_name');
			
			if($id!=''){
				$d['records'] = $this -> modify_model -> specific_product_new($id);
			}
			$cn= $d['records']->catagory_name;
			$cm= $d['records']->company_name;
			$cu= $d['records']->unit_name;
			
			$d['cnn']=form_dropdown('cnn[]',$d['catagory_records'],$cn,' class="ccn" style="width:100%;"');
			$d['com']=form_dropdown('com[]',$d['company_records'],$cm,' class="ccm" style="width:100%;"');
			$d['uni']=form_dropdown('uni[]',$d['unit_records'],$cu,' class="ccu" style="width:100%;"');
			
			echo json_encode($d);
		}
		function save_product_info_edit()
		{
			$hid = $this->input->post('hid');
			
			$this->modify_model->save_product_info_edit($hid);
			//$d = $this -> modify_model -> specific_product_new($hid);
			echo true;
		}

		function check_delete_product()
		{
			$product_id = $this->input->post('id');
			$this->db->select('*');
			$this->db->from('temp_sale_details');
			$this->db->where('temp_sale_details.product_id',$product_id);
			$data_temp = $this->db->get();
			if($data_temp->num_rows==0)
			{
				
				$pre = 'Not Pre Listed';
				echo json_encode($pre);
			}
			else
			{
				$pre = 'Pre Listed';
				echo json_encode($pre);
			}
		}
		function delete_productt()
		{
			$product_id = $this->input->post('id');

			$d = $this -> modify_model -> delete_product($product_id);
			echo json_encode($d);
			
		}
		/***********************
		* Product Modify
		* 2016-12-24
		* Ovi
		************************/
		/***********************
		* Expense Modify
		* 2016-12-24
		* Ovi
		************************/
		function  expense_modify_new()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['status'] = '';
			$data['temp'] = '';
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['sale_status'] = '';
			$data['alarming_level'] = FALSE;
			$data['user_name'] = $this->tank_auth->get_username();
			$data['expense_name'] = $this -> product_model -> expense_name();
			$data['status'] = '';
			$this -> load -> view('Modify/all_expense_report_new_modify', $data);
		}
		function all_expense_report_find_new()
		{

			$temp22 = $this->report_model->get_expense_info_by_multi_new();
			
			echo json_encode($temp22->result());

		}
		function get_expense_info()
		{
			$expense_id = $this->input->post('expense_id');
			$this->db->select('*');
			$this->db->from('expense_info');
			$this->db->where('expense_info.expense_id',$expense_id);
			$query = $this->db->get();
			echo json_encode($query->row());

		}
		
		public function update_expense_info()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'modify_controller', 'distributor_modify'))
			{
				$data['status'] = '';
				$data['user_name'] = $this->tank_auth->get_username();
				$data['purchase_receipt'] = $this -> product_model -> purchase_receipt_new_expense();
				$data['expense_name'] = $this -> product_model -> expense_name();
				if($data['temp']=$this -> modify_model -> update_expense_new())
				{
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
				$this->load->view('all_expense_report_new_modify',$data);
			}
		}
		/***********************
		* Expense Modify
		* 2016-12-24
		* Ovi
		************************/
		/***********************
		* Card Modify
		* 2016-12-24
		* Ovi
		************************/
		
		function card_report()
		{
		   $data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
			{
				$data['status'] = '';
				$data['temp'] = '';
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['bd_date'] = $bd_date;
				$data['sale_status'] = '';
				$data['alarming_level'] = FALSE;
				$data['card_name'] = $this -> product_model -> card_name();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['status'] = '';
				$this -> load -> view('Modify/all_card_report_new', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		
		function all_card_report_find()
		{

			$temp22 = $this->report_model->get_card_info_by_multi();
			
			echo json_encode($temp22->result());

		}
		
		function card_info_edit()
		{
			$id = $this->input->post('id');
			
			$d['bank_records'] = $this -> report_model -> all_select_list_2('bank_info','bank_id','bank_name');
			
			if($id!=''){
				$d['records'] = $this -> report_model -> specific_card_new($id);
			}
			$cb= $d['records']->bank_id;
			
			$d['cbn']=form_dropdown('cbn[]',$d['bank_records'],$cb,' class="ccb form-control" style="width:100%;"');
			
			echo json_encode($d);
		}
		function save_card_info_edit()
		{
			$hid = $this->input->post('hid');
			
			$this->report_model->save_card_info_edit($hid);
			$d = $this -> report_model -> specific_card_new($hid);
			echo json_encode($d);
		}
		/***********************
		* Expense Modify
		* 2016-12-24
		* Ovi
		************************/
		
		/***********************
		* Barcode Print Modify
		* 2016-12-24
		* Ovi
		************************/
		/* delete specific product from barcode */

		function delete_barcode_print_product($print_id = ''){
			$this->db->where('print_id',$print_id); 
			$this->db->delete('barcode_print'); 
			redirect('site_controller/searchBarcode');
		}
		 
		/* delete all product from barcode */

		function delete_all_barcode_print_product(){
			$this->db->empty_table('barcode_print'); 
			redirect('site_controller/searchBarcode');
		}
		/***********************
		* Barcode Print Modify
		* 2016-12-24
		* Ovi
		************************/
		/***********************
		* Cheque Status Modify
		* 2016-12-24
		* Ovi
		************************/
		function cheque_status_edit()
		{
			$cheque_id =$this->input->post('id');
			
			$d['status_records'] = $this -> modify_model -> all_type_list();
			
			if($cheque_id!=''){
				$d['records'] = $this -> modify_model -> specific_cheque($cheque_id);
			}
			$sn= $d['records']->status;
			
			$d['snn']=form_dropdown('snn[]',$d['status_records'],$sn,' class="ssn form-control" style="width:100%;"');
			echo json_encode($d);
		}
		function save_cheque_status_edit()
		{
			$hid = $this->input->post('hid');
			
			$this->modify_model->save_cheque_status_edit($hid);
			$d = $this -> modify_model -> specific_cheque($hid);
			echo json_encode($d);
		}
		/***********************
		* Cheque Status Modify
		* 2016-12-24
		* Ovi
		************************/
		
		/***********************
		* Purchase Receipt Modify
		* 2018-04-02
		* Ovi
		************************/
		/*******************************************************
		 *  Modify Total Purchase Price of an Purchase Recipt
		 **************************************************************/
		function total_purchase_price_modify()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'modify_controller', 'total_purchase_price_modify'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['bd_date'] = $bd_date;
				$data['alarming_level'] = false;
				$data['sale_status'] = '';
				$data['status'] = '';
				$data['receipt_general_details'] = '';
				$data['user_name'] = $this->tank_auth->get_username();
				$temp = $this -> report_model -> all_purchase_receipt();
				$receipt[''] =  'Select A Purchase Receipt';
				foreach ($temp -> result() as $field)
				{
					$receipt[$field -> receipt_id] = $field -> receipt_id.' (  '.$field -> distributor_name.'  )';	
				}
				$data['purchase_receipt'] = $receipt;
				$this -> load -> view('Modify/modify_total_purchase_price_view', $data);
			}
			else redirect('modify_controller/modify/noaccess');
		}
		function total_purchase_price()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['alarming_level'] = false;
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['receipt_general_details'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$temp = $this -> report_model -> all_purchase_receipt();
			$receipt[''] =  'Select A Purchase Receipt';
			foreach ($temp -> result() as $field)
			{
				$receipt[$field -> receipt_id] = $field -> receipt_id.' (  '.$field -> distributor_name.'  )';	
			}
			$data['purchase_receipt'] = $receipt;
			if($this -> uri -> segment(3))
			{
				$data['receipt_general_details'] = $this -> report_model -> specific_purchase_receipt_general( $this -> uri -> segment(3));
			}
			$this -> load -> view('Modify/modify_total_purchase_price_view', $data);
		}
		/**************************************************************
		 * Apply Modify Total Purchase Price of an Purchase Recipt    *
		 **************************************************************/
		function total_purchase_price_modify_apply()
		{
			$receipt_id = $this -> input -> post('receipt_id');
			if($this -> modify_model -> total_purchase_price_modify_apply())
			{
				redirect('modify_controller/total_purchase_price/'.$receipt_id.'/successful');
			}
			else 
			{
				redirect('modify_controller/total_purchase_price/'.$receipt_id.'/failed');
			
			}
		 }
		/***********************
		* Purchase Receipt Modify
		* 2018-04-02
		* Ovi
		************************/
	}
