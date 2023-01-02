<?php
  $conn = new mysqli("localhost", "mehan", "mehan1388","login");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $text = $_POST['text'];
    $sql = "INSERT INTO tweet (username, text)
      VALUES ('$username', '$text')";
    
    if ($conn->query($sql) === TRUE) {
        ?> 
        <?php
        header("Location: /php-twitter/");
        die();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}
