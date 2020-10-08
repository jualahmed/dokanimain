<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class App_model extends CI_model{
	public function __construct()
	{
		parent::__construct();
    }

    public function getAppInfo()
    {
        return $this->db->select('*')->from('apps_info')->get()->row();
    }
}