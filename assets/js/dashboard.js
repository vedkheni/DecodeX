function setTooltip(message) {
  $('button').tooltip('hide')
    .attr('data-original-title', message)
    .tooltip('show');
}
$('.panel-btn').click(function(){
	$(this).toggleClass('active');
	$(this).parents("div.panel").find('.panel-body').slideToggle('slow');
	$(this).parents("div.panel").toggleClass('active');
});
function hideTooltip() {
  setTimeout(function() {
    $('button').tooltip('hide');
  }, 1000);
}
$(document).ready(function ($) {
	$("div.panel").addClass('active');
  var base_url =$("#js_data").data('base-url');
	
	$(document).on('click','.increment-submit',function(){
		$('.increment-submit').prop('disabled', true);
		$('.btn-toggel').hide();
		var increment_amount = $("#increment_amount").val();
		var increment_date = $("#increment_date").val();
		if(increment_amount == '' || increment_date == ''){
			if (increment_amount == "") {
			jQuery("#increment_amount").addClass("required");
			} else {
				jQuery("#increment_amount").removeClass("required");
			}
			if (increment_date == "") {
			jQuery("#increment_date").addClass("required");
			} else {
				jQuery("#increment_date").removeClass("required");
			}
		}else{
			jQuery("#increment_date").removeClass("required");
			jQuery("#increment_amount").removeClass("required");
			var approved = confirm("Are you sure you want to approve increment?");
		  	if (approved == true) {
				$('.preloader-2').attr('style', 'display:block !important');
				$.ajax({
					url : base_url+'dashboard/insert_increment',
					type : 'post',
					data : $("#increment_form").serialize(),
					success : function(response){
						console.log(response);
						var obj = JSON.parse(response);
						if(obj.error_code == 0){
							$('.btn-toggel').show();
							hideTooltip();
							$('.close.close_popup').click();
							$('.preloader-2').attr('style', 'display:none !important');
							$('.msg-container').html(obj.message);
							$('.msg-container .msg-box').attr('style','display:block');
							setTimeout(function() {
								$('.msg-container .msg-box').attr('style','display:none');
							}, 6000);
							location.reload();
							$('.increment-submit').prop('disabled', false);
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
	$(document).on('click','.increment-submit-rejected',function(){
		$('.btn-toggel').hide();
		var rejected_increment_date = $("#rejected_increment_date").val();
		if(!rejected_increment_date){
			if (rejected_increment_date == "") {
				jQuery("#rejected_increment_date").addClass("required");
			} else {
				jQuery("#rejected_increment_date").removeClass("required");
			}
		}else{
			jQuery("#rejected_increment_date").removeClass("required");
			var rejected = confirm("Are you sure you want to update increment?");
			if (rejected == true) {
				$('.preloader-2').attr('style', 'display:block !important');
				$.ajax({
				  url : base_url+'dashboard/insert_increment_rejected',
				  type : 'post',
				  data : $("#increment_form_rejected").serialize(),
				  success : function(response){
				  	$('.btn-toggel').show();
					console.log(response);
					hideTooltip();
					$('.increment-submit-rejected').prop('disabled', true);
					$('.preloader-2').attr('style', 'display:none !important');
					location.reload();
				  }
				});
			}
		}
	});
	$(document).on('click','.increment-update-date',function(){
		$("#increment_amount").val();$("#next_increment_amount").val();$("#increment_date").val();$(".join_date").text();$(".current_salary").text();$(".employee_status").text();$("#id").val();
		var increment_status = $(this).data("increment-status");
		var employed_date = $(this).data("employed_date");
		if(increment_status == "Approved"){
			$('.approve_preloader').attr('style','display:block !important;');
				var id = $(this).data("id");
				var approv_id = $(this).data("approv_id");
				
				$(".join_date").text("");					  
				$(".current_salary").text("");					 
				$(".employee_status").text("");
				$("#emp_id").val("");
				$(".join_date").attr('data-join-date',"");
				$(".employee_name").text("");
				$("#increment_status").val("");	
					$('#increment_date').datepicker().data('datepicker').selectDate(new Date());

				$.ajax({
				  url : base_url+'dashboard/update_increment_status',
				  type : 'post',
				  data : {id:id,increment_status:increment_status},
				  success : function(response){
					 var obj = JSON.parse(response);
					 var joining_date = obj.joining_date;
					 if(obj.employed_date){
						employed_date = obj.employed_date;
					 }
					 var employee_name = obj.fname+" "+obj.lname;
					   $(".join_date").text(employed_date);					  
						$(".current_salary").text(obj.salary);					 
						$(".employee_status").text(obj.employee_status);
					  $("#emp_id").val(id);
					  $(".join_date").attr('data-join-date',employed_date);
					  $(".employee_name").text(employee_name);
					  $("#increment_status").val(increment_status);					 
					  /* if(obj.amount != ""){						  
					  $("#increment_amount").val(obj.amount);	
					  $("#next_increment_amount").val(obj.next_increment_date);	
					  $("#increment_date").val(obj.increment_date);				
					  $("#id").val(obj.id);						  				
					  $(".status-update").attr('data-index_id',obj.id);		
					  } */
					  $('.approve_preloader').attr('style','display:none !important;');

				  }
			});
		}
		if(increment_status == "Pending"){
			$('.reject_preloader').attr('style','display:block !important;');
			var reject_id = $(this).data("reject_id");
			var id = $(this).data("id");
			$(".join_date").text("");
			  $("#rejected_emp_id").val("");
			  $(".join_date").attr('data-join-date',"");
			  $(".employee_name").text("");
			  $("#rejected_increment_status").val("");
			 // $('#rejected_increment_date').datepicker().data('datepicker').selectDate(new Date());

				$.ajax({
				  url : base_url+'dashboard/update_increment_status',
				  type : 'post',
				  data : {id:id ,increment_status:increment_status},
				  success : function(response){
					 var obj = JSON.parse(response);
					 var joining_date = obj.joining_date;
					 var employee_name = obj.fname+" "+obj.lname;
					if(obj.employed_date){
						employed_date = obj.employed_date;
					 }
					  $(".join_date").text(employed_date);
					  $("#rejected_emp_id").val(reject_id);
					  $(".join_date").attr('data-join-date',employed_date);
					  $(".employee_name").text(employee_name);
					  $("#rejected_increment_status").val(increment_status);
					  $('.reject_preloader').attr('style','display:none !important;');

				  }
			});
		}
		
	});
	$(document).on('keypress', '#increment_amount', function(event){
	  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
		event.preventDefault();
	  }
	}); 
	if($('input').is('#increment_date')){
		$('#increment_date').datepicker({
			dateFormat: $('#js_data').data('dateformat'),
			language: 'en',
		});
	}
	if($('input').is('#rejected_increment_date')){
		$('#rejected_increment_date').datepicker({
			dateFormat: $('#js_data').data('dateformat'),
			language: 'en',
		});
	}
	if($('input').is('#next_increment_amount')){
		$('#next_increment_amount').datepicker({
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
});

$('#paidLeaveYear').change(function() {
	$('.preloader').attr('style', 'display:block !important');
	var id = $('#employee_id').val();
	var year = $(this).val();
	$.ajax({
		url : base_url+'paid_leave/paidLeave_byYear',
		type : 'post',
		data : {id:id ,year:year},
		success : function(response){
			// const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
			const months = [" ","Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
		   var obj = JSON.parse(response);
		   var html = '';
		   var $num = 0;
		   if(obj['employee_paid_leaves']){

			   html += '<table class="deposit-fixed">'+
			   '<tbody>'+
			   '<tr class="M_name emp_name month-details">'+
			   '<td class="emp_th">Month</td>';
			   $.each(obj['employee_paid_leaves'],function(index,$paid_leave){
				   html += '<td>'+months[$paid_leave['month']]+', '+$paid_leave['year']+'</td>';
				   // html += '<td>'+date("M, Y", mktime(0, 0, 0, $paid_leave['month'], 10, $paid_leave['year']))+'</td>';
				});
				html += '</tr>'+
				'</tbody>'+
				'</table>'+
				'<div class="deposit-list">'+
				'<table class="display nowrap deposit-list-table">'+
				'<tbody class="deposit-details paid_leave_detail">'+
				'<td class="emp_name">Paid <span>Leaves</span></td>';
				
				$.each(obj['employee_paid_leaves'],function(index,$v){
					if ($v['status'] == 'used') {
						$class_name = "deposite-pending";
						$leave_month = " "+months[$v['used_leave_month']];
						$leave_month_use = " - " + months[$v['used_leave_month']]+' '+($v['status']);
					} else if ($v['status'] == 'rejected') {
						$class_name = "deposite-rejected ";
						$leave_month = " "+months[$v['used_leave_month']];
						$leave_month_use = " - " + months[$v['used_leave_month']]+ ' '+($v['status']);
					} else if($v['status'] == 'unused') {
						$class_name = "";
						$leave_month = "(" + months[$v['month']] + ")";
						$leave_month_use = ""+' '+($v['status']);
					}else{
						$class_name = "all-deposite-paid ";
						$leave_month = " "+months[$v['used_leave_month']];
						$leave_month_use = " - " + months[$v['used_leave_month']]+ ' '+('paid');
					}
					html += '<td class="'+$class_name+'"><span title="'+$leave_month+'">'+$v['leave'] + ' ' + $leave_month_use+'</span></td>';
					$num++; 
				});
				html += '<input type="hidden" id="data_Leavecount" value="'+ $num +'">'+
				'</tbody>'+
				'</table>'+
				'</div>';
			}else{
				html = '<li class="no-data w-100 p-3">Data not available!</li>';
			}
			$('#paiLeave').html(html);
			$('#leave_count').text($num);
			$('.preloader').attr('style', 'display:none !important');
		}
  });
	// paidLeave_byYear
});