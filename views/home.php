<?php
    ini_set('error_reporting',E_ALL);
    ini_set('display_errors',1);
session_start();
    if(isset($_SESSION['username'])){
        echo "Welcome " . $_SESSION['username'];
        echo "<br>";
        echo '<a href="/php-twitter/logout">Logout from here</a>';
        ?>
        <form action="/php-twitter/api/tweet" method="post">
            <input type="text" name="text">
            <button type="submit">Tweet!</button>
        </form>

    <?php
    
    }else{
        echo "You aren't logged in";
        echo "<br>";
        echo '<a href="/php-twitter/login">Login from here</a>';
    }
    $conn = new mysqli("localhost", "mehan", "mehan1388","login");
    $sql = "SELECT * FROM tweet ORDER BY date DESC LIMIT 0,25";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $user = $row['username'];
        $text = $row['text'];
        $date = $row['date'];
        $id = $row['id'];
        echo "
        <p style=\"opacity:40%\">$date</p>
        <b> <a href=\"user/$user\">$user</a> wrote:</b>
        <p style=\"margin-left:40px\"> $text </p>
        <button class=\"likes\" id=\"likes-$id\" onclick=\"like($id)\">like</button>
        <p id=\"like-num-$id\"> </p>
        ";
    }
    } else {
    echo "0 results";
}
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    
    <!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">
    <title>Tweeter</title>

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
    
      <a href="#"><h1 class="site-title">
      <b>UTA</b> tweeter</a>
      </h1>
      <nav class="navbar">
        <ul class="navlist">
          <li class="navitem navlink active"><a href="/">Home</a></li>
          <li class="navitem navlink"><a href="/php-twitter/following">Following</a></li>
          <li class="navitem navlink"><a href="/php-twitter/trending">Trending</a></li>
          <li class="navitem navbar-search">
            <input type="text" id="navbar-search-input" placeholder="Search...">
            <button type="button" id="navbar-search-button"><i class="fas fa-search"></i></button>
            
            <?php
            if(isset($_SESSION['username'])){
              $username = $_SESSION['username'];
              echo "<a id=\"username\" href=\"/php-twitter/user/$username\">$username</a>";
            ?>
          <?php
        
          }else{
            echo "<a id=\"username\" href=\"/php-twitter/twitter\">Login</a>";
          }
          ?>
            
            
          </li>
        </ul>
      </nav>
    </header>

    <main class="twit-container">

    <?php
    
    $conn = new mysqli("localhost", "mehan", "mehan1388","login");
    $sql = "SELECT * FROM tweet ORDER BY date DESC LIMIT 0,25";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
        $user = $row['username'];
        $text = $row['text'];
        $date = $row['date'];
        $id = $row['id'];
        echo "
        <article class=\"twit\">
        <div class=\"twit-icon\">
          <i class=\"fas fa-bullhorn\"></i>
        </div>
        <div class=\"twit-content\">
          <p class=\"twit-text\">
            $text
          </p>
          <p class=\"twit-author\">
            <a href=\"/php-twitter/user/$user\">$user</a>
          </p>
          <i class=\"fa-regular fa-heart like\" id=\"like-$id\" onclick=\"like($id)\"></i>
        </div>
      </article>
      ";
      }
    }
     else {
    echo "0 results";
}
?>

    </main>

    <button type="button" id="create-twit-button"><i class="fas fa-bullhorn"></i></button>

    <div id="modal-backdrop" class="hidden"></div>
    <div id="create-twit-modal" class="hidden">
      <div class="modal-dialog">

        <div class="modal-header">
          <h3>Create a Twit</h3>
          <button type="button" class="modal-close-button">&times;</button>
        </div>

        <div class="modal-body">
          <div class="twit-input-element">
            <label for="twit-text-input">Twit text</label>
            <textarea id="twit-text-input"></textarea>
          </div>
          <div class="twit-input-element">
            <label for="twit-attribution-input">Author</label>
            <input type="text" id="twit-attribution-input">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="modal-cancel-button">Cancel</button>
          <button type="button" class="modal-accept-button">Create Twit</button>
        </div>

      </div>
    </div>

  </body>

</html>
<script>
        // sending like request to api
        setTimeout(() => {
          let buttons = document.querySelectorAll('.like')

        console.log(buttons);
        for (let i = 0; i < buttons.length; i++) {
            const element = buttons[i];
            console.log(element);
            let id = parseInt(element.id.replace("like-",""))
            console.log("t");
            if(localStorage.getItem("liked-"+id)=='true'){
              document.querySelector("#like-"+id).classList.replace("fa-regular","fa-solid")
              document.querySelector("#like-"+id).style.color='red';  
                console.log(id);
            }
            console.log(id);
            $.ajax({
                type:"POST",
                url:"api/like-count.php",
                data:"id="+id,
                dataType:"text",
                success: function (msg) {
                    document.getElementById("like-num-"+id).innerText=msg;
                }
            })
        }
        }, 1400);
       
        function like(id){
            $.ajax({
                type:"POST",
                url:"api/like.php",
                data:"id="+id,
                dataType:"text",
                success: function (msg) {
                    if(String(msg).includes("l")){
                        document.querySelector("#like-"+id).classList.replace("fa-regular","fa-solid")
                        document.querySelector("#like-"+id).style.color='red';
                        localStorage.setItem("liked-"+id,"true")
                        document.getElementById("like-num-"+id).innerText=msg.split("-")[1];
                    }else{
                      document.querySelector("#like-"+id).classList.replace("fa-solid","fa-regular")
                      document.querySelector("#like-"+id).style.color='black';
                        localStorage.removeItem("liked-"+id)
                        document.getElementById("like-num-"+id).innerText=msg.split("-")[1];
                    }
                  console.log(msg);
                }
            })
        }
    </script>