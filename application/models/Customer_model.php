<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function create($data='')
	{
		$this->db->insert('customer_info',$data);
   	 	return $this->db->insert_id();
	}

	public function all()
	{
		return $this->db->get('customer_info')->result();
	}

	public function destroy($id)
	{
		$this->db->where('customer_id', $id);
		return $this->db->delete('customer_info');
	}

	public function find($customer_id='')
	{
		$this->db->where('customer_id', $customer_id);
		return $this->db->get('customer_info')->row();
	}

	public function update($customer_id='',$data='')
	{
		$this->db->where('customer_id', $customer_id);
		return $this->db->update('customer_info', $data);
	}

}

/* End of file Customer_model.php */
/* Location: ./application/models/Customer_model.php */