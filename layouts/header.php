<!DOCTYPE html>
<html>

<head>
    <title>Shop công nghệ</title>
    <!-- Đường dẫn đến biểu tượng trang web -->
    <link rel="shortcut icon" type="image/x-icon" href="https://icons.iconarchive.com/icons/cjdowner/cryptocurrency-flat/256/Ark-icon.png">
    <meta charset="utf-8">
    <!-- Các tệp CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/frontend/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/frontend/css/slick.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/frontend/css/slick-theme.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/frontend/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/laravo/main.css">
    <!-- Các tệp JavaScript -->
    <script src="<?php echo base_url() ?>public/frontend/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url() ?>public/frontend/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>public/frontend/js/slick.min.js"></script>
    <!-- JavaScript để xử lý tìm kiếm theo từ khóa -->
    <script type="text/javascript">
        // Sự kiện xảy ra khi tài liệu đã được tải hoàn toàn
        $(document).ready(function() {
            // Sự kiện xảy ra khi người dùng gõ từ khóa tìm kiếm vào ô input
            $("#header-search").keyup(function() {
                if ($(this).val() != "") {
                    // Gửi yêu cầu AJAX để tìm kiếm sản phẩm với từ khóa nhập vào
                    $.ajax({
                        type: "get",
                        url: "/congngheshop/search.php",
                        data: 'keyword=' + $(this).val(),
                        beforeSend: function() {
                            $("#header-search").css("background", "#fff url(LoaderIcon.gif) no-repeat 165");
                        },
                        success: function(data) {
                            // Hiển thị hộp gợi ý khi tìm kiếm
                            $("#suggesstion-box").show();
                            $("#suggesstion-box").html('').append(data);
                            $("#header-search").css("background", "#FFF");
                        }
                    });
                } else {
                    // Ẩn hộp gợi ý khi ô tìm kiếm rỗng
                    $("#suggesstion-box").hide();
                }
            });

            // Sự kiện xảy ra khi ô tìm kiếm mất focus
            $('#header-search').blur(function() {
                // Xử lý khi ô tìm kiếm mất focus
            });
        });

        // Hàm này được gọi khi người dùng chọn một từ khóa trong hộp gợi ý
        function selectContry(val) {
            $("#header-search").val(val);
            $("#suggesstion-box").hide();
        }
    </script>
    <!-- CSS tùy chỉnh -->
    <style>
        /* CSS cho hộp gợi ý khi tìm kiếm */
        #suggesstion-box {
            position: absolute;
            z-index: 9999999;
            background: white;
            border: 1px solid #dedede;
            width: 60%;
            border-top: 0;
            height: 400px;
            overflow-y: auto;
            display: none;
        }

        #suggesstion-box li {
            padding: 5px 10px;
            border-bottom: 1px solid #dedede;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Phần HEADER -->
        <div id="header">
            <!-- Header top -->
            <div id="header-top">
                <!-- Phần thông tin liên hệ -->
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-6" id="header-text">
                            <a style="background-color: #da1719;">Minh Nhựt</a><b>0969819947</b>
                        </div>
                        <div class="col-md-6">
                            <!-- Phần đăng nhập và tài khoản -->
                            <nav id="header-nav-top">
                                <ul class="list-inline pull-right" id="headermenu">
                                    <!-- Hiển thị tên người dùng nếu đã đăng nhập -->
                                    <?php if (isset($_SESSION['name_user'])) : ?>
                                        <li>Hi : <?php echo $_SESSION['name_user'] ?></li>
                                        <li>
                                            <a href=""><i class="fa fa-user"></i>Tài Khoản <i class="fa fa-caret-down"></i></a>
                                            <ul id="header-submenu">
                                            <li><a href="/congngheshop/personal/index.php?id=<?php echo $_SESSION['name_id'] ?>">Personal</a></li>
                                                <li><a href="cart_product.php">Cart</a></li>
                                                <li><a href="logout.php"><i class="fa fa-share-square-o"></i>Đăng xuất</a></li>
                                            </ul>
                                        </li>
                                    <?php else : ?>
                                        <!-- Hiển thị nút đăng nhập và đăng ký nếu chưa đăng nhập -->
                                        <li>
                                            <a href="Login.php"><i class="fa fa-sign-in"></i>Đăng nhập</a>
                                        </li>
                                        <li>
                                            <a href="Register.php"><i class="fa fa-unlock"></i>Đăng ký</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Phần main của header -->
            <div class="container">
                <div class="row" id="header-main">
                    <div class="col-md-5">
                        <!-- Form tìm kiếm sản phẩm -->
                        <form class="form-inline" action="" method="POST">
                            <div class="form-group">
                                <input type="text" name="keyword" id="header-search" placeholder="Search name product ... " class="form-control" style="width: 300px; ">
                            </div>
                        </form>
                        <!-- Hộp gợi ý khi tìm kiếm -->
                        <div id="suggesstion-box"></div>
                    </div>
                    <div class="col-md-4">
                        <!-- Logo của trang web -->
                        <a href="index.php">
                            <img src="<?php echo base_url() ?>public/frontend/images/LOGO.jpg" style="margin-top: -15px; width: 280px; height: 70px;">
                        </a>
                    </div>
                    <div class="col-md-3" id="header-right">
                        <!-- Thông tin hotline -->
                        <div class="pull-right" style="margin-right: 15px;">
                            <div class="pull-left">
                                <i class="glyphicon glyphicon-phone-alt"></i>
                            </div>
                            <div class="pull-right">
                                <p id="hotline">HOTLINE</p>
                                <a id="callphone" href="tel:0969819947" style="color: black;">0777973754</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END HEADER -->

        <!-- Phần MENU NAVIGATION -->
        <div id="menunav">
            <div class="container">
                <nav>
                    <!-- Menu chính -->
                    <ul id="menu-main">
                        <li><a class="menupading" href="index.php">Trang chủ</a></li>
                        <li><a href="product.php">Sản Phẩm</a></li>
                        <li><a href="">Phụ Kiện</a></li>
                        <li><a href="">Tin Tức</a></li>
                        <li><a href="introduce.php">Giới thiệu</a></li>
                        <li><a href="">Liên hệ</a></li>
                    </ul>
                    <!-- Menu giỏ hàng -->
                    <ul class="pull-right" id="main-shopping">
                        <li><a href="cart_product.php"><i class="fa fa-shopping-basket"></i> Giỏ Hàng </a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- END MENU NAVIGATION -->
    </div>
</body>

</html>
