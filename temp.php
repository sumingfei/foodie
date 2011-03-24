<?php
include('connect-db.php');

if(isset($_GET['fitness_search_term'])){
	$search_term = $_GET['fitness_search_term'];
	echo $search_term;
}else{
	
			echo "No results to display!";	
	
}


?>