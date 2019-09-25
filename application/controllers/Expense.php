<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends MY_Controller {

	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('expense_model');
		$this->load->model('bankcard_model');
		$this->load->model('employee_model');
		$this->shop_id=$this->tank_auth->get_shop_id();
	}

	/* for expense entry*/
    public function index()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$bd_date = date('Y-m-d');
		$data['bd_date'] = $bd_date;
		$data['sale_status'] = '';	
		$data['status'] = '';
		$data['user_name'] = $this->tank_auth->get_username();
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['bank_info'] = $this->bankcard_model->all();
		$data['expense_type'] = $this->expense_model->typeall();
		$data['service_provider_info'] = $this->expense_model->SPall();
		$data['employee_info'] = $this->employee_model->all();
		$data['vuejscomp'] = 'expense.js';
		$this->__renderview('Setup/expense',$data);
	}

	public function create()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'expense_type',
	        'label' => 'expense_type',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'service_provider_id',
	        'label' => 'service_provider_id',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'expense_amount',
	        'label' => 'expense_amount',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'total_paid',
	        'label' => 'total_paid',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'expense_details',
	        'label' => 'expense_details',
	      ),
	      array(
	        'field' => 'payment_mode',
	        'label' => 'payment_mode',
	        'rules' => 'required',
	      )
	    );

		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'expense_type' => $this->input->post('expense_type'),
	        'service_provider_id' => $this->input->post('service_provider_id'),
	        'employee_id' => $this->input->post('employee_id'),
	        'expense_amount' => $this->input->post('expense_amount'),
	        'total_paid' => $this->input->post('total_paid'),
	        'expense_details' => $this->input->post('expense_details'),
	        'expense_creator' => $creator,
	      );
	      $id = $this->expense_model->create($data);
	      $output = '';
	      if ($id != -1) {
	        $jsonData['data'] = $this->expense_model->all($data);
	        $jsonData['success'] = true;
	      }
	    }else {
	      foreach ($_POST as $key => $value) {
	        $jsonData['errors'][$key] = form_error($key);
	      }
	    }
	    echo json_encode($jsonData);
	}

	public function all($rowno=0)
	{
		$rowperpage = 10;
        if($rowno != 0){
          $rowno = ($rowno-1) * $rowperpage;
        }
        $allcount = $this->db->count_all('expense_info');
        $this->db->limit($rowperpage, $rowno);
        $this->db->order_by('expense_id', 'desc');
        $this->db->join('type_info', 'type_info.type_id = expense_info.expense_type');
        $this->db->join('service_provider_info', 'service_provider_info.service_provider_id = expense_info.service_provider_id');
        $users_record = $this->db->get('expense_info')->result_array();
        $config['base_url'] = base_url().'expense';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = $rowno;
        echo json_encode($data);
	}

	public function find()
	{
		$expense_id=$this->input->post('expense_id');
		$data=$this->expense_model->find($expense_id);
		echo json_encode($data);
	}

	public function update()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'expense_name',
	        'label' => 'expense_name',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'expense_contact_no',
	        'label' => 'expense_contact_no',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'expense_email',
	        'label' => 'expense_email',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'expense_address',
	        'label' => 'expense_address',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'expense_description',
	        'label' => 'expense_description',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'expense_description',
	        'label' => 'expense_description',
	      )
	    );
	    $expense_id=$this->input->post('expense_id');
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'expense_name' => $this->input->post('expense_name'),
	        'expense_address' => $this->input->post('expense_address'),
	        'expense_contact_no' => $this->input->post('expense_contact_no'),
	        'expense_email' => $this->input->post('expense_email'),
	        'expense_description' => $this->input->post('expense_description'),
	        'expense_creator' => $creator,
	      );
	      $id = $this->expense_model->update($expense_id,$data);
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
		$result=$this->expense_model->destroy($id);
		if($result){
			$this->session->set_flashdata('success', 'expense Delete successfully');
			redirect('expense','refresh');
		}
	}

	// income CURD
	/* for expense entry*/
    public function income_index()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$bd_date = date('Y-m-d');
		$data['bd_date'] = $bd_date;
		$data['sale_status'] = '';	
		$data['status'] = '';
		$data['user_name'] = $this->tank_auth->get_username();
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['bank_info'] = $this->bankcard_model->all();
		$data['expense_type'] = $this->expense_model->typeall();
		$data['service_provider_info'] = $this->expense_model->SPall();
		$data['employee_info'] = $this->employee_model->all();
		$data['vuejscomp'] = 'income.js';
		$this->__renderview('Setup/income',$data);
	}

	public function income_create()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'income_type',
	        'label' => 'income_type',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'service_provider_id',
	        'label' => 'service_provider_id',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'income_amount',
	        'label' => 'income_amount',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'total_paid',
	        'label' => 'total_paid',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'income_details',
	        'label' => 'income_details',
	      )
	    );

		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'service_provider_id' => $this->input->post('service_provider_id'),
	        'employee_id' => $this->input->post('employee_id'),
	        'income_type' => $this->input->post('income_type'),
	        'income_amount' => $this->input->post('income_amount'),
	        'income_details' => $this->input->post('income_details'),
	        'total_paid' => $this->input->post('total_paid'),
	        'income_creator' => 12,
	      );
	      $id = $this->expense_model->incomecreate($data);
	      $output = '';
	      if ($id != -1) {
	        $jsonData['data'] = $this->expense_model->incomeall($data);
	        $jsonData['success'] = true;
	      }
	    }else {
	      foreach ($_POST as $key => $value) {
	        $jsonData['errors'][$key] = form_error($key);
	      }
	    }
	    echo json_encode($jsonData);
	}

	public function income_all($rowno=0)
	{
		$rowperpage = 10;
        if($rowno != 0){
          $rowno = ($rowno-1) * $rowperpage;
        }
        $allcount = $this->db->count_all('income_info');
        $this->db->limit($rowperpage, $rowno);
        $this->db->order_by('income_id', 'desc');
        $this->db->join('type_info', 'type_info.type_id = income_info.income_type');
        $this->db->join('service_provider_info', 'service_provider_info.service_provider_id = income_info.service_provider_id');
        $users_record = $this->db->get('income_info')->result_array();
        $config['base_url'] = base_url().'income';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = $rowno;
        echo json_encode($data);
	}

	public function income_find()
	{
		$income_id=$this->input->post('income_id');
		$data=$this->expense_model->incomefind($income_id);
		echo json_encode($data);
	}

	public function income_update()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'income_name',
	        'label' => 'income_name',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'income_contact_no',
	        'label' => 'income_contact_no',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'income_email',
	        'label' => 'income_email',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'income_address',
	        'label' => 'income_address',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'income_description',
	        'label' => 'income_description',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'income_description',
	        'label' => 'income_description',
	      )
	    );
	    $income_id=$this->input->post('income_id');
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'income_name' => $this->input->post('income_name'),
	        'income_address' => $this->input->post('income_address'),
	        'income_contact_no' => $this->input->post('income_contact_no'),
	        'income_email' => $this->input->post('income_email'),
	        'income_description' => $this->input->post('income_description'),
	        'income_creator' => $creator,
	      );
	      $id = $this->expense_model->incomeupdate($income_id,$data);
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

	public function income_destroy($id)
	{	
		$result=$this->expense_model->incomedestroy($id);
		if($result){
			$this->session->set_flashdata('success', 'income Delete successfully');
			redirect('expense/income_index','refresh');
		}
	}

	// type 
	public function create_type()
	{
		
		$this->form_validation->set_rules('type_type', 'type_type','required');
		if($this->form_validation->run() ==  FALSE)
		{
			echo json_encode(array('mssage'=>'error'));
		}
		else
		{
			$type_name = $this->input->post('type_type');
			$da=array(
				'type_name'=>$type_name,
				'type_creator'=>12
			);
			$i=$this->expense_model->typecreate($da);
			if($i){
				$typeall=$this->expense_model->typeall($da);
				echo json_encode($typeall);
			}		
		}
	}

	// for service provider
	public function create_service_provider()
	{
		
		$this->form_validation->set_rules('service_provider_name', 'service_provider_name','required');
		if($this->form_validation->run() ==  FALSE)
		{
			echo json_encode(array('mssage'=>'error'));
		}
		else
		{
			$service_provider_name = $this->input->post('service_provider_name');
			$service_provider_type = $this->input->post('service_provider_type');
			$service_provider_address = $this->input->post('service_provider_address');
			$service_provider_contact = $this->input->post('service_provider_contact');
			$service_provider_email = $this->input->post('service_provider_email');
			$service_provider_description = $this->input->post('service_provider_description');
			$da=array(
				'service_provider_name'=>$service_provider_name,
				'service_provider_type'=>$service_provider_type,
				'service_provider_contact'=>$service_provider_contact,
				'service_provider_address'=>$service_provider_address,
				'service_provider_email'=>$service_provider_email,
				'service_provider_description'=>$service_provider_description,
				'service_provider_creator	'=>12
			);
			$i=$this->expense_model->SPcreate($da);
			if($i){
				$typeall=$this->expense_model->SPall($da);
				echo json_encode($typeall);
			}		
		}
	}

}

/* End of file Expense.php */
/* Location: ./application/controllers/Expense.php */