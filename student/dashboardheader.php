<?php
// Start session only if it hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../dbscripts/dbconnection.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Get user ID from session
$userId = $_SESSION['user_id'];

// Set current year and month
$currentYear = date("Y");
$currentMonth = date("m");

// Check if the student has an application for the current year
$appQuery = "SELECT COUNT(*) AS application_count FROM student WHERE userid = ? AND YEAR(application_date) = ?";
$stmt = $conn->prepare($appQuery);
$stmt->bind_param("ii", $userId, $currentYear);
$stmt->execute();
$appResult = $stmt->get_result()->fetch_assoc();

// Determine if the application link should be shown: only in October and if no application exists for the current year
$showApplicationLink = ($currentMonth >= 10) && ($appResult['application_count'] == 0);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Environmental Health Logbook</title>
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Global CSS -->
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

<!-- Header -->
<header class="custom-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="d-flex flex-column align-items-center">
                <a class="navbar-brand" href="index.php">
                    <img src="../resource/mutlogo.webp" alt="MUT Logo" style="height: 75px;">
                </a>
                <span class="logo-text">Environmental Health</span>
            </div>
            <!-- Hamburger button for small screens -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard</a></li>
                    <li class="nav-item"><a href="logbook.php" class="nav-link">Logbook</a></li>
                    <li class="nav-item"><a href="report.php" class="nav-link">Report</a></li>
                    <li class="nav-item"><a href="profile.php" class="nav-link">Profile</a></li>
                    <?php if ($showApplicationLink): ?>
                        <li class="nav-item"><a href="student_application.php" class="nav-link">Student Application</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</header>
