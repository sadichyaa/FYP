<?php
include("header.php");

define('ESEWA_SECRET_KEY', '8gBm/:&EnhH.1/q');
define('ESEWA_MERCHANT_ID', 'EPAYTEST');
define('ESEWA_VERIFY_URL', 'https://rc-epay.esewa.com.np/api/epay/transaction/status/');

$status = $_GET['status'] ?? 'failure';

if($status == 'failure') {
    echo "<script>alert('Payment failed or cancelled. Please try again.'); window.location='viewwinningbid.php';</script>";
    exit;
}

// Decode the response data from eSewa
$data_base64 = $_GET['data'] ?? '';
if(empty($data_base64)) {
    echo "<script>alert('Invalid payment response.'); window.location='viewwinningbid.php';</script>";
    exit;
}

$data = json_decode(base64_decode($data_base64), true);

if(!$data) {
    echo "<script>alert('Could not decode payment response.'); window.location='viewwinningbid.php';</script>";
    exit;
}

$transaction_uuid  = $data['transaction_uuid'] ?? '';
$total_amount      = $data['total_amount'] ?? '';
$transaction_code  = $data['transaction_code'] ?? '';
$esewa_status      = $data['status'] ?? '';

// Verify signature
$message   = "transaction_code={$transaction_code},status={$esewa_status},total_amount={$total_amount},transaction_uuid={$transaction_uuid},product_code=" . ESEWA_MERCHANT_ID . ",signed_field_names=transaction_code,status,total_amount,transaction_uuid,product_code,signed_field_names";
$signature = base64_encode(hash_hmac('sha256', $message, ESEWA_SECRET_KEY, true));

if($signature !== ($data['signature'] ?? '')) {
    echo "<script>alert('Payment signature verification failed!'); window.location='viewwinningbid.php';</script>";
    exit;
}

// Check session data
$winner_id   = $_SESSION['esewa_winner_id']   ?? '';
$amount      = $_SESSION['esewa_amount']      ?? '';
$product_id  = $_SESSION['esewa_product_id']  ?? '';
$customer_id = $_SESSION['esewa_customer_id'] ?? '';

if(empty($winner_id) || empty($customer_id)) {
    echo "<script>alert('Session expired. Please try again.'); window.location='viewwinningbid.php';</script>";
    exit;
}

if($esewa_status == 'COMPLETE') {

    // Update winner status
    $sql = "UPDATE winners SET status='Active' WHERE winner_id='$winner_id'";
    mysqli_query($con, $sql);

    // Insert payment record
    $dt = date("Y-m-d");
    $sql = "INSERT INTO payment (payment_type, paid_amount, paid_date, status, customer_id, product_id, bidding_id)
            VALUES('eSewa', '$amount', '$dt', 'Active', '$customer_id', '$product_id', '0')";
    mysqli_query($con, $sql);

    // Insert billing record
    $verify_token = md5(rand());
    $sql = "INSERT INTO billing (email_id, purchase_date, product_id, purchase_amount, payment_type, card_type, card_number, expire_date, cvv_number, card_holder, verify_token, status, customer_id)
            VALUES('', '$dt', '$product_id', '$amount', 'Winners', 'eSewa', '$transaction_code', '$dt', '', 'eSewa Payment', '$verify_token', 'Active', '$customer_id')";
    $qsql = mysqli_query($con, $sql);
    $billing_id = mysqli_insert_id($con);

    // Clear session
    unset($_SESSION['esewa_txn']);
    unset($_SESSION['esewa_amount']);
    unset($_SESSION['esewa_winner_id']);
    unset($_SESSION['esewa_product_id']);
    unset($_SESSION['esewa_customer_id']);

    // Redirect to receipt
    echo "<script>alert('Payment of Rs.$amount successful via eSewa!'); window.location='paymentreceiptwinningbid.php?paymentid=$billing_id';</script>";

} else {
    echo "<script>alert('Payment was not completed. Status: $esewa_status'); window.location='viewwinningbid.php';</script>";
}
?>
