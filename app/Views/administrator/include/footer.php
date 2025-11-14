<?php $this->allfunction = new \App\Libraries\Allfunction(); ?>
<!-- /.container-fluid -->
<?php $user_role = $this->session->get('user_role');
$user_session = $this->session->get('id'); ?>
<div class="modal in" id="mail_send_modal" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close_mail_modal" data-dismiss="modal"><i class="fas fa-times"></i></button>
				<div class="modal_header">
					<h4 class="modal-title emp_name employee_name">Interview Schedule Mail</h4>
				</div>
			</div>
			<form method="POST" enctype="multipart/form-data" action="<?php base_url('candidates/update_content'); ?>" id="send_mail-form">
				<!-- <?php
				/* $csrf = array(
					'name' => $this->security->get_csrf_token_name(),
					'hash' => $this->security->get_csrf_hash()
				); */
				?> -->
				<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
				<input type="hidden" name="mail_id" id="mail_id" value="" data-msg="Candidate Id Not Found">
				<input type="hidden" name="mail_schedule_id" id="mail_schedule_id" data-msg="Schedule Id Not Found" value="">
				<input type="hidden" name="mail_designation1" id="mail_designation1" data-msg="Designation Not Found" value="">
				<input type="hidden" name="mail_date1" id="mail_date1" data-msg="Interview Date Not Found" value="">
				<div class="modal-body">
					<div class="row">
						<div class="col-6">
							<p>Name</p>
						</div>
						<div class="col-6">
							<p id="mail_name"></p>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
							<p>Designation</p>
						</div>
						<div class="col-6">
							<p id="mail_designation"></p>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
							<p>Date</p>
						</div>
						<div class="col-6">
							<p id="mail_date"></p>
						</div>
					</div>
					<div class="form-group mt-2 mb-0">
						<div class="single-field">
							<input type="time" name="interview_time" id="interview_time" data-msg="Interview Time Not Found" autocomplete="off">
							<label>Time</label>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-center">
					<div class="row w-100">
						<div class="col-12 p-0 text-right">
							<button type="button" class="btn sec-btn schedule_fix_mail" onclick="schedule_fix_mail()">Send Mail</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
	<?php  if($user_role != 'admin'){ ?>
	<div class="modal" id="changePassword" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<div class="modal_header-content">
					<h4 class="modal-title">Change Password</h4>
					</div>
				</div>
				<form method="POST" enctype="multipart/form-data" method="post" action="<?php echo base_url('dashboard/changePassword') ?>" id="changePassword_form1">
					<input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
					<input type="hidden" name="user_id" id="user_id" value="">
					<input type="hidden" name="detail_type" id="detail_type" value="change_password">
					<input type="hidden" name="pass" id="pass" value="">
					<div class="modal-body">
						<div class="form-group">
						<div class="single-field pwd">
							<input type="password" name="old_password" id="old_password" value="">
							<div class="pass-eye" data-id="old_password">
								<i class="fas fa-eye"></i>
							</div>
							<label>Old Password</label>
						</div>
						</div>
						<div class="form-group">
						<div class="single-field pwd">
							<input type="password" name="new_password" id="new_password" value="">
							<div class="pass-eye" data-id="new_password">
								<i class="fas fa-eye"></i>
							</div>
							<label>New Password</label>
						</div>
						</div>
						<div class="form-group m-0">
						<div class="single-field pwd">
							<input type="password" name="confirm_password" id="confirm_password" value="">
							<div class="pass-eye" data-id="confirm_password">
								<i class="fas fa-eye"></i>
							</div>
							<label>Confirm New Password</label>
						</div>
						</div>
						</div>
						<div class="modal-footer">                         
					<button type="button"  class="btn sec-btn text-right" onclick="changePassword('changePassword');">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
	}
$todays_birthday = array();
$arr = $this->allfunction->allActive_employee();
if (isset($arr['get_employee']) && !empty($arr['get_employee'])) {
	$current_date = date('m-d');
	usort($arr['get_employee'], build_sorter('date_of_birth', 'ASC'));
	if (!empty($arr['get_employee'])) {
		foreach ($arr['get_employee'] as $emp) {
			$b_date = date('m-d', strtotime($emp->date_of_birth));
			if ($b_date == date('m-d')) {
				array_push($todays_birthday, $emp);
			}
		}
	}
}
if (!empty($todays_birthday)) {
?>
<?php
	$others_birthday = '';
	$my_birthday = '';
	foreach ($todays_birthday as $emp) {
		$flag = 0;
		if($user_role != 'admin'){
			if($emp->id == $user_session){$flag++;}
		}
		if ($emp->profile_image != "") {
			$img2 = $_SERVER['DOCUMENT_ROOT'] . "/assets/profile_image32x32/" . $emp->profile_image;
			if (file_exists($img2)) {
				$img = base_url() . "assets/profile_image32x32/" . $emp->profile_image;
			} else {
				$img =  ($emp->gender == 'male') ? base_url() . "assets/images/male-default.svg" : base_url() . "assets/images/female-default.svg";
			}
		} else {
			$img =  ($emp->gender == 'male') ? base_url() . "assets/images/male-default.svg" :  base_url() . "assets/images/female-default.svg";
		}
		$dateofbirth = Format_date($emp->date_of_birth);
		$today = date("Y-m-d");
		$diff = date_diff(date_create(Format_date($emp->date_of_birth)), date_create($today));

		if($flag == 0){
			$text = ($user_session == $emp->id) ? '<b>DecodeX Infotech</b> Wishing you a happy birthday and a wonderful year ahead.' : 'It’s ' . $emp->fname . ' ' . $emp->lname . '’s birthday today.';

			$others_birthday .= '<li class="">
				<a href="javascript:void(0)">
					<img src="'.$img.'" alt="user-img" class="img-circle">
					<span>'.$emp->fname . ' ' . $emp->lname.'<small class="text-primary">' . date('M d, Y') . '</small></span>
				</a>
			</li>';
		}else{ 
		$my_birthday .= '<div class="birthday-card-wrap col">
			<div class="birthday-card">
				<div class="back-image">
					<img src="'.base_url('assets/images/birthday-bg.jpg').'" alt="">
				</div>
				<img src="'.$img.'" alt="user-img" class="img-circle">
				<p class="b-name">
					<strong class="d-block">Happy Birthday</strong>
					<span>'.$emp->fname . ' ' . $emp->lname.'</span>
					<small class="d-block">' . date('M d, Y') . '</small>
				</p>
				<p class="b-message">
					<strong>DecodeX Team </strong>Wishing You a Very Happy Birthday! Have a Great Year Ahead & May Only The Best Come Your Way Always.
				</p>
			</div>
		</div>';
	} }
	// <small class="d-block">Today, ' . date('M Y') . ' - ' . $diff->format('%y') . ' Years old</small>
	?>
	<div class="modal <?php if(empty($my_birthday)){ echo 'other'; } ?> <?php if(!empty($my_birthday) && empty($others_birthday)){ echo 'selfe'; } ?>" id="birthday_modal" role="dialog">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body p-0">
					<button type="button" class="close" id="birthday_modal_close" data-dismiss="modal"><i class="fas fa-times"></i></button>
					<div class="modal-bday row">
						<?php if(!empty($my_birthday)){ echo $my_birthday; } ?>
						<div class="col <?php if(!empty($my_birthday) && empty($others_birthday)){ echo 'd-none'; } ?>">
							<div class="panel-body" style="display: block;">
								<div class="modal_header">
									<h4 class="modal-title emp_name employee_name">Today's Birthday</h4>
								</div>
								<ul class="chatonline b-date">
									<?php if(!empty($others_birthday)){ echo $others_birthday; } ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<span data-show_modal="<?php echo (!empty($todays_birthday)) ? 'show' : 'hide'; ?>" id="show_modal"></span>
<footer class="footer text-center">
	<sapn> &copy; Copyright <?php echo date('Y'); ?> by <a href="javascript:void(0);">DecodeX Infotech</a></span>
</footer>
<!-- <footer class="footer text-center"><sapn>2019 &copy; DecodeX Infotech brought to you by staff.geekwebsolution.com</span></footer> -->
</div>
</div>
<div id="js_data" data-base-url="<?php echo base_url(); ?>" data-dateformat="dd M, yyyy" data-role="<?php echo $this->session->get('user_role'); ?>" data-employee-id="<?php echo $user_session; ?>"></div>
<script>
	function GetFormattedDate($date) {
		var month_name = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
		var todayTime = new Date($date);
		var month = todayTime.getMonth();
		var day = todayTime.getDate();
		var year = todayTime.getFullYear();
		day = (day > 9) ? day : '0' + day;
		return day + " " + month_name[month] + ", " + year;
	}

	function text_validate(text) {
		var letters = /^[A-Za-z\s]+$/;
		if (text == '') {
			return false;
		} else {
			if (text.match(letters) && text.length <= 50) {
				return true;
			} else {
				return false;
			}
		}
	}

	function maxlength(obj, wordLen) {
		var len = obj.split(/[\s]+/);
		if (len.length > wordLen) {
			return false;
		} else {
			return true;
		}
	}
</script>
<?php

if (isset($js_flag) && !empty($js_flag)) {
	if (!empty($js_flag) && $js_flag == "emp_js" || $js_flag == "project_task_js" || $js_flag == "project_js") { ?>
		<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js?<?php echo VER; ?>"></script>
		<script src="<?php echo base_url(); ?>assets/js/jquery-ui-timepicker-addon.min.js?<?php echo VER; ?>"></script>

<?php }
} ?>
<script src="<?php echo base_url(); ?>assets/js/select2.min.js?<?php echo VER; ?>"></script>
<!-- Popper JS -->
<script src="<?php echo base_url(); ?>assets/js/popper.min.js?<?php echo VER; ?>"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js?<?php echo VER; ?>"></script>
<!-- Bootstrap Core JavaScript -->

<script>
	function getCookie(cname) {
		let name = cname + "=";
		let decodedCookie = decodeURIComponent(document.cookie);
		let ca = decodedCookie.split(';');
		for(let i = 0; i <ca.length; i++) {
			let c = ca[i];
			while (c.charAt(0) == ' ') {
			c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
			}
		}
		return "";
	}
	function setCookie(cname, cvalue, exdays) {
		const d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		let expires = "expires="+ d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}
	var base_url = $("#js_data").data('base-url');

	function mail_send_click($this) {
		$('#mail_name').text($this.data('name'));
		$('#mail_id').val($this.data('id'));
		$('#mail_schedule_id').val($this.data('schedule'));
		$('#mail_date1').val($this.data('date'));
		$('#mail_date').text($this.data('date'));
		if($this.data('time') == ''){
			var d = new Date();
  			// var time = d.getUTCHours()+':'+d.getUTCMinutes();
  			var time = d.toLocaleTimeString();
			  $('#interview_time').val(convertTime12to24(time));
		}else{
			$('#interview_time').val(convertTime12to24($this.data('time')));
		}
		$('#mail_designation1').val($this.data('designation'));
		$('#mail_designation').text($this.data('designation'));
		$('#mail_send_modal').modal('show');
	}

	const convertTime12to24 = (time12h) => {
		const [time, modifier] = time12h.split(' ');

		let [hours, minutes] = time.split(':');

		if (hours === '12') {
			hours = '00';
		}

		if (modifier === 'PM') {
			hours = parseInt(hours, 10) + 12;
		}

		return `${hours}:${minutes}`;
	}

	function schedule_fix_mail() {
		$('.preloader-2').attr('style', 'display:block !important');
		$('.schedule_fix_mail').prop('disabled', true);
		var id = $('#mail_id').val();
		var designation = $('#mail_designation1').val();
		var interview_date = $('#mail_date1').val();
		var interview_time = $('#interview_time').val();
		var schedule_id = $('#mail_schedule_id').val();
		if (interview_time == '00:00') {
			interview_time = '12:00 AM';
		} else {
			interview_time = tConvert(interview_time);
		}
		var $message_box = ['mail_id', 'mail_designation1', 'mail_date1', 'interview_time', 'mail_schedule_id'];
		if (id != '' && designation != '' && interview_date != '' && interview_time != '' && schedule_id != '') {
			if (confirm("Are You Sure You Want To Send Mail?")) {
				var data = {
					'id': id,
					'interview_date': interview_date,
					'designation': designation,
					'time': interview_time,
					'schedule_id': schedule_id,
				};
				$.ajax({
					url: base_url + "candidates/send_mail",
					type: "post",
					data: data,
					success: function(response) {
						var obj = JSON.parse(response);
						if (obj.error_code == 0) {
							$('#mail_send_modal').modal('hide');
							$('.msg-container').html(obj.message);
							$('.msg-container .msg-box').attr('style', 'display:block');
							setTimeout(function() {
								$('.msg-container .msg-box').attr('style', 'display:none');
							}, 6000);
							$('.schedule_fix_mail').prop('disabled', false);
						} else {
							$('.msg-container').html(obj.message);
							$('.msg-container .msg-box').attr('style', 'display:block');
							setTimeout(function() {
								$('.msg-container .msg-box').attr('style', 'display:none');
							}, 6000);
							$('.schedule_fix_mail').prop('disabled', false);
							$('.preloader-2').attr('style', 'display:none !important');
						}
					},
				});
			} else {
				$('.schedule_fix_mail').prop('disabled', false);
				$('.preloader-2').attr('style', 'display:none !important');
			}
		} else {
			var html = '';
			$.each($message_box, function(i, v) {
				if ($message_box.length != (i + 1)) {
					var value = ($('#' + v).val());
					if (!value) {
						var msg = $('#' + v).data('msg');
						html += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' + msg + '</p></div></div></div>';
					} else {
						$(v).removeClass('error');
					}
				}
			});
			$('.msg-container').html(html);
			$('.msg-container .msg-box').attr('style', 'display:block');
			setTimeout(function() {
				$('.msg-container .msg-box').attr('style', 'display:none');
			}, 6000);
			$('.schedule_fix_mail').prop('disabled', false);
		}
	}

	function tConvert(time) {
		// Check correct time format and split into components
		time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

		if (time.length > 1) { // If time format correct
			time = time.slice(1); // Remove full string match value
			time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
			time[0] = +time[0] % 12 || 12; // Adjust hours
		}
		return time.join(''); // return adjusted time or original string
	}

	function get_month_year(num) {
		var exp = '';
		if (num <= 0) {
			exp += 'Fresher';
		} else {
			var number = num.split('.');
			if (number[1]) {
				var exp1 = '';
				var exp2 = '';
				if (number[1] > 11) {
					var year1 = ('' + (parseFloat(number[1]) / 12)).split('.');
					var year = number[0] + year1[0];
					exp1 += check_year(year);
					var month = number[1] - (year1[0] * 12);
					exp2 += check_month(month);
				} else {
					exp1 += check_year(number[0]);
					exp2 += check_month(number[1]);
				}
				exp += exp1 + ' ' + exp2;
			} else {
				exp += check_year(number[0]);
			}
		}
		return exp;
	}

	function check_year(number) {
		var exp1 = '';
		if (number == 1) {
			exp1 += number + ' Year';
		} else if (number <= 0) {
			exp1 += '';
		} else {
			exp1 += number + ' Years';
		}
		return exp1;
	}

	function check_month(number) {
		var exp1 = '';
		if (number == 1) {
			exp1 += number + ' Month';
		} else if (number <= 0) {
			exp1 += '';
		} else {
			exp1 += number + ' Months';
		}
		return exp1;
	}

	function myFunction(x) {
		x.classList.toggle("change");
	}
	$(document).ready(function() {
		$(".hamburger").click(function() {
			// $(".menu").fadeToggle();    
			$(".menu").toggleClass('menu-active');
			$("body").toggleClass('fix-body');
		});
	});
</script>
<script>
	$("#btn-download").click(function() {
		$(this).toggleClass("downloaded");
	});
</script>
<!-- Select2 -->

<script>
	$(".multiple").select2({
		placeholder: "Select  Developer's",
		allowClear: true
	});
	$('.attachments').bind('change', function() {
		var filename = $(".attachments").val();
		if (/^\s*$/.test(filename)) {
			$(".file-upload").removeClass('active');
			$("#noFile").text("No file chosen...");
		} else {
			$(".file-upload").addClass('active');
			$("#noFile").text(filename.replace("C:\\fakepath\\", ""));
		}
	});
	$('.id_proof').bind('change', function() {
		var filename = $(".id_proof").val();
		if (/^\s*$/.test(filename)) {
			$(".id_upload").removeClass('active');
			$("#noFile").text("No file chosen...");
		} else {
			$(".id_upload").addClass('active');
			$("#noFile").text(filename.replace("C:\\fakepath\\", ""));
		}
	});
	$('.emp_signature').bind('change', function() {
		var filename = $(".emp_signature").val();
		if (/^\s*$/.test(filename)) {
			$(".sign_upload").removeClass('active');
			$("#noFile1").text("No file chosen...");
		} else {
			$(".sign_upload").addClass('active');
			$("#noFile1").text(filename.replace("C:\\fakepath\\", ""));
		}
	});
</script>
<script src="<?php echo base_url(); ?>assets/js/slider-menu.js?<?php echo VER; ?>"></script>
<script src="<?php echo base_url(); ?>assets/js/head.js?<?php echo VER; ?>"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js?<?php echo VER; ?>"></script>


<?php

$datatable = array('pc_issue_js', 'candidates_js', 'employee_attendance_js', 'employee-attendance_admin_js', 'task-issues', 'designation_js', 'project_js', 'profile_js', 'project_task_js', 'emp_js', 'employee_report_js', 'leave_report_js', 'prof_tax_js', 'reports_js', 'bonus_js', 'deposit_js', 'increment_js', 'internship_js', 'salary_pay_js', 'salary_pay_new_js', 'leave_request_js', 'dashboard_js', 'holiday_js', 'paid_leave_js', 'mail_content_js','workingHours_report_js','broadcast_message_js');
// $rowReorder=array('emp_js','reports_js','salary_pay_js','leave_request_js','dashboard_js','employee_attendance_js');
$rowReorder = array('reports_js', 'employee_attendance_js');
$air_datepicker = array('increment_js', 'internship_js', 'emp_js', 'dashboard_js', 'reports_js', 'leave_request_js', 'employee-attendance_admin_js', 'profile_js', 'employee_attendance_admin_js', 'holiday_js', 'paid_leave_js', 'candidates_js','workingHours_report_js','broadcast_message_js','employee_report_js');
$fancybox = array('dashboard_js', 'pc_issue_js','salary_pay_js');

if (in_array($js_flag, $fancybox)) { ?>
	<script src="<?php echo base_url(); ?>assets/js/jquery.fancybox.min.js?<?php echo VER; ?>"></script>
	<?php }
if (isset($js_flag) && !empty($js_flag)) {
	if ($js_flag != "holiday_view_js") { ?>
		<!-- <script src="<?php //echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script> -->
	<?php 	}
	if (in_array($js_flag, $datatable)) { ?>
		<!-- <script src="<?php //echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script> -->
		<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js?<?php echo VER; ?>"></script>
		<!-- <script src="<?php //echo base_url(); ?>assets/js/dataTables.fixedHeader.min.js"></script> -->
		<?php
		if (in_array($js_flag, $rowReorder)) { ?>
			<script src="<?php echo base_url(); ?>assets/js/dataTables.rowReorder.min.js?<?php echo VER; ?>"></script>
			<script src="<?php echo base_url(); ?>assets/js/dataTables.responsive.min.js?<?php echo VER; ?>"></script>
		<?php }
	}
	if (in_array($js_flag, $air_datepicker)) { ?>
		<script src="<?php echo base_url(); ?>assets/js/air-datepicker.min.js?<?php echo VER; ?>"></script>
		<script src="<?php echo base_url(); ?>assets/js/air-datepicker.en.js?<?php echo VER; ?>"></script>

	<?php }
	if ($js_flag == "emp_js") { ?>
		<!--<script src="<?php //echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>-->
		<script>
			$('#joining_date, #employed_date, #interview_date, #birth_date, #increment_date, #next_increment_date').datepicker({
				dateFormat: $('#js_data').data('dateformat'),
				language: 'en',
			});
			/* $('').datepicker({
				dateFormat: 'yyyy-mm-dd',
				language: 'en',
			});
			$('').datepicker({
						dateFormat: 'yyyy-mm-dd',
						language: 'en',
			});
			$('').datepicker({
						dateFormat: 'yyyy-mm-dd',
						language: 'en',
			});
			$('').datepicker({
						dateFormat: 'yyyy-mm-dd',
						language: 'en',
			}); */
		</script>
		<script src="<?php echo base_url(); ?>assets/js/employee.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'employee_report_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/employee_report.js?<?php echo VER; ?>"></script>
		<!-- <script src="<?php // echo base_url(); ?>/assets/js//daterangepicker.min.js?<?php //echo VER; ?>"></script> -->
	<?php } else if ($js_flag == 'deposit_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/deposit_report.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'leave_report_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/leave_report.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'prof_tax_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/prof_tax.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'designation_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/designation.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'candidates_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/candidates.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'pc_issue_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/pc_issue.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'mail_content_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/mail_content.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'profile_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/profile.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'paid_leave_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/paid_leave.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == "bonus_new_js" || $js_flag == "deposit_report_new_js" || $js_flag == "prof_tax_new_js" || $js_flag == "paid_leave_report_new_js" || $js_flag == "use_paid_leave_report_new_js" || $js_flag == "leave_report_new_js" || $js_flag == "sick_leave_report_js" || $js_flag == "salary_report_new_js") { ?>
		<script src="<?php echo base_url(); ?>assets/js/reports_new.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'project_js') { ?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#start_date').datepicker({
					dateFormat: 'yy-mm-dd',
				});
				$('#end_date').datepicker({
					dateFormat: 'yy-mm-dd',
				});

			});
		</script>
		<script src="<?php echo base_url(); ?>assets/js/project.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'project_task_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/project-task.js?<?php echo VER; ?>"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				var startDate;
				$('.start_date').datetimepicker({
					dateFormat: $('#js_data').data('dateformat'),
					timeFormat: "hh:mm tt",
					minDate: 0,
					onChangeDateTime: function(dp, $input) {
						startDate = $(".start_date").val();
					}
				});
				$('.end_date').datetimepicker({
					dateFormat: $('#js_data').data('dateformat'),
					timeFormat: "hh:mm tt",
					onClose: function(current_time, $input) {
						var endDate = $(".end_date").val();
						startDate = $(".start_date").val();
						if (startDate > endDate) {
							$('.error_msg').html('<span style="color:red;">End Date should not be less than Start Date </span>');
							$(".end_date").addClass("error");
						} else {
							$('.error_msg').html('');
							$(".end_date").removeClass("error");
						}
					}

				});

				/*   $('.start_date').datetimepicker({
				      format: 'YYYY-MM-DD HH:mm:ss',
				 });
				 $('.end_date').datetimepicker({
				      format: 'YYYY-MM-DD HH:mm:ss',
				 });  */

			});
		</script>
	<?php } else if ($js_flag == 'task-issues') { ?>
		<script src="<?php echo base_url(); ?>assets/js/task-issues.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'employee_attendance_admin_js' || $js_flag == 'employee_attendance_profile_js') { ?>
		<!-- <script src="<?php //echo base_url(); ?>assets/js/jquery-ui.min.js?<?php //echo VER; ?>"></script> -->
		<script src="<?php echo base_url(); ?>assets/js/employee-attendance-form.js?<?php echo VER; ?>"></script>
		<script>
			jQuery(document).ready(function($) {
				var weekday = new Array(7);
				weekday[0] = "Sunday";
				weekday[1] = "Monday";
				weekday[2] = "Tuesday";
				weekday[3] = "Wednesday";
				weekday[4] = "Thursday";
				weekday[5] = "Friday";
				weekday[6] = "Saturday";
				// $('#datepicker').datepicker({
				// 	dateFormat: 'd MM yy',
				// 	beforeShowDay: noSunday,
				// 	maxDate: new Date(),
				// 	onSelect: function(dateText, inst) {
				// 	  var date = $(this).datepicker('getDate');
				// 	  var dayOfWeek = weekday[date.getUTCDay()+1];
				// 	  $("#weekday").text(dayOfWeek);	
				// 	  // dayOfWeek is then a string containing the day of the week
				// 	}

				// });

				function noSunday(date) {
					var day = date.getDay();
					return [(day > 0), ''];
				}
			});
		</script>
	<?php } else if ($js_flag == 'employee_attendance_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/employee-attendance.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'employee-attendance_admin_js') { ?>
		<!-- <script src="<?php //echo base_url(); ?>assets/js/dataTables.rowReorder.min.js?<?php //echo VER; ?>"></script> -->
		<!-- <script src="<?php //echo base_url(); ?>assets/js/dataTables.responsive.min.js?<?php //echo VER; ?>"></script> -->
		<script src="<?php echo base_url(); ?>assets/js/employee-attendance_admin.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'holiday_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/holiday.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'holiday_view_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-year-calendar.js?<?php echo VER; ?>"></script>
		<script src="<?php echo base_url(); ?>assets/js/holiday_calendar.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'reports_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/reports.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'workingHours_report_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/workingHours_report.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'bonus_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/bonus.js?<?php echo VER; ?>"></script>

	<?php } else if ($js_flag == 'increment_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/increment.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'internship_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/internship.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'deposit_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/deposit.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'salary_pay_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/salary_pay.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'broadcast_message_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/broadcast_message.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'salary_pay_new_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/salary_pay_new.js?<?php echo VER; ?>"></script>
	<?php } else if ($js_flag == 'leave_request_js' || $js_flag == 'dashboard_js') { ?>
		<script src="<?php echo base_url(); ?>assets/js/leave_request.js?<?php echo VER; ?>"></script>
		<script>
			$('#joining_date, #birth_date').datepicker({
				dateFormat: $('#js_data').data('dateformat'),
				language: 'en',
			});
			/* $('').datepicker({
						dateFormat: 'yyyy-mm-dd',
						language: 'en',
			}); */
			var disabledDays = [0, 6];

			function getNextWeek() {
				var today = new Date();
				var nextWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 7);
				return nextWeek;
			}

			function noSunday(date) {
				var day = date.getDay();
				return [(day > 0), ''];
			}
			var nextWeek = getNextWeek();
			var lastWeekMonth = nextWeek.getMonth() + 1;
			var lastWeekDay = nextWeek.getDate();
			var lastWeekYear = nextWeek.getFullYear();
			var lastWeekDisplayPadded = ("00" + lastWeekYear.toString()).slice(-4) + "-" + ("00" + lastWeekMonth.toString()).slice(-2) + "-" + ("0000" + lastWeekDay.toString()).slice(-2);
			<?php if ($user_role != "admin") { ?>
				$('#leave_date').datepicker({
					dateFormat: $('#js_data').data('dateformat'),
					language: 'en',
					minDate: new Date(lastWeekDisplayPadded),
					onRenderCell: function(date, cellType) {
						if (cellType == 'day') {
							var day = date.getDay(),
								isDisabled = disabledDays.indexOf(day) != -1;
							return {
								disabled: isDisabled
							}
						}
					}
				});
			<?php } else { ?>

				$('#leave_date').datepicker({
					dateFormat: $('#js_data').data('dateformat'),
					language: 'en',
					onRenderCell: function(date, cellType) {
						if (cellType == 'day') {
							var day = date.getDay(),
								isDisabled = disabledDays.indexOf(day) != -1;
							return {
								disabled: isDisabled
							}
						}
					}
				});
				jQuery(document).ready(function($) {

					if ($("#edit_date").val() && $("#edit_date").val() != "") {
						var edit_date = $("#edit_date").val();
						var date_val = edit_date.split('-');
						var moth = date_val[1] - 1;
						$('#leave_date').datepicker({
							onRenderCell: function(date, cellType) {
								if (cellType == 'day') {
									var day = date.getDay(),
										isDisabled = disabledDays.indexOf(day) != -1;
									return {
										disabled: isDisabled
									}
								}
							}
						});
						$('#leave_date').datepicker().data('datepicker').selectDate(new Date(date_val[0], moth, date_val[2]));
					}
				});

			<?php } ?>
		</script>
	<?php } else { ?>
		<script src="<?php echo base_url(); ?>assets/js/attendance.js?<?php echo VER; ?>"></script>
<?php  }
	//task-issues
} ?>
<!--slimscroll JavaScript -->
<script src="<?php echo base_url(); ?>assets/js/dashboard.js?<?php echo VER; ?>"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/jquery.min.js?<?php echo VER; ?>"></script> -->
<!--  <script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js?<?php echo VER; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.sparkline.min.js?<?php echo VER; ?>"></script> -->
<!-- Custom Theme JavaScript -->
<div class="short-action">
	<!-- <button type="button" class="short-action-btn" id="short-action1"><i id="short-action2" class="fas fa-plus"></i></button> -->
	<ul>
		<?php if ($user_role == 'admin') { ?>
			<!-- Admin Side Link -->
			<li class="<?php if (isset($menu) && $menu == 'full_month_attendance') {
							echo 'active';
						} ?>"><a href="<?php echo base_url(); ?>employee/full_month_attendance">Add Attendance</a></li>
			<li class="<?php if (isset($menu) && $menu == 'leave_request') {
							echo 'active';
						} ?>"><a href="<?php echo base_url(); ?>leave_request">Leave</a></li>
			<!-- <li class="<?php if (isset($menu) && $menu == 'leave_request_add') {
								echo 'active';
							} ?>"><a href="<?php echo base_url(); ?>leave_request/add">Add Leave</a></li> -->
			<li class="<?php if (isset($menu) && $menu == 'salary_pay') {
							echo 'active';
						} ?>"><a href="<?php echo base_url(); ?>salary_pay">Pay Salary</a></li>
			<!-- <li class="<?php if (isset($menu) && $menu == 'holiday_add') {
								echo 'active';
							} ?>"><a href="<?php echo base_url(); ?>holiday/add">Add Holiday</a></li> -->
			<li class="<?php if (isset($menu) && $menu == 'holiday') {
							echo 'active';
						} ?>"><a href="<?php echo base_url(); ?>holiday">Holiday</a></li>
			<li class="<?php if (isset($menu) && $menu == 'add_emp') {
							echo 'active';
						} ?>"><a href="<?php echo base_url(); ?>employee/add">Add Employee</a></li>
			<li class="<?php if (isset($menu) && $menu == 'employee_report') {
							echo 'active';
						} ?>"><a href="<?php echo base_url(); ?>reports/employee_report">View Reports</a></li>
		<?php } else { ?>
			<!-- Employee Side Link -->
			<!-- <li class="<?php if (isset($menu) && $menu == 'employee_add_attendance') {
								echo 'active';
							} ?>"><a href="<?php echo base_url(); ?>profile/add_employee_attendance">Add Attendance</a></li> -->
			<li class="<?php if (isset($menu) && $menu == 'employee_attendance') {
							echo 'active';
						} ?>"><a href="<?php echo base_url(); ?>employee/employee_attendance_list/<?php echo $user_session; ?>">Attendance</a></li>
			<!-- <li class="<?php if (isset($menu) && $menu == 'leave_request_add') {
								echo 'active';
							} ?>"><a href="<?php echo base_url(); ?>leave_request/add">Add Leave</a></li> -->
			<li class="<?php if (isset($menu) && $menu == 'leave_request') {
							echo 'active';
						} ?>"><a href="<?php echo base_url(); ?>leave_request">Leave</a></li>
			<li class="<?php if (isset($menu) && $menu == 'salary_pay') {
							echo 'active';
						} ?>"><a href="<?php echo base_url(); ?>salary_pay">Salary</a></li>
			<li class="<?php if (isset($menu) && $menu == 'salary_slip') {
							echo 'active';
						} ?>"><a href="<?php echo base_url(); ?>profile/download_salary_slip">Download Salary Slip</a></li>
		<?php } ?>

	</ul>
</div>
<button type="button" class="scrollToTop" ><i class="fas fa-chevron-up"></i></button>
<script src="<?php echo base_url(); ?>assets/js/custom.min.js?<?php echo VER; ?>"></script>
<?php
if (isset($js_flag) && !empty($js_flag)) {
	if ($js_flag == 'task_design') { ?>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js?<?php echo VER; ?>"></script>
		<script src='<?php echo base_url(); ?>assets/js/umd/popper.min.js?<?php echo VER; ?>'></script>
		<script src='<?php echo base_url(); ?>assets/js/fullcalendar.min.js?<?php echo VER; ?>'></script>
		<script src='<?php echo base_url(); ?>assets/js/datepicker.min.js?<?php echo VER; ?>'></script>
		<script src="<?php echo base_url(); ?>assets/js/calander_script.js?<?php echo VER; ?>"></script>
<?php } } ?>

<div class="msg-container">
	<div class="msg-box error-box">
		<div class="msg-content">
			<div class="msg-icon"><i class="fas fa-times"></i></div>
			<div class="msg-text">
				<p>This is only error message.</p>
			</div>
		</div>
	</div>
	<div class="msg-box success-box">
		<div class="msg-content">
			<div class="msg-icon"><i class="fas fa-check"></i></div>
			<div class="msg-text">
				<p>This is only Success message.</p>
			</div>
		</div>
	</div>
</div>

<?php if($js_flag == 'admin_profile_js') { ?>
	<div class="msg-container">
		<?php $html = '';
		$a = explode('</p>', $this->session->getFlashdata('message'));
		$a = array_filter($a);
		if (isset($a[0]) && $a[0] != '') {
			for ($i = 0; $i < count($a); $i++) {
				if (!empty($a[$i]) && ($i + 1) != count($a)) {
					$html .= '<div class="msg-box error-box box1">
                    <div class="msg-content">
                        <div class="msg-icon"><i class="fas fa-times"></i></div>
                        <div class="msg-text text1">' . $a[$i] . '</div>
                    </div>
                </div>';
				}
			}
			echo $html;
		} ?>
		<?php echo $this->session->getFlashdata('messages'); ?>
	</div>
	<script>
		$(document).ready(function() {
			if ($(".text1 p").text() != '') {
				$('.msg-container .box1').attr('style', 'display:block');
				setTimeout(function() {
					$('.msg-container .box1').attr('style', 'display:none');
				}, 6000);
			}
			if ($(".text2 p").text() != '') {
				$('.msg-container .box2').attr('style', 'display:block');
				setTimeout(function() {
					$('.msg-container .box2').attr('style', 'display:none');
				}, 6000);
			}
		});
	</script>
<?php } ?>
</body>

</html>

