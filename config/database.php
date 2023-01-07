<?php

$host ="localhost";
$username = "root";
$password = "root";
$db_name = "considero";


try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
} catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}
