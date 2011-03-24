<?php

include('connect-db.php');
print "<div> this page </div>\n";

echo '<pre>'; print_r($_GET); echo '</pre>';

if(isset($_GET)){
	foreach($_GET as $user_id=>$food_id){
		$food_id_array = explode(",", $food_id);
		
		foreach($food_id_array as $food_id_x){
			if($stmt = $mysqli->prepare("INSERT INTO nutrition_history_test (user_id, food_id) VALUES(?,?);")){
							$stmt->bind_param("ss", $user_id, $food_id_x);
							$stmt->execute();
							$stmt->close();
			}else{
					echo "ERROR: could not prepare SQL";	
			}
		}
	}
}else{
	echo "Error: post not set";

}
?>