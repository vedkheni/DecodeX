var $leaveType = ['Sick', 'Festival', 'Engagement', 'Marriage',  'Maternity', 'Family Events', 'Bereavement', 'General'];
function format(row_data, id, date) {
    var row = id;
    var base_url = $("#js_data").data('base-url');
    var role = $("#js_data").data('role');
    var btn = '';
    if (role == 'admin') {
        var url = base_url + 'employee/employee_attendance/' + id + '/' + date;
        alert(url);
        btn = '<div> <a data-id="' + date + '" data-date="' + date + '"  class="edit-employee-attendances btn btn-danger waves-effect waves-light" href="' + url + '">Edit</a> <a data-id="' + id + '" data-date="' + date + '"  class="delete-employee-attendances btn btn-danger waves-effect waves-light">Delete</a></div>';
    }
    return '<div><p><strong>Date :</strong>' + row_data[1] + ' </p><p><strong>Attendance :</strong>' + row_data[2] + ' </p><p><strong>In :</strong>' + row_data[3] + ' </p><p><strong>Out :</strong>' + row_data[4] + ' </p><p><strong>In :</strong> ' + row_data[5] + '</p><p><strong>Out :</strong>' + row_data[6] + ' </p><p><strong>Total :</strong> ' + row_data[7] + '</p></div>' + btn;
}

jQuery(document).ready(function () {
    fillModel();
    var id = $("#employee").val();
    var month = $("#month").val();
    var year = $("#year").val();
    var data = { 'id': id, 'month': month, 'year': year };
    var base_url = $("#js_data").data('base-url');
    if ($('#title').text() == "List Employees Attendance") {
        $('.preloader-2').attr('style', 'display:block !important;');
        var table = $('#example').DataTable({
            "oLanguage": {
                "sLengthMenu": "Show _MENU_ Entries",
                },
            "lengthMenu": [[5, 10, 15, 20, 25, 31], [5, 10, 15, 20, 25, 31]],
            "pageLength": 31,
            "ajax": {
                "url": base_url + "employee/",
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    d.id = $('#employee').val();
                    d.user = 'admin';
                    d.month = $('#month').val();
                    d.year = $('#year').val();
                },
            },
            "responsive": true,
            "columns": [
                { "data": "id" },
                { "data": "date" },
                { "data": "attendance" },
                { "data": "in" },
                { "data": "out" },
                { "data": "in1" },
                { "data": "out1" },
                { "data": "total" },
                { "data": "time" },
                { "data": "action" },
                
            ],
            "fixedHeader": true,
        });
    } else if ($('#title').text() == "List Attendance") {
        $('.preloader-2').attr('style', 'display:block !important;');
        var table = $('#example').DataTable({
            "oLanguage": {
                "sLengthMenu": "Show _MENU_ Entries",
                },
            "lengthMenu": [[5, 10, 15, 20, 25, 31], [5, 10, 15, 20, 25, 31]],
            "pageLength": 31,
            "ajax": {
                "url": base_url + "employee/employee_data_new",
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    d.id = $('#employee').val();
                    d.user = 'user';
                    d.csrf_test_name = $("input[name=csrf_test_name]").val();
                    d.month = $('#month').val();
                    d.year = $('#year').val();
                },
                dataSrc: function (json) {
                    if (json.csrf_token !== undefined) $('input[name=csrf_test_name]').val(json.csrf_token);
                    return json.data;
                },
            },
            "responsive": true,
            "columns": [
                { "data": "id" },
                { "data": "date" },
                { "data": "attendance" },
                { "data": "in" },
                { "data": "out" },
                { "data": "in1" },
                { "data": "out1" },
                { "data": "total" },
                { "data": "time" },
                { "data": "action" },
                
            ],
            "fixedHeader": true,
        });
    }
    attendance_search();
    $('#example').on('draw.dt', function () {
        $.each($('#example tr'), function () {
            /* if ($(this).find('td:eq( 2 )').text() == "Holiday") {
                $(this).closest('tr').addClass('official-leave-color');
            } */
            if ($(this).find('td:eq( 2 ) strong').hasClass('holiday')) {
                $(this).closest('tr').addClass('official-leave-color');
                $(this).find('td:eq( 2 )').attr('colspan','7');
                $(this).find('td .view-work-updates').attr('disabled','disabled').removeClass('view-work-updates');
                $(this).find('td:eq(3),td:eq(4),td:eq(5),td:eq(6),td:eq(7),td:eq(8)').remove();
            }
            if ($(this).find('td:eq( 2 )').text() == "Sunday" || $(this).find('td:eq( 2 )').text() == "Saturday") {
                $(this).find('td .view-work-updates').attr('disabled','disabled').removeClass('view-work-updates');;
                $(this).closest('tr').addClass('sunday-leave-color');
            }
            if ($(this).find('td:eq( 2 )').text() == "Absent Leave") {
                $(this).closest('tr').addClass('absent-leave-color');
                $(this).find('td .view-work-updates').attr('disabled','disabled').removeClass('view-work-updates');;
            }
            if ($(this).find('td:eq( 2 )').text() == "Half Day") {
                $(this).closest('tr').addClass('halfday-leave-color');
            }
            if ($(this).find('td:eq( 2 )').text() == "Unapprove Leave") {
                $(this).closest('tr').addClass('unapprove-leave-color');
            }
            if ($(this).find('td:eq( 2 )').text() == "Sick Leave") {
                $(this).closest('tr').addClass('sick-leave-color');
                $(this).find('td .view-work-updates').attr('disabled','disabled').removeClass('view-work-updates');;
            }

            // var $className = ($(this).find('td:eq( 2 )').text() == "Marriage Leave")? 'marriage-leave-color' : '';
            // var $className = ($(this).find('td:eq( 2 )').text() == "Festival Leave")? 'festival-leave-color' : '';
            // var $className = ($(this).find('td:eq( 2 )').text() == "Engagement Leave")? 'engagement-leave-color' : '';
            // var $className = ($(this).find('td:eq( 2 )').text() == "Maternity Leave")? 'maternity-leave-color' : '';
            // var $className = ($(this).find('td:eq( 2 )').text() == "Family Events Leave")? 'familyevents-leave-color' : '';
            // var $className = ($(this).find('td:eq( 2 )').text() == "Bereavement Leave")? 'bereavement-leave-color' : '';
            // var $className = ($(this).find('td:eq( 2 )').text() == "General Leave")? 'general-leave-color' : '';
            // $(this).closest('tr').addClass($className);

            if($leaveType.includes(($(this).find('td:eq( 2 )').text()).replace(' Leave',''))){
                $(this).closest('tr').addClass('absent-leave-color');
                $(this).find('td .view-work-updates').attr('disabled','disabled').removeClass('view-work-updates');;
            } 

            if ($(this).find('td:eq( 2 )').text() == "Paid Leave") {
                $(this).closest('tr').addClass('paid-leave-color');
                $(this).find('td .view-work-updates').attr('disabled','disabled').removeClass('view-work-updates');
            }
            if ($(this).find('td:eq( 2 )').text() == "Kindly contact Hr, Otherwise, 1.5 Days of leave will be deducted.") {
                $(this).find('td:eq( 2 )').attr('colspan', "7");
                $.each($(this).find('td'), function () {
                    if ($(this).text() == '') {
                        $(this).remove();
                    }
                });
                $(this).closest('tr').addClass('absent-leave-color');
            }
        });
        $('.preloader-2').attr('style', 'display:none !important;');
    });
    $(document).on('change', '#year', function () {
        attendance_search();
        return false;
    });
    $(document).on('change', '#month', function () {
        attendance_search();
        return false;
    });
    $(document).on('click', '.emp_reset', function () {
        $('.emp_reset1').click();
        attendance_search();
        return false;
    });
    $(document).on('click', '.view-work-updates', function () {
        viewWorkUpdates($(this));
        return false;
    });
    function viewWorkUpdates($this) {
        $('.preloader-2').attr('style', 'display:block !important;');
        var base_url = $("#js_data").data('base-url');
        var data = { 'id': $this.data('id'), 'date': $this.data('date'), csrf_test_name: $("input[name=csrf_test_name]").val() };
        $.ajax({
            url: base_url + "employee/getWork_Updates",
            type: "post",
            data: data,
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.daily_work_list != '') {
                    $('#work_updateDate').text(obj.daily_work_list[0].date);
                    $('#view_daily_work').text(obj.daily_work_list[0].daily_work);
                } else {
                    $('#work_updateDate').text($this.data('date'));
                    $('#view_daily_work').html('<p class="no-data">Data not available!</p>');
                }
                $('#view_work_updates').modal('show');
                $('.preloader-2').attr('style', 'display:none !important;');
            },
        });
    }

    function attendance_search() {
        $('.preloader-2').attr('style', 'display:block !important;');
        var base_url = $("#js_data").data('base-url');
        var data = { 'id': $("#employee").val(), 'month': $("#month").val(), 'year': $("#year").val(), 'csrf_test_name': $("input[name=csrf_test_name]").val() };
        $.ajax({
            url: base_url + "employee/total_employee_attendance",
            type: "post",
            data: data,
            success: function (response) {
                var obj = JSON.parse(response);
                $("input[name=csrf_test_name]").val();
                table.clear();
                table.ajax.reload();
                var html = '';
                // html += '<div class="col-lg-4 col-12"><div class="analytics-info"><h3 class="title">Plus Time</h3><h3><span class="plus_time plus-time-count plus-time-count1">'+obj.total_time.plus_time+'</span></h3></div></div>'
                // html += '<div class="col-lg-4 col-12"><div class="analytics-info"><h3 class="title">Minus Time:</h3><h3><span class="minus_time minus-time-count minus-time-count1">'+obj.total_time.minus_time+'</span></h3></div></div>'
                if (obj.total_time.time_status == 'plus') {
                    // html += '<div class="col-lg-4 col-12"><div class="analytics-info"><h3 class="title">Total Time:</h3><h3 class="total_time1"><span class="plus_time plus-time-count plus-time-count1">'+obj.total_time.total_time+'</span></h3></div></div>'
                    // '<span data-plus-time="" class=" plus_time plus-time-count">'+obj.total_time.total_time+'</span>';
                    html += '<span class="time-plus " id="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' + obj.total_time.total_time + '</span>';
                } else {
                    // html += '<div class="col-lg-4 col-12"><div class="analytics-info"><h3 class="title">Total Time:</h3><h3 class="total_time1"><span class="minus_time minus-time-count minus-time-count1">'+obj.total_time.total_time+'</span></h3></div></div>'
                    // html += '<span data-plus-time="" class="minus_time minus-time-count">'+obj.total_time.total_time+'</span>';
                    html += '<span class="time-minus " id="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;' + obj.total_time.total_time + '</span>';
                }
                $('#total_time1').html(html);
                /* if(obj.total_time.time_status == 'plus'){
                     html += '<span class="time-plus " id="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp; '+obj.total_time.total_time+'</span>'
                 }else{
                     html += '<span class="time-minus " id="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp; '+obj.total_time.total_time+'</span>'
                 }
                 $('#total_time1').html(html);*/
                // $("#time-plus").html('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;'+obj.total_time.plus_time);
                // $("#time-minus").html('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;'+obj.total_time.minus_time);
                if ($('#title').text() == "List Employees Attendance") {
                    var d = new Date();
                    var date = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();
                    var url = base_url + 'employee/employee_attendance/' + $("#employee").val() + '/' + date;
                } else if ($('#title').text() == "List Attendance") {
                    var url = base_url + 'profile/add_employee_attendance';
                }
                $(".add_attendance1").attr('href', url);
                $(".h4_name").text('Name : ' + obj.emp_detail[0].fname + ' ' + obj.emp_detail[0].lname + ' (' + obj.emp_detail[0].name + ')');
                $('.preloader-2').attr('style', 'display:none !important;');
            },
        });
    }
    /* $(document).on('click', '.close_popup', function(){
            $(this).parent('.field-box').hide();
            $('.field-box').css('display','none');
            $(this).find('.field-box').css('display','none');
            
        // $( ".field-edit" ).each(function() {
            //$(this).removeClass("open");
            //$(this).css("open");
            
        //}); 	
    }); */
    $('.close_popup').on('click', function (e) {
        e.stopPropagation();
        // $(this).parent('.field-box').hide();
        $('.field-box').css('display', 'none');
        //$(this).find('.field-box').css('display','none');
    });
    $(document).on('click', '.field-edit', function () {
        var popup_status = $(this).data('popup-status');
        if (popup_status != "") {
            if (popup_status == "active") {
                $('.field-edit').removeClass("open");
                $(this).parent('.field-box').show();
                $('.field-box').css('display', 'none');
                $(this).find('.field-box').css('display', 'block');
            }
        }
    });


    $(".update_time").click(function () {
        $(this).each(function () {
            var type = $(this).data('type');
            var attendance_date = $(this).data('attendance-date');
            var time = $(this).closest(".field-box").find('.get_time').val();
            var base_url = $("#js_data").data('base-url');
            var id = $("#employee").val();
            var error = "0";
            var employee_in = $(".in_time_" + attendance_date).text();
            var employee_out = $(".out_time_" + attendance_date).text();
            var employee_in1 = $(".in1_time_" + attendance_date).text();
            var employee_out1 = $(".out1_time_" + attendance_date).text();
            if (!time) {
                $(this).closest(".field-box").find('.get_time').addClass('error');
            } else {
                if (type == "out") {
                    if (employee_in != "" && time != "") {
                        var t = attendance_date + " " + employee_in;
                        var t1 = attendance_date + " " + time;
                        var dtStart = new Date(t);
                        var dtEnd = new Date(t1);
                        var difference_in_milliseconds = dtEnd - dtStart;


                        if (difference_in_milliseconds < 0) {
                            $(this).closest(".field-box").find('.get_time').addClass('error');
                            error = 1;
                        } else {
                            $(this).closest(".field-box").find('.get_time').removeClass('error');
                        }
                    }
                }
                if (type == "in1") {
                    if (employee_in != "" && employee_out != "" && time != "") {
                        var t = attendance_date + " " + employee_in;
                        var t2 = attendance_date + " " + employee_out;


                        var t1 = attendance_date + " " + time;
                        var dtStart = new Date(t);
                        var dtStart2 = new Date(t2);
                        var dtEnd = new Date(t1);
                        var difference_in_milliseconds = dtEnd - dtStart;
                        var difference_in_milliseconds2 = dtEnd - dtStart2;
                        if (difference_in_milliseconds < 0 || difference_in_milliseconds2 < 0) {
                            $(this).closest(".field-box").find('.get_time').addClass('error');
                            error = 1;
                        } else {
                            $(this).closest(".field-box").find('.get_time').removeClass('error');
                        }
                    }
                }
                if (type == "out1") {
                    if (employee_in != "" && employee_out != "" && time != "") {
                        var t = attendance_date + " " + employee_in;
                        var t2 = attendance_date + " " + employee_out;
                        var t3 = attendance_date + " " + employee_in1;
                        var t1 = attendance_date + " " + time;
                        var dtStart = new Date(t);
                        var dtStart2 = new Date(t2);
                        var dtStart3 = new Date(t3);
                        var dtEnd = new Date(t1);
                        var difference_in_milliseconds = dtEnd - dtStart;
                        var difference_in_milliseconds2 = dtEnd - dtStart2;
                        var difference_in_milliseconds3 = dtEnd - dtStart3;
                        if (difference_in_milliseconds < 0 || difference_in_milliseconds2 < 0 || difference_in_milliseconds3 < 0) {
                            $(this).closest(".field-box").find('.get_time').addClass('error');
                            error = 1;
                        } else {
                            $(this).closest(".field-box").find('.get_time').removeClass('error');
                        }
                    }
                }
                //return false;
                if (error == '0') {
                    var data = { 'id': id, 'type': type, 'attendance_date': attendance_date, 'time': time };
                    $.ajax({
                        url: base_url + "/employee/add_time",
                        type: "post",
                        data: data,
                        success: function (response) {
                            if (response != "") {
                                var obj = JSON.parse(response);
                                var total_time = obj.total_time;
                                var select_time = obj.select_time;
                                var time_count = obj.time_count;
                                var class_name = obj.class_name;
                                $(".total_time_" + attendance_date).text(total_time);
                                $(".plus_minus_time_" + attendance_date).html(time_count);
                                $("." + type + "_time_" + attendance_date).text(select_time);

                                $(".field-edit").each(function () {
                                    if (attendance_date == $(this).data('attendance-date')) {
                                        if (class_name != "") {
                                            $(this).closest('tr').addClass(class_name);
                                        } else {
                                            $(this).closest('tr').removeClass("halfday-leave-color");
                                        }

                                        if (type == "in") {
                                            if ($(this).data('type') == "out") {
                                                $(this).attr('data-popup-status', 'active');
                                            }
                                        } else if (type == "out") {
                                            if ($(this).data('type') == "in1") {
                                                $(this).attr('data-popup-status', 'active');
                                            }
                                        } else if (type == "in1") {
                                            if ($(this).data('type') == "out1") {
                                                $(this).attr('data-popup-status', 'active');
                                            }
                                        }
                                    }
                                    $(this).removeClass("open");
                                    //$(this).css('display','none');
                                    //$(this).closest('tr').addClass("red");
                                    $('.field-box').css('display', 'none');
                                    $(this).find('.field-box').css('display', 'none');

                                    //$('.field-box').css('display','none');
                                });
                            }
                            //table.order( [ 0, 'asc' ] ).draw();	
                        },
                    });
                }

            }
        });
    });
    $(document).on('click', '.delete-employee-attendances', function () {

        if (confirm("Are you sure?")) {

            jQuery(".loader-text").html("Deleting Employee");

            jQuery(".loader-wrap").show();

            var id = $(this).attr("data-id");

            var date = $(this).attr("data-date");



            var data = {

                'id': id,

                'date': date,

            };

            $.ajax({

                url: "../delete_employee_attendance",

                type: "post",

                data: data,

                success: function (response) {
                    attendance_search();
                    // location.reload();
                    // window.location.replace("../employee_attendance_list/"+id);

                },



            });


        }

        return false;

    });

    function checkDate(start, end) {

        var mStart = moment(start);

        var mEnd = moment(end);

        return mStart.isBefore(mEnd);

    }
    $("#full-attendance-form").submit(function (e) {
        var developer = $("#developer").val();
        var month = $("#month").val();
        var year = $("#year").val();
        if (!developer || !month || !year) {

            if (!developer) {
                $("#developer").addClass('error');
            } else {
                $("#developer").removeClass('error');
            }

            if (!month) {
                $("#month").addClass('error');
            } else {
                $("#month").removeClass('error');
            }

            if (!year) {
                $("#year").addClass('error');
            } else {
                $("#year").removeClass('error');
            }
            return false;
        } else {
            $("#developer").removeClass('error');
            $("#month").removeClass('error');
            $("#year").removeClass('error');
            var data = { 'developer': developer, 'month': month, 'year': year };
            $.ajax({
                url: base_url + "employee/insert_full_attendance",
                type: "post",
                async: false,
                data: data,
                success: function (response) {
                    if (response != '') {
                        var obj = JSON.parse(response);
                        $('.msg-container').html(obj.massage);
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        setTimeout(function () {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                        window.open((base_url + 'employee/employee_attendance_list/' + developer), '_blank');
                    }
                }
            });
            // return true;
            return false;
        }
        return false;
    });

    $("#search-form11").submit(function (e) {

        var from_date = $("#from_date").val();

        var to_date = $("#to_date").val();

        var search_dropdwon = $("#search_dropdwon").val();

        if (!search_dropdwon) {

            if (!from_date || !to_date) {

                e.preventDefault();

                if (!from_date) {

                    $("#from_date").addClass('error');

                } else {

                    $("#from_date").removeClass('error');

                }

                if (!to_date) {

                    $("#to_date").addClass('error');

                } else {

                    $("#to_date").removeClass('error');

                }



                return false;

            } else {

                $("#from_date").removeClass('error');

                $("#to_date").removeClass('error');

                $("#search_dropdwon").val('');

                return true;

            }

        } else {

            if (!search_dropdwon) {

                var validtion = checkDate(from_date, to_date);

                if (validtion == false) {

                    $('.error_msg').html('<span style="color:red;">End date should not be less than start date </span>');

                    return false;



                } else {

                    $('.error_msg').html("");

                    return true;

                }

                $("#search_dropdwon").val('');



            } else {

                $("#from_date").val('');

                $("#to_date").val('');

                return true;

            }
        }

    });

    /* Start Add Attendance Code */
    // $('.btn-open-desig').click();

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

    function convertTringtoTime(timetoSting){
        var ampm = (timetoSting).split(" ");
        var timeString = ampm[0]+':00';
        var timeStringArr = timeString.split(":");
        var time = (ampm[1] == 'PM') ? (parseInt(timeStringArr[0]) == 12) ? timeString : (parseInt(timeStringArr[0])+12)+':'+timeStringArr[1]+':00' : timeString;
        return time;
    }

    function diffMinutes(dt2, dt1) 
    {
        var diff =(dt2 - dt1) / 1000;
        diff /= 60;
        return Math.abs(Math.round(diff));
    
    }
    $(document).on('click', '.submit_form', function () {
        var d = new Date();
        if(d.getDay() != 7 && d.getDay() != 6){
            $(this).attr('disabled', 'disabled');
            $('#myModal > preloader-2').attr('style', 'display: block !important;');
            var d = new Date();
            var month = d.getMonth() + 1;
            var day = d.getDate();
            var output = d.getFullYear() + '/' +
                (month < 10 ? '0' : '') + month + '/' +
                (day < 10 ? '0' : '') + day;
            
            switch($(this).data('attendance')){
                case 2:
                    var time1 = (new Date(output+" "+convertTringtoTime($('#in_time').val()))).getTime();
                    var time2 = (new Date(output+" "+convertTringtoTime(formatAMPM(new Date)))).getTime();
                    var text = 'IN';
                    var text1 = 'OUT attendance '+formatAMPM(new Date);
                    var diff_result = diffMinutes(time1,time2);
                break;
                case 3:
                    var time1 = (new Date(output+" "+convertTringtoTime($('#out_time').val()))).getTime();
                    var time2 = (new Date(output+" "+convertTringtoTime(formatAMPM(new Date)))).getTime();
                    var text = 'OUT';
                    var text1 = 'IN attendance '+formatAMPM(new Date);
                    var diff_result = diffMinutes(time1,time2);
                break;
                case 4:
                    var time1 = (new Date(output+" "+convertTringtoTime($('#in_time1').val()))).getTime();
                    var time2 = (new Date(output+" "+convertTringtoTime(formatAMPM(new Date)))).getTime();
                    var text = 'IN';
                    var text1 = 'OUT attendance '+formatAMPM(new Date);
                    var diff_result = diffMinutes(time1,time2);
                break;
                default:
                    var diff_result = 100;
                break;
            }
            var $num = (diff_result < 3) ? 0 : 1;
            var $flag = ($num == 0) ? (confirm('You have already added your recent '+text+' attendance, so do you want to add '+text1+'?')) ? 'true' : 'false' : 'true' ;

            if($flag == 'true'){
                //$(".submit_form").click(function(){
                var attendance_type = $("#attendance_type option:selected").val();
                var daily_work_error = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>First Add Your Daily Work Updates Proper.</p></div></div></div>';
                var daily_work = $.trim($("#daily_work").val());
                // daily_work = ((/[0-9A-Za-z]/).test(daily_work))? daily_work : '';
                // daily_work = (daily_work != '' && daily_work.length > 20)? daily_work : '';
                var error = 0;
                if(daily_work != ''){
                    if ((/[0-9A-Za-z]/).test(daily_work)) {
                        daily_work = daily_work;
                    } else {
                        daily_work = '';
                        error++;
                        daily_work_error = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please do not write an only special character when you are adding a daily work updates.</p></div></div></div>';
                    }
                }else{
                    error++;
                    daily_work_error = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please fill-up your daily work updates to successfully add an attendance.</p></div></div></div>';
                }

                if (daily_work != '' && daily_work.length > 20) {
                    daily_work = daily_work;
                } else {
                    daily_work = '';
                    daily_work_error = error ? daily_work_error : '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please write more than 20 characters in the given filled .</p></div></div></div>';
                }
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
                    var current_time = "";
                    var html = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Attendance Inserted Successfully.</p></div></div></div>';
                    var html1 = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Attendance Inserted Failed.</p></div></div></div>';
                    if ($(this).data('attendance') == 1) {

                        var out_box2 = '<div class="form-group _form out_box2"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>Out *</label></div><div class="col-8 col-sm-5 "><div class="in1_val"><div class="form-group out_section"> <span class="time_in2">' + formatAMPM(new Date) + '</span> <button type="button" class="btn sec-btn submit_form pull-right" data-attendance="2">ADD</button> <input type="hidden" value="2" name="employee_in" id="employee_in" /> <input type="hidden" id="out_time" value="' + formatAMPM(new Date) + '" name=""></div></div></div></div><span class="span"></span></div>';
                        var text_eara = '';
                        if (attendance_type == 'half_day') {
                            text_eara = '<div class="form-group m-0 m-t-30">' +
                                '<div class="single-field">' +
                                '<textarea class="textarea" name="daily_work" id="daily_work" placeholder=" - For example today I have worked on these given tasks (mention tasks name)."></textarea>' +
                                '<label>Daily Work Updates*</label>' +
                                '<small class="work-info">Note: kindly mention your today completed work <span data-tooltip=" - For example today I have worked on these given tasks (mention tasks name)."><i class="fas fa-eye"></i></span></small>' +
                                '</div>' +
                                '</div>';
                        }
                        if (daily_work == '') {
                            daily_work = '';
                        }
                        $('.submit_form').attr('disabled', true);
                        current_time = formatAMPM(new Date);
                        var base_url = $("#js_data").data('base-url');
                        var data = { in_time: current_time, attendance_type: attendance_type, employee_in: attendance, in_out_time: "0", datepicker: output, in_out_time_count: "0", daily_work: daily_work, csrf_test_name: $("input[name=csrf_test_name]").val() };
                        var htmlClass1 = 'out_box1'; var htmlCode1 = out_box2; var htmlClass2 = 'out_box1'; var buttonClass = 'submit_form'; var textearaClass = '.out_box2 .span';
                        var htmlCode2 = '<div class="form-group _form"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>In *</label></div><div class="col-8 col-sm-5 "><div class="in1_val" data-name="In">' + formatAMPM(new Date) + '<input type="hidden" id="in_time" name="in_time" value="' + formatAMPM(new Date) + '" name=""></div></div></div></div>';
                        addAttendance(data, htmlClass1, htmlCode1, htmlClass2, htmlCode2, textearaClass, text_eara, html, html1, buttonClass, $(this).data('attendance'));
                    }
                    if ($(this).data('attendance') == 2) {
                        var num = 0;
                        if (attendance_type == 'half_day' && daily_work == '') {
                            num++;
                        } else if (attendance_type == 'half_day' && daily_work != '' && maxlength(daily_work, 200) === false) {
                            num++;
                        }

                        if (num == 0) {
                            $('#daily_work').removeClass('error');
                            out_box3 = '<div class="form-group _form hide_in_out form-add-field out_box3" ><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>IN *</label></div><div class="col-8 col-sm-5 "><div class="in1_val"><div class="form-group out_section"> <span class="time_in3">' + formatAMPM(new Date) + '</span> <button type="button" class="btn sec-btn submit_form pull-right" data-attendance="3">ADD</button> <input type="hidden" value="3" name="employee_in" id="employee_in" /> <input type="hidden" id="in_time1" value="' + formatAMPM(new Date) + '" name="in_time1"></div></div></div></div></div>';

                            $('.submit_form').attr('disabled', true);
                            current_time = formatAMPM(new Date);
                            var base_url = $("#js_data").data('base-url');
                            var data = { out_time: current_time, attendance_type: attendance_type, employee_in: attendance, in_out_time: "0", datepicker: output, in_out_time_count: "0", daily_work: daily_work, csrf_test_name: $("input[name=csrf_test_name]").val() };
                            var htmlClass1 = 'out_box2'; var htmlCode1 = out_box3; var htmlClass2 = 'out_box2';
                            var htmlCode2 = '<div class="form-group _form"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>Out *</label></div><div class="col-8 col-sm-5 "><div class="in1_val" data-name="In"> ' + formatAMPM(new Date) + ' <input type="hidden" id="out_time" value="' + formatAMPM(new Date) + '" name="out_time"></div></div></div></div>';
                            var textearaClass = '.out_box2 .span'; var text_eara = ''; var buttonClass = 'submit_form';
                            addAttendance(data, htmlClass1, htmlCode1, htmlClass2, htmlCode2, textearaClass, text_eara, html, html1, buttonClass, $(this).data('attendance'));
                        } else {
                            ajaxError(daily_work_error, 'submit_form')
                        }
                    }
                    if ($(this).data('attendance') == 3) {

                        out_box4 = '<div class="form-group _form out_box4"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>Out *</label></div><div class="col-8 col-sm-5 "><div class="in1_val"><div class="form-group out_section"> <span class="time_in4">' + formatAMPM(new Date) + '</span> <button type="button" class="btn sec-btn submit_form pull-right" data-attendance="4">ADD</button> <input type="hidden" value="4" name="employee_in" id="employee_in" /> <input type="hidden" id="out_time1" value="' + formatAMPM(new Date) + '" name="out_time1"></div></div></div></div><span class="span"></span></div>';
                        // var text_eara = '';
                        // if(attendance_type == 'full_day'){
                        text_eara = '<div class="form-group m-0 m-t-30">' +
                            '<div class="single-field">' +
                            '<textarea class="textarea" name="daily_work" id="daily_work" placeholder=" - For example today I have worked on these given tasks (mention tasks name)."></textarea>' +
                            '<label>Daily Work Updates*</label>' +
                            '<small class="work-info">Note: kindly mention your today completed work <span data-tooltip=" - For example today I have worked on these given tasks (mention tasks name)."><i class="fas fa-eye"></i></span></small>' +
                            '</div>' +
                            '</div>';
                        // }

                        if (daily_work == '') {
                            daily_work = '';
                        }
                        $('.submit_form').attr('disabled', true);
                        current_time = formatAMPM(new Date);
                        var base_url = $("#js_data").data('base-url');
                        var data = { in_time1: current_time, attendance_type: attendance_type, employee_in: attendance, in_out_time: "0", datepicker: output, in_out_time_count: "0", daily_work: daily_work, csrf_test_name: $("input[name=csrf_test_name]").val() };
                        var htmlClass1 = 'out_box3'; var htmlCode1 = out_box4; var htmlClass2 = 'out_box3';
                        var htmlCode2 = '<div class="form-group _form"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>IN *</label></div><div class="col-8 col-sm-5 "><div class="in1_val" data-name="In"> ' + formatAMPM(new Date) + ' <input type="hidden" id="in_time1" value="' + formatAMPM(new Date) + '" name="in_time1"></div></div></div></div>';
                        var textearaClass = '.out_box4 .span'; var buttonClass = 'submit_form';
                        addAttendance(data, htmlClass1, htmlCode1, htmlClass2, htmlCode2, textearaClass, text_eara, html, html1, buttonClass, $(this).data('attendance'));
                    }
                    if ($(this).data('attendance') == 4) {
                        /* out_box4 */
                        // var num = 0;
                        // if(attendance_type == 'full_day' && daily_work == ''){
                        //     num++;
                        // }
                        
                        if (daily_work != '' && maxlength(daily_work, 200)) {
                            $('#daily_work').removeClass('error');
                            // $('.out_box4').html('<div class="form-group _form"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>Out *</label></div><div class="col-8 col-sm-5 "><div class="in1_val" data-name="In"> ' + formatAMPM(new Date) + ' <input type="hidden" id="out_time1" value="' + formatAMPM(new Date) + '" name="out_time1"></div></div></div><span class="span"></span></div>');
                            // var text_eara = '';
                            // if(attendance_type == 'full_day'){
                            text_eara = '<div class="form-group m-0 m-t-30">' +
                                '<div class="single-field">' +
                                '<textarea class="textarea" id="task_list" disabled placeholder=" - For example today I have worked on these given tasks (mention tasks name)."></textarea>' +
                                '<label>Daily Work Updates*</label>' +
                                '<small class="work-info">Note: kindly mention your today completed work <span data-tooltip=" - For example today I have worked on these given tasks (mention tasks name)."><i class="fas fa-eye"></i></span></small>' +
                                '</div>' +
                                '</div>';
                            // }
                            // if(daily_work != ''){
                            current_time = formatAMPM(new Date);
                            var data = { out_time1: current_time, attendance_type: attendance_type, employee_in: attendance, in_out_time: "0", datepicker: output, in_out_time_count: "0", daily_work: daily_work, csrf_test_name: $("input[name=csrf_test_name]").val() };
                            var base_url = $("#js_data").data('base-url');
                            var htmlClass1 = 'out_box2'; var htmlCode1 = ''; var htmlClass2 = 'out_box4';
                            var htmlCode2 = '<div class="form-group _form"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>Out *</label></div><div class="col-8 col-sm-5 "><div class="in1_val" data-name="In"> ' + formatAMPM(new Date) + ' <input type="hidden" id="out_time1" value="' + formatAMPM(new Date) + '" name="out_time1"></div></div></div><span class="span"></span></div>';
                            var textearaClass = '.out_box4 .span'; var buttonClass = 'submit_form';
                            addAttendance(data, htmlClass1, htmlCode1, htmlClass2, htmlCode2, textearaClass, text_eara, html, html1, buttonClass, $(this).data('attendance'));
                        } else {
                            $('#daily_work').addClass('error');
                            ajaxError(daily_work_error, 'submit_form');
                        }
                    }
                    //$("#employee-form").submit();
                } else {
                    var html = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Select day type</p></div></div></div>';
                    ajaxError(html, 'submit_form');
                }
                attendance_search();
            }else{
                $(this).attr('disabled', false);
                $('#myModal > preloader-2').attr('style', 'display: none !important;');
            }
        }else{
            day = (d.getDay() == 7)?"Sunday":"Saturday";
            daily_work_error = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Sorry, Your attendance does not insert because today is '+day+'</p></div></div></div>';
            ajaxError(daily_work_error, 'submit_form');
            $('#timeCounter').parent('div').hide();
            $('.btn-open-desig').prop('disabled',true);
            $('#myModal').modal('hide'); 
        }
    });
    function addAttendance(data, htmlClass1, htmlCode1, htmlClass2, htmlCode2, textearaClass, text_eara, successMessage, errorMessage, buttonClass, attendanceCode) {
        var d = new Date();
        if(d.getDay() != 7 && d.getDay() != 6){
            if (attendanceCode == 4) {
                $('.' + htmlClass2).html(text_eara);
            }
            $('.' + buttonClass).attr('disabled', true);
            current_time = formatAMPM(new Date);
            var base_url = $("#js_data").data('base-url');
            $.ajax({
                type: "post",
                url: base_url + 'profile/insert_employee_attendance_new',
                data: data,
                success: function (response) {
                    var obj = JSON.parse(response);
                    if (obj.error_code == 0) {

                        table.clear();
                        table.ajax.reload();
                        if (attendanceCode == 4) {
                            $('.' + htmlClass1 + ' .span').html('');
                            $('.' + htmlClass2 + ' .span').html('');
                            $(textearaClass).html(text_eara);
                            $('#task_list').text(obj.daily_work_list[0].daily_work);
                        } else if (attendanceCode == 3) {
                            $('.out_box2 .span').html('');
                            $(textearaClass).html(text_eara);
                            if (obj.daily_work_list != '') {
                                $('.out_box4 .span #daily_work').val(obj.daily_work_list[0].daily_work);
                                $('#task_list').text(obj.daily_work_list[0].daily_work);
                            }
                        } else {
                            $('.' + htmlClass1).after(htmlCode1);
                            $('.' + htmlClass2).html(htmlCode2);
                            $(textearaClass).html(text_eara);
                        }
                        ajaxSuccess(successMessage, buttonClass);
                        $('#employee_in').val(attendanceCode+1);
                        var counter =  (attendanceCode == 4) ? 'stop' :'' ;
                        var totalTime = ($("#attendance_type option:selected").val() == 'half_day') ? '04:30:00' : '08:45:00';
                        addValue(totalTime,'minus');
                        documentReady(counter);
                    } else {
                        if(obj.message == '' || obj.message == undefined)
                        ajaxError(errorMessage, buttonClass);
                        else
                        ajaxError(obj.message, buttonClass);
                        $('.close').click();
                    }
                    /*  setTimeout(function() {
                    }, 800); */
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    ajaxError(errorMessage, buttonClass);
                }
            });
        }else{
            day = (d.getDay() == 7)?"Sunday":"Saturday";
            daily_work_error = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Sorry, Your attendance does not insert because today is '+day+'</p></div></div></div>';
            ajaxError(daily_work_error, 'submit_form');
            $('#timeCounter').parent('div').hide();
            $('.btn-open-desig').prop('disabled',true);
            $('#myModal').modal('hide');
        }
    }
    function ajaxSuccess(successMessage, buttonClass) {
        $('.' + buttonClass).attr('disabled', false);
        $('.preloader.preloader-2').attr('style', 'display: none !important;');
        $('.msg-container').html(successMessage);
        $('.msg-container .msg-box').attr('style', 'display:block');
        setTimeout(function () {
            $('.msg-container .msg-box').attr('style', 'display:none');
        }, 6000);
        $('.close').click();
    }
    function ajaxError(errorMessage, buttonClass) {
        $('.' + buttonClass).attr('disabled', false);
        $('.preloader.preloader-2').attr('style', 'display: none !important;');
        $('.msg-container').html(errorMessage);
        $('.msg-container .msg-box').attr('style', 'display:block');
        setTimeout(function () {
            $('.msg-container .msg-box').attr('style', 'display:none');
        }, 6000);
    }

    /* End Add Attendance Code */
    $('#attendance_type').change(function () {
        var text_eara = '<div class="form-group m-0 m-t-30" id="daily_work_div">' +
            '<div class="single-field">' +
            '<textarea class="textarea" name="daily_work" id="daily_work" placeholder=" - For example today I have worked on these given tasks (mention tasks name)."></textarea>' +
            '<label>Daily Work Updates*</label>' +
            '<small class="work-info">Note: kindly mention your today completed work <span data-tooltip=" - For example today I have worked on these given tasks (mention tasks name)."><i class="fas fa-eye"></i></span></small>' +
            '</div>' +
            '</div>';
        $('#employee_out_input .span').hide();
        $('.submit_form1').remove();
        $('.out_box3').show();
        if ($('.submit_form').data('attendance') == 2 && $(this).val() == 'full_day') {
            $('.out_box2 .span').html('');
        } else if ($('.submit_form').data('attendance') == 2 && $(this).val() == 'half_day') {
            if ($('.out_box2 .span').html() == '') { $('#daily_work_div').remove(); $('.out_box2 .span').html(text_eara); }
        } else if ($('.submit_form').data('attendance') == 4 && $(this).val() == 'full_day') {
            // if($('.out_box4 .span').html() == ''){$('.out_box4 .span').html(text_eara);}
        } else if ($('.submit_form').data('attendance') == 3 && $(this).val() == 'half_day') {
            $('#daily_work_div').remove();
            $('#employee_out_input .span').html(text_eara + '<button type="button" class="btn sec-btn submit_form1 pull-right" onclick="submit_form1();">ADD</button>');
            $('#employee_out_input .span').show();
            $('.out_box3').hide();
        }
    });
    $('.btn-open-desig').click(function () {
            fillModel();
    });
    function fillModel() {
        var d = new Date();
        if(d.getDay() != 7 && d.getDay() != 6){
            $('#timeCounter').parent('div').show();
            $('.btn-open-desig').prop('disabled',false);
            $('#myModal .preloader-2').attr('style', 'display: block !important;');
            $('#myModal').modal('show');
            var d = new Date();
            var month = d.getMonth() + 1;
            var day = d.getDate();
            var output = d.getFullYear() + '/' + (month < 10 ? '0' : '') + month + '/' + (day < 10 ? '0' : '') + day;
            var base_url = $("#js_data").data('base-url');
            var csrf_test_name = $("input[name=csrf_test_name]").val();
            $.ajax({
                type: "post",
                url: base_url + 'profile/getAttendance',
                data: { datepicker: output, csrf_test_name: csrf_test_name },
                success: function (data) {
                    var html = '';
                    var obj = JSON.parse(data);
                    if(obj != null && obj != ''){
                        var text_eara = '<div class="form-group m-0 m-t-30" id="daily_work_div">' +
                            '<div class="single-field">' +
                            '<textarea class="textarea" name="daily_work" id="daily_work" placeholder=" - For example today I have worked on these given tasks (mention tasks name)."></textarea>' +
                            '<label>Daily Work Updates*</label>' +
                            '<small class="work-info">Note: kindly mention your today completed work <span data-tooltip=" - For example today I have worked on these given tasks (mention tasks name)."><i class="fas fa-eye"></i></span></small>' +
                            '</div>' +
                            '</div>';
                        if (obj.get_employee_attendance.length == 1) {
                            // alert('OK1');
                            var date_in = new Date(obj.get_employee_attendance[0].employee_in);
                            html += '<div class="form-group _form"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>IN *</label></div><div class="col-8 col-sm-5 "><div class="in1_val" data-name="In">' + formatAMPM(date_in) + '<input type="hidden" id="in_time" name="in_time" value="' + formatAMPM(date_in) + '" name=""></div></div></div></div>';
                            if (obj.get_employee_attendance[0].employee_out) {
                                // alert('if 1');
                                var date_out = new Date(obj.get_employee_attendance[0].employee_out);
                                html += '<div class="form-group _form" id="employee_out_input"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>Out *</label></div><div class="col-8 col-sm-5 "><div class="in1_val" data-name="In"> ' + formatAMPM(date_out) + ' <input type="hidden" id="out_time" value="' + formatAMPM(date_out) + '" name="out_time"></div></div></div><span class="span"></span></div>';
                                html += '<div class="form-group _form hide_in_out form-add-field out_box3" ><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>IN *</label></div><div class="col-8 col-sm-5 "><div class="in1_val"><div class="form-group out_section"> <span class="time_in3">' + formatAMPM(new Date) + '</span> <button type="button" class="btn sec-btn submit_form pull-right" data-attendance="3">ADD</button> <input type="hidden" value="3" name="employee_in" id="employee_in" /> <input type="hidden" id="in_time1" value="' + formatAMPM(new Date) + '" name="in_time1"></div></div></div></div></div>';
                                $('#html').html(html);
                                if (obj.daily_work_list[0]) {
                                    if (obj.daily_work_list[0].daily_work != '' && obj.get_employee_attendance[0].attendance_type == 'half_day') {
                                        $('#employee_out_input .span').html('<div class="form-group m-0 m-t-30">' +
                                            '<div class="single-field">' +
                                            '<textarea class="textarea" id="task_list" disabled placeholder=" - For example today I have worked on these given tasks (mention tasks name)."></textarea>' +
                                            '<label>Daily Work Updates*</label>' +
                                            '<small class="work-info">Note: kindly mention your today completed work <span data-tooltip=" - For example today I have worked on these given tasks (mention tasks name)."><i class="fas fa-eye"></i></span></small>' +
                                            '</div>' +
                                            '</div>');
                                        $('#task_list').text(obj.daily_work_list[0].daily_work);
                                        $('.out_box3').hide();
                                    }
                                } else {
                                    if (obj.get_employee_attendance[0].attendance_type == 'half_day') {
                                        $('#employee_out_input .span').html(text_eara + '<button type="button" class="btn sec-btn submit_form1 pull-right" onclick="submit_form1();">ADD</button>');
                                        $('.out_box3').hide();
                                    }
                                }
                            } else {
                                // alert('else 1');
                                html += '<div class="form-group _form out_box2"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>Out *</label></div><div class="col-8 col-sm-5 "><div class="in1_val"><div class="form-group out_section"> <span class="time_in2">' + formatAMPM(new Date) + '</span> <button type="button" class="btn sec-btn submit_form pull-right" data-attendance="2">ADD</button> <input type="hidden" value="2" name="employee_in" id="employee_in" /> <input type="hidden" id="out_time" value="' + formatAMPM(new Date) + '" name=""></div></div></div></div><span class="span"></span></div>';
                                $('#html').html(html);
                                if (obj.get_employee_attendance[0].attendance_type == 'half_day') {
                                    $('.out_box2 .span').html(text_eara);
                                    // $('#task_list').text(obj.daily_work_list[0].daily_work);
                                    // $('.out_box3').hide();
                                }
                            }
                        } else if (obj.get_employee_attendance.length == 2) {
                            // alert('OK2');
                            var date_in1 = new Date(obj.get_employee_attendance[0].employee_in);
                            var date_out1 = new Date(obj.get_employee_attendance[0].employee_out);
                            var date_in2 = new Date(obj.get_employee_attendance[1].employee_in);
                            html += '<div class="form-group _form"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>IN *</label></div><div class="col-8 col-sm-5 "><div class="in1_val" data-name="In">' + formatAMPM(date_in1) + '<input type="hidden" id="in_time" name="in_time" value="' + formatAMPM(date_in1) + '" name=""></div></div></div></div>';
                            html += '<div class="form-group _form" id="employee_out_input"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>Out *</label></div><div class="col-8 col-sm-5 "><div class="in1_val" data-name="In"> ' + formatAMPM(date_out1) + ' <input type="hidden" id="out_time" value="' + formatAMPM(date_out1) + '" name="out_time"></div></div></div></div>';
                            html += '<div class="form-group _form"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>IN *</label></div><div class="col-8 col-sm-5 "><div class="in1_val" data-name="In"> ' + formatAMPM(date_in2) + ' <input type="hidden" id="in_time1" value="' + formatAMPM(date_in2) + '" name="in_time1"></div></div></div></div>';
                            if (obj.get_employee_attendance[1].employee_out) {
                                // alert('if 2');
                                var date_out2 = new Date(obj.get_employee_attendance[1].employee_out);
                                html += '<div class="form-group _form"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>Out *</label></div><div class="col-8 col-sm-5 "><div class="in1_val" data-name="In"> ' + formatAMPM(date_out2) + ' <input type="hidden" id="out_time1" value="' + formatAMPM(date_out2) + '" name="out_time1"></div></div></div><span class="span"></span></div>';
                                $('#html').html(html);
                                if (obj.daily_work_list[0].daily_work) {
                                    $('.span').html('<div class="form-group m-0 m-t-30">' +
                                        '<div class="single-field">' +
                                        '<textarea class="textarea" id="task_list" disabled placeholder=" - For example today I have worked on these given tasks (mention tasks name)."></textarea>' +
                                        '<label>Daily Work Updates*</label>' +
                                        '<small class="work-info">Note: kindly mention your today completed work <span data-tooltip=" - For example today I have worked on these given tasks (mention tasks name)."><i class="fas fa-eye"></i></span></small>' +
                                        '</div>' +
                                        '</div>');
                                    $('#task_list').html(obj.daily_work_list[0].daily_work);
                                }
                            } else {
                                // alert('else 2');
                                html += '<div class="form-group _form out_box4"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>Out *</label></div><div class="col-8 col-sm-5 "><div class="in1_val"><div class="form-group out_section"> <span class="time_in4">' + formatAMPM(new Date) + '</span> <button type="button" class="btn sec-btn submit_form pull-right" data-attendance="4">ADD</button> <input type="hidden" value="4" name="employee_in" id="employee_in" /> <input type="hidden" id="out_time1" value="' + formatAMPM(new Date) + '" name="out_time1"></div></div></div></div><span class="span"></span></div>';
                                $('#html').html(html);
                                if (obj.daily_work_list[0]) {
                                    if (obj.daily_work_list[0].daily_work) {
                                        $('.out_box4 .span').html(text_eara);
                                        $('#daily_work').val(obj.daily_work_list[0].daily_work);
                                    } else {
                                        $('.out_box4 .span').html(text_eara);
                                    }
                                } else {
                                    $('.out_box4 .span').html(text_eara);
                                }
                            }
                        } else {
                            // alert('OK3');
                            html += '<div class="form-group _form out_box4"><div class="row justify-content-center align-items-center"><div class="col-4 col-sm-5 "> <label>IN *</label></div><div class="col-8 col-sm-5 "><div class="in1_val"><div class="form-group out_section"> <span class="time_in1">' + formatAMPM(new Date) + '</span> <button type="button" class="btn sec-btn submit_form pull-right" data-attendance="1">ADD</button> <input type="hidden" value="1" name="employee_in" id="employee_in" /> <input type="hidden" id="in_time" value="' + formatAMPM(new Date) + '" name="in_time"></div></div></div></div><span class="span"></span></div>';
                            $('#html').html(html);
                        }
                        $('#myModal .preloader-2').attr('style', 'display: none !important;');
                        if(obj.get_employee_attendance.length > 0){ var totalTime = (obj.get_employee_attendance[0].attendance_type == 'half_day') ? '04:30:00' : '08:45:00'; } else { var totalTime = '08:45:00'; }
                        $('#timeCounter').text(totalTime);
                        $('#timeCounter').attr('data-time',totalTime);
                        documentReady();
                    }else{
                        $('#timeCounter').parent('div').hide();
                        $('.btn-open-desig').prop('disabled',true);
                        $('#myModal').modal('hide');
                    }
                },
            });
        }else{
            $('#timeCounter').parent('div').hide();
            $('.btn-open-desig').prop('disabled',true);
            $('#myModal').modal('hide');
        }
    }
});

function submit_form1() {
    $('.submit_form1').attr('disabled', 'disabled');
    $('.preloader.preloader-2').attr('style', 'display: block !important;');
    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var output = d.getFullYear() + '/' + (month < 10 ? '0' : '') + month + '/' + (day < 10 ? '0' : '') + day;
    var attendance_type = $('#attendance_type').val();
    var daily_work = $('#daily_work').val();
    var base_url = $("#js_data").data('base-url');
    if (daily_work != '') {
        $('#daily_work').removeClass('error');
        $.ajax({
            type: "post",
            url: base_url + 'profile/insert_today_task',
            data: { attendance_type: attendance_type, datepicker: output, daily_work: daily_work },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.error_code == 0) {
                    ajaxSuccess(obj.message, 'submit_form1');
                } else {
                    ajaxError(obj.message, 'submit_form1');
                }
            },
        });
    } else {
        ajaxError('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>First add your daily work updates.</p></div></div></div>', 'submit_form1');
    }
}

$('.submit_form').click(function(){
    var counterFlag = false;
    var attendance = $(this).data('attendance');
    if(attendance == 1 || attendance == 3){
        counterFlag = true;
        counterStart(counterFlag,'minus');
    }else{
        counterFlag = false;
        counterStart(counterFlag,'minus');
    }
});
var timeInterva;
function counterStart(counterFlag, type) {
    // var date = $('#datepicker').val();
    if (counterFlag && type != 'stop') {
        timeInterva = setInterval(function () {
        //     var tmpTime = getToTime(date+' '+$('#timeCounter').data('time'));

        //     if(tmpTime <= 0){
        //         let totalTime = ($('#attendance_type').val() == 'half_day') ? '04:30:00' : '08:45:00';
        //         addValue(totalTime,'plus');
        //         type = 'plus';
        //     }

        //    let newTimeString =  (type == 'plus') ? tmpTime+1 : tmpTime-1;

        //     addValue(getTimeFormat(new Date(date+" "+secondsToHms(newTimeString))), type);
            documentReady('counter');
        }, 997);
    }else{
        // if (typeof timeInterva !== 'undefined')
        clearInterval(timeInterva);
        console.log('OKKNS');
    }
}

function documentReady(counterType=''){
    var counterFlag = false;
    var date = $('#datepicker').val();
    if(counterType == '' || counterType != 'counter'){
        var time = $('#timeCounter').data('time');
    }else{
        var time = ($('#attendance_type').val() == 'half_day') ? '04:30:00' : '08:45:00';
    }
    var a = $('#employee_in').val();
    a = (a == undefined)? 5 : a ;
    var inTime = $('#in_time').val(),outTime = $('#out_time').val(),inTime1 = $('#in_time1').val(),outTime1 = $('#out_time1').val();

    if(a != 1 && a != 3){
        var currentTimeString = new Date().getTime();
        if(a == 2){
            var inTimeString = getToTime(date+' '+inTime);
            
            if(getToTime(date+' '+time) > (getToTime(currentTimeString)-inTimeString)){
                var timeDriff = new Date(date+" "+secondsToHms(getToTime(date+' '+time) -(getToTime(currentTimeString)-inTimeString)));
                var $type = $type1 = 'minus';
            }else{
                var timeDriff = new Date(date+" "+secondsToHms((getToTime(currentTimeString)-inTimeString) - getToTime(date+' '+time)));
                var $type = $type1 = 'plus';
            }
            counterFlag = true;
        }else if(a == 4){
            var inTimeString = getToTime(date+' '+inTime), outTimeString = getToTime(date+' '+outTime), inTime1String = getToTime(date+' '+inTime1);

            if(getToTime(date+' '+time) > ((getToTime(currentTimeString)-inTime1String)+(outTimeString-inTimeString))){
                var timeDriff = new Date(date+" "+secondsToHms(getToTime(date+' '+time) - ((getToTime(currentTimeString)-inTime1String)+(outTimeString-inTimeString))));
                var $type = $type1 = 'minus';
            }else{
                var timeDriff = new Date(date+" "+secondsToHms(((getToTime(currentTimeString)-inTime1String)+(outTimeString-inTimeString))-getToTime(date+' '+time)));
                var $type = $type1 = 'plus';
            }
            counterFlag = true;
        }else{
            var inTimeString = getToTime(date+' '+inTime), outTimeString = getToTime(date+' '+outTime), inTime1String = getToTime(date+' '+inTime1), outTime1String = (outTime1 == undefined)? getToTime(currentTimeString) : getToTime(date+' '+outTime1);

            if(getToTime(date+' '+time) > ((outTime1String-inTime1String)+(outTimeString-inTimeString))){
                var timeDriff = new Date(date+" "+secondsToHms(getToTime(date+' '+time) - ((outTime1String-inTime1String)+(outTimeString-inTimeString))));
                var $type = $type1 ='minus';
            }else{
                var timeDriff = new Date(date+" "+secondsToHms(((outTime1String-inTime1String)+(outTimeString-inTimeString))-getToTime(date+' '+time)));
                var $type = $type1 ='plus';
            }
            
            if(counterType == 'stop'){
                clearInterval(timeInterva);
            }
        }
    }else{
        if(a == 1){
            var timeDriff = ($('#attendance_type').val() == 'half_day') ? new Date(date+" "+'04:30:00') : new Date(date+" "+'08:45:00');
            var $type = $type1= 'minus';
        }else if(a == 3){
            var inTimeString = getToTime(date+' '+inTime);
            var outTimeString = getToTime(date+' '+outTime);
            if(getToTime(date+' '+time) > (outTimeString-inTimeString)){
                var timeDriff = new Date(date+" "+secondsToHms((getToTime(date+' '+time) - (outTimeString-inTimeString))));
                var $type = $type1= 'minus';
            }else{
                var timeDriff = new Date(date+" "+secondsToHms(((outTimeString-inTimeString) - getToTime(date+' '+time))));
                var $type = $type1= 'plus';
            }
        }
        var $type1 = 'stop';
        counterFlag = false;
    }
    
    var currentTime = getTimeFormat(timeDriff);
    addValue(currentTime,$type);
    if(counterType == '' || counterType != 'counter' && counterType != 'stop'){
        counterStart(counterFlag,$type1);
    }
}



function getTimeFormat(time){
    
    var tHours = (time.getHours() < 10)? (time.getHours() <= 0) ? '00' : '0'+time.getHours() :time.getHours();
    var tMinutes = (time.getMinutes() < 10)? (time.getMinutes() <= 0) ? '00' : '0'+time.getMinutes() :time.getMinutes();
    var tSeconds = (time.getSeconds() < 10)? (time.getSeconds() <= 0) ? '00' :  '0'+time.getSeconds() :time.getSeconds();
    return tHours+":"+tMinutes+":"+tSeconds;
}
function secondsToHms(d) {
    d = Number(d);
    var h = Math.floor(d / 3600);
    var m = Math.floor(d % 3600 / 60);
    var s = Math.floor(d % 3600 % 60);

    var hDisplay = h > 0 ? h : "00";
    var mDisplay = m > 0 ? m : "00";
    var sDisplay = s > 0 ? s : "00";
    return hDisplay+":"+mDisplay+":"+sDisplay; 
}
function getToTime(date){
    // return new Date(date).getTime();
    var d = new Date(date);
    var seconds = (d.getHours() * 60 * 60) + (d.getMinutes() * 60) + d.getSeconds(); 
    return seconds;
}
function addValue($value,$type){
    if($type == 'plus'){
        $('#timeCounter').removeClass('time-minus').addClass('time-plus').html('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;'+$value);
    }else{
        $('#timeCounter').removeClass('time-plus').addClass('time-minus').html('<i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;'+$value);
    }
    $('#timeCounter').data('time',$value);
}
