<?php
include('header.php');

require_once('lib/FatSecretAPI.php');
require_once('lib/config.php');
$API = new FatSecretAPI(API_KEY, API_SECRET);

date_default_timezone_set('America/Chicago');
?>

<link href="js/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="js/facebox.js" type="text/javascript"></script> 
<style>
.nutpanel {
    display:none;
	width: 250px;
	border: 5px solid #DDDDDD;
	height: 450px;
	float: right;
	margin: 5px 10px 0 0;
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
#search_result{
	padding: 10px 0 0 10px;
	width: 600px;
	height: 100%;
	float: left;
	margin: 20px 0 0 10px;
}
#search_term{
	height: 35px;
	width: 200px;
	margin: 0 0 0 20px;
	font-size: 20px;
	font: Ariel;
}
#cart{
	width: 200px;
	position:fixed;
	border: 1px solid #aaaaaa;
	margin: 0 0 0 700px;
	float: right;
}
#cart ul{
	list-style-type: none;
	margin-left: 0;
	padding-left: 1em;
	text-indent: -1em;
}
#cart input{
	display: inline;
	background: #54b4c8 !important; 
	border: 0px !important;
}
#theDate{
	display: inline-block;
	margin: 0 10px;
	font: 16px Sans-serif;
	width: 177px; 
	height: 35px; 
	background: url('images/dateholder.gif') top left;
}
#leftbutton{
	display: inline-block;
	width: 38px; 
	height: 35px; 
	background: url('images/leftbutton.gif');
}
#rightbutton{
	display: inline-block;
	width: 38px; 
	height: 35px; 
	background: url('images/rightbutton.gif');
}
</style>
	<script>

	var foodList;
	var foodServingList = new Array();
	var measurement;
	var myNutList = {"entries" : []};
	var myDay = new Date();
	var servingIndex = new Array();
	function setDraggable(){
		$( "#search_result .drag" ).draggable({
			appendTo: "body",
			helper: "clone"
		});
	}
	function setFacebox(){
		$('a[rel*=facebox]').facebox({
			loadingImage : 'images/loading.gif',
			closeImage   : 'images/closelabel.png'
		 });
	}
	function servingSelect($index, myservingIndex){
		/*
		for( j in foodServingList[$index]){
			if(foodServingList[$index][j].serving_id == jQuery('.serving_box option:selected').val()){
				var temp = foodServingList[$index][j];
				$('#food_description'+$index).text('Per '+parseInt(temp.number_of_units)+' '+temp.measurement_description+' - Calories: '+temp.calories+' kcal | Fat: '+temp.fat+'g | Carbs: '+temp.carbohydrate+'g | Protein: '+temp.protein);
				
			}
		}
		*/
		servingIndex[$index] = myservingIndex;
		if(myservingIndex != 'none'){
			var temp = foodServingList[$index][myservingIndex];
			$('#food_description'+$index).text('Per '+parseInt(temp.number_of_units)+' '+temp.measurement_description+' - Calories: '+temp.calories+' kcal | Fat: '+temp.fat+'g | Carbs: '+temp.carbohydrate+'g | Protein: '+temp.protein);
		}else{
			//console.debug(foodServingList[$index]);
		}
	}
	function getServingWithFoodID($food_id, $index){
		$.ajax({
					type	: "GET",
					url		: "changeServing.php",
					dataType: "json",
					data	: {"food_id": $food_id },
					success : function(response)
					{
						foodServingList[$index] = response.food.servings.serving;
					}
			});
	}
	function changeServing($food_id, $index){
		if(foodServingList[$index]==undefined){
			$.ajax({
					type	: "GET",
					url		: "changeServing.php",
					dataType: "json",
					data	: {"food_id": $food_id },
					success : function(response)
					{
						foodServingList[$index] = response.food.servings.serving;
						$(".serving_box").remove();
						var create = '<select class="serving_box" onClick="servingSelect('+$index+', this.value)">';
						if(isNaN(foodServingList[$index].length)){
							create += "<option value='none'>"+parseInt(foodServingList[$index].number_of_units)+' '+foodServingList[$index].measurement_description+"</option>";
							}
						else{
						for( serv in foodServingList[$index]){
							create += "<option value='"+serv+"'>"+parseFloat(foodServingList[$index][serv].number_of_units)+' '+foodServingList[$index][serv].measurement_description+"</option>";
						}}
							create += "</select>";
						$("#change_serving"+$index).after(create);
					}
			});
		}else{
			$(".serving_box").remove();
			var create = '<select class="serving_box" onClick="servingSelect('+$index+', this.value)">';
			if(isNaN(foodServingList[$index].length)){
				create += "<option value='none'>"+parseInt(foodServingList[$index].number_of_units)+' '+foodServingList[$index].measurement_description+"</option>";
			}
			else{
			for( serv in foodServingList[$index]){
				create += "<option value='"+serv+"'>"+parseFloat(foodServingList[$index][serv].number_of_units)+' '+foodServingList[$index][serv].measurement_description+"</option>";
			}}
				create += "</select>";
			$("#change_serving"+$index).after(create);
		}
	}
	$(function() {
		$("#theDate").text(myDay.toDateString());
		$("#search_input").submit(function(){
			var search_term = $("#search_term").val();
			if(search_term == ''){
			
			}else{
				foodSearch(search_term, 0);
			}
			return false;
		});
		$( "#cart ul" ).droppable({
			activeClass: "ui-state-default",
			hoverClass: "ui-state-hover",
			accept: ":not(.ui-sortable-helper)",
			drop: function( event, ui ) {
				$( this ).find( ".placeholder" ).remove();
				var foodID = $(ui.draggable).attr('food_id');
				var foodDesc = $(ui.draggable).attr('food_desc');
				var currentIndex = $(ui.draggable).attr('index');
				if(foodServingList[currentIndex]==undefined){
					$.ajax({
						type	: "GET",
						url		: "changeServing.php",
						dataType: "json",
						data	: {"food_id": foodID },
						success : function(response)
						{
							foodServingList[currentIndex] = response.food.servings.serving;
						}
					});
				}else{
				
				
				}
				
				//change this to id definded, get rid of foodDesc
				addList(this.id, ui.draggable.text(), foodID, foodDesc);
			}
		});
		$("#cart").submit(function(){
			$.ajax({
				type 	: "POST",
				url 	: "saveNut.php",
				data	: {"nutList" : myNutList,
					"date" : myDay.toDateString()},
				success : function(response)
				{
					setTimeout(function () { // wait .1 seconds and reload
					window.location.reload(true);
					  }, 100);
				}
			});
			return false;
		});
	});
	function foodSearch(search_term, page){
		$.ajax({
				type 	: "GET",
				url 	: "request.php",
				dataType: "json",
				data	: {"search_term" : search_term ,
						"page": page},
				success : function(response)
				{
					var create;
					foodList = response.foods.food;
					foodServingList = new Array(); //resolve memory, careful memory leak
					servingIndex = new Array();
					var pageNumber = parseInt(response.foods.page_number);
					var maxResults = 15; //hard coded to be 15 here, check with parseInt(response.foods.max_results)
					var totalResults = parseInt(response.foods.total_results);
					$num_from = pageNumber*15+1;
					$num_to = $num_from + 14;
					$num_pages = Math.ceil(totalResults/15);
					
					if(totalResults == 0){
						create = '<table id="result_table" class="fatsecret_foodsearch_results" cellpadding="0" cellspacing="0"><tbody><tr>';
						create += '<td class="fatsecret_subheading fatsecret_borderbottom">Search results for: '+search_term+'</td>';
						create += '<td class="fatsecret_foodsearch_total fatsecret_borderbottom" align="right">'+$num_from+' to '+$num_to+' of '+totalResults+'</td></tr>';
						create += '</table>';
						$("#search_result table").remove();
						$("#search_result #temp").remove();
						$("#search_result").append($(create).hide().fadeIn());
						return;
					}
					
					$page_from = (pageNumber - 4) > 1 ? (pageNumber - 4):1;
					$page_to = (pageNumber + 6) > $num_pages ? $num_pages : (pageNumber + 6); //pageto+1, cancel with i<page_to
					
					$lastPageMax = (totalResults % 15) > 0 ? (totalResults % 15) : 15;
					$currentListMax = page < $num_pages-1 ? 15 : $lastPageMax;
					
					$("#search_result table").fadeOut("fast", function()
					{
						$("#search_result table").remove();
						$("#search_result #temp").remove();
						create = '<table id="result_table" class="fatsecret_foodsearch_results" cellpadding="0" cellspacing="0"><tbody><tr>';
						create += '<td class="fatsecret_subheading fatsecret_borderbottom">Search results for: '+search_term+'</td>';
						create += '<td class="fatsecret_foodsearch_total fatsecret_borderbottom" align="right">'+$num_from+' to '+$num_to+' of '+totalResults+'</td></tr>';
						var i;
						for(i=0; i<$currentListMax; i++){
							var currentFood = foodList[i];
							create += '<div id="entry"><tr><td class="fatsecret_borderbottom" colspan="2">';
							create += '<div style="display:inline">';
							create += '<a class="drag" href="#nutpanel" index='+i+' rel="facebox" onclick="displayNut('+currentFood.food_id+','+i+');" title="click here for nutrition details" food_id="'+currentFood.food_id+'" food_desc="'+currentFood.food_description+'">'+currentFood.food_name+'</a></div>';
						
							create += '<div style="display:inline" class="change_serving"><a id="change_serving'+i+'" href="javascript:changeServing('+currentFood.food_id+', '+i+');" style="color:red;">change serving</a></div>';
							create += '<div id="serving_box" class="serving_box"></div>';
							create += '<div id="food_description'+i+'" style="display: block" class="food_description">'+currentFood.food_description+'</div></td></tr></div>';
						}
						create += '<tr><td>Result Page: ';
						if($page_from > 1){
							create += '<a class="pagination_link" href="#" onclick="foodSearch(\''+search_term+'\', 0); return false;">First|</a>';
						}
						for(i=$page_from; i<=$page_to; i++){
							create += '<a class="pagination_link" href="#" onclick="foodSearch(\''+search_term+'\', '+(i-1)+'); return false;">'+i+'|</a>';
						}
						if($page_to < $num_pages){
							create += '<a class="pagination_link" href="#" onclick="foodSearch(\''+search_term+'\', '+($num_pages-1)+'); return false;">End|</a>';
						}
						create += '</td></tr></tbody></table>';
						$("#search_result").append(create);
						setDraggable();
						setFacebox();
					});
				}
			});
	}
	function decDay(){
		myDay.setDate(myDay.getDate()-1);
		$("#theDate").text(myDay.toDateString());
	}
	function incDay(){
		myDay.setDate(myDay.getDate()+1);
		$("#theDate").text(myDay.toDateString());
	}
	function addList($meal_id, name, food_id, food_desc)
	{
		var calorie = parseMeasurement(food_desc);
		//note meal_id is one, two, three
		
		//add calorie to the cart for display
		$("#cart #"+$meal_id).append("<li>"+name+"</li><p>"+calorie+"</p>");
		$("#cart ."+$meal_id).val(parseInt($("#cart ."+$meal_id).val())+parseInt(calorie));
		var entry = {"user_id": 1234,
					"food_id" : food_id,
					"meal_time" : $meal_id,
					"food_desc" : food_desc
					}
		//MOD: add user_id here
		myNutList.entries.push(entry);
	}
	//return the calorie portion of the $text
	function parseMeasurement($text){
		$dd = $text.split(' - ');
		$zz = $text.match('[0-9]+kcal');
		$cal = $zz[0].slice(0, $zz[0].indexOf('kcal'));
		return $cal;
	}
	function parseMeasurement2($text){
		$dd = $text.split(' - ');
		$zz = $text.match('[0-9]+kcal');
		$cal = $zz[0].slice(0, $zz[0].indexOf('kcal'));
		return $cal;
	}
	
	//a temp test function
	function display(){
		$text = ""
		$dd = $text.split(' - ');
		$zz = $text.match('[0-9]+kcal');
		$cal = $zz[0].slice(0, $zz[0].indexOf('kcal'));
		return $cal;
	}
	function generateNutPanel($index){
		var create = '';
	
		if(servingIndex[$index] == undefined){//did not choose a serving
			return;
		}
		else if(servingIndex[$index] == 'none'){
			console.debug("display none");
			myServing = foodServingList[$index];
		}else{
			console.debug(servingIndex[$index]);
			myServing = foodServingList[$index][servingIndex[$index]];
		}
		var create = '<table style="table-layout:fixed"><colgroup><col width="5"/><col/><col width="30"/></colgroup>';
			create += '<tr><td colspan="3" class="title"><b>Nutrition Facts: </b>'+foodList[$index].food_name+'</td></tr>';
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

		$(".nutpanel table").remove();
		$(".nutpanel").append(create);
	}
	function displayNut($food_id, $index){
		//console.debug(foodList[$index].food_description);
		if(servingIndex[$index] == undefined){
			var create = '<table><tr><td>Needs to select a serving before displaying nutrition info</td></tr></table>';
			$(".nutpanel table").remove();
			$(".nutpanel").append(create);
		}
		if(foodServingList[$index]==undefined){
			$.ajax({
				type	: "GET",
				url		: "changeServing.php",
				dataType: "json",
				data	: {"food_id": $food_id },
				success : function(response)
				{
					foodServingList[$index] = response.food.servings.serving;
					generateNutPanel($index);
				}
			});
		}else{
			generateNutPanel($index);
		}
	}
	</script>
	
<div id="content">
<div id="choose_day">
	<!---<a class='' href="javascript:decDay();" id="" title="">Prev</a>  --->
	<a id="leftbutton" class='img' href="javascript:decDay();" title="Previous Day"></a>
	<!---<img src="Images/leftbutton.gif" alt="Prev" onclick="javascript:decDay();" style="display:inline;"/>--->
	<div id="theDate"></div>
	<!---<img id="theDate" src="Images/dateholder.gif" alt="" onclick="javascript:decDay();">Today</img>--->
	<a id="rightbutton" class='img' href="javascript:incDay();" title="Next Day"></a>
	
	<form id="search_input" name="search_input" style="display: inline-block;">
		<input type="text" value="" id="search_term" name="search_term" />
		<input class ="img" type="image" src="Images/search.gif" onclick="this.submit">
	</form>
</div>
<form id="cart">
	<h1 class="ui-widget-header1">BreakFast</h1><input type="text" value="0" class="one" autocomplete="off"></input>
	<div class="ui-widget-content">
		<ul id="one">
			<li class="placeholder">Add food here</li>
		</ul>
	</div>
	<h1 class="ui-widget-header">Lunch</h1><input type="text" value="0" class="two" autocomplete="off"></input>
	<div class="ui-widget-content">
		<ul id="two">
			<li class="placeholder">Add food here</li>
		</ul>
	</div>
	<h1 class="ui-widget-header">Dinner</h1><input type="text" value="0" class="three" autocomplete="off"></input>
	<div class="ui-widget-content">
		<ul id="three">
			<li class="placeholder">Add food here</li>
		</ul>
	</div>	
	<h1 class="ui-widget-header">Total Calories <input type="text" value="0" class="total" autocomplete="off"></input></h1>
	<input type="submit" id="save" value="Save" onclick=""/>
</form>
<div id="search_result" class="content_section"><table><div id="temp">Display results here</div></table>
</div>
<div style="width=300px" class="nutpanel" id="nutpanel"><table></table></div>
</div>
<?php
include('footer.php');
?>