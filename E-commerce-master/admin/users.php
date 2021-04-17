// retriving users from database
$userquery = $db->query("SELECT * FROM user ORDER BY full_name");<?php
require_once '../core/init.php';
if(!is_logged_in()){
	login_error_redirect();
	}
	if(!has_permission('admin')){
		permission_error_redirect('index.php');
	}
include'head.php';

if(isset($_GET['delete'])){
	$delete_id = sanitize($_GET['delete']);
	$db->query("DELETE FROM users WHERE id='$delete_id'");
	$_SESSION['success_flash'] = 'user has been successfuly deleted';
	header('Location: users.php');
}
if(isset($_GET['add'])){
	$name =  ((isset($_POST['name']))?sanitize($_POST['name']):'');
	$email =  ((isset($_POST['email']))?sanitize($_POST['email']):'');
	$password =  ((isset($_POST['password']))?sanitize($_POST['password']):'');
	$confirm =  ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
	$permission =  ((isset($_POST['permission']))?sanitize($_POST['permission']):'');
	$errors = array();
	if($_POST){
		$emailQuery = $db->query("SELECT * FROM users WHERE email='$email'");
		$emailCount = mysqli_num_rows($emailQuery);
		$required = array('name','email','password','confirm','permission');
		foreach($required as $f){
			if(empty($_POST[$f])){
				$errors[] = 'You must fill all the fileds';
				break;
			}
		}
		if(strlen($password)<6){
			$errors[] = 'Your password must be more than 6 characters';
		}
		if($password != $confirm){
			$errors[] ='Your password doesnt match';
		}
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$errors[] = 'Your must enter a valid email';
			}
			if($emailCount != 0){
				$errors[] = 'Your email already exist in our database';
			}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$hashed = password_hash($password,PASSWORD_DEFAULT);
			$db->query("INSERT INTO users (full_name,email,password,permission)values('$name','$email','$hashed','$permission')");
			$_SESSION['success_flash'] = 'your user has been successfully added';
			header('Location: users.php');
		}
	}
	?>	
<h4 class="text-center">Add New User</h4>
<form action="users.php?add=1" method="post">
<div class="form-group col-md-6">
<label for="Full_name">Full Name:</label>
<input type="text" name="name" class="form-control" id="full-name" value="<?=$name;?>" />
</div>
<div class="form-group col-md-6">
<label for="email">Email:</label>
<input type="email" name="email" class="form-control" id="email" value="<?=$email;?>" />
</div>
<div class="form-group col-md-6">
<label for="password">Password:</label>
<input type="password" name="password" class="form-control" id="password" value="<?=$password;?>" />
</div>
<div class="form-group col-md-6">
<label for="confirm_password">Confirm Password:</label>
<input type="password" name="confirm" class="form-control" id="confrim" value="<?=$confirm;?>" />
</div>
<div class="form-group col-md-6">
<label for="name">permissions:</label>
<select class="form-control" name="permission">
<option value=""<?=(($permission == '')?' selected':'');?>></option>
<option value="editor"<?=(($permission == 'editor')?' selected':'');?>>Editor</option>
<option value="admin,editor"<?=(($permission == 'admin,editor')?' selected':'');?>>Admin</option>
</select>
</div>
<div class="form-group col-md-6 text-right" style="margin-top:25px">
<a href="users.php" class="btn btn-default">cancle</a>
<input type="submit" class="btn btn-primary" value="Add user"  />
</div>
</form>
<?php	
}else{
$userQuery = $db->query("SELECT * FROM users ORDER BY full_name");
?>

<h2 class="text-center">user</h2>
<a href="users.php?add=1" class="btn btn-success pull-right">Add New User</a>
<hr />
<table class="table table-condensed table-bordered table-striped">
<thead>
<th></th><th>Name</th><th>Email</th><th>join_Date</th><th>Last login</th><th>permission</th></thead>
<tbody>
<?php while($user = mysqli_fetch_assoc($userQuery)):?>
<tr>
<td>
<?php if($user['id'] != $user_data['id']):?>
<a href="users.php?delete=<?=$user['id'];?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a>
<?php endif;?>
</td>
<td><?=$user['full_name'];?></td>
<td><?=$user['email'];?></td>
<td><?=pretty_date($user['join_date']);?></td>
<td><?=(($user['last_login'] == '0000-00-00 00:00:00')?'Never':pretty_date($user['last_login']));?></td>
<td><?=$user['permission'];?></td>
</tr>
<?php endwhile;?>
</tbody>
</table>
<?php }include'footer.php';?>