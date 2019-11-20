<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
class Salereturn extends MY_controller
{
	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id=$this->tank_auth->get_shop_id();
		$this->is_logged_in();
		$this->load->model('customer_model');
	}

	public function is_logged_in()
	{
		$this->load->library('tank_auth');
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login','refresh');
		}
	}
	
	public function cash_salereturn()
	{
		$data['user_type'] 	= $this->tank_auth->get_usertype();
		$data['user_name'] 	= $this->tank_auth->get_username();
		$data['customer_info'] 	= $this->customer_model->all();
		$data['product_info_warranty_details'] 	= '';
		$data['product_info_details'] 	= '';
		$data['return_main_product'] 	= $this->salereturn_model->sale_return_main_product();
		$i=1;
		foreach($data['return_main_product']->result() as $tmp)
		{
			$data['return_warranty_product'][$i] = $this->salereturn_model->return_warranty_product($tmp->produ_id);
			$i++;
		}
		$return_type = $this->uri->segment(3);
		$invoice_type = $this->uri->segment(4);
		$invoice_id = $this->uri->segment(5);
		$product_id = $this->uri->segment(6);
		if($return_type!='' || $invoice_type!='' || $invoice_id!='' || $product_id!='')
		{
			$data['product_info'] 	= $this->salereturn_model->product_info($invoice_id,$invoice_type);
			$data['product_info_details'] 	= $this->salereturn_model->product_info_details($invoice_id,$invoice_type,$product_id);
			$data['product_info_warranty_details'] 	= $this->salereturn_model->product_info_warranty_details($invoice_id,$invoice_type,$product_id);
		}
		$data['status'] 	= '';	
		$data['vuejscomp'] = 'cash_salereturn.js';
		$this->__renderview('Salereturn/cash_salereturn', $data);
	}

	public function list_cashsalereturn_temp_data()
	{
		$bd_date=date('Y-m-d');
		$creator = $this->tank_auth->get_user_id();
		$ip_id 			= $this->input->post('ip_ids');
		$ret_type 		= $this->input->post('ret_type');
		$in_type 		= $this->input->post('in_type');
		$pro_id 		= $this->input->post('pro_id');
		$inv_id 		= $this->input->post('inv_id');
		if($inv_id==''){
			$inv_id='null';
		}
		else{
			$inv_id=$inv_id;
		}
		$exact_price 	= $this->input->post('exact_price');
		$return_amount 	= $this->input->post('return_amount');
		
		if($ret_type=='product')
		{
			$type_name='productreturn';
		}
		else{
			$type_name='cashreturn';
		}
		if($ip_id!='')
		{
			$list_id=0;
			$this->db->select('*');
			$this->db->from('sale_return_list');
			$this->db->where('status=0');
			$query = $this->db->get();
			if($query->num_rows == 0)
			{
				$return_list = array(
				'total_amount' => 0,
				'type' => $type_name,
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
				);
				$this->db->insert('sale_return_list',$return_list);
				$list_id = $this->db->insert_id();
			}
			else
			{
				$tmp = $query->row();
				$list_id = $tmp->srl_id;
			}
			
			$main_data = array(
				'return_list_id' => $list_id,
				'inv_id' => $inv_id,
				'customer' => 0,
				'produ_id' => $pro_id,
				'return_quantity' => 0,
				'exact_price' => $exact_price,
				'status' => 0,
				'type' => $type_name,
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$this->db->insert('sale_return_main_product',$main_data);
			$insert_id = $this->db->insert_id();
			$i=1;
			foreach($ip_id as $ip)
			{
				$this->db->select('sl_no,warranty_period,invoice_id,sale_date,sale_price');
				$this->db->from('warranty_product_list');
				$this->db->where('ip_id',$ip);
				$query= $this->db->get();
				$tmp =$query->row();
				
				$warranty_data = array
				(
					'srmp_id' =>$insert_id,
					'ip_id' =>$ip,
					'product_id' =>$pro_id,
					'invoice_id' =>$tmp->invoice_id,
					'sl_no' =>$tmp->sl_no,
					'sale_date' =>$tmp->sale_date,
					'sale_price' =>$tmp->sale_price,
					'warranty_period' =>$tmp->warranty_period,
					'status' =>0,
					'creator' =>$creator,
					'doc' =>$bd_date,
					'dom' =>$bd_date
				);
				$this->db->insert('sale_return_warranty_product', $warranty_data);
				
				$this->db->set('return_quantity', 'return_quantity+' . 1, FALSE);
				$this->db->where('srmp_id', $insert_id);
				$this->db->update('sale_return_main_product');
				$i++;	
				
			}
			redirect('salereturn/cash_salereturn/'.$ret_type.'/'.$in_type.'/'.$inv_id);
		}
		else
		{
			$list_id=0;
			$this->db->select('*');
			$this->db->from('sale_return_list');
			$this->db->where('status=0');
			$query = $this->db->get();
			if($query->num_rows == 0)
			{
				$return_list = array(
				
				'total_amount' => 0,
				'type' => $type_name,
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
				);
				$this->db->insert('sale_return_list',$return_list);
				$list_id = $this->db->insert_id();
			}
			else
			{
				$tmp = $query->row();
				$list_id = $tmp->srl_id;
			}
			$main_data = array(
				
				'return_list_id' => $list_id,
				'inv_id' => $inv_id,
				'customer' => 0,
				'produ_id' => $pro_id,
				'return_quantity' => $return_amount,
				'exact_price' => $exact_price,
				'status' => 0,
				'type' => 'cashreturn',
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$this->db->insert('sale_return_main_product',$main_data);
			redirect('salereturn/cash_salereturn/'.$ret_type.'/'.$in_type.'/'.$inv_id);
		}
	}
	
	public function removeProduct()
	{
		$srmp_id = $this->input->post('srmp_id');
		$this->db->where('srmp_id', $srmp_id);
		$this->db->delete('sale_return_main_product'); 
		$this->db->where('srmp_id', $srmp_id);
		$this->db->delete('sale_return_warranty_product'); 
		echo json_encode(true);
	}

	public function get_customer_transaction() 
	{
		$customer_id = $this->input->post('customer_id');
		$invoice_ledgers_balance = array();
		$invoice_ledgers_sale = array();
		$invoice_ledgers_balance = $this->sale_model->get_invoice_ledger_balance_amount($customer_id);
		$invoice_ledgers_balance = $invoice_ledgers_balance->result_array();
		$invoice_ledgers_sale = $this->sale_model->get_invoice_ledger_sale_amount($customer_id);
		$invoice_ledgers_sale = $invoice_ledgers_sale->result_array();
		$invoice_ledgers_sale_return = $this->sale_model->get_invoice_ledger_sale_return_amount($customer_id);
		$invoice_ledgers_sale_return = $invoice_ledgers_sale_return->result_array();
		echo json_encode(array("balance"=>$invoice_ledgers_balance,"sale"=>$invoice_ledgers_sale,"sale_return"=>$invoice_ledgers_sale_return));
	}

	public function final_sale_return()
	{
		$bd_date=date('Y-m-d');
		$creator = $this->tank_auth->get_user_id();
		$customer_new = $this->input->post('customer_id');
		$in_type = $this->input->post('in_type');
		$in_id = $this->input->post('in_id');
		$re_type = $this->input->post('re_type');
		$return_adjustment_amount = $this->input->post('return_adjustment_amount');
		if($re_type=='productsale')
		{
			if($in_type=='yes')
			{
				$this->db->select('customer_id,total_paid');
				$this->db->from('invoice_info');
				$this->db->where('invoice_info.invoice_id',$in_id);
				$query = $this->db->get();
				$field = $query->row();
				$customer_id = $field->customer_id;
				$total_paid = $field->total_paid;
				
				if(($customer_new!='' || $customer_new!='0') && ($customer_id == $customer_new))
				{
					$zero = 0;
					$this->db->select('sale_return_main_product.*,SUM(return_quantity*exact_price) as total_return');
					$this->db->from('sale_return_main_product');
					$this->db->where('sale_return_main_product.status="'.$zero.'"');
					$query3 = $this->db->get();
					$tmp3 = $query3->row();
					$return_list_id = $tmp3->return_list_id;
					$total_return = $tmp3->total_return;
					
					$datareturn=array(
						'total_amount'=>$total_return,
						'return_adjustment'=>$return_adjustment_amount
					);
					$this->db->where('srl_id', $return_list_id);
					$this->db->update('sale_return_list',$datareturn);
						
					$this->db->select('*');
					$this->db->from('sale_return_main_product');
					$this->db->where('sale_return_main_product.status="'.$zero.'"');
					$query1 = $this->db->get();
					$i=1;
					foreach($query1->result() as $tmp1)
					{
						$this->db->set('stock_amount', 'stock_amount+' . $tmp1->return_quantity, FALSE);
						$this->db->where('product_id', $tmp1->produ_id);
						$this->db->update('bulk_stock_info');
						
						$data1=array(
							'customer'=>$customer_id,
							'status'=>1
						);
						$this->db->where('status="'.$zero.'"');
						$this->db->where('srmp_id', $tmp1->srmp_id);
						$this->db->where('produ_id', $tmp1->produ_id);
						$this->db->update('sale_return_main_product',$data1);
						 $i++;
					}

					$this->db->select('*');
					$this->db->from('sale_return_warranty_product');
					$this->db->where('sale_return_warranty_product.status="'.$zero.'"');
					$query2 = $this->db->get();
					
					if($query2->num_rows > 0)
					{
						$ii=1;
						foreach($query2->result() as $tmp2)
						{
							$data=array
							(
								'invoice_id'=>0,
								'sale_price'=>0,
								'sale_date'=>0000-00-00,
								'status'=>1
							);
							$this->db->where('warranty_product_list.ip_id',$tmp2->ip_id);
							$this->db->where('warranty_product_list.product_id',$tmp2->product_id);
							$this->db->update('warranty_product_list',$data);
							
							$this->db->set('status', 'status+' . 1, FALSE);
							$this->db->where('status="'.$zero.'"');
							$this->db->where('srwp_id', $tmp2->srwp_id);
							$this->db->where('srmp_id', $tmp2->srmp_id);
							$this->db->where('ip_id', $tmp2->ip_id);
							$this->db->where('product_id', $tmp2->product_id);
							$this->db->update('sale_return_warranty_product');
							$ii++;
						}
						
					}
					redirect('salereturn/cash_salereturn/null/null/null/null/success/'.$return_adjustment_amount.'/'.$return_list_id);

				}
				else
				{
					redirect('salereturn/cash_salereturn/'.$re_type.'/'.$in_type.'/'.$in_id.'/null/customer');
				}
			}
			else
			{
				if($customer_new!='' || $customer_new!='0')
				{
					$zero = 0;
					$this->db->select('sale_return_main_product.*,SUM(return_quantity*exact_price) as total_return');
					$this->db->from('sale_return_main_product');
					$this->db->where('sale_return_main_product.status="'.$zero.'"');
					$query3 = $this->db->get();
					$tmp3 = $query3->row();
					$return_list_id = $tmp3->return_list_id;
					$total_return = $tmp3->total_return;
					$datareturn=array(
						'total_amount'=>$total_return,
						'return_adjustment'=>$return_adjustment_amount
					);
					$this->db->where('srl_id', $return_list_id);
					$this->db->update('sale_return_list',$datareturn);
					
					$this->db->select('*');
					$this->db->from('sale_return_main_product');
					$this->db->where('sale_return_main_product.status="'.$zero.'"');
					$query1 = $this->db->get();
					$i=1;
					foreach($query1->result() as $tmp1)
					{
						$this->db->set('stock_amount', 'stock_amount+' . $tmp1->return_quantity, FALSE);
						$this->db->where('product_id', $tmp1->produ_id);
						$this->db->update('bulk_stock_info');
						
						$data1=array(
							'customer'=>$customer_new,
							'status'=>1
						);
						$this->db->where('status="'.$zero.'"');
						$this->db->where('srmp_id', $tmp1->srmp_id);
						$this->db->where('produ_id', $tmp1->produ_id);
						$this->db->update('sale_return_main_product',$data1);
						 $i++;
					}

					$this->db->select('*');
					$this->db->from('sale_return_warranty_product');
					$this->db->where('sale_return_warranty_product.status="'.$zero.'"');
					$query2 = $this->db->get();
					
					
					if($query2->num_rows > 0)
					{
						$ii=1;
						foreach($query2->result() as $tmp2)
						{
							$data=array
							(
								'invoice_id'=>0,
								'sale_price'=>0,
								'sale_date'=>0000-00-00,
								'status'=>1
							);
							$this->db->where('warranty_product_list.ip_id',$tmp2->ip_id);
							$this->db->where('warranty_product_list.product_id',$tmp2->product_id);
							$this->db->update('warranty_product_list',$data);
							
							$this->db->set('status', 'status+' . 1, FALSE);
							$this->db->where('status="'.$zero.'"');
							$this->db->where('srwp_id', $tmp2->srwp_id);
							$this->db->where('srmp_id', $tmp2->srmp_id);
							$this->db->where('ip_id', $tmp2->ip_id);
							$this->db->where('product_id', $tmp2->product_id);
							$this->db->update('sale_return_warranty_product');
							$ii++;
						}
						
					}
					redirect('salereturn/cash_salereturn/null/null/null/null/success/'.$return_adjustment_amount.'/'.$return_list_id);

				}
				else
				{
					redirect('salereturn/cash_salereturn/'.$re_type.'/'.$in_type.'/'.$in_id.'/null/customer');
				}
			}
		}
		else if($re_type=='cash')
		{
			if($in_type=='yes')
			{
				$this->db->select('customer_id,total_paid');
				$this->db->from('invoice_info');
				$this->db->where('invoice_info.invoice_id',$in_id);
				$query = $this->db->get();
				$field = $query->row();
				$customer_id = $field->customer_id;
				$total_paid = $field->total_paid;
				if(($customer_new!='' || $customer_new!='0') && ($customer_id == $customer_new))
				{

					$zero = 0;
					$this->db->select('sale_return_main_product.*,SUM(return_quantity*exact_price) as total_return');
					$this->db->from('sale_return_main_product');
					$this->db->where('sale_return_main_product.status="'.$zero.'"');
					$query3 = $this->db->get();
					$tmp3 = $query3->row();
					$return_list_id = $tmp3->return_list_id;
					$total_return = $tmp3->total_return;
					
					$datareturn=array(
						'total_amount'=>$total_return,
						'return_adjustment'=>$return_adjustment_amount
					);
					$this->db->where('srl_id', $return_list_id);
					$this->db->update('sale_return_list',$datareturn);
					if($total_paid!=0)
					{
						$transaction_info = array
						(
						   'transaction_id'         			=> '',
						   'transaction_purpose'                => 'sale_return',
						   'transaction_mode'                 	=> 'cash',
						   'ledger_id'         					=> $customer_id,
						   'common_id'         					=> '',
						   'sub_id'         					=> $return_list_id,
						   'amount'     						=> $tmp3->total_return,
						   'date'                   			=> date('Y-m-d'),
						   'status'        						=> 'active',
						   'creator'        					=> $creator,
						   'doc'   								=> $bd_date,
						   'dom'    							=> $bd_date
						);
						$this->db->insert('transaction_info', $transaction_info);
						$insert_id = $this->db->insert_id();
						$cash_book = array(
						   'cb_id'         						=> '',
						   'transaction_id'                     => $insert_id,
						   'transaction_type'                	=> 'out',
						   'amount'                 			=> $tmp3->total_return,
						   'date'         						=> $bd_date,
						   'status'    	 						=> 'active',
						   'creator'                   			=> $creator,
						   'doc'        						=> $bd_date,
						   'dom'       							=> $bd_date
						);
						$this->db->insert('cash_book', $cash_book);
					}
					else
					{
						$transaction_info = array
						(
						   'transaction_id'         			=> '',
						   'transaction_purpose'                => 'sale_return',
						   'transaction_mode'                 	=> 'cash',
						   'ledger_id'         					=> $customer_id,
						   'common_id'         					=> '',
						   'sub_id'         					=> $return_list_id,
						   'amount'     						=> $tmp3->total_return,
						   'date'                   			=> date('Y-m-d'),
						   'status'        						=> 'active',
						   'creator'        					=> $creator,
						   'doc'   								=> $bd_date,
						   'dom'    							=> $bd_date
						);
						$this->db->insert('transaction_info', $transaction_info);
					}
					$this->db->select('*');
					$this->db->from('sale_return_main_product');
					$this->db->where('sale_return_main_product.status="'.$zero.'"');
					$query1 = $this->db->get();
					$i=1;
					foreach($query1->result() as $tmp1)
					{
						$this->db->set('stock_amount', 'stock_amount+' . $tmp1->return_quantity, FALSE);
						$this->db->where('product_id', $tmp1->produ_id);
						$this->db->update('bulk_stock_info');
						
						$data1=array(
							'customer'=>$customer_id,
							'status'=>1
						);
						$this->db->where('status="'.$zero.'"');
						$this->db->where('srmp_id', $tmp1->srmp_id);
						$this->db->where('produ_id', $tmp1->produ_id);
						$this->db->update('sale_return_main_product',$data1);
						 $i++;
					}

					$this->db->select('*');
					$this->db->from('sale_return_warranty_product');
					$this->db->where('sale_return_warranty_product.status="'.$zero.'"');
					$query2 = $this->db->get();
					
					
					if($query2->num_rows > 0)
					{
						$ii=1;
						foreach($query2->result() as $tmp2)
						{
							$data=array
							(
								'invoice_id'=>0,
								'sale_price'=>0,
								'sale_date'=>0000-00-00,
								'status'=>1
							);
							$this->db->where('warranty_product_list.ip_id',$tmp2->ip_id);
							$this->db->where('warranty_product_list.product_id',$tmp2->product_id);
							$this->db->update('warranty_product_list',$data);
							
							$this->db->set('status', 'status+' . 1, FALSE);
							$this->db->where('status="'.$zero.'"');
							$this->db->where('srwp_id', $tmp2->srwp_id);
							$this->db->where('srmp_id', $tmp2->srmp_id);
							$this->db->where('ip_id', $tmp2->ip_id);
							$this->db->where('product_id', $tmp2->product_id);
							$this->db->update('sale_return_warranty_product');
							$ii++;
						}
						
					}
					redirect('salereturn/cash_salereturn/null/null/null/null/success');

				}
				else
				{
					redirect('salereturn/cash_salereturn/'.$re_type.'/'.$in_type.'/'.$in_id.'/null/customer');
				}
			}
			else
			{
				if($customer_new!='' || $customer_new!='0')
				{
					$zero = 0;
					$this->db->select('sale_return_main_product.*,SUM(return_quantity*exact_price) as total_return');
					$this->db->from('sale_return_main_product');
					$this->db->where('sale_return_main_product.status="'.$zero.'"');
					$query3 = $this->db->get();
					$tmp3 = $query3->row();
					$return_list_id = $tmp3->return_list_id;
					$total_return = $tmp3->total_return;
					
					$datareturn=array(
						'total_amount'=>$total_return,
						'return_adjustment'=>$return_adjustment_amount
					);
					$this->db->where('srl_id', $return_list_id);
					$this->db->update('sale_return_list',$datareturn);
					if($total_paid!=0)
					{
						$transaction_info = array
						(
						   'transaction_id'         			=> '',
						   'transaction_purpose'                => 'sale_return',
						   'transaction_mode'                 	=> 'cash',
						   'ledger_id'         					=> $customer_new,
						   'common_id'         					=> '',
						   'sub_id'         					=> $return_list_id,
						   'amount'     						=> $tmp3->total_return,
						   'date'                   			=> date('Y-m-d'),
						   'status'        						=> 'active',
						   'creator'        					=> $creator,
						   'doc'   								=> $bd_date,
						   'dom'    							=> $bd_date
						);
						$this->db->insert('transaction_info', $transaction_info);
						$insert_id = $this->db->insert_id();
						$cash_book = array(
						   'cb_id'         						=> '',
						   'transaction_id'                     => $insert_id,
						   'transaction_type'                	=> 'out',
						   'amount'                 			=> $tmp3->total_return,
						   'date'         						=> $bd_date,
						   'status'    	 						=> 'active',
						   'creator'                   			=> $creator,
						   'doc'        						=> $bd_date,
						   'dom'       							=> $bd_date
						);
						$this->db->insert('cash_book', $cash_book);
					}
					else
					{
						$transaction_info = array
						(
						   'transaction_id'         			=> '',
						   'transaction_purpose'                => 'sale_return',
						   'transaction_mode'                 	=> 'cash',
						   'ledger_id'         					=> $customer_new,
						   'common_id'         					=> '',
						   'sub_id'         					=> $return_list_id,
						   'amount'     						=> $tmp3->total_return,
						   'date'                   			=> date('Y-m-d'),
						   'status'        						=> 'active',
						   'creator'        					=> $creator,
						   'doc'   								=> $bd_date,
						   'dom'    							=> $bd_date
						);
						$this->db->insert('transaction_info', $transaction_info);
					}
					$this->db->select('*');
					$this->db->from('sale_return_main_product');
					$this->db->where('sale_return_main_product.status="'.$zero.'"');
					$query1 = $this->db->get();
					$i=1;
					foreach($query1->result() as $tmp1)
					{
						$this->db->set('stock_amount', 'stock_amount+' . $tmp1->return_quantity, FALSE);
						$this->db->where('product_id', $tmp1->produ_id);
						$this->db->update('bulk_stock_info');
						
						$data1=array(
							'customer'=>$customer_new,
							'status'=>1
						);
						$this->db->where('status="'.$zero.'"');
						$this->db->where('srmp_id', $tmp1->srmp_id);
						$this->db->where('produ_id', $tmp1->produ_id);
						$this->db->update('sale_return_main_product',$data1);
						 $i++;
					}

					$this->db->select('*');
					$this->db->from('sale_return_warranty_product');
					$this->db->where('sale_return_warranty_product.status="'.$zero.'"');
					$query2 = $this->db->get();
					
					if($query2->num_rows > 0)
					{
						$ii=1;
						foreach($query2->result() as $tmp2)
						{
							$data=array
							(
								'invoice_id'=>0,
								'sale_price'=>0,
								'sale_date'=>0000-00-00,
								'status'=>1
							);
							$this->db->where('warranty_product_list.ip_id',$tmp2->ip_id);
							$this->db->where('warranty_product_list.product_id',$tmp2->product_id);
							$this->db->update('warranty_product_list',$data);
							
							$this->db->set('status', 'status+' . 1, FALSE);
							$this->db->where('status="'.$zero.'"');
							$this->db->where('srwp_id', $tmp2->srwp_id);
							$this->db->where('srmp_id', $tmp2->srmp_id);
							$this->db->where('ip_id', $tmp2->ip_id);
							$this->db->where('product_id', $tmp2->product_id);
							$this->db->update('sale_return_warranty_product');
							$ii++;
						}
						
					}
					redirect('salereturn/cash_salereturn/null/null/null/null/success');

				}
				else
				{
					redirect('salereturn/cash_salereturn/'.$re_type.'/'.$in_type.'/'.$in_id.'/null/customer');
				}
			}
		}
	}
}
