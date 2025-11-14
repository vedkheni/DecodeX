<?php $user_session=$this->session->get('id'); ?>
<?php $todays_birthday = array(); ?>
<?php $upcoming_birthday = array(); ?>
<div id="page-wrapper" class="emp-dashboard">
   <div class="container-fluid">
      <div class="row bg-title">
         <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title">Dashboard</h4>
         </div>
         <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
         <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
         </ol>
         </div> -->
      </div>
      <?php $agree_terms_conditions = $get_employee_data[0]->agree_terms_conditions;
      $emp_id = $get_employee_data[0]->id;
      ?>
      <div class="row">
         <div class="col-12 col-md-6 col-xl-4">
            <div class="col-12 p-0">
               <div class="analytics-info border-none">
                  <h3 class="title">Used Paid Leave</h3>
                  <h3 class="counter">
                     <?php if (isset($leave_count)) {
                        echo $leave_count['paid_leave'];
                     } ?>
                  </h3>
               </div>
            </div>
            <div class="col-12 p-0">
               <div class="analytics-info border-none">
                  <h3 class="title">Used Sick Leaves <span class="info-tooltip" data-tooltip="The company will not pay when the employees are out of work due to illness."><i class="fa fa-info-circle" aria-hidden="true"></i></span></h3>
                  <h3 class="counter">
                     <?php if (isset($leave_count)) {
                        echo $leave_count['sick_leave'];
                     } ?>
                  </h3>
               </div>
            </div>
            <!-- <div class="col-lg-4 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Remaing Paid Leave</h3>
                <ul class="list-inline two-part">
                    <li>
                        <div id="sparklinedash3"></div>
                    </li>
                    <li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-info">
            <?php  //if(isset($leave_count)){
               //echo $leave_count['remaing_paid_leave'];
               //} 
               ?></span></li>
                </ul>
            </div>
            </div> -->
            <div class="col-12 p-0">
               <div class="analytics-info border-none">
                  <h3 class="title">Remaining Paid Leaves</h3>
                  <h3 class="counter">
                     <?php if (isset($leave_count)) {
                        echo $leave_count['remaing_paid_leave'];
                     } ?>
                  </h3>
               </div>
            </div>
            <!-- <div class="col-12 p-0">
               <div class="analytics-info border-none">
                  <h3 class="title">Remaining Sick Leaves</h3>
                  <h3 class="counter"><?php // if (isset($leave_count)) {
                     //echo $leave_count['remaing_sick_leave'];
                     //} 
                     ?></h3>
               </div>
            </div> -->
            <div class="col-12 p-0">
               <div class="analytics-info border-none">
                  <h3 class="box-title">Total Bonus</h3>
                  <h3 class="counter">
                     <?php if (isset($get_employee_total_bonus) && !empty($get_employee_total_bonus)) {
                        $bonus = 0;
                        if (!empty($get_employee_total_bonus[0]->total_bonus)) {
                           $bonus = $get_employee_total_bonus[0]->total_bonus;
                        }
                        echo $bonus;
                     } ?>
                  </h3>
               </div>
            </div>

            <?php  //echo "<pre>";print_r($get_employee_increment); echo "</pre>"; 
            ?>
            <?php $num = 0;
            foreach ($holiday_all as $d) {
               $b_date = date('Y-m-d', strtotime($d->holiday_date));
               if ($b_date >= date('Y-m-d') && $b_date <= date("Y-m-d", strtotime(" +1 months"))) {
                  $num++;
               }
            } ?>
            <?php if ($num > 0) { ?>
               <div class="panel active">
                  <div class="sk-chat-widgets">
                     <div class="panel panel-default dashboard-panel active">
                        <div class="panel-heading">
                           <span class="panel-heading-title">Upcoming Festival</span>
                           <span class="tag tag-primary" id="holiday_count"><?=@$num?></span>
                           <button type="button" class="panel-btn">
                              <span></span>
                              <span></span>
                           </button>
                        </div>
                        <div class="panel-body" style="display: block;">
                           <ul class="chatonline">
                              <li class="dropdown leave-dropdown-list open">
                                 <table class="leave-request-status dropdown-menu" role="leave_list" aria-labelledby="leave_list">
                                    <thead>
                                       <tr>
                                          <td class="leave-title"><strong>Date</strong></td>
                                          <td class="leave-title"><strong>Festival Name</strong></td>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php foreach ($holiday_all as $d) {
                                          $b_date = date('Y-m-d', strtotime($d->holiday_date));
                                          if ($b_date >= date('Y-m-d') && $b_date <= date("Y-m-d", strtotime(" +1 months"))) { ?>
                                             <tr>
                                                <td class="leave-data date"><?php echo dateFormat($d->holiday_date); ?></td>
                                                <td class="leave-data date"><?php echo $d->title; ?></td>
                                             </tr>
                                       <?php }
                                       } ?>
                                       <input type="hidden" id="data_Holidaycount" value="<?= $num ?>">
                                    </tbody>
                                 </table>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            <?php } ?>
            <?php if (!empty($get_employee_increment)) { ?>
               <!-- <div class="panel active">
                  <div class="sk-chat-widgets">
                     <div class="panel panel-default dashboard-panel active">
                        <div class="panel-heading">
                           <span class="panel-heading-title">Increment Details</span>
                           <span class="tag tag-primary" id="increment_count"></span>
                           <button type="button" class="panel-btn">
                              <span></span>
                              <span></span>
                           </button>
                        </div>
                        <div class="panel-body" style="display: block;">
                           <ul class="chatonline">
                              <span class="text-center d-block mb-3 font-bold text-primary">CTC : <?php //echo $profile[0]->salary; ?></span>
                              <li class="dropdown leave-dropdown-list open">
                                 <table class="leave-request-status dropdown-menu" role="leave_list" aria-labelledby="leave_list">
                                    <thead>
                                       <tr>
                                          <td class="leave-title">Date</td>
                                          <td class="leave-title">Amount</td>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php //$num = 0; foreach ($get_employee_increment as $d) { ?>
                                          <tr>
                                             <td class="leave-data date"><?php //echo dateFormat($d->increment_date); ?></td>
                                             <td class="leave-data date"><?php //echo $d->amount; ?></td>
                                          </tr>
                                       <?php // $num++; } ?>
                                       <input type="hidden" id="data_Incrementcount" value="<?= $num ?>">
                                    </tbody>
                                 </table>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div> -->
               <!-- <div class="col-12 col-md-6 col-xl-4">
               <div class="col-12 p-0  ">
                  <div class="white-box paid-panel-box">
                     <div class="row">
                        <div class="col-sm-6 col-xs-12">
                           <h3 class="box-title">Increment Details</h3>
                     
                        </div>
                  <div class="col-sm-6 col-xs-12">
                           <h3 class="box-title">CTC : <?php echo $profile[0]->salary; ?></h3>
                     
                        </div>
                        <div class="col-sm-12 col-xs-12">
                                 <table class="table  display nowrap" id="example_tbl" style="width:100%">
                           <thead>
                              <tr>
                                          <td>Date</td>
                                 <td>Amount</td>
                                       </tr>
                           </thead>
                                    <tbody>
                           <?php foreach ($get_employee_increment as $d) { ?>
                                       <tr>
                                          <td><?php echo $d->increment_date; ?></td>
                                 <td><?php echo $d->amount; ?></td>
                                       </tr>
                           <?php } ?>
                                    </tbody>
                                 </table>
                              
                        </div>
                     </div>
                  </div>
               </div>
            </div> -->
            <?php } ?>
         </div>

         <?php if (!empty($paid_leavesCount) && $paid_leavesCount != 0) { ?>
            <div class="col-12 col-md-6 col-xl-4">
               <div class="col-12 p-0  ">
                  <div class="white-box paid-panel-box">
                     <div class="row align-items-center mb-3">
                        <div class="col-sm-7 col-xs-12">
                           <h3 class="box-title m-0">Paid Leave Details <span class="tag tag-primary" id="leave_count"></span></h3>
                        </div>
                        <div class="col-sm-5 col-xs-12">
                           <div class="box-title-field">
                              <div class="single-field select-field">
                                 <input type="hidden" name="employee_id" id="employee_id" value="<?= $user_session; ?>">
                                 <select name="paidLeaveYear" id="paidLeaveYear">
                                    <?php for($i=date('Y');$i >=2018; $i--){ ?>
                                       <option value="<?= $i; ?>"><?= $i; ?></option>
                                    <?php } ?>
                                 </select>
                                 <label>Select Year</label>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm-12 col-xs-12">
                           <div class="deposit-table-scroll leave-list-table">
                              <div class="deposit-table" id="paiLeave">
                                 <?php if (!empty($employee_paid_leaves)) { ?>
                                 <table class="deposit-fixed">
                                    <tbody>
                                       <tr class="M_name emp_name month-details">
                                          <td class="emp_th">Month</td>
                                          <?php
                                          $keys = array_column($employee_paid_leaves, 'month');
                                          array_multisort($keys, SORT_ASC, $employee_paid_leaves);
                                          foreach ($employee_paid_leaves as $paid_leave) { ?>
                                             <td><?php echo date("M, Y", mktime(0, 0, 0, $paid_leave->month, 10, $paid_leave->year)); ?></td>
                                          <?php }
                                          ?>
                                       </tr>
                                    </tbody>
                                 </table>
                                 <div class="deposit-list">
                                    <table class="display nowrap deposit-list-table">
                                       <tbody class="deposit-details paid_leave_detail">
                                             <td class="emp_name">Paid <span>Leaves</span></td>
                                             <?php
                                             ksort($employee_paid_leaves);
                                             $num = 0;
                                             foreach ($employee_paid_leaves as $v) {
                                                if ($v->status == 'used') {
                                                   $class_name = "deposite-pending";
                                                   $leave_month = date(" M", mktime(0, 0, 0, $v->used_leave_month, 10, $v->year));
                                                   $leave_month_use = " - " . date(" M ", mktime(0, 0, 0, $v->used_leave_month, 10, $v->year)). ' '.ucwords($v->status);
                                                } else if ($v->status == 'rejected') {
                                                   $class_name = "deposite-rejected ";
                                                   $leave_month = date(" M ", mktime(0, 0, 0, $v->used_leave_month, 10, $v->year));
                                                   $leave_month_use = " - " . date(" M ", mktime(0, 0, 0, $v->used_leave_month, 10, $v->year)). ' '.ucwords($v->status);
                                                } else if($v->status == 'unused') {
                                                   $class_name = "";
                                                   $leave_month = "(" . date(" M ", mktime(0, 0, 0, $v->month, 10, $v->year)) . ")";
                                                   $leave_month_use = "". ' '.ucwords($v->status);
                                                }else{
                                                   $class_name = "all-deposite-paid ";
                                                   $leave_month = date(" M ", mktime(0, 0, 0, $v->used_leave_month, 10, $v->year));
                                                   $leave_month_use = " - " . date(" M ", mktime(0, 0, 0, $v->used_leave_month, 10, $v->year)). ' '.ucwords('paid');
                                                }
                                             ?>
                                                <td class="<?php echo $class_name; ?>"><span title="<?php echo $leave_month; ?>"><?php echo $v->leave . " " . $leave_month_use; ?></span></td>
                                             <?php $num++; }
                                            ?>
                                          <input type="hidden" id="data_Leavecount" value="<?= $num ?>">
                                       </tbody>
                                    </table>
                                 </div>
                                 <?php }else{
                                    echo '<input type="hidden" id="data_Leavecount" value="0"><li class="no-data w-100 p-3">Data not available!</li>';
                                 } ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         <?php } ?>
         <?php 
            // $time=date('Y-m',strtotime("10:00 AM"));
            $current_date = date('m-d');
            usort($get_employee, build_sorter('date_of_birth', 'ASC'));
            // echo "<pre>";print_r($get_employee);echo "</pre>";
            $num = 0;
            if (!empty($get_employee)) {
               foreach ($get_employee as $emp) {
                  $arr = array();
                  // $b_date = date('Y').'-'.date('m-d',strtotime($emp->date_of_birth));
                  // // $b_date = date('m-d', strtotime($emp->date_of_birth));
                  // if ($b_date == date('Y-m-d')) {
                  //    array_push($todays_birthday, $emp);
                  // } elseif ($b_date > date('Y-m-d') && $b_date <= date("Y-m-d", strtotime(" +3 months"))) {
                  //    array_push($upcoming_birthday, $emp);
                  // }
                  $bday = new DateTime($emp->date_of_birth); // Your date of birth
                  $today = new Datetime(date('Y-m-d'));
                  $diff = $today->diff($bday);
                  $b_date = '-'.date('m-d',strtotime($emp->date_of_birth));
                  $nextBday = (date('Y',strtotime($emp->date_of_birth))+1+$diff->y).$b_date;
                  
                  if (date('Y').$b_date == date('Y-m-d')) {
                     array_push($todays_birthday, $emp);
                  } elseif ($nextBday > date('Y-m-d') && $nextBday <= date("Y-m-d", strtotime(" +3 months"))){
                     $arr['profile_image'] = $emp->profile_image;
                     $arr['next_birthday'] = date("Y-m-d",strtotime($nextBday));
                     $arr['age'] = $diff->y;
                     $arr['name'] = $emp->fname . ' ' . $emp->lname;
                     $arr['gender'] = $emp->gender;
                     array_push($upcoming_birthday, $arr);
                  }
               }
            }
         ?>
         <div class="col-12 col-md-6 col-xl-4">
         <?php if (!empty($todays_birthday)) { ?>
               <div class="col-12 p-0">
                  <div class="panel">
                     <div class="sk-chat-widgets">
                        <div class="panel panel-default dashboard-panel">
                           <div class="panel-heading">
                              <span class="panel-heading-title">Today's Birthday</span>
                              <span class="tag tag-primary" id="today_count"></span>
                              <button type="button" class="panel-btn">
                                 <span></span>
                                 <span></span>
                              </button>
                           </div>
                           <div class="panel-body" style="display: block;">
                              <ul class="chatonline b-date">
                                 <?php
                                 //if (!empty($todays_birthday)) {
                                 $num = 0;
                                 foreach ($todays_birthday as $emp) {
                                    if ($emp->profile_image != "") {
                                       $img2 = $_SERVER['DOCUMENT_ROOT'] . "/assets/profile_image32x32/" . $emp->profile_image;
                                       if (file_exists($img2)) {
                                          $img = base_url() . "assets/profile_image32x32/" . $emp->profile_image;
                                       } else {
                                          if ($emp->gender == 'male') {
                                             $img = base_url() . "assets/images/male-default.svg";
                                          } else {
                                             $img = base_url() . "assets/images/female-default.svg";
                                          }
                                       }
                                    } else {
                                       if ($emp->gender == 'male') {
                                          $img = base_url() . "assets/images/male-default.svg";
                                       } else {
                                          $img = base_url() . "assets/images/female-default.svg";
                                       }
                                    }
                                    $dateofbirth = date('Y') . '-' . date('m-d', strtotime($emp->date_of_birth));
                                    $today = date("Y-m-d");
                                    $diff = date_diff(date_create(Format_date($emp->date_of_birth)), date_create($today));
                                    echo '<li class="">
                                       <a href="javascript:void(0)">
                                          <img src="' . $img . '" alt="user-img" class="img-circle"> 
                                          <span>' . $emp->fname . ' ' . $emp->lname . '<small class="text-primary">Today, ' . date('M Y') . ' - ' . $diff->format('%y') . ' Years old</small></span>
                                       </a>
                                    </li>';
                                    $num++;
                                 }
                                 // } else { 
                                 ?>
                                 <!-- <li class="no-data">Data not available!</li> -->
                                 <?php //} 
                                 ?>
                                 <input type="hidden" id="data_Todaycount" value="<?= $num ?>">
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            <?php } ?>
            <div class="col-12 p-0">
               <div class="panel">
                  <div class="sk-chat-widgets">
                     <div class="panel panel-default dashboard-panel">
                        <div class="panel-heading">
                           <span class="panel-heading-title">Upcoming Birthday</span>
                           <span class="tag tag-primary" id="upcoming_Birthcount"></span>
                           <button type="button" class="panel-btn">
                              <span></span>
                              <span></span>
                           </button>
                        </div>
                        <div class="panel-body" style="display: block;">
                           <ul class="chatonline b-date">
                              <?php
                              $num = 0;
                              if (!empty($upcoming_birthday)) {
                                 array_multisort(array_column($upcoming_birthday,'next_birthday'), SORT_ASC, $upcoming_birthday);
                                 foreach ($upcoming_birthday as $emp) {
                                       if ($emp['profile_image'] != "") {
                                          $img2 = $_SERVER['DOCUMENT_ROOT'] . "/assets/profile_image32x32/" . $emp['profile_image'];
                                          if (file_exists($img2)) {
                                             $img = base_url() . "assets/profile_image32x32/" . $emp['profile_image'];
                                          } else {
                                             if ($emp['gender'] == 'male') {
                                                $img = base_url() . "assets/images/male-default.svg";
                                             } else {
                                                $img = base_url() . "assets/images/female-default.svg";
                                             }
                                          }
                                       } else {
                                          if ($emp['gender'] == 'male') {
                                             $img = base_url() . "assets/images/male-default.svg";
                                          } else {
                                             $img = base_url() . "assets/images/female-default.svg";
                                          }
                                       }

                                       echo '<li class="">
                                       <a href="javascript:void(0)">
                                          <img src="' . $img . '" alt="user-img" class="img-circle"> 
                                          <span>' . $emp['name'] . '<small class="text-primary">' .$emp['next_birthday'] . ' - ' . ($emp['age']+1) . ' Years old</small></span>
                                       </a>
                                    </li>';
                                       $num++;
                              ?>
                                 <?php }
                              } else { ?>
                                 <li class="no-data">Data not available!</li>
                              <?php } ?>
                              <input type="hidden" id="data_Birthcount" value="<?= $num ?>">
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-12 p-0">
               <div class="panel">
                  <div class="sk-chat-widgets">
                     <div class="panel panel-default dashboard-panel">
                        <div class="panel-heading">
                           <span class="panel-heading-title">Your PC ID - 
                              <span class="idofpc">
                                 <?php if (isset($get_pc_data[0])) {
                                    echo $get_pc_data[0]->pc_id;
                                 } ?>
                              </span>
                           </span>
                           <button type="button" class="panel-btn">
                              <span></span>
                              <span></span>
                           </button>
                        </div>
                        <div class="panel-body" style="display: block;">
                           <div class="form-group with-btn m-2">
                              <div class="single-field">
                                 <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $emp_id; ?>">
                                 <input type="number" class="numeric" name="change_pc_id" id="change_pc_id" value="">
                                 <label>PC ID*</label>
                              </div>
                              <button type="button" id="btn-change_id" class="btn btn-outline-secondary">
                              <?php if (isset($get_pc_data[0])) {
                                 echo 'Change';
                              } else {
                                 echo 'Add';
                              } ?></button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php if (!empty($broadcast_list)) { ?>
            <div class="panel">
               <div class="sk-chat-widgets">
                  <div class="panel panel-default dashboard-panel">
                     <div class="panel-heading">
                        <span class="panel-heading-title">Broadcast</span>
                        <span class="tag tag-primary" id="broadcast_count"></span>
                        <button type="button" class="panel-btn">
                           <span></span>
                           <span></span>
                        </button>
                     </div>
                     <div class="panel-body" style="display: block;">
                        <ul class="chatonline">
                           <?php 
                           $num = 0;
                           if (!empty($broadcast_list)) {
                              foreach ($broadcast_list as $broadcast) {
                                 $img2 = $_SERVER['DOCUMENT_ROOT'] . "/assets/upload/broadcast_attachment/" . $broadcast->attachment;
                                 if ($broadcast->attachment != "") {
                                    $attachment = (file_exists($img2)) ? base_url() . "assets/upload/broadcast_attachment/" . $broadcast->attachment : '';
                                 } else {
                                    $attachment = '';
                                 }
                                 $expiry_date = date('Y-m-d', strtotime($broadcast->expiry_date));
                                 if(date('Y-m-d') < $expiry_date){
                                 ?>
                                 <li class="">
                                 <div class="annonce-sm">
                                    <a href="javascript:void(0)" onclick="openAnnouncmentModal();"><i class="fas fa-bullhorn"></i><?php echo $broadcast->title; ?></a>
                                    <?php if(!empty($attachment)){ ?>
                                       <a href="<?php echo $attachment; ?>" data-tooltip="View Attachments" flow="left" data-fancybox="image_group1" class="attache-btn"><i class="fas fa-file"></i></a>
                                    <?php } ?>
                                 </div>
                                 </li>
                           <?php $num++; } }
                           } 
                           if($num == 0){
                              echo '<li class="no-data">Data not available!</li> ';
                           }
                           ?>
                           <input type="hidden" id="data_Broadcast" value="<?php echo $num?>">
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <?php }else{
               echo '<li class="no-data">Data not available!</li>';
            } ?>
         </div>
      </div>
   </div>

   <div class="modal" id="myModal" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
               <div class="modal_header">
                  <h4 class="modal-title emp_name employee_name">Team & Condition</h4>
               </div>
            </div>
            <div class="modal-body">
               <!-- <div class="white-box m-0"> -->
               <div class="preloader preloader-2">
                  <svg class="circular" viewBox="25 25 50 50">
                     <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                  </svg>
               </div>
               <div class="massge_for_error text-center"><?php echo $this->session->getFlashdata('message'); ?> </div>
               <div class="massge_for_error text-center time_msg"></div>
               <form class="emp-attendance-form" method="post" id="employee-form">
                  <h4 class="page-title blue-text text-center m-0 text-capitalize"></h4>
                  <!-- <hr class="custom-hr"> -->
                  <div class="row justify-content-center">
                     <div class="col-12 ">
                        <?php if (isset($terms_and_condition) && !empty($terms_and_condition[0]->description)) {
                           echo $terms_and_condition[0]->description;
                        } ?>

                     </div>
                  </div>
                  <!-- </div> -->
            </div>
            <div class="modal-footer text-right">
               <button type="button" class="btn sec-btn submit_form agree_terms_and_condition">Agree</button>
            </div>
            </form>
         </div>
      </div>
   </div>
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
   </div>
   <script type="text/javascript">
      $(document).ready(function() {
         var data_Birthcount = $('#data_Birthcount').val();
         $('#upcoming_Birthcount').text(data_Birthcount);
         var data_Todaycount = $('#data_Todaycount').val();
         $('#today_count').text(data_Todaycount);
         var data_Leavecount = $('#data_Leavecount').val();
         $('#leave_count').text(data_Leavecount);
         var data_Broadcast = $('#data_Broadcast').val();
         $('#broadcast_count').text(data_Broadcast);
         var data_Incrementcount = $('#data_Incrementcount').val();
         $('#increment_count').text(data_Incrementcount);
         var data_Holidaycount = $('#data_Holidaycount').val();
         $('#holiday_count').text(data_Holidaycount);

      });

      if ($(".text1 p").text() != '') {
         $('.msg-container .box1').attr('style', 'display:block');
         setTimeout(function() {
            $('.msg-container .box1').attr('style', 'display:none');
         }, 6000);
      }
      $(document).ready(function($) {
         var agree_terms_conditions = '<?php echo $agree_terms_conditions; ?>';
         console.log(agree_terms_conditions);
         if (agree_terms_conditions == 0) {
            //$('#myModal').modal("show");
         }
         $(document).on('click', '.agree_terms_and_condition', function() {
            var base_url = $("#js_data").data('base-url');
            var agree = 0;
            if ($("#agree").prop("checked") == true) {
               agree = 1;
            }
            var data = {
               'emp_id': "<?php echo $emp_id; ?>",
               'agree': agree,
            };
            $.ajax({
               url: base_url + 'terms_and_condition/agree_team',
               type: 'post',
               data: data,
               success: function(response) {
                  //location.reload();
                  console.log(response);
                  $('.msg-container').html('<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Updated Successfully.</p></div></div></div>');
                  $('.msg-container .msg-box').attr('style', 'display:block');
                  setTimeout(function() {
                     $('.msg-container .msg-box').attr('style', 'display:none');
                  }, 6000);
                  console.log(response);
               }
            });
         });

      });
   </script>