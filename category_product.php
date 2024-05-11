<?php 
// Tải file autoload.php để có thể sử dụng các class mà không cần include nhiều lần
require_once __DIR__. "/autoload/autoload.php"; 

// Lấy ID danh mục từ URL và lấy thông tin của danh mục đó
$id = intval(getInput('id'));
$EditCategory = $db->fetchID("category" ,$id);

// Xác định trang hiện tại (nếu không có thì mặc định là trang đầu tiên)
$p = isset($_GET['page']) ? $_GET['page'] : 1;

// Truy vấn sản phẩm thuộc danh mục có ID là $id, phân trang và lấy 12 sản phẩm trên mỗi trang
$sql = "SELECT * FROM product WHERE category_id=$id ";
$product = $db->fetchJone('product', $sql, $p, 12, true);

// Lấy số trang của kết quả sản phẩm (nếu có)
if (isset($product['page'])) {
    $sotrang = $product['page'];
    unset($product['page']);
}

// Lấy đường dẫn của trang hiện tại
$path = $_SERVER['SCRIPT_NAME'];
?>

<!-- This is HEADER -->
<?php require_once __DIR__. "/layouts/header.php" ;?>
<?php require_once __DIR__. "/layouts/banner.php" ;?>
<!-- END HEADER -->

<style>
    .nametext {
        display: block;
        width: 180px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>

<div class="col-md-9 bor" style="padding-bottom: 15px;">
    <section class="box-main1">
        <!-- ----------MAIN-------------- -->
        <h3 class="title-main"><a href=""><?php echo $EditCategory['name'] ?></a></h3>
        <div class="showitem clearfix">
            <?php foreach ($product as $item): ?>
                <div class="col-md-3 item-product bor">
                    <?php if ($item['number'] < 1): ?>
                        <span style="position: absolute; background: #fbda00;color: #333;font-size: 12px;padding: 2px 6px;margin-left: 63px;">product not available</span>
                    <?php endif; ?>
                    <?php if ($item['sale'] > 0): ?>
                        <span style="position: absolute; background: red;color: #FFF;font-size: 12px;padding: 2px 6px;"><?php echo $item['sale'] ?> %</span>
                    <?php endif; ?>
                    <a href="detail_product.php?id=<?php echo $item['id'] ?>">
                        <img src="<?php echo uploads()?>product/<?php echo $item['thumbar']?>" class="" width="100%" height="140px">
                    </a>
                    <div class="info-item">
                        <a class="nametext" href="detail_product.php?id=<?php echo $item['id'] ?>"><?php echo $item['name']?></a>
                        <?php if ($item['sale'] < 1): ?>
                            <b style="color: #999;"> <?php echo formatPrice($item['price']) ?></b>
                        <?php endif; ?>
                        <?php if ($item['sale'] > 0): ?>
                            <p><strike class="sale"> <?php echo formatPrice($item['price']) ?></strike><b class="price"> <?php echo formatPriceSale($item['price'], $item['sale']) ?></b></p>
                        <?php endif; ?>
                    </div>
                    <div class="hidenitem">
                        <?php if ($item['number'] > 1): ?>
                            <p><a href="detail_product.php?id=<?php echo $item['id'] ?>"><i class="fa fa-search"></i></a></p>
                            <p><a href=""><i class="fa fa-heart"></i></a></p>
                            <p><a href="addcart.php?id=<?php echo $item['id'] ?>"><i class="fa fa-shopping-basket"></i></a></p>
                        <?php else: ?>
                            <p><a href="detail_product.php?id=<?php echo $item['id'] ?>"><i class="fa fa-search"></i></a></p>
                            <p><a href=""><i class="fa fa-heart"></i></a></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <nav class="text-center">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                </li>
                <?php for ($i = 1; $i <= $sotrang; $i++): ?>
                    <li class="<?php echo isset($_GET['page']) && $_GET['page'] == $i ? 'active' : '' ?>">
                        <a href="<?php echo $path ?>?id=<?php echo $id?>&page=<?php echo $i;?>"><?php echo $i;?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
                </li>
            </ul>
        </nav>
    </section>
</div>

<!-- This is Footer -->
<?php require_once __DIR__. "/layouts/footer.php" ;?>
<!-- END Footer -->
