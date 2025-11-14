
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row bg-title">
		<!-- <div class="col-sm-4"> -->
            <!--<h4 class="page-title back-btn">
                <a href="#" class="learn-more">
                    <div class="circle">
                      <span class="icon arrow"></span>
                    </div>
                    <p  class="button-text">                
                            Back
					</p>
                </a>
            </h4>--> 
        <!-- </div> -->
        <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title text-center">Attendance Reports</h4> 
        </div>
        <!-- <div class="col-sm-4">
            <ol class="breadcrumb">
                <li><a href="#">Reports</a></li>
                <li class="active">Attendance Reports</li>
            </ol>
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

        return $hours.":".$minutes;
        // return $hours." Hours ".$minutes." Minutes";
    }
	if(isset($employee_attendance_list) && !empty($employee_attendance_list)){
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
				if($minus_total_time > $plus_total_time){
					$time = $minus_total_time-$plus_total_time;
					$time_type = 'plus';
				}else{
					$time = $plus_total_time-$minus_total_time;
					$time_type = 'minus';
				}
				if($plus_time != 0){
					$all_time[$m]['plus_time']=seconds($plus_time);
				}
				if($minus_time != 0){
					$all_time[$m]['minus_time']=seconds($minus_time);
				}
		}
		//	echo "<pre>"; 
			//print_r($arr);
			//echo "</pre>"; 
		}
		$user_role=$this->session->get('user_role'); 
		$c_date=date('Y-m-d');
    ?>

        <div class="col-md-12">
            <div class="white-box m-0">
				<!-- total time Start -->
				<!-- <div class="time_report">
					<div class="col-md-12">
						<div class="clock-case">
						  <div >
							  	<span class="hour">12<sub>h</sub></span>
						  </div>
						  <div>
						  		<span class="minutes">30<sub>Min</sub></span>
						  </div>
						</div>
						  <div class="seconds"></div>
					</div>
				</div>-->
				<!-- total time end -->
                <div class="attendance_report emp-custom-part">
                	<div class="row">
						<div class="col-xl-6 col-12 text-xl-left text-center">
							<?php
								if(isset($search['employees'])){
								foreach($get_developer as $dev){
							?>
								<?php if(isset($search['employees']) && $search['employees'] == $dev->id ){ ?> <h4>Name : <?php echo $dev->fname ." ".$dev->lname; ?> ( <?php echo $get_employee[0]->name; ?>)</h4><?php }?>
								<?php } }else{?> <h4 class="h4_name">Name : <?php echo $get_developer[0]->fname ." ".$get_developer[0]->lname; ?> ( <?php echo $get_employee[0]->name; ?>)</h4><?php } ?>
					   </div>
					   <div class="col-xl-6 col-12 text-xl-right text-center">
							<?php if(!empty($all_time)){
									if($time_type == 'plus'){ 	
								 ?>
								<span class="time-minus "><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp; <?php echo seconds($time);  ?></span>
							<?php }else{ ?>
								<span class="time-plus "><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo seconds($time); ?></span>
								<?php }
							 } ?>	
						</div>
                	</div>
					<hr class="custom-hr">
				</div>

			<?php //echo "<pre>"; print_r($get_developer); echo "</pre>"; ?>
				<form class="frm-search" method="post" action="" id="search-form">
					<div class="_form-search-form emp-custom-field att-report-search">
							
							<!-- <div class="error_msg"></div> -->
                            
                            <div class="row">
                            	<div class="col-12 text-center">
		                            <div class="single-field emp-seach-field select-field multi-field _search-form">
		                                <select name="employees" id="employees">
		                                	<option value="" disabled>Select Employee</option>
											<?php
											foreach($get_developer as $dev){
											?>
												<option value="<?php echo $dev->id; ?>" <?php if(isset($search['employees']) && $search['employees'] == $dev->id ){ ?> selected="selected" <?php }?>><?php echo $dev->fname ." ".$dev->lname; ?></option>
											<?php } ?>
										</select>
		                                <label>Select Employee</label>
									</div>

									<div class="single-field select-field multi-field _search-form">
		                                <select name="search_dropdwon" id="search_dropdwon">
		                                    <option value="">--Search By Day--</option>
		                                   <!--  <option <?php // if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 1){ ?> selected="selected" <?php // } ?> value="1">Today</option>
		                                    <option <?php // if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 2){ ?> selected="selected" <?php // } ?> value="2">Yesterday</option> -->
		                                    <option <?php if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 3){ ?> selected="selected" <?php } ?> value="3">Last Week</option>
		                                    <option <?php if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 6){ ?> selected="selected" <?php } ?> value="6">This Month</option>
		                                    <option <?php if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 4){ ?> selected="selected" <?php } ?> value="4">Last Month</option>
		                                    <option  <?php if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 5){ ?> selected="selected" <?php } ?> value="5">Last 6 Months</option>
		                                </select> 
		                                <label>Search By</label>
									</div>
									<label class="com-label">Or</label>
		                            <div class="single-field date-field multi-field _search-form">
		                            	<input type="text" placeholder="yyyy-mm" class="datepicker-here" data-language="en" name="from_date" id="fdate" data-date-format="yyyy-mm"  data-min-view="months" data-view="months" autocomplete="off" value="<?php if(isset($search['from_date'])){ echo $search['from_date']; } ?>"> 
		                            	<label>Search By Month</label>
		                            	<!-- <input type="date" placeholder="Form Date" class="form-control form-control-line bor-top" name="from_date" id="fdate" value="<?php if(isset($search['from_date'])){ echo $search['from_date']; } ?>">  -->
		                            </div>

		                            <!-- <div class="single-field date-field multi-field _search-form">
										<input type="text" placeholder="yyyy-mm-dd" class="datepicker-here" name="to_date" id="tdate" data-language="en" data-date-format="yyyy-mm-dd" autocomplete="off" value="<?php if(isset($search['to_date'])){ echo $search['to_date']; } ?>"> 
		                                <label>Select To Date</label>
									</div> -->
									<!-- <input type="date" placeholder="Form Date" class="form-control form-control-line bor-top" name="to_date" id="tdate" value="<?php if(isset($search['to_date'])){ echo $search['to_date']; } ?>">  -->

	                                    <input type="reset" onclick="$('#search_dropdwon option').removeAttr('selected');$('#employees option').removeAttr('selected');$('#tdate').val('');$('#fdate').val('');$('#search_dropdwon option:eq(0)').attr('selected','selected');$('#employees option:eq(1)').attr('selected','selected');" class="btn btn-danger emp_reset"  value="Reset">

                            	</div>
                            </div>
                            
                        <!-- <div class="d-inline-block vertical-align-middle _search-form form_submit">
                            <div class="emp_"> -->
                                <!-- <div class="emp_submit">
                                    <input type="submit" placeholder="To Date" class="btn btn-primary pull-left emp_search"  value="Search">
                                </div> -->
                                <!-- <div class="emp_submit">
                                    <input type="reset" class="btn btn-danger emp_reset"  value="Reset">
                                </div>   -->                         
                            <!-- </div>
                        </div> -->
                    </div>
				</form>
				
				<hr class="custom-hr">

                <div class="table-responsive employee-table-list">
                	<div class="preloader preloader-2" style="display:none"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>
                    <table class="table dataTable display nowrap" id="attendance_report" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Attendance</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Total</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
							
							$indate1 = $indate2 = $outdate1 = $outdate2 = 0;
                            $seconds1 = $seconds2 ="0"; $i=1;
                             if(!empty($arr)){ krsort($arr); 
							 foreach ($arr as $key => $value) { 
                            ?>
                            <tr>
								<td><span><?php echo $i; ?></span></td>
                                <td><?php echo $key; ?></td>
                                <td><?php  if(isset($value['attendance_types'][0]) && !empty($value['attendance_types'][0])){ echo $value['attendance_types'][0]; } ?></td>
                                <td><?php 
                                if(isset($value['in'][0]) && !empty($value['in'][0])){ echo $value['in'][0]; 
								$indate1 = strtotime($value['in'][0]);
								}else{
									$indate1 = 0;
								} ?></td>
                                
                                <td><?php 
                                if(isset($value['out'][0]) && !empty($value['out'][0])){ echo $value['out'][0]; 
								$outdate1 = strtotime($value['out'][0]);
								}else{
									$outdate1 =0;
								} ?></td>
                                <td><?php 
                                if(isset($value['in'][1]) && !empty($value['in'][1])){ echo $value['in'][1]; 
									$indate2 = strtotime($value['in'][1]);
								}else{
									$indate2 =0;
								} ?></td>

                                <td><?php 
                                if(isset($value['out'][1]) && !empty($value['out'][1])){ echo $value['out'][1]; 
								$outdate2 = strtotime($value['out'][1]);
								}else{
									$outdate2=0;
								} ?></td>
                                <?php  
								//$seconds4 =  $outdate1 - $indate1;
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
                                //$seconds2=isset($value['seconds'][1]) ? $value['seconds'][1] : "0" ;
                                //$seconds= $value['seconds'][0] + $seconds2;
                                ?>
                                <td><?php echo seconds($seconds); ?></td>
								<?php if($user_role == "admin"){ ?>
								<td> 
									<?php if(!empty($all_time)){ 	
										if(isset($all_time[$key]['minus_time'])){ ?>
										<span class="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $all_time[$key]['minus_time'] ?></span>
										<?php }
										if(isset($all_time[$key]['plus_time'])){ ?>
										<span class="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $all_time[$key]['plus_time'] ?></span>
										<?php }
									 } ?> 
								</td>
								<?php } ?>
							</tr>
							<?php $i++ ; } } ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  /*  $(document).ready(function(){
   		var table = $('#example').DataTable(); 
   }); */
    
</script>