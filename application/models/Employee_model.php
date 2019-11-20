<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function create($data='')
	{
		$this->db->insert('employee_info',$data);
   	 	return $this->db->insert_id();
	}

	public function all()
	{
		return $this->db->get('employee_info')->result();
	}

	public function destroy($id)
	{
		$this->db->where('employee_id', $id);
		return $this->db->delete('employee_info');
	}

	public function find($employee_id='')
	{
		$this->db->where('employee_id', $employee_id);
		return $this->db->get('employee_info')->row();
	}

	public function update($employee_id='',$data='')
	{
		$this->db->where('employee_id', $employee_id);
		return $this->db->update('employee_info', $data);
	}

}

/* End of file Employee_model.php */
/* Location: ./application/models/Employee_model.php */