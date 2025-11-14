<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row bg-title">
			<?php $user_role = $this->session->get('user_role'); ?>
			<div class="col-lg-12 col-md-12 col-xs-12">
				<h4 class="page-title">Paid Leave List</h4>
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
					<?php if ($user_role == "admin") { ?>
						<?php

						if (isset($get_bonus) && !empty($get_bonus)) {
							$current_year = $get_bonus[0]->year;
							$current_month = $get_bonus[0]->month;
							$bonus = $get_bonus[0]->bonus;
							$edit_id = $get_bonus[0]->id;
						} else {
							$current_year = date('Y');
							$current_month = date('n');
							$bonus = "";
							$edit_id = "";
						}

						/*  echo "<pre>";
				print_r($get_employee);
				echo "</pre>";  */
						?>
						<div class="attendance_report">
							<div class="_form-search-form deposit-search-form">
								<form method="post" action="<?php echo base_url('increment/index/' . $id) ?>" id="increment-form">
									<div class="_form-search-form">
										<div class="row">
											<div class="col-12 text-center">

												<input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
												<input type="hidden" name="edit_id" id="edit_id" value="<?php echo $edit_id; ?>">

												<div class="single-field select-field multi-field _search-form">
													<select name="employee_select" id="employee_select">
														<option value="" disabled> Select Employee </option>
														<?php foreach ($employee_list as $emp) { ?>
															<option <?php if (isset($id) && $id == $emp->id) {
																		echo "selected='selected'";
																	} ?> data-percentage="<?php echo $emp->salary_deduction ?>" data-salary="<?php echo $emp->salary ?>" value="<?php echo $emp->id; ?>"><?php echo $emp->fname . " " . $emp->lname; ?></option>
														<?php } ?>
													</select>
													<label>Select Employee</label>
												</div>
												<button type="button" class="btn sec-btn add_new_leave pull-right" data-toggle="modal" data-target="#myModal_paid_leave" onclick="$('.used_leave_div1').hide();$('.used_leave_year_div1').hide();$('.employee_name').text('Employee : '+$('select#employee_select option:selected').text());" class="btn btn-outline-success btn-block add-paid_leave">Add Paid Leave</button>

											</div>

											<!-- <div class="col-md-3 col-sm-3 col-xs-12 _search-form _search-btn"> -->
											<!-- <button class="btn btn-success submit_form" type="submit">Search</button> -->
											<!-- </div> -->
										</div>
									</div>
								</form>
							</div>
						</div>
					<?php } ?>
					<!-- <div class="error_msg"></div> -->
					<form class="frm-search" method="post" action="<?php echo base_url('increment/index/' . $id) ?>" id="bonus-formsdsd">
						<?php if ($user_role !== "admin") { ?>
							<input type="hidden" name="employee_select" id="employee_select" value="<?php echo $get_employee[0]->id; ?>">
						<?php } ?>
						<!--<div class="_form-search-form deposit-list-form">
						<div class="row">
							<div class="col-lg-4 col-xs-12">
								<div class="analytics-info">
									<h3 class="title">Name : </h3>
									<h3 class="name" id="dfdg"><?php //echo $get_employee[0]->fname." ".$get_employee[0]->lname; 
																?></h3>
								</div>
							</div>
							<div class="col-lg-4 col-xs-12">
								<div class="analytics-info">
									<h3 class="title">Salary : </h3>
									<h3 class="counter" id="percentage"><?php //if(isset($get_employee) && !empty($get_employee)){ echo $get_employee[0]->salary; } 
																		?></h3>
								</div>
							</div>
							<div class="col-lg-4 col-xs-12">
								<div class="analytics-info">
									<h3 class="title">Total Increment : </h3>
									<h3 class="counter" id="total_deposit"><?php //if(isset($get_deposit_total) && $get_deposit_total != ""){ echo $get_deposit_total; }else{ echo "0"; } 
																			?></h3>
								</div>
							</div>
						</div>
					</div>-->

					</form>
					<hr class="custom-hr">
					<div class="table-responsive box-shadow employee-table-list">
						<div class="preloader preloader-2" style="display:none"><svg class="circular" viewBox="25 25 50 50">
								<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
							</svg></div>
						<table class="table  display nowrap dataTable" id="example_tbl" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Year</th>
									<th>Month</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($paid_leave_list)) {
									$i = 1;
									/* echo "<pre>";print_r($paid_leave_list);echo "</pre>"; */
									foreach ($paid_leave_list as $val) {
								?>
										<tr>
											<td><?php echo $i;  ?></td>
											<td class="increment_date_update<?php echo $val->id; ?>"><?php echo $val->year;  ?></td>
											<td class="amount_update<?php echo $val->id; ?>"><?php echo $val->month;  ?></td>
											<td class="increment_status<?php echo $val->id; ?>"><?php echo ucwords($val->status);  ?></td>
											<td><button data-id="<?php echo $val->id;  ?>" data-employee_id="<?php echo $val->employee_id;  ?>" data-status="<?php echo $val->status;  ?>" data-year="<?php echo $val->year;  ?>" data-month="<?php echo $val->month;  ?>" data-used_leave_month="<?php echo $val->used_leave_month;  ?>" data-used_leave_year="<?php echo $val->used_leave_year;  ?>" class="edit-edit-paid-leave btn btn-outline-secondary" data-toggle="modal" data-target="#modal_attendsnce">Edit</button></td>
										</tr><?php
												$i++;
											}
										}
												?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Increment Approve Modal Start -->
		<div class="modal increment-modal" id="myModal_paid_leave" role="dialog">

			<div class="modal-dialog modal-dialog-centered">

				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
						<div class="modal_header-content">
							<h4 class="modal-title emp_name employee_name"></h4>
							<h5 class="modal-sub-title">Add Paid Leave</h5>
						</div>
					</div>

					<form method="POST" name="increment_form" id="increment_form">
						<div class="modal-body">
							<div class="salary_main days">
							<div class="row">
								<div class="col-12">
										<div class="form-group att-admin">
											<div class="single-field">
												<input type="text" name="month1" id="month1" class='datepicker-here' data-min-view="months" data-view="months" data-date-format="mm" data-language='en'>
												<label>Paid Leave Month</label>
											</div>
										</div>
									</div>

									<div class="col-12">
										<div class="form-group att-admin">
											<div class="single-field">
												<input type="text" name="year1" id="year1" class='datepicker-here' data-min-view="years" data-view="years" data-date-format="yyyy" data-language='en'>
												<label>Paid Leave Year</label>
											</div>
										</div>
									</div>
									<div class="col-12 used_leave_div1">
										<div class="form-group att-admin">	
											<div class="single-field">
												<input type="text" name="used_leave_month1" id="used_leave_month1" class='datepicker-here' data-min-view="months" data-view="months" data-date-format="mm" data-language='en'>
												<label>Used Paid Leave Month</label>
											</div>
										</div>
									</div>
									<div class="col-12 used_leave_year_div1">
										<div class="form-group att-admin">	
											<div class="single-field">
												<input type="text" name="used_leave_year1" id="used_leave_year1" class='datepicker-here' data-min-view="years" data-view="years" data-date-format="yyyy" data-language='en'>
												<label>Used Paid Leave Year</label>
											</div>
										</div>
									</div>

									<div class="col-12">
										<div class="form-group att-admin m-0">
											<div class="single-field select-field ">
												<select name="paid_leave_status1" id="paid_leave_status1">
													<option value="" disabled> Select Status </option>
													<option value="paid">Paid</option>
													<option value="used">Used</option>
													<option value="unused" selected="selected">Unused</option>
												</select>
												<label>Select Status</label>
											</div>
										</div>
									</div>
							</div>

							</div>
						</div>
						<div class="modal-footer text-right">
							<button type="button" class="btn sec-btn add-paid_leave">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Increment Approve Modal End -->
		<div id="modal_attendsnce" class="modal employee-model">
			<div class="modal-dialog modal-dialog-centered">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
						<div class="modal-header-content">
							<h4 class="modal-title emp_name h5-emp-name employee_name1">Employee : <?php //echo $get_employee[0]->fname . "" . $get_employee[0]->lname; ?></h4>
							<h5 class="modal-sub-title">Edit Paid Leave</h5>
						</div>
					</div>
					<form class="form-horizontal form-material" method="Post" id="edit_employee_attendance-form">
						<!-- <div class="from_message time_msg"></div> -->

						<!-- <div class="from_message"></div> -->


						<input type="hidden" name="datepicker" id="datepicker" value="">
						<input type="hidden" name="leave_id" id="leave_id" value="">
						<div class="modal-body">

							<div class="row">
								<div class="col-12">
									<div class="form-group att-admin">
										<div class="single-field">
											<input type="text" name="month" id="month" class='datepicker-here' data-min-view="months" data-view="months" data-date-format="mm" data-language='en'>
											<label>Paid Leave Month</label>
										</div>
									</div>
								</div>

								<div class="col-12">
									<div class="form-group att-admin">
										<div class="single-field">
											<input type="text" name="year" id="year" class='datepicker-here' data-min-view="years" data-view="years" data-date-format="yyyy" data-language='en'>
											<label>Paid Leave Year</label>
										</div>
									</div>
								</div>
								<div class="col-12 used_leave_div">
									<div class="form-group att-admin">
										<div class="single-field">
											<input type="text" name="used_leave_month" class='datepicker-here' data-min-view="months" data-view="months" data-date-format="mm" data-language='en' id="used_leave_month">
											<label>Used Paid Leave Month</label>
										</div>
									</div>
								</div>
								<div class="col-12 used_leave_year_div">
									<div class="form-group att-admin">
										<div class="single-field">
											<input type="text" name="used_leave_year" class='datepicker-here' data-min-view="years" data-view="years" data-date-format="yyyy" data-language='en' id="used_leave_year">
											<label>Used Paid Leave Year</label>
										</div>
									</div>
								</div>

								<div class="col-12">
									<div class="form-group att-admin m-0">
										<div class="single-field select-field">
											<select name="paid_leave_status" id="paid_leave_status">
												<option value=""> Select Status </option>
												<option value="paid">Paid</option>
												<option value="used">Used</option>
												<option value="unused" >Unused</option>
											</select>
											<label>Select Status</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" name="increment_id" id="increment_id" value="">
						<div class="modal-footer text-right" id="all_btn">
							<button type="button" class="btn sec-btn submit_form update-paid_leave">Update</button>
							<!-- <button type="button" class="btn btn-success reset_data" onclick='$("#next_increment_date").val("");$("#increment_date").val("");$("#increment_amount").val("");'>Reset</button> -->
						</div>
					</form>
				</div>
			</div>
		</div>

	<script type="text/javascript">
	</script>