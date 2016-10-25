<?php
	// destroy any previous sessions
    session_start();
    session_destroy();
    require 'database.php';

    
	
    $username=$_POST["username"];
    $password_guess=$_POST["userpass"];
    //make sure username is safe
    //check username validity
    if( !preg_match('/^[\w_\-]+$/', $username) ){
    	echo "Invalid username";
    	exit;
    }

    //check password validity
    if( !preg_match('/^[\w_\-]+$/', $password_guess) ){
    	echo "Invalid password";
    	exit;
    }


        //if that's a reasonable user, log them in
    $check_u_p = $mysqli->prepare("select username, hash_key from users where username=? ");
    $check_u_p->bind_param('s', $username);
    $check_u_p->execute();

    $check_u_p->bind_result($username_db, $password_db);
    $check_u_p->fetch();

    if($username != $username_db){
        echo "Invalid username";
        exit;
    }
    if(password_verify($password_guess, $password_db)==$password_db){
        session_start();
        $_SESSION["Login"] = $username_db;
        $_SESSION['token'] = substr(md5(rand()), 0, 10); // generate a 10-character random string
        echo "Login successful";
        exit;
    }
        //send the user to failed login if not a user or allow them to home menu
    else{
    echo "Invalid Login Credentials";
     exit;
    }


?>