<?php
$cart_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
$price_sort =((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']):'');
$min_price = ((isset($_REQUEST['min_price']))?sanitize($_REQUEST['min_price']):'');
$max_price = ((isset($_REQUEST['max_price']))?sanitize($_REQUEST['max_price']):'');
$b = ((isset($_REQUEST['brand']))?sanitize($_REQUEST['brand']):'');
$brandQ = $db->query("SELECT * FROM brand ORDER BY brand");
?>
<h3 class="text-center"><span class="glyphicon glyphicon-search"></span>&nbsp; &nbsp;Search by</h3>
<h4 class="text-center">price</h4>
<form action="search.php" method="post">
<input type="hidden" name="cat" value="<?=$cart_id;?>">
<input type="hidden" name="price_sort" value="0">
<input type="radio" name="pric_sort" value="low<?=(($price_sort ='low')?' checked':'')?>">low to high<br>
<input type="radio" name="pric_sort" value="high<?=(($price_sort ='high')?' checked':'')?>">high to low<br>
<input type="text" name="min_price" class="price_range form-control" style="width:75px" placeholder="min ksh" value="<?=$min_price;?>">To
<input type="text" name="max_price" class="price_range form-control" style="width:75px" placeholder="max ksh" value="<?=$max_price;?>" >
<h4 class="text-center">Brand</h4>
<input type="radio" name="brand" value=""<?=(($b=='')?' checked':'');?>>All<br>
<?php while($brand = mysqli_fetch_assoc($brandQ)):?>
<input type="radio" name="brand" value="<?=$brand['id'];?>"<?=(($b==$brand['id'])?' checked':'');?>><?=$brand['brand']?><br>
 <?php endwhile;?>
 <input type="submit" value="search" class="btn btn-xs btn-success pull-right">
 <div class="clearfix"></div>
 </form>