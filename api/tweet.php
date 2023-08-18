<?php
$conn = new mysqli("localhost", "mehan", "mehan1388", "login");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$dest_path="";
session_start();
if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
  // get details of the uploaded file
  $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
  $fileName = $_FILES['uploadedFile']['name'];
  $fileSize = $_FILES['uploadedFile']['size'];
  $fileType = $_FILES['uploadedFile']['type'];
  $fileNameCmps = explode(".", $fileName);
  $fileExtension = strtolower(end($fileNameCmps));
  if (!is_dir("./upload/"))
    mkdir("./upload/");
  // sanitize file-name
  $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

  // check if file has one of the following extensions
  $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

  if (in_array($fileExtension, $allowedfileExtensions)) {
    // directory in which the uploaded file will be moved
    $uploadFileDir = 'upload/posts/';
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

if (isset($_SESSION['username'])) {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $text = $_POST['text'];
    $sql = "INSERT INTO tweet (username, text,image)
      VALUES ('$username', '$text','$dest_path')";

    if ($conn->query($sql) === TRUE) {
?> 
        <?php
        header("Location: /php-twitter/");
        die();
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
  } else {
    header("Location: /php-twitter?error=true");
    die();
  }
