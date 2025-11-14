jQuery(document).ready(function ($) {
// $('#datatable').dataTable();
$('.preloader-2').attr('style','display:block !important;');
var table = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "oLanguage": {
          "sLengthMenu": "Show _MENU_ Entries",
          },
        "lengthMenu": [ [10, 30, 50, 100], [10, 30, 50, 100] ],
        "pageLength": 30,
        "ajax":{
         "url": "designation/employee_pagination",
         "dataType": "json",
         "type": "POST",
        
                       },
        stateSave: true,               
          "columns": [
              { "data": "id" },
              { "data": "name" },
              { "data": "action" }, 
            
           ],
           "fixedHeader": true,
            "order": [[ 0, "desc" ]],
            "columnDefs": [{
              "targets": [2], 
              "orderable": false,
            }],                  

});
$('#example').on('draw.dt', function (){
    $('.preloader-2').attr('style','display:none !important;');
});
$('#designation-form').submit(function(){
  var base_url = $("#js_data").data('base-url');
  var e_id = $('#e_id').val();
  var designation = $('#designation').val();
  var skills = $('#skills').val();
  var num = 0;
  if(text_validate(designation) === true){$("#designation").removeClass('error');}else{$("#designation").addClass('error');num++;}
  if(num == 0){
      $('.preloader-2').attr('style','display:block !important;');
        var data = {
            'e_id': e_id,
            'designation': designation,
            'skills': skills,
        };
          var base_url = $('#js_data').data('base-url');
          $.ajax({
            url: base_url+"designation/insert_data",
            type: "post",
            data: data ,
            success: function (response1){
              var data = JSON.parse(response1);
                // console.log(response1);
                $('.msg-container').html(data.message);
                $('.msg-container .msg-box').attr('style','display:block');
                table.clear();
                table.ajax.reload();
                $('.close').click();
                $('.preloader-2').attr('style','display:none !important;');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style','display:none');
                }, 6000);
                return false;
            },
        });
        return false;
    }else{
      $('.msg-container .msg-box').attr('style','display:none');
        return false;
    }
});
$(document).on('click', '.edit-employee', function(){
  $('.preloader-2').attr('style', 'display:block !important');
    var base_url = $("#js_data").data('base-url');
    var e_id = $(this).data('id');
    if(e_id){
        var data = {
            'e_id': e_id,
        };
        var base_url = $('#js_data').data('base-url');
        $.ajax({
            url: base_url+"designation/add",
            type: "post",
            data: data ,
            success: function (response1) {
                $('.btn-open-desig').click();
                var data = JSON.parse(response1);
                $('#e_id').val(data.list_data[0].id);
                $('.employee_name').text('Update Designation');
                $('.submit_form').text('Update');
                $('#designation').val(data.list_data[0].name);
                $('#skills').val(data.list_data[0].skills);
                $('.preloader-2').attr('style', 'display:none !important');
                return false;
            },
        });
        $('.preloader-2').attr('style', 'display:none !important');
        return false;
    }else{ 
      $('.preloader-2').attr('style', 'display:none !important');
        return false;
    }
});
$(document).on('click', '.btn-open-desig', function(){
    $('#designation-form input').val('');
    $('#designation-form #skills').val('');
    $('.employee_name').text('Add Designation');
    $('.submit_form').text('Add');
});
$(document).on('click', '.delete-employee', function(){
    if (confirm("Are you sure want to delete?")) {
      $('.preloader-2').attr('style', 'display:block !important');
        jQuery(".loader-text").html("Deleting Designation");
        jQuery(".loader-wrap").show();
        var id=$(this).attr("data-id");
        var data = {
                'id': id,
                };
               $.ajax({
            url: "designation/delete_employee",
            type: "post",
            data: data ,
            success: function (response) {
              // window.location.replace("designation");
                table.clear();
                table.ajax.reload();
                $('.msg-container').html('<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Designation deleted successFully.</p></div></div></div>');
                $('.msg-container .msg-box').attr('style','display:block');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style','display:none');
                }, 6000);
                $('.preloader-2').attr('style', 'display:none !important');
          },

          });
  }
  return false; 
});
/* $("#designation-form").submit(function(e) {
  var designation=$("#designation").val();
  if(!designation){
      e.preventDefault();
      if(!designation){
        $("#designation").addClass('error');
      }
      else{
        $("#designation").removeClass('error');
      }
    return false;       
  }
  else{
    $("#designation").removeClass('error');
    return true;
  }
}); */
});