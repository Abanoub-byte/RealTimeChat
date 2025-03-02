<?php
require_once "config.php";
session_start();

$email = $_POST['email'] ?? null;
$pwd = $_POST['password'] ?? null;

if(empty($email) || empty($pwd)){
    die("Email and password are required.");
}


$query = "SELECT id, password FROM users WHERE email = $1";
$stmt = pg_prepare($conn, "find_user", $query);
$result = pg_execute($conn, "find_user", [$email]);


if($result && pg_num_rows($result) > 0){
    
    $user = pg_fetch_assoc($result);
    $status = "online";
    $query  = "UPDATE users SET status = $1 WHERE id = $2  ";
    $stmt = pg_prepare($conn, "update_status", $query);
    if(!$stmt){
        die(" Failed .." . pg_last_error($conn));
    }
    $result = pg_execute($conn, "update_status", [$status, $user['id']]);
    

    if(password_verify($pwd, $user['password'])){
        $_SESSION['unique_id'] = $user['id'];
        
        echo "success";
    }else{
        echo "invalid email or password";
    }
}else{
    echo "email or password is not correct";
}

?>