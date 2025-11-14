<div id="page-wrapper">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-12 col-md-12 col-xs-12">
	        <h4 class="page-title text-center">Add Content</h4>
        	
      	</div>
        
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-10 col-xl-8">
            <!-- <div class="white-box"> -->
                <div class="massge_for_error text-center"> </div>
                 <form class="form-horizontal form-material" method="POST" enctype="multipart/form-data" action="<?php base_url('mail_content/update_content'); ?>" id="mail_content-form">
                        <?php
                        $csrf = array(
                            'name' => $this->security->get_csrf_token_name(),
                            'hash' => $this->security->get_csrf_hash()
                        );
                        ?>
                        <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
						<input type="hidden" name="id" id="id" value="">
                    	<div class="field-grp white-box add-basic-detail">
                    	    <div class="field-grp-title"><h2>Mail Content</h2></div>
                    		    <div class="row">
								    <div class="col-md-12">
	                                 <div class="form-group">
	                                    <div class="single-field">
	                                        <input type="text" name="name" id="name" value="">
	                                    	<label for="name">Name*</label>
	                                    </div>
	                                </div>
	                            </div>	 								
	                            <div class="col-md-12">
	                                <div class="form-group">
	                                    <div class="single-field">
                                            <textarea class="textarea" name="mail_content" id="mail_content"></textarea>
                                            <script>
                                                CKEDITOR.replace('mail_content');
                                            </script>
	                                    </div>
	                                </div>
	                            </div>
								<div class="col-md-12">
	                                <div class="form-group">
	                                    <div class="single-field">
	                                        <input type="text" name="mail_slug" id="mail_slug" value="">
	                                    	<label>Slug*</label>
	                                    </div>
	                                </div>
	                            </div>
                        	</div>
                    	</div>
	                    <div class="white-box bluebox-border m-0">
	                    	<div class="row">
	                            <div class="col-md-12">
	                                <div class="form-group text-center m-0 p-0">
	                                    <div class="col-sm-12">
	                                        <button type="button" class="btn btn-outline-primary add_mail_content">Add</button>
	                                    </div>
	                                </div>
	                            </div>        
	                    	</div>
	                    </div>	
				</form>
            <!-- </div> -->
        </div>
    </div>
</div>
<script>
    
</script>