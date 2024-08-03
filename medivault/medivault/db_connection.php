<?php
$servername = "localhost"; // Change this to your MySQL server hostname if necessary
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password if you have one
$database = "medi_vault"; // Change this to your MySQL database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
