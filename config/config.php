<?php 
session_start();
$host = 'localhost';
$dbname = 'note-app';
$username = 'nater';
$password = 'nater123';

$connection = mysqli_connect($host, $username, $password, $dbname);
if(!$connection){
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully";
}
?>
