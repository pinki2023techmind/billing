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
          header("Location: add_supplier.php");
          exit();
        }
      }
    }

    $_SESSION['success_message'] = "Data imported successfully!";
    header("Location: add_supplier.php");
    exit();
  } else {
    $_SESSION['error_message'] = "Invalid file type. Please upload only Excel file.";
    header("Location: add_supplier.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Add New Supplier</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/sidenav.css">
  <link rel="stylesheet" href="css/home.css">
  <script src="js/validateForm.js"></script>
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
      createHeader('group', 'Add Supplier', 'Add New Supplier');
      // header section end
      ?>
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
            <a href="sample_supplier.xlsx" download>Download Sample File</a>&emsp;
            <button type="button" class="btn btn-success font-weight-bold" onclick="document.getElementById('fileInput').click();">Import </button>
            <input type="file" name="exceldata" accept=".xlsx, .xls" id="fileInput" style="display:none;">
            <input type="submit" name="import" value="Import to Excel" class="btn btn-success font-weight-bold" id="importButton" style="display:none;">
          </form>
          <?php
          // form content
          require "sections/add_new_supplier.html";
          ?>
        </div>
      </div>
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