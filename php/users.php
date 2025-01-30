<?php

include_once "config.php";

$query = "SELECT * FROM users";
$output = "";

$stmt = pg_prepare($conn, "get_users", $query);

if(!$stmt){
    die("error connecting to the database". preg_last_error($conn));
}else{
    $result = pg_execute($conn, "get_users", []);
    if(pg_num_rows($result)> 0){
        include "data.php";
    }else{
        $output .= "No users are available.";
    }
}
echo $output;

?>