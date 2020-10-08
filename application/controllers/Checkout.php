<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller{
    
    function  __construct(){
        parent::__construct();
        
        // Load form library & helper
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        // Load cart library
        $this->load->library('cart');
        
        // Load product model
        $this->load->model('checkout_model');
        
        $this->controller = 'checkout';
    }
    
    function index(){
        // Redirect if the cart is empty
        if($this->cart->total_items() <= 0){
            redirect('product/');
        }
        
        $custData = $data = array();
        
        // If order request is submitted
        $submit = $this->input->post('placeOrder');
        if(isset($submit)){
            // Form field validation rules
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            
            // Prepare customer data
            $custData = array(
                'name'     => strip_tags($this->input->post('name')),
                'email'     => strip_tags($this->input->post('email')),
                'phone'     => strip_tags($this->input->post('phone')),
                'address'=> strip_tags($this->input->post('address'))
            );
            
            // Validate submitted form data
            if($this->form_validation->run() == true){
                // Insert customer data
                $insert = $this->checkout_model->insertCustomer($custData);
                
                // Check customer data insert status
                if($insert){
                    // Insert order
                    $order = $this->placeOrder($insert);
                    
                    // If the order submission is successful
                    if($order){
                        $this->session->set_userdata('success_msg', 'Order placed successfully.');
                        redirect($this->controller.'/orderSuccess/'.$order);
                    }else{
                        $data['error_msg'] = 'Order submission failed, please try again.';
                    }
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }
        }
        
        // Customer data
        $data['custData'] = $custData;
        
        // Retrieve cart data from the session
        $data['cartItems'] = $this->cart->contents();
        
        // Pass products data to the view
        $this->load->view($this->controller.'/index', $data);
    }
    
    function placeOrder(){
       
		$user = $this->input->post('user_name');
		$pass = $this->input->post('password');
		$remember = 1;
				
		$data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND $this->config->item('use_username', 'tank_auth'));
			   
		$data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$user_id = array();
		if ($this->config->item('login_count_attempts', 'tank_auth') AND
			($login = $this->input->post('user'))) {
			$login = $this->security->xss_clean($login);
							
		} else {
			$login = '';
		}
		if ($this->tank_auth->login($user,$pass,$remember,$data['login_by_username'],$data['login_by_email'])) 
		{
			
			$user_id = $this->tank_auth->get_user_id();
			$sale_id = $this->direct_model->createNewSale($user_id, $this->tank_auth->get_shop_id());
        
			if($sale_id)
			{
				$cartItems = $this->cart->contents();
				$ordItemData = array();
				$i=0;
				foreach($cartItems as $item)
				{
					//$ordItemData[$i]['order_id']     = $sale_id;
					$ordItemData[$i]['product_id']     = $item['id'];
					$ordItemData[$i]['quantity']     = $item['qty'];
					$ordItemData[$i]['sub_total']     = $item["subtotal"];
					
					$this->db->select('bulk_stock_info.*,product_info.product_name')
					->from('bulk_stock_info,product_info')
					->where('bulk_stock_info.product_id=product_info.product_id')
					->where('bulk_stock_info.product_id', $ordItemData[$i]['product_id'])
					->limit(1);
					$query = $this->db->get();
					$tmp = $query->row();
					
					$data = array(
						'temp_sale_id'              => $sale_id,
						'product_id'                => $ordItemData[$i]['product_id'],
						'stock_id'                  => 0,
						'sale_quantity'             => $ordItemData[$i]['quantity'],
						'product_specification'     => 'bulk',
						'sale_type'                 => 1,
						'unit_buy_price'            => $tmp->bulk_unit_buy_price,
						'unit_sale_price'           => $tmp->bulk_unit_sale_price,
						'general_unit_sale_price'   => $tmp->general_unit_sale_price,
						'actual_sale_price'         => $tmp->bulk_unit_sale_price,
						'temp_sale_details_status'  => 1,
						'item_name'                 => $tmp->product_name,
						'stock'                     => $tmp->stock_amount - $ordItemData[$i]['quantity']
					);
					$this->db->insert('temp_sale_details', $data);
					$temp_sale_details_id = $this->db->insert_id();
					 $this->db->where('product_id', $ordItemData[$i]['product_id'])->limit(1)
					->update('bulk_stock_info', array('stock_amount' => $tmp->stock_amount - $ordItemData[$i]['quantity']));
					
					$i++;
				}

				$this->cart->destroy();
				redirect('checkout/orderSuccess/');
			}
		}
		else 
		{
			redirect('checkout/index/bn/wrong');
		}
        return false;
    }
    
    function orderSuccess(){
        // Fetch order data from the database
       // $data['order'] = $this->checkout_model->getOrder($ordID);
        
        // Load order details view
        $this->load->view($this->controller.'/order-success');
    }
    
}