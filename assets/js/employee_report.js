var start = moment().subtract(29, 'days');
var end = moment();
var disabledDays = [0, 6];
$('#date_range').datepicker({
    dateFormat: $('#js_data').data('dateformat'),
    language: 'en',
    range: true,
    multipleDatesSeparator: ' - ',
    maxDate: new Date(end),
    onRenderCell: function(date, cellType) {
        if (cellType == 'day') {
            var day = date.getDay(),
                isDisabled = disabledDays.indexOf(day) != -1;
            return {
                disabled: isDisabled
            }
        }
    }
});

$('#date_range').datepicker().data('datepicker').selectDate(new Date(start))
$('#date_range').datepicker().data('datepicker').selectDate(new Date(end));
/* $(function() {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#date_range').val(start.format('DD MMM, YYYY') + ' - ' + end.format('D MMM, YYYY'));
    }

    $('#date_range').daterangepicker({
        // startDate: start,
        // endDate: end,
        isInvalidDate: function(date) {
            if (date.day() == 0 || date.day() == 6)
              return true;
            return false;
          },
        alwaysShowCalendars: true,  
        singleDatePicker: false,
        maxDate: new Date(),
        autoApply: false,
        locale: {
            format: 'DD MMM, YYYY',
            separator: " - ",
          },
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "applyClass": "btn-primary",
    }, cb);

    cb(start, end);
    $('.drp-calendar.right').hide();
    $('.drp-calendar.left').addClass('single');
  
    $('.calendar-table').on('DOMSubtreeModified', function() {
      var el = $(".prev.available").parent().children().last();
      if (el.hasClass('next available')) {
        return;
      }
      el.addClass('next available');
      el.append('<span></span>');
    });

}); */

$('#workupdates_search').click(function (){
    employeeWorkUpdates();
});
function employeeWorkUpdates() {
    var base_url = $("#js_data").data('base-url');
    var id = $("#employee_id").val();
    var range = $('#date_range').val();
    var data = { 'range': range,'id':id};
    $.ajax({
        url: base_url + "reports/employeeWorkUpdates",
        type: "post",
        data: data,
        success: function(response) {
            var obj = JSON.parse(response);
            var $html = '';
            $.each(obj,function(i,v){
                $html += '<div class="col-xl-4 col-md-6">'+
                    '<div class="workUpdate-info">'+
                    '<h4>'+GetFormattedDate(obj[i].attendance_date)+':-</h4>'+
                    '<p class="whiteSpace-break">'+obj[i].daily_work+'</p>'+
                    '</div>'+
                '</div>';
            });
            if($html == '') $html += '<div class="simple-info col-12 no-data"><strong>Data not available!</strong></div>';
           $('#workUpdateDataBox').html($html);
        },
    });
}

function employee_attendance() {
    var base_url = $("#js_data").data('base-url');
    var id = $("#employee_id").val();
    var month = $("#salary_month").val();
    var year = $("#salary_year").val();
    var data = { 'id': id, 'month': month, 'year': year };
    $.ajax({
        url: base_url + "/reports/total_employee_attendance",
        type: "post",
        data: data,
        success: function(response) {
            var obj = JSON.parse(response);
            console.log(obj);
        },
    });
}

function getGetOrdinal(n) {
    var s = ["th", "st", "nd", "rd"],
        v = n % 100;
    return n + (s[(v - 20) % 10] || s[v] || s[0]);
}

function employee_increment_data() {
    var base_url = $("#js_data").data('base-url');
    var id = $("#employee_id").val();
    var data = { 'id': id };
    $.ajax({
        url: base_url + "/reports/employee_increment_deatils",
        type: "post",
        data: data,
        success: function(response) {
            var obj = JSON.parse(response);

            var i;
            var temp = "";
            var view_salary = "";
            var salaryCount = 0;
            if (obj.increment_date[0]) {
                for (i = 0; i < obj.increment_date.length; i++) {

                    if (i == 0) {
                        temp += '<div class="simple-info"> <div class="row m-0"> <div class="col-4 p-0"> <h3 class="title"> Employed Date :</h3> </div><div class="col-4 p-0"> <h3 class="counter increment-first">' + obj.increment_date[i] + '</h3> </div><div class="col-4 p-0"> <h3 class="counter increment-first-amount">' + obj.increment_amount[i] + '</h3> </div></div></div>';
                        salaryCount += Number(obj.increment_amount[i]);
                    } else {
                        salaryCount += Number(obj.increment_amount[i]);
                        // if (obj.increment_total_salary[i - 1]) {
                        //     view_salary = "<span> | " + obj.increment_total_salary[i - 1] + '</span>';
                        // }
                        if (obj.increment_total_salary[i - 1]) {
                            view_salary = "<span> | " + salaryCount + '</span>';
                        }
                        var GetOrdinal = total_salary = '';
                        if(obj.next_increment_date == '0000-00-00' && (obj.increment_amount.length-1) != i){
                            GetOrdinal = getGetOrdinal(i);
                            total_salary = obj.increment_amount[i] + ' ' + view_salary;
                        }else{ 
                            GetOrdinal = 'Next';
                            total_salary = 'Pending';
                        };
                        
                        temp += '<div class="simple-info"> <div class="row m-0"> <div class="col-4 p-0"> <h3 class="title">' + GetOrdinal + ' Increment:</h3> </div><div class="col-4 p-0"> <h3 class="counter increment-first">' + obj.increment_date[i] + '</h3> </div><div class="col-4 p-0"> <h3 class="counter increment-first-amount">' + total_salary + '</h3> </div></div></div>';
                    }

                }
            }
            if (obj.next_increment_date != "" && obj.next_increment_date != '0000-00-00') {
                temp += '<div class="simple-info"> <div class="row m-0"> <div class="col-4 p-0"> <h3 class="title">Next Increment:</h3> </div><div class="col-4 p-0"> <h3 class="counter increment-first">' + obj.next_increment_date + '</h3> </div><div class="col-4 p-0"> <h3 class="counter increment-first-amount">0.00</h3> </div></div></div>';
            }
            $('.increment-list').html(temp);
            /* console.log(obj);
            $('.increment-first').text("");
            $('.increment-second').text("");
            if(obj.employee_increment_deatils[0]){
                $('.increment-first').text(obj.employee_increment_deatils[0]);
            }
            if(obj.employee_increment_deatils[1]){
                $('.increment-second').text(obj.employee_increment_deatils[1]);
            }
            if(obj.employee_increment_deatils[2]){
                $('.increment-third').text(obj.employee_increment_deatils[2]);
            } */


        },
    });
}
jQuery(document).ready(function($) {
    employee_increment_data();
    employeeWorkUpdates();
    $('.preloader-2').attr('style', 'display:block !important;');
    employee_report();
    $(".select_month_details").show();
    var id = $("#employee_id").val();
    var month = $("#attendance_month").val();
    var year = $("#attendance_year").val();
    var data = { 'id': id, 'month': month, 'year': year };
    var base_url = $("#js_data").data('base-url');
    var table = $('#example').DataTable({
        "lengthMenu": [
            [10, 30, 50, 100],
            [10, 30, 50, 100]
        ],
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ Entries",
            },
        "pageLength": 50,
        "ajax": {
            "url": base_url + "/reports/employee_data_new",
            "dataType": "json",
            "type": "POST",
            "data": function(d) {
                d.id = $('#employee_id').val();
                d.month = $('#attendance_month').val();
                d.year = $('#attendance_year').val();
            },
        },
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

        ],
        "fixedHeader": true,

    });
    $('#example').on('draw.dt', function() {
        $.each($('#example tr'), function() {
            if ($(this).find('td:eq( 2 )').text() == "Holiday") {
                $(this).closest('tr').addClass('official-leave-color');
            }
            if ($(this).find('td:eq( 2 )').text() == "Sunday" || $(this).find('td:eq( 2 )').text() == "Saturday") {
                $(this).closest('tr').addClass('sunday-leave-color');
            }
            if ($(this).find('td:eq( 2 )').text() == "Absent Leave") {
                $(this).closest('tr').addClass('absent-leave-color');
            }
            if ($(this).find('td:eq( 2 )').text() == "Half Day") {
                $(this).closest('tr').addClass('halfday-leave-color');
            }
            if ($(this).find('td:eq( 2 )').text() == "Unapprove Leave") {
                $(this).closest('tr').addClass('unapprove-leave-color');
            }
            if ($(this).find('td:eq( 2 )').text() == "Sick Leave") {
                $(this).closest('tr').addClass('sick-leave-color');
            }
            if ($(this).find('td:eq( 2 )').text() == "Paid Leave") {
                $(this).closest('tr').addClass('paid-leave-color');
            }
        });
        $('.preloader-2').attr('style', 'display:none !important;');
    });

    function employee_report() {
        $('.preloader-2').attr('style', 'display:block !important;');
        var base_url = $("#js_data").data('base-url');
        var bonus_month = $('#bonus_month').val();
        var bonus_year = $('#bonus_year').val();
        var employee_id = $('#employee_id').val();
        var data = {
            "bonus_month": bonus_month,
            "bonus_year": bonus_year,
            "employee_id": employee_id,
        }
        $('.report_preloader1').show();
        $.ajax({
            url: base_url + "reports/employee_report1",
            type: "post",
            data: data,
            success: function(response) {
                var data = JSON.parse(response);
                console.log(data.total_time);
                table.clear();
                table.ajax.reload();
                $('.employee_id1').val(data.employee_deatils[0].id);
                $('.name').text(data.employee_deatils[0].fname + " " + data.employee_deatils[0].lname);
                $('.joining_date').text(data.employee_deatils[0].joining_date);
                $('.employed_status').text(data.employee_deatils[0].employee_status);
                $('.employed_date').text((data.employee_deatils[0].employed_date));
                $('.basic-salary').text(data.employee_deatils[0].salary);
                $('.paid_leave').text(data.leave_count.paid_leave);
                $('.sick_leave').text(data.leave_count.sick_leave);
                $('.remaing_paid_leave').text(data.leave_count.remaing_paid_leave);
                $('.remaing_sick_leave').text(data.leave_count.remaing_sick_leave);
                $('.working_days').text(data.result.working_day);
                $('.present_days').text(data.result.present_day);
                $('.total_leaves').text(data.result.total_leaves);
                $('.leaves').text(data.result.leaves);
                $('.approved_leaves').text(data.result.approved_leaves);
                $('.unapproved_leave').text(data.result.unapproved_leave);
                $('.paid_leaves').text(data.result.paid_leaves);
                $('.sick_leaves').text(data.result.sick_leaves);
                $('.prof_tax').text(data.result.prof_tax);
                $('.basic_salary').text(data.result.basic_salary);
                $('.deposit').text(data.result.deposit);
                $('.bonus').text(data.result.bonus);
                $('.leave_deduction').text(data.result.leave_deduction);
                $('.net_salary').text(data.result.net_salary);
                $(".plus-time-count1").text(data.total_time.plus_time);
                $(".minus-time-count1").text(data.total_time.minus_time);
                if (data.total_time.time_status == "plus") {
                    var t = '<span class="plus_time plus-time-count plus-time-count">' + data.total_time.total_time + '</span>';
                } else {
                    var t = '<span class="plus_time plus-time-count minus-time-count">' + data.total_time.total_time + '</span>';
                }
                $(".total_time1").html(t);
                $(".report_preloader1").hide();
                $('.preloader-2').attr('style', 'display:none !important;');
                attendance_search();


            },
        });
    }
    // $('#salary_month_search').click(function(){
    //  employee_report();
    //  return false;
    // });
    $('#employee_id').change(function() {
        employee_report();
        employee_increment_data();
        employeeWorkUpdates();
        return false;
    });
    $('#employeeStatus').change(function (){
        if($('#employeeStatus').val() == 'Active'){
            $('#employee_id option').prop('selected',false);
            $('#employee_id option.active').show();
            $('#employee_id option.active:eq(0)').prop('selected',true);
            $('#employee_id option.deactive').hide();
            $('#employee_id option.disabled').hide();
        }else if($('#employeeStatus').val() == 'Deactive'){
            $('#employee_id option.disabled').hide();
            $('#employee_id option').prop('selected',false);
            $('#employee_id option.active').hide();
            $('#employee_id option.deactive:eq(0)').prop('selected',true);
            $('#employee_id option.deactive').show();
        }else{
            $('#employee_id option.disabled').show();
            $('#employee_id option.active').show();
            $('#employee_id option.deactive').show();
        }
        if($('#employeeStatus').val() == 'Deactive' || $('#employeeStatus').val() == 'Active'){
            employee_report();
            employee_increment_data();
        }
        employeeWorkUpdates();
        return false;
    });
    $('#attendance_month').change(function() {
        attendance_search();
    });
    $('#attendance_year').change(function() {
        attendance_search();
    });

    function attendance_search() {
        $('.preloader-2').attr('style', 'display:block !important;');
        var base_url = $("#js_data").data('base-url');
        var data = { 'id': $("#employee_id").val(), 'month': $("#attendance_month").val(), 'year': $("#attendance_year").val() };
        $.ajax({
            url: base_url + "/reports/total_employee_attendance",
            type: "post",
            data: data,
            success: function(response) {
                table.clear();
                table.ajax.reload();
                var obj = JSON.parse(response);
                console.log(obj);
                $(".plus-time-count1").text(obj.plus_time);
                $(".minus-time-count1").text(obj.minus_time);
                if (obj.time_status == "plus") {
                    var t = '<span class="plus_time plus-time-count plus-time-count">' + obj.total_time + '</span>';
                } else {
                    var t = '<span class="plus_time plus-time-count minus-time-count">' + obj.total_time + '</span>';
                }
                $(".total_time1").html(t);
                $('.preloader-2').attr('style', 'display:none !important;');
            },
        });

    }
    $('#salary_month').change(function() {
        salary_search();
    });
    $('#salary_year').change(function() {
        salary_search();
    });

    function salary_search() {

        var id = $("#employee_id").val();
        var month = $("#salary_month").val();
        var year = $("#salary_year").val();
        var base_url = $("#js_data").data('base-url');
        var data = { 'id': id, 'month': month, 'year': year };
        if (month == "all" || year == "all") {
            $('.all_salary_view').html('<div class="preloader all_report_preloader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /></svg></div>');
            var monthNames = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

            $.ajax({
                url: base_url + "/reports/all_salary_details",
                type: "post",
                data: data,
                success: function(response) {

                    var obj = JSON.parse(response);
                    var t = "";
                    for (i = 0; i < obj.length; i++) {
                        t += '<div class="col-lg-6 col-12 simple-info-wrap"><h2>' + monthNames[obj[i].month_name] + '-' + obj[i].year + '</h2>';
                        t += '<div class="simple-info"><div class="row m-0"><div class="col-6 p-0"><h3 class="title">Working Days:</h3></div><div class="col-6 p-0 working_days"><h3 class="name">' + obj[i].working_day + '</h3></div></div></div>';
                        t += '<div class="simple-info"><div class="row m-0"><div class="col-6 p-0"><h3 class="title">Present Days:</h3></div><div class="col-6 p-0 working_days"><h3 class="name">' + obj[i].effective_day + '</h3></div></div></div>';
                        t += '<div class="simple-info"><div class="row m-0"><div class="col-6 p-0"><h3 class="title">Total Leaves:</h3></div><div class="col-6 p-0 working_days"><h3 class="name">' + obj[i].total_leaves + '</h3></div></div></div>';
                        t += '<div class="simple-info"><div class="row m-0"><div class="col-6 p-0"><h3 class="title">Paid Leaves:</h3></div><div class="col-6 p-0 working_days"><h3 class="name">' + obj[i].paid_leave + '</h3></div></div></div>';
                        t += '<div class="simple-info"><div class="row m-0"><div class="col-6 p-0"><h3 class="title">Sick Leaves:</h3></div><div class="col-6 p-0 working_days"><h3 class="name">' + obj[i].sick_leave + '</h3></div></div></div>';
                        t += '<div class="simple-info"><div class="row m-0"><div class="col-6 p-0"><h3 class="title">Prof Tax:</h3></div><div class="col-6 p-0 working_days"><h3 class="name">' + obj[i].prof_tax + '</h3></div></div></div>';
                        t += '<div class="simple-info"><div class="row m-0"><div class="col-6 p-0"><h3 class="title">Basic Salary:</h3></div><div class="col-6 p-0 working_days"><h3 class="name">' + obj[i].basic_salary + '</h3></div></div></div>';
                        t += '<div class="simple-info"><div class="row m-0"><div class="col-6 p-0"><h3 class="title">Deposit:</h3></div><div class="col-6 p-0 working_days"><h3 class="name">' + obj[i].amount_deduction + '</h3></div></div></div>';
                        t += '<div class="simple-info"><div class="row m-0"><div class="col-6 p-0"><h3 class="title">Bonus:</h3></div><div class="col-6 p-0 working_days"><h3 class="name">' + obj[i].bonus + '</h3></div></div></div>';
                        t += '<div class="simple-info"><div class="row m-0"><div class="col-6 p-0"><h3 class="title">Leave Deduction:</h3></div><div class="col-6 p-0 working_days"><h3 class="name">' + obj[i].deduction + '</h3></div></div></div>';
                        t += '<div class="simple-info"><div class="row m-0"><div class="col-6 p-0"><h3 class="title">Net Salary:</h3></div><div class="col-6 p-0 working_days"><h3 class="name">' + obj[i].net_salary + '</h3></div></div></div>';
                        t += "</div>";
                    }
                    $(".all_salary_view").html(t);
                    $('.all_report_preloader').css('display', 'none');
                    $(".select_month_details").hide();
                },
            });
        } else {
            $('.report_preloader').css('display', 'block');
            $(".select_month_details").show();
            $(".all_salary_view").html("");
            $.ajax({
                url: base_url + "/reports/employee_data",
                type: "post",
                data: data,
                success: function(response) {
                    var obj = JSON.parse(response);
                    $(".employee_name").text(obj.name);
                    $(".month_name").text(obj.month_name);
                    $(".working_days").text(obj.working_day);
                    $(".present_days").text(obj.present_day);
                    $(".total_leaves").text(obj.total_leaves);
                    $('.leaves').text(obj.leaves);
                    $('.approved_leaves').text(obj.approved_leaves);
                    $('.unapproved_leave').text(obj.unapproved_leave);
                    $(".paid_leaves").text(obj.paid_leaves);
                    $(".sick_leaves").text(obj.sick_leaves);
                    $(".prof_tax").text(obj.prof_tax);
                    $(".deposit").text(obj.deposit);
                    $(".bonus").text(obj.bonus);
                    $(".basic_salary").text(obj.basic_salary);
                    $(".leave_deduction").text(obj.leave_deduction);
                    $(".net_salary").text(obj.net_salary);
                    $('.report_preloader').css('display', 'none');
                },
            });
        }


    }

});