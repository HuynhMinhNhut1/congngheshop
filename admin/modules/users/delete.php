<?php
// Thiết lập biến mở để chỉ định phần trang đang hoạt động
$open = "users";
// Đường dẫn tới tệp autoload.php để load các file cần thiết
require_once __DIR__. "/../../autoload/autoload.php"; 

// Lấy ID của người dùng cần xóa từ request
$id = intval(getInput('id'));

// Lấy thông tin người dùng cần xóa từ cơ sở dữ liệu
$deleteUser = $db->fetchID("users", $id);

// Kiểm tra xem người dùng có tồn tại hay không
if(empty($deleteUser)) {
    $_SESSION['error'] = "Data does not exist";
    redirectAdmin("users");
}

// Thực hiện xóa người dùng khỏi cơ sở dữ liệu
$num = $db->delete("users", $id);

// Kiểm tra xem xóa thành công hay không
if($num > 0) {
    $_SESSION['success'] = "Delete user successfully!";
} else {
    $_SESSION['error'] = "Delete user NOT successful!";
}

// Sau khi thực hiện xóa, chuyển hướng trở lại trang quản lý người dùng
redirectAdmin("users");
?>
