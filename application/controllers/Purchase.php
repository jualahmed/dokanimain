<<<<<<< HEAD
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
	public function newPurchaseListing()
    {
    	date_default_timezone_set("Asia/Dhaka");
		$bd_date 						= date('Y-m-d');
		$data['user_type'] 				= $this -> tank_auth -> get_usertype();
		$data['user_name'] 				= $this -> tank_auth -> get_username();
		$data['bd_date'] 				= date ('Y-m-d');
		$data['total_amount'] 			= '';
		$data['previous_date'] 			= date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 30, date("y")));
		$data['purchase_receipt_info'] 	= $this -> product_model-> fatch_all_purchase_receipt_id();
		$data['company_name'] 			= $this -> product_model -> company_name();
		$data['catagory_name'] 			= $this -> product_model -> catagory_name();
		$data['product_specification'] 	= $this -> product_model -> product_specification();
		$data['unit_name'] 				= $this -> product_model -> unit_name();
		$data['last_id'] 				= $this -> product_model->getLastInserted();
		$data['distributor_info'] 		= $this -> product_model -> distributor_info();

    	$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
    }
	public function specificPurchaseReceipt()
	{
		$purchase_receipt_id 				= (int)$this->input->post('purchase_receipt_id');

		$data['receipt_general_details'] 	= $this->report_model->specific_purchase_receipt_general( $purchase_receipt_id);
		// $data['purchase_receipt_details'] 	= $this->report_model->specific_purchase_receipt( $purchase_receipt_id);
		$tmp_row 							= $data['receipt_general_details']->row();
		$tmp_data['grand_total'] 			= $tmp_row->grand_total;
		$tmp_data['purchase_amount'] 		= $tmp_row->purchase_amount;
		$tmp_data['total_purchase_amount'] 	= $this->report_model->get_total_purchase_amount($purchase_receipt_id);
		$tmp_data['basic_info'] 			= $this->load->view(__CLASS__ . '/' . __FUNCTION__, $data, true);

		echo json_encode($tmp_data);

	}
	public function getSpecificPurchaseReceiptProduct()
	{
		$purchase_receipt_id 				= (int)$this->input->post('purchase_receipt_id');
		$data['purchase_receipt_details'] 	= $this->report_model->specific_purchase_receipt( $purchase_receipt_id);

		$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
	}
	public function searchProduct_2(){
    	$requested_item 	= $this->input->post('term');
    	$flag 				= (int)$this->input->post('flag');
    	$field_name 		= "";
    	
    	if($flag == 1)$field_name 		= "product_name";
    	else if($flag == 2)$field_name 	= "barcode";
		
    	$data = $this->product_model->search_product($requested_item, $field_name);

    	$info = array();

    	if($data != FALSE){
    		foreach($data->result() as $tmp)
			{
				
				$unit_buy_price = $this->product_model->get_latest_unit_buy_price($tmp->product_id);
				
				
    			$info[] = array(
    				'id' 						=> $tmp->product_id,
    				'name' 						=> $tmp->product_name,
    				'catagory_name' 			=> $tmp->catagory_name,
    				'company_name'				=> $tmp->company_name,
    				'group_name'				=> $tmp->group_name,
    				'bulk_unit_buy_price'		=> $tmp->bulk_unit_buy_price,
    				'unit_buy_price'			=> $unit_buy_price,
    				'bulk_unit_sale_price'		=> $tmp->bulk_unit_sale_price,
    				'general_unit_sale_price'	=> $tmp->general_unit_sale_price,
    				'product_specification'		=> $tmp->new_specification
					
    				);
    		}
    	}
    	else{
    		$info[] = array(
    				'id' 				=> '',
    				'name' 				=> 'Nothing Found...',
    				'catagory_name' 	=> '',
    				'company_name'		=> '',
    				'group_name'		=> '',
					'bulk_unit_buy_price'		=> '',
					'unit_buy_price'			=> '',
    				'bulk_unit_sale_price'		=> '',
    				'general_unit_sale_price'		=> '',
    				'product_specification'		=> ''
    				);
    	}
    	echo json_encode($info);
    }

    /* Ending: searchProduct() */
	
	/* Starting: addProductToList() [old create_purchase()]*/
	public function addProductToList()
	{	
		$pur_recpt_id					= $this->input->post('purchase_receipt_id');
		$pro_name 						= $this->input->post('pro_name');
		$pro_id							= $this->input->post('pro_id');
		$pur_qnty						= $this->input->post('qnty');
		$ex_date						= $this->input->post('ex_date');
		$ttl_buy_pric					= $this->input->post('total_buy_price');
		$gnrl_sal_pric					= $this->input->post('general_sale_price');		// $unit_sale_price
		$unit_buy_pric					= $this->input->post('unit_buy_price');
		$exclu_sal_pric					= $this->input->post('exclusive_sale_price');
		
		$grand_total 					= $this->input->post('grand_total');
		$total_purchase_amount 			= $this->input->post('total_purchase_amount');

		$data['user_type'] 				= 	$this->tank_auth->get_usertype();
		

		$data['purchase_receipt_id']	= $pur_recpt_id;
		$data['product_name']  			= $pro_name;		
		$data['product_id']  			= $pro_id;		
		$data['quantity']  				= $pur_qnty;		
		$data['expaire_date']  			= $ex_date;		
		$data['total_buy_price']  		= $ttl_buy_pric;	
		$data['general_sale_price']  	= $gnrl_sal_pric;	
		$data['unit_buy_price']  		= $unit_buy_pric;
		$data['exclusive_sale_price'] 	= $exclu_sal_pric; 


		if($this->input->post('exclusive_sale_price') == '')$exclu_sal_pric = 0;
		
		//if($this->access_control_model->my_access($data['user_type'], 'product_controller', 'purchase_entry'))
		//{	
			if(is_numeric($pur_qnty) && is_numeric($ttl_buy_pric) && is_numeric($gnrl_sal_pric) && is_numeric($unit_buy_pric) && is_numeric($exclu_sal_pric))
			{	

				$pur_recpt_id 		= (int)$pur_recpt_id;
				$pro_name 			= (string)$pro_name;
				$pro_id 			= (int)$pro_id;
				$pur_qnty 			= abs((float)$pur_qnty);
				$ex_date 			= $ex_date;
				$ttl_buy_pric 		= abs((float)$ttl_buy_pric);
				$gnrl_sal_pric 		= abs((float)$gnrl_sal_pric);
				$unit_buy_pric 		= abs((float)$unit_buy_pric);
				$exclu_sal_pric 	= abs((float)$exclu_sal_pric);

				// $data['purchase_receipt_id']	= $pur_recpt_id;
				// $data['product_name']  			= $pro_name;		
				// $data['product_id']  			= $pro_id;		
				// $data['quantity']  				= $pur_qnty;		
				// $data['expaire_date']  			= $ex_date;		
				// $data['total_buy_price']  		= $ttl_buy_pric;	
				// $data['general_sale_price']  	= $gnrl_sal_pric;	
				// $data['unit_buy_price']  		= $unit_buy_pric;
				// $data['exclusive_sale_price'] 	= $exclu_sal_pric; 
				
				if($query = $this->product_model->newCreatePurchase($pur_recpt_id, $pro_id, $pur_qnty, $unit_buy_pric, $grand_total, $total_purchase_amount))
				{	
					if($query == true)
					{	$lst_purch_id = $this->db->insert_id();
						if($this->product_model->newCreateStock($pur_qnty, $gnrl_sal_pric, $pro_id, $pur_recpt_id, $unit_buy_pric, $lst_purch_id, $exclu_sal_pric))
						{
							$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
						}
					}
					else
					{	$purchase_id = $query;
						
						if($this->product_model->newCreateStock($pur_qnty, $gnrl_sal_pric, $pro_id, $pur_recpt_id, $unit_buy_pric, $purchase_id, $exclu_sal_pric))
						{
							$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
						}
					}
				}
			}	
		//}
	 	//else redirect(''); noaccess

	}
	/* Starting: updateExistsProduct() */
	public function updateExistsProduct()
	{
		$pur_recpt_id					= $this->input->post('purchase_receipt_id');
		$pro_name 						= $this->input->post('pro_name');
		$pro_id							= $this->input->post('pro_id');
		$pur_qnty						= $this->input->post('qnty');
		$ex_date						= $this->input->post('ex_date');
		$ttl_buy_pric					= $this->input->post('total_buy_price');
		$gnrl_sal_pric					= $this->input->post('general_sale_price');		// $unit_sale_price
		$unit_buy_pric					= $this->input->post('unit_buy_price_purchase');
		$exclu_sal_pric					= $this->input->post('exclusive_sale_price');
		$grand_total 					= $this->input->post('grand_total');
		$total_purchase_amount 			= $this->input->post('total_purchase_amount');
		
		$data['user_type'] 				= 	$this->tank_auth->get_usertype();

		if($this->input->post('exclusive_sale_price') == ''){
			$exclu_sal_pric = 0;
		}
		
		//if($this->access_control_model->my_access($data['user_type'], 'product_controller', 'purchase_entry'))
		//{	
			if(is_numeric($pur_qnty) && is_numeric($ttl_buy_pric) && is_numeric($gnrl_sal_pric) && is_numeric($unit_buy_pric) && is_numeric($exclu_sal_pric))
			{	
				$pur_recpt_id 		= (int)$pur_recpt_id;
				$pro_name 			= (string)$pro_name;
				$pro_id 			= (int)$pro_id;
				$pur_qnty 			= abs((float)$pur_qnty);
				$ex_date 			= $ex_date;
				$ttl_buy_pric 		= abs((float)$ttl_buy_pric);
				$gnrl_sal_pric 		= abs((float)$gnrl_sal_pric);
				$unit_buy_pric 		= abs((float)$unit_buy_pric);
				$exclu_sal_pric 	= abs((float)$exclu_sal_pric);

				if($query = $this->product_model->newCreatePurchase($pur_recpt_id, $pro_id, $pur_qnty, $unit_buy_pric, $grand_total, $total_purchase_amount))
				{	
					if($lst_purch_id = $this->db->insert_id())
					{	
						if($this->product_model->newCreateStock($pur_qnty, $gnrl_sal_pric, $pro_id, $pur_recpt_id, $unit_buy_pric, $lst_purch_id, $exclu_sal_pric))
						{
							$this->load->view(__CLASS__ . '/' . __FUNCTION__, $data);
						}
					}
					else if($query != false){
						$purchase_id 	= $query;
						$this->product_model->newCreateStock($pur_qnty, $gnrl_sal_pric, $pro_id, $pur_recpt_id, $unit_buy_pric, $purchase_id, $exclu_sal_pric);
					}
				}
			}
		//}
	}	
	/* Ending 			: updateExistsProduct() */
	/* Starting 		: removeProductFromPurchase() */
	public function removeProductFromPurchase()
	{
		$purchase_receipt_id  	= $this->input->post('purchase_receipt_id');
		$product_id 			= $this->input->post('pro_id');
		
		echo 'OKLLL';
		
		if($purchase_receipt_id != '' && $product_id != '' && is_numeric($purchase_receipt_id) && is_numeric($product_id))
		{	
			$is_accessible 		= $this->access_control_model->my_access($this->tank_auth->get_usertype(), __CLASS__, __FUNCTION__);
			if($is_accessible)
			{
				$this->product_model->removeProductFromPurchase($purchase_receipt_id, $product_id);
				echo 'OKK';
			}
		}
	}
	/* Ending 		: removeProductFromPurchase() */
	/* Starting 		: removeProductFromPurchase_warranty() */
	public function removeProductFromPurchase_warranty()
	{
		$purchase_receipt_id  	= $this->input->post('purchase_receipt_id');
		$ip_id 					= $this->input->post('ip_id');
		$product_id 			= $this->input->post('product_id');
		$unit_buy_price 			= $this->input->post('pro_hide_buy');
		
		echo 'OKLLL';
		
		if($purchase_receipt_id != '' && $ip_id != '' && $product_id != '' && is_numeric($purchase_receipt_id) && is_numeric($ip_id) && is_numeric($product_id))
		{	
			$is_accessible 		= $this->access_control_model->my_access($this->tank_auth->get_usertype(), __CLASS__, __FUNCTION__);
			if($is_accessible)
			{
				$this->product_model->removeProductFromPurchase_warranty($purchase_receipt_id, $ip_id, $unit_buy_price, $product_id);
				echo 'OKK';
			}
		}
	}
	/* Ending 		: removeProductFromPurchase_warranty() */
	/* Starting 		: removeProductFromPurchase_warranty_after_sale_return() */
	public function removeProductFromPurchase_warranty_after_sale_return()
	{
		//$ip_id 	= $this->input->post('ids');
	
		$data 	= $this->product_model->removeProductFromPurchase_warranty_after_sale_return();
		
		
		echo json_encode($data);
	}
	public function update_warranty_after_sale_return()
	{
		//$ip_id 	= $this->input->post('ids');
	
		$data 	= $this->product_model->update_warranty_after_sale_return();
		
		
		echo json_encode($data);
	}
	/* Ending 		: removeProductFromPurchase_warranty_after_sale_return() */
	
	function getIndiVidualProduct_warranty()
	{
		$purchase_receipt_id = $this->input->post('purchase_receipt_id');
		$product_id = $this->input->post('product_id');
		
		$this->db->select('ip_id,sl_no,status');
		$this->db->from('warranty_product_list');
		//$this->db->where('warranty_product_list.status = 1');
		$this->db->where('product_id',$product_id);
		$this->db->where('purchase_receipt_id',$purchase_receipt_id);
		$query = $this->db->get();
		echo json_encode($query->result());
	}
	
	function update_product_warranty()
	{
		$ip_id = $this->input->post('ip_id');
		$product_type_name = $this->input->post('product_type_name');
		
		
		$update_date = array(
		'sl_no' => $product_type_name
		);
		$this->db->where('ip_id',$ip_id);
		$this->db->update('warranty_product_list',$update_date);

		$this->db->select('sl_no');
		$this->db->from('warranty_product_list');
		$this->db->where('ip_id',$ip_id);
		$query = $this->db->get();
		echo json_encode($query->row());
	}
	
	
	/* Starting 	: editPruchaseProduct() */
	public function editPruchaseProduct()
	{
		$purchase_receipt_id  	= $this->input->post('purchase_receipt_id');
		$product_id 			= $this->input->post('pro_id');
		$qnty 					= $this->input->post('qty');
		$unit_buy_price 		= $this->input->post('u_b_p');
		$shop_id 				= $this->tank_auth->get_shop_id();

		if($purchase_receipt_id != '' && $product_id != '' && $qnty != '' && $unit_buy_price != '' && 
			is_numeric($unit_buy_price) && is_numeric($qnty) && is_numeric($purchase_receipt_id) && is_numeric($product_id))
		{
			/* $is_accessible 		= $this->access_control_model->my_access($this->tank_auth->get_usertype(), __CLASS__, __FUNCTION__);
			if($is_accessible)
			{ */
				echo $this->product_model->editPruchaseProduct($purchase_receipt_id, $product_id, $qnty, $unit_buy_price, $shop_id);
			//}
		}

	}
	/* Ending 		: editPruchaseProduct() */

	public function search_product_by_barcode()
	{
		$barcode =  $this->input->post('barcode');

		if($barcode != '')
		{
			$tmp_data = $this->product_model->search_product_by_barcode($barcode);
			
			if($tmp_data != false)
			{
				$unit_buy_price = $this->product_model->get_latest_unit_buy_price($tmp_data->product_id);
				$tmp_arr['product_id'] 				= $tmp_data->product_id;
				$tmp_arr['product_name'] 			= $tmp_data->product_name;	
				$tmp_arr['unit_buy_price'] 			= $unit_buy_price;	
				$tmp_arr['bulk_unit_buy_price'] 	= $tmp_data->bulk_unit_buy_price;	
				$tmp_arr['bulk_unit_sale_price'] 	= $tmp_data->bulk_unit_sale_price;	
				$tmp_arr['general_unit_sale_price'] = $tmp_data->general_unit_sale_price;	
				$tmp_arr['product_specification'] 	= $tmp_data->new_spec;	
				
				echo json_encode($tmp_arr);
			}

		}
	}
	function purchase_return()
	{
		$data['user_type'] 	= $this->tank_auth->get_usertype();
		$data['user_name'] 	= $this -> tank_auth -> get_username();
		$data['all_bank'] 	= $this -> purchase_model -> get_all_bank();
		$data['distributor_info'] 	= $this -> purchase_model -> distributor_info();
		$data['product_info_warranty_details'] 	= '';
		$data['product_info_details'] 	= '';
		$data['return_main_product'] 	= $this -> purchase_model -> return_main_product();
		$i=1;
		foreach($data['return_main_product']->result() as $tmp)
		{
			$data['return_warranty_product'][$i] 	= $this -> purchase_model -> return_warranty_product($tmp->produ_id);
			$i++;
		}
		$distributor_id = $this->uri->segment(3);
		$product_id = $this->uri->segment(4);
		if($distributor_id!='' || $product_id!='')
		{
			$data['product_info'] 	= $this -> purchase_model -> product_info();
			$data['product_info_details'] 	= $this -> purchase_model -> product_info_details($product_id);
			$data['product_info_warranty_details'] 	= $this -> purchase_model -> product_info_warranty_details($product_id);
		}
		$data['status'] 	= '';	
		$this -> load -> view('Purchase/purchase_return', $data);
	}
	public function list_purchase_temp_data()
	{
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
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
				$this->db->select('sl_no,warranty_period');
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
					'warranty_period' =>$tmp->warranty_period,
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
		$this->db->delete('purchase_return_main_product'); 
		
		$this->db->where('prmp_id', $prmp_id);
		$this->db->delete('purchase_return_warranty_product'); 
				
		echo json_encode(true);
	}
	public function final_purchase_return()
	{
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date=date('Y-m-d');
		$creator = $this->tank_auth->get_user_id();
		$zero = 0;
		$this->db->select('purchase_return_main_product.*,SUM(return_quantity*buy_price) as total_return');
		$this->db->from('purchase_return_main_product');
		$this->db->where('purchase_return_main_product.status="'.$zero.'"');
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
		$this->db->where('purchase_return_main_product.status="'.$zero.'"');
		$query1 = $this->db->get();
		$i=1;
		foreach($query1->result() as $tmp1)
		{
			$this->db->set('stock_amount', 'stock_amount-' . $tmp1->return_quantity, FALSE);
			$this->db->where('product_id', $tmp1->produ_id);
			$this->db->update('bulk_stock_info');
			
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
		
		
		if($query2->num_rows > 0)
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
		redirect('purchase/purchase_return/null/null/success');

	}
}
=======
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
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
