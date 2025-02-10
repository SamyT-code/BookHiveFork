<?php
// Clever Cloud MySQL Database Credentials
$db_host = "bu7trjlsx3hp2pm1uxbw-mysql.services.clever-cloud.com";
$db_user = "u4jfsnt4yopnllml";
$db_pass = "DaUH3UpXuyg1HogqJqaK";
$db_name = "bu7trjlsx3hp2pm1uxbw";
$db_port = "3306";  // Clever Cloud uses port 3306

// Create a connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}