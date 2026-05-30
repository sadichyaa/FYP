<?php
include("header.php");

// ✅ Fix timezone
date_default_timezone_set('Asia/Kathmandu');
?>

<script>
function countdowntimer(id, time)
{
    // Convert to proper JS date format
    var countDownDate = new Date(time.replace(" ", "T")).getTime();

    var x = setInterval(function() {

        var now = new Date().getTime();
        var distance = countDownDate - now;

        if (distance <= 0) {
            clearInterval(x);
            document.getElementById("countdowntime"+id).innerHTML =
                "<center><b style='color:red;'>EXPIRED</b></center>";
            return;
        }

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("countdowntime"+id).innerHTML =
            "<b style='color:red;'>Time Remaining</b><br><b>" +
            days + " Days " + hours + " hrs " +
            minutes + " min " + seconds + " sec</b>";

    }, 1000);
}
</script>

<div class="container">

<br><h3><?php echo $_GET['auctiontype']; ?></h3><hr>

<?php
$sqlcategory = "SELECT * FROM category WHERE status='Active'";
$qsqlcategory = mysqli_query($con,$sqlcategory);

while($rscategory = mysqli_fetch_array($qsqlcategory))
{
    $sqlproduct = "SELECT * FROM product 
                   WHERE status='Active' 
                   AND category_id='$rscategory[category_id]'  
                   AND end_date_time > NOW() ";

    // Same query but kept for flexibility
    $sqlproduct .= " ORDER BY product_id DESC LIMIT 0,3";

    $qsqlproduct = mysqli_query($con,$sqlproduct);

    if(mysqli_num_rows($qsqlproduct) >= 1)
    {
?>

<h2 class="border" style="padding: 10px;">
<a href='allproducts.php?category_id=<?php echo $rscategory[0]; ?>'>
<?php echo $rscategory['category_name']; ?>
</a>
</h2>

<div class="row">

<?php
while($rsproduct = mysqli_fetch_array($qsqlproduct))
{
    $arr_pro_img = unserialize($rsproduct['product_image']);

    if ($arr_pro_img && file_exists("imgproduct/".$arr_pro_img[0])) {
        $imgname = "imgproduct/".$arr_pro_img[0];
    } else {
        $imgname = "images/noimage.gif";
    }
?>

<div class="col-md-4">
    <figure class="card card-product">

        <div class="img-wrap">
            <center>
                <a href="single.php?productid=<?php echo $rsproduct[0]; ?>">
                    <img src="<?php echo $imgname; ?>" class="img-responsive" style="height:250px;">
                </a>
            </center>
        </div>

        <figcaption class="info-wrap">

            <h4 class="title">
                <a href="single.php?productid=<?php echo $rsproduct[0]; ?>">
                    <?php echo $rsproduct['product_name']; ?>
                </a>
            </h4>

            <!-- ✅ Countdown Timer -->
            <p id="countdowntime<?php echo $rsproduct[0]; ?>"></p>

            <script>
            countdowntimer(
                '<?php echo $rsproduct[0]; ?>',
                '<?php echo date("Y-m-d H:i:s", strtotime($rsproduct['end_date_time'])); ?>'
            );
            </script>

            <div class="rating-wrap">
                <div class="label-rating">
                    <span>
                        Started on 
                        <?php echo date("d-M-Y h:i A", strtotime($rsproduct['start_date_time'])); ?>
                    </span><br>
                </div>
            </div>

        </figcaption>

        <div class="bottom-wrap">
            <a href="single.php?productid=<?php echo $rsproduct['product_id']; ?>" 
               class="btn btn-sm btn-primary float-right">
               Click to Bid
            </a>

            <div class="price-wrap h5">
                <span class="price-new">
                    Current Bid : Rs.
                    <?php 
                    if($rsproduct['ending_bid'] > $rsproduct['starting_bid'])
                        echo $rsproduct['ending_bid']; 
                    else
                        echo $rsproduct['starting_bid'];
                    ?>
                </span>
            </div>
        </div>

    </figure>
</div>

<?php
}
?>

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