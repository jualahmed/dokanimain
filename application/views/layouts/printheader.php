<!DOCTYPE HTML>
<html>
<head>
	<title> Dokani : IT Lab Solutions </title>
	<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>
  	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap4.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/printstyle.css" type="text/css"/>
</head>
<body class="text-center"> 
  <div class="page-header" style="text-align: center">
    <div>
      <?php
        $this->db->where('shop_id', $this->tank_auth->get_shop_id());
        $data=$this->db->get('shop_setup')->row();
      ?>
      <?php if ($data->logo): ?>
        <img style="width:90px;" class="schoolLogoHeaderSmall" src="<?php echo base_url().'assets/img/'.$data->logo;?>"/>
      <?php else: ?>
        <img style="width:90px;" src="<?php echo base_url();?>assets/img/top_logo2.png"/>
      <?php endif ?>
    </div>
  	<h4> 
  		<?php echo $this->tank_auth->get_shopname().' ( '. $this->tank_auth->get_shopaddress().' ) '; ?>
  	</h4>
    <h4>
      <?php if (isset($reportname)): ?>
        <?php echo $reportname; ?>
      <?php endif ?>
    </h4>
  </div>
