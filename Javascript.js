document.getElementById("signup-btn").addEventListener("click", function() {
            document.getElementById("login-section").style.display = "none";
            document.getElementById("signup-section").style.display = "block";
        });

        document.getElementById("back-to-login-btn").addEventListener("click", function() {
            document.getElementById("signup-section").style.display = "none";
            document.getElementById("login-section").style.display = "block";
        });
        
// show pw for login
const passwordField = document.getElementById("password");
const togglePassword = document.getElementById("toggle-password");

// Add event listener to toggle password visibility
togglePassword.addEventListener("click", function() {
    // Check the current type of the password field and toggle it
    const type = passwordField.type === "password" ? "text" : "password";
    passwordField.type = type;

    // Toggle the eye icon (closed/open)
    this.classList.toggle("fa-eye-slash");
    this.classList.toggle("fa-eye");
});

// Show password for signup
const signupPasswordField = document.getElementById("signup_password");
const toggleSignupPassword = document.getElementById("toggle-signup-password");

// Add event listener to toggle password visibility
toggleSignupPassword.addEventListener("click", function() {
    // Check the current type of the password field and toggle it
    const type = signupPasswordField.type === "password" ? "text" : "password";
    signupPasswordField.type = type;

    // Toggle the eye icon (closed/open)
    this.classList.toggle("fa-eye-slash");
    this.classList.toggle("fa-eye");
});

document.getElementById("finishcreate-submit").addEventListener("click", function(event) {
    event.preventDefault();
    console.log("Button clicked");
});
