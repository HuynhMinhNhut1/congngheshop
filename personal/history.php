<?php
    // Khai báo biến $open với giá trị "transaction" để xác định trang đang mở
    $open = "transaction";
    
    // Nạp tệp autoload.php để sử dụng các hàm và biến đã định nghĩa sẵn
    require_once __DIR__. "/../autoload/autoload.php";
    
    // Lấy giá trị của tham số 'id' từ đầu vào và chuyển đổi thành số nguyên
    $id = intval(getInput('id'));
    
    // Truy vấn SQL để lấy thông tin giao dịch và thông tin người dùng
    $sql ="SELECT users.* ,transaction.* FROM transaction , users WHERE users.id = transaction.users_id and users.id=$id ORDER BY transaction.update_at Desc ";
    
    // Thực hiện truy vấn SQL
    $transaction = mysqli_query($con,$sql);
?>

<?php require_once __DIR__. "/../layout-personal/headeruser.php" ;?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Cập nhật quản trị viên</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="#">Người dùng</a></li>
            <li class="breadcrumb-item active">Lịch sử giao dịch</li>
        </ol>
        <div class="cleanfix"></div>

        <!-- Thông báo lỗi (nếu có) -->
        
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-folder-plus mr-1"></i><b> Lịch sử giao dịch</b>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Điện thoại</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Xem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Lặp qua từng giao dịch và hiển thị thông tin -->
                        <?php $Number = 1 ; foreach ($transaction as $item): ?>
                            <tr>
                                <td><?php echo $Number ?></td>
                                <td><?php echo $item['name'] ?></td>
                                <td><?php echo $item['phone'] ?></td>
                                <td><?php echo formatPrice($item['amount']) ?></td>
                                <td>
                                    <p class=""><?php echo $item['status']==0 ? 'Chưa xử lý' : 'Đã xử lý' ?></p>
                                </td>
                                <td><?php echo $item['created_at'] ?></td>
                                <td>
                                    <a class="js_order_item btn btn-xs btn-success" data-id="<?php echo $item['id'] ?>" href="view.php?id=<?php echo $item['id'] ?>" ><i class="ace-icon fa fa-eye"> </i>xem</a>
                                </td>
                            </tr>
                        <?php $Number++; endforeach ?>
                    </tbody>
                </table>

                <!-- Modal hiển thị chi tiết đơn hàng -->
                <div id="myModelOrder" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Chi tiết mã đơn hàng : #<b class='transaction_id'></b></h4>
                            </div>
                            <div class="modal-body" id="md_content">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
   $(function(){
     // Khi người dùng nhấp vào nút xem chi tiết đơn hàng
     $(".js_order_item").click(function(event){
        event.preventDefault();
        let $this = $(this);
        let url = $this.attr('href');
        
        // Hiển thị modal và tải nội dung chi tiết đơn hàng
        $(".transaction_id").text($this.attr('data-id'));
        $("#myModelOrder").modal('show');

        // Gửi yêu cầu AJAX để lấy nội dung chi tiết đơn hàng
        $.ajax({
            url: url,
        }).done(function(result){
            console.log(result);
            if(result) {
                $("#md_content").html('').append(result);
            }
        });
     });
   });
</script>

<?php require_once __DIR__. "/../layout-personal/footeruser.php" ;?>
