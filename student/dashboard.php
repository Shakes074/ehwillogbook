<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbook DLS</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Header -->
    <?php include 'dashboardheader.php'; ?>
    <!-- Main Content -->
    <div class="main-content">
        <div class="container content-wrapper">

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

    <!-- Modal for Logsheet Form -->
    <div class="modal fade" id="logsheetModal" tabindex="-1" aria-labelledby="logsheetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logsheetModalLabel">Daily Logsheet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Embed Logsheet Form -->
                    <?php include 'logsheet.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'dashboardfooter.php'; ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openForm() {
            $('#logsheetModal').modal('show');
        }
    </script>
</body>
</html>
