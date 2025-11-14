jQuery(document).ready(function($) {
    var disabledDays = [0, 6];
    if ($('#leave_date').data('role') != 'admin') {
        $('#leave_date').datepicker({
            dateFormat: $('#js_data').data('dateformat'),
            language: 'en',
            minDate: new Date(lastWeekDisplayPadded),
            onRenderCell: function(date, cellType) {
                if (cellType == 'day') {
                    var day = date.getDay(),
                        isDisabled = disabledDays.indexOf(day) != -1;
                    return {
                        disabled: isDisabled
                    }
                }
            },
            onSelect: function (fd, d, picker) {
                var usedPaidLeave = Number($('#usedPaidLeaveCount').data('count'));
                var unusedPaidLeave = Number($('#unusedPaidLeaveCount').data('count'));
                if(unusedPaidLeave <= d.length){
                    $('#usedPaidLeaveCount').text(unusedPaidLeave+usedPaidLeave);
                    $('#unusedPaidLeaveCount').text(0);
                }else{
                    unusedPaidLeave = unusedPaidLeave == undefined?0:unusedPaidLeave;
                    d.length = d.length == undefined?0:d.length;
                    $('#unusedPaidLeaveCount').text(unusedPaidLeave-d.length);
                    $('#usedPaidLeaveCount').text(usedPaidLeave+d.length);
                }
            }
        });
    }else{
        $('#leave_date').datepicker({
            dateFormat: $('#js_data').data('dateformat'),
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
            onSelect: function (fd, d, picker) {
                var usedPaidLeave = Number($('#usedPaidLeaveCount').data('count'));
                var unusedPaidLeave = Number($('#unusedPaidLeaveCount').data('count'));
                if(unusedPaidLeave <= d.length){
                    $('#usedPaidLeaveCount').text(unusedPaidLeave+usedPaidLeave);
                    $('#unusedPaidLeaveCount').text(0);
                }else{
                    unusedPaidLeave = unusedPaidLeave == undefined?0:unusedPaidLeave;
                    d.length = d.length == undefined?0:d.length;
                    $('#unusedPaidLeaveCount').text(unusedPaidLeave-d.length);
                    $('#usedPaidLeaveCount').text(usedPaidLeave+d.length);
                }
            }
        });
    }
    // $('#datatable').dataTable();

    var base_url = $("#js_data").attr("data-base-url");
    var employee_id = $("#js_data").attr("data-employee-id");
    var role = $("#js_data").attr("data-role");
    var employee_id1 = $("#employee_id").val();
    var select_year = $("#select_year").val();
    var select_month = $("#select_month").val();
    // var table =  $('#example').DataTable({
    //         "processing": true,
    //         "serverSide": true,
    //      "rowReorder": {
    //                  "selector": 'td:nth-child(2)'
    //              },
    //      "responsive": true,
    //         "lengthMenu": [ [10, 30, 50, 100], [10, 30, 50, 100] ],
    //         "pageLength": 30,
    //         "ajax":{
    //          "url": base_url+"leave_request/employee_pagination",         
    //          "type": "POST",
    //          "data": function( d ) {
    //       d.employee_id= $("#employee_id").val();
    //       d.select_month= $("#select_month").val();
    //       d.select_year= $("#select_year").val();
    //     },
    //     "dataType": "json",

    //                        },
    //         stateSave: true,               
    //           "columns": [
    //               { "data": "id" },
    //            { "data": "fname" },
    //               { "data": "leave_date" },
    //            { "data": "leave_status" },
    //            { "data": "action" }, 
    //            { "data": "status" }, 

    //            ],
    //             "order": [[ 5, "desc" ]]                   
    // });
    $('.preloader-2').attr('style', 'display:block !important;');
    var table1 = $('#example_admin-pending').DataTable({
        "processing": true,
        "serverSide": true,
        "rowReorder": {
            "selector": 'td:nth-child(2)'
        },
        // "columnDefs": [{ "targets": 2, "visible": false, }],
        "drawCallback": function(settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;
            var groupadmin1 = [];

            api.column(2, { page: 'current' }).data().each(function(group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group active" id="pending_' + i + '"><td colspan="7" class="font-bold blue-text"><span class="icon"></span>' + group + '</td></tr>'
                    );
                    groupadmin1.push('pending_' + i);
                    last = group;
                }
            });
            for (var k = 0; k < groupadmin1.length; k++) {
                // Code added for adding class to sibling elements as "group_<id>"  
                $("#" + groupadmin1[k]).nextUntil("#" + groupadmin1[k + 1]).addClass('group_' + groupadmin1[k]);
                $("#" + groupadmin1[k] + ' td').append(' <span class="float-right border-left pl-3" > ' + $('.group_' + groupadmin1[k]).length + ' Request </span>');
                // Code added for adding Toggle functionality for each group
                var gid = $("#" + groupadmin1[k]).attr("id");
                $(".group_" + gid).show();
                $("#" + groupadmin1[k]).click(function() {
                    $(this).toggleClass("active");
                    var gid = $(this).attr("id");
                    $(".group_" + gid).slideToggle(300);
                });

            }
        },
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ Entries",
            },
        "responsive": true,
        "lengthMenu": [
            [10, 30, 50, 100],
            [10, 30, 50, 100]
        ],
        "pageLength": 30,
        "fixedHeader": true,
        "ajax": {
            "url": base_url + "leave_request/employee_pagination/pending",
            "dataType": "json",
            "type": "POST",
            "data": function(d) {
                d.employee_id = $("#employee_id").val();
                d.select_month = $("#select_month").val();
                d.select_year = $("#select_year").val();
                d.select_leave = $("#select_leave").val();
            },

        },
        stateSave: true,
        "columns": [
            { "data": "#" },
            { "data": "id" },
            { "data": "fname" },
            { "data": "leave_date" },
            // { "data": "comment" }, 
            { "data": "leave_status" },
            { "data": "status" },
            { "data": "action" },

        ],
        "order": [
            [3, "asc"]
        ],
        "columnDefs": [
            { "orderable": false, "targets": [0, 1, 2, 4, 5] }
        ],
    });
    var table2 = $('#example_admin-approved').DataTable({
        "processing": true,
        "serverSide": true,
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ Entries",
            },
        "rowReorder": {
            "selector": 'td:nth-child(2)'
        },
        // "columnDefs": [{ "targets": 2, "visible": false, }],
        "drawCallback": function(settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;
            var groupadmin = [];
            
            api.column(2, { page: 'current' }).data().each(function(group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group active" id="' + i + '"><td colspan="6" class="font-bold blue-text"><span class="icon"></span>' + group + '</td></tr>'
                        );
                        groupadmin.push(i);
                        last = group;
                }
            });
            for (var k = 0; k < groupadmin.length; k++) {
                // Code added for adding class to sibling elements as "group_<id>"  
                $("#" + groupadmin[k]).nextUntil("#" + groupadmin[k + 1]).addClass(' group_' + groupadmin[k]);
                $("#" + groupadmin[k] + ' td').append(' <span class="float-right border-left pl-3" > ' + $('.group_' + groupadmin[k]).length + ' Request </span>');
                // Code added for adding Toggle functionality for each group
                var gid = $("#" + groupadmin[k]).attr("id");
                $(".group_" + gid).show();
                $("#" + groupadmin[k]).click(function() {
                    $(this).toggleClass("active");
                    var gid = $(this).attr("id");
                    $(".group_" + gid).slideToggle(300);
                });
                
            }
        },
        
        "responsive": true,
        "lengthMenu": [
            [10, 30, 50, 100],
            [10, 30, 50, 100]
        ],
        "pageLength": 30,
        "fixedHeader": true,
        "ajax": {
            "url": base_url + "leave_request/employee_pagination/approved",
            "dataType": "json",
            "type": "POST",
            "data": function(d) {
                d.employee_id = $("#employee_id").val();
                d.select_month = $("#select_month").val();
                d.select_year = $("#select_year").val();
                d.select_leave = $("#select_leave").val();
            },
        },
        stateSave: true,
        "columns": [
            { "data": "#" },
            { "data": "id" },
            { "data": "fname" },
            { "data": "leave_date" },
            // { "data": "comment" }, 
            { "data": "leave_status" },
            // { "data": "status" },
            { "data": "action" },

        ],
        "order": [
            [3, "asc"]
        ],
        "columnDefs": [
            { "orderable": false, "targets": [0, 1, 2, 4, 5] }
        ],
    });
    var table3 = $('#example_admin-rejected').DataTable({
        "processing": true,
        "serverSide": true,
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ Entries",
            },
        "rowReorder": {
            "selector": 'td:nth-child(2)'
        },
        // "columnDefs": [{ "targets": 2, "visible": false, }],
        "drawCallback": function(settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;
            var groupadmin = [];

            api.column(2, { page: 'current' }).data().each(function(group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group active" id="rejected_' + i + '"><td colspan="6" class="font-bold blue-text"><span class="icon"></span>' + group + '</td></tr>'
                    );
                    groupadmin.push('rejected_' + i);
                    last = group;
                }
            });
            for (var k = 0; k < groupadmin.length; k++) {
                // Code added for adding class to sibling elements as "group_<id>"  
                $("#" + groupadmin[k]).nextUntil("#" + groupadmin[k + 1]).addClass(' group_' + groupadmin[k]);
                $("#" + groupadmin[k] + ' td').append(' <span class="float-right border-left pl-3" > ' + $('.group_' + groupadmin[k]).length + ' Request </span>');
                // Code added for adding Toggle functionality for each group
                var gid = $("#" + groupadmin[k]).attr("id");
                $(".group_" + gid).show();
                $("#" + groupadmin[k]).click(function() {
                    $(this).toggleClass("active");
                    var gid = $(this).attr("id");
                    $(".group_" + gid).slideToggle(300);
                });

            }
        },
        "responsive": true,
        "lengthMenu": [
            [10, 30, 50, 100],
            [10, 30, 50, 100]
        ],
        "pageLength": 30,
        "fixedHeader": true,
        "ajax": {
            "url": base_url + "leave_request/employee_pagination/rejected",
            "dataType": "json",
            "type": "POST",
            "data": function(d) {
                d.employee_id = $("#employee_id").val();
                d.select_month = $("#select_month").val();
                d.select_year = $("#select_year").val();
                d.select_leave = $("#select_leave").val();
            },
        },
        stateSave: true,
        "columns": [
            { "data": "#" },
            { "data": "id" },
            { "data": "fname" },
            { "data": "leave_date" },
            //{ "data": "comment" }, 
            { "data": "leave_status" },
            // { "data": "status" },
            { "data": "action" },

        ],
        "order": [
            [3, "asc"]
        ],
        "columnDefs": [
            { "orderable": false, "targets": [0, 1, 2, 4, 5] }
        ],
    });

    $('#example_admin-pending').on('draw.dt', function() {
        $('.delete_leave').change(function() {
            var checkbox = $('.delete_leave:checked');
            if (checkbox.length > 0) { $('#button_delete').show(); } else { $('#button_delete').hide(); }
        });
        $('.preloader-2').attr('style', 'display:none !important;');
    });
    $('#example_admin-rejected').on('draw.dt', function() {
        $('.delete_leave').change(function() {
            var checkbox = $('.delete_leave:checked');
            if (checkbox.length > 0) { $('#button_delete').show(); } else { $('#button_delete').hide(); }
        });
        $('.preloader-2').attr('style', 'display:none !important;');
    });
    $('#example_admin-approved').on('draw.dt', function() {
        $('.delete_leave').change(function() {
            var checkbox = $('.delete_leave:checked');
            if (checkbox.length > 0) { $('#button_delete').show(); } else { $('#button_delete').hide(); }
        });
        $('.preloader-2').attr('style', 'display:none !important;');
    });
    var table_1 = $('#example-pending').DataTable({
        "processing": true,
        "serverSide": true,
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ Entries",
            },
        "rowReorder": {
            "selector": 'td:nth-child(2)'
        },
        "responsive": true,
        "lengthMenu": [
            [10, 30, 50, 100],
            [10, 30, 50, 100]
        ],
        "pageLength": 30,
        "ajax": {
            "url": base_url + "leave_request/employee_pagination/pending/" + employee_id,
            "dataType": "json",
            "type": "POST",

        },
        stateSave: true,
        "columns": [
            { "data": "#" },
            { "data": "id" },
            // { "data": "fname" },
            { "data": "leave_date" },
            // { "data": "comment" }, 
            { "data": "leave_status" },
            // { "data": "status" },
            { "data": "action" },

        ],
        "columnDefs": [{
            "targets": [0,1,4],
            "orderable": false
        }],
        "order": [
            [3, "desc"]
        ],
        "fixedHeader": true,
    });
    $('#example-pending').on('draw.dt', function() {
        $('.preloader-2').attr('style', 'display:none !important;');
    });
    var table_2 = $('#example-approved').DataTable({
        "processing": true,
        "serverSide": true,
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ Entries",
            },
        "rowReorder": {
            "selector": 'td:nth-child(2)'
        },
        "responsive": true,
        "lengthMenu": [
            [10, 30, 50, 100],
            [10, 30, 50, 100]
        ],
        "pageLength": 30,
        "ajax": {
            "url": base_url + "leave_request/employee_pagination/approved/" + employee_id,
            "dataType": "json",
            "type": "POST",

        },
        stateSave: true,
        "columns": [
            // { "data": "#" },
            { "data": "id" },
            // { "data": "fname" },
            { "data": "leave_date" },
            // { "data": "comment" }, 
            { "data": "leave_status" },
            // { "data": "status" },
            { "data": "action" },

        ],
        "columnDefs": [{
            "targets": [0,3],
            "orderable": false
        }],
        "order": [
            [2, "desc"]
        ],
        "fixedHeader": true,
    });
    var table_3 = $('#example-rejected').DataTable({
        "processing": true,
        "serverSide": true,
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ Entries",
            },
        "rowReorder": {
            "selector": 'td:nth-child(2)'
        },
        "responsive": true,
        "lengthMenu": [
            [10, 30, 50, 100],
            [10, 30, 50, 100]
        ],
        "pageLength": 30,
        "ajax": {
            "url": base_url + "leave_request/employee_pagination/rejected/" + employee_id,
            "dataType": "json",
            "type": "POST",

        },
        stateSave: true,
        "columns": [
            // { "data": "#" },
            { "data": "id" },
            // { "data": "fname" },
            { "data": "leave_date" },
            //{ "data": "comment" }, 
            { "data": "leave_status" },
            // { "data": "status" },
            { "data": "action" }, 

        ],
        "columnDefs": [{
            "targets": [0,3],
            "orderable": false
        }],
        "order": [
            [2, "desc"]
        ],
        "fixedHeader": true,
    });

    function reload_table_ajax() {
        table1.clear();
        table1.ajax.reload();
        table2.clear();
        table2.ajax.reload();
        table3.clear();
        table3.ajax.reload();
        table_1.clear();
        table_1.ajax.reload();
        table_2.clear();
        table_2.ajax.reload();
        table_3.clear();
        table_3.ajax.reload();
    }

    $('#example-approved').on('draw.dt', function() {
        $('.delete_leave').change(function() {
            var checkbox = $('.delete_leave:checked');
            if (checkbox.length > 0) { $('#button_delete').show(); } else { $('#button_delete').hide(); }
        });
        $('.preloader-2').attr('style', 'display:none');
    });
    $('#example-rejected').on('draw.dt', function() {
        $('.delete_leave').change(function() {
            var checkbox = $('.delete_leave:checked');
            if (checkbox.length > 0) { $('#button_delete').show(); } else { $('#button_delete').hide(); }
        });
        $('.preloader-2').attr('style', 'display:none');
    });
    $('#example-pending').on('draw.dt', function() {
        $('.delete_leave').change(function() {
            var checkbox = $('.delete_leave:checked');
            if (checkbox.length > 0) { $('#button_delete').show(); } else { $('#button_delete').hide(); }
        });
        $('.preloader-2').attr('style', 'display:none');
    });
    $(document).on('click', '#button_delete', function() {
        var checkbox = $('.delete_leave:checked');
        if (checkbox.length > 0) {
            var checkbox_value = [];
            $(checkbox).each(function() {
                checkbox_value.push($(this).val());
            });
            if (confirm("Are you sure you want to delete?")) {
                $('.preloader-2').attr('style', 'display:block !important;');
                var data = {
                    'id': checkbox_value,
                };
                $.ajax({
                    url: "leave_request/delete_leave",
                    type: "post",
                    data: data,
                    success: function(response) {
                        var data = JSON.parse(response);
                        // console.log(data.error);
                        $('.msg-container').html(data.error);
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                        reload_table_ajax();
                        $('.preloader-2').attr('style', 'display:none');
                        $('#button_delete').hide();
                    },
                });
            }
        } else {
            alert('Select atleast one records For Delete');
        }
        return false;
    });

    $('#bonus-form').submit(function() {
        // table.clear();
        // table.ajax.reload();
        $('.preloader-2').attr('style', 'display:block !important;');
        reload_table_ajax();
        return false;
    });
    $('.emp_search1').change(function() {
        // table.clear();
        // table.ajax.reload();
        $('.preloader-2').attr('style', 'display:block !important;');
        reload_table_ajax();
        return false;
    });
    $(document).on('click', '.edit_leave', function() {
        $('.preloader-2').attr('style', 'display:block !important;');
        // jQuery(".loader-text").html("Deleting Designation");
        // jQuery(".loader-wrap").show();
        var id = $(this).attr("data-id");
        var data = { 'id': id, };
        $.ajax({
            url: base_url + "leave_request/get_leave_detail",
            type: "post",
            data: data,
            success: function(response) {
                // location.reload();
                var data = JSON.parse(response);
                $('.submit_form').text('Update');
                $('.employee_name').text('Update Leave Request');
                $('.employee_name').text('Update Leave Request');
                $('#leave_commet').html(data.list_data[0].comment);
                $('#leave_commet').val(data.list_data[0].comment);
                if(data.list_data[0].comment != ''){
                    $('.add-comment').prop('checked',true);
                    $('.leave-commet-box').removeClass('d-none');
                }else{
                    $('.leave-commet-box').addClass('d-none');
                    $('.add-comment').prop('checked',false);
                }
                // $('#date_leave').val(data.list_data[0].leave_date);
                $('#leave_date').val(data.list_data[0].leave_date);
                $('#type').val('ajax');
                // $('#date_leave').datepicker('setDate', null);
                $('.multiple_date').datepicker({
                    multipleDates: false,
                });
                $('#leave_date').datepicker().data('datepicker').clear();
                // $('#date_leave').datepicker().data('datepicker').clear();
                $('#leave_date').datepicker().data('datepicker').selectDate(new Date(data.list_data[0].leave_date));
                $('#edit_date').val(data.list_data[0].leave_date);
                // $('#date_leave').datepicker().data('datepicker').selectDate(new Date(data.list_data[0].leave_date));
                $('#leave_status option').prop('selected', false);
                $('#leave_status option').each(function(i,v){
                    if(data.list_data[0].leave_status == $(this).val()){
                        $(this).prop('selected', true);
                    }else if(data.list_data[0].leave_status == 'none' && $(this).val() == 'General'){
                        $(this).prop('selected', true);
                    }else if(data.list_data[0].leave_status == 'sick' && $(this).val() == 'Sick'){
                        $(this).prop('selected', true);
                    }
                });
                // if (data.list_data[0].leave_status == 'none') {
                //     $('#leave_status_none').prop('checked', true);
                //     // $('#none').attr('checked', 'checked');
                // } else if (data.list_data[0].leave_status == 'sick') {
                //     $('#leave_status_sick').prop('checked', true);
                //     // $('#sick').attr('checked', 'checked');
                // }

                if (data.list_data[0].status == 'approved') {
                    $('#status_approve').prop('checked', true);
                    // $('#approved').attr('checked', 'checked');
                } else if (data.list_data[0].status == 'rejected') {
                    $('#status_reject').prop('checked', true);
                    // $('#rejected').attr('checked', 'checked');
                } else if (data.list_data[0].status == 'pending') {
                    $('#status_approve').prop('checked', false);
                    $('#status_reject').prop('checked', false);

                }

                $('#e_id').val(data.list_data[0].id);
                $('#employee_select').val(data.list_data[0].employee_id);
                $.each(data.all_employees, function(i) {
                    if (data.all_employees[i].id == data.list_data[0].employee_id) {
                        $('.h5-emp-name').text('Employee : ' + data.all_employees[i].fname + ' ' + data.all_employees[i].lname);
                        $('#emp_id').val(data.all_employees[i].id);
                    }
                });
                employee_select($('#employee_select'));
                $('.preloader-2').attr('style', 'display:none !important;');
                $('.btn-open-desig').click();
                // $('.add_leave_modal').click();
            },

        });
        return false;
    });
    $(document).on('click', '.add_attendance', function() {
        $('.submit_form').text('Add');
        $('.employee_name').text('Add Leave Request');
        $('#leave_commet').val('');
        $('.add-comment').prop('checked',false);
        $('.leave-commet-box').addClass('d-none');
        $('#leave_date').val('');
        $('#type').val('ajax');
        $('.multiple_date').datepicker({
            multipleDates: true,
        });
        $('#leave_date').datepicker().data('datepicker').clear();
        // $('#leave_status_none').prop('checked', false);
        // $('#leave_status_sick').prop('checked', false);
        $('#leave_status option').prop('selected', false);
        $('#status_approve').prop('checked', false);
        $('#status_reject').prop('checked', false);
        $('#e_id').val('');
        $('#employee_select').val($('#employee_select').find('option:eq(1)').val());
        if($('#js_data').data('role') != 'admin'){
            employee_select($('#employee_id'));
        }else{
            employee_select($('#employee_select'));
        }
    });
    $('.submit_edit_form').click(function() {
        var type = $('#type').val();
        var e_id = $('#e_id').val();
        var employee_select = $('#employee_select').val();
        var leave_date = $('#date_leave').val();
        var emp_id = $('#emp_id').val();
        var leave_commet = $('#leave_commet').html();
        var leave_status = $('#leave_status option:selected').val();
        var status = $('input[name=status]:checked').val();
        if (leave_status && employee_select && leave_date && status) {
            var data = {
                'type': type,
                'e_id': e_id,
                'employee_select': employee_select,
                'leave_date': leave_date,
                'employee_id': emp_id,
                'leave_commet': leave_commet,
                'leave_status': leave_status,
                'status': status,
            };
            $.ajax({
                url: base_url + "leave_request/insert_data",
                type: "post",
                data: data,
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.error_code !== '') {
                        $('.msg-container').html(data.error);
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        // $('.close').click();
                        reload_table_ajax();
                        // $('.close').click();
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                        return false;
                    }else{
                        $('.msg-container').html(data.error);
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        $('.close').click();
                        reload_table_ajax();
                        $('.close').click();
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                        return false;
                    }
                },

            });
            return false;
        } else {
            $('.close').click();
            return false;
        }
    });
    $(document).on('click', '.add-comment', function () {
        if($(this).prop('checked')){
            $('.leave-commet-box').removeClass('d-none');
        }else{
            $('.leave-commet-box').addClass('d-none');
        }
    });
    $('#leave-form').submit(function() {
        var type = $('#type').val();
        var e_id = $('#e_id').val();
        var employee_select = $('#employee_select').val();
        var leave_date = $('#leave_date').val();
        var old_leave_date = $('#edit_date').val();
        var leave_commet = $('#leave_commet').html();

        var leave_status = $('#leave_status option:selected').val();
        var status = $('input[name=status]:checked').val();
        var num = 0;
        if($('.add-comment').prop('checked')){
            if(maxlength(leave_commet,100)){$("#leave_commet").removeClass('error');}else{$("#leave_commet").addClass('error');num++;}
            var add_comment = "true";
        }else{
            var add_comment = "false";
        }
        if(num == 0){
            var data = {
                'type': type,
                'e_id': e_id,
                'employee_select': employee_select,
                'leave_date': leave_date,
                'old_leave_date': old_leave_date,
                'leave_commet': leave_commet,
                'leave_status': leave_status,
                'add_comment': add_comment,
                'status': status,
            };
            $.ajax({
                url: base_url + "leave_request/insert_data",
                type: "post",
                data: data,
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.error_code != 0) {
                        // window.location.href = base_url+'leave_request';
                        reload_table_ajax();
                        $('.msg-container').html(data.error);
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        // $('.close').click();
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                        return false;
                    }else{
                        reload_table_ajax();
                        $('.msg-container').html(data.error);
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        $('#leave_date').datepicker().data('datepicker').clear();
                        $('#leave_date').val('');
                        $('#leave_commet').val('');
                        $('.leave-commet-box').addClass('d-none');
                        $('.add-comment').prop('checked', false);
                        $('#employee_select').removeAttr('selected');
                        $('#employee_select option:eq(0)').attr('selected', true);
                        $('#leave_status option:selected').attr('selected', false);
                        $('input[name=status]').attr('selected', false);
                        $('.html_leave.row').empty();
                        $('.close').click();
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                        return false;
                    }
                },

            });
        }else{
            return false;
        }
        return false;
    });
    $(document).on('click', '.delete-employee', function() {
        if (confirm("Are you sure want to delete?")) {
            $('.preloader-2').attr('style', 'display:block !important;');
            jQuery(".loader-text").html("Deleting Designation");
            jQuery(".loader-wrap").show();
            var id = $(this).attr("data-id");
            var data = {
                'id': id,
            };
            $.ajax({
                url: base_url + "leave_request/delete_employee",
                type: "post",
                data: data,
                success: function(response) {
                    $('.preloader-2').attr('style', 'display:block !important;');
                    var data = JSON.parse(response);
                    // console.log(data.error);
                    $('.msg-container').html(data.error);
                    $('.msg-container .msg-box').attr('style', 'display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style', 'display:none');
                    }, 6000);
                    reload_table_ajax();
                    // location.reload();
                    return false;
                },

            });
        }
        return false;
    });
    $(document).on('click', '.status-update', function() {
        var checkbox = $('.leave_checkbox:checked');
        var checkbox_value = [];
        if (checkbox.length > 0) {
            $(checkbox).each(function() {
                checkbox_value.push($(this).val());
            });
        }else{
            if($(this).attr("data-id") != undefined)
            checkbox_value.push($(this).attr("data-id"));
        }
        if(checkbox_value.length > 0){
            if (confirm('Are You Sure About This Leave?')) {
                // $('.preloader-2').attr('style', 'display:block !important;');
                $('.preloader').attr('style', 'display:block !important;');
                // jQuery(".loader-wrap").show();
                //var id = $(this).attr("data-id");
                var status_update = $(this).attr("data-status");
                var data = {
                    'id': checkbox_value,
                    'status_update': status_update,
                };
                $.ajax({
                    url: base_url + "leave_request/update_status",
                    type: "post",
                    data: data,
                    success: function(response) {
                        var data = JSON.parse(response);
                        // console.log(response);
                        $('.msg-container').html(data.error);
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                        reload_table_ajax();
                        location.reload();
                        $('.preloader').attr('style', 'display:none !important;');
                    },

                });
                return false;
            }
        }else{
            return false;
        }
    });

});
// $("#leave-form").submit(function(e) {
    $(".submit_form").click(function() {
        var role = $("#js_data").attr("data-role");
        var leave_date = $("#leave_date").val();
        var leave_commet = $("#leave_commet").html();
        var employee_select = $("#employee_select").val();
        var status_approve = $("#status_approve").val();
        var status_reject = $("#status_reject").val();

        var leave_status = $('#leave_status option:selected', '#leave-form').val();
        //leave_status_error
        if (role == "admin") {
            var output = $('input[name=status]:checked', '#leave-form').val();
        } else {
            var output = " ";
        }
        var flag = 0;
        if (leave_date == '') {
            $("#leave_date").addClass('error');
            flag++;
        } else {
            $("#leave_date").removeClass('error');
        }
        if($('.add-comment').prop('checked')){
            if (leave_commet != '' && maxlength(leave_commet,200)) {
                $("#leave_commet").removeClass('error');
            } else {
                $("#leave_commet").addClass('error');
                flag++;
            }
        }
        // 
        $(".msg-container").html('');
        if (leave_status == '' || leave_status == undefined) {
            $("#leave_status_error").addClass('error');
            flag++;
            $(".msg-container").append('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Select leave type</p></div></div></div>');
            $('.msg-container .msg-box').attr('style', 'display:block');
        } else {
            $("#leave_status_error").removeClass('error');
            // $(".msg-container").html('');
        }
        if (role == "admin") {
            if (employee_select == ''){
                $("#employee_select").addClass('error');
                flag++;
            } else {
                $("#employee_select").removeClass('error');
            }
            if(output == '' || output == undefined) {
                $("#status_error").addClass('error');
                flag++;
                $(".msg-container").append('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Select leave status</p></div></div></div>');
                $('.msg-container .msg-box').attr('style', 'display:block');
            } else {
                $("#status_error").removeClass('error');
                // $(".msg-container").html('');
            }
        }
        if (flag == 0) {
            var num = 0;
            if(maxlength(leave_commet,200)){$("#leave_commet").removeClass('error');}else{$("#leave_commet").addClass('error');num++;}
            if(num == 0){
                $("#leave_date").removeClass('error');
                $("#leave_commet").removeClass('error');
                $("#status_error").removeClass('error');
                $("#leave_status_error").removeClass('error');
                $("#employee_select").removeClass('error');
                $(".msg-container").html('');
                return true;
                // $("#leave-form").submit();
            }else{
                return false;
            }
        } else {
            if($(".msg-container").html() != ''){
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style', 'display:none');
                }, 6000);
            }
            return false;
        }
    });
if ($('input').is('#leave_date')) {
    if ($('#leave_date').data('role') != 'admin') {
        if ($('#leave_date').data('date') != '') {
            var currentDate = new Date($('#leave_date').data('date'));
            $('#leave_date').datepicker().data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()));
        }
    }
}

$('#leave_commet').change(function(){
    $(this).html($(this).val());
});


