<?php
include('header.php');
?>
<div id="content">
	<script>
	function changeWeight(date, weight){
		$.ajax({
				type	: "GET",
				url		: "saveWeight.php",
				data	: {"date": date, "weight": weight},
				success : function(response)
				{
				}
		});
	}
	function weightSubmit(){
		$date = $("#datepicker").val();
		$weight = $("#weightpicker").val();
		console.debug($date);
		
		//$("#dd"+$date).val($weight);
		console.debug($(this).val());
		changeWeight($date, $weight);
		
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
		
		/*
		$.ajax({
				type	: "GET",
				url		: "saveWeight.php",
				dataType: "json",
				data	: {"what": 1},
				success : function(response)
				{
					
				}
		});
		*/
		setTimeout( sizeScrollbar, 10 );//safari wants a timeout
	});
	</script>

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
			$date2 = date("m/d/Y", $newdate);
			if(isset($data[$date2])){
				print '<div class="scroll-content-item ui-widget-header"><p style="float: left">'. date("M d", $newdate ).'</p> <input class="weightbox" id="dd'.$date2.'dd" style=" margin-left: 25%; height: 50px; width:50px; font-size: 20px;" value="'.$data[$date2].'" onChange="changeWeight(\''.$date2.'\', this.value);"/></div>';
			}else{
				print '<div class="scroll-content-item ui-widget-header"><p style="float: left">'. date("M d", $newdate ).'</p> <input class="weightbox" id="dd'.$date2.'dd" style=" margin-left: 25%; height: 50px; width:50px; font-size: 20px;" onChange="changeWeight(\''.$date2.'\', this.value);"/></div>';
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

<div id="here"></div>


</div>
<?php
include('footer.php');
?>