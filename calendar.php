<!DOCTYPE HTML>
<html>
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
        <button id="sharecalbutton">Share</button>
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
            <form name="login" class="form" id="login-form" action="#" method="POST">
                <!--form stores information about username and password-->
                <label for="userName">Username</label>
                <input type="text" id="username" name="username"><br>
                <label for="password">Password</label>
                <input type="password" id="password" name="userpass">
                <input type="submit" value="Login" />
            </form>
        </div>

        <div id="addEventer" title="Event Add">
            <p>Add an event</p> 
            <form class="form" name="addEv" id="addEvent" action="#" method="POST">
                <label for="date">Date</label>
                <input type="date" id="date" name="date"/> <br>
                <label for="time">Time</label>
                <input type="time" id="time" name="time"/> <br>
                <label for="eventTitle">Event Title</label>
                <input type="text" id="eventTitle" name="eventTitle"/> <br>
                <input type=submit name="Submit" value="Submit" id="event_submit"/>
            </form>
        </div>

        <div id="eventEditer" title="Event Edit">
            <p>Edit an event</p> 
            <form class="form" name="editEv" id="editEventForm" action="#" method="POST">
                <input type="hidden" id="edit_id" />  <!-- set value in function edit_dialog-->
                <input type="hidden" id="old_day" />  <!-- set value in edit_dialog -->
                <label for="date">Date</label>
                <input type="date" id="edit_date" name="date"/> <br>
                <label for="time">Time</label>
                <input type="time" id="edit_time" name="time"/> <br>
                <label for="eventTitle">Event Title</label>
                <input type="text" id="edit_text" name="eventTitle"/> <br>
                <input type=submit name="submit" value="submit" id="event_edit_submit"/>
            </form>
        </div>

        <div id="shareCalendar" title="Share Calendar">
            <p>Share with another user</p> 
            <form class="form" name="share" id="shareCal" action="#" method="POST">
                <label for="user">Enter user to share your events with</label>
                <input type="text" id="user_to_share_cal" name="other_cal_user"/> <br>
                <input type=submit name="submit" value="submit" id="share_cal_submit"/>
            </form>
        </div>

         <div id="shareEvent" title="Share Event">
            <p>Share with another user</p> 
            <form class="form" name="share" id="shareEv" action="#" method="POST">
                <input type="hidden" id="event_share_id" />
                <label for="user">Enter user to share your event with</label>
                <input type="text" id="user_to_share_ev" name="other_ev_user"/> <br>
                <input type=submit name="submit" value="submit" id="share_ev_submit"/>
            </form>
        </div>
        
        <script>
        //$('document').ready(function(){    
            //add event dialogue
            var global_username="";
            var global_token="";

            function addEvent(){
                $("#addEventer").dialog('open');
                $("#addEvent").show();
            }
            function addUser(){
                $("#addUser").dialog('open');
            }
            function shareCalDialog(){
                console.log("inside share cal dialog");
                $("#shareCalendar").dialog('open');
            }
            function shareEvDialog(event_id){
                console.log("inside share event dialog");
                $("#event_share_id").val(event_id);
                $("#shareEvent").dialog('open');
            }
            // function eventDelete(eventid){
            //     $("#delete_token").val(global_token);
            //     $("#delete_event_id").val(eventid);
            //     //var edit_event_text = $("#daySend > jsondata.id > event_text").val()
            //     $("#eventDeleter").dialog('open');
            // }
            function edit_dialog(id, day, time, date, text){
                $("#edit_id").val(id);
                $("#old_day").val(day);//original day
                $("#edit_date").val(date); //whole date, including month and year
                $("#edit_text").val(text);
                $("#edit_time").val(time);
                //$("#edit_day").val() = day; // user can change this
                //$("#edit_token").val(global_token);
                //$("#edit_event_id").val(eventid);
                $("#eventEditer").dialog('open');
            }
            
            function viewEvents(month, daySend, year){
                //check if session login variable is set
                //console.log("global_username: " + global_username)
                
                //if so, proceed to ajax query to get events for that day
                if(global_username!=""){
                    month = Number(month) + 1;
                    var string_day="";
                    //console.log("daysend:" + daySend);
                    
                    if(daySend < 10){
                        string_day += ("0"+ String(daySend));
                    }
                    else{
                        string_day+=String(daySend);
                    }
                    if(month < 10){
                        month = ("0"+ String(month));
                    }
                    else{
                        month=String(month);
                    }
                    //console.log("stirngday:" + string_day);

                    var year_month_day = year+"-"+month+"-"+string_day;
                    //php script called to get all events associated with user and date
                    
                    $.ajax({
                        'type' : "POST",
                        'url' : "event_view.php",
                        'data' : {
                            'dateSent' : year_month_day, // deleted comma after events
                        },
                        
                        'success' : function(data){
                            console.log("rawdata: " + data);

                            //var obj = jQuery.parseJSON(data);
                            //console.log("obj.id: " + obj.id);

                            var jsondata = JSON.parse(data);
                            var json_length = jsondata.length;
                            
                            if(json_length > 0){
                                for (var i = 0; i<json_length; i++)
                                {
                                    //add events to the calendar
                                    document.getElementById(daySend).innerHTML += "<div id='" + jsondata[i].id + "'>" + "<div class='event_text'>" +  jsondata[i].event_text + "</div>"+  "<br> Time: "  + "<div class='event_time'>" + jsondata[i].time + "</div>";

                                    //create edit and delete button for each event
                                    var delete_button = '<br> <button id="delete'+jsondata[i].id+'" onclick="event_delete('+jsondata[i].id+','+daySend+')">Delete</button>';
                                    
                                    var time = String(jsondata[i].time);
                                    //console.log("time: "+ time);
                                    var date = String(year_month_day);
                                    //console.log("date: "+ date);
                                    var text = jsondata[i].event_text;
                                    var edit_button = '<br> <button id="edit'+jsondata[i].id+'" onClick="edit_dialog(\'' + jsondata[i].id + '\',\'' + daySend + '\',\'' + time + '\',\'' + date + '\',\'' + text + '\')">Edit</button>';

                                    var share_button = '<br> <button id="share_ev'+jsondata[i].id+'" onClick="shareEvDialog(\'' + jsondata[i].id + '\')">Share</button>';
                                    //var edit_button = '<br> <button id="edit'+jsondata[i].id+'" onclick="edit_dialog('+jsondata[i].id+','+daySend+','+time+','+date+')">Edit</button>';

                                    // var stuff = '<br> <button id="delete'+jsondata[i].id+'" onclick="event_delete('+jsondata[i].id+','+daySend+')">Delete</button><button id="edit'+jsondata[i].id+'" onclick="edit_dialog('+jsondata[i].id+','+daySend+','+jsondata[i].event_text+','+jsondata[i].time+','+year_month_day+')">Edit</button><br>';

                                    //console.log("edit button " + edit_button);
                                    document.getElementById(daySend).innerHTML += delete_button;
                                    document.getElementById(daySend).innerHTML += edit_button;
                                    document.getElementById(daySend).innerHTML += share_button;

                                    var id = String(jsondata[i].id);
                                }
                            }
                        }
                    });
                    return false;
                }
            }
            function loginUser(){
                $("#loggerIn").dialog("open");
            }
            function logout(){
                global_username="";
                $.ajax({
                   'url' : "logout.php",
                   'success' : function(data){
                    alert(data);
                    console.log(data);
                    $("#logoutbutton").hide();
                    $("#eventAdder").hide();
                    $("#login").show();
                    $("#userAdder").show();
                    $("#sharecalbutton").hide();
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
                        $("#addUser").dialog('close');
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
                        var jsondata = JSON.parse(data)
                        alert(jsondata.message);
                        console.log(jsondata.message);
                        console.log(jsondata.result);
                        if(jsondata.result != ""){
                            global_username = jsondata.result;
                            global_token = jsondata.token;
                            $("#logoutbutton").show();
                            $("#login").hide();
                            $("#userAdder").hide();
                            $("#eventAdder").show();
                            $("#logoutbutton").show();
                            $("#sharecalbutton").show();
                            firstCalendar();
                        }
                        //close the window and wipe the form
                        $("#loggerIn").dialog('close');
                        $("#username").val("");
                        $("#password").val("");
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
                        $("#addEventer").dialog('close');
                        firstCalendar();
                    }
                });
                return false;
            }

            function event_delete(id,day){
                console.log("day: " + day);
                var go_ahead = confirm("Are you sure you want to delete");
                if(go_ahead){
                    //console.log("in eventdelete")
                    //var delete_event_text = $("#daySend > jsondata.id > event_text").val();
                    
                    var data = {"id": id, "token": global_token};
                    //console.log("event id: " + id);
                    //var data = $("#eventDelete1").serialize();
                    //console.log("DATA:" + data);
                    //data = data + global_token;
                    $.ajax({
                        'type': "POST",
                        'url': "event_delete.php",
                        'data' : data,
                        'success': function(response){
                            console.log("in response");
                            console.log(response);
                            if(response == "Content successfully deleted"){
                                console.log("inside if");
                                console.log("#"+day+" > "+id);
                                //console.log("day: " + $("#"+day).val());
                                //console.log($("#"+day+" > "+id).val());
                                //$("#"+day+" > "+id +" > event_text").remove();
                                //$("#"+day+" > "+id +" > event_time").remove();
                                $("#"+day+" > "+id).remove();
                                firstCalendar();
                            }
                        }
                    });
                    return false;
                }
            }

            function share_calendar(){
                console.log("inside share cal function");
                var other_user = $("#user_to_share_cal").val();
                console.log("other calendar user: " + other_user);

                var go_ahead = confirm("Are you sure you want to share all your events with " + other_user + "?");
                if(go_ahead){
                    var data = {"other_user": other_user, "token": global_token};
                    $.ajax({
                        'type': "POST",
                        'url': "calendar_share.php",
                        'data' : data,
                        'success': function(response){
                            console.log("in response");
                            console.log(response);
                            if(response == "Calendar successfully shared"){
                                $("#shareCalendar").dialog('close');
                                alert("Calendar successfully shared");
                                console.log("inside if");
                                //firstCalendar();
                            }
                        }
                    });
                    return false;
                }
            }

            function share_event(){
                console.log("inside share event function");
                var other_user_event = $("#user_to_share_ev").val();
                var event_id = $("#event_share_id").val();
                 console.log("event id: " + event_id);
                console.log("other event user: " + other_user_event);

                var go_ahead = confirm("Are you sure you want to share this event with " + other_user_event + "?");
                if(go_ahead){
                    
                    var data = {"other_user": other_user_event, "event_id": event_id, "token": global_token};
                    
                    $.ajax({
                        'type': "POST",
                        'url': "event_share.php",
                        'data' : data,
                        'success': function(response){
                            console.log("in response");
                            console.log(response);
                            if(response == "Event successfully shared"){
                                $("#shareEvent").dialog('close');
                                alert("Event successfully shared");
                                console.log("inside if");
                                //firstCalendar();
                            }
                        }
                    });
                    return false;
                }
            }

            function eventEdit(){
                console.log("inside eventEdit");
                var original_day = $("#old_day").val();
                var id = $("#edit_id").val();
                console.log("id: " + id);
                console.log("original day: " + original_day);
                var edit_event_text = $("#edit_text").val();
                var edit_event_time = $("#edit_time").val();
                var edit_event_date = $("#edit_date").val();
                
                var data = {"id": id, "token": global_token, "text": edit_event_text, "time": edit_event_time, "date": edit_event_date};
                console.log("edit data: " + data);
                //console.log("DATA:" + data);
//ended here.  Need to append the "data" string with the token by seeing how it prints out and then pass the whole thing to ajax/php and in php, compare the session_token with passed token
                //data = data + global_token;
                $.ajax({
                    'type': "POST",
                    'url': "event_edit.php",
                    'data' : data,
                    'success': function(response){
                        console.log("in response");
                        console.log(response);
                        if(response == "Content successfully changed"){
                            $("#eventEditer").dialog('close');
                            firstCalendar();
                            //console.log("inside if");
                            // first check to see if the event is inthe current month, if not, remove event
                            // if it is in the current month, change the day property and so on.
                            //$("#"+day+" > "+id+" > " + event_text).val(edit_event_text);// change day
                            //$("#"+day+" > "+id+" > " + event_text).val(edit_event_text);// change text
                            //$("#"+day+" > "+id+" > " + event_time).val(edit_event_time);// change time

                            //console.log("#"+day+" > "+id);
                            //console.log("day: " + $("#"+day).val());
                            //console.log($("#"+day+" > "+id).val());
                            //$("#"+day+" > "+id).remove();

                            //change day variable to new date and update the text, time, and date of the event in the calendar
                        }
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
                    //viewEvents(month, Calendar.getDate(), year);

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
                for(var k=0; k< daysInMonth; k++){
                    viewEvents(month, k+1, year);
                    //var id = k+1;
                    //$("#"+id).click(function(event){ //
                    //    
                    //}
                    //);
                }
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
                for(var k=1; k<= daysInMonth; k++){
                    //at sunday, start a new row
                    if(Calendar.getDay()===0){
                        cal += '<tr>';
                    }
                    dateString = Calendar.getDate();
                    cal += '<td>' + Calendar.getDate() + '<div id="'+dateString +'"></div></td>';
                    //viewEvents(month, Calendar.getDate(), year);

                    if(Calendar.getDay()===7){
                        //end row on saturday
                        cal += '</tr>';
                    }
                    //go through all the days in the month
                    Calendar.setDate(k+1); //Calendar.setDate(k+2);
                }
                
                //  for(var h=Calendar.getDay(); h< 7; h++){
                //    cal += '<td>  </td>';
                //}
                cal+= '</table>';
                document.getElementById("calSpot").innerHTML = cal;
                for(var k=0; k < daysInMonth; k++){
                    viewEvents(month, k+1, year);
                    var id = k+1;
                    //$("#delete"+id).on("click", $("#eventDeleter").dialog('open'));
                }
                //$("td").on('click', viewEvents(month, $(this.target).val(), year));
                //$("#calendar").on('click', '.btnSelect', viewEvents(month, year));
            }
            //everything that loads upon page load
            function start() {
                //check for login and display appropriate buttons
                
                if(global_username != ""){
                    $("#login").hide();
                    $("#logoutbutton").show();
                    $("#userAdder").hide();
                    $("#eventAdder").show();
                    //$("#sharecalbutton").show();
                }
                else{
                    $("#login").show();
                    $("#logoutbutton").hide();
                    $("#userAdder").show();
                    $("#eventAdder").hide();
                    $("#sharecalbutton").hide();
                }
                
                //listeners for the add event, user and login buttons
                document.getElementById("eventAdder").addEventListener("click", addEvent, false);
                document.getElementById("userAdder").addEventListener("click", addUser, false);
                document.getElementById("login").addEventListener("click", loginUser, false);
                document.getElementById("logoutbutton").addEventListener("click", logout, false);
                document.getElementById("sharecalbutton").addEventListener("click", shareCalDialog, false);
                //jquery listeners for the add event and add user forms
                
                $("#addEvent").on("submit", function(event){
                    event.preventDefault();
                    eventAdder();
                });
                $('#addEventer').dialog({autoOpen: false});

                $("#register").on("submit", function(event){
                    event.preventDefault();
                    userAdder();
                });
                $('#addUser').dialog({autoOpen: false});

                $("#login-form").on("submit", function(event){
                    event.preventDefault();
                    userLogger();
                });
                $('#loggerIn').dialog({autoOpen: false});

                $("#editEventForm").on("submit", function(event){
                    event.preventDefault();
                    eventEdit();
                });
                $('#eventEditer').dialog({autoOpen: false});

                $("#shareCal").on("submit", function(event){
                    event.preventDefault();
                    share_calendar();
                });
                $('#shareCalendar').dialog({autoOpen: false});

                $("#shareEv").on("submit", function(event){
                    event.preventDefault();
                    share_event();
                });
                $('#shareEvent').dialog({autoOpen: false});

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