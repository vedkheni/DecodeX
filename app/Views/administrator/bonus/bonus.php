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
		<!-- <div class="col-sm-4">
            <h4 class="page-title back-btn">
                <a href="#" class="learn-more">
                    <div class="circle">
                      <span class="icon arrow"></span>
                    </div>
                    <p  class="button-text">                
                            Back
					</p>
                </a>
            </h4> 
        </div> -->
        <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title">Bonus</h4> 
        </div>
        <!-- <div class="col-sm-4">
            <ol class="breadcrumb">
                <li><a href="<?php // echo base_url('employee'); ?>">Employee</a></li>
                <li class="active"> Bonus</li>
            </ol>
        </div> -->
        <!-- /.col-lg-12 -->
    </div>
	<!--  from to and dropdown search  -->
    <div class="row">
        <div class="col-md-12">
            <div class="white-box m-0">
            	<div class="custom-emp-field">
               		<div class="row">
				
				<?php 	$user_role=$this->session->get('user_role');
					if($user_role == 'admin'){ ?>
				<div class="col-xl-8 col-12 text-center text-xl-left ">
					<!-- form tag unusual class form-horizontal form-material -->
					<form class="frm-search bonus-search-form" method="post" action="<?php echo base_url("bonus"); ?>" id="bonus-form">
								
							<input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
							
                            
	                            <div class="single-field select-field multi-field _search-form">
									<select class="emp_search1" id="employee_id" name="employee_id" >
										<?php foreach($get_employee_list as $n => $name){ ?>
											<option <?php if(isset($employee_id) && !empty($employee_id) && $employee_id == $name->id){ echo "selected='selected'"; } ?> value="<?php echo $name->id; ?>"><?php echo $name->fname." ".$name->lname; ?></option>
										<?php } ?>
									</select>
									<label>Select Employee</label>
								</div>
								

	                            <div class="single-field select-field multi-field _search-form">
									<select class="emp_search1" id="select_year" name="select_year" >
										<option <?php if(isset($select_year) && !empty($select_year) && $select_year == "all"){ echo "selected='selected'"; } ?> value="all">All Year</option>
										<?php
											$next_year=date('Y',strtotime('+2 year'));
											for($i=2018;$i<=$next_year;$i++){?>
										<option   <?php if(isset($select_year) && !empty($select_year) && $select_year == $i){ echo "selected='selected'"; } ?> value="<?php echo $i;?>"><?php echo $i;?></option>
										<?php } ?>
									</select>
									<label>Select Year</label>
								</div>
							<!-- <div class="col-md-6 _search-form">
								<div class="col-md-12 emp_ p-0">
									<div class="emp_submit">
										<input type="submit"  class="btn btn-primary pull-left emp_search"  value="Submit">
									</div>
									<div class="emp_submit">
										<input type="reset" class="btn btn-grey btn-primary pull-left emp_reset"  value="Reset">
									</div>                           

								</div>
							</div> -->
					</form>
				</div>
					<?php	}
						$bonus=0;
						if(isset($get_employee_total_bonus) && !empty($get_employee_total_bonus)){
							$bonus=0;
							if(!empty($get_employee_total_bonus[0]->total_bonus)){
								$bonus=$get_employee_total_bonus[0]->total_bonus;
							}
						}
					?>
				<?php if($user_role == 'admin'){ ?>
					<div class="col-xl-4 col-12 text-center text-xl-right ">
		                  <h4>Total Bonus : <span class="blue-text t-bonus"><?php echo $bonus; ?></span></h4> 
					</div>
				<?php }else{ ?>
					<div class="col-12">
						<h4 class="text-center m-0">Total Bonus : <span class="blue-text t-bonus"><?php echo $bonus; ?></span></h4>
					</div>	
				<?php } ?>
				
				</div>

				<hr class="custom-hr">
				</div>


                <div class="table-responsive box-shadow employee-table-list">
                	<div class="preloader preloader-2" style="display:none"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>
                    <table class="table  display nowrap" id="example" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bonus</th>
                                <th>Month</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$('#bonus').keypress(function(event) {
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
    event.preventDefault();
  }
});
</script>