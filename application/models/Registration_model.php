<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Registration_model extends CI_model{

		
	
		function all_general_user()
		{
			$this -> db -> order_by('username',"asc");
			$this -> db -> select('users.id, users.username, user_full_name, users.user_type,users.user_type');
			$this -> db -> from('users');
			$this -> db -> where('users.user_type != "superadmin"');
			$query = $this -> db -> get();
			$temp[''] =  'Select a User Name';
			foreach ($query-> result() as $field){
				$temp[ base_url().'index.php/Registration/transfer_employee/'.$field -> username] = $field -> username.' ( '.$field -> user_full_name.' )';
			}
			return $temp;
		}
	
		function transfer_employee( $selected_user, $new_assigned_shop)
		{
			$user_up = array(
				'shop_id'    => $new_assigned_shop
			);
			
			$this->db->where('id', $selected_user);
			$up = $this->db->update('users', $user_up);
			return $up;
		}

		function create_company()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
		
		    /***********************************************************************************
		     * 
		     * rtrim(your_string,"the character you want to remove");
		     * 
		     * we used this function to remove a specific character from the end of a string
		     * 
		     ***********************************************************************************/
			
			$company_name = $this -> input ->post('company_name');
			$temp_name = rtrim($company_name, ";");
			//echo $temp_company_name;
			
			$new_company_insert_data = array(
				'company_name' => mysql_real_escape_string(strtoupper($temp_name)),
				'company_address' => $this -> input -> post('company_address'),
				'company_contact_no' => $this -> input -> post('company_contact_no'),
				'company_email' => $this -> input -> post('company_email'),
				'company_description' => $this -> input -> post('company_description'),
				'company_doc' => $bd_date,
				'company_dom' => $bd_date,
				'company_creator' => $creator
			);
			$insert = $this -> db -> insert('company_info', $new_company_insert_data);
			return $insert;
		}

		function create_distributor()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			
			/***********************************************************************************
		     * 
		     * rtrim(your_string,"the character you want to remove");
		     * 
		     * we used this function to remove a specific character from the end of a string
		     * 
		     ***********************************************************************************/
			
			$distributor_name = $this -> input ->post('distributor_name');
			$temp_name = rtrim($distributor_name, ";");
			
			$new_distributor_insert_data = array(
	
				'distributor_name' 				=> mysql_real_escape_string(strtoupper($temp_name)),
				'distributor_address' 			=> $this -> input -> post('distributor_address'),
				'distributor_contact_no' 		=> $this -> input -> post('distributor_contact_no'),
				'distributor_email' 			=> $this -> input -> post('distributor_email'),
				'distributor_description' 		=> $this -> input -> post('distributor_description'),
				'int_balance' 					=> $this -> input -> post('initial_balance'),
				'distributor_doc' 				=> $bd_date,
				'distributor_dom' 				=> $bd_date,
				'distributor_creator' 			=> $creator
			);
			$insert = $this -> db -> insert('distributor_info', $new_distributor_insert_data);
			return $insert;
		}
		
		public function newCreateDistributor($name, $phn, $mail, $address, $description)
		{
			$timezone 	= "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date 	= date('Y-m-d');
			$creator 	= $this->tank_auth->get_user_id();
			$temp_name 	= rtrim($name, ";");
			
			$new_distributor_insert_data = array(
	
				'distributor_name' 			=> $temp_name,
				'distributor_address' 		=> $address,
				'distributor_contact_no' 	=> $phn,
				'distributor_email' 		=> $mail,
				'distributor_description' 	=> $description,
				'distributor_doc' 			=> $bd_date,
				'distributor_dom' 			=> $bd_date,
				'distributor_creator' 		=> $creator
			);
			$insert = $this -> db -> insert('distributor_info', $new_distributor_insert_data);
			return $insert;	
		}

		function create_owner()
		{
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			$owner_name = $this -> input ->post('owner_name');
			$temp_name = rtrim($owner_name, ";");
			$new_owner_insert_data = array(
				'owner_name' => $temp_name,
				'owner_address' => $this->input->post('owner_address'),
				'owner_contact' => $this->input->post('owner_contact'),
				'owner_email' => $this->input->post('owner_email'),
				'owner_type' => $this->input->post('owner_type'),
				'owner_description' => $this->input->post('owner_description'),
				'owner_doc' => $bd_date,
				'owner_dom' => $bd_date,
				'owner_creator' => $creator
			);
			$insert = $this->db->insert('owner_info', $new_owner_insert_data);
			return $insert;
		}

		function create_loan_person()
		{
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			$loan_person_name = $this -> input ->post('loan_person_name');
			$temp_name = rtrim($loan_person_name, ";");
			$new_loan_person_insert_data = array(
				'loan_person_name' => $temp_name,
				'loan_person_address' => $this -> input -> post('loan_person_address'),
				'loan_person_contact' => $this -> input -> post('loan_person_contact'),
				'loan_person_email' => $this -> input -> post('loan_person_email'),
				'loan_person_type' => $this -> input -> post('loan_person_type'),
				'loan_person_description' => $this -> input -> post('loan_person_description'),
				'loan_person_doc' => $bd_date,
				'loan_person_dom' => $bd_date,
				'loan_person_creator' => $creator
			);
			$insert = $this -> db -> insert('loan_person_info', $new_loan_person_insert_data);
			return $insert;
		}

		function create_new_client()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			
			$customer_name = $this -> input ->post('customer_name');
			$customer_contact_no = $this -> input ->post('customer_contact_no');
			$customer_email = $this -> input ->post('customer_email');
			$customer_address = $this -> input ->post('customer_address');

			
			$customer_info = array(
				'customer_name' => $customer_name,
				'customer_contact_no' => $customer_contact_no,
				'customer_email' => $customer_email,
				'customer_address' => $customer_address,
				'customer_doc' => $bd_date,
				'customer_dom' => $bd_date,
				'customer_creator' => $creator
			);
			$insert = $this -> db -> insert('customer_info', $customer_info);
			
			return $this->db->insert_id();
		}
		/* customer Info */
		function customer_info()
		{
			
				$data = array(
				    ''  => 'Select A Type',
				    'Individual' => 'Individual',
				    'Corporate' => 'Corporate'
	         	);
		    return $data;
		}
		/* customer Mode*/
		function customer_mode()
		{
			
				$data = array(
				    ''  => 'Select a Mode',
				    'normal' => 'Normal',
				    'registered' => 'Registered'
	         	);
		    return $data;
		}
		
		function create_customer()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			
			/***********************************************************************************
			 * 
			 * rtrim(your_string,"the character you want to remove");
			 * 
			 * we used this function to remove a specific character from the end of a string
			 * 
			 ***********************************************************************************/
			
			$customer_name = $this -> input ->post('customer_name');
			$temp_name = rtrim($customer_name, ";");
			
			$new_customer_insert_data = array(
				'customer_name' 		=> mysql_real_escape_string(strtoupper($temp_name)),
				'customer_define_id' 	=> $this -> input -> post('customer_define_id'),
				'customer_contact_no' 	=> $this -> input -> post('customer_contact_no'),
				'customer_type' 		=> $this -> input -> post('customer_type'),
				'customer_mode' 		=> $this -> input -> post('customer_mode'),
				'customer_address' 		=> $this -> input -> post('customer_address'),
				'customer_email' 		=> $this -> input -> post('customer_email'),
				'int_balance' 			=> $this -> input -> post('initial_balance'),
				'customer_doc' 			=> $bd_date,
				'customer_dom' 			=> $bd_date,
				'customer_creator' 		=> $creator
			);
			$insert = $this -> db -> insert('customer_info', $new_customer_insert_data);
			return $insert;
		}
		
		function create_unit()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
		
		    /***********************************************************************************
		     * 
		     * rtrim(your_string,"the character you want to remove");
		     * 
		     * we used this function to remove a specific character from the end of a string
		     * 
		     ***********************************************************************************/
			
			$unit_name = $this -> input ->post('unit_name');
			$temp_name = rtrim($unit_name, ";");
			
			$new_unit_insert_data = array(
				'unit_name' => $temp_name
			);
			$insert = $this -> db -> insert('unit_info', $new_unit_insert_data);
			return $insert;
		}

		
		function create_investor()
		{
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			$investor_name = $this -> input ->post('investor_name');
			$temp_name = rtrim($investor_name, ";");
			$new_investor_insert_data = array(

				'investor_name' => $temp_name,
				'investor_address' => $this -> input -> post('investor_address'),
				'investor_contact_no' => $this -> input -> post('investor_contact_no'),
				'investor_email' => $this -> input -> post('investor_email'),
				'investor_description' => $this -> input -> post('investor_description'),
				'investor_doc' => $bd_date,
				'investor_dom' => $bd_date,
				'investor_creator' => $creator
			);
			$insert = $this -> db -> insert('investor_info', $new_investor_insert_data);
			return $insert;
		}
	
		public function userInformation()
		{
			$specific=$this -> uri -> segment(3);
			$this -> db -> order_by('username',"asc");
			$this -> db -> select('users.username,users.user_address,users.email,
								   users.user_type,users.id,user_full_name,created,
								   shop_name,shop_address');
			$this -> db -> from('users,shop_setup');
			$this -> db -> where('users.shop_id = shop_setup.shop_id');
			$this -> db -> where('users.user_type != "superadmin"');
			$this -> db -> where('users.user_type != "admin"');
			if($specific) $this -> db -> where('users.id', $specific);
			
			return $this -> db -> get();
		}

		public function userInformation_1()
		{
			$this -> db -> order_by('username',"asc");
			$this -> db -> select('users.username,users.user_address,users.email,
								   users.user_type,users.id,user_full_name,created,
								   shop_name,shop_address');
			$this -> db -> from('users,shop_setup');
			$this -> db -> where('users.shop_id = shop_setup.shop_id');
			$this -> db -> where('users.user_type != "superadmin"');
			$this -> db -> where('users.user_type != "admin"');
			return $this -> db -> get();
		}
	
		public function userSalaryInformation($specific, $userId, $date, $startDate, $endDate)
		{
			$this->db->order_by('salary_log_id',"asc");
			$this->db->select('user_full_name,users.id, username, salary_log_id, salary_amount, extra_payment,
								   reduced_amount,salary_month, salary_year,salary_doc, mode, salary_creator');
			$this->db->from('users,employee_salary_log');
			$this->db->where('users.id = employee_salary_log.user_id');
			$this->db->where('users.user_type != "superadmin"');
			$this->db->where('users.user_type != "admin"');
			if($specific) $this->db->where('users.id', $userId);
			$this->db->where('salary_status', 1);
			return $this->db->get();
		}
	
		public function employee_salary_setup($selectedUserId, $salaryAmount, $extraPayment,
									   $reducedAmount,$salaryMonth, $salaryYear)
		{
			$data = array(
               'user_id' => $selectedUserId,
               'salary_amount' => $salaryAmount,
               'extra_payment' => $extraPayment,
               'reduced_amount' => $reducedAmount,
               'salary_month' => $salaryMonth,
               'salary_year' => $salaryYear,
               'mode' => 'Salary',
               'salary_creator' => $this -> tank_auth -> get_user_id(),
               'salary_status' => 1
            );
			return $this->db-> insert('employee_salary_log', $data);
		}
}
