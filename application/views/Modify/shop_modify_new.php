<?php $this -> load -> view('include/header_for_new_sale'); ?>
<!--script  src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.min.js"></script-->
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
    <section class="content-header">
      <h1>Shop Modify</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Modify</a></li>
        <li class="active">Shop Modify</li>
      </ol>
    </section>
	<?php 
		if($status !=''){
			 if($status == "exists")
			 {
				 echo '<div class="box-body">';
				 echo $this->session->flashdata('msg');
				 echo '</div>';
			 }
			 else if($status == "successful")
			 {
				 echo '<div class="box-body">';
				 echo $this->session->flashdata('msg1');
				 echo '</div>';
			 }
			 else if($status == "failed")
			 {
				 echo '<div class="box-body">';
				 echo $this->session->flashdata('msg2');
				 echo '</div>';
			 }
		 }
	 ?>
<style>
.form-control-2{
	border-color: #d2d6de;
    border-radius: 0;
    box-shadow: none;
	background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    color: #555;
    display: block;
    font-size: 14px;
    height: 34px;
    line-height: 1.42857;
    padding: 6px 14px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
}
.col-xs-4{
	min-height: 1px;
    padding-left: 150px;
    padding-right: 19px;
    position: relative
}

.col-sm-22{
	width:34.75%;
	float:left;
	min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    position: relative;
}
.col-sm-222{
	width:52.8%;
	float:left;
	min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    position: relative;
}
.content-2{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 15px;
}
.content-3{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 15px;
}
.listStyl a{
font-size: 16px;
color: #777;
font-family : arial;
}
#product_show{
	min-width: 382px;
}
#product_show li{
background-color: #f7f7f7;
border: 1px solid #00c0ef;
}
.listStyl a:hover{
    background-color: #00c0ef;
    color:#ffffff;
}
.listStyl a:focus {
    background-color: #00c0ef;
	color: #ffffff;
}

input[type="text"]:disabled {
    background: #dddddd;
}

</style>
<section class="content-3" id="infomsg">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">	 
				<div class="box-body">
					<div class="wrap" style="margin:0px 0px 0px 0px;">
						<table class="head">
							<tr>
							  <td>No</td>
							  <td>S.ID</td>
							  <td>Name</td>
							  <td>Type</td>
							  <td>Address</td>
							  <td>Contact</td>
							  <td style="text-align:center;">Action</td>
							</tr>
						</table>
						<div class="inner_table" id="search_data">
							<table class="new_data">
								<?php
									 $i = 1; 
									 foreach($shop_data -> result() as $field):
								 ?>
								<tr class="inner_table">
									<td> <?php echo $i; ?> </td>
									<td style="text-align: left;"> <?php echo $field -> shop_id; ?> </td>
									<td style="text-align: left;"> <?php echo $field -> shop_name; ?> </td>
									<td style="text-align: left;"> <?php echo $field -> shop_type; ?> </td>
									<td style="text-align: left;overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo $field -> shop_address; ?>"> <?php echo $field -> shop_address; ?> </td>
									<td style="text-align: left;"> <?php echo $field -> shop_contact; ?> </td>
									<td> <center><a href="#" class='modal_load_2' valuu ="<?php echo $field->shop_id;?>" data-toggle="modal" data-target="#add_shop"><i class="fa fa-fw fa-edit" title="Edit Shop"></i></a></center> </td>
								</tr>
								<?php
									$i++; 
									endforeach;
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>
<style>
.wrap {
    width: 1000px;
}

.wrap table {
    width: 1050px;
    table-layout: fixed;
}

table tr td {
    padding: 5px;
    border: 1px solid black;
    width: 100px;
    word-wrap: break-word;
	background: white;
}

table.head tr td {
    color:white;
	background: gray;
}
table.new_data tr td {
    color:black;
	background: gray;
}

.new_data tr:nth-child(even) td {
    background-color: #dfe7f2;
}

.new_data tr:nth-child(odd) td {
    background-color: #fff;
}
.inner_table {
	color:#000;
    height: 100%;
	width: 1067px;
    overflow-y: auto !important;
}
</style>
<div class="modal fade" id="add_shop">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> Update Shop</h4>
      </div>
      <div class="modal-body">
        <span id="user-availability-status1" style="display:none;"></span>
        <span id="user-availability-status2" style="display:none;"></span>
		<span id="profile_show_2"></span>
		<img src="<?php echo base_url();?>assets/assets2/LoaderIcon.gif" id="loaderIcon" style="display:none" />
        
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$('.modal_load_2').click(function(){
		var shop_id = $(this).attr('valuu');
		var outputs2="";
		$.ajax({
			url: '<?php echo base_url();?>modify/get_shop_info', 
			dataType:'json',
			method: 'POST',
			data: {'shop_id' : shop_id},
			success: function(result){
				outputs2+='<section class="content"><div class="row"><div class="col-md-12"><div class="box box-info"><form action="<?php echo base_url();?>modify/update_shop_info" id="form_for_update" method="POST" enctype="multipart/form-data" role="form"><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">S.Name</label><div class="col-sm-10"><input type="text" class="form-control" id="shop_name_1" onBlur="checkAvailability()" name="shop_name" value="'+result.shop_name+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Address</label><div class="col-sm-10"><input type="text" class="form-control" name="shop_address" value="'+result.shop_address+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Conatct</label><div class="col-sm-10"><input type="text" class="form-control" name="shop_contact" value="'+result.shop_contact+'"></div></div><input type="hidden" name="shop_id" value="'+result.shop_id+'"><input type="submit" id="submit_btn" class="btn btn-block btn-success col-md-offset-2" style="width:116px; margin:10px 0px 0px 206px;" value="Update"></form></div></div></div></section>';

				$("#profile_show_2").html(outputs2);
			}
		});
	});
	
	$(document).ready(function() {
		$("#form_for_update").submit(function(event) {
		event.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');

		$.ajax({
			url: submiturl,
			type: methods,
			dataType: 'json',
			data: $(this).serialize(),
			success: function(result) {
				alert('Done');
			}
		});
	});
	
});

 $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
  });
</script>
<script>
function checkAvailability() {
	$("#loaderIcon").show();
	$.ajax({
	url: "<?php echo base_url();?>Product/check_shop",
	data:'shop_name='+$("#shop_name_1").val(),
	type: "POST",
    success:function(data){ 
		if(data == 'Shop Name Available') 
		{
			$('#submit_btn').removeAttr('disabled',false);
			$("#user-availability-status1").html(data).show();
			$("#user-availability-status2").html(data).hide()
			$("#loaderIcon").hide();
		}
		else if (data == 'Shop Name Not Available') 
		{
			$('#submit_btn').attr('disabled', true);
			$("#user-availability-status2").html(data).show();
			$("#user-availability-status1").html(data).hide();
			$("#loaderIcon").hide();
		}
    }	
	});
}
</script>
<style>
#user-availability-status1{color:#2FC332;}
#user-availability-status2{color:#D60202;}
</style>
</div>
<?php $this -> load -> view('include/footer'); ?>