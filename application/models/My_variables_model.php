<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class My_variables_model extends CI_model
{

	  function my_variables()
	  {
	  				  				  					  
        $data['transaction_type']= array(
			    ''  => 'Select A Type',
			   'cash' => 'Cash',
			   'cheque' => 'Cheque'
	    );
	    $data['transaction_type_for_bb']= array(
			    ''  => 'Select A Type',
			   'in' => 'In',
			   'out' => 'Out',
			   'transfer' => 'Transfer'
	    );
		
	    
	    $data['type_name'] = array(
			    ''  => 'Select A Type Name',
			   'Expense' => 'Expense',
	    );
	    return $data;
	  }
      /* fatch all expense type*/
	  function fatch_expense_type()
	  {  				
	    $query = $this -> db -> get('type_info');
		$data[''] =  'Select A Type';
		
		foreach ($query-> result() as $field)
		{
			    //$temp = preg_replace('/\s+/', '~',$field->catagory_name);
				$data[$field -> type_id] = $field -> type_type;
	    }
		return $data;	  	
	  }

	  function fatch_all_bank()
	  {  				
		    $query = $this -> db -> get('bank_info');
			$data[''] =  'Select A Bank';
			foreach ($query-> result() as $field)
			{
				    //$temp = preg_replace('/\s+/', '~',$field->catagory_name);
					$data[$field -> bank_id] = $field -> bank_name;
		    }
			return $data;
	  }
	  
      /* fatch all expense type*/
	  function all_expense_type_info()
	  { 
				$this -> db ->select('type_type');
		    $query = $this -> db -> get('type_info');
			if($query->num_rows() > 0){
				$data = $query->result_array();
			}
			//print_r($data);
			return $data;
				  	
	  }
      /* fatch service provider information*/
	  function fatch_service_provider_info()
	  {
	  $user_id = $this->tank_auth->get_user_id();
	  	    //$query = $this -> db -> get('service_provider_info');
	  	    $this -> db -> order_by("service_provider_name","asc");
	  	    $query = $this -> db -> select('*')
								 //-> where('id = "'.$user_id.'"')
			                     -> from('service_provider_info')
								 -> get();
								 
			$data[''] =  'Select A Name';
			foreach ($query-> result() as $field){
					$data[$field -> service_provider_id] = $field -> service_provider_name.nbs(5).'( Mob : '.$field -> service_provider_contact.')';
				}
			return $data;
	  }
	  /* fatch service provider information*/
	  function employee_info()
	  {
	  $user_id = $this->tank_auth->get_user_id();
	  	    //$query = $this -> db -> get('service_provider_info');
	  	    $this -> db -> order_by("employee_name","asc");
	  	    $query = $this -> db -> select('*')
								 //-> where('id = "'.$user_id.'"')
			                     -> from('employee_info')
								 -> get();
								 
			$data[''] =  'Select A Employee';
			foreach ($query-> result() as $field){
					$data[$field -> employee_id] = $field -> employee_name;
				}
			return $data;
	  }
	  /* for sale mode */
	  function  select_sale_mode()
	  {
		    $data = array(
			    ''  => 'Select A Mode',
			     base_url().'index.php/sale_controller/sale_information/credit_sale' => 'Credit Sale',
			     //base_url().'index.php/sale_controller/sale_information/new_customer' => 'New Customer',
			     //base_url().'index.php/sale_controller/sale_information/quick_sale' => 'Quick Sale',
			     //base_url().'index.php/sale_controller/sale_information/listed_customers' => 'Listed Customers'
            );
		    return $data;
	  }
	  
      /* for transaction mode*/
      function fatch_gift_mode()
      {
		   $seg = $this -> uri -> segment(4);
		   $data = array(
			    ''  => 'Select A Mode',
			    // 'cash' => 'Cash',
			     base_url().'index.php/account/transaction_entry/transfer/'.$seg.'/cash' => 'Cash',
			     base_url().'index.php/account/transaction_entry/transfer/'.$seg.'/cheque' => 'Cheque'
            );
		    return $data;
	  }
	  
	  /**************************************
	   * Sale Running Mode Selection              *
	   * *************************************/
	  function sale_running_mode_array()
	  {
		   $data = array(
			    ''  => 'Select A Mode',
			    // 'cash' => 'Cash',
			     base_url().'index.php/sale_controller/set_sale_running_mode/whole_sale' => 'Whole Sale',
			     base_url().'index.php/sale_controller/set_sale_running_mode/retail_sale' => 'Retail Sale'
            );
		    return $data;
	  }
	  
	   /* for cheque Type*/
	  function fatch_cheque_type()
	  {
			$data = array(
					''  => 'Select A Type',
					base_url().'index.php/account/cheque_entry/in' => 'In',
					base_url().'index.php/account/cheque_entry/out' => 'Out',
					base_url().'index.php/account/cheque_entry/transfer' => 'Transfer',
			);
			return $data;
	  }

	  /* change cheque status dropdown */
	  function fatch_all_cheque_change_status_purpose($total_paid, $cheque_amount,$cheque_status)
	  {
		    $segment_3 = $this -> uri -> segment(3);	    
		    // $segment_1 = $this -> uri -> segment(1);	    
			if($this -> uri -> segment(1) == 'account')
			{
				
				if($cheque_status == 'recovering' || $cheque_status == 'recovered')
				{
					$data = array(
							''  => 'Select A Status',
							//base_url().'index.php/account/change_cheque_status_entry/'.$segment_3.'/honore' => 'Honore',
							//base_url().'index.php/account/change_cheque_status_entry/'.$segment_3.'/dishonore' => 'Dishonore',
							//base_url().'index.php/account/change_cheque_status_entry/'.$segment_3.'/changeDate' => 'Change Cheque Date',
					);
					return $data;
				}
				else if($cheque_amount == $total_paid && $cheque_status != 'honored') 
				{
					$data = array(
							''  => 'Select A Status',
							base_url().'index.php/account/change_cheque_status_entry/'.$segment_3.'/changeDate' => 'Change Cheque Date',
							base_url().'index.php/account/change_cheque_status_entry/'.$segment_3.'/dishonore' => 'Dishonore',
							base_url().'index.php/account/change_cheque_status_entry/'.$segment_3.'/honore' => 'Honore',
					);
					return $data;
				}
				else if($cheque_status == 'honored' || $cheque_status == 'dishonored')
				{
					$data = array(
							''  => 'Select A Status',
							//base_url().'index.php/account/change_cheque_status_entry/'.$segment_3.'/honore' => 'Honore',
							//base_url().'index.php/account/change_cheque_status_entry/'.$segment_3.'/dishonore' => 'Dishonore',
							//base_url().'index.php/account/change_cheque_status_entry/'.$segment_3.'/changeDate' => 'Change Cheque Date',
					);
					return $data;
				}
				else
				{
					$data = array(
							''  => 'Select A Status',
							//base_url().'index.php/account/change_cheque_status_entry/'.$segment_3.'/honore' => 'Honore',
							base_url().'index.php/account/change_cheque_status_entry/'.$segment_3.'/changeDate' => 'Change Cheque Date',
							base_url().'index.php/account/change_cheque_status_entry/'.$segment_3.'/dishonore' => 'Dishonore',
					);
					return $data;
				}
			}
			else if( $this -> uri -> segment(1) == 'Report' &&  $this -> uri -> segment(2) == 'all_cheque_detials' )
			{
				$data = array(
						''  => 'Select A Status',
						base_url().'index.php/Report/all_cheque_detials/dishonored/bystatus' => 'Dishonore',
						base_url().'index.php/Report/all_cheque_detials/honored/bystatus' => 'Honore',
						base_url().'index.php/Report/all_cheque_detials/pending/bystatus' => 'Pending',
						
				);
				return $data;
			}
			else
			{
				$data = array(
						''  => 'Select A Status',
						base_url().'index.php/modify/cheque_status_modify/'.$segment_3.'/changeDate' => 'Change Cheque Date',
						base_url().'index.php/modify/cheque_status_modify/'.$segment_3.'/dishonore' => 'Dishonore',
						base_url().'index.php/modify/cheque_status_modify/'.$segment_3.'/honore' => 'Honore',
						base_url().'index.php/modify/cheque_status_modify/'.$segment_3.'/pending' => 'Pending',
						
				);
				return $data;
			}
	  }
	   /* fatch investor information*/
	  function fatch_investor_info()
	  {
	  	    $this->db->order_by("investor_name", "asc");
	  	    $query = $this -> db -> select('investor_name,investor_id,investor_contact_no')
			                     -> from('investor_info')
								 ->get();
								 
			$data[''] =  'Select A Name';
			foreach ($query-> result() as $field){
					$data[$field -> investor_id] = $field -> investor_name.nbs(5).'( Mob : '.$field -> investor_contact_no.' ) ';
				}
			return $data;
	  }
	   /* *****************************
	   * For Cheque Details 
	   * 
	   * Section: Accounts & Report
	   * **************************** */
	  function select_cheque_mode()
	  {
		    $data = array(
			    ''  => 'Select A Mode',
			     base_url().'index.php/Report/all_cheque_detials/in/bymode' => 'In',
			     base_url().'index.php/Report/all_cheque_detials/out/bymode' => 'Out',
			     base_url().'index.php/Report/all_cheque_detials/ToBank/bymode' => 'To Bank',
			     base_url().'index.php/Report/all_cheque_detials/FromBank/bymode' => 'From Bank'
            );
		    return $data;
	  }
	  
	  	

}
