<?php
include('header.php');
?>
<!-- 1. Add these JavaScript inclusions in the head of your page 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
-->
<script type="text/javascript" src="js/highcharts.js"></script>

<!-- Additional files for the Highslide popup effect -->
<script type="text/javascript" src="js/highslide-full.min.js"></script>
<script type="text/javascript" src="js/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="js/highslide.css">


<!-- 2. Add the JavaScript to initialize the chart on document ready -->
<script type="text/javascript">
var chart;
var piechart;
var nutData;
$(document).ready(function() {
		// define the options
	var piechart_options = {
		chart: {
				renderTo: 'pie_container',
				defaultSeriesType: 'pie'
			},
			title: {
				text: ''
			},
			plotArea: {
				shadow: null,
				borderWidth: null,
				backgroundColor: null
			},
			tooltip: {
				formatter: function() {
					return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						formatter: function() {
							if (this.y > 5) return this.point.name;
						},
						color: 'white',
						style: {
							font: '12px Trebuchet MS, Verdana, sans-serif'
						}
					}
				}
			},
			legend: {
				layout: 'vertical',
				style: {
					left: 'auto',
					bottom: 'auto',
					right: '5px',
					top: '10px'
				}
			},/*
			series: [{
				data: [
					['fat',   45.0],
					['calorie',       26.8],
					{
					name: 'Chrome',    
						y: 12.8,
						sliced: true,
						selected: true
					},
					['protein',    8.5]
				]
			}]*/
			series:[]
	}
	var chart_options = {
		chart: {
			renderTo: 'container',
			defaultSeriesType: 'spline'
		},
		title: {
			text: 'Daily Calories'
		},
		xAxis: {
			//categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
			//'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
			
			categories: ['Jan', 'Feb', 'Mar']
		},
		yAxis: {
			title: {
				text: 'Nutrition'
			},
			x: 20,
			y: 20
		},
		legend: {
			enabled: false
		},
		tooltip: {
			formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+
					this.x +': '+ this.y +'';
			}
		},
		plotOptions: {
			spline: {
				cursor: 'pointer',
				point: {
					events: {
						click: function() {
							//console.debug(piechart.series);
							$axis = this.x;
							piechart.series[0].setData(
								//[1, 2, 3]
								//[["fat", 1],["carb", 2],["protein", 3]]
								[["fat", nutData.fat[$axis]],["carb", nutData.carbohydrate[$axis]],["protein", nutData.protein[$axis]]]
							);

							piechart.redraw();
							/*
							hs.htmlExpand(null, {
								pageOrigin: {
									x: this.pageX, 
									y: this.pageY
								},
								headingText: this.series.name,
								maincontentText: 'this.category: '+ this.category +
									'<br/>this.y: '+ this.y,
								width: 200
							});
							*/
						}
					}
				}
			}
		},
		series: []
	}
	// Load data asynchronously using jQuery. On success, add the data
	// to the options and initiate the chart.
	// http://api.jquery.com/jQuery.getJSON/
	
	$user_id = 4444;
	$.ajax({
			type	: "GET",
			url		: "getNutrition.php",
			dataType: "json",
			data	: {"user_id": $user_id },
			success : function(response)
			{
				nutData = response;
				chart_options.series.push({
					name: 'Calorie',
					data: nutData.calorie
				});
				chart_options.series.push({
					name: 'Fat',
					data: nutData.fat
				});
				chart_options.series.push({
					name: 'Carbohydrate',
					data: nutData.carbohydrate
				});
				chart_options.series.push({
					name: 'Protein',
					data: nutData.protein
				});
				
				piechart_options.series.push({
					//data: [["fat", 1],["carb", 2],["protein", 3]]
					data:[["fat", nutData.fat[0]],["carb", nutData.carbohydrate[0]],["protein", nutData.protein[0]]]
				});
				chart = new Highcharts.Chart(chart_options);
				piechart = new Highcharts.Chart(piechart_options);
			}
	});
	
});
</script>
	
<div id="content">
	<!-- 3. Add the container -->
	<table><tr><td>
		<div id="pie_container" style="width: 300px; height: 300px; margin: 0pt auto;" ></div>
		</td>
		<td valign="top">
		<div id="container" style="width: 600px; height: 300px; margin: 0pt auto; z-index: 10" ></div>
	</td></table>
		

<?php
		include('connect-db.php');
		
		if ($result = $mysqli->query("SELECT * FROM nutrition_history ORDER BY id")){
			if($result->num_rows > 0){
				echo "<table id='datatable' border='1' cellpadding ='10'>";
				echo "<tr><th>???</th><th>User ID</th><th>Calorie</th><th>Fat</th><th>Carbohydrate</th><th>Protein</th><th>Time</th></tr>";
				while($row = $result->fetch_object())
				{
					echo"<tr>";
					//echo"<th>".$row->id."</td>";
					echo"<td>".$row->food_id."</td>";
					echo"<td>".$row->user_id."</td>";
					echo"<td>".$row->calorie."</td>";
					echo"<td>".$row->fat."</td>";
					echo"<td>".$row->carb."</td>";
					echo"<td>".$row->protein."</td>";
					echo"<td>".$row->inserttime."</td>";
					//echo"<th><a href='records.php?id=".$row->id."'>Edit</a></td>";
					//echo"<th><a href='delete.php?id=".$row->id."'>Delete</a></td>";
					echo"</tr>";
				}
				
				echo "</table>";
			}else{
				echo "No results to display!";	
			}
		}else{
			echo "ERROR: " . $mysqli->error;
		}
		$mysqli->close();
	?>				
	
</div>
<?php
include('footer.php');
?>