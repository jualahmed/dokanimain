<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Damageproduct extends MY_Controller {

	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id=$this->tank_auth->get_shop_id();
		$this->is_logged_in();
		$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->load->model('damageproduct_model');
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
		$data['vuejscomp'] = 'damageproduct.js';
		$this->__renderview('Setup/damageproduct',$data);
	}

	public function create()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'product_name',
	        'label' => 'product_name',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'damage_quantity',
	        'label' => 'damage_quantity',
	        'rules' => 'required'
	      ),array(
	        'field' => 'buy_price',
	        'label' => 'buy_price',
	        'rules' => 'required|integer'
	      )
	    );

		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'product_id' => $this->input->post('pro_id'),
	        'damage_quantity' => $this->input->post('damage_quantity'),
	        'unit_buy_price' => $this->input->post('buy_price'),
	        'creator' => $creator,
	      );
	      $id = $this->damageproduct_model->create($data);
	      $output = '';
	      if ($id != -1) {
	        $jsonData['data'] = $this->damageproduct_model->all($data);
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
        $allcount = $this->db->count_all('damage_product');

        $this->db->limit($rowperpage, $rowno);
        $this->db->order_by('damage_id', 'desc');
        $this->db->join('product_info','product_info.product_id = damage_product.product_id');
        $users_record = $this->db->get('damage_product')->result_array();
        $config['base_url'] = base_url().'damageproduct';
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
		$damageproduct_id=$this->input->post('damageproduct_id');
		$data=$this->damageproduct_model->find($damageproduct_id);
		echo json_encode($data);
	}

	public function update()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'damageproduct_name',
	        'label' => 'damageproduct_name',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'damageproduct_contact_no',
	        'label' => 'damageproduct_contact_no',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'damageproduct_email',
	        'label' => 'damageproduct_email',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'damageproduct_address',
	        'label' => 'damageproduct_address',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'damageproduct_description',
	        'label' => 'damageproduct_description',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'damageproduct_description',
	        'label' => 'damageproduct_description',
	      )
	    );
	    $damageproduct_id=$this->input->post('damageproduct_id');
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'damageproduct_name' => $this->input->post('damageproduct_name'),
	        'damageproduct_address' => $this->input->post('damageproduct_address'),
	        'damageproduct_contact_no' => $this->input->post('damageproduct_contact_no'),
	        'damageproduct_email' => $this->input->post('damageproduct_email'),
	        'damageproduct_description' => $this->input->post('damageproduct_description'),
	        'damageproduct_creator' => $creator,
	      );
	      $id = $this->damageproduct_model->update($damageproduct_id,$data);
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
		$result=$this->damageproduct_model->destroy($id);
		if($result){
			$this->session->set_flashdata('success', 'damageproduct Delete successfully');
			redirect('damageproduct','refresh');
		}
	}

	public function search_product(){
        $product_name			= $this->input->post('term');
		$data 	= true;
		$data 	= $this->damageproduct_model->search_and_get_product($product_name);
		$info 	= array();
		$stock 	= 0;
		if($data != false){
			foreach($data->result() as $tmp){
				if($tmp->stock_amount == '')$stock = 0;
				else $stock = $tmp->stock_amount;

				$info[] = array(
					'id' 						=> $tmp->product_id,
					'product_name' 				=> $tmp->product_name,
					'company_name' 				=> $tmp->company_name,
					'catagory_name' 			=> $tmp->catagory_name,
					'sale_price' 				=> $tmp->bulk_unit_sale_price,
					'buy_price' 				=> $tmp->bulk_unit_buy_price,
					'stock' 					=> $stock,
					'barcode' 					=> $tmp->barcode,
					'product_specification' 	=> $tmp->product_specification,
					'temp_pro_data' 			=> 	$tmp->product_id . '<>' . 
													$tmp->product_name . '<>' .
													$tmp->stock_amount . '<>' .
													$tmp->bulk_unit_sale_price . '<>' .
													$tmp->bulk_unit_buy_price . '<>' .
													$tmp->product_specification
					);
			}
		}
		else{
			$info[] = array(
					'id' 						=> '',
					'product_name' 				=> 'Nothing Found',
					'company_name' 				=> '',
					'catagory_name' 			=> '',
					'sale_price' 				=> '',
					'buy_price' 				=> '',
					'stock' 					=> '',
					'generic_name' 				=> '',
					'barcode' 					=> '',
					'product_specification' 	=> '',
					'temp_pro_data' 			=> ''
					);
		}
		echo json_encode($info);
	}

}

/* End of file Damageproduct.php */
/* Location: ./application/controllers/Damageproduct.php */