<!-- this script inspired by www.htmlbestcodes.com-Coded by: Krishna Eydat -->
<html>
    <head>
        <script>
            function printCalendar() {
                
            
            var weekDays = new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
            var months = new Array('January','February','March','April','May','June','July','August','September','October','November','December');
            //obtain the current date/year to start there
            var cal = new Date();
            var year = cal.getFullYear();     // Returns year
            var month = cal.getMonth();    // Returns month (0-11)
            var date = cal.getDate();    // Returns day (1-31)
            var day = cal.getDay();    // Returns day (1-31)
            
            var daysInWeek = 7;    // constant for number of days in a week
            var daysInMonth = 31;    // make variable
            var calTable = '<table><tr><td><table>';    // where calendar table will be stored
            
            Calendar.setDate(1);    // Start the calendar day at '1'
            Calendar.setMonth(month);    // Start the calendar month at now
            
            calTable += '<center>' + months[month] + '    ' + year +'</tr><td>';
             
            for(var i= 0; i< daysInWeek; i++){
                calTable += '<th id="'+ weekDays[i] +'">' + weekDays[i] + '</th>';
            }
            
            //make gaps until the first day of the month
            for(var j=0; j< Calendar.getDay(); j++){
                calTable += '<td>  </td>';
            }
            
            //put days in the calendar
            for(var k=0; k< daysInMonth; k++){
                if(Calendar.getDate() > k){
                    
                    //at sunday, start a new row
                    if(Calendar.getDay() === 0){
                        calTable += '<tr>';
                    }
                    
                    if( today ==Calendar.getDate()){
                        calTable += highlight_start + date + highlight_end + '</td>';
                    }
                    
                    else{
                        calTable += '<td>' + date + '</td>';
                    }
                    if(Calendar.getDay() ==7){
                        //end row on saturday
                        calTable += '</tr>';
                    }
                    //go through all the days in the month
                   
                }
                Calendar.setDate(Calendar.getDate()+1);
            }
            
            calTable+= '</table></tr></td></table>';
            
           document.createElement(calTable);

            }
        </script>
    </head>
    <body>
        <script>
             document.addEventListener("DOMContentLoaded", printCalendar, false);
        </script>
    </body>
</html>