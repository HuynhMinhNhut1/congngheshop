<?php 
// Đã bao gồm autoload để tự động tải các lớp cần thiết
require_once __DIR__. "/autoload/autoload.php"; 

// Tạo câu truy vấn ban đầu để lấy tất cả sản phẩm từ cơ sở dữ liệu
$sql = "SELECT * FROM product WHERE 1";

// Khởi tạo biến keyword rỗng để sử dụng cho tìm kiếm
$keyword = ''; 

// Kiểm tra xem có tham số keyword được gửi đi và không rỗng
if(isset($_GET['keyword']) && $_GET['keyword'] != NULL)
{
    // Lấy giá trị của tham số keyword từ URL
    $keyword = $_GET['keyword'];

    // Thêm điều kiện tìm kiếm vào câu truy vấn: tên sản phẩm chứa keyword
    $sql .= " AND name LIKE '%$keyword%'";
}

// Thực hiện truy vấn SQL để lấy kết quả tìm kiếm
$resultsearch = $db->fetchsql($sql);
?>

<!-- Hiển thị kết quả tìm kiếm -->
<?php if(isset($resultsearch) && count($resultsearch) > 0): ?>
    <ul id="returnsearch">
        <?php foreach($resultsearch as $item): ?>
            <li class="item-product-search">
                <a href="detail_product.php?id=<?php echo $item['id']; ?>">
                    <img src="<?php echo uploads(); ?>product/<?php echo $item['thumbar']; ?>" width="30%" height="60px">
                    <?php echo $item['name']; ?>
                </a>
                <div class="clearfix"></div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <ul id="returnsearch">
        <li> Kết quả không tương thích! </li>
    </ul>
<?php endif; ?>
