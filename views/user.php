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
        session_start();
        if(isset($_SESSION['username']))
            include("views/user-real.php");
        
        $conn = new mysqli("localhost", "mehan", "mehan1388","login");
        $sql = "SELECT * FROM tweet where username='$user' ORDER BY date DESC LIMIT 0,25";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $user = $row['username'];
            $text = $row['text'];
            $date = $row['date'];
            $id = $row['id'];
            echo "
            <p style=\"opacity:40%\">$date</p>
            <b> $user wrote:</b>
            <p style=\"margin-left:40px\"> $text </p>
            <button class=\"like\" id=\"like-$id\" onclick=\"like($id)\">like</button>
            <p id=\"like-num-$id\"> </p>
            ";}
        } else {
        echo "no tweet";
        }
    }
}else{
    echo "user $user not found :(";
}
?>