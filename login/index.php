<?php
// Khởi động phiên làm việc
session_start();

// Đưa các file thư viện vào
require_once __DIR__ . "/../libraries/Database.php";
require_once __DIR__ . "/../libraries/Function.php";

// Khởi tạo đối tượng Database
$db = new Database;

// Mảng chứa các lỗi
$error = [];

// Xử lý khi nhận phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        "email" => postInput("email"),
        "password" => postInput("password"),
    ];

    // Kiểm tra email
    if (postInput('email') == '') {
        $error['email'] = "Nhập email";
    }

    // Kiểm tra mật khẩu
    if (postInput('password') == '') {
        $error['password'] = "Nhập mật khẩu";
    }

    // Nếu không có lỗi, tiến hành kiểm tra đăng nhập
    if (empty($error)) {
        // Lấy thông tin người dùng từ CSDL
        $is_check = $db->fetchOne("admin", "email = '" . $data['email'] . "' AND password = '" . md5($data['password']) . "'");

        // Nếu tìm thấy người dùng, thực hiện đăng nhập
        if ($is_check != NULL) {
            $_SESSION['admin_name'] = $is_check['name'];
            $_SESSION['admin_id'] = $is_check['id'];
            $_SESSION['success'] = "Đăng nhập thành công!"; // Lưu thông báo đăng nhập thành công vào session
            echo "<script>alert('Login successfully!'); window.location.href='../admin/';</script>"; // Hiển thị thông báo và chuyển hướng
            exit(); // Kết thúc sau khi chuyển hướng
        } else {
            $error['login'] = "Email or mật khẩu không đúng";
        }
    }
}
?>

<!-- Đoạn mã HTML -->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<div class="container" style="padding-top:20px;">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please sign in</h3>
                </div>
                <div class="panel-body">
                    <?php if (isset($error['login'])) : ?>
                        <div class="alert alert-danger"><?php echo $error['login']; ?></div>
                    <?php endif; ?>
                    <form accept-charset="UTF-8" role="form" action="" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="text">
                                <?php if (isset($error['email'])) : ?>
                                    <p class="text-danger"><?php echo $error['email']; ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password">
                                <?php if (isset($error['password'])) : ?>
                                    <p class="text-danger"><?php echo $error['password']; ?></p>
                                <?php endif; ?>
                            </div>
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
