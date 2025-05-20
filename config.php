<?php
// Database credentials
$servername = "localhost";
$username = "u283492965_nailarchitect";      // default XAMPP username
$password = "WrongDirection432!";          // default XAMPP password is empty
$dbname = "u283492965_nailarchidb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>