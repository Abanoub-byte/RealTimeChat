<?php
session_start();
$outgoing_id = $_SESSION['unique_id'];

$query2 = "SELECT * FROM messages WHERE (receiver_msg_id = $1) OR (sender_msg_id = $2) AND (sender_msg_id = $3) OR (sender_msg_id = $4)
ORDER BY id DESC LIMIT 1";
$result2 = pg_prepare($conn, "get_last_msg", $query2);

while($user = pg_fetch_assoc($result)){
    $result2 = pg_execute($conn, "get_last_msg", [$user['id'],$user['id'], $outgoing_id, $outgoing_id ]);
    $message = "";
    if(pg_num_rows($result2) > 0){
        $result2 = pg_fetch_assoc($result2);
        $message = $result2['msg'];
    }else{
        $message = " ";
    }


    //timming messages...
    (strlen($message) < 28) ? $msg = substr($message, 0 , 28) : $msg = $message;

    if($_SESSION['unique_id'] == $user['id']){
        $output.= "";
    }else{
    $output .= '<a href="chat.php?id='.$user['id'].'">
        <div class="content">
        <img src="../uploads/'. $user["user_image"].'" alt="">
        <div class="details">
        <span> '. $user["first_name"] . " ". $user["last_name"] . '</span>
        <p> '. $msg .'</p>
        </div>
        </div>
        <div class="status-dot"><i class="fas fa-circle"></i></div>
    </a>';
    }
}