<?php
include("header.php");
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
        "<b style='color:red;'>Time Remaining</b><br><b>" +
        days + " Days " + hours + " hrs " + minutes + " min " + seconds + " sec</b>";

        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdowntime"+id).innerHTML =
            "<center><b style='color:red;'>EXPIRED</b></center>";
        }
    }, 1000);
}
</script>

<div class="container">

<br>
<h3><?php echo ucfirst($_GET['auctiontype']); ?></h3>
<hr>

<?php
$sqlcategory = "SELECT * FROM category WHERE status='Active'";
$qsqlcategory = mysqli_query($con,$sqlcategory);

while($rscategory = mysqli_fetch_array($qsqlcategory))
{
    // BASE QUERY (FIXED ❗ removed customer_id condition)
    $sqlproduct = "SELECT * FROM product 
                   WHERE status='Active' 
                   AND category_id='".$rscategory['category_id']."'  
                   AND end_date_time > NOW() ";

    // FEATURED / LATEST LOGIC
    if(isset($_GET['auctiontype']) && $_GET['auctiontype'] == "featured Auctions")
    {
        // requires is_featured column in DB (optional but recommended)
        $sqlproduct .= " AND is_featured='1' ";
    }

    $sqlproduct .= " ORDER BY product_id DESC LIMIT 0,3";

    $qsqlproduct = mysqli_query($con,$sqlproduct);

    if(mysqli_num_rows($qsqlproduct) >= 1)
    {
?>
<h2 class="border" style="padding: 10px;">
    <a href='allproducts.php?category_id=<?php echo $rscategory['category_id']; ?>'>
        <?php echo $rscategory['category_name']; ?>
    </a>
</h2>

<div class="row">

<?php
while($rsproduct = mysqli_fetch_array($qsqlproduct))
{
    $arr_pro_img = unserialize($rsproduct['product_image']);

    if ($arr_pro_img && file_exists("imgproduct/".$arr_pro_img[0])) 
    {
        $imgname = "imgproduct/".$arr_pro_img[0];
    } 
    else 
    {
        $imgname = "images/noimage.gif";
    }
?>

<div class="col-md-4">
<figure class="card card-product">

<div class="img-wrap">
<center>
<a href="single.php?productid=<?php echo $rsproduct['product_id']; ?>">
<img src="<?php echo $imgname; ?>" class="img-responsive" style="height:250px;">
</a>
</center>
</div>

<figcaption class="info-wrap">
<h4 class="title">
<a href="single.php?productid=<?php echo $rsproduct['product_id']; ?>">
<?php echo $rsproduct['product_name']; ?>
</a>
</h4>

<!-- TIMER -->
<p id="countdowntime<?php echo $rsproduct['product_id']; ?>"></p>
<script>
countdowntimer(
'<?php echo $rsproduct['product_id']; ?>',
'<?php echo date("M d, Y H:i:s", strtotime($rsproduct['end_date_time'])); ?>'
);
</script>

<div class="rating-wrap">
<div class="label-rating">
<span>Started on <?php echo date("d-M-Y h:i A",strtotime($rsproduct['start_date_time'])); ?></span>
</div>
</div>

</figcaption>

<div class="bottom-wrap">
<a href="single.php?productid=<?php echo $rsproduct['product_id']; ?>" class="btn btn-sm btn-primary float-right">
Click to Bid
</a>

<div class="price-wrap h5">
<span class="price-new">
Current Bid : Rs.
<?php 
if($rsproduct['ending_bid'] > $rsproduct['starting_bid'])
{
    echo $rsproduct['ending_bid']; 
}
else
{
    echo $rsproduct['starting_bid'];
}
?>
</span>
</div>

</div>

</figure>
</div>

<?php } ?>

</div>
<hr>

<?php
    }
}
?>

</div>

<?php
include("footer.php");
?>