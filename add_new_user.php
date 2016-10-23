<?php
//be able to access the database
require 'database.php';
//get username and password from add_user.html form
$new_username = $_POST["newname"];
$new_password = $_POST["newpass"];
//check username validity
if( !preg_match('/^[\w_\-]+$/', $new_username) ){
	echo "Invalid username";
	exit;
}

//check password validity
if( !preg_match('/^[\w_\-]+$/', $new_password) ){
	echo "Invalid password";
	exit;
}

//run salting and hash on the password.  Use password_hash instead of crypt because the former automatically generates a salt
$password_crypted = password_hash($new_password, PASSWORD_DEFAULT);

//get the username from the database, make sure it doesn't already exist
$check_u_p = $mysqli->prepare("select usernamefrom users where username like '$new_username' ");
if(!$check_u_p){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$check_u_p->execute();
$check_u_p->bind_result($username);
if ($username===$new_username) {
	echo "username already exists";
	exit;
}
else{
	//add username and password to the database if it doesn't exist already
	$adduser = $mysqli->prepare("insert into users (username, hash_key) values (?, ?)");
	if(!$adduser){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$adduser->bind_param('ss', $new_username, $password_crypted);
	$adduser->execute();
	$adduser->close();
	header("Location: calendar.php");
	exit;
}

else{
	echo "Username and password already taken";
} 

?>