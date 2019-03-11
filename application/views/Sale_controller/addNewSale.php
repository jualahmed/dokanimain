<?php if($sale_id != false){ ?>
<button style="color: green" id="sale_new<?php echo $sale_id; ?>" class="running_sale" onclick="getSaleId(this.id)">
<?php echo 'Sale ' . $sale_id; ?>
</button>
<?php }?>
