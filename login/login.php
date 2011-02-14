<?php
	session_start();

if (isset($_SESSION['name'])) {
	//already logged in, redirect to main page
	header("Location: main.php");
}
elseif (!isset($_SESSION['name']) && !isset($_POST['username'])){
    // if form has not been submitted, display the form
}
else {
	// form submitted, check for required values
    if (empty($_POST['username'])) {
        die ("<p>ERROR: Please enter username!</p>");
    }
    if (empty($_POST['password'])) {
        die ("<p>ERROR: Please enter password!</p>");
    }

    // set server access variables
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "records";
    
    // open connection
    $mysqli = new mysqli($host, $user, $pass, $db);
    
	/* check connection */
	if (mysqli_connect_errno()) {
		echo "Connect failed: ".mysqli_connect_error();
		exit();
	}
    
    // create query
	if($stmt = $mysqli->prepare("SELECT * FROM users WHERE username=? AND password=?")) {
		$stmt->bind_param('ss', $username, $password);
		$username = stripslashes($_POST['username']);
		$password = stripslashes($_POST['password']);
		$username = mysqli_real_escape_string($mysqli,$username);
		$password = mysqli_real_escape_string($mysqli,$password); //TO DO: encrypt with md5() or sha1() etc
		$stmt->execute();
		
		if($stmt->fetch()) {
			$_SESSION['name'] = $username;
			//redirect to main page
			header("Location: main.php");
		}
		else {
			// no result
			// authentication failed
			echo "ERROR: Incorrect username or password!";
			session_destroy();
		}
		
		$stmt->close();	
	}
	else {
		/* Error */
		echo "Prepared Statement Error: ". $mysqli->error;
	}
    
    $mysqli->close();
}
?>