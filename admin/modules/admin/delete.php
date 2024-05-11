<?php
// Đoạn mã để xóa một admin từ cơ sở dữ liệu
$open = "admin";
require_once __DIR__. "/../../autoload/autoload.php"; 

// Lấy ID của admin cần xóa từ URL và chuyển đổi sang kiểu số nguyên
$id = intval(getInput('id'));

// Tìm admin trong cơ sở dữ liệu dựa trên ID
$Deleteadmin = $db->fetchID("admin" ,$id);

// Kiểm tra nếu không tìm thấy admin với ID cụ thể
if(empty($Deleteadmin))
{
    $_SESSION['error'] ="Dữ liệu không tồn tại";
    redirectAdmin("admin");
}

// Thực hiện xóa admin khỏi cơ sở dữ liệu dựa trên ID
$num = $db->delete("admin",$id);

// Kiểm tra số dòng bị ảnh hưởng bởi truy vấn xóa
if($num > 0)
{
    // Nếu xóa thành công, thông báo thành công và chuyển hướng trở lại trang admin
    $_SESSION['success'] = "Xóa admin thành công !";
    redirectAdmin("admin");
}
else
{
    // Nếu xóa không thành công, thông báo lỗi và chuyển hướng trở lại trang admin
    $_SESSION['error'] = "xóa admin không thành công !";
    redirectAdmin("admin");
}
?>
