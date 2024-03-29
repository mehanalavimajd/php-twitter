<!-- bunch of cdn -->
<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <title>یوتا توییت</title>
  <link rel="icon" href="/php-twitter/public/UTA-i.png">
  <!-- This is a 3rd-party stylesheet to make available the font family to be used for this page ("Roboto"). -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,400,700" rel="stylesheet">

  <!-- This 3rd-party stylesheet incorporates SVG icons from Font Awesome: http://fontawesome.com/ -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.1/css/all.css" crossorigin="anonymous">

  <link rel="stylesheet" href="/php-twitter/public/style.css" media="screen">

  <script src="//localhost/php-twitter/public/index.js" charset="utf-8" defer></script>

</head>

<body>

<header style="background-color:#1c4a70; width:100%; text-align:center;">
    <!-- The <i> tag below includes the bullhorn icon from Font Awesome -->

    <a href="#" style:"display:inline-block; margin: 0 auto;">
      <img style="height:100px" src="//localhost/php-twitter/public/uta.png"></img>
    </a>
    <div class="alert" style="display:none">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
      This is an alert box.
    </div>
</header>

  <main class="twit-container">

    <?php
    session_start();
    $Id=0;
    function tweets($sql)
    {
      $conn = new mysqli("localhost", "mehan", "mehan1388", "login");

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
          $user = $row['username'];
          $text = $row['text'];
          $date = $row['date']; $retweet = $row['retweet'];
          $id = $row['id'];
          $Id=$id;
          $profile = "";
          $result2 = $conn->query("SELECT profile FROM users WHERE username='$user'");
          while ($row2 = $result2->fetch_assoc()) {
            $profile = $row2['profile'];
          }
          if ($profile === "public/user.png") 
            $profile="http://localhost/php-twitter/public/user.png";
          echo "
        <article class=\"twit\">
        <div class=\"twit-content\">
        <img class=\"twit-avatar\" src=\"//localhost/php-twitter/$profile\"></img>
        <p class=\"twit-author\">
        <b><a href=\"http://localhost/php-twitter/user/$user\">$user</a> </b>" ?> <?php if($retweet!==NULL) echo "ری‌توییت شده از <a class=\"retweet-link\" href=\"http://localhost/php-twitter/user/$retweet\">$retweet</a>"; echo "
      </p>
      <p id=\"text-c\">
          <a href=\"http://localhost/php-twitter/tweet/$id\" class=\"twit-text\">
            $text
          </a>
        </p>
        <div class=\"btn-cont\">
          <i class=\"btn fa-regular fa-heart like\" id=\"like-$id\" onclick=\"like($id)\"></i>
          <p id=\"like-num-$id\" class=\"btn like-num\"> </p>
          <i class=\"btn fa-solid fa-retweet retweet\" id=\"retweet-$id\"></i>
          <i class=\"btn fa-solid fa-share-nodes share\" id=\"share-$id\"></i>
          <i class=\"fa-regular fa-comment com-btn\" id=\"com-$id\"></i></a>
          <p id=\"com-num-$id\" class=\"com-num btn\"></p>
          ";
          if (isset($_SESSION['username']) && $user === $_SESSION['username']) {
            echo "
          <p id=\"delete-$id\" class=\"btn delete\">حذف</p>";
          }
          echo " 
          </div>
          <p id=\"date\" class=\"date\"> $date </p>
        </div>
      </article>
      ";
        }
      } else {
        echo "tweet not found";
      }
    }
    $id = $_GET['id'];
    tweets("SELECT * FROM tweet WHERE id=$id");
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
    <?php if(isset($_SESSION['username'])){?>
      <input id="comment" name="text" placeholder="نظر شما چیست؟">
      <i class="fa-solid fa-paper-plane fa-xl plane comment-btn"></i>
    <?php }?>
    <div class="comment-cont"></div>
  </main>

  <button type="button" id="create-twit-button"><i class="fas fa-plus"></i></button>

  <div id="modal-backdrop" class="hidden"></div>
  <div id="create-twit-modal" class="hidden">
    <div class="modal-dialog">

      <div class="modal-header">
        <h3>Create a Tweet</h3>
        <button type="button" class="modal-close-button">&times;</button>
      </div>
      <form action="/php-twitter/http://localhost:/php-twitter/api/tweet" method="post">
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
  let element = document.querySelector(".comment-btn")
  console.log("k"+location.href.split("/")[5]);
  function comment() {
    if(document.getElementById('comment').value!==''){
    $.ajax({
      type: "POST",
      url: "http://localhost/php-twitter/api/comment.php",
      data: {id : location.href.split("/")[5], text:document.getElementById('comment').value},
      dataType: "text",
      success: function(msg) {
        console.log(msg);
        location.reload()
      }
    })}
  }
  element.addEventListener("click",(e)=>{
    comment();
  })
  document.getElementById("comment").addEventListener("keypress",(e)=>{
    if(e.key==="Enter")
      comment();
  })
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
      url: "http://localhost:/php-twitter/api/like-count.php",
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
      url: "http://localhost:/php-twitter/api/like.php",
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
  let del=document.querySelectorAll(".delete")
  for (let o = 0; o < del.length; o++) {
    const element = del[o];
    let id = element.id.split("-")[1]
    element.addEventListener("click",(e)=>{
    $.ajax({
      type: "POST",
      url: "http://localhost:/php-twitter/api/delete.php",
      data: "id=" + id,
      dataType: "text",
      success: function(msg) {
        console.log(msg);
        location.reload()
      }
    })
  })}
  let share = document.querySelectorAll(".share")
  for (let o = 0; o < share.length; o++) {
    const element = share[o];
    let id = element.id.split("-")[1];
    element.addEventListener("click", (e) => {
      let alert = document.querySelector(".alert")
      if(alert.style.display=="none"){
        alert.style.display="block";
      }
      alert.innerHTML='<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> لینک اشتراک‌گذاری: localhost/php-twitter/tweet/'+id;
      
    })}
    $.ajax({
      type: "POST",
      url: "http://localhost/php-twitter/api/get-comment.php",
      data: {id : location.href.split("/")[5]},
      dataType: "text",
      success: function(msg) {
        try{
        let x=JSON.parse(msg);
        console.log(x);
        let obj = x.data;
        obj.forEach(el=> {
          document.querySelector(".comment-cont").innerHTML+=`
          <div class="comment-box">
          <img class="profile" src="//localhost/php-twitter/${el.profile}"></img>
          <a href="//localhost/php-twitter/user/${el.user}" class="author">${el.user} نوشت:</a>
          <p class="comment-text">${el.text}</p>
          </div>
          `
        });
        }catch(e){

        }
      }
    })
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
        console.log("hello");
      }
    })
  })
</script>

<?php
if (isset($_GET['q'])) {
  $query = $_GET['q'];
  clearTweets();
  tweets("SELECT * FROM tweet WHERE (`text` LIKE \"%$query%\") ORDER BY date DESC LIMIT 0,25");
}
