<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comission extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$data['user_type'] = $this->tank_auth->get_usertype();
		$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		if(!$this->access_control_model->my_access($data['user_type'], 'account', ''))
		{
			redirect('admin/noaccess');
		}
		$this->load->model('comission_model');
	}

	/* checking login status */
	public function is_logged_in()
	{
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login','refresh');
		}
	}

	public function index()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this->access_control_model->my_access($data['user_type'], 'account', 'bank_entry'))
		{
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['alarming_level'] = FALSE;
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['all'] = $this->comission_model->all();
			$data['vuejscomp'] = 'comission.js';
			$this->__renderview('Setup/comission_entry', $data);
		}
		else redirect('account/account/noaccess');
	}

	public function create()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'com_month',
	        'label' => 'com_month',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'com_amount',
	        'label' => 'com_amount',
	        'rules' => 'required'
	      ) 
	    );
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'com_month' => $this->input->post('com_month'),
	        'com_amount' => $this->input->post('com_amount'),
	      );
	      $id = $this->comission_model->create($data);
	      $output = '';
	      if ($id != -1) {
	        $jsonData['success'] = true;
	      }
	    }else {
	      foreach ($_POST as $key => $value) {
	        $jsonData['errors'][$key] = form_error($key);
	      }
	    }
	    echo json_encode($jsonData);
	}
}

/* End of file Comission.php */
/* Location: ./application/controllers/Comission.php */