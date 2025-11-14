<div id="page-wrapper">

<div class="container-fluid">

    <div class="row bg-title">
        <div class="col-sm-4">
            <h4 class="page-title back-btn">
                <!-- <a href="<?php echo base_url('employee'); ?>">
                <i class="fa fa-long-arrow-left" aria-hidden="true" style="font-size:19px"></i>&nbsp;&nbsp;&nbsp;&nbsp;Back
                </a> -->
                <button class="learn-more">
                    <div class="circle">
                      <span class="icon arrow"></span>
                    </div>
                    <a href="<?php echo base_url('project_task'); ?>" class="button-text">                
                            Back
                    </a>
                </button>
            </h4> 
        </div>
        <div class="col-sm-4 text-right">
                <h4 class="page-title text-center">2019 Salary Slip</h4> </div>4> 
        </div>
        <div class="col-sm-4">
            <ol class="breadcrumb">

                <li>
                    <a href="dashboard">Dashboard</a>
                </li>

                <li class="active">2019 Salary Slip</li>

            </ol>
        </div>
        <!-- /.col-lg-12 -->

    </div>

    <!--  from to and dropdown search  -->

    <div class="row">

<?php   

   

    /* function seconds($seconds) {

        // CONVERT TO HH:MM:SS

        $hours = floor($seconds/3600);

        $remainder_1 = ($seconds % 3600);

        $minutes = floor($remainder_1 / 60);

        $seconds = ($remainder_1 % 60);

        if(strlen($hours) == 1) {

            $hours = "0".$hours;

        }

        if(strlen($minutes) == 1) {

            $minutes = "0".$minutes;

        }

        if(strlen($seconds) == 1) {

            $seconds = "0".$seconds;

        }

        return $hours." Hours ".$minutes." Minutes";

    }



        $in=array_filter(explode(',',$employee_attendance_list[0]->employee_attendance_in));

        $out=array_filter(explode(',',$employee_attendance_list[0]->employee_attendance_out));

        $arr = $att_date =array();

        if($employee_attendance_list[0]->employee_attendance_in){

            

            $i=0;

            if(!empty($in)){

                foreach ($in as $k => $v) {

                    $datein=date_create($v);

                    $in_date= date_format($datein,"Y-m-d");

                    $dateout=date_create(isset($out[$k]) ? $out[$k] : "");

                    $out_date= date_format($dateout,"Y-m-d");

                    if($in_date == $out_date){



                        $arr[$in_date]['in'][]=$newDateTime = date('h:i A', strtotime($v));

                        $arr[$in_date]['out'][]=isset($out[$k]) ? date('h:i A', strtotime($out[$k])) : "";



                        $date1Timestamp = strtotime($v);

                        $date2Timestamp = strtotime(isset($out[$k]) ? $out[$k] : "");

                        $seconds1=(isset($out[$k]) && !empty($out[$k])) ?  $date2Timestamp - $date1Timestamp : "0";

                        $arr[$in_date]['seconds'][]=$seconds1;

                        $att_date[]=$in_date;

                        $i++;

                    }

                }

            }

        } */



       // echo "<pre>";print_r($in);print_r($out);echo "</pre>";

    ?>

    <?php $user_role=$this->session->userdata('user_role'); 

       // echo "<pre>"; print_r($search); echo "</pre>";

    ?>



        <div class="col-md-12">

            <div class="white-box">

			

				<!-- <h3 class="box-title">Employees Salary Slip</h3>  -->

			<form class="form-horizontal form-material" method="post" action="<?php echo base_url('salary_slip/download'); ?>" id="salary-slip-form">

                    <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">

 <?php 

                        $csrf = array(

                                'name' => $this->security->get_csrf_token_name(),

                                'hash' => $this->security->get_csrf_hash()

                        );

                    ?>

			<?php 

				$current_year="";

				$joining_year="";

					

						if(isset($employee_details)){

							$joining_year=(int)date("Y",strtotime($employee_details[0]->joining_date));

						//	echo "joining date".date("Y",$joining_year);

							$current_year=(int)date("Y");

							//echo $current_year;

						?>

						<select name="select_year" class="form-control form-control-line">

							<?php for($i=$current_year;$i>=$joining_year;$i--){

								?>

								<option value="<?php echo $i;?>"><?php echo $i;?></option>

								<?php

							}?>

						</select>

                

            <?php 		}

					

					//else{ ?>

						<?php //} ?>

               <!--  <form class="form-horizontal form-material" method="post" action="" id="search-form">

    

                        <div class="error_msg"></div>

                        

                   

                        <div class="col-md-3">

                            <label>To Date</label>

                            <input type="date" placeholder="To Date" class="form-control form-control-line" name="to_date" id="to_date" value="<?php if(isset($search['to_date'])){ echo $search['to_date']; } ?>"> 

                        </div>

                   

                    

                        <div class="col-md-3">

                            <label>Search By</label>

                            <select name="search_dropdwon" id="search_dropdwon" class="form-control form-control-line">

                                <option></option>

                                <option <?php if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 1){ ?> selected="selected" <?php }else{ ?> selected="selected" <?php } ?> value="1">Today</option>

                                <option <?php if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 2){ ?> selected="selected" <?php } ?> value="2">Yesterday</option>

                                <option <?php if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 3){ ?> selected="selected" <?php } ?> value="3">Last Week</option>

                                <option <?php if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 4){ ?> selected="selected" <?php } ?> value="4">Last Month</option>

                                <option  <?php if(isset($search['search_dropdwon']) && $search['search_dropdwon'] == 5){ ?> selected="selected" <?php } ?> value="5">6 Month</option>

                            </select> 

                        </div>

                 

                    <div class="form-group">

                    <div class="col-md-12">

                           

                            <input type="submit" placeholder="To Date" class="btn sec-btn pull-left"  value="Search"> &nbsp &nbsp&nbsp&nbsp

                             <a  href="" class="btn sec-btn">Reset</a>

                        </div>

                    </div>

                </form>-->

                <br>

                <br>

				<?php //echo "<pre/>";

				//print_r($employee_details);?>

                <div class="table-responsive">

                    <table class="table employee_attendance" id="datatable">

                        <thead>

                            <tr>

                                <th>Sr. No.</th>

                                <th>Month</th>

                                <th>Action</th>

                            </tr>

                        </thead>

                        <tbody>

                           <?php 

							$i=1;

						   ?> 

                            <tr>

                                <td><?php echo $i; ?></td>

                                <td>

									<select name="select_year" class="form-control form-control-line">

										<?php foreach(MONTH_NAME as $month_name){

											?>

											<option value="<?php echo $month_name;?>"><?php echo $month_name;?></option>

											<?php

										}?>

									</select>

								</td>

                                <td>  <a   href="<?php echo base_url('profile/download_salary_slip'); ?>" class="btn btn-success">Download</a></td>

                            </tr>

                            <?php ?>

                            

                        </tbody>

                    </table>

                </div>

				</form>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">

    



    

</script>