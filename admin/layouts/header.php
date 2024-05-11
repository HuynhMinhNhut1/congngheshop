<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Khai báo các thông tin meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Home Admin</title>
    <!-- Đường dẫn icon trang -->
    <link rel="shortcut icon" type="image/x-icon" href="https://icons.iconarchive.com/icons/cjdowner/cryptocurrency-flat/256/Ark-icon.png">
    <!-- Đường dẫn đến file CSS -->
    <link href="<?php echo base_url() ?>/public/admin/css/styles.css" rel="stylesheet" />
    <!-- Đường dẫn đến file CSS của DataTables -->
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <!-- Đường dẫn đến các thư viện JavaScript -->
    <script src="<?php echo base_url() ?>public/frontend/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url() ?>public/frontend/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Thẻ nav của thanh điều hướng -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Trang Chủ</a>
        <!-- Form tìm kiếm -->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Tìm kiếm..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- Menu navbar -->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item">
                <a class="nav-link" href="/congngheshop/index.php">Quay lại</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <!-- Dropdown menu -->
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">Cài đặt</a>
                    <a class="dropdown-item" href="#">Hoạt động đăng nhập</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/congngheshop/login/logout.php">Đăng Xuất</a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- Phần content của trang -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <!-- Thanh điều hướng bên -->
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">QUẢN LÝ</div>
                        <!-- Menu các mục quản lý -->
                        <li class="<?php echo isset($open) && $open == 'category' ? 'active' : '' ?>">
                            <a class="nav-link" href="<?php echo modules("category") ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                                Phân loại 
                            </a>
                        </li>
                        <li class="<?php echo isset($open) && $open == 'product' ? 'active' : '' ?>">
                            <a class="nav-link" href="<?php echo modules("product") ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                                Sản phẩm
                            </a>
                        </li>
                        <li class="<?php echo isset($open) && $open == 'transaction' ? 'active' : '' ?>">
                            <a class="nav-link" href="<?php echo modules("transaction") ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Giao dịch
                            </a>
                        </li>
                        <li class="<?php echo isset($open) && $open == 'admin' ? 'active' : '' ?>">
                            <a class="nav-link" href="<?php echo modules("admin") ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-id-badge"></i></div>
                                Admin
                            </a>
                        </li>
                        <li class="<?php echo isset($open) && $open == 'users' ? 'active' : '' ?>">
                            <a class="nav-link" href="<?php echo modules("users") ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-circle"></i></div>
                                Người dùng
                            </a>
                        </li>
                        
                    </div>
                    <!-- Footer của thanh điều hướng bên -->
                    <div class="sb-sidenav-footer">
                        <div class="small">Đăng nhập với tư cách:</div>
                        <p><?php echo $_SESSION['admin_name'] ?></p>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Phần content chính của trang -->
        <div id="layoutSidenav_content">
