<?php
include_once("constants.php");
$DB_CONN = mysql_connect(DB_HOST, DB_USER, DB_PWD);
if (!$DB_CONN)
{
  die('Could not connect: ' . mysql_error());
}else{

	echo "connect to db server<br>";
	$db_selected = mysql_select_db(DB_NAME,$DB_CONN) or die("can not connect db");
	echo "connect to db success<br>";
}

?>