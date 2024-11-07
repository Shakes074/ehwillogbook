<?php
// Start the session
session_start();
include 'dbscripts/dbconnection.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user input
    $username_or_email = trim($_POST['username']); // This will contain either the username or email
    $password = trim($_POST['password']);          // User's password

    // Prepare SQL to check for email or username
    $sql = "CALL sp_user_signin(?, ?);";
    $stmt = $conn->prepare($sql);

    // Bind parameters: "ss" means two string parameters (input_user, input_password)
    $stmt->bind_param("ss", $username_or_email, $password);

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to the user's home page
            header("Location: /ehwillogbook/student/dashboard.php");
            exit();
        
    } else {
        // Invalid username/email
        echo "<script>alert('No account found with that email or username.'); window.location.href='signin.php';</script>";
    }
} else {
    // Redirect if accessed directly
    header("Location: signin.php");
    exit();
}
?>
