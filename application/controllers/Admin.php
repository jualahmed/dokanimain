<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class admin extends MY_controller{

	public function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$this->load->model('admin_model');
		$this->ci =& get_instance();
	}

	public function is_logged_in()
	{
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login');
		}
	}

	public function index()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();	
		$data['user_type'] = $this->tank_auth->get_usertype();
		$start_date = date ('Y-m-d');
		$end_date = date ('Y-m-d 23:59:59');
		$data['previous_date'] = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 30, date("y")));
		$data[ 'sale_price_info' ] = $this->report_model->specific_date_sale_price_calculation(  $start_date  ,  $end_date  );
		$data[ 'main_cash_info' ] = $this->report_model->specific_date_total_cash_calculation(  $start_date  ,  $end_date  );
		$data[ 'purchase_info' ] = $this->report_model->specific_date_purchase_amount_calculation();
		$data['expense_info' ] = $this->report_model->specific_date_expense_amount_calculation( $start_date  ,  $end_date  );
		$data[ 'main_credit_receive_info' ] = $this->report_model->specific_date_total_credit_collection_calculation(  $start_date  ,  $end_date  );
		$data[ 'grand_price_info' ] = $this->report_model->specific_date_grand_sale_price_calculation(  $start_date  ,  $end_date  );
		$data[ 'total_price_info' ] = 0;
		$data['total_stock_price'] = $this->site_model->total_stock_price();
		$data['total_stock_quantity'] = $this->site_model->total_stock_quantity();
		$prevdate = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
		$data['statment']=Dailystatementm::where('date',$prevdate)->get();
		$this->__renderview('home', $data);
	}

	public function user_modification()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		$data['user_name'] = $this->tank_auth->get_username();
		if($data['user_type'] == 'superadmin' || $data['user_type'] == 'admin' || $data['user_type'] == 'manager' )
		{
			$data['sale_status'] = '';
			$data['status'] = '';
			$data['alarming_level'] = FALSE;
			$data['user_info'] = $this->admin_model->all_user();
			$data['change_mood'] = $this->admin_model->specific_user();
			$this->__renderview('user_modification_form_view', $data);
		}
	}

	public function update_user()
	{
		$data['user_type'] = $this->tank_auth->get_usertype();
		if($data['user_type'] == 'superadmin' || $data['user_type'] == 'admin' || $data['user_type'] == 'manager' )
		{
			$data['sale_status'] = '';
			$this->form_validation->set_rules('user_address', 'User Address','required|xss_clean');
			$this->form_validation->set_rules('email', 'Phone Number','numeric|required|xss_clean');
			$data['alarming_level'] = FALSE;
			$data['errors'] = array();
			$data['status']='';
			
			if ($this->form_validation->run(TRUE)) 
			{
				$new_password 	= $this->input->post('new_password');
				$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
				$hashed_password = $hasher->HashPassword($new_password);
				$this->admin_model->update_user($hashed_password,$new_password);
				$data['status'] = 'success';
				$data['user_type'] = $this->tank_auth->get_usertype();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['user_info'] = $this->admin_model->all_user();
				$data['change_mood'] = $this->admin_model->specific_user();
				$this->__renderview('user_modification_form_view', $data);
				
			}
			else
			{
				$errors = $this->tank_auth->get_error_message();
				foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				$data['status'] = 'error';
				$data['user_type'] = $this->tank_auth->get_usertype();
				$data['user_name'] = $this->tank_auth->get_username();
				$data['user_info'] = $this->admin_model->all_user();
				$data['change_mood'] = $this->admin_model->specific_user();
				$this->__renderview('user_modification_form_view', $data);
			}
		}
	}

	public function dailystatement()
	{
		$date = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
		$dailystatementm = new Dailystatementm();
		$dailystatementm->date = $date;
		$dailystatementm->purchase =Transactionm::where('transaction_purpose','purchase')->where('date',$date)->sum('amount');
		$dailystatementm->expense =Transactionm::where('transaction_purpose','expense')->where('date',$date)->sum('amount');
		$dailystatementm->sale =Transactionm::where('transaction_purpose','sale')->where('date',$date)->sum('amount');
		$dailystatementm->sale_discount =Invoicem::where('invoice_doc',$date)->sum('discount_amount');
		$dailystatementm->receivable_gift =Purchasereceiptinfom::where('receipt_date',$date)->sum('transport_cost');
		$dailystatementm->transport_cost =Purchasereceiptinfom::where('receipt_date',$date)->sum('gift_on_purchase');
		$cstock = Bulkstockinfom::selectRaw('SUM(bulk_unit_buy_price * stock_amount) as total')->pluck('total')[0];
		$totalsale = Invoicem::where('invoice_doc',$date)->sum('total_price');
		$totalpurchase = Purchaseinfom::selectRaw('SUM(unit_buy_price * purchase_quantity) as total')->where('purchase_doc',$date)->pluck('total')[0];
		$dailystatementm->stock_current =$cstock;
		$dailystatementm->stock_opening =($cstock+$totalsale)-$totalpurchase;
		$cahsin = Cashbook::where('transaction_type','in')->sum('amount');
		$cahsout = Cashbook::where('transaction_type','out')->sum('amount');
		$dailystatementm->cash_in_hand =$cahsin-$cahsout;
		$bankin = Bankbook::where('transaction_type','in')->sum('amount');
		$bankout = Bankbook::where('transaction_type','out')->sum('amount');
		$dailystatementm->cash_in_bank =$bankin-$bankout;
		$buyprice = Saledetails::selectRaw('SUM(unit_buy_price * sale_quantity) as total')->where('created_at',$date)->pluck('total')[0];
		$saleprice = Saledetails::selectRaw('SUM(actual_sale_price * sale_quantity) as total')->where('created_at',$date)->pluck('total')[0];
		$dailystatementm->gross_profit = $saleprice-$buyprice;
		$dailystatementm->save();
		redirect('/admin','refresh');
	}

	public function download_database(){
		$temp = $this->admin_model->backup_database();
		echo json_encode($temp);
	}
}
