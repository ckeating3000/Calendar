<?php
	require 'database.php';
		session_start();
		//check for valid token created when user logs in
		if($_SESSION['token'] !== $_POST['token']){
			die("Request forgery detected");
		}
		
		$user = $_SESSION["Login"]; // * change once we have logging in functionality
		//start session
		//$user = SESSION_["login"];
		if(!isset($_SESSION["Login"])){
			echo "You must log in to add events";
			exit;
		}
		$event = $_POST["eventTitle"];
		$time = $_POST["time"];
		$date = $_POST["date"];
		//check that date and time are properly formatted. Proper format automatic when inputting values using Chrome
		// from http://stackoverflow.com/questions/13194322/php-regex-to-check-date-is-in-yyyy-mm-dd-format
		$proper_date = False;
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)){
        	$proper_date=True;
    	}
    	else{
        	$proper_date=False;
    	}
    	$proper_time = False;
		if (preg_match("/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/",$time)){
        	$proper_time=True;
    	}
    	else{
        	$proper_time=False;
    	}

    	// proceed with inserting event if time and date are validated
    	if($proper_time && $proper_date){
			$addevent = $mysqli->prepare("insert into events (username, event_text, date, time) values (?, ?, ?, ?)");
			if(!$addevent){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				echo "Content upload problem";
				exit;
			}
			$addevent->bind_param('ssss', $user, $event, $date, $time);
			$addevent->execute();
			$addevent->close();
			echo "Content successfully added";
			exit;
		}
		else{ // else get out of here!
			echo "Content upload failure";
			exit;
		}

?>