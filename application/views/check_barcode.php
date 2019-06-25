<?php $this->load->view('include/header_for_new_sale'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>assets/JsBarcode.all.min.js'></script>
<div class="content-wrapper">

	<svg id="barcode"></svg>
	<svg id="barcode2"></svg>
	<svg id="barcode"></svg>
	<svg id="barcode"></svg>
	<svg id="barcode"></svg>
	<svg id="barcode"></svg>
	<svg id="barcode"></svg>
	<svg id="barcode"></svg>
	<svg id="barcode"></svg>
	<svg id="barcode"></svg>
</div>
<script>
JsBarcode("#barcode", "Hi");
JsBarcode("#barcode2", "45!");
</script>
<?php $this -> load -> view('include/footer'); ?>