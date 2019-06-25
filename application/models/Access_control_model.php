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
		function accountent_modify_controller( $function_name )
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
		function stockist_modify_controller( $function_name )
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
		function seller_modify_controller( $function_name )
		{
			switch( $function_name ){
				case 'sale_modify' 	: return true;
			    default				: return false;
			}
		}
		function seller_login_controller( $function_name )
		{
			switch( $function_name ){
				case 'user_information' : return false;
			    default				: return true;
			}
		}
		function seller_report_controller( $function_name )
		{
			switch( $function_name ){
				case 'customer_sale_report' : return true;
			    default	: return false;
			}
		}
		function seller_registration_controller( $function_name )
		{
			switch( $function_name ){
				case 'customer_registration' : return true;
			    default	: return false;
			}
		}
		/************************************************
		 * Manager Access on Modify Controller         *
		 ************************************************/
		function manager_modify_controller( $function_name )
		{
			switch( $function_name ){
				case 'alter_shop' 	: return true;
			    default				: return false;
			}
		}
		
		/************************************************
		 * Stockist Access on Registration Controller   *
		 ************************************************/
		function stockist_registration_controller( $function_name )
		{
			switch( $function_name ){
				case 'distributor_registration' 	 : return false;
				case 'customer_registration'         : return false;
				case 'service_provider_registration' : return false;
				case 'employee_salary_setup' 		 : return false;
			    default								 : return true;
			}
		}
		function stockist_report_controller( $function_name )
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
		function admin_registration_controller( $function_name )
		{
			switch( $function_name ){
				case 'shop_setup' 					 : return false;
			    default								 : return true;
			}
		}
		/************************************************
		 * Manager Access on Registration Controller   *
		 ************************************************/
		function manager_registration_controller( $function_name )
		{
			switch( $function_name ){
				case 'shop_setup' 					 : return false;
			    default								 : return true;
			}
		}
		/************************************************
		 * Accountent Access on Registration Controller   *
		 ************************************************/
		function accountent_registration_controller( $function_name )
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
					case 'account_controller' 			: return true;
					case 'auth' 			 			: return true;
					case 'expense_invoice_controller'	: return true;
					case 'login_controller'				: return true;
					case 'modify_controller'			: return true;
					case 'product_controller'			: return true;
					case 'registration_controller'		: return $this -> admin_registration_controller( $function_name );
					case 'report_controller'			: return true;
					case 'sale_controller'				: return true;
					case 'admin'				: return true;
					default 							: return false;
				}
				
			}
			else if( $user_type == 'manager')
			{
				switch( $controller_name ){
					case 'account_controller' 			: return true;
					case 'auth' 			 			: return true;
					case 'expense_invoice_controller'	: return true;
					case 'login_controller'				: return true;
					case 'modify_controller'			: return $this -> manager_modify_controller( $function_name );
					case 'product_controller'			: return true;
					case 'registration_controller'		: return $this -> manager_registration_controller( $function_name );
					case 'report_controller'			: return true;
					case 'sale_controller'				: return true;
					case 'admin'				: return true;
					default 							: return false;
				}
			}
			else if( $user_type == 'accountent')
			{
				switch( $controller_name ){
					case 'account_controller' 			: return true;
					case 'auth' 			 			: return true;
					case 'expense_invoice_controller'	: return true;
					case 'login_controller'				: return true;
					case 'modify_controller'			: return $this -> accountent_modify_controller( $function_name );
					case 'product_controller'			: return false;
					case 'registration_controller'		: return $this -> accountent_registration_controller( $function_name );
					case 'report_controller'			: return true;
					case 'sale_controller'				: return false;
					case 'admin'				: return true;
					default 							: return false;
				}
			}
			else if( $user_type == 'stockist')
			{
				switch( $controller_name ){
					case 'account_controller' 			: return false;
					case 'auth' 			 			: return true;
					case 'expense_invoice_controller'	: return true;
					case 'login_controller'				: return true;
					case 'modify_controller'			: return $this -> stockist_modify_controller( $function_name );
					case 'product_controller'			: return true;
					case 'registration_controller'		: return $this -> stockist_registration_controller( $function_name );
					case 'report_controller'			: return $this -> stockist_report_controller( $function_name );
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
					case 'expense_invoice_controller'	: return true;
					case 'login_controller'				: return $this -> seller_login_controller( $function_name );
					case 'modify_controller'			: return $this -> seller_modify_controller( $function_name );
					case 'product_controller'			: return false;
					case 'registration_controller'		: return $this -> seller_registration_controller( $function_name );
					case 'report_controller'			: return $this -> seller_report_controller( $function_name );
					case 'sale_controller'				: return true;
					case 'admin'				: return true;
					default 							: return false;
				}
			}
			else return false;
		}
	}
			

