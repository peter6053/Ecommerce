<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecco/agric/core/init.php';
include 'head.php';


if(isset($_GET['restore'])){
	$id = sanitize($_GET['restore']);
	$db->query("UPDATE products SET deleted ='0' WHERE id ='$id'");
	header('Location: archieved.php');
	}
	$sql =$db->query("SELECT * FROM products WHERE deleted=1 ORDER BY title");

?>
<h4 >Archieved</h4>
<table class="table table-bordered table-condensed table-striped">
<thead>
<th></th>
<th>products</th>
<th>price</th>
<th>category</th>
<th>sold</th>
</thead>
<tbody>
<?php while($product = mysqli_fetch_assoc($sql)):
$child_id =$product['categories'];
$childQuery= $db->query("SELECT * FROM categoriez WHERE id ='$child_id'");
$child = mysqli_fetch_assoc($childQuery);
$parent_id = $child['parent'];
$pQuery= $db->query("SELECT * FROM categoriez WHERE id='$parent_id'");
$parent = mysqli_fetch_assoc($pQuery);


?>
<tr>
<th>
<a href="archieved.php?restore=<?=$product['id'];?>" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-refresh">
</span></a>
</th>
<td><?=$product['title'];?></td>
<td><?=money($product['price']);?></td>
<td><?=$parent['category'].'~'.$child['category'];?></td>
<td>0</td>
</tr>
<?php endwhile;?>
</tbody>

</table>
<?php  include 'footer.php'?>