<?php
include('connect-db.php');
		//create new record
		if(isset($_POST['restaurantSubmit'])) {
			$name = htmlentities($_POST['name'], ENT_QUOTES);
			echo $name;
			$street = htmlentities($_POST['street'], ENT_QUOTES);
			$city = htmlentities($_POST['city'], ENT_QUOTES);
			$state = htmlentities($_POST['state'], ENT_QUOTES);
			$phone = htmlentities($_POST['phone'], ENT_QUOTES);
			
			if($stmt = $mysqli->prepare("INSERT restaurant (name, street, city, state, phone) VALUES (?, ?, ?, ?, ?)")){
					$stmt->bind_param("sssss", $name, $street, $city, $state, $phone);
					$stmt->execute();
					$stmt->close();
				}else{
					echo "ERROR: could not prepare SQL";	
				}
		}
		$mysqli->close();
?>