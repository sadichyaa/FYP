<?php

include ('databaseconnection.php');






if(isset($_GET['token']))
{
    $token = $_GET['token'];
   
 
    $verify_query= "SELECT verify_token, verify_status FROM billing WHERE verify_token='$token' LIMIT 1";
    $verify_query_run = mysqli_query($con, $verify_query);

 
    if(mysqli_num_rows($verify_query_run) > 0)
    {
        $row = mysqli_fetch_array($verify_query_run);
        if($row['verify_status'] == "0")
        {
            $clicked_token = $row['verify_token'];
            $update_query = "UPDATE billing SET verify_status='1' WHERE verify_token ='$clicked_token' LIMIT 1";
            $update_query_run = mysqli_query($con, $update_query);  

            if($update_query_run )
            {
                $sql=  "SELECT * FROM billing ";
                $qsql = mysqli_query($con,$sql);
                while($res= mysqli_fetch_array($qsql))
                {
                echo "<script>alert('You have paid Rs. $res[purchase_amount] successfully for winning bid...');</script>";
		        echo "<SCRIPT>window.location='paymentreceiptwinningbid.php?paymentid= $res[billing_id]';</SCRIPT>";
                exit(0);

                }
                
            }
            else
            {
                echo "<script>alert('Verification has failed.');</script>";
                header("Location: paywinningbid.php");
                exit(0);
            }

        }
        else
        {
            echo "<script>alert('Payment alredy verified.');</script>";
            
            header("Location: customeraccount.php");
            exit(0);

        }
    }
    else
    {
        echo "<script>alert('This token doesnot exist.');</script>";
            header("Location: customeraccount.php");
      
        exit(0);

    }
}

else
{
    echo "<script>alert('Not allowded.');</script>";
    header("Location: paywinningbid.php");
    exit(0);
}







?>