<?php
require_once __DIR__ . "/autoload/autoload.php";

// Truy vấn danh sách các danh mục sản phẩm được hiển thị trên trang chủ
$sqlHomecate = "SELECT name, id FROM category WHERE home = 1 ORDER BY update_at";
$categoryHome = $db->fetchsql($sqlHomecate);
$data = [];

// Lấy danh sách sản phẩm theo từng danh mục được hiển thị trên trang chủ
foreach ($categoryHome as $item) {
    $cateId = intval($item['id']);
    $sql = "SELECT * FROM product WHERE category_id = $cateId LIMIT 4";
    $productHome = $db->fetchsql($sql);
    $data[$item['name']] = $productHome;
}
?>
<?php require_once __DIR__ . "/layouts/header.php"; ?>
<?php require_once __DIR__ . "/layouts/banner.php"; ?>

<div class="col-md-9 bor" style="padding-bottom: 15px;">
    <section id="slide" class="text-center">
        <div class="slideshow-container">
            <?php for ($i = 1; $i < 5; $i++) : ?>
                <div class="mySlides">
                    <img src="<?php echo base_url() ?>public/uploads/banner/banner<?php echo $i; ?>.jpg" width="90%">
                </div>
            <?php endfor; ?>
            <br>
            <div style="text-align:center">
                <?php for ($i = 1; $i < 5; $i++) : ?>
                    <span class="dot"></span> <!-- Điểm chỉ số của slide -->
                <?php endfor; ?>
            </div>
            <script>
                var slideIndex = 1;
                showSlides();
                function showSlides() {
                    var slides = document.getElementsByClassName("mySlides");
                    var dots = document.getElementsByClassName("dot");
                    for (var i = 0; i < slides.length; i++) {
                        slides[i].style.display = "none"; // Ẩn tất cả các slide
                    }
                    slideIndex++;
                    if (slideIndex > slides.length) {
                        slideIndex = 1; // Quay lại slide đầu tiên nếu đã hiển thị hết các slide
                    }
                    for (i = 0; i < dots.length; i++) {
                        dots[i].className = dots[i].className.replace(" active", ""); // Xóa lớp active của các điểm chỉ số
                    }
                    slides[slideIndex - 1].style.display = "block"; // Hiển thị slide hiện tại
                    dots[slideIndex - 1].className += " active"; // Đánh dấu điểm chỉ số của slide hiện tại là active
                    setTimeout(showSlides, 4000); // Thay đổi hình ảnh mỗi 5 giây
                }
            </script>
        </div>
    </section>
    <section class="box-main1">
        <?php foreach ($data as $key => $value) : ?>
            <div class="col-md-12">
                <h3 class="title-main"><a href="#"><?php echo $key ?></a></h3> <!-- Tiêu đề danh mục sản phẩm -->
                <div class="showitem" style="margin-top: 10px; margin-bottom:10px;">
                    <?php foreach ($value as $item) : ?>
                        <div class="col-md-3 item-product bor">
                            <?php if ($item['number'] < 1) : ?>
                                <span style="position: absolute; background: #fbda00;color: #333;font-size: 12px;padding: 2px 6px;margin-left: 63px;">Sản phẩm không có sẵn</span>
                            <?php endif; ?>
                            <?php if ($item['sale'] > 0) : ?>
                                <span style="position: absolute; background: red;color: #FFF;font-size: 12px;padding: 2px 6px;"><?php echo $item['sale']; ?>%</span>
                            <?php endif; ?>
                            <a href="detail_product.php?id=<?php echo $item['id']; ?>">
                                <img src="<?php echo uploads(); ?>product/<?php echo $item['thumbar']; ?>" class="" width="100%" height="140px">
                            </a>
                            <div class="info-item">
                                <a class="nametext" href="detail_product.php?id=<?php echo $item['id']; ?>"><?php echo $item['name']; ?></a> <!-- Tên sản phẩm -->
                                <?php if ($item['sale'] < 1) : ?>
                                    <b style="color: #999;"><?php echo formatPrice($item['price']); ?></b> <!-- Giá sản phẩm -->
                                <?php else : ?>
                                    <p><strike class="sale"><?php echo formatPrice($item['price']); ?></strike><b class="price"><?php echo formatPriceSale($item['price'], $item['sale']); ?></b></p> <!-- Giá giảm -->
                                <?php endif; ?>
                            </div>
                            <div class="hidenitem">
                                <?php if ($item['number'] > 0) : ?>
                                    <p><a href="detail_product.php?id=<?php echo $item['id']; ?>"><i class="fa fa-search"></i></a></p>
                                    <p><a href=""><i class="fa fa-heart"></i></a></p>
                                    <p><a href="addcart.php?id=<?php echo $item['id']; ?>"><i class="fa fa-shopping-basket"></i></a></p>
                                <?php else : ?>
                                    <p><a href="detail_product.php?id=<?php echo $item['id']; ?>"><i class="fa fa-search"></i></a></p>
                                    <p><a href=""><i class="fa fa-heart"></i></a></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</div>
<?php require_once __DIR__ . "/layouts/footer.php"; ?>
