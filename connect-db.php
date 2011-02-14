<?php

$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'records';

$mysqli = new mysqli($server, $user, $pass, $db);

mysqli_report(MYSQLI_REPORT_ERROR);
$conn = mysql_connect($server, $user, $pass) or die("Error connecting to sql");

$dbname = 'records';
mysql_select_db($dbname);
?>