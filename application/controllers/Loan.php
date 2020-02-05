<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Loan extends MY_Controller {

	public function index()
	{	
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['sale_status'] = '';
		$data['alarming_level'] = FALSE;
		$data['status'] = '';
		$data['user_name'] = $this->tank_auth->get_username();
		$data['loanm']=Loanm::all();
		$data['customer']=Customerm::all();
		$this->__renderview('Setup/loan',$data);
	}

	public function create()
	{
		$customer_id=$this->input->post('customer_id');
		$amount=$this->input->post('amount');
		$loanm=new Loanm();
		$loanm->customer_id=$customer_id;
		$loanm->amount=$amount;
		$loanm->save();

		$Transactionm=new Transactionm();
		$Transactionm->transaction_purpose="loan";
		$Transactionm->transaction_mode='';
		$Transactionm->ledger_id=$customer_id;
		$Transactionm->common_id='';
		$Transactionm->sub_id='';
		$Transactionm->remarks='';
		$Transactionm->amount=$amount;
		$Transactionm->date=date("Y-m-d");
		$Transactionm->status="active";
		$Transactionm->creator=12;
		$Transactionm->save();
		
		$Cashbook=new Cashbook();
		$Cashbook->transaction_id=$Transactionm->transaction_id;
		$Cashbook->transaction_type='out';
		$Cashbook->amount=$amount;
		$Cashbook->date=date("Y-m-d");
		$Cashbook->status="active";
		$Cashbook->creator=12;
		$Cashbook->save();
		redirect('loan','refresh');
	}

}

/* End of file Loan.php */
/* Location: ./application/controllers/Loan.php */