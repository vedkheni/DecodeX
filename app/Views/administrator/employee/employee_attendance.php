<?php $user_session=$this->session->userdata('id'); ?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">

            <div class="col-lg-12 col-md-12 col-xs-12">
                <h4 class="page-title text-center" id="title">Add Employees Attendance</h4>
                <!-- <div class="page-title-btn">
                    <a href="<?php echo base_url('employee/employee_attendance_list/'.$user_session); ?>" class="btn sec-btn back-btn">
                        <i class="fas fa-chevron-left"></i>
                        <span>Back</span>
                    </a>
                </div> -->
            </div>
        <!-- <div class="col-sm-4">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('employee/employee_attendance_list/'.$user_session); ?>">List Attendance</a></li>
                <li class="active">Add Attendance</li>
            </ol>
        </div> -->
        <!-- /.col-lg-12 -->
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10 col-xs-12">
            <div class="white-box m-0">
            <div class="preloader preloader-2"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>
                <div class="massge_for_error text-center"><?php echo $this->session->flashdata('message'); ?> </div>
                <div class="massge_for_error text-center time_msg"></div>
				<!-- action="<?php //echo base_url('profile/insert_employee_attendance'); ?>" -->
                <form class="emp-attendance-form" method="post"  id="employee-form">
                    <h4 class="page-title blue-text text-center m-0"><?php echo date('d F Y'); ?></h4>

                    <hr class="custom-hr">

                    <div class="row justify-content-center m-t-30">
                        <div class="col-12 col-sm-10 col-md-12">
                            <div class="form-group">
                                <div class="single-field select-field">
                                    <select name="attendance_type" id="attendance_type">
                                        <option disabled>--Select Day-- </option>
                                        <option  <?php if(isset($get_employee_attendance[0]->attendance_type) && $get_employee_attendance[0]->attendance_type == 'full_day'){ ?> selected="selected" <?php } if(!isset($get_employee_attendance[0]->attendance_type)){echo 'selected="selected"';} ?> value="full_day">Full Day</option>
                                        <option <?php if(isset($get_employee_attendance[0]->attendance_type) && $get_employee_attendance[0]->attendance_type == 'half_day'){ ?> selected="selected" <?php } ?> value="half_day">Half Day</option>
                                    </select>
                                    <label>Select Day Type</label>
                                </div>
                            </div>
                            <div id="success_message"></div>
                        </div>
                    </div>
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
                                     <div class="col-4 col-sm-5 col-md-4">
                                        <label>In *</label>
                                    </div>
                                    <div class="col-8 col-sm-5 col-md-4">
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
                                        <div class="col-4 col-sm-5 col-md-4">
                                            <label>Out *</label>
                                        </div>
                                        <div class="col-8 col-sm-5 col-md-4">
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
                                </div>
                            <?php } }else{ ?>
                                <div class="form-group _form" id="employee_out_input">
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-4 col-sm-5 col-md-4">
                                            <label>Out *</label>
                                        </div>
                                        <div class="col-8 col-sm-5 col-md-4">
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
                             /*if(date('l') != 'Saturday'){*/
                             if($c == 1){ ?>
                                <div class="form-group _form hide_in_out form-add-field out_box3" >
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-4 col-sm-5 col-md-4">
                                            <label>IN *</label>
                                        </div>
                                        <div class="col-8 col-sm-5 col-md-4">
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
                                if($i == 2){
                                    ?>
                                    <div class="form-group _form">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-4 col-sm-5 col-md-4">
                                                <label>In*</label>
                                            </div>
                                            <div class="col-8 col-sm-5 col-md-4">
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
                                    $employee_out1=$value->employee_out;
                                    if($employee_out1 == "" || $employee_out1 == "0000-00-00 00:00:00"){ ?>
                                        <div class="form-group _form out_box4">
                                            <div class="row justify-content-center align-items-center">
                                                <div class="col-4 col-sm-5 col-md-4">
                                                    <label>Out *</label>
                                                </div>
                                                <div class="col-8 col-sm-5 col-md-4">
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
                                        </div>

                                    <?php }else{ ?>
                                     <div class="form-group _form" id="employee_out_input">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-4 col-sm-5 col-md-4">
                                                <label>Out *</label>
                                            </div>
                                            <div class="col-8 col-sm-5 col-md-4">
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
                                               <!--  <div class="form-group" id="employee_out_input">
                                                    <label class="col-md-4">IN *</label>
                                                    <div class="col-md-6">
                                                         <?php echo $value->employee_in; ?>
                                                          </div>
                                                      </div> -->

                                                  <?php } }
                                              /*}*/
                                              ?>     
                                              <?php $i++; }
                                          }else{ ?>
                                            <div class="form-group _form out_box1">
                                                <div class="row justify-content-center align-items-center">
                                                    <div class="col-4 col-sm-5 col-md-4">
                                                        <label>In *</label>
                                                    </div>
                                                    <div class="col-8 col-sm-5 col-md-4">
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

                            <input type="hidden" name="in_out_time" id="in_out_time" value="" data-current-date="<?php echo date('n/j/Y'); ?>">
                            <input type="hidden" name="datepicker" id="datepicker" value="<?php echo date('Y-m-d'); ?>" data-current-date="<?php echo date('Y-m-d'); ?>">
                            <input type="hidden" name="in_out_time_count" id="in_out_time_count" value="0">


                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
         function ampm(time) {
          if (time.value !== "") {
           var hours = time.split(":")[0];
           var minutes = time.split(":")[1];
           var suffix = hours >= 12 ? "PM" : "AM";
           hours = hours % 12 || 12;
           hours = hours < 10 ? "0" + hours : hours;

           var displayTime = hours + ":" + minutes + " " + suffix;
           $("#in_out_time").val(displayTime);
       }
   }

   $( document ).ready(function() {
     var today = new Date();
     if(today.getDay() == 6 || today.getDay() == 0){ 
       var employee_in=$("#employee_in").val();
       if(employee_in == "3" || employee_in == "4"){
        $(".hide_in_out").css("display","none");
    }
    $("#attendance_type").val("full_day");
			//$("#attendance_type").prop("disabled", true);
     } 
 });
</script>