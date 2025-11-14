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

        <div class="col-sm-4">

        </div>

        <div class="col-sm-4 text-right">

            <h4 class="page-title text-center">Leave Reports</h4> 

        </div>

        <div class="col-sm-4">

            <ol class="breadcrumb">

                <li><a href="#">Reports</a></li>

                <li class="active">Leave Reports</li>

            </ol>

        </div>

        <!-- /.col-lg-12 -->

    </div>

    <!--  from to and dropdown search  -->
<?php 	
		if(isset($search['month']) && isset($search['year'])){
			$current_month=$search['month'];
			$current_year=$search['year'];
		}else{
			$current_month=date('m');
			$current_year=date('Y');
		}
		$m=date('m');
		$y=date('Y');
		$sum=0;
		$sum1=0;
		if(!empty($prof_tax_count)){
			
			if($m == $current_month && $y == $current_year)
			{
				foreach($prof_tax_count as $prof_tax_total){
					$sum+=$prof_tax_total['paid_leave'];
					$sum1+=$prof_tax_total['absent_leave'];
				}
			}else{
				foreach($prof_tax_count as $prof_tax_total){
					$sum+=$prof_tax_total->paid_leave;
					$sum1+=$prof_tax_total->total_leaves;
				}
			}
			
			
		}
	
	?>
    <div class="row">
		<div class="col-md-12">
			<div class="white-box bg-none">
			<form class="form-horizontal form-material frm-search" method="post" action="<?php echo base_url('reports/leave'); ?>" id="bonus-form">
			<div class="_form-search-form">
					<div class="error_msg"></div>
					 <?php 
						
						$csrf = array(
								'name' => $this->security->get_csrf_token_name(),
								'hash' => $this->security->get_csrf_hash()
						);
					?>
					<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
					
					
					<div class="col-lg-4 col-md-6 _search-form">
						 <label>Month:</label>
						 <select class="form-control form-control-line bor-top" id="bonus_month" name="bonus_month" >
							<option value="">Month</option>
							<?php foreach(MONTH_NAME as $k => $v){ ?>
								<option <?php if($current_month == $k+1){ echo "selected='selected'"; } ?> value="<?php echo $k+1; ?>"><?php echo $v; ?></option>
							<?php } ?>
						</select>
						
					</div>
					<div class="col-lg-4 col-md-6 _search-form">
						 <label>Year:</label>
						 <select class="form-control form-control-line bor-top" id="bonus_year" name="bonus_year" >
							<option value="">Year</option>
							<?php
								$next_year=2022;
								for($i=2019;$i<=$next_year;$i++){?>
									<option  <?php if($current_year == $i){ echo "selected='selected'"; }?> value="<?php echo $i;?>"><?php echo $i;?></option>
							<?php } ?>
						</select>
						</div>

				<!-- </div> -->
				<div class="col-lg-4 col-md-6 _search-form">
					<div class="col-md-12 emp_">
						
						<div class="emp_submit">
							<input type="submit"  class="btn btn-primary pull-left emp_search " name="salary_month_search"  value="Search">
						</div>
						<div class="emp_submit">
							<input type="reset" class="btn btn-primary pull-left emp_reset"  value="Reset">
						</div>    
						
					</div>
				</div>
			</div>
		</form>

                
			
                <div class="table-responsive box-shadow">
				<div class="total-sum"><strong>Paid Leaves : <span><?php echo $sum; ?></span></strong></div>
				<div class="total-sum"><strong>Total Leaves: <span><?php echo $sum1; ?></span></strong></div>
					<table id="example" class=" display nowrap" style="width:100%">
						<thead class="_empthead">
							<tr>
								<th></th>
								<th>Name</th>
								<th>Paid Leave</th>
								<th>Total Leaves</th>
						</thead>
						<tbody class="_emptbody">
						</tbody>
					</table>
                </div>

            </div>

        </div>

    </div>

</div>

<!-- login_log_id,employee_id,datetime -->