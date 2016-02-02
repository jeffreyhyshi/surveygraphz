<?php
	$c = mysqli_connect("localhost","albusd_jshi","password123","albusd_jshi");
	if (mysqli_connect_errno()) {
		echo "-1";
	}

	if (isset($_POST['jsondata'])) {
		$surveyobj = json_decode($_POST['jsondata']);
		$surveyname = $surveyobj->name;
		$surveyquestions = $surveyobj->questions;

		$num_q = count($surveyquestions);

		$submitsurveyquery = "INSERT INTO surveys (name, num_q) 
							  VALUES ('$surveyname', $num_q)";

		if (mysqli_query($c, $submitsurveyquery)) {
			$s_id = mysqli_insert_id($c);
			$url = base_convert($s_id, 10, 36);
			$returnurl;

			$submiturlquery = "UPDATE surveys SET url='$url' WHERE s_id=$s_id";

			mysqli_query($c, $submiturlquery);

			foreach ($surveyquestions as $qkey => $question) {
				$questionname = $question->question;
				$questionchoices = $question->labels;
				$num_c = count($questionchoices);

				$submitquestionquery = "INSERT INTO questions (survey, name, q_order)
										VALUES ($s_id, '$questionname', $qkey)";
				if (mysqli_query($c, $submitquestionquery)) {
					$q_id = mysqli_insert_id($c);
					foreach ($questionchoices as $ckey => $choice) {
						$submitchoicequery = "INSERT INTO choices (question, name, count, c_order)
										       VALUES ($q_id, '$choice', 0, $ckey)";
						if (mysqli_query($c, $submitchoicequery)) {
							$returnurl = $url;
						}
					}
					
				} else {
					echo "-3";
				}

			}
			echo $returnurl;
		} else {
			echo "-2";
		}


		

		
	}
?>
