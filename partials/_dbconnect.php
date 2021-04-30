<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'iDiscuss';
$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn) {
    die("Unable to connect to database" . mysqli_connect_error());
} 
?>