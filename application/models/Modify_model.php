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
		function modify_single_invoice($invoice_id)
		{
			/**********************************
			* 1
			* 2019-04-17
			* If invoice has sale return Start
			***********************************/
				$this->db->select('*');
				$this->db->from('invoice_info');
				$this->db->where('invoice_info.invoice_id = "'.$invoice_id.'"');
				$query = $this -> db -> get();
				$tmp  = $query->row();	
				$sale_return_amount = $tmp->sale_return_amount;
				if($sale_return_amount!='')
				{
					$data = $this->db->select('sub_id')->where('transaction_purpose="sale_return"')->where('common_id', $invoice_id)->get('transaction_info');
					$tmp2 = $data->row();
					$sub_id = $tmp2->sub_id;
					
					$this->db->select('*');
					$this->db->from('sale_return_main_product');
					$this->db->where('sale_return_main_product.return_list_id',$sub_id);
					$query1 = $this->db->get();
					$i=1;
					foreach($query1->result() as $tmp1)
					{
						$this->db->set('stock_amount', 'stock_amount-' . $tmp1->return_quantity, FALSE);
						$this->db->where('product_id', $tmp1->produ_id);
						$this->db->update('bulk_stock_info');
						$i++;
					}

					$this->db->select('*');
					$this->db->from('sale_return_main_product');
					$this->db->where('sale_return_main_product.return_list_id',$sub_id);
					$query11 = $this->db->get();
					$tmp = $query11->result();
					$srmp_id = $tmp->srmp_id;
					
					$this->db->select('*');
					$this->db->from('sale_return_warranty_product');
					$this->db->where('sale_return_warranty_product.srmp_id="'.$srmp_id.'"');
					$query2 = $this->db->get();
					if($query2->num_rows > 0)
					{
						$ii=1;
						foreach($query2->result() as $tmp2)
						{
							$data=array
							(
								'invoice_id'=>$tmp->invoice_id,
								'sale_price'=>$tmp->sale_price,
								'sale_date'=>$tmp->sale_date,
								'status'=>3
							);
							$this->db->where('warranty_product_list.ip_id',$tmp2->ip_id);
							$this->db->where('warranty_product_list.product_id',$tmp2->product_id);
							$this->db->update('warranty_product_list',$data);

							$ii++;
						}
						 
					}
					$this->db->where('srl_id', $sub_id);
					$this->db->delete('sale_return_list'); 
					
					$this->db->where('return_list_id', $sub_id);
					$this->db->delete('sale_return_main_product'); 
					
					$this->db->where('srmp_id', $srmp_id);
					$this->db->delete('sale_return_warranty_product');
					
					$this->db->where('common_id', $invoice_id);
					$this->db->where('sub_id', $sub_id);
					$this->db->delete('transaction_info');

				}
			/**********************************
			* 1
			* 2019-04-17
			* If invoice has sale return Start
			***********************************/
			/**********************************
			* 2
			* 2019-04-17
			* Delete invoice Start
			***********************************/
			
				$this->db->where('invoice_id', $invoice_id);
				$this->db->delete('invoice_info'); 
			
			/**********************************
			* 2
			* 2019-04-17
			* Delete invoice End
			***********************************/
			/**********************************
			* 3
			* 2019-04-17
			* Select & Delete sale details Start
			***********************************/
				$this->db->select('*');
				$this->db->from('sale_details');
				$this->db->where('sale_details.invoice_id',$invoice_id);
				$query22 = $this->db->get();
				$iii=1;
				foreach($query22->result() as $tmp2)
				{
					$this->db->set('stock_amount', 'stock_amount+' . $tmp2->sale_quantity, FALSE);
					$this->db->where('product_id', $tmp2->product_id);
					$this->db->update('bulk_stock_info');
					
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('product_id', $tmp2->product_id);
					$this->db->delete('sale_details');
					$iii++;
				}
			/**********************************
			* 3
			* 2019-04-17
			* Select & Delete sale details End
			***********************************/
			
			/**********************************
			* 4-5
			* 2019-04-17
			* Select & Delete warranty sale details Start
			***********************************/
				$this->db->select('*');
				$this->db->from('warranty_product_sale_details');
				$this->db->where('warranty_product_sale_details.invoice_id',$invoice_id);
				$query33 = $this->db->get();
				$iv=1;
				foreach($query33->result() as $tmp3)
				{
					$data=array
					(
						'invoice_id'=>0,
						'sale_price'=>0,
						'sale_date'=>0000-00-00,
						'status'=>1
					);
					$this->db->where('warranty_product_list.ip_id',$tmp3->ip_id);
					$this->db->where('warranty_product_list.product_id',$tmp3->product_id);
					$this->db->update('warranty_product_list',$data);
					
					$this->db->where('ip_id', $tmp3->ip_id);
					$this->db->where('invoice_id', $invoice_id);
					$this->db->where('product_id', $tmp3->product_id);
					$this->db->delete('warranty_product_sale_details');
					$iv++;
				}
			/**********************************
			* 4-5
			* 2019-04-17
			* Select & Delete warranty sale details End
			***********************************/
			
			/**********************************
			* 6
			* 2019-04-17
			* Cash & Bank Book Select & Delete Start
			***********************************/
				$this->db->select('*');
				$this->db->from('transaction_info');
				$this->db->where('transaction_info.transaction_purpose="collection"');
				$this->db->where('transaction_info.common_id', $invoice_id);
				$query44 = $this->db->get();
				$tmp4 = $query44->row();
				
				$this->db->where('transaction_id', $tmp4->transaction_id);
				$this->db->delete('cash_book'); 
				
				$this->db->where('transaction_id', $tmp4->transaction_id);
				$this->db->delete('bank_book');
				
			/**********************************
			* 6
			* 2019-04-17
			* Cash & Bank Book Select & Delete End
			***********************************/
			
			/**********************************
			* 7
			* 2019-04-17
			* Transaction info Delete Start
			***********************************/
			
				$this->db->where('transaction_purpose="sale"');
				$this->db->where('common_id', $invoice_id);
				$this->db->delete('transaction_info'); 
				
				$this->db->where('transaction_purpose="delivery_charge"');
				$this->db->where('common_id', $invoice_id);
				$this->db->delete('transaction_info'); 
				
				$this->db->where('transaction_purpose="collection"');
				$this->db->where('common_id', $invoice_id);
				$this->db->delete('transaction_info'); 
				
			/**********************************
			* 7
			* 2019-04-17
			* Transaction info Delete End
			***********************************/
			return true;
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
		* Bank Modify
		* 2019-04-16
		* Ovi
		************************/
		function get_bank_info_modify()
		{
			$this->db->select('*');
			$this->db->from('bank_info');
			$query = $this->db->get();
			
			return $query;		
		}
		function specific_bank_new($bank_id)
		{
			$this -> db -> select('bank_info.*');
			$this -> db -> from('bank_info');
			$this -> db -> where('bank_info.bank_id = "'.$bank_id.'"');
			$query = $this -> db -> get();
			return $query->row();
		}
		function save_bank_info_edit($hid)
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$new_update_data = array(		
			   'bank_name' => $this -> input -> post('bank_name'),
               'bank_account_name' => $this -> input -> post('account_name'),
               'bank_account_no' => $this -> input -> post('account_no'),
               'bank_description' => $this -> input -> post('account_description')
			);
			$this->db->where('bank_id', $hid);
			$this->db->update('bank_info', $new_update_data); 	

			return true;
		}
		function delete_bank($bank_id)
		{
			$this->db->where('bank_id', $bank_id);
			$this->db->delete('bank_info'); 

			return true;
		}
		/***********************
		* Bank Modify
		* 2019-04-16
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
		* Transaction Modify
		* 2019-04-02
		* Ovi
		************************/
		function get_transaction_modify()
		{
			$purpose_id=$this->input->post('purpose_id');
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			
			if($purpose_id==1)
			{
				$this->db->select('transaction_info.*,customer_info.customer_name as ledger_name');
				$this->db->from('transaction_info,customer_info');
				$this->db->where('transaction_info.ledger_id=customer_info.customer_id');
				$this->db->where('transaction_info.transaction_purpose="credit_collection"');
				if($start_date!=''){$this->db->where('transaction_info.date >= "'.$start_date.'"');}
				if($end_date!=''){$this->db->where('transaction_info.date <= "'.$end_date.'"');}
				else if($start_date!=''){$this->db->where('transaction_info.date <= "'.$start_date.'"');}
				$query = $this->db->get();
				return $query;
			}
			if($purpose_id==2)
			{
				$this->db->select('transaction_info.*,type_info.type_type as ledger_name');
				$this->db->from('transaction_info,type_info');
				$this->db->where('transaction_info.sub_id=type_info.type_id');
				$this->db->where('transaction_info.transaction_purpose="expense_payment"');
				if($start_date!=''){$this->db->where('transaction_info.date >= "'.$start_date.'"');}
				if($end_date!=''){$this->db->where('transaction_info.date <= "'.$end_date.'"');}
				else if($start_date!=''){$this->db->where('transaction_info.date <= "'.$start_date.'"');}
				$query = $this->db->get();
				return $query;
			}
			if($purpose_id==3)
			{
				$this->db->select('transaction_info.*,distributor_info.distributor_name as ledger_name');
				$this->db->from('transaction_info,distributor_info');
				$this->db->where('transaction_info.ledger_id=distributor_info.distributor_id');
				$this->db->where('transaction_info.transaction_purpose="payment"');
				if($start_date!=''){$this->db->where('transaction_info.date >= "'.$start_date.'"');}
				if($end_date!=''){$this->db->where('transaction_info.date <= "'.$end_date.'"');}
				else if($start_date!=''){$this->db->where('transaction_info.date <= "'.$start_date.'"');}
				$query = $this->db->get();
				return $query;
			}
			if($purpose_id==4)
			{
				$this->db->select('*');
				$this->db->from('transaction_info');
				$this->db->where('(transaction_info.transaction_purpose="from_bank" OR transaction_info.transaction_purpose="to_bank")');
				if($start_date!=''){$this->db->where('transaction_info.date >= "'.$start_date.'"');}
				if($end_date!=''){$this->db->where('transaction_info.date <= "'.$end_date.'"');}
				else if($start_date!=''){$this->db->where('transaction_info.date <= "'.$start_date.'"');}
				$query = $this->db->get();
				return $query;
			}
			if($purpose_id==5)
			{
				$this->db->select('transaction_info.*,owner_info.owner_name as ledger_name');
				$this->db->from('transaction_info,owner_info');
				$this->db->where('transaction_info.ledger_id=owner_info.owner_id');
				$this->db->where('(transaction_info.transaction_purpose="from_owner" OR transaction_info.transaction_purpose="to_owner")');
				if($start_date!=''){$this->db->where('transaction_info.date >= "'.$start_date.'"');}
				if($end_date!=''){$this->db->where('transaction_info.date <= "'.$end_date.'"');}
				else if($start_date!=''){$this->db->where('transaction_info.date <= "'.$start_date.'"');}
				$query = $this->db->get();
				return $query;
			}
		}
		function delete_transaction($transaction_id)
		{
			$this->db->where('transaction_id', $transaction_id);
			$this->db->delete('transaction_info'); 
			
			$this->db->where('transaction_id', $transaction_id);
			$this->db->delete('cash_book'); 
			
			$this->db->where('transaction_id', $transaction_id);
			$this->db->delete('bank_book'); 
			
			$this->db->where('transaction_id', $transaction_id);
			$this->db->delete('owner_book'); 

			return true;
		}
		/***********************
		* Transaction Modify
		* 2019-04-02
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

			$this->db->select('product_name, company_name, catagory_name,product_size, unit_name,product_model, product_info.product_id, bulk_unit_sale_price,general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_specification,product_type,product_size,image_ext');
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
			$this->db->select('product_info.product_name,product_info.product_name_bng, product_info.company_name,product_model, product_info.product_size, product_info.catagory_name,product_info.unit_id, product_info.product_id,bulk_stock_info.bulk_unit_sale_price, bulk_stock_info.bulk_unit_buy_price,bulk_stock_info.bulk_alarming_stock,bulk_stock_info.stock_amount,bulk_stock_info.general_unit_sale_price,product_info.barcode,image_ext');
			$this->db->from('product_info,bulk_stock_info');
			$this->db->where('product_info.product_id = bulk_stock_info.product_id');
			//$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
			if($barcode1!='' && $barcode1!='null'){$this->db->where('product_info.barcode = "'.$barcode1.'" ');}
			if($pro_id!='' && $pro_id!='null'){$this->db->where('product_info.product_id = "'.$pro_id.'" ');}
			if($category1!='' && $category1!='null'){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
			if($company1!='' && $company1!='null'){$this->db->where('product_info.company_name = "'.$company1.'" ');}
			$query = $this->db->get();
			
			return $query;
			
		}
		function specific_product_new( $product_id )
		 {
			$this -> db -> select('product_info.product_name,product_info.product_name_bng,product_info.company_name,product_info.product_model,product_info.product_size,product_info.catagory_name,product_info.barcode,product_info.unit_id,bulk_stock_info.product_id,bulk_stock_info.general_unit_sale_price,bulk_stock_info.bulk_unit_buy_price,bulk_stock_info.bulk_unit_sale_price,bulk_stock_info.stock_amount');
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
				'product_name_bng' => $this -> input ->post('product_name_bng'),
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
		function save_product_image($hid)
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');

			$filetype = $_FILES['user_file_3']['type'];
			$queryy1= $this->db->select('image_ext')
								->from('product_info')
								->where('product_id',$hid)
								->get();
			$field = $queryy1->row();
			$image_ext = $field->image_ext;
			$number = ceil($hid/200);


			$dir = './images/product_image/main/'.$number.'/';
			if(!is_dir($dir))
			{
				mkdir('./images/product_image/main/'.$number,0777, true);
				
				$image_id = $hid;
				$this->upload_product_image($image_id);
			}
			else
			{
				$img_folder = $hid.$image_ext;
				unlink("images/product_image/main/".$number.'/'.$img_folder);
				$image_id = $hid;
				$this->upload_product_image($image_id);
			}

			return true;
		}
		function upload_product_image($image_id)
		{
			$number = ceil($image_id/200);
			$file_type2 = $this->get_file_type($_FILES['user_file_3']['type']);
			$user_ext3 = $image_id.'.'.$file_type2;

		
			$_FILES['user_file_3']['name']=$user_ext3;
			$path = $_FILES['user_file_3']['tmp_name'];
			$width = 300;
			$height = 300;
			
			$this->resize_new($width,$height,$path);
			
			$source_img = $path;
			$destination_img = $path;
			
			$d = $this->compress($source_img, $destination_img, 80);
			
			
			$config['upload_path'] 		='./images/product_image/main/'.$number;
			$config['allowed_types'] 	='*';
			
			$this->load->library('upload', $config);
			if($this->upload->do_upload('user_file_3'))
			{
				//echo 'OK';
			}
			else
			{
				//echo 'Not';
				
				//echo $this->upload->display_errors();
			}
			$queryy1= $this->db->select('image_ext')
								->from('product_info')
								->where('product_id',$image_id)
								->get();
			$field = $queryy1->row();
			$image_ext = $field->image_ext;
			$dir = './images/product_image/thumb/'.$number.'/';
			if(!is_dir($dir))
			{
				mkdir('./images/product_image/thumb/'.$number,0777, true);
				$this->thumb($user_ext3,$number);
			}
			else{
				$img_folder = $hid.$image_ext;
				unlink("images/product_image/thumb/".$number.'/'.$img_folder);
				$this->thumb($user_ext3,$number);
			}	
			$image = array(
					'image_ext' => '.'.$file_type2,
					'image_url' => base_url()."images/product_image/main/".$number.'/'.$user_ext3,
				);
			$this->db->where('product_id',$image_id);
			$this->db->update('product_info',$image);
				
		}
		function thumb($filename,$number)
		{

			$config['image_library'] = 'gd2';
			//$config['source_image'] = './uploads/'.$filename.'.jpg';  #no need to make it static as you are allowing multiple extensions in allowed_types.
			$config['source_image'] = './images/product_image/main/'.$number.'/'.$filename;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['thumb_marker'] = '';
			$config['width']    = 100;
			$config['height']   = 100;
			$config['new_image'] = './images/product_image/thumb/'.$number.'/'.$filename;
			$this->load->library('image_lib', $config); 

			$this->image_lib->initialize($config);

			if(!$this->image_lib->resize()) {
				echo $this->image_lib->display_errors();
				return FALSE;
			}
			
		}
		function resize_new($width, $height,$path)
		{
		  /* Get original image x y*/
			  list($w, $h) = getimagesize($_FILES['user_file_3']['tmp_name']);
			  /* calculate new image size with ratio */
			  $ratio = max($width/$w, $height/$h);
			  $h = ceil($height / $ratio);
			  $x = ($w - $width / $ratio) / 2;
			  $w = ceil($width / $ratio);
			  /* new file name */
			  //$path = 'upload/'.$width.'x'.$height.'_'.$_FILES['fileToUpload']['name'];
			  //$path = 'upload/'. basename($_FILES["user_avatar"]["name"]);
			  /* read binary data from image file */
			  $imgString = file_get_contents($_FILES['user_file_3']['tmp_name']);
			  /* create image from string */
			  $image = imagecreatefromstring($imgString);
			  $tmp = imagecreatetruecolor($width, $height);
			  imagecopyresampled($tmp, $image,
				0, 0,
				$x, 0,
				$width, $height,
				$w, $h);
			  /* Save image */
			  switch ($_FILES['user_file_3']['type']) 
			  {
				case 'image/jpeg':
				  imagejpeg($tmp, $path, 100);
				  break;
				case 'image/png':
				  imagepng($tmp, $path, 0);
				  break;
				case 'image/gif':
				  imagegif($tmp, $path);
				  break;
				default:
				  exit;
				  break;
			  }
			  return $path;
			  /* cleanup memory */
			  imagedestroy($image);
			  imagedestroy($tmp);
		}

		function compress($source, $destination, $quality) 
		{
			
			  $file_size = filesize($source); // Get file size in bytes
			$file_size = $file_size / 1024; // Get file size in KB
			  if($file_size > 100){
			  $info = getimagesize($source);

			  if ($info['mime'] == 'image/jpeg') 
				  $image = imagecreatefromjpeg($source);

			  elseif ($info['mime'] == 'image/gif') 
				  $image = imagecreatefromgif($source);

			  elseif ($info['mime'] == 'image/png') 
				  $image = imagecreatefrompng($source);

			  imagejpeg($image, $destination, $quality);
			}
			return $destination;
		}
		function get_file_type($filetype)
		{
			if($filetype == "image/jpg")
				$file_type='jpg';
			else if ($filetype == "image/gif")
				$file_type='gif';
			else if($filetype == "image/JPEG")
				$file_type='JPEG';
			else if($filetype == "image/jpeg")
				$file_type='jpeg';
			else if($filetype == "image/pjpeg")
				$file_type='pjpeg';
			else if($filetype ==  "image/png")
				$file_type='JPEG';
			else if($filetype ==  "application/msword")
				$file_type='doc';
			else if($filetype ==  "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
				$file_type='docx';
			else if($filetype ==  "application/pdf")
				$file_type='pdf';
			else if($filetype ==  "application/zip")
				$file_type='zip';
			return $file_type;
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
		function delete_expense_info($expense_id)
		{
			$expense = "expense";
			$this->db->where('expense_id',$expense_id);
			$this->db->delete('expense_info');
			
			$this->db->where('transaction_purpose',$expense);
			$this->db->where('common_id',$expense_id);
			$this->db->delete('transaction_info');
		
			return true;
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

		public function total_purchase_price_modify_apply()
		{
			$bd_date = date('Y-m-d');
			$receipt_id 		= $this->input->post('receipt_id');
			$new_grand_total 	= $this->input->post('new_grand_total');
			$new_transport_cost = $this->input->post('new_transport_cost');
			$purchase_amount 	= $this->input->post('purchase_amount');
			$gift_on_purchase 	= $this->input->post('gift_on_purchase');
			
			$findalamount=$purchase_amount-$gift_on_purchase;

			$this->db->query("UPDATE purchase_receipt_info
								SET purchase_amount = '".$purchase_amount."',final_amount = '".$findalamount."',gift_on_purchase = '".$gift_on_purchase."',transport_cost = '".$new_transport_cost."'WHERE receipt_id = '".$receipt_id."'AND shop_id = '".$this->tank_auth->get_shop_id()."'");
			$this->db->query("UPDATE expense_info
								  SET expense_amount = '".$new_transport_cost."'
								  WHERE service_provider_id = '".$receipt_id."'
								  AND expense_type = 'Transport Cost For Purchase'
								  AND shop_id = '".$this->tank_auth->get_shop_id()."'
								 ");
			$this->db->query("UPDATE transaction_info
								  SET amount = '".$findalamount."'
								  WHERE common_id = '".$receipt_id."'
								  AND transaction_purpose = 'purchase'
								 ");
			$this->db->query("UPDATE transaction_info
								  SET amount = '".$new_transport_cost."'
								  WHERE common_id = '".$receipt_id."'
								  AND transaction_purpose = 'expense'
								 ");
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
		
	
