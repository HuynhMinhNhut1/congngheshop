<?php
    $open = "transaction";
    require_once __DIR__. "/../../autoload/autoload.php"; 

    $id = intval(getInput('id'));

    $viewtransaction = $db->fetchID("transaction" ,$id);
    if(empty($viewtransaction))
    {
        $_SESSION['error'] ="Data does not exist";
        redirectAdmin("transaction");
    }
    
    $num = $db->delete("transaction",$id);
    if($num>0)
    {
        $_SESSION['success']="Delete transaction successfully !";
        redirectAdmin("transaction");
    }
    else
    {
        //not successfuly
        $_SESSION['error']="Delete transaction NOT successfully !";
        redirectAdmin("transaction");
    }
    
?>