<?php
  require "db_connection.php";

  if($con) {
    if(isset($_GET["action"]) && $_GET["action"] == "delete") {
      $id = $_GET["id"];
      $query = "DELETE FROM purchases WHERE VOUCHER_NUMBER = $id";
      $result = mysqli_query($con, $query);
      if(!empty($result))
    		showPurchases(0);
    }

    if(isset($_GET["action"]) && $_GET["action"] == "print_purchase")
    printPurchase($_GET["invoice_number"]);


    if(isset($_GET["action"]) && $_GET["action"] == "edit") {
      $id = $_GET["id"];
      showPurchases($id);
    }

    if(isset($_GET["action"]) && $_GET["action"] == "update") {
      $id = $_GET["id"];
      $suppliers_name = ucwords($_GET["suppliers_name"]);
      $invoice_date = $_GET["invoice_date"];
      $grand_total = $_GET["grand_total"];
      $payment_status = $_GET["payment_status"];
      updatePurchase($id, $suppliers_name, $invoice_date, $grand_total, $payment_status);
    }

    if(isset($_GET["action"]) && $_GET["action"] == "cancel")
      showPurchases(0);

    if(isset($_GET["action"]) && $_GET["action"] == "search")
      searchPurchase(strtoupper($_GET["text"]), $_GET["tag"]);
  }

  function showPurchases($id) {
    require "db_connection.php";
    if($con) {
      $seq_no = 0;
      $query = "SELECT * FROM purchases";
      $result = mysqli_query($con, $query);
      while($row = mysqli_fetch_array($result)) {
        $seq_no++;
        if($row['VOUCHER_NUMBER'] == $id)
          showEditOptionsRow($seq_no, $row);
        else
          showPurchaseRow($seq_no, $row);
      }
    }
  }

  function showPurchaseRow($seq_no, $row) {
    ?>
    <tr>
      <td><?php echo $seq_no; ?></td>
      <td><?php echo $row['VOUCHER_NUMBER']; ?></td>
      <td><?php echo $row['SUPPLIER_NAME'] ?></td>
      <td><?php echo $row['INVOICE_NUMBER']; ?></td>
      <td><?php echo $row['PURCHASE_DATE']; ?></td>
      <td><?php echo $row['TOTAL_AMOUNT']; ?></td>
      <td><?php echo $row['PAYMENT_STATUS']; ?></td>
      <td>
        <button class="btn btn-warning btn-sm" onclick="printSinglePurchase(<?php echo $row['INVOICE_NUMBER']; ?>);">
          <i class="fa fa-fax"></i>
        </button>
        <button href="" class="btn btn-info btn-sm" onclick="editPurchase(<?php echo $row['VOUCHER_NUMBER']; ?>);">
          <i class="fa fa-pencil"></i>
        </button>
        <button class="btn btn-danger btn-sm" onclick="deletePurchase(<?php echo $row['VOUCHER_NUMBER']; ?>);">
          <i class="fa fa-trash"></i>
        </button>
      </td>
    </tr>
    <?php
  }

function showEditOptionsRow($seq_no, $row) {
  ?>
  <tr>
    <td><?php echo $seq_no; ?></td>
    <td><?php echo $row['VOUCHER_NUMBER'] ?></td>
    <td>
      <input id="suppliers_name" type="text" class="form-control" value="<?php echo $row['SUPPLIER_NAME']; ?>" placeholder="Supplier Name" name="suppliers_name" onkeyup="showSuggestions(this.value, 'supplier');" disabled>
      <!--<code class="text-danger small font-weight-bold float-right" id="supplier_name_error" style="display: none;"></code>
      <div id="supplier_suggestions" class="list-group position-fixed" style="z-index: 1; width: 25.10%; overflow: auto; max-height: 200px;"></div>-->
    </td>
    <td>
      <input type="number" class="form-control" value="<?php echo $row['INVOICE_NUMBER']; ?>" id="invoice_number" disabled>
    </td>
    <td>
      <input type="date" class="datepicker form-control hasDatepicker" id="invoice_date" name="invoice_date" value='<?php echo $row['PURCHASE_DATE'] ?>' onblur="checkDate(this.value, 'date_error');">
      <code class="text-danger small font-weight-bold float-right" id="date_error" style="display: none;"></code>
    </td>
    <td><input type="text" class="form-control" value="<?php echo $row['TOTAL_AMOUNT']; ?>" id="grand_total" name="grand_total" disabled></td>
    <td>
      <select id="payment_status" class="form-control">
        <option value="DUE" <?php if($row['PAYMENT_STATUS'] == "DUE") echo "selected" ?>>DUE</option>
        <option value="PAID" <?php if($row['PAYMENT_STATUS'] == "PAID") echo "selected" ?>>PAID</option>
      </select>
    </td>
    <td>
      <button href="" class="btn btn-success btn-sm" onclick="updatePurchase(<?php echo $row['VOUCHER_NUMBER']; ?>);">
        <i class="fa fa-edit"></i>
      </button>
      <button class="btn btn-danger btn-sm" onclick="cancel();">
        <i class="fa fa-close"></i>
      </button>
    </td>
  </tr>
  <?php
}

function updatePurchase($id, $suppliers_name, $invoice_date, $grand_total, $payment_status) {
  require "db_connection.php";
  //echo $payment_status;
  $query = "UPDATE purchases SET SUPPLIER_NAME = '$suppliers_name', PURCHASE_DATE = '$invoice_date', TOTAL_AMOUNT = $grand_total, PAYMENT_STATUS = '$payment_status' WHERE VOUCHER_NUMBER = $id";
  $result = mysqli_query($con, $query);
  if(!empty($result))
    showPurchases(0);
}

function searchPurchase($text, $column) {
  require "db_connection.php";
  if($con) {
    $seq_no = 0;
    $query = "SELECT * FROM purchases WHERE $column LIKE '%$text%'";
    $result = mysqli_query($con, $query);
    while($row = mysqli_fetch_array($result)) {
      $seq_no++;
      showPurchaseRow($seq_no, $row);
    }
  }
}

function AmountInWords(float $amount)
{
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
      $get_divider = ($x == 2) ? 10 : 100;
      $amount = floor($num % $get_divider);
      $num = floor($num / $get_divider);
      $x += $get_divider == 10 ? 1 : 2;
      if ($amount) {
       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
   return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
}





 function printPurchase($invoice_number) {
    require "db_connection.php";
    if($con) {
      $query = "SELECT * FROM purchases INNER JOIN suppliers ON purchases.SUPPLIER_NAME = suppliers.NAME WHERE INVOICE_NUMBER = $invoice_number";
      $result = mysqli_query($con, $query);
      
      $row = mysqli_fetch_array($result);
     // echo '<pre>';print_r($row);exit;
      $supplier_name = $row['NAME'];
      $address = $row['ADDRESS'];
      $contact_number = $row['CONTACT_NUMBER'];
       $vehicle_number = $row['VEHICLE_NUMBER'];
      $number = $row['NUMBER'];

      $query = "SELECT * FROM purchases WHERE INVOICE_NUMBER = $invoice_number";
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_array($result);
     // echo '<pre>';print_r($row);exit;
      $purchase_date = $row['PURCHASE_DATE'];
      $dateTime = new DateTime($purchase_date);
    $formattedDate = $dateTime->format("d-m-Y");
      $total_amount = $row['TOTAL_AMOUNT'];
      //$total_discount = $row['TOTAL_DISCOUNT'];
      $net_total = $row['TOTAL_AMOUNT'];
      $stax = $row['STAX'];
      $ctax = $row['CTAX'];
    }

    ?>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sidenav.css">
    <link rel="stylesheet" href="css/home.css">
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-10 h3" style="color: #027ba3;">Purchase Invoice<span class="float-right">Invoice Number : <?php echo $invoice_number; ?></span></div>
    </div>
    <div class="row font-weight-bold">
      <div class="col-md-1"></div>
      <div class="col-md-10"><span class="h4 float-right">Purchase Date. : <?php echo $formattedDate; ?></span></div>
    </div>
    <div class="row text-center">
      <hr class="col-md-10" style="padding: 0px; border-top: 2px solid  #027ba3;">
    </div>
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-4">
        <span class="h4">Customer Details : </span><br><br>
        <span class="font-weight-bold">Name : </span><?php echo $supplier_name; ?><br>
        <span class="font-weight-bold">Address : </span><?php echo $address; ?><br>
        <span class="font-weight-bold">Contact Number : </span><?php echo $contact_number; ?><br>
        <span class="font-weight-bold">Vehicle Number : </span><?php echo $vehicle_number; ?><br>
        <span class="font-weight-bold">GST NUMBER : </span><?php echo $number; ?> <br>
      </div>
      <div class="col-md-2"></div>
      <?php

      $query = "SELECT * FROM suppliers";
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_array($result);
      $p_name = $row['NAME'];
      $p_address = $row['ADDRESS'];
      $p_email = $row['EMAIL'];
      $p_contact_number = $row['CONTACT_NUMBER'];
      ?>

      <div class="col-md-4">
        <span class="h4">Sold by : </span><br><br>
        
          <span class="font-weight-bold">GST : 29CMOPR7283N1ZR</span><br>
          <span class="font-weight-bold"> Embossed</span><br>
         


          <span class="font-weight-bold"> Opp KSRTC Bus Depo Bangalore road next </span><br>
        <span class="font-weight-bold">to Shashi Chandra Dental near More</span><br>
         <span class="font-weight-bold"> Super Market Chintamani - 563125</span><br>
        <span class="font-weight-bold">Contact Number : 7892528881 </span><br>
           </span><br>
        
      </div>
      
      <div class="col-md-1"></div>
    </div>
    <div class="row text-center">
      <hr class="col-md-10" style="padding: 0px; border-top: 2px solid  #027ba3;">
    </div>

    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-10 table-responsive">
        <table class="table table-bordered table-striped table-hover" id="purchase_report_div">
          <thead>
            <tr>
              <th>SL</th>
              <th>Item Name</th>
              <th>HSN No</th>
              <th>Per</th>
              <th>Quantity</th>
              <th>MRP</th>
              <th>Tax</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $seq_no = 0;
              $total = 0;
              $t=0;
              $query = "SELECT * FROM medicines_stock WHERE INVOICE_NUMBER = $invoice_number";
              $result = mysqli_query($con, $query);
              while($row = mysqli_fetch_array($result)) {
                $seq_no++;
                ?>
                <tr>
                  <td><?php echo $seq_no; ?></td>
                  <td><?php echo $row['NAME']; ?></td>
                  <td><?php echo $row['BATCH_ID']; ?></td>
                  <td><?php echo $row['PER']; ?></td>
                  <td><?php echo $row['QUANTITY']; ?></td>
                  <td><?php echo $row['RATE']; ?></td>
                  <td><?php echo $row['DISCOUNT']."%"; ?></td>
                  <td><?php echo $row['QUANTITY'] * $row['RATE']; ?></td>
                </tr>


                <?php $t += ($row['QUANTITY'] * $row['RATE']);
                      
              }
            ?>
          </tbody>
          <tfoot class="font-weight-bold">
            <tr style="text-align: right; font-size: 18px;">
              <td colspan="7">&nbsp;Total Amount</td>
              <td>₹ <?php echo ceil($t); ?>.00</td>
            </tr>
            <tr style="text-align: right; font-size: 18px;">
              <td colspan="7">&nbsp;SGST</td>
              <td>₹ <?php echo $stax; ?>.00</td>
            </tr>
            <tr style="text-align: right; font-size: 18px;">
              <td colspan="7">&nbsp;CGST</td>
              <td>₹ <?php echo $ctax; ?>.00</td>
            </tr> 
            <tr style="text-align: right; font-size: 22px;">
              <td colspan="7" >&nbsp;Net Amount</td>

              <td >₹ <?php echo ceil($t+$ctax+$stax); ?>.00</td>

            </tr>
            <tr>
              <td colspan="5">&nbsp;Net Amount in Words: </td>
              <td colspan="5"> <?php $amount_words = AmountInWords(ceil($t+$ctax+$stax)); echo $amount_words.' Only'; ?></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="col-md-1"></div>
    </div>
    <div class="row text-center">
      <hr class="col-md-10" style="padding: 0px; border-top: 2px solid  #027ba3;">
    </div>
    <?php
  }

?>
