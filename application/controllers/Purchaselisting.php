<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchaselisting extends MY_Controller
{

	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id = $this->tank_auth->get_shop_id();
		$this->is_logged_in();
		$this->load->model('purchaselisting_model');
		$this->load->model('report_model');
		$this->load->model('company_model');
		$this->load->model('category_model');
		$this->load->model('unit_model');
		$this->load->model('product_model');
	}

	public function is_logged_in()
	{
		$this->load->library('tank_auth');
		if (!$this->tank_auth->is_logged_in()) {
			redirect('auth/login', 'refresh');
		}
	}

	public function index()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		$data['user_type'] = $this->tank_auth->get_usertype();

		// For Product create start
		$data['sale_status'] = '';
		$data['alarming_level'] = FALSE;
		$data['status'] = '';
		$data['user_name'] = $this->tank_auth->get_username();
		$data['company'] = $this->company_model->all();
		$data['catagory'] = $this->category_model->all();
		$data['unit'] = $this->unit_model->all();
		$data['product_specification'] = $this->product_model->product_specification();
		$data['last_id'] = $this->product_model->getLastInserted();
		// For Product create end

		$data['vuejscomp'] = 'purchaselisting_new.js';
		$this->__renderview('Purchase/purchaselisting_new', $data);
	}

	public function createlisting()
	{
		$purchase_receipt_id = $this->input->post('purchase_receipt_id');
		$product_id = $this->input->post('product_id');
		$expire_date = $this->input->post('expiredate');
		$tp_total = $this->input->post('tp_total');
		$vat_total = $this->input->post('vat_total');
		$quantity = $this->input->post('quantity');
		$total_buy_price = $this->input->post('total_buy_price');
		$unit_buy_price_purchase = $this->input->post('unit_buy_price_purchase');
		$exclusive_sale_price = $this->input->post('exclusive_sale_price');
		$general_sale_price = $this->input->post('general_sale_price');
		$all_warranty_product = $this->input->post('allworrantyproduct');
		$creator = $this->tank_auth->get_user_id();


		$purchase_id = -1;
		$total_unit_buy_price = 0;
		$purchase_receipt = Purchaseinfom::where('purchase_receipt_id', $purchase_receipt_id)->get();
		foreach ($purchase_receipt as $key => $value) {
			$total_unit_buy_price += ($value->purchase_quantity * $value->unit_buy_price);
		}
		$total_price = Purchasereceiptinfom::find($purchase_receipt_id);
		$this->load->config('custom_config');
		$allow_purchase_exceed = $this->config->item('allow_purchase_exceed');
		if ($allow_purchase_exceed == 0 && ($total_unit_buy_price + $total_buy_price) > $total_price->purchase_amount) {
			echo "exceed";
		} else {

			/**
			 * purchase_info table
			 * 
			 * First check this :purchase_receipt_id with :product_id has any record in purchase info table
			 * If any record exists, then update record info
			 * Otherwise create new record
			 */
			$oldPurchaseData = $this->db->where([
				'product_id' => $product_id,
				'purchase_receipt_id' => $purchase_receipt_id,
			])->get('purchase_info')->row();

			if ($oldPurchaseData) {
				$purchase_id = $oldPurchaseData->purchase_id;
				$old_quantity = $oldPurchaseData->purchase_quantity;
				$new_quantity = $quantity + $old_quantity;

				/**
				 * if already purchases
				 * then
				 * otherwise create new record
				 * average prices [unit_buy_price, bulk_unit_sale_price, general_unit_sale_price]
				 */
				$object = [
					'purchase_quantity' => $new_quantity,
					'unit_buy_price' => $unit_buy_price_purchase,
					'bulk_unit_sale_price' => $exclusive_sale_price,
					'general_unit_sale_price' => $general_sale_price,
				];
				$this->db->where('purchase_id', $oldPurchaseData->purchase_id);
				$this->db->update('purchase_info', $object);
			} else {
				$data = array(
					'purchase_receipt_id' => $purchase_receipt_id,
					'product_id' => $product_id,
					'purchase_quantity' => $quantity,
					'unit_buy_price' => $unit_buy_price_purchase,
					'bulk_unit_sale_price' => $exclusive_sale_price,
					'general_unit_sale_price' => $general_sale_price,
					'purchase_expire_date' => $expire_date,
					'purchase_description' => "a test purchase_receipt_id",
					'purchase_creator' => $creator,
				);
				$purchase_id = $this->purchaselisting_model->createlisting($data);
			}

			/**
			 * warranty_product_list table
			 * 
			 * Add product serial no. if :product_id has warranty and serial_no
			 */
			if (!empty($all_warranty_product)) {
				foreach ($all_warranty_product as $key => $value) {
					$datass = array(
						'product_id' => $product_id,
						'purchase_receipt_id' => $purchase_receipt_id,
						'sl_no' => $value,
						'purchase_date' => date("Y-m-d"),
						'purchase_price' => $unit_buy_price_purchase,
						'sale_price' => $general_sale_price,
						'creator' => $creator,
					);
					$this->db->insert('warranty_product_list', $datass);
				}
			}

			/**
			 * bulk_stock_info table
			 * 
			 * First check this :product_id has any record in bulk stock info table
			 * If any record exists, then update record info
			 * Otherwise create new record
			 */
			$this->db->where('product_id', $product_id);
			$stock_data = $this->db->get('bulk_stock_info')->row();

			/**
			 * fetch selected product from product_info by product id
			 * then set alarming stock for bulk stock info
			 */
			$selectedProduct = $this->db->select('*')
					->from('product_info')
					->where('product_id', $product_id)
					->get()->row();

			if ($stock_data) {
				$oldQuantity = $stock_data->stock_amount;
				$totalQuantity = $quantity + $oldQuantity;
				$new_unit_buy_price_purchase = (($stock_data->bulk_unit_buy_price * $oldQuantity) +
					($unit_buy_price_purchase * $quantity)) / $totalQuantity;

				$object = [
					'stock_amount' => $totalQuantity,
					'bulk_unit_buy_price' => $new_unit_buy_price_purchase,
					'bulk_unit_sale_price' => $exclusive_sale_price,
					'general_unit_sale_price' => $general_sale_price,
					'bulk_alarming_stock' => $selectedProduct->alarming_stock,
					'last_buy_price' => $unit_buy_price_purchase
				];
				$this->db->where('bulk_id', $stock_data->bulk_id);
				$this->db->update('bulk_stock_info', $object);
			} else {
				$object = [
					'stock_amount' => $quantity,
					'product_id' => $product_id,
					'shop_id'   => $this->tank_auth->get_shop_id(),
					'bulk_unit_buy_price' => $unit_buy_price_purchase,
					'bulk_unit_sale_price' => $exclusive_sale_price,
					'general_unit_sale_price' => $general_sale_price,
					'bulk_alarming_stock' => $selectedProduct->alarming_stock,
					'last_buy_price' => $unit_buy_price_purchase,
				];
				$this->db->insert('bulk_stock_info', $object);
			}

			/**
			 * purchase_info table
			 * 
			 * after all insertion and updating, return new purchase data
			 */
			$this->db->select('purchase_info.*,product_info.product_name');
			$this->db->where('purchase_id', $purchase_id);
			$this->db->join('product_info', 'product_info.product_id = purchase_info.product_id');
			$purchase_data = $this->db->get('purchase_info')->result();
			echo json_encode($purchase_data);
		}
	}

	public function removePurchaseItem()
	{
		$purchase_id = $this->input->post('purchase_id');
		$purchase = $this->purchaselisting_model->find($purchase_id);
		$product = $this->product_model->find($purchase->product_id);
		$this->db->where('product_id', $purchase->product_id);
		$productOldData = $this->db->get('bulk_stock_info')->row();
		if ($purchase->purchase_quantity <= $productOldData->stock_amount) {
			if ($product->has_serial_no) {
				$this->db->where(array(
					'product_id' => $purchase->product_id,
					'purchase_receipt_id' => $purchase->purchase_receipt_id,
				))->delete('warranty_product_list');
			}
			if ($productOldData) {
				$quantity = $purchase->purchase_quantity;
				$oldQuantity = $productOldData->stock_amount;
				$totalQuantity = $oldQuantity - $quantity;
				if ($totalQuantity == 0) {
					$newBulkUnitBuyPrice = 0.00;
					$newBulkUnitSalePrice = 0.00;
					$newGeneralUnitPrice = 0.00;
				} else {
					$newBulkUnitBuyPrice = (($productOldData->bulk_unit_buy_price * $oldQuantity) -
						($purchase->unit_buy_price * $quantity)) / $totalQuantity;
					$newBulkUnitSalePrice = (($productOldData->bulk_unit_sale_price * $oldQuantity) -
						($purchase->bulk_unit_sale_price * $quantity)) / $totalQuantity;
					$newGeneralUnitPrice = (($productOldData->general_unit_sale_price * $oldQuantity) -
						($purchase->general_unit_sale_price * $quantity)) / $totalQuantity;
				}
				$total_buy_price = $quantity * $newBulkUnitBuyPrice;


				$object = [
					'stock_amount' => $totalQuantity,
					'bulk_unit_buy_price' => $newBulkUnitBuyPrice,
					'bulk_unit_sale_price' => $newBulkUnitSalePrice,
					'general_unit_sale_price' => $newGeneralUnitPrice,
					'last_buy_price' => $total_buy_price
				];
				$this->db->where('bulk_id', $productOldData->bulk_id);
				$this->db->update('bulk_stock_info', $object);

				$result = $this->db->where('purchase_id', $purchase_id)->delete('purchase_info');
				if ($result) {
					echo json_encode(['success' => true]);
				} else {
					echo json_encode(['success' => false]);
				}
			}
		} else {
			echo json_encode(['success' => false, 'msg' => "Product's current stock is $productOldData->stock_amount.<br/>Stock Quantity Goes to Negative"]);
		}
	}

	public function allproductbelogntopurchase($purchase_id = '')
	{
		$data = $this->purchaselisting_model->allproductbelogntopurchase($purchase_id);
		echo json_encode($data);
	}

	public function specificPurchaseReceipt()
	{
		$purchase_receipt_id 				= (int)$this->input->post('purchase_receipt_id');
		$receipt_general_details			= $this->purchaselisting_model->specific_purchase_receipt_general($purchase_receipt_id);
		$tmp_row 							= $receipt_general_details->row();
		$tmp_data['final_amount'] 			= $tmp_row->final_amount;
		$tmp_data['purchase_amount'] 		= $tmp_row->purchase_amount;
		$tmp_data['total_purchase_amount'] 	= $this->purchaselisting_model->get_total_purchase_amount($purchase_receipt_id);
		echo json_encode($tmp_data);
	}

	public function getSpecificPurchaseReceiptProduct()
	{
		$purchase_receipt_id 		= (int)$this->input->post('purchase_receipt_id');
		$purchase_receipt_details	= $this->purchaselisting_model->specific_purchase_receipt($purchase_receipt_id);
		json_encode($purchase_receipt_details);
	}

	public function all($rowno = 0)
	{
		$rowperpage = 12;
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}
		$allcount = $this->db->count_all('Purchaselisting_info');
		$this->db->limit($rowperpage, $rowno);
		$this->db->order_by('Purchaselisting_id', 'desc');
		$users_record = $this->db->get('Purchaselisting_info')->result_array();
		$config['base_url'] = base_url() . 'Purchaselisting';
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $allcount;
		$config['per_page'] = $rowperpage;
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']  = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']  = '</span></li>';
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $users_record;
		$data['row'] = $rowno;
		echo json_encode($data);
	}

	public function find()
	{
		$Purchaselisting_id = $this->input->post('purchaselisting_id');
		$data = $this->purchaselisting_model->find($Purchaselisting_id);
		echo json_encode($data);
	}

	public function editPruchaseProduct()
	{
		$purchase_id 			= $this->input->post('purchase_id');
		$quantity 					= $this->input->post('qty');
		echo $this->purchaselisting_model->editPruchaseProduct($purchase_id, $quantity);
	}

	public function update()
	{
		$jsonData = array('errors' => array(), 'success' => false, 'check' => false, 'output' => '');
		$rules = array(
			array(
				'field' => 'Purchaselisting_name',
				'label' => 'Purchaselisting_name',
				'rules' => 'required'
			),
			array(
				'field' => 'Purchaselisting_contact_no',
				'label' => 'Purchaselisting_contact_no',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'Purchaselisting_email',
				'label' => 'Purchaselisting_email',
				'rules' => 'required'
			),
			array(
				'field' => 'Purchaselisting_address',
				'label' => 'Purchaselisting_address',
				'rules' => 'required'
			),
			array(
				'field' => 'Purchaselisting_description',
				'label' => 'Purchaselisting_description',
				'rules' => 'required'
			),
			array(
				'field' => 'Purchaselisting_description',
				'label' => 'Purchaselisting_description',
			)
		);
		$Purchaselisting_id = $this->input->post('Purchaselisting_id');
		$creator = $this->tank_auth->get_user_id();
		$this->form_validation->set_rules($rules);
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		if ($this->form_validation->run() == TRUE) {
			$jsonData['check'] = true;
			$data = array(
				'Purchaselisting_name' => $this->input->post('Purchaselisting_name'),
				'Purchaselisting_address' => $this->input->post('Purchaselisting_address'),
				'Purchaselisting_contact_no' => $this->input->post('Purchaselisting_contact_no'),
				'Purchaselisting_email' => $this->input->post('Purchaselisting_email'),
				'Purchaselisting_description' => $this->input->post('Purchaselisting_description'),
				'Purchaselisting_creator' => $creator,
			);
			$id = $this->Purchaselisting_model->update($Purchaselisting_id, $data);
			$output = '';
			if ($id) {
				$jsonData['success'] = true;
			}
		} else {
			foreach ($_POST as $key => $value) {
				$jsonData['errors'][$key] = form_error($key);
			}
		}
		echo json_encode($jsonData);
	}

	public function destroy($id)
	{
		$result = $this->Purchaselisting_model->destroy($id);
		if ($result) {
			$this->session->set_flashdata('success', 'Purchaselisting Delete successfully');
			redirect('Purchaselisting', 'refresh');
		}
	}
}

/* End of file Purchaselisting.php */
/* Location: ./application/controllers/Purchaselisting.php */