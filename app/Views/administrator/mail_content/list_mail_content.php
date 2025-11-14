<?php $user_id = $this->session->get('id'); ?>
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-12 col-md-12 col-xs-12">
         <h4 class="page-title">Mail Content List</h4>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="white-box m-0">
            <div class="emp-custom-field">
               <div class="row">
                  <div class="col-12 text-center">
                     <!-- <div class="single-field multi-field select-field _search-form">
                        <select id="schedule_type" name="schedule_type">
                           <option value="" disabled="">Select Schedule Type</option>
                           <option value="all_candidate">All Candidate</option>
                           <option value="pending">Pending Schedule</option>
                           <option value="fixed">Fixed Schedule</option>
                        </select>
                        <label>Select Schedule Type</label>
                     </div> -->
                     <button type="button" class="btn sec-btn btn-open-desig" onclick="reset_form();" data-toggle="modal" data-target="#myModal">Add New</button>
                     <button type="button" class="d-none edit_modal" data-toggle="modal" data-target="#myModal"></button>
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
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Action</th>
                        <!-- <th>Status</th> -->
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                     <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Action</th>
                     </tr>
                  </tfoot>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal in" id="myModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <div class="modal_header">
                <h4 class="modal-title emp_name employee_name">Mail Content</h4>
            </div>
        </div>
        <form method="POST" enctype="multipart/form-data" action="<?php base_url('candidate/send_mail'); ?>" id="update_mail_content-form">
            <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="slug" id="slug" value="">
            <div class="modal-body">
                <input type="hidden" name="e_id" id="e_id" value="">
                                <input type="hidden" name="csrf_test_name" value="">
                <div class="form-group">
                    <div class="single-field">
                        <input type="text" name="name" id="name" value="">
                        <label for="name">Name*</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="single-field">
                        <input type="text" name="mail_slug" id="mail_slug" value="">
                        <label>Slug*</label>
                    </div>
                </div>
                <div class="form-group m-0">
                    <div class="single-field">
                        <textarea class="textarea" name="mail_content" id="mail_content"></textarea>
                        <script>
                           CKEDITOR.replace('mail_content');
                        </script>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <div class="row w-100">
                    <div class="col-12 p-0 text-right">
                        <button type="button" class="btn sec-btn mail_content">Add</button>
                    </div>
                </div>
            </div>
         </form>
      </div>
   </div>
</div>
   <script>

   </script>