<<<<<<< HEAD
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	
	class Direct_model extends CI_model{
		
		function __construct()
		{
			parent::__construct();
		}
		/******************************************
		 *  checking if element is already exists
		 * $table =  table name
		 * $item = element to search
		 * $field = field name
		 *******************************************/
		 	               // table_name,field name,element
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
/***************************************************** JOB SEEKER PANEL CODE Start *********************************************************/
		function catagory_info()
		{
			$this -> db -> order_by("catagory_name", "asc");
			$query = $this -> db -> get('catagory_info');
			return $query;
		}
		function catagory_wise_product_list($pass_code,$catagory_name)
		{
			
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date ('Y-m-d');
				$yes = 'yes';
				$this -> db -> select('product_info.product_id,product_info.product_name,product_info.product_name_bng,product_info.company_name,product_info.product_size,product_info.unit_name,product_info.image_url,bulk_stock_info.stock_amount,bulk_stock_info.general_unit_sale_price,bulk_stock_info.bulk_unit_sale_price');
				$this -> db -> from('product_info,bulk_stock_info');
				$this -> db -> where('product_info.product_id = bulk_stock_info.product_id');
				if($catagory_name!=''){$this -> db -> where('product_info.catagory_name',$catagory_name);}
				$this->db->order_by('product_info.product_id','desc');
				$query = $this -> db -> get();
				return $query;
			}
			else{
				return false;
			}
		}
		function customer_purchase_list($pass_code,$user_id,$start_date,$end_date)
		{
			
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date ('Y-m-d');
				$yes = 'yes';
				
				
				$this->db->select('customer_id');
				$this->db->from('customer_info');
				$this->db->where('customer_info.user_id',$user_id);
				$query = $this->db->get();
				$tmp = $query->row();
				$customer_id = $tmp->customer_id;
				
				$this -> db -> select('invoice_info.invoice_id,invoice_info.total_price,invoice_info.discount_amount,invoice_info.delivery_charge,invoice_info.sale_return_amount,invoice_info.grand_total,invoice_info.total_paid,invoice_info.invoice_doc');
				$this -> db -> from('invoice_info');
				if($customer_id!=''){$this -> db -> where('invoice_info.customer_id',$customer_id);}
				if($start_date!=''){$this -> db -> where('invoice_info.invoice_doc >= "'.$start_date.'"');}
				if($end_date!=''){$this -> db -> where('invoice_info.invoice_doc <= "'.$end_date.'"');}
				else if($start_date!=''){$this->db->where('invoice_info.invoice_doc <= "'.$start_date.'"');}
				$this->db->group_by('invoice_info.invoice_id'); 
				$this->db->order_by('invoice_info.invoice_id','asc'); 
				$this->db->order_by('invoice_info.invoice_doc','asc');
				$query = $this -> db -> get();
				return $query;
			}
			else{
				return false;
			}
		}
		function customer_purchase_list_against_invoice($pass_code,$invoice_id)
		{
			
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date ('Y-m-d');
				$yes = 'yes';

				$this -> db -> select('product_info.product_name,product_info.product_name_bng,product_info.product_size,product_info.unit_name,sale_details.*');
				$this -> db -> from('product_info,sale_details');
				$this -> db -> where('product_info.product_id = sale_details.product_id');
				$this -> db -> where('sale_details.invoice_id',$invoice_id);
				$this->db->group_by('sale_details.product_id'); 
				$this->db->order_by('sale_details.product_id','asc'); 
				$query = $this -> db -> get();
				return $query;
			}
			else{
				return false;
			}
		}
		public function total_transaction($pass_code,$user_id,$start_date,$end_date)
		{
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$this->db->select('customer_id');
				$this->db->from('customer_info');
				$this->db->where('customer_info.user_id',$user_id);
				$query = $this->db->get();
				$tmp = $query->row();
				$customer_id = $tmp->customer_id;
				
				$this->db->select('transaction_info.date,transaction_info.amount,transaction_info.transaction_purpose,customer_info.customer_name,customer_info.customer_contact_no,customer_info.customer_address');
				$this->db->from('transaction_info,customer_info');			
				$this->db->where('(transaction_info.transaction_purpose = "sale" OR transaction_info.transaction_purpose = "delivery_charge" OR transaction_info.transaction_purpose = "collection" OR transaction_info.transaction_purpose = "credit_collection" OR transaction_info.transaction_purpose = "sale_return")');
				$this->db->where('transaction_info.ledger_id = customer_info.customer_id');
				if($customer_id!=''){$this -> db-> where('transaction_info.ledger_id',$customer_id);}
				if($start_date!=''){$this -> db-> where('transaction_info.date >= "'.$start_date.'"');}
				if($end_date!=''){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
				else if($start_date!=''){$this->db->where('transaction_info.date <= "'.$start_date.'"');}
				$query_data = $this->db->get();
				return $query_data;
			}
			else{
				return false;
			}
		}
		function app_info($pass_code)
		{
			
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$this -> db -> select('*');
				$this -> db -> from('apps_info');
				$query = $this -> db -> get();
				return $query;
			}
			else{
				return false;
			}
		}
		function basic_details($pass_code,$user_id)
		{
			
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$this -> db -> select('*');
				$this -> db -> from('customer_info');
				$this -> db -> where('customer_info.user_id',$user_id);
				$query = $this -> db -> get();
				return $query;
			}
			else{
				return false;
			}
		}
		public function createNewSale($current_user, $current_shop)
        {
			$this -> db -> select('*');
			$this -> db -> from('customer_info');
			$this -> db -> where('customer_info.user_id',$current_user);
			$query = $this -> db -> get();
			$tmp = $query->row();
			$customer_id = $tmp->customer_id;
           
		    $sql = $this->db
                ->select('temp_sale_id')
                ->where('temp_customer_id', $customer_id)
                ->where('pre_invoice_status="pending"')
                ->get('temp_sale_info');
            
            if($sql->num_rows() == 0)
            {
				
				$data = array(
                    'temp_sale_id'          => '',
                    'temp_sale_shop_id'     => 1,
                    'temp_sale_type'     	=> 'cart',
                    'temp_customer_id'      => $customer_id,
                    'temp_sale_creator'     => 13,
                    'return_adjust_amount'  => 0,
                    'temp_sale_status'      => 1,
                    'pre_invoice_status'      => 'pending',
				);
                $this ->db->insert('temp_sale_info', $data);
                return $this->db->insert_id();
            }
            else 
			{
				$tmp = $sql->row();
				$temp_sale_id = $tmp->temp_sale_id;
				return $temp_sale_id;
			}
        }
		public function addProductToSale($sale_id,$product_id,$product_name,$quantity)
		{
			$this->db->select('temp_sale_details.*')
			->from('temp_sale_details')
			->where('product_id', $product_id)
			->where('temp_sale_id', $sale_id)
			->limit(1);
			$is_exists = $this->db->get();

			if($is_exists->num_rows() == 0)
			{
				$this->db->select('*')
				->from('bulk_stock_info')
				->where('product_id', $product_id)
				->limit(1);
				$query = $this->db->get();
				$tmp = $query->row();
				
				$data = array(
					'temp_sale_id'              => $sale_id,
					'product_id'                => $product_id,
					'stock_id'                  => 0,
					'sale_quantity'             => $quantity,
					'product_specification'     => 'bulk',
					'sale_type'                 => 1,
					'unit_buy_price'            => $tmp->bulk_unit_buy_price,
					'unit_sale_price'           => $tmp->bulk_unit_sale_price,
					'general_unit_sale_price'   => $tmp->general_unit_sale_price,
					'actual_sale_price'         => $tmp->bulk_unit_sale_price,
					'temp_sale_details_status'  => 1,
					'item_name'                 => $product_name,
					'stock'                     => $tmp->stock_amount - $quantity
				);
				$this->db->insert('temp_sale_details', $data);
				$temp_sale_details_id = $this->db->insert_id();
				 $this->db->where('product_id', $product_id)->limit(1)
				->update('bulk_stock_info', array('stock_amount' => $tmp->stock_amount - $quantity));

				return $temp_sale_details_id;
			}
			else if($is_exists->num_rows() != 0)
			{
				$this->db->select('*')
				->from('bulk_stock_info')
				->where('product_id', $product_id)
				->limit(1);
				$query = $this->db->get();
				$tmp = $query->row();
				
				
				$field = $is_exists->row();
				$temp_sale_details_id = $field->temp_sale_details_id;
				$sale_quantity_old = $field->sale_quantity;
				$sale_stock_old = $field->stock;
				
				$data = array(
				'sale_quantity' =>$sale_quantity_old + $quantity,
				'stock' =>$sale_stock_old - $quantity
				);
				$this->db->where('product_id', $product_id);
				$this->db->where('temp_sale_id', $sale_id);
				$this->db->update('temp_sale_details', $data);
				
				$this->db->where('product_id', $product_id)->limit(1)
				->update('bulk_stock_info', array('stock_amount' => $tmp->stock_amount - $quantity));

				return $temp_sale_details_id;
			}
        }
		function product_against_sale_id($sale_id)
		{

			$this -> db -> select('product_info.product_id,product_info.product_name,product_info.product_name_bng,product_info.company_name,product_info.product_size,product_info.unit_name,product_info.image_url,temp_sale_details.sale_quantity,temp_sale_details.unit_sale_price,temp_sale_details.general_unit_sale_price');
			$this -> db -> from('product_info,temp_sale_details');
			$this -> db -> where('product_info.product_id = temp_sale_details.product_id');
			$this -> db -> where('temp_sale_details.temp_sale_id',$sale_id);
			$this->db->order_by('temp_sale_details.product_id','asc');
			$query = $this -> db -> get();
			return $query;
		}
		public function initial_balance_amount_customer($user_id)
		{
			$this->db->select('customer_info.int_balance');
			$this->db->from('customer_info');			
			if($user_id!=''){$this->db->where('customer_info.user_id',$user_id);}
			$query_data = $this->db->get();
			$tmp = $query_data->row();
			return $tmp->int_balance;
		}
		public function sale_balance_total_amount($user_id,$start)
		{
			$this->db->where('user_id',$user_id);
			$query = $this->db->get('customer_info');
			$tmp = $query->row();
			$customer_id = $tmp->customer_id;
			
			$this->db->select('SUM(transaction_info.amount) as total_amount_sale');
			$this->db->from('transaction_info');			
			$this->db->where('(transaction_info.transaction_purpose = "sale" OR transaction_info.transaction_purpose = "sale_collection_deleted" OR transaction_info.transaction_purpose = "delivery_charge" OR transaction_info.transaction_purpose = "sale_return")');
			if($customer_id!=''){$this->db->where('transaction_info.ledger_id',$customer_id);}
			$this->db->where('transaction_info.date <',$start);
			$query_data = $this->db->get();
			$tmp = $query_data->row();
			return $tmp->total_amount_sale;
		}
		public function sale_collection_total_amount($user_id,$start)
		{
			$this->db->where('user_id',$user_id);
			$query = $this->db->get('customer_info');
			$tmp = $query->row();
			$customer_id = $tmp->customer_id;
			
			$this->db->select('SUM(transaction_info.amount) as total_amount_sale_collection');
			$this->db->from('transaction_info');			
			$this->db->where('((transaction_info.transaction_purpose="credit_collection" OR transaction_info.transaction_purpose="collection" OR transaction_info.transaction_purpose="cash_return"))');
			if($customer_id!=''){$this->db->where('transaction_info.ledger_id',$customer_id);}
			$this->db->where('transaction_info.date <',$start);
			$query_data = $this->db->get();
			$tmp = $query_data->row();
			return $tmp->total_amount_sale_collection;
		}
		public function sale_return_total_amount($user_id,$start)
		{
			$this->db->where('user_id',$user_id);
			$query = $this->db->get('customer_info');
			$tmp = $query->row();
			$customer_id = $tmp->customer_id;
			
			$this->db->select('SUM(transaction_info.amount) as total_amount_sale_return');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose="sale_return"');
			if($customer_id!=''){$this->db->where('transaction_info.ledger_id',$customer_id);}
			$this->db->where('transaction_info.date <',$start);
			$query_data = $this->db->get();
			$tmp = $query_data->row();
			return $tmp->total_amount_sale_return;
		}
		public function total_upload_data($pass_code,$user_id,$start_date,$end_date)
		{
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$this->db->select('*');
				$this->db->from('image_for_sale_listing');			
				if($user_id!=''){$this -> db-> where('image_for_sale_listing.user_id',$user_id);}
				if($start_date!=''){$this -> db-> where('image_for_sale_listing.delivery_date >= "'.$start_date.'"');}
				if($end_date!=''){$this -> db -> where('image_for_sale_listing.delivery_date <= "'.$end_date.'"');}
				else if($start_date!=''){$this->db->where('image_for_sale_listing.delivery_date <= "'.$start_date.'"');}
				$query_data = $this->db->get();
				return $query_data;
			}
			else{
				return false;
			}
		}
=======
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	
	class Direct_model extends CI_model{
		
		function __construct()
		{
			parent::__construct();
		}
		/******************************************
		 *  checking if element is already exists
		 * $table =  table name
		 * $item = element to search
		 * $field = field name
		 *******************************************/
		 	               // table_name,field name,element
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
/***************************************************** JOB SEEKER PANEL CODE Start *********************************************************/
		function catagory_info()
		{
			$this -> db -> order_by("catagory_name", "asc");
			$query = $this -> db -> get('catagory_info');
			return $query;
		}
		function catagory_wise_product_list($pass_code,$catagory_name)
		{
			
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date ('Y-m-d');
				$yes = 'yes';
				$this -> db -> select('product_info.product_id,product_info.product_name,product_info.product_name_bng,product_info.company_name,product_info.product_size,product_info.unit_name,product_info.image_url,bulk_stock_info.stock_amount,bulk_stock_info.general_unit_sale_price,bulk_stock_info.bulk_unit_sale_price');
				$this -> db -> from('product_info,bulk_stock_info');
				$this -> db -> where('product_info.product_id = bulk_stock_info.product_id');
				if($catagory_name!=''){$this -> db -> where('product_info.catagory_name',$catagory_name);}
				$this->db->order_by('product_info.product_id','desc');
				$query = $this -> db -> get();
				return $query;
			}
			else{
				return false;
			}
		}
		function customer_purchase_list($pass_code,$user_id,$start_date,$end_date)
		{
			
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date ('Y-m-d');
				$yes = 'yes';
				
				
				$this->db->select('customer_id');
				$this->db->from('customer_info');
				$this->db->where('customer_info.user_id',$user_id);
				$query = $this->db->get();
				$tmp = $query->row();
				$customer_id = $tmp->customer_id;
				
				$this -> db -> select('invoice_info.invoice_id,invoice_info.total_price,invoice_info.discount_amount,invoice_info.delivery_charge,invoice_info.sale_return_amount,invoice_info.grand_total,invoice_info.total_paid,invoice_info.invoice_doc');
				$this -> db -> from('invoice_info');
				if($customer_id!=''){$this -> db -> where('invoice_info.customer_id',$customer_id);}
				if($start_date!=''){$this -> db -> where('invoice_info.invoice_doc >= "'.$start_date.'"');}
				if($end_date!=''){$this -> db -> where('invoice_info.invoice_doc <= "'.$end_date.'"');}
				else if($start_date!=''){$this->db->where('invoice_info.invoice_doc <= "'.$start_date.'"');}
				$this->db->group_by('invoice_info.invoice_id'); 
				$this->db->order_by('invoice_info.invoice_id','asc'); 
				$this->db->order_by('invoice_info.invoice_doc','asc');
				$query = $this -> db -> get();
				return $query;
			}
			else{
				return false;
			}
		}
		function customer_purchase_list_against_invoice($pass_code,$invoice_id)
		{
			
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
				$bd_date = date ('Y-m-d');
				$yes = 'yes';

				$this -> db -> select('product_info.product_name,product_info.product_name_bng,product_info.product_size,product_info.unit_name,sale_details.*');
				$this -> db -> from('product_info,sale_details');
				$this -> db -> where('product_info.product_id = sale_details.product_id');
				$this -> db -> where('sale_details.invoice_id',$invoice_id);
				$this->db->group_by('sale_details.product_id'); 
				$this->db->order_by('sale_details.product_id','asc'); 
				$query = $this -> db -> get();
				return $query;
			}
			else{
				return false;
			}
		}
		public function total_transaction($pass_code,$user_id,$start_date,$end_date)
		{
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$this->db->select('customer_id');
				$this->db->from('customer_info');
				$this->db->where('customer_info.user_id',$user_id);
				$query = $this->db->get();
				$tmp = $query->row();
				$customer_id = $tmp->customer_id;
				
				$this->db->select('transaction_info.date,transaction_info.amount,transaction_info.transaction_purpose,customer_info.customer_name,customer_info.customer_contact_no,customer_info.customer_address');
				$this->db->from('transaction_info,customer_info');			
				$this->db->where('(transaction_info.transaction_purpose = "sale" OR transaction_info.transaction_purpose = "delivery_charge" OR transaction_info.transaction_purpose = "collection" OR transaction_info.transaction_purpose = "credit_collection" OR transaction_info.transaction_purpose = "sale_return")');
				$this->db->where('transaction_info.ledger_id = customer_info.customer_id');
				if($customer_id!=''){$this -> db-> where('transaction_info.ledger_id',$customer_id);}
				if($start_date!=''){$this -> db-> where('transaction_info.date >= "'.$start_date.'"');}
				if($end_date!=''){$this -> db -> where('transaction_info.date <= "'.$end_date.'"');}
				else if($start_date!=''){$this->db->where('transaction_info.date <= "'.$start_date.'"');}
				$query_data = $this->db->get();
				return $query_data;
			}
			else{
				return false;
			}
		}
		function app_info($pass_code)
		{
			
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$this -> db -> select('*');
				$this -> db -> from('apps_info');
				$query = $this -> db -> get();
				return $query;
			}
			else{
				return false;
			}
		}
		function basic_details($pass_code,$user_id)
		{
			
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$this -> db -> select('*');
				$this -> db -> from('customer_info');
				$this -> db -> where('customer_info.user_id',$user_id);
				$query = $this -> db -> get();
				return $query;
			}
			else{
				return false;
			}
		}
		public function createNewSale($current_user, $current_shop)
        {
			$this -> db -> select('*');
			$this -> db -> from('customer_info');
			$this -> db -> where('customer_info.user_id',$current_user);
			$query = $this -> db -> get();
			$tmp = $query->row();
			$customer_id = $tmp->customer_id;
           
		    $sql = $this->db
                ->select('temp_sale_id')
                ->where('temp_customer_id', $customer_id)
                ->where('pre_invoice_status="pending"')
                ->get('temp_sale_info');
            
            if($sql->num_rows() == 0)
            {
				
				$data = array(
                    'temp_sale_id'          => '',
                    'temp_sale_shop_id'     => 1,
                    'temp_sale_type'     	=> 'cart',
                    'temp_customer_id'      => $customer_id,
                    'temp_sale_creator'     => 13,
                    'return_adjust_amount'  => 0,
                    'temp_sale_status'      => 1,
                    'pre_invoice_status'      => 'pending',
				);
                $this ->db->insert('temp_sale_info', $data);
                return $this->db->insert_id();
            }
            else 
			{
				$tmp = $sql->row();
				$temp_sale_id = $tmp->temp_sale_id;
				return $temp_sale_id;
			}
        }
		public function addProductToSale($sale_id,$product_id,$product_name,$quantity)
		{
			$this->db->select('temp_sale_details.*')
			->from('temp_sale_details')
			->where('product_id', $product_id)
			->where('temp_sale_id', $sale_id)
			->limit(1);
			$is_exists = $this->db->get();

			if($is_exists->num_rows() == 0)
			{
				$this->db->select('*')
				->from('bulk_stock_info')
				->where('product_id', $product_id)
				->limit(1);
				$query = $this->db->get();
				$tmp = $query->row();
				
				$data = array(
					'temp_sale_id'              => $sale_id,
					'product_id'                => $product_id,
					'stock_id'                  => 0,
					'sale_quantity'             => $quantity,
					'product_specification'     => 'bulk',
					'sale_type'                 => 1,
					'unit_buy_price'            => $tmp->bulk_unit_buy_price,
					'unit_sale_price'           => $tmp->bulk_unit_sale_price,
					'general_unit_sale_price'   => $tmp->general_unit_sale_price,
					'actual_sale_price'         => $tmp->bulk_unit_sale_price,
					'temp_sale_details_status'  => 1,
					'item_name'                 => $product_name,
					'stock'                     => $tmp->stock_amount - $quantity
				);
				$this->db->insert('temp_sale_details', $data);
				$temp_sale_details_id = $this->db->insert_id();
				 $this->db->where('product_id', $product_id)->limit(1)
				->update('bulk_stock_info', array('stock_amount' => $tmp->stock_amount - $quantity));

				return $temp_sale_details_id;
			}
			else if($is_exists->num_rows() != 0)
			{
				$this->db->select('*')
				->from('bulk_stock_info')
				->where('product_id', $product_id)
				->limit(1);
				$query = $this->db->get();
				$tmp = $query->row();
				
				
				$field = $is_exists->row();
				$temp_sale_details_id = $field->temp_sale_details_id;
				$sale_quantity_old = $field->sale_quantity;
				$sale_stock_old = $field->stock;
				
				$data = array(
				'sale_quantity' =>$sale_quantity_old + $quantity,
				'stock' =>$sale_stock_old - $quantity
				);
				$this->db->where('product_id', $product_id);
				$this->db->where('temp_sale_id', $sale_id);
				$this->db->update('temp_sale_details', $data);
				
				$this->db->where('product_id', $product_id)->limit(1)
				->update('bulk_stock_info', array('stock_amount' => $tmp->stock_amount - $quantity));

				return $temp_sale_details_id;
			}
        }
		function product_against_sale_id($sale_id)
		{

			$this -> db -> select('product_info.product_id,product_info.product_name,product_info.product_name_bng,product_info.company_name,product_info.product_size,product_info.unit_name,product_info.image_url,temp_sale_details.sale_quantity,temp_sale_details.unit_sale_price,temp_sale_details.general_unit_sale_price');
			$this -> db -> from('product_info,temp_sale_details');
			$this -> db -> where('product_info.product_id = temp_sale_details.product_id');
			$this -> db -> where('temp_sale_details.temp_sale_id',$sale_id);
			$this->db->order_by('temp_sale_details.product_id','asc');
			$query = $this -> db -> get();
			return $query;
		}
		public function initial_balance_amount_customer($user_id)
		{
			$this->db->select('customer_info.int_balance');
			$this->db->from('customer_info');			
			if($user_id!=''){$this->db->where('customer_info.user_id',$user_id);}
			$query_data = $this->db->get();
			$tmp = $query_data->row();
			return $tmp->int_balance;
		}
		public function sale_balance_total_amount($user_id,$start)
		{
			$this->db->where('user_id',$user_id);
			$query = $this->db->get('customer_info');
			$tmp = $query->row();
			$customer_id = $tmp->customer_id;
			
			$this->db->select('SUM(transaction_info.amount) as total_amount_sale');
			$this->db->from('transaction_info');			
			$this->db->where('(transaction_info.transaction_purpose = "sale" OR transaction_info.transaction_purpose = "sale_collection_deleted" OR transaction_info.transaction_purpose = "delivery_charge" OR transaction_info.transaction_purpose = "sale_return")');
			if($customer_id!=''){$this->db->where('transaction_info.ledger_id',$customer_id);}
			$this->db->where('transaction_info.date <',$start);
			$query_data = $this->db->get();
			$tmp = $query_data->row();
			return $tmp->total_amount_sale;
		}
		public function sale_collection_total_amount($user_id,$start)
		{
			$this->db->where('user_id',$user_id);
			$query = $this->db->get('customer_info');
			$tmp = $query->row();
			$customer_id = $tmp->customer_id;
			
			$this->db->select('SUM(transaction_info.amount) as total_amount_sale_collection');
			$this->db->from('transaction_info');			
			$this->db->where('((transaction_info.transaction_purpose="credit_collection" OR transaction_info.transaction_purpose="collection" OR transaction_info.transaction_purpose="cash_return"))');
			if($customer_id!=''){$this->db->where('transaction_info.ledger_id',$customer_id);}
			$this->db->where('transaction_info.date <',$start);
			$query_data = $this->db->get();
			$tmp = $query_data->row();
			return $tmp->total_amount_sale_collection;
		}
		public function sale_return_total_amount($user_id,$start)
		{
			$this->db->where('user_id',$user_id);
			$query = $this->db->get('customer_info');
			$tmp = $query->row();
			$customer_id = $tmp->customer_id;
			
			$this->db->select('SUM(transaction_info.amount) as total_amount_sale_return');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose="sale_return"');
			if($customer_id!=''){$this->db->where('transaction_info.ledger_id',$customer_id);}
			$this->db->where('transaction_info.date <',$start);
			$query_data = $this->db->get();
			$tmp = $query_data->row();
			return $tmp->total_amount_sale_return;
		}
		public function total_upload_data($pass_code,$user_id,$start_date,$end_date)
		{
			$salt = hash('sha256', uniqid(mt_rand(), true) . "somesalt" . strtolower($pass_code));

			$hash = $salt . $pass_code;
			$update = array(
			'drc_name' => $hash
			);
			$this->db->where('drc_id','1');
			$this->db->update('data_retrive_checking',$update);
			
			if($hash!='')
			{
				$this->db->select('*');
				$this->db->from('image_for_sale_listing');			
				if($user_id!=''){$this -> db-> where('image_for_sale_listing.user_id',$user_id);}
				if($start_date!=''){$this -> db-> where('image_for_sale_listing.delivery_date >= "'.$start_date.'"');}
				if($end_date!=''){$this -> db -> where('image_for_sale_listing.delivery_date <= "'.$end_date.'"');}
				else if($start_date!=''){$this->db->where('image_for_sale_listing.delivery_date <= "'.$start_date.'"');}
				$query_data = $this->db->get();
				return $query_data;
			}
			else{
				return false;
			}
		}
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
	}