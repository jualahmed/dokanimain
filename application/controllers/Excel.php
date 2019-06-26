<<<<<<< HEAD
<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');  
  
class Excel extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		$this->load->model('excel_model'); 

	}
	public function stock_csv()
	{
		$data = $this -> excel_model -> print_data_stock();
	}
	public function stock_excel()
	{
		$data['down_data_stock'] = $this -> excel_model -> print_data_stock2();
		$this->load->view('excel_data_stock',$data);
	}

	public function stock_word()
	{
		$data['down_data_stock'] = $this -> excel_model -> print_data_stock2();
		$this->load->view('csv_data_stock',$data);
	}
	 
=======
<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');  
  
class Excel extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		$this->load->model('excel_model'); 

	}
	public function stock_csv()
	{
		$data = $this -> excel_model -> print_data_stock();
	}
	public function stock_excel()
	{
		$data['down_data_stock'] = $this -> excel_model -> print_data_stock2();
		$this->load->view('excel_data_stock',$data);
	}

	public function stock_word()
	{
		$data['down_data_stock'] = $this -> excel_model -> print_data_stock2();
		$this->load->view('csv_data_stock',$data);
	}
	 
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
}