
Validation.add('validate-time-last', 'Unable to save , End time Must be greater then Start time', function(v) {
    var starttime = jQuery('.validate-time-first').val();
    // var starttime = jQuery('.validate-time-first').val();
    console.log(starttime);
    console.log(v);
    if (parseInt(v) > parseInt(starttime))
    {
        return true;
    }
    return false;

});
Validation.add('validate-time-last1', 'Unable to save , End time Must be greater then Start time', function(v) {
    var starttime = jQuery('.validate-time-first1').val();

    if (parseInt(v) > parseInt(starttime))
    {
        return true;
    }
    return false;

});


var arrayintervaltime = '';
function timeIntervalArray(value) {
    arrayintervaltime = value;
    console.log(arrayintervaltime);
}
var arraydateintervaltime = '';
function timeDateIntervalArray(value) {
    arraydateintervaltime = value;
}
var timebuffersameday = '';
function timeBufferSameDay(value) {
    timebuffersameday = value;
}
function displayFormat(value) {
    $displayformat = value;
}
function timeIntervalAdmin(value) {
    $timeIntervalAdmin = value;
}
jQuery(document).ready(function() {
    jQuery(document).on('change', '#deliverydate', function() {
        /*
         * get the delivery date form date picker on change
         */
        var deliverydate = jQuery('#deliverydate').val();
        /*
         * converter all time interval into the two array array1 interval start time 
         * and array2 interval end time
         */
        if (arrayintervaltime !== undefined || arrayintervaltime !== null || arrayintervaltime.length !== 0) {
            var array1 = arrayintervaltime[0];
            var array2 = arrayintervaltime[1];
        }

        /*
         * converter all datetieminterval into the three  array dtarray1 interval start time , 
         *  dtarray2 interval end time and dtarray3 is date 
         */
        if (arraydateintervaltime !== undefined || arraydateintervaltime !== null || arraydateintervaltime.length !== 0) {
            var dtarray1 = arraydateintervaltime[0];
            var dtarray2 = arraydateintervaltime[1];
            var dtarray3 = arraydateintervaltime[2];

        }

        var fullDate = new Date();
        var sdate = (fullDate.getMonth() + 1) + '/' + fullDate.getDate() + '/' + fullDate.getFullYear();
        var d1 = new Date(sdate);
        /*
         *  create delivery date object ,delivery date from datepicker
         */
        var d2 = new Date(deliverydate);
        var currenthours = jQuery('#currenthours').text();

        jQuery('.timeinterval').empty();
        var timeinterval = jQuery('#timeinterval').text();

//        var timeobject = new Date();
//        timeobject.setHours(00, 00);
        /*create date object
         * set defautl time 
         */
        var timeobject1 = new Date();
        timeobject1.setHours(00, 00);
        var day = parseInt(timeobject1.getDate());//

        if (d1.getDate() == d2.getDate())
        {
            var time = currenthours;
            /*
             * set current hours and minutes to date object 
             */
            arr = time.split(':');
            timeobject1.setHours(arr[0]);
            timeobject1.setMinutes(arr[1]);
            var i = parseInt(arr[0] * 60) + parseInt(arr[1]);
             jQuery('.timeinterval').append('<option value="-1" style="display:none"></option>');
            for (var i; i < 1440; i += parseInt(timeinterval)) {

                timeobject1 = new Date(timeobject1.getTime() + timeinterval * 60000);

                /*
                 * add timeinterval(mins) to timeobject1(dateobject)
                 */
                var newTime = timeobject1.getHours() + ':' + timeobject1.getMinutes();
                if (parseInt(timeobject1.getDate()) > day)
                {
                    newTime = '24:00';
                }
                /*
                 * this is use for  the disable time interval which is create by the admin   array1 and array2 are two
                 * array of timeinterval values  like array1[j] is stating interval and array2[j]  end of interval
                 * j is depend on interval no. of interval which is decide by admin
                 */
                var timeinter = parseFloat(timeinterval / 60);

                var time1 = time.replace(":", ".");

                var newTime1 = newTime.replace(":", ".");


                var count = 1;
                for (var j = 0; j < array1.length; j++) {
                    if (((parseFloat(time1) >= parseFloat(array1[j])) || (parseFloat(newTime1) >= parseFloat(array1[j])))) {
                        if ((parseFloat(newTime1) <= parseFloat(array2[j]))) {
                            count++;
                        }
                        else if ((((parseFloat(time1) + timeinter) >= parseFloat(array2[j])) && (parseFloat(time1) < parseFloat(array2[j])))) {
                            count++;
                        }
                        if (parseFloat(newTime1) === parseFloat(array1[j])) {
                            count--;

                        }

                    }
                }
                /*
                 * create array of date object for test on which date the  time interval work
                 */
                var count1 = 1;

                for (var k = 0; k < dtarray3.length; k++) {
                    var datetimeintervalobject = new Date(dtarray3[k]);

                    if (((parseFloat(time1) >= parseFloat(dtarray1[k])) || (parseFloat(newTime1) >= parseFloat(dtarray1[k]))) && (d2.getDate() === datetimeintervalobject.getDate())) {
                        if ((parseFloat(newTime1) <= parseFloat(dtarray2[k]))) {
                            count1++;

                        }
                        else if ((((parseFloat(time1) + timeinter) >= parseFloat(dtarray2[k])) && (parseFloat(time1) < parseFloat(dtarray2[k])))) {
                            count1++;
                        }
                        if (parseFloat(newTime1) === parseFloat(dtarray1[k])) {
                            count1--;

                        }


                    }

                }

                if ((count > 1) || (count1 > 1)) {
                    var displaysetting = 'display:none;';
                } else {
                    var displaysetting = 'display:block;';
                }
                /* here is setting for AM and PM list 
                 * 
                 */
                time1 = parseFloat(time1);
                time1 = time1.toFixed(2);

                newTime1 = parseFloat(newTime1);
                newTime1 = newTime1.toFixed(2);

                if (parseInt($displayformat) === 1) {
                    if (parseFloat(time1) < 12) {
                        var timeampm = time1 + 'AM';
                    }
                    else {
                        if (parseFloat(time1) >= 13) {
                            time1 = time1 - 12;
                            time1 = time1.toFixed(2);
                            var timeampm = time1 + 'PM';
                        } else {
                            var timeampm = time1 + 'PM';
                        }

                    }
                    if (parseInt(newTime) < 12) {
                        var newTimeampm = newTime1 + 'AM';
                    } else {
                        if (parseFloat(newTime) >= 13) {
                            newTime1 = newTime1 - 12;
                            newTime1 = newTime1.toFixed(2);
                            var newTimeampm = newTime1 + 'PM';
                        }
                        else {
                            var newTimeampm = newTime1 + 'PM';
                        }
                    }
                } else {
                    var timeampm = time1;
                    var newTimeampm = newTime1;
                }

                jQuery('.timeinterval').append("<option style=" + displaysetting + " value=" + time + "-" + newTime + ">" + timeampm + "-" + newTimeampm + "</option>");
                time = newTime;
            }


        }
        else {

            var time = timeobject1.getHours() + ':' + timeobject1.getMinutes();
             jQuery('.timeinterval').append('<option value="-1" style="display:none"></option>');
            for (var i = 0; i < 1440; i += parseInt(timeinterval)) {
                timeobject1 = new Date(timeobject1.getTime() + timeinterval * 60000);

                /*
                 * add timeinterval(mins) to timeobject1(dateobject)
                 */
                var newTime = timeobject1.getHours() + ':' + timeobject1.getMinutes();
                if (parseInt(timeobject1.getDate()) > day)
                {
                    newTime = '24:00';
                }
                /*
                 * this is use for  the disable time interval which is create by the admin   array1 and array2 are two
                 * array of timeinterval values  like array1[j] is stating interval and array2[j]  end of interval
                 * j is depend on interval no. of interval which is decide by admin
                 */
                var timeinter = parseFloat(timeinterval / 60);

                var time1 = time.replace(":", ".");

                var newTime1 = newTime.replace(":", ".");


                var count = 1;
                for (var j = 0; j < array1.length; j++) {
                    if (((parseFloat(time1) >= parseFloat(array1[j])) || (parseFloat(newTime1) >= parseFloat(array1[j])))) {
                        if ((parseFloat(newTime1) <= parseFloat(array2[j]))) {
                            count++;
                        }
                        else if ((((parseFloat(time1) + timeinter) >= parseFloat(array2[j])) && (parseFloat(time1) < parseFloat(array2[j])))) {
                            count++;
                        }
                        if (parseFloat(newTime1) === parseFloat(array1[j])) {
                            count--;

                        }

                    }
                }
                /*
                 * create array of date object for test on which date the  time interval work
                 */
                var count1 = 1;
           
                for (var k = 0; k < dtarray3.length; k++) {
                    var datetimeintervalobject = new Date(dtarray3[k]);

                    if (((parseFloat(time1) >= parseFloat(dtarray1[k])) || (parseFloat(newTime1) >= parseFloat(dtarray1[k]))) && (d2.getDate() === datetimeintervalobject.getDate())) {
                        if ((parseFloat(newTime1) <= parseFloat(dtarray2[k]))) {
                            count1++;

                        }
                        else if ((((parseFloat(time1) + timeinter) >= parseFloat(dtarray2[k])) && (parseFloat(time1) < parseFloat(dtarray2[k])))) {
                            count1++;
                        }
                        if (parseFloat(newTime1) === parseFloat(dtarray1[k])) {
                            count1--;

                        }


                    }

                }

                if ((count > 1) || (count1 > 1)) {
                    var displaysetting = 'display:none;';
                } else {
                    var displaysetting = 'display:block;';
                }
                /* here is setting for AM and PM list 
                 * 
                 */
                time1 = parseFloat(time1);
                time1 = time1.toFixed(2);

                newTime1 = parseFloat(newTime1);
                newTime1 = newTime1.toFixed(2);

                if (parseInt($displayformat) == 1) {
                    if (parseFloat(time1) < 12) {
                        var timeampm = time1 + 'AM';
                    }
                    else {
                        if (parseFloat(time1) >= 13) {
                            time1 = time1 - 12;
                            time1 = time1.toFixed(2);
                            var timeampm = time1 + 'PM';
                        } else {
                            var timeampm = time1 + 'PM';
                        }

                    }
                    if (parseInt(newTime) < 12) {
                        var newTimeampm = newTime1 + 'AM';
                    } else {
                        if (parseFloat(newTime) >= 13) {
                            newTime1 = newTime1 - 12;
                            newTime1 = newTime1.toFixed(2);
                            var newTimeampm = newTime1 + 'PM';
                        }
                        else {
                            var newTimeampm = newTime1 + 'PM';
                        }
                    }
                } else {
                    var timeampm = time1;
                    var newTimeampm = newTime1;
                }
                jQuery('.timeinterval').append("<option style=" + displaysetting + " value=" + time + "-" + newTime + ">" + timeampm + "-" + newTimeampm + "</option>");
                time = newTime;
            }

        }

    });

    jQuery(document).on('click', '.editdeliveryitem', function(event) {
        event.preventDefault();
        jQuery('#orderedit').toggle();
        jQuery('#editdeliveryform').toggle();
        if (jQuery('.editdeliveryitem').text() == 'Edit') {
            jQuery('.editdeliveryitem').text('Cancel');
        } else {
            jQuery('.editdeliveryitem').text('Edit');
        }

    });

    jQuery(window).load(function() {
        // Run code
        var timeobject1 = new Date();
        timeobject1.setHours(00, 00);
        var time = timeobject1.getHours() + ':' + timeobject1.getMinutes();
        var day = parseInt(timeobject1.getDate());
        var timeinterval = $timeIntervalAdmin;
        for (var i = 0; i < 1440; i += parseInt(timeinterval)) {
            timeobject1 = new Date(timeobject1.getTime() + timeinterval * 60000);

            /*
             * add timeinterval(mins) to timeobject1(dateobject)
             */
            var newTime = timeobject1.getHours() + ':' + timeobject1.getMinutes();
            if (parseInt(timeobject1.getDate()) > day)
            {
                newTime = '24:00';
            }

            /* here is setting for AM and PM list 
             * 
             */
            var timeinter = parseFloat(timeinterval / 60);

            var time1 = time.replace(":", ".");

            var newTime1 = newTime.replace(":", ".");
            time1 = parseFloat(time1);
            time1 = time1.toFixed(2);

            newTime1 = parseFloat(newTime1);
            newTime1 = newTime1.toFixed(2);

            if (parseInt($displayformat) == 1) {
                if (parseFloat(time1) < 12) {
                    var timeampm = time1 + 'AM';
                }
                else {
                    if (parseFloat(time1) >= 13) {
                        time1 = time1 - 12;
                        time1 = time1.toFixed(2);
                        var timeampm = time1 + 'PM';
                    } else {
                        var timeampm = time1 + 'PM';
                    }

                }
                if (parseInt(newTime) < 12) {
                    var newTimeampm = newTime1 + 'AM';
                } else {
                    if (parseFloat(newTime) >= 13) {
                        newTime1 = newTime1 - 12;
                        newTime1 = newTime1.toFixed(2);
                        var newTimeampm = newTime1 + 'PM';
                    }
                    else {
                        var newTimeampm = newTime1 + 'PM';
                    }
                }
            } else {
                var timeampm = time1;
                var newTimeampm = newTime1;
            }

            jQuery('#delicerytimeedit').append("<option  value=" + time1 + "-" + newTime1 + ">" + timeampm + "-" + newTimeampm + "</option>");
            time = newTime;
        }
    });


    jQuery("#contact_submit button").click(function(event){
        var time=jQuery('#delicerytimeedit').val();
        if(time==''){
         event.preventDefault();  
         alert('Time cannot be left empty');
        }
        
    });

});


