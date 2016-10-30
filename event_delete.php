<?php
	session_start();
	require 'database.php';
	
	if(!isset($_SESSION['Login'])){
		echo "You must log in to delete events";
		exit;
	}
	$event_id = $_POST['id'];
	$token = $_POST['token'];

	//token match check
	if($token == $_SESSION['token']){
		// proceed with inserting event
		//echo"line 22";
		$delete_event = $mysqli->prepare("delete from events where event_id=?");
		if(!$delete_event){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			echo "Content delete problem";
			exit;
		}
		$delete_event->bind_param('d', $event_id);
		$delete_event->execute();
		$delete_event->close();
		echo "Content successfully deleted";
		exit;
	}
	else{ // else get out of here!
		echo $_SESSION['token'];
		exit;
	}

	

?>