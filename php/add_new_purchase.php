<?php

  if(isset($_GET['action']) && $_GET['action'] == "add_row")
    createMedicineInfoRow();

  if(isset($_GET['action']) && $_GET['action'] == "is_supplier")
    isSupplier(strtoupper($_GET['name']));

  if(isset($_GET['action']) && $_GET['action'] == "is_invoice")
    isInvoiceExist(strtoupper($_GET['invoice_number']));

  if(isset($_GET['action']) && $_GET['action'] == "is_new_medicine")
    isNewMedicine(strtoupper($_GET['name']), strtoupper($_GET['packing']));

  if(isset($_GET['action']) && $_GET['action'] == "add_stock")
    addStock();

  if(isset($_GET['action']) && $_GET['action'] == "add_new_purchase")
    addNewPurchase();

  if(isset($_GET['action']) && $_GET['action'] == "vehicles_number")
      getValue($_GET['action'], "VEHICLE_NUMBER");

    if(isset($_GET['action']) && $_GET['action'] == "gsts_number")
      getValue($_GET['action'], "GST_NUMBER");

  function isSupplier($name) {
    require "db_connection.php";
    if($con) {
      $query = "SELECT * FROM suppliers WHERE UPPER(NAME) = '$name'";
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_array($result);
      echo ($row) ? "true" : "false";
    }
  }

  function isInvoiceExist($invoice_number) {
    require "db_connection.php";
    if($con) {
      $query = "SELECT * FROM purchases WHERE INVOICE_NUMBER = $invoice_number";
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_array($result);
      echo ($row) ? "true" : "false";
    }
  }

  function isNewMedicine($name, $packing) {
    // echo $name;
    // echo $packing;exit;
    require "db_connection.php";
    if($con) {
      $query = "SELECT * FROM medicines WHERE UPPER(NAME) = '$name' AND UPPER(PACKING) = '$packing'";
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_array($result);
      echo ($row) ? "false" : "true";
    }
  }

  function addStock() {
    require "db_connection.php";
  //  echo '<pre>';print_r($_GET);exit;
    $name = ucwords($_GET['name']);
    $batch_id = strtoupper($_GET['batch_id']);
   // $expiry_date = $_GET['expiry_date'];
    $per = $_GET['per'];
    $quantity = $_GET['quantity'];
    $mrp = $_GET['mrp'];
    $rate = $_GET['rate'];
    $discount = $_GET['discount'];
    $tax = $_GET['tax'];
    $invoice_number = $_GET['invoice_number'];
    if($con) {
      $query = "SELECT * FROM medicines_stock WHERE UPPER(NAME) = '".strtoupper($name)."' AND UPPER(BATCH_ID) = '$batch_id'";
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_array($result);
    // echo '<pre>';print_r($result);
      if($row) {
        //echo "update medicines Stock";exit;
        $new_quantity = $row['QUANTITY'] + $quantity;
        $query = "UPDATE medicines_stock SET QUANTITY = $new_quantity WHERE UPPER(NAME) = '".strtoupper($name)."' AND UPPER(BATCH_ID) = '$batch_id'";
        $result = mysqli_query($con, $query);
      }
      else {
       // echo $name; echo $batch_id;
        $query = "INSERT INTO medicines_stock (NAME, BATCH_ID,PER, AVAIL_QTY, QUANTITY, MRP, RATE,DISCOUNT,TAX, INVOICE_NUMBER) VALUES('$name', '$batch_id','$per', '$quantity', $quantity,   $mrp, $rate,$discount,$tax, $invoice_number)";
    // echo '<pre>';print_r($query);
        $result = mysqli_query($con, $query);
         
         
      }
    }
  }

  function getValue($action, $column) {
require "db_connection.php";
    $name = $_GET['name'];
    $query = "SELECT * FROM suppliers WHERE NAME = '$name'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
      //echo '<pre>';print_r($row);exit;
      echo $row[$column];exit;
  }




  function addNewPurchase() {
    //echo "adsaddd";
    require "db_connection.php";
    $suppliers_name = ucwords($_GET['suppliers_name']);
    $invoice_number = $_GET['invoice_number'];
    $payment_type = $_GET['payment_type'];
    $invoice_date = $_GET['invoice_date'];
    $grand_total = $_GET['grand_total'];
    $voucher_number = $_GET['voucher_number'];
    $total_amount = $_GET['total_amount'];
    $stax = $_GET['stax'];
    $ctax = $_GET['ctax'];

    $payment_status = ($payment_type == "Payment Due") ? "DUE" : "PAID";
    //echo $grand_total;
    if($con) {
      $query = "INSERT INTO purchases (SUPPLIER_NAME, INVOICE_NUMBER, VOUCHER_NUMBER, PURCHASE_DATE, TOTAL_AMOUNT,GRAND_TOTAL, PAYMENT_STATUS,STAX,CTAX) VALUES('$suppliers_name', $invoice_number, '$voucher_number', '$invoice_date', $total_amount, $grand_total,'$payment_status','$stax','$ctax')";
      $result = mysqli_query($con, $query);
      // $row = mysqli_fetch_array($result);  
      //echo '<pre>';print_r($result);exit;
      if($result)
        echo "Purchase saved...";
      else
        echo "Failed to save purchase!";
    }
  }

  function createMedicineInfoRow() {
      $row_id = $_GET['row_id'];
      $row_number = $_GET['row_number'];
      ?>
      <div class="row col col-md-12">
        <div class="col col-md-2">
          <input type="text" class="form-control" placeholder="Item Name" name="medicine_name">
          <code class="text-danger small font-weight-bold float-right" id="medicine_name_error_<?php echo $row_number; ?>" style="display: none;"></code>
        </div>
        <div class="col col-md-1">
          <input type="text" class="form-control" name="packing">
          <code class="text-danger small font-weight-bold float-right" id="pack_error_<?php echo $row_number; ?>" style="display: none;"></code>
        </div>
        <div class="col col-md-1">
          <input type="text" class="form-control" name="batch_id">
          <code class="text-danger small font-weight-bold float-right" id="batch_id_error_<?php echo $row_number; ?>" style="display: none;"></code>
        </div>
       
        <div class="col col-md-1">
          <input type="number" class="form-control" id="quantity_<?php echo $row_number; ?>" value="0" name="quantity" onkeyup="getAmount(<?php echo $row_number; ?>);">
          <code class="text-danger small font-weight-bold float-right" id="quantity_error_<?php echo $row_number; ?>" style="display: none;"></code>
        </div> 


         <div class="col col-md-1" >
          <input type="text" class="form-control"  name="per" id="per_<?php echo $row_number;?>">
          <code class="text-danger small font-weight-bold float-right" id="per_error_<?php echo $row_number; ?>" style="display: none;"></code>
        </div>
         <!--  <div class="col col-md-1">
            <input type="text" class="form-control"  name="per" id="per">
            <code class="text-danger small font-weight-bold float-right" id="per_error_<?php echo $row_number; ?>" style="display: none;"></code>
          </div> -->



        <div class="col col-md-1">
          <input type="number" class="form-control" name="mrp">
          <code class="text-danger small font-weight-bold float-right" id="mrp_error_<?php echo $row_number; ?>" style="display: none;"></code>
        </div>
        <div class="col col-md-1">
          <input type="number" class="form-control" id="rate_<?php echo $row_number; ?>" name="rate" onkeyup="getAmount(<?php echo $row_number; ?>);">
          <code class="text-danger small font-weight-bold float-right" id="rate_error_<?php echo $row_number; ?>" style="display: none;"></code>
        </div>

       
        
        <!-- <div class="row col col-md-3"> -->
          <div class="col col-md-1">
            <input type="text" class="form-control" id="amount_<?php echo $row_number; ?>" disabled>
          </div>
          <!-- <div class="col col-md-1">
            <input type="text" class="form-control" id="discount_<?php echo $row_number; ?>" >
          </div> -->
           <!-- <div class="col col-md-1">
            <input type="number" class="form-control" id="discount_<?php echo $row_number; ?>" value="0" name="discount" onkeyup="getAmount('<?php echo $row_number; ?>');">
            <code class="text-danger small font-weight-bold float-right" id="discount_error_<?php echo $row_number; ?>" style="display: none;"></code>
           </div> -->

           <div class="col col-md-1">
            <input type="number" class="form-control" id="tax_<?php echo $row_number; ?>" value="0" name="tax" onkeyup="getAmount('<?php echo $row_number; ?>');">
            <code class="text-danger small font-weight-bold float-right" id="tax_error_<?php echo $row_number; ?>" style="display: none;"></code>
           </div>
           <div class="col col-md-1">
            <input type="number" class="form-control" id="total_row_<?php echo $row_number; ?>" value="0" name="total_row" onkeyup="getAmount('<?php echo $row_number; ?>');">
            <code class="text-danger small font-weight-bold float-right" id="total_row_error_<?php echo $row_number; ?>" style="display: none;"></code>
           </div>
          <div class="col col-md-1" style="display:flex">
            <button class="btn btn-primary" onclick="addRow();">
              <i class="fa fa-plus"></i>
            </button>
            <button class="btn btn-danger" onclick="removeRow('<?php echo $row_id ?>');">
              <i class="fa fa-trash"></i>
            </button>
          </div>
        </div>
      </div><br>
      <div class="row col col-md-8">
        <div class="col col-md-4">
          <label for="generic_name" class="font-weight-bold"></label>
        </div>
        <div class="col col-md-8">
          <input type="hidden" class="form-control" placeholder="Generic Name" name="generic_name" value="ABC">
          <code class="text-danger small font-weight-bold float-right" id="generic_name_error_<?php echo $row_number; ?>" style="display: none;"></code>
        </div>
     <!--  </div> -->
      <div class="col col-md-12">
        <hr class="col-md-12" style="padding: 0px;">
      </div>
      <?php
  }
?>
