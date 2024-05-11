<?php 
// Đã bao gồm autoload để tự động tải các lớp cần thiết
require_once __DIR__. "/autoload/autoload.php";

// Lấy giá trị key và qty từ request
$key = intval(getInput('key'));
$qty = intval(getInput('qty'));

// Cập nhật số lượng của sản phẩm trong giỏ hàng
$_SESSION['cart'][$key]['qty'] = $qty;

// Kết nối tới cơ sở dữ liệu MySQL
$con = mysqli_connect("localhost", "root", "", "shopcongnghe");

// Tạo truy vấn SQL để lấy số lượng sản phẩm từ cơ sở dữ liệu
$get_products = "SELECT number FROM product WHERE id = {$key}";

// Thực thi truy vấn SQL
$run_products = mysqli_query($con, $get_products);

// Lấy số lượng sản phẩm từ kết quả truy vấn
$qty_products = mysqli_fetch_assoc($run_products)['number'];

// Chuyển đổi số lượng sản phẩm từ dạng chuỗi sang số nguyên
$n = (int)$qty_products;

// Kiểm tra số lượng sản phẩm có đủ để thêm vào giỏ hàng không
if ($n < $qty) {
    // Nếu số lượng không đủ, cập nhật lại số lượng trong giỏ hàng bằng số lượng có sẵn
    $_SESSION['cart'][$key]['qty'] = $n;
    echo 0; // Trả về 0 nếu số lượng không đủ
} else {
    echo 1; // Trả về 1 nếu số lượng đủ để thêm vào giỏ hàng
}
?>
