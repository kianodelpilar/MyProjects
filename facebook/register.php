<?php
include 'session-file.php';
include 'handlers/register_handler.php';
include 'handlers/login_handler.php';
?>

<!DOCTYPE html>
<html lang="en">
<style>
    body {
    background-color: midnightblue;
    font-family: Arial, sans-serif;
    color: white; /* Set text color to white for better contrast */
}

.top-content {
    background-color: #3b5998;
    
    color: white;
    text-align: center;
    padding: 20px;
}

.wreper {
    display: flex;
    justify-content: center; /* Center the forms horizontally */
    align-items: center; /* Center the forms vertically */
    margin-top: 20px;
}


/* Set a fixed width for the forms */
.signin-form,
.signup-form {
    background-color: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 50px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: 400px; /* Adjust the width as needed */
    margin: 0 10px; /* Add some margin between forms */
}

/* Align the forms vertically */
.form-top-left h3,
.form-top-left p {
    text-align: center;
}

.form-top-left h3 {
    color: #3b5998;
    margin-bottom: 10px;
}

.form-top-left p {
    color: #555;
    font-size: 0.9em;
}

.form-bottom label {
    color: #555;
}

.form-bottom input[type="text"],
.form-bottom input[type="email"],
.form-bottom input[type="password"],
.form-bottom input[type="date"],
.form-bottom input[type="radio"] {
    width: calc(100% - 20px); /* Adjust width to account for padding */
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box; /* Ensure padding is included in width calculation */
}

.form-bottom button {
    background-color: #3b5998;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 3px;
    cursor: pointer;
}

.footer {
    text-align: center;
    margin-top: 20px;
    color: #555;
    font-size: 0.8em;
}

    .menu-link {
    display: inline-block;
    font-size: 15px;
    color: white;
    margin-right: 20px; /* Adjust as needed */
   transition: color 0.3s;
}
.menu-link:hover {
    color: black; /* Change to your desired hover color */
    text-decoration: underline; /* Underline on hover */
}


</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Mura'g Facebook</title>
    
    <link rel="shortcut icon" href="logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  
    <link rel="stylesheet" href="assets/fontawesome-free-5.15.1-web/css/all.css">
</head>
<body>
    <div class="top-content">
    <a href="index.php"><h1 class="menu-link">Home</h1></a>
    <a href="moderator.php"><h1 class="menu-link">Moderator</h1></a>
    <a href="admin.php"><h1 class="menu-link">Admin</h1></a>
    <h1 style="font-size:35px;">Mura'g Facebook</h1>
    <p>Sign up and start sharing your photos and updates with your friends.</p>
</div>


    <div class="wreper">
        <!-- Login Form -->
        <div class="signin-form">
            <div class="form-top-left">
                <h3>Login to our site</h3>
                <p>Enter Email and password to log on:</p>
            </div>
            <div class="form-bottom">
                <form action="register.php" method="POST" class="login-form">
                    <label for="form-email">Email Address</label>
                    <input type="email" name="log_email" placeholder="Email Address" value="<?php if(isset($SESSION['log_email'])) { echo $_SESSION['log_email']; } ?>" required> <br>
                    <label for="form-password">Password</label>
                    <span class="pswd_icon_bg" onclick="log_pswd_toggale()"><i class="fa-regular fa-eye" id="pswd_show" style="margin: auto;"></i></span>
                    <input type="password" id="login_pswd" name="log_password" placeholder="Password" required> <br>
                    <p><a href="forgot-password.php">Forgot Password?</a></p>
                    <?php if(in_array("Email or Password was incorrect", $error_array_login)) echo "<p class='alert'>Email or Password was incorrect</p>"; ?>
                    <button type="submit" style="margin-bottom:20px" name="login_button">Login</button>
                    
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="wreper">
            <!-- Sign Up Form -->
            <div class="signup-form">
                <div class="form-top-left">
                    <h3>Sign up now</h3>
                    <p>Fill in the form below to get instant access:</p>
                </div>
                <div class="form-bottom">
                    <form action="register.php" method="POST">
                        <!-- First Name -->
                        <label for="form-first-name">First Name</label>
                        <input type="text" name="reg_fname" placeholder="First Name" value="<?php if(isset($_SESSION['reg_fname'])) { echo $_SESSION['reg_fname']; } ?>" required>
                        <br>
                        <?php if(in_array("Your first name must be between 2 and 25 characters", $error_array)) echo "<p class='alert'>Your first name must be between 2 and 25 characters</p>"; ?>

                        <!-- Last Name -->
                        <label for="form-last-name">Last Name</label>
                        <input type="text" name="reg_lname" placeholder="Last Name" value="<?php if(isset($_SESSION['reg_lname'])) { echo $_SESSION['reg_lname']; } ?>" required>
                        <br>
                        <?php if(in_array("Your last name must be between 2 and 25 characters", $error_array)) echo "<p class='alert'>Your last name must be between 2 and 25 characters</p>"; ?>

                        <!-- Username -->
                        <label for="username">Username</label>
                        <input type="text" name="username" placeholder="Username" value="<?php if(isset($_SESSION['username'])) { echo $_SESSION['username']; } ?>" required>
                        <br>
                        <?php if(in_array("Username already exists", $error_array)) echo "<p class='alert'>Username already exists</p>"; ?>
                        <?php if(in_array("Username must be between 2 and 20", $error_array)) echo "<p class='alert'>Username must be between 2 and 20</p>"; ?>
                        <?php if(in_array("You username can only contain english characters or numbers", $error_array)) echo "<p class='alert'>You username can only contain english characters or numbers</p>"; ?>

                        <!-- Email -->
                        <label for="form-email">Email Address</label>
                        <input type="email" name="reg_email" placeholder="Email Address" value="<?php if(isset($_SESSION['reg_email'])) { echo $_SESSION['reg_email']; } ?>" required>
                        <br>
                        <?php if(in_array("Email already in use<br>", $error_array)) echo "<p class='alert'>Email already in use</p>"; ?>
                        <?php if(in_array("Email is invalid format<br>", $error_array)) echo "<p class='alert'>Email is invalid format</p>"; ?>
                        <?php if(in_array("Email doesn't match", $error_array)) echo "<p class='alert'>Email doesn't match</p>"; ?>

                        <!-- Confirm Email -->
                        <label for="form-email">Confirm Email Address</label>
                        <input type="email" name="reg_email2" placeholder="Confirm Email Address" value="<?php if(isset($_SESSION['reg_email2'])) { echo $_SESSION['reg_email2']; } ?>" required>
                        <br>

                        <!-- Password -->
                        <label for="form-password">Password</label>
                        <span class="pswd_icon_bg" onclick="pswd_toggale()"><i class="fa-regular fa-eye" id="pswd_show" style="margin: auto;"></i></span>
                        <input type="password" id="reg_pswd" name="reg_password" placeholder="Password" required>
                        <br>
                        <?php if(in_array("Your password must be between 5 and 30 characters or numbers", $error_array)) echo "<p class='alert'>Your password must be between 5 and 30 characters or numbers</p>"; ?>

                        <!-- Confirm Password -->
                        <label for="form-password">Confirm Password</label>
                        <span class="pswd_icon_bg" onclick="pswd_toggale()"><i class="fa-regular fa-eye" id="pswd_show" style="margin: auto;"></i></span>
                        <input type="password" id="reg_pswd" name="reg_password2" placeholder="Confirm Password" required>
                        <br>
                        <?php if(in_array("Your passwords doesn't match", $error_array)) echo "<p class='alert'>Your passwords doesn't match</p>"; ?>
                        
                        <!-- Date of Birth -->
                        <label for="form-dob">Date of Birth</label>
                        <input type="date" name="dob" value="<?php if(isset($_SESSION['dob'])) { echo $_SESSION['dob']; } ?>" required>
                        <br>

                        <!-- Gender -->
                        <label for="form-gender">Gender</label>
                        <input type="radio" name="gender" value="Male" required> Male
                        <input type="radio" name="gender" value="Female" required> Female
                        <br>

                        <button type="submit" style="margin-bottom:20px" name="reg_user">Sign Up</button>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    function log_pswd_toggale(){
        var pswd = document.getElementById("login_pswd");
        var icon = document.getElementById("pswd_show");
        if(pswd.type === "password"){
            pswd.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }else{
            pswd.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }

    function pswd_toggale(){
        var pswd = document.getElementById("reg_pswd");
        var icon = document.getElementById("pswd_show");
        if(pswd.type === "password"){
            pswd.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }else{
            pswd.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
