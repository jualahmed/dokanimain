<?php $this -> load -> view('include/header_web2'); ?>
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
	<!-- Cart -->
	<section class="cart bgwhite p-t-70 p-b-100">
		<div class="container">
			<div class="row">
			<!-- Cart item -->
			<div class="col-md-8">
			<div class="container-table-cart pos-relative bo9 m-t-30 p-t-20 p-l-10 p-r-10">
				<h5 class="m-text20 p-b-24">
					<?php
					$lang = $this->uri->segment(3);
					if($lang=='' || $lang=='bn')
					{
					?>
					পণ্যের তালিকা
					<?php
					}
					else if($lang=='en')
					{
					?>
						Your Order
					<?php
					}
					?>
					
				</h5>
				<div class="wrap-table-shopping-cart bgwhite">
					<table class="table-shopping-cart">
						<tr class="table-head" style="border: 1px solid #e6e6e6;">
							<th class="column-1"></th>
							<th class="column-2">Product</th>
							<th class="column-3">Price</th>
							<th class="column-4">Quantity</th>
							<th class="column-5">Total</th>
						</tr>
						<?php if($this->cart->total_items() > 0){ foreach($cartItems as $item){ ?>
						<tr class="table-row">
							
							<td class="column-1">
								<div class="cart-img-product b-rad-4 o-f-hidden">
									<img src="<?php echo base_url();?>images/cart.png" alt="IMG-PRODUCT">
								</div>
							</td>
							<td class="column-2"><?php echo $item["name"]; ?></td>
							<td class="column-3">
								<?php
								$lang = $this->uri->segment(3);
								if($lang=='' || $lang=='bn')
								{
								?>
								<strong>&#2547; <?php echo BanglaConverter::en2bn (sprintf('%0.2f',$item["price"]));?></strong>
								<?php
								}
								else if($lang=='en')
								{
								?>
								<strong>&#2547; <?php echo BanglaConverter::bn2en (sprintf('%0.2f',$item["price"]));?></strong>
								<?php
								}
								?>
							</td>
							<td class="column-4">
								<div class="flex-w bo5 of-hidden w-size13">
									<input type="number" class="form-control text-center btn-sm" style="padding: 2px 0px 2px 12px;" name="num-product1" value="<?php echo $item["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $item["rowid"]; ?>')">
								</div>
							</td>
							<td class="column-5">
								<?php
								$lang = $this->uri->segment(3);
								if($lang=='' || $lang=='bn')
								{
								?>
								<strong>&#2547; <?php echo BanglaConverter::en2bn (sprintf('%0.2f',$item["subtotal"]));?></strong>
								<?php
								}
								else if($lang=='en')
								{
								?>
								<strong>&#2547; <?php echo BanglaConverter::bn2en (sprintf('%0.2f',$item["subtotal"]));?></strong>
								<?php
								}
								?>
							</td>
							
						</tr>
						<?php } }else{ ?>
						<tr>
							<td colspan="5"><p>No items in your cart...</p></td>
						</tr>
						<?php } ?>
						
					</table>
				</div>
			</div>
			</div>
			<!-- Total -->
			<div class="col-md-4">
			<div class="bo9 w-size18 p-l-40 p-r-40 p-t-30 p-b-38 m-t-30 m-r-0 m-l-auto p-lr-15-sm">
				<h5 class="m-text20 p-b-24">
					
					<?php
					$lang = $this->uri->segment(3);
					if($lang=='' || $lang=='bn')
					{
					?>
						কার্টের বিবরণ
					
					<?php
					}
					else if($lang=='en')
					{
					?>
						Cart Totals
					<?php
					}
					?>
				</h5>

				<!--  -->
				<div class="flex-w flex-sb-m p-b-12">
					<span class="s-text18 w-size19 w-full-sm">
						<?php
						$lang = $this->uri->segment(3);
						if($lang=='' || $lang=='bn')
						{
						?>
							মোট টাকা :
						
						<?php
						}
						else if($lang=='en')
						{
						?>
							Total :
						<?php
						}
						?>
					</span>

					<span class="m-text21 w-size20 w-full-sm">
						<?php if($this->cart->total_items() > 0){ ?>
						
						<?php
						$lang = $this->uri->segment(3);
						if($lang=='' || $lang=='bn')
						{
						?>
						<strong>&#2547; <?php echo BanglaConverter::en2bn (sprintf('%0.2f',$this->cart->total()));?></strong>
						<?php
						}
						else if($lang=='en')
						{
						?>
						<strong>&#2547; <?php echo BanglaConverter::bn2en (sprintf('%0.2f',$this->cart->total()));?></strong>
						<?php
						}
						?>
						<?php } ?>
					</span>
				</div>

				<!--  -->
				<form class="billing_inner row" action="<?php echo base_url();?>checkout/placeOrder" method="post">
				
				<div class="flex-w flex-sb bo10 p-t-15 p-b-20">
					
					<?php
					if($this->uri->segment(4)!='' && $this->uri->segment(4)=='wrong')
					{
					?>
						<center><p style="color:red;margin-bottom:10px;text-align:center;">Wrong User ID and Password.</p></center>
					<?php
					}
					?>
					<span class="s-text18 w-size19 w-full-sm">
						<?php
						$lang = $this->uri->segment(3);
						if($lang=='' || $lang=='bn')
						{
						?>
							ইউজারনেম :
						
						<?php
						}
						else if($lang=='en')
						{
						?>
							Username:
						<?php
						}
						?>
					</span>

					<div class="w-size20 w-full-sm">
						<div class="size13 bo4 m-b-12">
							<input type="text" class="sizefull s-text7 p-l-15 p-r-15" id="name" name="user_name" aria-describedby="name" placeholder="">
						</div>
					</div>
					<span class="s-text18 w-size19 w-full-sm">
						<?php
						$lang = $this->uri->segment(3);
						if($lang=='' || $lang=='bn')
						{
						?>
							পাসওয়ার্ড :
						
						<?php
						}
						else if($lang=='en')
						{
						?>
							Password:
						<?php
						}
						?>
					</span>

					<div class="w-size20 w-full-sm">
						<div class="size13 bo4 m-b-12">
							<input type="password" class="sizefull s-text7 p-l-15 p-r-15" name="password" id="last" aria-describedby="last">
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							
							
							<?php
							$lang = $this->uri->segment(3);
							if($lang=='' || $lang=='bn')
							{
							?>
								<a href="<?php echo base_url();?>web/userregistration">নতুন ইউজার রেজিস্ট্রেশন</a>
							
							<?php
							}
							else if($lang=='en')
							{
							?>
								<a href="<?php echo base_url();?>web/userregistration">New User Registration.</a>
							<?php
							}
							?>
						</div>
					</div>
				</div>
				<div class="size15 trans-0-4" style="padding-top: 10px;">
					<!-- Button -->
					<button type="submit" class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
						
						<?php
						$lang = $this->uri->segment(3);
						if($lang=='' || $lang=='bn')
						{
						?>
							ক্রয় করুন
						
						<?php
						}
						else if($lang=='en')
						{
						?>
							Proceed to Checkout
						<?php
						}
						?>
					</button>
				</div>
				</form>
			</div>
			</div>
			</div>
		</div>
	</section>
	
	<script>
	$(document).ready(function () {
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