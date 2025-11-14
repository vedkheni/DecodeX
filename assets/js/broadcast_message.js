var base_url = $("#js_data").data('base-url');

function getFileData(myFile){
    var file = myFile.files[0];  
    var filename = file.name;
    $('#upload-text span').text(filename);
}
$('#expiryDate').datepicker({
    dateFormat: 'dd M, yyyy',
    language: 'en',
 });
$('#eventDate').datepicker({
    dateFormat: 'dd M, yyyy',
    language: 'en',
 });

 $('.preloader-2').attr('style', 'display:block !important');

var table = $('#broadcastMessageTable').DataTable({
    "processing": true,
    "oLanguage": {
        "sLengthMenu": "Show _MENU_ Entries",
        },
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
        "url": "broadcast/getMessageList",
        "dataType": "json",
        "type": "POST",
        "data": function(d) {

        },
    },
    stateSave: true,
    "columns": [
        { "data": "#"},
        { "data": "title" },
        { "data": "event_date" },
        { "data": "message" },
        { "data": "expiry_date" },
        { "data": "action" },
        // { "data": "status" },

    ],
    "fixedHeader": true,
    "columnDefs": [
        { "orderable": false, "targets": [0, 4,] }
    ]
});

table.order([1, 'desc']).draw();

$('#broadcastMessageTable').on('draw.dt', function() {
    $(document).on('click', '.editBroadcastMessage', function() {
        editBroadcastMessage($(this));
    });
    $('.preloader-2').attr('style', 'display:none !important');
});

$(document).on('click', '.deleteBroadcastMessage', function() {
    deleteBroadcastMessage($(this));
});

$(document).on('click', '.btn-open-desig', function() {
    $('.mail_content').text('Add');
});
$(document).on('click', '.broadcastSendMail', function() {
    broadcastSendMail($(this));
});
function broadcastSendMail($this) {
    $('.preloader-2').attr('style', 'display:block !important');
    var id = $this.data('id');
    var data = {
        'id': id,
    };
    $.ajax({
        url: base_url + 'broadcast/broadcastSendMail',
        type: 'post',
        data: data,
        success: function(response) {
            var obj = JSON.parse(response);
            $('.msg-container').html(obj.message);
            $('.msg-container .msg-box').attr('style', 'display:block');
            setTimeout(function() {
                $('.msg-container .msg-box').attr('style', 'display:none');
            }, 6000);
            $('.preloader-2').attr('style', 'display:none !important');
        }
     });
}

function editBroadcastMessage($this) {
    $('.preloader-2').attr('style', 'display:block !important');
    var id = $this.data('id');
    var data = {
        'id': id,
    };
    $.ajax({
        url: base_url + 'broadcast/getBroadcastMessage',
        type: 'post',
        data: data,
        success: function(response) {
            var obj = JSON.parse(response);
            if(obj.broadcastMessage != ''){
                $('#title').val(obj.broadcastMessage[0].title);
                $('#id').val(obj.broadcastMessage[0].id);
                $('#broadcastMessage').val(obj.broadcastMessage[0].message);
                if(obj.broadcastMessage['image'] != ''){
                    $('#upload_attachment').val(obj.broadcastMessage[0].attachment);
                    $('#upload-text').parent('div').append('<a target="_blank" class="view_resume" id="view_resume" data-tooltip="View Attachment" href="'+obj.broadcastMessage['image']+'"><i class="fas fa-eye"></i></a>');
                }else{
                    $('#upload_attachment').val('');
                }
                if(obj.broadcastMessage[0].expiry_date && new Date(obj.broadcastMessage[0].expiry_date) != 'Invalid Date'){
                    $('#expiryDate').val(obj.broadcastMessage[0].expiry_date);
                    $('#expiryDate').datepicker().data('datepicker').selectDate(new Date(obj.broadcastMessage[0].expiry_date));
                }
                if(obj.broadcastMessage[0].event_date && new Date(obj.broadcastMessage[0].event_date) != 'Invalid Date'){
                    $('#eventDate').val(obj.broadcastMessage[0].event_date);
                    $('#eventDate').datepicker().data('datepicker').selectDate(new Date(obj.broadcastMessage[0].event_date));
                }
                $('.broadcastMessage').text('Update');
                // $('#id').val(id);
                // $('.edit_modal').click();
                $('#broadcastMessageModal').modal('show');
            }
            $('.preloader-2').attr('style', 'display:none !important');
        }
     });
}

function deleteBroadcastMessage($this) {
    if (confirm("Are you sure want to delete?")) {
        $('.preloader-2').attr('style', 'display:block !important');
        var id = $this.data('id');
        var data = {
            'id': id,
        };
        $.ajax({
            url: base_url + 'broadcast/deleteBroadcastMessage',
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

$(document).on('submit', '.updateBroadcastMessage-form', function(e) {
    e.preventDefault(); 
    $('.preloader-2').attr('style', 'display:block !important');
    var title = $('#title').val();
    var id = $('#id').val();
    var broadcastMessage = $('#broadcastMessage').val();
    var expiryDate = $('#expiryDate').val();
    var eventDate = $('#eventDate').val();
    var attachment = ($('#attachment').val() != '')?$('#attachment').val():$('#upload_attachment').val();
    
    if(formValidat()){
        var data = {
            'id': id,
            'title': title,
            'broadcastMessage': broadcastMessage,
            'expiryDate': expiryDate,
            'eventDate': eventDate,
            'attachment': attachment,
        };
        $.ajax({
            url: base_url + 'broadcast/addMessage',
            type: 'post',
            processData:false,
            contentType:false,
            cache:false,
            data: new FormData(this),
            success: function(response) {
                var obj = JSON.parse(response);
                if(obj.error_code == 0){
                    reset_form();
                    $('.close').click();
                    // $('.mail_content').text('Add');
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
});

function reset_form(){
    // CKEDITOR.instances['mail_content'].setData('');
    $('#title').val('');
    $('#attachment').val('');
    $('#upload-text span').text('Upload attachment here');
    $('#expiryDate').val('');
    $('#eventDate').val('');
    $('#view_resume').remove('');
    $('#broadcastMessage').val('');
    $('#id').val('');
}
function formValidat(){
    var title = $('#title').val();
    var broadcastMessage = $('#broadcastMessage').val();
    var expiryDate = $('#expiryDate').val();
    var eventDate = $('#eventDate').val();
    var num = 0; 
    if(title != ''){
        $('#title').removeClass('error');
    }else{
        $('#title').addClass('error');
        num++;
    }
    if(broadcastMessage != ''){
        $('#broadcastMessage').removeClass('error');
    }else{
        $('#broadcastMessage').addClass('error');
        num++;
    }
    if(expiryDate != ''){
        $('#expiryDate').removeClass('error');
    }else{
        $('#expiryDate').addClass('error');
        num++;
    }
    if(eventDate != ''){
        $('#eventDate').removeClass('error');
    }else{
        $('#eventDate').addClass('error');
        num++;
    }

    if(num == 0){
        return true;
    }else{
        return false;
    }
}