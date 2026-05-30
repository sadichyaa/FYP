<?php
include("header.php");

if(!isset($_GET['winner_id'])) {
    echo "<script>alert('Invalid request'); window.location='customeraccount.php';</script>";
    exit;
}

$winner_id = $_GET['winner_id'];

$sql = "SELECT * FROM winners 
        LEFT JOIN product ON winners.product_id = product.product_id 
        LEFT JOIN customer ON winners.customer_id = customer.customer_id 
        WHERE winners.winner_id='$winner_id' AND winners.customer_id='" . $_SESSION['customer_id'] . "'";
$qsql = mysqli_query($con, $sql);
$rs = mysqli_fetch_array($qsql);

if(!$rs) {
    echo "<script>alert('No winning bid found'); window.location='customeraccount.php';</script>";
    exit;
}

$amount         = $rs['winning_bid'];
$commission     = round($amount * 0.05, 2);   // 5% admin commission
$total_amount   = $amount + $commission;
$product_id     = $rs['product_id'];
$customer_id    = $rs['customer_id'];
$customer_name  = $rs['customer_name'];
$product_name   = $rs['product_name'];

// Store in session
$_SESSION['esewa_amount']      = $amount;
$_SESSION['esewa_commission']  = $commission;
$_SESSION['esewa_total']       = $total_amount;
$_SESSION['esewa_winner_id']   = $winner_id;
$_SESSION['esewa_product_id']  = $product_id;
$_SESSION['esewa_customer_id'] = $customer_id;
?>

<div class="content-wraper mt-50">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div style="border:2px solid #60BB46; border-radius:12px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.1);">
                    
                    <!-- eSewa Header -->
                    <div style="background:#60BB46; padding:20px; text-align:center;">
                        <h3 style="color:white; margin:0; font-size:24px;">&#128176; eSewa Payment</h3>
                        <p style="color:white; margin:5px 0 0; font-size:13px;">Secure Digital Payment</p>
                    </div>

                    <!-- Payment Summary -->
                    <div style="background:#f9fff9; padding:20px; border-bottom:1px solid #ddd;">
                        <table style="width:100%; font-size:15px;">
                            <tr>
                                <td style="padding:6px 0; color:#555;">Product</td>
                                <td style="padding:6px 0; text-align:right;"><b><?php echo $product_name; ?></b></td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0; color:#555;">Winning Bid</td>
                                <td style="padding:6px 0; text-align:right;">Rs. <?php echo number_format($amount, 2); ?></td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0; color:#555;">Service Charge (5%)</td>
                                <td style="padding:6px 0; text-align:right; color:red;">+ Rs. <?php echo number_format($commission, 2); ?></td>
                            </tr>
                            <tr style="border-top:2px solid #60BB46;">
                                <td style="padding:10px 0; font-size:17px;"><b>Total Payable</b></td>
                                <td style="padding:10px 0; text-align:right; font-size:17px; color:#60BB46;"><b>Rs. <?php echo number_format($total_amount, 2); ?></b></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Simulated eSewa Login Form -->
                    <form action="esewa_process.php" method="POST" style="padding:25px;">
                        <input type="hidden" name="winner_id"   value="<?php echo $winner_id; ?>">
                        <input type="hidden" name="amount"      value="<?php echo $amount; ?>">
                        <input type="hidden" name="commission"  value="<?php echo $commission; ?>">
                        <input type="hidden" name="total"       value="<?php echo $total_amount; ?>">
                        <input type="hidden" name="product_id"  value="<?php echo $product_id; ?>">
                        <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">

                        <div style="margin-bottom:15px;">
                            <label style="font-weight:bold; color:#333;">eSewa ID / Mobile Number</label>
                            <input type="text" name="esewa_id" class="form-control" 
                                   placeholder="Enter eSewa ID" required
                                   style="border:1px solid #60BB46; border-radius:6px; padding:10px; margin-top:5px;">
                        </div>

                        <div style="margin-bottom:20px;">
                            <label style="font-weight:bold; color:#333;">Password</label>
                            <input type="password" name="esewa_password" class="form-control" 
                                   placeholder="Enter Password" required
                                   style="border:1px solid #60BB46; border-radius:6px; padding:10px; margin-top:5px;">
                        </div>

                        <button type="submit" 
                                style="width:100%; background:#60BB46; color:white; border:none; padding:14px; border-radius:8px; font-size:16px; font-weight:bold; cursor:pointer;">
                            Pay Rs. <?php echo number_format($total_amount, 2); ?>
                        </button>

                        <div style="text-align:center; margin-top:15px;">
                            <a href="viewwinningbid.php" style="color:red; font-size:13px;">Cancel Payment</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
