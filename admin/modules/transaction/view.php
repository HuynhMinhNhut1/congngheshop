<?php
    $open = "transaction";
    require_once __DIR__. "/../../autoload/autoload.php";

    $id = intval(getInput('id'));
    $sql ="SELECT product.name , product.thumbar, product.price, orders.qty, orders.price,orders.product_id from transaction, orders, product 
    WHERE transaction.id = $id and transaction.id = orders.transaction_id and orders.product_id = product.id";
    $Detailproduct = $db->fetchsql($sql);
?>
<table class="table">
    <thead>
      <tr>
        <th scope="col">STT</th>
        <th scope="col">Name Product</th>
        <th scope="col">Image</th>
        <th scope="col">Price</th>
        <th scope="col">Amount</th>
      </tr>
    </thead>
    <tbody>
      <?php $Number = 1 ; foreach ($Detailproduct as $item): ?>
          <tr>
              <td><?php echo $Number ?></td>
              <td><a href="http://congngheshop.com/detail_product.php?id=<?php echo $item['product_id'] ?>"><?php echo $item['name'] ?></a></td>
              <td>
                  <img src="<?php echo uploads()?>product/<?php echo $item['thumbar']?>" width="100px" height="70px">
              </td>
              <td><?php echo formatPrice($item['price']) ?></td>
              <td><?php echo $item['qty'] ?></td>
          </tr>
      <?php $Number++; endforeach ?>
    </tbody>
  </table>


