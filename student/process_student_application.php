<?php
session_start();
include '../dbscripts/dbconnection.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

try {
    // Retrieve and sanitize form inputs
    $title = trim($_POST['title']);
    $initials = trim($_POST['initials']);
    $gender = trim($_POST['gender']);
    $race = trim($_POST['race']);
    $levelId = (int)$_POST['level'];
    $workingArea1 = trim($_POST['workingarea1']); // Placement Option A
    $workingArea2 = trim($_POST['workingarea2']); // Placement Option B
    $altPhoneNumber = trim($_POST['alt_phone_number']);
    $idNumber = trim($_POST['id_number']);
    $dateOfBirth = trim($_POST['date_of_birth']); // Assuming this is passed as 'YYYY-MM-DD'

    // Concatenate address fields
    $streetAddress = trim($_POST['street_address']);
    $town = trim($_POST['town']);
    $province = trim($_POST['province']);
    $postalCode = trim($_POST['postal_code']);
    $homeAddress = "$streetAddress, $town, $province, $postalCode";

    // Get user ID from session
    $userId = $_SESSION['user_id'];
    $homeTown = $town; // Assuming town is the home_town

    // Handle file uploads
    $allowedPdfTypes = ['application/pdf'];
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/webp'];

    $cvDocument = $_FILES['cvdocument'];
    $idDocument = $_FILES['iddocument'];
    $signature = $_FILES['signature'];

    $targetDir = "../uploads/";

    $cvDocumentPath = $targetDir . basename($cvDocument['name']);
    $idDocumentPath = $targetDir . basename($idDocument['name']);
    $signaturePath = $targetDir . basename($signature['name']);

    // Validate and move uploaded files
    if (
        $cvDocument['error'] !== UPLOAD_ERR_OK ||
        $idDocument['error'] !== UPLOAD_ERR_OK ||
        $signature['error'] !== UPLOAD_ERR_OK ||
        !in_array($cvDocument['type'], $allowedPdfTypes) ||
        !in_array($idDocument['type'], $allowedPdfTypes) ||
        !in_array($signature['type'], $allowedImageTypes) ||
        !move_uploaded_file($cvDocument['tmp_name'], $cvDocumentPath) ||
        !move_uploaded_file($idDocument['tmp_name'], $idDocumentPath) ||
        !move_uploaded_file($signature['tmp_name'], $signaturePath)
    ) {
        throw new Exception('Error uploading files. Ensure correct file types (PDF for documents, JPG/PNG/WebP for signature) and try again.');
    }

    // Prepare SQL call to stored procedure
    $sql = "CALL sp_student_application(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @result_message)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'issssssssssssisss',
        $userId,          // p_user_id
        $title,           // p_title
        $race,            // p_race
        $initials,        // p_initials
        $dateOfBirth,     // p_date_of_birth
        $altPhoneNumber,  // p_alt_phone_number
        $idNumber,        // p_id_number
        $gender,          // p_gender
        $cvDocumentPath,  // p_cv_document
        $idDocumentPath,  // p_id_document
        $province,        // p_province_of_residence
        $homeAddress,     // p_physical_address
        $homeTown,        // p_home_town
        $signaturePath,   // p_signature
        $levelId,         // p_level_id
        $workingArea1,    // p_working_area_a
        $workingArea2     // p_working_area_b
    );

    if ($stmt->execute()) {
        $result = $conn->query("SELECT @result_message AS message");
        $message = $result->fetch_assoc()['message'];
        echo "<script>alert('$message'); window.location.href = 'dashboard.php';</script>";
    } else {
        throw new Exception("Error executing the procedure. Please try again.");
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo "<script>alert('{$e->getMessage()}'); window.location.href = 'student_application.php';</script>";
}
?>
