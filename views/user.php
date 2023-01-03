<?php
ini_set('error_reporting',E_ALL);
ini_set('display_errors',1);
$conn = new mysqli("localhost", "mehan", "mehan1388","login");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$user = $_GET['user']; // from index.php
$sql_query = "SELECT * FROM users WHERE username='$user'";
$result = $conn->query($sql_query);
if($result->num_rows == 1){
    while($row = $result->fetch_assoc()){
        echo $row['username'];
    }
}else{
    echo "user $user not found :(";
}
?>