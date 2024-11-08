<?php
include '../dbscripts/dbconnection.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $cellnumber = $_POST['cellnumber'];
    $email = $_POST['email'];
    $studentnumber = $_POST['studentnumber'];
    $password = $_POST['password'];

    try {
        // Call the stored procedure
        $stmt = $conn->prepare("CALL sp_register_student(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $surname, $studentnumber, $email, $password, $cellnumber);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Account created successfully!'); window.location.href = 'signin.php';</script>";
        } else {
            throw new Exception("Database execution failed: " . $stmt->error);
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) { // Duplicate entry
            echo "<script>alert('An account with this student number already exists. Please log in.'); window.location.href = 'signin.php';</script>";
        } else {
            echo "<script>alert('Database error: " . $e->getMessage() . "'); window.location.href = 'signup.php';</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('An unexpected error occurred: " . $e->getMessage() . "'); window.location.href = 'signup.php';</script>";
    } finally {
        $stmt->close();
        $conn->close();
    }
}
?>
