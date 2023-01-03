<?php
    ini_set('error_reporting',E_ALL);
    ini_set('display_errors',1);
session_start();
$conn = new mysqli("localhost", "mehan", "mehan1388","login");
$follower_user = $_SESSION['username'];
$following_user = $_POST['u'];
$sql = "SELECT * FROM users where username='$follower_user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $followings = $row['following'];
        if (strpos($followings, $follower_user) == false) {
            $f = $followings . $following_user . ",";
            $sql = "UPDATE users SET following='$f' WHERE username='$following_user'";
            $conn->query($sql);
            echo "success";
            $sql = "SELECT * FROM users where username='$follower_user'";
            $result2 = $conn->query($sql);
            while ($row2 = $result->fetch_assoc())
                $f2 = $row2['followers'] . $following_user . ",";
            $sql = "UPDATE users SET following='$followings' WHERE username='$follower_user'";
            $conn->query($sql);
        }
    }
}
