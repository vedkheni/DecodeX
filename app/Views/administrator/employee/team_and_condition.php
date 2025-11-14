<?php $user_id=$this->session->userdata('id');?>
<div id="page-wrapper">
<div class="container-fluid">
   <div class="row bg-title">
      <div class="col-lg-12 col-md-12 col-xs-12">
         <h4 class="page-title">Team & Condition</h4>
      </div>
   </div>                
   <div class="row">
      <div class="col-md-12">
         <div class="white-box m-0">
            <div class="team_con info-content p-0">
				  	<?php if(isset($team_and_condition) && !empty($team_and_condition[0]->description)){ echo $team_and_condition[0]->description; } ?>
            </div>  
         </div>
      </div>
   </div>
</div>	

