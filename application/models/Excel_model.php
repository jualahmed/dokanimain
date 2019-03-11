<?php
 
class Excel_model extends CI_Model{
	function __construct(){
		parent::__Construct();
		$this->shop_id = $this->tank_auth->get_shop_id();
		 
		$this->db = $this->load->database('default', TRUE,TRUE);
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
	}
	function print_data_stock()
	{
		$product = $this -> uri -> segment(3);
		$category = $this -> uri -> segment(4);
		$company = $this -> uri -> segment(5);
		$pro_type = $this -> uri -> segment(6);
		$pro_size = $this -> uri -> segment(7);
		$pro_amount = $this -> uri -> segment(8);
		
		$category1 = rawurldecode($category);
		$company1 = rawurldecode($company);
		$product_type1 = rawurldecode($pro_type);
		
		$this->db->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_specification,product_type,product_size');
		$this->db->from('product_info');
		$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');


		if($product!='' && $product !='null'){$this->db->where('product_info.product_id = "'.$product.'" ');}
		if($category1!='' && $category1 !='null'){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
		if($company1!='' && $company1 !='null'){$this->db->where('product_info.company_name = "'.$company1.'" ');}
		if($product_type1!='' && $product_type1 !='null'){$this->db->where('product_info.product_type = "'.$product_type1.'" ');}
		if($pro_size!='' && $pro_size !='null'){$this->db->where('product_info.product_size = "'.$pro_size.'" ');}
		if($pro_amount!='' && $pro_amount !='null'){$this->db->where('bulk_stock_info.stock_amount <= "'.$pro_amount.'" ');}
		
		$this->db->group_by('product_info.product_id'); 
		$this->db->order_by('product_info.product_id','asc'); 
		$query = $this->db->get();
		
		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=Stock.csv");
		 $handle = fopen('php://output', 'w');
		 fputcsv($handle, array('No','Id', 'Product', 'Company','Category','Type','Size','BP','Stock'));
		 $i=1; 
		 foreach($query->result() as $row)
		 {
			 fputcsv($handle, array(
			 $i,
			 $row->product_id,
			 $row->product_name,
			 $row->company_name,
			 $row->catagory_name,
			 $row->product_type,
			 $row->product_size,
			 $row->bulk_unit_buy_price,
			 $row->stock_amount,
			 ));
			 $i++;
		 }
		 fputcsv($handle, array());
		 fclose($handle);
		 
		 $headers = array(
		 'Content-Type' => 'text/csv',
		 );
		
		force_download($handle);
	} 
	function print_data_stock2()
	{
		$barcode = $this -> uri -> segment(3);
			$product_id = $this -> uri -> segment(4);
			$category = $this -> uri -> segment(5);
			$company = $this -> uri -> segment(6);
			$type_wise = $this -> uri -> segment(7);
			$product_amount = $this -> uri -> segment(8);
			$start_date=$this -> uri -> segment(9);
			$end_date=$this -> uri -> segment(10);
			
			$barcode1 = rawurldecode($barcode);
			$category1 = rawurldecode($category);
			$company1 = rawurldecode($company);
			
			if($type_wise !='' && $type_wise !='null')
			{
				if($type_wise =='available')
				{
					$this->db->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price, general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_specification,product_type,product_size');
					$this->db->from('product_info');
					$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
					$this->db->where('bulk_stock_info.stock_amount > 0'); 
					if($barcode1!='' && $barcode1 !='null'){$this->db->where('product_info.barcode = "'.$barcode1.'" ');} 
					if($product_id!='' && $product_id !='null'){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
					if($category1!='' && $category1 !='null'){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
					if($company1!='' && $company1 !='null'){$this->db->where('product_info.company_name = "'.$company1.'" ');}
					if($product_amount!='' && $product_amount !='null'){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
					/* if($start_date!='' && $start_date !='null'){$this->db->where('bulk_stock_info.stock_doc >= "'.$start_date.'"');}

					if($end_date!='' && $end_date !='null')
					{
						$this->db->where('bulk_stock_info.stock_doc <= "'.$end_date.'"');
					}
					else if($start_date!='' && $start_date !='null'){
						$this->db->where('bulk_stock_info.stock_doc <= "'.$start_date.'"');
					} */
					
					//$this->db->limit(5);
					$this->db->order_by('product_info.product_id','asc'); 
					$this->db->order_by('product_info.product_name','asc'); 
					$query = $this->db->get();
					return $query;
				}
				else if($type_wise =='not_available')
				{
					$this->db->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price,general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_specification,product_type,product_size');
					$this->db->from('product_info');
					$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
					$this->db->where('bulk_stock_info.stock_amount <= 0'); 
					if($barcode1!='' && $barcode1 !='null'){$this->db->where('product_info.barcode = "'.$barcode1.'" ');} 
					if($product_id!='' && $product_id !='null'){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
					if($category1!='' && $category1 !='null'){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
					if($company1!='' && $company1 !='null'){$this->db->where('product_info.company_name = "'.$company1.'" ');}
					if($product_amount!='' && $product_amount !='null'){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
					/* if($start_date!='' && $start_date !='null'){$this->db->where('bulk_stock_info.stock_doc >= "'.$start_date.'"');}

					if($end_date!='' && $end_date !='null')
					{
						$this->db->where('bulk_stock_info.stock_doc <= "'.$end_date.'"');
					}
					else if($start_date!='' && $start_date !='null'){
						$this->db->where('bulk_stock_info.stock_doc <= "'.$start_date.'"');
					} */
					
					//$this->db->limit(5);
					$this->db->order_by('product_info.product_id','asc'); 
					$this->db->order_by('product_info.product_name','asc'); 
					$query = $this->db->get();
					return $query;
				}
				else if($type_wise =='all')
				{
					$this->db->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price, general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_specification,product_type,product_size');
					$this->db->from('product_info,bulk_stock_info');
					$this->db->where('product_info.product_id = bulk_stock_info.product_id');
					//$this->db->where('bulk_stock_info.stock_amount <= 0'); 
					if($barcode1!='' && $barcode1 !='null'){$this->db->where('product_info.barcode = "'.$barcode1.'" ');} 
					if($product_id!='' && $product_id !='null'){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
					if($category1!='' && $category1 !='null'){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
					if($company1!='' && $company1 !='null'){$this->db->where('product_info.company_name = "'.$company1.'" ');}
					if($product_amount!='' && $product_amount !='null'){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
					/* if($start_date!='' && $start_date !='null'){$this->db->where('bulk_stock_info.stock_doc >= "'.$start_date.'"');}

					if($end_date!='' && $end_date !='null')
					{
						$this->db->where('bulk_stock_info.stock_doc <= "'.$end_date.'"');
					}
					else if($start_date!='' && $start_date !='null'){
						$this->db->where('bulk_stock_info.stock_doc <= "'.$start_date.'"');
					}
					 */
					//$this->db->limit(5);
					$this->db->order_by('product_info.product_id','asc'); 
					$this->db->order_by('product_info.product_name','asc'); 
					$query = $this->db->get();
					return $query;
				}
			}
			else
			{
				$this->db->select('product_name, company_name, catagory_name, product_info.product_id, bulk_unit_sale_price, general_unit_sale_price, bulk_unit_buy_price, stock_amount, barcode, group_name, product_specification,product_type,product_size');
				$this->db->from('product_info');
				$this->db->join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');

				if($barcode1!='' && $barcode1 !='null'){$this->db->where('product_info.barcode = "'.$barcode1.'" ');} 
				if($product_id!='' && $product_id !='null'){$this->db->where('product_info.product_id = "'.$product_id.'" ');}
				if($category1!='' && $category1 !='null'){$this->db->where('product_info.catagory_name = "'.$category1.'" ');}
				if($company1!='' && $company1 !='null'){$this->db->where('product_info.company_name = "'.$company1.'" ');}
				if($product_amount!='' && $product_amount !='null'){$this->db->where('bulk_stock_info.stock_amount <= "'.$product_amount.'" ');}
				/* if($start_date!='' && $start_date !='null'){$this->db->where('bulk_stock_info.stock_doc >= "'.$start_date.'"');}

				if($end_date!='' && $end_date !='null')
				{
					$this->db->where('bulk_stock_info.stock_doc <= "'.$end_date.'"');
				}
				else if($start_date!='' && $start_date !='null'){
					$this->db->where('bulk_stock_info.stock_doc <= "'.$start_date.'"');
				} */
				
				//$this->db->limit(5);
				$this->db->order_by('product_info.product_id','asc'); 
				$this->db->order_by('product_info.product_name','asc'); 
				$query = $this->db->get();
				return $query;
			}
		
	}
 
}