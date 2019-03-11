<?php $qnty = 0; $price = 0;$price1 = 0; $total_qnty = 0; $sub_to = 0; $vat = 0; ?>
    <?php if($tmp_item != FALSE){ foreach($tmp_item->result() as $tmp){?>
                <tr>
                    <td style="text-align: left; width: 40%; padding: 5px 0px 5px 5px" id="pro_name"><?php echo $tmp->item_name; ?></td>
                    <td style="width: 5%; text-align: center;"><?php echo $tmp->stock; ?></td>
                    <td style="width: 5%; text-align: center;"> <?php echo $qnty = $tmp->sale_quantity; ?></td>
                    <td style="width: 10%; text-align: center;"><?php echo $price1 = $tmp->general_unit_sale_price; ?></td>
                    <td style="width: 10%; text-align: center;"><?php echo $price = $tmp->unit_sale_price; ?></td>
                    <td style="width: 10%; text-align: center;">
                        <?php echo $tmp->sale_quantity * $tmp->unit_sale_price; ?>
                    </td>
                    <td style="width: 10%; text-align: center; ">
                        <input type="image" id="delete" src="<?php echo base_url() . 'images/delete.jpeg'?>" >       <!-- id="delete" -->
                    </td>
                    <td style="display: none;"><?php echo $tmp->product_id . "<>" . $qnty ."<>". $price; ?></td>
                </tr>
                <?php    
                    $total_qnty += $qnty;
                    $sub_to     = $sub_to + ($qnty * $price);
                    $vat        = $vat + ((($qnty * $price) * 10) / 100);
            }?> 

            <input type="hidden" value="<?php echo $total_qnty; ?>"     id="hid_qty" >
            <input type="hidden" value="<?php echo $sub_to;     ?>"     id="hid_sub_to" >
            <input type="hidden" value="<?php echo $vat;        ?>"     id="hid_vat" >
<?php }?>