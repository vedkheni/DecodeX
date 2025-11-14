<style>
   .time-minus{
   color : red;
   }
   .time-plus{
   color:green;
   }
</style>
<?php $user_role=$this->session->get('user_role'); ?>
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title text-center">Add Attendance</h4>
         <!-- <div class="page-title-btn">
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
         </div> -->
      </div>
      <!-- <div class="col-sm-4">
         <?php if($user_role == 'admin'){ ?>
                   <ol class="breadcrumb">
                       <li><a href="<?php echo base_url('employee'); ?>">Employee</a></li>
                       <li class="active">Add Attendance</li>
                   </ol>
         	<?php }else{ ?>
         	<ol class="breadcrumb">
                       <li class="active">Attendance</li>
                   </ol>
         	<?php } ?>
               </div> -->
      <!-- /.col-lg-12 -->
   </div>
   <!--  from to and dropdown search  -->
   <div class="row justify-content-center">
      <?php 
         //echo "<pre>"; print_r($krsort); echo "</pre>";
         $c_date=date('Y-m-d');
         ?>
      <div class="col-xl-5 col-lg-6 col-md-8 col-12">
         <div class="white-box space-30">
            <!-- total time Start -->
            <!-- total time end -->
            <?php 
               if(!empty($search)){
               	$current_year=$search['year']; 
               	$current_month=$search['month'];
               }else{
               	$current_year=date('Y'); 
               	$current_month=date('n');
               } ?>
            <form class=" add-full-attendance" method="post" action="<?php echo base_url('employee/insert_full_attendance'); ?>"  id="full-attendance-form">
               <div class="row">
                  <div class="col-md-12">
                     <!-- <div class="error_msg"></div> -->
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <div class="single-field select-field">
                           <select id="developer" name="developer" >
                              <option value="" disabled>Select Employee</option>
                              <?php foreach($get_developer as $k => $developer){ ?>
                              <option value="<?php echo $developer->id; ?>"><?php echo $developer->fname." ".$developer->lname; ?></option>
                              <?php } ?>
                           </select>
                           <label>Select Employee</label>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <div class="single-field select-field">
                           <select id="month" name="month" >
                              <option value="" disabled>Select Month</option>
                              <?php foreach(MONTH_NAME as $k => $v){ ?>
                              <option <?php if(isset($search['month']) && $search['month'] == $k+1) { echo "selected='selected'"; }else { if($current_month == $k+1){ echo "selected='selected'"; } }?> value="<?php echo $k+1; ?>"><?php echo $v; ?></option>
                              <?php } ?>
                           </select>
                           <label>Select Month</label>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <div class="single-field select-field">
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
                  </div>
                  <!-- </div> -->
                  <input type="hidden" name="search_dropdwon" id="search_dropdwon" value="1">
                  <!-- </div> -->
                  <div class="col-md-12">
                     <input type="reset" class="btn btn-danger float-left emp_reset"  value="Reset">
                     <input type="submit" class="btn sec-btn float-right emp_search"  value="Submit">
                  </div>
               </div>
            </form>
            <!-- <div class="table-responsive box-shadow">
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
                  
                  ?>
               
               	<table class="table display nowrap dataTable no-footer dtr-inline" id="example" style="width: 100%; position: relative;" role="grid" aria-describedby="example_info">
               		<thead>
                                        <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 39px;" aria-label="#: activate to sort column descending" aria-sort="ascending">#</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 65px;" aria-label="Date: activate to sort column ascending">Date</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 122px;" aria-label="Attendance: activate to sort column ascending">Attendance</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 54px;" aria-label="In: activate to sort column ascending">In</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 57px;" aria-label="Out: activate to sort column ascending">Out</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 54px;" aria-label="IN: activate to sort column ascending">IN</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 57px;" aria-label="Out: activate to sort column ascending">Out</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 135px;" aria-label="Total: activate to sort column ascending">Total</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 198px;" aria-label="Time: activate to sort column ascending">Time</th><th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 129px;" aria-label="Action: activate to sort column ascending">Action</th></tr>
                                </thead>
               		<tbody>
               		official-leave-color,paid-leave-color,approve-leave-color,unapprove-leave-color,sick-leave-color,absent-leave-color
               								
               		
               			<tr class="odd" role="row">
               				<td tabindex="0" class="sorting_1">1</td>
               				<td>
               					2019-12-01
               				</td>
               				<td>
               					<select>
               						<option>Full Day</option>
               						<option>Haif Day</option>
               					</select>
               				</td>
               				<td>
               					<input type="time" name="time1">
               				</td>
               				<td>
               					<input type="time" name="time2">
               				</td>
               				<td>
               					<input type="time" name="time3">
               				</td>
               				<td>
               					<input type="time" name="time4">
               				</td>
               				<td></td>
               				<td> 
               				</td>
               				
               				  
               				 <td>
               				 	<a class="edit-employee-attendances btn btn-danger waves-effect waves-light" href="#">Add</a>
               					<a class="edit-employee-attendances btn btn-danger waves-effect waves-light" href="#">Edit</a>
               					<a class="delete-employee-attendances btn btn-danger waves-effect waves-light">Reset</a>
               				</td> 						
               			</tr>
               			<tr class="even" role="row">
               				<td tabindex="0" class="sorting_1">2</td>
               				<td>2019-12-02</td>
               				<td>Full Day</td>
               				<td>09:35 AM</td>
               				<td>02:11 PM</td>
               				<td>02:43 PM</td>
               				<td>06:17 PM</td>
               				<td>08 Hours 10 Minutes</td>
               				<td>										<span class="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;00 Hours 10 Minutes</span>
               								 
               				</td>
               				
               				  
               				 <td>
               					<a class="edit-employee-attendances btn btn-danger waves-effect waves-light" href="#">Add</a>
               					<a class="edit-employee-attendances btn btn-danger waves-effect waves-light" href="#">Edit</a>
               					<a class="delete-employee-attendances btn btn-danger waves-effect waves-light">Reset</a>
               				</td> 						
               			</tr>
               			<tr>
               				<a class="btn btn-danger waves-effect waves-light" href="#">Edit All</a>
               				<a class="btn btn-danger waves-effect waves-light">Reset All</a>
               			</tr>
               		</tbody>
               	</table>
                           
                           </div> -->
         </div>
      </div>
   </div>
</div>
<script type="text/javascript"></script>