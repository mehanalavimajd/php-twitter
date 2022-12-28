<form action="/php-twitter/signup/" method="POST">
    <input type="text" name="username">
    <input type="password" name="pass">
    <input type="submit" href="/">
</form>
<?php
    ini_set('error_reporting',E_ALL);
    ini_set('display_errors',1);
    $conn = new mysqli("localhost", "mehan", "mehan1388","login");
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $pass = $_POST['pass'];
    
        $sql = "INSERT INTO users (username, password)
        VALUES ('$username', '$pass')";
    try {
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            $_SESSION['username'] = $username;
            $_SESSION['pass'] = $pass;
            header("location: /php-twitter/");
            die();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        die();
    }catch (mysqli_sql_exception){
        if($conn->errno==1062){
            echo "duplicate";
            die();
        }
    }
    }
?>