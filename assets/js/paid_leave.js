var base_url = $("#js_data").data('base-url');
$(document).ready(function(){
    $('.preloader-2').attr('style', 'display:block !important;');
    var table = $('#example_tbl').DataTable({
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
            "url": "paid_leave/paid_leave_list",
            "dataType": "json",
            "type": "POST",
            "data": function(d) {
                d.id = $("#employee_select").val();
            },
        },
        stateSave: true,
        "columns": [
            { "data": "#" },
            { "data": "year" },
            { "data": "month" },
            { "data": "status" },
            { "data": "action" },
            // { "data": "status" },

        ],
        "fixedHeader": true,
        "columnDefs": [
            { "orderable": false, "targets": [0, 4] }
        ]
    });
    table.order([3, 'asc']).draw();
    $('#example_tbl').on('draw.dt', function() {
        $('.preloader-2').attr('style', 'display:none');
    });
    $('#employee_select').on('change', function() {
        $('.preloader-2').attr('style', 'display:block !important;');
        table.clear();
        table.ajax.reload();
    });
$(document).on('click', '.edit-paid-leave', function(){
    var date = new Date(); 
    $('.employee_name1').text('Employee : '+$('select#employee_select option:selected').text());
    $("#leave_id").val("");
    $("#month").val("");
    $("#year").val("");
    $("#status").val("");
    $("#used_leave_month").val("");
    $("#used_leave_year").val("");

    $("#leave_id").val($(this).data('id'));
    $("#month").val($(this).data('month'));
    $("#year").val($(this).data('year'));
    $("#status").val($(this).data('status'));
    if($(this).data('status') == 'used'){
        $('.used_leave_div').show();
        $('.used_leave_year_div').show();
        $("select#paid_leave_status").html('<option value="" disabled>Select Status </option><option value="paid">Paid</option><option value="used" selected="selected">Used</option><option value="unused" >Unused</option>');
    }else if($(this).data('status') == 'unused'){
        $('.used_leave_div').hide();
        $('.used_leave_year_div').hide();
        $("select#paid_leave_status").html('<option value="" disabled>Select Status </option><option value="paid">Paid</option><option value="used">Used</option><option value="unused" selected="selected">Unused</option>');
    }else if($(this).data('status') == 'paid'){
        $('.used_leave_div').hide();
        $('.used_leave_year_div').hide();
        $("select#paid_leave_status").html('<option value="">Select Status </option><option value="paid" selected="selected">Paid</option><option value="used">Used</option><option value="unused">Unused</option>');
    }else{
        $('.used_leave_div').hide();
        $('.used_leave_year_div').hide();
        $("select#paid_leave_status").html('<option value="">Select Status </option><option value="paid">Paid</option><option value="used">Used</option><option value="unused">Unused</option>');
    }
    if($(this).data('used_leave_month')){
        $("#used_leave_month").val($(this).data('used_leave_month'));
    }else{
        $("#used_leave_month").val('');
    }
    if($(this).data('used_leave_year')){
        $("#used_leave_year").val($(this).data('used_leave_year'));
    }else{
        $("#used_leave_year").val('');
    }
    
});
$(document).on('change', '#paid_leave_status', function(){
    if($(this).val() == 'used'){
        $('.used_leave_div').show();
        $('.used_leave_div label').text('Used Paid Leave month');
        $('.used_leave_year_div').show();
        $('.used_leave_year_div label').text('Used Paid Leave Year');
    }else if($(this).val() == 'paid'){
        $('.used_leave_div').show();
        $('.used_leave_div label').text('Month of paid');
        $('.used_leave_year_div').show();
        $('.used_leave_year_div label').text('Year of paid');
    }else{
        $('.used_leave_div').hide();
        $('.used_leave_year_div').hide();
        $("#used_leave_month").val("");
        $("#used_leave_year").val("");
    }
});
$(document).on('change', '#paid_leave_status1', function(){
    if($(this).val() == 'used'){
        $('.used_leave_div1').show();
        $('.used_leave_div1 label').text('Used Paid Leave month');
        $('.used_leave_year_div1').show();
        $('.used_leave_year_div1 label').text('Used Paid Leave Year');
    }else if($(this).val() == 'paid'){
        $('.used_leave_div1').show();
        $('.used_leave_div1 label').text('Month of paid');
        $('.used_leave_year_div1').show();
        $('.used_leave_year_div1 label').text('Year of paid');
    }else{
        $('.used_leave_div1').hide();
        $('.used_leave_year_div1').hide();
        $("#used_leave_month1").val("");
        $("#used_leave_year1").val("");
    }
});
$(document).on('click', '.update-paid_leave', function(){
    var num = 0;
    var used_leave_month = $('#used_leave_month').val();
    var used_leave_year = $('#used_leave_year').val();
    var month = $('#month').val();
    var year = $('#year').val();
    var leave_id = $('#leave_id').val();
    var status = $('select#paid_leave_status option:selected').val();
    if(!month){
        $('#month').addClass('error');
        num++;
    }else{
        $('#month').removeClass('error');
    }
    if(!year){
        $('#year').addClass('error');
        num++;
    }else{
        $('#year').removeClass('error');
    }
    if(!status){
        $('#status').addClass('error');
        num++;
    }else{
        $('#status').removeClass('error');
    }
    if(!used_leave_month){
        if(status == 'used'){
            $('#used_leave_month').addClass('error');
            num++;
        }else{
            $('#used_leave_month').removeClass('error');
        }
    }
    if(!used_leave_year){
        if(status == 'used'){
            $('#used_leave_year').addClass('error');
            num++;
        }else{
            $('#used_leave_year').removeClass('error');
        }
    }
    if(num == 0){
        $('.update-paid_leave').prop('disabled', true);	
        $('.preloader-2').attr('style', 'display:block !important;');
        var data = {
            'id': leave_id,
            'year': year,
            'month': month,
            'used_leave_month': used_leave_month,
            'used_leave_year': used_leave_year,
            'status': status,
            };
        $.ajax({
            url: base_url+"paid_leave/update_leave",
            type: "post",
            data: data ,
            success: function (response) {
                    $('.msg-container').html(response);
                    $('.msg-container .msg-box').attr('style','display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style','display:none');
                    }, 6000);
                    $('.close').click();
                    table.clear();
                    table.ajax.reload();
                    $('.update-paid_leave').prop('disabled', false);	
                },
            });
    }else{
        return false;
    }
});
$(document).on('click', '.add-paid_leave', function(){
    var num = 0;
    var used_leave_month = $('#used_leave_month1').val();
    var used_leave_year = $('#used_leave_year1').val();
    var month = $('#month1').val();
    var year = $('#year1').val();
    var employee_id = $('#employee_select').val();
    var status = $('select#paid_leave_status1 option:selected').val();
    if(!month){
        $('#month1').addClass('error');
        num++;
    }else{
        $('#month1').removeClass('error');
    }
    if(!year){
        $('#year1').addClass('error');
        num++;
    }else{
        $('#year1').removeClass('error');
    }
    if(!status){
        $('#status1').addClass('error');
        num++;
    }else{
        $('#status1').removeClass('error');
    }
    if(!used_leave_month){
        if(status == 'used'){
            $('#used_leave_month1').addClass('error');
            num++;
        }else{
            $('#used_leave_month1').removeClass('error');
        }
    }
    if(!used_leave_year){
        if(status == 'used'){
            $('#used_leave_year1').addClass('error');
            num++;
        }else{
            $('#used_leave_year1').removeClass('error');
        }
    }
    if(num == 0){
        $('.add-paid_leave').prop('disabled', true);	
        $('.preloader-2').attr('style', 'display:block !important;');
        var data = {
            'employee_id': employee_id,
            'year': year,
            'month': month,
            'used_leave_month': used_leave_month,
            'used_leave_year': used_leave_year,
            'status': status,
            };
        $.ajax({
            url: base_url+"paid_leave/update_leave",
            type: "post",
            data: data ,
            success: function (response) {
                    $('.msg-container').html(response);
                    $('.msg-container .msg-box').attr('style','display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style','display:none');
                    }, 6000);
                    $('.close').click();
                    $('.add-paid_leave').prop('disabled', false);	
                    table.clear();
                    table.ajax.reload();
                },
            });
    }else{
        return false;
    }
});
$(document).on('click', '.delete-paid_leave', function(){
    if (confirm("Are you sure want to delete?")) {
        $(this).prop('disabled', true);	
        $('.preloader-2').attr('style', 'display:block !important;');
        var id = $(this).data('id');
        var employee_id = $('#employee_select').val();
        var data = {
            'id': id,
            'employee_id': employee_id,
            };
        $.ajax({
            url: base_url+"paid_leave/delete_leave",
            type: "post",
            data: data ,
            success: function (response) {
                    $('.msg-container').html(response);
                    $('.msg-container .msg-box').attr('style','display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style','display:none');
                    }, 6000);
                    $('.close').click();
                    $('.delete-paid_leave').prop('disabled', false);	
                    table.clear();
                    table.ajax.reload();
                },
            });
    }else{
        return false;
    }
});
$('#used_leave_month').datepicker().data('datepicker');
$('#used_leave_year').datepicker().data('datepicker');
$('#year').datepicker().data('datepicker');
$('#month').datepicker().data('datepicker');

});