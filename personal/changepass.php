<?php
// Khai báo biến $open với giá trị "users" để xác định trang đang mở
$open = "users";
require_once __DIR__ . "/../autoload/autoload.php";

// Lấy giá trị của tham số 'id' từ đầu vào và chuyển đổi thành số nguyên
$id = intval(getInput('id'));

// Kiểm tra nếu yêu cầu phương thức là POST (người dùng gửi dữ liệu)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị password và re_password từ dữ liệu gửi lên
    $password = postInput('password');
    $re_password = postInput('re_password');

    // Khởi tạo mảng $error để lưu trữ các lỗi (nếu có)
    $error = [];

    // Kiểm tra nếu cả hai mật khẩu đều được nhập vào
    if ($password != '' && $re_password != '') {
        // Kiểm tra nếu mật khẩu và xác nhận mật khẩu không khớp
        if ($password != $re_password) {
            $error['re_password'] = "Mật khẩu không khớp";
        } else {
            // Nếu mật khẩu khớp, tạo mảng $data chứa mật khẩu đã mã hóa
            $data = [
                "password" => md5($password)
            ];

            // Cập nhật mật khẩu cho người dùng với id tương ứng
            $id_update = $db->update("users", $data, array("id" => $id));

            // Kiểm tra nếu cập nhật thành công
            if ($id_update > 0) {
                // Cập nhật thành công, thông báo thành công
                $_SESSION['success'] = "Cập nhật mật khẩu thành công!";
            } else {
                // Cập nhật không thành công, thông báo lỗi
                $_SESSION['error'] = "Cập nhật mật khẩu không thành công!";
            }
        }
    } else {
        // Nếu không nhập mật khẩu hoặc xác nhận mật khẩu, thông báo lỗi
        $error['password'] = "Vui lòng nhập mật khẩu";
        $error['re_password'] = "Vui lòng xác nhận mật khẩu";
    }
}
?>

<?php require_once __DIR__ . "/../layout-personal/headeruser.php"; ?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Cập nhật mật khẩu</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="#">Người dùng</a></li>
            <li class="breadcrumb-item active">Cập nhật mật khẩu</li>
        </ol>
        <div class="cleanfix"></div>

        <!-- Thông báo lỗi -->
        <?php require_once __DIR__ . "/../partials/notification.php"; ?>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-folder-plus mr-1"></i>
                <b> Cập nhật mật khẩu</b>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Mật khẩu</b></label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="inputEmail3" placeholder="***********" name="password">
                            <?php if (isset($error['password'])) : ?>
                                <p class="text-danger"> <?php echo $error['password'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Xác nhận mật khẩu</b></label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="inputEmail3" placeholder="***********" name="re_password">
                            <?php if (isset($error['re_password'])) : ?>
                                <p class="text-danger"> <?php echo $error['re_password'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-md-2 col-sm-8">
                            <button type="submit" class="btn btn-success">Cập nhật mật khẩu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . "/../layout-personal/footeruser.php"; ?>
