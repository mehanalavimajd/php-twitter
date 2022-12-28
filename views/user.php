<?php
$id = $params['id'];
ini_set('error_reporting',E_ALL);
ini_set('display_errors',1);
$conn = new mysqli("localhost", "mehan", "mehan1388","login");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql_query = "SELECT firstname FROM MyGuests WHERE id=" . $id;
$result = $conn->query($sql_query);
if($result->num_rows == 1){
    while($row = $result->fetch_assoc()){
        echo "ID:" . $id . "<br>". "username:" . $row['firstname'];
    }
}else{
    echo "no user with id " . $id;
}
?>