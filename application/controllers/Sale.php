<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Sale extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$this->load->model('sale_model');
		$this->load->model('customer_model');
		$this->load->model('bankcard_model');
		$data['user_type'] = $this->tank_auth->get_usertype();
		if(!$this->access_control_model->my_access($data['user_type'], 'sale', ''))
		{
			redirect('admin/noaccess');
		}
	}

	public function is_logged_in() {
        if(!$this->tank_auth->is_logged_in()) {
            redirect('auth/login');
        }
	}

	public function addNewSale()
    {
		$data['sale_id'] = $this->sale_model->createNewSale($this->tank_auth->get_user_id(), $this->tank_auth->get_shop_id());
		$this->tank_auth->set_current_temp_sale( $data['sale_id'] );
		$this->load->view("Sale/addNewSale", $data);
    }

    public function setCurrentSale()
    {
    	$this->tank_auth->set_current_temp_sale($this->input->post('id'));
    	$data['tmp_item']   = $this->sale_model->getAllTmpProduct($this->input->post('id'));
    	$number             = 0;
        $data['in_word']    = "";
        if($data['tmp_item'] != FALSE)
        {
            foreach ($data['tmp_item']->result() as $tmp)
            {
                $number += ($tmp->unit_sale_price * $tmp->sale_quantity);
            }
            $VAT 	= ($number * 10) / 100;
            $number += $VAT;
        }
        $number = round($number);
        if($number != 0){
        	$data['in_word']    = $this->convert_number_to_words($number) . " (TK)"; 
        }
    	$this->load->view('Sale/setCurrentSale', $data);
    }

    public function search_product2()
    {
		$data['current_sale'] 	= '';        
        $data['current_sale'] 	= $this->tank_auth->get_current_temp_sale();
        if($data['current_sale'] != ''){
            $key=$this->input->post('term');
            $data 	= $this->sale_model->search_product($key);
            $info=[];
            if(count($data)>0){
				foreach($data as $tmp){
					if($tmp->stock_amount == '')$stock = 0;
					else $stock = $tmp->stock_amount;
					$info[] = array(
						'id' 						=> $tmp->product_id,
						'product_name' 				=> $tmp->product_name,
						'company_name' 				=> $tmp->company_name,
						'catagory_name' 			=> $tmp->catagory_name,
						'product_size' 				=> $tmp->product_size,
						'product_model' 			=> $tmp->product_model,
						'mrp_price' 				=> $tmp->bulk_unit_sale_price,
						'sale_price' 				=> $tmp->general_unit_sale_price,
						'buy_price' 				=> $tmp->bulk_unit_buy_price,
						'stock' 					=> $stock,
						'generic_name' 				=> $tmp->group_name,
						'barcode' 					=> $tmp->barcode,
						'product_specification' 	=> $tmp->product_specification,
						'temp_pro_data' 			=> $tmp->product_id . '<>' . 
													   $tmp->product_name . '<>' .
													   $tmp->stock_amount . '<>' .
													   $tmp->general_unit_sale_price . '<>' .
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
					'product_size' 				=> '',
					'product_model' 			=> '',
					'mrp_price' 				=> '',
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

    public function search_product_warranty()
    {
		$data['current_sale'] 	= '';        
        $data['current_sale'] 	= $this->tank_auth->get_current_temp_sale();
        if($data['current_sale'] != '')
        {
            $key			= $this->input->post('term');
            $flag 			= (int)$this->input->post('flag');

			$barcode 	= $this->input->post('barcode');
			$num_of_tr 	= $this->input->post('num_of_tr');

			if($barcode != '')
			{
				$tmp_data = $this->sale_model->search_warranty_product_and_add_to_my_list($barcode);
				$info=[];
	            if(count($tmp_data)>0){
					foreach($tmp_data as $tmp){
						$info[] = array(
							'id' 						=> $tmp->product_id,
							'product_name' 				=> $tmp->product_name,
							'company_name' 				=> $tmp->company_name,
							'catagory_name' 			=> $tmp->catagory_name,
							'product_size' 				=> $tmp->product_size,
							'product_model' 			=> $tmp->product_model,
							'mrp_price' 				=> $tmp->bulk_unit_sale_price,
							'sale_price' 				=> $tmp->general_unit_sale_price,
							'buy_price' 				=> $tmp->bulk_unit_buy_price,
							'stock' 					=> 1,
							'generic_name' 				=> $tmp->group_name,
							'barcode' 					=> $tmp->barcode,
							'product_specification' 	=> $tmp->product_specification,
							'temp_pro_data' 			=> $tmp->product_id . '<>' . 
														   $tmp->product_name . '<>' .
														   $tmp->stock_amount . '<>' .
														   $tmp->general_unit_sale_price . '<>' .
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
						'product_size' 				=> '',
						'product_model' 			=> '',
						'mrp_price' 				=> '',
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
    }

	public function new_sale()
	{
		$this->load->config('custom_config');
		$data['user_type'] 		= $this->tank_auth->get_usertype();
		$data['user_name'] 		= $this->tank_auth->get_username();
		$data['bd_date'] 		= date ('Y-m-d');
		$data['previous_date'] 	= date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 30, date("y")));
		$data['sales'] 			= $this->sale_model->getAllSale($this->tank_auth->get_user_id(), $this->tank_auth->get_shop_id());
		$data['current_sale'] 	= $this->tank_auth->get_current_temp_sale();
		$value_added_tax 		= $this->config->item('VAT');
		$tmp_customer_info 		= "";  
		$data['current_sale_customer'] 	= $this->sale_model->get_current_sale_customer($data['current_sale']);
        $data['sale_invoice_status'] 	= $this->sale_model->get_current_sale_invoice_status($data['current_sale']);
        $data['customer_info'] 	= $this->customer_model->all();
        $data['card_info'] 	= $this->bankcard_model->cardall();
		$data['tmp_item']   		= $this->sale_model->getAllTmpProduct($this->tank_auth->get_current_temp_sale());
		$data['return_id'] 			= $this->sale_model->getReturnId($this->tank_auth->get_current_temp_sale());
		$data['return_adjust'] 		= $this->sale_model->getReturnAdjustAmount($this->tank_auth->get_current_temp_sale());
        $number             		= 0;
        $data['in_word']    		= "";
        if($data['tmp_item'] != FALSE)
        {
            foreach ($data['tmp_item']->result() as $tmp)
            {
                $number += ($tmp->unit_sale_price * $tmp->sale_quantity);
            }
            $VAT 	= ($number * $value_added_tax) / 100;
            $number += $VAT;
            $number = round($number);
        }
        if($number != 0)$data['in_word']    = $this->convert_number_to_words($number) . " (TK)";
        
        $tmp_sale_return_id 	= $this->tank_auth->get_current_sale_return_id();
        $tmp_current_sale_id 	= $this->tank_auth->get_current_temp_sale();

        $data['sale_return_info'] = $this->sale_model->getAllSaleReturnProduct($tmp_sale_return_id, $tmp_current_sale_id);
		$data['vuejscomp'] = 'new_sale.js';
		$this->__renderview('Sale/new_sale',$data);
	}

    public function convert_number_to_words( $number )
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
	
    public function doSale()
    {	
        $current_sale_id 	   		= $this->tank_auth->get_current_temp_sale();
		$current_sale_return_id 	= $this->tank_auth->get_current_sale_return_id();
		$creator 			   		= $this->tank_auth->get_user_id(); 
    	$discount_in_percentage 	= (Float)$this->input->post('disc_in_p');
    	$discount_in_f          	= (Float)$this->input->post('disc_in_f');
    	$discount               	= 0;
    	$discount_type          	= 0;
    	$vat                    	= (Float)$this->input->post('vat');     
        if($discount_in_percentage != ''){ 
            $discount       = $discount_in_percentage; 
            $discount_type  = 2; 
        }
        else if($discount_in_f != ''){
            $discount       = $discount_in_f;
            $discount_type  = 1;
        }
        $customer_id    = (int)$this->input->post('customer_id');
		if($customer_id=='')
		{
			$customer_id=1;
		} 
		else
		{
			$customer_id = $customer_id;
		}
		$sub_total      = (Float)$this->input->post('sub_total');                 // (included vat) 
        $cash_commision = (Float)$discount;
        $disc_amount    = (Float)$this->input->post('disc_amount');
        $grand_total    = (Float)$this->input->post('total_');
        $total_paid     = (Float)$this->input->post('received');
        $delivery_charge     = (Float)$this->input->post('delivery_charge');
        $return_money   = (Float)$this->input->post('change');
        $payable   		= (Float)$this->input->post('payable');
        $flg            = (Float)$this->input->post('flg');
        $customer_name  = (string)$this->input->post('customer_name');
        $customer_phn   = (string)$this->input->post('customer_phn');
        $return_adjust 	= (Float)$this->input->post('return_adjust');
        $return_id 		= $this->input->post('return_id');

        if($return_money < 0){ $return_money = 0; }
		
        $invoice_id = $this->sale_model->doInvoiceInfoTask($customer_id, $sub_total, $cash_commision, $disc_amount, $discount_type, $grand_total, $total_paid, $return_money,$return_adjust,$payable,$delivery_charge);
		
        $products = $this->sale_model->getAllTmpProduct($this->tank_auth->get_current_temp_sale());
		$products_warranty = $this->sale_model->getAllTmpProduct_warranty($this->tank_auth->get_current_temp_sale());

        if($products != FALSE)
        {
            $this->sale_model->doSaleDetailsTask($invoice_id, $products, $cash_commision,$disc_amount, $discount_type);         
            $this->sale_model->transactioninfo_cashbook($invoice_id,$customer_id, $grand_total, $total_paid,$return_adjust,$payable,$return_id,$delivery_charge);
            $this->sale_model->deleteDataFromTmpSaleInfoAndTmpSaleDetails($current_sale_id, $current_sale_return_id, $creator);
            $this->tank_auth->unset_current_temp_sale();
            $this->tank_auth->unset_current_sale_return_id();
            echo $invoice_id;     
        }
        else
		{
            echo 'Nothing Found';
        }
    }
    
	public function removeProduct()
    {
		$pro_id 				= $this->input->post('product_id');
		$qnty 					= $this->input->post('Quantity');
		$currrent_temp_sale_id 	= $this->tank_auth->get_current_temp_sale();
		$d = $this->sale_model->removeProduct($pro_id, $currrent_temp_sale_id, $qnty);
		echo json_encode($d);
		echo $pro_id . "  " . $qnty . " " . $currrent_temp_sale_id;
    }

	public function select_active_sale()
    {
		$d = $this->sale_model->select_active_sale();
		$this->tank_auth->set_current_temp_sale($d);
		echo $d;
    }

    public function getIndiVidualProduct_warranty_new()
	{
		$pro_id = $this->input->post('product_id');
		$this->db->select('ip_id,sl_no');
		$this->db->from('warranty_product_list');
		$this->db->where('product_id',$pro_id);
		$this->db->where('status',1);
		$query = $this->db->get();
		echo json_encode($query->result());
	}

	public function getIndiVidualProduct_warranty()
	{
		$pro_id = $this->input->post('product_id');
		
		$this->db->select('ip_id,sl_no');
		$this->db->from('warranty_product_list');
		$this->db->where('product_id',$pro_id);
		$this->db->where('status=2');
		$query1 = $this->db->get();
		$this->db->select('ip_id,sl_no');
		$this->db->from('warranty_product_list');
		$this->db->where('product_id',$pro_id);
		$this->db->where('status !=3' );
		$query2 = $this->db->get();
		$temp1 =array();
		$temp2 =array();
		$temp1 =$query1->result_array();
		$temp2 =$query2->result_array();
		echo json_encode(array('selected_data'=>$temp1,'all_data'=>$temp2));
	}

	public function new_active_sale_with_salereturn()
    {
		$return_amount = $this->uri->segment(3);
		$d = $this->sale_model->new_active_sale_with_salereturn($return_amount);
		$this->tank_auth->set_current_temp_sale( $d);
		redirect('sale/new_sale');
    }

	public function doSale_credit()
    {
        $current_sale_id 	   		= $this->tank_auth->get_current_temp_sale();
		$current_sale_return_id 	= $this->tank_auth->get_current_sale_return_id();
		$creator 			   		= $this->tank_auth->get_user_id(); 
    	$discount_in_percentage 	= (Float)$this->input->post('disc_in_p');
    	$discount_in_f          	= (Float)$this->input->post('disc_in_f');
    	$discount               	= 0;
    	$discount_type          	= 0;
    	$vat                    	= (Float)$this->input->post('vat');
               
        if($discount_in_percentage != ''){ 
            $discount       = $discount_in_percentage; 
            $discount_type  = 2; 
        }
        else if($discount_in_f != ''){
            $discount       = $discount_in_f;
            $discount_type  = 1;
        }
        $customer_id    = (int)$this->input->post('customer_id');
        $sub_total      = (Float)$this->input->post('sub_total');                 // (included vat) 
        $cash_commision = (Float)$discount;
        $disc_amount    = (Float)$this->input->post('disc_amount');
        $grand_total    = (Float)$this->input->post('total_');
        $total_paid     = (Float)$this->input->post('received');
		$delivery_charge     = (Float)$this->input->post('delivery_charge');
        $return_money   = (Float)$this->input->post('change');
		$payable   		= (Float)$this->input->post('payable');
        $flg            = (Float)$this->input->post('flg');
        $customer_name  = (string)$this->input->post('customer_name');
        $customer_phn   = (string)$this->input->post('customer_phn');
        $return_adjust 	= (Float)$this->input->post('return_adjust');
		$return_id 		= $this->input->post('return_id');
        if($customer_name != '' && $customer_phn != '')
		{
            $customer_id = $this->sale_model->insertNewCustomer($customer_name, $customer_phn);
        }
        if($return_money < 0){ $return_money = 0; }
        $invoice_id = $this->sale_model->doInvoiceInfoTask_credit($customer_id, $sub_total, $cash_commision, $disc_amount, $discount_type, $grand_total, $total_paid, $return_money, $return_adjust,$payable,$delivery_charge);
        $products = $this->sale_model->getAllTmpProduct($this->tank_auth->get_current_temp_sale());
        if($products != FALSE)
        {
            $this->sale_model->doSaleDetailsTask($invoice_id, $products,$cash_commision, $disc_amount, $discount_type);  
			$this->sale_model->transactioninfo_creditsale($invoice_id,$customer_id, $grand_total,$return_adjust,$return_id,$delivery_charge);				
            $this->sale_model->deleteDataFromTmpSaleInfoAndTmpSaleDetails($current_sale_id, $current_sale_return_id, $creator);
            $this->tank_auth->unset_current_temp_sale();
            $this->tank_auth->unset_current_sale_return_id();
            echo $invoice_id;
                    
        }
        else{
            echo 'Nothing Found';
        }
    }
	
	public function doSale_card()
    {
        $current_sale_id 	   		= $this->tank_auth->get_current_temp_sale();
		$current_sale_return_id 	= $this->tank_auth->get_current_sale_return_id();
		$creator 			   		= $this->tank_auth->get_user_id(); 
    	$discount_in_percentage 	= (Float)$this->input->post('disc_in_p');
    	$discount_in_f          	= (Float)$this->input->post('disc_in_f');
    	$discount               	= 0;
    	$discount_type          	= 0;
    	$vat                    	= (Float)$this->input->post('vat');
               
        if($discount_in_percentage != '')
		{ 
            $discount       = $discount_in_percentage; 
            $discount_type  = 2; 
        }
        else if($discount_in_f != '')
		{
            $discount       = $discount_in_f;
            $discount_type  = 1;
        }
		
        $customer_id    = (int)$this->input->post('customer_id');
        $bank_id    	= (int)$this->input->post('bank_id');
        $sub_total      = (Float)$this->input->post('sub_total');                 // (included vat) 
        $cash_commision = (Float)$discount;
        $disc_amount    = (Float)$this->input->post('disc_amount');
        $grand_total    = (Float)$this->input->post('total_');
        $total_paid     = (Float)$this->input->post('received');
        $delivery_charge   = (Float)$this->input->post('delivery_charge');
        $return_money   = (Float)$this->input->post('change');
        $flg            = (int)$this->input->post('flg');
        $card_id  		= (string)$this->input->post('card_id');
        $customer_name  = (string)$this->input->post('customer_name');
        $customer_phn   = (string)$this->input->post('customer_phn');
        $return_adjust 	= (Float)$this->input->post('return_adjust');
        $payable 	= (Float)$this->input->post('payable');
		$return_id 		= $this->input->post('return_id');

        if($customer_name != '' && $customer_phn != '')
		{
            $customer_id = $this->sale_model->insertNewCustomer($customer_name, $customer_phn);
        }
       
        if($return_money < 0){ $return_money = 0; }
		if($customer_id==''){
			$customer_id = 1;
		}
        $invoice_id = $this->sale_model->doInvoiceInfoTask_card($customer_id, $sub_total, $cash_commision, $disc_amount, $discount_type, $grand_total, $total_paid, $return_money, $return_adjust,$payable,$delivery_charge);
		
        $products = $this->sale_model->getAllTmpProduct($current_sale_id);

        if($products != FALSE)
        {
            $this->sale_model->doSaleDetailsTask($invoice_id, $products,$cash_commision, $disc_amount, $discount_type);         
			$this->sale_model->transactioninfo_cardsale($invoice_id,$customer_id, $grand_total,$total_paid, $bank_id,$card_id,$return_adjust,$payable,$return_id,$delivery_charge);
            $this->sale_model->deleteDataFromTmpSaleInfoAndTmpSaleDetails($current_sale_id, $current_sale_return_id, $creator);
            $this->tank_auth->unset_current_temp_sale();
            $this->tank_auth->unset_current_sale_return_id();
            echo $invoice_id;
                    
        }
        else
		{
            echo 'Nothing Found';
        }
    }
            
    public function cancelSale()
    {
    	$current_sale_id 	   		= $this->tank_auth->get_current_temp_sale();
		$creator 			   		= $this->tank_auth->get_user_id();

		$datddd=$this->db->get('temp_sale_info')->result();
		if(count($datddd)>1){
        	$this->sale_model->cancelSale($current_sale_id, $creator);
    	}

        $this->tank_auth->unset_current_temp_sale();
        $this->tank_auth->unset_current_sale_return_id();
    }

	public function cancelcashSalereturn()
    {
        $this->sale_model->cancelcashSalereturn();
    }

    public function updateTmpProduct()
    {
    	$stripped_data  = explode("<>", $this->input->post('tmp_data'));
    	$product_id 	= (int)$stripped_data[0];
    	$new_qnty 		= (Float)$this->input->post('quty');
    	$pro_qnty 		= (Float)$this->input->post('pro_qnty');
    	$actual_price 	= (Float)$this->input->post('price');
    	$stock 			= (int)$stripped_data[2] - $pro_qnty;
    	$this->sale_model->updateTmpProduct($product_id, $new_qnty, $actual_price, $stock);
    	$this->sale_model->updateStock($product_id, $stock);
    	echo $stock;
    }

    /* Ending: searchProductForSaleReturn() */
	public function get_invoice_product_list() 
	{
		$invoice = $this->input->post('invoice');
		$temp = array();
		$invoice_ledgers_balance = array();
		$invoice_ledgers_sale = array();
		$temp = $this -> sale_model -> get_invoice_product_list($invoice);
		$temp = $temp->result_array();
		$this->db->select('transaction_info.ledger_id');
		$this->db->from('transaction_info');
		$this->db->where('transaction_info.common_id',$invoice);
		$query = $this->db->get();
		$field = $query->row();
		$ledger_id = $field->ledger_id;
		$invoice_ledgers_balance = $this->sale_model->get_invoice_ledger_balance_amount($ledger_id);
		$invoice_ledgers_balance = $invoice_ledgers_balance->result_array();
		$invoice_ledgers_sale = $this->sale_model->get_invoice_ledger_sale_amount($ledger_id);
		$invoice_ledgers_sale = $invoice_ledgers_sale->result_array();
		$invoice_ledgers_sale_return = $this->sale_model->get_invoice_ledger_sale_return_amount($ledger_id);
		$invoice_ledgers_sale_return = $invoice_ledgers_sale_return->result_array();
		$i=0;
		foreach($temp as $field)
		{
			
			$all_sale_amount = $this->sale_model->get_invoice_sale_amount($invoice);
			$temp[$i]['sale_amount_name'] = $all_sale_amount->result_array();
			
			$all_collection_amount = $this->sale_model->get_invoice_collection_amount($invoice);
			$temp[$i]['collection_amount_name'] = $all_collection_amount->result_array();
			
			$all_sale_return_amount = $this->sale_model->get_invoice_sale_return_amount($invoice);
			$temp[$i]['return_amount_name'] = $all_sale_return_amount->result_array();
			$i++;
		}
		
		echo json_encode(array("product_report"=>$temp,"balance"=>$invoice_ledgers_balance,"sale"=>$invoice_ledgers_sale,"sale_return"=>$invoice_ledgers_sale_return));
	}

	public function get_invoice_product_list2() 
	{
		$invoice = $this->input->post('invoice');
		$temp = $this -> sale_model -> get_invoice_product_list2($invoice);
		echo json_encode($temp->result());
	}

	public function get_product_list() 
	{
		$product = $this -> sale_model -> get_product_list();
		echo json_encode($product);
	}

	public function get_product_list2() 
	{
		$product = $this -> sale_model -> get_product_list2();
		echo json_encode($product);
	}

    /* Starting: addToSaleReturn*/
    public function addToSaleReturn()
    {
    	$data['id'] 			= $this->input->post('pro_id');
    	$data['product_name'] 	= $this->input->post('pro_name');
    	$data['unit_price'] 	= $this->input->post('unit_price');
    	$data['buy_pric'] 	= $this->input->post('buy_pric');
    	$data['qnty'] 			= $this->input->post('qnty');
    	$data['invoice'] 		= $this->input->post('invoice');
    	$sale_return_id 		= $this->tank_auth->get_current_sale_return_id();
    	
    	$this->sale_model->addToSaleReturn($data['id'], $data['product_name'], $data['unit_price'],$data['buy_pric'], $data['qnty'], $data['invoice'], $sale_return_id);
    	$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
    }

	public function addToCashSaleReturn()
    {
    	$data['id'] 			= $this->input->post('pro_id');
    	$data['product_name'] 	= $this->input->post('pro_name');
    	$data['unit_price'] 	= $this->input->post('unit_price');
    	$data['buy_pric'] 	= $this->input->post('buy_pric');
    	$data['qnty'] 			= $this->input->post('qnty');
    	$data['invoice'] 		= $this->input->post('invoice');
    	$sale_return_id 		= $this->input->post('sale_return_id');
    	
    	$this->sale_model->addToCashSaleReturn($data['id'], $data['product_name'], $data['unit_price'],$data['buy_pric'], $data['qnty'], $data['invoice'], $sale_return_id);
    }

	public function return_sale()
	{
		$data['tmp_sale_return_id'] 	= $this->sale_model->get_direct_sale_return_id();
		$tmp_sale_return_id 	= $this->sale_model->get_direct_sale_return_id();
		$data['sale_return_info'] = $this->sale_model->getAllSaleReturnProduct_direct($tmp_sale_return_id);
		$data['user_type'] 		= $this -> tank_auth -> get_usertype();
		$data['user_name'] 		= $this -> tank_auth -> get_username();
		$data['bd_date'] 		= date ('Y-m-d');
		$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
	}

	public function addProductToSale()
	{
		$stripped_data  = explode("<>", $this->input->post('temp_data'));
        $view_array                          	= array();
        $view_array['product_id']            	= $stripped_data[0];
        $view_array['product_name']          	= $stripped_data[1];
		$view_array['pro_mrp_price']            = round($stripped_data[3]);
        $view_array['sale_price']            	= round($stripped_data[3]);
        $view_array['buy_price']             	= $stripped_data[4];
        $view_array['product_specification'] 	= $stripped_data[5];
        $view_array['product_stock']         	= $stripped_data[2] - $this->input->post('pro_quantity');
        $view_array['pro_quantity']          	= $this->input->post('pro_quantity');
        $view_array['num_of_row']               = $this->input->post('num_of_row');
        $currrent_temp_sale_id = $this->session->userdata('currrent_temp_sale_id');
        $this->sale_model->addProductToSale($view_array['product_id'], $view_array['product_name'], 
                										$view_array['sale_price'],$view_array['pro_mrp_price'], $view_array['buy_price'], 
                										$view_array['product_specification'], $view_array['pro_quantity'], 
                										$view_array['product_stock'], $currrent_temp_sale_id);
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $view_array);     
	}

	public function change_sale_quantity2()
	{
		if($this -> sale_model -> change_sale_quantity2())
		{
			echo 'success';
		}
		else
		{
			echo 'error';
		}
	}

	public function doQuotation()
	{
		$number_of_product 		= $this->input->post('number_of_product');
		if(is_numeric($number_of_product) && $number_of_product !='' && $this->tank_auth->get_current_temp_sale() != ''){
			echo 1;
		}
		else{
			echo 0;
		}
	}

	public function printQuotation()
	{	
		$data['date'] 		= date ('Y-m-d');
		$data['creator'] 	= $this->tank_auth->get_user_id();
		$current_sale_id 	   		= $this->tank_auth->get_current_temp_sale();
		$current_sale_return_id 	= $this->tank_auth->get_current_sale_return_id();
		$creator 			   		= $this->tank_auth->get_user_id();
		$this->tank_auth->unset_current_temp_sale();
		if($this->uri->segment(3) == 1)
		{	
			$data['listed_product']  	= $this->sale_model->getAllTmpProduct($current_sale_id);
			$this->sale_model->cancelSale($current_sale_id, $current_sale_return_id, $creator);
			$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
		}
		else show_404();
	}
}
