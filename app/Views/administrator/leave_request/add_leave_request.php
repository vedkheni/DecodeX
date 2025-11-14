<?php 
    $page_text="Add";
    if(isset($list_data[0]->id) && !empty($list_data[0]->id)){ 
        $page_text="Update";
    }else{
        $page_text="Add";
    }
	$user_session=$this->session->userdata('id');
	$user_role=$this->session->userdata('user_role');
	// echo "<pre>"; print_r($leave_count); echo "</pre>";
	// echo "<pre>"; print_r($emp_detail[0]->id); echo "</pre>";
?>
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row bg-title">
        <!-- <div class="col-sm-4"> -->
                <!-- <a href="<?php echo base_url('employee'); ?>">
                <i class="fa fa-long-arrow-left" aria-hidden="true" style="font-size:19px"></i>&nbsp;&nbsp;&nbsp;&nbsp;Back
                </a> -->
				<!-- <a href="<?php echo base_url('leave_request'); ?>" class="learn-more">
                    <div class="circle">
                      <span class="icon arrow"></span>
                    </div>
                    <p  class="button-text">                
                            Back
					</p>
                </a> -->
        <!-- </div> -->
        <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title text-center"><?php echo $page_text; ?> Leave Request</h4>
        </div>
        <!-- <div class="col-sm-4">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('leave_request'); ?>">Leave Request</a></li>
                <li class="active"><?php echo $page_text; ?> Leave Request</li>
            </ol>
        </div> -->
        <!-- /.col-lg-12 -->
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-8 col-12">    
			<?php if($user_role != "admin"){ ?>
			<div class="row">

				<div class="col-lg-6 col-md-6 col-xs-12">
					<div class="analytics-info border-none">
						<h3 class="title">Used Paid Leave</h3>
						<h3 class="counter">
							<?php if(isset($leave_count)){
								echo $leave_count['paid_leave'];
							} ?>
						</h3>
					</div>
				</div>

                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="analytics-info border-none">
                            <h3 class="title">Used Sick Leaves</h3>
                                <h3 class="counter">
								<?php  if(isset($leave_count)){
									echo $leave_count['sick_leave'];
								} ?></h3>
                        </div>
                    </div>
					<!-- <div class="col-lg-4 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Remaing Paid Leave</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash3"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-info">
								<?php  //if(isset($leave_count)){
									//echo $leave_count['remaing_paid_leave'];
								//} ?></span></li>
                            </ul>
                        </div>
                    </div> -->
					<div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="analytics-info border-none">
                            <h3 class="title">Remaining Paid Leaves</h3>
                                <h3 class="counter">
								<?php  if(isset($leave_count)){
									echo $leave_count['this_month_paid_leave'];
								} ?></h3>
							</div>
                    </div>
					<div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="analytics-info border-none">
                            <h3 class="title">Remaining Sick Leaves</h3>
                                <h3 class="counter"><?php  if(isset($leave_count)){
									echo $leave_count['remaing_sick_leave'];
								} ?></h3>
                        </div>
                    </div>
                </div>
			<?php }else{ ?>
				<div class="html_leave "></div>
			<?php } ?>
            <div class="white-box space-30 m-0">

                <div class="massge_for_error text-center"><?php echo $this->session->flashdata('message'); ?> <?php echo $this->session->flashdata('message1'); ?></div>
				<!-- <div class="status_for_error text-center" style="color:red;"> </div>
				<div class="leave_status_for_error text-center" style="color:red;"> </div> -->
                 <form class="form-horizontal form-material" method="post" action="<?php echo base_url('leave_request/insert_data'); ?>" id="leave-form">
                    <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">
                    <input type="hidden" name="type" id="type" value="ajax">
                    <?php 
                        $csrf = array(
                                'name' => $this->security->get_csrf_token_name(),
                                'hash' => $this->security->get_csrf_hash()
                        );
                    ?>
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                <?php // echo "<pre>"; print_r($all_employees); echo "</pre>"; 
								
								if($user_role == "admin"){ ?>
								
								<div class="form-group">	
                                    <div class="single-field select-field">
                                    <select name="employee_select" id="employee_select">
									<option value="" disabled>Select Employee</option>
									<?php foreach($all_employees as $emp){ ?>
										<option <?php if(isset($list_data[0]->id) && $list_data[0]->id == $emp->id ){ echo "selected='selected'"; } ?> value="<?php echo $emp->id; ?>"><?php echo $emp->fname ." ".$emp->lname; ?></option>
										<!-- <option <?php if(isset($list_data[0]->employee_id) && $list_data[0]->employee_id == $emp->id ){ echo "selected='selected'"; } ?> value="<?php echo $emp->id; ?>"><?php echo $emp->fname ." ".$emp->lname; ?></option> -->
									<?php } ?>
									</select>
                                    <label>Select Employee*</label>
									</div>
                                </div>	
								<?php }else{ ?>
									<input type="hidden" name="employee_select" id="employee_select" value=<?php echo $user_session; ?> >
								<?php }
								?>	
								<div class="form-group">
                                    <div class="single-field date-field">
									<input type="text" class="datepicker-here" data-language="en" data-role='<?php echo $user_role; ?>'  data-date="<?php if(isset($list_data[0]->leave_date)){ echo $list_data[0]->leave_date;} ?>" <?php if(!isset($list_data[0]->leave_date)){ echo 'data-multiple-dates="100"'; } ?> name="leave_date" id="leave_date" data-multiple-dates-separator="," autocomplete="off" value="<?php if(isset($list_data[0]->leave_date)){ echo $list_data[0]->leave_date;} ?>"/>
                                    <label>Select Leave Date*</label>
                                    <!--<input type="text" placeholder="" class="form-control form-control-line" name="leave_date" id="leave_date" value="<?php //if(isset($list_data[0]->leave_date)){ echo $list_data[0]->leave_date;} ?>"> -->

									</div>
                                </div>
								<input id="edit_date" type="hidden" value="<?php if(isset($list_data[0]->leave_date)){ echo $list_data[0]->leave_date;} ?>">
								<div class="form-group">
                                    <div class="single-field">
										<textarea name="leave_commet" id="leave_commet" rows="5"><?php if(isset($list_data[0]->comment)){ echo $list_data[0]->comment;} ?></textarea>
                                    	<label>Leave Comment</label>
                                     </div>
                                </div>
                                <div class="row">
                                	<div class="col-md-6 col-xs-12">
										<div class="form-group form-radio">
		                                    <label class="form-radio-label">Leave Type</label>
		                                    <!-- <div class="col-md-12"> -->
											<!-- <div id="leave_status_error"></div> -->
		                                        <label class="form-radio-label"><input type="radio" <?php if($user_role == "admin"){if(isset($list_data[0]->leave_status) && !empty($list_data[0]->leave_status) && $list_data[0]->leave_status == 'none'){ echo 'checked="checked"'; }}else{echo 'checked="checked"';} ?>   class="" name="leave_status" id="leave_status_none" value="none"> None </label>
												<?php if($user_role != "admin"){ ?>	
												<?php if(isset($leave_count) && !empty($leave_count)){
												if($leave_count['this_month_paid_leave'] != "0" || (isset($list_data[0]->leave_status) && $list_data[0]->leave_status == 'paid')){ ?>
															<!--<input type="radio"  <?php //if(isset($list_data[0]->leave_status) && $list_data[0]->leave_status == 'paid'){ echo 'checked="checked"'; } ?> class="" name="leave_status" id="leave_status_paid" value="paid"> Paid Leave &nbsp&nbsp&nbsp-->
														<?php }
												} ?>
												
												<?php if(isset($leave_count) && !empty($leave_count)){
														if($leave_count['remaing_sick_leave'] != "0" || (isset($list_data[0]->leave_status) && $list_data[0]->leave_status == 'paid')){ ?>
															<label class="form-radio-label"><input type="radio" <?php if(isset($list_data[0]->leave_status) && $list_data[0]->leave_status == 'sick'){ echo 'checked="checked"'; } ?>  class="" name="leave_status" id="leave_status_sick" value="sick"> Sick Leave </label>
														<?php }
												} ?>
												<?php } else{ ?>
													<!--<input type="radio"  <?php //if(isset($list_data[0]->leave_status) && $list_data[0]->leave_status == 'paid'){ echo 'checked="checked"'; } ?> class="" name="leave_status" id="leave_status_paid" value="paid"> <span class="paid_leave_class">Paid Leave &nbsp&nbsp&nbsp </span> -->
												    <label class="form-radio-label"><input type="radio" <?php if(isset($list_data[0]->leave_status) && $list_data[0]->leave_status == 'sick'){ echo 'checked="checked"'; } ?>  class="" name="leave_status" id="leave_status_sick" value="sick"> <span class="sick_leave_class">Sick Leave &nbsp&nbsp </span></label>
												<?php } ?>
											<!-- </div> -->
		                                </div>
                                	</div>
                                
								<?php if($user_role == "admin"){ ?>
									<div class="col-md-6 col-xs-12">
										<div class="form-group form-radio">
											<label class="form-radio-labe">Leave Status</label>
											
												<!-- <div id="status_error"></div> -->

												<label class="form-radio-label"><input type="radio"  <?php if(isset($list_data[0]->status) && $list_data[0]->status == 'approved'){ echo 'checked="checked"'; } ?> class="" name="status" id="status_approve" value="approved"> Approve Leave </label>

												<label class="form-radio-label"><input type="radio" <?php if(isset($list_data[0]->status) && $list_data[0]->status == 'rejected'){ echo 'checked="checked"'; } ?>  class="" name="status" id="status_reject" value="rejected"> Reject Leave </label>

											
										</div>
									</div>
								</div>
								<?php }else{ ?>
									<input type="hidden" name="status" id="status" value="<?php if(!isset($list_data[0]->status) && empty($list_data[0]->status)){ echo "pending"; }?>">
								<?php } ?>
								<input type="hidden" id="edit_leave_status" value="<?php if(isset($list_data) && isset($list_data[0]->leave_status)){ echo $list_data[0]->leave_status; } ?>" >
                            	<div class="col-12">
                                    <div class=" text-center">
                                        <button class="btn sec-btn-outline submit_form"><?php echo $page_text; ?></button>
                                    </div>
                                </div>
                            </form>
            </div>
        </div>
	</div>
</div>

<script>
	$(document).ready(function(){
		employee_select('#employee_select');
	});
<?php if($user_role != "admin"){ ?>
 jQuery(document).ready(function ($) {
	 var edit_leave_status1=$("#edit_leave_status").val();
		if(edit_leave_status1 == "paid" ){
			  $(".paid_leave_class").show();
			  $("#leave_status_paid").show();
		}else{
			 $(".paid_leave_class").hide();
			  $("#leave_status_paid").hide();
		}
 });
<?php } ?>
$(document).on('change', '#employee_select', function(){
	var $this = this;
	employee_select($this);
});
function employee_select($this){
	var base_url=$("#js_data").attr("data-base-url");
	var id=$($this).val();
	var edit_leave_status=$("#edit_leave_status").val();
	
	var data = {
		'employee_id': id,
	};
	$.ajax({
		url: base_url+"leave_request/leave_count",
		type: "post",
		data: data ,
		success: function (response) {
			
		  var obj = jQuery.parseJSON(response);
		  console.log(obj);
		  var remaing_sick_leave =obj.remaing_sick_leave;
		  var this_month_paid_leave = obj.remaing_paid_leave;
		  var paid_leave = obj.paid_leave;
		  var sick_leave = obj.sick_leave;
		  console.log(remaing_sick_leave+" - "+this_month_paid_leave+" - "+paid_leave);
		  if(remaing_sick_leave == "0"){
			  $(".sick_leave_class").hide();
			  $("#leave_status_sick").hide();
			}else{
			  $(".sick_leave_class").show();
			  $("#leave_status_sick").show();
		  }
		  if(this_month_paid_leave == "0"){
			  $(".paid_leave_class").hide();
			  $("#leave_status_paid").hide();
		  }else{
			   $(".paid_leave_class").show();
			   $("#leave_status_paid").show();
		  }
		  if(edit_leave_status != ""){
			  if(edit_leave_status == "paid"){
				  $(".paid_leave_class").show();
				  $("#leave_status_paid").show();
			  }else{
				   $(".paid_leave_class").hide();
				  $("#leave_status_paid").hide();
			  }
		  }
		  var leave_html="";
		//   alert(paid_leave);
		  leave_html +='<div class="row"> <div class="col-lg-6 col-md-6 col-xs-12"><div class="analytics-info border-none"><h3 class="title">Used Paid Leave</h3><h3 class="counter">'+paid_leave+'</h3></div></div>';
		  leave_html +='<div class="col-lg-6 col-md-6 col-xs-12"><div class="analytics-info border-none"><h3 class="title">Used sick Leave</h3><h3 class="counter">'+sick_leave+'</h3></div></div></div>';
		  leave_html +='<div class="row"> <div class="col-lg-6 col-md-6 col-xs-12"><div class="analytics-info border-none"><h3 class="title">Remaining Paid Leaves</h3><h3 class="counter">'+this_month_paid_leave+'</h3></div></div>';
		  leave_html +='<div class="col-lg-6 col-md-6 col-xs-12"><div class="analytics-info border-none"><h3 class="title">Remaining sick Leaves</h3><h3 class="counter">'+remaing_sick_leave+'</h3></div></div></div>';
		  $(".html_leave").html(leave_html);
		},
	}); 
	 //console.log(id+" "+month+" "+year);
	//alert("sdsd");
}
</script>