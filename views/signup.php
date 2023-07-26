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


            <div class="form-body">
                <h2 class="title">نظراتتان را به اشتراک بگذارید!</h2>
                <div class="social-login">
                    <ul>
                        <li class="google"><a href="#"></a></li>
                        <li class="fb"><a href="#"></a></li>
                    </ul>
                </div><!-- SOCIAL LOGIN -->
                <form action="//localhost/php-twitter/signup" method="POST" class="the-form">

                    <label for="email">نام کاربری</label>
                    <input type="text" name="username" id="email" placeholder="">

                    <label for="email">ایمیل</label>
                    <input type="email" name="email" id="email" placeholder="">

                    <label for="password">رمز عبور</label>
                    <input type="password" name="pass" id="password">

                    <input type="submit" value="ثبت‌نام">

                </form>

            </div><!-- FORM BODY-->

            <div class="form-footer">
                <div class="sign">
                    <span>قبل از این حساب ساخته‌اید؟</span> <a href="/php-twitter/login">ورود</a>
                </div>
            </div><!-- FORM FOOTER -->

        </div><!-- FORM CONTAINER -->
    </div>

</body>

</html>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
$conn = new mysqli("localhost", "mehan", "mehan1388", "login");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$dest_path = "public/user.png";
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];




    //Create an instance; passing `true` enables exceptions


    $sql = "INSERT INTO users (username, password,email,profile)
        VALUES ('$username', '$pass','$email','$dest_path')";
    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  //gmail SMTP server
        $mail->SMTPAuth = true;
        //to view proper logging details for success and error messages
        // $mail->SMTPDebug = 1;
        $mail->Host = 'smtp.gmail.com';  //gmail SMTP server
        $mail->Username = 'helli5.uta.twitter@gmail.com';   //email
        $mail->Password = 'dqrxlehcryblblbj';   //16 character obtained from app password created
        $mail->Port = 465;                    //SMTP port
        $mail->SMTPSecure = "ssl";
        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('helli5.uta.twitter@gmail.com', 'کد یوتا توییت');
        $mail->addAddress($email);               //Name is optional

        $num = rand(100000, 999999);

        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This ';

        $mail->send();
        echo 'Message has been sent';
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            $_SESSION['username'] = $username;
            $_SESSION['pass'] = $pass;
            header("location: //localhost/php-twitter/");
            die();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        die();
    } catch (mysqli_sql_exception) {
        if ($conn->errno == 1062) {
            echo "<script>alert('نام کاربری یا ایمیل تکراری است')</script>";
            die();
        } else {
            echo $conn->error;
        }
    }
}
?>