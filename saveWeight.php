<?php
include('connect-db.php');

if(isset($_GET['date']) && is_numeric($_GET['weight'])){ //save weight data
	$date = $_GET['date'];
	$weight = $_GET['weight'];
	if($stmt = $mysqli->prepare("INSERT INTO weight_history (date, weight) VALUES(?, ?) ON DUPLICATE KEY UPDATE weight=?;")){
		$stmt->bind_param("sii", $date, $weight, $weight);
		$stmt->execute();
		$stmt->close();
	}else{
		echo "ERROR: could not prepare SQL";	
	}
}
else{ //retrieve weight data
	if($stmt = $mysqli->prepare("SELECT date,weight FROM weight_history WHERE timestamp > (SELECT DATE_SUB(now(), INTERVAL 14 day))")){
		$stmt->execute();
		$stmt->bind_result($date, $weight);
		$data;
		while($stmt->fetch()){
			$data[$date] = $weight;
		}
		$result = json_encode($data);
		$stmt->close();
		echo $result;
	}else{
		echo "ERROR: could not prepare SQL";	
	}
	/*
	for($i = 14; $i >= 0; $i--){
			$newdate = strtotime(-$i."day", time());
			$date2 = date("m/d/Y", $newdate);
			echo $data[$date2];
			print '<div class="scroll-content-item ui-widget-header"><p style="float: left">'. date("M d", $newdate ).'</p> <input style=" margin-left: 25%; height: 50px; width:50px; font-size: 20px;" onChange="changeWeight(\''.$date2.'\', this.value);"/></div>';
		
		}
		*/
}

$mysqli->close();


?>