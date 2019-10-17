<?php if(! defined('BASEPATH')) exit('No direct script access allowed'); 
class Modify extends My_controller{

	public function __construct()
	{
        parent::__construct();
		$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->is_logged_in();
		$this->load->model('Purchaselisting_model');
	}	

	public function is_logged_in()
	{
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login');
		}
	}

	public function invoice_modify_new()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['status'] = '';
		$data['user_name'] = $this->tank_auth->get_username();
		$data['vuejscomp'] = 'invoice_modify_new.js';
		$this->__renderview('Modify/invoice_modify_new',$data);
	}

	public function transaction_modify()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['status'] = '';
		$data['user_name'] = $this->tank_auth->get_username();
		$data['vuejscomp'] = 'transaction_modify.js';
		$this->__renderview('Modify/transaction_modify',$data);
	}

	public function total_purchase_price_modify()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this->access_control_model->my_access($data['user_type'], 'modify', 'total_purchase_price_modify'))
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
			$temp = $this->report_model->all_purchase_receipt();
			$receipt[''] =  'Select A Purchase Receipt';
			foreach ($temp -> result() as $field)
			{
				$receipt[$field->receipt_id]=$field->receipt_id.' (  '.$field->distributor_name.'  )';	
			}
			$data['purchase_receipt'] = $receipt;
			$data['vuejscomp'] = 'modify_total_purchase_price_view.js';
			$this->__renderview('Modify/modify_total_purchase_price_view', $data);
		}
		else redirect('modify/modify/noaccess');
	}

	public function expense_modify_new()
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
		$data['expense_name'] = $this->product_model->expense_name();
		$data['status'] = '';
		$data['vuejscomp'] = 'expense_modify_new.js';
		$this->__renderview('Modify/expense_modify_new', $data);
	}

	
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

	
	public function get_invoice_info_modify()
	{
        $records = $this -> modify_model -> get_invoice_info_modify();
        echo json_encode($records->result());
    }
	public function modify_single_invoice()
	{
		$invoice_id = $this->input->post('id');

		$records = $this -> modify_model -> modify_single_invoice($invoice_id);
        echo json_encode($records);
    }


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
	* Transaction Modify
	* 2019-04-02
	* Ovi
	************************/
	
	public function get_transaction_modify()
	{
        $records = $this -> modify_model -> get_transaction_modify();
        echo json_encode($records->result());
    }
	function delete_transaction()
	{
		$transaction_id = $this->input->post('id');
		$d = $this -> modify_model -> delete_transaction($transaction_id);
		echo json_encode($d);
			
	}


	function product_image_report()
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
		$this -> load -> view('Modify/all_product_image_report_new', $data);
	}

	public function get_all_unit_info(){
		$this->db->select('distinct(unit_name)');
		$this->db->order_by('unit_name','asc');
		$query = $this->db->get('unit_info');
		echo json_encode($query->result());
	} 


	function save_product_image()
	{
		$hid = $this->input->post('hid');
		
		$this->modify_model->save_product_image($hid);
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
	
	public function delete_expense_info()
	{
		$expense_id = $this->input->post('id');

		$d = $this -> modify_model -> delete_expense_info($expense_id);
		echo json_encode($d);
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
		if($this -> access_control_model -> my_access($data['user_type'], 'Product', 'product_entry'))
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
		else redirect('Product/product/noaccess');
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

	function total_purchase_price()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
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
		if($this->uri->segment(3))
		{
			$data['receipt_general_details'] = $this->Purchaselisting_model->specific_purchase_receipt_general( $this -> uri -> segment(3));
		}
		$this->__renderview('Modify/modify_total_purchase_price_view', $data);
	}
	/**************************************************************
	 * Apply Modify Total Purchase Price of an Purchase Recipt    *
	 **************************************************************/
	function total_purchase_price_modify_apply()
	{
		$receipt_id = $this->input->post('receipt_id');
		if($this->modify_model->total_purchase_price_modify_apply())
		{
			redirect('modify/total_purchase_price/'.$receipt_id.'/successful');
		}
		else 
		{
			redirect('modify/total_purchase_price/'.$receipt_id.'/failed');
		
		}
	}
	/***********************
	* Purchase Receipt Modify
	* 2018-04-02
	* Ovi
	************************/
}
