            <!-- footer-area start -->
            <footer class="footer-area">
              
                <div class="footer-top bg-black">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-4 col-md-12">
                                <div class="about-us-footer">
                                    <div class="footer-logo">
                                        <a href="#"><img src="img/logo/logoo.PNG" alt=""></a>
                                    </div>
                                    <div class="footer-info">
                                        <p class="phone">987777777799</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-12">
                                <div class="footer-info-inner">
                                    <div class="row">


<div class="col-lg-3 col-md-6 col-sm-6">
                                            <div class="footer-title">
                                                <h3> Account </h3>
                                            </div>
                                            <ul>
                                                <!-- <li><a href="about-us.php">About us</a></li> -->
                                                <li><a href="employeelogin.php?logintype=Admin">Admin Login</a></li>
            <li><a href="customerlogin.php">Customer Login</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                            <div class="footer-title">
                                                <h3> Our Pages </h3>
                                            </div>
                                            <ul>
                                                <!-- <li><a href="about-us.php">About us</a></li> -->
                                                <li><a href="index.php">Home</a></li>
                                                <li><a href="contact.php">Contact us </a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-5 offset-xl-1 col-md-6 col-sm-6">
                                            <div class="footer-title">
                                                <h3>Get in touch</h3>
                                            </div>
                                            <div class="block-contact-text">
                                                <p> SecondChance<br>Lalitpur,Kathmandu</p>
                                                <p>Call us: <span>9877777789 </span></p>
                                                <p>Email us: <span>secondchance@gmail.com</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="copyright">Copyright &copy; Online Auction. All Rights Reserved</div>
                            </div>	
                            <!-- <div class="col-lg-6 col-md-6">
                                 <div class="payment"><img alt="" src="img/icon/payment.png"></div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </footer>
            <!-- footer-area start -->
            
        
        </div>   
           
        
		<!-- jquery -->		
        <script src="js/vendor/jquery-1.12.4.min.js"></script>
		<!-- all plugins JS hear -->		
        <script src="js/popper.min.js"></script>	
        <script src="js/bootstrap.min.js"></script>	
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/jquery.mainmenu.js"></script>	
        <script src="js/ajax-email.js"></script>
        <script src="js/plugins.js"></script>
		<!-- main JS -->		
        <script src="js/main.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
<script>
$(document).ready( function () {
    $('#datatable').DataTable();
} );
</script>

<?php
// Winner popup - fires after full page load
if(isset($_SESSION['winner_popup_id']) && isset($_SESSION['winner_popup_name']))
{
    $popup_winner_id   = $_SESSION['winner_popup_id'];
    $popup_product_name = $_SESSION['winner_popup_name'];
    // Clear session so it only shows once
    unset($_SESSION['winner_popup_id']);
    unset($_SESSION['winner_popup_name']);
?>
<script>
window.onload = function() {
    if(confirm('🎉 Congratulations! You won the auction for:\n\n<?php echo $popup_product_name; ?>\n\nClick OK to proceed to eSewa payment.'))
    {
        window.location = 'esewa_payment.php?winner_id=<?php echo $popup_winner_id; ?>';
    }
    else
    {
        window.location = 'viewwinningbid.php';
    }
};
</script>
<?php } ?>
    </body>

<!-- Mirrored from demo.hasthemes.com/juta-preview/juta-v1/index-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 25 Dec 2019 04:55:35 GMT -->
</html>