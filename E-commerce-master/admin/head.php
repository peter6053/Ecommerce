<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../bootstrap-3.3.6-dist/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="../admin.css" type="text/css" rel="stylesheet">
<title>Untitled Document</title>
</head>

<body>
<div class="container-fluid display-table">
  <div class="row display-table-row">
   <!--side menu-->
     <div class="col-md-2 hidden-xs display-table-cell valign-top" id="side-menu">
       <h1 class="hidden-sm hidden-xs">Navigation</h1>
       <ul>
        <li class="link active">
         <a href="/ecco/agric/admin/index.php">
          <span class="glyphicon glyphicon-th" aria-hidden="true" ></span>
          <span class="hidden-sm hidden-xs" >Dashboard</span>
          </a>
        </li>
        <li class="link">
         <a href="categories.php">
          <span class="glyphicon glyphicon-cutlery" aria-hidden="true" ></span>
          <span class="hidden-sm hidden-xs">Categories</span>
          </a>
        </li>
        <li class="link">
         <a href="brands.php">
          <span class="glyphicon glyphicon-apple" aria-hidden="true" ></span>
          <span class="hidden-sm hidden-xs">Brands</span>
          </a>
        </li>
        <li class="link">
         <a href="users.php">
          <span class="glyphicon glyphicon-user" aria-hidden="true" ></span>
          <span class="hidden-sm hidden-xs">users</span>
          </a>
        </li>
        <li class="link">
         <a href="archieved.php">
          <span class="glyphicon glyphicon-trash" aria-hidden="true" ></span>
          <span class="hidden-sm hidden-xs">Archieve</span>
          </a>
        </li>
        <li class="link">
         <a href="products.php">
          <span class="glyphicon glyphicon-tags" aria-hidden="true" ></span>
          <span class="hidden-sm hidden-xs">Products</span>
           <span class="label label-warning pull-right hidden-sm hidden-xs">10</span> 
          </a>
        </li>
        
        <li class="link">
         <a href="#collapse-post" data-toggle="collapse" aria-controls="collapse-post">
          <span class="glyphicon glyphicon-list-alt" aria-hidden="true" ></span>
          <span class="hidden-sm hidden-xs">Article</span>
          <span class="label label-success pull-right hidden-sm hidden-xs">20</span> 
          </a>
          <ul class="collapse collapseble" id="collapse-post">
            <li><a href="new-article">Create new</a></li>
            <li><a href="new-article">new article</a></li>
            </ul>
        </li>
        <li class="link ">
         <a href="../cart.php">
          <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true" ></span>
          <span class="hidden-sm hidden-xs">Cart</span>
          </a>
        </li>
        <li class="link ">
         <a href="order.php">
          <span class="glyphicon glyphicon-pushpin" aria-hidden="true" ></span>
          <span class="hidden-sm hidden-xs">Orders</span>
          </a>
        </li>
         </li>
         <li class="link setting-btn">
         <a href="setting.html">
          <span class="glyphicon glyphicon-cog" aria-hidden="true" ></span>
          <span class="hidden-sm hidden-xs">setting</span>
          </a>
        </li>
        
       </ul>
        </div>
<!--main content area-->
<div class="col-md-10  display-table-cell valign-top ">
<div class="row">
  <header class="clearfix" id="nav-header">
   <div class="col-md-5">
     <nav class="navbar-default pull-left">
      <button type="button" class="navbar-toggle collapsed" data-toggle="offcanvas" data-target="#side-menu">
         <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
         </button>
       </nav>
     <input class="hidden-sm hidden-xs" type="text" placeholder="Search.." id="search"/>
     </div>
    <div class="col-md-7">
      <ul class="pull-right">
     <li class="hidden-xs">Welcome to your dashboard </li>
      <li class="fixed-with">
       <a href="#">
        <span class="glyphicon glyphicon-bell" aria-hidden="true"></span>
         <span class="label label-warning">3</span>
        </a>
       </li>
    <li class="fixed-with">
    <a href="#">
     <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
     <span class="label label-message">3</span>
      </a>
     <li>
    <a href="logout.php" class="log">
   <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
   log-Out</a>
   </li>
  </li>
 </ul>
</div>
 </header>
  </div>