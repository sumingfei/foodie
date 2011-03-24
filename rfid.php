<?php
include('header.php');
echo "<div id=content>";

include('connect-db.php');
		
		if ($result = $mysqli->query("SELECT * FROM nutrition_history_test ORDER BY nutrition_id")){
			if($result->num_rows > 0){
				echo "<table id='datatable' border='1' cellpadding ='10'>";
				echo "<tr><th>nutrition_id</th><th>user_id</th><th>food_id</th></tr>";
				while($row = $result->fetch_object())
				{
					echo"<tr>";
					//echo"<th>".$row->id."</td>";
					echo"<td>".$row->nutrition_id."</td>";
					echo"<td>".$row->user_id."</td>";
					echo"<td>".$row->food_id."</td>";
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
echo"</div>";
include('footer.php');
?>
