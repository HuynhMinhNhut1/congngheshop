<?php
// Thiết lập biến mở để đánh dấu trang đang mở là trang danh mục
$open = "category";

// Đưa vào file autoload.php để load các file cần thiết
require_once __DIR__ . "/../../autoload/autoload.php";

// Lấy danh sách tất cả các danh mục sản phẩm từ cơ sở dữ liệu
$category = $db->fetchAll("category");
?>
<?php require_once __DIR__ . "/../../layouts/header.php"; ?>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Thông Tin Bảng phân loại</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo base_url_admin() ?>">Trang chính</a></li>
            <li class="breadcrumb-item active">Loại</li>
        </ol>
        <div class="cleanfix"></div>

        <!-- Thông báo lỗi -->
        <?php require_once __DIR__ . "/../../../partials/notification.php"; ?>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Dữ liệu loại hàng
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên loại</th>
                                <th>Slug</th>
                                <th>Tình trạng</th>
                                <th>Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $Number = 1; foreach ($category as $item): ?>
                                <tr>
                                    <td><?php echo $Number ?></td>
                                    <td><?php echo $item['name'] ?></td>
                                    <td><?php echo $item['slug'] ?></td>
                                    <td>
                                        <a href="home.php?id=<?php echo $item['id'] ?>" class="btn <?php echo $item['home'] == 1 ? 'btn-success' : 'btn-warning' ?>">
                                            <?php echo $item['home'] == 1 ? 'Hiển thị' : 'Ẩn' ?>
                                        </a>
                                    </td>
                                    <td><?php echo $item['created_at'] ?></td>
                                </tr>
                            <?php $Number++; endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once __DIR__ . "/../../layouts/footer.php"; ?>
