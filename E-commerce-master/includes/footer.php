 <footer>
        <div class="container">
            <div class="row">
                <article class="col-lg-6 col-md-6 col-sm-6 followBox pull-right">
                    <div class="clearfix pull-right">
                        <p class="pull-left">Follow us:</p>
                        <ul class="account_desc">
    <li><a href="http://livedemo00.template-help.com/wt_47305/#"><img src="img/Designbolts-Ios8-Style-Social-Facebook.ico" alt="" width="50" height="50"></a></li>
      <li><a href="http://livedemo00.template-help.com/wt_47305/#"><img src="img/Designbolts-Ios8-Style-Social-Google-Plus.ico" alt="" widt="50" height="50"></a></li>
   <li><a href="http://livedemo00.template-help.com/wt_47305/#"><img src="img/Designbolts-Ios8-Style-Social-Email.ico" alt="" height="50" widt="50"></a></li>
     <li><a href="http://livedemo00.template-help.com/wt_47305/#"><img src="img/Designbolts-Ios8-Style-Social-Plaxo.ico" alt="" height="50" width="50"></a></li>
                        </ul>
                    </div>
                </article>
                <article class="col-lg-6 col-md-6 col-sm-6">
                    <h1 class="navbar-brand navbar-brand_">
<a href="http://livedemo00.template-help.com/wt_47305/index.html"><img src="img/logo.png" alt="" width="150" height="60"></a></h1>
                    <ul class="account_desc">
                        <li class="active"><a href="http://livedemo00.template-help.com/wt_47305/index.html">Home</a></li>
                        <li><a href="http://livedemo00.template-help.com/wt_47305/index-1.html">About us</a></li>
                        <li><a href="http://livedemo00.template-help.com/wt_47305/index-2.html">Products</a></li>
                        <li><a href="http://livedemo00.template-help.com/wt_47305/index-3.html">Clients</a></li>
                        <li><a href="http://livedemo00.template-help.com/wt_47305/index-4.html">Contacts</a></li>
                    </ul>
                    <br>
                    <p class="privacy">© 2013 <span>|</span> <a href="http://livedemo00.template-help.com/wt_47305/index-5.html">Privacy Policy</a></p>
                </article>
                <!-- {%FOOTER_LINK} -->
            </div>
<script src="controller.js"></script>
<script src="jquery-ui-1.10.4/jquery-1.10.2.js" ></script>
<script src="bootstrap-3.3.6-dist/js/bootstrap.js"></script>
<script src="main.js"></script>
<script>
function modal(id){
	var data = {"id" : id};
	jQuery.ajax({
		url:'/ecco/agric/includes/modal.php',		
		method:"post",
		data:data,
		success: function(data){
			jQuery('body').append(data);
			jQuery('#modal').modal('toggle'); 
			},
		error: function(){
			alert("something went wrong");
			}
	});
}

function update_cart(mode,edit_id,edit_size){
	var data = {"mode":mode,"edit_id":edit_id,"edit_size":edit_size};
	jQuery.ajax({
		url:'/ecco/agric/admin/parseres/update_cart.php',
		method:"post",
		data:data,
		success: function(){location.reload();},
		error: function(){alert("somethig went wrong");},
	});
	}
 function add_to_cart(){
   jQuery('#modal_errors').html("");
   var size = jQuery('#size').val();
   var quantity = jQuery('#quantity').val();
   var available = jQuery('#available').val();
   var error = '';
   var data  = jQuery('#add_product_form').serialize();
    if(size == '' || quantity =='' ||quantity == 0){
	error +='<p class="text-danger text-center">You must choose size and quantity</p>';
	jQuery('#modal_errors').html(error);
	return;
	}
	else if(quantity> available){
		error +='<p class="text-danger text-center">They are only '+available+' available</p>';
	jQuery('#modal_errors').html(error);
	 return;
		}else{
			jQuery.ajax({
				url:'/ecco/agric/admin/parseres/add_cart.php',
				method :'post',
				data: data,
				success: function(){
					location.reload();
					},
				error : function(){alert("something went wrong");}
			});
				
    }
 }
</script>