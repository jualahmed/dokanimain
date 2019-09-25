<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distributor extends MY_Controller {

	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id=$this->tank_auth->get_shop_id();
		$this->is_logged_in();
		$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->load->model('distributor_model');
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
		$data['vuejscomp'] = 'distributor.js';
		$this->__renderview('Setup/distributor',$data);
	}

	public function create()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'distributor_name',
	        'label' => 'distributor_name',
	        'rules' => 'required|is_unique[distributor_info.distributor_name]'
	      ),
	      array(
	        'field' => 'distributor_contact_no',
	        'label' => 'distributor_contact_no',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'distributor_email',
	        'label' => 'distributor_email',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'distributor_address',
	        'label' => 'distributor_address',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'int_balance',
	        'label' => 'int_balance',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'distributor_description',
	        'label' => 'distributor_description',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'distributor_description',
	        'label' => 'distributor_description',
	      )
	    );

		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'distributor_name' => $this->input->post('distributor_name'),
	        'distributor_address' => $this->input->post('distributor_address'),
	        'int_balance' => $this->input->post('int_balance'),
	        'distributor_contact_no' => $this->input->post('distributor_contact_no'),
	        'distributor_email' => $this->input->post('distributor_email'),
	        'distributor_description' => $this->input->post('distributor_description'),
	        'distributor_creator' => $creator,
	      );
	      $id = $this->distributor_model->create($data);
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

	// all distributor with pagination 
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
        $allcount = $this->db->count_all('distributor_info');
        $this->db->limit($rowperpage, $rowno);
        $this->db->order_by('distributor_id', 'desc');
        $users_record = $this->db->get('distributor_info')->result_array();
        $config['base_url'] = base_url().'distributor';
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
        	$data['rowperpage'] = $this->db->count_all('distributor_info');
        }else{
        	$nopage= (int) $allcount/$rowperpage;
        }
        $nopage=(int) $nopage;

        if($nopage==($pageg-1)){
        	$data['rowperpage'] = $this->db->count_all('distributor_info');
        }
        $data['total'] = $allcount;

        echo json_encode($data);
	}

	// all distributor without pagination 
	public function find()
	{
		$distributor_id=$this->input->post('distributor_id');
		$data=$this->distributor_model->find($distributor_id);
		echo json_encode($data);
	}

	public function update()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'distributor_name',
	        'label' => 'distributor_name',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'distributor_contact_no',
	        'label' => 'distributor_contact_no',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'distributor_email',
	        'label' => 'distributor_email',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'distributor_address',
	        'label' => 'distributor_address',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'int_balance',
	        'label' => 'int_balance',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'distributor_description',
	        'label' => 'distributor_description',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'distributor_description',
	        'label' => 'distributor_description',
	      )
	    );
	    $distributor_id=$this->input->post('distributor_id');
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'distributor_name' => $this->input->post('distributor_name'),
	        'distributor_address' => $this->input->post('distributor_address'),
	        'int_balance' => $this->input->post('int_balance'),
	        'distributor_contact_no' => $this->input->post('distributor_contact_no'),
	        'distributor_email' => $this->input->post('distributor_email'),
	        'distributor_description' => $this->input->post('distributor_description'),
	        'distributor_creator' => $creator,
	      );
	      $id = $this->distributor_model->update($distributor_id,$data);
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
		$result=$this->distributor_model->destroy($id);
		if($result){
			$this->session->set_flashdata('success', 'distributor Delete successfully');
			redirect('distributor','refresh');
		}
	}

}

/* End of file Distributor.php */
/* Location: ./application/controllers/Distributor.php */