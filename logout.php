<?php
//destroy the session after someone hits the logout button, send them back to the login screen
	session_start();
	ini_set("session.cookie_httponly", 1);
	$_SESSION['Login'] = '';
	session_destroy();
	echo "Logout successful";
	exit;
?>