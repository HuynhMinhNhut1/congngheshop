<?php
    // Khai báo một biến $open để chỉ định tên của mục hiện tại, ở đây là "transaction".
    $open = "transaction";
    require_once __DIR__. "/../../autoload/autoload.php"; 

    // Lấy giá trị ID từ đầu vào và chuyển đổi nó thành số nguyên.
    $id = intval(getInput('id'));

    // Lấy thông tin của giao dịch có ID tương ứng từ cơ sở dữ liệu.
    $viewtransaction = $db->fetchID("transaction" ,$id);

    // Kiểm tra xem giao dịch có tồn tại hay không.
    if(empty($viewtransaction))
    {
        // Nếu không tồn tại, lưu thông báo lỗi vào session và chuyển hướng về trang quản lý giao dịch.
        $_SESSION['error'] = "Dữ liệu không tồn tại";
        redirectAdmin("transaction");
    }

    // Xóa giao dịch có ID tương ứng khỏi cơ sở dữ liệu.
    $num = $db->delete("transaction", $id);

    // Kiểm tra kết quả của việc xóa.
    if($num > 0)
    {
        // Nếu thành công, lưu thông báo thành công vào session và chuyển hướng về trang quản lý giao dịch.
        $_SESSION['success'] = "Xóa giao dịch thành công !";
        redirectAdmin("transaction");
    }
    else
    {
        // Nếu không thành công, lưu thông báo lỗi vào session và chuyển hướng về trang quản lý giao dịch.
        $_SESSION['error'] = "Xóa giao dịch không thành công !";
        redirectAdmin("transaction");
    }
?>
