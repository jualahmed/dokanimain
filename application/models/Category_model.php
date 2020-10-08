<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function create($data='')
	{
		$this->db->insert('catagory_info',$data);
   	 	return $this->db->insert_id();
	}

	public function all()
	{
		$this->db->order_by('catagory_id', 'desc');
		return $this->db->get('catagory_info')->result();
	}

	public function destroy($id)
	{
		$this->db->where('catagory_id', $id);
		return $this->db->delete('catagory_info');
	}

	public function find($catagory_id='')
	{
		$this->db->where('catagory_id', $catagory_id);
		return $this->db->get('catagory_info')->row();
	}

	public function update($catagory_id='',$data='')
	{
		$this->db->where('catagory_id', $catagory_id);
		return $this->db->update('catagory_info', $data);
	}
}

/* End of file Category_model.php */
/* Location: ./application/models/Category_model.php */