<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTA tweeter</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/php-twitter/public/login-prefix.css">
    <style>
        .srouce {
            text-align: center;
            color: #ffffff;
            padding: 10px;
        }
    </style>
</head>

<body>

    <div class="main-container">
        <div class="form-container">

            <div class="srouce"><a>localhost/php-twitter</a></div>

            <div class="form-body">
                <h2 class="title">Start Tweeting today</h2>
                <div class="social-login">
                    <ul>
                        <li class="google"><a href="#"></a></li>
                        <li class="fb"><a href="#"></a></li>
                    </ul>
                </div><!-- SOCIAL LOGIN -->
                <form action="//localhost/php-twitter/signup" method="POST" class="the-form">

                    <label for="email">Username</label>
                    <input type="text" name="username" id="email" placeholder="Enter your user">

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email">

                    <label for="password">Password</label>
                    <input type="password" name="pass" id="password" placeholder="Enter your password">

                    <input type="submit" value="Log In">

                </form>

            </div><!-- FORM BODY-->

            <div class="form-footer">
                <div>
                    <span>Don't have an account?</span> <a href="/php-twitter/signup">Sign Up</a>
                </div>
            </div><!-- FORM FOOTER -->

        </div><!-- FORM CONTAINER -->
    </div>

</body>

</html>
<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
$conn = new mysqli("localhost", "mehan", "mehan1388", "login");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$dest_path="public/user.png";
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $sql = "INSERT INTO users (username, password,email,profile)
        VALUES ('$username', '$pass','$email','$dest_path')";
    try {
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            $_SESSION['username'] = $username;
            $_SESSION['pass'] = $pass;
            die();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        die();
    } catch (mysqli_sql_exception) {
        if ($conn->errno == 1062) {
            echo "duplicate";
            die();
        } else {
            echo $conn->error;
        }
    }
}
?>