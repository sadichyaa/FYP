<?php
include("header.php");
if(!isset($_SESSION['customer_id']))
{
	echo "<SCRIPT>window.location='customerlogin.php';</SCRIPT>";
}
?>
<!-- banner -->
	<div class="banner">
		<?php
		include("sidebar.php");
		?>
		<div class="w3l_banner_nav_right">
		<br/>
		<h2 style="text-align: center; font-weight: bold;">Select category..</h2>
		<br/>
		<div class="row">
		<?php
		$sql = "select * from category WHERE status='Active'";
		$qsql = mysqli_query($con,$sql);
		while($rs = mysqli_fetch_array($qsql))
		{
		?>
				<div class="col-md-4 w3l_banner_nav_right_banner3_btml">
					<div class="view view-tenth" onclick='window.location=`product.php?categoryid=<?php echo $rs['category_id']; ?>`' style="cursor:pointer; padding:20px; border:1px solid #ddd; border-radius:8px; text-align:center; margin-bottom:15px;">
						<h4><?php echo $rs['category_name']; ?></h4>
						<p><?php echo $rs['description']; ?></p>
					</div>
				<hr>
				</div>
		<?php
		}
		?>		
				</div>
			
		</div>
		<div class="clearfix"></div>
	</div>
<!-- //banner -->
<?php
include("footer.php");
?>