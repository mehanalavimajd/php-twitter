<?php
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
?>