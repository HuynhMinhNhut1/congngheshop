<?php
// Tải file autoload.php để sử dụng các class mà không cần include nhiều lần
require_once __DIR__ . "/autoload/autoload.php";

// Lấy ID sản phẩm từ URL và lấy thông tin của sản phẩm đó từ cơ sở dữ liệu
$id = intval(getInput('id'));
$product = $db->fetchID("product", $id);
?>

<!-- This is HEADER -->
<?php require_once __DIR__ . "/layouts/header.php"; ?>
<?php require_once __DIR__ . "/layouts/banner.php"; ?>
<!-- END HEADER -->

<style>
    /* Định dạng CSS cho các phần của trang sản phẩm */
    .nametext {
        display: block;
        width: 180px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .product-tab-content {
        overflow: hidden;
        font-weight: normal;
    }

    .product-tab-content h2 {
        font-size: 20px;
        font-weight: normal !important;
    }

    .product-tab-content h3 {
        font-size: 18px !important;
    }

    .product-tab-content h4 {
        font-size: 16px !important;
    }

    .product-tab-content img {
        margin: 0 auto;
        text-align: center;
        max-width: 100%;
        display: block;
    }

    .list_start {
        cursor: pointer;
    }

    .list_text {
        display: inline-block;
        margin-left: 10px;
        position: relative;
        background: #52b858;
        color: #fff;
        padding: 2px 8px;
        box-sizing: border-box;
        font-size: 12px;
        border-radius: 2px;
        display: none;
    }

    .list_text::after {
        right: 100%;
        top: 50%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-color: rgba(82, 184, 88, 0);
        border-right-color: #52b858;
        border-width: 6px;
        margin-top: -6px;
    }

    .ra_comment .active {
        color: #ff9705 !important;
    }
</style>

<div class="col-md-9 bor" style="padding-bottom: 15px;">
    <div style="text-align: right; padding-right: 135px; padding-bottom: 20px;">
        <!-- Hiển thị thông báo nếu sản phẩm không có sẵn -->
        <?php if ($product['number'] < 1) : ?>
            <span style="position: absolute; text-align: center;width: 150px; background: #fbda00;color: #333;font-size: 18px;padding: 4px 6px;">Sản phẩm không có sẵn</span>
        <?php endif; ?>
    </div>
    <section class="box-main1">
        <!-- Hiển thị hình ảnh sản phẩm và thông tin sản phẩm -->
        <div class="col-md-6 text-center">
            <img src="<?php echo uploads() ?>product/<?php echo $product['thumbar'] ?>" class="img-responsive bor zoom" id="imgmain" width="100%" height="450px">
        </div>
        <div class="col-md-6 " style="margin-top: 20px;padding: 30px;">
            <ul id="right">
                <!-- Hiển thị tên, giá, và quà tặng của sản phẩm -->
                <li><h2 style="font-weight: bold; text-align: center;"><?php echo $product['name'] ?></h2></li>
                <?php if ($product['bonus'] != '') : ?>
                    <li>
                        <h3 style="color:red;">Quà tặng gồm:</h3>
                        <p style="margin-top: 10px; font-size: 15px;">
                            <?php echo $product['bonus'] ?>
                        </p>
                    </li>
                <?php else : ?>
                    <li style="color:red;">Sản phẩm không đi kèm quà tặng</li>
                <?php endif; ?>
                <!-- Hiển thị giá sản phẩm -->
                <li style="font-size: 30px; text-align: center;">
                    <?php if ($product['sale'] > 0) : ?>
                        <p><strike style="font-size: 18px;" class="sale"><?php echo formatPrice($product['price']) ?></strike>
                            &emsp;<b class="price" style="font-size: 20px;"><?php echo formatPriceSale($product['price'], $product['sale']) ?></b></p>
                    <?php else : ?>
                        <p><b class="price" style="font-size: 20px;"><?php echo formatPrice($product['price']) ?></b></p>
                    <?php endif; ?>
                </li>
                <!-- Hiển thị nút thêm vào giỏ hàng -->
                <li style="text-align: center;">
                    <?php if ($product['number'] > 0) : ?>
                        <a href="addcart.php?id=<?php echo $product['id'] ?>" class="btn btn-default">Thêm vào giỏ hàng</a>
                    <?php else : ?>
                        <p style="font-size: 18px; color:#ea3a3c;">Hãy chọn sản phẩm khác</p>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </section>
    <!-- Hiển thị mô tả sản phẩm và thông số kỹ thuật -->
    <div class="col-md-12" id="tabdetail">
        <div class="row">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Mô tả sản phẩm</a></li>
                <li><a data-toggle="tab" href="#menu0">Thông số kỹ thuật</a></li>
            </ul>
            <div class="tab-content">
                <!-- Tab mô tả sản phẩm -->
                <div id="home" class="tab-pane fade in active">
                    <p><?php echo $product['content'] ?></p>
                </div>
                <!-- Tab thông số kỹ thuật -->
                <div id="menu0" class="tab-pane fade">
                    <h2 style="text-align: center;">Thông số kỹ thuật chi tiết</h2>
                    <p><?php echo $product['cpu'] ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- This is Footer -->
<?php require_once __DIR__ . "/layouts/footer.php"; ?>
<!-- END Footer -->
