<?php
include('connect-db.php');

if(isset($_GET['user_id'])){ //retrieve nutrition data
	$user_id = $_GET['user_id'];
	if($stmt = $mysqli->prepare("SELECT meal_date, sum(calorie), fat, carb, protein FROM nutrition_history WHERE user_id=1234 GROUP BY meal_date")){
		$stmt->execute();
		$stmt->bind_result($meal_date, $calorie, $fat, $carbohydrate, $protein);
		//$data;
		echo $calorie;
		$i = 0;
		$md; $cal; $f; $car; $pro;
		while($stmt->fetch()){
			$md[$i] = date("M d", strtotime($meal_date));
			$cal[$i] = (int)$calorie;
			$f[$i] = $fat;
			$car[$i] = $carbohydrate;
			$pro[$i] = $protein;
			$i++;
		};
		
		$data = Array("meal_date"=>$md,
			"calorie"=>$cal,
			"fat"=>$f,
			"carbohydrate"=>$car,
			"protein"=>$pro);
			
		$result = json_encode($data);
		$stmt->close();
		print $result;
	}else{
		echo "ERROR: could not prepare SQL";	
	}
}
else{
	echo "ERROR: missing user_id";	
}

$mysqli->close();



//$result = $API->getFood($food_id); 

//echo $result->food->food_name;

?>