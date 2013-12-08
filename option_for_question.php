<?php
$id = $_REQUEST['q_id'];

include_once("db_connect.php");

$sql = "SELECT * FROM `option` where q_id =$id ";
echo "Retrieve otion for question sql: $sql";

$option_result = mysqli_query($DB_CONN,$sql) or die("can not execute query:$query");
$options = array();
while($option_row = mysqli_fetch_array($option_result)){
	echo print_r($option_row)."<br>";
	$options['option'][] = array('id' => $option_row['id']
		, 'text' => $option_row['text'], 'q_id' => $option_row['q_id']);
}

echo "option json encode<br>";
echo json_encode($options);

?>