<?php
// Thiết lập biến mở để chỉ định phần trang đang hoạt động
$open = "product";
// Đường dẫn tới tệp autoload.php để load các file cần thiết
require_once __DIR__ . "/../../autoload/autoload.php";

// Lấy danh sách các danh mục sản phẩm từ cơ sở dữ liệu
$category = $db->fetchAll("category");

// Lấy ID sản phẩm cần chỉnh sửa từ request và chuyển đổi sang kiểu số nguyên
$id = intval(getInput('id'));

// Lấy thông tin sản phẩm cần chỉnh sửa từ cơ sở dữ liệu
$editProduct = $db->fetchID("product", $id);

// Kiểm tra xem sản phẩm có tồn tại hay không
if (empty($editProduct)) {
    $_SESSION['error'] = "Product does not exist";
    redirectAdmin("product");
}

// Xử lý khi có dữ liệu POST được gửi lên từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        "name" => postInput('name'),
        "slug" => to_slug(postInput("name")),
        "category_id" => postInput("category_id"),
        "price" => postInput("price"),
        "number" => postInput("number"),
        "cpu" => postInput("cpu"),
        "short_content" => postInput("short_content"),
        "content" => postInput("content"),
        "sale" => postInput("sale"),
        "bonus" => postInput("bonus"),
    ];
    $error = [];

    // Kiểm tra và xử lý các trường thông tin sản phẩm bắt buộc
    $required_fields = ['name', 'category_id', 'price', 'number', 'short_content', 'content', 'cpu'];
    foreach ($required_fields as $field) {
        if (empty($data[$field])) {
            $error[$field] = "Vui lòng nhập " . str_replace('_', ' ', $field) . " của sản phẩm";
        }
    }

    // Kiểm tra và xử lý tệp tải lên (hình ảnh sản phẩm)
    if (!empty($_FILES['thumbar']['name'])) {
        $file_name = $_FILES['thumbar']['name'];
        $file_tmp = $_FILES['thumbar']['tmp_name'];
        $file_type = $_FILES['thumbar']['type'];
        $file_error = $_FILES['thumbar']['error'];

        if ($file_error == 0) {
            $part = ROOT . "product/";
            $data['thumbar'] = $file_name;
        }
    }

    // Nếu không có lỗi, tiến hành cập nhật thông tin sản phẩm vào cơ sở dữ liệu
    if (empty($error)) {
        $update = $db->update("product", $data, ["id" => $id]);
        if ($update > 0) {
            move_uploaded_file($file_tmp, $part . $file_name);
            $_SESSION['success'] = "Cập nhật thành công!";
        } else {
            $_SESSION['error'] = "Cập nhật thất bại!";
        }
        redirectAdmin("product");
    }
}
?>

<?php require_once __DIR__ . "/../../layouts/header.php"; ?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Cập nhật sản phẩm mới</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Trang chính</a></li>
            <li class="breadcrumb-item"><a href="index.php">Sản phẩm</a></li>
            <li class="breadcrumb-item active">Cập nhật</li>
        </ol>

        <!-- Thông báo lỗi -->
        <?php require_once __DIR__ . "/../../../partials/notification.php"; ?>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-folder-plus mr-1"></i>
                <b>Cập nhật sản phẩm</b>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <!-- Dropdown chọn danh mục sản phẩm -->
                    <div class="form-group row">
                        <label for="category_id" class="col-sm-2 col-form-label" style="text-align: right;"><b>Danh mục sản phẩm</b></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="category_id">
                                <option value="">--Chọn danh mục sản phẩm--</option>
                                <?php foreach ($category as $item) : ?>
                                    <option value="<?php echo $item['id']; ?>" <?php echo ($editProduct['category_id'] == $item['id']) ? "selected" : ""; ?>>
                                        <?php echo $item['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($error['category_id'])) : ?>
                                <p class="text-danger"><?php echo $error['category_id']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Các trường thông tin sản phẩm -->
                    <!-- Tên sản phẩm -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label" style="text-align: right;"><b>Tên sản phẩm</b></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" placeholder="Nhập tên sản phẩm..." name="name" value="<?php echo $editProduct['name']; ?>">
                            <?php if (isset($error['name'])) : ?>
                                <p class="text-danger"><?php echo $error['name']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Giá sản phẩm -->
                    <div class="form-group row">
                        <label for="price" class="col-sm-2 col-form-label" style="text-align: right;"><b>Giá sản phẩm</b></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="price" placeholder="Nhập giá sản phẩm..." name="price" value="<?php echo $editProduct['price']; ?>">
                            <?php if (isset($error['price'])) : ?>
                                <p class="text-danger"><?php echo $error['price']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Số lượng sản phẩm -->
                    <div class="form-group row">
                        <label for="number" class="col-sm-2 col-form-label" style="text-align: right;"><b>Số lượng sản phẩm</b></label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="number" placeholder="Nhập số lượng sản phẩm..." name="number" value="<?php echo $editProduct['number']; ?>">
                            <?php if (isset($error['number'])) : ?>
                                <p class="text-danger"><?php echo $error['number']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Sản phẩm đang giảm giá -->
                    <div class="form-group row">
                        <label for="sale" class="col-sm-2 col-form-label" style="text-align: right;"><b>Sản phẩm đang giảm giá</b></label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="sale" placeholder="Nhập phần trăm giảm giá..." name="sale" value="<?php echo $editProduct['sale']; ?>">
                        </div>
                    </div>

                    <!-- Hình ảnh sản phẩm -->
                    <div class="form-group row">
                        <label for="thumbar" class="col-sm-2 col-form-label" style="text-align: right;"><b>Hình ảnh sản phẩm</b></label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" id="thumbar" name="thumbar">
                            <?php if (isset($error['thumbar'])) : ?>
                                <p class="text-danger"><?php echo $error['thumbar']; ?></p>
                            <?php endif; ?>
                            <img src="<?php echo uploads() ?>product/<?php echo $editProduct['thumbar']; ?>" width="250px" height="220px">
                        </div>
                    </div>

                    <!-- Thông tin bổ sung -->
                    <div class="form-group row">
                        <label for="bonus" class="col-sm-2 col-form-label" style="text-align: right;"><b>Thông tin bổ sung</b></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="bonus" placeholder="Nhập thông tin bổ sung..." name="bonus" value="<?php echo $editProduct['bonus']; ?>">
                        </div>
                    </div>

                    <!-- Mô tả CPU -->
                    <div class="form-group row">
                        <label for="cpu" class="col-sm-2 col-form-label" style="text-align: right;"><b>Mô tả CPU</b></label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="cpu" rows="5"><?php echo $editProduct['cpu']; ?></textarea>
                            <?php if (isset($error['cpu'])) : ?>
                                <p class="text-danger"><?php echo $error['cpu']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Mô tả ngắn gọn -->
                    <div class="form-group row">
                        <label for="short_content" class="col-sm-2 col-form-label" style="text-align: right;"><b>Mô tả ngắn gọn</b></label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="short_content" rows="4"><?php echo $editProduct['short_content']; ?></textarea>
                            <?php if (isset($error['short_content'])) : ?>
                                <p class="text-danger"><?php echo $error['short_content']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Mô tả chi tiết -->
                    <div class="form-group row">
                        <label for="content" class="col-sm-2 col-form-label" style="text-align: right;"><b>Mô tả chi tiết</b></label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="content" rows="5"><?php echo $editProduct['content']; ?></textarea>
                            <?php if (isset($error['content'])) : ?>
                                <p class="text-danger"><?php echo $error['content']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Nút cập nhật -->
                    <div class="form-group row">
                        <div class="offset-md-2 col-sm-8">
                            <button type="submit" class="btn btn-success">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="/public/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content');
    CKEDITOR.replace('cpu');
</script>

<?php require_once __DIR__ . "/../../layouts/footer.php"; ?>
