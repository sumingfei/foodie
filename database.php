<?php
/* This is the page that creates tables for the blog and other parts of the site */
include("$_SERVER[DOCUMENT_ROOT]/connect-db.php");
$sql2 = "CREATE TABLE blog_comments (
  id int(20) NOT NULL auto_increment,
  entry int(20) NOT NULL,
  name varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  url varchar(255) NOT NULL,
  comment longtext NOT NULL,
  timestamp datetime NOT NULL,
  PRIMARY KEY  (id)
)";

$result2 = mysql_query($sql2) or print ("Can't create the table 'blog_comments' in the database.<br /><br />" . mysql_error());
if ($result2 != false) {
    echo "Table 'blog_comments' was successfully created.";
}
mysql_close();
?>