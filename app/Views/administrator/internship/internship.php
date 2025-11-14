<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row bg-title">
			<?php $user_role = $this->session->get('user_role'); ?>
			<div class="col-lg-12 col-md-12 col-xs-12">
				<h4 class="page-title">Internship Details</h4>
			</div>
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

						?>
						<div class="attendance_report">
							<div class="_form-search-form deposit-search-form">
								<form method="post" action="<?php echo base_url('internship/index/' . (isset($id) ? $id : '')) ?>" id="internship-form">
									<div class="_form-search-form">
										<div class="row">
											<div class="col-12 text-center">
												<input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" />
												<input type="hidden" name="edit_id" id="edit_id" value="<?php echo $edit_id; ?>">

												<!-- <div class="single-field select-field multi-field _search-form">
													<select name="employee_select" id="employee_select">
														<option value="" disabled> Select Employee </option>
														<?php // foreach ($employee_list as $emp) { ?>
															<option <?php // if (isset($id) && $id == $emp->id) {
																		// echo "selected='selected'";
																	// } ?> data-percentage="<?php // echo $emp->salary_deduction ?>" data-salary="<?php // echo $emp->salary ?>" value="<?php // echo $emp->id; ?>"><?php // echo $emp->fname . " " . $emp->lname; ?></option>
														<?php // } ?>
													</select>
													<label>Select Employee</label>
												</div> -->
												<button type="button" class="btn sec-btn add_new_emp pull-right" onclick="resetFormModal();" data-toggle="modal" id="internship-update" data-target="#myModal_internship" class="btn btn-outline-success btn-block internship-update-date" data-internship-status="Approved">Add Intern</button>

											</div>

										</div>
									</div>
								</form>
							</div>
						</div>
					<?php } ?>
					<!-- <div class="error_msg"></div> -->

					<hr class="custom-hr">
					<div class="table-responsive box-shadow employee-table-list">
						<div class="preloader preloader-2 table-loader"><svg class="circular" viewBox="25 25 50 50">
								<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
							</svg></div>
						<table class="table  display nowrap" id="example_tbl" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Contact Number</th>
									<th>Email</th>
									<th>Course</th>
									<th>Internship Start Date</th>
									<th>Feedback Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Intern add modal start -->
		<div class="modal internship-modal" id="myModal_internship" role="dialog">

			<div class="modal-dialog modal-dialog-centered modal-lg">

				<div class="modal-content">
					<div class="preloader preloader-2 approve_preloader" style="display: none;">
						<svg class="circular" viewBox="25 25 50 50">
							<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
						</svg>
					</div>
					<div class="modal-header">
						<button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
						<div class="modal_header-content">
							<h4 class="modal-title internformtitle">Add Intern</h4>
						</div>
					</div>

					<form method="POST" name="internship_form" id="internship_form">
						<div class="modal-body">
							<div class="salary_main days row">
								
								<div class="col-md-6">
									<div class="form-group">
										<div class="single-field">
											<input type="text" name="name" id="name" value="">
											<label for="name">Name*</label>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<div class="single-field">
											<input type="text" class="numeric contact_number" maxlength="10" name="contact_number" id="contact_number" value="">
											<label for="contact_number">Contact Number*</label>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<div class="single-field">
											<input type="email" class="email" name="email" id="email" value="">
											<label for="email">Email Address*</label>
										</div>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group leave-commet-box">
										<div class="single-field">
											<textarea name="address" id="address" rows="5"></textarea>
											<label for="address">Address*</label>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<div class="single-field select-field">
											<select name="college_or_university" id="college_or_university">
												<option value="">Select College/University</option>
												<?php foreach($colleges as $k => $v){ ?>
													<option value="<?= $v->name ?>"><?= $v->name ?></option>
												<?php } ?>
											</select>
											<label for="college_or_university">Select College/University*</label>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<div class="single-field select-field">
											<select name="course" id="course">
												<option value="">Select Course</option>
												<option value="Laravel">Laravel</option>
												<option value="Javascript">Javascript</option>
												<option value="Node.js">Node.js</option>
												<option value="React.js">React.js</option>
												<option value="WordPress">WordPress</option>
												<option value="CodeIgniter">CodeIgniter</option>
												<option value="Python">Python</option>
												<option value="UI/UX">UI/UX</option>
												<option value="Graphic Designing">Graphic Designing</option>
												<option value="Digital Marketing">Digital Marketing</option>
												<option value="SEO">SEO</option>
											</select>
											<label for="course">Select Course*</label>
										</div>
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<div class="single-field date-field">
											<input type="text" name="internship_start_date" id="internship_start_date" data-date="<?= date('Y-m-d'); ?>" value="<?= date('Y-m-d'); ?>" class='datepicker-here' autocomplete="off" data-language='en' value="">
											<label for="internship_start_date">Internship Start Date*</label>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<div class="single-field date-field">
											<input type="text" name="internship_end_date" id="internship_end_date" data-date="" value="" class='datepicker-here' autocomplete="off" data-language='en' value="">
											<label for="internship_end_date">Internship End Date</label>
										</div>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group leave-commet-box">
										<div class="single-field">
											<textarea name="feedback" id="feedback" rows="5"></textarea>
											<label for="feedback">Intern's Feedback</label>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<div class="single-field select-field">
											<select name="feedback_status" id="feedback_status">
												<!-- <option value="">Select Feedback Status</option> -->
												<option value="pending">Pending</option>
												<option value="done">Done</option>
											</select>
											<label for="feedback_status">Select Feedback Status*</label>
										</div>
									</div>
								</div>

							</div>
						</div>
						<input type="hidden" name="id" id="internship_id" value="">
						<div class="modal-footer">
							<button type="button" class="btn sec-btn internship-submit">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<!-- Intern Detail Modal -->
		<div class="modal internship-modal" id="intern_detail_modal" role="dialog">

			<div class="modal-dialog modal-dialog-centered modal-lg">

				<div class="modal-content">
					<div class="preloader preloader-2 approve_preloader" style="display: none;">
						<svg class="circular" viewBox="25 25 50 50">
							<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
						</svg>
					</div>
					<div class="modal-header">
						<button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
						<div class="modal_header-content">
							<h4 class="modal-title internformtitle" id="intern_name">Name</h4>
						</div>
					</div>

					<form method="POST" name="internship_form" id="internship_form">
						<div class="modal-body">
							<div class="intern-info">
								<div class="row">
									<div class="col-12">
										<p class="extra-info">
											<strong class="extart-info-title">Contact Number</strong><span>:</span><span id="intern_contact_number"> </span>
										</p>
									</div>
									<div class="col-12">
										<p class="extra-info">
											<strong class="extart-info-title">Email</strong><span>:</span><span id="intern_email"></span>
										</p>
									</div>
									<div class="col-12">
										<p class="extra-info"><strong class="extart-info-title">Address</strong><span>:</span><span id="intern_address"></span></p>
										
									</div>
									<div class="col-12">
										<p class="extra-info"><strong class="extart-info-title">College/University</strong><span>:</span><span id="intern_college_or_university"></span></p>
									</div>
									<div class="col-12">
										<p class="extra-info">
											<strong class="extart-info-title">Internship Course</strong><span>:</span><span id="internship_course"></span>
										</p>
									</div>
									<div class="col-12">
										<p class="extra-info">
											<strong class="extart-info-title">Internship Date</strong><span>:</span><span id="internship_date"></span>
										</p>
									</div>
									<!-- <div class="col-12">
										<p class="extra-info mr-3"><strong class="extart-info-title">Feedback Status</strong><span>:</span><span id="intern_feedback_status"></span></p>
									</div> -->
									<div class="col-12">
										<p class="extra-info"><strong class="extart-info-title">Feedback</strong><span>:</span><span id="intern_feedback"></span></p>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn sec-btn detail-modal-btn" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		

	</script>