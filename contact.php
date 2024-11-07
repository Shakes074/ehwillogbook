<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Contact Us</h2>
            <p class="text-center">Please fill in the form below to reach out to us.</p>
            
            <form action="process_contact.php" method="POST" onsubmit="return validateContactForm()">
                <!-- Full Name Field -->
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Enter your full name" required>
                </div>
                
                <!-- Email Address Field -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email address" required>
                </div>
                
                <!-- Reason for Contacting Field -->
                <div class="form-group">
                    <label for="reason">Reason for Contacting</label>
                    <textarea name="reason" id="reason" class="form-control" rows="4" placeholder="Describe your reason for contacting us" required></textarea>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-block">Send Message</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- JavaScript for Form Validation -->
<script>
    // Validate the contact form
    function validateContactForm() {
        const email = document.getElementById("email").value;
        const fullname = document.getElementById("fullname").value;
        const reason = document.getElementById("reason").value;

        // Check if email format is valid
        const emailPattern = /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/;
        if (!emailPattern.test(email)) {
            alert("Please enter a valid email address.");
            return false;
        }

        // Check if fields are not empty
        if (!fullname.trim() || !reason.trim()) {
            alert("All fields are required.");
            return false;
        }

        return true;
    }
</script>
