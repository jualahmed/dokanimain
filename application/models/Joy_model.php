<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Joy_model extends CI_model{
		
		private $userId;
		private $bdDate;
		private $shop_id;
		
		public function __construct(){
			
			parent::__construct();
			$this -> userId = $this -> tank_auth -> get_user_id();
			$this -> shop_id = $this -> tank_auth -> get_shop_id();
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$this -> bdDate = date ('Y-m-d');
		}
		
		
		/*
		 * Checking if element is already exists
		 * 05-05-2104
		 * Arafat Mamun
		 * $table =  table name
		 * $item = element to search
		 * $field = field name
		 */
		 	               /*  table_name,field name,element */
		function redundancyCheck($table, $field, $item, $status){
			
			$this -> db -> select( $field );
			$this -> db -> where('status', $status);
			$query = $this -> db -> get($table );
			
			$temp_new = strtolower( preg_replace('/\s+/', '', $item));
			foreach($query -> result() as $info):
				$temp_old = strtolower( preg_replace('/\s+/', '',$info -> $field));
			if($temp_old == $temp_new) return true;
			endforeach;

			return false;
		}
		
		
		/*
		 * Product Info
		 * 05-05-2014
		 * Arafat Mamun
		 */
		function productInfoGeneral($specificProduct , $productId)
		{	
			$this -> db -> order_by('product_name', 'asc');
			$this -> db -> select('product_name, product_info.product_id,product_specification,
								   catagory_name,company_name,product_size,product_model');
			$this -> db -> from('product_info');
			if($specificProduct) $this -> db -> where('product_info.product_id', $productId);
			return $this -> db -> get();
		}
		
		/*
		 * Product Info Details
		 * 05-05-2014
		 * Arafat Mamun
		 */
		function productInfoDetails($specificProduct , $productId)
		{	
			$this -> db -> order_by('product_name', 'asc');
			$this -> db -> select('product_name, product_info.product_id, stock_amount,bulk_alarming_stock,	
								   product_specification,bulk_unit_buy_price, bulk_unit_sale_price,general_unit_sale_price, last_buy_price,
								   catagory_name,company_name,product_size,product_model');
			$this -> db -> from('product_info,bulk_stock_info');
			if($specificProduct) $this -> db -> where('product_info.product_id', $productId);
			$this -> db -> where('product_info.product_id = bulk_stock_info.product_id');
			$this -> db -> where('bulk_stock_info.shop_id', $this -> shop_id );
			return $this -> db -> get();
		}
		function productInfoDetails_for_purchase($specificProduct , $productId)
		{	
			$this -> db -> order_by('product_name', 'asc');
			$this -> db -> select('product_name, product_info.product_id, 
								   product_specification,
								   catagory_name,company_name,product_size,product_model,bulk_unit_sale_price,last_buy_price');
			$this -> db -> from('product_info');
			if($specificProduct) $this -> db -> where('product_info.product_id', $productId);
			$this -> db -> join('bulk_stock_info','product_info.product_id = bulk_stock_info.product_id','left');
			//$this -> db -> where('bulk_stock_info.shop_id', $this -> shop_id );
			return $this -> db -> get();
		}
		
		
		/*
		 * Purchase Receipt
		 * 05-05-2014
		 * Arafat Mamun
		 */
		function purchaseReceipt($specificReceipt , $receiptId)
		{	
			$this -> db -> order_by('receipt_id', 'desc');
			$this -> db -> select('receipt_id, distributor_name,purchase_receipt_code, receipt_date');
			$this -> db -> from('purchase_receipt_info, distributor_info');
			if($specificReceipt) $this -> db -> where('purchase_receipt_info.receipt_id', $receiptId);
			$this -> db -> where('purchase_receipt_info.distributor_id = distributor_info.distributor_id');
			
			return $this -> db -> get();
		}
		
		/*
		 * Purchase Entry
		 * 05-05-2014
		 * Arafat Mamun
		 */
		public function purchaseEntry($selectedReceipt, $selectedProduct,
									  $purchaseQuantity, $unitBuyPrice,
									  $purchaseType){
			
			/*
			 * $purchaseType == 1 : buy
			 * $purchaseType == 2 : Damage
			 * $purchaseType == 3 : Free
			 * $purchaseType == 4 : Offer
			*/
			
			if($purchaseType != 1){
				$marketUnitPrice = $unitBuyPrice;
				$unitBuyPrice = 0.00;
			}	  
			else $marketUnitPrice = $unitBuyPrice;
				  
			$productInfoData = array(
				'purchase_receipt_id' => $selectedReceipt,
				'product_id' => $selectedProduct,
				'purchase_quantity' => $purchaseQuantity,
				'market_unit_price' => $marketUnitPrice,
				'actual_unit_price' => $unitBuyPrice,
				'purchase_type' => $purchaseType,
				'price_id' => 0,
				'sold_quantity' => 0,
				'purchase_expire_date' => 0,
				'purchase_description' => 'No',
				'purchase_creator' => $this -> userId,
				'purchase_doc' => $this -> bdDate,
				'purchase_dom' => $this -> bdDate
			);
			$productInfoInsert = $this -> db -> insert('purchase_info', $productInfoData);
			if($productInfoInsert){
				$exists = $this -> productInfoDetails(TRUE, $selectedProduct);
				if($exists -> num_rows() > 0){
					
					foreach($exists -> result() as $field):
						$prevStock = $field -> stock_amount;
						$prevAvgPrice = $field -> bulk_unit_buy_price;
					endforeach;
					
					$prevTotalValue = $prevStock * $prevAvgPrice;
					$newStock = $prevStock + $purchaseQuantity;
					$newTotalValue = $prevTotalValue + ($marketUnitPrice * $purchaseQuantity);
					$newAvgPrice = $newTotalValue / $newStock;
					
					return $this -> db -> query("UPDATE bulk_stock_info
											  	 SET stock_amount = ".$newStock.",
													 bulk_unit_buy_price = ".$newAvgPrice.",
													 last_buy_price = ".$marketUnitPrice.",
													 stock_dom = '".$this -> bdDate."'
												 WHERE product_id = ".$selectedProduct."
												");
				}
				else{
					$bulkStockInfoData = array(
						'product_id' => $selectedProduct,
						'stock_amount' => $purchaseQuantity,
						'bulk_unit_buy_price' => $marketUnitPrice,
						'bulk_unit_sale_price' => 0.00,
						'bulk_alarming_stock' => 0,
						'last_buy_price' => $marketUnitPrice,
						'stock_doc' => $this -> bdDate,
						'stock_dom' => $this -> bdDate
					);
					return $this -> db -> insert('bulk_stock_info', $bulkStockInfoData);
				}
			}
			return false;
		}
		
		/*
		 * Sale Price Entry
		 * 06-05-2014
		 * Arafat Mamun
		 */
		public function salePriceEntry($selectedProduct, $bulkUnitSalePrice){
			$exists = $this -> productInfoDetails(TRUE, $selectedProduct);
			if($exists -> num_rows() > 0){
				
				return $this -> db -> query("UPDATE bulk_stock_info
											 SET 	bulk_unit_sale_price = '".$bulkUnitSalePrice."',
													general_unit_sale_price = 0,
												 stock_dom = '".$this -> bdDate."'
											 WHERE product_id = '".$selectedProduct."'
											 AND shop_id = '".$this -> shop_id."'
											");
			}
			else{
				$bulkStockInfoData = array(
					'product_id' => $selectedProduct,
					'stock_amount' => 0,
					'bulk_unit_buy_price' => 0,
					'bulk_unit_sale_price' => $bulkUnitSalePrice,
					'general_unit_sale_price' => 0,
					'bulk_alarming_stock' => 0,
					'shop_id' => $this -> shop_id,
					'last_buy_price' => 0,
					'stock_doc' => $this -> bdDate,
					'stock_dom' => $this -> bdDate
				);
				return $this -> db -> insert('bulk_stock_info', $bulkStockInfoData);
			}
			return false;
		}
		
		/*
		 * Alarming Level Entry
		 * 06-05-2014
		 * Arafat Mamun
		 */
		public function alarmingLevelEntry($selectedProduct, $bulkAlarmingStock){
			$exists = $this -> productInfoDetails(TRUE, $selectedProduct);
			if($exists -> num_rows() > 0){
				
				return $this -> db -> query("UPDATE bulk_stock_info
											 SET bulk_alarming_stock = ".$bulkAlarmingStock.",
												 stock_dom = '".$this -> bdDate."'
											 WHERE product_id = ".$selectedProduct."
											");
			}
			else{
				$bulkStockInfoData = array(
					'product_id' => $selectedProduct,
					'stock_amount' => 0,
					'bulk_unit_buy_price' => 0,
					'bulk_unit_sale_price' => 0,
					'bulk_alarming_stock' => $bulkAlarmingStock,
					'last_buy_price' => 0,
					'stock_doc' => $this -> bdDate,
					'stock_dom' => $this -> bdDate
				);
				return $this -> db -> insert('bulk_stock_info', $bulkStockInfoData);
			}
			return false;
		}
		
		/*
		 * Market Delivery Setup
		 * 06-05-2014
		 * Arafat Mamun
		 */
		public function marketDeliverySetup( $selectedMarket, $orderTakenBy, $orderDate, $deliveryBy, $deliveryDate ){
			
			$data = array(
               'market_id' => $selectedMarket,
               'order_man' => $orderTakenBy,
               'order_date' => $orderDate,
               'delivery_man' => $deliveryBy,
               'delivery_date' => $deliveryDate,
               'status' => 1,
               'creator' => $this -> userId
            );
			return $this->db-> insert('market_summery_temp', $data);
		}
		
		/*
		 * All / Specific User Runing Market Deliveries Setup
		 * 06-05-2014
		 * Arafat Mamun
		 */
		public function runningMarketDeliveries($specificUser, $userId){
			
			$this -> db -> order_by("market_name", "acs");
			$this -> db -> select('username, user_full_name, email,market_info.market_id,
									market_name, market_summery_temp.creator,market_summery_temp_id
								  ');
			$this -> db -> from('users, market_info, market_summery_temp');
			$this -> db -> where('market_info.market_id = market_summery_temp.market_id');
			$this -> db -> where('market_summery_temp.creator = users.id');
			if($specificUser) $this -> db -> where('id', $userId);
			$this -> db -> where('status', 1);
			return $this -> db -> get();
							
		}
		
		/*
		 * Get All / Specific Sales Man Information
		 * 06-05-2014
		 * Arafat Mamun
		 */
		public function getSalseMen($specific, $userId){
			
			$this -> db -> order_by("user_full_name", "asc");
			$this -> db -> select('username, id, user_full_name, email');
			if(!$specific) $this -> db -> where('user_type', 'seller');
			if($specific) $this -> db -> where('id', $userId);
			return $this -> db -> get('users');
		}
		
		/*
		 * Market Delivery Outlet Setup
		 * 06-05-2014
		 * Arafat Mamun
		 */
		public function marketDeliveryOutletSetup( $marketSummeryTempId, $selectedOutlet  ){
			
			$data = array(
               'market_summery_temp_id' => $marketSummeryTempId,
               'outlet_id' => $selectedOutlet,
               'status' => 1
            );
			$this -> db -> insert('cashmemo_temp_info', $data);
			return $this -> db -> insert_id();
		}
		
		/*
		 * All / Specific User Runing Market Delivery Setup
		 * 06-05-2014
		 * Arafat Mamun
		 */
		public function runningMarketOutletDelivery($specificUser, $userId, $specificMarketSummeryTemp, $marketSummeryTempId){
			
			$this -> db -> order_by("market_name", "acs");
			$this -> db -> select('username, user_full_name, email,market_info.market_id,
								   market_name, market_summery_temp.creator,market_summery_temp.market_summery_temp_id,
								   outlet_name, cashmemo_temp_id, outlet_info.outlet_id, outlet_contact
								  ');
			$this -> db -> from('users, market_info, market_summery_temp, cashmemo_temp_info, outlet_info');
			$this -> db -> where('market_info.market_id = market_summery_temp.market_id');
			$this -> db -> where('market_summery_temp.creator = users.id');
			$this -> db -> where('market_summery_temp.market_summery_temp_id = cashmemo_temp_info.market_summery_temp_id');
			$this -> db -> where('cashmemo_temp_info.outlet_id = outlet_info.outlet_id');
			if($specificUser) $this -> db -> where('id', $userId);
			if($specificMarketSummeryTemp)
				$this -> db -> where('market_summery_temp.market_summery_temp_id', $marketSummeryTempId);
			$this -> db -> where('cashmemo_temp_info.status', 1);
			$this -> db -> where('market_summery_temp.status', 1);
			return $this -> db -> get();
							
		}
		
		/*
		 * Cash Memo Temp Details
		 * 14-05-2014
		 * Arafat Mamun
		 */
		public function cashmemoTempDetails( $currentCashmemoTempId){
			
			$this -> db -> select('market_info.market_id, market_name, market_summery_temp.creator,
								   market_summery_temp.market_summery_temp_id, outlet_name,
								   cashmemo_temp_id, outlet_info.outlet_id, order_man, order_date,
								   delivery_man,delivery_date
								  ');
			$this -> db -> from('market_info, market_summery_temp, cashmemo_temp_info, outlet_info');
			$this -> db -> where('market_info.market_id = market_summery_temp.market_id');
			$this -> db -> where('market_summery_temp.market_summery_temp_id = cashmemo_temp_info.market_summery_temp_id');
			$this -> db -> where('cashmemo_temp_info.outlet_id = outlet_info.outlet_id');
			$this -> db -> where('cashmemo_temp_id', $currentCashmemoTempId);
			$this -> db -> where('cashmemo_temp_info.status', 1);
			$this -> db -> where('market_summery_temp.status', 1);
			return $this -> db -> get();
		}
		
		/*
		 * Outlet Delivery Listed Product - All / Single 
		 * 14-05-2014
		 * Arafat Mamun
		 */
		public function listedProduct($cashmemoTempId, $specificProduct, $productId, $specificSaleType, $saleType, $exists){
			
			$this -> db -> order_by("product_name", "acs");
			$this -> db -> select('product_name, product_info.product_id,unit_buy_price,
								   cashmemo_temp_detials_id,serving_quantity,sale_type,
								   unit_sale_price
								  ');
			$this -> db -> from('product_info, cashmemo_temp_detials');
			$this -> db -> where('product_info.product_id = cashmemo_temp_detials.product_id');
			$this -> db -> where('cashmemo_temp_id', $cashmemoTempId);
			if($specificProduct) $this -> db -> where('product_info.product_id', $productId);
			if($specificSaleType) $this -> db -> where('sale_type', $saleType);
			if($exists) $this -> db -> where('serving_quantity > 0');
			$this -> db -> where('status', 1);
			return $this -> db -> get();
		}
		
		
		/*
		 * Delivery Setup
		 * 14-05-2014
		 * Arafat Mamun
		 */
		public function deliverySetup( $cashmemoTempId, $productId,
												$servingQuantity, $saleType, $bulkUnitBuyPrice, $bulkUnitSalePrice){
			
									
			$prevListInfo = $this -> listedProduct($cashmemoTempId, TRUE, $productId,TRUE,$saleType, FALSE);
			if($prevListInfo -> num_rows() > 0){
				
				foreach($prevListInfo -> result() as $field):
					$cashmemoTempDetialsId = $field -> cashmemo_temp_detials_id;
					$prevServingQuantity = $field-> serving_quantity;
					$saleType = $field-> sale_type;
				endforeach;
				
				$this -> db -> query("UPDATE bulk_stock_info
									  SET stock_amount = stock_amount + ".$prevServingQuantity."
									  WHERE product_id = ".$productId."
									 ");
									 
				$this -> db -> query("UPDATE cashmemo_temp_detials
									  SET serving_quantity = 0,
										  unit_buy_price = 0,
										  unit_sale_price = 0
									  WHERE product_id = ".$productId."
									  AND cashmemo_temp_detials_id = ".$cashmemoTempDetialsId."
									 ");
			}
			else{
				
				$this -> db -> where('stock_amount >= '.$servingQuantity.'');								
				$this -> db -> where('product_id', $productId);							
				$productStatus = $this -> db -> get('bulk_stock_info');
				if($productStatus -> num_rows() < 1)
					return 'notSufficient';
					
				$data = array(
				   'cashmemo_temp_id' => $cashmemoTempId,
				   'product_id' => $productId,
				   'serving_quantity' => 0,
				   'sale_type' => $saleType,
				   'unit_buy_price' => 0,
				   'unit_sale_price' => 0,
				   'status' => 1
					);
				$this -> db -> insert('cashmemo_temp_detials', $data);
				
			}	 
			
			
			$this -> db -> where('stock_amount >= '.$servingQuantity.'');								
			$this -> db -> where('product_id', $productId);							
			$productStatus = $this -> db -> get('bulk_stock_info');
			if($productStatus -> num_rows() < 1)
				return 'notSufficient';
										
			$this -> db -> query("UPDATE bulk_stock_info
								  SET stock_amount = stock_amount - ".$servingQuantity."
								  WHERE product_id = ".$productId."
								 ");
								 
			$this -> db -> query("UPDATE cashmemo_temp_detials
								  SET serving_quantity = ".$servingQuantity.",
									  unit_buy_price = ".$bulkUnitBuyPrice.",
									  unit_sale_price = ".$bulkUnitSalePrice."
								  WHERE product_id = ".$productId."
								  AND sale_type = ".$saleType."
								  AND cashmemo_temp_id = ".$cashmemoTempId."
								 ");
			
			return 'successful';						
		}
		
		/*
		 * Delivery Setup Genaration For A Specic Outlet
		 * 14-05-2014
		 * Arafat Mamun
		 */
		public function generateDelivery($marketId, $marketSummeryTempId, $outletId, $cashmemoTempId,
									  $orderMan, $orderDate , $deliveryMan, $deliveryDate){
			
			$this -> db -> where('market_summery_temp_id', $marketSummeryTempId);
			$query = $this -> db -> get('market_summery');
			if($query -> num_rows() > 0){
				foreach($query -> result() as $field):
					$marketSummeryId = $field -> market_summery_id;
				endforeach;
			}
			else{
				$data = array(
				   'market_summery_temp_id' => $marketSummeryTempId,
				   'market_id' => $marketId,
				   'order_man' => $orderMan,
				   'order_date' => $orderDate,
				   'delivery_man' => $deliveryMan,
				   'delivery_date' => $deliveryDate,
				   'status' => 1,
				   'creator' => $this -> userId
					);
				$this -> db -> insert('market_summery', $data);
				$marketSummeryId = $this -> db -> insert_id();
			}
			
			$this -> db -> where('market_summery_id', $marketSummeryId);
			$this -> db -> where('outlet_id', $outletId);
			$query = $this -> db -> get('cashmemo_info');
			if($query -> num_rows() > 0){
				foreach($query -> result() as $field):
					$cashmemoId =  $field -> cashmemo_id;
				endforeach;
				return $cashmemoId;
			}
			
			$data = array(
				   'market_summery_id' => $marketSummeryId,
				   'outlet_id' => $outletId,
				   'total_sale' => 0,
				   'total_damage_rec' => 0,
				   'total_free' => 0,
				   'total_offer' => 0,
				   'grand_total' => 0,
				   'total_paid' => 0,
				   
				   'status' => 1,
				   'creator' => $this -> userId
					);
			$this -> db -> insert('cashmemo_info', $data);
			$cashmemoId = $this -> db -> insert_id();
			
			
			
			$query = $this -> listedProduct($cashmemoTempId, FALSE, 0, FALSE, 0, TRUE);
			foreach($query -> result() as $field):
				$data = array(
				   'cashmemo_id' => $cashmemoId,
				   'product_id' => $field -> product_id,
				   'serving_quantity' => $field -> serving_quantity,
				   'confirmation' => 0,
				   'sale_quantity' => 0,
				   'sale_type' => $field -> sale_type,
				   'unit_buy_price' => $field -> unit_buy_price,
				   'unit_sale_price' => $field -> unit_sale_price,
				   'status' => 1
					);
				$this -> db -> insert('cashmemo_details', $data);
			endforeach;
			
			$this -> db -> query("UPDATE cashmemo_temp_info
								  SET status = 2
								  WHERE cashmemo_temp_id = ".$cashmemoTempId."
								 ");
			$this -> db -> query("UPDATE cashmemo_temp_detials
								  SET status = 2
								  WHERE cashmemo_temp_id = ".$cashmemoTempId."
								 ");
			
			return $cashmemoId;
		}
		
		/*
		 * Cashmemo General Information
		 * 14-05-2014
		 * Arafat Mamun
		 */
		public function cashmemoInfo($cashmemoId, $status, $statusType){
			
			$this -> db -> select('market_info.market_id, market_name, market_summery.creator,
								   market_summery.market_summery_id, outlet_name, outlet_address,
								   cashmemo_id, outlet_info.outlet_id, order_man, order_date,
								   delivery_man,delivery_date, user_full_name, users.id, cashmemo_info_doc,
								   cashmemo_id, total_sale, total_damage_rec,total_free,total_offer,
								   grand_total,total_paid, outlet_owner_name, outlet_contact
								  ');
			$this -> db -> from('market_info, market_summery, cashmemo_info, outlet_info,users');
			$this -> db -> where('users.id = market_summery.creator');
			$this -> db -> where('market_info.market_id = market_summery.market_id');
			$this -> db -> where('market_summery.market_summery_id = cashmemo_info.market_summery_id');
			$this -> db -> where('cashmemo_info.outlet_id = outlet_info.outlet_id');
			$this -> db -> where('cashmemo_id', $cashmemoId);
			if($status) $this -> db -> where('cashmemo_info.status', $statusType);
			return $this -> db -> get();
		}
		
		/*
		 * Cash Memo Listed Product Details All / Single Product
		 * 14-05-2014
		 * Arafat Mamun
		 */
		public function cashmemoDetails($cashmemoId, $specificProduct, $productId,$specificSaleType, $saleType, $status, $statusType){
			
			$this -> db -> order_by("product_name", "acs");
			$this -> db -> select('product_name, product_info.product_id, cashmemo_details_id,
								   serving_quantity, confirmation, sale_quantity, sale_type,
								   cashmemo_details.unit_buy_price, cashmemo_details.unit_sale_price,
								   stock_amount
								  ');
			$this -> db -> from('product_info, cashmemo_details , bulk_stock_info');
			$this -> db -> where('bulk_stock_info.product_id = product_info.product_id');
			$this -> db -> where('product_info.product_id = cashmemo_details.product_id');
			$this -> db -> where('cashmemo_id', $cashmemoId);
			if($specificProduct) $this -> db -> where('product_info.product_id', $productId);
			if($specificSaleType) $this -> db -> where('sale_type', $saleType);
			if($status) $this -> db -> where('status', $statusType);
			return $this -> db -> get();
		}
		/*
		 * Market Summery
		 * 14-05-2014
		 * Arafat Mamun
		 *	 summeryStatus
		 * 		2 = delivered
		 * 		3 = sold
		 */
		public function marketSummery($specificMarketSummery, $marketSummeryId, $summeryStatus ,$summeryStatusType,
										$cashmemoStatus, $cashmemoStatusType){
			
			$this -> db -> order_by("market_name", "asc");
			$this -> db -> select('market_name, market_info.market_id, market_address, market_summery.status  as market_summery_status,
								   order_man,order_date, delivery_man,delivery_date,market_summery.creator,
								   market_summery.market_summery_id, market_summery_doc,
								   outlet_name,outlet_info.outlet_id,outlet_contact,
								   cashmemo_id,cashmemo_info.status as cashmemo_status
								  ');
			$this -> db -> from('market_info, outlet_info, market_summery, cashmemo_info');
			$this -> db -> where('market_info.market_id = market_summery.market_id');
			$this -> db -> where('market_summery.market_summery_id = cashmemo_info.market_summery_id');
			$this -> db -> where('cashmemo_info.outlet_id = outlet_info.outlet_id');
			if($specificMarketSummery) $this -> db -> where('market_summery.market_summery_id', $marketSummeryId);
			if($summeryStatus) $this -> db -> where('market_summery.status', $summeryStatusType);
			if($cashmemoStatus) $this -> db -> where('cashmemo_info.status', $cashmemoStatusType);
			if(!$specificMarketSummery) $this -> db -> group_by('market_id');
			return $this -> db -> get();
		}
		
		/*
		 * Market Summery On progress
		 * 14-05-2014
		 * Arafat Mamun
		 * 
		 * 
		 */
		public function awaitingMarketSummery($specificMarketSummery, $marketSummeryId, $cashmemoTempStatus, $statusType){
			
			$this -> db -> order_by("market_name", "asc");
			$this -> db -> select('market_name, market_info.market_id, market_address,
								   order_man,order_date, delivery_man,delivery_date,market_summery.creator,
								   market_summery.market_summery_id, market_summery_doc,
								   outlet_name,outlet_info.outlet_id,outlet_contact,
								   cashmemo_temp_id,cashmemo_temp_info.status as cashmemo_status
								  ');
			$this -> db -> from('market_info, outlet_info, market_summery, cashmemo_temp_info');
			$this -> db -> where('market_info.market_id = market_summery.market_id');
			$this -> db -> where('market_summery.market_summery_temp_id = cashmemo_temp_info.market_summery_temp_id');
			$this -> db -> where('cashmemo_temp_info.outlet_id = outlet_info.outlet_id');
			if($specificMarketSummery) $this -> db -> where('market_summery.market_summery_id', $marketSummeryId);
			if($cashmemoTempStatus) $this -> db -> where('cashmemo_temp_info.status', $statusType);
			if(!$cashmemoTempStatus) $this -> db -> where('cashmemo_temp_info.status > 0');
			$this -> db -> where('market_summery.status', 1);
			if(!$specificMarketSummery) $this -> db -> group_by('market_id');
			return $this -> db -> get();
		}
		
		/*
		 * If a outlet Delivery Is Running
		 * 15-05-2014
		 * Arafat Mamun
		 */
		public function isRunningOutletDelivery($marketSummeryTempId, $specificOutlet, $selectedOutlet){
			
			$this -> db -> where('market_summery_temp_id', $marketSummeryTempId);
			if($specificOutlet) $this -> db -> where('outlet_id', $selectedOutlet);
			$this -> db -> where('status > 0');
			$query = $this -> db -> get('cashmemo_temp_info');
			if($query -> num_rows() > 0) return true;
			else return false;
		}
		
		/*
		 * Specific Market Summery
		 * 15-05-2014
		 * Arafat Mamun
		 */
		public function specificMarketSummery( $summeryId, $specificSaleType, $saleType ){
			
			$this -> db -> order_by("product_name", "asc");
			$this -> db -> select('product_name,
								   cashmemo_details.unit_buy_price, cashmemo_details.unit_sale_price,
								   SUM(serving_quantity) as serving_quantity,
								   SUM(sale_quantity) as sale_quantity,
								');
			$this -> db -> from('product_info, cashmemo_info, market_summery, cashmemo_details');
			$this -> db -> where('product_info.product_id = cashmemo_details.product_id');
			$this -> db -> where('cashmemo_details.cashmemo_id = cashmemo_info.cashmemo_id');
			$this -> db -> where('cashmemo_info.market_summery_id = market_summery.market_summery_id');
			$this -> db -> where('market_summery.market_summery_id', $summeryId);
			if($specificSaleType) $this -> db -> where('cashmemo_details.sale_type', $saleType);
			$this -> db -> group_by("product_info.product_id");
			return $this -> db -> get();
		}
		
		/*
		 * Make Market Summery
		 * 15-05-2014
		 * Arafat Mamun
		 */
		public function makeMarketSummery($marketSummeryId, $newDeliveryMan){
			
			$this -> db -> query("UPDATE market_summery, cashmemo_info, cashmemo_details
									SET market_summery.delivery_man = ".$newDeliveryMan.",
										market_summery.status = 2,
										cashmemo_info.status = 2,
										cashmemo_details.status = 2
									WHERE cashmemo_details.cashmemo_id = cashmemo_info.cashmemo_id
									AND cashmemo_info.market_summery_id = market_summery.market_summery_id
									AND market_summery.market_summery_id = ".$marketSummeryId."
								");
			$this -> db -> query("UPDATE market_summery_temp, market_summery
									SET market_summery_temp.status = 2
									WHERE market_summery_temp.market_summery_temp_id = market_summery.market_summery_temp_id
									AND market_summery_id = ".$marketSummeryId."
								");
			return true;
		}
		
		/*
		 * Confirm Sale
		 * 19-05-2014
		 * Arafat Mamun
		 */
		public function confirmSale( $marketSummeryId, $cashmemoId, $productId,$soldQuantity, $saleType){
			
			$prevSaleInfo = $this -> cashmemoDetails($cashmemoId, TRUE, $productId ,TRUE, $saleType , TRUE, 2);
			foreach ($prevSaleInfo -> result() as $field):
				$cashmemoDetailsId = $field -> cashmemo_details_id;
				$servingQuantity = $field -> serving_quantity;
				$confirmation = $field -> confirmation;
				$prevSaleQuantity = $field -> sale_quantity;
				$prevStockAmount = $field -> stock_amount;
			endforeach;
			
			$stockAdjust = 0;
			if(!$confirmation){
				if($soldQuantity > $prevStockAmount + $servingQuantity) return false;
				
				$stockAdjust = $servingQuantity - $soldQuantity;
			}
			else $stockAdjust =  $prevSaleQuantity - $soldQuantity;
			
			$this -> db -> query("UPDATE cashmemo_details
								  SET sale_quantity =  ".$soldQuantity.",
									  confirmation = 1
								  WHERE product_id = ".$productId."
								  AND cashmemo_details_id = ".$cashmemoDetailsId."
								 ");
			$this -> db -> query("UPDATE bulk_stock_info
								  SET stock_amount = stock_amount + ".$stockAdjust."
								  WHERE product_id = ".$productId."
								 ");
			return True;

		}
		
		/*
		 * Confirm Sale Information
		 * 27-04-2014
		 * Arafat Mamun
		 */
		public function confirmSaleInformation($marketSummeryId, $marketId, $outletId,
							$cashmemoId,$amountPaid, $totalSupplyCost, $totalFreeCost, $totalDamageCost,
							$totalOfferCost, $totalSaleCost){
			
			$timezone = "Asia/Dhaka";
			date_default_timezone_set($timezone);
			$bd_date = date('Y-m-d');
				
			$this -> db -> query("UPDATE cashmemo_info
									SET total_sale = ".$totalSupplyCost.",
										total_free = ".$totalFreeCost.",
										total_damage_rec = ".$totalDamageCost.",
										total_offer = ".$totalOfferCost.",
										grand_total = ".$totalSaleCost.",
										total_paid = ".$amountPaid.",
										status = 3
									WHERE cashmemo_id = ".$cashmemoId." 
									AND market_summery_id = ".$marketSummeryId."
								");
			
			
			$this -> db -> query("UPDATE cashmemo_details
									SET status = 3
									WHERE cashmemo_id = ".$cashmemoId." 
								");
				
			
			
			/* this will insert the following data to transaction_ref_details table */
			$new_transaction_ref_details_insert_data = array(
				'ref_id' => $cashmemoId ,
				'transaction_amount' => $amountPaid,
				'transaction_type' => 'in',
				'transaction_purpose' =>'sale',
				'transaction_table_ref_name' => 'cashmemo_info',
				'transaction_table_ref_id_field' => 'cashmemo_id',
				'transaction_ref_details_doc' => $bd_date,
				'transaction_ref_details_dom' => $bd_date,
				'transaction_ref_details_creator' => $this -> userId
			);	
			$this -> db -> insert('transaction_ref_details',$new_transaction_ref_details_insert_data);
			/* end of transaction_ref_details table */
			$new_transaction_details_insert_data = array(
				'transaction_reference_id' => mysql_insert_id(),
				'transaction_amount' => $amountPaid,
				'transaction_type' =>'in',
				'transaction_mode' => 'cash',
				'transaction_doc' => $bd_date,
				'transaction_dom' => $bd_date,
				'transaction_creator' => $this -> userId
			);	
			$insert = $this -> db -> insert('transaction_details',$new_transaction_details_insert_data);
			
			$query = $this  -> marketSummery(TRUE, $marketSummeryId, TRUE, 2, TRUE, 2);
			if($query -> num_rows() < 1)
				$this -> db -> query("UPDATE market_summery
										SET status = 3
										WHERE market_summery_id = ".$marketSummeryId." 
									");
			return true;
		}
		
		/*
		 * Market Delivery Outlet Setup Cancle
		 * 20-05-2014
		 * Arafat Mamun
		 */
		public function marketDeliveryOutletSetupCancle($cashmemoTempId){
			$query = $this -> listedProduct($cashmemoTempId, FALSE, 0, FALSE, 0, FALSE);
			foreach($query -> result() as $field):
				$cashmemoTempDetialsId = $field -> cashmemo_temp_detials_id;
				$servingQuantity = $field-> serving_quantity;
				$productId = $field -> product_id;
				$this -> db -> query("UPDATE bulk_stock_info
								  SET stock_amount = stock_amount + ".$servingQuantity."
								  WHERE product_id = ".$productId."
								 ");
								 
				$this -> db -> query("UPDATE cashmemo_temp_detials
									  SET serving_quantity = 0,
										  unit_buy_price = 0,
										  unit_sale_price = 0,
										  status = 0
									  WHERE product_id = ".$productId."
									  AND cashmemo_temp_detials_id = ".$cashmemoTempDetialsId."
									 ");
			endforeach;
			$this -> db -> query("UPDATE cashmemo_temp_info
								  SET status = 0
								  WHERE cashmemo_temp_id = ".$cashmemoTempId."
								 ");
			
			return true;
		}
		
		/*
		 * Market Delivery Setup Cancle
		 * 20-05-2014
		 * Arafat Mamun
		 */
		public function marketDeliverySetupCancle($marketSummeryTempId){
			$this -> db -> query("UPDATE market_summery_temp
								  SET status = 0
								  WHERE market_summery_temp_id = ".$marketSummeryTempId."
								 ");
			return true;
		}
		
		/*
		 * Cashmemo In Interval
		 * 22-05-2014
		 * Arafat mamun
		 */
		public function matketSummeryInInterval($startDate, $endDate){
			
			$this -> db -> order_by("delivery_date", "asc");
			$this -> db -> select('market_name, market_info.market_id, market_address, market_summery.status  as market_summery_status,
								   order_man,order_date, delivery_man,delivery_date,market_summery.creator,
								   market_summery.market_summery_id, market_summery_doc,delivery_date, username, email,
								   cashmemo_id,
								  ');
			$this -> db -> from('market_info,market_summery, users, cashmemo_info');
			$this -> db -> where('users.id = market_summery.creator');
			$this -> db -> where('market_info.market_id = market_summery.market_id');
			$this -> db -> where('delivery_date >= "'.$startDate.'"');
			$this -> db -> where('delivery_date <= "'.$endDate.'"');
			return $this -> db -> get();
		}
		
		/*
		 * Cashmemo In Interval
		 * 22-05-2014
		 * Arafat mamun
		 */
		public function cashmemoInInterval($startDate, $endDate){
			
			$this -> db -> order_by("delivery_date", "asc");
			$this -> db -> select('market_name, market_info.market_id, market_address, market_summery.status  as market_summery_status,
								   order_man,order_date, delivery_man,delivery_date,market_summery.creator,
								   market_summery.market_summery_id, market_summery_doc,
								   outlet_name,outlet_info.outlet_id,outlet_contact,
								   cashmemo_id,cashmemo_info.status as cashmemo_status,
								   grand_total
								  ');
			$this -> db -> from('market_info, outlet_info, market_summery, cashmemo_info');
			$this -> db -> where('market_info.market_id = market_summery.market_id');
			$this -> db -> where('market_summery.market_summery_id = cashmemo_info.market_summery_id');
			$this -> db -> where('cashmemo_info.outlet_id = outlet_info.outlet_id');
			$this -> db -> where('delivery_date >= "'.$startDate.'"');
			$this -> db -> where('delivery_date <= "'.$endDate.'"');
			return $this -> db -> get();
		}
		
		/*
		 * Market Summery List
		 * 14-05-2014
		 * Arafat Mamun
		 *	 summeryStatus
		 * 		2 = delivered
		 * 		3 = sold
		 */
		public function marketSummeryList($specificMarketSummery, $marketSummeryId, $summeryStatus, $summeryStatusType){
			
			$this -> db -> order_by('market_summery_id', "desc");
			$this -> db -> select('market_name, market_info.market_id, market_address, market_summery.status  as market_summery_status,
								   order_man,order_date, delivery_man,delivery_date,market_summery.creator,
								   market_summery.market_summery_id, market_summery_doc
								  ');
			$this -> db -> from('market_info,market_summery');
			$this -> db -> where('market_info.market_id = market_summery.market_id');
			if($specificMarketSummery) $this -> db -> where('market_summery.market_summery_id', $marketSummeryId);
			if($summeryStatus) $this -> db -> where('market_summery.status', $summeryStatusType);
			return $this -> db -> get();
		}
		
		/*
		 * Edit Sale
		 * 19-05-2014
		 * Arafat Mamun
		 */
		public function editCashmemo( $marketSummeryId, $cashmemoId, $productId,$soldQuantity, $saleType){
			
			$prevSaleInfo = $this -> cashmemoDetails($cashmemoId, TRUE, $productId ,TRUE, $saleType , TRUE, 3);
			foreach ($prevSaleInfo -> result() as $field):
				$cashmemoDetailsId = $field -> cashmemo_details_id;
				$servingQuantity = $field -> serving_quantity;
				$confirmation = $field -> confirmation;
				$prevSaleQuantity = $field -> sale_quantity;
				$prevStockAmount = $field -> stock_amount;
				$unitSalePrice = $field -> unit_sale_price;
			endforeach;
			
			$stockAdjust = 0;
			$priceAdjust = 0;
			if(!$confirmation){
				if($soldQuantity > $prevStockAmount + $servingQuantity) return false;
				
				$stockAdjust = $servingQuantity - $soldQuantity;
			}
			else $stockAdjust =  $prevSaleQuantity - $soldQuantity;
			
			$priceAdjust = ( -1 * $stockAdjust) * $unitSalePrice;
			
			$this -> db -> query("UPDATE cashmemo_details
								  SET sale_quantity =  ".$soldQuantity.",
									  confirmation = 1
								  WHERE product_id = ".$productId."
								  AND cashmemo_details_id = ".$cashmemoDetailsId."
								 ");
			$this -> db -> query("UPDATE bulk_stock_info
								  SET stock_amount = stock_amount + ".$stockAdjust."
								  WHERE product_id = ".$productId."
								 ");
			if($saleType == 1)	 
				$this -> db -> query("UPDATE cashmemo_info
										SET total_sale = total_sale + ".$priceAdjust .",
											grand_total = grand_total + ".$priceAdjust."
										WHERE cashmemo_id = ".$cashmemoId." 
										AND market_summery_id = ".$marketSummeryId."
									");
			else if($saleType == 2)	 
				$this -> db -> query("UPDATE cashmemo_info
										SET total_sale = total_sale + ".$priceAdjust .",
											total_damage_rec = total_damage_rec + ".$priceAdjust."
										WHERE cashmemo_id = ".$cashmemoId." 
										AND market_summery_id = ".$marketSummeryId."
									");
			else if($saleType == 3)	 
				$this -> db -> query("UPDATE cashmemo_info
										SET total_sale = total_sale + ".$priceAdjust .",
											total_free = total_free + ".$priceAdjust."
										WHERE cashmemo_id = ".$cashmemoId." 
										AND market_summery_id = ".$marketSummeryId."
									");
			else if($saleType == 4)	 
				$this -> db -> query("UPDATE cashmemo_info
										SET total_sale = total_sale + ".$priceAdjust .",
											total_offer = total_offer + ".$priceAdjust."
										WHERE cashmemo_id = ".$cashmemoId." 
										AND market_summery_id = ".$marketSummeryId."
									");
			
			return True;

		}
	}
