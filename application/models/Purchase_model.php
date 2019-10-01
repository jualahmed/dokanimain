<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Purchase_model extends CI_model
{
    private $userId;
	private $bdDate;
	public function __construct()
	{
		parent::__construct();
		$this->userId = $this->tank_auth->get_user_id();
		$this->bdDate = date ('Y-m-d');
	}

	public function create(array $data,$ddd)
	{	
		$dd=$ddd;
		$insert = $this->db->insert('purchase_receipt_info',$data);
		$ref_id= $this->db->insert_id();
		/* transport_cost is an expance */
		if($data['transport_cost'] > 0)
		{
			$expance = array(
				'shop_id' 				=>$this->tank_auth->get_shop_id(), 
				'service_provider_id' 	=> 1, // Need to set a Default Value(purchase_receipt_id) to get the distributor
				'expense_type' 			=> 10,				
				'expense_amount' 		=> $data['transport_cost'],
				'expense_details' 		=> 'Transaction Cost For Purchase Receipt '. $ref_id,
				'expense_creator' 		=> $data['receipt_creator']
			);	
			$insert = $this->db->insert('expense_info',$expance);

			$purchase_expense_info = array
			(
			   'transaction_id'         			=> '',
			   'transaction_purpose'                => 'expense',
			   'transaction_mode'                 	=> '',
			   'ledger_id'         					=> 1,
			   'common_id'         					=> $ref_id,
			   'amount'     						=> $data['transport_cost'],
			   'date'                   			=> $dd,
			   'status'        						=> 'active',
			   'creator'        					=> $data['receipt_creator'],
			);
			$this->db->insert('transaction_info', $purchase_expense_info);
		}
		
		$purchase_info = array
		(
		   'transaction_purpose'                => 'purchase',
		   'transaction_mode'                 	=> '',
		   'ledger_id'         					=> $data['distributor_id'],
		   'common_id'         					=> $ref_id,
		   'amount'     						=> $data['final_amount'],
		   'date'                   			=> $dd,
		   'status'        						=> 'active',
		   'creator'        					=> $data['receipt_creator'],
		);
		$this->db->insert('transaction_info', $purchase_info);
		

		$payment_mode = $this->input->post('payment_mode');
		$payment_amount = $this->input->post('payment_amount');
		$card_id = $this->input->post('card_id');
		$my_bank = $this->input->post('my_bank');
		$to_bank = $this->input->post('to_bank');
		$cheque_no = $this->input->post('cheque_no');
		$cheque_date = $this->input->post('cheque_date');
		$bd_date=$dd;
		if($payment_mode !='')
		{
			if($payment_mode==1 && $payment_amount>0)
			{
				$payment_info = array
				(
				   'transaction_purpose'                => 'payment',
				   'transaction_mode'                 	=> 'cash',
				   'ledger_id'         					=> $data['distributor_id'],
				   'common_id'         					=> $ref_id,
				   'amount'     						=> $payment_amount,
				   'date'                   			=> $bd_date,
				   'status'        						=> 'active',
				   'creator'        					=> $data['receipt_creator'],
				);
				$this->db->insert('transaction_info', $payment_info);
				$insert_id = $this->db->insert_id();
				$cash_book = array(
				   'cb_id'         						=> '',
				   'transaction_id'                     => $insert_id,
				   'transaction_type'                	=> 'out',
				   'amount'                 			=> $payment_amount,
				   'date'         						=> $bd_date,
				   'status'    	 						=> 'active',
				   'creator'                   			=> $data['receipt_creator'],
				);
				$this->db->insert('cash_book', $cash_book);
			}
			else if($payment_mode==2 && $payment_amount>0)
			{
				$payment_info = array
				(
				   'transaction_purpose'                => 'payment',
				   'transaction_mode'                 	=> 'cheque',
				   'ledger_id'         					=> $data['distributor_id'],
				   'common_id'         					=> $ref_id,
				   'amount'     						=> $payment_amount,
				   'date'                   			=> $bd_date,
				   'status'        						=> 'active',
				   'creator'        					=> $data['receipt_creator'],
				);
				$this->db->insert('transaction_info', $payment_info);
				$insert_id = $this->db->insert_id();
				$bank_book = array(
				   'bb_id'         						=> '',
				   'transaction_id'                     => $insert_id,
				   'ledger_id'         					=> $data['distributor_id'],
				   'ledger_type'         				=> 'purchase_payment',
				   'bank_id'                     		=> $my_bank,
				   'card_id'                     		=> 0,
				   'transaction_type'                	=> 'out',
				   'bank_name'                			=> $to_bank,
				   'cheque_no'                			=> $cheque_no,
				   'cheque_date'                		=> $cheque_date,
				   'amount'                 			=> $payment_amount,
				   'date'         						=> $bd_date,
				   'status'    	 						=> 'inactive',
				   'creator'                   			=> $data['receipt_creator'],
				);
				$this->db->insert('bank_book', $bank_book);
			}
			
			else if($payment_mode==3 && $payment_amount>0)
			{
				$payment_info = array
				(
				   'transaction_purpose'                => 'payment',
				   'transaction_mode'                 	=> 'card',
				   'ledger_id'         					=> $data['distributor_id'],
				   'common_id'         					=> $ref_id,
				   'amount'     						=> $payment_amount,
				   'date'                   			=> $bd_date,
				   'status'        						=> 'active',
				   'creator'        					=> $data['receipt_creator'],
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
				   'date'         						=> $bd_date,
				   'status'    	 						=> 'active',
				   'creator'                   			=> $data['receipt_creator'],
				);
				$this->db->insert('bank_book', $bank_book);
			}
		}
		return $ref_id;
	}
	
	public function all()
	{	
		$this->db->order_by('receipt_id', 'asc');
        $this->db->join('distributor_info', 'distributor_info.distributor_id = purchase_receipt_info.distributor_id');
		return $this->db->get('purchase_receipt_info')->result();
	}

	// purchase return
	public function product_info_details($product_id)
	{
		$this->db->select("product_info.product_id,product_info.product_name,product_info.product_specification,bulk_stock_info.stock_amount,bulk_stock_info.bulk_unit_buy_price");
		$this->db->from("bulk_stock_info,product_info");
		$this->db->where("bulk_stock_info.product_id=product_info.product_id");
		$this->db->where("product_info.product_id", $product_id );
		$query = $this->db->get();
		return $query;
	}

	public function product_info_warranty_details($product_id)
	{
		$this->db->select("product_info.product_id,product_info.product_name,bulk_stock_info.stock_amount,warranty_product_list.ip_id,warranty_product_list.sl_no");
		$this->db->from("bulk_stock_info,product_info,warranty_product_list");
		$this->db->where("bulk_stock_info.product_id=product_info.product_id");
		$this->db->where("product_info.product_id=warranty_product_list.product_id");
		$this->db->where("warranty_product_list.product_id", $product_id );
		$this->db->where("warranty_product_list.status=1");
		$query = $this->db->get();
		return $query;
	}

	public function purchase_return_lilsting_product()
	{
		$this->db->select("product_info.product_name,distributor_info.distributor_name,purchase_return_main_product.*");
		$this->db->from("distributor_info,product_info,purchase_return_main_product");
		$this->db->where("purchase_return_main_product.produ_id=product_info.product_id");
		$this->db->where("purchase_return_main_product.distri_id=distributor_info.distributor_id");
		$this->db->where("purchase_return_main_product.status=0");
		$query = $this->db->get();
		return $query;
	}

	public function purchase_return_lilsting_product_warranty($produ_id)
	{
		$this->db->where("purchase_return_warranty_product.product_id",$produ_id);
		$this->db->where("purchase_return_warranty_product.status=0");
		$query = $this->db->get('purchase_return_warranty_product');
		return $query;
	}
}