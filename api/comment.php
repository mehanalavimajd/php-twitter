<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
$id = $_POST['id'];
$user = $_SESSION['username'];
$conn = new mysqli("localhost", "mehan", "mehan1388","login");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// don't know why??
$sql = "SELECT * FROM tweet where 'id'=$id";
echo "k".$id-'0';
$result = $conn->query($sql);
echo $result->num_rows;
if ($result->num_rows > 0) {
    echo 2;
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "jj";
  }
}
