<!-- this script inspired by www.htmlbestcodes.com-Coded by: Krishna Eydat -->
<html>
    <head>
        <title>
            Calendar
        </title>
        <link rel="stylesheet" type="text/css" href="calendar.css" />
        <script>
            function bleh(){
            var weekDays = new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
            var months = new Array('January','February','March','April','May','June','July','August','September','October','November','December');
            //obtain the current date/year to start there
            var Calendar = new Date();
            var year = Calendar.getFullYear();     // Returns year
            var month = Calendar.getMonth();    // Returns month (0-11)
            var dateCurr = Calendar.getDate();    // Returns day (1-31)
            var daysInMonth = 31;    // make variable
            var cal = '';    // where calendar table will be stored
            
            Calendar.setDate(1);    // Start the calendar day at '1'
            Calendar.setMonth(month);    // Start the calendar month at now
            
            cal += '<h1>' + months[month] + '                     ' + year +'<h1>';
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
                    if(Calendar.getDate == dateCurr){
                        cal += '<td><strong>' + currDate + '</strong></td>';
                    }
                    else{
                        cal += '<td>' + Calendar.getDate() + '</td>';
                    }
                    
                    
                    if(Calendar.getDay() ==7){
                        //end row on saturday
                        cal += '</tr>';
                    }
                    //go through all the days in the month
                   
                Calendar.setDate(Calendar.getDate()+1);
            }
            
            cal+= '</table>';
            document.getElementById("calSpot").innerHTML = cal;
            }
        </script>
    </head>
    <body>
        <script>
             //document.addEventListener("DOMContentLoaded", printCalendar, false);
            window.onload = bleh ;
            document.getElementById("prevMonth").addEventListener("click", bleh, false);
            document.getElementById("nextMonth").addEventListener("click", bleh, false);
        </script>
        <button id="prevMonth">Previous Month</button>
        <button id="nextMonth">Next Month</button>
        
        <p id="calSpot">
            
        </p>
    </body>
</html>