<?php
require_once __DIR__. "/autoload/autoload.php"; 

// // Kiểm tra nếu người dùng chưa đăng nhập, thông báo và chuyển hướng về trang chủ
// if (!isset($_SESSION['name_id'])) {
//     echo "<script>alert('Bạn cần đăng nhập trước khi chọn sản phẩm!');location.href='login.php'</script>";
// }

// Lấy ID sản phẩm từ request và chuyển đổi sang kiểu số nguyên
$id = intval(getInput('id'));

// Lấy thông tin chi tiết của sản phẩm dựa trên ID
$product = $db->fetchID("product", $id);

// Kiểm tra nếu sản phẩm chưa có trong giỏ hàng, thêm mới vào giỏ hàng
if (!isset($_SESSION['cart'][$id])) {
    // Tạo một mục mới trong giỏ hàng với thông tin sản phẩm
    $_SESSION['cart'][$id]['name'] = $product['name'];
    $_SESSION['cart'][$id]['thumbar'] = $product['thumbar'];
    $_SESSION['cart'][$id]['price'] = ((100 - $product['sale']) * $product['price']) / 100; // Tính giá sau khi áp dụng giảm giá
    $_SESSION['cart'][$id]['qty'] = 1; // Số lượng ban đầu là 1
} else {
    // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng lên 1
    $_SESSION['cart'][$id]['qty'] += 1;
}

// Thông báo thành công và chuyển hướng đến trang giỏ hàng
echo "<script>alert('Đã Thêm sản phẩm vào giỏ hàng');location.href='cart_product.php'</script>";
?>
