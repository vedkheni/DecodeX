<?php $user_id = $this->session->userdata('id'); ?>
<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title">Mail Content</h4>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="white-box m-0">
               <div class="tabbtn">
                  <div class="preloader preloader-2 report_preloader1" style="display:none !important;">
                     <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                     </svg>
                  </div>
                  <ul class="nav nav-tabs lg-custom-tabs" id="myTab" role="tablist">
                     <li class="nav-item active">
                        <a class="nav-link active" id="birthday-content-tab" data-toggle="tab" href="#birthday-content" role="tab" aria-controls="birthday-content" aria-selected="true">Birthday Content</a>  
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="welcome-content-tab" data-toggle="tab" href="#welcome-content" role="tab" aria-controls="welcome-content" aria-selected="true">Welcome content</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="salarypay-content-tab" data-toggle="tab" href="#salarypay-content" role="tab" aria-controls="salarypay-content" aria-selected="true">Salary Pay Content</a>
                     </li>
                     <!-- <li class="nav-item">
                        <a class="nav-link" id="salary-increment-content-tab" data-toggle="tab" href="#salary-increment-content" role="tab" aria-controls="salary-increment-content" aria-selected="true">Salary Increment content</a>
                     </li> -->
                  </ul>     
                  <div class="tab-content myTabContent1" id="myTabContent">
                     <div id="birthday-content" class="tab-pane fade in show active" role="tabpanel" aria-labelledby="birthday-content-tab">
                        <p>Birthday Content</p>
                        <form id="profile_image_change" enctype="multipart/form-data" method="post" action="<?php echo base_url('mail_content/update_team') ?>">
                           <?php
                           $csrf = array(
                              'name' => $this->security->get_csrf_token_name(),
                              'hash' => $this->security->get_csrf_hash()
                           );
                           ?>
                           <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                           <input type="hidden" name="id" value="<?= $csrf['hash']; ?>" />
                           <div class="user-content">
                              <div class="info-content p-0">
                                 <div class="form-group">
                                    <div class="single-field">
                                       <textarea class="textarea" name="birthday_content" id="birthday_content"><?php if (isset($mail_content) && !empty($mail_content[0]->description)) { echo $mail_content[0]->description; } ?></textarea>
                                       <script>
                                          CKEDITOR.replace('birthday_content');
                                       </script>
                                    </div>
                                 </div>
                                 <button type="button" class="btn sec-btn text-right update_mail_content">Update</button>
                              </div>
                           </div>
                        </form>
                     </div>
                     <div id="welcome-content" class="tab-pane fade in" role="tabpanel" aria-labelledby="welcome-content-tab">
                        <p>Welcome Content</p>
                        <form id="profile_image_change" enctype="multipart/form-data" method="post" action="<?php echo base_url('mail_content/update_team') ?>">
                           <?php
                           $csrf = array(
                              'name' => $this->security->get_csrf_token_name(),
                              'hash' => $this->security->get_csrf_hash()
                           );
                           ?>
                           <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                           <input type="hidden" name="id" value="<?= $csrf['hash']; ?>" />
                           <div class="user-content">
                              <div class="info-content p-0">
                                 <div class="form-group">
                                    <div class="single-field">
                                       <textarea class="textarea" name="welcome_content" id="welcome_content"><?php if (isset($mail_content) && !empty($mail_content[0]->description)) { echo $mail_content[0]->description; } ?></textarea>
                                       <script>
                                          CKEDITOR.replace('welcome_content');
                                       </script>
                                    </div>
                                 </div>
                                 <button type="button" class="btn sec-btn text-right update_mail_content">Update</button>
                              </div>
                           </div>
                        </form>
                     </div>
                     <div id="salarypay-content" class="tab-pane fade" role="tabpanel" aria-labelledby="salarypay-content-tab">
                        <p>Salary Pay Content</p>
                        <form id="profile_image_change" enctype="multipart/form-data" method="post" action="<?php echo base_url('mail_content/update_team') ?>">
                           <?php
                           $csrf = array(
                              'name' => $this->security->get_csrf_token_name(),
                              'hash' => $this->security->get_csrf_hash()
                           );
                           ?>
                           <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                           <input type="hidden" name="id" value="<?= $csrf['hash']; ?>" />
                           <div class="user-content">
                              <div class="info-content p-0">
                                 <div class="form-group">
                                    <div class="single-field">
                                       <textarea class="textarea" name="salary_pay_content" id="salary_pay_content"><?php if (isset($mail_content) && !empty($mail_content[0]->description)) { echo $mail_content[0]->description; } ?></textarea>
                                       <script>
                                          CKEDITOR.replace('salary_pay_content');
                                       </script>
                                    </div>
                                 </div>
                                 <button type="button" class="btn sec-btn text-right update_mail_content">Update</button>
                              </div>
                           </div>
                        </form>
                     </div>

                     <!-- <div id="attendance-details" class="tab-pane fade show active in" role="tabpanel" aria-labelledby="attendance-details-tab">
                     </div> -->
                  </div>   
               </div>
            </div>
         </div>
      </div>
   </div>

   <script>
      $(document).on('click', '.update_mail_content', function() {
         var base_url = $("#js_data").data('base-url');
         var desc = CKEDITOR.instances.mail_content.getData();

         var data = {
            'mail_content': desc,
         };
         $.ajax({
            url: base_url + 'mail_content/update_team',
            type: 'post',
            data: data,
            success: function(response) {
               //location.reload();
               console.log(response);
               $('.msg-container').html('<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Team And Condition Updated Successfully.</p></div></div></div>');
               $('.msg-container .msg-box').attr('style', 'display:block');
               setTimeout(function() {
                  $('.msg-container .msg-box').attr('style', 'display:none');
               }, 6000);
               console.log(response);
            }
         });
      });
      $('a.nav-link').click(function(){
         $('span.mb-custom-tab-active').text($(this).text());
            var id = $(this).attr('aria-controls');
            $('.tab-pane.fade').removeClass('show active');
            $('a').removeClass('active');
            $('a').parent().removeClass('active');
            $(this).addClass('active');
            var $this = $(this).text();
            $.each($('a.nav-link'),function(){
               if($(this).text() == $this){
                  $(this).addClass('active');
                  $(this).parent().addClass('active');
               }
            });
            $(this).parent().removeClass('active');
            $('#'+id).addClass('show');
         });
   </script>