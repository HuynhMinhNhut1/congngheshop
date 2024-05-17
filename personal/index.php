<?php
    // Khai báo biến $open với giá trị "users"
    $open = "users";
    
    // Yêu cầu tệp autoload.php từ thư mục autoload để sử dụng các hàm và biến đã định nghĩa sẵn
    require_once __DIR__. "/../autoload/autoload.php";

    // Lấy giá trị của tham số 'id' từ đầu vào và chuyển đổi thành số nguyên
    $id = intval(getInput('id'));

    // Sử dụng hàm fetchID để lấy thông tin của người dùng có id tương ứng từ bảng "users"
    $Editusers = $db->fetchID("users", $id);

    // Truy vấn để lấy tất cả các giao dịch của người dùng có id tương ứng từ bảng "transaction"
    $get_transaction = "select * from transaction where users_id=$id";
    $run_transaction = mysqli_query($con, $get_transaction);

    // Đếm số lượng giao dịch của người dùng có id tương ứng
    $count_transaction = mysqli_num_rows($run_transaction);
?>
<?php require_once __DIR__. "/../layout-personal/headeruser.php"; ?>

<?php require_once __DIR__. "/../layout-personal/footeruser.php"; ?>
