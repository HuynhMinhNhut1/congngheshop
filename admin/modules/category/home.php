<?php
// Thiết lập biến mở để đánh dấu trang đang mở là trang danh mục
$open = "category";

// Đưa vào file autoload.php để load các file cần thiết
require_once __DIR__ . "/../../autoload/autoload.php";

// Lấy ID danh mục từ input và chuyển đổi sang kiểu số nguyên
$id = intval(getInput('id'));

// Lấy thông tin danh mục cần chỉnh sửa từ CSDL bằng ID
$EditCategory = $db->fetchID("category", $id);

// Kiểm tra nếu không tìm thấy danh mục
if (empty($EditCategory)) {
    $_SESSION['error'] = "Dữ liệu không tồn tại";
    redirectAdmin("category");
}

// Đảo ngược trạng thái hiển thị của danh mục (0 -> 1, 1 -> 0)
$home = $EditCategory['home'] == 0 ? 1 : 0;

// Cập nhật trạng thái hiển thị mới vào CSDL
$update = $db->update("category", array("home" => $home), array("id" => $id));

// Kiểm tra kết quả cập nhật
if ($update > 0) {
    $_SESSION['success'] = "Cập nhật danh mục thành công!";
    redirectAdmin("category");
} else {
    $_SESSION['error'] = "Cập nhật danh mục không thành công!";
    redirectAdmin("category");
}
?>
