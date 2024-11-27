<?php
session_start();

// Hủy tất cả các session
$_SESSION = array();
session_destroy();

// Hủy cookies đăng nhập
setcookie("user_login", "", time() - 3600);
setcookie("user_password", "", time() - 3600);

// Chuyển hướng về trang login
header("location: login.php");
exit;
?>