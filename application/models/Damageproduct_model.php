<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Damageproduct_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function create($data='')
	{
		$this->db->insert('damage_product',$data);
   	 	return $this->db->insert_id();
	}

	public function all()
	{	$this->db->order_by('damage_id', 'desc');
		return $this->db->get('damage_product')->result();
	}

	public function destroy($id)
	{
		$this->db->where('damage_id', $id);
		return $this->db->delete('damage_product');
	}

	public function find($damage_id='')
	{
		$this->db->where('damage_id', $damage_id);
		return $this->db->get('damage_product')->row();
	}

	public function update($damage_id='',$data='')
	{
		$this->db->where('damage_id', $damage_id);
		return $this->db->update('damage_product', $data);
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

}

/* End of file Damageproduct_model.php */
/* Location: ./application/models/Damageproduct_model.php */