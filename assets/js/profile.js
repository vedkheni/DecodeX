 jQuery(document).ready(function($) {
     if ($('input').is('#joining_date')) {
         $('#joining_date').datepicker({
             dateFormat: $('#js_data').data('dateformat'),
         });
     }
     if ($('input').is('#birth_date')) {
         $('#birth_date').datepicker({
             dateFormat: $('#js_data').data('dateformat'),
         });
     }
     if ($('#birth_date').data('date') != undefined && $('#birth_date').data('date') != '') {
         var currentDate = new Date($('#birth_date').data('date'));
         $('#birth_date').datepicker().data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()));
     }

     if ($('#joining_date').data('date') != undefined && $('#joining_date').data('date') != '') {
         var currentDate = new Date($('#joining_date').data('date'));
         $('#joining_date').datepicker().data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()));
     }

     function isEmail(email) {
         var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
         return regex.test(email);
     }
     $(document).on('click', '.update-basic_detail', function(e) {

         // $("#profile-form").submit(function(e) {
         var fname = $("#fname").val();
         var lname = $("#lname").val();
         var email = $("#email").val();
         var personal_email = $("#personal_email").val();
         var birth_date = $("#birth_date").val();
         // var date_of_birth=$("#date_of_birth").val();
         //  var birth_year_val = date_of_birth.split('-');
         var joining_date = $("#joining_date").val();
         /* var gender = true;
          $('.gender').each(function(){
            gender = gender && $(this).is(':checked');
         });  */
         var isChecked = $('[name="gender"]:checked').length;
         var address = $("#address").val();
         var designation = $("#designation").val();
         var phone_number = $("#phone_number").val();
         var bank_name = $("#bank_name").val();
         //var ifsc_regx = /^[A-Za-z]{4}0[A-Z0-9]{6}$/;
         var ifsc_regx = /^[A-Za-z]{4}[a-zA-Z0-9]{7}$/;

         // var salary=$("#basic_salary").val();
         //var deduction=$("#salary_deduction").val();
         if (!fname || !lname || !email || !personal_email || !phone_number || !birth_date || !(isChecked > 0) || !address || !designation || !joining_date || (isEmail(email) == false) || !$.isNumeric(phone_number)) {

             e.preventDefault();
             var error_messages = "";
             if (!fname) {
                 // alert('OKKNS');
                 $("#fname").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee first name</p></div></div></div>';
             } else {
                 $("#fname").removeClass('error');
                 // $(".message_error .fname_err").remove();
             }
             if (!lname) {
                 $("#lname").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee last name</p></div></div></div>';
             } else {
                 $("#lname").removeClass('error');
                 // $(".message_error .lname_err").remove();
             }
             if (!email) {
                 $("#email").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee email</p></div></div></div>';
             } else {
                 if (isEmail(email) == false) {
                     $("#email").addClass('error');
                     error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid employee email</p></div></div></div>';
                 } else {
                     $("#email").removeClass('error');
                     // $(".message_error .email_err").remove();
                 }
             }
             if (!personal_email) {
                 $("#personal_email").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee personal email</p></div></div></div>';
             } else {
                 if (isEmail(personal_email) == false) {
                     $("#personal_email").addClass('error');
                     error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid employee personal email</p></div></div></div>';
                 } else {
                     $("#personal_email").removeClass('error');
                     // $(".message_error .email_err").remove();
                 }
             }
             if (!phone_number) {
                 $("#phone_number").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee contact no.</p></div></div></div>';
             } else {
                 if (!($.isNumeric(phone_number))) {
                     $("#phone_number").addClass('error');
                     error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid contact no.</p></div></div></div>';
                 } else {
                     $("#phone_number").removeClass('error');
                     // $(".message_error .pno_err").remove();
                 }

             }
             if (!birth_date) {
                 $("#birth_year").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee birth date</p></div></div></div>';
             } else {
                 $("#birth_year").removeClass('error');
                 // $(".message_error .byear_err").remove();
             }
             if (!(isChecked > 0)) {
                 //alert("data");
                 $(".gender").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Select employee gender </p></div></div></div>';

             } else {
                 $(".gender").removeClass('error');
                 // $(".message_error .gender_err").remove();
             }
             if (!designation) {
                 $("#designation").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee designation</p></div></div></div>';
             } else {
                 $("#designation").removeClass('error');
                 $(".message_error .desig_err").remove();
             }
             if (!address) {
                 $("#address").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee address</p></div></div></div>';
             } else {
                 $("#address").removeClass('error');
                 $(".message_error .address_err").remove();
             }
             if (!joining_date) {
                 $("#joining_year").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee joining date</p></div></div></div>';
             } else {
                 $("#joining_year").removeClass('error');
                 $(".message_error .jyear_err").remove();
             }
             $(".msg-container").html(error_messages);
             $('.msg-container .msg-box').attr('style', 'display:block');
             setTimeout(function() {
                 $('.msg-container .msg-box').attr('style', 'display:none');
             }, 6000);
             return false;
         } else {
            var num = 0;
            if(text_validate(fname) == true){$("#fname").removeClass('error');}else{$("#fname").addClass('error');num++;}
            if(text_validate(lname) == true){$("#lname").removeClass('error');}else{$("#lname").addClass('error');num++;}

            var regex = /^\S+@\S+\.\S+$/;
            if(regex.test(email) === false || email.length >= 254){$("#email").addClass('error');num++;}else{$("#email").removeClass('error');}
            if(regex.test(personal_email) === false || personal_email.length >= 254){$("#personal_email").addClass('error');num++;}else{$("#personal_email").removeClass('error');}
            
            if(address.length >= 200){$("#address").addClass('error');num++;}else{$("#address").removeClass('error');}
            if(num == 0){
                $("#fname").removeClass('error');
                $("#lname").removeClass('error');
                $("#email").removeClass('error');
                $("#personal_email").removeClass('error');
                $("#birth_date").removeClass('error');
                $("#joining_date").removeClass('error');
                $(".gender").removeClass('error');
                $("#address").removeClass('error');
                $("#designation").removeClass('error');
                $(".message_error").html('');
                // $('#profile-form1').submit();
                return true;
            }else{
                return false;
            }

         }
     });
     $(document).on('click', '.update-bank_detail', function(e) {

         var bank_name = $("#bank_name").val();
         var account_number = $("#account_number").val();
         var ifsc_number = $("#ifsc_number").val();
         var min_acc_length = account_number.length < 9;
         var max_acc_length = account_number.length > 18;
         //var ifsc_regx = /^[A-Za-z]{4}0[A-Z0-9]{6}$/;
         var ifsc_regx = /^[A-Za-z]{4}[a-zA-Z0-9]{7}$/;

         // var salary=$("#basic_salary").val();
         //var deduction=$("#salary_deduction").val();
         if (!bank_name || !account_number || !ifsc_number || min_acc_length || max_acc_length || !(ifsc_number.match(ifsc_regx))) {

             e.preventDefault();
             var error_messages = "";
             if (!bank_name) {
                 $("#bank_name").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee bank name</p></div></div></div>';

             } else {
                 $("#bank_name").removeClass('error');
                 // $(".message_error .bank_err").remove();
             }
             if (!account_number) {
                 $("#account_number").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee bank sccount number</p></div></div></div>';
             } else {
                 if ((account_number.length < 9) || (account_number.length > 18)) {
                     $("#account_number").addClass('error');
                     error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid bank account number</p></div></div></div>';
                 } else {
                     $("#account_number").removeClass('error');
                     // $(".message_error .account_err").remove();
                 }
             }
             if (!ifsc_number) {
                 $("#ifsc_number").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee bank IFSC number</p></div></div></div>';
             } else {
                 $("#ifsc_number").removeClass('error');
                 // $(".message_error .ifsc_err").remove();
             }
             if (!(ifsc_number.match(ifsc_regx))) {
                 if (ifsc_number.length > 0) {
                     $("#ifsc_number").addClass('error');
                     error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid employee bank IFSC number</p></div></div></div>';
                 }
             } else {
                 $("#ifsc_number").removeClass('error');
                 // $(".message_error .ifsc_err").remove();
             }
             $(".msg-container").html(error_messages);
             $('.msg-container .msg-box').attr('style', 'display:block');
             setTimeout(function() {
                 $('.msg-container .msg-box').attr('style', 'display:none');
             }, 6000);
             return false;
         } else {
             $("#bank_name").removeClass('error');
             $("#account_number").removeClass('error');
             $("#ifsc_number").removeClass('error');
             $(".message_error").html('');
             // $('#profile-form2').submit();
             return true;

         }
     });
     
     $(document).on('click', '.update-payment_method', function(e) {

         var upi_type = $("#upi_type").val();
         var qrcode_name = $("#qrcode_name").val();
         var qrcode = $("#qrcode").val();
         var upi_id = $("#upi_id").val();
         var upi_regx = /^[\w.-]+@[\w.-]+$/;

         // var salary=$("#basic_salary").val();
         //var deduction=$("#salary_deduction").val();

             var $flag = 0;
             var error_messages = "";
             if (!upi_type) {
                 $("#upi_type").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter UPI type</p></div></div></div>';
                 $flag++;
             } else {
                 $("#upi_type").removeClass('error');
             }
             if (!upi_id) {
                 $("#upi_id").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter UPI ID</p></div></div></div>';
                 $flag++;
             } else {
                 $("#upi_id").removeClass('error');
             }
             if (!(upi_id.match(upi_regx))) {
                 if (upi_id.length > 0) {
                     $("#upi_id").addClass('error');
                     error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid UPI ID</p></div></div></div>';
                     $flag++;
                 }
             } else {
                $("#upi_id").removeClass('error');
            }
            
            if(qrcode_name == '' && qrcode == ''){
                $flag++;
                error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please your upload QR code.</p></div></div></div>';
                $("#qrcode").addClass('error');
            } else {
                $("#qrcode").removeClass('error');
            }

        if ($flag == 0) {
            $("#upi_type").removeClass('error');
            $("#upi_id").removeClass('error');
            $("#qrcode").removeClass('error');
            $(".message_error").html('');
            return true;
        } else {
            e.preventDefault();
             $(".msg-container").html(error_messages);
             $('.msg-container .msg-box').attr('style', 'display:block');
             setTimeout(function() {
                 $('.msg-container .msg-box').attr('style', 'display:none');
             }, 6000);
             return false;

         }
     });
     $(document).on('click', '.update-credentials_detail', function(e) {

         var skype_account = $("#skype_account").val();
         var skype_password = $("#skype_password").val();
         var gmail_account = $("#gmail_account").val();
         var gmail_password = $("#gmail_password").val();
         //var ifsc_regx = /^[A-Za-z]{4}0[A-Z0-9]{6}$/;
         var ifsc_regx = /^[A-Za-z]{4}[a-zA-Z0-9]{7}$/;

         // var salary=$("#basic_salary").val();
         //var deduction=$("#salary_deduction").val();
         if (!skype_password || !skype_account || !gmail_password || !gmail_account || (isEmail(gmail_account) == false) || (isEmail(skype_account) == false)) {

             e.preventDefault();
             var error_messages = "";
             if (!gmail_account) {
                 $("#gmail_account").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee gmail account</p></div></div></div>';
             } else {
                 if (isEmail(gmail_account) == false) {
                     $("#gmail_account").addClass('error');
                     error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter Valid employee gmail account</p></div></div></div>';
                 } else {
                     $("#gmail_account").removeClass('error');
                     // $(".message_error .gmail_err").remove();
                 }
             }
             if (isEmail(gmail_account) == false) {
                 $("#gmail_account").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid employee gmail account</p></div></div></div>';
             } else {
                 $("#gmail_account").removeClass('error');
                 $(".message_error .gmail_err").remove();
             }
             if (!gmail_password) {
                 $("#gmail_password").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee gmail password</p></div></div></div>';
             } else {
                 $("#gmail_password").removeClass('error');
                 // $(".message_error .gmail_pass_err").remove();
             }
             if (!skype_account) {
                 $("#skype_account").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee skype account</p></div></div></div>';
             } else {
                 if (isEmail(skype_account) == false) {
                     $("#skype_account").addClass('error');
                     error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid employee skype account</p></div></div></div>';
                 } else {
                     $("#skype_account").removeClass('error');
                     // $(".message_error .skype_err").remove();
                 }
             }
             if (!skype_password) {
                 $("#skype_password").addClass('error');
                 error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter employee skype password</p></div></div></div>';
             } else {
                 $("#skype_password").removeClass('error');
                 // $(".message_error .skype_pass_err").remove();
             }
             $(".msg-container").html(error_messages);
             $('.msg-container .msg-box').attr('style', 'display:block');
             setTimeout(function() {
                 $('.msg-container .msg-box').attr('style', 'display:none');
             }, 6000);
             return false;
         } else {
             var num = 0;
             var regex = /^\S+@\S+\.\S+$/;
            if(regex.test(gmail_account) === false || gmail_account.length >= 254){$("#gmail_account").addClass('error');num++;}else{$("#gmail_account").removeClass('error');}
            if(regex.test(skype_account) === false || skype_account.length >= 254){$("#skype_account").addClass('error');num++;}else{$("#skype_account").removeClass('error');}
            if(num == 0){
                $("#gmail_account").removeClass('error');
                $("#gmail_password").removeClass('error');
                $("#skype_account").removeClass('error');
                $("#skype_password").removeClass('error');
                $(".message_error").html('');
                // $('#profile-form4').submit();
                return true;
            }else{
                return false;
            }

         }
     });
     $(document).on('click', '.update-id_proof', function(e) {
         // $('#profile-form3').submit();
         if($('#id_proof').val()){
            return true;
        } else {
            error_messages = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please your upload ID proof.</p></div></div></div>';
            $(".msg-container").html(error_messages);
            $('.msg-container .msg-box').attr('style', 'display:block');
            setTimeout(function() {
                $('.msg-container .msg-box').attr('style', 'display:none');
            }, 6000);
            return false;
        }
    });
     $(document).on('click', '.update-emp_signature', function(e) {
        if($('#emp_signature').val()){
            return true;
        } else {
            error_messages = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please your upload signature image.</p></div></div></div>';
            $(".msg-container").html(error_messages);
            $('.msg-container .msg-box').attr('style', 'display:block');
            setTimeout(function() {
                $('.msg-container .msg-box').attr('style', 'display:none');
            }, 6000);
            return false;
        }
         // $('#profile-form3').submit();
     });

     $(document).on('click', '.update-emergency_contact_detail', function(e) {

        var name = $("#emergency_contact_name").val();
        var email = $("#emergency_contact_email").val();
        var address = $("#emergency_contact_address").val();
        var phone_number = $("#emergency_contact_number").val();

        if (!name || !email || !phone_number || !address || (isEmail(email) == false) || !$.isNumeric(phone_number)) {

            e.preventDefault();
            var error_messages = "";
            if (!name) {
                $("#emergency_contact_name").addClass('error');
                error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter emergency contact name</p></div></div></div>';
            } else {
                $("#emergency_contact_name").removeClass('error');
            }
            if (!email) {
                $("#emergency_contact_email").addClass('error');
                error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter emergency contact email</p></div></div></div>';
            } else {
                if (isEmail(email) == false) {
                    $("#emergency_contact_email").addClass('error');
                    error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid emergency contact email</p></div></div></div>';
                } else {
                    $("#emergency_contact_email").removeClass('error');
                }
            }
            if (!phone_number) {
                $("#emergency_contact_number").addClass('error');
                error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter emergency contact no.</p></div></div></div>';
            } else {
                if (!($.isNumeric(phone_number))) {
                    $("#emergency_contact_number").addClass('error');
                    error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter valid contact no.</p></div></div></div>';
                } else {
                    $("#emergency_contact_number").removeClass('error');
                }

            }
            if (!address) {
                $("#emergency_contact_address").addClass('error');
                error_messages += '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please enter emergency contact address</p></div></div></div>';
            } else {
                $("#emergency_contact_address").removeClass('error');
                $(".message_error .address_err").remove();
            }
            $(".msg-container").html(error_messages);
            $('.msg-container .msg-box').attr('style', 'display:block');
            setTimeout(function() {
                $('.msg-container .msg-box').attr('style', 'display:none');
            }, 6000);
            return false;
        } else {
           var num = 0;
           if(text_validate(name) == true){$("#emergency_contact_name").removeClass('error');}else{$("#emergency_contact_name").addClass('error');num++;}
           var regex = /^\S+@\S+\.\S+$/;
           if(regex.test(email) === false || email.length >= 254){$("#emergency_contact_email").addClass('error');num++;}else{$("#emergency_contact_email").removeClass('error');}

           if(address.length >= 200){$("#emergency_contact_address").addClass('error');num++;}else{$("#emergency_contact_address").removeClass('error');}
           if(num == 0){
               $("#emergency_contact_name").removeClass('error');
               $("#emergency_contact_number").removeClass('error');
               $("#emergency_contact_email").removeClass('error');
               $("#emergency_contact_address").removeClass('error');
               $(".message_error").html('');
               return true;
           }else{
               return false;
           }

        }
    });


 });