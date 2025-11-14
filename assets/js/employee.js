$.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
        var min = $('#myInputTextField').val()
        var age = data[2]; // use data for the age column
        if (age == min) {
            return true;
        }
        return false;
    }
);

jQuery(document).ready(function($) {

    if ($("#joining_date").val()) {
        var joining_date = $("#joining_date").val();
        if (joining_date != "" && joining_date != '0000-00-00') {
            var date_val = joining_date.split('-');
            var moth = date_val[1] - 1;
            $('#joining_date').datepicker().data('datepicker').selectDate(new Date(date_val[0], moth, date_val[2]));
        }else{
            $("#joining_date").val('');
        }
    }
    if ($("#employed_date").val()) {
        var employed_date = $("#employed_date").val();
        if (employed_date != "" && employed_date != '0000-00-00') {
            var date_val = employed_date.split('-');
            var moth = date_val[1] - 1;
            $('#employed_date').datepicker().data('datepicker').selectDate(new Date(date_val[0], moth, date_val[2]));
        }else{
            $("#employed_date").val('');
        }
    }

    if ($("#birth_date").val()) {
        var birth_date = $("#birth_date").val();
        if (birth_date != "" && birth_date != '0000-00-00') {
            var date_val = birth_date.split('-');
            var moth = date_val[1] - 1;
            $('#birth_date').datepicker().data('datepicker').selectDate(new Date(date_val[0], moth, date_val[2]));
        }else{
            $("#birth_date").val('');
        }
    }
    if ($("#increment_date").val()) {
        var increment_date = $("#increment_date").val();
        if (increment_date != "" && increment_date != '0000-00-00') {
            var date_val = increment_date.split('-');
            var moth = date_val[1] - 1;
            $('#increment_date').datepicker().data('datepicker').selectDate(new Date(date_val[0], moth, date_val[2]));
        }else{
            $("#increment_date").val('');
        }
    }
    if ($("#next_increment_date").val()) {
        var next_increment_date = $("#next_increment_date").val();
        if (next_increment_date != "" && increment_next_increment_datedate != '0000-00-00') {
            var date_val = next_increment_date.split('-');
            var moth = date_val[1] - 1;
            $('#next_increment_date').datepicker().data('datepicker').selectDate(new Date(date_val[0], moth, date_val[2]));
        }else{
            $("#next_increment_date").val('');
        }
    }
    //  var table = $('#example').DataTable({
    //         "processing": true,
    //         "serverSide": true,
    //         "rowReorder": {
    //             "selector": 'td:nth-child(2)'
    //         },
    //         "responsive": true,
    //         "lengthMenu": [ [10, 30, 50, 100], [10, 30, 50, 100] ],
    //         "pageLength": 30,
    //         "ajax":{
    //             "url": "employee/employee_pagination",
    //           	"dataType": "json",
    //           	"type": "POST",
    //         },
    //         stateSave: true,               
    //           "columns": [
    //                         { "data": "#" },
    //               { "data": "id" },
    //               { "data": "fname" },
    //               { "data": "email" },
    //               { "data": "list_attendance" },
    //               { "data": "login" },
    //               { "data": "action" },
    //               { "data": "status" },

    //            ],
    //   "columnDefs": [
    //             { "orderable": false, "targets": 0 }
    //           ]
    // }); 
    // $('.preloader-2').show();
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
            "url": "employee/employee_pagination_search",
            "dataType": "json",
            "type": "POST",
            "data": function(d) {
                d.designation = $("#designation").val();
                d.emp_status = $("#emp_status").val();
            },
        },
        stateSave: true,
        "columns": [
            { "data": "#" },
            { "data": "id" },
            { "data": "fname" },
            { "data": "email" },
            { "data": "list_attendance" },
            { "data": "login" },
            { "data": "action" },
            // { "data": "status" },

        ],
        "fixedHeader": true,
        "columnDefs": [
            { "orderable": false, "targets": [0, 4, 5, 6] }
        ]
    });
    table.order([3, 'asc']).draw();
    // table.order([2, 'desc'], [1, 'desc']).draw();
    // table.order( [ 4, 'desc' ],[ 1, 'desc' ] ).draw();
    // $('.preloader-2').hide();
    /* $('#myInputTextField').keyup( function() {
        table.draw();
    } ); */

    $('#myInputTextField').keyup(function() {
        $("#search1").val($(this).val());
        table.draw();

        //table.search($(this).val()).columns(3).draw() ;
    });
    $('#emp_status').change(function() {
        $('.preloader-2').attr('style', 'display:block !important;');
        table.clear();
        table.ajax.reload();
    });
    $('#designation').change(function() {
        $('.preloader-2').attr('style', 'display:block !important;');
        table.clear();
        table.ajax.reload();
    });



    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    $('.delete_All_checkbox').click(function(event) {
        if ($(this).val() == 'All_delete') {
            if ($(this).is(":checked")) {
                $('.delete_checkbox').each(function() {
                    $(this).prop("checked", true);
                });
            } else {
                $('.delete_checkbox').each(function() {
                    $(this).prop("checked", false);
                });
            }
        }
    });
    $('#example').on('draw.dt', function() {
        $('.delete_checkbox').change(function() {
            var checkbox = $('.delete_checkbox:checked');
            if (checkbox.length > 0) { $('#btn_delete').show(); } else { $('#btn_delete').hide(); }
        });
        $('.preloader-2').attr('style', 'display:none');
    });
    $('.delete_All_checkbox').change(function() {
        var checkbox = $('.delete_checkbox:checked');
        if (checkbox.length > 0) { $('#btn_delete').show(); } else { $('#btn_delete').hide(); }
    });
    $(document).on('click', '#btn_delete', function() {
        // if($('#multiple').val() == 'delete'){
        var checkbox = $('.delete_checkbox:checked');
        if (checkbox.length > 0) {
            var checkbox_value = [];
            $(checkbox).each(function() {
                checkbox_value.push($(this).val());
            });
            if (confirm("Are you sure you want to delete?")) {
                $('.preloader-2').attr('style', 'display:block !important;');
                jQuery(".loader-text").html("Deleting Employee");
                jQuery(".loader-wrap").show();
                // var id=$(this).attr("data-id");

                var data = {
                    'id': checkbox_value,
                };
                $.ajax({
                    url: "employee/delete_employee",
                    type: "post",
                    data: data,
                    success: function(response) {
                        $('#btn_delete').hide();
                        table.clear();
                        table.ajax.reload();
                        $('.preloader-2').attr('style', 'display:none');
                        // window.location.replace("employee");
                    },
                });
                // your deletion code
            }
        } else {
            alert('Select atleast one records For Delete');
        }
        return false;
        // }else{
        //       alert('Select Any one Option');
        // }
    });
    $("#employee-form").submit(function(e) {
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var email = $("#email").val();
        var personal_email = $("#personal_email").val();
        var passwords = $("#password").val();
        // var date_of_birth=$("#date_of_birth").val();
        /* var birth_year=$("#birth_year").val();
          var birth_day=$("#birth_day").val();
          var birth_month=$("#birth_month").val();
          var date_of_birth=$("#date_of_birth").val();
        //  var birth_year_val = date_of_birth.split('-');
          var joining_year=$("#joining_year").val();
          var joining_day=$("#joining_day").val();
          var joining_month=$("#joining_month").val();
         // var join_year_val = joining_date.split('-'); */
        var joining_date = $("#joining_date").val();
        var birth_date = $("#birth_date").val();

        var skype_account = $("#skype_account").val();
        var skype_password = $("#skype_password").val();
        var gmail_account = $("#gmail_account").val();
        var gmail_password = $("#gmail_password").val();
        var employee_status = $("#employee_status").val();
        var gender = true;
        $('#gender').each(function() {
            gender = gender && $(this).is(':checked');
        });
        //console.log(gender);
        var address = $("#address").val();
        var designation = $("#designation").val();
        var phone_number = $("#phone_number").val();
        var salary = $("#basic_salary").val();
        var deduction = $("#salary_deduction").val();
        var upi_type = $("#upi_type").val();
        var qrcode_name = $("#qrcode_name").val();
         var qrcode = $("#qrcode").val();
         var upi_id = $("#upi_id").val();
         var upi_regx = /^[\w.-]+@[\w.-]+$/;
        var flag = 0;
        var letters = /^[A-Za-z\s]+$/;
        
        var error_messages = '';
        if(fname.match(letters) && fname.length <= 50){$("#fname").removeClass('error');}else{$("#fname").addClass('error');flag++;}
        if(lname.match(letters) && lname.length <= 50){$("#lname").removeClass('error');}else{$("#lname").addClass('error');flag++;}
        if(phone_number.match(/^\d{10}$/)){$("#phone_number").removeClass('error');}else{$("#phone_number").addClass('error');flag++;}

        var regex = /^\S+@\S+\.\S+$/;
        if(regex.test(email) === false || email.length >= 254){$("#email").addClass('error');flag++;}else{$("#email").removeClass('error');}
        if(regex.test(personal_email) === false || personal_email.length >= 254){$("#personal_email").addClass('error');flag++;}else{$("#personal_email").removeClass('error');}
        if(regex.test(gmail_account) === false || gmail_account.length >= 254){$("#gmail_account").addClass('error');flag++;}else{$("#gmail_account").removeClass('error');}
        if(regex.test(skype_account) === false || skype_account.length >= 254){$("#skype_account").addClass('error');flag++;}else{$("#skype_account").removeClass('error');}
        
        if(address.length >= 200){$("#address").addClass('error');flag++;}else{$("#address").removeClass('error');}
            if (joining_date == '') {
                $("#joining_date").addClass('error');
                flag++;
            } else {
                $("#joining_date").removeClass('error');
            }

            if (designation == '') {
                $("#designation").addClass('error');
                flag++;
            } else {
                $("#designation").removeClass('error');
            }
            if (salary == '') {
                $("#basic_salary").addClass('error');
                flag++;
            } else {
                $("#basic_salary").removeClass('error');
            }
            if (deduction == '') {
                $("#salary_deduction").addClass('error');
                flag++;
            } else {
                $("#salary_deduction").removeClass('error');
            }
            if (employee_status == '') {
                $("#employee_status").addClass('error');
                flag++;
            } else {
                $("#employee_status").removeClass('error');
            }
            if (gmail_account == '') {
                $("#gmail_account").addClass('error');
                error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter gmail ID.</p></div></div></div>';
                flag++;
            } else {
                if (isEmail(gmail_account) == false) {
                    $("#gmail_account").addClass('error');
                    error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid gmail ID.</p></div></div></div>';
                    flag++;
                } else {
                    $("#gmail_account").removeClass('error');
                }
            }
            if (gmail_password == '') {
                $("#gmail_password").addClass('error');
                flag++;
            } else {
                $("#gmail_password").removeClass('error');
            }

            if (skype_account == '') {
                $("#skype_account").addClass('error');
                error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter skype mail ID.</p></div></div></div>';
                flag++;
            } else {
                if (isEmail(skype_account) == false) {
                    $("#skype_account").addClass('error');
                    error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid skype mail ID.</p></div></div></div>';
                    flag++;
                } else {
                    $("#skype_account").removeClass('error');
                }
            }

            if (skype_password == '') {
                $("#skype_password").addClass('error');
                flag++;
            } else {
                $("#skype_password").removeClass('error');
            }

            if ($("#increment_amount").val()) {
                var increment_amount = $("#increment_amount").val();
                var increment_date = $("#increment_date").val();
                
                if (increment_amount == '') {
                    $("#increment_amount").addClass('error');
                    flag++;
                } else {
                    $("#increment_amount").removeClass('error');
                }
                if (increment_date == '') {
                    $("#increment_date").addClass('error');
                    flag++;
                } else {
                    $("#increment_date").removeClass('error');
                }
            }
            
            if($('#js_data').data('role') != 'admin'){

                if (!upi_type) {
                    $("#upi_type").addClass('error');
                    flag++;
                } else {
                    $("#upi_type").removeClass('error');
                }
                if (!upi_id) {
                    $("#upi_id").addClass('error');
                    flag++;
                } else {
                    $("#upi_id").removeClass('error');
                }
                if (!(upi_id.match(upi_regx))) {
                    if (upi_id.length > 0) {
                        $("#upi_id").addClass('error');
                        error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid UPI ID</p></div></div></div>';
                        flag++;
                    }
                } else {
                    $("#upi_id").removeClass('error');
                }

                if(qrcode_name == '' && qrcode == ''){
                    flag++;
                    error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please your upload QR code.</p></div></div></div>';
                    $("#qrcode").addClass('error');
                } else {
                    $("#qrcode").removeClass('error');
                }
            }
            if(error_messages != ''){
                $(".msg-container").html(error_messages);
                 $('.msg-container .msg-box').attr('style', 'display:block');
                 setTimeout(function() {
                     $('.msg-container .msg-box').attr('style', 'display:none');
                 }, 6000);
            }
            
            if(flag == 0){
                return true;
            }else{
                return false;
            }
    });

    $(document).on('click', '.dropmenu-btn', function() {
        $(".drop-main-menu").toggleClass("active-drop");
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
                success: function(data, response) {
                    // console.log(data);
                    //   console.log(response);
                    if (response == "success") {
                        table.order([4, 'desc'], [1, 'desc']).draw();
                    }
                    // location.reload();
                }
            });
        }
    });
});
function contact_number_validate(id){
    var phoneno = /^\d{10}$/;
    if(($('#'+id).val()).match(phoneno)){
        $('#'+id).removeClass('error');
        return 1;
    }else{
        $('#'+id).addClass('error');
        return 0;
    }
}