<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	


        class Login extends CI_Controller {

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
				redirect('Auth/login');
			}
		}

		public function index()
		{
			redirect('admin');
		}
		
		/************************************
		* General User Information         **
		*************************************/
		function user_information()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			
			if($this -> access_control_model -> my_access($data['user_type'], 'Login', 'user_information')) {
                            $data['user_type'] = $this->tank_auth->get_usertype();
                            $data['user_name'] = $this->tank_auth->get_username();
                            $data['sale_status'] = '';
                            $data['status'] = '';
                            $data['user_info'] = $this -> login_model -> all_general_user();
                            $data['specific_user'] = $this -> login_model -> specific_user( $this -> uri -> segment(3) );
                            $data['alarming_level'] = FALSE;
                            $data['tricker_content'] = 'tricker_registration_view';
                            $data['main_content'] = 'user_information_view';
                            $this -> load -> view('include/template', $data);
			}
			else redirect('Registration/registration/noaccess');
		}

	}
	
