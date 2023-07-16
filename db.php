<?php 
 // Replace with your MySQL database credentials, if you midify this file, do NOT push it
 $db_host = "localhost";
 $db_user = "root"; // Default username
 $db_pass = "";     // Default password is empty
 $db_name = "bookhive"; // Your database name (if you've already created it)

 // Create a connection
 $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

 if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
 }
?>
