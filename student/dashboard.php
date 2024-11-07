<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbook DLS</title>
    <!-- Link to Global CSS -->
    <link rel="stylesheet" href="styles.css"> <!-- Ensure this points to your global CSS file location -->
</head>
<body>
    <!-- Header (assumed to be included globally) -->
    <?php include 'dashboardheader.php'; ?>

    <!-- Main Content -->
    <div class="main-content">

            <p>     
                <?php
                    echo "User ID: " . $_SESSION['user_id'];
                ?>
            </p>

        <div class="container content-wrapper">
            <!-- PDF Viewer -->
            <div class="pdf-viewer">
                <div class="pdf-viewer-text">PDF</div>
                <div class="pdf-subtext">Saved DLS</div>
            </div>

            <!-- Create DLS Button -->
            <div class="create-dls" onclick="openForm()">
                <div class="create-icon">+</div>
                <div class="create-text">Create DLS</div>
            </div>

            <!-- Completed Counter -->
            <div class="completed-counter">
                <div>Completed</div>
                <div class="icon">⏰</div>
                <div class="count">100</div>
            </div>
        </div>
    </div>

    <!-- Footer (assumed to be included globally) -->
    <?php include 'dashboardfooter.php'; ?>

    <script>
        function openForm() {
            alert("Open the form to complete a new logsheet.");
        }
    </script>
</body>
</html>
