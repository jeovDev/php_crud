<?php

$server = "localhost";
$user = "root";
$pass = "";
// $database = "bookdb";

$conn = new mysqli($server,$user,$pass);

if($conn->connect_error){
    die("connection error at " . $conn->connect_error);
}
$db = "CREATE DATABASE IF NOT EXISTS bookdb";
if($conn->query($db)==FALSE){
    return true;
}

$tbl = "CREATE TABLE IF NOT EXISTS bookdb.book_tbl (book_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, cat_id VARCHAR(30) NOT NULL ,book VARCHAR(50) NOT NULL, author VARCHAR(100) NOT NULL, publish VARCHAR(100) NOT NULL)";
$tbl1 = "CREATE TABLE IF NOT EXISTS bookdb.cat_tbl (cat_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, cat_name VARCHAR(40) NOT NULL)";

$conn->query($tbl);
$conn->query($tbl1);
 



?>