<?php
include('header.php');
?>
<div id="content">
	<style>
	.scroll-pane { overflow: auto; width: 70%; float:left; }
	.scroll-content { width: 1700px; float: left; }
	.scroll-content-item { width: 100px; height: 100px; float: left; margin: 5px; font-size: 1em; line-height: 0px; }
	* html .scroll-content-item { display: inline; } /* IE6 float double margin bug */
	.scroll-bar-wrap { clear: left; padding: 0 4px 0 2px; margin: 0 -1px -1px -1px; }
	.scroll-bar-wrap .ui-slider { background: none; border:0; height: 2em; margin: 0 auto;  }
	.scroll-bar-wrap .ui-handle-helper-parent { position: relative; width: 100%; height: 100%; margin: 0 auto; }
	.scroll-bar-wrap .ui-slider-handle { top:.2em; height: 1.5em; }
	.scroll-bar-wrap .ui-slider-handle .ui-icon { margin: -8px auto 0; position: relative; top: 50%; }
	</style>
	<script>
	function changeWeight(date, weight){
		//$("#here").append('<div>'+date+' '+weight+'</div>');
		$.ajax({
				type	: "GET",
				url		: "saveWeight.php",
				data	: {"date": date, "weight": weight},
				success : function(response)
				{
					$("#here").append('<div>'+date+' '+weight+'</div>');
				}
		});
	}
	function weightSubmit(){
		$date = $("#datepicker").val();
		$weight = $("#weightpicker").val();
		console.debug($date);
		changeWeight($date, $weight);
	}
	$(function() {
		$( "#datepicker" ).datepicker({
			showOn: "both",
			buttonImage: "images/calendar.gif",
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
	</script>

<div class="scroll-pane ui-widget ui-widget-header ui-corner-all">
	<div class="scroll-content">
		<?php
		for($i = 14; $i >= 0; $i--){
		$newdate = strtotime(-$i."day", time());
		$date2 = date("m/d/Y", $newdate);
		print '<div class="scroll-content-item ui-widget-header"><p style="float: left">'. date("M d", $newdate ).'</p> <input style=" margin-left: 25%; height: 50px; width:50px; font-size: 20px;" onChange="changeWeight(\''.$date2.'\', this.value);"/></div>';
		//print '<div class="scroll-content-item ui-widget-header">'. $i.'</div>';
		}
		//print '<div>'. (time()/86400).'</div>';
		?>
	</div>
	<div class="scroll-bar-wrap ui-widget-content ui-corner-bottom">
		<div class="scroll-bar"></div>
	</div>
</div>

<div style="height: 606px;" id="sidebar">
		<form method="get" action="">
		<h2>Enter New Weight</h2>
			<input name="date" value="Enter Date" id="datepicker" onclick="this.value='';" type="text">
			<input name="weight" value="Enter Weight" id="weightpicker" onclick="this.value='';" type="text">
			<a href="javascript:weightSubmit()">Submit</a>
			<h1>look here</h1>
			<div id="here"></div>
		</form>	
</div>



</div>
<?php
include('footer.php');
?>