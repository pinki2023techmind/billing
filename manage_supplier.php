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
        $email = $spreadSheetAry[$i][1];
        $contactNumber = $spreadSheetAry[$i][2];
        $address = $spreadSheetAry[$i][3];
        $vehicleNumber = $spreadSheetAry[$i][4];
        $gstNumber = $spreadSheetAry[$i][5];
        // 
        $result = mysqli_query($con, "SELECT * FROM suppliers WHERE NAME = '$name'");
        $existingRecord = mysqli_fetch_assoc($result);
        if ($existingRecord) {
          $sql = "UPDATE suppliers SET
                        EMAIL = '$email',
                        CONTACT_NUMBER = '$contactNumber',
                        ADDRESS = '$address',
                        VEHICLE_NUMBER = '$vehicleNumber',
                        GST_NUMBER = '$gstNumber'
                        WHERE NAME = '$name'";
        } else {
          $sql = "insert into suppliers (NAME,EMAIL,CONTACT_NUMBER,ADDRESS,VEHICLE_NUMBER,GST_NUMBER) values ('" . $spreadSheetAry[$i][0] . "','" . $spreadSheetAry[$i][1] . "','" . $spreadSheetAry[$i][2] . "','" . $spreadSheetAry[$i][3] . "','" . $spreadSheetAry[$i][4] . "','" . $spreadSheetAry[$i][5] . "')";
        }
        if (!mysqli_query($con, $sql)) {
          $_SESSION['error_message'] = "Error importing data: " . mysqli_error($con);
          header("Location: manage_supplier.php");
          exit();
        }
      }
    }

    $_SESSION['success_message'] = "Data imported successfully!";
    header("Location: manage_supplier.php");
    exit();
  } else {
    $_SESSION['error_message'] = "Invalid file type. Please upload only Excel file.";
    header("Location: manage_supplier.php");
    exit();
  }
}

$sql = "SELECT * FROM suppliers";
if ($con) {
  $result = mysqli_query($con, $sql);
  $finaldata = array();
  while ($data = mysqli_fetch_assoc($result)) {
    $finaldata[] = $data;
  }

  if (isset($_POST['export'])) {
    $filename = "Suppliers" . date('Ymdhis') . ".xls";
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
  <title>Manage Supplier</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/sidenav.css">
  <link rel="stylesheet" href="css/home.css">
  <script src="js/manage_supplier.js"></script>
  <script src="js/validateForm.js"></script>
  <script src="js/restrict.js"></script>
</head>

<body>

<div id="add_new_supplier_model" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #027ba3; color: white">
          <div class="font-weight-bold">Add New Supplier</div>
          <button class="close" style="outline: none;" onclick="document.getElementById('add_new_supplier_model').style.display = 'none';"><i class="fa fa-close"></i></button>
        </div>
        <div class="modal-body" style="position: relative; height: 33rem; overflow:scroll">
          <?php
          include('sections/add_new_supplier.html');
          ?>
        </div>
      </div>
    </div>
  </div>

  <!-- including side navigations -->
  <?php include("sections/sidenav.html"); ?>

  <div class="container-fluid">
    <div class="container">

      <!-- header section -->
      <?php
      require "php/header.php";
      createHeader('group', 'Manage Supplier', 'Manage Existing Supplier');
      ?>
      <!-- header section end -->

      <!-- form content -->
      <div class="row">
        <div class="col-md-6 form-group form-inline">
          <label class="font-weight-bold" for="">Search&nbsp;</label>
          <input type="text" class="form-control" id="" placeholder="Search Supplier" onkeyup="searchSupplier(this.value,'NAME');">&nbsp;
          <input type="number" class="form-control" id="" placeholder="Contact Number" onkeyup="searchSupplier(this.value,'CONTACT_NUMBER');">
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
            <a href="sample_supplier.xlsx" download>Download Sample File</a>
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
              onclick="document.getElementById('add_new_supplier_model').style.display = 'block';" 
              class="btn btn-success font-weight-bold" name="add" >+ Add</button>
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
                  <th style="width: 5%;">SL</th>
                  <th style="width: 10%;">ID</th>
                  <th style="width: 20%;">Name</th>
                  <th style="width: 15%;">Email</th>
                  <th style="width: 15%;">Contact Number</th>
                  <th style="width: 20%;">Address</th>
                  <th style="width: 15%;">Action</th>
                </tr>
              </thead>
              <tbody id="suppliers_div">
                <?php
                require 'php/manage_supplier.php';
                showSuppliers(0);
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