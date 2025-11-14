<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-12 col-md-12 col-xs-12">
                <div class="page-title-btn">
    				<a href="<?php echo base_url('profile'); ?>" class="btn sec-btn back-btn">
    	            	<i class="fas fa-chevron-left"></i>
    	                <span>Back</span>
    	            </a>
    				<h4 class="page-title text-center"><?php echo date('Y').' Salary Slip';?></h4>
                </div>
			</div>
    	<!-- <div class="col-sm-4">
    		<ol class="breadcrumb">
    			<li class="active"><?php echo date('Y').' Salary Slip';?></li>
    		</ol>
    	</div> -->
    	<!-- /.col-lg-12 -->
    </div>
    <!--  from to and dropdown search  -->
    <div class="row justify-content-center">

    	<?php $user_role=$this->session->get('user_role'); 
    	?>
    	<div class="col-12 col-md-10 col-lg-8 col-xl-6">
    		<div class="white-box salary_slip m-0">

    			<!-- <h3 class="box-title text-center">Employees Salary Slip</h3>  -->
    			<!-- <form name="salary_slip_form" id="salary-slip-form" method="post" action="<?php echo base_url('salary_slip/calculate_slip'); ?>" id="salary-slip-form"> -->
    				<div class="massge_for_error text-center"><?php echo $this->session->getFlashdata('message'); ?> </div>
    				<input type="hidden" name="e_id" id="e_id" value="<?php echo $this->session->get('id'); ?>">
    				<input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
    				<?php 
    				$current_year="";
    				$joining_year="";
                    // echo '<pre>';print_r($employee_details);echo'</pre>';
    				if(isset($employee_details)){
    					$joining_year=(int)date("Y",strtotime($employee_details[0]->joining_date));
						//	echo "joining date".date("Y",$joining_year);
    					$current_year=(int)date("Y");
    					$current_month=(int)date("n");
    					$current_day=(int)date("j");
    					$joining_month_number=date("n",strtotime($employee_details[0]->joining_date));
    					$joining_month=date("F",strtotime($employee_details[0]->joining_date));
    					$joining_year=date("Y",strtotime($employee_details[0]->joining_date));
    					$selected_data=$this->session->getFlashdata('message1');

    					?>
    					<div class="row">
    						<div class="col-12 text-center">
		    					<div class="single-field select-field multi-field m-0">
			    					<select name="select_year" id="select-year" data-current-year="<?php echo $current_year;?>" data-current-month="<?php echo $current_month;?>" style="display:inline-block"> 
			    						<?php for($i=$current_year;$i>=$joining_year;$i--){
			    							?>
			    							<option value="<?php echo $i;?>" <?php if(isset($selected_data) && ($i)==$selected_data['year']) echo "selected";?>><?php echo $i;?></option>
			    							<?php
			    						}?>
			    					</select>
                                    <label>Select Year</label>
		    					</div>
    						</div>
    					</div>
    				<?php 		}?>
    				<hr class="custom-hr">
    				<div class="table-responsive">
    					<table class="table employee_attendance dataTable" id="datatable">
    						<thead>
    							<tr>
    								<th>Sr. No.</th>
    								<th>Month</th>
    								<th>Action</th>
    							</tr>
    						</thead>
    						<tbody id="t_body">
    							<?php 
    							$i=1;
    							?> 
    							<!-- <tr>
    								<td><?php echo $i; ?></td>
    								<td>
    									<select name="select_month" id="select-month" class="form-control form-control-line" data-month-digit="<?php echo $joining_month_number;?>" data-year="<?php echo $joining_year;?>" data-current-day="<?php echo $current_day;?>">
    										<?php 

    										?>
    										<?php foreach(MONTH_NAME as $key=>$month_name){
    											if(($key+1)>=$current_month){

    												break;
    											}
    											if($current_day<=10){

    												break;
    											}
    											?>
    											<option value="<?php echo $key+1;?>" <?php if(isset($selected_data) && ($key+1)==$selected_data['month']) echo "selected";?>><?php echo $month_name;?></option>
    											<?php
    											$i++;
    										}?>
    									</select>
    								</td>
    								<td><button class="btn sec-btn submit_form">Download</button></td>
    							</tr> -->
    							<?php ?>

    						</tbody>
    					</table>
    				</div>
    			<!-- </form> -->
    		</div>
    	</div>
    </div>
</div>
<!-- <form name="salary_slip_form" id="salary-slip-form" method="post" action="<?php echo base_url('salary_slip/calculate_slip'); ?>" id="salary-slip-form">
    <input type="hidden" name="select_month" id="select_month" value="">
    <input type="hidden" name="select_year" id="select_year" value="">
</form> -->
<script type="text/javascript">
    $(document).ready(function(){
        emp_salary_detail();    
    })
	$('#select-year').change(function(){
		emp_salary_detail();
        // var month_array='<?php echo json_encode(MONTH_NAME)?>';
		// var month_decod=$.parseJSON(month_array);
		// var selected_year = $('#select-year option:selected').val();
		// var current_year = $('#select-year').data('current-year');
		// var current_month = $('#select-year').data('current-month');
		// var month_key = $('#select-month option:selected').val();
		// var month_digit=$('#select-month').data('month-digit');
		// var day_digit=$('#select-month').data('current-day');
		// var join_year=$('#select-month').data('year');
		// var key=parseInt(month_key);
		// var options="";
		// $.each(month_decod, function( index, value ) {
		// 	if((index+1)<=month_digit && selected_year==join_year){
		// 		return true;
				
		// 	}
		// 	if((index+1)>=current_month && selected_year==current_year && day_digit>=10){
		// 		return false;
		// 	} 
		// 	options+='<option value="'+(index+1)+'">'+value+'</option>';
		// });
		// $('#select-month').html(options);
		
	});  

    function emp_salary_detail(){
         var base_url=$("#js_data").data('base-url');
         var data = { 'select_year': $('#select-year option:selected').val()};
          $.ajax({
            url: base_url+"profile/emp_salary_detail",
            type: "post",
            data: data ,
            success: function (response) {
                var obj = JSON.parse(response);
                var html = '';
                $.each(obj.emp_salary_month,function(i,v){
                    html += '<tr><td>'+(i+1)+'</td><td><span name="select_month" id="select-month" class="" >'+v+'</span></td><td><a href="'+base_url+'salary_slip/salary_slip_download/'+$('#e_id').val()+'/'+obj.salary_month_num[i]+'/'+$('#select-year option:selected').val()+'" class="btn sec-btn submit_form">Download</a></td></tr>';
                    // html += '<tr><td>'+(i+1)+'</td><td><span name="select_month" id="select-month" class="" >'+v+'</span></td><td><button class="btn sec-btn submit_form" onclick="submit_form('+$('#select-year option:selected').val()+','+obj.salary_month_num[i]+');">Download</button></td></tr>';
                });
                $('.page-title.text-center').html($('#select-year option:selected').val()+' Salary Slip');
              $('#t_body').html(html);  
            },
         });
    }
    // function submit_form(select_year,select_month){
    //      var base_url=$("#js_data").data('base-url');
    //      $('#select_month').val(select_month);
    //      $('#select_year').val(select_year);
    //      $('#salary-slip-form').submit();
    // }
</script>