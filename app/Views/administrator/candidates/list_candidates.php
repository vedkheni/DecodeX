<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">

<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-12 col-md-12 col-xs-12">
         <h4 class="page-title">List Candidates</h4>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="white-box m-0">
            <div class="emp-custom-field">
               <div class="row">
                  <div class="col-12 text-center">
                  <div class="single-field date-field multi-field _search-form">
                     <input type="text" class="datepicker-here" placeholder="dd mm, yyyy" data-language="en" data-date-format="dd M, yyyy" name="date" id="date" autocomplete="off" value="<?php if(isset($search['from_date'])){ echo $search['from_date']; } ?>"> 
                     <label>Search By Interview Date</label>
                  </div>
                     <div class="single-field multi-field select-field _search-form">
                        <select id="schedule_type" name="schedule_type">
                           <option value="" disabled="">Select Schedule Type</option>
                           <option value="all_candidate">All</option>
                           <option value="unscheduled">Unscheduled</option>
                           <option value="fixed">Fixed</option>
                           <option value="pending">Pending</option>
                           <option value="inprocess">In-Process</option>
                           <option value="reject">Rejected</option>
                        </select>
                        <label>Select Schedule Type</label>
                     </div>
                     <div class="single-field multi-field select-field _search-form">
                        <select id="select_designation" name="select_designation">
                           <option value="" disabled="">Select designation</option>
                           <option value="all_designation">All</option>
                           <?php foreach ($designation as $key => $value) { ?>
                           <option value="<?php echo $value->id; ?>"><?php echo ucwords($value->name); } ?></option>
                        </select>
                        <label>Select designation</label>
                     </div>
                     <a href="<?php echo base_url('export_excel/candidates_excel/all_designation'); ?>" class="btn sec-btn  export_excel" name="export_excel">Export Excel</a>
                     <a class="btn sec-btn " href="<?php echo base_url('candidates/add');?>">Add New</a>
                     <button type="button" class="btn btn-danger" id="delete_candidate">Delete</button>
                     <button type="button" class="btn sec-btn  btn-open-desig d-none" data-toggle="modal" data-target="#add_candidate">Add New candidate</button>
                  </div>
               </div>
               <hr class="custom-hr">
            </div>
            <div class="table-responsive employee-table-list">
               <div class="preloader preloader-2">
                  <svg class="circular" viewBox="25 25 50 50">
                     <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                  </svg>
               </div>
               <table id="example" class="display nowrap" style="width:100%">
                  <thead class="_empthead">
                     <tr>
                        <th><input type="checkbox" name="select_All_checkbox" id="select_All_checkbox" value="All_select"></th>
                        <th>#</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Interview Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                     <tr>
                        <th></th>
                        <th>#</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Interview Date</th>
                        <th>Action</th>
                     </tr>
                  </tfoot>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>

<div id="add_candidate" class="modal add-candidate-modal" role="dialog">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <div class="modal_header-content">
               <h4 class="modal-title emp_name employee_name">Interview Details</h4>
            </div>
         </div>
         <div class="modal-body">
         <div class="preloader preloader-2">
               <svg class="circular" viewBox="25 25 50 50">
                  <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
               </svg>
            </div>
            <div class="step-tabing">
               <div class="step-tabing-wrap">
                  <ul class="nav nav-tabs nav-justified">
                     <li class="nav-item active">
                        <a class="nav-link complete" data-toggle="tab" data-href="candidate-info" onclick="onclick_run('candidate_info','candidate_info','candidateName','candidateDesignation','candidateExperience');$('#next').val('candidate_info');$('#previous').val('candidate_info');$('#btn_previous').hide();$('#btn_next').text('Next');" id="candidate_info">Candidate Detail</a>
                     </li>
                     <li class="nav-item "> <!-- complete -->
                        <a class="nav-link disabled" data-toggle="tab" data-href="hr-round" onclick="onclick_run('hr_round','hr_round','candidate_name','candidate_designation','candidate_experience');$('#btn_previous').show();$('#btn_next').text('Next');" id="hr_round">HR Round</a>
                     </li>
                     <li class="nav-item "> <!-- incomplete -->  <!-- form_submit2(); -->
                        <a class="nav-link disabled" data-toggle="tab" data-href="technical-round" onclick="onclick_run('technical_round','technical_round','candidate_name1','candidate_designation1','candidate_experience1');$('#btn_previous').show();$('#btn_next').text('Next');" id="technical_round">Technical Round</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link disabled" data-toggle="tab" data-href="final-round" onclick="onclick_run('final_round','final_round','candidate_name2','candidate_designation2','candidate_experience2');$('#btn_previous').show();$('#btn_next').text('Update');" id="final_round">Final Round</a>
                     </li>
                  </ul>
               </div>
               <input type="hidden" id="next" value="candidate_info">
               <input type="hidden" id="previous" value="candidate_info">
               <!-- Tab panes -->
               <div class="tab-content">
                  <!-- Candiadate Detail Tab -->
                  <div id="candidate-info" class="tab-pane active">
                     <form class="form-horizontal form-material" method="POST" enctype="multipart/form-data" accept-charset="utf-8" action="<?php echo base_url('candidates/insert_data'); ?>" id="candidate-form1">
                        <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
                        <input type="hidden" name="id" id="id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">
                        <input type="hidden" name="i_s_id" id="i_s_id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">
                        <input type="hidden" name="data_type" id="data_type" value="schedule_detail">
                        <div class="row">
                           <?php // echo "<pre>"; print_r($list_data); echo "</pre>";?>
                           <div class="col-lg-6 col-12">
                              <div class="form-group">
                                 <div class="single-field">
                                    <input type="text" name="name" id="name" value="<?php if(isset($list_data[0]->name)){ echo $list_data[0]->name;} ?>">
                                    <label for="name">Name*</label>
                                 </div>
                              </div>
                           </div>
                              <div class="col-lg-6 col-12" id="interview_date_div">
                                 <div class="form-group">
                                    <div class="single-field date-field">
                                       <input type="text" class="datepicker-here" data-language="en" name="interview_date" id="interview_date" autocomplete="off" value="">
                                       <label>Interview Date*</label>
                                    </div>
                                 </div>
                              </div>
                           
                           <div class="col-lg-6 col-12">
                              <div class="form-group">
                                 <div class="single-field">
                                    <input type="email" class="email" name="email" id="email"  value="<?php if(isset($list_data[0]->email)){ echo $list_data[0]->email;} ?>">
                                    <label for="email">Email*</label>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6 col-12">
                              <div class="form-group">
                                 <div class="single-field">
                                    <input type="text" class="numeric contact_number" maxlength="10" name="phone_number" id="phone_number"  value="<?php if(isset($list_data[0]->phone_number)){ echo $list_data[0]->phone_number;} ?>">
                                    <label for="phone_number">Phone No*</label>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6 col-12">
                              <div class="form-group">
                                 <div class="single-field select-field">
                                    <select name="designation" id="designation" onchange="designation_change();">
                                       <option>Select Designation</option>
                                       <?php foreach ($designation as $key => $value) { ?>
                                       <option <?php if(isset($list_data[0]->designation) && $list_data[0]->designation == $value->id){ ?> selected="selected" <?php } ?> value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                       <?php } ?>
                                    </select>
                                    <label>Select Designation*</label>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6 col-12">
                              <div class="row cms-option-gender align-items-center">
                                 <div class=" col-md-2">
                                    <label class="m-0">Gender*</label>
                                 </div>
                                 <div class=" col-md-5">
                                    <label class="cms-option-box male" for="gender">
                                       <input type="radio" <?php if(isset($list_data[0]->gender) && $list_data[0]->gender == "male"){ ?> checked="checked" <?php } ?> name="gender" value="male" id="gender" class="radio-class gender">
                                       Male
                                    </label>
                                 </div>
                                 <div class=" col-md-5">
                                    <label class="cms-option-box female" for="gender1">
                                       <input type="radio" <?php if(isset($list_data[0]->gender) && $list_data[0]->gender == "female"){ ?> checked="checked" <?php } ?> name="gender" value="female" id="gender1" class="radio-class gender">
                                       Female
                                    </label>
                                 </div>
                              </div>
                           </div>
                           <span class="d-none" id="d_skills"></span>
                           <?php foreach ($designation as $key => $value) { if(isset($list_data[0]->designation) && $list_data[0]->designation == $value->id){ ?>
                           <p class="d-none" id="<?php echo $value->id; ?>_skills"><?php if(isset($list_data[0]->skills)){ echo $list_data[0]->skills;} ?></p>
                           <?php }else{ ?>
                           <p class="d-none" id="<?php echo $value->id; ?>_skills"><?php echo $value->skills; ?></p>
                           <?php } }?>
                           <div class="col-lg-6 col-12">
                              <div class="form-group">
                                 <div class="single-field">
                                    <input type="text" maxlength="10" class="numeric experience" name="experience" id="experience"  value="<?php if(isset($list_data[0]->experience)){ echo $list_data[0]->experience;} ?>">
                                    <label for="experience">Experience*</label>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6 col-12">
                              <div class="form-group">
                                 <div class="single-field">
                                    <input type="text" maxlength="10" class="numeric" name="current_salary" id="current_salary" maxlength="10" value="<?php if(isset($list_data[0]->current_salary)){ echo $list_data[0]->current_salary;} ?>">
                                    <label>CTC*</label>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6 col-12">
                              <div class="form-group">
                                 <div class="single-field">
                                    <input type="text" maxlength="10" class="numeric" name="expected_salary" id="expected_salary" maxlength="10" value="<?php if(isset($list_data[0]->expected_salary)){ echo $list_data[0]->expected_salary;} ?>">
                                    <label>Expected CTC*</label>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6 col-12">
                              <div class="form-group candidate-resume">
                                 <div class="single-field">
                                    <div class="upload-text" id="upload-text">
                                       <i class="fas fa-upload text-secondary"></i>
                                       <span>Upload your resume here</span>
                                    </div>
                                    <input type="file" name="upload_resume" class="file-upload-field" data-msg="Upload Resume Is Required" id="upload_resume" onchange="getFileData(this)"  value="<?php if(isset($list_data[0]->upload_resume)){ echo $list_data[0]->upload_resume;} ?>">
                                    <input type="hidden" name="upload_resume_name" id="upload_resume_name" value="<?php if(isset($list_data[0]->upload_resume)){ echo $list_data[0]->upload_resume;} ?>" >
                                    <?php ?>
                                    <a target="_blank" class="view_resume" id="view_resume" data-tooltip="View Resume" href=""><i class="fas fa-eye"></i></a>
                                    <?php  ?>		
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6 col-12">
                              <div class="form-group">
                                 <div class="single-field">
                                    <input type="text" name="address" id="address" value="<?php if(isset($list_data[0]->location)){ echo $list_data[0]->location;} ?>">
                                    <label>Location*</label>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12">
                              <div class="form-group m-0">
                                 <div class="tag-group">
                                    <textarea rows="4" class="textarea tagarea" name="skills" id="skills"><?php if(isset($list_data[0]->skills)){ echo $list_data[0]->skills;} ?></textarea>
                                    <label>Skills*</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- <div class="white-box bluebox-border m-0">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group text-center m-0 p-0">
                                    <div class="col-sm-12">
                                       <button type="submit" class="btn sec-btn sec-btn-outline"><?php //  echo $page_text; ?></button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div> -->
                     </form>
                  </div>
                  <!-- Hr Round Tab -->
                  <div id="hr-round" class="tab-pane">
                     <form class="form-horizontal form-material" method="POST" enctype="multipart/form-data" action="<?php echo base_url('candidates/update_hrround_detail'); ?>" id="candidate-form2">
                        <input type="hidden" name="hrround_id" id="hrround_id">
                        <input type="hidden" name="candidate_id" id="candidate_id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">
                        <input type="hidden" name="interview_status" data-msg="Interview Status Is Required" id="interview_status" value="">
                        <input type="hidden" name="hr_skills" data-msg="HR Skills Is Required" id="hr_skills">
                        <div class="hr-candi-wrap">
                           <div class="candidate-info">
                              <div class="row">
                                 <div class="col-md-7 col-12">
                                    <h2>Name : <span class="blue-text" id="candidate_name"></span></h2>   
                                    <div class="extra-info">
                                       <span>Designation : </span><span class="" id="candidate_designation"></span>
                                    </div>
                                    <div class="extra-info">
                                       <span>Experiance :</span><span class="" id="candidate_experience"></span>
                                    </div>
                                 </div>
                                 <div class="col-md-5 col-12">
                                    <div class="inetrview-taken-detail">
                                       <h2>Interview Date</h2>   
                                       <div class="schedule_date"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="skill-rate-grp form-group">
                              <div class="row" id="rating_html">
                              </div>
                              </div>
                              <div class="hr-feedback">
                                 <div class="row">
                                    <div class="col-12">
                                       <h3 class="mt-0">HR Feedback*</h3>
                                    </div>
                                    <div class="col-12">
                                       <div class="form-group mb-0">
                                          <div class="single-field">
                                             <textarea name="hr_feedback" id="hr_feedback"></textarea>
                                             <!-- <label>Add Feedback</label> -->
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4 col-12">
                                       <label class="cms-option-box primary" for="status_select">
                                          <input type="radio" name="hrm-select" data-satus="select" id="status_select" value="select">
                                          Select
                                       </label>
                                    </div>
                                    <div class="col-md-4 col-12">
                                       <label class="cms-option-box warning" for="status_pending">
                                          <input type="radio" name="hrm-select" data-satus="pending" id="status_pending" value="Pending">
                                          Pending
                                       </label>
                                    </div>
                                    <div class="col-md-4 col-12">
                                       <label class="cms-option-box danger" for="status_reject">
                                          <input type="radio" name="hrm-select" data-satus="reject" id="status_reject" value="reject">
                                          Reject
                                       </label>
                                    </div>
                                 </div>
                              </div>
                        </div>
                     </form>
                  </div>
                  <!-- Technical Round Tab -->
                  <div id="technical-round" class="tab-pane">
                     <form class="form-horizontal form-material" method="POST" enctype="multipart/form-data" action="<?php echo base_url('candidates/update_tcround_detail'); ?>" id="candidate-form3">
                        <input type="hidden" name="tcround_id" id="tcround_id">
                        <input type="hidden" name="c_id" id="c_id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">
                        <input type="hidden" name="taken_by" id="taken_by" data-msg="Taken By Is Required" value="">
                        <input type="hidden" name="technical_skill" data-msg="Technical Skills Is Required" id="technical_skill">
                        <div class="hr-candi-wrap">
                           <div class="candidate-info">
                              <div class="row">
                                 <div class="col-md-7 col-12">
                                    <h2>Name : <span class="blue-text" id="candidate_name1"></span></h2>   
                                    <div class="extra-info">
                                       <span>Designation : </span><span class="" id="candidate_designation1"></span>
                                    </div>
                                    <div class="extra-info">
                                       <span>Experiance :</span><span class="" id="candidate_experience1"></span>
                                    </div>
                                 </div>
                                 <div class="col-md-5 col-12">
                                       <div class="inetrview-taken-detail">
                                          <h2>Interview Date</h2>   
                                          <div class="schedule_date"></div>
                                       </div>
                                    </div>
                              </div>
                              <!-- <div class="col-4">
                                 <div class="form-group">
                                    <div class="single-field date-field">
                                       <input type="text" class="datepicker-here" data-language="en" name="interview_date" id="interview_date" autocomplete="off" value="">
                                       <label>Interview Date</label>
                                    </div>
                                 </div>
                              </div> -->
                           </div>
                           <div class="skill-rate-grp form-group">
                              <div class="row" id="rating_html1">
                              </div>
                              </div>
                              <div class="hr-feedback">
                                 <div class="row">
                                    <div class="col-12">
                                       <h3 class="mt-0">Technical Feedback*</h3>
                                    </div>
                                    <div class="col-12">
                                       <div class="form-group mb-0">
                                          <div class="single-field">
                                             <textarea name="technical_feedback" id="technical_feedback"></textarea>
                                             <!-- <label>Add Feedback</label> -->
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4 col-12">
                                       <label class="cms-option-box" for="taken_by_rk">
                                          <input type="checkbox" name="taken_by[]" id="taken_by_rk" value="Rajanikant Kakadiya" data-taken_by="Rajanikant Kakadiya">
                                          Rajanikant Kakadiya
                                       </label>
                                    </div>
                                    <div class="col-md-4 col-12">
                                       <label class="cms-option-box" for="taken_by_sg">
                                          <input type="checkbox" name="taken_by[]" id="taken_by_sg" value="Sagar Gopani" data-taken_by="Sagar Gopani">
                                          Sagar Gopani
                                       </label>
                                    </div>
                                    <div class="col-md-4 col-12">
                                       <label class="cms-option-box" for="taken_by_rv">
                                          <input type="checkbox" name="taken_by[]" id="taken_by_rv" value="Rakesh Vadhel" data-taken_by="Rakesh Vadhel">
                                          Rakesh Vadhel
                                       </label>
                                    </div>
                                 </div>
                              </div>
                        </div>
                     </form>
                  </div>
                  <!-- Final Round Tab -->
                  <div id="final-round" class="tab-pane">
                     <form class="form-horizontal form-material" method="POST" enctype="multipart/form-data" action="<?php echo base_url('candidates/update_hrround_detail'); ?>" id="candidate-form4">
                        <input type="hidden" name="fround_id" id="fround_id">
                        <input type="hidden" name="c1_id" id="c1_id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">
                        <input type="hidden" name="final_satus" data-msg="Status Is Required" id="final_satus" value="">
                        <div class="hr-candi-wrap">
                           <div class="candidate-info m-0">
                              <div class="row">
                                 <div class="col-md-7 col-12">
                                    <h2>Name : <span class="blue-text" id="candidate_name2"></span></h2>   
                                    <div class="extra-info">
                                       <span>Designation : </span><span class="" id="candidate_designation2"></span>
                                    </div>
                                    <div class="extra-info">
                                       <span>Experiance :</span><span class="" id="candidate_experience2"></span>
                                    </div>
                                 </div>
                                 <div class="col-md-5 col-12">
                                    <div class="inetrview-taken-detail">
                                       <h2>Interview Taken By</h2>   
                                       <div id="taken_by_view"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4 col-12">
                                 <label class="cms-option-box primary" for="final_select">
                                    <input type="radio" name="final-select" data-final_satus="select" id="final_select" value="select">
                                    Select
                                 </label>
                              </div>
                              <div class="col-md-4 col-12">
                                 <label class="cms-option-box warning" for="final_onhold">
                                    <input type="radio" name="final-select" data-final_satus="onhold" id="final_onhold" value="hold">
                                    On Hold
                                 </label>
                              </div>
                              <div class="col-md-4 col-12">
                                 <label class="cms-option-box danger" for="final_reject">
                                    <input type="radio" name="final-select" data-final_satus="reject" id="final_reject" value="reject">
                                    Reject
                                 </label>
                              </div>
                           </div>
                           <div id="reject_to_hide" class="reject_to_hide">
                              <div class="row">
                                 <div class="col-md-6 col-12">
                                    <div class="form-group">
                                       <div class="single-field">
                                          <input type="text" maxlength="10" class="numeric" name="salary" maxlength="10" id="salary" value="">
                                          <label>Salary*</label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6 col-12">
                                    <div class="form-group">
                                       <div class="single-field select-field">
                                          <select id="employee_status" name="employee_status">
                                             <option value="" disabled="">Select Status</option>
                                             <option value="training">Training</option>
                                             <option value="employee">Employee</option>
                                          </select>
                                          <label>Select Status*</label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6 col-12">
                                    <div class="form-group">
                                       <div class="single-field date-field">
                                          <input type="text" name="joining_date" id="joining_date" autocomplete="off" value="">
                                          <label>Joining Date*</label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6 col-12" id="traning_period_div">
                                    <div class="form-group">
                                       <div class="single-field">
                                          <input type="text" maxlength="10" class="numeric traning_period" name="traning_period" id="traning_period" value="">
                                          <label for="traning_period">Traning Period*</label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="hr-feedback">
                                 <div class="row">
                                    <div class="col-12">
                                       <h3 class="mt-0">Remark*</h3>
                                    </div>
                                    <div class="col-12">
                                       <div class="form-group mb-0">
                                          <div class="single-field">
                                             <textarea name="remark" id="remark"></textarea>
                                             <!-- <label>Remark</label> -->
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <div class="row m-0 w-100">
               <div class="col-6 p-0 text-left">
                  <button class="btn btn-outline-secondary" id="btn_previous">Previous</button>
               </div>
               <div class="col-6 p-0 text-right">
                  <button class="btn sec-btn sec-btn-outline" id="btn_next">Next</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
$('#employee_status').change(function(){
   if($(this).val() == 'employee'){
      $('#traning_period_div').hide();
   }else{
      $('#traning_period_div').show();
   }
});
</script>