<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distributor_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function create($data='')
	{
		$this->db->insert('distributor_info',$data);
   	 	return $this->db->insert_id();
	}

	public function all()
	{
		return $this->db->get('distributor_info')->result();
	}

	public function destroy($id)
	{
		$this->db->where('distributor_id', $id);
		return $this->db->delete('distributor_info');
	}

	public function find($distributor_id='')
	{
		$this->db->where('distributor_id', $distributor_id);
		return $this->db->get('distributor_info')->row();
	}

	public function update($distributor_id='',$data='')
	{
		$this->db->where('distributor_id', $distributor_id);
		return $this->db->update('distributor_info', $data);
	}

}

/* End of file Distributor_model.php */
/* Location: ./application/models/Distributor_model.php */