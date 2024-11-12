<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Portal</title>
    <link rel="stylesheet" href="LoginCSS.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="screen">
            <div class="screen__content">
                <!-- Login Section -->
                <div id="login-section" class="form-section">
                    <h1 class="welcome">Welcome Admin!</h1>
                    <form method="POST" action="" class="login">
    <div class="login__field">
        <i class="login__icon fas fa-user"></i>
        <input type="text" name="username" class="login__input" maxlength="10" placeholder="Username">
    </div>
    <div class="login__field">
        <i class="login__icon fas fa-lock"></i>
        <input id="password" type="password" name="password" class="login__input" maxlength="15" placeholder="Password">
        <i id="toggle-password" class="showpw__icon fas fa-eye-slash"></i>
    </div>
    <button type="submit" name="login__submit" class="button login__submit">
        <span class="button__text">Log In</span>
    </button>
</form>
                    <div class="signup-section">
                        <h4 class="signup-text">Create new Admin account</h4>
                        <button class="create__submit" id="signup-btn">Sign up</button>
                    </div>
                </div>
                
                <!-- Sign-Up Section -->
                <div id="signup-section" class="form-section" style="display: none;">
                    <h1 class="welcome">Create Account</h1>
                    <form method="POST" action="" class="login">
                        <div class="signup__field">
                            <i class="signup__icon fas fa-user"></i>
                            <input id="signup_usn" name="signup_usn" type="text" class="login__input" maxlength="10" placeholder="Username">
                        </div>
                        <div class="signup__field">
                            <i class="signup__icon fas fa-user"></i>
                            <input id="signup_firstname" name="signup_firstname" type="text" class="login__input" maxlength="20" placeholder="First Name">
                        </div>
                        <div class="signup__field">
                            <i class="signup__icon fas fa-user"></i>
                            <input id="signup_lastname" name="signup_lastname" type="text" class="login__input" maxlength="20" placeholder="Last Name">
                        </div>
                        <div class="signup__field">
                            <i class="login__icon fas fa-lock"></i>
                            <input id="signup_password" name="signup_password" type="password" class="login__input" maxlength="15" placeholder="Password">
                            <i id="toggle-signup-password" class="showpw__icon fas fa-eye-slash"></i>
                        </div>
                        <button class="button finishcreate__submit" type="submit" name="finishcreate__submit">Sign Up</button>                
                    </form>
                    <div class="signup-section">
                        <h4 class="login-text">Already have an account?</h4>
                        <button class="signup__submit" id="back-to-login-btn">Log In</button>
                    </div>
                </div>
            </div>
            
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>		
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>		
        </div>
    </div>
    <script src="Javascript.js"></script>
    
<?php
// Start the session to store user login information
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "db_portal");

// Check for a successful connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize login attempts if not set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

// Initialize cooldown end time if not set
if (!isset($_SESSION['cooldown_end'])) {
    $_SESSION['cooldown_end'] = 0;
}

// Cooldown duration in seconds
$cooldown_duration = 5;

// Check if there's an active cooldown
if (time() < $_SESSION['cooldown_end']) {
    $remaining_time = $_SESSION['cooldown_end'] - time();
    echo "<script>alert('Due to multiple failed attempts, please wait {$remaining_time} seconds before trying again.');</script>";
} elseif (isset($_POST['login__submit'])) {
    // Reset cooldown if it's expired
    $_SESSION['cooldown_end'] = 0;

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($username) || empty($password)) {
        echo "<script>alert('Please fill in all fields.');</script>";
    } else {
        $sql = "SELECT * FROM tbl_admin WHERE USN = ? AND PASSWORD = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Error preparing query: ' . $conn->error);
        }

        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Reset attempts and cooldown on successful login
            $_SESSION['login_attempts'] = 0;
            $_SESSION['cooldown_end'] = 0;
            $_SESSION['username'] = $username;
            $_SESSION['logged_in'] = true;
            echo "<script>window.location.href = 'Dashboard.php';</script>";
        } else {
            // Increment failed login attempts
            $_SESSION['login_attempts'] += 1;

            if ($_SESSION['login_attempts'] >= 3) {
                $_SESSION['cooldown_end'] = time() + $cooldown_duration;
                $_SESSION['login_attempts'] = 0;  // Reset attempts after triggering cooldown
                echo "<script>alert('Invalid Username or Password. Due to multiple failed attempts, please wait {$cooldown_duration} seconds before trying again.');</script>";
            } else {
                echo "<script>alert('Invalid Username or Password. Please try again.');</script>";
            }
        }

        $stmt->close();
    }
}

// Handling signup submission
if (isset($_POST['finishcreate__submit'])) {
    $signup_usn = mysqli_real_escape_string($conn, $_POST['signup_usn']);
    $signup_firstname = mysqli_real_escape_string($conn, $_POST['signup_firstname']);
    $signup_lastname = mysqli_real_escape_string($conn, $_POST['signup_lastname']);
    $signup_password = mysqli_real_escape_string($conn, $_POST['signup_password']);

    // Check for empty fields
    if (empty($signup_usn) || empty($signup_firstname) || empty($signup_lastname) || empty($signup_password)) {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
    // Check for invalid characters in first and last names
    else if (!preg_match("/^[a-zA-Z]+$/", $signup_firstname) || !preg_match("/^[a-zA-Z]+$/", $signup_lastname)) {
        echo "<script>alert('First Name and Last Name should contain only letters.');</script>";
    } else {
        // Check if username already exists
        $sql = "SELECT * FROM tbl_admin WHERE USN = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            die('Error preparing query: ' . $conn->error);
        }

        $stmt->bind_param("s", $signup_usn);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Username already exists. Please choose a different username.');</script>";
        } else {
            $full_name = $signup_firstname . ' ' . $signup_lastname;

            // Insert the new user into the database
            $sql = "INSERT INTO tbl_admin (USN, FULL_NAME, PASSWORD) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            if ($stmt === false) {
                die('Error preparing query: ' . $conn->error);
            }

            // Bind parameters for the insert statement
            $stmt->bind_param("sss", $signup_usn, $full_name, $signup_password);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>alert('Admin Account created successfully!'); window.location.href = 'Login.php';</script>";
            } else {
                echo "<script>alert('Error creating account. Please try again.');</script>";
            }
            
            $stmt->close();
        }
    }
}

$conn->close();
?>
    
</body>
</html>