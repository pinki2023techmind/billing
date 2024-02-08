<?php
  require "db_connection.php";
  if($con) {
    $name = ucwords($_GET["name"]);
    $email = $_GET["email"];
    $contact_number = $_GET["contact_number"];
    $address = ucwords($_GET["address"]);
    $state = ucwords($_GET['state']);
    $country = ucwords($_GET['country']);
    $vehicle_number = $_GET["vehicle_number"];
    $gst_number = $_GET["gst_number"];


    $query = "SELECT * FROM suppliers WHERE UPPER(NAME) = '".strtoupper($name)."'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if($row)
      echo "Supplier with name $name already exists!";
    else {
      $query = "INSERT INTO suppliers (NAME, EMAIL, CONTACT_NUMBER, ADDRESS, STATE, COUNTRY, VEHICLE_NUMBER, GST_NUMBER) 
      VALUES('$name', '$email', '$contact_number', '$address', '$state', '$country', '$vehicle_number','$gst_number')";
      $result = mysqli_query($con, $query);
      if(!empty($result))
  			echo "$name added...";
  		else
  			echo "Failed to add $name!";
    }
  }
?>
