<?php

$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'foodie';

$mysqli = new mysqli($server, $user, $pass, $db);

mysqli_report(MYSQLI_REPORT_ERROR);
$conn = mysql_connect($server, $user, $pass) or die("Error connecting to sql");

$dbname = 'foodie';
mysql_select_db($dbname);
?>