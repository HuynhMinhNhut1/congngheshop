<?php 
// Đã bao gồm autoload để tự động tải các lớp cần thiết
require_once __DIR__. "/autoload/autoload.php";

// Lấy giá trị của key từ tham số GET và chuyển đổi thành số nguyên
$key = intval(getInput('key'));

// Xóa sản phẩm khỏi giỏ hàng trong phiên làm việc của người dùng
unset($_SESSION['cart'][$key]);

// Đặt thông báo thành công để hiển thị sau khi xóa sản phẩm
$_SESSION['success'] = "Đã xóa thành công sản phẩm trong giỏ hàng!";

// Chuyển hướng người dùng đến trang giỏ hàng sau khi xóa sản phẩm
header("location:cart_product.php");
?>
