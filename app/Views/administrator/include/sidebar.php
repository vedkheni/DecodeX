<?php 
   $user_session=$this->session->get('id');
   $user_role=$this->session->get('user_role');
   $admin_id=$this->session->get('admin_id');
   $gender= $this->session->get('gender');
   $user_id=$this->session->get('id');
   // $user_id=$this->session->get('user_id');
   $username=$this->session->get('username');
   $useremail=$this->session->get('useremail');
   $employee_name=$this->session->get('employee_name');
   $profile_image=$this->session->get('profile_image');
   //echo "menu url".$menu;
   ?>
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<div class="sidebar" role="navigation">
   <?php 
   // echo '<pre>';print_r($this->session->get('gender'));
    ?>
   <div class="sidebar-nav">
      <div class="sidebar-head">
         <a href="<?php echo base_url(); ?>"  class="sidebar-logo" title="<?php echo base_url(); ?>">
         <img class="logo-img-sm" src="<?php echo base_url(); ?>assets/images/favimg.png" alt="home" />	
         <img class="logo-img-lg" src="<?php echo base_url(); ?>assets/images/decodex.svg" alt="home" />
         </a>
      </div>
   </div>
   <?php  
      // echo "data menu".$menu;
      ?>

   <div class="sidebar-menu">
      <ul class="nav" id="side-menu">
         
         <li class="<?php if(!empty($menu) && $menu == 'dashboard'){ echo "active"; } ?>">
            <a href="<?php echo base_url('dashboard'); ?>" class="<?php if(!empty($menu) && $menu == 'dashboard'){ echo "active"; } ?>">
               <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/dashboard.svg" alt="Dashboard"></span>
               <span class="menu-title">Dashboard</span>
            </a> 
         </li>

         <?php if($user_role != 'admin'){ ?>
            <li class="<?php if(isset($menu) && $menu == 'employee_attendance'){ echo "active";} ?>"> 
            <a href="<?php echo base_url('employee/employee_attendance_list/'.$user_session); ?>" class=" <?php if(isset($menu) && $menu == 'employee_attendance'){ echo "active";} ?>">
                  <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/attendance.svg?ff" alt="Attendance"></span>
                  <span class="menu-title">Attendance</span>
            </a>
         </li>
         <li class="<?php if(!empty($menu) && $menu == 'holiday_view'){ echo "active"; } ?>">
            <a href="<?php echo base_url('holiday'); ?>" class=" <?php if(!empty($menu) && $menu == 'holiday_view'){ echo "active"; } ?>">
               <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/holiday.svg" alt="Holiday"></span>
               <span class="menu-title">Holiday</span>
            </a>
         </li>
         <?php } ?>
         <?php if($user_role == 'admin'){ ?>
            <?php if(isset($menu)  && ( $menu == 'employee' || $menu == 'add_emp'|| $menu == 'full_month_attendance' || $menu == 'employee_detail' || $menu == 'employee_attendance')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
         <li class="<?php echo $active; ?>" >
            <a href="javascript:void(0)" class="has-arrow menu-a <?php echo $active; ?>">
               <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/employee.svg" alt="Attendance"></span>
               <span class="menu-title">Employee</span>
            </a>
            <ul class="nav sub-has-menu <?php echo $in; ?>" aria-expanded="<?php echo $aria; ?>" style="<?php echo $style; ?>">
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
         <li class="<?php if(!empty($menu) && $menu == 'holiday_view' || $menu == 'holiday_add'){ echo "active"; } ?>">
            <a href="<?php echo base_url('holiday'); ?>" class=" <?php if(!empty($menu) && $menu == 'holiday_view'){ echo "active"; } ?>">
               <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/holiday.svg" alt="Holiday"></span>
               <span class="menu-title">Holiday</span>
            </a>
         </li>
         <li class=" <?php if(isset($menu) && $menu == 'designation'){ echo "active";} ?>">
            <a href="<?php echo base_url('designation'); ?>" class=" <?php if(isset($menu) && $menu == 'designation'){ echo "active";} ?>">
               <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/designation.svg" alt="Designation"></span>
               <span class="menu-title">Designation</span>
            </a>
         </li>
            <?php if(isset($menu) && ($menu == 'reports' || $menu == 'log_rep' || $menu == 'prof_tax' || $menu == 'deposit_report' || $menu == 'leave_report' ||$menu == 'bonus_new' ||$menu == 'prof_tax_new' || $menu == 'deposit_report_new' || $menu == 'paid_leave_report_new' || $menu == 'sick_leave_report' || $menu == 'leave_report_new' || $menu == 'salary_report_new' || $menu == 'employee_report' || $menu == 'workingHours_report')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
         <li class="<?php echo $active; ?>">
            <a href="javascript:void(0)" class=" has-arrow menu-a <?php echo $active; ?>">
                  <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/report.svg" alt="Reports"></span>
                  <span class="menu-title">Reports</span>
               </a>
            <ul class="nav sub-has-menu <?php echo $in; ?>" aria-expanded="<?php echo $aria; ?>" style="<?php echo $style; ?>">
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
         <?php if(isset($menu) && ($menu == 'leave_request' || $menu == 'leave_request_add' || $menu == 'leave_request_list')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
         <li class="<?php if(isset($menu) && $menu == 'leave_request'){ echo "active";} ?>"> 
            <a href="<?php echo base_url('leave_request'); ?>" class=" <?php if(isset($menu) && $menu == 'leave_request'){ echo "active";} ?>">
                  <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/leave.svg" alt="Leave Request"></span>
                  <span class="menu-title">Leave</span>
               </a>
         </li>
         <li class="<?php if(isset($menu) && $menu == 'salary_pay'){ echo "active";} ?>"> 
            <a href="<?php echo base_url('salary_pay'); ?>" class=" <?php if(isset($menu) && $menu == 'salary_pay'){ echo "active";} ?>">
                  <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/salary.svg" alt="Salary"></span>
                  <span class="menu-title">Salary</span>
               </a>
         </li>
         <?php if($user_role == 'admin'){ ?>
            <?php if(isset($menu) && ($menu == 'deposit' || $menu == 'deposit_add' || $menu == 'deposit_list')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
         <li class="<?php echo $active; ?>">
            <a href="javascript:void(0)" class=" has-arrow menu-a <?php echo $active; ?>">
                  <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/deposit.svg" alt="Deposit"></span>
                  <span class="menu-title">Deposit</span>
               </a>
            <ul class="nav sub-has-menu <?php echo $in; ?>" aria-expanded="<?php echo $aria; ?>" style="<?php echo $style; ?>">
               <?php //if($user_role == "admin"){  ?>
               <li>
                  <a href="<?php echo base_url('deposit'); ?>" class=" <?php if(isset($menu) && $menu == 'deposit'){ echo "active";} ?>">List Deposit</a>
               </li>
               <li>
                  <a href="<?php echo base_url('deposit/add'); ?>" class=" <?php if(isset($menu) && $menu == 'deposit_add'){ echo "active";} ?>">Add Deposit</a>
               </li>
               <!-- <li>
                  <a href="<?php //echo base_url('deposit/deposit_list'); ?>" class=" <?php //f(isset($menu) && $menu == 'deposit_list'){ echo "active";} ?>">Deposit Payment</a>
               </li> -->
            </ul>
         </li>
         <?php }else{ ?>
            <li class="<?php if(isset($menu) && $menu == 'deposit'){ echo "active";} ?>">
               <a href="<?php echo base_url('deposit/index/'.$user_session); ?>" class=" <?php if(isset($menu) && $menu == 'deposit'){ echo "active";} ?>">
                     <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/deposit.svg" alt="Deposit"></span>
                     <span class="menu-title">Deposit</span>
                  </a>
            </li>
         <?php } ?>
         <?php if($user_role == 'admin'){ ?>
            <?php if(isset($menu) && ($menu == 'candidates' || $menu == 'candidates_add')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
         <li class="<?php echo $active; ?>">
            <a href="javascript:void(0)" class=" has-arrow menu-a <?php echo $active; ?>">
                  <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/candidates.svg" alt="Deposit"></span>
                  <span class="menu-title">Candidates</span>
               </a>
            <ul class="nav sub-has-menu <?php echo $in; ?>" aria-expanded="<?php echo $aria; ?>" style="<?php echo $style; ?>">
               <li>
                  <a href="<?php echo base_url('candidates'); ?>" class=" <?php if(isset($menu) && $menu == 'candidates'){ echo "active";} ?>">List Candidates</a>
               </li>
               <li>
                  <a href="<?php echo base_url('candidates/add'); ?>" class=" <?php if(isset($menu) && $menu == 'candidates_add'){ echo "active";} ?>">Add Candidates</a>
               </li>
            </ul>
         </li>
         <?php // }else{ ?>
            <li class="<?php if(!empty($menu) && $menu == 'internship'){ echo "active"; } ?>">
               <a href="<?php echo base_url('internship'); ?>" class=" <?php if(!empty($menu) && $menu == 'internship'){ echo "active"; } ?>">
                  <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/internship.svg" alt="Internship"></span>
                  <span class="menu-title">Internship</span>
               </a>
            </li>
         <?php //} ?>
         <?php  } ?>
         <?php // }else{ ?>
            <li class="<?php if(!empty($menu) && $menu == 'pc_issue'){ echo "active"; } ?>">
               <a href="<?php echo base_url('pc_issue'); ?>" class=" <?php if(!empty($menu) && $menu == 'pc_issue'){ echo "active"; } ?>">
                  <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/pc-issue.svg" alt="PC Issue"></span>
                  <span class="menu-title">PC Issue</span>
               </a>
            </li>
         <?php //} ?>

         <li class="<?php if(isset($menu) && $menu == 'bonus'){ echo "active";} ?>">
            <a href="<?php echo base_url('bonus'); ?>" class=" <?php if(isset($menu) && $menu == 'bonus'){ echo "active";} ?>">
               <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/bonus.svg" alt="Bonus"></span>
               <span class="menu-title">Bonus</span>
            </a>
         </li>
         <?php if(isset($menu) && ($menu == 'increment' || $menu == 'increment_add' || $menu == 'increment_list')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
         <li class="<?php if(isset($menu) && $menu == 'increment'){ echo "active";} ?>"> 
				<a href="<?php echo base_url('increment'); ?>" class=" <?php if(isset($menu) && $menu == 'increment'){ echo "active";} ?>">
            <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/increment.svg" alt="Salary"></span>
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
		 <?php } ?>
       <?php if($user_role == 'admin'){ ?>
		   <?php if(isset($menu) && ($menu == 'broadcast_message')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
			 <li class="<?php if(isset($menu) && $menu == 'broadcast_message'){ echo "active";} ?>"> 
				<a href="<?php echo base_url('broadcast'); ?>" class=" <?php if(isset($menu) && $menu == 'broadcast_message'){ echo "active";} ?>">
					  <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/broadcast.svg" alt="Broadcast"></span>
					  <span class="menu-title">Broadcast</span>
				   </a>
			 </li>
		 <?php } ?>
       <?php if($user_role == 'admin'){ ?>
		   <?php if(isset($menu) && ($menu == 'mail_content')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
			 <li class="<?php if(isset($menu) && $menu == 'mail_content'){ echo "active";} ?>"> 
				<a href="<?php echo base_url('mail_content'); ?>" class=" <?php if(isset($menu) && $menu == 'mail_content'){ echo "active";} ?>">
					  <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/mail.svg" alt="Salary"></span>
					  <span class="menu-title">Mail Content</span>
				   </a>
			 </li>
		 <?php } ?>

         <?php if(isset($menu) && ($menu == 'terms_and_condition')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
			 <li class="<?php if(isset($menu) && $menu == 'terms_and_condition'){ echo "active";} ?>"> 
				<a href="<?php echo base_url('terms_and_condition'); ?>" class=" <?php if(isset($menu) && $menu == 'terms_and_condition'){ echo "active";} ?>">
					  <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/terms.svg" alt="Terms & Conditions"></span>
					  <span class="menu-title">Terms & Conditions</span>
				   </a>
			 </li>
            <?php $active1 = $active2= "";
			if(isset($menu) && ($menu == 'admin_profile')){ $active = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else if(isset($menu) && ($menu == 'team_and_condition')){ $active2 = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';}else if(isset($menu) && ($menu == 'admin_settings')){ $active = ""; $active1 = 'active'; $in = "in"; $aria = "true"; $style = 'display: block;';} else{ $active = ''; $in = ""; $aria = "false"; $style = '';} ?>
         <li class="<?php echo $active; ?>">
            <a href="javascript:void(0)" class=" has-arrow menu-a <?php echo $active; ?>">
               <span class="menu-icon">
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
                  <img src="<?php echo $image; ?>" alt="home" class="sidebar-profile-img" />
               </span>
               <span class="menu-title">
                  <?php if(isset($username) && !empty($username)) { echo ucwords($username);}?>
               </span>
            </a>
            <ul class="nav sub-has-menu <?php echo $in; ?>" aria-expanded="<?php echo $aria; ?>" style="<?php echo $style; ?>">
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
            <?php if($user_role == 'admin'){ ?>
					<!-- <li><a href="<?php // echo base_url('settings'); ?>" class="<?php //echo $active1; ?>">Settings</a></li> -->
			   <?php } ?>
               <li>
                  <a href="<?php echo base_url('admin/do_logout'); ?>" class="">Logout</a>
               </li>
            </ul>
         </li>

         <?php if(isset($admin_id) && !empty($admin_id)){ ?> 
         <li class="">
            <a href="<?php echo base_url('change_role/admin_login/'.$admin_id); ?>" class="back-to-admin">
               <span class="menu-icon"><img src="<?php echo base_url(); ?>assets/images/admin.svg" alt="Dashboard"></span>
               <span class="menu-title">Back to admin</span>
            </a> 
         
         </li>
         <?php }  ?>
      </ul>
   </div>
   <div class="menu-btn">
      <button type="button" class="menu-toggle button_menu">
         <div class="right-arrow">
               <div id="cta">
                   <span class="arrow primera next "></span>
                   <span class="arrow segunda next "></span>
               </div>
           </div>
      </button>
   </div>
</div>
<!-- ============================================================== -->
<!-- End Left Sidebar -->
<!-- ============================================================== -->