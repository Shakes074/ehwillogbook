<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    session_start();
    include 'dashboardheader.php';
    include '../dbscripts/dbconnection.php';

    if (!isset($_SESSION['user_id'])) {
        header("Location: signin.php");
        exit();
    }

    $userId = $_SESSION['user_id'];
    $userQuery = "
        SELECT 
            s.title, 
            s.initials, 
            s.alt_phone_number, 
            s.province_of_residence, 
            s.physical_address, 
            s.home_town, 
            u.name, 
            u.surname, 
            u.email, 
            u.cellnumber 
        FROM student s
        INNER JOIN `user` u ON s.user_id = u.id
        WHERE u.id = ?;
    ";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $userResult = $stmt->get_result()->fetch_assoc();
    ?>

    <div class="container mt-5">
        <h2 class="text-center">Update Profile</h2>
        <form action="process_update_profile.php" method="POST">
            <!-- Title and Initials -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <select class="form-control" id="title" name="title" required>
                        <option value="">Select Title</option>
                        <option value="Mr" <?php echo $userResult['title'] === 'Mr' ? 'selected' : ''; ?>>Mr</option>
                        <option value="Mrs" <?php echo $userResult['title'] === 'Mrs' ? 'selected' : ''; ?>>Mrs</option>
                        <option value="Ms" <?php echo $userResult['title'] === 'Ms' ? 'selected' : ''; ?>>Ms</option>
                        <option value="Dr" <?php echo $userResult['title'] === 'Dr' ? 'selected' : ''; ?>>Dr</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="initials" name="initials" value="<?php echo htmlspecialchars($userResult['initials']); ?>" placeholder="Initials" required>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($userResult['name']); ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="surname" name="surname" value="<?php echo htmlspecialchars($userResult['surname']); ?>" required>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userResult['email']); ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="cellnumber" name="cellnumber" value="<?php echo htmlspecialchars($userResult['cellnumber']); ?>" maxlength="12" pattern="^\+27\d{9}$" placeholder="Phone Number (+27XXXXXXXXX)" required>
                </div>
            </div>

            <!-- Alternative Contact -->
            <div class="form-group">
                <input type="text" class="form-control" id="alt_phone_number" name="alt_phone_number" value="<?php echo htmlspecialchars($userResult['alt_phone_number']); ?>" maxlength="12" pattern="^\+27\d{9}$" placeholder="Alternative Phone (+27XXXXXXXXX)" required>
            </div>

            <!-- Address Information -->
            <div class="form-group">
                <input type="text" class="form-control mb-2" id="street_address" name="street_address" value="<?php echo htmlspecialchars($userResult['physical_address']); ?>" placeholder="Street Address" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="town" name="town" value="<?php echo htmlspecialchars($userResult['home_town']); ?>" placeholder="Town" required>
                </div>
                <div class="form-group col-md-4">
                    <select class="form-control" id="province" name="province" required>
                        <option value="">Select Province</option>
                        <?php
                        $provinces = ["Eastern Cape", "Free State", "Gauteng", "KwaZulu-Natal", "Limpopo", "Mpumalanga", "Northern Cape", "North West", "Western Cape"];
                        foreach ($provinces as $province) {
                            $selected = ($userResult['province_of_residence'] === $province) ? 'selected' : '';
                            echo "<option value=\"$province\" $selected>$province</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code" maxlength="4" pattern="\d{4}" required>
                </div>
            </div>

            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
            <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
        </form>
    </div>

    <?php include 'dashboardfooter.php'; ?>

    <script>
        document.querySelectorAll('#cellnumber, #alt_phone_number').forEach(function (field) {
            field.addEventListener('input', function (e) {
                e.target.value = e.target.value.replace(/[^\d+]/g, '').slice(0, 12);
            });
        });
    </script>
</body>
</html>
