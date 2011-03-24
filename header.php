<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Foodie</title>
<!-- 
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.8/themes/base/jquery-ui.css" type="text/css" media="all" />
-->
<link rel="stylesheet" href="js/jquery-ui.css" type="text/css" media="all" />
<link rel="stylesheet" href="styles/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="styles/main.css" type="text/css"/>
<link rel="stylesheet" href="styles/custom.css" />

<!-- 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
-->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script language="JavaScript">
<!--hide from Javascript-challanged browsers

function openWindow(url){
popupWin=window.open(url,'remote','status=0,width=300,height=400')
if (window.focus) {popupWin.focus()}
	return false;
}
sfHover = function() {
	var sfEls = document.getElementById("navbar").getElementsByTagName("li");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" hover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" hover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);
//done hiding-->
</script>

</head>
<body>
<div id="page">
<div id="headerimg">
<a href="index.php" id="foodie"></a>
	<form method = "post" id="login" action="UserManagement/signin.php" method="post">
	<label>User:</label><input id="username" name="username" type="text"/>
	<span class="error_text"><span></span></span>
	<label>Pass:</label><input id="password" name="password" type="password"/>
	<input id="submit" name="login" value="login" type="submit"/>
	<a href=register.php>Register</a><br/>
	</form>
	
<ul id="navbar">
	<li><a href="index.php">Dashboard </a></li>
	<li><a href="nutritionlog.php">Nutrition Log </a></li>
	<li><a href="weightlog.php">Weight Log </a></li>
	<li><a href="calendar.php">Calendar </a></li>
	<li><a href="rfid.php">RFID </a></li>
	<li><a href="restaurantSubmission.php">Restaurant </a></li>
	<li><a href="./forums">Forums</a></li>
	<!-- .. <li><a href="jobs.php">Work</a></li>  .. -->
	<!-- ... and so on ... -->
</ul>
</div>