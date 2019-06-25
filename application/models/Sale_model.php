<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	class Sale_model extends CI_model{
		private $shop_id;
		private $currentUser;
			
		function __construct()
		{
            date_default_timezone_set("Asia/Dhaka");
			$this -> shop_id        = $this -> tank_auth -> get_shop_id();
			$this -> currentUser    = $this -> tank_auth -> get_user_id();
		}
		/*********************************
		* Sale System for Vission Express
		* Start New Sale
		* 25-11-2013
		* Arafat Mamun
		**********************************/
		function add_new_my_sale($current_user, $current_shop)
		{
            $data = array(
				'temp_sale_creator' => $current_user,
				'temp_sale_shop_id' => $current_shop,
				'temp_sale_status' => 1,
			);
			$this -> db -> insert('temp_sale_info', $data);
			return $this -> db -> insert_id();
		}

        /************************************
        * Starting (functions added by Arun) 
        *************************************/
        function search_and_get_product($key, $field_name)
        {
            $data = $this->db
            ->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price, general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_specification')
            ->like($field_name, $key)
            ->order_by($field_name, 'asc')
            ->from('product_info')
            ->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left')
            ->group_by('product_info.product_id')
            ->get();
            
            if($data->num_rows() > 0)return $data;
            else return false;
        }

		public function search_and_get_product_2($key, $field_name)
        {
            $data = $this->db
            ->select('product_name, company_name, catagory_name,product_size,product_model, product_info.product_id, bulk_unit_sale_price, general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_info.product_specification')
            ->like($field_name, $key, 'after')
            //->like($field_name, $key)
            ->order_by($field_name, 'asc')
            ->limit(200)
            ->from('product_info')
            ->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left')
            //->where('bulk_stock_info.stock_amount > 0')
            //->group_by('product_info.product_id')
            ->get();
            
            if($data->num_rows() > 0)return $data;
            else return false;
        }

        public function search_and_get_product_2_test($key, $field_name)
        { 
            $data=$this->db
                 ->limit(300)
                 ->like('product_name',$key)
                 ->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left')
                 ->get('product_info');
            if($data->num_rows() > 0)return $data;
            else return false;
        }
        
        function search_product_and_add_to_my_list($barcode)
        {
            $currrent_temp_sale_id = $this->session->userdata('currrent_temp_sale_id');
            $this->db->select('product_info.*, bulk_stock_info.bulk_unit_buy_price, bulk_stock_info.general_unit_sale_price, bulk_stock_info.general_unit_sale_price,bulk_stock_info.bulk_unit_sale_price,bulk_stock_info.stock_amount')
            ->from('product_info, bulk_stock_info')
            ->where('product_info.product_id = bulk_stock_info.product_id')
            ->where('bulk_stock_info.stock_amount >', 0)
            ->where('barcode', $barcode)->limit(1);
            $query = $this->db->get();

            if($query->num_rows() > 0)
            {
                $tmp_data = $query->row();

                $this->db->select('temp_sale_details.*')
                ->from('temp_sale_details')
                ->where('product_id', $tmp_data->product_id)
                ->where('temp_sale_id', $currrent_temp_sale_id)
                ->limit(1);
                $is_exists = $this->db->get();

                if($is_exists->num_rows() == 0)
                {
                    $temp_sale_details  = array(
                        'temp_sale_id'              => $currrent_temp_sale_id,
                        'product_id'                => $tmp_data->product_id,
                        'stock_id'                  => 0,
                        'sale_quantity'             => 1,
                        'product_specification'     => $tmp_data->product_specification,
                        'sale_type'                 => 1,
                        'discount_info_id'          => 0,
                        'discount'                  => 0,
                        'discount_type'             => 0,
                        'unit_buy_price'            => $tmp_data->bulk_unit_buy_price,
                        'unit_sale_price'           => $tmp_data->bulk_unit_sale_price,
                        'general_unit_sale_price'   => $tmp_data->general_unit_sale_price,
                        'actual_sale_price'         => $tmp_data->bulk_unit_sale_price,
                        'temp_sale_details_status'  => 1,
                        'item_name'                 => $tmp_data->product_name,
                        'stock'                     => $tmp_data->stock_amount - 1
                    );
                    $this->db->insert('temp_sale_details', $temp_sale_details);

                    $this->db->where('product_id', $tmp_data->product_id)->limit(1)
                    ->update('bulk_stock_info', array('stock_amount' => $tmp_data->stock_amount-1));

                    return $tmp_data;
                }
				else if($is_exists->num_rows() != 0)
				{
					$field = $is_exists->row();
					$sale_quantity = $field->sale_quantity;
					
					$data = array(
					'sale_quantity' =>$sale_quantity + 1,
					'stock' =>$tmp_data->stock_amount - 1
					);
					$this->db->where('product_id', $tmp_data->product_id);
					$this->db->where('temp_sale_id', $currrent_temp_sale_id);
                    $this->db->update('temp_sale_details', $data);
					
					$this->db->where('product_id', $tmp_data->product_id)->limit(1)
                    ->update('bulk_stock_info', array('stock_amount' => $tmp_data->stock_amount-1));

                    return $tmp_data;
				}

            }

            return false;
        }

		function search_warranty_product_and_add_to_my_list($barcode)
        {
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
			$currrent_temp_sale_id = $this->session->userdata('currrent_temp_sale_id');
			
            $this->db->select('product_info.*,warranty_product_list.sl_no, bulk_stock_info.bulk_unit_buy_price, bulk_stock_info.general_unit_sale_price, bulk_stock_info.general_unit_sale_price,bulk_stock_info.bulk_unit_sale_price,bulk_stock_info.stock_amount')
            ->from('product_info, bulk_stock_info, warranty_product_list')
            ->where('product_info.product_id = warranty_product_list.product_id')
            ->where('product_info.product_id = bulk_stock_info.product_id')
            ->where('bulk_stock_info.stock_amount >', 0)
            ->where('warranty_product_list.status=1')
            ->where('warranty_product_list.sl_no', $barcode)->limit(1);
            $query = $this->db->get();

            if($query->num_rows() > 0)
            {
                $tmp_data = $query->row();

                $this->db->select('temp_sale_details.*')
                ->from('temp_sale_details')
                ->where('product_id', $tmp_data->product_id)
                ->where('temp_sale_id', $currrent_temp_sale_id)
                ->limit(1);
                $is_exists = $this->db->get();

                if($is_exists->num_rows() == 0)
                {
                    $temp_sale_details  = array(
                        'temp_sale_id'              => $currrent_temp_sale_id,
                        'product_id'                => $tmp_data->product_id,
                        'stock_id'                  => 0,
                        'sale_quantity'             => 1,
                        'product_specification'     => $tmp_data->product_specification,
                        'sale_type'                 => 1,
                        'discount_info_id'          => 0,
                        'discount'                  => 0,
                        'discount_type'             => 0,
                        'unit_buy_price'            => $tmp_data->bulk_unit_buy_price,
                        'unit_sale_price'           => $tmp_data->bulk_unit_sale_price,
                        'general_unit_sale_price'   => $tmp_data->general_unit_sale_price,
                        'actual_sale_price'         => $tmp_data->general_unit_sale_price,
                        'temp_sale_details_status'  => 1,
                        'item_name'                 => $tmp_data->product_name,
                        'stock'                     => $tmp_data->stock_amount - 1
                    );
                    $this->db->insert('temp_sale_details', $temp_sale_details);

                    $this->db->where('product_id', $tmp_data->product_id)->limit(1)
                    ->update('bulk_stock_info', array('stock_amount' => $tmp_data->stock_amount-1));
					
					
					$data_product= array(
						'invoice_id' => $currrent_temp_sale_id,
						'status' => 2,
						'dom' => $bd_date
					);
					$this->db->where('sl_no', $barcode);
					$this->db->update('warranty_product_list', $data_product);
					
					
                    return $tmp_data;
                }
				else if($is_exists->num_rows() != 0)
				{
					$field = $is_exists->row();
					$sale_quantity = $field->sale_quantity;
					
					$data = array(
					'sale_quantity' =>$sale_quantity + 1,
					'stock' =>$tmp_data->stock_amount - 1
					);
					$this->db->where('product_id', $tmp_data->product_id);
					$this->db->where('temp_sale_id', $currrent_temp_sale_id);
                    $this->db->update('temp_sale_details', $data);
					
					$this->db->where('product_id', $tmp_data->product_id)->limit(1)
                    ->update('bulk_stock_info', array('stock_amount' => $tmp_data->stock_amount-1));
					
					$data_product= array(
						'invoice_id' => $currrent_temp_sale_id,
						'status' => 2,
						'dom' => $bd_date
					);
					$this->db->where('sl_no', $barcode);
					$this->db->update('warranty_product_list', $data_product);
					
                    return $tmp_data;
				}

            }

            return false;
        }

        function get_product_by_barcode_for_sale_return($barcode)
        {
            $barcode;
            $this->db->select('product_info.*, bulk_stock_info.*')
            ->from('product_info, bulk_stock_info')
            ->where('product_info.product_id = bulk_stock_info.product_id')
            ->where('bulk_stock_info.stock_amount >', 0)
            ->where('barcode', $barcode)->limit(1);
            $query = $this->db->get();


            if($query->num_rows() > 0)
            {
                return $query->row();
            }

            return false;
        }

        function getProductList(){
            $query = $this->db
                    ->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, product_specification')
                    ->from('product_info')
                    ->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left')
                    ->group_by('product_info.product_id')
                    ->get();

            if($query->num_rows() > 0){ return $query; }

            else return FALSE;
        }
        
        function add_new_arun_sale($current_user, $current_shop)
        {
                    $flg = $this->db
                            ->where('temp_sale_creator', $current_user)
                            ->where('temp_sale_shop_id', $current_shop)
                            ->get('temp_sale_info');
                    if($flg->num_rows() == 0){
                        $data = array(
                            'temp_sale_shop_id' => $current_shop,
            				'temp_sale_creator' => $current_user,
            				'temp_sale_status'  => 1,
        			     );
                        $this ->db->insert('temp_sale_info', $data);
                        return $this->db->insert_id();
                    }   
                    else {
                        return FALSE;
                    }  
        }
                
        function get_temp_sale_id()
        {
            $data   = $this->db
                    ->select('temp_sale_id')
                    ->limit(1)
                    ->get('temp_sale_info')
                    ->row();
            return $data->temp_sale_id;
        }
                
        function check_stock($product_id)
        {
            $is_available = $this->db
                            ->where('product_id', $product_id)
                            ->where('stock_amount >', 0)
                            ->get('bulk_stock_info');   
            if($is_available->num_rows() > 0) return true;
            else return false;
        }
                
        function updateStock($pro_id, $updated_stock){
            $this->db->where('product_id', $pro_id);
            $this->db->update('bulk_stock_info', array('stock_amount' => $updated_stock));
        }

        function change_sale_quantity1()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			$service_provider_name = $this -> input ->post('service_provider_name');
			$temp_name = rtrim($service_provider_name, ";");
			$new_service_provider_insert_data = array(
				'service_provider_name' => $temp_name,
				'service_provider_address' => $this -> input -> post('service_provider_address'),
				'service_provider_contact' => $this -> input -> post('service_provider_contact'),
				'service_provider_email' => $this -> input -> post('service_provider_email'),
				'service_provider_type' => $this -> input -> post('service_provider_type'),
				'service_provider_description' => $this -> input -> post('service_provider_description'),
				'service_provider_doc' => $bd_date,
				'service_provider_dom' => $bd_date,
				'service_provider_creator' => $creator
			);
			$insert = $this -> db -> insert('service_provider_info', $new_service_provider_insert_data);
			return $insert;
		}

		function change_sale_quantity2(){
			$temp_sale_details_id = $this->input->post('temp_details_id');
			$new_sale_quantity = $this->input->post('sale_quantity');
			$sale_price = $this->input->post('sale_price');
			$buy_price = $this->input->post('buy_price');
			$currrent_temp_sale_id = $this -> tank_auth -> get_current_temp_sale();
			$this->db->where('temp_sale_details_id',$temp_sale_details_id);
			$prevListInfo = $this->db->get('temp_sale_details');
			if($prevListInfo -> num_rows() > 0){
				 foreach($prevListInfo -> result() as $field):
					$prevServingQuantity = $field-> sale_quantity;
					$saleType = $field-> sale_type;
					$productId = $field-> product_id;
				endforeach;
				$this -> db -> query("UPDATE bulk_stock_info
									  SET stock_amount = stock_amount + ".$prevServingQuantity."
									  WHERE product_id = ".$productId."
									  AND shop_id = ".$this -> shop_id." 
									");
				$this -> db -> query("UPDATE bulk_stock_info
									  SET stock_amount = stock_amount - ".$new_sale_quantity."
									  WHERE product_id = ".$productId."
									  AND shop_id = ".$this -> shop_id." 
									");
									 
				$this -> db -> query("UPDATE temp_sale_details 
									  SET stock = stock + ".$prevServingQuantity."
									  WHERE product_id = ".$productId." 
									  AND temp_sale_details_id = ".$temp_sale_details_id." 
									 ");
				$this -> db -> query("UPDATE temp_sale_details 
									  SET sale_quantity = ".$new_sale_quantity.",general_unit_sale_price = ".$sale_price.",stock = stock - ".$new_sale_quantity."
									  WHERE product_id = ".$productId." 
									  AND temp_sale_details_id = ".$temp_sale_details_id." 
									 ");
			}
			return true;
		}

        function add_arun_sale_details($product_id, $product_name, $sale_price, $buy_price, $product_specification, $sale_quantity,$product_stock, $currrent_temp_sale_id){
            $data = array(
                'temp_sale_id'              => $currrent_temp_sale_id,
                'product_id'                => $product_id,
                'stock_id'                  => 0,
                'sale_quantity'             => $sale_quantity,
                'product_specification'     => $product_specification,
                'sale_type'                 => 1,
                'discount_info_id'          => 0,
                'discount'                  => 0,
                'discount_type'             => $product_name,
                'unit_buy_price'            => $buy_price,
                'unit_sale_price'           => $sale_price,
                'general_unit_sale_price'   => 0,
                'actual_sale_price'         => $sale_price,
                'temp_sale_details_status'  => 1,
                'item_name'                 => $product_name,
                'stock'                     => $product_stock
            );
            $this->db->insert('temp_sale_details', $data);
        }

        function addProductToSale($product_id, $product_name, $sale_price, $mrp_price, $buy_price, $product_specification, $sale_quantity,$product_stock, $currrent_temp_sale_id)
		{
			$this->db->select('temp_sale_details.*')
                ->from('temp_sale_details')
                ->where('product_id', $product_id)
                ->where('temp_sale_id', $currrent_temp_sale_id)
                ->limit(1);
                $is_exists = $this->db->get();
                if($is_exists->num_rows() == 0)
                {
					$data = array(
						'temp_sale_id'              => $currrent_temp_sale_id,
						'product_id'                => $product_id,
						'stock_id'                  => 0,
						'sale_quantity'             => $sale_quantity,
						'product_specification'     => $product_specification,
						'sale_type'                 => 1,
						'discount_info_id'          => 0,
						'discount'                  => 0,
						'discount_type'             => $product_name,
						'unit_buy_price'            => $buy_price,
						'unit_sale_price'           => $sale_price,
						'general_unit_sale_price'   => $mrp_price,
						'actual_sale_price'         => $sale_price,
						'temp_sale_details_status'  => 1,
						'item_name'                 => $product_name,
						'stock'                     => $product_stock
					);
					$this->db->insert('temp_sale_details', $data);
					 $this->db->where('product_id', $product_id)->limit(1)
                    ->update('bulk_stock_info', array('stock_amount' => $product_stock));

                    return true;
				}
				else if($is_exists->num_rows() != 0)
				{
					$field = $is_exists->row();
					$sale_quantity_old = $field->sale_quantity;
					$sale_stock_old = $field->stock;
					
					$data = array(
					'sale_quantity' =>$sale_quantity_old + $sale_quantity,
					'stock' =>$sale_stock_old - $sale_quantity
					);
					$this->db->where('product_id', $product_id);
					$this->db->where('temp_sale_id', $currrent_temp_sale_id);
                    $this->db->update('temp_sale_details', $data);
					
					$this->db->where('product_id', $product_id)->limit(1)
                    ->update('bulk_stock_info', array('stock_amount' => $product_stock));

                    return true;
				}
        }

        function getAllCustomerInfo(){
            $data = $this->db
                    ->select('customer_name, customer_id, customer_contact_no')
                    ->order_by('customer_name', 'ASC')
                    ->get('customer_info');
            if($data->num_rows() > 0)return $data;
            else return FALSE;
        }

		function get_current_sale_customer($current_sale){
            $this->db->select('customer_info.customer_id,customer_info.customer_name,customer_info.customer_contact_no');
            $this->db->from('customer_info,temp_sale_info');
            $this->db->where('customer_info.customer_id=temp_sale_info.temp_customer_id');
            $this->db->where('temp_sale_info.temp_sale_id',$current_sale);
            $data =$this->db->get();            
            return $data;
        }

		function getAllCardInfo(){
            $data = $this->db
                    ->select('card_name, card_id, bank_id')
                    ->where('status="active"')
                    ->order_by('card_id', 'ASC')
                    ->get('bank_card_info');
            if($data->num_rows() > 0)return $data;
            else return FALSE;
        }

        function getAllProductInfo()
		{
            $data = $this->db
                    ->select('*')
                    ->order_by('product_name', 'ASC')
                    ->get('product_info');
            if($data->num_rows() > 0)return $data;
            else return FALSE;
        }  

        function getAllTmpProduct($currrent_temp_sale_id){
            $data = $this->db->select('temp_sale_details.*,product_info.product_size,product_info.product_model')
                            ->from('temp_sale_details,product_info')
                            ->where('temp_sale_details.product_id = product_info.product_id')
                            ->where('temp_sale_id', $currrent_temp_sale_id)
                            ->get();
            if($data->num_rows() > 0)return $data;
            else return FALSE;
        }

		function getAllTmpProduct_warranty($currrent_temp_sale_id){
            $data = $this->db->select('*')
                            ->from('warranty_product_list')
                            ->where('invoice_id', $currrent_temp_sale_id)
                            ->get();
            if($data->num_rows() > 0)return $data;
            else return FALSE;
        }

        function getReturnId($tmp_sale_id)
        {
            $data = $this->db->select('return_id')->where('temp_sale_id', $tmp_sale_id)->get('temp_sale_info');
            if($data->num_rows() > 0)
			{
                $row_data = $data->row();
                return $row_data->return_id;
            }
            else return 0;
        }  

		function getReturnAdjustAmount($tmp_sale_id)
        {
            $data = $this->db->select('return_adjust_amount')->where('temp_sale_id', $tmp_sale_id)->get('temp_sale_info');
            if($data->num_rows() > 0)
			{
                $row_data = $data->row();
                return $row_data->return_adjust_amount;
            }
            else return 0;
        }  
        //************************************* Quick Sale Start **********************************************\\	
        function doInvoiceInfoTask($customer_id,$sub_total,$cash_commision,$disc_amt,$disc_type,$grand_total,$total_paid,$return_money, $return_adjust,$payable,$delivery_charge)
        {
			if($return_adjust!='')
			{
				if($total_paid=='')
				{
					$total_paid = $payable+$delivery_charge;
				}
				else
				{
					$total_paid = $total_paid;
				}
				if($payable=='' && $total_paid=='')
				{
					$total_paid = 0;
				}
				else
				{
					$total_paid = $total_paid;
				}
				
				$data = array(
					'invoice_id'        => '',
					'shop_id'           => $this->tank_auth->get_shop_id(),
					'customer_id'       => $customer_id,
					'total_price'       => $sub_total,
					'discount'          => 0,
					'discount_type'     => $disc_type,
					'cash_commision'    => $cash_commision,
					'discount_amount'   => $disc_amt,
					'delivery_charge'   => $delivery_charge,
					'grand_total'       => $payable,
					'total_paid'        => $total_paid,
					'return_money'      => $return_money,  
					'sale_return_amount'=> $return_adjust,  
					'payment_mode'      => 'cash',
					'invoice_creator'   => $this->tank_auth->get_user_id(),
					'invoice_doc'       => date('Y-m-d'),
					'invoice_dom'       => date('Y-m-d'),
				);
							
				if($this->db->insert('invoice_info', $data))
						return $this->db->insert_id();
							
				else return FALSE;
			}
			else
			{
				if($total_paid=='')
				{
					$total_paid = $grand_total+$delivery_charge;
				}
				$data = array(
					'invoice_id'        => '',
					'shop_id'           => $this->tank_auth->get_shop_id(),
					'customer_id'       => $customer_id,
					'total_price'       => $sub_total,
					'discount'          => 0,
					'discount_type'     => $disc_type,
					'cash_commision'    => $cash_commision,
					'discount_amount'   => $disc_amt,
					'delivery_charge'   => $delivery_charge,
					'grand_total'       => $grand_total,
					'total_paid'        => $total_paid,
					'return_money'      => $return_money,  
					'payment_mode'      => 'cash',
					'invoice_creator'   => $this->tank_auth->get_user_id(),
					'invoice_doc'       => date('Y-m-d'),
					'invoice_dom'       => date('Y-m-d'),
				);
							
				if($this->db->insert('invoice_info', $data))
						return $this->db->insert_id();
							
				else return FALSE;
                        
			}
        } 
		
		function doInvoiceInfoTask_credit($customer_id,$sub_total,$cash_commision,$disc_amt,$disc_type,$grand_total,$total_paid,$return_money, $return_adjust,$payable,$delivery_charge)
        {
			if($return_adjust!='')
			{
				$data = array(
					'invoice_id'        => '',
					'shop_id'           => $this->tank_auth->get_shop_id(),
					'customer_id'       => $customer_id,
					'total_price'       => $sub_total,
					'discount'          => 0,
					'discount_type'     => $disc_type,
					'cash_commision'    => $cash_commision,
					'discount_amount'   => $disc_amt,
					'delivery_charge'   => $delivery_charge,
					'grand_total'       => $payable,
					'total_paid'        => $total_paid,
					'return_money'      => $return_money,  
					'sale_return_amount'=> $return_adjust,  
					'payment_mode'      => 'cash',
					'invoice_creator'   => $this->tank_auth->get_user_id(),
					'invoice_doc'       => date('Y-m-d'),
					'invoice_dom'       => date('Y-m-d'),
				);
							
				if($this->db->insert('invoice_info', $data))
						return $this->db->insert_id();
							
				else return FALSE;
			}
			else
			{
				$data = array(
					'invoice_id'        => '',
					'shop_id'           => $this->tank_auth->get_shop_id(),
					'customer_id'       => $customer_id,
					'total_price'       => $sub_total,
					'discount'          => 0,
					'discount_type'     => $disc_type,
					'cash_commision'    => $cash_commision,
					'discount_amount'   => $disc_amt,
					'delivery_charge'   => $delivery_charge,
					'grand_total'       => $grand_total,
					'total_paid'        => $total_paid,
					'return_money'      => $return_money,  
					'payment_mode'      => 'cash',
					'invoice_creator'   => $this->tank_auth->get_user_id(),
					'invoice_doc'       => date('Y-m-d'),
					'invoice_dom'       => date('Y-m-d'),
				);
							
				if($this->db->insert('invoice_info', $data))
						return $this->db->insert_id();
							
				else return FALSE;
                        
			}
        }

		function doSaleDetailsTask($invoice_id,$products,$cash_commision,$disc_amount, $discount_type)
		{
            $this->db->where('invoice_id',$invoice_id);
			$que = $this->db->get('invoice_info');
			$inv = $que->row();
            foreach($products->result() as $tmp)
            {
				if($cash_commision !='0')
				{
					$ratio = $disc_amount/$inv->total_price;
					$exact_sale_price = $tmp -> general_unit_sale_price - ( $tmp -> general_unit_sale_price * $ratio);
				}
				else
				{
					$exact_sale_price = $tmp -> general_unit_sale_price;
					
				}
                $data = array(
                    'sale_details_id'           => '',
                    'invoice_id'                => $invoice_id,
                    'product_id'                => $tmp->product_id,
                    'stock_id'                  => 0,
                    'sale_quantity'             => $tmp->sale_quantity,
                    'sale_type'                 => 1,
                    'discount_info_id'          => 0,
                    'discount'                  => $disc_amount,
                    'discount_type'             => $discount_type,
                    'unit_sale_price'           => $tmp->unit_sale_price,
                    'general_sale_price'        => $tmp->general_unit_sale_price,
                    'unit_buy_price'            => $tmp->unit_buy_price,
                    'actual_sale_price'         => $tmp->general_unit_sale_price,
                    'product_specification'     => $tmp->product_specification,
                    'exact_sale_price'          => $exact_sale_price,
                    'sale_details_status'       => 1,

                );
                $this->db->insert('sale_details', $data);
            }
        }

		function doWarrantyUpdateTask($invoice_id, $products,$products_warranty, $cash_commision,$disc_amount, $discount_type)
		{
            $this->db->where('invoice_id',$invoice_id);
			$que = $this->db->get('invoice_info');
			$inv = $que->row();
			$tmp = $products->row();
			if($cash_commision !='0')
			{
				$ratio = $disc_amount/$inv->total_price;
				$exact_sale_price = $tmp -> unit_sale_price - ( $tmp -> unit_sale_price * $ratio);
			}
			else
			{
				$exact_sale_price = $tmp -> unit_sale_price;
			}
			foreach($products_warranty->result() as $tmp2)
			{
				$data_product= array(
					'invoice_id' => $invoice_id,
					'status' => 3,
					'sale_price' => $exact_sale_price,
					'sale_date' => date('Y-m-d'),
					'dom' => date('Y-m-d')
				);
				//$this->db->where('product_id', $tmp2->product_id);
				$this->db->where('invoice_id', $tmp2->invoice_id);
				$this->db->update('warranty_product_list', $data_product);
				
				$data_product2= array(
					'ip_id' => $tmp2->ip_id,
					'product_id' => $tmp2->product_id,
					'invoice_id' => $invoice_id,
					'sl_no' => $tmp2->sl_no,
					'sale_price' => $exact_sale_price,
					'warranty_period' => $tmp2->warranty_period,
					'sale_date' => date('Y-m-d'),
					'doc' => date('Y-m-d'),
					'dom' => date('Y-m-d')
				);
				
				$this->db->insert('warranty_product_sale_details', $data_product2);
			}
			return true;
        }

		function transactioninfo_cashbook($invoice_id,$customer_id, $grand_total, $total_paid,$return_adjust,$payable,$return_id,$delivery_charge)
        {
            $sale_info = array
			(
               'transaction_id'         			=> '',
               'transaction_purpose'                => 'sale',
               'transaction_mode'                 	=> '',
               'ledger_id'         					=> $customer_id,
               'common_id'         					=> $invoice_id,
               'amount'     						=> $grand_total,
               'date'                   			=> date('Y-m-d'),
               'status'        						=> 'active',
               'creator'        					=> $this->currentUser,
               'doc'   								=> date('Y-m-d'),
               'dom'    							=> date('Y-m-d')
            );
            $this->db->insert('transaction_info', $sale_info);
            $insert_id = $this->db->insert_id();
			if($delivery_charge!=0)
			{
				$delivery_info = array
				(
				   'transaction_id'         			=> '',
				   'transaction_purpose'                => 'delivery_charge',
				   'transaction_mode'                 	=> 'cash',
				   'ledger_id'         					=> $customer_id,
				   'common_id'         					=> $invoice_id,
				   'amount'     						=> $delivery_charge,
				   'date'                   			=> date('Y-m-d'),
				   'status'        						=> 'active',
				   'creator'        					=> $this->currentUser,
				   'doc'   								=> date('Y-m-d'),
				   'dom'    							=> date('Y-m-d')
				);
				$this->db->insert('transaction_info', $delivery_info);
			}
            /*for sale return on sale*/
			if($return_adjust!='')
			{
				$collection_info = array
				(
				   'transaction_id'         			=> '',
				   'transaction_purpose'                => 'sale_return',
				   'transaction_mode'                 	=> '',
				   'ledger_id'         					=> $customer_id,
				   'common_id'         					=> $invoice_id,
				   'sub_id'         					=> $return_id,
				   'amount'     						=> $return_adjust,
				   'date'                   			=> date('Y-m-d'),
				   'status'        						=> 'active',
				   'creator'        					=> $this->currentUser,
				   'doc'   								=> date('Y-m-d'),
				   'dom'    							=> date('Y-m-d')
				);
				$this->db->insert('transaction_info', $collection_info);
				$insert_id1 = $this->db->insert_id();
				/* $cash_book = array(
				   'cb_id'         						=> '',
				   'transaction_id'                     => $insert_id1,
				   'transaction_type'                	=> 'out',
				   'amount'                 			=> $return_adjust,
				   'date'         						=> date('Y-m-d'),
				   'status'    	 						=> 'active',
				   'creator'                   			=> $this->currentUser,
				   'doc'        						=> date('Y-m-d'),
				   'dom'       							=> date('Y-m-d')
				);
				$this->db->insert('cash_book', $cash_book); */
				if($total_paid >= $payable)
				{
					$collection_info2 = array
					(
					   'transaction_id'         			=> '',
					   'transaction_purpose'                => 'collection',
					   'transaction_mode'                 	=> 'cash',
					   'ledger_id'         					=> $customer_id,
					   'common_id'         					=> $invoice_id,
					   'amount'     						=> $payable+$delivery_charge,
					   'date'                   			=> date('Y-m-d'),
					   'status'        						=> 'active',
					   'creator'        					=> $this->currentUser,
					   'doc'   								=> date('Y-m-d'),
					   'dom'    							=> date('Y-m-d')
					);
					$this->db->insert('transaction_info', $collection_info2);
					$insert_id = $this->db->insert_id();
					$cash_book2 = array(
					   'cb_id'         						=> '',
					   'transaction_id'                     => $insert_id,
					   'transaction_type'                	=> 'in',
					   'amount'                 			=> $payable+$delivery_charge,
					   'date'         						=> date('Y-m-d'),
					   'status'    	 						=> 'active',
					   'creator'                   			=> $this->currentUser,
					   'doc'        						=> date('Y-m-d'),
					   'dom'       							=> date('Y-m-d')
					);
					$this->db->insert('cash_book', $cash_book2);
				}
				else if($total_paid=='')
				{
					$collection_info2 = array
					(
					   'transaction_id'         			=> '',
					   'transaction_purpose'                => 'collection',
					   'transaction_mode'                 	=> 'cash',
					   'ledger_id'         					=> $customer_id,
					   'common_id'         					=> $invoice_id,
					   'amount'     						=> $payable+$delivery_charge,
					   'date'                   			=> date('Y-m-d'),
					   'status'        						=> 'active',
					   'creator'        					=> $this->currentUser,
					   'doc'   								=> date('Y-m-d'),
					   'dom'    							=> date('Y-m-d')
					);
					$this->db->insert('transaction_info', $collection_info2);
					$insert_id = $this->db->insert_id();
					$cash_book2 = array(
					   'cb_id'         						=> '',
					   'transaction_id'                     => $insert_id,
					   'transaction_type'                	=> 'in',
					   'amount'                 			=> $payable+$delivery_charge,
					   'date'         						=> date('Y-m-d'),
					   'status'    	 						=> 'active',
					   'creator'                   			=> $this->currentUser,
					   'doc'        						=> date('Y-m-d'),
					   'dom'       							=> date('Y-m-d')
					);
					$this->db->insert('cash_book', $cash_book2);
				}
				else
				{
					$collection_info3 = array
					(
					   'transaction_id'         			=> '',
					   'transaction_purpose'                => 'collection',
					   'transaction_mode'                 	=> 'cash',
					   'ledger_id'         					=> $customer_id,
					   'common_id'         					=> $invoice_id,
					   'amount'     						=> $total_paid,
					   'date'                   			=> date('Y-m-d'),
					   'status'        						=> 'active',
					   'creator'        					=> $this->currentUser,
					   'doc'   								=> date('Y-m-d'),
					   'dom'    							=> date('Y-m-d')
					);
					$this->db->insert('transaction_info', $collection_info3);
					$insert_id = $this->db->insert_id();
					$cash_book3 = array(
					   'cb_id'         						=> '',
					   'transaction_id'                     => $insert_id,
					   'transaction_type'                	=> 'in',
					   'amount'                 			=> $total_paid,
					   'date'         						=> date('Y-m-d'),
					   'status'    	 						=> 'active',
					   'creator'                   			=> $this->currentUser,
					   'doc'        						=> date('Y-m-d'),
					   'dom'       							=> date('Y-m-d')
					);
					$this->db->insert('cash_book', $cash_book3);
				}
			}
			  /*for collection on sale*/
			else
			{
				if($total_paid >= $grand_total+$delivery_charge)
				{
					$collection_info = array
					(
					   'transaction_id'         			=> '',
					   'transaction_purpose'                => 'collection',
					   'transaction_mode'                 	=> 'cash',
					   'ledger_id'         					=> $customer_id,
					   'common_id'         					=> $invoice_id,
					   'amount'     						=> $grand_total+$delivery_charge,
					   'date'                   			=> date('Y-m-d'),
					   'status'        						=> 'active',
					   'creator'        					=> $this->currentUser,
					   'doc'   								=> date('Y-m-d'),
					   'dom'    							=> date('Y-m-d')
					);
					$this->db->insert('transaction_info', $collection_info);
					$insert_id = $this->db->insert_id();
					$cash_book = array(
					   'cb_id'         						=> '',
					   'transaction_id'                     => $insert_id,
					   'transaction_type'                	=> 'in',
					   'amount'                 			=> $grand_total+$delivery_charge,
					   'date'         						=> date('Y-m-d'),
					   'status'    	 						=> 'active',
					   'creator'                   			=> $this->currentUser,
					   'doc'        						=> date('Y-m-d'),
					   'dom'       							=> date('Y-m-d')
					);
					$this->db->insert('cash_book', $cash_book);
				}
				else
				{
					if($total_paid=='')
					{
						$total_paid = $grand_total+$delivery_charge;
					}
					else
					{
						$total_paid = $total_paid;
					}
					$collection_info = array
					(
					   'transaction_id'         			=> '',
					   'transaction_purpose'                => 'collection',
					   'transaction_mode'                 	=> 'cash',
					   'ledger_id'         					=> $customer_id,
					   'common_id'         					=> $invoice_id,
					   'amount'     						=> $total_paid,
					   'date'                   			=> date('Y-m-d'),
					   'status'        						=> 'active',
					   'creator'        					=> $this->currentUser,
					   'doc'   								=> date('Y-m-d'),
					   'dom'    							=> date('Y-m-d')
					);
					$this->db->insert('transaction_info', $collection_info);
					$insert_id = $this->db->insert_id();
					$cash_book = array(
					   'cb_id'         						=> '',
					   'transaction_id'                     => $insert_id,
					   'transaction_type'                	=> 'in',
					   'amount'                 			=> $total_paid,
					   'date'         						=> date('Y-m-d'),
					   'status'    	 						=> 'active',
					   'creator'                   			=> $this->currentUser,
					   'doc'        						=> date('Y-m-d'),
					   'dom'       							=> date('Y-m-d')
					);
					$this->db->insert('cash_book', $cash_book);
				}
			}
            return $insert_id;
        }		
		
        //************************************* Quick Sale End **********************************************\\	
        //************************************* Credit Sale Start **********************************************\\	
		function transactioninfo_creditsale($invoice_id,$customer_id, $grand_total,$return_adjust,$return_id,$delivery_charge)
        {
            $sale_info = array
			(
               'transaction_id'         			=> '',
               'transaction_purpose'                => 'sale',
               'transaction_mode'                 	=> '',
               'ledger_id'         					=> $customer_id,
               'common_id'         					=> $invoice_id,
               'amount'     						=> $grand_total,
               'date'                   			=> date('Y-m-d'),
               'status'        						=> 'active',
               'creator'        					=> $this->currentUser,
               'doc'   								=> date('Y-m-d'),
               'dom'    							=> date('Y-m-d')
            );
            
            $this->db->insert('transaction_info', $sale_info);
            $insert_id = $this->db->insert_id();

			if($delivery_charge!=0)
			{
				$delivery_info = array
				(
				   'transaction_id'         			=> '',
				   'transaction_purpose'                => 'delivery_charge',
				   'transaction_mode'                 	=> '',
				   'ledger_id'         					=> $customer_id,
				   'common_id'         					=> $invoice_id,
				   'amount'     						=> $delivery_charge,
				   'date'                   			=> date('Y-m-d'),
				   'status'        						=> 'active',
				   'creator'        					=> $this->currentUser,
				   'doc'   								=> date('Y-m-d'),
				   'dom'    							=> date('Y-m-d')
				);
				$this->db->insert('transaction_info', $delivery_info);
			}
		   if($return_adjust!='')
		   {
			
			$sale_return_info = array
				(
				   'transaction_id'         			=> '',
				   'transaction_purpose'                => 'sale_return',
				   'transaction_mode'                 	=> '',
				   'ledger_id'         					=> $customer_id,
				   'common_id'         					=> $invoice_id,
				   'sub_id'         					=> $return_id,
				   'amount'     						=> $return_adjust,
				   'date'                   			=> date('Y-m-d'),
				   'status'        						=> 'active',
				   'creator'        					=> $this->currentUser,
				   'doc'   								=> date('Y-m-d'),
				   'dom'    							=> date('Y-m-d')
				);
				$this->db->insert('transaction_info', $sale_return_info);
				$insert_id1 = $this->db->insert_id();
				$cash_book = array(
				   'cb_id'         						=> '',
				   'transaction_id'                     => $insert_id1,
				   'transaction_type'                	=> 'out',
				   'amount'                 			=> $return_adjust,
				   'date'         						=> date('Y-m-d'),
				   'status'    	 						=> 'active',
				   'creator'                   			=> $this->currentUser,
				   'doc'        						=> date('Y-m-d'),
				   'dom'       							=> date('Y-m-d')
				);
				$this->db->insert('cash_book', $cash_book);
				
				
			}	
			 return $insert_id;
        }	
        //************************************* Credit Sale End **********************************************\\	
        //************************************* Card Sale Start **********************************************\\	
		function doInvoiceInfoTask_card($customer_id,$sub_total,$cash_commision,$disc_amt,$disc_type,$grand_total,$total_paid,$return_money, $return_adjust,$payable)
        {
			if($return_adjust!='')
			{
				if($total_paid=='')
				{
					$total_paid = $payable;
				}
				else
				{
					$total_paid = $total_paid;
				}
				if($payable=='' && $total_paid=='')
				{
					$total_paid = 0;
				}
				else
				{
					$total_paid = $total_paid;
				}
				$data = array(
					'invoice_id'        => '',
					'shop_id'           => $this->tank_auth->get_shop_id(),
					'customer_id'       => $customer_id,
					'total_price'       => $sub_total,
					'discount'          => 0,
					'discount_type'     => $disc_type,
					'cash_commision'    => $cash_commision,
					'discount_amount'   => $disc_amt,
					'grand_total'       => $payable,
					'total_paid'        => $total_paid,
					'return_money'      => $return_money,  
					'sale_return_amount'=> $return_adjust,  
					'payment_mode'      => 'card',
					'invoice_creator'   => $this->tank_auth->get_user_id(),
					'invoice_doc'       => date('Y-m-d'),
					'invoice_dom'       => date('Y-m-d'),
				);
							
				if($this->db->insert('invoice_info', $data))
						return $this->db->insert_id();
							
				else return FALSE;
			}
			else
			{
				if($total_paid=='')
				{
					$total_paid = $grand_total;
				}
				$data = array(
					'invoice_id'        => '',
					'shop_id'           => $this->tank_auth->get_shop_id(),
					'customer_id'       => $customer_id,
					'total_price'       => $sub_total,
					'discount'          => 0,
					'discount_type'     => $disc_type,
					'cash_commision'    => $cash_commision,
					'discount_amount'   => $disc_amt,
					'grand_total'       => $grand_total,
					'total_paid'        => $total_paid,
					'return_money'      => $return_money,  
					'payment_mode'      => 'card',
					'invoice_creator'   => $this->tank_auth->get_user_id(),
					'invoice_doc'       => date('Y-m-d'),
					'invoice_dom'       => date('Y-m-d'),
				);
							
				if($this->db->insert('invoice_info', $data))
						return $this->db->insert_id();
				else return FALSE;
			}
        }

		function transactioninfo_cardsale($invoice_id,$customer_id, $grand_total,$total_paid, $bank_id,$card_id,$return_adjust,$payable,$return_id,$delivery_charge)
        {
			/*for sale*/
            $sale_info = array
			(
               'transaction_id'         			=> '',
               'transaction_purpose'                => 'sale',
               'transaction_mode'                 	=> '',
               'ledger_id'         					=> $customer_id,
			   'common_id'         					=> $invoice_id,
               'amount'     						=> $grand_total,
               'date'                   			=> date('Y-m-d'),
               'status'        						=> 'active',
               'creator'        					=> $this->currentUser,
               'doc'   								=> date('Y-m-d'),
               'dom'    							=> date('Y-m-d')
            );
            $this->db->insert('transaction_info', $sale_info);
			if($delivery_charge!=0){
				$delivery_info = array
				(
				   'transaction_id'         			=> '',
				   'transaction_purpose'                => 'delivery_charge',
				   'transaction_mode'                 	=> 'cash',
				   'ledger_id'         					=> $customer_id,
				   'common_id'         					=> $invoice_id,
				   'amount'     						=> $delivery_charge,
				   'date'                   			=> date('Y-m-d'),
				   'status'        						=> 'active',
				   'creator'        					=> $this->currentUser,
				   'doc'   								=> date('Y-m-d'),
				   'dom'    							=> date('Y-m-d')
				);
				$this->db->insert('transaction_info', $delivery_info);
			}
			if($return_adjust!=''){
				$sale_return = array
				(
				   'transaction_id'         			=> '',
				   'transaction_purpose'                => 'sale_return',
				   'transaction_mode'                 	=> '',
				   'ledger_id'         					=> $customer_id,
				   'common_id'         					=> $invoice_id,
				   'sub_id'         					=> $return_id,
				   'amount'     						=> $return_adjust,
				   'date'                   			=> date('Y-m-d'),
				   'status'        						=> 'active',
				   'creator'        					=> $this->currentUser,
				   'doc'   								=> date('Y-m-d'),
				   'dom'    							=> date('Y-m-d')
				);
				$this->db->insert('transaction_info', $sale_return);
				$insert_id1 = $this->db->insert_id();
				$collection_info3 = array
				(
				   'transaction_id'         			=> '',
				   'transaction_purpose'                => 'collection',
				   'transaction_mode'                 	=> 'card',
				   'ledger_id'         					=> $customer_id,
				   'common_id'         					=> $invoice_id,
				   'amount'     						=> $total_paid+$delivery_charge,
				   'date'                   			=> date('Y-m-d'),
				   'status'        						=> 'active',
				   'creator'        					=> $this->currentUser,
				   'doc'   								=> date('Y-m-d'),
				   'dom'    							=> date('Y-m-d')
				);
				$this->db->insert('transaction_info', $collection_info3);
				$insert_id3 = $this->db->insert_id();
				$bank_book3 = array(
				   'bb_id'         						=> '',
				   'transaction_id'                     => $insert_id3,
				   'bank_id'                     		=> $bank_id,
				   'card_id'                     		=> $card_id,
				   'transaction_type'                	=> 'in',
				   'amount'                 			=> $total_paid+$delivery_charge,
				   'date'         						=> date('Y-m-d'),
				   'status'    	 						=> 'active',
				   'creator'                   			=> $this->currentUser,
				   'doc'        						=> date('Y-m-d'),
				   'dom'       							=> date('Y-m-d')
				);
				$this->db->insert('bank_book', $bank_book3);
			}
			else{
				/*for collection on sale*/
				$collection_info = array
				(
				   'transaction_id'         			=> '',
				   'transaction_purpose'                => 'collection',
				   'transaction_mode'                 	=> 'card',
				   'ledger_id'         					=> $customer_id,
				   'common_id'         					=> $invoice_id,
				   'amount'     						=> $grand_total+$delivery_charge,
				   'date'                   			=> date('Y-m-d'),
				   'status'        						=> 'active',
				   'creator'        					=> $this->currentUser,
				   'doc'   								=> date('Y-m-d'),
				   'dom'    							=> date('Y-m-d')
				);
				$this->db->insert('transaction_info', $collection_info);
				$insert_id = $this->db->insert_id();
				$bank_book = array(
				   'bb_id'         						=> '',
				   'transaction_id'                     => $insert_id,
				   'bank_id'                     		=> $bank_id,
				   'card_id'                     		=> $card_id,
				   'transaction_type'                	=> 'in',
				   'amount'                 			=> $grand_total+$delivery_charge,
				   'date'         						=> date('Y-m-d'),
				   'status'    	 						=> 'active',
				   'creator'                   			=> $this->currentUser,
				   'doc'        						=> date('Y-m-d'),
				   'dom'       							=> date('Y-m-d')
				);
				$this->db->insert('bank_book', $bank_book);
				return $insert_id;	
			}	
        }		
                    
        //************************************* Card Sale End **********************************************\\	 
        function deleteDataFromTmpSaleInfoAndTmpSaleDetails($currrent_temp_sale_id, $current_sale_return_id, $creator)
        {
            $this->db->where('temp_sale_id', $currrent_temp_sale_id);
            $this->db->delete('temp_sale_details');
            $this->db->where('temp_sale_id', $currrent_temp_sale_id);
            $this->db->delete('temp_sale_info');
            if($current_sale_return_id != '')
            {
                $this->db->where('tmp_sale_return_id', $current_sale_return_id)
                ->where('tmp_sale_id', $currrent_temp_sale_id)
                ->where('tmp_sale_return_creator', $creator)
                ->delete('tmp_sale_return_tbl');

                $this->db->where('tmp_sale_return_id', $current_sale_return_id)->delete('tmp_sale_return_details_tbl');
            }
        }
        
        function cancelSale($currrent_temp_sale_id, $current_sale_return_id, $creator)
        {
            $data = $this->db
                    ->where('temp_sale_id', $currrent_temp_sale_id)
                    ->get('temp_sale_details');

            if($data->num_rows() > 0 )
            {
                foreach ($data->result() as $tmp)
                {
                    $this->db->set('stock_amount', 'stock_amount+' . $tmp->sale_quantity, FALSE);
                    $this->db->where('product_id', $tmp->product_id);
                    $this->db->update('bulk_stock_info');
                }
                $this->db->where('temp_sale_id', $currrent_temp_sale_id);
                $this->db->delete('temp_sale_details');
            }

            $this->db->where('temp_sale_id', $currrent_temp_sale_id);
            $this->db->delete('temp_sale_info');
			
			$data = array
			(
			
			'invoice_id' =>0,
			'status' =>1,
			);
			$this->db->where('invoice_id', $currrent_temp_sale_id);
			$this->db->where('status', 2);
			$this->db->update('warranty_product_list',$data); 
			
            if($current_sale_return_id != '')
            {
                $this->db->where('tmp_sale_return_id', $current_sale_return_id)
                ->where('tmp_sale_id', $currrent_temp_sale_id)
                ->where('tmp_sale_return_creator', $creator)
                ->delete('tmp_sale_return_tbl');
				
				$this->db->where('tmp_sale_return_id', $current_sale_return_id)
                ->where('temp_sale_id', $currrent_temp_sale_id)
                ->delete('tmp_warranty_product_return');

                $this->db->where('tmp_sale_return_id', $current_sale_return_id)->delete('tmp_sale_return_details_tbl');
            }
        }

		function cancelcashSalereturn()
        {
			$this->db->select('tmp_cash_sale_return_id');
			$this->db->from('tmp_cash_sale_return_tbl');
			$this->db->where('status ="direct"');
			$query = $this->db->get();
			$tmp = $query->row();
			$this->db->where('tmp_cash_sale_return_id',$tmp->tmp_cash_sale_return_id);
			$this->db->delete('tmp_cash_sale_return_details_tbl');
			$this->db->where('tmp_cash_sale_return_id',$tmp->tmp_cash_sale_return_id);
			$this->db->where('status ="direct"');
			$this->db->delete('tmp_cash_sale_return_tbl');
			return true;
        }

        function insertNewCustomer($customer_name, $customer_phn, $customer_dob)
        {
            $data = array(
                'customer_name'         => $customer_name,
                'customer_id'           => '',
                'customer_define_id'    => 0,
                'customer_contact_no'   => $customer_phn,
                'customer_dob'   		=> '',
                'customer_type'         => 'Individual',
                'customer_mode'         => 'normal',
                'customer_address'      => '',
                'customer_email'        => '',
                'customer_creator'      => $this->currentUser,
                'customer_doc'          => date('Y-m-d'),
                'customer_dom'          => date('Y-m-d')
            );
            $this->db->insert('customer_info', $data);
            return $this->db->insert_id();
        }
        
        function restoreProduct($products)
        {
            foreach ($products->result() as $tmp)
            {
                $this->db->set('stock_amount', 'stock_amount+' . $tmp->sale_quantity, FALSE);
                $this->db->where('product_id', $tmp->product_id);
                $this->db->update('bulk_stock_info');
            }
        }

        function getSoldProducts($invoice_id)
        {
             $data   =  $this->db
                    ->select('product_info.product_name,product_info.product_specification,product_info.unit_name,product_info.product_size,product_info.product_model,product_info.product_warranty, sale_details.sale_quantity, sale_details.general_sale_price,sale_details.actual_sale_price,sale_details.unit_sale_price,sale_details.exact_sale_price,sale_details.unit_buy_price, invoice_info.total_price, invoice_info.delivery_charge,invoice_info.discount_amount, invoice_info.discount_type, invoice_info.total_paid, invoice_info.cash_commision, invoice_info.grand_total, invoice_info.sale_return_amount, invoice_info.return_money, invoice_info.invoice_doc, 
                        invoice_info.invoice_creator, username,invoice_info.date_time, invoice_info.customer_id, customer_name, customer_address,customer_contact_no, invoice_info.discount_type, invoice_info.discount')
                    ->from('product_info, sale_details, invoice_info,users,customer_info')
                    ->where('product_info.product_id = sale_details.product_id')
                    ->where('invoice_info.invoice_id = sale_details.invoice_id')
                    ->where('invoice_info.customer_id = customer_info.customer_id')
                    ->where('invoice_info.invoice_creator = users.id')
                    ->where('sale_details.invoice_id', $invoice_id)
                    ->where('invoice_info.invoice_id', $invoice_id)
					->order_by('sale_details.product_id','asc')
                    ->get();
            if($data->num_rows() > 0)return $data;
            else return FALSE;
        }

		function getSoldProducts_warranty($invoice_id)
        {
			$data2   =  $this->db
                    ->select('product_id')
                    ->from('sale_details')
                    ->where('sale_details.invoice_id', $invoice_id)
                    ->where('sale_details.product_specification', 2)
					//->group_by('product_id')
					->order_by('sale_details.product_id','asc')
                    ->get();
			$i = 1;
			$serial = '';
			foreach($data2->result() as $tmp)
			{
				//echo 'Hi'. $tmp->product_id;
				//echo 'Inv'.$invoice_id;

				      $data  = $this->db
						->select('sl_no,product_id,warranty_period')
						->from('warranty_product_sale_details')
						->where('warranty_product_sale_details.product_id',$tmp->product_id)
						->where('warranty_product_sale_details.invoice_id', $invoice_id)
						->order_by('product_id','asc')
						->get();
						
				      if($data->num_rows() > 0){
						$serial[$i] = $data->result();
				      }
				      $i++;
			}
			return $serial;
        }

		function receipt_sale_total_amount($customer_id,$invoice_id)
		{
			$this->db->select('transaction_info.transaction_id');
			$this->db->from('transaction_info');
			$this->db->where('transaction_info.transaction_purpose = "sale"');
			$this->db->where('transaction_info.common_id',$invoice_id);
			$query = $this->db->get();
			$row = $query->row();
			$transaction_id = $row->transaction_id;
			$this->db->select('SUM(transaction_info.amount) as total_sale_amount');
			$this->db->from('transaction_info');			
			$this->db->where('transaction_info.transaction_purpose = "sale"');
			$this->db->where('transaction_info.transaction_id < "'.$transaction_id.'"');
			$this->db->where('transaction_info.ledger_id',$customer_id);
			$query_data = $this->db->get();
			$row = $query_data->row();
			$total_sale_amount = $row->total_sale_amount;
			$this->db->select('SUM(transaction_info.amount) as total_collection_amount');
			$this->db->from('transaction_info');			
			$this->db->where('(transaction_info.transaction_purpose = "collection" OR transaction_info.transaction_purpose = "credit_collection" OR transaction_info.transaction_purpose = "sale_return")');
			$this->db->where('transaction_info.transaction_id < "'.$transaction_id.'"');
			$this->db->where('transaction_info.ledger_id',$customer_id);
			$query_data = $this->db->get();
			$row = $query_data->row();
			$total_collection_amount = $row->total_collection_amount;
			
			$this->db->select('SUM(customer_info.int_balance) as total_balance_amount');
			$this->db->from('customer_info');			
			$this->db->where('customer_info.customer_id',$customer_id);
			$query_data = $this->db->get();
			$row = $query_data->row();
			$total_balance_amount = $row->total_balance_amount;

			return $total_sale_amount + $total_balance_amount - $total_collection_amount;
		}

		function getreturnProducts($return_invoice_id)
        {
            $data   =  $this->db
                    ->select('product_info.product_name, sale_return_details_tbl.return_quantity,sale_return_details_tbl.unit_sale_price,sale_return_details_tbl.total_price, sale_return_receipt_tbl.sale_return_id,sale_return_receipt_tbl.total_return_amount,sale_return_receipt_tbl.sale_return_doc, username')
                    ->from('product_info, sale_return_details_tbl,users,sale_return_receipt_tbl')
                    ->where('sale_return_receipt_tbl.sale_return_id = sale_return_details_tbl.sale_return_id')
                    ->where('product_info.product_id = sale_return_details_tbl.product_id')
                    ->where('sale_return_receipt_tbl.creator = users.id')
                    ->where('sale_return_receipt_tbl.sale_return_id', $return_invoice_id)
                    ->get();
            if($data->num_rows() > 0)return $data;
            else return FALSE;
        }

        function createNewSale($current_user, $current_shop)
        {
            $data = array(
                    'temp_sale_id'          => '',
                    'temp_sale_shop_id'     => $current_shop,
                    'temp_sale_creator'     => $current_user,
                    'return_adjust_amount'  => 0,
                    'temp_sale_status'      => 1,
            );
            
            $sql = $this->db
                ->select('temp_sale_id')
                ->where('temp_sale_creator', $current_user)
                ->where('temp_sale_shop_id', $current_shop)
                ->get('temp_sale_info');
            
            if($sql->num_rows() < 14)
            {
                $this ->db->insert('temp_sale_info', $data);
                return $this->db->insert_id();
            }
            else return false;
        }

        function getAllSale($current_user, $current_shop)
        {
            $data = $this->db
                            ->select('temp_sale_id,temp_sale_type')
                            //->where('temp_sale_creator', $current_user)
                            ->where('temp_sale_shop_id', $current_shop)
                            ->order_by('temp_sale_id', "asc")
                            ->get('temp_sale_info');

            if($data->num_rows() > 0) return $data;

            else return FALSE;
        }

		function get_current_sale_invoice_status($current_sale)
        {
            $data = $this->db
                            ->select('*')
                            ->where('temp_sale_id', $current_sale)
                            ->where('pre_invoice_status = "pending"')
                            ->get('temp_sale_info');
            return $data;
        }
        
        function updateTmpProduct($product_id, $new_qnty, $actual_price, $stock)
        {

            $data = array(
               'sale_quantity'      => $new_qnty,
               'stock'              => $stock
            );

            $this->db->where('product_id', $product_id);
            $this->db->update('temp_sale_details', $data);

        }
        function createSaleReturn($tmp_sale_id, $creator, $shop_id, $bd_date)
        {
            $is_exists =    $this->db
                            ->select('tmp_sale_return_id')
                            ->where('tmp_sale_id', $tmp_sale_id)
                            ->limit(1)
                            ->get('tmp_sale_return_tbl');

            if($is_exists->num_rows() == 0){
                $sale_re_data = array(
                        'tmp_sale_return_id'        => '',
                        'tmp_sale_id'               => $tmp_sale_id,
                        'tmp_sale_return_shop_id'   => $shop_id,
                        'tmp_sale_return_creator'   => $creator,
                        'total_amount'              => 0,           //initially 0
                        'tmp_sale_return_doc'       => $bd_date
                    );

                $this->db->insert('tmp_sale_return_tbl', $sale_re_data);
                return $this->db->insert_id();
            }
            else{
                $tmp = $is_exists->row();
                return $tmp->tmp_sale_return_id;
            }

        }
		
		function createSaleReturn_direct($tmp_sale_id, $creator, $shop_id, $bd_date)
        {
			$is_exists =    $this->db
                            ->select('*')
                            ->where('status = "direct"')
                            ->limit(1)
                            ->get('tmp_cash_sale_return_tbl');
			if($is_exists->num_rows() == 0){
			$sale_re_data = array(
					'tmp_cash_sale_return_creator'   => $creator,
					'status'   						 => 'direct',
					'total_amount'              	 => 0,           //initially 0
					'tmp_cash_sale_return_doc'       => $bd_date
				);

			$this->db->insert('tmp_cash_sale_return_tbl', $sale_re_data);
			return $this->db->insert_id();
			}
            else{
                $tmp = $is_exists->row();
                return $tmp->tmp_cash_sale_return_id;
            }
        }
		function get_direct_sale_return_id()
        {
			$is_exists =    $this->db
                            ->select('tmp_cash_sale_return_id')
                            ->where('status = "direct"')
                            ->limit(1)
                            ->get('tmp_cash_sale_return_tbl');
			if($is_exists->num_rows() != 0)
			{
				$tmp = $is_exists->row();
                return $tmp->tmp_cash_sale_return_id;
			}
            else
			{
                return false;
            }
        }
		function get_invoice_product_list($invoice)
		{
			$this->db->select('product_info.product_name,sale_details.product_id,sale_details.exact_sale_price,transaction_info.amount');
			$this->db->from('sale_details,product_info,transaction_info');
			$this->db->where('product_info.product_id = sale_details.product_id');
			$this->db->where('sale_details.invoice_id',$invoice);
			$this->db->where('transaction_info.common_id',$invoice);
			$this->db->group_by('sale_details.sale_details_id');
			$query = $this->db->get();
			
			return $query;
		}
		function get_invoice_product_list2($invoice)
		{
			$this->db->select('product_info.product_name,sale_details.product_id,sale_details.exact_sale_price');
			$this->db->from('sale_details,product_info');
			$this->db->where('product_info.product_id = sale_details.product_id');
			$this->db->where('sale_details.invoice_id',$invoice);
			$this->db->group_by('sale_details.sale_details_id');
			$query = $this->db->get();
			
			return $query;
		}
		function get_invoice_sale_amount($invoice)
		{
			$this->db->select('transaction_info.amount');
			$this->db->from('transaction_info');
			$this->db->where('transaction_info.transaction_purpose="sale"');
			$this->db->where('transaction_info.common_id',$invoice);
			$query = $this->db->get();
			return $query;
		}
		function get_invoice_collection_amount($invoice)
		{
			$this->db->select('transaction_info.amount');
			$this->db->from('transaction_info');
			$this->db->where('transaction_info.transaction_purpose="collection"');
			$this->db->where('transaction_info.common_id',$invoice);
			$query = $this->db->get();
			return $query;
		}
		function get_invoice_ledger_balance_amount($ledger_id)
		{
			$this->db->select('SUM(transaction_info.amount) as balance_amount,customer_info.customer_name,customer_info.customer_id');
			$this->db->from('transaction_info,customer_info');
			$this->db->where('transaction_info.ledger_id=customer_info.customer_id');
			$this->db->where('((transaction_info.transaction_purpose = "collection") OR (transaction_info.transaction_purpose = "credit_collection"))');
			$this->db->where('transaction_info.ledger_id',$ledger_id); 
			$query2 = $this->db->get();
			
			/* foreach($query2 -> result() as $result):
					$amount = $result -> amount;
			endforeach; */
			return $query2;
		}
		function get_invoice_ledger_sale_amount($ledger_id)
		{
			$this->db->select('SUM(transaction_info.amount) as sale_amount');
			$this->db->from('transaction_info,customer_info');
			$this->db->where('transaction_info.ledger_id=customer_info.customer_id');
			$this->db->where('transaction_info.transaction_purpose = "sale"');
			$this->db->where('transaction_info.ledger_id',$ledger_id); 
			$query2 = $this->db->get();
			
			/* foreach($query2 -> result() as $result):
					$amount = $result -> amount;
			endforeach; */
			return $query2;
		}
		function get_invoice_ledger_sale_return_amount($ledger_id)
		{
			$this->db->select('SUM(transaction_info.amount) as sale_retrun_amount');
			$this->db->from('transaction_info,customer_info');
			$this->db->where('transaction_info.ledger_id=customer_info.customer_id');
			$this->db->where('transaction_info.transaction_purpose = "sale_return"');
			$this->db->where('transaction_info.ledger_id',$ledger_id); 
			$query2 = $this->db->get();
			
			/* foreach($query2 -> result() as $result):
					$amount = $result -> amount;
			endforeach; */
			return $query2;
		}
		function get_invoice_sale_return_amount($invoice)
		{
			$this->db->select('transaction_info.amount');
			$this->db->from('transaction_info');
			$this->db->where('transaction_info.transaction_purpose="sale_return"');
			$this->db->where('transaction_info.common_id',$invoice);
			$query = $this->db->get();
			return $query;
		}
		function get_product_list()
		{
			$product_id = $this->input->post('product_id');
			$invoice_id = $this->input->post('invoice_id');

			$this->db->select('product_info.product_name,sale_details.product_id,sale_details.unit_buy_price,sale_details.exact_sale_price,sale_details.sale_quantity');
			$this->db->from('sale_details,product_info');
			$this->db->where('product_info.product_id = sale_details.product_id');
			$this->db->where('sale_details.product_id',$product_id);
			$this->db->where('sale_details.invoice_id',$invoice_id);
			
			$query = $this->db->get();
			
			return $query->row();
		}
		function get_product_list2()
		{
			$product_id = $this->input->post('product_id');
			//$invoice_id = $this->input->post('invoice_id');

			$this->db->select('product_info.product_name,bulk_stock_info.product_id,bulk_stock_info.general_unit_sale_price,bulk_stock_info.stock_amount');
			$this->db->from('bulk_stock_info,product_info');
			$this->db->where('product_info.product_id = bulk_stock_info.product_id');
			$this->db->where('bulk_stock_info.product_id',$product_id);
			//$this->db->where('sale_details.invoice_id',$invoice_id);
			
			$query = $this->db->get();
			
			return $query->row();
		}
		function removeProduct($product_id, $currrent_temp_sale_id, $quantity)
        {
            $this->db->select('product_specification');
			$this->db->from('product_info');
			$this->db->where('product_info.product_id',$product_id);
			
			$query = $this->db->get();
			
			$tmp = $query->row();
			if($tmp->product_specification==2)
			{
				$this->db
						->set('stock_amount', 'stock_amount+' . $quantity, FALSE)
						->where('product_id', $product_id)
						->update('bulk_stock_info');
						
				$data = array(
				
				'invoice_id' =>0,
				'status' =>1,
				);
				$this->db->where('invoice_id', $currrent_temp_sale_id);
				$this->db->where('product_id', $product_id);
				$this->db->update('warranty_product_list',$data); 

				
				$this->db->where('temp_sale_id', $currrent_temp_sale_id);
				$this->db->where('product_id', $product_id);
				$this->db->delete('temp_sale_details'); 
				
				return true;

			}
			else{
				$this->db
						->set('stock_amount', 'stock_amount+' . $quantity, FALSE)
						->where('product_id', $product_id)
						->update('bulk_stock_info');

				$this->db->where('temp_sale_id', $currrent_temp_sale_id);
				$this->db->where('product_id', $product_id);
				$this->db->delete('temp_sale_details'); 
				
				
				return true;
			}


        }
		function select_active_sale()
        {
            $this->db->select('temp_sale_id');
			$this->db->from('temp_sale_info');
			$this->db->limit(1);
			$this->db->order_by('temp_sale_info.temp_sale_id','desc'); 
			$data = $this->db->get();
			$field = $data->row();
			$temp_sale_id = $field->temp_sale_id;
            
			if($temp_sale_id == '')
			{
				$current_user = $this->tank_auth->get_user_id();
				$current_shop = $this->tank_auth->get_shop_id();
				
				$data = array(
                    'temp_sale_id'          => '',
                    'temp_sale_shop_id'     => $current_shop,
                    'temp_sale_creator'     => $current_user,
                    'return_adjust_amount'  => 0,
                    'temp_sale_status'      => 1,
				);
				
				$sql = $this->db
					->select('temp_sale_id')
					->where('temp_sale_creator', $current_user)
					->where('temp_sale_shop_id', $current_shop)
					->get('temp_sale_info');
					$this ->db->insert('temp_sale_info', $data);
					return $this->db->insert_id();
			}
			else
			{
				return $temp_sale_id;
			}
        }
		function new_active_sale_with_salereturn($return_amount)
        {

			$current_user = $this->tank_auth->get_user_id();
			$current_shop = $this->tank_auth->get_shop_id();
			
			$data = array(
				'temp_sale_id'          => '',
				'temp_sale_shop_id'     => $current_shop,
				'temp_sale_creator'     => $current_user,
				'return_adjust_amount'  => $return_amount,
				'temp_sale_status'      => 1,
			);
			
			$sql = $this->db
				->select('temp_sale_id')
				->where('temp_sale_creator', $current_user)
				->where('temp_sale_shop_id', $current_shop)
				->get('temp_sale_info');
				$this ->db->insert('temp_sale_info', $data);
				return $this->db->insert_id();
		
        }
        function addToSaleReturn($pro_id, $product_name, $unit_price,$buy_pric, $qnty, $invoice,$sale_return_id)
        {   
            $total_price = round(($unit_price * $qnty), 2);
			$current_sale_return_id 	= $this->sale_model->get_direct_sale_return_id();
            if($sale_return_id ==0)
			{
				$data = array(
                'id'                    => '',
                'tmp_sale_return_id'    => 0,
                'product_id'            => $pro_id,
                'product_name'          => $product_name,
                'return_quantity'       => $qnty,
                'buy_price'            => $buy_pric,
                'unit_price'            => $unit_price,
                'total_price'           => $total_price
                );

            $this->db->insert('tmp_sale_return_details_tbl', $data);
            $this->db->set('total_amount', ' total_amount+' . $total_price, FALSE)
                    ->where('tmp_sale_return_id', $current_sale_return_id)
                    ->update('tmp_sale_return_tbl');
			}
			else
			{
				$data = array(
					'id'                    => '',
					'tmp_sale_return_id'    => $sale_return_id,
					'product_id'            => $pro_id,
					'product_name'          => $product_name,
					'return_quantity'       => $qnty,
					'buy_price'            => $buy_pric,
					'unit_price'            => $unit_price,
					'total_price'           => $total_price
					);

				$this->db->insert('tmp_sale_return_details_tbl', $data);
				$this->db->set('total_amount', ' total_amount+' . $total_price, FALSE)
						->where('tmp_sale_return_id', $sale_return_id)
						->update('tmp_sale_return_tbl');
			}
        }
		function addToCashSaleReturn($pro_id, $product_name, $unit_price,$buy_pric, $qnty, $invoice,$sale_return_id)
        {   
            $total_price = round(($unit_price * $qnty), 2);

			$data = array(
			'id'                    => '',
			'tmp_cash_sale_return_id'    => $sale_return_id,
			'invoice_id'    			=> $invoice,
			'product_id'            => $pro_id,
			'product_name'          => $product_name,
			'return_quantity'       => $qnty,
			'buy_price'            => $buy_pric,
			'unit_price'            => $unit_price,
			'total_price'           => $total_price
			);

			$this->db->insert('tmp_cash_sale_return_details_tbl', $data);
			$this->db->set('total_amount', ' total_amount+' . $total_price, FALSE)
				->where('tmp_cash_sale_return_id', $sale_return_id)
				->update('tmp_cash_sale_return_tbl');
				return true;
        }
        function getAllSaleReturnProduct($sale_return_id, $tmp_sale_id)
        {
           $this->db->select('product_id, product_name, return_quantity, unit_price, total_price');
           $this->db->from('tmp_sale_return_tbl, tmp_sale_return_details_tbl');
           $this->db->where('tmp_sale_return_details_tbl.tmp_sale_return_id', $sale_return_id);
           $this->db->where('tmp_sale_return_tbl.tmp_sale_id', $tmp_sale_id);
           $data = $this->db->get();
            if($data->num_rows() > 0){
                return $data;
            }
            else return false;

        }
		function getAllSaleReturnProduct_direct($sale_return_id)
        {
           $this->db->select('product_id, product_name, return_quantity, unit_price, total_price');
           $this->db->from('tmp_cash_sale_return_tbl, tmp_cash_sale_return_details_tbl');
           $this->db->where('tmp_cash_sale_return_details_tbl.tmp_cash_sale_return_id', $sale_return_id);
           $this->db->where('tmp_cash_sale_return_tbl.status = "direct"');
           $data = $this->db->get();
            if($data->num_rows() > 0){
                return $data;
            }
            else return false;

        }
        function getSaleReturnId($tmp_current_sale_id)
        {
            $sql = $this->db->select('tmp_sale_return_id')->where('tmp_sale_id', $tmp_current_sale_id)->limit(1)->get('tmp_sale_return_tbl');

            if($sql->num_rows() > 0){
                $tmp = $sql->row();
                return $tmp->tmp_sale_return_id;
            }
            else return false;
        }
        function doSaleReturnTask($current_sale_id, $current_sale_return_id, $creator, $bd_date,$return_adjustment_amount,$customer_id_ledger,$invoice_ledger_id)
        {   
           // $lsat_Id = $this->db->insert_id('sale_return_receipt_tbl') + 1;
            $sql = $this->db
                            ->select('product_id, product_name, return_quantity, buy_price,unit_price, total_price, total_amount, tmp_sale_return_shop_id')
                            ->from('tmp_sale_return_tbl, tmp_sale_return_details_tbl')
                            ->where('tmp_sale_return_tbl.tmp_sale_return_id = tmp_sale_return_details_tbl.tmp_sale_return_id')
                            ->where('tmp_sale_return_tbl.tmp_sale_id', $current_sale_id)
                            ->where('tmp_sale_return_tbl.tmp_sale_return_id', $current_sale_return_id)
                            //->where('tmp_sale_return_tbl.tmp_sale_return_creator', $creator)
                            ->get();
            
            if($sql->num_rows() > 0)
            {
                $row_info = $sql->row();
				 $sale_return_receipt_data = array(
					'sale_return_id'        => '',
					'shop_id'               => $row_info->tmp_sale_return_shop_id,
					'total_return_amount'   => $row_info->total_amount,
					'status'   				=> 'indirect',
					'status2'   			=> 'regular_return',
					'creator'               => $creator,
					'sale_return_doc'       => $bd_date,
					'sale_return_dom'       => $bd_date
					);

				$this->db->insert('sale_return_receipt_tbl', $sale_return_receipt_data);
				$insert_id = $this->db->insert_id();
				
				foreach($sql->result() as $tmp)
                {
                    $sale_return_details_data = array(
                        'id'                => '',
                        'sale_return_id'    => $insert_id,
                        'product_id'        => $tmp->product_id,
                        'product_name'      => $tmp->product_name,
                        'return_quantity'   => $tmp->return_quantity,
                        'unit_buy_price'   => $tmp->buy_price,
                        'unit_sale_price'   => $tmp->unit_price,
                        'total_price'       => $tmp->total_price,
                        'return_doc'        => $bd_date,
                        'return_dom'        => $bd_date
                    );
                    $this->db->insert('sale_return_details_tbl', $sale_return_details_data);

                    $this->db   ->set('stock_amount', 'stock_amount+' . $tmp->return_quantity, FALSE)
                                ->where('product_id', $tmp->product_id)->update('bulk_stock_info');

                }
                
				$this->db
                ->set('return_id', 'return_id+' . $insert_id, FALSE)
                ->where('temp_sale_id', $current_sale_id)
                ->update('temp_sale_info');

                $this->db->where('tmp_sale_return_id', $current_sale_return_id)
                        ->where('tmp_sale_id', $current_sale_id)
                        ->where('tmp_sale_return_creator', $creator)
                        ->delete('tmp_sale_return_tbl');

                $this->db->where('tmp_sale_return_id', $current_sale_return_id)->delete('tmp_sale_return_details_tbl');

                
                $return_data ['sale_return_id']=$insert_id;

				if(($return_adjustment_amount==0 && $customer_id_ledger!=0))
				{
					$this->db
					->set('return_adjust_amount', 'return_adjust_amount+' . $return_adjustment_amount, FALSE)
					->where('temp_sale_id', $current_sale_id)
					->update('temp_sale_info');
					
					$transaction_info = array(
                    'transaction_purpose'   => 'sale_return',
                    'transaction_mode'   	=> 'due_invoice_return'.' '.$invoice_ledger_id,
                    'ledger_id'   			=> $customer_id_ledger,
                    'amount'   				=> $row_info->total_amount,
                    'date'               	=> $bd_date,
                    'status'               	=> 'active',
                    'creator'               => $creator,
                    'doc'       			=> $bd_date,
                    'dom'       			=> $bd_date
                    );

					$this->db->insert('transaction_info', $transaction_info);
					
					$return_data['total_amount']=$return_adjustment_amount;
				}
					
				else if($return_adjustment_amount!=0 && $customer_id_ledger!=0)
				{ 
					$this->db
					->set('return_adjust_amount', 'return_adjust_amount+' .$row_info->total_amount, FALSE)
					->where('temp_sale_id', $current_sale_id)
					->update('temp_sale_info');
					
					$return_data['total_amount']=$row_info->total_amount;
				}
                
                
                return $return_data;
            }
            else
			{
                return false;
            }
        } 
		
		function doSaleReturn_direct($current_sale_return_id, $creator, $bd_date)
        {   
            //$lsat_Id = $this->db->insert_id('sale_return_receipt_tbl') + 1;
			
			$status = 'direct';
            $sql = $this->db
                            ->select('product_id, product_name, return_quantity, buy_price,unit_price, total_price, total_amount')
                            ->from('tmp_cash_sale_return_tbl, tmp_cash_sale_return_details_tbl')
                            ->where('tmp_cash_sale_return_tbl.tmp_cash_sale_return_id = tmp_cash_sale_return_details_tbl.tmp_cash_sale_return_id')
                            ->where('tmp_cash_sale_return_tbl.status', $status)
                            ->get();
            
            if($sql->num_rows() > 0)
            {
                $row_info = $sql->row();
				
				$this->db->select('invoice_id');
				$this->db->from('tmp_cash_sale_return_details_tbl');
				$this->db->limit(1);
				$query1 = $this->db->get();
				$field1 = $query1->row();
				$invoice_id = $field1->invoice_id;

				
				$this->db->select('customer_id,total_paid');
				$this->db->from('invoice_info');
				$this->db->where('invoice_info.invoice_id',$invoice_id);
				$query = $this->db->get();
				$field = $query->row();
				$customer_id = $field->customer_id;
				$total_paid = $field->total_paid;
				
				if($total_paid!=0)
				{
					$transaction_info = array(
						'transaction_purpose'   => 'sale_return',
						'transaction_mode'   	=> 'cash',
						'ledger_id'   			=> $customer_id,
						'amount'   				=> $row_info->total_amount,
						'date'               	=> $bd_date,
						'status'               	=> 'active',
						'creator'               => $creator,
						'doc'       			=> $bd_date,
						'dom'       			=> $bd_date
						);

					$this->db->insert('transaction_info', $transaction_info);
					$transaction_info_cash = array(
						'transaction_purpose'   => 'cash_return',
						'transaction_mode'   	=> 'cash',
						'ledger_id'   			=> $customer_id,
						'amount'   				=> $row_info->total_amount,
						'date'               	=> $bd_date,
						'status'               	=> 'active',
						'creator'               => $creator,
						'doc'       			=> $bd_date,
						'dom'       			=> $bd_date
						);

					$this->db->insert('transaction_info', $transaction_info_cash);
					$transaction_id = $this->db->insert_id();
					$cash_book = array(
						'transaction_id'   		=> $transaction_id,
						'transaction_type'   	=> 'out',
						'amount'   				=> $row_info->total_amount,
						'date'               	=> $bd_date,
						'status'               	=> 'active',
						'creator'               => $creator,
						'doc'       			=> $bd_date,
						'dom'       			=> $bd_date
						);

					$this->db->insert('cash_book', $cash_book);
				}
				else
				{
					$transaction_info = array(
						'transaction_purpose'   => 'sale_return',
						'ledger_id'   			=> $customer_id,
						'amount'   				=> $row_info->total_amount,
						'date'               	=> $bd_date,
						'status'               	=> 'active',
						'creator'               => $creator,
						'doc'       			=> $bd_date,
						'dom'       			=> $bd_date
						);

					$this->db->insert('transaction_info', $transaction_info);
					$transaction_id = $this->db->insert_id();
				}
				$sale_return_receipt_data = array(
						'sale_return_id'        => '',
						'shop_id'               => 1,
						'total_return_amount'   => $row_info->total_amount,
						'status'   				=> 'direct',
						'creator'               => $creator,
						'sale_return_doc'       => $bd_date,
						'sale_return_dom'       => $bd_date
						);

					$this->db->insert('sale_return_receipt_tbl', $sale_return_receipt_data);
					$insert_id = $this->db->insert_id();
                foreach($sql->result() as $tmp)
                {
                    $sale_return_details_data = array(
                        'id'                => '',
                        'sale_return_id'    => $insert_id,
                        'product_id'        => $tmp->product_id,
                        'product_name'      => $tmp->product_name,
                        'return_quantity'   => $tmp->return_quantity,
                        'unit_buy_price'    => $tmp->buy_price,
                        'unit_sale_price'   => $tmp->unit_price,
                        'total_price'       => $tmp->total_price,
                        'return_doc'        => $bd_date,
                        'return_dom'        => $bd_date
                    );
                    $this->db->insert('sale_return_details_tbl', $sale_return_details_data);

                    $this->db   ->set('stock_amount', 'stock_amount+' . $tmp->return_quantity, FALSE)
                                ->where('product_id', $tmp->product_id)->update('bulk_stock_info');

                }
                $this->db->where('tmp_cash_sale_return_id', $current_sale_return_id)
                        ->delete('tmp_cash_sale_return_tbl');

                $this->db->where('tmp_cash_sale_return_id', $current_sale_return_id)->delete('tmp_cash_sale_return_details_tbl');

                return $insert_id;
            }
            else{
                return false;
            }
        }
    function cancelSaleReturn($current_sale_id, $current_sale_return_id, $creator)
    {   
        $this->db->set('return_adjust_amount', 0, FALSE)->where('temp_sale_id', $current_sale_id)->update('temp_sale_info');
        $this->db->where('tmp_sale_return_id', $current_sale_return_id)->delete('tmp_sale_return_details_tbl');

        $this->db->where('tmp_sale_return_id', $current_sale_return_id)->where('tmp_sale_id', $current_sale_id)
                ->where('tmp_sale_return_creator', $creator)
                ->delete('tmp_sale_return_tbl');

    }
    function deleteProductFromSaleReturn($sale_return_id, $product_id)
    {
        $this->db->select('tmp_sale_return_details_tbl.total_price,tmp_sale_return_tbl.total_amount');
        $this->db->from('tmp_sale_return_details_tbl,tmp_sale_return_tbl');
        $this->db->where('tmp_sale_return_details_tbl.tmp_sale_return_id=tmp_sale_return_tbl.tmp_sale_return_id');
        $this->db->where('tmp_sale_return_details_tbl.tmp_sale_return_id', $sale_return_id);
        $this->db->where('tmp_sale_return_details_tbl.product_id', $product_id);
        $query = $this->db->get();
		$tmp= $query->row();
		$total_price = $tmp->total_price;
		$total_amount = $tmp->total_amount;
		
		$final_amount = $total_amount - $total_price;
		if($final_amount > 0){
			$final_amount = $final_amount;
		}
		else{
			$final_amount = 0;
		}
		$data = array(
			'total_amount' => $final_amount
		);
		$this->db->where('tmp_sale_return_id', $sale_return_id);
		$this->db->update('tmp_sale_return_tbl', $data);
 
		$this->db->where('tmp_sale_return_id', $sale_return_id)
        ->where('product_id', $product_id)
        ->delete('tmp_sale_return_details_tbl');
    }
	function deleteProductFromCashSaleReturn($sale_return_id, $product_id)
    {
        $this->db->select('tmp_cash_sale_return_details_tbl.total_price,tmp_cash_sale_return_tbl.total_amount');
        $this->db->from('tmp_cash_sale_return_details_tbl,tmp_cash_sale_return_tbl');
        $this->db->where('tmp_cash_sale_return_details_tbl.tmp_cash_sale_return_id=tmp_cash_sale_return_tbl.tmp_cash_sale_return_id');
        $this->db->where('tmp_cash_sale_return_details_tbl.tmp_cash_sale_return_id', $sale_return_id);
        $this->db->where('tmp_cash_sale_return_details_tbl.product_id', $product_id);
        $query = $this->db->get();
		$tmp= $query->row();
		$total_price = $tmp->total_price;
		$total_amount = $tmp->total_amount;
		
		$final_amount = $total_amount - $total_price;
		if($final_amount > 0){
			$final_amount = $final_amount;
		}
		else{
			$final_amount = 0;
		}
		$data = array(
			'total_amount' => $final_amount
		);
		$this->db->where('tmp_cash_sale_return_id', $sale_return_id);
		$this->db->update('tmp_cash_sale_return_tbl', $data);
 
		$this->db->where('tmp_cash_sale_return_id', $sale_return_id)
        ->where('product_id', $product_id)
        ->delete('tmp_cash_sale_return_details_tbl');
    }
    /******************************ending(added functions by arun)********************************/
                
                
		/*********************************
		* Sale System for Vission Express
		* Running Sales
		* 25-11-2013
		* Arafat Mamun
		**********************************/
		function running_my_sales($current_user, $current_shop)
		{
			$this -> db -> order_by('temp_sale_id', "asc");
			$this -> db -> where('temp_sale_shop_id', $current_shop);
			$this -> db -> where('temp_sale_creator', $current_user);
			return $this -> db -> get('temp_sale_info');
		}
		function all_point($customer_id)
		{
			$this -> db -> select_sum('total_point');
			$this -> db ->from('point_info');
			$this -> db -> where('temp_sale_shop_id', $current_shop);
			$this -> db -> where('temp_sale_creator', $current_user);
			return $this -> db -> get('');
		}
		
		/*****************************
		* Sale System for Vission Express
		* All / Specific Product Name  
		* 25-11-2013
		* Arafat Mamun
		******************************/ 
		function productsss_info($specific , $product_id, $shop_id)
		{	
			$this -> db -> select('product_name, product_info.product_id, stock_amount,product_specification,
								   catagory_name,company_name,barcode , product_size,product_model,
								   bulk_unit_buy_price, unit_name,
								   bulk_unit_sale_price as unit_sale_price,general_unit_sale_price');
			$this -> db -> from('bulk_stock_info, product_info');
			$this -> db -> where('bulk_stock_info.shop_id', $shop_id);
			if($specific) $this -> db -> where('product_info.product_id', $product_id);
			$this -> db -> where('bulk_stock_info.stock_amount >0 ');
			$this -> db -> where('product_info.product_id = bulk_stock_info.product_id ');
			$this -> db -> order_by('product_info.product_name');
			return $this -> db -> get();
		}
		function products_info($specific , $product_id, $shop_id)
		{	
			$this -> db -> select('product_name, product_info.product_id, stock_amount,product_specification,
								   catagory_name,company_name,barcode , product_size,product_model,
								   bulk_unit_buy_price, unit_name,
								   bulk_unit_sale_price as unit_sale_price,general_unit_sale_price');
			$this -> db -> from('bulk_stock_info, product_info');
			$this -> db -> where('bulk_stock_info.shop_id', $shop_id);
			if($specific) $this -> db -> where('product_info.product_id', $product_id);
			$this -> db -> where('product_info.product_id = bulk_stock_info.product_id ');
			$this -> db -> order_by('product_info.product_name');
			return $this -> db -> get();
		}
		function products_info_barcode($specific , $barcode, $shop_id)
		{	
			$this -> db -> select('product_name, product_info.product_id, stock_amount,product_specification,
								   catagory_name,company_name,product_size,product_model,
								   bulk_unit_buy_price, unit_name,
								   bulk_unit_sale_price as unit_sale_price');
			$this -> db -> from('bulk_stock_info, product_info');
			$this -> db -> where('bulk_stock_info.shop_id', $shop_id);
			if($specific) $this -> db -> where('product_info.barcode', $barcode);
			$this -> db -> where('product_info.product_id = bulk_stock_info.product_id ');
			return $this -> db -> get();
		}
		
		/*********************************
		* Sale System for Vission Express
		* Add Products to my sale
		* 25-11-2013
		* Arafat Mamun
		**********************************/
		function add_products_to_my_sale($selectedProductId, $selectedProductType, $selectedStockId,
											$selectedProductQuantity, $currrent_temp_sale_id,
											$unitSalePrice,$general_unit_sale_price, $unitBuyPrice){
			//echo $selectedProductType;
			
			$this->db->where('temp_sale_id',$currrent_temp_sale_id);
			$this->db->from('temp_sale_info');
			$query = $this->db->get();
			
			if($currrent_temp_sale_id!='' && $query->num_rows() > 0 && $selectedProductQuantity > 0.1){
			
			if($selectedProductType == 'individual'){
				
				$selectedProductQuantity = 1;
				$status = $this -> db -> query("SELECT stock_status
											FROM stock_info
											WHERE stock_id = '".$selectedStockId."'
											AND shop_id = ".$this -> shop_id."
											AND (stock_status = 'returned'
											     OR stock_status = 'stocked')");
				if($status -> num_rows < 1) return false;
									
				$this -> db -> query ("UPDATE stock_info
										SET listed_by =".$this -> currentUser.",
											stock_status = 'listed'
										WHERE stock_info.stock_id = '".$selectedStockId."'
										AND product_id = ".$selectedProductId."");
										
				$this -> db -> query("UPDATE bulk_stock_info
									  SET stock_amount = stock_amount - '".$selectedProductQuantity."'
									  WHERE bulk_stock_info.product_id = ".$selectedProductId."
									  AND shop_id = ".$this -> shop_id." ");
				$data = array(
					   'temp_sale_id' => $currrent_temp_sale_id,
					   'product_id' => $selectedProductId,
					   'stock_id' => $selectedStockId,
					   'sale_quantity' => 1,
					   'product_specification' => $selectedProductType,
					   'sale_type' => 1,
					   'discount_info_id' => 0,
					   'discount' => 0,
					   'discount_type' => 0,
					   'unit_buy_price' => $unitBuyPrice,
					   'unit_sale_price' => $unitSalePrice,
					   'general_unit_sale_price' => $general_unit_sale_price,
					   'actual_sale_price' => $unitSalePrice,
					   'temp_sale_details_status' => 1
						);
					$this -> db -> insert('temp_sale_details', $data);
					$tempSaleDetialsId = $this -> db -> insert_id();
				
			}
			else{
				
/* 				$prevListInfo = $this -> my_sale_listed_products($currrent_temp_sale_id, TRUE, $selectedProductId);
				if($prevListInfo -> num_rows() > 0){
					
					foreach($prevListInfo -> result() as $field):
						$tempSaleDetialsId = $field -> temp_sale_details_id;
						$prevServingQuantity = $field-> sale_quantity;
						$saleType = $field-> sale_type;
					endforeach;
					
					$this -> db -> query("UPDATE bulk_stock_info
										  SET stock_amount = stock_amount + ".$prevServingQuantity."
										  WHERE product_id = ".$selectedProductId."
										  AND shop_id = ".$this -> shop_id." 
										 ");
										 
					$this -> db -> query("UPDATE temp_sale_details
										  SET sale_quantity = 0,
											  unit_buy_price = 0,
											  unit_sale_price = 0,
											  discount_type = 0,
											  sale_type = 0,
											  discount = 0,
											  discount_info_id = 0
										  WHERE product_id = ".$selectedProductId."
										  AND temp_sale_details_id = ".$tempSaleDetialsId."
										 ");
				}
				else{ */
					
					$this -> db -> where('stock_amount >= '.$selectedProductQuantity.'');								
					$this -> db -> where('product_id', $selectedProductId);							
					$this -> db -> where('shop_id', $this -> shop_id);							
					$productStatus = $this -> db -> get('bulk_stock_info');
					if($productStatus -> num_rows() < 1)
						return false;
						
					$data = array(
					   'temp_sale_id' => $currrent_temp_sale_id,
					   'product_id' => $selectedProductId,
					   'stock_id' => 0,
					   'sale_quantity' => 0,
					   'product_specification' => $selectedProductType,
					   'sale_type' => 0,                                
					   'discount_info_id' => 0,
					   'discount' => 0,
					   'discount_type' => 0,
					   'unit_buy_price' => 0,
					   'unit_sale_price' => 0,
					   'actual_sale_price' => 0,
					   'temp_sale_details_status' => 1
						);
					$this -> db -> insert('temp_sale_details', $data);
					$tempSaleDetialsId = $this -> db -> insert_id();
					
				//}
				
				
				$this -> db -> where('stock_amount >= '.$selectedProductQuantity.'');								
				$this -> db -> where('product_id', $selectedProductId);							
				$this -> db -> where('shop_id', $this -> shop_id);							
				$productStatus = $this -> db -> get('bulk_stock_info');
				if($productStatus -> num_rows() < 1)
					return 'notSufficient';

				$this -> db -> query("UPDATE bulk_stock_info
									  SET stock_amount = stock_amount - ".$selectedProductQuantity."
									  WHERE product_id = ".$selectedProductId."
									  AND shop_id = ".$this -> shop_id."
									 ");
				 
				$this -> db -> query("UPDATE temp_sale_details
									  SET sale_quantity = ".$selectedProductQuantity.",
										  unit_buy_price = ".$unitBuyPrice.",
										  unit_sale_price = ".$unitSalePrice.",
										  general_unit_sale_price = ".$general_unit_sale_price.",
										  actual_sale_price = ".$unitSalePrice.",
										  product_specification = '".$selectedProductType."',
										  sale_type = 1
									  WHERE product_id = ".$selectedProductId."
									  AND temp_sale_details_id = ".$tempSaleDetialsId."
									 ");
				
			}
			
			$discountInfo = $this -> discountInfo($selectedProductId);
			
			if($discountInfo -> num_rows() > 0){
				foreach($discountInfo -> result() as $field):
					$discountInfoId = $field -> discount_info_id; 
					$validationQuantity = $field -> validate_quantity;
					if($field-> discount_type == 3){
						$discount = floor($selectedProductQuantity/$validationQuantity) * $field-> discount;
					}
					else{
						$discount = $field-> discount;
					}
					$discountType = $field-> discount_type;
				endforeach;
				
				if($selectedProductQuantity >= $validationQuantity){
					$totalSalePrice = $selectedProductQuantity * $unitSalePrice;
					if($discountType == 1){
						$decrementedTotal = (( 100.00 - $discount ) * $totalSalePrice) /(  100.00 );
						$avgSalePrice = $decrementedTotal / $selectedProductQuantity;
					}
					else if($discountType == 3){
						$decrementedTotal = $totalSalePrice - $discount;
						$avgSalePrice = $decrementedTotal / $selectedProductQuantity;
					}
					$this -> db -> query("UPDATE temp_sale_details
										  SET unit_sale_price = ".$avgSalePrice.",
											  discount_info_id = ".$discountInfoId.",
											  discount_type = ".$discountType.",
											  discount = ".$discount."
										  WHERE product_id = ".$selectedProductId."
										  AND temp_sale_details_id = ".$tempSaleDetialsId."
										 ");
				}
			}
			
			return true;
			}
			else{
				return FALSE;
			}
		}
		
		
		function add_product_to_my_sale_with_barcode(){
			$currrent_temp_sale_id = $this->tank_auth->get_current_temp_sale();
			$selectedProductQuantity = 1;
			$selectedProductType = 'bulk';
			


			$barcode = $this -> input -> post('barcode');
			$this->db->select('product_info.product_id,bulk_stock_info.bulk_unit_buy_price,bulk_stock_info.general_unit_sale_price,bulk_stock_info.bulk_unit_sale_price');
			$this->db->from('product_info,bulk_stock_info');
			$this->db->where('product_info.product_id = bulk_stock_info.product_id');
			$this->db->where('product_info.barcode',$barcode);
			$quer=$this->db->get();
			if($quer->num_rows >0){
				foreach($quer -> result() as $field):
					$selectedProductId = $field -> product_id;
					$unitBuyPrice = $field -> bulk_unit_buy_price;
					$unitSalePrice = $field -> bulk_unit_sale_price;
					$general_unit_sale_price = $field -> general_unit_sale_price;
				endforeach;
			}
			else{
				return false;
			}
			
			if($currrent_temp_sale_id!=''){
				
				$prevListInfo = $this -> my_sale_listed_products($currrent_temp_sale_id, TRUE, $selectedProductId);
				
				$this -> db -> where('stock_amount >= 1');								
				$this -> db -> where('product_id', $selectedProductId);							
				$this -> db -> where('shop_id', $this -> shop_id);							
				$productStatus = $this -> db -> get('bulk_stock_info');
				if($productStatus -> num_rows() < 1)
					return FALSE;
				
				if($prevListInfo -> num_rows() > 0){
					
					foreach($prevListInfo -> result() as $field):
						$tempSaleDetialsId = $field -> temp_sale_details_id;
						$prevServingQuantity = $field-> sale_quantity;
						$saleType = $field-> sale_type;
					endforeach;
					
					/* $this -> db -> query("UPDATE bulk_stock_info
										  SET stock_amount = stock_amount + ".$prevServingQuantity."
										  WHERE product_id = ".$selectedProductId."
										  AND shop_id = ".$this -> shop_id." 
										 ");
										 
					$this -> db -> query("UPDATE temp_sale_details
										  SET sale_quantity = 0,
											  unit_buy_price = 0,
											  unit_sale_price = 0,
											  discount_type = 0,
											  sale_type = 0,
											  discount = 0,
											  discount_info_id = 0
										  WHERE product_id = ".$selectedProductId."
										  AND temp_sale_details_id = ".$tempSaleDetialsId."
										 "); */
				}
				else{
					
					$this -> db -> where('stock_amount >= '.$selectedProductQuantity.'');								
					$this -> db -> where('product_id', $selectedProductId);							
					$this -> db -> where('shop_id', $this -> shop_id);							
					$productStatus = $this -> db -> get('bulk_stock_info');
					if($productStatus -> num_rows() < 1)
						return false;
						
					$data = array(
					   'temp_sale_id' => $currrent_temp_sale_id,
					   'product_id' => $selectedProductId,
					   'stock_id' => 0,
					   'sale_quantity' => 0,
					   'product_specification' => $selectedProductType,
					   'sale_type' => 0,
					   'discount_info_id' => 0,
					   'discount' => 0,
					   'discount_type' => 0,
					   'unit_buy_price' => 0,
					   'unit_sale_price' => 0,
					   'actual_sale_price' => 0,
					   'temp_sale_details_status' => 1
						);
					$this -> db -> insert('temp_sale_details', $data);
					$tempSaleDetialsId = $this -> db -> insert_id();
					
				}
				
				
				

				$this -> db -> query("UPDATE bulk_stock_info
									  SET stock_amount = stock_amount - ".$selectedProductQuantity."
									  WHERE product_id = ".$selectedProductId."
									  AND shop_id = ".$this -> shop_id."
									 ");
				 
				$this -> db -> query("UPDATE temp_sale_details
									  SET sale_quantity = sale_quantity + ".$selectedProductQuantity.",
										  unit_buy_price = ".$unitBuyPrice.",
										  unit_sale_price = ".$unitSalePrice.",
										  general_unit_sale_price = ".$general_unit_sale_price.",
										  actual_sale_price = ".$unitSalePrice.",
										  product_specification = '".$selectedProductType."',
										  sale_type = 1
									  WHERE product_id = ".$selectedProductId."
									  AND temp_sale_details_id = ".$tempSaleDetialsId."
									");
				

			
			$discountInfo = $this -> discountInfo($selectedProductId);
			
			if($discountInfo -> num_rows() > 0){
				foreach($discountInfo -> result() as $field):
					$discountInfoId = $field -> discount_info_id; 
					$validationQuantity = $field -> validate_quantity;
					if($field-> discount_type == 3){
						$discount = floor($selectedProductQuantity/$validationQuantity) * $field-> discount;
					}
					else{
						$discount = $field-> discount;
					}
					$discountType = $field-> discount_type;
				endforeach;
				
				if($selectedProductQuantity >= $validationQuantity){
					$totalSalePrice = $selectedProductQuantity * $unitSalePrice;
					if($discountType == 1){
						$decrementedTotal = (( 100.00 - $discount ) * $totalSalePrice) /(  100.00 );
						$avgSalePrice = $decrementedTotal / $selectedProductQuantity;
					}
					else if($discountType == 3){
						$decrementedTotal = $totalSalePrice - $discount;
						$avgSalePrice = $decrementedTotal / $selectedProductQuantity;
					}
					$this -> db -> query("UPDATE temp_sale_details
										  SET unit_sale_price = ".$avgSalePrice.",
											  discount_info_id = ".$discountInfoId.",
											  discount_type = ".$discountType.",
											  discount = ".$discount."
										  WHERE product_id = ".$selectedProductId."
										  AND temp_sale_details_id = ".$tempSaleDetialsId."
										 ");
				}
			}
			
			return true;
			}
			else{
				return FALSE;
			}
		}
		
		
		/***************************************
		 * Sale System for Cash Carry
		 * ALL / Specific Listed Products
		 * 09-07-2014
		 * Arafat Mamun
		****************************************/
		function discountInfo($productId){
			
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bdDate = date('Y-m-d');
			
			$this -> db -> select('validate_quantity, discount, quantity,
								   discount_type, discount_info.discount_info_id
								');
			$this -> db -> from('discount_info, discount_details');
			$this -> db -> where('discount_info.shop_id', $this -> shop_id);
			$this -> db -> where('discount_info.product_id', $productId);
			$this -> db -> where('discount_info.discount_info_id = discount_details.discount_info_id ');
			$this -> db -> where('start_date <= "'.$bdDate.'"');
			$this -> db -> where('end_date >= "'.$bdDate.'"');
			return $this -> db -> get();
		}
		
		
		
		/***************************************
		 * Sale System for Vission Express
		 * ALL / Specific Listed Products
		 * 28-11-2013
		 * Arafat Mamun
		****************************************/
		function my_sale_listed_products($currrent_temp_sale_id, $specific , $product_id)
		{
			$creator = $this -> tank_auth -> get_user_id();
			$this -> db -> order_by("product_name", "asc");
			$this -> db -> select('temp_sale_details_id, product_info.product_id,
								   temp_sale_info.temp_sale_id,
								   product_name, sale_quantity ,
								   unit_sale_price, general_unit_sale_price,unit_buy_price,
								   stock_id, temp_sale_details.product_specification,
								   sale_type, discount_info_id,
								   discount_type, discount, unit_name, actual_sale_price
								   ');
			$this -> db -> from('temp_sale_details,product_info,temp_sale_info');
			$this -> db -> where('temp_sale_details_status', 1);
			$this -> db -> where('temp_sale_status', 1);
			$this -> db -> where('temp_sale_info.temp_sale_id', $currrent_temp_sale_id);
			//$this -> db -> where('temp_sale_creator', $creator);
			if($specific) $this -> db -> where('product_info.product_id', $product_id);
			$this -> db -> where('temp_sale_info.temp_sale_id = temp_sale_details.temp_sale_id');
			$this -> db -> where('temp_sale_details.product_id = product_info.product_id');
			//$this -> db -> group_by('product_info.product_id');
			

			return $this -> db -> get();
		}
		
		/*****************************************************
		 * Sale System for Cash And Carry
		 * Remove Individual Product from My Sale   *******
		 * 08-07-2014
		 * Arafat Mamun
		******************************************************/
		function removeIndividualProduct($tempSaleDetailsId, $stockId, $productId){
			
			$this -> db -> query("UPDATE stock_info
								  SET listed_by = 0,
									stock_status = 'stocked'
								  WHERE stock_info.stock_id = '".$stockId."'
								");
										
			$this -> db -> query("UPDATE bulk_stock_info
								  SET stock_amount = stock_amount + 1
								  WHERE bulk_stock_info.product_id = ".$productId."
								  AND shop_id = ".$this -> shop_id." ");
								  
			$this -> db -> query("UPDATE temp_sale_details
								  SET temp_sale_details_status = 0
								  WHERE temp_sale_details_id = ".$tempSaleDetailsId."
								  AND product_id = ".$productId." ");
			return true;
		}
		
		/*****************************************************
		 * Sale System for Cash And Carry
		 * Remove Bulk Product from My Sale   *******
		 * 08-07-2014
		 * Arafat Mamun
		******************************************************/
		function removeBulkProduct($tempSaleDetailsId, $productId){
			$currrent_temp_sale_id = $this -> tank_auth -> get_current_temp_sale();
			$prevListInfo = $this -> my_sale_listed_products($currrent_temp_sale_id, TRUE, $productId);
			if($prevListInfo -> num_rows() > 0){
				
				foreach($prevListInfo -> result() as $field):
					if($tempSaleDetailsId == $field -> temp_sale_details_id){
						$tempSaleDetialsId = $field -> temp_sale_details_id;
						$prevServingQuantity = $field-> sale_quantity;
						$saleType = $field-> sale_type;
					}
				endforeach;
				
				$this -> db -> query("UPDATE bulk_stock_info
									  SET stock_amount = stock_amount + ".$prevServingQuantity."
									  WHERE product_id = ".$productId."
									  AND shop_id = ".$this -> shop_id." 
									 ");
									 
				/* $this -> db -> query("UPDATE temp_sale_details
									  SET sale_quantity = 0,
										  unit_buy_price = 0,
										  unit_sale_price = 0,
										  temp_sale_details_status = 0
									  WHERE product_id = ".$productId."
									  AND temp_sale_details_id = ".$tempSaleDetialsId."
									 "); */
				$this -> db -> query("DELETE FROM temp_sale_details 
									  WHERE product_id = ".$productId."
									  AND temp_sale_details_id = ".$tempSaleDetialsId."
									 ");
			}
		}
		
		
		
		
		/****************************
		 * Sale System for Vission Express
		 * Cancle A My Sale 
		 * 28-11-2013
		 * Arafat Mamun
		*****************************/
		function my_sale_cancle( $currrent_temp_sale_id)
		{
			$creator = $this -> tank_auth -> get_user_id();
			
			$this -> db -> select('temp_sale_details_id,product_info.product_id,unit_buy_price,
								   unit_sale_price,temp_sale_info.temp_sale_id, sale_quantity,
								   temp_sale_details.product_specification, stock_id,
								   temp_sale_details_status');
								   
			$this -> db -> from('temp_sale_details,product_info,temp_sale_info');
			$this -> db -> where('temp_sale_info.temp_sale_id', $currrent_temp_sale_id);
			//$this -> db -> where('temp_sale_creator', $creator);
			$this -> db -> where('temp_sale_info.temp_sale_id = temp_sale_details.temp_sale_id');
			$this -> db -> where('temp_sale_details.product_id = product_info.product_id');
			$query = $this -> db -> get();
			

			foreach($query -> result() as $field):
				if($field -> temp_sale_details_status == 1){
				$this -> db -> query("UPDATE bulk_stock_info
									  SET stock_amount = stock_amount + ".$field -> sale_quantity."
									  WHERE product_id = ".$field -> product_id."
									  AND  shop_id = ".$this -> shop_id." ");
				//  bulk_unit_buy_price = (( bulk_unit_buy_price * stock_amount) + ( ".$field -> unit_buy_price." * ".$field -> sale_quantity.") / ( stock_amount + ".$field -> sale_quantity.")),
				$this -> db -> query("DELETE  FROM temp_sale_details
									  WHERE product_id = ".$field -> product_id."
									  AND temp_sale_details_id = ".$field -> temp_sale_details_id."");
									  }

			endforeach;
			
			$this -> db -> query("DELETE  FROM temp_sale_info
								  WHERE temp_sale_id = ".$currrent_temp_sale_id."");
			return true;
		}
		/*****************************************************
		 * Sale System for Vission Express
		 * Remove Product from My Sale BY Product ID 
		 * 28-11-2013
		 * Arafat Mamun
		******************************************************/
		function remove_my_sale_product_by_product_id( $currrent_temp_sale_id, $selected_product_id,$removing_quantity)
		{
			$creator = $this -> tank_auth -> get_user_id();
			$this -> db -> order_by("temp_sale_details_id", "desc");
			$this -> db -> select('temp_sale_details_id,product_info.product_id,unit_buy_price,
								   unit_sale_price,temp_sale_info.temp_sale_id');			   
			$this -> db -> from('temp_sale_details,product_info,temp_sale_info');
			$this -> db -> where('product_info.product_id', $selected_product_id);
			$this -> db -> where('temp_sale_info.temp_sale_id', $currrent_temp_sale_id);
			$this -> db -> where('temp_sale_creator', $creator);
			$this -> db -> where('temp_sale_info.temp_sale_id = temp_sale_details.temp_sale_id');
			$this -> db -> where('temp_sale_details.product_id = product_info.product_id');
			$query = $this -> db -> get();
			
			$run_count = 1;
			foreach($query -> result() as $field):
				$this -> db -> query("UPDATE bulk_stock_info
									  SET bulk_unit_buy_price = (( bulk_unit_buy_price * stock_amount) + '".$field -> unit_buy_price."') / ( stock_amount + 1),
									      stock_amount = stock_amount + 1
									  WHERE product_id = ".$selected_product_id."
									  AND  shop_id = ".$this -> shop_id." ");
				$this -> db -> query("DELETE  FROM temp_sale_details
									  WHERE product_id = ".$selected_product_id."
									  AND temp_sale_details_id = ".$field -> temp_sale_details_id."");
				if($run_count == $removing_quantity) break;
				$run_count++;
			endforeach;
			return true;
		}
		
	
		
	
	/**********************************************
	 *  All Customer Info                                                   *
	 * *********************************************/
	function customer_info()
	{
		
		if($this -> uri -> segment(3) == 'credit_sale' )
		{
			$this -> db -> order_by("customer_name", "asc");
			$query = $this -> db -> get('customer_info');
			return $query;
		}
		else if($this -> uri -> segment(3) =='listed_customers' )
		{
			$this -> db -> order_by("customer_name", "asc");
			$query = $this -> db -> select('customer_name,customer_contact_no,customer_address')
							  -> from('invoice_info')
							  -> where('customer_name <> "Quick Sale"')
							  -> get();
			return $query;
		}
	}
	
	/******************************************
	 *  All Information of a Specific Customer   *
	 * *****************************************/
	function specific_customer_info($specific,$customer_id )
	{
		//$customer_name = str_replace('~', ' ',$this -> uri -> segment(5));	
		$this -> db -> order_by("customer_name", "asc");
		$this -> db -> select('customer_id,customer_define_id,customer_type,customer_mode,customer_email,customer_name,customer_contact_no,customer_address');
		$this -> db -> from('customer_info');
		if($specific) 
			$this -> db -> where('customer_id = "'.$customer_id.'"');
		return 	$this -> db-> get();
	}

	function add_to_sale()
	{
		$stock_id = $this -> input ->post('stock_id');
		$creator = $this->tank_auth->get_user_id();
		if($stock_id)
		{
			/*
			$status = $this -> db -> select('stock_status')
								  -> from('stock_info')
								  -> where('stock_status = "stocked"')
								  -> or_where('stock_status = "returned"')
								  -> where('stock_id = "'.$stock_id.'"')
								  -> get();
			*/
			$status = $this -> db -> query("SELECT stock_status
											FROM stock_info
											WHERE stock_id = '".$stock_id."' 
											AND (stock_status = 'returned'
											     OR stock_status = 'stocked')");
			if($status -> num_rows < 1) return false;
								
			$this -> db -> query ("UPDATE stock_info
									SET listed_by ='".$creator."',stock_status = 'listed'
									where stock_info.stock_id = '".$stock_id."'");
		}
		return true;
	}
	
	/*******************************************
	 *  Set Sle Running Mode                                     *
	 * ******************************************/
	 function set_sale_running_mode(  $creator )
	 {
		$mode = $this -> uri -> segment(3);
		$new_sale_running_mode_data = array(
				'sale_creator' => $creator,
				'sale_running_mode' =>  $mode
				);
				$insert = $this -> db -> insert('sale_running_info', $new_sale_running_mode_data );
	 }
	
	/*************************************** **
	 *  IS IT A WHOLE SALE OR RETAIL SALE   *
	 * ****************************************/
	function sale_running_mode( $creator) 
	{
		$query = $this -> db -> select('sale_running_mode')
							 -> from('sale_running_info')
							 -> where('sale_creator = "'.$creator.'"')
							 -> get();
		$temp = 'not_running';
		foreach($query -> result() as $field):
			$temp = $field -> sale_running_mode;
		endforeach;
			return $temp;
	}
	
	/*************************************
	 *  Unset Sale Running Mode                 *
	 * ************************************/
	function  unset_sale_running_mode()
	{
	 	$creator = $this->tank_auth->get_user_id();
		return $this -> db -> query("DELETE  FROM sale_running_info WHERE sale_creator = ".$creator." ");
	}
	
	/** by stock id serach query result**/ 
	function by_product_code_result()
	{	
	
		$creator = $this->tank_auth->get_user_id();
		$temp = $this ->sale_running_mode( $creator) ;
		if($temp == 'whole_sale') $field = 'whole_sale_price';
		else //if($temp == 'retail_sale')
		$field = 'unit_sale_price';				     				 
	 	$query = $this -> db -> select('product_name,product_info.product_id, '.$field.' AS unit_sale_price,
										stock_id,serial_no, bulk_unit_buy_price AS unit_buy_price')
		                     -> from('product_info, purchase_info, stock_info, purchase_receipt_info,
		                     		  sale_price_info,bulk_stock_info')
							 -> where('product_info.product_id = purchase_info.product_id')
							 -> where('purchase_info.purchase_receipt_id = purchase_receipt_info.receipt_id')
							// -> where('distributor_info.distributor_id = purchase_receipt_info.distributor_id')
							 -> where('stock_info.purchase_id = purchase_info.purchase_id')
							// -> where('product_info.company_name = company_info.company_name')
							 -> where('product_info.product_id = sale_price_info.product_id')
							 -> where('bulk_stock_info.product_id = product_info.product_id ')
							 -> where('stock_info.stock_status = "listed"')
							 -> where('stock_info.listed_by = "'.$creator.'"')
							 // -> group_by('product_info.product_name')
							 -> get();
		return $query;
	} 
	 
        
        /* BULK SALE QUERY */
  	 function by_product_code_result_bulk()
  	 {	
		$creator = $this->tank_auth->get_user_id();	
		/***** For Previous Dokani Version Before Vission Express ******/
		/*				     				 
  	 	$query = $this -> db -> select('product_info.product_name,product_info.product_id, bulk_sale_temp.unit_sale_price,
  	 									bulk_sale_quantity, bulk_sale_temp.unit_buy_price ') //count( product_info.product_name ) as number_of_quantity
		                     -> from('product_info, bulk_sale_temp, bulk_stock_info,sale_price_info')
							 -> where('product_info.product_id = bulk_sale_temp.product_id')
							 -> where('product_info.product_id = bulk_stock_info.product_id')
							 -> where('product_info.product_id = sale_price_info.product_id')
							 -> where('bulk_sale_temp.bulk_sale_creator = "'.$creator.'"')
							  //-> group_by('product_info.product_name')
							 -> get();
		return $query;
		****** End Previous Dokani Version Before Vission Express*******/
		
		
		/********** Vission Express ******************/
		$currrent_temp_sale_id = $this -> tank_auth -> get_current_temp_sale();
		
		$this -> db -> order_by("product_name", "asc");
		$this -> db -> select('temp_sale_details_id,product_info.product_id,
							   temp_sale_info.temp_sale_id, unit_buy_price,
							   product_name,COUNT(temp_sale_details.product_id) as bulk_sale_quantity,
							   SUM(unit_sale_price) as product_total_price,
							   ( SUM(unit_sale_price) / COUNT(temp_sale_details.product_id) ) as unit_sale_price ');
		$this -> db -> from('temp_sale_details,product_info,temp_sale_info');
		$this -> db -> where('temp_sale_details_status', 1);
		$this -> db -> where('temp_sale_status', 1);
		$this -> db -> where('temp_sale_info.temp_sale_id', $currrent_temp_sale_id);
		$this -> db -> where('temp_sale_creator', $creator);
	
		$this -> db -> where('temp_sale_info.temp_sale_id = temp_sale_details.temp_sale_id');
		$this -> db -> where('temp_sale_details.product_id = product_info.product_id');
		$this -> db -> group_by('product_info.product_id');
		
		return $this -> db -> get();
  	 } 
	 
	 /* UNSETTING SALE */
	 function for_update_stock_status()
	 {
	 	$creator = $this->tank_auth->get_user_id();	
		$this -> db -> query("UPDATE stock_info 
							  SET stock_status = 'stocked'
							  WHERE listed_by = '".$creator."'
							  AND stock_status = 'listed'");
	 }

	 function for_update_stock_status_bulk($stock_bulk)
	 {
	 	foreach($stock_bulk -> result() as $field)
	 	{
	 		$t_quantity = $field -> bulk_sale_quantity;
	 		$t_amount = $field -> unit_buy_price;
	 		$t_product = $field -> product_id;
	 		$main = $this -> db -> select('*')
	 							-> from('bulk_stock_info')
	 							-> where('bulk_stock_info.product_id = "'.$t_product.'"')
	 							-> get();
	 		
	 		foreach($main -> result() as $m):
	 			$m_quantity = $m -> stock_amount;
	 			$m_amount = $m -> bulk_unit_buy_price;
	 		endforeach;
	 		
	 		$f_quantity = $t_quantity + $m_quantity;
	 		
	 		if( $f_quantity )
						$temp_f_quantity = $f_quantity;
					else $temp_f_quantity = 1;
	 		
	 		$f_amount = (($t_amount * $t_quantity) + ($m_amount * $m_quantity)) / $temp_f_quantity;
	 		$this -> db -> query("UPDATE bulk_stock_info SET stock_amount = ".$f_quantity.", 
										bulk_unit_buy_price = ".$f_amount." WHERE product_id = ".$t_product." ");
			$this -> db -> query("DELETE  FROM bulk_sale_temp WHERE product_id = ".$t_product."
									AND bulk_sale_creator = ".$this->tank_auth->get_user_id()."");
	 	}
	 }
	 
	 /* END of UNSETTING SALE */
	 
	 /* Select Distinct  Stock ID for  SALE listed product*/
	function distinct_product_on_sale_id()
	{
		$creator = $this->tank_auth->get_user_id();	
		$query = $this ->db -> select('product_name,  sale_price_info.unit_sale_price,product_info.product_id, count( product_info.product_name ) as number_of_quantity')
			                -> from('product_info, purchase_info, stock_info, sale_price_info, bulk_stock_info')
							-> where('product_info.product_id = purchase_info.product_id')
							-> where('stock_info.purchase_id = purchase_info.purchase_id')
							-> where('product_info.product_id = bulk_stock_info.product_id')
							-> where('product_info.product_id = sale_price_info.product_id')
							-> where('stock_info.stock_status = "listed"')
							-> where('stock_info.listed_by = "'.$creator.'"')
							-> group_by('product_info.product_name')
							-> get();
		return $query;
	}
	/* MAKE ALL STOCK ID AS A SINGLE STRING */
	function single_stock($sale_stock)
	{
		$creator = $this->tank_auth->get_user_id();	
		foreach($sale_stock -> result() as $field)
		{
			$product_id = $field -> product_id;
			$query = $this -> db -> select('stock_id')
							  	 -> from('stock_info,product_info, purchase_info')							  
							  	 -> where('product_info.product_id = "'.$product_id.'"')
							  	 -> where('stock_info.stock_status = "listed"')
								 -> where('stock_info.listed_by = "'.$creator.'"')
							  	 -> where('product_info.product_id = purchase_info.product_id')
							 	 -> where('stock_info.purchase_id = purchase_info.purchase_id')
							  	 -> get();
			$data[ $product_id ] = ''; 
			$temp = $query -> num_rows();
				$temp_count = 1;
				foreach($query -> result() as $string):
					$data[ $product_id ] = $data[ $product_id ].''.$string -> stock_id;
					if( $temp_count != $temp ) $data[ $product_id ]  = $data[ $product_id ] .',';
					$temp_count++;
				endforeach;
		}
		if($sale_stock -> num_rows > 0 ) return $data;
	}
	/*end STOCK ID AS A SINGLE STRING*/
	 
	 
	 
	 
	 function  delete_a_spefific_product($stock_id,$pro_id)
	 {
	 	$creator = $this->tank_auth->get_user_id();	
		$this -> db -> query("UPDATE stock_info
							  SET stock_status = 'stocked' 
							  WHERE stock_id = ".$stock_id." 
							  AND stock_status = 'listed'
							  AND listed_by = ".$creator." ");
		$this -> db -> query("UPDATE bulk_stock_info SET stock_amount = stock_amount + 1 WHERE bulk_stock_info.product_id = ".$pro_id." ");
	 }
	 /* delate bulk product */
	 function delete_a_bulk_product($product_id)
	 {
	 	$creator = $this->tank_auth->get_user_id();	
	 	$main = $this -> db -> select('*')
	 							-> from('bulk_stock_info')
	 							-> where('bulk_stock_info.product_id = "'.$product_id.'"')
	 							-> get();
	 	foreach($main -> result() as $m):
	 			$m_quantity = $m -> stock_amount;
	 			$m_amount = $m -> bulk_unit_buy_price;
	 	endforeach;
	 	$temp = $this -> db -> select('*')
	 							-> from('bulk_sale_temp')
	 							-> where('bulk_sale_temp.product_id = "'.$product_id.'"')
								-> where('bulk_sale_temp.bulk_sale_creator = "'.$creator.'"')								
	 							-> get();
								
	 	foreach($temp -> result() as $t):
	 			$t_quantity = $t-> bulk_sale_quantity;
				$t_amount = $t -> unit_buy_price;
	 	endforeach;
	 	
			$f_quantity = $t_quantity + $m_quantity;
	 		$f_amount = (($t_amount * $t_quantity) + ($m_amount * $m_quantity))  /  $f_quantity;
	 		$this -> db -> query("UPDATE bulk_stock_info SET stock_amount = ".$f_quantity.", 
										bulk_unit_buy_price = ".$f_amount." WHERE product_id = ".$product_id." ");
			$this -> db -> query("DELETE  FROM bulk_sale_temp WHERE product_id = ".$product_id."
									AND bulk_sale_creator = ".$creator."");
	 }  /* END of DELETE SINGLE BULK PRODUCT*/
	 
	 /* to make all product_name onclick change */
	 function product_name_onlick()
	 {
	    $this->db->order_by("product_name", "asc");
		$query = $this -> db -> get('product_info');
		$data[''] =  'Select a Product';
		foreach ($query -> result() as $field)
		{
			    //$temp = preg_replace('/\s+/', '~',$field->product_name);
				//$temp = $field->product_name;
				 $data[base_url().'index.php/sale_controller/sale/'.$field->product_id] = $field -> product_name;
				//$data[$field -> product_id] = $field -> product_name;
		}
		return $data;	
	 }
	 
	 /* to get product quantity of a specific product by product_id*/
	 function fatch_specific_pro_quantity($pro_id)
	 {
	 	
		$query = $this -> db -> select('stock_amount')
							  -> from('bulk_stock_info')							  
							  -> where('bulk_stock_info.product_id = '.$pro_id.'')
							  //-> where('bulk_sale_creator = '.$this->tank_auth->get_user_id().'')
							  -> get();
		$data = 0;
		foreach ($query -> result() as $field)
		{
			     $data += $field->stock_amount;
				 
		}
		return $data;	
	 }
	 /* to get all stock_id which status is stocked*/
	 function fatch_all_stock_id($selected_product_id)
	 {
		/*
	 	$query = $this -> db -> select('stock_id')
							  -> from('stock_info,purchase_info')
							   -> where('stock_info.purchase_id = purchase_info.purchase_id')
							   -> where('purchase_info.product_id = '.$productid.'')
							  -> where('stock_status = "stocked"')
							  -> or_where('stock_status = "returned"')
							  -> get();
		*/
		$query = $this -> db -> query("SELECT stock_id
									   FROM stock_info,purchase_info
									   WHERE product_id = '".$selected_product_id."' 
									   AND stock_info.purchase_id = purchase_info.purchase_id
									   AND (stock_status = 'returned'
									   OR stock_status = 'stocked')");
		if($query -> num_rows() > 0 )
		{
			foreach ($query -> result() as $field)
			{
				 $temp = $field->stock_id;
			     $data[$field -> stock_id] = $field -> stock_id;
			}
			return $data;	
		}
		
							  
	 }
	 
	 /* to update stock_amount by specific product id*/
	 /*  when  bulk stock_amount - quantity */
	 function update_stock_amount($product_id)
	 {
		 $product_quantity = $this -> input -> post('product_quantity'); 
	     $this -> db -> query("UPDATE bulk_stock_info SET stock_amount = stock_amount - ".$product_quantity."  WHERE product_id = ".$product_id." ");
	 }
	 
	 /* to update stock_amount by specific product id*/
	 /*  when  bulk stock_amount + quantity */
     function update_bulk_stock_amount( $pro_id , $bulk_pro_quantity )
     {
     	 $this -> db -> query("UPDATE bulk_stock_info SET stock_amount = stock_amount + ".$bulk_pro_quantity."  WHERE product_id = ".$pro_id." ");
		 $this -> db -> query("DELETE  FROM bulk_sale_temp WHERE product_id = ".$pro_id."
									AND bulk_sale_creator = ".$this->tank_auth->get_user_id()."");
     }
   
   
     /* to get unit_sale_price & unit_buy_price of a specific product*/
	 function get_usp_ubp($pr_idd)
	 {
		$creator = $this->tank_auth->get_user_id();
		$temp = $this ->sale_running_mode( $creator) ;
		if($temp == 'whole_sale') $field = 'whole_sale_price';
		else //if($temp == 'retail_sale')
		 $field = 'unit_sale_price';	
	 	$query = $this -> db -> select('bulk_stock_info.bulk_unit_buy_price,  sale_price_info.'.$field.' AS unit_sale_price , bulk_stock_info.stock_amount')
							 -> from('bulk_stock_info,sale_price_info')
							 -> where('bulk_stock_info.product_id = sale_price_info.product_id')
							 -> where('bulk_stock_info.product_id = "'.$pr_idd.'"')
							  -> get();							  
		return $query;	
	 }
	 
	 /* to update bulk_sale_temp table */
	 function update_bulk_sale_temp($pr_idd,$unit_sp,$unit_bp)
	 {
	 	$product_quantity = $this -> input -> post('product_quantity');
		$creator = $this->tank_auth->get_user_id();	
		
		/* bulk product exists or not*/
		
		$check_availability = $this -> db -> select('product_id,bulk_sale_quantity')
		                                  -> from('bulk_sale_temp')
		                                  -> where('bulk_sale_temp.product_id = '.$pr_idd.'')
										  -> where('bulk_sale_temp.bulk_sale_creator = '.$creator.'')
										  -> get();
		if($check_availability -> num_rows() >0)
		{
			foreach($check_availability -> result() as $field):
			   $quanitiy = $field->bulk_sale_quantity;
			endforeach;		
			$product_quantity += $quanitiy;
			
			$this -> db -> query("UPDATE bulk_sale_temp 
			                      SET bulk_sale_quantity = ".$product_quantity."
		                   		  WHERE bulk_sale_temp.product_id = ".$pr_idd." 
								  AND bulk_sale_creator = ".$creator."");                    
		}
		else
	    {
			$new_bulk_sale_temp_insert_data = array(
	
				'bulk_sale_creator' => $creator,
				'product_id ' => $pr_idd,
				'bulk_sale_quantity' => $product_quantity,
				'unit_sale_price' => $unit_sp,
				'unit_buy_price' => $unit_bp

		   ); 
		   $insert = $this -> db -> insert('bulk_sale_temp',  $new_bulk_sale_temp_insert_data);	
		}		

	 }

     /* update stock amount for individual product for a specific product*/
     function update_stk_amount($pro_id)
	 {
	 	$this -> db -> query("UPDATE bulk_stock_info SET stock_amount = stock_amount - 1 WHERE bulk_stock_info.product_id = ".$pro_id." ");
	 }
	 /* fatch a specific product_name by product_id*/
	 function fatch_product_name($pro_id)
	 {
	 	//echo $pro_id;
	 	$query = $this ->db -> select('*')
		                    -> from('product_info')
							-> where('product_info.product_id = "'.$pro_id.'"')
							-> get();
		return $query;					
	 }
	  /* fatch price of a specific product */
	 function fatch_product_price($product_id)
	 {
		 $query = $this -> db -> select('unit_sale_price')
							  -> from('sale_price_info')
							  -> where('sale_price_info.product_id = "'.$product_id.'"')
							  -> get();
		return $query;
	 }
	 
	 
	 /* fatch all individual product's information while canceling sale*/
	 function by_product_code_result_fatch_individual()
     {
     	$creator = $this->tank_auth->get_user_id();	
     	$query = $this ->db -> select('stock_info.stock_id, stock_info.purchase_id,stock_info.stock_status, bulk_stock_info.product_id, bulk_stock_info.stock_amount')
		                    -> from('stock_info, bulk_stock_info, purchase_info, product_info')
							-> where('stock_info.purchase_id = purchase_info.purchase_id')
							-> where('product_info.product_id = purchase_info.product_id')
							-> where('purchase_info.product_id = bulk_stock_info.product_id')
							-> where('stock_info.stock_status =  "listed"')
							-> where('stock_info.listed_by = "'.$creator.'" ')
		                    -> get();
	   return $query;
     }	 
	 
     function individual_stock_status_update($stock_individual)
	 {
	 	$creator = $this->tank_auth->get_user_id();	
	 	foreach($stock_individual -> result() as $field)
	 	{
	 		$t_stk_amount = $field -> stock_amount;
	 		$t_pro_id = $field -> product_id;
			
	 		$query = $this -> db -> select('*')
	 							-> from('bulk_stock_info')
	 							-> where('bulk_stock_info.product_id = "'.$t_pro_id.'"')
	 							-> get();
	 		
	 		foreach($query -> result() as $m):
	 			$this -> db -> query("UPDATE bulk_stock_info SET stock_amount = stock_amount + 1
								  WHERE product_id = ".$t_pro_id." ");
					
	 		endforeach;
			$this -> db -> query("UPDATE stock_info SET stock_status ='stocked'
			                          WHERE stock_status = 'listed'
			                          AND listed_by = '".$creator."' ");
		}
	 }
	 
     function sale_price_exists_or_not($product_id)
	 {
		 $creator = $this->tank_auth->get_user_id();
		$temp = $this ->sale_running_mode( $creator) ;
		if($temp == 'whole_sale') $field = 'whole_sale_price';
		else //if($temp == 'retail_sale')
		 $field = 'unit_sale_price';	
	 	$query = $this -> db -> select($field)
		            -> from('sale_price_info')
					-> where('sale_price_info.product_id = "'.$product_id.'"')
		            -> get();
		            $temp = 0;
		            foreach( $query -> result() as $t):
						$temp= $t-> $field;
		            endforeach;
		            if( $temp ) return true;
		            else return false; 
		//return $data = $query -> num_rows();	
	 }
  
  
 	/****************************
	 *  Create INVOICE for a Sale 
	 * it will return the Invoice id;
	****************************/
	function create_invoice($customer_id)
	{
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date = date('Y-m-d');
		$shop_id = $this -> tank_auth -> get_shop_id();
		$total_sale_price = $this -> input -> post('total_sale_price');
		$amount_paid = $this -> input -> post('amount_paid');
		$discount = $this -> input -> post('discount');
	    $grand_total_price = $this -> input -> post('grand_total_price');
		$discount_amount = $this -> input -> post('discount_amount');
		$discount_type = $this -> input -> post('discount_type');
		$cash_commision = $this -> input -> post('cash_commision');
		$return_money = $this -> input -> post('return_money');
		$creator = $this->tank_auth->get_user_id();	
		if( $amount_paid >= $grand_total_price) $amount_paid = $grand_total_price;
		$new_invoice_insert_data = array(
			'shop_id' => $shop_id,
			'customer_id' => $customer_id,
			'total_price' => $total_sale_price,
			'total_paid' => $amount_paid,
			'payment_mode'=> 'cash',
			'discount' => $discount,
			'discount_type' => $discount_type,
			'cash_commision' => $cash_commision,
			'discount_amount' => $discount_amount,
			'grand_total' => $grand_total_price,
			'return_money' => $return_money,
			'invoice_creator' => $creator,
			'invoice_doc' => $bd_date,
			'invoice_dom' => $bd_date
		);
		$insert = $this -> db -> insert('invoice_info', $new_invoice_insert_data);
		
		/* this will insert the following data to transaction_ref_details table */
		$ref_id= $this -> db -> insert_id();
		$new_transaction_ref_details_insert_data = array(
			'ref_id' => $ref_id ,
			'transaction_amount' => $amount_paid,
			'transaction_type' => 'in',
			'transaction_purpose' =>'sale',
			'transaction_table_ref_name' => 'invoice_info',
			'transaction_table_ref_id_field' => 'invoice_id',
			'transaction_ref_details_doc' => $bd_date,
			'transaction_ref_details_dom' => $bd_date,
			'transaction_ref_details_creator' => $creator
		);	
	    $this -> db -> insert('transaction_ref_details',$new_transaction_ref_details_insert_data);
		/* end of transaction_ref_details table */
		$new_transaction_details_insert_data = array(
			'transaction_reference_id' => $this -> db -> insert_id(),
			'shop_id' => $shop_id,
			'transaction_amount' => $amount_paid,
			'transaction_type' =>'in',
			'transaction_mode' => 'cash',
			'transaction_doc' => $bd_date,
			'transaction_dom' => $bd_date,
			'transaction_creator' => $creator
		);	
	    $insert = $this -> db -> insert('transaction_details',$new_transaction_details_insert_data);
		return $ref_id;
	}
	
	
	
 	/****************************
	 *  Create INVOICE for a Quick Sale  BY KAWSAR AHMED
	 * it will return the Invoice id;
	****************************/
	function create_invoice_for_quick_sale($customer_id,$point_id,$total_sale_price,$show_discount,$grand_total_price)
	{
	
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date = date('Y-m-d');
		$shop_id = $this -> tank_auth -> get_shop_id();
		$amount_paid = $this -> input -> post('amount_paid');
		$final_amount_discount = 0;
		$creator = $this->tank_auth->get_user_id();	
		$amount_paid = $grand_total_price;
		$new_invoice_insert_data = array(
			'shop_id' => $shop_id,
			'customer_id' => $customer_id,
			'total_price' => $total_sale_price,
			'total_paid' => $amount_paid,
			'payment_mode'=> 'cash',
			'discount' => $show_discount,
			'grand_total' => $grand_total_price,
			'return_money' => 0,
			'invoice_creator' => $creator,
			'invoice_doc' => $bd_date,
			'invoice_dom' => $bd_date,
			'point_info_id' => $point_id,
			'current_point' => 0,
			'point_discount'=>$final_amount_discount
			
		);
		$insert = $this -> db -> insert('invoice_info', $new_invoice_insert_data);
		
		/* this will insert the following data to transaction_ref_details table */
		$ref_id= $this -> db -> insert_id();
		$new_transaction_ref_details_insert_data = array(
			'ref_id' => $ref_id ,
			'transaction_amount' => $amount_paid,
			'transaction_type' => 'in',
			'transaction_purpose' =>'sale',
			'transaction_table_ref_name' => 'invoice_info',
			'transaction_table_ref_id_field' => 'invoice_id',
			'transaction_ref_details_doc' => $bd_date,
			'transaction_ref_details_dom' => $bd_date,
			'transaction_ref_details_creator' => $creator
		);	
	    $this -> db -> insert('transaction_ref_details',$new_transaction_ref_details_insert_data);
		/* end of transaction_ref_details table */
		$new_transaction_details_insert_data = array(
			'transaction_reference_id' => $this -> db -> insert_id(),
			'shop_id' => $shop_id,
			'transaction_amount' => $amount_paid,
			'transaction_type' =>'in',
			'transaction_mode' => 'cash',
			'transaction_doc' => $bd_date,
			'transaction_dom' => $bd_date,
			'transaction_creator' => $creator
		);	
	    $insert = $this -> db -> insert('transaction_details',$new_transaction_details_insert_data);
		return $ref_id;
	}
	
 	/****************************
	 *  Create INVOICE for a Confirm With Details Sale  BY KAWSAR AHMED
	 * it will return the Invoice id;
	****************************/
	function create_invoice_for_confirm_with_details($customer_id,$point_id,$total_sale_price,$show_discount,$grand_total_price)
	{
	
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date = date('Y-m-d');
		$shop_id = $this -> tank_auth -> get_shop_id();
		$amount_paid = $this -> input -> post('amount_paid');
		
		$grand_total_price = $this->uri->segment(7);
		$discount_amount = $this->uri->segment(3);//$this -> input -> post('final_amount_discount');
		$discount_type = $this->uri->segment(4);//$this -> input -> post('discount_type');
		$cash_commision = $this->uri->segment(5);//$this -> input -> post('cash_commision');
		$return_money = $this->uri->segment(6);//$this -> input -> post('cash_commision');
		if($grand_total_price == 'mm'){$grand_total_price = 0;}
		if($discount_amount == 'mm'){$discount_amount = 0;}
		if($discount_type == 'mm'){$discount_type = 0;}
		if($return_money == 'mm'){$return_money = 0;}
		
		$final_amount_discount = 0;
		$creator = $this->tank_auth->get_user_id();	
		$amount_paid = $grand_total_price;
		$new_invoice_insert_data = array(
			'shop_id' => $shop_id,
			'customer_id' => $customer_id,
			'total_price' => $total_sale_price,
			'total_paid' => $grand_total_price,
			'payment_mode'=> 'cash',
			'discount' => $show_discount,
			'discount_type' => $discount_type,
			'cash_commision' => $cash_commision,
			'discount_amount' => $discount_amount,
			'grand_total' => $grand_total_price,
			'return_money' => $return_money,
			'invoice_creator' => $creator,
			'invoice_doc' => $bd_date,
			'invoice_dom' => $bd_date,
			'point_info_id' => $point_id,
			'current_point' => 0,
			'point_discount'=>$final_amount_discount
			
		);
		$insert = $this -> db -> insert('invoice_info', $new_invoice_insert_data);
		
		/* this will insert the following data to transaction_ref_details table */
		$ref_id= $this -> db -> insert_id();
		$new_transaction_ref_details_insert_data = array(
			'ref_id' => $ref_id ,
			'transaction_amount' => $grand_total_price,
			'transaction_type' => 'in',
			'transaction_purpose' =>'sale',
			'transaction_table_ref_name' => 'invoice_info',
			'transaction_table_ref_id_field' => 'invoice_id',
			'transaction_ref_details_doc' => $bd_date,
			'transaction_ref_details_dom' => $bd_date,
			'transaction_ref_details_creator' => $creator
		);	
	    $this -> db -> insert('transaction_ref_details',$new_transaction_ref_details_insert_data);
		/* end of transaction_ref_details table */
		$new_transaction_details_insert_data = array(
			'transaction_reference_id' => $this -> db -> insert_id(),
			'shop_id' => $shop_id,
			'transaction_amount' => $grand_total_price,
			'transaction_type' =>'in',
			'transaction_mode' => 'cash',
			'transaction_doc' => $bd_date,
			'transaction_dom' => $bd_date,
			'transaction_creator' => $creator
		);	
	    $insert = $this -> db -> insert('transaction_details',$new_transaction_details_insert_data);
		return $ref_id;
	}
	/***********************************
	 *  Create Sale Details Of  an Invoice
	 * *********************************/
	function create_sale_details($invoice_id  , $sale_stock , $sale_bulk, $discount, $total_buy_price, $total_sale_price, $grand_total_price, $show_discount)
	{
		$creator = $this->tank_auth->get_user_id();
		$currrent_temp_sale_id = $this -> tank_auth -> get_current_temp_sale();
	    $total_profit = ( $total_sale_price - $total_buy_price ) ;
	    $discount =  $show_discount / $total_profit ;

		/* Updating Individual Amount */
		foreach($sale_stock -> result() as $field):
			$new_sale_details_insert = array(
				'invoice_id' => $invoice_id,
				'unit_sale_price' => $field -> unit_sale_price,
				'exact_sale_price' => $field -> unit_sale_price - (($field -> unit_sale_price - $field -> unit_buy_price) * $discount ) ,// $field -> unit_buy_price + (( $field -> unit_buy_price) * $profit),
				'unit_buy_price' => $field -> unit_buy_price,
				'stock_id' => $field -> stock_id,
				'product_specification' => 'individual'
			);
			$this -> db -> insert('sale_details', $new_sale_details_insert);
			$this -> db -> query("UPDATE stock_info
								  SET stock_status = 'sold' 
								  WHERE stock_id = ".$field -> stock_id." 
								  AND stock_status = 'listed'
								  AND listed_by = ".$creator." ");
		endforeach;
		
		/* Updating Bulk Amount */
		foreach($sale_bulk -> result() as $field):
			for($i = 0 ; $i < $field -> bulk_sale_quantity; $i++)
			{
				$new_sale_details_insert = array(
					'invoice_id' => $invoice_id,
					'unit_sale_price' => $field -> unit_sale_price,
					'exact_sale_price' => $field -> unit_sale_price - (($field -> unit_sale_price - $field -> unit_buy_price) * $discount ),//+ (( $field -> unit_buy_price) * $profit),
					'unit_buy_price' => $field -> unit_buy_price,
					'stock_id' => $field -> product_id,
					'product_specification' => 'bulk'
				);
				$this -> db -> insert('sale_details', $new_sale_details_insert);
			}
			/*********** For Previous Dokani before VissionExpress *****/
			/*
			$this -> db -> query("DELETE  FROM bulk_sale_temp WHERE product_id = ".$field -> product_id."
									AND bulk_sale_creator = ".$creator."");
			*/
			/*********** END OF For Previous Dokani before VissionExpress *****/
			
			/******** vision Express 09-12-2013 ********/
			$this -> db -> query("DELETE  FROM temp_sale_details WHERE product_id = ".$field -> product_id."
									AND temp_sale_id = ".$currrent_temp_sale_id."");
			/******** end vision Express 09-12-2013 ********/
		endforeach;
		$this -> db -> query("DELETE  FROM temp_sale_info
								  WHERE temp_sale_id = ".$currrent_temp_sale_id."");
		return true;
	}
	/***********************************
	 *  Create Sale Details Of  an Invoice
	 * *********************************/
	function create_sale_details_cash_carry($invoice_id  , $all_listed_products )
	{
		$creator = $this->tank_auth->get_user_id();
		$currrent_temp_sale_id = $this -> tank_auth -> get_current_temp_sale();
	   
		foreach ($all_listed_products -> result() as $field):
		$exact_sale_price= $field -> actual_sale_price *  $field -> sale_quantity;
				$new_sale_details_insert = array(
				'invoice_id' => $invoice_id,
				'product_id' => $field -> product_id,
				'sale_quantity' => $field -> sale_quantity,
				'unit_sale_price' => $field -> unit_sale_price,
				'actual_sale_price' => $field -> actual_sale_price,
				'general_sale_price' => $field -> general_unit_sale_price,
				'unit_buy_price' => $field -> unit_buy_price,
				'stock_id' => $field -> stock_id,
				'product_specification' => $field -> product_specification,
				'sale_type' => $field -> sale_type,
				'exact_sale_price' => $exact_sale_price,
			    'discount_info_id' => $field -> discount_info_id,
			    'discount' => $field -> discount,
			    'discount_type' => $field -> discount_type,
			    'sale_details_status' => 1
			);
			$this -> db -> insert('sale_details', $new_sale_details_insert);
			if($field -> product_specification == 'individual')
				$this -> db -> query("UPDATE stock_info
									  SET stock_status = 'sold' 
									  WHERE stock_id = ".$field -> stock_id." 
									  AND stock_status = 'listed'
									  AND listed_by = ".$creator." ");
			
			$this -> db -> query("DELETE  FROM temp_sale_details
								  WHERE product_id = ".$field -> product_id."
								  AND temp_sale_details_id = ".$field -> temp_sale_details_id."");
				
		endforeach;						  
		
		$this -> db -> query("DELETE  FROM temp_sale_info
								  WHERE temp_sale_id = ".$currrent_temp_sale_id."");
		return true;
	}
	/**************************************************************
	 * this is a special insert function for registering a customer
	 * 
	 * 
	 * Section : Registration
	 *********************************************************** */
	function create_new_customer_sale_isrunning($customer_name,$customer_contact_no,$customer_address){
		$timezone = "Asia/Dhaka";
		date_default_timezone_set($timezone);
		$bd_date = date('Y-m-d');
		$creator = $this->tank_auth->get_user_id();	
		
		$new_customer_insert_data = array(
			'customer_name' => $customer_name,
			'customer_address' => $customer_address,
			'customer_contact_no' => $customer_contact_no,
			'customer_type' => 'Individual',
			'customer_mode' => 'normal',
			'customer_email' => 'NA',
			'customer_creator' => $creator,
			'customer_doc' => $bd_date,
			'customer_dom' => $bd_date
		);
		$insert = $this -> db -> insert('customer_info', $new_customer_insert_data);
		return $this -> db -> insert_id();
	}
	/****************************
	 * Sale System for Cash Carry
	 * Cancle A My Sale 
	 * 30-06-2014
	 * Arafat Mamun
	*****************************/
	function stockProductDetails($stockId){
		$this -> db -> select('*');			   
		$this -> db -> from('stock_info,product_info,bulk_stock_info');
		$this -> db -> where('stock_info.product_id = product_info.product_id');
		$this -> db -> where('product_info.product_id = bulk_stock_info.product_id');
		$this -> db -> where('stock_info.stock_id', $stockId);
		$this -> db -> where('bulk_stock_info.shop_id', $this -> shop_id);
		return $this -> db -> get();
	}
	/****************************
	 * Sale System for Cash Carry
	 * Cancle A My Sale 
	 * 30-06-2014
	 * Arafat Mamun
	*****************************/
	function individualProductStock($productId){
		return $this -> db -> query("SELECT *
									FROM stock_info
									WHERE product_id = ".$productId."
									AND  shop_id = ".$this -> shop_id."
									AND (stock_status = 'returned'
										 OR stock_status = 'stocked')");
	}

	function individualProductStock_barcode($barcode){
		return $this -> db -> query("SELECT *
									FROM stock_info , product_info
									WHERE product_info.barcode = '".$barcode."'
									AND  shop_id = ".$this -> shop_id."
									AND product_info.product_id=stock_info.product_id
									AND (stock_status = 'returned'
										 OR stock_status = 'stocked')");
	}

	function point_equal(){
		$shop_id=$this->tank_auth->get_shop_id();
		$this->db->select('one_point_equal,one_taka_equal');
		$this->db->from('shop_setup');
		$this->db->where('shop_id',$shop_id);
		$query=$this->db->get();
		$row=$query->row_array();
		return $row;
	}
	
	function add_point($customer_id){
        $this->db->select('*');
		$this->db->from('point_info');
		$this->db->where('customer_id',$customer_id);
		$query=$this->db->get();
    	if($query->num_rows>0){
    		$row=$query->row_array();
    		//$total_point=$row['total_point']+$this->input->post('total_point');
    		$total_point=$this->input->post('total_point');
    		//$withdraw_point=$row['withdraw_point']+$this->input->post('final_point');
    		$withdraw_point=$this->input->post('final_point');
    		$remain_point = $total_point - $withdraw_point;
    		$data=array('total_point' =>$total_point,
    					'withdraw_point' =>$withdraw_point,
    					'remain_point' => $remain_point);
    		$this->db->where('customer_id',$customer_id);
    		$this->db->update('point_info',$data);
    		
    		return $row['point_id'];
    	}
    	else {
        	$remain_point=$this->input->post('total_point')-$this->input->post('final_point');
            $data=array(
        		'customer_id'=>$this->input->post('customer_id'),
        		'total_point'=>$this->input->post('total_point'),
        		'withdraw_point'=>$this->input->post('final_point'),
        		'remain_point'=>$remain_point
        	);
        	$this->db->insert('point_info',$data);    
        	return $this -> db -> insert_id();
        }
    }

    function remain_point($customer_id){
    	$this->db->select('*');
    	$this->db->from('point_info');
    	$this->db->where('customer_id',$customer_id);
    	$query=$this->db->get();
    	if($query->num_rows >0){
    		$row=$query->row_array();
    		return $row;
    	}
    	else return 0;
    }
}