<?php
include("header.php");
date_default_timezone_set('Asia/Kathmandu');
?>

<script>
function countdowntimer(id, time)
{
    var countDownDate = new Date(time).getTime();

    var x = setInterval(function() {

        var now = new Date().getTime();
        var distance = countDownDate - now;

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("countdowntime"+id).innerHTML =
        "<b style='color:red;'>Time Remaining</b><br>" +
        days + "d " + hours + "h " + minutes + "m " + seconds + "s";

        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdowntime"+id).innerHTML =
            "<b style='color:red;'>EXPIRED</b>";
        }

    }, 1000);
}
</script>

<div class="banner">
<div class="w3l_banner_nav_right">

<div class="w3ls_w3l_banner_nav_right_grid">

<?php
$sqlcategory = "SELECT * FROM category WHERE status='Active'";
$qsqlcategory = mysqli_query($con,$sqlcategory);

while($rscategory = mysqli_fetch_array($qsqlcategory))
{
?>

<div class="w3ls_w3l_banner_nav_right_grid1">

<h6>
<?php echo $rscategory['category_name']; ?>

<span style="font-size:13px;color:red;">
<a href="allproducts.php?category_id=<?php echo $rscategory['category_id']; ?>">
View all >>
</a>
</span>
</h6>

<?php
$sqlproduct = "SELECT * FROM product 
WHERE status='Active'
AND category_id='{$rscategory['category_id']}'
ORDER BY product_id DESC LIMIT 0,3";

$qsqlproduct = mysqli_query($con,$sqlproduct);

while($rsproduct = mysqli_fetch_array($qsqlproduct))
{

// IMAGE FIX (NO file_exists dependency)
if(!empty($rsproduct['product_image']))
{
    $imgname = "imgproduct/".$rsproduct['product_image'];
}
else
{
    $imgname = "images/noimage.gif";
}
?>

<div class="col-md-4 w3ls_w3l_banner_left">

<div class="hover14 column">

<div class="agile_top_brand_left_grid">

<div class="agile_top_brand_left_grid1">

<figure>

<div class="snipcart-item block">

<div class="snipcart-thumb">

<a href="single.php?productid=<?php echo $rsproduct['product_id']; ?>">
<img src="<?php echo $imgname; ?>" class="img-responsive" style="height:250px; object-fit:cover;">
</a>

<p>
<b>
<a href="single.php?productid=<?php echo $rsproduct['product_id']; ?>">
<?php echo $rsproduct['product_name']; ?>
</a>
</b>
</p>

<!-- TIMER -->
<p id="countdowntime<?php echo $rsproduct['product_id']; ?>"></p>

<script>
countdowntimer(
'<?php echo $rsproduct['product_id']; ?>',
'<?php echo date("Y-m-d H:i:s", strtotime($rsproduct['end_date_time'])); ?>'
);
</script>

<h4>
Current Bid : Rs <?php echo $rsproduct['starting_bid']; ?>
</h4>

</div>

<div class="snipcart-details">

<fieldset>
<a href="single.php?productid=<?php echo $rsproduct['product_id']; ?>">
<input type="button" value="Bid Now" class="button" />
</a>
</fieldset>

</div>

</div>

</figure>

</div>

</div>

</div>

</div>

<?php } ?>

<div class="clearfix"></div>

</div>

<br>

<button class="submit check_out"
onclick="window.location='allproducts.php?category_id=<?php echo $rscategory['category_id']; ?>';">

View All Products from <?php echo $rscategory['category_name']; ?>

</button>

<hr>

<?php } ?>

</div>
</div>
<div class="clearfix"></div>
</div>

<?php include("footer.php"); ?>