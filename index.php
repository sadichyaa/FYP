<!DOCTYPE html>
<html>
<head>
    <title>Auction Home</title>
    <style>
        body { margin:0; font-family:Arial; background:#f5f5f5; }

        /* Header */
        .topbar {
            background:#005bbb;
            color:white;
            padding:15px;
            font-size:20px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .topbar .logo {
            font-size:24px;
            font-weight:bold;
        }

        .topbar a {
            color:white;
            margin-left:15px;
            text-decoration:none;
            font-size:16px;
        }

        /* Product Sections */
        .section-title {
            text-align:center;
            margin:40px 0 10px 0;
            font-size:28px;
            font-weight:bold;
        }

        .products {
            display:flex;
            flex-wrap:wrap;
            justify-content:center;
            gap:20px;
            padding:20px;
        }

        .product {
            width:250px;
            background:white;
            border-radius:10px;
            padding:15px;
            box-shadow:0 0 10px #ccc;
            text-align:center;
        }

        .product img {
            width:100%;
            height:200px;
            background:#ddd;
            border-radius:10px;
        }

        .btn {
            display:inline-block;
            margin-top:10px;
            padding:10px 20px;
            background:#005bbb;
            color:white;
            text-decoration:none;
            border-radius:5px;
        }
    </style>
</head>

<body>

<!-- ======================== -->
<!-- This is header.php       -->
<!-- ======================== -->
<div class="topbar">
    <div class="logo">AUCTION SYSTEM</div>
    <div class="nav">
        <a href="index.php">Home</a>
        <a href="customerlogin.php">Login</a>
        <a href="registry.php">Register</a>
        <a href="employeelogin.php">Employee Login</a>
    </div>
</div>
<!-- END OF header.php -->

<!-- Banner -->
<div style="width:100%; height:300px; background:#d9d9d9; display:flex; justify-content:center; align-items:center; font-size:30px;">
    Banner / Slider Area
</div>

<!-- Latest Auctions -->
<div class="section-title">Latest Auctions</div>
<div class="products">
    <div class="product">
        <img src="images/sample.jpg">
        <h3>Product Name</h3>
        <p>Product Code: 12345</p>
        <a class="btn">Bid Now</a>
    </div>

    <div class="product">
        <img src="images/sample.jpg">
        <h3>Product Name</h3>
        <p>Product Code: 12345</p>
        <a class="btn">Bid Now</a>
    </div>
</div>

<!-- Featured Auctions -->
<div class="section-title">Featured Auctions</div>
<div class="products">
    <div class="product">
        <img src="images/sample.jpg">
        <h3>Featured Product</h3>
        <a class="btn">View</a>
    </div>
</div>

<!-- Closing Soon -->
<div class="section-title">Closing Soon</div>
<div class="products">
    <div class="product">
        <img src="images/sample.jpg">
        <h3>Product Ending Soon</h3>
        <a class="btn">Bid Now</a>
    </div>
</div>

<!-- Closed Auctions -->
<div class="section-title">Recently Closed Auctions</div>
<div class="products">
    <div class="product">
        <img src="images/sample.jpg">
        <h3>Closed Product</h3>
        <a class="btn">View Result</a>
    </div>
</div>

</body>
</html>
