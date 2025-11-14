<?php $user_role=$this->session->get('user_role'); ?>
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title">Calendar</h4>
        </div>
         <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li class="active">Holiday</li>
            </ol>
        </div> --> 
        <!-- /.col-lg-12 -->
		
    </div>
    <div class="row">
        <div class="col-12">
            <?php if($user_role == 'admin'){ ?>
            <div class="text-center m-b-30">
                <a class="btn sec-btn add_new_holiday" href="<?php echo base_url('holiday/add'); ?>">Add New Holiday</a>
            </div>
            <?php } ?>
        </div>
        <div class="col-md-12">
            <?php
			$holiday="";
			if(isset($holiday_all) && !empty($holiday_all)){
				$holiday=json_encode($holiday_all);
			}
			?>
			<div class="white-box calendar" id="calendar" data-provide="calendar" data-holiday-date='<?php echo $holiday; ?>'>
			
            </div>
        </div>
    </div>
</div>
