<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);

if (isset($_POST['subscribe'])) {
    $emailfooter = $_POST['emailfooter'];

    $errors = array();

    if (empty($emailfooter)) {
        $errors[] = "Email address is required.";
    } elseif (!filter_var($emailfooter, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($errors)) {
        $query = mysqli_query($con, "INSERT INTO tblsubscriber(Email) VALUES ('$emailfooter')");
        if ($query) {
            echo "<script>alert('Subscription successful.');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    } else {
        $error_msg = implode("  ", $errors);
        echo "<script>alert('$error_msg');</script>";
    }
}

  ?>
<div class="footer">
        <!-- footer-->
        <div class="container">
            <div class="footer-block">
                <!-- footer block -->
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="footer-widget">
                            <h2 class="widget-title">Salon Address</h2>
                            <ul class="listnone contact">
                                <?php

$ret=mysqli_query($con,"select * from tblpage where PageType='contactus' ");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
                                <li><i class="fa fa-map-marker"></i> <?php  echo $row['PageDescription'];?> </li>
                                <li><i class="fa fa-phone"></i> +<?php  echo $row['MobileNumber'];?></li>
                               
                                <li><i class="fa fa-envelope-o"></i>  <?php  echo $row['Email'];?></li><?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="footer-widget footer-social">
                            <!-- social block -->
                            <h2 class="widget-title">Social Feed</h2>
                            <ul class="listnone">
                                <li>
                                    <a href="https://maps.app.goo.gl/Vki5bC1QoybNZAV86" target="_blank"> <i class="fa fa-map-marker" aria-hidden="true"> </i> Map </a>
                                </li>
                                <li>
                                    <a href="https://instagram.com/richclass_salon124?igshid=NTc4MTIwNjQ2YQ==" target="_blank"> <i class="fa fa-instagram" aria-hidden="true"> </i> Instagram </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.social block -->
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                        <div class="footer-widget widget-newsletter">
                            <!-- newsletter block -->
                            <h2 class="widget-title">Newsletters</h2>
                            <p>Enter your email address to receive new patient information and other useful information right to your inbox.</p>
                            <form method="post">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter your email address" name="emailfooter" id="emailfooter">
                                <span class="input-group-btn">
                            <button class="btn btn-default" type="submit" value="submit" name="subscribe" id="subscribe">Subscribe</button>
                            </span>
                            </div></form>
                            <!-- /input-group -->
                        </div>
                        <!-- newsletter block -->
                    </div>
                </div>
                <div class="tiny-footer">
                    <!-- tiny footer block -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="copyright-content">
                                <p>@ Rich class family salon 2023</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.tiny footer block -->
            </div>
            <!-- /.footer block -->
        </div>
    </div>