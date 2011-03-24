<?php
include('connect-db.php');
/*
*$text = "Per 100g - Calories: 52kcal | Fat: 0.17g | Carbs: 13.81g | Protein: 0.26g";
*into: Array ( [0] => [1] => 52 [2] => [3] => 0.17 [4] => [5] => 13.81 [6] => [7] => 0.26 [8] => ) 
*/
function parseMeasurement($text){
	$xx = explode(' - ', $text);
	$kcal = preg_split('/([A-Za-z]*[\s\|\:]+)|(g)/', $xx[1]);
	return $kcal;
}

if(isset($_POST['nutList']) && isset($_POST['date'])){ //save nutrition data
	$data = $_POST['nutList'];
	$length = sizeof($data['entries']);
	$meal_date = Date("Y-m-d", strtotime($_POST['date']));
	$i;
	for($i = 0; $i < $length; $i++){
		$myEntry = $data['entries'][$i];
		$food_id = $myEntry['food_id'];
		$user_id = $myEntry['user_id'];
		$foodInfo = parseMeasurement($myEntry['food_desc']);
		$calorie = $foodInfo[1];
		$fat = $foodInfo[3];
		$carb = $foodInfo[5];
		$protein = $foodInfo[7];
		//$meal_date = Date("Y-m-d", strtotime($myEntry['date']));
		$meal_time = $myEntry['meal_time'];

		if($stmt = $mysqli->prepare("INSERT INTO nutrition_history (food_id, user_id, calorie, fat, carb, protein, meal_date, meal_time) VALUES(?, ?, ?, ?, ?, ?, ?, ?);")){
			$stmt->bind_param("iiiiiiss", $food_id, $user_id, $calorie, $fat, $carb, $protein, $meal_date, $meal_time);
			$stmt->execute();
			$stmt->close();
		}else{
			echo "ERROR: could not prepare SQL";	
		}
	}
	/*
	if($stmt = $mysqli->prepare("INSERT INTO weight_history (date, weight) VALUES(?, ?) ON DUPLICATE KEY UPDATE weight=?;")){
		$stmt->bind_param("sii", $date, $weight, $weight);
		$stmt->execute();
		$stmt->close();
	}else{
		echo "ERROR: could not prepare SQL";	
	}
	*/
}else{
	echo "MISSING: nutList";
}
?>