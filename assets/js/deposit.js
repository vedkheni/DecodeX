jQuery(document).ready(function ($) {
	var base_url=$("#js_data").attr("data-base-url");
	var role=$("#js_data").attr("data-role");
	//var emp_id=$("#emp_id").val();
	var data_id=$(".pay-salary-btn").attr("data-id");
	if(role == "employee"){
		var emp_id=$("#js_data").attr("data-employee-id");
		//var emp_id1 =$(".pay-salary-btn").attr("data-id");
		//var emp_id= $("#emp_id").val(emp_id1);
	}else{
		var emp_id=$("#emp_id").val();
	}
	//console.log(emp_id);

// $('#datatable').dataTable();
$('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [ [10, 30, 50, 100], [10, 30, 50, 100] ],
        "pageLength": 30,
        "ajax":{
         "url": base_url+"deposit/employee_pagination",
         "dataType": "json",
         "type": "POST",
        
                       },
        stateSave: true,               
          "columns": [
              { "data": "id" },
              { "data": "fname" },
              { "data": "status" }, 
			  { "data": "action" },
           ],
           "fixedHeader": true,
            "order": [[ 0, "desc" ]]                   

});
$('#example_tbl').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [ [10, 30, 50, 100], [10, 30, 50, 100] ],
        "pageLength": 30,
        "ajax":{
         "url": base_url+"deposit/employee_pagination_list/"+emp_id,
         "dataType": "json",
         "type": "POST",
        
                       },
        stateSave: true,               
          "columns": [
              { "data": "id" },
              { "data": "deposit_amount" },
              { "data": "month" }, 
              { "data": "year" },
			  /* { "data": "action" }, */
           ],
           "fixedHeader": true,
            "order": [[ 0, "desc" ]]                   

});
$(document).on('click', '.delete-employee', function(){
    if (confirm("Are you sure?")) {
        jQuery(".loader-text").html("Deleting Designation");
        jQuery(".loader-wrap").show();
        var id=$(this).attr("data-id");
		var emp_id=$(this).attr("data-emp-id");
        var data = {
                'id': id,
				'emp_id': emp_id,
                };
               $.ajax({
            url: base_url+"bonus/delete_employee",
            type: "post",
            data: data ,
            success: function (response) {
             location.reload();
          },

          });
  }
  return false; 
});
$("#deposit-form").submit(function(e) {
  var employee_select=$("#employee_select").val();
  var deposit=$("#deposit").val();
  var deposit_month=$("#deposit_month").val();
  var deposit_year=$("#deposit_year").val();
  if(!employee_select || !deposit || !deposit_month || !deposit_year){
      e.preventDefault();
      if(!employee_select){
        $("#employee_select").addClass('error');
      }
      else{
        $("#employee_select").removeClass('error');
      }
	  if(!deposit){
        $("#deposit").addClass('error');
      }
      else{
        $("#deposit").removeClass('error');
      }
	  if(!deposit_month){
        $("#deposit_month").addClass('error');
      }
      else{
        $("#deposit_month").removeClass('error');
      }
	   if(!deposit_year){
        $("#deposit_year").addClass('error');
      }
      else{
        $("#deposit_year").removeClass('error');
      }
    return false;       
  }
  else{
    $("#employee_select").removeClass('error');
	$("#deposit").removeClass('error');
	$("#deposit_month").removeClass('error');
	$("#deposit_year").removeClass('error');
    return true;
  }
});
});