
<!DOCTYPE HTML>
<html>
    <?php
    session_start();
    if(isset($_SESSION['Login'])){
        session_destroy();
        session_start();
    }
    ?>
    <!-- this script inspired by www.htmlbestcodes.com-Coded by: Krishna Eydat -->
    <head>
        <title>Calendar</title>
        <link rel="stylesheet" type="text/css" href="calendar.css" />
        <!--load jquery to the page-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <!--jquery ui for forms-->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">
            //forms go here
        </script> 
    </head>
    
    <body>
        <!--buttons to move between months-->
        <button id="prevMonth">Previous Month</button>
        <button id="nextMonth">Next Month</button>
        <!--buttons to add events,users and log in -->
        <button id="eventAdder">Add Event</button>
        <button id="login">Login</button>
        <button id="userAdder">Register</button>
        <button id="logoutbutton">Logout</button>
        <div id="indevent"></div>
        <!--where the calendar will print out-->
        <p id="calSpot"> </p>
        
        <div id="addUser" title="Join Our Site">
            <p>Register to add and view events</p> 
            <form class="form" id="register" action="#" method="POST">
                <!--form stores information about username and password-->
                <div id="message"> </div>
                <label for="userName">Username</label>
                <input type="text" id="userName" name="newname"><br>
                <label for="newPassword">Password</label>
                <input type="password" id="newPassword" name="newpass">
                <button id="register-submit">Register</button>
            </form>
        </div>

        <div id="loggerIn" title="User Login">
            <p>Login to add and view your events</p> 
            <form name="login"  id="login-form" action="#" method="POST">
                <!--form stores information about username and password-->
                <label for="userName">Username</label>
                <input type="text" id="username" name="username"><br>
                <label for="password">Password</label>
                <input type="password" id="password" name="userpass">
                <input type="submit" value="Login" />
            </form>
        </div>


        <div id="addEventer" title="Event Add">
            <form id="addEvent" action="#" method="post">
                <!--date and time fields may not always be supported, consider one of these options or may want to figure out our own fields-->
                <?php  $token = $_SESSION["token"]; ?>
                <input type="hidden" name="token" value="<?php echo $token;?>" />
                <label for="date">Date</label>
                <input type="date" id="date" name="date"/> <br>
                <label for="time">Time</label>
                <input type="time" id="time" name="time"/> <br>
                <label for="eventTitle">Event Title</label>
                <input type="text" id="eventTitle" name="eventTitle"/> <br>
                <input type=submit name="Submit" value="Submit" id="event_submit"/>
            </form>
        </div>
        
        <script>
        //$('document').ready(function(){    
            //add event dialogue
            function addEvent(){
                $("#addEvent").dialog();
            }
            function addUser(){
                $("#addUser").dialog();
            }
             function eventDelete(){
                alert("Where deleting will happen");
             }
             function eventEdit(){
                alert("Where editing form will pop up");
             }
            
            function viewEvents(month, daySend, year){
                month = Number(month) + 1;
                var events = year+"-"+month+"-"+daySend;
                //php script called to get all events associated with user and date
                $.ajax({
                    'type' : "POST",
                    'url' : "event_view.php",
                    'data' : {
                        'dateSent' : events,
                    },
                    
                    'success' : function(data){
                        console.log(data);
                        document.getElementById(daySend).innerHTML = data;
                        if(data != "You must log in to view events"){
                            //var idreg = "\d+";
                            //var id = data.match(idreg);
                            $(".eventdisplay").click(function(data){
                                //show event popout for editing/deleting when event is clicked
                                var stuff = '<br><div>'+data+'</div><button id="delete-button">Delete</button><button id="edit-button">Edit</button>';
                                document.getElementById("indevent").innerHTML = stuff;
                                $("#delete-button").on("click", eventDelete);
                                 $("#edit-button").on("click", eventEdit);
                            }
                                                     
                            );
                        }
                        //send event id as json data
                        //not working yet, want to display the event with buttons to edit or delete
                        //https://forum.jquery.com/topic/hidden-value-in-a-ajax-data-response-in-html
                        
                    }
                });
                return false;
 
            }
            function loginUser(){
                $("#loggerIn").dialog();
            }
            function logout(){
                $.ajax({
                   'url' : "logout.php",
                   'success' : function(data){
                     alert(data);
                    console.log(data);
                    $("#logoutbutton").hide();
                    $("#eventAdder").hide();
                    $("#login").show();
                    $("#userAdder").show();
                    firstCalendar();
                    //logged out users shouldn't be able to add events, don't need to logout and need to register
                   }
                });
                return false;
                
            }
            //adapted from https://www.formget.com/jquery-registration-form/
            function userAdder(){
                var data = $("#register").serialize();
                  $.ajax({
                     'type' : "POST",
                     'url'  : "add_new_user.php",
                     'data' : data,
                     'beforeSend' :function(){
                         var name = $("#userName").val();
                         var password = $("#newPassword").val();
                         if (name === '' || password === '') {
                             alert("you must fill in both fields");
                         }
                         //else if ((password.length) < 8) {
                         //    alert("Password should be at least 8 character in length");
                         //}
                     },
                     'success': function(data) {
                        alert(data);
                        console.log(data);
                         if (data == 'You have registered') {
                             $("#register")[0].reset(); // reset form
                             //document.getElementById("message").innerHTML="You successfully registered";
                         }
                     }
                 });
                return false;
            }
            function userLogger(){
                var data = $("#login-form").serialize();
                $.ajax({
                    'type' : "POST",
                    'url'  : "login.php",
                    'data' : data,
                    'beforeSend' : function(){
                        var name = $("#username").val();
                        var password = $("#password").val();
                        if (name === '' || password === '') {
                            alert("you must fill in both fields");
                        }
                    },
                    'success' : function(data){
                    alert(data);
                    console.log(data);
                    if(data == "Login successful"){
                        $("#logoutbutton").show();
                        //check if session login variable is set, if so, then assign to title
                        //<?php 
                        //    $user;
                        //    if(isset($_SESSION["login"])){
                        //        $user = $_SESSION["login"];
                        //    }else{
                        //        $user="";
                        //    }
                        //?>;
                        

                        //logged in users can add events and don't need the register button
                        $("#login").hide();
                        $("#userAdder").hide();
                        $("#eventAdder").show();
                        firstCalendar();
                        
                    }
                    }
                });
                return false;
            }
            function eventAdder(){
                var data = $("#addEvent").serialize();
                $.ajax({
                    'type': "POST",
                    'url': "event_add.php",
                    'data' : data,
                    'success': function(data){
                        console.log(data);
                        alert(data);
                        firstCalendar();
                    }
                });
                return false;
            }

            //checking for leapyears to get days in february http://stackoverflow.com/questions/725098/leap-year-calculation
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
                if(month==3 || month==5 || month==8 || month==10){
                    numDays=30;
                }
                else if( month==1 && !isLeapYear(year)){
                    numDays=28;
                }
                else if( month==1 && isLeapYear(year)){
                    numDays=29;
                }
                else{
                    numDays=31;
                }
                return numDays;
            }
            //move between months infinitely

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
                var dateString ;
                //set header to current month
                cal += '<h1>' + months[month] + ' ' + year +'<h1>';
                //make table to display days of month
                cal += '<table id="calendar"><tr>';
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
                    dateString = Calendar.getDate();
                     cal += '<td>' + Calendar.getDate() + '<div id="'+dateString +'"></div></td>';
                    viewEvents(month, Calendar.getDate(), year);
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
                var dateString ;
                
                Calendar.setDate(1);    // Start the calendar day at '1'
                Calendar.setMonth(month);    // Start the calendar month at now
                Calendar.setFullYear(year);
                
                cal += '<h1>' + months[month] + ' ' + year +'<h1>';
                cal += '<table id="calendar"><tr>';
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
                     dateString = Calendar.getDate();
                        cal += '<td>' + Calendar.getDate() + '<div id="'+dateString +'"></div></td>';
                        viewEvents(month, Calendar.getDate(), year);
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
                //$("td").on('click', viewEvents(month, $(this.target).val(), year));
                //$("#calendar").on('click', '.btnSelect', viewEvents(month, year));
            }
            //everything that loads upon page load
            function start() {
                $("#eventAdder").hide();
                $("#logoutbutton").hide();
                
                //listeners for the add event, user and login buttons
                document.getElementById("eventAdder").addEventListener("click", addEvent, false);
                document.getElementById("userAdder").addEventListener("click", addUser, false);
                document.getElementById("login").addEventListener("click", loginUser, false);
                document.getElementById("logoutbutton").addEventListener("click", logout, false);
                //jquery listeners for the add event and add user forms
                $("#addEvent").on("submit", function(event){
                    event.preventDefault();
                    eventAdder();
                });
                $("#register").on("submit", function(event){
                    event.preventDefault();
                    userAdder();
                });
                $("#login-form").on("submit", function(event){
                    event.preventDefault();
                    userLogger();
                });
                firstCalendar();
                //$("#registerSub").click(register);
            }
            window.onload = start;
            
            var adv = new Date();
            var advMonth = adv.getMonth(); //put this somewhere it gets set once then can change at will
            var advYear = adv.getFullYear();
            if(advMonth!= -1){
                document.getElementById("prevMonth").addEventListener("click", prevMonth, false);
                document.getElementById("nextMonth").addEventListener("click", nextMonth, false);
            }

        //});
        </script>
        

    </body>
</html>