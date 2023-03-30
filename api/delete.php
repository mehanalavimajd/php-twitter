<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
$id = $_POST['id'];


$conn = new mysqli("localhost", "mehan", "mehan1388", "login");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM tweet where id='$id'";
$result = $conn->query($sql);
$username;
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
    }
}
if($_SESSION['username'] === $username){
$sql = "DELETE FROM tweet where id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
  } else {
    echo "Error deleting record: " . $conn->error;
  }
}