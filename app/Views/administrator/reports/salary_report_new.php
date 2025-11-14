<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         
         <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title">Salary Reports</h4>
         </div>
         <!-- <div class="col-sm-4">
            <ol class="breadcrumb">
               <li><a href="#">Reports</a></li>
               <li class="active">Salary Reports</li>
            </ol>
         </div> -->
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="white-box">

               <!-- search Form -->
               <form class="frm-search" method="post" action="">
                  <div class="row">
                     <div class="col-12 text-center">
                       <div class="single-field select-field multi-field _search-form">
                         <select id="bonus_year" onchange="get_salary(1,'Y');" name="bonus_year" >
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
                     <a href="<?php echo base_url("export_excel/salary_excel/1"); ?>" class="btn btn-primary pull-left export_excel " name="export_excel">Export Excel</a>
                     </div>

                     <!-- <div class="error_msg"></div> -->
               </div>
            </form>

            <hr class="custom-hr">

            <div class="deposit-table-scroll">
            <div class="deposit-table">
               <table class="deposit-fixed" >
                  <tbody>
                     <tr class="M_name emp_name month-details">

                     </tr>
                  </tbody>
               </table>
               <div class="deposit-list">
               <table  class="display nowrap deposit-list-table" >
                  <tbody class="deposit-details leave_detail">
                     
                  </tbody>
               </table>

               </div>

            </div>  
            </div>          
         </div>
         </div>
      </div>
   </div>
<input type="hidden" id="page" name="page" value="1">
<input type="hidden" id="total_pages" name="total_pages" value="5">
<script>
   
   $(document).ready(function($){
    get_salary(1,'Y');
     $(".deposit-list").scroll(function() {
         var total_pages = parseInt($("#total_pages").val());
         var page = parseInt($("#page").val())+1;
         if(page <= total_pages){
            console.log(page);
            get_salary(page,'X');
            $("#page").val(page);
         } 
      });
   });
</script>
<!-- login_log_id,employee_id,datetime -->