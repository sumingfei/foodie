<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript">
	$(function(){
		$("#search_input").submit(function(){
			$.ajax({
				type 	: "GET",
				url 	: "request2.php",
				data	: {"search_term" : $("#search_term").val() },
				success : function(response)
				{
					$("#search_result table").fadeOut("fast", function()
					{
						$("#search_result table").remove();
						$("#search_result").append($(response).hide().fadeIn());
					});

				}
			});
			return false;
		});
	});
</script>

<form id="search_input" name="search_input">
	<input type="text" value="" id="search_term" name="search_term" />
	<input type="submit" value="Search" />
</form>

<div id="search_result">
	<table></table>
</div>



