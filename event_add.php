<?php
require 'database.php';


$user = "Bob";
$event = $_POST["eventTitle"];
$time = $_POST["time"];
$date = $_POST["date"];
$addevent = $mysqli->prepare("insert into events (username, event_text, date, time) values (?, ?, ?, ?)");
$addevent->bind_param('ssii', $user, $event, $time, $date );
?>