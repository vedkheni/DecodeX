<div id="page-wrapper">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Add Task</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('project'); ?>">Task</a></li>
                <li class="active">Add Task</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php $user_role=$this->session->userdata('user_role'); 
		//echo "<pre>"; print_r($get_project_task); echo "</pre>";
	?>
    <div class="row">
        <div class="col-md-12">
		<div class="white-box task-view">
            <div class="row">
				<div>
			        <h4 class="modal-title"><h2 class="_title task-project"><?php if(isset($get_project_task[0])){ echo $get_project_task[0]->title; } ?> - <?php if(isset($get_project_task[0])){ echo $get_project_task[0]->project_title; } ?></h2></h4>
			        <div class="_model">
                        <div class="col-md-12 demo">
                            <div class="form-group _content">
                                <p class="control-label">Details:</p>
                                <div>
                                    <p class="details_text"><?php if(isset($get_project_task[0])){ echo $get_project_task[0]->description; } ?></p>
                                </div>
                            </div>
                        </div> 
                            <!-- <form action="/action_page.php">  -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group _content">
                                    <p class="control-label col-sm-12">Proiority:</p>
                                    <div class="col-sm-12">
                                        <p class="proiority_text"><?php if(isset($get_project_task[0])){ echo ucwords($get_project_task[0]->priority); } ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
	        	    	        <div class="form-group _content">
                                    <p class="control-label col-sm-12">Devloper:</p>
                                    <div class="col-sm-12 tag">
                                        <?php if(isset($get_project_task[0]) && !empty($get_project_task[0]->developer_name)){ 
												$developer_name=explode(",",$get_project_task[0]->developer_name); 
												foreach($developer_name as $developer){ ?>
												<p class="devloper_text"><?php echo $developer; ?></p>
										<?php }} ?>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group _content">
                                    <p class="control-label col-sm-12">Type:</p>
                                    <div class="col-sm-12">
                                        <p class="type_text"><?php if(isset($get_project_task[0])){ echo ucwords($get_project_task[0]->type); } ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group _content">
                                    <p class="control-label col-sm-12">Status:</p>
                                    <div class="col-sm-12">
                                        <p class="status_text"><?php if(isset($get_project_task[0])){ echo ucwords($get_project_task[0]->status); } ?></p>
                                    </div>
                                </div>
                            </div>  
                        </div>
						<?php 
							$hours = $minute = 0;
							if(!empty($get_project_task[0]->minute)){
							   $minutes=$get_project_task[0]->minute;
							   $hours = floor($minutes / 60);
							   $minute=($minutes -   floor($minutes / 60) * 60);
							}
						?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group _content">
                                    <p class="control-label col-sm-12">Time:</p>
                                    <div class="col-sm-12">
                                        <p class="text_time"><?php echo  $hours." Hours ".$minute." Minute"; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group _content">
                                    <p class="control-label col-sm-12">Deadline Date:</p>
                                    <div class="col-sm-12">
                                        <p class="deadline_date"><?php if(isset($get_project_task[0])){ echo $get_project_task[0]->deadline_date; } ?></p>
                                    </div>
                                </div>
                            </div>  
                        </div>
						<?php 
								$json_decode_tag="";
								if(isset($get_project_task[0]->task_tag)){
									$json_decode_tag=json_decode($get_project_task[0]->task_tag);
								}	
						?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group _content">
                                    <p class="control-label col-sm-12">Tags:</p>
                                    <div class="col-sm-12 tag">
									<?php
										if(!empty($json_decode_tag)){ 
											foreach($json_decode_tag as $tag){	?>
												<p class="tags"><?php echo $tag; ?></p>
										<?php 	
											} }
										?>
                                        </div>
                                </div>
                            </div>
							<?php 
								$json_decode="";
								if(isset($get_project_task[0]->task_bug)){
									$json_decode=json_decode($get_project_task[0]->task_bug);
								}	
							?>

                            <div class="col-sm-6">
                                <div class="form-group _content">
                                    <p class="control-label col-sm-12">Bugs:</p>
                                    <div class="col-sm-12 bug">
                                        <?php if(!empty($json_decode)){ 
												foreach($json_decode as $bug){	?>
													<p class="bugs"><?php echo $bug; ?></p>
										<?php 	} }
										?>
									</div>
                                </div>
                            </div>  
                        </div>
							 <div class="row">
							<?php $img_url="";
							if(isset($get_project_task[0]->attachments) && !empty($get_project_task[0]->attachments)){
								$attachments=explode(".",$get_project_task[0]->attachments);
								$ext=array('png','jpg','jpeg');
								$img="";
								$img_url=base_url('assets/attachments/').$get_project_task[0]->attachments;
								if(isset($attachments[1]) && in_array($attachments[1],$ext)){
									$img="image";
								} ?>

							
                       
                            <div class="col-sm-6">
                                <div class="col-sm-12 form-group _content">
                                    <p class="control-label">Attachments:</p>
									<?php if(!empty($img)){ ?>
                                    <div class="_attachment">
                                        <img src="<?php echo $img_url; ?>" height="200" width="300px">
                                    </div>
									<?php } ?>
                                    <!-- <a><i class="fa fa-download" aria-hidden="true"></i></a> -->
                                    <div class="col-lg-4 col-sm-6" style="padding:0px;">
                                        <div id="btn-download">
                                            <div class="download-btn">
                                                <svg width="40px" height="40px" viewBox="0 0 22 16">
                                                    <path d="M2,10 L6,13 L12.8760559,4.5959317 C14.1180021,3.0779974 16.2457925,2.62289624 18,3.5 L18,3.5 C19.8385982,4.4192991 21,6.29848669 21,8.35410197 L21,10 C21,12.7614237 18.7614237,15 16,15 L1,15" id="check"></path>
                                                    <polyline points="4.5 8.5 8 11 11.5 8.5" class="svg-out"></polyline>
                                                    <path d="M8,1 L8,11" class="svg-out"></path>
                                                </svg>
                                                <a href="<?php echo $img_url; ?>" download > Download </a>                                              
                                            </div>
                                        </div>        
                                    </div>                                    
                                </div>
                            </div>
							<?php } ?>
							<?php if(isset($get_project_task[0]) && !empty($get_project_task[0]->start_date)){ ?>
                            <div class="col-sm-6">
                                <div class="col-sm-12 form-group _content">
                                    <!-- <p class="control-label">:</p> -->
                                </div>
								<?php
									$start_date = $complete_percentage = $end_date = "";
									if(isset($get_project_task[0])){
										$start_date=json_decode($get_project_task[0]->start_date);
										$complete_percentage=json_decode($get_project_task[0]->complete_percentage);
										$end_date=json_decode($get_project_task[0]->end_date);
										
									} ?>
                                <div class="col-sm-12">                           
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Complete %</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">End Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php  if(!empty($start_date)){ $i=1; foreach($start_date  as $key =>  $sdate){  ?>
											<tr>
                                                <th scope="row"><?php echo $i; ?></th>
                                                <td><?php if(isset($complete_percentage->$key) && !empty($complete_percentage->$key)){ echo $complete_percentage->$key; } ?>%</td>
                                                <td><?php echo $sdate; ?></td>
                                                <td><?php if(isset($complete_percentage->$key) && !empty($complete_percentage->$key)){ echo $end_date->$key; } ?></td>
                                            </tr>	
										<?php $i++; } } ?>
                                        </tbody>
                                    </table>
                                </div>                                                    
                            </div>
					<?php } ?>
                        </div>
						<div class="clearfix"></div>

                            <!-- </form> -->

	        	            <!-- <div class="modal-footer">
                                <a href="<?php echo base_url('project/view'); ?>" class="btn btn-default _view-more">Add More Fields</a>
	        	    	        <button type="button" class="btn btn-primary _close" data-dismiss="modal">Add</button>
	        	            </div> -->

                        </div>
                    </div>
            </div>
        </div>
        </div>
    </div>
