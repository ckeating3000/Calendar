<?php
    session_start();
    ini_set("session.cookie_httponly", 1);
    //echo "starting session" ;
    //display events on the date selected
    require 'database.php';
    if(!isset($_SESSION['Login'])){
        echo "You must log in to view events";
        exit;
    }
    else{
        $user = htmlentities($_SESSION['Login']);
        $date = $_POST['dateSent']; // 2016-06-04
        //get all events for a user
        $get_events = $mysqli->prepare("select time, event_text, event_id from events where username=? and date=? order by time");
        //then, all of this data could be turned into a json object, use javascript to parse
        if(!$get_events){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $get_events->bind_param('ss', $user, $date);
        $get_events->execute();
        $get_events->bind_result($times, $events, $id);

        $response_array = array();
        //     "event" => array(
        //         "id" => $id,
        //         "time" => $time,
        //         "event_text" => $event_text
        //         )
        // );
        // echo json_encode($response_array);
        //links allow users to view the likes and comments of each post as well as post their own
        while($get_events->fetch()){
            
            array_push($response_array, array(
                "id" => htmlspecialchars($id),
                "time" => htmlspecialchars($times),
                "event_text" => htmlspecialchars($events)
                ));


            // printf("\t<p class='eventdisplay'> %s %s <div class='hide'>%d</div><br> </p>", 
            //     htmlspecialchars($times),
            //     htmlspecialchars($events),
            //     htmlspecialchars($id)

            
        }
        echo json_encode($response_array);
        $get_events->close();
        exit;
    } 
?> 