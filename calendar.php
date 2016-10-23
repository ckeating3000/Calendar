<!-- this script inspired by www.htmlbestcodes.com-Coded by: Krishna Eydat -->
<html>
    <head>
        <title>
            Calendar
        </title>
        <link rel="stylesheet" type="text/css" href="calendar.css" />
        <script>
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
                //even months have 31 days
                if(month % 2 !== 0){
                    numDays = 30;
                }
                if( month == 1 && !isLeapYear(year)){
                    numDays = 28;
                }
                if( month == 1 && isLeapYear(year)){
                    numDays = 29;
                }
                else{
                    numDays = 31;
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
            
            function addEvent(){
                
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
                    if(Calendar.getDay() === 0){
                        cal += '<tr>';
                    }
                    cal += '<td>' + Calendar.getDate() + '</td>';
                    if(Calendar.getDay() ==7){
                        //end row on saturday
                        cal += '</tr>';
                    }
                    //go through all the days in the month
                Calendar.setDate(k+2);
            }
            
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
                    if(Calendar.getDay() === 0){
                        cal += '<tr>';
                    }
                        cal += '<td id=date>' + Calendar.getDate() + '<div id=eventAdder>+ Event</div></td>';
                    if(Calendar.getDay() ==7){
                        //end row on saturday
                        cal += '</tr>';
                    }
                    //go through all the days in the month  
                Calendar.setDate(k+2);
            }
            cal+= '</table>';
            document.getElementById("calSpot").innerHTML = cal;
            }
        </script>
    </head>
    <body>
         <button id="prevMonth">Previous Month</button>
        <button id="nextMonth">Next Month</button>
        <script>
            
             //document.addEventListener("DOMContentLoaded", printCalendar, false);
            window.onload = firstCalendar ;
            var adv = new Date();
            var advMonth = adv.getMonth(); //put this somewhere it gets set once then can change at will
            var advYear = adv.getFullYear();
            if(advMonth != -1){
                document.getElementById("prevMonth").addEventListener("click", prevMonth, false);
                document.getElementById("nextMonth").addEventListener("click", nextMonth, false);
                document.getElementById("date").addEventListener("click", addEvent, false);
            }
            
        </script>
       
        
        <p id="calSpot">
            
        </p>
    </body>
</html>