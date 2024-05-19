
<!-- This is HEADER -->
<?php 
    require_once __DIR__. "/autoload/autoload.php"; 
    
?>

<?php require_once __DIR__. "/layouts/header.php" ;?>
<?php require_once __DIR__. "/layouts/banner.php" ;?>
<!-- END HEADER -->
<div class="col-md-9 bor" style="padding-bottom: 15px;">
    <section class="box-main1" >
        <!-- ----------MAIN-------------- -->
            <h3 class="title-main"><a href="">Đăng nhập</a></h3>
            <?php if(isset($_SESSION['success'])) :?>
                <div class="alert alert-success" style="margin-top:20px;">
                    <strong style="color:#155724;">SUCCESS ! </strong><?php echo $_SESSION['success']; unset($_SESSION['success']) ?>
                </div>
            <?php endif ?>
            <?php if(isset($_SESSION['error'])) :?>
                <div class="alert alert-danger" style="margin-top:20px;">
                    <strong style="color:#a94442;">ERROR ! </strong><?php echo $_SESSION['error']; unset($_SESSION['error']) ?>
                </div>
            <?php endif ?>
            
            <form class="form-horizontal" role="form" style="margin-top:30px" action="" method="POST">
                <div class="form-group">
                    <div style="text-align: center; margin-top: 10px;margin-bottom: 10px;">Vui lòng nhập email hoặc số điện thoại để tìm kiếm tài khoản của bạn.</div>
                    <label for="email" class="col-sm-3 control-label">Địa chỉ E-Mail</label>
                    <div class="col-sm-6">
                        <input type="email" id="email" placeholder="Email@gmail.com" class="form-control" name="email">
                        <?php if(isset($error['email'])):?>
                            <p class="text-danger">  <?php echo $error['email'] ?> </p>
                        <?php endif ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary col-md-6 col-md-offset-3 ">Gửi yêu cầu tới Email</button>
                <a href="login.php" class= "col-md-2 col-md-offset-5 " style="margin-top:10px;" id="forgot_pswd">Quay lại đăng nhập</a>
            </form> <!-- /form -->
        <!-- ----------MAIN-------------- -->
    </section>
</div>


<!-- This is Footer -->
<?php require_once __DIR__. "/layouts/footer.php" ;?>
<!-- END Footer -->