<?php
// Đoạn mã để thêm một admin mới
$open = "admin";
require_once __DIR__ . "/../../autoload/autoload.php";

// Thu thập dữ liệu từ form
$data = [
    "name" => postInput('name'),
    "email" => postInput("email"),
    "phone" => postInput("phone"),
    "password" => md5(postInput("password")), // Sử dụng md5 để mã hóa mật khẩu
    "address" => postInput("address"),
    "level" => postInput("level"),
];

// Xử lý khi nhận được dữ liệu POST từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $error = [];

    // Kiểm tra và xử lý lỗi khi không nhập tên
    if (postInput('name') == '') {
        $error['name'] = "Vui lòng nhập họ và tên đầy đủ";
    }

    // Kiểm tra và xử lý lỗi khi không nhập email
    if (postInput('email') == '') {
        $error['email'] = "Vui lòng nhập địa chỉ email";
    } else {
        // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu hay chưa
        $is_check = $db->fetchOne("admin", "email='" . $data['email'] . "' ");
        if ($is_check != NULL) {
            $error['email'] = "Email đã tồn tại";
        }
    }

    // Kiểm tra và xử lý lỗi khi không nhập số điện thoại
    if (postInput('phone') == '') {
        $error['phone'] = "Vui lòng nhập số điện thoại";
    }

    // Kiểm tra và xử lý lỗi khi không nhập mật khẩu
    if (postInput('password') == '') {
        $error['password'] = "Vui lòng nhập mật khẩu";
    }

    // Kiểm tra và xử lý lỗi khi không nhập địa chỉ
    if (postInput('address') == '') {
        $error['address'] = "Vui lòng nhập địa chỉ";
    }

    // Kiểm tra và xử lý lỗi khi không chọn level
    if (postInput('level') == '') {
        $error['level'] = "Vui lòng chọn level";
    }

    // Kiểm tra và xử lý lỗi khi mật khẩu không khớp
    if ($data['password'] != md5(postInput("re_password"))) {
        $error['re_password'] = "Mật khẩu không khớp";
    }

    // Nếu không có lỗi
    if (empty($error)) {
        // Thực hiện thêm admin vào cơ sở dữ liệu
        $id_insert = $db->insert("admin", $data);
        if ($id_insert) {
            $_SESSION['success'] = "Thêm admin thành công!";
            redirectAdmin("admin");
        } else {
            $_SESSION['error'] = "Thêm admin không thành công!";
            redirectAdmin("admin");
        }
    }
}
?>
<?php require_once __DIR__ . "/../../layouts/header.php"; ?>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Thêm admin</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Trang chính</a></li>
            <li class="breadcrumb-item"><a href="#">admin</a></li>
            <li class="breadcrumb-item active">Thêm mới</li>
        </ol>
        <div class="cleanfix"></div>

        <!-- Hiển thị thông báo lỗi -->
        <?php require_once __DIR__ . "/../../../partials/notification.php"; ?>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-folder-plus mr-1"></i>
                <b> Thêm admin mới</b>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <!-- Form nhập thông tin admin -->
                    <!-- Input tên đầy đủ -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Tên đầy đủ</b></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Nguyễn Văn A" name="name" value="<?php echo $data['name'] ?>">
                            <?php if (isset($error['name'])) : ?>
                                <p class="text-danger"> <?php echo $error['name'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Input Email -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Email</b></label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email@gmail.com" name="email" value="<?php echo $data['email'] ?>">
                            <?php if (isset($error['email'])) : ?>
                                <p class="text-danger"> <?php echo $error['email'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Input Số điện thoại -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Phone</b></label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="inputEmail3" placeholder="0777973754" name="phone" value="<?php echo $data['phone'] ?>">
                            <?php if (isset($error['phone'])) : ?>
                                <p class="text-danger"> <?php echo $error['phone'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Input Mật khẩu -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Mật Khẩu</b></label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="inputEmail3" placeholder="***********" name="password">
                            <?php if (isset($error['password'])) : ?>
                                <p class="text-danger"> <?php echo $error['password'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Input Xác nhận mật khẩu -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Xác nhận mật khẩu</b></label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="inputEmail3" placeholder="***********" name="re_password" required>
                            <?php if (isset($error['re_password'])) : ?>
                                <p class="text-danger"> <?php echo $error['re_password'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Input Địa chỉ -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Địa chỉ</b></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Khu Vực x - Phường Y - Quận Z - TP CT" name="address" value="<?php echo $data['address'] ?>">
                            <?php if (isset($error['address'])) : ?>
                                <p class="text-danger"> <?php echo $error['address'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Dropdown Level -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Level</b></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="level">
                                <option value="1" <?php echo isset($data['level']) && $data['level'] == 1 ?
                                                        "selected='selected'" : '' ?>> Admin </option>
                                <option value="2" <?php echo isset($data['level']) && $data['level'] == 2 ?
                                                        "selected='selected'" : '' ?>> CTV </option>
                            </select>
                            <?php if (isset($error['level'])) : ?>
                                <p class="text-danger"> <?php echo $error['level'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Nút Submit -->
                    <div class="form-group row">
                        <div class="offset-md-2 col-sm-8">
                            <button type="submit" class="btn btn-success">Thêm mới</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php require_once __DIR__ . "/../../layouts/footer.php"; ?>
