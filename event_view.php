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
        
        while($get_events->fetch()){
            array_push($response_array, array(
                "id" => htmlspecialchars($id),
                "time" => htmlspecialchars($times),
                "event_text" => htmlspecialchars($events)
                ));   
        }
        $get_events->close();
        $mysqli->next_result();

        // this query selects all events and looks through the other_event_users string to see if that event is shared with the current user
        //select `time`, `event_text`, `event_id` from `events` where `date`='2016-10-30' and other_event_users like '%ColinK%' order by `time`;
        $get_more_events = $mysqli->prepare("select `time`, `event_text`, `event_id`, `other_event_users` from `events` where `date`=? order by `time`");
        if(!$get_more_events){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $contain_user = "%"+$user+"%";
        $get_more_events->bind_param('s', $date);
        $get_more_events->execute();
        $get_more_events->bind_result($times2, $events2, $id2, $otherusers);
        //$all_users = preg_split ('/[\s*,\s*]*,+[\s*,\s*]*/', $otherusers);
        
        while($get_more_events->fetch()){
            //$all_users = explode("," , $otherusers);
            //if($all_users == $user){
            if (strpos($otherusers, $user) !== false) {
                array_push($response_array, array(
                    "id" => htmlspecialchars($id2),
                    "time" => htmlspecialchars($times2),
                    "event_text" => htmlspecialchars($events2)
                    )); 
            }
        }
        // for ($i=0; $i < sizeof($all_users); $i++) {
        //     if($all_users[$i] == $user){

        //         array_push($response_array, array(
        //         "id" => htmlspecialchars($id2[$i]),
        //         "time" => htmlspecialchars($times2[$i]),
        //         "other_event_text" => htmlspecialchars($events2[$i])
        //         ));
        //     }
        // }
        
        echo json_encode($response_array);
        $get_more_events->close();
        exit;
    } 
?> 