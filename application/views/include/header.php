<?php
		$this->load->library('tank_auth');
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login');
		}
?>					
<!DOCTYPE html>
<html>
<head>
	
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>::~Dokani~:: </title>
  <link rel="icon" href="<?php echo base_url(); ?>images/dokani_small.png"  type="image/x-icon"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/custom.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/fonts/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/plugins/datepicker/datepicker3.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/plugins/iCheck/all.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/ionicons.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/plugins/colorpicker/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/plugins/select2/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/dist/css/skins/_all-skins.min.css">
	
	<input type="hidden" id="new_product" value="<?php echo base_url();?>product_controller/catagory_entry">
	<input type="hidden" id="new_stock_report" value="<?php echo base_url();?>report_controller/stock_report">
	<input type="hidden" id="new_sale" value="<?php echo base_url();?>sale_controller/new_sale">
	
	
	<script language="JavaScript">
		var version = navigator.appVersion;
		
		function showKeyCode(e) 
		{
			var keycode = (window.event) ? event.keyCode : e.keyCode;
			
			if ((version.indexOf('MSIE') != -1)) 
			{
				if (keycode == 116) 
				{
				event.keyCode = 0;
				event.returnValue = false;
				return false;
				}
			}
			else 
			{
				if (keycode == 116) 
				{
				return false;
				}
			}
		}
	</script>

<script type="text/javascript">

function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
}

document.onkeypress = stopRKey;

</script> 
	
	<?php
	echo link_tag('assets/css/cupertino/jquery-ui.min.css');
	echo link_tag('assets/css/bootstrap.min.css');	
	echo link_tag('assets/css/bootstrap-theme.min.css');
	echo link_tag('assets/css/font-awesome.min.css');
	echo link_tag('assets/css/bootstrap-tagsinput.css');
	echo link_tag('assets/custom_style.css');
	?>

  <!-- CSS file for  autocomplete -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/autocom/jquery-ui.css" >
  <style type="text/css">
    /* Start: style for new sale view */

    .sale_input_custom_styl{
      height          : 25px;
      padding         : 0px 2px;
      font-size       : 12px;
      border-radius   : 0px;
      /*border          : none;*/
    }
    .sale_table_custom_styl tbody tr td{
      padding         : 2px 2px;
    }
    #btn_container{
      margin          : auto;
      width           : 100%;
      height          : auto;
      margin-top      : 1%;
    }
    .search{
      border-radius   : 0px; 
      height          : 25px; 
      width           : 100%; 
      font-size       : 12px; 
      padding         : 2px 2px;
      background      : none;
    }
    .quantity{
      border-radius   : 0px; 
      height          : 25px; 
      width           : 100%; 
      font-size       : 12px; 
      padding         : 0px 2px 0px 0px;
      text-align      : right;
    }
    
    .ui-autocomplete {
      height      : 300px;
      width       : 310px; 
      overflow-y  : auto;
      overflow-x  : hidden;
      font-size   : 12px;
      background  : white;
    }
    
    .ui-widget-content .ui-state-focus{
      background    : #ff8a00;
      color         : black;
      font-weight   : normal;
    }

    .autocomplete_custom_cls_for_customer{
      height        : 100px;
      width         : 50px; 
      overflow-y    : hidden;
      overflow-x    : hidden;
      font-size     : 14px;
    }

    .label_style{
      font-weight   : bold;
      color         : #00a65a;
    }
    .sale_selection{
      cursor        : pointer;
      padding       : 2px 10px;
      color         : white;
      /*margin-right  : 2%;*/
    }
    #num_of_sale{
      width   : auto;
      float   : left;
    }
    #btn_container{
      margin      : auto;
      width       : 100%;
      height      : auto;
      margin-top  : 1%;
    }
    /* End: style for new sale view */

     table.reduce_space tr td{
      padding   : 5px;
    }
    
  </style>
  <style>
	.common{
		height:130px;
		overflow-y: auto !important;
	}
	.common::-webkit-scrollbar {
    width: 6px;
	~background-color: #2d3335;
	}

	.common::-webkit-scrollbar-track {
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
		~background-color: white;
	}

	.common::-webkit-scrollbar-thumb {
	   background-color: #448ca6;
	   background-image: -webkit-linear-gradient(45deg,rgba(255, 255, 255, .2) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, .2) 50%,rgba(255, 255, 255, .2) 75%,transparent 75%,transparent)

	}
	
  </style>
</head>
<?php 

	$this->load->config('custom_config'); 
	$gas_product = $this->config->item('gas_product');
	$cash_sale_return = $this->config->item('cash_sale_return');
?>
<body class="hold-transition skin-blue sidebar-mini" onload="JavaScript:document.body.focus(); " onkeydown="return showKeyCode(event)">
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url();?>site_controller/main_site" class="logo">
	  <span class="logo-mini"><img src="<?php echo base_url(); ?>images/dokani_small.png" style="max-width:40px;"></span>
      <span class="logo-lg"><img src="<?php echo base_url(); ?>images/top_logo2.png" style="width:190px;height:50px;"></span>
    </a>
    <nav class="navbar navbar-static-top" style="height: 38px;line-height: 25px;">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" style="text-decoration:none;font-size:20px;">
        <span class="sr-only">Toggle navigation</span>
		<span style="margin:0px 0px 0px 10px; color:white; font-size:30px; font-weight:bold;Helvetica Neue,Helvetica,Arial,sans-serif"><?php echo $this->tank_auth->get_shopname(); ?></span>
		<?php
			$this->load->config('custom_config'); 
			//echo $version_name = $this->config->item('version_name');
		?>
	  </a>
      <div class="navbar-custom-menu">		
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url();?>images/avatar.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $user_name; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url();?>images/avatar.png" class="img-circle" alt="User Image">

                <p>
                  <?php echo $user_name; ?>
                  <small><?php echo ucfirst($user_type); ?></small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left" style="margin:0px 0px 0px 90px;">
					<a href="<?php echo base_url();?>auth/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
      </div>
	  <div id="scrollbar">
      <ul class="sidebar-menu">
        <li class="active treeview">
          <a href="<?php echo base_url();?>site_controller/main_site">
            <i class="fa fa-home"></i> <span>Home</span>
          </a>
        </li>
		<?php
		if($user_type!='seller')
		{
		?>
        <li class="treeview" id="setup">
          <a href="#">
            <i class="fa fa-gear"></i>
            <span>Setup</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu common">
            <li><a href="<?php echo base_url();?>setup/catagory_setup"><i class="fa fa-gear"></i>Category Setup</a></li>
            <li><a href="<?php echo base_url();?>setup/company_setup"><i class="fa fa-gear"></i>Company Setup</a></li>
            <li><a href="<?php echo base_url();?>setup/distributor_setup"><i class="fa fa-gear"></i>Distributor Setup</a></li>
            <li><a href="<?php echo base_url();?>setup/product_setup"><i class="fa fa-gear"></i>Product Setup</a></li>
            <!--li><a href="<?php echo base_url();?>setup/card_setup"><i class="fa fa-gear"></i>Card Setup</a></li-->
            <li><a href="<?php echo base_url();?>setup/customer_setup"><i class="fa fa-gear"></i>Customer Setup</a></li>
            <li><a href="<?php echo base_url();?>setup/damage_setup"><i class="fa fa-gear"></i>Damage Setup</a></li>
			<li><a href="<?php echo base_url();?>setup/employee_setup"><i class="fa fa-gear"></i>Employee Setup</a></li>
          </ul>
        </li>
		<?php }?>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-truck"></i>
            <span>Purchase</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>purchase/receipt_setup"><i class="fa fa-truck"></i>Purchase Receipt Entry</a></li>
            <li><a href="<?php echo base_url();?>product_controller/newPurchaseListing"><i class="fa fa-truck"></i>Purchase Listing </a></li>
          </ul>
        </li>
		
		<li class="treeview">
          <a href="<?php echo base_url();?>sale_controller/new_sale">
            <i class="fa fa-shopping-cart"></i> <span>Sale</span>
          </a>
        </li>
		<?php
		if($gas_product!=0)
		{
		?>
		<li class="treeview">
          <a href="<?php echo base_url();?>exchange/exchange_setup">
            <i class="fa fa-exchange"></i> <span>Product Exchange</span>
          </a>
        </li>
		<?php
		}
		?>
		<?php
		if($cash_sale_return!=0)
		{
		?>
		<li class="treeview">
          <a href="<?php echo base_url();?>sale_controller/return_sale">
            <i class="fa fa-shopping-cart"></i> <span>Cash Sale Return</span>
          </a>
        </li>
		<?php
		}
		?>
		<?php
		if($user_type!='seller')
		{
		?>
		<li class="treeview">
          <a href="<?php echo base_url();?>purchase/purchase_return">
            <i class="fa fa-truck"></i> <span>Purchase Return</span>
          </a>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-bank"></i>
            <span>Accounts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu common">
			<li><a href="<?php echo base_url();?>account_controller/today_transaction"><i class="fa fa-bank"></i>All Transactions</a></li>
			<li><a href="<?php echo base_url();?>account_controller/comission_entry"><i class="fa fa-bank"></i>Commission Setup</a></li>
            <li><a href="<?php echo base_url();?>account_controller/bank_entry"><i class="fa fa-bank"></i>Bank Entry</a></li>
			<li><a href="<?php echo base_url();?>account_controller/expense_entry"><i class="fa fa-bank"></i>Expense Entry</a></li>
			<li><a href="<?php echo base_url();?>account_controller/bank_transfer"><i class="fa fa-bank"></i>Bank Transfer</a></li>
			<li><a href="<?php echo base_url();?>account_controller/owner_transfer"><i class="fa fa-bank"></i>Owner Transfer</a></li>
			<li><a href="<?php echo base_url();?>account_controller/ledgers"><i class="fa fa-bank"></i>Ledger</a></li>
            <li><a href="<?php echo base_url();?>account_controller/cash_book_report"><i class="fa fa-bank"></i>Cash Book Report</a></li>
            <li><a href="<?php echo base_url();?>account_controller/cheque_status_report"><i class="fa fa-bank"></i>Cheque Status Report</a></li>
            <li><a href="<?php echo base_url();?>account_controller/credit_collection_receipt"><i class="fa fa-bank"></i>Credit Collection Receipt</a></li>
            <li><a href="<?php echo base_url();?>account_controller/purchase_payment_receipt"><i class="fa fa-bank"></i>Purchase Payment Receipt</a></li>
            <li><a href="<?php echo base_url();?>account_controller/expense_payment_receipt"><i class="fa fa-bank"></i>Expense Payment Receipt</a></li>
            <li><a href="<?php echo base_url();?>account_controller/pay_reci_report"><i class="fa fa-bank"></i>Payable & Receivable</a></li>
			<!--li><a href="<?php echo base_url();?>account_controller/bank_book_report"><i class="fa fa-bank"></i>Bank Book report</a></li>
			<!--li><a href="<?php echo base_url();?>account_controller/investment_entry"><i class="fa fa-bank"></i>Investment Entry</a></li>
			<li><a href="<?php echo base_url();?>account_controller/investment_report"><i class="fa fa-bank"></i>Investment report</a></li-->
          </ul>
        </li>
		<?php }?>
		<?php 
		if($user_type=='superadmin' || $user_type=='admin')
		{
		?>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i>
            <span>Modify</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu common">
			
            <!--li><a href="<?php echo base_url();?>modify_controller/invoice_modify_new"><i class="fa fa-edit"></i>Sale Invoice</a></li>
            <li><a href="<?php echo base_url();?>modify_controller/purchase_modify_new"><i class="fa fa-edit"></i>Purchase Receipt</a></li-->
			
			<li><a href="<?php echo base_url();?>modify_controller/total_purchase_price_modify"><i class="fa fa-edit"></i>Purchase Receipt</a></li>
            <li><a href="<?php echo base_url();?>modify_controller/catagory_modify_new"><i class="fa fa-edit"></i>Category Modify</a></li>
            <li><a href="<?php echo base_url();?>modify_controller/company_modify_new"><i class="fa fa-edit"></i>Company Modify</a></li>
            <li><a href="<?php echo base_url();?>modify_controller/distributor_modify_new"><i class="fa fa-edit"></i>Distributor Modify</a></li>
			<li><a href="<?php echo base_url();?>modify_controller/product_report"><i class="fa fa-edit"></i>Product Modify</a></li>
			<li><a href="<?php echo base_url();?>modify_controller/product_image_report"><i class="fa fa-edit"></i>Product Image Modify</a></li>
			<!--li><a href="<?php echo base_url();?>modify_controller/card_report"><i class="fa fa-edit"></i>Card Modify</a></li-->
            <li><a href="<?php echo base_url();?>modify_controller/customer_modify_new"><i class="fa fa-edit"></i>Customer Modify</a></li>
            <li><a href="<?php echo base_url();?>modify_controller/damage_modify_new"><i class="fa fa-edit"></i>Damage Modify</a></li>
            <!--li><a href="<?php echo base_url();?>modify_controller/expense_modify_new"><i class="fa fa-edit"></i>Expense Modify</a></li-->
          </ul>
        </li>
		<?php
		}
		?>
		<?php
		if($user_type!='seller')
		{
		?>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-search-plus"></i>
            <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu common">
            <li><a href="<?php echo base_url();?>report_controller/stock_report"><i class="fa fa-search-plus"></i>Stock Report</a></li>
            <li><a href="<?php echo base_url();?>report_controller/purchase_report"><i class="fa fa-search-plus"></i>Purchase Report</a></li>
            <li><a href="<?php echo base_url();?>report_controller/sale_report"><i class="fa fa-search-plus"></i>Sale Report</a></li>
			<li><a href="<?php echo base_url();?>report_controller/delivery_charge_report"><i class="fa fa-search-plus"></i>Delivery Charge Report</a></li>
            <li><a href="<?php echo base_url();?>report_controller/card_sale_report"><i class="fa fa-search-plus"></i>Card Sale Report</a></li>
			<li><a href="<?php echo base_url();?>report_controller/financial_report"><i class="fa fa-search-plus"></i>Financial Report</a></li>
			<?php
			if($gas_product!=0)
			{
			?>
			<li><a href="<?php echo base_url();?>report_controller/product_exchange_report_new"><i class="fa fa-search-plus"></i>Product Exchange Report </a></li>
			<?php
			}
			?>
            <li><a href="<?php echo base_url();?>report_controller/damage_report"><i class="fa fa-search-plus"></i>Damage Report </a></li>
            <li><a href="<?php echo base_url();?>report_controller/sale_return_report_new"><i class="fa fa-search-plus"></i>Sale Return Report </a></li>
			<li><a href="<?php echo base_url();?>report_controller/purchase_return_report_new"><i class="fa fa-search-plus"></i>Purchase Return Report </a></li>
            <!--li><a href="<?php echo base_url();?>report_controller/expense_report_new"><i class="fa fa-search-plus"></i>Expense Report </a></li-->
            <li><a href="<?php echo base_url();?>report_controller/credit_collection_report_new"><i class="fa fa-search-plus"></i>Credit Collection Report </a></li>
            <li><a href="<?php echo base_url();?>site_controller/searchBarcode"><i class="fa fa-search-plus"></i>Barcode Print</a></li>
           
          </ul>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>User</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>auth/register"><i class="fa fa-user"></i>Register User</a></li>
			 <li><a href="<?php echo base_url();?>report_controller/staff_report_new"><i class="fa fa-user"></i>Staff List </a></li>
            <li><a href="<?php echo base_url();?>registration_controller/user_modification"><i class="fa fa-user"></i>Modify User</a></li>
            <li><a href="<?php echo base_url();?>auth/change_password"><i class="fa fa-user"></i>Change Password</a></li>
          </ul>
        </li>
		
		<li class="treeview">
          <a href="#" id="download_database">
            <i class="fa fa-download"></i> <span>Download Backup</span>
          </a>
        </li>
		<?php
		}
		?>		
      </ul>
	  </div>
    </section>
  </aside>
<style>
#scrollbar2{
height:547px;
width:229px;
overflow-y:scroll;
}
#scrollbar2::-webkit-scrollbar {
    width: 8px;
	background-color: #2d3335;
}

#scrollbar2::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #2d3335;
}

#scrollbar2::-webkit-scrollbar-thumb {
   background-color: #448ca6;
   background-image: -webkit-linear-gradient(45deg,rgba(255, 255, 255, .2) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, .2) 50%,rgba(255, 255, 255, .2) 75%,transparent 75%,transparent)

}
</style>
<style type="text/css">
	.modal12345
	{
		position: fixed;
		z-index: 999;
		height: 100%;
		width: 100%;
		top: 0;
		left: 0;
		background-color: white;
		filter: alpha(opacity=60);
		opacity: 0.6;
		-moz-opacity: 0.8;
	}
	.center
	{
		z-index: 1000;
		margin: 300px auto;
		width: 350px;
		border-radius: 10px;
		filter: alpha(opacity=100);
		opacity: 1;
		-moz-opacity: 1;
	}
	.center img
	{
		margin:0px 0px 0px 100px;
	}
</style>
<div class="modal12345" style="display: none">
	<div class="center">
		<img src="<?php echo base_url();?>assets/assets2/spin.gif" id="loaderIcon"/>
	</div>
</div>

