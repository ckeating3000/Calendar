<?php
    session_start();
    //display events on the date selected
    require 'database.php';
    if(!isset($_SESSION["Login"])){
        echo "You must log in to view events";
    }
    $user = $_SESSION["Login"];
    $date = $_POST["dateSent"];
    //get all events for a user
    $get_events = $mysqli->prepare("select time, event_text from events where username=? and date=?");
    //then, all of this data could be turned into a json object, use javascript to parse
    if(!$get_events){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $get_events->bind_param('ss', $user, $date);
    $get_events->execute();
    $get_events->bind_result($times, $events);

 	//links allow users to view the likes and comments of each post as well as post their own
	while($get_events->fetch()){
		printf("\t<p> %s</a> <br> %s <b",
			"Event name: ".htmlspecialchars($event),
			"Event time: ".htmlspecialchars($time)
		);
	}
    //$data = array();
    //$data['date'] = $dates;
    //$data['time'] = $times;
    //$data['event'] = $events;
    ////look for correct month and year and store only correct dates
    ////&&&&&&&&&&&&&fixthisbelow!!!!!!!!!!!!!!!!
    //foreach ($data as $date){
    //    $pieces = explode("-", $date);
    //    if($pieces[0] == $year && $pieces[1]==$month){
    //        array_push($data['date'], $date);
    //    }
    //}
    ////make and populate an associative array containing all events for a user
    //$data = array();
    //$data['date'] = $dates;
    //$data['time'] = $times;
    //$data['event'] = $events;
    //
    //$json_event_string = json_encode($data);
    //echo $json_event_string;
    //
    //$get_events->close();



    ///////////////////////////////////////////////////////////////////////////////////////////////
    // Kate's code from Tuesday (10/25) afternoon
    // display events on the date selected
    // require 'database.php';
    // $get_events = $mysqli->prepare("select time, event_text from events where date=?, username=?");
    // if(!$get_events){
    //     printf("Query Prep Failed: %s\n", $mysqli->error);
    //     exit;
    // }
    // $get_events->bind_param('is', $date, $user);
    // $get_events->execute();
    // $get_events->bind_result($time, $event);

    // while($get_events->fetch()){
    // 	//nonusers can only see comments from other users
    //         printf(" %s %u",
    //         "Event title: ".htmlspecialchars($event),
    //         "Event time: ".htmlspecialchars($time)
    //     );
    // } 
    // $get_events->close();
        
?> 