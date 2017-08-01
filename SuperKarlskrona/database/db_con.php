<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "superkarlskrona";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//mysql_query("set names utf8");
date_default_timezone_set("Europe/Stockholm");
?>
