<?php
include 'env.php';
global $conn;
$servername = HOSTNAME; 
$db_username = DB_USER;
$db_password = DB_PASS;
$db_name = DB_NAME;


// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




?>