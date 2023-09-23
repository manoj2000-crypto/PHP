<?php
session_start();

// Add the following code to prevent caching of the payment gateway page
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $cardname = $_POST["cardname"];
  $cardnumber = $_POST["cardnumber"];
  $expmonth = $_POST["expmonth"];
  $expyear = $_POST["expyear"];
  $cvv = $_POST["cvv"];

  if (!empty($cardname) && !empty($cardnumber) && !empty($expmonth) && !empty($expyear) && !empty($cvv))
  {
    // Store payment details in session
    $_SESSION["payment_success"] = true;
    $_SESSION["cardname"] = $cardname;
    $_SESSION["cardnumber"] = $cardnumber;
    $_SESSION["expmonth"] = $expmonth;
    $_SESSION["expyear"] = $expyear;
    $_SESSION["cvv"] = $cvv;

    header("Location: thank-you.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
  font-family: Arial;
  font-size: 17px;
  padding: 8px;
}

* {
  box-sizing: border-box;
}

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #04AA6D;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}

a {
  color: #2196F3;
}

hr {
  border: 1px solid lightgrey;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}

/* Custom style for the logo image */
.logo {
  position: absolute;
  top: 20px;
  left: 30px;
}
.logo2 {
  position: absolute;
  top: 20px;
  right: 30px;
}
.logo3 {
  position: absolute;
  top: 20px;
  right: 200px;
}
</style>

<script>
function hideCVV() {
  var cvv = document.getElementById("cvv");
  if (cvv.type === "password") {
    cvv.type = "text";
  } else {
    cvv.type = "password";
  }
}

function hideCardNumber() {
  var cardnumber = document.getElementById("ccnum");
  if (cardnumber.type === "password") {
    cardnumber.type = "text";
  } else {
    cardnumber.type = "password";
  }
}

function validateForm() {
  var cardname = document.getElementById("cname").value;
  var cardnumber = document.getElementById("ccnum").value;
  var expmonth = document.getElementById("expmonth").value;
  var expyear = document.getElementById("expyear").value;
  var cvv = document.getElementById("cvv").value;

  if (cardname === "") {
    alert("Name on Card is required");
    return false;
  }
  if (cardnumber === "") {
    alert("Card number is required");
    return false;
  }
  if (expmonth === "") {
    alert("Expiration Month is required");
    return false;
  }
  if (expyear === "") {
    alert("Expiration Year is required");
    return false;
  }
  if (cvv === "") {
    alert("CVV is required");
    return false;
  }
  if (!/^\d{3}$/.test(cvv)) {
    alert("CVV must be a 3-digit code");
    return false;
  }
  if (!/^\d{4}$/.test(expyear)) {
    alert("Invalid year format. Please enter a 4-digit year");
    return false;
  }

  // Additional validations
  if (!/^\d{1,2}$/.test(expmonth) || parseInt(expmonth) > 12) {
    alert("Invalid expiration month. Please enter a valid month (1-12)");
    return false;
  }
  if (!/^\d{15,16}$/.test(cardnumber)) {
    alert("Invalid card number format. Please enter a valid 15-digit or 16-digit card number");
    return false;
  }

  return true;
}
</script>
</head>

<body>
<img src="images\logo1.png" style="max-width: 100%; height: 90px;" alt="Logo" class="logo">
<img src="images\payment_gateway.png" style="max-width: 100%; height: 90px;" alt="Logo2" class="logo2">
<img src="images\razerpay.png" style="max-width: 100%; height: 70px;" alt="Logo3" class="logo3">
<center>
<h2>Rich Class Family Salon</h2>
<p>Payment Gateway</p>
</center>
<div class="row">
  <div class="col-75">
    <div class="container">
      <form action="" method="POST" onsubmit="return validateForm()">
        <div class="row">
          <div class="col-50">
            <center>
              <h3>Payment</h3>
              <label for="fname">Accepted Cards</label>
              <div class="icon-container">
                <i class="fa fa-cc-visa" style="color:navy;"></i>
                <i class="fa fa-cc-amex" style="color:blue;"></i>
                <i class="fa fa-cc-mastercard" style="color:red;"></i>
                <i class="fa fa-cc-discover" style="color:orange;"></i>
              </div>
            </center>
            <label for="cname">Name on Card</label>
            <input type="text" id="cname" name="cardname" placeholder="Full Name" required>
            <label for="ccnum">Card number</label>
            <input type="password" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444" required>
            <label for="expmonth">Exp Month</label>
            <input type="text" id="expmonth" name="expmonth" placeholder="Month Number" required>
            <div class="row">
              <div class="col-50">
                <label for="expyear">Exp Year</label>
                <input type="text" id="expyear" name="expyear" placeholder="2033" required>
              </div>
              <div class="col-50">
                <label for="cvv">CVV</label>
                <input type="password" id="cvv" name="cvv" placeholder="Three Digit code" required>
              </div>
            </div>
            <input type="checkbox" onclick="hideCVV()"> Show CVV
	    <input type="checkbox" onclick="hideCardNumber()"> Show Card Number
          </div>
        </div>
        <input type="submit" value="Pay" class="btn">
      </form>
    </div>
  </div>
</div>
</body>
</html>
