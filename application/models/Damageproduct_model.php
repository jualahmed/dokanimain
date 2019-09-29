<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Damageproduct_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function create($data='')
	{
		$this->db->insert('damage_product',$data);
   	 	return $this->db->insert_id();
	}

	public function all()
	{	$this->db->order_by('damage_id', 'desc');
		return $this->db->get('damage_product')->result();
	}

	public function destroy($id)
	{
		$this->db->where('damage_id', $id);
		return $this->db->delete('damage_product');
	}

	public function find($damage_id='')
	{
		$this->db->where('damage_id', $damage_id);
		return $this->db->get('damage_product')->row();
	}

	public function update($damage_id='',$data='')
	{
		$this->db->where('damage_id', $damage_id);
		return $this->db->update('damage_product', $data);
	}
}

/* End of file Damageproduct_model.php */
/* Location: ./application/models/Damageproduct_model.php */