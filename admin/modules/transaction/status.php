<?php
    $open = "transaction";
    require_once __DIR__. "/../../autoload/autoload.php";

    $id = intval(getInput('id'));
    $EditTransaction = $db->fetchID("transaction" ,$id);
    if(empty($EditTransaction))
    {
        $_SESSION['error'] ="Data does not exist";
        redirectAdmin("transaction");
    }

    if($EditTransaction['status']==1)
    {
        $_SESSION['error'] ="Your order has been processed and you CAN'T change its status !";
        redirectAdmin("transaction");
    }


    $status=$EditTransaction['status']== 0 ? 1 : 0 ;

    $update =$db->update("transaction",array("status"=> $status),array("id"=>$id));

    if($update > 0)
    {
        $_SESSION['success']="Update transaction successfully !";

        $sql = " SELECT product_id,qty FROM orders WHERE transaction_id =$id";

        $order = $db->fetchsql($sql);

        foreach($order as $item){

            $idproduct=intval($item['product_id']);

            $product=$db->fetchID("product",$idproduct);

            $number=$product['number']-$item['qty'];


            $up_pro =$db->update("product",array("number"=>$number,"pay"=>$product['pay']+1),array("id"=>$idproduct));
        }
        redirectAdmin("transaction");
    }
    else{
        $_SESSION['error']="Update transaction NOT successfully !";
        redirectAdmin("transaction");
    }
?>