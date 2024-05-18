<?php
session_start();

// Xóa các biến session của admin
unset($_SESSION['admin_name']);
unset($_SESSION['admin_id']);

// Hủy toàn bộ session
session_destroy();

// Chuyển hướng người dùng đến trang đăng nhập
header("Location: /congngheshop/login/");
exit();
