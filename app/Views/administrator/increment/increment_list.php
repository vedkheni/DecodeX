<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row bg-title">
			<?php $user_role = $this->session->get('user_role'); ?>
			<div class="col-lg-12 col-md-12 col-xs-12">
				<h4 class="page-title">Increment Details</h4>
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
												<input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
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
												<button type="button" class="btn sec-btn add_new_emp pull-right" data-id="<?php echo $emp->id; ?>" data-toggle="modal" id="increment-update" data-target="#myModal_increment" class="btn btn-outline-success btn-block increment-update-date" data-increment-status="Approved">Add Increment</button>

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
						<table class="table  display nowrap" id="example_tbl" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Increment Date</th>
									<th>Status</th>
									<th>Amount</th>
									<?php if ($user_role == 'admin') { ?>
										<th>Action</th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($get_employee_increment_data)) {
									$i = 1;
									/* echo "<pre>";print_r($get_employee_increment_data);echo "</pre>"; */
									foreach ($get_employee_increment_data as $val) {
								?>
										<tr>
											<td><?php echo $i;  ?></td>
											<td class="increment_date_update<?php echo $val->id; ?>"><?php echo dateFormat($val->increment_date);  ?></td>
											<td class="increment_status<?php echo $val->id; ?>"><?php echo ucwords($val->status);  ?></td>
											<td class="amount_update<?php echo $val->id; ?>"><?php echo $val->amount;  ?></td>
											<?php if ($user_role == 'admin') { ?>
												<td><button data-id="<?php echo $val->id;  ?>" data-increment_date="<?php echo $val->increment_date;  ?>" data-status="<?php echo $val->status;  ?>" data-next_increment_date="<?php echo $val->next_increment_date;  ?>" data-amount="<?php echo $val->amount;  ?>" class="edit-employee-increment btn btn-outline-secondary" data-toggle="modal" data-target="#modal_attendsnce">Edit</button><button data-id="<?php echo $val->id;  ?>" class="btn btn-outline-danger m-l-5 delete-employee-increment">Delete</button></td>
											<?php } ?>
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
		<div class="modal increment-modal" id="myModal_increment" role="dialog">

			<div class="modal-dialog modal-dialog-centered">

				<div class="modal-content">
					<div class="preloader preloader-2 approve_preloader" style="display: none;">
						<svg class="circular" viewBox="25 25 50 50">
							<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
						</svg>
					</div>
					<div class="modal-header">
						<button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
						<div class="modal_header-content">
							<h4 class="modal-title emp_name employee_name"><?php echo $get_employee[0]->fname . " " . $get_employee[0]->lname; ?></h4>
							<h5 class="modal-sub-title">Add Increment</h5>
						</div>
					</div>

					<form method="POST" name="increment_form" id="increment_form">
						<div class="modal-body">
							<div class="salary_main days">

								<div class="row">
									<div class="col-6">
										<div class="form-sigle-line">
											<p>Current Salary :</p>
										</div>
									</div>
									<div class="col-6">
										<p class="salay_details current_salary"> <?php echo $get_employee[0]->salary; ?></p>
									</div>
								</div>

								<div class="row">
									<div class="col-6">
										<div class="form-sigle-line">
											<p>Employee Status :</p>
										</div>
									</div>
									<div class="col-6">
										<p class="salay_details employee_status"> <?php echo ucwords($get_employee[0]->employee_status); ?></p>
									</div>
								</div>

								<div class="row">
									<input type="hidden" name="emp_id" id="emp_id" value="<?php echo $get_employee[0]->id; ?>">
									<input type="hidden" name="increment_status" class="increment_status" id="increment_status" value="">
									<div class="col-6">
										<div class="form-sigle-line">
											<p>Employed Date :</p>
										</div>
									</div>
									<div class="col-6">
										<p data-join-date="" class="salay_details join_date"> <?php echo $get_employee[0]->employed_date; ?></p>
									</div>
								</div>

								<div class="row align-items-center m-b-20">
									<div class="col-12 col-sm-6">
										<div class="form-sigle-line">
											<label class="m-0">Increment Date :</label>
										</div>
									</div>
									<div class="col-12 col-sm-6">
										<div class="single-field date-field salay_details">
											<input type="text" name="increment_date1" id="increment_date1" value="<?php echo date('Y-m-d'); ?>" class='datepicker-here' autocomplete="off" data-language='en'>
										</div>
									</div>
								</div>

								<div class="row align-items-center m-b-20">
									<div class="col-12 col-sm-6">
										<div class="form-sigle-line">
											<label class="m-0">Increment Amount :</label>
										</div>
									</div>
									<div class="col-12 col-sm-6">
										<div class="single-field salay_details">
											<input type="text" name="increment_amount1" step="any" id="increment_amount1">
										</div>
									</div>
								</div>

								<div class="row align-items-center">
									<div class="col-12 col-sm-6">
										<div class="form-sigle-line">
											<label class="m-0">Select Status :</label>
										</div>
									</div>
									<div class="col-12 col-sm-6">
										<div class="single-field select-field multi-field _search-form m-0">
											<select name="increment_status_add" id="increment_status_add">
												<option value="" disabled> Select Status </option>
												<option value="approved">Approved</option>
												<option value="pending">Pending</option>
											</select>
										</div>
									</div>
								</div>

							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn sec-btn increment-submit">Submit</button>
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
							<h4 class="modal-title emp_name h5-emp-name employee_name1">Employee : <?php echo $get_employee[0]->fname . "" . $get_employee[0]->lname; ?></h4>
							<h5 class="modal-sub-title">Edit Increment</h5>
						</div>
					</div>
					<form class="form-horizontal form-material" method="Post" id="edit_employee_attendance-form">
						<!-- <div class="from_message time_msg"></div> -->

						<!-- <div class="from_message"></div> -->


						<input type="hidden" name="datepicker" id="datepicker" value="">
						<div class="modal-body">

							<div class="row justify-content-center">

								<div class="col-md-10 col-sm-10">
									<div class="form-group att-admin">
										<div class="single-field">
											<input type="text" name="increment_amount" step="any" id="increment_amount">
											<label>Increment Amount</label>
										</div>
									</div>
								</div>

								<div class="col-md-10 col-sm-10">
									<div class="form-group att-admin">
										<div class="single-field">
											<input type="text" name="increment_date" id="increment_date" class='datepicker-here' autocomplete="off" data-language='en'>
											<label>Increment Date</label>
										</div>
									</div>
								</div>

								<div class="col-md-10 col-sm-10">
									<div class="form-group att-admin">
										<div class="single-field select-field multi-field _search-form m-0">
											<select name="increment_status" id="increment_status">
												<option value="" disabled> Select Status </option>
												<option value="approved">Approved</option>
												<option value="pending">Pending</option>
											</select>
											<label>Select Status</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" name="increment_id" id="increment_id" value="">
						<div class="modal-footer justify-content-center" id="all_btn">
							<button type="button" class="btn sec-btn submit_form update-increment">Update</button>
							<button type="button" class="btn btn-danger reset_data" onclick='$("#next_increment_date").val("");$("#increment_date").val("");$("#increment_amount").val("");'>Reset</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">

	</script>