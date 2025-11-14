<?php
$page_text = "Add";
if (isset($list_data[0]->id) && !empty($list_data[0]->id)) {
    $page_text = "Update";
} else {
    $page_text = "Add";
}
$user_session = $this->session->get('id');
$user_role = $this->session->get('user_role');
$leaveType = array('Sick', 'Festival', 'Engagement', 'Marriage',  'Maternity', 'Family Events', 'Bereavement', 'General');
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <h4 class="page-title">List Leave Request</h4>
            </div>
            <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
         <ol class="breadcrumb">
             <li><a href="#">Leave Request</a></li>
             <li class="active">List Leave Request</li>
         </ol>
         </div> -->
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box m-0">

                    <?php $user_role = $this->session->get('user_role');
                    if ($user_role != "admin") {
                        if (isset($paid_leave)) {
                            //echo count($paid_leave);
                        }
                        if (isset($sick_leave)) {
                            //echo count($sick_leave);
                        }
                    }
                    //print_r($get_employee_list);
                    ?>
                    <?php $user_role = $this->session->get('user_role');
                    if ($user_role == 'admin') { ?>
                        <div class="emp-custom-field">
                            <form class="frm-search bonus-search-form text-center" method="post" action="<?php echo base_url("leave_request"); ?>" id="bonus-form">
                                <!-- <div class="error_msg"></div> -->
                                <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />

                                <div class="single-field select-field multi-field _search-form">
                                    <select class=" emp_search1" id="employee_id" name="employee_id">
                                        <option value="">All Employee</option>
                                        <?php foreach ($get_employee_list as $n => $name) { ?>
                                            <option <?php if (isset($employee_id) && !empty($employee_id) && $employee_id == $name->id) {
                                                        echo "selected='selected'";
                                                    } ?> value="<?php echo $name->id; ?>"><?php echo $name->fname . " " . $name->lname; ?></option>
                                        <?php } ?>
                                    </select>
                                    <label>Select Employee</label>
                                </div>

                                <div class="single-field select-field multi-field _search-form">
                                    <select class="emp_search1" id="select_month" name="select_month">
                                        <option value="">All Month</option>
                                        <?php foreach (MONTH_NAME as $k => $v) { ?>
                                            <option <?php if (date('m') == $k + 1) {
                                                        echo "selected='selected'";
                                                    } ?> value="<?php echo $k + 1; ?>"><?php echo $v; ?></option>
                                            <!-- <option  <?php // if(isset($select_month) && $select_month == $k+1){ echo "selected='selected'"; } 
                                                            ?> value="<?php echo $k + 1; ?>"><?php echo $v; ?></option> -->
                                        <?php } ?>
                                    </select>
                                    <label>Select Month</label>
                                </div>

                                <div class="single-field select-field multi-field _search-form">
                                    <select class="emp_search1" id="select_year" name="select_year">
                                        <option value="">All Year</option>
                                        <?php $next_year = date('Y', strtotime('+1 year'));
                                        for ($i = 2018; $i <= $next_year; $i++) { ?>
                                            <option <?php if (date('Y') == $i) {
                                                        echo "selected='selected'";
                                                    } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <!-- <option <?php //if(isset($select_year) && $select_year == $i){ echo "selected='selected'"; } 
                                                            ?> value="<?php echo $i; ?>"><?php echo $i; ?></option> -->
                                        <?php } ?>
                                    </select>
                                    <label>Select Year</label>
                                </div>

                                <div class="single-field select-field multi-field _search-form">
                                    <select class="emp_search1" id="select_leave" name="select_leave">
                                        <option value="" disabled>Select Leave</option>
                                        <option value="upcoming">Upcoming Leave</option>
                                        <option value="recent">Recent Leave</option>
                                    </select>
                                    <label>Select Leave</label>
                                </div>
                                <button class="btn sec-btn add_attendance" data-toggle="modal" data-target="#myModal">Add Leave Request</button>
                                <button type="button" class="btn btn-danger" style="display: none;" id="button_delete">Delete</button>
                                <!-- <a class="btn sec-btn add_attendance" href="<?php // echo base_url('leave_request/add'); 
                                                                                    ?>">Add Leave Request</a> -->
                                <button type="button" class="btn sec-btn btn-open-desig d-none" data-toggle="modal" data-target="#myModal">Add New</button>


                                <!-- <div class="col-md-6 _search-form">
                  <div class="col-md-12 emp_ p-0">
                    <div class="emp_submit">
                        <input type="submit"  class="btn sec-btn pull-left emp_search"  value="Submit">
                    </div>
                    <div class="emp_submit">
                        <input type="reset" class="btn btn-grey sec-btn pull-left emp_reset"  value="Reset">
                    </div>                           
                  
                  </div>
                  </div> -->
                            </form>
                            <hr class="custom-hr">
                        </div>

                    <?php }
                    if ($user_role != 'admin') { ?>
                        <div class="col-12 text-center">
                            <input type="hidden" name="employee_id" id="employee_id" value="<?php if (isset($list_data[0]->id)) { echo $list_data[0]->id; } ?>">
                            <button class="btn sec-btn add_attendance" data-toggle="modal" data-target="#myModal">Add Leave Request</button>
                            <button type="button" class="btn btn-danger" style="display: none;" id="button_delete">Delete</button>
                            <button type="button" class="btn sec-btn btn-open-desig d-none" data-toggle="modal" data-target="#myModal">Add New</button>
                        </div>
                        <hr class="custom-hr">
                    <?php } ?>


                    <div class="leave_list">
                        <!-- <div class="js_error text-center"></div> -->
                        <?php if ($user_role == "admin") { ?>
                            <div class="single-field select-field mb-custom-tab" onclick="$(this).toggleClass('active');">
                                <span class="mb-custom-tab-active">Pending Leave</span>
                                <ul class="mb-tab-list">
                                    <li class="nav-item list_tab">
                                        <a class="nav-link active" id="pills-pending-tab" onclick=" $('span.mb-custom-tab-active').text($(this).text());" data-toggle="pill" href="#pills-pending" role="tab" aria-controls="pills-pending" aria-selected="true">Pending Leave</a>
                                    </li>
                                    <li class="nav-item list_tab">
                                        <a class="nav-link " id="pills-reject-tab" onclick=" $('span.mb-custom-tab-active').text($(this).text());" data-toggle="pill" href="#pills-reject" role="tab" aria-controls="pills-reject" aria-selected="false">Rejected Leave</a>
                                    </li>
                                    <li class="nav-item list_tab">
                                        <a class="nav-link" id="pills-approve-tab" onclick=" $('span.mb-custom-tab-active').text($(this).text());" data-toggle="pill" href="#pills-approve" role="tab" aria-controls="pills-approve" aria-selected="false">Approved Leave</a>
                                    </li>
                                </ul>
                            </div>
                            <ul class="nav nav-tabs lg-custom-tabs" id="myTab" role="tablist">
                                <li class="nav-item list_tab">
                                    <a class="nav-link active" id="pills-pending-tab" data-toggle="pill" href="#pills-pending" role="tab" aria-controls="pills-pending" aria-selected="true">Pending Leave</a>
                                </li>
                                <li class="nav-item list_tab">
                                    <a class="nav-link " id="pills-reject-tab" data-toggle="pill" href="#pills-reject" role="tab" aria-controls="pills-reject" aria-selected="false">Rejected Leave</a>
                                </li>
                                <li class="nav-item list_tab">
                                    <a class="nav-link" id="pills-approve-tab" data-toggle="pill" href="#pills-approve" role="tab" aria-controls="pills-approve" aria-selected="false">Approved Leave</a>
                                </li>
                            </ul>
                            <div class="tab-content employee-table-list" id="myTabContent">
                                <div class="preloader preloader-2" style="display:none"><svg class="circular" viewBox="25 25 50 50">
                                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                                    </svg></div>
                                <div class="tab-pane fade show active" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab">
                                    <div class="table-responsive">
                                        <!-- <a class="btn sec-btn pull-right" href="<?php //echo base_url('designation/add'); 
                                                                                        ?>" style="margin:10px;">Add New</a> -->
                                        <!-- <h4 class="page-title">Pending Leave Request</h4> -->
                                        <table id="example_admin-pending" class="display nowrap  datatable-accordion" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Leave Date</th>
                                                    <!-- <th>Comment</th>-->
                                                    <th>Leave Status</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-reject" role="tabpanel" aria-labelledby="pills-reject-tab">
                                    <div class="table-responsive">
                                        <!-- <h4 class="page-title">Reject Leave Request</h4> -->
                                        <table id="example_admin-rejected" class="display nowrap  datatable-accordion" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Leave Date</th>
                                                    <!-- <th>Comment</th>-->
                                                    <th>Leave Status</th>
                                                    <!-- <th>Status</th> -->
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-approve" role="tabpanel" aria-labelledby="pills-approve-tab">
                                    <div class="table-responsive">
                                        <!-- <h4 class="page-title">Approve Leave Request</h4> -->
                                        <table id="example_admin-approved" class="display nowrap datatable-accordion" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Leave Date</th>
                                                    <!-- <th>Comment</th>-->
                                                    <th>Leave Status</th>
                                                    <!-- <th>Status</th> -->
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="table-responsive">
               /*<a class="btn sec-btn pull-right" href="<?php //echo base_url('designation/add'); 
                                                            ?>" style="margin:10px;">Add New</a> 
               <h4 class="page-title">Leave Request</h4>*/
               <table id="example" class="display nowrap" style="width:100%">
               <thead>
                          <tr>
                              <th>#</th>
               <th>Name</th>
                              <th>Leave Date</th>
                              /*<th>Comment</th>*/
               <th>Leave Status</th>
               <th>Action</th>
               <th>Status</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
               </table>
               </div>    -->
                        <?php } else { ?>
                            <div class="single-field select-field mb-custom-tab" onclick="$(this).toggleClass('active');">
                                <span class="mb-custom-tab-active">Pending Leave</span>
                                <ul class="mb-tab-list">
                                    <li class="nav-item list_tab">
                                        <a class="nav-link active " id="pills-pending-tab" onclick=" $('span.mb-custom-tab-active').text($(this).text());" data-toggle="pill" href="#pills-pending" role="tab" aria-controls="pills-pending" aria-selected="true">Pending Leave</a>
                                    </li>
                                    <li class="nav-item list_tab">
                                        <a class="nav-link " id="pills-reject-tab" onclick=" $('span.mb-custom-tab-active').text($(this).text());" data-toggle="pill" href="#pills-reject" role="tab" aria-controls="pills-reject" aria-selected="false">Rejected Leave</a>
                                    </li>
                                    <li class="nav-item list_tab">
                                        <a class="nav-link " id="pills-approve-tab" onclick=" $('span.mb-custom-tab-active').text($(this).text());" data-toggle="pill" href="#pills-approve" role="tab" aria-controls="pills-approve" aria-selected="false">Approved Leave</a>
                                    </li>
                                </ul>
                            </div>
                            <ul class="nav nav-tabs lg-custom-tabs" id="myTab" role="tablist">
                                <li class="nav-item list_tab">
                                    <a class="nav-link active " id="pills-pending-tab" data-toggle="pill" href="#pills-pending" role="tab" aria-controls="pills-pending" aria-selected="true">Pending Leave</a>
                                </li>
                                <li class="nav-item list_tab">
                                    <a class="nav-link " id="pills-reject-tab" data-toggle="pill" href="#pills-reject" role="tab" aria-controls="pills-reject" aria-selected="false">Rejected Leave</a>
                                </li>
                                <li class="nav-item list_tab">
                                    <a class="nav-link " id="pills-approve-tab" data-toggle="pill" href="#pills-approve" role="tab" aria-controls="pills-approve" aria-selected="false">Approved Leave</a>
                                </li>
                            </ul>
                            <div class="tab-content employee-table-list" id="myTabContent">
                                <div class="preloader preloader-2" style="display:none"><svg class="circular" viewBox="25 25 50 50">
                                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                                    </svg></div>
                                <div class="tab-pane fade show active" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab">
                                    <div class="table-responsive">
                                        <!-- <a class="btn sec-btn pull-right" href="<?php //echo base_url('designation/add'); 
                                                                                        ?>" style="margin:10px;">Add New</a> -->
                                        <!-- <h4 class="page-title">Pending Leave Request</h4> -->
                                        <table id="example-pending" class="display nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>#</th>
                                                    <!-- <th>Name</th> -->
                                                    <th>Leave Date</th>
                                                    <!-- <th>Comment</th>-->
                                                    <th>Leave Status</th>
                                                    <!-- <th>Status</th> -->
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-reject" role="tabpanel" aria-labelledby="pills-reject-tab">
                                    <div class="table-responsive">
                                        <!-- <h4 class="page-title">Reject Leave Request</h4> -->
                                        <table id="example-rejected" class="display nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <!-- <th>Name</th> -->
                                                    <th>Leave Date</th>
                                                    <!-- <th>Comment</th>-->
                                                    <th>Leave Status</th>
                                                    <!-- <th>Status</th> -->
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-approve" role="tabpanel" aria-labelledby="pills-approve-tab">
                                    <div class="table-responsive">
                                        <!-- <h4 class="page-title">Approve Leave Request</h4> -->
                                        <table id="example-approved" class="display nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <!-- <th>Name</th> -->
                                                    <th>Leave Date</th>
                                                    <!-- <th>Comment</th>-->
                                                    <th>Leave Status</th>
                                                    <!-- <th>Status</th> -->
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="button" style="display: none;" class="btn sec-btn btn-theme-dark pull-left add_leave_modal" value="Add Leave" data-toggle="modal" data-target="#submit_leave">

    <!-- Add & Update Designation Modal -->
    <div class="modal" id="myModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    <div class="modal_header">
                        <h4 class="modal-title emp_name employee_name">Add Leave Request</h4>
                    </div>
                </div>
                <div class="modal-body">
                    <!-- <div class="col-xl-6 col-lg-8 col-md-8 col-12">     -->
                    <?php if ($user_role != "admin") { ?>
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <div class="analytics-info">
                                    <h3 class="title">Used Paid Leave</h3>
                                    <h3 class="counter" id="usedPaidLeaveCount" data-count="<?php if (isset($leave_count)) {
                                                                                                echo $leave_count['paid_leave'];
                                                                                            } ?>">
                                        <?php if (isset($leave_count)) {
                                            echo $leave_count['paid_leave'];
                                        } ?>
                                    </h3>
                                </div>
                            </div>

                            <!-- <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="analytics-info">
                            <h3 class="title">Used Sick Leaves</h3>
                                <h3 class="counter">
								<?php // if(isset($leave_count)){
                                // echo $leave_count['sick_leave'];
                                //} 
                                ?></h3>
                        </div>
                    </div> -->

                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <div class="analytics-info">
                                    <h3 class="title">Remaining Paid Leaves</h3>
                                    <h3 class="counter" id="unusedPaidLeaveCount" data-count="<?php if (isset($leave_count)) {
                                                                                                    echo $leave_count['remaing_paid_leave'];
                                                                                                } ?>">
                                        <?php if (isset($leave_count)) {
                                            echo $leave_count['remaing_paid_leave'];
                                        } ?></h3>
                                </div>
                            </div>
                            <!-- <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="analytics-info">
                            <h3 class="title">Remaining Sick Leaves</h3>
                                <h3 class="counter"><?php // if(isset($leave_count)){
                                                    // echo $leave_count['remaing_sick_leave'];
                                                    //} 
                                                    ?></h3>
                        </div>
                    </div> -->
                        </div>
                    <?php } else { ?>
                        <div class="html_leave "></div>
                    <?php } ?>
                    <div class="massge_for_error text-center"><?php echo $this->session->getFlashdata('message'); ?> <?php echo $this->session->getFlashdata('message1'); ?></div>

                    <form class="form-horizontal form-material" method="post" action="<?php echo base_url('leave_request/insert_data'); ?>" id="leave-form">
                        <input type="hidden" name="e_id" id="e_id" value="<?php if (isset($list_data[0]->id)) {
                                                                                echo $list_data[0]->id;
                                                                            } ?>">
                        <input type="hidden" name="type" id="type" value="ajax">
                        <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
                        <?php // echo "<pre>"; print_r($list_data); echo "</pre>"; 

                        if ($user_role == "admin") { ?>
                            <div class="form-group">
                                <div class="single-field select-field">
                                    <select name="employee_select" id="employee_select">
                                        <option value="" disabled>Select Employee</option>
                                        <?php foreach ($all_employees as $emp) { ?>
                                            <option <?php if (isset($list_data[0]->id) && $list_data[0]->id == $emp->id) {
                                                        echo "selected='selected'";
                                                    } ?> value="<?php echo $emp->id; ?>"><?php echo $emp->fname . " " . $emp->lname; ?></option>
                                        <?php } ?>
                                    </select>
                                    <label>Select Employee*</label>
                                </div>
                            </div>
                        <?php } else { ?>
                            <input type="hidden" name="employee_select" id="employee_select" value=<?php echo $this->session->get('id'); ?>>
                        <?php } ?>
                        <div class="form-group">
                            <div class="single-field date-field">
                                <input type="text" class="datepicker-here multiple_date" data-language="en" data-role='<?php echo $user_role; ?>' data-date="<?php if (isset($list_data[0]->leave_date)) {
                                                                                                                                                                    echo $list_data[0]->leave_date;
                                                                                                                                                                } ?>" <?php if (!isset($list_data[0]->leave_date)) {
                                                                                                                                                                                                                                                    echo 'data-multiple-dates="100"';
                                                                                                                                                                                                                                                } ?> name="leave_date" id="leave_date" data-multiple-dates-separator=" , " autocomplete="off" value="<?php if (isset($list_data[0]->leave_date)) {
                                                                                                                                                                                                                                                                                                                                                                                                                                        echo $list_data[0]->leave_date;
                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?>" />
                                <label>Select Leave Date*</label>
                            </div>
                        </div>
                        <input id="edit_date" type="hidden" name="old_leave_date" value="<?php if (isset($list_data[0]->leave_date)) {
                                                                                                echo $list_data[0]->leave_date;
                                                                                            } ?>">
                        <div class="form-group">
                            <div class="single-field select-field">
                                <select name="leave_status" id="leave_status">
                                    <option value="" disabled>Leave Type</option>
                                    <?php foreach ($leaveType as $type) { $list_data_leave_status = isset($list_data[0]->leave_status) ? $list_data[0]->leave_status : '' ?>
                                        <option <?php if (isset($type) && $type == $list_data_leave_status) {
                                                    echo "selected='selected'";
                                                } elseif ($type == 'General' && $list_data_leave_status == 'none') {
                                                    echo "selected='selected'";
                                                } ?> value="<?php echo $type; ?>"><?php echo $type . ' Leave'; ?></option>
                                    <?php } ?>
                                </select>
                                <label>Leave Type*</label>
                            </div>
                        </div>
                        <div class="form-group <?php if ($user_role != "admin") { echo 'd-none'; } ?>">
                            <label class="d-block">
                                <input type="checkbox" class="add-comment" name="add_comment" value="true" <?php if ($user_role != "admin") { echo 'checked="checked"'; } ?>> Add Comment
                            </label>
                        </div>
                        <div class="form-group <?php if ($user_role == "admin") { echo 'leave-commet-box d-none'; } ?>">
                            <div class="single-field">
                                <textarea name="leave_commet" id="leave_commet" rows="5"><?php if (isset($list_data[0]->comment)) { echo $list_data[0]->comment; } ?></textarea>
                                <label>Leave Comment</label>
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-md-6 col-xs-12"> -->
                            <!-- </div> -->

                            <?php if ($user_role == "admin") { ?>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group form-radio">
                                        <label class="form-radio-labe">Leave Status</label>
                                        <label class="form-radio-label"><input type="radio" <?php if (isset($list_data[0]->status) && $list_data[0]->status == 'approved') { echo 'checked="checked"'; } ?> class="" name="status" id="status_approve" value="approved"> Approve Leave </label>
                                        <label class="form-radio-label"><input type="radio" <?php if (isset($list_data[0]->status) && $list_data[0]->status == 'rejected') { echo 'checked="checked"'; } ?> class="" name="status" id="status_reject" value="rejected"> Reject Leave </label>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <input type="hidden" name="status" id="status" value="<?php if (!isset($list_data[0]->status) && empty($list_data[0]->status)) { echo "pending"; } ?>">
                            <?php } ?>
                        </div>
                </div>
                <input type="hidden" id="edit_leave_status" value="<?php if (isset($list_data) && isset($list_data[0]->leave_status)) {
                                                                        echo $list_data[0]->leave_status;
                                                                    } ?>">
                <div class="modal-footer justify-content-center">
                    <div class="row w-100">
                        <div class="col-12 p-0 text-right">
                            <button class="btn sec-btn-outline submit_form"><?php echo $page_text; ?></button>
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>

    <div id="view_leave_reason" class="modal employee-model">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                    <div class="modal-header-content">
                        <h4 class="modal-title emp_name h5-emp-name"><span id="leaveDate"></span> Leave Reason</h4>
                    </div>
                </div>
                <form class="form-horizontal form-material" method="Post" id="edit_employee_attendance-form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="text-center m-0" id="leaveType">Leave Reason</h3>
                                <div class="whiteSpace-break" id="view_reason"></div>
                                <!-- <small class="work-info">Note: kindly mention your today completed work <span data-tooltip=" - For example today I have worked on these given tasks (mention tasks name)."><i class="fas fa-eye"></i></span></small> -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            if (getUrlVars().action == 'add_leave' && getUrlVars().id != '') {
                $.each($('#employee_select option'), function() {
                    if ($(this).val() == getUrlVars().id) {
                        $(this).attr('selected', true);
                    }
                });
                $('#myModal').modal('show');
            }

            function getUrlVars() {
                var vars = [],
                    hash;
                var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                for (var i = 0; i < hashes.length; i++) {
                    hash = hashes[i].split('=');
                    vars.push(hash[0]);
                    vars[hash[0]] = hash[1];
                }
                return vars;
            }
            employee_select('#employee_select');
        });

        $('a.nav-link').click(function() {
            $('span.mb-custom-tab-active').text($(this).text());
            var id = $(this).attr('aria-controls');
            $('.tab-pane.fade').removeClass('show active');
            $('a').removeClass('active');
            $(this).addClass('active');
            var $this = $(this).text();
            $.each($('a.nav-link'), function() {
                if ($(this).text() == $this) {
                    $(this).addClass('active');
                    $(this).parent().addClass('active');
                }
            });
            $(this).parent().removeClass('active');
            $('#' + id).addClass('show');
        });

        $(document).on('change', '#employee_select', function() {
            var $this = this;
            employee_select($this);
        });

        function employee_select($this) {
            var base_url = $("#js_data").attr("data-base-url");
            var id = $($this).val();
            var edit_leave_status = $("#edit_leave_status").val();

            var data = {
                'employee_id': id,
            };
            $.ajax({
                url: base_url + "leave_request/leave_count",
                type: "post",
                data: data,
                success: function(response) {

                    var obj = jQuery.parseJSON(response);
                    console.log(obj);
                    var remaing_sick_leave = obj.remaing_sick_leave;
                    var this_month_paid_leave = obj.remaing_paid_leave;
                    var paid_leave = obj.paid_leave;
                    var sick_leave = obj.sick_leave;
                    //   console.log(remaing_sick_leave+" - "+this_month_paid_leave+" - "+paid_leave);
                    $('#usedPaidLeaveCount').text(paid_leave);
                    $('#unusedPaidLeaveCount').text(this_month_paid_leave);

                    $('#usedPaidLeaveCount').attr('data-count', paid_leave);
                    $('#unusedPaidLeaveCount').attr('data-count', this_month_paid_leave);

                    if (remaing_sick_leave == "0") {
                        $(".sick_leave_class").hide();
                        $("#leave_status_sick").hide();
                    } else {
                        $(".sick_leave_class").show();
                        $("#leave_status_sick").show();
                    }
                    if (this_month_paid_leave == "0") {
                        $(".paid_leave_class").hide();
                        $("#leave_status_paid").hide();
                    } else {
                        $(".paid_leave_class").show();
                        $("#leave_status_paid").show();
                    }
                    if (edit_leave_status != "") {
                        if (edit_leave_status == "paid") {
                            $(".paid_leave_class").show();
                            $("#leave_status_paid").show();
                        } else {
                            $(".paid_leave_class").hide();
                            $("#leave_status_paid").hide();
                        }
                    }
                    var leave_html = "";
                    leave_html += '<div class="row"> <div class="col-lg-6 col-md-6 col-xs-12"><div class="analytics-info"><h3 class="title">Used Paid Leave</h3><h3 class="counter" id="usedPaidLeaveCount" data-count="' + paid_leave + '">' + paid_leave + '</h3></div></div>';
                    leave_html += '<div class="col-lg-6 col-md-6 col-xs-12"><div class="analytics-info"><h3 class="title">Remaining Paid Leaves</h3><h3 class="counter" id="unusedPaidLeaveCount" data-count="' + this_month_paid_leave + '">' + this_month_paid_leave + '</h3></div></div></div>';
                    //   leave_html +='<div class="col-lg-6 col-md-6 col-xs-12"><div class="analytics-info"><h3 class="title">Used sick Leave</h3><h3 class="counter">'+sick_leave+'</h3></div></div></div>';
                    //   leave_html +='<div class="row"> <div class="col-lg-6 col-md-6 col-xs-12"><div class="analytics-info"><h3 class="title">Remaining Paid Leaves</h3><h3 class="counter">'+this_month_paid_leave+'</h3></div></div>';
                    //   leave_html +='<div class="col-lg-6 col-md-6 col-xs-12"><div class="analytics-info"><h3 class="title">Remaining sick Leaves</h3><h3 class="counter">'+remaing_sick_leave+'</h3></div></div></div>';
                    $(".html_leave").html(leave_html);
                },
            });
            //console.log(id+" "+month+" "+year);
            //alert("sdsd");
        }

        function viewLeaveReason(id) {
            $('#leaveDate').html('');
            $('#view_reason').html('<p class="no-data">Data not available!</p>');
            var data = {
                'id': id,
            };
            $.ajax({
                url: base_url + "leave_request/view_leave_reason",
                type: "post",
                data: data,
                success: function(response) {
                    var obj = jQuery.parseJSON(response);
                    $('#leaveDate').html(GetFormattedDate(obj.leave_detail[0].leave_date));
                    $('#leaveType').html((obj.leave_detail[0].leave_status == '') ? 'General Leave' : obj.leave_detail[0].leave_status + ' Leave');
                    $('#view_reason').html((obj.leave_detail[0].comment == '') ? '<p class="no-data">Data not available!</p>' : obj.leave_detail[0].comment);
                    $('#view_leave_reason').modal('show');
                },
            });
        }
    </script>