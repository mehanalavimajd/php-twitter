<?php
$user = $_GET['user'];
?>
<html>
<link rel="stylesheet" href="/php-twitter/public/style.css">

<body>
    <p id="title-follow"> دنبال کنندگان <?php echo $user; ?>:</p>
    <table id="table">
    </table>
</body>
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
            data.forEach(e => {
                $.ajax({
                    type: "POST",
                    url: "http://localhost/php-twitter/api/getprofile.php",
                    data: "user=" + e,
                    dataType: "text",
                    success: (profile) => {
                        console.log(profile);
                        let row = document.getElementById("table")
                        let cell = document.createElement("tr");
                        cell.innerHTML=
                        `
                        <img class="follow-profile" src="//localhost/php-twitter/${profile}"></img>
                        <p class="user-follow">${e}</p>
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