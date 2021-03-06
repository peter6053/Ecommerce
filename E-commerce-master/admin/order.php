<?php
require_once"../core/init.php";
if(!is_logged_in()){
	header('Location: loggin.php');
}
include "head.php";


if(isset($_GET['complete']) && $_GET['complete']==1){
	$cart_id =sanitize((int)$_GET['cart_id']);
	$db->query("UPDATE carts SET shipped==1 WHERE id = '{cart_id}'");
	$_SESSION['success_flash']="The order has been completed";
	header('Location: index.php');
	}

$txn_id = sanitize((int)$_GET['txn_id']);
$txnQuery = $db->query("SELECT * FROM transactions WHERE id ='{$txn_id}'");
$txn = mysqli_fetch_assoc($txnQuery);
$cart_id =$txn['cart_id'];
$cartQ = $db->query("SELECT * FROM carts WHERE id ='{$cart_id}'");
$cart = mysqli_fetch_assoc($cartQ);
$items = json_decode($cart['items'],true);
$idArray= array();
$products =array();
foreach($items as $item){
	$idArray[] = $item['id'];
	}
	$ids = implode(',',$idArray); 
	$productQ = $db->query("SELECT i.id as 'id',i.title as 'title',c.id as 'cid',c.category as 'child',p.category as 'parent'     FROM products i
	LEFT JOIN categories c ON i.categories = c.id
	LEFT JOIN categories p ON c.parent = p.id
	WHERE i.id IN ({$ids})
	");
	while($p = mysqli_fetch_assoc($productQ)){
		foreach($items as $item){
			if($item['id']==$p['id']){
				$x =$item;
				continue;
				}
		}
		$products[] = array_merge($x,$p);
	}
?>
<h2 class="text-center"></h2>
<table class="table table-condensed table-bordered table-striped ">
<thead>
  <th>Quantity</th>
  <th>Title</th>
  <th>Category</th>
  <th>Size</th>
</thead>
<tbody>
<?php foreach ($products as $product):?>
<tr>
  <td><?=$product['quantity']?></td>
   <td><?=$product['title']?></td>
    <td><?=$product['parent'].'~'.$product['child'];?></td>
     <td><?=$product['size']?></td>
     </tr>
<?php endforeach;?>
</tbody>
</table>
<div class="row">
<div class="col-md-6">
<h2 class="text-center">Ordered details</h2>
<table class="table table-condensed table-bordered table-striped">

 <tbody>
   <tr>
    <td>Subtotal</td>
    <td><?=money($txn['sub_total'])?></td>
   </tr>
   <tr>
    <td>Tax</td>
    <td><?=money($txn['tax'])?></td>
   </tr>
   <tr>
    <td>GrandTotal</td>
    <td><?=money($txn['grand_total'])?></td>
   </tr>
   <tr>
    <td>Date</td>
    <td><?=pretty_date($txn['txn_date'])?></td>
   </tr>
  </tbody>
</table>
</div>
<div class="col-md-6"></div>
<h2 class="text-center">Shipping Address</h2>
<address>
<?=$txn['full_name']?><br>
<?=$txn['street']?><br>
<?=($txn['street2'] !='')?$txn['street2'].'<br>':'';?>
<?=$txn['city'].','.$txn['county'].' '.$txn['zip_code']?><br>
<?=$txn['country']?><br>
</address>
</div>
<div class="pull-right">
<a href="index.php" class="btn btn-large btn-default">Cancle</a>
<a href="order.php?complete=1&cart_id =<?=$cart_id;?>'" class="btn btn-large btn-primary">Complete</a>
</div>

<?php
include "footer.php";
?>