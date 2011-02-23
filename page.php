<?php
include("header.php");
?>
<div id="content">
<?php
$my_username = "USERNAME";
$my_password = "PASSWORD";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid ID specified.";
	include("footer.php");
}

$id = (int)$_GET['id'];
$sql = "SELECT * FROM blog WHERE id='$id' LIMIT 1";

$result = mysql_query($sql) or print ("Can't select entry from table blog.<br />" . $sql . "<br />" . mysql_error());

while($row = mysql_fetch_array($result)) {

    $date = date("F jS Y", strtotime($row['timestamp']));

    $title = stripslashes($row['title']);
    $entry = stripslashes($row['entry']);
    $password = $row['password'];
	echo '<div id="entry">';
    if ($password == 1) {
         if (isset($_POST['username']) && $_POST['username'] == $my_username) {
             if (isset($_POST['pass']) && $_POST['pass'] == $my_password) {
                 ?>
				
                 <h3><?php echo $title; ?></h3>
                 <?php echo $entry; ?><br /><br />
                 Posted on <?php echo $date; ?></p>

                <?php
             }
             else { ?>
                 <p>Sorry, wrong password.</p>

                 <?php
             }
         }
         else {
            echo "<h3>" . $title . "</h3>";

            printf("<p>This is a password protected entry. If you have a password, log in below.</p>");

            printf("<form method=\"post\" action=\"journal.php?id=%s\"><p><strong><label for=\"username\">Username:</label></strong><br /><input type=\"text\" name=\"username\" id=\"username\" /></p><p><strong><label for=\"pass\">Password:</label></strong><br /><input type=\"password\" name=\"pass\" id=\"pass\" /></p><p><input type=\"submit\" name=\"submit\" id=\"submit\" value=\"submit\" /></p></form>",$id);
            print "<hr /><br /><br />";
        }
    }
    else { ?>

        <p><strong><?php echo $title; ?></strong><br /><br />
        <?php echo $entry; ?><br /><br />
        Posted on <?php echo $date; ?></p>

        <?php
    }
}
date_default_timezone_set('America/Chicago');
$commenttimestamp = date("Y-m-d-H:i:s",time());
echo '</div>';

$sql = "SELECT * FROM blog_comments WHERE entry='$id' ORDER BY timestamp DESC";
$result = mysql_query ($sql) or print ("Can't select comments from table blog_comments.<br />" . $sql . "<br />" . mysql_error());
while($row = mysql_fetch_array($result)) {
    $timestamp = date("l F jS Y", strtotime($row['timestamp']));
    printf("<hr />");
    print("<p>" . stripslashes($row['comment']) . "</p>");
	if(stripslashes($row['url'])==""){
		printf("<p>Comment by %s @ %s</p>", stripslashes($row['name']), $timestamp);
	}
	else{
		printf("<p>Comment by <a href=\"%s\">%s</a> @ %s</p>", stripslashes($row['url']), stripslashes($row['name']), $timestamp);
	}
    printf("<hr />");
}
if (isset($_POST['submit_comment'])) {
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['comment']) || empty($_POST['spam'])) {
        echo "<div style=\"color:#ff0000\"><h3 id=\"reply\">Error</h3>You have forgotten to fill in one of the required fields! Please make sure you submit a name, e-mail address and comment. Click the back button to go back and try again.</div>";
		echo '</div>';
		include("footer.php");
		return false;
	}
	if ($_POST['spam'] != "Not Spam") {
		echo "<div style=\"color:#ff0000\"><h3 id=\"reply\">Error</h3>Please re-submit your comment with the correct words in the anti-spam box.</div>";
		echo '</div>';
		include("footer.php");
		return false;
	}
	else {
		echo "<h3 id=\"reply\">Success</h3>Your comment has been successfully submitted. Please refresh the page to see it.";
	}
    $entry = htmlspecialchars(strip_tags($_POST['entry']));
    $timestamp = htmlspecialchars(strip_tags($_POST['timestamp']));
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $url = htmlspecialchars(strip_tags($_POST['url']));
    $comment = htmlspecialchars(strip_tags($_POST['comment']));
    $comment = nl2br($comment);

    if (!get_magic_quotes_gpc()) {
        $name = addslashes($name);
        $url = addslashes($url);
        $comment = addslashes($comment);
    }

    if (!eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) {
         echo "The e-mail address you submitted does not appear to be valid. Please go back and correct it";
		 echo '</div>';
		 include("footer.php");
		 return false;
    }
    $result = mysql_query("INSERT INTO blog_comments (entry, timestamp, name, email, url, comment) VALUES ('$entry','$timestamp','$name','$email','$url','$comment')");
	//email comment
	$youraddress = "sue@endless-sonata.net";
    $emailsubject = "New comment on entry #" . $entry;
    $bodyemail = "A new comment was posted \nName: " . $name . "\nEmail: " . $email . "\nUrl: " . $url. "\nDate submitted: " . date('d.m.y \a\\t H:i',strtotime($timestamp)) . "\nMessage:" . $comment;
    $extra = "From: Blog <" . $youraddress . ">\r\n" . "X-Mailer: PHP/" . phpversion();
    mail($youraddress, $emailsubject, $bodyemail, $extra);
}
?>
<h3 id="reply">Leave a Reply</h3>
<blockquote>
Thank you for taking the time to leave a message. 
Your comment is much appreciated. Also, please leave a comment relevant to the posted topic. 
<!--If this is your first time commenting, your comment will be held for moderation before being 
displayed. If you would like a custom avatar to appear beside your message, please sign up 
for an account on <a href="http://gravatar.com">Gravatar</a>-->
</blockquote>
<form method="post" action="journal.php?id=<?php echo $id ?>#reply" id="commentform">
<form method="post" action="journal.php?id=<?php echo $id ?>#reply" id="commentform">

<p><input type="hidden" name="entry" id="entry" value="<?php echo $id; ?>" />

<input type="hidden" name="timestamp" id="timestamp" value="<?php echo $commenttimestamp; ?>">

 <input type="text" name="name" id="name" size="28" /><strong><label for="name"> Name (required)</label></strong><br />

 <input type="text" name="email" id="email" size="28" /><strong><label for="email"> E-mail (required but will not publish)</label></strong><br />

 <input type="text" name="url" id="url" size="28" value="" /><strong><label for="url"> URL</label></strong><br />

<textarea cols="25" rows="5" name="comment" id="comment"></textarea></p>
<strong><label for="spam">Type </label><img src="spam.png" alt="spam"/><input type="text" name="spam" id="spam" size="20" value="" /><br />
<p><input type="submit" name="submit_comment" id="submit_comment" value="Add Comment" /></p>

</form>
</div>
<?php include("footer.php"); ?>