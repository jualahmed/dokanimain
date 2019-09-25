<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

	class Web extends CI_controller
	{
		public function __construct()
		{
	        parent::__construct();
	
			$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			//$this->load->library('security');
			$this->load->helper('security');
			$this->load->library('tank_auth');
			$this->lang->load('tank_auth');
			
			$this->ci =& get_instance();
			$this->load->library('cart');
			$this->ci->load->config('tank_auth', TRUE);
	
			$this->ci->load->library('session');
			$this->ci->load->database();
			$this->ci->load->model('tank_auth/users');
		}
	
		function index()
		{
			$lang = $this->uri->segment(3);
			if($lang=='' || $lang=='bn' || $lang=='en')
			{
				$data['catagory_info'] 		= $this->web_model->catagory_info();

				$category_id = rawurldecode($this->uri->segment(4));
				$config = array();
				$config["base_url"] = base_url() . "web/index/".$lang.'/'.$category_id.'/';
				$config['total_rows'] = $this -> web_model -> all_search_record_count($category_id);
				$config['per_page'] = 12;
			   // $config['num_links'] = 5;
				$config['uri_segment'] = 5;
				$config['full_tag_open'] = "<ul class='pagination'>";
				$config['full_tag_close'] = '</ul>';
				$config['num_tag_open'] = '<li style="background-color: #2ca8a8;border: 1px solid black;color: #fff;padding: 1px 5px;;margin-left: 0;font-size: 18px;width: 45px;text-align: center;height: 45px;line-height: 43px;font-weight: bold;">';
				$config['num_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active" style="background-color: #152626;border: none;color: #fff;padding: 1px 5px;;margin-left: 0;font-size: 18px;width: 45px;text-align: center;height: 45px;line-height: 43px;font-weight: bold;"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['prev_tag_open'] = '<li style="background-color: #1681a2;padding: 8px 4px;border: 1px solid black;">';
				$config['prev_tag_close'] = '</li>';
				$config['first_tag_open'] = '<li style="background-color: #1681a2;padding: 8px 4px;border: 1px solid black;">';
				$config['first_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li style="background-color: #1681a2;padding: 8px 4px;border: 1px solid black;">';
				$config['last_tag_close'] = '</li>';



				$config['prev_link'] = '<i class="fa fa-long-arrow-left"  style="color: black;"></i>';
				$config['prev_tag_open'] = '<li style="background-color: #dadada;border: none;color: #fff;padding: 0;margin-left: 0;font-size: 18px;width: 45px;text-align: center;height: 45px;line-height: 43px;font-weight: bold;">';
				$config['prev_tag_close'] = '</li>';


				$config['next_link'] = '<i class="fa fa-long-arrow-right"  style="color: black;"></i>';
				$config['next_tag_open'] = '<li style="background-color: #dadada;border: none;color: #fff;padding: 0;margin-left: 0;font-size: 18px;width: 45px;text-align: center;height: 45px;line-height: 43px;font-weight: bold;">';
				$config['next_tag_close'] = '</li>';
				$this -> pagination -> initialize($config);

				$data['result']   = $this-> web_model-> all_search_result($config["per_page"],$category_id);
				$data['links'] = $this->pagination->create_links();
			}
			$this->load->view('Web/home',$data);
		}
		function addcart()
		{
			
			$this->cart->product_name_rules = '[:print:]';
			$product = $this->input->post('rowproname');
			$product_id = $this->input->post('rowid');
			$qty = $this->input->post('qty');
			$price = $this->input->post('rowprice');
			$data = array(
					'id'      => $product_id,
					'qty'     => $qty,
					'price'   => $price,
					'name'    => $product
			);
			$add = $this->cart->insert($data);
			// Return response
			
			echo $add?'ok':'err';
			//redirect('web/index/'.$this->input->post('language_id').'/'.$this->input->post('catagory_id'));
		}
		function updateItemQty()
		{
			$update = 0;
			
			// Get cart item info
			$rowid = $this->input->post('rowid');
			$qty = $this->input->post('qty');
			
			// Update item in the cart
			if(!empty($rowid) && !empty($qty))
			{
				$data = array(
					'rowid' => $rowid,
					'qty'   => $qty
				);
				$update = $this->cart->update($data);
			}
			
			// Return response
			echo $update?'ok':'err';
		}
		function removeItem($rowid){
			$lan = $this->uri->segment(3);
			$cat = $this->uri->segment(4);
			$rowid = $this->uri->segment(5);
			$remove = $this->cart->remove($rowid);

			redirect('web/index/'.$lan.'/'.$cat);
		}
		function userregistration(){
			
			$this->load->view('web/userregistration');
		}
		function check_user_name() 
		{
			$user_name =strtolower(preg_replace('/\+/', '', $this->input->post('user_name')));
			$query=$this -> db -> select('*')
							-> from('users')
							->like('LOWER(username)',$user_name)
							->get();
			if($query -> num_rows() >0) 
			{
			  echo 'Not_Available';
			}
			else{
			  echo 'Available';
			}
		}
		function user_final_registration($pass_code)
		{
			date_default_timezone_set('Asia/Dhaka');
			$cur_bd_date 	= date('Y-m-d');
			
			$user_full_name = $this->input->post('user_full_name');
			$email = $this->input->post('email');
			$address = $this->input->post('address');
			$mobile_no = $this->input->post('mobile_no');
			$user_name = $this->input->post('user_name');
			$password = $this->input->post('password');

			$exists1 = $this->web_model-> redundancy_check('users', 'username', $user_name);
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
					'user_address' 		=> $address,
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
					redirect('web/userregistration/bn/Success');
				}
				else 
				{
					redirect('web/userregistration/bn/Failed');
				}
			}
		}
	}
