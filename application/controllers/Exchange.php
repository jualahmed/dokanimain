<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
class Exchange extends CI_controller{
	
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

	function exchange_setup()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['sale_status'] = '';
		$data['alarming_level'] = FALSE;
		$data['status'] = '';
		$data['user_name'] = $this->tank_auth->get_username();
		$data['exchange_info'] = $this->exchange_model->get_all_exchange_product();
		$data['product_info'] 	= $this->sale_model->getAllProductInfo();
		$this -> load -> view('Exchange/exchange_setup', $data);
	}
	public function addToExchangeReturn()
	{
		$data['id'] 			= $this->input->post('pro_id');
		$data['product_name'] 	= $this->input->post('pro_name');
		$data['unit_price'] 	= $this->input->post('unit_price');
		$data['qnty'] 			= $this->input->post('qnty');
		$data['status_type'] 	= $this->input->post('status_type');
		
		$this->exchange_model->addToExchangeReturn($data['id'], $data['product_name'], $data['unit_price'], $data['qnty'], $data['status_type']);
		$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
	}
	public function doExchangeReturn()
	{	
		date_default_timezone_set("Asia/Dhaka");
		$bd_date 					= date ('Y-m-d');
		$current_exchange_return_id 	= $this->exchange_model->get_exchange_return_id();
		$creator 					= $this->tank_auth->get_user_id(); 

		$data = $this->exchange_model->doExchangeReturn($current_exchange_return_id, $creator, $bd_date);

		if($data != false)
		{
			echo $data;
		}
	}
	public function deleteExchangeReturn()
	{
		$product_id 					= $this->input->post('pro_id');
		$current_exchange_return_id 	= $this->exchange_model->get_exchange_return_id();
		$this->exchange_model->deleteExchangeReturn($current_exchange_return_id, $product_id);
		echo true;
	}
}
