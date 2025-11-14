<?php $user_id = $this->session->get('id'); ?>
<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title">Broadcast Message</h4>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="white-box m-0">
               <div class="emp-custom-field">
                  <div class="row">
                     <div class="col-12 text-center">
                        <button type="button" class="btn sec-btn btn-open-desig" onclick="reset_form();" data-toggle="modal" data-target="#broadcastMessageModal">Add New</button>
                        <button type="button" class="d-none edit_modal" data-toggle="modal" data-target="#broadcastMessageModal"></button>
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
                  <table id="broadcastMessageTable" class="display nowrap" style="width:100%">
                     <thead class="_empthead">
                        <tr>
                           <th>#</th>
                           <th>Title</th>
                           <th>Event Date</th>
                           <th>Message</th>
                           <th>Expiry</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                     </tbody>
                     <tfoot>
                        <tr>
                           <th>#</th>
                           <th>Title</th>
                           <th>Event Date</th>
                           <th>Message</th>
                           <th>Expiry</th>
                           <th>Action</th>
                        </tr>
                     </tfoot>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="modal in" id="broadcastMessageModal" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
               <div class="modal_header">
                  <h4 class="modal-title emp_name employee_name">Broadcast Message</h4>
               </div>
            </div>
            <form method="POST" enctype="multipart/form-data" action="<?php base_url('broadcast/addMessage'); ?>" class="updateBroadcastMessage-form" id="updateBroadcastMessage-form">
               <input type="hidden" name="id" id="id" value="">
               <div class="modal-body">
                  <input type="hidden" name="e_id" id="e_id" value="">
                  <div class="form-group">
                     <div class="single-field">
                        <input type="text" name="title" id="title" value="">
                        <label for="title">Title*</label>
                     </div>
                  </div>
                  <div class="form-group candidate-resume">
                     <div class="single-field">
                        <div class="upload-text" id="upload-text">
                           <i class="fas fa-upload text-secondary"></i>
                           <span>Upload attachment here</span>
                        </div>
                        <input type="file" class="file-upload-field" name="attachment" id="attachment" onchange="getFileData(this)" value="">
                        <input type="hidden" name="upload_attachment" id="upload_attachment" value="">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="single-field date-field">
                        <input type="text" name="eventDate" id="eventDate" autocomplete="off" value="">
                        <label for="eventDate">Event Date*</label>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="single-field date-field">
                        <input type="text" name="expiryDate" id="expiryDate" autocomplete="off" value="">
                        <label for="expiryDate">Expiry Date*</label>
                     </div>
                  </div>
                  <div class="form-group m-0">
                     <div class="single-field">
                        <textarea class="textarea" name="broadcastMessage" id="broadcastMessage"></textarea>
                        <!-- <script>
                        CKEDITOR.replace('mail_content');
                     </script> -->
                        <label for="broadcastMessage">Broadcast Message*</label>
                     </div>
                  </div>
               </div>
               <div class="modal-footer justify-content-center">
                  <div class="row w-100">
                     <div class="col-12 p-0 text-right">
                        <button type="submit" class="btn sec-btn broadcastMessage">Add</button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>

   <div class="modal" id="view_message" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
               <div class="modal_header-content">
                  <h4 class="modal-title emp_name employee_name">View Message</h4>
               </div>
            </div>
            <div class="modal-body">
               <p id='full_message'></p>
            </div>
         </div>
      </div>
   </div>
   <script>
      function viewMessage($this) {
         $('.preloader-2').attr('style', 'display:block !important');
         var message = $this.data('message');
         $('#full_message').text(message);
         $('#view_message').modal('show');
         $('.preloader-2').attr('style', 'display:none !important');
      }
   </script>