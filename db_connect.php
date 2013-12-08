<?php
include_once("constants.php");

$DB_CONN = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_NAME) or die("Error1 " . mysqli_error($DB_CONN));

//echo "db_connection successfully";
?>