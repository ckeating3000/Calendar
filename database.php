<?php
//connect to mod3 database with ability to update, select and insert into tables
//For Colin's database:
$mysqli = new mysqli('localhost', 'wustl_inst', 'wustl_pass', 'calendar');
//For Kate's database:
//$mysqli = new mysqli('localhost', 'wustl_inst', 'wustl_pass', 'mod5');
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>