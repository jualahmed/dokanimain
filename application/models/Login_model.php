<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	class Login_model extends CI_model{
		
		/************************************
		* General User Information         **
		*************************************/
		function all_general_user()
		{
			$this -> db -> order_by('username',"asc");
			$this -> db -> select('users.id, users.username, user_full_name, users.user_type,users.user_type');
			$this -> db -> from('users');
			$this -> db -> where('users.user_type != "superadmin"');
			$query = $this -> db -> get();
			$temp[''] =  'Select a User Name';
			foreach ($query-> result() as $field){
				$temp[ base_url().'index.php/Login/user_information/'.$field -> username] = $field -> username.' ( '.$field -> user_full_name.' )';
			}
			return $temp;
		}
		
		/************************************
		* Specific User Information        **
		*************************************/
		function specific_user( $name )
		{
			$this -> db -> select('users.username,users.user_address,users.email,
								   users.user_type,users.id,user_full_name,created,
								   shop_name,shop_address');
			$this -> db -> from('users,shop_setup');
			$this -> db -> where('users.shop_id = shop_setup.shop_id');
			$this -> db -> where('users.user_type != "superadmin"');
			$this -> db -> where('users.username = "'.$name.'"');
			return $query = $this -> db -> get();
		}
	}
