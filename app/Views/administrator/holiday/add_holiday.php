 <?php 
    $page_text="Add";
    if(isset($list_data[0]->id) && !empty($list_data[0]->id)){ 
        $page_text="Update";
    }else{
        $page_text="Add";
    }
    $date_min=date('Y-m-d', strtotime("first day of January this year"));
    $date_max=date('Y-m-d', strtotime("last day of December this year"));
?>
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title text-center">Add Holiday</h4>
        </div>
        <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
				<li class="active">Holidays</li>
            </ol>
        </div> -->
    </div>
    <?php  
       // echo "<pre>"; print_r($list_data); echo "</pre>"; 
    ?>
    <!-- <div class="row justify-content-center">
        <div class="col-xs-12 col-lg-10 col-xl-7">
            <div class="white-box m-0">
                
               
                <div class="massge_for_error text-center"><?php //echo $this->session->getFlashdata('message'); ?> </div>
                 <form class="form-horizontal form-material" method="post" action="<?php //echo base_url('holiday/insert_data1'); ?>" id="holiday-form">
                    <input type="hidden" name="e_id" id="e_id" value="<?php //if(isset($list_data[0]->id)){ echo $list_data[0]->id;} ?>">
                        <?php 
                           /*  $csrf = array(
                                'name' => $this->security->get_csrf_token_name(),
                                'hash' => $this->security->get_csrf_hash()
                            ); */
							
						?> -->
						<!-- <div class="massge_for_error text-center"><?php //echo $this->session->getFlashdata('message'); ?> </div>
						<div class="massge_for_error text-center"><?php //echo $this->session->getFlashdata('message1'); ?> </div>
						<div class="error_msg massge_for_error text-center"></div>
						<div id="holiday_massage"></div> -->
                        <!-- <input type="hidden" name="<?php // echo $csrf['name'];?>" value="<?php //echo $csrf['hash'];?>" />
                        
						<div class="row _holiday">
                            <div class="col-12 text-center">
						        <div class="holiday_form">
						        	<div class="single-field select-field multi-field">
							        	<select id="search_year" name="search_year" >
							        		<option value="" disabled>Select Year</option>
							        		<option <?php //if(isset($year) && $year == '2017'){ echo "selected='selected'"; } ?> value="2017">2017</option>
							        		<option <?php //if(isset($year) && $year == '2018'){ echo "selected='selected'"; } ?> value="2018">2018</option>
							        		<option <?php //if(isset($year) && $year == '2019'){ echo "selected='selected'"; } ?> value="2019">2019</option>
							        		<option <?php //if(isset($year) && $year == '2020'){ echo "selected='selected'"; } ?> value="2020">2020</option>
							        		<option <?php //if(isset($year) && $year == '2021'){ echo "selected='selected'"; } ?> value="2021">2021</option>
							        		<option <?php //if(isset($year) && $year == '2022'){ echo "selected='selected'"; } ?> value="2022">2022</option>
							        		<option <?php //if(isset($year) && $year == '2023'){ echo "selected='selected'"; } ?> value="2023">2023</option>
							        	</select>
							        	<label>Select Year</label>
									</div> -->
									<!-- <button type="button"  class="pro-edit"><i class="fas fa-pencil-alt"></i></button> -->
						        	<!-- <a href="javascript:void(0);" class=" btn sec-btn" data-toggle="modal" data-target="#add_holiday" title="Add field" >Add More</a> -->
						        	<!-- <a href="javascript:void(0);" class=" btn sec-btn add_button" data-toggle="modal" data-target="#add_holiday" title="Add field" >Add More</a> -->
                                <!-- </div>
                            </div>
                        </div>

                        <hr class="custom-hr"> -->

                      <!--   <div class="row">
                            <div class="col-md-12 ">
                                 <div class="field_wrapper">
                                <?php 
                                    // $i=1;
                                    // if(isset($list_data) && !empty($list_data)){
                                    //     // print_r($list_data);exit;
                                    //     $cls = 1 ;
                                    //       foreach ($list_data as $key => $value) { 
						        	// 		$d=date_create($value->holiday_date);
						        	// 		$day_number=date_format($d,'j');
						        	// 		$month_number=date_format($d,'n');
									// 		$days_join=31;
									// 		if(!empty($month_number) && !empty($year)){
									// 			$days_join=cal_days_in_month(CAL_GREGORIAN,$month_number,$year);
									// 		}
						        		  ?>
        
                                        <div class="holiday-add-grp" id="holiday-class-<?php //echo $value->id; ?>">
                                            

                                            <div class="form-group" id="<?php //echo $cls; ?>">
											<div class="row">
											<input type="hidden" name="holiday_id[]" id="holiday_id" value="<?php //echo $value->id; ?>">
                                                <div class="col-12 col-sm-4">
                                                	<div class="single-field select-field">
							        					<select class="select_day select_day_update days<?php // echo $value->id ?>" id="select_day" name="select_day_update[<?php // echo $value->id ?>]"  >
							        						<option disabled>Select Day</option>
							        						<?php // for($m=1;$m<=$days_join;$m++){ ?>
							        							<option <?php // if($day_number == $m){ echo "selected"; } ?> value="<?php // echo $m; ?>"><?php // echo $m; ?></option>
							        						<?php // } ?>
							        					</select>
	                                                    <label>Select Day</label>
                                                	</div>
                                                </div>
						        				<div class="col-12 col-sm-4">
						        					<div class="single-field select-field">
	                                                    <select  data-did="<?php // echo $value->id ?>" class="select_month select_month_update" id="select_month" name="select_month_update[<?php // echo $value->id ?>]" >
							        					<option disabled>Select Month</option>
							        						<?php // foreach(MONTH_NAME as $k => $v){ ?>
							        							<option <?php // if($month_number == $k +1){ echo "selected"; } ?> value="<?php // echo $k+1; ?>"><?php // echo $v; ?></option>
							        						<?php // } ?>
							        					</select>
	                                                    <label>Select Month</label>
	                                                </div>
                                                </div>
                                                <div class="col-12 col-sm-4">
                                                	<div class="single-field">
	                                                    <input type="text" name="title_update[<?php // echo $value->id ?>]" id="title" class="title title_update" value="<?php // echo $value->title; ?>"/>
	                                                    <label>Title</label>
	                                                </div>
                                                </div>

                                    <?php // if($i == 1){ ?>
                                        
                                    <?php //  }else{ ?>
                                        <a href="javascript:void(0);" class="remove_button pull-right" title="Remove" data-hid="<?php // echo $value->id; ?>"></a>  
                                    <?php // } ?>                                                               
                                                        
                                    		</div>
                                                </div>
                                            </div>
                                        
                                        <?php 
                                     // $i++;$cls++; } 
                                    // }else{ ?>
                            
                                    <div class="holiday-add-grp">
                                        <input type="hidden" name="holiday_id[]" id="holiday_id" value="">
                                        <div class="form-group">
                                            <div class="col-12 col-sm-4">
                                            	<div class="single-field select-field">
							        				<select class="select_day select_day1" id="select_day" name="select_day[]" >
							        				<option disabled>Select Day</option>
							        					<?php // for($j=1;$j<=31;$j++){ ?>
							        						<option value="<?php // echo $j; ?>"><?php // echo $j; ?></option>
							        					<?php // } ?>
							        				</select>
							        				<label>Select Day</label>
						        				</div>
						        			</div>
						        			<div class="col-12 col-sm-4">
						        				<div class="single-field select-field">
							        				<select class="select_month select_month1" id="select_month" name="select_month[]" >
							        				<option disabled>Select Month</option>
							        					<?php // foreach(MONTH_NAME as $k1 => $v1){ ?>
							        						<option  value="<?php // echo $k1+1; ?>"><?php // echo $v1; ?></option>
							        					<?php // } ?>
							        				</select>
							        				<label>Select Month</label>
						        				</div>
						        			</div>
						        			<div class="col-12 col-sm-4">
						        				<div class="single-field">
                                                   <label>Title</label>
                                                   <input type="text" name="title[]" id="title" class="title title1" value=""/>
                                            	</div>
                                            </div>
                                                    
                                            <a href="javascript:void(0);" class=" btn sec-btn add_button" title="Add field">Add More</a
                                        </div>
                                    </div>
                                                    
                                <?php //   } ?>
                                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                            	<div class="holiday-result-msg">
	                        		<div class="massge_for_error"><?php // echo $this->session->getFlashdata('message'); ?> </div>
									<div class="massge_for_error"><?php // echo $this->session->getFlashdata('message1'); ?> </div>
                            	</div>
                        	</div>
                            <div class="col-12 col-md-6 text-right">
                                    <button class="btn sec-btn submit_form1" type="button" ><?php // echo $page_text; ?></button>
                            </div>
                        </div> -->
                    <!-- </form>
            </div>
        </div>
    </div> -->

	<!-- teble -->
<div class="row">
	<div class="col-md-12">
         <div class="white-box m-0">
            <div class="emp-custom-field">
			<div class="row">
				<div class="col-12 text-center">
				<form class="form-horizontal form-material" method="post" action="<?php echo base_url('holiday/insert_data1'); ?>" id="holiday-form">
					<input type="hidden" name="e_id" id="e_id" value="10">
					<input type="hidden" name="csrf_test_name" value="f0abc8a1c2f186d6c4be00b440af6b30">
					
					<div class="row _holiday">
						<div class="col-12 text-center">
							<div class="holiday_form">
								<div class="single-field select-field multi-field">
									<select id="search_year" name="search_year">
										<option value="" disabled="">Select Year</option>
										<?php
											$next_year=date('Y',strtotime('+3 year'));
											for($i=2018;$i<=$next_year;$i++){?>
											<option   <?php if(date('Y') == $i) echo "selected='selected'";  ?> value="<?php echo $i;?>"><?php echo $i;?></option>
										<?php } ?>
									</select>
									<label>Select Year</label>
								</div>
								<a href="javascript:void(0);" class=" btn sec-btn add_holiday_btn" data-toggle="modal" data-target="#add_holiday" title="Add field">Add More</a>
							</div>
						</div>
					</div>
					<hr class="custom-hr">
				</form>
				</div>
			</div>
			<div class="table-responsive employee-table-list">
				<div class="preloader preloader-2" style="display:none"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>
				<table id="example" class="display nowrap dataTable" style="width: 100%;">
					<thead class="_empthead">
						<tr role="row">
							<th>#</th>
							<th>Date</th>
							<th>Title</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<!-- <?php 
							$i=1;
							if(isset($list_data) && !empty($list_data)){
								foreach ($list_data as $key => $value){
								?>
									<tr>
										<td><?php echo $key+1;  ?></td>
										<td><?php echo $value->holiday_date; ?></td>
										<td><?php echo $value->title; ?></td>
										<td>
											<button data-holiday_id="<?php echo $value->id; ?>" class="btn btn-outline-secondary edit-employee">Edit</button>  
											<button data-holiday_id="<?php echo $value->id; ?>" class="btn btn-danger delete-employee">Delete</button>
										</td>
									</tr>
								<?php 
									} 
							} 
						?> -->
					</tbody>
					<tfoot>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>
</div>

</div>	
	<!-- teble -->
	<a href="javascript:void(0);" class="d-none btn sec-btn add_holiday_btn1" data-toggle="modal" data-target="#add_holiday" title="Add field">Add More</a>
<!-- Start Modal -->
<div class="modal in" id="add_holiday" role="dialog">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close close_popup" data-dismiss="modal"><i class="fas fa-times"></i></button>
            <div class="modal_header-content">
               <h4 class="modal-title" id="title">Add Holiday</h4>
            </div>
         </div>
         <form method="POST" enctype="multipart/form-data" action="<?php echo base_url('holiday/insert_data'); ?>" id="holiday-form1">
                              <input type="hidden" name="csrf_test_name" value="c7d2253a6393422e3e9684319c38f548">
               <input type="hidden" name="holiday_id" id="holiday_id" value="">
               <input type="hidden" name="detail_type" id="detail_type" value="basic_detail">
               <input type="hidden" name="hidden_date" id="hidden_date" value="">
            <div class="modal-body">
				<div class="form-group">
                  <div class="single-field date-field">
                     <input type="text" name="holiday_date" class="datepicker-here" id="holiday_date" data-multiple-dates-separator=" ," data-multiple-dates = "100"  data-date="2019-12-12" value="2019-12-12" autocomplete="off">
                     <label>Holiday Date</label>
                  </div>
               </div>
				<div class="form-group m-0">
                  <div class="single-field">
                     <input type="text" name="holiday_title" id="holiday_title" value="">
                     <label>Holiday Title</label>
                  </div>
               </div>
            </div>
            <div class="modal-footer">     
				<button type="button" class="btn sec-btn text-right add-holiday" title="Add Holiday" >Add Holiday</button>                    
            </div>
         </form>
      </div>
   </div>
</div>
<!-- End Modal -->
<script type="text/javascript">

$(document).ready(function(){
	
	//$( "li" ).each(function( index ) {
  //console.log( index + ": " + $( this ).text() );
//});
 //    $("#search_year").change(function(){
	// 	var year = $(this).val();
	// 	//alert(year);
	// 	window.location="<?php //echo base_url('holiday/add/'); ?>"+year;
	// });
	var month_array='<?php echo json_encode(MONTH_NAME)?>';
	var month_decod=JSON.parse(month_array);
	var month_name = month_decod;
	
    
	var day_option = "";
	
	var i;
	//var day1 = 31;
	for (i = 1; i <= 31; i++) {
		day_option += "<option value='"+ i +"'>" + i + "</option>";
	}
	
	var	month_name_option = "";
	var j;
	for (j = 0; j < month_name.length; j++) {
	  month_name_option +=  "<option value='"+ (j+1) +"'>" + month_name[j] + "</option>";
	}
	
   
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
   var k = 1; //Initial field counter is 1
	 
    //Once add button is clicked
		  $(addButton).click(function(){
		  var fieldHTML='<div class="holiday-add-grp"><div class="form-group"><div class="row"><div class="col-12 col-sm-4"><div class="single-field select-field"> <select class=" select_day select_day1 select_day_add new_days'+k+'" id="select_day" name="select_day[]"><option disabled>Select Day</option>'+day_option+' </select> <label>Select Day</label></div></div><div class="col-12 col-sm-4"><div class="single-field select-field"> <select class=" select_month select_month1 select_month_add new_month'+k+'" data-add-month="'+k+'" id="select_month" name="select_month[]"><option disabled>Select Month</option>'+month_name_option+' </select> <label>Select Month</label></div></div><div class="col-12 col-sm-4"><div class="single-field"> <input type="text" name="title[]" id="title" class="title title1 " value="" /> <label>Title</label></div></div> <a href="javascript:void(0);" class="remove_button pull-right" title="Remove"></a></div></div></div>';
		 $(wrapper).append(fieldHTML); 
		 k++;
        
    });
    
  
	 function daysInMonth (month, year) { 
		return new Date(year, month, 0).getDate(); 
     } 
	$(".select_month").on('change', function() {
	   var id = $(this).data("did"); 
	   var select_month = $(this).val(); 
       if($("#search_year").val() != ""){
			var search_year=$("#search_year").val();   
	   }else{
		   var search_year=2019;
	   }
	   var select_day = $(".days"+id).val();
	   var num = daysInMonth(select_month, search_year);
	   console.log(num+""+select_day);
		var i;
		 var option="<option disabled>Day</option>";
		for (i = 1; i <= num; i++) {
		  option +="<option value='"+i+"'>"+i+"</option>";
		}
		
		
		$(".days"+id).html(option);
		$(".days"+id).val(select_day);
	});
	
	$(document).on('change', ".select_month_add", function() {
		 //alert();
	    var id = $(this).data("add-month"); 
	   var select_month = $(this).val(); 
       if($("#search_year").val() != ""){
			var search_year=$("#search_year").val();   
	   }else{
		   var search_year=2019;
	   }
	   var select_day = $(".new_days"+id).val();
	   var num = daysInMonth(select_month, search_year);
	  // console.log(num+""+select_day);
		var i;
		 var option="<option disabled>Day</option>";
		for (i = 1; i <= num; i++) {
		  option +="<option value='"+i+"'>"+i+"</option>";
		}
		//console.log(id);
		$(".new_days"+id).html(option);
		$(".new_days"+id).val(select_day); 
	});
});
</script>