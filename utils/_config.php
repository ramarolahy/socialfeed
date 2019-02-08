<?php 
ob_start(); // Turns on output buffering
// If there is no session yet, start a new one
if(!isset($_SESSION)) { 
    session_start(); 
} 

$timezone = date_default_timezone_set("America/Denver"); // Set default timezone

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "social";

// https://www.w3schools.com/php/func_mysqli_connect.asp
// create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// check connection
if (mysqli_connect_errno()) {
    echo "\nFailed to connect to MYSQL:" . mysqli_connect_errno();
}
?>