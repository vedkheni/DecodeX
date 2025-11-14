jQuery(document).ready(function($) {
    $('#fdate').data('datepicker');
    $('#tdate').data('datepicker');

    function checkDate(start, end) {

        var mStart = moment(start);

        var mEnd = moment(end);

        return mStart.isBefore(mEnd);

    }

    var table = $('#attendance_report').DataTable({
        "lengthMenu": [
            [10, 30, 50, 100],
            [10, 30, 50, 100]
        ],
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ Entries",
            },
        "pageLength": 30,
        "ajax": {
            "url": "reports/attendance_report",
            "dataType": "json",
            "type": "POST",
            "data": function(d) {
                d.employees = $("#employees").val();
                d.search_dropdwon = $("#search_dropdwon").val();
                d.from_date = $("#fdate").val();
                // d.to_date = $("#tdate").val();
            },
        },
        "columns": [
            { "data": "#" },
            { "data": "date" },
            { "data": "attendance" },
            { "data": "in" },
            { "data": "out" },
            { "data": "in1" },
            { "data": "out1" },
            { "data": "total" },
            { "data": "time" },
        ],
        "fixedHeader": true,
        "order": [
            [1, "desc"]
        ],
    });
    $('#attendance_report').on('draw.dt', function() {
        $('.preloader.preloader-2').attr('style', 'display: none !important');
    });
    $('#search_dropdwon').change(function() {
        $('.preloader-2').attr('style', 'display:block !important;');
        // $('#fdate').datepicker().data('datepicker').clear();
        search_form();
        // $('.preloader-2').attr('style', 'display:none !important;');
    });
    $('#employees').change(function() {
        $('.preloader-2').attr('style', 'display:block !important;');
        var emp_id = $(this).val();
        $(this).prop('disabled', true);
        var data = {
            'id': emp_id,
        };
        $.ajax({
            url: "employee/get_employee_detail",
            type: "post",
            data: data,
            success: function(response) {
                var obj = JSON.parse(response);
                $(".h4_name").text('Name : ' + obj.emp_detail[0].fname + ' ' + obj.emp_detail[0].lname + ' (' + obj.emp_detail[0].name + ')');
                $('#employees').prop('disabled', false);
                table.clear();
                table.ajax.reload();
                $('.preloader-2').attr('style', 'display:none !important;');
            },
        });
        $('.preloader-2').attr('style', 'display:block !important;');
        search_form();
        // $('.preloader-2').attr('style', 'display:none !important;');
    });
    /* $('#tdate').change(function() {
        $('.preloader-2').attr('style', 'display:block !important;');
        search_form();
        // $('.preloader-2').attr('style', 'display:none !important;');
    }); */
    $('#fdate').change(function() {
        $('.preloader-2').attr('style', 'display:block !important;');
        $('#search_dropdwon option:eq(0)').prop('selected', true);
        search_form();
        // $('.preloader-2').attr('style', 'display:none !important;');
    });
    /*  $('#tdate').datepicker({
         language: 'en',
         onSelect: function onSelect(fd, date) {
             search_form();
         }
     }) */
    $('#fdate').datepicker({
        language: 'en',
        onSelect: function onSelect(fd, date) {
            $('#search_dropdwon option:eq(0)').prop('selected', true);
            search_form();
        }
    })

    function search_form_submit() {
        $('.preloader.preloader-2').attr('style', 'display: block !important');
        table.clear();
        table.ajax.reload();
        // $('.preloader.preloader-2').attr('style', 'display: none !important');
    }
$('#search-form').submit(function(e){
    e.preventDefault();
    search_form();
    return false;
});
    function search_form() {
        var fdate = $("#fdate").val();

        /* var tdate = $("#tdate").val(); */

        var search_dropdwon = $("#search_dropdwon").val();

        if (!search_dropdwon) {

            // if (!fdate || !tdate) {
            if (!fdate) {

                // e.preventDefault();

                if (!fdate) {

                    $("#fdate").addClass('error');

                } else {

                    $("#fdate").removeClass('error');

                }

                /* if (!tdate) {

                    $("#tdate").addClass('error');

                } else {

                    $("#tdate").removeClass('error');

                } */
                $('.preloader-2').attr('style', 'display:none !important;');
                return false;

            } else {

                $("#fdate").removeClass('error');

                // $("#tdate").removeClass('error');

                $("#search_dropdwon").val('');

                search_form_submit();
                return false;

            }

        } else {

            if (!search_dropdwon) {

                // var validtion = checkDate(fdate, tdate);
                var validtion = checkDate(fdate);

                if (validtion == false) {

                    $('.error_msg').html('<span style="color:red;">End date should not be less than start date </span>');
                    $('.preloader-2').attr('style', 'display:none !important;');
                    return false;



                } else {

                    $('.error_msg').html("");

                    // $('#search-form').submit();
                    search_form_submit()
                    return false;

                }

                $("#search_dropdwon").val('');



            } else {

                $("#fdate").val('');

                // $("#tdate").val('');
                /* $('#search-form').submit();
                return true; */
                search_form_submit()
                return false;

            }
        }

    }


});