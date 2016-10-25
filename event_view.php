                <?php
                session_start();
                //display events on the date selected
                require 'database.php';
                $get_events = $mysqli->prepare("select time, event_text from events where date=?, username=?");
                if(!$get_events){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
                $get_events->bind_param('is', $date, $user);
                $get_events->execute();
                $get_events->bind_result($time, $event);
                 
                while($get_events->fetch()){
					//nonusers can only see comments from other users
                        printf(" %s %u",
                        "Event title: ".htmlspecialchars($event),
                        "Event time: ".htmlspecialchars($time)
                    );
                } 
                $get_events->close();
                ?> 