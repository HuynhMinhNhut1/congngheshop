<?php
    $open = "transaction";
    require_once __DIR__. "/../../autoload/autoload.php";
    // $product = $db->fetchAll("product");
    if(isset($_GET['page']))
    {
        $p=$_GET['page'];
    }
    else
    {
        $p=1;
    }

    $sql ="SELECT transaction.* , users.name as nameusers,users.phone as phoneusers  FROM transaction LEFT JOIN users on users.id = transaction.users_id ORDER BY ID Desc ";

    $transaction=$db->fetchJone('transaction',$sql,$p,5,true);
    if(isset($transaction['page']))
    {
        $sotrang=$transaction['page'];
        unset($transaction['page']);
    }
?>
<?php require_once __DIR__. "/../../layouts/header.php" ;?>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">List transaction</h1>
        <!--  -->
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo base_url_admin() ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" >List Transaction</li>
        </ol>
        <div class="cleanfix"></div>

        <!-- Notification Error -->
        <?php require_once __DIR__. "/../../../partials/notification.php"; ?>

        <!-- <div class="card mb-4">
            <div class="card-body">
                <p class="mb-0"></p>
            </div>
        </div> -->
        <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            DataTable transaction
        </div> 
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Total</th>
                            <th>Date created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $Number = 1 ; foreach ($transaction as $item): ?>
                            <tr>
                                <td><?php echo $Number ?></td>
                                <td><?php echo $item['nameusers'] ?></td>
                                <td><?php echo $item['phoneusers'] ?></td>
                                <td><?php echo formatPrice($item['amount']) ?></td>
                                <td><?php echo $item['created_at'] ?></td>
                                <td>
                                    <a class="js_order_item btn btn-xs btn-success" data-id="<?php echo $item['id'] ?>"  href="view.php?id=<?php echo $item['id'] ?>" ><i class="ace-icon fa fa-eye"> </i>view</a>
                                    <a class="btn btn-xs btn-danger" href="delete.php?id=<?php echo $item['id'] ?>"><i  class="fa fa-times"></i> delete </a>
                                </td> 
                               
                            </tr>
                        <?php $Number++; endforeach ?>
                    </tbody>
                </table>
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
                <div class="pull-right" style="float: right;">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                            </li>
                            <?php for($i = 1 ; $i <= $sotrang ; $i++ ):?> 
                                <?php 
                                    if(isset($_GET['page']))
                                    {
                                        $p=$_GET['page'];
                                    }
                                    else
                                    {
                                        $p=1;
                                    }
                                ?>
                                <li class="page-item <?php echo ($i==$p) ?'active': '' ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                                <?php endfor; ?>

                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>
<script>
    $(document).ready(function(){
        $(".js_order_item").click(function(event){
            event.preventDefault();
            let $this = $(this);
            let url =$this.attr('href');
            $(".transaction_id").text($this.attr('data-id'));
            $("#myModelOrder").modal('show');
            $.ajax({
                url: url,
            }).done(function(result){
                console.log(result);
                if(result)
                {
                $("#md_content").html(result);
                }
            });
        });
   });
 </script>
<?php require_once __DIR__. "/../../layouts/footer.php" ;?>