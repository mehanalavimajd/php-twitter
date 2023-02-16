<?php if($user != $_SESSION['username']){ ?>
<button id="follow-btn" onclick="follow('<?php echo $user ?>')">
    Follow
</button>
<?php } ?>
<p>followers:</p> <p id="f-num"></p>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
$.ajax({
        type:"POST",
        url:"http://localhost/php-twitter/api/follow-count.php",
        data:"user="+'<?php echo $user ?>',
        dataType:"text",
        success: function (msg) {
            console.log(msg);
            document.getElementById("f-num").innerText=msg.split("-")[1];
            let x = "unfollow"?String(msg).includes("u"):"follow";
            if (x)
                document.getElementById('follow-btn').innerText="Unfollow";
            else
                document.getElementById('follow-btn').innerText="Follow";
        }
    })
function follow(u) {
    $.ajax({
        type:"POST",
        url:"http://localhost/php-twitter/api/follow.php",
        data:"u="+u,
        dataType:"text",
        success: function (msg) {
            console.log(msg);
            document.getElementById("f-num").innerText=msg.split('-')[1];
            let x = "unfollow"?String(msg).includes("u"):"follow";
            if(x)
            document.getElementById('follow-btn').innerText="Follow";
            else
            document.getElementById('follow-btn').innerText="UnFollow";
        }
    })
}
// ----------------------- likes
setTimeout(() => {
    let buttons = document.querySelectorAll('button')
console.log(buttons);
for (let i = 0; i < buttons.length; i++) {
    const element = buttons[i];
    let id = parseInt(element.id.replace("like-",""))
    if(localStorage.getItem("liked-"+id)=='true'){
        element.style.backgroundColor="red";
        console.log(id);
    }
    $.ajax({
        type:"POST",
        url:"http://localhost/php-twitter/api/like-count.php",
        data:"id="+id,
        dataType:"text",
        success: function (msg) {
            $(document).ready(
                function(){
                    document.getElementById("like-num-"+id).innerText=msg;
                }
            );

        }
    })
}
}, 1000);

function like(id){
    $.ajax({
        type:"POST",
        url:"http://localhost/php-twitter/api/like.php",
        data:"id="+id,
        dataType:"text",
        success: function (msg) {
            if(String(msg).includes("l")){
                document.getElementById("like-"+id).style.backgroundColor="red";
                localStorage.setItem("liked-"+id,"true")
                document.getElementById("like-num-"+id).innerText=msg.split("-")[1];
            }else{
                document.getElementById("like-"+id).style.background="none";
                localStorage.removeItem("liked-"+id)
                document.getElementById("like-num-"+id).innerText=msg.split("-")[1];
            }
            console.log(msg);
        }
    })
}
</script>