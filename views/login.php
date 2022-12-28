<form action="/php-twitter/login" method="POST">
    <input type="text" name="username">
    <input type="password" name="pass">
    <input type="submit">
</form>
<?php
    session_start();
    ini_set('error_reporting',E_ALL);
    ini_set('display_errors',1);
    $conn = new mysqli("localhost", "mehan", "mehan1388","login");
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    if($_SERVER['REQUEST_METHOD']=="POST"){
      $username = $_POST['username'];
      $pass = $_POST['pass'];
      $sql_query="SELECT id FROM users WHERE username='$username' AND password='$pass'";
      $result = $conn->query($sql_query);
      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $_SESSION['username']=$username;
          $_SESSION['pass']=$pass;
          header("location: /php-twitter/");
          die();
        }
     }else {
      echo "0 results";
    }
    $conn->close();
    }
?>