<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<link rel="stylesheet" href="/php-twitter/public/style.css" media="screen">
<section style="background-color: #eee;">


    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
            <h3 class="my-3">John Smith</h5>
            <p class="text-muted mb-1">Full Stack Developer</p>
            <p class="text-muted mb-4">Bay Area, San Francisco, CA</p>
            <div class="d-flex justify-content-center mb-2">
              <button type="button" class="btn btn-primary">Follow</button>
              <button type="button" class="btn btn-outline-primary ms-1">Message</button>
            </div>
          </div>
        </div>
       
</section>
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
          $profile = "";
          $result2 = $conn->query("SELECT profile FROM users WHERE username='$user'");
          while ($row2 = $result2->fetch_assoc()) {
            $profile = $row2['profile'];
          }
          echo "
          <article class=\"twit usertwit\">
          <div class=\"twit-content\">
          <img class=\"twit-avatar\" src=\"$profile\"></img>
          <p class=\"twit-author\">
          <a href=\"/php-twitter/user/$user\">$user</a>
        </p>
            <p class=\"twit-text\">
              $text
            </p>
            <i class=\"fa-regular fa-heart like\" id=\"like-$id\" onclick=\"like($id)\"></i>
            <p id=\"like-num-$id\" class=\"like-num\"> </p>
        ";
        if(isset($_SESSION['username'])){
        if ($user === $_SESSION['username']) {
          echo "
        <p id=\"delete-$id\" class=\"delete\">Delete</p>";
        }
      }
        echo " 
        <p id=\"date\" class=\"date\"> $date </p>
        </div>
      </article>";
        }
      } else {
        echo "0 results";
        }
    }
}else{
    echo "user $user not found :(";
}
?>