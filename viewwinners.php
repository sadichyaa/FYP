<?php
include("header.php");
if(isset($_GET['delid']))
{
	$sql = "DELETE FROM winners WHERE winner_id='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('winner record deleted successfully...');</script>";
	}
}
?>
<!-- banner -->
	<div class="banner">
		<?php
		include("sidebar.php");
		?>
		<div class="w3l_banner_nav_right">
<!-- about -->
		<div class="privacy about">
			<br>
			<h3 style="text-align: center; font-weight: bold;">View Winner</h3>
<br/>
			<div class="checkout-left">	

				<div class="col-md-12  pr-3 pl-3">
<table id="datatable"  class="table table-striped table-bordered dataTable" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;" >		
	<thead>
		<tr>
		    <th>Customer</th>
			<th>Product</th>
			<th>Winning Bid</th>
			<th>End Date</th>
			<th>Payment Status</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$sql = "SELECT winners.*, customer.customer_name, customer.email_id, customer.mobile_no,
		        product.product_name, product.product_id as prod_id
		        FROM winners 
		        LEFT JOIN customer ON winners.customer_id = customer.customer_id 
		        LEFT JOIN product ON winners.product_id = product.product_id
		        ORDER BY winners.winner_id DESC";
		$qsql = mysqli_query($con,$sql);
		while($rs = mysqli_fetch_array($qsql))
		{
			$status_color = ($rs['status'] == 'Active') ? 'green' : 'orange';
			$status_label = ($rs['status'] == 'Active') ? 'Paid' : 'Pending Payment';
			echo "<tr>
			    <td><b>$rs[customer_name]</b><br>$rs[email_id]<br>$rs[mobile_no]</td>
				<td><b>$rs[product_name]</b><br>Product ID: $rs[prod_id]</td>
				<td><b>Rs. $rs[winning_bid]</b></td>
				<td>$rs[end_date]</td>
				<td><span style='color:$status_color; font-weight:bold;'>$status_label</span></td>
			</tr>";
		}
		?>
	</tbody>
</table>
				</div>
			
				<div class="clearfix"> </div>
				
			</div>

		</div>
<!-- //about -->
		</div>
		<div class="clearfix"></div>
	</div>
<!-- //banner -->
<script>
function deleteconfirm()
{
	if(confirm("Are you sure want to delete this record?") == true)
	{
		return  true;
	}
	else
	{
		return false;
	}
}
</script>

<?php
include("datatable.php");
include("footer.php");
?>