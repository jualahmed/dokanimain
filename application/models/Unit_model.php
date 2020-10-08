<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function create($data='')
	{
		$this->db->insert('unit_info',$data);
   	 	return $this->db->insert_id();
	}

	public function all()
	{	$this->db->order_by('unit_id', 'desc');
		return $this->db->get('unit_info')->result();
	}

	public function destroy($id)
	{
		$this->db->where('unit_id', $id);
		return $this->db->delete('unit_info');
	}

	public function find($unit_id='')
	{
		$this->db->where('unit_id', $unit_id);
		return $this->db->get('unit_info')->row();
	}

	public function update($unit_id='',$data='')
	{
		$this->db->where('unit_id', $unit_id);
		return $this->db->update('unit_info', $data);
	}

}

/* End of file Unit_model.php */
/* Location: ./application/models/Unit_model.php */