<div id="page-wrapper">
	
<div class="container-fluid">

    <div class="row bg-title">
        <div class="col-sm-4">
            <h4 class="page-title back-btn">
                <!-- <a href="<?php echo base_url('employee'); ?>">
                <i class="fa fa-long-arrow-left" aria-hidden="true" style="font-size:19px"></i>&nbsp;&nbsp;&nbsp;&nbsp;Back
                </a> -->
				<a href="<?php echo base_url('project_task'); ?>" class="learn-more">
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
            <h4 class="page-title text-center">Add Task</h4> 
        </div>
        <div class="col-sm-4">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('project_task'); ?>">Task</a></li>
                <li class="active">Add Task</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->

    </div>

	

    <?php $user_role=$this->session->userdata('user_role'); ?>

    <div class="row">

        <div class="col-md-12">
        <div class="col-md-2"></div>
            <div class="col-md-8 white-box add-task">
                
                <div class="massge_for_error text-center"><?php echo $this->session->flashdata('message'); ?> </div>

                 <form class="form-horizontal form-material" method="post" action="<?php echo base_url('project_task/insert_data'); ?>" id="project-task-form-admin" enctype="multipart/form-data">

                    <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">

                            <?php $dev=array(); 

                                        if(isset($list_data[0]->developer)){ 

                                          $dev=explode(',',$list_data[0]->developer); 

                                        }

                                    ?>

                    <?php 

                        $csrf = array(

                                'name' => $this->security->get_csrf_token_name(),

                                'hash' => $this->security->get_csrf_hash()

                        );

                    ?>

                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                                <div class="form-group">

                                   

                                    <div class="col-md-6">

                                         <label >Project</label>

                                         <select class="form-control form-control-line" name="project" id="project">

                                            <option>Select Project</option>

                                            <?php foreach ($get_project as $key => $p) { ?>

                                               <option <?php if(isset($list_data[0]->project_id)) {if($list_data[0]->project_id == $p->id){ ?> selected="selected" <?php }} ?> value="<?php echo $p->id; ?>"><?php echo $p->title; ?></option>

                                            <?php } ?>

                                         </select>

                                     </div>

                                     <div class="col-md-6">
                                        <div class="">
                                            <label class="col-md-12 select_developer">Select Developer</label>
                                            <select name="developer[]" class="js-states form-control multiple" multiple id="developer">
                                            <?php foreach ($get_developer as $key => $value) { ?>
                                                    <option <?php if(in_array($value->id,$dev)){ ?> selected="selected" <?php } ?> value="<?php echo $value->id ?>"><?php echo $value->fname." ".$value->lname; ?></option>
                                                <?Php } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">

                                    <label class="col-md-12">Title</label>

                                    <div class="col-md-12">

                                        <input type="text" placeholder="Project Title" class="form-control form-control-line" name="title" id="title" value="<?php if(isset($list_data[0]->title)){ echo $list_data[0]->title;} ?>"> </div>

                                </div>

                                 <div class="form-group">

                                    <label class="col-md-12">Details</label>

                                    <div class="col-md-12">

                                         <textarea class="form-control form-control-line" name="description" id="description"> <?php if(isset($list_data[0]->description)){ echo $list_data[0]->description;} ?></textarea></textarea>

                                        <script>

                                                CKEDITOR.replace( 'description' );

                                        </script>

                                       

                                        </div>

                                </div>

                                <?php 

                                $hours = $minute = "";

                                if(isset($list_data[0]->minute)){

                                   $minutes=$list_data[0]->minute;

                                   $hours = floor($minutes / 60);

                                   $minute=($minutes -   floor($minutes / 60) * 60);

                                }

                                ?>

                                <div class="form-group">

                                    <div class="col-md-6">

                                      <label>Hour</label>

                                        <input type="number" name="hour" class="form-control form-control-line" id="hour" min="0" max="24" value="<?php echo $hours; ?>">

                                    </div>

                                    <div class="col-md-6">

                                    <label>Minute</label>

                                        <input type="number" name="minute" class="form-control form-control-line" id="minute" min="0" max="60" value="<?php echo $minute; ?>">

                                    </div>   

                                </div>

                                 

                                <div class="form-group">

                                    <div class="col-md-6">

                                        <label>Deadline</label>

                                         <input type="date" name="deadline" class="form-control form-control-line" id="deadline" value="<?php if(isset($list_data[0]->deadline_date)) { echo $list_data[0]->deadline_date; } ?>">

                                    </div>

                                    <div class="col-md-6">

                                        <label>Priority</label>

                                        <select class="form-control form-control-line" name="priority" id="priority">

                                            <option <?php if(isset($list_data[0]->priority) && $list_data[0]->priority == 'low'){ ?> selected="selected" <?php } ?> value="low">Low</option>

                                            <option <?php if(isset($list_data[0]->priority) && $list_data[0]->priority == 'normal'){ ?> selected="selected" <?php } ?> value="normal">Normal</option>

                                            <option <?php if(isset($list_data[0]->priority) && $list_data[0]->priority == 'high'){ ?> selected="selected" <?php } ?> value="high">High</option>

                                            <option <?php if(isset($list_data[0]->priority) && $list_data[0]->priority == 'critical'){ ?> selected="selected" <?php } ?> value="critical">Critical</option>

                                        </select>

                                    </div>

                                </div>

                                

                                <div class="form-group">

                                    <div class="col-md-6">

                                        <label>Type</label>

                                        <select class="form-control form-control-line" name="type" id="type">

                                            <option <?php if(isset($list_data[0]->priority) && $list_data[0]->priority == 'bug'){ ?> selected="selected" <?php } ?> value="bug">Bug</option>

                                            <option <?php if(isset($list_data[0]->priority) && $list_data[0]->priority == 'task'){ ?> selected="selected" <?php } ?> value="task">Task</option>

                                       </select>

                                    </div>

                                    <div class="col-md-6">

									

                                        <label>Status</label>

                                        <select class="form-control form-control-line" name="status"

                                         id="status">

                                            <option <?php if(isset($list_data[0]->priority) && $list_data[0]->priority == 'pending'){ ?> selected="selected" <?php } ?> value="pending">Pending</option>

                                            <option <?php if(isset($list_data[0]->priority) && $list_data[0]->priority == 'in development'){ ?> selected="selected" <?php } ?> value="in development">In Development</option>

                                            <option <?php if(isset($list_data[0]->priority) && $list_data[0]->priority == 'task'){ ?> selected="selected" <?php } ?> value="testing">Testing</option>

                                              <option <?php if(isset($list_data[0]->priority) && $list_data[0]->priority == 'review'){ ?> selected="selected" <?php } ?> value="review">Review</option>

                                            <option <?php if(isset($list_data[0]->priority) && $list_data[0]->priority == 'complete'){ ?> selected="selected" <?php } ?> value="complete">Complete</option>

                                        </select>

                                    </div>

                                </div>

								<!-- <div class="form-group">

                                    <div class="col-md-5">

                                        <label>Tags</label>

										 <textarea rows="4" cols="50" name="tag" id="tag" class="form-control form-control-line"><?php if(isset($list_data[0]->task_tag)) { echo $list_data[0]->task_tag; } ?></textarea>

										 	<input type="text" name="tag" class="form-control form-control-line" id="tag">

											<input type="hidden" name="json_tag" class="form-control form-control-line" id="json_tag" value='<?php if(isset($list_data[0]->task_tag)){ echo $list_data[0]->task_tag; }?>'>

											

                                    </div>

									<div class="col-md-1">

										<div id="button" class="addtag">Add</div>

									</div>

                                    <div class="col-md-5">

                                        <label>Bugs</label>

										<textarea rows="4" cols="50" name="bugs" id="bugs" class="form-control form-control-line"><?php if(isset($list_data[0]->task_bug)) { echo $list_data[0]->task_bug; } ?></textarea>

										<input type="text" name="bugs" class="form-control form-control-line" id="bugs" >

										<input type="hidden" name="json_bug" class="form-control form-control-line" id="json_bug" value='<?php if(isset($list_data[0]->task_bug)){ echo $list_data[0]->task_bug; }?>'>

									</div>

									<div class="col-md-1">

										<div id="button" class="addbug">Add</div>

									</div>

                                </div> -->

                                <div class="form-group">

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-xs-8">
                                                <label>Tags</label>
                                            </div>
                                            <div class="col-xs-4 btn-right">
                                                <div id="button" class="addtag">Add</div>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" name="tag" class="form-control form-control-line" id="tag">

                                                <input type="hidden" name="json_tag" class="form-control form-control-line" id="json_tag" value='<?php if(isset($list_data[0]->task_tag)){ echo $list_data[0]->task_tag; }?>'>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-xs-8">
                                                <label>Bugs</label>
                                            </div>
                                            <div class="col-xs-4 btn-right">
                                                <div id="button" class="addbug">Add</div>
                                            </div>
                                            <div class="col-md-12">

                                                <input type="text" name="bugs" class="form-control form-control-line" id="bugs" >

                                                <input type="hidden" name="json_bug" class="form-control form-control-line" id="json_bug" value='<?php if(isset($list_data[0]->task_bug)){ echo $list_data[0]->task_bug; }?>'>
                                            </div>
                                        </div>
                                    </div>
                                </div>

								<div class="form-group">

                                    <div class="col-md-6">

                                        <ol class="tag-ol">

										<?php

										if((isset($list_data[0]->task_tag))&&!empty($list_data[0]->task_tag))

										{

											$tag_data = json_decode($list_data[0]->task_tag);

											

											if(!empty($tag_data))

											{

												foreach($tag_data as $value)

												{

													echo '<li>'.$value.'<i class="fa fa-close close close-tag" aria-hidden="true"></i></li>';

												}

											}

										}

										?>

										</ol>

                                    </div>

									<div class="col-md-6">

                                        <ol class="bug-ol">

										<?php

										if((isset($list_data[0]->task_bug))&&!empty($list_data[0]->task_bug))

										{

											//print_r($list_data[0]->task_bug);

											$bug_data = json_decode($list_data[0]->task_bug);

											if(!empty($bug_data))

											{

												foreach($bug_data as $value)

												{

													echo '<li>'.$value.'<i class="fa fa-close close close-tag" aria-hidden="true"></i></li>';

												}

											}

										}

										?>

										</ol>

                                    </div>

      

                                </div>

								<div class="form-group">

                                    <div class="col-md-12">

                                        <label>Reminder</label>

										 <input type="checkbox" name="reminder" id="reminder" value="yes" <?php if(isset($list_data[0]->reminder_message) && $list_data[0]->reminder_message == '1') { echo 'checked'; }?>>

                                    </div>

                                </div>

                                <?php 

                                  $url = base_url().'assets/attachments';

                                ?>

                                <div class="form-group">

                                    <label class="col-md-12">Attachments</label>

                                    <div class="col-md-6">

                                        <!-- <input type="file" name="attachments" class="form-control" id="attachments" > -->
                                        <div class="file-upload">
                                            <div class="file-select">
                                                <div class="file-select-button" id="fileName">Choose File</div>
                                                <div class="file-select-name" id="noFile">No file chosen...</div> 
                                                <input type="file" name="attachments" class="attachments" id="attachments">
                                            </div>
                                        </div>
                                        

                                    </div>
									<?php 
									if(isset($list_data[0]->attachments) && !empty($list_data[0]->attachments)){
										$attachment=$list_data[0]->attachments;
										$extension = pathinfo($attachment,PATHINFO_EXTENSION);
										$img_ext=array("jpg","bmp","gif","png","jpeg");
										if(in_array($extension,$img_ext)){
										?>
											<div class="col-md-2 attached-image-container">
												<img src="<?php echo $url.'/'.$list_data[0]->attachments; ?>" class="attached-image">
											</div>
									<?php }?>
                                     <div class="col-md-4">
										<a download href="<?php echo $url.'/'.$list_data[0]->attachments; ?>" class="btn btn-sm btn-primary">Attachments Download</a>
									 </div>
									<?php } ?>
								</div>
                            <?php 

                            if(isset($list_data[0]->start_date)){

                                    $start_date=json_decode($list_data[0]->start_date,true); 

                                    $end_date=json_decode($list_data[0]->end_date,true); 

                                    $complete_percentage=json_decode($list_data[0]->complete_percentage,true); 

                                if(!empty($start_date)){ ?>

                                     <div class="input_fields_container">

                                         <div class="error_msg"></div>

                                <?php $i=0; 

                               

                                foreach ($start_date as $k => $s) { 

                                   ?>
                                    <div>

                                        <div class="form-group ">

                                        <div class="col-md-3">

                                          <label>Complete %</label>

                                            <input type="number" name="complete_per[]" class="form-control form-control-line complete_per" min="0" max="100" id="complete_per" value="<?php if(isset($complete_percentage[$k])) { echo $complete_percentage[$k]; } ?>">

                                        </div>

                                        <div class="col-md-3">

                                        <label>Start Date</label>

                                            <input type="text" name="start_date[]" class="form-control form-control-line start_date" id="start_date" value="<?php if(isset($start_date[$k])) { echo $start_date[$k]; } ?>">
	
                                        </div>

                                         <div class="col-md-3">

                                        <label>End Date</label>

                                            <input type="text" name="end_date[]" class="form-control form-control-line end_date" id="end_date" value="<?php if(isset($end_date[$k])) {echo $end_date[$k]; } ?>">

                                        </div>

                                        <?php if($i == 0) { ?>

                                            <div class="col-md-2">

                                                <button class="btn btn-sm btn-primary add_more_button" type="button">Add More Fields</button>

                                            </div>

                                        <?php }else{ ?>

                                            <a href="#" class="btn btn-sm btn-primary remove_field" style="margin-left:10px;">Remove</a>

                                        <?php } ?>

                                    </div>

                                  </div>

                                <?php $i++; } ?>

                                </div>

                            <?php }else{ ?>

                                    <div class="input_fields_container">

                                         <div class="error_msg"></div>

                                    <div>

                                        <div class="form-group task-last">

                                        <div class="col-md-3">

                                          <label>Complete %</label>

                                            <input type="number" name="complete_per[]" class="form-control form-control-line complete_per" min="0" max="100" id="complete_per" value="">

                                        </div>

                                        <div class="col-md-3">

                                        <label>Start Date</label>

                                            <input type="text" name="start_date[]" class="form-control form-control-line start_date" id="start_date" value="">

                                        </div>

                                         <div class="col-md-3">

                                        <label>End Date</label>

                                            <input type="text" name="end_date[]" class="form-control form-control-line end_date" id="end_date" value="">

                                        </div>

                                        <div class="col-md-2">

                                            <button class="btn btn-sm btn-primary add_more_button" type="button">Add More Fields</button>

                                        </div>

                                    </div>

                                  </div>

                                </div>

                                <?php } ?>

                                

                                

                           <?php }else{ ?>

                                <div class="input_fields_container">

                                     <div class="error_msg"></div>

                                    <div>

                                        <div class="form-group">

                                        <div class="col-md-3">

                                          <label>Complete %</label>

                                            <input type="number" name="complete_per[]" class="form-control form-control-line complete_per" min="0" max="100" id="complete_per" value="">

                                        </div>

                                        <div class="col-md-3">

                                        <label>Start Date</label>

                                            <input type="text" name="start_date[]" class="form-control form-control-line start_date" id="start_date" value="">

                                        </div>

                                         <div class="col-md-3">

                                        <label>End Date</label>

                                            <input type="text" name="end_date[]" class="form-control form-control-line end_date" id="end_date" value="">

                                        </div>

                                        <div class="col-md-2">

                                            <button class="btn btn-sm btn-primary add_more_button" type="button">Add More Fields</button>

                                        </div>

                                    </div>

                                  </div>

                                </div>

                            <?php 

                                }

                            ?>

                            <div class="form-group">

							<?php 

								$btn_text="ADD";

								if(isset($list_data[0]->id)){

									$btn_text="UPDATE";

								}

								

							?>

                                    <div class="col-sm-12">

                                        <button class="btn btn-success submit_form"><?php echo $btn_text;?></button>

                                    </div>

                                </div>

                            </form>

                </div>
                <div class="col-md-2"></div>
            </div>
        </div>

</div>

<script>

   
    $(document).ready(function() {

    

    $('.input_fields_container').on("click",".remove_field", function(e){ 

        e.preventDefault(); 

        $(this).parent('div').remove(); x--;

    })

});



</script>

<style>

.container{

padding: 20px;

width: 300px;

margin: 0 auto;

margin-top: 40px;

background: white;

border-radius: 5px;}



form {

display: inline-block;

}



input{

padding: 4px 15px 4px 5px;

}



#button{

display: inline-block;

background-color:#fc999b;

color:#ffffff;

border-radius: 5px;

text-align:center;

margin-top:2px;

padding: 5px 15px;

}



#button:hover{

cursor: pointer;

opacity: .8;}



ol {padding-left: 20px;}



ol li {padding: 5px;color:#000;}



ol li:nth-child(even){background: #dfdfdf;}



.strike{text-decoration: line-through;}



li:hover{

  cursor: pointer;

 }



</style>