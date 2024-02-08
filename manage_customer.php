<?php
include("php/db_connection.php");

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

require_once('vendor/autoload.php');
session_start();
if (isset($_POST['import'])) {
  $allowedFileTypes = [];
  if ($_FILES["exceldata"]['size'] > 0) {
    $allowedFileTypes = [
      'application/vnd.ms-excel',
      'text/xls',
      'text/xlsx',
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];
  }

  if (in_array($_FILES["exceldata"]["type"], $allowedFileTypes)) {
    $filename = $_FILES['exceldata']['name'];
    $tempname = $_FILES['exceldata']['tmp_name'];
    move_uploaded_file($tempname, 'uploads/' . $filename);

    $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $spreadSheet = $Reader->load('uploads/' . $filename);
    $excelSheet = $spreadSheet->getActiveSheet();
    $spreadSheetAry = $excelSheet->toArray();
    $sheetCount = count($spreadSheetAry);

    for ($i = 1; $i < $sheetCount; $i++) {
      if ($con) {
        $name = $spreadSheetAry[$i][0];
        $contactNumber = $spreadSheetAry[$i][1];
        $address = $spreadSheetAry[$i][2];
        $state = $spreadSheetAry[$i][3];
        $country = $spreadSheetAry[$i][4];
        $vehicleNumber = $spreadSheetAry[$i][5];
        $gstNumber = $spreadSheetAry[$i][6];
        // 
        $result = mysqli_query($con, "SELECT * FROM customers WHERE CONTACT_NUMBER = '$contactNumber'");
        $existingRecord = mysqli_fetch_assoc($result);
        if ($existingRecord) {
          $sql = "UPDATE customers SET
                        NAME = '$name',
                        ADDRESS = '$address',
                        STATE = '$state',
                        COUNTRY = '$country',
                        VEHICLE_NUMBER = '$vehicleNumber',
                        GST_NUMBER = '$gstNumber'
                        WHERE CONTACT_NUMBER = '$contactNumber'";
        } else {
          $sql = "insert into customers (NAME,CONTACT_NUMBER,ADDRESS,STATE,COUNTRY,GST_NUMBER) 
          values ('" . $spreadSheetAry[$i][0] . "','" . $spreadSheetAry[$i][1] . "','" . $spreadSheetAry[$i][2] . "','" . $spreadSheetAry[$i][3] . "','" . $spreadSheetAry[$i][4] . "','" . $spreadSheetAry[$i][5] . "','" . $spreadSheetAry[$i][6] . "')";
        }
        // $sql = "insert into customers (NAME,CONTACT_NUMBER,ADDRESS,,GST_NUMBER) values ('" . $spreadSheetAry[$i][0] . "','" . $spreadSheetAry[$i][1] . "','" . $spreadSheetAry[$i][2] . "','" . $spreadSheetAry[$i][3] . "','" . $spreadSheetAry[$i][4] . "')";
        if (!mysqli_query($con, $sql)) {
          $_SESSION['error_message'] = "Error importing data: " . mysqli_error($con);
          header("Location: manage_customer.php");
          exit();
        }
      }
    }

    $_SESSION['success_message'] = "Data imported successfully!";
    header("Location: manage_customer.php");
    exit();
  } else {
    $_SESSION['error_message'] = "Invalid file type. Please upload only Excel file.";
    header("Location: manage_customer.php");
    exit();
  }
}



$sql = "SELECT * FROM customers";
if ($con) {
  $result = mysqli_query($con, $sql);
  $finaldata = array();
  while ($data = mysqli_fetch_assoc($result)) {
    $finaldata[] = $data;
  }

  if (isset($_POST['export'])) {
    $filename = "Customers" . date('Ymdhis') . ".xls";
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
  <title>Manage Customer</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <link rel="shortcut icon" href="" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/sidenav.css">
  <link rel="stylesheet" href="css/home.css">
  <script src="js/manage_customer.js"></script>
  <script src="js/validateForm.js"></script>
  <script src="js/restrict.js"></script>
</head>

<body style="max-height: 100%;">
  <!-- including side navigations -->


  <div id="add_new_customer_model">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #027ba3; color: white">
          <div class="font-weight-bold">Add New Customer</div>
          <button class="close" style="outline: none;" onclick="document.getElementById('add_new_customer_model').style.display = 'none';"><i class="fa fa-close"></i></button>
        </div>
        <div class="modal-body" style="position: relative; height: 33rem; overflow:scroll">
        <?php         

          // Display error message if set
          // Display success message if set
          if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
          } else  if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
          }
          ?>
          <form method="post" id="importForm" enctype="multipart/form-data">&emsp;
            <a href="sample_customers.xlsx" download>Download Sample File</a>&emsp;
            <button type="button" class="btn btn-success font-weight-bold" onclick="document.getElementById('fileInput').click();">Import </button>
            <input type="file" name="exceldata" accept=".xlsx, .xls" id="fileInput" style="display:none;">
            <input type="submit" name="import" value="Import to Excel" class="btn btn-success font-weight-bold" id="importButton" style="display:none;">
          </form>
          <?php
          // form content
          require "sections/add_new_customer.html";
          ?>
        </div>
      </div>
    </div>
  </div>
  <?php include("sections/sidenav.html"); ?>

  

  <div class="container-fluid">
    <div class="container">

      <!-- header section -->
      <?php
      require "php/header.php";
      createHeader('handshake', 'Manage Customer', 'Manage Existing Customer');
      ?>
      <!-- header section end -->

      <!-- form content -->
      <div class="row">

        <div class="col-md-6 form-group form-inline">
          <label class="font-weight-bold" for="">Search&nbsp;</label>
          <input type="text" class="form-control" id="" placeholder="Search Customer" onkeyup="searchCustomer(this.value,'NAME');">&nbsp;
          <input type="text" class="form-control" id="" placeholder="Search Contact Number" onkeyup="searchCustomer(this.value,'CONTACT_NUMBER');">
        </div>
        <div class="col-md-6 form-group form-inline">
          <?php
          session_start();
          // Display error message if set
          // Display success message if set
          if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
          } else  if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
          }
          ?>
          <form method="post" id="importForm" enctype="multipart/form-data">
            <a href="sample_customers.xlsx" download>Download Sample File</a>
            <button type="button" class="btn btn-success font-weight-bold" onclick="document.getElementById('fileInput').click();">Import </button>
            <input type="file" name="exceldata" accept=".xlsx, .xls" id="fileInput" style="display:none;">
            <input type="submit" name="import" value="Import to Excel" class="btn btn-success font-weight-bold" id="importButton" style="display:none;">
          </form>
          &emsp;
          <form method="post">
            <input type="submit" class="btn btn-success font-weight-bold" name="export" value="Export">
          </form>
           <div style="padding-left:20px"> 
            <button type="submit"  style="cursor:pointer"
              onclick="document.getElementById('add_new_customer_model').style.display = 'block';" 
              class="btn btn-success font-weight-bold" name="add" >+ Add</button>
          </div>
          <div class="modal-body">
          <?php
          include('sections/add_customer.html');
          ?>
        </div>
        </div>
         
        <div class="col col-md-12">
          <hr class="col-md-12" style="padding: 0px; border-top: 2px solid  #02b6ff;">
        </div>

        <div class="col col-md-12 table-responsive">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th style="width: 2%;">SL.</th>
                  <th style="width: 10%;">Customer ID</th>
                  <th style="width: 13%;">Customer Name</th>
                  <th style="width: 13%;">Contact Number</th>
                  <th style="width: 17%;">Address</th>
                 <th style="width: 13%;">State</th>
                    <th style="width: 17%;">Country</th>
                  <th style="width: 15%;">Action</th>
                </tr>
              </thead>
              <tbody id="customers_div">
                <?php
                require 'php/manage_customer.php';
                showCustomers(0);
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
  <script>
    document.getElementById('fileInput').addEventListener('change', function() {
      document.getElementById('importButton').click();
    });
  </script>
</body>

</html>