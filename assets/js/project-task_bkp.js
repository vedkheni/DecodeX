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
        "lengthMenu": [ [10, 25, 50, 100], [10, 25, 50, 100] ],
        "pageLength": 10,
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
});