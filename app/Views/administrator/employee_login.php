<?php 
	$uid = isset($uid) ? $uid : '';
	$token = isset($token) ? $token : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>

	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/favicon.png" />

	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/all.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/air-datepicker.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/login/css/style.css?dsf">

	<style>
		.massge_for_error.text-center {
			color: red;
		}
	</style>
	<script src="https://www.google.com/recaptcha/api.js?render=<?php echo SITE_KEY; ?>"></script>
	<script>
		grecaptcha.ready(function() {
			grecaptcha.execute("<?php echo SITE_KEY; ?>", {
				action: 'employee'
			}).then(function(token) {
				var recaptchaResponse = document.getElementById('recaptchaResponse');
				recaptchaResponse.value = token;
				/* var recaptchaResponse = document.getElementById('recaptchaResponse1');
				recaptchaResponse.value = token; */
			});
		});
	</script>
</head>

<body>
	<div id="js_data" data-base-url="<?php echo base_url(); ?>"></div>

	<div class="login-wrap">
		<div class="login-left">
			<div class="site-logo">
				<img src="<?php echo base_url(); ?>assets/images/decodex.svg" alt="Site Logo">
			</div>
			<div class="welcome-img">
				<img src="<?php echo base_url(); ?>assets/images/welcome img.svg?dfg" alt="Welcome Back">
			</div>
		</div>
		<div class="login-right">
			<div class="login-form">
				<form class="validate-form" method="POST" id="employee-login_form" action="<?php echo base_url('login'); ?>">
					<!-- <div class="massge_for_error text-center"><?php //echo session()->getFlashdata('message'); 
																	?> </div>
					<div class="massge_for_error text-center"><?php //echo session()->getFlashdata('messages'); 
													?> </div> -->
					<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
					<h2 class="title"><span>Welcome Back!</span>Sign into your Account</h2>
					<div class="sign-field">
						<input type="text" name="email" id="email" class="input100">
						<label class="sign-label" for="email"><i class="fas fa-user"></i>Username</label>
					</div>
					<div class="sign-field">
						<div class="pwd">
							<input type="password" name="password" class="input100" id="password">
							<div class="pass-eye" data-id="password">
								<i class="fas fa-eye"></i>
							</div>
						</div>
						<div class="forgot-pwd"><small class="cur-pointer" data-toggle="modal" data-target="#forgotPass" onclick="$('#resetEmail').val('').removeClass('error');">Forgot Password</small></div>
						<label class="sign-label" for="password"><i class="fas fa-key"></i>Password</label>
					</div>
					<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
					<input type="submit" value="Sign in" class="btn btn_login">
				</form>
			</div>
			<div class="copyright">
				<i class="far fa-copyright"></i> Copyright <?php echo date('Y'); ?> by <a href="javascript:void(0);">DecodeX Infotech</a>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="forgotPass" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Forgot Password</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
				</div>
				<div class="modal-body">
					<form method="post" action="<?php // echo base_url('login/sendForgotPass'); 
												?>" id="forgotPass-form">
						<div class="sign-field m-0">
							<input type="text" name="resetEmail" id="resetEmail" class="input100">
							<label class="sign-label" for="resetEmail"><i class="fas fa-user"></i>Mail Address</label>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary sendLink">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="d-none" id="error_massage"><?php echo $error_massage ?></div>

	<!--===============================================================================================-->
	<!-- <script src="<?php // echo base_url(); 
						?>/assets/login/vendor/jquery/jquery-3.2.1.min.js"></script> -->
	<script src="<?php echo base_url(); ?>/assets/login/vendor/jquery/jquery-3.6.0.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>assets/login/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo base_url(); ?>assets/login/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>assets/login/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>assets/login/vendor/tilt/tilt.jquery.min.js"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<?php if (isset($vaidate_token) && $vaidate_token == 1) { ?>
		<div class="modal" id="changePass" role="dialog" data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<div class="modal_header-content">
							<h4 class="modal-title">Change Password</h4>
						</div>
					</div>
					<form method="Post" action="<?php echo base_url() . 'resetPassword/' . $uid . '/' . $token; ?>" id="changePassForm">
						<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
						<input type="hidden" name="token" id="token" value="<?php echo $token; ?>">
						<input type="hidden" name="uid" id="uid" value="<?php echo $uid; ?>">
						<div class="modal-body">

							<div class="sign-field ">

								<input type="password" name="new_password" id="new_password" value="">
								<div class="pass-eye" data-id="changePassForm #new_password">
									<i class="fas fa-eye"></i>
								</div>
								<label class="sign-label" for="password"><i class="fas fa-key"></i>New Password</label>

							</div>

							<div class="sign-field pwd m-0">
								<input type="password" name="confirm_password" id="confirm_password" value="">
								<div class="pass-eye" data-id="changePassForm #confirm_password">
									<i class="fas fa-eye"></i>
								</div>
								<label class="sign-label" for="password"><i class="fas fa-key"></i>Confirm New Password</label>
							</div>


							<!-- <div class="form-group">
								<div class="single-field pwd">
									<input type="password" name="new_password" id="new_password" value="">
									<div class="pass-eye" >
										<i class="fas fa-eye"></i>
									</div>
									<label>New Password</label>
								</div>
							</div>
							<div class="form-group m-0">
								<div class="single-field pwd">
									<input type="password" name="confirm_password" id="confirm_password" value="">
									<div class="pass-eye" >
										<i class="fas fa-eye"></i>
									</div>
									<label>Confirm New Password</label>
								</div>
							</div> -->

						</div>
						<div class="modal-footer">
							<input type="button" class="btn btn-primary text-right resetPass" value="Reset">
						</div>
					</form>
				</div>
			</div>
		</div>
		<script>
			$("#changePass").modal('show');
		</script>
	<?php } elseif(isset($token_expired['message'])){ ?>
		<div class="msg-container">
			<div class="msg-box error-box" style="display:none">
				<div class="msg-content">
					<div class="msg-icon"><i class="fas fa-times"></i></div>
					<div class="msg-text">
						<p><?php echo $token_expired['title']; ?> <br> <?php echo $token_expired['message']; ?></p>
					</div>
				</div>
			</div>
		</div>
		<script>
			$('.msg-container .msg-box').attr('style', 'display:block');
				setTimeout(function() {
					$('.msg-container .msg-box').attr('style', 'display:none');
				}, 6000);
		</script>
	<?php } ?>
	<script src="<?php echo base_url(); ?>assets/js/air-datepicker.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/air-datepicker.en.js"></script>
	<script>
		$('.sendLink').click(function() {
			sendLink();
		});
		$('.resetPass').click(function() {
			changePassword();
		});

		function changePassword() {
			$('.preloader-2').attr('style', 'display:block !important;');
			var $num = 0;
			var new_password = $('#changePassForm #new_password').val();
			var confirm_password = $('#changePassForm #confirm_password').val();
			var token = $('#changePassForm #token').val();
			var uid = $('#changePassForm #uid').val();
			var text = '';
			if(new_password != ''){
				$('#changePassForm #new_password').removeClass('error');
			}else{
				$('#changePassForm #new_password').addClass('error');
				$num++;
			}
			if(confirm_password != ''){
				$('#changePassForm #confirm_password').removeClass('error');
			}else{
				$('#changePassForm #confirm_password').addClass('error');
				$num++;
			}
			if(token == ''){
				text += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Token not found!</p></div></div></div>';
				$num++;
			}
			if(uid == ''){
				text += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>User id not found!</p></div></div></div>';
				$num++;
			}

			if($num == 0){
				var data = {
					'new_password': new_password,
					'confirm_password': confirm_password,
					'token': token,
					'uid': uid,
				};
				$.ajax({
					url: "<?php echo base_url() . 'resetPassword/' . $uid . '/' . $token; ?>",
					type: "post",
					data: data,
					success: function(response) {
						// console.log(response);
						var data = JSON.parse(response);
						if (data['token_expired'] != undefined) {
							$('.msg-container').html('<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>' + data['token_expired']['message'] + '</p></div></div></div>');
							$('.msg-container .msg-box').attr('style', 'display:block');
							setTimeout(function() {
								$('.msg-container .msg-box').attr('style', 'display:none');
							}, 6000);
							$('#changePass').modal('hide');
							$('#changePass').remove();
							const nextURL = $("#js_data").data('base-url');
							const nextTitle = 'Login';
							const nextState = { additionalInformation: 'Login' };
							window.history.replaceState(nextState, nextTitle, nextURL);
						} else {
							$('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' + data['error'] + '</p></div></div></div>');
							$('.msg-container .msg-box').attr('style', 'display:block');
							setTimeout(function() {
								$('.msg-container .msg-box').attr('style', 'display:none');
							}, 6000);
						}
					},
				});
			}else{
				if(text != ''){
					$('.msg-container').html(text);
					$('.msg-container .msg-box').attr('style', 'display:block');
					setTimeout(function() {
						$('.msg-container .msg-box').attr('style', 'display:none');
					}, 6000);
				}
			}
			$('.preloader-2').attr('style', 'display:none !important;');
			return false;
		}

		function sendLink() {
			$('.sendLink').prop('disabled', true);
			$('.preloader-2').attr('style', 'display:block !important;');
			var resetEmail = ($('#forgotPass-form #resetEmail').val()).trim();
			if(resetEmail != ''){
				$('#forgotPass-form #resetEmail').removeClass('error');
				var data = {
					'email': resetEmail,
				};
				$.ajax({
					url: "<?php echo base_url(); ?>login/sendForgotPass",
					type: "post",
					data: data,
					success: function(response) {
						var data = JSON.parse(response);
						if(data['error_code'] == 0){
							$('.msg-container').html(data['message']);
							$('.msg-container .msg-box').attr('style', 'display:block');
							setTimeout(function() {
								$('.msg-container .msg-box').attr('style', 'display:none');
							}, 6000);
							$('#forgotPass').modal('hide');
						}else{
							$('.msg-container').html(data['message']);
							$('.msg-container .msg-box').attr('style', 'display:block');
							setTimeout(function() {
								$('.msg-container .msg-box').attr('style', 'display:none');
							}, 6000);
						}
					},
				});
			}else{
				$('#forgotPass-form #resetEmail').addClass('error');
			}
			$('.sendLink').prop('disabled', false);
			$('.preloader-2').attr('style', 'display:none !important;');
		}
		$('.pass-eye').click(function() {
			var $input = $(this).parent('div').find('input');
			// var id = $(this).data('id');
			if ($(this).hasClass('show')) {
				$(this).removeClass('show');
				// $('#'+id).attr('type', 'password');
				$input.attr('type', 'password');
			} else {
				$(this).addClass('show');
				// $('#'+id).attr('type', 'text');
				$input.attr('type', 'text');
			}
		});
		/* $('.pass-eye').click(function() {
			if ($(this).hasClass('show')) {
				$(this).removeClass('show');
				$('#password').attr('type', 'password');
			} else {
				$(this).addClass('show');
				$('#password').attr('type', 'text');
			}
		}); */
		$('#joining_date').datepicker({
			dateFormat: 'yyyy-mm-dd',
			language: 'en',
		});
		$('#birth_date').datepicker({
			dateFormat: 'yyyy-mm-dd',
			language: 'en',
		});
		$(".btn_login").click(function(e) {
			var password = $("#password").val();
			var email = $("#email").val();

			if (!password || !email) {
				e.preventDefault();
				if (!password) {
					$("#password").addClass('error');
				} else {
					$("#password").removeClass('error');
				}
				if (!email) {
					$("#email").addClass('error');
				} else {
					$("#email").removeClass('error');
				}
				return false;
			} else {
				$('.preloader-2').attr('style', 'display:block !important;');
				$("#password").removeClass('error');
				$("#email").removeClass('error');
				$('.btn_login').prop('disabled', true);
				$('.preloader-2').attr('style', 'display:block !important;');
				var csrf_test_name = $("input[name=csrf_test_name]").val();
				var base_url = $("#js_data").data('base-url');
				var data = {
					'csrf_test_name': csrf_test_name,
					'password': $("#password").val(),
					'email': $("#email").val()
				};
				$.ajax({
					url: base_url + "login/js_validation",
					type: "post",
					data: data,
					success: function(response) {
						console.log(response);
						var obj = JSON.parse(response);
						if (obj.error_code) {
							$('.msg-container').html(obj.massage);
							$('.msg-container .msg-box').attr('style', 'display:block');
							$('.preloader-2').attr('style', 'display:none !important;');
							setTimeout(function() {
								$('.msg-container .msg-box').attr('style', 'display:none');
							}, 6000);
							$('.btn_login').prop('disabled', false);
							return false;
						} else {
							$('.preloader-2').attr('style', 'display:none !important;');
							$('.btn_login').prop('disabled', false);
							$("#employee-login_form").submit();
							return true;
						}
					},
					error: function(response) {
						console.log(response);
					},
				});
				$('.preloader-2').attr('style', 'display:none !important;');
				return false;
			}
		});
		$("#employee-form").submit(function(e) {
			var fname = $("#fname").val();
			var lname = $("#lname").val();
			var email = $("#email1").val();

			var birth_date = $("#birth_date").val();

			var joining_date = $("#joining_date").val();

			/* var skype_account=$("#skype_account").val();
			var skype_password=$("#skype_password").val();
			var gmail_account=$("#gmail_account").val();
			var gmail_password=$("#gmail_password").val(); */
			var gender = true;
			$('#gender').each(function() {
				gender = gender && $(this).is(':checked');
			});
			var address = $("#address").val();
			var designation = $("#designation").val();
			var phone_number = $("#phone_number").val();
			// if(!fname || !lname || !email || !phone_number || !birth_date || !joining_date  || !address || !designation ||  !skype_password || !skype_account || !gmail_password || !gmail_account){
			if (!fname || !lname || !email || !phone_number || !birth_date || !joining_date || !address || !designation || !gender) {
				e.preventDefault();
				if (!fname) {
					$("#fname").addClass('error');
				} else {
					$("#fname").removeClass('error');
				}
				if (!lname) {
					$("#lname").addClass('error');
				} else {
					$("#lname").removeClass('error');
				}
				if (!email) {
					$("#email1").addClass('error');
				} else {
					$("#email1").removeClass('error');
				}
				if (!phone_number) {
					$("#phone_number").addClass('error');
				} else {
					$("#phone_number").removeClass('error');
				}
				if (!birth_date) {
					$("#birth_date").addClass('error');
				} else {
					$("#birth_date").removeClass('error');
				}
				if (!joining_date) {
					$("#joining_date").addClass('error');
				} else {
					$("#joining_date").removeClass('error');
				}

				if (!designation) {
					$("#designation").addClass('error');
				} else {
					$("#designation").removeClass('error');
				}
				if (!address) {
					$("#address").addClass('error');
				} else {
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
			} else {
				$("#fname").removeClass('error');
				$("#lname").removeClass('error');
				$("#email1").removeClass('error');
				// $("#password").removeClass('error');  
				$("#birth_date").removeClass('error');
				$("#joining_date").removeClass('error');
				$("#birth_day").removeClass('error');
				// $("#gender1").removeClass('error');
				$("#address").removeClass('error');
				$("#designation").removeClass('error');
				// $("#gmail_account").removeClass('error');
				// $("#gmail_password").removeClass('error');
				// $("#skype_account").removeClass('error');
				// $("#skype_password").removeClass('error');
				/* $('.preloader-2').attr('style', 'display:block !important;');
				var base_url = $("#js_data").data('base-url');
				var data = { 'id': $("#employee").val(), 'month': $("#month").val(), 'year': $("#year").val() };
				$.ajax({
				    url: base_url + "login/js_validation",
				    type: "post",
				    data: data,
				    success: function(response) {

				        $('.preloader-2').attr('style', 'display:none !important;');
				        return true;  
				    },
				}); */

			}
		});
		// const nextURL = $("#js_data").data('base-url');
		// const nextTitle = 'Login';
		// const nextState = { additionalInformation: 'Login' };
		// // window.history.pushState(nextState, nextTitle, nextURL);
		// window.history.replaceState(nextState, nextTitle, nextURL);
	</script>
	<!-- <script src="<?php echo base_url(); ?>assets/login/js/app.js"></script> -->
	<script src="<?php echo base_url(); ?>assets/login/js/main.js"></script>
	<div class="msg-container">
		<?php $html = '';
		// echo '<pre>';
		// print_r(session()->getFlashdata('message'));
		// echo '</pre>';
		// exit;
		$a = explode('</p>', session()->getFlashdata('message'));
		$a = array_filter($a);
		if (isset($a[0]) && $a[0] != '') {
			for ($i = 0; $i < count($a); $i++) {
				if (!empty($a[$i]) && ($i + 1) != count($a)) {
					$html .= '<div class="msg-box error-box box1">
                    <div class="msg-content">
                        <div class="msg-icon"><i class="fas fa-times"></i></div>
                        <div class="msg-text text1">' . $a[$i] . '</div>
                    </div>
                </div>';
				}
			}
			echo $html;
		} ?>
		<!-- <div class="msg-box error-box box1">
			<div class="msg-content">
				<div class="msg-icon"><i class="fas fa-times"></i></div>
				<div class="msg-text text1"><p></p></div>
			</div>
        </div> -->
		<?php echo session()->getFlashdata('messages'); ?>
	</div>
	<script>
		$(document).ready(function() {
			if ($(".text1 p").text() != '') {
				$('.msg-container .box1').attr('style', 'display:block');
				setTimeout(function() {
					$('.msg-container .box1').attr('style', 'display:none');
				}, 6000);
			}
			if ($(".text2 p").text() != '') {
				$('.msg-container .box2').attr('style', 'display:block');
				setTimeout(function() {
					$('.msg-container .box2').attr('style', 'display:none');
				}, 6000);
			}
			if ($("#error_massage").text() != '') {
				$('.msg-container').html($("#error_massage").html());
				$('.msg-container .msg-box').attr('style', 'display:block');
				setTimeout(function() {
					$('.msg-container .msg-box').attr('style', 'display:none');
				}, 6000);
			}
		});
	</script>
</body>

</html>