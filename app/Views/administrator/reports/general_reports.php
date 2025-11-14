<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row bg-title">
         <!-- <div class="col-sm-4">
         </div> -->
         <div class="col-lg-12 col-md-12 col-xs-12">
            <h4 class="page-title"><?php echo $page_title; ?></h4>
         </div>
         <!-- <div class="col-sm-4">
            <ol class="breadcrumb">
               <li><a href="#">Reports</a></li>
               <li class="active">Paid Leave Reports</li>
            </ol>
         </div> -->
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="white-box m-0">

               <!-- search Form -->
               <div class="emp-custom-field">
                  <form class="frm-search" method="post" action="">
                     <div class="row">
                        <div class="col-lg-8 col-12 text-center text-lg-left">
                           <div class="single-field multi-field select-field _search-form">
                              <select id="bonus_year" name="bonus_year">
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
                           <div class="single-field multi-field select-field _search-form">
                              <select id="report_page" name="report_page">
                                 <option value="" disabled>Select Report</option>
                                 <option value="1">Bonus Reports</option>
                                 <option value="2">Deposit Reports</option>
                                 <option value="3" selected="">Paid Leave Reports</option>
                                 <option value="4">Sick Leave Reports</option>
                                 <option value="5">Leave Reports</option>
                                 <option value="6">Used Paid Leave Reports</option>
                                 <option value="7">Prof Tax Reports</option>
                                 <option value="8">Salary Reports</option>
                              </select>
                              <label>Select Report</label>
                           </div>
                           <div class="single-field multi-field select-field _search-form">
                              <select name="employees" id="employees">
                                 <option value="" disabled>Select Employee</option>
                                 <?php
                                 foreach ($get_employee as $dev) {
                                 ?>
                                    <option value="<?php echo $dev->id; ?>" <?php if (isset($search['employees']) && $search['employees'] == $dev->id) { ?> selected="selected" <?php } ?>><?php echo $dev->fname . " " . $dev->lname; ?></option>
                                 <?php } ?>
                              </select>
                              <label>Select Employee</label>
                           </div>
                           <a href="<?php echo base_url("export_excel/paid_leave_excel/1"); ?>" class="btn sec-btn export_excel " name="export_excel">Export Excel</a>
                        </div>
                           <div class="col-lg-4 col-12 text-center text-lg-right">
                              <div class="_form-search-form deposit-list-form">
                                 <div class="_search-form ">
                                    <h4 class="total-salary-title">Total :
                                       <span class="blue-text" id="total_count"></span>
                                    </h4>
                                 </div>
                              </div>
                           </div>

                        <!-- <div class="error_msg"></div> -->
                        <!-- <div class="d-inline-block _search-form">
                     <div class="emp_">
                        <div class="emp_submit">
                           <a href="<?php echo base_url("export_excel/paid_leave_excel/1"); ?>" class="btn sec-btn pull-left export_excel " name="export_excel">Export Excel</a>
                        </div>
                     </div>
                  </div> -->
                     </div>
                  </form>
                  <hr class="custom-hr">
               </div>


               <!-- <div class="box-shadow"> -->
               <!-- <div class="deposit-table-scroll"> -->
               <div class="preloader preloader-2">
                  <svg class="circular" viewBox="25 25 50 50">
                     <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                  </svg>
               </div>
               <div class="deposit-table gen_report-list" id="report_list">
                  <!-- <table class="deposit-fixed" >
                  <tbody>
                     <tr class="M_name emp_name month-details">
                       
                     </tr>
                  </tbody>
               </table> -->
                  <!-- <div class="reports_detail deposit-list"> -->
                  <!--  <table  class="display nowrap deposit-list-table" >
                  <tbody class="deposit-details reports_detail">
                     
                  </tbody>
               </table> -->

                  <!-- </div> -->

               </div>
               <!-- </div>   -->
               <!-- </div>           -->
            </div>
         </div>
      </div>
   </div>
   <!-- </div> -->
   <input type="hidden" id="page" name="page" value="1">
   <input type="hidden" id="total_pages" name="total_pages" value="5">
   <script>
      function report_all_page(page, n) {
         var report_page = $('#report_page').val();
         if (report_page == 1) {
            $('#report_list').attr('class', '');
            $('#report_list').attr('class', 'deposit-table gen_report-list deposit-details');
            get_bonus(page, n);
         } else if (report_page == 2) {
            $('#report_list').attr('class', '');
            $('#report_list').attr('class', 'deposit-table gen_report-list deposit-details');
            get_deposit(page, n);
         } else if (report_page == 3) {
            $('#report_list').attr('class', '');
            $('#report_list').attr('class', 'deposit-table gen_report-list reports_detail');
            get_paid_leave(page, n);
         } else if (report_page == 4) {
            $('#report_list').attr('class', '');
            $('#report_list').attr('class', 'deposit-table gen_report-list sick_leave_detail');
            get_sick_leave(page, n);
         } else if (report_page == 5) {
            $('#report_list').attr('class', '');
            $('#report_list').attr('class', 'deposit-table gen_report-list leave_detail');
            get_leave(page, n);
         } else if (report_page == 6) {
            $('#report_list').attr('class', '');
            $('#report_list').attr('class', 'deposit-table gen_report-list paid_leave_detail');
            get_use_paid_leave(page, n);
         } else if (report_page == 7) {
            $('#report_list').attr('class', '');
            $('#report_list').attr('class', 'deposit-table gen_report-list prof_tax_detail');
            get_prof_tax(page, n);
         } else if (report_page == 8) {
            $('#report_list').attr('class', '');
            $('#report_list').attr('class', 'deposit-table gen_report-list leave_detail');
            get_salary(page, n);
         }

      }
      $(document).ready(function($) {
         report_all_page(1, 'Y');
         /*  $(".deposit-list").scroll(function() {
         var total_pages = parseInt($("#total_pages").val());
         var page = parseInt($("#page").val())+1;
			 if(page <= total_pages){
				console.log(page);
				report_all_page(page,'X');
				$("#page").val(page);
			 }
      }); */
         $("#employees").change(function() {
            report_all_page(1, 'Y');
         });
         $("#bonus_year").change(function() {
            report_all_page(1, 'Y');
         });
         $("#report_page").change(function() {
            report_all_page(1, 'Y');
         });
      });
   </script>
   <!-- login_log_id,employee_id,datetime -->