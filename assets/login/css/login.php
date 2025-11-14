<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/favicon.png"/>

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/login/css/style.css">
	<style>
    .massge_for_error.text-center {
        color: red;
    }
	</style>
    <script src="https://kit.fontawesome.com/89e70b322a.js" crossorigin="anonymous"></script>
	<script src="https://www.google.com/recaptcha/api.js?render=<?php echo SITE_KEY; ?>"></script>
	<script>
        grecaptcha.ready(function () {
            grecaptcha.execute("<?php echo SITE_KEY; ?>", { action: 'employee' }).then(function (token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });
    </script>
</head>
<body>
<div id="js_data" data-base-url="<?php echo base_url(); ?>"></div>
    <div class="sign-container">
        <div class="forms-container">
            <div class="signin-signup">
                <form class="sign-in-form validate-form" method="POST" id="employee-login_form" action="<?php echo base_url('admin'); ?>">
				<?php 
                        $csrf = array(
                                'name' => $this->security->get_csrf_token_name(),
                                'hash' => $this->security->get_csrf_hash()
                        );
                    ?>
					 <!-- <div class="massge_for_error text-center"><?php // echo $this->session->flashdata('message'); ?> </div>
                     <div class="massge_for_error text-center"><?php // echo $this->session->flashdata('messages'); ?> </div> -->

                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    <h2 class="title">Sign in</h2>
                    <div class="sign-field">
                        <input type="text" name="email" id="email" class="input100">
                        <label class="sign-label" for="email">Username</label>
                    </div>
                    <div class="sign-field">
                        <input type="password" name="password" class="input100" id="password">
                        <label class="sign-label" for="password">Password</label>
                    </div>
					<input type="hidden" name="recaptcha_response" id="recaptchaResponse">

                    <input type="submit" value="Sign in" class="btn btn-primary btn_login">
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
            <div class="content">
                    <h3>Admin</h3>
                </div>        
                <img src="<?php echo base_url(); ?>assets/login/img/sign-in-img.svg" class="image" alt="Sign in image">
            </div>
        </div>
    </div>
    
    <div class="d-none" id="error_massage"><?php echo $error_massage ?></div>
    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/login/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(".btn_login").click(function(e) {
          var password=$("#password").val();
          var email=$("#email").val();
         
        if(!password || !email){
              e.preventDefault();
              if(!password){
                $("#password").addClass('error');
              }
              else{
                $("#password").removeClass('error');
              }
              if(!email){
                $("#email").addClass('error');
              }
              else{
                $("#email").removeClass('error');
              }
            return false;       
          }else{
            $("#password").removeClass('error');
            $("#email").removeClass('error'); 
            $('.btn_login').prop('disabled',true);
            $('.preloader-2').attr('style', 'display:block !important;');
            var base_url = $("#js_data").data('base-url');
            var data = { 'password': $("#password").val(), 'email': $("#email").val() };
            $.ajax({
                url: base_url + "admin/js_validation",
                type: "post",
                data: data,
                success: function(response) {
                    var obj = JSON.parse(response);
                    if(obj.error_code){
                        $('.msg-container').html(obj.massage);
                        $('.msg-container .msg-box').attr('style','display:block');
                        $('.preloader-2').attr('style', 'display:none !important;');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style','display:none');
                        }, 6000);
                        $('.btn_login').prop('disabled',false);
                        return false;  
                    }else{
                        $('.preloader-2').attr('style', 'display:none !important;');
                        $('.btn_login').prop('disabled',false);
                        $("#employee-login_form").submit();
                        return true; 
                    }
                },
            }); 
            return false;
            // return true;  
            
          }
        });
    </script>
    <script src="<?php echo base_url(); ?>assets/login/js/app.js"></script>
	    <script src="<?php echo base_url(); ?>assets/login/js/main.js"></script>
        <div class="msg-container">
    <?php $html = ''; $a = explode('</p>',$this->session->flashdata('message')); $a=array_filter($a); if(isset($a[0]) && $a[0] != ''){
        for($i=0; $i < count($a); $i++){
            if(!empty($a[$i]) && ($i+1) != count($a)){
                $html .= '<div class="msg-box error-box box1">
                    <div class="msg-content">
                        <div class="msg-icon"><i class="fas fa-times"></i></div>
                        <div class="msg-text text1">'.$a[$i].'</div>
                    </div>
                </div>';
            }
        }
        echo $html;
    } ?>
		<?php echo $this->session->flashdata('messages'); ?>
    </div>
    <script>
        $(document).ready(function(){
            if ($(".text1 p").text() != ''){
                $('.msg-container .box1').attr('style','display:block');
                setTimeout(function() {
                    $('.msg-container .box1').attr('style','display:none');
                }, 6000);
            }
            if ($(".text2 p").text() != ''){
                $('.msg-container .box2').attr('style','display:block');
                setTimeout(function() {
                    $('.msg-container .box2').attr('style','display:none');
                }, 6000);
            }
            if ($("#error_massage").text() != ''){
              $('.msg-container').html($("#error_massage").html());
                $('.msg-container .msg-box').attr('style','display:block');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style','display:none');
                }, 6000);
            }
        });
    </script>
</body>
</html>

