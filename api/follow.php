<?php
session_start();
ini_set('error_reporting',E_ALL);
ini_set('display_errors',1);
$conn = new mysqli("localhost", "mehan", "mehan1388","login");
$u1 = "";
$u2 = $_POST['u']; // * u1 wants to follow u2
$x = explode(" ",$u2);
$u1=$x[1];
$u2=$x[0];

$sql = "SELECT * FROM users where username='$u1'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $followings = $row['following'];
        $f2=$row['f2-num'];
        if (!(in_array($u2,json_decode($followings,true)['data']))) {
            $f = json_decode($followings, true);
            echo in_array($u2, json_decode($followings, true));
            $f['data'][] = $u2;
            $f = json_encode($f);
            $sql = "UPDATE users SET following='$f' WHERE username='$u1'";
            $conn->query($sql);
            $f2+=1;
            $sql = "UPDATE users SET `f2-num`='$f2' WHERE username='$u1'";
            $conn->query($sql);
            $sql = "SELECT * FROM users where username='$u2'";
            $result2 = $conn->query($sql);
            $f2 = '';
            while ($row2 = $result2->fetch_assoc()) {
                $f2 = json_decode($row2['follower'],true);
                $f2['data'][] = $u1;
                $f2 = json_encode($f2);
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
            $f = json_decode($followings, true);
            $key = array_search($u2, $f['data']);
            unset($f['data'][$key]);
            $f = json_encode($f);

            $sql = "UPDATE users SET following='$f' WHERE username='$u1'";
            $conn->query($sql);
            $sql = "SELECT * FROM users where username='$u2'";
            $result2 = $conn->query($sql);
            $f2 = '';
            while ($row2 = $result2->fetch_assoc()) {
                $f2 = json_decode($followings, true);
                $key = array_search($u2, $f2['data']);
                unset($f2['data'][$key]);
                $f2 = json_encode($f2);

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
