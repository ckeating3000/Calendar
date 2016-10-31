<?php
	session_start();
	ini_set("session.cookie_httponly", 1);
	require 'database.php';
	
	if(!isset($_SESSION['Login'])){
		echo "You must log in to edit events";
		exit;
	}

	$token = $_POST['token'];
	$user = htmlentities($_SESSION['Login']);
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
				$match=true;
				break;
			}
		}
		$all_users->close();
    	$mysqli->next_result();
		//if there's a match, then proceed
		if($match==true){
			$user.=","; //concatenate a comma to make the whole string separated by usernames
			$edit_event = $mysqli->prepare("update users set other_users = CONCAT(other_users,?) where username=?");
			if(!$edit_event){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				echo "Content edit problem";
				exit;
			}
			$edit_event->bind_param('ss', $user, $other_user);
			$edit_event->execute();
			$edit_event->close();
			echo "Calendar successfully shared";
			exit;
		}
	}
	else{ // else get out of here!
		echo $_SESSION['token'];
		exit;
	}
?>