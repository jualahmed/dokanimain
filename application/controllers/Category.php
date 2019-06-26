<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {

	private $shop_id;
	public function __construct()
	{
		parent::__construct();
		$this->shop_id=$this->tank_auth->get_shop_id();
		$this->output->set_header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->is_logged_in();
	}

	public function is_logged_in()
	{
		$this->load->library('tank_auth');
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login','refresh');
		}
	}

	public function index()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['sale_status'] = '';
		$data['alarming_level'] = FALSE;
		$data['status'] = '';
		$data['user_name'] = $this->tank_auth->get_username();
		$this->__renderview('Setup/catagory',$data);
	}

	/* create catagory */
	public function create()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['status'] = '';
		$this->load->library('form_validation');
		$this->form_validation->set_rules('catagory_name', 'Catagory Name','required');
		$this->form_validation->set_rules('catagory_description', 'Catagory Description');
		$data['user_name'] = $this->tank_auth->get_username();
		
		if($this -> form_validation -> run() ==  FALSE)
		{
			$data['status'] = 'error';
			redirect('category/error');
		}
		else
		{
			$catagory_name = $this -> input ->post('catagory_name');
			$exists = $this -> setup_model -> redundancy_check('catagory_info', 'catagory_name', $catagory_name);
			if($exists == true)
			{
				$data['status'] = 'exist';
				redirect('category/exist');
			}
			else
			{
			
				$catagory_id = $this -> setup_model -> create_catagory();
				
				if($catagory_id!='')
				{
					$data['status'] = 'success';
					redirect('category/success');
				}
				else
				{
					$data['status'] = 'failed';
					redirect('category/failed');
				}
			}
		}
	}

	public function store()
	{
		# code...
	}

	public function show()
	{
		# code...
	}

	public function edit()
	{
		# code...
	}

	public function update()
	{
		# code...
	}

	public function destroy()
	{
		# code...
	}

}

/* End of file Category.php */
/* Location: ./application/controllers/Category.php */