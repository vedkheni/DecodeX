<style>

.time-minus{

    color : red;

}

.time-plus{

    color:green;

}

</style>

<div id="page-wrapper">

<div class="container-fluid">

    <div class="row bg-title">

        <div class="col-sm-4">

        </div>

        <div class="col-sm-4 text-right">

            <h4 class="page-title text-center">Logs Reports</h4> 

        </div>

        <div class="col-sm-4">

            <ol class="breadcrumb">

                <li><a href="#">Reports</a></li>

                <li class="active">Logs Reports</li>

            </ol>

        </div>

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



        return $hours." Hours ".$minutes." Minutes";

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

                if($plus_time != 0){

                    $all_time[$m]['plus_time']=seconds($plus_time);

                }

                if($minus_time != 0){

                    $all_time[$m]['minus_time']=seconds($minus_time);

                }

        }

        //  echo "<pre>"; 

            //print_r($arr);

            //echo "</pre>"; 

        }

        $user_role=$this->session->userdata('user_role'); 

        $c_date=date('Y-m-d');

    ?>



        <div class="col-md-12">

            <div class="white-box bg-none">

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

                <div class="attendance_report">

                    <div>

                        <?php if(isset($get_employee) && !empty($get_employee)){ ?>

                             <h4>Name : <?php echo $get_employee[0]->fname." ".$get_employee[0]->lname; ?> ( <?php echo $get_employee[0]->name; ?>)</h4> 

                        <?php } ?>

                   </div>

                   <div class="col-md-6 report pull-right">

                        <?php if(!empty($all_time)){    

                             ?>

                            <span class="col-md-5 time-minus "><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp; <?php echo seconds($minus_total_time);  ?></span>



                            <span class="col-md-5 time-plus "><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo seconds($plus_total_time); ?></span>

                            <?php 

                         } ?>   

                    </div>

                </div>

                

            <?php       //echo "<pre>"; print_r($get_developer); echo "</pre>"; ?>

                <form class="form-horizontal form-material frm-search" method="post" action="" id="search-form">
                    <div class="_form-search-form">

                            <div class="error_msg"></div>

                            <div class="col-md-6 _search-form">

                                 <label>Employees :</label>

                                <select class="form-control form-control-line bor-top" name="employees" id="employees">

                                    <?php

                                    foreach($get_developer as $dev){

                                    ?>

                                        <option value="<?php echo $dev->id; ?>" <?php if(isset($search['employees']) && $search['employees'] == $dev->id ){ ?> selected="selected" <?php }?>><?php echo $dev->fname ." ".$dev->lname; ?></option>

                                    <?php } ?>

                                </select>

                            </div>



                        <!-- <div class="form-group"> -->

                            <div class="error_msg"></div>

                            <div class="col-md-6 _search-form">

                                <label>From Date :</label>

                              

                                <input type="date" placeholder="Form Date" class="form-control form-control-line bor-top" name="from_date" id="fdate" value="<?php if(isset($search['from_date'])){ echo $search['from_date']; } ?>"> 

                     



                            </div>

                        <!-- </div> -->

                        <!-- <div class="form-group"> -->

                            <div class="col-md-6 _search-form">

                                <label>To Date :</label>

                               

                                <input type="date" placeholder="Form Date" class="form-control form-control-line bor-top" name="to_date" id="tdate" value="<?php if(isset($search['to_date'])){ echo $search['to_date']; } ?>"> 

                            </div>

                        <!-- </div> -->



                            <div class="col-md-6 _search-form">

                                <label>Search By :</label>

                                <select name="search_dropdwon" id="search_dropdwon" class="form-control form-control-line bor-top">

                                    <option value="">--Search By Day--</option>

                                    <option <?php if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 1){ ?> selected="selected" <?php } ?> value="1">Today</option>

                                    <option <?php if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 2){ ?> selected="selected" <?php } ?> value="2">Yesterday</option>

                                    <option <?php if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 3){ ?> selected="selected" <?php } ?> value="3">Last Week</option>

                                    <option <?php if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 6){ ?> selected="selected" <?php } ?> value="6">This Month</option>

                                    <option <?php if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 4){ ?> selected="selected" <?php } ?> value="4">Last Month</option>

                                    <option  <?php if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 5){ ?> selected="selected" <?php } ?> value="5">6 Month</option>

                                </select> 

                            </div>

                        <!-- </div> -->

                        <div class="col-md-12 _search-form">

                            <div class="emp_">

                                <div class="emp_submit">

                                    <input type="submit" placeholder="To Date" class="btn btn-primary pull-left emp_search"  value="Search">

                                </div>

                                <div class="emp_submit">

                                    <input type="reset" class="btn btn-grey btn-primary pull-left emp_reset"  value="Reset">

                                </div>                           



                            </div>

                        </div>
                    </div>
                </form>

                

                <div class="table-responsive box-shadow">

                



                    <table class="table  display nowrap table-text-center" id="example" style="width:100%">

                        <thead>

                            <tr>

                                <th>Id</th>

                                <th>DateTime</th>

								<th>Ip Address</th>

                                <th>Attendance</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                                if (isset($logs)) {

                                    foreach ($logs as $value) { ?>

                                        <tr>

                                            <td>

                                                <?php echo $value->login_log_id; ?>

                                            </td>

                                            <td>

                                                <?php echo $value->employee_id; ?>

                                            </td>

                                            <td>

                                                <?php echo $value->ip_address; ?>

                                            </td>

											<td>

                                                <?php echo $value->datetime; ?>

                                            </td>

                                        </tr>

                                    <?php

                                    }

                                }

                            ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- login_log_id,employee_id,datetime -->