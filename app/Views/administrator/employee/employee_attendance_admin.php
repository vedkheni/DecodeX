<?php 
   $page_text="Add";
   if(isset($get_employee_attendance) && !empty($get_employee_attendance)){ 
       $page_text="Update";
   }else{
       $page_text="Add";
   }
   $find_date=date('Y-m-d'); 
   if(isset($get_date) && !empty($get_date)) { 
   $find_date=$get_date;
   } 
   $all_field="";
   if(strtolower(date("l", strtotime($find_date))) == "sunday"){
   $all_field="disabled";
   }
   
   ?>
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-12 col-md-12 col-xs-12">
         <div class="page-title-btn">
            <a class="btn sec-btn back-btn" href="<?php echo base_url('employee/employee_attendance_list/'.$id); ?>">
               <i class="fas fa-chevron-left"></i>
               <span>Back</span>
            </a>
            <h4 class="page-title text-center"><?php echo $page_text; ?> Attendance ( <?php if(isset($get_date) && !empty($get_date)) { $d=date_create($get_date); echo date_format($d,"d F Y"); } else { echo date('d F Y'); } ?> )</h4>
         </div>

      </div>
      <!-- <div class="col-sm-4">
         <ol class="breadcrumb">
            <li><a href="<?php // echo base_url('employee/employee_attendance_list/'.$id); ?>">List Attendance</a></li>
            <li class="active"><?php // echo $page_text; ?> Attendance </li>
         </ol>
      </div> -->
      <!-- /.col-lg-12 -->
   </div>
   <?php 
      //echo "<pre/>";
           // print_r($get_employee);
       // echo $dd;
       
         // print_r($date_month);
      $month_day=array();
       foreach($date_month as $k => $v){
      $d=date_create($v->employee_in);
      $date_val=date_format($d,"d F Y");
      $month_day[]=$date_val;
      //array_push($month_day,$date_val); 
       }
      //  $ab=array_unique($month_day);
       $m_d_encode=json_encode($month_day);
       
        
      //    die;
           // echo "</pre>";
        $Attendance=array();
        if(isset($get_employee_attendance)){
            foreach ($get_employee_attendance as $k => $v) {
                $Attendance[]=$v->id;
            }
        }
         ?>
   <div id="json-date" data-alldate='<?php echo $m_d_encode; ?>'></div>
   
   <div class="row justify-content-center">
      <div class="preloader preloader-2 report_preloader1">
            <svg class="circular" viewBox="25 25 50 50">
               <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
         </div>
      <div class="col-12 col-md-10 col-lg-8 col-xl-6">
         <div class="white-box space-30">
         <form class="frm-search" method="post" id="search-form">
            <div class="row">
               <!-- <div class="form-group"> -->
               <?php 
                  $csrf = array(
                          'name' => $this->security->get_csrf_token_name(),
                          'hash' => $this->security->get_csrf_hash()
                  );
                  //echo "<pre>"; print_r($list_data); echo "</pre>";
                  ?>
               <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
               
               <div class="col-md-12 col-xs-12   ">
                  <div class="single-field select-field _search-form">
                     <select id="employee" name="employee" >
                        <option value="" disabled>Select Employee</option>
                        <?php foreach($get_employee_list as $key => $val){ ?>
                        <option <?php  if($id == $val->id){ echo "selected='selected'";  } ?> value="<?php echo $val->id; ?>"><?php echo $val->fname." ".$val->lname; ?></option>
                        <?php } ?>
                     </select>
                     <label>Select Employee</label>
                  </div>
               </div>
               
              <!--  <div class="col-md-4 col-xs-12 text-right">
                  <div class="_search-form">
                     <div class="emp_">
                        <div class="emp_submit">
                           <input type="button" placeholder="To Date" class="btn sec-btn pull-left emp_search"  value="Search">
                        </div>
                     </div>
                  </div>
               </div> -->
            </div>
         </form>
      </div>
         <div class="white-box p-b-35 m-0">
            <?php if(isset($get_employee) && !empty($get_employee)){ ?>
               <div class="employee-name text-center"> Name : <?php  echo $get_employee[0]->fname." ".$get_employee[0]->lname; ?></div>
            <?php } ?>
            <form class="form-horizontal form-material" method="post" action="<?php echo base_url('employee/insert_employee_attendance'); ?>" id="employee-form-admin">
               <?php    
                  if(isset($get_date) && !empty($get_date)) {
                    $g_date=$get_date;
                  }else{
                    $g_date=date('Y-m-d');
                  }
                  $next=date('Y-m-d', strtotime('+1 day', strtotime($g_date)));
                  $prev=date('Y-m-d', strtotime('-1 day', strtotime($g_date)));
                  ?>
               <div class="text-center day-title">
                  <a href="<?php echo $prev; ?>" class="prev-day btn sec-btn"><span class="fa fa-chevron-left"></span></a>
                  <input type="text" id="datepicker" class="datepicker-here" name="attendance_date" value="<?php if(isset($get_date) && !empty($get_date)) { $d=date_create($get_date); echo date_format($d,"d F Y"); } else { echo date('d F Y'); } ?>" autocomplete="off">
                  <?php //if(isset($get_date) && !empty($get_date)) { $d=date_create($get_date); echo date_format($d,"d F Y"); } else { echo date('d F Y'); } ?>
                  <p id="weekday" onchange="//date_change();" class="weekday"><?php if(isset($get_date) && !empty($get_date)) { $d1=date_create($get_date); echo date_format($d1,"l"); } else { echo date('l'); } ?></p>
                  <a href="<?php echo $next; ?>" class="next-day btn sec-btn"><span class="fa fa-chevron-right"></span></a>
               </div>
               <!-- <a class="btn sec-btn pull-right" href="<?php echo base_url('employee/employee_attendance_list/'.$id); ?>">LIst Attendance</a> -->
               <div class="massge_for_error text-center"><?php echo $this->session->flashdata('message'); ?> </div>
               <!-- <div class="massge_for_error text-center time_msg"></div> -->
               <input type="hidden" name="emp_id" id="emp_id" value="<?php echo implode(",", $Attendance); ?>">
               <input type="hidden" name="id" id="id"  value="<?php echo $id; ?>">
               <input type="hidden" name="other_date" id="other_date" value="<?php echo $get_date; ?>">
               
               <div class="row justify-content-center">
               
               <div class="col-12 col-md-10">
                  <div class="form-group att-admin">
                     <div class="single-field select-field">
                        <select name="attendance_type"  id="attendance_type" <?php echo $all_field; ?>>
                           <option value="--Select Day--" disabled>--Select Day--</option>
                           <option  <?php if(isset($get_employee_attendance[0]->attendance_type) && $get_employee_attendance[0]->attendance_type == 'full_day'){ ?> selected="selected" <?php } ?> value="full_day">Full Day</option>
                           <option <?php if(isset($get_employee_attendance[0]->attendance_type) && $get_employee_attendance[0]->attendance_type == 'half_day'){ ?> selected="selected" <?php } ?> value="half_day">Half Day</option>
                        </select>
                        <label>Select Day Type</label>
                     </div>
                  </div>
               </div>

            </div>

            <div class="row justify-content-center">
            
               <div class="col-12 col-md-5">
                  <div class="form-group att-admin">
                     <div class="single-field">
                           <!-- <div class='input-group date datetimepicker1' id='datetimepicker1'> -->
                           <?php
                              $employee_in =  $employee_out = $employee_in1 = $employee_out1 = $employee_in_hidden = $employee_out_hidden 
                              = $employee_in1_hidden = $employee_out1_hidden ="";
                              if(isset($get_employee_attendance) && !empty($get_employee_attendance[0]->employee_in) && $get_employee_attendance[0]->employee_in != "0000-00-00 00:00:00"){
                                  $date_create=date_create($get_employee_attendance[0]->employee_in);
                                 $employee_in=date_format($date_create,'H:i');
                              $employee_in_hidden=date_format($date_create,'h:i A');
                              }
                              if(isset($get_employee_attendance) && !empty($get_employee_attendance[0]->employee_out) && $get_employee_attendance[0]->employee_out != "0000-00-00 00:00:00"){
                                  $date_create1=date_create($get_employee_attendance[0]->employee_out);
                                 $employee_out=date_format($date_create1,'H:i');
                              $employee_out_hidden=date_format($date_create1,'h:i A');
                              }
                              if(isset($get_employee_attendance) && !empty($get_employee_attendance[1]) && $get_employee_attendance[1]->employee_in != "0000-00-00 00:00:00"){
                                  $date_create2=date_create($get_employee_attendance[1]->employee_in);
                                 $employee_in1=date_format($date_create2,'H:i');
                              $employee_in1_hidden=date_format($date_create2,'h:i A');
                              }
                              if(isset($get_employee_attendance) && isset($get_employee_attendance[1]) && !empty($get_employee_attendance[1]->employee_out) && $get_employee_attendance[1]->employee_out != "0000-00-00 00:00:00"){
                              //echo "<pre>";print_r($get_employee_attendance[1]);echo "</pre>";
                                 $date_create3=date_create($get_employee_attendance[1]->employee_out);
                                 $employee_out1=date_format($date_create3,'H:i');
                              $employee_out1_hidden=date_format($date_create3,'h:i A');
                              }
                              //echo "<pre>";
                              //print_r($get_employee_attendance);
                              //echo "</pre>";
                              /*echo $employee_in;
                              echo "<br>";
                              echo $employee_out;
                              echo "<br>";
                              echo $employee_in1;
                              echo "<br>";
                              echo $employee_out1;
                              echo "<br>";*/
                               ?>
                           <input type="hidden" name="in_time" id="in_time" value="<?php echo $employee_in_hidden; ?>" >
                           <input type="hidden" name="out_time" id="out_time" value="<?php echo $employee_out_hidden; ?>" >
                           <input type="hidden" name="in_time1" id="in_time1" value="<?php echo $employee_in1_hidden; ?>" >
                           <input type="hidden" name="out_time1" id="out_time1" value="<?php echo $employee_out1_hidden; ?>">
                           <input type='time' <?php echo $all_field; ?>   name="employee_in" id="employee_in" value="<?php echo $employee_in; ?>"/>
                           <label>IN *</label>
                           <!-- <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                              </div> -->
                     </div>
                  </div>
               </div>
                  <div class="col-12 col-md-5">
                     <div class="form-group att-admin">
                        <div class="single-field">
                           <!-- <div class='input-group date datetimepicker1' id='datetimepicker1'> -->
                           <input type='time' <?php echo $all_field; ?> name="employee_out" id="employee_out" value="<?php echo $employee_out; ?>"/>
                           <label>Out *</label>
                           <!-- <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                           </div> -->
                        </div>
                     </div>
                  </div>
               </div>


               <div class="row justify-content-center">

                  <div class="col-12 col-md-5">
                     <div class="form-group att-admin">
                        <div class="single-field">
                           <!-- <div class='input-group date datetimepicker1' id='datetimepicker1'> -->
                           <input type='time' <?php echo $all_field; ?> name="employee_in1" id="employee_in1" value="<?php echo $employee_in1; ?>"/>
                           <label>IN *</label>
                           <!-- <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                              </div> -->
                        </div>
                     </div>
                  </div>
                  
                  <div class="col-12 col-md-5">
                     <div class="form-group att-admin">
                        <div class="single-field">
                           <!--   <div class='input-group date datetimepicker1' id='datetimepicker1'> -->
                           <input type='time' <?php echo $all_field; ?>  name="employee_out1" id="employee_out1" value="<?php echo $employee_out1; ?>"/>
                           <label>Out *</label>
                           <!-- <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                              </div> -->
                        </div>
                     </div>
                  </div>
               
               </div>

               <?php if(isset($get_date) && !empty($get_date)) { $d2=date_create($get_date);  $d1=date_format($d2,'n/j/Y'); } else { $d1=date('n/j/Y'); } 
                  //echo "hewkwekwe".$d1;
                  ?>
                  <input type="hidden" name="in_out_time" id="in_out_time" value="<?php echo $d1; ?>">
                  
                  <div class="row justify-content-center" id="all_btn">
                     <div class="col-5 text-left">
                        <button onclick="$('#employee_in').val('');$('#employee_out').val('');$('#employee_in1').val('');$('#employee_out1').val('');" class="btn btn-danger reset_data" <?php echo $all_field; ?> type="button">Reset</button>
                        <?php  if(isset($get_employee_attendance) && !empty($get_employee_attendance)){  ?>
                           <a data-id="<?php echo $id; ?>" data-date="<?php echo $find_date; ?>" class="delete-employee-attendances btn btn-danger">Delete</a>
                        <?php } ?>
                     </div>
                     <div class="col-5 text-right">
                        <button class="btn sec-btn submit_form" <?php echo $all_field; ?>><?php echo $page_text; ?></button>
                     </div>
                  </div>
                  <div class="row justify-content-center">
                     <div class="col-md-10 col-sm-12">
                        <!-- <div class="from_message space-top"></div> -->
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
<script type="text/javascript">
   $( document ).ready(function() {
   	$('#datepicker').datepicker().data('datepicker').selectDate(new Date('<?php if(isset($get_date) && !empty($get_date)) { $d=date_create($get_date); echo date_format($d,"d F Y"); } else { echo date('d F Y'); } ?>'));
   });
</script>