<?php
include 'session-file.php';

if(isset($_SESSION['username'])){
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM admin WHERE adminname='$userLoggedIn'") or die(mysqli_error($con));
    $user = mysqli_fetch_array($user_details_query);

    if(isset($_POST['moderatorname']) && isset($_POST['password']) && isset($_POST['confirm_password'])){
        $moderatorname = $_POST['moderatorname'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if($password === $confirm_password){
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the moderator data into the database
            $insert_query = mysqli_query($con, "INSERT INTO moderator (moderatorname, password) VALUES ('$moderatorname', '$hashed_password')") or die(mysqli_error($con));
            
            if($insert_query){
                $_SESSION['moderator_created'] = true;
            }else{
                $_SESSION['moderator_created'] = false;
            }
        }else{
            $_SESSION['moderator_created'] = false;
        }
    }
}else{
    header("Location: admin.php");
    exit();
}
header("Location: create_moderator.php");
exit();
?>
