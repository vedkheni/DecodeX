<?php 
    $user_role=$this->session->userdata('user_role');
    $page_text="Add";
    if(isset($list_data[0]->id) && !empty($list_data[0]->id)){ 
        $page_text="Update";
    }else{
        $page_text="Add";
    }
    if(isset($list_data[0]->hardware_part) && !empty($list_data[0]->hardware_part)){
       $hpart = explode(',',$list_data[0]->hardware_part);
    }
    $issue = '';
    if(isset($list_data[0]->issue) && $list_data[0]->issue == 'software'){
        $screenshort = explode(',',$list_data[0]->screenshorts);
        foreach ($screenshort as $k => $v){ $issue .= '<div class="img-preview removeImg" ><button type="button" class="remove_img" data-image_name="'.$v.'"><i class="fas fa-times"></i></button> <a href="javascript:void(0)" onclick="show_img($(this))" class="ss_view_image" title="View Resume" data-href="'.base_url('assets/upload/issue_ss/').$v.'"><i class="fas fa-eye"></i><img src="'.base_url('assets/upload/issue_ss/').$v.'" style="width: 100px;" alt=""></a></div>'; }
    }
?>
<style>
.img-preview {
    display: inline-block;
    position: relative;
    margin: 0 5px;
}

.img-preview button {
    background: #fff;
    border: none;
    color: #000;
    height: 21px;
    width: 21px;
    padding: 0;
    border-radius: 4px;
    position: absolute;
    right: 5px;
    top: 5px;
    z-index: 10;
}

.img-preview .ss_view_image {
    position: relative;
    z-index: 8;
}

.img-preview .ss_view_image i {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    color: #fff;
}
</style>
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-12 col-md-12 col-xs-12">
	        <h4 class="page-title text-center"><?php echo $page_text; ?> Candidate</h4>
      	</div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-10 col-xl-8">
            <!-- <div class="white-box"> -->
                <div class="massge_for_error text-center"><?php // echo $this->session->flashdata('message'); ?> </div>
                 <form class="form-horizontal form-material" method="POST" enctype="multipart/form-data"  action="<?php echo base_url('pc_issue/insert_data'); ?>" id="pc_issue-form">
						<?php 	
                        $csrf = array(
                                'name' => $this->security->get_csrf_token_name(),
                                'hash' => $this->security->get_csrf_hash()
                        );
						?>
                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
						<input type="hidden" name="emp_id" id="emp_id" value="<?php echo (isset($list_data[0]->employee_id))? $list_data[0]->employee_id : $this->session->userdata('id'); ?>">
						<input type="hidden" name="id" id="id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">
						<input type="hidden" name="ss" id="ss" value="<?php echo (isset($list_data[0]->screenshorts))?$list_data[0]->screenshorts : ''; ?>">
						<input type="hidden" name="parts" id="parts" value="<?php echo (isset($list_data[0]->hardware_part))?$list_data[0]->hardware_part : ''; ?>">
                        <input type="hidden" name="pc_id" id="pc_id" value="<?php echo (isset($list_data[0]->pc_id))?$list_data[0]->pc_id : ''; ?>">
                    	<div class="field-grp white-box add-basic-detail">
                    	<div class="field-grp-title"><h2>PC Issue</h2></div>
                    		
                            <div class="text-center"><h2>Your PC ID <span id="idofpc_1"><?php if(isset($get_pc_data[0])){ echo $get_pc_data[0]->pc_id; }elseif(isset($list_data[0]->pc_id)){echo $list_data[0]->pc_id; } ?></span></h2></div>
                    		<div class="row">
							<?php // echo "<pre>"; print_r($list_data); echo "</pre>";?>
								<div class="col-md-6">
									<div class="form-group">
										<div class="single-field select-field">
											<select name="issue" id="issue">
												<option value="" disabled>Select Issue</option>
												<option <?php if(isset($list_data[0]->issue) && $list_data[0]->issue == 'hardware'){ ?> selected="selected" <?php }elseif(!isset($list_data[0]->issue)){ echo 'selected="selected"'; } ?> value="hardware">Hardware</option>
												<option <?php if(isset($list_data[0]->issue) && $list_data[0]->issue == 'software'){ ?> selected="selected" <?php } ?> value="software">Software</option>
											</select>
											<label>Select Issue*</label>
										</div>
									</div>
								</div>
                                <?php if($user_role == 'admin'){ ?>
								<div class="col-md-6">
									<div class="form-group">
										<div class="single-field select-field">
                                            <select name="status" id="status">
                                                <option <?php if(isset($list_data[0]->issue) && $list_data[0]->status == 'new'){ ?> selected="selected" <?php } ?> value="new">New</option>
                                                <option <?php if(isset($list_data[0]->issue) && $list_data[0]->status == 'pending'){ ?> selected="selected" <?php } ?> value="pending">Pending</option>
                                                <option <?php if(isset($list_data[0]->issue) && $list_data[0]->status == 'inprogress'){ ?> selected="selected" <?php } ?> value="inprogress">Inprogress</option>
                                                <option <?php if(isset($list_data[0]->issue) && $list_data[0]->status == 'resolved'){ ?> selected="selected" <?php } ?> value="resolved">Resolved</option>
                                            </select>
                                            <label>Select Status*</label>
										</div>
									</div>
								</div>
                                <?php } ?>
								<span class="col-md-12 <?php if(isset($list_data[0]->issue) && $list_data[0]->issue == 'software'){ ?> d-none <?php } ?> ?>" id="hardware">
									<div class="col-md-6">
										<div class="form-group radio-group">
											<label class="m-0">Hardware Parts*</label>
											<div class="form-radio">
												<input type="checkbox" <?php if(isset($hpart) && in_array('display',$hpart)){ ?> checked="checked" <?php } ?> name="h_parts" value="display" id="h_part1" class="radio-class gender"><label for="h_part1">Display</label>
											</div>
											<div class="form-radio">
												<input type="checkbox" <?php if(isset($hpart) && in_array('cpu',$hpart)){ ?> checked="checked" <?php } ?> name="h_parts" value="cpu" id="h_part2" class="radio-class gender"><label for="h_part2">CPU</label>
											</div>
											<div class="form-radio">
												<input type="checkbox" <?php if(isset($hpart) && in_array('keyboard',$hpart)){ ?> checked="checked" <?php } ?> name="h_parts" value="keyboard" id="h_part3" class="radio-class gender"><label for="h_part3">Keyboard</label>
											</div>
											<div class="form-radio">
												<input type="checkbox" <?php if(isset($hpart) && in_array('mouse',$hpart)){ ?> checked="checked" <?php } ?> name="h_parts" value="mouse" id="h_part4" class="radio-class gender"><label for="h_part4">Mouse</label>
											</div>
										</div>
									</div>
								</span>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="single-field">
                                            <textarea class="textarea" name="issue_description" id="issue_description"><?php if(isset($list_data[0]->description)){ echo $list_data[0]->description;} ?></textarea>
                                            <label>Type Your Issue Description*</label>
                                        </div>
                                    </div>
                                </div>
								<span class="col-md-12 <?php if(isset($list_data[0]->issue) && $list_data[0]->issue == 'hardware'){ ?> d-none <?php }elseif(!isset($list_data[0]->issue)){ echo 'd-none'; }  ?>" id="software">
									<!-- Software -->									
									<div class="col-md-6 float-left">
										<div class="form-group candidate-resume">
											<div class="single-field">
												<div class="upload-text" id="upload-text">
													<i class="fas fa-upload text-secondary"></i>
													<span>Upload Screenshort here</span>
												</div>

												<input type="file" class="file-upload-field" name="screenshorts[]" id="screenshorts" multiple value="">
                                                <span id="image_name"></span>
										    </div>
										</div>	
									</div>
                                    <div class="col-md-6 float-right"><?php if(!empty($issue)){ echo $issue; } ?></div>
								</span>
                        	</div>
                    	</div>
	                    <div class="white-box bluebox-border m-0">
	                    	<div class="row">
	                            <div class="col-md-12">
	                                <div class="form-group text-center m-0 p-0">
	                                    <div class="col-sm-12">
	                                        <button type="button" id="btn-issue_sub" class="btn sec-btn sec-btn-outline"><?php  echo $page_text; ?></button>
	                                    </div>
	                                </div>
	                            </div>        
	                    	</div>
	                    </div>	
				</form>
            <!-- </div> -->
        </div>
        <?php if($user_role != 'admin'){ ?>
            <div class="add-basic-detail field-grp white-box">
                <div class="field-grp-title"><h2>Your PC ID <span id="idofpc"><?php if(isset($get_pc_data[0])){ echo $get_pc_data[0]->pc_id; }elseif(isset($list_data[0]->pc_id)){echo $list_data[0]->pc_id; } ?></span></h2></div>      
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="single-field">
                            <input type="hidden" name="url" id="url" value="pc_issue/add">
                            <input type="number" class="numeric" name="change_pc_id" id="change_pc_id" min="1" value="">
                            <label>PC ID*</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group text-center m-0 p-0">
                            <div class="col-sm-12">
                                <button type="button" id="btn-change_id" class="btn sec-btn sec-btn-outline">Change</button>
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <img src="" id="view_ss_image" alt="">
        </div>
    </div>
</div>
<div class="msg-container">
    <?php $html = ''; $a = explode('</p>',$this->session->flashdata('message')); $a=array_filter($a); if(isset($a[0]) && $a[0] != ''){
        for($i=0; $i < count($a); $i++){
            if(!empty($a[$i]) && ($i+1) != count($a)){
                $html .= '<div class="msg-box error-box box1">
                    <div class="msg-content">
                        <div class="msg-icon"><i class="fas fa-times"></i></div>
                        <div class="msg-text text1">'.$a[$i].'</div>
                    </div>
                </div>';
            }
        }
        echo $html;
    } ?>
    </div>
<script>
</script>