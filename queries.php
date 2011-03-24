<?php
// print out user profile data in a table
function user_profile($userid) {
	$i = 0;
	$sql = "SELECT username, firstname, lastname, prof_bdate, prof_sex, email, registered_on, prof_bio FROM users u, user_profile p WHERE u.id = p.user_id AND u.id = '$userid'";
	echo '<table align=center width=100%>';
	if ($result=mysql_query($sql)) {
	  while ($row=mysql_fetch_row($result)) {
		$timestamp = date("l F jS Y g:i a", strtotime($row[$i+6]));
		echo '<tr><td class="left-column"><strong>Username: </strong></td><td>'.$row[$i].'</td></tr>';
		echo '<tr><td class="left-column"><strong>Name: </strong></td><td>'.$row[$i+1].'&nbsp;'.$row[$i+2].'</td></tr>';
		echo '<tr><td class="left-column"><strong>Birthdate: </strong></td><td>'.$row[$i+3].'</td></tr>';
		echo '<tr><td class="left-column"><strong>Sex: </strong></td><td>'.$row[$i+4].'</td></tr>'; 
		echo '<tr><td class="left-column"><strong>Email: </strong></td><td>'.$row[$i+5].'</td></tr>'; 
		echo '<tr><td class="left-column"><strong>Registered on: </strong></td><td>'.$timestamp.'</td></tr>'; 
		echo '<tr><td class="left-column"><strong>Bio: </strong></td><td>'.$row[$i+7].'</td></tr>
		'; 
	  }
	} else {
	  echo '<!-- SQL Error '.mysql_error().' -->';
	}
	echo '</table>';
}
// print all fitness data for one user
function user_fitness($userid){
	$i = 0;
	$j = 0;
	$sql = "SELECT username, firstname, lastname, fit_type, fit_name, fit_duration, fit_intensity, f.timestamp FROM users u, fitness f WHERE u.id = f.user_id AND u.id = '$userid'";
	echo '<table align=center width=100%>';
	if ($result=mysql_query($sql)) {
		$result1 = mysql_query($sql);
		$row1 = mysql_fetch_row($result1);
		echo '<tr><td><strong>Username: </strong>'.$row1[$j].'</td></tr><tr><td><strong>Name: </strong>'.$row1[$j+1].'&nbsp;'.$row1[$j+2].'</td></tr>';
		echo '<tr><th>Fitness type</th><th>Fitness name</th><th>Fitness duration</th><th>Fitness intensity</th><th>Date</th></tr>
			<tr>';
		while ($row = mysql_fetch_row($result)) {
			$timestamp = date("F jS Y g:i a", strtotime($row[$i+7]));
			if ($row[$i+3] == 1) {
				echo '<td>Aerobics</td>'; 
			}
			else {
				echo '<td>Weights</td>'; 
			}
			echo '<td>'.$row[$i+4].'</td>';
			echo '<td>'.$row[$i+5].' minutes</td>'; 
			echo '<td>'.$row[$i+6].' </td>'; 
			echo '<td>'.$timestamp.'</td></tr>'; 
		}
	} else {
	  echo '<!-- SQL Error '.mysql_error().' -->';
	}
	echo '</table>';
}

?>