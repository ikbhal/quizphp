<!DOCTYPE html>
<html>
<head>
<script src="js/jquery.min.js">
</script>
<style type="text/css">
</style>
<script>
var quizes = null;
var qi = -1;
var score = 0;
$(document).ready(function(){
  $("#startQuiz").click(function(){
    $.ajax({url:"quiz.php",
    	dataType: "json",
    	success:function(result){
    		console.log("result:" + result);
    	quizes = result;
    	qi = 0;
    	loadQuestion(qi);
    }});
  });

  $("#nextQuestion").click(function(){
  		console.log("clicked nextQuestion");
  		console.log("answer is  and selection ");
  		
  		var qAnswers =  $("#question").data("qAnswers");
  		console.log("qAnswers:" + qAnswers);
  		var optionSelected = null;
  		var correctAnswer = false;
  		$.each(qAnswers, function(key, answer){
  			$(".qOption").each(function (){
  				if($(this).data("select")){
  					optionSelected = $(this);
  					if(answer.o_id == $(this).data('oId')){
  						console.log("match option with answer id:" + answer.id);
  						optionSelected = $(this);
  						correctAnswer = true;
  					}
  				}
  			});
  		});

  		if( optionSelected == null){
  			console.log("Please select any option");
  			alert("Please select any option");
  			$("#message").html("Please select any option");
  		}else if(correctAnswer){
  			$("#message").html("Correct Answer");
  			alert("Correct Answer");
  			score ++;
  			moveToNextQuestionIfPossible();

  			
  		}else{
  			alert("Wrong Answer");
  			$("#message").html("Wrong Answer");
  			moveToNextQuestionIfPossible();
  		}

  });

  //option clicked
  $(".qOption").click(optionClicked);

});

function showScore(){
	console.log("inside showScore");
	$("#message").html("Score:" + score);
}

function moveToNextQuestionIfPossible(){
			if(qi + 1 >= quizes.question.length){
				console.log("All Question over");
				showScore();
				return;
			}
			qi++;
			loadQuestion(qi);
  			console.log("Moving to next Question qi:" + qi);
}

function optionClicked(){
	console.log("inside option clicked");

	var select = true;
	if($(this).data("select")){
		select = false;
	}
	$(this).data("select", select);
}

function loadQuestion(qi){
	console.log("loadQuestion:" + qi);
	if(quizes == null){
		console.log("no quiz data");
		return;
	}
	if (typeof quizes.question[qi] == 'undefined'){
		console.log("no Question exist for index:" + qi);
		return;
	}

	var q = quizes.question[qi];
	var qId = q.id;
	console.log("qId:" + qId);
	$("#question").data("qId", qId);
	var qText = q.text;
	console.log("qText:" + qText);
	var qOptions = q.option;
	console.log("qOptions:" + qOptions);

	var qAnswers = q.answer;
	console.log("qAnswers:" + qAnswers);
	$("#question").data("qAnswers", qAnswers);

	$("#qText").text(qText);


//	var qOptionDivClone = $("<div class=\"qOption\"></div>");
//	$( "#qOptions" ).remove(".qOption");
	var qOptionDivClone = $(".qOption:first").clone();
	$("#qOptions").empty();

	var qOptionDiv = null;
	$.each( qOptions, function( key, qOption ) {
  		qOptionDiv = qOptionDivClone.clone();
  		
  		qOptionDiv.text(qOption.text);
  		qOptionDiv.data("oId",qOption.id);

  		qOptionDiv.appendTo( "#qOptions" );
  		qOptionDiv.click(optionClicked);
	});
	
}
</script>
</head>
<body>

	<h1>Quiz</h1>
	<button id="startQuiz" >Start Quiz</button>
	<div class="qOption">
	</div>
	<div id="message"></div>
	<div id ="question" >

		<div id="qText"></div>
		<div id="qOptions" >
		</div>
		<button id="nextQuestion">Next</button>
	</div>

</body>
</html>