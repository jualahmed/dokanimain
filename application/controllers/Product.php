<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {
	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id=$this->tank_auth->get_shop_id();
		$this->is_logged_in();
		$this->load->model('product_model');
		$this->load->model('category_model');
		$this->load->model('company_model');
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
		$data['company'] = $this->company_model->all();
		$data['catagory'] = $this->category_model->all();
		$data['unit'] = $this->unit_model->all();
		$data['product_specification'] = $this->product_model->product_specification();
		$data['last_id'] = $this->product_model->getLastInserted();
		$data['vuejscomp'] = 'product.js';
		$this->__renderview('Setup/product',$data);
	}

	public function create()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'product_name',
	        'label' => 'product_name',
	        'rules' => 'required|is_unique[product_info.product_name]'
	      ),
	      array(
	        'field' => 'catagory_id',
	        'label' => 'catagory_id',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'company_id',
	        'label' => 'company_id',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'product_specification',
	        'label' => 'product_specification',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'unit_id',
	        'label' => 'unit_id',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'product_model',
	        'label' => 'product_model'
	      ),
	      array(
	        'field' => 'product_size',
	        'label' => 'product_size'
	      ),
	      array(
	        'field' => 'barcode',
	        'label' => 'barcode',
	        'rules' => 'required|is_unique[product_info.barcode]'
	      )   
	    );
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'product_name' => $this->input->post('product_name'),
	        'catagory_id' => $this->input->post('catagory_id'),
	        'company_id' => $this->input->post('company_id'),
	        'product_size' => $this->input->post('product_size'),
	        'product_model' => $this->input->post('product_model'),
	        'unit_id' => $this->input->post('unit_id'),
	        'barcode' => $this->input->post('barcode'),
	        'product_specification' => $this->input->post('product_specification'),
	        'product_warranty' => $this->input->post('product_warranty'),
	        'product_creator' => $creator
	      );
	      $id = $this->product_model->create($data);
	      $output = '';
	      if ($id != -1) {
	        $jsonData['success'] = true;
	        $jsonData['id'] = $id;
	      }
	    }else {
	      foreach ($_POST as $key => $value) {
	        $jsonData['errors'][$key] = form_error($key);
	      }
	    }
	    echo json_encode($jsonData);
	}

	public function upload_file($id){
        $config['upload_path'] = 'assets/img/productimg';
        $config['allowed_types'] = '*';
        $config['max_filename'] = '255';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = '1024'; //1 MB
        if (isset($_FILES['file']['name'])) {
            if (0 < $_FILES['file']['error']) {
                echo 'Error during file upload' . $_FILES['file']['error'];
            } else {
                if (file_exists('assets/img/productimg/' . $_FILES['file']['name'])) {
                    echo 'File already exists : assets/img/productimg/' . $_FILES['file']['name'];
                } else {
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('file')) {
                        echo $this->upload->display_errors();
                    } else {
                    	$upload_data = $this->upload->data();
                        echo 'File successfully uploaded : assets/img/productimg/' . $_FILES['file']['name'];
                        $this->db->set('img', base_url().'assets/img/productimg/'.$upload_data['file_name']);
                        $this->db->where('product_id', $id);
                        $this->db->update('product_info');
                    }
                }
            }
        } else {
            echo 'Please choose a file';
        }
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
        $allcount = $this->db->count_all('product_info');
        $this->db->limit($rowperpage, $rowno);
        $this->db->join('catagory_info', 'catagory_info.catagory_id = product_info.catagory_id');
        $this->db->join('company_info', 'company_info.company_id = product_info.company_id');
        $this->db->order_by('product_id', 'desc');
        $users_record = $this->db->get('product_info')->result_array();
        $config['base_url'] = base_url().'product';
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
        	$data['rowperpage'] = $this->db->count_all('product_info');
        }else{
        	$nopage= (int) $allcount/$rowperpage;
        }
        $nopage=(int) $nopage;

        if($nopage==($pageg-1)){
        	$data['rowperpage'] = $this->db->count_all('product_info');
        }
        $data['total'] = $allcount;

        echo json_encode($data);
	}

	public function find()
	{
		$product_id=$this->input->post('product_id');
		$data=$this->product_model->find($product_id);
		echo json_encode($data);
	}

	public function update()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $product_id=$this->input->post('product_id');

		$original_value = $this->db->query("SELECT product_name FROM product_info WHERE product_id = ".$product_id)->row()->product_name ;
	    if($this->input->post('product_name') != $original_value) {
	       $is_unique =  '|is_unique[product_info.product_name]';
	    } else {
	       $is_unique =  '';
	    }

	    $rules = array(
	      array(
	        'field' => 'product_name',
	        'label' => 'product_name',
	        'rules' => 'required'.$is_unique
	      ),
	      array(
	        'field' => 'catagory_id',
	        'label' => 'catagory_id',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'company_id',
	        'label' => 'company_id',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'unit_id',
	        'label' => 'unit_id',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'product_model',
	        'label' => 'product_model'
	      ),
	      array(
	        'field' => 'product_size',
	        'label' => 'product_size'
	      ) 
	    );
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'product_name' => $this->input->post('product_name'),
	        'catagory_id' => $this->input->post('catagory_id'),
	        'company_id' => $this->input->post('company_id'),
	        'product_size' => $this->input->post('product_size'),
	        'product_model' => $this->input->post('product_model'),
	        'unit_id' => $this->input->post('unit_id'),
	        'product_creator' => $creator
	      );
	      $id = $this->product_model->update($product_id,$data);
	      $output = '';
	      if ($id) {
	        $jsonData['success'] = true;
	        $jsonData['id'] = $product_id;
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
		$result=$this->product_model->destroy($id);
		if($result){
			$this->session->set_flashdata('success', 'product Delete successfully');
			redirect('product','refresh');
		}
	}
	
	public function search($query='')
	{	
		$query=$this->input->get('query');
		$data=$this->product_model->search($query);
		echo json_encode($data);
	}

	public function search_product(){
        $product_name			= $this->input->post('term');
		$data 	= true;
		$data 	= $this->product_model->search_and_get_product($product_name);
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

	public function search_barcode_barcode()
	{
		$barcode = $this->input->post('barcode');
		$this->db->select('product_id');
		$this->db->from('product_info');
		$this->db->where('barcode',$barcode);
		$quer=$this->db->get();
		if($quer->num_rows >0){ 
			foreach($quer-> result() as $field):
				$inputValue = $field->product_id;
			endforeach;
		}
		redirect('product/searchBarcode/'.$inputValue);
	}

	public function warrantyproductprint($id='')
	{
		$this->product_model->wmakeBarcodew($id);
		redirect('product/searchBarcode');
	}

	public function searchBarcode()
	{
		$data['bd_date'] = date ('Y-m-d');
		$data['user_id'] = $this->tank_auth->get_user_id();
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();	
		$data['shop_name'] = $this->tank_auth->get_shopname();
		$data['shop_address'] = $this->tank_auth->get_shopaddress();
		$data['access_status'] = '';
		$data['sale_status'] = '';
		$data['status'] = '';
		$data['alarming_level'] = FALSE;
	    $data['product_info']  = $this->product_model->productsss_info(FALSE, 0, $this->tank_auth->get_shop_id())->result();
	    $data['w_product_info']  = $this->product_model->w_product_info();
		$data['product_type'] = 'nil';
		if($this->input->post('productId'))
	    	$product_ID = $this->input->post('productId'); // from submission
		else $product_ID = $this->uri->segment(3) ; // from url
		$query_two = $this->product_model->products_special_information($product_ID, $this->tank_auth->get_shop_id());
		foreach($query_two -> result() as $field):
			 $data['product_name'] = $field->product_name;
			 $data['available_stock'] = $field->available_stock;
			 $data['product_type'] = $field->product_specification;
			 $data['buy_price'] = $field->bulk_unit_buy_price;
			 $data['sale_price'] = $field->bulk_unit_sale_price;
			 $data['general_sale_price'] = $field->general_unit_sale_price;
		endforeach;
		if($this->uri->segment(3))
		{
			$this->form_validation->set_rules('product_id', ' ', 'trim|required|xss_clean');
			if( $data['product_type'] == 'bulk')
					$this->form_validation->set_rules('Quantity', ' ', 'trim|required|xss_clean|numeric');
		}
		else
		{
			$this->form_validation->set_rules('productId', ' ', 'trim|required|xss_clean');
			if( $data['product_type'] == 'bulk')
				$this->form_validation->set_rules('Quantity', ' ', 'trim|required|xss_clean|numeric');
			else $this->form_validation->set_rules('special_for_individual', ' ', 'trim|required|xss_clean|numeric');
		}
		$data['find_all_stock_id']= $this->product_model->find_all_stock_id($product_ID, $this->tank_auth->get_shop_id());
		if($this->form_validation->run())
		{
			$data['status'] = 'successful';
			$SALE_price = $this->input->post('unit_sale_price');
			$g_price = $this->input->post('general_sale_price');
			$PRODUCT_NAME = $this->input->post('PRODUCT_NAME');
			$this->product_model->makeBarcode($product_ID,$PRODUCT_NAME,$data['product_type'],$SALE_price,$g_price,$data['find_all_stock_id']);
		}
		$data['listed_product'] =$this->product_model->get_barcode_all_listed_product();
		$data['vuejscomp'] = 'searchBarcodeview.js';
		$this->__renderview('searchBarcodeview', $data);
	}

	public function delete_all_barcode_print_product()
	{
		$this->db->empty_table('barcode_print'); 
		redirect('product/searchBarcode');
	}
	
	public function print_barcode_by_search()
	{
		$data['nil_discount'] = 1;
		$data['listed_product'] = $this->product_model->get_barcode_all_listed_product();
		$this->__renderviewprint('Prints/barcode/barcode_print_view', $data);
	}

	public function delete_barcode_print_product($print_id = '')
	{
		$this->db->where('print_id',$print_id); 
		$this->db->delete('barcode_print'); 
		redirect('product/searchBarcode');
	}

	public function update_new_product_serial()
	{
		$creator = $this->tank_auth->get_user_id();
		$product_type2 =  rawurldecode($this->input->post('product_type'));
		$product_id = $this->input->post('product_id');
		$new_temp_sale_id = $this->input->post('new_temp_sale_id');
		$product_type_1 = explode("product_type=",$product_type2);
		$k = 0;
		foreach($product_type_1 AS $product_type_12)
		{
			if($k != 0){
				$product_type_2[$k] = str_replace('&','',$product_type_12);
			}
			$k++;
		}
		$i=1;
		foreach($product_type_2 as $product) 
		{
			$data_product= array(
				'invoice_id' => $new_temp_sale_id,
				'status' => 0
			);
			$this->db->where('ip_id', $product);
			$this->db->where('product_id', $product_id);
			$this->db->update('warranty_product_list', $data_product);
			$i++;
		}
		echo json_encode('Success');
	}

}

/* End of file Product.php */
/* Location: ./application/controllers/Product.php */