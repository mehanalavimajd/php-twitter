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
            $profile = $row['profile'];
            $bio = $row['bio'];
            $city = $row['city'];
    ?>
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.1/css/all.css" crossorigin="anonymous">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <link rel="stylesheet" href="/php-twitter/public/style.css" media="screen">
            <section style="background-color: #eee;">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <img style="width:100px; height:100px;" src="http://localhost/php-twitter/<?php echo $profile ?>">
                                <h3 class="my-3"><?php echo $user; ?></h5>
                                    <p id="followyou"></p>
                                    <p class="text-muted mb-1"><?php echo $bio; ?></p>
                                    <p class="text-muted mb-4"><?php echo $city; ?></p>
                                    <p class="mb-4" id="f-num"></p>
                                    <?php if ($_SESSION['username'] != $user) { ?>
                                        <div class="d-flex justify-content-center mb-2">
                                            <button type="button" id="follow-btn" class="btn btn-primary nop" onclick="follow('<?php echo $user; ?>')">دنبال‌کردن</button>
                                            <button type="button" class="btn btn-outline-primary ms-1 nop siuuu">ارسال پیام</button>
                                        </div>
                                    <?php } ?>
                            </div>
                        </div>

            </section>
    <?php }
    } ?>
    <script src="/php-twitter/public/jquery.js"></script>
    <script>
        <?php if ($_SESSION['username'] !== $_GET['user']) { ?>
            $.ajax({

                type: "POST",
                url: "http://localhost/php-twitter/api/follow-count.php",
                data: "user=" + '<?php echo $user ?>' + ' ' + '<?php echo $_SESSION["username"] ?>',
                dataType: "text",
                success: function(msg) {
                    console.log(msg);
                    $(document).ready(() => {
                        document.getElementById("f-num").innerText = "تعداد دنبال‌کننده‌ها: " + msg.split("-")[1];
                        let x = "unfollow" ? String(msg).includes("u") : "follow";
                        if (x)
                            document.getElementById('follow-btn').innerText = "توقف دنبال";
                        else
                            document.getElementById('follow-btn').innerText = "دنبال‌کردن";
                    })
                }
            })

            function follow(u) {
                $.ajax({
                    type: "POST",
                    url: "http://localhost/php-twitter/api/follow.php",
                    data: "u=" + u + ' ' + '<?php echo $_SESSION["username"] ?>',
                    dataType: "text",
                    success: function(msg) {
                        console.info(msg);
                        setTimeout(() => {

                        }, 200);
                        document.getElementById("f-num").innerText = "followers: " + msg.split('-')[1];
                        let x = "unfollow" ? String(msg).includes("u") : "follow";
                        if (x)
                            document.getElementById('follow-btn').innerText = "دنبال‌ کردن";
                        else
                            document.getElementById('follow-btn').innerText = "توقف‌دنبال";
                    }
                })
            }
        <?php } ?>
        // ----------------------- likes
        setTimeout(() => {
            let buttons = document.querySelectorAll('i')
            console.log(buttons);

            for (let i = 0; i < buttons.length; i++) {
                const element = buttons[i];
                let id = parseInt(element.id.replace("like-", ""))
                if (localStorage.getItem("liked-" + id) == 'true') {
                    document.querySelector("#like-" + id).classList.replace("fa-regular", "fa-solid")
                    document.querySelector("#like-" + id).style.color = 'red';

                }
                $.ajax({
                    type: "POST",
                    url: "http://localhost/php-twitter/api/like-count.php",
                    data: "id=" + id,
                    dataType: "text",
                    success: function(msg) {
                        if (id !== NaN && msg != "") {
                            document.getElementById("like-num-" + id).innerText = msg;
                        }
                        console.log(msg + " " + id)
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
                        document.querySelector("#like-" + id).classList.replace("fa-regular", "fa-solid")
                        document.querySelector("#like-" + id).style.color = 'red';
                        localStorage.setItem("liked-" + id, "true")
                        document.getElementById("like-num-" + id).innerText = msg.split("-")[1];
                    } else {
                        document.querySelector("#like-" + id).classList.replace("fa-solid", "fa-regular")
                        document.querySelector("#like-" + id).style.color = 'black';
                        localStorage.removeItem("liked-" + id)
                        document.getElementById("like-num-" + id).innerText = msg.split("-")[1];
                    }
                    console.log(msg);
                }
            })
        }
        setTimeout(() => {
            let del = document.querySelectorAll(".delete")
            for (let o = 0; o < del.length; o++) {
                const element = del[o];
                let id = element.id.split("-")[1]
                element.addEventListener("click", (e) => {
                    $.ajax({
                        type: "POST",
                        url: "//localhost/php-twitter/api/delete.php",
                        data: "id=" + id,
                        dataType: "text",
                        success: function(msg) {
                            location.reload()
                        }
                    })
                })
            }
            let ret = document.querySelectorAll(".retweet")
            for (let o = 0; o < ret.length; o++) {
                const element = ret[o];
                let id = element.id.split("-")[1]
                element.addEventListener("click", (e) => {
                    $.ajax({
                        type: "POST",
                        url: "//localhost/php-twitter/api/retweet.php",
                        data: "id=" + id,
                        dataType: "text",
                        success: function(msg) {
                            console.log(msg);
                            location.reload();
                        }
                    })
                })

                let share = document.querySelectorAll(".share")
                for (let o = 0; o < share.length; o++) {
                    const element = share[o];
                    let id = element.id.split("-")[1];
                    element.addEventListener("click", (e) => {
                        let alert = document.querySelector(".alert")
                        if (alert.style.display == "none") {
                            alert.style.display = "block";
                        }
                        alert.innerHTML = '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> لینک اشتراک‌گذاری: localhost/php-twitter/tweet/' + id;

                    })
                }
            }
        }, 1000);
        // follows you
        let json;

        $.ajax({
            type: "POST",
            url: "http://localhost/php-twitter/api/followsyou.php",
            data: "u1=" + "<?php echo $user ?>",
            dataType: "json",
            success: function(msg) {
                json = msg;
                var user = "<?php echo $_SESSION['username'] ?>";
                var f=0;
                json.data.forEach(element => {
                    if(element===user)
                        f=1;
                });
                if(f==1)
                    document.getElementById("followyou").innerHTML="شما را دنبال می کند"
            }

        })
    </script>
</body>

</html>