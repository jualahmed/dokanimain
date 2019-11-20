<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Account_model extends CI_model{
    private $userId;
	private $bdDate;
	public function __construct()
	{
		parent::__construct();
		$this -> userId = $this -> tank_auth -> get_user_id();
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$this -> bdDate = date ('Y-m-d');
	}
		/* type entry*/
        function create_type()
		{
			
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');

			$creator = $this->tank_auth->get_user_id();	
	
			$new_type_info_insert_data = array(
				'type_name' => 'Expense',				
				'type_type' => rtrim($this -> input -> post('type_type'),";"),
				'type_doc' => $bd_date,
				'type_dom' => $bd_date,
				'type_creator' => $creator
			);
			return $insert = $this -> db -> insert('type_info',$new_type_info_insert_data);
		}
		 /** for investment_info table **/ 
        function  create_investment()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');

			$creator = $this->tank_auth->get_user_id();	
			$my_bank          		= (int)$this->input->post('my_bank');
			$to_bank          		= (int)$this->input->post('to_bank');
			$cheque_no          	= $this->input->post('cheque_no');
			$cheque_date          	= $this->input->post('cheque_date');
			$new_investment_info_insert_data = array(
				'shop_id' =>$this->tank_auth->get_shop_id(), 
				'investor_id' => $this -> input -> post('investor_id'),	
				'investment_amount' => $this -> input -> post('investment_amount'),
				'investment_details' => $this -> input -> post('investment_details'),
				'investment_doc' => $bd_date,
				'investment_dom' => $bd_date,
				'investment_creator' => $creator
			);	
			$this -> db -> insert('investment_info',$new_investment_info_insert_data);
			$investment_id = $this->db->insert_id();
			
			$payment_mode = $this -> input -> post('payment_mode');
			
			if($payment_mode ==1)
			{
				$transaction_info = array
				(
				   'transaction_id'         			=> '',
				   'transaction_purpose'                => 'investment',
				   'transaction_mode'                 	=> 'cash',
				   'ledger_id'         					=> $this -> input -> post('investor_id'),
				   'amount'     						=> $this -> input -> post('investment_amount'),
				   'date'                   			=> $bd_date,
				   'status'        						=> 'active',
				   'creator'        					=> $creator,
				   'doc'   								=> $bd_date,
				   'dom'    							=> $bd_date
				);
				$this->db->insert('transaction_info', $transaction_info);
				$insert_id1 = $this->db->insert_id();
				$cash_book = array(
				   'cb_id'         						=> '',
				   'transaction_id'                     => $insert_id1,
				   'transaction_type'                	=> 'in',
				   'amount'                 			=> $this -> input -> post('investment_amount'),
				   'date'         						=> $bd_date,
				   'status'    	 						=> 'active',
				   'creator'                   			=> $creator,
				   'doc'        						=> $bd_date,
				   'dom'       							=> $bd_date,
				);
				$this->db->insert('cash_book', $cash_book);
			}
			else 
			{
				$transaction_info = array
				(
				   'transaction_id'         			=> '',
				   'transaction_purpose'                => 'investment',
				   'transaction_mode'                 	=> 'cheque',
				   'ledger_id'         					=> $this -> input -> post('investor_id'),
				   'amount'     						=> $this -> input -> post('investment_amount'),
				   'date'                   			=> $bd_date,
				   'status'        						=> 'active',
				   'creator'        					=> $creator,
				   'doc'   								=> $bd_date,
				   'dom'    							=> $bd_date
				);
				$this->db->insert('transaction_info', $transaction_info);
				$insert_id1 = $this->db->insert_id();
				$bank_book = array(
				   'bb_id'         						=> '',
				   'transaction_id'                     => $insert_id1,
				   'bank_id'                     		=> $my_bank,
				   'card_id'                     		=> 0,
				   'transaction_type'                	=> 'in',
				   'bank_name'                			=> $to_bank,
				   'cheque_no'                			=> $cheque_no,
				   'cheque_date'                		=> $cheque_date,
				   'amount'                 			=> $this -> input -> post('investment_amount'),
				   'date'         						=> $bd_date,
				   'status'    	 						=> 'active',
				   'creator'                   			=> $creator,
				   'doc'        						=> $bd_date,
				   'dom'       							=> $bd_date,
				);
				$this->db->insert('bank_book', $bank_book);
			}
			return $investment_id;
		}
		function get_loan_receive_in()
		{
			if($this->uri->segment(3)=='')
			{
				$lp_id=$this->input->post('lp_id');
			}	
			else{
				$lp_id=$this->uri->segment(3);
			}

			$this->db->select('transaction_info.*,loan_person_info.loan_person_name');
			$this->db->from('transaction_info,loan_person_info');
			$this->db->where('transaction_info.ledger_id=loan_person_info.lp_id');
			$this->db->where('transaction_info.transaction_purpose="loan_receive"');
			$this->db->where('transaction_info.ledger_id',$lp_id);
			$this->db->order_by('transaction_info.transaction_id','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		} 	
		function get_loan_payment_out()
		{
			if($this->uri->segment(3)=='')
			{
				$lp_id=$this->input->post('lp_id');
			}	
			else{
				$lp_id=$this->uri->segment(3);
			}

			$this->db->select('transaction_info.*,loan_person_info.loan_person_name');
			$this->db->from('transaction_info,loan_person_info');
			$this->db->where('transaction_info.ledger_id=loan_person_info.lp_id');
			$this->db->where('transaction_info.transaction_purpose="loan_payment"');
			$this->db->where('transaction_info.ledger_id',$lp_id);
			$this->db->order_by('transaction_info.transaction_id','asc'); 
			$query = $this->db->get();
			
			return $query;
			
		}	
		function get_cash_book_in()
		{
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');

			$this->db->select('cash_book.*,transaction_info.transaction_purpose');
			$this->db->from('cash_book,transaction_info');
			$this->db->where('cash_book.transaction_id=transaction_info.transaction_id');
			$this->db->where('cash_book.transaction_type="in"');

			if($start_date!=''){$this -> db -> where('cash_book.date >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('cash_book.date <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('cash_book.date <= "'.$start_date.'"');}
			$this->db->order_by('cash_book.cb_id','asc'); 
			$this->db->order_by('cash_book.date','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		} 	
		function get_cash_book_out()
		{
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');

			$this->db->select('cash_book.*,transaction_info.transaction_purpose,type_info.type_type');
			$this->db->from('cash_book,transaction_info');
			$this->db->join('type_info','transaction_info.sub_id=type_info.type_id','left');
			$this->db->where('cash_book.transaction_id=transaction_info.transaction_id');
			$this->db->where('cash_book.transaction_type="out"');
			if($start_date!=''){$this -> db -> where('cash_book.date >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('cash_book.date <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('cash_book.date <= "'.$start_date.'"');}
			$this->db->order_by('cash_book.cb_id','asc'); 
			$this->db->order_by('cash_book.date','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		}	
		function all_today_transaction_collection()
		{
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');

			$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.date,transaction_info.remarks,customer_info.customer_name');
			$this->db->from('transaction_info,customer_info');
			$this->db->where('transaction_info.ledger_id=customer_info.customer_id');
			$this->db->where('transaction_info.transaction_purpose="collection"');

			if($start_date!=''){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}
			 
			//$this->db->group_by('transaction_info.transaction_purpose'); 
			//$this->db->order_by('transaction_info.transaction_purpose','asc');
			$query = $this->db->get();
			//print_r($query->result_array());
			
			return $query;	
			
		} 
		function all_today_transaction_sale()
		{
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');

			$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.date,transaction_info.remarks,customer_info.customer_name');
			$this->db->from('transaction_info,customer_info');
			$this->db->where('transaction_info.ledger_id=customer_info.customer_id');
			$this->db->where('transaction_info.transaction_purpose="sale"');

			if($start_date!=''){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}
			 
			//$this->db->group_by('transaction_info.transaction_purpose'); 
			//$this->db->order_by('transaction_info.transaction_purpose','asc');
			$query = $this->db->get();
			//print_r($query->result_array());
			
			return $query;	
			
		} 
		function all_today_transaction_credit_collection()
		{
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');

			$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.date,transaction_info.remarks,customer_info.customer_name');
			$this->db->from('transaction_info,customer_info');
			$this->db->where('transaction_info.ledger_id=customer_info.customer_id');
			$this->db->where('transaction_info.transaction_purpose="credit_collection"');

			if($start_date!=''){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}
			 
			//$this->db->group_by('transaction_info.transaction_purpose'); 
			//$this->db->order_by('transaction_info.transaction_purpose','asc');
			$query = $this->db->get();
			//print_r($query->result_array());
			
			return $query;	
			
		} 
		function all_today_transaction_purchase()
		{
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');

			$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.date,transaction_info.remarks,distributor_info.distributor_name');
			$this->db->from('transaction_info,distributor_info');
			$this->db->where('transaction_info.ledger_id=distributor_info.distributor_id');
			$this->db->where('transaction_info.transaction_purpose="purchase"');

			if($start_date!=''){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}
			 
			//$this->db->group_by('transaction_info.transaction_purpose'); 
			//$this->db->order_by('transaction_info.transaction_purpose','asc');
			$query = $this->db->get();
			//print_r($query->result_array());
			
			return $query;	
			
		} 
		function all_today_transaction_purchase_payment()
		{
			$start_date='2019-01-01';$this->input->post('start_date');
			$end_date='2019-04-03';$this->input->post('end_date');

			$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.date,transaction_info.remarks,distributor_info.distributor_name');
			$this->db->from('transaction_info,distributor_info');
			$this->db->where('transaction_info.ledger_id=distributor_info.distributor_id');
			$this->db->where('transaction_info.transaction_purpose="payment"');

			if($start_date!=''){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}
			 
			//$this->db->group_by('transaction_info.transaction_purpose'); 
			//$this->db->order_by('transaction_info.transaction_purpose','asc');
			$query = $this->db->get();
			//print_r($query->result_array());
			
			return $query;	
			
		} 
		function all_today_transaction_expense()
		{
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');

			$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.date,transaction_info.remarks,type_info.type_type,expense_info.expense_details');
			$this->db->from('transaction_info,expense_info,type_info');
			$this->db->where('transaction_info.common_id=expense_info.expense_id');
			$this->db->where('transaction_info.sub_id=type_info.type_id');
			$this->db->where('transaction_info.transaction_purpose="expense"');

			if($start_date!=''){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}
			 
			//$this->db->group_by('transaction_info.transaction_purpose'); 
			//$this->db->order_by('transaction_info.transaction_purpose','asc');
			$query = $this->db->get();
			//print_r($query->result_array());
			
			return $query;	
			
		} 
		function all_today_transaction_expense_payment()
		{
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');

			$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.date,transaction_info.remarks,type_info.type_type,expense_info.expense_details');
			$this->db->from('transaction_info,type_info');
			$this->db->join('expense_info','transaction_info.common_id=expense_info.expense_id','left');
			$this->db->where('transaction_info.sub_id=type_info.type_id');
			$this->db->where('transaction_info.transaction_purpose="expense_payment"');

			if($start_date!=''){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}
			 
			//$this->db->group_by('transaction_info.transaction_purpose'); 
			//$this->db->order_by('transaction_info.transaction_purpose','asc');
			$query = $this->db->get();
			//print_r($query->result_array());
			
			return $query;	
			
		} 
		
		function all_today_transaction_collection_print()
		{
			$start_date=$this->uri->segment(3);
			$end_date=$this->uri->segment(4);

			$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.date,transaction_info.remarks,customer_info.customer_name');
			$this->db->from('transaction_info,customer_info');
			$this->db->where('transaction_info.ledger_id=customer_info.customer_id');
			$this->db->where('transaction_info.transaction_purpose="collection"');

			if($start_date!='' && $start_date!='null'){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!='null'){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!='null'){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}
			 
			//$this->db->group_by('transaction_info.transaction_purpose'); 
			//$this->db->order_by('transaction_info.transaction_purpose','asc');
			$query = $this->db->get();
			//print_r($query->result_array());
			
			return $query;	
			
		} 
		function all_today_transaction_sale_print()
		{
			$start_date=$this->uri->segment(3);
			$end_date=$this->uri->segment(4);

			$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.date,transaction_info.remarks,customer_info.customer_name');
			$this->db->from('transaction_info,customer_info');
			$this->db->where('transaction_info.ledger_id=customer_info.customer_id');
			$this->db->where('transaction_info.transaction_purpose="sale"');

			if($start_date!='' && $start_date!='null'){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!='null'){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!='null'){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}
			 
			//$this->db->group_by('transaction_info.transaction_purpose'); 
			//$this->db->order_by('transaction_info.transaction_purpose','asc');
			$query = $this->db->get();
			//print_r($query->result_array());
			
			return $query;	
			
		} 
		function all_today_transaction_credit_collection_print()
		{
			$start_date=$this->uri->segment(3);
			$end_date=$this->uri->segment(4);

			$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.date,transaction_info.remarks,customer_info.customer_name');
			$this->db->from('transaction_info,customer_info');
			$this->db->where('transaction_info.ledger_id=customer_info.customer_id');
			$this->db->where('transaction_info.transaction_purpose="credit_collection"');

			if($start_date!='' && $start_date!='null'){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!='null'){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!='null'){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}
			 
			//$this->db->group_by('transaction_info.transaction_purpose'); 
			//$this->db->order_by('transaction_info.transaction_purpose','asc');
			$query = $this->db->get();
			//print_r($query->result_array());
			
			return $query;	
			
		} 
		function all_today_transaction_purchase_print()
		{
			$start_date=$this->uri->segment(3);
			$end_date=$this->uri->segment(4);

			$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.date,transaction_info.remarks,distributor_info.distributor_name');
			$this->db->from('transaction_info,distributor_info');
			$this->db->where('transaction_info.ledger_id=distributor_info.distributor_id');
			$this->db->where('transaction_info.transaction_purpose="purchase"');

			if($start_date!='' && $start_date!='null'){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!='null'){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!='null'){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}
			 
			//$this->db->group_by('transaction_info.transaction_purpose'); 
			//$this->db->order_by('transaction_info.transaction_purpose','asc');
			$query = $this->db->get();
			//print_r($query->result_array());
			
			return $query;	
			
		} 
		function all_today_transaction_purchase_payment_print()
		{
			$start_date=$this->uri->segment(3);
			$end_date=$this->uri->segment(4);

			$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.date,transaction_info.remarks,distributor_info.distributor_name');
			$this->db->from('transaction_info,distributor_info');
			$this->db->where('transaction_info.ledger_id=distributor_info.distributor_id');
			$this->db->where('transaction_info.transaction_purpose="payment"');

			if($start_date!='' && $start_date!='null'){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!='null'){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!='null'){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}
			 
			//$this->db->group_by('transaction_info.transaction_purpose'); 
			//$this->db->order_by('transaction_info.transaction_purpose','asc');
			$query = $this->db->get();
			//print_r($query->result_array());
			
			return $query;	
			
		} 
		function all_today_transaction_expense_print()
		{
			$start_date=$this->uri->segment(3);
			$end_date=$this->uri->segment(4);

			$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.date,transaction_info.remarks,type_info.type_type,expense_info.expense_details');
			$this->db->from('transaction_info,expense_info,type_info');
			$this->db->where('transaction_info.common_id=expense_info.expense_id');
			$this->db->where('transaction_info.sub_id=type_info.type_id');
			$this->db->where('transaction_info.transaction_purpose="expense"');

			if($start_date!='' && $start_date!='null'){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!='null'){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!='null'){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}
			 
			//$this->db->group_by('transaction_info.transaction_purpose'); 
			//$this->db->order_by('transaction_info.transaction_purpose','asc');
			$query = $this->db->get();
			//print_r($query->result_array());
			
			return $query;			
			
		} 
		function all_today_transaction_expense_payment_print()
		{
			$start_date=$this->uri->segment(3);
			$end_date=$this->uri->segment(4);

			$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.date,transaction_info.remarks,type_info.type_type,expense_info.expense_details');
			$this->db->from('transaction_info,type_info');
			$this->db->join('expense_info','transaction_info.common_id=expense_info.expense_id','left');
			$this->db->where('transaction_info.sub_id=type_info.type_id');
			$this->db->where('transaction_info.transaction_purpose="expense_payment"');

			if($start_date!='' && $start_date!='null'){$this -> db -> where('transaction_info.date >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!='null'){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!='null'){$this -> db -> where('transaction_info.date <= "'.$start_date.'"');}
			 
			//$this->db->group_by('transaction_info.transaction_purpose'); 
			//$this->db->order_by('transaction_info.transaction_purpose','asc');
			$query = $this->db->get();
			//print_r($query->result_array());
			
			return $query;	
			
		} 
		function all_today_transaction_sum()
		{
			$this->db->select('transaction_info.transaction_purpose');
			$this->db->from('transaction_info');
			$this->db->group_by('transaction_info.transaction_purpose'); 
			$query = $this->db->get();
			
			return $query;	
		} 
		function today_cashbook()
		{
			$start=$this->input->post('start_date');
			$end=$this->input->post('end_date');
			
			$query1 = $this -> db -> select_sum('cash_book.amount')
								 -> from('cash_book')
								 -> where('cash_book.transaction_type = "in"')
								 -> where('cash_book.date >= "'.$start.'"')
								 -> where('cash_book.date <= "'.$end.'"')
								 -> get();
			foreach($query1 -> result() as $result):
					$todays_cash_book_in = $result -> amount;
			endforeach;
			$query2 = $this -> db -> select_sum('cash_book.amount')
								 -> from('cash_book')
								 -> where('cash_book.transaction_type = "out"')
								 -> where('cash_book.date >= "'.$start.'"')
								 -> where('cash_book.date <= "'.$end.'"')
								 -> get();
			foreach($query2 -> result() as $result):
					$todays_cash_book_out = $result -> amount;
			endforeach;
			return $todays_cash_book = $todays_cash_book_in - $todays_cash_book_out;
		} 
		function today_bankbook()
		{
			$start=$this->input->post('start_date');
			$end=$this->input->post('end_date');
			
			$query = $this -> db -> select_sum('bank_book.amount')
								 -> from('bank_book')
								 -> where('bank_book.transaction_type = "in"')
								 -> where('bank_book.date >= "'.$start.'"')
								 -> where('bank_book.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_collection_bank_in = $result -> amount;
			endforeach;
			$query2 = $this -> db -> select_sum('bank_book.amount')
								 -> from('bank_book')
								 -> where('bank_book.transaction_type = "out"')
								 -> where('bank_book.date >= "'.$start.'"')
								 -> where('bank_book.date <= "'.$end.'"')
								 -> get();
			foreach($query2 -> result() as $result):
					$todays_collection_bank_out = $result -> amount;
			endforeach;
			return $todays_collection_bank_in - $todays_collection_bank_out;
		} 
		function today_cashbook_print()
		{
			$start=$this->uri->segment(3);
			$end=$this->uri->segment(4);
			
			$query1 = $this -> db -> select_sum('cash_book.amount')
								 -> from('cash_book')
								 -> where('cash_book.transaction_type = "in"')
								 -> where('cash_book.date >= "'.$start.'"')
								 -> where('cash_book.date <= "'.$end.'"')
								 -> get();
			foreach($query1 -> result() as $result):
					$todays_cash_book_in = $result -> amount;
			endforeach;
			$query2 = $this -> db -> select_sum('cash_book.amount')
								 -> from('cash_book')
								 -> where('cash_book.transaction_type = "out"')
								 -> where('cash_book.date >= "'.$start.'"')
								 -> where('cash_book.date <= "'.$end.'"')
								 -> get();
			foreach($query2 -> result() as $result):
					$todays_cash_book_out = $result -> amount;
			endforeach;
			return $todays_cash_book = $todays_cash_book_in - $todays_cash_book_out;
		} 
		function today_bankbook_print()
		{
			$start=$this->uri->segment(3);
			$end=$this->uri->segment(4);
			
			$query = $this -> db -> select_sum('bank_book.amount')
								 -> from('bank_book')
								 -> where('bank_book.transaction_type = "in"')
								 -> where('bank_book.date >= "'.$start.'"')
								 -> where('bank_book.date <= "'.$end.'"')
								 -> get();
			foreach($query -> result() as $result):
					$todays_collection_bank_in = $result -> amount;
			endforeach;
			$query2 = $this -> db -> select_sum('bank_book.amount')
								 -> from('bank_book')
								 -> where('bank_book.transaction_type = "out"')
								 -> where('bank_book.date >= "'.$start.'"')
								 -> where('bank_book.date <= "'.$end.'"')
								 -> get();
			foreach($query2 -> result() as $result):
					$todays_collection_bank_out = $result -> amount;
			endforeach;
			return $todays_collection_bank_in - $todays_collection_bank_out;
		} 
		function get_cash_book_in_print()
		{
			$start_date=$this->uri->segment(3);
			$end_date=$this->uri->segment(4);

			$this->db->select('cash_book.*,transaction_info.transaction_purpose');
			$this->db->from('cash_book,transaction_info');
			$this->db->where('cash_book.transaction_id=transaction_info.transaction_id');
			$this->db->where('cash_book.transaction_type="in"');

			if($start_date!='' && $start_date!='null'){$this -> db -> where('cash_book.date >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!='null'){$this -> db -> where('cash_book.date <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!='null'){$this -> db -> where('cash_book.date <= "'.$start_date.'"');}
			$this->db->order_by('cash_book.cb_id','asc'); 
			$this->db->order_by('cash_book.date','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		} 	
		function get_cash_book_out_print()
		{
			$start_date=$this->uri->segment(3);
			$end_date=$this->uri->segment(4);

			$this->db->select('cash_book.*,transaction_info.transaction_purpose,type_info.type_type');
			$this->db->from('cash_book,transaction_info');
			$this->db->join('type_info','transaction_info.sub_id=type_info.type_id','left');
			$this->db->where('cash_book.transaction_id=transaction_info.transaction_id');
			$this->db->where('cash_book.transaction_type="out"');
			if($start_date!='' && $start_date!='null'){$this -> db -> where('cash_book.date >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!='null'){$this -> db -> where('cash_book.date <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!='null'){$this -> db -> where('cash_book.date <= "'.$start_date.'"');}
			$this->db->order_by('cash_book.cb_id','asc'); 
			$this->db->order_by('cash_book.date','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		}	
		function get_bank_book_in()
		{
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');

			$this->db->select('bank_book.*,transaction_info.transaction_purpose');
			$this->db->from('bank_book,transaction_info');
			$this->db->where('bank_book.transaction_id=transaction_info.transaction_id');
			$this->db->where('bank_book.transaction_type="in"');

			if($start_date!=''){$this -> db -> where('bank_book.date >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('bank_book.date <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('bank_book.date <= "'.$start_date.'"');}
			$this->db->order_by('bank_book.bb_id','asc'); 
			$this->db->order_by('bank_book.date','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		} 	
		function get_bank_book_out()
		{
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');

			$this->db->select('bank_book.*,transaction_info.transaction_purpose');
			$this->db->from('bank_book,transaction_info');
			$this->db->where('bank_book.transaction_id=transaction_info.transaction_id');
			$this->db->where('bank_book.transaction_type="out"');
			if($start_date!=''){$this -> db -> where('bank_book.date >= "'.$start_date.'"');}
			if($end_date!=''){$this -> db -> where('bank_book.date <= "'.$end_date.'"');}
			else if($start_date!=''){$this -> db -> where('bank_book.date <= "'.$start_date.'"');}
			$this->db->order_by('bank_book.bb_id','asc'); 
			$this->db->order_by('bank_book.date','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		} 	
		function get_bank_book_in_print()
		{
			$start_date=$this->uri->segment(3);
			$end_date=$this->uri->segment(4);

			$this->db->select('bank_book.*,transaction_info.transaction_purpose');
			$this->db->from('bank_book,transaction_info');
			$this->db->where('bank_book.transaction_id=transaction_info.transaction_id');
			$this->db->where('bank_book.transaction_type="in"');

			if($start_date!='' && $start_date!='null'){$this -> db -> where('bank_book.date >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!='null'){$this -> db -> where('bank_book.date <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!='null'){$this -> db -> where('bank_book.date <= "'.$start_date.'"');}
			$this->db->order_by('bank_book.bb_id','asc'); 
			$this->db->order_by('bank_book.date','asc'); 
			$query = $this->db->get();
			
			return $query;	
			
		} 	
		function get_bank_book_out_print()
		{
			$start_date=$this->uri->segment(3);
			$end_date=$this->uri->segment(4);

			$this->db->select('bank_book.*,transaction_info.transaction_purpose');
			$this->db->from('bank_book,transaction_info');
			$this->db->where('bank_book.transaction_id=transaction_info.transaction_id');
			$this->db->where('bank_book.transaction_type="out"');
			if($start_date!='' && $start_date!='null'){$this -> db -> where('bank_book.date >= "'.$start_date.'"');}
			if($end_date!='' && $end_date!='null'){$this -> db -> where('bank_book.date <= "'.$end_date.'"');}
			else if($start_date!='' && $start_date!='null'){$this -> db -> where('bank_book.date <= "'.$start_date.'"');}
			$this->db->order_by('bank_book.bb_id','asc'); 
			$this->db->order_by('bank_book.date','asc'); 
			$query = $this->db->get();
			
			return $query;	
		}	

	/* Ending: newCreatePurchaseReceipt (added by Prasanta). */
	function get_all_bank()
	{
		$this->db->select('bank_info.bank_name,bank_info.bank_id');
		$this->db->from('bank_info');
		$this->db->order_by('bank_info.bank_name','asc');
		$query = $this->db->get();
		return $query;
	}
	function all_investor()
	{
		$this -> db -> order_by('investor_info.investor_name','asc');
		$query = $this -> db -> get('investor_info');
		$data[''] =  'Select Investor';
		foreach ($query -> result() as $field){
				$data[$field -> investor_id] = $field -> investor_name;
			}
		return $data;
	}
	
	function get_investment_info_by_multi()
	{
		$investor_id= $this->input->post('investor_id');
		$start_date=$this->input->post('start_date');
		$end_date=$this->input->post('end_date');
		
		$this->db->select('investment_info.*,investor_info.investor_name');
		$this->db->from('investment_info,investor_info');
		$this->db->where('investment_info.investor_id = investor_info.investor_id');
		
		if($investor_id!=''){$this->db->where('investment_info.investor_id',$investor_id);}
		if($start_date!=''){$this -> db -> where('investment_info.investment_doc >= "'.$start_date.'"');}
		if($end_date!=''){$this -> db -> where('investment_info.investment_doc <= "'.$end_date.'"');}
		else if($start_date!=''){$this -> db -> where('investment_info.investment_doc <= "'.$start_date.'"');}

		//$this->db->group_by('investment_info.investor_id');
		$this->db->order_by('investment_info.investor_id','asc'); 
		$this->db->order_by('investment_info.investment_doc','asc'); 
		$query = $this->db->get();
		
		return $query;	
		
	} 		
	function print_data_investment()
	{
		$investor_id= $this->uri->segment(3);
		$start_date=$this->uri->segment(4);
		$end_date=$this->uri->segment(5);
		
		$this->db->select('investment_info.*,investor_info.investor_name');
		$this->db->from('investment_info,investor_info');
		$this->db->where('investment_info.investor_id = investor_info.investor_id');
		
		if($investor_id!='' && $investor_id!='null'){$this->db->where('investment_info.investor_id',$investor_id);}
		if($start_date!='' && $start_date!='null'){$this -> db -> where('investment_info.investment_doc >= "'.$start_date.'"');}
		if($end_date!='' && $end_date!='null'){$this -> db -> where('investment_info.investment_doc <= "'.$end_date.'"');}
		else if($start_date!='' && $start_date!='null'){$this -> db -> where('investment_info.investment_doc <= "'.$start_date.'"');}

		//$this->db->group_by('investment_info.investor_id');
		$this->db->order_by('investment_info.investor_id','asc'); 
		$this->db->order_by('investment_info.investment_doc','asc'); 
		$query = $this->db->get();
		
		return $query;	
		
	} 
	function get_cheque_status_info_by_multi($cheque_status)
	{
		$this->db->select('bank_book.*,bank_info.bank_name');
		$this->db->from('bank_book,bank_info');
		$this->db->where('bank_book.bank_id = bank_info.bank_id');
		
		$this->db->where('bank_book.status',$cheque_status);

		$this->db->order_by('bank_book.bb_id','asc'); 
		$query = $this->db->get();
		
		return $query;	
		
	} 
	public function get_sale_ledger_name($ledger_type,$ledger_id,$bb_id)
	{
		$this->db->select('customer_info.customer_name as sale_ledger');
		$this->db->from('customer_info, bank_book');
		$this->db->where('customer_info.customer_id =bank_book.ledger_id'); 
		$this->db->where('bank_book.bb_id',$bb_id);
		$this->db->where('bank_book.ledger_id',$ledger_id);
		$this->db->where('bank_book.ledger_type',$ledger_type);
		$this->db->order_by('bank_book.bb_id','asc'); 
		$query_data = $this->db->get();
		return $query_data;
	}
	public function get_purchase_ledger_name($ledger_type,$ledger_id,$bb_id)
	{
		$this->db->select('distributor_info.distributor_name as purchase_ledger');
		$this->db->from('distributor_info, bank_book');
		$this->db->where('distributor_info.distributor_id =bank_book.ledger_id'); 
		$this->db->where('bank_book.bb_id',$bb_id);
		$this->db->where('bank_book.ledger_id',$ledger_id);
		$this->db->where('bank_book.ledger_type',$ledger_type);
		$this->db->order_by('bank_book.bb_id','asc'); 
		$query_data = $this->db->get();
		return $query_data;
	}
	public function get_expense_ledger_name($ledger_type,$ledger_id,$bb_id)
	{
		$this->db->select('service_provider_info.service_provider_name as expense_ledger');
		$this->db->from('service_provider_info,bank_book');
		$this->db->where('service_provider_info.service_provider_id =bank_book.ledger_id');
		$this->db->where('bank_book.bb_id',$bb_id);
		$this->db->where('bank_book.ledger_id',$ledger_id);
		$this->db->where('bank_book.ledger_type',$ledger_type);
		$this->db->order_by('bank_book.bb_id','asc'); 
		$query_data = $this->db->get();
		return $query_data;
	}
	
	/* insert bank transfer information   */
	public function create_transfer()
	{
		$bd_date = date('Y-m-d');
		$transfer_type = $this->input->post('transfer_type');
		$bank_id  = $this->input->post('bank_id');
		$cheque_no  = $this->input->post('cheque_no');
		$cheque_date  = $this->input->post('cheque_date');
		$service_provider_id  = $this->input->post('service_provider_id');
		$amount  = $this->input->post('amount');
		$creator = $this->tank_auth->get_user_id();
		
		if($transfer_type ==1)
		{
			$to_bank_transaction_info = array(
				'transaction_purpose' =>'to_bank', 
				'transaction_mode' => 'cash',
				'amount' => $amount,
				'date' => $bd_date,
				'status' => 'active',
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$this -> db -> insert('transaction_info',$to_bank_transaction_info);
			$transaction_id = $this->db->insert_id();
			$to_bank_cash_book = array(
				'transaction_id' =>$transaction_id, 
				'transaction_type' => 'out',
				'amount' => $amount,
				'date' => $bd_date,
				'status' => 'active',
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$insert = $this -> db -> insert('cash_book',$to_bank_cash_book);
			$to_bank_bank_book = array(
				'transaction_id' =>$transaction_id, 
				'bank_id' => $bank_id,
				'transaction_type' => 'in',
				'amount' => $amount,
				'date' => $bd_date,
				'status' => 'active',
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$insert = $this -> db -> insert('bank_book',$to_bank_bank_book);
			return $transaction_id;
		}
		else
		{
			$from_bank_transaction_info = array(
				'transaction_purpose' =>'from_bank', 
				'transaction_mode' => 'cheque',
				'amount' => $amount,
				'date' => $bd_date,
				'status' => 'active',
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$this -> db -> insert('transaction_info',$from_bank_transaction_info);
			$transaction_id = $this->db->insert_id();
			$from_bank_cash_book = array(
				'transaction_id' =>$transaction_id, 
				'transaction_type' => 'in',
				'amount' => $amount,
				'date' => $bd_date,
				'status' => 'active',
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$insert = $this -> db -> insert('cash_book',$from_bank_cash_book);
			$from_bank_bank_book = array(
				'transaction_id' =>$transaction_id, 
				'bank_id' => $bank_id,
				'cheque_no' => $cheque_no,
				'cheque_date' => $cheque_date,
				'transaction_type' => 'out',
				'amount' => $amount,
				'date' => $bd_date,
				'status' => 'active',
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$insert = $this -> db -> insert('bank_book',$from_bank_bank_book);
			return $transaction_id;
		}
    }

	/* insert owner transfer information   */
	public function create_owner_transfer()
	{
		$bd_date = date('Y-m-d');
		$transfer_type = $this -> input -> post('transfer_type');
		$payment_type = $this -> input -> post('payment_type');
		$owner_id  = $this -> input -> post('owner_id');
		$bank_id  = $this -> input -> post('bank_id');
		$cheque_no  = $this -> input -> post('cheque_no');
		$cheque_date  = $this -> input -> post('cheque_date');
		$amount  = $this -> input -> post('amount');
		$creator = $this->tank_auth->get_user_id();
		if($transfer_type ==1)
		{
			if($payment_type==1)
			{
				$to_owner_transaction_info = array(
					'transaction_purpose' =>'to_owner', 
					'transaction_mode' => 'cash',
					'ledger_id' => $owner_id,
					'amount' => $amount,
					'date' => $bd_date,
					'status' => 'active',
					'creator' => $creator,
					'doc' => $bd_date,
					'dom' => $bd_date
				);
				$this -> db -> insert('transaction_info',$to_owner_transaction_info);
				$transaction_id = $this->db->insert_id();
				$to_owner_book = array(
					'transaction_id' =>$transaction_id, 
					'cash_cheque' => 'cash',
					'transaction_type' => 'in',
					'cheque_no' => 0,
					'cheque_date' => 0000-00-00,
					'amount' => $amount,
					'date' => $bd_date,
					'status' => 'active',
					'creator' => $creator,
					'doc' => $bd_date,
					'dom' => $bd_date
				);
				$insert = $this -> db -> insert('owner_book',$to_owner_book);
				$out_cash_book = array(
					'transaction_id' =>$transaction_id, 
					'transaction_type' => 'out',
					'amount' => $amount,
					'date' => $bd_date,
					'status' => 'active',
					'creator' => $creator,
					'doc' => $bd_date,
					'dom' => $bd_date
				);
				$insert = $this -> db -> insert('cash_book',$out_cash_book);
				return $transaction_id;
			}
			else
			{
				$from_owner_transaction_info = array(
					'transaction_purpose' =>'to_owner', 
					'transaction_mode' => 'cheque',
					'ledger_id' => $owner_id,
					'amount' => $amount,
					'date' => $bd_date,
					'status' => 'active',
					'creator' => $creator,
					'doc' => $bd_date,
					'dom' => $bd_date
				);
				$this -> db -> insert('transaction_info',$from_owner_transaction_info);
				$transaction_id = $this->db->insert_id();
				$from_owner_book = array(
					'transaction_id' =>$transaction_id, 
					'cash_cheque' => 'cheque',
					'transaction_type' => 'in',
					'cheque_no' => $cheque_no,
					'cheque_date' => $cheque_date,
					'amount' => $amount,
					'date' => $bd_date,
					'status' => 'active',
					'creator' => $creator,
					'doc' => $bd_date,
					'dom' => $bd_date
				);
				$insert = $this -> db -> insert('owner_book',$from_owner_book);
				$in_bank_book = array(
					'transaction_id' =>$transaction_id, 
					'transaction_type' => 'out',
					'bank_name' => $bank_id,
					'cheque_no' => $cheque_no,
					'cheque_date' => $cheque_date,
					'amount' => $amount,
					'date' => $bd_date,
					'status' => 'active',
					'creator' => $creator,
					'doc' => $bd_date,
					'dom' => $bd_date
				);
				$insert = $this -> db -> insert('bank_book',$in_bank_book);
				return $transaction_id;
			}
		}
		else
		{
			if($payment_type==1)
			{
				$from_owner_transaction_info = array(
					'transaction_purpose' =>'from_owner', 
					'transaction_mode' => 'cash',
					'ledger_id' => $owner_id,
					'amount' => $amount,
					'date' => $bd_date,
					'status' => 'active',
					'creator' => $creator,
					'doc' => $bd_date,
					'dom' => $bd_date
				);
				$this -> db -> insert('transaction_info',$from_owner_transaction_info);
				$transaction_id = $this->db->insert_id();
				$from_owner_book = array(
					'transaction_id' =>$transaction_id, 
					'cash_cheque' => 'cash',
					'transaction_type' => 'out',
					'cheque_no' => 0,
					'cheque_date' => 0000-00-00,
					'amount' => $amount,
					'date' => $bd_date,
					'status' => 'active',
					'creator' => $creator,
					'doc' => $bd_date,
					'dom' => $bd_date
				);
				$insert = $this -> db -> insert('owner_book',$from_owner_book);
				$in_cash_book = array(
					'transaction_id' =>$transaction_id, 
					'transaction_type' => 'in',
					'amount' => $amount,
					'date' => $bd_date,
					'status' => 'active',
					'creator' => $creator,
					'doc' => $bd_date,
					'dom' => $bd_date
				);
				$insert = $this -> db -> insert('cash_book',$in_cash_book);
				return $transaction_id;
			}
			else
			{
				$from_owner_transaction_info = array(
					'transaction_purpose' =>'from_owner', 
					'transaction_mode' => 'cheque',
					'ledger_id' => $owner_id,
					'amount' => $amount,
					'date' => $bd_date,
					'status' => 'active',
					'creator' => $creator,
					'doc' => $bd_date,
					'dom' => $bd_date
				);
				$this -> db -> insert('transaction_info',$from_owner_transaction_info);
				$transaction_id = $this->db->insert_id();
				$from_owner_book = array(
					'transaction_id' =>$transaction_id, 
					'cash_cheque' => 'cheque',
					'transaction_type' => 'out',
					'cheque_no' => $cheque_no,
					'cheque_date' => $cheque_date,
					'amount' => $amount,
					'date' => $bd_date,
					'status' => 'active',
					'creator' => $creator,
					'doc' => $bd_date,
					'dom' => $bd_date
				);
				$insert = $this -> db -> insert('owner_book',$from_owner_book);
				$in_bank_book = array(
					'transaction_id' =>$transaction_id, 
					'transaction_type' => 'in',
					'bank_name' => $bank_id,
					'cheque_no' => $cheque_no,
					'cheque_date' => $cheque_date,
					'amount' => $amount,
					'date' => $bd_date,
					'status' => 'active',
					'creator' => $creator,
					'doc' => $bd_date,
					'dom' => $bd_date
				);
				$insert = $this -> db -> insert('bank_book',$in_bank_book);
				return $transaction_id;
			}
		}
    }

	/* insert bank information to bank_info table   */
	function create_loan_transfer()
	{
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date = date('Y-m-d');
		
		$transfer_type = $this -> input -> post('transfer_type');
		$lp_id  = $this -> input -> post('lp_id');
		$amount  = $this -> input -> post('amount');
		$creator = $this->tank_auth->get_user_id();
		
		if($transfer_type ==1)
		{
			$loan_receive_transaction_info = array(
				'transaction_purpose' =>'loan_receive', 
				'transaction_mode' => 'cash',
				'ledger_id' => $lp_id,
				'amount' => $amount,
				'date' => $bd_date,
				'status' => 'active',
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$this -> db -> insert('transaction_info',$loan_receive_transaction_info);
			$transaction_id = $this->db->insert_id();
			$in_cash_book = array(
				'transaction_id' =>$transaction_id, 
				'transaction_type' => 'in',
				'amount' => $amount,
				'date' => $bd_date,
				'status' => 'active',
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$insert = $this -> db -> insert('cash_book',$in_cash_book);
			return $transaction_id;
		}
		else
		{
			$loan_payment_transaction_info = array(
				'transaction_purpose' =>'loan_payment', 
				'transaction_mode' => 'cash',
				'ledger_id' => $lp_id,
				'amount' => $amount,
				'date' => $bd_date,
				'status' => 'active',
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$this -> db -> insert('transaction_info',$loan_payment_transaction_info);
			$transaction_id = $this->db->insert_id();
			$out_cash_book = array(
				'transaction_id' =>$transaction_id, 
				'transaction_type' => 'out',
				'amount' => $amount,
				'date' => $bd_date,
				'status' => 'active',
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$insert = $this -> db -> insert('cash_book',$out_cash_book);
			return $transaction_id;
		}

    }

	function create_bank()
	{
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date = date('Y-m-d');
		
		$bank_name = $this -> input -> post('bank_name');
		$bank_account_no  = $this -> input -> post('bank_account_no');
		$bank_account_name  = $this -> input -> post('bank_account_name');
		//$bank_status  = $this -> input -> post('bank_status');
		
		$creator = $this->tank_auth->get_user_id();	
		
		$new_bank_info_insert_data = array(
			//'shop_id' =>$this->tank_auth->get_shop_id(), 
			'bank_name ' => $bank_name,
			'bank_account_no ' => $bank_account_no,
			'bank_account_name ' => $bank_account_name,
			'bank_status ' => 'active',	
			'bank_description' => $this -> input ->post('bank_description'),
			'bank_doc' => $bd_date,
			'bank_dom' => $bd_date,
			'bank_creator' => $creator
		);		
		$insert = $this -> db -> insert('bank_info',$new_bank_info_insert_data );
		return $this->db->insert_id();
	}

    /* insert bank_book information to bank_book_info table   */
    function create_bank_book() //------------ this fuction means nothing.......its still unused :P ---10-12-2013---
	{
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date = date('Y-m-d');
		
		$creator = $this->tank_auth->get_user_id();	
		
		$new_bank_book_info_insert_data = array(
			'bank_id ' => $this -> input -> post('bank_id'),
			'transaction_type' => $this -> input -> post('transaction_type'),		
			'amount' => $this -> input -> post('amount'),
			'bank_book_doc' => $bd_date,
			'bank_book_dom' => $bd_date,
			'bank_book_creator' => $creator
		);
		return $insert = $this -> db -> insert('bank_book_info',$new_bank_book_info_insert_data );
	}
	
	/*-----------27-11-2017------
	*
	*-----------Customer Credit Collection
	*
	* Section : Accounts. By Prasanta Bhattacharjee
	*****************************/

	public function receipt_sale_total_amount($customer_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_sale_amount,customer_info.customer_id,customer_info.customer_name,customer_info.customer_contact_no,customer_info.customer_address');
		$this->db->from('transaction_info,customer_info');			
		$this->db->where('(transaction_info.transaction_purpose = "sale" OR transaction_info.transaction_purpose = "delivery_charge")');
		$this->db->where('transaction_info.ledger_id = customer_info.customer_id');
		$this->db->where('transaction_info.ledger_id',$customer_id);
		$query_data = $this->db->get();
		return $query_data;
	}

	public function receipt_collection_total_amount($customer_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_collection_amount');
		$this->db->from('transaction_info');			
		$this->db->where('(transaction_info.transaction_purpose = "collection" OR transaction_info.transaction_purpose = "credit_collection")');
		$this->db->where('transaction_info.ledger_id',$customer_id);
		$query_data = $this->db->get();
		return $query_data;
	}

	public function receipt_delivery_total_amount($customer_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_delivery_amount');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "delivery_charge"');
		$this->db->where('transaction_info.ledger_id',$customer_id);
		$query_data = $this->db->get();
		return $query_data;
	}

	public function receipt_sale_return_total_amount($customer_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_sale_return_amount');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "sale_return"');
		$this->db->where('transaction_info.ledger_id',$customer_id);
		$query_data = $this->db->get();
		return $query_data;
	}

	public function receipt_cash_return_total_amount($customer_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_cash_return_amount');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "cash_return"');
		$this->db->where('transaction_info.ledger_id',$customer_id);
		$query_data = $this->db->get();
		return $query_data;
	}

	public function receipt_balance_total_amount_customer($customer_id)
	{
		$this->db->select('SUM(customer_info.int_balance) as total_balance_amount');
		$this->db->from('customer_info');			
		$this->db->where('customer_info.customer_id',$customer_id);
		$query_data = $this->db->get();
		return $query_data;
	}

	public function receipt_purchase_total_amount($distributor_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_purchase_amount,distributor_info.distributor_name,distributor_info.distributor_contact_no,distributor_info.distributor_address');
		$this->db->from('transaction_info,distributor_info');			
		$this->db->where('transaction_info.transaction_purpose = "purchase"');
		$this->db->where('transaction_info.ledger_id = distributor_info.distributor_id');
		$this->db->where('transaction_info.ledger_id',$distributor_id);
		$query_data = $this->db->get();
		return $query_data;
	}

	public function receipt_payment_total_amount($distributor_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_payment_amount');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "payment"');
		$this->db->where('transaction_info.ledger_id',$distributor_id);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function receipt_purchase_return_total_amount($distributor_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_purchase_return_amount');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "purchase_return"');
		$this->db->where('transaction_info.ledger_id',$distributor_id);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function receipt_payment_delete_total_amount($distributor_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_delete_payment_amount');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "purchase_payment_deleted"');
		$this->db->where('transaction_info.ledger_id',$distributor_id);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function receipt_balance_total_amount_distributor($distributor_id)
	{
		$this->db->select('SUM(distributor_info.int_balance) as total_balance_amount');
		$this->db->from('distributor_info');			
		$this->db->where('distributor_info.distributor_id',$distributor_id);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function receipt_expense_total_amount_emp_wise($employee_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_expense_amount,employee_info.*,type_info.*');
		$this->db->from('transaction_info,employee_info');			
		$this->db->where('transaction_info.transaction_purpose = "expense"');
		$this->db->where('transaction_info.ledger_id = employee_info.employee_id');
		$this->db->join('type_info','transaction_info.sub_id = type_info.type_id','left');
		$this->db->where('transaction_info.ledger_id',$employee_id);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function receipt_expense_delete_total_amount_emp_wise($employee_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_delete_expense_amount');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "expense_payment_deleted"');
		$this->db->where('transaction_info.ledger_id',$employee_id);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function receipt_expense_payment_total_amount_emp_wise($employee_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_expense_payment_amount');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "expense_payment"');
		$this->db->where('transaction_info.ledger_id',$employee_id);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function receipt_expense_total_amount_type_wise($expense_type)
	{
		$this->db->select('SUM(transaction_info.amount) as total_expense_amount,type_info.*');
		$this->db->from('transaction_info,type_info');			
		$this->db->where('transaction_info.transaction_purpose = "expense"');
		$this->db->where('transaction_info.sub_id = type_info.type_id');
		$this->db->where('transaction_info.sub_id',$expense_type);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function receipt_expense_delete_total_amount_type_wise($expense_type)
	{
		$this->db->select('SUM(transaction_info.amount) as total_delete_expense_amount');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "expense_payment_deleted"');
		$this->db->where('transaction_info.sub_id',$expense_type);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function receipt_expense_payment_total_amount_type_wise($expense_type)
	{
		$this->db->select('SUM(transaction_info.amount) as total_expense_payment_amount');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "expense_payment"');
		$this->db->where('transaction_info.sub_id',$expense_type);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function do_collection_client($creator,$payment_mode,$customer_id,$card_id, $payment_amount,$my_bank,$to_bank,$cheque_no,$cheque_date,$balance_customer,$remarks)
	{
		/* $data = array(
		
		) */
		
		if($payment_mode==1)
		{
			$collection_info = array
			(
			   'transaction_id'         			=> '',
			   'transaction_purpose'                => 'credit_collection',
			   'transaction_mode'                 	=> 'cash',
			   'ledger_id'         					=> $customer_id,
			   'amount'     						=> $payment_amount,
			   'remarks'     						=> $remarks,
			   'date'                   			=> date('Y-m-d'),
			   'status'        						=> 'active',
			   'creator'        					=> $creator,
			   'doc'   								=> date('Y-m-d'),
			   'dom'    							=> date('Y-m-d')
			);
			$this->db->insert('transaction_info', $collection_info);
			$insert_id = $this->db->insert_id();
			$cash_book = array(
			   'cb_id'         						=> '',
			   'transaction_id'                     => $insert_id,
			   'transaction_type'                	=> 'in',
			   'amount'                 			=> $payment_amount,
			   'date'         						=> date('Y-m-d'),
			   'status'    	 						=> 'active',
			   'creator'                   			=> $creator,
			   'doc'        						=> date('Y-m-d'),
			   'dom'       							=> date('Y-m-d')
			);
			$this->db->insert('cash_book', $cash_book);
			return $insert_id;
		}
		else if($payment_mode==2)
		{
			$bank_book = array(
			   'bb_id'         						=> '',
			   'transaction_id'                     => '',
			   'ledger_id'         					=> $customer_id,
			   'ledger_type'         				=> 'sale_collection',
			   'bank_id'                     		=> $my_bank,
			   'card_id'                     		=> 0,
			   'transaction_type'                	=> 'in',
			   'bank_name'                			=> $to_bank,
			   'cheque_no'                			=> $cheque_no,
			   'cheque_date'                		=> $cheque_date,
			   'amount'                 			=> $payment_amount,
			   'date'         						=> date('Y-m-d'),
			   'status'    	 						=> 'inactive',
			   'creator'                   			=> $creator,
			   'doc'        						=> date('Y-m-d'),
			   'dom'       							=> date('Y-m-d')
			);
			$this->db->insert('bank_book', $bank_book);
			return 'cheque';
		}
		
		else if($payment_mode==3)
		{
			$collection_info = array
			(
			   'transaction_id'         			=> '',
			   'transaction_purpose'                => 'credit_collection',
			   'transaction_mode'                 	=> 'card',
			   'ledger_id'         					=> $customer_id,
			   'remarks'     						=> $remarks,
			   'amount'     						=> $payment_amount,
			   'date'                   			=> date('Y-m-d'),
			   'status'        						=> 'active',
			   'creator'        					=> $creator,
			   'doc'   								=> date('Y-m-d'),
			   'dom'    							=> date('Y-m-d')
			);
			$this->db->insert('transaction_info', $collection_info);
			$insert_id = $this->db->insert_id();
			
			$this->db->select('bank_card_info.bank_id');
			$this->db->from('bank_card_info');
			$this->db->where('bank_card_info.card_id',$card_id);
			$query = $this->db->get();
			$field = $query->row();
			$bank_id = $field->bank_id;
			
			$bank_book = array(
			   'bb_id'         						=> '',
			   'transaction_id'                     => $insert_id,
			   'bank_id'                     		=> $bank_id,
			   'card_id'                     		=> $card_id,
			   'transaction_type'                	=> 'in',
			   'bank_name'                			=> '',
			   'cheque_no'                			=> '',
			   'cheque_date'                		=> '0000-00-00',
			   'amount'                 			=> $payment_amount,
			   'date'         						=> date('Y-m-d'),
			   'status'    	 						=> 'active',
			   'creator'                   			=> $creator,
			   'doc'        						=> date('Y-m-d'),
			   'dom'       							=> date('Y-m-d')
			);
			$this->db->insert('bank_book', $bank_book);
			return $insert_id;
		}
		
	}	
	
	public function do_payment_distributor($creator,$payment_mode,$distributor_id,$card_id, $payment_amount,$my_bank,$to_bank,$cheque_no,$cheque_date,$remarks)
	{
		if($payment_mode==1)
		{
			$payment_info = array
			(
			   'transaction_id'         			=> '',
			   'transaction_purpose'                => 'payment',
			   'transaction_mode'                 	=> 'cash',
			   'ledger_id'         					=> $distributor_id,
			   'remarks'     						=> $remarks,
			   'amount'     						=> $payment_amount,
			   'date'                   			=> date('Y-m-d'),
			   'status'        						=> 'active',
			   'creator'        					=> $creator,
			   'doc'   								=> date('Y-m-d'),
			   'dom'    							=> date('Y-m-d')
			);
			$this->db->insert('transaction_info', $payment_info);
			$insert_id = $this->db->insert_id();
			$cash_book = array(
			   'cb_id'         						=> '',
			   'transaction_id'                     => $insert_id,
			   'transaction_type'                	=> 'out',
			   'amount'                 			=> $payment_amount,
			   'date'         						=> date('Y-m-d'),
			   'status'    	 						=> 'active',
			   'creator'                   			=> $creator,
			   'doc'        						=> date('Y-m-d'),
			   'dom'       							=> date('Y-m-d')
			);
			$this->db->insert('cash_book', $cash_book);
			return $insert_id;
		}
		else if($payment_mode==2)
		{
			$bank_book = array(
			   'bb_id'         						=> '',
			   'transaction_id'                     => '',
			   'ledger_id'         					=> $distributor_id,
			   'ledger_type'         				=> 'purchase_payment',
			   'bank_id'                     		=> $my_bank,
			   'card_id'                     		=> 0,
			   'transaction_type'                	=> 'out',
			   'bank_name'                			=> $to_bank,
			   'cheque_no'                			=> $cheque_no,
			   'cheque_date'                		=> $cheque_date,
			   'amount'                 			=> $payment_amount,
			   'date'         						=> date('Y-m-d'),
			   'status'    	 						=> 'inactive',
			   'creator'                   			=> $creator,
			   'doc'        						=> date('Y-m-d'),
			   'dom'       							=> date('Y-m-d')
			);
			$this->db->insert('bank_book', $bank_book);
			return 'cheque';
		}
		
		else if($payment_mode==3)
		{
			$payment_info = array
			(
			   'transaction_id'         			=> '',
			   'transaction_purpose'                => 'payment',
			   'transaction_mode'                 	=> 'card',
			   'ledger_id'         					=> $distributor_id,
			   'remarks'     						=> $remarks,
			   'amount'     						=> $payment_amount,
			   'date'                   			=> date('Y-m-d'),
			   'status'        						=> 'active',
			   'creator'        					=> $creator,
			   'doc'   								=> date('Y-m-d'),
			   'dom'    							=> date('Y-m-d')
			);
			$this->db->insert('transaction_info', $payment_info);
			$insert_id = $this->db->insert_id();
			
			$this->db->select('bank_card_info.bank_id');
			$this->db->from('bank_card_info');
			$this->db->where('bank_card_info.card_id',$card_id);
			$query = $this->db->get();
			$field = $query->row();
			$bank_id = $field->bank_id;
			
			$bank_book = array(
			   'bb_id'         						=> '',
			   'transaction_id'                     => $insert_id,
			   'bank_id'                     		=> $bank_id,
			   'card_id'                     		=> $card_id,
			   'transaction_type'                	=> 'out',
			   'bank_name'                			=> '',
			   'cheque_no'                			=> '',
			   'cheque_date'                		=> '0000-00-00',
			   'amount'                 			=> $payment_amount,
			   'date'         						=> date('Y-m-d'),
			   'status'    	 						=> 'active',
			   'creator'                   			=> $creator,
			   'doc'        						=> date('Y-m-d'),
			   'dom'       							=> date('Y-m-d')
			);
			$this->db->insert('bank_book', $bank_book);
			return $insert_id;
		}
		
	}	
	public function do_payment_expense($creator,$payment_mode,$service_provider_id,$expense_type,$employee_id,$card_id, $payment_amount,$my_bank,$to_bank,$cheque_no,$cheque_date,$remarks)
	{
		if($payment_mode==1)
		{
			$payment_info = array
			(
			   'transaction_id'         			=> '',
			   'transaction_purpose'                => 'expense_payment',
			   'transaction_mode'                 	=> 'cash',
			   'ledger_id'         					=> $employee_id,
			   'common_id'         					=> 0,
			   'sub_id'         					=> $expense_type,
			   'remarks'     						=> $remarks,
			   'amount'     						=> $payment_amount,
			   'date'                   			=> date('Y-m-d'),
			   'status'        						=> 'active',
			   'creator'        					=> $creator,
			   'doc'   								=> date('Y-m-d'),
			   'dom'    							=> date('Y-m-d')
			);
			$this->db->insert('transaction_info', $payment_info);
			$insert_id = $this->db->insert_id();
			$cash_book = array(
			   'cb_id'         						=> '',
			   'transaction_id'                     => $insert_id,
			   'transaction_type'                	=> 'out',
			   'amount'                 			=> $payment_amount,
			   'date'         						=> date('Y-m-d'),
			   'status'    	 						=> 'active',
			   'creator'                   			=> $creator,
			   'doc'        						=> date('Y-m-d'),
			   'dom'       							=> date('Y-m-d')
			);
			$this->db->insert('cash_book', $cash_book);
			return $insert_id;
		}
		else if($payment_mode==2)
		{
			$bank_book = array(
			   'bb_id'         						=> '',
			   'transaction_id'                     => $insert_id,
			   //'ledger_id'         					=> $service_provider_id,
			   'ledger_type'         				=> 'expense_payment',
			   'bank_id'                     		=> $my_bank,
			   'card_id'                     		=> 0,
			   'transaction_type'                	=> 'out',
			   'bank_name'                			=> $to_bank,
			   'cheque_no'                			=> $cheque_no,
			   'cheque_date'                		=> $cheque_date,
			   'amount'                 			=> $payment_amount,
			   'date'         						=> date('Y-m-d'),
			   'status'    	 						=> 'inactive',
			   'creator'                   			=> $creator,
			   'doc'        						=> date('Y-m-d'),
			   'dom'       							=> date('Y-m-d')
			);
			$this->db->insert('bank_book', $bank_book);
			return 'cheque';
		}
		else if($payment_mode==3)
		{
			$payment_info = array
			(
			   'transaction_id'         			=> '',
			   'transaction_purpose'                => 'expense_payment',
			   'transaction_mode'                 	=> 'card',
			   'ledger_id'         					=> $employee_id,
			   'common_id'         					=> 0,
			   'sub_id'         					=> $expense_type,
			   'remarks'     						=> $remarks,
			   'amount'     						=> $payment_amount,
			   'date'                   			=> date('Y-m-d'),
			   'status'        						=> 'active',
			   'creator'        					=> $creator,
			   'doc'   								=> date('Y-m-d'),
			   'dom'    							=> date('Y-m-d')
			);
			$this->db->insert('transaction_info', $payment_info);
			$insert_id = $this->db->insert_id();
			
			$this->db->select('bank_card_info.bank_id');
			$this->db->from('bank_card_info');
			$this->db->where('bank_card_info.card_id',$card_id);
			$query = $this->db->get();
			$field = $query->row();
			$bank_id = $field->bank_id;
			
			$bank_book = array(
			   'bb_id'         						=> '',
			   'transaction_id'                     => $insert_id,
			   'bank_id'                     		=> $bank_id,
			   'card_id'                     		=> $card_id,
			   'transaction_type'                	=> 'out',
			   'bank_name'                			=> '',
			   'cheque_no'                			=> '',
			   'cheque_date'                		=> '0000-00-00',
			   'amount'                 			=> $payment_amount,
			   'date'         						=> date('Y-m-d'),
			   'status'    	 						=> 'active',
			   'creator'                   			=> $creator,
			   'doc'        						=> date('Y-m-d'),
			   'dom'       							=> date('Y-m-d')
			);
			$this->db->insert('bank_book', $bank_book);
			return $insert_id;
		}
		
	}	
	public function collection_payment_invoice($transaction_id,$receipt_type)
	{
		if($receipt_type==3)
		{
			$data=  $this->db
					->select('customer_info.customer_name, customer_info.customer_contact_no, customer_info.customer_address,transaction_info.transaction_mode,transaction_info.amount,transaction_info.date, transaction_info.transaction_id,transaction_info.creator, users.username')
					->from('customer_info,transaction_info,users')
					->where('transaction_info.ledger_id = customer_info.customer_id')
					->where('transaction_info.creator = users.id')
					->where('transaction_info.transaction_id', $transaction_id)
					->group_by('transaction_info.transaction_id')
					->get();

			if($data->num_rows() > 0)return $data;
			else return FALSE;

		}
		else if($receipt_type==1)
		{
			$data=  $this->db
					->select('distributor_info.distributor_name, distributor_info.distributor_contact_no, distributor_info.distributor_address,transaction_info.transaction_mode,transaction_info.amount,transaction_info.date, transaction_info.transaction_id,transaction_info.creator, users.username')
					->from('distributor_info,transaction_info,users')
					->where('transaction_info.ledger_id = distributor_info.distributor_id')
					->where('transaction_info.creator = users.id')
					->where('transaction_info.transaction_id', $transaction_id)
					->group_by('transaction_info.transaction_id')
					->get();

			if($data->num_rows() > 0)return $data;
			else return FALSE;

		}
		else if($receipt_type==2)
		{
			$data=  $this->db
					->select('employee_info.*,type_info.*,transaction_info.transaction_mode,transaction_info.amount,transaction_info.date, transaction_info.transaction_id,transaction_info.creator, users.username')
					->from('type_info,transaction_info,users')
					->where('transaction_info.sub_id = type_info.type_id')
					->join('employee_info','transaction_info.ledger_id = employee_info.employee_id','left')
					->where('transaction_info.creator = users.id')
					->where('transaction_info.transaction_id', $transaction_id)
					->group_by('transaction_info.transaction_id')
					->get();

			if($data->num_rows() > 0)return $data;
			else return FALSE;

		}
	}

	/* redundency for 2 parameter
	 * 
	 * redundency chk for bankName and Account no*/
							// table_name   ,  field name1, field name2,  element1,  element2 
	function redundancy_check($table, $field1, $field2, $element1, $element2)
	{
		$query = $this -> db -> select(' * ')
							 -> from( $table )
							 -> get();
							 
		 $element_1 = strtolower( preg_replace('/\s+/', '', $element1));
		 $element_2 = strtolower( preg_replace('/\s+/', '', $element2));
		
		 //echo $table.' '.$field1.' '.$field2.' '.$element1.' '.$element2.'</br>'.$element_1.' '.$element_2.'</br>'; 
		 	
		 foreach($query -> result() as $info):
			 $element_1_old = strtolower( preg_replace('/\s+/', '',$info -> $field1));
		     $element_2_old = strtolower( preg_replace('/\s+/', '',$info -> $field2));
			 if($element_1 == $element_1_old &&  $element_2 == $element_2_old ) return true;
		 endforeach;
		 return false;
	}
	
	 
	/*---------------------------------------------------Accounts distributor version starts here------------------------------------*/
    /* ****************************
    * Distributor information 
    * 
    * Section : Accounts
    ******************************/ 
	function distributor_info()
	{
		 $this -> db -> order_by( "distributor_name", "asc" );
		$query = $this -> db -> get('distributor_info');
		$data[''] =  'Select Distributor Name';
		foreach ($query-> result() as $field){
				//$data[$field -> distributor_id ] = $field -> distributor_name;
				$data[$field -> distributor_id] = $field -> distributor_name;	
		}
		return $data;
	}
	function customer_info()
	{
		$this -> db -> order_by("customer_name", "asc");
		$query = $this -> db -> get('customer_info');
		$data[''] =  'Select Customer';
		foreach ($query-> result() as $field)
		{
			$data[$field -> customer_id] = $field -> customer_name;
		}
		return $data;
	}
	function customer_infoo_new()
	{
		$this -> db -> where("customer_id!=1");
		$this -> db -> order_by("customer_name", "asc");
		$query = $this -> db -> get('customer_info');
		$data[''] =  'Select Customer';
		foreach ($query-> result() as $field)
		{
			$data[$field -> customer_id] = $field -> customer_name;
		}
		return $data;
	}
	function service_provider_info()
	{
		$this -> db -> order_by("service_provider_name", "asc");
		$query = $this -> db -> get('service_provider_info');
		$data[''] =  'Select Service Provider';
		foreach ($query-> result() as $field)
		{
			$data[$field -> service_provider_id] = $field -> service_provider_name;
		}
		return $data;
	}
	function owner_info()
	{
		$this -> db -> order_by("owner_name", "asc");
		$query = $this -> db -> get('owner_info');
		$data[''] =  'Select Owner';
		foreach ($query-> result() as $field)
		{
			$data[$field -> owner_id] = $field -> owner_name;
		}
		return $data;
	}
	function loan_person_info()
	{
		$this -> db -> order_by("loan_person_name", "asc");
		$query = $this -> db -> get('loan_person_info');
		$data[''] =  'Select Loan Person';
		foreach ($query-> result() as $field)
		{
			$data[$field -> lp_id] = $field -> loan_person_name;
		}
		return $data;
	}

	public function purchase_total_amount($start,$distributor_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_purchase');
		$this->db->from('transaction_info');			
		$this->db->where('(transaction_info.transaction_purpose="purchase" OR transaction_info.transaction_purpose="purchase_payment_deleted")');
		if($distributor_id!=''){$this->db->where('transaction_info.ledger_id',$distributor_id);}
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}

	public function balance_amount_distributor($distributor_id)
	{
		$this->db->select('distributor_info.int_balance');
		$this->db->from('distributor_info');			
		if($distributor_id!=''){$this->db->where('distributor_info.distributor_id',$distributor_id);}
		$query_data = $this->db->get();
		return $query_data;
	}

	public function purchase_payment_amount($start,$distributor_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_purchase_payment');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "payment"');
		if($distributor_id!=''){$this->db->where('transaction_info.ledger_id',$distributor_id);}
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function all_purchase($start,$end,$distributor_id)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.remarks,transaction_info.transaction_mode,transaction_info.date,distributor_info.distributor_name');
		$this->db->from('transaction_info,distributor_info');
		$this->db->where('transaction_info.ledger_id =distributor_info.distributor_id'); 
		$this->db->where('(transaction_info.transaction_purpose="purchase" OR transaction_info.transaction_purpose="purchase_payment_deleted")');		
		if($distributor_id!=''){$this->db->where('transaction_info.ledger_id',$distributor_id);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data;
		}
		else{
			return false;
		}
	}
	public function all_payment($start,$end,$distributor_id)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.remarks,transaction_info.transaction_mode,transaction_info.date,distributor_info.distributor_name');
		$this->db->from('transaction_info,distributor_info');
		$this->db->where('transaction_info.ledger_id =distributor_info.distributor_id'); 
		$this->db->where('(transaction_info.transaction_purpose = "payment" OR transaction_info.transaction_purpose="purchase_return")');
		if($distributor_id!=''){$this->db->where('transaction_info.ledger_id',$distributor_id);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data;
		}
		else{
			return false;
		}
	}
	public function all_delete_payment($start,$end,$distributor_id)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.remarks,transaction_info.transaction_mode,transaction_info.date,distributor_info.distributor_name');
		$this->db->from('transaction_info,distributor_info');
		$this->db->where('transaction_info.ledger_id =distributor_info.distributor_id'); 
		$this->db->where('transaction_info.transaction_purpose = "purchase_payment_deleted"');		
		if($distributor_id!=''){$this->db->where('transaction_info.ledger_id',$distributor_id);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data;
		}
		else{
			return false;
		}
	}
	
	public function sale_total_amount($start,$customer_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_sale');
		$this->db->from('transaction_info');			
		$this->db->where('(transaction_info.transaction_purpose = "sale" OR transaction_info.transaction_purpose = "sale_collection_deleted" OR transaction_info.transaction_purpose = "delivery_charge" OR transaction_info.transaction_purpose = "sale_return")');
		if($customer_id!=''){$this->db->where('transaction_info.ledger_id',$customer_id);}
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function sale_collection_total_amount($start,$customer_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_sale_collection');
		$this->db->from('transaction_info');			
		$this->db->where('((transaction_info.transaction_purpose="credit_collection" OR transaction_info.transaction_purpose="collection" OR transaction_info.transaction_purpose="cash_return"))');
		if($customer_id!=''){$this->db->where('transaction_info.ledger_id',$customer_id);}
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function sale_return_total_amount($start,$customer_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_sale_return');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose="sale_return"');
		if($customer_id!=''){$this->db->where('transaction_info.ledger_id',$customer_id);}
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function balance_amount_customer($customer_id)
	{
		$this->db->select('customer_info.int_balance');
		$this->db->from('customer_info');			
		if($customer_id!=''){$this->db->where('customer_info.customer_id',$customer_id);}
		$query_data = $this->db->get();
		return $query_data;
	}
	public function all_sale($start,$end,$customer_id)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.common_id,transaction_info.remarks,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,customer_info.customer_name');
		$this->db->from('transaction_info,customer_info');
		$this->db->where('transaction_info.ledger_id =customer_info.customer_id'); 
		$this->db->where('(transaction_info.transaction_purpose = "sale" OR transaction_info.transaction_purpose = "sale_collection_deleted" OR transaction_info.transaction_purpose = "delivery_charge" OR transaction_info.transaction_purpose = "sale_return")');		
		if($customer_id!=''){$this->db->where('transaction_info.ledger_id',$customer_id);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data;
		}
		else{
			return false;
		}
	}
	public function all_collection($start,$end,$customer_id)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.remarks,transaction_info.transaction_mode,transaction_info.date,customer_info.customer_name');
		$this->db->from('transaction_info,customer_info');
		$this->db->where('transaction_info.ledger_id =customer_info.customer_id'); 
		$this->db->where('((transaction_info.transaction_purpose="credit_collection" OR transaction_info.transaction_purpose="collection" OR transaction_info.transaction_purpose="cash_return"))');		
		if($customer_id!=''){$this->db->where('transaction_info.ledger_id',$customer_id);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data;
		}
		else{
			return false;
		}
	}
	public function all_sale_return($start,$end,$customer_id)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.remarks,transaction_info.transaction_mode,transaction_info.date,customer_info.customer_name');
		$this->db->from('transaction_info,customer_info');
		$this->db->where('transaction_info.ledger_id =customer_info.customer_id'); 
		$this->db->where('transaction_info.transaction_purpose="sale_return"');		
		if($customer_id!=''){$this->db->where('transaction_info.ledger_id',$customer_id);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data;
		}
		else{
			return false;
		}
	}
	
	public function expense_total_amount($start,$type_id,$employee_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_expense');
		$this->db->from('transaction_info');			
		$this->db->where('(transaction_info.transaction_purpose = "expense" OR transaction_info.transaction_purpose = "expense_payment_deleted")');
		if($type_id!=''){$this->db->where('transaction_info.sub_id',$type_id);}
		if($employee_id!=''){$this->db->where('transaction_info.ledger_id',$employee_id);}
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function expense_payment_total_amount($start,$type_id,$employee_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_expense_payment');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "expense_payment"');
		if($type_id!=''){$this->db->where('transaction_info.sub_id',$type_id);}
		if($employee_id!=''){$this->db->where('transaction_info.ledger_id',$employee_id);}
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	
	public function all_expense($start,$end,$type_id,$employee_id)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.remarks,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,employee_info.*,type_info.*');
		$this->db->from('transaction_info,type_info');
		$this->db->join('employee_info','transaction_info.ledger_id = employee_info.employee_id','left');
		$this->db->where('transaction_info.sub_id =type_info.type_id'); 
		$this->db->where('(transaction_info.transaction_purpose = "expense" OR transaction_info.transaction_purpose = "expense_payment_deleted")');		
		if($type_id!=''){$this->db->where('transaction_info.sub_id',$type_id);}
		if($employee_id!=''){$this->db->where('transaction_info.ledger_id',$employee_id);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data;
		}
		else{
			return false;
		}
	}
	public function all_expense_payment($start,$end,$type_id,$employee_id)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.remarks,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,employee_info.*,type_info.*');
		$this->db->from('transaction_info,type_info');
		$this->db->join('employee_info','transaction_info.ledger_id = employee_info.employee_id','left');
		$this->db->where('transaction_info.sub_id =type_info.type_id'); 
		$this->db->where('transaction_info.transaction_purpose = "expense_payment"');		
		if($type_id!=''){$this->db->where('transaction_info.sub_id',$type_id);}
		if($employee_id!=''){$this->db->where('transaction_info.ledger_id',$employee_id);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data;
		}
		else{
			return false;
		}
	}
	public function to_bank_total_amount($start,$transfer_type)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_to_bank');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "to_bank"');
		if($transfer_type!=''){$this->db->where('transaction_info.transaction_purpose',$transfer_type);}
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function from_bank_total_amount($start,$transfer_type)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_from_bank');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "from_bank"');
		if($transfer_type!=''){$this->db->where('transaction_info.transaction_purpose',$transfer_type);}
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function all_to_bank($start,$end,$transfer_type)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,bank_info.bank_name');
		$this->db->from('transaction_info,bank_info,bank_book');
		$this->db->where('transaction_info.transaction_id =bank_book.transaction_id'); 
		$this->db->where('bank_info.bank_id = bank_book.bank_id'); 
		$this->db->where('transaction_info.transaction_purpose = "to_bank"');		
		if($transfer_type!=''){$this->db->where('transaction_info.transaction_purpose',$transfer_type);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data;
		}
		else{
			return false;
		}
	}
	public function all_from_bank($start,$end,$transfer_type)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,bank_info.bank_name');
		$this->db->from('transaction_info,bank_info,bank_book');
		$this->db->where('transaction_info.transaction_id =bank_book.transaction_id'); 
		$this->db->where('bank_info.bank_id = bank_book.bank_id'); 
		$this->db->where('transaction_info.transaction_purpose = "from_bank"');		
		if($transfer_type!=''){$this->db->where('transaction_info.transaction_purpose',$transfer_type);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data;
		}
		else{
			return false;
		}
	}
	public function to_owner_total_amount($start,$owner_transfer_type)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_to_owner');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "to_owner"');
		if($owner_transfer_type!=''){$this->db->where('transaction_info.transaction_purpose',$owner_transfer_type);}
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function from_owner_total_amount($start,$owner_transfer_type)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_from_owner');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "from_owner"');
		if($owner_transfer_type!=''){$this->db->where('transaction_info.transaction_purpose',$owner_transfer_type);}
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function all_to_owner($start,$end,$owner_transfer_type)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,owner_info.owner_name');
		$this->db->from('transaction_info,owner_info,owner_book');
		$this->db->where('transaction_info.ledger_id =owner_info.owner_id'); 
		$this->db->where('transaction_info.transaction_id =owner_book.transaction_id'); 
		$this->db->where('transaction_info.transaction_purpose = "to_owner"');		
		if($owner_transfer_type!=''){$this->db->where('transaction_info.transaction_purpose',$owner_transfer_type);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data;
		}
		else{
			return false;
		}
	}
	public function all_from_owner($start,$end,$owner_transfer_type)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,owner_info.owner_name');
		$this->db->from('transaction_info,owner_info,owner_book');
		$this->db->where('transaction_info.ledger_id =owner_info.owner_id'); 
		$this->db->where('transaction_info.transaction_id =owner_book.transaction_id'); 
		$this->db->where('transaction_info.transaction_purpose = "from_owner"');		
		if($owner_transfer_type!=''){$this->db->where('transaction_info.transaction_purpose',$owner_transfer_type);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data;
		}
		else{
			return false;
		}
	}
	public function purchase_total_amount_print($start,$distributor_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_purchase');
		$this->db->from('transaction_info');			
		$this->db->where('(transaction_info.transaction_purpose="purchase" OR transaction_info.transaction_purpose="purchase_payment_deleted")');
		$this->db->where('transaction_info.ledger_id',$distributor_id);
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function purchase_payment_amount_print($start,$distributor_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_purchase_payment');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "payment"');
		$this->db->where('transaction_info.ledger_id',$distributor_id);
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function balance_amount_distributor_print($distributor_id)
	{
		$this->db->select('distributor_info.int_balance');
		$this->db->from('distributor_info');			
		$this->db->where('distributor_info.distributor_id',$distributor_id);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function all_purchase_print($start,$end,$distributor_id)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.remarks,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,distributor_info.distributor_name');
		$this->db->from('transaction_info,distributor_info');
		$this->db->where('transaction_info.ledger_id =distributor_info.distributor_id'); 
		$this->db->where('(transaction_info.transaction_purpose="purchase" OR transaction_info.transaction_purpose="purchase_payment_deleted")');		
		$this->db->where('transaction_info.ledger_id',$distributor_id);
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data->result_array();
		}
		else{
			return false;
		}
	}
	public function all_payment_print($start,$end,$distributor_id)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.amount,transaction_info.remarks,transaction_info.transaction_mode,transaction_info.date,distributor_info.distributor_name');
		$this->db->from('transaction_info,distributor_info');
		$this->db->where('transaction_info.ledger_id =distributor_info.distributor_id'); 
		$this->db->where('(transaction_info.transaction_purpose = "payment" OR transaction_info.transaction_purpose = "purchase_return")');
		$this->db->where('transaction_info.ledger_id',$distributor_id);
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data->result_array();
		}
		else{
			return false;
		}
	}
	
	public function sale_total_amount_print($start,$customer_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_sale');
		$this->db->from('transaction_info');			
		$this->db->where('(transaction_info.transaction_purpose = "sale" OR transaction_info.transaction_purpose = "sale_collection_deleted" OR transaction_info.transaction_purpose = "delivery_charge" OR transaction_info.transaction_purpose = "sale_return")');
		$this->db->where('transaction_info.ledger_id',$customer_id);
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function sale_collection_total_amount_print($start,$customer_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_sale_collection');
		$this->db->from('transaction_info');			
		$this->db->where('(transaction_info.transaction_purpose="credit_collection" OR transaction_info.transaction_purpose="collection" OR transaction_info.transaction_purpose="cash_return")');
		$this->db->where('transaction_info.ledger_id',$customer_id);
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function sale_return_total_amount_print($start,$customer_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_sale_return');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose="sale_return"');
		$this->db->where('transaction_info.ledger_id',$customer_id);
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function balance_amount_customer_print($customer_id)
	{
		$this->db->select('customer_info.int_balance');
		$this->db->from('customer_info');			
		$this->db->where('customer_info.customer_id',$customer_id);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function all_sale_print($start,$end,$customer_id)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.remarks,transaction_info.common_id,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,customer_info.customer_name');
		$this->db->from('transaction_info,customer_info');
		$this->db->where('transaction_info.ledger_id =customer_info.customer_id'); 
		$this->db->where('(transaction_info.transaction_purpose = "sale" OR transaction_info.transaction_purpose = "sale_collection_deleted" OR transaction_info.transaction_purpose = "delivery_charge" OR transaction_info.transaction_purpose = "sale_return")');		
		$this->db->where('transaction_info.ledger_id',$customer_id);
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data->result_array();
		}
		else{
			return false;
		}
		
	}
	public function all_collection_print($start,$end,$customer_id)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.remarks,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,customer_info.customer_name');
		$this->db->from('transaction_info,customer_info');
		$this->db->where('transaction_info.ledger_id =customer_info.customer_id'); 
		$this->db->where('(transaction_info.transaction_purpose="credit_collection" OR transaction_info.transaction_purpose="collection" OR transaction_info.transaction_purpose="cash_return")');		
		$this->db->where('transaction_info.ledger_id',$customer_id);
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data->result_array();
		}
		else{
			return false;
		}
	}
	public function all_sale_return_print($start,$end,$customer_id)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.remarks,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,customer_info.customer_name');
		$this->db->from('transaction_info,customer_info');
		$this->db->where('transaction_info.ledger_id =customer_info.customer_id'); 
		$this->db->where('transaction_info.transaction_purpose="sale_return"');		
		$this->db->where('transaction_info.ledger_id',$customer_id);
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data->result_array();
		}
		else{
			return false;
		}
	}
	
	public function expense_total_amount_print($start,$type_id,$employee_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_expense');
		$this->db->from('transaction_info');			
		$this->db->where('(transaction_info.transaction_purpose = "expense" OR transaction_info.transaction_purpose = "expense_payment_deleted")');
		if($type_id!='' && $type_id!='null'){$this->db->where('transaction_info.sub_id',$type_id);}
		if($employee_id!='' && $employee_id!='null'){$this->db->where('transaction_info.ledger_id',$employee_id);}
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function expense_payment_total_amount_print($start,$type_id,$employee_id)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_expense_payment');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "expense_payment"');
		if($type_id!='' && $type_id!='null'){$this->db->where('transaction_info.sub_id',$type_id);}
		if($employee_id!='' && $employee_id!='null'){$this->db->where('transaction_info.ledger_id',$employee_id);}
		$this->db->where('transaction_info.date <',$start);
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	
	public function all_expense_print($start,$end,$type_id,$employee_id)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.remarks,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,employee_info.*,type_info.*');
		$this->db->from('transaction_info,type_info');
		$this->db->join('employee_info','transaction_info.ledger_id = employee_info.employee_id','left');
		$this->db->where('transaction_info.sub_id =type_info.type_id'); 
		$this->db->where('(transaction_info.transaction_purpose = "expense" OR transaction_info.transaction_purpose = "expense_payment_deleted")');		
		if($type_id!='' && $type_id!='null'){$this->db->where('transaction_info.sub_id',$type_id);}
		if($employee_id!='' && $employee_id!='null'){$this->db->where('transaction_info.ledger_id',$employee_id);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data->result_array();
		}
		else{
			return false;
		}
	}
	public function all_expense_payment_print($start,$end,$type_id,$employee_id)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.remarks,transaction_info.remarks,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,employee_info.*,type_info.*');
		$this->db->from('transaction_info,type_info');
		$this->db->join('employee_info','transaction_info.ledger_id = employee_info.employee_id','left');
		$this->db->where('transaction_info.sub_id =type_info.type_id'); 
		$this->db->where('transaction_info.transaction_purpose = "expense_payment"');		
		if($type_id!='' && $type_id!='null'){$this->db->where('transaction_info.sub_id',$type_id);}
		if($employee_id!='' && $employee_id!='null'){$this->db->where('transaction_info.ledger_id',$employee_id);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data->result_array();
		}
		else{
			return false;
		}
	}
	public function to_bank_total_amount_print($start,$transfer_type)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_to_bank');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "to_bank"');
		$this->db->where('transaction_info.transaction_purpose',$transfer_type);
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function from_bank_total_amount_print($start,$transfer_type)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_from_bank');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "from_bank"');
		$this->db->where('transaction_info.transaction_purpose',$transfer_type);
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function all_to_bank_print($start,$end,$transfer_type)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.remarks,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,bank_info.bank_name');
		$this->db->from('transaction_info,bank_info,bank_book');
		$this->db->where('transaction_info.transaction_id =bank_book.transaction_id'); 
		$this->db->where('bank_info.bank_id = bank_book.bank_id'); 
		$this->db->where('transaction_info.transaction_purpose = "to_bank"');		
		if($transfer_type!='null'){$this->db->where('transaction_info.transaction_purpose',$transfer_type);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data->result_array();
		}
		else{
			return false;
		}
	}
	public function all_from_bank_print($start,$end,$transfer_type)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.remarks,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,bank_info.bank_name');
		$this->db->from('transaction_info,bank_info,bank_book');
		$this->db->where('transaction_info.transaction_id =bank_book.transaction_id'); 
		$this->db->where('bank_info.bank_id = bank_book.bank_id'); 
		$this->db->where('transaction_info.transaction_purpose = "from_bank"');		
		if($transfer_type!='null'){$this->db->where('transaction_info.transaction_purpose',$transfer_type);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data->result_array();
		}
		else{
			return false;
		}
	}
	public function to_owner_total_amount_print($start,$owner_transfer_type)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_to_owner');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "to_owner"');
		if($owner_transfer_type!='null'){$this->db->where('transaction_info.transaction_purpose',$owner_transfer_type);}
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function from_owner_total_amount_print($start,$owner_transfer_type)
	{
		$this->db->select('SUM(transaction_info.amount) as total_amount_from_owner');
		$this->db->from('transaction_info');			
		$this->db->where('transaction_info.transaction_purpose = "from_owner"');
		if($owner_transfer_type!='null'){$this->db->where('transaction_info.transaction_purpose',$owner_transfer_type);}
		$this->db->where('transaction_info.date <',$start);
		$query_data = $this->db->get();
		return $query_data;
	}
	public function all_to_owner_print($start,$end,$owner_transfer_type)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.remarks,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,owner_info.owner_name');
		$this->db->from('transaction_info,owner_info,owner_book');
		$this->db->where('transaction_info.ledger_id =owner_info.owner_id'); 
		$this->db->where('transaction_info.transaction_id =owner_book.transaction_id'); 
		$this->db->where('transaction_info.transaction_purpose = "to_owner"');		
		if($owner_transfer_type!='null'){$this->db->where('transaction_info.transaction_purpose',$owner_transfer_type);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data->result_array();
		}
		else{
			return false;
		}
	}
	public function all_from_owner_print($start,$end,$owner_transfer_type)
	{
		$this->db->select('transaction_info.transaction_id,transaction_info.transaction_purpose,transaction_info.remarks,transaction_info.amount,transaction_info.transaction_mode,transaction_info.date,owner_info.owner_name');
		$this->db->from('transaction_info,owner_info,owner_book');
		$this->db->where('transaction_info.ledger_id =owner_info.owner_id'); 
		$this->db->where('transaction_info.transaction_id =owner_book.transaction_id'); 
		$this->db->where('transaction_info.transaction_purpose = "from_owner"');		
		if($owner_transfer_type!='null'){$this->db->where('transaction_info.transaction_purpose',$owner_transfer_type);}
		$this->db->where('transaction_info.date >= "'.$start.'"');
		$this->db->where('transaction_info.date <= "'.$end.'"');
		$this->db->order_by('transaction_info.date','asc');
		$this->db->group_by('transaction_info.transaction_id');
		$query_data = $this->db->get();
		if($query_data->num_rows() > 0)
		{
			return $query_data->result_array();
		}
		else
		{
			return false;
		}
	}
	
	function transaction_with_employees($specific,$employee_id)
	{
		if($specific)
		{
			return $this -> db -> query(" 
										SELECT 
										user_full_name AS employee_name,users.id,  
										SUM( CASE WHEN mode = 'Salary' THEN ((salary_amount + extra_payment) - reduced_amount) END )  AS grand_total,
										SUM( CASE WHEN mode = 'Paid' THEN salary_amount END ) AS total_paid,
										SUM( CASE WHEN mode = 'Salary' THEN ((salary_amount + extra_payment) - reduced_amount) END ) - 
										SUM( CASE WHEN mode = 'Paid' THEN salary_amount END ) AS total_due


										FROM users,employee_salary_log
										WHERE users.id = employee_salary_log.user_id
										AND users.shop_id = '". $this->tank_auth->get_shop_id()."'
										AND salary_status = 1
										AND users.id = '".$employee_id."'
									");
		}
		else
		{
			return $this -> db -> query(" 
										SELECT 
										user_full_name AS employee_name,users.id,  

										SUM( CASE WHEN mode = 'Salary' THEN ((salary_amount + extra_payment) - reduced_amount) END )  AS grand_total,
										SUM( CASE WHEN mode = 'Paid' THEN salary_amount END ) AS total_paid,
										SUM( CASE WHEN mode = 'Salary' THEN ((salary_amount + extra_payment) - reduced_amount) END ) - 
										SUM( CASE WHEN mode = 'Paid' THEN salary_amount END ) AS total_due

										FROM users,employee_salary_log
										WHERE users.id = employee_salary_log.user_id
										AND users.shop_id = '". $this->tank_auth->get_shop_id()."'
										AND salary_status = 1
									");
		}
	} 
}
