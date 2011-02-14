<?php
require_once('lib/FatSecretAPI.php');
require_once('lib/config.php');
$API = new FatSecretAPI(API_KEY, API_SECRET);

$food_id = $_GET['food_id'];

$result = $API->getFood($food_id); 

//echo $result->food->food_name;
echo $result;
?>