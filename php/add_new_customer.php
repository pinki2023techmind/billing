<?php
  require "db_connection.php";
  if($con) {
    $name = ucwords($_GET["name"]);
    $contact_number = $_GET["contact_number"];
    $address = ucwords($_GET["address"]);
    $state = ucwords($_GET["state"]);
    $country = ucwords($_GET["country"]);
    
    $vehicle_number = ucwords($_GET["vehicle_number"]);
    $gst_number = ucwords($_GET["gst_number"]);

    $query = "SELECT * FROM customers WHERE CONTACT_NUMBER = '$contact_number'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if($row)
      echo "Customer ".$row['NAME']." with contact number $contact_number already exists!";
    else {
      $query = "INSERT INTO customers (NAME, CONTACT_NUMBER, ADDRESS, STATE,  COUNTRY, VEHICLE_NUMBER, GST_NUMBER) 
      VALUES('$name', '$contact_number', '$address', '$state', '$country', '$vehicle_number', '$gst_number')";
     // echo '<pre>';print_r($query);exit;
      $result = mysqli_query($con, $query);
      if(!empty($result))
  			echo "$name added...";
      
  		else
  			echo "Failed to add $name!";
    }
  }
?>
