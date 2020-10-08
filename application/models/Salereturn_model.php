<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Salereturn_model extends CI_model
{
    private $userId;
	private $bdDate;
	public function __construct()
	{
		parent::__construct();
		$this->userId = $this->tank_auth->get_user_id();
		$this->bdDate = date ('Y-m-d');
	}

	public function sale_return_main_product()
	{
		$this->db->select("product_info.product_name,sale_return_main_product.*");
		$this->db->from("product_info,sale_return_main_product");
		$this->db->where("sale_return_main_product.produ_id=product_info.product_id");
		$this->db->where("sale_return_main_product.status=0");
		$query = $this->db->get();
		return $query;
	}

	public function return_warranty_product($produ_id)
	{
		$this->db->select("*");
		$this->db->from("sale_return_warranty_product");
		$this->db->where("sale_return_warranty_product.product_id",$produ_id);
		$this->db->where("sale_return_warranty_product.status=0");
		$query = $this->db->get();
		return $query;
	}

	public function product_info($invoice_id,$invoice_type)
	{
		if($invoice_type=='yes')
		{
			$this->db->select("product_info.product_id,product_info.product_name,product_info.product_specification");
			$this->db->from("product_info,sale_details");
			$this->db->where("sale_details.product_id=product_info.product_id");
			$this->db->where("sale_details.invoice_id", $invoice_id );
			$this->db->order_by("product_info.product_name", "asc" );
			$this->db->group_by("product_info.product_id" );
			$query = $this->db->get();
			return $query;
		}
		else{
			$this->db->select("product_info.product_id,product_info.product_name,product_info.product_specification");
			$this->db->from("product_info");
			$this->db->order_by("product_info.product_name", "asc" );
			$this->db->group_by("product_info.product_id" );
			$query = $this->db->get();
			return $query;
		}
	}

	public function product_info_details($invoice_id,$invoice_type,$product_id)
	{
		if($invoice_type=='yes')
		{
			$this->db->select("product_info.product_id,product_info.product_name,product_info.product_specification,sale_details.sale_quantity,sale_details.discount,sale_details.unit_sale_price,sale_details.general_sale_price,sale_details.exact_sale_price");
			$this->db->from("sale_details,product_info");
			$this->db->where("sale_details.product_id=product_info.product_id");
			$this->db->where("sale_details.invoice_id", $invoice_id );
			$this->db->where("product_info.product_id", $product_id );
			$query = $this->db->get();

			return $query;
		}
		else if($invoice_type=='no')
		{
			$this->db->select("product_info.product_id,product_info.product_name,product_info.product_specification,bulk_stock_info.stock_amount,bulk_stock_info.bulk_unit_buy_price,bulk_stock_info.bulk_unit_sale_price,bulk_stock_info.general_unit_sale_price");
			$this->db->from("bulk_stock_info,product_info");
			$this->db->where("bulk_stock_info.product_id=product_info.product_id");
			$this->db->where("product_info.product_id", $product_id );
			$query = $this->db->get();
			return $query;
		}
	}

	public function product_info_warranty_details($invoice_id,$invoice_type,$product_id)
	{
		if($invoice_type=='yes')
		{
			$this->db->select("product_info.product_id,product_info.product_name,sale_details.sale_quantity,warranty_product_list.ip_id,warranty_product_list.sl_no");
			$this->db->from("sale_details,product_info,warranty_product_list");
			$this->db->where("sale_details.product_id=product_info.product_id");
			$this->db->where("product_info.product_id=warranty_product_list.product_id");
			$this->db->where("warranty_product_list.invoice_id", $invoice_id );
			$this->db->where("warranty_product_list.product_id", $product_id );
			$this->db->where('warranty_product_list.status',1);
			$this->db->group_by("warranty_product_list.ip_id");
			$query = $this->db->get();
			return $query;
		}
		else if($invoice_type=='no')
		{
			$this->db->select("product_info.product_id,product_info.product_name,sale_details.sale_quantity,warranty_product_list.ip_id,warranty_product_list.sl_no");
			$this->db->from("sale_details,product_info,warranty_product_list");
			$this->db->where("sale_details.product_id=product_info.product_id");
			$this->db->where("product_info.product_id=warranty_product_list.product_id");
			$this->db->where("warranty_product_list.product_id", $product_id );
			$this->db->where('warranty_product_list.status',1);
			$this->db->group_by("warranty_product_list.ip_id");
			$query = $this->db->get();
			return $query;
		}
	}
}