<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends MY_Controller {

	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id=$this->tank_auth->get_shop_id();
		$this->is_logged_in();
		$this->load->model('unit_model');
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
		$data['vuejscomp'] = 'unit.js';
		$this->__renderview('Setup/unit',$data);
	}

	public function create()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'unit_name',
	        'label' => 'unit_name',
	        'rules' => 'required|is_unique[unit_info.unit_name]'
	      )
	    );

		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'unit_name' => $this->input->post('unit_name'),
	      );
	      $id = $this->unit_model->create($data);
	      $output = '';
	      if ($id != -1) {
	        $jsonData['data'] = $this->unit_model->all($data);
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
		$rowperpage = 12;
        if($rowno != 0){
          $rowno = ($rowno-1) * $rowperpage;
        }
        $allcount = $this->db->count_all('unit_info');
        $this->db->limit($rowperpage, $rowno);
        $this->db->order_by('unit_id', 'desc');
        $users_record = $this->db->get('unit_info')->result_array();
        $config['base_url'] = base_url().'unit';
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
		$unit_id=$this->input->post('unit_id');
		$data=$this->unit_model->find($unit_id);
		echo json_encode($data);
	}

	public function update()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'unit_name',
	        'label' => 'unit_name',
	        'rules' => 'required'
	      )
	    );
	    $unit_id=$this->input->post('unit_id');
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'unit_name' => $this->input->post('unit_name'),
	      );
	      $id = $this->unit_model->update($unit_id,$data);
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
		$result=$this->unit_model->destroy($id);
		if($result){
			$this->session->set_flashdata('success', 'unit Delete successfully');
			redirect('unit','refresh');
		}
	}

}

/* End of file Unit.php */
/* Location: ./application/controllers/Unit.php */