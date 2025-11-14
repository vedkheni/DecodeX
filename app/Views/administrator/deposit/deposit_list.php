<!-- <style>
.time-minus{
	color : red;
}
.time-plus{
	color:green;
}
</style> -->
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row bg-title">
			<!-- <div class="col-sm-4"> -->
            <!--<h4 class="page-title back-btn">
                <a href="#" class="learn-more">
                    <div class="circle">
                      <span class="icon arrow"></span>
                    </div>
                    <p  class="button-text">                
                            Back
					</p>
                </a>
            </h4>--> 
            <!-- </div> -->
            <?php $user_role=$this->session->get('user_role'); ?>
            <div class="col-lg-12 col-md-12 col-xs-12">
            	<h4 class="page-title">Deposit</h4> 
            </div>
        <!-- <div class="col-sm-4">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('employee'); ?>">Employee</a></li>
                <li class="active"> Deposit</li>
            </ol>
        </div> -->
        <!-- /.col-lg-12 -->
    </div>
    <!--  from to and dropdown search  -->
    <div class="row">
    	<div class="col-md-12">
    		<div class="white-box m-0">
    			<!-- total time Start -->

    			<!-- total time end -->
    			<?php if($user_role == "admin"){ ?>
    				<?php 

    				if(isset($get_bonus) && !empty($get_bonus)){
    					$current_year=$get_bonus[0]->year; 
    					$current_month=$get_bonus[0]->month;
    					$bonus=$get_bonus[0]->bonus;
    					$edit_id=$get_bonus[0]->id;
    				}else{	 
    					$current_year=date('Y'); 
    					$current_month=date('n');
    					$bonus="";
    					$edit_id="";
    				}

				/* echo "<pre>";
				print_r($deposit_payment[0]['status']);
				echo "</pre>"; */
				?>		
				<div class="attendance_report">
					<div class="_form-search-form deposit-search-form">
						<form method="post" action="<?php echo base_url('deposit/index/'.$id) ?>" id="bonus-form">
							<div class="_form-search-form">
								<div class="row">
									<div class="col-12 text-center">
									
									<input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
									<input type="hidden" name="emp_id" id="emp_id" value="<?php echo $id; ?>">
									<input type="hidden" name="edit_id" id="edit_id" value="<?php echo $edit_id; ?>">

										<div class="single-field select-field multi-field _search-form m-0">
											<select name="employee_select" id="employee_select">
												<option value="" disabled> Select Employee </option>
												<?php foreach($employee_list as $emp){ ?>
													<option <?php if(isset($id) && $id == $emp->id){ echo "selected='selected'"; } ?> data-percentage="<?php echo $emp->salary_deduction ?>" data-salary="<?php echo $emp->salary ?>"  value="<?php echo $emp->id; ?>"><?php echo $emp->fname ." ".$emp->lname; ?></option>
												<?php } ?>
											</select>
											<label>Select Employee</label>
										</div>
									</div>

									<!-- <div class="col-md-3 col-sm-3 col-xs-12 _search-form _search-btn"> -->
										<!-- <button class="btn btn-success submit_form" type="submit">Search</button> -->
										<!-- </div> -->
									</div>
								</div>
							</form>
						</div>
					</div>
				<hr class="custom-hr">
				<?php } ?>
				<!-- <div class="error_msg"></div> -->
				<form class="frm-search" method="post" action="<?php echo base_url('deposit/index/'.$id) ?>" id="bonus-formsdsd">
					<?php if($user_role !== "admin"){?>
						<input type="hidden" name="employee_select" id="employee_select" value="<?php echo $get_employee[0]->id;?>">
					<?php } ?>
					<div class="_form-search-form deposit-list-form">
						<div class="row">
							<div class="col-lg-4 col-xs-12">
								<div class="analytics-info">
									<h3 class="title">Name : </h3>
									<h3 class="name" id="dfdg"><?php echo $get_employee[0]->fname." ".$get_employee[0]->lname; ?></h3>
								</div>
							</div>
							<div class="col-lg-4 col-xs-12">
								<div class="analytics-info">
									<h3 class="title">Percentage : </h3>
									<h3 class="counter" id="percentage"><?php echo (isset($deposit_total_pr) && !empty($deposit_total_pr))? $deposit_total_pr: '0'; ?>%</h3>
									<!-- <h3 class="counter" id="percentage"><?php //if(isset($get_employee) && !empty($get_employee)){ echo $get_employee[0]->salary_deduction; } ?>%</h3> -->
								</div>
							</div>
							<div class="col-lg-4 col-xs-12">
								<div class="analytics-info">
									<h3 class="title">Total Deposit : </h3>
									<h3 class="counter" id="total_deposit"><?php if(isset($get_deposit_total) && $get_deposit_total != ""){ echo $get_deposit_total; }else{ echo "0"; } ?></h3>
								</div>
							</div>
						</div>

						<?php //if($user_role == "admin"){ ?>
							<!--<div class="col-lg-3 col-sm-6 _search-form">
                                 <label>Status : </label>
								  <?php //if(isset($deposit_payment[0]['status']) && $deposit_payment[0]['status'] == "paid"){ ?>
									<p>Paid</p>
								 <?php //}else{ ?>
									 <p>Unpaid</p>
								 <?php //} ?>
								</div>-->
								<?php //} ?>
							</div>

						</form>
						<hr class="custom-hr">
						<div class="table-responsive box-shadow employee-table-list">
							<div class="preloader preloader-2" style="display:none"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>
							<table class="table  display nowrap" id="example_tbl" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Deposit</th>
										<th>Month</th>
										<th>Year</th>
										<th>Status</th>
										<?php if($user_role == 'admin'){ ?>
										<th>Action</th>
										<?php } ?>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="edit_deposit" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
						<div class="modal_header">
							<h4 class="modal-title emp_name employee_name">Update Deposit</h4>
						</div>
					</div>
					<form class="small-form" method="post" action="<?php echo base_url('deposit/insert_data'); ?>" id="deposit-form">
						<div class="modal-body">
							<div class="row">
								<!-- <div class="error_msg"></div> -->
								<input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
									<input type="hidden" name="deposit_id" id="deposit_id" value="" />
									<input type="hidden" id="edit_modal" value="Edit Using Modal" />

								<div class="col-12">
									<div class="form-group">
										<div class="single-field">
											<input type="text" id="emp_name" disabled>
											<label>Employee Name</label>
										</div>
									</div>
								</div>

								<div class="col-12">
									<input type="hidden" name="salary_deduction_per" id="salary_deduction_per" value="">
									<div class="form-group">	
										<div class="single-field">
											<input type="text" placeholder="Deposit" name="deposit" id="deposit" value=""> 
											<label>Deposit*</label>
										</div>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">	
										<div class="single-field select-field">
											<select id="deposit_month" name="deposit_month" >
												<option value="" disabled>Select Month</option>
												<?php foreach(MONTH_NAME as $k => $v){ ?>
													<option value="<?php echo $k+1; ?>"><?php echo $v; ?></option>
												<?php } ?>
											</select>
											<label>Select Month*</label>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group m-0">	
										<div class="single-field select-field">
											<select id="deposit_year" name="deposit_year" >
												<option value="" disabled>Select Year</option>
												<?php
												$next_year=2022;
												for($i=2019;$i<=$next_year;$i++){?>
													<option value="<?php echo $i;?>"><?php echo $i;?></option>
												<?php } ?>
											</select>
											<label>Select Year*</label>
										</div>
									</div>	
								</div>	
							</div>
						</div>
						<div class="modal-footer justify-content-center">
							<div class="row w-100">
								<div class="col-6 p-0 text-left">
									<input type="reset" class="btn btn-danger emp_reset" value="Reset">
								</div>
								<div class="col-6 p-0 text-right">
									<input type="submit" class="btn sec-btn emp_search" value="Submit">
								</div>
							</div>
						</div>
			    	</form>
				</div>
			</div>
		</div>
		<div class="modal" id="myModal" role="dialog" style="display: none;">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
						<div class="modal_header">
							<h4 class="modal-title emp_name employee_name">Update Designation</h4>
						</div>
					</div>
					<form method="post" action="https://stage.geekwebsolution.com/designation/insert_data" id="designation-form">
						<div class="modal-body">
							<input type="hidden" name="e_id" id="e_id" value="1">
											<input type="hidden" name="csrf_test_name" value="">
							<div class="form-group">
								<div class="single-field">
									<input type="text" name="designation" id="designation" value=""> 
									<label>Designation Name</label>
								</div>
							</div>
							<div class="form-group m-0">
								<div class="single-field">
									<textarea name="skills" id="skills" cols="4"></textarea>
									<!-- <input type="text" name="designation" id="designation" value="">  -->
									<label>Skills</label>
								</div>
							</div>
						</div>
						<div class="modal-footer justify-content-center">
							<div class="row w-100">
								<div class="col-12 p-0 text-right">
									<button class="btn sec-btn submit_form">Update</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(document).on('click', '.deposit_payment_btn', function(){
				var data = {
					'id': $("#employee_select").val(),
					'total_deposit': $("#total_deposit").text(),
				};
				var base_url=$("#js_data").attr("data-base-url");
				$.ajax({
					url: base_url+"deposit/insert_data_payment",
					type: "post",
					data: data ,
					success: function (response) {
						console.log(response);
				//location.reload();
			},

		}); 
			});
			$('#bonus').keypress(function(event) {
				if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
					event.preventDefault();
				}
			});
		</script>