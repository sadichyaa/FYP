<?php
include("header.php");
if(isset($_POST['submit']))
{
    // OTP VALIDATION
    if(!isset($_SESSION['otp']))
    {
        echo "<script>alert('Session expired. Please try again');</script>";
    }
    elseif(trim($_POST['enteredotp']) != $_SESSION['otp'])
    {
        echo "<script>alert('Invalid OTP');</script>";
    }
    elseif(time() - $_SESSION['otp_time'] > 300)
    {
        echo "<script>alert('OTP expired');</script>";
    }
    else
    {
        // ORIGINAL REGISTER LOGIC
        $check_email_query = "SELECT email_id FROM customer WHERE email_id='$_POST[email_id]' LIMIT 1";
        $check_email_query_run = mysqli_query($con, $check_email_query);

        if(mysqli_num_rows($check_email_query_run) > 0)
        {
            echo "<script>alert('Email already exist..');</script>";
            echo "<script>window.location='register.php';</script>";
        }
        else
        {
            $sql = "INSERT INTO customer(customer_name,email_id,password,mobile_no,status) VALUES('$_POST[customer_name]','$_POST[email_id]','$_POST[password]','$_POST[mobile_no]','Active')";
            $qsql = mysqli_query($con, $sql);

            if(mysqli_affected_rows($con) == 1)
            {
                echo "<script>alert('Customer Registration done successfully..');</script>";
                echo "<script>window.location='customerlogin.php';</script>";
                // CLEAR OTP
                unset($_SESSION['otp']);
                unset($_SESSION['otp_email']);
                unset($_SESSION['otp_time']);
            }
            else
            {
                echo "<script>alert('Failed to Register..');</script>";
                echo mysqli_error($con);
            }
        }
    }
}
?>

<!-- breadcrumb -->
<div class="breadcrumb-area bg-gray">
    <div class="container-fluid">
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Register</li>
        </ul>
    </div>
</div>

<div class="content-wraper mt-50">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="customer-login-register">
                    <center><h3>Customer Registration Panel</h3></center>
                    <div class="login-Register-info">
                        <form action="" method="post">
                            <p>
                                <label>Full Name</label>
                                <input type="text" name="customer_name" id="customer_name">
                            </p>
                            <p>
                                <label>Email</label>
                                <input type="text" name="email_id" id="email_id">
                            </p>
                            <p>
                                <label>Mobile No</label>
                                <input type="text" name="mobile_no" id="mobile_no">
                            </p>
                            <p>
                                <label>Password</label>
                                <input type="password" name="password" id="password">
                            </p>
                            <p>
                                <label>Confirm Password</label>
                                <input type="password" name="cpassword" id="cpassword">
                            </p>
                            <p>
                                <button type="button" id="btnsubmit" onclick="return validatecustomer()">Register</button>
                            </p>

                            <!-- OTP MODAL -->
                            <div id="otpModal" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>Verify OTP</h4>
                                        </div>
                                        <div class="modal-body">
                                            <label>Email</label>
                                            <input type="text" id="emailids" readonly>
                                            <label>Enter OTP</label>
                                            <input type="text" name="enteredotp" id="enteredotp">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="submit">Complete Registration</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

<script>
function validatecustomer()
{
    var email = document.getElementById("email_id").value;
    var name  = document.getElementById("customer_name").value;

    if(email == "" || name == "")
    {
        alert("Fill required fields");
        return false;
    }

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
        {
            if(this.responseText.trim() == "sent")
            {
                document.getElementById("emailids").value = email;
                $('#otpModal').modal('show');
            }
            else
            {
                alert("Failed to send OTP");
            }
        }
    };
    xmlhttp.open("GET", "sendotp.php?emailid=" + email + "&cstname=" + name, true);
    xmlhttp.send();
}
</script>
