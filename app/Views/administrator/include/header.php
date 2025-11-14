<?php
//phpinfo();
/* $total = $this->uri->total_segments();

$first_segments=$this->uri->segment(1);
$last_segment = $this->uri->segment($total); */
$this->session = session();

function build_sorter($key, $dir = 'ASC')
   {
      return function ($a, $b) use ($key, $dir) {
         $t1 = strtotime(date('Y') . '-' . date('m-d', strtotime(is_array($a) ? $a[$key] : $a->$key)));
         $t2 = strtotime(date('Y') . '-' . date('m-d', strtotime(is_array($b) ? $b[$key] : $b->$key)));
         if ($t1 == $t2) return 0;
         return (strtoupper($dir) == 'ASC' ? ($t1 < $t2) : ($t1 > $t2)) ? -1 : 1;
      };
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#0675e8"/>

	<link rel="apple-touch-icon" sizes="57x57" href="/assets/images/maskeble-icon.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/assets/images/maskeble-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/assets/images/maskeble-icon.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/assets/images/maskeble-icon.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/assets/images/maskeble-icon.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/assets/images/maskeble-icon.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/assets/images/maskeble-icon.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/assets/images/maskeble-icon.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/assets/images/maskeble-icon.png">

	<link rel="manifest" href="/manifest.json">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/images/favicon.png">
    <title><?php if(isset($page_title)){ echo $page_title ; }  ?></title>
	
	<!-- $js_flag == "emp_js" -->
	<?php	
		$air_datepicker=array('increment_js','internship_js','emp_js','dashboard_js','reports_js','leave_request_js','employee-attendance_admin_js','profile_js','employee_attendance_admin_js','holiday_js','paid_leave_js','candidates_js','workingHours_report_js','broadcast_message_js','employee_report_js'); 

		$fancybox=array('dashboard_js','pc_issue_js','salary_pay_js'); 
		
	 if(isset($js_flag) && !empty($js_flag)){ 
		if(isset($js_flag) && $js_flag == "employee_attendance_admin_js" || $js_flag == "project_js" || $js_flag == 'project_task_js'){ ?>
		<!-- <link rel="stylesheet" href="<?php //echo base_url(); ?>assets/css/jquery-ui.min.css?<?php echo VER; ?>"> -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/air-datepicker.min.css?<?php echo VER; ?>">
		<!-- <link rel="stylesheet" href="<?php //echo base_url(); ?>assets/css/jquery-ui-timepicker-addon.min.css?<?php //echo VER; ?>"> -->
    <?php } else if(in_array($js_flag,$air_datepicker)){ ?>	
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/air-datepicker.min.css?<?php echo VER; ?>">
	<?php } else if($js_flag == "holiday_view_js"){ ?>	
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-year-calendar.css?<?php echo VER; ?>">
	
	<?php } else if($js_flag == "employee_attendance_js"){ ?>	
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.min.css?<?php echo VER; ?>">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/editor.dataTables.min.css?<?php echo VER; ?>">
		<?php }
		//if($js_flag == 'employee_report_js'){?>
			<!-- <link rel="stylesheet" href="<?php // echo base_url(); ?>/assets/css/daterangepicker.css?<?php // echo VER; ?>"> -->
	<?php //} 
	} ?>
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.min.css?<?php echo VER; ?>">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/editor.dataTables.min.css?<?php echo VER; ?>"> -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/fixedHeader.dataTables.min.css"> -->
    <?php if(in_array($js_flag,$fancybox)){ ?>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.fancybox.min.css?<?php echo VER; ?>">
	<?php } ?>	
	
    <!-- Select2 CSS -->
    <link href="<?php echo base_url(); ?>assets/css/select2.min.css?<?php echo VER; ?>" rel="stylesheet" />
    <!-- Bootstrap Core CSS -->
	
    <!-- DataTables CSS -->
    <link href="<?php echo base_url(); ?>assets/css/dataTables.min.css?<?php echo VER; ?>" id="theme" rel="stylesheet">
	
	<link href="<?php echo base_url(); ?>assets/css/calander_style.css?<?php echo VER; ?>" rel="stylesheet">
	<!-- fonntawesome css -->
	<link href="<?php echo base_url(); ?>assets/css/all.min.css?<?php echo VER; ?>" rel="stylesheet">
	<!-- Bootstrap CSS -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css?<?php echo VER; ?>" rel="stylesheet">
	
	<?php if($js_flag == "employee_attendance_js"){ ?>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/responsive.bootstrap.min.css?<?php echo VER; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/responsive.jqueryui.min.css?<?php echo VER; ?>">
	<?php } ?>
	
	<!-- Custom Style CSS -->
	<link href="<?php echo base_url(); ?>assets/css/style.min.css?<?php echo VER; ?>" rel="stylesheet">

	<!-- <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script> -->
	<script src="<?php echo base_url(); ?>assets/js/jquery-3.5.1.min.js?<?php echo VER; ?>"></script>
	<!-- <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css?<?php echo VER; ?>" rel="stylesheet"> -->
<?php if($js_flag == "terms_and_condition" || $js_flag == "mail_content_js"){ ?>   
<script src="<?php echo base_url(); ?>assets/js/ckeditor.js?<?php echo VER; ?>"></script>
<?php } ?>
</head>
<?php 
   $user_session=$this->session->get('id');
   $user_role=$this->session->get('user_role');
   $admin_id=$this->session->get('admin_id');
   
   $user_id=$this->session->get('id');
   // $user_id=$this->session->get('user_id');
   $username=$this->session->get('username');
   $useremail=$this->session->get('useremail');
   $employee_name=$this->session->get('employee_name');
   $profile_image=$this->session->get('profile_image');
   //echo "menu url".$menu;
   ?>
<div class="announceHeader-wrap">
	<header id="header" class="mb-header">
		<div class="container-fluid">
			<div class="row align-item-center">
				<div class="col-12">
					<div class="header-top-content">
						<div class="site-branding">
							<a href="<?php echo base_url(); ?>" title="<?php echo base_url(); ?>">
								<img class="logo-img-lg" src="<?php echo base_url(); ?>assets/images/decodex.svg" alt="home" />
							</a>
						</div>
						<button type="button" class="header-btn">
							<span></span>
							<span></span>
							<span></span>
						</button>
					</div>
				</div>
			</div>
		</div>
			<nav class="site-navigation">
				<div class="header-menu-container">
					<ul class="primary-menu">
						<li class="<?php if(!empty($menu) && $menu == 'dashboard'){ echo "active"; } ?>">
							<a href="<?php echo base_url('dashboard'); ?>" class="header-menu-item <?php if(!empty($menu) && $menu == 'dashboard'){ echo "active"; } ?>">
							   <img src="<?php echo base_url(); ?>assets/images/dashboard.svg" alt="Dashboard">
							   <span>Dashboard</span>
							</a> 
						 </li>
						 <?php if($user_role != 'admin'){ ?>
						<?php if(isset($menu) && ($menu == 'employee_add_attendance' || $menu == 'employee_attendance')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = 'display:none';} ?>
						 <li class="<?php echo $active; ?>">
							<a href="<?php echo base_url('employee/employee_attendance_list/'.$user_session); ?>" class="header-menu-item <?php echo $active; ?>">
							   <img src="<?php echo base_url(); ?>assets/images/attendance.svg" alt="Attendance">
							   <span>Attendance</span>
							</a>
						 </li>
						 <li class="<?php if(!empty($menu) && $menu == 'holiday_view'){ echo "active"; } ?>">
							<a href="<?php echo base_url('holiday'); ?>" class="header-menu-item <?php if(!empty($menu) && $menu == 'holiday_view'){ echo "active"; } ?>">
							   <img src="<?php echo base_url(); ?>assets/images/holiday.svg" alt="Holiday">
							   <span>Holiday</span>
							</a>
						 </li>
						 <?php } ?>
						 <?php if($user_role == 'admin'){ ?>
							<?php if(isset($menu)  && ( $menu == 'employee' || $menu == 'add_emp'|| $menu == 'full_month_attendance'|| $menu == 'employee_detail' || $menu == 'employee_attendance')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = 'display:none';} ?>
						 <li class="<?php echo $active; ?>" >
							<a href="javascript:void(0)" class="header-menu-item has-arrow <?php echo $active; ?>">
							   <img src="<?php echo base_url(); ?>assets/images/employee.svg" alt="Attendance">
							   <span>Employee</span>
							</a>
							<ul class="secondary-menu <?php echo $in; ?>" aria-expanded="<?php echo $aria; ?>" style="<?php echo $style; ?>">
							   <li>
								  <a href="<?php echo base_url('employee'); ?>" class="  <?php if(isset($menu) && $menu == 'employee'){ echo "active";} ?>">Employee List</a>
							   </li>
							   <li>
							   		<a href="<?php echo base_url('employee/employee_attendance_list'); ?>" class="  <?php if(isset($menu) && $menu == 'employee_attendance'){ echo "active";} ?>">Attendance</a>
								</li>
							   <li>
									<a href="<?php echo base_url('employee/detail'); ?>" class="  <?php if(isset($menu) && $menu == 'employee_detail'){ echo "active";} ?>">Employee Detail</a>
								</li>
							   <li>
								  <a href="<?php echo base_url('employee/add'); ?>" class="  <?php if(isset($menu) && $menu == 'add_emp'){ echo "active";} ?>">Add New</a>
							   </li>
							   <li>
								  <a href="<?php echo base_url('employee/full_month_attendance'); ?>" class="  <?php if(isset($menu) && $menu == 'full_month_attendance'){ echo "active";} ?>">Add Attendance</a>
							   </li>
							</ul>
						 </li>
						 <?php if(isset($menu)  && ( $menu == 'holiday_add' || $menu == 'holiday_view'|| $menu == 'holiday')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = 'display:none';} ?>
						 <li class="<?php echo $active; ?>" >
							<a href="<?php echo base_url('holiday'); ?>" class="header-menu-item <?php echo $active; ?>">
							   <img src="<?php echo base_url(); ?>assets/images/holiday.svg" alt="Holiday">
							   <span>Holiday</span>
							</a>
						 </li>
						 <li class=" <?php if(isset($menu) && $menu == 'designation'){ echo "active";} ?>">
							<a href="<?php echo base_url('designation'); ?>" class="header-menu-item <?php if(isset($menu) && $menu == 'designation'){ echo "active";} ?>">
							   <img src="<?php echo base_url(); ?>assets/images/designation.svg" alt="Designation">
							   <span>Designation</span>
							</a>
						 </li>
						 <?php if(isset($menu) && ($menu == 'reports' || $menu == 'log_rep' || $menu == 'prof_tax' || $menu == 'deposit_report' || $menu == 'leave_report' ||$menu == 'bonus_new' ||$menu == 'prof_tax_new' || $menu == 'deposit_report_new' || $menu == 'paid_leave_report_new' || $menu == 'sick_leave_report' || $menu == 'leave_report_new' || $menu == 'salary_report_new' || $menu == 'employee_report' || $menu == 'workingHours_report')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = 'display:none';} ?>
						 <li class="<?php echo $active; ?>">
							<a href="javascript:void(0)" class="header-menu-item has-arrow <?php echo $active; ?>">
								  <img src="<?php echo base_url(); ?>assets/images/report.svg" alt="Reports">
								  <span>Reports</span>
							   </a>
							<ul class="secondary-menu <?php echo $in; ?>" aria-expanded="<?php echo $aria; ?>" style="<?php echo $style; ?>">
							   <li>
								  <a href="<?php echo base_url('reports'); ?>" class=" <?php if(isset($menu) && $menu == 'reports'){ echo "active";} ?>">Attendance Reports</a>
							   </li>
							   <li>
									<a href="<?php echo base_url('reports/workingHours'); ?>" class=" <?php if(isset($menu) && $menu == 'workingHours_report'){ echo "active";} ?>">Working Hours Reports</a>
								</li>
							   <li>
								  <a href="<?php echo base_url('reports/general_reports'); ?>" class=" <?php if(isset($menu) && $menu == 'paid_leave_report_new'){ echo "active";} ?>">General Reports</a>
							   </li>
							   <li>
								  <a href="<?php echo base_url('reports/employee_report'); ?>" class=" <?php if(isset($menu) && $menu == 'employee_report'){ echo "active";} ?>">Employee Reports</a>
							   </li>
							</ul>
						 </li>
						 <?php } ?>
						 <?php if(isset($menu) && ($menu == 'leave_request' || $menu == 'leave_request_add' || $menu == 'leave_request_list')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = 'display:none';} ?>
						 <li class="<?php echo $active; ?>">
							<a href="<?php echo base_url('leave_request'); ?>" class="header-menu-item <?php echo $active; ?>">
								  <img src="<?php echo base_url(); ?>assets/images/leave.svg" alt="Leave Request">
								  <span>Leave</span>
							   </a>
						 </li>
						 <li class="<?php if(isset($menu) && $menu == 'salary_pay'){ echo "active";} ?>"> 
							<a href="<?php echo base_url('salary_pay'); ?>" class="header-menu-item <?php if(isset($menu) && $menu == 'salary_pay'){ echo "active";} ?>">
								  <img src="<?php echo base_url(); ?>assets/images/salary.svg" alt="Salary">
								  <span>Salary</span>
							   </a>
						 </li>
						 <?php if($user_role == 'admin'){ ?>
							<?php if(isset($menu) && ($menu == 'deposit' || $menu == 'deposit_add' || $menu == 'deposit_list')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = 'display:none';} ?>
						 <li class="<?php echo $active; ?>">
							<a href="javascript:void(0)" class="header-menu-item has-arrow <?php echo $active; ?>">
								  <img src="<?php echo base_url(); ?>assets/images/deposit.svg" alt="Deposit">
								  <span>Deposit</span>
							   </a>
							<ul class="secondary-menu <?php echo $in; ?>" aria-expanded="<?php echo $aria; ?>" style="<?php echo $style; ?>">
							   <li>
								  <a href="<?php echo base_url('deposit'); ?>" class=" <?php if(isset($menu) && $menu == 'deposit'){ echo "active";} ?>">List Deposit</a>
							   </li>
							   <li>
								  <a href="<?php echo base_url('deposit/add'); ?>" class=" <?php if(isset($menu) && $menu == 'deposit_add'){ echo "active";} ?>">Add Deposit</a>
							   </li>
							   <!-- <li>
								  <a href="<?php // echo base_url('deposit/deposit_list'); ?>" class=" <?php //if(isset($menu) && $menu == 'deposit_list'){ echo "active";} ?>">Deposit Payment</a>
							   </li> -->
							</ul>
						 </li>
						 <?php }else{ ?>
							<li class="<?php if(isset($menu) && $menu == 'deposit'){ echo "active";} ?>">
							   <a href="<?php echo base_url('deposit/index/'.$user_session); ?>" class="header-menu-item <?php if(isset($menu) && $menu == 'deposit'){ echo "active";} ?>">
									 <img src="<?php echo base_url(); ?>assets/images/deposit.svg" alt="Deposit">
									 <span>Deposit</span>
								  </a>
							</li>
						 <?php } ?>
						 <?php if($user_role == 'admin'){ ?>
							<?php if(isset($menu) && ($menu == 'candidates' || $menu == 'candidates_add')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
							<li class="<?php echo $active; ?>">
								<a href="javascript:void(0)" class="header-menu-item has-arrow <?php echo $active; ?>">
									<span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/candidates.svg" alt="Deposit"></span>
									<span class="menu-title">Candidates</span>
								</a>
								<ul class="secondary-menu <?php echo $in; ?>" aria-expanded="<?php echo $aria; ?>" style="<?php echo $style; ?>">
								<li>
									<a href="<?php echo base_url('candidates'); ?>" class=" <?php if(isset($menu) && $menu == 'candidates'){ echo "active";} ?>">List Candidates</a>
								</li>
								<li>
									<a href="<?php echo base_url('candidates/add'); ?>" class=" <?php if(isset($menu) && $menu == 'candidates_add'){ echo "active";} ?>">Add Candidates</a>
								</li>
								</ul>
							</li>
							<li class="<?php if(!empty($menu) && $menu == 'internship'){ echo "active"; } ?>">
								<a href="<?php echo base_url('internship'); ?>" class=" <?php if(!empty($menu) && $menu == 'internship'){ echo "active"; } ?>">
									<span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/internship.svg" alt="Internship"></span>
									<span class="menu-title">Internship</span>
								</a>
							</li>
						<?php } ?>
						<li class="<?php if(!empty($menu) && $menu == 'pc_issue'){ echo "active"; } ?>">
							<a href="<?php echo base_url('pc_issue'); ?>" class=" <?php if(!empty($menu) && $menu == 'pc_issue'){ echo "active"; } ?>">
								<span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/pc-issue.svg" alt="PC Issue"></span>
								<span class="menu-title">PC Issue</span>
							</a>
						</li>
						 <li class="<?php if(isset($menu) && $menu == 'bonus'){ echo "active";} ?>">
							<a href="<?php echo base_url('bonus'); ?>" class="header-menu-item <?php if(isset($menu) && $menu == 'bonus'){ echo "active";} ?>">
							   <img src="<?php echo base_url(); ?>assets/images/bonus.svg" alt="Bonus">
							   <span>Bonus</span>
							</a>
						 </li>
						 <?php if(isset($menu) && ($menu == 'increment' || $menu == 'increment_add' || $menu == 'increment_list')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
						 <li class="<?php if(isset($menu) && $menu == 'increment'){ echo "active";} ?>"> 
							 <a href="<?php echo base_url('increment'); ?>" class=" <?php if(isset($menu) && $menu == 'increment'){ echo "active";} ?>">
								 <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/salary.svg" alt="Salary"></span>
								 <span class="menu-title">Increment</span>
							 </a>
						 </li>
						 <?php if($user_role == 'admin'){ ?>
						<?php } ?>
						<?php if($user_role == 'admin'){ ?>
							<?php if(isset($menu) && ($menu == 'paid_leave')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
							<li class="<?php if(isset($menu) && $menu == 'paid_leave'){ echo "active";} ?>"> 
								<a href="<?php echo base_url('paid_leave'); ?>" class=" <?php if(isset($menu) && $menu == 'paid_leave'){ echo "active";} ?>">
									<span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/leave.svg" alt="Salary"></span>
									<span class="menu-title">Paid Leave</span>
								</a>
							</li>
							<?php if(isset($menu) && ($menu == 'broadcast_message')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
							<li class="<?php if(isset($menu) && $menu == 'broadcast_message'){ echo "active";} ?>"> 
								<a href="<?php echo base_url('broadcast'); ?>" class=" <?php if(isset($menu) && $menu == 'broadcast_message'){ echo "active";} ?>">
									<span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/broadcast.svg" alt="Salary"></span>
									<span class="menu-title">Broadcast</span>
								</a>
							</li>
							<?php if(isset($menu) && ($menu == 'mail_content')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
							<li class="<?php if(isset($menu) && $menu == 'mail_content'){ echo "active";} ?>"> 
								<a href="<?php echo base_url('mail_content'); ?>" class=" <?php if(isset($menu) && $menu == 'mail_content'){ echo "active";} ?>">
									<span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/mail.svg" alt="Salary"></span>
									<span class="menu-title">Mail Content</span>
								</a>
							</li>
						<?php } ?>
						 <?php $active2= ""; if(isset($menu) && ($menu == 'admin_profile')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}elseif(isset($menu) && ($menu == 'terms_and_condition')){ $active2 = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
						<li class="<?php echo $active; ?>">
							<a href="javascript:void(0)" class="header-menu-item has-arrow <?php echo $active; ?>">
							<?php
								if($profile_image != ""){
									$image1=$_SERVER['DOCUMENT_ROOT']."/assets/profile_image32x32/".$profile_image;
									if(file_exists($image1)){
										$image=base_url()."assets/profile_image32x32/".$profile_image;
									}else{
										if(isset($gender) && $gender == 'female') {
										$image=base_url()."assets/images/female-default.svg";
										}else{
										$image=base_url()."assets/images/male-default.svg";
										}
									}
								}else{
									if(isset($gender) && $gender == 'female') {
										$image=base_url()."assets/images/female-default.svg";
									}else{
										$image=base_url()."assets/images/male-default.svg";  
									}
								} 
							?>
								  <img src="<?php echo $image; ?>" alt="home" class="header-profile-img" />
							  
							   <span>
								  <?php if(isset($username) && !empty($username)) { echo ucwords($username);}?>
							   </span>
							</a>
							<ul class="secondary-menu <?php echo $in; ?>" aria-expanded="<?php echo $aria; ?>" style="<?php echo $style; ?>">
							   <li>
								  <a href="<?php echo base_url('profile'); ?>" class="<?php echo $active; ?>">View Profile</a>
							   </li>
							   <?php 
									if($user_role != 'admin'){ 
										$agreement=$_SERVER['DOCUMENT_ROOT']."/assets/agreement/agreement_".$user_id.".pdf";
										if(file_exists($agreement)){
											$agreement= base_url()."assets/agreement/agreement_".$user_id.".pdf";
										}else{
											$agreement= '';
										}
										if($agreement){
									?>
								<li>
									<a target="_blank" class="view_agreement" id="view_agreement" title="View Agreement" href="<?php echo $agreement; ?>">Agreement</a>
								</li>
								<?php } } ?>
							   <li><a href="<?php echo base_url('terms_and_condition'); ?>" class="<?php echo $active2; ?>">Terms & Condition</a></li>
							   <li>
								  <a href="<?php echo base_url('admin/do_logout'); ?>" class="">Logout</a>
							   </li>
							</ul>
						 </li>
	
						 <?php if(isset($admin_id) && !empty($admin_id)){ ?> 
						 <li class="">
							<a href="<?php echo base_url('change_role/admin_login/'.$admin_id); ?>" class="back-to-admin header-menu-item">
							   <img src="<?php echo base_url(); ?>assets/images/back-admin.svg" alt="Dashboard">
							   <span>Back to admin</span>
							</a> 
						 
						 </li>
						 <?php }  ?>
					</ul>
				</div>
			</nav>
	</header>
	<?php if(!empty($broadcast_list)){ $html=''; $class = '';?>
		<?php foreach ($broadcast_list as $broadcast) {  
			$expiry_date = date('Y-m-d', strtotime($broadcast->expiry_date));
            if(date('Y-m-d') < $expiry_date){ 
				$class = 'announcIs-set';
				$html .= (isset($broadcast) && !empty($broadcast->title))? '<span onclick="openAnnouncmentModal();">'.$broadcast->title.'</span>':''; } 
		}
		if($html != ''){ 
		?>
		<input type="hidden" id="class" value="<?= $class; ?>">
		<div class="announcLine-wrap">
			<marquee class="announcLine" behavior="scroll" onmouseover="this.stop();" onmouseout="this.start();" attribute_name ="attribute_value"....more attributes><?php echo $html; ?></marquee>
		<span onclick="openAnnouncmentModal();">View More</span>
	</div>
	<?php } } ?>
</div>
<?php 
	if(isset($broadcast_list) && !empty($broadcast_list)){
		$todayEvent = $tomorrowEvent = $upcomingEvent = array();
		function checkAttachment($file){
			$img2 = $_SERVER['DOCUMENT_ROOT'] . "/assets/upload/broadcast_attachment/" . $file;
			if($file != "") {
				$attachment = (file_exists($img2)) ? base_url() . "assets/upload/broadcast_attachment/" . $file : '';
			} else {
				$attachment = '';
			}
			return $attachment;
		}
		foreach($broadcast_list as $key => $broadcast){
			$expiry_date = date('Y-m-d', strtotime($broadcast->expiry_date));
            if(date('Y-m-d') < $expiry_date){ 
				if($broadcast->event_date == date('Y-m-d')){
					array_push($todayEvent,$broadcast);
				}elseif($broadcast->event_date == date("Y-m-d", strtotime('tomorrow'))){
					array_push($tomorrowEvent,$broadcast);
				}else{
					array_push($upcomingEvent,$broadcast);
				}
			}
		}
		$num = 0;
?>
	<div class="modal announcModal" id="announcmentModal" tabindex="-1" role="dialog" aria-labelledby="announcmentModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close closePopup" data-dismiss="modal"><i class="fas fa-times"></i></button>
				</div>
				<div class="modal-body">
					<?php if(!empty($todayEvent)){ ?>
					<div class="announcList-grp">
						<h3 class="mt-0">Today</h3>
						<?php foreach($todayEvent as $tEvent){ ?>
						<div class="announcInfo">
							<div class="announcInfo-head openAnnouncInfo" data-target="#c-<?=$num?>">
								<h5><?= $tEvent->title; ?></h5>
								<span class="date-wrap"><i class="fas fa-calendar-alt"></i><span class="date">Date : <?=dateFormat($tEvent->event_date);?></span></span>
							</div>
							<div class="announcInfo-body" id="c-<?=$num?>">
								<p><?=$tEvent->message;?></p>
								<?php if(!empty(checkAttachment($tEvent->attachment))){ ?>
									<a href="<?=checkAttachment($tEvent->attachment)?>" target="_bleak" data-tooltip="View Attachment" class="attach-link"><i class="fas fa-file mr-1"></i> View Attachment</a>
								<?php } ?>
							</div>
						</div>
						<?php $num++;} ?>
					</div>
					<?php } 
					if(!empty($tomorrowEvent)){ ?>
					<div class="announcList-grp">
						<h3 class="mt-0">Tomorrow</h3>
						<?php foreach($tomorrowEvent as $toEvent){ ?>
						<div class="announcInfo">
							<div class="announcInfo-head openAnnouncInfo" data-target="#c-<?=$num?>">
								<h5><?= $toEvent->title; ?></h5>
								<span class="date-wrap"><i class="fas fa-calendar-alt"></i><span class="date">Date : <?=dateFormat($toEvent->event_date);?></span></span>
							</div>
							<div class="announcInfo-body" id="c-<?=$num?>">
								<p><?=$toEvent->message;?></p>
								<?php if(!empty(checkAttachment($toEvent->attachment))){ ?>
									<a href="<?=checkAttachment($toEvent->attachment)?>" target="_bleak" data-tooltip="View Attachments" class="attach-link"><i class="fas fa-file mr-1"></i> View Attachements</a>
								<?php } ?>
							</div>
						</div>
						<?php $num++;} ?>
					</div>
					<?php }  
					if(!empty($upcomingEvent)){ ?>
					<div class="announcList-grp">
						<h3 class="mt-0">Upcoming</h3>
						<?php foreach($upcomingEvent as $upEvent){ ?>
						<div class="announcInfo">
							<div class="announcInfo-head openAnnouncInfo" data-target="#c-<?=$num?>">
								<h5><?= $upEvent->title; ?></h5>
								<span class="date-wrap"><i class="fas fa-calendar-alt"></i><span class="date">Date : <?=dateFormat($upEvent->event_date);?></span></span>
							</div>
							<div class="announcInfo-body" id="c-<?=$num?>">
								<p><?=$upEvent->message;?></p>
								<?php if(!empty(checkAttachment($upEvent->attachment))){ ?>
									<a href="<?=checkAttachment($upEvent->attachment)?>" target="_bleak" data-tooltip="View Attachments" class="attach-link"><i class="fas fa-file mr-1"></i> View Attachements</a>
								<?php } ?>
							</div>
						</div>
						<?php $num++;} ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<script>
	$('body').addClass($('#class').val());
</script>