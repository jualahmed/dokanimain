<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	


	class Report_controller extends CI_controller
	{
		
		private $shop_id;
		private $data_2;

		public function __construct()
		{
			parent::__construct();
			$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
			$this->is_logged_in();
			
			$this -> shop_id = $this -> tank_auth -> get_shop_id();
		}

		public function is_logged_in()
		{
			
			if(!$this->tank_auth->is_logged_in())
			{
				redirect('auth/login');
			}
		}
		/*******************************
		 * System For vission Express
		 * Product Transfer Log
		 * 13-12-2013
		 * Arafat Mamun
		********************************/
		function product_transfer_log()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['alarming_level'] = FALSE;
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			
			$data['status'] = '';
			/* for sale Running Status */
			$data['sale_status'] = '';
			$data['number_of_products'] = 0;

			$data ['total_buy_price'] = 0;
			$data ['total_sale_price'] = 0;
			$data ['total_profit'] = 0;
			$data['discount_on'] = true;
			//$data['debit_credit']  = $this -> input -> post('debit_credit');
			$data['sale_type']  = $this -> input -> post('sale_type');
			
				
			$data['sale_mode'] = $this -> my_variables_model -> select_sale_mode();
			$data['sale_stock'] = $this -> sale_model -> by_product_code_result();
			if($data['sale_stock'] ->  num_rows() > 0)
			{
				
				$data['sale_status'] = 'running';
				$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
				$buy_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$buy_amount = $buy_amount + $field -> unit_buy_price;
				endforeach;
				$data ['total_buy_price'] += $buy_amount;
				$sale_amount = 0;
				foreach($data['sale_stock'] -> result() as $field):
					$sale_amount = $sale_amount + $field -> unit_sale_price;
				endforeach;
				$data ['total_sale_price'] += $sale_amount;
				$data ['total_profit'] += $sale_amount - $buy_amount;
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			$data['sale_bulk'] = $this -> sale_model -> by_product_code_result_bulk();
			if($data['sale_bulk'] ->  num_rows() > 0)
			{ 
				$data['sale_status'] = 'running';
				$quantity = 0; // bulk product amount
				foreach($data['sale_bulk'] -> result() as $field):
					$quantity = $quantity + $field -> bulk_sale_quantity;
				endforeach;
				$data['number_of_products'] += $quantity;
				$buy_amount = 0; // bulk buy price
				foreach($data['sale_bulk'] -> result() as $field):
					$buy_amount = $buy_amount + ( $field -> unit_buy_price *  $field -> bulk_sale_quantity );
				endforeach;
				//$data ['total_buy_price'] += ( $buy_amount * $quantity);
				$data ['total_buy_price'] += ( $buy_amount );
				$sale_amount = 0;
				foreach($data['sale_bulk'] -> result() as $field):
					$sale_amount = $sale_amount + ( $field -> unit_sale_price  *  $field -> bulk_sale_quantity );				
				endforeach;
				//$data ['total_sale_price'] += ( $sale_amount * $quantity );
				$data ['total_sale_price'] += ( $sale_amount  );
				$data ['total_profit'] += ( $sale_amount - $buy_amount );
				if( $data ['total_buy_price'] )
					$temp_buy_price = $data ['total_buy_price'];
				else $temp_buy_price = 1;
				$data['total_profit_percentage'] =  floor((( $data ['total_sale_price'] - $data ['total_buy_price'] ) * 100.00 ) / $temp_buy_price);
			}
			/* end of Sale running Status*/
			
			$data['running_my_sales'] = $this -> sale_model -> running_my_sales($this->tank_auth->get_user_id(), $this->tank_auth->get_shop_id());
			$data['currrent_temp_sale_id'] = $this -> tank_auth -> get_current_temp_sale();
			
			/*** All Products **/
			$query = $this -> product_model -> specific_shop_products($this -> tank_auth -> get_shop_id(), FAlSE, 0);
			$product['notSelected'] = 'All Products';
			foreach($query -> result() as $field):
				$product[ $field -> product_id ] = $field -> product_name;
			endforeach;
			$data['all_product'] = $product;
			
			/*** All Shops ***/
			$query = $this -> report_model -> shop_information(FALSE, 0);
			$shop['notSelected'] = 'All Shops';
			if($query -> num_rows < 1) $shop[ '' ] = 'No Shop is listed Yet!';
			foreach($query -> result() as $field):
				if($field -> shop_id == $this -> shop_id) continue;
				$shop[ $field -> shop_id ] = $field -> shop_name.' ( '.$field -> shop_address .' )';
			endforeach;
			$data['all_shop'] = $shop;
			
			/*** All Transfer Mode ***/
			$data['transfer_mode'] = Array(
										'allInOut' => 'All IN OUT',
										'inProducts' => 'Products IN',
										'outProducts' => 'Products OUT'
										);
								
			$data['result'] = '';					
					
			
			$this->form_validation->set_rules('selected_product_id', ' ', 'trim|xss_clean|');
			$this->form_validation->set_rules('selected_shop_id', ' ', 'trim|xss_clean');
			$this->form_validation->set_rules('transfer_mode', ' ', 'trim|xss_clean');
			$this->form_validation->set_rules('start_date', ' ', 'trim|xss_clean');
			$this->form_validation->set_rules('end_date', ' ', 'trim|xss_clean');
			
			if($this->form_validation->run())
			{
				if($data['general_details'] = $this -> report_model -> product_transfer_log(
					$this->form_validation->set_value('selected_product_id'),
					$this->form_validation->set_value('selected_shop_id'),
					$this->form_validation->set_value('transfer_mode'),
					$this->form_validation->set_value('start_date'),
					$this->form_validation->set_value('end_date')))
				$data['result'] = "result";
			}
			
			
			
			$data['main_content'] = 'product_transfer_log';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
		}
		/*******************************
		 * System For vission Express
		 * Product Transfer Log Print
		 * 13-12-2013
		 * Arafat Mamun
		********************************/
		function print_product_transfer_log()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['selected_product_id'] = $this -> uri -> segment(3);
			$data['selected_shop_id'] = $this -> uri -> segment(4);
			$data['transfer_mode'] = $this -> uri -> segment(5);
			$data['start_date'] = $this -> uri -> segment(6);
			$data['end_date'] = $this -> uri -> segment(7);
			$data['general_details'] = $this -> report_model -> product_transfer_log(
											$this -> uri -> segment(3),
											$this -> uri -> segment(4),
											$this -> uri -> segment(5),
											$this -> uri -> segment(6),
											$this -> uri -> segment(7));

			 $this -> load -> view('print_product_transfer_log', $data);
		}
		
		function report()
		{
		//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			$data['access_status'] = $this -> uri -> segment(3);
			$data['alarming_level'] = FALSE;
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['main_content'] = 'report_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
		}
		
		/************************
		 *  See an Old Invoice  *
		 * *************************/
		function old_invoice()
		{
			$data['sale_status'] = '';
			$data['status'] = '';
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			if( $this -> uri -> segment(3) == 'no_invoice_found')
				$data['status'] = 'no_invoice_found';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'old_invoice_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
		}
		
		
		/************************
		 *  See All Sale Return Details *
		 * *************************/
		function sale_return_report()
		{
			$data['sale_status'] = '';
			$data['status'] = '';
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			if( $this -> uri -> segment(3) == 'no_invoice_found')
				$data['status'] = 'no_invoice_found';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'sale_return_report_form_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
		}
		
		/**********************************************
		* Invoice of  Specific date                   *
		* *********************************************/
		function  specific_date_invoice()
		{
		   $data['sale_status'] = '';
		   $data['status'] = '';
		   $data['user_type'] = $this->tank_auth->get_usertype();
		   $data['user_name'] = $this->tank_auth->get_username();
		   $data['start_date'] = $this -> input -> post('start_date');
		   $data['end_date'] = $this -> input -> post('end_date');
		   $data['action'] = $this -> input -> post('action');
		   
		    if( !$this -> input -> post('specific_date') &&  (!$data['start_date']) && (!$data['end_date'])) 
		    {
				$data['start_date'] = $this -> uri -> segment(3);
			    $data['end_date'] =  $this -> uri -> segment(3);
		    }
		   
		   if( $this -> input -> post('specific_date'))
		   {
			   $data['start_date'] = $this -> input -> post('specific_date');
			   $data['end_date'] = $this -> input -> post('specific_date');
		   }
		   $data['all_invoice_id'] = $this -> report_model ->  invoice_id_of_a_specific_date(   $data['start_date']  ,  $data['end_date']  );
		   $data['alarming_level'] = FALSE;
		   $data['main_content'] = 'specific_date_profit_details_view';
		   $data['tricker_content'] = 'tricker_report_view';
		   if(  $data['action'] == 'modify')
				 $data['tricker_content'] = 'tricker_modify_view';
		   $this -> load -> view('include/template', $data);
		}
		
		/**********************************************
		* All Stock / Purchase / Sale / Discount Report (Ovi-2016-12-15)      Start             *
		* *********************************************/
		 public function search_product(){
    		
	            $key			= $this->input->post('term');
	            $flag 			= (int)$this->input->post('flag');
	            $field_name 	= "";

	            if($flag == 1){
	            	$field_name 	= 'product_name';
	            }
				$data 	= $this->sale_model->search_and_get_product($key, $field_name);
				
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
							'generic_name' 				=> $tmp->group_name,
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

		function stock_report()
		{
		   $data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['bd_date'] = $bd_date;
				$data['sale_status'] = '';
				$data['alarming_level'] = FALSE;
				$data['last_id'] = $this->product_model->getLastInserted();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['status'] = '';
				$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id();
				$data['distributor_info'] = $this -> product_model -> distributor_info();
				$data['company_name'] = $this -> product_model -> company_name();
				$data['catagory_name'] = $this -> product_model -> catagory_name();
				$data['product_specification'] = $this -> product_model -> product_specification();
				$this->load->model('product_model');
				$data['total_stock_price'] = $this -> site_model -> total_stock_price();
				$data['total_stock_sale_price'] = $this -> site_model -> total_stock_sale_price();
				$data['total_stock_quantity'] = $this -> site_model -> total_stock_quantity();
				$data['product_type'] = $this -> product_model -> product_type();
				$data['unit_name'] = $this -> product_model -> unit_name();
				
				$data['posts']= array();
				
				$this -> load -> view('Report/all_stock_report_new', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		
		function  all_stock_report_by_barcode()
		{
			$barcode = $this->input->post('barcode');
			$temp 	 = $this->report_model->all_stock_report_by_barcode($barcode);
			
			echo json_encode($temp->result());

		}
		function  all_stock_report_find()
		{

			$temp = $this->report_model->get_stock_info_by_multi();
			
			echo json_encode($temp->result());

		}
		function download_data_stock()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());
			$data['down_data_stock'] = $this -> report_model -> print_data_stock();
			$html=$this->load->view('Download/download_data_stock',$data, true); 

			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Stock Report");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
				
				
		}
		function warranty_stock_report()
		{
		   $data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['bd_date'] = $bd_date;
				$data['sale_status'] = '';
				$data['alarming_level'] = FALSE;
				$data['last_id'] = $this->product_model->getLastInserted();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['status'] = '';
				$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id();
				$data['distributor_info'] = $this -> product_model -> distributor_info();
				$data['company_name'] = $this -> product_model -> company_name();
				$data['catagory_name'] = $this -> product_model -> catagory_name();
				$data['product_specification'] = $this -> product_model -> product_specification();
				$this->load->model('product_model');
				$data['total_stock_price'] = $this -> site_model -> total_stock_price();
				$data['total_stock_sale_price'] = $this -> site_model -> total_stock_sale_price();
				$data['total_stock_quantity'] = $this -> site_model -> total_stock_quantity();
				$data['product_type'] = $this -> product_model -> product_type();
				$data['unit_name'] = $this -> product_model -> unit_name();
				
				$data['posts']= array();
				
				$this -> load -> view('Report/all_warranty_stock_report_new', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		function  all_warranty_stock_report_find()
		{
			$temp = array();
			$temp = $this->report_model->get_warranty_stock_info_by_multi();
			$temp = $temp->result_array();
			$i=0;
			foreach($temp as $tmp)
			{
				$product_id = $tmp['product_id'];
				$warranty_name = $this->report_model->get_warranty_stock($product_id);
				$temp[$i]['warranty_name'] = $warranty_name->result_array();
				$i++;
				
			}
			
			echo json_encode(array("pro_list"=>$temp));

		}
		function  purchase_report()
		{
		   $data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['bd_date'] = $bd_date;
				$data['sale_status'] = '';
				$data['alarming_level'] = FALSE;
				$data['last_id'] = $this->product_model->getLastInserted();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['status'] = '';
				$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id();
				$data['distributor_info'] = $this -> product_model -> distributor_info();
				$data['company_name'] = $this -> product_model -> company_name();
				$data['catagory_name'] = $this -> product_model -> catagory_name();
				$data['distributor_name'] = $this -> product_model -> distributor_name();
				$this->load->model('product_model');
				$data['product_type'] = $this -> product_model -> product_type();
				$data['receipt_status'] = $this -> product_model -> receipt_status();
				$data['purchase_receipt'] = $this -> product_model -> purchase_receipt();
				$data['unit_name'] = $this -> product_model -> unit_name();
				$this -> load -> view('Report/all_purchase_report_new', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		
		function  all_purchase_report_find()
		{
			$temp1 = $this->report_model->get_purchase_info_by_multi();
			
			echo json_encode($temp1->result());

		}
		
		function download_data_purchase()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());

			$data['download_data_purchase'] = $this -> report_model -> print_data_purchase();
			$html=$this->load->view('Download/download_data_purchase',$data, true); 

			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Purchase Report");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
		}
		
		function sale_report()
		{
		   $data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['bd_date'] = $bd_date;
				$data['sale_status'] = '';
				$data['alarming_level'] = FALSE;
				$data['last_id'] = $this->product_model->getLastInserted();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['status'] = '';
				$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id();
				$data['distributor_info'] = $this -> product_model -> distributor_info();
				$data['company_name'] = $this -> product_model -> company_name();
				$data['catagory_name'] = $this -> product_model -> catagory_name();
				$data['distributor_name'] = $this -> product_model -> distributor_name();
				$data['customer_name'] = $this -> product_model -> customer_name();
				$data['product_specification'] = $this -> product_model -> product_specification();
				$this->load->model('product_model');
				$data['product_type'] = $this -> product_model -> product_type();
				$data['purchase_receipt'] = $this -> product_model -> purchase_receipt();
				$data['seller'] = $this -> product_model -> seller();
				$data['unit_name'] = $this -> product_model -> unit_name();
				$this -> load -> view('Report/all_sale_report_new', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		
		function all_sale_report_find()
		{

			$temp2 = $this->report_model->get_sale_info_by_multi();
			
			echo json_encode($temp2->result());

		}
		function all_individual_sale_report_find()
		{

			$invoice_id = $this->input->post('invoice_id');
		
			$this->db->select('customer_info.customer_name,product_info.product_name, product_info.company_name, product_info.catagory_name,product_info.product_type,invoice_info.invoice_id,sale_details.sale_quantity,sale_details.exact_sale_price,sale_details.unit_buy_price,sale_details.unit_sale_price,invoice_info.invoice_doc,users.username');
			$this->db->from('invoice_info,sale_details,customer_info,product_info,users');
			$this->db->where('customer_info.customer_id = invoice_info.customer_id');
			$this->db->where('invoice_info.invoice_id = sale_details.invoice_id');
			$this->db->where('invoice_info.invoice_creator = users.id');
			$this->db->where('product_info.product_id = sale_details.product_id');
			$this->db->where('invoice_info.invoice_id',$invoice_id); 
			$query = $this->db->get();
			echo json_encode($query->result_array());

		}
		function download_data_sale()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());
			$data['download_data_sale'] = $this -> report_model -> print_data_sale();
			$html=$this->load->view('Download/download_data_sale',$data, true); 

			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Sale Report");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
		}
		
		function  card_sale_report()
		{
		   $data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['bd_date'] = $bd_date;
				$data['sale_status'] = '';
				$data['alarming_level'] = FALSE;
				$data['last_id'] = $this->product_model->getLastInserted();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['status'] = '';
				$data['card_name'] = $this -> product_model -> card_name();
				$data['unit_name'] = $this -> product_model -> unit_name();
				$this -> load -> view('Report/all_card_sale_report_new', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		
		function  all_card_sale_report_find()
		{

			$temp2 = $this->report_model->get_card_sale_info_by_multi();
			
			echo json_encode($temp2->result());

		}
		function download_data_card_sale()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());
			$data['download_data_card_sale'] = $this -> report_model -> print_data_card_sale();
			$html=$this->load->view('Download/download_data_card_sale',$data, true); 

			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Card Sale Report");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
		}

		function  damage_report()
		{
		   $data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['bd_date'] = $bd_date;
				$data['sale_status'] = '';
				$data['alarming_level'] = FALSE;
				$data['last_id'] = $this->product_model->getLastInserted();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['status'] = '';
				$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id();
				$data['distributor_info'] = $this -> product_model -> distributor_info();
				$data['company_name'] = $this -> product_model -> company_name();
				$data['catagory_name'] = $this -> product_model -> catagory_name();
				$data['distributor_name'] = $this -> product_model -> distributor_name();
				$data['product_specification'] = $this -> product_model -> product_specification();
				$this->load->model('product_model');
				$data['product_type'] = $this -> product_model -> product_type();
				$data['purchase_receipt'] = $this -> product_model -> purchase_receipt();
				$data['seller'] = $this -> product_model -> seller();
				$data['unit_name'] = $this -> product_model -> unit_name();
				$this -> load -> view('Report/all_damage_report_new', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		function  all_damage_report_find()
		{
			$temp3 = $this->report_model->get_damage_info_by_multi();

			echo json_encode($temp3->result());
		}
		function download_data_damage()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());
				
			$data['download_data_damage'] = $this -> report_model -> print_data_damage();
			$html=$this->load->view('Download/download_data_damage',$data, true); 

			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Damage Report");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
		}
		
		function  delivery_charge_report()
		{
		   $data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['bd_date'] = $bd_date;
				$data['sale_status'] = '';
				$data['alarming_level'] = FALSE;
				$data['last_id'] = $this->product_model->getLastInserted();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['status'] = '';
				$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id();
				$data['distributor_info'] = $this -> product_model -> distributor_info();
				$data['company_name'] = $this -> product_model -> company_name();
				$data['catagory_name'] = $this -> product_model -> catagory_name();
				$data['distributor_name'] = $this -> product_model -> distributor_name();
				$data['product_specification'] = $this -> product_model -> product_specification();
				$this->load->model('product_model');
				$data['product_type'] = $this -> product_model -> product_type();
				$data['purchase_receipt'] = $this -> product_model -> purchase_receipt();
				$data['seller'] = $this -> product_model -> seller();
				
				$data['unit_name'] = $this -> product_model -> unit_name();
				$this -> load -> view('Report/delivery_charge_report', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		function all_delivery_charge_report_find()
		{
			$temp3 = $this->report_model->get_delivery_charge_info_by_multi();

			echo json_encode($temp3->result());
					

		}
		function download_data_delivery_charge()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());
			$data['download_data_delivery_charge'] = $this -> report_model -> print_data_delivery_charge();
			$html=$this->load->view('Download/download_data_delivery_charge',$data, true); 

			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Sale Return Report");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
		}
		function  sale_return_report_new()
		{
		   $data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['bd_date'] = $bd_date;
				$data['sale_status'] = '';
				$data['alarming_level'] = FALSE;
				$data['last_id'] = $this->product_model->getLastInserted();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['status'] = '';
				$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id();
				$data['distributor_info'] = $this -> product_model -> distributor_info();
				$data['company_name'] = $this -> product_model -> company_name();
				$data['catagory_name'] = $this -> product_model -> catagory_name();
				$data['distributor_name'] = $this -> product_model -> distributor_name();
				$data['product_specification'] = $this -> product_model -> product_specification();
				$this->load->model('product_model');
				$data['product_type'] = $this -> product_model -> product_type();
				$data['purchase_receipt'] = $this -> product_model -> purchase_receipt();
				$data['seller'] = $this -> product_model -> seller();
				
				$data['unit_name'] = $this -> product_model -> unit_name();
				$this -> load -> view('Report/all_sale_return_report_new', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		function all_sale_return_report_find()
		{
			$temp3 = $this->report_model->get_return_info_by_multi();

			echo json_encode($temp3->result());
					

		}
		function download_data_return()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());
			$data['download_data_return'] = $this -> report_model -> print_data_return();
			$html=$this->load->view('Download/download_data_return',$data, true); 

			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Sale Return Report");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
		}
		function purchase_return_report_new()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['alarming_level'] = FALSE;
			$data['user_name'] = $this->tank_auth->get_username();
			$data['status'] = '';
			$data['return_main_product'] = '';

			$data['distributor_info'] = $this -> product_model -> distributor_info();
			$distributor_id= $this->uri->segment(3);
			$start_date=$this->uri->segment(4);
			$end_date=$this->uri->segment(5);
			if($distributor_id!='' || $start_date!='' || $end_date!='')
			{
				$data['return_main_product'] = $this->report_model->get_purchase_return_info_by_multi($distributor_id,$start_date,$end_date);
				$i=1;
				foreach($data['return_main_product']->result() as $tmp)
				{
					$data['return_warranty_product'][$i] 	= $this -> report_model -> return_warranty_product($tmp->product_id,$tmp->prmp_id);
					$i++;
				}
			}
			$this -> load -> view('Report/all_purchase_return_report_new', $data);
		}

		function download_data_purchase_return()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());

			$distributor_id= $this->uri->segment(3);
			$start_date=$this->uri->segment(4);
			$end_date=$this->uri->segment(5);
			if($distributor_id!='' || $start_date!='' || $end_date!='')
			{
				$data['return_main_product'] = $this->report_model->get_purchase_return_info_by_multi($distributor_id,$start_date,$end_date);
				$i=1;
				foreach($data['return_main_product']->result() as $tmp)
				{
					$data['return_warranty_product'][$i] 	= $this -> report_model -> return_warranty_product($tmp->product_id,$tmp->prmp_id);
					$i++;
				}
			}
			$html=$this->load->view('Download/download_data_purchase_return',$data, true); 

			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Sale Return Report");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
		}
		function product_exchange_report_new()
		{
		   $data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['bd_date'] = $bd_date;
				$data['sale_status'] = '';
				$data['alarming_level'] = FALSE;
				$data['last_id'] = $this->product_model->getLastInserted();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['status'] = '';
				$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id();
				$data['distributor_info'] = $this -> product_model -> distributor_info();
				$data['company_name'] = $this -> product_model -> company_name();
				$data['catagory_name'] = $this -> product_model -> catagory_name();
				$data['distributor_name'] = $this -> product_model -> distributor_name();
				$data['product_specification'] = $this -> product_model -> product_specification();
				$this->load->model('product_model');
				$data['product_type'] = $this -> product_model -> product_type();
				$data['purchase_receipt'] = $this -> product_model -> purchase_receipt();
				$data['seller'] = $this -> product_model -> seller();
				
				$data['unit_name'] = $this -> product_model -> unit_name();
				$this -> load -> view('Report/product_exchange_report_new', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		function all_product_exchange_report_find()
		{
			$temp3 = $this->report_model->get_product_exchange_info_by_multi();

			echo json_encode($temp3->result());
					

		}
		function download_product_exchange()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());
			$data['download_product_exchange'] = $this -> report_model -> print_product_exchange();
			$html=$this->load->view('Download/download_product_exchange',$data, true); 

			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Purchase Return Report");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
		}
		function expense_report_new()
		{
		   $data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['bd_date'] = $bd_date;
				$data['sale_status'] = '';
				$data['alarming_level'] = FALSE;
				$data['last_id'] = $this->product_model->getLastInserted();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['status'] = '';
				$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id();
				$data['distributor_info'] = $this -> product_model -> distributor_info();
				$data['company_name'] = $this -> product_model -> company_name();
				$data['catagory_name'] = $this -> product_model -> catagory_name();
				$data['distributor_name'] = $this -> product_model -> distributor_name();
				$data['expense_name'] = $this -> product_model -> expense_name();
				$data['product_specification'] = $this -> product_model -> product_specification();
				$this->load->model('product_model');
				$data['product_type'] = $this -> product_model -> product_type();
				$data['purchase_receipt'] = $this -> product_model -> purchase_receipt();
				$data['seller'] = $this -> product_model -> seller();
				$data['service_provider_info'] = $this -> my_variables_model -> fatch_service_provider_info();
				$data['unit_name'] = $this -> product_model -> unit_name();
				$data['employee_info'] = $this -> my_variables_model -> employee_info();
				$this -> load -> view('Report/all_expense_report_new', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		function  all_expense_report_find()
		{
			$temp3 = $this->report_model->get_expense_info_by_multi();

			echo json_encode($temp3->result());
					

		}
		function download_data_expense()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());
				
			$data['download_data_expense'] = $this -> report_model -> print_data_expense();
			$html=$this->load->view('Download/download_data_expense',$data, true); 

			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Expense Report");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
		}
		
		
		function staff_report_new()
		{
		   $data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['bd_date'] = $bd_date;
				$data['sale_status'] = '';
				$data['user_name'] = $this->tank_auth->get_username();
				$data['status'] = '';
				$data['all_staff'] = $this->report_model->all_staff_list();
				$this -> load -> view('Report/all_staff_report_new', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		function download_staff_list()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());
						
		    $data['all_staff'] = $this->report_model->all_staff_list();
			$html=$this->load->view('Download/download_staff_list',$data, true); 

			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Staff List");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
		}
		function credit_collection_report_new()
		{
		   $data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'product_controller', 'product_entry'))
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date('Y-m-d');
				$data['bd_date'] = $bd_date;
				$data['sale_status'] = '';
				$data['alarming_level'] = FALSE;
				$data['last_id'] = $this->product_model->getLastInserted();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['status'] = '';
				$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id();
				$data['distributor_info'] = $this -> product_model -> distributor_info();
				$data['company_name'] = $this -> product_model -> company_name();
				$data['catagory_name'] = $this -> product_model -> catagory_name();
				$data['distributor_name'] = $this -> product_model -> distributor_name();
				$data['expense_name'] = $this -> product_model -> expense_name();
				$data['product_specification'] = $this -> product_model -> product_specification();
				$this->load->model('product_model');
				$data['product_type'] = $this -> product_model -> product_type();
				$data['purchase_receipt'] = $this -> product_model -> purchase_receipt();
				$data['seller'] = $this -> product_model -> seller();
				$data['unit_name'] = $this -> product_model -> unit_name();
				$this -> load -> view('Report/all_credit_collection_report_new', $data);
			}
			else redirect('product_controller/product/noaccess');
		}
		function  all_credit_collection_report_find()
		{
			$temp3 = $this->report_model->get_credit_collection_info_by_multi();

			echo json_encode($temp3->result());
		}
		function download_credit_collection()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());
						
		    $data['all_credit_collection'] = $this->report_model->all_credit_collection();
			$html=$this->load->view('Download/download_credit_collection',$data, true); 

			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Credit Collection Report");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
		}
		function all_catagory_download()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());
						
		     $this->data['down_data_catagory'] = $this -> report_model -> print_data_catagory();
				$html=$this->load->view('Download/download_all_catagory',$this->data, true); 
				$this->load->library('m_pdf');
				ob_start();
				$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
				$this->m_pdf->pdf->SetProtection(array('print'));
				$this->m_pdf->pdf->SetTitle("Staff List");
				$this->m_pdf->pdf->SetAuthor("Dokani");
				$this->m_pdf->pdf->SetDisplayMode('fullpage');
				
				$this->m_pdf->pdf->AddPageByArray(array(
				'orientation' => '',
				'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
				//margin left,margin right,margin top,margin bottom,margin header,margin footer
				));
				//$this->m_pdf->pdf->SetColumns(2);
				$this->m_pdf->pdf->WriteHTML($html);
				ob_clean();
				$this->m_pdf->pdf->Output();
				ob_end_flush();
				exit;
				
				
		}
		function all_company_download()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());
						
		    $this->data['down_data_company'] = $this -> report_model -> print_data_company();
			$html=$this->load->view('Download/download_all_company',$this->data, true); 
			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Staff List");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
		}
		function all_distributor_download()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());
						
		    $this->data['down_data_distributor'] = $this -> report_model -> print_data_distributor();
			$html=$this->load->view('Download/download_all_distributor',$this->data, true); 
			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Staff List");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
				
		}
		function all_customer_download()
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date = date('Y-m-d',time());
						
		     $this->data['down_data_customer'] = $this -> report_model -> print_data_customer();

			$html=$this->load->view('Download/download_all_customer',$this->data, true); 
			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Staff List");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '35','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
		}
		/**********************************************
		* All Stock Report (Ovi-2016-12-15)    End               *
		* *********************************************/
		
		/*-----Financial_report Genaration-----*/
		function financial_report()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			$this -> load -> view('Report/financial_report_form_view', $data);
		}
		
		function specific_date_report_for_financial_statement_1()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['sale_status'] = '';
		    $data['status'] = '';
		    $data['user_type'] = $this->tank_auth->get_usertype();
		    $data['user_name'] = $this->tank_auth->get_username();
		    $data['start_date'] = $this -> input -> post('start_date');
		    $data['end_date'] = $this -> input -> post('end_date');
		    $quee = array();
		    if( !$this -> input -> post('specific_date') &&  (!$data['start_date']) && (!$data['end_date'])) 
		    {
				$data['start_date'] = $this -> uri -> segment(3);
			    $data['end_date'] =  $this -> uri -> segment(3);
			}
		    if($data['start_date'] == $data['end_date']){
				$this->db->where('statement_date',$data['start_date']);
				$quee = $this->db->get('daily_statement');
			}
		    if( $this -> input -> post('specific_date'))
		    {
			   $data['start_date'] = $this -> input -> post('specific_date');
			   $data['end_date'] = $this -> input -> post('specific_date');
				$this->db->where('statement_date',$this -> input -> post('specific_date'));
				$quee = $this->db->get('daily_statement');
		    }

			if(($data['start_date'] != $data['end_date']) || $quee->num_rows() < 1 ){
				$data['opening_stock'] = $this -> report_model -> stock_status_on_specific_date( $data['start_date'] , $data['bd_date']);
				$temp_date = date("Y-m-d",strtotime(date("Y-m-d", strtotime($data['end_date'])) . " +1 day"));
				$data['closing_stock'] = $this -> report_model -> stock_status_on_specific_date( $temp_date , $data['bd_date'] );
				
				$data['financial_statement_info' ] = $this -> report_model -> date_wise_financial_statement_calculation( $data['start_date']  ,  $data['end_date']);
				$data['payable_receivable_financial_statement'] = $this -> report_model -> payable_receivable_financial_statement($data['start_date']  ,  $data['end_date']);
				$data['expense_financial_statement'] = $this -> report_model -> expense_financial_statement($data['start_date']  ,  $data['end_date']);
				$data['date_wise_total_discount']= $this -> report_model -> specific_date_discount_calculation( $data['start_date']  ,  $data['end_date']);
				$data['date_wise_total_comission']= $this -> report_model -> specific_date_comission_calculation( $data['start_date']  ,  $data['end_date']);
				$data['date_wise_total_cash_discount']= $this -> report_model -> specific_date_cash_discount_calculation( $data['start_date']  ,  $data['end_date']);
				$data['cash_status_report_info'] = $this -> report_model -> cash_status_report_result_calculation( $data['start_date']  ,  $data['end_date']);
				//$data['total_point_discount'] = $this -> report_model -> total_point_discount_datewise( $data['start_date']  ,  $data['end_date']);

				$data['payable_receivable_salary_statement'] = $this -> account_model -> transaction_with_employees(false,0);
				
				
				if($this -> uri -> segment(4))
				{
					$data['transaction_details'] = $this -> report_model -> specific_transaction_details($this -> uri -> segment(4));
				}
				if($this -> uri -> segment(7))
				{
					$data['get_transaction_details_by_purpose'] = $this -> report_model -> get_transaction_details_by_purpose($this -> uri -> segment(7),$this -> uri -> segment(3));
				}
				$data[ 'sale_price_info' ] = $this -> report_model -> todays_sale(  $data['start_date']  ,  $data['end_date']  );
				$data[ 'sale_return_info' ] = $this -> report_model -> sale_return_info(  $data['start_date']  ,  $data['end_date']  );
				$data[ 'delivery_charge_info' ] = $this -> report_model -> delivery_charge_info(  $data['start_date']  ,  $data['end_date']  );
				$data[ 'buy_price_info' ] = $this -> report_model -> specific_date_buy_price_calculation(  $data['start_date']  ,  $data['end_date'] );
				$data['all_stock'] = $this -> report_model -> get_all_stock_report();
			}
			else
			{
				$data['field'] = $quee->row_array();
			}
		    $this -> load -> view('Report/financial_statement_result_view_1', $data);
		}
		
		function get_other_expense_details(){
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$data = $this -> report_model -> get_other_expense_details($start_date,$end_date);
			echo json_encode($data->result());
		}
		/*for printing  finalcial stement  */
		function print_financial_report_1()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$this->data['bd_date'] = date ('Y-m-d');
			$this->data['sale_status'] = '';
		    $this->data['status'] = '';
		    $this->data['user_type'] = $this->tank_auth->get_usertype();
		    $this->data['user_name'] = $this->tank_auth->get_username();
		    $this->data['start_date'] = $this -> uri -> segment(3);
		    $this->data['end_date'] = $this -> uri -> segment(4);  
		    $this->data['financial_statement_info' ] = $this -> report_model -> date_wise_financial_statement_calculation( $this->data['start_date']  ,  $this->data['end_date']);
		    $this->data['payable_receivable_financial_statement'] = $this -> report_model -> payable_receivable_financial_statement($this->data['start_date']  ,  $this->data['end_date']);
		    $this->data['cash_status_report_info'] = $this -> report_model -> cash_status_report_result_calculation( $this->data['start_date']  ,  $this->data['end_date']);
		    $this->data['date_wise_total_discount']= $this -> report_model -> specific_date_discount_calculation( $this->data['start_date']  ,  $this->data['end_date']);
			$this->data['date_wise_total_comission']= $this -> report_model -> specific_date_comission_calculation( $this->data['start_date']  ,  $this->data['end_date']);
			$this->data['date_wise_total_cash_discount']= $this -> report_model -> specific_date_cash_discount_calculation($this->data['start_date']  ,  $this->data['end_date']);
			$this->data['expense_financial_statement'] = $this -> report_model -> expense_financial_statement($this->data['start_date']  ,  $this->data['end_date']);
		    $this->data['payable_receivable_salary_statement'] = $this -> account_model -> transaction_with_employees(false,0);
		    $this->data['total_point_discount'] = $this -> report_model -> total_point_discount_datewise($this->data['start_date']  ,  $this->data['end_date']);

		    $this->data['opening_stock'] = $this -> report_model -> stock_status_on_specific_date($this->data['start_date'] , $this->data['bd_date']);
			$temp_date = date("Y-m-d",strtotime(date("Y-m-d", strtotime($this->data['end_date'])) . " +1 day"));
			$this->data['closing_stock'] = $this -> report_model -> stock_status_on_specific_date( $temp_date , $this->data['bd_date'] );

		    
			$this->data[ 'sale_price_info' ] = $this -> report_model -> todays_sale(  $this->data['start_date']  ,  $this->data['end_date']  );
			$this->data[ 'sale_return_info' ] = $this -> report_model -> sale_return_info(  $this->data['start_date']  ,  $this->data['end_date']  );
			$this->data[ 'delivery_charge_info' ] = $this -> report_model -> delivery_charge_info(  $this->data['start_date']  ,  $this->data['end_date']  );
		    $this->data[ 'buy_price_info' ] = $this -> report_model -> specific_date_buy_price_calculation(  $this->data['start_date']  ,  $this->data['end_date'] );
		    $this->data['all_stock'] = $this -> report_model -> get_all_stock_report();
		    
			//$this->load->view('Download/download_data_financial_statement',$this->data); 
			$html=$this->load->view('Download/download_data_financial_statement',$this->data, true); 

			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("Financial Report");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '45','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
		}

		function scb_report()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$bd_date = date ('Y-m-d');
			$data['sale_status'] = '';
		    $data['status'] = '';
		    $data['user_type'] = $this->tank_auth->get_usertype();
		    $data['user_name'] = $this->tank_auth->get_username();
		    
			$start_date = $this->uri->segment(3);
		    $end_date = $this->uri->segment(4);
			
		    if(($start_date!=''&& $end_date=='null'))
		    {
				$start_date = $start_date;
				$end_date = $start_date;
		    }
			else if($start_date=='' && $end_date=='')
		    {
				$start_date = $bd_date;
				$end_date = $bd_date;
		    }
			else
			{
				$start_date = $start_date;
				$end_date = $end_date;
			}
			//Stock Report Start//
			$data['opening_stock'] = $this->report_model->stock_status_on_specific_date($start_date,$bd_date);
			$temp_date = date("Y-m-d",strtotime(date("Y-m-d", strtotime($end_date)) . " +1 day"));
			$pre_date = date("Y-m-d",strtotime(date("Y-m-d", strtotime($start_date)) . " -1 day"));
			$data['closing_stock'] = $this->report_model->stock_status_on_specific_date($temp_date,$bd_date);
			$data['payable_receivable_financial_statement'] = $this->report_model->payable_receivable_financial_statement($start_date,$end_date);
			$data['sale_price_info'] = $this->report_model->todays_sale($start_date,$end_date);
			$data['sale_return_info'] = $this-> report_model->sale_return_info($start_date,$end_date);
			$data['purchase_return_info'] = $this->report_model->purchase_return_info($start_date,$end_date);
			//Stock Report End//
			
			//Cash Book Report Start//
			$data['from_bank_opening'] = $this->report_model->from_bank_opening($pre_date);
			$data['to_bank_opening'] = $this->report_model->to_bank_opening($pre_date);
			$data['from_owner_opening'] = $this->report_model->from_owner_opening($pre_date);
			$data['to_owner_opening'] = $this->report_model->to_owner_opening($pre_date);
			$data['cash_sale_opening'] = $this->report_model->cash_sale_opening($pre_date);
			$data['cash_delivery_charge_opening'] = $this->report_model->cash_delivery_charge_opening($pre_date);
			$data['cash_credit_collection_opening'] = $this->report_model->cash_credit_collection_opening($pre_date);
			$data['cash_sale_return_opening'] = $this->report_model->cash_sale_return_opening($pre_date);
			$data['cash_purchase_payment_opening'] = $this->report_model->cash_purchase_payment_opening($pre_date);
			$data['cash_expense_payment_opening'] = $this->report_model->cash_expense_payment_opening($pre_date);
			
			
			$data['from_bank'] = $this->report_model->from_bank($start_date,$end_date);
			$data['to_bank'] = $this->report_model->to_bank($start_date,$end_date);
			$data['from_owner'] = $this->report_model->from_owner($start_date,$end_date);
			$data['to_owner'] = $this->report_model->to_owner($start_date,$end_date);
			$data['cash_sale'] = $this->report_model->cash_sale($start_date,$end_date);
			$data['cash_delivery_charge'] = $this->report_model->cash_delivery_charge($start_date,$end_date);
			$data['cash_credit_collection'] = $this->report_model->todays_credit_collection_cash($start_date,$end_date);
			$data['cash_sale_return'] = $this->report_model->cash_sale_return($start_date,$end_date);
			$data['cash_purchase_payment'] = $this->report_model->todays_purchase_payment_cash($start_date,$end_date);
			$data['cash_expense_payment'] = $this->report_model->todays_expense_payment_cash($start_date,$end_date);
			//Cash Book Report End//
			
			//Bank Book Report Start//
			$data['from_owner_bank_opening'] = $this->report_model->from_owner_bank_opening($pre_date);
			$data['to_owner_bank_opening'] = $this->report_model->to_owner_bank_opening($pre_date);
			$data['card_sale_opening'] = $this->report_model->cash_sale_opening($pre_date);
			$data['card_delivery_charge_opening'] = $this->report_model->card_delivery_charge_opening($pre_date);
			$data['bank_credit_collection_opening'] = $this->report_model->bank_credit_collection_opening($pre_date);
			$data['bank_sale_return_opening'] = $this->report_model->bank_sale_return_opening($pre_date);
			$data['bank_purchase_payment_opening'] = $this->report_model->bank_purchase_payment_opening($pre_date);
			$data['bank_expense_payment_opening'] = $this->report_model->bank_expense_payment_opening($pre_date);
			
			
			$data['from_owner_bank'] = $this->report_model->from_owner_bank($start_date,$end_date);
			$data['to_owner_bank'] = $this->report_model->to_owner_bank($start_date,$end_date);
			$data['card_sale'] = $this->report_model->card_sale($start_date,$end_date);
			$data['card_delivery_charge'] = $this->report_model->card_delivery_charge($start_date,$end_date);
			$data['bank_sale_return'] = $this->report_model->bank_sale_return($start_date,$end_date);
			$data['bank_expense_payment' ] = $this->report_model->todays_expense_payment_bank($start_date,$end_date);
			$data['bank_purchase_payment'] = $this->report_model->todays_purchase_payment_bank($start_date,$end_date);
			$data['bank_credit_collection'] = $this->report_model->todays_credit_collection_bank($start_date,$end_date);
			//Bank Book Report End//
			
		    $this -> load -> view('Report/scb_report', $data);
		}
		function download_scb_report()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$this->data['bd_date'] = date ('Y-m-d');
			$bd_date = date ('Y-m-d');
			$data['sale_status'] = '';
		    $data['status'] = '';
		    $data['user_type'] = $this->tank_auth->get_usertype();
		    $data['user_name'] = $this->tank_auth->get_username();
		    
			$start_date = $this->uri->segment(3);
		    $end_date = $this->uri->segment(4);
			
		    if(($start_date!=''&& $end_date=='null'))
		    {
				$start_date = $start_date;
				$end_date = $start_date;
		    }
			else if($start_date=='' && $end_date=='')
		    {
				$start_date = $bd_date;
				$end_date = $bd_date;
		    }
			else
			{
				$start_date = $start_date;
				$end_date = $end_date;
			}
			//Stock Report Start//
			$this->data['opening_stock'] = $this->report_model->stock_status_on_specific_date($start_date,$bd_date);
			$temp_date = date("Y-m-d",strtotime(date("Y-m-d", strtotime($end_date)) . " +1 day"));
			$pre_date = date("Y-m-d",strtotime(date("Y-m-d", strtotime($start_date)) . " -1 day"));
			$this->data['closing_stock'] = $this->report_model->stock_status_on_specific_date($temp_date,$bd_date);
			$this->data['payable_receivable_financial_statement'] = $this->report_model->payable_receivable_financial_statement($start_date,$end_date);
			$this->data['sale_price_info'] = $this->report_model->todays_sale($start_date,$end_date);
			$this->data['sale_return_info'] = $this-> report_model->sale_return_info($start_date,$end_date);
			$this->data['purchase_return_info'] = $this->report_model->purchase_return_info($start_date,$end_date);
			//Stock Report End//
			
			//Cash Book Report Start//
			$this->data['from_bank_opening'] = $this->report_model->from_bank_opening($pre_date);
			$this->data['to_bank_opening'] = $this->report_model->to_bank_opening($pre_date);
			$this->data['from_owner_opening'] = $this->report_model->from_owner_opening($pre_date);
			$this->data['to_owner_opening'] = $this->report_model->to_owner_opening($pre_date);
			$this->data['cash_sale_opening'] = $this->report_model->cash_sale_opening($pre_date);
			$this->data['cash_delivery_charge_opening'] = $this->report_model->cash_delivery_charge_opening($pre_date);
			$this->data['cash_credit_collection_opening'] = $this->report_model->cash_credit_collection_opening($pre_date);
			$this->data['cash_sale_return_opening'] = $this->report_model->cash_sale_return_opening($pre_date);
			$this->data['cash_purchase_payment_opening'] = $this->report_model->cash_purchase_payment_opening($pre_date);
			$this->data['cash_expense_payment_opening'] = $this->report_model->cash_expense_payment_opening($pre_date);
			
			
			$this->data['from_bank'] = $this->report_model->from_bank($start_date,$end_date);
			$this->data['to_bank'] = $this->report_model->to_bank($start_date,$end_date);
			$this->data['from_owner'] = $this->report_model->from_owner($start_date,$end_date);
			$this->data['to_owner'] = $this->report_model->to_owner($start_date,$end_date);
			$this->data['cash_sale'] = $this->report_model->cash_sale($start_date,$end_date);
			$this->data['cash_delivery_charge'] = $this->report_model->cash_delivery_charge($start_date,$end_date);
			$this->data['cash_credit_collection'] = $this->report_model->todays_credit_collection_cash($start_date,$end_date);
			$this->data['cash_sale_return'] = $this->report_model->cash_sale_return($start_date,$end_date);
			$this->data['cash_purchase_payment'] = $this->report_model->todays_purchase_payment_cash($start_date,$end_date);
			$this->data['cash_expense_payment'] = $this->report_model->todays_expense_payment_cash($start_date,$end_date);
			//Cash Book Report End//
			
			//Bank Book Report Start//
			$this->data['from_owner_bank_opening'] = $this->report_model->from_owner_bank_opening($pre_date);
			$this->data['to_owner_bank_opening'] = $this->report_model->to_owner_bank_opening($pre_date);
			$this->data['card_sale_opening'] = $this->report_model->cash_sale_opening($pre_date);
			$this->data['card_delivery_charge_opening'] = $this->report_model->card_delivery_charge_opening($pre_date);
			$this->data['bank_credit_collection_opening'] = $this->report_model->bank_credit_collection_opening($pre_date);
			$this->data['bank_sale_return_opening'] = $this->report_model->bank_sale_return_opening($pre_date);
			$this->data['bank_purchase_payment_opening'] = $this->report_model->bank_purchase_payment_opening($pre_date);
			$this->data['bank_expense_payment_opening'] = $this->report_model->bank_expense_payment_opening($pre_date);
			
			
			$this->data['from_owner_bank'] = $this->report_model->from_owner_bank($start_date,$end_date);
			$this->data['to_owner_bank'] = $this->report_model->to_owner_bank($start_date,$end_date);
			$this->data['card_sale'] = $this->report_model->card_sale($start_date,$end_date);
			$this->data['card_delivery_charge'] = $this->report_model->card_delivery_charge($start_date,$end_date);
			$this->data['bank_sale_return'] = $this->report_model->bank_sale_return($start_date,$end_date);
			$this->data['bank_expense_payment' ] = $this->report_model->todays_expense_payment_bank($start_date,$end_date);
			$this->data['bank_purchase_payment'] = $this->report_model->todays_purchase_payment_bank($start_date,$end_date);
			$this->data['bank_credit_collection'] = $this->report_model->todays_credit_collection_bank($start_date,$end_date);
			//Bank Book Report End//
			
		    $html=$this->load->view('Download/download_scb_report',$this->data, true); 

			$this->load->library('m_pdf');
			ob_start();
			$this->m_pdf->pdf 	= new mPDF('utf-8', 'A4');
			$this->m_pdf->pdf->SetProtection(array('print'));
			$this->m_pdf->pdf->SetTitle("SCB Report");
			$this->m_pdf->pdf->SetAuthor("Dokani");
			$this->m_pdf->pdf->SetDisplayMode('fullpage');
			
			$this->m_pdf->pdf->AddPageByArray(array(
			'orientation' => '',
			'mgl' => '10','mgr' => '10','mgt' => '45','mgb' => '20','mgh' => '10','mgf' => '5',
			//margin left,margin right,margin top,margin bottom,margin header,margin footer
			));
			//$this->m_pdf->pdf->SetColumns(2);
			$this->m_pdf->pdf->WriteHTML($html);
			ob_clean();
			$this->m_pdf->pdf->Output();
			ob_end_flush();
			exit;
		}
		/*------end of financial_report-----*/
		
		
	
		
	
		/******************************************
		 *  All Supply By a Specific Distributor  *
		 ******************************************/
		function supply_by_distributor()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'report_controller', 'supply_by_distributor'))
			{
		    $data['sale_status'] = '';
		    $data['user_type'] = $this->tank_auth->get_usertype();
		    $data['user_name'] = $this->tank_auth->get_username();
		    $query = $this -> report_model -> distributor_info();
		    $temp[''] = "Select A Distributor Name";
			foreach( $query -> result() as $field):
				$temp[ base_url().'index.php/report_controller/supply_by_distributor/'. $field -> distributor_id ] = $field -> distributor_name;
			endforeach;
		    $data['all_distributor'] = $temp;
		    $data['supplied_product'] = $this -> report_model -> supply_by_distributor( $this -> uri ->segment(3));
		    $data['alarming_level'] = FALSE;
			$data['main_content'] = 'supply_by_distributor_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
			}
			else redirect('report_controller/report/noaccess');
		}
		
		/************************************************
		 *  Print All Supply By a Specific Distributor  *
		 ************************************************/
		function print_supply_by_distributor()
		{
		    $timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
		    $data['supplied_product'] = $this -> report_model -> supply_by_distributor( $this -> uri ->segment(3));
			$this -> load -> view('supply_by_distributor_print_view', $data);
		}
		/******************************************
		 *  Specific Sold Product Search      **  *
		 ******************************************/
		function sold_product_search()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
		    $data['sale_status'] = '';
		    $data['user_type'] = $this->tank_auth->get_usertype();
		    $data['user_name'] = $this->tank_auth->get_username();
		    $temp_result = $this -> modify_model -> all_product();
		    $processed[''] = "Select A Product Name";
				foreach( $temp_result -> result() as $field):
					$processed[ base_url().'index.php/report_controller/sold_product_search/'. $field -> product_id ] = $field -> product_name;
				endforeach;
				$data['all_product'] = $processed;
		    //if( $this -> uri -> segment(3))
			$data['specific_product'] = $this -> modify_model -> specific_product( $this -> uri -> segment(3) );
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'sold_product_search_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
		}
		/******************************************
		 *  Specific Sold Product Search   Add    *
		 ******************************************/
		function sold_product_search_add()
		{
			redirect('report_controller/sold_product_search/'.$this -> input -> post('product_id'));	
		}
		/******************************************
		 *  Specific Sold Product Search  Result  *
		 ******************************************/
		function sold_product_search_result()
		{
		    $data['sale_status'] = '';
		    $data['user_type'] = $this->tank_auth->get_usertype();
		    $data['user_name'] = $this->tank_auth->get_username();
		    $data['start_date'] = $this -> input -> post('start_date');
		    $data['end_date'] = $this -> input -> post('end_date');
		    if( $this -> input -> post('specific_date')){
			    $data['start_date'] = $this -> input -> post('specific_date');
			    $data['end_date'] = $this -> input -> post('specific_date');
		    }
		    $data['product_id'] = $this -> input -> post('product_id');
		    $data['product_name'] = $this -> input -> post('product_name');
		    $is_individual = $this -> site_model -> product_specification( $data['product_id'] );
			$data['all_invoice'] = $this -> report_model ->  invoice_of_specific_product( $data['product_id'],  $data['start_date']  ,  $data['end_date'] , $is_individual );
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'sold_product_search_result_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
		}
		/******************************
		 * Cash in bank ,, Cash in hand 
		 * ****************************/
		function cash_status_report()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'report_controller', 'cash_status_report'))
			{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['cash_status_report_info'] = $this -> report_model -> cash_status_report_result_calculation('2013-11-01' ,  $data['bd_date']);
            //echo $data['ok'] = $this -> input -> post('ok');
            $data['alarming_level'] = FALSE;
			$data['main_content'] = 'cash_status_report_result_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
			}
			else redirect('report_controller/report/noaccess');
		}
		/*--------------------------------09-12-2013---------------------------
		 * 
		 * To print cash status report
		 * 
		 * Section : Accounts.
		 * *********************************************************************/
		function print_cash_status_report()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['cash_status_report_info'] = $this -> report_model -> cash_status_report_result_calculation('2013-11-01' ,  $data['bd_date']);
            //echo $data['ok'] = $this -> input -> post('ok');
            $data['alarming_level'] = FALSE;
			$this -> load -> view('cash_status_report_print_view', $data);
		}
			
		/****************************************
		 * Bar Code Test     ********************
		 * **************************************/
		
		function generate_barcode()
		{
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			$this -> load -> add_package_path(APPPATH.'third_party/Zend_framework');
		
			
			/*
			$barcodeOptions = array('text' => 'A');
			$rendererOptions = array(
									'text' => '3588',
									'barHeight' => '100'
								);
			$data['barcode'] = Zend_Barcode::factory('code39', 'image', $barcodeOptions, $rendererOptions)->render();
			*/
			/*
			$config = new Zend_Config(array(
										'barcode'        => 'code39',
										'barcodeParams'  => array(
																'text' => 'AC-15896',
																'barHeight' => '20',
																'font' => '2',
																'barThickWidth' => 3,
																'withBorder' => true,
																'factor' => 1,
																'height' => '100px',
																'width' => '200px',
																'withQuietZones' => true,
																'drawText' => true,
																'stretchText' => true,
															),
										'renderer'       => 'image',
										'rendererParams' => array('imageType' => 'jpg'),
									));
			$data['action'] = Zend_Barcode::factory($config) -> render();
			*/
			$name = 'BC49857';
			$barcodeOptions = array('text' => $name );
 
				$bc = Zend_Barcode::factory(
					'code39',
					'image',
					$barcodeOptions,
					array()
				);
				/* @var $bc Zend_Barcode */
				$res = $bc->draw();
				$filename = '/opt/lampp/htdocs/Dokani/barcode/'.$name;
				imagepng($res, $filename);
			$data['main_content'] = 'barcode_view';
		    $data['tricker_content'] = 'tricker_report_view';
		    $this -> load -> view('include/template', $data);
		}
		/*************************************************
		 *  All Transaction with a Specific Distributor  *
		 *************************************************/
		function transaction_with_distributor()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'report_controller', 'transaction_with_distributor'))
			{
		    $data['sale_status'] = '';
		    $data['user_type'] = $this->tank_auth->get_usertype();
		    $data['user_name'] = $this->tank_auth->get_username();
		    $query = $this -> report_model -> distributor_info();
		    $temp[''] = "Select A Distributor Name";
			foreach( $query -> result() as $field):
				$temp[ base_url().'index.php/report_controller/transaction_with_distributor/'. $field -> distributor_id ] = $field -> distributor_name;
			endforeach;
		    $data['all_distributor'] = $temp;
		    $data['supplied_product'] = $this -> report_model -> transaction_with_distributor( $this -> uri ->segment(3));
		    $data['alarming_level'] = FALSE;
			$data['main_content'] = 'transaction_with_distributor_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
			}
			else redirect('report_controller/report/noaccess');
		}
		
		/*********************************************
		 * Select Products lower Then Alarming level *
		 *********************************************/
		function product_under_alarming_level()
		{
			$data['sale_status'] = '';
		    $data['user_type'] = $this->tank_auth->get_usertype();
		    $data['user_name'] = $this->tank_auth->get_username();
		    $data['alarming_level'] = FALSE;
			$data['main_content'] = 'product_under_alarming_level_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
		}
		
		/****************************************************
		 * Select Random Products lower Then Alarming level *
		 ****************************************************/
		function print_product_under_alarming_level()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['alarming_level'] = FALSE;
			$this -> load -> view('product_under_alarming_level_print_view', $data);
		}
		
		/*********************************************
		 * Stock Status on a Specific Date           *
		 *********************************************/
		function stock_status_on_specific_date()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'report_controller', 'stock_status_on_specific_date'))
			{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['sale_status'] = '';
		    $data['user_type'] = $this->tank_auth->get_usertype();
		    $data['user_name'] = $this->tank_auth->get_username();
		    $data['alarming_level'] = FALSE;
		    $data['start_date'] = $this -> input -> post('start_date');
		    $data['end_date'] = $this -> input -> post('end_date');
		    if( $this -> input -> post('specific_date')){
			    $data['start_date'] = $this -> input -> post('specific_date');
			    $data['end_date'] = $this -> input -> post('specific_date');
		    }
		    $data['result_move'] = false;
		    if($data['start_date'] && $data['end_date'])
		    {
				$data['opening_stock'] = $this -> report_model -> stock_status_on_specific_date( $data['start_date'] , $data['bd_date']);
				$temp_date = date("Y-m-d",strtotime(date("Y-m-d", strtotime($data['end_date'])) . " +1 day"));
				$data['closing_stock'] = $this -> report_model -> stock_status_on_specific_date( $temp_date , $data['bd_date'] );
				$data['result_move'] = true;
			}
			$data['main_content'] = 'stock_status_on_specific_date_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
			}
			else redirect('report_controller/report/noaccess');
		}
		/*********************************************
		 * All Credit Transactions********************
		 * 
		 * Section : Accounts
		 * *********************************************/
		function all_credit_transactions()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			
			$data['customer_credit_transactions'] =  $this -> account_model -> fatch_all_customer_credit_transactions();
			$data['alarming_level'] = FALSE;
			//$data['main_content'] = 'all_credit_transaction_form_view';
			//$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('all_credit_transaction_form_view', $data);
		}
		/*********************************************
		 * Print All Credit Transactions
		 * 
		 * Section : Accounts
		 * *********************************************/
		function print_all_credit_transaction()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			
			$data['customer_credit_transactions'] =  $this -> account_model -> fatch_all_customer_credit_transactions();
			$data['alarming_level'] = FALSE;
			$this -> load -> view('all_credit_transaction_print_view', $data);
		}
		
		/****************************************************************************************
		 * this will fatch all information about best saling product and less saling product
		 * 
		 * Section: Report
		 * **************************************************************************************/
		function product_statistics()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = date('Y-m-d');
			
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			if($this->input->post('specific_date')){
			$data['bd_date'] = $this->input->post('specific_date');
			$data['previous_date'] = $this->input->post('specific_date');
			$limit_level = $this->input->post('limit_level');
			}
			else if($this->input->post('end_date')){
			$data['bd_date'] = $this->input->post('end_date');
			$data['previous_date'] = $this->input->post('start_date');
			$limit_level = $this->input->post('limit_level2');
			}
			else{
			$data['bd_date'] = $bd_date;
			$data['previous_date'] = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 30, date("y")));
			$limit_level = 5;
			}
			
			$data[ 'best_sale_info' ] = $this -> report_model -> best_sale( $data['previous_date']  ,  $data['bd_date'] , $limit_level );
		    $data[ 'slow_sale_info' ] = $this -> report_model -> slow_sale( $data['previous_date']  ,  $data['bd_date'] , $limit_level );
		    
		    
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'product_statistics_form_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
		}
		/*******************************************************
		 *  This will fatch all cheque details
		 *  Besides user can see cheque's date wise too..
		 * 
		 *  Section : Accounts & Report.
		 **************************************************************/
		 function all_cheque_detials()
		 {
			$data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'report_controller', 'all_cheque_detials'))
			{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['cheque_modes'] = $this -> my_variables_model -> select_cheque_mode();
			$data['cheque_status'] = $this -> my_variables_model -> fatch_all_cheque_change_status_purpose(0, 0,0);

            $data['start_date'] = $this -> input -> post('start_date');
		    $data['end_date'] = $this -> input -> post('end_date');
		    
		    if( $this -> input -> post('specific_date'))
		    {
			   $data['start_date'] = $this -> input -> post('specific_date');
			   $data['end_date'] = $this -> input -> post('specific_date');
		    }
			$data[ 'date_wise_cheque_details_info' ] = $this -> report_model -> date_wise_cheque_details_calculation( false,0,$data['start_date']  ,  $data['end_date']); 
            
			$query_for_distributors = $this -> report_model -> all_distributor_whome_hv_transation_by_cheque(false,0);
			$distributors[''] = 'Select Distributor Name'; 
			if($query_for_distributors->  num_rows() > 0)
			{	
				$distributors[base_url().'index.php/report_controller/all_cheque_detials/all_distributor/bydistributor'] = 'All Distributors'; 
				foreach($query_for_distributors -> result() as $field):
					$distributors[base_url().'index.php/report_controller/all_cheque_detials/'.$field -> distributor_id.'/bydistributor'] = $field -> distributor_name.' (Mob : '.$field -> distributor_contact_no.'  )';	
				endforeach;
			}
			$data['all_distributors'] = $distributors;
 			
			$temp_customer_info = $this -> report_model -> all_customer_whome_hv_transation_by_cheque(false,0);
			$customers[''] = "Select Customer Name";
			$customers[base_url().'index.php/report_controller/all_cheque_detials/all_customer/bycustomer'] = 'All Customers'; 
			foreach($temp_customer_info -> result() as $field):
				$customers[base_url().'index.php/report_controller/all_cheque_detials/'.$field -> customer_id.'/bycustomer'] = $field -> customer_name.' (Mob : '. $field -> customer_contact_no.' )';
			endforeach;
			$data['all_customers'] = $customers;
			
			
			//$segment_3 = $this -> uri -> segment(3);
			$segment_4 = $this -> uri -> segment(4);
			
			if( $segment_4 == 'bymode')
			{
				$data['bymode_query'] = $this ->report_model -> fatch_cheque_details_by_mode($this -> uri -> segment(3));
				$data['query_status'] = 'No result found.!';
			}
			if( $segment_4 == 'bystatus')
			{
				$data['bystatus_query'] = $this ->report_model -> fatch_cheque_details_by_status($this -> uri -> segment(3));
				$data['query_status'] = 'There is no transaction of this status.';
			}
			if( $segment_4 == 'bydistributor')
			{
				if($this -> uri -> segment(3) == 'all_distributor')
					$data['bydistributor_query'] = $this -> report_model -> all_distributor_whome_hv_transation_by_cheque(false,$this -> uri -> segment(3));
				else $data['bydistributor_query'] = $this -> report_model -> all_distributor_whome_hv_transation_by_cheque(true,$this -> uri -> segment(3));
				$data['query_status'] = 'There is no transaction with this distributor.';
			}
			if( $segment_4 == 'bycustomer')
			{
				if($this -> uri -> segment(3) == 'all_customer')
					$data['bycustomer_query'] = $this -> report_model -> all_customer_whome_hv_transation_by_cheque(false,$this -> uri -> segment(3));
				else $data['bycustomer_query'] = $this -> report_model -> all_customer_whome_hv_transation_by_cheque(true,$this -> uri -> segment(3));
				$data['query_status'] = 'There is no transaction with this customer.';
			}
				
	
			$data['due_status'] = '';
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'all_cheque_details_form_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
			}
			else redirect('report_controller/report/noaccess');
		 }
		 /*------------------08-12-2013---------------
		  * this will print all sort of cheque details
		  * 
		  * Section : Accounts
		  * */
		 function print_all_cheque_details()
		 {
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['cheque_modes'] = $this -> my_variables_model -> select_cheque_mode();
			$data['cheque_status'] = $this -> my_variables_model -> fatch_all_cheque_change_status_purpose(0, 0,0);

            if($segment_3 = $this -> uri -> segment(3) == 'thisPageDateWise')
            {
				$data['start_date'] = $this -> uri -> segment(4);
				$data['end_date'] = $this -> uri -> segment(5);  
				$data[ 'date_wise_cheque_details_info' ] = $this -> report_model -> date_wise_cheque_details_calculation( false,0,$data['start_date']  ,  $data['end_date']); 
				
			}
            else if($segment_3 = $this -> uri -> segment(3) == 'dateWise')
            {
				$data['start_date'] = $this -> uri -> segment(4);
				$data['end_date'] = $this -> uri -> segment(5);  
				$data[ 'date_wise_cheque_details_info' ] = $this -> report_model -> date_wise_cheque_details_calculation(true,$this->uri->segment(6),$data['start_date']  ,  $data['end_date']); 
				
			}
			else
			{
				$segment_6 = $this -> uri -> segment(4);
				
				if( $segment_6 == 'bymode')
				{
					$data['bymode_query'] = $this ->report_model -> fatch_cheque_details_by_mode($this -> uri -> segment(3));
					$data['query_status'] = 'No result found.!';
				}
				if( $segment_6 == 'bystatus')
				{
					$data['bystatus_query'] = $this ->report_model -> fatch_cheque_details_by_status($this -> uri -> segment(3));
					$data['query_status'] = 'There is no transaction of this status.';
				}
				if( $segment_6 == 'bydistributor')
				{
					if($this -> uri -> segment(3) == 'all_distributor')
						$data['bydistributor_query'] = $this -> report_model -> all_distributor_whome_hv_transation_by_cheque(false,$this -> uri -> segment(3));
					else $data['bydistributor_query'] = $this -> report_model -> all_distributor_whome_hv_transation_by_cheque(true,$this -> uri -> segment(3));
					$data['query_status'] = 'There is no transaction with this distributor.';
				}
				if( $segment_6 == 'bycustomer')
				{
					if($this -> uri -> segment(3) == 'all_customer')
						$data['bycustomer_query'] = $this -> report_model -> all_customer_whome_hv_transation_by_cheque(false,$this -> uri -> segment(3));
					else $data['bycustomer_query'] = $this -> report_model -> all_customer_whome_hv_transation_by_cheque(true,$this -> uri -> segment(3));
					$data['query_status'] = 'There is no transaction with this customer.';
				} 
			}
			$data['due_status'] = '';
			$data['alarming_level'] = FALSE;
			$this -> load -> view('all_cheque_details_print_view', $data);
		}
		/************************************************************
		  * ----------------------Ledger Generation------------------
		  * 
		  * this will load the ledger generation form view page------
		  * 
		  * Section : Accounts
		  * ---------------------------------------------------------
		*************************************************************/
		function ledger_generation()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'registration_controller', 'employee_salary_setup'))
			{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			
			$data['transaction_purpose'] = $this -> account_model -> fatch_all_transaction_purpose(); 
			//$segment_3 = $this -> uri -> segment(3);
			$segment_4 = $this -> uri -> segment(4);
			
            $data['start_date'] = $this -> input -> post('start_date');
		    $data['end_date'] = $this -> input -> post('end_date');
		    
		    if( $this -> input -> post('specific_date'))
		    {
			   $data['start_date'] = $this -> input -> post('specific_date');
			   $data['end_date'] = $this -> input -> post('specific_date');
		    }
			$data[ 'date_wise_cheque_details_info' ] = $this -> report_model -> date_wise_cheque_details_calculation(false,0, $data['start_date']  ,  $data['end_date']); 
            
			//$query_for_distributors = $this -> report_model -> all_distributor_whome_hv_transation_by_cheque(false,0);
			$data['query_for_distributors'] = $this -> product_model -> distributor_info();

			$temp_customer_info = $this -> sale_model -> specific_customer_info(false,0);
			$customers[''] = "Select Customer Name";
			foreach($temp_customer_info -> result() as $field):
				$customers[$field -> customer_id] = $field -> customer_name.' (Mob : '. $field -> customer_contact_no.' )';
			endforeach;
			$data['all_customers'] = $customers;	
			
			$temp_service_provider_info = $this -> report_model -> all_service_providers_information(false,0);
			$service_providers[''] = "Select Service Provider Name";
			foreach($temp_service_provider_info -> result() as $field):
				$service_providers[$field -> service_provider_id] = $field -> service_provider_name.' (Mob : '. $field -> service_provider_contact.' )';
			endforeach;
			//$data['all_service_providers'] = $service_providers;	
			$data['all_service_providers'][''] = 'Modification going on';	
			
			
			/*if( $segment_4 == 'bymode')
			{
				$data['bymode_query'] = $this ->report_model -> fatch_cheque_details_by_mode($this -> uri -> segment(3));
				$data['query_status'] = 'No result found.!';
			}
			if( $segment_4 == 'bystatus')
			{
				$data['bystatus_query'] = $this ->report_model -> fatch_cheque_details_by_status($this -> uri -> segment(3));
				$data['query_status'] = 'There is no transaction of this status.';
			}
			if( $segment_4 == 'bydistributor')
			{
				if($this -> uri -> segment(3) == 'all_distributor')
					$data['bydistributor_query'] = $this -> report_model -> all_distributor_whome_hv_transation_by_cheque(false,$this -> uri -> segment(3));
				else $data['bydistributor_query'] = $this -> report_model -> all_distributor_whome_hv_transation_by_cheque(true,$this -> uri -> segment(3));
				$data['query_status'] = 'There is no transaction with this distributor.';
			}
			if( $segment_4 == 'bycustomer')
			{
				if($this -> uri -> segment(3) == 'all_customer')
					$data['bycustomer_query'] = $this -> report_model -> all_customer_whome_hv_transation_by_cheque(false,$this -> uri -> segment(3));
				else $data['bycustomer_query'] = $this -> report_model -> all_customer_whome_hv_transation_by_cheque(true,$this -> uri -> segment(3));
				$data['query_status'] = 'There is no transaction with this customer.';
			}
			if( $segment_4 == 'byserviceprovider')
			{
				if($this -> uri -> segment(3) == 'all_service_provider')
					$data['byserviceprovider_query'] = $this -> report_model -> all_customer_whome_hv_transation_by_cheque(false,$this -> uri -> segment(3));
				else $data['byserviceprovider_query'] = $this -> report_model -> all_customer_whome_hv_transation_by_cheque(true,$this -> uri -> segment(3));
				$data['query_status'] = 'There is no transaction with this customer.';
			}
			*/
			$data['due_status'] = '';
			$data['alarming_level'] = FALSE;
			//$data['main_content'] = 'ledger_generation_form_view';
			//$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('ledger_generation_form_view', $data);
			}
			else redirect('report_controller/report/noaccess');
		}
		/************************************************************
		  * ----------------------Ledger Generation------------------
		  * 
		  * this will generate every possible ledgers----------------
		  * 
		  * Section : Accounts
		  * ---------------------------------------------------------
		*************************************************************/
		function create_ledger()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['expense_type'] = '';
            $data['start_date'] = $this -> input -> post('start_date');
		    $data['end_date'] = $this -> input -> post('end_date');
			
			$data['is_date'] = false;
		    if($this -> input -> post('specific_date') !='')
		    {
			   $data['is_date'] = true;
			   $data['start_date'] = $this -> input -> post('specific_date');
			   $data['end_date'] = $this -> input -> post('specific_date');
		    }
		    else if( !$this -> input -> post('start_date') && $this -> input -> post('end_date'))
		    {
			    $data['is_date'] = true;
				$data['start_date'] = $this -> input -> post('end_date');
			    $data['end_date'] = $this -> input -> post('end_date');
			}
			else if( $this -> input -> post('start_date') && !$this -> input -> post('end_date'))
			{
				 $data['is_date'] = true;
				$data['start_date'] = $this -> input -> post('start_date');
			    $data['end_date'] = $this -> input -> post('start_date');
			}
			else if( $this -> input -> post('start_date') && $this -> input -> post('end_date'))
			{
				 $data['is_date'] = true;
				$data['start_date'] = $this -> input -> post('start_date');
			    $data['end_date'] = $this -> input -> post('end_date');
			}
			else if(!$this -> input -> post('start_date') && !$this -> input -> post('end_date'))
			{
				$data['is_date'] = true;
				$data['start_date'] ='2013-01-01';
			    $data['end_date'] = $data['bd_date'];
			}
			
			$data['for_who_or_what'] = '';
			
			$data['distributor_id'] = $this -> input -> post('distributor_id');
			$data['customer_id'] = $this -> input -> post('customer_id');
			$data['service_prover_id']= $this -> input -> post('service_provider_id');
			$data['transaction_purpose'] = $this -> input -> post('transaction_purpose');
		
			if($data['is_date'] == true)
			{
				/*if($data['distributor_id'])
				{
					/***************Arafat****************/
						/*array initia;ization*/
						/*$startDate = date($data['start_date']);
						$endDate = date($data['end_date']);
						
						$initialization[$startDate]['receipt_id'] = 0;
						$initialization[$startDate]['purchase'] = 0;
						$initialization[$startDate]['payment'] = 0;

						while(true){
							$today = date("Y-m-d",strtotime(date("Y-m-d", strtotime($startDate)) . " +1 day"));
							$startDate = date("Y-m-d",strtotime($today));
							
							$initialization[$startDate]['purchase'] = 0;
							$initialization[$startDate]['payment'] = 0;
								
							if(date($startDate) == date($endDate))  break;
						}*/
					/***************************************/
					
					/*$data['for_who_or_what'] = 'distributor';
					$data['my_ledger']= $this -> report_model -> ledger_generation(true,true,$data['for_who_or_what'],$data['distributor_id'],$data['start_date'],$data['end_date']);
					
					
					$diposit_details = $this -> account_model -> fatch_deposit_details_by_distributor($data['distributor_id']);
					$data['diposit_amount'] = 0;
					if($diposit_details -> num_rows() > 0)
					{	
						foreach($diposit_details -> result() as $field):
							 $data['diposit_amount']= $field -> diposit_amount;
						endforeach;
					}
					*/
					
					/*foreach($query['date_wise_total_purchase'] -> result() as $field):
						$initialization[$field -> receipt_date]['purchase'] = $field -> purchase_amount;
						$initialization[$field -> receipt_date]['receipt_id'] = $field -> receipt_id;
						$data['distributor_name'] = $field -> distributor_name;
					endforeach;
					
					
					foreach($query['date_wise_total_payment'] -> result() as $field):
						$initialization[$field -> transaction_doc]['payment'] = $field -> total_payment_amount;
						$data['distributor_name'] = $field -> distributor_name;
					endforeach;
					
					$temp_receipt_amount = 0;$paid_ob_amount_before =0;
					foreach($query['receipt_amount_ob'] -> result() as $field):
						$temp_receipt_amount = $field -> receipt_amount_ob; 
					endforeach;
					foreach($query['paid_amount_before'] -> result() as $field):	
						 $paid_ob_amount_before = $field -> paid_ob_amount; 
					endforeach;
					$data['temp_opening_balance'] = $temp_receipt_amount - $paid_ob_amount_before;
					
					$data['ledger_details'] = $initialization;*/
					
					//~ foreach($query['my_ledger'] -> result() as $field):
						//~ $data['distributor_name'] = $field -> distributor_name;
						//~ $data['receipt_id'] = $field -> receipt_id;
						//~ $data['purchased_amount'] = $field -> grand_total;
						//~ $data['total_paid'] = $field -> total_paid;
						//~ //$data['distributor_name'] = $field -> distributor_name;
					//~ endforeach;
					
				/*
				}
				*/
				if($data['distributor_id'])
				{
					/***************Arafat****************/
						/*array initia;ization*/
						$startDate = date($data['start_date']);
						$endDate = date($data['end_date']);
						
						$initialization[$startDate]['purchase'] = 0;
						$initialization[$startDate]['payment'] = 0;

						while(true){
							$today = date("Y-m-d",strtotime(date("Y-m-d", strtotime($startDate)) . " +1 day"));
							$startDate = date("Y-m-d",strtotime($today));
							
							$initialization[$startDate]['purchase'] = 0;
							$initialization[$startDate]['payment'] = 0;
								
							if(date($startDate) == date($endDate))  break;
						}
					/***************************************/
					
					$data['for_who_or_what'] = 'distributor';
					$data['distributor_name'] = 'No Transaction Found..!!';
					$query = $this -> report_model -> ledger_generation(true,true,$data['for_who_or_what'],$data['distributor_id'],$data['start_date'],$data['end_date']);
					
					foreach($query['date_wise_total_purchase'] -> result() as $field):
						$initialization[$field -> receipt_date]['purchase'] = $field -> purchase_amount;
						$data['distributor_name'] = $field -> distributor_name;
					endforeach;
					
					$diposit_amount_final= $this -> account_model -> fatch_deposit_details_by_distributor($data['distributor_id']);
					$data['diposit_amount'] = 0;
					foreach($diposit_amount_final -> result() as $temp_field):
						 $data['diposit_amount'] += $temp_field -> diposit_amount;
					endforeach;
					
					foreach($query['date_wise_total_payment'] -> result() as $field):
						$initialization[$field -> transaction_doc]['payment'] = $field -> total_payment_amount;
						$data['distributor_name'] = $field -> distributor_name;
					endforeach;
					
					$temp_receipt_amount = 0;$paid_ob_amount_before =0;
					foreach($query['receipt_amount_ob'] -> result() as $field):
						$temp_receipt_amount = $field -> receipt_amount_ob; 
					endforeach;
					foreach($query['paid_amount_before'] -> result() as $field):	
						 $paid_ob_amount_before = $field -> paid_ob_amount; 
					endforeach;
					$data['temp_opening_balance'] = $temp_receipt_amount - $paid_ob_amount_before;
					
					foreach($query['total_damage_quantity'] -> result() as $field):	
						 $damage_quantity_new = $field -> damage_quantity_new; 
						 $damage_price = $field -> unit_buy_price; 
						 $final_damage= $damage_quantity_new * $damage_price;
					endforeach;
					$data['final_damage_new'] = $final_damage;
					$data['ledger_details'] = $initialization;
				}
				else if($data['customer_id'])
				{
					/***************Arafat****************/
						/*array initia;ization*/
						$startDate = date($data['start_date']);
						$endDate = date($data['end_date']);
						
						$initialization[$startDate]['total_sale'] = 0;
						$initialization[$startDate]['total_discount'] = 0;
						$initialization[$startDate]['paid_by_cash'] = 0;
						$initialization[$startDate]['paid_by_cheque'] = 0;

						while(true){
							$today = date("Y-m-d",strtotime(date("Y-m-d", strtotime($startDate)) . " +1 day"));
							$startDate = date("Y-m-d",strtotime($today));
							
							$initialization[$startDate]['total_sale'] = 0;
							$initialization[$startDate]['total_discount'] = 0;
							$initialization[$startDate]['paid_by_cash'] = 0;
							$initialization[$startDate]['paid_by_cheque'] = 0;
								
							if(date($startDate) == date($endDate))  break;
						}
					/***************************************/
					
					$data['for_who_or_what'] = 'customer';
					$data['customer_name'] = 'No Transaction Found..!!';
					$query = $this -> report_model -> ledger_generation(true,true,$data['for_who_or_what'],$data['customer_id'],$data['start_date'],$data['end_date']);
					
					
					foreach($query['date_wise_total_sale'] -> result() as $field):
						$initialization[$field -> invoice_doc]['total_sale'] = $field -> invoice_amount;
						$initialization[$field -> invoice_doc]['total_discount'] = $field -> dis_amount;
						//$discount_amount += $field -> dis_amount;
						$data['customer_name'] = $field -> customer_name;
					endforeach;
					
					
					foreach($query['date_wise_total_payment_cash'] -> result() as $field):
						$initialization[$field -> transaction_doc]['paid_by_cash'] = $field -> amount_by_cash;
						$data['customer_name'] = $field -> customer_name;
					endforeach;
					foreach($query['date_wise_total_payment_cheque'] -> result() as $field):
						$initialization[$field -> transaction_doc]['paid_by_cheque'] = $field -> amount_by_cheque;
						$data['customer_name'] = $field -> customer_name;
					endforeach;
					
					
					
					$temp_invoice_amount = 0;$paid_ob_amount_before =0;
					$temp_amount_one = 0; $temp_amount_two = 0;$discount_amount = 0;
					foreach($query['invoice_amount_ob'] -> result() as $field):
						$temp_invoice_amount = $field -> invoice_amount; 
						$discount_amount += $field -> temp_dis_amount;
					endforeach;
					foreach($query['paid_amount_before'] -> result() as $field):	
					     $temp_amount_one =  $field -> ta_one;
					     $temp_amount_two =  $field -> ta_two;
						 $paid_ob_amount_before = $temp_amount_one + $temp_amount_two;
					endforeach;
					$data['temp_opening_balance'] = $temp_invoice_amount - ($paid_ob_amount_before + $discount_amount) ;
					
					$data['ledger_details'] = $initialization;
				}
				else if($data['service_prover_id'])	
				{
					/***************Arafat****************/
						/*array initia;ization*/
						$startDate = date($data['start_date']);
						$endDate = date($data['end_date']);
						
						$initialization[$startDate]['service_provider'] = 0;
						$initialization[$startDate]['payment'] = 0;

						while(true){
							$today = date("Y-m-d",strtotime(date("Y-m-d", strtotime($startDate)) . " +1 day"));
							$startDate = date("Y-m-d",strtotime($today));
							
							$initialization[$startDate]['service_provider'] = 0;
							$initialization[$startDate]['payment'] = 0;
							/*need to initialize*/
								
							if(date($startDate) == date($endDate))  break;
						}
					/***************************************/
					$data['for_who_or_what'] = 'service_provider';
					$data['ledger_details'] = $this -> report_model -> ledger_generation(true,true,$data['for_who_or_what'],$data['service_prover_id'],$data['start_date'],$data['end_date']);
				}
				else if($data['transaction_purpose'])
				{
					$data['for_who_or_what'] = 'transaction_purpose';
					$data['ledger_details'] = $this -> report_model -> ledger_generation(true,true,$data['for_who_or_what'],$data['transaction_purpose'],$data['start_date'],$data['end_date']);
					if($data['transaction_purpose'] == 'expense'){
						$data['expense_type'] = $this -> my_variables_model -> all_expense_type_info();
					}
				}
			}
			else
			{
				if($data['distributor_id'])
				{
					
					/***************Arafat****************/
						/*array initia;ization*/

						$startDate = $data['start_date'] = '2013-01-01';
						$endDate = $data['end_date'] = $bd_date;

						$initialization[$startDate]['purchase'] = 0;
						$initialization[$startDate]['payment'] = 0;

						while(true){
							$today = date("Y-m-d",strtotime(date("Y-m-d", strtotime($startDate)) . " +1 day"));
							$startDate = date("Y-m-d",strtotime($today));
							
							$initialization[$startDate]['purchase'] = 0;
							$initialization[$startDate]['payment'] = 0;
								
							if(date($startDate) == date($endDate))  break;
						}
					/***************************************/

					$data['for_who_or_what'] = 'distributor';
					$query = $this -> report_model -> ledger_generation(false,true,$data['for_who_or_what'],$data['distributor_id'],0,0);
					
					foreach($query['date_wise_total_purchase'] -> result() as $field):
						$initialization[$field -> receipt_date]['purchase'] = $field -> purchase_amount;
						$data['distributor_name'] = $field -> distributor_name;
					endforeach;
					
					foreach($query['date_wise_total_payment'] -> result() as $field):
						$initialization[$field -> transaction_doc]['payment'] = $field -> total_payment_amount;
						$data['distributor_name'] = $field -> distributor_name;
					endforeach;
					
					/*$temp_receipt_amount = 0; $paid_ob_amount_before =0;
					foreach($query['receipt_amount_ob'] -> result() as $field):
						$temp_receipt_amount = $field -> receipt_amount_ob; 
					endforeach;
					foreach($query['paid_amount_before'] -> result() as $field):	
						 $paid_ob_amount_before = $field -> paid_ob_amount; 
					endforeach;*/
					$data['temp_opening_balance'] = 0;
					
					$data['ledger_details'] = $initialization;
				}
				else if($data['customer_id'])
				{
					/***************Arafat****************/
						/*array initia;ization*/

						$startDate = $data['start_date'] = '2013-01-01';
						$endDate = $data['end_date'] = $bd_date;

						$initialization[$startDate]['total_sale'] = 0;
						$initialization[$startDate]['paid_by_cash'] = 0;
						$initialization[$startDate]['paid_by_cheque'] = 0;

						while(true){
							$today = date("Y-m-d",strtotime(date("Y-m-d", strtotime($startDate)) . " +1 day"));
							$startDate = date("Y-m-d",strtotime($today));
							
							$initialization[$startDate]['total_sale'] = 0;
							$initialization[$startDate]['paid_by_cash'] = 0;
							$initialization[$startDate]['paid_by_cheque'] = 0;
								
							if(date($startDate) == date($endDate))  break;
						}
					/***************************************/
                   // echo 'hello';
					$data['for_who_or_what'] = 'customer';
					$query = $this -> report_model -> ledger_generation(false,true,$data['for_who_or_what'],$data['customer_id'],0,0);
					
					foreach($query['date_wise_total_sale'] -> result() as $field):
						$initialization[$field -> invoice_doc]['total_sale'] = $field -> invoice_amount;
						$initialization[$field -> invoice_doc]['total_discount'] = $field -> dis_amount;
						$data['customer_name'] = $field -> customer_name;
					endforeach;
					
					foreach($query['date_wise_total_payment_cash'] -> result() as $field):
						$initialization[$field -> transaction_doc]['paid_by_cash'] = $field -> amount_by_cash;
						$data['customer_name'] = $field -> customer_name;
					endforeach;
					foreach($query['date_wise_total_payment_cheque'] -> result() as $field):
						$initialization[$field -> transaction_doc]['paid_by_cheque'] = $field -> amount_by_cheque;
						$data['customer_name'] = $field -> customer_name;
					endforeach;
					
					
					$data['temp_opening_balance'] = 0;
					$data['ledger_details'] = $initialization;
				}
				else if($data['service_prover_id'])	
				{
					$data['for_who_or_what'] = 'service_provider';
					$data['ledger_details' ] = $this -> report_model -> ledger_generation(false,true,$data['for_who_or_what'],$data['service_prover_id'],0, 0);
				}
				else if($data['transaction_purpose'])
				{
					$data['for_who_or_what'] = 'transaction_purpose';
					$data['ledger_details' ] = $this -> report_model -> ledger_generation(false,true,$data['for_who_or_what'],$data['transaction_purpose'],0 , 0);	
					if($data['transaction_purpose'] == 'expense'){
						$data['expense_type'] = $this -> my_variables_model -> all_expense_type_info();
					}
				}
			}
				
            if(!$data['distributor_id'] && (!$data['customer_id']) && (!$data['service_prover_id']) && (!$data['transaction_purpose']))
                redirect('report_controller/ledger_generation');


			$data['alarming_level'] = FALSE;
			//$data['main_content'] = 'ledger_generation_result_view';
			//$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('ledger_generation_result_view', $data);
			
		}
		
		/*for printing  ledger  */
		function print_ledger_report()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['sale_status'] = '';
		    $data['status'] = '';
		    $data['user_type'] = $this->tank_auth->get_usertype();
		    $data['user_name'] = $this->tank_auth->get_username();
		    //~ $data['start_date'] = $this -> uri -> segment(3);
		    //~ $data['end_date'] = $this -> uri -> segment(4);  
		    //~ $data[ 'financial_statement_info' ] = $this -> report_model -> date_wise_financial_statement_calculation( $data['start_date']  ,  $data['end_date']);
		    //~ $data['payable_receivable_financial_statement'] = $this -> report_model -> payable_receivable_financial_statement($data['start_date']  ,  $data['end_date']);
		    //~ $data['cash_status_report_info'] = $this -> report_model -> cash_status_report_result_calculation();
		    //~ $data['date_wise_total_discount']= $this -> report_model -> specific_date_discount_calculation( $data['start_date']  ,  $data['end_date']);
		    //~ 
		    //~ $data['opening_stock'] = $this -> report_model -> stock_status_on_specific_date( $data['start_date'] , $data['bd_date']);
			//~ $temp_date = date("Y-m-d",strtotime(date("Y-m-d", strtotime($data['end_date'])) . " +1 day"));
			//~ $data['closing_stock'] = $this -> report_model -> stock_status_on_specific_date( $temp_date , $data['bd_date'] );

			//~ $data[ 'sale_price_info' ] = $this -> report_model -> specific_date_sale_price_calculation(  $data['start_date']  ,  $data['end_date']  );
		    //~ $data[ 'buy_price_info' ] = $this -> report_model -> specific_date_buy_price_calculation(  $data['start_date']  ,  $data['end_date'] );
		    //~ $data['all_stock'] = $this -> report_model -> get_all_stock_report();
		    //~ 
		    
		   
		    $data['start_date'] = $this -> uri -> segment(3);
		    $data['end_date'] = $this -> uri -> segment(4);  
			
			$data['is_date'] = true;
		   /* if($this -> input -> post('specific_date') !='')
		    {
			   $data['is_date'] = true;
			   $data['start_date'] = $this -> input -> post('specific_date');
			   $data['end_date'] = $this -> input -> post('specific_date');
		    }
		    else if( !$this -> input -> post('start_date') && $this -> input -> post('end_date'))
		    {
			    $data['is_date'] = true;
				$data['start_date'] = $this -> input -> post('end_date');
			    $data['end_date'] = $this -> input -> post('end_date');
			}
			else if( $this -> input -> post('start_date') && !$this -> input -> post('end_date'))
			{
				 $data['is_date'] = true;
				$data['start_date'] = $this -> input -> post('start_date');
			    $data['end_date'] = $this -> input -> post('start_date');
			}
			else if( $this -> input -> post('start_date') && $this -> input -> post('end_date'))
			{
				 $data['is_date'] = true;
				$data['start_date'] = $this -> input -> post('start_date');
			    $data['end_date'] = $this -> input -> post('end_date');
			}
			else if(!$this -> input -> post('start_date') && !$this -> input -> post('end_date'))
			{
				$data['is_date'] = true;
				$data['start_date'] ='2013-01-01';
			    $data['end_date'] = $data['bd_date'];
			}
			*/
			//~ echo $distributor_id =$this -> uri -> segment(5);  
			//~ echo $customer_id = $this -> uri -> segment(6);  
			//~ echo $service_prover_id = $this -> uri -> segment(7);  
			//~ echo $transaction_purpose = $this -> uri -> segment(8); 
			//~ echo $data['for_who_or_what'] = $this -> uri -> segment(9);   
			//~ $distributor_id =$this -> uri -> segment(5);  
			//~ $customer_id = $this -> uri -> segment(6);  
			//~ $service_prover_id = $this -> uri -> segment(7);  
		    //~ $transaction_purpose = $this -> uri -> segment(8); 
			//~ $data['for_who_or_what'] = $this -> uri -> segment(9);  
			
			$transaction_purpose = '';$distributor_id = ''; $customer_id = '';
			$data['for_who_or_what'] = $this -> uri -> segment(6);  
			
			if($data['for_who_or_what'] == 'distributor')
				$distributor_id = $this -> uri -> segment(5); 	
			else if($data['for_who_or_what'] == 'customer')
				$customer_id = $this -> uri -> segment(5); 		
			else if($data['for_who_or_what'] == 'transaction_purpose')
			{
				$transaction_purpose = $this -> uri -> segment(5); 	
				$data['transaction_purpose'] = $this -> uri -> segment(5); 	
			}

			if($data['is_date'] == true)
			{
				if($transaction_purpose)
				{
					$data['for_who_or_what'] = 'transaction_purpose';
					$data['ledger_details'] = $this -> report_model -> ledger_generation(true,true,$data['for_who_or_what'],$transaction_purpose,$data['start_date'],$data['end_date']);	
				}
				else
				{
					if($distributor_id)
					{
						/***************Arafat****************/
							/*array initia;ization*/
							$startDate = date($data['start_date']);
							$endDate = date($data['end_date']);
							
							$initialization[$startDate]['purchase'] = 0;
							$initialization[$startDate]['payment'] = 0;

							while(true){
								$today = date("Y-m-d",strtotime(date("Y-m-d", strtotime($startDate)) . " +1 day"));
								$startDate = date("Y-m-d",strtotime($today));
								
								$initialization[$startDate]['purchase'] = 0;
								$initialization[$startDate]['payment'] = 0;
									
								if(date($startDate) == date($endDate))  break;
							}
						/***************************************/
						
						$data['for_who_or_what'] = 'distributor';
						$data['distributor_name'] = 'No Transaction Found..!!';
						$query = $this -> report_model -> ledger_generation(true,true,$data['for_who_or_what'],$distributor_id,$data['start_date'],$data['end_date']);
						
						foreach($query['date_wise_total_purchase'] -> result() as $field):
							$initialization[$field -> receipt_date]['purchase'] = $field -> purchase_amount;
							$data['distributor_name'] = $field -> distributor_name;
						endforeach;
						
						$diposit_amount_final= $this -> account_model -> fatch_deposit_details_by_distributor($distributor_id);
						$data['diposit_amount'] = 0;
						foreach($diposit_amount_final -> result() as $temp_field):
							 $data['diposit_amount'] += $temp_field -> diposit_amount;
						endforeach;
						
						foreach($query['date_wise_total_payment'] -> result() as $field):
							$initialization[$field -> transaction_doc]['payment'] = $field -> total_payment_amount;
							$data['distributor_name'] = $field -> distributor_name;
						endforeach;
						
						$temp_receipt_amount = 0;$paid_ob_amount_before =0;
						foreach($query['receipt_amount_ob'] -> result() as $field):
							$temp_receipt_amount = $field -> receipt_amount_ob; 
						endforeach;
						foreach($query['paid_amount_before'] -> result() as $field):	
							 $paid_ob_amount_before = $field -> paid_ob_amount; 
						endforeach;
						$data['temp_opening_balance'] = $temp_receipt_amount - $paid_ob_amount_before;
						
						foreach($query['total_damage_quantity'] -> result() as $field):	
						 $damage_quantity_new = $field -> damage_quantity_new; 
						 $damage_price = $field -> unit_buy_price; 
						 $final_damage= $damage_quantity_new * $damage_price;
						endforeach;
						
						$data['final_damage_new'] = $final_damage;
						$data['ledger_details'] = $initialization;
					}
					else if($customer_id)
					{
						/***************Arafat****************/
							/*array initia;ization*/
							$startDate = date($data['start_date']);
							$endDate = date($data['end_date']);
							
							$initialization[$startDate]['total_sale'] = 0;
							$initialization[$startDate]['total_discount'] = 0;
							$initialization[$startDate]['paid_by_cash'] = 0;
							$initialization[$startDate]['paid_by_cheque'] = 0;

							while(true){
								$today = date("Y-m-d",strtotime(date("Y-m-d", strtotime($startDate)) . " +1 day"));
								$startDate = date("Y-m-d",strtotime($today));
								
								$initialization[$startDate]['total_sale'] = 0;
								$initialization[$startDate]['total_discount'] = 0;
								$initialization[$startDate]['paid_by_cash'] = 0;
								$initialization[$startDate]['paid_by_cheque'] = 0;
									
								if(date($startDate) == date($endDate))  break;
							}
						/***************************************/
						
						$data['for_who_or_what'] = 'customer';
						$data['customer_name'] = 'No Transaction Found..!!';
						$query = $this -> report_model -> ledger_generation(true,true,$data['for_who_or_what'],$customer_id,$data['start_date'],$data['end_date']);
						
						
						foreach($query['date_wise_total_sale'] -> result() as $field):
							$initialization[$field -> invoice_doc]['total_sale'] = $field -> invoice_amount;
							$initialization[$field -> invoice_doc]['total_discount'] = $field -> dis_amount;
							//$discount_amount += $field -> dis_amount;
							$data['customer_name'] = $field -> customer_name;
						endforeach;
						
						
						foreach($query['date_wise_total_payment_cash'] -> result() as $field):
							$initialization[$field -> transaction_doc]['paid_by_cash'] = $field -> amount_by_cash;
							$data['customer_name'] = $field -> customer_name;
						endforeach;
						foreach($query['date_wise_total_payment_cheque'] -> result() as $field):
							$initialization[$field -> transaction_doc]['paid_by_cheque'] = $field -> amount_by_cheque;
							$data['customer_name'] = $field -> customer_name;
						endforeach;
						
						
						
						$temp_invoice_amount = 0;$paid_ob_amount_before =0;
						$temp_amount_one = 0; $temp_amount_two = 0;$discount_amount = 0;
						foreach($query['invoice_amount_ob'] -> result() as $field):
							$temp_invoice_amount = $field -> invoice_amount; 
							$discount_amount += $field -> temp_dis_amount;
						endforeach;
						foreach($query['paid_amount_before'] -> result() as $field):	
							 $temp_amount_one =  $field -> ta_one;
							 $temp_amount_two =  $field -> ta_two;
							 $paid_ob_amount_before = $temp_amount_one + $temp_amount_two;
						endforeach;
						$data['temp_opening_balance'] = $temp_invoice_amount - ($paid_ob_amount_before + $discount_amount) ;
						
						$data['ledger_details'] = $initialization;

					}
					else if($service_prover_id)	
					{
						$data['for_who_or_what'] = 'service_provider';
						$data['ledger_details'] = $this -> report_model -> ledger_generation(true,true,$data['for_who_or_what'],$service_prover_id,$data['start_date'],$data['end_date']);
					}
				}
			}
			else
			{
				if($distributor_id)
				{
					
					/***************Arafat****************/
						/*array initia;ization*/

						$startDate = $data['start_date'] = '2013-01-01';
						$endDate = $data['end_date'] = $bd_date;

						$initialization[$startDate]['purchase'] = 0;
						$initialization[$startDate]['payment'] = 0;

						while(true){
							$today = date("Y-m-d",strtotime(date("Y-m-d", strtotime($startDate)) . " +1 day"));
							$startDate = date("Y-m-d",strtotime($today));
							
							$initialization[$startDate]['purchase'] = 0;
							$initialization[$startDate]['payment'] = 0;
								
							if(date($startDate) == date($endDate))  break;
						}
					/***************************************/

					$data['for_who_or_what'] = 'distributor';
					$query = $this -> report_model -> ledger_generation(false,true,$data['for_who_or_what'],$distributor_id,0,0);
					
					foreach($query['date_wise_total_purchase'] -> result() as $field):
						$initialization[$field -> receipt_date]['purchase'] = $field -> purchase_amount;
						$data['distributor_name'] = $field -> distributor_name;
					endforeach;
					
					foreach($query['date_wise_total_payment'] -> result() as $field):
						$initialization[$field -> transaction_doc]['payment'] = $field -> total_payment_amount;
						$data['distributor_name'] = $field -> distributor_name;
					endforeach;
					
					/*$temp_receipt_amount = 0; $paid_ob_amount_before =0;
					foreach($query['receipt_amount_ob'] -> result() as $field):
						$temp_receipt_amount = $field -> receipt_amount_ob; 
					endforeach;
					foreach($query['paid_amount_before'] -> result() as $field):	
						 $paid_ob_amount_before = $field -> paid_ob_amount; 
					endforeach;*/
					$data['temp_opening_balance'] = 0;
					
					$data['ledger_details'] = $initialization;
				}
				else if($customer_id)
				{
					/***************Arafat****************/
						/*array initia;ization*/

						$startDate = $data['start_date'] = '2013-01-01';
						$endDate = $data['end_date'] = $bd_date;

						$initialization[$startDate]['total_sale'] = 0;
						$initialization[$startDate]['paid_by_cash'] = 0;
						$initialization[$startDate]['paid_by_cheque'] = 0;

						while(true){
							$today = date("Y-m-d",strtotime(date("Y-m-d", strtotime($startDate)) . " +1 day"));
							$startDate = date("Y-m-d",strtotime($today));
							
							$initialization[$startDate]['total_sale'] = 0;
							$initialization[$startDate]['paid_by_cash'] = 0;
							$initialization[$startDate]['paid_by_cheque'] = 0;
								
							if(date($startDate) == date($endDate))  break;
						}
					/***************************************/
                   
					$data['for_who_or_what'] = 'customer';
					$query = $this -> report_model -> ledger_generation(false,true,$data['for_who_or_what'],$customer_id,0,0);
					
					foreach($query['date_wise_total_sale'] -> result() as $field):
						$initialization[$field -> invoice_doc]['total_sale'] = $field -> invoice_amount;
						$data['customer_name'] = $field -> customer_name;
					endforeach;
					
					foreach($query['date_wise_total_payment_cash'] -> result() as $field):
						$initialization[$field -> transaction_doc]['paid_by_cash'] = $field -> amount_by_cash;
						$data['customer_name'] = $field -> customer_name;
					endforeach;
					foreach($query['date_wise_total_payment_cheque'] -> result() as $field):
						$initialization[$field -> transaction_doc]['paid_by_cheque'] = $field -> amount_by_cheque;
						$data['customer_name'] = $field -> customer_name;
					endforeach;
					
					
					$data['temp_opening_balance'] = 0;
					$data['ledger_details'] = $initialization;
				}
				else if($service_prover_id)	
				{
					$data['for_who_or_what'] = 'service_provider';
					$data['ledger_details' ] = $this -> report_model -> ledger_generation(false,true,$data['for_who_or_what'],$service_prover_id,0, 0);
				}
				else if($transaction_purpose)
				{
					$data['for_who_or_what'] = 'transaction_purpose';
					$data['ledger_details' ] = $this -> report_model -> ledger_generation(false,true,$data['for_who_or_what'],$transaction_purpose,0 , 0);	
				}
			}

            //if(!$distributor_id && (!$customer_id) && (!$service_prover_id) && (!$transaction_purpose))
               // redirect('report_controller/ledger_generation');

			$data['alarming_level'] = FALSE;
		    $this -> load -> view('ledger_result_print_view', $data);
		}

		/***************************************************
		 * Customer Sale Report Details
		 * System for distributor requrement
		 * Show supplyer/company wise Sale to a customer
		 * 08-11-2013
		 * Arafat Mamun
		***************************************************/
		function customer_sale_report_distributor_wise()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			
			$customer_info_final = $this -> sale_model -> specific_customer_info(false,0);
			$temp_customer_info_final[''] = "Select Customer Name";
			foreach ($customer_info_final -> result() as $field){
				$temp_customer_info_final[  base_url().'index.php/report_controller/customer_sale_report_distributor_wise/'.$field -> customer_id ] = $field -> customer_name.' ( '. $field -> customer_contact_no.' )';
			}
			$data['all_customer_information'] = $temp_customer_info_final;
			if($data['selected_customer_id'] = $this -> uri -> segment(3))
			{
				$data['selected_customer_details'] = $this -> sale_model -> specific_customer_info( TRUE, $this -> uri -> segment(3));
				$data['distributor_wise_sale'] = $this -> report_model -> customer_sale_report_distributor_wise( $this -> uri -> segment(3) );
				
			}
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'customer_sale_report_distributor_wise_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
		}
		
		/***************************************************
		 * Customer Sale Report Details Print
		 * System for distributor requrement
		 * Show supplyer/company wise Sale to a customer
		 * 08-11-2013
		 * Arafat Mamun
		***************************************************/
		function customer_sale_report_distributor_wise_print()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			
		
			$data['selected_customer_details'] = $this -> sale_model -> specific_customer_info( TRUE, $this -> uri -> segment(3));
			$data['distributor_wise_sale'] = $this -> report_model -> customer_sale_report_distributor_wise( $this -> uri -> segment(3) );
			
			$this -> load -> view('customer_sale_report_distributor_wise_print_view', $data);
		}
		
		/***************************************************
		 * Distributor Wise Sale Details
		 * System for distributor requrement
		 * Show supplyer/company wise Sale to all customer
		 * 09-11-2013
		 * Arafat Mamun
		***************************************************/
		function distributor_wise_sale_report()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			
			
			$query = $this -> report_model -> distributor_info();
			$all_distributor[''] = "Select Distributor Name";
			foreach ($query -> result() as $field){
				$all_distributor[  base_url().'index.php/report_controller/distributor_wise_sale_report/'.$field -> distributor_id ] = $field -> distributor_name;
			}
			$data['all_distributor_information'] = $all_distributor;
			if($data['selected_distributor_id'] = $this -> uri -> segment(3))
			{
				$data['selected_distributor_details'] = $this -> report_model -> specific_distributor_info( $this -> uri -> segment(3));
				$data['distributor_wise_sale'] = $this -> report_model -> distributor_wise_sale_report( $this -> uri -> segment(3) );
				$data['distributor_transactions'] = $this -> report_model -> transaction_with_distributor( $this -> uri ->segment(3));
			}
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'distributor_wise_sale_report_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
		}
		/***************************************************
		 * Distributor Wise Sale Details Print
		 * System for distributor requrement
		 * Show supplyer/company wise Sale to all customer
		 * 09-11-2013
		 * Arafat Mamun
		***************************************************/
		function distributor_wise_sale_report_print()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			
			
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			
		
			$data['selected_distributor_details'] = $this -> report_model -> specific_distributor_info( $this -> uri -> segment(3));
			$data['distributor_wise_sale'] = $this -> report_model -> distributor_wise_sale_report( $this -> uri -> segment(3) );
			$data['distributor_transactions'] = $this -> report_model -> transaction_with_distributor( $this -> uri ->segment(3));
		
			$this -> load -> view('distributor_wise_sale_report_print_view', $data);
		}
		/*-------------------------2013-11-13---------------
		 * this function will generates company's ledger
		 * 
		 * *************************************************/
		function my_ledger()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
		}
		/************************************************************
		  * ----------------------------------------
		  * 
		  * this will fatch all transaction with customer------
		  * 
		  * Section : Accounts
		  * ---------------------------------------------------------
		*************************************************************/
		function transaction_with_customer()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'transaction_with_customer_form_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
		}
		
		function date_wise_trasaction_with_customer()
		{
			
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['sale_status'] = '';
		    $data['status'] = '';
		    $data['user_type'] = $this->tank_auth->get_usertype();
		    $data['user_name'] = $this->tank_auth->get_username();
		    $data['start_date'] = $this -> input -> post('start_date');
		    $data['end_date'] = $this -> input -> post('end_date');
		    
		    if( !$this -> input -> post('specific_date') &&  (!$data['start_date']) && (!$data['end_date'])) 
		    {
				//echo 'hello';
				$data['start_date'] = $this -> uri -> segment(3);
			    $data['end_date'] =  $this -> uri -> segment(4);
			}
		     
		    if( $this -> input -> post('specific_date'))
		    {
			   $data['start_date'] = $this -> input -> post('specific_date');
			   $data['end_date'] = $this -> input -> post('specific_date');
		    }
			
			$data['customer_credit_transactions'] =  $this -> report_model -> fatch_all_customer_transactions();
			foreach($data['customer_credit_transactions'] -> result() as $field):
				$data['due_amount'][$field -> customer_id] = $field -> total_due;
			endforeach;
			if( $this -> uri -> segment(3))
				$data['transaction_with_customer_info_details' ] = $this -> report_model -> transaction_with_customer_details($this -> uri -> segment(3),
																											$this -> uri -> segment(4),$this -> uri -> segment(5));
			
			$data['transaction_with_customer_info' ] = $this -> report_model -> transaction_with_customer( $data['start_date']  ,  $data['end_date']);
			$data['alarming_level'] = FALSE;
			$data['main_content'] = 'transaction_with_customer_result_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
		}
		
		function print_date_wise_trasaction_with_customer()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['sale_status'] = '';
		    $data['status'] = '';
		    $data['user_type'] = $this->tank_auth->get_usertype();
		    $data['user_name'] = $this->tank_auth->get_username();
		    $data['start_date'] = $this -> input -> post('start_date');
		    $data['end_date'] = $this -> input -> post('end_date');
		    
		    if( !$this -> input -> post('specific_date') &&  (!$data['start_date']) && (!$data['end_date'])) 
		    {
				
				$data['start_date'] = $this -> uri -> segment(3);
			     $data['end_date'] =  $this -> uri -> segment(4);
			}
		     
		    if( $this -> input -> post('specific_date'))
		    {
			   $data['start_date'] = $this -> input -> post('specific_date');
			   $data['end_date'] = $this -> input -> post('specific_date');
		    }
			
			$data['customer_credit_transactions'] =  $this -> report_model -> fatch_all_customer_transactions();
			foreach($data['customer_credit_transactions'] -> result() as $field):
				$data['due_amount'][$field -> customer_id] = $field -> total_due;
			endforeach;
			if( $this -> uri -> segment(3))
				$data['transaction_with_customer_info_details' ] = $this -> report_model -> transaction_with_customer_details($this -> uri -> segment(3),
																											$this -> uri -> segment(4),$this -> uri -> segment(5));
			
			$data['transaction_with_customer_info' ] = $this -> report_model -> transaction_with_customer( $data['start_date']  ,  $data['end_date']);
			$data['alarming_level'] = FALSE;
			//$data['main_content'] = 'transaction_with_customer_print_view';
			//$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('transaction_with_customer_print_view', $data);
		}
		
		/***********************
		* Employee Salary Log
		* 21-01-2014
		* Arafat Mamun
		************************/
		function salary_log()
		{
			$data['user_type'] = $this->tank_auth->get_usertype();
			if($this -> access_control_model -> my_access($data['user_type'], 'report_controller', 'salary_log'))
			{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['sale_status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['access_status'] = '';
			$data['status'] = '';
			$data['result'] = '';
			
			$this->form_validation->set_rules('selectedUserId', ' ', 'trim|xss_clean|numeric');
			$this->form_validation->set_rules('startDate', ' ', 'trim|required|xss_clean');
			$this->form_validation->set_rules('endDate', ' ', 'trim|xss_clean|required');
			if($this->form_validation->run())
				$data['result'] = 'result';
			
			$query = $this -> registration_model -> userInformation(FALSE, 0);
			$all_employee[''] = 'Select An Employee';
			foreach($query -> result() as $field):
				$all_employee[ $field -> id ] = $field -> username.' ( '.$field -> user_full_name.' )';
			endforeach;
			$data['user_info'] = $all_employee;
			
			//$data['specific_user'] = $this -> registration_model -> userInformation( TRUE, $this -> uri -> segment(3) );
			
			$flag = FALSE;
			if($this -> input -> post('selectedUserId'))
				$flag = TRUE;
			
			$data['salary_information'] = $this -> registration_model -> userSalaryInformation($flag , $this->form_validation->set_value('selectedUserId'), TRUE, $this->form_validation->set_value('startDate'), $this->form_validation->set_value('endDate'));
			$data['alarming_level'] = FALSE;
			
			$data['main_content'] = 'employee_salary_log_view';
			$data['tricker_content'] = 'tricker_report_view';
			$this -> load -> view('include/template', $data);
			}
			else redirect('report_controller/report/noaccess');
		}
		/******************************
		 *  Print Specific purchase Receipt    *
		 ******************************/
		function print_purchase_receipt()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['sale_status'] = '';
			$data['status'] = '';
			$receipt_id = $this -> uri -> segment(3);
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['receipt_general_details'] = $this -> report_model -> specific_purchase_receipt_general( $receipt_id);
			$data['purchase_receipt_details'] = $this -> report_model -> specific_purchase_receipt( $receipt_id);
			//$data['alarming_level'] = FALSE;
			$data['main_content'] = 'specific_purchase_receipt_view';
			$this -> load -> view('print_purchase_receipt_view', $data);
		}
		
		function due_list_of_customers(){
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			
			
			$data['invoice_remaining_due'] = $this -> expense_invoice_model -> fatch_all_reamaining_due_list_for_customer();
			$data['due_status'] = '';
			$data['invoice_remaining_due'] = $data['invoice_remaining_due'] ->result_array();
			$data['alarming_level'] = FALSE;
			
		    //$data['main_content'] = 'customer_due_list';
		    //$data['tricker_content'] = 'tricker_report_view';
		    $this -> load -> view('customer_due_list', $data);
		}
		
		
		function loan_payment_details($loan_details_id){
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			
			$data['loan_details_info'] = $this -> report_model -> loan_payment_details($loan_details_id);

			$data['alarming_level'] = FALSE;
			
		    $data['main_content'] = 'loan_payment_details_view';
		    $data['tricker_content'] = 'tricker_report_view';
		    $this -> load -> view('include/template', $data);
		}
		
	}











