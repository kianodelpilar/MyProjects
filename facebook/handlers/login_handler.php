<?php


$error_array_login = array();

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if (!isset($_SESSION['last_email'])) {
    $_SESSION['last_email'] = '';
}

if(isset($_POST['login_button'])){
    $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['log_password'];

    // Reset login attempts if the email is different from the last one
    if ($_SESSION['last_email'] !== $email) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_email'] = $email;
    }

    $_SESSION['log_email'] = $email;

    $check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
    $check_login_query = mysqli_num_rows($check_database_query);

    if($check_login_query == 1){
        $row = mysqli_fetch_array($check_database_query);
        $username = $row['username'];
        $hashed_password = $row['password'];

        if(password_verify($password, $hashed_password)){
            $user_closed_query = mysqli_query($con,"SELECT * FROM users WHERE email='$email' AND user_closed='yes'");
            if(mysqli_num_rows($user_closed_query) == 1){
                $reopen_acc = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE email='$email'");
            }

            $_SESSION['username'] = $username;
            $_SESSION['login_attempts'] = 0; // Reset the login attempts on successful login
            $_SESSION['last_email'] = ''; // Reset the last email
            header("Location: index1.php");
            exit();
        }
        else{
            $_SESSION['login_attempts']++;
            array_push($error_array_login, "Email or Password was incorrect");
        }
    }
    else{
        $_SESSION['login_attempts']++;
        array_push($error_array_login, "Email or Password was incorrect");
    }

    if($_SESSION['login_attempts'] >= 3){
        header("Location: forgot-password.php");
        exit();
    }
}
?>
