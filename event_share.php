<?php
	session_start();
	ini_set("session.cookie_httponly", 1);
	require 'database.php';
	
	if(!isset($_SESSION['Login'])){
		echo "You must log in to edit events";
		exit;
	}

	$id = $_POST['event_id'];
	$token = $_POST['token'];
	$other_user = htmlentities($_POST['other_user']);
	
	//token match check
	if($token == $_SESSION['token']){
		// proceed with inserting event
		//echo"line 22";
		//select all users and see if user-provided username matches
		$all_users =$mysqli->prepare("select username from users");
		$all_users-> execute();
		$all_users->bind_result($users);
		$match=false;
		while($all_users->fetch()){
			if($users==$other_user){
				echo "found a match";
				$match=true;
			}
			else{
				$match=false;
				echo "username not found";
				exit;
			}
		}
		//if there's a match, then proceed
		if($match==true){
			$other_user.=","; //concatenate a comma to make the whole string separated by usernames
			$edit_event = $mysqli->prepare("update events set other_event_users = CONCAT(other_event_users,?) where event_id=?");
			if(!$edit_event){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				echo "Content edit problem";
				exit;
			}
			$edit_event->bind_param('ss', $other_user, $id);
			$edit_event->execute();
			$edit_event->close();
			echo "Event successfully shared";
			exit;
		}
	}
	else{ // else get out of here!
		echo $_SESSION['token'];
		exit;
	}
?>