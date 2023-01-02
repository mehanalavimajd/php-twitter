<?php
  $conn = new mysqli("localhost", "mehan", "mehan1388","login");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
$id = $_POST['id'];
$user = $_SESSION['username'];
$sql = "SELECT * FROM tweet where id=$id";
if($conn->query($sql)===true){
    
}