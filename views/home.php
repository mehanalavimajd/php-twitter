<!-- bunch of cdn -->
<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
?>
<script src="/php-twitter/public/jquery.js"></script>
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <title>Tweeter</title>
  <link rel="icon" href="/php-twitter/public/UTA-i.png">
  <!-- This is a 3rd-party stylesheet to make available the font family to be used for this page ("Roboto"). -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,400,700" rel="stylesheet">

  <!-- This 3rd-party stylesheet incorporates SVG icons from Font Awesome: http://fontawesome.com/ -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.1/css/all.css" crossorigin="anonymous">

  <link rel="stylesheet" href="/php-twitter/public/style.css" media="screen">

  <script src="/php-twitter/public/index.js" charset="utf-8" defer></script>

</head>

<body>

  <header>
    <!-- The <i> tag below includes the bullhorn icon from Font Awesome -->

    <a href="#">
      <h1 class="site-title">
        <b>UTA</b> twitter
    </a>
    </h1>
    <nav class="navbar">
      <ul class="navlist">
        <li class="navitem navlink active "><a href="/php-twitter">Home</a></li>
        <?php
        session_start();
        if (isset($_SESSION['username'])) { ?>

          <li class="navitem navlink"><a href="/php-twitter/followings">Following</a></li>
        <?php } else { ?>
          <li class="navitem navlink"><a href="/php-twitter/login">Following</a></li>
        <?php
        }
        ?>
        <?php
        if (isset($_SESSION['username'])) { ?>
          <li class="navitem navlink"><a href="/php-twitter/trending">Trending</a></li>
        <?php } else { ?>
          <li class="navitem navlink"><a href="/php-twitter/login">Trending</a></li>
        <?php
        }
        ?>

        <li class="navitem navbar-search">
          <input type="text" id="navbar-search-input" class="search" placeholder="Search...">
          <button type="button" id="navbar-search-button"><i class="fas fa-search"></i></button>
          <img src="public/triangle.png" alt="" class="tri" onclick="infobox()">
          <?php
          if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            echo "<a id=\"username\" href=\"/php-twitter/user/$username\">$username</a>";
          ?>
            <div class="info-box">
              <a href='/php-twitter/edit'>Edit profile</a>
              <div style="width:100%; height:1px; background-color: black;"></div>
              <a href='/php-twitter/logout'>Logout</a>
            </div>
          <?php

          } else {
            echo "<a id=\"username\" href=\"/php-twitter/login\">Login</a>";
          }
          ?>
        </li>
      </ul>
    </nav>
  </header>

  <main class="twit-container">

    <?php
    function tweets($sql)
    {
      $conn = new mysqli("localhost", "mehan", "mehan1388", "login");

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
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
        <article class=\"twit\">
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
          if ($user === $_SESSION['username']) {
            echo "
          <p id=\"delete-$id\" class=\"delete\">Delete</p>";
          }
          echo " 
          <p id=\"date\" class=\"date\"> $date </p>
        </div>
      </article>
      ";
        }
      } else {
        echo "0 results";
      }
    }
    tweets("SELECT * FROM tweet ORDER BY date DESC LIMIT 0,25");
    function clearTweets()
    {
    ?>
      <script>
        let twits = document.querySelectorAll("article");
        for (let i = 0; i < twits.length; i++) {
          const element = twits[i];
          element.remove();
        }
      </script>
    <?php
    }
    ?>

  </main>

  <button type="button" id="create-twit-button"><i class="fas fa-plus"></i></button>

  <div id="modal-backdrop" class="hidden"></div>
  <div id="create-twit-modal" class="hidden">
    <div class="modal-dialog">

      <div class="modal-header">
        <h3>Create a Tweet</h3>
        <button type="button" class="modal-close-button">&times;</button>
      </div>
      <form action="/php-twitter/api/tweet" method="post">
        <div class="modal-body">
          <div class="twit-input-element">
            <label for="twit-text-input">Tweet text</label>
            <input maxlength="255" type="text" name="text">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="modal-cancel-button">Cancel</button>
          <button type="submit" class="modal-accept-button">Tweet!</button>
        </div>
      </form>
    </div>
  </div>

</body>

</html>
<script>
  // sending like request to api
  let buttons = document.querySelectorAll('.like')

  function ErrorNotification() {
    alert("Please login to like and tweet")
  }
  if (String(window.location).split("?").length == 2) {
    if (String(window.location).split("?")[1].includes("error")) {
      ErrorNotification();
      window.location = "/php-twitter"
    }
  }
  console.log(buttons);
  for (let i = 0; i < buttons.length; i++) {
    const element = buttons[i];
    console.log(element);
    let id = parseInt(element.id.replace("like-", ""))
    console.log("t");
    if (localStorage.getItem("liked-" + id) == 'true') {
      document.querySelector("#like-" + id).classList.replace("fa-regular", "fa-solid")
      document.querySelector("#like-" + id).style.color = 'red';
      console.log(id);
    }
    console.log(id);
    $.ajax({
      type: "POST",
      url: "api/like-count.php",
      data: "id=" + id,
      dataType: "text",
      success: function(msg) {
        document.getElementById("like-num-" + id).innerText = msg;
      }
    })
  }

  function like(id) {
    $.ajax({
      type: "POST",
      url: "api/like.php",
      data: "id=" + id,
      dataType: "text",
      success: function(msg) {
        // the condition is because maybe the user is not logged in
        if (msg !== '') {
          if (String(msg).includes("l")) {
            document.querySelector("#like-" + id).classList.replace("fa-regular", "fa-solid")
            document.querySelector("#like-" + id).style.color = 'red';
            localStorage.setItem("liked-" + id, "true");
            document.getElementById("like-num-" + id).innerText = msg.split("-")[1];
          } else {
            document.querySelector("#like-" + id).classList.replace("fa-solid", "fa-regular")
            document.querySelector("#like-" + id).style.color = 'black';
            localStorage.removeItem("liked-" + id)
            document.getElementById("like-num-" + id).innerText = msg.split("-")[1];
          }
          console.log(msg);
        } else {
          ErrorNotification();
        }
      }
    })
  }
  let infoclick = 0;

  function infobox() {
    if (infoclick == 0) {
      document.querySelector(".info-box").style.display = 'block';
      infoclick = 1;
    } else {
      document.querySelector(".info-box").style.display = 'none';
      infoclick = 0;
    }
  }
  // search feature
  $('.search').change(function(e) {
    var q = $('.search').val();
    window.location = "/php-twitter?q=" + q
  })
  let del = document.querySelectorAll(".delete")
  for (let o = 0; o < del.length; o++) {
    const element = del[o];
    let id = element.id.split("-")[1]
    element.addEventListener("click", (e) => {
      $.ajax({
        type: "POST",
        url: "api/delete.php",
        data: "id=" + id,
        dataType: "text",
        success: function(msg) {
          console.log(msg);
          location.reload()
        }
      })
    })
  }
</script>

<?php
if (isset($_GET['q'])) {
  $query = $_GET['q'];
  clearTweets();
  tweets("SELECT * FROM tweet WHERE (`text` LIKE \"%$query%\") ORDER BY date DESC LIMIT 0,25");
}
