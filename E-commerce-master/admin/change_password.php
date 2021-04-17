<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecco/agric/core/init.php';
if(!is_logged_in()){
	login_error_redirect();
	}
include 'includes/head.php';
$hashed = $user_data['password'];
$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password = trim($old_password);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$confirm  = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm = trim($confirm );
$errors = array();
$new_hashed = password_hash($password,PASSWORD_DEFAULT);
$user_id = $user_data['id'];
?>

<div id="login-form">
<div>
<?php

if($_POST){
if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])){
	$errors[] = 'your must enter email and password';
	}
	
	if(strlen($password)<6){
		$errors[] = 'the password must be more than 6 characters';
	}
	if($password != $confirm){
	$errors[] = 'The New password doesnt match the confirm password';
	}
	if(!password_verify($old_password,$hashed)){
		$errors[] = 'Your old password doesnt match our records';
	}
	if(!empty($errors)){
		echo display_errors($errors);
	}else{
	$db->query("UPDATE users SET password='$new_hashed' WHERE id='$user_id'");
	$_SESSION['success_flash']='Your password has successely been changed';
	header('Location: index.php');
	}	
	}
?>
</div>
<h2 class="text-center">Change password</h2><hr>
<form action="change_password.php" method="post">
<div class="form-group">
<label for="old password">Old password:</label>
<input type="password" id="old_password" name="old_password" class="form-control" value="<?=$old_password;?>"  />
</div>
<div class="form-group">
<label for="password">New Password:</label>
<input type="password" id="password" name="password" class="form-control" value="<?=$password;?>"  />
</div>
<div class="form-group">
<label for="confirm">confirm New password:</label>
<input type="password" id="confirm" name="confirm" class="form-control" value="<?=$confirm;?>"  />
</div>
<div class="form-group">
<a href="index.php" class="btn btn-default">cancel</a>
<input type="submit" value="login" class="btn btn-primary"  />
</div>
</form>
<p class="text-right"><a href="/ecco/agric/index.php">Visit site</a></p>
</div>

<?php  include 'includes/footer.php'?>