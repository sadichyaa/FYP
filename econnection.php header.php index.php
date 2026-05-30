[1mdiff --cc databaseconnection.php[m
[1mindex 77965b2,72db7c9..0000000[m
[1m--- a/databaseconnection.php[m
[1m+++ b/databaseconnection.php[m
[36m@@@ -1,5 -1,5 +1,5 @@@[m
  <?php[m
  // Create connection[m
[31m -$con=mysqli_connect("localhost","root","","onlineauctions");[m
[32m +$con=mysqli_connect("localhost","root","","onlineauction");[m
  echo mysqli_connect_error();[m
[31m--?>[m
[32m++?>[m
[1mdiff --cc header.php[m
[1mindex 0e3d78c,dac46b1..0000000[m
[1m--- a/header.php[m
[1m+++ b/header.php[m
[36m@@@ -1,504 -1,33 +1,539 @@@[m
[31m -<!DOCTYPE html>[m
[31m -<html>[m
[31m -<head>[m
[31m -    <title>Online Auction</title>[m
[31m -    <style>[m
[31m -        body {[m
[31m -            font-family: Arial, sans-serif;[m
[31m -        }[m
[31m -        .navbar {[m
[31m -            background: #333;[m
[31m -            padding: 10px;[m
[31m -        }[m
[31m -        .navbar a {[m
[31m -            color: white;[m
[31m -            margin-right: 15px;[m
[31m -            text-decoration: none;[m
[31m -            font-size: 18px;[m
[31m -        }[m
[31m -        .navbar a:hover {[m
[31m -            color: yellow;[m
[32m +<?php[m
[32m +session_start();[m
[32m +error_reporting(E_ALL & ~E_NOTICE  &  ~E_STRICT &  ~E_WARNING);[m
[32m +//default_time_stamp();[m
[32m +include("productlistcss.php");[m
[32m +date_default_timezone_set('Asia/Kolkata');[m
[32m +include("databaseconnection.php");[m
[32m +$currentpagename= trim(basename($_SERVER['PHP_SELF']));	[m
[32m +$dttim = date("Y-m-d H:i:s");[m
[32m +//Default record starts here[m
[32m +$sqlemployee = "SELECT * FROM employee WHERE employee_id='1'";[m
[32m +$qsqlemployee = mysqli_query($con,$sqlemployee);[m
[32m +echo mysqli_error($con);[m
[32m +if(mysqli_num_rows($qsqlemployee) == 0)[m
[32m +{[m
[32m +	$sqlINSERTemployee= "INSERT INTO employee(employee_id,employee_name,login_id,password,employee_type,status) VALUES('1','Administrator','Admin','admin','Admin','Active')";[m
[32m +	mysqli_query($con,$sqlINSERTemployee);[m
[32m +	echo mysqli_error($con);[m
[32m +}[m
[32m +//Default record ends here[m
[32m +date_default_timezone_set('Asia/Kolkata');[m
[32m +$dt = date("Y-m-d");[m
[32m +$tim = date("H:i:s");[m
[32m +$currentpagename= trim(basename($_SERVER['PHP_SELF']));	[m
[32m +if(isset($_POST['btnlogin']))[m
[32m +{[m
[32m +	$sql= "SELECT * FROM customer WHERE email_id='$_POST[emailid]' AND password='$_POST[password]' AND status='Active'";[m
[32m +	$qresult = mysqli_query($con,$sql);[m
[32m +	if(mysqli_num_rows($qresult) == 1 )[m
[32m +	{[m
[32m +		$rs = mysqli_fetch_array($qresult);[m
[32m +		$_SESSION['customer_id'] = $rs['customer_id'];[m
[32m +		[m
[32m +		$sql = "SELECT SUM(purchase_amount) FROM billing WHERE customer_id='" . $_SESSION['customer_id'] . "' and status='Active' and payment_type='Deposit'";[m
[32m +		$qsql = mysqli_query($con,$sql);[m
[32m +		$rs = mysqli_fetch_array($qsql);[m
[32m +		$depamt =  $rs[0];[m
[32m +[m
[32m +		$sql = "SELECT SUM(paid_amount) FROM payment WHERE customer_id='" . $_SESSION['customer_id'] . "' and status='Active' and payment_type='Bid'";[m
[32m +		$qsql = mysqli_query($con,$sql);[m
[32m +		$rs = mysqli_fetch_array($qsql);[m
[32m +		$widamt = $rs[0];[m
[32m +		$accbalamt = $depamt-$widamt;[m
[32m +		if($accbalamt > 0)[m
[32m +		{[m
[32m +			echo "<script>window.location='index.php';</script>";[m
[32m +		}[m
[32m +		else[m
[32m +		{[m
[32m +			echo "<script>window.location='deposit.php';</script>";[m
[32m +		}[m
[32m +	}[m
[32m +	else[m
[32m +	{[m
[32m +		echo "<script>alert('Failed to login...');</script>";[m
[32m +	}[m
[32m +}[m
[31m- $sqlwinningbid ="SELECT * FROM product LEFT JOIN winners ON product.product_id = winners.product_id LEFT JOIN bidding ON bidding.product_id=product.product_id WHERE product.ending_bid=bidding.bidding_amount AND product.status='Active' AND product.end_date_time<'$dt $tim' AND winners.product_id IS NULL";[m
[31m- $qsqlwinningbid  = mysqli_query($con,$sqlwinningbid);[m
[32m++$sqlwinningbid = "SELECT product.product_id, product.end_date_time, MAX(bidding.bidding_amount) as max_bid, bidding.customer_id [m
[32m++                  FROM product [m
[32m++                  LEFT JOIN bidding ON bidding.product_id = product.product_id [m
[32m++                  LEFT JOIN winners ON winners.product_id = product.product_id [m
[32m++                  WHERE product.status='Active' [m
[32m++                  AND product.end_date_time < NOW() [m
[32m++                  AND winners.product_id IS NULL[m
[32m++                  AND bidding.bidding_amount IS NOT NULL[m
[32m++                  GROUP BY product.product_id";[m
[32m++$qsqlwinningbid = mysqli_query($con, $sqlwinningbid);[m
[32m +while($rswinningbid = mysqli_fetch_array($qsqlwinningbid))[m
[32m +{[m
[31m- 	$sqlwinner ="INSERT INTO winners(product_id,customer_id,winning_bid,end_date,status) VALUES('$rswinningbid[0]','$rswinningbid[23]','$rswinningbid[6]','$rswinningbid[26]','Pending')";[m
[31m- 	mysqli_query($con,$sqlwinner);[m
[32m++    $sqlwinner = "INSERT INTO winners(product_id,customer_id,winning_bid,end_date,status) [m
[32m++                  VALUES('$rswinningbid[product_id]','$rswinningbid[customer_id]','$rswinningbid[max_bid]','$rswinningbid[end_date_time]','Pending')";[m
[32m++    mysqli_query($con, $sqlwinner);[m
[32m++}[m
[32m++[m
[32m++// Notify logged-in customer if they won and redirect to eSewa[m
[32m++if(isset($_SESSION['customer_id']))[m
[32m++{[m
[32m++    $sqlcheckwinner = "SELECT winners.winner_id, product.product_name [m
[32m++                       FROM winners [m
[32m++                       LEFT JOIN product ON winners.product_id = product.product_id[m
[32m++                       WHERE winners.customer_id='" . $_SESSION['customer_id'] . "' [m
[32m++                       AND winners.status='Pending'[m
[32m++                       LIMIT 1";[m
[32m++    $qsqlcheckwinner = mysqli_query($con, $sqlcheckwinner);[m
[32m++    if(mysqli_num_rows($qsqlcheckwinner) > 0)[m
[32m++    {[m
[32m++        $rswinner = mysqli_fetch_array($qsqlcheckwinner);[m
[32m++        $winner_id = $rswinner['winner_id'];[m
[32m++        $product_name = addslashes($rswinner['product_name']);[m
[32m++        $current_page = basename($_SERVER['PHP_SELF']);[m
[32m++        if(!in_array($current_page, ['esewa_payment.php','esewa_verify.php','viewwinningbid.php','logout.php','paymentreceiptwinningbid.php']))[m
[32m++        {[m
[32m++            // Store in session so JS can pick it up after page loads[m
[32m++            $_SESSION['winner_popup_id']   = $winner_id;[m
[32m++            $_SESSION['winner_popup_name'] = $product_name;[m
[32m+         }[m
[31m -    </style>[m
[31m -</head>[m
[31m -<body>[m
[31m -[m
[31m -<div class="navbar">[m
[31m -    <a href="index.php">Home</a>[m
[31m -    <a href="registry.php">Register</a>[m
[31m -    <a href="employeelogin.php">Employee Login</a>[m
[31m -    <a href="customerlogin.php">Customer Login</a>[m
[32m++    }[m
[32m +}[m
[32m +if(isset($_SESSION['customer_id']))[m
[32m +{[m
[32m +	$sql = "SELECT SUM(purchase_amount) FROM billing WHERE customer_id='" . $_SESSION['customer_id'] . "' and status='Active' and payment_type='Deposit'";[m
[32m +	$qsql = mysqli_query($con,$sql);[m
[32m +	$rs = mysqli_fetch_array($qsql);[m
[32m +	$depamt =  $rs[0];[m
[32m +[m
[32m +	$sql = "SELECT SUM(paid_amount) FROM payment WHERE customer_id='" . $_SESSION['customer_id'] . "' and status='Active' and payment_type='Bid'";[m
[32m +	$qsql = mysqli_query($con,$sql);[m
[32m +	$rs = mysqli_fetch_array($qsql);[m
[32m +	$widamt = $rs[0];[m
[32m +[m
[32m +	$accbalamt = $depamt-$widamt;[m
[32m +	[m
[32m +}[m
[32m +if(!isset($_SESSION['customer_id']))[m
[32m +{[m
[32m +	$pagenames=array("","deposit.php","viewwinningbid.php");[m
[32m +	if(array_search($currentpagename,$pagenames) >=1)[m
[32m +	{[m
[32m +		echo "<script>window.location='login.php';</script>";[m
[32m +	}[m
[32m +}[m
[32m +?>[m
[32m +<html class="no-js" lang="en">[m
[32m +<head>[m
[32m +        <meta charset="utf-8">[m
[32m +        <meta http-equiv="x-ua-compatible" content="ie=edge">[m
[32m +        <title>Online Auction</title>[m
[32m +        <meta name="description" content="">[m
[32m +        <meta name="viewport" content="width=device-width, initial-scale=1">	[m
[32m +        <!-- Place favicon.ico in the root directory -->[m
[32m +	    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">	[m
[32m +		<!-- all CSS hear -->		[m
[32m +        <link rel="stylesheet" href="css/bootstrap.min.css">[m
[32m +        <link rel="stylesheet" href="css/font-awesome.min.css">[m
[32m +        <link rel="stylesheet" href="css/ionicons.min.css">[m
[32m +        <link rel="stylesheet" href="css/animate.css">[m
[32m +        <link rel="stylesheet" href="css/nice-select.css">[m
[32m +        <link rel="stylesheet" href="css/owl.carousel.min.css">[m
[32m +        <link rel="stylesheet" href="css/mainmenu.css">[m
[32m +        <link rel="stylesheet" href="style.css">[m
[32m +        <link rel="stylesheet" href="css/responsive.css">	[m
[32m +        <link rel="stylesheet" href="css/jquery.dataTables.min.css">	[m
[32m +        <script src="js/vendor/modernizr-2.8.3.min.js"></script>[m
[32m +		<style>[m
[32m +			.errormsg[m
[32m +			{[m
[32m +				color: red;[m
[32m +				padding-left: 5px;[m
[32m +			}[m
[32m +[m
[32m +		</style>[m
[32m +    </head>[m
[32m +    <body>[m
[32m +        <!-- Add your application content here -->[m
[32m +        [m
[32m +        <div class="wrapper home-3">            [m
[32m +            <!-- header start -->[m
[32m +            <header>[m
[32m +                <!-- header-top start -->[m
[32m +                <div class="header-top bg-black">[m
[32m +                    <div class="container-fluid">[m
[32m +                        <div class="row">[m
[32m +                            <div class="col-lg-2 col-md-3 md-custom-12">[m
[32m +                                <!-- logo start -->[m
[32m +                                <div class="logo">[m
[32m +                                    <a href="index.php"><img src="img/logo/logoo.PNG" alt=""></a>[m
[32m +                                </div>[m
[32m +                                <!-- logo end -->[m
[32m +                            </div>[m
[32m +                            <div class="col-lg-10 col-md-9 md-custom-12">[m
[32m +                                <div class="row">[m
[32m +<?php[m
[32m +if(!isset($_SESSION['employee_id']))[m
[32m +{[m
[32m +?>[m
[32m +                                    <div class="col-lg-3 d-none d-lg-block">[m
[32m +[m
[32m +                                    </div>[m
[32m +<?php[m
[32m +}[m
[32m +?>[m
[32m +<?php[m
[32m +if(isset($_SESSION['employee_id']))[m
[32m +{[m
[32m +?>[m
[32m +<div class="col-lg-12 col-md-12">[m
[32m +<?php[m
[32m +}[m
[32m +else[m
[32m +{[m
[32m +?>[m
[32m +<div class="col-lg-9 col-md-12">[m
[32m +<?php[m
[32m +}[m
[32m +?>[m
[32m +                                        <!-- full-setting-area start -->[m
[32m +                                        <div class="full-setting-area setting-style-3">[m
[32m +<div class="top-dropdown">[m
[32m +	<ul>[m
[32m +	<?php[m
[32m +	if(isset($_SESSION['customer_id']))[m
[32m +	{[m
[32m +	?>[m
[32m +		<li><a href="customeraccount.php">Dashboard</a></li>[m
[32m +		[m
[32m +		[m
[32m +		<li><a href="messagebox.php">Message Box</a></li> [m
[32m +		[m
[32m +		[m
[32m +		<li class="drodown-show"><a href="#"> View My Bid <i class="fa fa-angle-down"></i></a>[m
[32m +			<ul class="open-dropdown setting">[m
[32m +			[m
[32m +		<li><a href="viewmybid.php">My Bid (<?php[m
[32m +$sql = "SELECT * FROM bidding WHERE customer_id='" . $_SESSION['customer_id'] . "'";[m
[32m +$qsql = mysqli_query($con,$sql);[m
[32m +echo mysqli_num_rows($qsql);[m
[32m +?>)</a></li>[m
[32m +[m
[32m +				<li><a href="viewwinningbid.php">Winning Bid (<?php[m
[32m +$sql = "sELECT * FROM winners LEFT JOIN product ON winners.product_id=product.product_id WHERE product.customer_id!='0' AND winners.customer_id='" . $_SESSION['customer_id'] . "'";[m
[32m +$qsql = mysqli_query($con,$sql);[m
[32m +echo mysqli_num_rows($qsql);[m
[32m +?>)</a></li>[m
[32m +[m
[32m +				<!-- <li><a href="reversebidwinner.php">Reverse Bid (<?php[m
[32m +					$sql = "SELECT MIN(t1.bidding_amount) AS price, t1.product_id FROM ( SELECT `bidding_amount`, product_id FROM bidding WHERE bidding.customer_id='" . $_SESSION['customer_id'] . "' GROUP BY `bidding_amount`, product_id HAVING COUNT(`bidding_amount`) = 1) t1";[m
[32m +					$qsql = mysqli_query($con,$sql);[m
[32m +					echo mysqli_num_rows($qsql);[m
[32m +					?>)</a></li> -->[m
[32m +[m
[32m +<li><a href="viewbillingcustomer.php">View Trasaction</a></li>[m
[32m +			</ul>[m
[32m +		</li>[m
[32m +		<li class="drodown-show"><a href="#"> My Products <i class="fa fa-angle-down"></i></a>[m
[32m +			<ul class="open-dropdown setting">[m
[32m +				<li><a href="selectcategory.php">Add Products</a></li>[m
[32m +				<li><a href="viewproduct.php">View Products</a></li>[m
[32m +			</ul>[m
[32m +		</li>[m
[32m +		<li class="drodown-show"><a href="#"> My account <i class="fa fa-angle-down"></i></a>[m
[32m +			<ul class="open-dropdown setting">[m
[32m +				<li><a href="customerprofile.php">Profile</a></li>[m
[32m +				<!-- <li><a href="custchangepassword.php">Change password</a></li>  -->[m
[32m +				<li><a href="logout.php">Logout</a></li>[m
[32m +			</ul>[m
[32m +		</li>[m
[32m +	<?php[m
[32m +	}[m
[32m +	else if(isset($_SESSION['employee_id']))[m
[32m +	{[m
[32m +	?>[m
[32m +						[m
[32m +		<!-- <li class="drodown-show"><a href="#"> Reverse Product <i class="fa fa-angle-down"></i></a>[m
[32m +			<ul class="open-dropdown setting">[m
[32m +				<li><a href="selectreversebidcategory.php">Add Product</a></li>[m
[32m +				<li><a href="viewreverseproduct.php">View Products</a></li>[m
[32m +			</ul>[m
[32m +		</li> -->[m
[32m +		[m
[32m +		<li class="drodown-show"><a href="#"> Users <i class="fa fa-angle-down"></i></a>[m
[32m +			<ul class="open-dropdown setting">[m
[32m +			<?php[m
[32m +			if($_SESSION['employee_type'] == "Admin")[m
[32m +			{[m
[32m +			?>[m
[32m +				<!-- <li><a href="employee.php">Add Staff</a></li>[m
[32m +				<li><a href="viewemployee.php">View Staff</a></li> -->[m
[32m +			<?php[m
[32m +			}[m
[32m +			?>[m
[32m +				<li><a href="viewcustomer.php">View Customers</a></li>[m
[32m +			</ul>[m
[32m +		</li>[m
[32m +		[m
[32m +			<?php[m
[32m +			if($_SESSION['employee_type'] == "Admin")[m
[32m +			{[m
[32m +			?>[m
[32m +		<li class="drodown-show"><a href="#"> Categories <i class="fa fa-angle-down"></i></a>[m
[32m +			<ul class="open-dropdown setting">[m
[32m +				<li><a href="category.php">Add Categories</a></li>[m
[32m +				<li><a href="viewcategory.php">View Categories</a></li>[m
[32m +			</ul>[m
[32m +		</li>[m
[32m +			<?php[m
[32m +			}[m
[32m +			?>[m
[32m +		<li class="drodown-show"><a href="#"> Bidding Report <i class="fa fa-angle-down"></i></a>[m
[32m +			<ul class="open-dropdown setting">[m
[32m +				<li><a href="viewbiddingproduct.php">Current Bidding</a></li>[m
[32m +				<li><a href="closebiddingproduct.php">Closed Bidding</a></li>[m
[32m +				<li><a href="viewwinners.php">View Winners List</a></li>[m
[32m +			</ul>[m
[32m +		</li>[m
[32m +		<li class="drodown-show"><a href="#"> Report <i class="fa fa-angle-down"></i></a>[m
[32m +			<ul class="open-dropdown setting">[m
[32m +				<!-- <li><a href="viewbilling.php">View Billing</a></li> -->[m
[32m +				<!-- <li><a href="viewcustomer.php">Customer Report</a></li> -->[m
[32m +				<li><a href="viewmessage.php">View Messages</a></li>[m
[32m +				<li><a href="viewpayment.php">View Payment</a></li>[m
[32m +				<li><a href="viewproduct.php">View products</a></li>[m
[32m +			</ul>[m
[32m +		</li>[m
[32m +		<li class="drodown-show"><a href="#"> My account <i class="fa fa-angle-down"></i></a>[m
[32m +			<ul class="open-dropdown setting">[m
[32m +				<li><a href="employeeaccount.php">Dashboard</a></li>[m
[32m +				<!-- <li><a href="empprofile.php">My Profile</a></li>[m
[32m +				<li><a href="empchangepassword.php">Change password</a></li> -->[m
[32m +				<li><a href="logout.php">Logout</a></li>[m
[32m +			</ul>[m
[32m +		</li>[m
[32m +	<?php[m
[32m +	}[m
[32m +	else[m
[32m +	{[m
[32m +	?>[m
[32m +	<li><a href="index.php">Home</a></li>[m
[32m +<!-- <li><a href="about-us.php">About</a></li> -->[m
[32m +<li><a href="contact.php">Contact</a></li>[m
[32m +[m
[32m +			<li><a href="register.php">Register</a></li>[m
[32m +			<li><a href="customerlogin.php">Login</a></li>[m
[32m +			<li><a href="employeelogin.php?logintype=Admin">Admin Login</a></li>[m
[32m +	<?php[m
[32m +	}[m
[32m +	?>[m
[32m +	</ul>[m
[32m +</div>[m
[32m +                                        </div>[m
[32m +                                        <!-- full-setting-area end -->[m
[32m +                                    </div>[m
[32m +                                </div>[m
[32m +                            </div>[m
[32m +                            [m
[32m +                        </div>[m
[32m +                    </div>[m
[32m +                </div>[m
[32m +                <!-- header-top end -->[m
[32m +                <!-- header-mid-area start -->[m
[32m +                <div class="header-mid-area header-mid-style-3 bg-black">[m
[32m +                    <div class="container-fluid">[m
[32m +                        <div class="row">[m
[32m +                            <div class="col-lg-12 pl-5"> [m
[32m +								<!-- hot-line-area start -->[m
[32m +                                <div class="hot-line-area">[m
[32m +                                    <div class="phone">[m
[32m +                                        Customer Support: <span>+977-9821677333 </span>[m
[32m +                                    </div>[m
[32m +                                </div>[m
[32m +                                <!-- hot-line-area end -->[m
[32m +                              [m
[32m +[m
[32m +                                <!-- searchbox start-->[m
[32m +[m
[32m +                                 <div class="searchbox pl-5 pr-3">[m
[32m +<form action="searchproduct.php" method="get">[m
[32m +	<div class="search-form-input">[m
[32m +<select id="searchcategory_id" name="searchcategory_id" class="nice-select">[m
[32m +	<option value="">All Categories</option> [m
[32m +	<?php[m
[32m +	$sqlcategory ="SELECT * FROM category WHERE status='Active'";[m
[32m +	$qsqlcategory = mysqli_query($con,$sqlcategory);[m
[32m +	while($rscategory = mysqli_fetch_array($qsqlcategory))[m
[32m +	{[m
[32m +		if($rscategory['category_id'] == $_GET['searchcategory_id'])[m
[32m +		{[m
[32m +			echo "<option value='" . $rscategory['category_id'] . "' selected >" . $rscategory['category_name'] . "</option>";[m
[32m +		}[m
[32m +		else[m
[32m +		{[m
[32m +			echo "<option value='" . $rscategory['category_id'] . "'>" . $rscategory['category_name'] . "</option>";[m
[32m +		}[m
[32m +	}[m
[32m +	?>[m
[32m +</select>[m
[32m +		<input type="text" name="searchcriteria" placeholder="Enter your search key ... " value="<?php echo $_GET['searchcriteria']; ?>">[m
[32m +		<button class="top-search-btn" type="submitsearch">Search</button>[m
[32m +	</div>[m
[32m +</form>[m
[32m +                                </div> [m
[32m +                                <!-- searchbox end -->[m
[32m +[m
[32m +<!-- <div class="shopping-cart-box white-cart-box">[m
[32m +<ul>[m
[32m +<?php[m
[32m +if(isset($_SESSION['customer_id']))[m
[32m +{[m
[32m +?>[m
[32m +[m
[32m +<li>[m
[32m +<a href="deposit.php">[m
[32m +<span class="item-cart-inner" >[m
[32m +Balance[m
[32m +</span>[m
[32m +<div class="item-total" >Rs.<?php echo $accbalamt; ?></div>[m
[32m +</a>[m
[32m +</li>[m
[32m +<?php[m
[32m +}[m
[32m +else[m
[32m +{[m
[32m +?>[m
[32m +<li>[m
[32m +<a href="customerlogin.php">[m
[32m +	<span class="item-cart-inner" >[m
[32m +	Deposit[m
[32m +	</span>[m
[32m +	<div class="item-total"></div>[m
[32m +</a>[m
[32m +</li>			[m
[32m +<?php[m
[32m +}[m
[32m +?> -->[m
[32m +[m
[32m +[m
[32m +[m
[32m +</ul>[m
[32m +</div>[m
[32m +[m
[32m +<!-- shopping-cart-box start -->                            </div>[m
[32m +                        </div>[m
[32m +                    </div>[m
[32m +                </div>[m
[32m +                <!-- header-mid-area end -->[m
[32m +                <!-- header-bottom-area start -->[m
[32m +                <div class="header-bottom-area bg-black" style="background-color: #f3f3f3;">[m
[32m +                    <div class="container-fluid">[m
[32m +                        <div class="row">[m
[32m +                            <div class="col-lg-12 d-none d-lg-block">[m
[32m +                                <!-- main-menu-area start -->[m
[32m +                                <div class="main-menu-area">[m
[32m +                                    <nav>[m
[32m +                                        <ul>[m
[32m +[m
[32m +<li><a href="latestauction.php?auctiontype=Latest Auctions" style="color:black;">Latest Auctions</a></li>[m
[32m +<li><a href="featured.php?auctiontype=featured Auctions" style="color:black;">Featured Auctions</a></li>[m
[32m +[m
[32m +[m
[32m +<li><a href="closed.php?auctiontype=Closed Auctions" style="color:black;" >Closed Auctions</a></li>[m
[32m +[m
[32m +[m
[32m +                                        </ul>[m
[32m +                                    </nav>[m
[32m +                                </div>[m
[32m +                                <!-- main-menu-area end -->[m
[32m +                            </div>[m
[32m +                        </div>[m
[32m +                    </div>[m
[32m +                </div>[m
[32m +                <!-- header-bottom-area end -->[m
[32m +            </header>[m
[32m +            <!-- header end -->[m
[32m +<?php[m
[32m +if(basename($_SERVER['PHP_SELF']) == "index.php")[m
[32m +{[m
[32m +?>[m
[32m +<!-- slider-main-area start -->[m
[32m +<div class="slider-main-area">[m
[32m +	<div class="slider-active owl-carousel">[m
[32m +		<!-- slider-wrapper start -->[m
[32m +		<div class="slider-wrapper" style="background-image:url(img/slider/bgimage.jpg); width: 100%;height: 100vh; filter: brightness(70%) ">[m
[32m +			<div class="container-fluid">[m
[32m +				<div class="row">[m
[32m +					<div class="col">[m
[32m +						<div class="slider-text-info style-2 text-center slider-text-animation">[m
[32m +							<h1 class="title1" ><span class="text"> Second Chance Online Thrift Auction.</span></h1>[m
[32m +						[m
[32m +							<p style="background-color:powderblue;font-weight: bold; color:black;">SELL YOUR OLD STUFF. </span> GET NEW STUFF YOU LOVE.</p>[m
[32m +							<div class="slier-btn-1">[m
[32m +								<a title="Bid now" href="latestauction.php?auctiontype=Latest%20Auctions" class="shop-btn">View Latest Auctions</a>[m
[32m +							</div>[m
[32m +						</div>[m
[32m +					</div>[m
[32m +				</div>[m
[32m +			</div>[m
[32m +		</div>[m
[32m +		<!-- slider-wrapper end -->[m
[32m +		<!-- slider-wrapper start -->[m
[32m +[m
[32m +[m
[32m +[m
[32m +[m
[32m +[m
[32m +		<!-- slider-wrapper start -->[m
[32m +		<!-- <div class="slider-wrapper" style="background-image:url(img/slider/home-3-01.jpg);width: 100%; filter: brightness(70%) ">[m
[32m +			<div class="container-fluid">[m
[32m +				<div class="row">[m
[32m +					<div class="col">[m
[32m +						<div class="slider-text-info style-2 text-center slider-text-animation">[m
[32m +							<h1 class="title1"><span class="text">Bid For Products..</span></h1>[m
[32m +							<p>Convinient auction platform..</p>[m
[32m +							<div class="slier-btn-1">[m
[32m +								<a title="Bid now" href="latestauction.php?auctiontype=Latest%20Auctions" class="shop-btn">View Latest Auctions</a>[m
[32m +							</div>[m
[32m +						</div>[m
[32m +					</div>[m
[32m +				</div>[m
[32m +			</div>[m
[32m +		</div> -->[m
[32m +		<!-- <div class="slider-wrapper" style="background-image:url(img/slider/bid.png);width: 100%;">[m
[32m +			<div class="container-fluid">[m
[32m +				<div class="row">[m
[32m +					<div class="col">[m
[32m +						<div class="slider-text-info style-2 text-center slider-text-animation">[m
[32m +							<h1 class="title1"><span class="text">Online Auction.. </span> </h1>[m
[32m +							<p>Convinient auction platform..</p>[m
[32m +							<div class="slier-btn-1">[m
[32m +								<a title="Bid now" href="featured.php?auctiontype=featured%20Auctions" class="shop-btn">View Featured Auctions</a>[m
[32m +							</div>[m
[32m +						</div>[m
[32m +					</div>[m
[32m +				</div>[m
[32m +			</div>[m
[32m +		</div> -->[m
[32m +		<!-- slider-wrapper end -->[m
[32m +		<!-- slider-wrapper start -->[m
[32m +		<!-- <div class="slider-wrapper" style="background-image:url(img/slider/home-3-1.jpg);width: 100%;">[m
[32m +			<div class="container-fluid">[m
[32m +				<div class="row">[m
[32m +					<div class="col">[m
[32m +						<div class="slider-text-info style-2 text-center slider-text-animation">[m
[32m +							<h1 class="title1"><span class="text">Online Auction.. </span> </h1>[m
[32m +							<p>Convinient auction platform..</p>[m
[32m +							<div class="slier-btn-1">[m
[32m +								<a title="Bid now" href="latestauction.php?auctiontype=Latest%20Auctions" class="shop-btn">View Upcoming Auctions</a>[m
[32m +							</div>[m
[32m +						</div>[m
[32m +					</div>[m
[32m +				</div>[m
[32m +			</div>[m
[32m +		</div> -->[m
[32m +		<!-- slider-wrapper end -->[m
[32m +	</div>[m
  </div>[m
[32m +<!-- slider-main-area end -->[m
[32m +<?php[m
[32m +}[m
[31m- ?>[m
[32m++?>[m
[32m+ [m
[31m -<hr>[m
[1mdiff --cc index.php[m
[1mindex 17bfcdf,940be60..0000000[m
[1m--- a/index.php[m
[1m+++ b/index.php[m
[36m@@@ -1,593 -1,145 +1,153 @@@[m
[31m -<!DOCTYPE html>[m
[31m -<html>[m
[31m -<head>[m
[31m -    <title>Auction Home</title>[m
[31m -    <style>[m
[31m -        body { margin:0; font-family:Arial; background:#f5f5f5; }[m
[31m -[m
[31m -        /* Header */[m
[31m -        .topbar {[m
[31m -            background:#005bbb;[m
[31m -            color:white;[m
[31m -            padding:15px;[m
[31m -            font-size:20px;[m
[31m -            display:flex;[m
[31m -            justify-content:space-between;[m
[31m -            align-items:center;[m
[31m -        }[m
[31m -[m
[31m -        .topbar .logo {[m
[31m -            font-size:24px;[m
[31m -            font-weight:bold;[m
[31m -        }[m
[31m -[m
[31m -        .topbar a {[m
[31m -            color:white;[m
[31m -            margin-left:15px;[m
[31m -            text-decoration:none;[m
[31m -            font-size:16px;[m
[31m -        }[m
[31m -[m
[31m -        /* Product Sections */[m
[31m -        .section-title {[m
[31m -            text-align:center;[m
[31m -            margin:40px 0 10px 0;[m
[31m -            font-size:28px;[m
[31m -            font-weight:bold;[m
[32m +<?php[m
[32m +include("header.php");[m
[32m +?>[m
[32m +<script>[m
[32m +function countdowntimer(id, time)[m
[32m +{[m
[31m- 		// Set the date we're counting down to[m
[31m- 		var countDownDate = new Date(time).getTime();[m
[31m- [m
[31m- 		// Update the count down every 1 second[m
[31m- 		var x = setInterval(function() {[m
[31m- [m
[31m- 		// Get todays date and time[m
[31m- 		var now = new Date().getTime();[m
[31m- 		[m
[31m- 		// Find the distance between now an the count down date[m
[31m- 		var distance = countDownDate - now;[m
[31m- 		[m
[31m- 		// Time calculations for days, hours, minutes and seconds[m
[31m- 		var days = Math.floor(distance / (1000 * 60 * 60 * 24));[m
[31m- 		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));[m
[31m- 		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));[m
[31m- 		var seconds = Math.floor((distance % (1000 * 60)) / 1000);[m
[31m- 		[m
[31m- 		// Output the result in an element with id="demo"[m
[31m- 		document.getElementById("countdowntime"+id).innerHTML = "<b  style='color: red;'>Time Remaining</b> <br><b>" + days + "Days " + hours + "hrs " + minutes + "min " + seconds + "sec</b>";[m
[31m- 		[m
[31m- 		// If the count down is over, write some text [m
[31m- 		if (distance < 0) {[m
[31m- 			clearInterval(x);[m
[31m- 			document.getElementById("countdowntime"+id).innerHTML = "<center><b  style='color: red;'>EXPIRED</b></center>";[m
[31m- 		}[m
[31m- 	}, 1000);[m
[31m- 	[m
[32m++    var countDownDate = new Date(time).getTime();[m
[32m++    var x = setInterval(function() {[m
[32m++        var now = new Date().getTime();[m
[32m++        var distance = countDownDate - now;[m
[32m++        var days    = Math.floor(distance / (1000 * 60 * 60 * 24));[m
[32m++        var hours   = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));[m
[32m++        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));[m
[32m++        var seconds = Math.floor((distance % (1000 * 60)) / 1000);[m
[32m++        document.getElementById("countdowntime"+id).innerHTML =[m
[32m++            "<b style='color:red;'>Time Remaining</b><br><b>" + days + "Days " + hours + "hrs " + minutes + "min " + seconds + "sec</b>";[m
[32m++        if (distance < 0) {[m
[32m++            clearInterval(x);[m
[32m++            document.getElementById("countdowntime"+id).innerHTML = "<center><b style='color:red;'>EXPIRED</b></center>";[m
[32m+         }[m
[31m -[m
[31m -        .products {[m
[31m -            display:flex;[m
[31m -            flex-wrap:wrap;[m
[31m -            justify-content:center;[m
[31m -            gap:20px;[m
[31m -            padding:20px;[m
[31m -        }[m
[31m -[m
[31m -        .product {[m
[31m -            width:250px;[m
[31m -            background:white;[m
[31m -            border-radius:10px;[m
[31m -            padding:15px;[m
[31m -            box-shadow:0 0 10px #ccc;[m
[31m -            text-align:center;[m
[31m -        }[m
[31m -[m
[31m -        .product img {[m
[31m -            width:100%;[m
[31m -            height:200px;[m
[31m -            background:#ddd;[m
[31m -            border-radius:10px;[m
[31m -        }[m
[31m -[m
[31m -        .btn {[m
[31m -            display:inline-block;[m
[31m -            margin-top:10px;[m
[31m -            padding:10px 20px;[m
[31m -            background:#005bbb;[m
[31m -            color:white;[m
[31m -            text-decoration:none;[m
[31m -            border-radius:5px;[m
[31m -        }[m
[31m -    </style>[m
[31m -</head>[m
[31m -[m
[31m -<body>[m
[31m -[m
[31m -<!-- ======================== -->[m
[31m -<!-- This is header.php       -->[m
[31m -<!-- ======================== -->[m
[31m -<div class="topbar">[m
[31m -    <div class="logo">AUCTION SYSTEM</div>[m
[31m -    <div class="nav">[m
[31m -        <a href="index.php">Home</a>[m
[31m -        <a href="customerlogin.php">Login</a>[m
[31m -        <a href="registry.php">Register</a>[m
[31m -        <a href="employeelogin.php">Employee Login</a>[m
[32m++    }, 1000);[m
[32m +}[m
[31m- </script> [m
[32m++</script>[m
[32m++[m
[32m++<hr>[m
[32m +[m
[31m- <hr>		[m
[31m-             <!-- Latest Auctions start -->[m
[31m-             <div class="product-area pb-95">[m
[31m-                 <div class="container-fluid">[m
[31m-                     <div class="row">[m
[31m-                         <div class="col">[m
[31m-                             <div class="row">[m
[31m-                                 <div class="col">[m
[31m-                                     <div class="section-title-3">[m
[31m-                                         <h2>Latest Auctions</h2>[m
[31m-                                     </div>[m
[31m-                                 </div>[m
[31m-                             </div>[m
[31m-                             <div class="row">[m
[31m-                                 <div class="col">[m
[31m-                                     <div class="tab-content">[m
[31m-                                         <div id="for-men" class="tab-pane active show" role="tabpanel">[m
[31m-                                             <div class="row">[m
[31m-                                                 <div class="product-active-3 owl-carousel">[m
[32m++<!-- ===== Latest Auctions ===== -->[m
[32m++<div class="product-area pb-95">[m
[32m++    <div class="container-fluid">[m
[32m++        <div class="row">[m
[32m++            <div class="col">[m
[32m++                <div class="section-title-3"><h2>Latest Auctions</h2></div>[m
[32m++                <div class="row">[m
[32m++                    <div class="col">[m
[32m++                        <div class="product-active-3 owl-carousel">[m
[32m +<?php[m
[31m- $i=0;[m
[31m- 			$sqlproduct = "select product.*,category.category_name from product LEFT JOIN category on product.category_id=category.category_id WHERE product.status='Active' AND product.customer_id!='0' AND product.customer_id!='0' AND start_date_time<='$dttim' order by product.product_id DESC limit 0,4";[m
[31m- 			$qsqlproduct = mysqli_query($con,$sqlproduct);[m
[31m- 			while($rsproduct = mysqli_fetch_array($qsqlproduct))[m
[31m- 			{[m
[31m- 				$i++;[m
[31m- 				if (file_exists("imgproduct/".$rsproduct['product_image'])) [m
[31m- 				{[m
[31m- 					 $imgname = "imgproduct/".$rsproduct['product_image'];[m
[31m- 				} [m
[31m- 				else [m
[31m- 				{[m
[31m- 					$imgname = "images/cloth.jpg";[m
[31m- 				}[m
[32m++$i = 0;[m
[32m++$sqlproduct = "SELECT product.*, category.category_name [m
[32m++               FROM product [m
[32m++               LEFT JOIN category ON product.category_id = category.category_id [m
[32m++               WHERE product.status='Active' [m
[32m++               AND product.end_date_time > NOW() [m
[32m++               GROUP BY product.product_id[m
[32m++               ORDER BY product.product_id DESC LIMIT 0,8";[m
[32m++$qsqlproduct = mysqli_query($con, $sqlproduct);[m
[32m++while($rsproduct = mysqli_fetch_array($qsqlproduct))[m
[32m++{[m
[32m++    $i++;[m
[32m++    $arr_pro_img = unserialize($rsproduct['product_image']);[m
[32m++    $imgname = ($arr_pro_img && file_exists("imgproduct/".$arr_pro_img[0]))[m
[32m++        ? "imgproduct/".$arr_pro_img[0][m
[32m++        : "images/noimage.gif";[m
[32m +?>[m
[32m +<div class="col">[m
[31m- 	<!-- single-product-wrap start -->[m
[31m- 	<div class="single-product-wrap">[m
[31m- 		<div class="product-image box"  style="height:350px;width:100%;">[m
[31m- 			<a href="single.php?productid=<?php echo $rsproduct[0]; ?>">[m
[31m- 				<img class="primary-image" src="<?php echo $imgname; ?>" alt=""  style="width:100%; height:100%">[m
[31m- 				<?php /*<img class="secondary-image" src="<?php echo $imgname; ?>" alt=""> */ ?>[m
[31m- 			</a>[m
[31m- 			<div class="label-product"><?php echo $rsproduct['category_name']; ?></div>[m
[31m- 		</div>[m
[31m- 		<div class="product_desc">[m
[31m- 			<div class="product_desc_info">[m
[31m- <?php[m
[31m- [m
[31m- ?>				[m
[31m- 				<h4><a class="product_name" href="single.php?productid=<?php echo $rsproduct[0]; ?>"><?php echo $rsproduct['product_name']; ?></a></h4>[m
[31m- 		<div class="manufacturer"><a href="single.php?productid=<?php echo $rsproduct[0]; ?>">Product Code: <?php echo $rsproduct['product_id']; ?></a></div>[m
[31m- <!-- Timer code starts here -->[m
[31m- <?php  ?>[m
[31m- <script type="application/javascript">countdowntimer('<?php echo $rsproduct[0].$i; ?>', '<?php echo date("M d, Y H:i:s",strtotime($rsproduct['end_date_time'])); ?>');</script>[m
[31m- <!-- Timer code ends here -->[m
[31m- 				<div class="price-box">[m
[31m- 					<span class="new-price">Current Bid Amount : Rs.<?php [m
[31m- 					if($rsproduct['ending_bid'] > $rsproduct['starting_bid'])[m
[31m- 					{[m
[31m- 					echo $rsproduct['ending_bid']; [m
[31m- 					}[m
[31m- 					else[m
[31m- 					{[m
[31m- 					echo $rsproduct['starting_bid'];[m
[31m- 					}[m
[31m- 					?></span>[m
[31m- 					<?php  ?>[m
[31m- 				</div>[m
[31m- 			</div>[m
[31m- 			<div class="add-actions">[m
[31m- 				<ul class="add-actions-link">[m
[31m- 					<li class="add-cart"><a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><i class="ion-android-cart"></i> Click here to BID</a></li>[m
[31m- 				<?php[m
[31m- 				[m
[31m- 					?>[m
[31m- 				</ul>[m
[31m- 			</div>[m
[31m- 		</div>[m
[31m- 	</div>[m
[31m- 	<!-- single-product-wrap end -->[m
[31m- </div>[m
[31m- 			<?php[m
[31m- 			}[m
[31m- 			?>[m
[31m- 												[m
[31m- 												</div>[m
[31m-                                             </div>[m
[31m-                                         </div>[m
[31m- 									</div>[m
[31m-                                 </div>[m
[31m-                             </div>[m
[31m-                         </div>[m
[31m-                     </div>[m
[32m++    <div class="single-product-wrap">[m
[32m++        <div class="product-image box" style="height:250px;width:100%;display:flex;align-items:center;justify-content:center;background:#f9f9f9;">[m
[32m++            <a href="single.php?productid=<?php echo $rsproduct['product_id']; ?>">[m
[32m++                <img class="primary-image" src="<?php echo $imgname; ?>" alt="" style="max-height:250px;max-width:100%;width:auto;height:auto;object-fit:contain;">[m
[32m++            </a>[m
[32m++            <div class="label-product"><?php echo $rsproduct['category_name']; ?></div>[m
[32m++        </div>[m
[32m++        <div class="product_desc">[m
[32m++            <div class="product_desc_info">[m
[32m++                <h4><a class="product_name" href="single.php?productid=<?php echo $rsproduct['product_id']; ?>"><?php echo $rsproduct['product_name']; ?></a></h4>[m
[32m++                <div class="manufacturer">Product Code: <?php echo $rsproduct['product_id']; ?></div>[m
[32m++                <p id="countdowntime<?php echo $rsproduct['product_id'].$i; ?>"></p>[m
[32m++                <script>countdowntimer('<?php echo $rsproduct['product_id'].$i; ?>', '<?php echo date("M d, Y H:i:s", strtotime($rsproduct['end_date_time'])); ?>');</script>[m
[32m++                <div class="price-box">[m
[32m++                    <span class="new-price">Current Bid: Rs.<?php echo ($rsproduct['ending_bid'] > $rsproduct['starting_bid']) ? $rsproduct['ending_bid'] : $rsproduct['starting_bid']; ?></span>[m
[32m +                </div>[m
[32m +            </div>[m
[31m-             <!-- Latest Auctions end -->[m
[31m- [m
[31m- 			<div class="product-area pb-95">[m
[31m-                 <div class="container-fluid">[m
[31m-                     <div class="row">[m
[31m-                         <div class="col">[m
[31m-                             <div class="row">[m
[31m-                                 <div class="col">[m
[31m-                                     <div class="section-title-3">[m
[31m-                                         <h2>Featured Auctions</h2>[m
[31m-                                     </div>[m
[31m-                                 </div>[m
[31m-                             </div>[m
[31m- 							[m
[31m-                             <div class="row">[m
[31m-                                 <div class="col">[m
[31m-                                     <div class="tab-content">[m
[31m-                                         <div id="for-men" class="tab-pane active show" role="tabpanel">[m
[31m-                                             <div class="row">[m
[31m-                                                 <div class="product-active-3 owl-carousel">[m
[31m- 												[m
[31m- 	<?php[m
[31m- $i=0;	[m
[31m- 	?><?php[m
[31m- 			$sqlproduct = "select product.*,category.category_name from product LEFT JOIN category on product.category_id=category.category_id WHERE product.status='Active' AND product.customer_id!='0' AND end_date_time<'$dttim' order by product.product_id ASC limit 0,4";[m
[31m- 			$qsqlproduct = mysqli_query($con,$sqlproduct);[m
[31m- 			while($rsproduct = mysqli_fetch_array($qsqlproduct))[m
[31m- 			{[m
[31m- 				$i++;[m
[31m- 				if (file_exists("imgproduct/".$rsproduct['product_image'])) [m
[31m- 				{[m
[31m- 					 $imgname = "imgproduct/".$rsproduct['product_image'];[m
[31m- 				} [m
[31m- 				else [m
[31m- 				{[m
[31m- 					$imgname = "images/noimage.gif";[m
[31m- 				}[m
[31m- ?>[m
[31m- <div class="col">[m
[31m- 	<!-- single-product-wrap start -->[m
[31m- 	<div class="single-product-wrap">[m
[31m- 		<div class="product-image box"  style="height:350px;width:100%;">[m
[31m- 			<a href="single.php?productid=<?php echo $rsproduct[0]; ?>">[m
[31m- 				<img class="primary-image" src="<?php echo $imgname; ?>" alt=""  style="width:100%; height:100%">[m
[31m- 				<?php /*<img class="secondary-image" src="<?php echo $imgname; ?>" alt=""> */ ?>[m
[31m- 			</a>[m
[31m- 			<div class="label-product"><?php echo $rsproduct['category_name']; ?></div>[m
[31m- 		</div>[m
[31m- 		<div class="product_desc">[m
[31m- 			<div class="product_desc_info">[m
[31m- <?php[m
[31m- /*			[m
[31m- 				<div class="rating-box">[m
[31m- 					<ul class="rating">[m
[31m- 						<li><i class="fa fa-star"></i></li>[m
[31m- 						<li><i class="fa fa-star"></i></li>[m
[31m- 						<li><i class="fa fa-star"></i></li>[m
[31m- 						<li class="no-star"><i class="fa fa-star"></i></li>[m
[31m- 						<li class="no-star"><i class="fa fa-star"></i></li>[m
[31m- 					</ul>[m
[31m- 				</div>[m
[31m- */[m
[31m- ?>				[m
[31m- 				<h4><a class="product_name" href="single.php?productid=<?php echo $rsproduct[0]; ?>"><?php echo $rsproduct['product_name']; ?></a></h4>[m
[31m- 		<div class="manufacturer"><a href="single.php?productid=<?php echo $rsproduct[0]; ?>">Product Code: <?php echo $rsproduct['product_id']; ?></a></div>[m
[31m- <!-- Timer code starts here -->[m
[31m- <p id="countdowntime<?php echo $rsproduct[0].$i; ?>"></p>[m
[31m- <script type="application/javascript">countdowntimer('<?php echo $rsproduct[0].$i; ?>', '<?php echo date("M d, Y H:i:s",strtotime($rsproduct['end_date_time'])); ?>');</script>[m
[31m- <!-- Timer code ends here -->[m
[31m- 				<div class="price-box">[m
[31m- 					<span class="new-price">Current Bid Amount : Rs.<?php [m
[31m- 					if($rsproduct['ending_bid'] > $rsproduct['starting_bid'])[m
[31m- 					{[m
[31m- 					echo $rsproduct['ending_bid']; [m
[31m- 					}[m
[31m- 					else[m
[31m- 					{[m
[31m- 					echo $rsproduct['starting_bid'];[m
[31m- 					}[m
[31m- 					?></span>[m
[31m- 					<?php /*<span class="old-price">$250.00</span> */ ?>[m
[31m- 				</div>[m
[31m- 			</div>[m
[31m- 			<div class="add-actions">[m
[31m- 				<ul class="add-actions-link">[m
[31m- 					<li class="add-cart"><a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><i class="ion-android-cart"></i> Click here to BID</a></li>[m
[31m- 				<?php[m
[31m- 				/*[m
[31m- 					<li><a class="quick-view" data-toggle="modal" data-target="#exampleModalCenter" href="#"><i class="ion-android-open"></i></a></li>[m
[31m- 					<li><a class="links-details" href="single-product.php"><i class="ion-clipboard"></i></a></li>[m
[31m- 					*/[m
[31m- 					?>[m
[31m- 				</ul>[m
[31m- 			</div>[m
[31m- 		</div>[m
[31m- 	</div>[m
[31m- 	<!-- single-product-wrap end -->[m
[32m++            <div class="add-actions">[m
[32m++                <ul class="add-actions-link">[m
[32m++                    <li class="add-cart"><a href="single.php?productid=<?php echo $rsproduct['product_id']; ?>"><i class="ion-android-cart"></i> Click here to BID</a></li>[m
[32m++                </ul>[m
[32m++            </div>[m
[32m++        </div>[m
[32m+     </div>[m
  </div>[m
[31m- 			<?php[m
[31m- 			}[m
[31m- 			?>[m
[31m- 												[m
[31m- 												</div>[m
[31m-                                             </div>[m
[31m-                                         </div>[m
[31m- 									</div>[m
[31m-                                 </div>[m
[31m-                             </div>[m
[31m-                         [m
[31m- 							</div>[m
[31m -<!-- END OF header.php -->[m
[31m -[m
[31m -<!-- Banner -->[m
[31m -<div style="width:100%; height:300px; background:#d9d9d9; display:flex; justify-content:center; align-items:center; font-size:30px;">[m
[31m -    Banner / Slider Area[m
[31m -</div>[m
[31m -[m
[31m -<!-- Latest Auctions -->[m
[31m -<div class="section-title">Latest Auctions</div>[m
[31m -<div class="products">[m
[31m -    <div class="product">[m
[31m -        <img src="images/sample.jpg">[m
[31m -        <h3>Product Name</h3>[m
[31m -        <p>Product Code: 12345</p>[m
[31m -        <a class="btn">Bid Now</a>[m
[31m -    </div>[m
[31m -[m
[31m -    <div class="product">[m
[31m -        <img src="images/sample.jpg">[m
[31m -        <h3>Product Name</h3>[m
[31m -        <p>Product Code: 12345</p>[m
[31m -        <a class="btn">Bid Now</a>[m
[31m -    </div>[m
[31m -</div>[m
[31m -[m
[31m -<!-- Featured Auctions -->[m
[31m -<div class="section-title">Featured Auctions</div>[m
[31m -<div class="products">[m
[31m -    <div class="product">[m
[31m -        <img src="images/sample.jpg">[m
[31m -        <h3>Featured Product</h3>[m
[31m -        <a class="btn">View</a>[m
[32m++<?php } ?>[m
[32m++                        </div>[m
[32m +                    </div>[m
[32m +                </div>[m
[32m +            </div>[m
[31m-             [m
[31m- [m
[31m-             <!-- Featured Auctions end -->[m
[31m-             <!-- <hr> -->[m
[31m-             <!-- Upcoming Auctions start -->[m
[31m-             <!-- <div class="product-area pb-95">[m
[31m-                 <div class="container-fluid">[m
[31m-                     <div class="row">[m
[31m-                         <div class="col">[m
[31m-                             <div class="row">[m
[31m-                                 <div class="col">[m
[31m-                                     <div class="section-title-3">[m
[31m-                                         <h2>Upcoming Auctions</h2>[m
[31m-                                     </div>[m
[31m-                                 </div>[m
[31m-                             </div>[m
[32m++        </div>[m
[32m+     </div>[m
[32m+ </div>[m
[31m -[m
[31m -<!-- Closing Soon -->[m
[31m -<div class="section-title">Closing Soon</div>[m
[31m -<div class="products">[m
[31m -    <div class="product">[m
[31m -        <img src="images/sample.jpg">[m
[31m -        <h3>Product Ending Soon</h3>[m
[31m -        <a class="btn">Bid Now</a>[m
[32m++<!-- Latest Auctions end -->[m
[32m +[m
[31m-                             <div class="row">[m
[31m-                                 <div class="col">[m
[31m-                                     <div class="tab-content">[m
[31m-                                         <div id="for-men" class="tab-pane active show" role="tabpanel">[m
[31m-                                             <div class="row">[m
[31m-                                                 <div class="product-active-3 owl-carousel">  -->[m
[31m-  												[m
[32m++<!-- ===== Closed Auctions ===== -->[m
[32m++<div class="product-area pb-95">[m
[32m++    <div class="container-fluid">[m
[32m++        <div class="row">[m
[32m++            <div class="col">[m
[32m++                <div class="section-title-3"><h2>Closed Auctions</h2></div>[m
[32m++                <div class="row">[m
[32m++                    <div class="col">[m
[32m++                        <div class="product-active-3 owl-carousel">[m
[32m +<?php[m
[31m- $i=0;[m
[31m- 			$sqlproduct = "select product.*,category.category_name from product LEFT JOIN category on product.category_id=category.category_id WHERE product.status='Active' AND product.customer_id!='0'  AND start_date_time>'$dttim' order by product.product_id DESC limit 0,4";[m
[31m- 			$qsqlproduct = mysqli_query($con,$sqlproduct);[m
[31m- 			while($rsproduct = mysqli_fetch_array($qsqlproduct))[m
[31m- 			{[m
[31m- 				$i++;[m
[31m- 				if (file_exists("imgproduct/".$rsproduct['product_image'])) [m
[31m- 				{[m
[31m- 					 $imgname = "imgproduct/".$rsproduct['product_image'];[m
[31m- 				} [m
[31m- 				else [m
[31m- 				{[m
[31m- 					$imgname = "images/noimage.gif";[m
[31m- 				}[m
[32m++$i = 0;[m
[32m++$sqlproduct = "SELECT product.*, category.category_name [m
[32m++               FROM product [m
[32m++               LEFT JOIN category ON product.category_id = category.category_id [m
[32m++               WHERE product.status='Active' [m
[32m++               AND product.end_date_time < NOW() [m
[32m++               GROUP BY product.product_id[m
[32m++               ORDER BY product.product_id DESC LIMIT 0,8";[m
[32m++$qsqlproduct = mysqli_query($con, $sqlproduct);[m
[32m++while($rsproduct = mysqli_fetch_array($qsqlproduct))[m
[32m++{[m
[32m++    $i++;[m
[32m++    $arr_pro_img = unserialize($rsproduct['product_image']);[m
[32m++    $imgname = ($arr_pro_img && file_exists("imgproduct/".$arr_pro_img[0]))[m
[32m++        ? "imgproduct/".$arr_pro_img[0][m
[32m++        : "images/noimage.gif";[m
[32m +?>[m
[32m +<div class="col">[m
[31m- 	<!-- single-product-wrap start -->[m
[31m- 	<div class="single-product-wrap">[m
[31m- 		<div class="product-image box"  style="height:350px;width:100%;">[m
[31m- 			<a href="single.php?productid=<?php echo $rsproduct[0]; ?>">[m
[31m- 				<img class="primary-image" src="<?php echo $imgname; ?>" alt=""  style="width:100%; height:100%">[m
[31m- 				<?php /*<img class="secondary-image" src="<?php echo $imgname; ?>" alt=""> */ ?>[m
[31m- 			</a>[m
[31m- 			<div class="label-product"><?php echo $rsproduct['category_name']; ?></div>[m
[31m- 		</div>[m
[31m- 		<div class="product_desc">[m
[31m- 			<div class="product_desc_info">[m
[31m- <?php[m
[31m- /*			[m
[31m- 				<div class="rating-box">[m
[31m- 					<ul class="rating">[m
[31m- 						<li><i class="fa fa-star"></i></li>[m
[31m- 						<li><i class="fa fa-star"></i></li>[m
[31m- 						<li><i class="fa fa-star"></i></li>[m
[31m- 						<li class="no-star"><i class="fa fa-star"></i></li>[m
[31m- 						<li class="no-star"><i class="fa fa-star"></i></li>[m
[31m- 					</ul>[m
[31m- 				</div>[m
[31m- */[m
[31m- ?>				[m
[31m- 				<h4><a class="product_name" href="single.php?productid=<?php echo $rsproduct[0]; ?>"><?php echo $rsproduct['product_name']; ?></a></h4>[m
[31m- 		<div class="manufacturer"><a href="single.php?productid=<?php echo $rsproduct[0]; ?>">Product Code: <?php echo $rsproduct['product_id']; ?></a></div>[m
[31m- <!-- Timer code starts here -->[m
[31m- <p id="countdowntime<?php echo $rsproduct[0].$i; ?>"></p>[m
[31m- <script type="application/javascript">countdowntimer('<?php echo $rsproduct[0].$i; ?>', '<?php echo date("M d, Y H:i:s",strtotime($rsproduct['end_date_time'])); ?>');</script>[m
[31m- <!-- Timer code ends here -->[m
[31m- 				<div class="price-box">[m
[31m- 					<span class="new-price">Current Bid Amount : Rs.<?php [m
[31m- 					if($rsproduct['ending_bid'] > $rsproduct['starting_bid'])[m
[31m- 					{[m
[31m- 					echo $rsproduct['ending_bid']; [m
[31m- 					}[m
[31m- 					else[m
[31m- 					{[m
[31m- 					echo $rsproduct['starting_bid'];[m
[31m- 					}[m
[31m- 					?></span>[m
[31m- 					<?php /*<span class="old-price">$250.00</span> */ ?>[m
[31m- 				</div>[m
[31m- 			</div>[m
[31m- 			<div class="add-actions">[m
[31m- 				<ul class="add-actions-link">[m
[31m- 					<li class="add-cart"><a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><i class="ion-android-cart"></i> Click here to BID</a></li>[m
[31m- 				<?php[m
[31m- 					/*[m
[31m- 					<li><a class="quick-view" data-toggle="modal" data-target="#exampleModalCenter" href="#"><i class="ion-android-open"></i></a></li>[m
[31m- 					<li><a class="links-details" href="single-product.php"><i class="ion-clipboard"></i></a></li>[m
[31m- 					*/[m
[31m- 				?>[m
[31m- 				</ul>[m
[31m- 			</div>[m
[31m- 		</div>[m
[31m- 	</div>[m
[31m- 	<!-- single-product-wrap end -->[m
[31m- </div>[m
[31m- 			<?php[m
[31m- 			}[m
[31m- 			?>[m
[31m- 												</div>[m
[31m-                                             </div>[m
[31m-                                         </div>[m
[31m- 									</div>[m
[31m-                                 </div>[m
[31m-                             </div>[m
[31m-                         [m
[31m- 						</div>[m
[31m-                     </div>[m
[32m++    <div class="single-product-wrap">[m
[32m++        <div class="product-image box" style="height:250px;width:100%;display:flex;align-items:center;justify-content:center;background:#f9f9f9;">[m
[32m++            <a href="single.php?productid=<?php echo $rsproduct['product_id']; ?>">[m
[32m++                <img class="primary-image" src="<?php echo $imgname; ?>" alt="" style="max-height:250px;max-width:100%;width:auto;height:auto;object-fit:contain;">[m
[32m++            </a>[m
[32m++            <div class="label-product"><?php echo $rsproduct['category_name']; ?></div>[m
[32m++        </div>[m
[32m++        <div class="product_desc">[m
[32m++            <div class="product_desc_info">[m
[32m++                <h4><a class="product_name" href="single.php?productid=<?php echo $rsproduct['product_id']; ?>"><?php echo $rsproduct['product_name']; ?></a></h4>[m
[32m++                <div class="manufacturer">Product Code: <?php echo $rsproduct['product_id']; ?></div>[m
[32m++                <p id="countdowntime<?php echo $rsproduct['product_id'].$i; ?>"></p>[m
[32m++                <script>countdowntimer('<?php echo $rsproduct['product_id'].$i; ?>', '<?php echo date("M d, Y H:i:s", strtotime($rsproduct['end_date_time'])); ?>');</script>[m
[32m++                <div class="price-box">[m
[32m++                    <span class="new-price">Final Bid: Rs.<?php echo ($rsproduct['ending_bid'] > $rsproduct['starting_bid']) ? $rsproduct['ending_bid'] : $rsproduct['starting_bid']; ?></span>[m
[32m +                </div>[m
[32m +            </div>[m
[31m-             <!-- Upcoming Auctions end -->[m
[31m-             <!-- <hr> -->[m
[31m-             <!-- Closing Auctions start -->[m
[31m-             <!-- <div class="product-area pb-95">[m
[31m-                 <div class="container-fluid">[m
[31m-                     <div class="row">[m
[31m-                         <div class="col">[m
[31m-                             <div class="row">[m
[31m-                                 <div class="col">[m
[31m-                                     <div class="section-title-3">[m
[31m-                                         <h2>Closing Auctions</h2>[m
[31m-                                     </div>[m
[31m-                                 </div>[m
[31m-                             </div>[m
[31m- [m
[31m-                             <div class="row">[m
[31m-                                 <div class="col">[m
[31m-                                     <div class="tab-content">[m
[31m-                                         <div id="for-men" class="tab-pane active show" role="tabpanel">[m
[31m-                                             <div class="row">[m
[31m-                                                 <div class="product-active-3 owl-carousel"> [m
[31m- 												 -->[m
[31m- 	<?php[m
[31m- $i=0;	[m
[31m- 	?><?php[m
[31m- 			$sqlproduct = "select product.*,category.category_name from product LEFT JOIN category on product.category_id=category.category_id WHERE product.status='Active' AND product.customer_id!='0'   AND product.end_date_time>'$dt $tim' AND product.end_date_time <'$dt 23:59:59'  order by product.product_id DESC limit 0,4";[m
[31m- 			$qsqlproduct = mysqli_query($con,$sqlproduct);[m
[31m- 			while($rsproduct = mysqli_fetch_array($qsqlproduct))[m
[31m- 			{[m
[31m- 				$i++;[m
[31m- 				if (file_exists("imgproduct/".$rsproduct['product_image'])) [m
[31m- 				{[m
[31m- 					 $imgname = "imgproduct/".$rsproduct['product_image'];[m
[31m- 				} [m
[31m- 				else [m
[31m- 				{[m
[31m- 					$imgname = "images/noimage.gif";[m
[31m- 				}[m
[31m- ?>[m
[31m- <div class="col">[m
[31m- 	<!-- single-product-wrap start -->[m
[31m- 	<div class="single-product-wrap">[m
[31m- 		<div class="product-image box"  style="height:350px;width:100%;">[m
[31m- 			<a href="single.php?productid=<?php echo $rsproduct[0]; ?>">[m
[31m- 				<img class="primary-image" src="<?php echo $imgname; ?>" alt=""  style="width:100%; height:100%">[m
[31m- 				<?php /*<img class="secondary-image" src="<?php echo $imgname; ?>" alt=""> */ ?>[m
[31m- 			</a>[m
[31m- 			<div class="label-product"><?php echo $rsproduct['category_name']; ?></div>[m
[31m- 		</div>[m
[31m- 		<div class="product_desc">[m
[31m- 			<div class="product_desc_info">[m
[31m- <?php[m
[31m- /*			[m
[31m- 				<div class="rating-box">[m
[31m- 					<ul class="rating">[m
[31m- 						<li><i class="fa fa-star"></i></li>[m
[31m- 						<li><i class="fa fa-star"></i></li>[m
[31m- 						<li><i class="fa fa-star"></i></li>[m
[31m- 						<li class="no-star"><i class="fa fa-star"></i></li>[m
[31m- 						<li class="no-star"><i class="fa fa-star"></i></li>[m
[31m- 					</ul>[m
[31m- 				</div>[m
[31m- */[m
[31m- ?>				[m
[31m- 				<h4><a class="product_name" href="single.php?productid=<?php echo $rsproduct[0]; ?>"><?php echo $rsproduct['product_name']; ?></a></h4>[m
[31m- 		<div class="manufacturer"><a href="single.php?productid=<?php echo $rsproduct[0]; ?>">Product Code: <?php echo $rsproduct['product_id']; ?></a></div>[m
[31m- <!-- Timer code starts here -->[m
[31m- <p id="countdowntime<?php echo $rsproduct[0].$i; ?>"></p>[m
[31m- <script type="application/javascript">countdowntimer('<?php echo $rsproduct[0].$i; ?>', '<?php echo date("M d, Y H:i:s",strtotime($rsproduct['end_date_time'])); ?>');</script>[m
[31m- <!-- Timer code ends here -->[m
[31m- 				<div class="price-box">[m
[31m- 					<span class="new-price">Current Bid Amount : Rs.<?php [m
[31m- 					if($rsproduct['ending_bid'] > $rsproduct['starting_bid'])[m
[31m- 					{[m
[31m- 					echo $rsproduct['ending_bid']; [m
[31m- 					}[m
[31m- 					else[m
[31m- 					{[m
[31m- 					echo $rsproduct['starting_bid'];[m
[31m- 					}[m
[31m- 					?></span>[m
[31m- 					<?php /*<span class="old-price">$250.00</span> */ ?>[m
[31m- 				</div>[m
[31m- 			</div>[m
[31m- 			<div class="add-actions">[m
[31m- 				<ul class="add-actions-link">[m
[31m- 					<li class="add-cart"><a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><i class="ion-android-cart"></i> Click here to BID</a></li>[m
[31m- 				<?php[m
[31m- 				/*[m
[31m- 					<li><a class="quick-view" data-toggle="modal" data-target="#exampleModalCenter" href="#"><i class="ion-android-open"></i></a></li>[m
[31m- 					<li><a class="links-details" href="single-product.php"><i class="ion-clipboard"></i></a></li>[m
[31m- 					*/[m
[31m- 					?>[m
[31m- 				</ul>[m
[31m- 			</div>[m
[31m- 		</div>[m
[31m- 	</div>[m
[31m- 	<!-- single-product-wrap end -->[m
[31m- </div>[m
[31m- 			<?php[m
[31m- 			}[m
[31m- 			?>[m
[31m- 												[m
[31m- 												</div>[m
[31m-                                             </div>[m
[31m-                                         </div>[m
[31m- 									</div>[m
[31m-                                 </div>[m
[31m-                             </div>[m
[31m-                         [m
[31m- 					   </div>[m
[31m-                     </div>[m
[31m-                 </div>[m
[32m++            <div class="add-actions">[m
[32m++                <ul class="add-actions-link">[m
[32m++                    <li class="add-cart"><a href="single.php?productid=<?php echo $rsproduct['product_id']; ?>"><i class="ion-eye"></i> View Product</a></li>[m
[32m++                </ul>[m
[32m +            </div>[m
[31m-             <!-- Closing Auctions end -->[m
[31m-             <!-- <hr> -->[m
[31m-             <!-- Closed Auctions start -->[m
[31m-             <div class="product-area pb-95">[m
[31m-                 <div class="container-fluid">[m
[31m-                     <div class="row">[m
[31m-                         <div class="col">[m
[31m-                             <div class="row">[m
[31m-                                 <div class="col">[m
[31m-                                     <div class="section-title-3">[m
[31m-                                         <h2>Closed Auctions</h2>[m
[31m-                                     </div>[m
[31m-                                 </div>[m
[31m-                             </div>[m
[31m- [m
[31m-                             <div class="row">[m
[31m-                                 <div class="col">[m
[31m-                                     <div class="tab-content">[m
[31m-                                         <div id="for-men" class="tab-pane active show" role="tabpanel">[m
[31m-                                             <div class="row">[m
[31m-                                                 <div class="product-active-3 owl-carousel">[m
[31m- 												[m
[31m- 	<?php[m
[31m- $i=0;	[m
[31m- 	?><?php[m
[31m- 			$sqlproduct = "select product.*,category.category_name from product LEFT JOIN category on product.category_id=category.category_id WHERE product.status='Active'  AND product.customer_id!='0' AND end_date_time<'$dt $tim' order by product.product_id DESC limit 0,4";[m
[31m- 			$qsqlproduct = mysqli_query($con,$sqlproduct);[m
[31m- 			while($rsproduct = mysqli_fetch_array($qsqlproduct))[m
[31m- 			{[m
[31m- 				$i++;[m
[31m- 				if (file_exists("imgproduct/".$rsproduct['product_image'])) [m
[31m- 				{[m
[31m- 					 $imgname = "imgproduct/".$rsproduct['product_image'];[m
[31m- 				} [m
[31m- 				else [m
[31m- 				{[m
[31m- 					$imgname = "images/bagg.jpg";[m
[31m- 				}[m
[31m- ?>[m
[31m- <div class="col">[m
[31m- 	<!-- single-product-wrap start -->[m
[31m- 	<div class="single-product-wrap">[m
[31m- 		<div class="product-image box"  style="height:350px;width:100%;">[m
[31m- 			<a href="single.php?productid=<?php echo $rsproduct[0]; ?>">[m
[31m- 				<img class="primary-image" src="<?php echo $imgname; ?>" alt=""  style="width:100%; height:100%">[m
[31m- 				<?php /*<img class="secondary-image" src="<?php echo $imgname; ?>" alt=""> */ ?>[m
[31m- 			</a>[m
[31m- 			<div class="label-product"><?php echo $rsproduct['category_name']; ?></div>[m
[31m- 		</div>[m
[31m- 		<div class="product_desc">[m
[31m- 			<div class="product_desc_info">[m
[31m- <?php[m
[31m- /*			[m
[31m- 				<div class="rating-box">[m
[31m- 					<ul class="rating">[m
[31m- 						<li><i class="fa fa-star"></i></li>[m
[31m- 						<li><i class="fa fa-star"></i></li>[m
[31m- 						<li><i class="fa fa-star"></i></li>[m
[31m- 						<li class="no-star"><i class="fa fa-star"></i></li>[m
[31m- 						<li class="no-star"><i class="fa fa-star"></i></li>[m
[31m- 					</ul>[m
[31m- 				</div>[m
[31m- */[m
[31m- ?>				[m
[31m- 				<h4><a class="product_name" href="single.php?productid=<?php echo $rsproduct[0]; ?>"><?php echo $rsproduct['product_name']; ?></a></h4>[m
[31m- 		<div class="manufacturer"><a href="single.php?productid=<?php echo $rsproduct[0]; ?>">Product Code: <?php echo $rsproduct['product_id']; ?></a></div>[m
[31m- <!-- Timer code starts here -->[m
[31m- <p id="countdowntime<?php echo $rsproduct[0].$i; ?>"></p>[m
[31m- <script type="application/javascript">countdowntimer('<?php echo $rsproduct[0].$i; ?>', '<?php echo date("M d, Y H:i:s",strtotime($rsproduct['end_date_time'])); ?>');</script>[m
[31m- <!-- Timer code ends here -->[m
[31m- 				<div class="price-box">[m
[31m- 					<span class="new-price">Current Bid Amount : Rs.<?php [m
[31m- 					if($rsproduct['ending_bid'] > $rsproduct['starting_bid'])[m
[31m- 					{[m
[31m- 					echo $rsproduct['ending_bid']; [m
[31m- 					}[m
[31m- 					else[m
[31m- 					{[m
[31m- 					echo $rsproduct['starting_bid'];[m
[31m- 					}[m
[31m- 					?></span>[m
[31m- 					<?php /*<span class="old-price">$250.00</span> */ ?>[m
[31m- 				</div>[m
[31m- 			</div>[m
[31m- 			<div class="add-actions">[m
[31m- 				<ul class="add-actions-link">[m
[31m- 					<li class="add-cart"><a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><i class="ion-android-cart"></i> Click here to BID</a></li>[m
[31m- 				<?php[m
[31m- 				/*[m
[31m- 					<li><a class="quick-view" data-toggle="modal" data-target="#exampleModalCenter" href="#"><i class="ion-android-open"></i></a></li>[m
[31m- 					<li><a class="links-details" href="single-product.php"><i class="ion-clipboard"></i></a></li>[m
[31m- 					*/[m
[31m- 					?>[m
[31m- 				</ul>[m
[31m- 			</div>[m
[31m- 		</div>[m
[31m- 	</div>[m
[31m- 	<!-- single-product-wrap end -->[m
[32m++        </div>[m
[32m+     </div>[m
  </div>[m
[31m- 			<?php[m
[31m- 			}[m
[31m- 			?>[m
[31m- 												[m
[31m- 												</div>[m
[31m-                                             </div>[m
[31m-                                         </div>[m
[31m- 									</div>[m
[31m-                                 </div>[m
[31m-                             </div>[m
[31m-                         [m
[31m- 					   </div>[m
[31m -[m
[31m -<!-- Closed Auctions -->[m
[31m -<div class="section-title">Recently Closed Auctions</div>[m
[31m -<div class="products">[m
[31m -    <div class="product">[m
[31m -        <img src="images/sample.jpg">[m
[31m -        <h3>Closed Product</h3>[m
[31m -        <a class="btn">View Result</a>[m
[32m++<?php } ?>[m
[32m++                        </div>[m
[32m +                    </div>[m
[32m +                </div>[m
[32m +            </div>[m
[31m-             <!-- Closed Auctions end -->	   [m
[32m++        </div>[m
[32m+     </div>[m
[32m+ </div>[m
[32m++<!-- Closed Auctions end -->[m
  [m
[31m- <?php[m
[31m- include("footer.php");[m
[31m- ?>[m
[31m -</body>[m
[31m -</html>[m
[32m++<?php include("footer.php"); ?>[m
[1mdiff --git a/allproducts.php b/allproducts.php[m
[1mindex e8a02a0..f35a5ea 100644[m
[1m--- a/allproducts.php[m
[1m+++ b/allproducts.php[m
[36m@@ -83,7 +83,7 @@[m [mfunction countdowntimer(id, time)[m
 								<figure>[m
 									<div class="snipcart-item block">[m
 										<div class="snipcart-thumb"	>[m
[31m-											<a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><img src="<?php echo $imgname; ?>" alt=" " class="img-responsive"style="height: 250px;" /></a>[m
[32m+[m											[32m<a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><img src="<?php echo $imgname; ?>" alt=" " class="img-responsive"style="height:250px;width:auto;max-width:100%;object-fit:contain;" /></a>[m
 											<p><b><a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><?php echo $rsproduct['product_name']; ?></a></b></p>[m
 <!-- Timer code starts here -->[m
 <p id="countdowntime<?php echo $rsproduct[0]; ?>"></p>[m
[1mdiff --git a/category.php b/category.php[m
[1mindex 50046d1..54f6458 100644[m
[1m--- a/category.php[m
[1m+++ b/category.php[m
[36m@@ -2,12 +2,9 @@[m
 include("header.php");[m
 if(isset($_POST['submit']))[m
 {[m
[31m-	$filename = rand(). $_FILES["category_icon"]["name"];[m
[31m-	move_uploaded_file($_FILES["category_icon"]["tmp_name"],"imgcategory/".$filename);[m
 	if(isset($_GET['editid']))[m
 	{[m
[31m-		//Update statement starts here[m
[31m-		$sql = "UPDATE category SET category_name='$_POST[category_name]',category_icon='$filename',description='$_POST[description]',status='$_POST[status]' WHERE  category_id='$_GET[editid]'";[m
[32m+[m		[32m$sql = "UPDATE category SET category_name='$_POST[category_name]',description='$_POST[description]',status='$_POST[status]' WHERE category_id='$_GET[editid]'";[m
 		$qsql = mysqli_query($con,$sql);[m
 		if(mysqli_affected_rows($con) == 1)[m
 		{[m
[36m@@ -17,11 +14,10 @@[m [mif(isset($_POST['submit']))[m
 		{[m
 			echo mysqli_error($con);[m
 		}[m
[31m-		//Update statement ends here		[m
 	}[m
 	else[m
 	{[m
[31m-		$sql = "INSERT INTO category(category_name,category_icon,description,status) VALUES('$_POST[category_name]','$filename','$_POST[description]','$_POST[status]')";[m
[32m+[m		[32m$sql = "INSERT INTO category(category_name,description,status) VALUES('$_POST[category_name]','$_POST[description]','$_POST[status]')";[m
 		$qsql = mysqli_query($con,$sql);[m
 		if(mysqli_affected_rows($con) == 1)[m
 		{[m
[36m@@ -67,7 +63,7 @@[m [mif(isset($_GET['editid']))[m
                             <div class="col-lg-12">[m
 <div class="row">[m
 	<div class="col-lg-12 offset-xl-2 col-xl-8 col-sm-12">[m
[31m-		<form action="" method="post" enctype="multipart/form-data" onsubmit="return validateform()">[m
[32m+[m		[32m<form action="" method="post" onsubmit="return validateform()">[m
 			<div class="checkbox-form checkout-review-order">[m
 				<h3 class="shoping-checkboxt-title">Category</h3>[m
 				<div class="row">[m
[36m@@ -79,29 +75,7 @@[m [mif(isset($_GET['editid']))[m
 	</p>[m
 </div>	[m
 [m
[31m-<div class="col-lg-12">[m
[31m-	<p class="single-form-row">[m
[31m-		<label>Category Icon</label><span class="required">*</span> <span class="errormsg" id="errcategory_icon"></span></label>[m
[31m-		<input type="file" name="category_icon" id="category_icon" class="form-control" accept="image/*" >[m
[31m-		<?php[m
[31m-		if(isset($_GET['editid']))[m
[31m-		{[m
[31m-			if($rsedit['category_icon'] == "")[m
[31m-			{[m
[31m-				echo "<img src='img/No-Image-Available.png' style='width: 200px;height:250px;'>";[m
[31m-			}[m
[31m-			else if(file_exists("imgcategory/".$rsedit['category_icon']))[m
[31m-			{[m
[31m-				echo "<img src='imgcategory/$rsedit[category_icon]' style='width: 200px;height:250px;'>";[m
[31m-			}[m
[31m-			else[m
[31m-			{[m
[31m-				echo "<img src='img/No-Image-Available.png' style='width: 200px;height:250px;'>";[m
[31m-			}[m
[31m-		}[m
[31m-		?>[m
[31m-	</p>[m
[31m-</div>[m
[32m+[m
 [m
 <div class="col-lg-12">[m
 	<p class="single-form-row">[m
[36m@@ -175,18 +149,6 @@[m [mfunction validateform()[m
 		i=1;		[m
 	}[m
 	[m
[31m-	var image =document.getElementById("category_icon").value;[m
[31m-    var checkimg = image.toLowerCase();[m
[31m-    if(!checkimg.match(/(\.jpg|\.png|\.JPG|\.PNG|\.gif|\.GIF|\.jpeg|\.JPEG)$/))[m
[31m-	{[m
[31m-		document.getElementById("errcategory_icon").innerHTML ="Please enter Image File Extensions .jpg,.png,.jpeg,.gif..";[m
[31m-		i=1;	[m
[31m-	}[m
[31m-	if(document.getElementById("category_icon").value == "")[m
[31m-	{[m
[31m-		document.getElementById("errcategory_icon").innerHTML ="Category icon should not be empty....";	[m
[31m-		i=1;		[m
[31m-	}[m
 	if(document.getElementById("status").value == "")[m
 	{[m
 		document.getElementById("errstatus").innerHTML ="Kindly select category status....";	[m
[1mdiff --git a/closebiddingproduct.php b/closebiddingproduct.php[m
[1mindex 3803ad9..fce93fb 100644[m
[1m--- a/closebiddingproduct.php[m
[1m+++ b/closebiddingproduct.php[m
[36m@@ -41,7 +41,7 @@[m [mif(isset($_GET['delid']))[m
 		{[m
 			$sql = $sql . " AND customer_id='" . $_SESSION['customer_id'] . "'";[m
 		}[m
[31m-		$sql = $sql . " AND product.status='Active' AND end_date_time<'$dt $tim'";[m
[32m+[m		[32m$sql = $sql . " AND product.status='Active' AND end_date_time < NOW()";[m
 		$sql = $sql . " ORDER BY product.product_id DESC";[m
 		$qsql = mysqli_query($con,$sql);[m
 		while($rs = mysqli_fetch_array($qsql))[m
[1mdiff --git a/closed.php b/closed.php[m
[1mindex caf152a..5d471d9 100644[m
[1m--- a/closed.php[m
[1m+++ b/closed.php[m
[36m@@ -43,17 +43,7 @@[m [mfunction countdowntimer(id, time)[m
 		$qsqlcategory = mysqli_query($con,$sqlcategory);[m
 		while($rscategory = mysqli_fetch_array($qsqlcategory))[m
 		{[m
[31m-			$sqlproduct = "select * from product WHERE status='Active' AND category_id='$rscategory[category_id]' AND end_date_time < '$dttim'  ";			[m
[31m-			if($_GET['auctiontype'] == "LatestAuctions")[m
[31m-			{[m
[31m-				[m
[31m-				$sqlproduct = $sqlproduct  . " order by product_id DESC limit 0,113";[m
[31m-			}[m
[31m-			else[m
[31m-			{[m
[31m-				[m
[31m-				$sqlproduct = $sqlproduct  . " order by product_id DESC limit 0,113";[m
[31m-			}[m
[32m+[m			[32m$sqlproduct = "select * from product WHERE status='Active' AND category_id='$rscategory[category_id]' AND end_date_time < NOW() order by product_id DESC limit 0,113";[m
 			$qsqlproduct = mysqli_query($con,$sqlproduct);[m
 			if(mysqli_num_rows($qsqlproduct) >= 1)[m
 			{[m
[36m@@ -65,9 +55,10 @@[m [mfunction countdowntimer(id, time)[m
 <?php[m
 			while($rsproduct = mysqli_fetch_array($qsqlproduct))[m
 			{[m
[31m-				if (file_exists("imgproduct/".$rsproduct['product_image'])) [m
[32m+[m				[32m$arr_pro_img = unserialize($rsproduct['product_image']);[m
[32m+[m				[32mif ($arr_pro_img && file_exists("imgproduct/".$arr_pro_img[0]))[m[41m [m
 				{[m
[31m-					 $imgname = "imgproduct/".$rsproduct['product_image'];[m
[32m+[m					[32m $imgname = "imgproduct/".$arr_pro_img[0];[m
 				} [m
 				else [m
 				{[m
[36m@@ -79,7 +70,7 @@[m [mfunction countdowntimer(id, time)[m
 	<figure class="card card-product">[m
 		<div class="img-wrap">[m
 			<center>[m
[31m-				<a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><img src="<?php echo $imgname; ?>" alt=" " class="img-responsive"style="height: 250px;" /></a>[m
[32m+[m				[32m<a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><img src="<?php echo $imgname; ?>" alt=" " class="img-responsive"style="height:250px;width:auto;max-width:100%;object-fit:contain;" /></a>[m
 			</center>[m
 		</div>[m
 		<figcaption class="info-wrap">[m
[1mdiff --git a/featured.php b/featured.php[m
[1mindex 189f7a1..136be77 100644[m
[1m--- a/featured.php[m
[1m+++ b/featured.php[m
[36m@@ -43,15 +43,7 @@[m [mfunction countdowntimer(id, time)[m
 		$qsqlcategory = mysqli_query($con,$sqlcategory);[m
 		while($rscategory = mysqli_fetch_array($qsqlcategory))[m
 		{[m
[31m-			$sqlproduct = "select * from product WHERE status='Active' AND category_id='$rscategory[category_id]'  AND product.customer_id!='0'   AND end_date_time>'$dt $tim' ";[m
[31m-			if($_GET['auctiontype'] == "featured Auctions")[m
[31m-			{[m
[31m-				$sqlproduct = $sqlproduct  . " order by product_id DESC limit 0,3";[m
[31m-			}[m
[31m-			else[m
[31m-			{[m
[31m-				$sqlproduct = $sqlproduct  . " order by product_id DESC limit 0,3";[m
[31m-			}[m
[32m+[m			[32m$sqlproduct = "select * from product WHERE status='Active' AND category_id='$rscategory[category_id]' AND end_date_time > NOW() order by product_id DESC limit 0,3";[m
 			$qsqlproduct = mysqli_query($con,$sqlproduct);[m
 			if(mysqli_num_rows($qsqlproduct) >= 1)[m
 			{[m
[36m@@ -63,9 +55,10 @@[m [mfunction countdowntimer(id, time)[m
 <?php[m
 			while($rsproduct = mysqli_fetch_array($qsqlproduct))[m
 			{[m
[31m-				if (file_exists("imgproduct/".$rsproduct['product_image'])) [m
[32m+[m				[32m$arr_pro_img = unserialize($rsproduct['product_image']);[m
[32m+[m				[32mif ($arr_pro_img && file_exists("imgproduct/".$arr_pro_img[0]))[m[41m [m
 				{[m
[31m-					 $imgname = "imgproduct/".$rsproduct['product_image'];[m
[32m+[m					[32m $imgname = "imgproduct/".$arr_pro_img[0];[m
 				} [m
 				else [m
 				{[m
[36m@@ -77,7 +70,7 @@[m [mfunction countdowntimer(id, time)[m
 	<figure class="card card-product">[m
 		<div class="img-wrap">[m
 			<center>[m
[31m-				<a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><img src="<?php echo $imgname; ?>" alt=" " class="img-responsive"style="height: 250px;" /></a>[m
[32m+[m				[32m<a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><img src="<?php echo $imgname; ?>" alt=" " class="img-responsive"style="height:250px;width:auto;max-width:100%;object-fit:contain;" /></a>[m
 			</center>[m
 		</div>[m
 		<figcaption class="info-wrap">[m
[1mdiff --git a/footer.php b/footer.php[m
[1mindex 95e3140..bf2ca40 100644[m
[1m--- a/footer.php[m
[1m+++ b/footer.php[m
[36m@@ -91,6 +91,30 @@[m [m$(document).ready( function () {[m
     $('#datatable').DataTable();[m
 } );[m
 </script>[m
[32m+[m
[32m+[m[32m<?php[m
[32m+[m[32m// Winner popup - fires after full page load[m
[32m+[m[32mif(isset($_SESSION['winner_popup_id']) && isset($_SESSION['winner_popup_name']))[m
[32m+[m[32m{[m
[32m+[m[32m    $popup_winner_id   = $_SESSION['winner_popup_id'];[m
[32m+[m[32m    $popup_product_name = $_SESSION['winner_popup_name'];[m
[32m+[m[32m    // Clear session so it only shows once[m
[32m+[m[32m    unset($_SESSION['winner_popup_id']);[m
[32m+[m[32m    unset($_SESSION['winner_popup_name']);[m
[32m+[m[32m?>[m
[32m+[m[32m<script>[m
[32m+[m[32mwindow.onload = function() {[m
[32m+[m[32m    if(confirm('🎉 Congratulations! You won the auction for:\n\n<?php echo $popup_product_name; ?>\n\nClick OK to proceed to eSewa payment.'))[m
[32m+[m[32m    {[m
[32m+[m[32m        window.location = 'esewa_payment.php?winner_id=<?php echo $popup_winner_id; ?>';[m
[32m+[m[32m    }[m
[32m+[m[32m    else[m
[32m+[m[32m    {[m
[32m+[m[32m        window.location = 'viewwinningbid.php';[m
[32m+[m[32m    }[m
[32m+[m[32m};[m
[32m+[m[32m</script>[m
[32m+[m[32m<?php } ?>[m
     </body>[m
 [m
 <!-- Mirrored from demo.hasthemes.com/juta-preview/juta-v1/index-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 25 Dec 2019 04:55:35 GMT -->[m
[1mdiff --git a/latestauction.php b/latestauction.php[m
[1mindex 63334ac..e38aa9a 100644[m
[1m--- a/latestauction.php[m
[1m+++ b/latestauction.php[m
[36m@@ -45,15 +45,7 @@[m [mfunction countdowntimer(id, time)[m
 		$qsqlcategory = mysqli_query($con,$sqlcategory);[m
 		while($rscategory = mysqli_fetch_array($qsqlcategory))[m
 		{[m
[31m-			$sqlproduct = "select * from product WHERE status='Active' AND category_id='$rscategory[category_id]'  AND start_date_time<='$dttim'  AND product.customer_id!='0' ";[m
[31m-			if($_GET['auctiontype'] == "Latest Auctions")[m
[31m-			{[m
[31m-				$sqlproduct = $sqlproduct  . " order by product_id DESC limit 0,3";[m
[31m-			}[m
[31m-			else[m
[31m-			{[m
[31m-				$sqlproduct = $sqlproduct  . " order by product_id DESC limit 0,3";[m
[31m-			}[m
[32m+[m			[32m$sqlproduct = "SELECT * FROM product WHERE status='Active' AND category_id='$rscategory[category_id]' AND end_date_time > NOW() GROUP BY product_id ORDER BY product_id DESC LIMIT 0,3";[m
 			$qsqlproduct = mysqli_query($con,$sqlproduct);[m
 			if(mysqli_num_rows($qsqlproduct) >= 1)[m
 			{[m
[36m@@ -65,9 +57,10 @@[m [mfunction countdowntimer(id, time)[m
 <?php[m
 			while($rsproduct = mysqli_fetch_array($qsqlproduct))[m
 			{[m
[31m-				if (file_exists("imgproduct/".$rsproduct['product_image'])) [m
[32m+[m				[32m$arr_pro_img = unserialize($rsproduct['product_image']);[m
[32m+[m				[32mif ($arr_pro_img && file_exists("imgproduct/".$arr_pro_img[0]))[m[41m [m
 				{[m
[31m-					 $imgname = "imgproduct/".$rsproduct['product_image'];[m
[32m+[m					[32m $imgname = "imgproduct/".$arr_pro_img[0];[m
 				} [m
 				else [m
 				{[m
[36m@@ -79,7 +72,7 @@[m [mfunction countdowntimer(id, time)[m
 	<figure class="card card-product">[m
 		<div class="img-wrap">[m
 			<center>[m
[31m-				<a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><img src="<?php echo $imgname; ?>" alt=" " class="img-responsive"style="height: 250px;" /></a>[m
[32m+[m				[32m<a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><img src="<?php echo $imgname; ?>" alt=" " class="img-responsive"style="height:250px;width:auto;max-width:100%;object-fit:contain;" /></a>[m
 			</center>[m
 		</div>[m
 		<figcaption class="info-wrap">[m
[1mdiff --git a/logout.php b/logout.php[m
[1mindex 6ccf527..d5d35d3 100644[m
[1m--- a/logout.php[m
[1m+++ b/logout.php[m
[36m@@ -1,5 +1,5 @@[m
 <?php[m
[31m-session_start();[m
[32m+[m[32mif(session_status() == PHP_SESSION_NONE) { session_start(); }[m
 session_destroy();[m
 echo "<script>window.location='index.php';</script>";[m
 ?>[m
\ No newline at end of file[m
[1mdiff --git a/paymentreceiptwinningbid.php b/paymentreceiptwinningbid.php[m
[1mindex dc5008c..8df6b5a 100644[m
[1m--- a/paymentreceiptwinningbid.php[m
[1m+++ b/paymentreceiptwinningbid.php[m
[36m@@ -42,15 +42,31 @@[m [m$rsproduct= mysqli_fetch_array($qsqlproduct);[m
 		    <td><b>Customer</b> <?php echo $rspayment['customer_name']; ?></td>[m
 			<td><b>Payment type</b> <?php echo $rspayment['card_type']; ?></td>[m
 		</tr>[m
[31m-			<tr>[m
[31m-			<th><b>Paid amount</b></th>[m
[31m-			<td>Rs. <?php echo $rspayment['purchase_amount']; ?>[m
[31m-			</td>[m
[32m+[m		[32m<?php[m
[32m+[m		[32m$winning_bid = $rspayment['purchase_amount'];[m
[32m+[m		[32m$commission  = $rspayment['cvv_number']; // we stored commission in cvv_number field[m
[32m+[m		[32mif(!is_numeric($commission) || $commission <= 0) {[m
[32m+[m			[32m$commission = round($winning_bid * 0.05, 2);[m
[32m+[m		[32m}[m
[32m+[m		[32m$total = $winning_bid;[m
[32m+[m		[32m$bid_only = round($winning_bid - $commission, 2);[m
[32m+[m		[32m?>[m
[32m+[m		[32m<tr>[m
[32m+[m			[32m<th><b>Winning Bid</b></th>[m
[32m+[m			[32m<td>Rs. <?php echo number_format($bid_only, 2); ?></td>[m
[32m+[m		[32m</tr>[m
[32m+[m		[32m<tr>[m
[32m+[m			[32m<th><b>Service Charge (5%)</b></th>[m
[32m+[m			[32m<td style="color:red;">Rs. <?php echo number_format($commission, 2); ?></td>[m
[32m+[m		[32m</tr>[m
[32m+[m		[32m<tr>[m
[32m+[m			[32m<th><b>Total Paid</b></th>[m
[32m+[m			[32m<td style="color:green;"><b>Rs. <?php echo number_format($total, 2); ?></b></td>[m
[32m+[m		[32m</tr>[m
[32m+[m		[32m<tr>[m
[32m+[m			[32m<th><b>Product code:</b> <?php echo $rsproduct['product_id']; ?></th>[m
[32m+[m			[32m<td><b>Product name:</b>  <?php echo $rsproduct['product_name']; ?></td>[m
 		</tr>[m
[31m-			<tr>[m
[31m-			<th><b>Product code :</b> <?php echo $rsproduct['product_id']; ?></th>[m
[31m-			<td><b>Product name :</b>  <?php echo $rsproduct['product_name']; ?></td>[m
[31m-			</tr>[m
 </table>[m
 </div><br><hr>[m
 <center><input type="button" name='print' class="btn btn-primary"  onclick="printDiv('printableArea')" value="Click here to Print"></center>[m
[1mdiff --git a/phpmailer.php b/phpmailer.php[m
[1mindex e497644..ae56048 100644[m
[1m--- a/phpmailer.php[m
[1m+++ b/phpmailer.php[m
[36m@@ -1,86 +1,36 @@[m
 <?php[m
[32m+[m[32mrequire_once 'PHPMailer/src/Exception.php';[m
[32m+[m[32mrequire_once 'PHPMailer/src/PHPMailer.php';[m
[32m+[m[32mrequire_once 'PHPMailer/src/SMTP.php';[m
[32m+[m
 use PHPMailer\PHPMailer\PHPMailer;[m
[31m-use PHPMailer\PHPMailer\SMTP;[m
 use PHPMailer\PHPMailer\Exception;[m
[31m-function sendmail($tomail, $totmailname , $subject, $message)[m
[31m-{[m
[31m-	$loginid 	= "onlineauctionprojectmail@myprojectcoding.xyz";[m
[31m-	$password 	= "h?eeL$9e0lp6";[m
[31m-	$smtpserver = "mail.myprojectcoding.xyz";[m
[31m-	$smtpport 	= 26;[m
[31m-	$mailsender = "OnlineAuction";[m
[31m-	$companyname= "OnlineAuction";[m
[31m-	$facebook = "https://www.facebook.com/OnlineAuction";[m
[31m-	$twitter = "https://www.twitter.com/OnlineAuction";[m
[31m-	$youtube = "https://www.youtube.com/OnlineAuction";[m
[31m-	$linkedin = "https://www.linkedin.com/OnlineAuction";[m
[31m-	$companyaddress  = "secondchance.com, Kathmandu, Nepal";[m
[31m-	$contactno = "9877777777";[m
[31m-	$url = "www.secondchancce.com";[m
[31m-	// Import PHPMailer classes into the global namespace[m
[31m-	// These must be at the top of your script, not inside a function[m
[31m-	// Load Composer's autoloader[m
[31m-	require_once 'PHPMailer/src/Exception.php';[m
[31m-	require_once 'PHPMailer/src/PHPMailer.php';[m
[31m-	require_once 'PHPMailer/src/SMTP.php';[m
[31m-[m
[31m-	// Instantiation and passing `true` enables exceptions[m
[31m-	$mail = new PHPMailer(true);[m
 [m
[31m-	try[m
[31m-	{[m
[31m-		//Server settings[m
[31m-		$mail->SMTPDebug = false; // SMTP::DEBUG_SERVER; // Enable verbose debug output[m
[31m-		$mail->isSMTP();          // Send using SMTP[m
[31m-		$mail->Host       = $smtpserver; // Set the SMTP server to send through[m
[31m-		$mail->SMTPAuth   = true;  // Enable SMTP authentication[m
[31m-		$mail->Username   = $loginid; // SMTP username[m
[31m-		$mail->Password   = $password;  // SMTP password[m
[31m-		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted[m
[31m-		$mail->Port       = $smtpport;[m
[31m-		// TCP port to connect to[m
[31m-[m
[31m-		//Recipients[m
[31m-		$mail->setFrom($loginid, $mailsender);[m
[31m-		$mail->addAddress($tomail, $totmailname);     // Add a recipient[m
[31m-		$mail->addAddress($tomail);               // Name is optional[m
[31m-		$mail->addReplyTo($tomail, $totmailname);[m
[31m-		//$mail->addCC('cc@example.com');[m
[31m-		//$mail->addBCC('bcc@example.com');[m
[32m+[m[32mfunction sendmail($tomail, $totmailname, $subject, $message)[m
[32m+[m[32m{[m
[32m+[m[32m    $mail = new PHPMailer(true);[m
[32m+[m[32m    try {[m
[32m+[m[32m        $mail->isSMTP();[m
[32m+[m[32m        $mail->SMTPDebug  = 0;[m
[32m+[m[32m        $mail->Host       = 'smtp.gmail.com';[m
[32m+[m[32m        $mail->SMTPAuth   = true;[m
[32m+[m[32m        $mail->Username   = 'sadikshyanepal454@gmail.com';[m
[32m+[m[32m        $mail->Password   = 'zqeripybjijsaxxs';[m
[32m+[m[32m        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;[m
[32m+[m[32m        $mail->Port       = 587;[m
 [m
[31m-		// Attachments[m
[31m-		// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments[m
[31m-		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name[m
[32m+[m[32m        $mail->setFrom('sadikshyanepal454@gmail.com', 'Second Chance Auction');[m
[32m+[m[32m        $mail->addAddress($tomail, $totmailname);[m
 [m
[31m-		// Content[m
[31m-		$mail->isHTML(true);        // Set email format to HTML[m
[31m-		$mail->Subject = $subject;[m
[31m-	$mailmessage = "<body link='#00a5b5' vlink='#00a5b5' alink='#00a5b5'><table class=' main contenttable' align='center' style='font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;'>		<tr>			<td class='border' style='border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;'>				<table style='font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;'>					<tr>						<td colspan='4' valign='top' class='image-section' style='border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5'>[m
[31m-	<center><a href='$url' style='text-decoration: none;'><H2>" . $companyname ."</H2></a></center>[m
[31m-	</td>					</tr>					<tr><td valign='top' class='side title' style='border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;'><table style='font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;'><tr><td class='head-title' style='border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 28px;line-height: 34px;font-weight: bold; text-align: center;'><div class='mktEditable' id='main_title'>$subject</div></td></tr><tr><td class='top-padding' style='border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;'></td></tr>";[m
[31m-	$mailmessage = $mailmessage . "<tr><td class='top-padding' style='border-collapse: collapse;border: 0;margin: 0;padding: 15px 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 21px;'><hr size='1' color='#eeeff0'></td></tr><tr><td class='text' style='border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;'><div class='mktEditable' id='main_text'>". $message ."</div></td></tr></table>				</td>					</tr>					<tr>						<td style='padding:20px; font-family: Arial, sans-serif; -webkit-text-size-adjust: none;' align='center'>							<table>								<tr>									<td align='center' style='font-family: Arial, sans-serif; -webkit-text-size-adjust: none; font-size: 16px;'>										<a style='color: #00a5b5;' href='{{system.forwardToFriendLink}}'>Note:</a>										<br/><span style='font-size:10px; font-family: Arial, sans-serif; -webkit-text-size-adjust: none;' >This email has been sent to you, because you are a customer of ". $companyname ." </span>									</td>								</tr>							</table>						</td>					</tr>					<tr>						<td style='border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 24px; padding: 20px;'>		</td>					</tr>	<tr>						<td valign='top' align='center' style='border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;'>";[m
[31m-	if($facebook != "" && $twitter != "" && $youtube != "" && $linkedin != "" )[m
[31m-	{[m
[31m-	$mailmessage = $mailmessage . "<table style='font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;'>								<tr>									<td align='center' valign='middle' class='social' style='border-collapse: collapse;border: 0;margin: 0;padding: 10px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;text-align: center;'>										<table style='font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;'>											<tr>															[m
[31m-	<td style='border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;'><a href='$facebook'><img src='https://info.tenable.com/rs/tenable/images/facebook-teal.png'></a></td>						[m
[31m-	<td style='border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;'><a href='$twitter'><img src='https://info.tenable.com/rs/tenable/images/twitter-teal.png'></a></td>	[m
[31m-	<td style='border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;'><a href='$youtube'><img src='https://info.tenable.com/rs/tenable/images/youtube-teal.png'></a></td>									<td style='border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;'><a href='$linkedin'><img src='https://info.tenable.com/rs/tenable/images/linkedin-teal.png'></a></td>[m
[31m-	</tr>										</table>									</td>								</tr>							</table>";[m
[31m-	}[m
[31m-	$mailmessage = $mailmessage . "</td>					</tr>					<tr bgcolor='#fff' style='border-top: 4px solid #00a5b5;'>						<td valign='top' class='footer' style='border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background: #fff;text-align: center;'>							<table style='font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;'>								<tr>									<td class='inside-footer' align='center' valign='middle' style='border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 12px;line-height: 16px;vertical-align: middle;text-align: center;width: 580px;'><div id='address' class='mktEditable'><b>$companyname</b><br>$companyaddress<br>  [m
[31m-	$contactno<br><br>                      [m
[31m-	</div>									</td>								</tr>							</table>						</td>					</tr>				</table>			</td>		</tr>	</table>  </body>";		[m
[31m-		$mail->Body    = $mailmessage; //$message;[m
[31m-		$mail->AltBody = 'Mail Receieved';[m
[32m+[m[32m        $mail->isHTML(true);[m
[32m+[m[32m        $mail->Subject = $subject;[m
[32m+[m[32m        $mail->Body    = $message;[m
[32m+[m[32m        $mail->AltBody = strip_tags($message);[m
 [m
[31m-		$mail->send();[m
[31m-			//echo 'Mail has been sent';[m
[31m-	}[m
[31m-	catch (Exception $e) [m
[31m-	{[m
[31m-		echo "Message could not be sent. Mailer Error: {[m
[31m-			$mail->ErrorInfo}";[m
[31m-	}[m
[32m+[m[32m        $mail->send();[m
[32m+[m[32m    } catch (Exception $e) {[m
[32m+[m[32m        // Silently log — don't break the page[m
[32m+[m[32m        error_log("Mail error to $tomail: " . $mail->ErrorInfo);[m
[32m+[m[32m    }[m
 }[m
[31m-//sendmail("studentprojects.live@gmail.com", "Student Projects" , "My subject title", "My message");[m
[31m-?>[m
\ No newline at end of file[m
[32m+[m[32m?>[m
[1mdiff --git a/product.php b/product.php[m
[1mindex 5d20b70..06444f5 100644[m
[1m--- a/product.php[m
[1m+++ b/product.php[m
[36m@@ -30,12 +30,13 @@[m [mif(isset($_POST['submit']))[m
 	} [m
 	else[m
 	{ [m
[31m-		$sql = "INSERT INTO  product (customer_id,category_id,product_name,product_description,starting_bid,ending_bid,start_date_time,end_date_time,product_cost,product_image,product_warranty,product_delivery,company_name,status) VALUES('$_SESSION[customer_id]','$_POST[category_id]','$_POST[product_name]','$productdescription','$_POST[starting_bid]','$_POST[starting_bid]','$_POST[start_date] $_POST[start_time]','$_POST[end_date] $_POST[end_time]','$_POST[product_cost]','$arrimg','$_POST[product_warranty]','$_POST[product_delivery]','$_POST[company_name]','Active')";[m
[32m+[m		[32m$owner_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : $_SESSION['employee_id'];[m
[32m+[m		[32m$sql = "INSERT INTO  product (customer_id,category_id,product_name,product_description,starting_bid,ending_bid,start_date_time,end_date_time,product_cost,product_image,product_warranty,product_delivery,company_name,status) VALUES('$owner_id','$_POST[category_id]','$_POST[product_name]','$productdescription','$_POST[starting_bid]','$_POST[starting_bid]','$_POST[start_date] $_POST[start_time]','$_POST[end_date] $_POST[end_time]','$_POST[product_cost]','$arrimg','$_POST[product_warranty]','$_POST[product_delivery]','$_POST[company_name]','Active')";[m
 		$qsql = mysqli_query($con,$sql);[m
 		if(mysqli_affected_rows($con) == 1)[m
 		{[m
 			echo "<script>alert('Product record inserted successfully..');</script>";[m
[31m-			[m
[32m+[m			[32mecho "<script>window.location='viewproduct.php';</script>";[m
 		}[m
 		else[m
 		{[m
[36m@@ -227,22 +228,19 @@[m [melse[m
 	<div class="row">[m
 		<div class="col-md-6 col-lg-6">		[m
 			<label class="control-label">End date</label>[m
[31m-			<div id="idchangetodate"><?php include("ajaxenddate.php"); ?></div>[m
[32m+[m			[32m<?php if(isset($_GET['editid'])): ?>[m
[32m+[m				[32m<input class="form-control" name="end_date" type="date" value="<?php echo date('Y-m-d', strtotime($rsedit['end_date_time'])); ?>" readonly style="background-color:#fcf8e3;">[m
[32m+[m			[32m<?php else: ?>[m
[32m+[m				[32m<input class="form-control" name="end_date" id="end_date" type="date" value="<?php echo date('Y-m-d'); ?>">[m
[32m+[m			[32m<?php endif; ?>[m
 		</div>[m
 		<div class="col-md-6 col-lg-6">		[m
 			<label class="control-label">End time</label>[m
[31m-			<div id="idend_time">[m
[31m-				<input class="form-control"  style="background-color:#fcf8e3;" name="end_time"  type="time" placeholder="End time"  value="<?php [m
[31m-				if(isset($_GET['editid']))[m
[31m-				{[m
[31m-				echo date("H:i:s",strtotime($rsedit['end_date_time']));[m
[31m-				}[m
[31m-				else[m
[31m-				{[m
[31m-					echo date("H:i");[m
[31m-				}[m
[31m-				?>"  >[m
[31m-			</div>[m
[32m+[m			[32m<?php if(isset($_GET['editid'])): ?>[m
[32m+[m				[32m<input class="form-control" name="end_time" type="time" value="<?php echo date('H:i:s', strtotime($rsedit['end_date_time'])); ?>" readonly style="background-color:#fcf8e3;">[m
[32m+[m			[32m<?php else: ?>[m
[32m+[m				[32m<input class="form-control" name="end_time" id="end_time" type="time" value="<?php echo date('H:i'); ?>">[m
[32m+[m			[32m<?php endif; ?>[m
 		</div>[m
 	</div>[m
 	[m
[36m@@ -306,7 +304,7 @@[m [mif(isset($_SESSION['employeeid']))[m
 [m
 ?>[m
 	<div class="contact-submit-btn"><hr>[m
[31m-		<center><button  type="submit" name="submit"  class="btn btn-info"  onclick="return validateform()">Click Here to Submit</button></center>[m
[32m+[m		[32m<center><button type="submit" name="submit" id="submitbtn" class="btn btn-info" onclick="if(validateform()){this.disabled=true; this.innerText='Submitting...'; return true;} return false;">Click Here to Submit</button></center>[m
 	</div>[m
 </form>[m
                             </div>[m
[36m@@ -344,14 +342,14 @@[m [mfunction validateform()[m
 		document.getElementById("idproduct_name").innerHTML ="Product name should contain only alphabets and spaces....";	[m
 		i=1;		[m
 	}[m
[31m-	if(document.getElementById("product_name").value.length < 5)[m
[32m+[m	[32mif(document.getElementById("product_name").value.length < 3)[m
 	{[m
[31m-		document.getElementById("idproduct_name").innerHTML ="Product name should contain more than 10 characters....";	[m
[32m+[m		[32mdocument.getElementById("idproduct_name").innerHTML ="Product name should contain at least 3 characters....";[m[41m	[m
 		i=1;		[m
 	}[m
 	if(document.getElementById("product_name").value.length > 100)[m
 	{[m
[31m-		document.getElementById("idproduct_name").innerHTML ="Product name should contain less than 20 characters....";	[m
[32m+[m		[32mdocument.getElementById("idproduct_name").innerHTML ="Product name should contain less than 100 characters....";[m[41m	[m
 		i=1;		[m
 	}[m
 	if(document.getElementById("product_name").value == "")[m
[36m@@ -386,9 +384,9 @@[m [mfunction validateform()[m
 		document.getElementById("idstarting_bid").innerHTML ="Starting bid should not be empty....";	[m
 		i=1;		[m
 	}[m
[31m-	if(document.getElementById("product_cost").value < 100)[m
[32m+[m	[32mif(document.getElementById("product_cost").value < 1)[m
 	{[m
[31m-		document.getElementById("idproduct_cost").innerHTML ="Product cost should be more than RS.100....";	[m
[32m+[m		[32mdocument.getElementById("idproduct_cost").innerHTML ="Product cost should be more than RS.1....";[m[41m	[m
 		i=1;		[m
 	}[m
 	[m
[36m@@ -445,10 +443,8 @@[m [mfunction changedate(dt)[m
 {[m
 	var start_date = dt;[m
 	if (window.XMLHttpRequest) {[m
[31m-		// code for IE7+, Firefox, Chrome, Opera, Safari[m
 		xmlhttp = new XMLHttpRequest();[m
 	} else {[m
[31m-		// code for IE6, IE5[m
 		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");[m
 	}[m
 	xmlhttp.onreadystatechange = function() {[m
[36m@@ -459,4 +455,31 @@[m [mfunction changedate(dt)[m
 	xmlhttp.open("GET","ajaxenddate.php?start_date="+start_date,true);[m
 	xmlhttp.send();[m
 }[m
[32m+[m
[32m+[m[32mfunction setEndDateTime(duration) {[m
[32m+[m	[32mvar now = new Date();[m
[32m+[m	[32mvar end = new Date();[m
[32m+[m
[32m+[m	[32mif(duration == '1min')       end = new Date(now.getTime() + 1 * 60 * 1000);[m
[32m+[m	[32melse if(duration == '1hour') end = new Date(now.getTime() + 60 * 60 * 1000);[m
[32m+[m	[32melse if(duration == '1day')  end = new Date(now.getTime() + 24 * 60 * 60 * 1000);[m
[32m+[m	[32melse if(duration == '1week') end = new Date(now.getTime() + 7 * 24 * 60 * 60 * 1000);[m
[32m+[m	[32melse return;[m
[32m+[m
[32m+[m	[32m// Format date as YYYY-MM-DD[m
[32m+[m	[32mvar endDate = end.getFullYear() + '-' +[m
[32m+[m		[32mString(end.getMonth()+1).padStart(2,'0') + '-' +[m
[32m+[m		[32mString(end.getDate()).padStart(2,'0');[m
[32m+[m
[32m+[m	[32m// Format time as HH:MM[m
[32m+[m	[32mvar endTime = String(end.getHours()).padStart(2,'0') + ':' +[m
[32m+[m		[32mString(end.getMinutes()).padStart(2,'0');[m
[32m+[m
[32m+[m	[32mdocument.getElementById('end_date').value = endDate;[m
[32m+[m	[32mdocument.getElementById('end_time').value = endTime;[m
[32m+[m
[32m+[m	[32m// Show to user[m
[32m+[m	[32mdocument.getElementById('end_display').innerHTML =[m
[32m+[m		[32m'Auction ends at: ' + end.toLocaleString();[m
[32m+[m[32m}[m
 </script>[m
[1mdiff --git a/products.php b/products.php[m
[1mindex 90a1db3..2ecd337 100644[m
[1m--- a/products.php[m
[1m+++ b/products.php[m
[36m@@ -66,9 +66,10 @@[m [mfunction countdowntimer(id, time)[m
 			$qsqlproduct = mysqli_query($con,$sqlproduct);[m
 			while($rsproduct = mysqli_fetch_array($qsqlproduct))[m
 			{[m
[31m-				if (file_exists("imgproduct/".$rsproduct['product_image'])) [m
[32m+[m				[32m$arr_pro_img = unserialize($rsproduct['product_image']);[m
[32m+[m				[32mif ($arr_pro_img && file_exists("imgproduct/".$arr_pro_img[0]))[m[41m [m
 				{[m
[31m-					 $imgname = "imgproduct/".$rsproduct['product_image'];[m
[32m+[m					[32m $imgname = "imgproduct/".$arr_pro_img[0];[m
 				} [m
 				else [m
 				{[m
[1mdiff --git a/searchproduct.php b/searchproduct.php[m
[1mindex 748faf9..8e3b064 100644[m
[1m--- a/searchproduct.php[m
[1m+++ b/searchproduct.php[m
[36m@@ -69,9 +69,10 @@[m [mfunction countdowntimer(id, time)[m
 <?php[m
 			while($rsproduct = mysqli_fetch_array($qsqlproduct))[m
 			{[m
[31m-				if (file_exists("imgproduct/".$rsproduct['product_image'])) [m
[32m+[m				[32m$arr_pro_img = unserialize($rsproduct['product_image']);[m
[32m+[m				[32mif ($arr_pro_img && file_exists("imgproduct/".$arr_pro_img[0]))[m[41m [m
 				{[m
[31m-					 $imgname = "imgproduct/".$rsproduct['product_image'];[m
[32m+[m					[32m $imgname = "imgproduct/".$arr_pro_img[0];[m
 				} [m
 				else [m
 				{[m
[36m@@ -83,7 +84,7 @@[m [mfunction countdowntimer(id, time)[m
 	<figure class="card card-product">[m
 		<div class="img-wrap">[m
 			<center>[m
[31m-				<a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><img src="<?php echo $imgname; ?>" alt=" " class="img-responsive"style="height: 250px;" /></a>[m
[32m+[m				[32m<a href="single.php?productid=<?php echo $rsproduct[0]; ?>"><img src="<?php echo $imgname; ?>" alt=" " class="img-responsive"style="height:250px;width:auto;max-width:100%;object-fit:contain;" /></a>[m
 			</center>[m
 		</div>[m
 		<figcaption class="info-wrap">[m
[1mdiff --git a/selectcategory.php b/selectcategory.php[m
[1mindex f2c8240..06ea220 100644[m
[1m--- a/selectcategory.php[m
[1m+++ b/selectcategory.php[m
[36m@@ -20,22 +20,11 @@[m [mif(!isset($_SESSION['customer_id']))[m
 		$qsql = mysqli_query($con,$sql);[m
 		while($rs = mysqli_fetch_array($qsql))[m
 		{[m
[31m-			if (file_exists("imgcategory/".$rs['category_icon'])) [m
[31m-			{[m
[31m-				 $imgname = "imgcategory/".$rs['category_icon'];[m
[31m-			} [m
[31m-			else [m
[31m-			{[m
[31m-				$imgname = "img/No-Image-Available.png";[m
[31m-			}[m
 		?>[m
[31m-				<div class="col-md-4 w3l_banner_nav_right_banner3_btml"  >[m
[31m-					<div class="view view-tenth" onclick='window.location=`product.php?categoryid=<?php echo $rs['category_id']; ?>`' style="Cursor:pointer;">[m
[31m-						<img src="<?php echo $imgname; ?>" style="height:280px;width: 100%;" class="img-responsive" />[m
[31m-						<div class="mask">[m
[31m-							<h4><?php echo $rs['category_name']; ?></h4>[m
[31m-							<p><?php echo $rs['description']; ?></p>[m
[31m-						</div>[m
[32m+[m				[32m<div class="col-md-4 w3l_banner_nav_right_banner3_btml">[m
[32m+[m					[32m<div class="view view-tenth" onclick='window.location=`product.php?categoryid=<?php echo $rs['category_id']; ?>`' style="cursor:pointer; padding:20px; border:1px solid #ddd; border-radius:8px; text-align:center; margin-bottom:15px;">[m
[32m+[m						[32m<h4><?php echo $rs['category_name']; ?></h4>[m
[32m+[m						[32m<p><?php echo $rs['description']; ?></p>[m
 					</div>[m
 				<hr>[m
 				</div>[m
[1mdiff --git a/single.php b/single.php[m
[1mindex 96b1e91..fc17afd 100644[m
[1m--- a/single.php[m
[1m+++ b/single.php[m
[36m@@ -5,7 +5,8 @@[m [mif(isset($_POST['submit']))[m
 		if($accbalamt >= 0)[m
 		{[m
 		$dttime = date("Y-m-d H:i:s");[m
[31m-		$sql = "INSERT INTO  bidding (customer_id,product_id,bidding_amount,bidding_date_time,note,status) VALUES('$_SESSION[customer_id]','$_GET[productid]','$_POST[purchase_amount]','$dttime','$_POST[note]','Active')";[m
[32m+[m		[32m$note = isset($_POST['note']) ? mysqli_real_escape_string($con, $_POST['note']) : '';[m
[32m+[m		[32m$sql = "INSERT INTO bidding (customer_id,product_id,bidding_amount,bidding_date_time,note,status) VALUES('$_SESSION[customer_id]','$_GET[productid]','$_POST[purchase_amount]','$dttime','$note','Active')";[m
 		$qsql = mysqli_query($con,$sql);[m
 		if(mysqli_affected_rows($con) == 1)[m
 		{[m
[36m@@ -552,29 +553,26 @@[m [mfunction confirmbidding()[m
 {[m
 	if(document.getElementById("purchase_amount").value == "")[m
 	{[m
[31m-		alert('Bidding amount not entered..');[m
[32m+[m		[32malert('Please enter a bid amount.');[m
 		return false;[m
 	}[m
[31m-	if(parseFloat(document.getElementById("ending_bid").value)  > parseFloat(document.getElementById("purchase_amount").value))[m
[32m+[m	[32mif(isNaN(document.getElementById("purchase_amount").value))[m
 	{[m
[31m-		alert('Bidding amount must be greater than Rs' + document.getElementById("ending_bid").value);[m
[32m+[m		[32malert('Bid amount must be a number.');[m
 		return false;[m
 	}[m
[31m-	else if(parseFloat(document.getElementById("purchase_amount").value)  > parseFloat(document.getElementById("max_bid_amt").value))[m
[32m+[m	[32mif(parseFloat(document.getElementById("ending_bid").value) >= parseFloat(document.getElementById("purchase_amount").value))[m
 	{[m
[31m-		alert('Bidding amount should be lesser than Rs' + document.getElementById("max_bid_amt").value);[m
[32m+[m		[32malert('Your bid must be greater than the current bid of Rs.' + document.getElementById("ending_bid").value);[m
 		return false;[m
 	}[m
[32m+[m	[32mif(confirm("Confirm your bid of Rs." + document.getElementById("purchase_amount").value + "?") == true)[m
[32m+[m	[32m{[m
[32m+[m		[32mreturn true;[m
[32m+[m	[32m}[m
 	else[m
 	{[m
[31m-		if(confirm("confrim to bid!!") == true)[m
[31m-		{[m
[31m-			return true;[m
[31m-		}[m
[31m-		else[m
[31m-		{[m
[31m-			return false;[m
[31m-		}[m
[32m+[m		[32mreturn false;[m
 	}[m
 }[m
 </script>[m
\ No newline at end of file[m
[1mdiff --git a/viewcategory.php b/viewcategory.php[m
[1mindex 58f71fe..7a81a54 100644[m
[1m--- a/viewcategory.php[m
[1m+++ b/viewcategory.php[m
[36m@@ -46,7 +46,6 @@[m [mif(isset($_GET['delid']))[m
 <table id="datatable" class="table table-striped table-bordered">[m
 	<thead>[m
 		<tr>[m
[31m-			<th>Icon</th>[m
 			<th>Category Name</th>[m
 			<th>Description</th>[m
 			<th>Status</th>[m
[36m@@ -60,32 +59,13 @@[m [mif(isset($_GET['delid']))[m
 	while($rs = mysqli_fetch_array($qsql))[m
 	{[m
 		echo "<tr>[m
[31m-			<td>";[m
[31m-			if($rs['category_icon'] == "")[m
[31m-			{[m
[31m-				echo "<img src='img/No-Image-Available.png' style='width: 200px;height:175px;'>";[m
[31m-			}[m
[31m-			else if(file_exists("imgcategory/".$rs['category_icon']))[m
[31m-			{[m
[31m-				echo "<img src='imgcategory/$rs[category_icon]' style='width: 200px;height:175px;'>";[m
[31m-			}[m
[31m-			else[m
[31m-			{[m
[31m-				echo "<img src='img/No-Image-Available.png' style='width: 200px;height:175px;'>";[m
[31m-			}[m
[31m-[m
[31m-			echo "</td>			[m
 			<td>$rs[category_name]</td>[m
 			<td>$rs[description]</td>[m
 			<td>$rs[status]</td>[m
 			<td>[m
[31m-[m
[31m-				<a href='category.php?editid=$rs[0]' class='btn btn-info' >Edit</a>[m
[31m-			[m
[31m-			<a href='viewcategory.php?delid=$rs[0]' class='btn btn-danger' onclick='return confirmdelete()'>Delete</a>[m
[31m-			[m
[32m+[m				[32m<a href='category.php?editid=$rs[0]' class='btn btn-info'>Edit</a>[m
[32m+[m				[32m<a href='viewcategory.php?delid=$rs[0]' class='btn btn-danger' onclick='return confirmdelete()'>Delete</a>[m
 			</td>[m
[31m-			[m
 			</tr>";[m
 	}[m
 	?>[m
[1mdiff --git a/viewmybid.php b/viewmybid.php[m
[1mindex ab30dc0..051f863 100644[m
[1m--- a/viewmybid.php[m
[1m+++ b/viewmybid.php[m
[36m@@ -63,9 +63,10 @@[m [mfunction countdowntimer(id, time)[m
 <?php[m
 			while($rsproduct = mysqli_fetch_array($qsqlproduct))[m
 			{[m
[31m-				if (file_exists("imgproduct/".$rsproduct['product_image'])) [m
[32m+[m				[32m$arr_pro_img = unserialize($rsproduct['product_image']);[m
[32m+[m				[32mif ($arr_pro_img && file_exists("imgproduct/".$arr_pro_img[0]))[m[41m [m
 				{[m
[31m-					 $imgname = "imgproduct/".$rsproduct['product_image'];[m
[32m+[m					[32m $imgname = "imgproduct/".$arr_pro_img[0];[m
 				} [m
 				else [m
 				{[m
[1mdiff --git a/viewproduct.php b/viewproduct.php[m
[1mindex addb565..2ba5a6a 100644[m
[1m--- a/viewproduct.php[m
[1m+++ b/viewproduct.php[m
[36m@@ -70,12 +70,12 @@[m [mif(isset($_GET['delid']))[m
 			}[m
 			echo "<tr><td>";[m
 ?>[m
[31m-<div class="w3-content w3-section" style="max-width:500px">[m
[32m+[m[32m<div style="width:100px; height:80px; overflow:hidden; display:flex; align-items:center; justify-content:center; background:#f9f9f9;">[m
 <?php[m
 for($iimg = 0; $iimg <count($arr_pro_img); $iimg++)[m
 {[m
 ?>[m
[31m-  <img class="mySlides<?php echo $rs[0]; ?> " src="imgproduct/<?php echo $arr_pro_img[$iimg]; ?>" style="width:100%">[m
[32m+[m[32m  <img class="mySlides<?php echo $rs[0]; ?>" src="imgproduct/<?php echo $arr_pro_img[$iimg]; ?>" style="max-width:100px; max-height:80px; width:auto; height:auto; object-fit:contain;">[m
 <?php[m
 }[m
 ?>[m
[1mdiff --git a/viewwinners.php b/viewwinners.php[m
[1mindex a18ab55..2589a59 100644[m
[1m--- a/viewwinners.php[m
[1m+++ b/viewwinners.php[m
[36m@@ -29,24 +29,32 @@[m [mif(isset($_GET['delid']))[m
 	<thead>[m
 		<tr>[m
 		    <th>Customer</th>[m
[31m-			<th >Product</th>[m
[31m-			<th>Winners image</th>[m
[31m-			<th>Winning bid</th>[m
[31m-			<th>End date</th>[m
[32m+[m			[32m<th>Product</th>[m
[32m+[m			[32m<th>Winning Bid</th>[m
[32m+[m			[32m<th>End Date</th>[m
[32m+[m			[32m<th>Payment Status</th>[m
 		</tr>[m
 		</thead>[m
 		<tbody>[m
 		<?php[m
[31m-		$sql = "select * from winners LEFT JOIN customer ON winners.customer_id =customer.customer_id LEFT JOIN product ON winners.product_id=product.product_id";[m
[32m+[m		[32m$sql = "SELECT winners.*, customer.customer_name, customer.email_id, customer.mobile_no,[m
[32m+[m		[32m        product.product_name, product.product_id as prod_id[m
[32m+[m		[32m        FROM winners[m[41m [m
[32m+[m		[32m        LEFT JOIN customer ON winners.customer_id = customer.customer_id[m[41m [m
[32m+[m		[32m        LEFT JOIN product ON winners.product_id = product.product_id[m
[32m+[m		[32m        ORDER BY winners.winner_id DESC";[m
 		$qsql = mysqli_query($con,$sql);[m
 		while($rs = mysqli_fetch_array($qsql))[m
 		{[m
[32m+[m			[32m$status_color = ($rs['status'] == 'Active') ? 'green' : 'orange';[m
[32m+[m			[32m$status_label = ($rs['status'] == 'Active') ? 'Paid' : 'Pending Payment';[m
 			echo "<tr>[m
[31m-			    <td>$rs[customer_name]</td>[m
[31m-				<td>$rs[product_name]</td>[m
[31m-			<td><img src='imgwinner/$rs[winners_image]' width='200px;' ></td>[m
[31m-				<td>$rs[winning_bid]</td>[m
[31m-				<td>$rs[end_date]</td></tr>";[m
[32m+[m			[32m    <td><b>$rs[customer_name]</b><br>$rs[email_id]<br>$rs[mobile_no]</td>[m
[32m+[m				[32m<td><b>$rs[product_name]</b><br>Product ID: $rs[prod_id]</td>[m
[32m+[m				[32m<td><b>Rs. $rs[winning_bid]</b></td>[m
[32m+[m				[32m<td>$rs[end_date]</td>[m
[32m+[m				[32m<td><span style='color:$status_color; font-weight:bold;'>$status_label</span></td>[m
[32m+[m			[32m</tr>";[m
 		}[m
 		?>[m
 	</tbody>[m
[1mdiff --git a/viewwinnerslist.php b/viewwinnerslist.php[m
[1mindex f0ff99a..abe6f18 100644[m
[1m--- a/viewwinnerslist.php[m
[1m+++ b/viewwinnerslist.php[m
[36m@@ -47,9 +47,10 @@[m [mfunction countdowntimer(id, time)[m
 	$qsqlproduct = mysqli_query($con,$sqlproduct);[m
 		while($rsproduct = mysqli_fetch_array($qsqlproduct))[m
 		{[m
[31m-				if (file_exists("imgproduct/".$rsproduct["product_image"])) [m
[32m+[m				[32m$arr_pro_img = unserialize($rsproduct["product_image"]);[m
[32m+[m				[32mif ($arr_pro_img && file_exists("imgproduct/".$arr_pro_img[0]))[m[41m [m
 				{[m
[31m-					 $imgname = "imgproduct/".$rsproduct["product_image"];[m
[32m+[m					[32m $imgname = "imgproduct/".$arr_pro_img[0];[m
 				} [m
 				else [m
 				{[m
[1mdiff --git a/viewwinningbid.php b/viewwinningbid.php[m
[1mindex 491eb76..7ce4505 100644[m
[1m--- a/viewwinningbid.php[m
[1m+++ b/viewwinningbid.php[m
[36m@@ -83,13 +83,14 @@[m [mfunction countdowntimer(id, time)[m
     <div class="row">[m
 <?php[m
 $dttim = date("Y-m-d h:i:s");[m
[31m-$sqlproduct = "SELECT *,product.product_id as proid FROM winners LEFT JOIN product ON winners.product_id = product.product_id LEFT JOIN customer ON winners.customer_id=customer.customer_id where (winners.status='Pending' OR winners.status='Active') AND winners.customer_id='" . $_SESSION['customer_id'] . "' AND product.customer_id!='0'  ORDER BY winners.winner_id DESC ";[m
[32m+[m[32m$sqlproduct = "SELECT *,product.product_id as proid FROM winners LEFT JOIN product ON winners.product_id = product.product_id LEFT JOIN customer ON winners.customer_id=customer.customer_id WHERE (winners.status='Pending' OR winners.status='Active') AND winners.customer_id='" . $_SESSION['customer_id'] . "' ORDER BY winners.winner_id DESC ";[m
 $qsqlproduct = mysqli_query($con,$sqlproduct);[m
 		while($rsproduct = mysqli_fetch_array($qsqlproduct))[m
 		{[m
[31m-				if (file_exists("imgproduct/".$rsproduct['product_image'])) [m
[32m+[m				[32m$arr_pro_img = unserialize($rsproduct['product_image']);[m
[32m+[m				[32mif ($arr_pro_img && file_exists("imgproduct/".$arr_pro_img[0]))[m[41m [m
 				{[m
[31m-					 $imgname = "imgproduct/".$rsproduct['product_image'];[m
[32m+[m					[32m $imgname = "imgproduct/".$arr_pro_img[0];[m
 				} [m
 				else [m
 				{[m
[36m@@ -110,38 +111,43 @@[m [m$qsqlproduct = mysqli_query($con,$sqlproduct);[m
 ?>[m
         [m
 		[m
[31m-		<div class="col-md-12">[m
[32m+[m		[32m<div class="col-md-6 col-sm-12" style="margin-bottom:20px;">[m
 			[m
[31m-            <div class="product-grid8 border">[m
[31m-                <div class="product-image8">[m
[32m+[m[32m            <div class="product-grid8 border" style="border-radius:8px; overflow:hidden;">[m
[32m+[m[32m                <div class="product-image8" style="height:250px; overflow:hidden; display:flex; align-items:center; justify-content:center; background:#f9f9f9;">[m
                     <a href="single.php?productid=<?php echo $rsproduct['proid']; ?>">[m
[31m-                        <img class="pic-1" src="<?php echo $imgname; ?>">[m
[31m-                        <img class="pic-2" src="<?php echo $imgwinner; ?>">[m
[32m+[m[32m                        <img class="pic-1" src="<?php echo $imgname; ?>" style="max-height:250px; max-width:100%; width:auto; object-fit:contain;">[m
[32m+[m[32m                        <img class="pic-2" src="<?php echo $imgwinner; ?>" style="max-height:250px; max-width:100%; width:auto; object-fit:contain;">[m
                     </a>[m
[31m-                   [m
                 </div>[m
[31m-                <div class="product-content">[m
[31m-                    <span class="product-shipping" style="color: brown;"><b>Product : <?php echo $rsproduct['product_name']; ?></b></span>[m
[31m-                    <span class="product-shipping" style="color: brown;"><b>Product Code : <?php echo $rsproduct['product_name']; ?> </b></span>[m
[32m+[m[32m                <div class="product-content" style="padding:15px;">[m
[32m+[m[32m                    <span class="product-shipping" style="color:brown;"><b>Product:</b> <?php echo $rsproduct['product_name']; ?></span>[m
[32m+[m[32m                    <span class="product-shipping" style="color:brown;"><b>Product ID:</b> <?php echo $rsproduct['proid']; ?></span>[m
                     <a class="all-deals" href="single.php?productid=<?php echo $rsproduct['proid']; ?>" target="_blank">View Product <i class="fa fa-angle-right icon"></i></a>[m
                 </div>[m
[31m-                <div class="product-content">[m
[31m-                    <span class="product-shipping" style="color: green;"><b>Winner : <?php echo $rsproduct['customer_name']; ?></b></span>[m
[31m-                    <span class="product-shipping" style="color: green;"><b>From : <?php echo $rsproduct['city']; ?></b></span>[m
[31m-                    <span class="product-shipping" style="color: green;"><b>Amount payable: : Rs. <?php echo $rsproduct['winning_bid']; ?></b></span>[m
[31m-[m
[32m+[m[32m                <div class="product-content" style="padding:15px;">[m
[32m+[m[32m                    <span class="product-shipping" style="color:green;"><b>Winner:</b> <?php echo $rsproduct['customer_name']; ?></span>[m
[32m+[m[32m                    <span class="product-shipping" style="color:green;"><b>Amount Payable:</b> Rs. <?php echo $rsproduct['winning_bid']; ?></span>[m
[32m+[m[32m                    <span class="product-shipping" style="color:<?php echo ($rsproduct['status']=='Active') ? 'green' : 'orange'; ?>;"><b>Status:</b> <?php echo ($rsproduct['status']=='Active') ? 'Paid' : 'Pending Payment'; ?></span>[m
 [m
 <?php[m
[31m-if($rsproduct[6] == "Pending")[m
[32m+[m[32mif($rsproduct['status'] == "Pending")[m
 {[m
 ?>[m
[31m-<a class="all-deals" href="paywinningbid.php?winner_id=<?php echo $rsproduct['winner_id']; ?>">Claim winning bid <i class="fa fa-angle-right icon"></i></a>[m
[31m-[m
[31m-[m
[32m+[m[32m<a class="all-deals" style="background:#4CAF50;" href="esewa_payment.php?winner_id=<?php echo $rsproduct['winner_id']; ?>">[m
[32m+[m[32m    Pay with eSewa <i class="fa fa-angle-right icon"></i>[m
[32m+[m[32m</a>[m
[32m+[m[32m<?php[m
[32m+[m[32m}[m
[32m+[m[32melse[m
[32m+[m[32m{[m
[32m+[m[32m?>[m
[32m+[m[32m<a class="all-deals" style="background:#0081c2;" href="paymentreceiptwinningbid.php">[m
[32m+[m[32m    View Receipt <i class="fa fa-angle-right icon"></i>[m
[32m+[m[32m</a>[m
 <?php[m
 }[m
 ?>[m
[31m-[m
                 </div>[m
             </div>[m
         </div>[m
[1mdiff --git a/winningproduct.php b/winningproduct.php[m
[1mindex 83422fa..b34b644 100644[m
[1m--- a/winningproduct.php[m
[1m+++ b/winningproduct.php[m
[36m@@ -8,9 +8,10 @@[m [m$rsproduct= mysqli_fetch_array($qsqlproduct);[m
 $qsqlwinner = mysqli_query($con,$sqlwinner);[m
 $rswinner = mysqli_fetch_array($qsqlwinner);[m
 [m
[31m-if (file_exists("imgproduct/".$rsproduct['product_image'])) [m
[32m+[m[32m$arr_pro_img = unserialize($rsproduct['product_image']);[m
[32m+[m[32mif ($arr_pro_img && file_exists("imgproduct/".$arr_pro_img[0]))[m[41m [m
 {[m
[31m-	$imgname = "imgproduct/".$rsproduct['product_image'];[m
[32m+[m	[32m$imgname = "imgproduct/".$arr_pro_img[0];[m
 } [m
 else [m
 {[m
