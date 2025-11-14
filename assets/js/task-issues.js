jQuery(document).ready(function ($) {

// $('#datatable').dataTable();
 $('.task-pending').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [ [10, 25, 50, 100], [10, 25, 50, 100] ],
        "pageLength": 10,
        "ajax":{
         "url": "issues/employee_pagination",
         "dataType": "json",
         "type": "POST",
        
                       },
        stateSave: true,               
          "columns": [
              { "data": "id" },
              { "data": "project_id" },
              { "data": "title" },             
              { "data": "status" }, 
              { "data": "action" }, 
            
           ],
            "order": [[ 0, "desc" ]]                   

});

/*table.on( 'select', function ( e, dt, type, indexes ) {
  alert();
    if ( type === 'row' ) {
        var data = table.rows( indexes ).data().pluck( 'id' );
 
        // do something with the ID of the selected items
    }
});*/
$('.task-in-progress').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [ [10, 25, 50, 100], [10, 25, 50, 100] ],
        "pageLength": 10,
        "ajax":{
         "url": "issues/employee_pagination_in_progress",
         "dataType": "json",
         "type": "POST",
        
                       },
        stateSave: true,               
          "columns": [
              { "data": "id" },
              { "data": "project_id" },
              { "data": "title" },             
              { "data": "status" }, 
              { "data": "action" }, 
            
           ],
            "order": [[ 0, "desc" ]]                   

});
$('.task-in-completed').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [ [10, 25, 50, 100], [10, 25, 50, 100] ],
        "pageLength": 10,
        "ajax":{
         "url": "issues/employee_pagination_completed",
         "dataType": "json",
         "type": "POST",
        
                       },
        stateSave: true,               
          "columns": [
              { "data": "id" },
              { "data": "project_id" },
              { "data": "title" },             
              { "data": "status" }, 
              { "data": "action" }, 
            
           ],
            "order": [[ 0, "desc" ]]                   

});

$(document).on('change', '.update-status', function(){
  var status = jQuery(this).val();
  var id=$(this).attr("data-id");
  var data = {
                'id': id,
                'status': status,
              };
               $.ajax({
            url: "issues/update_status",
            type: "post",
            data: data ,
            success: function (response) {
              //console.log(response);
              window.location.replace("issues");
          },

          });
 // alert(selectedText+" - "+id);
}).change(); 

$(document).on('click', '.delete-employee', function(){
    if (confirm("Are you sure?")) {
        jQuery(".loader-text").html("Deleting Project Task");
        jQuery(".loader-wrap").show();
        var id=$(this).attr("data-id");
        var data = {
                'id': id,
                };
               $.ajax({
            url: "project_task/delete_employee",
            type: "post",
            data: data ,
            success: function (response) {
              window.location.replace("project_task");
          },

          });
  }
  return false; 
});
/*$(".update-status").change(function(){
  
  alert();
        var id=$(this).attr("data-id");
        var data = {
                'id': id,
                };
          $.ajax({
            url: "issues/update_status",
            type: "post",
            data: data ,
            success: function (response) {
              console.log(response);
              //window.location.replace("issues");
            },
          });
  
 
});*/

$("#project-task-form").submit(function(e) {
  var project=$("#project").val();
  var title=$("#title").val();
  var description=$("#description").val();
  var hour=$("#hour").val();
  var minute=$("#minute").val();
  var developer=$("#developer").val();
  var deadline=$("#deadline").val();
  var priority=$("#priority").val();
  var status=$("#status").val();
  if(!project || !title || !description || !hour || !minute || !developer || !deadline || !priority || !status){
      e.preventDefault();
      if(!project){
        $("#project").addClass('error');
      }
      else{
        $("#project").removeClass('error');
      }if(!title){
        $("#title").addClass('error');
      }
      else{
        $("#title").removeClass('error');
      }
      if(!description){
        $("#description").addClass('error');
      }
      else{
        $("#description").removeClass('error');
      }
      if(!hour){
        $("#hour").addClass('error');
      }
      else{
        $("#hour").removeClass('error');
      }
      if(!minute){
        $("#minute").addClass('error');
      }
      else{
        $("#minute").removeClass('error');
      }
      if(!developer){
        $("#developer").addClass('error');
      }
      else{
        $("#developer").removeClass('error');
      }
      if(!deadline){
        $("#deadline").addClass('error');
      }
      else{
        $("#deadline").removeClass('error');
      }
      if(!priority){
        $("#priority").addClass('error');
      }
      else{
        $("#priority").removeClass('error');
      }
      if(!status){
        $("#status").addClass('error');
      }
      else{
        $("#status").removeClass('error');
      }
    return false;       
  }
  else{
    $("#title").removeClass('error');
    $("#description").removeClass('error');
    $("#hour").removeClass('error');
    $("#minute").removeClass('error');
    $("#developer").removeClass('error');
    $("#deadline").removeClass('error');
    $("#priority").removeClass('error');
    $("#status").removeClass('error');
    return true;
  }
});
});