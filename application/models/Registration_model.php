<<<<<<< HEAD
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	class Registration_model extends CI_model{

			/***************************
			 * Shop Setup
			 * 22-11-2013
			 * Arafat Mamun
			 ***************************/
			function shop_setup($shopName, $shopType, $shopAddress, $shopContact)
			{
				$creator = $this -> tank_auth -> get_user_id();
				$data = array(
					'shop_name' => rtrim($shopName,";"),
					'shop_type' => $shopType,
					'shop_address' => $shopAddress,
					'shop_contact' => $shopContact,
					'shop_creator' => $creator,
					'shop_status' => 1
				);
				return $this -> db -> insert('shop_setup', $data);
			}
			
			/***************************
			 * All General User
			 * 22-11-2013
			 * Arafat Mamun
			 ***************************/
			function all_general_user()
			{
				$this -> db -> order_by('username',"asc");
				$this -> db -> select('users.id, users.username, user_full_name, users.user_type,users.user_type');
				$this -> db -> from('users');
				$this -> db -> where('users.user_type != "superadmin"');
				$query = $this -> db -> get();
				$temp[''] =  'Select a User Name';
				foreach ($query-> result() as $field){
					$temp[ base_url().'index.php/registration_controller/transfer_employee/'.$field -> username] = $field -> username.' ( '.$field -> user_full_name.' )';
				}
				return $temp;
			}
			/*********************
			 * Transfer Employee
			 * 13-12-2013
			 * Arafat Mamun
			************************/
			function transfer_employee( $selected_user, $new_assigned_shop)
			{
				$user_up = array(
					'shop_id'    => $new_assigned_shop
				);
				
				$this->db->where('id', $selected_user);
				$up = $this->db->update('users', $user_up);
				return $up;
			}
			
			/* Insert a Company */
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
			
			/* Insert A Distributor */
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
			/* Insert A Service Provider */
			/* Starting: newCreateDistributor (12-12-16)*/
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
			/* Ending: newCreateDistributor (12-12-16)*/
			function create_service_provider()
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
				
				$service_provider_name = $this -> input ->post('service_provider_name');
				$temp_name = rtrim($service_provider_name, ";");
				
				$new_service_provider_insert_data = array(
					'service_provider_name' => $temp_name,
					'service_provider_address' => $this -> input -> post('service_provider_address'),
					'service_provider_contact' => $this -> input -> post('service_provider_contact'),
					'service_provider_email' => $this -> input -> post('service_provider_email'),
					'service_provider_type' => $this -> input -> post('service_provider_type'),
					'service_provider_description' => $this -> input -> post('service_provider_description'),
					'service_provider_doc' => $bd_date,
					'service_provider_dom' => $bd_date,
					'service_provider_creator' => $creator
				);
				$insert = $this -> db -> insert('service_provider_info', $new_service_provider_insert_data);
				return $insert;
			}
			function create_owner()
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
				
				$owner_name = $this -> input ->post('owner_name');
				$temp_name = rtrim($owner_name, ";");
				
				$new_owner_insert_data = array(
					'owner_name' => $temp_name,
					'owner_address' => $this -> input -> post('owner_address'),
					'owner_contact' => $this -> input -> post('owner_contact'),
					'owner_email' => $this -> input -> post('owner_email'),
					'owner_type' => $this -> input -> post('owner_type'),
					'owner_description' => $this -> input -> post('owner_description'),
					'owner_doc' => $bd_date,
					'owner_dom' => $bd_date,
					'owner_creator' => $creator
				);
				$insert = $this -> db -> insert('owner_info', $new_owner_insert_data);
				return $insert;
			}
			function create_loan_person()
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
			
						/* Insert a Unit */
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

			function all_user()
			{
				$usertype = $this -> tank_auth -> get_usertype();
				$this -> db -> order_by('username',"asc");
				$this -> db -> select('users.id, users.username, user_full_name, users.user_type,users.user_type');
				$this -> db -> from('users');
				if($usertype == 'manager')
				{
					$this -> db -> where('users.user_type = "seller"');
					$this -> db -> or_where('users.user_type = "stockist"');
					$this -> db -> or_where('users.user_type = "accountent"');
				}
				else if($usertype == 'admin')
					{
						$this -> db -> where('users.user_type = "manager" ');
						$this -> db -> or_where('users.user_type = "accountent"');
						$this -> db -> or_where('users.user_type = "seller" ');
						$this -> db -> or_where('users.user_type = "stockist"');
					}
				if($usertype == 'superadmin')
				{
					$this -> db -> where('users.user_type = "superadmin" ');
					$this -> db -> or_where('users.user_type = "admin"');
					$this -> db -> or_where('users.user_type = "manager"');
					$this -> db -> or_where('users.user_type = "accountent"');
					$this -> db -> or_where('users.user_type = "seller"');
					$this -> db -> or_where('users.user_type = "stockist"');				 
				}
				$query = $this -> db -> get();
				$data[''] =  'Select a User Name';
				foreach ($query-> result() as $field){
					//$length = strlen($field -> username);
					//$defined_length = 20;
					//$space = '';
					//$space =  nbs($defined_length - $length); 
					$data[ base_url().'index.php/registration_controller/user_modification/'.$field -> username] = $field -> username.' ( '.$field -> user_full_name.' )';
				}
				return $data;
			}
			
			function specific_user()
			{
				$name = $this -> uri -> segment(3);
				$usertype = $this -> tank_auth -> get_usertype();
				$this -> db -> select('users.username,users.user_address,users.email,users.user_type,users.id,user_full_name');
				$this -> db -> from('users');
				$this -> db -> where('users.username = "'.$name.'"');
				$query = $this -> db -> get();
				
				foreach($query -> result() as $check):
					$type = $check -> user_type;
					if($usertype == 'manager')
					{
						if($type == 'seller' || $type == 'stockist' || $type == 'accountent') return $query;
						else
						{
							$this -> db -> select('users.username,users.user_address,users.email,users.user_type');
							$this -> db -> from('users');
							$this -> db -> where('users.username = ""');
							$query = $this -> db -> get();
						}
					}
					else if($usertype == 'admin')
					{
						if($type == 'seller' || $type == 'stockist' || $type == 'accountent' || $type == 'manager') return $query;
						else
						{
							$this -> db -> select('users.username,users.user_address,users.email,users.user_type');
							$this -> db -> from('users');
							$this -> db -> where('users.username = ""');
							$query = $this -> db -> get();
						}
					}
					else if($usertype == 'superadmin')
					{
						if($type == 'seller' || $type == 'stockist' || $type == 'accountent' || $type == 'manager' || $type == 'admin' || $type = 'superadmin') return $query;
						else
						{
							$this -> db -> select('users.username,users.user_address,users.email,users.user_type');
							$this -> db -> from('users');
							$this -> db -> where('users.username = ""');
							$query = $this -> db -> get();
						}			 
					}
				endforeach;
				
				return $query;
		    }

			function update_user($hashed_password,$new_password)
			{
				$username 		= $this -> input -> post('username');
				$u_id 			= $this -> input -> post('ch_id');
				$new_type 			= $this -> input -> post('new_user_type');
				$contact 			= $this -> input -> post('email');
				$user_add 			= $this -> input -> post('user_address');
				$user_full_name 	= $this -> input -> post('user_full_name');
				
				$user_up = array(
					'username'     	=> $username,
					'user_type'    	=> $new_type,
					'password'        	=> $hashed_password,
					'password2'        	=> $new_password,
					'email'        	=> $contact,
					'user_address' 	=> $user_add,
					'user_full_name' => $user_full_name
				);
				
				$this->db->where('id', $u_id);
				$up = $this->db->update('users', $user_up);
				return $up;
			}
			
			
			/*************************************************
			 *  Function to Backup The Running Database       *
			 * ************************************************/
			 function backup_database()
			 {
			 	$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$this->load->dbutil();
				/* LIST All Database */
				/*$dbs = $this->dbutil->list_databases();
				foreach ($dbs as $db)
				{
					echo $db;
				}*/
			
				if ($this->dbutil->database_exists('dokani'))
				{
				  $prefs = array(
									'tables'      => array(),  // Array of tables to backup.
									//'ignore'      => array(),           // List of tables to omit from the backup
									'format'      => 'txt',             // gzip, zip, txt
									//'filename'    => 'test.sql',    // File name - NEEDED ONLY WITH ZIP FILES
									'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
									'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
									'newline'     => "\n"               // Newline character used in backup file
									);
					$backup =& $this->dbutil->backup($prefs);
					/***********************************************************************************
					 * Back up System For Windows  *
					 *******************************/
					
					//Load the file helper and write the file to your server 
					$path = "D:\\dokani_backup\\".$bd_date; // For Windows
					
				    if(!is_dir($path)) //create the folder if it's not already exists
				    {
				      mkdir($path,0700,TRUE);
				    } 
					$this->load->helper('file');
					write_file($path.'\\dokani.sql', $backup); // For Windows
					
					/*********** End Of Windows Backup **************************************************/
					
					
					/****************************
					 * Back up System For Linux *
					 ****************************/
					/* Load the file helper and write the file to your server */
					//chmod("/opt/lampp/htdocs/backup", 0700);
					/*
					$path = "/opt/lampp/htdocs/cashCarry/dataBase/".$bd_date; // For Linux
				    if(!is_dir($path)) //create the folder if it's not already exists
				    {
				      mkdir($path,0700,TRUE);
				    } 
					$this->load->helper('file');
					write_file($path.'/cash_carry.sql', $backup); // For Linux
					
					$prev_month = date("m",strtotime(date("Y-m-d", strtotime($bd_date)) . " -1 month"));
					$prev_year = date("Y",strtotime(date("Y-m-d", strtotime($bd_date)) . " -1 month"));
					$num_of_days = cal_days_in_month(CAL_GREGORIAN, $prev_month, $prev_year).'</br>';
					
					for($all_date = 1; $all_date < $num_of_days; $all_date++)
					{
						$temp_date = date("Y-m-d",strtotime($prev_year.'-'.$prev_month.'-'.$all_date));
						if (is_dir('/opt/lampp/htdocs/cashCarry/dataBase/'.$temp_date)) {
							unlink('/opt/lampp/htdocs/cashCarry/dataBase/'.$temp_date.'/cash_carry.sql');
							rmdir('/opt/lampp/htdocs/cashCarry/dataBase/'.$temp_date);
						}
					}
					/*********** End Of Windows Backup **************************************************/

					return true;
				}
				return false;
			 }
			 /*create investor*/
			 function create_investor()
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
		/**********************************
		 * All / Specific User Information
		 * 19-01-2014
		 * Arafat Mamun
		***********************************/
		function userInformation()
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
		function userInformation_1()
		{
			//$specific=$this -> uri -> segment(3);
			$this -> db -> order_by('username',"asc");
			$this -> db -> select('users.username,users.user_address,users.email,
								   users.user_type,users.id,user_full_name,created,
								   shop_name,shop_address');
			$this -> db -> from('users,shop_setup');
			$this -> db -> where('users.shop_id = shop_setup.shop_id');
			$this -> db -> where('users.user_type != "superadmin"');
			$this -> db -> where('users.user_type != "admin"');
			//if($specific) $this -> db -> where('users.id', $specific);
			
			return $this -> db -> get();
		}
		/****************************************
		 * All / Specific User Salary Information
		 * 19-01-2014
		 * Arafat Mamun
		******************************************/
		function userSalaryInformation($specific, $userId, $date, $startDate, $endDate)
		{
			/* For automation salary (half done)
			$this -> db -> order_by('username',"asc");
			$this -> db -> select('salary_id, salary_amount, extra_payment,reduced_amount, salary_status');
			$this -> db -> from('users,employee_salary');
			$this -> db -> where('users.id = employee_salary.user_id');
			$this -> db -> where('users.user_type != "superadmin"');
			$this -> db -> where('users.user_type != "admin"');
			if($specific) $this -> db -> where('users.id', $userId);
			if(!$specific) $this -> db -> where('salary_status', 1);
			return $this -> db -> get();
			*/
			$this -> db -> order_by('salary_log_id',"asc");
			$this -> db -> select('user_full_name,users.id, username, salary_log_id, salary_amount, extra_payment,
								   reduced_amount,salary_month, salary_year,salary_doc, mode, salary_creator');
			$this -> db -> from('users,employee_salary_log');
			$this -> db -> where('users.id = employee_salary_log.user_id');
			$this -> db -> where('users.user_type != "superadmin"');
			$this -> db -> where('users.user_type != "admin"');
			if($specific) $this -> db -> where('users.id', $userId);
			$this -> db -> where('salary_status', 1);
			return $this -> db -> get();
		}
		
		/***********************
		* Employee Salary Setup
		* 19-01-2014
		* Arafat Mamun
		************************/
		function employee_salary_setup($selectedUserId, $salaryAmount, $extraPayment,
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
=======
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	class Registration_model extends CI_model{

			/***************************
			 * Shop Setup
			 * 22-11-2013
			 * Arafat Mamun
			 ***************************/
			function shop_setup($shopName, $shopType, $shopAddress, $shopContact)
			{
				$creator = $this -> tank_auth -> get_user_id();
				$data = array(
					'shop_name' => rtrim($shopName,";"),
					'shop_type' => $shopType,
					'shop_address' => $shopAddress,
					'shop_contact' => $shopContact,
					'shop_creator' => $creator,
					'shop_status' => 1
				);
				return $this -> db -> insert('shop_setup', $data);
			}
			
			/***************************
			 * All General User
			 * 22-11-2013
			 * Arafat Mamun
			 ***************************/
			function all_general_user()
			{
				$this -> db -> order_by('username',"asc");
				$this -> db -> select('users.id, users.username, user_full_name, users.user_type,users.user_type');
				$this -> db -> from('users');
				$this -> db -> where('users.user_type != "superadmin"');
				$query = $this -> db -> get();
				$temp[''] =  'Select a User Name';
				foreach ($query-> result() as $field){
					$temp[ base_url().'index.php/registration_controller/transfer_employee/'.$field -> username] = $field -> username.' ( '.$field -> user_full_name.' )';
				}
				return $temp;
			}
			/*********************
			 * Transfer Employee
			 * 13-12-2013
			 * Arafat Mamun
			************************/
			function transfer_employee( $selected_user, $new_assigned_shop)
			{
				$user_up = array(
					'shop_id'    => $new_assigned_shop
				);
				
				$this->db->where('id', $selected_user);
				$up = $this->db->update('users', $user_up);
				return $up;
			}
			
			/* Insert a Company */
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
			
			/* Insert A Distributor */
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
			/* Insert A Service Provider */
			/* Starting: newCreateDistributor (12-12-16)*/
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
			/* Ending: newCreateDistributor (12-12-16)*/
			function create_service_provider()
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
				
				$service_provider_name = $this -> input ->post('service_provider_name');
				$temp_name = rtrim($service_provider_name, ";");
				
				$new_service_provider_insert_data = array(
					'service_provider_name' => $temp_name,
					'service_provider_address' => $this -> input -> post('service_provider_address'),
					'service_provider_contact' => $this -> input -> post('service_provider_contact'),
					'service_provider_email' => $this -> input -> post('service_provider_email'),
					'service_provider_type' => $this -> input -> post('service_provider_type'),
					'service_provider_description' => $this -> input -> post('service_provider_description'),
					'service_provider_doc' => $bd_date,
					'service_provider_dom' => $bd_date,
					'service_provider_creator' => $creator
				);
				$insert = $this -> db -> insert('service_provider_info', $new_service_provider_insert_data);
				return $insert;
			}
			function create_owner()
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
				
				$owner_name = $this -> input ->post('owner_name');
				$temp_name = rtrim($owner_name, ";");
				
				$new_owner_insert_data = array(
					'owner_name' => $temp_name,
					'owner_address' => $this -> input -> post('owner_address'),
					'owner_contact' => $this -> input -> post('owner_contact'),
					'owner_email' => $this -> input -> post('owner_email'),
					'owner_type' => $this -> input -> post('owner_type'),
					'owner_description' => $this -> input -> post('owner_description'),
					'owner_doc' => $bd_date,
					'owner_dom' => $bd_date,
					'owner_creator' => $creator
				);
				$insert = $this -> db -> insert('owner_info', $new_owner_insert_data);
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
			
						/* Insert a Unit */
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

			function all_user()
			{
				$usertype = $this -> tank_auth -> get_usertype();
				$this -> db -> order_by('username',"asc");
				$this -> db -> select('users.id, users.username, user_full_name, users.user_type,users.user_type');
				$this -> db -> from('users');
				if($usertype == 'manager')
				{
					$this -> db -> where('users.user_type = "seller"');
					$this -> db -> or_where('users.user_type = "stockist"');
					$this -> db -> or_where('users.user_type = "accountent"');
				}
				else if($usertype == 'admin')
					{
						$this -> db -> where('users.user_type = "manager" ');
						$this -> db -> or_where('users.user_type = "accountent"');
						$this -> db -> or_where('users.user_type = "seller" ');
						$this -> db -> or_where('users.user_type = "stockist"');
					}
				if($usertype == 'superadmin')
				{
					$this -> db -> where('users.user_type = "superadmin" ');
					$this -> db -> or_where('users.user_type = "admin"');
					$this -> db -> or_where('users.user_type = "manager"');
					$this -> db -> or_where('users.user_type = "accountent"');
					$this -> db -> or_where('users.user_type = "seller"');
					$this -> db -> or_where('users.user_type = "stockist"');				 
				}
				$query = $this -> db -> get();
				$data[''] =  'Select a User Name';
				foreach ($query-> result() as $field){
					//$length = strlen($field -> username);
					//$defined_length = 20;
					//$space = '';
					//$space =  nbs($defined_length - $length); 
					$data[ base_url().'index.php/registration_controller/user_modification/'.$field -> username] = $field -> username.' ( '.$field -> user_full_name.' )';
				}
				return $data;
			}
			
			function specific_user()
			{
				$name = $this -> uri -> segment(3);
				$usertype = $this -> tank_auth -> get_usertype();
				$this -> db -> select('users.username,users.user_address,users.email,users.user_type,users.id,user_full_name');
				$this -> db -> from('users');
				$this -> db -> where('users.username = "'.$name.'"');
				$query = $this -> db -> get();
				
				foreach($query -> result() as $check):
					$type = $check -> user_type;
					if($usertype == 'manager')
					{
						if($type == 'seller' || $type == 'stockist' || $type == 'accountent') return $query;
						else
						{
							$this -> db -> select('users.username,users.user_address,users.email,users.user_type');
							$this -> db -> from('users');
							$this -> db -> where('users.username = ""');
							$query = $this -> db -> get();
						}
					}
					else if($usertype == 'admin')
					{
						if($type == 'seller' || $type == 'stockist' || $type == 'accountent' || $type == 'manager') return $query;
						else
						{
							$this -> db -> select('users.username,users.user_address,users.email,users.user_type');
							$this -> db -> from('users');
							$this -> db -> where('users.username = ""');
							$query = $this -> db -> get();
						}
					}
					else if($usertype == 'superadmin')
					{
						if($type == 'seller' || $type == 'stockist' || $type == 'accountent' || $type == 'manager' || $type == 'admin' || $type = 'superadmin') return $query;
						else
						{
							$this -> db -> select('users.username,users.user_address,users.email,users.user_type');
							$this -> db -> from('users');
							$this -> db -> where('users.username = ""');
							$query = $this -> db -> get();
						}			 
					}
				endforeach;
				
				return $query;
		    }

			function update_user($hashed_password,$new_password)
			{
				$username 		= $this -> input -> post('username');
				$u_id 			= $this -> input -> post('ch_id');
				$new_type 			= $this -> input -> post('new_user_type');
				$contact 			= $this -> input -> post('email');
				$user_add 			= $this -> input -> post('user_address');
				$user_full_name 	= $this -> input -> post('user_full_name');
				
				$user_up = array(
					'username'     	=> $username,
					'user_type'    	=> $new_type,
					'password'        	=> $hashed_password,
					'password2'        	=> $new_password,
					'email'        	=> $contact,
					'user_address' 	=> $user_add,
					'user_full_name' => $user_full_name
				);
				
				$this->db->where('id', $u_id);
				$up = $this->db->update('users', $user_up);
				return $up;
			}
			
			
			/*************************************************
			 *  Function to Backup The Running Database       *
			 * ************************************************/
			 function backup_database()
			 {
			 	$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$this->load->dbutil();
				/* LIST All Database */
				/*$dbs = $this->dbutil->list_databases();
				foreach ($dbs as $db)
				{
					echo $db;
				}*/
			
				if ($this->dbutil->database_exists('dokani'))
				{
				  $prefs = array(
									'tables'      => array(),  // Array of tables to backup.
									//'ignore'      => array(),           // List of tables to omit from the backup
									'format'      => 'txt',             // gzip, zip, txt
									//'filename'    => 'test.sql',    // File name - NEEDED ONLY WITH ZIP FILES
									'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
									'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
									'newline'     => "\n"               // Newline character used in backup file
									);
					$backup =& $this->dbutil->backup($prefs);
					/***********************************************************************************
					 * Back up System For Windows  *
					 *******************************/
					
					//Load the file helper and write the file to your server 
					$path = "D:\\dokani_backup\\".$bd_date; // For Windows
					
				    if(!is_dir($path)) //create the folder if it's not already exists
				    {
				      mkdir($path,0700,TRUE);
				    } 
					$this->load->helper('file');
					write_file($path.'\\dokani.sql', $backup); // For Windows
					
					/*********** End Of Windows Backup **************************************************/
					
					
					/****************************
					 * Back up System For Linux *
					 ****************************/
					/* Load the file helper and write the file to your server */
					//chmod("/opt/lampp/htdocs/backup", 0700);
					/*
					$path = "/opt/lampp/htdocs/cashCarry/dataBase/".$bd_date; // For Linux
				    if(!is_dir($path)) //create the folder if it's not already exists
				    {
				      mkdir($path,0700,TRUE);
				    } 
					$this->load->helper('file');
					write_file($path.'/cash_carry.sql', $backup); // For Linux
					
					$prev_month = date("m",strtotime(date("Y-m-d", strtotime($bd_date)) . " -1 month"));
					$prev_year = date("Y",strtotime(date("Y-m-d", strtotime($bd_date)) . " -1 month"));
					$num_of_days = cal_days_in_month(CAL_GREGORIAN, $prev_month, $prev_year).'</br>';
					
					for($all_date = 1; $all_date < $num_of_days; $all_date++)
					{
						$temp_date = date("Y-m-d",strtotime($prev_year.'-'.$prev_month.'-'.$all_date));
						if (is_dir('/opt/lampp/htdocs/cashCarry/dataBase/'.$temp_date)) {
							unlink('/opt/lampp/htdocs/cashCarry/dataBase/'.$temp_date.'/cash_carry.sql');
							rmdir('/opt/lampp/htdocs/cashCarry/dataBase/'.$temp_date);
						}
					}
					/*********** End Of Windows Backup **************************************************/

					return true;
				}
				return false;
			 }
			 /*create investor*/
			 function create_investor()
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
		/**********************************
		 * All / Specific User Information
		 * 19-01-2014
		 * Arafat Mamun
		***********************************/
		function userInformation()
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
		function userInformation_1()
		{
			//$specific=$this -> uri -> segment(3);
			$this -> db -> order_by('username',"asc");
			$this -> db -> select('users.username,users.user_address,users.email,
								   users.user_type,users.id,user_full_name,created,
								   shop_name,shop_address');
			$this -> db -> from('users,shop_setup');
			$this -> db -> where('users.shop_id = shop_setup.shop_id');
			$this -> db -> where('users.user_type != "superadmin"');
			$this -> db -> where('users.user_type != "admin"');
			//if($specific) $this -> db -> where('users.id', $specific);
			
			return $this -> db -> get();
		}
		/****************************************
		 * All / Specific User Salary Information
		 * 19-01-2014
		 * Arafat Mamun
		******************************************/
		function userSalaryInformation($specific, $userId, $date, $startDate, $endDate)
		{
			/* For automation salary (half done)
			$this -> db -> order_by('username',"asc");
			$this -> db -> select('salary_id, salary_amount, extra_payment,reduced_amount, salary_status');
			$this -> db -> from('users,employee_salary');
			$this -> db -> where('users.id = employee_salary.user_id');
			$this -> db -> where('users.user_type != "superadmin"');
			$this -> db -> where('users.user_type != "admin"');
			if($specific) $this -> db -> where('users.id', $userId);
			if(!$specific) $this -> db -> where('salary_status', 1);
			return $this -> db -> get();
			*/
			$this -> db -> order_by('salary_log_id',"asc");
			$this -> db -> select('user_full_name,users.id, username, salary_log_id, salary_amount, extra_payment,
								   reduced_amount,salary_month, salary_year,salary_doc, mode, salary_creator');
			$this -> db -> from('users,employee_salary_log');
			$this -> db -> where('users.id = employee_salary_log.user_id');
			$this -> db -> where('users.user_type != "superadmin"');
			$this -> db -> where('users.user_type != "admin"');
			if($specific) $this -> db -> where('users.id', $userId);
			$this -> db -> where('salary_status', 1);
			return $this -> db -> get();
		}
		
		/***********************
		* Employee Salary Setup
		* 19-01-2014
		* Arafat Mamun
		************************/
		function employee_salary_setup($selectedUserId, $salaryAmount, $extraPayment,
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
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
