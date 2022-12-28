<?php
session_start();
    if(isset($_SESSION['username'])){
        echo "Welcome " . $_SESSION['username'];
    echo "<br>";
    echo '<a href="/login/logout">Logout from here</a>';
    }else{
        echo "You aren't logged in";
        echo "<br>";
        echo '<a href="/php-twitter/login">Login from here</a>';
    }
?>