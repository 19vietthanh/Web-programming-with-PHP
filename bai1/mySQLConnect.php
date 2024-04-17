<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classicmodels";
$mysqli = new mysqli($servername, $username, $password, $dbname);
if($mysqli->connect_error){
    die("Connection failed" . $mysqli_connect_error);
}
?>