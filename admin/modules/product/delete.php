<?php
// Thiết lập biến mở để đánh dấu trang đang mở là trang sản phẩm
$open = "product";

// Đưa vào file autoload.php để load các file cần thiết
require_once __DIR__ . "/../../autoload/autoload.php";

// Lấy ID sản phẩm từ input và chuyển đổi sang kiểu số nguyên
$id = intval(getInput('id'));

// Lấy thông tin sản phẩm cần xóa từ CSDL bằng ID
$editProduct = $db->fetchID("product", $id);

// Kiểm tra nếu không tìm thấy sản phẩm
if (empty($editProduct)) {
    $_SESSION['error'] = "Dữ liệu không tồn tại";
    redirectAdmin("product");
}

// Xóa sản phẩm từ CSDL bằng ID
$num = $db->delete("product", $id);

// Kiểm tra kết quả xóa sản phẩm
if ($num > 0) {
    $_SESSION['success'] = "Xóa sản phẩm thành công!";
    redirectAdmin("product");
} else {
    $_SESSION['error'] = "Xóa sản phẩm không thành công!";
    redirectAdmin("product");
}
?>
