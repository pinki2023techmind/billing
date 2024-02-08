<?php

  if(isset($_GET["action"]) && $_GET["action"] == "delete") {
    require "db_connection.php";
    $invoice_number = $_GET["invoice_number"];
    $query = "DELETE FROM invoices WHERE INVOICE_ID = $invoice_number";
    $result = mysqli_query($con, $query);
    if(!empty($result))
  		showInvoices();
  }

  if(isset($_GET["action"]) && $_GET["action"] == "refresh")
    showInvoices();

  if(isset($_GET["action"]) && $_GET["action"] == "search")
    searchInvoice(strtoupper($_GET["text"]), $_GET["tag"]);

  if(isset($_GET["action"]) && $_GET["action"] == "print_invoice")
    printInvoice($_GET["invoice_number"]);

  function showInvoices() {
    require "db_connection.php";
    if($con) {
      $seq_no = 0;
      $query = "SELECT * FROM invoices INNER JOIN customers ON invoices.CUSTOMER_ID = customers.ID";
      $result = mysqli_query($con, $query);
      while($row = mysqli_fetch_array($result)) {
        $seq_no++;
       
        showInvoiceRow($seq_no, $row);
      }
    }
  }

  function showInvoiceRow($seq_no, $row) {
    ?>
    <tr>
      <td><?php echo $seq_no; ?></td>
      <td><?php echo convertToPaddedString($row['INVOICE_ID']); ?></td>
      <td><?php echo $row['NAME']; ?></td>
      <td><?php echo $row['REFFERED']; ?></td>
      <td><?php echo $row['INVOICE_DATE']; ?></td>
      <td><?php echo $row['TOTAL_AMOUNT']; ?></td>
      <td><?php echo $row['TOTAL_DISCOUNT']; ?></td>
      <td><?php echo $row['STAX']; ?></td>
      <td><?php echo $row['CTAX']; ?></td>
      <td><?php echo $row['NET_TOTAL']; ?></td>
      <td>
        <button class="btn btn-warning btn-sm" onclick="printInvoice(<?php echo $row['INVOICE_ID']; ?>);">
          <i class="fa fa-fax"></i>
        </button>
        <!--<button class="btn btn-danger btn-sm" onclick="deleteInvoice(<?php echo $row['INVOICE_ID']; ?>);">-->
        <!--  <i class="fa fa-trash"></i>-->
        <!--</button>-->
      </td>
    </tr>
    <?php
  }

  function searchInvoice($text, $column) {
    require "db_connection.php";
    if($con) {
      $seq_no = 0;
      if($column == 'INVOICE_ID')
        $query = "SELECT * FROM invoices INNER JOIN customers ON invoices.CUSTOMER_ID = customers.ID WHERE CAST(invoices.$column AS VARCHAR(9)) LIKE '%$text%'";
      else if($column == "INVOICE_DATE")
        $query = "SELECT * FROM invoices INNER JOIN customers ON invoices.CUSTOMER_ID = customers.ID WHERE invoices.$column = '$text'";
      else
        $query = "SELECT * FROM invoices INNER JOIN customers ON invoices.CUSTOMER_ID = customers.ID WHERE UPPER(customers.$column) LIKE '%$text%'";

      $result = mysqli_query($con, $query);
      while($row = mysqli_fetch_array($result)) {
        $seq_no++;
        showInvoiceRow($seq_no, $row);
      }
    }
  }


// Create a function for converting the amount in words
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




function convertToPaddedString($number, $length = 4) {
    return str_pad($number, $length, '0', STR_PAD_LEFT);
}

  function printInvoice($invoice_number) {
    // echo $invoice_number;
    require "db_connection.php";
    
    if($con) {
      $query = "SELECT * FROM sales INNER JOIN customers ON sales.CUSTOMER_ID = customers.ID WHERE INVOICE_NUMBER = $invoice_number";
      $result = mysqli_query($con, $query);
      
      $row = mysqli_fetch_array($result);
      // echo '<pre>';print_r($row['ADDRESS']);exit;
      $customer_name = $row['NAME'];
      $address = $row['ADDRESS'];
      $contact_number = $row['CONTACT_NUMBER'];
      $vehicle_number = $row['VEHICLE_NUMBER'];
      $number = $row['NUMBER'];
      $reffered = $row['REFFERED'];

      $query = "SELECT * FROM invoices WHERE INVOICE_ID = $invoice_number";
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_array($result);
     // echo '<pre>';print_r($row);exit;
      $invoice_date = $row['INVOICE_DATE'];
       $invoice_date = new DateTime($invoice_date);
    $invoice_date = $invoice_date->format("d-m-Y");
      $total_amount = $row['TOTAL_AMOUNT'];
      // $total_amount -= (($row['TOTAL_AMOUNT']-$row['TOTAL_DISCOUNT'])/100);
      // echo $row['TOTAL_DISCOUNT'];
      $total_discount = $row['TOTAL_DISCOUNT'];
      $net_total = $row['NET_TOTAL'];
      $stax = ceil($row['TOTAL_TAX']/2);
      $ctax = ceil($row['TOTAL_TAX']/2);
     $invoice_number=convertToPaddedString($invoice_number);
    }

    ?>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sidenav.css">
    <link rel="stylesheet" href="css/home.css">
    <div class="row" >
   <div style='width:100%;display:flex;justify-content:center'> <img src="https://yrpitsolutions.com/embossed/images/logo-transprant.png" alt="logo" width="100"/><br/></div>
      <div class="col-md-1"></div>
     
      <div class="col-md-10 h3" style="color: #027ba3;">Customer Invoice<span class="float-right">Invoice Number : <?php echo $invoice_number; ?></span></div>
    </div>
    <div class="row font-weight-bold">
      <div class="col-md-1"></div>
      <div class="col-md-10"><span class="h4 float-right">Invoice Date. : <?php echo $invoice_date; ?></span></div>
    </div>
    <div class="row text-center">
      <hr class="col-md-10" style="padding: 0px; border-top: 2px solid  #027ba3;">
    </div>
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-4">
       
        <span class="h4">Customer Details : </span><br><br>
        <span class="font-weight-bold">Name : </span><?php echo $customer_name; ?><br>
        <span class="font-weight-bold">Address : </span><?php echo $address; ?><br>
        <span class="font-weight-bold">Contact Number : </span><?php echo $contact_number; ?><br>
        <span class="font-weight-bold">Vehicle Number : </span><?php echo $vehicle_number; ?><br>
        <span class="font-weight-bold">GST NUMBER : </span><?php echo $number; ?> <br>
        <span class="font-weight-bold">REFFERED BY: </span><?php echo $reffered; ?> <br>
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
        
          <span class="font-weight-bold">GST : 29AJEPW6489Q1ZS</span><br>
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
              <th>Rate</th>
              <th>Tax</th>
              <th>DISCOUNT</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $seq_no = 0;
              $total = 0;
              // $query = "SELECT * FROM sales WHERE INVOICE_NUMBER = $invoice_number";
              $query = "SELECT sales.*, invoices.*
              FROM sales JOIN invoices ON invoices.INVOICE_ID = sales.INVOICE_NUMBER
              WHERE sales.INVOICE_NUMBER = $invoice_number";

              $result = mysqli_query($con, $query);
              while($row = mysqli_fetch_array($result)) {
                $seq_no++;
                ?>
                <tr>
                  <td><?php echo $seq_no; ?></td>
                  <td><?php echo $row['MEDICINE_NAME']; ?></td>
                   <td><?php echo $row['BATCH_ID']; ?></td>
                    <td><?php echo $row['EXPIRY_DATE']; ?></td>
                  <td><?php echo $row['QUANTITY']; ?></td>
                  <td><?php echo $row['MRP']; ?></td>
                  <td><?php echo $row['TOTAL']."%"; ?></td>
                  <td><?php echo $row['DISCOUNT']."%"; ?></td>
                  <td><?php echo $row['MRP']*$row['QUANTITY']; ?></td>
                </tr>
                <?php
              }
            ?>
          </tbody>
          <tfoot class="font-weight-bold">
            <tr style="text-align: right; font-size: 18px;">
              <td colspan="8">&nbsp;Total Amount</td>
              <td>₹ <?php echo $total_amount; ?>.00</td>
            </tr>
            <tr style="text-align: right; font-size: 18px;">
              <td colspan="8">&nbsp;Total Discount</td>
              <td>-₹ <?php echo $total_discount; ?>.00</td>
            </tr>
            <tr style="text-align: right; font-size: 18px;">
              <td colspan="8">&nbsp;SGST</td>
              <td>₹ <?php echo $stax; ?>.00</td>
            </tr>
            <tr style="text-align: right; font-size: 18px;">
              <td colspan="8">&nbsp;CGST</td>
              <td>₹ <?php echo $ctax; ?>.00</td>
            </tr>
            <tr style="text-align: right; font-size: 22px;">
              <td colspan="8">&nbsp;Net Amount</td>

              <td class="">₹ <?php echo ceil(($total_amount+$ctax+$stax)-$total_discount); ?>.00</td>

            </tr>
            <tr>
              <td colspan="5">&nbsp;Net Amount in Words: </td>
              <td colspan="5" > <?php $amount_words = AmountInWords(ceil(($total_amount+$ctax+$stax)-$total_discount)); echo $amount_words.' Only'; ?></td>
            </tr>
          </tfoot>
        </table>
        <div class="width:100%; h3 float-right">
            
                
<span class="h6" style="font-size:30px">FOR : </span>
<span class="h6"  style="font-size:30px"> Embossed </span><br><br>

</div><br/>

      
    
      </div>
    
    </div>
    <div class="row text-center">
   
    <p class="text-center col-md-12"><strong>NOTE: </strong>Item once sold will not be taken back or exchange</p> 
    </div>
  
    <div class="row text-center">
   
      <hr class="col-md-10" style="padding: 0px; border-top: 2px solid  #027ba3;">
    </div>
   

<div class="col-md-12  " style="display:flex;justify-content:center;">
**This is a Computer Generated Invoice**
            </div>
    <?php
  }

?>






