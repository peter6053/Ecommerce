 <?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecco/agric/core/init.php';
if(!is_logged_in()){
	login_error_redirect();
	}
include 'head.php';

if(isset($_GET['delete'])){
	$id = (int)$_GET['delete'];
	$db->query("UPDATE products SET deleted= 1 WHERE id ='$id'");
	header('Location : products.php');	
	
	}
$dbpath = '';
if(isset($_GET['add']) || isset($_GET['edit'])){	
	$brandQuery=$db->query("SELECT * FROM brand ORDER BY brand");
	$parentQuery=$db->query("SELECT * FROM categoriez WHERE parent = 0 ORDER BY category");
	$title =((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
	$brand = ((isset($_POST['brand'])&& !empty($_POST['brand']))?sanitize($_POST['brand']):'');
	$parent = ((isset($_POST['parent'])&& !empty($_POST['parent']))?sanitize($_POST['parent']):'');
	$category = ((isset($_POST['child'])&& !empty($_POST['child']))?sanitize($_POST['child']):'');
	$price = ((isset($_POST['price'])&& !empty($_POST['price']))?sanitize($_POST['price']):'');
	$list_price = ((isset($_POST['list_price'])&& !empty($_POST['list_price']))?sanitize($_POST['list_price']):'');
	$description = ((isset($_POST['description'])&& !empty($_POST['description']))?sanitize($_POST['description']):'');
	$sizes =((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):'');
    $sizes=rtrim($sizes,',');
	$saved_image ='';
		if(isset($_GET['edit'])){
		$edit_id = (int)$_GET['edit'];
		$productResults = $db->query("SELECT * FROM products WHERE id='$edit_id'");
		$product = mysqli_fetch_assoc($productResults);
		
		if(isset($_GET['delete_image'])){
			$image_url = $_SERVER['DOCUMENT_ROOT'].$product['image'];
			unset($image_url);
			$db->query("UPDATE products SET image='' WHERE id='$edit_id'");
			header('Location: products.php?edit='.$edit_id);
			}
		$category = ((isset($_POST['child']) && $_POST['child'] !='')?sanitize($_POST['child']):$product['categories']);
		$title =((isset($_POST['title']) && $_POST['title'] !='')?sanitize($_POST['title']):$product['title']);
		$brand =((isset($_POST['brand']) && $_POST['brand'] !='')?sanitize($_POST['brand']):$product['brand']);
		$parentQueryy= $db->query("SELECT * FROM categoriez WHERE id='$category'");
		$parentResult = mysqli_fetch_assoc($parentQueryy);
		$parent  =((isset($_POST['parent']) && $_POST['parent'] !='')?sanitize($_POST['parent']):$parentResult['parent']);
		$price =((isset($_POST['price']) && $_POST['price'] !='')?sanitize($_POST['price']):$product['price']);
		$list_price =((isset($_POST['list_price']))?sanitize($_POST['list_price']): $product['list_price']);
		$description =((isset($_POST['description']))?sanitize($_POST['description']):$product['description']);
	$sizes =((isset($_POST['sizes']) && $_POST['sizes'] !='')?sanitize($_POST['sizes']):$product['sizes']);
	$sizes=rtrim($sizes,',');	
	$saved_image =(($product['image'] !='')?$product['image']:'');
	$dbpath = $saved_image;
		}
if(!empty($sizes)){
	$sizeString = sanitize($sizes);
	$sizeString =rtrim($sizeString,',');
	$sizeArray = explode(',',$sizeString);
	$sArray=array();
	$qArray=array();
	$tArray=array();
	foreach($sizeArray as $ss){
	$s = explode(':',$ss);
	$sArray[] = $s[0];
	$qArray[] = $s[1];
	$tArray[] = $s[2];		
	}
	
	}else{ $sizeArray = array();}			
if($_POST){
	$errors=array();
		
	$required = array('title','price','brand','parent','child','sizes');
	 foreach($required  as $field){
		 if($_POST[$field] == ''){
			 $errors[]= 'All field with astriks are required';
			 break;
			 }
			  }
			 if($_FILES['photo']['name'] !=''){ 
				$photo = $_FILES['photo'];
				$name = $photo['name'];
				$nameArray = explode('.',$name);
				$filename = $nameArray[0];
				$fileExt = $nameArray[1];
				$mime = explode('/',$photo['type']);
				$mimeType = $mime[0];
				$mimeExt = $mime[1];
				$tmpLoc = $photo['tmp_name'];
				$fileSize = $photo['size'];
				$allowed = array('png','jpg','gif','jpeg');
				$uploadname = md5(microtime()).'.'.$fileExt;
				$uploadpath =BASEURL.'/agric/img/'.$uploadname;
                $dbpath = '/ecco/agric/img/'.$uploadname;
				if($mimeType != 'image'){
				$errors[] ='Choose a file image type';
				}
				if(!in_array($fileExt,$allowed)){
					$errors[] ='Only  files with png/jpg/jpeg/gif are allowed';
				}
				if($fileSize> 10000000){
					$errors[] ='File size is too large';
				}
				if($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg' )){
				 $errors[] ='The file extension doesnt match the file type';
				}
			 }
			 
		
		 if(!empty($errors)){
			 echo display_errors($errors);}else{
				 if(!empty($_FILES)){
			move_uploaded_file($tmpLoc,$uploadpath);
				 }
$insertSql="INSERT INTO products (`title`,`price`,`list_price`,`brand`,`categories` ,`description`, `sizes`, `image`)
			 VALUES('$title','$price','$list_price','$brand','$category','$description','$sizes','$dbpath')";
if(isset($_GET['$edit'])){
$insertSql ="UPDATE products SET title='$title',price ='$price',list_price ='$list_price',brand ='$brand',categories ='$category',description ='$description',
 sizes ='$sizes',image ='$dbpath' WHERE id='$edit_id'";
				 
				 }
				$db->query($insertSql);
				
				 header('Location: products.php');
		}
	}
?>
<h2 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add a New')?> product</h2>
<form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1')?>" method="POST" enctype="multipart/form-data" >
<div class="form-group col-md-3">
<label for="title">Title*</label>
<input type="text" name="title" class="form-control" id="title"  
value="<?=$title;?>"
 /> </div>
<div class="form-group col-md-3"><label for="brand">Brand*:</label>
<select class="form-control" id="brand" name="brand">
<option value="<?=(($brand == '')?' selected':'');?>"></option>
<?php while($b = mysqli_fetch_assoc($brandQuery)):?>
 <option value="<?=$b['id']?>"<?=(($brand ==$b['id'])?' selected':'')?>><?=$b['brand'];?></option>
<?php endwhile;?>
</select>
</div>
<div class="form-group col-md-3">
<label for="parent">parent category*:</label>
<select class="form-control" id="parent" name="parent">
<option value=""<?=(($parent=='')?' selected':'')?>></option>
<?php while($p=mysqli_fetch_assoc($parentQuery)):?>
<option value="<?=$p['id'];?>"<?=(($parent==$p['id'])?' selected':'')?>>
<?=$p['category'];?></option>
<?php endwhile;?>
</select>
</div>
<div class="form-group col-md-3">
<label for="child">child category*:</label>
<select id="child" name="child" class="form-control">
</select>
</div>
<div class="form-group col-md-3">
<label for="price">price*:</label>
<input type="text" id="price" name="price" class="form-control" value="<?=$price;?>" />
</div>
<div class="form-group col-md-3">
<label for="list_price">list_price*:</label>
<input type="text" id="list_price" name="list_price" class="form-control" value="<?=$list_price;?>" />
</div>
<div class="form-group col-md-3">
<label>Quantity & sizes</label>
<button type="button" class="btn btn-default form-control"  onclick="jQuery('#sizeModal').modal('toggle');return false; ">Quantity & sizes</button>


</div>
<div class="form-group col-md-3">
<label>sizes & QLT preview</label>
<input type="" id="sizes" name="sizes" class="form-control" value="<?=$sizes;?>" readonly="readonly" />
</div>
<div class="form-group col-md-6">
<?php if($saved_image!=''):?>
<div class="saved_image"><img src="<?=$saved_image?>" alt="saved image"  /><br />
<a href="products.php?delete_image=1&edit=<?=$edit_id?>" class="text-danger">Delete image</a>
</div>
<?php else:?>
<label for="photo">product photo</label>
<input type="file" id="photo" name="photo" class="form-control" />
<?php endif;?>
</div>
<div class="form-group col-md-6">
<label for="descriptions">description</label>
<textarea id="description" name="description" class="form-control" rows="6">
<?=$description;?></textarea>
</div>
<div class="form-group pull-right">
<a href="products.php" class="btn btn-default">cancel</a>
<input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add')?> product" class=" btn btn-success " />
</div><div class="clearfix"></div>
</form>
<div class="modal fade" id="sizeModal" tabindex="-1" role="dialog"  aria-labelledby="sizesModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="sizesModalLabel"> This Modal title</h4> </div>
          <div class="modal-body">
          <div class="container-fluid" >
          <?php for($i=1;$i<=12;$i++):?>
          <div class="form-group col-md-2">
          <label for="size<?=$i;?>">size</label>
          <input type="text" name="size<?=$i;?>" id="size<?=$i?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$s-1]:'');?>"  class="form-control" />
          </div>
          <div class="form-group col-md-2">
          <label for="qty<?=$i;?>">Quantity</label>
          <input type="number" name="qty<?=$i;?>" id="qty<?=$i?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$s-1]:'');?>" min="0"  class="form-control"/>
          </div>
          <div class="form-group col-md-2">
          <label for="threshold<?=$i;?>">Threshold</label>
          <input type="number" name="threshold<?=$i;?>" id="threshold<?=$i?>" value="<?=((!empty($tArray[$i-1]))?$tArray[$s-1]:'');?>" min="0"  class="form-control"/>
          </div>
          <?php endfor;?>
           </div></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close  </button>
<button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizeModal').modal('togggle');return false;">save changes </button>
                   </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->
    </div>          
<?php }else{
$sql = "SELECT * FROM products WHERE  deleted=0";
$presults = $db->query($sql);
if(isset($_GET['feature'])){
	$id = (int)$_GET['id'];
	$feature = (int)$_GET['feature'];
	$featuresql = "UPDATE products SET feature ='$feature' WHERE id ='$id'";
	$db->query($featuresql);
	header('Location: products.php');
	}
?>
<h3 >Products</h3>
<a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add product</a><div class="clear-fix" style="margin-top:-235px"></div>
<table class="table table-bordered table-condensed table-striped">
<thead>
<th></th>
<th>products</th>
<th>price</th>
<th>category</th>
<th>featured</th>
<th>sold</th>
</thead>
<tbody>
<?php while($product = mysqli_fetch_assoc($presults)):
$childID =$product['categories'];
$catsql = "SELECT * FROM categoriez WHERE id='$childID'";
$results= $db->query($catsql);
$child = mysqli_fetch_assoc($results);
$parentID=$child['parent'];
$psql="SELECT * FROM categoriez WHERE id='$parentID'";
$fresults=$db->query($psql);
$parent = mysqli_fetch_assoc($fresults);
$category = $parent['category'].'~'.$child['category'];
?>
<tr>
<td>
<a href="products.php?edit=<?=$product['id'];?>" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil">
</span></a>
<a href="products.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-remove-sign"></span></a>
</td>
<td><?=$product['title'];?></td>
<td><?=money($product['price']);?></td>
<td><?=$category;?></td>
<td>
<a href="products.php?feature=<?=(($product['feature']==0)?'1':'0');?>&id=<?=$product['id'];?>" 
class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-<?=(($product['feature']==1)?'minus':'plus');?>"></span></a>
&nbsp<?=(($product['feature']== 1)?'featured product':'');?>
</td>
<td>0</td>
</tr>
<?php endwhile;?>
</tbody>
</table>
<div class="clearfix"></div>
  
<?php } include 'footer.php'?>
<script>
jQuery('document').ready(function(){
    get_child_options('<?=$category;?>');
	
});
</script>