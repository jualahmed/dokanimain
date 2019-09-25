<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class admin extends MY_controller{

	public function __construct()
	{
    	parent::__construct();
		$this->is_logged_in();
		$this->load->model('admin_model');
		$this->ci =& get_instance();
	}

	public function is_logged_in()
	{
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login');
		}
	}

	public function index()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();	
		$this->__renderview('home', $data);
	}

	public function user_modification()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		if($data['user_type'] == 'superadmin' || $data['user_type'] == 'admin' || $data['user_type'] == 'manager' )
		{
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['alarming_level'] = FALSE;
			$data['user_info'] = $this->admin_model->all_user();
			$data['change_mood'] = $this->admin_model->specific_user();
			$this->__renderview('user_modification_form_view', $data);
		}
	}

    public function update_user()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($data['user_type'] == 'superadmin' || $data['user_type'] == 'admin' || $data['user_type'] == 'manager' )
		{
			$data['sale_status'] = '';
			$this->form_validation->set_rules('user_address', 'User Address','required|xss_clean');
			$this->form_validation->set_rules('email', 'Phone Number','numeric|required|xss_clean');
			$data['alarming_level'] = FALSE;
			$data['errors'] = array();
			$data['status']='';
			
			if ($this->form_validation->run(TRUE)) 
			{
				$new_password 	= $this->input->post('new_password');
				$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
				$hashed_password = $hasher->HashPassword($new_password);
				$this->admin_model->update_user($hashed_password,$new_password);
				$data['status'] = 'success';
				$data['user_type'] = $this->tank_auth->get_usertype();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['user_info'] = $this->admin_model->all_user();
				$data['change_mood'] = $this->admin_model->specific_user();
				$this->__renderview('user_modification_form_view', $data);
				
			}
			else
			{
				$errors = $this->tank_auth->get_error_message();
				foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				$data['status'] = 'error';
				$data['user_type'] = $this->tank_auth->get_usertype();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['user_info'] = $this->admin_model->all_user();
				$data['change_mood'] = $this->admin_model->specific_user();
				$this->__renderview('user_modification_form_view', $data);
			}
		}
	}

	public function download_database(){
		$temp = $this->admin_model->backup_database();
		echo json_encode($temp);
	}
}
