<?php
    ini_set('error_reporting',E_ALL);
    ini_set('display_errors',1);
$conn = new mysqli("localhost", "mehan", "mehan1388", "login");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id=$_POST['id'];
$sql = "SELECT * FROM tweet where id='$id'";
$result = $conn->query($sql);
echo $id;
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $retweet = $row['username'];
        $text = $row['text'];
        echo "hhe";
    }
}
global $text;
global $retweet;
echo $text;
session_start();
if (isset($_SESSION['username'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_SESSION['username'];
        $sql = "INSERT INTO tweet (username, text,retweet)
      VALUES ('$username', '$text','$retweet')";

        if ($conn->query($sql) === TRUE) {
?> 
        <?php
            echo "ok";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    header("Location: /php-twitter?error=true");
    die();
}
