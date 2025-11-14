
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login V1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/vendor/animate/animate.css">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/vendor/select2/select2.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/css/util.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/css/main.css">
<!--===============================================================================================-->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/air-datepicker.min.css">
<style>
    .massge_for_error {
        color: red;
    }
.error {
    background: transparent !important;
    border-top: 1px solid #ff0000 !important;
}

</style>
</head>
<script src='https://www.google.com/recaptcha/api.js'></script>

<body>
    
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
			<div class="massge_for_error text-center"><?php echo $this->session->getFlashdata('message'); ?> </div>
                <div class="massge_for_error text-center"><?php echo $this->session->getFlashdata('user_exists_message'); ?> </div>
			  <form class="form-horizontal form-material" method="post" action="<?php echo base_url('login/insert_data'); ?>" id="employee-form">
                    <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">
                    <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
                        <div class="row">
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label class="col-md-12">First Name *</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="First Name" class="form-control form-control-line" name="fname" id="fname" value=""> </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Last Name *</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Last Name" class="form-control form-control-line" name="lname" id="lname" value=""> </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">Email *</label>
                                    <div class="col-md-12">
                                        <input type="email" placeholder="Email" class="form-control form-control-line" name="email" id="email"  value=""> </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Phone No *</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Phone No" class="form-control form-control-line" name="phone_number" id="phone_number"  value=""> </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Gender *</label>
                                    <div class="col-md-12">
										<input type="radio"  name="gender" value="male" id="gender" class="radio-class gender">Male
                                        <input type="radio"    name="gender" value="female" id="gender1" class="radio-class gender">Female
                                    </div>
                                </div>
                            </div>
							<div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Designation *</label>
                                    <div class="col-md-12">
                                       <select class="form-control form-control-line" name="designation" id="designation">
                                            <option value="">Designation</option>
                                            <?php foreach ($designation as $key => $value) { ?>
                                             <option  value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                                    
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
							<div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Joining Date *</label>
                                    <div class="col-md-12">
                                      <input type="text" placeholder="Joining Date" class="form-control form-control-line" name="joining_date" id="joining_date"  value="">
                                    </div>
                                </div>
                            </div>
							<div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Date of Birth *</label>
                                    <div class="col-md-12">
                                      <input type="text" placeholder="Date of Birth" class="form-control form-control-line" name="birth_date" id="birth_date"  value="">
                                    </div>
                                </div>
                            </div>
							
                           

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12">Address *</label>
                                    <div class="col-md-12">
                                        <textarea rows="4" class="form-control form-control-line textarea" name="address" id="address"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Gmail ID *</label>
                                    <div class="col-md-12">
									<input type="text" placeholder="Gmail ID" class="form-control form-control-line" name="gmail_account" id="gmail_account" value="">
                                    </div>
                                </div>
                            </div>
							<div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Gmail Password *</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Gmail Password" class="form-control form-control-line" name="gmail_password" id="gmail_password" value="">
                                    </div>
                                </div>
                            </div>
							<div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Skype ID *</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Skype ID" class="form-control form-control-line" name="skype_account" id="skype_account" value="">
                                    </div>
                                </div>
                            </div>
							<div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Skype Password *</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Skype Password" class="form-control form-control-line" name="skype_password" id="skype_password" value="">
                                    </div>
                                </div>
                            </div> -->
							<div class="col-md-6">
                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>"></div>
                                </div>
                            </div>
							
							
							<br>
						   <div class="col-md-12">
                                <div class="form-group">
									
                                    <div class="col-sm-12">
                                        <button class="btn btn-success submit_form">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
				</form>
               
            </div>
        </div>
    </div>
    
    

    
<!--===============================================================================================-->  
    <script src="<?php echo base_url(); ?>assets/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
    <script src="<?php echo base_url(); ?>assets/login/vendor/bootstrap/js/popper.js"></script>
    <script src="<?php echo base_url(); ?>assets/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
    <script src="<?php echo base_url(); ?>assets/login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
    <script src="<?php echo base_url(); ?>assets/login/vendor/tilt/tilt.jquery.min.js"></script>
    <script >
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
	<script src="<?php echo base_url(); ?>assets/js/air-datepicker.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/air-datepicker.en.js"></script>
	<script>
	$('#joining_date').datepicker({
				dateFormat: 'yyyy-mm-dd',
				language: 'en',
	});
	$('#birth_date').datepicker({
				dateFormat: 'yyyy-mm-dd',
				language: 'en',
	});
	$("#employee-form").submit(function(e) {
          var fname=$("#fname").val();
          var lname=$("#lname").val();
          var email=$("#email").val();
         
          var birth_date=$("#birth_date").val();
         
		  var joining_date=$("#joining_date").val();
         
		  /* var skype_account=$("#skype_account").val();
		  var skype_password=$("#skype_password").val();
		  var gmail_account=$("#gmail_account").val();
		  var gmail_password=$("#gmail_password").val(); */
		   var gender = true;
          $('#gender').each(function(){
             gender = gender && $(this).is(':checked');
          });
          var address=$("#address").val();
          var designation=$("#designation").val();
          var phone_number=$("#phone_number").val();
          if(!fname || !lname || !email || !phone_number || !birth_date || !joining_date  || !address || !designation ||  !skype_password || !skype_account || !gmail_password || !gmail_account){
              e.preventDefault();
              if(!fname){
                $("#fname").addClass('error');
              }
              else{
                $("#fname").removeClass('error');
              }
              if(!lname){
                $("#lname").addClass('error');
              }
              else{
                $("#lname").removeClass('error');
              }
              if(!email){
                $("#email").addClass('error');
              }
              else{
                $("#email").removeClass('error');
              }
              if(!phone_number){
                $("#phone_number").addClass('error');
              }
              else{
                $("#phone_number").removeClass('error');
              }
              if(!birth_date){
				$("#birth_date").addClass('error');
			  }
              else{
                $("#birth_date").removeClass('error');
              }
			  if(!joining_date){
				$("#joining_date").addClass('error');
			  }
              else{
                $(joining_date).removeClass('error');
              }
			
			  if(!designation){
                $("#designation").addClass('error');
              }
              else{
                $("#designation").removeClass('error');
              }
              if(!address){
                $("#address").addClass('error');
              }
              else{
                $("#address").removeClass('error');
              }
			 /*  if(!gmail_account){
                $("#gmail_account").addClass('error');
				//error_messages +="<span class='massge_for_error gmail_err text-center'>Please Enter Employee Gmail Account</span><br/>";
			  }
              else{
				if(isEmail(gmail_account) == false){
					$("#gmail_account").addClass('error');
					//error_messages +="<span class='massge_for_error gmail_err text-center'>Please Enter Valid Employee Gmail Account</span><br/>";
				}
				else{
					$("#gmail_account").removeClass('error');
					//$(".message_error").remove();
				}
              } 
			   if(!gmail_password){
                $("#gmail_password").addClass('error');
				//error_messages +="<span class='massge_for_error gmail_pass_err text-center'>Please Enter Employee Gmail Password</span><br/>";
			  }
              else{
                $("#gmail_password").removeClass('error');
				//$(".message_error").remove();
              }
			  if(!skype_account){
                $("#skype_account").addClass('error');
				//error_messages +="<span class='massge_for_error skype_err text-center'>Please Enter Employee Skype Account</span><br/>";
			  }
              else{
				if(isEmail(skype_account) == false){
					$("#skype_account").addClass('error');
					//error_messages +="<span class='massge_for_error skype_err text-center'>Please Enter Valid Employee Skype Account</span><br/>";
				}
				else{
					$("#skype_account").removeClass('error');
					//$(".message_error").remove();
				}
              }
			  if(!skype_password){
                $("#skype_password").addClass('error');
				//error_messages +="<span class='massge_for_error skype_pass_err text-center'>Please Enter Employee Skype Password</span><br/>";
			  }
              else{
                $("#skype_password").removeClass('error');
				//$(".message_error").remove();
              } */
            return false;       
          }	
          else{
            $("#fname").removeClass('error');
            $("#lname").removeClass('error');
            $("#email").removeClass('error');
            $("#password").removeClass('error');  
            $("#birth_date").removeClass('error');
			$("#joining_date").removeClass('error');
			$("#birth_day").removeClass('error');
			$("#gender1").removeClass('error');
            $("#address").removeClass('error');
            $("#designation").removeClass('error');
			$("#gmail_account").removeClass('error');
			$("#gmail_password").removeClass('error');
			$("#skype_account").removeClass('error');
			$("#skype_password").removeClass('error');
              return true;  
            
          }
        });

	</script>
<!--===============================================================================================-->
    <script src="<?php echo base_url(); ?>assets/login/js/main.js"></script>

</body>
</html>