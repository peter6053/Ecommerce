$(function() {
    setInterval(function(){
		$('#slider.slider').animate({'margin-left':'-720'})
	
	},3000);
	$("#one").hide(300);
	$("#pan").fadeIn(10000);
});
var myApp =angular.module('myApp',['ngRoute']);

myApp.config([$routeProvider', function($routeProvider){
	$routeProvider.
	 when('/login', {
		 templeteUrl:'logiin.html',
		 controller:'RegistrationController'
	 }).
	  when('/register', {
		 templeteUrl:'registe.html',
		 controller:'RegistrationController'
	 }).
	  when('/success', {
		 templeteUrl:'success.html',
		 controller:'SuccessController'
	 }).
	 otherwise({
		 redirectTo:'/login'
	 });
}]);
	 
	 

myApp.controller('appController',['$scope', function($scope){
	
}]);