<?php
    // Khai báo biến $open với giá trị "transaction" để xác định trang đang mở
    $open = "transaction";

    // Nạp tệp autoload.php để sử dụng các hàm và biến đã định nghĩa sẵn
    require_once __DIR__. "/../../autoload/autoload.php";

    // Lấy giá trị id từ URL và chuyển đổi thành kiểu số nguyên
    $id = intval(getInput('id'));

    // Lấy thông tin giao dịch dựa trên id
    $EditTransaction = $db->fetchID("transaction", $id);

    // Kiểm tra nếu giao dịch không tồn tại thì hiển thị thông báo lỗi và chuyển hướng về trang quản lý giao dịch
    if (empty($EditTransaction)) {
        $_SESSION['error'] = "Dữ liệu không tồn tại";
        redirectAdmin("transaction");
    }

    // Kiểm tra nếu giao dịch đã được xử lý thì không cho phép thay đổi trạng thái và hiển thị thông báo lỗi
    if ($EditTransaction['status'] == 1) {
        $_SESSION['error'] = "Đơn hàng đã được xử lý và bạn KHÔNG THỂ thay đổi trạng thái của nó!";
        redirectAdmin("transaction");
    }

    // Thay đổi trạng thái giao dịch: nếu trạng thái hiện tại là 0 thì đổi thành 1 và ngược lại
    $status = $EditTransaction['status'] == 0 ? 1 : 0;

    // Cập nhật trạng thái giao dịch trong cơ sở dữ liệu
    $update = $db->update("transaction", array("status" => $status), array("id" => $id));

    // Kiểm tra nếu cập nhật thành công
    if ($update > 0) {
        $_SESSION['success'] = "Cập nhật giao dịch thành công!";

        // Truy vấn để lấy thông tin sản phẩm và số lượng trong đơn hàng dựa trên id giao dịch
        $sql = "SELECT product_id, qty FROM orders WHERE transaction_id = $id";
        $order = $db->fetchsql($sql);

        // Lặp qua từng sản phẩm trong đơn hàng và cập nhật số lượng tồn kho
        foreach ($order as $item) {
            $idproduct = intval($item['product_id']); // Lấy id sản phẩm
            $product = $db->fetchID("product", $idproduct); // Lấy thông tin sản phẩm

            // Tính toán số lượng sản phẩm còn lại sau khi trừ số lượng đã mua
            $number = $product['number'] - $item['qty'];

            // Cập nhật số lượng sản phẩm và số lần thanh toán
            $up_pro = $db->update("product", array("number" => $number, "pay" => $product['pay'] + 1), array("id" => $idproduct));
        }

        // Chuyển hướng về trang quản lý giao dịch
        redirectAdmin("transaction");
    } else {
        // Nếu cập nhật không thành công thì hiển thị thông báo lỗi và chuyển hướng về trang quản lý giao dịch
        $_SESSION['error'] = "Cập nhật giao dịch KHÔNG thành công!";
        redirectAdmin("transaction");
    }
?>
