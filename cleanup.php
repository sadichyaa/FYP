<?php
include("databaseconnection.php");

// Show all products
$sql = "SELECT product_id, product_name, start_date_time FROM product ORDER BY product_id DESC";
$q = mysqli_query($con, $sql);
echo "<h3>All Products</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Name</th><th>Start Time</th><th>Action</th></tr>";
while($r = mysqli_fetch_assoc($q)) {
    echo "<tr>
        <td>{$r['product_id']}</td>
        <td>{$r['product_name']}</td>
        <td>{$r['start_date_time']}</td>
        <td><a href='cleanup.php?delete={$r['product_id']}' onclick='return confirm(\"Delete this product?\")' style='color:red;'>DELETE</a></td>
    </tr>";
}
echo "</table>";

// Handle delete
if(isset($_GET['delete'])) {
    $pid = intval($_GET['delete']);
    mysqli_query($con, "DELETE FROM product WHERE product_id='$pid'");
    mysqli_query($con, "DELETE FROM bidding WHERE product_id='$pid'");
    mysqli_query($con, "DELETE FROM winners WHERE product_id='$pid'");
    echo "<script>alert('Product $pid deleted'); window.location='cleanup.php';</script>";
}
?>
