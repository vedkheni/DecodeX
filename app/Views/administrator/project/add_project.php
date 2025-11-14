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
				<a href="<?php echo base_url('project'); ?>" class="learn-more">
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
            <h4 class="page-title text-center"><?php echo $page_text; ?> Project</h4> </div>
        <div class="col-sm-4">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('project'); ?>">Project</a></li>
                <li class="active"><?php echo $page_text; ?> Project</li>
            </ol>
        </div> 
        <!-- /.col-lg-12-->
    </div>
    
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="white-box bg-none">
                <!-- <div class="frm-search">
                    <h3 class="box-title"><?php echo $page_text; ?> project</h3> 
                    
                </div> -->
                <div class="massge_for_error text-center"><?php echo $this->session->flashdata('message'); ?> </div>
                <form class="form-horizontal form-material box-shadow" method="post" action="<?php echo base_url('project/insert_data'); ?>" id="project-form">
                
                            <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">
                            <?php 
                                $csrf = array(
                                        'name' => $this->security->get_csrf_token_name(),
                                        'hash' => $this->security->get_csrf_hash()
                                );
                            ?>
                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                            <!-- <div class="from-group">
                                <div class="col-sm-12 ">
                                    <a class="btn btn-primary text-center" href="<?php echo base_url('project_task/add'); ?>">Add Task</a>
                                </div>
                                
                            </div> -->
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12">Title</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="Project Title" class="form-control form-control-line" name="title" id="title" value="<?php if(isset($list_data[0]->title)){ echo $list_data[0]->title;} ?>"> </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label class="col-md-12">Client Name</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="Client Name" class="form-control form-control-line" name="client_name" id="client_name" value="<?php if(isset($list_data[0]->client_name)){ echo $list_data[0]->client_name;} ?>"> </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                    <label class="col-md-12">Admin Credential</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control form-control-line textarea" name="admin_credential" id="admin_credential" rows="7"><?php if(isset($list_data[0]->admin_credential)){ echo $list_data[0]->admin_credential;} ?></textarea>
                                     </div>   
                            </div>
                            <div class="form-group">
                                    <label class="col-md-12">Developer Credential</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control form-control-line textarea" id="developer_credential" name="developer_credential" rows="7"><?php if(isset($list_data[0]->developer_credential)){ echo $list_data[0]->developer_credential;} ?></textarea> </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div>
                                        <label >Start Date</label>
                                        <div>
                                            <input type="text" placeholder="" class="form-control form-control-line" name="start_date" id="start_date" value="<?php if(isset($list_data[0]->start_date)){ echo $list_data[0]->start_date;} ?>"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label >End Date</label>
                                        <div>
                                            <input type="text" placeholder="" class="form-control form-control-line" name="end_date" id="end_date" value="<?php if(isset($list_data[0]->end_date)){ echo $list_data[0]->end_date;} ?>"> 
                                        </div>
                                    </div>
                                </div>
                                <?php $dev=array(); 
                                    if(isset($list_data[0]->developer)){ 
                                      $dev=explode(',',$list_data[0]->developer); 
                                    }
                                ?>
                                 <!-- <div class="form-group">
                                    <label class="col-md-12">Developer</label>
                                    <div class="col-md-12">
                                        <select class="form-control form-control-line dropdown-content" multiple="multiple" name="developer[]" id="developer">
                                            
                                            <?php foreach ($get_developer as $key => $value) { ?>
                                                <option <?php if(in_array($value->id,$dev)){ ?> selected="selected" <?php } ?> value="<?php echo $value->id ?>"><?php echo $value->fname." ".$value->lname; ?></option>
                                            <?Php } ?>
                                        </select>   
                                    </div>
                                </div> -->
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                        <label class="col-md-12 select_developer">Select Developer</label>
                                        <select  class="js-states form-control multiple " multiple="multiple" name="developer[]" id="developer">
                                        <?php foreach ($get_developer as $key => $value) { ?>
                                                <option <?php if(in_array($value->id,$dev)){ ?> selected="selected" <?php } ?> value="<?php echo $value->id ?>"><?php echo $value->fname." ".$value->lname; ?></option>
                                            <?Php } ?>
                                        </select>
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
