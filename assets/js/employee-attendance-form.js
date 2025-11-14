jQuery(document).ready(function($) {
    var disabledDays = [0];
    var weekday = new Array(7);
    weekday[0] = "Sunday";
    weekday[1] = "Monday";
    weekday[2] = "Tuesday";
    weekday[3] = "Wednesday";
    weekday[4] = "Thursday";
    weekday[5] = "Friday";
    weekday[6] = "Saturday";
    if ($('.datepicker-here').is('#datepicker')) {

        $('#datepicker').datepicker({
            dateFormat: 'dd MM yyyy',
            language: 'en',
            onRenderCell: function(date, cellType) {
                if (cellType == 'day') {
                    var day = date.getDay(),
                        isDisabled = disabledDays.indexOf(day) != -1;
                    return {
                        disabled: isDisabled
                    }
                }
            },
            onSelect: function onSelect(fd, date) {
                var dayOfWeek = weekday[date.getUTCDay() + 1];
                $("#weekday").text(dayOfWeek);
                var $dd = date.getDate() - 1;
                var $dd1 = date.getDate() + 1;
                var $mm = date.getMonth() + 1;

                var $yyyy = date.getFullYear();
                if ($dd < 10) { $dd = '0' + $dd }
                if ($mm < 10) { $mm = '0' + $mm }
                date1 = $yyyy + '-' + $mm + '-' + $dd;
                if ($dd1 < 10) { $dd1 = '0' + $dd1 }
                if ($mm < 10) { $mm = '0' + $mm }
                date2 = $yyyy + '-' + $mm + '-' + $dd1;
                $('.prev-day').attr('href', (date1));
                $('.next-day').attr('href', (date2));
                date_change('Y');
                $(".page-title.text-center").text('Add Attendance ( ' + $('#datepicker').val() + ' )');
            }
        });
    }
    // $('#datepicker').datepicker();
    var base_url = $("#js_data").data('base-url');
    // date_change('X');
    function remove_c() {
        $("#employee_in").removeClass('error');
        $("#employee_in1").removeClass('error');
        $("#employee_out").removeClass('error');
        $("#employee_out1").removeClass('error');
    }
    $('#employee-form-admin').submit(function(e) {
        var employee_in = $("#employee_in").val();
        var employee_out = $("#employee_out").val();
        var employee_in1 = $("#employee_in1").val();
        var employee_out1 = $("#employee_out1").val();
        var attendance_type = $("#attendance_type").val();
        if (!employee_in && !employee_out && !employee_in1 && !employee_out1 && !attendance_type) {
            var in_time = $("#in_time").val();
            var out_time = $("#out_time").val();
            var in_time1 = $("#in_time1").val();
            var out_time1 = $("#out_time1").val();
            var in_out_time = $("#in_out_time").val();
            $("#attendance_type").removeClass('error');
            remove_c();
            submit_ajax_form(attendance_type, in_time, out_time, in_time1, out_time1, employee_in, employee_out, employee_in1, employee_out1, in_out_time);
            // return true;
            return false;
        } else {
            if (!employee_in || !attendance_type) {
                e.preventDefault();
                if (!employee_in) {
                    $("#employee_in").addClass('error');
                } else {
                    $("#employee_in").removeClass('error');
                }
                if (!attendance_type) {
                    $("#attendance_type").addClass('error');
                } else {
                    $("#attendance_type").removeClass('error');
                }

                return false;
            } else {

                var in_time = $("#in_time").val();
                var out_time = $("#out_time").val();
                var in_time1 = $("#in_time1").val();
                var out_time1 = $("#out_time1").val();
                var in_out_time = $("#in_out_time").val();
                if (out_time != "") {
                    //1,2
                    if (in_time != "" && out_time != "") {
                        console.log("if1");
                        var t = in_out_time + " " + in_time;
                        var t1 = in_out_time + " " + out_time;
                        //console.log(t1+""+t);
                        var dtStart = new Date(t);
                        var dtEnd = new Date(t1);
                        var difference_in_milliseconds = dtEnd - dtStart;
                        if (difference_in_milliseconds < 0) {
                            $('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>OUT time must be greater than IN time</p></div></div></div>');
                            $('.msg-container .msg-box').attr('style', 'display:block');
                            setTimeout(function() {
                                $('.msg-container .msg-box').attr('style', 'display:none');
                            }, 6000);
                            // $(".from_message").html('');
                            $("#employee_in").addClass('error');
                            return false;
                        } else {
                            $('.time_msg').text("");
                            $("#employee_in").removeClass('error');
                            if (in_time1 != "") {
                                //2,3
                                if (in_time != "" && out_time != "" && in_time1 != "") {
                                    console.log("if2");
                                    var t2 = in_out_time + " " + out_time;
                                    var t3 = in_out_time + " " + in_time1;
                                    //console.log(t1+""+t);
                                    var dtStart1 = new Date(t2);
                                    var dtEnd1 = new Date(t3);
                                    var difference_in_milliseconds1 = dtEnd1 - dtStart1;
                                    if (difference_in_milliseconds1 < 0) {
                                        $("#employee_in1").addClass('error');
                                        $('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>IN time must be greater than OUT time</p></div></div></div>');
                                        $('.msg-container .msg-box').attr('style', 'display:block');
                                        setTimeout(function() {
                                            $('.msg-container .msg-box').attr('style', 'display:none');
                                        }, 6000);
                                        // $(".from_message").html('');
                                        return false;
                                    } else {
                                        $('.time_msg').text("");
                                        $("#employee_in1").removeClass('error');

                                        //3,4

                                        if (out_time1 != "") {
                                            if (in_time != "" && out_time != "" && in_time1 != "" && out_time1 != "") {
                                                console.log("if3");
                                                var t4 = in_out_time + " " + in_time1;
                                                var t5 = in_out_time + " " + out_time1;
                                                //console.log(t4+""+t5);
                                                var dtStart2 = new Date(t4);
                                                var dtEnd2 = new Date(t5);
                                                var difference_in_milliseconds2 = dtEnd2 - dtStart2;
                                                if (difference_in_milliseconds2 < 0) {
                                                    $("#employee_out1").addClass('error');
                                                    $('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>IN time must be greater than OUT time</p></div></div></div>');
                                                    $('.msg-container .msg-box').attr('style', 'display:block');
                                                    setTimeout(function() {
                                                        $('.msg-container .msg-box').attr('style', 'display:none');
                                                    }, 6000);
                                                    // $(".from_message").html('');
                                                    return false;
                                                } else {
                                                    $("#employee_out1").removeClass('error');
                                                    $('.time_msg').text("");
                                                    submit_ajax_form(attendance_type, in_time, out_time, in_time1, out_time1, employee_in, employee_out, employee_in1, employee_out1, in_out_time);
                                                    // return true;
                                                    return false;
                                                }
                                            } else {
                                                console.log("else3");
                                                if (!employee_in) {
                                                    $("#employee_in").addClass('error');
                                                } else {
                                                    $("#employee_in").removeClass('error');
                                                }
                                                if (!employee_out) {
                                                    $("#employee_out").addClass('error');
                                                } else {
                                                    $("#employee_out").removeClass('error');
                                                }
                                                if (!employee_in1) {
                                                    $("#employee_in1").addClass('error');
                                                } else {
                                                    $("#employee_in1").removeClass('error');
                                                }
                                                if (!employee_out1) {
                                                    $("#employee_out1").addClass('error');
                                                } else {
                                                    $("#employee_out1").removeClass('error');
                                                }
                                                $('.time_msg').text("");
                                                return false;
                                            }
                                        } else {
                                            remove_c();
                                            submit_ajax_form(attendance_type, in_time, out_time, in_time1, out_time1, employee_in, employee_out, employee_in1, employee_out1, in_out_time);
                                            // return true;
                                            return false;

                                        }




                                    }
                                } else {
                                    console.log("else2");
                                    if (!employee_in) {
                                        $("#employee_in").addClass('error');
                                    } else {
                                        $("#employee_in").removeClass('error');
                                    }
                                    if (!employee_out) {
                                        $("#employee_out").addClass('error');
                                    } else {
                                        $("#employee_out").removeClass('error');
                                    }
                                    if (!employee_in1) {
                                        $("#employee_in1").addClass('error');
                                    } else {
                                        $("#employee_in1").removeClass('error');
                                    }
                                    $('.time_msg').text("");
                                    return false;
                                }
                            } else {
                                console.log("if43");
                                if (in_time != "" && out_time != "" && out_time1 != "") {

                                    if (!employee_in1) {
                                        $("#employee_in1").addClass('error');
                                    } else {
                                        $("#employee_in1").removeClass('error');
                                    }

                                    return false;
                                } else {
                                    remove_c();
                                    submit_ajax_form(attendance_type, in_time, out_time, in_time1, out_time1, employee_in, employee_out, employee_in1, employee_out1, in_out_time);
                                    // return true;
                                    return false;
                                }

                            }
                        }

                    } else {
                        console.log("else");
                        if (!employee_in) {
                            $("#employee_in").addClass('error');
                        } else {
                            $("#employee_in").removeClass('error');
                        }
                        if (!employee_out) {
                            $("#employee_out").addClass('error');
                        } else {
                            $("#employee_out").removeClass('error');
                        }

                        return false;
                    }
                } else {
                    console.log("if4");
                    if (in_time1 != "" && out_time1 != "") {

                        if (!employee_out) {
                            $("#employee_out").addClass('error');
                        } else {
                            $("#employee_out").removeClass('error');
                        }

                        return false;
                    } else {
                        if (in_time != "" && out_time == "" && in_time1 == "" && out_time1 != "") {
                            $("#employee_out").addClass('error');
                            $("#employee_in1").addClass('error');
                            return false;
                        } else {
                            if (in_time != "" && out_time == "" && in_time1 != "" && out_time1 == "") {
                                $("#employee_out").addClass('error');
                                // $("#employee_in1").addClass('error');
                                return false;
                            } else {
                                remove_c();
                                console.log("if4");
                                submit_ajax_form(attendance_type, in_time, out_time, in_time1, out_time1, employee_in, employee_out, employee_in1, employee_out1, in_out_time);
                                // return true;
                                return false;
                            }
                        }
                    }

                    console.log("if4");
                    //  return true;
                }

                // return false;
                //end
            }

        }

    });

    /*ajax*/
    function submit_ajax_form(attendance_type, in_time, out_time, in_time1, out_time1, employee_in, employee_out, employee_in1, employee_out1, in_out_time) {
        // $(".from_message").html('');
        var url = base_url + "employee/insert_employee_attendance";
        var attendance_date = $('#datepicker').val();
        var emp_id = $('#emp_id').val();
        var id = $('#id').val();
        var other_date = $('#other_date').val();
        $.ajax({
            type: "post",
            url: url,
            data: { attendance_date, emp_id, id, other_date, attendance_type, in_time, out_time, in_time1, out_time1, employee_in, employee_out, employee_in1, employee_out1, in_out_time },
            success: function(data) {
                date_change('Y');
                $(".msg-container").html(data);
                $('.msg-container .msg-box').attr('style', 'display:block');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style', 'display:none');
                }, 6000);
            },
        });
    }
    $('#employee').change(function() {
        $('.report_preloader1').attr('style', 'display:block');
        var url = base_url + "employee/search_employee_attendance";
        var employee = $('#employee').val();
        $.ajax({
            type: "post",
            url: url,
            data: { employee },
            success: function(response) {
                var data = JSON.parse(response);
                var id = $('#id').val(data.id);
                $('.employee-name').text(' Name : ' + data.get_employee[0].fname + ' ' + data.get_employee[0].lname);
                date_change('Y');
                $('.time_msg').html('');
                $('.report_preloader1').attr('style', 'display:none');
                return false;
            },
        });
    });
    /*	var weekday=new Array(7);
        weekday[0]="Sunday";
        weekday[1]="Monday";
        weekday[2]="Tuesday";
        weekday[3]="Wednesday";
        weekday[4]="Thursday";
        weekday[5]="Friday";
        weekday[6]="Saturday";*/
    /* if($('#datepicker')){
	    // $('#datepicker').datepicker({
	    //     dateFormat: 'd MM yy',
	    //     beforeShowDay: noSunday,
	    //     maxDate: new Date(),
	    //     onSelect: function(dateText, inst) {
	    //       var date = $(this).datepicker('getDate');
	    //       var dayOfWeek = weekday[date.getUTCDay()+1];
	    //       $("#weekday").text(dayOfWeek);    
	    //       $(".page-title.text-center").text('Add Attendance ( '+$('#datepicker').val()+' )');    
	    //       date_change('Y');
	    //       // dayOfWeek is then a string containing the day of the week
	    //     }
	        
	    // });
    }*/
    date_change('Y');

    function noSunday(date) {
        var day = date.getDay();
        return [(day > 0), ''];
    }

    function date_change(n) {
        $.each($('#attendance_type option'), function() {
            if ($(this).val() == '') {
                $(this).prop('selected', true);
            }
        });
        var d = '';
        if (n == 'Y') {
            var date1 = $('#datepicker').val();
            d = new Date(date1);
        } else {
            d = new Date();
        }
        //  dd-MM-yy
        var id = $('#id').val();
        var data = {
            'id': id,
            'year': d.getFullYear(),
            'month': (d.getMonth() + 1),
            'day': d.getDate(),
        }
        $.ajax({
            url: base_url + "employee/employee_attendance1",
            type: "post",
            data: data,
            success: function(response) {
                remove_c();
                $('.time_msg').html('');
                // console.log(response);
                // alert(Array.isArray(response.employee_attendance[0]));
                // if(Array.isArray(response)){
                var data = JSON.parse(response);
                if (data.employee_attendance[0]) {
                    if (data.employee_attendance[0].attendance_type == 'full_day') {
                        $.each($('#attendance_type option'), function() {
                            if ($(this).val() == 'full_day') {
                                $(this).prop('selected', true);
                            }
                        });
                    } else if (data.employee_attendance[0].attendance_type == 'half_day') {
                        $.each($('#attendance_type option'), function() {
                            if ($(this).val() == 'half_day') {
                                $(this).prop('selected', true);
                            }
                        });
                    } else {
                        $.each($('#attendance_type option'), function() {
                            if ($(this).val() == '') {
                                $(this).prop('selected', true);
                            }
                        });
                    }
                }
                if (data.get_employee_attendance !== '') {
                    var attendance = [];
                    $.each(data.get_employee_attendance, function(k, v) {
                        attendance.push(v.id);
                    });
                }
                if (data.employee_in !== '') {
                    var btn = '<div class="col-md-5 text-left"><button class="btn btn-primary submit_form">Update</button></div><div class="col-md-5 text-right"><button onclick=$("#employee_in").val("");$("#employee_out").val("");$("#employee_in1").val("");$("#employee_out1").val(""); class="btn btn-danger reset_data" type="button">Reset</button>';
                    btn += '<button data-id="' + data.id + '" data-date="' + data.get_date + '" class="delete-employee-attendances btn btn-danger m-l-5">Delete</button></div>';
                    $('#emp_id').val(attendance.join(", "));
                    $('#other_date').val(data.get_date);
                    $('#all_btn').html(btn);
                } else {
                    var btn = '<div class="col-md-5 text-left"><button class="btn btn-primary submit_form">Add</button></div><div class="col-md-5 text-right"><button onclick=$("#employee_in").val("");$("#employee_out").val("");$("#employee_in1").val("");$("#employee_out1").val(""); class="btn btn-danger reset_data" type="button">Reset</button>';
                    $('#emp_id').val('');
                    $('#other_date').val('');
                    $('#all_btn').html(btn);
                }
                $('#employee_in').val(data.employee_in);
                $('#employee_out').val(data.employee_out);
                $('#employee_in1').val(data.employee_in1);
                $('#employee_out1').val(data.employee_out1);
                $('#in_time').val(data.employee_in_hidden);
                $('#out_time').val(data.employee_out_hidden);
                $('#in_time1').val(data.employee_in1_hidden);
                $('#out_time1').val(data.employee_out1_hidden);
                // }


                // window.location.replace(base_url+"/employee_attendance_list/"+id);
            },
        });
    }

    $(document).on('click', '.delete-employee-attendances', function() {

        if (confirm("Are you sure want to delete?")) {

            jQuery(".loader-text").html("Deleting Employee");

            jQuery(".loader-wrap").show();

            var id = $(this).attr("data-id");

            var date = $(this).attr("data-date");



            var data = {

                'id': id,

                'date': date,

            };

            $.ajax({

                url: base_url + "/employee/delete_employee_attendance",

                type: "post",

                data: data,

                success: function(response) {
                    // console.log(response);
                    date_change('Y');
                    // window.location.replace(base_url+"/employee_attendance_list/"+id);

                },



            });


        }

        return false;

    });
    $('#employee_in').on('change', function() {
        console.log("change employee_in");
        // alert("change event");
        var time = $(this).val();
        if ($(this).val() !== "") {
            var hours = time.split(":")[0];
            var minutes = time.split(":")[1];
            var suffix = hours >= 12 ? "PM" : "AM";
            hours = hours % 12 || 12;
            hours = hours < 10 ? "0" + hours : hours;

            var displayTime = hours + ":" + minutes + " " + suffix;
            //var momentObj = moment(displayTime, ["h:mm A"])
            //var last_time=momentObj.format("HH:mm");
            $("#in_time").val(displayTime);



            //document.getElementById("display_time").innerHTML = displayTime;
        } else {
            $("#in_time").val("");
            $("#employee_in").val("");
        }
    });
    $('#employee_out').on('change', function() {
        console.log("change employee_out");
        var time = $(this).val();
        if ($(this).val() !== "") {
            var hours = time.split(":")[0];
            var minutes = time.split(":")[1];
            var suffix = hours >= 12 ? "PM" : "AM";
            hours = hours % 12 || 12;
            hours = hours < 10 ? "0" + hours : hours;

            var displayTime = hours + ":" + minutes + " " + suffix;
            //var momentObj = moment(displayTime, ["h:mm A"])
            //var last_time=momentObj.format("HH:mm");
            $("#out_time").val(displayTime);



            //document.getElementById("display_time").innerHTML = displayTime;
        } else {
            $("#out_time").val("");
            $("#employee_out").val("");
        }
    });
    $('#employee_in1').on('change', function() {
        console.log("change employee_in1");
        var time = $(this).val();
        if ($(this).val() !== "") {
            var hours = time.split(":")[0];
            var minutes = time.split(":")[1];
            var suffix = hours >= 12 ? "PM" : "AM";
            hours = hours % 12 || 12;
            hours = hours < 10 ? "0" + hours : hours;

            var displayTime = hours + ":" + minutes + " " + suffix;
            //var momentObj = moment(displayTime, ["h:mm A"])
            //var last_time=momentObj.format("HH:mm");
            $("#in_time1").val(displayTime);



            //document.getElementById("display_time").innerHTML = displayTime;
        } else {
            $("#in_time1").val("");
            $("#employee_in1").val("");
        }
    });
    $('#employee_out1').on('change', function() {
        console.log("change employee_out1");
        var time = $(this).val();
        if ($(this).val() !== "") {
            var hours = time.split(":")[0];
            var minutes = time.split(":")[1];
            var suffix = hours >= 12 ? "PM" : "AM";
            hours = hours % 12 || 12;
            hours = hours < 10 ? "0" + hours : hours;

            var displayTime = hours + ":" + minutes + " " + suffix;
            //var momentObj = moment(displayTime, ["h:mm A"])
            //var last_time=momentObj.format("HH:mm");
            $("#out_time1").val(displayTime);



            //document.getElementById("display_time").innerHTML = displayTime;
        } else {
            $("#out_time1").val("");
            $("#employee_out1").val("");
        }
    });
    //console.log(in1_val_length);
    // $('#employee-form').submit(function(e) {
    // var in1_val_length= $(".in1_val").length;
    // if(in1_val_length == 4)
    // {
    // $("#in_out_time_count").val(in1_val_length);
    // var attendance_type=$("#attendance_type").val();
    // if(!attendance_type)
    // {
    // if(!attendance_type)
    // {
    // $("#attendance_type").addClass('error');
    // }
    // else
    // {
    // $("#attendance_type").removeClass('error');
    // }
    // return false;
    // }
    // else
    // {
    // $("#attendance_type").removeClass('error');
    // return true;
    // }

    // }

    // });
    $('#employee-form1111').submit(function(e) {
        var employee_in = $('#in_time').val();
        var employee_out = $('#out_time').val();
        var employee_in1 = $('#in_time1').val();
        var employee_out1 = $('#out_time1').val();
        var in_out_time = $("#in_out_time").data('current-date');
        var attendance_type = $("#attendance_type").val();
        if (!employee_in && !employee_out && !employee_in1 && !employee_out1 && !attendance_type) {
            var in_time = $("#in_time").val();
            var out_time = $("#out_time").val();
            var in_time1 = $("#in_time1").val();
            var out_time1 = $("#out_time1").val();
            var in_out_time = $("#in_out_time").data('current-date');
            $("#attendance_type").removeClass('error');
            remove_c();
            // alert('okkkns112-1');
            return true;
            // return false;
        } else {
            if (!employee_in || !attendance_type) {
                e.preventDefault();
                if (!employee_in) {
                    $("#employee_in").addClass('error');
                } else {
                    $("#employee_in").removeClass('error');
                }
                if (!attendance_type) {
                    $("#attendance_type").addClass('error');
                } else {
                    $("#attendance_type").removeClass('error');
                }
                return false;
            } else {

                var in_time = $("#in_time").val();
                var out_time = $("#out_time").val();
                var in_time1 = $("#in_time1").val();
                var out_time1 = $("#out_time1").val();
                var in_out_time = $("#in_out_time").data('current-date');
                if (out_time != undefined) {
                    //1,2
                    if (in_time != undefined && out_time != undefined) {
                        console.log("if1");
                        var t = in_out_time + " " + in_time;
                        var t1 = in_out_time + " " + out_time;
                        //console.log(t1+""+t);
                        var dtStart = new Date(t);
                        var dtEnd = new Date(t1);
                        var difference_in_milliseconds = ((dtEnd.getTime() / 1000) - (dtStart.getTime() / 1000));
                        if (difference_in_milliseconds < 0) {
                            $('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>OUT time must be greater than IN time</p></div></div></div>');
                            $('.msg-container .msg-box').attr('style', 'display:block');
                            setTimeout(function() {
                                $('.msg-container .msg-box').attr('style', 'display:none');
                            }, 6000);
                            // $(".from_message").html('');
                            $("#employee_in").addClass('error');
                            return false;
                        } else {
                            $('.time_msg').text("");
                            $("#employee_in").removeClass('error');
                            if (in_time1 != undefined) {
                                //2,3
                                if (in_time != undefined && out_time != undefined && in_time1 != undefined) {
                                    console.log("if2");
                                    var t2 = in_out_time + " " + out_time;
                                    var t3 = in_out_time + " " + in_time1;
                                    //console.log(t1+""+t);
                                    var dtStart1 = new Date(t2);
                                    var dtEnd1 = new Date(t3);
                                    var difference_in_milliseconds1 = ((dtEnd1.getTime() / 1000) - (dtStart1.getTime() / 1000));
                                    if (difference_in_milliseconds1 < 0) {
                                        $("#employee_in1").addClass('error');
                                        $('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>IN time must be greater than OUT time</p></div></div></div>');
                                        $('.msg-container .msg-box').attr('style', 'display:block');
                                        setTimeout(function() {
                                            $('.msg-container .msg-box').attr('style', 'display:none');
                                        }, 6000);
                                        // $(".from_message").html('');
                                        return false;
                                    } else {
                                        $('.time_msg').text("");
                                        $("#employee_in1").removeClass('error');

                                        //3,4

                                        if (out_time1 != undefined) {
                                            if (in_time != undefined && out_time != undefined && in_time1 != undefined && out_time1 != undefined) {
                                                console.log("if3");
                                                var t4 = in_out_time + " " + in_time1;
                                                var t5 = in_out_time + " " + out_time1;
                                                //console.log(t4+""+t5);
                                                var dtStart2 = new Date(t4);
                                                var dtEnd2 = new Date(t5);
                                                var difference_in_milliseconds2 = ((dtEnd2.getTime() / 1000) - (dtStart2.getTime() / 1000));
                                                if (difference_in_milliseconds2 < 0) {
                                                    $("#employee_out1").addClass('error');
                                                    $('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>IN time must be greater than OUT time</p></div></div></div>');
                                                    $('.msg-container .msg-box').attr('style', 'display:block');
                                                    setTimeout(function() {
                                                        $('.msg-container .msg-box').attr('style', 'display:none');
                                                    }, 6000);
                                                    // $(".from_message").html('');
                                                    return false;
                                                } else {
                                                    $("#employee_out1").removeClass('error');
                                                    $('.time_msg').text("");
                                                    // alert('okkkns112-2');
                                                    return true;
                                                    // return false;
                                                }
                                            } else {
                                                console.log("else3");
                                                if (!employee_in) {
                                                    $("#employee_in").addClass('error');
                                                } else {
                                                    $("#employee_in").removeClass('error');
                                                }
                                                if (!employee_out) {
                                                    $("#employee_out").addClass('error');
                                                } else {
                                                    $("#employee_out").removeClass('error');
                                                }
                                                if (!employee_in1) {
                                                    $("#employee_in1").addClass('error');
                                                } else {
                                                    $("#employee_in1").removeClass('error');
                                                }
                                                if (!employee_out1) {
                                                    $("#employee_out1").addClass('error');
                                                } else {
                                                    $("#employee_out1").removeClass('error');
                                                }
                                                $('.time_msg').text("");
                                                return false;
                                            }
                                        } else {
                                            remove_c();
                                            // alert('okkkns112-3');
                                            return true;
                                            // return false;

                                        }
                                    }
                                } else {
                                    console.log("else2");
                                    if (!employee_in) {
                                        $("#employee_in").addClass('error');
                                    } else {
                                        $("#employee_in").removeClass('error');
                                    }
                                    if (!employee_out) {
                                        $("#employee_out").addClass('error');
                                    } else {
                                        $("#employee_out").removeClass('error');
                                    }
                                    if (!employee_in1) {
                                        $("#employee_in1").addClass('error');
                                    } else {
                                        $("#employee_in1").removeClass('error');
                                    }
                                    $('.time_msg').text("");
                                    return false;
                                }
                            } else {
                                console.log("if43");
                                if (in_time != undefined && out_time != undefined && out_time1 != undefined) {

                                    if (!employee_in1) {
                                        $("#employee_in1").addClass('error');
                                    } else {
                                        $("#employee_in1").removeClass('error');
                                    }

                                    return false;
                                } else {
                                    remove_c();
                                    // alert('okkkns112-4');
                                    return true;
                                    // return false;
                                }

                            }
                        }

                    } else {
                        console.log("else");
                        if (!employee_in) {
                            $("#employee_in").addClass('error');
                        } else {
                            $("#employee_in").removeClass('error');
                        }
                        if (!employee_out) {
                            $("#employee_out").addClass('error');
                        } else {
                            $("#employee_out").removeClass('error');
                        }

                        return false;
                    }
                } else {
                    console.log("if4");
                    if (in_time1 != undefined && out_time1 != undefined) {

                        if (!employee_out) {
                            $("#employee_out").addClass('error');
                        } else {
                            $("#employee_out").removeClass('error');
                        }

                        return false;
                    } else {
                        if (in_time != undefined && out_time == undefined && in_time1 == undefined && out_time1 != undefined) {
                            $("#employee_out").addClass('error');
                            $("#employee_in1").addClass('error');
                            return false;
                        } else {
                            if (in_time != undefined && out_time == undefined && in_time1 != undefined && out_time1 == undefined) {
                                $("#employee_out").addClass('error');
                                // $("#employee_in1").addClass('error');
                                return false;
                            } else {
                                remove_c();
                                console.log("if4");
                                // alert('okkkns112-5');
                                return true;
                                // return false;
                            }
                        }
                    }

                    console.log("if4");
                    //  return true;
                }
            }

        }

    });
    return false;

});
$(".reset_data").click(function() {
    $("#employee_in").val('');
    $("#employee_out").val('');
    $("#employee_in1").val('');
    $("#employee_out1").val('');
    $("#attendance_type").val('');
});

$('#attendance_type').on('change', function() {
    var attendance_type = $(this).val();
    if (attendance_type == "full_day") {
        if ($("#employee_in").val() == "") {
            $("#employee_in").val("09:30");
        }
        if ($("#employee_out").val() == "") {
            $("#employee_out").val("14:00");
        }
        if ($("#employee_in1").val() == "") {
            $("#employee_in1").val("15:00");
        }
        if ($("#employee_out1").val() == "") {
            $("#employee_out1").val("18:30");
        }
    }
    if (attendance_type == "half_day") {
        if ($("#employee_in").val() == "") {
            $("#employee_in").val("09:30");
        }
        if ($("#employee_out").val() == "") {
            $("#employee_out").val("14:00");
        }
        $("#employee_out1").val("");
        $("#employee_in1").val("");
    }
});

function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    hours = hours < 10 ? '0' + hours : hours;

    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}

$(document).ready(function($) {

    $(document).on('click', '.submit_form', function() {
        $(this).attr('disabled', 'disabled');
        $('.preloader.preloader-2').attr('style', 'display: block !important;');
        console.log(formatAMPM(new Date));
        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var output = d.getFullYear() + '/' +
            (month < 10 ? '0' : '') + month + '/' +
            (day < 10 ? '0' : '') + day;

        //$(".submit_form").click(function(){
        var attendance_type = $("#attendance_type").val();
        var select_error = true;
        if (attendance_type == "--Select Day--") {
            $("#attendance_type").addClass('error');
            select_error = true;
        } else {
            $("#attendance_type").removeClass('error');
            select_error = false;


        }
        if (select_error == false) {
            var attendance = $(this).data('attendance');
            console.log(attendance);
            var current_time = "";
            var html = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Attendance inserted successfully.</p></div></div></div>';
            var html1 = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Attendance inserted failed.</p></div></div></div>';
            if ($(this).data('attendance') == 1) {

                var out_box2 = '<div class="form-group _form out_box2"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 col-md-4"> <label>Out *</label></div><div class="col-8 col-sm-5 col-md-4"><div class="in1_val"><div class="form-group out_section"> <span class="time_in2">' + formatAMPM(new Date) + '</span> <button type="button" class="btn btn-primary submit_form pull-right" data-attendance="2">ADD</button> <input type="hidden" value="2" name="employee_in" id="employee_in" /> <input type="hidden" id="out_time" value="' + formatAMPM(new Date) + '" name=""></div></div></div></div></div>';

                $('.submit_form').attr('disabled', true);
                current_time = formatAMPM(new Date);
                var base_url = $("#js_data").data('base-url');
                $.ajax({
                    type: "post",
                    url: base_url + 'profile/insert_employee_attendance_new',
                    data: { in_time: current_time, attendance_type: attendance_type, employee_in: attendance, in_out_time: "0", datepicker: output, in_out_time_count: "0" },
                    success: function(data) {
                        $('.out_box1').after(out_box2);
                        $('.out_box1').html('<div class="form-group _form"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 col-md-4"> <label>In *</label></div><div class="col-8 col-sm-5 col-md-4"><div class="in1_val" data-name="In">' + formatAMPM(new Date) + '<input type="hidden" id="in_time" name="in_time" value="' + formatAMPM(new Date) + '" name=""></div></div></div></div>');
                        $('.submit_form').attr('disabled', false);
                        $('.preloader.preloader-2').attr('style', 'display: none !important;');
                        $('.msg-container').html(html);
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $('.submit_form').attr('disabled', false);
                        $('.preloader.preloader-2').attr('style', 'display: none !important;');
                        $('.msg-container').html(html1);
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                    }
                });
            }
            if ($(this).data('attendance') == 2) {

                out_box3 = '<div class="form-group _form hide_in_out form-add-field out_box3" ><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 col-md-4"> <label>IN *</label></div><div class="col-8 col-sm-5 col-md-4"><div class="in1_val"><div class="form-group out_section"> <span class="time_in3">' + formatAMPM(new Date) + '</span> <button type="button" class="btn btn-primary submit_form pull-right" data-attendance="3">ADD</button> <input type="hidden" value="3" name="employee_in" id="employee_in" /> <input type="hidden" id="in_time1" value="' + formatAMPM(new Date) + '" name="in_time1"></div></div></div></div></div>';

                $('.submit_form').attr('disabled', true);
                current_time = formatAMPM(new Date);
                var base_url = $("#js_data").data('base-url');
                $.ajax({
                    type: "post",
                    url: base_url + 'profile/insert_employee_attendance_new',
                    data: { out_time: current_time, attendance_type: attendance_type, employee_in: attendance, in_out_time: "0", datepicker: output, in_out_time_count: "0" },
                    success: function(data) {
                        $('.submit_form').attr('disabled', false);
                        $('.out_box2').after(out_box3);
                        $('.out_box2').html('<div class="form-group _form"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 col-md-4"> <label>Out *</label></div><div class="col-8 col-sm-5 col-md-4"><div class="in1_val" data-name="In"> ' + formatAMPM(new Date) + ' <input type="hidden" id="out_time" value="' + formatAMPM(new Date) + '" name="out_time"></div></div></div></div>');
                        $('.preloader.preloader-2').attr('style', 'display: none !important;');
                        $('.msg-container').html(html);
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $('.submit_form').attr('disabled', false);
                        $('.preloader.preloader-2').attr('style', 'display: none !important;');
                        $('.msg-container').html(html1);
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                    }
                });
            }
            if ($(this).data('attendance') == 3) {

                out_box4 = '<div class="form-group _form out_box4"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 col-md-4"> <label>Out *</label></div><div class="col-8 col-sm-5 col-md-4"><div class="in1_val"><div class="form-group out_section"> <span class="time_in4">' + formatAMPM(new Date) + '</span> <button type="button" class="btn btn-primary submit_form pull-right" data-attendance="4">ADD</button> <input type="hidden" value="4" name="employee_in" id="employee_in" /> <input type="hidden" id="out_time1" value="' + formatAMPM(new Date) + '" name="out_time1"></div></div></div></div></div>';

                $('.submit_form').attr('disabled', true);
                current_time = formatAMPM(new Date);
                var base_url = $("#js_data").data('base-url');
                $.ajax({
                    type: "post",
                    url: base_url + 'profile/insert_employee_attendance_new',
                    data: { in_time1: current_time, attendance_type: attendance_type, employee_in: attendance, in_out_time: "0", datepicker: output, in_out_time_count: "0" },
                    success: function(data) {
                        $('.out_box3').after(out_box4);
                        $('.out_box3').html('<div class="form-group _form"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 col-md-4"> <label>IN *</label></div><div class="col-8 col-sm-5 col-md-4"><div class="in1_val" data-name="In"> ' + formatAMPM(new Date) + ' <input type="hidden" id="in_time1" value="' + formatAMPM(new Date) + '" name="in_time1"></div></div></div></div>');
                        $('.submit_form').attr('disabled', false);
                        $('.preloader.preloader-2').attr('style', 'display: none !important;');
                        $('.msg-container').html(html);
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $('.submit_form').attr('disabled', false);
                        $('.preloader.preloader-2').attr('style', 'display: none !important;');
                        $('.msg-container').html(html1);
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                    }
                });
            }
            if ($(this).data('attendance') == 4) {
                /* out_box4 */
                $('.out_box4').html('<div class="form-group _form"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 col-md-4"> <label>Out *</label></div><div class="col-8 col-sm-5 col-md-4"><div class="in1_val" data-name="In"> ' + formatAMPM(new Date) + ' <input type="hidden" id="out_time1" value="' + formatAMPM(new Date) + '" name="out_time1"></div></div></div></div>');
                current_time = formatAMPM(new Date);
                var base_url = $("#js_data").data('base-url');
                $.ajax({
                    type: "post",
                    url: base_url + 'profile/insert_employee_attendance_new',
                    data: { out_time1: current_time, attendance_type: attendance_type, employee_in: attendance, in_out_time: "0", datepicker: output, in_out_time_count: "0" },
                    success: function(data) {
                        $('.submit_form').attr('disabled', false);
                        //console.log(data);
                        $('.preloader.preloader-2').attr('style', 'display: none !important;');
                        $('.msg-container').html(html);
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);

                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $('.submit_form').attr('disabled', false);
                        $('.preloader.preloader-2').attr('style', 'display: none !important;');
                        $('.msg-container').html(html1);
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                    }
                });
            }


            //$("#employee-form").submit();
        } else {
            $('.submit_form').attr('disabled', false);
            $('.preloader.preloader-2').attr('style', 'display: none !important;');
            var html = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Select day type</p></div></div></div>';
            $('.msg-container').html(html);
            $('.msg-container .msg-box').attr('style', 'display:block');
            setTimeout(function() {
                $('.msg-container .msg-box').attr('style', 'display:none');
            }, 6000);
        }

    });
});