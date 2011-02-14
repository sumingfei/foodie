<?php
include('header.php');
?>

<div id="content">
<div id="container">
	<form action = "restaurantSubmission2.php" method = "post">
		<table id = "restTable" border="0">
			<tr>
				<td>Restaurant Name:</td>
				<td><input type="text" name="name" size="20" value="" /></td>
				
			<tr>
				<td>Street Address:</td>
				<td><input type="text" name="street" size="20" value="" /></td>
			</tr>
			<tr>
				<td>City:</td>
				<td><input type="text" name="city" size="20" value="" /></td>
			</tr>
			<tr>
				<td>State:</td>
				<td><input type="text" name="state" size="20" value="" /></td>
			</tr>
			<tr>
				<td>Phone Number:</td>
				<td><input type="text" name="phone" size="20" value="" /></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="restaurantSubmit" value="submit"></td>
			</tr>
		</table>
	</form>
</div> <!--close container div-->

</div> <!--close content div-->
<?php
include('footer.php');
?>