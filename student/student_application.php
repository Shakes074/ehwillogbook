<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Application Form</title>
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
    $userQuery = "SELECT name, surname, username AS student_number, email, cellnumber FROM `user` WHERE id = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $userResult = $stmt->get_result()->fetch_assoc();

    $levelQuery = "SELECT * FROM levels";
    $levelResult = $conn->query($levelQuery);

    $placementQuery = "SELECT * FROM WIL_PLACEMENT";
    $placementResult1 = $conn->query($placementQuery);
    $placementResult2 = $conn->query($placementQuery);
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
                    <input type="text" class="form-control" id="initials" name="initials" placeholder="Initials" value="<?php echo substr($userResult['name'], 0, 1); ?>" readonly required>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($userResult['name']); ?>" readonly>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="surname" name="surname" value="<?php echo htmlspecialchars($userResult['surname']); ?>" readonly>
                </div>
            </div>

            <!-- Additional Personal Information -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required placeholder="Date of Birth" onchange="generateIDNumber()">
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="alt_phone_number" name="alt_phone_number" placeholder="Alternative Phone (+27)" maxlength="12" required>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="id_number" name="id_number" placeholder="ID Number" maxlength="13" required>
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
                    <select class="form-control" id="race" name="race" required>
                        <option value="">Select Race</option>
                        <option value="African">African</option>
                        <option value="Asian">Asian</option>
                        <option value="Coloured">Coloured</option>
                        <option value="White">White</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <!-- Level and Placement Options Selection (Same line) -->
            <div class="form-row">
                <div class="form-group col-md-4">
                    <select class="form-control" id="level" name="level" required>
                        <option value="">Select Level</option>
                        <?php while ($row = $levelResult->fetch_assoc()): ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['level_no']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <select class="form-control" id="workingarea1" name="workingarea1" required>
                        <option value="">Placement Option A</option>
                        <?php while ($row = $placementResult1->fetch_assoc()): ?>
                            <option value="<?php echo $row['provider_name']; ?>"><?php echo $row['provider_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <select class="form-control" id="workingarea2" name="workingarea2">
                        <option value="">Placement Option B</option>
                        <?php while ($row = $placementResult2->fetch_assoc()): ?>
                            <option value="<?php echo $row['provider_name']; ?>"><?php echo $row['provider_name']; ?></option>
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
                <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code" maxlength="4" pattern="\d{4}" required>
            </div>
            
            <input type="hidden" id="homeaddress" name="homeaddress">

            <!-- File Uploads -->
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="cvdocument">CV Document (PDF only)</label>
                    <input type="file" class="form-control-file" id="cvdocument" name="cvdocument" accept=".pdf" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="iddocument">ID Document (PDF only)</label>
                    <input type="file" class="form-control-file" id="iddocument" name="iddocument" accept=".pdf" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="signature">Signature Picture (.jpg, .png, .webp)</label>
                    <input type="file" class="form-control-file" id="signature" name="signature" accept=".jpg,.png,.webp" required>
                </div>
            </div>

            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
            <button type="submit" class="btn btn-primary btn-block">Submit Application</button>
        </form>
    </div>

    <?php include 'dashboardfooter.php'; ?>

    <script>
        // Restrict input to numbers only for ID and Alt Phone fields
        document.getElementById('id_number').addEventListener('input', function (e) {
            e.target.value = e.target.value.replace(/\D/g, '').slice(0, 13);
        });
        
        document.getElementById('alt_phone_number').addEventListener('input', function (e) {
            e.target.value = e.target.value.replace(/[^\d+]/g, '').slice(0, 12);
        });

        function validateForm() {
            const dob = document.getElementById('date_of_birth').value;
            const idField = document.getElementById('id_number');
            const street = document.getElementById('street_address').value;
            const town = document.getElementById('town').value;
            const province = document.getElementById('province').value;
            const postalCode = document.getElementById('postal_code').value;

            document.getElementById('homeaddress').value = `${street}, ${town}, ${province}, ${postalCode}`;
            
            if (dob) {
                const dobFormatted = dob.replace(/-/g, '').slice(2, 8);
                idField.value = dobFormatted + idField.value.slice(6);
                if (idField.value.length !== 13 || isNaN(idField.value)) {
                    alert("ID Number must be 13 digits long and match birthdate.");
                    return false;
                }
            }
            return true;
        }

        function generateIDNumber() {
            const dob = document.getElementById('date_of_birth').value;
            if (dob) {
                const dobFormatted = dob.replace(/-/g, '').slice(2, 8);
                document.getElementById('id_number').value = dobFormatted;
            }
        }
    </script>
</body>
</html>
