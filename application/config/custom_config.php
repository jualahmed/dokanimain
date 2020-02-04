<?php
	$ci = &get_instance();
  	$ci->db->get('bulk_stock_info')->result();
	$config['VAT'] = 1;
	$config['tp_price_purchase'] = 0; /** Allow=1, Not Allow = 0 **/
	$config['tp_price_vat_purchase'] = 0; /** Allow=1, Not Allow = 0 **/
	$config['allow_negative_stock'] = 0; /** Allow=1, Not Allow = 0 **/
	$config['version_name'] = 'v18.5.15'; /** Allow=1, Not Allow = 0 **/
	$config['discount_limit'] = 1;/** Allow any amount=1, Not Allow = 0 **/
	$config['gas_product'] = 0;/** Allow any amount=1, Not Allow = 0 **/
	$config['pre_blance_show_invoice'] = 0;/** Allow=1, Not Allow = 0 **/
	$config['cash_sale_return'] = 1;/** Allow =1, Not Allow = 0 **/
	$config['product_sale_return'] = 1;/** Allow =1, Not Allow = 0 **/
	$config['invoice_type'] = 1;/** Pos Printer =1, A4/A5 = 0 **/
	$config['allow_purchase_exceed'] = 0;/** YES = 1, NO = 0 **/
?>