<?php 
    $page_text="Add";
    if(isset($list_data[0]->id) && !empty($list_data[0]->id)){ 
        $page_text="Update";
    }else{
        $page_text="Add";
    }
?>
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-sm-4">
            <h4 class="page-title back-btn">
                <!-- <a href="<?php echo base_url('employee'); ?>">
                <i class="fa fa-long-arrow-left" aria-hidden="true" style="font-size:19px"></i>&nbsp;&nbsp;&nbsp;&nbsp;Back
                </a> -->
				<a href="<?php echo base_url('leave_request'); ?>" class="learn-more">
                    <div class="circle">
                      <span class="icon arrow"></span>
                    </div>
                    <p  class="button-text">                
                            Back
					</p>
                </a>
               
            </h4> 
        </div>
        <div class="col-sm-4 text-right">
            <h4 class="page-title text-center"><?php echo $page_text; ?> Leave Request</h4> </div>
        <div class="col-sm-4">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('leave_request'); ?>">Leave Request</a></li>
                <li class="active"><?php echo $page_text; ?> Leave Request</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="white-box">
                <div class="massge_for_error text-center"><?php echo $this->session->flashdata('message'); ?> </div>
                 <form class="form-horizontal form-material" method="post" action="<?php echo base_url('leave_request/insert_data'); ?>" id="leave-form">
                    <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">
                    <?php 
                        $csrf = array(
                                'name' => $this->security->get_csrf_token_name(),
                                'hash' => $this->security->get_csrf_hash()
                        );
                    ?>
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                <div class="form-group">
                                    <label class="col-md-12">Select Leave Date*</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="" class="form-control form-control-line" name="leave_date" id="leave_date" value="<?php if(isset($list_data[0]->leave_date)){ echo $list_data[0]->leave_date;} ?>"> </div>
                                </div>
								<div class="form-group">
                                    <label class="col-md-12">Leave Status</label>
                                    <div class="col-md-12">
                                        <input type="radio" <?php if(isset($list_data[0]->leave_status) && !empty($list_data[0]->leave_status) && $list_data[0]->leave_status == 'none'){ echo 'checked="checked"'; }else{ echo 'checked="checked"'; } ?>   class="" name="leave_status" id="leave_status" value="none"> None &nbsp&nbsp&nbsp
										<input type="radio"  <?php if(isset($list_data[0]->leave_status) && $list_data[0]->leave_status == 'paid'){ echo 'checked="checked"'; } ?> class="" name="leave_status" id="leave_status" value="paid"> Paid Leave &nbsp&nbsp&nbsp
										<input type="radio" <?php if(isset($list_data[0]->leave_status) && $list_data[0]->leave_status == 'sick'){ echo 'checked="checked"'; } ?>  class="" name="leave_status" id="leave_status" value="sick"> Sick Leave
									</div>
                                </div>
								<div class="form-group">
                                    <label class="col-md-12">Leave Comment</label>
                                    <div class="col-md-12">
										<textarea class="form-control form-control-line" name="leave_commet" id="leave_commet" rows="5"><?php if(isset($list_data[0]->comment)){ echo $list_data[0]->comment;} ?></textarea>
                                     </div>
                                </div>
								
                            <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success submit_form"><?php echo $page_text; ?></button>
                                    </div>
                                </div>
                            </form>
            </div>
        </div>
		<div class="col-md-2"></div>
    </div>
</div>
