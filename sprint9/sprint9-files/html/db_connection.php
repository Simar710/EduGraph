<?php
function open_con() {
  $dbhost = "localhost";
  // $dbuser = "root";
  $dbuser = "cis3760";
  // $dbpass = "";
  $dbpass = "pass1234";
  $conn = new mysqli($dbhost, $dbuser, $dbpass) or die("Connect failed: %s\n". $conn->error);
  return $conn;
}
function close_con($conn) {
  $conn -> close();
}
?>

