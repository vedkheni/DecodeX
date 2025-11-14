<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script> -->
<!-- <style>
   .time-minus{
   color : red;
   }
   .time-plus{
   color:green;
   }
</style> -->
<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         <div class="col-lg-12 col-d-12 col-xs-12">
            <h4 class="page-title">Employee Reports</h4>
         </div>
         <!-- <div class="col-sm-4">
            <ol class="breadcrumb">
               <li><a href="#">Reports</a></li>
               <li class="active">Employee Reports</li>
            </ol>
         </div> -->
         <!-- /.col-lg-12 -->
      </div>
      <div class="row">
         <div class="col-md-12 col-xs-12">
            <div class="white-box m-0 employee-report-page">
               <form class="frm-search emp-custom-field" method="post" action="<?php echo base_url('reports/employee_report'); ?>" id="bonus-form">
                  <div class="row">
                     <div class="col-12 text-center">
                        <!-- <div class="error_msg"></div> -->
                        <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
                        <?php
                        if (isset($search) && !empty($search)) {
                           //echo "<pre>"; print_r($search); echo "</pre>";
                           $current_month = $search['month'];
                           $current_year = $search['year'];
                           $employee_id = $search['employee_id'];
                           //echo "<pre>"; print_r($leave_count); 
                           //print_r($result);  
                           //echo "</pre>";
                        }
                        ?>
                        <div class="single-field select-field multi-field _search-form m-0">
                           <select id="employee_id" name="employee_id">
                              <option value="" disabled>Select Employee</option>
                              <?php foreach ($employee_all as $n => $name) { ?>
                                 <option class="active" <?php if ($employee_id == $name->id) {
                                                            echo "selected='selected'";
                                                         } ?> value="<?php echo $name->id; ?>"><?php echo $name->fname . " " . $name->lname; ?></option>
                              <?php } ?>
                              <option value="" class="disabled" disabled>Deactive Employee</option>
                              <?php foreach ($all_deactive_emp as $n => $name) { ?>
                                 <option class="deactive" <?php if ($employee_id == $name->id) {
                                                               echo "selected='selected'";
                                                            } ?> value="<?php echo $name->id; ?>"><?php echo $name->fname . " " . $name->lname; ?></option>
                              <?php } ?>
                           </select>
                           <label>Select Employee</label>
                        </div>
                        <div class="single-field select-field multi-field _search-form m-0">
                           <select name="employeeStatus" id="employeeStatus">
                              <option value="" selected="">All Status</option>
                              <option value="Active">Active</option>
                              <option value="Deactive">Deactive</option>
                           </select>
                           <label>Select Status</label>
                        </div>
                        <input type="hidden" name="bonus_month" id="bonus_month" value="<?php echo $current_month; ?>">
                        <input type="hidden" name="bonus_year" id="bonus_year" value="<?php echo $current_year; ?>">
                        <!-- <div class="col-lg-4 col-md-6 _search-form">
                        <label>Month:</label>
                        <select class="form-control form-control-line bor-top" id="bonus_month" name="bonus_month" >
                           <option value="">Month</option>
                           <?php foreach (MONTH_NAME as $k => $v) { ?>
                              <option <?php if ($current_month == $k + 1) {
                                          echo "selected='selected'";
                                       } ?> value="<?php echo $k + 1; ?>"><?php echo $v; ?></option>
                           <?php } ?>
                        </select>
                        
                        </div>
                        <div class="col-lg-4 col-md-6 _search-form">
                        <label>Year:</label>
                        <select class="form-control form-control-line bor-top" id="bonus_year" name="bonus_year" >
                           <option value="">Year</option>
                           <?php
                           $next_year=date('Y',strtotime('+1 year'));
                           for ($i = 2018; $i <= $next_year; $i++) { ?>
                              <option  <?php if ($current_year == $i) {
                                          echo "selected='selected'";
                                       } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                           <?php } ?>
                        </select>
                        </div> -->
                        <!-- </div> -->
                        <!-- <div class="col-md-6 _search-form"> -->
                        <!-- <div class="col-md-12 emp_ p-0"> -->
                        <!-- <div class="emp_submit">
                              <input type="button"  class="btn sec-btn pull-left emp_search " id="salary_month_search" name="salary_month_search"  value="Search">
                              </div> -->
                        <!-- </div> -->
                        <!-- </div> -->
                     </div>
                  </div>
                  <hr class="custom-hr">
               </form>


               <div class="tabbtn">
                  <div class="preloader preloader-2 report_preloader1" style="display:none">
                     <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                     </svg>
                  </div>
                  <!-- <div class="main-tabs">
                     <a href="#basic-details" class="tablink tab_emp" onclick="openCity('basic-details', this, 'orange')" id="defaultOpen">Basic Details</a>
                     <a href="#salary-details" class="tablink tab_emp" onclick="openCity('salary-details', this, 'orange')">Salary Details</a>
                     <a href="#attendance-details" class="tablink tab_emp" onclick="openCity('attendance-details', this, 'orange')">Attendance Details</a>
                  </div> -->

                  <div class="single-field select-field mb-custom-tab" onclick="$(this).toggleClass('active');">
                     <span class="mb-custom-tab-active">Basic Details</span>
                     <ul class="mb-tab-list">
                        <li class="nav-item active">
                           <a class="nav-link active" id="dailyWork-updates-tab" onclick=" $('span.mb-custom-tab-active').text($(this).text());" data-toggle="tab" href="#dailyWork-updates" role="tab" aria-controls="dailyWork-updates" aria-selected="true">Daily Work Updates</a>
                        </li>

                        <li class="nav-item">
                           <a class="nav-link" id="basic-details-tab" onclick=" $('span.mb-custom-tab-active').text($(this).text());" data-toggle="tab" href="#basic-details" role="tab" aria-controls="basic-details" aria-selected="true">Basic Details</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" id="salary-details-tab" onclick=" $('span.mb-custom-tab-active').text($(this).text());" data-toggle="tab" href="#salary-details" role="tab" aria-controls="salary-details" aria-selected="true">Salary Details</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" id="attendance-details-tab" onclick=" $('span.mb-custom-tab-active').text($(this).text());" data-toggle="tab" href="#attendance-details" role="tab" aria-controls="attendance-details" aria-selected="true">Attendance Details</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" id="salary-increment-details-tab" onclick=" $('span.mb-custom-tab-active').text($(this).text());" data-toggle="tab" href="#salary-increment-details" role="tab" aria-controls="salary-increment-details" aria-selected="true">Salary Increment Details</a>
                        </li>
                     </ul>
                  </div>

                  <ul class="nav nav-tabs lg-custom-tabs" id="myTab" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" id="dailyWork-updates-tab" data-toggle="tab" href="#dailyWork-updates" role="tab" aria-controls="dailyWork-updates" aria-selected="true">Daily Work Updates</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="basic-details-tab" data-toggle="tab" href="#basic-details" role="tab" aria-controls="basic-details" aria-selected="true">Basic Details</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="salary-details-tab" data-toggle="tab" href="#salary-details" role="tab" aria-controls="salary-details" aria-selected="true">Salary Details</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="attendance-details-tab" data-toggle="tab" href="#attendance-details" role="tab" aria-controls="attendance-details" aria-selected="true">Attendance Details</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="salary-increment-details-tab" data-toggle="tab" href="#salary-increment-details" role="tab" aria-controls="salary-increment-details" aria-selected="true">Salary Increment Details</a>
                     </li>
                  </ul>
                  <div class="tab-content myTabContent1" id="myTabContent">

                     <div id="dailyWork-updates" class="tab-pane fade show active" role="tabpanel" aria-labelledby="dailyWork-updates-tab">
                        <div class="emp-custom-field">

                           <form class="frm-search m-t-10 text-center" method="post" action="<?php echo base_url('reports/employee_report'); ?>">
                              <input type="hidden" name="employee_id" class="employee_id1" id="employee_id" value="<?php echo $employee_id; ?>">

                              <div class="single-field date-field multi-field">
                                 <input type="text" name="date_range" id="date_range" class="datepicker-here" autocomplete="off" value="">
                                 <label>Date Range </label>
                              </div>
                              <button type="button" class="btn sec-btn" id="workupdates_search">Search</button>
                           </form>
                           <hr class="custom-hr">
                        </div>


                        <div class="all_salary_view row"></div>


                        <div class="select_month_details">

                           <div class="preloader preloader-2 report_preloader" style="display:none">
                              <svg class="circular" viewBox="25 25 50 50">
                                 <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                              </svg>
                           </div>
                           <div class="row simple-info-border" id="workUpdateDataBox">
                              
                           </div>
                        </div>
                     </div>

                     <div id="basic-details" class="tab-pane fade" role="tabpanel" aria-labelledby="basic-details-tab">
                        <div class="row justify-content-center">

                           <div class="col-12 col-lg-8 col-xl-6">
                              <div class="simple-info">
                                 <div class="row m-0">
                                    <div class="col-6 p-0">
                                       <h3 class="title">Name:</h3>
                                    </div>
                                    <div class="col-6 p-0">
                                       <h3 class="name"><?php echo $employee_deatils[0]->fname . "" . $employee_deatils[0]->lname; ?></h3>
                                    </div>
                                 </div>
                              </div>
                              <div class="simple-info">
                                 <div class="row m-0">
                                    <div class="col-6 p-0">
                                       <h3 class="title">Joining Date:</h3>
                                    </div>
                                    <div class="col-6 p-0">
                                       <h3 class="counter joining_date"><?php echo dateFormat($employee_deatils[0]->joining_date); ?></h3>
                                    </div>
                                 </div>
                              </div>
                              <div class="simple-info">
                                 <div class="row m-0">
                                    <div class="col-6 p-0">
                                       <h3 class="title">Employed Status:</h3>
                                    </div>
                                    <div class="col-6 p-0">
                                       <h3 class="counter employed_status"><?php echo $employee_deatils[0]->employee_status; ?></h3>
                                    </div>
                                 </div>
                              </div>
                              <div class="simple-info">
                                 <div class="row m-0">
                                    <div class="col-6 p-0">
                                       <h3 class="title">Employed Date:</h3>
                                    </div>
                                    <div class="col-6 p-0">
                                       <h3 class="counter employed_date"><?php echo dateFormat($employee_deatils[0]->employed_date); ?></h3>
                                    </div>
                                 </div>
                              </div>

                              <div class="simple-info">
                                 <div class="row m-0">
                                    <div class="col-6 p-0">
                                       <h3 class="title">Used Paid Leave:</h3>
                                    </div>
                                    <div class="col-6 p-0">
                                       <h3 class="counter paid_leave"><?php echo $leave_count['paid_leave']; ?></h3>
                                    </div>
                                 </div>
                              </div>
                              <div class="simple-info">
                                 <div class="row m-0">
                                    <div class="col-6 p-0">
                                       <h3 class="title">Used Sick Leave:</h3>
                                    </div>
                                    <div class="col-6 p-0">
                                       <h3 class="counter sick_leave"><?php echo $leave_count['sick_leave']; ?></h3>
                                    </div>
                                 </div>
                              </div>
                              <div class="simple-info">
                                 <div class="row m-0">
                                    <div class="col-6 p-0">
                                       <h3 class="title">Remaining Paid Leave:</h3>
                                    </div>
                                    <div class="col-6 p-0">
                                       <h3 class="counter remaing_paid_leave"><?php echo $employee_deatils[0]->monthly_paid_leave; ?></h3>
                                    </div>
                                 </div>
                              </div>
                              <div class="simple-info">
                                 <div class="row m-0">
                                    <div class="col-6 p-0">
                                       <h3 class="title">Remaining Sick Leave:</h3>
                                    </div>
                                    <div class="col-6 p-0">
                                       <h3 class="counter remaing_sick_leave"><?php echo $leave_count['remaing_sick_leave']; ?></h3>
                                    </div>
                                 </div>
                              </div>
                           </div>

                        </div>
                     </div>

                     <div id="salary-details" class="tab-pane fade" role="tabpanel" aria-labelledby="salary-details-tab">
                        <div class="emp-custom-field">

                           <form class="frm-search m-t-10 text-center" method="post" action="<?php echo base_url('reports/employee_report'); ?>">
                              <input type="hidden" name="employee_id" class="employee_id1" id="employee_id" value="<?php echo $employee_id; ?>">

                              <div class="single-field multi-field select-field _search-form">
                                 <select id="salary_month" name="bonus_month">
                                    <option value="all">All Month</option>
                                    <?php foreach (MONTH_NAME as $k => $v) { ?>
                                       <option <?php if ($current_month == $k + 1) {
                                                   echo "selected='selected'";
                                                } ?> value="<?php echo $k + 1; ?>"><?php echo $v; ?></option>
                                    <?php } ?>
                                 </select>
                                 <label>Select Month</label>
                              </div>

                              <div class="single-field multi-field select-field _search-form m-b-0">
                                 <select id="salary_year" name="bonus_year">
                                    <option value="" disabled>Select Year</option>
                                    <?php
                                    $next_year=date('Y',strtotime('+1 year'));
                                    for ($i = 2018; $i <= $next_year; $i++) { ?>
                                       <option <?php if ($current_year == $i) {
                                                   echo "selected='selected'";
                                                } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                 </select>
                                 <label>Select Year</label>
                              </div>

                              <!--  <div class="d-inline-block _search-form">
                              <div class="emp_ p-0">
                                 <div class="emp_submit">
                                    <input type="button" class="btn sec-btn pull-left emp_search " name="salary_month_search" id="salary_search" value="Search">
                                 </div>
                              </div>
                           </div> -->

                           </form>
                           <hr class="custom-hr">
                        </div>


                        <div class="all_salary_view row"></div>


                        <div class="select_month_details">

                           <div class="preloader preloader-2 report_preloader" style="display:none">
                              <svg class="circular" viewBox="25 25 50 50">
                                 <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                              </svg>
                           </div>
                           <div class="row justify-content-center">
                              <div class="col-12 col-lg-8 col-xl-6">
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-6 p-0">
                                          <h3 class="title">Working Days:</h3>
                                       </div>
                                       <div class="col-6 p-0">
                                          <h3 class="counter working_days">
                                             <?php echo isset($result['working_day']) ? $result['working_day'] : 0; ?>
                                          </h3>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-6 p-0">
                                          <h3 class="title">Present Days:</h3>
                                       </div>
                                       <div class="col-6 p-0">
                                          <h3 class="counter present_days">
                                             <?php echo isset($result['present_day']) ? $result['present_day'] : 0; ?>
                                          </h3>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-6 p-0">
                                          <h3 class="title">Leaves:</h3>
                                       </div>
                                       <div class="col-6 p-0">
                                          <h3 class="counter leaves">
                                             <?php echo isset($result['leaves']) ? $result['leaves'] : 0; ?>
                                          </h3>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-6 p-0">
                                          <h3 class="title">Paid Leaves:</h3>
                                       </div>
                                       <div class="col-6 p-0">
                                          <h3 class="counter paid_leaves">
                                             <?php echo isset($result['paid_leaves']) ? $result['paid_leaves'] : 0; ?>
                                          </h3>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-6 p-0">
                                          <h3 class="title">Sick Leaves:</h3>
                                       </div>
                                       <div class="col-6 p-0">
                                          <h3 class="counter sick_leaves">
                                             <?php echo isset($result['sick_leaves']) ? $result['sick_leaves'] : 0; ?>
                                          </h3>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-6 p-0">
                                          <h3 class="title">Approved Leaves:</h3>
                                       </div>
                                       <div class="col-6 p-0">
                                          <h3 class="counter approved_leaves">
                                             <?php echo isset($result['approved_leaves']) ? $result['approved_leaves'] : 0; ?>
                                          </h3>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-6 p-0">
                                          <h3 class="title" title="1 Leave = 1.5 Unapproved Leave Count">Unapproved Leave <i class="fa fa-info-circle" aria-hidden="true"></i> :</h3>
                                       </div>
                                       <div class="col-6 p-0">
                                          <h3 class="counter unapproved_leave">
                                             <?php echo isset($result['unapproved_leave']) ? $result['unapproved_leave'] : 0; ?>
                                          </h3>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-6 p-0">
                                          <h3 class="title" title="Including Unapproved Leaves">Total Leaves <i class="fa fa-info-circle" aria-hidden="true"></i> :</h3>
                                       </div>
                                       <div class="col-6 p-0">
                                          <h3 class="counter total_leaves">
                                             <?php echo isset($result['total_leaves']) ? $result['total_leaves'] : 0; ?>
                                          </h3>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-6 p-0">
                                          <h3 class="title">Basic Salary:</h3>
                                       </div>
                                       <div class="col-6 p-0">
                                          <h3 class="counter basic_salary">
                                             <?php echo isset($result['basic_salary']) ? $result['basic_salary'] : 0; ?>
                                          </h3>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-6 p-0">
                                          <h3 class="title">Prof Tax:</h3>
                                       </div>
                                       <div class="col-6 p-0">
                                          <h3 class="counter prof_tax">
                                             <?php echo isset($result['prof_tax']) ? $result['prof_tax'] : 0; ?>
                                          </h3>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-6 p-0">
                                          <h3 class="title">Deposit:</h3>
                                       </div>
                                       <div class="col-6 p-0">
                                          <h3 class="counter deposit">
                                             <?php echo isset($result['deposit']) ? $result['deposit'] : 0; ?>
                                          </h3>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-6 p-0">
                                          <h3 class="title">Bonus:</h3>
                                       </div>
                                       <div class="col-6 p-0">
                                          <h3 class="counter bonus">
                                             <?php echo isset($result['bonus']) ? $result['bonus'] : 0; ?>
                                          </h3>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-6 p-0">
                                          <h3 class="title">Leave Deduction:</h3>
                                       </div>
                                       <div class="col-6 p-0">
                                          <h3 class="counter leave_deduction">
                                             <?php echo isset($result['leave_deduction']) ? $result['leave_deduction'] : 0; ?>
                                          </h3>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-6 p-0">
                                          <h3 class="title">Net Salary:</h3>
                                       </div>
                                       <div class="col-6 p-0">
                                          <h3 class="counter net_salary">
                                             <?php echo number_format($result['net_salary'], 2); ?>
                                          </h3>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div id="attendance-details" class="tab-pane fade" role="tabpanel" aria-labelledby="attendance-details-tab">
                        <div class="emp-custom-field">

                           <form class="frm-search m-t-10 text-center" method="post">
                              <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $employee_id; ?>">

                              <div class="single-field multi-field select-field _search-form">
                                 <select id="attendance_month" name="bonus_month">
                                    <option value="" disabled>Select Month</option>
                                    <?php foreach (MONTH_NAME as $k => $v) { ?>
                                       <option <?php if ($current_month == $k + 1) {
                                                   echo "selected='selected'";
                                                } ?> value="<?php echo $k + 1; ?>"><?php echo $v; ?></option>
                                    <?php } ?>
                                 </select>
                                 <label>Select Month</label>
                              </div>

                              <div class="single-field multi-field select-field _search-form m-b-0">
                                 <select id="attendance_year" name="bonus_year">
                                    <option value="" disabled>Select Year</option>
                                    <?php
                                    $next_year=date('Y',strtotime('+1 year'));
                                    for ($i = 2018; $i <= $next_year; $i++) { ?>
                                       <option <?php if ($current_year == $i) {
                                                   echo "selected='selected'";
                                                } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                 </select>
                                 <label>Select Year</label>
                              </div>

                              <!-- <div class="d-inline-block _search-form">
                              <div class="emp_">
                                 <div class="emp_submit">
                                    <input type="button" class="btn sec-btn pull-left emp_search " id="attendance_search" name="salary_month_search" value="Search">
                                 </div>
                              </div>
                           </div> -->

                           </form>
                           <hr class="custom-hr">


                           <?php
                           function seconds($seconds)
                           {
                              // CONVERT TO HH:MM:SS
                              $hours = floor($seconds / 3600);
                              $remainder_1 = ($seconds % 3600);
                              $minutes = floor($remainder_1 / 60);
                              $seconds = ($remainder_1 % 60);
                              if (strlen($hours) == 1) {
                                 $hours = "0" . $hours;
                              }
                              if (strlen($minutes) == 1) {
                                 $minutes = "0" . $minutes;
                              }
                              if (strlen($seconds) == 1) {
                                 $seconds = "0" . $seconds;
                              }
                              return $hours . ":" . $minutes . "";
                           }
                           ?>
                           <div class="row">
                              <div class="col-lg-4 col-12">
                                 <div class="analytics-info">
                                    <h3 class="title">Plus Time</h3>
                                    <h3>
                                       <span class="plus_time plus-time-count plus-time-count1"><?php echo $result['plus_time']; ?></span>
                                    </h3>
                                 </div>
                              </div>
                              <div class="col-lg-4 col-12">
                                 <div class="analytics-info">
                                    <h3 class="title">Minus Time:</h3>
                                    <h3>
                                       <span class="minus_time minus-time-count minus-time-count1"><?php echo $result['minus_time']; ?></span>
                                    </h3>
                                 </div>
                              </div>
                              <div class="col-lg-4 col-12">
                                 <div class="analytics-info">
                                    <h3 class="title">Total Time:</h3>
                                    <h3 class="total_time1">
                                       <?php if ($result['time_status'] == 'plus') {
                                          echo '<span data-plus-time="" class=" plus_time plus-time-count">' . $result['total_time'] . '</span>';
                                       } else {
                                          echo '<span data-plus-time="" class="minus_time minus-time-count">' . $result['total_time'] . '</span>';
                                       } ?>
                                    </h3>
                                 </div>
                              </div>
                           </div>
                           <hr class="custom-hr">
                        </div>

                        <div class="table-responsive employee-table-list">
                           <div class="preloader preloader-2" style="display:none"><svg class="circular" viewBox="25 25 50 50">
                                 <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                              </svg></div>
                           <table class="table  display nowrap" id="example" style="width:100%">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Attendance</th>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>IN</th>
                                    <th>Out</th>
                                    <th>Total</th>
                                    <th>Time</th>
                                 </tr>
                              </thead>
                              <tbody class="data-attendance">
                              </tbody>
                           </table>
                        </div>
                     </div>

                     <div id="salary-increment-details" class="tab-pane fade" role="tabpanel" aria-labelledby="salary-increment-details-tab">
                        <div class="row justify-content-center">
                           <?php //echo "<pre>"; print_r($employee_increment_deatils); echo "</pre>"; 
                           ?>
                           <div class="col-12 col-lg-8 col-xl-6">
                              <div class="increment-list">
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-4 p-0">
                                          <h3 class="title">First Increment:</h3>
                                       </div>
                                       <div class="col-4 p-0">
                                          <h3 class="counter increment-first">-</h3>
                                       </div>
                                       <div class="col-4 p-0">
                                          <h3 class="counter increment-first-amount">0.00</h3>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="simple-info">
                                    <div class="row m-0">
                                       <div class="col-4 p-0">
                                          <h3 class="title">Second Increment:</h3>
                                       </div>
                                       <div class="col-4 p-0">
                                          <h3 class="counter increment-second">-</h3>
                                       </div>
                                       <div class="col-4 p-0">
                                          <h3 class="counter increment-second-amount">0.00</h3>
                                       </div>
                                    </div>
                                 </div>
                              </div>


                           </div>

                        </div>
                     </div>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- </div> -->
   <!-- login_log_id,employee_id,datetime -->
   <script type="text/javascript">
      // $('.mb-custom-tab').click(function(){
      // $(this).toggleClass('active');
      // });
      $('a.nav-link').click(function() {
         $('span.mb-custom-tab-active').text($(this).text());
         var id = $(this).attr('aria-controls');
         $('.tab-pane.fade').removeClass('show active');
         $('a').removeClass('active');
         $('a').parent().removeClass('active');
         $(this).addClass('active');
         var $this = $(this).text();
         $.each($('a.nav-link'), function() {
            if ($(this).text() == $this) {
               $(this).addClass('active');
               $(this).parent().addClass('active');
            }
         });
         $(this).parent().removeClass('active');
         $('#' + id).addClass('show');
      });

      /*  $(document).ready(function () {
          //change selectboxes to selectize mode to be searchable
          $("#employee_id").select2();
       }); */
      /* function openCity(cityName, elmnt, color) {
         // Hide all elements with class="tabcontent" by default 
         var i, tabcontent, tablinks;
         tabcontent = document.getElementsByClassName("tabcontent");
         for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
         }
       
         // Remove the background color of all tablinks/buttons
         tablinks = document.getElementsByClassName("tablink");
         // for (i = 0; i < tablinks.length; i++) {
         //  // tablinks[i].style.backgroundColor = "";
         // }
       
         // Show the specific tab content
         document.getElementById(cityName).style.display = "block";
         // Add the specific color to the button used to open the tab content
         // elmnt.style.backgroundColor = color;
       }*/

      // Get the element with id="defaultOpen" and click on it
      //document.getElementById("defaultOpen").click();
      // openCity('basic-details', document.getElementById("defaultOpen"), 'orange');
   </script>