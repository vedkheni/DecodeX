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
        <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title">List Designation</h4>
        </div>
        <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Designation</a></li>
                <li class="active">List Designation</li>
            </ol>
        </div> -->
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box m-0">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xs-12 text-center">
                        <button type="button" class="btn sec-btn btn-open-desig" data-toggle="modal" data-target="#myModal">Add New</button>
                        <!-- <a class="btn sec-btn float-right" href="<?php //echo base_url('designation/add'); ?>">Add New</a> -->
                    </div>
                </div>
                <hr class="custom-hr">
                <div class="table-responsive designa-table-list">
                    <div class="preloader preloader-2" style="display:none"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>
                   <table id="example" class="table dataTable display designation-table" style="width:100%">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add & Update Designation Modal -->
<div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <div class="modal_header">
                <h4 class="modal-title emp_name employee_name"><?php echo $page_text; ?> Designation</h4>
            </div>
        </div>
        <form method="post" action="<?php echo base_url('designation/insert_data'); ?>" id="designation-form">
            <div class="modal-body">
                <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">
                <input type="hidden" name="<?=csrf_token();?>" value="<?=csrf_hash();?>" />
                <div class="form-group">
                    <div class="single-field">
                        <input type="text" name="designation" id="designation" value="<?php if(isset($list_data[0]->name)){ echo $list_data[0]->name;} ?>"> 
                        <label>Designation Name</label>
                    </div>
                </div>
                <div class="form-group m-0">
                    <div class="single-field">
                        <textarea name="skills" id="skills" cols="4"><?php if(isset($list_data[0]->skills)){ echo $list_data[0]->skills;} ?></textarea>
                        <!-- <input type="text" name="designation" id="designation" value="<?php if(isset($list_data[0]->name)){ echo $list_data[0]->name;} ?>">  -->
                        <label>Skills</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <div class="row w-100">
                    <div class="col-12 p-0 text-right">
                        <button class="btn sec-btn submit_form"><?php echo $page_text; ?></button>
                    </div>
                </div>
          </div>
      </form>
  </div>

</div>
</div>

