<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchaselisting_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function createlisting(array $data)
	{
		$this->db->insert('purchase_info', $data);
		$id = $this->db->insert_id();
		return $id;
	}

	public function allproductbelogntopurchase($purchase_id = '')
	{
		$this->db->select('purchase_info.*,product_info.product_name,product_info.product_specification');
		$this->db->where('purchase_receipt_id', $purchase_id);
		$this->db->join('product_info', 'product_info.product_id = purchase_info.product_id');
		return $this->db->get('purchase_info')->result();
	}

	public function find($purchaselisting_id = '')
	{
		$this->db->select('purchase_info.*, product_info.has_serial_no')
			->join('product_info', 'product_info.product_id=purchase_info.product_id', 'left')
			->where('purchase_id', $purchaselisting_id);
		$product = $this->db->get('purchase_info')->row();

		$product->serials = null;
		if ($product->has_serial_no == 1) {
			$product->serials = $this->db->where('purchase_receipt_id', $product->purchase_receipt_id)
				->where('product_id', $product->product_id)
				->get('warranty_product_list')->result();
		}
		return $product;
	}


	public function specific_purchase_receipt_general($receipt_id)
	{
		$query = $this->db->select('receipt_id, purchase_receipt_info.distributor_id, final_amount, purchase_amount, receipt_creator, receipt_status, total_paid ,receipt_date ,
										distributor_name, user_full_name, username, transport_cost, gift_on_purchase,SUM(purchase_quantity * unit_buy_price) as total_listing')
			->from('purchase_receipt_info')
			->where('receipt_id', $receipt_id)
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

	public function specific_purchase_receipt($receipt_id)
	{
		$this->db->order_by("purchase_id", "asc");
		$query = $this->db->select('product_name, purchase_info.product_id,product_info.product_specification, purchase_quantity AS number_of_quantity,purchase_id, unit_buy_price, purchase_expire_date')
			->from('purchase_info,product_info,purchase_receipt_info')
			->where('purchase_receipt_id = "' . $receipt_id . '"')
			->where('purchase_info.product_id = product_info.product_id')
			->where('purchase_info.purchase_receipt_id = purchase_receipt_info.receipt_id')
			->get();
		return $query;
	}

	public function removeProductFromPurchase($purchase_receipt_id, $product_id, $purchase_id)
	{
		$purchaseInfo = $this->db->where('purchase_id', $purchase_id)
			->get('purchase_info')->row();

		$this->db->where('product_id', $product_id);
		$bulkProduct = $this->db->get('bulk_stock_info')->row();

		if ($purchaseInfo->purchase_quantity <= $bulkProduct->stock_amount) {
			$new_stock = $bulkProduct->stock_amount - $purchaseInfo->purchase_quantity; //previous_total_stock - new_total_stock

			$this->db->set('stock_amount', $new_stock, FALSE);
			$this->db->where('product_id', $product_id);
			$this->db->update('bulk_stock_info');
			return $this->db->where('purchase_id', $purchase_id)->delete('purchase_info');
		}
	}

	public function	editPruchaseProduct($purchase_id, $quantity)
	{
		$this->db->where('purchase_id', $purchase_id);
		$purchase_info = $this->db->get('purchase_info')->row();

		$this->db->where('product_id', $purchase_info->product_id);
		$stock_info = $this->db->get('bulk_stock_info')->row();

		$stock_quantity = $stock_info->stock_amount;
		$purchase_quantity = $purchase_info->purchase_quantity;
		$new_stock_quantity = $stock_quantity - ($purchase_quantity - $quantity);

		if ($new_stock_quantity < 0) {
			echo "Purchase quantity must be less then to stock amount.";
		} else {
			$this->db->where('product_id', $purchase_info->product_id);
			$this->db->set('stock_amount', $new_stock_quantity, FALSE);
			$this->db->update('bulk_stock_info');

			$this->db->where('purchase_id', $purchase_id);
			$this->db->set('purchase_quantity', $quantity);
			$this->db->update('purchase_info');

			echo 'success';
		}
	}
}

/* End of file Purchaselisting_model.php */
/* Location: ./application/models/Purchaselisting_model.php */