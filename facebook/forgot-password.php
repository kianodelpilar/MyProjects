<?php
session_start();

// Include PHPMailer
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Database connection
$conn = new mysqli('localhost', 'root', '', 'facebook');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate OTP
function generateOTP($length = 6) {
    $characters = '0123456789';
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $otp;
}

// Check the current step
$step = isset($_SESSION['reset_step']) ? $_SESSION['reset_step'] : 'email';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['check-email'])) {
        // Validate email
        $email = $_POST['email'];
        $result = $conn->query("SELECT * FROM users WHERE email='$email'");
        if ($result->num_rows > 0) {
            // Generate OTP
            $otp = generateOTP();

            // Save OTP to the database
            $conn->query("UPDATE users SET otp='$otp' WHERE email='$email'");

            // Save OTP and email to session
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;
            $_SESSION['reset_step'] = 'otp';

            // Send OTP to user's email
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'akoa36253@gmail.com';
                $mail->Password = 'lqmk ierh qjzy cnmj';
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('akoa36253@gmail.com', 'Mura,g Facebook');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Forgot Password OTP';
                $mail->Body    = 'Your OTP is: ' . $otp;

                $mail->send();
                echo '<script>alert("An OTP has been sent to your email. Please check your inbox.");</script>';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo '<script>alert("Email address does not exist.");</script>';
        }
    } elseif (isset($_POST['verify-otp'])) {
        // Verify OTP
        $input_otp = $_POST['otp'];
        if ($input_otp == $_SESSION['otp']) {
            $_SESSION['reset_step'] = 'new_password';
        } else {
            echo '<script>alert("OTP not matched.");</script>';
        }
    } elseif (isset($_POST['reset-password'])) {
        // Reset password
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        if ($new_password == $confirm_password) {
            $email = $_SESSION['email'];
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $conn->query("UPDATE users SET password='$hashed_password' WHERE email='$email'");
            echo '<script>alert("Password has been reset successfully.");</script>';
            session_destroy();
        } else {
            echo '<script>alert("Passwords do not match.");</script>';
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="logo.png" type="image/x-icon">
    <title>Forgot Password</title>
    <style>
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 80px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #dddfe2;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        h2 {
            text-align: center;
            color: #1877f2;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="email"],
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #dddfe2;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #1877f2;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #165db0;
        }
        .alert {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        .btn {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #1877f2;
            border: 1px solid #1877f2;
            padding: 10px 20px;
            border-radius: 4px;
        }
        .btn:hover {
            background-color: #1877f2;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Forgot Password</h2>
    <?php if ($step == 'email') { ?>
        <form method="post" action="">
            <label for="email">Enter your email address:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit" name="check-email">Continue</button>
            <a href="index.php" class="btn">Back</a>
        </form>
    <?php } elseif ($step == 'otp') { ?>
        <form method="post" action="">
            <label for="otp">Enter OTP:</label>
            <input type="text" id="otp" name="otp" required>
            <button type="submit" name="verify-otp">Confirm</button>
        </form>
    <?php } elseif ($step == 'new_password') { ?>
        <form method="post" action="">
            <label for="new_password">Enter new password:</label>
            <input type="password" id="new_password" name="new_password" required>
            <label for="confirm_password">Confirm new password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit" name="reset-password">Reset Password</button>
        </form>
    <?php } ?>
</div>

</body>
</html>