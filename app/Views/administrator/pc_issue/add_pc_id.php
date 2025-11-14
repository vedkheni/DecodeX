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
            <div class="add-basic-detail field-grp white-box">
                <div class="field-grp-title"><h2>Add Employee PC Id</h2></div>
                <div><h2>Your PC ID <span id="idofpc"><?php if(isset($get_pc_data[0])){ echo $get_pc_data[0]->pc_id; }elseif(isset($list_data[0]->pc_id)){echo $list_data[0]->pc_id; } ?></span></h2></div>  
                <div class="single-field select-field multi-field _search-form">
                  <select class=" emp_search1" id="emp_id" name="emp_id" >
                     <option value="">All Employee</option>
                     <?php foreach($employee_list as $n => $name){ ?>
                     <option <?php if(isset($employee_id) && !empty($employee_id) && $employee_id == $name->id){ echo "selected='selected'"; } ?> value="<?php echo $name->id; ?>"><?php echo $name->fname." ".$name->lname; ?></option>
                     <?php } ?>
                  </select>
                  <label>Select Employee</label>
               </div>      
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
                                <button type="button" id="btn-change_id" class="btn sec-btn sec-btn-outline">Add</button>
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
        </div>
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
// var base_url = $("#js_data").data('base-url');

</script>