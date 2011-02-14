<?php
include('header.php');
?>
<div id="content">
<script src="http://platform.fatsecret.com/js?key=3d4a31a60c134d80b5da143a6154625c&auto_load=true&auto_template=false"></script>
<div id="search"></div>
<div id="result"></div>
<script>
fatsecret.addRef("search", "search");
fatsecret.addRef("result", "result");
</script>

<div id="food_title"></div>
<div id="nutrition_panel"></div> <!-- not in use -->
<div id="serving_entry"></div> 
<script>
fatsecret.addRef("foodtitle", "food_title");
fatsecret.addRef("nutritionpanel", "nutrition_panel");
fatsecret.addRef("servingentry", "serving_entry");
</script>

<a onclick='fatsecret.replaceCanvas("food.get", {food_id: "35718"})'> click this </a>
<p></p>
<a onclick='fatsecret.replaceCanvas("foods.search", {search_expression: "pizza"})'> click that </a>
</div>
<?php
include('footer.php');
?>