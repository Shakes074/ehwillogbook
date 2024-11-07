<?php
// Database connection details
$server = "mysql.s815.sureserver.com";
$user = "ehwillogbook";
$password = "@EH_WIL_logbook#074";
$database = "ehwillogbook_ehwillogbookDB";
$port = 3308;

// Create a connection
$conn = new mysqli($server, $user, $password, $database, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
