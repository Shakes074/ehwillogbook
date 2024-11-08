<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../dbscripts/dbconnection.php';

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {  // Assuming admin sessions use 'admin_id'
    header("Location: signin.php");
    exit();
}

// Get admin ID from session
$adminId = $_SESSION['admin_id'];

// Set current year and month
$currentYear = date("Y");
$currentMonth = date("m");

// Check if any specific logic is required for admin roles
// Example: Fetching application counts for admin dashboards could be different
$appQuery = "SELECT COUNT(*) AS application_count FROM student WHERE YEAR(application_date) = ?";
$stmt = $conn->prepare($appQuery);
$stmt->bind_param("i", $currentYear);
$stmt->execute();
$appResult = $stmt->get_result()->fetch_assoc();

// Example: Only show application management link during October
$showApplicationLink = ($currentMonth >= 10);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Environmental Health Logbook</title>
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
                <a class="navbar-brand" href="admin-dashboard.php">
                    <img src="../resource/mutlogo.webp" alt="MUT Logo" style="height: 75px;">
                </a>
                <span class="logo-text">Environmental Health - Admin Panel</span>
            </div>
            <!-- Hamburger button for small screens -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="admin-dashboard.php" class="nav-link">Dashboard</a></li>
                    <li class="nav-item"><a href="users.php" class="nav-link">Users</a></li>
                    <li class="nav-item"><a href="logbooks.php" class="nav-link">Logbooks</a></li>
                    <li class="nav-item"><a href="service-providers.php" class="nav-link">Service Providers</a></li>
                    <li class="nav-item"><a href="profile.php" class="nav-link">Profile</a></li>
                    <?php if ($showApplicationLink): ?>
                        <li class="nav-item"><a href="manage-applications.php" class="nav-link">Applications</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<!-- Main Content Placeholder -->
<main class="container mt-4">
    <!-- Admin dashboard main content -->
</main>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
