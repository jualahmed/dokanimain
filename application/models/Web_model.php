<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	class Web_model extends CI_model
	{
		function redundancy_check($table, $field, $item)
		{
			$query = $this -> db -> select( $field )
								 -> from( $table )
								 -> get();
			 $temp_new = strtolower( preg_replace('/\s+/', '', $item));
			 foreach($query -> result() as $info):
				$temp_old = strtolower( preg_replace('/\s+/', '',$info -> $field));
				if($temp_old == $temp_new) return true;
			 endforeach;
			 
			 return false;
		}
		function catagory_info()
		{
			$this -> db -> order_by("catagory_id", "asc");
			$query = $this -> db -> get('catagory_info');
			return $query;
		}
		public function all_search_record_count($category_id) 
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date ('Y-m-d');

			$this -> db -> select('product_info.product_name,product_info.company_name,product_info.product_size,product_info.unit_id,product_info.image_url,bulk_stock_info.stock_amount,bulk_stock_info.general_unit_sale_price');
			$this -> db -> from('product_info,bulk_stock_info');
			$this -> db -> where('product_info.product_id = bulk_stock_info.product_id');
			$this->db->where('product_info.catagory_name',$category_id);
			$this->db->group_by('product_info.product_id');
			$this->db->order_by('product_info.product_id','asc');
			$query = $this -> db -> get();

			return $data = $query -> num_rows(); 
		}
		public function all_search_result($per_page,$category_id) 
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date ('Y-m-d');

			$this -> db -> select('product_info.product_id,product_info.product_name,product_info.product_name_bng,product_info.company_name,product_info.product_size,product_info.unit_id,product_info.image_ext,product_info.image_url,bulk_stock_info.stock_amount,bulk_stock_info.general_unit_sale_price');
			$this -> db -> from('product_info,bulk_stock_info');
			$this -> db -> where('product_info.product_id = bulk_stock_info.product_id');
			$this->db->where('product_info.catagory_name',$category_id);
			$this->db->limit($per_page, $this -> uri -> segment(5));
			$this->db->group_by('product_info.product_id');
			$this->db->order_by('product_info.product_id','asc');
			$query = $this -> db -> get();

			return $query; 
		}
	}
		
