<?php $user_id=$this->session->get('id');?>
<script src="https://cdnjs.com/libraries/pdf.js"></script>
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-12 col-md-12 col-xs-12">
         <h4 class="page-title">Profile page</h4>
      </div>
      <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
         <ol class="breadcrumb">
             <li class="active">Profile Page</li>
         </ol>
         </div> -->
   </div>
   <!-- /.row -->
   <?php //echo "<pre>"; print_r($profile);  echo "</pre>"; ?>
   <!-- .row -->
   <?php 
      $profile_url = base_url().'assets/profile_image256x256';
      ?>
   <?php
      $gmail_account="";
      $gmail_password="";
      $skype_account="";
      $skype_password="";
      if(isset($profile) && !empty($profile)){
       $decode_credentials=json_decode($profile[0]->credential);
      //echo "<pre/>";
      //print_r($profile);
      /* echo "<pre/>";
      print_r($profile[0]->credential);
      die; */
      
      if(isset($decode_credentials) && !empty($decode_credentials)){
      $gmail=$decode_credentials->gmail;
      $skype=$decode_credentials->skype;
      $gmail_account=$gmail->gmail_account;
      $gmail_password=$gmail->gmail_password;
      $skype_account=$skype->skype_account;
      $skype_password=$skype->skype_password; 
      }
      }
      $url = base_url().'assets/id_proof256x256';
      $signature_url = base_url().'assets/signature256x256';
      ?>                
   <div class="row">
      <div class="col-12 col-xl-6">
         <div class="profile-box basic-info">
            <div class="massge_for_error text-center"><?php echo $this->session->getFlashdata('message'); ?></div>
            <form id="profile_image_change" enctype="multipart/form-data" method="post" action="<?php echo base_url('profile/profile_image_change') ?>">
               <input type="hidden" name="<?=csrf_token();?>" value="<?= csrf_hash();?>" />
               <div class="user-content">
                  <div class="pro-title">
                     <h3>Profile Details</h3>
                     <!-- <button type="button" data-toggle="modal" data-target="#basic_detail" class="pro-edit"><i class="fas fa-pencil-alt"></i></button> -->
                     <div class="btn-group">
                        <button type="button" data-toggle="modal" data-target="#change-Password" class="pro-password" data-tooltip="Change Password" flow="left" ><i class="fas fa-key"></i></button>
                        <button type="button" data-toggle="modal" data-target="#basic_detail" class="pro-edit ml-2" data-tooltip="Edit Basic Detail" flow="left"><i class="fas fa-pencil-alt"></i></button>
                     </div>
                  </div>
                  <div class="profile-pic">
                     <div class="col-xs-12 d-none">
                        <input type="file" name="profile_image" id="profile_image" class="profile-pic">
                     </div>
                     <div class="profile-img-box">
                     <?php  if($profile[0]->profile_image != ""){
                                 $image1=$_SERVER['DOCUMENT_ROOT']."/assets/profile_image32x32/".$profile[0]->profile_image;
                                 if(file_exists($image1)){
                                    $image=$profile_url."/".$profile[0]->profile_image;
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
                              } ?>
                              <img src="<?php echo $image; ?>" class="profile-img profile-pic-url" alt="img"  >
                        <div class="camera-icon upload-button">
                           <i class="fas fa-camera"></i>
                        </div>
                     </div>
                  </div>
                  <div class="info-content">
                     <ul>
                        <li>
                           <span class="info-title">Name</span>
                           <span class="info-value"><?php if(isset($profile[0]->fname) && isset($profile[0]->lname)){ echo $profile[0]->fname.' '.$profile[0]->lname;} ?></span>
                        </li>
                        <li>
                           <span class="info-title">Email</span>
                           <span class="info-value"><?php echo $profile[0]->email; ?></span>
                        </li>
                        <li>
                           <span class="info-title">Personal Email</span>
                           <span class="info-value"><?php echo $profile[0]->personal_email; ?></span>
                        </li>
                        <li>
                           <span class="info-title">Phone No.</span>
                           <span class="info-value"><?php echo $profile[0]->phone_number; ?></span>
                        </li>
                        <li>
                           <span class="info-title">User Role</span>
                           <span class="info-value"><?php echo ucwords($profile[0]->user_role); ?></span>
                        </li>
                        <li>
                           <span class="info-title">Date Of Birth</span>
                           <span class="info-value"><?php echo ($profile[0]->date_of_birth != '0000-00-00' && $profile[0]->date_of_birth != '' )?dateFormat($profile[0]->date_of_birth):''; ?></span>
                        </li>
                        <li>
                           <span class="info-title">Gender</span>
                           <span class="info-value"><?php echo ucwords($profile[0]->gender); ?></span>
                        </li>
                        <li>
                           <span class="info-title">Designation</span>
                           <span class="info-value">
                            <?php foreach ($designation as $key => $value){
                                if(isset($profile[0]->designation) && $profile[0]->designation == $value->id){ echo $value->name; } 
                            } ?>
                            </span>
                        </li>
                        <li>
                           <span class="info-title">Joining Date</span>
                           <span class="info-value"><?php echo ($profile[0]->joining_date != '0000-00-00' && $profile[0]->joining_date != '' )?dateFormat($profile[0]->joining_date):''; ?></span>
                        </li>
                        <li>
                           <span class="info-title">Address</span>
                           <span class="info-value info-address"><?php echo $profile[0]->address; ?></span>
                        </li>
                     </ul>
                  </div>
               </div>
            </form>
         </div>
         <div class="profile-box emergency-contact">
            <div class="user-content">
               <div class="pro-title">
                  <h3>Emergency Contact</h3>
                  <button type="button"  data-toggle="modal" data-target="#emergency_contact" class="pro-edit" data-tooltip="Edit Emergency Contact Detail" flow="left"><i class="fas fa-pencil-alt"></i></button>
               </div>
               <div class="info-content">
                     <?php if(isset($emergency_contact) && !empty($emergency_contact)){ ?>
                        <ul>
                           <li>
                              <span class="info-title">Name</span>
                              <span class="info-value"><?php echo $emergency_contact->name; ?></span>
                           </li>
                           <li>
                              <span class="info-title">Phone No.</span>
                              <span class="info-value"><?php echo $emergency_contact->phone_number; ?></span>
                           </li>
                           <li>
                              <span class="info-title">Email</span>
                              <span class="info-value"><?php echo $emergency_contact->email; ?></span>
                           </li>
                           <li>
                              <span class="info-title">Address</span>
                              <span class="info-value"><?php echo $emergency_contact->address; ?></span>
                           </li>
                        </ul>
                     <?php }else{ ?>
                        <div class="empty-id-proof">
                           <p>Emergency Contact Not Found!</p>
                        </div>
                     <?php } ?>
               </div>
            </div>
         </div>
      </div>
      <div class="col-12 col-xl-6">
         <div class="profile-box bank-info">
            <div class="user-content">
               <div class="pro-title">
                  <h3>Bank Details</h3>
                  <button type="button"  data-toggle="modal" data-target="#bank_detail" class="pro-edit" data-tooltip="Edit Bank Detail" flow="left"><i class="fas fa-pencil-alt"></i></button>
               </div>
               <div class="info-content">
                  <ul>
                     <li>
                        <span class="info-title">Salary</span>
                        <span class="info-value">₹ <?php echo $profile[0]->salary; ?></span>
                     </li>
                     <li>
                        <span class="info-title">Salary Deduction</span>
                        <span class="info-value"><?php echo $profile[0]->salary_deduction; ?>%</span>
                     </li>
                     <li>
                        <span class="info-title">Bank Name</span>
                        <span class="info-value"><?php echo $profile[0]->bank_name; ?></span>
                     </li>
                     <li>
                        <span class="info-title">Account No.</span>
                        <span class="info-value"><?php echo $profile[0]->account_number; ?></span>
                     </li>
                     <li>
                        <span class="info-title">IFSC Code</span>
                        <span class="info-value"><?php echo $profile[0]->ifsc_number; ?></span>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="profile-box other-payment-method">
            <div class="user-content">
               <div class="pro-title">
                  <h3>Other Payment method</h3>
                  <button type="button"  data-toggle="modal" data-target="#payment_method" class="pro-edit" data-tooltip="Edit Payment Method" flow="left"><i class="fas fa-pencil-alt"></i></button>
               </div>
               <div class="info-content">
                  <ul>
                     <li>
                        <span class="info-title">UPI Type</span>
                        <span class="info-value"><?php echo ($profile[0]->upi_type == 'gpay') ? 'Google Pay' : 'PhonePe'; ?></span>
                     </li>
                     <li>
                        <span class="info-title">UPI ID</span>
                        <span class="info-value"><?php echo $profile[0]->upi_id; ?></span>
                     </li>
                     <li>
                        <div class="info-content m-auto">
                           <?php if(isset($profile[0]->qr_code) && !empty($profile[0]->qr_code)){ 
                              $image1=$_SERVER['DOCUMENT_ROOT']."/assets/upload/qrcode/".$profile[0]->qr_code;
                              if(file_exists($image1)){
                                 $image=base_url()."assets/upload/qrcode/".$profile[0]->qr_code;
                              ?>
                              <a download href="<?php echo $image; ?>"><img class="id-img" width="300" src="<?php echo $image; ?>"></a> 
                           <?php } } ?>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="profile-box id-info">
            <div class="user-content">
               <div class="pro-title">
                  <h3>ID Proof</h3>
                  <!-- <button type="button" data-toggle="modal" data-target="#id_proof_pop" class="pro-edit"><i class="fas fa-pencil-alt"></i></button> -->
               </div>
               <div class="info-content">
                    <?php if(isset($profile[0]->id_proof) && !empty($profile[0]->id_proof)){ 
                        $image1=$_SERVER['DOCUMENT_ROOT']."/assets/id_proof512x512/".$profile[0]->id_proof;
                        if(file_exists($image1)){
                           $image=base_url()."assets/id_proof512x512/".$profile[0]->id_proof;
                           $image_1=$url.'/'.$profile[0]->id_proof;
                        ?>
                        <a download href="<?php echo $image; ?>">
                           <img class="id-img" src="<?php echo $image_1; ?>">
                       </a> 
                        <?php }else{ ?>
                           <div class="empty-id-proof">
                           <p>No ID Proof Uploaded.</p>
                        </div>   
                           <?php } }else{ ?>
                        <div class="empty-id-proof">
                           <p>No ID Proof Uploaded.</p>
                        </div>
                        <!-- <img class="id-img" src="https://stage.geekwebsolution.com/assets/images/geekwebsoloution.png" alt=""> -->
                    <?php } ?>
               </div>
            </div>
         </div>

         <div class="profile-box id-info">
            <div class="user-content">
               <div class="pro-title">
                  <h3>Passport Size Photo</h3>
               </div>
               <div class="info-content">
                    <?php if(isset($profile[0]->passportphoto) && !empty($profile[0]->passportphoto)){ 
                        $image1=$_SERVER['DOCUMENT_ROOT']."/assets/upload/passportphoto/".$profile[0]->passportphoto;
                        if(file_exists($image1)){
                           $image=base_url()."assets/upload/passportphoto/".$profile[0]->passportphoto;
                        ?>
                        <a download href="<?php echo $image; ?>">
                           <img class="id-img" src="<?php echo $image; ?>">
                       </a> 
                        <?php }else{ ?>
                           <div class="empty-id-proof">
                           <p>Photo Not Uploaded.</p>
                        </div>   
                           <?php } }else{ ?>
                        <div class="empty-id-proof">
                           <p>Photo Not Uploaded.</p>
                        </div>
                    <?php } ?>
               </div>
            </div>
         </div>

         <!-- <div class="profile-box id-info">
            <div class="user-content">
               <div class="pro-title">
                  <h3>Signature</h3>
                  <button type="button" data-toggle="modal" data-target="#emp_signature_pop" class="pro-edit"><i class="fas fa-pencil-alt"></i></button>
               </div>
               <div class="info-content">
                    <?php 
                     /* if(isset($profile[0]->signature) && !empty($profile[0]->signature)){ 
                       $image1=$_SERVER['DOCUMENT_ROOT']."/assets/signature512x512/".$profile[0]->signature;
                       if(file_exists($image1)){
                          $image=base_url()."assets/signature512x512/".$profile[0]->signature;
                          $image_1=$signature_url.'/'.$profile[0]->signature; */
                          ?>
                          <a download href="<?php // echo $image; ?>">
                           <img class="id-img" src="<?php // echo $image_1; ?>">
                        </a> 
                      <?php
                       // }else{ ?>
                          <div class="empty-id-proof">
                           <p>No Signature Uploaded.</p>
                        </div>
                       <?php // } }else{ ?>
                        <div class="empty-id-proof">
                           <p>No Signature Uploaded.</p>
                        </div>
                    <?php //} ?>
               </div>
            </div>
         </div> -->
         <div class="profile-box credential-info">
            <div class="user-content">
               <div class="pro-title">
                  <h3>Credentials</h3>
                  <button type="button" data-toggle="modal" data-target="#credi_detail" class="pro-edit" data-tooltip="Edit Credentials Detail" flow="left"><i class="fas fa-pencil-alt"></i></button>
               </div>
               <div class="info-content">
                  <ul>
                     <li>
                        <span class="info-title">Gmail Id</span>
                        <span class="info-value"><?php if(isset($gmail_account)){ echo $gmail_account;} ?></span>
                     </li>
                     <li>
                        <span class="info-title">Gmail Password</span>
                        <span class="info-value"><?php if(isset($gmail_password)){ echo $gmail_password;} ?></span>
                     </li>
                     <li>
                        <span class="info-title">Skype Id</span>
                        <span class="info-value"><?php if(isset($skype_account)){ echo $skype_account;} ?></span>
                     </li>
                     <li>
                        <span class="info-title">Skype Password</span>
                        <span class="info-value"><?php if(isset($skype_password)){ echo $skype_password;} ?></span>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Basic Detail Pop-Up Start -->
<div class="modal" id="basic_detail" role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <div class="modal_header-content">
               <h4 class="modal-title">Basic Detail</h4>
            </div>
         </div>
         <form method="POST" enctype="multipart/form-data" method="post" action="<?php echo base_url('profile/insert_data') ?>" id="profile-form1">
               <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
               <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($profile[0]->id)){ echo $profile[0]->id;} ?>">
               <input type="hidden" name="detail_type" id="detail_type" value="basic_detail">
            <div class="modal-body">
               <div class="form-group">
                  <div class="single-field">
                     <input type="text" name="fname" id="fname" value="<?php if(isset($profile[0]->fname)){ echo $profile[0]->fname;} ?>">
                     <label>First Name</label>
                  </div>
               </div>
               <div class="form-group">
                  <div class="single-field">
                     <input type="text" name="lname" id="lname" value="<?php if(isset($profile[0]->lname)){ echo $profile[0]->lname;} ?>">
                     <label>Last Name</label>
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
                     <input type="text" name="personal_email" id="personal_email" value="<?php if(isset($profile[0]->personal_email)){ echo $profile[0]->personal_email;} ?>">
                     <label>Personal Email</label>
                  </div>
               </div>
               <div class="form-group">
                  <div class="single-field">
                     <input type="text" name="phone_number" id="phone_number"  value="<?php if(isset($profile[0]->phone_number)){ echo $profile[0]->phone_number;} ?>">
                     <label>Phone No</label>
                  </div>
               </div>
               <div class="form-group">
                  <div class="single-field date-field">
                     <input type="text" name="birth_date" class="datepicker-here" id="birth_date" data-date="<?php if(isset($profile[0]->date_of_birth)){ echo $profile[0]->date_of_birth;} ?>" value="<?php if(isset($profile[0]->date_of_birth)){ echo $profile[0]->date_of_birth;} ?>" data-language="en" autocomplete="off">
                     <label>Date Of Birth</label>
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
               <!-- <div class="form-group">
                  <div class="single-field date-field">
                     <input type="text" name="joining_date" class="datepicker-here" id="joining_date"  data-date="<?php //if(isset($profile[0]->joining_date)){ echo $profile[0]->joining_date;} ?>" value="<?php //if(isset($profile[0]->joining_date)){ echo $profile[0]->joining_date;} ?>" data-language="en" autocomplete="off">
                     <label>Joining Date</label>
                  </div>
               </div> -->
               <div class="form-group">
                  <div class="single-field select-field">
                     <select name="designation" id="designation">
                        <?php foreach ($designation as $key => $value) { ?>
                        <option <?php if(isset($profile[0]->designation) && $profile[0]->designation == $value->id){ ?> selected="selected" <?php } ?> value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php } ?>
                     </select>
                     <label>Select Designation</label>
                  </div>
               </div>
               <div class="form-group m-0">
                  <div class="single-field">
                     <textarea class="textarea" name="address" id="address"><?php if(isset($profile[0]->address)){ echo $profile[0]->address;} ?></textarea>
                     <label>Address</label>
                  </div>
               </div>
            </div>
            <div class="modal-footer">                         
               <button type="submit"  class="btn btn-primary text-right update-basic_detail">Update</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Basic Detail Pop-Up End -->
<!-- Bank Detail Pop-Up Start -->
<div class="modal" id="bank_detail" role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <div class="modal_header-content">
               <h4 class="modal-title">Bank Detail</h4>
            </div>
         </div>
         <form method="POST" enctype="multipart/form-data" method="post" action="<?php echo base_url('profile/insert_data') ?>" id="profile-form2">
               <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
               <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($profile[0]->id)){ echo $profile[0]->id;} ?>">
               <input type="hidden" name="detail_type" id="detail_type" value="bank_detail">
            <div class="modal-body">
               <div class="form-group">
                  <div class="single-field ">
                     <input type="text" <?php if(isset($profile[0]->bank_name) && !empty($profile[0]->bank_name)){ echo "readonly"; } ?> name="bank_name" id="bank_name"  value="<?php if(isset($profile[0]->bank_name)){ echo $profile[0]->bank_name;} ?>">
                     <label>Bank name</label>
                  </div>
               </div>
               <div class="form-group">
                  <div class="single-field">
                     <input type="number" <?php if(isset($profile[0]->account_number) && !empty($profile[0]->account_number)){ echo "readonly"; } ?> name="account_number" id="account_number" value="<?php if(isset($profile[0]->account_number)){ echo $profile[0]->account_number;} ?>">
                     <label>Account No.</label>
                     <!-- <input type="text" placeholder="Account Number" class="form-control form-control-line" name="account_number" id="account_number"  value="<?php if(isset($profile[0]->account_number)){ echo $profile[0]->account_number;} ?>">-->
                  </div>
               </div>
               <div class="form-group m-0">
                  <div class="single-field">
                     <input type="text" <?php if(isset($profile[0]->ifsc_number) && !empty($profile[0]->ifsc_number)){ echo "readonly"; } ?> name="ifsc_number" id="ifsc_number"  value="<?php if(isset($profile[0]->ifsc_number)){ echo $profile[0]->ifsc_number;} ?>">
                     <label>IFSC Code</label>
                  </div>
               </div>
            </div>
            <div class="modal-footer">                         
               <button type="submit"  class="btn btn-primary text-right update-bank_detail">Update</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Bank Detail Pop-Up End -->
<!-- Other Payment Method Pop-Up Start -->
<div class="modal" id="payment_method" role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <div class="modal_header-content">
               <h4 class="modal-title">Bank Detail</h4>
            </div>
         </div>
         <form method="POST" enctype="multipart/form-data" method="post" action="<?php echo base_url('profile/insert_data') ?>" id="profile-form6">
               <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
               <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($profile[0]->id)){ echo $profile[0]->id;} ?>">
               <input type="hidden" name="detail_type" id="detail_type" value="payment_method">
            <div class="modal-body">
               <div class="form-group">
                  <div class="single-field select-field">
                     <select name="upi_type" id="upi_type">
                        <option value="" disabled>Select UPI Type</option>
                        <option <?php if(isset($profile[0]->upi_type) && $profile[0]->upi_type == 'gpay'){ ?> selected="selected" <?php } ?> value="gpay">Goole Pay</option>
                        <option <?php if(isset($profile[0]->upi_type) && $profile[0]->upi_type == 'phonepe'){ ?> selected="selected" <?php } ?> value="phonepe">PhonePe</option>
                        <!-- <option <?php if(isset($profile[0]->upi_type) && $profile[0]->upi_type == 'paytm'){ ?> selected="selected" <?php } ?> value="paytm">Paytm</option> -->
                     </select>
                     <label>Select UPI Type</label>
                  </div>
               </div>
               <div class="form-group">
                  <div class="single-field">
                     <input type="text" name="upi_id" id="upi_id"  value="<?php if(isset($profile[0]->upi_id)){ echo $profile[0]->upi_id;} ?>">
                     <label>UPI ID</label>
                  </div>
               </div>
               <div class="form-group m-0 candidate-resume">
                  <div class="single-field">
                     <div class="upload-text" id="upload-text">
                        <i class="fas fa-upload text-secondary"></i>
                        <span>Upload QR code here</span>
                     </div>
                     <input type="file" class="file-upload-field" name="qrcode" id="qrcode" onchange="getFileData(this)"  value="<?php if(isset($profile[0]->qr_code)){ echo $profile[0]->qr_code;} ?>">
                     <input type="hidden" name="qrcode_name" id="qrcode_name" value="<?php if(isset($profile[0]->qr_code)){ echo $profile[0]->qr_code;} ?>" >
                     <?php if(isset($profile[0]->qr_code) && !empty($profile[0]->qr_code)){ ?>
                        <a target="_blank" class="view_resume view_qrcode" title="View QR Code" href="<?php echo base_url().'assets/upload/qrcode/'.$profile[0]->qr_code;?>"><i class="fas fa-eye"></i></a>
                     <?php } ?>		
                  </div>
               </div>
            </div>
            <div class="modal-footer">                         
               <button type="submit"  class="btn btn-primary text-right update-payment_method">Update</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Other Payment Method Pop-Up End -->
<!-- ID Proof Pop-Up Start -->
<div class="modal" id="id_proof_pop" role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <div class="modal_header-content">
               <h4 class="modal-title">ID Proof</h4>
            </div>
         </div>
         <form method="POST" enctype="multipart/form-data" method="post" action="<?php echo base_url('profile/insert_data') ?>" id="profile-form3">
               <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
               <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($profile[0]->id)){ echo $profile[0]->id;} ?>">
               <input type="hidden" name="detail_type" id="detail_type" value="id_proof">
            <div class="modal-body">
               <div class="form-group">
                  <label>ID Proof</label>
                  <div class="file-upload id_upload">
                     <div class="file-select">
                        <div class="file-select-button" id="fileName">Choose File</div>
                        <div class="file-select-name" id="noFile">No file chosen...</div>
                        <input type="file"  class="form-control form-control-line id_proof" name="id_proof" id="id_proof">
                     </div>
                  </div>
                  <!-- <input type="file" class="form-control form-control-line" name="id_proof" id="id_proof"> -->
                  <input type="hidden" name="id_proof_name" id="id_proof_name" value="<?php if(isset($profile[0]->id_proof) && !empty($profile[0]->id_proof)){ echo $profile[0]->id_proof; }?>">
               </div>
            </div>
            <div class="modal-footer">                         
               <button type="submit"  class="btn btn-primary text-right update-id_proof">Update</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- ID Proof Pop-Up End -->
<!-- ID Proof Pop-Up Start -->
<div class="modal" id="credi_detail" role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <div class="modal_header-content">
               <h4 class="modal-title">Credentials</h4>
            </div>
         </div>
         <form method="POST" enctype="multipart/form-data" method="post" action="<?php echo base_url('profile/insert_data') ?>" id="profile-form4">
               <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
               <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($profile[0]->id)){ echo $profile[0]->id;} ?>">
               <input type="hidden" name="detail_type" id="detail_type" value="credentials_detail">
            <div class="modal-body">
               <div class="form-group">
                  <div class="single-field">
                     <input type="text" name="gmail_account" id="gmail_account"  value="<?php if(isset($gmail_account)){ echo $gmail_account;} ?>">
                     <label>Gmail ID</label>
                  </div>
               </div>
               <div class="form-group">
                  <div class="single-field">
                     <input type="text" name="gmail_password" id="gmail_password"  value="<?php if(isset($gmail_password)){ echo $gmail_password;} ?>">
                     <label>Gmail Password</label>
                  </div>
               </div>
               <div class="form-group">
                  <div class="single-field">
                     <input type="text" name="skype_account" id="skype_account"  value="<?php if(isset($skype_account)){ echo $skype_account;} ?>">
                     <label>Skype ID</label>
                  </div>
               </div>
               <div class="form-group m-0">
                  <div class="single-field">
                     <input type="text" name="skype_password" id="skype_password"  value="<?php if(isset($skype_password)){ echo $skype_password;} ?>">
                     <label>Skype Password</label>
                  </div>
               </div>
            </div>
            <div class="modal-footer">                         
               <button type="submit"  class="btn btn-primary text-right update-credentials_detail">Update</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- ID Proof Pop-Up End -->
<!-- Signature Pop-Up Start -->
<div class="modal" id="emp_signature_pop" role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <div class="modal_header-content">
               <h4 class="modal-title">Signature</h4>
            </div>
         </div>
         <form method="POST" enctype="multipart/form-data" method="post" action="<?php echo base_url('profile/insert_data') ?>" id="profile-form5">
               <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
               <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($profile[0]->id)){ echo $profile[0]->id;} ?>">
               <input type="hidden" name="detail_type" id="detail_type" value="emp_signature">
            <div class="modal-body">
               <div class="form-group">
                  <label>Signature</label>
                  <div class="file-upload sign_upload">
                     <div class="file-select">
                        <div class="file-select-button" id="fileName1">Choose File</div>
                        <div class="file-select-name" id="noFile1">No file chosen...</div>
                        <input type="file"  class="form-control form-control-line emp_signature" name="emp_signature" id="emp_signature">
                     </div>
                  </div>
                  <!-- <input type="file" class="form-control form-control-line" name="emp_signature" id="emp_signature"> -->
                  <input type="hidden" name="emp_signature_name" id="emp_signature_name" value="<?php if(isset($profile[0]->signature) && !empty($profile[0]->signature)){ echo $profile[0]->signature; }?>">
               </div>
            </div>
            <div class="modal-footer">                         
               <button type="submit"  class="btn btn-primary text-right update-emp_signature">Update</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Signature Pop-Up End -->

<!-- Change Password Start -->
<div class="modal" id="change-Password" role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <div class="modal_header-content">
            <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <h4 class="modal-title">Change Password</h4>
            </div>
         </div>
         <form method="POST" enctype="multipart/form-data" method="post" action="<?php echo base_url('dashboard/changePassword') ?>" id="change-Password_form1">
            <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
            <input type="hidden" name="user_id" id="user_id" value="<?= $profile[0]->id; ?>">
            <input type="hidden" name="detail_type" id="detail_type" value="change_password">
            <input type="hidden" name="pass" id="pass" value="<?= $profile[0]->password; ?>">
            <div class="modal-body">
               <div class="form-group">
               <div class="single-field pwd">
                  <input type="password" name="old_password" id="old_password" value="">
                  <div class="pass-eye" data-id="old_password">
                     <i class="fas fa-eye"></i>
                  </div>
                  <label>Old Password</label>
               </div>
               </div>
               <div class="form-group">
               <div class="single-field pwd">
                  <input type="password" name="new_password" id="new_password" value="">
                  <div class="pass-eye" data-id="new_password">
                     <i class="fas fa-eye"></i>
                  </div>
                  <label>New Password</label>
               </div>
               </div>
               <div class="form-group m-0">
               <div class="single-field pwd">
                  <input type="password" name="confirm_password" id="confirm_password" value="">
                  <div class="pass-eye" data-id="confirm_password">
                     <i class="fas fa-eye"></i>
                  </div>
                  <label>Confirm New Password</label>
               </div>
               </div>
               </div>
               <div class="modal-footer">                         
            <button type="button"  class="btn btn-primary text-right" onclick="changePassword('change-Password');">Update</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Change Password End -->
<!-- Emergency Contact Pop-Up Start -->
<div class="modal" id="emergency_contact" role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <div class="modal_header-content">
               <h4 class="modal-title">Emergency Contact</h4>
            </div>
         </div>
         <form method="POST" enctype="multipart/form-data" method="post" action="<?php echo base_url('profile/insert_emergency_detail') ?>" id="profile-form2">
               <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
               <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($profile[0]->id)){ echo $profile[0]->id;} ?>">
               <input type="hidden" name="emergency_contact_id" id="emergency_contact_id" value="<?php if(isset($emergency_contact->id)){ echo $emergency_contact->id;} ?>">
            <div class="modal-body">
               <div class="form-group">
                  <div class="single-field ">
                     <input type="text" name="emergency_contact_name" id="emergency_contact_name"  value="<?php if(isset($emergency_contact->name)){ echo $emergency_contact->name;} ?>">
                     <label>Full Name</label>
                  </div>
               </div>
               <div class="form-group">
                  <div class="single-field">
                     <input type="text" name="emergency_contact_number" id="emergency_contact_number" value="<?php if(isset($emergency_contact->phone_number)){ echo $emergency_contact->phone_number;} ?>">
                     <label>Phone No.</label>
                  </div>
               </div>
               <div class="form-group">
                  <div class="single-field">
                     <input type="email" name="emergency_contact_email" id="emergency_contact_email"  value="<?php if(isset($emergency_contact->email)){ echo $emergency_contact->email;} ?>">
                     <label>Email</label>
                  </div>
               </div>
               <div class="form-group m-0">
                  <div class="single-field">
                     <textarea class="textarea" name="emergency_contact_address" id="emergency_contact_address"><?php if(isset($emergency_contact->address)){ echo $emergency_contact->address;} ?></textarea>
                     <label>Address</label>
                  </div>
               </div>
            </div>
            <div class="modal-footer">                         
               <button type="submit"  class="btn btn-primary text-right update-emergency_contact_detail">Update</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Emergency Contact Pop-Up End -->

<script type = "text/javascript">
   $('a.nav-link').click(function () {
      $('span.mb-custom-tab-active').text($(this).text());
      var id = $(this).attr('aria-controls');
      $('.tab-pane.fade').removeClass('show active');
      $('a').removeClass('active');
      $(this).addClass('active');
      var $this = $(this).text();
      $.each($('a.nav-link'), function () {
         if ($(this).text() == $this) {
            $(this).addClass('active');
            $(this).parent().addClass('active');
         }
      });
      $(this).parent().removeClass('active');
      $('#' + id).addClass('show');
   });
// function openCity(cityName, elmnt, color) {
//   // Hide all elements with class="tabcontent" by default */
//   var i, tabcontent, tablinks;
//   tabcontent = document.getElementsByClassName("tabcontent");
//   for (i = 0; i < tabcontent.length; i++) {
//     tabcontent[i].style.display = "none";
//   }

//   // Remove the background color of all tablinks/buttons
//   tablinks = document.getElementsByClassName("tablink");
//   for (i = 0; i < tablinks.length; i++) {
//     tablinks[i].style.backgroundColor = "";
//   }

//   // Show the specific tab content
//   document.getElementById(cityName).style.display = "block";
//   // Add the specific color to the button used to open the tab content
//   elmnt.style.backgroundColor = color;
// }

// Get the element with id="defaultOpen" and click on it
//document.getElementById("defaultOpen").click();
// openCity('profile-details', document.getElementById("defaultOpen"), 'orange');
$(document).ready(function () {
   var readURL = function (input) {
      if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function (e) {
            $('.profile-pic-url').attr('src', e.target.result);
         }

         reader.readAsDataURL(input.files[0]);
      }
   }
   $(".profile-pic").on('change', function () {
      readURL(this);
      $("#profile_image_change").submit();
   });

   $(".upload-button").on('click', function () {
      $(".profile-pic").click();
   });

   function daysInMonth(month, year) {
      return new Date(year, month, 0).getDate();
   }
   $("#birth_month").on('change', function () {
      var birth_month = $(this).val();
      if ($("#birth_year").val() != "") {
         var birth_year = $("#birth_year").val();
      } else {
         var birth_year = 1985;
      }
      var birth_day = $("#birth_day").val();
      var num = daysInMonth(birth_month, birth_year);
      console.log(num + "" + birth_day);
      var i;
      var option = "<option>-Day-</option>";
      for (i = 1; i <= num; i++) {
         option += "<option value='" + i + "'>" + i + "</option>";
      }
      $("#birth_day").html(option);
      $("#birth_day").val(birth_day);
   });

   $("#birth_year").on('change', function () {
      var birth_year = $(this).val();
      if ($("#birth_month").val() != "") {
         var birth_month = $("#birth_month").val();
      } else {
         var birth_month = 1985;
      }
      var birth_day = $("#birth_day").val();
      var num = daysInMonth(birth_month, birth_year);
      console.log(num + "" + birth_day);
      var i;
      var option = "<option>-Day-</option>";
      for (i = 1; i <= num; i++) {
         option += "<option value='" + i + "'>" + i + "</option>";
      }
      $("#birth_day").html(option);
      $("#birth_day").val(birth_day);
   });

   /* ----------------------------------- */
   $("#joining_month").on('change', function () {
      var joining_month = $(this).val();
      if ($("#joining_year").val() != "") {
         var joining_year = $("#joining_year").val();
      } else {
         var joining_year = 2016;
      }
      var joining_day = $("#joining_day").val();
      var num = daysInMonth(joining_month, joining_year);
      console.log(num + "" + joining_day);
      var i;
      var option = "<option>--Day--</option>";
      for (i = 1; i <= num; i++) {
         option += "<option value='" + i + "'>" + i + "</option>";
      }
      $("#joining_day").html(option);
      $("#joining_day").val(joining_day);
   });

   $("#joining_year").on('change', function () {
      var joining_year = $(this).val();
      if ($("#joining_month").val() != "") {
         var joining_month = $("#joining_month").val();
      } else {
         var joining_month = 1985;
      }
      var joining_day = $("#joining_day").val();
      var num = daysInMonth(joining_month, joining_year);
      console.log(num + "" + joining_day);
      var i;
      var option = "<option>--Day--</option>";
      for (i = 1; i <= num; i++) {
         option += "<option value='" + i + "'>" + i + "</option>";
      }
      $("#joining_day").html(option);
      $("#joining_day").val(joining_day);
   });
}); 

function getFileData(myFile){
    var file = myFile.files[0];  
    var filename = file.name;
    $('#upload-text span').text(filename);
}
</script>