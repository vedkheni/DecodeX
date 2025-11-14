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


//  function format(row_data, id, date) {
//     var row = id;
//     var base_url = $("#js_data").data('base-url');
//     var role = $("#js_data").data('role');
//     var btn = '';
//     if (role == 'admin') {
//         btn = '<div> <a data-id="' + date + '" data-date="' + date + '"  class="edit-employee-attendances btn btn-danger waves-effect waves-light" href="' + base_url + 'employee/employee_attendance/' + id + '/' + date + '">Edit</a> <a data-id="' + id + '" data-date="' + date + '"  class="delete-employee-attendances btn btn-danger waves-effect waves-light">Delete</a></div>';
//     }
//     return '<div><p><strong>Date :</strong>' + row_data[1] + ' </p><p><strong>Attendance :</strong>' + row_data[2] + ' </p><p><strong>In :</strong>' + row_data[3] + ' </p><p><strong>Out :</strong>' + row_data[4] + ' </p><p><strong>In :</strong> ' + row_data[5] + '</p><p><strong>Out :</strong>' + row_data[6] + ' </p><p><strong>Total :</strong> ' + row_data[7] + '</p></div>' + btn;
// }
var table = '';

function attendance_search() {
    $('.preloader-2').attr('style', 'display:block !important;');
    var base_url = $("#js_data").data('base-url');
    var data = { 'id': $("#employee").val(), 'month': $("#month").val(), 'year': $("#year").val() };
    $.ajax({
        url: base_url + "employee/total_employee_attendance",
        type: "post",
        data: data,
        success: function (response) {

            var obj = JSON.parse(response);
            // console.log(obj);
            var html = '';

            // html += '<div class="col-lg-4 col-12"><div class="analytics-info"><h3 class="title">Plus Time</h3><h3><span class="plus_time plus-time-count plus-time-count1">'+obj.total_time.plus_time+'</span></h3></div></div>'
            // html += '<div class="col-lg-4 col-12"><div class="analytics-info"><h3 class="title">Minus Time:</h3><h3><span class="minus_time minus-time-count minus-time-count1">'+obj.total_time.minus_time+'</span></h3></div></div>'
            if (obj.total_time.time_status == 'plus') {
                //html += '<div class="col-lg-4 col-12"><div class="analytics-info"><h3 class="title">Total Time:</h3><h3 class="total_time1"><span class="plus_time plus-time-count plus-time-count1">'+obj.total_time.total_time+'</span></h3></div></div>'
                // html += '<span data-plus-time="" class=" plus_time plus-time-count">'+obj.total_time.total_time+'</span>';
                html += '<span class="time-box time-plus " id="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' + obj.total_time.total_time + '</span>';
            } else {
                //html += '<div class="col-lg-4 col-12"><div class="analytics-info"><h3 class="title">Total Time:</h3><h3 class="total_time1"><span class="minus_time minus-time-count minus-time-count1">'+obj.total_time.total_time+'</span></h3></div></div>'
                // html += '<span data-plus-time="" class="minus_time minus-time-count">'+obj.total_time.total_time+'</span>';
                html += '<span class="time-box time-minus " id="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;' + obj.total_time.total_time + '</span>';
            }
            $('#total_time1').html(html);
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
            $(".tmp_name").text(obj.emp_detail[0].fname + ' ' + obj.emp_detail[0].lname);
            $(".tmp_name").data('emp_id', obj.emp_detail[0].id);
            $(".edit-employee-attendances").data('id', obj.emp_detail[0].id);
            $('.h5-emp-name').text('Employee : ' + obj.emp_detail[0].fname + ' ' + obj.emp_detail[0].lname);
            table.clear();
            table.ajax.reload();
            $('.preloader-2').attr('style', 'display:none !important;');
        },
    });
}
jQuery(document).ready(function ($) {

    // var table = $('#example').DataTable({
    // 			"lengthMenu": [ [10, 31, 50, 100], [10, 31, 50, 100] ],
    //                "pageLength": 31,
    // 	}); 
    // 	table.order( [ 0, 'asc' ] ).draw();
    $('.preloader-2').attr('style', 'display:block !important;');
    // var id = $("#employee").val();
    // var month = $("#month").val();
    // var year = $("#year").val();
    // var data = { 'id': id, 'month': month, 'year': year };
    var base_url = $("#js_data").data('base-url');
    table = $('#example').DataTable({
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ Entries",
            },
        "lengthMenu": [[5, 10, 15, 20, 25, 31], [5, 10, 15, 20, 25, 31]],
        "pageLength": 31,
        "ajax": {
            "url": base_url + "employee/employee_data_new1",
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
            { "data": "#" },
            // { "data": "id" },
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
        "columnDefs": [{
            "targets": [0, 9],
            "orderable": false,
        }],
    });
    table.order([1, 'asc']).draw();

    attendance_search();
    $('#example').on('draw.dt', function () {
        $('.preloader-2').attr('style', 'display:block !important;');
        var td_1 = 2;
        var td_2 = 3;
        var td_3 = 4;
        var td_4 = 5;
        var td_5 = 6;
        var td_6 = 9;
        $.each($('#example tr'), function () {
            $.each($(this).find('td span'), function () {
                if ($(this).text() == '00:00') {
                    $(this).addClass('text-danger').closest('td').addClass('text-muted');
                }
            });

            // if ($(this).find('td:eq( ' + td_1 + ' )').text() == "Holiday") {
            if ($(this).find('td:eq( ' + td_1 + ' ) strong').hasClass('holiday')) {
                $(this).closest('tr').addClass('official-leave-color');
                // $(this).find('td:eq( '+td_6+' ) button').prop('disabled', true);
                $(this).find('td:eq( ' + td_1 + ' )').attr('colspan','7');
                $(this).find('td:eq(4),td:eq(5),td:eq(6),td:eq(7),td:eq(8),td:eq(3) ').remove();
                $(this).find('td .edit-employee-attendances').attr('disabled','disabled').removeClass('edit-employee-attendances');
                $(this).find('td:eq( ' + td_6 + ' ) button').attr('data-leave', 'This is official holiday');
            }
            if ($(this).find('td:eq( ' + td_1 + ' )').text() == "Sunday") {
                $(this).closest('tr').addClass('sunday-leave-color');
                $(this).find('td .edit-employee-attendances').attr('disabled','disabled').removeClass('edit-employee-attendances');
                // $(this).find('td:eq( '+td_6+' ) button').prop('disabled', true);
                //  $(this).find('td:eq( 0 ) input').addClass('d-none');
                //  $(this).find('td:eq( 0 ) input').remove();
                $(this).find('td:eq( ' + td_6 + ' ) button').attr('data-leave', 'Sunday is official holiday.');
            }
            if ($(this).find('td:eq( ' + td_1 + ' )').text() == "Saturday") {
                $(this).closest('tr').addClass('sunday-leave-color');
                $(this).find('td .edit-employee-attendances').attr('disabled','disabled').removeClass('edit-employee-attendances');
                //  $(this).find('td:eq( 0 ) input').addClass('d-none');
                //  $(this).find('td:eq( 0 ) input').remove();
                $(this).find('td:eq( ' + td_6 + ' ) button').attr('data-leave', 'Saturday is official holiday.');
            }
            if ($(this).find('td:eq( ' + td_1 + ' )').text() == "Absent Leave") {
                $(this).closest('tr').addClass('absent-leave-color');
                $(this).find('td .edit-employee-attendances').attr('disabled','disabled').removeClass('edit-employee-attendances');
                // $(this).find('td:eq( '+td_6+' ) button').prop('disabled', true);
                $(this).find('td:eq( ' + td_6 + ' ) button').attr('data-leave', 'This is absent leave');
            }
            if ($(this).find('td:eq( ' + td_1 + ' )').text() == "Half Day") {
                $(this).closest('tr').addClass('halfday-leave-color');
            }
            if ($(this).find('td:eq( ' + td_1 + ' ) span.attendance_type').text() == "Half Day") {
                $(this).closest('tr').addClass('halfday-leave-color');
            }
            if ($(this).find('td:eq( ' + td_1 + ' )').text() == "Unapprove leave") {
                $(this).closest('tr').addClass('unapprove-leave-color');
            }
            if ($(this).find('td:eq( ' + td_1 + ' )').text() == "Sick leave") {
                $(this).find('td .edit-employee-attendances').attr('disabled','disabled').removeClass('edit-employee-attendances');
                $(this).closest('tr').addClass('sick-leave-color');
            }

            // if($(this).find('td:eq( ' + td_1 + ' )').text() == "Marriage Leave") var $className ='marriage-leave-color';
            // if($(this).find('td:eq( ' + td_1 + ' )').text() == "Festival Leave") var $className ='festival-leave-color';
            // if($(this).find('td:eq( ' + td_1 + ' )').text() == "Engagement Leave") var $className ='engagement-leave-color';
            // if($(this).find('td:eq( ' + td_1 + ' )').text() == "Maternity Leave") var $className ='maternity-leave-color';
            // if($(this).find('td:eq( ' + td_1 + ' )').text() == "Family Events Leave") var $className ='familyevents-leave-color';
            // if($(this).find('td:eq( ' + td_1 + ' )').text() == "Bereavement Leave") var $className ='bereavement-leave-color';
            // if($(this).find('td:eq( ' + td_1 + ' )').text() == "General Leave") var $className ='general-leave-color';
            // $(this).closest('tr').addClass($className);
            
            if($leaveType.includes(($(this).find('td:eq( ' + td_1 + ' )').text()).replace(' Leave',''))){
                $(this).closest('tr').addClass('absent-leave-color');
                $(this).find('td .edit-employee-attendances').attr('disabled','disabled').removeClass('edit-employee-attendances');
            } 
                

            if ($(this).find('td:eq( ' + td_1 + ' )').text() == "Paid leave") {
                $(this).closest('tr').addClass('paid-leave-color');
                // $(this).find('td:eq( '+td_6+' ) button').prop('disabled', true);
                $(this).find('td:eq( ' + td_6 + ' ) button').attr('data-leave', 'Paid leave');
            }
        });
        $.each($('#example tr'), function () {
            $(this).find('td:eq( ' + td_1 + ' )').addClass('td_in_time field-edit');
            $(this).find('td:eq( ' + td_2 + ' )').addClass('td_in_time field-edit');
            $(this).find('td:eq( ' + td_3 + ' )').addClass('td_in_time field-edit');
            $(this).find('td:eq( ' + td_4 + ' )').addClass('td_in_time field-edit');
            $(this).find('td:eq( ' + td_5 + ' )').addClass('td_in_time field-edit');

            var td2 = $(this).find('td:eq( ' + td_1 + ' ) span.field-edit').html();
            var td3 = $(this).find('td:eq( ' + td_2 + ' ) span.field-edit').html();
            var td4 = $(this).find('td:eq( ' + td_3 + ' ) span.field-edit').html();
            var td5 = $(this).find('td:eq( ' + td_4 + ' ) span.field-edit').html();
            var td6 = $(this).find('td:eq( ' + td_5 + ' ) span.field-edit').html();
            $.each($(this).find('td.td_in_time'), function () {
                var satuts = $(this).find('span.field-edit').attr('data-popup-status');
                $(this).attr('data-popup-status', satuts);
                var type = $(this).find('span.field-edit').attr('data-type');
                $(this).attr('data-type', type);
                var attendance_date = $(this).find('span.field-edit').attr('data-attendance-date');
                $(this).attr('data-attendance-date', attendance_date);
            });
            $(this).find('td:eq( ' + td_1 + ' ) span.field-edit').remove();
            $(this).find('td:eq( ' + td_2 + ' ) span.field-edit').remove();
            $(this).find('td:eq( ' + td_3 + ' ) span.field-edit').remove();
            $(this).find('td:eq( ' + td_4 + ' ) span.field-edit').remove();
            $(this).find('td:eq( ' + td_5 + ' ) span.field-edit').remove();
            $(this).find('td:eq( ' + td_1 + ' )').html(td2);
            $(this).find('td:eq( ' + td_2 + ' )').html(td3);
            $(this).find('td:eq( ' + td_3 + ' )').html(td4);
            $(this).find('td:eq( ' + td_4 + ' )').html(td5);
            $(this).find('td:eq( ' + td_5 + ' )').html(td6);
        });
        $('.preloader-2').attr('style', 'display:none !important;');
    });
    // new $.fn.dataTable.FixedHeader( table );
    $(document).on('change', '#employee', function () {
        $('.preloader-2').attr('style', 'display:block !important;');
        attendance_search();
        return false;
    });
    $(document).on('change', '#month', function () {
        $('.preloader-2').attr('style', 'display:block !important;');
        attendance_search();
        return false;

    });
    $(document).on('change', '#year', function () {
        $('.preloader-2').attr('style', 'display:block !important;');
        attendance_search();
        return false;
    });
    $(document).on('click', '.emp_reset', function () {
        $('.emp_reset1').click();
        $('.preloader-2').attr('style', 'display:block !important;');
        attendance_search();
        return false;
    });
    
    $(document).on('click', '.add-comment', function () {
        if($(this).prop('checked')){
            $('.leave-commet-box').removeClass('d-none');
        }else{
            $('.leave-commet-box').addClass('d-none');
        }
    });

    $(document).on('click', '.add_leave', function () {
        $('#leave_commet').removeClass('error');
        $('#leave_commet').val('').text('');
        $('.leave-commet-box').addClass('d-none');
        $('.add-comment').prop('checked',false);
        $('input[name=status]').prop('checked',false);
        $('input[name=status]:eq(0)').prop('checked',true);
        $('#leave_status option').prop('selected',false);
        var checkbox = $('.attendances_check:checked');
        if (checkbox.length > 0) {
            $('.add_leave_modal').click();
            // var emp_name = $('.tmp_name').text();$('.h5-emp-name').text('Employee : '+emp_name);
            var checkbox_value = [];
            $('#date_leave').datepicker().data('datepicker').clear();
            $(checkbox).each(function () {
                checkbox_value.push($(this).val());
                // {minDate: new Date()}
                $('#date_leave').datepicker().data('datepicker').selectDate(new Date($(this).val()));
            });
            var leave_date = checkbox_value.toString();
            // $('#date_leave').val(leave_date);
            $('#date_leave').attr('value', leave_date);
            $('#emp_id').val($(".tmp_name").data('emp_id'));
        } else {
            alert('Select atleast one records For Delete');
        }
        return false;
    });

    function checkbox_check() {
        var checkbox = $('.attendances_check:checked');
        if (checkbox.length > 0) {
            $('.add_leave').show();
            $('#delete_leave').show();
        } else {
            $('.add_leave').hide();
            $('#delete_leave').hide();
        }
    }
    $('#example').on('draw.dt', function () {
        checkbox_check();
        $('.attendances_check').change(function () {
            checkbox_check();
        });
    });
    $('#select_All_checkbox').change(function () {
        checkbox_check();
    });
    $('#delete_leave').click(function () {
        if (confirm("Are you sure want to delete?")) {
            var checkbox = $('.attendances_check:checked');
            if (checkbox.length > 0) {
                $('.preloader-2').attr('style', 'display:block !important;');
                var checkbox_value = [];
                $(checkbox).each(function () {
                    checkbox_value.push($(this).val());
                });
                var leave_date = checkbox_value.toString();
                var base_url = $("#js_data").data('base-url');
                var id = $(".tmp_name").data('emp_id');
                var data = { 'employee_id': id, 'leave_date': leave_date };
                $.ajax({
                    url: base_url + "employee/delete_employee_all_leave",
                    type: "post",
                    data: data,
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.success == 'success') {
                            $('.msg-container').html('<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Leave deleted successFully.</p></div></div></div>');
                            $('.msg-container .msg-box').attr('style', 'display:block');
                        } else {
                            $('.msg-container').html(data.success);
                            $('.msg-container .msg-box').attr('style', 'display:block');
                        }
                        table.clear();
                        table.ajax.reload();
                        setTimeout(function () {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                        checkbox_check();
                    },
                });
            } else {
                alert('Select atleast one records For Delete');
            }
        }
    });
    $("#add_leave").click(function (e) {
        e.preventDefault();
        var leave_date = $("#date_leave").val();
        var leave_commet = $("#leave_commet").val();
        var status_approve = $("#status_approve").val();
        var status_reject = $("#status_reject").val();
        var id = $('#emp_id').val();
        var leave_status = $('#leave_status option:selected').val();
        var status = $('input[name=status]:checked').val();
        var $num = 0;
        //leave_status_error
        if (!leave_date) {
            $("#date_leave").addClass('error');
            $num++;
        } else {
            $("#date_leave").removeClass('error');
        }

        if($('.add-comment').prop('checked')){
            if (!leave_commet) {
                $("#leave_commet").addClass('error');
                $num++;
            } else {
                $("#leave_commet").removeClass('error');
            }
        }

        if (!id) {
            $("#emp_id").addClass('error');
            $num++;
        } else {
            $("#emp_id").removeClass('error');
        }
        // 
        if (!leave_status) {
            $("#leave_status_error").addClass('error');
            $(".leave_status_for_error").html('Please Select Leave Status');
            $num++;
        } else {
            $("#leave_status_error").removeClass('error');
            $(".leave_status_for_error").html('');
        }
        if (!status) {
            $("#status_error").addClass('error');
            $(".status_for_error").html('Please Select Status');
            $num++;
        } else {
            $("#status_error").removeClass('error');
            $(".status_for_error").html('');
        }

        if ($num != 0) {
            return false;
        } else {
            $('.preloader-2').attr('style', 'display:block !important;');
            $("#leave_date").removeClass('error');
            $("#leave_commet").removeClass('error');
            var base_url = $("#js_data").data('base-url');
            var num = 0;
            if($('.add-comment').prop('checked')){
                if (maxlength(leave_commet, 100)) { $("#leave_commet").removeClass('error'); } else { $("#leave_commet").addClass('error'); num++; }
                var add_comment = "true";
            }else{
                var add_comment = "false";
            }
            if (num == 0) {
                var data = {
                    'type': 'ajax',
                    'employee_select': id,
                    'employee_id': id,
                    'leave_date': leave_date,
                    'leave_status': leave_status,
                    'leave_commet': leave_commet,
                    'add_comment': add_comment,
                    'status': status
                };
                $.ajax({
                    url: base_url + "leave_request/insert_data",
                    type: "post",
                    data: data,
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.error == '') {
                            $('.msg-container').html(data.error);
                            $('.msg-container .msg-box').attr('style', 'display:block');
                            $('.preloader-2').attr('style', 'display:none !important;');
                        } else {
                            $('#date_leave').val('');
                            $('#leave_commet').val('');
                            $('.add-comment').prop('checked',false);
                            $('#date_leave').datepicker().data('datepicker').clear();
                            $('.msg-container').html(data.error);
                            $('.msg-container .msg-box').attr('style', 'display:block');
                            $('.js_error').html(data.success);
                            $('.close').click();
                            table.clear();
                            table.ajax.reload();
                        }
                        checkbox_check();
                        setTimeout(function () {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                    },
                });
                return false;
            } else {
                return false;
            }
            // return true;
        }
    });
    $('#select_All_checkbox').click(function (event) {
        if ($(this).val() == 'All_select') {
            if ($(this).is(":checked")) {
                $('.attendances_check').each(function () {
                    $(this).prop("checked", true);
                });
            } else {
                $('.attendances_check').each(function () {
                    $(this).prop("checked", false);
                });
            }
        }
    });

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
    $('body').click(function (event) {
        if (!$(this).parents('.field-box')) {
            $('.field-box').css('display', 'none');
        }
        /* if (!$(this.target).is('.field-box')) {
             $('.field-box').css('display', 'none');
         } */
    });
    $(document).on('click', '.field-edit span', function () {
        var popup_status = $(this).parent().data('popup-status');
        if (popup_status != "") {
            if (popup_status == "active") {
                $('.field-edit').removeClass("open");
                $(this).parents('.field-box').show();
                $('.field-box').css('display', 'none');
                $(this).parent().find('.field-box').css('display', 'block');
            }
        }
    });

    $('#example').on('draw.dt', function () {
        $('.close_popup').on('click', function (e) {
            e.stopPropagation();
            // $(this).parent('.field-box').hide();
            $('.field-box').css('display', 'none');
            //$(this).find('.field-box').css('display','none');
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
                        // console.log("in1");
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
                        // console.log("out1");
                    }
                    //return false;
                    if (error == '0') {
                        // console.log("update time");
                        var data = { 'id': id, 'type': type, 'attendance_date': attendance_date, 'time': time };
                        $.ajax({
                            url: base_url + "/employee/add_time",
                            type: "post",
                            data: data,
                            success: function (response) {
                                // console.log(response);
                                if (response != "") {
                                    attendance_search();
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
    });
    $(document).on('click', '.delete-employee-attendances', function () {

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

                url: "../delete_employee_attendance",

                type: "post",

                data: data,

                success: function (response) {
                    location.reload();
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
            return true;
        }
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

                    $('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>End date should not be less than start date </p></div></div></div>');
                    setTimeout(function () {
                        $('.msg-container .msg-box').attr('style', 'display:none');
                    }, 6000);
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
});
$(".submit_form").click(function () {
    var attendance_type = $("#attendance_type").val();
    var select_error = true;
    if (attendance_type == "--Select Day--" || attendance_type == null) {

        $("#attendance_type").addClass('error');
        select_error = true;
    } else {
        $("#attendance_type").removeClass('error');
        select_error = false;


    }
    if (select_error == false) {
        $("#edit_employee_attendance-form").submit();
    }
});
// jQuery(document).ready(function ($) {
var base_url = $("#js_data").data('base-url');
// date_change('X');
function remove_c() {
    $("#employee_in").removeClass('error');
    $("#employee_in1").removeClass('error');
    $("#employee_out").removeClass('error');
    $("#employee_out1").removeClass('error');
}
$('#edit_employee_attendance-form').submit(function (e) {
    var employee_in = $("#employee_in").val();
    var employee_out = $("#employee_out").val();
    var employee_in1 = $("#employee_in1").val();
    var employee_out1 = $("#employee_out1").val();
    var attendance_type = $("#attendance_type").val();
    var daily_work = $("#daily_work").val();

    if (!employee_in && !employee_out && !employee_in1 && !employee_out1 && !attendance_type) {
        var in_time = $("#in_time").val();
        var out_time = $("#out_time").val();
        var in_time1 = $("#in_time1").val();
        var out_time1 = $("#out_time1").val();
        var in_out_time = $("#in_out_time").val();
        var daily_work = $("#daily_work").val();
        $("#attendance_type").removeClass('error');
        remove_c();
        submit_ajax_form(attendance_type, in_time, out_time, in_time1, out_time1, employee_in, employee_out, employee_in1, employee_out1, in_out_time, daily_work);
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
            var daily_work = $("#daily_work").val();
            if (out_time != "") {
                //1,2
                if (in_time != "" && out_time != "") {
                    // console.log("if1");
                    var t = in_out_time + " " + in_time;
                    var t1 = in_out_time + " " + out_time;
                    //console.log(t1+""+t);
                    var dtStart = new Date(t);
                    var dtEnd = new Date(t1);
                    var difference_in_milliseconds = dtEnd - dtStart;
                    if (difference_in_milliseconds < 0) {
                        $('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>OUT time must be greater than IN time</p></div></div></div>');
                        // $(".msg-container").html('');
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        setTimeout(function () {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                        $("#employee_in").addClass('error');
                        return false;
                    } else {
                        $('.time_msg').text("");
                        $("#employee_in").removeClass('error');
                        if (in_time1 != "") {
                            //2,3
                            if (in_time != "" && out_time != "" && in_time1 != "") {
                                // console.log("if2");
                                var t2 = in_out_time + " " + out_time;
                                var t3 = in_out_time + " " + in_time1;
                                //console.log(t1+""+t);
                                var dtStart1 = new Date(t2);
                                var dtEnd1 = new Date(t3);
                                var difference_in_milliseconds1 = dtEnd1 - dtStart1;
                                if (difference_in_milliseconds1 < 0) {
                                    $("#employee_in1").addClass('error');
                                    $('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>IN time must be greater than OUT time</p></div></div></div>');
                                    // $(".msg-container").html('');
                                    $('.msg-container .msg-box').attr('style', 'display:block');
                                    setTimeout(function () {
                                        $('.msg-container .msg-box').attr('style', 'display:none');
                                    }, 6000);
                                    return false;
                                } else {
                                    $('.time_msg').text("");
                                    $("#employee_in1").removeClass('error');

                                    //3,4

                                    if (out_time1 != "") {
                                        if (in_time != "" && out_time != "" && in_time1 != "" && out_time1 != "") {
                                            // console.log("if3");
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
                                                // $(".msg-container").html('');
                                                setTimeout(function () {
                                                    $('.msg-container .msg-box').attr('style', 'display:none');
                                                }, 6000);
                                                return false;
                                            } else {
                                                $("#employee_out1").removeClass('error');
                                                $('.time_msg').text("");
                                                submit_ajax_form(attendance_type, in_time, out_time, in_time1, out_time1, employee_in, employee_out, employee_in1, employee_out1, in_out_time, daily_work);
                                                // return true;
                                                return false;
                                            }
                                        } else {
                                            // console.log("else3");
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
                                        submit_ajax_form(attendance_type, in_time, out_time, in_time1, out_time1, employee_in, employee_out, employee_in1, employee_out1, in_out_time, daily_work);
                                        // return true;
                                        return false;

                                    }
                                }
                            } else {
                                // console.log("else2");
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
                            // console.log("if43");
                            if (in_time != "" && out_time != "" && out_time1 != "") {

                                if (!employee_in1) {
                                    $("#employee_in1").addClass('error');
                                } else {
                                    $("#employee_in1").removeClass('error');
                                }
                                return false;
                            } else {
                                remove_c();
                                submit_ajax_form(attendance_type, in_time, out_time, in_time1, out_time1, employee_in, employee_out, employee_in1, employee_out1, in_out_time, daily_work);
                                // return true;
                                return false;
                            }
                        }
                    }
                } else {
                    // console.log("else");
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
                // console.log("if4");
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
                            // console.log("if4");
                            submit_ajax_form(attendance_type, in_time, out_time, in_time1, out_time1, employee_in, employee_out, employee_in1, employee_out1, in_out_time, daily_work);
                            // return true;
                            return false;
                        }
                    }
                }
                // console.log("if4");
                //  return true;
            }
            // return false;
            //end
        }
    }
    // setTimeout(function () {
    //     $('.msg-container .msg-box').attr('style', 'display:none');
    // }, 6000);
});
/*ajax*/
function submit_ajax_form(attendance_type, in_time, out_time, in_time1, out_time1, employee_in, employee_out, employee_in1, employee_out1, in_out_time, daily_work) {
    $('.preloader-2').attr('style', 'display:block !important;');
    $(".msg-container").html('');
    var url = base_url + "/employee/insert_employee_attendance";
    var attendance_date = $('#datepicker').val();
    var emp_id = $('#emp_id1').val();
    var id = $('#id').val();
    var other_date = $('#other_date').val();
    $.ajax({
        type: "post",
        url: url,
        data: { attendance_date, emp_id, id, other_date, attendance_type, in_time, out_time, in_time1, out_time1, employee_in, employee_out, employee_in1, employee_out1, in_out_time, daily_work },
        success: function (data) {
            $(".msg-container").html(data);
            $('.msg-container .msg-box').attr('style', 'display:block');
            table.clear();
            table.ajax.reload();
            date_change('Y');
            attendance_search();
            $('.close').click();
            setTimeout(function () {
                $('.msg-container .msg-box').attr('style', 'display:none');
            }, 6000);
        },
    });
}
$('#example').on('draw.dt', function () {

    $('.edit-employee-attendances').click(function () {
        var leave = $(this).data('leave');
        if (leave == undefined) {
            // var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            var id = $(this).data('id');
            var date = $(this).data('date');
            $('#id').val(id);
            var d = new Date(date);
            var day = d.getDate();
            var month = months[d.getMonth()];
            var year = d.getFullYear();
            if (day < 10) {
                day = "0" + day;
            }
            $('#datepicker').attr('value', day + ' ' + month + ' ' + year);
            $('#in_out_time').attr('value', d.getMonth() + '/' + day + '/' + year);
            $('.modal-sub-title').text('Add Attendance - ' + day + ' ' + month + ', ' + year);


            $(".msg-container").text('');
            // $('#datepicker').attr('value',$.datepicker.dateFormat('dd M yy',new Date(date)));
            date_change('Y');
            date_change('Y');
            $('.time_msg').html('');
        } else {
            $(".msg-container").html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' + leave + '</p></div></div></div>');
            $('.msg-container .msg-box').attr('style', 'display:block');
            setTimeout(function () {
                $('.msg-container .msg-box').attr('style', 'display:none');
            }, 6000);
            return false;
        }
    });
});
/* function fillModel(){
   $('#myModal > .preloader-2').attr('style', 'display: block !important;');
   var date1 = $('#datepicker').val();
   var d = new Date(date1);
   var month = d.getMonth() + 1;
   var day = d.getDate();
   var output = d.getFullYear() + '/' + (month < 10 ? '0' : '') + month + '/' + (day < 10 ? '0' : '') + day;
   var base_url = $("#js_data").data('base-url');
   $.ajax({
       type: "post",
       url: base_url + 'profile/getAttendance',
       data: {datepicker: output },
       success: function(data) {
           var html = ''; 
           var obj = JSON.parse(data);
           $('.preloader.preloader-2').attr('style', 'display: none !important;');
       },
   }); 
} */
function date_change(n) {
    $('.preloader-2').attr('style', 'display:block !important;');
    $.each($('#attendance_type option'), function () {
        if ($(this).val() == '') {
            $(this).prop('selected', true);
        }
    });
    var d = '';
    var date1 = $('#datepicker').val();
    d = new Date(date1);
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
        success: function (response) {
            remove_c();
            $('.time_msg').html('');
            // console.log(response);
            var data = JSON.parse(response);
            $('#daily_work').val('');
            if (data.employee_attendance[0]) {
                if (data.employee_attendance[0].attendance_type == 'full_day') {
                    $.each($('#attendance_type option'), function () {
                        if ($(this).val() == 'full_day') {
                            $(this).prop('selected', true);
                        }
                    });
                } else if (data.employee_attendance[0].attendance_type == 'half_day') {
                    $.each($('#attendance_type option'), function () {
                        if ($(this).val() == 'half_day') {
                            $(this).prop('selected', true);
                        }
                    });
                } else {
                    $.each($('#attendance_type option'), function () {
                        if ($(this).val() == '') {
                            $(this).prop('selected', true);
                        }
                    });
                }
            }
            if (data.get_employee_attendance !== '') {
                var attendance = [];
                $.each(data.get_employee_attendance, function (k, v) {
                    attendance.push(v.id);
                });
            }
            if (data.employee_in !== '') {
                var btn = '<div class="row w-100"><div class="col-6 text-left p-0"><button class="btn sec-btn submit_form">Update</button></div><div class="col-6 text-right p-0"><button onclick="reset_data()" class="btn btn-danger reset_data" type="button">Reset</button>';
                btn += '<button data-id="' + data.id + '" data-date="' + data.get_date + '" class="delete-employee-attendances1 m-l-5 btn btn-danger">Delete</button></div></div>';
                $('#emp_id1').val(attendance.join(", "));
                $('#other_date').val(data.get_date);
                $('#all_btn').html(btn);
            } else {
                var btn = '<div class="row w-100"><div class="col-6 text-left p-0"><button class="btn sec-btn submit_form">Add</button></div><div class="col-6 text-right p-0"><button class="btn btn-danger reset_data" onclick="reset_data()" type="button">Reset</button></div></div>';
                $('#emp_id1').val('');
                $('#other_date').val('');
                $('#all_btn').html(btn);
            }
            if (data.daily_work_list[0]) {
                $('#daily_work').val(data.daily_work_list[0].daily_work);
            }

            $('#employee_in').val(data.employee_in);
            $('#employee_out').val(data.employee_out);
            $('#employee_in1').val(data.employee_in1);
            $('#employee_out1').val(data.employee_out1);
            $('#in_time').val(data.employee_in_hidden);
            $('#out_time').val(data.employee_out_hidden);
            $('#in_time1').val(data.employee_in1_hidden);
            $('#out_time1').val(data.employee_out1_hidden);
            $('#attendance_type').removeClass('error');
            $('.preloader-2').attr('style', 'display:none !important;');

            // window.location.replace(base_url+"/employee_attendance_list/"+id);
        },
    });
}
$(document).on('click', '.delete-employee-attendances1', function () {
    if (confirm("Are you sure want to delete?")) {
        $('.preloader-2').attr('style', 'display:block !important;');
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
            success: function (response) {
                // console.log(response);
                var data = '<div class="msg-box success-box" ><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>' + response + '</p></div></div></div>';
                $(".msg-container").html(data);
                $('.msg-container .msg-box').attr('style', 'display:block');
                table.clear();
                table.ajax.reload();
                $('.preloader-2').attr('style', 'display:none !important;');
                date_change('Y');
                $('.close').click();
                setTimeout(function () {
                    $('.msg-container .msg-box').attr('style', 'display:none');
                }, 6000);
            },
        });
    }
    return false;
});
$('#employee_in').on('change', function () {
    // console.log("change employee_in");
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
$('#employee_out').on('change', function () {
    // console.log("change employee_out");
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
$('#employee_in1').on('change', function () {
    // console.log("change employee_in1");
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
$('#employee_out1').on('change', function () {
    // console.log("change employee_out1");
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
$('#attendance_type').on('change', function () {
    var attendance_type = $(this).val();
    if (attendance_type == "full_day") {
        if ($("#employee_in").val() == "") {
            $("#employee_in").val("09:00");
        }
        if ($("#employee_out").val() == "") {
            $("#employee_out").val("14:00");
        }
        if ($("#employee_in1").val() == "") {
            $("#employee_in1").val("14:45");
        }
        if ($("#employee_out1").val() == "") {
            $("#employee_out1").val("18:30");
        }
    }
    if (attendance_type == "half_day") {
        if ($("#employee_in").val() == "") {
            $("#employee_in").val("09:00");
        }
        if ($("#employee_out").val() == "") {
            $("#employee_out").val("14:00");
        }
        $("#employee_out1").val("");
        $("#employee_in1").val("");
    }
});
 // });