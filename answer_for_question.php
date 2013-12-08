<?php
$id = $_REQUEST['q_id'];
echo "q_id:$id<br>";

$sql = "SELECT * FROM `answer` where q_id = ". $id;
//echo "Retrieve otion for question sql: $sql";

$aresult = mysqli_query($DB_CONN,$sql) or die("can not execute query:$sql");
$answers = array();
if($arow = mysqli_fetch_array($aresult)){
	//echo print_r($option_row)."<br>";
	$answers[] = array('id' => $arow['id']
		, 'o_id' => $arow['o_id'], 'q_id' => $arow['q_id']);
}

echo json_encode($answers);
?>