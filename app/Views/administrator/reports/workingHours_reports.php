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
                            <div class="row">
                                <div class="col-lg-8 col-12 text-center text-lg-left">
                                    <div class="single-field date-field multi-field _search-form">
                                        <input type="text" placeholder="01 Jan, 1998" class="datepicker-here" data-language="en" name="date" id="date" data-date-format="dd M, yyyy" autocomplete="off" value="">
                                        <label>Select Date</label>
                                    </div>
                                    <button type="button" class="btn sec-btn" id="time_search">Search</button>
                                </div>
                            </div>
                        <hr class="custom-hr">
                    </div>
                    <div class="tabbtn">
                        <div class="preloader preloader-2 report_preloader1" style="display:none !important;">
                            <svg class="circular" viewBox="25 25 50 50">
                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                            </svg>
                        </div>

                        <div class="single-field select-field mb-custom-tab" onclick="$(this).toggleClass('active');">
                            <span class="mb-custom-tab-active">Working Hours Details</span>
                            <ul class="mb-tab-list">
                                <li class="nav-item active">
                                    <a class="nav-link active" id="workingHours-details-tab" onclick=" $('span.mb-custom-tab-active').text($(this).text());" data-toggle="tab" href="#workingHours-details" role="tab" aria-controls="workingHours-details" aria-selected="true">Working Hours Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="dailyWork-updates-tab" onclick=" $('span.mb-custom-tab-active').text($(this).text());" data-toggle="tab" href="#dailyWork-updates" role="tab" aria-controls="dailyWork-updates" aria-selected="true">Work Updates</a>
                                </li>
                            </ul>
                        </div>

                        <ul class="nav nav-tabs lg-custom-tabs" id="myTab" role="tablist">
                            <li class="nav-item active">
                                <a class="nav-link active" id="workingHours-details-tab" data-toggle="tab" href="#workingHours-details" role="tab" aria-controls="workingHours-details" aria-selected="true">Working Hours Details</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="dailyWork-updates-tab" data-toggle="tab" href="#dailyWork-updates" role="tab" aria-controls="dailyWork-updates" aria-selected="true">Work Updates</a>
                            </li>
                        </ul>

                        <div class="tab-content myTabContent1" id="myTabContent">

                            <div id="workingHours-details" class="tab-pane fade show active" role="tabpanel" aria-labelledby="workingHours-details-tab">
                                <div class="preloader preloader-2">
                                    <svg class="circular" viewBox="25 25 50 50">
                                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
                                    </svg>
                                </div>
                                <div class="table-responsive box-shadow employee-table-list my-3" id="report_list">
                                    <table class="table display nowrap" style="width:100%" id="workingHours">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Attendance</th>
                                                <th>In</th>
                                                <th>Out</th>
                                                <th>In</th>
                                                <th>Out</th>
                                                <th>Break</th>
                                                <th>Total Time</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="dailyWork-updates" class="tab-pane fade" role="tabpanel" aria-labelledby="dailyWork-updates-tab">
                                <div class="select_month_details">
                                    <div class="preloader preloader-2 report_preloader" style="display:none !important;">
                                        <svg class="circular" viewBox="25 25 50 50">
                                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10">
                                            </circle>
                                        </svg>
                                    </div>
                                    <div class="row simple-info-border" id="workUpdateBox">

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
    <input type="hidden" id="page" name="page" value="1">
    <input type="hidden" id="total_pages" name="total_pages" value="5">
    <!-- login_log_id,employee_id,datetime -->
    <script>
        $('a.nav-link').click(function() {
         $('span.mb-custom-tab-active').text($(this).text());
         var id = $(this).attr('aria-controls');
         $('.tab-pane.fade').removeClass('show active');
         $('a').removeClass('active');
         $('a').parent().removeClass('active');
         $(this).addClass('active');
         var $this = $(this).text();
         $.each($('a.nav-link'), function() {
            if ($(this).text() == $this) {
               $(this).addClass('active');
               $(this).parent().addClass('active');
            }
         });
         $(this).parent().removeClass('active');
         $('#' + id).addClass('show');
      });
    </script>