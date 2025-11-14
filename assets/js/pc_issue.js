var base_url = $("#js_data").data('base-url');

$("#screenshorts").on("change", function() {
    var ss = $('#ss').val().split(',');
    if($('#ss').val() == ''){
        var len = 5;
    }else{
        var len  = 5-(ss.length);
    }
    if(0 >= len){
        alert("You Can't Select Any Images");
    }else{
        if($("#screenshorts")[0] != ''){
            if ($("#screenshorts")[0].files.length > len) {
                alert("You Can Select Only "+len+" Images");
            }else{
                var image_name = '';
                $.each($("#screenshorts")[0].files,function(i,v){
                    image_name += '<span>'+v.name+'</span>';
                });
                $('#image_name').html(image_name);
            }
        }else{
            $('#image_name').html('Upload Screenshot');
        }
    }
});
$('#emp_id').change(function(){
    getPC_id($(this));
});
if($('user_role').data('user_role') != 'admin'){
    getPC_id($('#emp_id'));
}
function getPC_id($this){
    $('.preloader-2').attr('style', 'display:block !important');
    var emp_id = $this.val();
    var data = {
        'emp_id': emp_id,
    };
    if(emp_id != ''){
        $.ajax({
            url: base_url+"pc_issue/getPC_id",
            type: "post",
            data: data ,
            success: function (response) {
                var obj = JSON.parse(response);
                if(obj.pc_data != ''){
                    $('.idofpc').text(obj.pc_data[0].pc_id);
                    if(obj.pc_data[0].pc_id != ''){
                        $('.row_pc_id').hide();
                    }
                    $('.title').text("Change");
                    $('#btn-change_id').text('Change');
                }else{
                    $('.row_pc_id').show();
                    $('.idofpc').text('');
                    $('.title').text("Add");
                    $('#btn-change_id').text('Add');
                }
                $('.preloader-2').attr('style', 'display:none !important');
            },
        });
    }else{
        $('.idofpc').text('');
        $('#btn-change_id').text('Add');
        $('.preloader-2').attr('style', 'display:none !important');
    }
}
function view_description($this){
    $('.preloader-2').attr('style', 'display:block !important');
        var description = $this.data('description');
        $('#full_description').text(description);
        $('#view_description').modal('show');
        $('.preloader-2').attr('style', 'display:none !important');
}
function status_chnage($this){
    $('.preloader-2').attr('style', 'display:block !important');
    var status = $this.data('status');
    var issue_id = $this.data('id');
    $('#issue_id').val(issue_id);
    $('#status option').each(function(){
        if($(this).val() == status){
            $(this).prop('selected',true);
        }
    });
    $('#change_status').modal('show');
    $('.preloader-2').attr('style', 'display:none !important');
}
$(document).ready(function($) {
    if ($(".text1 p").text() != ''){
		$('.msg-container .box1').attr('style','display:block');
		setTimeout(function() {
			$('.msg-container .box1').attr('style','display:none');
		}, 6000);
	}
	$('#issue').change(function(){
		if($(this).find('option:selected').val() == 'software'){
			$('#software').removeClass('d-none');
			$('#hardware').addClass('d-none');
		}else if($(this).find('option:selected').val() == 'hardware'){
			$('#hardware').removeClass('d-none');
			$('#software').addClass('d-none');
		}
	});
	$("#btn-issue_sub").click(function() {
        if($('#pc_id').val() != '' || $("#add_pc_id").val() != ''){
            $("#add_pc_id").removeClass('error');
            $pcId = ($('.idofpc').text() != '')?$('.idofpc').text():$("#add_pc_id").val();
            /* if(add_pc_id != ''){
                $("#pc_id").val(add_pc_id);
                $(".idofpc").text(add_pc_id);
                $("#change_pc_id").val(add_pc_id);
                $("#btn-change_id").click();
            } */
            $('.preloader-2').attr('style', 'display:block !important');
            var issue = $("#issue").val();
            $("#pc_id").val($pcId);

            parts = '';
            $("input[name='h_parts']:checked").each ( function(i,v) {
                if($("input[name='h_parts']:checked").length == (i+1)){
                    parts += $(this).val();
                }else{
                    parts += $(this).val() + ",";
                }
            });
            $('#parts').val(parts);
            var issue_description = $("#issue_description").val();
            var screenshorts = $("#screenshorts").val();
            var pc_id = $("#pc_id").val()
            var id = $("#id").val();
            var ss = $("#ss").val();
            var flag = 0;
            
            if (!$pcId) {
                $('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>First add your PC ID.</p></div></div></div>');
                $('.msg-container .msg-box').attr('style','display:block');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style','display:none');
                }, 6000);
                flag++;
            } else {
                //$('.msg-container .msg-box').attr('style','display:none');
            }
            if (!issue) {
                $("#issue").addClass('error');
                flag++;
            } else {
                $("#issue").removeClass('error');
            }
            if(issue != '' && issue == 'hardware'){
                if (!parts) {
                    $('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please select hardware parts.</p></div></div></div>');
                    $('.msg-container .msg-box').attr('style','display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style','display:none');
                    }, 6000);
                    flag++;
                }else{
                    //$('.msg-container .msg-box').attr('style','display:none');
                }
            }else if(issue != '' && issue == 'software'){
                var ss = $('#ss').val().split(',');
                if($('#ss').val() == ''){
                    var len = 5;
                }else{
                    var len  = 5-(ss.length);
                }
                if(0 >= len){
                    alert("You Can't Select Any Images");
                }else{
                    if ($("#screenshorts")[0].files.length > len){
                        alert("You Can Select Only "+len+" Images");
                        $("#screenshorts").parent().addClass('error');
                        flag++;
                    }else{
                        if(id == ''){
                            $('.msg-container .msg-box').attr('style','display:none');
                            if (!screenshorts) {
                                $("#screenshorts").parent().addClass('error');
                                flag++;
                            } else {
                                $("#screenshorts").parent().removeClass('error');
                            }
                        }else{
                            if(ss == '' && !screenshorts){
                                $("#screenshorts").parent().addClass('error');
                                flag++;
                            }else{
                                $("#screenshorts").parent().removeClass('error');
                            }
                        }
                    }
                }
            }
            if (!issue_description) {
                $("#issue_description").addClass('error');
                flag++;
            } else {
                if(issue_description.length >= 200){
                    $("#issue_description").addClass('error');
                    flag++;
                }else{
                    $("#issue_description").removeClass('error');
                }
            }
            // var flag = 0;
            if(flag == 0)
            {
                $pcId = ($('.idofpc').text() != '')?$('.idofpc').text():$("#add_pc_id").val();
                if(confirm("Your pc id is "+$pcId+" , Are you sure about pc id?")){
                    $("#pc_issue-form").submit();
                }else{
                    $('.preloader-2').attr('style', 'display:none !important');
                    return false;
                }
            }else{
                $('.preloader-2').attr('style', 'display:none !important');
                return false;
            }
        }else{
            $("#add_pc_id").addClass('error');
            $('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>First add your PC ID.</p></div></div></div>');
            $('.msg-container .msg-box').attr('style','display:block');
            setTimeout(function() {
                $('.msg-container .msg-box').attr('style','display:none');
            }, 6000);
        }
    });
});

$("#pc_issue-form").submit(function(){
    $('.preloader-2').attr('style', 'display:block !important');
    $.ajax({
        url: base_url+"pc_issue/insert_data",
        type: "post",
        data:new FormData(this),
        processData:false,
        contentType:false,
        cache:false,
        // async:false,
        success: function (response) {
        var obj = JSON.parse(response);
            if(obj.error_code == 0){
                $('.msg-container').html(obj.message);
                $('.msg-container .msg-box').attr('style','display:block');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style','display:none');
                }, 6000);
                $('.close_popup').click();
                table.clear();
                table.ajax.reload();
                table1.clear();
                table1.ajax.reload();
                $('.preloader-2').attr('style', 'display:none !important');
            }else{
                $('.msg-container').html(obj.message);
                $('.msg-container .msg-box').attr('style','display:block');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style','display:none');
                }, 6000);
                $('.preloader-2').attr('style', 'display:none !important');
            }
        },
    });
    return false;
});

$('.preloader-2').attr('style', 'display:block !important');
var table = $('#example').DataTable({
    "oLanguage": {
        "sLengthMenu": "Show _MENU_ Entries",
        },
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
        "url": "pc_issue/list_pcIssue",
        "dataType": "json",
        "type": "POST",
        "data": function(d) {
        },
    },
    stateSave: true,
    "columns": [
        { "data": "#"},
        { "data": "type_issue"},
        { "data": "issue"},
        { "data": "description" },
        { "data": "pc_id" },
        { "data": "status" },
        { "data": "action" },

    ],
    "fixedHeader": true,
    "columnDefs": [
        { "orderable": false, "targets": [0, 1, 4,] }
    ]
});
$('.preloader-2').attr('style', 'display:block !important');
var table1 = $('#pc_issue_list').DataTable({
    "oLanguage": {
        "sLengthMenu": "Show _MENU_ Entries",
        },
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
        "url": "pc_issue/list_pcIssue",
        "dataType": "json",
        "type": "POST",
        "data": function(d) {
        },
    },
    stateSave: true,
    "columns": [
        { "data": "#"},
        { "data": "employee"},
        { "data": "type_issue"},
        { "data": "issue"},
        { "data": "description" },
        { "data": "pc_id" },
        { "data": "status" },
        { "data": "action" },

    ],
    "fixedHeader": true,
    "columnDefs": [
        { "orderable": false, "targets": [0, 1, 4,] }
    ]
});

table.order([2, 'desc']).draw();
$('#example').on('draw.dt', function() {
    $('.view_description').click(function(){
        view_description($(this));
    });
    $('.edit').click(function(){
        getIssue($(this));
    });
    $('.preloader-2').attr('style', 'display:none !important');
});
table1.order([2, 'desc']).draw();
$('#pc_issue_list').on('draw.dt', function(){
    $('.delete_pc_issue').click(function(){
        delete_pc_issue($(this));
    });
    $('.view_description').click(function(){
        view_description($(this));
    });
    $('.edit_pc_issue').click(function(){
        getIssue($(this));
    });
    $('.change_status').click(function(){
        status_chnage($(this));
    });
    $('.preloader-2').attr('style', 'display:none !important');
});
$('#candidate-form1').on('submit', function(e){  
    e.preventDefault(); 
    $('.preloader-2').attr('style', 'display:block !important');
    var id = $('#id').val();
    var i_s_id = $('#i_s_id').val();
    var name = $('#name').val();
    var designation = $('#designation').val();
    var email = $('#email').val();
    var gender = $('#gender').val();
    var experience = $('#experience').val();
    var phone_number = $('#phone_number').val();
    var address = $('#address').val();
    var current_salary = $('#current_salary').val();
    var expected_salary = $('#expected_salary').val();
    var upload_resume_name = $('#upload_resume_name').val();
    var upload_resume = $('#upload_resume').val();
    var skills = $('#skills').val();
    var interview_date = $('#interview_date').val();

    if(upload_resume != '' && upload_resume_name != ''){
        var massage_box = ['upload_resume'];
    }else{
        var massage_box = [];
    }
    var data = {
        'id': id,
        'name': name,
        'designation': designation,
        'email': email,
        'gender': gender,
        'experience': experience,
        'phone_number': phone_number,
        'address': address,
        'current_salary': current_salary,
        'expected_salary': expected_salary,
        'upload_resume_name': upload_resume_name,
        'upload_resume': upload_resume,
        'skills': skills,
        'interview_date': interview_date,
        'i_s_id': i_s_id,
    };
    $.ajax({
        url: base_url+"candidates/update",
        type: "post",
        data:new FormData(this),
        processData:false,
        contentType:false,
        cache:false,
        // async:false,
    success: function (response) {
        var obj = JSON.parse(response);
        if(obj.error_code == 0){
            if(obj.insert_id){
                $('#hrround_id').val(obj.insert_id);
                $('#tcround_id').val(obj.insert_id);
                $('#fround_id').val(obj.insert_id);
                $('#i_s_id').val(obj.insert_id);
            }
            $('.msg-container').html(obj.message);
                $('.msg-container .msg-box').attr('style','display:block');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style','display:none');
                }, 6000);
                /* $('.close_popup').click();*/
                $('#next').val('hr_round');
                $('#previous').val('hr_round');
                $('#candidate_name').text($('#name').val());
                $('.schedule_date').text($('#interview_date').val());
                $('#btn_previous').show();
                $('#hr_round').removeClass('disabled');
                $('#hr_round').click();
                tab_validation();
                table.clear();
                table.ajax.reload();
                $('.preloader-2').attr('style', 'display:none !important');
            }else{
                $('.msg-container').html(obj.message);
                $('.msg-container .msg-box').attr('style','display:block');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style','display:none');
                }, 6000);
                $('.preloader-2').attr('style', 'display:none !important');
            }
        },
    });
});
/* Delete */
function delete_pc_issue($this){
    if (confirm("Are you sure want to delete?")) {
        /* var checkbox = $('.candidate_check:checked');
        if (checkbox.length > 0) {
            var checkbox_value = [];
            $(checkbox).each(function() {
                checkbox_value.push($(this).val());
            });
            var id = checkbox_value.toString(); */
            $('.preloader-2').attr('style', 'display:block !important;');
            var base_url = $("#js_data").data('base-url');
            var id = $this.data('id');
            var data = { 'id': id };
            $.ajax({
                url: base_url + "pc_issue/delete_pcIssue",
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
                        table1.clear();
                        table1.ajax.reload();
                        $('.preloader-2').attr('style', 'display:none !important');
                    }else{
                        $('.msg-container').html(obj.message);
                        $('.msg-container .msg-box').attr('style','display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style','display:none');
                        }, 6000);
                        $('.preloader-2').attr('style', 'display:none !important');
                    }
                    checkbox_check();
                },
            });
        /* } else {
            alert('Select atleast one records For Delete');
        } */
    }
}

function change_issue_status(){
    $('.preloader-2').attr('style', 'display:block !important;');
    var base_url = $("#js_data").data('base-url');
    var status = $('#status').val();
    var issue_id = $('#issue_id').val();
    var data = { 'status': status, 'id':issue_id };
    $.ajax({
        url: base_url + "pc_issue/changeStatus",
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
                table1.clear();
                table1.ajax.reload();
                $('.close').click();
                $('.preloader-2').attr('style', 'display:none !important');
            }else{
                $('.msg-container').html(obj.message);
                $('.msg-container .msg-box').attr('style','display:block');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style','display:none');
                }, 6000);
                $('.preloader-2').attr('style', 'display:none !important');
            }
            checkbox_check();
        },
    });
}

function getIssue($this){
    $('.preloader-2').attr('style', 'display:block !important;');
    reset_form();
    var id = $this.data('id');
    var pc_id = $this.data('pc_id');
    var data = { 'id': id, 'pc_id':pc_id };
    if(id != '' && id != undefined && pc_id != ''){
        $.ajax({
            url: base_url + "pc_issue/getIssue",
            type: "post",
            data: data,
            success: function(response) {
                var obj = JSON.parse(response);
                if(obj.list_data != ''){
                    $('#employee_id').val(obj.list_data[0].employee_id);
                    $('#id').val(obj.list_data[0].id);
                    $('#ss').val(obj.list_data[0].screenshorts);
                    $('#parts').val(obj.list_data[0].hardware_part);
                    $('#pc_id').val(obj.list_data[0].pc_id);
                    $('#idofpc_1').text(obj.list_data[0].pc_id);
                    $('.idofpc').text(obj.list_data[0].pc_id);
                    $('#issue_description').val(obj.list_data[0].description);
                    $('#issue option').each(function(){
                        if($(this).val() == obj.list_data[0].issue){
                            $(this).prop('selected',true);
                        }
                    });
                    
                    if(obj.list_data[0].pc_id != ''){
                        $('.row_pc_id').hide();
                    }

                    if(obj.list_data[0].issue == 'hardware'){
                        var hardware_part = (obj.list_data[0].hardware_part).split(",");
                        $('input[name="h_parts"]').each(function(){
                            if(jQuery.inArray($(this).val(), hardware_part) >= 0){
                                $(this).prop('checked',true);
                            }
                        });
                        $('#software').addClass('d-none');
                        $('#hardware').removeClass('d-none');
                    }else{
                        var screenshorts = (obj.list_data[0].screenshorts).split(",");
                        var html = '';
                        $.each(screenshorts,function(i,v){
                            html += '<div class="issue-img-box" id="img-box"><button type="button" class="btn remove-img remove_img" data-image_name="'+v+'"><i class="fas fa-trash-alt"></i></button>'+
                            '<a href="'+base_url+'assets/upload/issue_ss/'+v+'" data-fancybox="image_group">'+
                            '<img src="'+base_url+'assets/upload/issue_ss/'+v+'" alt="issue Image">'+
                            '</a></div>';
                        });
                        $('#thum_image').html(html);
                        $('#hardware').addClass('d-none');
                        $('#software').removeClass('d-none');
                    }
                    table1.clear();
                    table1.ajax.reload();
                    $('#btn-issue_sub').text('Update');
                    $('#btn-issue_sub .title').text('Update');
                    $('#add-pc-issue').modal('show');
                    $('.preloader-2').attr('style', 'display:none !important');
                }else{
                    $('.row_pc_id').show();
                    $('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Data not found!</p></div></div></div>');
                    $('.msg-container .msg-box').attr('style','display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style','display:none');
                    }, 6000);
                    $('.preloader-2').attr('style', 'display:none !important');
                }
            },
        });
    }else{
        $('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Data not found!</p></div></div></div>');
        $('.msg-container .msg-box').attr('style','display:block');
        setTimeout(function() {
            $('.msg-container .msg-box').attr('style','display:none');
        }, 6000);
        $('.preloader-2').attr('style', 'display:none !important');
    }
}

$('body').on("click",".remove_img",function(){
    var image_name = $(this).data('image_name');
    var ss = ($('#ss').val()).split(',');
    var new_ss = [];
    $.each(ss,function(i,v){
        if(v != image_name){
            new_ss.push(v);
        }
    });
    $(this).parents('#img-box').hide();
    $('#ss').val(new_ss.join(','));
});
function reset_form(){
    $('#pc_issue-form')[0].reset();
    $('#thum_image').empty();
    $('#image_name').text('Upload Screenshot');
    $('#id').val('');
    $('#ss').val('');
    ($('#pc_id').val() != '')?$('#row_pc_id').hide():$('#row_pc_id').show();
    $('input[name="h_parts"]').prop('checked',false);
    $('#hardware').removeClass('d-none');
    $('#software').addClass('d-none');
    getPC_id($('#employee_id'));
}