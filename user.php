<?php
include('header.php');
?>
<link media="screen" rel="stylesheet" href="styles/colorbox.css" />
<script type="text/javascript" src="js/highcharts.js"></script>
<script type="text/javascript" src="js/graph.js"></script>

<script type="text/javascript" src="js/facebox.js"></script>
<script src="js/jquery.colorbox.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		//Examples of how to assign the ColorBox event to elements
		$("a[rel='example1']").colorbox();
		$("a[rel='example2']").colorbox({transition:"fade"});
		$("a[rel='example3']").colorbox({transition:"none", width:"75%", height:"75%"});
		$("a[rel='example4']").colorbox({slideshow:true});
		$(".example5").colorbox();
		$(".example6").colorbox({iframe:true, innerWidth:425, innerHeight:344});
		$(".example7").colorbox({width:"80%", height:"80%", iframe:true});
		$(".example8").colorbox({width:"50%", inline:true, href:"#inline_example1"});
		$(".example9").colorbox({
			onOpen:function(){ alert('onOpen: colorbox is about to open'); },
			onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
			onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
			onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
			onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
		});
		
		//Example of preserving a JavaScript event for inline calls.
		$("#click").click(function(){ 
			$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
			return false;
		});
	});
</script>
 
<div id="content">
<h3 class="first">User Information</h3>
<table><tr><td>
<a class='example5' href="user/nutrition.html" id="nutrition" title="nutrition">Track Nutrition</a>
<a class='example5' href="user/workout.php" id="workout" title="workout">Track Workout</a>
<a class='example5' href="user/body.php" id="body" title="body">Track Body</a></td>
	<td valign="top">
	<div id="container" style="width: 600px; height: 300px; margin: 0 auto"></div>
	</td></table>

<?php
		include('connect-db.php');
		
		if ($result = $mysqli->query("SELECT * FROM nutrition_history ORDER BY id")){
			if($result->num_rows > 0){
				echo "<table id='datatable' border='1' cellpadding ='10'>";
				echo "<tr><th>???</th><th>Calorie</th><th>Fat</th><th>Carbohydrate</th><th>Protein</th></tr>";
				while($row = $result->fetch_object())
				{
					echo"<tr>";
					//echo"<th>".$row->id."</td>";
					echo"<th>".$row->food_id."</th>";
					echo"<td>".$row->calorie."</td>";
					echo"<td>".$row->fat."</td>";
					echo"<td>".$row->carb."</td>";
					echo"<td>".$row->protein."</td>";
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
		$mysqli->close()
	
	?>
	<table id="datatable2">
		<thead>
			<tr><th></th>
				<th>Jane</th>
				<th>John</th>
			</tr>
		</thead>
			<tbody>
			<tr>
				<th>Apples</th>
				<td>3</td>
				<td>4</td>
			</tr>
			<tr>
					<th>Pears</th>
				<td>2</td>
				<td>0</td>
			</tr>
			<tr>
				<th>Plums</th>
				<td>5</td>
					<td>11</td>
			</tr>
			<tr>
				<th>Bananas</th>
				<td>1</td>
				<td>1</td>
			</tr>
			<tr>
				<th>Oranges</th>
				<td>2</td>
				<td>4</td>
			</tr>
		</tbody>
	</table>
</div><!--close content div-->
<?php
include('footer.php');
?>