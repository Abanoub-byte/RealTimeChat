<?php

$server_name = "localhost";
$port = "5432";
$user = "bob";
$pwd = "123";
$db_name = "chat_app";

$conn_str = "host=$server_name port=$port dbname=$db_name password=$pwd";
$conn = pg_connect($conn_str);

if($conn){
    error_log("Connected!");
}else{
    error_log("Can not connect to the database") . pg_connect_error();
}