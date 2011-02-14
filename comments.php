<?php include("header.php");
include ("connect-db.php");
?>
<div id="content">
<?php //select blog_comments table
$sql = "SELECT * FROM blog_comments ORDER BY timestamp DESC";
$result = mysql_query ($sql) or print ("Can't select comments from table blog_comments.<br />" . $sql . "<br />" . mysql_error());
//fetch database results and print each comment
$i = 0;
while($row = mysql_fetch_array($result)) {
	$i++;
    //$timestamp = date("l F jS Y", strtotime($row['timestamp']));
	$timestamp = $row['timestamp'];
	print("<div class=\"d".($i & 1)."\">");
    print("<p>" . stripslashes($row['comment']) . "</p>");
	if(stripslashes($row['url'])==""){
		printf("<p>Comment by %s @ %s</p>", stripslashes($row['name']), $timestamp);
	}
	else{
		printf("<p>Comment by <a href=\"%s\">%s</a> @ %s</p>", stripslashes($row['url']), stripslashes($row['name']), $timestamp);
	}
    printf("</div>");
}
//if submit is pushed, check to see if required fields are selected.
if (isset($_POST['submit_comment'])) {
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['comment']) || empty($_POST['spam'])) {
        echo "<div style=\"color:#ff0000\"><h3 id=\"reply\">Error</h3>You have forgotten to fill in one of the required fields! Please make sure you submit a name, e-mail address and comment. Click the back button to go back and try again.</div>";
		echo '</div>';
		include("footer.php");
		return false;
	}
	if ($_POST['spam'] != "NOT SPAM") {
		echo "<div style=\"color:#ff0000\"><h3 id=\"reply\">Error</h3>Please re-submit your comment with the correct words in the anti-spam box.</div>";
		echo '</div>';
		include("footer.php");
		return false;
	}
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

    if (!preg_match("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$^", $email)) {
         echo "<div style=\"color:#ff0000\"><h3 id=\"reply\">Error</h3>The e-mail address you submitted does not appear to be valid. Please go back and correct it</div>";
		 echo '</div>';
		 include("footer.php");
		 return false;
    }
	else {
		echo "<h3 id=\"reply\">Success</h3>Your comment has been successfully submitted. Please refresh the page to see it.";
	}
    $result = mysql_query("INSERT INTO blog_comments (name, email, url, comment) VALUES ('$name','$email','$url','$comment')");
	//email comment
	$youraddress = "suebriquet@gmail.com";
    $emailsubject = "[Foodie] New comment";
    $bodyemail = "A new comment was posted on your blog\nName: " . $name . "\nEmail: " . $email . "\nUrl: " . $url. "\nDate submitted: " . date('d.m.y \a\\t H:i',strtotime($timestamp)) . "\nMessage:" . $comment;
    $extra = "From: Blog <" . $youraddress . ">\r\n" . "X-Mailer: PHP/" . phpversion();
    mail($youraddress, $emailsubject, $bodyemail, $extra);
}
?>
<h3 id="reply">Leave a Comment</h3>
<blockquote>
Thank you for taking the time to leave a message. 
Your feedback is much appreciated. 
</blockquote>
<form method="post" action="/comments.php#comment" id="commentform">
<p>

 <input type="text" name="name" id="name" size="28" /><strong><label for="name"> Name (required)</label></strong><br />

 <input type="text" name="email" id="email" size="28" /><strong><label for="email"> E-mail (required but will not publish)</label></strong><br />

 <input type="text" name="url" id="url" size="28" value="" /><strong><label for="url"> URL</label></strong><br />

<textarea cols="25" rows="5" name="comment" id="comment"></textarea></p>
<strong><label for="spam">Type </label><img src="spam.png" alt="spam"/><input type="text" name="spam" id="spam" size="20" value="" /><br />
<p><input type="submit" name="submit_comment" id="submit_comment" value="Add Comment" /></p>

</form>
</div>
<?php include("footer.php")?>