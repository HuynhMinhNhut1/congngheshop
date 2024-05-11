<!--ENDMENUNAV-->   
<div id="maincontent">
    <div class="container">
        <div class="col-md-3 fixside">
            <!-- Box menu danh mục sản phẩm -->
            <div class="box-left box-menu">
                <!-- Tiêu đề danh mục sản phẩm -->
                <h3 class="box-title"><i class="fa fa-list"></i>Phân Loại</h3>
                <ul>
                    <!-- Duyệt qua danh sách các danh mục sản phẩm -->
                    <?php foreach ($category as $item): ?>
                        <li><a href="category_product.php?id=<?php echo $item['id'] ?>"><?php echo $item['name'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- Box menu sản phẩm mới -->
            <div class="box-left box-menu">
                <!-- Tiêu đề sản phẩm mới -->
                <h3 class="box-title"><i class="fa fa-bullhorn"></i>Sản Phẩm Mới</h3>
                <ul>
                    <!-- Duyệt qua danh sách các sản phẩm mới -->
                    <?php foreach ($productNEW as $item): ?>
                        <li class="clearfix">
                            <a href="detail_product.php?id=<?php echo $item['id'] ?>">
                                <!-- Hiển thị hình ảnh sản phẩm -->
                                <img src="<?php echo uploads() ?>product/<?php echo $item['thumbar'] ?>" class="img-responsive pull-left" width="80" height="80">
                                <div class="info pull-right">
                                    <!-- Hiển thị tên sản phẩm -->
                                    <p class="name"><?php echo $item['name'] ?></p>
                                    <!-- Hiển thị giá và giá giảm (nếu có) của sản phẩm -->
                                    <b class="price"><?php echo formatPriceSale($item['price'], $item['sale']) ?></b><br>
                                    <!-- Hiển thị giá gốc của sản phẩm -->
                                    <b class="sale"><?php echo formatPrice($item['price']) ?></b><br>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
