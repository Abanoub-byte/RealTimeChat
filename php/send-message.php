<?php

session_start();
if(isset($_SESSION['unique_id'])){
    include_once "config.php";

    if(isset($_POST['sender_id'])){

        $sent_id = pg_escape_string($conn, $_POST['sender_id']);
    }

    if(isset($_POST['receiver_id'])){

        $received_id = pg_escape_string($conn, $_POST['receiver_id']);
        
    }

    if(isset($_POST['message'])){

        $message = pg_escape_string($conn, $_POST['message']);
    }

    if(!empty($message)){
        $query = "INSERT INTO messages (receiver_msg_id, sender_msg_id, msg) VALUES ($1, $2, $3)";
        $stmt = pg_prepare($conn, "insert_msg", $query);
        if(!$stmt){
            echo "error connecting to the db". preg_last_error($conn);
        }
        $result = pg_execute($conn, "insert_msg", [$received_id, $sent_id, $message]);
        if($result){
            echo "success";
        }
    }
}else{
    header("location:../login.php");
}


?>