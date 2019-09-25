<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function all_user()
	{
		$usertype = $this -> tank_auth -> get_usertype();
		$this -> db -> order_by('username',"asc");
		$this -> db -> select('users.id, users.username, user_full_name, users.user_type,users.user_type');
		$this -> db -> from('users');
		if($usertype == 'manager')
		{
			$this -> db -> where('users.user_type = "seller"');
			$this -> db -> or_where('users.user_type = "stockist"');
			$this -> db -> or_where('users.user_type = "accountent"');
		}
		else if($usertype == 'admin')
			{
				$this -> db -> where('users.user_type = "manager" ');
				$this -> db -> or_where('users.user_type = "accountent"');
				$this -> db -> or_where('users.user_type = "seller" ');
				$this -> db -> or_where('users.user_type = "stockist"');
			}
		if($usertype == 'superadmin')
		{
			$this -> db -> where('users.user_type = "superadmin" ');
			$this -> db -> or_where('users.user_type = "admin"');
			$this -> db -> or_where('users.user_type = "manager"');
			$this -> db -> or_where('users.user_type = "accountent"');
			$this -> db -> or_where('users.user_type = "seller"');
			$this -> db -> or_where('users.user_type = "stockist"');				 
		}
		$query = $this -> db -> get();
		$data[''] =  'Select a User Name';
		foreach ($query-> result() as $field){
			$data[ base_url().'admin/user_modification/'.$field -> username] = $field -> username.' ( '.$field -> user_full_name.' )';
		}
		return $data;
	}
	
	public function specific_user()
	{
		$name = $this -> uri -> segment(3);
		$usertype = $this -> tank_auth -> get_usertype();
		$this -> db -> select('users.username,users.user_address,users.email,users.user_type,users.id,user_full_name');
		$this -> db -> from('users');
		$this -> db -> where('users.username = "'.$name.'"');
		$query = $this -> db -> get();
		
		foreach($query -> result() as $check):
			$type = $check -> user_type;
			if($usertype == 'manager')
			{
				if($type == 'seller' || $type == 'stockist' || $type == 'accountent') return $query;
				else
				{
					$this -> db -> select('users.username,users.user_address,users.email,users.user_type');
					$this -> db -> from('users');
					$this -> db -> where('users.username = ""');
					$query = $this -> db -> get();
				}
			}
			else if($usertype == 'admin')
			{
				if($type == 'seller' || $type == 'stockist' || $type == 'accountent' || $type == 'manager') return $query;
				else
				{
					$this -> db -> select('users.username,users.user_address,users.email,users.user_type');
					$this -> db -> from('users');
					$this -> db -> where('users.username = ""');
					$query = $this -> db -> get();
				}
			}
			else if($usertype == 'superadmin')
			{
				if($type == 'seller' || $type == 'stockist' || $type == 'accountent' || $type == 'manager' || $type == 'admin' || $type = 'superadmin') return $query;
				else
				{
					$this -> db -> select('users.username,users.user_address,users.email,users.user_type');
					$this -> db -> from('users');
					$this -> db -> where('users.username = ""');
					$query = $this -> db -> get();
				}			 
			}
		endforeach;
		
		return $query;
    }

	public function update_user($hashed_password,$new_password)
	{
		$username 		= $this -> input -> post('username');
		$u_id 			= $this -> input -> post('ch_id');
		$new_type 			= $this -> input -> post('new_user_type');
		$contact 			= $this -> input -> post('email');
		$user_add 			= $this -> input -> post('user_address');
		$user_full_name 	= $this -> input -> post('user_full_name');
		
		$user_up = array(
			'username'     	=> $username,
			'user_type'    	=> $new_type,
			'password'        	=> $hashed_password,
			'password2'        	=> $new_password,
			'email'        	=> $contact,
			'user_address' 	=> $user_add,
			'user_full_name' => $user_full_name
		);
		
		$this->db->where('id', $u_id);
		$up = $this->db->update('users', $user_up);
		return $up;
	}

	public function backup_database()
	{
		$bd_date = date('Y-m-d');
		$this->load->dbutil();
		if ($this->dbutil->database_exists('dokani'))
		{
		   $prefs = array(
				'tables'      => array(),              // Array of tables to backup.
				'format'      => 'txt',                // gzip, zip, txt
				'add_drop'    => TRUE,                 // Whether to add DROP TABLE statements to backup file
				'add_insert'  => TRUE,                 // Whether to add INSERT data to backup file
				'newline'     => "\n"                  // Newline character used in backup file
			);
			$backup =& $this->dbutil->backup($prefs);
			$path = "D:\\dokani_backup\\".$bd_date;    // For Windows
		    if(!is_dir($path))                         //create the folder if it's not already exists
		    {
		      mkdir($path,0700,TRUE);
		    } 
			$this->load->helper('file');
			write_file($path.'\\dokani.sql', $backup); // For Windows
			return true;
		}
		return false;
	}
}

/* End of file Admin_model.php */
/* Location: ./application/models/Admin_model.php */