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
       <!--  <div class="col-sm-4">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('employee'); ?>">Employee</a></li>
                <li class="active">Deposit</li>
            </ol>
        </div> -->
        <!-- /.col-lg-12 -->
    </div>
	<!--  from to and dropdown search  -->
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-7 col-md-8 col-12">
            <div class="white-box space-30 m-0">
			    	<form class="small-form" method="post" action="<?php echo base_url('deposit/insert_data'); ?>" id="deposit-form">
			    		<div class="row">
			    			<!-- <div class="error_msg"></div> -->
			    			<div class="col-12">
								<input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
			    				<input type="hidden" name="deposit_id" id="deposit_id" value="<?php echo (isset($get_deposit[0]->id))?$get_deposit[0]->id:''; ?>" />
			    				<div class="form-group">
			    					<div class="single-field select-field">
			    						<select name="employee_select" id="employee_select">
			    							<option value="" disabled>Select Employee</option>
			    							<?php foreach($employee_list as $emp){ ?>
			    								<option <?php echo (isset($get_employee[0]->id) && $get_employee[0]->id == $emp->id)? 'selected="selected"' : '';?>  data-percentage="<?php echo $emp->salary_deduction ?>" data-salary="<?php echo $emp->salary ?>"  value="<?php echo $emp->id; ?>"><?php echo $emp->fname ." ".$emp->lname; ?></option>
			    							<?php } ?>
			    						</select>
			    						<label>Select Employee*</label>
			    					</div>
			    				</div>
			    			</div>

			    			<div class="col-12">
			    				<input type="hidden" name="salary_deduction_per" id="salary_deduction_per" value="">
			    				<div class="form-group">	
			    					<div class="single-field">
			    						<input type="text" placeholder="Deposit" name="deposit" id="deposit" value="<?php echo (isset($get_deposit[0]->deposit_amount))? $get_deposit[0]->deposit_amount: ''; ?>"> 
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
			    								<option <?php echo (isset($get_deposit[0]->month) && $get_deposit[0]->month == $k+1)? 'selected="selected"' : '';?> value="<?php echo $k+1; ?>"><?php echo $v; ?></option>
			    							<?php } ?>
			    						</select>
			    						<label>Select Month*</label>
			    					</div>
			    				</div>
			    			</div>

			    			<div class="col-md-12">
			    				<div class="form-group">	
			    					<div class="single-field select-field">
			    						<select id="deposit_year" name="deposit_year" >
			    							<option value="" disabled>Select Year</option>
			    							<?php
			    							$next_year=date('Y',strtotime('+1 year'));
			    							for($i=2018;$i<=$next_year;$i++){?>
			    								<option <?php echo (isset($get_deposit[0]->year) && $get_deposit[0]->year == $i)? 'selected="selected"' : '';?> value="<?php echo $i;?>"><?php echo $i;?></option>
			    							<?php } ?>
			    						</select>
			    						<label>Select Year*</label>
			    					</div>
			    				</div>	
			    			</div>	

			    			<div class="col-6 form_submit">
								<div class="emp_ float-left">
									<div class="emp_submit">
										<input type="reset" class="btn btn-danger emp_reset" value="Reset">
									</div>                           
								</div>
							</div>
			    			<div class="col-6 form_submit">
								<div class="emp_ float-right">
									<div class="emp_submit">
										<input type="submit" class="btn sec-btn emp_search" value="Submit">
									</div>
								</div>
							</div>

			    		</div>
			    	</form>
            </div>
        </div>
    </div>		
</div>
<script type="text/javascript">
$(document).on('change', '#employee_select', function(){
	var base_url=$("#js_data").attr("data-base-url");
	var id=$(this).val();
	var percentage=$(this).find(':selected').attr('data-percentage');
	var salary=$(this).find(':selected').attr('data-salary');
	var total=(salary * percentage)/ 100
	//console.log(salary +" - "+percentage+" "+id);
	$("#salary_deduction_per").val(percentage);
	$("#deposit").val(total);
});
$('#deposit').keypress(function(event) {
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
    event.preventDefault();
  }
});
</script>