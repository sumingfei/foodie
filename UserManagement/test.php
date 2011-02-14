<?php
/* 
-------------------------------------------------------------------------
project: Sharp User Management System
author : Denon Studio (denonstudio.net)
url    : http://codecanyon.net/denonstudio
license: http://codecanyon.net/wiki/support/legal-terms/licensing-terms/
-------------------------------------------------------------------------
*/

include_once("includes.php");

$auth = new TAuthentication();
$auth_result = $auth->validateSession(array( "admin"));

switch ($auth_result->auth_code)
{
    case AUTH_OKAY :
        echo "Signed in";
        echo "<pre>";
        print_r($auth_result->account);
        echo "</pre>";
    break;
    
    case AUTH_NO_SESSION :
        echo "Not signed in";
    break;
    
    case AUTH_INSUFFICIENT_ROLES :
        echo "Missing roles for viewing content!";
        echo "<pre>";
        print_r($auth_result->roles);
        echo "</pre>";
    break;
}
?>