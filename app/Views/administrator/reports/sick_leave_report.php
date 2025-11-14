<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         <!-- <div class="col-sm-4">
         </div> -->
         <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title">Sick Leave Reports</h4>
         </div>
         <!-- <div class="col-sm-4">
            <ol class="breadcrumb">
               <li><a href="#">Reports</a></li>
               <li class="active">Sick Leave Reports</li>
            </ol>
         </div> -->
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="white-box m-0">

               <!-- search Form -->
               <form class="form-horizontal form-material frm-search" method="post" action="">
                  <div class="row">
                     <div class="col-12 text-center"  >
                       <div class="single-field multi-field select-field _search-form">
                         <select id="bonus_year" onchange="get_sick_leave(1,'Y');" name="bonus_year" >
                           <option value="" disabled>Select Year</option>
                           <option value="1">This year</option>
                           <option value="2">Last 2 years</option>
                           <option value="3">Last 3 years</option>
                           <option value="4">Last 4 years</option>
                           <option value="5">Last 5 years</option>
                           <option value="all_year">All year</option>
                        </select>
                         <label>Select Year</label>
                     </div>
                     <a href="<?php echo base_url("export_excel/sick_leave_excel/1"); ?>" class="btn btn-primary export_excel " name="export_excel">Export Excel</a>
                     </div>


                  <!-- </div> 
                  <div class="error_msg"></div>
                  <div class="col-lg-4 col-md-6 _search-form">
                     <div class="col-md-12 emp_">

                        <div class="emp_submit">
                           <input type="submit"  class="btn btn-primary pull-left emp_search " name="salary_month_search"  value="Search">
                        </div>
                        <div class="emp_submit">
                           <input type="reset" class="btn btn-primary pull-left emp_reset"  value="Reset">
                        </div>    

                     </div>
                  </div>-->
                   <!-- <div class="d-inline-block _search-form">
                     <div class="emp_">
                        <div class="emp_submit">
                           <a href="<?php // echo base_url("export_excel/sick_leave_excel/1"); ?>" class="btn btn-primary pull-left export_excel " name="export_excel">Export Excel</a>
                        </div>
                     </div>
                  </div> -->

               </div>
            </form>

            <hr class="custom-hr">

            <!-- <div class="table-responsive box-shadow">
               <table id="data_deposit" class=" display nowrap">

               </table>
            </div> -->
            <!-- <div class="box-shadow"> -->
            <div class="deposit-table-scroll">
            <div class="deposit-table">
               <table class="deposit-fixed" >
                  <tbody>
                     
                     <tr class="M_name emp_name month-details">
                       <!-- <td>January</td>
                        <td>February</td>
                        <td>March</td>
                        <td>April</td>
                        <td>May</td>
                        <td>Jun</td>
                        <td>July</td>
                        <td>August</td>
                        <td>September</td>
                        <td>October</td>
                        <td>November</td>
                        <td>December</td>
                        <td>Months</td>
                        <td>January</td>
                        <td>February</td>
                        <td>March</td>
                        <td>April</td>
                        <td>May</td>
                        <td>Jun</td>
                        <td>July</td>
                        <td>August</td>
                        <td>September</td>
                        <td>October</td>
                        <td>November</td>
                        <td>December</td>-->
                     </tr>
                    
                  </tbody>
               </table>
               <div class="deposit-list">
               <table  class="display nowrap deposit-list-table" >
                  <tbody class="deposit-details sick_leave_detail">
                     
                  </tbody>
               </table>

               </div>

            </div>  
            </div>  
            <!-- </div>           -->
         </div>
         </div>
      </div>
   </div>
<!-- </div> -->
<input type="hidden" id="page" name="page" value="1">
<input type="hidden" id="total_pages" name="total_pages" value="5">
<script>
   $(document).ready(function($){
    get_sick_leave(1,'Y');
     $(".deposit-list").scroll(function() {
         var total_pages = parseInt($("#total_pages").val());
         var page = parseInt($("#page").val())+1;
         if(page <= total_pages){
            console.log(page);
            get_sick_leave(page,'X');
            $("#page").val(page);
         } 
      });
   });
</script>
<!-- login_log_id,employee_id,datetime -->