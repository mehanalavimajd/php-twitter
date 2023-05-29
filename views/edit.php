<?php 
session_start();

if (!isset($_SESSION['username'])){
  header("location: /php-twitter/signup");
  die();
}
$user = $_SESSION['username'];
$conn = new mysqli("localhost", "mehan", "mehan1388", "login");
$sql = "SELECT * FROM users where username='$user'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while ($row = $result->fetch_assoc()) {
    $user = $row['username'];
    $bio = $row['bio'];
    $city = $row['city'];
    $email = $row['email'];
    $profile = "";
    $result2 = $conn->query("SELECT profile FROM users WHERE username='$user'");
    while ($row2 = $result2->fetch_assoc()) {
      $profile = $row2['profile'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <style>
        @font-face {
            font-family: vazir;
            src: url("public/Vazirmatn-Medium.ttf");
        }
        *{
            direction:rtl;
            font-family: vazir;
        }
        label{
            margin-left: 52%;
        }
    </style>


    <title>account setting or edit profile - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <div class="user-avatar">
                                    <img src="<?php echo $profile ?>" alt="user pic">
                                </div>
                                <h5 class="user-name"><?php echo $user; ?></h5>
                                <h6 class="user-email"><a><?php echo $email; ?></a></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <form action="http://localhost/php-twitter/edit" method="post" enctype="multipart/form-data">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mb-2 text-primary">اطلاعات شخصی</h6>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="bio">توضیحی کوتاه درباره خودتان</label>
                                        <input type="text" value="<?php echo $bio; ?>" name="bio" class="form-control" id="bio" placeholder="Enter bio">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="email" style="margin-left: 87%;">ایمیل</label>
                                        <input type="email" value="<?php echo $email; ?>" name="email" class="form-control" id="email" placeholder="Enter email ">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="city" style="margin-left: 75%;">موقعیت مکانی</label>
                                        <input type="text" value="<?php echo $city; ?>" name="city" class="form-control" id="city" placeholder="Enter city">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                        <label for="city" style="margin-left: 75%;">عکس پروفایل</label>
                                        <input type="file"  name="uploadedFile" class="form-control" id="city" placeholder="Enter phone number">
                                    </div>
                                </div>

                            </div>
                            <div class="row gutters" style="visibility:hidden">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mt-3 mb-2 text-primary">Address</h6>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="Street">Street</label>
                                        <input type="name" class="form-control" id="Street" placeholder="Enter Street">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="ciTy">City</label>
                                        <input type="name" class="form-control" id="ciTy" placeholder="Enter City">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="sTate">State</label>
                                        <input type="text" class="form-control" id="sTate" placeholder="Enter State">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="zIp">Zip Code</label>
                                        <input type="text" class="form-control" id="zIp" placeholder="Zip Code">
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="text-right">
                                        <button type="button" id="submit" onclick="location.reload()" name="submit" class="btn btn-secondary">لغو‌ کردن</button>
                                        <button type="submit" id="submit" name="submit" class="btn btn-primary">به‌روزرسانی</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <style type="text/css">
        body {
            margin: 0;
            padding-top: 40px;
            color: #2e323c;
            background: #f5f6fa;
            position: relative;
            height: 100%;
        }

        .account-settings {
            margin: 0 0 1rem 0;
            padding-bottom: 1rem;
            text-align: center;
        }
        .user-profile{
            margin-top: 50%;
        }

        .account-settings  .user-avatar {
            margin: 0 0 1rem 0;
        }

        .account-settings .user-profile .user-avatar img {
            width: 90px;
            height: 90px;
            -webkit-border-radius: 100px;
            -moz-border-radius: 100px;
            border-radius: 100px;
        }

        .account-settings .user-profile h5.user-name {
            margin: 0 0 0.5rem 0;
        }

        .account-settings .user-profile h6.user-email {
            margin: 0;
            font-size: 0.8rem;
            font-weight: 400;
            color: #9fa8b9;
        }

        .account-settings .about {
            margin: 2rem 0 0 0;
            text-align: center;
        }

        .account-settings .about h5 {
            margin: 0 0 15px 0;
            color: #007ae1;
        }

        .account-settings .about p {
            font-size: 0.825rem;
        }

        .form-control {
            border: 1px solid #cfd1d8;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            font-size: .825rem;
            background: #ffffff;
            color: #2e323c;
        }

        .card {
            background: #ffffff;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            border: 0;
            margin-bottom: 1rem;
        }
    </style>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
$message = '';
$dest_path=$profile;
$bio=$_POST['bio'];
$city=$_POST['city'];
$email=$_POST['email'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
    // get details of the uploaded file
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    if(!is_dir("./upload/"))
        mkdir("./upload/");
    // sanitize file-name
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

    // check if file has one of the following extensions
    $allowedfileExtensions = array('jpg', 'gif', 'png','jpeg');

    if (in_array($fileExtension, $allowedfileExtensions)) {
        // directory in which the uploaded file will be moved
        $uploadFileDir = 'upload/';
        $dest_path = $uploadFileDir . $newFileName;
        
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $message = 'File is successfully uploaded.';
        } else {
            $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
        }
    } else {
        $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    }
} else {
    $message = 'There is some error in the file upload. Please check the following error.<br>';
    $message .= 'Error:' . $_FILES['uploadedFile']['error'];
}
$_SESSION['message'] = $message;

$conn = new mysqli("localhost", "mehan", "mehan1388", "login");
$conn->query("UPDATE users SET bio='$bio' WHERE username='$user'");
$conn->query("UPDATE users SET email='$email' WHERE username='$user'");
$conn->query("UPDATE users SET profile='$dest_path' WHERE username='$user'");
$conn->query("UPDATE users SET city='$city' WHERE username='$user'");

// wow, sql sucks at updating multiple things
}}}}