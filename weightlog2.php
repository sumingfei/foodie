<?php
$xx = "Per 100g - Calories: 52kcal | Fat: 0.17g | Carbs: 13.81g | Protein: 0.26g";
$text = "Per 1 medium (2-3/4\" dia) (approx 3 per lb) - Calories: 61 kcal | Fat: 0.17g | Carbs: 16.33g | Protein: 0.35";
$text2 = explode(" - ", $text);
echo $text2[0]."<br/>";

$str = 'foobar: 2008';

$matches = preg_split('/\s[\d]+/i', $text2[0]);
print_r($matches);

?>