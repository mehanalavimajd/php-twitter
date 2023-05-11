<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
$conn = new mysqli("localhost", "mehan", "mehan1388", "login");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$user = $_GET['user']; // from index.php
$sql_query = "SELECT * FROM users WHERE username='$user'";
$result = $conn->query($sql_query);
if ($result->num_rows == 1) {
  while ($row = $result->fetch_assoc()) {
?>

<?php
    session_start();
    if (isset($_SESSION['username']))
    include("views/user-real.php");

    $conn = new mysqli("localhost", "mehan", "mehan1388", "login");
    $sql = "SELECT * FROM tweet where username='$user' ORDER BY date DESC LIMIT 0,25";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
        $user = $row['username'];
        $text = $row['text'];
        $date = $row['date']; $retweet = $row['retweet'];
        $id = $row['id'];
        $profile = "";
        $result2 = $conn->query("SELECT profile FROM users WHERE username='$user'");
        while ($row2 = $result2->fetch_assoc()) {
          $profile = $row2['profile'];
        }
        echo "
        <div class=\"alert\" style=\"display:none\">
        <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
        This is an alert box.
      </div>
          <article class=\"twit usertwit\">
          <div class=\"twit-content\">
          <img class=\"twit-avatar\" src=\"http://localhost/php-twitter/$profile\"></img>
          <p class=\"twit-author\">
          <b><a href=\"/php-twitter/user/$user\">$user</a> </b>" ?> <?php if($retweet!==NULL) echo "ری‌توییت شده از <a class=\"retweet-link\" href=\"localhost/php-twitter/user/$retweet\">$retweet</a>"; echo "
        </p>
        <p>
            <a href=\"http://localhost/php-twitter/tweet/$id\" class=\"twit-text\">
              $text
            </a>
        </p>
        <div class=\"btn-cont\">
        <i class=\"fa-regular fa-heart like btns\" id=\"like-$id\" onclick=\"like($id)\"></i>
        <p id=\"like-num-$id\" class=\"like-num btns\"> </p>
        <i class=\"fa-solid fa-retweet retweet btns\" id=\"retweet-$id\"></i>
        <i class=\"fa-solid fa-share-nodes share btns\" id=\"share-$id\"></i>
        <i class=\"fa-regular fa-comment com-btn\" id=\"com-$id\"></i></a>
        <p id=\"com-num-$id\" class=\"com-num btn\"></p>
        ";
        if (isset($_SESSION['username'])) {
          if ($user === $_SESSION['username']) {
            echo "
        <p id=\"delete-$id\" class=\"delete btns\">Delete</p>";
          }
        }
        echo " 
        </div>
        <p id=\"date\" class=\"date\"> $date </p>
        </div>
      </article>";
      }
    } else {
      echo "0 results";
    }
    
  }
} else {
  echo "user $user not found :(";
}
?>
<script>
  let cbtn = document.querySelectorAll(".com-btn")
  cbtn.forEach((e)=>{
    let id = e.id.split("com-")[1]
    $.ajax({
      type: "POST",
      url: "//localhost/php-twitter/api/comment-count.php",
      data: "id=" + id,
      dataType: "text",
      success: function(msg) {
        document.getElementById("com-num-" + id).innerText = msg;
        console.log('hekk');
      }
    })
  })
</script>