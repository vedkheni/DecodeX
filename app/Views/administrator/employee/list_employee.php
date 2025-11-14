<div id="page-wrapper">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title">Employee List</h4>
        </div>
        <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Employee</a></li>
                <li class="active">List Employees</li>
            </ol>
        </div> -->
        <!-- /.col-lg-12 -->
    </div>
   <div class="row">
      <div class="col-md-12">
         <div class="white-box m-0">
            <!-- <form class="form-horizontal form-material frm-search" method="post" action="" id="search-form">
               <div class="form-group"> 
                  <div class="error_msg"></div>
                  <div class="col-md-3 _search-form">
                      <label>Status</label>
               <select class="form-control form-control-line bor-top">
               <option value="1">Active</option>
               <option value="0">Deactive</option>
               </select>
                      <input type="date" placeholder="Form Date" class="form-control form-control-line bor-top" name="from_date" id="from_date" value="<?php // if(isset($search['from_date'])){ echo $search['from_date']; } ?>"> 
               
                  </div>
               
                  
               </div> 
               <div class="col-md-3 _search-form">
                  <div class="col-md-12 emp_">
                      <div class="col-md-6 emp_submit">
                          <input type="submit" placeholder="To Date" class="btn sec-btn pull-left emp_search"  value="Search">
                      </div>
                      <div class="col-md-6 emp_submit">
                          <input type="reset" class="btn sec-btn pull-left emp_reset"  value="Reset">
                      </div>                           
               
                  </div>
               </div>
               </form> <form class="form-horizontal form-material frm-search" method="post" action="" id="search-form"><input type="text" id="myInputTextField" name="myInputTextField"></form>
               <input id="search1" name="search1" type="hidden" value="" >-->
                <div class="emp-custom-field">
                  <div class="row">
                        <div class="col-12 text-center">
                          <div class="single-field select-field multi-field">
                             <select name="designation" id="designation">
                                <option value="" selected>All Designation</option>
                                 <?php foreach ($designation as $key => $value) { ?>
                                   <option <?php if(isset($list_data[0]->designation) && $list_data[0]->designation == $value->id){ ?> selected="selected" <?php } ?> value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>         
                                 <?php } ?>
                             </select>
                           <label>Select Designation</label>
                          </div>

                          <div class="single-field select-field multi-field">
                           <select name="emp_status" id="emp_status">
                              <option value="">All Status</option>
                              <option value="Active" selected>Active</option>
                              <option value="Deactive">Deactive</option>
                           </select>
                           <label>Select Status</label>
                          </div>
                          <button style="display: none;" class="btn btn-danger" id="btn_delete">Delete</button>
                           <a class="btn sec-btn add_new_emp pull-right" href="<?php echo base_url('employee/add'); ?>">Add New</a>
                        </div>
                     </div>
                    <hr class="custom-hr">
                </div>

            <div class="table-responsive employee-table-list">
                <div class="preloader preloader-2"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /></svg></div>
               <table id="example" class="display nowrap" style="width:100%">
                  <thead class="_empthead">
                     <tr>
                        <th> <input type="checkbox" class="delete_All_checkbox" value="All_delete"></th>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Attendance</th>
                        <th>Login</th>
                        <th>Action</th>
                        <!-- <th>Status</th> -->
                     </tr>
                  </thead>
                  <tbody class="_emptbody">
                     
                  </tbody>
                  <tfoot>
                     <tr>
                        <th><input type="checkbox" class="d-none" value=""></th>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Attendance</th>
                        <th>Login</th>
                        <th>Action</th>
                        <!-- <th>Status</th> -->
                     </tr>
                  </tfoot>
               </table>
               <!-- <table id="example" class="display" cellspacing="0" width="100%">
                  <thead class="_empthead">
                      <tr>
                  <th></th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Email</th>
                      </tr>
                  </thead>
                  <tbody class="_emptbody">
                      <a class="btn sec-btn pull-right" href="<?php //echo base_url('employee/add'); ?>">Add New</a>
                  </tbody>
                  </table> -->
            </div>
         </div>
      </div>
   </div>
</div>

<div id="submit_leave" class="modal fade employee-model" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            <div class="bg-title m-0">
               <h4 class="page-title text-center">Add Leave Request</h4>
            </div>
         </div>
         <div class="modal-body">
            <div class="white-box">
               <form class="form-horizontal">
                  <div class="form-group">
                     <label class="col-md-12">Employee*</label>
                     <div class="col-md-12">
                        <div class="dropdown">
                           <input class="form-control select-emp" type="text" data-toggle="dropdown" placeholder="Select Employee">
                           <ul class="dropdown-menu emp-list">
                              <li><label class="employee-item"><input type="checkbox" value="0"> Priti Singh</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Niranjan Prajapati</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Tarun Gudala</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Himay Jayani</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Svapanil Chaudhari</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Roshan Bichve</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Chandrakant Chhodvadiya</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Jignesha  Patel</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Puran Kumar</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Vivek Tarsariya</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Karan Rana</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Vaibhav Borkar</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Parima Khengar</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Divyang kakadiya</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Sagar S Rathod</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Dhvani Davda</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Kalpesh Rathod</label></li>
                              <li><label class="employee-item"><input type="checkbox" value="0"> Theertha Shetty</label></li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-12">Leave Date*</label>
                     <div class="col-md-12">
                        <input type="text" class="datepicker-here form-control form-control-line" data-position="top left">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-12">Leave Comment</label>
                     <div class="col-md-12">
                        <textarea class="form-control form-control-line" name="leave_commet" id="leave_commet" rows="5"></textarea>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-12">Leave Status</label>
                     <div class="col-md-12">
                        <div id="leave_status_error"></div>
                        <input type="radio" class="" name="leave_status" value="none"> None
                        <input type="radio" class="" name="leave_status" value="sick"> <span class="sick_leave_class">Sick Leave</span>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-12">Status</label>
                     <div class="col-md-12">
                        <input type="radio" class="" name="status" value="approved"> Approve Leave
                        <input type="radio" class="" name="status" value="rejected"> Reject Leave
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <div class="modal-footer">
            <button class="btn btn-success" data-dismiss="modal">Add</button>
         </div>
      </div>
   </div>
</div>
<script>
   $(document).ready(function() {
     $('#multiselect').multiselect({
       buttonWidth : '160px',
       includeSelectAllOption : true,
           nonSelectedText: 'Select Song'
     });
   });
   
   function getSelectedValues() {
     var selectedVal = $("#multiselect").val();
       for(var i=0; i<selectedVal.length; i++){
           function innerFunc(i) {
               setTimeout(function() {
                   location.href = selectedVal[i];
               }, i*2000);
           }
           innerFunc(i);
       }
   }
   /*   $(document).ready(function(){
       $(document).on('click',".status",function(){
           // var id = $(this).data('sid');
           // console.log('#status'+id);
           var text = $(this).text();
           if(text == "Active"){
               $(this).text('Deactive');
           }
           else{
               $(this).text('Active');
           }
           // alert(id);
   
           // $('#status'+id).text("Deactive");
       });
   }); */
</script>