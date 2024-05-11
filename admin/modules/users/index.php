<?php
    $open = "users";
    require_once __DIR__. "/../../autoload/autoload.php";
    
    // Xử lý phân trang
    if(isset($_GET['page']))
    {
        $p=$_GET['page'];
    }
    else
    {
        $p=1;
    }

    // Truy vấn SQL để lấy dữ liệu người dùng và sắp xếp theo ID giảm dần
    $sql ="SELECT users.* FROM users ORDER BY ID DESC";

    // Gọi hàm fetchJone để lấy dữ liệu người dùng phân trang
    $users = $db->fetchJone('users', $sql, $p, 5, true);

    // Xử lý phân trang: lấy số trang và xóa phần tử 'page' ra khỏi mảng người dùng
    if(isset($users['page']))
    {
        $sotrang = $users['page'];
        unset($users['page']);
    }
?>
<?php require_once __DIR__. "/../../layouts/header.php" ;?>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Danh sách người dùng</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo base_url_admin() ?>">Trang chính</a></li>
            <li class="breadcrumb-item active">Danh sách người dùng</li>
        </ol>
        <div class="cleanfix"></div>

        <!-- Notification Error -->
        <?php require_once __DIR__. "/../../../partials/notification.php"; ?>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Dữ liệu người dùng
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $Number = 1 ; foreach ($users as $item): ?>
                                <tr>
                                    <td><?php echo $Number ?></td>
                                    <td><?php echo $item['name'] ?></td>
                                    <td><?php echo $item['email'] ?></td>
                                    <td><?php echo $item['phone'] ?></td>
                                    <td>
                                        <!-- Nút xóa người dùng -->
                                        <a class="btn btn-xs btn-danger" href="delete.php?id=<?php echo $item['id'] ?>">
                                            <i class="fa fa-times"></i> Xóa
                                        </a>
                                    </td>
                                </tr>
                                <?php $Number++; endforeach ?>
                        </tbody>
                    </table>
                    <!-- Phân trang -->
                    <div class="pull-right" style="float: right;">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                                </li>
                                <?php for($i = 1 ; $i <= $sotrang ; $i++ ):?> 
                                    <?php 
                                        if(isset($_GET['page']))
                                        {
                                            $p=$_GET['page'];
                                        }
                                        else
                                        {
                                            $p=1;
                                        }
                                    ?>
                                    <!-- Hiển thị các trang phân trang -->
                                    <li class="page-item <?php echo ($i==$p) ? 'active' : '' ?>">
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
<?php require_once __DIR__. "/../../layouts/footer.php" ;?>
