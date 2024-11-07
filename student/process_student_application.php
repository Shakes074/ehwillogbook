<?php
session_start();
include '../dbscripts/dbconnection.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Retrieve and sanitize form inputs
$title = trim($_POST['title']);
$initials = trim($_POST['initials']);
$gender = trim($_POST['gender']);
$race = trim($_POST['race']);
$levelId = (int)$_POST['level'];
$workingArea1 = (int)$_POST['workingarea1'];
$workingArea2 = (int)$_POST['workingarea2'];

// Concatenate address fields
$streetAddress = trim($_POST['street_address']);
$town = trim($_POST['town']);
$province = trim($_POST['province']);
$postalCode = trim($_POST['postal_code']);
$homeAddress = "$streetAddress, $town, $province, $postalCode";

// Get user ID from session
$userId = $_SESSION['user_id'];
$applicationDate = date('Y-m-d');

// File upload paths (set appropriate paths for storing files)
$cvDocument = $_FILES['cvdocument']['name'];
$idDocument = $_FILES['iddocument']['name'];
$signature = $_FILES['signature']['name'];

// Move uploaded files to a designated folder
$targetDir = "../uploads/";
$cvDocumentPath = $targetDir . basename($cvDocument);
$idDocumentPath = $targetDir . basename($idDocument);
$signaturePath = $targetDir . basename($signature);

// Check file upload and move files
if (!move_uploaded_file($_FILES['cvdocument']['tmp_name'], $cvDocumentPath) ||
    !move_uploaded_file($_FILES['iddocument']['tmp_name'], $idDocumentPath) ||
    !move_uploaded_file($_FILES['signature']['tmp_name'], $signaturePath)) {
    echo "Error uploading files. Please try again.";
    exit();
}

// Prepare SQL call to stored procedure
$resultMessage = '';
$sql = "CALL sp_student_application(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @resultMessage)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    'sssssssiisss',
    $cvDocumentPath,    // p_cvdocument
    $idDocumentPath,    // p_iddocument
    $workingArea1,      // p_workingarea1
    $workingArea2,      // p_workingarea2
    $homeAddress,       // p_address
    $signaturePath,     // p_signature
    0,                  // p_active (set to inactive by default)
    $userId,            // p_userid
    $levelId,           // p_levelid
    $title,             // p_title
    $initials,          // p_initials
    $gender,            // p_gender
    $race               // p_race
);

// Execute the procedure and get the result
if ($stmt->execute()) {
    $result = $conn->query("SELECT @resultMessage AS message");
    $message = $result->fetch_assoc()['message'];
    echo "<script>alert('$message'); window.location.href = 'dashboard.php';</script>";
} else {
    echo "Error submitting application: " . $conn->error;
}
$stmt->close();
$conn->close();
?>
