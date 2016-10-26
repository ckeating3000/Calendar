<?php
    session_start();
    //echo "starting session" ;
    //display events on the date selected
    require 'database.php';
    if(!isset($_SESSION['Login'])){
        echo "You must log in to view events";
        exit;
    }
    else{
        $user = $_SESSION['Login'];
        $date = $_POST['dateSent']; // 2016-06-04
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
            printf("\t<p id='eventdisplay'> %s %s <br> </p>",
                htmlspecialchars($times),
                htmlspecialchars($events)
            );
        }
        $get_events->close();
        exit;
    } 
?> 