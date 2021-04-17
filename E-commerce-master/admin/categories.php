<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecco/agric/core/init.php';
include 'head.php';

$sql = "SELECT * FROM categoriez WHERE parent=0";
$result = $db->query($sql);
$errors = array();
//Delete category
if(isset($_GET['delete']) && !empty($_GET['delete'])){
	$delete_id = (int)$_GET['delete'];
	$delete_id = sanitize($delete_id);
	$sql = "SELECT * FROM categoriez WHERE id='$delete_id'";
	$result=$db->query($sql);
	$category = mysqli_fetch_assoc($result);
	if($category['parent']==0){
		$sql ="DELETE FROM categoriez  WHERE parent ='$delete_id'";
		$db->query($sql);
		}
	
	$dsql = "DELETE FROM categoriez WHERE id='$delete_id'";
	$db->query($dsql);
	header('Location: categories.php');
	
	}
//process form
if(isset($_POST) && !empty($_POST)){
$parent = sanitize($_POST['parent']);
$category = sanitize($_POST['category']);
$sqlform ="SELECT * FROM categoriez WHERE category ='$category' AND parent='$parent'";
$fresults =$db->query($sqlform);
$count = mysqli_num_rows($fresults);
//if is balnk
if($category==''){
	$errors[].='The category can not be left blank';
	}
//if database exist
if($count>0){
	$errors[].=  $category.'already exist choose another category';
}
//Display errors or update
if(!empty($errors)){
	//display errors
	$display = display_errors($errors); ?>
    <script>
    jQuery('document').ready(function() {
        jQuery('#errors').html('<?=$display;?>');
    });
    
    </script>
    <?php }else{
	$sqlupdate ="INSERT INTO categoriez (category,parent) VALUES ('$category','$parent')";
	$db->query($sqlupdate);
	header('Location: categories.php');
}
}
?>
<h2 class="text-center">Categories</h2>
<div class="row">
<div class="col-md-6">
<legend>Add category</legend>
<div id="errors"></div>
<form class="form" action="categories.php" method="post">
<div class="form-group">
<label for="parent">parent</label>
<select class="form-control" name="parent" id="parent">
<option value="0">parent</option>
<?php while($parent = mysqli_fetch_assoc($result)):?>
<option value="<?=$parent['id'];?>"><?=$parent['category'];?></option>
<?php endwhile?>
</select> 
</div>
<div class="form-group">
<label for="category">category</label>
<input type="text" class="form-control" name="category" id="category">
</div>
<div class="form-conrol">
<input type="submit" value="Add Category" class="btn btn-success">
</div>
</form>

</div>
<div class="col-md-6">
<table class="table table-bordered table-condensed ">
<thead>
<th>Category</th><th>Parent</th><th></th>
</thead>
<tbody>
<?php
$sql = "SELECT * FROM categoriez WHERE parent=0";
$result = $db->query($sql);
 while($parent = mysqli_fetch_assoc($result)):
$parent_id=(int)$parent['id'];
$sql2 = "SELECT * FROM categoriez WHERE parent='$parent_id'";
$cresults = $db->query($sql2);
 ?>
<tr class="bg-info">
<td><?=$parent['category'];?></td>
<td>parent</td>
<td>
<a href="categories.php?edit=<?=$parent['id'];?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span></a>
<a href="categories.php?delete=<?=$parent['id'];?>" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-remove-sign"></span></a>
</td>
</tr>

<?php while($child = mysqli_fetch_assoc($cresults)):?>
<tr class="bg-default">
<td><?=$child['category'];?></td>
<td><?=$parent['category'];?></td>
<td>
<a href="categories.php?edit=<?=$child['id'];?>" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>
<a href="categories.php?delete=<?=$child['id'];?>" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove-sign"></span></a>
</td>
</tr>


<?php endwhile;?>
<?php endwhile;?>
</tbody>
</table>
</div>
</div>
<?php include 'footer.php'?>