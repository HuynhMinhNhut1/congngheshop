<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Home </title>
    <link rel="shortcut icon" type="image/x-icon" href="https://icons.iconarchive.com/icons/cjdowner/cryptocurrency-flat/256/Ark-icon.png">
    <link href="<?php echo base_url() ?>/public/admin/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="<?php echo base_url() ?>public/frontend/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url() ?>public/frontend/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
</head>
<?php
$id = intval(getInput('id'));
$sql = "SELECT * FROM users WHERE id = $id";
$usersss = mysqli_query($con, $sql);
?>

<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.html">Xin chào  <?php echo $_SESSION['name_user'] ?></a>
        <!-- Navbar Search-->

        <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <a href="/../congngheshop/index.php" style="font-size: 12px;font-weight: bold;color:aliceblue;">Thoát</a>
            </div>
        </div>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading"></div>
                        <a class="nav-link" href="/congngheshop/personal/update.php?id=<?php echo $_SESSION['name_id'] ?>">
                            <div class="sb-nav-link-icon"><i class="far fa-address-card"></i></i></div>
                            Thông Tin
                        </a>
                        <a class="nav-link" href="/congngheshop/personal/changepass.php?id=<?php echo $_SESSION['name_id'] ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-lock-open"></i></div>
                            Thay đổi Mật khẩu
                        </a>
                        <a class="nav-link" href="/congngheshop/personal/history.php?id=<?php echo $_SESSION['name_id'] ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-folder-open"></i></div>
                            Lịch sử đơn đặt
                        </a>
            
                        <a class="navbar-brand" style="text-align: center; "><?php echo $_SESSION['name_user'] ?></a>
                    </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">