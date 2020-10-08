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
		$query = $this -> db -> select('product_info.product_id, product_info.product_name, product_info.unit_id,
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
	   $query = $this -> db -> select('product_info.product_id, product_info.product_name,
										damage_product.damage_quantity, damage_product.unit_buy_price')
							 -> from('product_info, damage_product')
							 -> where('product_info.product_id = damage_product.product_id')
							 -> group_by('product_info.product_name')
							 -> limit($per_page, $this -> uri -> segment(3))
                  			 -> get();
	  	return $query;
	}

    function product_specification($pro_id)
    {
   		$query = $this -> db -> select('product_info.product_specification')
   							 -> from('product_info')
   							 -> where('product_specification = "individual"')
   							 -> where('product_info.product_id = "'.$pro_id.'"')
   							 -> get();
   		return $data = $query -> num_rows(); 				 
    }

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
	 
	
    function get_shelf_info_of_a_product( $pro_id )
    {
	  	$this->db->select('cell_no');
		$this->db->from('product_position_info');
		$this->db->where('product_id = "'.$pro_id.'"');
		$query = $this->db->get();
		return $query;
    }
	 
	function by_product_name_result($pro_id , $per_page)
	{
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

	function by_product_name_bulk_result($pro_id, $per_page)
	{
	 	$query = $this->db->select('product_info.product_id, product_info.product_name,
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
		$query = $this -> db -> get();
		return $query;
	}


	

	
}
		
