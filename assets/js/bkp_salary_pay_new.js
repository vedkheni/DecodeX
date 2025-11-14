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
            "responsive": true,
            "lengthMenu": [
                [10, 30, 50, 100],
                [10, 30, 50, 100]
            ],
            "pageLength": 30,
            "ajax": {
                "url": base_url + "salary_pay_new/employee_pagination",
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
                { "data": "status" },
                { "data": "bankstatus" },
                { "data": "action" },
            ],
            "columnDefs": [{
                "targets": [4, 5],
                "orderable": false,
            }],

        });
        table.order([1, 'asc']).draw();
    } else {
        var table = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
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
                "url": base_url + "salary_pay_new/employee_pagination",
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
                { "data": "status" },
                // { "data": "bankstatus" },
                { "data": "action" },
            ],
            "columnDefs": [{
                "targets": [4],
                "orderable": false,
            }],

        });
        table.order([1, 'asc']).draw();
    }
    // table.order([0, 'desc']).draw();
    // }
    $(document).on('click', '.salary_payment_btn', function() {
        var id = $(this).attr("data-id");
        var payment_status = $(this).attr("data-payment-status");

        if ($("#skip_paid_leave").prop("checked")) {
            var skip_paid_leave = 1;
        } else {
            var skip_paid_leave = 0;
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
        var d = $(".total_deposit").text();
        if ($.isNumeric(d)) {
            var deposit = $(".total_deposit").text();
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
            'total_deposit': deposit,
            'skip_paid_leave': skip_paid_leave,
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
                    // table.order([0, 'desc']).draw();
                    $('.close.close_popup').click();
                } else {
                    setTooltip('Copied!');
                    hideTooltip();
                    //update message
                    //console.log(response);
                } 


            },

        });
       // emp_search1();

    });
    $(document).on('click', '.paid_to_bank', function() {
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
                table.order([0, 'desc']).draw();
                $('#massagae').html(response);
                $('.preloader-2').attr('style', 'display:none !important;');
                // window.location.replace("employee");
            },
        });
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
                // table.order([0, 'desc']).draw();
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
                table.order([0, 'desc']).draw();
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