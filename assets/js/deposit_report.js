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
	var currentYear = (new Date).getFullYear();
    var currentMonth = (new Date).getMonth() + 1;
	if($("#bonus_month").val() == currentMonth && $("#bonus_year").val() == currentYear){
     $('.preloader-2').attr('style','display:block !important;');
					$('#example').DataTable({
						"oLanguage": {
							"sLengthMenu": "Show _MENU_ Entries",
							},
						"processing": true,
						"serverSide": true,
						"lengthMenu": [ [10, 30, 50, 100], [10, 30, 50, 100] ],
						"pageLength": 30,
						"ajax":{	
						 "url": base_url+"reports/current_month_deposit",
						 "data":{month:$("#bonus_month").val(),year:$("#bonus_year").val()},
						 "dataType": "json",
						 "type": "POST",
						
									   },
						stateSave: true,               
						  "columns": [
							  { "data": "id" },
							  { "data": "fname" },
							  { "data": "deposit_amount" }, 
							  /* { "data": "action" }, */
						   ],
						   "fixedHeader": true,
						   "order": [[ 0, "desc" ]]                   

					});
           $('.preloader-2').attr('style','display:none !important;');
	}else{
         $('.preloader-2').attr('style','display:block !important;');
			$('#example').DataTable({
				"oLanguage": {
					"sLengthMenu": "Show _MENU_ Entries",
					},
				"processing": true,
				"serverSide": true,
				"lengthMenu": [ [10, 30, 50, 100], [10, 30, 50, 100] ],
				"pageLength": 30,
				"ajax":{
				 "url": base_url+"reports/deposit_pagination",
				 "data":{month:$("#bonus_month").val(),year:$("#bonus_year").val()},
				 "dataType": "json",
				 "type": "POST",
				
							   },
				stateSave: true,               
				  "columns": [
					  { "data": "id" },
					  { "data": "fname" },
					  { "data": "deposit_amount" }, 
					   { "data": "action" }, 
				   ],
				   "fixedHeader": true,	
				   "order": [[ 0, "desc" ]]   
					                

			});
             $('.preloader-2').attr('style','display:none !important;');
	}
	$('.preloader-2').attr('style', 'display:block !important');
	var role = $('#js_data').data('role');
	if(role == 'admin'){
		var table = $('#example_tbl').DataTable({
			"oLanguage": {
				"sLengthMenu": "Show _MENU_ Entries",
				},
			"processing": true,
			"serverSide": true,
			"lengthMenu": [ [10, 30, 50, 100], [10, 30, 50, 100] ],
			"pageLength": 30,
			"ajax":{
			 "url": base_url+"deposit/employee_pagination_list",
			 "dataType": "json",
			 "type": "POST",
			"data":function(d){d.id = $('#employee_select').val();},
						   },
			stateSave: true,               
			  "columns": [
				  { "data": "id" },
				  { "data": "deposit_amount" },
				  { "data": "month" }, 
				  { "data": "year" },			  			  
				  { "data": "payment_status" },
				  { "data": "action" },
			   ],
				"order": [[ 0, "desc" ]],                 
				"fixedHeader": true,
		  });
	}else{
		var table = $('#example_tbl').DataTable({
			"oLanguage": {
				"sLengthMenu": "Show _MENU_ Entries",
				},
			"processing": true,
			"serverSide": true,
			"lengthMenu": [ [10, 30, 50, 100], [10, 30, 50, 100] ],
			"pageLength": 30,
			"ajax":{
			 "url": base_url+"deposit/employee_pagination_list",
			 "dataType": "json",
			 "type": "POST",
			"data":function(d){d.id = $('#employee_select').val();},
						   },
			stateSave: true,               
			  "columns": [
				  { "data": "id" },
				  { "data": "deposit_amount" },
				  { "data": "month" }, 
				  { "data": "year" },			  			  
				  { "data": "payment_status" },
			   ],
				"order": [[ 0, "desc" ]],
				"fixedHeader": true,               
		  
		  });
	}
	  $('#example_tbl').on('draw.dt', function() {
		$('.edit_deposit').click(function(){
			$('.preloader-2').attr('style','display:block !important;');
			edit_deposit($(this));
		});
		$('.delete_deposit').click(function(){
			delete_deposit($(this));
		});
		  $('.preloader-2').attr('style', 'display:none !important');
	  });
$(document).on('click', '.submit_form', function(){
     $('.preloader-2').attr('style','display:block !important;');
   var employee =  $('#employee_select').val();
   var data = {
      'id':employee,
   }
   $.ajax({
      url : base_url+'deposit/total_deposits',
      type : "POST",
      data : data,
      success : function(response){
        // console.log(response);
        var data = JSON.parse(response);
        $('#total_deposit').text(data.get_deposit_total);
        // $('#percentage').text(data.get_employee[0].salary_deduction+"%");
        $('#percentage').text(data.deposit_total_pr+"%");
        $('#dfdg').text(data.get_employee[0].fname+" "+data.get_employee[0].lname);
        table.clear();
        table.ajax.reload();
         $('.preloader-2').attr('style','display:none !important;');
        return false;
      },
   });
        return false;
});
$(document).on('change', '#employee_select', function(){
     $('.preloader-2').attr('style','display:block !important;');
   var employee =  $('#employee_select').val();
   var data = {
      'id':employee,
   }
   $.ajax({
      url : base_url+'deposit/total_deposits',
      type : "POST",
      data : data,
      success : function(response){
        // console.log(response);
        var data = JSON.parse(response);
        $('#total_deposit').text(data.get_deposit_total);
        // $('#percentage').text(data.get_employee[0].salary_deduction+"%");
        $('#percentage').text(data.deposit_total_pr+"%");
        $('#dfdg').text(data.get_employee[0].fname+" "+data.get_employee[0].lname);
        table.clear();
        table.ajax.reload();
         $('.preloader-2').attr('style','display:none !important;');
        return false;
      },
   });
        return false;
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
  var deposit_id=$("#deposit_id").val();
  var deposit_month=$("#deposit_month").val();
  var deposit_year=$("#deposit_year").val();
  var salary_deduction_per=$("#salary_deduction_per").val();
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
	$('.preloader-2').attr('style','display:block !important;');
    $("#employee_select").removeClass('error');
	$("#deposit").removeClass('error');
	$("#deposit_month").removeClass('error');
	$("#deposit_year").removeClass('error');
    var data = { 
		'employee_select': employee_select,
		'deposit':deposit,
		'deposit_month':deposit_month,
		'deposit_year':deposit_year,
		'salary_deduction_per':salary_deduction_per,
		'deposit_id':deposit_id,
	};
    $.ajax({
    url: base_url+"deposit/insert_data",
    type: "post",
    async: false,
    data: data ,
    success: function (response) {
            console.log(response);
            if(response != ''){
                var obj = JSON.parse(response);
                $('.msg-container').html(obj.massage);
                $('.msg-container .msg-box').attr('style','display:block');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style','display:none');
                }, 6000);
				if($('#edit_modal').val() == 'Edit Using Modal'){
					table.clear();
					table.ajax.reload();
					$('.close').click();
					$('.preloader-2').attr('style','display:none !important;');
				}else{
					window.open((base_url+'deposit/index/'+employee_select), '_blank');
				}
            }else{
				$('.preloader-2').attr('style','display:none !important;');
			}
        }
    });
    // return true;
    return false;
  }
});
function delete_deposit($this){
    if (confirm("Are you sure you want to delete?")) {
		$('.preloader-2').attr('style','display:block !important;');
        jQuery(".loader-text").html("Deleting Designation");
        jQuery(".loader-wrap").show();
        var id=$this.attr("data-id");
		var emp_id=$this.attr("data-emp-id");
        var data = {
                'id': id,
				'emp_id': emp_id,
                };
               $.ajax({
            url: base_url+"deposit/deleteDeposit",
            type: "post",
            data: data ,
            success: function (response) {
				var obj = JSON.parse(response);
				if(obj.error == 0){
					$('.msg-container').html(obj.massage);
					$('.msg-container .msg-box').attr('style','display:block');
					setTimeout(function() {
						$('.msg-container .msg-box').attr('style','display:none');
					}, 6000);
					table.clear();
					table.ajax.reload();
					$('.preloader-2').attr('style','display:none !important;');
				}else{
					$('.msg-container').html(obj.massage);
					$('.msg-container .msg-box').attr('style','display:block');
					setTimeout(function() {
						$('.msg-container .msg-box').attr('style','display:none');
					}, 6000);
					$('.preloader-2').attr('style','display:none !important;');
				}

          },

          });
  }
  return false; 
}
});
function edit_deposit($this){
	var emp_id = $this.data('emp_id');
	var deposit_id = $this.data('id');
	var data = { 
		'id': emp_id,
		'deposit_id':deposit_id,
	};
    $.ajax({
    url: base_url+"deposit/getDeposit_data",
    type: "post",
    async: false,
    data: data ,
    success: function (response) {
		var obj = JSON.parse(response);
            console.log(obj);
            if(obj.get_deposit != ''){
				$('#deposit').val(obj.get_deposit[0].deposit_amount);
				$('#deposit_id').val(obj.get_deposit[0].id);
				$('#emp_name').val(obj.get_employee[0].fname+' '+obj.get_employee[0].lname);
				$.each($('#deposit_month option'),function(){
					if($(this).val() == obj.get_deposit[0].month){
						$(this).attr('selected','selected');
					}else{
						$(this).removeAttr('selected');
					}
				});
				$.each($('#deposit_year option'),function(){
					if($(this).val() == obj.get_deposit[0].year){
						$(this).attr('selected','selected');
					}else{
						$(this).removeAttr('selected');
					}
				});
				$('#edit_deposit').modal('show');
            }
			$('.preloader-2').attr('style','display: none !important;');
        }
    });
}