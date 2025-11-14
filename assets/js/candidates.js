var base_url = $("#js_data").data('base-url');
var hr_skills = ['Good Communication', 'Interpersonal Skills', 'Time Management',];
// var hr_skills = ['Good Communication', 'Screening', 'Sourcing', 'Interpersonal Skills', 'Selection Process', 'Time Management', 'Hiring', 'Recruitment', 'Convincing Power',];
function getFileData(myFile){
    var file = myFile.files[0];  
    var filename = file.name;
    $('#upload-text span').text(filename);
}
jQuery('#address').keyup(function(){
    if(text_validate($(this).val())){
        $(this).removeClass('error');
    }else{
        $(this).addClass('error');
    }
});
jQuery(document).ready(function($) {
    $('#date').data('datepicker');
    $('#interview_date').datepicker({
        dateFormat: 'dd M, yyyy',
        language: 'en',
     });        
    $('#joining_date').datepicker({
        dateFormat: 'dd M, yyyy',
        language: 'en',
     });    
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });
      addskills_set('hr_skills');
	// $('#example').DataTable();
    if ($("#interview_date").val()) {
        var interview_date = $("#interview_date").val();
        if (interview_date != "") {
            var date_val = interview_date.split('-');
            var moth = date_val[1] - 1;
            //$(interview_date).datepicker().data('datepicker').selectDate(new Date(date_val[0], moth, date_val[2]));
        }
    }
    $('#btn_next').click(function(){
        if($('#next').val() == 'candidate_info'){
             // if(input_validate(arr,message_box) == 0){
                $('#candidate-form1').submit();
                $("input[name='hrm-select']").prop('checked',false);
            // }
        }else if($('#next').val() == 'hr_round'){
            // var arr = ['hr_feedback'];
            // var message_box = ['hr_skills','interview_status'];
            // if(input_validate(arr,message_box) == 0){
                if($('#interview_date').val() != ''){
                    skills_val(hr_skills,'hr_skills');
                    form_submit2();
                    $('#technical_round').removeClass('disabled');
                }else{
                    $('#technical_round').addClass('disabled');
                }
                
            // }
        }else if($('#next').val() == 'technical_round'){
            // var arr = ['technical_feedback'];
            // var message_box = ['technical_skill','taken_by'];
            // if(input_validate(arr,message_box) == 0){
                var skill = ($('#skills').val()).split(", ");
                skills_val(skill,'technical_skill');
                form_submit3();
                $('#final_round').removeClass('disabled');
                $("input[name='final-select']").prop('checked',false);
            // }
        }else if($('#next').val() == 'final_round'){
             form_submit4();
        }
    });
    $('#btn_previous').click(function(){
        if($('#previous').val() == 'candidate_info'){
            
        }else if($('#previous').val() == 'hr_round'){
             $('#candidate_info').click();
             $('#next').val('candidate_info');
             $('#previous').val('candidate_info');
        }else if($('#previous').val() == 'technical_round'){
            $('#hr_round').click();
            $('#next').val('hr_round');
            $('#previous').val('hr_round');
        }else if($('#previous').val() == 'final_round'){
            $('#technical_round').click();
            $('#next').val('technical_round');
            $('#previous').val('technical_round');
            // form_submit();
         }
    });
    /* ==================================== ========================================== */

    //var tagArea = '.tag-area';
    // select_designation();
    $('#designation').change(function(){
        select_designation();
    });
    $('#schedule_type').change(function(){
        $('.preloader-2').attr('style', 'display:block !important');
        table.clear();
        table.ajax.reload();
    });
    
    $('#select_designation').change(function(){
        $('.export_excel').attr('href',base_url+'/export_excel/candidates_excel/'+$(this).val());
        $('.preloader-2').attr('style', 'display:block !important');
        table.clear();
        table.ajax.reload();
    });
    
});
$('#date').datepicker({
    language: 'en',
    onSelect: function onSelect(fd, date) {
        $('.preloader-2').attr('style', 'display:block !important');
        table.clear();
        table.ajax.reload();
    }
});
function onclick_run(text,id,name,designation,experience){
    var num = 0;
    var arr1 = ['id','name','designation','email','gender','experience','phone_number','address','current_salary','expected_salary','skills','interview_date'];
    var arr2 = ['hr_feedback','hr_skills','interview_status'];
    var arr3 = ['technical_feedback','technical_skill','taken_by'];
    if(text == 'hr_round'){
        if(check_validate(arr1)){
            num++;return false;
        }
    }
    if(text == 'technical_round'){
        if(check_validate(arr2) || check_validate(arr1)){
            num++;
        }
    }
    if(text == 'final_round'){
        if(check_validate(arr3) || check_validate(arr2) || check_validate(arr1)){
            num++;return false;
        }
        var taken_by = '';
        $("input[name='taken_by[]']:checked").each(function(i,v){
            taken_by += '<span>'+$(this).val()+'</span>';
        });
        $('#taken_by_view').html(taken_by);
        if($('#final_reject').is(':checked')){
            $('#reject_to_hide').hide();
        }else{
            $('#reject_to_hide').show();
        }
    }
    if(num == 0){
        $('#next').val(text);$('#previous').val(text);
        $('#'+name).text($('#name').val());
        $('#'+designation).text($('#designation option:selected').text());
        $('#'+experience).text(get_month_year($('#experience').val()));
        var $target_id = $('#'+id).data('href');
        $('.tab-pane').removeClass('active');
        $('#'+$target_id).addClass('active');
    }
}
function addskills_set(key){
    if(key == 'hr_skills'){
        var skills = hr_skills;
        var id = 'rating_html';
        $('#candidate_name').text($('#name').val());
        $('.schedule_date').text($('#interview_date').val());
    }else if(key == 'skills'){
        var skill = ($('#skills').val()).split(", ");
        var skills = skill;
        var id = 'rating_html1';
        $('#candidate_name1').text($('#name').val());
        $('.schedule_date').text($('#interview_date').val());
    }

    var html = '<div class="col-12"><h3 class="mt-0">Skill Set</h3></div>';
    $.each(skills,function(i,v){
        if(v != '' && v != ' '){
            var name = ((v.toLowerCase()).replace(/\s/g,'_')).replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');
            html += '<div class="col-lg-6 col-12">'+
            '<div class="rating-box analytics-info">'+
            '<h3 class="title">'+v+'</h3>'+
            '<fieldset class="rating rate">'+
            '<input type="radio" id="'+name+(i+1)+'_star5" name="'+name+(i+1)+'" value="5" /><label class="full" for="'+name+(i+1)+'_star5"title="Awesome - 5 stars"></label>'+
            '<input type="radio" id="'+name+(i+1)+'_star4half" name="'+name+(i+1)+'" value="4.5" /><label class="half" for="'+name+(i+1)+'_star4half" title="Pretty good - 4.5 stars"></label>'+
            '<input type="radio" id="'+name+(i+1)+'_star4" name="'+name+(i+1)+'" value="4" /><label class="full" for="'+name+(i+1)+'_star4" title="Pretty good - 4 stars"></label>'+
            '<input type="radio" id="'+name+(i+1)+'_star3half" name="'+name+(i+1)+'" value="3.5" /><label class="half" for="'+name+(i+1)+'_star3half" title="Meh - 3.5 stars"></label>'+
            '<input type="radio" id="'+name+(i+1)+'_star3" name="'+name+(i+1)+'" value="3" /><label class="full" for="'+name+(i+1)+'_star3" title="Meh - 3 stars"></label>'+
            '<input type="radio" id="'+name+(i+1)+'_star2half" name="'+name+(i+1)+'" value="2.5" /><label class="half" for="'+name+(i+1)+'_star2half" title="Kinda bad - 2.5 stars"></label>'+
            '<input type="radio" id="'+name+(i+1)+'_star2" name="'+name+(i+1)+'" value="2" /><label class="full" for="'+name+(i+1)+'_star2" title="Kinda bad - 2 stars"></label>'+
            '<input type="radio" id="'+name+(i+1)+'_star1half" name="'+name+(i+1)+'" value="1.5" /><label class="half" for="'+name+(i+1)+'_star1half" title="Meh - 1.5 stars"></label>'+
            '<input type="radio" id="'+name+(i+1)+'_star1" name="'+name+(i+1)+'" value="1" /><label class="full" for="'+name+(i+1)+'_star1" title="Sucks big time - 1 star"></label>'+
            '<input type="radio" id="'+name+(i+1)+'_starhalf" name="'+name+(i+1)+'" value="0.5" /><label class="half" for="'+name+(i+1)+'_starhalf" title="Sucks big time - 0.5 stars"></label>'+
            '</fieldset>'+
            '</div>'+
            '</div>';
        }
    });
    $('#'+id).html(html);
}

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
        "url": "candidates/list_candidates",
        "dataType": "json",
        "type": "POST",
        "data": function(d) {
            d.designation = $("#select_designation").val();
            d.schedule_type = $("#schedule_type").val();
            d.interviewDate = $("#date").val();
        },
    },
    stateSave: true,
    "columns": [
        { "data": "#"},
        { "data": "id"},
        { "data": "name" },
        { "data": "designation" },
        { "data": "status" },
        { "data": "location" },
        { "data": "interview_date" },
        { "data": "action" },

    ],
    "fixedHeader": true,
    "columnDefs": [
        { "orderable": false, "targets": [0, 1, 5,] }
    ]
});
function checkbox_check() {
    var checkbox = $('.candidate_check:checked');
    if (checkbox.length > 0) {
        $('#delete_candidate').show();
    } else {
        $('#delete_candidate').hide();
    }
}
$('#select_All_checkbox').change(function() {
    checkbox_check();
});
/* $('#delete_leave').click(function() {
    
}); */
$('#select_All_checkbox').click(function(event) {
    if ($(this).val() == 'All_select') {
        if ($(this).is(":checked")) {
            $('.candidate_check').each(function() {
                $(this).prop("checked", true);
            });
        } else {
            $('.candidate_check').each(function() {
                $(this).prop("checked", false);
            });
        }
    }
});
$('#delete_candidate').click(function(){
    delete_candidate($(this));
});
table.order([0, 'desc']).draw();
$(document).on("click",'.interview_schedule',function(){
    $("input[name='hrm-select']").prop('checked',false);
    $("input[name='final-select']").prop('checked',false);
    $("#add_candidate input[name='text']").removeClass('error');
    $("#add_candidate textarea").removeClass('error');
    $("#salary").removeClass('error');
    $("#joining_date").removeClass('error');
    $("#traning_period").removeClass('error');
    $("#upload-text span").text('Upload your resume here');
    $('.preloader-2').attr('style', 'display:block !important');
    var id = $(this).data('id');
    interview_schedule(id);
});
$('#example').on('draw.dt', function() {
    $('.editCandidate_detail').click(function(){
        editCandidate_detail($(this));
    });
     $('.mail_send').click(function(){
        mail_send_click($(this));
     });
    checkbox_check();
    $('.candidate_check').change(function() {
        checkbox_check();
    });
    $('.preloader-2').attr('style', 'display:none !important');
});
$('.schedule_fix_mail').click(function(){
    // schedule_fix_mail();
    table.clear();
	table.ajax.reload();
});
$('#status_select, #status_pending, #status_reject').click(function(){
    var satus = $(this).data('satus');
    $('#interview_status').val(satus);
    if(satus == 'select'){
        $(this).removeClass('sec-btn  sec-btn-outline').addClass('sec-btn');
        $('#status_pending').addClass('btn-outline-warning').removeClass('btn-warning');
        $('#status_reject').addClass('btn-outline-danger').removeClass('btn-danger');
    }else if(satus == 'pending'){
        $(this).removeClass('btn-outline-warning').addClass('btn-warning');
        $('#status_select').addClass('sec-btn  sec-btn-outline').removeClass('sec-btn');
        $('#status_reject').addClass('btn-outline-danger').removeClass('btn-danger');
    }else if(satus == 'reject'){
        $(this).removeClass('btn-outline-danger').addClass('btn-danger');
        $('#status_select').addClass('sec-btn  sec-btn-outline').removeClass('sec-btn');
        $('#status_pending').addClass('btn-outline-warning').removeClass('btn-warning');
    }
});
$('#final_select, #final_onhold, #final_reject').click(function(){
    var satus = $(this).data('final_satus');
    $('#final_satus').val(satus);
    if(satus == 'select'){
        $(this).removeClass('sec-btn  sec-btn-outline').addClass('sec-btn');
        $('#final_onhold').addClass('btn-outline-warning').removeClass('btn-warning');
        $('#final_reject').addClass('btn-outline-danger').removeClass('btn-danger');
        $('#reject_to_hide').show();
    }else if(satus == 'onhold'){
        $(this).removeClass('btn-outline-warning').addClass('btn-warning');
        $('#final_select').addClass('sec-btn  sec-btn-outline').removeClass('sec-btn');
        $('#final_reject').addClass('btn-outline-danger').removeClass('btn-danger');
        $('#reject_to_hide').show();
    }else if(satus == 'reject'){
        $(this).removeClass('btn-outline-danger').addClass('btn-danger');
        $('#final_select').addClass('sec-btn  sec-btn-outline').removeClass('sec-btn');
        $('#final_onhold').addClass('btn-outline-warning').removeClass('btn-warning');
        $('#reject_to_hide').hide();
    }
});
function skills(){
    var skills = '';
    $.each($('.tag-box li.tags'), function (i,v) {
        var text = $(this).text();
        if($('.tag-box li.tags').length == (i+1)){
            skills += text.replace(',', '');
        }else{
            skills += text.replace(',', '') + ', ';
        }
    });
    $('#skills').val(skills);
}
function select_designation(){
    var backSpace;
    var close = '<a class="close"></a>';
    
    var PreTags = $('.tagarea').val().trim().split(", ");
    $('.tag-box').remove();
    $('.tagarea').after('<ul class="tag-box"></ul>');
    if(PreTags.length == 1 && PreTags[0] == ''){

    }else{
        for (i = 0; i < PreTags.length; i++) {
            $('.tag-box').append('<li class="tags">' + PreTags[i] + close + '</li>');
        }
    }
    $('.tag-box').append('<li class="new-tag"><input class="input-tag" type="text"></li>');
        // Taging 
    $('.input-tag').bind("keyup", function (kp) {
        var tag = $('.input-tag').val().trim();
        $(".tags").removeClass("danger");
        if (tag.length > 0) {
            backSpace = 0;
            if (kp.keyCode == 13) {
                $(".new-tag").before('<li class="tags">' + tag + close + '</li>');
                skills();
                $(this).val('');
            }
            if (kp.which == 188) {
                $(".new-tag").before('<li class="tags">' + tag.replace(',', '') + close + '</li>');
                skills();
                $(this).val('');
            }
        } else {
            if (kp.keyCode == 8) {
                $(".new-tag").prev().addClass("danger");
                backSpace++;
                if (backSpace == 2) {
                    $(".new-tag").prev().remove();
                    backSpace = 0;
                    skills();
                }
            }
        }
    });
    //Delete tag
    $(".tag-box").on("click", ".close", function () {
        $(this).parent().remove();
        skills();
    });
    $(".tag-box").click(function () {
        $('.input-tag').focus();
    });
    // Edit
    $('.tag-box').on("dblclick", ".tags", function (cl) {
        var tags = $(this);
        var tag = tags.text().trim();
        $('.tags').removeClass('edit');
        tags.addClass('edit');
        tags.html('<input class="input-tag" value="' + tag + '" type="text">')
        $(".new-tag").hide();
        tags.find('.input-tag').focus();

        tag = $(this).find('.input-tag').val();
        $('.tags').dblclick(function () {
            tags.html(tag + close);
            $('.tags').removeClass('edit');
            $(".new-tag").show();
        });

        tags.find('.input-tag').bind("keydown", function (edit) {
            tag = $(this).val();
            if (edit.keyCode == 13) {
                $(".new-tag").show();
                $('.input-tag').focus();
                $('.tags').removeClass('edit');
                if (tag.length > 0) {
                    tags.html(tag + close);
                } else {
                    tags.remove();
                }
                skills();
            }
        });
    });
    // sorting
    $(function () {
        $(".tag-box").sortable({
            items: "li:not(.new-tag)",
            containment: "parent",
            scrollSpeed: 100
        });
        $(".tag-box").disableSelection();
    });
}
function interview_schedule(id) {
    $('.preloader-2').attr('style', 'display:block !important');
    $('.btn-open-desig').click();
    $("#candidate-form2>input[name='hrm-select']").prop('checked',false);
    $("input[name='final-select']").prop('checked',false);
    $('#candidate_info').click();
    // var id = $(this).data('id');
    var data = {
        'id': id,
    };
    $.ajax({
        url: base_url + "candidates/get_candidates",
        type: "post",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            // console.log(obj.list_data[0]);
            $('#btn_previous').hide();
            $('#technical_skill').val('');
            $('#taken_by').val('');
            $('#hr_skills').val('');
            $('#hr_feedback').removeClass('error');
            $('#interview_status').val('');
            $('.employee_name').text('Interview Details');
            $('#btn_next').text('Next');
            $('#interview_date_div').show();
            $('#data_type').val('schedule_detail');
            $('#candidate_info').parents('ul.nav.nav-tabs').show();
            addskills_set('hr_skills');
            addskills_set('skills');
            $("input[name='hrm-select']").prop('checked',false);
            $("input[name='final-select']").prop('checked',false);
            if(obj.list_data[0]){
                $('#candidate_info').parent().addClass('complete').removeClass('incomplete'); 
                $('#id').val(obj.list_data[0].id);
                $('#candidate_id').val(obj.list_data[0].id);
                $('#c_id').val(obj.list_data[0].id);
                $('#c1_id').val(obj.list_data[0].id);
                $('#name').val(obj.list_data[0].name);
                $('#email').val(obj.list_data[0].email);
                $('#phone_number').val(obj.list_data[0].phone_number);
                $('#experience').val(obj.list_data[0].experience);
                $('#current_salary').val(obj.list_data[0].current_salary);
                $('#expected_salary').val(obj.list_data[0].expected_salary);
                $('#address').val(obj.list_data[0].location);
                $('#skills').val(obj.list_data[0].skills);
                if(obj.list_data[0].upload_resume){
                    $('#upload_resume_name').val(obj.list_data[0].upload_resume);
                    $('#upload-text span').text(obj.list_data[0].upload_resume);
                    $('#view_resume').show();
                    $('#view_resume').attr('href', base_url + 'assets/upload/candidates_upload_resume/' + obj.list_data[0].upload_resume);
                }else{
                    $('#upload-text span').text('Upload your resume here');
                    $('#upload_resume_name').val('');
                    $('#view_resume').hide();
                }
                if(obj.list_data[0].gender == 'male') {
                    $('#gender').prop('checked', true);
                }else if(obj.list_data[0].gender == 'female'){
                    $('#gender1').prop('checked', true);
                }
                var html = '<option>Select Designation</option>';
                var html1 = '';
                $.each(obj.designation, function (i, v) {
                    if (v.id == obj.list_data[0].designation) {
                        html += '<option value="' + v.id + '" selected="selected">' + v.name + '</option>';
                        html1 += '<p class="d-none" id="' + v.id + '_skills">' + obj.list_data[0].skills + '</p>';
                    } else {
                        html += '<option value="' + v.id + '">' + v.name + '</option>';
                        html1 += '<p class="d-none" id="' + v.id + '_skills">' + v.skills + '</p>';
                    }
                });
                $('#designation').html(html);
                $('#d_skills').html(html1);
            }
            if(obj.list_interview_schedule[0]){
                if(obj.list_interview_schedule[0].interview_status && obj.list_interview_schedule[0].hr_feedback && obj.list_interview_schedule[0].hr_skill){
                    $('#hr_round').parent().addClass('complete').removeClass('incomplete'); 
                }
                $('#i_s_id').val(obj.list_interview_schedule[0].id);
                $('#hrround_id').val(obj.list_interview_schedule[0].id);
                $('#tcround_id').val(obj.list_interview_schedule[0].id);
                $('#fround_id').val(obj.list_interview_schedule[0].id);
                $('#hr_feedback').val(obj.list_interview_schedule[0].hr_feedback);
                if(obj.list_interview_schedule[0].hr_feedback != ''){
                    $('#status_'+obj.list_interview_schedule[0].interview_status).click();
                }

                if(obj.list_interview_schedule[0].interview_date && new Date(obj.list_interview_schedule[0].interview_date) != 'Invalid Date'){
                    $('#interview_date').val(obj.list_interview_schedule[0].interview_date);
                    $('#interview_date').datepicker().data('datepicker').selectDate(new Date(obj.list_interview_schedule[0].interview_date));
                    $('#interview_date').removeClass('error');
                }
                var num = 1;
                $.each(obj.list_interview_schedule[0].hr_skill,function(i,v){
                    $.each($("input[name="+i+num+"]"),function(index,value){
                        if($(this).val() == v){
                            $(this).prop('checked',true);
                        }
                    });
                    num++;
                });
                skills_val(hr_skills,'hr_skills');
                addskills_set('skills');
                if(obj.list_interview_schedule[0].technical_skill && obj.list_interview_schedule[0].technical_feedback && obj.list_interview_schedule[0].taken_by){
                    $('#technical_round').parent().addClass('complete').removeClass('incomplete');
                }
                if(obj.list_interview_schedule[0].technical_skill){
                    var num1 = 1;
                    $.each(obj.list_interview_schedule[0].technical_skill,function(i1,v1){
                        $.each($("input[name="+i1+num1+"]"),function(){
                            if($(this).val() == v1){
                                $(this).prop('checked',true);
                            }
                        });
                        num1++;
                    });
                    var skill = ($('#skills').val()).split(", ");
                    skills_val(skill,'technical_skill');
                }else{
                    
                }
                if(obj.list_interview_schedule[0].technical_feedback){
                    $('#technical_feedback').val(obj.list_interview_schedule[0].technical_feedback);
                }else{
                    $('#technical_feedback').val(' ');
                }
                if(obj.list_interview_schedule[0].taken_by){
                    $('#taken_by').val(obj.list_interview_schedule[0].taken_by);
                    var taken_by = (obj.list_interview_schedule[0].taken_by).split(',');
                    $.each(taken_by,function(index,value) {
                        $("input[name='taken_by[]']").each ( function(i,v) {
                            if($(this).data('taken_by') == value){
                                $(this).prop('checked',true);
                            }
                        });
                    });
                }else{
                    $("input[name='taken_by[]']").each ( function(i,v) {
                        $(this).prop('checked',false);
                    });
                }
                if(obj.list_interview_schedule[0].salary && obj.list_interview_schedule[0].remark && obj.list_interview_schedule[0].joining_date && obj.list_interview_schedule[0].status && obj.list_interview_schedule[0].employee_status){
                     $('#final_round').parent().addClass('complete').removeClass('incomplete');
                }
                if(obj.list_interview_schedule[0].salary){
                    $('#salary').val(obj.list_interview_schedule[0].salary);
                }else{
                    $('#salary').val('');
                }
                if(obj.list_interview_schedule[0].remark){
                    $('#remark').val(obj.list_interview_schedule[0].remark);
                }else{
                    $('#remark').val('');
                }
                if(obj.list_interview_schedule[0].joining_date  && new Date(obj.list_interview_schedule[0].joining_date) != 'NaN undefined, NaN'){
                    $('#joining_date').val(obj.list_interview_schedule[0].joining_date);
                    if(!new Date(obj.list_interview_schedule[0].joining_date) || new Date(obj.list_interview_schedule[0].joining_date) == 'Invalid Date'){
                        $('#joining_date').val('');
                    }else{
                        $('#joining_date').datepicker().data('datepicker').selectDate(new Date(obj.list_interview_schedule[0].joining_date));
                    }
                }else{
                    $('#joining_date').val('');
                }
                if(obj.list_interview_schedule[0].status != 'select' && obj.list_interview_schedule[0].remark != ''){
                    $('#final_'+obj.list_interview_schedule[0].status).click();
                }
                if(obj.list_interview_schedule[0].employee_status){
                    var html = '';
                    if(obj.list_interview_schedule[0].employee_status == 'employee'){
                        $('#traning_period_div').hide();
                        html += '<option value="" disabled="">Select Status</option><option value="training">Training</option><option value="employee" selected="selected">Employee</option>';
                    }else{
                        $('#traning_period_div').show();
                        html += '<option value="" disabled="">Select Status</option><option value="training" selected="selected">Training</option><option value="employee">Employee</option>';
                        if(obj.list_interview_schedule[0].traning_period){
                            $('#traning_period').val(obj.list_interview_schedule[0].traning_period);
                        }
                    }
                    $('#candidate-form2 #employee_status').html(html);
                }
            }else{
                $("input[name='hrm-select']").prop('checked',false);
                $("input[name='final-select']").prop('checked',false);
                addskills_set('hr_skills');
                addskills_set('skills');
                $('#technical_round,#hr_round,#final_round').parent().addClass('incomplete').removeClass('complete');
                $('#candidate_name').text($('#name').val());
                $('.schedule_date').text($('#interview_date').val());
                $('#hr_feedback').val('');
                $('#hr_feedback').val('');
                $('#status_select').addClass('sec-btn  sec-btn-outline').removeClass('sec-btn');
                $('#status_pending').addClass('btn-outline-warning').removeClass('btn-warning');
                $('#status_reject').addClass('btn-outline-danger').removeClass('btn-danger');
                $('#interview_date').val('');
            }
            tab_validation();
            // $('.msg-container').html(response);
            // $('.msg-container .msg-box').attr('style','display:block');
            // setTimeout(function() {
            //     $('.msg-container .msg-box').attr('style','display:none');
            // }, 6000);	
            // table.clear();
            // table.ajax.reload();
            select_designation();
            $('.preloader-2').attr('style', 'display:none !important');
        },
    });
}
function designation_change(){
    var id = $('#designation').val();
    var skills = $('#'+id+'_skills').text();
    $('#skills').val(skills);
}

function skills_val(array,id){
    var ns = [];
    for(var i = 0; i < array.length; i++){
        var key = ((array[i].toLowerCase()).replace(/\s/g,'_')).replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');
        var r = $("input[name="+key.toLowerCase()+(i+1)+"]:checked").val();
        ns.push(r);
    }
    $('#'+id).val(ns);
}
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
    var num = 0;
    var arr = [];
    if( $('#data_type').val() == 'schedule_detail'){
        arr = ['id','name','designation','email','gender','experience','phone_number','address','current_salary','expected_salary','skills','interview_date'];
        if(new Date(interview_date) == 'Invalid Date'){
            num++;
        }
    }else{
        arr = ['id','name','designation','email','gender','experience','phone_number','address','current_salary','expected_salary','skills'];
    }
    if(input_validate(arr,massage_box) != 0){num++;}
    if(text_validate(name) == true){$("#name").removeClass('error');}else{$("#name").addClass('error');num++;}
    if(text_validate(address)){$("#address").removeClass('error');}else{$("#address").addClass('error');num++;}
    if(email_validate('email') == 1 && contact_number_validate('phone_number') == 1 && num == 0){
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
                if( $('#data_type').val() == 'schedule_detail'){
                    if(obj.insert_id){
                        $('#hrround_id').val(obj.insert_id);
                        $('#tcround_id').val(obj.insert_id);
                        $('#fround_id').val(obj.insert_id);
                        $('#i_s_id').val(obj.insert_id);
                    }
                    if(obj.upload_resume){
                        $('#upload_resume_name').val(obj.upload_resume);
                        $('#upload-text span').text(obj.upload_resume);
                        $('#view_resume').show();
                        $('#view_resume').attr('href', base_url + 'assets/upload/candidates_upload_resume/' + obj.upload_resume);
                    }else{
                        $('#upload-text span').text('Upload your resume here');
                        $('#upload_resume_name').val('');
                        $('#view_resume').hide();
                    }

                    $('#next').val('hr_round');
                    $('#previous').val('hr_round');
                    $('#candidate_name').text($('#name').val());
                    $('.schedule_date').text($('#interview_date').val());
                    $('#btn_previous').show();
                    $('#hr_round').removeClass('disabled');
                    $('#hr_round').click();
                    tab_validation();
                }else{
                    $('.close_popup').click();
                }
                $('.msg-container').html(obj.message);
                $('.msg-container .msg-box').attr('style','display:block');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style','display:none');
                }, 6000);
                /* $('.close_popup').click();*/
                table.clear();
                table.ajax.reload();
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
    }else{
        $('.preloader-2').attr('style', 'display:none !important');
        return false;   
    }
});
/* function form_submit1(){
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
    if(!upload_resume && !upload_resume_name){
        var massage_box = ['upload_resume'];
    }else{
        var massage_box = [];
    }
    var arr = ['id','name','designation','email','gender','experience','phone_number','address','current_salary','expected_salary','skills','interview_date'];
    var num = 0;
    if(text_validate(name) == true){$("#name").removeClass('error');}else{$("#name").addClass('error');num++;}
    if(input_validate(arr,massage_box) == 0 && email_validate('email') == 1 && contact_number_validate('phone_number') == 1 && num == 0){
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
            data:new FormData($('#candidate-form1')),
            processData:false,
            contentType:false,
            cache:false,
            async:false,
        success: function (response) {
            var obj = JSON.parse(response);
            if(obj.error_code == 0){
                $('.msg-container').html(obj.message);
                    $('.msg-container .msg-box').attr('style','display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style','display:none');
                    }, 6000);
                    // $('.close_popup').click();
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
    }else{
        $('.preloader-2').attr('style', 'display:none !important');
        return false;   
    }
} */
function form_submit2(){
    $('.preloader-2').attr('style', 'display:block !important');
    var hrround_id = $('#hrround_id').val();
    var candidate_id = $('#candidate_id').val();
    var hr_skills = $('#hr_skills').val();
    var hr_feedback = $('#hr_feedback').val();
    var interview_status = $('#interview_status').val();
    var interview_date = $('#interview_date').val();
    var arr = ['hr_feedback'];
    var message_box = ['hr_skills','interview_status'];
    var num = 0;
    if(maxlength(hr_feedback,100)){$("#hr_feedback").removeClass('error');}else{$("#hr_feedback").addClass('error');num++;}
    if(input_validate(arr,message_box) == 0 && num == 0){
        var data = {
            'hrround_id': hrround_id,
            'candidate_id': candidate_id,
            'interview_status': interview_status,
            'interview_date': interview_date,
            'hr_skills': hr_skills,
            'hr_feedback': hr_feedback,
            };
        $.ajax({
            url: base_url+"candidates/update_hrround_detail",
            type: "post",
            data: data ,
            success: function (response) {
                    var obj = JSON.parse(response);
                    if(obj.error_code == 0){
                        $('.msg-container').html(obj.message);
                        $('.msg-container .msg-box').attr('style','display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style','display:none');
                        }, 6000);
                        /* $('.close_popup').click(); */
                        if(interview_status != 'reject'){
                            $('#next').val('technical_round');
                            $('#previous').val('technical_round');
                            $('#technical_round').click();
                            tab_validation();
                        }else{
                            $('.close_popup').click();
                        }
                        table.clear();
                        table.ajax.reload(); 
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
    }else{
            $('.preloader-2').attr('style', 'display:none !important');
            return false;
    }
}
function form_submit3(){
    $('.preloader-2').attr('style', 'display:block !important');
    var taken_by = '';
    var count = $("input[name='taken_by[]']:checked").length; 
    $("input[name='taken_by[]']:checked").each ( function(i,v) {
        if(count == (i+1)){
            taken_by += $(this).val();
        }else{
            taken_by += $(this).val() + ",";
        }
    });
    $('#taken_by').val(taken_by);
    var skill = $('#skills').val();
    var tcround_id = $('#tcround_id').val();
    var c_id = $('#c_id').val();
    var technical_skill = $('#technical_skill').val();
    var technical_feedback = $('#technical_feedback').val();
    var num = 0;
    if(maxlength(technical_feedback,100)){$("#technical_feedback").removeClass('error');}else{$("#technical_feedback").addClass('error');num++;}
    var arr = ['technical_feedback'];
    var message_box = ['technical_skill','taken_by'];
    if(input_validate(arr,message_box) == 0 && num == 0){
        var data = {
            'tcround_id': tcround_id,
            'c_id': c_id,
            'taken_by': taken_by,
            'skill': skill,
            'technical_skill': technical_skill,
            'technical_feedback': technical_feedback,
            };
        $.ajax({
            url: base_url+"candidates/update_tcround_detail",
            type: "post",
            data: data ,
            success: function (response) {
                var obj = JSON.parse(response);
                if(obj.error_code == 0){
                    $('.msg-container').html(obj.message);
                    $('.msg-container .msg-box').attr('style','display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style','display:none');
                    }, 6000);
                    /* $('.close_popup').click(); */
                    $('#next').val('final_round');
                    $('#previous').val('final_round');    
                    $('#final_round').click();
                    tab_validation();
                    table.clear();
                    table.ajax.reload();
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
    }else{
        $('.preloader-2').attr('style', 'display:none !important');
        return false;
    }
}
function form_submit4(){
    $('.preloader-2').attr('style', 'display:block !important');
    var fround_id = $('#fround_id').val();
    var c1_id = $('#c1_id').val();
    var salary = $('#salary').val();
    var employee_status = $('#employee_status').val();
    var joining_date = $('#joining_date').val();
    var traning_period = $('#traning_period').val();
    var remark = $('#remark').val();
    var num = 0;
    var final_satus = $('#final_satus').val();

    if(final_satus != 'reject'){
        if(maxlength(remark,100)){$("#remark").removeClass('error');}else{$("#remark").addClass('error');num++;}
        if(employee_status == 'employee'){
            var arr = ['employee_status','salary','joining_date','remark'];
        }else{
            var arr = ['employee_status','salary','joining_date','traning_period','remark'];
        }
        var massage_box = ['final_satus'];
        if(input_validate(arr,massage_box) != 0 || new Date(joining_date) == 'Invalid Date' || num != 0){
            num += 10;
        }
    }
    if(num == 0){
        var data = {
            'fround_id': fround_id,
            'c1_id': c1_id,
            'salary': salary,
            'traning_period': traning_period,
            'employee_status': employee_status,
            'joining_date': joining_date,
            'remark': remark,
            'final_satus': final_satus,
            };
        $.ajax({
            url: base_url+"candidates/update_fround_detail",
            type: "post",
            data: data ,
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
    }else{
        $('.preloader-2').attr('style', 'display:none !important');
        return false;
    }
}

function delete_candidate($this){
    if (confirm("Are you sure want to delete?")){
        var checkbox = $('.candidate_check:checked');
        if (checkbox.length > 0) {
            $('.preloader-2').attr('style', 'display:block !important;');
            var checkbox_value = [];
            $(checkbox).each(function() {
                checkbox_value.push($(this).val());
            });
            var id = checkbox_value.toString();
            var base_url = $("#js_data").data('base-url');
            // var id = $(".tmp_name").data('emp_id');
            var data = { 'id': id };
            $.ajax({
                url: base_url + "candidates/delete_candidate",
                type: "post",
                data: data,
                success: function(response) {
                    var obj = JSON.parse(response);
                    if(obj.error_code == 0){
                        jQuery('#select_All_checkbox').prop('checked',false);
                        $('.msg-container').html(obj.message);
                        $('.msg-container .msg-box').attr('style','display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style','display:none');
                        }, 6000);
                        table.clear();
                        table.ajax.reload();
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
        } else {
            alert('Select atleast one records For Delete');
        }
    }
    /* if (confirm("Are you sure you want to delete?")) {
        var id = $this.data('id');
        var schedule_id = $this.data('schedule');
        if(id){

            var data = {
                'id': id,
                'schedule_id': schedule_id,
            };
            $.ajax({
                url: base_url+"candidates/delete_candidate",
                type: "post",
                data: data ,
                success: function (response) {
                    var obj = JSON.parse(response);
                    if(obj.error_code == 0){
                        $('.msg-container').html(obj.message);
                        $('.msg-container .msg-box').attr('style','display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style','display:none');
                        }, 6000);
                        table.clear();
                        table.ajax.reload();
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
        }else{
            var message = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">Candidate Id Not Found</p></div></div></div>';
            $('.msg-container').html(message);
            $('.msg-container .msg-box').attr('style','display:block');
            setTimeout(function() {
                $('.msg-container .msg-box').attr('style','display:none');
            }, 6000);
        }
    } */
}
function editCandidate_detail($this){
    var id = $this.data('id');
    $('.preloader-2').attr('style', 'display:block !important;');
    var base_url = $("#js_data").data('base-url');
    var data = { 'id': id };
    $.ajax({
        url: base_url + "candidates/get_candidates",
        type: "post",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if(obj.list_data[0]){
                // $('#candidate_info').parent().addClass('complete').removeClass('incomplete'); 
                $('#candidate_info').click(); 
                $('.employee_name').text('Edit Candidate Detail');
                $('#btn_next').text('Update');
                $('#interview_date_div').hide();
                $('#btn_previous').hide();
                $('#candidate_info').parents('ul.nav.nav-tabs').hide(); 
                $('#id').val(obj.list_data[0].id);
                $('#data_type').val('candidate_detail');
                $('#candidate_id').val(obj.list_data[0].id);
                $('#c_id').val(obj.list_data[0].id);
                $('#c1_id').val(obj.list_data[0].id);
                $('#name').val(obj.list_data[0].name);
                $('#email').val(obj.list_data[0].email);
                $('#phone_number').val(obj.list_data[0].phone_number);
                $('#experience').val(obj.list_data[0].experience);
                $('#current_salary').val(obj.list_data[0].current_salary);
                $('#expected_salary').val(obj.list_data[0].expected_salary);
                $('#address').val(obj.list_data[0].location);
                $('#skills').val(obj.list_data[0].skills);
                
                if(obj.list_data[0].upload_resume){
                    $('#upload_resume_name').val(obj.list_data[0].upload_resume);
                    $('#upload-text span').text(obj.list_data[0].upload_resume);
                    $('#view_resume').show();
                    $('#view_resume').attr('href', base_url + 'assets/upload/candidates_upload_resume/' + obj.list_data[0].upload_resume);
                }else{
                    $('#upload-text span').text('Upload your resume here');
                    $('#upload_resume_name').val('');
                    $('#view_resume').hide();
                }
                if(obj.list_data[0].gender == 'male') {
                    $('#gender').prop('checked', true);
                }else if(obj.list_data[0].gender == 'female'){
                    $('#gender1').prop('checked', true);
                }else{
                    $('#gender').prop('checked', false);
                    $('#gender1').prop('checked', false);
                }
                var html = '<option>Select Designation</option>';
                var html1 = '';
                $.each(obj.designation, function (i, v) {
                    if (v.id == obj.list_data[0].designation) {
                        html += '<option value="' + v.id + '" selected="selected">' + v.name + '</option>';
                        html1 += '<p class="d-none" id="' + v.id + '_skills">' + obj.list_data[0].skills + '</p>';
                    } else {
                        html += '<option value="' + v.id + '">' + v.name + '</option>';
                        html1 += '<p class="d-none" id="' + v.id + '_skills">' + v.skills + '</p>';
                    }
                });
                $('#designation').html(html);
                $('#d_skills').html(html1);
                select_designation();
                $('#add_candidate').modal('show');

            }
            $('.preloader-2').attr('style', 'display:none !important');
        },
    });
}

$('.email').keyup(function() {
    var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if(this.value.match(mailformat))
    {
        $(this).removeClass('error');
        return true;
    }else{
        $(this).addClass('error');
        return false;
    }
});
$('.contact_number').keyup(function() {
    var phoneno = /^\d{10}$/;
    if(this.value.match(phoneno)){
        $(this).removeClass('error');
    }else{
        $(this).addClass('error');
    }
});

$('.numeric').keyup(function() {
    this.value = this.value.replace(/[^0-9\.]/g, '');
});
$('.experience').keyup(function() {
    this.value = this.value.replace(/[^0-9\.]/g, '');
    if(this.value > 20){
        this.value = 20;
    }
});
$('.traning_period').keyup(function() {
    this.value = this.value.replace(/[^0-9\.]/g, '');
    var a = this.value.split('.');
    if(a[0] > 1 || a[1] > 12){
        this.value = 1;
    }
});

function tab_validation(){
    var arr1 = ['id','name','designation','email','gender','experience','phone_number','address','current_salary','expected_salary','skills','interview_date'];
    var arr2 = ['hr_feedback','hr_skills','interview_status'];
    var arr3 = ['technical_feedback','technical_skill','taken_by'];
    var arr4 = ['employee_status','salary','joining_date','traning_period','remark','final_satus'];
    if(check_validate(arr4) == 0 && check_validate(arr3) == 0 && check_validate(arr2) == 0 && check_validate(arr1) == 0){
        $('#final_round').removeClass('disabled');
        $('#technical_round').removeClass('disabled');
        $('#hr_round').removeClass('disabled');
        $('#candidate_info').parent().addClass('complete').removeClass('incomplete');
        $('#technical_round').parent().addClass('complete').removeClass('incomplete');
        $('#hr_round').parent().addClass('complete').removeClass('incomplete');
        $('#final_round').parent().addClass('complete').removeClass('incomplete');
        $('#final_round').click();
        $('#btn_previous').show();
    }else if(check_validate(arr3) == 0 && check_validate(arr2) == 0 && check_validate(arr1) == 0){
        $('#final_round').removeClass('disabled');
        $('#technical_round').removeClass('disabled');
        $('#hr_round').removeClass('disabled');
        $('#candidate_info').parent().addClass('complete').removeClass('incomplete');
        $('#technical_round').parent().addClass('complete').removeClass('incomplete');
        $('#hr_round').parent().addClass('complete').removeClass('incomplete');
        $('#final_round').parent().removeClass('complete').removeClass('incomplete');
        $('#final_round').click();
        $('#btn_previous').show();
    }else if(check_validate(arr2) == 0 && check_validate(arr1) == 0){
        if($('#interview_status').val() != 'reject'){
            $('#technical_round').removeClass('disabled');
            $('#hr_round').removeClass('disabled');
            $('#final_round').addClass('disabled');
            $('#candidate_info').parent().addClass('complete').removeClass('incomplete');
            $('#hr_round').parent().addClass('complete').removeClass('incomplete');
            $('#technical_round').parent().removeClass('incomplete').removeClass('complete');
            $('#final_round').parent().removeClass('complete').addClass('incomplete');
            $('#technical_round').click();
            $('#btn_previous').show();
        }else{
            $('#technical_round,#final_round').parent().addClass('incomplete').removeClass('complete');
            $('#technical_round,#final_round').addClass('disabled');
            $('#hr_round').click();
        }
    }else if(check_validate(arr1) == 0){
        $('#hr_round').removeClass('disabled');
        $('#final_round').addClass('disabled');
        $('#technical_round').addClass('disabled'); 
        $('#candidate_info').parent().addClass('complete').removeClass('incomplete');
        $('#hr_round').parent().removeClass('complete').removeClass('incomplete');  
        $('#technical_round').parent().removeClass('complete').addClass('incomplete');
        $('#final_round').parent().removeClass('complete').addClass('incomplete');
        $('#hr_round').click();
        $('#btn_previous').show();
    }else{
        $('#hr_round').addClass('disabled');
        $('#final_round').addClass('disabled');
        $('#technical_round').addClass('disabled');
        $('#candidate_info').parent().removeClass('incomplete').removeClass('complete');
        $('#candidate_info').parent().addClass('incomplete').removeClass('complete');
        $('#candidate_info').parent().addClass('incomplete').removeClass('complete');
        $('#final_round').parent().addClass('incomplete').removeClass('complete');
        $('#btn_previous').hide();
    }
}
function email_validate(id) {
    var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if(($('#'+id).val()).match(mailformat))
    {
        $('#'+id).removeClass('error');
        return 1;
    }else{
        $('#'+id).addClass('error');
        return 0;
    }
}
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

function input_validate($data,$message_box){
    var num = 0;
    if($data.length > 0){
        $.each($data,function(i,v){
            var value = ($('#'+v).val()).replaceAll(',','');
            if(!value){
                $('#'+v).addClass('error');
                num++;
            }else{
                $('#'+v).removeClass('error');
            }
        });
    }
    if($message_box.length > 0){
        var html = '';
        $.each($message_box,function(i,v){
            var value = ($('#'+v).val()).replaceAll(',','');
            if(!value){
                var msg = $('#'+v).data('msg');
                html += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>'+msg+'</p></div></div></div>';
                num++;
            }else{
                $(v).removeClass('error');
            }
        });
        $('.msg-container').html(html);
        $('.msg-container .msg-box').attr('style','display:block');
        setTimeout(function() {
            $('.msg-container .msg-box').attr('style','display:none');
        }, 6000);
    }
    return num;
}
function check_validate($data){
    var num = 0;
    $.each($data,function(i,v){
        var value = ($('#'+v).val()).replaceAll(',','');
        if(!value){
            num++;
        }
    });
    return num;
}


$(document).ready(function(){
    if(getCookie('candidates_id') != '' && getCookie('candidates_id') != null){
        var id = getCookie('candidates_id');
        interview_schedule(id);
        // $(".btn-view-schedule[data-schedule="+id+"]").click();
        setCookie('candidates_id','',-1);
    }
});