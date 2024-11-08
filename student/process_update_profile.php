<?php
session_start();
include '../dbscripts/dbconnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

try {
    // Retrieve and sanitize form inputs
    $userId = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $initials = trim($_POST['initials']);
    $altPhoneNumber = trim($_POST['alt_phone_number']);
    $province = trim($_POST['province']);
    $streetAddress = trim($_POST['street_address']);
    $town = trim($_POST['town']);
    $physicalAddress = "$streetAddress, $town";
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $cellNumber = trim($_POST['cellnumber']);

    if (empty($title) || empty($initials) || empty($altPhoneNumber) || empty($province) ||
        empty($physicalAddress) || empty($name) || empty($surname) || empty($email) || empty($cellNumber)) {
        throw new Exception('All fields must be filled.');
    }

    $sql = "CALL sp_update_user_profile(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @result_message)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        'issssssssss',
        $userId,          // User ID
        $title,           // Title
        $initials,        // Initials
        $altPhoneNumber,  // Alternative phone number
        $province,        // Province
        $physicalAddress, // Physical address
        $town,            // Home town
        $name,            // Name
        $surname,         // Surname
        $email,           // Email
        $cellNumber       // Cell number
    );

    if (!$stmt->execute()) {
        throw new Exception('Failed to execute stored procedure: ' . $stmt->error);
    }

    $result = $conn->query("SELECT @result_message AS message");
    $message = $result->fetch_assoc()['message'];

    echo "<script>alert('$message'); window.location.href = 'profile.php';</script>";
} catch (Exception $e) {
    echo "<script>alert('{$e->getMessage()}'); window.location.href = 'profile.php';</script>";
} finally {
    $stmt->close();
    $conn->close();
}
?>
