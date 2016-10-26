<?php
    session_start();
    //display events on the date selected
    require 'database.php';
    //alternatively, we could just display all events for the month, for which the SQL script would be:
    $get_events = $mysqli->prepare("select date, time, event_text from events where username=?");
    //then, all of this data could be turned into a json object, use javascript to parse 
    
    if(!$get_events){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $get_events->bind_param('s', $user);
    $get_events->execute();
    $get_events->bind_result($date $time, $event);

    //make and populate an associative array containing all events for a user
    $data = array();
    $data['date'] = $date;
    $data['time'] = $time;
    $data['event'] = $event;

    // $json = array();
    // while($row = mysql_fetch_array($data))     
    // {
    //     $json[]= array(
    //         'date' => $row['date'],
    //         'time' => $row['time'],
    //         'event'=> $row['event']
    //     );
    // }

    $json_event_string = json_encode($data);
    echo $json_event_string;

    $get_events->close();



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