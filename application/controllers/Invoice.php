<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class invoice extends CI_controller{

    public function __construct(){
		parent::__construct();
		$this->is_logged_in();
		$this->load->library('numbertoword');
	}

	public function is_logged_in() {
   		if(!$this->tank_auth->is_logged_in()) {
       		redirect('auth/login');
   		}
	}
	
	// sale invoice
    public function index()
    {
    	$this->load->config('custom_config'); 
    	if(is_numeric($data['invoice_id'] = $this->uri->segment(3)))
    	{	
	    	$data['invoice_id'] = abs($data['invoice_id']);		
	    	$data['sale_info'] 	= $this->sale_model->getSoldProducts($data['invoice_id']);
			$data['sale_warranty_info'] 	= $this->sale_model->getSoldProducts_warranty($data['invoice_id']);
			if($data['sale_info'] != false)
			{
				$number 			= $data['sale_info']->row();
				$data['receipt_sale_total_amount'] = $this->sale_model->receipt_sale_total_amount($number->customer_id,$data['invoice_id']);
				$data['in_word'] 	= $this->numbertoword->convert_number_to_words($number->grand_total);
				$this->load->view('Prints/invoices/saleinvoice', $data);
			}
			else{
				echo 'NOTHING FOUND!!!';
			}
    	}
    	else show_404();
    }

	public function sale_return()
    {
    	if(is_numeric($data['return_invoice_id'] = $this->uri->segment(3)))
    	{	
	    	$data['return_invoice_id'] = abs($data['return_invoice_id']);		
	    	$data['sale_return_info'] 	= $this->sale_model->getreturnProducts($data['return_invoice_id']);
			
			if($data['sale_return_info'] != false)
			{
				$number 			= $data['sale_return_info']->row();
				$data['in_word'] 	= $this->numbertoword->convert_number_to_words($number->total_return_amount) . " (TK)";

				$this->load->view('Prints/invoices/sale_return', $data);
			}
			else{
				echo 'NOTHING FOUND!!!';
			}
    	}
    	else show_404();
    }

	public function purchase_return()
    {
    	if(is_numeric($data['return_invoice_id'] = $this->uri->segment(3)))
    	{	
	    	$data['return_invoice_id'] = abs($data['return_invoice_id']);		
	    	$data['purchase_return_info'] 	= $this->purchase_model->getreturnProducts($data['return_invoice_id']);
			
			if($data['purchase_return_info'] != false)
			{
				$number 			= $data['purchase_return_info']->row();
				$data['in_word'] 	= $this->numbertoword->convert_number_to_words($number->total_return_amount) . " (TK)";

				$this->load->view('Prints/invoices/purchase_return', $data);
			}
			else{
				echo 'NOTHING FOUND!!!';
			}
    	}
    	else show_404();
    }
	
	public function collection_payment_invoice()
    {
    	if(is_numeric($data['transaction_id'] = $this->uri->segment(3)))
    	{	
	    	$data['transaction_id'] = abs($data['transaction_id']);	
			$data['receipt_type'] = $this->uri->segment(4);			
	    	$data['collection_payment_info'] 	= $this->account_model->collection_payment_invoice($data['transaction_id'],$data['receipt_type']);
			if($data['collection_payment_info'] != false)
			{
				$number 			= $data['collection_payment_info']->row();
				$data['in_word'] 	= $this->numbertoword->convert_number_to_words($number->amount) . " (TK)";

				$this->load->view( 'Prints/invoices/collection_payment_invoice', $data);
			}
			else{
				echo 'NOTHING FOUND!!!';
			}
    	}
    	else show_404();
    }

	public function index2()
    {
    	if(is_numeric($data['invoice_id'] = $this->uri->segment(3)))
    	{	
	    	$data['invoice_id'] = abs($data['invoice_id']);			
	    	$data['sale_info'] 	= $this->sale_model->getSoldProducts($data['invoice_id']);
			
			if($data['sale_info'] != false)
			{
				$number 			= $data['sale_info']->row();
				$data['in_word'] 	= $this->numbertoword->convert_number_to_words($number->grand_total) . " (TK)";

				$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
			}
			else{
				echo 'NOTHING FOUND!!!';
			}
    	}
    	else show_404();
    }
	
	public function index3()
    {
    	if(is_numeric($data['invoice_id'] = $this->uri->segment(3)) && is_numeric($data['card_id'] = $this->uri->segment(4)))
    	{	
	    	$data['invoice_id'] = abs($data['invoice_id']);		
	    	$data['card_id'] 	= abs($data['card_id']);		
	    	$data['card_info'] 	= $this->sale_model->getSoldProducts_card($data['card_id'],$data['invoice_id']);
	    	$data['sale_info'] 	= $this->sale_model->getSoldProducts($data['invoice_id']);
			
			if($data['sale_info'] != false)
			{
				$number 			= $data['sale_info']->row();
				$data['in_word'] 	= $this->numbertoword->convert_number_to_words($number->grand_total) . " (TK)";

				$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
			}
			else{
				echo 'NOTHING FOUND!!!';
			}
    	}
    	else show_404();
    }
	
	public function index4()
    {
    	if(is_numeric($data['invoice_id'] = $this->uri->segment(3)))
    	{	
	    	$data['invoice_id'] = abs($data['invoice_id']);		
	    	$data['sale_info'] 	= $this->sale_model->getSoldProducts($data['invoice_id']);
			
			if($data['sale_info'] != false)
			{
				$number 			= $data['sale_info']->row();
				$data['in_word'] 	= $this->numbertoword->convert_number_to_words($number->grand_total) . " (TK)";

				$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
			}
			else{
				echo 'NOTHING FOUND!!!';
			}
    	}
    	else show_404();
    }
}