<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function create($data='')
	{
		$this->db->insert('expense_info',$data);
   	 	$insert_ids=$this->db->insert_id();
   	 	$payment_mode = $this->input->post('payment_mode');
		$payment_amount = $data['total_paid'];
		$card_id = $this->input->post('card_id');
		$my_bank = $this->input->post('my_bank');
		$to_bank = $this->input->post('to_bank');
		$cheque_no = $this->input->post('cheque_no');
		$cheque_date = $this->input->post('cheque_date');
		if($payment_mode==1)
		{
			$payment_info = array
			(
			   'transaction_purpose'                => 'expense_payment',
			   'transaction_mode'                 	=> 'cash',
			   'ledger_id'         					=> 1,
			   'common_id'         					=> $insert_ids,
			   'sub_id'         					=> $data['expense_type'],
			   'amount'     						=> $payment_amount,
			   'date'                   			=> date("Y-m-d"),
			   'status'        						=> 'active',
			   'creator'        					=> $data['expense_creator'],
			);
			$this->db->insert('transaction_info', $payment_info);

			$payment_info = array
			(
			   'transaction_purpose'                => 'expense',
			   'transaction_mode'                 	=> 'cash',
			   'ledger_id'         					=> 1,
			   'common_id'         					=> $insert_ids,
			   'sub_id'         					=> $data['expense_type'],
			   'amount'     						=> $data['expense_amount'],
			   'date'                   			=> date("Y-m-d"),
			   'status'        						=> 'active',
			   'creator'        					=> $data['expense_creator'],
			);
			$this->db->insert('transaction_info', $payment_info);

			$insert_id = $this->db->insert_id();
			$cash_book = array(
			   'cb_id'         						=> '',
			   'transaction_id'                     => $insert_id,
			   'transaction_type'                	=> 'out',
			   'amount'                 			=> $payment_amount,
			   'date'         						=> date("Y-m-d"),
			   'status'    	 						=> 'active',
			   'creator'                   			=> $data['expense_creator'],
			);
			$this->db->insert('cash_book', $cash_book);
		}

		else if($payment_mode==2)
		{
			$payment_info = array
			(
			   'transaction_purpose'                => 'expense_payment',
			   'transaction_mode'                 	=> 'cheque',
			   'ledger_id'         					=> 1,
			   'common_id'         					=> $insert_ids,
			    'sub_id'         					=> $data['expense_type'],
			   'amount'     						=> $payment_amount,
			   'date'                   			=> date("Y-m-d"),
			   'status'        						=> 'active',
			   'creator'        					=> $data['expense_creator'],
			);
			$this->db->insert('transaction_info', $payment_info);
			$insert_id = $this->db->insert_id();


			$payment_info = array
			(
			   'transaction_purpose'                => 'expense',
			   'transaction_mode'                 	=> 'card',
			   'ledger_id'         					=> 1,
			   'common_id'         					=> $insert_ids,
			   'sub_id'         					=> $data['expense_type'],
			   'amount'     						=> $data['expense_amount'],
			   'date'                   			=> date("Y-m-d"),
			   'status'        						=> 'active',
			   'creator'        					=> $data['expense_creator'],
			);
			$this->db->insert('transaction_info', $payment_info);


			$bank_book = array(
			   'bb_id'         						=> '',
			   'transaction_id'                     => $insert_id,
			   'ledger_id'         					=> 1,
			   'ledger_type'         				=> 'expense_payment',
			   'bank_id'                     		=> $my_bank,
			   'card_id'                     		=> 0,
			   'transaction_type'                	=> 'out',
			   'bank_name'                			=> $to_bank,
			   'cheque_no'                			=> $cheque_no,
			   'cheque_date'                		=> $cheque_date,
			   'amount'                 			=> $payment_amount,
			   'date'         						=> date("Y-m-d"),
			   'status'    	 						=> 'inactive',
			   'creator'                   			=> $data['expense_creator'],
			);
			$this->db->insert('bank_book', $bank_book);
		}
		
		else if($payment_mode==3)
		{
			$payment_info = array
			(
			   'transaction_purpose'                => 'expense_payment',
			   'transaction_mode'                 	=> 'card',
			   'ledger_id'         					=> 1,
			   'common_id'         					=> $insert_ids,
			   'sub_id'         					=> $data['expense_type'],
			   'amount'     						=> $payment_amount,
			   'date'                   			=> $bd_date,
			   'status'        						=> 'active',
			   'creator'        					=> $creator,
			   'doc'   								=> $bd_date,
			   'dom'    							=> $bd_date
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
			   'date'         						=> date("Y-m-d"),
			   'status'    	 						=> 'active',
			   'creator'                   			=> $data['expense_creator'],
			);
			$this->db->insert('bank_book', $bank_book);

			$payment_info = array
			(
			   'transaction_purpose'                => 'expense',
			   'transaction_mode'                 	=> 'card',
			   'ledger_id'         					=> 1,
			   'common_id'         					=> $insert_ids,
			   'sub_id'         					=> $data['expense_type'],
			   'amount'     						=> $data['expense_amount'],
			   'date'                   			=> date("Y-m-d"),
			   'status'        						=> 'active',
			   'creator'        					=> $data['expense_creator'],
			);
			$this->db->insert('transaction_info', $payment_info);
			
		}
   	 	return $insert_ids;
	}

	public function all()
	{
		$this->db->order_by('expense_id', 'desc');
		return $this->db->get('expense_info')->result();
	}

	public function destroy($id)
	{
		$this->db->where('expense_id', $id);
		return $this->db->delete('expense_info');
	}

	public function find($expense_id='')
	{
		$this->db->where('expense_id', $expense_id);
		return $this->db->get('expense_info')->row();
	}

	public function update($expense_id='',$data='')
	{
		$this->db->where('expense_id', $expense_id);
		return $this->db->update('expense_info', $data);
	}

	// INCOME SYSTEM curd
	public function incomecreate($data='')
	{
		$this->db->insert('income_info',$data);
   	 	$insert_ids=$this->db->insert_id();
   	 	$payment_mode = $this->input->post('payment_mode');
		$payment_amount = $data['total_paid'];
		$card_id = $this->input->post('card_id');
		$my_bank = $this->input->post('my_bank');
		$to_bank = $this->input->post('to_bank');
		$cheque_no = $this->input->post('cheque_no');
		$cheque_date = $this->input->post('cheque_date');
		if($payment_mode==1)
		{
			$payment_info = array
			(
			   'transaction_purpose'                => 'income_get',
			   'transaction_mode'                 	=> 'cash',
			   'ledger_id'         					=> 1,
			   'common_id'         					=> $insert_ids,
			   'sub_id'         					=> $data['income_type'],
			   'amount'     						=> $payment_amount,
			   'date'                   			=> date("Y-m-d"),
			   'status'        						=> 'active',
			   'creator'        					=> $data['income_creator'],
			);
			$this->db->insert('transaction_info', $payment_info);

			$payment_info = array
			(
			   'transaction_purpose'                => 'income',
			   'transaction_mode'                 	=> 'cash',
			   'ledger_id'         					=> 1,
			   'common_id'         					=> $insert_ids,
			   'sub_id'         					=> $data['income_type'],
			   'amount'     						=> $data['income_amount'],
			   'date'                   			=> date("Y-m-d"),
			   'status'        						=> 'active',
			   'creator'        					=> $data['income_creator'],
			);
			$this->db->insert('transaction_info', $payment_info);

			$insert_id = $this->db->insert_id();
			$cash_book = array(
			   'cb_id'         						=> '',
			   'transaction_id'                     => $insert_id,
			   'transaction_type'                	=> 'in',
			   'amount'                 			=> $payment_amount,
			   'date'         						=> date("Y-m-d"),
			   'status'    	 						=> 'active',
			   'creator'                   			=> $data['income_creator'],
			);
			$this->db->insert('cash_book', $cash_book);
		}
		else if($payment_mode==2)
		{
			$payment_info = array
			(
			   'transaction_purpose'                => 'income_get',
			   'transaction_mode'                 	=> 'cheque',
			   'ledger_id'         					=> 1,
			   'common_id'         					=> $insert_ids,
			    'sub_id'         					=> $data['income_type'],
			   'amount'     						=> $payment_amount,
			   'date'                   			=> date("Y-m-d"),
			   'status'        						=> 'active',
			   'creator'        					=> $data['income_creator'],
			);
			$this->db->insert('transaction_info', $payment_info);
			$insert_id = $this->db->insert_id();


			$payment_info = array
			(
			   'transaction_purpose'                => 'income',
			   'transaction_mode'                 	=> 'card',
			   'ledger_id'         					=> 1,
			   'common_id'         					=> $insert_ids,
			   'sub_id'         					=> $data['income_type'],
			   'amount'     						=> $data['income_amount'],
			   'date'                   			=> date("Y-m-d"),
			   'status'        						=> 'active',
			   'creator'        					=> $data['income_creator'],
			);
			$this->db->insert('transaction_info', $payment_info);


			$bank_book = array(
			   'bb_id'         						=> '',
			   'transaction_id'                     => $insert_id,
			   'ledger_id'         					=> 1,
			   'ledger_type'         				=> 'income_get',
			   'bank_id'                     		=> $my_bank,
			   'card_id'                     		=> 0,
			   'transaction_type'                	=> 'in',
			   'bank_name'                			=> $to_bank,
			   'cheque_no'                			=> $cheque_no,
			   'cheque_date'                		=> $cheque_date,
			   'amount'                 			=> $payment_amount,
			   'date'         						=> date("Y-m-d"),
			   'status'    	 						=> 'inactive',
			   'creator'                   			=> $data['income_creator'],
			);
			$this->db->insert('bank_book', $bank_book);
		}
		else if($payment_mode==3)
		{
			$payment_info = array
			(
			   'transaction_purpose'                => 'income_get',
			   'transaction_mode'                 	=> 'card',
			   'ledger_id'         					=> 1,
			   'common_id'         					=> $insert_ids,
			   'sub_id'         					=> $data['income_type'],
			   'amount'     						=> $payment_amount,
			   'date'                   			=> $bd_date,
			   'status'        						=> 'active',
			   'creator'        					=> $creator,
			   'doc'   								=> $bd_date,
			   'dom'    							=> $bd_date
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
			   'transaction_type'                	=> 'in',
			   'bank_name'                			=> '',
			   'cheque_no'                			=> '',
			   'cheque_date'                		=> '0000-00-00',
			   'amount'                 			=> $payment_amount,
			   'date'         						=> date("Y-m-d"),
			   'status'    	 						=> 'active',
			   'creator'                   			=> $data['income_creator'],
			);
			$this->db->insert('bank_book', $bank_book);

			$payment_info = array
			(
			   'transaction_purpose'                => 'income',
			   'transaction_mode'                 	=> 'card',
			   'ledger_id'         					=> 1,
			   'common_id'         					=> $insert_ids,
			   'sub_id'         					=> $data['income_type'],
			   'amount'     						=> $data['income_amount'],
			   'date'                   			=> date("Y-m-d"),
			   'status'        						=> 'active',
			   'creator'        					=> $data['income_creator'],
			);
			$this->db->insert('transaction_info', $payment_info);
			
		}
   	 	return $insert_ids;
	}

	public function incomeall()
	{
		$this->db->order_by('income_id', 'desc');
		return $this->db->get('income_info')->result();
	}

	public function incomedestroy($id)
	{
		$this->db->where('income_id', $id);
		return $this->db->delete('income_info');
	}

	public function incomefind($income_id='')
	{
		$this->db->where('income_id', $income_id);
		return $this->db->get('income_info')->row();
	}

	public function incomeupdate($income_id='',$data='')
	{
		$this->db->where('income_id', $income_id);
		return $this->db->update('income_info', $data);
	}


	//expance type_info CURD
	public function typecreate($data='')
	{
		$this->db->insert('type_info',$data);
   	 	return $this->db->insert_id();
	}

	public function typeall()
	{
		$this->db->order_by('type_id', 'desc');
		return $this->db->get('type_info')->result();
	}

	public function typedestroy($id)
	{
		$this->db->where('type_id', $id);
		return $this->db->delete('type_info');
	}

	public function typefind($type_id='')
	{
		$this->db->where('type_id', $type_id);
		return $this->db->get('type_info')->row();
	}

	public function typeupdate($type_id='',$data='')
	{
		$this->db->where('type_id', $type_id);
		return $this->db->update('type_info', $data);
	}



	// service provider CURD
	public function SPcreate($data='')
	{
		$this->db->insert('service_provider_info',$data);
   	 	return $this->db->get('service_provider_info')->result();
	}

	public function SPall()
	{
		$this->db->order_by('service_provider_id', 'desc');
		return $this->db->get('service_provider_info')->result();
	}

	public function SPdestroy($id)
	{
		$this->db->where('service_provider_id', $id);
		return $this->db->delete('service_provider_info');
	}

	public function SPfind($service_provider_id='')
	{
		$this->db->where('service_provider_id', $service_provider_id);
		return $this->db->get('service_provider_info')->row();
	}

	public function SPupdate($service_provider_id='',$data='')
	{
		$this->db->where('service_provider_id', $service_provider_id);
		return $this->db->update('service_provider_info', $data);
	}
}

/* End of file Expense_model.php */
/* Location: ./application/models/Expense_model.php */