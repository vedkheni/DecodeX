<style>
.time-minus{
	color : red;
}
.time-plus{
	color:green;
}
</style>
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
               <!--  <div class="attendance_report">
					<div>
                   		<?php //if(isset($get_employee) && !empty($get_employee)){ ?>
                   		     <h4>Name : <?php // echo $get_employee[0]->fname." ".$get_employee[0]->lname; ?> ( <?php //echo $get_employee[0]->name; ?>)</h4> 
                   		<?php //} ?>
				   </div>
				</div> -->
					
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
			?>
				<form class=" frm-search" method="post" action="<?php echo base_url("bonus/insert_data"); ?>" id="bonus-form">
							<!-- <div class="error_msg"></div> -->
							 <?php 
								//echo "<pre>"; print_r($list_data); echo "</pre>";
							?>
							

                        <!-- </div> -->
                        <div class="col-md-3 _search-form">
                            <div class="col-md-12 emp_">
                              <div class="col-md-6 emp_submit">
                                    <div class="col-md-4 emp_submit">
									
									<?php $current_month=date("m");
										$current_year=date("Y");
										$month_name = date('M', mktime(0, 0, 0, $current_month, 10)); 
									    $file_exists =$_SERVER['DOCUMENT_ROOT'].'/assets/salary_pay/Deposit_'.$month_name.'_'.$current_year.'.txt';
										if(file_exists($file_exists)){ ?>
										<a target="_blank" class="btn sec-btn pull-left emp_search " href="<?php echo base_url().'deposit/txt_file_update'; ?>">View Text File</a>
									<?php }
									?>
								</div>
                              </div>                           
                            </div>
                        </div>
				</form>
				<div id="myModal" class="modal fade salary_modal" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    	<div class="modal-content">
				    	  		<div class="modal-header">
									<button type="button" class="close close_popup" data-dismiss="modal">&times;</button>
									<div class="modal_header col-sm-12">
										<h4 class="modal-title emp_name col-sm-6 employee_name">Tarun Gudala - Designer</h4>
										<p class="control-label col-sm-6 salary-month"></p>
									</div>
								</div>
				    	  		<div class="modal-body">
								  	<div class="salary_main">
										<div class="row">
											<form class="form-horizontal" action="<?php base_url('salary_pay/insert_data'); ?>">
												<input type="hidden" name="emp_id" id="emp_id" value="">
												
												
												<!-- salary -->
												
												<input type="hidden" name="eid" id="eid" value="">
												<!-- end -->
												<!-- leave section -->
												<div class="leave modal-row col-sm-12">
												 <div class="row">
												 	<div class="col-sm-6">
														<h4 class="_heading">Deposit List :</h4>
													</div>
													<div class="col-sm-6">
														<div class="salary deposit-pay col-sm-12">
														
															<div class="">
																<div class="salary-popup">
																	<div class="col-sm-6">
																		<div class="form-group">
																			<p class="control-label col-sm-12 deduction_lable"><span id="per_val"></span>Total Deposit:<span class="salay_details total_deduction_per"> 0</span></p>
																		</div>				
																	</div>
																	
																</div>
															</div>
															<!-- <div class="">
																<div class="salary-popup">
																	<div class="col-sm-4">
																		<div class="form-group">
																			<p class="control-label col-sm-12 ">Net Salary :<span class="salay_details total_net_salary"> 1</span></p>
		                    											</div>				
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<p class="control-label col-sm-12 ">Deduction :<span class="salay_details total_deduction"> 1</span></p>
		                    											</div>				
																	</div>
																</div>
															</div> -->
														</div>
													</div>
												</div>
													<div class="">
												 	<div class="table-responsive box-shadow employee-table-list">
												 		<div class="preloader preloader-2" style="display:none"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>
													<table class="table  display nowrap" id="example_tbl_deposit" style="width:100%">
														<thead>
															<tr>
																<th>#</th>
																<th>Deposit</th>
																<th>Month</th>
																<th>Year</th>
																
															</tr>
														</thead>
														<tbody id="tbl_tbody">
														   
														</tbody>
													</table>
												</div>
											</div>
													
													
												</div>

												<!-- end -->
											</form>

										</div>
									</div>
				    	  		</div>
				    	  		<div class="modal-footer">
									
						  			<button type="button" class="btn btn-default submit  deposit_payment">Submit</button>
									<button type="button" class="btn btn-default close_popup" id="close" data-dismiss="modal">Close</button>
				    	  		</div>
				    	</div>

				  </div>
				</div>
                <div class="table-responsive box-shadow">
				

                    <table class="table  display nowrap" id="example" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Deposit</th>
                                <th>Month</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).on('click', '.deposit_payment_btn', function(){
	var status= $(this).attr("data-status");
		var data = {
				'id': $(this).attr("data-id"),
				'total_deposit': $("#total_deposit").text(),
		};
		$("#eid").val($(this).attr("data-id"));
		var base_url=$("#js_data").attr("data-base-url");
		 $.ajax({
            url: base_url+"deposit/deposit_employee_data",
            type: "post",
            data: data ,
            success: function (response) {
			console.log(response);
			var obj = jQuery.parseJSON(response);
			$(".employee_name").text(obj.employee_name);
			//$(".total_basic_salary").text(obj.salary);
			$(".total_deduction_per").text(obj.salary_deduction);
				var i;
				var text="";
				
				if(obj.deposit_data != "empty"){
					for (i = 0; i < obj.deposit_data.month.length; i++) {
					  text += "<tr><td>"+ (i+1) + "</td>";
					  text += "<td>"+ obj.deposit_data.deposit_amount[i] + "</td>";
					  text += "<td>"+ obj.deposit_data.month[i] + "</td>";
					  text += "<td>"+ obj.deposit_data.year[i] + "</td></tr>";
					}
				}else{
					text +="<tr class='deposit_data_empty'><td console='4' colspan='4'>No data available in table</td></tr>";
				}
				$("#tbl_tbody").html(text);
				
				console.log(status);
				if(status == "Paid"){
					$(".deposit_payment").hide();
				}else{
					$(".deposit_payment").show();
				}
          },

          }); 
});
$(document).on('click', '.deposit_payment', function(){
		$("#eid").val();
		
		$(".total_deduction_per").text();
		var data = {
				'id': $("#eid").val(),
				'total_deposit': $(".total_deduction_per").text(),
				//'salary':$(".total_basic_salary").text(),
		};
		var base_url=$("#js_data").attr("data-base-url");
		 $.ajax({
            url: base_url+"deposit/deposit_insert_data",
            type: "post",
            data: data ,
            success: function (response) {
			console.log(response);
			
          },

          }); 
});
// deposit_payment

$('#bonus').keypress(function(event) {
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
    event.preventDefault();
  }
});
</script>