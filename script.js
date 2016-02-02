$(function(){
	var survey = new Object();
	survey.questions = new Array();

	var responseData;

	var addInputs = function(q, t, n) {
		survey.questions[n] = {
			question: q,
			type: t,
			labels: new Array()
		};
		var $qInputHtml = makeInputHtml(q,t,n);
		var $qHtml = $(
			"<div id='q" + n + 
			"' class='question'>" +
			survey.questions[n].question +
			$qInputHtml +
			"</div>");
		$("#survey").append($qHtml);

		$(".label").blur(function() {
			var myId = $(this).attr("id").toString();
			console.log(myId.indexOf("_"));
			var qIndex = (myId.indexOf("_") !== -1) ? myId.substring(0, myId.indexOf("_")) : myId;
			var lIndex = (myId.indexOf("_") !== -1) ? myId.substring(myId.indexOf("_") + 1) : 0;
			survey.questions[qIndex].labels[lIndex] = $(this).val();
		});
	};

	var checkInputs = function(q, t, n) {

	}

	var makeInputHtml = function(q, t, n) {
		var retHtml = "";
		if (t == "radio" || t == "checkbox") {
			for (var i=0; i<4; i++) {
					retHtml = retHtml +
					"<input type='" + t + "'>" +
					"<input type = 'text' class='label' id='" +
					n + "_" + i + "'>";
			}
		} else {
			retHtml = retHtml +
					"<span class='label' contenteditable>Edit label</span>" + 
					"<input type='" + t + "' id='" +
					n + "'>";
		}
		return retHtml;
	}

	//$("#survey").sortable({cancel: ':input,button,[contenteditable]'});
	$("#survey").disableSelection();

	$("#addbutton").click(function() {
		checkInputs($("#questiontext").val(),$("#type :selected").val(),
			survey.questions.length);
		addInputs($("#questiontext").val(),$("#type :selected").val(),
			survey.questions.length);
	});

	$("#submitbutton").click(function() {
		survey.name = $("#surveyname").val();
		var surveyjson = JSON.stringify(survey);
		$.post('ajax/newsurvey.php', {jsondata: surveyjson}, function (data) {
			console.log(data);
			var responseData = data;
			var urlstub = "penumbra.ausdk12.org/students/2012/jshi/importantproject/survey.php?r=";
			$("#surveyurl").html("<a href='http://" + urlstub + responseData + "'>SURVEY HERE </a>");
		});
	});

	

	//todo: checkInputs
	//todo: make these moveable/draggable, fix array as such
});