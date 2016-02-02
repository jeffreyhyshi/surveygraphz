<?php
	$c = mysqli_connect('localhost','albusd_jshi','password123','albusd_jshi');
	if (mysqli_connect_errno()) {
		echo "-1";
	}

	if (isset($_POST['jsondata'])) {
		$choice_ids = json_decode($_POST['jsondata']);

		foreach ($choice_ids as $choice_id) {
			$update_counts_query = "UPDATE choices SET count=count+1 WHERE c_id=$choice_id";
			if (mysqli_query($c, $update_counts_query)) {
				echo '1';
			}
		}


	}
			
?>