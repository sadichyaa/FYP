<?php
include("header.php");

if(!isset($_POST['winner_id'])) {
    echo "<script>alert('Invalid request'); window.location='customeraccount.php';</script>";
    exit;
}

$winner_id   = $_POST['winner_id'];
$amount      = $_POST['amount'];
$commission  = $_POST['commission'];
$total       = $_POST['total'];
$product_id  = $_POST['product_id'];
$customer_id = $_POST['customer_id'];
$esewa_id    = $_POST['esewa_id'];
$dt          = date("Y-m-d");
$transaction_code = 'ESEWA-' . strtoupper(uniqid());

// Update winner status to Active (paid)
$sql = "UPDATE winners SET status='Active' WHERE winner_id='$winner_id'";
mysqli_query($con, $sql);

// Insert payment record
$sql = "INSERT INTO payment (payment_type, paid_amount, paid_date, status, customer_id, product_id, bidding_id)
        VALUES('eSewa', '$total', '$dt', 'Active', '$customer_id', '$product_id', '0')";
mysqli_query($con, $sql);

// Insert billing record with commission info
$verify_token = md5(rand());
$sql = "INSERT INTO billing (email_id, purchase_date, product_id, purchase_amount, payment_type, card_type, card_number, expire_date, cvv_number, card_holder, verify_token, status, customer_id)
        VALUES('$esewa_id', '$dt', '$product_id', '$total', 'Winners', 'eSewa', '$transaction_code', '$dt', '$commission', 'eSewa Payment', '$verify_token', 'Active', '$customer_id')";
mysqli_query($con, $sql);
$billing_id = mysqli_insert_id($con);

// Clear winner popup session
unset($_SESSION['winner_popup_id']);
unset($_SESSION['winner_popup_name']);
unset($_SESSION['esewa_amount']);
unset($_SESSION['esewa_commission']);
unset($_SESSION['esewa_total']);
unset($_SESSION['esewa_winner_id']);
unset($_SESSION['esewa_product_id']);
unset($_SESSION['esewa_customer_id']);
?>

<div class="content-wraper mt-50">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div style="border:2px solid #60BB46; border-radius:12px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.1); text-align:center; padding:40px;">
                    
                    <div style="font-size:60px;">&#9989;</div>
                    <h3 style="color:#60BB46; margin:15px 0;">Payment Successful!</h3>
                    <p style="color:#555;">Your eSewa payment has been processed successfully.</p>
                    <hr>

                    <table style="width:100%; font-size:15px; text-align:left; margin:20px 0;">
                        <tr>
                            <td style="padding:6px;"><b>Transaction ID</b></td>
                            <td style="padding:6px; color:#60BB46;"><?php echo $transaction_code; ?></td>
                        </tr>
                        <tr>
                            <td style="padding:6px;"><b>eSewa ID</b></td>
                            <td style="padding:6px;"><?php echo $esewa_id; ?></td>
                        </tr>
                        <tr>
                            <td style="padding:6px;"><b>Winning Bid</b></td>
                            <td style="padding:6px;">Rs. <?php echo number_format($amount, 2); ?></td>
                        </tr>
                        <tr>
                            <td style="padding:6px;"><b>Service Charge (5%)</b></td>
                            <td style="padding:6px; color:red;">Rs. <?php echo number_format($commission, 2); ?></td>
                        </tr>
                        <tr style="border-top:2px solid #60BB46;">
                            <td style="padding:10px 6px;"><b>Total Paid</b></td>
                            <td style="padding:10px 6px; color:#60BB46; font-size:18px;"><b>Rs. <?php echo number_format($total, 2); ?></b></td>
                        </tr>
                        <tr>
                            <td style="padding:6px;"><b>Date</b></td>
                            <td style="padding:6px;"><?php echo date("d-M-Y"); ?></td>
                        </tr>
                    </table>

                    <a href="paymentreceiptwinningbid.php?paymentid=<?php echo $billing_id; ?>" 
                       class="btn btn-success" style="margin-right:10px;">
                        View Receipt
                    </a>
                    <a href="customeraccount.php" class="btn btn-primary">
                        Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
