<?php
/* 
-------------------------------------------------------------------------
project: Sharp User Management System
author : Denon Studio (denonstudio.net)
url    : http://codecanyon.net/denonstudio
license: http://codecanyon.net/wiki/support/legal-terms/licensing-terms/
-------------------------------------------------------------------------
*/

//session_save_path("/home/users/web/b828/moo.armanm/cgi-bin/tmp"); 
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('UPDATE_DISABLED', true);

define('REL_APP_FOLDER', 'Foodie/UserManagement');

define('APP_FOLDER'    , realpath(dirname(__FILE__))        );
define('VIEWS_FOLDER'  , APP_FOLDER . '/_application/views' );
define('MODELS_FOLDER' , APP_FOLDER . '/_application/models');
define('EMAILS_FOLDER' , APP_FOLDER . '/_application/emails');
define('SITE_URL'      , "http://" . $_SERVER["HTTP_HOST"] . "/" . REL_APP_FOLDER); 


/* Config */
include_once(APP_FOLDER . "/_application/config/config.php");

/* Library */
include_once(APP_FOLDER . "/_application/core/Email.php"                 );
include_once(APP_FOLDER . "/_application/core/TAuthentication.php"       );
include_once(APP_FOLDER . "/_application/core/TUtilities.php"            );
include_once(APP_FOLDER . "/_application/core/TPagination.php"           );
include_once(APP_FOLDER . "/_application/core/TAbstractEmailTemplate.php");

/* Controllers */
include_once(APP_FOLDER . "/_application/core/TAbstractController.php");

/* Model */
include_once(APP_FOLDER . "/_application/core/TAbstractModel.php");

/* Exceptions */
include_once(APP_FOLDER . "/_application/core/TExceptions.php");

/* Database */
include_once(APP_FOLDER . "/_application/core/TDatabase.php");


?>