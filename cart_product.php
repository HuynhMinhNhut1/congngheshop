<?php
// Tải file autoload.php để có thể sử dụng các class mà không cần include nhiều lần
require_once __DIR__ . "/autoload/autoload.php";

// Khởi tạo biến tổng số tiền
$sum = 0;

// Kiểm tra nếu giỏ hàng không tồn tại hoặc không có sản phẩm nào trong giỏ hàng, hiển thị thông báo và chuyển hướng về trang chủ
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<script>alert('Không có sản phẩm nào trong giỏ hàng của bạn !');location.href='index.php'</script>";
}
?>

<!-- This is HEADER -->
<?php require_once __DIR__ . "/layouts/header.php"; ?>
<?php require_once __DIR__ . "/layouts/banner.php"; ?>
<!-- END HEADER -->

<div class="col-md-9 bor" style="padding-bottom: 15px;">
    <section class="box-main1">

        <!-- NOTIFICATION -->
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="alert alert-success" style="margin-top:20px;">
                <strong style="color:#155724;">Thành Công ! </strong><?php echo $_SESSION['success'];
                                                                    unset($_SESSION['success']) ?>
            </div>
        <?php endif ?>

        <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger" style="margin-top:20px;">
                <strong style="color:#a94442;">Lỗi ! </strong><?php echo $_SESSION['error'];
                                                                unset($_SESSION['error']) ?>
            </div>
        <?php endif ?>
        <!-- NOTIFICATION -->

        <!-- MAIN CONTENT -->
        <h3 class="title-main"><a href="">Giỏ hàng </a></h3>
        <table class="table table-hover" style="margin-bottom: 25px;" id="shoppingcart_info">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên sản phẩm</th>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Giá bán</th>
                    <th scope="col">Tổng</th>
                    <th scope="col">Lệnh</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $stt = 1;
                // Lặp qua từng sản phẩm trong giỏ hàng để hiển thị thông tin sản phẩm
                foreach ($_SESSION['cart'] as $key => $value) : ?>
                    <tr>
                        <td><?php echo $stt ?></td>
                        <td><?php echo $value['name'] ?></td>
                        <td>
                            <img src="<?php echo uploads() ?>product/<?php echo $value['thumbar'] ?>" width="80px" height="60px">
                        </td>
                        <td style="text-align: center;">
                            <input type="number" class="qty" value="<?php echo $value['qty'] ?>" min="1" max="10" step="1" name="qty" />
                        </td>
                        <td><?php echo formatPrice($value['price']) ?></td>
                        <td><?php echo formatPrice($value['qty'] * $value['price']) ?></td>
                        <td>
                            <!-- Nút cập nhật số lượng sản phẩm và nút xóa sản phẩm khỏi giỏ hàng -->
                            <a href="#" class="btn btn-xs btn-info updatecart" data-key=<?php echo $key ?>>
                                <i class="fa fa-refresh"></i>
                                Cập nhật
                            </a>
                            <a href="remove_cart.php?key=<?php echo $key ?>" class="btn btn-xs btn-danger">
                                <i class="fa fa-times"></i>
                                Xóa
                            </a>
                        </td>
                    </tr>
                    <?php 
                    // Tính tổng số tiền của từng sản phẩm
                    $sum += $value['price'] * $value['qty'];
                    // Lưu tổng số tiền vào session để sử dụng sau này
                    $_SESSION['total'] = $sum; ?>
                <?php 
                // Tăng biến đếm STT lên sau mỗi lần lặp
                $stt++;
                endforeach ?>
            </tbody>
        </table>

        <!-- Thông tin đặt hàng -->
        <div>
            <div class="col-md-6 pull-right">
                <ul class="list-group">
                    <li class="list-group-item">
                        <h3>Thông tin đặt hàng</h3>
                    </li>
                    <li class="list-group-item">
                        <span class="badge"><?php echo formatPrice($_SESSION['total']) ?></span> Số tiền tạm thời
                    </li>
                    <li class="list-group-item">
                        <span class="badge">10%</span> VAT
                    </li>
                    <li class="list-group-item">
                        <span class="badge"><?php echo sale($_SESSION['total']) ?> % </span> Giảm giá
                    </li>
                    <li class="list-group-item">
                        <span class="badge"><?php $_SESSION['total_bill'] = $_SESSION['total'] * 110 / 100;
                                            echo formatPrice($_SESSION['total_bill']) ?></span> Khoản phải trả
                    </li>
                    <li class="list-group-item">
                        <!-- Nút tiếp tục mua hàng và nút thanh toán -->
                        <a href="index.php" class="btn btn-warning">Tiếp tục mua hàng</a>
                        <a href="payment.php" class="btn btn-success">Thanh toán ngay</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END MAIN CONTENT -->
    </section>
</div>

<!-- This is Footer -->
<?php require_once __DIR__ . "/layouts/footer.php"; ?>
<!-- END Footer -->
