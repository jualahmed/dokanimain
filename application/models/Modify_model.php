<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Modify_model extends CI_model{
		
		private $shop_id;
			
		function __construct()
		{
			$this -> shop_id = $this -> tank_auth -> get_shop_id();
		}

		/***********************
		* Shop Modify
		* 2016-12-24
		* Ovi
		************************/
		function get_shop_info_modify(){
			
			$this->db->select('*');
			$this->db->from('shop_setup');
			$query = $this->db->get();
			
			return $query;		
		}
		
		function update_shop(){

		  	$data = array(
               'shop_name' => $this -> input -> post('shop_name'),
               'shop_address' => $this -> input -> post('shop_address'),
               'shop_contact' => $this -> input -> post('shop_contact')
            );
			$this->db->where('shop_id', $this -> input -> post('shop_id'));
			 $data_update= $this->db->update('shop_setup', $data); 	
			 return $data_update;
		}
		/***********************
		* Shop Modify
		* 2016-12-24
		* Ovi
		************************/
		/***********************
		* Invoice Modify
		* 2016-12-24
		* Ovi
		************************/
		function get_invoice_info_modify()
		{
			$invoice_id = $this -> input -> post('invoice_id');
			$start_date = $this -> input -> post('start_date');
			$end_date = $this -> input -> post('end_date');
			
			
			$this -> db -> select('invoice_info.*,users.user_full_name');
			$this -> db -> from('invoice_info,users');
			$this -> db -> where('invoice_info.invoice_creator=users.id');
			if($invoice_id!=''){$this->db->where('invoice_info.invoice_id = "'.$invoice_id.'"');}
			if($start_date!=''){$this->db->where('invoice_info.invoice_doc >= "'.$start_date.'"');}

			if($end_date!='')
			{
				$this->db->where('invoice_info.invoice_doc <= "'.$end_date.'"');
			}
			else if($start_date!=''){
				$this->db->where('invoice_info.invoice_doc <= "'.$start_date.'"');
			}
			$query = $this -> db -> get();
			return $query;		
		}
		function get_single_invoice_info_modify($invoice_id)
		{
			$this->db->select('invoice_info.*,users.user_full_name,customer_info.customer_name');
			$this->db->from('invoice_info,users');
			$this->db->join('customer_info','invoice_info.customer_id = customer_info.customer_id','left');
			$this->db->where('invoice_info.invoice_creator=users.id');
			$this->db->where('invoice_info.invoice_id = "'.$invoice_id.'"');
			$query = $this -> db -> get();
			return $query;		
		}
		function get_single_invoice_product_info_modify($invoice_id)
		{
			$this->db->select('sale_details.*,product_info.product_name');
			$this->db->from('invoice_info,sale_details,product_info');
			$this->db->where('invoice_info.invoice_id=sale_details.invoice_id');
			$this->db->where('product_info.product_id=sale_details.product_id');
			$this->db->where('sale_details.invoice_id = "'.$invoice_id.'"');
			$query = $this -> db -> get();
			return $query;		
		}
		public function getReturnId($invoice_id)
        {
            $data = $this->db->select('sub_id')->where('transaction_purpose="sale_return"')->where('common_id', $invoice_id)->get('transaction_info');
            if($data->num_rows() > 0)
			{
                $row_data = $data->row();
                return $row_data->sub_id;
            }
            else return 0;
        }   
		public function getReturnAdjustAmount($invoice_id)
        {
            $data = $this->db->select('amount')->where('transaction_purpose="sale_return"')->where('common_id', $invoice_id)->get('transaction_info');
            if($data->num_rows() > 0)
			{
                $row_data = $data->row();
                return $row_data->amount;
            }
            else return 0;
        }  
		/***********************
		* Invoice Modify
		* 2018-02-01
		* Ovi
		************************/
		/***********************
		* Category / Group Modify
		* 2016-12-24
		* Ovi
		************************/
		function get_catagory_info_modify()
		{
			$status = $this -> input -> post('status');
			if($status!='')
			{
				$this->db->select('*');
				$this->db->from('catagory_info');
				$query = $this->db->get();
				return $query;
			}			
		}
		function specific_catagory_new($catagory_id)
		{
			$this -> db -> select('catagory_info.*');
			$this -> db -> from('catagory_info');
			$this -> db -> where('catagory_info.catagory_id = "'.$catagory_id.'"');
			$query = $this -> db -> get();
			return $query->row();
		}
		function save_catagory_info_edit($hid)
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$new_update_data = array(		
				'catagory_name' => $this -> input ->post('catagory_name'),
				'catagory_description' => $this -> input ->post('catagory_description'),
				'catagory_dom' => $bd_date
			);
		
			$this->db->where('catagory_id', $hid);
			$this -> db -> update('catagory_info', $new_update_data);

			return true;
		}
		function delete_catagory($catagory_id)
		{
			$this->db->where('catagory_id', $catagory_id);
			$this->db->delete('catagory_info'); 

			return true;
		}
		/***********************
		* Category / Group Modify
		* 2016-12-24
		* Ovi
		************************/
		/***********************
		* Company Modify
		* 2016-12-24
		* Ovi
		************************/
		function get_company_info_modify()
		{
			$status = $this -> input -> post('status');
			if($status!='')
			{
				$this->db->select('*');
				$this->db->from('company_info');
				$query = $this->db->get();
				
				return $query;		
			}
		}
		function specific_company_new($company_id)
		{
			$this -> db -> select('company_info.*');
			$this -> db -> from('company_info');
			$this -> db -> where('company_info.company_id = "'.$company_id.'"');
			$query = $this -> db -> get();
			return $query->row();
		}
		function save_company_info_edit($hid)
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$new_update_data = array(		
				'company_name' => $this -> input ->post('company_name'),
				'company_address' => $this -> input ->post('company_address'),
				'company_contact_no' => $this -> input ->post('company_contact'),
				'company_email' => $this -> input ->post('company_email'),
				'company_description' => $this -> input ->post('company_description'),
				'company_dom' => $bd_date
			);
		
			$this->db->where('company_id', $hid);
			$this -> db -> update('company_info', $new_update_data);

			return true;
		}
		function delete_company($company_id)
		{
			$this->db->where('company_id', $company_id);
			$this->db->delete('company_info'); 

			return true;
		}
		
		/***********************
		* Company Modify
		* 2016-12-24
		* Ovi
		************************/
		/***********************
		* Distributor Modify
		* 2016-12-24
		* Ovi
		************************/
		function get_distributor_info_modify()
		{
			$status = $this -> input -> post('status');
			if($status!='')
			{
				$this->db->select('*');
				$this->db->from('distributor_info');
				$query = $this->db->get();
				
				return $query;		
			}
		}
		function specific_distributor_new($distributor_id)
		{
			$this -> db -> select('distributor_info.*');
			$this -> db -> from('distributor_info');
			$this -> db -> where('distributor_info.distributor_id = "'.$distributor_id.'"');
			$query = $this -> db -> get();
			return $query->row();
		}
		function save_distributor_info_edit($hid)
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$new_update_data = array(		
				'distributor_name' => $this -> input ->post('distributor_name'),
				'distributor_address' => $this -> input ->post('distributor_address'),
				'distributor_contact_no' => $this -> input ->post('distributor_contact'),
				'distributor_email' => $this -> input ->post('distributor_email'),
				'distributor_description' => $this -> input ->post('distributor_description'),
				'int_balance' => $this -> input ->post('distributor_balance'),
				'distributor_dom' => $bd_date
			);
		
			$this->db->where('distributor_id', $hid);
			$this -> db -> update('distributor_info', $new_update_data);

			return true;
		}
		function delete_distributor($distributor_id)
		{
			$this->db->where('distributor_id', $distributor_id);
			$this->db->delete('distributor_info'); 

			return true;
		}
		/***********************
		* Distributor Modify
		* 2016-12-24
		* Ovi
		************************/
		/***********************
		* Customer Modify
		* 2016-12-24
		* Ovi
		************************/
		function get_customer_info_modify()
		{
			$status = $this -> input -> post('status');
			if($status!='')
			{
				$this->db->select('*');
				$this->db->from('customer_info');
				$query = $this->db->get();
				
				return $query;		
			}
		}
		function specific_customer_new($customer_id)
		{
			$this -> db -> select('customer_info.*');
			$this -> db -> from('customer_info');
			$this -> db -> where('customer_info.customer_id = "'.$customer_id.'"');
			$query = $this -> db -> get();
			return $query->row();
		}
		function save_customer_info_edit($hid)
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$new_update_data = array(		
			   'customer_name' => $this -> input -> post('customer_name'),
               'customer_mode' => $this -> input -> post('customer_mode'),
               'customer_address' => $this -> input -> post('customer_address'),
               'customer_contact_no' => $this -> input -> post('customer_contact'),
               'customer_email' => $this -> input -> post('customer_email'),
               'int_balance' => $this -> input -> post('customer_balance'),
               'customer_dom' => $bd_date
			);
			$this->db->where('customer_id', $hid);
			$this->db->update('customer_info', $new_update_data); 	

			return true;
		}
		function delete_customer($customer_id)
		{
			$this->db->where('customer_id', $customer_id);
			$this->db->delete('customer_info'); 

			return true;
		}
		/***********************
		* Customer Modify
		* 2016-12-24
		* Ovi
		************************/
		/***********************
		* Staff Modify
		* 2018-06-11
		* Ovi
		************************/
		function specific_staff_new($staff_id)
		{
			$this -> db -> select('*');
			$this -> db -> from('employee_info');
			$this -> db -> where('employee_id',$staff_id);
			$query = $this -> db -> get();
			return $query->row();
		}
		function save_staff_info_edit($hid)
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$new_update_data = array(		
			   'employee_name' => $this -> input -> post('employee_name'),
               'employee_address' => $this -> input -> post('employee_address'),
               'employee_contact_no' => $this -> input -> post('employee_contact_no'),
               'employee_type' => $this -> input -> post('employee_type'),
               'employee_dom' => $bd_date
			);
			$this->db->where('employee_id', $hid);
			$this->db->update('employee_info', $new_update_data); 	

			return true;
		}
		function delete_staff($staff_id)
		{
			$this->db->where('employee_id', $staff_id);
			$this->db->delete('employee_info'); 

			return true;
		}
		/***********************
		* Staff Modify
		* 2018-06-11
		* Ovi
		************************/
		
		/***********************
		* Damage Modify
		* 2016-12-24
		* Ovi
		************************/
		function get_damage_info_modify()
		{
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			
			$this->db->select('damage_product.*,product_info.product_name,bulk_stock_info.stock_amount');
			$this->db->from('damage_product,product_info,bulk_stock_info');
			$this->db->where('damage_product.product_id=product_info.product_id');
			$this->db->where('damage_product.product_id=bulk_stock_info.product_id');
			if($start_date!=''){$this->db->where('damage_product.doc >= "'.$start_date.'"');}

			if($end_date!='')
			{
				$this->db->where('damage_product.doc <= "'.$end_date.'"');
			}
			else if($start_date!=''){
				$this->db->where('damage_product.doc <= "'.$start_date.'"');
			}
			$query = $this->db->get();
			
			return $query;
		}
		function specific_damage_new($damage_id)
		{
			$this -> db -> select('damage_product.*,bulk_stock_info.stock_amount');
			$this -> db -> from('damage_product,bulk_stock_info');
			$this->db->where('damage_product.product_id=bulk_stock_info.product_id');
			$this -> db -> where('damage_product.damage_id = "'.$damage_id.'"');
			$query = $this -> db -> get();
			return $query->row();
		}
		function save_damage_info_edit($hid)
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			
			$damage_quantity = $this -> input -> post('damage_quantity');
			$hidden_quantity = $this -> input -> post('hidden_quantity');
			$stock = $this -> input -> post('stock');
			$product_id = $this -> input -> post('product_id');
			
			if($damage_quantity > $hidden_quantity)
			{
				$final_stock = $damage_quantity - $hidden_quantity;
				$main_stock = $stock - $final_stock;
			}
			else
			{
				$final_stock = $hidden_quantity - $damage_quantity;
				$main_stock = $stock + $final_stock;
			}
			
			$data = array(
			   'damage_quantity' => $damage_quantity,
			   'doc' => $bd_date
			);
			$this->db->where('damage_id', $hid);
			$this->db->update('damage_product', $data); 
				
			$new_update_stock = array(		
			   'stock_amount' => $main_stock
			);
			$this->db->where('product_id', $product_id);
			$this->db->update('bulk_stock_info', $new_update_stock); 	

			return true;
		}
		function delete_damage($damage_id,$quantity,$product_id)
		{
			
			$this->db->select('stock_amount');
			$this->db->from('bulk_stock_info');
			$this->db->where('bulk_stock_info.product_id',$product_id);
			$query = $this->db->get();
			$field = $query->row();
			$stock_amount = $field->stock_amount;
			$new = $stock_amount + $quantity;
			
			$data = array
			(
				'stock_amount' => $new
			);
			$this->db->where('product_id', $product_id);
			$this->db->update('bulk_stock_info',$data); 
			
			
			$this->db->where('damage_id', $damage_id);
			$this->db->delete('damage_product'); 

			return true;
		}
		/***********************
		* Damage Modify
		* 2016-12-24
		* Ovi
		************************/
		/***********************
		* Product Modify
		* 2016-12-24
		* Ovi
		************************/
		function all_select_list($table_name,$value_field,$option_field)
		{
			$query = $this->db->from($table_name)
							  -> get();
			if($option_field == 'catagory_name'){
				$select[''] = 'Select Catagory ';
			}
			else if($option_field == 'company_name'){
				$select[''] = 'Select Company ';
			}
			else if($option_field == 'unit_name'){
				$select[''] = 'Select Unit ';
			}
			if($query->num_rows() > 0){
				foreach($query->result() as $field){
					$select[$field->$option_field] = $field->$option_field;
				}
			}
			return $select;
		}
		public function search_and_get_product($key, $field_name)
        {

            $data = $this->db
            ->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price, general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_specification')
            ->like($field_name, $key, 'after')
            ->order_by($field_name, 'asc')
            ->from('product_info')
            ->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left')
            ->group_by('product_info.product_id')
            ->get();
            
            if($data->num_rows() > 0)return $data;
            else return false;

        }
		function all_stock_report_by_barcode($barcode)
		{

			$barcode2= rawurlencode($barcode);
			$barcode1 = rawurldecode($barcode2);

			$this->db->select('product_name, company_name, catagory_name,product_size, unit_name,product_model, product_info.product_id, bulk_unit_sale_price,general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_specification,product_type,product_size');
			$this->db->from('product_info');
			$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
			//$this->db->where('bulk_stock_info.stock_amount > 0'); 
			$this->db->where('product_info.barcode = "'.$barcode1.'" ');
			$this->db->order_by('product_info.product_id','asc'); 
			$this->db->order_by('product_info.product_name','asc'); 
			$query = $this->db->get();
			return $query;
		} 
		function get_product_info_by_multi()
		{

			$barcode= $this->input->post('barcode');
			$pro_id= $this->input->post('pro_id');
			$catagory_name= $this->input->post('catagory_name');
			$company_name= $this->input->post('company_name');
			$barcode1 = rawurldecode($barcode);
			$category1 = rawurldecode($catagory_name);
			$company1 = rawurldecode($company_name);
			$this->db->select('product_info.product_name, product_info.company_name,product_model, product_info.product_size, product_info.catagory_name,product_info.unit_name, product_info.product_id,bulk_stock_info.bulk_unit_sale_price, bulk_stock_info.bulk_unit_buy_price,bulk_stock_info.bulk_alarming_stock,bulk_stock_info.stock_amount,bulk_stock_info.general_unit_sale_price,product_info.barcode');
			$this->db->from('product_info,bulk_stock_info');
			$this->db->where('product_info.product_id = bulk_stock_info.product_id');
			//$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
			if($barcode1!=''){$this->db->where('product_info.barcode = "'.$barcode1.'" ');}
			if($pro_id!=''){$this->db->where('product_info.product_id = "'.$pro_id.'" ');}
			if($category1!=''){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
			if($company1!=''){$this->db->where('product_info.company_name = "'.$company1.'" ');}
			$query = $this->db->get();
			
			return $query;
			
		}
		function specific_product_new( $product_id )
		 {
			$this -> db -> select('product_info.product_name,product_info.company_name,product_info.product_model,product_info.product_size,product_info.catagory_name,product_info.barcode,product_info.unit_name,bulk_stock_info.product_id,bulk_stock_info.general_unit_sale_price,bulk_stock_info.bulk_unit_buy_price,bulk_stock_info.bulk_unit_sale_price,bulk_stock_info.stock_amount');
			$this -> db -> from('product_info,bulk_stock_info');
			$this -> db -> where('product_info.product_id = bulk_stock_info.product_id');
			$this -> db -> where('product_info.product_id = "'.$product_id.'"');
			$query = $this -> db -> get();
			return $query->row();
		 }
			
		function save_product_info_edit($hid)
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$new_update_data = array(		
				'product_name' => $this -> input ->post('product'),
				'product_size' => $this -> input ->post('product_size'),
				'product_model' => $this -> input ->post('product_model'),
				'barcode' => $this -> input ->post('barcode'),
				'catagory_name' => $this -> input ->post('catagory'),
				'company_name' => $this -> input ->post('company'),
				'unit_name' => $this -> input ->post('unit'),
				'product_dom' => $bd_date
			);
		
			$this->db->where('product_id', $hid);
			$this -> db -> update('product_info', $new_update_data);
			
			$new_update_data2 = array(		
				'stock_amount' => $this -> input ->post('quantity'),
				'bulk_unit_buy_price' => $this -> input ->post('buy_price'),
				'bulk_unit_sale_price' => $this -> input ->post('sale_price'),
				'general_unit_sale_price' => $this -> input -> post('ex_sale_price'),
				'stock_dom' => $bd_date
			);
		
			$this->db->where('product_id', $hid);
			$this -> db -> update('bulk_stock_info', $new_update_data2);
		
			return true;
		}
		function delete_product($product_id)
		{
			$this->db->where('product_id',$product_id);
			$this->db->delete('bulk_stock_info');
			
			$this->db->where('product_id',$product_id);
			$this->db->delete('product_info');
		
			return true;
		}
		/***********************
		* Product Modify
		* 2016-12-24
		* Ovi
		************************/
		/***********************
		* Expense Modify
		* 2016-12-24
		* Ovi
		************************/
		function update_expense_new(){
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$creator 			= $this->tank_auth->get_user_id();
			$shop_id 			= $this -> tank_auth -> get_shop_id();
		  	$dataa = array(
               'expense_amount' => $this -> input -> post('expense_amount'),
               'total_paid' => $this -> input -> post('total_paid'),
               'expense_dom' => $bd_date
            );
			$this->db->where('expense_id', $this -> input -> post('expense_id'));
			$this->db->update('expense_info', $dataa);
			
			
			
				
				$queryyas1= $this->db->select('transaction_ref_details_id,transaction_ref_details_doc')
							->from('transaction_ref_details')
							->where('ref_id',$this -> input -> post('expense_id'))
							->where('transaction_ref_details.transaction_purpose','expense')
							->get();
				$data = $queryyas1->result();
					foreach($data as $field){
						$transaction_ref_details_id = $field->transaction_ref_details_id;
						$transaction_ref_details_doc = $field->transaction_ref_details_doc;
					
					
					$new_transaction_ref_details_insert_data = array(
						'ref_id'				 			=> $this -> input -> post('expense_id'),
						'transaction_amount' 				=> $this -> input -> post('total_paid'),
						'transaction_type' 					=> 'out',
						'transaction_purpose' 				=> 'expense',
						'transaction_table_ref_name' 		=> 'expense_info',
						'transaction_table_ref_id_field' 	=> 'expense_id',
						'transaction_ref_details_doc' 		=> $transaction_ref_details_doc,
						'transaction_ref_details_dom' 		=> $bd_date,
						'transaction_ref_details_creator' 	=> $creator
					);	
					$this->db->where('ref_id', $this -> input -> post('expense_id'));
					$this->db->where('transaction_purpose', 'expense');
					$this->db->update('transaction_ref_details', $new_transaction_ref_details_insert_data);
					
					$new_transaction_details_insert_datasde = array(
				
						'transaction_reference_id' 			=> $transaction_ref_details_id,
						'shop_id' 							=> $shop_id,
						'transaction_amount' 				=> $this -> input -> post('total_paid'),
						'transaction_type' 					=>'out',
						'transaction_mode' 					=> 'cash',
						'transaction_doc' 					=> $transaction_ref_details_doc,
						'transaction_dom' 					=> $bd_date,
						'transaction_creator' 				=> $creator
					);
					$this->db->where('transaction_reference_id', $transaction_ref_details_id);
					$this->db->update('transaction_details', $new_transaction_details_insert_datasde);
				}
			$this->db->select('*');
			$this->db->from('expense_info');
			$this->db->where('expense_info.expense_id',$this -> input -> post('expense_id'));
			//$this->db->group_by('product_info.product_id');
			//$this->db->order_by('bulk_stock_info.bulk_id','asc');

			$query = $this->db->get();
			$data = $query->row();

			return $data;
		}
		/***********************
		* Expense Modify
		* 2016-12-24
		* Ovi
		************************/
		
		/***********************
		* Cheque Status Modify
		* 2016-12-24
		* Ovi
		************************/
		function all_type_list()
		{
			$data = array
			(
				''  => 'Select Status',
				'active' => 'Hounoured',
				'inactive' => 'Dishounoured',
				'deleted' => 'Delete'
			);
			return $data;
		}
		function specific_cheque($cheque_id)
		{
			$this->db->select('bank_book.*');
			$this->db->from('bank_book');
			$this -> db -> where('bank_book.bb_id = "'.$cheque_id.'"');
			$query = $this -> db -> get();
			return $query->row();
		}
		function save_cheque_status_edit($hid)
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			
			if($this -> input ->post('status') == 'deleted')
			{
				$new_cheque_status = array
				(		
					'status' => $this -> input ->post('status'),
					'dom' => $bd_date
				);
			
				$this->db->where('bb_id', $hid);
				$this -> db -> update('bank_book', $new_cheque_status);
				if($this -> input ->post('ledger_type')=='purchase_payment')
				{
					$this->db->select('*');
					$this->db->from('bank_book');
					$this->db->where('bb_id', $hid);
					$query = $this->db->get();
					$tmp= $query->row();
					$ledger_id = $tmp->ledger_id;
					$transaction_info = array(
						'transaction_purpose' =>'purchase_payment_deleted', 
						'transaction_mode' => 'cheque',
						'ledger_id' => $ledger_id,
						'amount' => $this -> input ->post('amount'),
						'date' => $bd_date,
						'status' => 'active',
						'creator' => $creator,
						'doc' => $bd_date,
						'dom' => $bd_date
					);
					$this -> db -> insert('transaction_info',$transaction_info);
					$insert_id = $this->db->insert_id();
					
					$new_cheque_transaction = array
					(		
						'transaction_id' => $insert_id
					);
				
					$this->db->where('bb_id', $hid);
					$this -> db -> update('bank_book', $new_cheque_transaction);
				}
				else if($this -> input ->post('ledger_type')=='sale_collection')
				{
					$this->db->select('*');
					$this->db->from('bank_book');
					$this->db->where('bb_id', $hid);
					$query = $this->db->get();
					$tmp= $query->row();
					$ledger_id = $tmp->ledger_id;
					
					$transaction_info = array(
						'transaction_purpose' =>'sale_collection_deleted', 
						'transaction_mode' => 'cheque',
						'ledger_id' => $ledger_id,
						'amount' => $this -> input ->post('amount'),
						'date' => $bd_date,
						'status' => 'active',
						'creator' => $creator,
						'doc' => $bd_date,
						'dom' => $bd_date
					);
					$this -> db -> insert('transaction_info',$transaction_info);
					$insert_id = $this->db->insert_id();
					
					$new_cheque_transaction = array
					(		
						'transaction_id' => $insert_id
					);
				
					$this->db->where('bb_id', $hid);
					$this -> db -> update('bank_book', $new_cheque_transaction);
				}
				else if($this -> input ->post('ledger_type')=='expense_payment')
				{
					$this->db->select('*');
					$this->db->from('bank_book');
					$this->db->where('bb_id', $hid);
					$query = $this->db->get();
					$tmp= $query->row();
					$ledger_id = $tmp->ledger_id;
					
					$transaction_info = array(
						'transaction_purpose' =>'expense_payment_deleted', 
						'transaction_mode' => 'cheque',
						'ledger_id' => $ledger_id,
						'sub_id' => $sub_id,
						'amount' => $this -> input ->post('amount'),
						'date' => $bd_date,
						'status' => 'active',
						'creator' => $creator,
						'doc' => $bd_date,
						'dom' => $bd_date
					);
					$this -> db -> insert('transaction_info',$transaction_info);
					$insert_id = $this->db->insert_id();
					
					$new_cheque_transaction = array
					(		
						'transaction_id' => $insert_id
					);
				
					$this->db->where('bb_id', $hid);
					$this -> db -> update('bank_book', $new_cheque_transaction);
				}
			}
			else if($this -> input ->post('status') == 'active')
			{
				$new_cheque_status = array
				(		
					'status' => $this -> input ->post('status'),
					'dom' => $bd_date
				);
			
				$this->db->where('bb_id', $hid);
				$this -> db -> update('bank_book', $new_cheque_status);
				if($this -> input ->post('ledger_type')=='purchase_payment')
				{
					$this->db->select('*');
					$this->db->from('bank_book');
					$this->db->where('bb_id', $hid);
					$query = $this->db->get();
					$tmp= $query->row();
					$ledger_id = $tmp->ledger_id;
					$transaction_info = array(
						'transaction_purpose' =>'payment', 
						'transaction_mode' => 'cheque',
						'ledger_id' => $ledger_id,
						'amount' => $this -> input ->post('amount'),
						'date' => $bd_date,
						'status' => 'active',
						'creator' => $creator,
						'doc' => $bd_date,
						'dom' => $bd_date
					);
					$this -> db -> insert('transaction_info',$transaction_info);
					$insert_id = $this->db->insert_id();
					
					$new_cheque_transaction = array
					(		
						'transaction_id' => $insert_id
					);
				
					$this->db->where('bb_id', $hid);
					$this -> db -> update('bank_book', $new_cheque_transaction);
				}
				else if($this -> input ->post('ledger_type')=='sale_collection')
				{
					$this->db->select('*');
					$this->db->from('bank_book');
					$this->db->where('bb_id', $hid);
					$query = $this->db->get();
					$tmp= $query->row();
					$ledger_id = $tmp->ledger_id;
					
					$transaction_info = array(
						'transaction_purpose' =>'credit_collection', 
						'transaction_mode' => 'cheque',
						'ledger_id' => $ledger_id,
						'amount' => $this -> input ->post('amount'),
						'date' => $bd_date,
						'status' => 'active',
						'creator' => $creator,
						'doc' => $bd_date,
						'dom' => $bd_date
					);
					$this -> db -> insert('transaction_info',$transaction_info);
					$insert_id = $this->db->insert_id();
					
					$new_cheque_transaction = array
					(		
						'transaction_id' => $insert_id
					);
				
					$this->db->where('bb_id', $hid);
					$this -> db -> update('bank_book', $new_cheque_transaction);
				}
				else if($this -> input ->post('ledger_type')=='expense_payment')
				{
					$this->db->select('*');
					$this->db->from('bank_book');
					$this->db->where('bb_id', $hid);
					$query = $this->db->get();
					$tmp= $query->row();
					$ledger_id = $tmp->ledger_id;
					
					$transaction_info = array(
						'transaction_purpose' =>'expense_payment', 
						'transaction_mode' => 'cheque',
						'ledger_id' => $ledger_id,
						'sub_id' => $sub_id,
						'amount' => $this -> input ->post('amount'),
						'date' => $bd_date,
						'status' => 'active',
						'creator' => $creator,
						'doc' => $bd_date,
						'dom' => $bd_date
					);
					$this -> db -> insert('transaction_info',$transaction_info);
					$insert_id = $this->db->insert_id();
					
					$new_cheque_transaction = array
					(		
						'transaction_id' => $insert_id
					);
				
					$this->db->where('bb_id', $hid);
					$this -> db -> update('bank_book', $new_cheque_transaction);
				}
			}
			else if($this -> input ->post('status') == 'inactive')
			{
				$this->db->select('*');
				$this->db->from('bank_book');
				$this->db->where('bb_id', $hid);
				$query = $this->db->get();
				$tmp= $query->row();
				$transaction_id = $tmp->transaction_id;
				
				$this->db->where('transaction_id', $transaction_id);
				$this->db->delete('transaction_info');
				
				$new_cheque_transaction = array
				(		
					'transaction_id' => 0,
					'status' => $this -> input ->post('status'),
					'dom' => $bd_date
				);
			
				$this->db->where('bb_id', $hid);
				$this->db->update('bank_book', $new_cheque_transaction);
			}
			return true;
		}
		/***********************
		* Cheque Status Modify
		* 2016-12-24
		* Ovi
		************************/
		/*****************************************************
		 * Update Total Purchase Price Of a Purchase Receipt *
		 * ***************************************************/
		function total_purchase_price_modify_apply()
		{
			/******* Modified 27-10-2013 *****/
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			
			$receipt_id = $this -> input -> post('receipt_id');
			$new_grand_total = $this -> input -> post('new_grand_total');
			$new_transport_cost = $this -> input -> post('new_transport_cost');
			$purchase_amount = $this -> input -> post('purchase_amount');
			$gift_on_purchase = $this -> input -> post('gift_on_purchase');
			
			$query = $this -> db -> select('*')
								 -> from('purchase_receipt_info')
								 -> where('receipt_id',$receipt_id)
								 -> get();

			foreach($query -> result() as $field):
				$prev_grand_total = $field -> grand_total;
				$prev_transport_cost = $field -> transport_cost;
			endforeach;
			

			$this -> db -> query("UPDATE purchase_receipt_info
								  SET purchase_amount = '".$purchase_amount."',grand_total = '".$new_grand_total."',gift_on_purchase = '".$gift_on_purchase."',transport_cost = '".$new_transport_cost."'
								  WHERE receipt_id = '".$receipt_id."'
								  AND shop_id = '".$this->tank_auth->get_shop_id()."'
								");
			$this -> db -> query("UPDATE expense_info
								  SET expense_amount = '".$new_transport_cost."'
								  WHERE service_provider_id = '".$receipt_id."'
								  AND expense_type = 'Transport Cost For Purchase'
								  AND shop_id = '".$this->tank_auth->get_shop_id()."'
								 ");
			$this -> db -> query("UPDATE transaction_info
								  SET amount = '".$new_grand_total."'
								  WHERE common_id = '".$receipt_id."'
								  AND transaction_purpose = 'purchase'
								 ");
								  
			$this -> db -> query("UPDATE transaction_info
								  SET amount = '".$new_transport_cost."'
								  WHERE common_id = '".$receipt_id."'
								  AND transaction_purpose = 'expense'
								 ");
								  
								  
			$all_product = $this -> db -> select('product_id, purchase_quantity,purchase_id, unit_buy_price')
								 -> from('purchase_info')
								 -> where('purchase_receipt_id = "'.$receipt_id.'"')
								 -> get();
								 
								 
			$previous_added_price_ratio = (( $prev_grand_total + $prev_transport_cost ) / $prev_grand_total );
			$new_add_price_ratio = (( $new_grand_total + $new_transport_cost ) / $new_grand_total );
			
			foreach($all_product -> result() as $field):
				$product_id = $field -> product_id;
				$unit_buy_price = $field -> unit_buy_price;
				$purchase_quantity = $field -> purchase_quantity;
				
				$specific_purchase_product = $this -> specific_product_details_from_bulk_stock_info( $product_id );
				foreach($specific_purchase_product -> result() as $bulk_stock_details):
					$stock_quantity = $bulk_stock_details -> stock_amount;
					$stock_avg_price = $bulk_stock_details -> bulk_unit_buy_price;
				endforeach;
				$previous_incresed_price = $previous_added_price_ratio * $unit_buy_price;
				$new_increased_price = $new_add_price_ratio * $unit_buy_price;
				$unit_change = $new_increased_price - $previous_incresed_price;
				$total_change = $unit_change * $purchase_quantity;
				$new_total_price = ( $stock_quantity * $stock_avg_price ) + $total_change;
				
				if( $stock_quantity )
					$temp_stock_quantity = $stock_quantity;
				else $temp_stock_quantity = 1;
				$new_avg_price =  $new_total_price / $temp_stock_quantity;
				
				$data = array(
				   'bulk_unit_buy_price' => $new_avg_price,
				   'stock_dom' => $bd_date
				);
				$this->db->where('product_id', $product_id);
				$this->db->where('shop_id', $this -> shop_id);
				$this->db->update('bulk_stock_info', $data);
			endforeach;			
			/***** end modification 27-10-2013 ***/
								  
			return true;
			
		}
		
		function specific_product_details_from_bulk_stock_info( $product_id )
		{
			$query = $this -> db -> select('*')
								   -> from('bulk_stock_info')
								   -> where('product_id' ,$product_id)
								   -> where('shop_id', $this -> shop_id)
								   -> get();
			 return $query;
		}
	}
		
	
