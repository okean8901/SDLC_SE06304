<?php
session_start();
include "connect.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    if (!empty($username) && !empty($password)) {
        // Sử dụng câu lệnh SQL đơn giản để kiểm tra
        $sql = "SELECT * FROM Users WHERE Username='$username' AND Password='$password'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) == 1) {
            // Đăng nhập thành công
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            header("Location: main.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Please enter username and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
    font-family: "Poppins", sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
   background: url('imagesdlc.jpg') no-repeat center center fixed;
    background-size: cover;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-box {
    position: relative;
    width: 400px;
    padding: 60px;
    background: rgba(0, 0, 0, 0.5);
    box-shadow: 0 15px 25px rgba(0, 0, 0, 0.6);
    border-radius: 10px;
}

.login-box h2 {
    margin: 0 0 30px;
    color: #fff;
    text-align: center;
}

.user-box {
    position: relative;
    margin-bottom: 30px;
}

.user-box input {
    width: 100%;
    padding: 10px 0;
    font-size: 16px;
    color: #fff;
    border: none;
    border-bottom: 1px solid #fff;
    background: transparent;
    outline: none;
}

.user-box label {
    position: absolute;
    top: 0;
    left: 0;
    padding: 10px 0;
    font-size: 16px;
    color: #fff;
    pointer-events: none;
    transition: 0.5s;
}

.user-box input:focus ~ label,
.user-box input:valid ~ label {
    top: -20px;
    left: 0;
    color: #03e9f4;
    font-size: 12px;
}

.text-danger {
    color: #ff4444;
    font-size: 15px;
    margin-top: 10px;
    text-align: center;
}

.remember-forgot-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 20px 0;
}

.remember-me {
    display: flex;
    align-items: center;
}

.remember-me label {
    margin-left: 5px;
    color: #fff;
    font-size: 14px;
}

.forgot-password {
    color: #03e9f4;
    text-decoration: none;
    font-size: 14px;
}

.login-button {
    width: 100%;
    padding: 10px;
    background: #03e9f4;
    border: none;
    border-radius: 5px;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}

.login-button:hover {
    background: #0284a5;
}

.dont-have-an-account {
    text-align: center;
    margin-top: 20px;
    color: #fff;
}

.dont-have-an-account a {
    color: #03e9f4;
    text-decoration: none;
}
.logo {
    position: absolute;
    top: 20px;
    left: 20px;
    color: #03e9f4;
    font-size: 24px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 2px;
    text-shadow: 0 0 10px rgba(3, 233, 244, 0.5);
}
    </style>
</head>
<header class="logo">BTEC FPT</header>
<body>
    <form action="login.php" method="post" class="login-box">
        <h2>Login</h2>
        <?php if(!empty($error)): ?>
            <div class="text-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <div class="user-box">
            <input type="text" name="username" required="">
            <label>Username</label>
        </div>
        <div class="user-box">
            <input type="password" name="password" required="">
            <label>Password</label>
        </div>

        <section class="remember-forgot-box">
            <div class="remember-me">
                <input type="checkbox" name="remember-me" id="remember-me">
                <label for="remember-me">Remember me</label>
            </div>
            <a class="forgot-password" href="#">Forgot password?</a>
        </section>

        <button class="login-button" type="submit">Login</button>

        <h5 class="dont-have-an-account">
            Don't have an account? <a href="register.php"><b>Register</b></a>
        </h5>
    </form>
</body>
</html>