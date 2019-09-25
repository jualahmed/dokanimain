<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sale_model extends CI_model{
	private $shop_id;
	private $currentUser;
	function __construct()
	{
        $this->shop_id        = $this->tank_auth->get_shop_id();
		$this->currentUser    = $this->tank_auth->get_user_id();
	}

    public function createNewSale($current_user, $current_shop)
    {
        $data = array(
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

    public function search_product($query){
        return $this->db->query("SELECT * FROM product_info INNER JOIN catagory_info ON catagory_info.catagory_id = product_info.catagory_id INNER JOIN company_info ON company_info.company_id = product_info.company_id INNER JOIN bulk_stock_info ON bulk_stock_info.product_id = product_info.product_id WHERE (product_info.product_warranty=0) AND (`product_name` RLIKE +'$query' OR `product_name` LIKE '$query%')")->result();
    }

    public function search_warranty_product_and_add_to_my_list($serial_no)
    {
        $this->db->select('catagory_info.*,company_info.*,product_info.*,warranty_product_list.*, bulk_stock_info.bulk_unit_buy_price, bulk_stock_info.general_unit_sale_price, bulk_stock_info.general_unit_sale_price,bulk_stock_info.bulk_unit_sale_price,bulk_stock_info.stock_amount');
        $this->db->join('product_info', "product_info.product_id = warranty_product_list.product_id");
        $this->db->join('bulk_stock_info', 'product_info.product_id = bulk_stock_info.product_id');
        $this->db->join('catagory_info', 'catagory_info.catagory_id = product_info.catagory_id');
        $this->db->join('company_info', 'company_info.company_id = product_info.company_id');
        $this->db->where('warranty_product_list.status',1);
        $this->db->like('warranty_product_list.sl_no', $serial_no);
        return $query = $this->db->get('warranty_product_list')->result();
    }

    public function get_product_by_barcode_for_sale_return($barcode)
    {
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
                
    public function updateStock($pro_id, $updated_stock){
        $this->db->where('product_id', $pro_id);
        $this->db->update('bulk_stock_info', array('stock_amount' => $updated_stock));
    }

	public function change_sale_quantity2(){
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

    public function addProductToSale($product_id, $product_name, $sale_price, $mrp_price, $buy_price, $product_specification, $sale_quantity,$product_stock, $currrent_temp_sale_id)
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

	public function get_current_sale_customer($current_sale){
        $this->db->select('customer_info.customer_id,customer_info.customer_name,customer_info.customer_contact_no');
        $this->db->from('customer_info,temp_sale_info');
        $this->db->where('customer_info.customer_id=temp_sale_info.temp_customer_id');
        $this->db->where('temp_sale_info.temp_sale_id',$current_sale);
        $data =$this->db->get();            
        return $data;
    }

    public function getAllTmpProduct($currrent_temp_sale_id){
        $data = $this->db->select('temp_sale_details.*,product_info.product_size,product_info.product_model')
                        ->from('temp_sale_details,product_info')
                        ->where('temp_sale_details.product_id = product_info.product_id')
                        ->where('temp_sale_id', $currrent_temp_sale_id)
                        ->get();
        if($data->num_rows() > 0)return $data;
        else return FALSE;
    }

	public function getAllTmpProduct_warranty($currrent_temp_sale_id){
        $data = $this->db->select('*')
                        ->from('warranty_product_list')
                        ->where('invoice_id', $currrent_temp_sale_id)
                        ->get();
        if($data->num_rows() > 0)return $data;
        else return FALSE;
    }

    public function getReturnId($tmp_sale_id)
    {
        $data = $this->db->select('return_id')->where('temp_sale_id', $tmp_sale_id)->get('temp_sale_info');
        if($data->num_rows() > 0)
		{
            $row_data = $data->row();
            return $row_data->return_id;
        }
        else return 0;
    }  

	public function getReturnAdjustAmount($tmp_sale_id)
    {
        $data = $this->db->select('return_adjust_amount')->where('temp_sale_id', $tmp_sale_id)->get('temp_sale_info');
        if($data->num_rows() > 0)
		{
            $row_data = $data->row();
            return $row_data->return_adjust_amount;
        }
        else return 0;
    }  

    public function doInvoiceInfoTask($customer_id,$sub_total,$cash_commision,$disc_amt,$disc_type,$grand_total,$total_paid,$return_money, $return_adjust,$payable,$delivery_charge)
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
	
	public function doInvoiceInfoTask_credit($customer_id,$sub_total,$cash_commision,$disc_amt,$disc_type,$grand_total,$total_paid,$return_money, $return_adjust,$payable,$delivery_charge)
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

	public function doSaleDetailsTask($invoice_id,$products,$cash_commision,$disc_amount, $discount_type)
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
        
	public function transactioninfo_cashbook($invoice_id,$customer_id, $grand_total, $total_paid,$return_adjust,$payable,$return_id,$delivery_charge)
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
	public function transactioninfo_creditsale($invoice_id,$customer_id, $grand_total,$return_adjust,$return_id,$delivery_charge)
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
	public function doInvoiceInfoTask_card($customer_id,$sub_total,$cash_commision,$disc_amt,$disc_type,$grand_total,$total_paid,$return_money, $return_adjust,$payable)
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

	public function transactioninfo_cardsale($invoice_id,$customer_id, $grand_total,$total_paid, $bank_id,$card_id,$return_adjust,$payable,$return_id,$delivery_charge)
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
    public function deleteDataFromTmpSaleInfoAndTmpSaleDetails($currrent_temp_sale_id, $current_sale_return_id, $creator)
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
        
    public function cancelSale($currrent_temp_sale_id, $creator)
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
    }

	public function cancelcashSalereturn()
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

    public function getSoldProducts($invoice_id)
    {
         $data   =  $this->db
                ->select('product_info.product_name,product_info.product_specification,product_info.unit_id,product_info.product_size,product_info.product_model,product_info.product_warranty, sale_details.sale_quantity, sale_details.general_sale_price,sale_details.actual_sale_price,sale_details.unit_sale_price,sale_details.exact_sale_price,sale_details.unit_buy_price, invoice_info.total_price, invoice_info.delivery_charge,invoice_info.discount_amount, invoice_info.discount_type, invoice_info.total_paid, invoice_info.cash_commision, invoice_info.grand_total, invoice_info.sale_return_amount, invoice_info.return_money, invoice_info.invoice_doc, 
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

    public function getSoldProducts_warranty($invoice_id)
    {
    	$data2   =  $this->db
                ->select('product_id')
                ->from('sale_details')
                ->where('sale_details.invoice_id', $invoice_id)
                ->where('sale_details.product_specification', 2)
    			->order_by('sale_details.product_id','asc')
                ->get();
    	$i = 1;
    	$serial = '';
    	foreach($data2->result() as $tmp)
    	{
    		      $data  = $this->db
    				->select('sl_no,product_id')
    				->from('  warranty_product_list')
    				->where(' warranty_product_list.product_id',$tmp->product_id)
                    ->where(' warranty_product_list.invoice_id', $invoice_id)
    				->order_by('product_id','asc')
    				->get();
    		      if($data->num_rows() > 0){
    				$serial[$i] = $data->result();
    		      }
    		      $i++;
    	}
    	return $serial;
    }

	public function receipt_sale_total_amount($customer_id,$invoice_id)
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

	public function getreturnProducts($return_invoice_id)
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

    public function getAllSale($current_user, $current_shop)
    {
        $data = $this->db
                        ->select('temp_sale_id,temp_sale_type')
                        ->where('temp_sale_shop_id', $current_shop)
                        ->order_by('temp_sale_id', "asc")
                        ->get('temp_sale_info');

        if($data->num_rows() > 0) return $data;
        else return FALSE;
    }

	public function get_current_sale_invoice_status($current_sale)
    {
        $data = $this->db
                        ->select('*')
                        ->where('temp_sale_id', $current_sale)
                        ->where('pre_invoice_status = "pending"')
                        ->get('temp_sale_info');
        return $data;
    }
        
    public function updateTmpProduct($product_id, $new_qnty, $actual_price, $stock)
    {
        $data = array(
           'sale_quantity'      => $new_qnty,
           'stock'              => $stock
        );
        $this->db->where('product_id', $product_id);
        $this->db->update('temp_sale_details', $data);
    }

    public function createSaleReturn($tmp_sale_id, $creator, $shop_id, $bd_date)
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
		
	public function createSaleReturn_direct($tmp_sale_id, $creator, $shop_id, $bd_date)
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

	public function get_invoice_product_list($invoice)
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

	public function get_invoice_product_list2($invoice)
	{
		$this->db->select('product_info.product_name,sale_details.product_id,sale_details.exact_sale_price');
		$this->db->from('sale_details,product_info');
		$this->db->where('product_info.product_id = sale_details.product_id');
		$this->db->where('sale_details.invoice_id',$invoice);
		$this->db->group_by('sale_details.sale_details_id');
		$query = $this->db->get();
		return $query;
	}

	public function get_invoice_sale_amount($invoice)
	{
		$this->db->select('transaction_info.amount');
		$this->db->from('transaction_info');
		$this->db->where('transaction_info.transaction_purpose="sale"');
		$this->db->where('transaction_info.common_id',$invoice);
		$query = $this->db->get();
		return $query;
	}

	public function get_invoice_collection_amount($invoice)
	{
		$this->db->select('transaction_info.amount');
		$this->db->from('transaction_info');
		$this->db->where('transaction_info.transaction_purpose="collection"');
		$this->db->where('transaction_info.common_id',$invoice);
		$query = $this->db->get();
		return $query;
	}
	public function get_invoice_ledger_balance_amount($ledger_id)
	{
		$this->db->select('SUM(transaction_info.amount) as balance_amount,customer_info.customer_name,customer_info.customer_id');
		$this->db->from('transaction_info,customer_info');
		$this->db->where('transaction_info.ledger_id=customer_info.customer_id');
		$this->db->where('((transaction_info.transaction_purpose = "collection") OR (transaction_info.transaction_purpose = "credit_collection"))');
		$this->db->where('transaction_info.ledger_id',$ledger_id); 
		$query2 = $this->db->get();
		return $query2;
	}

	public function get_invoice_ledger_sale_amount($ledger_id)
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

	public function get_invoice_ledger_sale_return_amount($ledger_id)
	{
		$this->db->select('SUM(transaction_info.amount) as sale_retrun_amount');
		$this->db->from('transaction_info,customer_info');
		$this->db->where('transaction_info.ledger_id=customer_info.customer_id');
		$this->db->where('transaction_info.transaction_purpose = "sale_return"');
		$this->db->where('transaction_info.ledger_id',$ledger_id); 
		$query2 = $this->db->get();
		return $query2;
	}

	public function get_invoice_sale_return_amount($invoice)
	{
		$this->db->select('transaction_info.amount');
		$this->db->from('transaction_info');
		$this->db->where('transaction_info.transaction_purpose="sale_return"');
		$this->db->where('transaction_info.common_id',$invoice);
		$query = $this->db->get();
		return $query;
	}

	public function get_product_list()
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

	public function get_product_list2()
	{
		$product_id = $this->input->post('product_id');
		$this->db->select('product_info.product_name,bulk_stock_info.product_id,bulk_stock_info.general_unit_sale_price,bulk_stock_info.stock_amount');
		$this->db->from('bulk_stock_info,product_info');
		$this->db->where('product_info.product_id = bulk_stock_info.product_id');
		$this->db->where('bulk_stock_info.product_id',$product_id);
		$query = $this->db->get();
		return $query->row();
	}

	public function removeProduct($product_id, $currrent_temp_sale_id, $quantity)
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

	public function select_active_sale()
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
	
	public function new_active_sale_with_salereturn($return_amount)
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

 

    public function getAllSaleReturnProduct($sale_return_id, $tmp_sale_id)
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

    public function running_my_sales($current_user, $current_shop)
    {
        $this -> db -> order_by('temp_sale_id', "asc");
        $this -> db -> where('temp_sale_shop_id', $current_shop);
        $this -> db -> where('temp_sale_creator', $current_user);
        return $this -> db -> get('temp_sale_info');
    }

	public function my_sale_cancle( $currrent_temp_sale_id)
	{
		$creator = $this -> tank_auth -> get_user_id();
		
		$this -> db -> select('temp_sale_details_id,product_info.product_id,unit_buy_price,
							   unit_sale_price,temp_sale_info.temp_sale_id, sale_quantity,
							   temp_sale_details.product_specification, stock_id,
							   temp_sale_details_status');
							   
		$this -> db -> from('temp_sale_details,product_info,temp_sale_info');
		$this -> db -> where('temp_sale_info.temp_sale_id', $currrent_temp_sale_id);
		$this -> db -> where('temp_sale_info.temp_sale_id = temp_sale_details.temp_sale_id');
		$this -> db -> where('temp_sale_details.product_id = product_info.product_id');
		$query = $this -> db -> get();
		foreach($query -> result() as $field):
			if($field -> temp_sale_details_status == 1){
			$this -> db -> query("UPDATE bulk_stock_info
								  SET stock_amount = stock_amount + ".$field -> sale_quantity."
								  WHERE product_id = ".$field -> product_id."
								  AND  shop_id = ".$this -> shop_id." ");
			$this -> db -> query("DELETE  FROM temp_sale_details
								  WHERE product_id = ".$field -> product_id."
								  AND temp_sale_details_id = ".$field -> temp_sale_details_id."");
								  }
		endforeach;
		$this -> db -> query("DELETE  FROM temp_sale_info
							  WHERE temp_sale_id = ".$currrent_temp_sale_id."");
		return true;
	}
}