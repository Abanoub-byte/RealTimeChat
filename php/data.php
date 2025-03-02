<?php
session_start();
if(isset($_SESSION['unique_id'])){
$outgoing_id = $_SESSION['unique_id'];

$query2 = "
    SELECT * FROM messages 
    WHERE 
        (receiver_msg_id = $1 AND sender_msg_id = $2) 
        OR (sender_msg_id = $1 AND receiver_msg_id = $2)
    ORDER BY id DESC 
    LIMIT 1;
";
$result2 = pg_prepare($conn, "get_last_msg", $query2);

while ($user = pg_fetch_assoc($result)) {
    $result2 = pg_execute($conn, "get_last_msg", [$user['id'], $outgoing_id]);
    $user2 = pg_fetch_assoc($result2);

    if (pg_num_rows($result2) > 0) {
        // Conversation exists → show the last message
        $message = ($user2['sender_msg_id'] == $outgoing_id || $user2['receiver_msg_id'] == $outgoing_id) 
            ? $user2['msg'] 
            : ""; // Hide message if not a participant
    } else {
        // No conversation → message should be empty
        $message = "";
    }

    // Shorten long messages
    $msg = (strlen($message) < 28) ? $message : substr($message, 0, 28) . '...';

    // Hide logged-in user from list
    if ($_SESSION['unique_id'] == $user['id']) {
        continue;
    }

    $you = "";
    
    if( $user2 && isset($user2['sender_msg_id']) && $outgoing_id == $user2['sender_msg_id']){
        $you = "You: ";
    }
    ($user['status'] == "offline")? $offline = "offline": $offline = "";

    $output .= '
    <a href="chat.php?id=' . $user['id'] . '">
        <div class="content">
            <img src="../uploads/' . $user["user_image"] . '" alt="">
            <div class="details">
                <span>' . $user["first_name"] . " " . $user["last_name"] . '</span>
                <p>' . $you . htmlspecialchars($msg) . '</p> 
            </div>
        </div>
        <div class="status-dot '. $offline . ' "><i class="fas fa-circle"></i></div>
    </a>';
}
}