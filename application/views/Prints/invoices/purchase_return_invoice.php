<!DOCTYPE HTML>
<html>
<head>
	<title> Dokani : IT Lab Solutions </title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
</head>
<?php 
	$this->load->config('custom_config'); 
	$pre_blance_show_invoice = $this->config->item('pre_blance_show_invoice');
?>
<body> 
 	<div id ="main_invoice" style="width: 700px;margin: auto;">
		<div id = "invoice" style="text-align: center;">
			<div id = "shop_title_test"> <?php echo $this->tank_auth->get_shopname(); ?>  </div>
			<div id = "shop_address_test">  <?php echo $this->tank_auth->get_shopaddress(); ?></div>	
			<div id = "shop_address_test"> Contact: <?php echo $this->tank_auth->get_shopcontact(); ?> </div>
			<?php
				$shop_id=$this->tank_auth->get_shop_id();
				$this->db->where('shop_id',$shop_id);
				$shop_info=$this->db->get('shop_setup')->row();
			?>
			<?php if ($shop_info->invoicelogo): ?>
				<img style="width: 100%;" src="<?php echo base_url();?>assets/img/shop/<?php echo $shop_info->invoicelogo ?>">
			<?php else: ?>
				<img style="width: 50%;height: 100px" src="<?php echo base_url();?>assets/img/top_logo2.png">
			<?php endif ?> 
		</div>
        <table class="table table-bordered">
            <tr>
                <th>Distributor</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            <?php if($alll->num_rows()>0){
                foreach ($alll->result() as $key => $var): ?>
            <tr>
                <th><?php echo $var->distributor_name ?></th>
                <th><?php echo $var->product_name ?></th>
                <th><?php echo $var->return_quantity ?></th>
                <th><?php echo $var->buy_price ?></th>
            </tr>
            <?php endforeach; } ?>

            <?php if($wproduct->num_rows()>0){
                foreach ($alll->result() as $key => $var): ?>
            <tr>
                <th><?php echo $var->distributor_name ?></th>
                <th><?php echo $var->product_name ?></th>
                <th><?php echo $var->return_quantity ?></th>
                <th><?php echo $var->buy_price ?></th>
            </tr>
            <?php endforeach; } ?>
        </table>
	</div>
</body>
</html>	
