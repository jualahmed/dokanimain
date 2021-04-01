<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function all_user()
	{
		$usertype = $this->tank_auth->get_usertype();
		$this->db->order_by('username', "asc");
		$this->db->select('users.id, users.username, user_full_name, users.user_type,users.user_type');
		$this->db->from('users');
		if ($usertype == 'manager') {
			$this->db->where('users.user_type = "seller"');
			$this->db->or_where('users.user_type = "stockist"');
			$this->db->or_where('users.user_type = "accountent"');
		} else if ($usertype == 'admin') {
			$this->db->where('users.user_type = "manager" ');
			$this->db->or_where('users.user_type = "accountent"');
			$this->db->or_where('users.user_type = "seller" ');
			$this->db->or_where('users.user_type = "stockist"');
		}
		if ($usertype == 'superadmin') {
			$this->db->where('users.user_type = "superadmin" ');
			$this->db->or_where('users.user_type = "admin"');
			$this->db->or_where('users.user_type = "manager"');
			$this->db->or_where('users.user_type = "accountent"');
			$this->db->or_where('users.user_type = "seller"');
			$this->db->or_where('users.user_type = "stockist"');
		}
		$query = $this->db->get();
		$data[''] =  'Select a User Name';
		foreach ($query->result() as $field) {
			$data[base_url() . 'admin/user_modification/' . $field->username] = $field->username . '(' . $field->user_full_name . ')';
		}
		return $data;
	}

	public function specific_user()
	{
		$name = $this->uri->segment(3);
		$usertype = $this->tank_auth->get_usertype();
		$this->db->select('users.username,users.user_address,users.email,users.user_type,users.id,user_full_name');
		$this->db->from('users');
		$this->db->where('users.username = "' . $name . '"');
		$query = $this->db->get();

		foreach ($query->result() as $check) :
			$type = $check->user_type;
			if ($usertype == 'manager') {
				if ($type == 'seller' || $type == 'stockist' || $type == 'accountent') return $query;
				else {
					$this->db->select('users.username,users.user_address,users.email,users.user_type');
					$this->db->from('users');
					$this->db->where('users.username = ""');
					$query = $this->db->get();
				}
			} else if ($usertype == 'admin') {
				if ($type == 'seller' || $type == 'stockist' || $type == 'accountent' || $type == 'manager') return $query;
				else {
					$this->db->select('users.username,users.user_address,users.email,users.user_type');
					$this->db->from('users');
					$this->db->where('users.username = ""');
					$query = $this->db->get();
				}
			} else if ($usertype == 'superadmin') {
				if ($type == 'seller' || $type == 'stockist' || $type == 'accountent' || $type == 'manager' || $type == 'admin' || $type = 'superadmin') return $query;
				else {
					$this->db->select('users.username,users.user_address,users.email,users.user_type');
					$this->db->from('users');
					$this->db->where('users.username = ""');
					$query = $this->db->get();
				}
			}
		endforeach;

		return $query;
	}

	public function update_user($hashed_password, $new_password)
	{
		$username 		= $this->input->post('username');
		$u_id 			= $this->input->post('ch_id');
		$new_type 			= $this->input->post('new_user_type');
		$contact 			= $this->input->post('email');
		$user_add 			= $this->input->post('user_address');
		$user_full_name 	= $this->input->post('user_full_name');

		$user_up = array(
			'username'     	=> $username,
			'user_type'    	=> $new_type,
			'password'        	=> $hashed_password,
			'password2'        	=> $new_password,
			'email'        	=> $contact,
			'user_address' 	=> $user_add,
			'user_full_name' => $user_full_name
		);

		$this->db->where('id', $u_id);
		$up = $this->db->update('users', $user_up);
		return $up;
	}

	public function backup_database()
	{
		$bd_date = date('d_m_Y');
		$this->load->dbutil();
		$prefs = array(
			'tables'      => array(),              // Array of tables to backup.
			'format'      => 'txt',                // gzip, zip, txt
			'filename'      => 'dokani.sql',
			'add_drop'    => TRUE,                 // Whether to add DROP TABLE statements to backup file
			'add_insert'  => TRUE,                 // Whether to add INSERT data to backup file
			'newline'     => "\n"                  // Newline character used in backup file
		);
		$backup = $this->dbutil->backup($prefs);

		$folder = date('d_m_Y');
		$this->load->helper("file");
		write_file(FCPATH . "\\dokani$folder.sql", $backup); // store in server
		$this->load->helper("download");
		if (force_download("dokani$folder.sql", $backup)) {
			return true;
		}

		return false;
	}


	public function daily_statement()
	{
		$last_date = '2020-01-01';
		$date = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
		$dateList = array();
		while (!$this->alreadyExist($date) && $date >= $last_date) {
			array_push($dateList, $date);
			$date = date('Y-m-d', strtotime('-1 day', strtotime($date)));
		}


		foreach ($dateList as $date) {
			$dailystatementm = new Dailystatementm();
			$dailystatementm->date = $date;
			$dailystatementm->purchase = Transactionm::where('transaction_purpose', 'purchase')->where('date', $date)->sum('amount');
			$dailystatementm->expense = Transactionm::where('transaction_purpose', 'expense')->where('date', $date)->sum('amount');
			$dailystatementm->sale = Transactionm::where('transaction_purpose', 'sale')->where('date', $date)->sum('amount');
			$dailystatementm->sale_discount = Invoicem::where('invoice_doc', $date)->sum('discount_amount');
			$dailystatementm->receivable_gift = Purchasereceiptinfom::where('receipt_date', $date)->sum('transport_cost');
			$dailystatementm->transport_cost = Purchasereceiptinfom::where('receipt_date', $date)->sum('gift_on_purchase');
			$cstock = Bulkstockinfom::selectRaw('SUM(bulk_unit_buy_price * stock_amount) as total')->pluck('total')[0];
			$totalsale = Invoicem::where('invoice_doc', $date)->sum('total_price');
			$totalpurchase = Purchaseinfom::selectRaw('SUM(unit_buy_price * purchase_quantity) as total')->where('purchase_doc', $date)->pluck('total')[0];
			$dailystatementm->stock_current = $cstock;
			$dailystatementm->stock_opening = ($cstock + $totalsale) - $totalpurchase;
			$cashIn = Cashbook::where('transaction_type', 'in')->sum('amount');
			$cashOut = Cashbook::where('transaction_type', 'out')->sum('amount');
			$dailystatementm->cash_in_hand = $cashIn - $cashOut;
			$bankIn = Bankbook::where('transaction_type', 'in')->sum('amount');
			$bankOut = Bankbook::where('transaction_type', 'out')->sum('amount');
			$dailystatementm->cash_in_bank = $bankIn - $bankOut;
			$price = $this->db->select('SUM(unit_buy_price * sale_quantity) as total_buy_price, SUM(actual_sale_price * sale_quantity) as total_sale_price')
				->from('sale_details')
				->join('invoice_info', 'invoice_info.invoice_id=sale_details.invoice_id', 'left')
				->where("invoice_doc='$date'")
				->get()->row();
			$buyPrice = $price->total_buy_price;
			$salePrice = $price->total_sale_price;
			$dailystatementm->gross_profit = $salePrice - $buyPrice;
			$dailystatementm->save();
		}
	}

	public function alreadyExist($date)
	{
		$dailystatementm = Dailystatementm::where('date', $date)->first();

		return $dailystatementm ? true : false;
	}
}

/* End of file Admin_model.php */
/* Location: ./application/models/Admin_model.php */