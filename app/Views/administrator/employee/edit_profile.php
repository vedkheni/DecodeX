<div id="page-wrapper">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Profile</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php //echo "<pre>";print_r($list_data); echo "</pre>"; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Update Profile</h3> 
                <div class="massge_for_error text-center"><?php echo $this->session->flashdata('message'); ?> </div>
                 <form class="form-horizontal form-material" method="post" action="<?php echo base_url('profile/insert_data'); ?>" id="employee-form" enctype="multipart/form-data">
                    <input type="hidden" name="e_id" id="e_id" value="<?php if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">

                                <div class="form-group">
                                    <label class="col-md-12">First Name *</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="First Name" class="form-control form-control-line" name="fname" id="fname" value="<?php if(isset($list_data[0]->fname)){ echo $list_data[0]->fname;} ?>"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Last Name *</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Last Name" class="form-control form-control-line" name="lname" id="lname" value="<?php if(isset($list_data[0]->lname)){ echo $list_data[0]->lname;} ?>"> </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">Email *</label>
                                    <div class="col-md-12">
                                        <input type="email" placeholder="Email" class="form-control form-control-line" name="email" id="email"  value="<?php if(isset($list_data[0]->email)){ echo $list_data[0]->email;} ?>"> </div>
                                </div>
                                <div class="form-group" style="display: none;">
                                    <label class="col-md-12">Password *</label>
                                    <div class="col-md-12">
                                        <input type="hidden" value="Geek@1234" name="password" id="password" class="form-control form-control-line"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Phone No *</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Phone No" class="form-control form-control-line" name="phone_number" id="phone_number"  value="<?php if(isset($list_data[0]->phone_number)){ echo $list_data[0]->phone_number;} ?>"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Date of Birth *</label>
                                    <div class="col-md-12">
                                        <input type="date"  class="form-control form-control-line" name="date_of_birth" id="date_of_birth"  value="<?php if(isset($list_data[0]->date_of_birth)){ echo $list_data[0]->date_of_birth;} ?>"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Gender *</label>
                                    <div class="col-md-12">
                                        <input type="radio" <?php if(isset($list_data[0]->gender) && $list_data[0]->gender == "female"){ ?> checked="checked" <?php } ?> name="gender" value="female" id="gender" class="radio-class">Female
                                        <input type="radio" <?php if(isset($list_data[0]->gender) && $list_data[0]->gender == "male"){ ?> checked="checked" <?php } ?> name="gender" value="male" id="gender1" class="radio-class">Male
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Address *</label>
                                    <div class="col-md-12">
                                        <textarea rows="5" class="form-control form-control-line" name="address" id="address"><?php if(isset($list_data[0]->address)){ echo $list_data[0]->address;} ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">designation *</label>
                                    <div class="col-md-12">
                                       <select class="form-control form-control-line" name="designation" id="designation">
                                            <option></option>
                                            <?php foreach ($designation as $key => $value) { ?>
                                             <option <?php if(isset($list_data[0]->designation) && $list_data[0]->designation == $value->id){ ?> selected="selected" <?php } ?> value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                                    
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php 
                                  $url = base_url().'assets/id_proof';
                                ?>
                                <div class="form-group">
                                    <label class="col-md-12">ID Proof *</label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control form-control-line" name="id_proof" id="id_proof">
                                    </div>
                                    <div class="col-md-6">
                                        <?php if(isset($list_data[0]->id_proof) && !empty($list_data[0]->id_proof)){ ?>
                                          <a download href="<?php echo $url.'/'.$list_data[0]->id_proof; ?>"><img src="<?php echo $url.'/'.$list_data[0]->id_proof; ?>" width="50%">

                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success submit_form">ADD</button>
                                    </div>
                                </div>
                            </form>
            </div>
        </div>
    </div>
</div>
