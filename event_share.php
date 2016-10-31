<?php
	session_start();
	ini_set("session.cookie_httponly", 1);
	require 'database.php';
	
	if(!isset($_SESSION['Login'])){
		echo "You must log in to edit events";
		exit;
	}
	$event_id = $_POST['event_id'];
	$token = $_POST['token'];

	//token match check
	if($token == $_SESSION['token']){
		// proceed with inserting event
		//echo"line 22";
		//select all users and see if user-provided username matches
		$all_users =$mysqli->prepare("select username from users");
		$all_users-> execute();
		$get_events->bind_result($users);

		$edit_event = $mysqli->prepare("update events set event_text=?, time=?, date=? where event_id=?");
		if(!$edit_event){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			echo "Content edit problem";
			exit;
		}
		$edit_event->bind_param('sssd', $text, $time, $date, $event_id);
		$edit_event->execute();
		$edit_event->close();
		echo "Event successfully shared";
		exit;
	}
	else{ // else get out of here!
		echo $_SESSION['token'];
		exit;
	}
?>