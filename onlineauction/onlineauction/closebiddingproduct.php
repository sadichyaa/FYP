<?php
include("header.php");

date_default_timezone_set('Asia/Kathmandu');
?>

<div class="banner">
<div class="privacy about">

<br/>
<h3 style="text-align: center; font-weight: bold;">
    View Closed Biddings
</h3>
<br/>

<div class="checkout-left">    

<div class="col-md-12 pl-5 pr-5">

<table id="datatable" class="table table-striped table-bordered">

<thead>
<tr>
    <th>Product Image</th>
    <th>Winner</th>
    <th>Product Name</th>
    <th>Owner</th>
    <th>Starting Bid</th>
    <th>Closed Bid</th>
    <th>Bidding Date</th>
</tr>
</thead>

<tbody>

<?php
// ✅ ONLY CLOSED AUCTIONS
$sql = "SELECT product.*, category.category_name
        FROM product
        LEFT JOIN category ON product.category_id = category.category_id
        WHERE product.product_id != ''
        AND product.status='Active'
        AND end_date_time < '$dt $tim'
        ORDER BY product.product_id DESC";

$qsql = mysqli_query($con, $sql);

while($rs = mysqli_fetch_array($qsql))
{

    // =========================
    // ✅ WINNER LOGIC FIXED
    // =========================
    $sqlbidding = "SELECT customer_id, bidding_amount 
                   FROM bidding 
                   WHERE product_id='{$rs['product_id']}' 
                   ORDER BY bidding_amount DESC 
                   LIMIT 1";

    $qsqlbidding = mysqli_query($con, $sqlbidding);
    $rsbidding = mysqli_fetch_array($qsqlbidding);

    $winner_name = "No Bids";
    $winning_amount = "0";

    if($rsbidding)
    {
        $sqlcustomer = "SELECT customer_name 
                        FROM customer 
                        WHERE customer_id='{$rsbidding['customer_id']}'";

        $qsqlcustomer = mysqli_query($con, $sqlcustomer);
        $rscustomer = mysqli_fetch_array($qsqlcustomer);

        $winner_name = $rscustomer['customer_name'];
        $winning_amount = $rsbidding['bidding_amount'];
    }

    // =========================
    // ✅ IMAGE FIX (FINAL WORKING)
    // =========================
    $images = [];

    $raw = $rs['product_image'];

    // try unserialize
    $un = @unserialize($raw);

    if (is_array($un)) {
        $images = $un;
    } else {
        // fallback: single image
        $images = [$raw];
    }
?>

<tr>

<!-- IMAGE -->
<td>
<?php
foreach ($images as $img) {

    $img = trim($img);

    if (!empty($img)) {

        $path = "imgproduct/" . $img;

        // NO file_exists (avoids server issues)
        echo "<img src='$path' 
                style='width:90px; height:90px; margin:3px; object-fit:cover; border-radius:5px;' 
                onerror=\"this.src='images/noimage.gif'\">
              ";
    }
}
?>
</td>

<!-- WINNER -->
<td>
    <b><?php echo $winner_name; ?></b><br>
    <span style="color:green;">
        Won for Rs. <?php echo $winning_amount; ?>
    </span>
</td>

<!-- PRODUCT -->
<td>
    <?php echo $rs['product_name']; ?><br>
    <font color="red">
        [Category - <?php echo $rs['category_name']; ?>]
    </font>
</td>

<!-- OWNER -->
<td>
    <?php echo $rs['customer_id']; ?>
</td>

<!-- START BID -->
<td>
    Rs. <?php echo $rs['starting_bid']; ?>
</td>

<!-- CLOSED BID -->
<td>
    Rs. <?php echo $rs['ending_bid']; ?>
</td>

<!-- DATE -->
<td>
    <?php 
    echo date("d-M-Y h:i A", strtotime($rs['start_date_time'])) . " -<br>";
    echo date("d-M-Y h:i A", strtotime($rs['end_date_time']));
    ?>
</td>

</tr>

<?php } ?>

</tbody>
</table>

</div>

<div class="clearfix"></div>

</div>
</div>
</div>

<?php
include("datatable.php");
include("footer.php");
?>