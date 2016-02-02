$(function() {
	$("#submitsurvey").click(function() {
		var sId = $("#sid").val();
		var qIdArray = new Array();

		$("input:radio:checked").each(function(i, domEle) {
			qIdArray[i] = $(domEle).val();
		})

		var postArray = JSON.stringify(qIdArray);

		$.post('ajax/submitsurvey.php', {jsondata: postArray}, function (data) {
			console.log(data);
			if (data != -1) {
				var urlstub = "penumbra.ausdk12.org/students/2012/jshi/importantproject/results.php?r=";
				$("#surveyurl").html("<a href='http://" + urlstub + sId + "'>SURVEY HERE </a>");
			}
		});
	})
})