<?php
include('connect-db.php');

if(isset($_GET['user_id'])){ //retrieve nutrition data
	$user_id = $_GET['user_id'];
	$x = 12;
	$newdate = strtotime(-$x."day", time());
	$date2 = date("Y-m-d", $newdate);
	if($stmt = $mysqli->prepare("SELECT date,weight FROM weight_history WHERE date > '".$date2."'")){
		$stmt->execute();
		$stmt->bind_result($date, $weight);
		$i = 0;
		$d; $w;
		while($stmt->fetch()){
			$d[$i] = date("M d", strtotime($date));
			$w[$i] = $weight;
			$i++;
		};
		//$here = Array(7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6);
		//print_r($here);
		
		$data = Array("date"=>$d,
			"weight"=>$w);
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