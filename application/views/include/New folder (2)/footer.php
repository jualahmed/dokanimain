</form>
<div class="modal fade" id="show_login_modal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> User Login</h4>
      </div>
      <form id="another_login_form" action="<?php echo base_url(); ?>index.php/auth/another_login" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
      <div class="modal-body">
        <div class="input-group input-group-sm">
          <span class="input-group-addon">User Name</span>
          <input name="login" type="text" class="form-control userr_name" placeholder="User Name" />
        </div>
		<div class="separator10"></div>
		<div class="input-group input-group-sm">
          <span class="input-group-addon">Password</span>
          <input name="password" type="password" class="form-control user_pass" placeholder="Password" />
        </div>
		<div class="separator10" id="mssage_log"></div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Login</button>
        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>



		<div style="display: none;">
			<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/js/bootstrap-tagsinput-angular.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/custom_script.js" type="text/javascript"></script>
			<input type="hidden" value="<?php echo base_url();?>extra_controller/retrive_and_select" id="ret_and_sel" >
			<input type="hidden" value="<?php echo base_url();?>extra_controller/retrive_and_select_with_id" id="ret_and_sel_with_id" >
		</div>				
			    <div id="footer">
					<p id="shop_copyright"> &#169; IT Lab Solutions, Zindabazar, Sylhet.</p>
					
					<p id="dokani_copyright">
					    &reg; <b>DOKANI</b> 
						&copy; <a href="#">IT Lab Solutions</a>+8801842485222
					</p>	
				</div><!--end of footer-->
			</div> <!--end of main-->
		</div><!--end of container-->
		

	

	
     </body><!--end of body-->
</html>		
