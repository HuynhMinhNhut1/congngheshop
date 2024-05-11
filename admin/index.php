<?php
    // Đã bao gồm file autoload.php để load các class cần thiết
    require_once __DIR__. "/autoload/autoload.php";

    // Lấy số lượng sản phẩm từ bảng product
    $get_products = "select * from product";
    $run_products = mysqli_query($con,$get_products);
    $count_products = mysqli_num_rows($run_products);

    // Lấy số lượng người dùng từ bảng users
    $get_users = "select * from users";
    $run_users = mysqli_query($con,$get_users);
    $count_users = mysqli_num_rows($run_users);
    
    $get_transaction = "select * from transaction";
    $run_transaction = mysqli_query($con,$get_transaction);
    $count_transaction = mysqli_num_rows($run_transaction);
    $get_totaltransaction = "SELECT SUM(amount) as SUM FROM transaction";
    $run_totaltransaction = mysqli_query($con,$get_totaltransaction);
    $sum_totaltransaction = mysqli_fetch_assoc($run_totaltransaction)['SUM'];

    // Lấy số lượng liên hệ từ bảng contacts
    $get_contacts = "select * from contacts";
    $run_contacts = mysqli_query($con,$get_contacts);
    $count_contacts = mysqli_num_rows($run_contacts);
?>

<?php
    // Xác định trang hiện tại và số lượng dữ liệu trên mỗi trang
    $open = "transaction";
    if(isset($_GET['page'])) {
        $p=$_GET['page'];
    } else {
        $p=1;
    }

    // Truy vấn lấy dữ liệu từ bảng transaction kèm theo thông tin người dùng
    $sql ="SELECT transaction.* , users.name as nameusers,users.phone as phoneusers  
            FROM transaction LEFT JOIN users on users.id = transaction.users_id 
            ORDER BY created_at Desc ";

    // Sử dụng phương thức fetchJone để lấy dữ liệu trang hiện tại
    $transaction=$db->fetchJone('transaction',$sql,$p,5,true);

    // Xử lý phân trang
    if(isset($transaction['page'])) {
        $sotrang=$transaction['page'];
        unset($transaction['page']);
    }
?>

<?php require_once __DIR__. "/layouts/header.php" ;?>

<?php require_once __DIR__. "/layouts/footer.php" ;?>
