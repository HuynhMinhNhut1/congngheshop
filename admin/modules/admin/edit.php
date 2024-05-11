<?php
// Đoạn mã để chỉnh sửa thông tin admin trong cơ sở dữ liệu
$open = "admin";
require_once __DIR__. "/../../autoload/autoload.php";

// Lấy ID của admin cần chỉnh sửa từ URL và chuyển đổi sang kiểu số nguyên
$id = intval(getInput('id'));

// Tìm admin trong cơ sở dữ liệu dựa trên ID
$Editadmin = $db->fetchID("admin", $id);

// Kiểm tra nếu không tìm thấy admin với ID cụ thể
if(empty($Editadmin))
{
    $_SESSION['error'] ="Dữ liệu không tồn tại";
    redirectAdmin("admin");
}

// Xử lý khi form được gửi đi (phương thức POST)
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Thu thập dữ liệu từ form
    $data =
    [
        "name" => postInput('name'),
        "email" => postInput("email"),
        "phone" => postInput("phone"),
        "password" => md5(postInput("password")), // Mã hóa mật khẩu
        "address" => postInput("address"),
        "level" => postInput("level"),
    ];

    $error = [];

    // Kiểm tra các trường dữ liệu
    if(postInput('name') == '')
    {
        $error['name'] = "Vui lòng nhập họ và tên đầy đủ";
    }
    if(postInput('email') == '')
    {
        $error['email'] = "Vui lòng nhập địa chỉ email";
    }
    else
    {
        if(postInput("email") != $Editadmin['email'])
        {
            // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu hay chưa
            $is_check = $db->fetchOne("admin", "email='".$data['email']."' ");
            if($is_check != NULL)
            {
                $error['email'] = "Email đã tồn tại";
            }
        }
    }
    if(postInput('phone') == '')
    {
        $error['phone'] = "Vui lòng nhập số điện thoại";
    }
    if(postInput('password') == '')
    {
        $error['password'] = "Vui lòng nhập mật khẩu";
    }
    if(postInput('address') == '')
    {
        $error['address'] = "Vui lòng nhập địa chỉ";
    }
    if(postInput('level') == '')
    {
        $error['level'] = "Vui lòng nhập level";
    }
    
    // Kiểm tra xác nhận mật khẩu
    if(postInput('password') != NULL && postInput("re_password") != NULL)
    {
        if(postInput('password') != postInput('re_password'))
        {
            $error['re_password'] = "Mật khẩu không khớp";
        }
        else
        {
            $data['password'] = md5(postInput('password')); // Cập nhật lại mật khẩu
        }
    }

    // Kiểm tra lỗi và cập nhật thông tin admin
    if(empty($error))
    {
        $id_update = $db->update("admin", $data, array("id" => $id));
        if($id_update > 0)
        {
            $_SESSION['success'] = "Cập nhật thông tin thành công!";
            redirectAdmin("admin");
        }
        else
        {
            $_SESSION['error'] = "Cập nhật thông tin thất bại!";
            redirectAdmin("admin");
        }
    }
}
?>

<?php require_once __DIR__. "/../../layouts/header.php"; ?>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Cập nhật admin</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Thêm mới</a></li>
            <li class="breadcrumb-item"><a href="#">admin</a></li>
            <li class="breadcrumb-item active">Cập nhật</li>
        </ol>
        <div class="cleanfix"></div>

        <!-- Hiển thị thông báo lỗi nếu có -->
        <?php require_once __DIR__. "/../../../partials/notification.php"; ?>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-folder-plus mr-1"></i>
                <b> Cập nhật admin</b>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <!-- Input Tên đầy đủ -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Tên đầy đủ</b></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Nguyễn Văn A" name="name" value="<?php echo $Editadmin['name'] ?>">
                            <?php if(isset($error['name'])): ?>
                                <p class="text-danger"> <?php echo $error['name'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Input Email -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Email</b></label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email@gmail.com" name="email" value="<?php echo $Editadmin['email'] ?>">
                            <?php if(isset($error['email'])): ?>
                                <p class="text-danger"> <?php echo $error['email'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Input Số điện thoại -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Phone</b></label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="inputEmail3" placeholder="099666999" name="phone" value="<?php echo $Editadmin['phone'] ?>">
                            <?php if(isset($error['phone'])): ?>
                                <p class="text-danger"> <?php echo $error['phone'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Input Mật khẩu -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Mật khẩu</b></label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="inputEmail3" placeholder="***********" name="password">
                            <?php if(isset($error['password'])): ?>
                                <p class="text-danger"> <?php echo $error['password'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Input Xác nhận mật khẩu -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Xác nhận</b></label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="inputEmail3" placeholder="***********" name="re_password">
                            <?php if(isset($error['re_password'])): ?>
                                <p class="text-danger"> <?php echo $error['re_password'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Input Địa chỉ -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Địa chỉ</b></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Khu phố X - Phường Y - Quận Z - TP HCM" name="address" value="<?php echo $Editadmin['address'] ?>">
                            <?php if(isset($error['address'])): ?>
                                <p class="text-danger"> <?php echo $error['address'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Dropdown Level -->
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Level</b></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="level">
                                <option value="1" <?php echo isset($Editadmin['level']) && $Editadmin['level'] == 1 ? "selected='selected'" : '' ?>> Admin </option>
                                <option value="2" <?php echo isset($Editadmin['level']) && $Editadmin['level'] == 2 ? "selected='selected'" : '' ?>> CTV </option>
                            </select>
                            <?php if(isset($error['level'])): ?>
                                <p class="text-danger"> <?php echo $error['level'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Button Cập nhật -->
                    <div class="form-group row">
                        <div class="offset-md-2 col-sm-8">
                            <button type="submit" class="btn btn-success">Cập nhật admin</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php require_once __DIR__. "/../../layouts/footer.php"; ?>
