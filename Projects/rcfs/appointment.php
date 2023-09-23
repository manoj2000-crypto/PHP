<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $services = $_POST['services'];
    $adate = $_POST['adate'];
    $atime = $_POST['atime'];
    $phone = $_POST['phone'];
    $aptnumber = mt_rand(100000000, 999999999);

    // Form validation
    $errors = array();

    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $errors[] = "Invalid phone number format. Please enter a 10-digit number.";
    }

    if (empty($services)) {
        $errors[] = "Please select a service.";
    }

    if (empty($adate)) {
        $errors[] = "Appointment date is required.";
    }

    if (empty($atime)) {
        $errors[] = "Appointment time is required.";
    }

    if (empty($errors)) {
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['services'] = $services;
        $_SESSION['adate'] = $adate;
        $_SESSION['atime'] = $atime;
        $_SESSION['phone'] = $phone;
        $_SESSION['aptnumber'] = $aptnumber;
        
        $query = mysqli_query($con, "INSERT INTO tblappointment(AptNumber, Name, Email, PhoneNumber, AptDate, AptTime, Services) VALUES ('$aptnumber','$name','$email','$phone','$adate','$atime','$services')");
        if ($query) {
            echo "<script>window.location.href='payment_gateaway.php'</script>";
            exit();
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    } else {
        $error_msg = implode("  ", $errors);
        echo "<script>alert('$error_msg');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Rich Class Family Salon || Appointments Form</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i%7cMontserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- Style -->
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <?php include_once('includes/header.php'); ?>
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-caption">
                        <h2 class="page-title">Book Appointment</h2>
                        <div class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li><a href="index.php">Home</a></li>
                                <li class="active">Book Appointment</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">

                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h1>Appointment Form</h1>
                            <p>Book your appointment to save salon rush.</p>
                            <form method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="name">Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Name" name="name" required="true">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label" for="phone">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required="true" maxlength="10" pattern="[0-9]+">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label" for="email">Email</label>
                                        <input type="email" class="form-control" id="appointment_email" placeholder="Email" name="email" required="true">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label" for="Subject">Services</label>
                                        <select name="services" id="services" required="true" class="form-control">
                                            <option value="">Select Services</option>
                                            <?php
                                            $query = mysqli_query($con, "SELECT * FROM tblservices");
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                <option value="<?php echo $row['ServiceName']; ?>"><?php echo $row['ServiceName']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label" for="textarea">Appointment Date</label>
                                            <input type="date" class="form-control appointment_date" placeholder="Date" name="adate" id='adate' required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label" for="textarea">Appointment Time</label>
                                            <input type="time" class="form-control appointment_time" placeholder="Time" name="atime" id='atime' required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" id="submit" name="submit" class="btn btn-default">Book</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                <li><i class="fa fa-map-marker"></i> Apple Residency, Sinhgad Rd, opposite Nanded City Road, Nanded Fata, Pandurang Industrial Area, Nanded, Pune-411041 </li>
                                <li><i class="fa fa-phone"></i> +91 9665669029 </li>
                                <li><i class="fa fa-envelope-o"></i> richclassfamilysalon@gmail.com </li>
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
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Email Address" name="emailfooter" id="emailfooter">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="subscribe" name="subscribe">Subscribe</button>
                                </span>
                            </div>
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
                                <p>© 2023 Rich Class Family Salon || all rights reserved </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- tiny footer block -->
        </div>
    </div>
    <!-- footer-->
    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/retina.js"></script>
    <script src="js/scrollreveal.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/jquery.countdown.js"></script>
    <script src="js/jquery.countdown-de.js"></script>
    <script src="js/custom.js"></script>
    <script>
        $(document).ready(function() {
    $("#submit").click(function() {
        var adate = $("#adate").val();
        var atime = $("#atime").val();
        
        var selected_datetime = new Date(adate + "T" + atime);
        var current_datetime = new Date();
        
        if (selected_datetime < current_datetime) {
            alert("Please select a future date and time for the appointment.");
            return false;
        }
    });
});
    </script>
</body>
</html>