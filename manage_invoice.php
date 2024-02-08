<?php
include("php/db_connection.php");
$sql = "SELECT * FROM invoices";
if ($con) {
  $result = mysqli_query($con, $sql);
  $finaldata = array();
  while ($data = mysqli_fetch_assoc($result)) {
    $finaldata[] = $data;
  }

  if (isset($_POST['export'])) {
    $filename = "Invoices" . date('Ymdhis') . ".xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment;filename=\"$filename\"");

    $firstrow = false;
    foreach ($finaldata as $data) {
      if (!$firstrow) {
        echo implode("\t", array_keys($data)) . "\n";
        $firstrow = true;
      }
      echo implode("\t", array_values($data)) . "\n";
    }
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Manage Invoice</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/sidenav.css">
  <link rel="stylesheet" href="css/home.css">
  <script src="js/manage_invoice.js"></script>
  <script src="js/restrict.js"></script>
</head>

<body>
  <!-- including side navigations -->
  <?php include("sections/sidenav.html"); ?>

  <div class="container-fluid">
    <div class="container">

      <!-- header section -->
      <?php
      require "php/header.php";
      createHeader('address-book', 'Manage Invoice', 'Manage Existing Invoice');
      ?>
      <!-- header section end -->

      <!-- form content -->
      <div class="row">

        <div class="col-md-12 form-group form-inline">
          <label class="font-weight-bold" for="">Search :&emsp;</label>
          <input type="number" class="form-control" id="by_invoice_number" placeholder="By Invoice Number" onkeyup="searchInvoice(this.value, 'INVOICE_ID');">
          &emsp;<input type="text" class="form-control" id="by_customer_name" placeholder="By Customer Name" onkeyup="searchInvoice(this.value, 'NAME');">
          &emsp;<label class="font-weight-bold" for="">By Invoice Date :&emsp;</label>
          <input type="date" class="form-control" id="by_date" onchange="searchInvoice(this.value, 'INVOICE_DATE');">
          &emsp;<button class="btn btn-success font-weight-bold" onclick="refresh();"><i class="fa fa-refresh"></i></button>&emsp;
          <form method="post">
            <input type="submit" class="btn btn-success" name="export" value="Export ">
          </form>
        </div>

        <div class="col col-md-12">
          <hr class="col-md-12" style="padding: 0px; border-top: 2px solid  #02b6ff;">
        </div>


        <div class="col col-md-12 table-responsive">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>SL.</th>
                  <th>Invoice No</th>
                  <th>Customer Name</th>
                  <th>Reffered By</th>
                  <th>Date</th>
                  <th>Total Amount</th>
                  <th>Total Tax</th>
                  <th>SGST</th>
                  <th>CGST</th>
                  <th>Net Total</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="invoices_div">
                <?php
                require 'php/manage_invoice.php';
                showInvoices();
                ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
      <!-- form content end -->
      <hr style="border-top: 2px solid #027ba3;">
    </div>
  </div>
</body>

</html>