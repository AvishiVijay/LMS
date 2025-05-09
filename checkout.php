<?php 
include('./dbConnection.php');
session_start();

if (!isset($_SESSION['stuLogEmail'])) {
    echo "<script> location.href='loginorsignup.php'; </script>";
    exit;
}

header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

$stuEmail = $_SESSION['stuLogEmail'];
$_SESSION['TXNAMOUNT'] = $_POST['id'] ?? '500';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <div class="row">
    <div class="col-sm-6 offset-sm-3 jumbotron">
      <h3 class="mb-5">Welcome to A Cube Tech Payment Page</h3>
      <form method="post" action="./PaytmKit/pgRedirect.php">
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Order ID</label>
          <div class="col-sm-8">
            <input class="form-control" name="ORDER_ID" value="<?php echo $order_id = 'ORD' . rand(10000,99999999); ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Student Email</label>
          <div class="col-sm-8">
            <input class="form-control" name="CUST_ID" value="<?php echo $stuEmail; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Amount</label>
          <div class="col-sm-8">
            <input class="form-control" name="TXN_AMOUNT" value="<?php echo $_SESSION['TXNAMOUNT']; ?>" readonly>
          </div>
        </div>
        <div class="text-center">
          <input value="Check out" type="submit" class="btn btn-primary">
          <a href="./courses.php" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
