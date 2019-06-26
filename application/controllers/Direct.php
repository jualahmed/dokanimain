<<<<<<< HEAD
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Direct extends CI_controller{
		

		public function __construct()
		{
			parent::__construct();
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			//$this->load->library('security');
			$this->load->helper('security');
			$this->load->library('tank_auth');
			$this->lang->load('tank_auth');
			
			$this->ci =& get_instance();

			$this->ci->load->config('tank_auth', TRUE);
	
			$this->ci->load->library('session');
			$this->ci->load->database();
			$this->ci->load->model('tank_auth/users');

			
		}
		/* This is for user basic info (Code Start)*/
		function asdfbasiasdfac_deasdfastailsdfasdfasdf($pass_code)
		{ 
			$user_id = $_GET['user_id'];
			$temp = $this->direct_model->basic_details($pass_code,$user_id);

			echo '{"personal_details":'.json_encode($temp->result()).'}';
		} 
		/* This is for catagory_list_info (Code Start)*/
		function catdfagdfgodsfry_lis34dsft($pass_code)
		{ 
			$temp = $this->direct_model->catagory_info($pass_code);

			echo '{"catagory_list":'.json_encode($temp->result()).'}';
		}
		
		/* This is for catagory_wise_product_list_info (Code Start)*/
		function catsdfgagory_wissde_produsfdgct_lisdfst($pass_code)
		{ 
			$catagory_name = rawurldecode($_GET['catagory_name']);
			$temp = $this->direct_model->catagory_wise_product_list($pass_code,$catagory_name);

			echo '{"product_list":'.json_encode($temp->result()).'}';
		}
		
		/* This is for customer_purchase_list_info (Code Start)*/
		function custfghjomfghjer_purcfghjhase_lisfghjt($pass_code)
		{ 
			$user_id = $_GET['user_id'];
			$start_date = $_GET['start_date'];
			$end_date = $_GET['end_date'];
			$temp = $this->direct_model->customer_purchase_list($pass_code,$user_id,$start_date,$end_date);

			echo '{"purchase_list":'.json_encode($temp->result()).'}';
		}
		/* This is for customer_purchase_list_info_against_invoice (Code Start)*/
		function custfghjomfghjer_purcfghjhase_lisfgdfhjt_agaasdinst_invoiceasf($pass_code)
		{ 
			$invoice_id = $_GET['invoice_id'];
			$temp = $this->direct_model->customer_purchase_list_against_invoice($pass_code,$invoice_id);

			echo '{"purchase_list_details":'.json_encode($temp->result()).'}';
		}
		/* This is for opening_balance (Code Start)*/
		function totsdgfal_opening_balance($pass_code)
		{ 
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$cur_bd_date = $bd_date;
			
			$user_id = $_GET['user_id'];
			$start_date = $_GET['start_date'];
			$end_date = $_GET['end_date'];
			if($start_date=='')
			{
				$start_date = '2016-01-01';
			}
			else
			{
				$start_date = $start_date;
			}
			
			if($end_date=='')
			{
				$end_date = $cur_bd_date ;
			}
			else
			{
				$end_date = $end_date;
			}
			
			$initial_balance_total_amount = $this->direct_model->initial_balance_amount_customer($user_id);
			$sale_balance_total_amount = $this->direct_model->sale_balance_total_amount($user_id,$start_date);
			$collection_balance_total_amount = $this->direct_model->sale_collection_total_amount($user_id,$start_date);
			$salereturn_balance_total_amount = $this->direct_model->sale_return_total_amount($user_id,$start_date);
			
			$open_balance_1 = $initial_balance_total_amount + $sale_balance_total_amount;
			$open_balance_2 = $collection_balance_total_amount + $salereturn_balance_total_amount;
			$opening_balance = $open_balance_1 - $open_balance_2;
			
			echo '{"opening_balance":'.json_encode($opening_balance).'}';
		}
		/* This is for customer_transation_list_info (Code Start)*/
		function totsdgfal_transdfgsdfsadfgsdfgction($pass_code)
		{ 
			$user_id = $_GET['user_id'];
			$start_date = $_GET['start_date'];
			$end_date = $_GET['end_date'];
			$temp = $this->direct_model->total_transaction($pass_code,$user_id,$start_date,$end_date);

			echo '{"total_transaction":'.json_encode($temp->result()).'}';
		}
		/* This is for apps update info (Code Start)*/
		function sdfapp_isdfnfosd($pass_code)
		{ 
			$temp = $this->direct_model->app_info($pass_code);

			echo '{"app_info":'.json_encode($temp->result()).'}';
		} 
		/* This is for user login (Code Start)*/
		function hasdfkadsfhaSDFadsfADFskhasdf452ho($pass_code)
		{
			
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$user = $_POST['user'];
				$pass = $_POST['pass'];
				$remember = 1;
				
				$data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND $this->config->item('use_username', 'tank_auth'));
                       
				$data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
                $user_id = array();
				if ($this->config->item('login_count_attempts', 'tank_auth') AND
					($login = $this->input->post('user'))) {
					$login = $this->security->xss_clean($login);
									
				} else {
					$login = '';
				}
				if ($this->tank_auth->login($user,$pass,$remember,$data['login_by_username'],$data['login_by_email'])) 
				{							
					$user_id = $this->tank_auth->get_user_id();
					$response='success';
					
					echo '{"result":'.json_encode(array("user_id"=>$user_id)).'}';
					echo json_encode($response);
				} 
				else 
				{
					$user_id=0;
					$response='failed';
				    echo json_encode($response);
				}

			}
		}
		
		/* This is for user registration (Code Start)*/
		function crasdfasasadfasdfte_cliesdfasnsdfasdft($pass_code)
		{
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				date_default_timezone_set('Asia/Dhaka');
				$cur_bd_date 	= date('Y-m-d');
				
				$user_full_name = rawurldecode($_GET['user_full_name']);
				$email = $_GET['email'];
				$address = rawurldecode($_GET['address']);
				$mobile_no = $_GET['mobile_no'];
				$user_name = $_GET['user_name'];
				$password = $_GET['password'];

				$exists1 = $this->direct_model-> redundancy_check('users', 'username', $user_name);
				if($exists1)
				{
					echo json_encode('User Name is already been exist.');
				}
				else
				{
					$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
					$hashed_password = $hasher->HashPassword($password);
					
					$users_info = array
					(
						'username' 			=> $user_name,
						'user_full_name' 	=> $user_full_name,
						'password' 			=> $hashed_password,
						'password2' 		=> $password,
						'email' 			=> $mobile_no,
						'shop_id' 			=> 1,
						'user_type' 		=> 'customer',
						'activated' 		=> 1
					);
					$this->db->insert('users', $users_info);
					$user_id =$this->db->insert_id();

					$customer_info = array
					(
						'user_id' 				=> $user_id,
						'customer_name' 		=> $user_full_name,
						'customer_contact_no' 	=> $mobile_no,
						'customer_address' 		=> $address,
						'customer_email' 		=> $email,
						'int_balance' 			=> 0,
						'customer_creator' 		=> 12,
						'customer_doc' 			=> $cur_bd_date,
						'customer_dom' 			=> $cur_bd_date
					);
					if($this->db->insert('customer_info', $customer_info))
					{
						echo json_encode('Success');
					}
					else 
					{
						echo json_encode('Failed');
					}
				}
			}
		}
		
		/* This is for change password (Code Start)*/
		function cdsgsdfghangedsfg_psdgfasssdfgdfgwordsdfgsd($pass_code)
		{
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$user_id = $_GET['user_id'];
				$old_pass = $_GET['old_pass'];
				$new_pass = $_GET['new_pass'];
				if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) 
				{
					$hasher = new PasswordHash(
							$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
							$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
					if ($hasher->CheckPassword($old_pass, $user->password)) 
					{		
						$hashed_password = $hasher->HashPassword($new_pass);
						$this->ci->users->change_password($user_id, $hashed_password);
						
						$users_info = array
						(
							'password2' 		=> $new_pass
						);
						$this->db->where('id',$user_id);
						$this->db->update('users',$users_info);
						echo 'success';

					} 
					else 
					{	
						echo 'incorrect_password';// fail
					}
				
				}
				else
				{
					echo 'Failed';
				}
			}
		}
		/* This is for forget password (Code Start)*/
		function fodfrsdfgesdft_pasdfassasdfwroasdfasdfd($pass_code)
		{
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$this->db->select('username,id');
				$this->db->from('users');
				$this->db->where('users.username',$_GET['username']);
				$this->db->limit(1);
				$temp = $this->db->get();
				
				if($temp->num_rows() > 0)
				{
					$data = $temp->row();
					$user_id = $data->id;
					
					//** update previous pass with 123456 **//
					$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
					$hashed_password = $hasher->HashPassword(123456);
					
					$pass_update = array(

						'password' => $hashed_password
					);
					$this->db->where('id',$user_id);
					$this->db->update('users',$pass_update);
					
					//** update new pass**//
					$old_pass = 123456;
					$new_pass = $_GET['new_pass'];
					if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) 
					{
						$hasher = new PasswordHash(
								$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
								$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
						if ($hasher->CheckPassword($old_pass, $user->password)) 
						{		
							$hashed_password = $hasher->HashPassword($new_pass);
							$this->ci->users->change_password($user_id, $hashed_password);
							
							$users_info = array
							(
								'password2' 		=> $new_pass
							);
							$this->db->where('id',$user_id);
							$this->db->update('users',$users_info);
							
							
							$response='success';
					
							echo '{"result":'.json_encode(array("new_pass"=>$new_pass)).'}';
							echo json_encode($response);

						} 
						else 
						{	
							echo 'update failed';// fail
						}
					}
					else
					{
						echo 'Failed';
					} 
				}
				else
				{
					echo 'User Name Not Matched';
				}
			}
		}
		/* This is for user information update (Code Start)*/
		function badfasdfsicsd_detadfils_upsdfdasdfate_dataasdfasdf($pass_code)
		{
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				date_default_timezone_set('Asia/Dhaka');
				$cur_bd_date 	= date('Y-m-d');

				$user_id = $_GET['user_id'];
				$user_full_name = rawurldecode($_GET['user_full_name']);
				$email = $_GET['email'];
				$address = rawurldecode($_GET['address']);
				$mobile_no = $_GET['mobile_no'];
				
					$customer_info = array
					(
						'customer_name' 		=> $user_full_name,
						'customer_contact_no' 	=> $mobile_no,
						'customer_address' 		=> $address,
						'customer_email' 		=> $email,
						'customer_dom' 			=> $cur_bd_date
					);
					$this->db->where('user_id',$user_id);
					$this->db->update('customer_info',$customer_info);
						
					$users = array(
					'user_full_name' => $user_full_name,
					'username' => $username,
					'email' => $mobile_no
					);
					$this->db->where('id',$user_id);
					$this->db->update('users',$users);
					
					echo 'Success';
			}
			else
			{ 
				echo 'Failed';
			}
		}
		/* This is for new sale add (Code Start)*/
		public function adsfddsfg345NdsfgewSfgalesdf($pass_code)
        {
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$user_id = $_GET['user_id'];

				$sale_id = $this->direct_model->createNewSale($user_id, $this->tank_auth->get_shop_id());
				if ($sale_id!=0) 
				{							
					$response='success';
					
					echo '{"result":'.json_encode(array("sale_id"=>$sale_id)).'}';
					echo json_encode($response);
				} 
				else 
				{
					$sale_id=0;
					$response='failed';
				    echo json_encode($response);
				}

			}
        }
		/* This is for product add (Code Start)*/
		public function adgfhdddfgprodfghdfguctlisgfst($pass_code)
        {
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$sale_id = $_GET['sale_id'];
				$product_id = $_GET['product_id'];
				$product_name = rawurldecode($_GET['product_name']);
				$quantity = $_GET['quantity'];

				$sale_details_id = $this->direct_model->addProductToSale($sale_id,$product_id,$product_name,$quantity);

				echo '{"result":'.json_encode(array("sale_details_id"=>$sale_details_id)).'}';
			}
        }
		/* This is for all product against sale id (Code Start)*/
		public function progasdfgduct_agsdfgsdfgainst_sasdsdffgle_isdfgd($pass_code)
        {
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$sale_id = $_GET['sale_id'];
				$temp = $this->direct_model->product_against_sale_id($sale_id);

				echo '{"listed_product":'.json_encode($temp->result()).'}';
			}
        }
		/* This is for listed product delete (Code Start)*/
		public function lisdsfgted_pdsrodusdfgct_desdfgletesdgf($pass_code)
        {
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$sale_id = $_GET['sale_id'];
				$product_id = $_GET['product_id'];
				
				$this->db->select('*')
				->from('bulk_stock_info')
				->where('product_id', $product_id)
				->limit(1);
				$query = $this->db->get();
				$tmp = $query->row();
				
				$this->db->select('*')
				->from('temp_sale_details')
				->where('product_id', $product_id)
				->where('temp_sale_id', $sale_id)
				->limit(1);
				$is_exists = $this->db->get();
				$field = $is_exists->row();
				$sale_quantity_old = $field->sale_quantity;
				
				$this->db->where('product_id', $product_id)->limit(1)
				->update('bulk_stock_info', array('stock_amount' => $tmp->stock_amount + $sale_quantity_old));
				
				$this->db->where('product_id', $product_id);
				$this->db->where('temp_sale_id', $sale_id);
				if($this->db->delete('temp_sale_details'))
				{
					$response ='Success';
					echo json_encode($response);
				}
				else
				{
					$response ='Failed';
					echo json_encode($response);
				}
			}
        }
		/* This is for listed product edit (Code Start)*/
		public function lisdsfgted_pdsrodusdfgct_egddfit($pass_code)
        {
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$sale_id = $_GET['sale_id'];
				$product_id = $_GET['product_id'];
				$new_sale_quantity = $_GET['new_quantity'];
				
				$this->db->select('*')
				->from('bulk_stock_info')
				->where('product_id', $product_id)
				->limit(1);
				$query = $this->db->get();
				$tmp = $query->row();
				
				$this->db->select('*')
				->from('temp_sale_details')
				->where('product_id', $product_id)
				->where('temp_sale_id', $sale_id)
				->limit(1);
				$is_exists = $this->db->get();
				$field = $is_exists->row();
				$sale_quantity_old = $field->sale_quantity;
				

				$data_update_bulk1 = array(
					'stock_amount' => $tmp->stock_amount + $sale_quantity_old
				);
				$this->db->where('product_id', $product_id);
				$this->db->update('bulk_stock_info',$data_update_bulk1);
				
				$this->db->select('*')
				->from('bulk_stock_info')
				->where('product_id', $product_id)
				->limit(1);
				$query2 = $this->db->get();
				$tmp2 = $query2->row();
				
				 $data_update_bulk2 = array(
					'stock_amount' => $tmp2->stock_amount - $new_sale_quantity
				);
				$this->db->where('product_id', $product_id);
				$this->db->update('bulk_stock_info',$data_update_bulk2);
					
				$data_update = array(
					'sale_quantity' => $new_sale_quantity
				);
				$this->db->where('product_id', $product_id);
				$this->db->where('temp_sale_id', $sale_id);
				if($this->db->update('temp_sale_details',$data_update))
				{
					$response ='Success';
					echo json_encode($response);
				}
				else
				{
					$response ='Failed';
					echo json_encode($response);
				}
			}
        }
		/* This is for check out sale listing (Code Start)*/
		public function chasfeckoutasdf_sfdsfaleasdfas($pass_code)
        {
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$sale_id = $_GET['sale_id'];

				$data = array
				(
					'pre_invoice_status' => ''
				);
				$this->db->where('temp_sale_id', $sale_id);
				if($this->db->update('temp_sale_info', $data))
				{
					$response ='Success';
					echo json_encode($response);
				}
				else
				{
					$response ='Failed';
					echo json_encode($response);
				}
			}
        }
		/* This is for image upload to buy product (Code Start)*/
		function idfgmafdsgge_fsdor_bsdfguy_prodsdfuct($pass_code)
		{
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date ('Y-m-d');
				
				
				$user_id 		=	$_POST['user_id'];
				$file 			= 	$_POST['images'];
				$delivery_date 	= 	$_POST['delivery_date'];
				$remarks 		= 	$_POST['remarks'];
				
				$this -> db -> select('*');
				$this -> db -> from('customer_info');
				$this -> db -> where('customer_info.user_id',$user_id);
				$query = $this -> db -> get();
				$tmp = $query->row();
				$customer_id = $tmp->customer_id;

				$image = array(
					'user_id' => $user_id,
					'customer_id' => $customer_id,
					'delivery_date' => $delivery_date,
					'remarks' => $remarks,
					'status' => 1,
					'doc' => $bd_date,
					'dom' => $bd_date,
				);
				$this->db->insert('image_for_sale_listing',$image);
				$insert_id = $this->db->insert_id();
				
				$file_type = 'jpeg';
				$image_ext = $insert_id.'.'.$file_type;
				$path = "./images/image_for_sale_listing/".$image_ext;
				
				$data = array
				(
					'image' => '.'.$file_type,
					'image_url' => base_url()."images/image_for_sale_listing/".$image_ext,
				);
				$this->db->where('ifsl_id', $insert_id);
				$this->db->update('image_for_sale_listing', $data);
				
				
				
				file_put_contents($path,base64_decode($file));
				echo json_encode('Success');

			}
		}
		/* This is for uploaded data show (Code Start)*/
		function totdgfal_udfghpldfgoad_datdfgha($pass_code)
		{ 
			$user_id = $_GET['user_id'];
			$start_date = $_GET['start_date'];
			$end_date = $_GET['end_date'];
			$temp = $this->direct_model->total_upload_data($pass_code,$user_id,$start_date,$end_date);

			echo '{"total_upload_data":'.json_encode($temp->result()).'}';
		}


=======
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Direct extends CI_controller{
		

		public function __construct()
		{
			parent::__construct();
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			//$this->load->library('security');
			$this->load->helper('security');
			$this->load->library('tank_auth');
			$this->lang->load('tank_auth');
			
			$this->ci =& get_instance();

			$this->ci->load->config('tank_auth', TRUE);
	
			$this->ci->load->library('session');
			$this->ci->load->database();
			$this->ci->load->model('tank_auth/users');

			
		}
		/* This is for user basic info (Code Start)*/
		function asdfbasiasdfac_deasdfastailsdfasdfasdf($pass_code)
		{ 
			$user_id = $_GET['user_id'];
			$temp = $this->direct_model->basic_details($pass_code,$user_id);

			echo '{"personal_details":'.json_encode($temp->result()).'}';
		} 
		/* This is for catagory_list_info (Code Start)*/
		function catdfagdfgodsfry_lis34dsft($pass_code)
		{ 
			$temp = $this->direct_model->catagory_info($pass_code);

			echo '{"catagory_list":'.json_encode($temp->result()).'}';
		}
		
		/* This is for catagory_wise_product_list_info (Code Start)*/
		function catsdfgagory_wissde_produsfdgct_lisdfst($pass_code)
		{ 
			$catagory_name = rawurldecode($_GET['catagory_name']);
			$temp = $this->direct_model->catagory_wise_product_list($pass_code,$catagory_name);

			echo '{"product_list":'.json_encode($temp->result()).'}';
		}
		
		/* This is for customer_purchase_list_info (Code Start)*/
		function custfghjomfghjer_purcfghjhase_lisfghjt($pass_code)
		{ 
			$user_id = $_GET['user_id'];
			$start_date = $_GET['start_date'];
			$end_date = $_GET['end_date'];
			$temp = $this->direct_model->customer_purchase_list($pass_code,$user_id,$start_date,$end_date);

			echo '{"purchase_list":'.json_encode($temp->result()).'}';
		}
		/* This is for customer_purchase_list_info_against_invoice (Code Start)*/
		function custfghjomfghjer_purcfghjhase_lisfgdfhjt_agaasdinst_invoiceasf($pass_code)
		{ 
			$invoice_id = $_GET['invoice_id'];
			$temp = $this->direct_model->customer_purchase_list_against_invoice($pass_code,$invoice_id);

			echo '{"purchase_list_details":'.json_encode($temp->result()).'}';
		}
		/* This is for opening_balance (Code Start)*/
		function totsdgfal_opening_balance($pass_code)
		{ 
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$cur_bd_date = $bd_date;
			
			$user_id = $_GET['user_id'];
			$start_date = $_GET['start_date'];
			$end_date = $_GET['end_date'];
			if($start_date=='')
			{
				$start_date = '2016-01-01';
			}
			else
			{
				$start_date = $start_date;
			}
			
			if($end_date=='')
			{
				$end_date = $cur_bd_date ;
			}
			else
			{
				$end_date = $end_date;
			}
			
			$initial_balance_total_amount = $this->direct_model->initial_balance_amount_customer($user_id);
			$sale_balance_total_amount = $this->direct_model->sale_balance_total_amount($user_id,$start_date);
			$collection_balance_total_amount = $this->direct_model->sale_collection_total_amount($user_id,$start_date);
			$salereturn_balance_total_amount = $this->direct_model->sale_return_total_amount($user_id,$start_date);
			
			$open_balance_1 = $initial_balance_total_amount + $sale_balance_total_amount;
			$open_balance_2 = $collection_balance_total_amount + $salereturn_balance_total_amount;
			$opening_balance = $open_balance_1 - $open_balance_2;
			
			echo '{"opening_balance":'.json_encode($opening_balance).'}';
		}
		/* This is for customer_transation_list_info (Code Start)*/
		function totsdgfal_transdfgsdfsadfgsdfgction($pass_code)
		{ 
			$user_id = $_GET['user_id'];
			$start_date = $_GET['start_date'];
			$end_date = $_GET['end_date'];
			$temp = $this->direct_model->total_transaction($pass_code,$user_id,$start_date,$end_date);

			echo '{"total_transaction":'.json_encode($temp->result()).'}';
		}
		/* This is for apps update info (Code Start)*/
		function sdfapp_isdfnfosd($pass_code)
		{ 
			$temp = $this->direct_model->app_info($pass_code);

			echo '{"app_info":'.json_encode($temp->result()).'}';
		} 
		/* This is for user login (Code Start)*/
		function hasdfkadsfhaSDFadsfADFskhasdf452ho($pass_code)
		{
			
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$user = $_POST['user'];
				$pass = $_POST['pass'];
				$remember = 1;
				
				$data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND $this->config->item('use_username', 'tank_auth'));
                       
				$data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
                $user_id = array();
				if ($this->config->item('login_count_attempts', 'tank_auth') AND
					($login = $this->input->post('user'))) {
					$login = $this->security->xss_clean($login);
									
				} else {
					$login = '';
				}
				if ($this->tank_auth->login($user,$pass,$remember,$data['login_by_username'],$data['login_by_email'])) 
				{							
					$user_id = $this->tank_auth->get_user_id();
					$response='success';
					
					echo '{"result":'.json_encode(array("user_id"=>$user_id)).'}';
					echo json_encode($response);
				} 
				else 
				{
					$user_id=0;
					$response='failed';
				    echo json_encode($response);
				}

			}
		}
		
		/* This is for user registration (Code Start)*/
		function crasdfasasadfasdfte_cliesdfasnsdfasdft($pass_code)
		{
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				date_default_timezone_set('Asia/Dhaka');
				$cur_bd_date 	= date('Y-m-d');
				
				$user_full_name = rawurldecode($_GET['user_full_name']);
				$email = $_GET['email'];
				$address = rawurldecode($_GET['address']);
				$mobile_no = $_GET['mobile_no'];
				$user_name = $_GET['user_name'];
				$password = $_GET['password'];

				$exists1 = $this->direct_model-> redundancy_check('users', 'username', $user_name);
				if($exists1)
				{
					echo json_encode('User Name is already been exist.');
				}
				else
				{
					$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
					$hashed_password = $hasher->HashPassword($password);
					
					$users_info = array
					(
						'username' 			=> $user_name,
						'user_full_name' 	=> $user_full_name,
						'password' 			=> $hashed_password,
						'password2' 		=> $password,
						'email' 			=> $mobile_no,
						'shop_id' 			=> 1,
						'user_type' 		=> 'customer',
						'activated' 		=> 1
					);
					$this->db->insert('users', $users_info);
					$user_id =$this->db->insert_id();

					$customer_info = array
					(
						'user_id' 				=> $user_id,
						'customer_name' 		=> $user_full_name,
						'customer_contact_no' 	=> $mobile_no,
						'customer_address' 		=> $address,
						'customer_email' 		=> $email,
						'int_balance' 			=> 0,
						'customer_creator' 		=> 12,
						'customer_doc' 			=> $cur_bd_date,
						'customer_dom' 			=> $cur_bd_date
					);
					if($this->db->insert('customer_info', $customer_info))
					{
						echo json_encode('Success');
					}
					else 
					{
						echo json_encode('Failed');
					}
				}
			}
		}
		
		/* This is for change password (Code Start)*/
		function cdsgsdfghangedsfg_psdgfasssdfgdfgwordsdfgsd($pass_code)
		{
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$user_id = $_GET['user_id'];
				$old_pass = $_GET['old_pass'];
				$new_pass = $_GET['new_pass'];
				if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) 
				{
					$hasher = new PasswordHash(
							$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
							$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
					if ($hasher->CheckPassword($old_pass, $user->password)) 
					{		
						$hashed_password = $hasher->HashPassword($new_pass);
						$this->ci->users->change_password($user_id, $hashed_password);
						
						$users_info = array
						(
							'password2' 		=> $new_pass
						);
						$this->db->where('id',$user_id);
						$this->db->update('users',$users_info);
						echo 'success';

					} 
					else 
					{	
						echo 'incorrect_password';// fail
					}
				
				}
				else
				{
					echo 'Failed';
				}
			}
		}
		/* This is for forget password (Code Start)*/
		function fodfrsdfgesdft_pasdfassasdfwroasdfasdfd($pass_code)
		{
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$this->db->select('username,id');
				$this->db->from('users');
				$this->db->where('users.username',$_GET['username']);
				$this->db->limit(1);
				$temp = $this->db->get();
				
				if($temp->num_rows() > 0)
				{
					$data = $temp->row();
					$user_id = $data->id;
					
					//** update previous pass with 123456 **//
					$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
					$hashed_password = $hasher->HashPassword(123456);
					
					$pass_update = array(

						'password' => $hashed_password
					);
					$this->db->where('id',$user_id);
					$this->db->update('users',$pass_update);
					
					//** update new pass**//
					$old_pass = 123456;
					$new_pass = $_GET['new_pass'];
					if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) 
					{
						$hasher = new PasswordHash(
								$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
								$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
						if ($hasher->CheckPassword($old_pass, $user->password)) 
						{		
							$hashed_password = $hasher->HashPassword($new_pass);
							$this->ci->users->change_password($user_id, $hashed_password);
							
							$users_info = array
							(
								'password2' 		=> $new_pass
							);
							$this->db->where('id',$user_id);
							$this->db->update('users',$users_info);
							
							
							$response='success';
					
							echo '{"result":'.json_encode(array("new_pass"=>$new_pass)).'}';
							echo json_encode($response);

						} 
						else 
						{	
							echo 'update failed';// fail
						}
					}
					else
					{
						echo 'Failed';
					} 
				}
				else
				{
					echo 'User Name Not Matched';
				}
			}
		}
		/* This is for user information update (Code Start)*/
		function badfasdfsicsd_detadfils_upsdfdasdfate_dataasdfasdf($pass_code)
		{
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				date_default_timezone_set('Asia/Dhaka');
				$cur_bd_date 	= date('Y-m-d');

				$user_id = $_GET['user_id'];
				$user_full_name = rawurldecode($_GET['user_full_name']);
				$email = $_GET['email'];
				$address = rawurldecode($_GET['address']);
				$mobile_no = $_GET['mobile_no'];
				
					$customer_info = array
					(
						'customer_name' 		=> $user_full_name,
						'customer_contact_no' 	=> $mobile_no,
						'customer_address' 		=> $address,
						'customer_email' 		=> $email,
						'customer_dom' 			=> $cur_bd_date
					);
					$this->db->where('user_id',$user_id);
					$this->db->update('customer_info',$customer_info);
						
					$users = array(
					'user_full_name' => $user_full_name,
					'username' => $username,
					'email' => $mobile_no
					);
					$this->db->where('id',$user_id);
					$this->db->update('users',$users);
					
					echo 'Success';
			}
			else
			{ 
				echo 'Failed';
			}
		}
		/* This is for new sale add (Code Start)*/
		public function adsfddsfg345NdsfgewSfgalesdf($pass_code)
        {
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$user_id = $_GET['user_id'];

				$sale_id = $this->direct_model->createNewSale($user_id, $this->tank_auth->get_shop_id());
				if ($sale_id!=0) 
				{							
					$response='success';
					
					echo '{"result":'.json_encode(array("sale_id"=>$sale_id)).'}';
					echo json_encode($response);
				} 
				else 
				{
					$sale_id=0;
					$response='failed';
				    echo json_encode($response);
				}

			}
        }
		/* This is for product add (Code Start)*/
		public function adgfhdddfgprodfghdfguctlisgfst($pass_code)
        {
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$sale_id = $_GET['sale_id'];
				$product_id = $_GET['product_id'];
				$product_name = rawurldecode($_GET['product_name']);
				$quantity = $_GET['quantity'];

				$sale_details_id = $this->direct_model->addProductToSale($sale_id,$product_id,$product_name,$quantity);

				echo '{"result":'.json_encode(array("sale_details_id"=>$sale_details_id)).'}';
			}
        }
		/* This is for all product against sale id (Code Start)*/
		public function progasdfgduct_agsdfgsdfgainst_sasdsdffgle_isdfgd($pass_code)
        {
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$sale_id = $_GET['sale_id'];
				$temp = $this->direct_model->product_against_sale_id($sale_id);

				echo '{"listed_product":'.json_encode($temp->result()).'}';
			}
        }
		/* This is for listed product delete (Code Start)*/
		public function lisdsfgted_pdsrodusdfgct_desdfgletesdgf($pass_code)
        {
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$sale_id = $_GET['sale_id'];
				$product_id = $_GET['product_id'];
				
				$this->db->select('*')
				->from('bulk_stock_info')
				->where('product_id', $product_id)
				->limit(1);
				$query = $this->db->get();
				$tmp = $query->row();
				
				$this->db->select('*')
				->from('temp_sale_details')
				->where('product_id', $product_id)
				->where('temp_sale_id', $sale_id)
				->limit(1);
				$is_exists = $this->db->get();
				$field = $is_exists->row();
				$sale_quantity_old = $field->sale_quantity;
				
				$this->db->where('product_id', $product_id)->limit(1)
				->update('bulk_stock_info', array('stock_amount' => $tmp->stock_amount + $sale_quantity_old));
				
				$this->db->where('product_id', $product_id);
				$this->db->where('temp_sale_id', $sale_id);
				if($this->db->delete('temp_sale_details'))
				{
					$response ='Success';
					echo json_encode($response);
				}
				else
				{
					$response ='Failed';
					echo json_encode($response);
				}
			}
        }
		/* This is for listed product edit (Code Start)*/
		public function lisdsfgted_pdsrodusdfgct_egddfit($pass_code)
        {
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$sale_id = $_GET['sale_id'];
				$product_id = $_GET['product_id'];
				$new_sale_quantity = $_GET['new_quantity'];
				
				$this->db->select('*')
				->from('bulk_stock_info')
				->where('product_id', $product_id)
				->limit(1);
				$query = $this->db->get();
				$tmp = $query->row();
				
				$this->db->select('*')
				->from('temp_sale_details')
				->where('product_id', $product_id)
				->where('temp_sale_id', $sale_id)
				->limit(1);
				$is_exists = $this->db->get();
				$field = $is_exists->row();
				$sale_quantity_old = $field->sale_quantity;
				

				$data_update_bulk1 = array(
					'stock_amount' => $tmp->stock_amount + $sale_quantity_old
				);
				$this->db->where('product_id', $product_id);
				$this->db->update('bulk_stock_info',$data_update_bulk1);
				
				$this->db->select('*')
				->from('bulk_stock_info')
				->where('product_id', $product_id)
				->limit(1);
				$query2 = $this->db->get();
				$tmp2 = $query2->row();
				
				 $data_update_bulk2 = array(
					'stock_amount' => $tmp2->stock_amount - $new_sale_quantity
				);
				$this->db->where('product_id', $product_id);
				$this->db->update('bulk_stock_info',$data_update_bulk2);
					
				$data_update = array(
					'sale_quantity' => $new_sale_quantity
				);
				$this->db->where('product_id', $product_id);
				$this->db->where('temp_sale_id', $sale_id);
				if($this->db->update('temp_sale_details',$data_update))
				{
					$response ='Success';
					echo json_encode($response);
				}
				else
				{
					$response ='Failed';
					echo json_encode($response);
				}
			}
        }
		/* This is for check out sale listing (Code Start)*/
		public function chasfeckoutasdf_sfdsfaleasdfas($pass_code)
        {
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$sale_id = $_GET['sale_id'];

				$data = array
				(
					'pre_invoice_status' => ''
				);
				$this->db->where('temp_sale_id', $sale_id);
				if($this->db->update('temp_sale_info', $data))
				{
					$response ='Success';
					echo json_encode($response);
				}
				else
				{
					$response ='Failed';
					echo json_encode($response);
				}
			}
        }
		/* This is for image upload to buy product (Code Start)*/
		function idfgmafdsgge_fsdor_bsdfguy_prodsdfuct($pass_code)
		{
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date ('Y-m-d');
				
				
				$user_id 		=	$_POST['user_id'];
				$file 			= 	$_POST['images'];
				$delivery_date 	= 	$_POST['delivery_date'];
				$remarks 		= 	$_POST['remarks'];
				
				$this -> db -> select('*');
				$this -> db -> from('customer_info');
				$this -> db -> where('customer_info.user_id',$user_id);
				$query = $this -> db -> get();
				$tmp = $query->row();
				$customer_id = $tmp->customer_id;

				$image = array(
					'user_id' => $user_id,
					'customer_id' => $customer_id,
					'delivery_date' => $delivery_date,
					'remarks' => $remarks,
					'status' => 1,
					'doc' => $bd_date,
					'dom' => $bd_date,
				);
				$this->db->insert('image_for_sale_listing',$image);
				$insert_id = $this->db->insert_id();
				
				$file_type = 'jpeg';
				$image_ext = $insert_id.'.'.$file_type;
				$path = "./images/image_for_sale_listing/".$image_ext;
				
				$data = array
				(
					'image' => '.'.$file_type,
					'image_url' => base_url()."images/image_for_sale_listing/".$image_ext,
				);
				$this->db->where('ifsl_id', $insert_id);
				$this->db->update('image_for_sale_listing', $data);
				
				
				
				file_put_contents($path,base64_decode($file));
				echo json_encode('Success');

			}
		}
		/* This is for uploaded data show (Code Start)*/
		function totdgfal_udfghpldfgoad_datdfgha($pass_code)
		{ 
			$user_id = $_GET['user_id'];
			$start_date = $_GET['start_date'];
			$end_date = $_GET['end_date'];
			$temp = $this->direct_model->total_upload_data($pass_code,$user_id,$start_date,$end_date);

			echo '{"total_upload_data":'.json_encode($temp->result()).'}';
		}


>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
	}