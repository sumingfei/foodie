<?php
include('header.php');
?>
<script>
$(function() {
	$("#fitness_search_input").submit(function(){
			$.ajax({
				type 	: "GET",
				url 	: "getExcercise.php",
				dataType: "json",
				data	: {"fitness_search_term" : $("#fitness_search_term").val()},
				success : function(response)
				{
					$(".exercise_box").remove();
					if(response == "error"){
						$("#fitness_search_result").append("<table class='exercise_box'>No results found</table>");
					}else{
						//console.debug(response.exercise[0]);
						
						create = "<table class='exercise_box'>";
						for(var i = 0; i < response.size; i++){
							create += "<tr><td>"+response.exercise[i]+"</td><td>"+response.MET[i]+"</td></tr>";
						}
						create += "</table>";
						$("#fitness_search_result").append(create);
						
					}
				}
			});
			return false;
		});
});
</script>
<div id="content">

<form id="fitness_search_input" name="fitness_search_input">
	<input type="text" value="" id="fitness_search_term" name="fitness_search_term" />
	<input type="submit" value="Search" />
</form>
<div id="fitness_search_result"><table class="exercise_box"></table></div>

</div>
<?php
include('footer.php');
?>