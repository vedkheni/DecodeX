var table = $('#example_tbl').DataTable({"fixedHeader": true,"oLanguage": {
	"sLengthMenu": "Show _MENU_ Entries",
	},});
jQuery(document).ready(function ($) {
	var base_url=$("#js_data").attr("data-base-url");
	var role=$("#js_data").attr("data-role");
	var emp_id=$("#emp-id").val();
	// var table = $('#example_tbl').DataTable({"fixedHeader": true,});
	
$(document).on('click','.increment-submit',function(e){
	e.preventDefault();
	$('.btn-toggel').hide();
	var increment_amount = $("#increment_amount1").val();
	var increment_date = $("#increment_date1").val();
	var increment_status_add = $("#increment_status_add").val();

	if(!increment_amount  || !increment_date || !increment_status_add){
		if (increment_amount == "") {
		jQuery("#increment_amount1").addClass("required");
		} else {
			jQuery("#increment_amount1").removeClass("required");
		}
		if (increment_date == "") {
		jQuery("#increment_date1").addClass("required");
		} else {
			jQuery("#increment_date1").removeClass("required");
		}
		if (increment_status_add == "") {
		jQuery("#increment_status_add").addClass("required");
		} else {
			jQuery("#increment_status_add").removeClass("required");
		}
	}else{
	
		jQuery("#increment_date1").removeClass("required");
		jQuery("#increment_amount1").removeClass("required");
	var approved = confirm("Are you sure you want to approve increment?");
	  if (approved == true) {
		$('.preloader-2').attr('style','display:block !important;');
		$('.increment-submit').prop('disabled', true);	
		$.ajax({
		  url : base_url+'increment/insert_increment',
		  type : 'post',
		  data : $("#increment_form").serialize(),
		  success : function(response){
			var obj = JSON.parse(response);
			if(obj.error_code == 0){
				var insert_id = obj.id;
				$('.msg-container').html(obj.message);
				$('.msg-container .msg-box').attr('style','display:block');
				setTimeout(function() {
					$('.msg-container .msg-box').attr('style','display:none');
				}, 6000);
				var increment_status1 = increment_status_add.toLowerCase().replace(/\b[a-z]/g, function(letter) {
					return letter.toUpperCase();
				});
				$('.increment-submit').prop('disabled', false);
				$('.preloader-2').attr('style','display:none !important;');
				$('.close').click();
				// var tb = $("#example_tbl").DataTable({"fixedHeader": true,});
				// var tb = $("#example_tbl").DataTable();
				var count1=table.rows().count();
				var d='<tr><td>'+(count1+1)+'</td><td class="increment_date_update'+insert_id+'">'+increment_date+'</td><td class="next_increment_date_update'+insert_id+'">'+increment_status1+'</td><td class="amount_update'+insert_id+'">'+increment_amount+'</td><td><button data-id="'+insert_id+'" data-increment_date="'+increment_date+'" data-status="'+increment_status_add+'" data-amount="'+increment_amount+'" class="edit-employee-increment btn btn-outline-secondary" data-toggle="modal" data-target="#modal_attendsnce">Edit</button><button data-id="'+insert_id+'" class="btn btn-outline-danger m-l-5 delete-employee-increment">Delete</button></td></tr>';
				table.row.add($(d).get(0));
				table.draw();
			}else{
				$('.msg-container').html(obj.message);
				$('.msg-container .msg-box').attr('style','display:block');
				setTimeout(function() {
					$('.msg-container .msg-box').attr('style','display:none');
				}, 6000);
				$('.preloader-2').attr('style', 'display:none !important');
				$('.increment-submit').prop('disabled', false);
			}
		 }
		});
	  }
	}
});

$(document).on('click', '.edit-employee-increment', function(){
		$("#increment_id").val("");
		$("#increment_date").val("");
		$("#next_increment_date").val("");
		$("#increment_amount").val("");
		jQuery("#increment_date").removeClass("required");
		jQuery("#increment_amount").removeClass("required");
		$("select#increment_status").html('<option value="" disabled=""> Select Status </option><option value="approved">Approved</option><option value="pending" >Pending</option>');
		
		var id = $(this).data('id');
		var status_val = $(this).data('status');
		var increment_status2 = $(".increment_status"+id).text();
		var increment_date = $(".increment_date_update"+id).text();
		//var next_increment_date="";
		/* if($(".next_increment_date_update"+id).text() != '0000-00-00'){
			next_increment_date = $(".next_increment_date_update"+id).text();
			$('#next_increment_date').datepicker().data('datepicker').selectDate(new Date(next_increment_date));

		} */
		
		var amount = $(".amount_update"+id).text();
		/* var increment_date = $(this).data('increment_date');
		var next_increment_date = $(this).data('next_increment_date');
		var amount = $(this).data('amount'); */
		$("#increment_id").val(id);
		$("#increment_date").val(increment_date);
		//$("#next_increment_date").val(next_increment_date);
		$("#increment_amount").val(amount);
		//$("#increment_status").val(status_val);
		var increment_status2 = increment_status2.toLowerCase().replace(/\b[a-z]/g, function(letter) {
				return letter.toLowerCase();
			});
		$('select[name^="increment_status"] option[value="'+increment_status2+'"]').attr("selected","selected");

		console.log(increment_status2);
		$('#increment_date').datepicker().data('datepicker').selectDate(new Date(increment_date));

});

$(document).on('click', '.update-increment', function(){

		var increment_id = $("#increment_id").val();
		var employee_id = $("#employee_select").val();
		var increment_date = $("#increment_date").val();
		
		var increment_status = $( 'select#increment_status option:selected').val();
		var increment_amount = $("#increment_amount").val();
		//console.log(increment_status + " - " +$( 'select#increment_status option:selected').val());
		//return false;
		  var data = {
				'employee_id' : employee_id,
				'increment_id': increment_id,
				'increment_date': increment_date,
				'increment_status': increment_status,
				'increment_amount': increment_amount,
                };
        if(increment_id && increment_date && increment_status && increment_amount){
			$('#increment_date').removeClass('error');
			$('#increment_status').removeClass('error');
			$('#increment_amount').removeClass('error');
			$.ajax({
				url: base_url+"increment/update_increment",
				type: "post",
				data: data ,
				success: function (response) {
					$('.msg-container').html(response);
					$('.msg-container .msg-box').attr('style','display:block');
					setTimeout(function() {
						$('.msg-container .msg-box').attr('style','display:none');
					}, 6000);
						increment_status = increment_status.toLowerCase().replace(/\b[a-z]/g, function(letter) {
							return letter.toUpperCase();
						});
					$(".increment_date_update"+increment_id).text(GetFormattedDate(increment_date));
					$(".increment_status"+increment_id).text(increment_status);
					$(".amount_update"+increment_id).text(increment_amount);
					
					/* if($('.edit-employee-increment').data('id') == increment_id){
						$('.edit-employee-increment').attr('data-increment_date',increment_date);	
						$('.edit-employee-increment').attr('data-next_increment_date',next_increment_date);	
						$('.edit-employee-increment').attr('data-amount',increment_amount);	
					} */
					$('.close').click();
				},
			});
		}else{
			if(increment_date){
				$('#increment_date').removeClass('error');
			}else{
				$('#increment_date').addClass('error');
			}
			if(increment_status){
				$('#increment_status').removeClass('error');
			}else{
				$('#increment_status').addClass('error');
			}
			if(increment_amount){
				$('#increment_amount').removeClass('error');
			}else{
				$('#increment_amount').addClass('error');
			}
		}
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
$(document).ready(function() {
	$('#increment_date1').datepicker().data('datepicker').selectDate(new Date());

if($('input').is('#increment_date')){
		$('#increment_date').datepicker({
			dateFormat: $('#js_data').data('dateformat'),
			language: 'en',
		});
	}
	if($('input').is('#increment_date1')){
		$('#increment_date1').datepicker({
			dateFormat: $('#js_data').data('dateformat'),
			language: 'en',
		});
	}
	if($('input').is('#next_increment_amount1')){
		$('#next_increment_amount1').datepicker({
			dateFormat: $('#js_data').data('dateformat'),
			language: 'en',
		});
	}
	if($('input').is('#next_increment_date')){
		$('#next_increment_date').datepicker({
			dateFormat: $('#js_data').data('dateformat'),
			language: 'en',
		});
	}
  $('#employee_select').on('change', function() {
	  		$('.preloader-2').attr('style','display:block !important;');

	  	var base_url=$("#js_data").attr("data-base-url");
	    var id=$(this).val();
		$("#emp_id").val(id);
		$('.add_new_emp').attr('data-id',id)
        $.ajax({
            url: base_url+"increment/append_data_employee",
            type: "post",
            data: {"id":id} ,
            success: function (response) {
				// var tb = $("#example_tbl").DataTable({"fixedHeader": true,});
				// var tb = $("#example_tbl").DataTable();
				
				 var obj = JSON.parse(response);
				 var employee_name=obj.employee_details[0].fname+" "+obj.employee_details[0].lname;
				$('.employee_name').text(employee_name);
				$('.employee_name1').text("Employee : "+employee_name);
				$('.join_date').text(GetFormattedDate(obj.employee_details[0].employed_date));
				if (obj.data != '') {
					table.clear();
					$.each(obj.data, function(k, v) {
						var payment_status=v.status;
						payment_status = payment_status.toLowerCase().replace(/\b[a-z]/g, function(letter) {
							return letter.toUpperCase();
						});
                       var d='<tr><td>'+(k+1)+'</td><td class="increment_date_update'+v.id+'">'+GetFormattedDate(v.increment_date)+'</td><td class="increment_status'+v.id+'">'+payment_status+'</td><td class="amount_update'+v.id+'">'+v.amount+'</td><td><button data-id="'+v.id+'" data-increment_date="'+v.increment_date+'" data-next_increment_date="'+v.next_increment_date+'" data-amount="'+v.amount+'" data-status="'+v.status+'"class="edit-employee-increment btn btn-outline-secondary" data-toggle="modal" data-target="#modal_attendsnce">Edit</button><button data-id="'+v.id+'" class="btn btn-outline-danger m-l-5 delete-employee-increment">Delete</button></td></tr>';
					   table.row.add($(d).get(0));
                    });
                    table.draw();
                } else {
					$('#example_tbl tbody').html("<tr><td colspan='5'>No Data Availbale</td></tr>");
					//tb.draw();
                }
				 $('.preloader-2').attr('style','display:none !important;');

				
			},
		});
  });

  	$(document).on('click','.add_new_emp',function(){
		var increment_status = $(this).data("increment-status");
		$('.approve_preloader').attr('style','display:block !important;');
		// var id = $(this).attr("data-id");
		var id = $('#employee_select').val();
		$("#myModal_increment .join_date").text("");					  
		$("#myModal_increment .current_salary").text("");					 
		$("#myModal_increment .employee_status").text("");
		$("#myModal_increment #emp_id").val("");
		$("#myModal_increment .join_date").attr('data-join-date',"");
		$("#myModal_increment .employee_name").text("");
		// $("#increment_status").val("");	
		$('#increment_date1').datepicker().data('datepicker').selectDate(new Date());

		$.ajax({
			url : base_url+'increment/update_increment_status',
			type : 'post',
			data : {id:id,increment_status:increment_status},
			success : function(response){
				var obj = JSON.parse(response);					 
				console.log(obj);
				var joining_date = obj.joining_date;
				// obj.increment_date
				var employed_date = (obj.employed_date != '' && obj.employed_date != undefined)? obj.employed_date: '';
				var employee_name = obj.fname+" "+obj.lname;
				$("#myModal_increment .current_salary").text(obj.salary);					 
				$("#myModal_increment .employee_status").text(obj.employee_status);
				$("#myModal_increment #emp_id").val(obj.id);
				if(employed_date.trim() != '' && employed_date.trim() != '0000-00-00'){
					$("#myModal_increment .join_date").text(GetFormattedDate(employed_date));					  
					$("#myModal_increment .join_date").attr('data-join-date',GetFormattedDate(employed_date));
				}else{
					$("#myModal_increment .join_date").text('0000-00-00');
					$("#myModal_increment .join_date").attr('data-join-date','0000-00-00');
				}
				$("#myModal_increment .employee_name").text(employee_name);
				// $("#increment_status").val(increment_status);
				$('.approve_preloader').attr('style','display:none !important;');

			}
		});
	});

});


$(document).on('click', '.delete-employee-increment', function(){
	var increment_id = $(this).data('id');
	  var data = {
			'id' : increment_id,
			};
	if(increment_id && confirm('Are you sure you want to delete?')){
		$.ajax({
			url: base_url+"increment/delete_increment",
			type: "post",
			data: data ,
			success: function (response) {
				$('.msg-container').html(response);
				$('.msg-container .msg-box').attr('style','display:block');
				setTimeout(function() {
					$('.msg-container .msg-box').attr('style','display:none');
				}, 6000);
				$('#employee_select').change();
			},
		});
	}else{
		
	}
});