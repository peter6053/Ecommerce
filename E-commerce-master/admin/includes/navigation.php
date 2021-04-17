<div class="container">
<div class="header">
 <div class="headertop_desc">
  
        <div class="account_desc">
         <ul>
         <li><a href="users.php">Register</a></li>
         <li><a href="login.php">Login</a></li>
         <li><a href="#">Delivery</a></li>
         <li><a href="#">Checkout</a></li>
        <li><a href="#">My Account</a></li>
     </ul>
</div>
  <div class="header">
<div class="logo">

<img src="../img/logo.png" alt="smart farm" width="200">
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

<li class="active"><a title="Home" href="index.php">Admin</a></li>
<li><a href="categories.php">Categories</a></li>
<li><a href="users.php">Users</a></li>
<li><a href="archieved.php">Archieved</a></li>
<li><a href="products.php">Products</a></li>
<li><a href="brands.php">Brands</a></li>
<?php if(has_permission('admin')):?>
<li><a href="users.php">Users</a></li>
<?php endif;?>
<li class="dropdown"> 
<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello <?=$user_data['first'];?>!<span class="caret"></span></a>
<ul class="dropdown-menu" role="menu">
<li><a href="change_password.php">change password</a></li>
<li><a href="logout.php">logout</a></li>
</ul>
</li>
<div class="clear"></div>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>