<?php
    ini_set('error_reporting',E_ALL);
    ini_set('display_errors',1);
session_start();
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
        $likers = $row['likers'];
        if(strpos($likers,$user) !== false){
            $likers = str_replace($likers, "", $user.",");
            $likes = $row['likes'] - 1;
            $sql = "UPDATE tweet SET likers='$likers' WHERE id=$id";
            $conn->query($sql);
            $sql = "UPDATE tweet SET likes='$likes' WHERE id=$id";
            $conn->query($sql);
            echo "u-$likes"; // responding back!
        }else{
            $likes = $row['likes'] + 1;
            $likers .= $user . ",";
            $sql = "UPDATE tweet SET likers='$likers' WHERE id=$id";
            $conn->query($sql);
            $sql = "UPDATE tweet SET likes='$likes' WHERE id=$id";
            $conn->query($sql);
            echo "l-$likes"; // responding back!
        }
  }
} 