<?php
include 'core/init.php';
include 'includes/menu.php';
include 'includes/head.php';

if($cart_id !=''){
$cartQ = $db->query("SELECT * FROM carts WHERE id='{$cart_id}'");
$result =mysqli_fetch_assoc($cartQ);
$items = json_decode($result['items'],true);
$i =1;
$sub_total = 0;
$item_count = 0;
}

?>
<div class="col-md-12">
<div class="row">
<h2 class="text-center">My shooping cart</h2><hr>
  <?php if($cart_id ==''):?>
  <div class="bg-danger">
   <p class="text-center text-danger">Your cart is empty!</p>
   </div>
   <?php else:?>
   <table class="table table-bordered table-condensed table-striped">
   <thead class="bg-success" >
   <th><span class="glyphicon glyphicon-th "></span></th><th>item</th><th>price</th><th>quantity</th><th>size</th><th>subtotal</th>
   </thead>
   <tbody>
   <?php
   foreach($items as $item){
   $product_id = $item['id'];
   $productQ = $db->query("SELECT * FROM products WHERE id ='{$product_id}' ");
   $product = mysqli_fetch_assoc($productQ);
   $sArray = explode(',',$product['sizes']);
    foreach($sArray as $sizeString){
		$s = explode(':',$sizeString);
		 if($s[0] == $item['size']){
			 $available = $s[1];
			 }
		 }
		 ?>
         
       <tr >  
       <td><?=$i;?></td>
       <td><?=$product['title'];?></td>
       <td><?=money($product['price']);?></td>
       <td>
<button class="btn btn-success btn-xs" onClick="update_cart('removeone','<?=$product['id'];?>','<?=$item['size'];?>');">-</button>
	   <?=$item['quantity'];?>
       <?php if($item['quantity'] < $available):?>
    <button class="btn btn-success btn-xs" onClick="update_cart('addone','<?=$product['id'];?>','<?=$item['size'];?>');">+</button>
       <?php else:?>
       <span class="text-danger">max</span>
       <?php endif;?>
       </td>
       <td><?=$item['size'];?></td>
       <td class="bg-warning"><?=money($item['quantity'] * $product['price']);?></td>  
       </tr>
	    <?php 
		$i++;
		$item_count += $item['quantity'];
		$sub_total +=($product['price'] * $item['quantity']);
		          }
		$tax = TAXRATE * $sub_total;
		$tax = number_format($tax);
		$grand_total = $tax + $sub_total;
		?>
  
   </tbody>
   </table>
  <table class="table table-bordered table-condensed table-striped text-right">
  <thead class="totals-table bg-info">
  <th>Total items</th>
  <th>subtotal</th>
  <th>tax</th>
  <th>grandtotal</th>
  </thead>
  <tbody>
  <tr>
  <td><?=$item_count;?></td>
  <td><?=money($sub_total);?></td>
  <td><?=money($tax);?></td>
  <td class="bg-success"><?=money($grand_total);?></td>
  </tr>
  </tbody>
  </table> 
<!-- Button check out -->
<button class="btn btn-primary pull-right" data-toggle="modal" data-target="#checkoutModal">
 <span class="glyphicon glyphicon-shopping-cart"></span> checkout>>
</button>
<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                  
                <h4 class="modal-title" id="checkoutModalLabel">Shipping Address </h4>
                  </div>
                   <div class="modal-body">
                   <div class="row">
                   <form action="thankYour.php" method="post" id="payment-form">
                   <span class="bg-danger" id="payment-errors"></span>
                   <input type="hidden" name="tax" value="<?=$tax?>"  />
                   <input type="hidden" name="sub_total" value="<?=$sub_total?>"  />
                   <input type="hidden" name="grand_total" value="<?=$grand_total?>"  />
                   <input type="hidden" name="cart_id" value="<?=$cart_id?>"  />
            <input type="hidden" name="description" value="<?=$item_count.'item'.(($item_count>1)?'s':'').'from smart store.';?>"  />
                  
                   <div id="step1" style="display:block">
                     <div class="form-group col-md-6">
                       <label for="full_name">Full name:</label>
                       <input class="form-control" id="full_name" name="full_name" type="text" /> 
                      </div>
                      <div class="form-group col-md-6">
                       <label for="Email">Email:</label>
                       <input class="form-control" id="Email" name="Email" type="Email" />
                      </div>
                      <div class="form-group col-md-6">
                       <label for="Street">Street Adress:</label>
                       <input class="form-control" id="Street" name="Street" type="text" data-stripe="address_line1" />
                      </div>
                      <div class="form-group col-md-6">
                       <label for="Street2">Streer Adress2:</label>
                       <input class="form-control" id="Street2" name="Street2" type="text" data-stripe="address_line2" />
                      </div>
                      <div class="form-group col-md-6">
                       <label for="city">City:</label>
                       <input class="form-control" id="city" name="city" type="text" data-stripe="address_city" />
                      </div>
                      <div class="form-group col-md-6">
                       <label for="county">county:</label>
                       <input class="form-control" id="county" name="county" type="text" data-stripe="address_state" />
                      </div>
                      <div class="form-group col-md-6">
                       <label for="zip_code">Zip code:</label>
                       <input class="form-control" id="zip_code" name="zip_code" type="text" data-stripe="address_zip" />
                      </div>
                      <div class="form-group col-md-6">
                       <label for="county">Country:</label>
                       <input class="form-control" id="country" name="country" type="text" data-stripe="country" />
                      </div>
                   </div>
                   <div id="step2" style="display:none">
                     <div class="form-group col-md-3">
                      <label for="name">Card Name:</label>
                      <input type="text" id="name" class="form-control" data-stripe="name" />
                     </div>
                     <div class="form-group col-md-3">
                      <label for="number">Card Number:</label>
                      <input type="text" id="number" class="form-control" data-stripe="number" />
                     </div>
                     <div class="form-group col-md-2">
                      <label for="cvc">Cvc:</label>
                      <input type="text" id="name" class="form-control" data-stripe="cvc"  />
                     </div>
                     <div class="form-group col-md-2">
                      <label for="name">Expire date:</label>
                          <select id="exp-month" class="form-control" data-stripe="exp_month">
                          <option value=""></option>
                            <?php for($i=1;$i<13;$i++):?>
                            <option value="<?=$i;?>"><?=$i;?></option>
                            <?php endfor;?>
                          </select>
                     </div>
                     <div class="form-group col-md-2">
                      <label for="exp-year">Expire Year:</label>
                      <select id="exp-year" class="form-control" data-stripe="exp_year">
                        <option value=""></option>
                         <?php $yr = date("Y");?>
                         <?php for($i=0;$i<11;$i++):?>
                         <option value="<?=$yr+$i;?>"><?=$yr+$i;?></option>
                         <?php endfor;?>
                      </select>
                     </div></div></div>
                                    <div class="modal-footer">
     <button type="button" class="btn btn-default"data-dismiss="modal">Close </button> 
    <button type="button" class="btn btn-primary" id="Next_button" onclick="check_address();">Next>></button>
     <button type="button" class="btn btn-warning" id="Back_button" onclick="back_address();" style="display:none">Back</button>
    <button type="submit" class="btn btn-success" id="check_out_button" style="display:none" >Check Out >></button></form>
                </div>
              </div><!-- /.modal-content -->
           </div><!-- /.modal -->
                   
  
   <?php endif;?>
</div>
</div>

<?php include'includes/footer.php';?>
<script>
 function back_address(){
	 jQuery('#payment-errors').html("");
	 jQuery('#step1').css("display","block");
						jQuery('#step2').css("display","none");
						jQuery('#Next_button').css("display","inline-block");
						jQuery('#Back_button').css("display","none");
						jQuery('#check_out_button').css("display","none");
						jQuery('#checkoutModalLabel').html('Shipping address');
	 }
 function check_address(){
	 var data ={
		 'full_name' : jQuery('#full_name').val(),
		  'email' : jQuery('#Email').val(),
		  'street' : jQuery('#Street').val(),
		  'street2' : jQuery('#Street2').val(),
		  'city' : jQuery('#city').val(),
		  'county': jQuery('#county').val(),
		  'zip_code' : jQuery('#zip_code').val(),
		  'country' : jQuery('#country').val()
	     };
		 jQuery.ajax({
			 url:"/ecco/agric/admin/parseres/check_address.php",
			 method:'post',
			 data:data,
			 success: function(data){
				 if(data!= 'passed'){
					 jQuery('#payment-errors').html(data);
					 }
					 if(data== 'passed'){
						jQuery('#payment-errors').html("");
						jQuery('#step1').css("display","none");
						jQuery('#step2').css("display","block");
						jQuery('#Next_button').css("display","none");
						jQuery('#Back_button').css("display","inline-block");
						jQuery('#check_out_button').css("display","inline-block");
						jQuery('#checkoutModalLabel').html('Enter yor cart details');
						 }
				 },
			 error :function(){alert("somethig went wrong");}
		 });
	 }
	 
	  Stripe.setPublishableKey('<?=STRIPE_PUBLIC;?>');
function stripeResponseHandler(status, response) {
          // Grab the form:
            var $form = $('#payment-form');

                if (response.error) { // Problem!

                     // Show the errors on the form:
                 $form.find('.payment-errors').text(response.error.message);
                  $form.find('.submit').prop('disabled', false); // Re-enable submission

                  } else { // Token was created!

                     // Get the token ID:
                    var token = response.id;

                      // Insert the token ID into the form so it gets submitted to the server:
                    $form.append($('<input type="hidden" name="stripeToken">').val(token));

                   // Submit the form:
                     $form.get(0).submit();
                      }
                      };
	  
	 jQuery(function() {
  var $form = $('#payment-form');
  $form.submit(function(event) {
    // Disable the submit button to prevent repeated clicks:
    $form.find('.submit').prop('disabled', true);

    // Request a token from Stripe:
    Stripe.card.createToken($form, stripeResponseHandler);

    // Prevent the form from being submitted:
    return false;
  });
});
    
</script>                 
                   
                   
                   
     
