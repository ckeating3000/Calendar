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
    //this query gets all events for current user
        $get_events = $mysqli->prepare("select time, event_text, event_id ,tag from events where username=? and date=? order by time");
        if(!$get_events){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $get_events->bind_param('ss', $user, $date);
        $get_events->execute();
        $get_events->bind_result($times, $events, $id, $tag);

        $response_array = array();
        
        while($get_events->fetch()){
            array_push($response_array, array(
                "id" => htmlspecialchars($id),
                "time" => htmlspecialchars($times),
                "event_text" => htmlspecialchars($events),
                "event_tag" => htmlspecialchars($tag)
                ));   
        }
        $get_events->close();
        $mysqli->next_result();

// (for event sharing)
    // this query selects all events and looks through the other_event_users string to see if that event is shared with the current user
        $get_more_events = $mysqli->prepare("select `time`, `event_text`, `event_id`, `other_event_users`, `tag` from `events` where `date`=? order by `time`");
        if(!$get_more_events){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $contain_user = "%"+$user+"%";
        $get_more_events->bind_param('s', $date);
        $get_more_events->execute();
        $get_more_events->bind_result($times2, $events2, $id2, $otherusers, $tag2);
        
        while($get_more_events->fetch()){
            if (strpos($otherusers, $user) !== false) {
                array_push($response_array, array(
                    "id" => htmlspecialchars($id2),
                    "time" => htmlspecialchars($times2),
                    "event_text" => htmlspecialchars($events2),
                    "event_tag" => htmlspecialchars($tag2)
                    )); 
            }
        }
        $get_more_events->close();
        $mysqli->next_result();

// (for calendar sharing)
    // this query selects all users in user table and stores them in an array    
        $get_users = $mysqli->prepare("select username from users");
        if(!$get_users){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $get_users->execute();
        $get_users->bind_result($allusers);
        $user_array = array();
        while($get_users->fetch()){
            array_push($user_array, array(
                "user" => htmlspecialchars($allusers),
                ));   
        }

        $get_users->close();
        $mysqli->next_result();

    // this query selects only appropriate users and store them in another array    
        $get_other = $mysqli->prepare("select `other_users` from users where `username`=?");
        if(!$get_other){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $get_other->bind_param('s', $user);
        $get_other->execute();
        $get_other->bind_result($other);
        $final_others= array();
        while($get_other->fetch()){
            for ($i=0; $i < sizeof($user_array); $i++) { 
                if(strpos($other, $user_array[$i]["user"]) !== false){ // $user_array[$i]["user"]
                    array_push($final_others, $user_array[$i]["user"]);
                }
            }
        }
        $get_other->close();
        $mysqli->next_result();

        // then for each other user the cal is shared with, get all events for that day
        for ($i=0; $i < sizeof($final_others); $i++) {    
            $get_even_more_events = $mysqli->prepare("select `time`, `event_text`, `event_id`, `tag` from `events` where `date`=? and `username`=? order by `time`");
            if(!$get_even_more_events){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $contain_user = "%"+$user+"%";
            $get_even_more_events->bind_param('ss', $date, $final_others[$i]);
            $get_even_more_events->execute();
            $get_even_more_events->bind_result($times3, $events3, $id3, $tag3);
            
            while($get_even_more_events->fetch()){
                array_push($response_array, array(
                    "id" => htmlspecialchars($id3),
                    "time" => htmlspecialchars($times3),
                    "event_text" => htmlspecialchars($events3),
                    "event_tag" => htmlspecialchars($tag3)
                    ));
            }
            $get_even_more_events->close();
            $mysqli->next_result();
        }
        //sort entire response array by times
        // function cmp($a, $b) {
        //     return $a['time'] - $b['time'];
        // }
        // usort($response_array,"cmp");

        echo json_encode($response_array);
        
        exit;
    } 
?> 