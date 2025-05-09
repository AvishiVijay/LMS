<?php
  include('./dbConnection.php');
  // Header Include from mainInclude 
  include('./mainInclude/header.php'); 
  header("Pragma: no-cache");
  header("Cache-Control: no-cache");
  header("Expires: 0");

  // Include Paytm payment files
  require_once("./PaytmKit/lib/config_paytm.php");
  require_once("./PaytmKit/lib/encdec_paytm.php");

  $ORDER_ID = "";
  $requestParamList = array();
  $responseParamList = array();

  if (isset($_POST["ORDER_ID"]) && !empty($_POST["ORDER_ID"])) {
      $ORDER_ID = $_POST["ORDER_ID"];

      // Create an array with required parameters
      $requestParamList = array("MID" => PAYTM_MERCHANT_MID, "ORDERID" => $ORDER_ID);

      // Generate checksum hash
      $StatusCheckSum = getChecksumFromArray($requestParamList, PAYTM_MERCHANT_KEY);
      $requestParamList['CHECKSUMHASH'] = $StatusCheckSum;

      // Get transaction status
      $responseParamList = getTxnStatusNew($requestParamList);
  }

?>  
<div class="container-fluid bg-dark"> <!-- Start Course Page Banner -->
    <div class="row">
        <img src="./image/coursebanner.jpg" alt="courses" style="height:300px; width:100%; object-fit:cover; box-shadow:10px;"/>
    </div> 
</div> <!-- End Course Page Banner -->

<div class="container">
    <h2 class="text-center my-4">Payment Status</h2>
    <form method="post" action="">
        <div class="form-group row">
            <label class="offset-sm-3 col-form-label">Order ID:</label>
            <div>
                <input class="form-control mx-3" id="ORDER_ID" tabindex="1" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="<?php echo htmlspecialchars($ORDER_ID); ?>">
            </div>
            <div>
                <input class="btn btn-primary mx-4" value="View" type="submit">
            </div>
        </div>
    </form>
</div>

<div class="container">
    <?php
      if (!empty($responseParamList)) { 
          if (isset($responseParamList["ORDERID"])) {
              $orderID = $responseParamList["ORDERID"];
          } else {
              $orderID = null;
          }

          $sql = "SELECT order_id FROM courseorder";
          $result = $conn->query($sql);

          if (!$result) {
              echo "<p class='text-center text-danger'>Database error: " . $conn->error . "</p>";
          } else {
              $orderFound = false;
              while ($row = $result->fetch_assoc()) {
                  if ($orderID !== null && $orderID == $row["order_id"]) { 
                      $orderFound = true;
                      ?>
                      <div class="row justify-content-center">
                          <div class="col-auto">
                              <h2 class="text-center">Payment Receipt</h2>
                              <table class="table table-bordered">
                                  <tbody>
                                      <?php
                                      foreach ($responseParamList as $paramName => $paramValue) {
                                          if (in_array($paramName, ["TXNID", "ORDERID", "TXNAMOUNT", "STATUS"])) { ?>
                                              <tr>
                                                  <td><label><?php echo htmlspecialchars($paramName); ?></label></td>
                                                  <td><?php echo htmlspecialchars($paramValue); ?></td>
                                              </tr>
                                      <?php } } ?>
                                      <tr>
                                          <td></td>
                                          <td><button class="btn btn-primary" onclick="javascript:window.print();">Print Receipt</button></td>
                                      </tr>
                                  </tbody>
                              </table>      
                          </div>
                      </div>
                  <?php
                  }
              }
              if (!$orderFound) {
                  echo "<p class='text-center text-danger'>No matching order found.</p>";
              }
          }
      } else {
          echo "<p class='text-center text-danger'>No transaction details available.</p>";
      }
    ?>
</div>

<div class="mt-5">
    <?php include('./contact.php'); ?> 
</div>

<?php include('./mainInclude/footer.php'); ?>
