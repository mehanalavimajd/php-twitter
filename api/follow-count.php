<?php
    ini_set('error_reporting',E_ALL);
    ini_set('display_errors',1);
session_start();
  $conn = new mysqli("localhost", "mehan", "mehan1388","login");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $user = $_POST['user'];
$u=explode(" ",$user);
$user = $u[0];
$user2 = $u[1];

$sql = "SELECT * FROM users where username='$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    if ($row['follower']===null) {
      $row['follower'] = "";
    }
        if(strpos($row['follower'],$user2)===false){
            $s = $row['f-num'];
            $s2=$row['f2-num'];
            echo "f-$s-$s2";
        }else{
            $s = $row['f-num'];
            $s2=$row['f2-num'];
            echo "u-$s-$s2";
        }
    }
} 