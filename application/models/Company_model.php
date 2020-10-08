<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function create($data='')
	{
		$this->db->insert('company_info',$data);
   	 	return $this->db->insert_id();
	}

	public function all()
	{	$this->db->order_by('company_id', 'desc');
		return $this->db->get('company_info')->result();
	}

	public function destroy($id)
	{
		$this->db->where('company_id', $id);
		return $this->db->delete('company_info');
	}

	public function find($company_id='')
	{
		$this->db->where('company_id', $company_id);
		return $this->db->get('company_info')->row();
	}

	public function update($company_id='',$data='')
	{
		$this->db->where('company_id', $company_id);
		return $this->db->update('company_info', $data);
	}

}

/* End of file Company_model.php */
/* Location: ./application/models/Company_model.php */