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
        $packing = $spreadSheetAry[$i][1];
        $generic_name = $spreadSheetAry[$i][2];
        $supplier_name = $spreadSheetAry[$i][3];
        $batch_id = $spreadSheetAry[$i][4];
        $per = $spreadSheetAry[$i][5];
        $avail_qty = $spreadSheetAry[$i][6];
        $quantity = $spreadSheetAry[$i][7];
        $mrp = $spreadSheetAry[$i][8];
        $rate = $spreadSheetAry[$i][9];
        $discount = $spreadSheetAry[$i][10];
        $tax = $spreadSheetAry[$i][11];
        $invoice_number = $spreadSheetAry[$i][12];

        $result = mysqli_query($con, "SELECT * FROM medicines WHERE NAME = '$name' AND PACKING = '$packing' AND SUPPLIER_NAME = '$supplier_name'");
        $existingRecord = mysqli_fetch_assoc($result);
        if ($existingRecord) {
          print_r($existingRecord);
          $sql1 = "UPDATE medicines SET
          PACKING = '$packing',
          GENERIC_NAME = '$generic_name',
          SUPPLIER_NAME = '$supplier_name'
          WHERE NAME = '$name' AND PACKING = '$packing' AND SUPPLIER_NAME = '$supplier_name'";

          $sql2 = "UPDATE medicines_stock SET
          BATCH_ID = '$batch_id',
          PER = '$per',
          AVAIL_QTY = '$avail_qty',
          QUANTITY = '$quantity',
          MRP = '$mrp',
          RATE = '$rate',
          DISCOUNT = '$discount',
          TAX = '$tax',
          INVOICE_NUMBER = '$invoice_number'
          WHERE NAME = '$name'";
        } else {
          $sql1 = "insert into medicines (NAME,PACKING,GENERIC_NAME,SUPPLIER_NAME) values ('" . $spreadSheetAry[$i][0] . "','" . $spreadSheetAry[$i][1] . "','" . $spreadSheetAry[$i][2] . "','" . $spreadSheetAry[$i][3] . "')";
          $sql2 = "insert into medicines_stock (NAME,BATCH_ID,PER,AVAIL_QTY,QUANTITY,MRP,RATE,DISCOUNT,TAX,INVOICE_NUMBER) values ('" . $spreadSheetAry[$i][0] . "','" . $spreadSheetAry[$i][4] . "','" . $spreadSheetAry[$i][5] . "','" . $spreadSheetAry[$i][6] . "','" . $spreadSheetAry[$i][7] . "','" . $spreadSheetAry[$i][8] . "','" . $spreadSheetAry[$i][9] . "','" . $spreadSheetAry[$i][10] . "','" . $spreadSheetAry[$i][11] . "','" . $spreadSheetAry[$i][12] . "')";
        }

        if (!mysqli_query($con, $sql1) || !mysqli_query($con, $sql2)) {
          $_SESSION['error_message'] = "Error importing data: " . mysqli_error($con);
          header("Location: add_medicine.php");
          exit();
        }
      }
    }

    $_SESSION['success_message'] = "Data imported successfully!";
    header("Location: add_medicine.php");
    exit();
  } else {
    $_SESSION['error_message'] = "Invalid file type. Please upload only Excel file.";
    header("Location: add_medicine.php");
    exit();
  }
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Add New Item</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/sidenav.css">
  <link rel="stylesheet" href="css/home.css">
  <script src="js/suggestions.js"></script>
  <script src="js/validateForm.js"></script>
  <script src="js/restrict.js"></script>
</head>

<body>
  <div id="add_new_supplier_model">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #027ba3; color: white">
          <div class="font-weight-bold">Add New Supplier</div>
          <button class="close" style="outline: none;" onclick="document.getElementById('add_new_supplier_model').style.display = 'none';"><i class="fa fa-close"></i></button>
        </div>
        <div class="modal-body">
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
      createHeader('shopping-bag', 'Add Item', 'Add New Item');
      ?>
      <!-- header section end -->

      <!-- form content -->
      <div class="row">
        <div class="row col col-md-6">&emsp;
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
          <form method="post" id="importForm" enctype="multipart/form-data">&emsp;
            <a href="sample_item.xlsx" download>Download Sample File</a>&emsp;
            <button type="button" class="btn btn-success font-weight-bold" onclick="document.getElementById('fileInput').click();">Import </button>
            <input type="file" name="exceldata" accept=".xlsx, .xls" id="fileInput" style="display:none;">
            <input type="submit" name="import" value="Import to Excel" class="btn btn-success font-weight-bold" id="importButton" style="display:none;">
          </form>
          <?php
          // form content
          require "sections/add_new_medicine.html";
          ?>
        </div>
      </div>

      <hr style="border-top: 2px solid #027ba3;">
      <!-- form content end -->
    </div>
  </div>
  <script>
    document.getElementById('fileInput').addEventListener('change', function() {
      document.getElementById('importButton').click();
    });
  </script>
</body>

</html>