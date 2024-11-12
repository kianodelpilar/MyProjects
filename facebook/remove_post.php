<?php
include 'session-file.php';

$userLoggedIn = $_SESSION['username'];
if(isset($_SESSION['username'])){
    $user_details_query = mysqli_query($con, "SELECT * FROM admin WHERE adminname='$userLoggedIn'")or die(mysqli_error($con));
    $user = mysqli_fetch_array($user_details_query);
}
else{
    header("Location: admin.php");
}

if(isset($_POST['post_id']))
{
    $post_id = $_POST['post_id'];
    // Remove user
    $query = mysqli_query($con, "DELETE FROM posts WHERE id='$post_id'") or die("Error: ".mysqli_error($con));
}
?>
