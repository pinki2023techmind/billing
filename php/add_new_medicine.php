<?php
require "db_connection.php";
if ($con) {

  $name = ucwords($_GET["name"]);
  $packing = strtoupper($_GET["packing"]);
  $generic_name = ucwords($_GET["generic_name"]);
  $suppliers_name = $_GET["suppliers_name"];

  $hsn_no = $_GET["hsn_no"];
  $avail_qty = $_GET['avail_qty'];
  $mrp = $_GET['mrp'];
  $item_discount = $_GET['item_discount'];

  $query = "SELECT * FROM medicines WHERE UPPER(NAME) = '" . strtoupper($name) . "' AND UPPER(PACKING) = '" . strtoupper($packing) . "' AND UPPER(SUPPLIER_NAME) = '" . strtoupper($suppliers_name) . "'";
  $result = mysqli_query($con, $query);
  $row = mysqli_fetch_array($result);
  if ($row)
    echo "Medicine $name with $packing already exists by supplier $suppliers_name!";
  else {
    $query = "INSERT INTO medicines (NAME, PACKING, SUPPLIER_NAME) VALUES('$name', '$packing', '$suppliers_name')";
    if ($hsn_no != "" && $mrp != "" && $avail_qty != "" && $item_discount != "") {
      $query_stock = "INSERT INTO medicines_stock (NAME, BATCH_ID, QUANTITY,MRP,DISCOUNT) VALUES('$name', '$hsn_no','$avail_qty','$mrp',$item_discount)";
      // echo print_r($query_stock);exit;
      $result2 = mysqli_query($con, $query_stock);
    }
    $result = mysqli_query($con, $query);

    if (!empty($result))
      echo "$name added...";
    else
      echo "Failed to add $name!";
  }
}
