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
                <input type="text" class="form-control" name="cellnumber" id="cellnumber" placeholder="Phone Number (e.g., +27682449534)" maxlength="12" required>
            </div>
        </div>
        
        <div class="row">
            <!-- Email, Student Number -->
            <div class="col-md-6 mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Student Email (e.g., 12345678@live.mut.ac.za)" required>
                <small id="emailError" class="text-danger d-none">Email must end with @live.mut.ac.za or @gmail.com</small>
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" name="studentnumber" id="studentnumber" placeholder="Student Number (e.g., 12345678)" maxlength="8" required>
            </div>
        </div>
        
        <div class="row">
            <!-- Password and Confirm Password -->
            <div class="col-md-6 mb-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password (Min. 6 chars, Max. 13 chars)" maxlength="13" required>
                <small id="passwordRequirements" class="form-text text-muted">
                    Password must include:
                    <ul>
                        <li id="reqUppercase">One uppercase letter</li>
                        <li id="reqLowercase">One lowercase letter</li>
                        <li id="reqNumber">One number</li>
                        <li id="reqSpecial">One special character (@$!%*?&)</li>
                        <li id="reqLength">Length between 6 and 13</li>
                    </ul>
                </small>
            </div>
            <div class="col-md-6 mb-3">
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" maxlength="13" required>
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
    const passwordField = document.getElementById("password");
    const confirmPasswordField = document.getElementById("confirm_password");
    const emailField = document.getElementById("email");
    const emailError = document.getElementById("emailError");

    const passwordRequirements = {
        uppercase: /[A-Z]/,
        lowercase: /[a-z]/,
        number: /[0-9]/,
        special: /[@$!%*?&]/,
        minLength: 6,
        maxLength: 13
    };

    // Update password requirements live as the user types
    passwordField.addEventListener("input", function () {
        const password = passwordField.value;

        document.getElementById("reqUppercase").style.color = passwordRequirements.uppercase.test(password) ? "green" : "red";
        document.getElementById("reqLowercase").style.color = passwordRequirements.lowercase.test(password) ? "green" : "red";
        document.getElementById("reqNumber").style.color = passwordRequirements.number.test(password) ? "green" : "red";
        document.getElementById("reqSpecial").style.color = passwordRequirements.special.test(password) ? "green" : "red";
        document.getElementById("reqLength").style.color = (password.length >= passwordRequirements.minLength && password.length <= passwordRequirements.maxLength) ? "green" : "red";
    });

    function validateEmail() {
        const email = emailField.value;
        const allowedDomains = ["@live.mut.ac.za", "@gmail.com"];
        const isValid = allowedDomains.some(domain => email.endsWith(domain));
        
        emailError.classList.toggle("d-none", isValid);
        return isValid;
    }

    function validateForm() {
        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;

        if (!validateEmail()) {
            alert("Invalid email domain. Only @live.mut.ac.za and @gmail.com are allowed.");
            return false;
        }

        if (!passwordRequirements.uppercase.test(password) ||
            !passwordRequirements.lowercase.test(password) ||
            !passwordRequirements.number.test(password) ||
            !passwordRequirements.special.test(password) ||
            password.length < passwordRequirements.minLength ||
            password.length > passwordRequirements.maxLength) {
            alert("Password does not meet the required criteria.");
            return false;
        }

        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }

        return true;
    }

    function togglePasswordVisibility() {
        const type = passwordField.type === "password" ? "text" : "password";
        passwordField.type = type;
        confirmPasswordField.type = type;
    }

    document.getElementById("cellnumber").addEventListener("input", function (e) {
        let value = e.target.value.replace(/[^+\d]/g, '');
        e.target.value = value.slice(0, 12);
    });
</script>
