<?php $todays_birthday=array(); ?>
<?php $upcoming_birthday=array(); ?>
<!-- Page Content -->
<!-- ============================================================== -->
<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title">Dashboard</h4>
         </div>
        
      </div>
      <?php
      $increment_data = array();
      if (!empty($get_employee_increment)) {
         foreach ($get_employee_increment as $v) {
            $increment_data[$v->employee_id] = $v;
         }
      }
      
      
      ?>
      

      <!-- Increment Rejected Modal Start -->

      <div id="myModal_increment_rejected" class="modal increment-reject-modal" role="dialog">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="preloader preloader-2 reject_preloader" style="display:none"><svg class="circular" viewBox="25 25 50 50">
                     <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                  </svg></div>

               <div class="modal-header">
                  <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
                  <div class="modal_header-content">
                     <h4 class="modal-title emp_name employee_name">Tarun Gudala</h4>
                     <h5 class="modal-sub-title">Increment</h5>
                  </div>
               </div>

               <form method="POST" name="increment_form_rejected" id="increment_form_rejected">
                  <div class="modal-body">
                     <div class="salary_main days">

                        <div class="row">
                           <input type="hidden" name="rejected_emp_id" id="rejected_emp_id" value="">
                           <input type="hidden" name="rejected_increment_status" class="rejected_increment_status" id="rejected_increment_status" value="">
                           <div class="col-6">
                              <div class="form-sigle-line">
                                 <p>Employed Date :</p>
                              </div>
                           </div>
                           <div class="col-6">
                              <p data-join-date="" class="salay_details join_date"> 03-02-2019</p>
                           </div>
                        </div>

                        <div class="row align-items-center">
                           <div class="col-6">
                              <div class="form-sigle-line">
                                 <label class="m-0">Increment Date :</label>
                              </div>
                           </div>
                           <div class="col-12 col-sm-6">
                              <div class="single-field date-field salay_details">
                                 <input type="text" name="rejected_increment_date" id="rejected_increment_date" class='datepicker-here' data-language='en'>
                              </div>
                           </div>
                        </div>

                        <!-- <div class="row">
                        <div class="days modal-row col-sm-12">
                           <div class="">
                              <input type="hidden" name="rejected_emp_id" id="rejected_emp_id" value="">
                              <input type="hidden" name="rejected_increment_status" class="rejected_increment_status" id="rejected_increment_status" value="">
                              <div class="salary-popup attendance-time" >
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <p class="control-label col-sm-12 ">Join Date:<span data-join-date="" class="salay_details join_date"> 03-02-2019</span></p>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <p class="control-label col-sm-12 ">Increment Date :<span class="salay_details"><input type="text" name="rejected_increment_date" id="rejected_increment_date" class='datepicker-here' data-language='en' style="width: 70%; float: right;"></span></p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div> -->

                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn sec-btn increment-submit-rejected salary-update">Submit<span class="btn-toggel">Successfully updated.</span></button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Increment Rejected Modal End -->

      <!-- Increment Approve Modal Start -->
      <div class="modal increment-modal" id="myModal_increment" role="dialog">

         <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">
               <div class="preloader preloader-2 approve_preloader" style="display:none"><svg class="circular" viewBox="25 25 50 50">
                     <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                  </svg></div>

               <div class="modal-header">
                  <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
                  <div class="modal_header-content">
                     <h4 class="modal-title emp_name employee_name">Tarun Gudala</h4>
                     <h5 class="modal-sub-title">Increment</h5>
                  </div>
               </div>

               <form method="POST" name="increment_form" id="increment_form">
                  <div class="modal-body">
                     <div class="salary_main days">

                        <div class="row">
                           <div class="col-6">
                              <div class="form-sigle-line">
                                 <p>Current Salary :</p>
                              </div>
                           </div>
                           <div class="col-6">
                              <p data-join-date="" class="salay_details current_salary"> -</p>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-6">
                              <div class="form-sigle-line">
                                 <p>Employee Status :</p>
                              </div>
                           </div>
                           <div class="col-6">
                              <p data-join-date="" class="salay_details employee_status"> -</p>
                           </div>
                        </div>

                        <div class="row">
                           <input type="hidden" id="id" id="id" value="">
                           <input type="hidden" name="emp_id" id="emp_id" value="">
                           <input type="hidden" name="increment_status" class="increment_status" id="increment_status" value="">
                           <div class="col-6">
                              <div class="form-sigle-line">
                                 <p>Employed Date :</p>
                              </div>
                           </div>
                           <div class="col-6">
                              <p data-join-date="" class="salay_details join_date"> 03-02-2019</p>
                           </div>
                        </div>

                        <div class="row align-items-center m-b-20">
                           <div class="col-12 col-sm-6">
                              <div class="form-sigle-line">
                                 <label class="m-0">Increment Date :</label>
                              </div>
                           </div>
                           <div class="col-12 col-sm-6">
                              <div class="single-field date-field salay_details">
                                 <input type="text" name="increment_date" id="increment_date" class='datepicker-here' data-language='en' autocomplete="off">
                              </div>
                           </div>
                        </div>

                        <div class="row align-items-center m-b-20">
                           <div class="col-12 col-sm-6">
                              <div class="form-sigle-line">
                                 <label class="m-0">Increment Amount :</label>
                              </div>
                           </div>
                           <div class="col-12 col-sm-6">
                              <div class="single-field salay_details">
                                 <input type="text" name="increment_amount" step="any" id="increment_amount">
                              </div>
                           </div>
                        </div>

                        <div class="row align-items-center">
                           <div class="col-12 col-sm-6">
                              <div class="form-sigle-line">
                                 <label class="m-0">Next Increment Date :</label>
                              </div>
                           </div>
                           <div class="col-12 col-sm-6">
                              <div class="single-field date-field salay_details">
                                 <input type="text" class='datepicker-here' data-language='en' name="next_increment_amount" autocomplete="off" step="any" id="next_increment_amount">
                              </div>
                           </div>
                        </div>


                        <!-- <div class="row">
                     <div class="days modal-row col-sm-12">
                        <div class="">
                           <div class="salary-popup attendance-time" >
                              <div class="col-sm-6">
                                 <div class="form-group">
                                    <p class="control-label col-sm-12 ">Current Salary:<span data-join-date="" class="salay_details current_salary"> -</span></p>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-group">
                                    <p class="control-label col-sm-12 ">Employee Status:<span data-join-date="" class="salay_details employee_status"> -</span></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="">
                           <input type="hidden" id="id" id="id" value="">
                           <input type="hidden" name="emp_id" id="emp_id" value="">
                           <input type="hidden" name="increment_status" class="increment_status" id="increment_status" value="">
                           <div class="salary-popup attendance-time" >
                              <div class="col-sm-6">
                                 <div class="form-group">
                                    <p class="control-label col-sm-12 ">Join Date:<span data-join-date="" class="salay_details join_date"> 03-02-2019</span></p>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-group">
                                    <p class="control-label col-sm-12 ">Increment Date :<span class="salay_details"><input type="text" name="increment_date" id="increment_date" class='datepicker-here' data-language='en' style="width: 70%; float: right;"></span></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="">
                           <div class="salary-popup attendance-time" >
                              <div class="col-sm-6">
                                 <div class="form-group">
                                    <p class="control-label col-sm-12 ">Increment Amount :<span class="salay_details"><input  type="text" name="increment_amount" step="any" id="increment_amount"  style="width: 70%; float: right;"></span></p>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-group">
                                    <p class="control-label col-sm-12 ">Next Increment Date :<span  class="salay_details"><input type="text" class='datepicker-here' data-language='en' name="next_increment_amount" step="any" id="next_increment_amount"  style="width: 70%; float: right;"></span></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div> -->
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn sec-btn increment-submit salary-update">Submit<span class="btn-toggel">Successfully Approved.</span></button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Increment Approve Modal End -->
      <?php	 

      ?>

      <div class="row">

         <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="panel">
               <div class="sk-chat-widgets">
                  <div class="panel panel-default dashboard-panel">
                     <div class="panel-heading">
                        <span class="panel-heading-title">Increment Employee</span>
                        <span class="tag tag-primary" id="increment_count"></span>
                        <button type="button" class="panel-btn">
                           <span></span>
                           <span></span>
                        </button>
                     </div>
                     <div class="panel-body" style="display: block;">
                        <ul class="chatonline">
                           <?php
                           $num = 0;
                           if (!empty($get_employee_increment)) {
                              $current_date = date('Y-m-d');
                              foreach ($get_employee_increment as $emp) {
                                 $emp_increment = date('Y-m-d', strtotime($emp->increment_date));

                                 if ($emp_increment >= date('Y-m-01') && $emp_increment < date("Y-m-01", strtotime(" +6 months"))) {
                                    // echo $emp_increment;
                                    $emp_increment_id = $emp->id;
                                    foreach ($get_employee_joining_date as $emp_list) {

                                       if ($emp_list->id == $emp->employee_id) {
                                          $num++;
                                          if ($emp_list->profile_image != "") {
                                             $image1 = $_SERVER['DOCUMENT_ROOT'] . "/assets/profile_image32x32/" . $emp_list->profile_image;
                                             if (file_exists($image1)) {
                                                $image = base_url() . "assets/profile_image32x32/" . $emp_list->profile_image;
                                             } else {
                                                if ($emp_list->gender == 'male') {
                                                   $image = base_url() . "assets/images/male-default.svg";
                                                } else {
                                                   $image = base_url() . "assets/images/female-default.svg";
                                                }
                                             }
                                          } else {
                                             if ($emp_list->gender == 'male') {
                                                $image = base_url() . "assets/images/male-default.svg";
                                             } else {
                                                $image = base_url() . "assets/images/female-default.svg";
                                             }
                                          }

                           ?>
                                          <li class="dropdown leave-dropdown-list">
                                             <a href="javascript:void(0)" class="dropdown-toggle toggle-arow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <img src="<?php echo $image; ?>" alt="user-img" class="img-circle">
                                                <span><?php echo $emp_list->fname . " " . $emp_list->lname; ?> <small class="text-primary"><?php echo dateFormat($emp_increment); ?> - <?php echo $emp_list->salary; ?></small></span>
                                             </a>
                                             <table class="leave-request-status dropdown-menu" role="leave_list" aria-labelledby="leave_list">
                                                <!--  <thead>
                              <tr>
                                 <td class="leavedata-title">Date</td>
                                 <td  class="leavedata-title" colspan="2">Action</td>
                              </tr>
                           </thead> -->
                                                <tbody>
                                                   <tr>
                                                      <!-- <td class="leavedata"><?php echo $emp_list->employed_date; ?></td> -->
                                                      <td class="leavedata">
                                                         <button type="button" data-approv_id="<?php echo $emp_increment_id; ?>" data-employed_date="<?php echo dateFormat($emp_list->employed_date); ?>" data-id="<?php echo $emp_list->id; ?>" data-toggle="modal" data-target="#myModal_increment" class="btn sec-btn  sec-btn-outline btn-block increment-update-date" data-increment-status="Approved">Approve</button>
                                                      </td>
                                                      <td class="leavedata">
                                                         <button type="button" data-reject_id="<?php echo $emp_increment_id; ?>" data-employed_date="<?php echo dateFormat($emp_list->employed_date); ?>" data-id="<?php echo $emp_list->id; ?>" data-toggle="modal" data-target="#myModal_increment_rejected" class="btn btn-outline-danger btn-block increment-update-date" data-increment-status="Pending">Update</button>
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </li>

                           <?php }
                                    }
                                 }
                              }
                           } else{ ?>
                              <li class="no-data">Data not available!</li>
                           <?php } ?>
                           <input type="hidden" id="data_count" value="<?=$num?>">
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <?php 
                  // $time=date('Y-m',strtotime("10:00 AM"));
                  $current_date = date('Y-m-d');
                  usort($get_employee, build_sorter('date_of_birth', 'ASC'));
                  // echo "<pre>";print_r($get_employee);echo "</pre>";
                  if (!empty($get_employee)) {
                     foreach ($get_employee as $emp) {
                        $arr = array();
                        // $b_date = date('Y').'-'.date('m-d',strtotime($emp->date_of_birth));
                        // // $b_date = date('m-d', strtotime($emp->date_of_birth));
                        // if($b_date == date('Y-m-d')){
                        //    array_push($todays_birthday, $emp);
                        // }elseif ($b_date > date('Y-m-d') && $b_date <= date("Y-m-d", strtotime(" +3 months"))) {
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
         <?php if (!empty($todays_birthday)) { ?>
            <div class="panel">
               <div class="sk-chat-widgets">
                  <div class="panel panel-default dashboard-panel">
                     <div class="panel-heading">
                        <span class="panel-heading-title">Today's Birthday</span>
                        <span class="tag tag-primary" id="todayBirth_count"></span>
                        <button type="button" class="panel-btn">
                           <span></span>
                           <span></span>
                        </button>
                     </div>
                     <div class="panel-body" style="display: block;">
                        <ul class="chatonline b-date">
                           <?php
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
                                       <span>' . $emp->fname . ' ' . $emp->lname . '<small class="text-primary">Today, '.date('M Y').' - '. $diff->format('%y').' Years old</small></span>
                                       </a>
                                       </li>';
                                       // <span>' . $emp->fname . ' ' . $emp->lname . '<small class="text-primary">' . dateFormat($dateofbirth) . '</small></span>
                                    $num++;
                              } ?>
                              <input type="hidden" id="data_Todaycount" value="<?=$num?>">
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            <?php } ?>
            <div class="panel">
               <div class="sk-chat-widgets">
                  <div class="panel panel-default dashboard-panel">
                     <div class="panel-heading">
                        <span class="panel-heading-title">Upcoming Birthday</span>
                        <span class="tag tag-primary" id="upcomingBirthday_count"></span>
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
                                       <span>' . $emp['name'] . '<small class="text-primary">' . $emp['next_birthday'].' - '. ($emp['age']+1).' Years old</small></span>
                                    </a>
                                 </li>';
                                 $num++;
                           ?>
                           <?php }
                           }else{ ?>
                              <li class="no-data">Data not available!</li> 
                           <?php } //} ?>
                           <input type="hidden" id="data_Birthcount" value="<?=$num?>">
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <?php
            $sts = array();
            foreach ($get_current_date_attedance_status as $status) {
               if ($status->employee_in != "") {
                  $sts[$status->employee_id] = '<small class="text-success">Online</small>';
               }
               if ($status->employee_out != "") {
                  $sts[$status->employee_id] = '<small class="text-danger">Offline</small>';
               }
            }
            //print_r($sts); print_r($get_current_date_attedance_status);  echo "</pre>";
            ?>
            <div class="panel">
               <div class="sk-chat-widgets">
                  <div class="panel panel-default dashboard-panel">
                     <div class="panel-heading">
                        <span class="panel-heading-title">Interview Schedule Mail</span>
                        <span class="tag tag-primary" id="interview_count"></span>
                        <button type="button" class="panel-btn">
                           <span></span>
                           <span></span>
                        </button>
                     </div>
                     <div class="panel-body" style="display: block;">
                        <ul class="chatonline">
                           <?php
                           //print_r();
                           $num = 0;
                           if(isset($get_interview_schedule) && !empty($get_interview_schedule)){
                              foreach ($get_interview_schedule as $interview_schedule) {
                              foreach ($designation_list as $key => $value) {
                                 if ($value->id == $interview_schedule->designation) {
                                    $d = ucwords($value->name);
                                 }
                              }
                              if (!isset($sts[$interview_schedule->id]) && empty($sts[$interview_schedule->id]) && $interview_schedule->interview_status != "reject" && $interview_schedule->status != 'reject') {
                                 if ($interview_schedule->gender == 'male') {
                                    $img = base_url() . "assets/images/male-default.svg";
                                 } else {
                                    $img = base_url() . "assets/images/female-default.svg";
                                 }
                           ?>
                                 <li class="dropdown leave-dropdown-list">
                                    <a href="javascript:void(0)" class="dropdown-toggle toggle-arow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       <img src="<?php echo $img; ?>" alt="user-img" class="img-circle">
                                       <span onclick="goTOList($(this))" data-candidates_id="<?= $interview_schedule->candidate_id; ?>">
                                          <span>
                                             <?php echo $interview_schedule->name; ?>
                                             <span class="small"> | <?php echo $d; ?></span>
                                          </span>
                                          <span class="badge-grp">
                                             <small class="badge badge-pill badge-secondary"><?php echo dateFormat($interview_schedule->interview_date); ?></small>
                                             <?php if(!empty($interview_schedule->phone_number)){ ?>
                                                <small class="badge badge-pill badge-secondary"><?php echo $interview_schedule->phone_number; ?></small>
                                             <?php } ?>
                                          </span>
                                       </span>
                                    </a>
                                    <table class="leave-request-status dropdown-menu" role="leave_list" aria-labelledby="leave_list">
                                       <!--  <thead>
                                 <tr>
                                    <td class="leavedata-title">Date</td>
                                    <td  class="leavedata-title" colspan="2">Action</td>
                                 </tr>
                              </thead> -->
                                       <tbody>
                                          <tr>
                                             <!-- <td class="leavedata"><?php //echo $emp_list->employed_date; 
                                                                        ?></td> -->
                                             <td class="leavedata">
                                                <button type="button" data-name="<?php echo $interview_schedule->name; ?>" data-schedule="<?php echo $interview_schedule->id; ?>" data-id="<?php echo $interview_schedule->candidate_id; ?>" data-date="<?php echo dateFormat($interview_schedule->interview_date); ?>" data-time="<?php echo $interview_schedule->interview_time; ?>" data-designation="<?php echo $d; ?>" class="btn btn-block sec-btn  sec-btn-outline" onclick="mail_send_click($(this));">Send Mail</button>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </li>
                           <?php $num++; }else{
                                 echo '<li class="no-data">Data not available!</li>';
                           }
                           } }else{ ?>
                              <li class="no-data">Data not available!</li> 
                           <?php } ?>
                           <input type="hidden" id="data_Interviewcount" value="<?=$num?>">
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="panel">
               <div class="sk-chat-widgets">
                  <div class="panel panel-default dashboard-panel">
                     <div class="panel-heading">
                        <span class="panel-heading-title">Absent Employees</span>
                        <span class="tag tag-primary" id="absent_count"></span>
                        <button type="button" class="panel-btn">
                           <span></span>
                           <span></span>
                        </button>
                     </div>
                     <div class="panel-body" style="display: block;">
                        <ul class="chatonline">
                           <?php
                           //print_r();
                           $num = 0;
                           if(isset($get_employee) && !empty($get_employee)){
                              foreach ($get_employee as $emp_list1) {
                                 if (!isset($sts[$emp_list1->id]) && empty($sts[$emp_list1->id])) {
                                    if ($emp_list1->profile_image != "") {
                                       $img4 = $_SERVER['DOCUMENT_ROOT'] . "/assets/profile_image32x32/" . $emp_list1->profile_image;
                                       if (file_exists($img4)) {
                                          $img = base_url() . "assets/profile_image32x32/" . $emp_list1->profile_image;
                                       } else {
                                          if ($emp_list1->gender == 'male') {
                                             $img = base_url() . "assets/images/male-default.svg";
                                          } else {
                                             $img = base_url() . "assets/images/female-default.svg";
                                          }
                                       }
                                    } else {
                                       if ($emp_list1->gender == 'male') {
                                          $img = base_url() . "assets/images/male-default.svg";
                                       } else {
                                          $img = base_url() . "assets/images/female-default.svg";
                                       }
                                    } ?>
                                    <li>
                                       <a href="<?php echo base_url('employee/employee_attendance_list/' . $emp_list1->id); ?>"><img src="<?php echo $img; ?>" alt="user-img" class="img-circle"> <span><?php echo $emp_list1->fname . " " . $emp_list1->lname; ?>
                                             <?php if (isset($sts[$emp_list1->id]) && !empty($sts[$emp_list1->id])) {
                                                echo $sts[$emp_list1->id];
                                             } else {
                                                echo '<small class="text-danger">Absent</small>';
                                             } ?>
                                          </span></a>
                                       <!--<div class="call-chat">
                                    <button class="btn btn-success btn-circle btn-lg" type="button"><i class="fa fa-phone"></i></button>
                                    <button class="btn btn-info btn-circle btn-lg" type="button"><i class="fa fa-comments-o"></i></button>
                                    </div>-->
                                    </li>
                              <?php $num++; } } }else{ ?>
                                 <li class="no-data">Data not available!</li> 
                              <?php } ?>
                              <input type="hidden" id="data_Absentcount" value="<?=$num?>">
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="panel">
               <div class="sk-chat-widgets">
                  <div class="panel panel-default dashboard-panel">
                     <div class="panel-heading">
                        <span class="panel-heading-title">Pending Leave Request</span>
                        <span class="tag tag-primary" id="leave_count"></span>
                        <button type="button" class="panel-btn">
                           <span></span>
                           <span></span>
                        </button>
                     </div>
                     <?php $leavedata = array();
                     if (!empty($this_month_leave)) {
                        foreach ($this_month_leave as $leave) {
                           $leavedata[$leave->employee_id]['leave_date'][] = $leave->leave_date;
                           $leavedata[$leave->employee_id]['id'][] = $leave->id;
                           $leavedata[$leave->employee_id]['status'][] = $leave->status;
                           $leavedata[$leave->employee_id]['name'][] = $leave->fname . "" . $leave->lname;
                           $leavedata[$leave->employee_id]['profile_image'][] = $leave->profile_image;
                           $leavedata[$leave->employee_id]['gender'][] = $leave->gender;
                        }
                     }
                     ?>
                     <div class="panel-body" style="display: block;">
                        <ul class="chatonline">
                           <?php
                           //  echo "<pre>";
                           // print_r($leavedata);
                           // echo "</pre>"; 
                           $num = 0;
                           if (!empty($leavedata)) {
                              foreach ($leavedata as $leave_list) {
                                 $img2 = $_SERVER['DOCUMENT_ROOT'] . "/assets/profile_image32x32/" . $leave_list['profile_image'][0];
                                 if ($leave_list['profile_image'][0] != "") {
                                    if (file_exists($img2)) {
                                       $img = base_url() . "assets/profile_image32x32/" . $leave_list['profile_image'][0];
                                    } else {
                                       if ($leave_list['gender'][0] == 'male') {
                                          $img = base_url() . "assets/images/male-default.svg";
                                       } else {
                                          $img = base_url() . "assets/images/female-default.svg";
                                       }
                                    }
                                 } else {
                                    if ($leave_list['gender'][0] == 'male') {
                                       $img = base_url() . "assets/images/male-default.svg";
                                    } else {
                                       $img = base_url() . "assets/images/female-default.svg";
                                    }
                                 }

                                 $leave_count = count($leave_list['leave_date']); ?>
                                 <li class="dropdown leave-dropdown-list">
                                    <a href="javascript:void(0)" class="dropdown-toggle toggle-arow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       <img src="<?php echo $img; ?>" alt="user-img" class="img-circle">
                                       <span><?php echo $leave_list['name'][0]; ?> <small class="text-primary"><?php echo $leave_count; ?></small></span>
                                    </a>
                                    <table class="leave-request-status dropdown-menu" role="leave_list" aria-labelledby="leave_list">
                                       <thead>
                                          <tr>
                                             <td class="leave-title">Date</td>
                                             <!-- <td class="leave-title">Status</td> -->
                                             <td class="leave-title">Action</td>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php foreach ($leave_list['leave_date'] as $k => $leave_date) { ?>
                                             <tr>
                                                <td class="leave-data date"><?php echo dateFormat($leave_date); ?></td>
                                                <!-- <td class="leave-data status"><?php //echo ucwords($leave_list['status'][$k]); 
                                                                                    ?></td> -->
                                                <td class="leave-data lave-btn">
                                                   <?php if(count($leave_list['leave_date']) > 1){ ?>
                                                   <input type="checkbox" value="<?php echo $leave_list['id'][$k] ?>" class="leave_checkbox" name="leave">
                                                   <?php }else{ ?>
                                                      <button class="btn sec-btn  sec-btn-outline btn-sm status-update" data-id="<?php echo $leave_list['id'][$k] ?>" data-status="Approved">Approve</button>
                                                      <button class="btn btn-outline-danger btn-sm status-update" data-id="<?php echo $leave_list['id'][$k] ?>" data-status="Rejected">Reject</button>      
                                                   <?php } ?>
                                                </td>
                                             </tr>
                                          <?php } ?>
                                          <?php if(count($leave_list['leave_date']) > 1){ ?>
                                          <tr>
                                             <td colspan="2" class="leave-data lave-btn">
                                                <button class="btn sec-btn  sec-btn-outline btn-sm status-update" data-status="Approved">Approve</button>
                                                <button class="btn btn-outline-danger btn-sm status-update" data-status="Rejected">Reject</button>
                                             </td>
                                          </tr>
                                          <?php } ?>
                                       </tbody>
                                    </table>
                                 </li>
                           <?php $num++; }
                           }else{ ?>
                              <li class="no-data">Data not available!</li> 
                           <?php } 
                              if($num){ ?>
                                 <!-- <td class="leave-data lave-btn">
                                    <button data-id="<?php // echo $leave_list['id'][$k] ?>" data-index_id="" class="btn sec-btn  sec-btn-outline btn-sm status-update" data-status="Approved">Approve</button>
                                    <button data-id="<?php // echo $leave_list['id'][$k] ?>" data-index_id="" class="btn btn-outline-danger btn-sm status-update" data-status="Rejected">Reject</button>
                                 </td> -->
                              <?php } ?>
                           <input type="hidden" id="data_Leavecount" value="<?=$num?>">
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
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
                                       <?php if(isset($holiday_all) && !empty($holiday_all)){ foreach ($holiday_all as $d) {
                                          $b_date = date('Y-m-d', strtotime($d->holiday_date));
                                          if ($b_date >= date('Y-m-d') && $b_date <= date("Y-m-d", strtotime(" +1 months"))) { ?>
                                             <tr>
                                                <td class="leave-data date"><?php echo dateFormat($d->holiday_date); ?></td>
                                                <td class="leave-data date"><?php echo $d->title; ?></td>
                                             </tr>
                                       <?php }
                                       }  }else{ ?>
                                          <li class="no-data">Data not available!</li> 
                                       <?php } ?>
                                       <input type="hidden" id="data_Holidaycount" value="<?=$num?>">
                                    </tbody>
                                 </table>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            <?php } ?>
         </div>

         <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
            <div class="panel">
               <div class="sk-chat-widgets">
                  <div class="panel panel-default dashboard-panel">
                     <div class="panel-heading">
                        <span class="panel-heading-title">Late Employees</span>
                        <span class="tag tag-primary" id="late_count"></span>
                        <button type="button" class="panel-btn">
                           <span></span>
                           <span></span>
                        </button>
                     </div>
                     <div class="panel-body" style="display: block;">
                        <ul class="chatonline">
                           <?php
                           $time = strtotime("09:15 AM");
                           $num = 0;
                           if (!empty($get_employee_attedance)) {
                              $keys = array_column($get_employee_attedance, 'employee_in');
                              array_multisort($keys, SORT_DESC, $get_employee_attedance);
                              foreach ($get_employee_attedance as $emp) {
                                 $inTime = date('h:i A', strtotime($emp->employee_in));
                                 if (strtotime($inTime) > $time) {

                                    $img2 = $_SERVER['DOCUMENT_ROOT'] . "/assets/profile_image32x32/" . $emp->profile_image;
                                    if ($emp->profile_image != "") {
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
                                    } ?>
                                    <li>
                                       <a href="<?= base_url() ?>/employee/employee_attendance_list/<?= $emp->employee_id ?>"><img src="<?php echo $img; ?>" alt="user-img" class="img-circle"> <span><?php echo $emp->fname . " " . $emp->lname; ?> <small class="text-primary"><?= date('h:i A', strtotime($emp->employee_in)) ?></small></span></a>
                                       <!-- <div class="call-chat">
                           <button class="btn btn-success btn-circle btn-lg" type="button"><i class="fa fa-phone"></i></button>
                           <button class="btn btn-info btn-circle btn-lg" type="button"><i class="fa fa-comments-o"></i></button>
                           </div> -->
                                    </li>
                           <?php $num++; }else{ 
                           }
                              }
                           } if($num == 0){ ?>
                              <li class="no-data">Data not available!</li> 
                           <?php } ?>
                           <input type="hidden" id="data_Latecount" value="<?=$num?>">
                        </ul>
                     </div>
                  </div>
               </div>
            </div>

            <div class="panel pc-issue-admin">
               <div class="sk-chat-widgets">
                  <div class="panel panel-default dashboard-panel">
                     <div class="panel-heading">
                        <span class="panel-heading-title">PC Issue</span>
                        <span class="tag tag-primary" id="issue_count"></span>
                        <button type="button" class="panel-btn">
                           <span></span>
                           <span></span>
                        </button>
                     </div>
                     <div class="panel-body" style="display: block;">
                     
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                           <li class="nav-item active">
                              <a class="nav-link active" id="pc-issue-new-tab" data-toggle="tab" href="#pc-issue-new" role="tab" aria-controls="pc-issue-new" aria-selected="true">New</a>  
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" id="pc-issue-pending-tab"  data-toggle="tab" href="#pc-issue-pending" role="tab" aria-controls="pc-issue-pending" aria-selected="true">Pending</a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" id="pc-issue-inprog-tab" data-toggle="tab" href="#pc-issue-inprog" role="tab" aria-controls="pc-issue-inprog" aria-selected="true">Inprogress</a>
                           </li>
                        </ul>
                        <div class="tab-content myTabContent1" id="myTabContent">
                           <div id="pc-issue-new" class="tab-pane fade show active" role="tabpanel" aria-labelledby="pc-issue-new-tab"> 
                              <div class="chatonline">
                                 <ul>
                                    <?php $num = 0; if(isset($new_pc_issue) && !empty($new_pc_issue)){ ?>
                                    <li class="dropdown leave-dropdown-list open">
                                       <table class="leave-request-status dropdown-menu" role="leave_list" aria-labelledby="leave_list">
                                          <thead>
                                             <tr>
                                                <td class="leave-title">PC Id</td>
                                                <td class="leave-title">Issue</td>
                                                <td class="leave-title">Description</td>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php $i = 1; foreach($new_pc_issue as $Key => $new_issue) {
                                                $new_issue_html = '';
                                                if (isset($new_issue->issue) && $new_issue->issue == 'software') {
                                                   $screenshort = explode(',', $new_issue->screenshorts);
                                                   foreach ($screenshort as $k => $v) {
                                                      $new_issue_html .= '<div class="issue-img-box"><a href="' . base_url().'assets/upload/issue_ss/' . $v . '" data-fancybox="new_issue_image_group'.($i+1).'"><img src="' . base_url().'assets/upload/issue_ss/' . $v . '" alt="issue Image"></a></div>';
                                                   }
                                                } else {
                                                   $new_issue_html = '';
                                                }
                                             ?>
                                                <tr>
                                                   <td class="leave-data date"><?php echo $new_issue->pc_id; ?></td>
                                                   <td class="leave-data date"><?php echo ucwords($new_issue->issue); ?></td>
                                                   <td class="leave-data date"><button type="button" onclick="view_description($(this));" data-id="ss_new_issue_<?php echo $Key; ?>" class="btn btn-sm sec-btn  sec-btn-outline view_description" data-description="<?php echo ucwords($new_issue->description); ?>">Description</button><span class="d-none ss_new_issue_<?php echo $Key; ?>"><div class="pc-issue-img-wrap"><?php echo $new_issue_html; ?></div></span></td>
                                                </tr>
                                             <?php $i++; $num++; } ?>
                                          </tbody>
                                       </table>
                                    </li>
                                    <?php }else{ ?>
                                       <li class="no-data">Data not available!</li> 
                                    <?php } ?>
                                 </ul>
                              </div>
                           </div>
                           <div id="pc-issue-pending" class="tab-pane fade show" role="tabpanel" aria-labelledby="pc-issue-pending-tab">
                              <div class="chatonline">
                                 <ul>
                                    <?php if(isset($pending_pc_issue) && !empty($pending_pc_issue)){ ?>
                                    <li class="dropdown leave-dropdown-list open">
                                       <table class="leave-request-status dropdown-menu" role="leave_list" aria-labelledby="leave_list">
                                          <thead>
                                             <tr>
                                                <td class="leave-title">PC Id</td>
                                                <td class="leave-title">Issue</td>
                                                <td class="leave-title">Description</td>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php $i=1; foreach ($pending_pc_issue as $Key => $pending) {
                                                $pending_html = '';
                                                if (isset($pending->issue) && $pending->issue == 'software') {
                                                   $screenshort = explode(',', $pending->screenshorts);
                                                   foreach ($screenshort as $k => $v) {
                                                      $pending_html .= '<div class="issue-img-box"><a href="' . base_url().'assets/upload/issue_ss/' . $v . '" data-fancybox="pending_issue_image_group'.($i+1).'" ><img src="' . base_url().'assets/upload/issue_ss/' . $v . '" alt="issue Image"></a></div>';
                                                   }
                                                } else {
                                                   $pending_html = '';
                                                }
                                             ?>
                                                <tr>
                                                   <td class="leave-data date"><?php echo $pending->pc_id; ?></td>
                                                   <td class="leave-data date"><?php echo ucwords($pending->issue); ?></td>
                                                   <td class="leave-data date"><button type="button" onclick="view_description($(this));" data-id="ss_pending_<?php echo $Key; ?>" class="btn btn-sm sec-btn  sec-btn-outline view_description" data-description="<?php echo ucwords($pending->description); ?>">Description</button><span class="d-none ss_pending_<?php echo $Key; ?>"><div class="pc-issue-img-wrap"><?php echo $pending_html; ?></div></span></td>
                                                </tr>
                                             <?php $i++; $num++; } ?>
                                          </tbody>
                                       </table>
                                    </li>
                                    <?php }else{ ?>
                                       <li class="no-data">Data not available!</li>
                                    <?php } ?>
                                 </ul>
                              </div>
                           </div>
                           <div id="pc-issue-inprog" class="tab-pane fade show" role="tabpanel" aria-labelledby="pc-issue-inprog-tab">
                              <div class="chatonline">
                                 <ul>
                                    <?php if(isset($inprogress_pc_issue) && !empty($inprogress_pc_issue)){ ?>
                                    <li class="dropdown leave-dropdown-list open">
                                       <table class="leave-request-status dropdown-menu" role="leave_list" aria-labelledby="leave_list">
                                          <thead>
                                             <tr>
                                                <td class="leave-title">PC Id</td>
                                                <td class="leave-title">Issue</td>
                                                <td class="leave-title">Description</td>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php $i = 1; foreach ($inprogress_pc_issue as $Key => $inprogress_issue) {
                                                $inprogress_html = '';
                                                if (isset($inprogress_issue->issue) && $inprogress_issue->issue == 'software') {
                                                   $screenshort = explode(',', $inprogress_issue->screenshorts);
                                                   foreach ($screenshort as $k => $v) {
                                                      $inprogress_html .= '<div class="issue-img-box"><a href="' . base_url('assets/upload/issue_ss/') . $v . '" data-fancybox="inprogress_issue_image_group'.($i+1).'"><img src="' . base_url('assets/upload/issue_ss/') . $v . '" alt="issue Image"></a></div>';
                                                   }
                                                } else {
                                                   $inprogress_html = '';
                                                }
                                             ?>
                                                <tr>
                                                   <td class="leave-data date"><?php echo $inprogress_issue->pc_id; ?></td>
                                                   <td class="leave-data date"><?php echo ucwords($inprogress_issue->issue); ?></td>
                                                   <td class="leave-data date"><button type="button" href="javascript:void(0)" onclick="view_description($(this));" data-id="ss_inprogress_html_<?php echo $Key; ?>" class="btn btn-sm sec-btn  sec-btn-outline view_description" data-description="<?php echo ucwords($inprogress_issue->description); ?>">Description</button><span class="d-none ss_inprogress_html_<?php echo $Key; ?>"><div class="pc-issue-img-wrap"><?php echo $inprogress_html; ?></div></span></td>
                                                </tr>
                                             <?php $i++; $num++; } ?>
                                          </tbody>
                                       </table>
                                    </li>
                                    <?php }else{ ?>
                                       <li class="no-data">Data not available!</li> 
                                    <?php } ?>
                                    <input type="hidden" id="data_Issuecount" value="<?=$num?>">
                                 </ul>
                              </div>
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
                           <?php $num++; } } }
                           if($num == 0){
                              echo '<li class="no-data">Data not available!</li> ';
                           } ?>
                           <input type="hidden" id="data_Broadcast" value="<?php echo $num?>">
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <?php } ?>
            <?php $num = 0;
            foreach ($holiday_all as $d) {
               $b_date = date('Y-m-d', strtotime($d->holiday_date));
               if ($b_date >= date('Y-m-d') && $b_date <= date("Y-m-d", strtotime(" +1 months"))) {
                  $num++;
               }
            } ?>
            <?php if ($num > 0) { ?>
               <!-- <div class="panel active">
                  <div class="sk-chat-widgets">
                     <div class="panel panel-default dashboard-panel active">
                        <div class="panel-heading">
                           <span class="panel-heading-title">Upcoming Holiday</span>
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
                                          <td class="leave-title">Holiday Date</td>
                                          <td class="leave-title">Holiday Name</td>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php if(isset($holiday_all) && !empty($holiday_all)){ foreach ($holiday_all as $d) {
                                          $b_date = date('Y-m-d', strtotime($d->holiday_date));
                                          if ($b_date >= date('Y-m-d') && $b_date <= date("Y-m-d", strtotime(" +1 months"))) { ?>
                                             <tr>
                                                <td class="leave-data date"><?php echo dateFormat($d->holiday_date); ?></td>
                                                <td class="leave-data date"><?php echo $d->title; ?></td>
                                             </tr>
                                       <?php }
                                       }  }else{ ?>
                                          <li class="no-data">Data not available!</li> 
                                       <?php } ?>
                                       <input type="hidden" id="data_Holidaycount" value="<?=$num?>">
                                    </tbody>
                                 </table>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div> -->
            <?php } ?>
         </div>
      </div>
   </div>

   <div class="modal" id="view_description" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
               <div class="modal_header-content">
                  <h4 class="modal-title emp_name employee_name">PC Issue Description</h4>
               </div>
            </div>
            <div class="modal-body">
               
            <p id='full_description'></p>
               <div id="ss"></div>
               
            </div>
         </div>
      </div>
   </div>

   <div class="modal modal-issue-img" id="myModal" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered">
         <div class="modal-content">
            <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <img src="" id="view_ss_image" alt="">
         </div>
      </div>
   </div>
<script>
   $(document).ready(function(){
      var data_count = $('#data_count').val();
      $('#increment_count').text(data_count);
      var data_Birthcount = $('#data_Birthcount').val();
      $('#upcomingBirthday_count').text(data_Birthcount);
      var data_Todaycount = $('#data_Todaycount').val();
      $('#todayBirth_count').text(data_Todaycount);
      var data_Interviewcount = $('#data_Interviewcount').val();
      $('#interview_count').text(data_Interviewcount);
      var data_Absentcount = $('#data_Absentcount').val();
      $('#absent_count').text(data_Absentcount);
      var data_Leavecount = $('#data_Leavecount').val();
      $('#leave_count').text(data_Leavecount);
      var data_Broadcast = $('#data_Broadcast').val();
      $('#broadcast_count').text(data_Broadcast);
      var data_Holidaycount = $('#data_Holidaycount').val();
      $('#holiday_count').text(data_Holidaycount);
      var data_Latecount = $('#data_Latecount').val();
      $('#late_count').text(data_Latecount);
      var data_Issuecount = $('#data_Issuecount').val();
      (data_Issuecount == 0)?$('#myTab').hide():$('#myTab').show();
      $('#issue_count').text(data_Issuecount);
      
   });
   $('a.nav-link').click(function(){
      $('span.mb-custom-tab-active').text($(this).text());
      var id = $(this).attr('aria-controls');
      $('.tab-pane.fade').removeClass('show active');
      $('a').removeClass('active');
      $(this).addClass('active');
      var $this = $(this).text();
      $.each($('a.nav-link'),function(){
         if($(this).text() == $this){
            $(this).addClass('active');
            $(this).parent().addClass('active');
         }
      });
      $(this).parent().removeClass('active');
      $('#'+id).addClass('show');
   });
   
      function view_description($this) {
         $('#ss').html('');
         $('#full_description').text('');

         var description = $this.data('description');
         var ss = $('.' + $this.data('id')).html();

         $('#ss').html(ss);
         $('#full_description').text(description);
         $('#view_description').modal('show');
      }
   function goTOList($this){
      var base_url = $('#js_data').data('base-url');
      var candidates_id = $this.data('candidates_id');
      setCookie('candidates_id', candidates_id, 1)
      window.location.href = base_url+'candidates';
   }
</script>