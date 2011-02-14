<?php
session_start();
?>

<html>
<head>
<title>Main Page</title>
<link href="lib/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>

	<?php
	if(!isset($_SESSION['name'])){
		//redirect to login page
		session_destroy();
		header("Location: login.php");
	}

	echo "<p>You are logged in as ". $_SESSION['name']. ". Click <a href='logout.php'>here</a> to logout</p>";
	?>
	
	<FORM ACTION="xml.php" METHOD="post">
		<table border="0">
			<tr>
				<td>Food Name</td>
				<td><input type="text" name="name" class="input" size="20" maxlength="250"></td>
			</tr>
			<tr>
				<td>Calorie</td>
				<td><input type="text" name="calorie" class="input" size="20" maxlength="10"></td>
			</tr>
			<tr>
				<td>Fat</td>
				<td><input type="text" name="fat" class="input" size="20" maxlength="10"></td>
			</tr>
			<tr>
				<td>Carbohydrate</td>
				<td><input type="text" name="carb" class="input" size="20" maxlength="10"></td>
			</tr>
			<tr>
				<td>Protein</td>
				<td><input type="text" name="protein" class="input" size="20" maxlength="10"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" value="submit"></td>
			</tr>
		</table>
	</FORM>
	

</body>
</html>