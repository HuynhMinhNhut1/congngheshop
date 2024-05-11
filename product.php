<?php
// Đặt biến $open là "product" để sử dụng trong file autoload
$open = "product";
require_once __DIR__ . "/autoload/autoload.php";

// Lấy trang hiện tại từ tham số GET 'page' hoặc mặc định là 1 nếu không có
if (isset($_GET['page'])) {
    $p = $_GET['page'];
} else {
    $p = 1;
}

// Truy vấn lấy danh sách sản phẩm và tên danh mục tương ứng từ CSDL bằng LEFT JOIN
$sql ="SELECT product.*, category.name AS namecate FROM product LEFT JOIN 
    category ON category.id = product.category_id ";

// Sử dụng fetchJone() để lấy danh sách sản phẩm phân trang
$product = $db->fetchJone('product', $sql, $p, 16, true);

// Lấy số trang và gỡ bỏ khỏi mảng kết quả
if (isset($product['page'])) {
    $sotrang = $product['page'];
    unset($product['page']);
}
?>

<style>
    .nametext {
        display: block;
        width: 180px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>

<!-- This is HEADER -->
<?php require_once __DIR__ . "/layouts/header.php"; ?> <!-- Gọi file header.php -->
<?php require_once __DIR__ . "/layouts/banner.php"; ?> <!-- Gọi file banner.php -->
<!-- END HEADER -->

<div class="col-md-9 bor" style="padding-bottom: 15px;">
    <section class="box-main1">
        <h2 style="text-align: center;margin-top: 15px;margin-bottom: 15px;"> Sản Phẩm </h2>
        <!-- ITEM PRODUCT -->
        <div class="col-md-12">
            <div class="showitem" style="margin-top: 10px; margin-bottom:10px;">
                <?php $Number = 1; foreach ($product as $item): ?>
                    <div class="col-md-3 item-product bor">
                        <?php
                        // Hiển thị thông báo sản phẩm hết hàng nếu số lượng < 1
                        if ($item['number'] < 1) {
                            echo '<span style="position: absolute; background: #fbda00;color: #333;font-size: 12px;padding: 2px 6px;margin-left: 63px;">product not available</span>';
                        }
                        // Hiển thị thông báo giảm giá nếu có
                        if ($item['sale'] > 0) {
                            echo '<span style="position: absolute; background: red;color: #FFF;font-size: 12px;padding: 2px 6px;">'.$item['sale'].' %</span>';
                        }
                        ?>
                        <a href="detail_product.php?id=<?php echo $item['id'] ?>">
                            <img src="<?php echo uploads()?>product/<?php echo $item['thumbar']?>" class="" width="100%" height="140px">
                        </a>
                        <div class="info-item">
                            <a class="nametext" href="detail_product.php?id=<?php echo $item['id'] ?>"><?php echo $item['name']?></a>
                            <?php
                            // Hiển thị giá sản phẩm
                            if ($item['sale'] < 1) {
                                echo '<b style="color: #999;">'.formatPrice($item['price']).'</b>';
                            }
                            // Hiển thị giá sau khi giảm nếu có
                            if ($item['sale'] > 0) {
                                echo '<p><strike class="sale">'.formatPrice($item['price']).'</strike><b class="price">'.formatPriceSale($item['price'],$item['sale']).'</b></p>';
                            }
                            ?>
                        </div>
                        <div class="hidenitem">
                            <?php if ($item['number'] > 1) : ?>
                                <p><a href="detail_product.php?id=<?php echo $item['id'] ?>"><i class="fa fa-search"></i></a></p>
                                <p><a href=""><i class="fa fa-heart"></i></a></p>
                                <p><a href="addcart.php?id=<?php echo $item['id'] ?>"><i class="fa fa-shopping-basket"></i></a></p>
                            <?php else : ?>
                                <p><a href="detail_product.php?id=<?php echo $item['id'] ?>"><i class="fa fa-search"></i></a></p>
                                <p><a href=""><i class="fa fa-heart"></i></a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php $Number++; endforeach; ?>
            </div>
            <!-- Phân trang -->
            <div class="pull-right" style="float: right;">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                        </li>
                        <?php for ($i = 1; $i <= $sotrang; $i++): ?>
                            <?php 
                                // Kiểm tra trang hiện tại
                                if (isset($_GET['page'])) {
                                    $p = $_GET['page'];
                                } else {
                                    $p = 1;
                                }
                            ?>
                            <li class="page-item <?php echo ($i == $p) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- ITEM PRODUCT -->
    </section>
</div>

<!-- This is Footer -->
<?php require_once __DIR__ . "/layouts/footer.php"; ?> <!-- Gọi file footer.php -->
<!-- END Footer -->
