<?php
$_head_profile_attr = '';
if ( bb_is_profile() ) {
	global $self;
	if ( !$self ) {
		$_head_profile_attr = ' profile="http://www.w3.org/2006/03/hcard"';
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"<?php bb_language_attributes( '1.1' ); ?>>
<head<?php echo $_head_profile_attr; ?>>
	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php bb_title() ?></title>
	<link rel="stylesheet" href="<?php bb_stylesheet_uri(); ?>" type="text/css" />
<?php if ( 'rtl' == bb_get_option( 'text_direction' ) ) : ?>
	<link rel="stylesheet" href="<?php bb_stylesheet_uri( 'rtl' ); ?>" type="text/css" />
<?php endif; ?>

<?php bb_feed_head(); ?>

<?php bb_head(); ?>

</head>
<body id="<?php bb_location(); ?>">
	<div id="wrapper">
		<div id="header" role="banner">
<h1 id="title">Foodie</h1>
	<form method = "post" id="login" action="/UserManagement/signin.php" method="post">
	<label>User:</label><input id="username" name="username" type="text"/>
	<span class="error_text"><span></span></span>
	<label>Pass:</label><input id="password" name="password" type="password"/>
	<input id="submit" name="login" value="login" type="submit"/>
	<a href=/register.php>Register</a><br/>
	</form>
	
<a href="/index.php" id="foodie"></a>

<ul id="navbar">
	<li><a href="../index.php">Home |</a></li>
	<li><a href="../user.php">User |</a></li>
	<li><a href="../comments.php">Comments |</a></li>
	<li><a href="../weightlog.php">WeightLog |</a></li>
	<li><a href="../fatsecret.php">Fat Secret |</a><ul>
		<li><a href="../fatsecret2.php">Fat Secret 2</a></li>
		<li><a href="#">Second Subitem</a></li>
		<li><a href="#">Numero Tres</a></li></ul>
	</li>
	<li><a href="../restaurantSubmission.php">Restaurant |</a>
	</li>
	<li><a href="../forums">Forums</a></li>
	<!-- .. <li><a href="jobs.php">Work</a></li>  .. -->
	<!-- ... and so on ... -->
</ul>
		</div>
		<div id="main">
<?php if ( !in_array( bb_get_location(), array( 'login-page', 'register-page' ) ) ) login_form(); ?>
<?php if ( bb_is_profile() ) profile_menu(); ?>
