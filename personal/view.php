<?php
    // Khai báo biến $open không được sử dụng trong đoạn mã này
    $open = "transaction";

    // Tải tệp autoload.php từ đường dẫn tương đối
    require_once __DIR__. "/../autoload/autoload.php";

    // Lấy ID từ đầu vào và chuyển đổi thành số nguyên bằng intval
    $id = intval(getInput('id'));

    // Tạo câu truy vấn SQL để lấy chi tiết sản phẩm liên quan đến giao dịch có ID là $id
    $sql = "SELECT product.name, product.thumbar, product.price, orders.qty, orders.price, orders.product_id 
            FROM transaction, orders, product 
            WHERE transaction.id = $id AND transaction.id = orders.transaction_id AND orders.product_id = product.id";

    // Thực hiện truy vấn SQL và lấy kết quả
    $Detailproduct = $db->fetchsql($sql);
?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên Sản phẩm</th>
            <th scope="col">Ảnh</th>
            <th scope="col">Giá</th>
            <th scope="col">Số lượng</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $Number = 1; 
        // Duyệt qua mảng $Detailproduct để hiển thị từng sản phẩm trong bảng
        foreach ($Detailproduct as $item): 
        ?>
            <tr>
                <!-- Cột STT -->
                <td><?php echo $Number ?></td>
                <!-- Cột Tên Sản phẩm với đường dẫn đến chi tiết sản phẩm -->
                <td><a href="http://congngheshop/detail_product.php?id=<?php echo $item['product_id'] ?>"><?php echo $item['name'] ?></a></td>
                <!-- Cột Ảnh sản phẩm -->
                <td>
                    <img src="<?php echo uploads()?>product/<?php echo $item['thumbar']?>" width="100px" height="70px">
                </td>
                <!-- Cột Giá sản phẩm được định dạng -->
                <td><?php echo formatPrice($item['price']) ?></td>
                <!-- Cột Số lượng sản phẩm -->
                <td><?php echo $item['qty'] ?></td>
            </tr>
        <?php 
        $Number++; // Tăng số thứ tự sau mỗi lần lặp
        endforeach; // Kết thúc vòng lặp
        ?>
    </tbody>
</table>
