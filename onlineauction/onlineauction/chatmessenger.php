<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("databaseconnection.php");
date_default_timezone_set('Asia/Kolkata');

$dttim = date("Y-m-d H:i:s");

/* ---------------- SAFE SESSION SET ---------------- */
if (isset($_POST['senderid']) && $_POST['senderid'] != 0) {
    $_SESSION['senderid'] = $_POST['senderid'];
}

if (isset($_POST['receiverid']) && $_POST['receiverid'] != 0) {
    $_SESSION['receiverid'] = $_POST['receiverid'];
}

if (isset($_POST['productid']) && $_POST['productid'] != 0) {
    $_SESSION['productid'] = $_POST['productid'];
}

/* ---------------- SAFE VARIABLES ---------------- */
$senderid   = isset($_SESSION['senderid']) ? $_SESSION['senderid'] : 0;
$receiverid = isset($_SESSION['receiverid']) ? $_SESSION['receiverid'] : 0;
$productid  = isset($_SESSION['productid']) ? $_SESSION['productid'] : 0;

/* ---------------- INSERT MESSAGE ---------------- */
if (isset($_POST['message']) && $_POST['message'] != "") {

    if ($senderid == 0 || $receiverid == 0) {
        die("Session not set properly for chat.");
    }

    $message = mysqli_real_escape_string($con, $_POST['message']);

    if ($productid == 0) {
        $product_sql = "NULL";
    } else {
        $product_sql = "'$productid'";
    }

    $sql = "INSERT INTO message 
            (sender_id, receiver_id, message_date_time, product_id, message, status)
            VALUES 
            ('$senderid', '$receiverid', '$dttim', $product_sql, '$message', 'Seller')";

    mysqli_query($con, $sql);

    if (mysqli_error($con)) {
        die("Insert Error: " . mysqli_error($con));
    }
}

/* ---------------- VALIDATION BEFORE SELECT ---------------- */
if ($senderid == 0 || $receiverid == 0) {
    die("Chat session not initialized.");
}

/* ---------------- FETCH MESSAGES ---------------- */
$sqlmessage = "
SELECT 
    message.*,
    sender.name AS sender_name,
    receiver.name AS receiver_name
FROM message
LEFT JOIN customer AS sender ON sender.customer_id = message.sender_id
LEFT JOIN customer AS receiver ON receiver.customer_id = message.receiver_id
WHERE message.sender_id = '$senderid'
AND message.receiver_id = '$receiverid'
";

if ($productid != 0) {
    $sqlmessage .= " AND message.product_id = '$productid'";
}

$sqlmessage .= " ORDER BY message.message_date_time ASC";

$qsqlmessage = mysqli_query($con, $sqlmessage);

/* ---------------- SQL ERROR CHECK ---------------- */
if (!$qsqlmessage) {
    die("SQL Error: " . mysqli_error($con));
}

/* ---------------- DISPLAY MESSAGES ---------------- */
while ($rsmessage = mysqli_fetch_assoc($qsqlmessage)) {

    $sendername = $rsmessage['sender_name'];

?>

<div class="direct-chat-messages" style="padding-left:10px;">
    <div class="direct-chat-msg doted-border">
        <div class="direct-chat-text">
            <b><?php echo $sendername; ?></b>
            | <?php echo date("d-M-Y h:i A", strtotime($rsmessage['message_date_time'])); ?>
            <br>
            <b><?php echo htmlspecialchars($rsmessage['message']); ?></b>
        </div>
    </div>
</div>

<?php } ?>