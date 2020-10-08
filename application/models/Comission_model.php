<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comission_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function create(array $data)
	{
		$bd_date = date('Y-m-d');
		$current_year  = date('Y');
		$creator = $this->tank_auth->get_user_id();	
		$create_comission = array(
			'com_year ' => $current_year,
			'com_month ' => $data['com_month'],
			'com_amount ' => $data['com_amount'],
			'status ' => 1,	
			'creator' => $creator
		);		
		$insert = $this->db->insert('commison_info',$create_comission );
		return $this->db->insert_id();
	}

	public function all($value='')
	{
		return $this->db->get('commison_info')->result();
	}

}

/* End of file Comission_model.php */
/* Location: ./application/models/Comission_model.php */