<?php
    ini_set('error_reporting',E_ALL);
    ini_set('display_errors',1);
session_start();
  $conn = new mysqli("localhost", "mehan", "mehan1388","login");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
$id = $_POST['id'];
$sql = "SELECT * FROM tweet where id='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
        echo $row['likes'];
    }
} 
