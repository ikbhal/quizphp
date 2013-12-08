<?php
$json = $_REQUEST['json'];
echo "json:$json<br>";

$quiz = json_decode($json, true) or die("can not decode json");

include_once("db_connnect1.php");

//$sql = "INSERT INTO person VALUES ('B�rge','Refsnes','Sandnes','17')";
//$result = mysql_query($sql,$con);
//echo "ID of last inserted record is: " . mysql_insert_id();

//mysql_close($con);
echo "vardump<br>";
var_dump($quiz);

echo "Quiz<br>";
$questions= $quiz['question'];
foreach($questions as $qId => $question){
	$qtext = $question['text'];
	echo "qtext:".$qtext."<br>";

	//insert question
	$sql = "insert into question(text) values('$qtext')";
	echo "sql:$sql<br>";
	$result = mysql_query($sql,$DB_CONN) or die("can not execute query:$sql");
	$qId1 = mysql_insert_id() or die("can not fetch insert id");

	echo "qId1:$qId1<br>";

	$options = $question['option'];
	echo "options<br>";
	$oIdToI = array();
	$i=0;
	foreach($options as $oId => $option){
		$optionText = $option['text'];
		//insert option
		$sql = "insert into question(q_id, text) values($qId1, '$optionText')";
		echo "sql:$sql<br>";
		$result = mysql_query($sql,$DB_CONN) or die("can not execute query:$sql");
		$oId1 = mysql_insert_id() or die("can not fetch insert id");

		$oId2 = $option['id'];
		//$oId1 = $option['id'];
		$oIdToI["$oId2"]=$i;
		$oDbIdToI["$i"] = $oId1;

		$i++;
		echo "oId1:$oId1;oId2:$oId2;optionText:$optionText<br>";
	}

	echo "oIdToI :".print_r($oIdToI)."<br>";
	echo "oDbIdToI :".print_r($oDbIdToI)."<br>";

	echo "answers<br>";
	$answers = $question['answer'];
	foreach($answers as $aId => $answer){
		$oId= $answer['o_id'];
		echo "oId:$oId<br>";

		$answerJsonOptionIndex = $oIdToI["$oId"];
		echo "answerJsonOptionIndex:$answerJsonOptionIndex<br>";

		$answerOptionIndex = $oDbIdToI["$answerJsonOptionIndex"];
		echo "answerOptionIndex:$answerOptionIndex<br>";

		//insert answer o_id, q_id
		$sql = "insert into answer(o_id, q_id) values( $answerOptionIndex, $qId1)";
		echo "sql:$sql<br>";
		$result = mysql_query($sql,$DB_CONN) or die("can not execute query:$sql");
		$aId1 = mysql_insert_id() or die("can not fetch insert id");


		echo "o_id:$oId; aId1: $aId1;answerOptionIndex: $answerOptionIndex; answer:"
			.$options[$answerOptionIndex]['text']."<br>";
	}

}

mysql_close($con) or die("can not close db connection");

echo ">>>>>>>>>Success<<<<<<<<<<<br>";

?>