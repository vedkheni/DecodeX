$('#search_year').change(function() {
    var mindate = new Date('01-01-' + $(this).val());
    var maxdate = new Date('12-01-' + $(this).val());

    $('#holiday_date').datepicker({
        language: 'en',
        dateFormat: $('#js_data').data('dateformat'),
        minDate: mindate,
        maxDate: maxdate,
    });
});
$('.preloader.preloader-2').attr('style', 'display: block !important');
var table = $('#example').DataTable({
    "oLanguage": {
        "sLengthMenu": "Show _MENU_ Entries",
        },
    "processing": true,
    "serverSide": true,
    "lengthMenu": [
        [10, 30, 50, 100],
        [10, 30, 50, 100]
    ],
    "pageLength": 30,
    "ajax": {
        "url": "get_holiday_list",
        "dataType": "json",
        "type": "POST",
        "data": function(d) {
            d.year = $("#search_year").val();
        },
    },
    stateSave: true,
    "columns": [
        { "data": "#" },
        { "data": "holiday_date" },
        { "data": "title" },
        { "data": "action" },

    ],
    // "fixedHeader": {headerOffset: 10},
    "fixedHeader": true,
    "order": [
        [1, "desc"]
    ],
    "columnDefs": [{
        "targets": [0],
        "orderable": false,
    }],
});
$('#example').on('draw.dt', function() {
    $('.preloader-2').attr('style', 'display:none !important;');
});

jQuery(document).ready(function($) {
    var mindate = new Date('01-01-' + $('#search_year').val());
    var maxdate = new Date('12-31-' + $('#search_year').val());
    $('#holiday_date').datepicker({
        language: 'en',
        dateFormat: $('#js_data').data('dateformat'),
        minDate: mindate,
        maxDate: maxdate,
    });



    function daysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

    $("#search_year").change(function() {
        table.clear();
        table.ajax.reload();
        /*  var year = $(this).find("option:selected").val();
         var base_url = $("#js_data").data('base-url');
         // alert(year);
         // window.location="<?php //echo base_url('holiday/add/'); ?>"+year;
         var url = base_url + "holiday/get_data_by_year";
         $.ajax({
             url: url,
             type: "get",
             data: { year: year },
             success: function(data1, response) {
                 // console.log(response);
                 // console.log(data);
                 var html = '';
                 var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                 var data = JSON.parse(data1);
                 if (data.list_data.length <= 0) {
                     $('#e_id').val('');
                     $('.field_wrapper').html('');
                     $('.submit_form1').html('Add');
                     html += '<div><input type="hidden" name="holiday_id[]" id="holiday_id" value=""><div class="form-group"><div class="row"><div class="col-md-4"><div class="single-field select-field"><select class=" select_day select_day1" id="select_day" name="select_day[]" ><option>Day</option>';
                     for (var j = 1; j <= 31; j++) {
                         html += '<option value="' + j + '">' + j + '</option>';
                     }
                     html += '</select><label>Day</label></div></div><div class="col-md-4"><div class="single-field select-field"><select class=" select_month select_month1" id="select_month" name="select_month[]" ><option>Month</option>';
                     $.each(monthNames, function(ind, val) {
                         html += '<option value="' + (ind + 1) + '">' + val + '</option>';
                     });
                     html += '</select><label>Month</label></div></div><div class="col-md-4"><div class="single-field"><input type="text" name="title[]" id="title" class="title title1 " value=""/><label>Title</label></div></div></div></div></div>';
                     // html += '<a href="javascript:void(0);" class="remove_button pull-right" title="Remove"></a></div></div>';
                 } else {
                     $('#e_id').val(data.list_data[0].id);
                     $('.submit_form1').html('Update');
                     $('.field_wrapper').html('');
                     var cls = 1;
                     var i = 1;
                     $.each(data.list_data, function(index, value) {
                         var d = new Date(value.holiday_date);
                         var day_number = d.getDate();
                         var month_number = d.getMonth() + 1;
                         var days_join = 31;
                         if (month_number !== '' && data.year !== '') {
                             days_join = daysInMonth(month_number, data.year);
                         }
                         html += '<div id="holiday-class-' + value.id + '"><div class="form-group" id="' + cls + '"><div class="row"><input type="hidden" name="holiday_id[]" id="holiday_id" value="' + value.id + '"><div class="col-md-4"><div class="single-field select-field"><select class=" select_day select_day_update days' + value.id + '" id="select_day" name="select_day_update[' + value.id + ']"  ><option>Day</option>';
                         for (var m = 1; m <= days_join; m++) {
                             var selected = '';
                             if (day_number == m) { selected = "selected"; }
                             html += '<option ' + selected + ' value="' + m + '">' + m + '</option>';
                         }
                         html += '</select><label>Day</label></div></div><div class="col-md-4"><div class="single-field select-field"><select  data-did="' + value.id + '" class=" select_month select_month_update" id="select_month" name="select_month_update[' + value.id + ']" ><option>Month</option>';
                         $.each(monthNames, function(ind, val) {
                             var selected1 = '';
                             if (month_number == ind + 1) { selected1 = "selected"; }
                             html += '<option ' + selected1 + ' value="' + (ind + 1) + '">' + val + '</option>';
                         });
                         html += '</select><label>Month</label></div></div><div class="col-md-4"><div class="single-field"><input type="text" name="title_update[' + value.id + ']" id="title" class="title title_update " value="' + value.title + '"/><label>Title</label></div></div>';
                         if (i == 1) {} else {
                             html += '<a href="javascript:void(0);" class="remove_button pull-right" title="Remove" data-hid="' + value.id + '"></a>';
                         }
                         html += '</div></div></div>';
                         i++;
                         cls++;
                     });
                     // alert(data.year);
                     // alert(data.list_data[0].id);
                     // alert("okk");
                 }
                 $('.field_wrapper').html(html);
             },
         }); */
    });
    // $('#datatable').dataTable();

    /*$('#example').DataTable({

            "processing": true,

            "serverSide": true,

            "lengthMenu": [ [10, 25, 50, 100], [10, 25, 50, 100] ],

            "pageLength": 10,

            "ajax":{

             "url": "designation/employee_pagination",

             "dataType": "json",

             "type": "POST",

            

                           },

            stateSave: true,               

              "columns": [

                  { "data": "id" },

                  { "data": "name" },

                  { "data": "action" }, 

                

               ],

                "order": [[ 0, "desc" ]]                   



    });*/

    $(document).on('click', '.remove_button', function() {
        var base_url = $("#js_data").data('base-url');
        if ($(this).attr("data-hid")) {
            if (confirm("Are you sure want to delete Holiday?")) {

                jQuery(".loader-text").html("Deleting Designation");

                jQuery(".loader-wrap").show();

                var id = $(this).attr("data-hid");

                var data = {

                    'id': id,

                };

                $.ajax({

                    url: base_url + "holiday/delete_holiday",

                    type: "post",

                    data: data,

                    success: function(response) {
                        console.log(response);
                        // $("#holiday_massage").html('');
                        $("#holiday-class-" + id).remove();
                        //$(this).parent('div').remove();
                        //$("holiday-class-3").html("");
                    },



                });

            }
        } else {
            $(this).parent('div').remove();
        }
        return false;

    });


    var count = count1 = count2 = 0;
    $(document).on('click', '.submit_form1', function() {
        var select_month = [];
        $('.select_month1').each(function(index, value) {

            if ($(this).val() == "") {
                // $("#holiday_massage").html('');
                $(this).addClass('error');

                count = 1;

            } else {

                $(this).removeClass('error');

                count = 0;
                //  $('.select_month_add').each(function (index1, value1) {
                //   select_month[index1]=$(this).val();
                // });
                $('.select_month1').each(function(index1, value) {
                    select_month[index1] = $(this).val();
                });


            }

            // console.log('div' + index + ':' + $(this).attr('id'));

        });
        var select_day = [];
        $('.select_day1').each(function(index, value) {

            if ($(this).val() == "") {
                // $("#holiday_massage").html('');
                $(this).addClass('error');

                count2 = 1;

            } else {

                $(this).removeClass('error');

                count2 = 0;
                // $('.select_day_add').each(function (index1, value1) {
                // select_day[index1]=$(this).val();
                //  });
                $('.select_day1').each(function(index, value) {
                    select_day[index] = $(this).val();
                });
                // select_day[index]=$(this).val();
            }

            // console.log('div' + index + ':' + $(this).attr('id'));

        });

        $('.title').each(function(index, value) {

            if ($(this).val() == "") {
                // $("#holiday_massage").html('');
                $(this).addClass('error');

                count1 = 1;

            } else {

                $(this).removeClass('error');

                count1 = 0;

            }

        });
        if (count == 0 && count1 == 0 && count2 == 0) {
            $(".select_day").val();
            var data = {
                'select_month': select_month,
                'select_day': select_day,
                'search_year': $("#search_year").val(),
            };
            var base_url = $('#js_data').data('base-url');
            $.ajax({
                url: base_url + "holiday/get_exists_holiday_date",
                type: "post",
                data: data,
                success: function(response1) {
                    console.log(response1);
                    if (response1 == "success") {
                        //$('.error_msg').html("");
                        console.log("If");
                        form_submit();
                        // $('#holiday-form').submit();
                        return true;
                    } else {
                        console.log("else");
                        // $("#holiday_massage").html('');
                        $('.msg-container').html('<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' + response1 + '</p></div></div></div>');
                        $('.msg-container .msg-box').attr('style', 'display:block');
                        setTimeout(function() {
                            $('.msg-container .msg-box').attr('style', 'display:none');
                        }, 6000);
                        return false;
                    }
                },
            });
        } else {
            return false;
        }
    });
});
$(document).on('click', '.edit-holiday', function() {
    $('#holiday_date').datepicker({
        multipleDates: false,
    });
    $('#holiday_date').datepicker().data('datepicker').clear();
    var id = $(this).data('holiday_id');
    var title = $(this).data('holiday_title');
    var date = $(this).data('holiday_date');
    $('#holiday_title').val(title);
    $('#holiday_id').val(id);
    $('#holiday_date').val(GetFormattedDate(date));
    $('#hidden_date').val(date);
    $('#title').text('Edit Holiday');
    $('.add-holiday').attr('title','Edit Holiday');
    $('.add-holiday').text('Edit Holiday');
    $('.add_holiday_btn1').click();
});
$(document).on('click', '.add_holiday_btn', function() {
    $('#holiday_date').datepicker({
        multipleDates: true,
    });
    $('#holiday_date').datepicker().data('datepicker').clear();
    $('#holiday_title').val('');
    $('#holiday_id').val('');
    $('#holiday_date').val('');
    $('#hidden_date').val('');
    $('#title').text('Add Holiday');
    $('.add-holiday').text('Add Holiday');
});

function form_submit() {
    var base_url = $('#js_data').data('base-url');
    var e_id = $('#e_id').val();
    var search_year = $('#search_year').val();
    // alert(search_year);
    var holiday_id = [];
    $('input[name^=holiday_id]').each(function(i1, v1) {
        holiday_id[i1] = $(this).val();
    });

    var title_update = [];
    $('input[name^=title_update]').each(function(i2, v2) {
        title_update[i2] = $(this).val();
    });

    var select_day_update = [];
    $('.select_day_update').each(function(i3, v3) {
        select_day_update[i3] = $(this).val();
    });

    var select_month_update = [];
    $('.select_month_update').each(function(i4, v4) {
        select_month_update[i4] = $(this).val();
    });

    var title = [];
    $('.title1').each(function(i5, v5) {
        title[i5] = $(this).val();
    });

    var select_day = [];
    $('.select_day1').each(function(i6, v6) {
        select_day[i6] = $(this).val();
    });

    var select_month = [];
    $('.select_month1').each(function(i7, v7) {
        select_month[i7] = $(this).val();
    });

    if (title.length > 0 && select_day.length > 0 && select_month.length > 0) {
        var data = {
            "e_id": e_id,
            "search_year": search_year,
            "holiday_id": holiday_id,
            "select_day_update": select_day_update,
            "select_month_update": select_month_update,
            "title_update": title_update,
            "select_day": select_day,
            "select_month": select_month,
            "title": title,
        }
    } else {
        var data = {
            "e_id": e_id,
            "search_year": search_year,
            "holiday_id": holiday_id,
            "select_day_update": select_day_update,
            "select_month_update": select_month_update,
            "title_update": title_update,
        }
    }
    console.log(data);
    $.ajax({
        url: base_url + "holiday/insert_data1",
        type: "get",
        data: data,
        success: function(data1) {
            var data = JSON.parse(data1);
            if (data.id) {
                var i = 0;
                $(".remove_button").each(function(i1, v1) {
                    if (!$(this).attr("data-hid")) {
                        // $(this).each(function(i,v){
                        $(this).attr("data-hid", data.id[i]);
                        $(this).closest(".form-group").parent('div').attr("id", "holiday-class-" + data.id[i]);
                        $(this).parent('div').find('.select_month_add').attr("data-hid", data.id[i]);
                        $(this).parent('div').find('.select_day1').removeClass("select_day1 select_day_add").addClass("select_day_update days" + data.id[i]);
                        $(this).parent('div').find('.select_month1').removeClass("select_month1 select_month_add").addClass("select_month_update");
                        $(this).parent('div').find('.title1').removeClass("title1").addClass("title_update");
                        $("#holiday-class-" + data.id[i] + " div.form-group").append('<input type="hidden" name="holiday_id[]" id="holiday_id" value="' + data.id[i] + '">');
                        $(this).parent('div').find('.title_update').attr('value', data.title[i]);
                        $(this).parent('div').find('.title_update').attr('name', 'title_update[' + data.id[i] + ']');
                        // });
                        i++;
                    }
                });
            }
            $('#holiday_date').datepicker().data('datepicker').clear();
            $(".submit_form1").text('Update');
            $(".error_msg").html('');
            $(".msg-container").html(data.msg);
            $('.msg-container .msg-box').attr('style', 'display:block');
            setTimeout(function() {
                $('.msg-container .msg-box').attr('style', 'display:none');
            }, 6000);
            return false;
        },
    });
}

$(document).on('click', '.delete-holiday', function() {
    if (confirm("Are you sure want to delete?")) {
        $('.preloader.preloader-2').attr('style', 'display: block !important');
        var id = $(this).data('holiday_id');
        var holiday_dates = $('#holiday_date').val();
        var data = {
            "holiday_id": id,
            "holiday_dates": holiday_dates,
        }
        var base_url = $('#js_data').data('base-url');
        $.ajax({
            url: base_url + "holiday/delete_data",
            type: "post",
            data: data,
            success: function(data1) {
                var data = JSON.parse(data1);
                // $(".submit_form1").text('Update');
                $('.add-holiday').attr('disabled', false);
                table.clear();
                table.ajax.reload();
                $(".close_popup").click();
                $('.preloader.preloader-2').attr('style', 'display: none !important');
                $(".error_msg").html('');
                $(".msg-container").html(data.msg);
                $('.msg-container .msg-box').attr('style', 'display:block');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style', 'display:none');
                }, 6000);
                return false;
            },
        });
    }
});
$(document).on('click', '.add-holiday', function() {
    form_submit1();
});

function form_submit1() {
    $('.preloader.preloader-2').attr('style', 'display: block !important');
    var base_url = $('#js_data').data('base-url');
    var holiday_id = $('#holiday_id').val();
    var search_year = $('#search_year').val();
    var holiday_title = $('#holiday_title').val();
    var holiday_dates = $('#holiday_date').val();
    var hidden_date = $('#hidden_date').val();
    var num = 0;
    if (holiday_dates == '') {
        $('#holiday_date').addClass('error');
        num++;
    } else {
        $('#holiday_date').removeClass('error');
    }
    if(text_validate(holiday_title) == true) {
        $('#holiday_title').removeClass('error');
    }else{
        $('#holiday_title').addClass('error');
        num++;
    }
    if (num == 0) {
        $('.add-holiday').prop('disabled', true);
        var data = {
            "holiday_id": holiday_id,
            "search_year": search_year,
            "holiday_dates": holiday_dates,
            "hidden_date": hidden_date,
            "title": holiday_title,
        }
        console.log(data);
        $.ajax({
            url: base_url + "holiday/insert_data",
            type: "post",
            data: data,
            success: function(data1) {
                var data = JSON.parse(data1);
                // $(".submit_form1").text('Update');
                $('.add-holiday').prop('disabled', false);
                table.clear();
                table.ajax.reload();
                $(".close_popup").click();
                $('.preloader.preloader-2').attr('style', 'display: none !important');
                $(".error_msg").html('');
                $(".msg-container").html(data.msg);
                $('.msg-container .msg-box').attr('style', 'display:block');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style', 'display:none');
                }, 6000);
                return false;
            },
        });
    } else {
        $('.preloader.preloader-2').attr('style', 'display: none !important');
        return false;
    }
}