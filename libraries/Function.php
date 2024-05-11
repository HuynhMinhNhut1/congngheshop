<?php

// Hàm lấy giá trị từ mảng $_POST
function postInput($string)
{
    return isset($_POST[$string]) ? $_POST[$string] : '';
}

// Hàm lấy giá trị từ mảng $_GET
function getInput($string)
{
    return isset($_GET[$string]) ? $_GET[$string] : '';
}

// Hàm trả về đường dẫn gốc của trang web
function base_url()
{
    return "http://localhost/congngheshop/";
}

// Hàm trả về đường dẫn gốc của trang quản trị
function base_url_admin()
{
    return "http://localhost/congngheshop/admin/";
}

// Hàm trả về đường dẫn tới thư mục public của trang quản trị
function public_admin()
{
    return base_url() . "public/admin/";
}

// Hàm trả về đường dẫn tới thư mục public của trang frontend
function public_frontend()
{
    return base_url() . "public/frontend/";
}

// Hàm trả về đường dẫn tới thư mục modules trong trang quản trị
function modules($url)
{
    return base_url() . "admin/modules/" . $url;
}

// Hàm trả về đường dẫn tới thư mục uploads của trang web
function uploads()
{
    return base_url() . "public/uploads/";
}

// Hàm chuyển hướng đến một URL cụ thể
function redirectStyle($url = "")
{
    header("location: " . base_url() . "{$url}");
    exit();
}

// Hàm debug dữ liệu hiện tại và hiển thị thông tin debug
function _debug($data)
{
    echo '<pre class="sf-dump" style=" color: #222; overflow: auto;">';
    echo '<div>Your IP: ' . $_SERVER['REMOTE_ADDR'] . '</div>';
    $debug_backtrace = debug_backtrace();
    $debug = array_shift($debug_backtrace);
    echo '<div>File: ' . $debug['file'] . '</div>';
    echo '<div>Line: ' . $debug['line'] . '</div>';
    if (is_array($data) || is_object($data)) {
        print_r($data);
    } else {
        var_dump($data);
    }
    echo '</pre>';
}

// Hàm loại bỏ các ký tự đặc biệt để tạo slug
function to_slug($str)
{
    $str = trim(mb_strtolower($str));
    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
    $str = preg_replace('/(đ)/', 'd', $str);
    $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
    $str = preg_replace('/([\s]+)/', '-', $str);
    return $str;
}

// Hàm chuyển hướng đến trang quản trị với URL cụ thể
function redirectAdmin($url = "")
{
    header("location: " . base_url() . "admin/modules/{$url}");
    exit();
}

// Hàm chuyển hướng đến URL khác
function redirect($url = "")
{
    header("location: " . base_url() . "../{$url}");
    exit();
}

// Hàm loại bỏ các ký tự đặc biệt để ngăn chặn tấn công XSS
function xss_clean($data)
{
    // Loại bỏ các thẻ HTML bị đe dọa
    $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    // Loại bỏ các thuộc tính nguy hiểm
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    // Loại bỏ các thẻ HTML nguy hiểm
    do {
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    } while ($old_data !== $data);

    // Trả về dữ liệu đã được làm sạch
    return $data;
}

// Hàm xác định mức giảm giá dựa trên giá trị sản phẩm
function sale($number)
{
    $number = intval($number);
    if ($number < 50000000) {
        return 0;
    } elseif ($number < 100000000) {
        return 5;
    } else {
        return 10;
    }
}

// Hàm định dạng giá tiền theo định dạng 19.999.000 đồng
function formatPrice($number)
{
    $number = intval($number);
    return number_format($number, 0, ',', '.') . "đ";
}

// Hàm định dạng giá tiền sau khi áp dụng mức giảm giá
function formatPriceSale($number, $sale)
{
    $number = intval($number);
    $sale = intval($sale);

    $price = $number * (100 - $sale) / 100;
    return formatPrice($price);
}
?>
