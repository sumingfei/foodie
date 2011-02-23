<?php
include('header.php');

require_once('lib/FatSecretAPI.php');
require_once('lib/config.php');
$API = new FatSecretAPI(API_KEY, API_SECRET);
?>
<style>
.nutpanel {
	width: 250px;
	border: 5px solid #DDDDDD;
	padding: 5px;
	color: #666666;
	font-family: arial;
}
.title {
	font-size: 20px;
}
td.borderTop, td.generic {
	border-bottom: 1px solid #aaaaaa;
}
.nutpanel table {
	font-size: 12px;
	border-collapse: collapse;
	width: 250px;
}
td.sep {
	border-top: 10px solid #aaaaaa;
}
</style>
	<script>
	var foodData;
	var measurement;
	function setDraggable(){
		$( "#search_result span" ).draggable({
			appendTo: "body",
			helper: "clone"
		});
	}
	
	function servingSelect($index){
		for( j in foodData){
			if(foodData[j].serving_id == jQuery('.serving_box option:selected').val()){
				$('#food_description'+$index).text('Per '+parseInt(foodData[j].number_of_units)+' '+foodData[j].measurement_description+' - Calories: '+foodData[j].calories+' kcal | Fat: '+foodData[j].fat+'g | Carbs: '+foodData[j].carbohydrate+'g | Protein: '+foodData[j].protein);
				
			}
		}
	}
	function displayNut(){
		
		for( j in foodData){
			if(foodData[j].serving_id == jQuery('.serving_box option:selected').val()){
				var myServing = foodData[j];
				var create = '<table style="table-layout:fixed"><colgroup><col width="5"/><col/><col width="30"/></colgroup>';
					create += '<tr><td colspan="3" class="title"><b>Nutrition Facts</b></td></tr>';
					create += '<tr><td class="label" colspan="3">Serving Size '+parseInt(myServing.number_of_units)+' '+myServing.measurement_description+'</tr>';
					create += '<tr><td class="sep" colspan="3"></td></tr><tr class="borderTop"><td class="borderTop label strong small" colspan="3">Amount Per Serving</td></tr>';
					create += '<tr><td class="borderTop label" colspan="3"><div style="float:right;white-space:nowrap">Calories from Fat '+parseInt(myServing.fat*9)+'</div><b>Calories</b> '+myServing.calories+'</td></tr>';
					create += '<tr height="2px"><td class="sep" colspan="3"></td></tr><tr><td class="label strong small" colspan="3" align="right">% Daily Values*</td></tr>';
					create += '<tr><td class="label borderTop" colspan="2"><b>Total Fat</b> '+myServing.fat+'g</td><td class="borderTop" align="right"><b> '+Math.round((myServing.fat/65)*100)+'</b>%</td></tr>';
					create += '<tr><td>&nbsp;</td><td class="borderTop label">Saturated Fat	'+myServing.saturated_fat+'g</td><td class="borderTop" align="right"><b>'+Math.round((myServing.saturated_fat/20)*100)+'</b>%</td></tr>';
					create += '<tr><td>&nbsp;</td><td class="label borderTop">Polyunsaturated Fat '+myServing.polyunsaturated_fat+'g</td><td class="borderTop">&nbsp;</td></tr>';
					create += '<tr><td>&nbsp;</td><td class="label borderTop">Monounsaturated Fat '+myServing.monounsaturated_fat+'g</td><td class="borderTop">&nbsp;</td></tr>';
					create += '<tr><td class="label borderTop" colspan="2"><b>Cholesterol</b>	'+myServing.cholesterol+'mg</td><td class="borderTop" align="right"><b>'+Math.round((myServing.cholesterol/300)*100)+'</b>%</td></tr>';
					create += '<tr><td class="label borderTop" colspan="2"><b>Sodium</b>'+myServing.sodium+'mg</td><td class="borderTop" align="right"><b>'+Math.round((myServing.sodium/2400)*100)+'</b>%</td></tr>';
					create += '<tr><td class="label borderTop" colspan="2"><b>Potassium</b>	'+myServing.potassium+'mg</td><td class="borderTop">&nbsp;</td></tr>';
					create += '<tr><td class="label borderTop" colspan="2"><b>Total Carbohydrate</b> '+myServing.carbohydrate+'g</td><td class="borderTop" align="right"><b>'+Math.round((myServing.carbohydrate/300)*100)+'</b>%</td></tr>';
					create += '<tr><td>&nbsp;</td><td class="borderTop label">Dietary Fiber '+myServing.fiber+'g</td><td class="borderTop" align="right"><b>'+Math.round((myServing.fiber/25)*100)+'</b>%</td></tr>';
					create += '<tr><td>&nbsp;</td><td class="borderTop label">Sugars	'+myServing.sugar+'g</td><td class="borderTop">&nbsp;</td></tr>';
					create += '<tr><td class="label borderTop" colspan="2"><b>Protein</b> '+myServing.protein+'g</td><td class="borderTop">&nbsp;</td></tr>';
					create += '<tr><td class="sep" colspan="3"></td></tr><tr><td colspan="3"><table class="generic" style="margin:0"><tr><td width="45%">Vitamin A '+Math.round((myServing.vitamin_a/5000)*100)+'%</td>';
					create += '<td align="center"><img src="images/myfs_darkcir.gif" width="6" height="6"/></td><td width="45%">Vitamin C	'+Math.round((myServing.vitamin_c/60)*100)+'%</td></tr></table></td></tr>';
					create += '<tr><td colspan="3" class="label borderTop"><table class="generic" style="margin:0"><tr><td width="45%">Calcium	'+Math.round((myServing.calcium/1000)*100)+'%</td><td align="center"><img src="images/myfs_darkcir.gif" width="6" height="6"/></td>';
					create += '<td width="45%">Iron	'+Math.round((myServing.iron/18)*100)+'%</td></tr></table></td></tr>';
					create += '<tr><td class="label borderTop" colspan="3"><table style="border-collapse:collapse"><tr valign="top"><td>*</td>';
					create += '<td style="font-size:9px">Percent Daily Values are based on a 2000 calorie diet. Your daily values may be higher or lower depending on your calorie needs.<br/><br/>Nutrition Values are based on USDA Nutrient Database SR18';
					create += '</td></tr></table></td></tr></table>';
			}
		}
		$(".nutpanel table").remove();
		$(".nutpanel").append(create);
		//console.debug("here");
	}
	function changeServing($food_id, $index){
		$.ajax({
				type	: "GET",
				url		: "changeServing.php",
				dataType: "json",
				data	: {"food_id": $food_id },
				success : function(response)
				{
					foodData = response.food.servings.serving;
					$(".serving_box").remove();
					var create = '<select class="serving_box" onChange="servingSelect('+$index+')">';
					if(isNaN(foodData.length)){
						create += "<option value='"+foodData.serving_id+"'>"+parseInt(foodData.number_of_units)+' '+foodData.measurement_description+"</option>";
						}
					else{
					for( serv in foodData){
						create += "<option value='"+foodData[serv].serving_id+"'>"+parseInt(foodData[serv].number_of_units)+' '+foodData[serv].measurement_description+"</option>";
					}}
						create += "</select>";
					$("#change_serving"+$index).after(create);
				}
		});
	}
	$(function() {
		$("#search_input").submit(function(){
			$.ajax({
				type 	: "GET",
				url 	: "request.php",
				data	: {"search_term" : $("#search_term").val() },
				success : function(response)
				{
					$("#search_result table").fadeOut("fast", function()
					{
						$("#search_result table").remove();
						$("#search_result").append($(response).hide().fadeIn());
						setDraggable();
					});
				}
			});
			return false;
		});
		$( "#cart ol" ).droppable({
			activeClass: "ui-state-default",
			hoverClass: "ui-state-hover",
			accept: ":not(.ui-sortable-helper)",
			drop: function( event, ui ) {
				$( this ).find( ".placeholder" ).remove();
				//console.debug(ui.draggable.id());
				$( "<li></li>" ).text( ui.draggable.text() ).appendTo( this );
				//figure out calorie, post to end of li
				//food_id = ui.draggable.find("food_id").text();
			}
		});
		
	});
	</script>
<div id="content">

<form id="search_input" name="search_input">
	<input type="text" value="" id="search_term" name="search_term" />
	<input type="submit" value="Search" />
</form>
<div id="left">
<div id="search_result">
	<table></table>
</div></div>


<div id="right">
<div id="cart">
	<h1 class="ui-widget-header1">BreakFast</h1>
	<div class="ui-widget-content">
		<ol>
			<li class="placeholder">Add food here</li>
		</ol>
	</div>
	<h1 class="ui-widget-header">Lunch</h1>
	<div class="ui-widget-content">
		<ol>
			<li class="placeholder">Add food here</li>
		</ol>
	</div>
	<h1 class="ui-widget-header">Dinner</h1>
	<div class="ui-widget-content">
		<ol>
			<li class="placeholder">Add food here</li>
		</ol>
	</div>
</div>

<div class="nutpanel"><table></table></div>
</div>




</div>
<?php
include('footer.php');
?>