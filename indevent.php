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
        $id = $_POST['id']; 
      
        $get_event = $mysqli->prepare("select time, event_text, username, date from events where event_id=?");
        //then, all of this data could be turned into a json object, use javascript to parse
        if(!$get_event){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $get_event->bind_param('i', $id);
        $get_event->execute();
        $get_event->bind_result($time, $event, $username, $date);

        //links allow users to view the likes and comments of each post as well as post their own
        while($get_event->fetch()){
            printf("\t<p > %s %s <br> </p>",
                htmlspecialchars($time),  
                htmlspecialchars($event),
                htmlspecialchars($date)
            );
        }
        $get_event->close();
        exit;
    } 
?> 