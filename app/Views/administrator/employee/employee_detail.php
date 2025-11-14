<?php $user_id=$this->session->get('id');?>
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-12 col-md-12 col-xs-12">
         <h4 class="page-title">Profile page</h4>
      </div>
   </div>
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
      $photoURL = base_url().'assets/upload/passport_photo';
      $signature_url = base_url().'assets/signature256x256';
      ?>
    <div class="row">
        <div class="col-12 text-center">
            <div class="white-box">
                <div class="emp-custom-field">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="single-field select-field multi-field">
                                <select  id="employees_id" name="employees_id" >
                                    <option value="" disabled>Select Employee</option>
                                    <?php foreach($employee_list as $key => $val){ ?>
                                        <option <?php if(isset($employee_id) && $employee_id == $val->id) { echo "selected='selected'"; } ?> value="<?php echo $val->id; ?>"><?php echo $val->fname." ".$val->lname; ?></option>
                                    <?php } ?>
                                </select>
                                <label>Select Employee</label>
                            </div>        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <div class="row">
      <div class="col-12 col-xl-6">
         <div class="profile-box basic-info">
            <div class="massge_for_error text-center"><?php echo $this->session->getFlashdata('message'); ?></div>
            <form id="profile_image_change" enctype="multipart/form-data" method="post" action="<?php echo base_url('profile/profile_image_change') ?>">
            <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
               <div class="user-content">
                  <div class="pro-title">
                     <h3>Profile Details</h3>
                     <button type="button" data-toggle="modal" data-target="#basic_detail" class="pro-edit" data-tooltip="Edit Basic Detail" flow="left"><i class="fas fa-pencil-alt"></i></button>
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
                              <a href="<?php echo $image; ?>" target="_blank" id="profile_pic"><img src="<?php echo $image; ?>" class="profile-img profile-pic-url" alt="img"  ></a>
                        <!-- <div class="camera-icon upload-button"><i class="fas fa-camera"></i></div> -->
                     </div>
                  </div>
                  <div class="info-content">
                     <ul>
                        <li>
                           <span class="info-title">Name</span>
                           <span class="info-value" id="nameText"><?php if(isset($profile[0]->fname) && isset($profile[0]->lname)){ echo $profile[0]->fname.' '.$profile[0]->lname;} ?></span>
                        </li>
                        <li>
                           <span class="info-title">Email</span>
                           <span class="info-value" id="emailText"><?php echo $profile[0]->email; ?></span>
                        </li>
                        <li>
                           <span class="info-title">Personal Email</span>
                           <span class="info-value" id="personal_emailText"><?php echo $profile[0]->personal_email; ?></span>
                        </li>
                        <li>
                           <span class="info-title">Phone No.</span>
                           <span class="info-value" id="phone_noText"><?php echo $profile[0]->phone_number; ?></span>
                        </li>
                        <li>
                           <span class="info-title">User Role</span>
                           <span class="info-value" id="user_roleText"><?php echo ucwords($profile[0]->user_role); ?></span>
                        </li>
                        <li>
                           <span class="info-title">Date Of Birth</span>
                           <span class="info-value" id="date_of_birthText"><?php echo ($profile[0]->date_of_birth != '0000-00-00' && $profile[0]->date_of_birth != '' )?dateFormat($profile[0]->date_of_birth):''; ?></span>
                        </li>
                        <li>
                           <span class="info-title">Gender</span>
                           <span class="info-value" id="genderText"><?php echo ucwords($profile[0]->gender); ?></span>
                        </li>
                        <li>
                           <span class="info-title">Designation</span>
                           <span class="info-value" id="designationText">
                           <?php foreach ($designation as $key => $value){
                                if(isset($profile[0]->designation) && $profile[0]->designation == $value->id){ echo $value->name; } 
                            } ?>
                            </span>
                        </li>
                        <li>
                           <span class="info-title">Joining Date</span>
                           <span class="info-value" id="joining_dateText"><?php echo ($profile[0]->joining_date != '0000-00-00' && $profile[0]->joining_date != '' )?dateFormat($profile[0]->joining_date):''; ?></span>
                        </li>
                        <li>
                           <span class="info-title">Address</span>
                           <span class="info-value info-address" id="addressText"><?php echo $profile[0]->address; ?></span>
                        </li>
                        <li>
                            <span class="info-title">Agreement</span>
                            <span class="info-value info-address">
                              <span id="agreement_row">
                                View 
                                    <a target="_blank" class="btn sec-btn btn-sm view_agreement ml-1" id="view_agreement" title="View Agreement" data-tooltip="View Agreement" flow="left" href="<?php echo base_url(); ?>assets/agreement/agreement_<?php echo $profile[0]->id; ?>.pdf">
                                        <i class="fas fa-eye"></i>
                                    </a>
                              </span>
                                &nbsp;&nbsp;Upload 
                                <button type="button" data-toggle="modal" data-target="#agreement_pop" onclick="$('#noAgreement').text('No file chosen...');$('#agreement').val('');" class="btn sec-btn btn-sm pro-edit ml-1" data-tooltip="Upload Agreement" flow="left"><i class="fas fa-pencil-alt"></i></button>
                            </span>
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
                  <button type="button"  data-toggle="modal" data-target="#emergency_contact" class="pro-edit" data-tooltip="Edit Emergency Contact" flow="left"><i class="fas fa-pencil-alt"></i></button>
               </div>
               <div class="info-content">
               <?php if(isset($emergency_contact) && !empty($emergency_contact)){ $show2='d-none';$show1=''; }else{ $show1='d-none';$show2=''; } ?>
                  <ul class="<?= $show1 ?>" id="Found">
                     <li>
                        <span class="info-title">Name</span>
                        <span class="info-value" id="ecNameText"><?php echo isset($emergency_contact->name) ? $emergency_contact->name : ''; ?></span>
                     </li>
                     <li>
                        <span class="info-title">Phone No.</span>
                        <span class="info-value" id="ecNumberText"><?php echo isset($emergency_contact->phone_number) ? $emergency_contact->phone_number : ''; ?></span>
                     </li>
                     <li>
                        <span class="info-title">Email</span>
                        <span class="info-value" id="ecEmailText"><?php echo isset($emergency_contact->email) ? $emergency_contact->email : ''; ?></span>
                     </li>
                     <li>
                        <span class="info-title">Address</span>
                        <span class="info-value" id="ecAddressText"><?php echo isset($emergency_contact->address) ? $emergency_contact->address : ''; ?></span>
                     </li>
                  </ul>

                  <div class="empty-id-proof <?= $show2 ?>" id="notFound">
                     <p>Emergency Contact Not Found!</p>
                  </div>
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
                        <span class="info-value" id="salaryText">₹ <?php echo isset($profile[0]->salary) ? $profile[0]->salary : 0; ?></span>
                     </li>
                     <li>
                        <span class="info-title">Salary Deduction</span>
                        <span class="info-value" id=salary_deductionText><?php echo isset($profile[0]->salary_deduction) ? $profile[0]->salary_deduction : 0; ?>%</span>
                     </li>
                     <li>
                        <span class="info-title">Bank Name</span>
                        <span class="info-value" id="bank_nameText"><?php echo isset($profile[0]->bank_name) ? $profile[0]->bank_name : ''; ?></span>
                     </li>
                     <li>
                        <span class="info-title">Account No.</span>
                        <span class="info-value" id="account_noText"><?php echo isset($profile[0]->account_number) ? $profile[0]->account_number : ''; ?></span>
                     </li>
                     <li>
                        <span class="info-title">IFSC Code</span>
                        <span class="info-value" id="ifsc_codeText"><?php echo isset($profile[0]->ifsc_number) ? $profile[0]->ifsc_number : ''; ?></span>
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
                        <span class="info-value" id="upi_typeText"><?php echo (isset($profile[0]->upi_type) && $profile[0]->upi_type == 'gpay') ? 'Google Pay' : 'PhonePe'; ?></span>
                     </li>
                     <li>
                        <span class="info-title">UPI ID</span>
                        <span class="info-value" id="upi_idText"><?php echo isset($profile[0]->upi_id) ? $profile[0]->upi_id : ''; ?></span>
                     </li>
                     <li>
                        <div class="info-content m-auto" id="viewQR_code">
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
                  <button type="button" data-toggle="modal" data-target="#id_proof_pop" class="pro-edit" data-tooltip="Upload ID Proof" flow="left"><i class="fas fa-pencil-alt"></i></button>
               </div>
               <div class="info-content" id="viewId_proof">
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
                  <button type="button" data-toggle="modal" data-target="#passportphoto_pop" class="pro-edit" data-tooltip="Upload Passport Size Photo" flow="left"><i class="fas fa-pencil-alt"></i></button>
               </div>
               <div class="info-content" id="viewPassportphoto">
                    <?php if(isset($profile[0]->passport_photo) && !empty($profile[0]->passport_photo)){ 
                         $image1=$_SERVER['DOCUMENT_ROOT']."/assets/upload/passport_photo/".$profile[0]->passport_photo;
                         if(file_exists($image1)){
                            $image=base_url()."assets/upload/passport_photo/".$profile[0]->passport_photo;
                            $image_1=$photoURL.'/'.$profile[0]->passport_photo;
                        ?>
                        <a download href="<?php echo $image; ?>">
                           <img class="id-img" width="150" src="<?php echo $image_1; ?>">
                       </a> 
                        <?php }else{ ?>
                           <div class="empty-id-proof">
                           <p>Photo not uploaded.</p>
                        </div>   
                           <?php } }else{ ?>
                        <div class="empty-id-proof">
                           <p>Photo not uploaded.</p>
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
               <div class="info-content" id="signature">
                    <?php // if(isset($profile[0]->signature) && !empty($profile[0]->signature)){ 
                     //   $image1=$_SERVER['DOCUMENT_ROOT']."/assets/signature512x512/".$profile[0]->signature;
                     //   if(file_exists($image1)){
                     //      $image=base_url()."assets/signature512x512/".$profile[0]->signature;
                     //      $image_1=$signature_url.'/'.$profile[0]->signature;
                          ?>
                          <a download href="<?php //echo $image; ?>">
                           <img class="id-img" src="<?php // echo $image_1; ?>">
                        </a> 
                      <?php
                       //}else{ ?>
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
                        <span class="info-value" id="gmail_idText"><?php if(isset($gmail_account)){ echo $gmail_account;} ?></span>
                     </li>
                     <li>
                        <span class="info-title">Gmail Password</span>
                        <span class="info-value" id="gmail_passText"><?php if(isset($gmail_password)){ echo $gmail_password;} ?></span>
                     </li>
                     <li>
                        <span class="info-title">Skype Id</span>
                        <span class="info-value" id="skype_idText"><?php if(isset($skype_account)){ echo $skype_account;} ?></span>
                     </li>
                     <li>
                        <span class="info-title">Skype Password</span>
                        <span class="info-value" id="skype_passText"><?php if(isset($skype_password)){ echo $skype_password;} ?></span>
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
               <input type="hidden" name="slug" id="slug" value="/employee/detail">
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
                     <input type="radio" <?php if(isset($profile[0]->gender) && $profile[0]->gender == "female"){ ?> checked="checked" <?php } ?> name="gender" value="female" id="gender1" class="gender">Female
                  </div>
               </div>
               <div class="form-group">
                  <div class="single-field date-field">
                     <input type="text" name="joining_date" class="datepicker-here" id="joining_date"  data-date="<?php if(isset($profile[0]->joining_date)){ echo $profile[0]->joining_date;} ?>" value="<?php if(isset($profile[0]->joining_date)){ echo $profile[0]->joining_date;} ?>" data-language="en" autocomplete="off">
                     <label>Joining Date</label>
                  </div>
               </div>
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
               <button type="submit"  class="btn sec-btn text-right update-basic_detail">Update</button>
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
               <input type="hidden" name="slug" id="slug" value="/employee/detail">
            <div class="modal-body">
               <div class="form-group">
                  <div class="single-field ">
                     <input type="text" <?php //if(isset($profile[0]->bank_name) && !empty($profile[0]->bank_name)){ echo "readonly"; } ?> name="bank_name" id="bank_name"  value="<?php if(isset($profile[0]->bank_name)){ echo $profile[0]->bank_name;} ?>">
                     <label>Bank name</label>
                  </div>
               </div>
               <div class="form-group">
                  <div class="single-field">
                     <input type="number" <?php //if(isset($profile[0]->account_number) && !empty($profile[0]->account_number)){ echo "readonly"; } ?> name="account_number" id="account_number" value="<?php if(isset($profile[0]->account_number)){ echo $profile[0]->account_number;} ?>">
                     <label>Account No.</label>
                     <!-- <input type="text" placeholder="Account Number" class="form-control form-control-line" name="account_number" id="account_number"  value="<?php if(isset($profile[0]->account_number)){ echo $profile[0]->account_number;} ?>">-->
                  </div>
               </div>
               <div class="form-group m-0">
                  <div class="single-field">
                     <input type="text" <?php //if(isset($profile[0]->ifsc_number) && !empty($profile[0]->ifsc_number)){ echo "readonly"; } ?> name="ifsc_number" id="ifsc_number"  value="<?php if(isset($profile[0]->ifsc_number)){ echo $profile[0]->ifsc_number;} ?>">
                     <label>IFSC Code</label>
                  </div>
               </div>
            </div>
            <div class="modal-footer">                         
               <button type="submit"  class="btn sec-btn text-right update-bank_detail">Update</button>
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
               <h4 class="modal-title">Other Payment Method</h4>
            </div>
         </div>
         <form method="POST" enctype="multipart/form-data" method="post" action="<?php echo base_url('profile/insert_data') ?>" id="profile-form6">
               <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
               <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($profile[0]->id)){ echo $profile[0]->id;} ?>">
               <input type="hidden" name="detail_type" id="detail_type" value="payment_method">
               <input type="hidden" name="slug" id="slug" value="/employee/detail">
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
               <input type="hidden" name="slug" id="slug" value="/employee/detail">
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
               <button type="submit"  class="btn sec-btn text-right update-id_proof">Update</button>
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
               <input type="hidden" name="slug" id="slug" value="/employee/detail">
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
               <button type="submit"  class="btn sec-btn text-right update-credentials_detail">Update</button>
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
               <input type="hidden" name="slug" id="slug" value="/employee/detail">
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
               <button type="submit"  class="btn sec-btn text-right update-emp_signature">Update</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Signature Pop-Up End -->

<!-- ID Proof Pop-Up Start -->
<div class="modal" id="agreement_pop" role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <div class="modal_header-content">
               <h4 class="modal-title">Agreement</h4>
            </div>
         </div>
         <form method="POST" enctype="multipart/form-data" method="post" action="<?php echo base_url('profile/uploadAgreement') ?>" id="uploadAgreement-form">
               <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
               <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($profile[0]->id)){ echo $profile[0]->id;} ?>">
            <div class="modal-body">
               <div class="form-group">
                  <label>Agreement</label>
                  <div class="file-upload agreement_upload">
                     <div class="file-select">
                        <div class="file-select-button" id="fileName">Choose File</div>
                        <div class="file-select-name" id="noAgreement">No file chosen...</div>
                        <input type="file"  class="form-control form-control-line agreement" name="agreement" id="agreement">
                     </div>
                  </div>
                  <!-- <input type="file" class="form-control form-control-line" name="agreement" id="agreement"> -->
                  <input type="hidden" name="agreement_name" id="agreement_name" value="<?php echo base_url(); ?>assets/agreement/agreement_<?php echo $profile[0]->id; ?>.pdf">
               </div>
            </div>
            <div class="modal-footer">                         
               <button type="submit"  class="btn sec-btn text-right upload-agreement">Update</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- ID Proof Pop-Up End -->

<!-- Passport size photo Pop-Up Start -->
<div class="modal" id="passportphoto_pop" role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <div class="modal_header-content">
               <h4 class="modal-title">Passport Size Photo</h4>
            </div>
         </div>
         <form method="POST" enctype="multipart/form-data" method="post" action="<?php echo base_url('profile/insert_data') ?>" id="passportphoto-form">
               <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
               <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($profile[0]->id)){ echo $profile[0]->id;} ?>">
               <input type="hidden" name="detail_type" id="detail_type" value="passport_photo">
            <div class="modal-body">
               <div class="form-group">
                  <label>Passport Size Photo</label>
                  <div class="file-upload photo_upload">
                     <div class="file-select">
                        <div class="file-select-button" id="fileName">Choose File</div>
                        <div class="file-select-name" id="noPassportphoto">No file chosen...</div>
                        <input type="file"  class="form-control form-control-line passportPhoto" name="passportPhoto" id="passportPhoto">
                     </div>
                  </div>
                  <input type="hidden" name="passportPhoto_name" id="passportPhoto_name" value="<?php if(isset($profile[0]->passport_photo) && !empty($profile[0]->passport_photo)){ echo $profile[0]->passport_photo; }?>">
               </div>
            </div>
            <div class="modal-footer">                         
               <button type="submit"  class="btn sec-btn text-right update-passportphoto">Upload</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Passport size photo Pop-Up End -->
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
         <form method="POST" enctype="multipart/form-data" method="post" action="<?php echo base_url('profile/insert_emergency_detail') ?>" id="profile-ec_detail">
               <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
               <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($profile[0]->id)){ echo $profile[0]->id;} ?>">
               <input type="hidden" name="emergency_contact_id" id="emergency_contact_id" value="<?php if(isset($emergency_contact->id)){ echo $emergency_contact->id;} ?>">
               <input type="hidden" name="slug" id="slug" value="/employee/detail">
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
               <button type="submit"  class="btn sec-btn text-right update-emergency_contact_detail">Update</button>
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

   $('#employees_id').change(function(){
        getEmployee_detail();
   });

   $('#uploadAgreement-form').submit(function(){
      $('.preloader').attr('style', 'display:block !important');
      var $id = $(this).find('#e_id').val();
      $.ajax({
         url: base_url+"profile/uploadAgreement",
         type: "post",
         data:new FormData(this),
         processData:false,
         contentType:false,
         cache:false,
         // async:false,
         success: function (response) {
               var obj = JSON.parse(response);
               $('.msg-container').html(obj.message);
               $('.msg-container .msg-box').attr('style','display:block');
               setTimeout(function() {
                  $('.msg-container .msg-box').attr('style','display:none');
               }, 6000);
               if(obj.error_code == 0){
                  window.location.href = base_url+'employee/detail/'+$id;
                  $('#agreement_pop').modal('hide');
               }
         },
      });
      $('.preloader').attr('style', 'display:none !important');
      return false;
   });

   $('.agreement').bind('change', function() {
   var filename = $(".agreement").val();
   if (/^\s*$/.test(filename)) {
      $(".agreement_upload").removeClass('active');
      $("#noAgreement").text("No File chosen...");
   } else {
      $(".agreement_upload").addClass('active');
      $("#noAgreement").text(filename.replace("C:\\fakepath\\", ""));
   }
});

$('#passportphoto-form').submit(function(){
      $('.preloader').attr('style', 'display:block !important');
      var $id = $(this).find('#e_id').val();
      $.ajax({
         url: base_url+"profile/uploadPhoto",
         type: "post",
         data:new FormData(this),
         processData:false,
         contentType:false,
         cache:false,
         // async:false,
         success: function (response) {
               var obj = JSON.parse(response);
               $('.msg-container').html(obj.message);
               $('.msg-container .msg-box').attr('style','display:block');
               setTimeout(function() {
                  $('.msg-container .msg-box').attr('style','display:none');
               }, 6000);
               if(obj.error_code == 0){
                  window.location.href = base_url+'employee/detail/'+$id;
                  $('#passportphoto_pop').modal('hide');
               }
         },
      });
      $('.preloader').attr('style', 'display:none !important');
      return false;
   });

   $('.passportPhoto').bind('change', function() {
   var filename = $(".passportPhoto").val();
   if (/^\s*$/.test(filename)) {
      $(".passportphoto_upload").removeClass('active');
      $("#noPassportphoto").text("No File chosen...");
   } else {
      $(".passportphoto_upload").addClass('active');
      $("#noPassportphoto").text(filename.replace("C:\\fakepath\\", ""));
   }
});

   function getEmployee_detail(){
    $('.preloader').attr('style', 'display:block !important');
    var base_url = $("#js_data").data('base-url');
    var id = $('#employees_id').val();
    $.ajax({
        url: base_url + "employee/detail",
        type: "POST",
        data: { id },
        success: function(response){
            if(response){
                var obj = JSON.parse(response);
                $('#profile_pic img').attr('src',obj.profile[0].profile_image);
                var credential = JSON.parse(obj.profile[0].credential);
                if(obj.profile[0].agreement != ''){
                    $('#agreement_row').show();
                    $('#view_agreement').attr('href',obj.profile[0].agreement);
                    $('.upload-agreement').text('Update');
                }else{
                    $('#agreement_row').hide();
                    $('.upload-agreement').text('Add');
                }
                $('#profile_pic').attr('href',obj.profile[0].profile_image);
                $('#nameText').text(obj.profile[0].fname+' '+obj.profile[0].lname);
                $('#e_id').val(obj.profile[0].id);
                $('#profile-form6 #e_id,#profile-form5 #e_id,#profile-form4 #e_id,#profile-form3 #e_id,#profile-form2 #e_id,#profile-form1 #e_id,#passportphoto-form #e_id,#profile-ec_detail #e_id').val(obj.profile[0].id);
                $('#fname').val(obj.profile[0].fname);
                $('#lname').val(obj.profile[0].lname);
                $('#emailText').text(obj.profile[0].email);
                $('#email').val(obj.profile[0].email);
                $('#personal_emailText').text(obj.profile[0].personal_email);
                $('#personal_email').val(obj.profile[0].personal_email);
                $('#phone_noText').text(obj.profile[0].phone_number);
                $('#phone_number').val(obj.profile[0].phone_number);
                $('#user_roleText').text(obj.profile[0].user_role);
                $('#user_role').val(obj.profile[0].user_role);
                $('#date_of_birthText').text(obj.profile[0].date_of_birth);
                $('#birth_date').val(obj.profile[0].date_of_birth);
                if (obj.profile[0].date_of_birth != '') {
                    var currentDate = new Date(obj.profile[0].date_of_birth);
                    $('#birth_date').datepicker().data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()));
                }
                $('#genderText').text(obj.profile[0].gender);
                (obj.profile[0].gender != 'Female') ? $('#gender').prop('checked',true) : $('#gender1').prop('checked',true);
                $('#designationText').text(obj.profile[0].name);
                
                $('#joining_dateText').text(obj.profile[0].joining_date);
                $('#joining_date').val(obj.profile[0].joining_date);
                if (obj.profile[0].joining_date != '') {
                    var currentDate = new Date(obj.profile[0].joining_date);
                    $('#joining_date').datepicker().data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()));
                }
                $('#addressText').text(obj.profile[0].address);
                $('#address').val(obj.profile[0].address);
                $('#salaryText').text('₹ '+obj.profile[0].salary);
                $('#salary').val('₹ '+obj.profile[0].salary);
                $('#salary_deductionText').text(obj.profile[0].salary_deduction+'%');
                $('#salary_deduction').val(obj.profile[0].salary_deduction);
                $('#bank_nameText').text(obj.profile[0].bank_name);
                $('#bank_name').val(obj.profile[0].bank_name);
                $('#account_noText').text(obj.profile[0].account_number);
                $('#account_number').val(obj.profile[0].account_number);
                $('#ifsc_codeText').text(obj.profile[0].ifsc_number);
                $('#ifsc_number').val(obj.profile[0].ifsc_number);
                $('#upi_idText').text(obj.profile[0].upi_id);
                $('#upi_id').val(obj.profile[0].upi_id);
                $('#upi_typeText').text((obj.profile[0].upi_type == 'gpay')?'Google Pay':'PhonePe');
                $('#upi_type').val(obj.profile[0].upi_type);
                $('#viewQR_code').html(obj.profile[0].qr_code);
                $('#viewId_proof').html(obj.profile[0].id_proof);
                $('#viewPassportphoto').html(obj.profile[0].passport_photo);
                $('#signature').html(obj.profile[0].signature);
                $('#gmail_idText').text(credential.gmail.gmail_account);
                $('#gmail_account').val(credential.gmail.gmail_account);
                $('#gmail_passText').text(credential.gmail.gmail_password);
                $('#gmail_password').val(credential.gmail.gmail_password);
                $('#skype_idText').text(credential.skype.skype_account);
                $('#skype_account').val(credential.skype.skype_account);
                $('#skype_passText').text(credential.skype.skype_password);
                $('#skype_password').val(credential.skype.skype_password);

                if(obj.emergency_contact == '' || obj.emergency_contact == null){
                  $('#emergency_contact_id,#emergency_contact_name,#emergency_contact_number,#emergency_contact_email,#emergency_contact_address').val('');
                  $('#ecAddressText,#ecNameText,#ecNumberText,#ecEmailText').text('');
                  $('#notFound').removeClass('d-none');
                  $('#Found').addClass('d-none');
                }else{
                   $('#emergency_contact_id').val(obj.emergency_contact.id);
                   $('#ecNameText').text(obj.emergency_contact.name);
                   $('#emergency_contact_name').val(obj.emergency_contact.name);
                   $('#ecNumberText').text(obj.emergency_contact.phone_number);
                   $('#emergency_contact_number').val(obj.emergency_contact.phone_number);
                   $('#ecEmailText').text(obj.emergency_contact.email);
                   $('#emergency_contact_email').val(obj.emergency_contact.email);
                   $('#ecAddressText').text(obj.emergency_contact.address);
                   $('#emergency_contact_address').val(obj.emergency_contact.address);
                  $('#Found').removeClass('d-none');
                  $('#notFound').addClass('d-none');
                }
                
                $('#designation').each(function(i,v){
                  if($(this).text() == obj.profile[0].name) $(this).prop('selected',true);
                });
            }
            $('.preloader').attr('style', 'display:none !important');
        },
    });
   }

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