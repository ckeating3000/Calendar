<!-- this script inspired by www.htmlbestcodes.com-Coded by: Krishna Eydat -->
<html>
    <head>
        <title>
            Calendar
        </title>
        <link rel="stylesheet" type="text/css" href="calendar.css" />
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js">//load jquery to the page</script>
        <!--jquery ui for forms-->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">
            //forms go here
        </script>

        <script>
            //add event dialogue
            function addEvent(){
                $("#addEvent").dialog();
            }
            function addUser(){
                $("#addUser").dialog();
            }
            function viewEvents(){
                $("#viewEvents").dialog();
            }
             function loginUser(){
                $("#loggerIn").dialog();
            }
        
            
            //cheacking for leapyears to get days in february http://stackoverflow.com/questions/725098/leap-year-calculation
            function isLeapYear(year){
                var leapYear ;
                if ((year % 4 === 0 && year % 100 !== 0) || year % 400 === 0){
                    leapYear=true;
                }
                else {
                    leapYear =false;
                }
                return leapYear;
            }
            function monthDays(month, year) {
                var numDays ;
                
                //      April        june          September    November
                if(month===3 || month===5 || month===8 || month===10){
                    numDays=30;
                }
                if( month===1 && !isLeapYear(year)){
                    numDays=28;
                }
                if( month===1 && isLeapYear(year)){
                    numDays=29;
                }
                else{
                    numDays=31;
                }
                return numDays;
            }
            //trying to be able to move between months infinitely

            function prevMonth(){
                if(advMonth > 0){
                   advMonth = advMonth -1;
                    displayCalendar(advMonth, advYear); 
                }
                else{
                    advMonth = 11;
                    advYear = advYear -1;
                    displayCalendar(advMonth, advYear); 
                }
                
            }
            function nextMonth(){
                if(advMonth < 11){
                    advMonth = advMonth +1;
                    displayCalendar(advMonth, advYear);
                }
                else{
                    advMonth = 0;
                    advYear = advYear +1;
                    displayCalendar(advMonth, advYear);
                }
                
            }
            
            //load other months
            function displayCalendar(mo, year){
                var weekDays = new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
                var months = new Array('January','February','March','April','May','June','July','August','September','October','November','December');

                //obtain the current date/year to start there
                var Calendar = new Date();   
                var month = mo;    // Returns month (0-11)
                var daysInMonth = monthDays(month, year);    // call function
                var cal = '';    // where calendar table will be stored
                Calendar.setDate(1);    // Start the calendar day at '1'
                Calendar.setMonth(month);    // Start the calendar month at now
                Calendar.setFullYear(year);
                //set header to current month
                cal += '<h1>' + months[month] + ' ' + year +'<h1>';
                //make table to display days of month
                cal += '<table><tr>';
                for(var i= 0; i< 7; i++){
                    cal += '<th>' +weekDays[i] +'</th>';
                }
                cal += '</tr>';
                //make gaps until the first day of the month
                for(var j=0; j< Calendar.getDay(); j++){
                    cal += '<td>  </td>';
                }
                //put days in the calendar
                for(var k=0; k< daysInMonth; k++){
                    //at sunday, start a new row
                    if(Calendar.getDay()===0){
                        cal += '<tr>';
                    }
                    cal += '<td id="date">' + Calendar.getDate() + '</td>';
                    if(Calendar.getDay()===7){
                        //end row on saturday
                        cal += '</tr>';
                    }
                    
                    //go through all the days in the month
                    Calendar.setDate(k+2);
                }
                  //for(var h=Calendar.getDay(); h< 7; h++){
                  //  cal += '<td>  </td>';
                  //  }
                cal+= '</table>';
                document.getElementById("calSpot").innerHTML = cal;
               $("td").click(viewEvents);
            }
            
            //first load
            function firstCalendar(){

                var weekDays = new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
                var months = new Array('January','February','March','April','May','June','July','August','September','October','November','December');
                //obtain the current date/year to start there
                var Calendar = new Date();   
                var month = Calendar.getMonth();    // Returns month (0-11)
                var year = Calendar.getFullYear();
                var daysInMonth = monthDays(month, year);    // make variable
                var cal = '';    // where calendar table will be stored
                
                Calendar.setDate(1);    // Start the calendar day at '1'
                Calendar.setMonth(month);    // Start the calendar month at now
                Calendar.setFullYear(year);
                
                cal += '<h1>' + months[month] + ' ' + year +'<h1>';
                cal += '<table><tr>';
                for(var i= 0; i< 7; i++){
                    cal += '<th>' +weekDays[i] +'</th>';
                }
                cal += '</tr>';
                //make gaps until the first day of the month
                for(var j=0; j< Calendar.getDay(); j++){
                    cal += '<td>  </td>';
                }
                //put days in the calendar
                for(var k=0; k< daysInMonth; k++){
                    //at sunday, start a new row
                    if(Calendar.getDay()===0){
                        cal += '<tr>';
                    }
                        cal += '<td id="date">' + Calendar.getDate() + '</td>';
                    if(Calendar.getDay()===7){
                        //end row on saturday
                        cal += '</tr>';
                    }
                    //go through all the days in the month  
                    Calendar.setDate(k+2);
                }
                //  for(var h=Calendar.getDay(); h< 7; h++){
                //    cal += '<td>  </td>';
                //}
                cal+= '</table>';
                document.getElementById("calSpot").innerHTML = cal;
                $("td").click(viewEvents);
            }
        </script>
    </head>
    <body>
        <!--buttons to move between months-->
        <button id="prevMonth">Previous Month</button>
        <button id="nextMonth">Next Month</button>
        <button id="eventAdder">Add Event</button>
         <button id="login">Login</button>
        <button id="userAdder">Register</button>
        
           <div id="addUser" title="Join Our Site">
       <p>Register to add and view events</p> 
            <form name="add_new_user"  action="add_new_user.php" method="POST">
                <!--form stores information about username and password-->
                <label for="userName">Username</label>
                 <input type="text" id="userName" name="newname"><br>
                 <label for="newPassword">Password</label>
               <input type="password" id="newPassword" name="newpass">
                <input type="submit" value="Join our site" />
                
            </form>
        </div>
           <div id="loggerIn" title="User Login">
       <p>Login to add and view your events</p> 
            <form name="add_new_user"  action="login.php" method="POST">
                <!--form stores information about username and password-->
                <label for="userName">Username</label>
                 <input type="text" id="username" name="newname"><br>
                 <label for="newPassword">Password</label>
               <input type="password" id="password" name="newpass">
                <input type="submit" value="Login" />
                
            </form>
        </div>
        <!--where the calendar will print out-->
        <p id="calSpot"> </p>
        <div id="addEvent" title="Event Add">
            <form name="addEvent" action="event_add.php" method="post">
                <label for="date">Date</label>
                <input type="date" id="date" name="date"/> <br>
                <label for="time">Time</label>
                <input type="time" id="time" name="time"/> <br>
                <label for="eventTitle">Event Title</label>
                <input type="text" id="eventTitle" name="eventTitle"/> <br>
                <input type=submit name="Submit" value="Submit" id="Submit"/>
            </form>
        </div>
     

        <div id="viewEvents" title="Events">
            View the events on this day
                <?php
//                session_start();
//                //display events on the date selected
//                require 'database.php';
//                $get_events = $mysqli->prepare("select time, event_text from events where date=?, username=?");
//                if(!$get_events){
//                    printf("Query Prep Failed: %s\n", $mysqli->error);
//                    exit;
//                }
//                $get_events->bind_param('is', $date, $user);
//                $get_events->execute();
//                $get_events->bind_result($time, $event);
//                 
//                while($get_events->fetch()){
//					//nonusers can only see comments from other users
//                        printf(" %s %u",
//                        "Event title: ".htmlspecialchars($event),
//                        "Event time: ".htmlspecialchars($time)
//                    );
//                } 
//                $get_events->close();
                ?>
                
        </div>
        
        <script>
            function start() {
                firstCalendar();
                document.getElementById("eventAdder").addEventListener("click", addEvent, false);
                document.getElementById("userAdder").addEventListener("click", addUser, false);
                document.getElementById("login").addEventListener("click", loginUser, false);

            }
            window.onload = start;
            
            var adv = new Date();
            var advMonth = adv.getMonth(); //put this somewhere it gets set once then can change at will
            var advYear = adv.getFullYear();
            if(advMonth!= -1){
                document.getElementById("prevMonth").addEventListener("click", prevMonth, false);
                document.getElementById("nextMonth").addEventListener("click", nextMonth, false);
            }
            
        </script>
    </body>
</html>