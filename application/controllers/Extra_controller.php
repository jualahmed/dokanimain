<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

	class Extra_controller extends CI_controller{
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
		// controlling home page
		function create_catagory()
		{
			
			$this -> form_validation -> set_rules('catagory_name', 'Catagory Name','required');
			$this -> form_validation -> set_rules('catagory_description', 'Catagory Description');
			if($this -> form_validation -> run() ==  FALSE)
			{
				echo json_encode(array('mssage'=>'error'));
			}
			else
			{
				$catagory_name = $this -> input ->post('catagory_name');
																	// table_name   ,  field name,      element
				$exists = $this -> product_model -> redundancy_check('catagory_info', 'catagory_name', $catagory_name);
				if($exists == true)
				{
					echo 'exist';
				}
				else if($this -> product_model -> create_catagory())
				{
					echo 'success';
				}
				else
				{
					echo 'error';
				}
			}
		}
		
		/* Create a New Company */
        function create_company()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'company_registration'))
			{
				//* for sale Running Status */
				$data['sale_status'] = '';
				/* end of Sale running Status*/
				$data['user_name'] = $this->tank_auth->get_username();
				
				$this -> form_validation -> set_rules('company_name', 'Company Name','required|xss_clean');
				//$this -> form_validation -> set_rules('company_address', 'Company Address','required|xss_clean');
				//$this -> form_validation -> set_rules('company_contact_no', 'Phone Number','numeric|required|xss_clean');
				//$this -> form_validation -> set_rules('company_email', 'Company Email','required');
				//$this -> form_validation -> set_rules('company_description', 'Description','max_length[250]|xss_clean');

				$companyname = $this -> input -> post('company_name');
				if($this -> form_validation -> run() ==  FALSE)
				{
					echo "error";
				}
				else
				{
					
					$exist = $this -> product_model -> redundancy_check('company_info', 'company_name', $companyname);
					if($exist)
					{
						echo 'exist';
					}
					else if($this -> registration_model -> create_company())
					{
						echo 'success';
					}
					else
					{
						echo 'error';
					}
				}
			}
			else redirect('product_controller/product/noaccess');
		}
		
		/* Create a New Company */
        function create_unit()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'company_registration'))
			{
				//* for sale Running Status */
				$data['sale_status'] = '';
				/* end of Sale running Status*/
				$data['user_name'] = $this->tank_auth->get_username();
				
				$this -> form_validation -> set_rules('unit_name', 'Unit Name','required|xss_clean');

				$unit_name = $this -> input -> post('unit_name');
				if($this -> form_validation -> run() ==  FALSE)
				{
					echo "error";
				}
				else
				{
					
					$exist = $this -> product_model -> redundancy_check('unit_info', 'unit_name', $unit_name);
					if($exist)
					{
						echo 'exist';
					}
					else if($this -> registration_model -> create_unit())
					{
						echo 'success';
					}
					else
					{
						echo 'error';
					}
				}
			}
			else redirect('product_controller/product/noaccess');
		}
		
		/* Create a New Company */
        function create_group()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'company_registration'))
			{
				//* for sale Running Status */
				$data['sale_status'] = '';
				/* end of Sale running Status*/
				$data['user_name'] = $this->tank_auth->get_username();
				
				$this -> form_validation -> set_rules('group_name', 'Group Name','required|xss_clean');
				$this -> form_validation -> set_rules('group_description', 'Group Description','required|xss_clean');

				$group_name = $this -> input -> post('group_name');
				if($this -> form_validation -> run() ==  FALSE)
				{
					echo "error";
				}
				else
				{
					
					$exist = $this -> product_model -> redundancy_check('group_info', 'group_name', $group_name);
					if($exist)
					{
						echo 'exist';
					}
					else if($this -> registration_model -> create_group())
					{
						echo 'success';
					}
					else
					{
						echo 'error';
					}
				}
			}
			else redirect('product_controller/product/noaccess');
		}
		
		/* Create a New Distributor */
        function create_distributor()
		{
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'distributor_registration'))
			{
				//* for sale Running Status */
				$data['sale_status'] = '';
				/* end of Sale running Status*/
				$data['user_type'] = $this->tank_auth->get_usertype();
				$data['user_name'] = $this->tank_auth->get_username();

				
				$this -> form_validation -> set_rules('distributor_name', 'Distributor Name','required|xss_clean');
				//$this -> form_validation -> set_rules('distributor_address', 'Distributor Address','required|xss_clean');
				//$this -> form_validation -> set_rules('distributor_contact_no', 'Phone Number','required|xss_clean|numeric');
				//$this -> form_validation -> set_rules('distributor_email', 'Distributor Email','required|valid_email');
				//$this -> form_validation -> set_rules('distributor_description', 'Description','max_length[250]|xss_clean');
				$distributorname = $this -> input -> post('distributor_name');
				if($this -> form_validation -> run() ==  FALSE)
				{
					echo 'error';
				}
				else
				{
					
					$exists = $this -> product_model -> redundancy_check('distributor_info', 'distributor_name', $distributorname);
					if($exists)
					{
						echo 'exist';
					}
					else if($this -> registration_model -> create_distributor())
					{
						echo 'success';
					}
					else
					{
						echo 'failed';
					}
				}
			}
			else redirect('product_controller/product/noaccess');
		}
		
    /* to create purchase receipt*/
	function create_purchase_receipt()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'purchase_receipt_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			
			$this -> form_validation -> set_rules('distributor_id', 'Distributor Name','required');
			$this -> form_validation -> set_rules('grand_total', 'Total Purchae','required|numeric');
			$this -> form_validation -> set_rules('transport_cost', 'Transport Cost','required|numeric');
			$this -> form_validation -> set_rules('gift_on_purchase', 'Discount','required|numeric');
			$data['user_name'] = $this->tank_auth->get_username();

			$data['distributor_info'] = $this -> product_model -> distributor_info();
			if($this -> form_validation -> run() ==  FALSE)
			{
				echo 'error';
			}
			else
			{
				if($data['receipt_id'] = $this -> account_model -> create_purchase_receipt())
				{
					echo 'success';
				}
				else
				{
					echo 'error';
				}
			}
		}
		else redirect('account_controller/account/noaccess');	
	}
		
		
		function retrive_and_select($table='',$id='',$field_name='',$vlaues='')
		{
			$json_response = array();
			if($vlaues==''){
			$this->db->select_max($id);
			$que = $this->db->get($table);
			$rw= $que->row_array();
			$values = $rw[$id];
			$this->db->where($id,$values);
			$quer = $this->db->get($table);
			$rwo= $quer->row_array();
			$value = $rwo[$field_name];
			}
			else{
				$value = $vlaues;
			}
			$prove = '';
			$this->db->select('*');
			//$this->db->where($id,$rw[$id]);
			$query = $this->db->get($table);
			$row = $query->result_array();
			
			$prove.= "<option value=>Please Select a $field_name";
			if($query->num_rows() > 0){
				foreach($row as $field){
					$ids = $field[$id];
					$prove.= "<option value='$field[$field_name]'>$field[$field_name]";
				}
			}
			$data[] = $prove;
			$data[] = $value;
			echo json_encode($data);
		}
		function retrive_and_select_with_id($table='',$id='',$field_name='',$vlaues='')
		{
			$json_response = array();
			if($vlaues==''){
			$this->db->select_max($id);
			$que = $this->db->get($table);
			$rw= $que->row_array();
			$values = $rw[$id];
			$this->db->where($id,$values);
			$quer = $this->db->get($table);
			$rwo= $quer->row_array();
			$value = $rwo[$id];
			}
			else{
				$this->db->where($field_name,$vlaues);
				$quer = $this->db->get($table);
				$rwo= $quer->row_array();
				$value = $rwo[$id];
			}
			$prove = '';
			$this->db->select('*');
			//$this->db->where($id,$rw[$id]);
			$query = $this->db->get($table);
			$row = $query->result_array();
			
			$prove.= "<option value=>Please Select a $field_name";
			if($query->num_rows() > 0){
				foreach($row as $field){
					$ids = $field[$id];
					$prove.= "<option value='$field[$id]'>$field[$field_name]";
				}
			}
			$data[] = $prove;
			$data[] = $value;
			echo json_encode($data);
		}
		
		function exception_retrive_and_select($table='',$id='',$sec_table='',$sec_id='',$sec_field='')
		{
		
		/* $table='purchase_receipt_info';
		$id='receipt_id';
		$sec_table='distributor_info';
		$sec_id='distributor_id';
		$sec_field='distributor_name';  */
		
			$json_response = array();

			$this->db->select_max($id);
			$que = $this->db->get($table);
			$rw= $que->row_array();
			$values = $rw[$id];

			$prove = '';

			$this->db->from($table);
			$this->db->join($sec_table,$sec_table.'.'.$sec_id.' = '.$table.'.'.$sec_id,'left');
			$query = $this->db->get();
			$row = $query->result_array();
			
			$prove.= "<option value=>Please Select a $table";
			if($query->num_rows() > 0){
				foreach($row as $field){
					$ids = $field[$id];
					$prove.= "<option value='$field[$id]'>$field[$id] ($field[$sec_field])";
				}
			}
			$data[] = $prove;
			$data[] = $values;
			echo json_encode($data);
		}
	}