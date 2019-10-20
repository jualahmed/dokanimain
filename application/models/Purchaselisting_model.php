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

	public function find($purchaselisting_id='')
	{
		$this->db->where('purchase_id', $purchaselisting_id);
		return $this->db->get('purchase_info')->row();
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
		$this->db->order_by("purchase_id", "asc");
		$query = $this -> db -> select('product_name, purchase_info.product_id,product_info.product_specification, purchase_quantity AS number_of_quantity,purchase_id, unit_buy_price, purchase_expire_date')
						 -> from('purchase_info,product_info,purchase_receipt_info')
						 -> where('purchase_receipt_id = "'.$receipt_id.'"')
						 -> where('purchase_info.product_id = product_info.product_id')
						 -> where('purchase_info.purchase_receipt_id = purchase_receipt_info.receipt_id')
						 -> get();
		return $query;
	}

	public function removeProductFromPurchase($purchase_receipt_id, $product_id,$purchase_id)
	{
		$tmp =$this->db->where('purchase_id',$purchase_id)
			    	   ->get('purchase_info')->row();

		$this->db->where('product_id' , $product_id);
		$query_2 = $this->db->get('bulk_stock_info');
		$tmp_2 = $query_2->row();

		if($tmp->purchase_quantity <= $tmp_2->stock_amount)
		{
			$pre_total_price = $tmp_2->stock_amount * $tmp_2->bulk_unit_buy_price;
			$new_total_purchase_price = $tmp->purchase_quantity * $tmp->unit_buy_price;
			$new_stock = $tmp_2->stock_amount - $tmp->purchase_quantity;
			$new_buy_price = $pre_total_price - $new_total_purchase_price;
			if($new_buy_price==0 || $new_stock==0){
				$final_buy_price=0;
			}else{
				$final_buy_price = $new_buy_price / $new_stock;
			}

			$pre_total_price1 = $tmp_2->stock_amount * $tmp_2->bulk_unit_sale_price;
			$new_total_purchase_price1 = $tmp->purchase_quantity * $tmp->bulk_unit_sale_price;
			$new_stock1 = $tmp_2->stock_amount - $tmp->purchase_quantity;
			$new_buy_price1 = $pre_total_price1 - $new_total_purchase_price1;

			if($new_buy_price1==0 || $new_stock1==0){
				$final_buy_price1=0;
			}else{
				$final_buy_price1 = $new_buy_price / $new_stock;
			}

			$pre_total_price2 = $tmp_2->stock_amount * $tmp_2->general_unit_sale_price;
			$new_total_purchase_price2 = $tmp->purchase_quantity * $tmp->general_unit_sale_price;
			$new_stock2 = $tmp_2->stock_amount - $tmp->purchase_quantity;
			$new_buy_price2 = $pre_total_price2 - $new_total_purchase_price2;

			if($new_buy_price2==0 || $new_stock2==0){
				$final_buy_price2=0;
			}else{
				$final_buy_price2 = $new_buy_price2 / $new_stock2;
			}

			$data = array(
				'bulk_unit_buy_price' => $final_buy_price,
				'bulk_unit_sale_price' => $final_buy_price1,
				'general_unit_sale_price' => $final_buy_price2
			);
			$this->db->where('product_id' , $product_id);
			$this->db->update('bulk_stock_info',$data);

			$this->db->set('stock_amount', 'stock_amount - ' . $tmp->purchase_quantity, FALSE);
			$this->db->where('product_id' , $product_id);
			$this->db->update('bulk_stock_info');
			$this->db->where('purchase_id', $purchase_id)->delete('purchase_info');
		}
	}

	public function	editPruchaseProduct($purchase_id, $qnty, $unit_buy_price,$bulk_unit_sale_price,$general_unit_sale_price)
	{	
		$this->db->where('purchase_id', $purchase_id);
		$purchase_info = $this->db->get('purchase_info')->row();

		$this->db->where('product_id', $purchase_info->product_id);
		$alddata=$this->db->get('bulk_stock_info')->row();

		$oldquantity=$alddata->stock_amount;
		$totalquantity=$oldquantity-$purchase_info->purchase_quantity;

		if($oldquantity-$purchase_info->purchase_quantity==0){
			$unit_buy_price_purchase=0;
			$exclusive_sale_price1=0;
			$general_unit_sale_price1=0;
		}else{
			$unit_buy_price_purchase=(($alddata->bulk_unit_buy_price*$oldquantity)-($purchase_info->unit_buy_price*$purchase_info->purchase_quantity))/($oldquantity-$purchase_info->purchase_quantity);
			$exclusive_sale_price1=(($alddata->bulk_unit_sale_price*$oldquantity)-($purchase_info->bulk_unit_sale_price*$purchase_info->purchase_quantity))/($oldquantity-$purchase_info->purchase_quantity);
			$general_unit_sale_price1=(($alddata->general_unit_sale_price*$oldquantity)-($purchase_info->general_unit_sale_price*$purchase_info->purchase_quantity))/($oldquantity-$purchase_info->purchase_quantity);
		}

		echo $unit_buy_price_purchase;

		$this->db->where('product_id', $purchase_info->product_id);
		$this->db->set('stock_amount','stock_amount-'.$purchase_info->purchase_quantity,FALSE);
		$this->db->set('bulk_unit_buy_price',$unit_buy_price_purchase);
		$this->db->set('bulk_unit_sale_price',$exclusive_sale_price1);
		$this->db->set('general_unit_sale_price',$general_unit_sale_price1);
		$this->db->update('bulk_stock_info');

		$this->db->where('purchase_id', $purchase_id);
		$this->db->set('purchase_quantity',$qnty);
		$this->db->set('unit_buy_price',$unit_buy_price);
		$this->db->set('bulk_unit_sale_price',$bulk_unit_sale_price);
		$this->db->set('general_unit_sale_price',$general_unit_sale_price);
		$this->db->update('purchase_info');

		$this->db->where('purchase_id', $purchase_id);
		$purchase_info = $this->db->get('purchase_info')->row();

		$this->db->where('product_id', $purchase_info->product_id);
		$alddata=$this->db->get('bulk_stock_info')->row();

		// okay
		$oldquantity=$alddata->stock_amount;
		$totalquantity=$purchase_info->purchase_quantity+$oldquantity;
		$unit_buy_price_purchase1=(($alddata->bulk_unit_buy_price*$oldquantity)+($purchase_info->unit_buy_price*$purchase_info->purchase_quantity))/($oldquantity+$purchase_info->purchase_quantity);
		$exclusive_sale_price1=(($alddata->bulk_unit_sale_price*$oldquantity)+($purchase_info->bulk_unit_sale_price*$purchase_info->purchase_quantity))/($oldquantity+$purchase_info->purchase_quantity);
		$general_unit_sale_price1=(($alddata->general_unit_sale_price*$oldquantity)+($purchase_info->general_unit_sale_price*$purchase_info->purchase_quantity))/($oldquantity+$purchase_info->purchase_quantity);

		$unit_buy_price_purchase1=ceil($unit_buy_price_purchase1);
		$exclusive_sale_price1=ceil($exclusive_sale_price1);
		$general_unit_sale_price1=ceil($general_unit_sale_price1);
		$object=[
			'stock_amount'=>$totalquantity,
			'bulk_unit_buy_price'=>$unit_buy_price_purchase1,
			'bulk_unit_sale_price'=>$exclusive_sale_price1,
			'general_unit_sale_price'=>$general_unit_sale_price1
		];
		$this->db->where('bulk_id', $alddata->bulk_id);
		$this->db->update('bulk_stock_info',$object);
	}
}

/* End of file Purchaselisting_model.php */
/* Location: ./application/models/Purchaselisting_model.php */