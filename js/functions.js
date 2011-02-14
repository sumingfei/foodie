//DISJOINTED ROLLOVERS USING BUTTON NAVIGATION AND IMAGES FADING IN AND OUT

$(document).ready(function(){
//disjointed rollover function starting point
$("div#button li").hover(function(){
	//make a variable and assign the hovered id to it
	var elid = $(this).attr('id');
	//hide the image currently there
	$("div#images div").hide();
	//fade in the image with the same id as the selected buttom
	$("div#images div#" + elid + "").fadeIn("slow");

	});

});