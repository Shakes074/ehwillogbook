<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Sign In</h2>
            <p class="text-center">Log in using your email or username</p>
            
            <form action="process_signin.php" method="POST" onsubmit="return validateSignInForm()">
                <!-- Email or Username Field -->
                <div class="form-group">
                    <label for="username">Email or Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter your email or student number" required>
                </div>
                
                <!-- Password Field with Show/Hide Option -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">Show</button>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </form>
            <p class="text-center mt-3"><a href="forgot_password.php">Forgot your password?</a></p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- JavaScript for Form Validation and Password Toggle -->
<script>
    // Toggle password visibility
    function togglePassword() {
        const passwordField = document.getElementById("password");
        const toggleButton = event.target;
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleButton.textContent = "Hide";
        } else {
            passwordField.type = "password";
            toggleButton.textContent = "Show";
        }
    }

    // Validate the sign-in form
    function validateSignInForm() {
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        if (!username.trim() || !password.trim()) {
            alert("Both fields are required.");
            return false;
        }

        return true;
    }
</script>
