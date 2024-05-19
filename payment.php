<?php
// Tải file autoload.php để sử dụng các class trong ứng dụng
require_once __DIR__ . "/autoload/autoload.php";

 // Kiểm tra nếu người dùng chưa đăng nhập, thông báo và chuyển hướng
if (!isset($_SESSION['name_id'])) {
    echo "<script>alert('Bạn cần đăng nhập trước khi chọn sản phẩm!');</script>";
    echo "<script>window.location='/congngheshop/login.php';</script>";
    exit; // Kết thúc script sau khi chuyển hướng
}


// Lấy thông tin người dùng từ CSDL dựa trên ID người dùng trong session
$users = $db->fetchID("users", intval($_SESSION['name_id']));

// Xử lý khi người dùng gửi form đặt hàng (POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'amount' => $_SESSION['total_bill'], // Số tiền thanh toán (tổng hóa đơn)
        'users_id' => $_SESSION['name_id'], // ID người dùng đặt hàng
        'note' => postInput("note") // Ghi chú cho đơn hàng
    ];

    // Thêm thông tin đơn hàng vào bảng 'transaction' trong CSDL
    $id_trans = $db->insert("transaction", $data);

    if ($id_trans > 0) {
        // Nếu thêm đơn hàng thành công, thêm chi tiết đơn hàng (sản phẩm trong giỏ hàng) vào bảng 'orders'
        foreach ($_SESSION['cart'] as $key => $value) {
            $data2 = [
                'transaction_id' => $id_trans, // ID của đơn hàng
                'product_id' => $key, // ID sản phẩm
                'qty' => $value['qty'], // Số lượng sản phẩm
                'price' => $value['price'], // Giá sản phẩm
            ];

            $id_insert = $db->insert("orders", $data2);
        }

        // Đặt session 'success' thông báo đặt hàng thành công và chuyển hướng đến trang thông báo
        $_SESSION['success'] = "Lưu vào để đặt hàng thành công! Chúng tôi sẽ liên hệ với bạn ngay khi có thể .";
        header("location:notification.php");
    } else {
        // Nếu thêm đơn hàng không thành công, đặt session 'error' thông báo lỗi
        $_SESSION['error'] = "Đơn hàng của bạn chưa được xử lý ! vui lòng thử lại !";
    }
}
?>

<!-- This is HEADER -->
<?php require_once __DIR__ . "/layouts/header.php"; ?> <!-- Gọi file header.php -->
<?php require_once __DIR__ . "/layouts/banner.php"; ?> <!-- Gọi file banner.php -->
<!-- END HEADER -->

<div class="col-md-9 bor" style="padding-bottom: 15px;">
    <section class="box-main1">
        <!-- ----------MAIN-------------- -->
        <h3 class="title-main"><a href=""></a>Thanh toán</h3>
        <form class="form-horizontal" action="" method="POST" role="form" style="margin-top:30px">
            <!-- Hiển thị thông tin người dùng -->
            <div class="form-group">
                <label for="firstName" class="col-sm-3 control-label">Họ tên</label>
                <div class="col-sm-6">
                    <input type="text" readonly="" id="firstName" placeholder="Nguyễn Văn A" class="form-control" name="name" value="<?php echo $users['name'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-3 control-label">Email </label>
                <div class="col-sm-6">
                    <input type="email" readonly="" id="email" placeholder="Email@gmail.com" class="form-control" name="email" value="<?php echo $users['email'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="phoneNumber" class="col-sm-3 control-label">Phone number </label>
                <div class="col-sm-6">
                    <input type="phoneNumber" readonly="" id="phoneNumber" placeholder="099999999" class="form-control" name="phone" value="<?php echo $users['phone'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="lastName" class="col-sm-3 control-label">Địa chỉ</label>
                <div class="col-sm-6">
                    <input type="text" readonly="" id="lastName" placeholder="Khu phố X - Phường Y - Quận Z - TP HCM" class="form-control" name="address" value="<?php echo $users['address'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="lastName" class="col-sm-3 control-label">Số tiền thanh toán</label>
                <div class="col-sm-6">
                    <input type="text" readonly="" id="lastName" placeholder="" class="form-control" name="total_bill" value="<?php echo formatPrice($_SESSION['total_bill']) ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="lastName" class="col-sm-3 control-label">Ghi chú</label>
                <div class="col-sm-6">
                    <input type="note" id="lastName" placeholder="Delivery address" class="form-control" name="note" value="">
                </div>
            </div>
            <!-- Nút xác nhận đơn đặt hàng -->
            <button type="submit" class="btn btn-success col-md-6 col-md-offset-3 " style="margin-bottom:50px">Xác nhận đơn đặt</button>
        </form> <!-- /form -->
    </section>
</div>

<!-- This is Footer -->
<?php require_once __DIR__ . "/layouts/footer.php"; ?> <!-- Gọi file footer.php -->
<!-- END Footer -->
