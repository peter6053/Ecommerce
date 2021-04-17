<?php
require_once'core/init.php';


// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("STRIPE_PRIVATE");

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];

//Get the rest of our data
$full_name = sanitize($_POST['full_name']);
$email = sanitize($_POST['Email']);
$Street1 = sanitize($_POST['Street']);
$Streer2 = sanitize($_POST['Street2']);
$city = sanitize($_POST['city']);
$county = sanitize($_POST['county']);
$zip_code = sanitize($_POST['zip_code']);
$country = sanitize($_POST['country']);
$tax = sanitize($_POST['tax']);
$sub_total = sanitize($_POST['sub_total']);
$grand_total = sanitize($_POST['grand_total']);
$cart_id = sanitize($_POST['cart_id']);
$description = sanitize($_POST['description']);
$charge_amount = number_format($grand_total,2)*100;
$metadata= array(
"cart_id" => $cart_id,
"tax"     => $tax,
"sub_total" => $sub_total,


);


// Create a charge: this will charge the user's card
try {
  $charge = \Stripe\Charge::create(array(
    "amount" =>$charge_amount, // Amount in cents
    "currency" => CURRENCY,
    "source" => $token,
    "description" => $description,
	"receipt_email" =>$email,
	"metadata" =>$metadata,
    ));
	//adjust inventory
	$itemQ = $db->query("SELECT * FROM carts WHERE id ='{$cart_id}'");
	$iresults = mysqli_fetch_assoc($itemQ);
	$items =json_decode($iresults,true);
	 foreach($items as $item){
		 $newsizes = array();
		 $item_id = $item['id'];
		 $productQ = $db->query("SELECT * FROM products WHERE id ='{$item_id}'");
		 $product = mysqli_fetch_assoc($product);
		 $sizes =sizesToArray($product['sizes']);
		  foreach($sizes as $size){
			  if($size['size'] = $item['size']){
				  $q = $size['quantity']- $item['quantity'];
				  $newsizes[] = array('size'=>$size['size'],'quantity'=>$q);
				  
				  }else{
					$newsizes[] = array('size'=>$size['size'],'quantity'=>$size['quantity']);  
					  }
			  }
		 $sizestring = sizeToString($newsizes);
		 $db->query("UPDATE products SET sizes='{$sizestring}' WHERE id ='{$item_id}'");
		 }
	
	
	
	
	
	//update cart
	$db->query("UPDATE carts SET paid=1 WHERE id ='{$cart_id}'");
	$db->query("INSERT INTO transactions (charge_id,cart_id,full_name,email,street,street2,city,county,zip_code,country,sub_total,tax,grand_total,description,txn_type)
	VALUES('$charge->id','$cart_id','$full_name','$email','$Street1','$Streer2','$city','$county','$zip_code','$country','$sub_total','$tax','$grand_total','$description','$charge->object')");
	$domain =($_SERVER['HTTP_HOST'] != 'localhost')?$_SERVER['HTTP_HOST']:false;
	setcookie(CART_COOKIE,'',1,"/",$domain,false);
 include 'includes/head.php';
 include 'includes/navigation.php';
 ?>
 <h1 class="text-center text-success">Thank you</h1>
 <p> Your cart has been successfully charged <?=money($grand_total);?>.Your have been emailed a receipt.check your email if not please check your spam indox.You can also print this screen as your receipt</p>
 <p>Your receip number is <strong><?=$cart_id?></strong></p>
 <p>Ypur order will be shipped in the address below</p>
 <address>
 <?=$full_name;?><br />
 <?=$Street1;?><br />
 <?=(($Streer2 !='')?$Streer2.'<br>':'')?>
 <?=$city.','.$county.' '.$zip_code;?><br />
 <?=$country;?><br />
 
 </address>
 <?php
 include 'includes/footer.php';	
} catch(\Stripe\Error\Card $e) {
  // The card has been declined
  echo $e;
}


?>