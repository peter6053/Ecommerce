  
   <footer style="bottom:0px">
        <div class="container">
            <div class="row">
                <article class="col-lg-6 col-md-6 col-sm-6 followBox pull-right">
                    <div class="clearfix pull-right">
                        <p class="pull-left">Follow us:</p>
                        <ul class="account_desc">
<li><a href="http://livedemo00.template-help.com/wt_47305/#"><img src="../img/Designbolts-Ios8-Style-Social-Facebook.ico" alt="" width="50" height="50"></a></li>
 <li><a href="http://livedemo00.template-help.com/wt_47305/#"><img src="../img/Designbolts-Ios8-Style-Social-Google-Plus.ico" alt="" widt="50" height="50"></a></li>
<li><a href="http://livedemo00.template-help.com/wt_47305/#"><img src="../img/Designbolts-Ios8-Style-Social-Email.ico" alt="" height="50" widt="50"></a></li>
<li><a href="http://livedemo00.template-help.com/wt_47305/#"><img src="../img/Designbolts-Ios8-Style-Social-Plaxo.ico" alt="" height="50" width="50"></a></li></ul></div></article>
  <article class="col-lg-6 col-md-6 col-sm-6">
   <h1 class="navbar-brand navbar-brand_">
<a href="http://livedemo00.template-help.com/wt_47305/index.html"><img src="../img/logo.png" alt="" width="150" height="60"></a></h1>
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
        </div></footer>    <script src="../controller.js"></script>
<script src="../jquery-ui-1.10.4/jquery-1.10.2.js" ></script>
<script src="../bootstrap-3.3.6-dist/js/bootstrap.js"></script>
<script src="../main.js"></script>
<script>
    
	
  function updateSizes(){
	  var sizeString =' ';
	  for(var i=1;i<=12;i++){
		  if(jQuery('#size'+i).val()!=''){
			 sizeString += jQuery('#size'+i).val()+ ':'+jQuery('#qty'+i).val()+ ':' +jQuery('#threshold'+i).val()+',';  
			  
			  }
		  }
	  jQuery('#sizes').val(sizeString);
	  
  }
   function get_child_options(selected){
	   if(typeof selected === 'undefined'){
		   var selected = '';
		   }
	   var parentID = jQuery('#parent').val();
	 jQuery.ajax({
	 url:'/ecco/agric/admin/parseres/child_catergories.php',
	 type:'POST',
	 data:{parentID : parentID, selected: selected},
	 success: function(data){
	 jQuery('#child').html(data); 
	 },
	 error: function(){alert("something went wrong wit the child options.")},
	 });
  }
   jQuery('select[name="parent"]').change(function(){
	   get_child_options();
	   });
	   
    
   </script>  
    
 