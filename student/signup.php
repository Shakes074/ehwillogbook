<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Student Sign-Up</h2>
    <form action="process_signup.php" method="POST" onsubmit="return validateForm()">
        <div class="row">
            <!-- Name, Surname, Cell Number -->
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" name="name" id="name" placeholder="First Name (e.g., John)" required>
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" name="surname" id="surname" placeholder="Surname (e.g., Doe)" required>
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" name="cellnumber" id="cellnumber" placeholder="Cell Number (e.g.,  068 244 9534)" maxlength="12" required>
            </div>
        </div>
        
        <div class="row">
            <!-- Email, Student Number -->
            <div class="col-md-6 mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Student Email (e.g., 12345678@live.mut.ac.za)" required>
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" name="studentnumber" id="studentnumber" placeholder="Student Number (e.g., 12345678)" maxlength="8" required>
            </div>
        </div>
        
        <div class="row">
            <!-- Password and Confirm Password -->
            <div class="col-md-6 mb-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password (Min. 6 chars)" required>
                <small id="passwordRequirements" class="form-text text-muted">
                    Password must include:
                    <ul>
                        <li id="reqUppercase">One uppercase letter</li>
                        <li id="reqLowercase">One lowercase letter</li>
                        <li id="reqNumber">One number</li>
                        <li id="reqSpecial">One special character (@$!%*?&)</li>
                        <li id="reqLength">Length should be 6 or more</li>
                    </ul>
                </small>
            </div>
            <div class="col-md-6 mb-3">
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
            </div>
        </div>

        <!-- Show Password Checkbox -->
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePasswordVisibility()">
            <label class="form-check-label" for="showPassword">Show Password</label>
        </div>
        
        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
    </form>
</div>

<?php include 'footer.php'; ?>

<!-- JavaScript for Form Validation, Password Toggle, and Input Restrictions -->
<script>
    // Password validation requirements
    const passwordField = document.getElementById("password");
    const confirmPasswordField = document.getElementById("confirm_password");

    const passwordRequirements = {
        uppercase: /[A-Z]/,
        lowercase: /[a-z]/,
        number: /[0-9]/,
        special: /[@$!%*?&]/,
        minLength: 6
    };

    // Update password requirements live as the user types
    passwordField.addEventListener("input", function () {
        const password = passwordField.value;

        // Check each requirement and update the UI color
        document.getElementById("reqUppercase").style.color = passwordRequirements.uppercase.test(password) ? "green" : "red";
        document.getElementById("reqLowercase").style.color = passwordRequirements.lowercase.test(password) ? "green" : "red";
        document.getElementById("reqNumber").style.color = passwordRequirements.number.test(password) ? "green" : "red";
        document.getElementById("reqSpecial").style.color = passwordRequirements.special.test(password) ? "green" : "red";

        // Length validation
        document.getElementById("reqLength").style.color = password.length >= passwordRequirements.minLength ? "green" : "red";
    });

    function validateForm() {
        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;

        // Ensure all requirements are met
        if (!passwordRequirements.uppercase.test(password) ||
            !passwordRequirements.lowercase.test(password) ||
            !passwordRequirements.number.test(password) ||
            !passwordRequirements.special.test(password) ||
            password.length < passwordRequirements.minLength) {
            alert("Password does not meet the required criteria.");
            return false;
        }

        // Check if passwords match
        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }

        return true;
    }

    // Toggle password visibility
    function togglePasswordVisibility() {
        const type = passwordField.type === "password" ? "text" : "password";
        passwordField.type = type;
        confirmPasswordField.type = type;
    }

    // Restrict input to numbers only in the Student Number field and enforce max length of 8
    document.getElementById("studentnumber").addEventListener("input", function (e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');  // Remove any non-numeric characters
        if (e.target.value.length > 8) {
            e.target.value = e.target.value.slice(0, 8);  // Limit to 8 digits
        }
    });

    // Format cell number input with fixed prefix and spacing
    /*document.getElementById("cellnumber").addEventListener("input", function (e) {
        let value = e.target.value.replace(/[^0-9]/g, "");*/

        // Display formatted cell number as "(+27) XX XXX XXXX"
        /*e.target.value = "(+27) " + value.slice(0, 2) + (value.length > 2 ? " " : "") + value.slice(2, 5) + (value.length > 5 ? " " : "") + value.slice(5, 9);*/
    
    // Restrict input to numbers only in the Student Number field and enforce max length of 8
    document.getElementById("cellnumber").addEventListener("input", function (e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');  // Remove any non-numeric characters
        if (e.target.value.length > 12) {
            e.target.value = e.target.value.slice(0, 12);  // Limit to 8 digits
        }
    });
    
    });
</script>
