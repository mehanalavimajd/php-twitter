<?php
  $conn = new mysqli("localhost", "mehan", "mehan1388","login");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
$id = $_POST['id'];
$user = $_SESSION['username'];
$sql = "SELECT * FROM tweet where id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
  }
} 