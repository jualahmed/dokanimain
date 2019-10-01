<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchaselisting extends MY_Controller {

	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id=$this->tank_auth->get_shop_id();
		$this->is_logged_in();
		$this->load->model('purchaselisting_model');
		$this->load->model('report_model');
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
		$data['user_name'] = $this->tank_auth->get_username();
		$data['vuejscomp'] = 'purchaselisting.js';
		$this->__renderview('Purchase/purchaselisting',$data);
	}

	public function createlisting()
	{
		$purchase_receipt_id=$this->input->post('purchase_receipt_id');
		$product_id=$this->input->post('product_id');
		$expiredate=$this->input->post('expiredate');
		$tp_total=$this->input->post('tp_total');
		$vat_total=$this->input->post('vat_total');
		$quantity=$this->input->post('quantity');
		$total_buy_price=$this->input->post('total_buy_price');
		$unit_buy_price_purchase=$this->input->post('unit_buy_price_purchase');
		$exclusive_sale_price=$this->input->post('exclusive_sale_price');
		$general_sale_price=$this->input->post('general_sale_price');
		$allworrantyproduct=$this->input->post('allworrantyproduct');
		$creator = $this->tank_auth->get_user_id();
		// Bulk stoke info table
		$this->db->where('product_id', $product_id);
		$alddata=$this->db->get('bulk_stock_info')->result();

		if($alddata){
			$oldquantity=$alddata['0']->stock_amount;
			$totalquantity=$quantity+$oldquantity;
			$unit_buy_price_purchase1=($alddata['0']->bulk_unit_buy_price+$unit_buy_price_purchase)/2;
			$exclusive_sale_price1=($alddata['0']->bulk_unit_sale_price+$exclusive_sale_price)/2;
			$general_unit_sale_price1=($alddata['0']->general_unit_sale_price+$general_sale_price)/2;
			$object=[
				'stock_amount'=>$totalquantity,
				'bulk_unit_buy_price'=>$unit_buy_price_purchase1,
				'bulk_unit_sale_price'=>$exclusive_sale_price1,
				'general_unit_sale_price'=>$general_unit_sale_price1,
				'last_buy_price'=>$total_buy_price
			];
			$this->db->where('bulk_id', $alddata['0']->bulk_id);
			$this->db->update('bulk_stock_info',$object);
		}else{
			$object=[
				'stock_amount'=>$quantity,
				'product_id'=>$product_id,
				'shop_id'   => $this->tank_auth->get_shop_id(), 
				'bulk_unit_buy_price'=>$unit_buy_price_purchase,
				'bulk_unit_sale_price'=>$exclusive_sale_price,
				'general_unit_sale_price'=>$general_sale_price,
				'bulk_alarming_stock'=>100,
				'last_buy_price'=>$total_buy_price,
			];
			$this->db->insert('bulk_stock_info', $object);
		}

		// reciper for info table
		$data = array(
	        'purchase_receipt_id' => $purchase_receipt_id,
	        'product_id' => $product_id,
	        'purchase_quantity' => $quantity,
	        'unit_buy_price' => $unit_buy_price_purchase,
	        'purchase_expire_date' => $expiredate,
	        'purchase_description' => "a test purchase_receipt_id",
	        'purchase_creator' => $creator,
	    );
	    $id=$this->purchaselisting_model->createlisting($data);

	    if(!empty($allworrantyproduct)){
		    foreach ($allworrantyproduct as $key => $value) {
				$datass = array(
			        'product_id' => $product_id,
			        'purchase_receipt_id' => $purchase_receipt_id,
			        'sl_no'=>$value,
			        'purchase_date' => date("Y-m-d"),
			        'purchase_price' => $unit_buy_price_purchase,
			        'sale_price' => $general_sale_price,
			        'creator' => $creator,
		    	);
		    	$this->db->insert('warranty_product_list', $datass);
			}
		}

	    $this->db->select('purchase_info.*,product_info.product_name');
		$this->db->where('purchase_id', $id);
		$this->db->join('product_info', 'product_info.product_id = purchase_info.product_id');
		$alldata= $this->db->get('purchase_info')->result();
	    echo json_encode($alldata);
	}

	public function allproductbelogntopurchase($purchase_id='')
	{	
		$data=$this->purchaselisting_model->allproductbelogntopurchase($purchase_id);
		echo json_encode($data);
	}

	public function specificPurchaseReceipt()
	{
		$purchase_receipt_id 				= (int)$this->input->post('purchase_receipt_id');
		$receipt_general_details			= $this->purchaselisting_model->specific_purchase_receipt_general( $purchase_receipt_id);
		$tmp_row 							= $receipt_general_details->row();
		$tmp_data['final_amount'] 			= $tmp_row->final_amount;
		$tmp_data['purchase_amount'] 		= $tmp_row->purchase_amount;
		$tmp_data['total_purchase_amount'] 	= $this->purchaselisting_model->get_total_purchase_amount($purchase_receipt_id);
		echo json_encode($tmp_data);
	}

	public function getSpecificPurchaseReceiptProduct()
	{
		$purchase_receipt_id 		= (int)$this->input->post('purchase_receipt_id');
		$purchase_receipt_details	= $this->purchaselisting_model->specific_purchase_receipt($purchase_receipt_id);
		json_encode($purchase_receipt_details);
	}
	
	public function all($rowno=0)
	{
		$rowperpage = 12;
        if($rowno != 0){
          $rowno = ($rowno-1) * $rowperpage;
        }
        $allcount = $this->db->count_all('Purchaselisting_info');
        $this->db->limit($rowperpage, $rowno);
        $this->db->order_by('Purchaselisting_id', 'desc');
        $users_record = $this->db->get('Purchaselisting_info')->result_array();
        $config['base_url'] = base_url().'Purchaselisting';
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
		$Purchaselisting_id=$this->input->post('Purchaselisting_id');
		$data=$this->Purchaselisting_model->find($Purchaselisting_id);
		echo json_encode($data);
	}

	public function update()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'Purchaselisting_name',
	        'label' => 'Purchaselisting_name',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'Purchaselisting_contact_no',
	        'label' => 'Purchaselisting_contact_no',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'Purchaselisting_email',
	        'label' => 'Purchaselisting_email',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'Purchaselisting_address',
	        'label' => 'Purchaselisting_address',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'Purchaselisting_description',
	        'label' => 'Purchaselisting_description',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'Purchaselisting_description',
	        'label' => 'Purchaselisting_description',
	      )
	    );
	    $Purchaselisting_id=$this->input->post('Purchaselisting_id');
		$creator = $this->tank_auth->get_user_id();
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'Purchaselisting_name' => $this->input->post('Purchaselisting_name'),
	        'Purchaselisting_address' => $this->input->post('Purchaselisting_address'),
	        'Purchaselisting_contact_no' => $this->input->post('Purchaselisting_contact_no'),
	        'Purchaselisting_email' => $this->input->post('Purchaselisting_email'),
	        'Purchaselisting_description' => $this->input->post('Purchaselisting_description'),
	        'Purchaselisting_creator' => $creator,
	      );
	      $id = $this->Purchaselisting_model->update($Purchaselisting_id,$data);
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
		$result=$this->Purchaselisting_model->destroy($id);
		if($result){
			$this->session->set_flashdata('success', 'Purchaselisting Delete successfully');
			redirect('Purchaselisting','refresh');
		}
	}

}

/* End of file Purchaselisting.php */
/* Location: ./application/controllers/Purchaselisting.php */