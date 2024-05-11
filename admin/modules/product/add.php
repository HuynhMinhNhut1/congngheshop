<?php
require_once __DIR__ . "/../../autoload/autoload.php";

// Lấy danh sách các danh mục sản phẩm từ cơ sở dữ liệu
$category = $db->fetchAll("category");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và gán vào mảng $data
    $data = [
        "name" => postInput('name'),                        // Tên sản phẩm
        "slug" => to_slug(postInput("name")),               // Tạo slug từ tên sản phẩm
        "category_id" => postInput("category_id"),          // ID của danh mục sản phẩm
        "price" => postInput("price"),                      // Giá sản phẩm
        "number" => postInput("number"),                    // Số lượng sản phẩm
        "sale" => postInput("sale"),                        // Giảm giá sản phẩm
        "cpu" => postInput("cpu"),                          // Mô tả CPU
        "short_content" => postInput("short_content"),      // Mô tả ngắn
        "content" => postInput("content"),                  // Mô tả chi tiết
    ];
    
    $error = [];  // Mảng chứa thông báo lỗi

    // Kiểm tra các trường thông tin sản phẩm bắt buộc
    $required_fields = ['name', 'category_id', 'price', 'number', 'short_content', 'content', 'cpu'];
    foreach ($required_fields as $field) {
        if (empty($data[$field])) {
            $error[$field] = "Vui lòng nhập " . str_replace('_', ' ', $field) . " của sản phẩm";
        }
    }

    // Xử lý tệp tải lên (hình ảnh sản phẩm)
    if (!empty($_FILES['thumbar']['name'])) {
        $file_name = $_FILES['thumbar']['name'];
        $file_tmp = $_FILES['thumbar']['tmp_name'];
        $file_size = $_FILES['thumbar']['size'];
        
        // Đường dẫn thư mục lưu trữ hình ảnh sản phẩm
        $part = ROOT ."product/";
        $data['thumbar'] = $file_name;
        
        // Di chuyển tệp tải lên vào thư mục sản phẩm
        move_uploaded_file($file_tmp, $part . $file_name);
    }

    // Thêm sản phẩm vào cơ sở dữ liệu
    $id_insert = $db->insert("product", $data);
    if ($id_insert) {
        $_SESSION['success'] = "Thêm sản phẩm thành công !";
        redirectAdmin("product");
    } else {
        $_SESSION['error'] = "Thêm sản phẩm thất bại !";
        redirectAdmin("product");
    }
}
?>

<?php require_once __DIR__ . "/../../layouts/header.php"; ?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Thêm Sản Phẩm Mới</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Trang chính</a></li>
            <li class="breadcrumb-item"><a href="index.php">Sản phẩm</a></li>
            <li class="breadcrumb-item active">Thêm Sản Phẩm Mới</li>
        </ol>
        <div class="cleanfix"></div>

        <!-- Thông báo lỗi -->
        <?php require_once __DIR__ . "/../../../partials/notification.php"; ?>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-folder-plus mr-1"></i>
                <b> Thêm Sản Phẩm Mới</b>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Danh Mục Sản Phẩm</b></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="category_id">
                                <option value="">--Vui lòng chọn danh mục sản phẩm--</option>
                                <?php foreach ($category as $item) : ?>
                                    <option value="<?php echo $item['id'] ?>"> <?php echo $item['name'] ?> </option>
                                <?php endforeach ?>
                            </select>
                            <?php if (isset($error['category_id'])) : ?>
                                <p class="text-danger"> <?php echo $error['category_id'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Tên Sản Phẩm</b></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Tên sản phẩm ..." name="name">
                            <?php if (isset($error['name'])) : ?>
                                <p class="text-danger"> <?php echo $error['name'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Giá Sản Phẩm</b></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="9.000.000" name="price">
                            <?php if (isset($error['price'])) : ?>
                                <p class="text-danger"> <?php echo $error['price'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Số Lượng Sản Phẩm</b></label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="inputEmail3" placeholder="15" name="number" value="0">
                            <?php if (isset($error['number'])) : ?>
                                <p class="text-danger"> <?php echo $error['number'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Giảm Giá</b></label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="inputEmail3" placeholder="15%" name="sale" value="0">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Hình Ảnh</b></label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" id="inputEmail3" placeholder="15%" name="thumbar">
                            <?php if (isset($error['thumbar'])) : ?>
                                <p class="text-danger"> <?php echo $error['thumbar'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Ưu Đãi</b></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Ưu đãi sản phẩm ..." name="bonus">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Mô Tả CPU</b></label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="cpu" rows="10"></textarea>
                            <?php if (isset($error['cpu'])) : ?>
                                <p class="text-danger"> <?php echo $error['cpu'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Mô Tả Ngắn</b></label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="short_content" rows="4"></textarea>
                            <?php if (isset($error['short_content'])) : ?>
                                <p class="text-danger"> <?php echo $error['short_content'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: right;"><b>Mô Tả Chi Tiết</b></label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="content" rows="15"></textarea>
                            <?php if (isset($error['content'])) : ?>
                                <p class="text-danger"> <?php echo $error['content'] ?> </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-md-2 col-sm-8">
                            <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script src="/congngheshop/public/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content');
    CKEDITOR.replace('cpu');
</script>

<?php require_once __DIR__ . "/../../layouts/footer.php"; ?>