<?php 
// Tải file autoload.php để sử dụng các class trong ứng dụng
require_once __DIR__. "/autoload/autoload.php"; 

// Xóa các session liên quan đến giỏ hàng và tổng hóa đơn
unset($_SESSION['cart']);
unset($_SESSION['total_bill']);
?>

<!-- This is HEADER -->
<?php require_once __DIR__. "/layouts/header.php" ;?> <!-- Gọi file header.php -->
<?php require_once __DIR__. "/layouts/banner.php" ;?> <!-- Gọi file banner.php -->
<!-- END HEADER -->

<div class="col-md-9 bor" style="padding-bottom: 15px;">
    <section class="box-main1" >
        <!-- ----------MAIN-------------- -->
        <h3 class="title-main"><a href="">Thông báo</a></h3>
        
        <!-- Hiển thị thông báo thành công nếu có -->
        <?php if(isset($_SESSION['success'])) :?>
            <div class="alert alert-success" style="margin-top:20px;">
                <strong style="color:#155724;">Thành Công ! </strong><?php echo $_SESSION['success']; unset($_SESSION['success']) ?>
            </div>
        <?php endif ?>
        
        <!-- Hiển thị thông báo lỗi nếu có -->
        <?php if(isset($_SESSION['error'])) :?>
            <div class="alert alert-danger" style="margin-top:20px;">
                <strong style="color:#a94442;">Lỗi ! </strong><?php echo $_SESSION['error']; unset($_SESSION['error']) ?>
            </div>
        <?php endif ?>
        
        <!-- Link trở lại trang chính -->
        <a href="index.php" class="btn btn-success"> Trở lại trang chính </a>
        <!-- ----------MAIN-------------- -->
    </section>
</div>

<!-- This is Footer -->
<?php require_once __DIR__. "/layouts/footer.php" ;?> <!-- Gọi file footer.php -->
<!-- END Footer -->
