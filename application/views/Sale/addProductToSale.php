
<?php if($num_of_row % 2 == 0){?>
<tr style="background-color: #f0f3f5;"> 
    <td style="text-align: left;" id="pro_name"><?php echo $product_name; ?></td>
    <td style="text-align: center;"><?php echo $product_stock; ?></td>
    <td style="text-align: center;"> <?php echo $pro_quantity; ?></td>
    <td style="text-align: center;"><?php echo round($pro_mrp_price); ?></td>
    <td style="text-align: center;"><?php echo round($sale_price); ?></td>
    <td style="text-align: center;">
        <?php echo $pro_quantity * $sale_price; ?>
    </td>
    <td style="text-align: center; ">
        <!-- <input type="image" id="delete" src="<?php //echo base_url() . 'images/delete.jpeg'?>" /> -->
        <i id="delete" class="fa fa-fw fa-remove" style="color: red" ></i>
		<i id="edit" class="fa fa-fw fa-edit edit_quantty" style="color: green" ></i>       <!-- id="edit" -->
        <!-- <input type="hidden" id="deleted_product_id"        value="<?php //echo $product_id;?>">
        <input type="hidden" id="deleted_product_quty"      value=" <?php //echo $pro_quantity; ?> ">
        <input type="hidden" id="deleted_product_price"     value="<?php //echo $sale_price; ?>">   -->     
    </td>
    <td style="display: none;"><?php echo $product_id . "<>" . $pro_quantity ."<>". round($sale_price); ?></td>
</tr>
<?php } else {?>
<tr style="background-color: white;"> 
    <td style="text-align: left;" id="pro_name"><?php echo $product_name; ?></td>
    <td style="text-align: center;"><?php echo $product_stock; ?></td>
    <td style="text-align: center;"> <?php echo $pro_quantity; ?></td>
    <td style="text-align: center;"><?php echo round($pro_mrp_price); ?></td>
    <td style="text-align: center;"><?php echo round($sale_price); ?></td>
    <td style="text-align: center;">
        <?php echo $pro_quantity * $sale_price; ?>
    </td>
    <td style="text-align: center; ">
        <!-- <input type="image" id="delete" src="<?php //echo base_url() . 'images/delete.jpeg'?>" /> -->
        <i id="delete" class="fa fa-fw fa-remove" style="color: red" ></i>
		<i id="edit" class="fa fa-fw fa-edit edit_quantty" style="color: green" ></i>       <!-- id="edit" -->
        <!-- <input type="hidden" id="deleted_product_id"        value="<?php //echo $product_id;?>">
        <input type="hidden" id="deleted_product_quty"      value=" <?php //echo $pro_quantity; ?> ">
        <input type="hidden" id="deleted_product_price"     value="<?php //echo $sale_price; ?>">   -->     
    </td>
    <td style="display: none;"><?php echo $product_id . "<>" . $pro_quantity ."<>". round($sale_price); ?></td>
</tr>
<?php }?>
