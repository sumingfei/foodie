<?php
include('header.php');

require_once('lib/FatSecretAPI.php');
require_once('lib/config.php');
$API = new FatSecretAPI(API_KEY, API_SECRET);
?>
	<style>
.ui-widget-header, .ui-widget-header1 { 
	font-size: 16px; 
	color: #ffffff !important; 
	padding: 5px; margin: 0; 
	background: #54b4c8 !important; 
	border: 0px !important;
}
.ui-widget-header1 { 
	border-top-left-radius: 10px !important;
	border-top-right-radius: 10px !important;
	-moz-border-top-left-radius: 10px !important;
	-moz-border-top-right-radius: 10px !important;
}
#content { 
	height: 300px; 
}
#products { 
	float:right; 
	width: 500px; 
	margin-right: 2em; 
}
#cart { 
	width: 200px;
	position:fixed;
	float:right;
	border: 1px solid #aaaaaa;
	border-radius: 10px !important;
	-moz-border-radius: 10px !important;
	-moz-box-shadow: 3px 3px 4px #aaaaaa;
	-webkit-box-shadow: 3px 3px 4px #aaaaaa;
	box-shadow: 3px 3px 4px #aaaaaa;
	/* For IE 8 */
	-ms-filter: "progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#aaaaaa')";
	/* For IE 5.5 - 7 */
	filter: progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#aaaaaa');
}
.ui-widget-content, .ui-state-default, .ui-state-hover {
	border: 0px !important;
	padding-right: 10px;
	background: transparent !important;
	}
#right { 
	float: right;
	width:200px; 
	}
/* style the list to maximize the droppable hitarea */
#cart ol { margin: 0; padding: 1em 0 1em 3em;}
.change_serving {width: 250px;}
*html #cart {
    position: absolute;
    left: expression( ( 0   ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) )   'px' );
    top: expression( ( 0   ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) )   'px' );
}

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
	//var serving_changed = false;
	function setDraggable(){
		$( "#search_result span" ).draggable({
			appendTo: "body",
			helper: "clone"
		});
	}
	
	function servingSelect($index){
		//servingChanged = true;
		for( j in foodData){
			if(foodData[j].serving_id == jQuery('.serving_box option:selected').val()){
				measurement = foodData[j].measurement_description;
				$('#food_description'+$index).text('Per '+parseInt(foodData[j].number_of_units)+' '+foodData[j].measurement_description+' - Calories: '+foodData[j].calories+' kcal | Fat: '+foodData[j].fat+'g | Carbs: '+foodData[j].carbohydrate+'g | Protein: '+foodData[j].protein);
			}
		}
	}
	
	function displayNutPanel($food_id, $index){
		$.ajax({
				type	: "GET",
				url		: "changeServing.php",
				dataType: "json",
				data	: {"food_id": $food_id },
				success : function(response)
				{
					foodData = response.food.servings.serving;
					$("#nuttable").remove();
					var create = '<table id="nuttable" style="table-layout:fixed"><colgroup><col width="5"/><col/><col width="30"/></colgroup><tr><td colspan="3" class="title"><b>Nutrition Facts</b></td></tr>';	
					for( serv in foodData){
						console.debug("here: "+measurement);
						if(foodData[serv].measurement_description==measurement){
							console.debug(measurement);
						}
						//create += "<option value='"+foodData[serv].serving_id+"'>"+parseInt(foodData[serv].number_of_units)+' '+foodData[serv].measurement_description+"</option>";
					}
					create += 	'</table>';
					$("#nutpanel").append(create);
				}
		});
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
					//console.debug(foodData.length);
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

<div id="nutpanel">
<table id="nuttable"></table>
</div>

</div>



</div> <!----- close content ----->
<?php
include('footer.php');
?>