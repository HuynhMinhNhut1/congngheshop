<?php
$open = "admin";
require_once __DIR__ . "/../../autoload/autoload.php";

// Lấy trang hiện tại từ tham số GET, mặc định là trang 1 nếu không có tham số
$p = isset($_GET['page']) ? $_GET['page'] : 1;

// Truy vấn danh sách admin và phân trang
$sql = "SELECT admin.* FROM admin ORDER BY ID DESC ";
$admin = $db->fetchJone('admin', $sql, $p, 2, true);

// Lấy số trang
$sotrang = isset($admin['page']) ? $admin['page'] : 1;
unset($admin['page']);
?>

<?php require_once __DIR__ . "/../../layouts/header.php"; ?>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Danh sách Admin
            <a href="add.php" class="btn btn-success">Thêm admin</a>
        </h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Danh sách Admin</li>
        </ol>
        <div class="cleanfix"></div>

        <!-- Hiển thị thông báo lỗi -->
        <?php require_once __DIR__ . "/../../../partials/notification.php"; ?>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Dữ liệu Admin
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Chức vụ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $Number = 1;
                            foreach ($admin as $item) : ?>
                                <tr>
                                    <td><?php echo $Number ?></td>
                                    <td><?php echo $item['name'] ?></td>
                                    <td><?php echo $item['email'] ?></td>
                                    <td><?php echo $item['phone'] ?></td>
                                    <td>
                                        <?php echo ($item['level'] == 1) ? "Admin" : "CTV"; ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-xs btn-info" href="edit.php?id=<?php echo $item['id'] ?>">
                                            <i class="fa fa-edit"></i> Sửa </a>
                                        <a class="btn btn-xs btn-danger" href="delete.php?id=<?php echo $item['id'] ?>">
                                            <i class="fa fa-times"></i> Xóa </a>
                                    </td>
                                </tr>
                            <?php $Number++;
                            endforeach; ?>
                        </tbody>
                    </table>
                    <div class="pull-right" style="float: right;">
                        <!-- Hiển thị phân trang -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                                </li>
                                <?php for ($i = 1; $i <= $sotrang; $i++) : ?>
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
            </div>
        </div>
    </div>
</main>
<?php require_once __DIR__ . "/../../layouts/footer.php"; ?>
