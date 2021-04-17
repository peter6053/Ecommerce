<?php
define('BASEURL',$_SERVER['DOCUMENT_ROOT'].'/ecco/');
define ('CART_COOKIE','SBwzTXc45gHY6ASj');
define('CART_COOKIE_EXPIRE',time()+(86400 * 30));
define('TAXRATE',0.087);//SALES tax rate set to zero if not chaging tax

define('CURRENCY','Ksh');
define('CHECKOUTMODE','TEST');//chage test to live


if(CHECKOUTMODE == 'TEST'){
	define('STRIPE_PRIVATE','#');
	define('STRIPE_PUBLIC','#');
	
	}
if(CHECKOUTMODE == 'LIVE'){
	define('STRIPE_PRIVATE','#');
	define('STRIPE_PUBLIC','#');
	
	}



?>