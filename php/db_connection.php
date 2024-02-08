<?php
// $SERVER = 'localhost';
// $USERNAME = 'u790157750_pharmacy';
// $PASSWORD = 'Welcome@2022';
// $DB = 'u790157750_Pharmacy';


$SERVER = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DB = 'u790157750_billing';


@$con = mysqli_connect($SERVER, $USERNAME, $PASSWORD, $DB)
  or
  die("<div class='text-danger text-center h5'>Oops, Unable to connect with database!</div>");

if (isset($_GET['action']) && $_GET['action'] == 'is_logged_in') {
  $query = "SELECT IS_LOGGED_IN FROM admin_credentials";
  $result = mysqli_query($con, $query);
  if ($result) {
    $row = mysqli_fetch_array($result);
    echo $row['IS_LOGGED_IN'];
  } else
    echo "setup";
}
