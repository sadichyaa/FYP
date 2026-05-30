<?php
include("header.php");
?>
<style>
h3.h3{text-align:center;margin:1em;text-transform:capitalize;font-size:1.7em;}

.product-grid8{font-family:Poppins,sans-serif;position:relative;z-index:1}
.product-grid8 .product-image8{border:1px solid #e4e9ef;position:relative;}
.product-grid8:hover .product-image8{box-shadow:0 0 10px rgba(0,0,0,.15)}
.product-grid8 .product-image8 a{display:block}
.product-grid8 .product-image8 img{width:100%;height:auto}
.product-grid8 .pic-1{opacity:1;transition:all .5s ease-out 0s}
.product-grid8:hover .pic-1{opacity:0}
.product-grid8 .pic-2{opacity:0;position:absolute;top:0;left:0;transition:all .5s ease-out 0s}
.product-grid8:hover .pic-2{opacity:1}
.product-grid8 .social{padding:0;margin:0;list-style:none;position:absolute;bottom:13px;right:13px;z-index:1}
.product-grid8 .social li{opacity:0;transform:translateY(3px);transition:all .5s ease 0s}
.product-grid8:hover .social li{margin:0 0 10px;opacity:1;transform:translateY(0)}
.product-grid8:hover .social li:nth-child(1){transition-delay:.1s}
.product-grid8:hover .social li:nth-child(2){transition-delay:.2s}
.product-grid8:hover .social li:nth-child(3){transition-delay:.4s}
.product-grid8 .social li a{color:grey;font-size:17px;line-height:40px;text-align:center;height:40px;width:40px;border:1px solid grey;display:block;transition:all .5s ease-in-out}
.product-grid8 .social li a:hover{color:#000;border-color:#000}
.product-grid8 .product-discount-label{display:block;padding:4px 15px 4px 30px;color:#fff;background-color:#0081c2;position:absolute;top:10px;right:0;-webkit-clip-path:polygon(34% 0,100% 0,100% 100%,0 100%);clip-path:polygon(34% 0,100% 0,100% 100%,0 100%)}
.product-grid8 .product-content{padding:20px 0 0}
.product-grid8 .price{color:#000;font-size:19px;font-weight:400;margin-bottom:8px;text-align:left;transition:all .3s}
.product-grid8 .price span{color:#999;font-size:14px;font-weight:500;text-decoration:line-through;margin-left:7px;display:inline-block}
.product-grid8 .product-shipping{color:rgba(0,0,0,.5);font-size:15px;padding-left:35px;margin:0 0 15px;display:block;position:relative}
.product-grid8 .product-shipping:before{content:'';height:1px;width:25px;background-color:rgba(0,0,0,.5);transform:translateY(-50%);position:absolute;top:50%;left:0}
.product-grid8 .title{font-size:16px;font-weight:400;text-transform:capitalize;margin:0 0 30px;transition:all .3s ease 0s}
.product-grid8 .title a{color:#000}
.product-grid8 .title a:hover{color:#0081c2}
.product-grid8 .all-deals{display:block;color:#fff;background-color:#2e353b;font-size:15px;letter-spacing:1px;text-align:center;text-transform:uppercase;padding:22px 5px;transition:all .5s ease 0s}
.product-grid8 .all-deals .icon{margin-left:7px}
.product-grid8 .all-deals:hover{background-color:#0081c2}
@media only screen and (max-width:990px){.product-grid8{margin-bottom:30px}
}


</style>
<script>
function countdowntimer(id, time)
{
		// Set the date we're counting down to
		var countDownDate = new Date(time).getTime();

		// Update the count down every 1 second
		var x = setInterval(function() {

		// Get todays date and time
		var now = new Date().getTime();
		
		// Find the distance between now an the count down date
		var distance = countDownDate - now;
		
		// Time calculations for days, hours, minutes and seconds
		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		
		// Output the result in an element with id="demo"
		document.getElementById("countdowntime"+id).innerHTML = "<b  style='color: red;'>Time Remaining</b> <br><b>" + days + "Days " + hours + "hrs " + minutes + "min " + seconds + "sec</b>";
		
		// If the count down is over, write some text 
		if (distance < 0) {
			clearInterval(x);
			document.getElementById("countdowntime"+id).innerHTML = "<center><b  style='color: red;'>EXPIRED</b></center>";
		}
	}, 1000);
	
}
</script>  

<!-- banner -->
	<div class="banner">

		<div class="w3l_banner_nav_right" style="float: right;width: 100%;">
			<div class="w3ls_w3l_banner_nav_right_grid">

<div class="container">
    <h3 class="h3">Winners list</h3>
    <div class="row">
<?php
$dttim = date("Y-m-d h:i:s");
$sqlproduct = "SELECT *,product.product_id as proid FROM winners LEFT JOIN product ON winners.product_id = product.product_id LEFT JOIN customer ON winners.customer_id=customer.customer_id where (winners.status='Pending' OR winners.status='Active') AND winners.customer_id='" . $_SESSION['customer_id'] . "' AND product.customer_id!='0'  ORDER BY winners.winner_id DESC ";
$qsqlproduct = mysqli_query($con,$sqlproduct);
		while($rsproduct = mysqli_fetch_array($qsqlproduct))
		{
				if (file_exists("imgproduct/".$rsproduct['product_image'])) 
				{
					 $imgname = "imgproduct/".$rsproduct['product_image'];
				} 
				else 
				{
					$imgname = "images/noimage.gif";
				}
				if($rsproduct['winners_image'] == "")
				{
					$imgwinner = "images/noimage.gif";
				}
				else if(file_exists("imgwinner/".$rsproduct['winners_image'])) 
				{
					 $imgwinner = "imgwinner/".$rsproduct['winners_image'];
				} 
				else 
				{
					$imgwinner = "images/noimage.gif";
				}
?>
        
		
		<div class="col-md-12">
			
            <div class="product-grid8 border">
                <div class="product-image8">
                    <a href="single.php?productid=<?php echo $rsproduct['proid']; ?>">
                        <img class="pic-1" src="<?php echo $imgname; ?>">
                        <img class="pic-2" src="<?php echo $imgwinner; ?>">
                    </a>
                   
                </div>
                <div class="product-content">
                    <span class="product-shipping" style="color: brown;"><b>Product : <?php echo $rsproduct['product_name']; ?></b></span>
                    <span class="product-shipping" style="color: brown;"><b>Product Code : <?php echo $rsproduct['product_name']; ?> </b></span>
                    <a class="all-deals" href="single.php?productid=<?php echo $rsproduct['proid']; ?>" target="_blank">View Product <i class="fa fa-angle-right icon"></i></a>
                </div>
                <div class="product-content">
                    <span class="product-shipping" style="color: green;"><b>Winner : <?php echo $rsproduct['customer_name']; ?></b></span>
                    <span class="product-shipping" style="color: green;"><b>From : <?php echo $rsproduct['city']; ?></b></span>
                    <span class="product-shipping" style="color: green;"><b>Amount payable: : Rs. <?php echo $rsproduct['winning_bid']; ?></b></span>


<?php
if($rsproduct[6] == "Pending")
{
?>
<a class="all-deals" href="paywinningbid.php?winner_id=<?php echo $rsproduct['winner_id']; ?>">Claim winning bid <i class="fa fa-angle-right icon"></i></a>


<?php
}
?>

                </div>
            </div>
        </div>
<?php
		}
?>
	</div>
</div>
<hr>


			</div>
		</div>
		
		
		<div class="clearfix"></div>
	</div>
<!-- //banner -->
<?php
include("footer.php");
?>