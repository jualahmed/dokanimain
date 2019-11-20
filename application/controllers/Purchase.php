<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
class Purchase extends MY_Controller
{
	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id = $this->tank_auth->get_shop_id();
		$this->is_logged_in();
		$this->load->model('purchase_model');
		$this->load->model('product_model');
		$this->load->model('distributor_model');
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
	
	public function index()
	{
		$data['user_type'] 	= $this->tank_auth->get_usertype();
		$data['user_name'] 	= $this->tank_auth->get_username();
		$data['all_bank'] 	= $this->bankcard_model->all();
		$data['distributor_info'] 	= $this->distributor_model->all();
		$data['status'] 	= '';
		$data['vuejscomp'] = 'purchasereceipt.js';
		$this->__renderview('Purchase/purchasereceipt',$data);
	}

	public function create()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
	    $rules = array(
	      array(
	        'field' => 'distributor_id',
	        'label' => 'distributor_id',
	        'rules' => 'required'
	      ),
	      array(
	        'field' => 'purchase_amount',
	        'label' => 'purchase_amount',
	        'rules' => 'required|integer'
	      ),
	      array(
	        'field' => 'transport_cost',
	        'label' => 'transport_cost',
	      ),
	      array(
	        'field' => 'gift_on_purchase',
	        'label' => 'gift_on_purchase',
	      ),
	      array(
	        'field' => 'final_amount',
	        'label' => 'final_amount',
	      ),
	      array(
	        'field' => 'payment_amount',
	        'label' => 'payment_amount',
	      ),
	      array(
	        'field' => 'receipt_date',
	        'label' => 'receipt_date',
	        'rules' => 'required'
	      )
	    );

		$creator = $this->tank_auth->get_user_id();
		$ffffffff=$this->input->post('receipt_date');
	    $this->form_validation->set_rules($rules);
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	    if ($this->form_validation->run() == TRUE) {
	      $jsonData['check'] = true;
	      $data = array(
	        'distributor_id' => $this->input->post('distributor_id'),
	        'purchase_amount' => $this->input->post('purchase_amount'),
	        'transport_cost' => $this->input->post('transport_cost'),
	        'gift_on_purchase' => $this->input->post('gift_on_purchase'),
	        'final_amount' => $this->input->post('final_amount'),
	        'shop_id' 		=> $this->tank_auth->get_shop_id(), 
	        'receipt_status' 	=> 'unpaid',
			'total_paid' 		=> $this->input->post('payment_amount'),
	        'receipt_date	' => $ffffffff,
	        'receipt_creator' => $creator,
	      );
	      // $id = 4;
	      $id = $this->purchase_model->create($data,$ffffffff);
	      $output = '';
	      if ($id != -1) {
	        $jsonData['data'] = $this->purchase_model->all($data);
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
		$rowperpage = 8;
        if($rowno != 0){
          $rowno = ($rowno-1) * $rowperpage;
        }
        $allcount = $this->db->count_all('purchase_receipt_info');
        $this->db->limit($rowperpage, $rowno);
        $this->db->order_by('receipt_id', 'desc');
        $this->db->join('distributor_info', 'distributor_info.distributor_id = purchase_receipt_info.distributor_id');
        $users_record = $this->db->get('purchase_receipt_info')->result_array();
        $config['base_url'] = base_url().'purchase';
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
        $config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']   = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close']  = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']   = '</span></li>';
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = $rowno;
        echo json_encode($data);
	}

	public function alls()
	{
		$data=$this->purchase_model->all();
		echo json_encode($data);
	}

	// purchase return
	public function purchase_return()
	{
		$data['user_type'] 	= $this->tank_auth->get_usertype();
		$data['user_name'] 	= $this->tank_auth->get_username();
		$data['all_bank'] 	= $this->bankcard_model->all();
		$data['distributor_info'] 	= $this->distributor_model->all();
		$data['product_info_warranty_details'] 	= '';
		$data['product_info_details'] 	= '';
		$data['return_main_product'] 	= $this->purchase_model->purchase_return_lilsting_product();
		$i=1;
		foreach($data['return_main_product']->result() as $tmp)
		{
			$data['return_warranty_product'][$i] 	= $this->purchase_model->purchase_return_lilsting_product_warranty($tmp->produ_id);
			$i++;
		}
		$distributor_id = $this->uri->segment(3);
		$product_id = $this->uri->segment(4);
		if($distributor_id!='' || $product_id!='')
		{
			$data['product_info'] 	= $this->product_model->all();
			$data['product_info_details'] 	= $this->purchase_model->product_info_details($product_id);
			$data['product_info_warranty_details'] 	= $this->purchase_model->product_info_warranty_details($product_id);
		}
		$data['status'] 	= '';
		$data['vuejscomp'] = 'purchase_return.js';
		$this->__renderview('Purchase/purchase_return', $data);
	}

	public function list_purchase_temp_data()
	{
		$bd_date=date('Y-m-d');
		$creator = $this->tank_auth->get_user_id();
		$ip_id 			= $this->input->post('ip_ids');
		$pro_id 		= $this->input->post('pro_id');
		$dis_id 		= $this->input->post('dis_id');
		$buy_price 		= $this->input->post('buy_price');
		$return_amount 	= $this->input->post('return_amount');
		
		if($ip_id!='')
		{
			
			$main_data = array(
				'distri_id' => $dis_id,
				'produ_id' => $pro_id,
				'return_quantity' => 0,
				'buy_price' => $buy_price,
				'status' => 0,
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$this->db->insert('purchase_return_main_product',$main_data);
			$insert_id = $this->db->insert_id();
			$i=1;
			foreach($ip_id as $ip)
			{	
				$this->db->set('stock_amount', 'stock_amount-'. 1, FALSE);
				$this->db->where('product_id', $pro_id);
				$this->db->update('bulk_stock_info');

				$this->db->set('status',0);
				$this->db->where('ip_id',$ip);
				$this->db->update('warranty_product_list');

				$this->db->select('sl_no');
				$this->db->from('warranty_product_list');
				$this->db->where('ip_id',$ip);
				$query= $this->db->get();
				$tmp =$query->row();
				
				$warranty_data = array
				(
					'prmp_id' =>$insert_id,
					'ip_id' =>$ip,
					'product_id' =>$pro_id,
					'sl_no' =>$tmp->sl_no,
					'status' =>0,
					'creator' =>$creator,
					'doc' =>$bd_date,
					'dom' =>$bd_date
				);
				$this->db->insert('purchase_return_warranty_product', $warranty_data);
				$this->db->set('return_quantity', 'return_quantity+' . 1, FALSE);
				$this->db->where('prmp_id', $insert_id);
				$this->db->update('purchase_return_main_product');
				$i++;	
			}
			redirect('purchase/purchase_return/'.$dis_id);
		}
		else
		{
			$this->db->set('stock_amount', 'stock_amount-' . $return_amount, FALSE);
			$this->db->where('product_id', $pro_id);
			$this->db->update('bulk_stock_info');
			$main_data = array(
				'distri_id' => $dis_id,
				'produ_id' => $pro_id,
				'return_quantity' => $return_amount,
				'buy_price' => $buy_price,
				'status' => 0,
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$this->db->insert('purchase_return_main_product',$main_data);
			redirect('purchase/purchase_return/'.$dis_id);
		}
	}

	public function removeProduct()
	{
		$prmp_id = $this->input->post('prmp_id');
		$this->db->where('prmp_id', $prmp_id);
		$data=$this->db->get('purchase_return_main_product')->row(); 

		$this->db->set('stock_amount', 'stock_amount+' . $data->return_quantity, FALSE);
		$this->db->where('product_id', $data->produ_id);
		$this->db->update('bulk_stock_info');

		$this->db->select('*');
		$this->db->from('purchase_return_warranty_product');
		$this->db->where('purchase_return_warranty_product.status="'.$zero.'"');
		$query2 = $this->db->get();

		if($query2->num_rows() > 0)
		{
			foreach($query2->result() as $tmp2)
			{
				$this->db->where('ip_id', $tmp2->ip_id);
				$this->db->where('product_id', $tmp2->product_id);
				$this->db->set('status',1);
				$this->db->update('warranty_product_list');
			}
			
		}


		$this->db->where('prmp_id', $prmp_id);
		$this->db->delete('purchase_return_main_product'); 
		$this->db->where('prmp_id', $prmp_id);
		$this->db->delete('purchase_return_warranty_product'); 
		echo json_encode(true);
	}

	public function final_purchase_return()
	{
		$bd_date=date('Y-m-d');
		$creator = $this->tank_auth->get_user_id();
		$zero = 0;
		$this->db->select('purchase_return_main_product.*,SUM(return_quantity*buy_price) as total_return');
		$this->db->from('purchase_return_main_product');
		$this->db->where('purchase_return_main_product.status="0"');
		$query3 = $this->db->get();
		$tmp3 = $query3->row();
		$transaction_info = array
		(
		   'transaction_id'         			=> '',
		   'transaction_purpose'                => 'purchase_return',
		   'transaction_mode'                 	=> '',
		   'ledger_id'         					=> $tmp3->distri_id,
		   'common_id'         					=> '',
		   'amount'     						=> $tmp3->total_return,
		   'date'                   			=> date('Y-m-d'),
		   'status'        						=> 'active',
		   'creator'        					=> $creator,
		   'doc'   								=> $bd_date,
		   'dom'    							=> $bd_date
		);
		$this->db->insert('transaction_info', $transaction_info);
		$this->db->select('*');
		$this->db->from('purchase_return_main_product');
		$this->db->where('purchase_return_main_product.status="0"');
		$query1 = $this->db->get();
		$i=1;
		$data['alll']=$query1;
		foreach($query1->result() as $tmp1)
		{
			$this->db->set('status', 'status+' . 1, FALSE);
			$this->db->where('status="'.$zero.'"');
			$this->db->where('prmp_id', $tmp1->prmp_id);
			$this->db->where('produ_id', $tmp1->produ_id);
			$this->db->update('purchase_return_main_product');
			 $i++;
		}

		$this->db->select('*');
		$this->db->from('purchase_return_warranty_product');
		$this->db->where('purchase_return_warranty_product.status="'.$zero.'"');
		$query2 = $this->db->get();
		
		
		if($query2->num_rows() > 0)
		{
			$ii=1;
			foreach($query2->result() as $tmp2)
			{
				$this->db->where('ip_id', $tmp2->ip_id);
				$this->db->where('product_id', $tmp2->product_id);
				$this->db->delete('warranty_product_list');
				
				$this->db->set('status', 'status+' . 1, FALSE);
				$this->db->where('status="'.$zero.'"');
				$this->db->where('prwp_id', $tmp2->prwp_id);
				$this->db->where('prmp_id', $tmp2->prmp_id);
				$this->db->where('ip_id', $tmp2->ip_id);
				$this->db->where('product_id', $tmp2->product_id);
				$this->db->update('purchase_return_warranty_product');
				$ii++;
			}
			
		}
		$this->__renderviewprint('Prints/invoices/purchase_return_invoice', $data);
	}
}
