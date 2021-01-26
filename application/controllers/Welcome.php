<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('purchase_model');
		$this->load->model('distributor_model');
		$this->load->model('purchaselisting_model');
	}

	function update_buy_and_sale_price()
	{
		$saleProducts = $this->db->query("SELECT * FROM `sale_details` WHERE `unit_buy_price`=0 OR `general_sale_price`=0")->result();
		if ($saleProducts) {
			foreach ($saleProducts as $product) {
				$stock = $this->db->select("*")->from("bulk_stock_info")->where("product_id", $product->product_id)->get()->row();
				if ($stock) {
					$this->db->where("product_id", $product->product_id)->update('sale_details', array(
						'general_sale_price' => $stock->general_unit_sale_price,
						'unit_buy_price' => $stock->bulk_unit_buy_price,
					));
					echo 'Updated......................................<br/>';
				}
			}
		}
	}

	function update_stock_according_to_purchase()
	{
		$stocks = $this->db->select('*')
			->from('bulk_stock_info')
			->where("bulk_unit_buy_price=0")
			->get()
			->result();
		if ($stocks) {
			foreach ($stocks as $stock) {
				$purchase = $this->db->select('*')
					->from('purchase_info')
					->where('product_id', $stock->product_id)
					->order_by('purchase_doc', 'DESC')
					->get()
					->row();

				if ($purchase) {
					$this->db->where('bulk_id', $stock->bulk_id)
						->update('bulk_stock_info', array(
							'bulk_unit_buy_price' => $purchase->unit_buy_price,
							'bulk_unit_sale_price' => $purchase->bulk_unit_sale_price,
							'general_unit_sale_price' => $purchase->general_unit_sale_price,
							'last_buy_price' => $purchase->unit_buy_price,
						));
				}
			}
		}
	}


	function setup_purchase_transaction_by_stock()
	{
		$date = date('Y-m-d');
		$stocks = $this->db->select('*')
			->from('bulk_stock_info')
			->get()
			->result();

		$total_buy_price = 0;
		foreach($stocks as $stock) {
			$total_buy_price += ($stock->stock_amount * $stock->bulk_unit_buy_price);
		}

		$distributor_data = array(
			'distributor_name' => 'Dokani Old Stock',
			'distributor_address' => '',
			'int_balance' => $total_buy_price,
			'distributor_contact_no' => '',
			'distributor_email' => '',
			'distributor_description' => '',
			'distributor_creator' => 1,
		);
		$distributor_id = $this->distributor_model->create($distributor_data);

		$purchase_data = array(
			'distributor_id'    => $distributor_id,
			'purchase_amount'   => $total_buy_price,
			'transport_cost'    => 0,
			'gift_on_purchase'  => 0,
			'final_amount'      => $total_buy_price,
			'shop_id' 		    => 1, 
			'receipt_status' 	=> 'paid',
			'total_paid' 		=> 0,
			'receipt_date'   => $date,
			'receipt_creator'   => 1,
		);
		$purchase_receipt_id = $this->purchase_model->create($purchase_data, $date);

		if ($stocks) {
			foreach ($stocks as $stock) {
				$data = array(
					'purchase_receipt_id'     => $purchase_receipt_id,
					'product_id'              => $stock->product_id,
					'purchase_quantity'       => $stock->stock_amount,
					'unit_buy_price'          => $stock->bulk_unit_buy_price,
					'bulk_unit_sale_price'    => $stock->bulk_unit_sale_price,
					'general_unit_sale_price' => $stock->general_unit_sale_price,
					'purchase_expire_date'    => $date,
					'purchase_description'    => "initial purchase",
					'purchase_creator'        => 1,
				);
				$purchase_id = $this->purchaselisting_model->createlisting($data);
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */