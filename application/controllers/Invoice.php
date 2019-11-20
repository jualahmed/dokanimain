<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class invoice extends CI_controller{

    public function __construct(){
		parent::__construct();
		$this->is_logged_in();
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
				$data['in_word'] 	= $this->convert_number_to_words($number->grand_total);
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
				$data['in_word'] 	= $this->convert_number_to_words($number->total_return_amount) . " (TK)";

				$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
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
				$data['in_word'] 	= $this->convert_number_to_words($number->total_return_amount) . " (TK)";

				$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
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
				$data['in_word'] 	= $this->convert_number_to_words($number->amount) . " (TK)";

				$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
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
				$data['in_word'] 	= $this->convert_number_to_words($number->grand_total) . " (TK)";

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
				$data['in_word'] 	= $this->convert_number_to_words($number->grand_total) . " (TK)";

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
				$data['in_word'] 	= $this->convert_number_to_words($number->grand_total) . " (TK)";

				$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
			}
			else{
				echo 'NOTHING FOUND!!!';
			}
    	}
    	else show_404();
    }

    public function convert_number_to_words($number)
	{
	    $hyphen      = '-';
	    $conjunction = ' AND ';
	    $separator   = ', ';
	    $negative    = 'NEGATIVE ';
	    $decimal     = ' POINT ';
	    $dictionary  = array(
	        0                   => 'ZERO',
	        1                   => 'ONE',
	        2                   => 'TWO',
	        3                   => 'THREE',
	        4                   => 'FOUR',
	        5                   => 'FIVE',
	        6                   => 'SIX',
		    7                   => 'SEVEN',
		    8                   => 'EIGHT',
		    9                   => 'NINE',
		    10                  => 'TEN',
		    11                  => 'ELEVEN',
		    12                  => 'TWELVE',
		    13                  => 'THIRTEEN',
		    14                  => 'FOURTEEN',
		    15                  => 'FIFTEEN',
		    16                  => 'SIXTEEN',
		    17                  => 'SEVENTEEN',
		    18                  => 'EIGHTEEN',
		    19                  => 'NINETEEN',
		    20                  => 'TWENTY',
		    30                  => 'THIRTY',
		    40                  => 'FOURTY',
		    50                  => 'FIFTY',
		    60                  => 'SIXTY',
		    70                  => 'SEVENTY',
		    80                  => 'EIGHTY',
		    90                  => 'NINETY',
		    100                 => 'HUNDRED',
		    1000                => 'THOUSAND',
		    1000000             => 'MILLION',
		    1000000000          => 'BILLION',
		    1000000000000       => 'TRILLION',
		    1000000000000000    => 'QUADRILLION',
		    1000000000000000000 => 'QUINTILLION'
	    );
	   
	    if (!is_numeric($number)) {
	        return false;
	    }
	   
	    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
	        // overflow
	        trigger_error(
	            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
	            E_USER_WARNING
	        );
	        return false;
	    }
	
	    if ($number < 0) {
	        return $negative . $this->convert_number_to_words(abs($number));
	    }
	   
	    $string = $fraction = null;
	   
	    if (strpos($number, '.') !== false) {
	        list($number, $fraction) = explode('.', $number);
	    }
	   
	    switch (true) {
	        case $number < 21:
	            $string = $dictionary[$number];
	            break;
	        case $number < 100:
	            $tens   = ((int) ($number / 10)) * 10;
	            $units  = $number % 10;
	            $string = $dictionary[$tens];
	            if ($units) {
	                $string .= $hyphen . $dictionary[$units];
	            }
	            break;
	        case $number < 1000:
	            $hundreds  = $number / 100;
	            $remainder = $number % 100;
	            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
	            if ($remainder) {
	                $string .= $conjunction . $this->convert_number_to_words($remainder);
	            }
	            break;
		    default:
		        $baseUnit = pow(1000, floor(log($number, 1000)));
		        $numBaseUnits = (int) ($number / $baseUnit);
		        $remainder = $number % $baseUnit;
		        $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
		        if ($remainder) {
		            $string .= $remainder < 100 ? $conjunction : $separator;
		            $string .= $this->convert_number_to_words($remainder);
		        }
		            break;
		}
		   
		if (null !== $fraction && is_numeric($fraction)) {
		    $string .= $decimal;
		    $words = array();
		    foreach (str_split((string) $fraction) as $number) {
		        $words[] = $dictionary[$number];
		    }
		    $string .= implode(' ', $words);
		}
                    
		return $string;
	}
}