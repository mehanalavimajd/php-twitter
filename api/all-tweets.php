<?php
  $conn = new mysqli("localhost", "mehan", "mehan1388","login");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT * FROM tweet ORDER BY date DESC LIMIT 0,25";
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          array()
        }
      } else {
        echo "0 results";
      }
      $conn->close();
    header('Content-Type: application/json');

    } 

