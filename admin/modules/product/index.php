<?php
$open = "product";  // Biến mở cho trang sản phẩm
require_once __DIR__ . "/../../autoload/autoload.php";

// Xử lý phân trang
if (isset($_GET['page'])) {
    $p = $_GET['page'];
} else {
    $p = 1;
}

// Truy vấn SQL để lấy dữ liệu sản phẩm và danh mục tương ứng
$sql = "SELECT product.*, category.name AS namecate 
        FROM product 
        LEFT JOIN category ON category.id = product.category_id 
        ORDER BY update_at DESC";

// Gọi hàm fetchJone để lấy dữ liệu sản phẩm phân trang
$product = $db->fetchJone('product', $sql, $p, 5, true);

// Xử lý phân trang: lấy số trang và xóa phần tử 'page' ra khỏi mảng sản phẩm
if (isset($product['page'])) {
    $sotrang = $product['page'];
    unset($product['page']);
}
?>
<?php require_once __DIR__ . "/../../layouts/header.php"; ?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Sản phẩm
            <a href="add.php" class="btn btn-success">Thêm sản phẩm</a>
        </h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo base_url_admin() ?>">Trang chính</a></li>
            <li class="breadcrumb-item active">Danh sách sản phẩm</li>
        </ol>
        <div class="cleanfix"></div>

        <!-- Thông báo lỗi -->
        <?php require_once __DIR__ . "/../../../partials/notification.php"; ?>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Dữ liệu sản phẩm
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Tên sản phẩm</th>
                                <th>Loại</th>
                                <th>Slug</th>
                                <th>Thunbar</th>
                                <th>Thông tin</th>
                                <th style="width: 15%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $Number = 1;
                            foreach ($product as $item) : ?>
                                <tr>
                                    <td><?php echo $Number ?></td>
                                    <td><?php echo $item['name'] ?></td>
                                    <td><?php echo $item['namecate'] ?></td>
                                    <td><?php echo $item['slug'] ?></td>

                                    <td>
                                        <img src="<?php echo uploads() ?>product/<?php echo $item['thumbar'] ?>" width="100px" height="70px">
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Price : <?php echo formatPrice($item['price']) ?></li>
                                            <li>Sale : <?php echo formatPriceSale($item['price'], $item['sale']) ?></li>
                                            <li>Amount : <?php echo $item['number'] ?>
                                                <?php if ($item['number'] < 1) : ?>
                                                    <p style="font-size: 15px; color: red;">thêm or loại bỏ</p>
                                                <?php endif; ?>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <!-- Các nút chức năng: sửa và xóa sản phẩm -->
                                        <a class="btn btn-xs btn-info" href="edit.php?id=<?php echo $item['id'] ?>">
                                            <i class="fa fa-edit"></i> Cập nhật </a>
                                        <a class="btn btn-xs btn-danger" href="delete.php?id=<?php echo $item['id'] ?>">
                                            <i class="fa fa-times"></i> Xóa </a>
                                    </td>
                                </tr>
                            <?php $Number++;
                            endforeach ?>
                        </tbody>
                    </table>
                    <!-- Phân trang -->
                    <div class="pull-right" style="float: right;">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                                </li>
                                <?php for ($i = 1; $i <= $sotrang; $i++) : ?>
                                    <?php
                                    // Xử lý hiển thị trang được chọn
                                    if (isset($_GET['page'])) {
                                        $p = $_GET['page'];
                                    } else {
                                        $p = 1;
                                    }
                                    ?>
                                    <!-- Hiển thị các trang phân trang -->
                                    <li class="page-item <?php echo ($i == $p) ? 'active' : '' ?>">
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
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . "/../../layouts/footer.php"; ?>
