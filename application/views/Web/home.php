<?php $this -> load -> view('include/header_web'); ?>
 <script src="<?php echo base_url();?>assets/assets5/js/jquery-3.2.1.min.js"></script>

<script>
/* Update item quantity */
function addCartItem(obj, rowid, rowprice, rowproname)
{
	var submiturl = '<?php echo base_url();?>web/addcart';
	var methods = 'POST';
	$.ajax({
		url: submiturl,
		type: methods,
		data: {rowid:rowid,rowprice:rowprice,rowproname:rowproname, qty:obj.value},
		success: function(result) 
		{
			if(result == 'ok')
			{
				location.reload();
			}else{
				alert('Cart update failed, please try again.');
			}
		}
	});
}
function updateCartItem(obj, rowid)
{
	var submiturl = '<?php echo base_url();?>web/updateItemQty';
	var methods = 'POST';
	$.ajax({
		url: submiturl,
		type: methods,
		data: {rowid:rowid,qty:obj.value},
		success: function(result) 
		{
			if(result == 'ok')
			{
				location.reload();
			}else{
				alert('Cart update failed, please try again.');
			}
		}
	});
}
</script>
	<input type="hidden" id="language" value="<?php echo $this->uri->segment(3);?>">
	<section class="bgwhite p-t-55 p-b-65">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-xs-12 col-md-4 col-lg-3 p-b-50">
					<div class=" p-r-20 p-r-0-sm">
						<!--  -->
						<h4 class="m-text14 p-b-7">
							Categories
						</h4>

						<ul class="p-b-54 leftbar" style="height: 400px;overflow-x: auto;border: 1px solid deepskyblue;padding: 10px 10px;">
							<?php
							$lang = $this->uri->segment(3);
							if($lang=='' || $lang=='bn')
							{
							?>
								<?php
								foreach($catagory_info->result() as $tmp)
								{
								?>
								<li class="p-t-4">
									
									<a href="<?php echo base_url();?>web/index/bn/<?php echo $tmp->catagory_name;?>" class="s-text13 active1">
										<?php echo $tmp->catagory_name_bng;?>
									</a>
								</li>
							<?php
								}
							?>
						
							<?php
							}
							else if($lang=='en')
							{
							?>
								<?php
								foreach($catagory_info->result() as $tmp)
								{
								?>
								<li class="p-t-4">
									
									<a href="<?php echo base_url();?>web/index/bn/<?php echo $tmp->catagory_name;?>" class="s-text13 active1">
										<?php echo $tmp->catagory_name;?>
									</a>
								</li>
								<?php
									}
								?>
							<?php
							}
							?>
						</ul>
					</div>
				</div>

				<div class="col-xs-12 col-xs-12 col-md-8 col-lg-9 p-b-50">
					<!-- Product -->
					<div class="row">
						<?php
						$cat = $this->uri->segment(4);
						if($cat=='')
						{
						?>
							<?php
							$pr_name='';
							$lang = $this->uri->segment(3);
							foreach($result->result() as $field)
							{
								$product_id = $field->product_id;
								$product_name = $field->product_name;
								$product_name_bng = $field->product_name_bng;
								$product_size = $field->product_size;
								$general_unit_sale_price = $field->general_unit_sale_price;
								$image_ext = $field->image_ext;
							?>
							<div class="col-sm-12 col-md-6 col-lg-3 p-b-50">
								<!-- Block2 -->
								<div class="block2">
									<div class="block2-img wrap-pic-w of-hidden pos-relative">
										<img src="<?php echo base_url();?>images/cart.png" alt="">
										<div class="block2-overlay trans-0-4">
											<div class="block2-btn-addcart w-size1 trans-0-4">
												<?php
												$lang = $this->uri->segment(3);
												if($lang=='' || $lang=='bn')
												{
												?>
												<input type="number" class="form-control text-center size1 bg4 hov1 trans-0-4" placeholder="Add to Cart" onchange="addCartItem(this, '<?php echo $product_id; ?>', '<?php echo $general_unit_sale_price; ?>', '<?php echo $product_name_bng; ?>')">
												<?php
												}
												else if($lang=='en')
												{
												?>
												<input type="number" class="form-control text-center flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4" placeholder="Add to Cart" onchange="addCartItem(this, '<?php echo $product_id; ?>', '<?php echo $general_unit_sale_price; ?>', '<?php echo $product_name; ?>')">
												<?php
												}
												?>
											</div>
										</div>
									</div>

									<div class="block2-txt p-t-20">
										<?php
										$lang = $this->uri->segment(3);
										if($lang=='' || $lang=='bn')
										{
										?>
										<a class="block2-name dis-block s-text3 p-b-5">
											<?php echo $product_name_bng;?>
										</a>
										<span class="block2-price m-text6 p-r-5">
											&#2547; <?php echo BanglaConverter::en2bn($general_unit_sale_price);?>
										</span>
										<?php
										}
										else if($lang=='en')
										{
										?>
										<a class="block2-name dis-block s-text3 p-b-5">
											<?php echo $product_name;?>
										</a>
										<span class="block2-price m-text6 p-r-5">
											&#2547; <?php echo BanglaConverter::bn2en($general_unit_sale_price);?>
										</span>
										<?php
										}
										?>
									</div>
								</div>
							</div>
							<?php
							}
							?>
							
						<?php
						}
						else
						{
						?>
							<?php
							$pr_name='';
							$lang = $this->uri->segment(3);
							foreach($result->result() as $field)
							{
								$product_id = $field->product_id;
								$product_name = $field->product_name;
								$product_name_bng = $field->product_name_bng;
								$product_size = $field->product_size;
								$general_unit_sale_price = $field->general_unit_sale_price;
								$image_ext = $field->image_ext;
							?>
							<div class="col-sm-12 col-md-6 col-lg-3 p-b-50">
								<!-- Block2 -->
								<div class="block2">
									<div class="block2-img wrap-pic-w of-hidden pos-relative">
										<img src="<?php echo base_url();?>images/cart.png" alt="">
										<div class="block2-overlay trans-0-4">
											<div class="block2-btn-addcart w-size1 trans-0-4">
												<?php
												$lang = $this->uri->segment(3);
												if($lang=='' || $lang=='bn')
												{
												?>
												<input type="number" class="form-control text-center flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4" placeholder="Add to Cart" onchange="addCartItem(this, '<?php echo $product_id; ?>', '<?php echo $general_unit_sale_price; ?>', '<?php echo $product_name_bng; ?>')">
												<?php
												}
												else if($lang=='en')
												{
												?>
												<input type="number" class="form-control text-center flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4" placeholder="Add to Cart" onchange="addCartItem(this, '<?php echo $product_id; ?>', '<?php echo $general_unit_sale_price; ?>', '<?php echo $product_name; ?>')">
												<?php
												}
												?>
											</div>
										</div>
									</div>

									<div class="block2-txt p-t-20">
										<?php
										$lang = $this->uri->segment(3);
										if($lang=='' || $lang=='bn')
										{
										?>
										<a class="block2-name dis-block s-text3 p-b-5">
											<?php echo $product_name_bng;?>
										</a>
										<span class="block2-price m-text6 p-r-5">
											&#2547; <?php echo BanglaConverter::en2bn($general_unit_sale_price);?>
										</span>
										<?php
										}
										else if($lang=='en')
										{
										?>
										<a class="block2-name dis-block s-text3 p-b-5">
											<?php echo $product_name;?>
										</a>
										<span class="block2-price m-text6 p-r-5">
											&#2547; <?php echo BanglaConverter::bn2en($general_unit_sale_price);?>
										</span>
										<?php
										}
										?>
									</div>
								</div>
							</div>
						<?php
							}
						}
						?>
						<!-- Pagination -->
						<div class="col-xs-12 col-xs-12 col-md-8 p-b-50">
							<center>
								<!--a href="#" class="item-pagination flex-c-m trans-0-4 active-pagination">1</a>
								<a href="#" class="item-pagination flex-c-m trans-0-4">2</a-->
								<?php echo $links; ?>
							</center> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script>
	$('#clickme').click(function() {
		
		$('#clickme').hide();
		$('.mydiv').show();
	});
	$('#clickmeclose').click(function() {
		
		$('#clickme').show();
		$('.mydiv').hide();
	  });
	$(document).ready(function () {
		$('#clickme').hide();
		var $slider = $('.mydiv');
		//$slider.animate({left: '0px',right: '0px'});
		$('.lang_id').on("change",function(evv)
		{
			evv.preventDefault();
			var lang_id 		= $(this).val();

			var submiturl 	= '<?php echo base_url();?>web/index/'+lang_id+'/';
			
			window.open(submiturl,'_self');
		});
		$('.category_id').on("change",function(evv)
		{
			evv.preventDefault();
			var category_id 		= $(this).val();
			var language 		= $('#language').val();
			if(language=='' || language=='bn')
			{
				var lang = 'bn';
			}
			else if(language=='en')
			{
				var lang = 'en';
			}
			var submiturl 	= '<?php echo base_url();?>web/index/'+lang+'/'+category_id;
			window.open(submiturl,'_self');
		});
	});
	</script>
<?php $this -> load -> view('include/footer_web'); ?>