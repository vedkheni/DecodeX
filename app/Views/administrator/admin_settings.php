<?php 
$profile_url = base_url().'assets/profile_image256x256';
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <h4 class="page-title">Settings</h4>
            </div>
        <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li class="active">Profile</li>
            </ol>
        </div> -->
    </div>
    <!-- .row -->
    <div class="row justify-content-center">
        <div class="col-6">
		<?php //print_r($profile); ?>
            <div class="white-box space-30 m-0">
                <div class="massge_for_error text-center"><?php echo $this->session->flashdata('message'); ?></div>
                <form class="form-horizontal form-material" id="update_setting" enctype="multipart/form-data" method="post" action="<?php echo base_url('settings/update_setting') ?>">
                    <?php 
                    $csrf = array(
                        'name' => $this->security->get_csrf_token_name(),
                        'hash' => $this->security->get_csrf_hash()
                    );
                    ?>
                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
					<div class="form-group">
						<div class="single-field">
						<input type="date" name="chnage_date" class="datepicker-here" id="chnage_date" value="<?php if(!empty($profile->chnage_date)) { echo $profile->chnage_date; }  ?>" placeholder="Date">
						<label>Date</label>
						 </div>
					</div>
					<div class="form-group">
						<div class="single-field">
						<input type="text" name="official_time" id="official_time" placeholder="Official Time" value="<?php if(isset($profile) && !empty($profile->official_time)) {echo $profile->official_time; } ?>">
						<label>Official time</label>
						 </div>
					</div>
					<div class="form-group">
						<div class="single-field">
						<input type="text" name="lunch_time" id="lunch_time" value="<?php if(isset($profile) && !empty($profile->lunch_time)) { echo $profile->lunch_time; } ?>" placeholder="Lunch Time">
						<label>Working days</label>
						 </div>
					</div>
					<?php 
						$working_days=array();
						if(!empty($profile->working_days)){
							$working_days=explode(',',$profile->working_days);
						}
					?>
					<div class="form-group form-radio">
						<label class="form-radio-labe">Working days</label>
						
							<!-- <div id="status_error"></div> -->
							<label class="form-radio-label"><input type="checkbox" name="working_day[]" id="working_day"  <?php if(!empty($working_days) && in_array('1',$working_days)){ echo "checked"; } ?> value="1"> Monday </label>
							<label class="form-radio-label"><input type="checkbox" name="working_day[]" <?php if(!empty($working_days) && in_array('2',$working_days)){ echo "checked"; } ?> id="working_day" value="2"> Tuesday </label>
							<label class="form-radio-label"><input type="checkbox" name="working_day[]" <?php if(!empty($working_days) && in_array('3',$working_days)){ echo "checked"; } ?> id="working_day" value="3"> Wednesday</label>
							<label class="form-radio-label"><input type="checkbox" name="working_day[]" <?php if(!empty($working_days) && in_array('4',$working_days)){ echo "checked"; } ?> id="working_day" value="4"> Thursday </label>
							<label class="form-radio-label"><input type="checkbox" name="working_day[]" <?php if(!empty($working_days) && in_array('5',$working_days)){ echo "checked"; } ?> id="working_day" value="5"> Friday</label>
							<label class="form-radio-label"><input type="checkbox" name="working_day[]" <?php if(!empty($working_days) && in_array('6',$working_days)){ echo "checked"; } ?> id="working_day" value="6"> Saturday </label>
							<label class="form-radio-label"><input type="checkbox" name="working_day[]" <?php if(!empty($working_days) && in_array('7',$working_days)){ echo "checked"; } ?> id="working_day" value="7"> Sunday  </label>
							
					</div>
					<div class="form-group form-radio">
						<label class="form-radio-labe">New</label>
						<label class="form-radio-label"><input type="checkbox" name="new_create" id="new_create" <?php if(!isset($profile) && !empty($profile)){ echo "checked"; } ?> value="1"  value="1"> Create New</label>
					</div>
					<input type="hidden" id="sid" name="sid" value="<?php if(isset($profile) && !empty($profile->id)) { echo $profile->id; }  ?>">
						<div class="col-12">
							<div class=" text-center">
								<button type="submit" name="submit" id="submit" class="btn btn-outline-primary submit_form">Submit</button>
							</div>
						</div>
                    
                </form>
            </div>
        </div>

    </div>
    <!-- /.row -->
</div>
<script>
$(document).on('click', '#update_setting', function(e){

          var chnage_date=$("#chnage_date").val();
          var official_time=$("#official_time").val();
          var lunch_time=$("#lunch_time").val();
		  
          if(!chnage_date || !official_time || !lunch_time){
         
			 e.preventDefault();
			 var error_messages="";
			  if(!chnage_date){
                $("#chnage_date").addClass('error');
				error_messages +='<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please Enter Date</p></div></div></div>';
             
			  }
              else{
                $("#chnage_date").removeClass('error');
				// $(".message_error .bank_err").remove();
              }
			  if(!official_time){
                $("#official_time").addClass('error');
				error_messages +='<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please Enter Official Time</p></div></div></div>';
			  }
              else{
					$("#official_time").removeClass('error');
              }
			  if(!lunch_time){
                $("#lunch_time").addClass('error');
				error_messages +='<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please Enter Lunch Time</p></div></div></div>';
			  }
              else{
                $("#lunch_time").removeClass('error');
				// $(".message_error .ifsc_err").remove();
              }
			  
			  	$(".msg-container").html(error_messages);
			 	$('.msg-container .msg-box').attr('style','display:block');
				  	setTimeout(function() {
					  	$('.msg-container .msg-box').attr('style','display:none');
					}, 6000);
			return false;       
          }
          else{
			$("#chnage_date").removeClass('error');
            $("#official_time").removeClass('error');
            $("#lunch_time").removeClass('error');
			$(".message_error").html('');
    		// $('#profile-form2').submit();
            return true;  
            
          }
    });

</script>
