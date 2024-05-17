<?php
// Khai báo biến $open với giá trị "users" để xác định trang đang mở
$open = "users";

require_once __DIR__ . "/../autoload/autoload.php";
// Lấy giá trị của tham số 'id' từ đầu vào và chuyển đổi thành số nguyên
$id = intval(getInput('id'));

// Lấy thông tin của người dùng có id tương ứng từ bảng "users"
$Editusers = $db->fetchID("users", $id);

// Kiểm tra nếu yêu cầu phương thức là POST (người dùng gửi dữ liệu)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tạo mảng $data chứa các thông tin người dùng nhập vào
    $data = [
        "name" => postInput('name'),
        "email" => postInput("email"),
        "phone" => postInput("phone"),
        "address" => postInput("address"),
    ];
    
    // Khởi tạo mảng $error để lưu trữ các lỗi (nếu có)
    $error = [];
    
    // Kiểm tra và xử lý các trường hợp thiếu dữ liệu đầu vào
    if (postInput('name') == '') {
        $error['name'] = "Vui lòng nhập họ tên đầy đủ.";
    }
    if (postInput('email') == '') {
        $error['email'] = "Vui lòng nhập email.";
    } else {
        // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu hay chưa
        if (postInput("email") != $Editusers['email']) {
            $is_check = $db->fetchOne("users", "email='" . $data['email'] . "' ");
            if ($is_check != NULL) {
                $error['email'] = "Email đã tồn tại.";
            }
        }
    }
    if (postInput('phone') == '') {
        $error['phone'] = "Vui lòng nhập số điện thoại.";
    }
    if (postInput('address') == '') {
        $error['address'] = "Vui lòng nhập địa chỉ.";
    }
   
    // Nếu không có lỗi, tiến hành cập nhật thông tin người dùng
    if (empty($error)) {
        $updated = $db->update("users", $data, array("id" => $id));
        if ($updated > 0) {
            // Cập nhật thành công, thông báo thành công
            $_SESSION['success'] = "Cập nhật người dùng thành công!";
        } else {
            // Cập nhật không thành công, thông báo lỗi
            $_SESSION['error'] = "Cập nhật người dùng không thành công!";
        }
    }
}
?>
<?php require_once __DIR__ . "/../layout-personal/headeruser.php"; ?>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Cập nhật người dùng</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="#">Người dùng</a></li>
            <li class="breadcrumb-item active">Cập nhật người dùng</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-folder-plus mr-1"></i>
                <b> Cập nhật người dùng</b>
            </div>
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="alert alert-success" style="margin-top:20px;">
                    <strong style="color:#155724;">THÀNH CÔNG! </strong><?php echo $_SESSION['success'];
                    unset($_SESSION['success']) ?>
                </div>
            <?php endif ?>
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="alert alert-danger" style="margin-top:20px;">
                    <strong style="color:#a94442;">LỖI! </strong><?php echo $_SESSION['error'];
                    unset($_SESSION['error']) ?>
                </div>
            <?php endif ?>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Họ Tên</b></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Nguyễn Văn A" name="name" value="<?php echo $Editusers['name'] ?>">
                            <?php if (isset($error['name'])) : ?>
                                <p class="text-danger">  <?php echo $error['name'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Email</b></label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email@gmail.com" name="email" value="<?php echo $Editusers['email'] ?>">
                            <?php if (isset($error['email'])) : ?>
                                <p class="text-danger">  <?php echo $error['email'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Điện Thoại</b></label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="inputEmail3" placeholder="099666999" name="phone" value="<?php echo $Editusers['phone'] ?>">
                            <?php if (isset($error['phone'])) : ?>
                                <p class="text-danger">  <?php echo $error['phone'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Địa Chỉ</b></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Khu phố X - Phường Y - Quận Z - TP HCM" name="address" value="<?php echo $Editusers['address'] ?>">
                            <?php if (isset($error['address'])) : ?>
                                <p class="text-danger">  <?php echo $error['address'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-md-2 col-sm-8">
                            <button type="submit" class="btn btn-success">Cập nhật người dùng</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php require_once __DIR__ . "/../layout-personal/footeruser.php"; ?>
