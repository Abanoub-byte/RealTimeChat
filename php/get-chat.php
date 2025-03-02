<?php 
session_start();

if(isset($_SESSION['unique_id'])){
    include_once "config.php";

    $sender_id = pg_escape_string($conn, $_POST['sender_id']);
    if(isset($sender_id)){
        $query = "SELECT * FROM users WHERE id = $1";
        $stmt = pg_prepare($conn, "find_user", $query);
        $result = pg_execute($conn, "find_user", [$sender_id]);
        $get_user = pg_fetch_assoc($result);
    }


    
    $receiver_id = pg_escape_string( $_POST['receiver_id']);
   
    if(!empty($receiver_id)){
        $query = "SELECT * FROM users WHERE id = $1";
        $stmt = pg_prepare($conn, "get_receiver", $query);
        $result2 = pg_execute($conn, "get_receiver", [$receiver_id]);
        $receiver = pg_fetch_assoc($result2);
    }
    $output = "";


    if(!empty($sender_id)){
        $query = "SELECT * FROM messages 
        WHERE (receiver_msg_id = $1 AND sender_msg_id = $2) 
           OR (receiver_msg_id = $2 AND sender_msg_id = $1) 
        ORDER BY id ASC";

        $stmt = pg_prepare($conn, "fetch_messages", $query);
            if (!$stmt) {
            die("Error preparing statement: " . pg_last_error($conn));
            }
            $result = pg_execute($conn, "fetch_messages", [$receiver_id, $sender_id]);
        if($result){
            while($user = pg_fetch_assoc($result)){
            if($user['sender_msg_id'] === $receiver_id){

                $output .= '<div class="chat incoming ">
                            <img src="uploads/'.$receiver['user_image'].'" alt="">
                            <div class="details">
                            <p>'. $user['msg'].'</p>
                            </div>
                            </div>';
            }else{
                $output .= '<div class="chat outgoing">
                             <div class="details">
                            <p>' .$user['msg']. '</p>
                             </div>
                            </div>';

            }
        }
        echo $output; 
    }
}
}else{
    header("location:../login.php");
}

?>