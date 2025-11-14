<?php 
   $user_role=$this->session->get('user_role');
   $user_session=$this->session->get('id');
?>
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-12 col-md-12 col-xs-12">
         <div class="grid-title">
            <h4 class="page-title text-center" id="title"><?php if($user_role == 'admin'){ ?>List Employees Attendance<?php }else{ ?>List Attendance<?php }?></h4>
            <span class="time-box time-minus m-0" id="timeCounter" data-time="08:45:00">
               <i class="fa fa-minus" aria-hidden="true"></i>
               &nbsp;&nbsp;07:20
            </span>
         </div>
         <!-- <div class="page-title-btn">
            <?php if($user_role == 'admin'){ ?>
            <a href="<?php echo base_url('employee'); ?>" class="btn sec-btn back-btn">
            	<i class="fas fa-chevron-left"></i>
            	<span>Back</span>
                        </a>
            <?php }else{ ?>
            <a href="<?php echo base_url('profile'); ?>" class="btn sec-btn back-btn">
            	<i class="fas fa-chevron-left"></i>
            	<span>Back</span>
                        </a>
            <?php } ?>
            </div> -->
         <!-- <div class="col-sm-4">
            <?php if($user_role == 'admin'){ ?>
                      <ol class="breadcrumb">
                          <li><a href="<?php echo base_url('employee'); ?>">Employee</a></li>
                          <li class="active">List Employees Attendance</li>
                      </ol>
            	<?php }else{ ?>
            	<ol class="breadcrumb">
                          <li class="active">List Attendance</li>
                      </ol>
            	<?php } ?>
                  </div> -->
         <!-- /.col-lg-12 -->
      </div>
   </div>
   <!--  from to and dropdown search  -->
   <div class="row">
      <?php   
         function seconds($seconds) {
             // CONVERT TO HH:MM:SS
             $hours = floor($seconds/3600);
             $remainder_1 = ($seconds % 3600);
             $minutes = floor($remainder_1 / 60);
             $seconds = ($remainder_1 % 60);
             if(strlen($hours) == 1) {
                 $hours = "0".$hours;
             }
             if(strlen($minutes) == 1) {
                 $minutes = "0".$minutes;
             }
             if(strlen($seconds) == 1) {
                 $seconds = "0".$seconds;
             }
             return $hours.":".$minutes."";
         }
         
             $in=array_filter(explode(',',$employee_attendance_list[0]->employee_attendance_in));
             $out=array_filter(explode(',',$employee_attendance_list[0]->employee_attendance_out));
             $attendance_type=array_filter(explode(',',$employee_attendance_list[0]->employee_attendance_type));
             $arr = $att_date =array();
         
         $out_date_arr = $out_date_arr1 = array();
         if($employee_attendance_list[0]->employee_attendance_in){
         $j=0;
         $out=array_filter(explode(',',$employee_attendance_list[0]->employee_attendance_out));
         
         if(!empty($out)){
          foreach($out as $o_date => $o){
         	 
         	 if (DateTime::createFromFormat('Y-m-d H:i:s', $o) !== FALSE) {
         		 $dateout1=date_create($o);
         		 $out_date1= date_format($dateout1,"Y-m-d");
         		 $out_date_arr[$out_date1][]=$o;
         		 $out_date_arr1[]=$out_date1;
         	 }
         	  //$out_date_arr1[]=$o;
         	 
          }
         }
         $date2Timestamp=0;
         $a=array_unique($out_date_arr1);
                  if(!empty($in)){
                     foreach ($in as $k => $v) {
                         $datein=date_create($v);
                         $in_date= date_format($datein,"Y-m-d");
         	//echo $k;
         	 $arr[$in_date]['in'][]= $newDateTime = date('h:i A', strtotime($v));
         	   if(isset($attendance_type[$k])){
                                 if($attendance_type[$k] == "full_day"){
                                     $day_name="Full Day";
                                 }else{
                                     $day_name="Half Day";
                                 }
                             }
                             $arr[$in_date]['attendance_types'][0]=$day_name;
         	$date_key=array_keys($out_date_arr);
         	if(in_array($in_date,$a)){
         		
         		 $date1Timestamp = strtotime($v);
         	if(isset($out_date_arr[$in_date])){
         		if(isset($out_date_arr[$in_date][0])){
         			 $arr[$in_date]['out'][0]= date('h:i A', strtotime($out_date_arr[$in_date][0])); 
         			  $date2Timestamp = strtotime($arr[$in_date]['out'][0]);
         			   $seconds1=  $date2Timestamp - $date1Timestamp;
         			    $arr[$in_date]['seconds'][]=0;
         		}
         		if(isset($out_date_arr[$in_date][1])){
         			 $arr[$in_date]['out'][1]=date('h:i A', strtotime($out_date_arr[$in_date][1]));
         				$date2Timestamp = strtotime($arr[$in_date]['out'][1]);
         			    $seconds1=  $date2Timestamp - $date1Timestamp;
         			    $arr[$in_date]['seconds'][]=0;
         		}
         		
         	}
         	$att_date[]=$in_date;
         	 
         	}
         }
         } 
         }
         $all_time=array();
         if(!empty($arr)){
         $in_time = $out_time = $in_time1 = $out_time1 = $daliy_time = $plus_total_time = $minus_total_time = 0;
         $full_second=28800; $half_second=16200; $total_time=0;
         /* if(strtotime(date('Y-m-d') < strtotime(date('Y-m-d','2020-11-20')))){
         echo "if";
         }else{
         echo "else";
         } */
         foreach($arr as $m => $time_count){
         if(trim($time_count['attendance_types'][0]) == 'Half Day'){
         $full_second=16200;
         }else{
         $full_second=28800;
         }
         $seconds_count=0; 
         if(isset($time_count['in'][0]) && isset($time_count['out'][0])){
         if(!empty($time_count['in'][0]) && !empty($time_count['out'][0])){
         	$in_time = strtotime($time_count['in'][0]);
         	$out_time = strtotime($time_count['out'][0]);
         	$seconds_count=  $out_time - $in_time;
         }
         }
         $seconds_count1=0;
         if(isset($time_count['in'][1]) && isset($time_count['out'][1])){
         if(!empty($time_count['in'][1]) && !empty($time_count['out'][1])){
         	$in_time1 = strtotime($time_count['in'][1]);
         	$out_time1 = strtotime($time_count['out'][1]);
         	$seconds_count1=  $out_time1 - $in_time1;
         }
         }
         $minus_time = $plus_time = 0;
         $daliy_time = $seconds_count + $seconds_count1;
         if($daliy_time != 0){
         	$weekDay = date('w', strtotime($m));
         	//echo "Week Days".$m." - ".$weekDay."<br/>";
         	if($weekDay == 6){
         		if($half_second <= $daliy_time){
         			$plus_time=$daliy_time - $half_second;
         			$plus_total_time+=$plus_time;
         		}else{
         			$minus_time=$half_second - $daliy_time;
         			$minus_total_time+=$minus_time;
         		}
         	}else{
         		if($full_second <= $daliy_time){
         			$plus_time=$daliy_time - $full_second;
         			$plus_total_time+=$plus_time;
         		}else{
         			$minus_time=$full_second - $daliy_time;
         			$minus_total_time+=$minus_time;
         		}
         		
         	}
         }
         if($plus_time != 0){
         	$all_time[$m]['plus_time']=seconds($plus_time);
         }
         if($minus_time != 0){
         	$all_time[$m]['minus_time']=seconds($minus_time);
         }
         }
         //die;
         /* echo $total_time;
         echo "<pre>"; print_r($arr); 
         print_r($all_time);
         echo "</pre>"; */
         }
             /* if($employee_attendance_list[0]->employee_attendance_in){
                 
                 $i=0;
                 if(!empty($in)){
                     foreach ($in as $k => $v) {
                         $datein=date_create($v);
                         $in_date= date_format($datein,"Y-m-d");
                         $dateout=date_create(isset($out[$k]) ? $out[$k] : "");
                         $out_date= date_format($dateout,"Y-m-d");
                         if($in_date == $out_date){
         
                             $arr[$in_date]['in'][]=$newDateTime = date('h:i A', strtotime($v));
                             $arr[$in_date]['out'][]=isset($out[$k]) ? date('h:i A', strtotime($out[$k])) : "";
                             $day_name="Full Day";
                             if(isset($attendance_type[$k])){
                                 if($attendance_type[$k] == "full_day"){
                                     $day_name="Full Day";
                                 }else{
                                     $day_name="Half Day";
                                 }
                             }
                             $arr[$in_date]['attendance_types'][]=$day_name;
         
                             $date1Timestamp = strtotime($v);
                             $date2Timestamp = strtotime(isset($out[$k]) ? $out[$k] : "");
                             $seconds1=(isset($out[$k]) && !empty($out[$k])) ?  $date2Timestamp - $date1Timestamp : "0";
                             $arr[$in_date]['seconds'][]=$seconds1;
                             $att_date[]=$in_date;
                             $i++;
                         }
                     }
                 }
             } */
         //echo "<pre>";
         //print_r($out);
         //print_r($a);
         //print_r($arr);
         //echo "</pre>";
         //die;
         //die(); 
           // echo "<pre>";print_r($in);print_r($arr);echo "</pre>";
         ?>
      <?php 
         //echo "<pre>"; print_r($krsort); echo "</pre>";
         $c_date=date('Y-m-d');
         ?>
      <div class="col-md-12">
         <div class="white-box m-0">
            <div class="custom-emp-part">
               <div class="attendance_report">
                  <div class="row">
                     <div class="col-lg-5 col-12 text-center text-lg-left">
                        <?php if(isset($get_employee) && !empty($get_employee)){ ?>
                        <h4 class="h4_name">Name : <?php echo $get_employee[0]->fname." ".$get_employee[0]->lname; ?> ( <?php echo $get_employee[0]->name; ?>)</h4>
                        <?php } ?>
                     </div>
                     <div class="col-lg-3 col-12 report text-center p-0" id="total_time1">
                        <?php if(!empty($all_time)){ 	
                           ?>
                        <span class="time-minus " id="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp; <?php echo seconds($minus_total_time);  ?></span>
                        <span class="time-plus " id="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo seconds($plus_total_time); ?></span>
                        <?php 
                           } ?>	
                     </div>
                     <div class="col-lg-4 col-12 text-center text-lg-right">
                        <?php if($user_role == "admin"){ ?>
                        <a class="btn sec-btn add_attendance add_attendance1" href="<?php echo base_url('employee/employee_attendance/'.$id.'/'.$c_date); ?>">Add Attendance</a>
                        <?php }else{ ?>
                        <button type="button" class="btn sec-btn btn-open-desig">Add Attendance</button>
                        <!-- <a class="btn sec-btn add_attendance" href="<?php // echo base_url('profile/add_employee_attendance'); ?>">Add Attendance</a> -->
                        <?php } ?>
                     </div>
                  </div>
               </div>
            </div>
            <hr class="custom-hr">
            <div class="emp-custom-field">
               <?php 
                  /* echo "<pre>";
                  	print_r($get_employee_list);
                  echo "</pre>"; */
                  if(!empty($search)){
                  	$current_year=$search['year']; 
                  	$current_month=$search['month'];
                  }else{
                  	$current_year=date('Y'); 
                  	$current_month=date('n');
                  } ?>
               <form class="frm-search" method="post" action="<?php echo base_url('employee/employee_attendance_list'); if(isset($search['employee']) && !empty($search['employee'])){ echo '/'.$search['employee']; } ?>" id="search-form">
                  <div class="_form-search-form">
                     <div class="row">
                        <div class="col-xl-8 col-12 text-center text-xl-left">
                           <?php if($user_role == "admin"){ ?>
                           <div class="single-field select-field multi-field _search-form">
                              <select id="employee" name="employee" >
                                 <option value="">Employee</option>
                                 <?php foreach($get_employee_list as $key => $val){ ?>
                                 <option <?php if(isset($search['employee']) && $search['employee'] == $val->id) { echo "selected='selected'"; }else{ if($id == $val->id){ echo "selected='selected'"; } } ?> value="<?php echo $val->id; ?>"><?php echo $val->fname." ".$val->lname; ?></option>
                                 <?php } ?>
                              </select>
                              <label>Employee:</label>
                           </div>
                           <?php }else{ ?>
                           <input type="hidden" name="employee" id="employee" value="<?php echo $user_session; ?>">
                           <?php } ?>
                           <div class="single-field select-field multi-field _search-form">
                              <select id="month" name="month" >
                                 <option value="" disabled>Month</option>
                                 <?php foreach(MONTH_NAME as $k => $v){ ?>
                                 <option <?php if(isset($search['month']) && $search['month'] == $k+1) { echo "selected='selected'"; }else { if($current_month == $k+1){ echo "selected='selected'"; } }?> value="<?php echo $k+1; ?>"><?php echo $v; ?></option>
                                 <?php } ?>
                              </select>
                              <label>Select Month</label>
                           </div>
                           <div class="single-field select-field multi-field _search-form">
                              <select id="year" name="year" >
                                 <option value="" disabled>Select Year</option>
                                 <?php
                                    $next_year=date('Y',strtotime('+1 year'));
                                    for($i=2018;$i<=$next_year;$i++){?>
                                 <option   <?php if(isset($search['year']) && $search['year'] == $i) { echo "selected='selected'"; } else{ if($current_year == $i){ echo "selected='selected'"; } }?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                 <?php } ?>
                              </select>
                              <label>Select Year</label>
                           </div>
                        </div>
                        <div class="col-xl-4 col-12 text-center text-xl-right">
                           <input type="hidden" name="change_id" id="change_id" value="<?php echo $id; ?>">
                           <input type="hidden" name="search_dropdwon" id="search_dropdwon" value="1">
                           <div class=" _search-form form_submit">
                              <div class="emp_">
                                 <!-- <div class="emp_submit">
                                    <input type="button" placeholder="To Date" class="btn sec-btn emp_search" id="attendance_search"  value="Search">
                                    </div> -->
                                 <div class="emp_submit">
                                    <input type="reset" style="display: none;" class="btn btn-danger emp_reset1"  value="Reset">
                                    <input type="button" class="btn btn-danger emp_reset"  value="Reset">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
            <!-- <div class="row mt-4" id="total_time1"></div> -->
            <hr class="custom-hr">
            <div class="table-responsive employee-table-list">
               <?php 
                  $list=array();
                  $month = $current_month;
                  $year = $current_year;
                  for($d=1; $d<=31; $d++)
                  {
                  $time=mktime(12, 0, 0, $month, $d, $year);          
                  if (date('m', $time)==$month)       
                  $list[]=date('Y-m-d', $time);
                  //$list[]=date('Y-m-d-D', $time);
                  }
                  $holiday=array();
                  if($holiday_date){
                  foreach($holiday_date as $holiday_day){
                  $holiday[]=$holiday_day->holiday_date;
                  }
                  }
                  $leave=array();
                  $leave_status=array();
                  if($get_leave_employee){
                  foreach($get_leave_employee as $get_leave){
                  $leave[]=$get_leave->leave_date;
                  $leave_status[$get_leave->leave_date]['status']=$get_leave->status;
                  if($get_leave->leave_status == "none"){
                  $leave_status[$get_leave->leave_date]['leave_status']="absent";
                  }else{
                  $leave_status[$get_leave->leave_date]['leave_status']=$get_leave->leave_status;
                  }
                  
                  }
                  }
                  /* echo "<pre>";
                  //print_r($leave);
                  print_r($all_time);
                  echo "</pre>";  */
                  ?>
               <div class="preloader preloader-2" style="display:none !important;">
                  <svg class="circular" viewBox="25 25 50 50">
                     <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                  </svg>
               </div>
               <table class="table  display nowrap " id="example" style="width:100%">
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
                        <th>Work Updates</th>
                     </tr>
                  </thead>
                  <tbody>
                     <!--official-leave-color,paid-leave-color,approve-leave-color,unapprove-leave-color,sick-leave-color,absent-leave-color-->
                     <?php $i=1;
                        $indate1 = $indate2 = $outdate1 = $outdate2 = 0;
                         $seconds1 = $seconds2 ="0";
                        
                        foreach($list as $key => $val){ ?>
                     <?php  		 $attendance_types ="";	
                        $class_tr="";
                        $update_class="";
                        if(in_array($val,$leave)){
                        	if($leave_status[$val]['status'] == "approved"){
                        		if($leave_status[$val]['leave_status'] == "paid"){
                        			$attendance_types=ucwords($leave_status[$val]['leave_status'])." Leave";
                        			$class_tr="paid-leave-color";
                        		}else if($leave_status[$val]['leave_status'] == "sick"){
                        			$attendance_types=ucwords($leave_status[$val]['leave_status'])." Leave";
                        			$class_tr="sick-leave-color";
                        		}else{
                        			$attendance_types=ucwords($leave_status[$val]['leave_status'])." Leave";
                        			$class_tr="absent-leave-color";
                        		}
                        	}else if($leave_status[$val]['status'] == "rejected"){
                        		$attendance_types=ucwords($leave_status[$val]['leave_status'])." Leave";
                        		$class_tr="unapprove-leave-color";
                        	}else{
                        		$attendance_types=ucwords($leave_status[$val]['leave_status'])." Leave";
                        		$class_tr="absent-leave-color";
                        	}
                        }
                        if(in_array($val,$holiday)){
                        	$attendance_types="Holiday";
                        	$class_tr="official-leave-color";
                        }
                        if(date('N', strtotime($val)) == 7){
                        	$attendance_types="Sunday";
                        	$class_tr="sunday-leave-color";
                        }
                        $in = $in1 = $out = $out1 = $seconds = $total_time = "";
                        
                        if(isset($arr[$val]) && !empty($arr[$val])){
                        		//echo "<pre>";
                        		//print_r($arr[$val]);
                        		if(isset($arr[$val]['in'][0])){
                        			$in=$arr[$val]['in'][0];
                        			
                        			$indate1 = strtotime($arr[$val]['in'][0]);
                        		}else{
                        			$indate1=0;
                        		}
                        		
                        		if(isset($arr[$val]['out'][0])){
                        			$out=$arr[$val]['out'][0];
                        		
                        			$outdate1 = strtotime($arr[$val]['out'][0]);
                        		}else{
                        			$outdate1=0;
                        		}
                        		if(isset($arr[$val]['in'][1])){
                        			$in1=$arr[$val]['in'][1];
                        			
                        			$indate2 = strtotime($arr[$val]['in'][1]);
                        		}else{
                        			$indate2=0;
                        		}
                        		if(isset($arr[$val]['out'][1])){
                        			$out1=$arr[$val]['out'][1];
                        			
                        			$outdate2 = strtotime($arr[$val]['out'][1]);
                        		}else{
                        			$outdate2=0;
                        		}
                        		if($outdate2 != 0 && $indate2 != 0){
                        			$seconds3=  $outdate2 - $indate2;
                        		}else{
                        			$seconds3 =0;
                        		}
                        		
                        		
                        		if($outdate1 != 0 && $indate1 != 0){
                        			$seconds4=  $outdate1 - $indate1;
                        		}else{
                        			$seconds4 =0;
                        		}
                        		
                        		$seconds = $seconds3 + $seconds4;
                        		$total_time=seconds($seconds);
                        		$attendance_types=$arr[$val]['attendance_types'][0];
                        		
                        		if($attendance_types == "Half Day"){
                        			$class_tr="halfday-leave-color";
                        		}else{
                        			$class_tr="";
                        		}
                        		if($user_role == "admin" && ($attendance_types  == 'Half Day' || $attendance_types  == 'Full Day')) { 
                        			$update_class="field-edit";
                        		}
                        }
                        
                        ?>
                     <?php if($user_role == "admin"){ ?> 
                     <tr class="<?php echo $class_tr; ?>">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $val; ?></td>
                        <td class="td_in_time <?php echo $update_class; ?>" data-popup-status="active" data-type="attendance_type" data-attendance-date="<?php echo $val; ?>">
                           <span class="attendance_type_time_<?php echo $val; ?> attendance_type"><?php echo $attendance_types; ?></span>
                           <?php if($user_role == "admin" && ($attendance_types  == 'Half Day' || $attendance_types  == 'Full Day')) { ?>
                           <div class="field-box">
                              <form>
                                 <div class="form-group">
                                    <label>Attendance types</label>
                                    <select class="form-control get_time" name="time" >
                                       <option <?php if($attendance_types  == 'Full Day'){ echo "selected='selected'";} ?> value="full_day">Full Day</option>
                                       <option <?php if($attendance_types  == 'Half Day'){ echo "selected='selected'";} ?>  value="half_day">Half Day</option>
                                    </select>
                                 </div>
                                 <input type="button" value="Update" class="btn sec-btn pull-right update_time" data-type="attendance_type" data-attendance-date="<?php echo $val; ?>">
                                 <input type="button" value="Close" class="btn btn-close close_popup">
                              </form>
                           </div>
                           <?php } ?>
                        </td>
                        <td class="td_in_time <?php echo $update_class; ?>" data-popup-status="active" data-type="in" data-attendance-date="<?php echo $val; ?>">
                           <span class="in_time_<?php echo $val; ?> in"><?php echo $in; ?></span>
                           <?php if($user_role == "admin" && ($attendance_types  == 'Half Day' || $attendance_types  == 'Full Day')) { ?>
                           <div class="field-box">
                              <form>
                                 <div class="form-group">
                                    <label>In (<?php echo $val; ?>)</label>
                                    <input type="time" name="time" required class="form-control get_time" value="<?php if(!empty($in)){ echo date('H:i',strtotime($in)); } ?>">
                                 </div>
                                 <input type="button" value="Update" class="btn sec-btn pull-right update_time" data-type="in" data-attendance-date="<?php echo $val; ?>">
                                 <input type="button" value="Close" class="btn btn-close close_popup">
                              </form>
                           </div>
                           <?php } ?>
                        </td>
                        <td class="td_in_time <?php echo $update_class; ?>" data-popup-status="<?php if(!empty($in)){ echo "active"; } ?>" data-type="out" data-attendance-date="<?php echo $val; ?>">
                           <span class="out_time_<?php echo $val; ?> out"><?php echo $out; ?></span>
                           <?php if($user_role == "admin" && ($attendance_types  == 'Half Day' || $attendance_types  == 'Full Day')) { ?>
                           <div class="field-box">
                              <form>
                                 <div class="form-group">
                                    <label>Out (<?php echo $val; ?>)</label>
                                    <input type="time" name="time" required class="form-control get_time" value="<?php if(!empty($out)){ echo date('H:i',strtotime($out)); } ?>">
                                 </div>
                                 <input type="button" value="Update" class="btn sec-btn pull-right update_time" data-type="out" data-attendance-date="<?php echo $val; ?>">
                                 <input type="button" value="Close" class="btn btn-close close_popup" data-type="out" data-attendance-date="<?php echo $val; ?>">
                              </form>
                           </div>
                           <?php } ?>
                        </td>
                        <td class="td_in_time <?php echo $update_class; ?>" data-popup-status="<?php if(!empty($out)){ echo "active"; } ?>" data-type="in1" data-attendance-date="<?php echo $val; ?>">
                           <span class="in1_time_<?php echo $val; ?> in1"><?php echo $in1; ?></span>
                           <?php if($user_role == "admin" && $attendance_types  == 'Full Day' && date('N', strtotime($val)) != 6) { ?>
                           <div class="field-box">
                              <form>
                                 <div class="form-group">
                                    <label>In (<?php echo $val; ?>)</label>
                                    <input type="time" name="time" required class="form-control get_time"  value="<?php if(!empty($in1)){ echo date('H:i',strtotime($in1)); } ?>">
                                 </div>
                                 <input type="button" value="Update" class="btn sec-btn pull-right update_time" data-type="in1" data-attendance-date="<?php echo $val; ?>">
                                 <input type="button" value="Close" class="btn btn-close close_popup">
                              </form>
                           </div>
                           <?php } ?>
                        </td>
                        <td class="td_in_time <?php echo $update_class; ?>" data-popup-status="<?php if(!empty($in1)){ echo "active"; } ?>" data-type="out1" data-attendance-date="<?php echo $val; ?>">
                           <span class="out1_time_<?php echo $val; ?> out1"><?php echo $out1; ?></span>
                           <?php if($user_role == "admin" && $attendance_types  == 'Full Day' && date('N', strtotime($val)) != 6) { ?>
                           <div class="field-box">
                              <form>
                                 <div class="form-group">
                                    <label>Out (<?php echo $val; ?>)</label>
                                    <input type="time" name="time"required class="form-control get_time" value="<?php if(!empty($out1)){ echo date('H:i',strtotime($out1)); } ?>">
                                 </div>
                                 <input type="button" value="Update" class="btn sec-btn pull-right update_time" data-type="out1" data-attendance-date="<?php echo $val; ?>">
                                 <input type="button" value="Close" class="btn btn-close close_popup">
                              </form>
                           </div>
                           <?php } ?>
                        </td>
                        <td class="total_time_<?php echo $val; ?>"><?php echo $total_time; ?></td>
                        <td class="plus_minus_time_<?php echo $val; ?>"><?php if(!empty($all_time)){ 	
                           if(isset($all_time[$val]['minus_time'])){ ?>
                           <span class="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $all_time[$val]['minus_time'] ?></span>
                           <?php }
                              if(isset($all_time[$val]['plus_time'])){ ?>
                           <span class="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $all_time[$val]['plus_time'] ?></span>
                           <?php }
                              } ?> 
                        </td>
                        <?php if($user_role == "admin"){ ?> 
                        <td>
                           <a data-id="<?php echo $id; ?>" data-date="<?php echo $val; ?>"  class="edit-employee-attendances btn btn-danger waves-effect waves-light" href="<?php echo base_url()."employee/employee_attendance/".$id."/".$val; ?>">Edit</a>
                           <a data-id="<?php echo $id; ?>" data-date="<?php echo $val; ?>"  class="delete-employee-attendances btn btn-danger waves-effect waves-light">Delete</a>
                        </td>
                        <?php } ?>
                     </tr>
                     <?php }else{?>
                     <tr class="<?php echo $class_tr; ?>">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $val; ?></td>
                        <td><?php echo $attendance_types; ?></td>
                        <td class="td_in_time" data-type="in" data-attendance-date="<?php echo $val; ?>"><?php echo $in; ?></td>
                        <td class="td_in_time" data-type="out" data-attendance-date="<?php echo $val; ?>"><?php echo $out; ?></td>
                        <td class="td_in_time" data-type="in1" data-attendance-date="<?php echo $val; ?>"><?php echo $in1; ?></td>
                        <td class="td_in_time" data-type="out1" data-attendance-date="<?php echo $val; ?>"><?php echo $out1; ?></td>
                        <td><?php echo $total_time; ?></td>
                        <td><?php if(!empty($all_time)){ 	
                           if(isset($all_time[$val]['minus_time'])){ ?>
                           <span class="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $all_time[$val]['minus_time'] ?></span>
                           <?php }
                              if(isset($all_time[$val]['plus_time'])){ ?>
                           <span class="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $all_time[$val]['plus_time'] ?></span>
                           <?php }
                              } ?> 
                        </td>
                        <?php if($user_role == "admin"){ ?> 
                        <td>
                           <a data-id="<?php echo $id; ?>" data-date="<?php echo $val; ?>"  class="edit-employee-attendances btn btn-danger waves-effect waves-light" href="<?php echo base_url()."employee/employee_attendance/".$id."/".$val; ?>">Edit</a>
                           <a data-id="<?php echo $id; ?>" data-date="<?php echo $val; ?>"  class="delete-employee-attendances btn btn-danger waves-effect waves-light">Delete</a>
                        </td>
                        <?php } ?>
                     </tr>
                     <?php  } ?>
                     <?php $i++;} ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Add & Update Designation Modal -->
<div class="modal" id="myModal" role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <div class="modal_header">
               <h4 class="modal-title emp_name employee_name">Add Employee Attendance</h4>
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
            <!-- action="<?php echo base_url('profile/insert_employee_attendance'); ?>" -->
            <form class="emp-attendance-form" method="post"  id="employee-form">
               <h4 class="page-title blue-text text-center m-0 text-capitalize"><?php echo date('d F Y'); ?></h4>
               <!-- <hr class="custom-hr"> -->
               <div class="row justify-content-center m-t-30">
                  <div class="col-12 col-sm-12">
                     <div class="form-group">
                        <div class="single-field select-field">
                           <select name="attendance_type" id="attendance_type">
                              <option disabled>--Select Day-- </option>
                              <option  <?php if(isset($get_employee_attendance[0]->attendance_type) && $get_employee_attendance[0]->attendance_type == 'full_day'){ ?> selected <?php } if(!isset($get_employee_attendance[0]->attendance_type)){echo 'selected="selected"';} ?> value="full_day">Full Day</option>
                              <option <?php if(isset($get_employee_attendance[0]->attendance_type) && $get_employee_attendance[0]->attendance_type == 'half_day'){ ?> selected <?php } ?> value="half_day">Half Day</option>
                           </select>
                           <label>Select Day Type</label>
                        </div>
                     </div>
                     <div id="success_message"></div>
                  </div>
               </div>
               <div id="html">      
               <?php $d2=date_create(CURRENT_TIME); 
                  $current_time=date_format($d2,'h:i A'); ?>
               <?php  
                  $i=1;
                  if(isset($get_employee_attendance) && !empty($get_employee_attendance)){
                      $c=count($get_employee_attendance);
                      foreach ($get_employee_attendance as $key => $value) {
                          if($i == 1){ ?>
               <div class="form-group _form">
                  <div class="row justify-content-center align-items-center">
                     <div class="col-4 col-sm-5 ">
                        <label>In *</label>
                     </div>
                     <div class="col-8 col-sm-5 ">
                        <div class="in1_val" data-name="In">
                           <?php 
                              $date_create=date_create($value->employee_in);
                              echo date_format($date_create,'h:i A');
                              ?>
                           <input type="hidden" id="in_time" value="<?php echo date_format($date_create,'h:i A'); ?>" name="">
                        </div>
                     </div>
                  </div>
               </div>
               <?php 
                  $employee_out=$value->employee_out;
                  if($employee_out == "" || $employee_out == "0000-00-00 00:00:00"){  if($c == 1){ ?>
               <div class="form-group _form out_box2">
                  <div class="row justify-content-center align-items-center">
                     <div class="col-4 col-sm-5 ">
                        <label>Out *</label>
                     </div>
                     <div class="col-8 col-sm-5 ">
                        <div class="in1_val">
                           <div class="form-group out_section">
                              <span class="time_in2"><?php echo $current_time; ?></span>
                              <button type="button" class="btn sec-btn submit_form  pull-right" data-attendance="2">ADD</button>
                              <input type='hidden' value="2"  name="employee_in" id="employee_in"  />
                              <input type="hidden" id="out_time" value="<?php echo date_format($d2,'h:i A'); ?>" name="">
                           </div>
                        </div>
                     </div>
                  </div>
                  <span class="span">
                     <?php if(isset($get_employee_attendance[0]->attendance_type) && $get_employee_attendance[0]->attendance_type == 'half_day'){ ?>  
                        <div class="form-group mt-5">
                           <div class="single-field">
                              <textarea class="textarea" name="daily_work" id="daily_work"><?php if(isset($daily_work_list[0])){ echo $daily_work_list[0]->daily_work; } ?></textarea>
                              <label>Daily Update</label>
                           </div>
                        </div>
                        <!-- <textarea name="daily_work" id="daily_work" cols="45" rows="5"><?php if(isset($daily_work_list[0])){ echo $daily_work_list[0]->daily_work; } ?></textarea> -->
                     <?php } ?>  
                  </span>
               </div>
               <?php } }else{ ?>
               <div class="form-group _form" id="employee_out_input">
                  <div class="row justify-content-center align-items-center">
                     <div class="col-4 col-sm-5 ">
                        <label>Out *</label>
                     </div>
                     <div class="col-8 col-sm-5 ">
                        <div class="in1_val" data-name="Out">
                           <?php 
                              $date_create=date_create($value->employee_out);
                              echo date_format($date_create,'h:i A');
                              ?>
                           <input type="hidden" id="out_time" value="<?php echo date_format($date_create,'h:i A'); ?>" name="">
                        </div>
                     </div>
                  </div>
               </div>
               <?php
                  if(isset($daily_work_list[0]->daily_work) && $get_employee_attendance[0]->attendance_type == 'half_day'){ ?>
                      <p id="task_list"><?php if(isset($daily_work_list[0])){ echo $daily_work_list[0]->daily_work; } ?></p>
                      <?php }else{
                  /*if(date('l') != 'Saturday'){*/
                  if($c == 1){ ?>
               <div class="form-group _form hide_in_out form-add-field out_box3" >
                  <div class="row justify-content-center align-items-center">
                     <div class="col-4 col-sm-5 ">
                        <label>IN *</label>
                     </div>
                     <div class="col-8 col-sm-5 ">
                        <div class="in1_val">
                           <div class="form-group out_section">
                              <span class="time_in3"><?php echo $current_time; ?></span>
                              <button type="button" class="btn sec-btn submit_form  pull-right" data-attendance="3">ADD</button>
                              <input type='hidden' value="3" name="employee_in" id="employee_in"  />
                              <input type="hidden" id="in_time1" value="<?php echo date_format($d2,'h:i A'); ?>" name="">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php }
               }
                  } 
                  
                  }
                  if($i == 2){
                  ?>
               <div class="form-group _form">
                  <div class="row justify-content-center align-items-center">
                     <div class="col-4 col-sm-5 ">
                        <label>In*</label>
                     </div>
                     <div class="col-8 col-sm-5 ">
                        <div class="in1_val" data-name="In">
                           <?php 
                              $date_create=date_create($value->employee_in);
                              echo date_format($date_create,'h:i A');
                              ?>
                           <input type="hidden" id="in_time1" value="<?php echo date_format($date_create,'h:i A'); ?>" name="">
                        </div>
                     </div>
                  </div>
               </div>
               <?php 
               if(isset($daily_work_list[0]->daily_work) && $get_employee_attendance[0]->attendance_type == 'half_day'){

               }else{
                  $employee_out1=$value->employee_out;
                  if($employee_out1 == "" || $employee_out1 == "0000-00-00 00:00:00"){ ?>
               <div class="form-group _form out_box4">
                  <div class="row justify-content-center align-items-center">
                     <div class="col-4 col-sm-5 ">
                        <label>Out *</label>
                     </div>
                     <div class="col-8 col-sm-5 ">
                        <div class="in1_val">
                           <div class="form-group out_section">
                              <span class="time_in4"><?php echo $current_time; ?></span>
                              <button type="button" class="btn sec-btn submit_form  pull-right" data-attendance="4">ADD</button>
                              <input type='hidden' value="4"  name="employee_in" id="employee_in"  />
                              <input type="hidden" id="out_time1" value="<?php echo date_format($d2,'h:i A'); ?>" name="">
                           </div>
                        </div>
                     </div>
                  </div>
                  <span class="span">  
                     <?php // if(isset($get_employee_attendance[0]->attendance_type) && $get_employee_attendance[0]->attendance_type == 'full_day'){ ?>  
                        <div class="form-group mt-5">
                           <div class="single-field">
                              <textarea class="textarea" name="daily_work" id="daily_work"><?php if(isset($daily_work_list[0])){ echo $daily_work_list[0]->daily_work; } ?></textarea>
                              <label>Daily Update</label>
                           </div>
                        </div>
                     <?php //} ?>  
                  </span>  
               </div>
               <?php }else{ ?>
               <div class="form-group _form" id="employee_out_input">
                  <div class="row justify-content-center align-items-center">
                     <div class="col-4 col-sm-5 ">
                        <label>Out *</label>
                     </div>
                     <div class="col-8 col-sm-5 ">
                        <div class="in1_val" data-name="Out">
                           <?php 
                              $date_create=date_create($value->employee_out);
                              echo date_format($date_create,'h:i A');
                              ?>
                           <input type="hidden" id="out_time1" value="<?php echo date_format($date_create,'h:i A'); ?>" name="">
                        </div>
                     </div>
                  </div>
               </div>
               <p id="task_list"><?php if(isset($daily_work_list[0])){ echo $daily_work_list[0]->daily_work; } ?></p>
               <!--  <div class="form-group" id="employee_out_input">
                  <label class="">IN *</label>
                  <div class="col-md-6">
                       <?php echo $value->employee_in; ?>
                        </div>
                    </div> -->
               <?php } } }
                  /*}*/
                  ?>     
               <?php $i++; }
                  }else{ ?>
               <div class="form-group _form out_box1">
                  <div class="row justify-content-center align-items-center">
                     <div class="col-4 col-sm-5 ">
                        <label>In *</label>
                     </div>
                     <div class="col-8 col-sm-5 ">
                        <div class="in1_val">
                           <div class="form-group out_section">
                              <span class="time_in1"><?php echo $current_time; ?></span>
                              <button type="button" class="btn sec-btn submit_form  pull-right" data-attendance="1">ADD</button>
                              <input type='hidden' value="1"  name="employee_in" id="employee_in"  />
                              <input type="hidden" id="in_time" value="<?php echo date_format($d2,'h:i A'); ?>" name="">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php }
                  ?>
                  </div>
               <input type="hidden" name="in_out_time" id="in_out_time" value="" data-current-date="<?php echo date('n/j/Y'); ?>">
               <input type="hidden" name="datepicker" id="datepicker" value="<?php echo date('Y-m-d'); ?>" data-current-date="<?php echo date('Y-m-d'); ?>">
               <input type="hidden" name="in_out_time_count" id="in_out_time_count" value="0">
            </form>
            <!-- </div> -->
         </div>
      </div>
   </div>
</div>

<div id="view_work_updates" class="modal employee-model">
	<div class="modal-dialog modal-dialog-centered">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            <div class="modal-header-content">
					<h4 class="modal-title emp_name h5-emp-name"><span id="work_updateDate"></span> Work Updates</h4>
				</div>
			</div>
			<form class="form-horizontal form-material" method="Post" id="edit_employee_attendance-form">
				<div class="modal-body">
	            <div class="row">
						<div class="col-12">
								<div class="whiteSpace-break" id="view_daily_work"></div>
								<!-- <small class="work-info">Note: kindly mention your today completed work <span data-tooltip=" - For example today I have worked on these given tasks (mention tasks name)."><i class="fas fa-eye"></i></span></small> -->
						</div>
	            </div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
   $("#employee").change(function(){
   	var eid=$(this).val();
   	$("#change_id").val(eid);  
    // alert("The text has been changed.");
   });

   
   // $(".emp_search").click(function(e) {
   //     e.preventDefault();
   // 	var base_url = $("#js_data").data("base-url");
   // 	// var id=$("#employee").val();
   // 	var id=$("#change_id").val();
   // 	var url =base_url+"employee/employee_attendance_list/"+id;
   // 	var form = $("#search-form");
   //     form.prop("action", url);
   //     form.submit();
   //  });
</script>