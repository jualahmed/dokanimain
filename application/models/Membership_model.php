<<<<<<< HEAD
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
class Membership_model extends CI_model{
	
	function validate()
	{
		$this -> db -> where('user_name', $this -> input -> post('username'));
		$this -> db -> where('user_password', $this -> input -> post('password'));
		//$this -> db -> select('user_name,user_type,user_id')
		            
		$query = $this -> db -> get('user_info');
		
		/*if($query -> num_rows == 1)
		{
			return true;
		}*/
		return $query;
    }
=======
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
class Membership_model extends CI_model{
	
	function validate()
	{
		$this -> db -> where('user_name', $this -> input -> post('username'));
		$this -> db -> where('user_password', $this -> input -> post('password'));
		//$this -> db -> select('user_name,user_type,user_id')
		            
		$query = $this -> db -> get('user_info');
		
		/*if($query -> num_rows == 1)
		{
			return true;
		}*/
		return $query;
    }
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
}