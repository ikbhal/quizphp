<?php

include_once("db_connect.php");

$sql = "select * from question";

//echo "sql:$sql<br>";

$result = mysqli_query($DB_CONN,$sql) or die("can not execute query:$query");
$questions = array();
while($row = mysqli_fetch_array($result))
  {
  	//echo $row['id'] . " " . $row['text']."<br>";

  	//begin answer 
	$sql = "SELECT * FROM `answer` where q_id = ". $row['id'];
	//echo "Retrieve otion for question sql: $sql";

	$aresult = mysqli_query($DB_CONN,$sql) or die("can not execute query:$sql");
	$answers = array();
	if($arow = mysqli_fetch_array($aresult)){
		//echo print_r($option_row)."<br>";
		$answers[] = array('id' => $arow['id']
			, 'o_id' => $arow['o_id'], 'q_id' => $arow['q_id']);
	}
  	//end answer

  	//begin options
  	$sql = "SELECT * FROM `option` where q_id = ". $row['id'];
	//echo "Retrieve otion for question sql: $sql";

	$option_result = mysqli_query($DB_CONN,$sql) or die("can not execute query:$query");
	$options = array();
	while($option_row = mysqli_fetch_array($option_result)){
		//echo print_r($option_row)."<br>";
		$options[] = array('id' => $option_row['id']
			, 'text' => $option_row['text'], 'q_id' => $option_row['q_id']);
	}
	//end options

    $questions['question'][] = array('id' =>$row['id'], 'text' =>$row['text']
    	, 'option' => $options, "answer" => $answers);

  	//echo "<br>";
  }

mysqli_close($DB_CONN) or die("can not close mysql");

//echo "Questions json<br>";
echo json_encode($questions);

?>