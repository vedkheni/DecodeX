jQuery(document).ready(function ($) {
// $('#datatable').dataTable();
$('#example').DataTable({
        "processing": true,
        "serverSide": true,
		"rowReorder": {
					"selector": 'td:nth-child(2)'
				},
        "oLanguage": {
          "sLengthMenu": "Show _MENU_ Entries",
          },
		"responsive": true,
        "lengthMenu": [ [10, 30, 50, 100], [10, 30, 50, 100] ],
        "pageLength": 30,
        "ajax":{
         "url": "project/employee_pagination",
         "dataType": "json",
         "type": "POST",
        
                       },
        stateSave: true,               
          "columns": [
              { "data": "id" },
              { "data": "title" },
              { "data": "client_name" },
              { "data": "action" }, 
            
           ],
            "order": [[ 0, "desc" ]]                   

});
$(document).on('click', '.delete-employee', function(){
    if (confirm("Are you sure?")) {
        jQuery(".loader-text").html("Deleting Project");
        jQuery(".loader-wrap").show();
        var id=$(this).attr("data-id");
        var data = {
                'id': id,
                };
               $.ajax({
            url: "project/delete_employee",
            type: "post",
            data: data ,
            success: function (response) {
              window.location.replace("project");
          },

          });
  }
  return false; 
});
$("#project-form").submit(function(e) {
  var title=$("#title").val();
  if(!title){
      e.preventDefault();
      if(!title){
        $("#title").addClass('error');
      }
      else{
        $("#title").removeClass('error');
      }
    return false;       
  }
  else{
    $("#title").removeClass('error');
    return true;
  }
});
});