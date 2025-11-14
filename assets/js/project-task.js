jQuery(document).ready(function ($) {
// $('#datatable').dataTable();
// var start = "2019-08-30 10:30:44";
// var end = "2019-08-30 10:30:44";
//  var start12 = "2019-08-30 10:30:44";
// var end12 = "22019-08-27 10:30:42";
function checkDate(start, end){
 var mStart = moment(start);
 var mEnd = moment(end);
 return mStart.isBefore(mEnd);
}
// console.log(checkDate(start, end));

$('#example').DataTable({
        "processing": true,
        "serverSide": true,
		"rowReorder": {
					"selector": 'td:nth-child(2)'
				},
		"responsive": true,
        "lengthMenu": [ [10, 30, 50, 100], [10, 30, 50, 100] ],
        "pageLength": 30,
        "ajax":{
         "url": "project_task/employee_pagination",
         "dataType": "json",
         "type": "POST",
        
                       },
        stateSave: true,               
          "columns": [
              { "data": "id" },
              { "data": "project_id" },
              { "data": "title" },             
              { "data": "description" }, 
              { "data": "action" }, 
            
           ],
            "order": [[ 0, "desc" ]]                   

});
$(document).on('click', '.delete-employee', function(){
    if (confirm("Are you sure?")) {
        jQuery(".loader-text").html("Deleting Project Task");
        jQuery(".loader-wrap").show();
        var id=$(this).attr("data-id");
        var data = {
                'id': id,
                };
               $.ajax({
            url: "project_task/delete_employee",
            type: "post",
            data: data ,
            success: function (response) {
              window.location.replace("project_task");
          },

          });
  }
  return false; 
});

$("#project-task-form").submit(function(e) {
  var project=$("#project").val();
  var title=$("#title").val();
  var description=$("#description").val();
  var hour=$("#hour").val();
  var minute=$("#minute").val();
  var developer=$("#developer").val();
  var deadline=$("#deadline").val();
  var priority=$("#priority").val();
  var status=$("#status").val();
   var s_date = "";
    var counter1 = 0;
    var counter2 = 0;

    $(".end_date").each(function() {

        if ($(this).val() == "") {
             $(this).addClass("error");
            counter2++;
        }else{
          var end=$(this).val();
         
          $(".start_date").each(function(index, val) {
         /* $('.end_date').each(function(index, val){
            alert(index + ' has value: ' + $(this).val());
          });*/
          
          if(index == 0){
            if ($(this).val() == "") {
                $(this).addClass("error");
                counter1=12;
                $('.error_msg').html("");
            }else{
              var start=$(this).val();
              var validtion=checkDate(start, end)
                if(validtion == false){
                  $('.error_msg').html('<span style="color:red;">End Date should not be less than Start Date </span>');
                  $(this).addClass("error");
                   counter1=13;
                }else{
                  counter1=0;  
                 
                  $(this).removeClass("error");
                  $('.error_msg').html("");
                 // $(this).replaceWith('<div class="start_date_class">'+$(this).val()+'</div>');
                }
                
            }
          }
          });

      }
    });
    if (($(".end_date").length == 0)){
  
    $(".start_date_class").each(function() {
      var start1=$(this).val();
      $(".end_date").each(function() {
         var end1=$(this).val();
          var validtion1=checkDate(start1, end1);
          if(validtion1 == false){
            $('.error_msg').html('<span style="color:red;">End Date should not be less than Start Date </span>');
            $(this).addClass("error");
             counter1=14;
          }else{
            counter1=0;  
            $(this).removeClass("error");
             $('.error_msg').html("");
            //$(this).replaceWith('<div class="start_date_class">'+$(this).val()+'</div>');
          }
      });
    
    });
     
    }
    if(counter1 ==  '0'){
        s_date=" ";
       $('.error_msg').html("");
    }else{
        s_date="";
    }
   /* console.log(s_date+" - "+counter1);
    return false;*/
  if(!project || !title || !description || !hour || !minute || !developer || !deadline || !priority || !status || !s_date){
      e.preventDefault();
      if(!project){
        $("#project").addClass('error');
      }
      else{
        $("#project").removeClass('error');
      }if(!title){
        $("#title").addClass('error');
      }
      else{
        $("#title").removeClass('error');
      }
      if(!description){
        $("#description").addClass('error');
      }
      else{
        $("#description").removeClass('error');
      }
      if(!hour){
        $("#hour").addClass('error');
      }
      else{
        $("#hour").removeClass('error');
      }
      if(!minute){
        $("#minute").addClass('error');
      }
      else{
        $("#minute").removeClass('error');
      }
      if(!developer){
        $("#developer").addClass('error');
      }
      else{
        $("#developer").removeClass('error');
      }
      if(!deadline){
        $("#deadline").addClass('error');
      }
      else{
        $("#deadline").removeClass('error');
      }
      if(!priority){
        $("#priority").addClass('error');
      }
      else{
        $("#priority").removeClass('error');
      }
      if(!status){
        $("#status").addClass('error');
      }
      else{
        $("#status").removeClass('error');
      }
    return false;       
  }
  else{
    var i=0;
     var start_date_class=[];
     $(".start_date_class").each(function(index,val) {
        i=index;
         start_date_class[i]=$(this).text();
     });
     var end_date_class=[];
     $(".end_date_class").each(function(index,val) {
        i=index;
         end_date_class[i]=$(this).text();
     });
     var complete_date_class=[];
     $(".complete_date_class").each(function(index,val) {
        i=index;
         complete_date_class[i]=$(this).text();
     });
      $("#start_hidden").val(start_date_class);
      $("#end_hidden").val(end_date_class);
      $("#complete_hidden").val(complete_date_class);
  
    $("#description").removeClass('error');
    $("#hour").removeClass('error');
    $("#minute").removeClass('error');
    $("#developer").removeClass('error');
    $("#deadline").removeClass('error');
    $("#priority").removeClass('error');
    $("#status").removeClass('error');
    return true;
  }
});


$("#project-task-form-admin").submit(function(e) {
  var project=$("#project").val();
  var title=$("#title").val();
  var description=$("#description").val();
  var hour=$("#hour").val();
  var minute=$("#minute").val();
  var developer=$("#developer").val();
  var deadline=$("#deadline").val();
  var priority=$("#priority").val();
  var tag=$("#tag").val();
  var bugs=$("#bugs").val();
  var complete_per=$(".complete_per").val();
  var start_date=$(".start_date").val();
  var end_date=$(".end_date").val();
  var status=$("#status").val();
  var s_date = "";
  var counter11 = 0;
    //var counter2 = 0;
/*      $(".end_date").each(function(index, value) {
        var end=$(this).val();
        if ($(this).val() == "") {
            $(this).addClass("error");
            counter11=11;
        }else{
            $(".start_date").each(function(index, value) {
              var start=$(this).val();
              if ($(this).val() == "") {
                  $(this).addClass("error");
                  counter11=12;
              }else{
                 var validtion=checkDate(start, end)
                  if(validtion == false){
                    $('.error_msg').html('<span style="color:red;">End Date should not be less than Start Date </span>');
                   // $(this).addClass("error");
                     counter11=13;
                  }else{
                    counter11=0;  
                   
                    $(this).removeClass("error");
                    $('.error_msg').html("");
                  }
              }
          });
           
        }
    });
    if(counter11 ==  '0'){
        s_date=" ";
       $('.error_msg').html("");
    }else{
        s_date="";
    }
    console.log(s_date+" - "+counter11);  */
    //return false;
	var data="";
	$('li.select2-selection__choice').each(function() {
		data= $(this).attr('title');
		$("#developer option").filter(function() {
			return this.text == data; 
		}).attr('selected', true);
	});
  if(!project || !title || !description || !hour || !minute || !developer || !deadline || !priority || !status ){
      e.preventDefault();
      if(!project){
        $("#project").addClass('error');
      }
      else{
        $("#project").removeClass('error');
      }if(!title){
        $("#title").addClass('error');
      }
      else{
        $("#title").removeClass('error');
      }
      if(!description){
        $("#description").addClass('error');
      }
      else{
        $("#description").removeClass('error');
      }
      if(!hour){
        $("#hour").addClass('error');
      }
      else{
        $("#hour").removeClass('error');
      }
      if(!minute){
        $("#minute").addClass('error');
      }
      else{
        $("#minute").removeClass('error');
      }
      if(!developer){
        $("#developer").addClass('error');
      }
      else{
        $("#developer").removeClass('error');
      }
      if(!deadline){
        $("#deadline").addClass('error');
      }
      else{
        $("#deadline").removeClass('error');
      }
      if(!priority){
        $("#priority").addClass('error');
      }
      else{
        $("#priority").removeClass('error');
      }
      if(!status){
        $("#status").addClass('error');
      }
      else{
        $("#status").removeClass('error');
      }
	if(complete_per){
		//e.preventDefault();
		console.log("complete per1");
		$(".complete_per").removeClass('error');
		 if(!start_date){
			$(".start_date").addClass('error');
			console.log("complete per12");
			
			}
		else{
		   $(".start_date").removeClass('error');
		 
		  console.log("complete per1");
			
		}
		if(!end_date){
			console.log("complete ");
			$(".end_date").addClass('error');
			
			}
		else{
			console.log("complete per1222");
		   $(".end_date").removeClass('error');
		 
			 
		}
		
      }
      else if(start_date){
		  console.log("start date");
		 $(".start_date").removeClass('error');
		
		if(!complete_per){
			console.log("dd1");
			$(".complete_per").addClass('error');
		
		}
		else{
			console.log("dd11");
		   $(".complete_per").removeClass('error');
		 
		}
		if(!end_date){
			console.log("complete ");
			$(".end_date").addClass('error');
			
			}
		else{
			console.log("complete per1222");
		   $(".end_date").removeClass('error');
		 
			 
		}
		
      }
	 else if(end_date){
		 console.log("end date1");
		$(".end_date").removeClass('error');
		if(!complete_per){
			$(".complete_per").addClass('error');
		}
		else{
		   $(".complete_per").removeClass('error');
		}
		if(!start_date){
			$(".start_date").addClass('error');
			console.log("complete per12");
			
			}
		else{
		   $(".start_date").removeClass('error');
		 
		  console.log("complete per1");
			
		}
		 
	 }
	 else{
		   console.log("else section1");
		   $(".start_date").removeClass('error');
		   $(".end_date").removeClass('error');
		   $(".complete_per").removeClass('error');
	  }
	 /*  if(!complete_per || !start_date || !end_date){
		  if(!complete_per){
			  $(".complete_per").addClass('error');
		  }
		  else{
			  $(".complete_per").removeClass('error');
		  }
		  if(!start_date){
			 $(".start_date").addClass('error');
		  }
		  else{
			 $(".start_date").removeClass('error');
		  }
		  if(!end_date){
			    $(".end_date").addClass('error');
		  }
		  else{
			   $(".end_date").removeClass('error');
		  }
		  
	  }
	  else{
		  $(".start_date").removeClass('error');
		   $(".end_date").removeClass('error');
		   $(".complete_per").removeClass('error');
	  } */
    return false;       
  }
  else{
     /* var counter11 = 0;
    //var counter2 = 0;
     $(".end_date").each(function(index, value) {
        var end=$(this).val();
        if ($(this).val() == "") {
            $(this).addClass("error");
            counter11=11;
        }else{
            $(".start_date").each(function(index, value) {
              var start=$(this).val();
              if ($(this).val() == "") {
                  $(this).addClass("error");
                  counter11=12;
              }else{
                 var validtion=checkDate(start, end)
                  if(validtion == false){
                    $('.error_msg').html('<span style="color:red;">End Date should not be less than Start Date </span>');
                   // $(this).addClass("error");
                     counter11=13;
                  }else{
                    counter11=0;  
                   
                    $(this).removeClass("error");
                    $('.error_msg').html("");
                  }
              }
          });
           
        }
    });
    if(counter11 ==  '0'){
        s_date=" ";
       $('.error_msg').html("");
    }else{
        s_date="";
    }
    console.log(s_date+" - "+counter11); */
    $("#description").removeClass('error');
    $("#hour").removeClass('error');
    $("#minute").removeClass('error');
    $("#developer").removeClass('error');
    $("#deadline").removeClass('error');
    $("#priority").removeClass('error');
    $("#status").removeClass('error');
     $(".complete_per").removeClass('error');
    $(".start_date").removeClass('error');
    $(".end_date").removeClass('error');
    return true;
  }
});

			
			$('.addtag').click(function(){
				
				jsonObj2 = [];
                var tag = $('input[name=tag]').val();
				console.log("add item btn click");
				 var span = '<i class="fa fa-close close close-tag" aria-hidden="true"></i>';

                
				 if(tag==""){
					 $('input[name=tag]').addClass('error');
					 return false;
				 }
				 else{
					
					 $('input[name=tag]').removeClass('error');
					  $('ol.tag-ol').append('<li>' + tag +' '+span+'</li>');
					   $('input[name=tag]').val('');
					  var i = 0;
						$(".tag-ol li").each(function() {
							tag = $(this).text();
							jsonObj2[i] = tag;
							i++;
							
						});
						console.log(jsonObj2);
						jsonObj2 = JSON.stringify(jsonObj2);
						$("#json_tag").val(jsonObj2);		
						return true;
				 }
            });
			
			$(document).on('click','.close-tag', function(){
				newjsonObj = [];
				var close = $(".close-tag").length;
				$(this).parent().remove(); 
				var x = 0;
				$(".tag-ol li").each(function() {
					tag = $(this).text();
					newjsonObj[x] = tag;
					x++;
				});
				var my_new_JSON = JSON.stringify(newjsonObj);
				$("#json_tag").val(my_new_JSON);
			});
       $("input[name=tag]").keyup(function(event){
          if(event.keyCode == 13){
            $(".addtag").click();
          }         
      });
      $('input[name=tag]').focus(function() {
        $(this).val('');
      });
      
    $('ol.tag-ol').sortable();  
    // bug todolist
	
	$('.addbug').click(function(){
				jsonObj2 = [];
                var bug = $('input[name=bugs]').val();
				console.log("add item btn click");
				 var span = '<i class="fa fa-close close close-bug" aria-hidden="true"></i>';
                
				 if(bug==""){
					 $('input[name=bugs]').addClass('error');
					 return false;
				 }
				 else{
					 $('input[name=bugs]').removeClass('error');
					  $('ol.bug-ol').append('<li>' + bug +' '+span+'</li>');
					  $('input[name=bugs]').val('');
						var i = 0;
						$(".bug-ol li").each(function() {
							bug = $(this).text();
							jsonObj2[i] = bug;
							i++;
							
						});
						console.log(jsonObj2);
						jsonObj2 = JSON.stringify(jsonObj2);
						$("#json_bug").val(jsonObj2);
						return true;
				 }
            });
			$(document).on('click','.close-bug', function(){
				newjsonObj2 = [];
				var close = $(".close-bug").length;
				$(this).parent().remove(); 
				var y = 0;
				$(".bug-ol li").each(function() {
					bug = $(this).text();
					newjsonObj2[y] = bug;
					y++;
				});
				var my_new_JSON2 = JSON.stringify(newjsonObj2);
				$("#json_bug").val(my_new_JSON2);
			});
       $("input[name=bugs]").keyup(function(event){
          if(event.keyCode == 13){
            $(".addbug").click();
			
          }         
      });
      $('input[name=bugs]').focus(function() {
        $(this).val('');
      });
	  $('ol.bug-ol').sortable();  
	

    });