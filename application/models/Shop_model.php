<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function shop_setup($shopName, $shopType, $shopAddress, $shopContact,$logo='',$invoicelogo='')
	{
		$creator = $this->tank_auth->get_user_id();
		$data = array(
			'shop_name' => rtrim($shopName,";"),
			'shop_type' => $shopType,
			'shop_address' => $shopAddress,
			'shop_contact' => $shopContact,
			'logo' => $logo,
			'invoicelogo' => $invoicelogo,
			'shop_creator' => $creator,
			'shop_status' => 1
		);
		return $this->db->insert('shop_setup', $data);
	}

	public function update($shop_id='',$data='')
	{
		$this->db->where('shop_id', $shop_id);
		return $this->db->update('shop_setup', $data);
	}
}

/* End of file Shop_model.php */
/* Location: ./application/models/Shop_model.php */