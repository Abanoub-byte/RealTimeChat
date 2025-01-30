<?php

    include_once "config.php";
    $searchTerm = pg_escape_string($conn, $_POST['searchTerm']);

    $query = "SELECT * FROM users WHERE first_name = $1";
    $stmt = pg_prepare($conn, "search_term", $query);
    $result = pg_execute($conn, "search_term", [$searchTerm]);
    
    $output = "";
    if(pg_num_rows($result)> 0){
         include "data.php";

    }else{
        $output .= "No user found";
    }

    echo $output;
?>