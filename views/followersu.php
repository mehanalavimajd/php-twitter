<?php
$user = $_GET['user'];
session_start();
?>
<html>
<link rel="stylesheet" href="/php-twitter/public/style.css">

<body>
    <p id="title-follow"> دنبال کنندگان <?php echo $user; ?>:</p>
    <table id="table">
    </table>
</body>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/php-twitter/public/jquery.js"></script>
<script>
    $.ajax({
        type: "POST",
        url: "http://localhost/php-twitter/api/followers.php",
        data: "user=" + "<?php echo $user ?>",
        dataType: "json",
        success: (msg) => {
            let data = msg['data'];
            console.log(data);
            let s="";
            data.forEach(e => {
                $.ajax({
                    type:"POST",
                    url:"http://localhost/php-twitter/api/followsyou.php",
                    data:{u1:e, u2:"<?php echo $_SESSION['username']?>"},
                    dataType:"text",
                    success:(msg)=>{if(msg=="1"){s="شما را دنبال می کند"}}
                })
                $.ajax({
                    type: "POST",
                    url: "http://localhost/php-twitter/api/getprofile.php/",
                    data: "user=" + e,
                    dataType: "text",
                    success: (profile) => {
                        console.log(profile);
                        let row = document.getElementById("table")
                        let cell = document.createElement("tr");
                        cell.innerHTML =
                        `
                        <img class="follow-profile" src="//localhost/php-twitter/${profile}"></img>
                        <p class="user-follow">${e}</p>
                        `
                        if(s!="" )
                            cell.innerHTML+=`<p class="follow-you">${e}</p>`;
                        cell.innerHTML+=  `
                        <button class="view-page-btn btn btn-outline-primary ms-1 nop siuuu" onclick="window.location.href='//localhost/php-twitter/user/<?php echo $user?>';">مشاهده پروفایل</button>
                        <button class="view-page-btn btn btn-primary nop">ارسال‌پیام</button>
                        <i class="line-i "></i>
                        `
                        row.appendChild(cell)
                        console.log(88);
                    }
                })
            });
        }
    })
</script>

</html>