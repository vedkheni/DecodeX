jQuery(document).ready(function($) {
    var base_url = $("#js_data").attr("data-base-url");
    var employee_id = $("#js_data").attr("data-employee-id");
    var role = $("#js_data").attr("data-role");
    var month = $("#bonus_month").val();
    var year = $("#bonus_year").val();
    // data_table_draw(month,year);
    // function data_table_draw(month,year){
    $('.preloader-2').attr('style', 'display:block !important;');
    if (role == 'admin') {

        var table = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "rowReorder": {
                "selector": 'td:nth-child(2)'
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
            "ajax": {
                "url": base_url + "salary_pay/employee_pagination",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.month = $("#bonus_month").val();
                    d.year = $("#bonus_year").val();
                },
            },
            stateSave: true,
            "columns": [
                { "data": "id" },
                { "data": "fname" },
                { "data": "salary" },
                { "data": "bonus" },
                { "data": "leave" },
                { "data": "qrcode" },
                { "data": "status" },
                { "data": "bankstatus" },
                { "data": "action" },
            ],
            "columnDefs": [{
                "targets": [5, 6],
                "orderable": false,
            },{"targets": [2,3],
            "createdCell": function(td, cellData, rowData, row, col){
                $(td).attr('data-order',Number(($(td).text()).replace(/[^0-9.]/g, "")));
            }
           },],
        });
        table.order([1, 'asc']).draw();
    } else {
        var table = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
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
                "url": base_url + "salary_pay/employee_pagination",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.month = $("#bonus_month").val();
                    d.year = $("#bonus_year").val();
                },
            },
            stateSave: true,
            "columns": [
                { "data": "id" },
                { "data": "fname" },
                { "data": "salary" },
                { "data": "bonus" },
                { "data": "leave" },
                { "data": "status" },
                // { "data": "bankstatus" },
                { "data": "action" },
            ],
            "columnDefs": [{
                "targets": [5],
                "orderable": false,
            },{"targets": [2,3],
            "createdCell": function(td, cellData, rowData, row, col){
                $(td).attr('data-order',Number(($(td).text()).replace(/[^0-9.]/g, "")));
            }
            },],
            "fixedHeader": true,
        }); 
        table.order([1, 'asc']).draw();
    }
    // table.order([1, 'asc']).draw();
    // }
    
    $(document).on('click', '.salary_payment_btn', function() {
        $('.salary_preloader').attr('style', 'display:block !important;');
        var id = $(this).attr("data-id");
        var payment_status = $(this).attr("data-payment-status");

        if ($("#skip_paid_leave").prop("checked")) {
            var skip_paid_leave = 1;
        } else {
            var skip_paid_leave = 0;
        }
        if ($("#salary_deduction").prop("checked")) {
            var salary_deduction = 1;
        } else {
            var salary_deduction = 0;
        }
        //console.log(payment_status);
        //if (confirm("Are you sure?")) {
        if ($("#bonus_month").val() == "11") {
            $(".remaining_list").show();
        } else {
            $(".remaining_list").hide();
        }
        // var id=$("#eid").val();
        var deposit = "";
        var d = $(".total_deposit").attr('data-total-deposit');
        if ($.isNumeric(d)) {
            var deposit = $(".total_deposit").attr('data-total-deposit');
        }
		  var payout_paid_leave_amount = 0;
		  var payout_paid_leave_status = 'uncheck';
		  if ($("#payout_paid_leave").is(":checked")) {
			var payout_paid_leave_status = 'check';
			payout_paid_leave_amount = $('.payout_paid_leave_amount').text();
		  }
        //console.log($(".total_basic_salary").closest(this).data('basic-salary'));
        var data = {
            'id': id,
            'month': $("#bonus_month").val(),
            'year': $("#bonus_year").val(),
            'total_working_day': $(".total_working_day").text(),
            'diposit_status': $('#diposit_status').val(),
            'total_official_holiday': $(".total_official_holiday").text(),
            'total_effective_day': $(".total_effective_day").text(),
            'total_absent_leave': $(".total_absent_leave").text(),
            'total_unpaid_leave': $(".total_unpaid_leave").text(),
            'total_approved_leave': $(".total_approved_leave").text(),
            'total_paid_leave': $(".total_paid_leave").text(),
            'total_unapproved_leave': $(".total_unapproved_leave").text(),
            'basic_salary': $(".total_basic_salary").text(),
            'bonus': $("#bonus").val(),
            'total_prof_tax': $(".total_prof_tax").text(),
            'total_deduction': $(".total_deduction").text(),
            'total_net_salary': $(".total_net_salary").text(),
            'total_sick_leave': $(".total_sick_leave").text(),
            'per_val': $("#per_val").text(),
            'total_deduction_per': $(".total_deduction_per").text(),
            'total_leave': $(".total_leave").text(),
            'payment_status': payment_status,
            'submit_status': $("#submit_status").val(),
            'total_deposit': deposit,
            'skip_paid_leave': skip_paid_leave,
            'salary_deduction': salary_deduction,
			'payout_paid_leave_amount': payout_paid_leave_amount,
			'payout_paid_leave_status': payout_paid_leave_status,
        };
        $.ajax({
            url: "salary_pay/insert_data",
            type: "post",
            data: data,
            success: function(response) {
				console.log(response);
                if (payment_status == "paid") {
                    // location.reload();
                    table.order([1, 'asc']).draw();
                    // table.order([1, 'asc']).draw();
                    if(response == 1){
                        var message = ($('#submit_status').val() == 'edit')? 'Employee salary updated successfully.': 'Employee salary paid successfully.';
                        $('.msg-container').html('<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>'+message+'</p></div></div></div>');
                        $('.salary_payment_btn').hide();
                        $('.salary_payment_edit_btn').show();
                        $('.msg-container .msg-box').attr('style','display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style','display:none');
                        }, 6000);
                    }
                    salary_pay_data(id);
                    // $('.close.close_popup').click();
                } else {
                    setTooltip('Copied!');
                    hideTooltip();
                    //update message
                    //console.log(response);
                } 
                $('.salary_preloader').attr('style', 'display:none !important;');
            },

        });
       // emp_search1();

    });

    $(document).on('click', '.salary_pay_btn', function() {
        $('.salary_preloader').attr('style', 'display:block !important;');
        var id = $(this).attr("data-id");
        var payment_status = $(this).attr("data-payment-status");

        if ($("#bonus_month").val() == "11") {
            $(".remaining_list").show();
        } else {
            $(".remaining_list").hide();
        }
        
		var payout_paid_leave_status = ($("#payout_paid_leave").is(":checked")) ? 'check' :'uncheck';
		var skip_paid_leave = ($("#skip_paid_leave").is(":checked")) ? 'check' :'uncheck';

        var data = {
            'id': id,
            'month': $("#bonus_month").val(),
            'year': $("#bonus_year").val(),
            'diposit_status': $('#diposit_status').val(),
            'bonus': $("#bonus").val(),
            'skip_paid_leave': skip_paid_leave,
            'payment_status': payment_status,
            'submit_status': $("#submit_status").val(),
			'payout_paid_leave_status': payout_paid_leave_status,
        };
        $.ajax({
            url: "salary_pay/salaryDataInsert",
            type: "post",
            data: data,
            success: function(response) {
				// console.log(response);
                if (payment_status == "paid") {
                    
                    table.order([1, 'asc']).draw();
                    if(response){
                        var obj = JSON.parse(response);
                        var message = ($('#submit_status').val() == 'edit')? 'Employee salary updated successfully.': 'Employee salary paid successfully.';
                        $('.msg-container').html(obj.message);
                        $('.salary_pay_btn').hide();
                        $('.salary_payEdit_btn').show();
                        $('.msg-container .msg-box').attr('style','display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style','display:none');
                        }, 6000);
                    }
                    salary_pay_data(id);
                    if(obj.error_code == 0){
                        $('.close.close_popup').click();
                        emp_search1();
                    }
                } else {
                    setTooltip('Copied!');
                    hideTooltip();
                    //update message
                    //console.log(response);
                } 
                $('.salary_preloader').attr('style', 'display:none !important;');
            },
        });
    });

    $(document).on('click', '.paid_to_bank', function() {
        if (confirm("Are you sure you want to change bank status?")) {
            $('.preloader-2').attr('style', 'display:block !important;');
            $('#massagae').html('');
            var base_url = $("#js_data").attr("data-base-url");
            var id = $(this).data('id');
            var month = $(this).data('month');
            var year = $(this).data('year');
            var salary = $(this).data('salary');
            var data = {
                'employee_id': id,
                'month': month,
                'year': year,
                'salary': salary,
            }
            $.ajax({
                url: base_url + "salary_pay/ajax_bank_status",
                type: "post",
                data: data,
                success: function(response) {
                    var obj = JSON.parse(response);
                    if(obj.error_code == 0){
                        $('.msg-container').html(obj.message);
                        $('.msg-container .msg-box').attr('style','display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style','display:none');
                        }, 6000);
                        table.order([1, 'asc']).draw();
                        // $('#massagae').html(response);
                    }else{
                        $('.msg-container').html(obj.message);
                        $('.msg-container .msg-box').attr('style','display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style','display:none');
                        }, 6000);
                    }
                        $('.preloader-2').attr('style', 'display:none !important;');
                    // window.location.replace("employee");
                },
            });
        }
    });
    
    $('#salary_month_search').click(function() {
        $('.preloader-2').attr('style', 'display:block !important;');
        $('#massagae').html('');
        // $('.report_preloader1').show();

        var base_url = $("#js_data").attr("data-base-url");
        var month = '';
        if ($("#bonus_month").val() < 10) {
            month = 0 + $("#bonus_month").val();
        } else {
            month = $("#bonus_month").val();
        }
        var year = $("#bonus_year").val();
        var url = base_url + 'salary_pay/txt_file_update/' + month + '/' + year;
        var url = base_url + 'salary_pay/upi_txt_file_update/' + month + '/' + year;
        $('#text_file').attr('href', url);
        var data = {
            'bonus_month': month,
            'bonus_year': year,
        };
        $.ajax({
            url: base_url + "salary_pay/total_salary",
            type: "post",
            data: data,
            success: function(response) {
                table.order([1, 'asc']).draw();
                // table.order([1, 'asc']).draw();
                // console.log(response);
                var data = JSON.parse(response);
                if (data.total_salary[0].total_salary) {
                    $('#totle_salary').text(data.total_salary[0].total_salary);
                } else {
                    $('#totle_salary').text('0.00');
                }
                $('.preloader-2').attr('style', 'display:none !important;');
            },

        });
    });

    $('#example').on('draw.dt', function() {
        $('.preloader-2').attr('style', 'display:none !important;');
    });

    $('.emp_search1').change(function() {
        emp_search1();
    });

    function emp_search1() {
        $('#massagae').html('');
        $('.preloader-2').attr('style', 'display:block !important;');
        // $('.report_preloader1').show();

        var base_url = $("#js_data").attr("data-base-url");
        var month = '';
        if ($("#bonus_month").val() < 10) {
            month = 0 + $("#bonus_month").val();
        } else {
            month = $("#bonus_month").val();
        }
        var year = $("#bonus_year").val();
        var url = base_url + 'salary_pay/txt_file_update/' + month + '/' + year;
        var url = base_url + 'salary_pay/upi_txt_file_update/' + month + '/' + year;
        // var file = new File('salary_pay/txt_file_update/' + month + '/' + year);
        // See if the file exists
        var data = {
            'bonus_month': month,
            'bonus_year': year,
        };
        $.ajax({
            url: base_url + "salary_pay/total_salary",
            type: "post",
            data: data,
            success: function(response) {
                table.order([1, 'asc']).draw();
                // console.log(response);
                var data = JSON.parse(response);
                if(data.file_exists == 'true'){
                    $('.emp_view').html('<a target="_blank" class="btn sec-btn emp_search " id="text_file" href="">View Text File</a>');
                    $('#text_file').attr('href', url);
                    $('#text_file').show();
                }else{
                    $('#text_file').hide();
                }
                if (data.total_salary[0].total_salary) {
                    $('#totle_salary').text(Number(data.total_salary[0].total_salary).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,'));
                } else {
                    $('#totle_salary').text('0.00');
                }
                $('.preloader-2').attr('style', 'display:none !important;');
            },

        });
        $('#example').on('draw.dt', function() {
            $('.report_preloader1').hide();
        });
    }

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    $(document).on('click', '.delete-employee', function() {
        if (confirm("Are you sure?")) {
            jQuery(".loader-text").html("Deleting Employee");
            jQuery(".loader-wrap").show();
            var id = $(this).attr("data-id");

            var data = {
                'id': id,
            };
            $.ajax({
                url: "employee/delete_employee",
                type: "post",
                data: data,
                success: function(response) {
                    window.location.replace("employee");
                },

            });
            // your deletion code
        }
        return false;
    });

    $("#employee-form").submit(function(e) {
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var email = $("#email").val();
        var passwords = $("#password").val();
        // var date_of_birth=$("#date_of_birth").val();
        var birth_year = $("#birth_year").val();
        var birth_day = $("#birth_day").val();
        var birth_month = $("#birth_month").val();
        var date_of_birth = $("#date_of_birth").val();
        //  var birth_year_val = date_of_birth.split('-');
        var joining_year = $("#joining_year").val();
        var joining_day = $("#joining_day").val();
        var joining_month = $("#joining_month").val();
        // var join_year_val = joining_date.split('-');

        var skype_account = $("#skype_account").val();
        var skype_password = $("#skype_password").val();
        var gmail_account = $("#gmail_account").val();
        var gmail_password = $("#gmail_password").val();

        var gender = true;
        $('#gender').each(function() {
            gender = gender && $(this).is(':checked');
        });
        var address = $("#address").val();
        var designation = $("#designation").val();
        var phone_number = $("#phone_number").val();
        var salary = $("#basic_salary").val();
        var deduction = $("#salary_deduction").val();
        if (!fname || !lname || !email || !passwords || !phone_number || !birth_year || !birth_day || !birth_month || !address || !designation || !salary || !deduction || !joining_year || !joining_day || !joining_month || !skype_password || !skype_account || !gmail_password || !gmail_account) {
            e.preventDefault();
            if (!fname) {
                $("#fname").addClass('error');
            } else {
                $("#fname").removeClass('error');
            }
            if (!lname) {
                $("#lname").addClass('error');
            } else {
                $("#lname").removeClass('error');
            }
            if (!email) {
                $("#email").addClass('error');
            } else {
                $("#email").removeClass('error');
            }
            if (!passwords) {
                $("#password").addClass('error');
            } else {
                $("#password").removeClass('error');
            }
            if (!phone_number) {
                $("#phone_number").addClass('error');
            } else {
                $("#phone_number").removeClass('error');
            }
            if (!birth_year) {
                $("#birth_year").addClass('error');
            } else {
                $("#birth_year").removeClass('error');
            }
            if (!birth_month) {
                $("#birth_month").addClass('error');
            } else {
                $("#birth_month").removeClass('error');
            }
            if (!birth_day) {
                $("#birth_day").addClass('error');
            } else {
                $("#birth_day").removeClass('error');
            }

            if (!designation) {
                $("#designation").addClass('error');
            } else {
                $("#designation").removeClass('error');
            }
            if (!address) {
                $("#address").addClass('error');
            } else {
                $("#address").removeClass('error');
            }
            if (!joining_year) {
                $("#joining_year").addClass('error');
            } else {
                $("#joining_year").removeClass('error');
            }
            if (!joining_day) {
                $("#joining_day").addClass('error');
            } else {
                $("#joining_day").removeClass('error');
            }
            if (!joining_month) {
                $("#joining_month").addClass('error');
            } else {
                $("#joining_month").removeClass('error');
            }
            if (!salary) {
                $("#basic_salary").addClass('error');
            } else {
                $("#basic_salary").removeClass('error');
            }
            if (!deduction) {
                $("#salary_deduction").addClass('error');
            } else {
                $("#salary_deduction").removeClass('error');
            }
            if (!gmail_account) {
                $("#gmail_account").addClass('error');
                //error_messages +="<span class='massge_for_error gmail_err text-center'>Please Enter Employee Gmail Account</span><br/>";
            } else {
                if (isEmail(gmail_account) == false) {
                    $("#gmail_account").addClass('error');
                    //error_messages +="<span class='massge_for_error gmail_err text-center'>Please Enter Valid Employee Gmail Account</span><br/>";
                } else {
                    $("#gmail_account").removeClass('error');
                    //$(".message_error").remove();
                }
            }
            if (!gmail_password) {
                $("#gmail_password").addClass('error');
                //error_messages +="<span class='massge_for_error gmail_pass_err text-center'>Please Enter Employee Gmail Password</span><br/>";
            } else {
                $("#gmail_password").removeClass('error');
                //$(".message_error").remove();
            }
            if (!skype_account) {
                $("#skype_account").addClass('error');
                //error_messages +="<span class='massge_for_error skype_err text-center'>Please Enter Employee Skype Account</span><br/>";
            } else {
                if (isEmail(skype_account) == false) {
                    $("#skype_account").addClass('error');
                    //error_messages +="<span class='massge_for_error skype_err text-center'>Please Enter Valid Employee Skype Account</span><br/>";
                } else {
                    $("#skype_account").removeClass('error');
                    //$(".message_error").remove();
                }
            }
            if (!skype_password) {
                $("#skype_password").addClass('error');
                //error_messages +="<span class='massge_for_error skype_pass_err text-center'>Please Enter Employee Skype Password</span><br/>";
            } else {
                $("#skype_password").removeClass('error');
                //$(".message_error").remove();
            }
            return false;
        } else {
            $("#fname").removeClass('error');
            $("#lname").removeClass('error');
            $("#email").removeClass('error');
            $("#password").removeClass('error');
            $("#birth_year").removeClass('error');
            $("#birth_month").removeClass('error');
            $("#birth_day").removeClass('error');
            $("#joining_day").removeClass('error');
            $("#joining_month").removeClass('error');
            $("#joining_year").removeClass('error');
            $("#gender1").removeClass('error');
            $("#address").removeClass('error');
            $("#designation").removeClass('error');
            $("#basic_salary").removeClass('error');
            $("#salary_deduction").removeClass('error');
            $("#gmail_account").removeClass('error');
            $("#gmail_password").removeClass('error');
            $("#skype_account").removeClass('error');
            $("#skype_password").removeClass('error');

            /* var userinput = $("#email").val();
             var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i

             if(!pattern.test(userinput))
             {
               alert('not a valid e-mail address');
             }​else{
             }*/
            $('.close.close_popup').click();
            return true;

        }
    });

    $(document).on('click', '.status', function() {
        var base_url = $("#js_data").data('base-url');
        if ($(this).attr('data-id')) {
            var employee_status = $(this).data('status');
            var id = $(this).data('id');
            console.log(employee_status + " - " + id);
            var data = {
                'id': id,
                'status': employee_status,
            };
            $.ajax({
                url: base_url + 'employee/update_employee_status',
                type: 'post',
                data: data,
                success: function(response) {
                    location.reload();
                }
            });
        }
    });
});

/* view file code Start */
$(document).ready(function() {
    var base_url = $("#js_data").attr("data-base-url");
});

function salary_pay_data(id) {
    $('.row_payout_paid_leave').hide();

    $('.salary_pay_btn').attr('data-id', id);
    
    $('.salary_preloader').attr('style', 'display:block !important;');
    var user_role = $("#js_user_role").attr("data-user_role");
    var base_url = $("#js_data").attr("data-base-url");
    $("#eid").val(id);

    if ($("#bonus").val()) {
        var bonus = $("#bonus").val();
    } else {
        var bonus = 0;
    }

    var month = $("#bonus_month").val();
    var year = $("#bonus_year").val();
    var basic_salary = 0;

    var data = {
        'employee_id': id,
        'month': month,
        'year': year,
        'bonus': bonus,
    };
    $.ajax({
        url: base_url + "salary_pay/get_salaryDetails",
        type: "post",
        data: data,
        success: function(response) {
            $('.remove_pay-deposit').hide();
            var obj = jQuery.parseJSON(response);
            /* button hide show */
                /* Hide Show For Admin And Eployee Side */
                if (obj.payment_status == "paid") {
                    $(".salary_pay_btn").hide();
                    if (user_role == "admin") {
                        $(".total_bonus").html('<input type="text"  step="any" name="bonus" id="bonus"   placeholder="Bonus">');
                        $("#bonus").val(obj.bonus);
                        $(".salary_payEdit_btn").show();
                        $("#submit_status").val('edit');
                        if (obj.deposit_paid != 0) {
                            $('.total_deposit').attr('data-total-deposit', Number(obj.deposit_paid).toFixed());
                            $('.total_deposit').text(Number(obj.deposit_paid).toFixed());
                            $('.pay-deposit').attr('data-pay-deposit', Number(obj.deposit_paid).toFixed());
                            $('.total_deposit').addClass("added");
                            $('.remove_pay-deposit').show();
                            ((obj.total_deposit) <= 0 && obj.deposit_paid == 0) ? $(".row_total_deposit").hide(): $('.row_total_deposit').show();
                            $('#diposit_status').val('paid');

                        } else {
                            $('.remove_pay-deposit').hide();
                            $('#diposit_status').val('pending');
                            $(".total_deposit").html('<button type="button"  class="btn btn-default text-primary p-0 pay-deposit" data-pay-deposit="" >Pay Deposit</button>');
                        }
                    } else {
                        $(".total_bonus").text("+" + obj.bonus);
                    }
                } else {
                    if (user_role == "admin") {
                        $('#diposit_status').val('pending');
                        $(".salary_pay_btn").show();
                        $(".salary_payEdit_btn").hide();
                        $(".total_deposit").html('<button type="button"  class="btn btn-default text-primary p-0 pay-deposit" data-pay-deposit="" >Pay Deposit</button>');
                        $(".total_bonus").html('<input type="text"  step="any" name="bonus" id="bonus"   placeholder="Bonus">');
                        $("#bonus").val(obj.bonus);
                    } else { 
                        $(".salary_pay_btn").hide();
                        $(".total_bonus").text("+" + obj.bonus);
                    }

                }
                /* End */
            /* End */
            /* Show Salary Attendance Time */
            var str = obj.plus_time;
            var str1 = obj.minus_time;
            var str2 = obj.total_time;
            if (obj.time_status == "plus") {
                $(".total_plus_minus_time").addClass("color_border_green");
                $(".total_plus_minus_time").removeClass("color_border_red");
            } else {
                $(".total_plus_minus_time").addClass("color_border_red");
                $(".total_plus_minus_time").removeClass("color_border_green");
            }
            var p_time = str;
            var m_time = str1;
            var t_time = str2;
            $(".total_plus_time").text(p_time);
            $(".total_minus_time").text(m_time);
            $(".total_plus_minus_time").text(t_time);
            /* End */
            /* Show Salary Days */

            $(".total_working_day").text(obj.total_working_days);
            $(".total_official_holiday").text(obj.total_holiday_days);
            $(".total_effective_day").text(obj.total_present_days);
            /* End */

            /* Show Salary Leave */
            $(".total_leave").text(obj.total_absent_days);
            $(".total_paid_leave").text(obj.paid_leave);
            $(".total_sick_leave").text(obj.sick_leave);
            $(".total_approved_leave").text(obj.approved_leaves);
            $(".total_unapproved_leave").text(obj.unapproved_leave);
            $(".total_absent_leave").text(obj.total_leaves);
            /* End */

            /* Show Salary Left Part (Part-1)  */
            // Show Salary Part-1 Baisc Salary  
            $(".total_basic_salary").text(Number(obj.basic_salary).toFixed());
            $(".total_basic_salary").attr('data-basic-salary', Number(obj.basic_salary).toFixed());
            /* End */
            // Show Salary Part-1 Deposit  
            $('#diposit_status').val(obj.diposit_status);
            ((obj.total_deposit) <= 0 && obj.deposit_paid == 0) ? $(".row_total_deposit").hide(): $('.row_total_deposit').show();
            var deposit = ($('#diposit_status').val() != 'paid') ? parseFloat(Number(obj.total_deposit).toFixed()) : 0;
            $('#per_val1').text("Deposit (" + deposit + ") :");
            $('.total_deposit').attr('data-total-deposit', deposit);	

            var e_date = new Date(obj.employed_date);
            if(e_date.getDate() < 15){
                m = (e_date.getMonth())+1;
                y = e_date.getFullYear();
                var d = new Date("01-" + m + "-" + y);
            }else{
                m = (e_date.getMonth())+2;
                y = e_date.getFullYear();
                var d = new Date("01-" + m + "-" + y);
            }
            var c_date = new Date(("01 - " + obj.month_year_name).replaceAll(/\s/g, ''));
            const diffTime = Math.abs(c_date - d);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            (diffDays >= 365 && (obj.total_deposit) != 0 && obj.thisMonth_deduction == 0) ? $(".row_total_deposit").show(): $(".row_total_deposit").hide();
            if (obj.deposit_paid != 0) {
                $('.row_total_deposit').show();
                $('.remove_pay-deposit').show();
                $('#per_val1').text('Deposit :');
                $('.total_deposit').attr('data-total-deposit', Number(obj.deposit_paid).toFixed());
                $('.total_deposit').text(Number(obj.deposit_paid).toFixed());
            }
            /* End */

            // Show Salary Part-1 Deduction
            /* $("#per_val").text(Number(obj.deduction_percentage) + "% ");
            (obj.deduction_percentage == 0) ? $(".deduction_lable").hide(): $(".deduction_lable").show(); */
            $("#per_val").text(Number(obj.deduction_percentage) + "% ");
            // (obj.deduction_percentage == 0 && obj.thisMonth_deduction == 0) ? $(".deduction_lable").hide(): $(".deduction_lable").show();
            (obj.thisMonth_deduction == 0) ? $(".deduction_lable").hide(): $(".deduction_lable").show();

            var deduction_amount = (Number(obj.deduction_amount) == 0 || Number(obj.deduction_amount) == '') ? obj.thisMonth_deduction : obj.deduction_amount ;
            $(".total_deduction_per").text("-" + Number(deduction_amount).toFixed());
            $(".total_deduction_per").attr('data-deduction-per', Number(deduction_amount).toFixed());
            /* End */
            // Show Salary Part-1 Leave Deduction And Prof Text
            $(".total_prof_tax").text("-" + Number(obj.prof_tax).toFixed());
            $(".total_prof_tax").attr("data-prof-tax", Number(obj.prof_tax).toFixed());
            $(".total_deduction").attr('data-leave-deduction', Number(obj.total_leave_deduction).toFixed());
            $(".total_deduction").text("-" + Number(obj.total_leave_deduction).toFixed());
           
            /* End */
            
            /* End */
            // Show Salary And bonus Part-1 Total
            $("#bonus").val(Number(obj.bonus).toFixed());
            $(".total_net_salary").text((Number(obj.net_salary) + Number(obj.bonus)).toFixed());
            $(".total_net_salary").attr('data-total-salary', (Number(obj.net_salary) + Number(obj.bonus)).toFixed());
            /* End */
            /* End */

            /* Show Salary Right Part (Part-2)  */
            // Show Salary Part-2 Payout Paid Leave Amd Skip Leave
            $(".payout_paid_leave_amount").text(Number(obj.payout_paid_leave_amount).toFixed());
            $(".payout_paid_leave_amount").attr('data-payout_paid_leave_amount', Number(obj.payout_paid_leave_amount).toFixed());

            (obj.skip_paid_leave == '1') ? $("#skip_paid_leave").prop("checked", true): $("#skip_paid_leave").prop("checked", false);
            if (obj.payout_paid_leave_checkbox) {
                (obj.payout_paid_leave_checkbox == 'checked') ? $("#payout_paid_leave").prop("checked", true): $("#payout_paid_leave").prop("checked", false);
            } else {
                $("#payout_paid_leave").prop("checked", false);
            }
            $('.view_payout_paid_leave').text(Number(obj.payout_paid_leave_amount).toFixed());
            $('.view_payout_paid_leave').attr('data-leave-deduction', Number(obj.payout_paid_leave_amount).toFixed());
            if ($("#payout_paid_leave").is(":checked")) {
                $('.row_payout_paid_leave').show();
            } else {
                $('.row_payout_paid_leave').hide();
            }
            /* End */
            /* Baisc Detail */
            $(".employee_name").text(obj.name + '-' + obj.designation);
            $(".salary-month").text(obj.month_year_name);
            $('.salary_preloader').attr('style', 'display:none !important;');
            /* End */

            if (user_role == "admin") {
                $(".qr_code_image").html(obj.qr_code);
                if (obj.note_message) {
                    $(".note_paid_leave").html('<p class="text-danger">' + obj.note_message + '</p>');
                }
            }
            
        },
    });
}

$(document).on('click', '.pay-salary-btn', function() {

    var id = $(this).attr("data-id");
    $("#bonus").val("");
    $(".payout_paid_leave_amount").text("0");
    $(".total_plus_time").text("");
    $(".total_minus_time").text("");
    $(".total_plus_minus_time").text("");
    $(".total_working_day").text("");
    $(".total_official_holiday").text("");
    $(".total_effective_day").text("");
    $(".total_leave").text("");
    $(".total_paid_leave").text("");
    $(".total_sick_leave").text("");
    $(".total_approved_leave").text("");
    $(".total_unapproved_leave").text("");
    $(".total_absent_leave").text("");
    $(".employee_name").text("");
    $(".total_basic_salary").text("");
    $(".total_deduction_per").text("");
    $(".total_prof_tax").text("");
    $(".total_net_salary").text("");
    $(".total_net_salary").attr("data-total-salary", '');
    $(".total_deduction").text("");
    $(".total_deduction").text("");
    $(".per_val").text("");
    $('#payout_paid_leave').prop('checked', false);
    $('#diposit_status').val('pending');
    $(".note_paid_leave").html("");
    $('.total_deposit').attr('data-total-deposit', '0');
    $('.total_deposit').text("");
    $('.total_deposit').html('<button type="button" class="btn btn-default text-primary p-0 pay-deposit" data-pay-deposit="0">Pay Deposit</button>');
    $('.total_deposit').removeClass("added");
    $('.remove_pay-deposit').show();
    salary_pay_data(id);

    return false;

});

$('#payout_paid_leave').change(function() {
    var paid_leave_amount = $('.payout_paid_leave_amount').attr('data-payout_paid_leave_amount');
    var total_net_salary = $('.total_net_salary').attr('data-total-salary');
    $('.view_payout_paid_leave').text(0).attr('data-paid_leave_amount', 0);

    if ($(this).is(':checked')) {
        $('.view_payout_paid_leave').text(Number(paid_leave_amount).toFixed()).attr('data-paid_leave_amount', Number(paid_leave_amount).toFixed());
        // $('.view_payout_paid_leave').data('paid_leave_amount', Number(paid_leave_amount).toFixed());

        $('.total_net_salary').text((Number(total_net_salary) + Number(paid_leave_amount)).toFixed());
        $('.total_net_salary').attr('data-total-salary', (Number(total_net_salary) + Number(paid_leave_amount)).toFixed());

        $('.row_payout_paid_leave').show();
    } else {
        $('.view_payout_paid_leave').text(0).attr('data-paid_leave_amount', 0);
        // $('.view_payout_paid_leave').data('paid_leave_amount', 0);

        $('.total_net_salary').text((Number(total_net_salary) - Number(paid_leave_amount)).toFixed());
        $('.total_net_salary').attr('data-total-salary', (Number(total_net_salary) - Number(paid_leave_amount)).toFixed());

        $('.row_payout_paid_leave').hide();
    }
});

$(document).on('keyup', '#bonus', function() {
    addBonus($(this));
});

$(document).on('change', '#bonus', function() {
    addBonus($(this));
});

function addBonus($this) {
    var total_net_salary = $('.total_net_salary').data('total-salary');
    if ($this.val() != '') {
        var bonus = Number($this.val());
    } else {
        var bonus = 0;
    }
    var total_deposit = ($('#diposit_status').val() == 'paid') ? Number($('.total_deposit').attr('data-total-deposit').replace(/,/g, '')) : 0;
    var payout_paid_leave = ($('#payout_paid_leave').is(':checked')) ? Number($('.payout_paid_leave_amount').text().replace(/,/g, '')) : 0;
    var total_basic_salary = Number($(".total_basic_salary").attr('data-basic-salary').replace(/,/g, ''));

    var leave_deduction = Number($(".total_deduction").attr('data-leave-deduction').replace(/,/g, ''));
    var deduction = Number($(".total_deduction_per").attr('data-deduction-per').replace(/,/g, ''));
    var total_prof_tax = Number($(".total_prof_tax").attr('data-prof-tax').replace(/,/g, ''));

    var total_net_salary = (total_deposit + payout_paid_leave + total_basic_salary + bonus) - (leave_deduction + deduction + total_prof_tax);

    $(".total_net_salary").text(Number(total_net_salary).toFixed());
    $(".total_net_salary").data('total-salary', Number(total_net_salary).toFixed());
}

$(document).on('click', '.pay-deposit', function() {
    var total_salary = Number($('.total_net_salary').data('total-salary'));

    var total_deposit = ($('.total_deposit').attr('data-total-deposit') != '') ? Number($('.total_deposit').attr('data-total-deposit').replace(/,/g, '')) : 0;
    var total_deduction_per = ($('.total_deduction_per').attr('data-deduction-per') != '') ? Number($('.total_deduction_per').attr('data-deduction-per').replace(/,/g, '')) : 0;

    var total_net_salary = total_deposit + total_salary + total_deduction_per;

    $(".total_net_salary").text(Number(total_net_salary).toFixed());
    $(".total_net_salary").attr('data-total-salary', Number(total_net_salary).toFixed());
    $('#diposit_status').val('paid');
    $(".total_deposit").addClass("added");
    $(".total_deposit").text(total_deposit);
    $(this).hide();
    $('#per_val1').text('Deposit :');
    $('.deduction_lable').hide();
    $('.remove_pay-deposit').show();
});

$(document).on('click', '.remove_pay-deposit', function() {
    var total_salary = $('.total_net_salary').attr('data-total-salary');

    var total_deposit = ($('.total_deposit').attr('data-total-deposit') != '') ? Number($('.total_deposit').attr('data-total-deposit')) : 0;
    var total_deduction_per = ($('.total_deduction_per').attr('data-deduction-per') != '') ? Number($('.total_deduction_per').attr('data-deduction-per').replace(/,/g, '')) : 0;

    var total_net_salary = total_salary - (total_deduction_per + total_deposit);
    $(".total_net_salary").text(Number(total_net_salary).toFixed());
    $(".total_net_salary").attr('data-total-salary', Number(total_net_salary).toFixed());
    $(".total_deposit").removeClass("added");
    $(".total_deposit").html('<button type="button" class="btn btn-default text-primary p-0 pay-deposit" data-pay-deposit="' + total_deposit + '">Pay Deposit</button>');
    $('#diposit_status').val('pending')	;
    (total_deduction_per != '' && total_deduction_per != 0) ? $('.deduction_lable').show() : $('.deduction_lable').hide();
    $(this).hide();
    $('#per_val1').text('Deposit (' + Number(total_deposit).toFixed() + '):');
    $('.pay-deposit').show();
});

function setTooltip(message) {
    $('button').tooltip('hide')
        .attr('data-original-title', message)
        .tooltip('show');
}

function hideTooltip() {
    setTimeout(function() {
        $('button').tooltip('hide');
    }, 1000);
}



$(document).on('keypress', '#bonus', function(event) {
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});
/* view file code End */
