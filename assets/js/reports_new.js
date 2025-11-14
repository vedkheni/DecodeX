/*Deposit*/
function get_deposit(page, r) {
    if (r == 'Y') {
        $("#page").val(1);
        // $('.deposit-details').html('<div class="preloader all_report_preloader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /></svg></div>');
    }
    $('.preloader.preloader-2').attr('style', 'display:block !important');
    var year = $("#bonus_year").val();
    var employee_id = $('#employees').val();
    var base_url = $("#js_data").data('base-url');
    $('.export_excel').attr('href', base_url + "export_excel/deposit_excel/" + year);
    var url = base_url + "reports/deposit_onchange";
    $.ajax({
        url: url,
        type: "POST",
        data: { year: year, page: page, employee_id:employee_id },
        success: function(response){
            var text1 = '<div class="row">';
            if(response){
                var obj = JSON.parse(response);
                if(obj.employee_details){
                    $("#total_pages").val(obj.total_no_of_pages);
                    /* var number_details = '<td class="emp_name">No.</td>';
                    var month_details = '<td class="emp_th">Months</td>'; */
                    // var num = "";
                /*  $.each(obj.year_data, function(index, val) {
                        num = index + 1;
                        number_details += '<td>' + num + '</td>';
                        month_details += '<td>' + val + '</td>';
                    });
                    month_details += '<td class="emp_th">Months</td>'; */
                    var employee_details = obj.employee_details;
                    var num = 0;
                    var total_count = 0;
                    $.each(employee_details, function(i1, v1) {
                        text1 += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><table><tbody><tr><td class="emp_name">Month</td>';
                        $.each(obj.year_data[num], function(i2, v2) {
                            text1 += '<td>' + v2 + '</td>';
                        });
                        text1 += '<td class="emp_total">Total</td></tr>';
                        text1 += '<tr><td class="emp_name">' + i1 + '</td>';
                        var count = 0;
                        $.each(obj.year_data[num], function(i2, v2) {
                            var leave = 0;
                            if (employee_details[i1][v2] == undefined) {
                                leave = '-';
                            } else {
                                count += Number(((employee_details[i1][v2]).replace('<span>','')).replace('</span>',''));
                                leave = employee_details[i1][v2];
                                // alert(count);
                            }
                            text1 += '<td>' + leave + '</td>';
                        });
                        if(isNaN(count)){
                            count = 0;
                        }
                        total_count += count;
                        text1 += '<td class="emp_total">' + Number(count).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,') + '</td></tr></tbody></table></div>';
                        num++;
                    });
                    $('#total_count').text(Number(total_count).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,'));
                }else{
                    text1 += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><span class="no-data">Data not available !</span></div>';
                }
            }else{
                text1 += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><table><tbody><tr><td class="emp_name">Data not available !</td></tbody></table></div>';
            }
            text1 += '</div>';
        /*  $.each(employee_details, function(index1, val1) {
                text1 += '<tr><td class="emp_name">' + index1 + '</td>';
                $.each(obj.year_data, function(index, val) {
                    var leave = 0;
                    if (employee_details[index1][val] == undefined) {
                        leave = '-';
                    } else {
                        leave = employee_details[index1][val];
                    }
                    text1 += "<td>" + leave + "</td>";
                });
                text1 += '<td class="emp_name">' + index1 + '</td></tr>';
            }); */

            if (r == 'Y') {
                $(".deposit-details").html(text1);
            } else {
                $(".deposit-details").append(text1);
            }

            // $(".M_name").html(month_details);
            $('td span').each(function(i, chk) {
                if ($(this).hasClass('deposite-paid')) {
                    $(this).closest('td').addClass('deposite-paid');
                    $(this).removeClass('deposite-paid');
                }
            });
            $('.preloader.preloader-2').attr('style', 'display:none !important');
        },
    });
}
/*Bouns*/
function get_bonus(page, r) {
    if (r == 'Y') {
        $("#page").val(1);
        // $('.deposit-details').html('<div class="preloader all_report_preloader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /></svg></div>');
    }
    $('.preloader.preloader-2').attr('style', 'display:block !important');
    var year = $("#bonus_year").val();
    var employee_id = $('#employees').val();
    var base_url = $("#js_data").data('base-url');
    $('.export_excel').attr('href', base_url + "export_excel/bouns_excel/" + year);
    var url = base_url + "reports/bonus_onchange";
    $.ajax({
        url: url,
        type: "POST",
        data: { year: year, page: page, employee_id:employee_id },
        success: function(response) {
            var text1 = '<div class="row">';
            if(response){
                var obj = JSON.parse(response);
                if(obj.employee_details){
                    $("#total_pages").val(obj.total_no_of_pages);
                    /* var number_details = '<td class="emp_name">No.</td>';
                    var month_details = '<td class="emp_th">Months</td>';
                    var num = ""; */
                    /*  $.each(obj.year_data, function(index, val) {
                        // console.log(obj.employee_details[val]);
                        num = index + 1;
                        number_details += '<td>' + num + '</td>';
                        month_details += '<td>' + val + '</td>';
                        
                    });
                    month_details += '<td class="emp_th">Months</td>'; */
                    var employee_details = obj.employee_details;
                    var num = 0;
                    var total_count = 0;
                    $.each(employee_details, function(i1, v1) {
                        text1 += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><table><tbody><tr><td class="emp_name">Month</td>';
                        $.each(obj.year_data[num], function(i2, v2) {
                            text1 += '<td>' + v2 + '</td>';
                        });
                        text1 += '<td class="emp_total">Total</td></tr>';
                        text1 += '<tr><td class="emp_name">' + i1 + '</td>';
                        var count = 0;
                        $.each(obj.year_data[num], function(i2, v2) {
                            var leave = 0;
                            if (employee_details[i1][v2] == undefined) {
                                leave = '-';
                            } else {
                                count += Number((employee_details[i1][v2]).replace( /(^.+)(\w\d+\w)(.+$)/i,'$2')); 
                                leave = employee_details[i1][v2];
                            }
                            text1 += '<td>' + leave + '</td>';
                        });
                        if(isNaN(count)){
                            count = 0;
                        }
                        total_count += count;
                        text1 += '<td class="emp_total">' + Number(count).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,') + '</td></tr></tbody></table></div>';
                        num++;
                    });
                    $('#total_count').text(Number(total_count).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,'));
                }else{
                    text1 += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><span class="no-data">Data not available !</span></div>';
                }
            }else{
                text1 += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><table><tbody><tr><td class="emp_name">Data not available !</td></tbody></table></div>';
            }
                text1 += '</div>';
            /*  $.each(employee_details, function(index1, val1) {
                    text1 += '<tr><td class="emp_name">' + index1 + '</td>';
                    $.each(obj.year_data, function(index, val) {
                        var leave = 0;
                        if (employee_details[index1][val] == undefined) {
                            leave = '-';
                        } else {
                            leave = employee_details[index1][val];
                        }
                        text1 += "<td>" + leave + "</td>";
                    });
                    text1 += '<td class="emp_name">' + index1 + '</td></tr>';
                }); */

                if (r == 'Y') {
                    $(".deposit-details").html(text1);
                } else {
                    $(".deposit-details").append(text1);
                }

                // $(".M_name").html(month_details);
                $('.preloader.preloader-2').attr('style', 'display:none !important');
        },
    });
}

/*Leave*/
function get_leave(page, n) {
    if (n == 'Y') {
        $("#page").val(1);
        //$('.deposit-details').html('<div class="preloader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /></svg></div>');
    }
    $('.preloader.preloader-2').attr('style', 'display:block !important');
    var year = $('#bonus_year').val();
    var employee_id = $('#employees').val();
    var base_url = $("#js_data").data('base-url');
    $('.export_excel').attr('href', base_url + "export_excel/leave_excel/" + year);
    $.ajax({
        url: base_url + "reports/leave_onchange",
        type: "POST",
        data: { year: year, page: page, employee_id:employee_id },
        success: function(response1) {
            /*console.log(response1);*/
            // var month_name = '<td class="emp_th">Months</td>';
            var leave_detail = '<div class="row">';
            var emp_name_detail = '';
            if(response1){
                var data = JSON.parse(response1);
                if(data.emp_detail){
                    /*  $.each(data.year_month, function(i, v) {
                        month_name += '<td>' + v + '</td>';
                    });
                    month_name += '<td class="emp_th">Months</td>'; */
                    var num = 0;
                    var total_count = 0;
                    $.each(data.emp_detail, function(i1, v1) {
                        leave_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><table><tbody><tr><td class="emp_name">Month</td>';
                        $.each(data.year_month[num], function(i2, v2) {
                            leave_detail += '<td>' + v2 + '</td>';
                        });
                        leave_detail += '<td class="emp_total">Total</td></tr>';
                        leave_detail += '<tr><td class="emp_name">' + i1 + '</td>';
                        var count = 0;
                        $.each(data.year_month[num], function(i2, v2) {
                            var leave = 0;
                            if (data.emp_detail[i1][v2] == undefined) {
                                leave = '-';
                            } else {
                                count += Number((data.emp_detail[i1][v2]));
                                leave = data.emp_detail[i1][v2];
                            }
                            leave_detail += '<td>' + leave + '</td>';
                        });
                        if(isNaN(count)){
                            count = 0;
                        }
                        total_count += count;
                        leave_detail += '<td class="emp_total">' + count + '</td></tr></tbody></table></div>';
                        num++;
                    });
                    $('#total_count').text(Number(total_count).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,'));
                }else{
                    leave_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><span class="no-data">Data not available !</span></div>';
                }
            }else{
                leave_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><table><tbody><tr><td class="emp_name">Data not available !</td></tbody></table></div>';
            }
            leave_detail += '</div>';

            /* $.each(data.emp_detail, function(i1, v1) {
                leave_detail += '<tr><td class="emp_name">' + i1 + '</td>';
                $.each(data.year_month, function(i2, v2) {
                    var leave = 0;
                    if (data.emp_detail[i1][v2] == undefined) {
                        leave = '-';
                    } else {
                        leave = data.emp_detail[i1][v2];
                    }
                    leave_detail += '<td>' + leave + '</td>';
                });
                leave_detail += '<td class="emp_name">' + i1 + '</td></tr>';
            }); */
            if (n == 'Y') {
                $(".leave_detail").html(leave_detail);
            } else {
                $(".leave_detail").append(leave_detail);
            }
            // $('.M_name').html(month_name);
            $('.preloader.preloader-2').attr('style', 'display:none !important');
        },
    });
}

/*Use Paid Leave*/
function get_use_paid_leave(page, n) {
    if (n == 'Y') {
        $("#page").val(1);
    }
    $('.preloader.preloader-2').attr('style', 'display:block !important');
    var base_url = $("#js_data").data('base-url');
    var year = $('#bonus_year').val();
    var employee_id = $('#employees').val();
    $('.export_excel').attr('href', base_url + "export_excel/used_paid_leave_excel/" + year);
    $.ajax({
        url: base_url + "reports/paid_leave_onchange1",
        type: "POST",
        data: { year: year, page: page, employee_id:employee_id },
        success: function(response1) {
            /*console.log(response1);*/
            var month_name = '<td class="emp_th">Months</td>';
            var paid_leave_detail = '<div class="row">';
            var emp_name_detail = '';
            if(response1){
                var data = JSON.parse(response1);
                if(data.emp_detail){
                    /* $.each(data.year_month, function(i, v) {
                        month_name += '<td>' + v + '</td>';
                    });
                    month_name += '<td class="emp_th">Months</td>'; */
                    var num = 0;
                    var total_count = 0;
                    $.each(data.emp_detail, function(i1, v1) {
                        paid_leave_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><table><tbody><tr><td class="emp_name">Month</td>';
                        $.each(data.year_month[num], function(i2, v2) {
                            paid_leave_detail += '<td>' + v2 + '</td>';
                        });
                        paid_leave_detail += '<td class="emp_total">Total</td></tr>';
                        paid_leave_detail += '<tr><td class="emp_name">' + i1 + '</td>';
                        var count = 0;
                        $.each(data.year_month[num], function(i2, v2) {
                            var leave = 0;
                            if (data.emp_detail[i1][v2] == undefined) {
                                leave = '-';
                            } else {
                                count += Number((data.emp_detail[i1][v2]).match(/\d+/g));
                                leave = data.emp_detail[i1][v2];
                            }
                            paid_leave_detail += '<td>' + leave + '</td>';
                        });
                        if(isNaN(count)){
                            count = 0;
                        }
                        total_count += count;
                        paid_leave_detail += '<td class="emp_total">' + count + '</td></tr></tbody></table></div>';
                        num++;
                    });
                    $('#total_count').text(Number(total_count).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,'));
                }else{
                    paid_leave_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><span class="no-data">Data not available !</span></div>';
                }
            }else{
                paid_leave_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><table><tbody><tr><td class="emp_name">Data not available !</td></tbody></table></div>';
            }
            paid_leave_detail += '</div>';
           
            /* $.each(data.emp_detail, function(i1, v1) {
                paid_leave_detail += '<tr><td class="emp_name">' + i1 + '</td>';
                $.each(data.year_month, function(i2, v2) {
                    var leave = 0;
                    if (data.emp_detail[i1][v2] == undefined) {
                        leave = '-';
                    } else {
                        leave = data.emp_detail[i1][v2];
                    }
                    paid_leave_detail += '<td>' + leave + '</td>';
                });
                paid_leave_detail += '<td class="emp_name">' + i1 + '</td></tr>';
            }); */
            if (n == 'Y') {
                $(".paid_leave_detail").html(paid_leave_detail);
            } else {
                $(".paid_leave_detail").append(paid_leave_detail);
            }
            // $('.M_name').html(month_name);
            $('td span').each(function(i, chk) {
                if ($(this).hasClass('deposite-paid')) {
                    $(this).closest('td').addClass('deposite-paid');
                    $(this).removeClass('deposite-paid');
                }
                if ($(this).hasClass('deposite-rejected')) {
                    $(this).closest('td').addClass('deposite-rejected');
                    $(this).removeClass('deposite-rejected');
                }
                if ($(this).hasClass('deposite-pending')) {
                    $(this).closest('td').addClass('deposite-pending');
                    $(this).removeClass('deposite-pending');
                }
            });
            $('.preloader.preloader-2').attr('style', 'display:none !important');
        },
    });
}

/* function get_use_paid_leave(page, n) {
    if (n == 'Y') {
        $("#page").val(1);
    }
    var base_url = $("#js_data").data('base-url');
    var year = $('#bonus_year').val();
    $('.export_excel').attr('href', base_url + "export_excel/used_paid_leave_excel/" + year);
    $.ajax({
        url: base_url + "reports/paid_leave_onchange1",
        type: "POST",
        data: { year: year, page: page },
        success: function(response1) {
            var month_name = '<td class="emp_th">Months</td>';
            var paid_leave_detail = '';
            var emp_name_detail = '';
            var data = JSON.parse(response1);
            $.each(data.year_month, function(i, v) {
                month_name += '<td>' + v + '</td>';
            });
            month_name += '<td class="emp_th">Months</td>';
            $.each(data.emp_detail, function(i1, v1) {
                paid_leave_detail += '<tr><td class="emp_name">' + i1 + '</td>';
                $.each(data.year_month, function(i2, v2) {
                    var leave = 0;
                    if (data.emp_detail[i1][v2] == undefined) {
                        leave = '-';
                    } else {
                        leave = data.emp_detail[i1][v2];
                    }
                    paid_leave_detail += '<td>' + leave + '</td>';
                });
                paid_leave_detail += '<td class="emp_name">' + i1 + '</td></tr>';
            });
            if (n == 'Y') {
                $(".paid_leave_detail").html(paid_leave_detail);
            } else {
                $(".paid_leave_detail").append(paid_leave_detail);
            }
            // $('.M_name').html(month_name);
            $('td span').each(function(i, chk) {
                if ($(this).hasClass('deposite-paid')) {
                    $(this).closest('td').addClass('deposite-paid');
                    $(this).removeClass('deposite-paid');
                }
                if ($(this).hasClass('deposite-rejected')) {
                    $(this).closest('td').addClass('deposite-rejected');
                    $(this).removeClass('deposite-rejected');
                }
                if ($(this).hasClass('deposite-pending')) {
                    $(this).closest('td').addClass('deposite-pending');
                    $(this).removeClass('deposite-pending');
                }
            });
        },
    });
} */
/*Prof Tax*/
function get_prof_tax(page, n) {
    if (n == 'Y') {
        $("#page").val(1);
        $('.deposit-details').html('<div class="preloader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /></svg></div>');
    }
    $('.preloader-2').attr('style','display : block !important');
    var year = $('#bonus_year').val();
    var employee_id = $('#employees').val();
    var base_url = $("#js_data").data('base-url');
    $('.export_excel').attr('href', base_url + "export_excel/prof_tax_excel/" + year);
    $.ajax({
        url: base_url + "reports/prof_tax_onchange",
        type: "POST",
        data: { year: year, page: page, employee_id:employee_id },
        success: function(response1) {
            /*console.log(response1);*/
            // var month_name = '<td class="emp_th">Months</td>';
            var prof_tax_detail = '<div class="row">';
            var emp_name_detail = '';
            if(response1){
                var data = JSON.parse(response1);
                if(data.emp_detail){
                    /* $.each(data.year_month, function(i, v) {
                        month_name += '<td>' + v + '</td>';
                    });
                    month_name += '<td class="emp_th">Months</td>'; */
                    var num = 0;
                    var total_count = 0;
                    $.each(data.emp_detail, function(i1, v1) {
                        prof_tax_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><table><tbody><tr><td class="emp_name">Month</td>';
                        $.each(data.year_month[num], function(i2, v2) {
                            prof_tax_detail += '<td>' + v2 + '</td>';
                        });
                        prof_tax_detail += '<td class="emp_total">Total</td></tr>';
                        prof_tax_detail += '<tr><td class="emp_name">' + i1 + '</td>';
                        var count = 0;
                        $.each(data.year_month[num], function(i2, v2) {
                            var leave = 0;
                            if (data.emp_detail[i1][v2] == undefined) {
                                leave = '-';
                            } else {
                                count += Number((data.emp_detail[i1][v2]));
                                leave = data.emp_detail[i1][v2];
                            }
                            prof_tax_detail += '<td>' + leave + '</td>';
                        });
                        if(isNaN(count)){
                            count = 0;
                        }
                        total_count += count;
                        prof_tax_detail += '<td class="emp_total">' + Number(count).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,') + '</td></tr></tbody></table></div>';
                        num++;
                    });
                    $('#total_count').text(Number(total_count).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,'));
                }else{
                    prof_tax_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><span class="no-data">Data not available !</span></div>';
                }
            }else{
                prof_tax_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><table><tbody><tr><td class="emp_name">Data not available !</td></tbody></table></div>';
            }
            prof_tax_detail += '</div>';
            /*  $.each(data.emp_detail, function(i1, v1) {
                prof_tax_detail += '<tr><td class="emp_name">' + i1 + '</td>';
                $.each(data.year_month, function(i2, v2) {
                    var tax = 0;
                    if (data.emp_detail[i1][v2] == 0) {
                        tax = '-';
                    } else if (data.emp_detail[i1][v2] == undefined) {
                        tax = '-';
                    } else {
                        tax = data.emp_detail[i1][v2];
                    }
                    prof_tax_detail += '<td>' + tax + '</td>';
                });
                prof_tax_detail += '<td class="emp_name">' + i1 + '</td></tr>';
            }); */
            if (n == 'Y') {
                $(".prof_tax_detail").html(prof_tax_detail);
            } else {
                $(".prof_tax_detail").append(prof_tax_detail);
            }
            // $('.M_name').html(month_name);
            $('.preloader.preloader-2').attr('style', 'display:none !important');
        },
    });
}

/*Salary*/
function get_salary(page, n) {
    if (n == 'Y') {
        $("#page").val(1);
        $('.deposit-details').html('<div class="preloader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /></svg></div>');
    }
    $('.preloader-2').attr('style','display : block !important');
    var year = $('#bonus_year').val();
    var employee_id = $('#employees').val();
    var base_url = $("#js_data").data('base-url');
    $('.export_excel').attr('href', base_url + "export_excel/salary_excel/" + year);
    $.ajax({
        url: base_url + "reports/salary_onchange",
        type: "POST",
        data: { year: year, page: page, employee_id:employee_id },
        success: function(response1) {
            /*console.log(response1);*/
            // var month_name = '<td class="emp_th">Months</td>';
            var leave_detail = '<div class="row">';
            var emp_name_detail = '';
            if(response1){
                var data = JSON.parse(response1);
                if(data.emp_detail){
                    /* $.each(data.year_month, function(i, v) {
                        month_name += '<td>' + v + '</td>';
                    });
                    month_name += '<td class="emp_th">Months</td>'; */
                    var num = 0;
                    var total_count = 0;
                    $.each(data.emp_detail, function(i1, v1) {
                        leave_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><table><tbody><tr><td class="emp_name">Month</td>';
                        $.each(data.year_month[num], function(i2, v2) {
                            leave_detail += '<td>' + v2 + '</td>';
                        });
                        leave_detail += '<td class="emp_total">Total</td></tr>';
                        leave_detail += '<tr><td class="emp_name">' + i1 + '</td>';
                        var count = 0;
                        $.each(data.year_month[num], function(i2, v2) {
                            var leave = 0;
                            if (data.emp_detail[i1][v2] == undefined) {
                                leave = '-';
                            } else {
                                count += Number((data.emp_detail[i1][v2]));
                                leave = data.emp_detail[i1][v2];
                            }
                            leave_detail += '<td>' + leave + '</td>';
                        });
                        if(isNaN(count)){
                            count = 0;
                        }
                        total_count += count;
                        leave_detail += '<td class="emp_total">' + Number(count).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,') + '</td></tr></tbody></table></div>';
                        num++;
                    });
                    $('#total_count').text(Number(total_count).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,'));
                }else{
                    leave_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><span class="no-data">Data not available !</span></div>';
                }
            }else{
                leave_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><table><tbody><tr><td class="emp_name">Data not available !</td></tbody></table></div>';
            }
            leave_detail += '</div>';
            /* $.each(data.emp_detail, function(i1, v1) {
                leave_detail += '<tr><td class="emp_name">' + i1 + '</td>';
                $.each(data.year_month, function(i2, v2) {
                    var leave = 0;
                    if (data.emp_detail[i1][v2] == undefined) {
                        leave = '-';
                    } else {
                        leave = data.emp_detail[i1][v2];
                    }
                    leave_detail += '<td>' + leave + '</td>';
                });
                leave_detail += '<td class="emp_name">' + i1 + '</td></tr>';
            }); */
            if (n == 'Y') {
                $(".leave_detail").html(leave_detail);
            } else {
                $(".leave_detail").append(leave_detail);
            }
            // $('.M_name').html(month_name);
            $('.preloader.preloader-2').attr('style', 'display:none !important');
        },
    });
}

/*Sick Leave*/
function get_sick_leave(page, n) {
    if (n == 'Y') {
        $("#page").val(1);
        $('.deposit-details').html('<div class="preloader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /></svg></div>');
    }
    $('.preloader-2').attr('style','display : block !important');
    var year = $('#bonus_year').val();
    var employee_id = $('#employees').val();
    var base_url = $("#js_data").data('base-url');
    $('.export_excel').attr('href', base_url + "export_excel/sick_leave_excel/" + year);
    $.ajax({
        url: base_url + "reports/sick_leave_onchange",
        type: "POST",
        data: { year: year, page: page, employee_id:employee_id },
        success: function(response1) {
            /*console.log(response1);*/
            // var month_name = '<td class="emp_th">Months</td>';
            var sick_leave_detail = '<div class="row">';
            var emp_name_detail = '';
            if(response1){
                var data = JSON.parse(response1);
                if(data.emp_detail){
                    /* $.each(data.year_month, function(i, v) {
                        month_name += '<td>' + v + '</td>';
                    });
                    month_name += '<td class="emp_th">Months</td>'; */
                    var num = 0;
                    var total_count = 0;
                    $.each(data.emp_detail, function(i1, v1) {
                        sick_leave_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><table><tbody><tr><td class="emp_name">Month</td>';
                        $.each(data.year_month[num], function(i2, v2) {
                            sick_leave_detail += '<td>' + v2 + '</td>';
                        });
                        sick_leave_detail += '<td class="emp_total">Total</td></tr>';
                        sick_leave_detail += '<tr><td class="emp_name">' + i1 + '</td>';
                        var count = 0;
                        $.each(data.year_month[num], function(i2, v2) {
                            var leave = 0;
                            if (data.emp_detail[i1][v2] == undefined) {
                                leave = '-';
                            } else {
                                count += Number((data.emp_detail[i1][v2]));
                                leave = data.emp_detail[i1][v2];
                            }
                            sick_leave_detail += '<td>' + leave + '</td>';
                        });
                        if(isNaN(count)){
                            count = 0;
                        }
                        total_count += count;
                        sick_leave_detail += '<td class="emp_total">' + count + '</td></tr></tbody></table></div>';
                        num++;
                    });
                    $('#total_count').text(Number(total_count).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,'));
                }else{
                    paid_leave_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><span class="no-data">Data not available !</span></div>';
                }
            }else{
                sick_leave_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><table><tbody><tr><td class="emp_name">Data not available !</td></tbody></table></div>';
            }
            sick_leave_detail += '</div>';
            /*  $.each(data.emp_detail, function(i1, v1) {
                sick_leave_detail += '<tr><td class="emp_name">' + i1 + '</td>';
                $.each(data.year_month, function(i2, v2) {
                    var leave = 0;
                    if (data.emp_detail[i1][v2] == undefined) {
                        leave = '-';
                    } else {
                        leave = data.emp_detail[i1][v2];
                    }
                    sick_leave_detail += '<td>' + leave + '</td>';
                });
                sick_leave_detail += '<td class="emp_name">' + i1 + '</td></tr>';
            }); */
            if (n == 'Y') {
                $(".sick_leave_detail").html(sick_leave_detail);
            } else {
                $(".sick_leave_detail").append(sick_leave_detail);
            }
            // $('.M_name').html(month_name);
            $('.preloader.preloader-2').attr('style', 'display:none !important');
        },
    });
}

/*Paid Leave*/
function get_paid_leave(page, n) {
    if (n == 'Y') {
        $("#page").val(1);
        $('.deposit-details').html('<div class="preloader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /></svg></div>');
    }
    $('.preloader-2').attr('style','display : block !important');
    var year = $('#bonus_year').val();
    var employee_id = $('#employees').val();
    var base_url = $("#js_data").data('base-url');
    $('.export_excel').attr('href', base_url + "export_excel/paid_leave_excel/" + year);
    $.ajax({
        url: base_url + "reports/paid_leave_onchange",
        type: "POST",
        data: { year: year, page: page,employee_id:employee_id  },
        success: function(response1) {
            /*console.log(response1);*/
            // var month_name = '<td class="emp_th">Months</td>';
            var paid_leave_detail = '<div class="row">';
            var emp_name_detail = '';
            if(response1){
                var data = JSON.parse(response1);
                if(data.emp_detail){
                /*  $.each(data.year_month, function(i, v) {
                        month_name += '<td>' + v + '</td>';
                    });
                    month_name += '<td class="emp_th">Months</td>'; */
                    var num = 0;
                    var total_count = 0;
                    $.each(data.emp_detail, function(i1, v1) {
                        paid_leave_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><table><tbody><tr><td class="emp_name">Month</td>';
                        $.each(data.year_month[num], function(i2, v2) {
                            paid_leave_detail += '<td>' + v2 + '</td>';
                        });
                        paid_leave_detail += '<td class="emp_total">Total</td></tr>';
                        paid_leave_detail += '<tr><td class="emp_name">' + i1 + '</td>';
                        var count = 0;
                        $.each(data.year_month[num], function(i2, v2) {
                            var leave = 0;
                            if (data.emp_detail[i1][v2] == undefined) {
                                leave = '-';
                            } else {
                                count += Number((data.emp_detail[i1][v2]));
                                leave = data.emp_detail[i1][v2];
                            }
                            paid_leave_detail += '<td>' + leave + '</td>';
                        });
                        if(isNaN(count)){
                            count = 0;
                        }
                        total_count += count;
                        paid_leave_detail += '<td class="emp_total">' + count + '</td></tr></tbody></table></div>';
                        num++;
                    });
                    $('#total_count').text(Number(total_count).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,'));
                }else{
                    paid_leave_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><span class="no-data">Data not available !</span></div>';
                }
            }else{
                paid_leave_detail += '<div class="col-xs-12 col-md-6 col-lg-4 col-xl-3"><span class="no-data">Data not available !</span></div>';
            }
            paid_leave_detail += '</div>';
            /* $.each(data.emp_detail, function(i1, v1) {
                paid_leave_detail += '<tr><td class="emp_name">' + i1 + '</td>';
                $.each(data.year_month, function(i2, v2) {
                    var leave = 0;
                    if (data.emp_detail[i1][v2] == undefined) {
                        leave = '-';
                    } else {
                        leave = data.emp_detail[i1][v2];
                    }
                    paid_leave_detail += '<td>' + leave + '</td>';
                });
                paid_leave_detail += '<td class="emp_name">' + i1 + '</td></tr>';
            }); */
            if (n == 'Y') {
                $(".reports_detail").html(paid_leave_detail);
            } else {
                $(".reports_detail").append(paid_leave_detail);
            }
            // $('.M_name').html(month_name);
            $('.preloader.preloader-2').attr('style', 'display:none !important');
        },
    });
}