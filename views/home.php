<?php
    ini_set('error_reporting',E_ALL);
    ini_set('display_errors',1);
session_start();
    if(isset($_SESSION['username'])){
        echo "Welcome " . $_SESSION['username'];
        echo "<br>";
        echo '<a href="/php-twitter/logout">Logout from here</a>';
        ?>
        <form action="/php-twitter/api/tweet" method="post">
            <input type="text" name="text">
            <button type="submit">Tweet!</button>
        </form>

    <?php
    
    }else{
        echo "You aren't logged in";
        echo "<br>";
        echo '<a href="/php-twitter/login">Login from here</a>';
    }
    $conn = new mysqli("localhost", "mehan", "mehan1388","login");
    $sql = "SELECT * FROM tweet ORDER BY date DESC LIMIT 0,25";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $user = $row['username'];
        $text = $row['text'];
        $date = $row['date'];
        echo "
        <p style=\"opacity:40%\">$date</p>
        <b> $user wrote:</b>
        <p style=\"margin-left:40px\"> $text </p>
        ";
    }
    } else {
    echo "0 results";
}
    ?>