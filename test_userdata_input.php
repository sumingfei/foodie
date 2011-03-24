<?php
include('header.php');
include ('connect-db.php');
include('queries.php');
?>


<div id="content">
<?php
print '<h2>User Profile</h2>';
user_profile('1');
user_fitness('1');
?>
</div><!--close content div-->

<?php
include('footer.php');
?>