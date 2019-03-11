<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	class Site_model extends CI_model{
			
			private $shop_id;
			
			function __construct()
			{
				$this -> shop_id = $this -> tank_auth -> get_shop_id();
			}
			/* Select All Stock */
			function all_stock($per_page)
			{
				/****PREVIOUS */
				/*
				$query = $this -> db -> select('product_info.product_id, product_info.product_name,
												 count( product_info.product_name ) as number_of_quantity')
									 -> from('product_info, purchase_info, stock_info')
									 -> where('stock_info.stock_status = "stocked"')
									 -> where('purchase_info.purchase_id = stock_info.purchase_id')
									 -> where('purchase_info.product_id = product_info.product_id')
									 -> group_by('product_info.product_name')
									 -> limit($per_page, $this -> uri -> segment(3))
		                  			 -> get();
			/* END PREVIOUS			*/
				$query = $this -> db -> select('product_info.product_id, product_info.product_name, product_info.unit_name,
												bulk_stock_info.stock_amount, bulk_unit_sale_price as unit_sale_price,
												bulk_stock_info.bulk_unit_buy_price')
									 -> from('product_info, bulk_stock_info')
									 -> where('bulk_stock_info.shop_id', $this -> shop_id)
									 -> where('product_info.product_id = bulk_stock_info.product_id')
									 -> group_by('product_info.product_name')
									 -> limit($per_page, $this -> uri -> segment(3))
		                  			 -> get();
			  	return $query;
			}
			
			function all_stock_no_of_rows()
			{
				/****PREVIOUS */
				/*$query = $this -> db -> query ("SELECT product_info.product_id
											FROM product_info, purchase_info, stock_info
											WHERE stock_info.stock_status = 'stocked' 
											AND purchase_info.purchase_id = stock_info.purchase_id
											AND purchase_info.product_id = product_info.product_id
											GROUP BY product_info.product_name");
				/* END PREVIOUS			*/
			  	/*foreach ($query->result() as $field):
				   $data = $field -> number_of_quantity;
			    endforeach;*/
			    
			   /* END PREVIOUS			*/
			   $query = $this -> db -> select('product_info.product_id, product_info.product_name,
												bulk_stock_info.stock_amount, bulk_stock_info.bulk_unit_buy_price')
									 -> from('product_info, bulk_stock_info')
									 -> where('bulk_stock_info.shop_id', $this -> shop_id)
									 -> where('product_info.product_id = bulk_stock_info.product_id')
									 -> group_by('product_info.product_name')
		                  			 -> get();
			   return $data = $query -> num_rows(); 
			}
			
			function total_stock_price()
			{
				$query = $this -> db -> select('SUM( bulk_stock_info.stock_amount * bulk_stock_info.bulk_unit_buy_price) AS total_stock_price')
									 -> from('bulk_stock_info')
									 -> where('bulk_stock_info.shop_id', $this -> shop_id)
		                  			 -> get();
				if( $query -> num_rows() > 0){
					$row = $query -> row();
					return $row->total_stock_price;
				}
				else{
					return 0;
				}
			}
			
			function total_stock_sale_price()
			{
				$query = $this -> db -> select('SUM(bulk_stock_info.stock_amount * bulk_stock_info.bulk_unit_sale_price) AS total_stock_sale_price')
									 -> from('bulk_stock_info')
									 -> where('bulk_stock_info.shop_id', $this -> shop_id)
		                  			 -> get();
				if( $query -> num_rows() > 0){
					$row = $query -> row();
					return $row->total_stock_sale_price;
				}
				else{
					return 0;
				}
			}
			
			function total_stock_quantity()
			{
				$query = $this -> db -> select('SUM( bulk_stock_info.stock_amount) AS total_stock_quantity')
									 -> from('bulk_stock_info')
									 -> where('bulk_stock_info.shop_id', $this -> shop_id)
		                  			 -> get();
				if( $query -> num_rows() > 0){
					$row = $query -> row();
					return $row->total_stock_quantity;
				}
				else{
					return 0;
				}
			}
			
			function total_buy_quantity($start,$end,$product_id,$flag){
				//echo $start.'////'.$end;
				if($flag == 1){
					$this->db->select_sum('purchase_quantity');
				}
				else if($flag == 2){
					$this->db->select_avg('unit_buy_price');
				}
				$this->db->from('purchase_info,purchase_receipt_info');
				$this->db->where('purchase_info.product_id',$product_id);
				$this->db->where('purchase_info.purchase_receipt_id = purchase_receipt_info.receipt_id');
				$this->db->where('purchase_receipt_info.receipt_date >= "'.$start.'" ');
				$this->db->where('purchase_receipt_info.receipt_date <= "'.$end.'" ');
				$this->db->group_by('purchase_info.product_id');
				$query = $this->db->get();
				$row = $query->row();
				if(count($row) > 0){
					if($flag == 1){return $row->purchase_quantity;}
					else if($flag == 2){return $row->unit_buy_price;}
				}
				else{
					return 0;
				}
			}
			
			
			function exact_total_buy_quantity($start,$end){

				$this->db->select_sum('purchase_info.purchase_quantity');

				$this->db->from('purchase_info,purchase_receipt_info');
				$this->db->where('purchase_info.purchase_receipt_id = purchase_receipt_info.receipt_id');
				$this->db->where('purchase_receipt_info.receipt_date >= "'.$start.'" ');
				$this->db->where('purchase_receipt_info.receipt_date <= "'.$end.'" ');
				//$this->db->group_by('purchase_info.product_id');
				$query = $this->db->get();
				$row = $query->row();
				if(count($row) > 0){
					return $row->purchase_quantity;
				}
				else{
					return 0;
				}
			}
			
			function total_sale_quantity($start,$end,$product_id,$flag){
				if($flag == 1){
					$this->db->select_sum('sale_quantity');
				}
				else if($flag == 2){
					$this->db->select_avg('unit_sale_price');
				}
				$this->db->from('invoice_info,sale_details');
				$this->db->where('sale_details.product_id',$product_id);
				$this->db->where('invoice_info.invoice_id = sale_details.invoice_id');
				$this->db->where('invoice_info.invoice_doc >= "'.$start.'" ');
				$this->db->where('invoice_info.invoice_doc <= "'.$end.'" ');
				$this->db->group_by('sale_details.product_id');
				$query = $this->db->get();
				$row = $query->row();
				if(count($row) > 0){
					if($flag == 1){return $row->sale_quantity;}
					else if($flag == 2){return $row->unit_sale_price;}
				}
				else{
					return 0;
				}
			}
			
			function exact_total_sale_quantity($start,$end){

				$this->db->select_sum('sale_quantity');
				$this->db->from('invoice_info,sale_details');
				$this->db->where('invoice_info.invoice_id = sale_details.invoice_id');
				$this->db->where('invoice_info.invoice_doc >= "'.$start.'" ');
				$this->db->where('invoice_info.invoice_doc <= "'.$end.'" ');
				//$this->db->group_by('sale_details.product_id');
				$query = $this->db->get();
				$row = $query->row();
				if(count($row) > 0){
					return $row->sale_quantity;
				}
				else{
					return 0;
				}
			}
			
			function exact_total_sale_price($start,$end){

				$this->db->select( ' SUM(sale_quantity * actual_sale_price) AS exact_total_sale_price');
				$this->db->from('invoice_info,sale_details');
				$this->db->where('invoice_info.invoice_id = sale_details.invoice_id');
				$this->db->where('invoice_info.invoice_doc >= "'.$start.'" ');
				$this->db->where('invoice_info.invoice_doc <= "'.$end.'" ');
				//$this->db->group_by('sale_details.product_id');
				$query = $this->db->get();
				$row = $query->row();
				if(count($row) > 0){
					return $row->exact_total_sale_price;
				}
				else{
					return 0;
				}
			}
			
			
			function all_damage_stock_no_of_rows()
			{
				/****PREVIOUS */
				/*$query = $this -> db -> query ("SELECT product_info.product_id
											FROM product_info, purchase_info, stock_info
											WHERE stock_info.stock_status = 'stocked' 
											AND purchase_info.purchase_id = stock_info.purchase_id
											AND purchase_info.product_id = product_info.product_id
											GROUP BY product_info.product_name");
				/* END PREVIOUS			*/
			  	/*foreach ($query->result() as $field):
				   $data = $field -> number_of_quantity;
			    endforeach;*/
			    
			   /* END PREVIOUS			*/
			   $query = $this -> db -> select('product_info.product_id, product_info.product_name,
												damage_product.damage_quantity, damage_product.unit_buy_price')
									 -> from('product_info, damage_product')
									 -> where('product_info.product_id = damage_product.product_id')
									 -> group_by('product_info.product_name')
		                  			 -> get();
			   return $data = $query -> num_rows(); 
			}
			function all_damage_stock($per_page)
			{
				/****PREVIOUS */
				/*$query = $this -> db -> query ("SELECT product_info.product_id
											FROM product_info, purchase_info, stock_info
											WHERE stock_info.stock_status = 'stocked' 
											AND purchase_info.purchase_id = stock_info.purchase_id
											AND purchase_info.product_id = product_info.product_id
											GROUP BY product_info.product_name");
				/* END PREVIOUS			*/
			  	/*foreach ($query->result() as $field):
				   $data = $field -> number_of_quantity;
			    endforeach;*/
			    
			   /* END PREVIOUS			*/
			   $query = $this -> db -> select('product_info.product_id, product_info.product_name,
												damage_product.damage_quantity, damage_product.unit_buy_price')
									 -> from('product_info, damage_product')
									 -> where('product_info.product_id = damage_product.product_id')
									 -> group_by('product_info.product_name')
									 -> limit($per_page, $this -> uri -> segment(3))
		                  			 -> get();
			  	return $query;
				}
			
			
		  /*Product Specification BULK /  INDIVIDUAL */
		   function product_specification($pro_id)
		   {
		   		$query = $this -> db -> select('product_info.product_specification')
		   							 -> from('product_info')
		   							 -> where('product_specification = "individual"')
		   							 -> where('product_info.product_id = "'.$pro_id.'"')
		   							 -> get();
		   		return $data = $query -> num_rows(); 				 
		   }
		  /* returns no of stocked items of a specific Product */
		  function by_product_name_result_no_of_row($pro_id)
		  {
		
		  	  $query = $this->db->query ("SELECT count( product_info.product_name ) as number_of_row
						FROM product_info, stock_info
						WHERE ( stock_info.stock_status = 'stocked' 
						OR stock_info.stock_status = 'returned' )
						AND product_info.product_id = stock_info.product_id
						AND shop_id = ".$this -> shop_id."
					    AND product_info.product_id = '".$pro_id."' ");
			  
			  foreach ($query->result() as $field):
				   $data = $field -> number_of_row;
			  endforeach;
			  return $data;  
		 }
		 
		 function specific_sold_product_details_bulk( $product_id )
		 {
			 
			  $query = $this -> db -> select('product_name,  bulk_stock_info.bulk_unit_sale_price, bulk_stock_info.bulk_unit_buy_price,product_info.product_id')
										-> from('product_info , bulk_stock_info')
										-> where('product_info.product_id = "'.$product_id.'"')
										-> where('product_info.product_id = bulk_stock_info.product_id')
										-> where('bulk_stock_info.shop_id', $this -> shop_id)
										-> get();
										
			return $query;
		 }
		 
		 /********************************************
		  * SHELF INFORMATION OF A SPECIFIC PRODUCT *
		  *******************************************/
		  function get_shelf_info_of_a_product( $pro_id )
		  {
		  	$this -> db -> select('cell_no');
			$this -> db -> from('product_position_info');
			$this -> db -> where('product_id = "'.$pro_id.'"');
			$query = $this -> db -> get();
			return $query;
		  }
		 
		 
		  /* returns Stocked list of a specific product*/
		  function by_product_name_result($pro_id , $per_page)
		  {
			 /* $condition = "stock_info.stock_status = 'stocked'  OR stock_info.stock_status = 'returned'";
		  	  $query = $this->db->select('stock_info.stock_id, receipt_date , product_name, serial_no, unit_sale_price')
		                  			->from('stock_info,purchase_info,product_info, purchase_receipt_info,sale_price_info')
		                  			->where('product_info.product_id = "'.$pro_id.'"')
		                  			
						  			->where('purchase_info.product_id = product_info.product_id')
		                  			->where('purchase_info.purchase_id = stock_info.purchase_id')
		                  			->where( $condition )
						  			->where('sale_price_info.product_id = product_info.product_id')
						  			->where('purchase_info.purchase_receipt_id = purchase_receipt_info.receipt_id')
						  			//-> where('stock_info.stock_status = "sold"')
						  			
		                  			->limit($per_page, $this -> uri -> segment(4))
		                  			->get(); 
			 */
				$start = 0;
				if ($this -> uri -> segment(4))
					$start =  $this -> uri -> segment(4);
			     $end =  $per_page;
			   $query = $this->db->query("SELECT stock_info.stock_id, receipt_date , product_name, product_info.product_id, serial_no,unit_buy_price, unit_sale_price
										  FROM stock_info,purchase_info,product_info, purchase_receipt_info,sale_price_info
										  WHERE ( stock_info.stock_status = 'stocked' 
										  OR stock_info.stock_status = 'returned' )
										  AND purchase_info.purchase_id = stock_info.purchase_id
										  AND purchase_info.product_id = product_info.product_id
										  AND purchase_info.purchase_receipt_id = purchase_receipt_info.receipt_id
										  AND sale_price_info.product_id = product_info.product_id
										  AND product_info.product_id = '".$pro_id."' LIMIT ".$start.", ".$end."");
				 return $query;
		 }
		 /* Return Bulk Specific Product */
		 function by_product_name_bulk_result($pro_id, $per_page)
		 {
		 	$query = $this -> db -> select('product_info.product_id, product_info.product_name,
												bulk_stock_info.stock_amount, bulk_unit_sale_price AS unit_sale_price, general_unit_sale_price,last_buy_price,
												bulk_unit_buy_price AS unit_buy_price')
									 -> from('product_info, bulk_stock_info')
									 -> where('bulk_stock_info.shop_id', $this -> shop_id)
									 -> where('product_info.product_id = bulk_stock_info.product_id')
									 -> where('bulk_stock_info.product_id = "'.$pro_id.'"')
									 -> limit($per_page, $this -> uri -> segment(4))
		                  			 -> get();
			  	return $query;
		 }
		 /*  By Serial Number Resulr */
		 function by_serial_no_result()
	  	 {	
	  	 	$serial_no = $this -> input ->post('serial_no');
	  	 	$query = $this -> db -> select('product_name, receipt_date, stock_status, distributor_name, stock_id, company_info.company_name')
			                     -> from('product_info, purchase_info, stock_info, distributor_info, company_info, purchase_receipt_info')
								 -> where('product_info.product_id = purchase_info.product_id')
								  -> where('purchase_info.purchase_receipt_id = purchase_receipt_info.receipt_id')
								 -> where('distributor_info.distributor_id = purchase_receipt_info.distributor_id')
								 -> where('stock_info.purchase_id = purchase_info.purchase_id')
								 -> where('product_info.company_name = company_info.company_name')
								 -> where('stock_info.serial_no = "'.$serial_no.'"')
								 -> get();
			return $query;
	  	 	
	  	 }
		 
		 /** by stock id serach query result**/ 
		 function by_stock_id_result()
	  	 {
	  	 	if($this -> uri -> segment(3))
				$stock_id = $this -> uri -> segment(3);
			else $stock_id = $this -> input ->post('stock_id');
	  	 	$query = $this -> db -> select('product_name,product_info.product_id, receipt_date, stock_status, distributor_name, company_info.company_name,users.username,stock_info.stock_id, serial_no')
			                     -> from('product_info, purchase_info, stock_info, purchase_receipt_info, distributor_info, company_info,users')
								 -> where('stock_info.stock_creator = users.id')
								 -> where('product_info.product_id = purchase_info.product_id')
								 -> where('purchase_info.purchase_receipt_id = purchase_receipt_info.receipt_id')
								 -> where('distributor_info.distributor_id = purchase_receipt_info.distributor_id')
								 -> where('stock_info.purchase_id = purchase_info.purchase_id')
								 -> where('product_info.company_name = company_info.company_name')
								 -> where('stock_info.stock_id = "'.$stock_id.'"')
								 -> get();
			return $query;
	  	 	
	  	 }

		/** select all catagory **/
		function all_catagory()
		{
			$this -> db -> order_by("catagory_name","asc");
			$query = $this -> db -> select('catagory_id, catagory_name')
													 -> from('catagory_info')
													 -> get();
			return $query;
		/*	$data[''] =  'Select a Catagory';
			foreach ($query-> result() as $field)
			{
					$temp = preg_replace('/\s+/', '~',$field->catagory_name);// $url_title = url_title($field->catagory_name, '_');
					//$data['http://localhost/inventory_management/index.php/site_controller/advance_search/'.$field->catagory_name] = $field -> catagory_name;
				    $data[base_url().'index.php/site_controller/advance_search/'.$temp] = $field -> catagory_name;
		    }*/
			//return $data;
		}
		
		
		function product_type()
		{
			$catagory_name = str_replace('~', ' ',$this -> uri -> segment(3));//$this -> uri -> segment(3);
			$query = $this -> db -> select('product_type, product_size, product_id, product_model,company_name')
								 -> from('catagory_info, product_info')
								 -> where('catagory_info.catagory_name = product_info.catagory_name')
								 -> where('product_info.catagory_name = "'.$catagory_name.'"')
								 -> get();
			return $query;
		}
		
		/* Advance Searc Result */
		function advance_search_result()
		{
			 $temp_catagory_name = $this -> uri -> segment(3);
			 if($this -> input -> post('catagory_name') )
				$temp_catagory_name = $this -> input -> post('catagory_name');
			 $catagory_name = str_replace('~', ' ',$temp_catagory_name);
			 $product_type = $this -> input -> post('catagory_type');
			 $product_model = $this -> input -> post('product_model');
			 $product_size = $this -> input -> post('product_size');
			 $company_name = $this -> input -> post('company_name');
			 
			 $this -> db -> select('product_info.product_name,product_info.product_id,
									bulk_unit_sale_price AS unit_sale_price ,
									general_unit_sale_price ,
									bulk_stock_info.stock_amount AS number_of_quantity,
									bulk_unit_buy_price');
			 $this -> db -> from('product_info,bulk_stock_info');
			 $this -> db -> where('product_info.catagory_name = "'.$catagory_name.'" ');
			 if($product_type) $this -> db -> where('product_info.product_type = "'.$product_type.'"');
		 	 if($product_model) $this -> db -> where('product_info.product_model = "'.$product_model.'"');
			 if($product_size) $this -> db -> where('product_info.product_size = "'.$product_size.'"');
			 if($company_name) $this -> db -> where('product_info.company_name = "'.$company_name.'"');
			 $this -> db -> where('bulk_stock_info.shop_id', $this -> shop_id);
			 $this -> db -> where('bulk_stock_info.product_id = product_info.product_id');
			 
			// if($product_size > 0)  $product_size =  $product_size.'\"';
			//echo $product_size;
			//$this -> db -> select('product_info.product_name,unit_sale_price, COUNT(product_info.product_name) AS number_of_quantity');
		/*	$this -> db -> select('product_info.product_name,unit_sale_price, bulk_stock_info.stock_amount AS number_of_quantity');
			$this -> db -> from('catagory_info, company_info,distributor_info,product_info,purchase_info,stock_info,sale_price_info, purchase_receipt_info,bulk_stock_info');
			$this -> db -> where('catagory_info.catagory_name = "'.$catagory_name.'" ');
			
			if($product_type) $this -> db -> where('product_info.product_type = "'.$product_type.'"');
			if($product_model) $this -> db -> where('product_info.product_model = "'.$product_model.'"');
			if($product_size) $this -> db -> where('product_info.product_size = "'.$product_size.'"');
			if($company_name) $this -> db -> where('company_info.company_name = "'.$company_name.'"');
			
			$this -> db -> where('bulk_stock_info.product_id = product_info.product_id');
			$this -> db -> where('catagory_info.catagory_name = product_info.catagory_name');
			$this -> db -> where('product_info.company_name = company_info.company_name');
			$this -> db -> where('product_info.product_id = purchase_info.product_id');
			$this -> db -> where('purchase_receipt_info.distributor_id = distributor_info.distributor_id');
			$this -> db -> where('purchase_info.purchase_receipt_id = purchase_receipt_info.receipt_id');
			//$this -> db -> where('purchase_info.purchase_id = stock_info.purchase_id');
			$this -> db -> where('product_info.product_id = sale_price_info.product_id');
			$this -> db -> group_by('product_info.product_name');*/
			$query = $this -> db -> get();
			return $query;
		}
		
		
		/*********************
		 * No Of Distributors
		 * ******************/
		 function num_of_distributors()
		 {
		 	$query = $this -> db -> get('distributor_info');
			return $query -> num_rows();
		 }
		
		/**********************************
		 * All Distributor With Pagination
		 **********************************/
		 function all_distributor(  $per_page )
		 {
			$query =  $this -> db -> order_by("distributor_name", "asc")
												  -> select('*')
												 -> from('distributor_info')
												 -> limit( $per_page, $this -> uri -> segment(3) )
												 -> get();
			return $query;
		 }

		/*********************
		 * No Of Company
		 * ******************/
		 function num_of_companys()
		 {
		 	$query = $this -> db -> get('company_info');
			return $query -> num_rows();
		 }
		
		/**********************************
		 * All Company With Pagination
		 **********************************/
		 function all_company(  $per_page )
		 {
			 $query =  $this -> db -> order_by("company_name", "asc")
													-> select('*')
													 -> from('company_info')
													 -> limit( $per_page, $this -> uri -> segment(3) )
													 -> get();
			return $query;
		 }
		 
		 function all_expire_date()
		 {
			 $query =  $this -> db -> order_by("expire_date", "asc")
													-> select('*')
													 -> from('software_expire_date')
													// -> limit( $per_page, $this -> uri -> segment(3) )
													 -> get();
			return $query;
		 }
		 
		/*********************
		 * No Of Catagory
		 *******************/
		function num_of_catagory()
		{
		 	$query = $this -> db -> get('catagory_info');
			return $query -> num_rows();
		}
		
		/**********************************
		 * All Catagory With Pagination
		 **********************************/
		function all_catagory_pagination(  $per_page )
		{
			$query =  $this -> db -> order_by("catagory_name", "asc")
								  -> select('*')
								  -> from('catagory_info')
								  -> limit( $per_page, $this -> uri -> segment(3) )
								  -> get();
			return $query;
		}
		
		/****************************
		 * No Of Registred Customer *
		 ****************************/
		function num_of_registerd_customer()
		{
		 	//$query = $this -> db -> get('customer_info');
			//return $query -> num_rows();
			
			$query = $this -> db -> select('customer_name,customer_contact_no,customer_type,customer_mode,customer_address')
		 	                     -> from('customer_info')
		 	                     -> where('customer_mode = "registered"')
		 	                     -> get();
			return $query -> num_rows();
		}
				/****************************
		 * No Of All Type Customer *
		 ****************************/
		function num_of_all_type_customer()
		{
		 	//$query = $this -> db -> get('customer_info');
			//return $query -> num_rows();
			
			$query = $this -> db -> select('customer_name,customer_contact_no,customer_type,customer_mode,customer_address')
		 	                     -> from('customer_info')
		 	                     -> get();
			return $query -> num_rows();
		}
		
		/*******************************************
		 * All Registered Customer With Pagination *
		 *******************************************/
		function all_registerd_customer_pagination(  $per_page )
		{
			$query =  $this -> db -> order_by("customer_name", "asc")
								  -> select('*')
								  -> from('customer_info')
								  -> where('customer_mode = "registered"')
								  -> limit( $per_page, $this -> uri -> segment(3) )
								  -> get();
			return $query;
		}
		function all_type_customer(  $per_page )
		{
			$query =  $this -> db -> order_by("customer_name", "asc")
								  -> select('*')
								  -> from('customer_info')
								  -> limit( $per_page, $this -> uri -> segment(3) )
								  -> get();
			return $query;
		}
		function all_customer_info()
		{
			$query =  $this -> db -> order_by("customer_name", "asc")
								  -> select('*')
								  -> from('customer_info')
								  -> get();
			return $query;
		}
		function specific_customer_info($customer_id)
		{
			$query =  $this -> db -> order_by("customer_name", "asc")
								  -> select('*')
								  -> from('customer_info')
								  -> where('customer_id = "'.$customer_id.'"')
								  -> get();
			return $query;
		}
		
		function all_point_customer( $start_date , $end_date )
		{
		$endd=explode('-',$end_date);
		$dd=$endd[2]+1;
		$end_date=$endd[0].'-'.$endd[1].'-'.$dd;
		
		
			$query =  $this -> db -> order_by("customer_name", "asc")
								  -> select('customer_name, point_info.customer_id ,remain_point')
								  -> select_sum('invoice_info.current_point')
								  -> from('customer_info,point_info,invoice_info')
								  -> where('invoice_info.invoice_dom >= "'.$start_date.'"')
								  -> where('invoice_info.invoice_dom <= "'.$end_date.'"')
								  
								  -> where('point_info.customer_id = invoice_info.customer_id')
								  -> where('point_info.customer_id = customer_info.customer_id')
								  -> group_by('point_info.customer_id')
								  -> get();
			return $query;
		}
		
		function all_point_customer_all()
		{
			$query =  $this -> db -> order_by("customer_name", "asc")
								  -> select('customer_name, point_info.customer_id ,remain_point')
								  -> select_sum('invoice_info.current_point')
								  -> from('customer_info,point_info,invoice_info')
								  -> where('point_info.customer_id = invoice_info.customer_id')
								  -> where('point_info.customer_id = customer_info.customer_id')
								  -> group_by('point_info.customer_id')
								  -> get();
			return $query;
		}
		 
		  /* All distributor information for print purpose */
		 function get_all_distributor_report()
		 {
			$query =  $this -> db -> select('*')
								  -> from('distributor_info')
								  -> get();						 
			return $query;
		 }
		 /*All company information for print purpose */
		 function get_all_company_report()
		 {
			$query =  $this -> db -> select('*')
								  -> from('company_info')
								  -> get();						 
			return $query;
		 }
		 
		 function get_all_catagory_report()
		 {
			$query =  $this -> db -> select('*')
								  -> from('catagory_info')
								  -> get();						 
			return $query;
		 }
		 
		 function unitSalePrice($pro_id){
			 $this -> db -> where('product_id', $pro_id);
			 $this -> db -> where('shop_id', $this -> shop_id);
			 return $this -> db -> get('bulk_stock_info');
		 }
		/*  --------------16-07-2014-----------------
		 *this fuction fetch's some vital
		 *information about a product
		 *no matter if its a bulk/individual product
		 *
		 *
		 --------------------------------------------*/
		 function products_special_information($product_id , $shop_id)
		 {
		 	//echo $product_id;
		 	return $this -> db -> query("
		 									SELECT DISTINCT product_info.product_id,product_name,product_specification,bulk_unit_buy_price
											,bulk_unit_sale_price,bulk_stock_info.general_unit_sale_price,bulk_stock_info.stock_amount as available_stock

											FROM product_info, bulk_stock_info
											WHERE bulk_stock_info.product_id = '".$product_id."'
											AND product_info.product_id = bulk_stock_info.product_id
											AND bulk_stock_info.shop_id = '".$shop_id."'

											UNION

											SELECT  DISTINCT product_info.product_id,product_name,product_specification,
											bulk_unit_buy_price,bulk_unit_sale_price,general_unit_sale_price,bulk_stock_info.stock_amount as available_stock

											FROM product_info, bulk_stock_info
											WHERE bulk_stock_info.product_id = '".$product_id."'
											AND product_info.product_id = bulk_stock_info.product_id
											AND bulk_stock_info.shop_id = '".$shop_id."'


		 								");
		 }
		 
		 /*  ---------------------------16-07-2014----------------------------
		 *this fuction fetch's all stock id of an specific product(Individual)
		 --------------------------------------------------------------------*/
		 function find_all_stock_id($product_id, $shop_id)
		 {
		 	 	return $this -> db -> query("
		 	 									SELECT DISTINCT product_info.product_id,product_name,product_specification,stock_info.stock_id,
		 	 													stock_status,bulk_unit_buy_price,bulk_unit_sale_price  
												FROM product_info, bulk_stock_info,stock_info 
												WHERE bulk_stock_info.product_id = '".$product_id."'
												AND product_info.product_id = bulk_stock_info.product_id 
												AND stock_status <> 'sold' 
												AND product_info.product_id = stock_info.product_id 
												AND bulk_stock_info.shop_id = '".$shop_id."'
		 	 							   ");

		 }

		 function makeBarcode($product_id,$product_name, $product_specification,$sale_price,$g_price,$all_selected_stock_list)
		 {
		 	$this->db->select('barcode');
			$this->db->from('product_info');
			$this->db->where('product_id',$product_id);
			$quer=$this->db->get();
			if($quer->num_rows >0){ 
				foreach($quer -> result() as $field):
					$barcode = $field -> barcode;
				endforeach;
				}
		 
		 
		 	//echo $product_id.' '.$product_name.' '.$product_specification.' '.$sale_price;
		 	$this -> load -> add_package_path(APPPATH.'third_party/Zend_framework');
			$this -> load -> library('zend_framework');
			

		 	if($product_specification == 'individual')
		 	{
	 			$items = array();
			 	foreach($all_selected_stock_list -> result() as $field):
			 		if($this -> input -> post('stockId_'.$field -> stock_id))
			 		{
			 		 	$items[]  = $field -> stock_id;
			 		}
			 		
			 	endforeach;
			 	$data['start'] = current($items);
			 	$data['end']  = end($items);
			 	//$data['start'] = $data['end'] - $quantity + 1;

				for($i=$data['start'] ; $i<=$data['end']; $i++)
				{
					foreach($all_selected_stock_list -> result() as $field):
						if($this -> input -> post('stockId_'.$field -> stock_id))
						{
							$i = $field -> stock_id;
							$barcodeOptions = array('text' => $i );
				 
							$bc = Zend_Barcode::factory(
								'code39',
								'image',
								$barcodeOptions,
								array()
							);
							/* @var $bc Zend_Barcode */
							$res = $bc->draw();
							$filename = './images/barcode/'.$i;
							imagepng($res, $filename);
						}
					endforeach;
				}
				$this->session->set_userdata(array(
						'product_id'	=> $product_id,
						'barcode'	=> $barcode,
						'product_name' => $product_name,
						'pro_specification' => $product_specification,
						'stock_start' => $data['start'],
						'stock_end' => $data['end'],
						'product_price' => $sale_price,
						'general_price' => $g_price,
						'selected_barcodes' => $items
						));		

		 	}
		 	else
		 	{
		 		$barcodeOptions = array('text' => $barcode );
	 
				$bc = Zend_Barcode::factory(
					'code39',
					'image',
					$barcodeOptions,
					array()
				);
				/* @var $bc Zend_Barcode */
				$res = $bc->draw();
				$filename = './images/barcode/'.$barcode;
				imagepng($res, $filename);
				$this->session->set_userdata(array(
						'product_id'	=> $product_id,
						'purchase_quantity' => $this -> input -> post('Quantity'),
						'barcode'	=> $barcode,
						'product_name' => $product_name,
						'pro_specification' => $product_specification,
						'product_price' => $sale_price,
						'general_price' => $g_price
						));
						
						
				$ins_data2 = array(
						'product_id'	=> $product_id,
						'purchase_quantity' => $this -> input -> post('Quantity'),
						'barcode'	=> $barcode,
						'product_name' => $product_name,
						'pro_specification' => $product_specification,
						'product_price' => $sale_price,
						'general_price' => $g_price
						);
				$this->db->insert('barcode_print',$ins_data2);
		 	}
		 }
		 
		function get_barcode_all_listed_product(){
			$query = $this->db->get('barcode_print');
			return $query;
		}
	}
		
