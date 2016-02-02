<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script type="text/javascript" src="submit.js"></script>
	<title>SurveyGraphz</title>
</head>
<body>
<div id="header">
	<h1>Welcome to SurveyGraphz</h1>
	<h2>Where your surveys have graphz</h2>
</div>
<div id="main">
	<?php
	$c = mysqli_connect('localhost','albusd_jshi','password123','albusd_jshi');

	if (mysqli_connect_errno($c)) {
		echo "Could not connect to mysql";
	}

	if (isset($_GET['r'])) {
		$url = $_GET['r'];
		$s_id = (int) base_convert($url, 36, 10);

		$questionsdata = mysqli_query($c, "SELECT * FROM questions WHERE survey='$s_id' ORDER BY q_order");
		$questionsarray = array();

		while ($row = mysqli_fetch_assoc($questionsdata)) {
			$questionsarray[] = $row;
		}

		foreach ($questionsarray as $question) {
			$q_id = $question['q_id'];
			$qname = $question['name'];
			$show_order = $question['q_order'] + 1;
			echo "<div class='question' id='$q_id'><h3>{$show_order}. {$qname}</h3>";

			$choicesdata = mysqli_query($c, "SELECT * FROM choices WHERE question='$q_id'");
			$choicesarray = array();
			while ($row = mysqli_fetch_assoc($choicesdata)) {
				$choicesarray[] = $row;
			}
			foreach ($choicesarray as $choice) {
				$c_id = $choice['c_id'];
				$cname = $choice['name'];
				echo "<div class='answerchoice'><input type='radio' value='$c_id'>";
				echo "$cname </div>";
			}
			echo "</div>";

		}

		echo "<input type='hidden' value='$s_id' id='sid'>";
	}	
		
	?>

	<div class="button" id="submitsurvey">SUBMIT</div>
	<div>
		<span id="surveyurl"></span>
	</div>

</div>

</body>

</html>