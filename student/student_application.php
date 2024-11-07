<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Application Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to global CSS file -->
</head>
<body>
    <?php
    session_start();
    include 'dashboardheader.php';
    include '../dbscripts/dbconnection.php';

    // Ensure user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: signin.php");
        exit();
    }

    // Get user ID from session
    $userId = $_SESSION['user_id'];

    // Fetch student data from the user table for auto-fill fields
    $userQuery = "SELECT name, surname, username AS student_number, email, cellnumber FROM `user` WHERE id = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $userResult = $stmt->get_result()->fetch_assoc();

    // Fetch levels from the levels view
    $levelQuery = "SELECT * FROM levels";
    $levelResult = $conn->query($levelQuery);

    // Fetch WIL placement options from the WIL_PLACEMENT view
    $placementQuery = "SELECT * FROM WIL_PLACEMENT";
    $placementResult1 = $conn->query($placementQuery);
    $placementResult2 = $conn->query($placementQuery); // For the second option
    ?>

    <div class="container mt-5">
        <h2 class="text-center">Student Application Form</h2>
        <form action="process_student_application.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <!-- Personal Information -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <select class="form-control" id="title" name="title" required>
                        <option value="">Title (e.g., Mr, Mrs, Ms)</option>
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Ms">Ms</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="initials" name="initials" placeholder="Initials (e.g., J.S.)" required>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($userResult['name']); ?>" readonly>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="surname" name="surname" value="<?php echo htmlspecialchars($userResult['surname']); ?>" readonly>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="student_number" name="student_number" value="<?php echo htmlspecialchars($userResult['student_number']); ?>" readonly>
                </div>
                <div class="form-group col-md-3">
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userResult['email']); ?>" readonly>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="cellnumber" name="cellnumber" value="<?php echo htmlspecialchars($userResult['cellnumber']); ?>" readonly>
                </div>
                <div class="form-group col-md-3">
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <!-- Race and Level Selection -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <select class="form-control" id="race" name="race" required>
                        <option value="">Select Race</option>
                        <option value="African">African</option>
                        <option value="Asian">Asian</option>
                        <option value="Coloured">Coloured</option>
                        <option value="White">White</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <select class="form-control" id="level" name="level" required>
                        <option value="">Select Level</option>
                        <?php while ($row = $levelResult->fetch_assoc()): ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['level_no']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <!-- Placement Options Selection -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <select class="form-control" id="workingarea1" name="workingarea1" required>
                        <option value="">Placement Option A</option>
                        <?php while ($row = $placementResult1->fetch_assoc()): ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['provider_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <select class="form-control" id="workingarea2" name="workingarea2">
                        <option value="">Placement Option B</option>
                        <?php while ($row = $placementResult2->fetch_assoc()): ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['provider_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <!-- Address Information -->
            <div class="form-group">
                <input type="text" class="form-control mb-2" id="street_address" name="street_address" placeholder="Street Address" required>
                <input type="text" class="form-control mb-2" id="town" name="town" placeholder="Town" required>
                
                <select class="form-control mb-2" id="province" name="province" required>
                    <option value="">Select Province</option>
                    <option value="Eastern Cape">Eastern Cape</option>
                    <option value="Free State">Free State</option>
                    <option value="Gauteng">Gauteng</option>
                    <option value="KwaZulu-Natal">KwaZulu-Natal</option>
                    <option value="Limpopo">Limpopo</option>
                    <option value="Mpumalanga">Mpumalanga</option>
                    <option value="Northern Cape">Northern Cape</option>
                    <option value="North West">North West</option>
                    <option value="Western Cape">Western Cape</option>
                </select>

                <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code" required>
            </div>

            <!-- File Uploads with Labels -->
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="cvdocument">CV Document</label>
                    <input type="file" class="form-control-file" id="cvdocument" name="cvdocument" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="iddocument">ID Document</label>
                    <input type="file" class="form-control-file" id="iddocument" name="iddocument" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="signature">Signature Picture (white background, 4x4 cm)</label>
                    <input type="file" class="form-control-file" id="signature" name="signature" required>
                </div>
            </div>

            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
            <button type="submit" class="btn btn-primary btn-block">Submit Application</button>
        </form>
    </div>

    <?php include 'dashboardfooter.php'; ?>

    <!-- JavaScript Validation Script -->
    <script>
        function validateForm() {
            const street = document.getElementById('street_address').value;
            const town = document.getElementById('town').value;
            const province = document.getElementById('province').value;
            const postalCode = document.getElementById('postal_code').value;
            document.getElementById('homeaddress').value = `${street}, ${town}, ${province}, ${postalCode}`;
            return true;
        }
    </script>
</body>
</html>
