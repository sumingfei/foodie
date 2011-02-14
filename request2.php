<?php
require_once('lib/FatSecretAPI.php');
require_once('lib/config.php');
$API = new FatSecretAPI(API_KEY, API_SECRET);

$search_term = $_GET['search_term'];

//echo printResults($search_term, $API);
$result = new simpleXMLElement($API->searchFoods($search_term));
	$foods = $result->food;
	$num_from = $result->page_number+1;
	$num_to = $num_from + $result->max_results - 1;
	
print '<table class="fatsecret_foodsearch_results" cellpadding="0" cellspacing="0">
		<tbody><tr>
		<td class="fatsecret_subheading fatsecret_borderbottom">Search results for: '.$search_term.'</td>
		<td class="fatsecret_foodsearch_total fatsecret_borderbottom" align="right">'.$num_from.' to '.$num_to.' of '.$result->total_results.'</td>
		</tr>';
		
foreach ($foods as $food){
		print '<tr><td class="fatsecret_borderbottom" colspan="2">';


		print '<a class="fatsecret_foodsearch_result_link" href="#" onclick="">';
		
		print '<span class="fatsecret_foodsearch_result_highlight">'.$food->food_name.'</span></a>
		<a class="fatsecret_ate_this" href="#">ate this</a>
		<div>'. $food->food_description .'</div></td></tr>';
	}
print '</tbody></table>';
?>