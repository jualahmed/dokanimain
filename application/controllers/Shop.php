<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('shop_model');
	}

	public function shop_setup($value='')
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this->access_control_model->my_access($data['user_type'], 'Registration', 'shop_setup'))
		{
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['alarming_level'] = FALSE;
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('shopName', 'shopName ', 'xss_clean|required');
			$this->form_validation->set_rules('shopAddress', 'shopAddress ','required|xss_clean');
			$this->form_validation->set_rules('shopContact', ' shopContact ','required|xss_clean');
			if($this->form_validation->run())
			{
				$config['upload_path'] = 'assets/img/shop';
		        $config['allowed_types'] = '*';
		        $config['max_filename'] = '255';
		        $config['encrypt_name'] = TRUE;
		        $config['max_size'] = '1024'; //1 MB
	          	$this->load->library('upload', $config);
                if (!$this->upload->do_upload('logo')) {
                   
                } else {
                	$upload_data = $this->upload->data();
                }
                $config['upload_path'] = 'assets/img/shop';
		        $config['allowed_types'] = '*';
		        $config['max_filename'] = '255';
		        $config['encrypt_name'] = TRUE;
		        $config['max_size'] = '1024'; //1 MB
	          	$this->load->library('upload', $config);
                if (!$this->upload->do_upload('invoicelogo')) {
                   
                } else {
                	$upload_data1 = $this->upload->data();
                }
                if(isset($upload_data)){
                	$file_name=$upload_data['file_name'];
                }else{
                	$file_name='';
                }
                if(isset($upload_data1)){
                	$file_name1=$upload_data1['file_name'];
                }else{
                	$file_name1='';
                }
				$this->shop_model->shop_setup(
					$this->form_validation->set_value('shopName'),
					$this->form_validation->set_value('shopType'),
					$this->form_validation->set_value('shopAddress'),
					$this->form_validation->set_value('shopContact'),
					$file_name,
					$file_name1
				);
			}
			
			$data['allshop']=$this->db->get('shop_setup')->result();
			$data['vuejscomp']="shop_setup.js";
			$this->__renderview('shop_setup', $data);
		}
	}

	public function findshop()
	{	
		$id=$this->input->post("shop_id");
		$this->db->where('shop_id', $id);
		$data=$this->db->get('shop_setup')->row();
		echo json_encode($data);
	}

	public function shopupdate()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'shop_name',
	        'label' => 'shop_name',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'shop_contact',
	        'label' => 'shop_contact',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'shop_address',
	        'label' => 'shop_address',
	        'rules' => 'required'
	      )
	    );
	    $shop_id=$this->input->post('shop_id');
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'shop_name' => $this->input->post('shop_name'),
	        'shop_contact' => $this->input->post('shop_contact'),
	        'shop_address' => $this->input->post('shop_address')
	      );
	      $id = $this->shop_model->update($shop_id,$data);
	      $output = '';
	      if ($id) {
	        $jsonData['success'] = true;
	        $jsonData['id'] = $shop_id;
	      }
	    }else {
	      foreach ($_POST as $key => $value) {
	        $jsonData['errors'][$key] = form_error($key);
	      }
	    }
	    echo json_encode($jsonData);
	}

	public function deleteshop($id='')
	{	
		$this->db->where('shop_id', $id);
		$this->db->delete('shop_setup');
		redirect('/shop/shop_setup','refresh');
	}

	public function upload_file($id){
        $config['upload_path'] = 'assets/img/shop';
        $config['allowed_types'] = '*';
        $config['max_filename'] = '255';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = '1024'; //1 MB
        if (isset($_FILES['logo']['name'])) {
            if (0 < $_FILES['logo']['error']) {
                echo 'Error during logo upload' . $_FILES['logo']['error'];
            } else {
              	$this->db->where('shop_id', $id);
            	$sddsd=$this->db->get('shop_setup')->row();
                if (file_exists('assets/img/shop/'.$sddsd->logo)) {
                	unlink('assets/img/shop/'.$sddsd->logo);
                }
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('logo')) {
                    echo $this->upload->display_errors();
                } else {
                	$upload_data = $this->upload->data();
                    echo 'File successfully uploaded : assets/img/shop/' . $_FILES['logo']['name'];
                    $this->db->set('logo',$upload_data['file_name']);
                    $this->db->where('shop_id', $id);
                    $this->db->update('shop_setup');
                }
            }
        } else {
            echo 'Please choose a file';
        }

        if (isset($_FILES['invoicelogo']['name'])) {
            if (0 < $_FILES['invoicelogo']['error']) {
                echo 'Error during invoicelogo upload' . $_FILES['invoicelogo']['error'];
            } else {
            	$this->db->where('shop_id', $id);
            	$sddd=$this->db->get('shop_setup')->row();
                if (file_exists('assets/img/shop/'.$sddd->invoicelogo)) {
                	unlink('assets/img/shop/'.$sddd->invoicelogo);
                }
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('invoicelogo')) {
                    echo $this->upload->display_errors();
                } else {
                	$upload_data = $this->upload->data();
                    echo 'File successfully uploaded : assets/img/shop/' . $_FILES['invoicelogo']['name'];
                    $this->db->set('invoicelogo',$upload_data['file_name']);
                    $this->db->where('shop_id', $id);
                    $this->db->update('shop_setup');
                }
                
            }
        } else {
            echo 'Please choose a file';
        }
    }
}

/* End of file Shop.php */
/* Location: ./application/controllers/Shop.php */