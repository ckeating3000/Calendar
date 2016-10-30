<?php
	require 'database.php';
	session_start();
	//check for valid token created when user logs in
	//if($_SESSION['token'] !== $_POST['token']){
	//	die("Request forgery detected");
	//}
	
	$user = $_SESSION['Login']; // * change once we have logging in functionality
	//start session
	//$user = SESSION_["login"];
	if(!isset($_SESSION['Login'])){
		echo "You must log in to delete events";
		exit;
	}
	$event_id = $_POST['id'];
	$ = $_POST[''];
	$date = $_POST['date'];
	//check that date and time are properly formatted. Proper format automatic when inputting values using Chrome
	// from http://stackoverflow.com/questions/13194322/php-regex-to-check-date-is-in-yyyy-mm-dd-format
	$proper_date = False;
	if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)){
    	$proper_date=True;
	}
	else{
    	$proper_date=False;
	}
	// check for proper time
	$proper_time = False;
	if (preg_match("/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/",$time)){
    	$proper_time=True;
	}
	else{
    	$proper_time=False;
	}

	// proceed with inserting event if time and date are validated
	if($proper_time && $proper_date){
		$delete_event = $mysqli->prepare("delete from events where username=?, event_text=?, date=?, time=?");
		if(!$delete_event){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			echo "Content delete problem";
			exit;
		}
		$delete_event->bind_param('ssss', $user, $event, $date, $time);
		$delete_event->execute();
		$delete_event->close();
		echo "Content successfully deleted";
		exit;
	}
	else{ // else get out of here!
		echo "Content delete failure";
		exit;
	}

?>