<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_model extends CI_model{

	private $shop_id;
	function __construct()
	{
		$this->shop_id = $this->tank_auth->get_shop_id();
	}

	public function create($data='')
	{
		$this->db->insert('product_info',$data);
   	 	return $this->db->insert_id();
	}

	public function all()
	{	$this->db->order_by('product_id', 'desc');
		return $this->db->get('product_info')->result();
	}

	public function destroy($id)
	{
		$this->db->where('product_id', $id);
		return $this->db->delete('product_info');
	}

	public function find($product_id='')
	{
		$this->db->where('product_id', $product_id);
		return $this->db->get('product_info')->row();
	}

	public function update($product_id='',$data='')
	{
		$this->db->where('product_id', $product_id);
		return $this->db->update('product_info', $data);
	}

	public function redundancy_check($table, $field, $item)
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

	public function search($query='')
	{
		return $this->db->query("SELECT * FROM product_info WHERE (`product_name` RLIKE ' +$query') OR `product_name` LIKE '$query%'")->result();
	}

	public function fatch_all_purchase_receipt_id()
	{
		$shop_id = $this->tank_auth->get_shop_id();
	 	$this->db->order_by("receipt_id", "desc");
		$query = $this->db->select('receipt_id, distributor_name')
		                    ->from('purchase_receipt_info, distributor_info')
		                    ->where('shop_id', $shop_id)
		                    ->where('purchase_receipt_info.distributor_id = distributor_info.distributor_id')
							->get();
		$data[''] =  'Select An ID';
		foreach ($query -> result() as $field)
		{
			$data[$field->receipt_id] = $field->receipt_id.' (  '.$field->distributor_name.')';	
		}
		return $data;
	}
		 
	public function productsss_info($specific , $product_id, $shop_id)
	{	
		$this->db->select('product_info.product_id,product_info.product_name, stock_amount,product_info.product_specification,
							   catagory_id,company_id,barcode , product_size,product_model,
							   bulk_unit_buy_price, unit_id,
							   bulk_unit_sale_price as unit_sale_price,general_unit_sale_price');
		$this->db->from('bulk_stock_info, product_info');
		$this->db->where('bulk_stock_info.shop_id', $shop_id);
		$this->db->where('product_info.product_specification', 1);
		if($specific) $this->db->where('product_info.product_id', $product_id);
		$this->db->where('bulk_stock_info.stock_amount >0 ');
		$this->db->where('product_info.product_id = bulk_stock_info.product_id ');
		$this->db->order_by('product_info.product_name');
		return $this->db->get();
	}

	public function products_special_information($product_id , $shop_id)
	{
	 	return $this -> db -> query("
			SELECT DISTINCT product_info.product_id,product_name,product_info.product_specification,bulk_unit_buy_price
			,bulk_unit_sale_price,bulk_stock_info.general_unit_sale_price,bulk_stock_info.stock_amount as available_stock

			FROM product_info, bulk_stock_info
			WHERE bulk_stock_info.product_id = '".$product_id."'
			AND product_info.product_id = bulk_stock_info.product_id
			AND bulk_stock_info.shop_id = '".$shop_id."'
			UNION
			SELECT  DISTINCT product_info.product_id,product_name,product_info.product_specification,
			bulk_unit_buy_price,bulk_unit_sale_price,general_unit_sale_price,bulk_stock_info.stock_amount as available_stock

			FROM product_info, bulk_stock_info
			WHERE bulk_stock_info.product_id = '".$product_id."'
			AND product_info.product_id = bulk_stock_info.product_id
			AND bulk_stock_info.shop_id = '".$shop_id."'
		");
	}

	public function find_all_stock_id($product_id, $shop_id)
	{
	 	return $this -> db -> query("SELECT DISTINCT product_info.product_id,product_name,product_info.product_specification,stock_info.stock_id,stock_status,bulk_unit_buy_price,bulk_unit_sale_price  
			FROM product_info, bulk_stock_info,stock_info 
			WHERE bulk_stock_info.product_id = '".$product_id."'
			AND product_info.product_id = bulk_stock_info.product_id 
			AND stock_status <> 'sold' 
			AND product_info.product_id = stock_info.product_id 
			AND bulk_stock_info.shop_id = '".$shop_id."'
		");

	}

	// warranty product barcode make
	public function wmakeBarcodew($id)
	{
		$this->db->where('ip_id', $id);
		$this->db->join('product_info', 'product_info.product_id = warranty_product_list.product_id');
		$this->db->join('bulk_stock_info', 'bulk_stock_info.product_id = product_info.product_id');
		$row=$this->db->get('warranty_product_list')->row();
		
	 	$this -> load -> add_package_path(APPPATH.'third_party/Zend_framework');
		$this -> load -> library('zend_framework');
		$barcode=$row->sl_no;
 		$barcodeOptions = array('text' => $row->sl_no );
		$bc = Zend_Barcode::factory(
			'code39',
			'image',
			$barcodeOptions,
			array()
		);
		$res = $bc->draw();
		$filename = './barcode/'.$barcode;
		imagepng($res, $filename);
		$this->session->set_userdata(array(
			'purchase_quantity' => 1,
			'barcode'	=> $barcode,
			'product_name' => $row->product_name,
			'sale_price' =>$row->general_unit_sale_price,
		));
		$ins_data2 = array(
			'Quantity' => 1,
			'barcode'	=> $barcode,
			'product_name' => $row->product_name,
			'sale_price' => $row->general_unit_sale_price,
		);
		$this->db->insert('barcode_print',$ins_data2);
	}

	public function makeBarcode($product_id,$product_name, $product_specification,$sale_price,$g_price,$all_selected_stock_list)
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
	 	$this -> load -> add_package_path(APPPATH.'third_party/Zend_framework');
		$this -> load -> library('zend_framework');
	 
	 		$barcodeOptions = array('text' => $barcode );
 
			$bc = Zend_Barcode::factory(
				'code39',
				'image',
				$barcodeOptions,
				array()
			);
			$res = $bc->draw();
			$filename = './barcode/'.$barcode;
			imagepng($res, $filename);
			$this->session->set_userdata(array(
				'purchase_quantity' => $this->input->post('Quantity'),
				'barcode'	=> $barcode,
				'product_name' => $product_name,
				'sale_price' => $sale_price,
			));
			$ins_data2 = array(
				'Quantity' => $this->input->post('Quantity'),
				'barcode'	=> $barcode,
				'product_name' => $product_name,
				'sale_price' => $sale_price,
			);
			$this->db->insert('barcode_print',$ins_data2);
	}
	 
	public function get_barcode_all_listed_product(){
		$query = $this->db->get('barcode_print');
		return $query;
	}

	public function w_product_info(){
		$this->db->join('product_info', 'product_info.product_id = warranty_product_list.product_id');
		return $this->db->get('warranty_product_list')->result();
	}

	public function search_and_get_product($product_name=false)
    {
        $data = $this->db
        ->select('*')
        ->like('product_name', $product_name)
        ->from('product_info')
        ->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left')
        ->join('catagory_info','catagory_info.catagory_id = product_info.catagory_id')
        ->join('company_info','company_info.company_id = product_info.company_id')
        ->get();
        if($data->num_rows() > 0)return $data;
        else return false;
    }
	

	


		

























	// old code will orginage and delete
	function create_damage()
	{
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date = date('Y-m-d');
		$creator = $this->tank_auth->get_user_id();	
		$create_damage= array(
			'product_id' 		=> $this->input->post('pro_id'),
			'damage_quantity' 	=> $this->input->post('damage_quantity'),
			'unit_buy_price' 	=> $this->input->post('buy_price'),
			'creator' 			=> $creator,
			'doc'				=> $bd_date,
			'dom' 				=> $bd_date
			);

		$damage_id = $this->db->insert('damage_product', $create_damage);
		$update_stock = array(
		'stock_amount'=>$this->input->post('stock') - $this->input->post('damage_quantity')
		);
		$this->db->where('product_id',$this->input->post('pro_id'));
		$this->db->update('bulk_stock_info',$update_stock);
		return $damage_id;
	}

	/*********************************
	 * Vission Express
	 * Specific Shop Products Details (Single / All Products)
	 * 10-12-2013
	 * Arafat Mamun
	**********************************/
	function specific_shop_products($shop_id, $specific, $product_id)
	{
		$this -> db -> order_by('product_name', 'asc');
		$this -> db -> select('product_info.product_id, product_info.product_name,
								bulk_stock_info.stock_amount, sale_price_info.unit_sale_price,
								bulk_stock_info.bulk_unit_buy_price');
		$this -> db -> from('product_info, bulk_stock_info, sale_price_info');
		$this -> db -> where('sale_price_info.shop_id', $this -> shop_id);
		$this -> db -> where('bulk_stock_info.shop_id = sale_price_info.shop_id');
		if($specific) $this -> db -> where('product_info.product_id', $product_id);
		$this -> db -> where('product_info.product_id = bulk_stock_info.product_id');
		$this -> db -> where('bulk_stock_info.product_id = sale_price_info.product_id');
		
		$this -> db -> group_by('product_info.product_name');
		return $query = $this -> db -> get();
		}
	/*********************************
	 * Vission Express
	 * shop wise product
	 * 10-12-2013
	 * Arafat Mamun
	**********************************/
	function shop_wise_product($product_id, $exclude)
	{
		$this -> db -> order_by('product_name', 'asc');
		$this -> db -> select('product_info.product_id, product_info.product_name,
							   bulk_stock_info.stock_amount');
		$this -> db -> from('product_info, bulk_stock_info');
		$this -> db -> where('product_info.product_id', $product_id);
		$this -> db -> where('product_info.product_id = bulk_stock_info.product_id');
		return $query = $this -> db -> get();
	}

		function purchase_wise_product($product_id)
		{
			$this -> db -> select('unit_buy_price,distributor_info.distributor_id,distributor_name,purchase_receipt_info.distributor_id,purchase_receipt_id');
			$this -> db -> from('purchase_info,distributor_info,purchase_receipt_info');
			$this -> db -> where('purchase_info.product_id', $product_id);
			$this -> db -> where('purchase_receipt_info.receipt_id = purchase_info.purchase_receipt_id ');
			$this -> db -> where('purchase_receipt_info.distributor_id = distributor_info.distributor_id ');
			return $query = $this -> db -> get();
		}
		
		function distirbutor($product_id)
		{
			$this -> db -> select('distributor_info.distributor_id,distributor_name,purchase_info.purchase_receipt_id,purchase_info.unit_buy_price');
			$this -> db -> from('purchase_info,distributor_info,purchase_receipt_info,product_info');
			$this -> db -> where('purchase_info.product_id', $product_id);
			$this -> db -> where('purchase_info.product_id = product_info.product_id ');
			$this -> db -> where('purchase_receipt_info.receipt_id = purchase_info.purchase_receipt_id ');
			$this -> db -> where('purchase_receipt_info.distributor_id = distributor_info.distributor_id ');
			$query = $this -> db -> get();
			return $query;
		}

		/****************************
		 * Vision Express
		 * Transfer Product
		 * 10-12-2013
		 * Arafat Mamun
		******************************/
		function transfer_product($current_shop_id, $selected_product_id, $selected_shop_id, $selected_product_quantity)
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
		
			$this -> db -> select('stock_amount,bulk_unit_buy_price');
			$this -> db -> from('bulk_stock_info');
			$this -> db -> where('product_id', $selected_product_id);
			$this -> db -> where('shop_id', $current_shop_id);
			$this -> db -> where('stock_amount >= "'.$selected_product_quantity.'"');
			$query = $this -> db -> get();
			foreach($query -> result() as $field):
				$product_price = $field -> bulk_unit_buy_price;
			endforeach;
			if($query -> num_rows < 1) return false;
			$this -> db -> query("UPDATE bulk_stock_info
								  SET stock_amount = stock_amount - ".$selected_product_quantity."
								  WHERE bulk_stock_info.product_id = ".$selected_product_id."
								  AND shop_id = ".$current_shop_id." ");
								  
			$exists = 	$this -> db -> query("SELECT product_id
											  FROM bulk_stock_info 
											  WHERE product_id = '".$selected_product_id."'
											  AND shop_id = ".$selected_shop_id." ");
			if ($exists->num_rows() > 0)
		    {
				$this -> db -> query("UPDATE bulk_stock_info
									  SET bulk_unit_buy_price = (((bulk_unit_buy_price * stock_amount ) + (".$selected_product_quantity." * ".$product_price.")) / (stock_amount + ".$selected_product_quantity.")),
										  stock_amount = stock_amount + ".$selected_product_quantity."
									  WHERE bulk_stock_info.product_id = ".$selected_product_id."
									  AND shop_id = ".$selected_shop_id." ");
				 
			}
			else 
			{
				
				$bulk_stock_insert_data = array(			
					'stock_amount' => $selected_product_quantity,
					'bulk_unit_buy_price' => $product_price,
					'shop_id' => $selected_shop_id,
					'product_id' => $selected_product_id,
					'stock_doc' => $bd_date,
					'stock_dom' => $bd_date
				);
			    $insert = $this -> db -> insert('bulk_stock_info', $bulk_stock_insert_data);
			    $new_sale_price_insert_data = array(
				'product_id' => $selected_product_id,
				'shop_id' => $selected_shop_id,
				'unit_sale_price' => 0,
				'alarming_stock' => 0,
				'warranty' => 0
				);
				$insert = $this -> db -> insert('sale_price_info', $new_sale_price_insert_data);
			}
			
			$product_transfer_log_insert_data = array(			
					'transfer_amount' => $selected_product_quantity,
					'unit_buy_price' => $product_price,
					'from_shop' => $current_shop_id,
					'to_shop' => $selected_shop_id,
					'product_id' => $selected_product_id,
					'transferred_by' => $this->tank_auth->get_user_id(),
					'transfer_date' => $bd_date
				);
			    $insert = $this -> db -> insert('product_transfer_log', $product_transfer_log_insert_data);
			return true;
		}
		
		function create_catagory()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
		    $creator = $this->tank_auth->get_user_id();
			
			$new_catagory_insert_data = array(
	
				'catagory_name' => mysql_real_escape_string(strtoupper($this -> input ->post('catagory_name'))),
				'catagory_description' => $this -> input -> post('catagory_description'),
				'catagory_creator' => $creator,
				'catagory_doc' => $bd_date,
				'catagory_dom' => $bd_date
	
			);
			
			$insert = $this -> db -> insert('catagory_info', $new_catagory_insert_data);
			return $insert;
		}
		
		/* fatch all company name */
		function company_name()
		{
			$this -> db -> order_by("company_name", "asc");
			$query = $this -> db -> get('company_info');
			$data[''] =  'Select Company';
			foreach ($query -> result() as $field){
					$data[rawurlencode($field -> company_name)] = $field -> company_name;
					//$row[rawurlencode($field->catagory_name)] = $field->catagory_name;
				}
			return $data;
		}
		
		/* fatch all card name */
		function card_name()
		{
			$this -> db -> order_by("card_id", "asc");
			$query = $this -> db -> get('bank_card_info');
			$data[''] =  'Select Card';
			foreach ($query -> result() as $field){
					$data[rawurlencode($field -> card_id)] = $field -> card_name;
					//$row[rawurlencode($field->catagory_name)] = $field->catagory_name;
				}
			return $data;
		}
		
		/* fatch all company name for product setup*/
		function company_name_1()
		{
			$this -> db -> order_by("company_name", "asc");
			$query = $this -> db -> get('company_info');
			$data[''] =  'Select Company';
			foreach ($query -> result() as $field){
				$data[rawurlencode($field -> company_name)] = $field -> company_name;
			}
			return $data;
		}
		
		function catagory_name()
		{
			$this -> db -> order_by("catagory_name", "asc");
			$query = $this -> db -> get('catagory_info');
			$data[''] =  'Select Category';
			foreach ($query-> result() as $field){
				$data[rawurlencode($field -> catagory_name)] = $field -> catagory_name;
			}
			return $data;
		}
		
		function distributor_name()
		{
			$this -> db -> order_by("distributor_name", "asc");
			$query = $this -> db -> get('distributor_info');
			$data[''] =  'Select Distributor';
			foreach ($query-> result() as $field){
				$data[$field -> distributor_id] = $field -> distributor_name;
			}
			return $data;
		}
		
		function expense_name()
		{
			$this -> db -> order_by("type_type", "DISTINCT");
			$query = $this -> db -> get('type_info');
			$data[''] =  'Select Expense';
			foreach ($query-> result() as $field){
				$data[rawurlencode($field -> type_id)] = $field -> type_type;
			}
			return $data;
		}
		
		function purchase_receipt_new_expense()
		{
			$this -> db -> order_by("expense_details", "DISTINCT");
			$transport = 'Transport Cost For Purchase';
			$query = $this -> db -> select('expense_details')
			                     -> from('expense_info')
			                     -> where('expense_info.expense_type = "'.$transport.'"')
								 -> get();
			$data[''] =  'Select Expense';
			foreach ($query-> result() as $field){
				$data[rawurlencode($field -> expense_details)] = $field -> expense_details;
			}
			return $data;
		}
		
		function customer_name()
		{
			$this -> db -> order_by("customer_name", "asc");
			$query = $this -> db -> get('customer_info');
			$data[''] =  'Select Customer';
			foreach ($query-> result() as $field){
				$data[$field -> customer_id] = $field -> customer_name;
			}
			return $data;
		}
		
		function product_type()
		{
			$this->db->select("product_type","DISTINCT");
			$query = $this -> db -> get('product_info');
			$data[''] =  'Select Type';
			foreach ($query-> result() as $field){
				$data[rawurlencode($field -> product_type)] = $field -> product_type;
			}
			return $data;
		}
		
		function receipt_status()
		{
			$this->db->select("receipt_status","DISTINCT");
			$query = $this -> db -> get('purchase_receipt_info');
			$data[''] =  'Select Status';
			foreach ($query-> result() as $field){
				$data[$field -> receipt_status] = $field -> receipt_status;
			}
			return $data;
		}
		
		function purchase_receipt()
		{
			$shop_id = $this -> tank_auth -> get_shop_id();
		 	$this->db->order_by("receipt_id", "desc");
			$query = $this -> db -> select('receipt_id, distributor_name')
			                     -> from('purchase_receipt_info, distributor_info')
			                     -> where('shop_id', $shop_id)
			                     -> where('purchase_receipt_info.distributor_id = distributor_info.distributor_id')
			                     -> group_by('purchase_receipt_info.receipt_id')
								 -> get();
			$data[''] =  'Select Receipt';
			foreach ($query -> result() as $field)
			{
				$data[$field -> receipt_id] = $field -> receipt_id.' (  '.$field -> distributor_name.'  )';	
			}
			return $data;
		}
		
		function seller()
		{
			$seller = 'seller';
			$this->db->select('*');
			$query = $this -> db -> get('users');
			$data[''] =  'Select Seller';
			foreach ($query-> result() as $field){
				
					$data[$field -> id] = $field -> username;
				}
			return $data;
		}

		function emp_name()
		{
			$this->db->select('*');
			$query = $this -> db -> get('users');
			$data[''] =  'Select Employee';
			foreach ($query-> result() as $field){
				$data[$field -> id] = $field -> username;
			}
			return $data;
		}
		
		function product_specification()
		{
			$data = array(
			    ''  => 'Select a type',
			    'individual' => 'Individual',
			    'bulk' => 'Bulk'
   	        );
			return $data;
		}

		
		function unit_name()
		{
			$query = $this->db->get('unit_info');
			if($query->num_rows() >0 ){
			$row = $query->result();
			
			$data[]='Select Unit Name';
			foreach($row as $row){
				$data[$row->unit_name]=$row->unit_name;
			}
			return $data;
			}
			else{
				$data[]='Select Unit Name';
				return $data;
			}
		}
				
		public function search_product($requested_item)
		{
			$data = $this->db
	        ->select('*')
	        ->like('product_name', $requested_item)
	        ->from('product_info')
	        ->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left')
	        ->join('catagory_info','catagory_info.catagory_id = product_info.catagory_id')
	        ->join('company_info','company_info.company_id = product_info.company_id')
	        ->get();
	        if($data->num_rows() > 0)return $data;
	        else return false;
		}

		public function search_productt2($requested_item, $field)
		{
			$data 	= $this->db
					->select('product_info.product_id, product_name, catagory_name, bulk_stock_info.*')
					->from('product_info, bulk_stock_info')
					->where('product_info.product_id = bulk_stock_info.product_id')
					->like($field, $requested_item, 'after')
					->order_by($field, 'asc')
					->get();
			if($data->num_rows() > 0)return $data;
			else return FALSE;
		}

		public function search_warranty_productt2($requested_item, $field)
		{
			$data 	= $this->db
					->select('product_info.product_id, product_name, catagory_name, bulk_stock_info.*')
					->from('product_info, bulk_stock_info')
					->where('product_info.product_id = bulk_stock_info.product_id')
					->where('product_info.product_specification=2')
					->like($field, $requested_item, 'after')
					->order_by($field, 'asc')
					->get();
			if($data->num_rows() > 0)return $data;
			else return FALSE;
		}
		
		function get_latest_unit_buy_price($product)
		{
			$this->db->select('unit_buy_price');
			$this->db->from('purchase_info');
			$this->db->where('product_id',$product);
			$this->db->where('unit_buy_price != 0');
			$this->db->limit(1);
			$this->db->order_by('purchase_id','desc');
			$query = $this->db->get();
			if($query -> num_rows() > 0)
			{
				return $query->row()->unit_buy_price;
			}
			else{
				return 0;
			}
		}
		
		/* Starting: search_product() */
		public function searchProduct_2($requested_item, $field)
		{
			$data 	= $this->db
					->select('product_info.product_id, product_name, catagory_name, company_name, group_name, bulk_stock_info.*,purchase_info.unit_buy_price')
					->from('product_info, bulk_stock_info, purchase_info')
					->where('product_info.product_id = bulk_stock_info.product_id')
					->where('product_info.product_id = purchase_info.product_id')
					->like($field, $requested_item, 'after')
					->order_by($field, 'asc')
					->get();
			if($data->num_rows() > 0)return $data;
			else return FALSE;
		}
		
		public function search_purchase_buy_price($product_id)
		{
			$data 	= $this->db
					->select('product_info.product_id, product_name, catagory_name, company_name, group_name, bulk_stock_info.*,purchase_info.unit_buy_price')
					->from('product_info, bulk_stock_info')
					->where('product_info.product_id = bulk_stock_info.product_id')
					->where('product_info.product_id = "'.$product_id.'"')
					->get();
			if($data->num_rows() > 0)return $data;
			else return FALSE;
		}

		function create_product()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
		    $creator = $this->tank_auth->get_user_id();
			
			$new_product_insert_data = array(			
				'product_name' => mysql_real_escape_string(strtoupper($this -> input ->post('customProductName'))),
				'catagory_name' => rawurldecode($this -> input ->post('catagory_name')),
				'company_name' => rawurldecode($this -> input ->post('company_name')),
				'product_type' => strtoupper($this -> input ->post('product_type')),
				'product_size' => strtoupper($this -> input ->post('product_size')),
				'product_model' => strtoupper($this -> input ->post('product_model')),
				'product_specification' => 'BULK',
				'unit_name' => $this -> input -> post('unit_name'),
				'barcode' => strtoupper($this -> input ->post('barcode')),
				'product_status' => 'active',		
				'product_creator' => $creator,
				'product_doc' => $bd_date,
				'product_dom' => $bd_date
			);
			$this -> db -> insert('product_info', $new_product_insert_data);
			
			$new_product_id = $this->db->insert_id() ;
			
			$shop_id = $this -> tank_auth -> get_shop_id();
			
			$new_sale_price_info_data = array(
				'product_id' => $new_product_id,
				'bulk_alarming_stock' => $this -> input ->post('alarming_stock'),
				'stock_amount' => 0,
				'shop_id' => $shop_id,
				'bulk_unit_buy_price' => 0,
				'bulk_unit_sale_price' => 0,
				'general_unit_sale_price' => 0,
				'last_buy_price' => 0,
				'stock_doc' => $bd_date,
				'stock_dom' => $bd_date
			);
			
			$insert = $this -> db -> insert('bulk_stock_info', $new_sale_price_info_data);
			return $insert;
		}

		function create_card()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
		    $creator = $this->tank_auth->get_user_id();
			
			$new_card = array(			
				'bank_id' => $this -> input ->post('bank_id'),
				'card_name' => mysql_real_escape_string(strtoupper($this -> input ->post('card_name'))),
				'status' => 'active',		
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$insert = $this -> db -> insert('bank_card_info', $new_card);
			return $insert;
		}

		function create_shelf()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
		    $creator = $this->tank_auth->get_user_id();
			
			$new_shelf_insert_data = array(
				
				'shelf_no' => $this -> input ->post('shelf_no'),
				'row' => $this -> input ->post('row'),
				'column' => $this -> input ->post('column'),
				'shelf_description' => $this -> input -> post('shelf_description'),			
				'shelf_creator' => $creator,
				'shelf_doc' => $bd_date,
				'shelf_dom' => $bd_date
	
			);
			$insert = $this -> db -> insert('shelf_info', $new_shelf_insert_data);
			return $insert;
		}



		/* facth row ,col quantity of a specific shelf */
        function fatch_no_of_row_col()
		{
			$shelf_no = $this -> uri -> segment(3);
			$query = $this -> db -> select('row,column')
								 -> from('shelf_info')
								 -> where('shelf_info.shelf_no = "'.$shelf_no.'"')
								 -> get();
			return $query;
		}
        
		/****************************************
		 * Product Info For onclick Flexibility *
		 * **************************************/
		function  product_info_onclick()
		{
		 	$this -> db -> order_by("product_name", "asc");
		 	$this -> db -> select('product_info.product_id, product_info.product_name');
		 	$this -> db -> where('product_info.product_id = bulk_stock_info.product_id');
			return $this -> db -> get('product_info,bulk_stock_info');
		}
		 /******************************************
		  * Get General Details Of a Specific Product  *
		  * ****************************************/
		function product_general_details()
		{
		  	$product_id = $this -> uri -> segment(3);
		  	$this -> db -> select('product_info.product_name,  sale_price_info.unit_sale_price, whole_sale_price,
		  						   bulk_stock_info.bulk_unit_buy_price, warranty,  alarming_stock,  product_status,
		  						   bulk_stock_info.stock_amount AS number_of_quantity');
			$this -> db -> from('product_info, sale_price_info,  bulk_stock_info');
			
			$this -> db -> where('sale_price_info.shop_id', $this -> shop_id);
			$this -> db -> where('bulk_stock_info.shop_id = sale_price_info.shop_id');
			
			$this -> db -> where('product_info.product_id = "'.$product_id.'"');
			$this -> db -> where('bulk_stock_info.product_id = product_info.product_id');
			//$this -> db -> where('catagory_info.catagory_name = product_info.catagory_name');
			//$this -> db -> where('product_info.company_name = company_info.company_name');
			//$this -> db -> where('product_info.product_id = purchase_info.product_id');
			$this -> db -> where('product_info.product_id = sale_price_info.product_id');
			$this -> db -> group_by('product_info.product_name');
			$query = $this -> db -> get();
			return $query;
		}
		
		/**************************************************
		 * If product Product Specification Is INDIVIDUAL *
		 **************************************************/
	   function get_product_specification( $pro_id )
	   {
	   		$query = $this -> db -> select('product_info.product_specification')
	   							 -> from('product_info')
	   							 -> where('product_specification = "individual"')
	   							 -> where('product_info.product_id = "'.$pro_id.'"')
	   							 -> get();
	   		return $data = $query -> num_rows(); 				 
	   }
		
		/* Create Stock */
		function create_stock()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			$shop_id = $this -> tank_auth -> get_shop_id();
			$last_purchase_id = mysql_insert_id();
			
			$purchase_quantity = $this -> input ->post('purchase_quantity');
			$sale_price = $this -> input ->post('unit_sale_price');
			$product_id = $this -> input -> post('product_id');
			$receipt_id =  $this -> input ->post('receipt_id');
			
			$query = $this -> db -> select('*')
								 -> from('purchase_receipt_info')
								 -> where('receipt_id',$receipt_id)
								 -> get();

			foreach($query -> result() as $field):
				$grand_total = $field -> grand_total;
				$transport_cost = $field -> transport_cost;
			endforeach;
			
			$increse_price = ( $grand_total + $transport_cost ) / $grand_total;
			
			
			$query = $this -> db -> query("SELECT product_specification FROM product_info WHERE product_id = '".$product_id."' ");
	        if ($query->num_rows() > 0)
			{
	           foreach ($query->result_array() as $ps)
			   {    
				  $product_specification = $ps['product_specification'];
			   }
			}
			
								
			$exists = 	$this -> db -> query("SELECT product_id
											  FROM bulk_stock_info 
											  WHERE product_id = '".$product_id."'
											  AND shop_id = ".$shop_id." ");
			if ($exists->num_rows() > 0)
		    {
				 
				 $stock_amount = $this -> db -> select('stock_amount,bulk_unit_buy_price')
				 							 -> from('bulk_stock_info')
											 -> where('product_id = "'.$product_id.'"')
											 -> where('shop_id', $shop_id)
											 -> get();
				 $amount = 0; $unit_price = 0;						 
				 if ($stock_amount->num_rows() > 0)
				 {
		           foreach ($stock_amount->result_array() as $ps)
				   {    
					  $amount = $ps['stock_amount'];
					  $unit_price = $ps['bulk_unit_buy_price'];
				   }
				 }
				 $u_price = $amount * $unit_price;
				 
				$u_price = $u_price + ( $purchase_quantity * ( $this -> input -> post('unit_buy_price')));
				$u_price = $u_price / ($amount + $purchase_quantity );
				
						 
 				$amount = $amount + $purchase_quantity;
				$unit_buy_price=$this -> input -> post('unit_buy_price');
				$this -> db -> query("UPDATE bulk_stock_info 
									  SET stock_amount = ".$amount.", 
									      bulk_unit_buy_price = ".$u_price." ,
										  bulk_unit_sale_price = ".$sale_price." ,
										  last_buy_price = ".$unit_buy_price."
									  WHERE product_id = ".$product_id."
									  AND shop_id = ".$shop_id." ");				 					 	
				/* $this -> db -> update('bulk_stock_info')
		                     -> set('stock_amount' ,$amount)
							 -> where('product_id = "'.$product_id.'"')
							 -> get();*/
				 
			}
			else 
			{
				
				$bulk_stock_insert_data = array(			
					'stock_amount' => $purchase_quantity,
					'bulk_unit_buy_price' => ( $this -> input -> post('unit_buy_price') ),
					'bulk_unit_sale_price' => $sale_price,
					'shop_id' => $shop_id,
					'product_id' => $product_id,
					'last_buy_price' => $this -> input -> post('unit_buy_price'),
					'stock_doc' => $bd_date,
					'stock_dom' => $bd_date
				);
			    $insert = $this -> db -> insert('bulk_stock_info', $bulk_stock_insert_data);	
			}
			
			$this -> db -> where('product_id', $product_id);
			$this -> db -> where('shop_id', $shop_id);
			$query = $this -> db -> get('sale_price_info');
			if ($query -> num_rows() < 1)
			{
				$new_sale_price_insert_data = array(
				'product_id' => $product_id,
				'shop_id' => $shop_id,
				'unit_sale_price' => 0.00,
				'alarming_stock' => 0,
				'warranty' => 0
				);
				$insert = $this -> db -> insert('sale_price_info', $new_sale_price_insert_data);
				//return $insert;
				
			}	

			if($product_specification == 'individual')
			{
				if( $this -> input ->post('serial'))
					$status = 'Not Assigned';
				else $status = 'Not Applicable';
				
				$new_stock_insert_data = array(
				'purchase_id' => $last_purchase_id,
				'product_id' => $product_id,
				'shop_id' => $shop_id,
				'serial_no' => $status,
				'stock_status' => 'stocked',
				'stock_creator' => $creator,
				'stock_doc' => $bd_date,
				'stock_dom' => $bd_date
				);
				for( $i = 0; $i < $purchase_quantity; $i++)
					$insert = $this -> db -> insert('stock_info', $new_stock_insert_data);
			 }
		}
		
		/* Starting: newCreateStock() 17-12-16 (Arun) */
		public function newCreateStock($purchase_quantity, $unit_sale_price, $product_id, $receipt_id, $unit_buy_price, $last_purchase_id, $exclu_sal_pric)
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date 			= date('Y-m-d');
			$creator 			= (int)$this->tank_auth->get_user_id();
			$shop_id 			= (int)$this->tank_auth->get_shop_id();
			
			/* Not Required (Blocked by Arun)
			$purchase_quantity 	= $this -> input ->post('purchase_quantity');
			$sale_price 		= $this -> input ->post('unit_sale_price');
			$product_id 		= $this -> input -> post('product_id');
			$receipt_id 		= $this -> input ->post('receipt_id');
			*/

			/* Starting: Useless block of code*/
			// $query = $this -> db -> select('*')
			// 					 -> from('purchase_receipt_info')
			// 					 -> where('receipt_id',$receipt_id)
			// 					 -> get();

			// foreach($query -> result() as $field):
			// 	$grand_total 		= $field->grand_total;
			// 	$transport_cost 	= $field->transport_cost;
			// endforeach;
			
			// $increse_price = ( $grand_total + $transport_cost ) / $grand_total;
			/* Ending: Useless block of code*/
			
			$query = $this -> db -> query("SELECT product_specification FROM product_info WHERE product_id = '".$product_id."' ");
	        if ($query->num_rows() > 0)
			{
	           foreach ($query->result_array() as $ps)
			   {    
				  $product_specification = $ps['product_specification'];
			   }
			}
			
			/* blocked by arun					
			$exists = 	$this->db->query("SELECT product_id
											  FROM bulk_stock_info 
											  WHERE product_id = '".$product_id."'
											  AND shop_id = ".$shop_id." ");*/

			$is_exists = $this->db->select('product_id')
									->where('product_id', $product_id)
									->where('shop_id', $shop_id)
									->get('bulk_stock_info');
			
			if($is_exists->num_rows() > 0)
		    {	
				 $query_new= $this->db->select('purchase_quantity,unit_buy_price')
									->where('product_id', $product_id)
									->where('purchase_receipt_id!=', $receipt_id)
									->get('purchase_info');
				if($query_new->num_rows() > 0)
				{
					$stock_amount = $this->db->select('stock_amount,bulk_unit_buy_price')
				 						  ->from('bulk_stock_info')
										  ->where('product_id', $product_id)
										  ->where('shop_id', $shop_id)
										  ->get();

					 $amount 		= 0; 
					 $unit_price 	= 0;

					 if ($stock_amount->num_rows() > 0)
					 {
					   foreach ($stock_amount->result_array() as $ps)
					   {    
						  $amount 		= $ps['stock_amount'];
						  $unit_price 	= $ps['bulk_unit_buy_price'];
					   }
					 } 
					$new_purchase_quantity =0;
					$total_buy_price_new =0;
					foreach($query_new->result() as $field)
					{
						$new_purchase_quantity+= $field->purchase_quantity;
						$total_buy_price_new+= $field->purchase_quantity * $field->unit_buy_price;
					}
					
					$total_buy_price_new+=$purchase_quantity *  $unit_buy_price;
					$new_purchase_quantity+=$purchase_quantity;

			
					$update_data = array(
							'stock_amount' 			=> $amount + $purchase_quantity,
							'bulk_unit_buy_price' 	=> $total_buy_price_new/$new_purchase_quantity,
							'bulk_unit_sale_price' 	=> $unit_sale_price,
							'general_unit_sale_price' => $exclu_sal_pric,
							'last_buy_price' 		=> $total_buy_price_new/$new_purchase_quantity
							);
					$is_ok 	= $this->db->set($update_data)
										->where('product_id', $product_id)
										->where('shop_id', $shop_id)
										->update('bulk_stock_info');
					if($is_ok)return true;
				}
				else
				{
					$stock_amount = $this->db->select('stock_amount,bulk_unit_buy_price')
				 						  ->from('bulk_stock_info')
										  ->where('product_id', $product_id)
										  ->where('shop_id', $shop_id)
										  ->get();

					 $amount 		= 0; 
					 $unit_price 	= 0;

					 if ($stock_amount->num_rows() > 0)
					 {
					   foreach ($stock_amount->result_array() as $ps)
					   {    
						  $amount 		= $ps['stock_amount'];
						  $unit_price 	= $ps['bulk_unit_buy_price'];
					   }
					 } 
					
					
					
					
					$bulk_stock_update_data = array(	
					'stock_amount' 				=> $amount + $purchase_quantity,
					'bulk_unit_buy_price' 		=> $unit_buy_price,
					'bulk_unit_sale_price' 		=> $unit_sale_price,
					'general_unit_sale_price' 	=> $exclu_sal_pric,
					'bulk_alarming_stock' 		=> 0,
					'last_buy_price' 			=> $unit_buy_price
					);
					$is_ok 	= $this->db->set($bulk_stock_update_data)
										->where('product_id', $product_id)
										->update('bulk_stock_info');
					if($is_ok)return true;
				}
			}
			else 
			{
				$stock_amount = $this->db->select('stock_amount,bulk_unit_buy_price')
				 						  ->from('bulk_stock_info')
										  ->where('product_id', $product_id)
										  ->where('shop_id', $shop_id)
										  ->get();

					 $amount 		= 0; 
					 $unit_price 	= 0;

					 if ($stock_amount->num_rows() > 0)
					 {
					   foreach ($stock_amount->result_array() as $ps)
					   {    
						  $amount 		= $ps['stock_amount'];
						  $unit_price 	= $ps['bulk_unit_buy_price'];
					   }
					 } 
				
				$bulk_stock_insert_data = array(
					'bulk_id' 					=> '',		
					'stock_amount' 				=> $amount + $purchase_quantity,
					'product_id' 				=> $product_id,
					'shop_id' 					=> $shop_id,
					'bulk_unit_buy_price' 		=> $unit_buy_price,
					'bulk_unit_sale_price' 		=> $unit_sale_price,
					'general_unit_sale_price' 	=> 0,
					'bulk_alarming_stock' 		=> 0,
					'last_buy_price' 			=> $unit_buy_price,
					'warranty_period' 			=> 0,
					'stock_doc' 				=> $bd_date,
					'stock_dom' 				=> $bd_date
				);
			    $insert = $this->db->insert('bulk_stock_info', $bulk_stock_insert_data);
			    if($insert)return true;
			    else return false;
			}
			
			// $this ->db->where('product_id', $product_id);
			// $this ->db->where('shop_id', $shop_id);
			// $query = $this->db->get('sale_price_info');
			
			// if ($query -> num_rows() < 1)
			// {
			// 	$new_sale_price_insert_data = array(
			// 	'product_id' 		=> $product_id,
			// 	'shop_id' 			=> $shop_id,
			// 	'unit_sale_price' 	=> 0.00,
			// 	'alarming_stock' 	=> 0,
			// 	'warranty' 			=> 0
			// 	);
			// 	$insert = $this -> db -> insert('sale_price_info', $new_sale_price_insert_data);
			// 	//return $insert;
				
			// }	

			// if($product_specification == 'individual')
			// {
			// 	if( $this -> input ->post('serial'))$status = 'Not Assigned';
				
			// 	else $status = 'Not Applicable';
				
			// 	$new_stock_insert_data = array(
			// 	'purchase_id' 		=> $last_purchase_id,
			// 	'product_id' 		=> $product_id,
			// 	'shop_id' 			=> $shop_id,
			// 	'serial_no' 		=> $status,
			// 	'stock_status' 		=> 'stocked',
			// 	'stock_creator' 	=> $creator,
			// 	'stock_doc' 		=> $bd_date,
			// 	'stock_dom' 		=> $bd_date
			// 	);
			// 	for( $i = 0; $i < $purchase_quantity; $i++)
			// 		$insert = $this->db->insert('stock_info', $new_stock_insert_data);
			//  }
		}
		/* Ending: newCreateStock() 17-12-16 (Arun)*/


		/* Specific Product Name */
		function specific_product_name($pro_id)
		{
	         $query = $this -> db -> query("SELECT product_name FROM product_info WHERE product_id = '".$pro_id."' ");
	         if ($query->num_rows() > 0)
			 {
	           foreach ($query->result_array() as $p_name)
			   {    
				  $product_name = $p_name['product_name'];
			   }
		       return $product_name;
			}
		}
		
		/* Create Purchase */
		function create_purchase()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			$shop_id = $this -> tank_auth -> get_shop_id();
			
		    $receipt_id =  $this -> input ->post('receipt_id');
			
			/*$query = $this -> db -> select('receipt_doc')
													 -> form('purchase_receipt_info')
													 -> where('receipt_id = "'.$receipt_id.'"')
													 -> get();*/
			$query = $this -> db -> select('*')
								 -> from('purchase_receipt_info')
								 -> where('receipt_id',$receipt_id)
								 -> get();

			foreach($query -> result() as $field):
				$grand_total = $field -> grand_total;
				$transport_cost = $field -> transport_cost;
			endforeach;
			
			$new_purchase_insert_data = array(
				//'product_name' => $this -> input ->post('catagory_name').' '.$this -> input ->post('company_name').' '.$this -> input ->post('product_type').' '.$this -> input ->post('product_size') ,
				'purchase_receipt_id' => $this -> input ->post('receipt_id'),
				'product_id' => $this -> input ->post('product_id'),
				//'distributor_id' => $this -> input ->post('distributor_id'),
				'purchase_quantity' => $this -> input ->post('purchase_quantity'),
				'unit_buy_price' => ( $this -> input ->post('unit_buy_price') ),
				//'purchase_expire_date' => $this -> input ->post('purchase_expire_date'),
				'purchase_description' => $this -> input -> post('purchase_description'),
				'purchase_creator' => $creator,
				'purchase_doc' => $bd_date,
				'purchase_dom' => $bd_date
	
			);
			
			return $insert = $this -> db -> insert('purchase_info', $new_purchase_insert_data);
		}
		


		/* Starting: newCreatePurchase() [17-12-16 Arun]*/
		public function newCreatePurchase($purchase_receipt_id, $pro_id, $qunty, $unit_buy_pric, $grand_total, $total_purchase_amount)
		{
			date_default_timezone_set("Asia/Dhaka");
			$bd_date 		= date('Y-m-d');
			$creator 		= $this->tank_auth->get_user_id();
			$shop_id 		= $this->tank_auth->get_shop_id();
		    /*$receipt_id 	= $this -> input ->post('receipt_id'); 		Not required. */
			
			/*$query = $this -> db -> select('receipt_doc')
													 -> form('purchase_receipt_info')
													 -> where('receipt_id = "'.$receipt_id.'"')
													 -> get();*/
			/*	Not Required (Blocked by Arun)
				$query = $this -> db -> select('*')
								 -> from('purchase_receipt_info')
								 -> where('receipt_id',$purchase_receipt_id)
								 -> get();

			foreach($query -> result() as $field):
				$grand_total 		= $field->grand_total;
				$transport_cost 	= $field->transport_cost;
			endforeach;*/
			$total_price 			= $qunty * $unit_buy_pric;
			$total_purchase_amount 	+= $total_price;
			
			if($grand_total < $total_purchase_amount)
			{
				$this->db->where('receipt_id', $purchase_receipt_id)
				->update('purchase_receipt_info', array('grand_total2' => $total_purchase_amount));
			}

			$is_exists 	= $this->db
									->select('purchase_id')
									->where('purchase_receipt_id', $purchase_receipt_id)
									->where('product_id', $pro_id)
									->limit(1)
									->get('purchase_info');

			$tmp 	= $is_exists->row();
			if($is_exists->num_rows() > 0)
			{

				// $data = array(
				// 	'purchase_quantity' 	=> 'purchase_quantity+' . $qunty, FALSE,
				// 	'unit_buy_price' 		=> $unit_buy_pric, FALSE
				// 	);

				$is_updated = $this->db
									->set('purchase_quantity', 'purchase_quantity+' . $qunty, FALSE)
									->set('unit_buy_price', $unit_buy_pric, FALSE)
									->where('purchase_receipt_id', $purchase_receipt_id)
									->where('product_id', $pro_id)
									->update('purchase_info');

				if($is_updated){
					return $tmp->purchase_id;
				}

				else return false;
			}
			else
			{
				$expire_date 	= 0;
				$tmp_date 		= $this->input->post('ex_date');
				
				if($tmp_date != ''){
					$expire_date = $tmp_date;
				}

				$new_purchase_insert_data = array(
					//'product_name' 			=> $this -> input ->post('catagory_name').' '.$this -> input ->post('company_name').' '.$this -> input ->post('product_type').' '.$this -> input ->post('product_size') ,
					'purchase_receipt_id' 		=> $purchase_receipt_id,
					'product_id' 				=> $pro_id,
					//'distributor_id' 			=> $this -> input ->post('distributor_id'),
					'purchase_quantity' 		=> $qunty,
					'unit_buy_price' 			=> $unit_buy_pric,
					'purchase_expire_date' 		=> date('Y-m-d', strtotime($expire_date)),
					'purchase_description' 		=> 'N/A', 		//$this -> input -> post('purchase_description'),
					'purchase_creator' 			=> $creator,
					'purchase_doc' 				=> $bd_date,
					'purchase_dom' 				=> $bd_date
				);
			
				$this->db->insert('purchase_info', $new_purchase_insert_data);
				return true;
			}
		}
		/* Ending: newCreatePurchase() [17-12-16 Arun]*/


		
		/* Starting: removeProductFromPurchase() (Added by Arun)*/
		public function removeProductFromPurchase($purchase_receipt_id, $product_id)
		{
			// getting previous data
			$query = $this->db->select('purchase_info.*')
			->where('purchase_receipt_id', $purchase_receipt_id)
			->where('product_id', $product_id)
			->limit(1)->get('purchase_info');
			$tmp = $query->row();
			
			$this->db->select('bulk_stock_info.stock_amount,bulk_stock_info.bulk_unit_buy_price');
			$this->db->where('product_id' , $product_id);
			$query_2 = $this->db->get('bulk_stock_info');
			$tmp_2 = $query_2->row();
			
			
			
			if($tmp->purchase_quantity <= $tmp_2->stock_amount)
			{
				// updating stock amount
				$this->db->set('stock_amount', 'stock_amount - ' . $tmp->purchase_quantity, false);
				$this->db->where('product_id' , $product_id);
				$this->db->update('bulk_stock_info');
				
				//$total_buy_price 	= round(($tmp->purchase_quantity * $tmp->unit_buy_price), 2);
				$total_buy_price 	= round(($tmp->purchase_quantity * $tmp->unit_buy_price), 2);
				
				
				// updating buy price
				
				$pre_total_price = $tmp_2->stock_amount * $tmp_2->bulk_unit_buy_price;
				$new_total_purchase_price = $tmp->purchase_quantity * $tmp->unit_buy_price;
				$new_stock = $tmp_2->stock_amount - $tmp->purchase_quantity;
				
				$new_buy_price = $pre_total_price - $new_total_purchase_price;
				
				$final_buy_price = $new_buy_price / $new_stock;
				
				$data = array(
				'bulk_unit_buy_price' => $final_buy_price
				);
				
				$this->db->where('product_id' , $product_id);
				$this->db->update('bulk_stock_info',$data);
				
				

				$this->db->select('*')
				->from('purchase_receipt_info')
				->where('receipt_id', $purchase_receipt_id)
				->limit(1);
				$purchase_receipt_data = $this->db->get()->row();

				$purchase_amt = $purchase_receipt_data->grand_total - $total_buy_price;

				if($purchase_amt >= 0)
				{
					$this->db->where('receipt_id', $purchase_receipt_id)
					->limit(1)
					->update('purchase_receipt_info', array('grand_total2' => $purchase_amt));
				} 

				// deleting product form purchase info
				$this->db->where('purchase_receipt_id', $purchase_receipt_id)
				->where('product_id', $product_id)
				->limit(1)->delete('purchase_info');
			}
			
		}

		/* Ending: removeProductFromPurchase() */
		public function removeProductFromPurchase_warranty($purchase_receipt_id, $ip_id, $unit_buy_price, $product_id)
		{
			
			$this->db->where('ip_id', $ip_id)
				->delete('warranty_product_list');
				
			$this->db->select('bulk_stock_info.stock_amount,bulk_stock_info.bulk_unit_buy_price');
			$this->db->where('product_id' , $product_id);
			$query_2 = $this->db->get('bulk_stock_info');
			$tmp_2 = $query_2->row();
			
			$qnty = $tmp_2->stock_amount - 1;
			/*start: updating purchase amount */
			$this->db->select('*')
			->from('purchase_receipt_info')
			->where('receipt_id', $purchase_receipt_id)
			->limit(1);
			$purchase_receipt_data = $this->db->get()->row();

			$new_purchase_amt = $purchase_receipt_data->grand_total - ($qnty*$unit_buy_price);

			if($new_purchase_amt >= 0)
			{
				$this->db->where('receipt_id', $purchase_receipt_id)
				->update('purchase_receipt_info', array('grand_total2' => $new_purchase_amt));

			}
			
			/*end*/

			$sql =  	$this->db->select('purchase_quantity')
						->where('purchase_receipt_id', $purchase_receipt_id)
						->where('product_id', $product_id)
						->limit(1)
						->get('purchase_info')->row();

			$prev_qty = $sql->purchase_quantity;

			$pur_rcipt_data = array(
				'purchase_quantity' => $prev_qty - 1,
				'unit_buy_price' 	=> $unit_buy_price
				);
			$this->db 	->set($pur_rcipt_data)
						->where('purchase_receipt_id', $purchase_receipt_id)
						->where('product_id', $product_id)
						->update('purchase_info');
						
			$stock_amount = $this->db->select('stock_amount,bulk_unit_buy_price')
			->from('bulk_stock_info')
			->where('product_id', $product_id)
			->where('shop_id', $shop_id)
			->limit(1)->get();

			$amount 		= $qnty; 
			$unit_price 	= 0;

			if ($stock_amount->num_rows() > 0)
			{
		        foreach ($stock_amount->result_array() as $ps)
				{    
					//$amount 		= $ps['stock_amount'];
					$unit_price 	= $ps['bulk_unit_buy_price'];
				}
			}
			$u_price = $amount * $unit_price;
			$u_price = $u_price + ( $qnty * ( $unit_buy_price ));
			$u_price = $u_price / $amount;
				

 			//$amount 			= $amount + ($qnty - $prev_qty);
			$unit_buy_price 	= $unit_buy_price;
				
			$update_data = array(
					'stock_amount' 			=> $amount,
					'bulk_unit_buy_price' 	=> $u_price,
					'last_buy_price' 		=> $unit_buy_price
					);
			$this->db->set($update_data)
						->where('product_id', $product_id)
						//->where('shop_id', $shop_id)
						->update('bulk_stock_info');
			return $prev_qty;
			
			
		}
		
		public function removeProductFromPurchase_warranty_after_sale_return()
		{
			$current_sale_id 	   		= $this->tank_auth->get_current_temp_sale();
			$current_sale_return_id 	= $this->tank_auth->get_current_sale_return_id();
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
			
			$this->db->select('product_id');
			$this->db->from('tmp_sale_return_details_tbl');
			$this->db->where('tmp_sale_return_id',$current_sale_return_id);
			$this->db->limit(1);
			$this->db->order_by('tmp_sale_return_details_tbl.id','DESC');
			$query = $this->db->get();
			
			$tmp = $query->row();
			$product_id = $tmp->product_id;
			$ip_id 	= $this->input->post('ids');
			
/* 			for($i = 0;$i < count($ip_id);$i++)
			{
				$data = array
				(
					'temp_sale_id' =>$current_sale_id,
					'tmp_sale_return_id' =>$current_sale_return_id,
					'product_id' =>$product_id,
					'ip_id' =>$ip_id[$i],
					'doc' =>$bd_date
				);
				$this->db->insert('tmp_warranty_product_return', $data);
					
			} */
			$i=0;
			foreach($ip_id as $ip)
			{
				$data = array
				(
					'temp_sale_id' =>$current_sale_id,
					'tmp_sale_return_id' =>$current_sale_return_id,
					'product_id' =>$product_id,
					'ip_id' =>$ip,
					'doc' =>$bd_date
				);
				$this->db->insert('tmp_warranty_product_return', $data);
				$i++;	
			}
			return true;
		}
		public function update_warranty_after_sale_return()
		{
			$current_sale_id 	   		= $this->tank_auth->get_current_temp_sale();
			$current_sale_return_id 	= $this->tank_auth->get_current_sale_return_id();
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');

            $sql1 = $this->db
                            ->select('*')
                            ->from('tmp_warranty_product_return')
                            ->where('tmp_warranty_product_return.temp_sale_id', $current_sale_id)
                            ->where('tmp_warranty_product_return.tmp_sale_return_id', $current_sale_return_id)
                            ->get();
			if($sql1->num_rows() > 0)
			{
				foreach($sql1->result() as $field_new)
				{
					$data=array
					(
						'status'=>1
					);
					$this->db->where('warranty_product_list.ip_id',$field_new->ip_id);
					$this->db->where('warranty_product_list.product_id',$field_new->product_id);
					$this->db->update('warranty_product_list',$data);
				}
				return true;
			}
			else{
				return false;
			}
			
		}
		/* Ending: removeProductFromPurchase() */
		/* Starting: editPruchaseProduct() (Added by Arun)*/
		public function	editPruchaseProduct($purchase_receipt_id, $product_id, $qnty, $unit_buy_price, $shop_id)
		{	

			/*start: updating purchase amount */
			$this->db->select('*')
			->from('purchase_receipt_info')
			->where('receipt_id', $purchase_receipt_id)
			->limit(1);
			$purchase_receipt_data = $this->db->get()->row();

			$new_purchase_amt = $purchase_receipt_data->grand_total - ($qnty*$unit_buy_price);

			if($new_purchase_amt >= 0)
			{
				$this->db->where('receipt_id', $purchase_receipt_id)
				->update('purchase_receipt_info', array('grand_total2' => $new_purchase_amt));

			}
			
			/*end*/

			$sql =  	$this->db->select('purchase_quantity')
						->where('purchase_receipt_id', $purchase_receipt_id)
						->where('product_id', $product_id)
						->limit(1)
						->get('purchase_info')->row();

			$prev_qty = $sql->purchase_quantity;

			$pur_rcipt_data = array(
				'purchase_quantity' => $qnty,
				'unit_buy_price' 	=> $unit_buy_price
				);
			$this->db 	->set($pur_rcipt_data)
						->where('purchase_receipt_id', $purchase_receipt_id)
						->where('product_id', $product_id)
						->update('purchase_info');
						
				$query_new= $this->db->select('purchase_quantity,unit_buy_price')
									->where('product_id', $product_id)
									->where('purchase_receipt_id!=', $purchase_receipt_id)
									->get('purchase_info');
				if($query_new->num_rows() > 0)
				{
					
					$stock_amount = $this->db->select('stock_amount,bulk_unit_buy_price')
				 						  ->from('bulk_stock_info')
										  ->where('product_id', $product_id)
										  ->where('shop_id', $shop_id)
										  ->get();

					 $amount 		= 0; 
					 $unit_price 	= 0;

					 if ($stock_amount->num_rows() > 0)
					 {
					   foreach ($stock_amount->result_array() as $ps)
					   {    
						  $amount 		= $ps['stock_amount'];
						  $unit_price 	= $ps['bulk_unit_buy_price'];
					   }
					 } 
					
					
					$new_purchase_quantity =0;
					$total_buy_price_new =0;
					foreach($query_new->result() as $field)
					{
						$new_purchase_quantity+= $field->purchase_quantity;
						$total_buy_price_new+= $field->purchase_quantity * $field->unit_buy_price;
					}
					
					$total_buy_price_new+=$qnty *  $unit_buy_price;
					$new_purchase_quantity+=$qnty;
				
					$update_data = array(
							'stock_amount' 			=> ($amount-$prev_qty) + $qnty,
							'bulk_unit_buy_price' 	=> $total_buy_price_new/$new_purchase_quantity,
							'last_buy_price' 		=> $total_buy_price_new/$new_purchase_quantity
							);
					$is_ok 	= $this->db->set($update_data)
										->where('product_id', $product_id)
										->where('shop_id', $shop_id)
										->update('bulk_stock_info');
					if($is_ok)return true;
				}
				else
				{
					$stock_amount = $this->db->select('stock_amount,bulk_unit_buy_price')
				 						  ->from('bulk_stock_info')
										  ->where('product_id', $product_id)
										  ->where('shop_id', $shop_id)
										  ->get();

					 $amount 		= 0; 
					 $unit_price 	= 0;

					 if ($stock_amount->num_rows() > 0)
					 {
					   foreach ($stock_amount->result_array() as $ps)
					   {    
						  $amount 		= $ps['stock_amount'];
						  $unit_price 	= $ps['bulk_unit_buy_price'];
					   }
					 } 
					 
					$bulk_stock_update_data = array(	
					'stock_amount' 				=> ($amount-$prev_qty) + $qnty,
					'bulk_unit_buy_price' 		=> $unit_buy_price,
					'last_buy_price' 			=> $unit_buy_price
					);
					$is_ok 	= $this->db->set($bulk_stock_update_data)
										->where('product_id', $product_id)
										->update('bulk_stock_info');
					if($is_ok)return true;
				}			
			
			return $prev_qty;

		}
		/* Ending: editPruchaseProduct() */
		/* Create Purchase */
		function create_purchase_for_direct_entry($product_id)
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			$shop_id = $this -> tank_auth -> get_shop_id();
			
		    $receipt_id =  $this -> input ->post('receipt_id');
			
			$new_purchase_insert_data = array(
				'purchase_receipt_id' => $this -> input ->post('receipt_id'),
				'product_id' => $product_id,
				'purchase_quantity' => $this -> input ->post('purchase_quantity'),
				'unit_buy_price' =>  $this -> input ->post('unit_buy_price') ,
				'purchase_description' => $this -> input -> post('purchase_description'),
				'purchase_creator' => $creator,
				'purchase_doc' => $bd_date,
				'purchase_dom' => $bd_date
			);
			
			return $insert = $this -> db -> insert('purchase_info', $new_purchase_insert_data);
		}
		
		/* Create Stock */
		function create_stock_for_direct_entry($new_product_id,$purchase_id)
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			$shop_id = $this -> tank_auth -> get_shop_id();
			$last_purchase_id = $purchase_id;
			
			$purchase_quantity = $this -> input ->post('purchase_quantity');
			$product_id = $new_product_id;
			$receipt_id =  $this -> input ->post('receipt_id');
			
			$query = $this -> db -> select('*')
								 -> from('purchase_receipt_info')
								 -> where('receipt_id',$receipt_id)
								 -> get();

			foreach($query -> result() as $field):
				$grand_total = $field -> grand_total;
				$transport_cost = $field -> transport_cost;
			endforeach;
			
			$increse_price = ( $grand_total + $transport_cost ) / $grand_total;
			
			
			$query = $this -> db -> query("SELECT product_specification FROM product_info WHERE product_id = '".$product_id."' ");
	        if ($query->num_rows() > 0)
			{
	           foreach ($query->result_array() as $ps)
			   {    
				  $product_specification = $ps['product_specification'];
			   }
			}
			
								
			$exists = 	$this -> db -> query("SELECT product_id
											  FROM bulk_stock_info 
											  WHERE product_id = '".$product_id."'
											  AND shop_id = ".$shop_id." ");
			if ($exists->num_rows() > 0)
		    {
				 
				 $stock_amount = $this -> db -> select('stock_amount,bulk_unit_buy_price')
				 							 -> from('bulk_stock_info')
											 -> where('product_id = "'.$product_id.'"')
											 -> where('shop_id', $shop_id)
											 -> get();
				 $amount = 0; $unit_price = 0;						 
				 if ($stock_amount->num_rows() > 0)
				 {
		           foreach ($stock_amount->result_array() as $ps)
				   {    
					  $amount = $ps['stock_amount'];
					  $unit_price = $ps['bulk_unit_buy_price'];
				   }
				 }
				 $u_price = $amount * $unit_price;
				 
				$u_price = $u_price + ( $purchase_quantity *  $this -> input -> post('unit_buy_price'));
				$u_price = $u_price / ($amount + $purchase_quantity );
				
						 
 				$amount = $amount + $purchase_quantity;
				$unit_buy_price=$this -> input -> post('unit_buy_price');
				$this -> db -> query("UPDATE bulk_stock_info 
									  SET stock_amount = ".$amount.", 
									      bulk_unit_buy_price = ".$u_price." ,
										  last_buy_price = ".$unit_buy_price."
									  WHERE product_id = ".$product_id."
									  AND shop_id = ".$shop_id." ");				 					 	
				/* $this -> db -> update('bulk_stock_info')
		                     -> set('stock_amount' ,$amount)
							 -> where('product_id = "'.$product_id.'"')
							 -> get();*/
				 
			}
			else 
			{
				
				$bulk_stock_insert_data = array(			
					'stock_amount' => $purchase_quantity,
					'bulk_unit_buy_price' => ( $this -> input -> post('unit_buy_price') ),
					'bulk_unit_sale_price' => $this -> input -> post('bulkUnitSalePrice'),
					'shop_id' => $shop_id,
					'product_id' => $product_id,
					'last_buy_price' => $this -> input -> post('unit_buy_price'),
					'bulk_alarming_stock' => $this -> input -> post('alarming_stock'),
					'stock_doc' => $bd_date,
					'stock_dom' => $bd_date
				);
			    $insert = $this -> db -> insert('bulk_stock_info', $bulk_stock_insert_data);	
			}
			
			$this -> db -> where('product_id', $product_id);
			$this -> db -> where('shop_id', $shop_id);
			$query = $this -> db -> get('sale_price_info');
			if ($query -> num_rows() < 1)
			{
				$new_sale_price_insert_data = array(
				'product_id' => $product_id,
				'shop_id' => $shop_id,
				'unit_sale_price' => 0.00,
				'alarming_stock' => 0,
				'warranty' => 0
				);
				$insert = $this -> db -> insert('sale_price_info', $new_sale_price_insert_data);
				//return $insert;
				
			}	

			if($product_specification == 'individual')
			{
				if( $this -> input ->post('serial'))
					$status = 'Not Assigned';
				else $status = 'Not Applicable';
				
				$new_stock_insert_data = array(
				'purchase_id' => $last_purchase_id,
				'product_id' => $product_id,
				'shop_id' => $shop_id,
				'serial_no' => $status,
				'stock_status' => 'stocked',
				'stock_creator' => $creator,
				'stock_doc' => $bd_date,
				'stock_dom' => $bd_date
				);
				for( $i = 0; $i < $purchase_quantity; $i++)
					$insert = $this -> db -> insert('stock_info', $new_stock_insert_data);
			}
		}

		/* Check serial number duplicasy  */
		function serial_no_check($product_id, $serial)
		{
			$query = $this -> db -> select('stock_id')
	                  			 -> from('stock_info,purchase_info,product_info')
								 -> where('purchase_info.product_id = product_info.product_id')
								 -> where('purchase_info.purchase_id = stock_info.purchase_id')
								 -> where('product_info.product_id = "'.$product_id.'"')
								 -> where('stock_info.serial_no = "'.$serial.'"')
	                  			 -> get();							 
			return $query -> num_rows();

		}


		/* Update Serial Number */
		function update_serial_no()
		{
			$serial_no = preg_replace('/\s+/', '', $this -> input -> post('serial_no'));
			$stock_id = $this -> input -> post('stock_id');
			$query = $this -> db -> query("UPDATE stock_info SET serial_no='".$serial_no."' WHERE stock_id= '".$stock_id."'");
			return $query;
		}
		
		/* Update Todays Sale Price */
		function sale_price_entry()
		{
			$pro_id = $this -> input -> post('product_id');
			$shop_id = $this -> tank_auth -> get_shop_id();
			$retail_price = $this -> input -> post('unit_sale_price');
			//$whole_price = $this -> input -> post('whole_sale_price');
			
			$this -> db -> where('product_id', $pro_id);
			$this -> db -> where('shop_id', $shop_id);
			$query = $this -> db -> get('sale_price_info');
			if ($query -> num_rows() > 0)
			{
				$update = $this -> db -> query("UPDATE sale_price_info 
												SET unit_sale_price='".$retail_price."'
												WHERE product_id= '".$pro_id."'
												AND shop_id = ".$shop_id."");
				return $update;
			}
			else
			{
				$new_sale_price_insert_data = array(
				'product_id' => $pro_id,
				'shop_id' => $shop_id,
				'unit_sale_price' => $retail_price,
				'alarming_stock' => 0,
				'warranty' => 0
				);
				$insert = $this -> db -> insert('sale_price_info', $new_sale_price_insert_data);
				return $insert;
				
			}
	
			
			
		}
		
		/*********************************************************
		 * Select All Product Active And Inactive To Change Status
		 *********************************************************/
		 function  all_product()
		 {
		 	$this->db->order_by("product_name", "asc");
			$query = $this -> db -> get('product_info');
			$data[''] =  'Select a Product';
			foreach ($query -> result() as $field){
				
					$data[$field -> product_id] = $field -> product_name;
				}
			return $data;
		 }
		
		/************************
		 * Update Product Status
		 ************************/
		 function change_product_status()
		 {
		 	$product_id = $this -> input -> post('product_id');
			$product_status = $this -> input -> post('product_status');
			$query = $this -> db ->  query("UPDATE product_info 
											SET product_status ='".$product_status."'
											WHERE product_id = '".$product_id."'");
			return $query;
		 }
		 
		 /************************************
		 * Update Alarming Level of A Product
		 *************************************/
		 function set_alarming_level()
		 {
		 	$product_id = $this -> input -> post('product_id');
			$alarming_stock = $this -> input -> post('alarming_stock');
			$query = $this -> db ->  query("UPDATE sale_price_info 
											SET alarming_stock ='".$alarming_stock."'
											WHERE product_id = '".$product_id."'
											AND shop_id = '".$this -> shop_id."'");
			return $query;
		 }
		 function getLastInserted() 
		 {
			$this->db->select_max('product_id');
			$result= $this->db->get('product_info')->row_array();
			return $result;
			
		 }
		 function getLastInserted2() 
		 {
			$this->db->select('product_id');
			$this->db->from('product_info');
			$this->db->order_by('product_id','DESC');
			$this->db->limit(1);
			$result= $this->db->get();
			$field = $result->row();
			return $field->product_id;
			
		 }
		 public function get_product($key, $field_name){

            $data = $this->db
                            ->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_specification')
                            ->like($field_name, $key, 'after')
                            ->order_by('product_name', 'asc')
                            ->from('product_info')
                            ->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left')
                            ->group_by('product_info.product_id')
                            ->get();
            
            if($data->num_rows() > 0)return $data;
            else return false;

        }
		 /**************************
		  * Update Warranty Period *
		  * ************************/
		function warranty_period_entry( $task )
		{
			$pro_id = $this -> input -> post('product_id');
			$warranty_period = $this -> input -> post('warranty_period');
			if($task == 'insert')
			{
				$new_sale_price_insert_data = array(
				'product_id' => $pro_id,
				'warranty' => $warranty_period,
				'shop_id' => $this -> shop_id
				);
				$insert = $this -> db -> insert('sale_price_info', $new_sale_price_insert_data);
				return $insert;
			}
			else
			{
				$update = $this -> db -> query("UPDATE sale_price_info 
												SET warranty='".$warranty_period."' 
												WHERE product_id= '".$pro_id."'
												AND shop_id = '".$this -> shop_id."'");
				return $update;
			}
		}
		
	
		 
		 
		 function fatch_all_purchase_receipt_id_for_transaction_purpose()
		 {
			$this->db->order_by("receipt_id", "asc");
			$query = $this -> db -> select('receipt_id,distributor_name')
			                     -> from('purchase_receipt_info, distributor_info')
			                     -> where('total_paid < grand_total')
			                     -> where('purchase_receipt_info.distributor_id = distributor_info.distributor_id')
								 -> get();
								 
			$data[''] =  'Select An ID';
			foreach ($query -> result() as $field)
			{
				$segment_3 = $this -> uri -> segment(3);
				//$data[base_url().'index.php/account/transaction_entry/'.$segment_3.'/purchase/'.$field->receipt_id] = $field -> receipt_id;
				$data[base_url().'index.php/account/transaction_entry/'.$segment_3.'/purchase/'.$field->receipt_id] = $field -> receipt_id.' (  '.$field -> distributor_name.'  )';	
			}
			return $data;
		 }
		
		/* this function will fetch product name : by limon */ 
		function fatch_product_info_forprint($product_id)
		{					 
			return $query = $this -> db -> query("SELECT product_name,product_specification
											FROM product_info
											WHERE product_id= '".$product_id."'
											");			
		}
		function damage_product_apply( $bulk_stock_details,$product_specification)
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			$new_damage = $this -> input -> post('new_damage');
			$product_id = $this -> input -> post('product_id');
			$purchase_receipt_id = $this -> input -> post('purchase_receipt_id');
			
			foreach($bulk_stock_details -> result() as $field):
				$prev_quantity = $field -> stock_amount;
				$prev_avg_price = $field -> bulk_unit_buy_price;
			endforeach;
			
			$query = $this -> db -> select('distributor_id,unit_buy_price,grand_total')
			                     -> from('purchase_receipt_info,purchase_info')
			                     -> where('purchase_receipt_info.receipt_id ="'.$purchase_receipt_id.'"')
			                     -> where('purchase_receipt_info.receipt_id =purchase_info.purchase_receipt_id')
								 -> get();
								 
			foreach($query -> result() as $field):
				$distributor_id = $field -> distributor_id;
				$unit_buy_price = $field -> unit_buy_price;
				$grand_total = $field -> grand_total;
			endforeach;

			$new_grand_total = $unit_buy_price * $new_damage;
			$final_grand_total = $grand_total - $new_grand_total;
			
			$total_quantity = $prev_quantity - $new_damage;
			$total_price = ( $prev_quantity * $prev_avg_price );
			$new_total_price = $total_quantity * $prev_avg_price;
			$new_quantity = $total_quantity;
			
			$temp_new_quantity = $new_quantity;
			$new_avg_price =  $new_total_price / $temp_new_quantity;
			
			
			//$new_avg_price =  $new_total_price / $temp_new_quantity;
			
			/***** end modification 27-10-2013 ***/

			$dataa = array(
			   'grand_total' => $final_grand_total
			);
			$this->db->where('receipt_id', $purchase_receipt_id);
			$this->db->where('shop_id', $this -> shop_id);
			$this->db->update('purchase_receipt_info', $dataa); 
			
			$dataaa = array(
			   'damage_purchase_quantity' => $new_damage
			);
			$this->db->where('purchase_receipt_id', $purchase_receipt_id);
			$this->db->update('purchase_info', $dataaa); 
			
			$data = array(
			   'stock_amount' => $new_quantity,
			   'bulk_unit_buy_price' => $new_avg_price,
			   'stock_dom' => $bd_date
			);
			$this->db->where('product_id', $product_id);
			$this->db->where('shop_id', $this -> shop_id);
			$this->db->update('bulk_stock_info', $data); 
			
			$damage_data = array(
								   'product_id' => $product_id,
								   'damage_quantity' => $new_damage,
								   'unit_buy_price' => $new_avg_price,
								   'distributor_id' => $distributor_id,
								   'purchase_receipt_id' => $purchase_receipt_id,
								   'DOC' => $bd_date
								);
			$this->db->insert('damage_product',$damage_data);
			/* $ref_id=mysql_insert_id();
			
			$new_transaction_ref_details_insert_dataa1 = array(
					'ref_id'				 			=> $ref_id ,
					'transaction_amount' 				=> $new_grand_total,
					'transaction_type' 					=> 'out',
					'transaction_purpose' 				=> 'damagereturn',
					'transaction_table_ref_name' 		=> 'damage_product',
					'transaction_table_ref_id_field' 	=> 'damage_id',
					'transaction_ref_details_doc' 		=> $bd_date,
					'transaction_ref_details_dom' 		=> $bd_date,
					'transaction_ref_details_creator' 	=> $creator
				);	
				$this -> db -> insert('transaction_ref_details',$new_transaction_ref_details_insert_dataa1);
				$new_id_2=mysql_insert_id();
				$new_transaction_details_insert_datasde = array(
					
						'transaction_reference_id' 			=> $new_id_2,
						'shop_id' 							=> $this -> shop_id,
						'transaction_amount' 				=> $new_grand_total,
						'transaction_type' 					=> 'out',
						'transaction_mode' 					=> 'cash',
						'transaction_doc' 					=> $bd_date,
						'transaction_dom' 					=> $bd_date,
						'transaction_creator' 				=> $creator
					);
					$this -> db -> insert('transaction_details',$new_transaction_details_insert_datasde); */
			
			if( $product_specification ) // if it is a Individual Product
			{
				if( $previous_purchase_quantity > $this -> input -> post('new_purchase_quantity') )
				{
					$temp_count = $previous_purchase_quantity - $this -> input -> post('new_purchase_quantity');
					$this -> db ->order_by("stock_id", "desc");
					$this -> db -> select('stock_id');
					$this -> db -> from('stock_info');
					$this -> db -> where('purchase_id = "'.$purchase_id.'"');
					$query = $this -> db -> get();
					$index = 0;
					foreach($query -> result() as $field):
						if($index >= $temp_count) break;
						$this -> db -> query("DELETE  FROM stock_info WHERE stock_id = ".$field -> stock_id." ");
						$index++;
					endforeach;
				}
				
				if( $previous_purchase_quantity < $this -> input -> post('new_purchase_quantity') )
				{
					$temp_count =  $this -> input -> post('new_purchase_quantity') - $previous_purchase_quantity;
					if( $this -> input ->post('serial'))
						$status = 'Not Assigned';
					else $status = 'Not Applicable';
					$new_stock_insert_data = array(
						'purchase_id' => $purchase_id,
						'serial_no' => $status,
						'stock_status' => 'stocked',
						'stock_creator' => $creator,
						'stock_doc' => $bd_date,
						'stock_dom' => $bd_date
						);
					for( $index = 0; $index < $temp_count; $index++)
						$insert = $this -> db -> insert('stock_info', $new_stock_insert_data);
					return mysql_insert_id();
				}
			}
			
		}

		public function search_product_by_barcode($barcode)
		{
			$this->db
			->select('product_info.product_id, product_info.product_specification as new_spec, product_name, catagory_name, company_name, group_name, bulk_stock_info.*')
			->from('product_info, bulk_stock_info')
			->where('product_info.product_id = bulk_stock_info.product_id')
			->where('barcode', $barcode)
			->limit(1);
			$query = $this->db->get();

			if($query->num_rows() > 0)
			{
				return $query->row();
			}

			return false;
			
		}
}
