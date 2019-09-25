<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Setup_model extends CI_model{
		private $shop_id;
			
		function __construct()
		{
			$this -> shop_id = $this -> tank_auth -> get_shop_id();
		}
		/******************************************
		 *  checking if element is already exists
		 * $table =  table name
		 * $item = element to search
		 * $field = field name
		 *******************************************/
		 	               // table_name,field name,element
		function redundancy_check($table, $field, $item)
		{
			$query = $this -> db -> select( $field )
								 -> from( $table )
								 -> get();
			 $temp_new = strtolower( preg_replace('/\s+/', '', $item));
			 foreach($query -> result() as $info):
				$temp_old = strtolower( preg_replace('/\s+/', '',$info -> $field));
				if($temp_old == $temp_new) return true;
			 endforeach;
			 
			 return false;
		}
		
		/***************************************************
		 *  Redundancy Check For New Product Entry            *
		 * **************************************************/
		 function redundancy_check_for_new_product()
		 {
			 $new_catagory_name = strtolower( preg_replace('/\s+/', '',$this -> input ->post('catagory_name')));
			 $new_company_name = strtolower( preg_replace('/\s+/', '',$this -> input ->post('company_name')));
			 $new_product_type = strtolower( preg_replace('/\s+/', '',$this -> input ->post('product_type')));
			 $new_product_size = strtolower( preg_replace('/\s+/', '',$this -> input ->post('product_size')));
			 $new_product_model = strtolower( preg_replace('/\s+/', '',$this -> input ->post('product_model')));
			 $new_product_name = strtolower( preg_replace('/\s+/', '',$this -> input ->post('customProductName')));
			 $query = $this -> db -> get('product_info');
			 foreach($query -> result() as $info):
				 $old_catagory_name = strtolower( preg_replace('/\s+/', '', $info -> catagory_name ));
				 $old_company_name = strtolower( preg_replace('/\s+/', '', $info -> company_name));
				 $old_product_type = strtolower( preg_replace('/\s+/', '', $info -> product_type ));
				 $old_product_size = strtolower( preg_replace('/\s+/', '', $info -> product_size));
				 $old_product_model = strtolower( preg_replace('/\s+/', '', $info -> product_model));
				 $old_product_name = strtolower( preg_replace('/\s+/', '', $info -> product_name));
				 /* if( $new_catagory_name == $old_catagory_name )
					 if( $new_company_name == $old_company_name )
						 if( $new_product_type == $old_product_type )
						 	if( $new_product_size == $old_product_size )
								if( $new_product_model == $old_product_model )
									return true; */
				if($new_product_name == $old_product_name)
					return true;
			 endforeach;
			 
			 return false;
		 }
		function create_damage()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();	
			$create_damage= array(
				'product_id' 		=> $this->input->post('pro_id'),
				'damage_quantity' 	=> $this->input->post('damage_quantity'),
				'unit_buy_price' 	=> $this->input->post('buy_price'),
				'creator' 			=> $creator,
				'doc'				=> $bd_date,
				'dom' 				=> $bd_date
				);

			$this->db->insert('damage_product', $create_damage);
			$damage_id = $this->db->insert_id();
			
			$update_stock = array(
			'stock_amount'=>$this->input->post('stock') - $this->input->post('damage_quantity')
			);
			$this->db->where('product_id',$this->input->post('pro_id'));
			$this->db->update('bulk_stock_info',$update_stock);
			
			return $damage_id;
		}
		function create_employee()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();	
			$create_employee= array(
				'employee_name' 		=> mysql_real_escape_string(strtoupper($this -> input -> post('employee_name'))),
				'employee_contact_no' 	=> $this -> input -> post('employee_contact_no'),
				'employee_type' 		=> $this -> input -> post('employee_type'),
				'employee_address' 		=> $this -> input -> post('employee_address'),
				'employee_email' 		=> $this -> input -> post('employee_email'),
				'employee_doc' 			=> $bd_date,
				'employee_dom' 			=> $bd_date,
				'employee_creator' 		=> $creator
				);

			$this->db->insert('employee_info', $create_employee);
			$employee_id = $this->db->insert_id();
			
			return $employee_id;
		}

		function create_catagory()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
		    $creator = $this->tank_auth->get_user_id();
			
			$new_catagory_insert_data = array(
	
				'catagory_name' => mysql_real_escape_string(strtoupper($this -> input ->post('catagory_name'))),
				'catagory_description' => $this -> input -> post('catagory_description'),
				'catagory_creator' => $creator,
				'catagory_doc' => $bd_date,
				'catagory_dom' => $bd_date
	
			);
			
			$this -> db -> insert('catagory_info', $new_catagory_insert_data);
			return $insert = $this->db->insert_id();
		}
		
		function create_company()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
		
			/***********************************************************************************
			 * 
			 * rtrim(your_string,"the character you want to remove");
			 * 
			 * we used this function to remove a specific character from the end of a string
			 * 
			 ***********************************************************************************/
			
			$company_name = $this -> input ->post('company_name');
			$temp_name = rtrim($company_name, ";");
			
			$new_company_insert_data = array(
				'company_name' => mysql_real_escape_string(strtoupper($temp_name)),
				'company_address' => $this -> input -> post('company_address'),
				'company_contact_no' => $this -> input -> post('company_contact_no'),
				'company_email' => $this -> input -> post('company_email'),
				'company_description' => $this -> input -> post('company_description'),
				'company_doc' => $bd_date,
				'company_dom' => $bd_date,
				'company_creator' => $creator
			);
			$this -> db -> insert('company_info', $new_company_insert_data);
			return $insert = $this->db->insert_id();
		}
		/* Insert A Distributor */
		function create_distributor()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			
			/***********************************************************************************
			 * 
			 * rtrim(your_string,"the character you want to remove");
			 * 
			 * we used this function to remove a specific character from the end of a string
			 * 
			 ***********************************************************************************/
			
			$distributor_name = $this -> input ->post('distributor_name');
			$temp_name = rtrim($distributor_name, ";");
			
			$new_distributor_insert_data = array(
	
				'distributor_name' 				=> mysql_real_escape_string(strtoupper($temp_name)),
				'distributor_address' 			=> $this -> input -> post('distributor_address'),
				'distributor_contact_no' 		=> $this -> input -> post('distributor_contact_no'),
				'distributor_email' 			=> $this -> input -> post('distributor_email'),
				'distributor_description' 		=> $this -> input -> post('distributor_description'),
				'int_balance' 					=> $this -> input -> post('initial_balance'),
				'distributor_doc' 				=> $bd_date,
				'distributor_dom' 				=> $bd_date,
				'distributor_creator' 			=> $creator
			);
			$this -> db -> insert('distributor_info', $new_distributor_insert_data);
			return $insert = $this->db->insert_id();
		}
		function create_product()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
		    $creator = $this->tank_auth->get_user_id();
			
			$new_product_insert_data = array(			
				'product_name' => mysql_real_escape_string(strtoupper($this -> input ->post('customProductName'))),
				'product_name_bng' => $this -> input ->post('product_name_bng'),
				'catagory_name' => rawurldecode($this -> input ->post('catagory_name')),
				'company_name' => rawurldecode($this -> input ->post('company_name')),
				'product_type' => 'N/A',
				'product_size' => strtoupper($this -> input ->post('product_size')),
				'product_model' => strtoupper($this -> input ->post('product_model')),
				'product_specification' => $this -> input -> post('product_specification'),
				'unit_name' => $this -> input -> post('unit_name'),
				'barcode' => strtoupper($this -> input ->post('barcode')),
				'product_warranty' => $this -> input ->post('product_warranty'),
				'product_status' => 'active',		
				'product_creator' => $creator,
				'product_doc' => $bd_date,
				'product_dom' => $bd_date
			);
			$this -> db -> insert('product_info', $new_product_insert_data);
			
			$new_product_id = $this->db->insert_id() ;
			
			$shop_id = $this -> tank_auth -> get_shop_id();
			
			$new_sale_price_info_data = array(
				'product_id' => $new_product_id,
				'bulk_alarming_stock' => $this -> input ->post('alarming_stock'),
				'stock_amount' => 0,
				'shop_id' => $shop_id,
				'bulk_unit_buy_price' => 0,
				'bulk_unit_sale_price' => 0,
				'general_unit_sale_price' => 0,
				'last_buy_price' => 0,
				'product_specification' => $this -> input -> post('product_specification'),
				'stock_doc' => $bd_date,
				'stock_dom' => $bd_date
			);
			
			$this -> db -> insert('bulk_stock_info', $new_sale_price_info_data);
			
			$filetype = $_FILES['user_file_3']['type'];
			$number = ceil($new_product_id/200);
			if($filetype!='' && $filetype!='0')
			{

				$dir = './images/product_image/main/'.$number.'/';
				if(!is_dir($dir))
				{
					mkdir('./images/product_image/main/'.$number,0777, true);
					
					$image_id = $new_product_id;
					$this->upload_product_image($image_id);
				}
				else
				{
					$image_id = $new_product_id;
					$this->upload_product_image($image_id);
				}
			}
			return $new_product_id;
		}
		function upload_product_image($image_id)
		{
			$number = ceil($image_id/200);
			$file_type2 = $this->get_file_type($_FILES['user_file_3']['type']);
			$user_ext3 = $image_id.'.'.$file_type2;

		
			$_FILES['user_file_3']['name']=$user_ext3;
			$path = $_FILES['user_file_3']['tmp_name'];
			$width = 300;
			$height = 300;
			
			$this->resize_new($width,$height,$path);
			
			$source_img = $path;
			$destination_img = $path;
			
			$d = $this->compress($source_img, $destination_img, 80);
			
			
			$config['upload_path'] 		='./images/product_image/main/'.$number;
			$config['allowed_types'] 	='*';
			
			$this->load->library('upload', $config);
			if($this->upload->do_upload('user_file_3'))
			{
				//echo 'OK';
			}
			else
			{
				//echo 'Not';
				
				//echo $this->upload->display_errors();
			}
			$dir = './images/product_image/thumb/'.$number.'/';
			if(!is_dir($dir))
			{
				mkdir('./images/product_image/thumb/'.$number,0777, true);
				$this->thumb($user_ext3,$number);
			}
			else{
				$this->thumb($user_ext3,$number);
			}	
			$image = array(
					'image_ext' => '.'.$file_type2,
					'image_url' => base_url()."images/product_image/main/".$number.'/'.$user_ext3,
				);
			$this->db->where('product_id',$image_id);
			$this->db->update('product_info',$image);
				
		}
		function thumb($filename,$number)
		{

			$config['image_library'] = 'gd2';
			//$config['source_image'] = './uploads/'.$filename.'.jpg';  #no need to make it static as you are allowing multiple extensions in allowed_types.
			$config['source_image'] = './images/product_image/main/'.$number.'/'.$filename;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['thumb_marker'] = '';
			$config['width']    = 100;
			$config['height']   = 100;
			$config['new_image'] = './images/product_image/thumb/'.$number.'/'.$filename;
			$this->load->library('image_lib', $config); 

			$this->image_lib->initialize($config);

			if(!$this->image_lib->resize()) {
				echo $this->image_lib->display_errors();
				return FALSE;
			}
			
		}
		function resize_new($width, $height,$path)
		{
		  /* Get original image x y*/
			  list($w, $h) = getimagesize($_FILES['user_file_3']['tmp_name']);
			  /* calculate new image size with ratio */
			  $ratio = max($width/$w, $height/$h);
			  $h = ceil($height / $ratio);
			  $x = ($w - $width / $ratio) / 2;
			  $w = ceil($width / $ratio);
			  /* new file name */
			  //$path = 'upload/'.$width.'x'.$height.'_'.$_FILES['fileToUpload']['name'];
			  //$path = 'upload/'. basename($_FILES["user_avatar"]["name"]);
			  /* read binary data from image file */
			  $imgString = file_get_contents($_FILES['user_file_3']['tmp_name']);
			  /* create image from string */
			  $image = imagecreatefromstring($imgString);
			  $tmp = imagecreatetruecolor($width, $height);
			  imagecopyresampled($tmp, $image,
				0, 0,
				$x, 0,
				$width, $height,
				$w, $h);
			  /* Save image */
			  switch ($_FILES['user_file_3']['type']) 
			  {
				case 'image/jpeg':
				  imagejpeg($tmp, $path, 100);
				  break;
				case 'image/png':
				  imagepng($tmp, $path, 0);
				  break;
				case 'image/gif':
				  imagegif($tmp, $path);
				  break;
				default:
				  exit;
				  break;
			  }
			  return $path;
			  /* cleanup memory */
			  imagedestroy($image);
			  imagedestroy($tmp);
		}

		function compress($source, $destination, $quality) 
		{
			
			  $file_size = filesize($source); // Get file size in bytes
			$file_size = $file_size / 1024; // Get file size in KB
			  if($file_size > 100){
			  $info = getimagesize($source);

			  if ($info['mime'] == 'image/jpeg') 
				  $image = imagecreatefromjpeg($source);

			  elseif ($info['mime'] == 'image/gif') 
				  $image = imagecreatefromgif($source);

			  elseif ($info['mime'] == 'image/png') 
				  $image = imagecreatefrompng($source);

			  imagejpeg($image, $destination, $quality);
			}
			return $destination;
		}
		function get_file_type($filetype)
		{
			if($filetype == "image/jpg")
				$file_type='jpg';
			else if ($filetype == "image/gif")
				$file_type='gif';
			else if($filetype == "image/JPEG")
				$file_type='JPEG';
			else if($filetype == "image/jpeg")
				$file_type='jpeg';
			else if($filetype == "image/pjpeg")
				$file_type='pjpeg';
			else if($filetype ==  "image/png")
				$file_type='JPEG';
			else if($filetype ==  "application/msword")
				$file_type='doc';
			else if($filetype ==  "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
				$file_type='docx';
			else if($filetype ==  "application/pdf")
				$file_type='pdf';
			else if($filetype ==  "application/zip")
				$file_type='zip';
			return $file_type;
		}
		function fatch_all_bank()
		{  				
			$query = $this -> db -> get('bank_info');
			$data[''] =  'Select A Bank';
			
			foreach ($query-> result() as $field)
			{
				$data[$field -> bank_id] = $field -> bank_name;
			}
			
			return $data;	
		}
		function create_card()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
		    $creator = $this->tank_auth->get_user_id();
			
			$new_card = array(			
				'bank_id' => $this -> input ->post('bank_id'),
				'card_name' => mysql_real_escape_string(strtoupper($this -> input ->post('card_name'))),
				'status' => 'active',		
				'creator' => $creator,
				'doc' => $bd_date,
				'dom' => $bd_date
			);
			$this -> db -> insert('bank_card_info', $new_card);
			return $insert = $this->db->insert_id();
		}
		function create_customer()
		{
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date=date('Y-m-d');
			$creator = $this->tank_auth->get_user_id();
			
			/***********************************************************************************
			 * 
			 * rtrim(your_string,"the character you want to remove");
			 * 
			 * we used this function to remove a specific character from the end of a string
			 * 
			 ***********************************************************************************/
			
			$customer_name = $this -> input ->post('customer_name');
			$temp_name = rtrim($customer_name, ";");
			
			$new_customer_insert_data = array(
				'customer_name' 		=> mysql_real_escape_string(strtoupper($temp_name)),
				'customer_define_id' 	=> $this -> input -> post('customer_define_id'),
				'customer_contact_no' 	=> $this -> input -> post('customer_contact_no'),
				'customer_type' 		=> $this -> input -> post('customer_type'),
				'customer_mode' 		=> $this -> input -> post('customer_mode'),
				'customer_address' 		=> $this -> input -> post('customer_address'),
				'customer_email' 		=> $this -> input -> post('customer_email'),
				'int_balance' 			=> $this -> input -> post('initial_balance'),
				'customer_doc' 			=> $bd_date,
				'customer_dom' 			=> $bd_date,
				'customer_creator' 		=> $creator
			);
			$this -> db -> insert('customer_info', $new_customer_insert_data);
			return $insert = $this->db->insert_id();
		}
		/* customer Info */
			function customer_info()
			{
				
  				$data = array(
  				    ''  => 'Select A Type',
  				    'Individual' => 'Individual',
  				    'Corporate' => 'Corporate'
   	         	);
			    return $data;
			}
			/* customer Mode*/
			function customer_mode()
			{
				
  				$data = array(
  				    ''  => 'Select a Mode',
  				    'normal' => 'Normal',
  				    'registered' => 'Registered'
   	         	);
			    return $data;
			}
			
			function product_specification()
			{
				$data = array(
						''  => 'Select a type',
						'individual' => 'Individual',
						'bulk' => 'Bulk'
				);
				return $data;
			}

			
			function unit_name()
			{
				$query = $this->db->get('unit_info');
				if($query->num_rows() >0 ){
				$row = $query->result();
				
				$data[]='Select Unit Name';
				foreach($row as $row){
					$data[$row->unit_name]=$row->unit_name;
				}
				return $data;
				}
				else{
					$data[]='Select Unit Name';
					return $data;
				}
			}
			/* fatch all company name for product setup*/
			function company_name_1()
			{
				$this -> db -> order_by("company_name", "asc");
				$query = $this -> db -> get('company_info');
				$data[''] =  'Select Company';
				foreach ($query -> result() as $field){
						$data[rawurlencode($field -> company_name)] = $field -> company_name;
					}
				return $data;
			}
			
			function catagory_name()
			{
				$this -> db -> order_by("catagory_name", "asc");
				$query = $this -> db -> get('catagory_info');
				$data[''] =  'Select Category';
				foreach ($query-> result() as $field){
						$data[rawurlencode($field -> catagory_name)] = $field -> catagory_name;
					}
				return $data;
			}
			function getLastInserted() 
			{
				$this->db->select_max('product_id');
				$result= $this->db->get('product_info')->row_array();
				return $result;
			}
}
