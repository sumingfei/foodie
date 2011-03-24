<?php
include('header.php');
date_default_timezone_set('America/Los_Angeles');
?>
<script type="text/javascript" src="js/highcharts.js"></script>
		
		<!-- Additional files for the Highslide popup effect -->
<script type="text/javascript" src="js/highslide-full.min.js"></script>
<script type="text/javascript" src="js/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="js/highslide.css">
	<script>
	function changeWeight(date, weight){
		$.ajax({
				type	: "GET",
				url		: "saveWeight.php",
				data	: {"date": date, "weight": weight},
				success : function(response)
				{
					//console.debug(response);
				}
		});
	}
	function weightSubmit(){
		$date = $("#datepicker").val();
		$weight = $("#weightpicker").val();
		changeWeight($date, $weight);
		setTimeout(function () { // wait 2 seconds and reload
			window.location.reload(true);
		  }, 2000);

	}
	$(function() {
		$( "#datepicker" ).datepicker({
			showOn: "both",
			buttonImage: "Images/calendar.gif",
			buttonImageOnly: true
		});
		$(".button").click(function() {  
			console.debug("clicked");
		});  
		//scrollpane parts
		var scrollPane = $( ".scroll-pane" ),
			scrollContent = $( ".scroll-content" );
		
		//build slider
		var scrollbar = $( ".scroll-bar" ).slider({
			slide: function( event, ui ) {
				if ( scrollContent.width() > scrollPane.width() ) {
					scrollContent.css( "margin-left", Math.round(
						ui.value / 100 * ( scrollPane.width() - scrollContent.width() )
					) + "px" );
				} else {
					scrollContent.css( "margin-left", 0 );
				}
			}
		});
		
		//append icon to handle
		var handleHelper = scrollbar.find( ".ui-slider-handle" )
		.mousedown(function() {
			scrollbar.width( handleHelper.width() );
		})
		.mouseup(function() {
			scrollbar.width( "100%" );
		})
		.append( "<span class='ui-icon ui-icon-grip-dotted-vertical'></span>" )
		.wrap( "<div class='ui-handle-helper-parent'></div>" ).parent();
		
		//change overflow to hidden now that slider handles the scrolling
		scrollPane.css( "overflow", "hidden" );
		
		//size scrollbar and handle proportionally to scroll distance
		function sizeScrollbar() {
			var remainder = scrollContent.width() - scrollPane.width();
			var proportion = remainder / scrollContent.width();
			var handleSize = scrollPane.width() - ( proportion * scrollPane.width() );
			scrollbar.find( ".ui-slider-handle" ).css({
				width: handleSize,
				"margin-left": -handleSize / 2
			});
			handleHelper.width( "" ).width( scrollbar.width() - handleSize );
		}
		
		//reset slider value based on scroll content position
		function resetValue() {
			var remainder = scrollPane.width() - scrollContent.width();
			var leftVal = scrollContent.css( "margin-left" ) === "auto" ? 0 :
				parseInt( scrollContent.css( "margin-left" ) );
			var percentage = Math.round( leftVal / remainder * 100 );
			scrollbar.slider( "value", percentage );
		}
		
		//if the slider is 100% and window gets larger, reveal content
		function reflowContent() {
				var showing = scrollContent.width() + parseInt( scrollContent.css( "margin-left" ), 10 );
				var gap = scrollPane.width() - showing;
				if ( gap > 0 ) {
					scrollContent.css( "margin-left", parseInt( scrollContent.css( "margin-left" ), 10 ) + gap );
				}
		}
		
		
		//change handle position on window resize
		$( window ).resize(function() {
			resetValue();
			sizeScrollbar();
			reflowContent();
		});
		//init scrollbar size
		
		setTimeout( sizeScrollbar, 10 );//safari wants a timeout
	});
	
	var chart;
	$(document).ready(function() {
		var chart_options = {
			chart: {
				renderTo: 'container',
				defaultSeriesType: 'spline'
			},
			title: {
				text: 'Weight History',
				x: -20 //center
			},
			xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
					'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
			},
			yAxis: {
				title: {
					text: 'Weight (lbs)'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				formatter: function() {
						return '<b>'+ this.series.name +'</b><br/>'+
						this.x +': '+ this.y +'lbs';
				}
			},
			series: []
		}
		$user_id = 1234;
		$.ajax({
				type	: "GET",
				url		: "getWeightHistory.php",
				dataType: "json",
				data	: {"user_id": $user_id },
				success : function(response)
				{
					chart_options.xAxis.categories = response.date;
					chart_options.series.push({
						name: 'Weight',
						data: response.weight
					});
					chart = new Highcharts.Chart(chart_options);
				}
		});
		
	});

	</script>

<div id="content">	
<div class="scroll-pane ui-widget ui-widget-header ui-corner-all" id="weightlog">
	<div class="scroll-content">
		<?php
		//MOD: change this part to a diff file
		include('connect-db.php');
		if($stmt = $mysqli->prepare("SELECT date,weight FROM weight_history WHERE timestamp > (SELECT DATE_SUB(now(), INTERVAL 14 day))")){
			$stmt->execute();
			$stmt->bind_result($date, $weight);
			$data;
			while($stmt->fetch()){
				$data[$date] = $weight;
			}
			//$result = json_encode($data);
			$stmt->close();
			//echo $result;
		}else{
			echo "ERROR: could not prepare SQL";	
		}
		$mysqli->close();

		for($i = 14; $i >= 0; $i--){
			$newdate = strtotime(-$i."day", time());
			$date2 = date("Y-m-d", $newdate);
			if(isset($data[$date2])){
				print '<div class="scroll-content-item"><p style="float: left">'. date("M d", $newdate ).'</p> <input autocomplete="off" class="weightbox" id="dd'.$date2.'dd" style=" font-size: 18px;" value="'.$data[$date2].'" onChange="changeWeight(\''.$date2.'\', this.value);"/></div>';
			}else{
				print '<div class="scroll-content-item"><p style="float: left">'. date("M d", $newdate ).'</p> <input autocomplete="off" class="weightbox" id="dd'.$date2.'dd" style=" font-size: 18px;" onChange="changeWeight(\''.$date2.'\', this.value);"/></div>';
			}
		}
		?>
	</div>
	<div class="scroll-bar-wrap ui-widget-content ui-corner-bottom">
		<div class="scroll-bar"></div>
	</div>
</div>

<div style="" id="weight-log-sidebar">
		<form method="post" action="">
		<h2>Enter New Weight</h2>
			<input name="date" value="Enter Date" id="datepicker" onclick="this.value='';" type="text">
			<input name="weight" value="Enter Weight" id="weightpicker" onclick="this.value='';" type="text">
			<div><a href="javascript:weightSubmit()">Submit</a></div>
		</form>	
</div>

<div id="weight_graph" style="padding: 20px 0 0; clear: both;"> 
<h3 style="clear: left" class="content_section">Weight Log</h3>
<div id="container" style="width: 800px; height: 400px; margin: 0 0;"></div>
<div>

</div>
<?php
include('footer.php');
?>