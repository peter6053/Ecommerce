// JavaScript Document
var username ="";
function send_message(message){
	var preState =  $("#container").html();
				if(preState.length>2){
			      preState = preState + "<br>";
		         }
	$("#container").html(preState+"<span class='current_message'>"+"<span class='bot'>Help desk:</span>"+message+"</span>");
			$(".current_message").hide();
			$(".current_message").delay(500).fadeIn();
			$(".current_message").removeClass("current_message");
	
}
function get_userName(){
	send_message("Hello, whats you name?");
}
function ai(message){
	if(username<2){
		username = message;
		send_message("Nice to meet you "+ username+", how can i help you?");
	   }
	   if(message.indexOf("delivered")>=0 || message.indexOf("delivery")>=0){
		   send_message("Please wait for 12 hours preo to you oder and you will receive a confirmation of the delivery of your oder.");
		   }
		   if(message.indexOf("thank you")>=0 ){
		username = message;
		send_message("You are more welcomed");
	   }
	}
$(function(){
	get_userName();
	$("#textbox").keypress(function(event){
		if(event.which==13){
			if($("#enter").prop("checked")){
				$("#send").click();
				event.preventDefault();
				}
		}
	});
	$("#send").click(function(){
		var userName =" <span class='userName'>You:</span>";
		var userMessage = $("#textbox").val();
		$("#textbox").val("");
		var preState =  $("#container").html();
				if(preState.length>2){
			      preState = preState + "<br>";
		         }
		    $("#container").html(preState+userName +userMessage);
		$("#container").scrollTop($("#container").prop("scrollHeight"));
		ai(userMessage);
	});
});