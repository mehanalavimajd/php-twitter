<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
$u1 = $_POST['u1'];
$u2 = $_POST['u2'];
$conn = new mysqli("localhost", "mehan", "mehan1388", "login");
$sql = "SELECT * FROM users where username='$u1'";
$result = $conn->query($sql);
$json;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $json = $row['following'];
    }
}
$arr = json_decode($json, true);
$f = 0;
foreach ($arr['data'] as $el) {
    if ($el == $u2) {
        $f = 1;
        break;
    }
}
echo $f;