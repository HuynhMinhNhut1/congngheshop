<?php
require_once __DIR__ . "/autoload/autoload.php";

// Lấy dữ liệu từ form gửi đi
$data = [
    "email" => postInput("email"),
    "password" => postInput("password"),
];
// Mảng lưu trữ thông báo lỗi
$error = [];
// Xử lý khi form được gửi đi (POST method)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra nếu email trống
    if (postInput('email') == '') {
        $error['email'] = "Please enter email";
    }
    // Kiểm tra nếu password trống
    if (postInput('password') == '') {
        $error['password'] = "Please enter password";
    }
    // Nếu không có lỗi
    if (empty($error)) {
        // Kiểm tra thông tin đăng nhập trong database
        $is_check = $db->fetchOne("users", " email = '" . $data['email'] . "' AND password='" . md5($data['password']) . "'");
   
        // Nếu thông tin đăng nhập hợp lệ
        if ($is_check != NULL) {
            // Lưu tên người dùng và ID vào session
            $_SESSION['name_user'] = $is_check['name'];
            $_SESSION['name_id'] = $is_check['id'];
            echo "<script>alert('Đăng nhập thành công !');location.href='index.php'</script>'";
        } else {
            $_SESSION['error'] = "Đăng nhập không thành công !";
        }
    }
}
?>
<!-- This is HEADER -->
<?php require_once __DIR__ . "/layouts/header.php"; ?>
<?php require_once __DIR__ . "/layouts/banner.php"; ?>
<!-- END HEADER -->

<div class="col-md-9 bor" style="padding-bottom: 15px;">
    <section class="box-main1">
        <!-- ----------MAIN-------------- -->
        <h3 class="title-main"><a href="">Đăng nhập</a></h3>

        <!-- Hiển thị thông báo thành công nếu có -->
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="alert alert-success" style="margin-top:20px;">
                <strong style="color:#155724;">Đăng nhập thành công ! </strong><?php echo $_SESSION['success']; ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif ?>

        <!-- Hiển thị thông báo lỗi nếu có -->
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger" style="margin-top:20px;">
                <strong style="color:#a94442;">Đăng nhập thất bại ! </strong><?php echo $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif ?>

        <!-- Form đăng nhập -->
        <form class="form-horizontal" role="form" style="margin-top:30px" action="" method="POST">
            <div class="form-group">
                <label for="email" class="col-sm-3 control-label">Địa chỉ E-Mail</label>
                <div class="col-sm-6">
                    <input type="email" id="email" placeholder="Email@gmail.com" class="form-control" name="email">
                    <?php if (isset($error['email'])) : ?>
                        <p class="text-danger"> <?php echo $error['email'] ?> </p>
                    <?php endif ?>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Mật khẩu </label>
                <div class="col-sm-6">
                    <input type="password" id="password" placeholder="*************" class="form-control" name="password">
                    <?php if (isset($error['password'])) : ?>
                        <p class="text-danger"> <?php echo $error['password'] ?> </p>
                    <?php endif ?>
                </div>
            </div>
            <!-- Button đăng nhập -->
            <button type="submit" class="btn btn-primary col-md-6 col-md-offset-3 ">Đăng nhập</button>
            <!-- Link quên mật khẩu -->
            <a href="forgotpass.php" class="col-md-2 col-md-offset-5 " style="margin-top:10px;" id="forgot_pswd">Quên mật khẩu ?</a>
        </form>
    </section>
</div>
<!-- This is Footer -->
<?php require_once __DIR__ . "/layouts/footer.php"; ?>
<!-- END Footer -->
