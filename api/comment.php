<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
$id = $_POST['id'];
$text = $_POST['text'];
$user = $_SESSION['username'];
$conn = new mysqli("localhost", "mehan", "mehan1388","login");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM tweet where id=$id";
$com;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $com = $row['comments'];
  }
}
$sql = "SELECT * FROM users where username='$user'";
$profile;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $profile = $row['profile'];
  }
}
$com = json_decode($com,true);
$newContent = [
  'user'=> $user,
  'text'=> $text,
  'profile'=>$profile
];
$com['data'][] = $newContent;
echo json_encode($com);
$com = json_encode($com);
$sql = "UPDATE tweet SET comments='$com' WHERE id=$id";
$conn->query($sql);
