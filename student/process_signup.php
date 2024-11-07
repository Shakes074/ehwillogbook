<?php
include '../dbscripts/dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $studentnumber = trim($_POST['studentnumber']);
    $email = trim($_POST['email']);
    $cellnumber = trim($_POST['cellnumber']);
    $password = trim($_POST['confirm_password']);  // Use confirmed password directly

    // Prepare SQL to call the stored procedure
    $sql = "CALL sp_register_student(?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters: name, surname, student number, email, plain password, cell number
    $stmt->bind_param("ssssss", $name, $surname, $studentnumber, $email, $password, $cellnumber);

    // Execute the statement and check if successful
    if ($stmt->execute()) {
        // Redirect to login page or confirmation page
        header("Location: ../student/signin.php");
        exit();
    } else {
        echo "<script>alert('Error: Could not register. Please try again.'); window.location.href='signup.php';</script>";
    }
} else {
    header("Location: ../student/signup.php");
    exit();
}
?>
