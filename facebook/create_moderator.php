<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo.png" type="image/x-icon">
    <title>Create Moderator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #1877f2;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #166fe5;
        }
        .terms {
            font-size: 12px;
            margin-top: 10px;
        }
        .terms a {
            color: #1877f2;
            text-decoration: none;
        }
        .floating-message {
            display: none;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px 20px;
            border-radius: 5px;
            z-index: 9999;
        }
        .success-message {
            background-color: #4CAF50;
            color: white;
        }
        .error-message {
            background-color: #f44336;
            color: white;
        }
        #strength-meter {
            margin-top: 10px;
        }
        .strength-meter-fill {
            height: 5px;
            transition: width 0.3s;
        }
        .strength-meter-weak {
            background-color: #f44336;
        }
        .strength-meter-medium {
            background-color: #ff9800;
        }
        .strength-meter-strong {
            background-color: #4caf50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Moderator</h2>
        <form method="post" action="create_moderator_process.php">
            <label for="moderatorname">Enter Moderator Username:</label><br>
            <input type="text" id="moderatorname" name="moderatorname" required><br><br>
            <label for="password">Enter Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>
            <input type="submit" value="Create Moderator">
            <a href="admin_home.php" class="btn">Back</a>
        </form>
        <div id="floating_error" class="floating-message error-message">Password and Confirm Password do not match!</div>
        <div id="floating_success" class="floating-message success-message"><?php if(isset($_SESSION['moderator_created']) && $_SESSION['moderator_created']) { echo "Moderator created successfully!"; } ?></div>
    </div>
    <script>
        function showFloatingMessage(messageId) {
            document.getElementById(messageId).style.display = "block";
            setTimeout(function() {
                document.getElementById(messageId).style.display = "none";
            }, 3000);
        }
        document.querySelector("form").addEventListener("submit", function(event) {
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;
            if (password !== confirm_password) {
                event.preventDefault();
                showFloatingMessage("floating_error");
            }
        });
        <?php if(isset($_SESSION['moderator_created']) && $_SESSION['moderator_created']) { ?>
            document.addEventListener("DOMContentLoaded", function() {
                showFloatingMessage("floating_success");
            });
        <?php } ?>
    </script>
</body>
</html>
