<?php
	$c = mysqli_connect('localhost','albusd_jshi','password123','albusd_jshi');

	if (mysqli_connect_errno($c)) {
		echo "nope";
	} else {
		mysqli_query($c, "DELETE FROM choices");
		mysqli_query($c, "DELETE FROM questions");
		mysqli_query($c, "DELETE FROM surveys");
		mysqli_query($c, "ALTER TABLE choices AUTO_INCREMENT = 1");
		mysqli_query($c, "ALTER TABLE questions AUTO_INCREMENT = 1");
		mysqli_query($c, "ALTER TABLE surveys AUTO_INCREMENT = 1");
	}


?>