<?php
include('connect-db.php');


if(isset($_POST['myList']) && isset($_POST['length'])){ //save nutrition data
	$data = $_POST['myList'];
	$length = $_POST['length'];
	
	$i;
	for($i = 0; $i < $length; $i++){
		$name = $data[$i]['name'];
		$type = $data[$i]['type'];
		$calorie = $data[$i]['calorie'];
		
		if($stmt = $mysqli->prepare("INSERT INTO exercises_temp (exercise_name, type, calorie) VALUES(?, ?, ?);")){
			$stmt->bind_param("ssi", $name, $type, $calorie);
			$stmt->execute();
			$stmt->close();
		}else{
			echo "ERROR: could not prepare SQL";	
		}
	}
}else{
	echo "MISSING: nutList";
}
?>