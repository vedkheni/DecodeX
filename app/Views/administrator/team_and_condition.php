<?php $user_id=$this->session->userdata('id');?>
<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title">Team & Condition</h4>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="white-box m-0">
               <div class="massge_for_error text-center"><?php echo $this->session->flashdata('message'); ?></div>
               <form id="profile_image_change" enctype="multipart/form-data" method="post" action="<?php echo base_url('team_and_condition/update_team') ?>">
                  <?php 
                     $csrf = array(
                         'name' => $this->security->get_csrf_token_name(),
                         'hash' => $this->security->get_csrf_hash()
                     );
                     ?>
                  <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                  <div class="user-content">
                     <div class="info-content p-0">
                        <div class="form-group">
                           <div class="single-field">
                              <textarea class="textarea" name="team_and_condition" id="team_and_condition"><?php if(isset($team_and_condition) && !empty($team_and_condition[0]->description)){ echo $team_and_condition[0]->description; } ?></textarea>
                              <script>
                                 CKEDITOR.replace( 'team_and_condition' );
                              </script>
                           </div>
                        </div>
                        <button type="button"  class="btn sec-btn text-right update_team_and_condition">Update</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>

<script>	
 $(document).on('click', '.update_team_and_condition', function() {
        var base_url = $("#js_data").data('base-url');
		var desc = CKEDITOR.instances.team_and_condition.getData();

            var data = {
                'team_and_condition': desc,
            };
            $.ajax({
                url: base_url + 'team_and_condition/update_team',
                type: 'post',
                data: data,
                success: function(response) {
                    //location.reload();
					console.log(response);
					$('.msg-container').html('<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Team And Condition Updated Successfully.</p></div></div></div>');
					$('.msg-container .msg-box').attr('style','display:block');
					setTimeout(function() {
						$('.msg-container .msg-box').attr('style','display:none');
					}, 6000);
					console.log(response);
                }
            });	
    });
</script>
