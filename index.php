<?php
include('header.php');
?>
<script>
$(function() {

	$("ul.css-tabs").tabs("div.css-panes > div", {effect: 'ajax'});

});
</script>


<div id="content">

<!-- tabs -->
<ul class="css-tabs">
	<li><a href="test2.html">fs_search</a></li>
	<li><a href="jobs2.php">Jobs</a></li>
	<li><a href="request.php?search_term=apple">search_apple</a></li>
</ul>

<!-- single pane. it is always visible -->
<div class="css-panes">
	<div style="display:block"></div>
</div>








</div><!--close content div-->

<?php
include('footer.php');
?>