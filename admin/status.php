<?php
    // Xác định trang hiện tại là "transaction" và bao gồm file autoload.php để load các class cần thiết
    $open = "transaction";
    require_once __DIR__. "/../autoload/autoload.php";

    // Lấy id của giao dịch từ request và chuyển về kiểu số nguyên
    $id = intval(getInput('id'));

    // Lấy thông tin giao dịch từ bảng transaction với id tương ứng
    $EditTransaction = $db->fetchID("transaction", $id);

    // Kiểm tra nếu không tìm thấy giao dịch
    if(empty($EditTransaction)) {
        $_SESSION['error'] ="Data does not exist";
        redirectAdmin("transaction");
    }

    // Kiểm tra nếu giao dịch đã được xử lý (status = 1) thì không thể thay đổi trạng thái
    if($EditTransaction['status'] == 1) {
        $_SESSION['error'] ="Your order has been processed and you CAN'T change its status !";
        redirectAdmin("transaction");
    }

    // Đảo ngược trạng thái của giao dịch (0 -> 1 hoặc 1 -> 0)
    $status = $EditTransaction['status'] == 0 ? 1 : 0;

    // Cập nhật trạng thái mới vào bảng transaction
    $update = $db->update("transaction", array("status" => $status), array("id" => $id));

    // Kiểm tra nếu cập nhật thành công
    if($update > 0) {
        $_SESSION['success'] = "Update transaction successfully !";

        // Lấy danh sách các sản phẩm trong đơn hàng có transaction_id là $id
        $sql = "SELECT product_id, qty FROM orders WHERE transaction_id = $id";
        $order = $db->fetchSql($sql);

        // Duyệt qua từng sản phẩm trong đơn hàng
        foreach($order as $item) {
            $idproduct = intval($item['product_id']);

            // Lấy thông tin sản phẩm từ bảng product
            $product = $db->fetchID("product", $idproduct);

            // Cập nhật số lượng sản phẩm còn lại và số lần được mua (pay)
            $number = $product['number'] - $item['qty'];
            $up_pro = $db->update("product", array("number" => $number, "pay" => $product['pay'] + 1), array("id" => $idproduct));
        }

        redirectAdmin("transaction");
    } else {
        // Nếu cập nhật không thành công
        $_SESSION['error'] = "Update transaction NOT successfully !";
        redirectAdmin("transaction");
    }
?>
