<?php
  $servername = "localhost";
  $username = "root";
  $password = "1234";
  $dbase = "hrm_project";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbase);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  //echo "connected.";
?>                                            