<?php
$user_role = $this->session->get('user_role');
//echo '<pre>'; print_r( $pc_issue ); echo '</pre>'; 
$page_text = "Add";
if (isset($list_data[0]->id) && !empty($list_data[0]->id)) {
   $page_text = "Update";
} else {
   $page_text = "Add";
}
if (isset($list_data[0]->hardware_part) && !empty($list_data[0]->hardware_part)) {
   $hpart = explode(',', $list_data[0]->hardware_part);
}
$issue = '';
if (isset($list_data[0]->issue) && $list_data[0]->issue == 'software') {
   $screenshort = explode(',', $list_data[0]->screenshorts);
   foreach ($screenshort as $k => $v) {
      $issue .= '<div class="img-preview removeImg" ><button type="button" class="remove_img" data-image_name="' . $v . '"><i class="fas fa-times"></i></button> <a href="javascript:void(0)" onclick="show_img($(this))" class="ss_view_image" title="View Resume" data-href="' . base_url('assets/upload/issue_ss/') . $v . '"><i class="fas fa-eye"></i><img src="' . base_url('assets/upload/issue_ss/') . $v . '" style="width: 100px;" alt=""></a></div>';
   }
}
?>
<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title">List PC Issue</h4>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="white-box m-0">
               <?php if ($user_role == 'admin') { ?>
                  <!-- For Admin -->

                  <div class="emp-custom-field">
                     <div class="row">
                        <div class="col-12 text-center">
                           <button type="button" class="btn sec-btn" data-toggle="modal" data-target="#add-pc-id">Add PC ID </button>
                        </div>
                     </div>
                     <hr class="custom-hr">
                  </div>
               <?php } else { ?>
                  <!-- For Employee -->
                  <?php  ?>
                  <div class="emp-custom-field">
                     <div class="row">
                        <div class="col-12 text-center btn-grp">
                           <button type="button" class="btn sec-btn" onclick="reset_form();" data-toggle="modal" data-target="#add-pc-issue">Add PC Issue </button>
                           <button type="button" class="btn sec-btn" data-toggle="modal" data-target="#change-pc-id">Change PC ID </button>
                        </div>
                     </div>
                     <hr class="custom-hr">
                  </div>
               <?php } ?>

               <div class="table-responsive employee-table-list">
                  <div class="preloader preloader-2">
                     <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                     </svg>
                  </div>
                  <?php if ($user_role != 'admin') { ?>
                     <table id="example" class="display nowrap" style="width:100%">
                        <thead class="_empthead">
                           <tr>
                              <th>#</th>
                              <th>Issue Type</th>
                              <th>Issue</th>
                              <th>Description</th>
                              <th>System Id</th>
                              <th>Status</th>
                              <th>Action</th>
                              <!-- <th>Status</th> -->
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                           <tr>
                              <th>#</th>
                              <th>Issue Type</th>
                              <th>Issue</th>
                              <th>Description</th>
                              <th>System Id</th>
                              <th>Status</th>
                              <th>Action</th>
                           </tr>
                        </tfoot>
                     </table>
                  <?php } else { ?>
                     <table id="pc_issue_list" class="display nowrap" style="width:100%">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Employee</th>
                              <th>Issue Type</th>
                              <th>Issue</th>
                              <th>Description</th>
                              <th>System Id</th>
                              <th>Status</th>
                              <th>Action</th>
                              <!-- <th>Status</th> -->
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                           <tr>
                              <th>#</th>
                              <th>Employee</th>
                              <th>Issue Type</th>
                              <th>Issue</th>
                              <th>Description</th>
                              <th>System Id</th>
                              <th>Status</th>
                              <th>Action</th>
                           </tr>
                        </tfoot>
                     </table>
                  <?php } ?>
               </div>
            </div>
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

   <div class="modal" id="myModal" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered">
         <div class="modal-content">
            <img src="" id="view_ss_image" alt="">
         </div>
      </div>
   </div>

   <div class="modal" id="view_description" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
               <div class="modal_header-content">
                  <h4 class="modal-title emp_name employee_name">View Description</h4>
               </div>
            </div>
            <div class="modal-body">
               <p id='full_description'></p>
            </div>
         </div>
      </div>
   </div>

   <div class="modal" id="change_status" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
               <div class="modal_header-content">
                  <h4 class="modal-title emp_name employee_name">Change Status</h4>
               </div>
            </div>
            <div class="modal-body">
               <div class="form-group m-0">
                  <input type="hidden" value="" id="issue_id" name="issue_id">
                  <div class="single-field select-field">
                     <select name="status" id="status">
                        <option value="new">New</option>
                        <option value="pending">Pending</option>
                        <option value="inprogress">Inprogress</option>
                        <option value="resolved">Resolved</option>
                     </select>
                     <label>Select Status*</label>
                  </div>
               </div>
            </div>
            <div class="modal-footer justify-content-center">
               <div class="row w-100">
                  <div class="col-12 p-0 text-right">
                     <button class="btn sec-btn submit_form" onclick="change_issue_status();">Change</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Add PC Issue Modal -->
   <div class="modal add-issue-modal" id="add-pc-issue" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
               <div class="modal_header-content">
                  <h4 class="modal-title emp_name employee_name"><span class="title">Add</span> PC Issue</h4>
               </div>
            </div>
            <form class="form-horizontal form-material" method="POST" enctype="multipart/form-data" action="<?php echo base_url('pc_issue/insert_data'); ?>" id="pc_issue-form">
               <div class="modal-body">
                  <div class="preloader preloader-2" style="">
                     <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                     </svg>
                  </div>
                  <div class="alert alert-secondary text-center mb-5">
                     <h3 class="m-0">Your PC ID - <span id="idofpc_1"><?php if (isset($get_pc_data[0])) {
                                                                           echo $get_pc_data[0]->pc_id;
                                                                        } elseif (isset($list_data[0]->pc_id)) {
                                                                           echo $list_data[0]->pc_id;
                                                                        } ?></span> </h3>
                  </div>
                  <?php
                  $e_id = ($user_role == 'admin') ? '' : $this->session->get('id');
                  ?>
                 <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
                  <input type="hidden" name="employee_id" id="employee_id" value="<?php echo (isset($list_data[0]->employee_id)) ? $list_data[0]->employee_id : $e_id; ?>">
                  <input type="hidden" name="pc_id" id="pc_id" value="<?php if (isset($get_pc_data[0])) {
                                                                           echo $get_pc_data[0]->pc_id;
                                                                        } elseif (isset($list_data[0]->pc_id)) {
                                                                           echo $list_data[0]->pc_id;
                                                                        } ?>">
                  <input type="hidden" name="id" id="id" value="<?php if (isset($list_data[0]->id)) {
                                                                     echo $list_data[0]->id;
                                                                  } ?>">
                  <input type="hidden" name="ss" id="ss" value="<?php echo (isset($list_data[0]->screenshorts)) ? $list_data[0]->screenshorts : ''; ?>">
                  <input type="hidden" name="parts" id="parts" value="<?php echo (isset($list_data[0]->hardware_part)) ? $list_data[0]->hardware_part : ''; ?>">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <div class="single-field select-field">
                              <select name="issue" id="issue">
                                 <option value="" disabled>Select Issue</option>
                                 <option <?php if (isset($list_data[0]->issue) && $list_data[0]->issue == 'hardware') { ?> selected="selected" <?php } elseif (!isset($list_data[0]->issue)) {
                                                                                                                                             echo 'selected="selected"';
                                                                                                                                          } ?> value="hardware">Hardware</option>
                                 <option <?php if (isset($list_data[0]->issue) && $list_data[0]->issue == 'software') { ?> selected="selected" <?php } ?> value="software">Software</option>
                              </select>
                              <label>Select Issue*</label>
                           </div>
                        </div>
                     </div>
                     <?php if ($user_role == 'admin') { ?>
                        <div class="col-12 col-md-6">
                           <div class="form-group">
                              <div class="single-field select-field">
                                 <select name="status" id="status">
                                    <option <?php if (isset($list_data[0]->issue) && $list_data[0]->status == 'new') { ?> selected="selected" <?php } ?> value="new">New</option>
                                    <option <?php if (isset($list_data[0]->issue) && $list_data[0]->status == 'pending') { ?> selected="selected" <?php } ?> value="pending">Pending</option>
                                    <option <?php if (isset($list_data[0]->issue) && $list_data[0]->status == 'inprogress') { ?> selected="selected" <?php } ?> value="inprogress">Inprogress</option>
                                    <option <?php if (isset($list_data[0]->issue) && $list_data[0]->status == 'resolved') { ?> selected="selected" <?php } ?> value="resolved">Resolved</option>
                                 </select>
                                 <label>Select Status*</label>
                              </div>
                           </div>
                        </div>
                     <?php } if(!isset($get_pc_data[0]) && !isset($list_data[0]->pc_id)) { ?>
                        <div class="col-12 col-md-6 row_pc_id">
                           <div class="form-group">
                              <div class="single-field">
                                 <input type="number" class="numeric" name="add_pc_id" id="add_pc_id" min="1" value="">
                                 <label>PC ID*</label>
                              </div>
                           </div>
                        </div>
                     <?php } ?>
                     <div class="col-12  <?php if (isset($list_data[0]->issue) && $list_data[0]->issue == 'software') { ?> d-none <?php } ?>" id="hardware">
                        <div class="row">
                           <div class="col-12">
                              <label>Hardware Parts*</label>
                           </div>
                           <div class="col-12 col-sm-6 col-xl-3">
                              <label class="cms-option-box" for="h_part1"><input type="checkbox" <?php if (isset($hpart) && in_array('display', $hpart)) { ?> checked="checked" <?php } ?> name="h_parts" value="display" id="h_part1">Display</label>
                           </div>
                           <div class="col-12 col-sm-6 col-xl-3">
                              <label class="cms-option-box" for="h_part2"><input type="checkbox" <?php if (isset($hpart) && in_array('cpu', $hpart)) { ?> checked="checked" <?php } ?> name="h_parts" value="cpu" id="h_part2">CPU</label>
                           </div>
                           <div class="col-12 col-sm-6 col-xl-3">
                              <label class="cms-option-box" for="h_part3"><input type="checkbox" <?php if (isset($hpart) && in_array('keyboard', $hpart)) { ?> checked="checked" <?php } ?> name="h_parts" value="keyboard" id="h_part3">Keyboard</label>
                           </div>
                           <div class="col-12 col-sm-6 col-xl-3">
                              <label class="cms-option-box" for="h_part4"><input type="checkbox" <?php if (isset($hpart) && in_array('mouse', $hpart)) { ?> checked="checked" <?php } ?> name="h_parts" value="mouse" id="h_part4">Mouse</label>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <div class="single-field">
                              <textarea class="textarea" name="issue_description" id="issue_description"><?php if (isset($list_data[0]->description)) {
                                                                                                            echo $list_data[0]->description;
                                                                                                         } ?></textarea>
                              <label>Type Your Issue Description*</label>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 <?php if (isset($list_data[0]->issue) && $list_data[0]->issue == 'hardware') { ?> d-none <?php } elseif (!isset($list_data[0]->issue)) { echo 'd-none'; }  ?>" id="software">
                        <!-- Software -->
                        <div class="form-group candidate-resume">
                           <div class="single-field">
                              <div class="upload-text" id="upload-text">
                                 <i class="fas fa-upload text-secondary"></i>
                                 <span id="image_name">Upload Screenshot</span>
                                 <!-- <span>Upload Screenshort here</span> -->
                              </div>

                              <input type="file" class="file-upload-field" name="screenshorts[]" id="screenshorts" multiple value="">
                           </div>
                        </div>
                        <div class="col-md-6 float-right"><?php if (!empty($issue)) {
                                                               echo $issue;
                                                            } ?></div>
                     </div>
                  </div>
                  <div class="pc-issue-img-wrap" id="thum_image"></div>
               </div>
               <div class="modal-footer">
                  <button type="button" id="btn-issue_sub" class="btn sec-btn sec-btn-outline"><?php echo $page_text; ?></button>
               </div>
            </form>
         </div>
      </div>
   </div>

   <?php if ($user_role == 'admin') { ?>
      <!-- Add PC ID Modal -->
      <div class="modal" id="add-pc-id" role="dialog">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                  <div class="modal_header-content">
                     <h4 class="modal-title emp_name employee_name"><span class="title">Add</span> PC ID</h4>
                  </div>
               </div>
               <div class="modal-body">
                  <div class="preloader preloader-2" style="">
                     <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                     </svg>
                  </div>
                  <div class="alert alert-secondary text-center mb-5">
                     <h3 class="m-0">Your PC ID - <span class="idofpc"><?php if (isset($get_pc_data[0])) {
                                                                           echo $get_pc_data[0]->pc_id;
                                                                        } elseif (isset($list_data[0]->pc_id)) {
                                                                           echo $list_data[0]->pc_id;
                                                                        } ?></span> </h3>
                  </div>
                  <div class="form-group">
                     <div class="single-field select-field">
                        <select class=" emp_search1" id="emp_id" name="emp_id">
                           <option value="">All Employee</option>
                           <?php foreach ($employee_list as $n => $name) { ?>
                              <option <?php if (isset($employee_id) && !empty($employee_id) && $employee_id == $name->id) {
                                          echo "selected='selected'";
                                       } ?> value="<?php echo $name->id; ?>"><?php echo $name->fname . " " . $name->lname; ?></option>
                           <?php } ?>
                        </select>
                        <label>Select Employee</label>
                     </div>
                  </div>
                  <div class="form-group m-0">
                     <div class="single-field">
                        <input type="hidden" name="url" id="url" value="pc_issue/add">
                        <input type="number" class="numeric" name="change_pc_id" id="change_pc_id" min="1" value="">
                        <label>PC ID*</label>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" id="btn-change_id" class="btn sec-btn">Add</button>

               </div>
            </div>
         </div>
      </div>

   <?php } else { ?>

      <!-- Add PC Issue Modal -->
      <div class="modal" id="change-pc-id" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
               <div class="modal_header-content">
                  <h4 class="modal-title emp_name employee_name">Change PC Id</h4>
               </div>
            </div>
            <div class="modal-body">
            <div class="preloader preloader-2" style="">
                     <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                     </svg>
                  </div>
               <div class="alert alert-secondary text-center mb-5">
                  <h3 class="m-0">Your PC ID - <span class="idofpc"><?php if (isset($get_pc_data[0])) {
                                                                        echo $get_pc_data[0]->pc_id;
                                                                     } elseif (isset($list_data[0]->pc_id)) {
                                                                        echo $list_data[0]->pc_id;
                                                                     } ?></span> </h3>
               </div>
               <div class="form-group m-0">
                        <div class="single-field">
                            <input type="hidden" name="emp_id" id="emp_id" value="<?php echo (isset($list_data[0]->employee_id)) ? $list_data[0]->employee_id : $this->session->get('id'); ?>">
                            <input type="number" class="numeric" name="change_pc_id" id="change_pc_id" min="1" value="">
                            <label>PC ID*</label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
               <button type="button" id="btn-change_id" class="btn sec-btn sec-btn-outline">Change</button>
            </div>
         </div>
      </div>
   </div>

   <?php } ?>
   <div id="user_role" data-user_role="<?php echo $user_role; ?>"></div>