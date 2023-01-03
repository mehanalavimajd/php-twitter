<button id="follow-btn" onclick="follow('<?php echo $user ?>')">
    Follow
</button>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
function follow(u) {
    $.ajax({
        type:"POST",
        url:"http://localhost/php-twitter/api/follow.php",
        data:"u="+u,
        dataType:"text",
        success: function (msg) {
            console.log(msg);
        }
    })
}
</script>