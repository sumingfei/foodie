<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Log in to inDinero.com</title>

	<link rel="stylesheet" type="text/css" href="/stylesheets/website/style.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/stylesheets/website/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="/stylesheets/product/login.css" media="screen" />
		
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

	<script type="text/javascript" src="/javascripts/website/jquery.innerfade.js"></script>
	<script type="text/javascript" src="/javascripts/website/init.js"></script>
	<script type="text/javascript" src="/javascripts/product/login.js"></script>
	
	<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
	
	<!--[if lte IE 6]>
	<script type="text/javascript" src="/javascripts/website/DD_belatedPNG.js"></script>
	<script type="text/javascript" src="/javascripts/website/IE6.js"></script>
	<link rel="stylesheet" href="/stylesheets/website/ie6.css" type="text/css" media="screen"/>
	<![endif]-->
	
</head>
<body>

<div id="login-box">
  <div class="logo"><a href="/"><img src="/images/logo.png" alt="" /></a></div>

	  <div id="step1">
	    
			<span class="no-logout-msg"></span>
			
			
		<fieldset>
		  <div class="message">
	      <p>Don't have an account yet? </p>
	      <p><a href="/plans"><strong>Sign up here.</strong></a></p>

	    </div><!--/end message-->
      <h2>Welcome to inDinero</h2>
      
        <form action="/login" method="post">
			<div style="margin:0;padding:0">
			<input name="authenticity_token" type="hidden" value="M6Dv6JDJDelfl7bOU34PsBn4reE83Zbwzc2Tfgn+o2M=" />
			</div>
				<input type="hidden" id="redirecturl" value="" />
				
				
        <p>
				  <label>Email:</label>
          <input class="text" id="email" name="email" type="text" />
					
				</p>

				<span class="error_text"><span></span></span>
				<p>
					<label>Password:</label>
					<input class="text" id="password" name="password" type="password" value="" />
				</p>
				
				<br>
				<span class="spacer"></span>
				<!-- INPUT TYPE MUST BE BUTTON!!! NOT IMAGE or submit. THE BELOW IMAGE IS FOUND IN  src="images/buttons/login.png" -->

				<input type="button" class="submit-login" /><br>
				</form>
			<span class="spacer"></span>
			<p><a href="/forgotpassword"><strong>Forgot your password?</strong></a></p>
			</fieldset>
			<span class="btm-border-curve"></span>
		
</div><!--/end step 1-->

<!-- STEP 2 -->

<div id="step2">
  <div id="login-connecting">
    <p>Establishing Secure Connection</p>
  <p><img src="/images/accounts-v3/ajax-loader3.gif" alt="" /></p>
  </div><!--/end modal login connecting-->
</div><!--/end step 2-->

<!-- login footer goes here -->


	<div class="login-footer">  
    <p><a href="/about/security">Learn more about privacy and security</a></p>

	<p class="copy">Copyright 2010 inDinero Inc.</p>
  </div><!--/end login footer-->
</div><!--/end login box-->
    
</body>
</html>