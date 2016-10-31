<?php
	session_start();
	ini_set("session.cookie_httponly", 1);
	require 'database.php';
	
	if(!isset($_SESSION['Login'])){
		echo "You must log in to edit events";
		exit;
	}
	$event_id = $_POST['id'];
	$token = $_POST['token'];
	$text = $_POST['text'];
	$time = $_POST['time'];
	$date = $_POST['date'];
	$tag = $_POST['tag'];

	//token match check
	if($token == $_SESSION['token']){
		// proceed with inserting event
		//echo"line 22";
		$edit_event = $mysqli->prepare("update events set event_text=?, time=?, date=?, tag=? where event_id=?");
		if(!$edit_event){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			echo "Content edit problem";
			exit;
		}
		$edit_event->bind_param('sssss', $text, $time, $date, $tag, $event_id);
		$edit_event->execute();
		$edit_event->close();
		echo "Content successfully changed";
		exit;
	}
	else{ // else get out of here!
		echo $_SESSION['token'];
		exit;
	}
?>