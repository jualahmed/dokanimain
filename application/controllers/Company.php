<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company extends MY_Controller {

	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id=$this->tank_auth->get_shop_id();
		$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->is_logged_in();
		$this->load->model('company_model');
	}

	public function is_logged_in()
	{
		$this->load->library('tank_auth');
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login','refresh');
		}
	}

	public function index()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['sale_status'] = '';
		$data['alarming_level'] = FALSE;
		$data['status'] = '';
		$data['user_name'] = $this->tank_auth->get_username();
		$data['vuejscomp'] = 'company.js';
		$this->__renderview('Setup/company',$data);
	}

	public function create()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'company_name',
	        'label' => 'company_name',
	        'rules' => 'required|is_unique[company_info.company_name]'
	      ),
	      array(
	        'field' => 'company_contact_no',
	        'label' => 'company_contact_no',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'company_email',
	        'label' => 'company_email',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'company_address',
	        'label' => 'company_address',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'company_description',
	        'label' => 'company_description',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'company_description',
	        'label' => 'company_description',
	      )
	    );

		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'company_name' => $this->input->post('company_name'),
	        'company_address' => $this->input->post('company_address'),
	        'company_contact_no' => $this->input->post('company_contact_no'),
	        'company_email' => $this->input->post('company_email'),
	        'company_description' => $this->input->post('company_description'),
	        'company_creator' => $creator,
	      );
	      $id = $this->company_model->create($data);
	      $output = '';
	      if ($id != -1) {
	        $jsonData['data'] = $this->company_model->all($data);
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
		$pageg=$rowno;
		$rowperpage = 12;
        if($rowno != 0){
          $rowno = ($rowno-1) * $rowperpage;
        }
        else{
        	$rowno=0;
        }
        $allcount = $this->db->count_all('company_info');
        $this->db->limit($rowperpage, $rowno);
        $this->db->order_by('company_id', 'desc');
        $users_record = $this->db->get('company_info')->result_array();
        $config['base_url'] = base_url().'company';
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
        
        $data['rowperpage'] = $rowno+$rowperpage;
        if($rowperpage>$allcount){
        	$nopage= (int) $rowperpage/$allcount;
        	$data['rowperpage'] = $this->db->count_all('company_info');
        }else{
        	$nopage= (int) $allcount/$rowperpage;
        }
        $nopage=(int) $nopage;

        if($nopage==($pageg-1)){
        	$data['rowperpage'] = $this->db->count_all('company_info');
        }
        $data['total'] = $allcount;

        echo json_encode($data);
	}

	public function find()
	{
		$company_id=$this->input->post('company_id');
		$data=$this->company_model->find($company_id);
		echo json_encode($data);
	}

	public function update()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'company_name',
	        'label' => 'company_name',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'company_contact_no',
	        'label' => 'company_contact_no',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'company_email',
	        'label' => 'company_email',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'company_address',
	        'label' => 'company_address',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'company_description',
	        'label' => 'company_description',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'company_description',
	        'label' => 'company_description',
	      )
	    );
	    $company_id=$this->input->post('company_id');
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'company_name' => $this->input->post('company_name'),
	        'company_address' => $this->input->post('company_address'),
	        'company_contact_no' => $this->input->post('company_contact_no'),
	        'company_email' => $this->input->post('company_email'),
	        'company_description' => $this->input->post('company_description'),
	        'company_creator' => $creator,
	      );
	      $id = $this->company_model->update($company_id,$data);
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
		$result=$this->company_model->destroy($id);
		if($result){
			$this->session->set_flashdata('success', 'Company Delete successfully');
			redirect('company','refresh');
		}
	}
}

/* End of file Company.php */
/* Location: ./application/controllers/Company.php */