<?php
require_once('lib/FatSecretAPI.php');
require_once('lib/config.php');
$API = new FatSecretAPI(API_KEY, API_SECRET);

$search_term = $_GET['search_term'];

function parseMeasurement($text){
$xx = explode(' - ', $text);
$kcal = preg_split('/[\|\:]/', $xx[1]);
$num_kcal = preg_split('/kcal/', $kcal[1]);
return $num_kcal[0];
}

//echo printResults($search_term, $API);
$result = new simpleXMLElement($API->searchFoods($search_term));
	$foods = $result->food;
	$num_from = $result->page_number+1;
	$num_to = $num_from + $result->max_results - 1;
	
print '<table id="result_table" class="fatsecret_foodsearch_results" cellpadding="0" cellspacing="0">
		<tbody><tr>
		<td class="fatsecret_subheading fatsecret_borderbottom">Search results for: '.$search_term.'</td>
		<td class="fatsecret_foodsearch_total fatsecret_borderbottom" align="right">'.$num_from.' to '.$num_to.' of '.$result->total_results.'</td>
		</tr>';
		$i = 1;
foreach ($foods as $food){
		print '<div id="entry"><tr><td class="fatsecret_borderbottom" colspan="2">';
		print '<div style="display:inline"><a class="fatsecret_foodsearch_result_link" href="#" onclick=
		"javascript:displayNut()">';
		print '<span class="drag" id="'.$i.'" food_id="'.$food->food_id.'" food_cal="'.parseMeasurement($food->food_description).'" food_desc="'.$food->food_description.'">'.$food->food_name.'</span></a></div>
		<div style="display:inline" class="change_serving"><a id="change_serving'.$i.'" href="javascript:changeServing('.$food->food_id.', '.$i.');" style="color:red;">change serving</a></div>
		<div id="serving_box" class="serving_box"></div>
		<div id="food_id" style="display:none;">'.$food->food_id.'</div>
		<div id="food_description'.$i.'" style="display: block" class="food_description">'. $food->food_description .'</div></td></tr></div>';
		$i++;
	}
print '</tbody></table>';
?>