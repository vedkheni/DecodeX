<?php 
$profile_url = base_url().'assets/profile_image256x256';
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <h4 class="page-title">Profile</h4>
            </div>
        <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li class="active">Profile</li>
            </ol>
        </div> -->
    </div>
    <!-- .row -->
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="profile-box admin-profile-box">
                <!-- <div class="massge_for_error text-center"><?php //echo $this->session->flashdata('message'); ?></div> -->
                <form class="form-horizontal form-material" id="admin_profile_image_change" enctype="multipart/form-data" method="post" action="<?php echo base_url('user/profile_image_change') ?>">
                    <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
                    <div class="user-content">
                        <div class="pro-title">
                            <h3>Profile Details</h3>
                            <button type="button" data-toggle="modal" data-target="#profile_detail" class="pro-edit" data-tooltip="Edit Profile Detail" flow="left"><i class="fas fa-pencil-alt"></i></button>
                        </div>
                        <div class="profile-pic">
                            <div class="col-xs-12 d-none">
                                <input type="file" name="profile_image" id="profile_image" class="admin-file-upload">
                            </div>
                            <div class="profile-img-box">
                                <!-- <a href="javascript:void(0)"><img src="<?php // echo base_url(); ?>assets/plugins/images/users/genu.jpg" class="thumb-lg img-circle profile-pic-url" alt="img"></a>-->
                                <?php
                                  /*   echo "<pre>";
                                    print_r($profile);
                                    echo "</pre>"; */
                                    if($profile[0]->profile_image != ""){
                                        $image1=$_SERVER['DOCUMENT_ROOT']."/assets/profile_image32x32/".$profile[0]->profile_image;
                                        if(file_exists($image1)){
                                           $image=base_url()."assets/profile_image32x32/".$profile[0]->profile_image;
                                        }else{
                                           if(isset($profile[0]->gender) && $profile[0]->gender == 'female') {
                                              $image=base_url()."assets/images/female-default.svg";
                                           }else{
                                              $image=base_url()."assets/images/male-default.svg";
                                           }
                                        }
                                     }else{
                                        if(isset($profile[0]->gender) && $profile[0]->gender == 'female') {
                                           $image=base_url()."assets/images/female-default.svg";
                                        }else{
                                           $image=base_url()."assets/images/male-default.svg";  
                                        }
                                     } 
                                ?>
                                <img src="<?php echo $image; ?>" class="profile-img profile-pic-url" alt="img"  >
                                <div class="camera-icon upload-admin-button">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>

                        </div>

                        <div class="info-content">
                            <ul>
                                <li>
                                    <span class="info-title">User Name</span>
                                    <span class="info-value"><?php echo $profile[0]->username; ?></span>
                                </li>
                                <li>
                                    <span class="info-title">Email</span>
                                    <span class="info-value"><?php echo $profile[0]->email; ?></span>
                                </li>
                                <li>
                                    <span class="info-title">Phone No.</span>
                                    <span class="info-value"><?php echo $profile[0]->phone_number; ?></span>
                                </li>
                                <li>
                                    <span class="info-title">User Role</span>
                                    <span class="info-value"><?php echo $profile[0]->user_role; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- <div class="col-md-7 col-xs-12">
            <div class="white-box form_section">
                <form class="form-horizontal form-material">
                <div class="form-group">
                    <label class="col-md-12">User Name</label>
                    <div class="col-md-12">
                        <?php // echo $profile[0]->username; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="example-email" class="col-md-12">Email</label>
                    <div class="col-md-12">
                        <?php // echo $profile[0]->email; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12">Phone No</label>
                    <div class="col-md-12">
                        <?php // echo $profile[0]->phone_number; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12">User Role</label>
                    <div class="col-md-12">
                        <?php // echo $profile[0]->user_role; ?>
                    </div>
                </div>
                </form>
            </div>
        </div> -->
    </div>
    <!-- /.row -->
</div>

<!-- Basic Detail Pop-Up Start -->
<div class="modal" id="profile_detail" role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <div class="modal_header-content">
               <h4 class="modal-title">Profile Details</h4>
            </div>
         </div>
         <form method="POST" enctype="multipart/form-data" method="post" action="<?php echo base_url('user/profile_detail_change') ?>" id="profile_form1">
                <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
               <input type="hidden" name="user_id" id="user_id" value="<?php if(isset($profile[0]->id)){ echo $profile[0]->id;} ?>">
               <input type="hidden" name="detail_type" id="detail_type" value="profile_detail">
               <input type="hidden" name="pass" id="pass" value="<?php if(isset($profile[0]->password)){ echo $profile[0]->password;} ?>">
            <div class="modal-body">
               <div class="form-group">
                  <div class="single-field">
                     <input type="text" name="username" id="username" value="<?php if(isset($profile[0]->username)){ echo $profile[0]->username;} ?>">
                     <label>User Name</label>
                  </div>
               </div>
               <div class="form-group">
                  <div class="single-field">
                     <input type="text" name="email" id="email" value="<?php if(isset($profile[0]->email)){ echo $profile[0]->email;} ?>">
                     <label>Email</label>
                  </div>
               </div>
               <div class="form-group">
                  <div class="single-field">
                     <input type="text" name="phone_number" id="phone_number"  value="<?php if(isset($profile[0]->phone_number)){ echo $profile[0]->phone_number;} ?>">
                     <label>Phone No</label>
                  </div>
               </div>
               <div class="form-group radio-group">
                  <label>Gender </label>
                  <div class="form-radio">
                     <input type="radio" <?php if(isset($profile[0]->gender) && $profile[0]->gender == "male"){ ?> checked="checked" <?php } ?> name="gender" value="male" id="gender" class="gender">Male
                  </div>
                  <div class="form-radio">
                     <input type="radio" <?php if(isset($profile[0]->gender) && $profile[0]->gender == "female"){ ?> checked="checked" <?php } ?> name="gender" value="female" id="gender" class="gender">Female
                  </div>
                </div>
                <div class="form-group">
                <h3 class="blue-text">Change Password</h3>  
                </div>
                <div class="form-group">
                   <div class="single-field">
                      <input type="text" name="old_password" id="old_password" value="">
                      <label>Old Password</label>
                   </div>
                </div>
                <div class="form-group">
                   <div class="single-field">
                      <input type="password" name="new_password" id="new_password" value="">
                      <label>New Password</label>
                   </div>
                </div>
                <div class="form-group m-0">
                   <div class="single-field">
                      <input type="password" name="confirm_password" id="confirm_password" value="">
                      <label>Confirm New Password</label>
                   </div>
                </div>
                </div>
                  <div class="modal-footer">                         
               <button type="submit"  class="btn btn-primary text-right update-profile_detail">Update</button>
            </div>
        </form>
    </div>
    </div>
</div>

<!-- Basic Detail Pop-Up End -->

<script>
 $(document).ready(function() {
     var readURL = function(input) {
         if (input.files && input.files[0]) {
             var reader = new FileReader();
             reader.onload = function (e) {
                 $('.admin-profile-pic-url').attr('src', e.target.result);
             }

             reader.readAsDataURL(input.files[0]);
         }
     }
     $(".admin-file-upload").on('change', function(e){
       console.log("image select");
       readURL(this);
       $("#admin_profile_image_change").submit();
   });

     $(".upload-admin-button").on('click', function() {
       console.log("image btn on click select");
       $(".admin-file-upload").click();
   });
 });
 function isEmail(email) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		  }
 $(document).on('click', '.update-profile_detail', function(e){

   var username=$("#username").val();
   var email=$("#email").val();
   var old_password=$("#old_password").val();
   var new_password=$("#new_password").val();
   var confirm_password=$("#confirm_password").val(); 
   /* var gender = true;
    $('.gender').each(function(){
      gender = gender && $(this).is(':checked');
   });  */
   var isChecked = $('[name="gender"]:checked').length;
   var phone_number=$("#phone_number").val();
    if(!username || !email || !phone_number || !(isChecked > 0) || (isEmail(email)==false) || !$.isNumeric(phone_number)){
  
      e.preventDefault();
      var error_messages="";
       if(!username){
         $("#username").addClass('error');
         error_messages +='<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please Enter User First Name</p></div></div></div>';
       }
       else{
         $("#username").removeClass('error');
         // $(".message_error .username_err").remove();
       }
       if(!email){
         $("#email").addClass('error');
         error_messages +='<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please Enter User Email</p></div></div></div>';
       }
       else{
         if(isEmail(email) == false){
             $("#email").addClass('error');
             error_messages +='<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please Enter Valid User Email</p></div></div></div>';
         }
         else{
             $("#email").removeClass('error');
             // $(".message_error .email_err").remove();
         }
       }
       if(!phone_number){
         $("#phone_number").addClass('error');
         error_messages +='<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please Enter User Contact No.</p></div></div></div>';
       }
       else{
         if(!($.isNumeric(phone_number))){
             $("#phone_number").addClass('error');
             error_messages +='<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please Enter Valid Contact No.</p></div></div></div>';
         }
         else{
             $("#phone_number").removeClass('error');
             // $(".message_error .pno_err").remove();
         }
             
       }
       if(!(isChecked > 0)){
           //alert("data");
         $(".gender").addClass('error');
         error_messages +='<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Select User Gender </p></div></div></div>';
    
       }
       else{
         $(".gender").removeClass('error');
         // $(".message_error .gender_err").remove();
       }
           $(".msg-container").html(error_messages);
         $('.msg-container .msg-box').attr('style','display:block');
           setTimeout(function() {
               $('.msg-container .msg-box').attr('style','display:none');
         }, 6000);
     return false;       
   }
   else{
     $("#username").removeClass('error');
     $("#email").removeClass('error');
     $(".gender").removeClass('error');
     $("#phone_number").removeClass('error');
     $(".message_error").html('');
     
     if(old_password && new_password && confirm_password){
        if(new_password != confirm_password){
            $("#new_password").addClass('error');
            $("#confirm_password").addClass('error');
            error_messages ='<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Password And Confirm Password Not Match!</p></div></div></div>';
            $(".msg-container").html(error_messages);
            $('.msg-container .msg-box').attr('style','display:block');
            setTimeout(function() {
               $('.msg-container .msg-box').attr('style','display:none');
            }, 6000);
            return false;  
        }else{
            $("#new_password").removeClass('error');
            $("#confirm_password").removeClass('error');
            // $('#profile_form1').submit();
            return true;  
        }
     }else{
        if(old_password || new_password || confirm_password){
            if(!old_password){
                $("#old_password").addClass('error');
                error_messages +='<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please Enter Old Password</p></div></div></div>';
            }
            else{
                $("#old_password").removeClass('error');
                // $(".message_error .username_err").remove();
            }
            if(!new_password){
                $("#new_password").addClass('error');
                error_messages +='<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please Enter Password</p></div></div></div>';
            }
            else{
                $("#new_password").removeClass('error');
                // $(".message_error .username_err").remove();
            }
            if(!confirm_password){
                $("#confirm_password").addClass('error');
                error_messages +='<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please Enter Confirm password</p></div></div></div>';
            }
            else{
                $("#confirm_password").removeClass('error');
                // $(".message_error .username_err").remove();
            }
            $(".msg-container").html(error_messages);
            $('.msg-container .msg-box').attr('style','display:block');
            setTimeout(function() {
            $('.msg-container .msg-box').attr('style','display:none');
            }, 6000);
            return false; 
        }else{
            // $('#profile_form1').submit();
            return true;  
        }
     }
 
 }
});
</script>


