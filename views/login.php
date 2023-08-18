<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTA tweeter</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/php-twitter/public/login-prefix.css">
    <style>
        .srouce{
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
                <form action="//localhost/php-twitter/login" method="POST" class="the-form">

                    <label for="email">ایمیل</label>
                    <input type="email" name="email" id="email" placeholder="">

                    <label for="password">رمز عبور</label>
                    <input type="password" name="pass" id="password" placeholder="">

                    <input type="submit" value="ورود">

                </form>

            </div><!-- FORM BODY-->

            <div class="form-footer">
                <div class="sign">
                    <span>اکانت ندارید؟</span> <a href="/php-twitter/signup">ثبت‌نام کنید!</a>
                </div>
            </div><!-- FORM FOOTER -->

        </div><!-- FORM CONTAINER -->
    </div>

</body>
</html>
<?php
    session_start();
    ini_set('error_reporting',E_ALL);
    ini_set('display_errors',1);
    $conn = new mysqli("localhost", "mehan", "mehan1388","login");
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    if($_SERVER['REQUEST_METHOD']=="POST"){
      $email = $_POST['email'];
      $pass = $_POST['pass'];
      $sql_query="SELECT username FROM users WHERE email='$email' AND password='$pass'";
      $result = $conn->query($sql_query);
      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          $_SESSION['username']=$row['username'];
          $_SESSION['pass']=$pass;
          header("location: /php-twitter/");
          die();
        }
     }else {
        echo "<script>alert('نام کاربری یا رمز اشتباه است.')</script>";
    }
    $conn->close();
    }
?>