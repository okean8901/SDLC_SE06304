<?php
include "connect.php"; // Kết nối đến cơ sở dữ liệu

$error = ''; // Biến để lưu thông báo lỗi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Băm mật khẩu
    $email = $_POST['email'];
    $address = $_POST['address'];
    $birthday = $_POST['birthday'];
    $phoneNumber = $_POST['phonenumber'];
    $role = $_POST['role'];

    // Kiểm tra xem tên người dùng đã tồn tại chưa
    $stmt = $conn->prepare("SELECT UserID FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Tên này đã được dùng, vui lòng dùng tên khác.";
    } else {
        // Kiểm tra xem người dùng đã chọn vai trò chưa
        if (empty($role)) {
            $error = "Please select a role.";
        } else {
            // Thêm dữ liệu vào bảng Users
            $stmt = $conn->prepare("INSERT INTO Users (Username, Password, Role, Email, Address, `Phone Number`, Birthday) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $username, $password, $role, $email, $address, $phoneNumber, $birthday);

            if ($stmt->execute()) {
                // Đăng ký thành công, chuyển hướng người dùng
                header("Location: login.php"); // Tạo một trang thành công
                exit();
            } else {
                $error = "Error: " . $stmt->error; // Hiển thị lỗi nếu có
            }
        }
    }

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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
        .text-danger{
            color: red;
        }

        .register-box {
            position: relative;
            width: 350px;
            padding: 30px;
            background: rgba(0, 0, 0, 0.5);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.6);
            border-radius: 15px;
        }

        .register-box h2 {
            margin: 0 0 20px;
            color: #fff;
            text-align: center;
        }

        .user-box {
            position: relative;
            margin-bottom: 13px;
        }

        .user-box input, .user-box select {
            width: 100%;
            padding: 10px 0;
            font-size: 16px;
            color: #fff;
            border: none;
            border-bottom: 1px solid #fff;
            background: transparent;
            outline: none;
        }

        .user-box select option {
            background: #333;
            color: #fff;
        }

        .user-box label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 10px 0;
            font-size: 12px;
            color: #fff;
            pointer-events: none;
            transition: 0.5s;
        }

        .user-box input:focus ~ label,
        .user-box input:valid ~ label,
        .user-box select:focus ~ label,
        .user-box select:valid ~ label {
            top: -20px;
            left: 0;
            color: #03e9f4;
            font-size: 10px;
        }

        .check-box {
            margin: 15px 0;
        }
        
        .check-box div {
            margin-bottom: 10px;
        }

        .check-box label {
            color: #fff;
            font-size: 14px;
        }

        .Register-button {
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

        .Register-button:hover {
            background: #0284a5;
        }

        @media (max-width: 480px) {
            .register-box {
                width: 90%;
                padding: 20px;
            }
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
    <form class="register-box" action="register.php" method="POST">
        <h2>Registration</h2>
        <div class="user-box">
            <input type="text" name="username" required="">
            <label>Username</label>
        </div>
        <div class="user-box">
            <input type="password" name="password" required="">
            <label>Password</label>
        </div>
        <div class="user-box">
            <input type="email" name="email" required="">
            <label>Email</label>
        </div>
        <div class="user-box">
            <input type="address" name="address" required="">
            <label>Address</label>
        </div>
        <div class="user-box">
            <input type="text" name="birthday" required="">
            <label>Birthday</label>
        </div>
        <div class="user-box">
            <input type="text" name="phonenumber" required="">
            <label>Phone Number</label>
        </div>
        <div class="user-box">
            <select name="role" required="">
                <option value="">Select Role</option>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="check-box">
            <div class="robot">
                <input type="checkbox" name="robot" id="robot" required>
                <label for="robot">I'm Not a Robot</label>
            </div>
        </div>
        <span class="text-danger"><?php echo $error; ?></span>

        <button class="Register-button" type="submit">Register</button>
    </form>
</body>
</html>