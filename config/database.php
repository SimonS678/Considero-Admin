<?php
$host ="db1547.1und1.de";
$username = "dbo250310088";
$password = "a9fpubF8";
$db_name = "db250310088";

$host ="localhost";
$username = "root";
$password = "root";
$db_name = "considero";


try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
} catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}
