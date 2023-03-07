<!DOCTYPE html>
<html>
    <body>
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
        $profile=$row['profile']
?>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.1/css/all.css" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/php-twitter/public/style.css" media="screen">
        <section style="background-color: #eee;">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="http://localhost/php-twitter/<?php echo $profile?>">
                            <h3 class="my-3"><?php echo $user; ?></h5>
                                <p class="text-muted mb-1">Full Stack Developer</p>
                                <p class="text-muted mb-4">Bay Area, San Francisco, CA</p>
                                <p class="mb-4" id="f-num"></p>
                                <div class="d-flex justify-content-center mb-2">
                                    <button type="button" id="follow-btn" class="btn btn-primary" onclick="follow('<?php echo $user; ?>')">Follow</button>
                                    <button type="button" class="btn btn-outline-primary ms-1">Message</button>
                                </div>
                        </div>
                    </div>

        </section>
<?php }
} ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
    $.ajax({

        type: "POST",
        url: "http://localhost/php-twitter/api/follow-count.php",
        data: "user=" + '<?php echo $user ?>' + ' ' + '<?php echo $_SESSION["username"] ?>',
        dataType: "text",
        success: function(msg) {
            console.log(msg);
            $(document).ready(()=>{
                document.getElementById("f-num").innerText = "followers: "+msg.split("-")[1];
                let x = "unfollow" ? String(msg).includes("u") : "follow";
                if (x)
                    document.getElementById('follow-btn').innerText = "Unfollow";
                else
                    document.getElementById('follow-btn').innerText = "Follow";
            })
        }
    })

    function follow(u) {
        $.ajax({
            type: "POST",
            url: "http://localhost/php-twitter/api/follow.php",
            data: "u=" +u + ' ' + '<?php echo $_SESSION["username"] ?>',
            dataType: "text",
            success: function(msg) {
                console.info(msg);
                setTimeout(() => {
                    
                }, 200);
                document.getElementById("f-num").innerText = "followers: "+msg.split('-')[1];
                let x = "unfollow" ? String(msg).includes("u") : "follow";
                if (x)
                    document.getElementById('follow-btn').innerText = "Follow";
                else
                    document.getElementById('follow-btn').innerText = "UnFollow";
            }
        })
    }
    // ----------------------- likes
    setTimeout(() => {
        let buttons = document.querySelectorAll('button')
        console.log(buttons);
        for (let i = 0; i < buttons.length; i++) {
            const element = buttons[i];
            let id = parseInt(element.id.replace("like-", ""))
            if (localStorage.getItem("liked-" + id) == 'true') {
                element.style.backgroundColor = "red";
                console.log(id);
            }
            $.ajax({
                type: "POST",
                url: "http://localhost/php-twitter/api/like-count.php",
                data: "id=" + id,
                dataType: "text",
                success: function(msg) {
                    $(document).ready(
                        function() {
                            document.getElementById("like-num-" + id).innerText = msg;
                        }
                    );

                }
            })
        }
    }, 1000);

    function like(id) {
        $.ajax({
            type: "POST",
            url: "http://localhost/php-twitter/api/like.php",
            data: "id=" + id,
            dataType: "text",
            success: function(msg) {
                if (String(msg).includes("l")) {
                    document.getElementById("like-" + id).style.backgroundColor = "red";
                    localStorage.setItem("liked-" + id, "true")
                    document.getElementById("like-num-" + id).innerText = msg.split("-")[1];
                } else {
                    document.getElementById("like-" + id).style.background = "none";
                    localStorage.removeItem("liked-" + id)
                    document.getElementById("like-num-" + id).innerText = msg.split("-")[1];
                }
                console.log(msg);
            }
        })
    }
</script>
    </body>
</html>
