<div class="breadcrumb-area bg-gray">
    ...
</div>

<div class="content-wraper mt-50">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">

                <div class="customer-login-register">
                    <center><h3>Customer Registration Panel</h3></center>

                    <form action="" method="post"> 
                        <p>
                            <label>Full Name *</label>
                            <input type="text" name="customer_name" id="customer_name">
                        </p>

                        <p>
                            <label>Email *</label>
                            <input type="text" name="email_id" id="email_id">
                        </p>

                        <p>
                            <label>Mobile No. *</label>
                            <input type="text" name="mobile_no" id="mobile_no">
                        </p>

                        <p>
                            <label>Password *</label>
                            <input type="password" name="password" id="password">
                        </p>

                        <p>
                            <label>Confirm password *</label>
                            <input type="password" name="cpassword" id="cpassword">
                        </p>

                        <button type="submit" name="btnsubmit" id="btnsubmit" onclick="return validatecustomer()">Register</button>
                    </form>
