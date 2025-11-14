<?php
$page_text = "Add";
if (isset($list_data[0]->id) && !empty($list_data[0]->id)) {
    $page_text = "Update";
} else {
    $page_text = "Add";
}
    $url = base_url().'assets/id_proof256x256';
    $signature_url = base_url().'assets/signature256x256';
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <h4 class="page-title text-center"><?php echo $page_text; ?> Employee</h4>
                <!-- <div class="page-title-btn">
                <a class="btn sec-btn back-btn" href="<?php echo base_url('employee'); ?>">
                	<i class="fas fa-chevron-left"></i>
                	<span>Back</span>
                </a>
                 	</div> -->
            </div>
            <!-- <div class="col-sm-4">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('employee'); ?>">Employee</a></li>
                <li class="active"><?php echo $page_text; ?> Employee</li>
            </ol>
            </div> -->
            <!-- /.col-lg-12 -->
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- <div class="white-box"> -->
                <!-- <div class="massge_for_error text-center"><?php echo $this->session->getFlashdata('message'); ?> </div>
                <div class="massge_for_error text-center"><?php echo $this->session->getFlashdata('user_exists_message'); ?> </div> -->
                <form class="form-horizontal form-material" method="post" action="<?php echo base_url('employee/insert_data'); ?>" id="employee-form">
                    <input type="hidden" name="e_id" id="e_id" value="<?php if (isset($list_data[0]->id)) {
                                                                            echo $list_data[0]->id;
                                                                        } ?>">
                    <?php
                    //echo "<pre>"; print_r($employee_increment); 
                    //print_r($employee_increment1);echo "</pre>";
                    /* if(isset($list_data[0]->id)){ echo "<pre>";print_r($list_data);echo "</pre>";
                    	echo "<pre>"; print_r($get_employee_increment);echo "</pre>";
                    	} */
                    //echo "<pre>"; print_r($list_data[0]->employed_date); echo "</pre>";
                    ?>
                    <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
                    <div class="field-grp white-box add-basic-detail">
                        <div class="field-grp-title">
                            <h2>Basic Details</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="single-field">
                                        <input type="text" name="fname" id="fname" value="<?php if (isset($list_data[0]->fname)) {
                                                                                                echo $list_data[0]->fname;
                                                                                            } ?>">
                                        <label>First Name *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="single-field">
                                        <input type="text" name="lname" id="lname" value="<?php if (isset($list_data[0]->lname)) {
                                                                                                echo $list_data[0]->lname;
                                                                                            } ?>">
                                        <label>Last Name *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="single-field">
                                        <input type="email" name="email" id="email" value="<?php if (isset($list_data[0]->email)) {
                                                                                                echo $list_data[0]->email;
                                                                                            } ?>">
                                        <label>Email *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="single-field">
                                        <input type="email" name="personal_email" id="personal_email" value="<?php if (isset($list_data[0]->personal_email)) {
                                                                                                                    echo $list_data[0]->personal_email;
                                                                                                                } ?>">
                                        <label>personal email *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="single-field">
                                        <input type="text" name="password" id="password" value="DecodeX@217" disabled>
                                        <label>Password *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3" id="addPassword">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="cms-option-box" for="addPassword1"><input type="checkbox" name="addPassword" value="DecodeX@217" id="addPassword1">Add Default Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row cms-option-gender align-items-center">
                                    <div class=" col-md-4">
                                        <label class="m-0">Gender *</label>
                                    </div>
                                    <div class=" col-md-4">
                                        <label class="cms-option-box male" for="gender">
                                            <input type="radio" <?php if (isset($list_data[0]->gender) && $list_data[0]->gender == "male") { ?> checked="checked" <?php } ?> name="gender" value="male" id="gender" class="radio-class gender">Male</label>
                                    </div>
                                    <div class=" col-md-4">
                                        <label class="cms-option-box male" for="gender1">
                                            <input type="radio" <?php if (isset($list_data[0]->gender) && $list_data[0]->gender == "female") { ?> checked="checked" <?php } ?> name="gender" value="female" id="gender1" class="radio-class gender">Female</label>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="single-field">
                                        <input type="text" name="phone_number" class="numeric contact_number" id="phone_number" maxlength="10" value="<?php if (isset($list_data[0]->phone_number)) {
                                                                                                                                                            echo $list_data[0]->phone_number;
                                                                                                                                                        } ?>">
                                        <label>Phone No *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="single-field date-field">
                                        <input type="text" name="birth_date" id="birth_date" autocomplete="off" value="<?php if (isset($list_data[0]->date_of_birth)) {
                                                                                                                            echo $list_data[0]->date_of_birth;
                                                                                                                        } ?>">
                                        <label>Date of Birth </label>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="single-field">
                                        <textarea rows="4" class="textarea" name="address" id="address"><?php if (isset($list_data[0]->address)) {
                                                                                                            echo $list_data[0]->address;
                                                                                                        } ?></textarea>
                                        <label>Address </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field-grp white-box">
                        <div class="field-grp-title">
                            <h2>Job Details</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="single-field date-field">
                                        <input type="text" name="joining_date" id="joining_date" autocomplete="off" value="<?php if (isset($list_data[0]->joining_date)) {
                                                                                                                                echo $list_data[0]->joining_date;
                                                                                                                            } ?>">
                                        <label>Joining Date *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="single-field select-field">
                                        <select name="designation" id="designation">
                                            <option disabled>Select Designation</option>
                                            <?php foreach ($designation as $key => $value) { ?>
                                                <option <?php if (isset($list_data[0]->designation) && $list_data[0]->designation == $value->id) { ?> selected="selected" <?php } ?> value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <label>Select Designation *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="single-field date-field">
                                        <input type="text" name="employed_date" id="employed_date" autocomplete="off" value="<?php if (isset($list_data[0]->employed_date) && $list_data[0]->employed_date != '0000-00-00') {
                                                                                                                                    echo $list_data[0]->employed_date;
                                                                                                                                } ?>">
                                        <label>Employed Date</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="single-field select-field">
                                        <select id="employee_status" name="employee_status">
                                            <option value="" disabled>Select Status</option>
                                            <option <?php if (isset($list_data[0]->employee_status) && $list_data[0]->employee_status == "training") { ?> selected="selected" <?php } ?> value="training">Training</option>
                                            <option <?php if (isset($list_data[0]->employee_status) && $list_data[0]->employee_status == "employee") { ?> selected="selected" <?php } ?> value="employee">Employee</option>
                                        </select>
                                        <label>Select Status *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <div class="single-field">
                                        <input type="number" name="basic_salary" id="basic_salary" value="<?php if (isset($list_data[0]->salary)) {
                                                                                                                echo $list_data[0]->salary;
                                                                                                            } ?>">
                                        <label>Basic Salary *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <div class="single-field">
                                        <input type="text" class="numeric" name="salary_deduction" min="0" max="100" id="salary_deduction" value="<?php if (isset($list_data[0]->salary_deduction)) {
                                                                                                                                                        echo $list_data[0]->salary_deduction;
                                                                                                                                                    } else {
                                                                                                                                                        echo 0;
                                                                                                                                                    } ?>">
                                        <!-- <select id="salary_deduction" name="salary_deduction">
                                        <option value="" disabled>Salary Deduction</option>
                                        <option <?php //if (isset($list_data[0]->salary_deduction) && $list_data[0]->salary_deduction == "0") { 
                                                ?> selected="selected" <?php // } 
                                                                                                                                                                        ?> value="0">Training</option>
                                        <option <?php //if (isset($list_data[0]->salary_deduction) && $list_data[0]->salary_deduction != "0") { 
                                                ?> selected="selected" <?php // } 
                                                                                                                                                                        ?> value="100">Deduction Full Salary</option>
                                        </select> -->
                                        <label>Salary Deduction (%) *</label>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if (isset($get_employee_increment) && !empty($get_employee_increment)) { ?>
                                <!--<input type="hidden" name="increment_id" id="increment_id" value="<?php //if(isset($get_employee_increment->id)){ echo $get_employee_increment->id; } 
                                                                                                        ?>">
                            <div class="col-md-4">
                                                     <div class="form-group">
                                                         <div class="single-field">
                            			<input type="text" name="increment_amount" id="increment_amount"  value="<?php //if(isset($get_employee_increment->amount)){ echo $get_employee_increment->amount; } 
                                                                                                                    ?>">
                                                         	<label>Increment Amount </label>
                                                         </div>
                                                     </div>
                                                 </div>
                            <div class="col-md-4">
                                                     <div class="form-group">
                                                         <div class="single-field date-field">
                            			<input type="text" name="increment_date" id="increment_date" autocomplete="off"  value="<?php //if(isset($get_employee_increment->increment_date)){ echo $get_employee_increment->increment_date; } 
                                                                                                                                ?>">
                                                         	<label>Increment Date </label>
                                                         </div>
                                                     </div>
                                                 </div>
                            <div class="col-md-4">
                                                     <div class="form-group">
                                                         <div class="single-field date-field">
                            			<input type="text" name="next_increment_date" autocomplete="off" id="next_increment_date"  value="<?php // if(isset($get_employee_increment->next_increment_date) && $get_employee_increment->next_increment_date != '0000-00-00'){ echo $get_employee_increment->next_increment_date; } 
                                                                                                                                            ?>">
                                                         	<label>Next Increment Date </label>
                                                         </div>
                                                     </div>
                                                 </div>-->
                            <?php    }
                            ?>
                        </div>
                    </div>
                    <div class="field-grp white-box">
                        <div class="field-grp-title">
                            <h2>Bank Details</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="single-field">
                                        <input type="text" name="bank_name" id="bank_name" value="<?php if (isset($list_data[0]->bank_name)) {
                                                                                                        echo $list_data[0]->bank_name;
                                                                                                    } ?>">
                                        <label>Bank name </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="single-field">
                                        <input type="text" name="account_number" id="account_number" value="<?php if (isset($list_data[0]->account_number)) {
                                                                                                                echo $list_data[0]->account_number;
                                                                                                            } ?>">
                                        <label>Account No </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="single-field">
                                        <input type="text" name="ifsc_number" id="ifsc_number" value="<?php if (isset($list_data[0]->ifsc_number)) {
                                                                                                            echo $list_data[0]->ifsc_number;
                                                                                                        } ?>">
                                        <label>IFSC Code </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field-grp white-box">
                        <div class="field-grp-title">
                            <h2>Other Payment Method</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
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
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="single-field">
                                        <input type="text" name="upi_id" id="upi_id" value="<?php if (isset($list_data[0]->upi_id)) { echo $list_data[0]->upi_id; } ?>">
                                        <label>UPI ID</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field-grp white-box">
                        <div class="field-grp-title">
                            <h2>DecodeX Account Details</h2>
                        </div>
                        <div class="row">
                            <?php
                            $gmail_id = $gmail_password = $skype_id = $skype_password = "";
                            if (isset($list_data[0]->credential)) {
                                $credential = json_decode($list_data[0]->credential);
                                //echo "<pre>";print_r($credential);echo "</pre>";
                                $gmail_id = (isset($credential->gmail->gmail_account) && !empty($credential->gmail->gmail_account)) ? $credential->gmail->gmail_account : "";

                                $gmail_password = (isset($credential->gmail->gmail_password) && !empty($credential->gmail->gmail_password)) ? $credential->gmail->gmail_password : "";

                                $skype_id = (isset($credential->skype->skype_account) && !empty($credential->skype->skype_account)) ? $credential->skype->skype_account : "";

                                $skype_password = (isset($credential->skype->skype_password) && !empty($credential->skype->skype_password)) ? $credential->skype->skype_password : "";
                            }
                            ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="single-field">
                                        <input type="text" name="gmail_account" id="gmail_account" value="<?php echo $gmail_id; ?>">
                                        <label>Gmail ID *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="single-field">
                                        <input type="text" name="gmail_password" id="gmail_password" value="<?php echo $gmail_password; ?>">
                                        <label>Gmail Password *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="single-field">
                                        <input type="text" name="skype_account" id="skype_account" value="<?php echo $skype_id; ?>">
                                        <label>Skype ID *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="single-field">
                                        <input type="text" name="skype_password" id="skype_password" value="<?php echo $skype_password; ?>">
                                        <label>Skype Password *</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field-grp white-box" id="thum_img">
                        <div class="field-grp-title">
                            <h2>ID & Signature Image</h2>
                        </div>
                        <div class="emp-proof">
                            <div id="idcount">
                                <div class="emp-proof-img">
                                        <?php $num = 0; if (isset($list_data[0]->id_proof) && !empty($list_data[0]->id_proof)) {
                                            $image1 = $_SERVER['DOCUMENT_ROOT'] . "/assets/id_proof512x512/" . $list_data[0]->id_proof;
                                            if (file_exists($image1)) {
                                                $image = base_url() . "assets/id_proof512x512/" . $list_data[0]->id_proof;
                                                $image_1 = $url . '/' . $list_data[0]->id_proof;
                                        ?>
                                                <a download href="<?php echo $image; ?>"><img class="id-img" src="<?php echo $image_1; ?>"></a>
                                            <?php $num++; } ?>
                                        <?php } ?>
                                        <input type="hidden" id="data_idcount" value="<?=$num?>">
                                </div>
                            </div>
                            <div id="signcount">
                                <div class="emp-proof-img">
                                        <?php $num = 0; if (isset($list_data[0]->signature) && !empty($list_data[0]->signature)) {
                                            $image1 = $_SERVER['DOCUMENT_ROOT'] . "/assets/signature512x512/" . $list_data[0]->signature;
                                            if (file_exists($image1)) {
                                                $image = base_url() . "assets/signature512x512/" . $list_data[0]->signature;
                                                $image_1 = $signature_url . '/' . $list_data[0]->signature;
                                        ?>
                                                <a download href="<?php echo $image; ?>">
                                                    <img class="id-img" src="<?php echo $image_1; ?>">
                                                </a>
                                        <?php $num++; }
                                        }  ?>
                                        <input type="hidden" id="data_signcount" value="<?=$num?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-30">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-center m-0 p-0">
                                    <div class="col-sm-12">
                                        <button class="btn sec-btn submit_form"><?php echo $page_text; ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- </div> -->
            </div>
        </div>
    </div>
    <div class="msg-container">
        <?php $html = '';
        $a = explode('</p>', $this->session->getFlashdata('message'));
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
        <?php $html = '';
        $a = explode('</p>', $this->session->getFlashdata('user_exists_message'));
        $a = array_filter($a);
        if (isset($a[0]) && $a[0] != '') {
            for ($i = 0; $i < count($a); $i++) {
                if (!empty($a[$i]) && ($i + 1) != count($a)) {
                    $html .= '<div class="msg-box error-box box2">
                          <div class="msg-content">
                              <div class="msg-icon"><i class="fas fa-times"></i></div>
                              <div class="msg-text text2">' . $a[$i] . '</div>
                          </div>
                      </div>';
                }
            }
            echo $html;
        } ?>
    </div>
    <script>
    
    $(document).ready(function() {
        var data_idcount = $('#data_idcount').val();
        (data_idcount == 0)?$('#idcount').hide():$('#idcount').show();
        var data_signcount = $('#data_signcount').val();
        (data_signcount == 0)?$('#signcount').hide():$('#signcount').show();
        (data_idcount == 0 && data_signcount == 0)?$('#thum_img').hide():$('#thum_img').show();

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
        });

        function daysInMonth(month, year) {
            return new Date(year, month, 0).getDate();
        }
        $("#birth_month").on('change', function() {
            var birth_month = $(this).val();
            if ($("#birth_year").val() != "" && $("#birth_year").val() != "Year") {
                var birth_year = $("#birth_year").val();
            } else {
                var birth_year = 1985;
            }


            var birth_day = $("#birth_day").val();
            var num = daysInMonth(birth_month, birth_year);
            //console.log(birth_month+" - "+birth_year);

            var i;
            var option = "<option disabled>Day</option>";
            for (i = 1; i <= num; i++) {
                option += "<option value='" + i + "'>" + i + "</option>";
            }
            $("#birth_day").html(option);
            $("#birth_day").val(birth_day);


        });

        function daysInMonth(month, year) {
            return new Date(year, month, 0).getDate();
        }
        $('.contact_number').keyup(function() {
            var phoneno = /^\d{10}$/;
            if (this.value.match(phoneno)) {
                $(this).removeClass('error');
            } else {
                $(this).addClass('error');
            }
        });
        $("#joining_month").on('change', function() {
            var joining_month = $(this).val();
            if ($("#joining_year").val() != "" && $("#joining_year").val() != "Year") {
                var joining_year = $("#joining_year").val();
            } else {
                var joining_year = 1985;
            }


            var joining_day = $("#joining_day").val();
            var num = daysInMonth(joining_month, joining_year);
            // console.log(num+""+joining_day);
            var i;
            var option = "<option disabled>Day</option>";
            for (i = 1; i <= num; i++) {
                option += "<option value='" + i + "'>" + i + "</option>";
            }
            $("#joining_day").html(option);
            $("#joining_day").val(joining_day);


        });
    </script>