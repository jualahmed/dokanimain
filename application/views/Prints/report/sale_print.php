<table>
	<thead>
	  <tr>
	    <td>
	      <!--place holder for the fixed-position header-->
	      <div class="page-header-space"></div>
	    </td>
	  </tr>
	</thead>

	<tbody>
	  <tr>
	    <td>
	      <div class="page" style="line-height: 3;">
	       	<section class="content" style="padding-top: 0px;">
				<div class="table table-secondary" v-if="alldata.length">          
					<table class="table table-secondary">
						<thead class="table-hf">
							<tr>
								<th>NO</th>
								<th>Invoice ID</th>
								<th>Date</th>
								<th>Product Model</th>
								<th>Company</th>
								<th>Catagory</th>
								<th>Customer Name</th>
								<th>Mobile No</th>
								<th>BP</th>
								<th>SP</th>
								<th>Seller</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data as $key => $var): ?>
							<tr>
								<td><?php echo $key+1 ?></td>
								<td align="center"><?php echo $var->sid ?></td>
								<td></td>
								<td><?php echo $var->product_name ?></td>
								<td><?php echo $var->company_name ?></td>
								<td><?php echo $var->catagory_name ?></td>
								<td><?php echo $var->customer_name ?></td>
								<td><?php echo $var->customer_contact_no ?></td>
								<th ><?php echo $var->customer_contact_no ?></th>
								<th ><?php echo $var->customer_contact_no ?></th>
								<td><?php echo $var->username ?></td>
							</tr>
							<?php endforeach ?>
							<tr>
								<td colspan="8"></td>
								<td><b>Total BP: {{ amount }}</b></td>
								<td><b>Total SP:{{ samount }}</b></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div v-else>
					<h2 class="text-danger text-center">Result is Empty</h2>
				</div>
			</section>
	      </div>
	    </td>
	  </tr>
	</tbody>

	<tfoot>
	  <tr>
	    <td>
	      <div class="page-footer-space"></div>
	    </td>
	  </tr>
	</tfoot>
</table>