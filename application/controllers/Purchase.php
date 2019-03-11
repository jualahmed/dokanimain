<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
class Purchase extends CI_controller
{
	
	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		
		
		$this -> shop_id = $this -> tank_auth -> get_shop_id();
		$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		
		$this->is_logged_in();
	}
	/* checking login status */
	public function is_logged_in()
	{
		$this->load->library('tank_auth');
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login','refresh');
		}
	}
	
	/****************************
	 * 2018-01-06
	 * Prasanta Bhattacharjee
	******************************/
	function receipt_setup()
	{
		$data['user_type'] 	= $this->tank_auth->get_usertype();
		$data['user_name'] 	= $this -> tank_auth -> get_username();
		$data['all_bank'] 	= $this -> purchase_model -> get_all_bank();
		$data['distributor_info'] 	= $this -> purchase_model -> distributor_info();
		$data['status'] 	= '';	
		$this -> load -> view('Purchase/purchase_receipt_setup', $data);
	}
	public function newCreatePurchaseReceipt()
	{	
		$data['user_type'] 	= $this->tank_auth->get_usertype();
		$data['user_name'] 	= $this -> tank_auth -> get_username();
		$data['all_bank'] 	= $this -> purchase_model -> get_all_bank();
		$data['distributor_info'] 	= $this -> purchase_model -> distributor_info();
		$data['status'] 	= '';			
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date = date('Y-m-d');

		$data['sale_status'] 		= '';
		$this -> form_validation -> set_rules('distributor_id', 	'Distributor Name',	'required');
		$this -> form_validation -> set_rules('purchase_amt',  		'Purchase Amount',	'required|numeric');
		$this -> form_validation -> set_rules('transport_cst',  	'Transport Cost',	'required|numeric');
		$this -> form_validation -> set_rules('disc', 				'Discount',			'numeric');
		$this -> form_validation -> set_rules('final_amt', 			'Final Amount',		'required|numeric');
		$this -> form_validation -> set_rules('receipt_date', 		'Date',				'required');

		
		$data['bd_date'] 			= $bd_date;
		if($this -> form_validation -> run() ==  FALSE)
		{
			$data['status'] ='error';
			redirect('purchase/receipt_setup/error');
		}
		else
		{
			$distributor_id 	= $this -> input -> post('distributor_id');
			$purchase_amount   	= (float)$this -> input -> post('purchase_amt');
			$transport_cost   	= (float)$this -> input -> post('transport_cst'); 		// 12-0613
			$discount  			= (float)$this -> input -> post('disc'); 				// 12-0613
			$grand_total 		= (float)$this -> input -> post('final_amt');
			$doc 				= date('Y-m-d', strtotime($this->input->post('receipt_date')));
			$creator 			= $this->tank_auth->get_user_id();	
			
			if($data['receipt_id'] = $this->purchase_model->newCreatePurchaseReceipt($distributor_id, $purchase_amount, $transport_cost, $discount, $grand_total, $doc, $creator ))
			{
				$data['status'] = 'success';
				redirect('purchase/receipt_setup/success');
			}
			else
			{
				$data['status'] = 'failed';
				redirect('purchase/receipt_setup/failed');
			}
		}
	}
	function get_all_card()
	{
		$this->db->select('bank_card_info.card_id,bank_card_info.card_name');
		$this->db->from('bank_card_info');
		$this->db->order_by('bank_card_info.card_id','asc');
		$query = $this->db->get();
		echo json_encode($query->result());
	}
	public function newCreateDistributor()
	{
		$timezone 				= "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date 				= date('Y-m-d');
		$data['bd_date'] 		= $bd_date;
		$data['status'] 		= "";
		$data['user_type'] 		= $this->tank_auth->get_usertype();
		$data['user_name'] 		= $this->tank_auth->get_username();
		$name 					= $this->input->post('name');
		$phn 					= $this->input->post('phn');
		$mail 					= $this->input->post('mail');
		$address 				= $this->input->post('address');
		$description 			= $this->input->post('des');
		$int_balance 			= $this->input->post('int_balance');
		
		$exists 				= $this->setup_model->redundancy_check('distributor_info', 'distributor_name', $name);

		if($exists == true)
		{
			echo 'exist';
		}
		else
		{
			$dist_id = $this->purchase_model->create_distributor($name, $phn, $mail, $address, $description, $int_balance);
			if($dist_id !='')
			{
				echo 'success';
			}
			else
			{
				echo 'failed';
			}
		}
	}
	function purchase_return()
	{
		$data['user_type'] 	= $this->tank_auth->get_usertype();
		$data['user_name'] 	= $this -> tank_auth -> get_username();
		$data['all_bank'] 	= $this -> purchase_model -> get_all_bank();
		$data['distributor_info'] 	= $this -> purchase_model -> distributor_info();
		$data['tmp_purchase_return_id'] 	= $this->purchase_model->get_direct_purchase_return_id();
		$tmp_purchase_return_id 	= $this->purchase_model->get_direct_purchase_return_id();
		$data['distributor_id'] 	= $this->purchase_model->get_distributor_purchase_return_id();
		$data['purchase_return_distributor_info'] = $this->purchase_model->getAllPurchaseReturnDistributor($tmp_purchase_return_id);
		$data['purchase_return_info'] = $this->purchase_model->getAllPurchaseReturnProduct($tmp_purchase_return_id);
		$data['status'] 	= '';	
		$this -> load -> view('Purchase/purchase_return', $data);
	}
	public function createPurchaseReturn_direct()
	{
		date_default_timezone_set("Asia/Dhaka");
		$bd_date 		= date ('Y-m-d');
		$tmp_purchase_id 	= $this->input->post('tmp_purchase_id');
		$creator 		= $this->tank_auth->get_user_id(); 
		$shop_id 		= $this->tank_auth->get_shop_id();

		$insert_id = $this->purchase_model->createPurchaseReturn_direct($tmp_purchase_id,$creator, $shop_id, $bd_date);
		$this->tank_auth->set_id_for_purchase_return($insert_id);
		echo $insert_id;
	}
	
	public function addToPurchaseReturn()
	{
		$data['id'] 								= $this->input->post('pro_id');
		$data['product_name'] 						= $this->input->post('pro_name');
		$data['unit_buy_price'] 					= $this->input->post('unit_price');
		$data['qnty'] 								= $this->input->post('qnty');
		$data['distributor_id'] 					= $this->input->post('distributor_id');
		$purchase_return_id 						= $this->tank_auth->get_current_purchase_return_id();
		$tmp_purchase_return_id 					= $this->purchase_model->get_direct_purchase_return_id();
		echo $data['purchase_return_distributor_info'] 	= $this->purchase_model->getAllPurchaseReturnDistributor($tmp_purchase_return_id);
		
		$this->purchase_model->addToPurchaseReturn($data['id'], $data['product_name'], $data['unit_buy_price'], $data['qnty'], $data['distributor_id'], $purchase_return_id);
		$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
	}
	public function doPurchaseReturn()
	{	
		date_default_timezone_set("Asia/Dhaka");
		$bd_date 					= date ('Y-m-d');
		$current_purchase_return_id = $this->purchase_model->get_direct_purchase_return_id();
		$creator 					= $this->tank_auth->get_user_id(); 
		$distributor_id 			= $this->input->post('distributor_id'); 

		$data = $this->purchase_model->doPurchaseReturn($current_purchase_return_id, $creator, $bd_date,$distributor_id);

		if($data != false)
		{
			$this->tank_auth->unset_current_purchase_return_id();
			echo $data;
		}
		//echo $data;
	}
	public function deleteProductFromPurchaseReturn()
	{
		$product_id 		= $this->input->post('pro_id');
		$purchase_return_id = $this->tank_auth->get_current_purchase_return_id();

		$this->purchase_model->deleteProductFromPurchaseReturn($purchase_return_id, $product_id);
		
	}
	
}
