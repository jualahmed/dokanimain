<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bankcard_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function create_bank($data='')
	{
		$this->db->insert('bank_info',$data);
   	 	return $this->db->insert_id();
	}

	public function all()
	{
		return $this->db->get('bank_info')->result();
	}

	public function destroy($id)
	{
		$this->db->where('bank_id', $id);
		return $this->db->delete('bank_info');
	}

	public function find($bank_id='')
	{
		$this->db->where('bank_id', $bank_id);
		return $this->db->get('bank_info')->row();
	}

	public function update($bank_id='',$data='')
	{
		$this->db->where('bank_id', $bank_id);
		return $this->db->update('bank_info', $data);
	}

	// card info
	public function cardall()
	{
		return $this->db->get('bank_card_info');
	}
}

/* End of file Bankcard_model.php */
/* Location: ./application/models/Bankcard_model.php */