
<div class="container">
<div class="header">
 <div class="headertop_desc">
  
        <div class="account_desc">
         <ul>
         <li><a href="#">Register</a></li>
         <li><a href="login.php">Login</a></li>
         <li><a href="#">Delivery</a></li>
         <li><a href="cart.php">Checkout</a></li>
        <li><a href="admin.php">My Account</a></li>
     </ul>
</div>
  <div class="header">
<div class="logo">

<img src="img/logo.png" alt="smart farm" width="200">
</div>
<div class="header-right">
<div class="contact-info">
<ul>
<li>Help line</li>
<li>+254-0715-1302</li>
</ul>
</div>
<div class="menu">
<ul class="nav">

<li class="active"><a title="Home" href="#">Home</a></li>
<li><a href="#">About</a></li>
<li><a href="#">Store</a></li>
<li><a href="#">Contact</a></li>
<li><a href="#l">Subscribe</a></li>
<li><a href="#">Customer Support</a></li>
<li><a href="cart.php">My Cart <span class="glyphicon glyphicon-shopping-cart"></span></a></li>
<div class="clear"></div>

<ul>
<?php
$sql2= "SELECT * FROM categoriez WHERE parent=0";
$pquery = $db->query($sql2);
?>
<?php while($parent =mysqli_fetch_assoc($pquery)):?>
    <?php $parent_id = $parent['id'];
    $sql= "SELECT * FROM categoriez WHERE parent='$parent_id'";
	$cquery = $db->query($sql);
	
      ?>
 <li class="dropdown">
 <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category'];?><span class="caret"></span></a>
   <ul class="dropdown-menu" role="menu">
     <?php while($child = mysqli_fetch_assoc($cquery)):?>
      <li><a href="category.php?cat=<?=$child['id'];?>"><?php echo $child['category'];?></a></li>
      <?php endwhile;?>
    </ul>
</li>
    <?php endwhile;?>
 </ul>
</div>
</div>
</div>
</div>
</div>
</div>