<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
class Main_account_controller extends CI_controller{
	public function __construct()
	{
		parent::__construct();
		
		$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		
		$this->is_logged_in();
		
		$data['user_type'] = $this->tank_auth->get_usertype();
		if(!$this -> access_control_model -> my_access($data['user_type'], 'account_controller', ''))
		{
		redirect('site_controller/main_site/noaccess');
		}
	}
	
	/* checking login status */
	public function is_logged_in()
	{
		
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login','refresh');
		}
	}
	
	 /*********************************
	 * Call the Home page for Account
	 * ********************************/
	function account()
	{
		$data['sale_status'] = '';
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		$data['access_status'] = $this -> uri -> segment(3);
		$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
		$data['main_content'] = 'account_view';
		$data['tricker_content'] = 'tricker_account_view';
		$this -> load -> view('include/template', $data);
	}
	
	
	/* purchase_receipt_entry  form */
	function purchase_receipt_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'purchase_receipt_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['distributor_info'] = $this -> product_model -> distributor_info();
			$data['receipt_status'] = $this -> account_model -> fatch_receipt_status();
			$data['main_content'] = 'purchase_receipt_entry_form_view';
			$data['tricker_content'] = 'tricker_account_view';
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');
	}
    /* to create purchase receipt*/
	function create_purchase_receipt()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'purchase_receipt_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			
			$this -> form_validation -> set_rules('distributor_id', 'Distributor Name','required');
			$this -> form_validation -> set_rules('grand_total', 'Total Purchae','required|numeric');
			$this -> form_validation -> set_rules('transport_cost', 'Transport Cost','required|numeric');
			$this -> form_validation -> set_rules('gift_on_purchase', 'Discount','required|numeric');
			$data['user_name'] = $this->tank_auth->get_username();
			
			$data['main_content'] = 'purchase_receipt_entry_form_view';
			$data['tricker_content'] = 'tricker_account_view';
			$data['distributor_info'] = $this -> product_model -> distributor_info();
			$data['bd_date'] = $bd_date;
			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
				//$this -> load -> view('include/template', $data);
			}
			else
			{
				if($data['receipt_id'] = $this -> account_model -> create_purchase_receipt())
				{
					$data['status'] = 'successful';
					
				}
				else
				{
					$data['status'] = 'failed';
					
				}
			}
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');	
	}

	 /***********************
	 * Gift Entry Form
	 * **********************/
	 function gift_entry()
	 {
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'gift_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;	
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['gift_mode'] = $this -> my_variables_model -> fatch_gift_mode();
			$data['distributor_info'] = $this -> product_model -> distributor_info();
			$data['main_content'] = 'gift_entry_form_view';
			$data['tricker_content'] = 'tricker_account_view';
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');
	 }
     /* gift information */
    function create_gift()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'gift_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			
			$this -> form_validation -> set_rules('distributor_id', 'Distributor Name','required');
			//$this -> form_validation -> set_rules('gift_mode', 'Gift Mode','required');
			$this -> form_validation -> set_rules('gift_amount', 'Gift Amount','required|numeric');
			$data['user_name'] = $this->tank_auth->get_username();
			$data['main_content'] = 'gift_entry_form_view';
			$data['tricker_content'] = 'tricker_account_view';
			$data['distributor_info'] = $this -> product_model -> distributor_info();
		   // $data['gift_mode'] = $this -> my_variables_model -> fatch_gift_mode();
			$data['bd_date'] = $bd_date;
			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
			}
			else
			{
				if($this -> account_model -> create_gift())
				{
					$data['status'] = 'successful';
				}
				else
				{
					$data['status'] = 'failed';
				}
			}
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');
	 }
     /* bank entry form*/
    function bank_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'bank_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			//$data['bank_status'] = $this -> account_model -> fatch_bank_status();
			$data['main_content'] = 'bank_entry_form_view';
			$data['tricker_content'] = 'tricker_account_view';
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');
	}
     /* Create new bank entry form view */
    function create_bank()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'bank_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			//* for sale Running Status */
			$data['sale_status'] = '';
			/* end of Sale running Status*/
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			
			$this -> form_validation -> set_rules('bank_name', 'Bank Name','required');
			$this -> form_validation -> set_rules('bank_account_no', 'Bank Account No','required|numeric');
			$this -> form_validation -> set_rules('bank_account_name', 'Bank Account Name','required');
			//$this -> form_validation -> set_rules('bank_status', 'Bank Status','required');
			//$data['bank_status'] = $this -> account_model -> fatch_bank_status();
			
			$data['user_name'] = $this->tank_auth->get_username();
			$data['main_content'] = 'bank_entry_form_view';
			$data['tricker_content'] = 'tricker_account_view';
		 
			$data['bd_date'] = $bd_date;
			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
			}
			else
			{
				$bank_name = $this -> input -> post('bank_name');
				$bank_account_no  = $this -> input -> post('bank_account_no');	
																    //table_name   ,  field name1, field name2,  element1,  element2 
				$exists = $this -> account_model -> redundancy_check('bank_info', 'bank_name', 'bank_account_no' ,$bank_name, $bank_account_no);
				
				if($exists == true)
				{
					$data['status'] = 'exists';
				}
				else if($this -> account_model -> create_bank())
				{
					$data['status'] = 'successful';
				}
				else
				{
					$data['status'] = 'failed';
				}
			}
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');
	 }
      /* bank entry form*/
    function bank_book_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'bank_book_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['bank_info'] = $this -> account_model -> fatch_bank_name();
			//$data['transaction_type'] = $this -> account_model -> fatch_transaction_type();
			$data['transaction_type'] = $this -> my_variables_model -> my_variables();
			
			$data['main_content'] = 'bank_book_entry_form_view';
			$data['tricker_content'] = 'tricker_account_view';
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');
	 }
     /* Create new bank entry form view */
    function create_book_bank()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'bank_book_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['sale_status'] = '';
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			
			$this -> form_validation -> set_rules('bank_id', 'Bank Name','required');
			$this -> form_validation -> set_rules('transaction_type', 'Transaction Type','required');
			$this -> form_validation -> set_rules('amount', 'Amount','required|numeric');
			$data['user_name'] = $this->tank_auth->get_username();
			//$data['transaction_type'] = $this -> my_variables_model -> my_variables();
			$data['bank_info'] = $this -> account_model -> fatch_bank_name();
			$data['transaction_type'] = $this -> my_variables_model -> my_variables();
			$data['main_content'] = 'bank_book_entry_form_view';
			$data['tricker_content'] = 'tricker_account_view';
		 
			$data['bd_date'] = $bd_date;
			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
			}
			else
			{
				if($this -> account_model -> create_bank_book())
				{
					$data['status'] = 'successful';
				}
				else
				{
					$data['status'] = 'failed';
				}
			}
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');
	 }

      /* cheque info form*/
    function cheque_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'cheque_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['cheque_type'] = $this -> my_variables_model -> fatch_cheque_type();
			$data['bank_info'] = $this -> account_model -> fatch_bank_name();
			$data['cheque_info'] = $this -> account_model -> fatch_all_cheque_id();	
			$data['tran_type_for_transaction_details'] = $this -> account_model -> fatch_all_tran_type_for_transaction_details();
			$data['main_content'] = 'cheque_info_entry_form_view';
			$data['tricker_content'] = 'tricker_account_view';
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');
	 }
    /* create cheque info entry form */
    function create_cheque_info()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'cheque_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['sale_status'] = '';
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			
			if($this -> input -> post('cheque_type') == 'in')
			{	
				$this -> form_validation -> set_rules('cheque_bank_name', 'Cheque Bank Name','required');
				$this -> form_validation -> set_rules('cheque_account_name', 'Cheque Account Name','required');
				$this -> form_validation -> set_rules('cheque_account_no', 'Cheque Account No','required');
				$this -> form_validation -> set_rules('bank_id', 'Bank Name','required');
			}
			/*else if($this -> input -> post('cheque_type') == 'transfer')
			{
				echo 'here';
				echo $this -> input -> post('purposes');
				if($this -> input -> post('purposes') != 'ToBank' || $this -> input -> post('purposes') != 'FromBank')
				{
					echo 124;
					$data['status'] = 'failed';
				}
				
			}*/
			$this -> form_validation -> set_rules('cheque_no', 'Cheque No','required|numeric');
			//$this -> form_validation -> set_rules('cheque_activate_date', 'Cheque Activate Date','required');
			$this -> form_validation -> set_rules('cheque_date', 'Cheque Bank Name','required');
			$this -> form_validation -> set_rules('cheque_amount', 'Cheque Amount','required|numeric');
			$this -> form_validation -> set_rules('bank_id', 'Bank ID','required');
			$data['cheque_info'] = $this -> account_model -> fatch_all_cheque_id();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['cheque_type'] = $this -> my_variables_model -> fatch_cheque_type();
			$data['bank_info'] = $this -> account_model -> fatch_bank_name();
			$data['main_content'] = 'cheque_info_entry_form_view';
			$data['tricker_content'] = 'tricker_account_view';
		 
			$data['bd_date'] = $bd_date;
			if($this -> input -> post('cheque_type') == 'transfer' && ($this -> input -> post('purposes') == '' || $this -> input -> post('purposes') == ''))
			{
				$data['status3'] = 'failed';
				if($this -> form_validation -> run() ==  FALSE)
					$data['status2'] = 'error';
			}
			else
			{
				$data['status2'] = '';
				$data['status3'] = '';
			}
			
			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
			}
			else
			{	
				if($this -> input -> post('cheque_type') == 'out')
				{	
					$my_bank = $this -> input -> post('bank_id');
					$cheque_no  = $this -> input -> post('cheque_no');
																	// table_name   ,  field name1, field name2,  element1,  element2 
					$exists = $this -> account_model -> redundancy_check('cheque_info', 'my_bank', 'cheque_no' ,$my_bank, $cheque_no);
					if($exists == true)
					{
						$data['status'] = 'exists';
						//$this -> load -> view('include/template', $data);
					}
					else if($this -> account_model -> create_cheque_info())
					{
						$data['status'] = 'successful';
					}
					else
					{
						$data['status'] = 'failed';
					}
				}
				if($this -> input -> post('cheque_type') == 'in' )
				{	
					$cheque_no  = $this -> input -> post('cheque_no');
					$cheque_bank_name = $this -> input -> post('cheque_bank_name');
					//$cheque_account_no = $this -> input -> post('cheque_account_no');
					
																		// table_name   ,  field name1, field name2,  element1,  element2 
					$exists = $this -> account_model -> redundancy_check('cheque_info', 'cheque_no', 'cheque_bank_name' ,$cheque_no,$cheque_bank_name);
					if($exists == true)
					{
						$data['status'] = 'exists';
						//$this -> load -> view('include/template', $data);
					}
					else if($this -> account_model -> create_cheque_info())
					{
						$data['status'] = 'successful';
					}
					else
					{
						$data['status'] = 'failed';
					}
				}
				
				if($this -> input -> post('cheque_type') == 'transfer')
				{	
					$my_bank = $this -> input -> post('bank_id');
					$cheque_no  = $this -> input -> post('cheque_no');
					//$cheque_no  = $this -> input -> post('cheque_type');
																	// table_name   ,  field name1, field name2,  element1,  element2 
					$exists = $this -> account_model -> redundancy_check('cheque_info', 'my_bank', 'cheque_no' ,$my_bank, $cheque_no);
					if($exists == true)
					{
						$data['status'] = 'exists';
						//$this -> load -> view('include/template', $data);
					}
					else if($this -> account_model -> create_cheque_info())
					{
						$data['status'] = 'successful';
					}
					else
					{
						$data['status'] = 'failed';
					}
				}	
			}
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');
	 }

    /* this will change the status of a cheque */
    function change_cheque_status_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'change_cheque_status'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			//$data['bank_info'] = $this -> account_model -> fatch_bank_name();
			//$data['cheque_info'] = $this -> account_model -> fatch_all_cheque_id_for_dishonor_purpose();
			$data['chk_exists'] = '';
			$data['cheque_info'] = $this -> account_model -> fatch_all_cheque_id_for_change_status_purpose();					 
			/*if( $data['cheque_info'] )
			{
				
				 $data['chk_exists'] = 'hahaha';
			}*/
			$data['amount_due'] = 0;
			$data['cheque_amount'] = 0;
			$segment_3 = $this -> uri -> segment(3);
			if($segment_3)
			{
				$data['cheque_full_information'] = $this -> account_model -> fatch_full_cheque_information($segment_3);
				
				$data['due_status'] = '';
				if($data['cheque_full_information'] ->  num_rows() > 0)
				{
					//$data['sale_status'] = 'running';
					//$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
					$data['due_status'] = 'ok';
					$due_amount2 = 0;
					foreach($data['cheque_full_information'] -> result() as $field):
						// $due_amount2 = $field -> grand_total - $field -> total_paid;
						$data['cheque_no'] =  $field ->  cheque_no;
						$data['cheque_account_no'] =  $field -> cheque_account_no; 
						$data['cheque_account_name'] =  $field -> cheque_account_name;
						$data['cheque_bank_name'] =  $field -> cheque_bank_name; 
						$data['cheque_amount'] =  $field -> cheque_amount ;
						$data['total_paid'] = $data['cheque_amount'] - $field -> total_paid;
						$data['amount_due'] = $field -> total_paid;
						$data['cheque_status'] = $field -> cheque_status;
					    $data['bank_name'] =  $field -> bank_name;
						//$data['cheque_clear_date'] =  $field -> cheque_clear_date;  
						$data['cheque_activate_date'] = $field -> cheque_activate_date;
						$data['my_bank'] = $field -> my_bank;
						$data['cheque_type'] = $field -> cheque_type;
						$data['cheque_status'] = $field -> cheque_status;
					endforeach;
				}
				
				$data['cheque_change_purpose'] = $this -> my_variables_model -> fatch_all_cheque_change_status_purpose($data['amount_due'] , $data['cheque_amount'],$data['cheque_status'] );	
			}
			$data['main_content'] = 'change_cheque_status_entry_form_view';
			$data['tricker_content'] = 'tricker_account_view';
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');
	 }
	/* ****************************************************
	* this function willl change the status of a cheque 
	* 
	* getting accesed from modify_controller---------------
	* ****************************************************/
    function create_change_cheque_status_entry_form()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'change_cheque_status'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			$data['sale_status'] = '';
			$data['chk_exists'] = 'pip';
			
			$this -> form_validation -> set_rules('cheque_id', 'Cheque ID','required');
			//$this -> form_validation -> set_rules('cheque_book_amount', 'Cheque Book Amount','required|numeric');
			$data['user_name'] = $this->tank_auth->get_username();
			$data['status3'] = '';
			
			if($this -> input -> post('cheque_id'))
			{
				$data['cheque_change_purpose'] = $this -> my_variables_model -> fatch_all_cheque_change_status_purpose(0 , 0, 0);	
			}
					
			if($this -> input -> post('cheque_purpose') == '' && $this -> input -> post('cheque_id') != '')
			{	
				$data['status'] = 'lol';
				$data['status3'] = 'error';
			}
			$data['cheque_info'] = $this -> account_model -> fatch_all_cheque_id_for_change_status_purpose();
			
			$data['bd_date'] = $bd_date;
			//$this -> input -> post('cheque_id')
			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
			}
			if($this -> input -> post('cheque_id')  &&  $this -> input -> post('cheque_purpose') )
			{
				if($this -> form_validation -> run() ==  FALSE)
				{
					$data['status'] = 'error';
				}
				else
				{
					$my_bank = $this -> input -> post('my_bank');
					$cheque_amount = $this -> input -> post('cheque_amount');
					$cheque_type = $this -> input -> post('cheque_type');
					$cheque_purpose = $this -> input -> post('cheque_purpose'); 
					$cheque_status = $this -> input -> post('cheque_status'); 
					
					if($cheque_status == 'recovering' || $cheque_status == 'recovered')
					{
						$data['status'] = 'failed_3';
						if($cheque_status == 'recovered')
							$data['chk_status'] = 'Recovered';
						else $data['chk_status'] = 'Recovering';
						
					}
					else if(($cheque_purpose != 'dishonore' && $cheque_purpose != 'changeDate'))
					{
						//echo 1;
						if( ($cheque_type == 'FromBank' || $cheque_type == 'out'))
						{
							//echo 2;
							if($this -> account_model -> sufficiant_money_has_in_bank_or_not($my_bank, $cheque_amount))
							{
								if($this -> account_model -> create_change_cheque_status_entry())
								{
									$data['status'] = 'successful';
								}
								else
								{
									$data['status'] = 'failed';
								}
							}
							else
							{
								$data['status'] = 'failed_2';
							}
						}
						else if($this -> account_model -> create_change_cheque_status_entry())
						{
							$data['status'] = 'successful';
						}
						else
						{
							$data['status'] = 'failed';
						}
					}
					else
					{
						//echo 3;
						if($this -> account_model -> create_change_cheque_status_entry())
						{
							$data['status'] = 'successful';
						}
						else
						{
							$data['status'] = 'failed';
						}
					}
				}
			}
			$data['main_content'] = 'change_cheque_status_entry_form_view.php';
			$data['tricker_content'] = 'tricker_account_view';
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');
	}

     /* cheque_reference_info entry form*/
    function cheque_reference_info_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'cheque_reference_info'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['user_name'] = $this->tank_auth->get_username();
			$data['cheque_type'] = $this -> my_variables_model -> fatch_cheque_type();
			$data['tran_purpose'] = $this -> account_model -> fatch_all_transaction_purpose();
			$data['main_content'] = 'cheque_reference_info_entry_form_view';
			$data['tricker_content'] = 'tricker_account_view';
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');
	 }
     
	  /* create cheque_reference_info_entry*/
    function create_cheque_reference_info()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'cheque_reference_info'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['sale_status'] = '';
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			
			$this -> form_validation -> set_rules('ref_id', 'Receipt No/Invoice ID','required|numeric');
			$this -> form_validation -> set_rules('cheque_id', 'Cheque ID','required|numeric');
			$this -> form_validation -> set_rules('transaction_amount', 'Cheque Amount','required|numeric');
			$this -> form_validation -> set_rules('transaction_type', 'Transaction Type','required');
			$this -> form_validation -> set_rules('cheque_ref_purpose', 'cheque Reference Purpose','required');
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['cheque_type'] = $this -> my_variables_model -> fatch_cheque_type();
			$data['tran_purpose'] = $this -> account_model -> fatch_all_transaction_purpose();
			$data['main_content'] = 'cheque_reference_info_entry_form_view';
			$data['tricker_content'] = 'tricker_account_view';
			$data['bd_date'] = $bd_date;
			if($this -> form_validation -> run() ==  FALSE)
			{
				$data['status'] = 'error';
			}
			else
			{
				if($this -> account_model -> create_cheque_reference_info())
				{
					$data['status'] = 'successful';
				}
				else
				{
					$data['status'] = 'failed';
				}
			}
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');
	 }
	//---------------------------------------------------Accounts distributor version starts here------------------------------------//
	 /* 
     * transaction view for distributor_version
     * 
     * Section : Accounts
     * 
     * */
    function transaction_entry()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'transaction_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['bd_date'] = $bd_date;
			$data['sale_status'] = '';	// for sale status
			$data['status'] = '';
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			$data['user_name'] = $this->tank_auth->get_username();			
			$data['cheque_type'] = $this -> account_model -> fatch_cheque_type();
			$data['bank_info'] = $this -> account_model -> fatch_bank_name();
			$data['transaction_mode'] = $this -> account_model -> fatch_all_transaction_mode();
			$data['transaction_purpose'] = $this -> account_model -> fatch_all_transaction_purpose(); 
			$data['tran_type_for_transaction_details'] = $this -> account_model -> fatch_all_tran_type_for_transaction_details();
			$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id_for_transaction_purpose();
			$data['expense_info'] = $this ->expense_invoice_model-> fatch_all_expense_id_for_transaction_purpose();
			$data['invoice_info'] =  $this ->expense_invoice_model-> fatch_all_invoiceID_not_paid_yet_for_transaction_purpose();
			$data['due_customer_info'] = $this ->expense_invoice_model-> fatch_all_customerID_not_paid_yet_for_transaction_purpose();
			$data['gift_info'] = $this -> account_model -> fatch_all_gift_id_for_transaction_purpose();
			$data['cheque_info'] = $this -> account_model -> fatch_all_cheque_id();
			$data['cheque_info_for_dishonor_purpose'] = $this -> account_model -> fatch_all_dishonored_cheque_id();
			$data['gift_mode'] = $this -> my_variables_model -> fatch_gift_mode();
			$data['bank_info'] = $this -> account_model -> fatch_bank_name();
			$data['investment_info'] = $this -> expense_invoice_model -> fatch_all_investment_id_for_transaction_purpose();
			$data['investor_info'] = $this -> expense_invoice_model -> fatch_all_investor_information();
			$data['distributor_info'] = $this -> account_model -> distributor_info();
			
			
			

			$segment_3 = $this -> uri -> segment(3);
			$segment_4 = $this -> uri -> segment(4);
			$segment_5 = $this -> uri -> segment(5);
			$segment_6 = $this -> uri -> segment(6);
			
			
			$query = $this -> registration_model -> userInformation(FALSE, 0);
			$all_employee[''] = 'Select An Employee';
			foreach($query -> result() as $field):
				$all_employee[ base_url().'index.php/account_controller/transaction_entry/'.$segment_3.'/Salary/'.$field -> id] = $field -> username.' ( '.$field -> user_full_name.' )';
			endforeach;
			$data['user_info'] = $all_employee;
			//$data['specific_user'] = $this -> registration_model -> userInformation( TRUE, $this -> uri -> segment(3) );
			
			
			if($segment_4 == 'purchase' )
			{
				$temp_distributor_information[''] = 'Select A Distributor';
				if($data['distributor_info'] -> num_rows() > 0)
				{
					foreach($data['distributor_info']-> result() as $field):
						$temp_distributor_information[base_url().'index.php/account_controller/transaction_entry/'.$segment_3.'/purchase/'.$field->distributor_id ] = $field -> distributor_name;
					endforeach;
				}
				$data['distributor_information'] = $temp_distributor_information; 
				$data['distributor_status'] = '';
				if($segment_5 )
				{
				    $data['distributor_status'] = 'no';
					$temp_transaction_with_distributor = $this -> account_model -> transaction_with_distributors(true,$segment_5);
					$diposit_details = $this -> account_model -> fatch_deposit_details_by_distributor($segment_5);
					if($temp_transaction_with_distributor -> num_rows() > 0)
					{	
						$data['distributor_status'] = 'yes';
						foreach($temp_transaction_with_distributor -> result() as $field):
							 $data['distributor_name']= $field -> distributor_name;
							 $data['due_amount']= $field -> total_due;
							 $data['grand_total']= $field -> grand_total;
							 $data['total_paid']= $field -> total_paid;
						endforeach;
					}
					$data['diposit_status'] = 'no';
					if($diposit_details -> num_rows() > 0)
					{
						$data['diposit_status'] = 'yes';
						foreach($diposit_details -> result() as $field):
							// $data['diposit_id']= $field -> diposit_id;
							 $data['diposit_amount']= $field -> diposit_amount;
							 //$data['diposit_total_paid']= $field -> total_paid;
							// $data['diposit_cheque_id']= $field -> diposit_cheque_id;
						endforeach;
					}
				}
			}
			
			$for_cheque = $this -> input -> post('for_cheque');
			if($segment_4 == 'sale' )
			{
				$data['invoice_remaining_due'] = $this -> expense_invoice_model -> fatch_invoice_reamaining_due($segment_5 );
				$data['due_status'] = '';
				if($data['invoice_remaining_due'] ->  num_rows() > 0)
				{
					//$data['sale_status'] = 'running';
					//$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
					$data['due_status'] = 'invoice';
					$due_amount2 = 0;
					foreach($data['invoice_remaining_due']-> result() as $field):
						 $due_amount2 = $field -> grand_total - $field -> total_paid;
					endforeach;
					$data['amount_to_be_paid'] = $due_amount2;
				}
			}
			else if($segment_4 == 'sale_customer' )
			{
				$data['customer_remaining_due'] = $this -> expense_invoice_model -> fatch_all_reamaining_due_list_for_specific_customer($segment_5);
				$data['due_status'] = '';
				if($data['customer_remaining_due']  > 0)
				{
					//$data['sale_status'] = 'running';
					//$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
					$data['due_status'] = 'invoice';
					$due_amount2 = 0;
					$data['amount_to_be_paid'] = $data['customer_remaining_due'];
				}
			}
			else if($segment_4 == 'expense' )
			{
				$data['expense_remaining_due'] = $this -> expense_invoice_model -> fatch_expense_reamaining_due($segment_5);
				
				$data['due_status'] = '';
				if($data['expense_remaining_due'] ->  num_rows() > 0)
				{
					//$data['sale_status'] = 'running';
					//$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
					$data['due_status'] = 'expense';
					$due_amount2 = 0;
					foreach($data['expense_remaining_due']-> result() as $field):
						 $due_amount2 = $field -> expense_amount - $field -> total_paid;
					endforeach;
					$data['amount_to_be_paid'] = $due_amount2;
				}
			}
			//~ if($segment_4 == 'purchase' )
			//~ {
				//~ $data['purchase_remaining_due'] = $this -> expense_invoice_model -> fatch_purchase_reamaining_due_for_specific_purchase_receipt_id($segment_5 );
				//~ $data['due_status'] = '';
				//~ if($data['purchase_remaining_due'] ->  num_rows() > 0)
				//~ { 
					//~ //$data['sale_status'] = 'running';
					//~ //$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
					//~ $data['due_status'] = 'purchase';
					//~ $due_amount2 = 0;
					//~ foreach($data['purchase_remaining_due']-> result() as $field):
						 //~ //echo 'here_comes';
						  //~ $due_amount2 = $field -> grand_total - $field -> total_paid;
						 //~ //echo 'here_comes_end';
					//~ endforeach;
					//~ $data['amount_to_be_paid'] = $due_amount2;
				//~ }
			//~ }
			if($segment_4 == 'gift' )
			{
				$data['gift_remaining_due'] = $this -> account_model -> fatch_gift_reamaining_due_for_specific_gift_id($segment_5 );
				$data['due_status'] = '';
				if($data['gift_remaining_due'] ->  num_rows() > 0)
				{
					//$data['sale_status'] = 'running';
					//$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
					$data['due_status'] = 'gift';
					$due_amount2 = 0;
					foreach($data['gift_remaining_due']-> result() as $field):
						 $due_amount2 = $field -> gift_amount - $field -> total_paid;
					endforeach;
					$data['amount_to_be_paid'] = $due_amount2;
				}
			}
			else if($segment_4 == 'investment' )
			{
				$data['investment_remaining_due'] = $this -> expense_invoice_model -> fatch_investment_remaining_due($segment_5 );
				
				$data['due_status'] = '';
				if($data['investment_remaining_due'] ->  num_rows() > 0)
				{
					//$data['sale_status'] = 'running';
					//$data['number_of_products'] += $data['sale_stock'] ->  num_rows();
					$data['due_status'] = 'investment';
					$due_amount2 = 0;
					foreach($data['investment_remaining_due']-> result() as $field):
						 $due_amount2 = $field ->investment_amount - $field -> total_paid;
					endforeach;
					$data['amount_to_be_paid'] = $due_amount2;
				}
			
			}
			else if($segment_4 == 'Withdrawal' )
			{
				//$data['investment_remaining_due'] = $this -> expense_invoice_model -> fatch_investment_remaining_due($segment_5 );
				$data['investor_info_by_investor_id'] = $this -> expense_invoice_model -> specific_investor_information($segment_5);
				
				$data['due_status'] = '';
				$due_amount2 = 0;
				if($data['investor_info_by_investor_id'] ->  num_rows() > 0)
				{
					$data['due_status'] = 'Withdrawal';
					
				    foreach($data['investor_info_by_investor_id']-> result() as $field):
						$data['investor_name'] = $field -> investor_name;
					endforeach;
					$data['amount_to_be_paid'] = $due_amount2;
				}
			}
			else if($segment_4 == 'Loan' )
			{
				$loan_details_info = $this -> account_model -> loanDetailsInformation(false, 0, false, 0, true);
				$temp[''] = "Select An ID";
				foreach($loan_details_info -> result() as $field):
					if(($field -> loan_mode) == 1) 
						 $loan_mode = "Get Loan"; 
					else  $loan_mode = "Provide Loan"; 
					$temp[base_url().'account_controller/transaction_entry/'.$segment_3.'/'.$segment_4.'/'.$field -> loan_details_id] = 
											$field -> loan_seeker_name.nbs(3).' [Amount : '.($field -> loan_amount)
											.'] Mob : '.$field -> contact_no.' [Mode : '.($loan_mode).']';
						/*$temp[base_url().'account_controller/transaction_entry/'.$segment_3.'/'.$segment_4.'/'.$field -> loan_details_id] = 
																							$field -> loan_seeker_name.nbs(3).' [Amount : '.($field -> loan_amount).'] Mob : '.$field -> contact_no;
						*/
				endforeach;
				$data['loan_details_info'] = $temp;

				$data['loan_remaining_due'] = $this -> account_model -> loanDetailsInformation(true, $segment_5, false, 0, false);
				
				$data['due_status'] = '';
				if($data['loan_remaining_due'] ->  num_rows() > 0)
				{
					$data['due_status'] = 'Loan';
					$due_amount2 = 0;
					foreach($data['loan_remaining_due']-> result() as $field):
						 $due_amount2 = $field -> loan_amount - $field -> total_paid;
						 $data['loan_mode'] = $field -> loan_mode;
					endforeach;
					$data['amount_to_be_paid'] = $due_amount2;
				}
				
			}
			else if($segment_4 == 'Salary' )
			{
				//~ $data['salary_remaining_due'] = $this -> account_model -> fatch_salary_reamaining_due($segment_5 );
				//~ $data['due_status'] = '';
				//~ if($data['salary_remaining_due'] ->  num_rows() > 0)
				//~ {
					//~ $data['due_status'] = 'Salary';
					//~ $due_amount2 = 0;
					//~ foreach($data['salary_remaining_due']-> result() as $field):
						 //~ $due_amount2 = $field -> expense_amount - $field -> total_paid;
					//~ endforeach;
					//~ $data['amount_to_be_paid'] = $due_amount2;	
				//~ }
				$data['employee_status'] = 'no';
				if($segment_5 )
				{
				   
					$temp_transaction_with_employee = $this -> account_model -> transaction_with_employees(true,$segment_5);
					if($temp_transaction_with_employee -> num_rows() > 0)
					{	
						$data['employee_status'] = 'yes';
						foreach($temp_transaction_with_employee -> result() as $field):
							 $data['employee_name']= $field -> employee_name;
							 $data['due_amount']= $field -> total_due;
							 $data['grand_total']= $field -> grand_total;
							 $data['total_paid']= $field -> total_paid;
						endforeach;
					}
				}
			}
			
			
			$data['main_content'] = 'transaction_entry_form_view';
			$data['tricker_content'] = 'tricker_account_view';
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');
	}
	 
    /* create transaction ref details*/
    function create_transaction_details()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($this -> access_control_model -> my_access($data['user_type'], 'account_controller', 'transaction_entry'))
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			$data['sale_status'] = '';
			
			$purpose = $this -> input -> post('purpose'); 
			$purposes = $this -> input -> post('purposes');  //--------------- (purposes)only for transfer mode........ otherwise its(purpose) 
			$segment_5_last = $this -> input -> post('p_receipt_id_or_expense_or_invoice');
			
			$mode = $this -> input -> post('mode');
			$tran_type_final = $this ->  input -> post('tran_type'); 
			$data['status_tran'] = '';
			$data['status_tran_temp'] = '';
			$data['final_type'] = '';
			$data['final_mode'] = '';
			if( $mode =='cash' && ($purpose == 'gift' || $purpose == 'purchase' || $purpose == 'sale' || $purpose == 'sale_customer' || $purpose == 'expense'  || $purpose == 'chequeDishonor' || $purpose == 'investment' || $purpose == 'Withdrawal' || $purpose == 'Loan' || $purpose == 'Salary' )  )
			{
				if($purpose == 'purchase')
					$this -> form_validation -> set_rules('p_receipt_id_or_expense_or_invoice', 'Receipt ID','required');	
				if($purpose == 'sale')
					$this -> form_validation -> set_rules('p_receipt_id_or_expense_or_invoice', 'Cashmemo ID','required');
				if($purpose == 'sale_customer')
					$this -> form_validation -> set_rules('p_receipt_id_or_expense_or_invoice', 'Customer ID','required');
				if($purpose == 'expense')
					$this -> form_validation -> set_rules('p_receipt_id_or_expense_or_invoice', 'Expense ID','required');
				if($purpose == 'gift')
					$this -> form_validation -> set_rules('p_receipt_id_or_expense_or_invoice', 'Gift ID','required');
				if($purpose == 'Loan')
					$this -> form_validation -> set_rules('p_receipt_id_or_expense_or_invoice', 'Loan ID','required');
				if($purpose == 'Salary')
					$this -> form_validation -> set_rules('p_receipt_id_or_expense_or_invoice', 'Employee Name','required');
				if($purpose == 'chequeDishonor')
					$this -> form_validation -> set_rules('dishonored_cheque_id', 'Dishonored Cheque ID','required');	
				$this -> form_validation -> set_rules('transaction_amount', 'Transaction Amount','required|numeric');
			}
			else if( $mode =='cheque' && ($purpose == 'gift' || $purpose == 'purchase' || $purpose == 'sale' || $purpose == 'sale_customer' || $purpose == 'expense' ||  $purpose == 'chequeDishonor' || $purpose == 'investment'  || $purpose == 'Withdrawal' || $purpose == 'Loan' || $purpose == 'Salary')  )
			{
				
				if($purpose == 'purchase')
					$this -> form_validation -> set_rules('p_receipt_id_or_expense_or_invoice', 'Receipt ID','required');	
				if($purpose == 'sale')
					$this -> form_validation -> set_rules('p_receipt_id_or_expense_or_invoice', 'Cashmemo ID','required');
				if($purpose == 'sale_customer')
					$this -> form_validation -> set_rules('p_receipt_id_or_expense_or_invoice', 'Customer ID','required');
				if($purpose == 'expense')
					$this -> form_validation -> set_rules('p_receipt_id_or_expense_or_invoice', 'Expense ID','required');
				if($purpose == 'gift')
					$this -> form_validation -> set_rules('p_receipt_id_or_expense_or_invoice', 'Gift ID','required');
				if($purpose == 'Salary')
					$this -> form_validation -> set_rules('p_receipt_id_or_expense_or_invoice', 'Employee Name','required');
				if($purpose == 'Loan')
					$this -> form_validation -> set_rules('p_receipt_id_or_expense_or_invoice', 'Loan ID','required');
				if($purpose == 'chequeDishonor')
					$this -> form_validation -> set_rules('dishonored_cheque_id', 'Dishonored Cheque ID','required');
				$this -> form_validation -> set_rules('cheque_id', 'Cheque No','required');	
				
					
			}
			else if($purposes == 'transfer'  )
			{
				$data['status_tran'] = '';
				$data['status_tran_temp'] = '';
				$data['final_type'] = '';
				$data['final_mode'] = '';
				/*if($tran_type_final == 'ToBank') $data['final_type'] = 'To Bank';
					else $data['final_type'] = 'From Bank';*/
					
				if($mode == 'cash') 
				{
					$data['final_mode'] = 'Cash';
					$this -> form_validation -> set_rules('bank_id', 'Bank ID','required');	
					$this -> form_validation -> set_rules('transaction_amount', 'Transaction Amount','required|numeric');
				}
				else if($mode == 'cheque')
				{
					$data['final_mode'] = 'Cheque';
					$this -> form_validation -> set_rules('cheque_id', 'Cheque No','required');
				}
				
				if($tran_type_final == '' && $mode == '')
				{
					$data['status_tran'] = 'not_exists';
					$data['status_mode'] = 'not_exists';
					if($this -> form_validation -> run() ==  FALSE)
					{
						$data['status_tran_temp'] = 'error';
						$this -> form_validation -> set_rules('transaction_amount', 'Transaction Amount','required|numeric');
					}
				}
				else if($tran_type_final == '')
				{
					$data['status_tran'] == 'not_exists';
					if($this -> form_validation -> run() ==  FALSE)
					{
						$data['status_tran_temp'] = 'error';
					}
				}
				else if($mode == '')
				{
					$data['status_tran'] = 'not_exists_for_mode';
					if($this -> form_validation -> run() ==  FALSE)
					{
						$data['status_tran_temp'] = 'error';
						$this -> form_validation -> set_rules('transaction_amount', 'Transaction Amount','required|numeric');
					}
				}
			}
			else
			{
				$this -> form_validation -> set_rules('transaction_amount', 'Transaction Amount','required|numeric');
			}
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_name'] = $this->tank_auth->get_username();
			$data['transaction_mode'] = $this -> account_model -> fatch_all_transaction_mode();
			$data['tran_type_for_transaction_details'] = $this -> account_model -> fatch_all_tran_type_for_transaction_details();
			$data['purchase_receipt_info'] = $this ->product_model-> fatch_all_purchase_receipt_id_for_transaction_purpose();
			$data['expense_info'] = $this ->expense_invoice_model-> fatch_all_expense_id_for_transaction_purpose();
			$data['invoice_info'] =  $this ->expense_invoice_model-> fatch_all_invoiceID_not_paid_yet_for_transaction_purpose();
			$data['due_customer_info'] = $this ->expense_invoice_model-> fatch_all_customerID_not_paid_yet_for_transaction_purpose();
			$data['bank_info'] = $this -> account_model -> fatch_bank_name();
			$data['cheque_info'] = $this -> account_model -> fatch_all_cheque_id();
			$data['cheque_info_for_dishonor_purpose'] = $this -> account_model -> fatch_all_dishonored_cheque_id();
			$data['investment_info'] = $this -> expense_invoice_model -> fatch_all_investment_id_for_transaction_purpose();
			
			$data['main_content'] = 'transaction_entry_form_view';
			$data['tricker_content'] = 'tricker_account_view';
			$data['bd_date'] = $bd_date;
			$data['status2'] = 'ufff';
			$data['status3'] = 'grrrrrrr';
			
			if($purposes != 'transfer')
			{
				if(( $mode =='cash' || $mode =='cheque')  && $purpose  == '' )
				{
					$data['status'] = 'lol';
					$data['status2'] = 'test';
					$data['status3'] = 'failed';
					if($this -> form_validation -> run() ==  FALSE)
					{
						$data['status2'] = 'error';
					}
				}
				else
				{
					$data['status2'] = 'HHH';
					$data['status3'] = 'TTT';
				}
			}
			if($purpose == 'chequeDishonor'  && $mode =='cheque' )
			{
				$data['cheeck_if_purposes_are_same'] = $this -> account_model -> cheeck_if_purposes_are_same_or_not($this -> input-> post('dishonored_cheque_id'),$this -> input-> post('cheque_id') );
				if(!$data['cheeck_if_purposes_are_same'] )
				{
					$data['status'] = 'lol';
					$data['status3'] = 'failed';
					$data['status_unknown'] = 'not_same';
				}
			}
			
			if($data['status3'] != 'failed')
			{
				if($this -> form_validation -> run() ==  FALSE )
				{
					$data['status'] = 'error';
				}
				else
				{
					$due_amount2=0;  $previous_total_paid=0; $tran_amount =0;

					/**********************************************************  
					* Special purchase mode for Distributor Version of Dokani
					***********************************************************/
					if($purpose == 'purchase')
					{
						$distributor_id =  $this -> input -> post('p_receipt_id_or_expense_or_invoice');
						$purchase_receipts['all_purchase_receipts'] = $this -> account_model -> fatch_all_due_purchase_receipt_id_by_distributor(true,$distributor_id);

						if($purchase_receipts['all_purchase_receipts'] ->  num_rows() > 0)
						{
							if($this -> account_model -> create_transaction_details_for_dokani_distributor_version($distributor_id,$purchase_receipts['all_purchase_receipts']));
							$data['status'] = 'successful';
						}
						else 
						{
							$data['status'] = 'failed';
							$data['status_for_distributor_version'] = 'He Has No Due Left';
						}
					} /*---------------------end of purchase mode for distributor vesion------------------------*/
					else if($purpose == 'expense')
					{
						$expense_id =  $this -> input -> post('p_receipt_id_or_expense_or_invoice');
						$data['expense_remaining_due'] = $this -> expense_invoice_model -> fatch_expense_reamaining_due($expense_id);
						if($data['expense_remaining_due'] ->  num_rows() > 0)
						{
							$due_amount2 = 0;
							foreach($data['expense_remaining_due']-> result() as $field):
								 $due_amount2 = $field -> expense_amount;
								 $previous_total_paid = $field -> total_paid;
							endforeach;
							 $tran_amount = $this -> input -> post('transaction_amount');
						}
					}
					else if($purpose == 'investment')
					{
						$investment_id =  $this -> input -> post('p_receipt_id_or_expense_or_invoice');
						$data['investment_remaining_due'] = $this -> expense_invoice_model -> fatch_investment_remaining_due($investment_id);
						if($data['investment_remaining_due'] ->  num_rows() > 0)
						{
							$due_amount2 = 0;
							foreach($data['investment_remaining_due']-> result() as $field):
								 $due_amount2 = $field -> investment_amount;
								 $previous_total_paid = $field -> total_paid;
							endforeach;
							 $tran_amount = $this -> input -> post('transaction_amount');
						}
					}
					else if($purpose == 'Withdrawal')
					{
						$investor_id =  $this -> input -> post('p_receipt_id_or_expense_or_invoice');
						$tran_amount = $this -> input -> post('transaction_amount');
						//~ $data['investment_remaining_due'] = $this -> expense_invoice_model -> fatch_investment_remaining_due($investment_id);
						//~ if($data['investment_remaining_due'] ->  num_rows() > 0)
						//~ {
							//~ //$data['due_status'] = 'purchase';
							//~ $due_amount2 = 0;
							//~ foreach($data['investment_remaining_due']-> result() as $field):
								 //~ $due_amount2 = $field -> investment_amount;// - $field -> total_paid;
								 //~ $previous_total_paid = $field -> total_paid;
							//~ endforeach;
							 //~ $tran_amount = $this -> input -> post('transaction_amount');
						//~ }
						
					}
					else if($purpose == 'sale')
					{
						$invoice_id =  $this -> input -> post('p_receipt_id_or_expense_or_invoice');
						$data['invoice_remaining_due'] = $this -> expense_invoice_model -> fatch_invoice_reamaining_due($invoice_id );
						if($data['invoice_remaining_due'] ->  num_rows() > 0)
						{
							$due_amount2 = 0;
							foreach($data['invoice_remaining_due']-> result() as $field):
								 $due_amount2 = $field -> grand_total;// - $field -> total_paid;
								 $previous_total_paid = $field -> total_paid;
							endforeach;
							$tran_amount = $this -> input -> post('transaction_amount');
						}
					}
					else if($purpose == 'sale_customer')
					{
						$customer_id =  $this -> input -> post('p_receipt_id_or_expense_or_invoice');
						$data['customer_remaining_due'] = $this -> expense_invoice_model -> fatch_all_reamaining_due_list_for_specific_customer($customer_id );
						if($data['customer_remaining_due'] > 0)
						{
							$sale_receipts['all_sale_receipts'] = $this -> expense_invoice_model -> reamaining_due_invoice_list_for_specific_customer($customer_id);
							
							
							$due_amount2 = 0;
							$due_amount2 = $data['customer_remaining_due'];
							$tran_amount = $this -> input -> post('transaction_amount');
							if($sale_receipts['all_sale_receipts'] ->num_rows() > 0){
								if($this->account_model->paid_customer_prev_due_together($customer_id, $sale_receipts['all_sale_receipts'])){
									
									$return_amount = $tran_amount - $due_amount2;
									if($return_amount > 0){
									$data['status'] = 'hello';
									$data['amount_to_be_returned'] = $return_amount;
									}
									else{
									$data['status'] = 'successful';
									}
								}
								else{
									$data['status'] = 'error';
								}
							}
							else{
								$data['status'] = 'error';
							}
						}
					}
					else if($purpose == 'gift')
					{
						$gift_id =  $this -> input -> post('p_receipt_id_or_expense_or_invoice');
						$data['gift_remaining_due'] = $this -> account_model -> fatch_gift_reamaining_due_for_specific_gift_id($gift_id );
						if($data['gift_remaining_due'] ->  num_rows() > 0)
						{
							$due_amount2 = 0;
							foreach($data['gift_remaining_due']-> result() as $field):
								 $due_amount2 = $field -> gift_amount;// - $field -> total_paid;
								 $previous_total_paid = $field -> total_paid;
							endforeach;
							$tran_amount = $this -> input -> post('transaction_amount');	
						}
					}
					else if($purpose == 'Loan') /* written on 04-06-2014 */
					{
						$loan_details_id =  $this -> input -> post('p_receipt_id_or_expense_or_invoice');
						$data['loan_remaining_due'] = $this -> account_model -> loanDetailsInformation(true, $loan_details_id, false, 0, false);
						
						$data['due_status'] = '';
						if($data['loan_remaining_due'] ->  num_rows() > 0)
						{
				
							$due_amount2 = 0;
							foreach($data['loan_remaining_due']-> result() as $field):
								 $due_amount2 = $field -> loan_amount;
								 $previous_total_paid = $field -> total_paid;
							endforeach;
							$tran_amount = $this -> input -> post('transaction_amount');
						}
					}
					else if($purpose == 'chequeDishonor')
					{
			
						$cheque_id =  $this -> input -> post('dishonored_cheque_id');
						$data['cheque_dishonor_remaining_due'] = $this -> account_model -> fatch_cheque_reamaining_due_for_specific_cheque_id($cheque_id);
						if($data['cheque_dishonor_remaining_due'] ->  num_rows() > 0)
						{
							$due_amount2 = 0;
							foreach($data['cheque_dishonor_remaining_due']-> result() as $field):
								 $due_amount2 = $field -> cheque_amount;// - $field -> total_paid;
								 $previous_total_paid = $field -> total_paid;
							endforeach;
							$tran_amount = $this -> input -> post('transaction_amount');	
						}
					}
					else if($purpose == 'Salary')
					{
						//~ $invoice_id =  $this -> input -> post('p_receipt_id_or_expense_or_invoice');
						//~ $data['invoice_remaining_due'] = $this -> expense_invoice_model -> fatch_invoice_reamaining_due($invoice_id );
						//~ if($data['invoice_remaining_due'] ->  num_rows() > 0)
						//~ {
							//~ $due_amount2 = 0;
							//~ foreach($data['invoice_remaining_due']-> result() as $field):
								 //~ $due_amount2 = $field -> grand_total;// - $field -> total_paid;
								 //~ $previous_total_paid = $field -> total_paid;
							//~ endforeach;
							//~ $tran_amount = $this -> input -> post('transaction_amount');
						//~ }
						$tran_amount = $this -> input -> post('transaction_amount');
                        $due_amount2 = 0;
						$previous_total_paid = 0;
					}
					else if($purposes == 'transfer')
					{
						/************************22-12-2013****************************
					     * 
					     *  First we cheecked if the transaction_type is FromBank
					     *  if so then we had to cheeck if there is sufficient money
					     *  exists in the requested bank....
					     * 
					     * 
					     *  Section: Accounts
					     * ************************************************************/
					   
					   
					    $transaction_type = $this -> input -> post('tran_type');
						$my_bank = $this -> input -> post('bank_id');
						$amount = 0;
						  
						if($mode == 'cheque')
						{
						    $cheque_id = $this -> input-> post('cheque_id');								
							$query = $this -> account_model -> fatch_cheque_reamaining_due_for_specific_cheque_id($cheque_id);
												 
							if($query -> num_rows() >0)
							{
								foreach($query -> result() as $field):
								   $amount = $field -> cheque_amount - $field -> total_paid;
								   $my_bank = $field -> my_bank;
								endforeach;		           
							}
						}
						else $amount = $this -> input -> post('transaction_amount');

						if($transaction_type == 'FromBank')
						{
							//echo 'here'.$amount;
							if($this -> account_model -> sufficiant_money_has_in_bank_or_not($my_bank, $amount))
							{
								if($this -> account_model -> create_transaction_details($purposes, $mode, 0, 0,0))
								{
									$data['status'] = 'successful';
								}
								else
								{
									$data['status'] = 'failed';
								}
							}
							else
							{
								$data['status'] = 'failed_2';
							}
						}
						else 
						{
							if($this -> account_model -> create_transaction_details($purposes, $mode, 0, 0,0))
							{
								  $data['status'] = 'successful';
							}
							else
							{
								$data['status'] = 'failed';
							}
						}
					}
					/*  
					 * if($purposes != 'purchase')
					 *     Purchase mode is not allowed here for distributor version of dokani
					 *     because it doesnt work according to purchase receipt id......
					 * */
					if($purpose != 'purchase' && $purpose != 'sale_customer')
					{
						$had_to_pay = $due_amount2 - $previous_total_paid;		
						if($tran_amount > $had_to_pay && $purpose != 'Salary') 
						{
							  $return_amount = $tran_amount - $had_to_pay;
							  if($this -> account_model -> create_transaction_details($purpose, $mode, $due_amount2, $previous_total_paid,$had_to_pay))
							  {
								  if($purpose != 'Withdrawal')
								  {
									  $data['status'] = 'hello';
									  $data['amount_to_be_returned'] = $return_amount;
								  }
								  else $data['status'] = 'successful';
							  }
							  else
							  {
									$data['status'] = 'failed';
							  }
						}
						else if($purpose != 'transfer' && $purposes != 'transfer' )
						{			
							if($this -> account_model -> create_transaction_details($purpose, $mode, $due_amount2, $previous_total_paid,$had_to_pay))
							{
								$data['status'] = 'successful';
							}
							else
							{
								$data['status'] = 'failed';
							}
						}
					}
				}
			}
			$this -> load -> view('include/template', $data);
		}
		else redirect('account_controller/account/noaccess');
	}
	/*-----------03-06-2014------
	*
	*-----------Loan Seeker Entry
	*
	* Section : Accounts.
	*****************************/
	function loan_seeker_entry()
	{
		$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['user_id'] = $this -> tank_auth -> get_user_id();
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();	
			$data['shop_name'] = $this -> tank_auth -> get_shopname();
			$data['shop_address'] = $this -> tank_auth -> get_shopaddress();
			$data['access_status'] = '';
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();

			/*$market_info = $this -> add_model -> marketInfo(false, false);
			$temp[''] = "Select A Market";
			foreach( $market_info -> result() as $field):
				$temp[$field -> market_id ] = $field -> market_name;
			endforeach;
		    $data['market_info'] = $temp;*/

			
			$this->form_validation->set_rules('loanSeekerName', ' ', 'trim|required|xss_clean');
			$this->form_validation->set_rules('contactNo', ' ', 'trim|required|xss_clean');
			$this->form_validation->set_rules('emailAddress', ' ', 'trim|xss_clean|valid_email');
			$this->form_validation->set_rules('address', ' ', 'trim|xss_clean');
			$this->form_validation->set_rules('description', ' ', 'trim|xss_clean');
			if($this->form_validation->run())
			{
				$exists = $this -> product_model -> redundancy_check('loan_seeker_info',
																	 'contact_no', 
																	 $this->form_validation->set_value('contactNo')
																	);
				if($exists == true)
					$data['status'] = 'exists';

				else if($this -> account_model -> add_loan_seeker())
					$data['status'] = 'successful';
				else $data['status'] = 'error';

			}
			
			//$data['viewType'] = 'reduced_view';
			$data['main_content'] = 'loan_seeker_entry_view';
			$data['tricker_content'] = 'tricker_account_view';
			$this -> load -> view('include/template', $data);
	}
	/*-----------03-06-2014-------
	*
	*-----------Loan Details Entry
	*
	* Section : Accounts.
	*****************************/
	function loan_details_entry()
	{
		$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$data['bd_date'] = date ('Y-m-d');
			$data['user_id'] = $this -> tank_auth -> get_user_id();
			$data['user_type'] = $this -> tank_auth -> get_usertype();
			$data['user_name'] = $this -> tank_auth -> get_username();	
			$data['shop_name'] = $this -> tank_auth -> get_shopname();
			$data['shop_address'] = $this -> tank_auth -> get_shopaddress();
			$data['access_status'] = '';
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();

			$segment_3 = $this -> uri -> segment(3);
			//$segment_4 = $this -> uri -> segment(4);
			$data['segment_4'] = $this -> uri -> segment(4);

			$loan_seeker_info = $this -> account_model -> loanSeekerInfo(false, false);
			$temp[''] = "Select A Name";
			foreach( $loan_seeker_info -> result() as $field):
				$temp[base_url().'account_controller/loan_details_entry/'.$segment_3.'/'.$field -> loan_seeker_id] = $field -> loan_seeker_name;
			endforeach;
		    $data['loan_seeker_info'] = $temp;

			$data['loan_seeker_mode'] = $this -> account_model -> loanSeekerMode();
			//$data['loan_seeker_type'] = $this -> account_model -> loanSeekerType();

			if($data['segment_4'])
			{
		    	$temp_loan_seeker = $this -> account_model -> loanSeekerInfo(true, $data['segment_4']);
		    	foreach( $temp_loan_seeker -> result() as $field):
			    	$data['loan_seeker_name'] = $field -> loan_seeker_name;
					$data['contact_no'] = $field -> contact_no;
					$data['address'] = $field -> address;
				endforeach;
			}

			$this->form_validation->set_rules('loanAmount', ' ', 'trim|xss_clean|numeric|required');
			$this->form_validation->set_rules('description', ' ', 'trim|xss_clean');

			
			if( $this->form_validation->run())
			{
				if($segment_3 && $data['segment_4'])
				{
					if($this -> account_model -> add_loan_details($segment_3,$data['segment_4']))
						$data['status'] = 'successful';
					else $data['status'] = 'error';
				}
				else $data['status'] = 'failed';
				

			}
			
			//$data['viewType'] = 'reduced_view';
			$data['main_content'] = 'loan_details_entry_view';
			$data['tricker_content'] = 'tricker_account_view';
			$this -> load -> view('include/template', $data);
	}
		function expi_dated_selec(){

			
			if($this->input->post('submit')){
				$all_copany = '';
				$data['user_id'] = $this->tank_auth->get_user_id();
				$all_copany = $this -> site_model -> all_expire_date();
				$expire_date = $this->input->post('specific_date');

				   $output = false;
				   $string = $expire_date;

				   $key = '12e435034534898345';

				   // initialization vector 
				   $iv = md5(md5($key));

					   $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv);
					   $encrypted = base64_encode($output);

				$data = array('expire_date' => $encrypted,'creator'=>$data['user_id']);
				if($all_copany -> num_rows() > 0){
				$dta = array('expire_date' => $encrypted);
					$this->db->where('expire_date_id',1);
					$this->db->update('software_expire_date',$dta);
				}
				else{
					$this->db->insert('software_expire_date',$data);
				}
			}
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$data['bd_date'] = date ('Y-m-d');
				$data['sale_status'] = '';
			
			$data['user_type'] = $this->tank_auth->get_usertype();
			$data['user_id'] = $this->tank_auth->get_user_id();
			$data['user_name'] = $this -> tank_auth -> get_username();
			
			$data['all_company'] = $this -> site_model -> all_expire_date();
			$data['alarming_level'] = $this -> report_model -> product_under_alarming_level();
			$data['main_content'] = 'expirationDateview';
			$data['tricker_content'] = 'tricker_search_option_view';
			$this -> load -> view('include/template',$data);
		}
}