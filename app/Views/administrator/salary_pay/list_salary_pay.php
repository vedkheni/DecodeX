<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row bg-title">

			<div class="col-lg-12 col-md-12 col-xs-12">
				<h4 class="page-title text-center">Employee's Salary Details</h4>
			</div>

		</div>
		<?php $user_role = $this->session->get('user_role');  ?>
		<div class="row">
			<div class="col-md-12">
				<div class="white-box m-0">
					<div id="myModal" class="modal salary_modal" role="dialog">
						<div class="modal-dialog modal-dialog-centered modal-lg">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="preloader preloader-2 salary_preloader" style="display:none">
									<svg class="circular" viewBox="25 25 50 50">
										<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
									</svg>
								</div>
								<div class="modal-header">
									<button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
									<div class="modal-header-content">
										<div class="row align-items-center">
											<div class="col-lg-8 col-12">
												<h4 class="modal-title emp_name employee_name">Tarun Gudala - Designer</h4>
											</div>
											<div class="col-lg-4 col-12 text-left text-lg-right">
												<h5 class="modal-sub-title salary-month">November-2019</h5>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-body">
									<div class="salary_main">
										<div class="row m-0">
											<form class="form-horizontal w-100" action="<?php base_url('salary_pay/insert_data'); ?>">
												<input type="hidden" name="diposit_status" id="diposit_status" value="pending">
												<input type="hidden" name="submit_status" id="submit_status" value="add">
												<!-- time -->
												<div class="preloader preloader_salary_pay">
													<svg class="circular" viewBox="25 25 50 50">
														<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
													</svg>
												</div>
												<div class="days salary-popup-sec bor-bottom">
													<h4 class="_heading">Attendance Time :</h4>
													<div class="salary-popup attendance-time">
														<div class="row">
															<div class="col-lg-4 col-12 bor-right">
																<div class="form-group">
																	<p class="control-label ">Plus Time:<span data-plus-time="" class="salay_details total_plus_time"> 11:20</span></p>
																</div>
															</div>
															<div class="col-lg-4 col-12 bor-right">
																<div class="form-group">
																	<p class="control-label ">Minus Time :<span data-minus-time="" class="salay_details total_minus_time"> 11:20</span></p>
																</div>
															</div>
															<div class="col-lg-4 col-12">
																<div class="form-group">
																	<p class="control-label ">Total Time :<span data-total-time="" class="salay_details color_border_green total_plus_minus_time"> 00:00</span></p>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!-- end -->
												<!-- Days -->
												<div class="days salary-popup-sec bor-bottom">
													<h4 class="_heading">Days :</h4>
													<div class="salary-popup">
														<div class="row">
															<div class="col-lg-4 col-12 bor-right">
																<div class="form-group">
																	<p class="control-label">Working Days:<span data-plus-time="" class="salay_details total_working_day"> 23</span></p>
																</div>
															</div>
															<div class="col-lg-4 col-12 bor-right">
																<div class="form-group">
																	<p class="control-label">Official Holidays :<span data-offical-holiday="" class="salay_details total_official_holiday"> 8</span></p>
																</div>
															</div>
															<div class="col-lg-4 col-12">
																<div class="form-group">
																	<p class="control-label">Present Days :<span data-present-days="" class="salay_details total_effective_day"> 0</span></p>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!-- end -->
												<!-- leave section -->
												<div class="leave salary-popup-sec">
													<h4 class="_heading">Leaves :</h4>
													<div class="salary-popup bor-bottom">
														<div class="row">
															<div class="col-lg-4 col-12 bor-right">
																<div class="form-group">
																	<p class="control-label">Leaves :<span data-leaves-days="" class="salay_details total_leave"> 20</span></p>
																</div>
															</div>
															<div class="col-lg-4 col-12 bor-right">
																<div class="form-group">
																	<p class="control-label">Paid Leaves :<span data-present-days="" class="salay_details total_paid_leave"> 1</span></p>
																</div>
															</div>
															<div class="col-lg-4 col-12">
																<div class="form-group">
																	<p class="control-label">Sick Leaves :<span data-sick-days="" class="salay_details total_sick_leave"> 0</span></p>
																</div>
															</div>
														</div>
													</div>
													<div class="salary-popup">
														<div class="row">
															<div class="col-lg-4 col-12 bor-right">
																<div class="form-group">
																	<p class="control-label">Approved Leaves :<span data-approved-leaves="" class="salay_details total_approved_leave"> 0</span></p>
																</div>
															</div>
															<div class="col-lg-4 col-12 bor-right">
																<div class="form-group">
																	<p class="control-label" title="1 Leave = 1.5 Unapproved Leave Count">Unapproved Leaves <i class="fa fa-info-circle" aria-hidden="true"></i> :<span data-unapproved-leaves="" class="salay_details total_unapproved_leave"> 0</span></p>
																</div>
															</div>
															<div class="col-lg-4 col-12">
																<div class="form-group">
																	<p class="control-label" title="Including Unapproved Leaves">Total Leaves <i class="fa fa-info-circle" aria-hidden="true"></i> :<span data-absent-leaves="" class="salay_details total_absent_leave"> 1</span></p>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!-- end -->
												<!-- salary -->
												<div class="salary salary-popup-sec m-0">
													<h4 class="_heading">Salary :</h4>
													<div class="salary-popup">
														<div class="row">
															<div class="col-lg-6 col-12 order-last order-lg-first">
																<div class="form-group">
																	<p class="control-label ">Basic Salary :<span data-basic-salary="" class="salay_details total_basic_salary"> 0</span></p>
																	<?php if ($user_role == "admin") { ?>
																		<input type="hidden" id="remove_deposit" name="remove_deposit" value="">
																		<p class="row_total_deposit control-label ">
																			<span id="per_val1" class="per_val">Deposit :</span>
																			<span>
																				<span data-total-deposit="" class="salay_details total_deposit">
																					<button type="button" class="btn btn-default text-primary p-0 pay-deposit" data-pay-deposit="">Pay Deposit</button>
																				</span>
																				<span class="float-right"><button type="button" class="btn btn-default text-danger p-0 remove_pay-deposit" style="display: none;"><i class="fas fa-times"></i></button></span>
																			</span>
																		</p>
																	<?php } ?>
																	<p class="control-label deduction_lable"><span id="per_val" class="per_val">%</span>Deduction :<span data-deduction-per="" class="salay_details total_deduction_per"> 0</span></p>
																	<p class="control-label ">Leave Deduction :<span data-leave-deduction="" class="salay_details total_deduction"> 0</span></p>
																	<p class="control-label row_payout_paid_leave">Paid Leave :<span data-leave-deduction="" class="salay_details view_payout_paid_leave"> 0</span></p>
																	<p class="control-label ">Prof Tax :<span data-prof-tax="" class="salay_details total_prof_tax"> 0</span></p>
																	<p class="control-label ">Bonus :<span data-bonus="" class="salay_details  total_bonus"><input data-bonus="" type="number" name="bonus" step="any" id="bonus" autocomplete="off" placeholder="Bonus"></span></p>
																	<p class="control-label total-salary">Total Salary :<span data-total-salary="" class="salay_details total_net_salary"> 0</span></p>
																</div>
															</div>
															<?php if ($user_role == "admin") { ?>
																<div class="col-lg-6 col-12 bor-left order-first order-lg-last">
																	<div class="form-group skip_paid_leave_div">
																		<p class="control-label ">Skip Paid Leave :<span class="salay_details skip_paid_leave"> <input type="checkbox" name="skip_paid_leave" id="skip_paid_leave" value="1"></span></p>
																	</div>
																	<div class="form-group skip_paid_leave_div">
																		<p class="control-label ">Payout Paid Leave (₹ <span class="float-none payout_paid_leave_amount" data-payout_paid_leave_amount="0">0</span>) :<span class="salay_details payout_paid_leave"> <input type="checkbox" name="payout_paid_leave" id="payout_paid_leave" value="1"></span></p>
																	</div>
																	<!-- <div class="form-group skip_paid_leave_div">
																		<p class="control-label ">Paid Leave Amount :</p>
																	</div> -->
																	<div class="form-group note_paid_leave"></div>
																	<div class="form-group qr_code_image"></div>
																</div>

															<?php }else{ ?>
																<input type="checkbox" name="payout_paid_leave" class="d-none" id="payout_paid_leave" value="1">	
															<?php } ?>
														</div>
													</div>
												</div>
												<input type="hidden" name="eid" id="eid" value="">
												<!-- end -->
											</form>
										</div>
									</div>
								</div>
								<div class="modal-footer justify-content-center">
									<div class="row w-100">
										<div class="col-12 text-right p-0">
											<button type="button" data-payment-status="paid" data-id="" class="btn sec-btn submit salary_pay_btn salary_payEdit_btn">Update</button>
											<button type="button" data-payment-status="paid" data-id="" class="btn sec-btn submit salary_pay_btn">Pay</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<form class="frm-search" method="post" action="<?php echo base_url('salary_pay'); ?>" id="bonus-form">
						<div class="_form-search-form">
							<div class="emp-custom-field">
								<div class="row">
									<input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
									<?php if ($user_role == "admin") { ?>
										<div class="col-lg-8 col-12 text-center text-lg-left">
											<div class="single-field select-field multi-field _search-form admin123">
												<select class="emp_search1" id="bonus_month" name="bonus_month">
													<option value="" disabled>Month</option>
													<?php foreach (MONTH_NAME as $k => $v) { ?>
														<option <?php if ($current_month == $k + 1) {
																	echo "selected='selected'";
																} ?> value="<?php echo $k + 1; ?>"><?php echo $v; ?></option>
													<?php } ?>
												</select>
												<label>Select Month</label>
											</div>
											<div class="single-field select-field multi-field _search-form">
												<select class="emp_search1" id="bonus_year" name="bonus_year">
													<option value="" disabled>Year</option>
													<?php
													$next_year=date('Y',strtotime('+2 year'));;
													for ($i = 2018; $i <= $next_year; $i++) { ?>
														<option <?php if ($current_year == $i) {
																	echo "selected='selected'";
																} ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
													<?php } ?>
												</select>
												<label>Select Year</label>
											</div>
											<?php if ($user_role == "admin") { ?>
												<div class="emp_submit emp_view d-inline-block">
													<?php $month_name = date('F', mktime(0, 0, 0, $current_month, 10));
												// 	$file_exists = $_SERVER['DOCUMENT_ROOT'] . '/assets/salary_pay/Salary_' . $month_name . '_' . $current_year . '.txt';
													$file_exists = $_SERVER['DOCUMENT_ROOT'] . '/pay_txt/Salary_' . $month_name . '_' . $current_year . '.txt';
													if (file_exists($file_exists)) { ?>
														<!-- <a target="_blank" class="btn sec-btn emp_search " id="text_file" href="<?php echo base_url() . 'salary_pay/txt_file_update/' . $current_month . '/' . $current_year; ?>">View Text File</a> -->
														<a target="_blank" class="btn sec-btn emp_search " id="text_file" href="<?php echo base_url() . 'salary_pay/upi_txt_file_update/' . $current_month . '/' . $current_year; ?>">View Text File</a>
													<?php }
													?>
												</div>
											<?php } ?>
										</div>
										<div class="col-lg-4 col-12 text-center text-lg-right">
											<?php if ($user_role == "admin") { ?>
												<div class="_form-search-form deposit-list-form">
													<div class="_search-form ">
														<h4 class="total-salary-title">Total Salary :
															<span class="blue-text" id="totle_salary"><?php setlocale(LC_MONETARY, 'en_IN');
																										echo (isset($total_salary[0]->total_salary) && !empty($total_salary[0]->total_salary)) ? number_format($total_salary[0]->total_salary,2) : "0";  ?></span>
														</h4>
													</div>
												</div>
												<div id="massagae"><?php echo $this->session->getFlashdata('message'); ?> </div>
											<?php } ?>
										</div>
									<?php } else { ?>
										<div class="col-12 text-center">
											<div class="single-field select-field multi-field _search-form xyz">
												<select class="emp_search1" id="bonus_month" name="bonus_month">
													<option value="" disabled>Month</option>
													<?php foreach (MONTH_NAME as $k => $v) { ?>
														<option <?php if ($current_month == $k + 1) {
																	echo "selected='selected'";
																} ?> value="<?php echo $k + 1; ?>"><?php echo $v; ?></option>
													<?php } ?>
												</select>
												<label>Select Month</label>
											</div>
											<div class="single-field select-field multi-field _search-form">
												<select class="emp_search1" id="bonus_year" name="bonus_year">
													<option value="" disabled>Year</option>
													<?php
													$next_year=date('Y',strtotime('+2 year'));
													for ($i = 2018; $i <= $next_year; $i++) { ?>
														<option <?php if ($current_year == $i) {
																	echo "selected='selected'";
																} ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
													<?php } ?>
												</select>
												<label>Select Year</label>
											</div>
										</div>
									<?php } ?>
								</div>
								<hr class="custom-hr">
							</div>
						</div>
					</form>
					<div class="table-responsive box-shadow employee-table-list">
						<div class="preloader preloader-2" style="display:none">
							<svg class="circular" viewBox="25 25 50 50">
								<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
							</svg>
						</div>
						<table id="example" class=" display nowrap" style="width:100%">
							<thead class="_empthead">
								<tr>
									<th></th>
									<th>Name</th>
									<th>Salary</th>
									<th>Bonus</th>
									<th>Leave</th>
									<?php if ($user_role == "admin") { ?>
										<th>QR Code</th>
									<?php } ?>
									<th>Payment Status</th>
									<?php if ($user_role == "admin") { ?>
										<th>Bank Status</th>
									<?php } ?>
									<th>Action</th>
								</tr>
							</thead>
							<tbody class="_emptbody">
							</tbody>
							<tfoot class="_emptfoot">
								<tr>
									<th></th>
									<th>Name</th>
									<th>Salary</th>
									<th>Bonus</th>
									<th>Leave</th>
									<?php if ($user_role == "admin") { ?>
										<th>QR Code</th>
									<?php } ?>
									<th>Payment Status</th>
									<?php if ($user_role == "admin") { ?>
										<th>Bank Status</th>
									<?php } ?>
									<th>Action</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="js_user_role" data-user_role="<?php echo $user_role = $this->session->get('user_role'); ?>"></div>
	<script type="text/javascript">
	</script>