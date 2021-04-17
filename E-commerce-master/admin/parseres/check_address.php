<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ecco/agric/core/init.php';
$name = sanitize($_POST['full_name']);
$email = sanitize($_POST['email']);
$street = sanitize($_POST['street']);
$street2 = sanitize($_POST['street2']);
$city = sanitize($_POST['city']);
$country = sanitize($_POST['country']);
$zip_code = sanitize($_POST['zip_code']);
$county = sanitize($_POST['county']);
$errors = array();
$required = array(
  'full_name' => 'Full_name',
   'email' =>'Email',
    'street' => 'Street',
	 'city' =>'City',
      'zip_code' => 'Zip_code',
	   'county' => 'County',
	     'country' => 'Country',
 
);
//check if all redquired filled are filled up
 foreach($required as $f=>$d){
if(empty($_POST[$f]) || $_POST[$f]==''){
	$errors[] = $d. ' is required.';
	
	}
 }
 //check if valid email
 if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
  $errors[] = 'please enter a valide email.';
 }
 if(!empty($errors)){
 echo display_errors($errors); 
 }else{
	 echo'passed';
	 }
?>