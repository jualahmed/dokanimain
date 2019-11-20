<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchaselisting_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function createlisting(array $data)
	{
		$this->db->insert('purchase_info', $data);
		$id=$this->db->insert_id();
		return $id;
	}

	public function allproductbelogntopurchase($purchase_id='')
	{	
		$this->db->select('purchase_info.*,product_info.product_name');
		$this->db->where('purchase_receipt_id', $purchase_id);
		$this->db->join('product_info', 'product_info.product_id = purchase_info.product_id');
		return $this->db->get('purchase_info')->result();
	}


	public function specific_purchase_receipt_general($receipt_id)
	{	
		$query = $this->db->select('receipt_id, purchase_receipt_info.distributor_id, final_amount, purchase_amount, receipt_creator, receipt_status, total_paid ,receipt_date ,
										distributor_name, user_full_name, username, transport_cost, gift_on_purchase,SUM(purchase_quantity * unit_buy_price) as total_listing')
		->from('purchase_receipt_info')
		->where('receipt_id',$receipt_id)
		->join('purchase_info', 'purchase_info.purchase_receipt_id = purchase_receipt_info.receipt_id', 'left')
		->join('distributor_info', 'distributor_info.distributor_id = purchase_receipt_info.distributor_id', 'left')
		->join('users', 'users.id = purchase_receipt_info.receipt_creator', 'left')
		->get();
		return $query;
	}

	public function get_total_purchase_amount($purchase_receipt_id)
	{
		$this->db->select('SUM(purchase_quantity * unit_buy_price) as total_purchase_amount')
		->from('purchase_info')
		->where('purchase_receipt_id', $purchase_receipt_id);
		$query = $this->db->get()->row();

		return $query->total_purchase_amount;
	}

	public function specific_purchase_receipt( $receipt_id)
	{
		$this -> db -> order_by("purchase_id", "asc");
		$query = $this -> db -> select('product_name, purchase_info.product_id,product_info.product_specification, purchase_quantity AS number_of_quantity,purchase_id, unit_buy_price, purchase_expire_date')
						 -> from('purchase_info,product_info,purchase_receipt_info')
						 -> where('purchase_receipt_id = "'.$receipt_id.'"')
						 -> where('purchase_info.product_id = product_info.product_id')
						 -> where('purchase_info.purchase_receipt_id = purchase_receipt_info.receipt_id')
						 -> get();
		return $query;
	}
}

/* End of file Purchaselisting_model.php */
/* Location: ./application/models/Purchaselisting_model.php */