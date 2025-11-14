var base_url = $("#js_data").data('base-url');
$('.preloader-2').attr('style', 'display:block !important');
var table = $('#example').DataTable({
    "oLanguage": {
        "sLengthMenu": "Show _MENU_ Entries",
        },
    "processing": true,
    "serverSide": true,
    "rowReorder": {
        "selector": 'td:nth-child(2)'
    },
    "responsive": true,
    "lengthMenu": [
        [10, 30, 50, 100],
        [10, 30, 50, 100]
    ],
    "pageLength": 30,
    "ajax": {
        "url": "mail_content/get_content_list",
        "dataType": "json",
        "type": "POST",
        "data": function(d) {

        },
    },
    stateSave: true,
    "columns": [
        { "data": "#"},
        { "data": "name" },
        { "data": "slug" },
        { "data": "action" },
        // { "data": "status" },

    ],
    "fixedHeader": true,
    "columnDefs": [
        { "orderable": false, "targets": [0, 3,] }
    ]
});
table.order([1, 'desc']).draw();
$('#example').on('draw.dt', function() {
    $(document).on('click', '.edit_mail_content', function() {
        edit_mail_content($(this));
    });
    $('.preloader-2').attr('style', 'display:none !important');
});
$(document).on('click', '.delete_mail_content', function() {
    delete_mail_content($(this));
});
$(document).on('click', '.btn-open-desig', function() {
    $('.mail_content').text('Add');
});

function edit_mail_content($this) {
    $('.preloader-2').attr('style', 'display:block !important');
    var id = $this.data('id');
    var data = {
        'id': id,
    };
    $.ajax({
        url: base_url + 'mail_content/get_mail_content',
        type: 'post',
        data: data,
        success: function(response) {
            var obj = JSON.parse(response);
            CKEDITOR.instances['mail_content'].setData(obj.mail_content[0].content);
            $('#name').val(obj.mail_content[0].name);
            $('#id').val(obj.mail_content[0].id);
            $('#mail_slug').val(obj.mail_content[0].slug);   
            $('#slug').val(obj.mail_content[0].slug);
            $('.mail_content').text('Update');
            // $('#id').val(id);
            // $('.edit_modal').click();
            $('#myModal').modal('show');
            $('.preloader-2').attr('style', 'display:none !important');
        }
     });
}
function delete_mail_content($this) {
    if (confirm("Are you sure want to delete?")) {
        $('.preloader-2').attr('style', 'display:block !important');
        var id = $this.data('id');
        var data = {
            'id': id,
        };
        $.ajax({
            url: base_url + 'mail_content/delete_mail_content',
            type: 'post',
            data: data,
            success: function(response) {
                var obj = JSON.parse(response);
                if(obj.error_code == 0){
                    $('.msg-container').html(obj.message);
                    $('.msg-container .msg-box').attr('style', 'display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style', 'display:none');
                    }, 6000);
                    table.clear();
                    table.ajax.reload();
                }else{
                    $('.msg-container').html(obj.message);
                    $('.msg-container .msg-box').attr('style', 'display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style', 'display:none');
                    }, 6000);
                    $('.preloader-2').attr('style', 'display:none !important');
                }
            }
        });
    }
}
$(document).on('click', '.mail_content', function() {
    $('.preloader-2').attr('style', 'display:block !important');
    var name = $('#name').val();
    var id = $('#id').val();
    var desc = CKEDITOR.instances.mail_content.getData();
    var mail_slug = $('#mail_slug').val();
    var slug = $('#slug').val();

    var data = {
        'id': id,
        'name': name,
        'mail_content': desc,
        'mail_slug': mail_slug,
        'slug': slug,
    };
    $.ajax({
        url: base_url + 'mail_content/update_content',
        type: 'post',
        data: data,
        success: function(response) {
            console.log(response);
            var obj = JSON.parse(response);
            if(obj.error_code == 0){
               reset_form();
                $('.close').click();
                $('.mail_content').text('Add');
                $('.msg-container').html(obj.message);
                $('.msg-container .msg-box').attr('style', 'display:block');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style', 'display:none');
                }, 6000);
                table.clear();
                table.ajax.reload();
            }else{
                $('.msg-container').html(obj.message);
                $('.msg-container .msg-box').attr('style', 'display:block');
                setTimeout(function() {
                    $('.msg-container .msg-box').attr('style', 'display:none');
                }, 6000);
                $('.preloader-2').attr('style', 'display:none !important');
            }
            console.log(response);
        }
    });
});

  function reset_form(){
    CKEDITOR.instances['mail_content'].setData('');
    $('#mail_slug').val('');
    $('#slug').val('');
    $('#name').val('');
    $('#id').val('');
  }