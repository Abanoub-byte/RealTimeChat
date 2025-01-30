<?php
session_start();
while($user = pg_fetch_assoc($result)){
   
    if($_SESSION['unique_id'] == $user['id']){
        $output.= "";
    }else{
    $output .= '<a href="">
        <div class="content">
        <img src="../uploads/'. $user["user_image"].'" alt="">
        <div class="details">
        <span> '. $user["first_name"] . " ". $user["last_name"] . '</span>
        <p>This is test message.</p>
        </div>
        </div>
        <div class="status-dot"><i class="fas fa-circle"></i></div>
    </a>';
    }
}