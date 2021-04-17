<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecco/agric/core/init.php';
include 'includes/head.php';

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$errors = array();
?>
<style>
body{
	background-image:url("/ecco/agric/img/stock-photo-whole-and-sliced-apples-with-leaves-on-white-background-306475175.jpg");
	background-size:100vw 100vh;
	background-attachment:fixed;
	
	}
</style>
<div id="login-form">
<div>
<?php

if($_POST){
if(empty($_POST['email']) || empty($_POST['password'])){
	$errors[] = 'your must enter email and password';
	}//validate email
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
	$errors[] = 'you must enter a valide email';	
	}
	if(strlen($password)<6){
		$errors[] = 'the password must be more than 6 characters';
	}
	$query=$db->query("SELECT * FROM users WHERE email='$email'");
	$user = mysqli_fetch_assoc($query);
	$usercount = mysqli_num_rows($query);
	if($usercount<1){
		$errors[] = "The users doesnt exist in our database";
	}
	if(!password_verify($password,$user['password'])){
		$errors[] = ' The password doesn\'t match';
	}
	if(!empty($errors)){
		echo display_errors($errors);
	}else{
	
	$user_id = $user['id'];
	login($user_id);
	}	
	}
?>
</div>
<h2 class="text-center">login form</h2><hr>

<form action="login.php" method="post" >
<div class="form-group">
<label for="email">Email:</label>
<input type="email" id="email" name="email" class="form-control" value="<?=$email;?>"  />
</div>
<div class="form-group">
<label for="password">Password:</label>
<input type="password" id="password" name="password" class="form-control" value="<?=$password;?>"  />
</div>
<div class="form-group">
<input type="submit" value="login" class="btn btn-primary"  />
</div>
</form>
<p class="text-right"><a href="/ecco/agric/index.php">Visit site</a></p>
</div>

<?php  include 'includes/footer.php'?>