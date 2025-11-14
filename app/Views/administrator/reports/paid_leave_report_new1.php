<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         <div class="col-sm-4">
         </div>
         <div class="col-sm-4 text-right">
            <h4 class="page-title text-center">Paid Leave Reports</h4>
         </div>
         <div class="col-sm-4">
            <ol class="breadcrumb">
               <li><a href="#">Reports</a></li>
               <li class="active">Paid Leave Reports</li>
            </ol>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="white-box bg-none">

               <!-- search Form -->
               <form class="form-horizontal form-material frm-search" method="post" action="">
                  <div class="_form-search-form">
                     <!-- <div class="error_msg"></div> -->

                    <div class="col-lg-4 col-md-6 _search-form">
                      <label>Year:</label>
                      <select class="form-control form-control-line bor-top" id="bonus_year" onchange="get_use_paid_leave(1,'Y');" name="bonus_year" >
                        <option value="" disabled>Select Year</option>
                        <option value="1">This year</option>
                        <option value="2">Last 2 years</option>
                        <option value="3">Last 3 years</option>
                        <option value="4">Last 4 years</option>
                        <option value="5">Last 5 years</option>
                        <option value="all_year">All year</option>
                     </select>
                  </div>

                  <div class="col-lg-4 col-md-6 _search-form">
                     <div class="col-md-12 emp_">
                        <div class="emp_submit">
                           <a href="<?php echo base_url("export_excel/used_paid_leave_excel/1"); ?>" class="btn btn-primary pull-left export_excel " name="export_excel">Export Excel</a>
                        </div>
                     </div>
                  </div>
               </div>
            </form>

            <div class="box-shadow">
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
                  <tbody class="deposit-details paid_leave_detail">
                     
                  </tbody>
               </table>

               </div>

            </div>  
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
    get_use_paid_leave(1,'Y');
     $(".deposit-list").scroll(function() {
         var total_pages = parseInt($("#total_pages").val());
         var page = parseInt($("#page").val())+1;
         if(page <= total_pages){
            console.log(page);
            get_use_paid_leave(page,'X');
            $("#page").val(page);
         } 
      });
   });
</script>
<!-- login_log_id,employee_id,datetime -->