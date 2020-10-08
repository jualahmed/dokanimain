<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bankcard extends MY_Controller {

	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id=$this->tank_auth->get_shop_id();
		$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->is_logged_in();
		$this->load->model('bankcard_model');
	}

	public function is_logged_in()
	{
		$this->load->library('tank_auth');
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login','refresh');
		}
	}

	public function bank_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['sale_status'] = '';
		$data['alarming_level'] = FALSE;
		$data['status'] = '';
		$data['user_name'] = $this->tank_auth->get_username();
		$data['all'] = $this->bankcard_model->all();
		$data['vuejscomp'] = 'bankcard.js';
		$this->__renderview('Setup/bank',$data);
	}

	public function create_bank()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'bank_name',
	        'label' => 'bank_name',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'bank_account_no',
	        'label' => 'bank_account_no',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'bank_account_name',
	        'label' => 'bank_account_name',
	        'rules' => 'required'
	      ),
	    );
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'shop_id' => $this->shop_id,
	        'bank_name' => $this->input->post('bank_name'),
	        'bank_account_no' => $this->input->post('bank_account_no'),
	        'bank_account_name' => $this->input->post('bank_account_name'),
	        'bank_status' => 'active',
	        'bank_creator' => $creator,
	      );
	      $id = $this->bankcard_model->create_bank($data);
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

	public function find()
	{
		$bankcard_id=$this->input->post('bankcard_id');
		$data=$this->bankcard_model->find($bankcard_id);
		echo json_encode($data);
	}

	public function update()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'bankcard_name',
	        'label' => 'bankcard_name',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'bankcard_type',
	        'label' => 'bankcard_type',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'bankcard_contact_no',
	        'label' => 'bankcard_contact_no',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'bankcard_mode',
	        'label' => 'bankcard_mode',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'bankcard_email',
	        'label' => 'bankcard_email',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'bankcard_address',
	        'label' => 'bankcard_address',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'int_balance',
	        'label' => 'int_balance',
	        'rules' => 'required'
	      )
	    );
	    $bankcard_id=$this->input->post('bankcard_id');
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'bankcard_name' => $this->input->post('bankcard_name'),
	        'bankcard_type' => $this->input->post('bankcard_type'),
	        'bankcard_contact_no' => $this->input->post('bankcard_contact_no'),
	        'bankcard_mode' => $this->input->post('bankcard_mode'),
	        'bankcard_email' => $this->input->post('bankcard_email'),
	        'bankcard_address' => $this->input->post('bankcard_address'),
	        'int_balance' => $this->input->post('int_balance'),
	        'bankcard_creator' => $creator,
	      );
	      $id = $this->bankcard_model->update($bankcard_id,$data);
	      $output = '';
	      if ($id) {
	        $jsonData['success'] = true;
	      }
	    }else {
	      foreach ($_POST as $key => $value) {
	        $jsonData['errors'][$key] = form_error($key);
	      }
	    }
	    echo json_encode($jsonData);
	}

	public function destroy($id)
	{	
		$result=$this->bankcard_model->destroy($id);
		if($result){
			$this->session->set_flashdata('success', 'Bankcard Delete successfully');
			redirect('bankcard','refresh');
		}
	}

}

/* End of file Bankcard.php */
/* Location: ./application/controllers/Bankcard.php */