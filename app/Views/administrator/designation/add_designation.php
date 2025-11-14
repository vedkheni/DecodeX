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
				<a href="<?php echo base_url('designation'); ?>" class="learn-more">
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
            <h4 class="page-title text-center"><?php echo $page_text; ?> Designation</h4> </div>
        <div class="col-sm-4">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('designation'); ?>">Designation</a></li>
                <li class="active"><?php echo $page_text; ?> Designation</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="white-box">
                <div class="massge_for_error text-center"><?php echo $this->session->flashdata('message'); ?> </div>
                 <form class="form-horizontal form-material" method="post" action="<?php echo base_url('designation/insert_data'); ?>" id="designation-form">
                    <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">
                    <?php 
                        $csrf = array(
                                'name' => $this->security->get_csrf_token_name(),
                                'hash' => $this->security->get_csrf_hash()
                        );
                    ?>
                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                <div class="form-group">
                                    <label class="col-md-12">Name</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="" class="form-control form-control-line" name="designation" id="designation" value="<?php if(isset($list_data[0]->name)){ echo $list_data[0]->name;} ?>"> </div>
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
