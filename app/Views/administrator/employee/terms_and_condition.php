<?php $user_id=$this->session->get('id');?>
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-12 col-md-12 col-xs-12">
         <h4 class="page-title">Terms & Condition</h4>
      </div>
   </div>                
   <div class="row">
      <div class="col-md-12">
         <div class="white-box m-0">
            <div class="team_con p-0">
				  	<?php if(isset($terms_and_condition) && !empty($terms_and_condition[0]->description)){ echo $terms_and_condition[0]->description; }else{ echo '<li class="no-data">Data not available!</li>'; } ?>
            </div>  
         </div>
      </div>
   </div>
</div>	

