<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Chart.js for Pie Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="logbooks.php">Logbooks</a></li>
                <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Dashboard Content -->
    <div class="container mt-5">
        <h2 class="text-center">Logbook Statistics - 2024</h2>
        
        <div class="row">
            <!-- Started Student List -->
            <div class="col-md-4">
                <h5>Students Who Have Started Logbooks</h5>
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Emily Watson</strong><br>
                        Days Covered: 45
                    </li>
                    <li class="list-group-item">
                        <strong>Michael Johnson</strong><br>
                        Days Covered: 30
                    </li>
                    <li class="list-group-item">
                        <strong>Sara Williams</strong><br>
                        Days Covered: 20
                    </li>
                </ul>
            </div>

            <!-- Pie Chart for Logbook Stats -->
            <div class="col-md-4 text-center">
                <canvas id="logbookChart" style="max-width: 300px;"></canvas>
            </div>

            <!-- Not Started Student List -->
            <div class="col-md-4">
                <h5>Students Who Haven’t Started Logbooks</h5>
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Jane Doe</strong><br>
                        Cell: (+27) 68 244 9534<br>
                        Email: jane.doe@example.com
                    </li>
                    <li class="list-group-item">
                        <strong>John Smith</strong><br>
                        Cell: (+27) 72 345 6789<br>
                        Email: john.smith@example.com
                    </li>
                    <li class="list-group-item">
                        <strong>Alice Brown</strong><br>
                        Cell: (+27) 71 123 4567<br>
                        Email: alice.brown@example.com
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- JavaScript for Chart -->
    <script>
        // Chart.js for Logbook Pie Chart
        const ctx = document.getElementById('logbookChart').getContext('2d');
        const logbookChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Started', 'Not Started'],
                datasets: [{
                    data: [60, 40], // Static values: 60% started, 40% not started
                    backgroundColor: ['green', 'red'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
