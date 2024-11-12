

<?php

include 'session-file.php';

$error_array = array();

if (isset($_POST['login_btn'])) {
    $Username = filter_var($_POST['log_user'], FILTER_SANITIZE_EMAIL);

    $_SESSION['log_user'] = $Username;
    $password = $_POST['log_password'];

    $check_database_query = mysqli_query($con, "SELECT * FROM admin WHERE adminname='$Username' AND password='$password'") or die(mysqli_error($con));
    $check_login_query = mysqli_num_rows($check_database_query);

    if ($check_login_query == 1) {
        $row = mysqli_fetch_array($check_database_query) or die(mysqli_error($con));
        $username = $row['adminname'];

        $user_closed_query = mysqli_query($con, "SELECT * FROM admin WHERE adminname='$Username'");
        $_SESSION['username'] = $username;
        header("Location: admin_home.php");
        exit();
    } else {
        array_push($error_array, "Username or Password was incorrect");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/register.css">
    <link rel="shortcut icon" href="logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/fontawesome-free-5.15.1-web/css/all.css">
    <title>Welcome Admin</title>

    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        .login-container h3 {
            color: #1877f2;
            margin-bottom: 20px;
        }

        .login-container label {
            display: block;
            color: #1877f2;
            text-align: left;
            margin: 10px 0 5px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #dddfe2;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #1877f2;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .login-container button:hover {
            background-color: #166fe5;
        }

        .alert {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h3>Welcome Admin</h3>
        <form action="admin.php" method="POST">
            <label for="log_user">Username</label>
            <input type="text" name="log_user" placeholder="Username" value="<?php if(isset($_SESSION['log_user'])) echo $_SESSION['log_user']; ?>" required>

            <label for="log_password">Password</label>
            <input type="password" name="log_password" placeholder="Password" required>

            <?php if (in_array("Username or Password was incorrect", $error_array)) echo "<p class='alert'>Username or Password was incorrect</p>"; ?>

            <button type="submit" name="login_btn">Sign in!</button>
            <a href="register.php" class="btn">Back</a>
        </form>
    </div>
</body>
</html>
