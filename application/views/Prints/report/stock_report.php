

<table style="width: 100%">
  <thead>
    <tr>
      <td>
        <!--place holder for the fixed-position header-->
        <div class="page-header-space"></div>
      </td>
    </tr>
  </thead>

  <tbody>
    <tr>
      <td>
        <div class="page">
         	<?php if(count($temp->result())>0){ ?>
            <table class="table table-bordered">
            	<tr>
            		<th>No.</th>
            		<th>Product.</th>
            		<th>Stock.</th>
            		<th>BP.</th>
            		<th>SP.</th>
            	</tr>
            	<?php $stockqty=0;$amount=0;$samount=0; foreach ($temp->result() as $key => $var):$stockqty=$stockqty+$var->stock_amount;$amount=$amount+($var->stock_amount*$var->bulk_unit_buy_price) ;$samount=$samount+($var->stock_amount*$var->general_unit_sale_price)?>
            		<tr v-for="(d,index) in alldata">
            			<td><?php echo $key+1 ?></td> 
            			<td><?php echo $var->product_name ?></td>
            			<td><?php echo $var->stock_amount ?></td>
            			<td><?php echo $var->bulk_unit_buy_price ?></td>
            			<td><?php echo $var->general_unit_sale_price ?></td>
            		</tr>
            	<?php endforeach ?>
            	<tr>
            		<td colspan="2"><b></b></td>
            		<td colspan="1"><b>Total Quantity: <?php echo $stockqty ?></b> </td>
            		<td colspan="1"><b>Total Stock Amount: <?php echo $amount ?></b></td>
            		<td colspan="1"><b>Total Sale Amount: <?php echo $samount ?></b></td>
            	</tr>
            </table>
            <?php } else{?>
            <h2 class="text-danger text-center">Result is Empty</h2>
            <?php } ?>
        </div>
      </td>
    </tr>
  </tbody>

  <tfoot>
    <tr>
      <td>
        <div class="page-footer-space"></div>
      </td>
    </tr>
  </tfoot>
</table>