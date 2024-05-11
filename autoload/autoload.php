<?php
    // Bắt đầu một phiên làm việc session
    session_start();

    // Đưa vào các file chứa các hàm và lớp cần thiết
    require_once __DIR__. "/../libraries/Database.php";
    require_once __DIR__. "/../libraries/Function.php";

    // Kết nối đến cơ sở dữ liệu MySQL
    $con = mysqli_connect("localhost","root","","shopcongnghe");

    // Tạo một đối tượng của lớp Database để làm việc với cơ sở dữ liệu
    $db = new Database;

    // Định nghĩa đường dẫn lưu trữ ảnh
    define("ROOT", $_SERVER['DOCUMENT_ROOT'] . "/public/uploads/");

    // Tải danh sách các danh mục sản phẩm
    $category = $db->fetchcate("category");

    // Truy vấn để lấy danh sách 5 sản phẩm mới nhất không thuộc danh mục có category_id là 14
    $sqlNEW = "SELECT * FROM product WHERE category_id <> 14 ORDER BY ID DESC LIMIT 5";
    $productNEW = $db->fetchsql($sqlNEW);

    // Truy vấn để lấy danh sách 5 sản phẩm được thanh toán nhiều nhất
    $sqlPAY = "SELECT * FROM product WHERE 1 ORDER BY PAY DESC LIMIT 5";
    $productPAY = $db->fetchsql($sqlPAY);
?>
