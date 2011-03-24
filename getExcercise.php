<?php
include('connect-db.php');

if(isset($_GET['fitness_search_term'])){
	$search_term = $_GET['fitness_search_term'];
	if ($stmt = $mysqli->prepare("SELECT exercise, MET FROM exercises WHERE exercise LIKE '%".$search_term."%'")){
		$stmt->execute();
		$stmt->bind_result($exe, $met);
		$i = 0;
		$exercise; $MET;
		while($stmt->fetch()){
			$exercise[$i] = $exe;
			$MET[$i] = $met;
			$i++;
		};
		if($i>0){
			$data = Array("size"=>$i++,
				"exercise"=>$exercise,
				"MET"=>$MET);
			$result = json_encode($data);
			$stmt->close();
			print $result;
		}else{
			echo json_encode("error");
		}
	}else{
		echo "ERROR: " . $mysqli->error;
	}
}else{
	if ($result = $mysqli->query("SELECT * FROM exercises;")){
		if($result->num_rows > 0){
			echo "<table id='datatable' border='1' cellpadding ='10'>";
			echo "<tr><th>id</th><th>Exercise</th><th>MET</th></tr>";
			while($row = $result->fetch_object())
			{
				echo"<tr>";
				echo"<td>".$row->exercise_id."</td>";
				echo"<td>".$row->exercise."</td>";
				echo"<td>".$row->MET."</td>";
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
}
$mysqli->close();


?>