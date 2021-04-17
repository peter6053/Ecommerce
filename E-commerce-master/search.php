<?php
require_once'core/init.php';
include 'includes/head.php';
include 'includes/menu.php';
include 'includes/slider.php';
include 'includes/left.php';
$sql ="SELECT * FROM products";
$cart_id =(($_POST['cat'] !='')?sanitize($_POST['cat']):'');
if($cart_id ==''){
	$sql .=' WHERE deleted=0';	
	}else{
	$sql .= " WHERE categories='{$cat_id}' AND deleted =0";	
		}
$price_sort =(($_POST['price_sort'] !='')?sanitize($_POST['price_sort']):'');
$min_price =(($_POST['min_price'] !='')?sanitize($_POST['min_price']):'');
$max_pricet =(($_POST['max_price'] !='')?sanitize($_POST['max_price']):'');
$brand =(($_POST['brand'] !='')?sanitize($_POST['brand']):'');
if($min_price != ''){
	$sql .=" AND price>='{$min_price}'";
	}
	if($max_price != ''){
	$sql .=" AND price<='{$min_price}'";
	}
	if($brand != ''){
	$sql .=" AND brand = '{$brand}'";	
		}
	if($price_sort == 'low'){
		$sql .=" ORDER BY price";
		}		
		if($price_sort == 'high'){
		$sql .=" ORDER BY price DESC";
		}		
$productQ=$db->query($sql);
$category = get_category($cat_id);
?>


<div class="row">
<div class="content-bottom-right">
<?php if($cart_id != ''):?>
 <h3><?=$category['parent'].' '.$category['child'];?></h3>
 <?php else:?>
 <h3>All categories</h3>
 <?php endif;?>
   <div class="section group" ><?php while($product=mysqli_fetch_assoc($productQ)):?>
    <div class="grid_1_of_4 images_1_of_4">
     <h4><a href="https://p.w3layouts.com/demos/ecomm/web/preview.html"><?=$product['title'];?> </a></h4>
      <a href="https://p.w3layouts.com/demos/ecomm/web/preview.html">
       <img alt="<?=$product['title'];?>" src="<?=$product['image'];?>" width="260" height="180"></a>
        <div class="price-details">
         <div class="price-number">
       <h4><span class="rupees">ksh<?=$product['list_price'];?> </span></h4>   
      </div>
<div class="add-cart">
<button type="button" class="btn btn-success btn-md" onclick="modal(<?=$product['id'];?>)"> Details</button>
</div> 
<div class="clear"></div>
</div> </div>
<?php endwhile;?>
</div>
<?php include 'includes/footer.php'?>

</body>
</html>