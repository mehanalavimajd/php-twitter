<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
$user = $_POST['user'];
$conn = new mysqli("localhost", "mehan", "mehan1388","login");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM users where username=$user";
$com;
$c_num;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo $row['profile'];
  }}
