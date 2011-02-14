<?php
function recent_comments(){
	$recent_comments = mysql_query("SELECT * FROM blog_comments ORDER BY timestamp DESC LIMIT 5")or print ("Can't select entries from table blog_comments.<br />" . mysql_error());
	echo '<table>';
	while($row = mysql_fetch_array($recent_comments)) {
		$entry = (int)$row['entry'];
		$entry_title = mysql_query("SELECT * FROM blog WHERE id=$entry") or print ("Can't select entries from table blog.<br />" . mysql_error());
		while ($entry_row = mysql_fetch_array($entry_title)) {
		$comment = $row['comment'];
		$name = $row['name'];
		$date = date("m.j.Y", strtotime($row['timestamp']));
		$id = $row['id'];
		$title = $entry_row['title'];
		if ($comment == "") {echo "None";}
	else
		echo '<tr><td>'.$name.'<br />'.$date.'<br /><a href="editcomments.php?id='.$id.'">Edit</a></td><td><h4>'.$title.'</h4>'.$comment.'</td></tr>';
		}
	}
	echo '</table>';
}
?>