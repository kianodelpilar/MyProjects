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

    $user_detail_query = mysqli_query($con,"select * from admin where adminname='$userLoggedIn'");
    $user_array = mysqli_fetch_array($user_detail_query);

    // Total users
    $count_user_query = mysqli_query($con,"select * from users");
    $count_user = mysqli_num_rows($count_user_query);

    // Total posts
    $count_post_query = mysqli_query($con,"select * from posts");
    $count_post = mysqli_num_rows($count_post_query);

    // Total comments
    $count_comments_query = mysqli_query($con, "SELECT * FROM comments");
    $count_comments = mysqli_num_rows($count_comments_query);

    // Viewed messages
    $count_viewed_messages_query = mysqli_query($con, "SELECT * FROM messages WHERE viewed = 'yes'");
    $count_viewed_messages = mysqli_num_rows($count_viewed_messages_query);

    // Total moderators
    $count_moderators_query = mysqli_query($con, "SELECT * FROM moderator");
    $count_moderators = mysqli_num_rows($count_moderators_query);

    // Fetch all users
    $users_query = mysqli_query($con,"select * from users");
    $users = [];
    while ($row = mysqli_fetch_assoc($users_query)) {
        $users[] = $row;
    }

    // Fetch all posts
    $posts_query = mysqli_query($con,"select * from posts");
    $posts = [];
    while ($row = mysqli_fetch_assoc($posts_query)) {
        $posts[] = $row;
    }

    // Fetch all comments
    $comments_query = mysqli_query($con, "SELECT * FROM comments");
    $comments = [];
    while ($row = mysqli_fetch_assoc($comments_query)) {
        $comments[] = $row;
    }

    // Fetch all messages
    $messages_query = mysqli_query($con, "SELECT * FROM messages");
    $messages = [];
    while ($row = mysqli_fetch_assoc($messages_query)) {
        $messages[] = $row;
    }

    // Fetch all moderators
    $moderator_query = mysqli_query($con, "SELECT * FROM moderator");
    $moderators = [];
    while ($row = mysqli_fetch_assoc($moderator_query)) {
        $moderators[] = $row;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/fontawesome-free-5.15.1-web/css/all.css">
    <link rel="shortcut icon" href="logo.png" type="image/x-icon">
    <title>Home</title>

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
            background-color: #2c3e50;
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
            background-color: #34495e;
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
            background: cadetblue;
            width: 200px;
            height: 150px;
            line-height: 35px;
            margin: 10px;
            align-items: center;
            border-radius: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
            cursor: pointer;
        }
        .t_moderator {
            background: cadetblue;
            width: 200px;
            height: 150px;
            line-height: 35px;
            margin: 10px;
            align-items: center;
            border-radius: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
            cursor: pointer;
        }
        .heading {
            background: gold;
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
            color: gold;
            background: white;
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
        <h3 style="color: white;">Admin Panel</h3>
        <a href="#" onClick='javascript:show("remove_user_section")'>Remove User</a>
        <a href="#" onClick='javascript:show("remove_post_section")'>Remove Post</a>
        <a href="#" onClick='javascript:show("remove_comment_section")'>Remove Comment</a>
        <a href="#" onClick='javascript:show("remove_moderator_section")'>Remove Moderator</a>
        
        <a href="create_moderator.php" onClick='javascript:show("add_moderator_section")'>Create Moderator</a>
    </div>

    <div class="main-content">
        <div class="heading">
            <span>Hello <b><?php echo $user['adminname']; ?></b>, Welcome Admin :)</span>
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
                <span style="font-size: 25px;"></span>
            </div>
            <div class="t_moderator" onclick="show('moderator_section')">
                <i class="fas fa-user-shield fa-3x"></i>
                <span style="font-size: 22px;">Total Moderator/s</span>
                <span style="font-size: 25px;"><?php echo $count_moderators; ?></span>
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
                            <!-- Add more columns as needed -->
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
                                <!-- Add more columns as needed -->
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
                            <!-- Add more columns as needed -->
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
            <div id="moderator_section" class="section">
            <h3>All Moderators</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Moderator Name</th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($moderators as $moderator) { ?>
                        <tr>
                            <td><?php echo $moderator['id']; ?></td>
                            <td><?php echo $moderator['moderatorname']; ?></td>
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
<div id="remove_moderator_section" class="section">
    <h3>Remove Message</h3>
    <form id="remove_moderator_form">
        <input type="text" name="moderator_id" placeholder="Enter Moderator ID">
        <button type="submit">Remove Moderator</button>
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
        showFloatingMessage("Post successfully removed!");
    })
    .catch(error => console.error('Error:', error));
});

// AJAX for Remove moderator
document.getElementById("remove_moderator_form").addEventListener("submit", function(event) {
    event.preventDefault();
    let moderator_id = this.querySelector("[name='moderator_id']").value;
    let formData = new FormData();
    formData.append('moderator_id', moderator_id);
    fetch('remove_msg.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Remove this line if you don't want the default alert
        showFloatingMessage("Moderator successfully removed!");
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
        showFloatingMessage("Comment successfully removed!");
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
            document.getElementById("remove_moderator_section").style.display = "none";
            document.getElementById("remove_comment_section").style.display = "none";
        }
    </script>
</body>
</html>