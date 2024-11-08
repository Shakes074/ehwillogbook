<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Logsheet</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    // Check if a session already exists before starting a new session
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userId = $_SESSION['user_id'];
    $currentDate = date('Y-m-d');
    ?>

    <div class="container mt-5">
        <form id="logsheet-form" action="process_logsheet.php" method="POST" onsubmit="return validateLogsheet()">
            <div id="activity-container">
                <h5 class="mt-4">Log Activities (Total 6 hours):</h5>

                <!-- Activity Template -->
                <div class="activity-row form-row">
                    <div class="form-group col-md-10">
                        <input type="text" class="form-control activity-input" name="activities[]" placeholder="Describe the activity" required>
                    </div>
                    <div class="form-group col-md-2">
                        <button type="button" class="btn btn-danger btn-remove" onclick="removeActivity(this)">Remove</button>
                    </div>
                </div>
            </div>

            <!-- Add Activity Button -->
            <button type="button" id="add-activity" class="btn btn-success mb-4">Add Activity</button>

            <!-- Report Section -->
            <h5 class="mt-4">Daily Reflection and Report:</h5>
            <div class="form-group">
                <textarea class="form-control" name="reflection" placeholder="Reflection on the day's activities" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="problem_solving" placeholder="Describe any problem-solving encountered" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="thoughts" placeholder="General thoughts about the day" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="general_comments" placeholder="General comments" rows="3"></textarea>
            </div>

            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
            <input type="hidden" name="log_date" value="<?php echo $currentDate; ?>">

            <button type="submit" class="btn btn-primary btn-block">Submit Logsheet</button>
        </form>
    </div>

    

    <script>
        let activityCount = 1;

        document.getElementById('add-activity').addEventListener('click', function () {
            if (activityCount < 6) {
                const activityContainer = document.getElementById('activity-container');
                const newActivityRow = document.createElement('div');
                newActivityRow.className = 'activity-row form-row';
                newActivityRow.innerHTML = `
                    <div class="form-group col-md-10">
                        <input type="text" class="form-control activity-input" name="activities[]" placeholder="Describe the activity" required>
                    </div>
                    <div class="form-group col-md-2">
                        <button type="button" class="btn btn-danger btn-remove" onclick="removeActivity(this)">Remove</button>
                    </div>
                `;
                activityContainer.appendChild(newActivityRow);
                activityCount++;
            } else {
                alert("You can only log up to 6 activities.");
            }
        });

        function removeActivity(button) {
            const activityRow = button.closest('.activity-row');
            activityRow.remove();
            activityCount--;
        }

        function validateLogsheet() {
            const activities = document.querySelectorAll('.activity-input');
            const activityCount = activities.length;

            if (activityCount === 0) {
                alert("You must log at least one activity.");
                return false;
            }

            const totalHours = activityCount; // Each activity is 1 hour
            if (totalHours !== 6) {
                alert(`Total hours must equal 6. Currently, you have ${totalHours} hours.`);
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
