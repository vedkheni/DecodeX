jQuery(document).ready(function ($) {

$("#employee-form").submit(function(e) {
  var employee_in=$("#employee_in").val();
  //var employee_out=$("#employee_out").val();
 /// var time_picker=$("#time_picker").val();
  //&& !employee_out && !time_picker
  if(!employee_in){
      e.preventDefault();
      if(!employee_in){
        $("#employee_in").addClass('error');
      }
      else{
        $("#employee_in").removeClass('error');
      }
      /*if(!employee_out){
        $("#employee_out").addClass('error');
      }
      else{
        $("#employee_out").removeClass('error');
      }
       if(!time_picker){
        $("#time_picker").addClass('error');
      }
      else{
        $("#time_picker").removeClass('error');
      }*/
    return false;       
  }
  else{
    $("#employee_in").removeClass('error');
   // $("#time_picker").removeClass('error');
    //$("#employee_out").removeClass('error');
    return true;
  }
});
});