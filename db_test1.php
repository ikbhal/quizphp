<?php
include_once("db_connect1.php");

$qtext = "How to print in PHP";

	$sql = "insert into question(text) values('$qtext')";
	echo "sql:$sql<br>";
	$result = mysql_query($sql,$DB_CONN) or die("can not execute query:$sql");
	$qId1 = mysql_insert_id() or die("can not fetch insert id");


?>