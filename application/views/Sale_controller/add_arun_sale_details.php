<tr>
    <!--<td style="width: 5%;padding: 10px 0px; text-align: center;"><?php //echo $sn; ?></td>-->
    <td style="text-align: left; width: 40%; padding: 5px 0px 5px 5px" id="pro_name"><?php echo $product_name; ?></td>
    <td style="width: 5%; text-align: center;"><?php echo $product_stock; ?></td>
    <td style="width: 5%; text-align: center;"> <?php echo $pro_quantity; ?></td>
    <td style="width: 10%; text-align: center;"><?php echo round($sale_price); ?></td>
    <td style="width: 10%; text-align: center;">
        <?php echo $pro_quantity * $sale_price; ?>
    </td>
    <td style="width: 10%; text-align: center; ">
        <input type="image" id="delete" src="<?php echo base_url() . 'images/delete.jpeg'?>" />
        <!-- <input type="hidden" id="deleted_product_id"        value="<?php echo $product_id;?>">
        <input type="hidden" id="deleted_product_quty"      value=" <?php echo $pro_quantity; ?> ">
        <input type="hidden" id="deleted_product_price"     value="<?php echo $sale_price; ?>">   -->     
    </td>
    <td style="display: none;"><?php echo $product_id . "<>" . $pro_quantity ."<>". round($sale_price); ?></td>
</tr>