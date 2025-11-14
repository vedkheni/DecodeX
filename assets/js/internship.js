function resetFormModal(){
    $("#internship_id").val('');
    $("#name").val('');
    $("#email").val('');
    $("#contact_number").val('');
    $("#address").val('');
    $("#address").html('');
    $("#college_or_university option:eq(0)").prop('selected',true);
    $("#course option:eq(0)").prop('selected',true);
    $("#feedback").val('');
    $("#feedback").html('');
    var currentDate = new Date();
    $('#internship_start_date').datepicker().data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()));
    $('#internship_end_date').datepicker().data('datepicker').selectDate(null);
    $("#feedback_status option:eq(0)").prop('selected',true);
    $('.internformtitle').text('Add Intern');
    $('.internship-submit').text('Submit');
}

jQuery(document).ready(function ($) {
	var base_url=$("#js_data").attr("data-base-url");
    var table = $('#example_tbl').DataTable({
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
            "url": base_url+'internship/intern_list',
            "dataType": "json",
            "type": "POST",
            // "data": function(d) {
            //     d.designation = $("#designation").val();
            //     d.emp_status = $("#emp_status").val();
            // },
        },
        stateSave: true,
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "contact_number" },
            { "data": "email" },
            { "data": "course" },
            { "data": "internship_start_date" },
            { "data": "feedback_status" },
            { "data": "action" },

        ],
        "fixedHeader": true,
        "columnDefs": [
            { "orderable": false, "targets": [0, 2, 5, 7] }
        ]
    });

    // table.order([1, 'asc']).draw();


	var role=$("#js_data").attr("data-role");
	var emp_id=$("#emp-id").val();
	// var table = $('#example_tbl').DataTable({"fixedHeader": true,});
    
    if ($('input').is('#internship_start_date,#internship_end_date')) {
        $('#internship_start_date,#internship_end_date').datepicker({
            dateFormat: $('#js_data').data('dateformat'),
        });
    }
    if ($('#internship_end_date').data('date') != undefined && $('#internship_end_date').data('date') != '') {
        var currentDate = new Date($('#internship_end_date').data('date'));
        $('#internship_end_date').datepicker().data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()));
    }
    if ($('#internship_start_date').data('date') != undefined && $('#internship_start_date').data('date') != '') {
        var currentDate = new Date($('#internship_start_date').data('date'));
        $('#internship_start_date').datepicker().data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()));
    }

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
	
    $(document).on('click','.internship-submit',function(e){
        e.preventDefault();
        $('.btn-toggel').hide();
        var name = ($("#name").val() != undefined) ? ($("#name").val()).trim() : '';
        var email = ($("#email").val() != undefined) ? ($("#email").val()).trim() : '';
        var contact_number = ($("#contact_number").val() != undefined) ? ($("#contact_number").val()).trim() : '';
        var address = ($("#address").val() != undefined) ? ($("#address").val()).trim() : '';
        var college_or_university = ($("#college_or_university").val() != undefined) ? ($("#college_or_university").val()).trim() : '';
        var course = ($("#course").val() != undefined) ? ($("#course").val()).trim() : '';
        var internship_start_date = ($("#internship_start_date").val() != undefined) ? ($("#internship_start_date").val()).trim() : '';
        var error_messages = '';
        $flag = 0;
        if (!name) {
            $("#name").addClass('error');
            error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter name</p></div></div></div>';
            $flag++;
        } else {
            $("#name").removeClass('error');
        }
        if (!email) {
            $("#email").addClass('required');
            error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter email</p></div></div></div>';
            $flag++;
        } else {
            if (isEmail(email) == false) {
                $("#email").addClass('required');
                error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid email</p></div></div></div>';
                $flag++;
            } else {
                $("#email").removeClass('required');
            }
        }

        if (!contact_number) {
            $("#contact_number").addClass('required');
            error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter contact number.</p></div></div></div>';
            $flag++;
        } else {
            if (!($.isNumeric(contact_number))) {
                $("#contact_number").addClass('required');
                error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid contact number.</p></div></div></div>';
                $flag++;
            } else {
                $("#contact_number").removeClass('required');
            }
        }

        if (!address) {
            $("#address").addClass('error');
            error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter address</p></div></div></div>';
            $flag++;
        } else {
            $("#address").removeClass('error');
        }
        
        if (!college_or_university) {
            $("#college_or_university").addClass('error');
            error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please select college/university</p></div></div></div>';
            $flag++;
        } else {
            $("#college_or_university").removeClass('error');
        }
        
        if (!course) {
            $("#course").addClass('error');
            error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please select course</p></div></div></div>';
            $flag++;
        } else {
            $("#course").removeClass('error');
        }
        
        if (!internship_start_date) {
            $("#internship_start_date").addClass('error');
            error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter internship start date</p></div></div></div>';
            $flag++;
        } else {
            $("#internship_start_date").removeClass('error');
        }

        if($flag > 0){
            $(".msg-container").html(error_messages);
            $('.msg-container .msg-box').attr('style', 'display:block');
            setTimeout(function() {
                $('.msg-container .msg-box').attr('style', 'display:none');
            }, 6000);
            return false;
        }else{
            $('.preloader-2').attr('style','display:block !important;');
            $('.internship-submit').prop('disabled', true);	
            $.ajax({
            url : base_url+'internship/insert_intern',
            type : 'post',
            data : $("#internship_form").serialize(),
            success : function(response){
                var obj = JSON.parse(response);
                if(obj.error_code == 0){
                    var insert_id = obj.id;
                    $('.msg-container').html(obj.message);
                    $('.msg-container .msg-box').attr('style','display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style','display:none');
                    }, 6000);
                    
                    $('.internship-submit').prop('disabled', false);
                    $('#myModal_internship').modal('hide');
                    $('.preloader-2').attr('style','display:none !important;');
                    $('.close').click();
                    table.clear();
                    table.ajax.reload();
                    resetFormModal();
                }else{
                    $('.msg-container').html(obj.message);
                    $('.msg-container .msg-box').attr('style','display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style','display:none');
                    }, 6000);
                    $('.preloader-2').attr('style', 'display:none !important');
                    $('.internship-submit').prop('disabled', false);
                }
            }
            });
        }
    });

    $(document).on('click', '.edit-intern-detail', function(){
        $('.table-loader').attr('style', 'display:block !important');
        resetFormModal();
        var id = $(this).data('id');
        var data = {
            'id' : id,
        };
        $.ajax({
            url: base_url+"internship/get_intern_detail",
            type: "post",
            data: data ,
            success: function (response) {
                var obj = JSON.parse(response);
                if(obj.error_code == 0){
                    $("#internship_id").val(obj.detail[0].id);
                    $("#name").val(obj.detail[0].name);
                    $("#email").val(obj.detail[0].email);
                    $("#contact_number").val(obj.detail[0].contact_number);
                    $("#address").val(obj.detail[0].address);
                    $("#address").html(obj.detail[0].address);

                    $("#college_or_university option").each(function(i,v){
                        $(this).val() == obj.detail[0].college_or_university ? $(this).prop('selected',true) : '';
                    });

                    $("#course option").each(function(i,v){
                        $(this).val() == obj.detail[0].course ? $(this).prop('selected',true) : '';
                    });

                    $("#feedback").val(obj.detail[0].feedback);
                    $("#feedback").html(obj.detail[0].feedback);

                    
                    if (obj.detail[0].internship_start_date != '' && obj.detail[0].internship_start_date != '0000-00-00') {
                        var currentDate = new Date(obj.detail[0].internship_start_date);
                        $('#internship_start_date').datepicker().data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()));
                    }
                    if (obj.detail[0].internship_end_date != '' && obj.detail[0].internship_end_date != '0000-00-00') {
                        var currentDate = new Date(obj.detail[0].internship_end_date);
                        $('#internship_end_date').datepicker().data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()));
                    }
                    (obj.detail[0].feedback_status == 'done') ? $("#feedback_status option:eq(1)").prop('selected',true) : $("#feedback_status option:eq(0)").prop('selected',true);
                    
                    $('.internformtitle').text('Edit Intern');
                    $('.internship-submit').text('Update');
                    $('#myModal_internship').modal('show');
                }else{
                    $('.msg-container').html(obj.message);
                    $('.msg-container .msg-box').attr('style','display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style','display:none');
                    }, 6000);
                    $('.preloader-2').attr('style', 'display:none !important');
                    $('.internship-submit').prop('disabled', false);
                }
                $('.table-loader').attr('style', 'display:none !important');
            },
        });
    });
    
    $(document).on('click', '.show-intern-detail', function(){
        $("#intern_name,#intern_contact_number,#intern_email,#intern_address,#intern_college_or_university,#internship_course,#internship_date,#intern_feedback_status,#intern_feedback").html('');
        $('.table-loader').attr('style', 'display:block !important');
        var id = $(this).data('id');
        var data = {
            'id' : id,
        };
        $.ajax({
            url: base_url+"internship/get_intern_detail",
            type: "post",
            data: data ,
            success: function (response) {
                var obj = JSON.parse(response);
                if(obj.error_code == 0){
                    
                    internship_date = '';
                    
                    if (obj.detail[0].internship_start_date != '' && obj.detail[0].internship_start_date != '0000-00-00') {
                        internship_date += obj.detail[0].start_date;
                    }
                    if (obj.detail[0].internship_end_date != '' && obj.detail[0].internship_end_date != '0000-00-00') {
                        internship_date += ' to '+obj.detail[0].end_date;
                    }

                    $("#intern_name").html(obj.detail[0].name);
                    $("#intern_contact_number").html(obj.detail[0].contact_number);
                    $("#intern_email").html(obj.detail[0].email);
                    $("#intern_address").html(obj.detail[0].address);
                    $("#intern_college_or_university").html(obj.detail[0].college_or_university);
                    $("#internship_course").html(obj.detail[0].course);
                    $("#internship_date").html(internship_date);
                    // $("#intern_feedback_status").html(obj.detail[0].feedback_status);
                    $("#intern_feedback").html(obj.detail[0].feedback == '' ? obj.detail[0].feedback_status : obj.detail[0].feedback);

                    $('#intern_detail_modal').modal('show');
                }else{
                    $('.msg-container').html(obj.message);
                    $('.msg-container .msg-box').attr('style','display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style','display:none');
                    }, 6000);
                    $('.preloader-2').attr('style', 'display:none !important');
                    $('.internship-submit').prop('disabled', false);
                }
                $('.table-loader').attr('style', 'display:none !important');
            },
        });
    });
});


$(document).on('click', '.delete-intern', function(){
	var internship_id = $(this).data('id');
	var data = {
        'id' : internship_id,
    };
	if(internship_id && confirm('Are you sure you want to delete?')){
		$.ajax({
			url: base_url+"internship/delete_intern",
			type: "post",
			data: data ,
			success: function (response) {
				$('.msg-container').html(response);
				$('.msg-container .msg-box').attr('style','display:block');
				setTimeout(function() {
					$('.msg-container .msg-box').attr('style','display:none');
				}, 6000);
                table.clear();
                table.ajax.reload();
			},
		});
	}
});