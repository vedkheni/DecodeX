<style>
.time-minus{
	color : red;
}
.time-plus{
	color:green;
}
</style>	
<?php 
		$user_role=$this->session->get('user_role');
		$user_session=$this->session->get('id');
		$leaveType = array('General', 'Festival', 'Engagement', 'Marriage',  'Maternity', 'Family Events', 'Bereavement', 'Sick' );
?>
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row bg-title">

		<!-- <div class="col-sm-4">
                <a href="<?php // echo base_url('employee/employee_attendance_list/'.$id); ?>">
                <i class="fa fa-long-arrow-left" aria-hidden="true" style="font-size:19px"></i>&nbsp;&nbsp;&nbsp;&nbsp;Back
                </a>
        </div> -->
        <div class="col-lg-12 col-md-12 col-xs-12">
			<div class="page-title-btn">
				<?php if($user_role == 'admin'){ ?>
					<a class="btn sec-btn back-btn" href="<?php echo base_url('employee'); ?>">
	                    <i class="fas fa-chevron-left"></i>
		    			<span>Back</span>
	                </a>
					<?php }else{ ?>
					<a class="btn sec-btn back-btn" href="<?php echo base_url('profile'); ?>">
	                    <i class="fas fa-chevron-left"></i>
		    			<span>Back</span>
	                </a>
					<?php } ?>
				<h4 class="page-title text-center" id="title"><?php if($user_role == 'admin'){ ?>List Employees Attendance<?php }else{ ?>List Attendance<?php }?></h4>
			</div>
		</div>
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
        	<!-- <div class="preloader preloader-2 report_preloader1">
				<svg class="circular" viewBox="25 25 50 50">
					<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
				</svg>
			</div> -->
            <div class="white-box m-0">
				
            	<!-- first section start -->

            	<div class="custom-emp-part">
	                <div class="attendance_report">
						<div class="row">
		                	<div class="col-lg-5 col-12 text-center text-lg-left">
		                		<?php if(isset($get_employee) && !empty($get_employee)){ ?>
		                			<h4 class="h4_name"><strong>Name : <?php echo $get_employee[0]->fname." ".$get_employee[0]->lname; ?> ( <?php echo $get_employee[0]->name; ?>)</strong></h4> 
		                		<?php } ?>
		                		<p class="tmp_name" data-emp_id="" style="display: none;"></p>
		                	</div>

							 <div class="col-lg-3 col-12 report text-center p-0" id="total_time1">
								<?php if(!empty($all_time)){ 	
									 ?>
									<span class="time-box time-minus " id="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp; <?php echo seconds($minus_total_time);  ?></span>

									<span class="time-box time-plus " id="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo seconds($plus_total_time); ?></span>
									<?php 
								 } ?>	
							</div> 

							<div class="col-lg-4 col-12 text-center text-lg-right">
								<?php if($user_role == "admin"){ ?>
									
									<!-- <a class="btn sec-btn pull-right add_attendance add_attendance1" href="<?php // echo base_url('employee/employee_attendance/'.$id.'/'.$c_date); ?>">Add Attendance</a> -->
								<?php }else{ ?>
									<a class="btn sec-btn pull-right add_attendance" href="<?php echo base_url('profile/add_employee_attendance'); ?>">Add Attendance</a>
								<?php } ?>
							</div>
		                </div>
	               	</div>
            	</div>
            	<!-- first section End -->

                <hr class="custom-hr">

            	<!-- second section start -->

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
					<div class="emp-custom-field">
                    <form class=" frm-search" method="post" action="<?php echo base_url('employee/employee_attendance_list'); if(isset($search['employee']) && !empty($search['employee'])){ echo '/'.$search['employee']; } ?>" id="search-form">
                    	<div class="row">
                    		<div class="col-xl-8 col-12 text-center text-xl-left">
                    			
                            <!-- <div class="error_msg"></div> -->
							
							<?php if($user_role == "admin"){ ?>
								<div class="single-field select-field multi-field">
									<select  id="employee" name="employee" >
										<option value="" disabled>Select Employee</option>
										<?php foreach ($get_employee_list as $key => $val) { ?>
											<option class="active" <?php if(isset($search['employee']) && $search['employee'] == $val->id) { echo "selected='selected'"; }else{ if($id == $val->id){ echo "selected='selected'"; } } ?> value="<?php echo $val->id; ?>"><?php echo $val->fname . " " . $val->lname; ?></option>
										<?php } ?>
										<option value="" class="disabled d-none" disabled>Deactive Employee</option>
										<?php foreach ($get_deactive_emp as $k => $v) { ?>
											<option class="deactive d-none" disabled <?php if(isset($search['employee']) && $search['employee'] == $v->id) { echo "selected='selected'"; }else{ if($id == $v->id){ echo "selected='selected'"; } } ?> value="<?php echo $v->id; ?>"><?php echo $v->fname . " " . $v->lname; ?> (Deactive)</option>
										<?php } ?>
									</select>
									<label>Select Employee</label>
								</div>
							<?php }else{ ?>
								<input type="hidden" name="employee" id="employee" value="<?php echo $user_session; ?>">
							<?php } ?>
							  
								
								<div class="single-field select-field multi-field">
									<select id="month" name="month" >
										<option value="" disabled>Select Month</option>
										<?php foreach(MONTH_NAME as $k => $v){ ?>
											<option <?php if(isset($search['month']) && $search['month'] == $k+1) { echo "selected='selected'"; }else { if($current_month == $k+1){ echo "selected='selected'"; } }?> value="<?php echo $k+1; ?>"><?php echo $v; ?></option>
										<?php } ?>
									</select>
									<label>Select Month</label>
                                </div>
						
                            <div class="single-field select-field multi-field">
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
							<input type="hidden" name="change_id" id="change_id" value="<?php echo $id; ?>">
							<input type="hidden" name="search_dropdwon" id="search_dropdwon" value="1">

						</div>
                         

                        <div class="col-xl-4 col-12 text-center text-xl-right" >
                            <div class="emp_">
                                <!-- <span class="emp_submit">
                                    <input type="button" placeholder="To Date" class="btn sec-btn emp_search" id="attendance_search"  value="Search">
                                </span> -->
                                <span class="emp_submit">
                                    <input type="reset" style="display: none;" class="emp_reset1"  value="Reset">
                                    <input type="button" class="btn btn-danger emp_reset"  value="Reset">
                                </span> 
                                <span class="emp_submit">
                                    <input type="button" style="display: none;" class="btn sec-btn sec-btn-outline sec-btn add_leave" value="Add Leave">
                                    <input type="button" style="display: none;" class="btn sec-btn sec-btn-outline sec-btn add_leave_modal" value="Add Leave" data-toggle="modal" data-target="#submit_leave">
                                </span>
                                <span class="emp_submit">
                                    <input type="button" style="display: none;" class="btn btn-outline-danger emp_del" id="delete_leave" value="Delete Leave">
                                </span>                           

                            </div>
                        </div>
                    	
                    	<!-- <div class="from_message"></div> -->

                        </div>
                    </form>
                    </div>
                    <!-- <div class="row mt-4" id="total_time1"></div> -->
                	<hr class="custom-hr">
            	<!-- second section start -->



                <div class="table-responsive box-shadow employee-table-list">
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
					<div class="preloader preloader-2" style="display:none"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>
					<table class="table  display nowrap" id="example" style="width:100%">
					<thead>
                            <tr>
                            	<th><input type="checkbox" name="select_All_checkbox" id="select_All_checkbox" value="All_select"></th>
                                <!-- <th>#</th> -->
                                <th>Date</th>
                                <th>Attendance</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Total</th>
								<th>Time</th>
                               <?php if($user_role == "admin"){ ?> <th>Action</th> <?php } ?>
                            </tr>
                    </thead>
					<tbody>

					</tbody>
					</table>
                
                </div>
            </div>
        </div>
    </div>
</div>

<div id="submit_leave" class="modal employee-model">
	<div class="modal-dialog modal-dialog-centered">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
				<div class="modal-header-content">
					<h4 class="h5-emp-name modal-title">Employee : Niranjan Prajapati</h4>
					<h5 class="modal-sub-title">Add Leave Request</h5>
				</div>
			</div>
			
			<div class="row">
				<div class="col-12">
					<!-- <div class="from_message"></div>
					<div class="status_for_error text-center" style="color:red;"></div>
					<div class="leave_status_for_error text-center" style="color:red;"></div> -->
				</div>
			</div>

			<form id="multiple_leave-form">
				<input type="hidden" name="emp_id" id="emp_id" value="">
				<div class="modal-body">
						<div class="row">
							<!-- <div class="col-md-12">
								<h5 class="h5-emp-name">Employee : Niranjan Prajapati</h5>
							</div> -->
							<!-- <div  class="col-md-12">	
								<label>Employee</label>
								<input type="text" name="emp-name" value="Niranjan Prajapati" class="form-control form-control-line" disabled="disabled">
							</div> -->
						<div class="col-12">
							<div class="form-group">
								<div class="single-field">
									<input type="text" class="datepicker-here" value="" data-date-format="dd M, yyyy" id="date_leave" name="leave_date" data-language="en" data-multiple-dates="100" data-multiple-dates-separator=" , ">
									<label>Leave Date*</label>
									<!-- <input type="text" class="datepicker-here form-control form-control-line" data-language="en" name="leave_date" id="leave_date" data-multiple-dates-separator="," data-position="top left" value=""/> -->
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<div class="single-field select-field">
									<select name="leave_status" id="leave_status">
										<option value="" disabled>Leave Type</option>
										<?php foreach($leaveType as $type){ ?>
											<option value="<?php echo $type; ?>"><?php echo $type.' Leave'; ?></option>
										<?php } ?>
									</select>
									<label>Leave Type*</label>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<!-- <label>Status</label> -->
									<!-- <div id="status_error"></div> -->
									<label class="d-block">
										<input type="checkbox" class="add-comment" name="add_comment" value="true"> Add Comment
									</label>
							</div>
						</div>
						<div class="col-12 leave-commet-box d-none">
							<div class="form-group">
								<div class="single-field">
									<textarea name="leave_commet" id="leave_commet" rows="5"></textarea>
									<label>Leave Comment</label>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Status</label>
									<!-- <div id="status_error"></div> -->
									<label class="d-block">
										<input type="radio" class="" name="status" value="approved" checked="checked"> Approve Leave
									</label>
									<label class="d-block">
										<input type="radio" class="" name="status" value="rejected"> Reject Leave
									</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<!-- <button class="btn btn-success" data-dismiss="modal">Add</button> -->
					<button type="submit" class="btn sec-btn emp_reset" id="add_leave">Add</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="modal_attendsnce" class="modal employee-model">
	<div class="modal-dialog modal-dialog-centered">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
				<div class="modal-header-content">
					<h4 class="modal-title emp_name h5-emp-name">Employee : Niranjan Prajapati</h4>
					<h5 class="modal-sub-title">Add Attendance</h5>
				</div>
			</div>
			<form class="form-horizontal form-material" method="Post" id="edit_employee_attendance-form">
				<!-- <div class="from_message time_msg"></div> -->
                <input type="hidden" name="emp_id" id="emp_id1" value="">
                <input type="hidden" name="id" id="id"  value="">
                <input type="hidden" name="other_date" id="other_date" value="">
				<!-- <div class="from_message"></div> -->


				<input type="hidden" name="datepicker" id="datepicker" value="" >
				<div class="modal-body">
						<div class="row">
							<!-- <div class="col-md-12"> -->
								<!-- <h5 class="h5-emp-name text-center">Employee : Niranjan Prajapati</h5> -->
							<!-- </div> -->
							<!-- <div  class="col-md-12">	
								<label>Employee</label>
								<input type="text" name="emp-name" value="Niranjan Prajapati" class="form-control form-control-line" disabled="disabled">
							</div> -->
						<!-- </div>	 -->
	                    <div class="col-md-12">
							<div class="form-group att-admin">    
	                            <div class="single-field select-field">
	                                <select name="attendance_type" id="attendance_type">
	                                    <option value="" disabled>--Select Day--</option>
	                                    <option value="full_day">Full Day</option>
	                                    <option value="half_day">Half Day</option>
	                                </select>
	                        		<label>Select Day Type</label>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="row justify-content-center">

	                	<div class="col-md-10 col-sm-10">
	                		<div class="form-group att-admin">
	                			<div class="single-field">
	                				<input type="hidden" name="in_time" id="in_time">
	                				<input type="hidden" name="out_time" id="out_time">
	                				<input type="hidden" name="in_time1" id="in_time1">
	                				<input type="hidden" name="out_time1" id="out_time1">
	                				<input type="time" name="employee_in" id="employee_in">
	                				<label>IN *</label>
	                			</div>
	                		</div>
	                	</div>

	                	<div class="col-md-10 col-sm-10">
	                		<div class="form-group att-admin">
	                			<div class="single-field">
	                				<input type="time" name="employee_out" id="employee_out">
	                				<label>OUT *</label>
	                			</div>
	                		</div>
	                	</div>

	                	<div class="col-md-10 col-sm-10">
	                		<div class="form-group att-admin">
	                			<div class="single-field">
	                				<input type="time" name="employee_in1" id="employee_in1">
	                				<label>IN *</label>
	                			</div>
	                		</div>
	                	</div>

	                	<div class="col-md-10 col-sm-10">
	                		<div class="form-group att-admin m-0">
	                			<div class="single-field">
	                				<input type="time" name="employee_out1" id="employee_out1">
	                				<label>OUT *</label>
	                			</div>
	                		</div>
	                	</div>
						<div class="col-md-10 col-sm-10">
							<span class="span">
								<div class="form-group m-0 m-t-30" id="daily_work_div">
									<div class="single-field">
										<textarea class="textarea" name="daily_work" id="daily_work" placeholder=" - For example today I have worked on these given tasks (mention tasks name)."></textarea>
										<label>Daily Work Updates</label>
										<small class="work-info">Note: kindly mention your today completed work <span data-tooltip=" - For example today I have worked on these given tasks (mention tasks name)."><i class="fas fa-eye"></i></span></small>
									</div>
								</div>
							</span>
						</div>
	                </div>
				</div>
				<input type="hidden" name="in_out_time" id="in_out_time" value="9/3/2020">
				<div class="modal-footer justify-content-center" id="all_btn">
					<!-- <button class="btn btn-success" data-dismiss="modal">Add</button> -->
					<button type="submit" class="btn btn-success submit_form">Add</button>
					<button type="button" class="btn btn-success reset_data" onclick='reset_data()'>Reset</button>
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
$(".reset_data").click(function(){
	reset_data();
});

const reset_data = () => {
	$("#employee_in").val('');
	$("#employee_out").val('');
	$("#employee_in1").val('');
	$("#employee_out1").val('');
	$("#attendance_type").val('');
	$("#attendance_type option").eq('0').prop('selected',true);
}


/*$(".emp_search").click(function(e) {
    e.preventDefault();
	var base_url = $("#js_data").data("base-url");
	//var id=$("#employee").val();
	var id=$("#change_id").val();
	var url =base_url+"employee/employee_attendance_list/"+id;
	var form = $("#search-form");
    form.prop("action", url);
    form.submit();
 });*/
</script>
