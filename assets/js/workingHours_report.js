var base_url = $("#js_data").data('base-url');
$('#attendance_report').on('draw.dt', function() {
    $('.preloader.preloader-2').attr('style', 'display: none !important');
});
$(document).ready(function($) {
    var disabledDays = [0, 6];
    $('#date').datepicker({
        onRenderCell: function(date, cellType) {
            if (cellType == 'day') {
                var day = date.getDay(),
                    isDisabled = disabledDays.indexOf(day) != -1;
                return {
                    disabled: isDisabled
                }
            }
        }
    })
    $('#date').datepicker().data('datepicker').selectDate(new Date());
    WorkUpdates();
    // time_search();
    var table = $('#workingHours').DataTable({
        "processing": true,
            "serverSide": true,
            "rowReorder": {
                "selector": 'td:nth-child(2)'
            },
            "responsive": true,
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ Entries",
            },
        "lengthMenu": [
            [10, 30, 50, 100],
            [10, 30, 50, 100]
        ],
        "pageLength": 10,
        "ajax": {
            "url": base_url+"reports/get_workingHours",
            "dataType": "json",
            "type": "POST",
            "data": function(d) {
                d.date = $('#date').val();
            },
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "attendance" },
            { "data": "in" },
            { "data": "out" },
            { "data": "in1" },
            { "data": "out1" },
            { "data": "break" },
            { "data": "total" },
            { "data": "time" },
        ],
        "fixedHeader": true,
        "order": [[1, "desc"] ],
    });
    $('#time_search').click(function(){
        time_search();
        WorkUpdates();
    });
    function time_search() {
        table.clear();
        table.ajax.reload();
    }
    function WorkUpdates(){
        var base_url = $("#js_data").data('base-url');
        var date = $('#date').val();
        var data = {'date': date};
        $.ajax({
            url: base_url + "reports/employeeWorkUpdates",
            type: "post",
            data: data,
            success: function(response) {
                var obj = JSON.parse(response);
                var $html = '';
                $.each(obj,function(i,v){
                    $html += '<div class="col-xl-4 col-md-6">'+
                        '<div class="workUpdate-info">'+
                        '<h4>'+obj[i].fname+' '+obj[i].lname+':-</h4>'+
                        '<p class="whiteSpace-break">'+obj[i].daily_work+'</p>'+
                        '</div>'+
                    '</div>';
                });
                if($html == '') $html += '<div class="simple-info col-12 no-data"><strong>Data not available!</strong></div>';
               $('#workUpdateBox').html($html);
            },
        });
    }
});