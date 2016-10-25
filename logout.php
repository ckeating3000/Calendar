<?php
//destroy the session after someone hits the logout button, send them back to the login screen
	session_start();
	session_destroy();
	echo "Logout successful";
	exit;
?>