<?php 
include 'session-file.php';

if(!isset($_SESSION['moderator_logged_in'])){
    header("Location: moderator.php");
    exit();
}

$userLoggedIn = $_SESSION['moderatorname'];

$user_details_query = mysqli_query($con, "SELECT * FROM moderator WHERE moderatorname='$userLoggedIn'") or die(mysqli_error($con));
$moderator = mysqli_fetch_array($user_details_query);

if (!$moderator) {
    header("Location: moderator.php");
    exit();
}

// Total users
$count_user_query = mysqli_query($con, "SELECT COUNT(*) as count FROM users") or die(mysqli_error($con));
$count_user = mysqli_fetch_assoc($count_user_query)['count'];

// Total posts
$count_post_query = mysqli_query($con, "SELECT COUNT(*) as count FROM posts") or die(mysqli_error($con));
$count_post = mysqli_fetch_assoc($count_post_query)['count'];

// Total comments
$count_comments_query = mysqli_query($con, "SELECT COUNT(*) as count FROM comments") or die(mysqli_error($con));
$count_comments = mysqli_fetch_assoc($count_comments_query)['count'];

// Viewed messages
$count_viewed_messages_query = mysqli_query($con, "SELECT COUNT(*) as count FROM messages WHERE viewed = 'yes'") or die(mysqli_error($con));
$count_viewed_messages = mysqli_fetch_assoc($count_viewed_messages_query)['count'];

// Fetch all users
$users_query = mysqli_query($con, "SELECT * FROM users") or die(mysqli_error($con));
$users = mysqli_fetch_all($users_query, MYSQLI_ASSOC);

// Fetch all posts
$posts_query = mysqli_query($con, "SELECT * FROM posts") or die(mysqli_error($con));
$posts = mysqli_fetch_all($posts_query, MYSQLI_ASSOC);

// Fetch all comments
$comments_query = mysqli_query($con, "SELECT * FROM comments") or die(mysqli_error($con));
$comments = mysqli_fetch_all($comments_query, MYSQLI_ASSOC);

// Fetch all messages
$messages_query = mysqli_query($con, "SELECT * FROM messages") or die(mysqli_error($con));
$messages = mysqli_fetch_all($messages_query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/fontawesome-free-5.15.1-web/css/all.css">
    <link rel="shortcut icon" href="images/favicon.jpg" type="image/x-icon">
    <title>Moderator Home</title>
    <style>
        @font-face {
            font-family: 'roboto';
            src: url('assets/fonts/Roboto-MediumItalic.ttf');
        }
        body {
            line-height: 17px;
            background-color: #EEEEEE;
            font-family: Roboto;
            display: flex;
        }
        .sidebar {
            width: 200px;
            background-color: blue;
            padding: 20px;
            height: 100vh;
        }
        .sidebar a {
            display: block;
            padding: 10px;
            color: white;
            text-decoration: none;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: cadetblue;
        }
        .sidebar a:hover {
            background-color: #1abc9c;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
        .total {
            display: flex;
            justify-content: space-around;
        }
        .t_user, .t_post, .t_comment, .t_message {
            background: indigo;
            width: 260px;
            height: 150px;
            line-height: 35px;
            margin: 10px;
            align-items: center;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
            cursor: pointer;
        }
        .heading {
            background: white;
            padding: 18px;
            border-radius: 5px;
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        button {
            border: none;
            font-size: 14px;
            padding: 5px 12px;
            border-radius: 4px;
            color: white;
            background: black;
        }
        .section-content {
            margin-top: 50px;
        }
        .section {
            display: none;
            margin-top: 20px;
        }
        .section table {
            width: 100%;
            border-collapse: collapse;
        }
        .section table, .section th, .section td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div id="floating-message" style="display: none; position: fixed; bottom: 20px; right: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; border-radius: 5px; z-index: 999;"></div>

    <div class="sidebar">
        <h3 style="color: white;">Moderator Panel</h3>
        <a href="#" onClick='javascript:show("remove_user_section")'>Remove User</a>
        <a href="#" onClick='javascript:show("remove_post_section")'>Remove Post</a>
      
        <a href="#" onClick='javascript:show("remove_comment_section")'>Remove Comment</a>
       
    </div>
    <div class="main-content">
        <div class="heading">
            <span>Hello <b><?php echo $moderator['moderatorname']; ?></b>, Welcome Moderator :)</span>
            <a href="#" onclick="confirmLogout()"><button>Logout</button></a>

        </div>
        <div class="total">
            <div class="t_user" onclick="show('user_section')">
                <i class="fas fa-user fa-3x"></i>
                <span style="font-size: 22px;">Total Users</span>
                <span style="font-size: 25px;"><?php echo $count_user; ?></span>
            </div>
            <div class="t_post" onclick="show('post_section')">
                <i class="fas fa-copy fa-3x"></i>
                <span style="font-size: 22px;">Total Posts</span>
                <span style="font-size: 25px;"><?php echo $count_post; ?></span>
            </div>
            <div class="t_comment" onclick="show('comment_section')">
                <i class="fas fa-comment fa-3x"></i>
                <span style="font-size: 22px;">Total Comments</span>
                <span style="font-size: 25px;"><?php echo $count_comments; ?></span>
            </div>
            <div class="t_message" onclick="show('message_section')">
                <i class="fas fa-envelope fa-3x"></i>
                <span style="font-size: 22px;">View Messages</span>
                <span style="font-size: 25px;"><?php echo $count_viewed_messages; ?></span>
            </div>
        </div>
        <div class="section-content">
            <div id="user_section" class="section">
                <h3>All Users</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) { ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['first_name']; ?></td>
                                <td><?php echo $user['last_name']; ?></td>
                                <td><?php echo $user['username']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div id="post_section" class="section">
                <h3>All Posts</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Body</th>
                            <th>Added By</th>
                            <th>Date Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post) { ?>
                            <tr>
                                <td><?php echo $post['id']; ?></td>
                                <td><?php echo $post['body']; ?></td>
                                <td><?php echo $post['added_by']; ?></td>
                               

                                <td><?php echo $post['date_added']; ?></td>
                                <!-- Add more columns as needed -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div id="comment_section" class="section">
                <h3>All Comments</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Post Body</th>
                            <th>Posted By</th>
                            <th>Posted To</th>
                            <th>Date Added</th>
                            <!-- Add more columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment) { ?>
                            <tr>
                                <td><?php echo $comment['id']; ?></td>
                                <td><?php echo $comment['post_body']; ?></td>
                                <td><?php echo $comment['posted_by']; ?></td>
                                <td><?php echo $comment['posted_to']; ?></td>
                                <td><?php echo $comment['date_added']; ?></td>
                                <!-- Add more columns as needed -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div id="message_section" class="section">
                <h3>All Messages</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Body</th>
                            <th>Date</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $message) { ?>
                            <tr>
                                <td><?php echo $message['id']; ?></td>
                                <td><?php echo $message['user_from']; ?></td>
                                <td><?php echo $message['user_to']; ?></td>
                                <td><?php echo $message['body']; ?></td>
                                <td><?php echo $message['date']; ?></td>
                                
                                <!-- Add more columns as needed -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- Remove User Section -->
<div id="remove_user_section" class="section">
    <h3>Remove User</h3>
    <form id="remove_user_form">
        <input type="text" name="user_id" placeholder="Enter User ID">
        <button type="submit">Remove User</button>
    </form>
</div>

<!-- Remove Post Section -->
<div id="remove_post_section" class="section">
    <h3>Remove Post</h3>
    <form id="remove_post_form">
        <input type="text" name="post_id" placeholder="Enter Post ID">
        <button type="submit">Remove Post</button>
    </form>
</div>

<!-- Remove Message Section -->
<div id="remove_message_section" class="section">
    <h3>Remove Message</h3>
    <form id="remove_message_form">
        <input type="text" name="message_id" placeholder="Enter Message ID">
        <button type="submit">Remove Message</button>
    </form>
</div>

<!-- Remove Comment Section -->
<div id="remove_comment_section" class="section">
    <h3>Remove Comment</h3>
    <form id="remove_comment_form">
        <input type="text" name="comment_id" placeholder="Enter Comment ID">
        <button type="submit">Remove Comment</button>
    </form>
</div>


        </div>
    </div>

    <script>
        function confirmLogout() {
    if (confirm("Do you want to log out?")) {
        window.location.href = 'logout.php';
    }
}
// Function to show a floating message
function showFloatingMessage(message) {
    const floatingMessage = document.getElementById("floating-message");
    floatingMessage.textContent = message;
    floatingMessage.style.display = "block";

    setTimeout(function() {
        floatingMessage.style.display = "none";
    }, 3000); // Hide the message after 3 seconds
}
        // AJAX for Remove User
    document.getElementById("remove_user_form").addEventListener("submit", function(event) {
        event.preventDefault();
        let user_id = this.querySelector("[name='user_id']").value;
        let formData = new FormData();
        formData.append('user_id', user_id);
        fetch('remove_user.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
    .then(data => {
        alert(data); // Remove this line if you don't want the default alert
        showFloatingMessage("User successfully removed!");
    })
    .catch(error => console.error('Error:', error));
});
    // AJAX for Remove Post
document.getElementById("remove_post_form").addEventListener("submit", function(event) {
    event.preventDefault();
    let post_id = this.querySelector("[name='post_id']").value;
    let formData = new FormData();
    formData.append('post_id', post_id);
    fetch('remove_post.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Remove this line if you don't want the default alert
        showFloatingMessage("User successfully removed!");
    })
    .catch(error => console.error('Error:', error));
});

// AJAX for Remove Message
document.getElementById("remove_message_form").addEventListener("submit", function(event) {
    event.preventDefault();
    let message_id = this.querySelector("[name='message_id']").value;
    let formData = new FormData();
    formData.append('message_id', message_id);
    fetch('remove_message.php', {
        method: 'POST',
        body: formData
    })
   .then(response => response.text())
    .then(data => {
        alert(data); // Remove this line if you don't want the default alert
        showFloatingMessage("User successfully removed!");
    })
    .catch(error => console.error('Error:', error));
});

// AJAX for Remove Comment
document.getElementById("remove_comment_form").addEventListener("submit", function(event) {
    event.preventDefault();
    let comment_id = this.querySelector("[name='comment_id']").value;
    let formData = new FormData();
    formData.append('comment_id', comment_id);
    fetch('remove_comment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Remove this line if you don't want the default alert
        showFloatingMessage("User successfully removed!");
    })
    .catch(error => console.error('Error:', error));
});


    // Repeat similar AJAX calls for Remove Post, Remove Message, and Remove Comment
        function show(sectionId) {
            hideAll();
            document.getElementById(sectionId).style.display = "block";
        }

        function hideAll() {
            document.getElementById("user_section").style.display = "none";
            document.getElementById("post_section").style.display = "none";
            document.getElementById("comment_section").style.display = "none";
            document.getElementById("message_section").style.display = "none";
            document.getElementById("remove_user_section").style.display = "none";
            document.getElementById("remove_post_section").style.display = "none";
            document.getElementById("remove_message_section").style.display = "none";
            document.getElementById("remove_comment_section").style.display = "none";
        }
    </script>
</body>
</html>
