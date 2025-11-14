jQuery(document).ready(function($) {
    var base_url = $("#js_data").attr("data-base-url");
    var employee_id = "";
    if ($("#employee_id").val()) {
        employee_id = $("#employee_id").val();
    }
    var select_year = "";
    if ($("#select_year").val()) {
        select_year = $("#select_year").val();
    }
    // $('#datatable').dataTable();
    $('.preloader-2').attr('style', 'display:block !important;');
    var table = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ Entries",
            },
        "lengthMenu": [
            [10, 30, 50, 100],
            [10, 30, 50, 100]
        ],
        "pageLength": 30,
        "ajax": {
            "url": base_url + "bonus/employee_pagination",
            "data": function(d) {
                d.employee_id = $("#employee_id").val();
                d.select_year = $("#select_year").val()
            },
            "dataType": "json",
            "type": "POST",
        },
        stateSave: true,
        "columns": [
            { "data": "id" },
            { "data": "bonus" },
            { "data": "month" },
            { "data": "year" },
        ],
        "fixedHeader": true,
        "order": [
            [0, "desc"]
        ]

    });
    $('#example').on('draw.dt', function() {
        $('.preloader-2').attr('style', 'display:none !important;');
    });
    $(document).on('click', '.emp_search', function() {
        $('.preloader-2').attr('style', 'display:block !important;');
        var employee = $('#employee_id').val();
        var year = $('#select_year').val();
        var data = {
            'employee_id': employee,
            'select_year': year,
        }
        $.ajax({
            url: base_url + 'bonus/totle_bouns',
            type: "POST",
            data: data,
            success: function(response) {
                // console.log(response);
                var data = JSON.parse(response);
                if (data.get_employee_total_bonus[0].total_bonus == null) {
                    $('.t-bonus').text("0.00");
                } else {
                    $('.t-bonus').text(data.get_employee_total_bonus[0].total_bonus);
                }
                table.clear();
                table.ajax.reload();
                $('.preloader-2').attr('style', 'display:none !important;');
                return false;
            },
        });
        return false;
    });
    $(document).on('change', '.emp_search1', function() {
        emp_search1();
    });
    emp_search1();

    function emp_search1() {
        $('.preloader-2').attr('style', 'display:block !important;');
        var employee = $('#employee_id').val();
        var year = $('#select_year').val();
        var data = {
            'employee_id': employee,
            'select_year': year,
        }
        $.ajax({
            url: base_url + 'bonus/totle_bouns',
            type: "POST",
            data: data,
            success: function(response) {
                // console.log(response);
                var data = JSON.parse(response);
                if (data.get_employee_total_bonus[0].total_bonus == null) {
                    $('.t-bonus').text("0.00");
                } else {
                    $('.t-bonus').text(data.get_employee_total_bonus[0].total_bonus);
                }
                table.clear();
                table.ajax.reload();
                $('.preloader-2').attr('style', 'display:none !important;');
                return false;
            },
        });
        return false;
    }
    $(document).on('click', '.delete-employee', function() {
        if (confirm("Are you sure?")) {
            jQuery(".loader-text").html("Deleting Designation");
            jQuery(".loader-wrap").show();
            var id = $(this).attr("data-id");
            var emp_id = $(this).attr("data-emp-id");
            var data = {
                'id': id,
                'emp_id': emp_id,
            };
            $.ajax({
                url: base_url + "bonus/delete_employee",
                type: "post",
                data: data,
                success: function(response) {
                    location.reload();
                },

            });
        }
        return false;
    });

});