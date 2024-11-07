<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $reason = htmlspecialchars($_POST['reason']);

    if ($email) {
        $to = "your-email@example.com";  // Replace with your actual email address
        $subject = "Contact Form Submission from $fullname";
        $message = "Name: $fullname\nEmail: $email\n\nReason for Contact:\n$reason";
        $headers = "From: $email";

        if (mail($to, $subject, $message, $headers)) {
            echo "Your message has been sent successfully!";
        } else {
            echo "There was an error sending your message. Please try again.";
        }
    } else {
        echo "Invalid email format.";
    }
} else {
    header("Location: contact.php");
    exit();
}
?>
