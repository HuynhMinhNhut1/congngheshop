</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Phần chân trang -->
<section id="footer">
    <div class="container">
        <div class="col-md-3" id="shareicon">
            <!-- Các biểu tượng chia sẻ mạng xã hội -->
            <ul>
                <li><a href="https://www.facebook.com/profile.php?id=100041641999879"><i class="fa fa-facebook"></i></a></li>
                <li><a href="https://twitter.com/Minhnhut"><i class="fa fa-twitter"></i></a></li>
                <li><a href="https://mail.google.com/mail"><i class="fa fa-google-plus"></i></a></li>
                <li><a href="https://www.youtube.com/"><i class="fa fa-youtube"></i></a></li>
            </ul>
        </div>
        <div class="col-md-8" id="title-block">
            <div class="pull-left">

            </div>
            <div class="pull-right">

            </div>
        </div>
    </div>
</section>

<!-- Phần nút chân trang -->
<section id="footer-button">
    <div class="container">
        <div class="col-md-4" id="ft-about">
            <!-- Thông tin về website -->
            <p>Website của chúng tôi là một địa điểm uy tín để mua laptop mới nhất và tốt nhất trên thị trường. Chúng tôi cung cấp một loạt các laptop từ tất cả các thương hiệu lớn, bao gồm Dell, Asus, Macbook, Lenovo. Chúng tôi cũng có đội ngũ chuyên gia am hiểu có thể giúp bạn tìm thấy laptop hoàn hảo cho nhu cầu của bạn.</p>
        </div>
        <div class="col-md-3 box-footer">
            <!-- Danh sách liên kết tài khoản -->
            <h3 class="tittle-footer">Tài khoản</h3>
            <ul>
                <li><i class="fa fa-angle-double-right"></i><a href=""><i></i>Giới Thiệu</a></li>
                <li><i class="fa fa-angle-double-right"></i><a href="product.php"><i></i>Sản phẩm</a></li>
                <li><i class="fa fa-angle-double-right"></i><a href=""><i></i>Liên hệ</a></li>
                <li><i class="fa fa-angle-double-right"></i><a href="login.php"><i></i>Tài khoản</a></li>
                <li><i class="fa fa-angle-double-right"></i><a href=""><i></i>Tin tức</a></li>
            </ul>
        </div>
        <div class="col-md-3 box-footer"></div>
        <div class="col-md-3" id="footer-support">
            <!-- Thông tin liên hệ -->
            <h3 class="tittle-footer">Liên hệ với chúng tôi</h3>
            <ul>
                <li>
                    <p><i class="fa fa-home" style="font-size: 16px; padding-right: 5px;"></i>Information technology university</p>
                    <p><i class="sp-ic fa fa-mobile" style="font-size: 22px; padding-right: 5px;"></i>0777973754</p>
                    <p><i class="sp-ic fa fa-envelope" style="font-size: 13px; padding-right: 5px;"></i>huynhminhnhut@vlvh.ctu.edu.vn</p>
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- Chân trang với bản quyền -->
<section id="ft-bottom">
    <p class="text-center">Copyright © 2024. Nhựt Minh</p>
</section>

<!-- Kết thúc thẻ body và HTML -->
<script src="<?php echo base_url() ?>public/frontend/js/slick.min.js"></script>
</body>
</html>

<script type="text/javascript">
    $(function() {
        // Hiển thị/ẩn các phần tử ẩn khi rê chuột qua sản phẩm
        $hidenitem = $(".hidenitem");
        $itemproduct = $(".item-product");
        $itemproduct.hover(function() {
            $(this).children(".hidenitem").show(100);
        }, function() {
            $hidenitem.hide(500);
        })
    })

    $(function() {
        // Xử lý sự kiện cập nhật giỏ hàng
        $updatecart = $(".updatecart");
        $updatecart.click(function(e) {
            e.preventDefault();
            $qty = $(this).parents("tr").find(".qty").val();
            $key = $(this).attr("data-key");
            $.ajax({
                url: 'update_cart.php',
                type: 'GET',
                data: {
                    'qty': $qty,
                    'key': $key
                },
                success: function(data) {
                    if (data == 1) {
                        alert('Bạn đã cập nhật thành công giỏ hàng của mình!');
                        location.href = 'cart_product.php';
                    } else {
                        alert('Lấy làm tiếc! Số lượng bạn mua vượt quá số lượng hàng tồn kho của bạn!');
                        location.href = 'cart_product.php';
                    }
                }
            });
        })
    })
</script>
