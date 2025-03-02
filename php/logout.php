<?php
session_start();

if(isset($_SESSION['unique_id'])){
    include_once "config.php";
    $loggedout_user_id = pg_escape_string($conn, $_GET['logout_id']);
    echo $loggedout_user_id;
    if(isset($loggedout_user_id)){
        $status = "offline";

        $query  = "UPDATE users SET status = $1 WHERE id = $2  ";
        $stmt = pg_prepare($conn, "update_status", $query);
        $result = pg_execute($conn, "update_status", [$status, $loggedout_user_id]);
        
        if($result){
            session_unset();
            session_destroy();
            header("location: ../login.php");
        }
    }else{
        header("location: ../users.php");
    }
}else{
    header("location: ../login.php");
}


?>