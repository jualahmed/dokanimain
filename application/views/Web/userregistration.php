<?php $this -> load -> view('include/header_web2'); ?>
<script src="<?php echo base_url();?>assets/assets5/js/jquery-3.2.1.min.js"></script>
		<section class="login_area p_100" style="padding:0px 0px 50px 0px;">
            <div class="container">
                <div class="login_inner">
                    <div class="row">
                        <div class="bo9 w-size10 p-l-40 p-r-40 p-t-30 p-b-38 m-t-30 m-r-0 m-l-auto p-lr-15-sm">
								<h5 class="m-text20 p-b-24">
									Create account
								</h5>
								<?php
								if($this->uri->segment(4)!='' && $this->uri->segment(4)=='Success')
								{
								?>
                                <h2 style="color:green;">You Have Successfully Registered.</h2>
								<a href="<?php echo base_url();?>checkout/index">Back To Order</a>
								<?php
								}
								else if($this->uri->segment(4)!='' && $this->uri->segment(4)=='Failed')
								{
								?>
                                <h2 style="color:red;">You Have Failed.</h2>
								<?php
								}
								?>
                            
                            <form class="login_form row" action="<?php echo base_url();?>web/user_final_registration" method="post" autocomplete="off">
								
                                <div class="col-lg-4 form-group">
                                    <input class="form-control" type="text" name="user_full_name" placeholder="Name">
                                </div>
                                <div class="col-lg-4 form-group">
                                    <input class="form-control" type="email" name="email" placeholder="Email">
                                </div>
								<div class="col-lg-4 form-group">
                                    <input class="form-control" type="text" name="mobile_no" id="mobile_no" placeholder="Phone">
                                </div>
								<div class="col-lg-12 form-group">
                                    <input class="form-control" type="text" name="address" placeholder="Address">
                                </div>
								
                                <div class="col-lg-4 form-group">
									
                                    <input class="form-control" id="user_name" name="user_name" onBlur="checkAvailability()" title="Avoid Symbols and Space" type="text" placeholder="User Name">
									<span id="show_availavity1" style="font-size: 11px;font-weight: normal;color:red;"></span><span id="show_availavity2" style="font-size: 11px;font-weight: normal;color:green;"></span><span id="show_availavity3" style="font-size: 11px;font-weight: normal;color:red;"></span>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <input class="form-control" type="password" name="password" id="password1" placeholder="Password">
                                </div>
								
                                <div class="col-lg-4 form-group">
									
                                    <input class="form-control" type="password" id="password2" placeholder="Re-Password">
									<span id="correct_password" style="font-size: 11px;color:#2ECC71;display:none;">Password matched.</span><span id="incorrect_password" style="color:#E74C3C;display:none;font-size: 11px;">Password not matched.</span>
                                </div>
 
								<div class="col-lg-4 size15 trans-0-4">
									<!-- Button -->
									<button type="submit" class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
										Register
									</button>
								</div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		<script type="text/javascript">
			mobile_no.oninput = function () {
				if (this.value.length > 11) {
					this.value = this.value.slice(0,11); 
				}
			}
			function checkAvailability()
			{
				var search_value=$('#user_name').val();
				//alert(search_value);
				var format = /[!@#$%^&*()+\=\[\]{};':"" "\\|,.<>\/?]+/;

				if(format.test(search_value))
				{
					$('#show_availavity1').html('Please Avoid Symbols');
					$("#show_availavity1").show();
					$("#show_availavity2").hide();
					$("#show_availavity3").hide();
					
				} 
				else 
				{
				  $.ajax({
						url: "<?php echo base_url();?>web/check_user_name",
						data:{'user_name':search_value},
						type: "POST",
						success:function(data){
							if(data == 'Available') 
							{
								alert('User Name Available');
								$('#show_availavity2').html('Username Available');
								$("#show_availavity1").hide();
								$("#show_availavity2").show();
								$("#show_availavity3").hide();
							}
							else if (data == 'Not_Available') 
							{
								alert('User Name Not Available');
								$('#show_availavity3').html('Username Exists');
								$("#show_availavity1").hide();
								$("#show_availavity2").hide();
								$("#show_availavity3").show();
							}
						}
					});
				}
			};
			$(document).ready(function()
			{
				$('#button_disable').prop("disabled", true);
				$('#password2').keyup(function()
				{
					$('#button_disable').prop("disabled", true);
					var confirm_new_password = $(this).val();
					var new_password = $('#password1').val();
					if(new_password == confirm_new_password)
					{
						$('#correct_password').show();
						$('#incorrect_password').hide();
						$('#button_disable').prop("disabled", false);
					}
					else{
						$('#correct_password').hide();
						$('#incorrect_password').show();
						$('#button_disable').prop("disabled", true);
					}
				});
			});
		</script>
<?php $this -> load -> view('include/footer_web'); ?>