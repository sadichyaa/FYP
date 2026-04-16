<?php
include("header.php");
include("dbconnection.php");

// ✅ GET RECEIVER ID
$receiver_id = 0;
if(isset($_GET['receiver_id']))
{
    $receiver_id = $_GET['receiver_id'];
}

// ✅ SEND MESSAGE
if(isset($_POST['send']))
{
    $message = $_POST['message'];
    $sender_id = $_SESSION['customer_id'];

    if($message != "")
    {
        $sql = "INSERT INTO message(sender_id,receiver_id,message,message_date_time) 
                VALUES('$sender_id','$receiver_id','$message',NOW())";
        mysqli_query($con,$sql);
    }
}
?>

<div class="container" style="margin-top:50px;">
<h3>Chat Window</h3>

<div class="row">

<!-- ================= LEFT SIDE (USERS) ================= -->
<div class="col-md-4">

<?php
$sqlmessage = "SELECT * FROM message 
LEFT JOIN customer ON message.sender_id=customer.customer_id 
GROUP BY message.sender_id 
ORDER BY message.message_date_time DESC";

$qsqlmessage = mysqli_query($con,$sqlmessage);

while($rsmessage = mysqli_fetch_array($qsqlmessage))
{
?>
    <a href="?receiver_id=<?php echo $rsmessage['sender_id']; ?>" class="chatperson">
        <span class="chatimg">
            <img src="http://via.placeholder.com/50x50?text=A" />
        </span>
        <div class="namechat">
            <div class="pname"><?php echo $rsmessage['customer_name']; ?></div>
            <div class="lastmsg"><?php echo $rsmessage['message']; ?></div>
        </div>
    </a>
<?php
}
?>

</div>

<!-- ================= RIGHT SIDE (CHAT BOX) ================= -->
<div class="col-md-8">

<div class="chatbody">

<?php
if($receiver_id != 0)
{
    $sqlmessage = "SELECT * FROM message 
    LEFT JOIN customer ON message.sender_id=customer.customer_id 
    WHERE (sender_id='$receiver_id' OR receiver_id='$receiver_id') 
    ORDER BY message.message_date_time ASC";

    $qsqlmessage = mysqli_query($con,$sqlmessage);

    while($rsmessage = mysqli_fetch_array($qsqlmessage))
    {
?>
    <div class="chatmsg">
        <b><?php echo $rsmessage['customer_name']; ?></b> 
        <small><?php echo date("d-M-Y h:i A",strtotime($rsmessage['message_date_time'])); ?></small>
        <br>
        <?php echo $rsmessage['message']; ?>
    </div>
<?php
    }
}
else
{
    echo "<p>Select a user to start chatting</p>";
}
?>

</div>

<!-- ================= SEND MESSAGE ================= -->
<?php if($receiver_id != 0) { ?>
<form method="post">
<div class="row" style="margin-top:10px;">
    <div class="col-xs-10">
        <textarea name="message" class="form-control" placeholder="Enter message..." required></textarea>
    </div>
    <div class="col-xs-2">
        <button type="submit" name="send" class="btn btn-success">Send</button>
    </div>
</div>
</form>
<?php } ?>

</div>
</div>
</div>

<style>
.chatperson{
  display:flex;
  align-items:center;
  border-bottom:1px solid #eee;
  padding:10px;
  text-decoration:none;
}
.chatperson:hover{
  background:#f5f5f5;
}
.chatimg img{
  width:40px;
  height:40px;
  border-radius:50%;
}
.namechat{
  margin-left:10px;
}
.pname{
  font-size:16px;
  font-weight:bold;
}
.lastmsg{
  font-size:12px;
  color:gray;
}

.chatbody{
  height:400px;
  overflow:auto;
  border:1px solid #ddd;
  padding:10px;
  background:#fafafa;
}

.chatmsg{
  margin-bottom:10px;
  padding:8px;
  background:white;
  border-radius:5px;
  border:1px solid #ddd;
}
</style>

<?php include("footer.php"); ?>