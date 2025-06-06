<?php
session_start();

// Include 2FA functions
require_once '2fa-functions.php';

// Handle logout
if (isset($_GET['logout'])) {
    // Destroy the session
    session_unset();
    session_destroy();

    // Start a new session
    session_start();
}

$conn = mysqli_connect("localhost", "u283492965_nailarchitect", "WrongDirection432!", "u283492965_nailarchidb");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error_message = ""; // Initialize an error message variable

if (isset($_POST['login'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Fetch user data from the database
        $stmt = $conn->prepare("SELECT id, first_name, last_name, password, is_verified FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];
            $is_verified = $row['is_verified'];

            // Check if the account is verified
            if ($is_verified == 0) {
                $error_message = "Please verify your email before logging in. Check your inbox for the verification link.";
            }
            // Verify the password
            else if (password_verify($password, $hashedPassword)) {
                // Check if 2FA is enabled
                if (is2FAEnabled($conn, $row['id'], null)) {
                    // Store temporary session data for 2FA verification
                    $_SESSION['2fa_required'] = true;
                    $_SESSION['2fa_user_id'] = $row['id'];
                    $_SESSION['2fa_user_name'] = $row['first_name'] . ' ' . $row['last_name'];
                    $_SESSION['2fa_user_email'] = $email;
                    $_SESSION['2fa_admin'] = false;
                    
                    // Redirect to 2FA verification page
                    header("Location: 2fa-verify.php");
                    exit();
                } else {
                    // No 2FA required, proceed with normal login
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_name'] = $row['first_name'] . ' ' . $row['last_name'];
                    $_SESSION['user_email'] = $email;

                    // Redirect to members area
                    header("Location: members-lounge.php");
                    exit();
                }
            } else {
                $error_message = "Invalid email or password. Please try again.";
            }
        } else {
            $error_message = "Invalid email or password. Please try again.";
        }
    } else {
        $error_message = "Both fields are required.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="bg-gradient.css">
    <link rel="icon" type="image/png" href="Assets/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Nail Architect - Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #F2E9E9;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1500px;
            width: 100%;
            flex: 1;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
        }

        .book-now {
            padding: 8px 20px;
            background-color: #e8d7d0;
            border-radius: 20px;
            cursor: pointer;
        }

        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 1;
            animation: fadeIn 0.6s ease-out forwards;
            padding: 20px 0;
        }

        .login-form-container {
            background-color: rgb(245, 207, 207);
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            animation: fadeIn 0.7s ease-out forwards;
            border: 1px solid rgba(235, 184, 184, 0.3);
            box-shadow: 
                0 4px 16px rgba(0, 0, 0, 0.1),
                0 2px 8px rgba(0, 0, 0, 0.05),
                inset 0 1px 2px rgba(255, 255, 255, 0.3);
        }

        .login-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #F2E9E9;
            font-family: Poppins;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            background-color: #ffffff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .password-input-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            cursor: pointer;
            color: #666;
            font-size: 16px;
            user-select: none;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: #333;
        }

        .forgot-password {
            text-align: right;
            font-size: 12px;
            margin-top: 8px;
            cursor: pointer;
            transition: opacity 0.3s ease;
        }

        .forgot-password:hover {
            opacity: 0.7;
        }

        .login-button {
            padding: 12px 24px;
            background: linear-gradient(to right, #e6a4a4, #d98d8d);
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            display: block;
            width: 100%;
            margin-top: 20px;
            font-weight: bold;
        }

        .login-button:hover {
            background: linear-gradient(to right, #d98d8d, #ce7878);
            transform: translateY(-2px);
        }

        .signup-link {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
        }

        .signup-text {
            cursor: pointer;
            font-weight: bold;
            transition: opacity 0.3s ease;
        }

        .signup-text:hover {
            opacity: 0.7;
        }

        .back-button {
            display: inline-block;
            margin-top: 30px;
            font-size: 14px;
            cursor: pointer;
            position: relative;
            animation: fadeIn 0.8s ease-out forwards;
            align-self: center;
        }

        .back-button:after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            bottom: -2px;
            left: 0;
            background-color: #000;
            transition: width 0.3s ease;
        }

        .back-button:hover:after {
            width: 100%;
        }

        /* Toast notification for errors */
        .toast {
            visibility: hidden;
            width: 280px;
            margin: 0 auto;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 16px;
            position: absolute;
            z-index: 1;
            left: 0;
            right: 0;
            bottom: 100px;
            font-size: 17px;
        }

        .toast.show {
            visibility: visible;
            animation: fadeInOut 3s;
        }

        @keyframes fadeInOut {
            0%, 100% {
                opacity: 0;
            }
            10%, 90% {
                opacity: 1;
            }
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .login-form-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <div class="logo-container">
                <div class="logo">
                    <a href="index.php">
                        <img src="Assets/logo.png" alt="Nail Architect Logo">
                    </a>
                </div>
            </div>
            <div class="nav-links">
                <div class="nav-link">Services</div>
                <div class="book-now">Book Now</div>
                <div class="login-icon"></div>
            </div>
        </header>
        <div class="login-container">
            <div class="login-form-container">
                <div class="login-title">Welcome Back</div>

                <form id="login-form" method="POST" action="">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-input-container">
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                            <i id="toggle-password-icon" class="fa fa-eye toggle-password" onclick="togglePassword()"></i>
                        </div>
                        <div class="forgot-password" onclick="window.location.href='reset-password.php'">Forgot password?</div>
                    </div>

                    <button type="submit" name="login" class="login-button">Sign In</button>
                </form>

                <div class="signup-link">
                    Don't have an account? <span class="signup-text" onclick="window.location.href='sign-up.php'">Sign Up</span>
                </div>

                <?php if (!empty($error_message)): ?>
                    <div id="toast" class="toast"><?php echo $error_message; ?></div>
                    <script>
                        // Show toast message
                        const toast = document.getElementById("toast");
                        toast.classList.add("show");
                        setTimeout(() => {
                            toast.classList.remove("show");
                        }, 3000); // Toast is visible for 3 seconds
                    </script>
                <?php endif; ?>
            </div>

            <div class="back-button" onclick="window.location.href='index.php'">← Back to Home</div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-password-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const bookNow = document.querySelector('.book-now');
            bookNow.addEventListener('click', function() {
                window.location.href = 'booking.php';
            });

            const servicesLink = document.querySelector('.nav-link');
            servicesLink.addEventListener('click', function() {
                window.location.href = 'services.php';
            });

            // Fixed: Removed the PHP conditional that was causing errors
            const loginIcon = document.querySelector('.login-icon');
            if (loginIcon) {
                loginIcon.addEventListener('click', function() {
                    window.location.href = 'login.php';
                });
            }
        });
    </script>
</body>

</html>