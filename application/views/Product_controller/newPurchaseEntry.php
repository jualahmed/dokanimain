<?php $this->load->view('include/header_for_new_sale'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Purchase Listing</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Purchase</li>
        <li class="active">Purchase Listing</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content"> 
	    <div class="row">
	      	<div class="col-md-6">
		        <div class="box box-info">
		            <div class="box-header with-border"></div>
		            <div class="box-body">
		            <!-- box-body -->
		            	<div class="form-group">
		            		<label >Purchase Receipt ID:</label>
		            		
		            		<select class="form-control select2" style="width: 91%;">
			                    <option selected="selected"></option>
				                <?php foreach($purchase_receipt_info as $tmp){?><option><?php echo $tmp; ?></option><?php }?>
                			</select>
                			<button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#dis_adder_mdl">+</button>
                			
                			<div class="modal" id="dis_adder_mdl">
    						<div class="modal-dialog" >
					            <div class="modal-content">
					              <div class="modal-header">
					                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                  <span aria-hidden="true">&times;</span></button>
					                <h4 class="modal-title">Add Purchase Receipt</h4>
					              </div>
					              <div class="modal-body">
					              	<form id="add_purchase_receipt" method="post">
					             	<table class="table table-bordered reduce_space">
					             		<tr>
					             			<td>Distributor:</td>
					             			<td>
					             				<select class="form-control select2" style="width: 100%;">
					             					<option></option>
					             				</select>
					             			</td>
					             		</tr>
					             		<tr>
					             			<td>Purchase Amount:</td>
					             			<td>
					             				<input type="text" class="form-control" name="" placeholder="Ex: 1000">
					             			</td>
					             		</tr>
					             		<tr>
					             			<td>Transport Cost:</td>
					             			<td>
					             				<input type="text" class="form-control" name="" placeholder="Ex: 100">
					             			</td>
					             		</tr>
					             		<tr>
					             			<td>Discount:</td>
					             			<td>
					             				<input type="text" class="form-control" name="" placeholder="Ex: 5">
					             			</td>
					             		</tr>
					             		<tr>
					             			<td>Final Amount:</td>
					             			<td>
					             				<input type="text" class="form-control" name="" placeholder="Ex: 995">
					             			</td>
					             		</tr>
					             		<tr>
					             			<td>Date: </td>
					             			<td>
					             				<input type="text" id="datepicker" class="form-control" name="" placeholder="Ex: 14-12-16">
					             			</td>
					             		</tr>
					             	</table>
					              </div>
					              <div class="modal-footer">
					                <button type="button" class="btn" data-dismiss="modal">Close</button>
					                <input type="submit" class="btn btn-info" value="Save">
					              </div>
					              </form>
					            </div>
				          </div>
				        </div>
		            	</div>
		            	
		           		<div class="input-group">
		                	<span class="input-group-addon"><i class="fa fa-fw fa-search"></i></span>
		                	<input type="email" class="form-control" placeholder="Search By Barcode">
		                	<span class="input-group-addon"><i class="fa fa-fw fa-search"></i></span>
		                	<input type="email" class="form-control" placeholder="Search By Product Name">
		              	</div>
		              	<br>
		              	<table class="table table-bordered reduce_space">
		              		<tbody>
		              			<tr>
		              				<td>
		              					Quantity:
		              				</td>
		              				<td>
		              					<input type="" class="form-control" name="" placeholder="Quantity">
		              				</td>
		              			</tr>

		              			<tr>
		              				<td>
		              					Total Buy Price:
		              				</td>
		              				<td>
		              					<input type="" class="form-control" name="" placeholder="Total Buy Price">
		              				</td>
		              			</tr>

		              			<tr>
		              				<td>
		              					Unit Buy Price:
		              				</td>
		              				<td>
		              					<input type="" class="form-control" name="" placeholder="Unit Buy Price">
		              				</td>
		              			</tr>

		              			<tr>
		              				<td>
		              					Total Sale Price:
		              				</td>
		              				<td>
		              					<input type="" class="form-control" name="" placeholder="Total Sale Price">
		              				</td>
		              			</tr>

		              			<tr>
		              				<td>
		              					Unit Sale Price:
		              				</td>
		              				<td>
		              					<input type="" class="form-control" name="" placeholder="Unit Sale Price">
		              				</td>
		              			</tr>

		              			<tr>
		              				<td>
		              					Expire Date:
		              				</td>
		              				<td>
		              					<input type="text" id="datepicker" class="form-control" name="" placeholder="Expire Date">
		              				</td>
		              			</tr>

		              			<!-- <tr>
		              				<td>
		              					Purchase Description:
		              				</td>
		              				<td>
		              					<input type="" class="form-control" name="" placeholder="Purchase Description">
		              				</td>
		              			</tr> -->
		              		</tbody>
		              	</table>


		            <!-- box-body -->
		            </div>
		        </div>
	      	</div>
	      	<div class="col-md-6">
		        <div class="box box-info">
		            <div class="box-header with-border"><!-- Box Header --></div>
		            <div class="box-body">
			            <table class="table table-bordered">
			            	<tbody>
			            		<tr>
			            			<td>Distributor Name</td>
			            			<td colspan="3">
			            				
			            			</td>
			            		</tr>
			            		<tr>
			            			<td> Receipt ID </td>
			            			<td>
			            				
			            			</td>
			            			<td>
			            				Purchase Date 
			            			</td>
			            			<td>
			            				
			            			</td>
			            		</tr>
			            		<tr>
			            			<td>Purchase Price</td>
			            			<td>
			            				
			            			</td>
			            			<td>Discount</td>
			            			<td>
			            				
			            			</td>
			            		</tr>
			            		<tr>
			            			<td>Grand Total</td>
			            			<td>
			            				
			            			</td>
			            			<td>Transport Cost</td>
			            			<td>
			            				
			            			</td>
			            		</tr>
			            	</tbody>
			            </table>
			            <br>
			            <table class="table table-bordered">
			            	<tbody>
			            		<tr style="background-color: #2aabd2; color: white;">
			            			<td>Product ID</td>
			            			<td>Product Name</td>
			            			<td >Quantity</td>
			            			<td>Unit Price</td>
			            			<td>Total Price</td>
			            		</tr>
			            	</tbody>
			            </table>
			            <div class="box-footer">
		            		<button type="submit" class="btn btn-info pull-right">Submit</button>
		            	</div>
		            </div>
		        </div>
	      	</div>
	    </div>
    </section>
</div>
<?php $this -> load -> view('include/footer_for_purchase_listing'); ?>