<?php

session_start();

// Hủy tất cả dữ liệu trong session
session_unset();

// Hủy session
session_destroy();

// Chuyển hướng người dùng về trang đăng nhập hoặc trang chủ
header('Location: ../user/login.php'); // Hoặc bạn có thể chuyển hướng về trang chính
exit();
?>
