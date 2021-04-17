<?php
require_once'core/init.php';
include 'includes/head.php';
include 'includes/menu.php';
include 'includes/slider.php';
include 'includes/left.php';
if(isset($_GET['cat'])){
	$cat_id = sanitize($_GET['cat']);	
}else{
	$cat_id = '';
	}

$sql= "SELECT * FROM products WHERE categories='$cat_id'";
$productQ=$db->query($sql);
$cquery = $db->query($sql);
$category = get_category($cat_id);
?>



<div class="content-bottom-right">
 <h3><?=$category['parent'].' '.$category['child'];?></h3>
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
<?php include 'includes/footer.php'?>

</body>
</html>