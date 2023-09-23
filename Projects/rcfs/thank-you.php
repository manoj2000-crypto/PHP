<?php
require_once('TCPDF-main/tcpdf.php');
include('includes/dbconnection.php');
session_start();
error_reporting(0);

if (!isset($_SESSION["payment_success"]) || !$_SESSION["payment_success"]) {
  // Redirect back to the payment page
  header("Location: payment_gateaway.php");
  exit();
}

// Check if the PDF download is requested
if (isset($_GET["download"]) && $_GET["download"] === "pdf") {
  // Generate PDF
  $headerLogo = ".\\images\\logo1.png";
  $headerLogoWidth = 30; // in millimeters
  $headerTitle = 'Rich Class Family Salon';
  $headerString = 'Appointment Details';
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  // Set document information
  $pdf->SetCreator('Rich Class Family Salon');
  $pdf->SetAuthor('Rutuja');
  $pdf->SetTitle('Appointment Details');
  $pdf->SetSubject('Appointment Details');
  $pdf->SetKeywords('Appointment, Thank You');

  // Set default header data
  $pdf->SetHeaderData($headerLogo, $headerLogoWidth, $headerTitle, $headerString);

  // Set header and footer fonts
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

  // Set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

  // Set margins
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

  // Set auto page breaks
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

  // Set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

  // Set font
  $pdf->SetFont('helvetica', '', 12);

  // Add a page
  $pdf->AddPage();

  // Create the appointment details table
  $html = '<h2>Appointment Details</h2>';
  $html .= '<table border="1" cellpadding="5" cellspacing="0">';
  $html .= '<tr>';
  $html .= '<th>Appointment No</th>';
  $html .= '<th>Customer Name</th>';
  $html .= '<th>Email</th>';
  $html .= '<th>Phone</th>';
  $html .= '<th>Service</th>';
  $html .= '<th>Cost</th>';
  $html .= '<th>Date</th>';
  $html .= '<th>Time</th>';
  $html .= '</tr>';

  // Retrieve appointment details from session
  $aptno = $_SESSION['aptnumber'];//*****************************
  $customerName = $_SESSION['name'];
  $email = $_SESSION['email'];
  $phone = $_SESSION['phone'];
  $service = $_SESSION['services'];
  $date = $_SESSION['adate'];
  $time = $_SESSION['atime'];

  $selectedService = mysqli_real_escape_string($con, $_SESSION['services']);
  $query = "SELECT Cost FROM tblservices WHERE ServiceName = '$selectedService'";
  $result = mysqli_query($con, $query);
  
  if ($result)
  {
     $row = mysqli_fetch_assoc($result);
     $serviceCost = $row['Cost'];
  }
  else 
  {
    echo "Error: " . mysqli_error($connection);
  }

  // Add data to the appointment details table
  $html .= '<tr>';
  $html .= '<td>' . $aptno . '</td>';
  $html .= '<td>' . $customerName . '</td>';
  $html .= '<td>' . $email . '</td>';
  $html .= '<td>' . $phone . '</td>';
  $html .= '<td>' . $service . '</td>';
  $html .= '<td>' . $serviceCost . '</td>';
  $html .= '<td>' . $date . '</td>';
  $html .= '<td>' . $time . '</td>';
  $html .= '</tr>';
  $html .= '</table>';

  // Create the payment details table
  $html .= '<h2>Payment Details</h2>';
  $html .= '<table border="1" cellpadding="5" cellspacing="0">';
  $html .= '<tr>';
  //$html .= '<th>Payment Method</th>';
  $html .= '<th>Card Name</th>';
  $html .= '<th>Card Number</th>';
  $html .= '<th>Expiration Month</th>';
  $html .= '<th>Expiration Year</th>';
  $html .= '</tr>';

  // Retrieve payment details from session
  //$paymentMethod = $_SESSION['payment_method'];
  $cardName = $_SESSION['cardname'];
  $cardNumber = $_SESSION['cardnumber'];
  $expMonth = $_SESSION['expmonth'];
  $expYear = $_SESSION['expyear'];

  // Add data to the payment details table
  $html .= '<tr>';
  //$html .= '<td>' . $paymentMethod . '</td>';
  $html .= '<td>' . $cardName . '</td>';
  $html .= '<td>' . $cardNumber . '</td>';
  $html .= '<td>' . $expMonth . '</td>';
  $html .= '<td>' . $expYear . '</td>';
  $html .= '</tr>';
  $html .= '</table>';

  // Output the HTML content
  $pdf->writeHTML($html, true, false, true, false, '');

  // Close and output PDF document
  $pdf->Output('appointment_details.pdf', 'D');

  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <title>Men Salon Management System || Thank You Page</title>
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
    <?php include_once('includes/header.php');?>
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-caption">
                        <h2 class="page-title">Thank You</h2>
                        <div class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li><a href="index.php">Home</a></li>
                                <li class="active">Thank You</li>
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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="post-block post-quote">
                        <div class="row ">
                            <!-- post block -->
                            <div class="col-md-12">
                                <div class="quote-content">
                                    <blockquote>“Payment Successful! Your Appointment No is <?php echo $_SESSION['aptnumber'];?>”</blockquote>
                                    <a href="thank-you.php?download=pdf" class="btn btn-primary" target="_blank">Generate PDF</a>
                                </div>
                            </div>
                            <!-- /.post block -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
         include_once('includes/footer.php');
         mysqli_close($connection); 
    ?>
    <!-- /.footer-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/menumaker.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/sticky-header.js"></script>
</body>
</html>
