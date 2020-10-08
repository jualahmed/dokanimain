<?php
/****************************************
 * Access controlling of diffrent Users *
 ****************************************/
 ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Access_control_model extends CI_model{

		/************************************************
		 * Accountent Access on Modify Controller       *
		 ************************************************/
		function accountent_modify( $function_name )
		{
			switch( $function_name ){
				case 'distributor_modify' 		   : return true;
				case 'total_purchase_price_modify' : return true;
			    default							   : return false;
			}
		}
		
		/************************************************
		 * Stockist Access on Modify Controller         *
		 ************************************************/
		function stockist_modify( $function_name )
		{
			switch( $function_name ){
				case 'distributor_modify' 		   : return false;
				case 'sale_modify'				   : return false;
				case 'total_purchase_price_modify' : return false;
				case 'registered_customer_modify'  : return false;
				case 'alter_shop'  				   : return false;
				case 'salary_modify'  			   : return false;
				case 'cheque_status_modify'  	   : return false;
			    default					 		   : return true;
			}
		}
		/************************************************
		 * Stockist Access on Modify Controller         *
		 ************************************************/
		function seller_modify( $function_name )
		{
			switch( $function_name ){
				case 'sale_modify' 	: return true;
			    default				: return false;
			}
		}
		function seller_Login( $function_name )
		{
			switch( $function_name ){
				case 'user_information' : return false;
			    default				: return true;
			}
		}
		function seller_Report( $function_name )
		{
			switch( $function_name ){
				case 'customer_sale_report' : return true;
			    default	: return false;
			}
		}
		function seller_Registration( $function_name )
		{
			switch( $function_name ){
				case 'customer_registration' : return true;
			    default	: return false;
			}
		}
		/************************************************
		 * Manager Access on Modify Controller         *
		 ************************************************/
		function manager_modify( $function_name )
		{
			switch( $function_name ){
				case 'alter_shop' 	: return true;
			    default				: return false;
			}
		}
		
		/************************************************
		 * Stockist Access on Registration Controller   *
		 ************************************************/
		function stockist_Registration( $function_name )
		{
			switch( $function_name ){
				case 'distributor_registration' 	 : return false;
				case 'customer_registration'         : return false;
				case 'service_provider_registration' : return false;
				case 'employee_salary_setup' 		 : return false;
			    default								 : return true;
			}
		}
		function stockist_Report( $function_name )
		{
			switch( $function_name ){
				case 'supply_by_distributor' 		 : return true;
			    case 'purchase_receipt' 	   		 : return true;
			    case 'stock_status_on_specific_date' : return true;
			    default								 : return false;
			}
		}
		
		/************************************************
		 * admin Access on Registration Controller   *
		 ************************************************/
		function admin_Registration( $function_name )
		{
			switch( $function_name ){
				case 'shop_setup' 					 : return false;
			    default								 : return true;
			}
		}
		/************************************************
		 * Manager Access on Registration Controller   *
		 ************************************************/
		function manager_Registration( $function_name )
		{
			switch( $function_name ){
				case 'shop_setup' 					 : return false;
			    default								 : return true;
			}
		}
		/************************************************
		 * Accountent Access on Registration Controller   *
		 ************************************************/
		function accountent_Registration( $function_name )
		{
			switch( $function_name ){
				case 'distributor_registration' 	 : return true;
				case 'service_provider_registration' : return true;
			    default								 : return false;
			}
		}
		/*******************************
		 * Function to receive Request *
		 *******************************/
		function my_access($user_type, $controller_name, $function_name)
		{
			if($user_type == 'superadmin') return true;
			else if($user_type == 'admin')
			{
				switch( $controller_name ){
					case 'account' 			: return true;
					case 'auth' 			 			: return true;
					case 'expenseinvoice'	: return true;
					case 'Login'				: return true;
					case 'modify'			: return true;
					case 'Product'			: return true;
					case 'Registration'		: return $this -> admin_Registration( $function_name );
					case 'Report'			: return true;
					case 'sale_controller'				: return true;
					case 'admin'				: return true;
					default 							: return false;
				}
				
			}
			else if( $user_type == 'manager')
			{
				switch( $controller_name ){
					case 'account' 			: return true;
					case 'auth' 			 			: return true;
					case 'expenseinvoice'	: return true;
					case 'Login'				: return true;
					case 'modify'			: return $this -> manager_modify( $function_name );
					case 'Product'			: return true;
					case 'Registration'		: return $this -> manager_Registration( $function_name );
					case 'Report'			: return true;
					case 'sale_controller'				: return true;
					case 'admin'				: return true;
					default 							: return false;
				}
			}
			else if( $user_type == 'accountent')
			{
				switch( $controller_name ){
					case 'account' 			: return true;
					case 'auth' 			 			: return true;
					case 'expenseinvoice'	: return true;
					case 'Login'				: return true;
					case 'modify'			: return $this -> accountent_modify( $function_name );
					case 'Product'			: return false;
					case 'Registration'		: return $this -> accountent_Registration( $function_name );
					case 'Report'			: return true;
					case 'sale_controller'				: return false;
					case 'admin'				: return true;
					default 							: return false;
				}
			}
			else if( $user_type == 'stockist')
			{
				switch( $controller_name ){
					case 'account' 			: return false;
					case 'auth' 			 			: return true;
					case 'expenseinvoice'	: return true;
					case 'Login'				: return true;
					case 'modify'			: return $this -> stockist_modify( $function_name );
					case 'Product'			: return true;
					case 'Registration'		: return $this -> stockist_Registration( $function_name );
					case 'Report'			: return $this -> stockist_Report( $function_name );
					case 'sale_controller'				: return false;
					case 'admin'				: return true;
					default 							: return false;
				}
			}
			else if( $user_type == 'seller')
			{
				switch( $controller_name ){
					case 'accuont_controller' 			: return false;
					case 'auth' 			 			: return true;
					case 'expenseinvoice'	: return true;
					case 'Login'				: return $this -> seller_Login( $function_name );
					case 'modify'			: return $this -> seller_modify( $function_name );
					case 'Product'			: return false;
					case 'Registration'		: return $this -> seller_Registration( $function_name );
					case 'Report'			: return $this -> seller_Report( $function_name );
					case 'sale_controller'				: return true;
					case 'admin'				: return true;
					default 							: return false;
				}
			}
			else return false;
		}
	}
			

