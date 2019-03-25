<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Exchange_model extends CI_model{
		private $shop_id;
			
		function __construct()
		{
			$this -> shop_id = $this -> tank_auth -> get_shop_id();
		}
		public function get_exchange_return_id()
        {
			$is_exists =    $this->db
                            ->select('exchange_return_id')
                            ->where('status = "pending"')
                            ->limit(1)
                            ->get('exchange_return_tbl');
			if($is_exists->num_rows() != 0)
			{
				$tmp = $is_exists->row();
                return $tmp->exchange_return_id;
			}
            else
			{
                return false;
            }
        }
		public function get_all_exchange_product()
        {
           $this->db->select('product_id, product_name, exchange_quantity, unit_price, status1');
           $this->db->from('exchange_return_tbl, exchange_return_details_tbl');
           $this->db->where('exchange_return_details_tbl.exchange_return_id = exchange_return_details_tbl.exchange_return_id');
           $this->db->where('exchange_return_tbl.status = "pending"');
           $this->db->where('exchange_return_details_tbl.status2 = "pending"');
           $data = $this->db->get();
            if($data->num_rows() > 0){
                return $data;
            }
            else return false;

        }
		public function addToExchangeReturn($pro_id, $product_name, $unit_price, $qnty, $status_type)
        {
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			
			$is_exists =    $this->db
                            ->select('exchange_return_id')
                            ->where('status = "pending"')
                            ->limit(1)
                            ->get('exchange_return_tbl');
			if($is_exists->num_rows() == 0)
			{
				$data1 = array(
					'exchange_return_creator'    => $creator,
					'status'            		 => 'pending',
					'total_amount_ex'          	 => 0,
					'total_amount_re'          	 => 0,
					'exchange_return_doc'        => $bd_date
					);

				$this->db->insert('exchange_return_tbl', $data1);
				$exchange_return_id = $this->db->insert_id();
				
				if($status_type=='Exchange')
				{
					$total_price = round(($unit_price * $qnty), 2);
					$data2 = array(
						'id'                    => '',
						'exchange_return_id'    => $exchange_return_id,
						'product_id'            => $pro_id,
						'product_name'          => $product_name,
						'exchange_quantity'     => $qnty,
						'unit_price'            => $unit_price,
						'total_price'           => $total_price,
						'status1'               => $status_type,
						'status2'               => 'pending'
						);

					$this->db->insert('exchange_return_details_tbl', $data2);
					$this->db->set('total_amount_ex', ' total_amount_ex+' . $total_price, FALSE)
								->where('exchange_return_id', $exchange_return_id)
								->update('exchange_return_tbl');
				}
				else
				{
					$total_price = round(($unit_price * $qnty), 2);
					$data2 = array(
						'id'                    => '',
						'exchange_return_id'    => $exchange_return_id,
						'product_id'            => $pro_id,
						'product_name'          => $product_name,
						'exchange_quantity'     => $qnty,
						'unit_price'            => $unit_price,
						'total_price'           => $total_price,
						'status1'               => $status_type,
						'status2'               => 'pending'
						);

					$this->db->insert('exchange_return_details_tbl', $data2);
					$this->db->set('total_amount_re', ' total_amount_re+' . $total_price, FALSE)
								->where('exchange_return_id', $exchange_return_id)
								->update('exchange_return_tbl');
					
				}
			}
			else
			{
				$tmp = $is_exists->row();
                $exchange_return_id =  $tmp->exchange_return_id;
				if($status_type=='Exchange')
				{
					$total_price = round(($unit_price * $qnty), 2);
					$data2 = array(
						'id'                    => '',
						'exchange_return_id'    => $exchange_return_id,
						'product_id'            => $pro_id,
						'product_name'          => $product_name,
						'exchange_quantity'     => $qnty,
						'unit_price'            => $unit_price,
						'total_price'           => $total_price,
						'status1'               => $status_type,
						'status2'               => 'pending'
						);

					$this->db->insert('exchange_return_details_tbl', $data2);
					$this->db->set('total_amount_ex', ' total_amount_ex+' . $total_price, FALSE)
								->where('exchange_return_id', $exchange_return_id)
								->update('exchange_return_tbl');
				}
				else
				{
					$total_price = round(($unit_price * $qnty), 2);
					$data2 = array(
						'id'                    => '',
						'exchange_return_id'    => $exchange_return_id,
						'product_id'            => $pro_id,
						'product_name'          => $product_name,
						'exchange_quantity'     => $qnty,
						'unit_price'            => $unit_price,
						'total_price'           => $total_price,
						'status1'               => $status_type,
						'status2'               => 'pending'
						);

					$this->db->insert('exchange_return_details_tbl', $data2);
					$this->db->set('total_amount_re', ' total_amount_re+' . $total_price, FALSE)
								->where('exchange_return_id', $exchange_return_id)
								->update('exchange_return_tbl');
					
				}
			}
			return true;
        }
		public function doExchangeReturn($current_exchange_return_id, $creator, $bd_date)
        {   
			$stat = 'pending';
            $sql = $this->db
                            ->select('exchange_return_tbl.exchange_return_id,product_id, exchange_quantity, status1')
                            ->from('exchange_return_tbl, exchange_return_details_tbl')
                            ->where('exchange_return_tbl.exchange_return_id = exchange_return_details_tbl.exchange_return_id')
                            ->where('exchange_return_tbl.status', $stat)
                            ->where('exchange_return_tbl.exchange_return_id', $current_exchange_return_id)
                            ->get();
            
            if($sql->num_rows() > 0)
            {
				$tmp1 = $sql->row();
				$sts = 'active';
				
				$dataa = array
				(
					'status'=>$sts
				);
				$this->db->where('exchange_return_id', $tmp1->exchange_return_id)->update('exchange_return_tbl',$dataa);
								
                foreach($sql->result() as $tmp)
                {
					if($tmp->status1=='Receive')
					{
						$this->db->set('stock_amount', 'stock_amount+' . $tmp->exchange_quantity, FALSE)
                                ->where('product_id', $tmp->product_id)->update('bulk_stock_info');
								
						$dataa1 = array
						(
							'status2'=>$sts
						);
						$this->db->where('product_id', $tmp->product_id)->update('exchange_return_details_tbl',$dataa1);

					}
					else if($tmp->status1=='Exchange')
					{
						$this->db->set('stock_amount', 'stock_amount-' . $tmp->exchange_quantity, FALSE)
                                ->where('product_id', $tmp->product_id)->update('bulk_stock_info');
								
						$dataa2 = array
						(
							'status2'=>$sts
						);
						$this->db->where('product_id', $tmp1->product_id)->update('exchange_return_details_tbl',$dataa2);
					}
                }

                return true;
            }
            else{
                return false;
            }
        }
		public function deleteExchangeReturn($current_exchange_return_id, $product_id)
		{
			 $sql = $this->db
                            ->select('exchange_return_details_tbl.total_price,exchange_return_details_tbl.status1')
                            ->from('exchange_return_details_tbl')
                            ->where('exchange_return_details_tbl.exchange_return_id', $current_exchange_return_id)
                            ->get();
			
			$tmp1 = $sql->row();
			
			if($tmp1->status1=='Exchange')
			{
				$this->db->set('total_amount_ex', 'total_amount_ex-' . $tmp1->total_price, FALSE)
                                ->where('exchange_return_id', $current_exchange_return_id)->update('exchange_return_tbl');
			}
			else if($tmp1->status1=='Receive')
			{
				$this->db->set('total_amount_re', 'total_amount_re-' . $tmp1->total_price, FALSE)
                                ->where('exchange_return_id', $current_exchange_return_id)->update('exchange_return_tbl');
			}

			$this->db->where('exchange_return_id', $current_exchange_return_id)
			->where('product_id', $product_id)
			->delete('exchange_return_details_tbl');
			
			return true;
		}
}
