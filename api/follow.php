<?php
    ini_set('error_reporting',E_ALL);
    ini_set('display_errors',1);
session_start();
$conn = new mysqli("localhost", "mehan", "mehan1388","login");
$u1 = $_SESSION['username'];
$u2 = $_POST['u']; // * u1 wants to follow u2
$sql = "SELECT * FROM users where username='$u1'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $followings = $row['following'];
        if (strpos($followings, $u2) === false) {
            $f = $followings . $u2 . ",";
            $sql = "UPDATE users SET following='$f' WHERE username='$u1'";
            $conn->query($sql);
            $sql = "SELECT * FROM users where username='$u2'";
            $result2 = $conn->query($sql);
            $f2 = '';
            while ($row2 = $result2->fetch_assoc()) {
                $f2 = $row2['follower'] . $u1 . ",";
                $follower_num = $row2["f-num"];
                $follower_num += 1;
            }
            $sql = "UPDATE users SET follower='$f2' WHERE username='$u2'";
            $conn->query($sql);
            global $follower_num;
            $sql = "UPDATE users SET `f-num`='$follower_num' WHERE username='$u2'";
            $conn->query($sql);
            echo "f-$follower_num";
        }else{
            $f = str_replace($followings, "", $u2.",");
            $sql = "UPDATE users SET following='$f' WHERE username='$u1'";
            $conn->query($sql);
            $sql = "SELECT * FROM users where username='$u2'";
            $result2 = $conn->query($sql);
            $f2 = '';
            while ($row2 = $result2->fetch_assoc()) {
                $f2 = str_replace($row2['follower'], "", $u1.",");;
                $follower_num = $row2["f-num"];
                $follower_num -= 1;
            }
            $sql = "UPDATE users SET follower='$f2' WHERE username='$u2'";
            $conn->query($sql);
            global $follower_num;
            $sql = "UPDATE users SET `f-num`='$follower_num' WHERE username='$u2'";
            $conn->query($sql);
            echo "u-$follower_num";
        }
    }
}
