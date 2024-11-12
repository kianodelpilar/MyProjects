<?php
include 'session-file.php';
include 'database/classes/User.php';
include 'database/classes/Post.php';

$userLoggedIn = $_SESSION['username'];
if(isset($_SESSION['username'])){
    $user_details_query = mysqli_query($con, "SELECT * FROM admin WHERE adminname='$userLoggedIn'")or die(mysqli_error($con));
    $user = mysqli_fetch_array($user_details_query);
}
else{
    header("Location: admin.php");
}

if(isset($_POST['comment_id']))
{
    $comment_id = $_POST['comment_id'];
    // Remove user
    $query = mysqli_query($con, "DELETE FROM comments WHERE id='$comment_id'") or die("Error: ".mysqli_error($con));
    // Remove user's posts
    $post_query = mysqli_query($con, "DELETE FROM posts WHERE post_id='$post_id'") or die("Error: ".mysqli_error($con));
    
    if($query && $post_query){
        echo "User with ID $comment_id and associated posts have been deleted successfully.";
    } else {
        echo "Failed to delete user with ID $comment_id.";
    }
}
?>
