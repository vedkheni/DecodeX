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
    <?php $user_role=$this->session->userdata('user_role'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="massge_for_error text-center"><?php echo $this->session->flashdata('message'); ?> </div>
                 <form class="form-horizontal form-material" method="post" action="<?php echo base_url('project_task/insert_data'); ?>" id="project-task-form" enctype="multipart/form-data">
                    <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">
                     <?php 
                        $csrf = array(
                                'name' => $this->security->get_csrf_token_name(),
                                'hash' => $this->security->get_csrf_hash()
                        );
                    ?>
                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                            <?php $dev=array(); 
                                        if(isset($list_data[0]->developer)){ 
                                          $dev=explode(',',$list_data[0]->developer); 
                                        }
                                    ?>
                                <div class="form-group">
                                   
                                    <div class="col-md-6">
                                         <label>Project</label>
                                         <select class="form-control form-control-line" name="project" id="project">
                                            <option>Project</option>
                                            <?php foreach ($get_project as $key => $p) { ?>
                                               <option <?php if(isset($list_data[0]->project_id)) {if($list_data[0]->project_id == $p->id){ ?> selected="selected" <?php }} ?> value="<?php echo $p->id; ?>"><?php echo $p->title; ?></option>
                                            <?php } ?>
                                         </select>
                                     </div>
                                      <div class="col-md-6">
                                         <label>Developer</label>
                                        <select class="form-control form-control-line " multiple="multiple" name="developer[]" id="developer">
                                            <!-- <option></option> -->
                                            <?php foreach ($get_developer as $key => $value) { ?>
                                                <option <?php if(in_array($value->id,$dev)){ ?> selected="selected" <?php } ?> value="<?php echo $value->id ?>"><?php echo $value->fname." ".$value->lname; ?></option>
                                            <?Php } ?>
                                        </select>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Title</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="" class="form-control form-control-line" name="title" id="title" value="<?php if(isset($list_data[0]->title)){ echo $list_data[0]->title;} ?>"> </div>
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
                                            <option <?php if(isset($list_data[0]->priority) && $list_data[0]->priority == 'testing'){ ?> selected="selected" <?php } ?> value="testing">Testing</option>
                                            <option <?php if(isset($list_data[0]->priority) && $list_data[0]->priority == 'review'){ ?> selected="selected" <?php } ?> value="review">Review</option>
                                            <option <?php if(isset($list_data[0]->priority) && $list_data[0]->priority == 'complete'){ ?> selected="selected" <?php } ?> value="complete">Complete</option>
                                        </select>
                                    </div>
                                </div>
                                <?php 
                                  $url = base_url().'assets/attachments';
                                ?>
                                <div class="form-group">
                                    <label class="col-md-12">Attachments</label>
                                    <div class="col-md-6">
                                        <input type="file" name="attachments" class="form-control" id="attachments" >
                                        
                                    </div>
                                     <div class="col-md-6">
                                        <?php if(isset($list_data[0]->attachments) && !empty($list_data[0]->attachments)){ ?>
                                            <a download href="<?php echo $url.'/'.$list_data[0]->attachments; ?>" class="btn btn-sm btn-primary">Attachments Download</a>
                                        <?php } ?>
                                     </div>
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
                                $complete_percentage_readonly_class = $start_date_readonly_class = $end_date_readonly_class ="";
                                foreach ($start_date as $k => $s) { ?>
                                        <div>
                                        <div class="form-group">
                                   <?php if($user_role != 'admin'){
                                         if(isset($complete_percentage[$k])) { ?> 
                                        <div class="col-md-2">
                                            <label>Complete %</label>
                                           <div class="complete_date_class"><?php echo $complete_percentage[$k]; ?>
                                           </div>
                                        </div>
                                        <?php  }else{ ?>
                                            <div class="col-md-2">
                                            <label>Complete %</label>
                                            <input type="number" name="complete_per[]" class="form-control form-control-line complete_per" min="0" max="100" id="complete_per" value="">
                                        </div>
                                        <?php }
                                        
                                        if(isset($start_date[$k])) { ?>
                                        <div class="col-md-4">
                                            <label>Start Date</label>
                                            <div class="start_date_class"><?php echo $start_date[$k]; ?></div>
                                        </div>
                                        <?php }else{ ?>
                                            <div class="col-md-4">
                                            <label>Start Date</label>
                                                <input type="text" name="start_date[]" class="form-control form-control-line start_date" id="start_date" value="">
                                            </div>
                                        <?php } 
                                        
                                        if(isset($end_date[$k])) { ?>
                                        <div class="col-md-4">
                                            <label>End Date</label>
                                            <div class="end_date_class"><?php echo $end_date[$k]; ?></div>
                                        </div>
                                        <?php }else{ ?>
                                            <div class="col-md-4">
                                            <label>End Date</label>
                                            <input type="text" name="end_date[]" class="form-control form-control-line end_date" id="end_date" value="">
                                        </div>
                                        <?php } 
                                        }
                                    ?> 
                                   
                                    
                                        
                                        
                                        
                                        <?php if($i == 0) { ?>
                                            <div class="col-md-2">
                                                <button class="btn btn-sm btn-primary add_more_button" type="button">Add More Fields</button>
                                            </div>
                                        <?php }else{ ?>
                                            <!-- <a href="#" class="btn btn-sm btn-primary remove_field" style="margin-left:10px;">Remove</a> -->
                                        <?php } ?>
                                    </div>
                                  </div>
                                
                                <?php $i++; } ?>
                                </div>
                            <?php }else{ ?>
                                    <div class="input_fields_container">
                                        <div class="error_msg"></div>
                                    <div>
                                        <div class="form-group">
                                        <div class="col-md-2">
                                          <label>Complete %</label>
                                            <input type="number" name="complete_per[]" class="form-control form-control-line complete_per" min="0" max="100" id="complete_per" value="">
                                        </div>
                                        <div class="col-md-4">
                                        <label>Start Date</label>
                                            <input type="text" name="start_date[]" class="form-control form-control-line start_date" id="start_date" value="">
                                        </div>
                                         <div class="col-md-4">
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
                                        <div class="col-md-2">
                                          <label>Complete %</label>
                                            <input type="number" name="complete_per[]" class="form-control form-control-line complete_per" min="0" max="100" id="complete_per" value="">
                                        </div>
                                        <div class="col-md-4">
                                        <label>Start Date</label>
                                            <input type="text" name="start_date[]" class="form-control form-control-line start_date" id="start_date" value="">
                                        </div>
                                         <div class="col-md-4">
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
                                
                            <div class="task_complete" style="display: none;">
                                
                               
                                        <div class="form-group">
                                        <div class="col-md-2">
                                          <label>Complete %</label>
                                            <input type="number" name="complete_per[]" class="form-control form-control-line complete_per" min="0" max="100" id="complete_per" value="">
                                        </div>
                                        <div class="col-md-4">
                                        <label>Start Date</label>
                                            <input type="text" name="start_date[]" class="form-control form-control-line start_date" id="start_date" value="">
                                        </div>
                                        <div class="col-md-4">
                                        <label>End Date</label>
                                            <input type="text" name="end_date[]" class="form-control form-control-line end_date" id="end_date" value="">
                                        </div>
                                       
                                           <!--  <a href="#" class="btn btn-sm btn-primary remove_field" style="margin-left:10px;">Remove</a> -->
                                        
                                    </div>
                                  </div>

                            
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
                                <input type="hidden" name="complete_hidden[]" id="complete_hidden" value="">
                                <input type="hidden" name="start_hidden[]" id="start_hidden" value="">
                                <input type="hidden" name="end_hidden[]" id="end_hidden" value="">
                            </form>
            </div>
        </div>
    </div>
</div>
<script>
     function checkDate(start, end){
 var mStart = moment(start);
 var mEnd = moment(end);
 return mStart.isBefore(mEnd);
}
    $(document).ready(function() {

    var max_fields_limit = 10; //set limit for maximum input fields
    var x = 1; //initialize counter for text box
    $('.add_more_button').click(function(e){ 
    var counter = 0;
    var counter1 = 0;
    var counter2 = 0;
    $(".complete_per").each(function() {
       // console.log($(this).val());
        if ($(this).val() == "") {
            $(this).addClass("error");
            counter++;
        }else{
            $(this).removeClass("error");
            counter=0;
         
           $(this).replaceWith('<div class="complete_date_class">'+$(this).val()+'</div>');
           
        }
    });
   /* $(".start_date").each(function() {
        if ($(this).val() == "") {
            $(this).addClass("error");
            counter1++;
        }else{
            $(this).removeClass("error");
            counter1=0;
            
        }
    });*/
    if($(".end_date").val()){
    $(".end_date").each(function(index, value) {
         var end=$(".end_date").val();
        if ($().val() == "") {
            $(this).addClass("error");
            counter=125;
        }else{
             $(".start_date").each(function(index, value) {
              var start=$(".start_date").val();
              if ($(".start_date").val() == "") {
                  $(this).addClass("error");
                  counter=121;
              }else{
                 var validtion=checkDate(start, end);
                  if(validtion == false){
                    $('.error_msg').html('<span style="color:red;">End Date should not be less than Start Date </span>');
                    $(this).addClass("error");
                     counter=13;
                  }else{
                    counter=0;  
             //$(this).attr('readonly', true);
                $(".start_date").replaceWith('<div class="start_date_class">'+$(this).val()+'</div>');
             //   $(this).attr('readonly', true);
             $(".end_date").replaceWith('<div class="end_date_class">'+$(this).val()+'</div>');
                    //$(this).removeClass("error");
                    //$('.error_msg').html("");
                  }
              }
          });

            // $(".end_date").removeClass("error");
            // counter2=0;
            // // $(this).attr('readonly', true);
            // $(".end_date").replaceWith('<div class="end_date_class">'+$(this).val()+'</div>');

        }
    });
}else{
    counter=0;
}
    console.log(counter+" "+counter1+""+counter2);
    //return false;
    if(counter == '0' && counter1 == '0' && counter2 == '0'){

     
     //if(counter11 ==  '0'){
        //$(".task_complete").clone().show().appendTo(".input_fields_container");
        $('.input_fields_container').append('<div class="task_complete" > <div class="form-group"> <div class="col-md-2"> <label>Complete %</label> <input type="number" name="complete_per[]" class="form-control form-control-line complete_per" min="0" max="100" id="complete_per" value=""> </div><div class="col-md-4"> <label>Start Date</label> <input type="text" name="start_date[]" class="form-control form-control-line start_date" id="start_date" value=""> </div><div class="col-md-4"> <label>End Date</label> <input type="text" name="end_date[]" class="form-control form-control-line end_date" id="end_date" value=""> </div> </div></div>');
   // }
    
        $(".complete_per").removeClass('error');
        $(".start_date").removeClass('error');
        $(".end_date").removeClass('error');
    }
    
    });  
    $('.input_fields_container').on("click",".remove_field", function(e){ 
        e.preventDefault(); 
        $(this).parent('div').remove(); x--;
        $(".input_fields_container .complete_per:last" ).removeAttr('readonly', false);
        $(".input_fields_container .start_date:last" ).removeAttr('readonly', false);
        $(".input_fields_container .end_date:last" ).removeAttr('readonly', false);

    })
});
</script>