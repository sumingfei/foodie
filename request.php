<?php
require_once('lib/FatSecretAPI.php');
require_once('lib/config.php');
$API = new FatSecretAPI(API_KEY, API_SECRET);

function parseMeasurement($text){
$xx = explode(' - ', $text);
$kcal = preg_split('/[\|\:]/', $xx[1]);
$num_kcal = preg_split('/kcal/', $kcal[1]);
return $num_kcal[0];
}

if(isset($_GET['search_term'])){
	$search_term = $_GET['search_term'];
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}else{
		$page = 0;
	}
	$result = $API->searchFoods2($search_term, $page);
	echo $result;
}else{
	echo "ERROR: search_term not set";	
}
?>