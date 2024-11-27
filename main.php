<?php
session_start();

// Kiểm tra xem user đã đăng nhập chưa
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            text-align: center;
            padding: 50px;
        }
        .welcome-message {
            margin-bottom: 20px;
        }
        .logout-btn {
            padding: 10px 20px;
            background-color: #03e9f4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: #0284a5;
        }
    </style>
</head>
<body>
    <div class="welcome-message">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
    </div>
    <a href="logout.php" class="logout-btn">Logout</a>
</body>
</html>