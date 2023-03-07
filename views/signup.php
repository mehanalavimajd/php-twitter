<form action="/php-twitter/signup/" method="POST" enctype="multipart/form-data">
    <input type="text" name="username">
    <input type="password" name="pass">
    <input type="email" name="email">
    <label for="input">Avatar</label>
    <input type="file" name="uploadedFile" id="filee">
    <input type="submit">
</form>
<?php
error_reporting(-1);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);


$message = '';
$dest_path='';
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
echo $dest_path;
if($dest_path==="")
    $dest_path="public/user.png";
}
$conn = new mysqli("localhost", "mehan", "mehan1388", "login");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
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
        }else{
            echo $conn->error;
        }
    }
    
}
?>