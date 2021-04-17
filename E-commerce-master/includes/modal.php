 <?php

require_once'../core/init.php';
$id = $_POST['id'];
 $id =(int)$id;
 $sql = "SELECT * FROM products WHERE id='$id'";
 $result = $db->query($sql);
 $product= mysqli_fetch_assoc($result);
 $brand_id =$product['brand'];
 $lsql = "SELECT brand FROM brand WHERE id='$brand_id'";
 $brand_query = $db->query($lsql);
 $brand = mysqli_fetch_assoc($brand_query);
 $sizeString =$product['sizes'];
 $sizeString  = rtrim($sizeString,',' );
 $size_array = explode(',',$sizeString);
 ?>
 
 
 
  <!-- Modal -->
  <?php ob_start();?>
 
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header">
          <button type="button" class="close" onclick="closeModal()" aria-hidden="true" id="id">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><?=$product['title'];?></h4>
          </div>
          <div class="modal-body">
           <div class="container-fluid">
           <div class="row">
           <span id="modal_errors" class="bg-danger"></span>
           <div class="col-sm-6">
           <div class="center-block"> 
           <img alt="<?=$product['title'];?>" src="<?=$product['image'];?>" width="260" height="180">
           </div>
           </div>
           <div class="col-sm-6">
           <h4>Details</h4>
           <h5><?=$product['description'];?></h5>
           <hr>
           <h5>Brand:<?=$brand['brand'];?></h5>
           <h6>price:ksh <?=$product['price'];?></h6>
           <form action="add_cart.php"  method="post" id="add_product_form">
           <input type="hidden" name="product_id" value="<?=$id;?>">
           <input type="hidden" name="available" id="available" value="">
           <div class="form-group">
           <div class="col-xs-3">
           <label for="quantity">Quantinty</label></div> 
          <input type="number" class="form-control" id="quantity" name="quantity"></div><br /><div class="col-xs-9">&nbsp;</div>
          
          <div class="form-group">
          <label for="size">size:</label>
          <select name="size" id="size" class="form-control">
          <option value=""></option>
          <?php foreach($size_array as $string){
			  $string_array = explode(':',$string);
			  $size = $string_array[0];
			  $available = $string_array[1];
			  if($available>0){
			  echo'<option value="'.$size.'"data-available="'.$available.'">'.$size.'('.$available.' Available)</option>';
		  }}?>
		  </select>
       </div>
      </form>
     </div>
    </div>
   </div>
  </div> 
 <div class="modal-footer">
<button type="button" class="btn btn-danger" onclick="closeModal()">Close</button>
 <button type="button" class="btn btn-warning" onclick="add_to_cart();return false;"><span class="glyphicon glyphicon-shopping-cart">Add to cart</span></button>
 </div>
 </div>
 </div><!-- /.modal-content -->
</div><!-- /.modal -->
<script>

	jQuery('#size').change(function(){
		var available = jQuery('#size option:selected').data("available");
		jQuery('#available').val(available);
		});
function closeModal(){
jQuery('#modal').modal('hide');
setTimeout(function(){
	jQuery('#modal').remove();
	jQuery('.modal-backdrop').remove();
	},500);	
}
</script>
   <?php echo ob_get_clean();?>                   