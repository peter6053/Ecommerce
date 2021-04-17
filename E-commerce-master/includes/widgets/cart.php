
<h3 class="text-center"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;&nbsp;Shopping cart</h3>
<div>
<?php if(empty($cart_id)):?>
<p>Your shopping cart is empty</p>
<?php else:
$cartQ = $db->query("SELECT * FROM carts WHERE id = '{$cart_id}'");
$results = mysqli_fetch_assoc($cartQ);
$items = json_decode($results['items'],true);
$sub_total = 0;
?>
<table class="table table-condensed" id="cart_widget">

<tbody>
<?php foreach($items as $item):
$productQ = $db->query("SELECT * FROM products WHERE id ='{$item['id']}'");
$product = mysqli_fetch_assoc($productQ);
?>
<tr class="bg-warning">
<td><?=$item['quantity']?></td>
<td><?=substr($product['title'],0.5);?></td>
<td><?=money($item['quantity']*$product['price'])?></td>
</tr>
<?php
$sub_total += ($item['quantity']*$product['price']);
 endforeach;?>
 <tr style="font-size:12px;" class="bg-info">
 <td></td>
 <td>subtotal</td>
 <td><?=money($sub_total);?></td>
 </tr>
</tbody>
</table>
<a href="cart.php" class="btn btn-xs btn-primary pull-right">view cart</a>
<div class="clearfix"></div>
<?php endif;?>
</div>