/* Start Cookie's Get And Set Function  */
function setCookie(name,value,days) {
	var expires = "";
    if (days) {
		var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
	var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
		var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

/* End Cookie's Get And Set Function  */

/* Start Birthday Modal Code  */
if(getCookie('close_modal') == null){
	($('#show_modal').data('show_modal') == 'show') ? $('#birthday_modal').modal('show') : $('#birthday_modal').modal('hide') ;
}
$('body').click(function(event){
	setTimeout(function() {
		if(!$('#birthday_modal').hasClass('in')){
			if($('#close_forever').is(':checked')){
				setCookie('close_modal','close modal true',0.75);
			}
		}
	}, 500);	
});
$('#birthday_modal_close').click(function(){
	if($('#close_forever').is(':checked')){
		setCookie('close_modal','close modal true',0.75);
	}
	$('#birthday_modal').modal('hide');
});

/* End Birthday Modal Code  */

/*jslint browser: true*/
 /*global $, jQuery, alert*/
 $('.numeric').keyup(function() {
    this.value = this.value.replace(/[^0-9\.]/g, '');
});
var base_url = $("#js_data").data('base-url');
$('#btn-change_id').click(function(){
    $('.preloader.preloader-2').attr('style', 'display:block !important');
    var change_pc_id = $('#change_pc_id').val();
    var emp_id = $('#emp_id').val();
    var data = {
        'emp_id': emp_id,
        'pc_id': change_pc_id,
    };
    if(emp_id != '' && change_pc_id.length < 2){
        $.ajax({
            url: base_url+"pc_issue/changPC_id",
            type: "post",
            data: data ,
            success: function (response) {
                var obj = JSON.parse(response);
                if(obj.error_code == 0){
                    $('.idofpc').text($('#change_pc_id').val());
                    $('#idofpc_1').text($('#change_pc_id').val());
                    $('#change_pc_id').val('');
                    $('.msg-container').html(obj.message);
                    $('.msg-container .msg-box').attr('style','display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style','display:none');
                    }, 6000);
                    $('.preloader.preloader-2').attr('style', 'display:none !important');
                }else{
                    $('.msg-container').html(obj.message);
                    $('.msg-container .msg-box').attr('style','display:block');
                    setTimeout(function() {
                        $('.msg-container .msg-box').attr('style','display:none');
                    }, 6000);
                    $('.preloader.preloader-2').attr('style', 'display:none !important');
                }
            },
        });
    }else{
        if(change_pc_id.length < 2){$('#change_pc_id').addClass('error')}else{$('#change_pc_id').removeClass('error')};
        if(emp_id == ''){$('#emp_id').addClass('error'); }else{$('#emp_id').removeClass('error'); };
        $('.preloader.preloader-2').attr('style', 'display:none !important');
    }
});
 $(document).ready(function () {

     "use strict";

     var body = $("body");

     $(function () {
         $(".preloader").fadeOut();
         $('#side-menu').metisMenu();
     });

     /* ===== Theme Settings ===== */

     $(".open-close").on("click", function () {
         body.toggleClass("show-sidebar").toggleClass("hide-sidebar");
         $(".sidebar-head .open-close i").toggleClass("ti-menu");
     });



     /* ===========================================================
         Loads the correct sidebar on window load.
         collapses the sidebar on window resize.
         Sets the min-height of #page-wrapper to window size.
     =========================================================== */

     $(function () {
         var set = function () {
                 var topOffset = 60,
                     width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width,
                     height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
                 if (width < 768) {
                     $('div.navbar-collapse').addClass('collapse');
                     topOffset = 100; /* 2-row-menu */
                 } else {
                     $('div.navbar-collapse').removeClass('collapse');
                 }

                 /* ===== This is for resizing window ===== */

                 if (width < 1170) {
                     body.addClass('content-wrapper');
                     $(".sidebar-nav, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
                 } else {
                     body.removeClass('content-wrapper');
                 }

                 height = height - topOffset;
                 if (height < 1) {
                     height = 1;
                 }
                 if (height > topOffset) {
                     $("#page-wrapper").css("min-height", (height) + "px");
                 }
             },
             url = window.location,
             element = $('ul.nav a').filter(function () {
                 return this.href === url || url.href.indexOf(this.href) === 0;
             }).addClass('active').parent().parent().addClass('in').parent();
         if (element.is('li')) {
             element.addClass('active');
         }
         $(window).ready(set);
         $(window).bind("resize", set);
     });


     /* ===== Tooltip Initialization ===== */

     $(function () {
         $('[data-toggle="tooltip"]').tooltip();
     });

     /* ===== Popover Initialization ===== */

     $(function () {
         $('[data-toggle="popover"]').popover();
     });

     /* ===== Task Initialization ===== */

     $(".list-task li label").on("click", function () {
         $(this).toggleClass("task-done");
     });
     $(".settings_box a").on("click", function () {
         $("ul.theme_color").toggleClass("theme_block");
     });

     /* ===== Collepsible Toggle ===== */

     $(".collapseble").on("click", function () {
         $(".collapseblebox").fadeToggle(350);
     });

     /* ===== Sidebar ===== */

     $('.slimscrollright').slimScroll({
         height: '100%',
         position: 'right',
         size: "5px",
         color: '#dcdcdc'
     });
     $('.slimscrollsidebar').slimScroll({
         height: '100%',
         position: 'right',
         size: "6px",
         color: 'rgba(0,0,0,0.3)'
     });
     $('.chat-list').slimScroll({
         height: '100%',
         position: 'right',
         size: "0px",
         color: '#dcdcdc'
     });

     /* ===== Resize all elements ===== */

     body.trigger("resize");

     /* ===== Visited ul li ===== */

     $('.visited li a').on("click", function (e) {
         $('.visited li').removeClass('active');
         var $parent = $(this).parent();
         if (!$parent.hasClass('active')) {
             $parent.addClass('active');
         }
         e.preventDefault();
     });

     /* ===== Login and Recover Password ===== */

     $('#to-recover').on("click", function () {
         $("#loginform").slideUp();
         $("#recoverform").fadeIn();
     });

     /* ================================================================= 
         Update 1.5
         this is for close icon when navigation open in mobile view
     ================================================================= */

     $(".navbar-toggle").on("click", function () {
         $(".navbar-toggle i").toggleClass("ti-menu").addClass("ti-close");
     });

     $('#joining_year').each(function () {
         var $this = $(this), numberOfOptions = $(this).children('option').length;
         $this.addClass('select-hidden');
         $this.wrap('<div class="select"></div>');
         $this.after('<div class="select-styled"></div>');
         var $styledSelect = $this.next('div.select-styled');
         $styledSelect.text($this.children('option').eq(0).text());
         var $list = $('<ul />', {
             'class': 'select-options'
         }).insertAfter($styledSelect);
         for (var i = 0; i < numberOfOptions; i++) {
             $('<li />', {
                 text: $this.children('option').eq(i).text(),
                 rel: $this.children('option').eq(i).val()
             }).appendTo($list);
         }

         var $listItems = $list.children('li');
         $styledSelect.click(function (e) {
             e.stopPropagation();
             $('div.select-styled.active').not(this).each(function () {
                 $(this).removeClass('active').next('ul.select-options').hide();
             });
             $(this).toggleClass('active').next('ul.select-options').toggle();
         });
         $listItems.click(function (e) {
             e.stopPropagation();
             $styledSelect.text($(this).text()).removeClass('active');
             $this.val($(this).attr('rel'));
             $list.hide();
             //console.log($this.val());
         });
         $(document).click(function () {
             $styledSelect.removeClass('active');
             $list.hide();
         });
     });
	 
	 function createJSON() {
		jsonObj = [];
		$(".tag-ol li").each(function() {

			var text = $(this).text();
			item ["text"] = text;
			jsonObj.push(item);
		});

		alert(jsonObj);
	}
	
	$(".submit_form").click(function(){
		//createJSON();
	});
    
	
 });

 jQuery(window).scroll(function () {
	if (jQuery(this).scrollTop() > 180) {
		jQuery('.scrollToTop').css({ transform: "scale(1)" });
	} else {
		jQuery('.scrollToTop').css({ transform: "scale(0)" });
	}
});

jQuery('.scrollToTop').click(function () {
	jQuery("html, body").animate({
		scrollTop: 0
	}, 10);
	return false;
});
/* Start Broadcast */
function openAnnouncmentModal(){
    $('.preloader-2').attr('style', 'display:block !important');
    $('.announcInfo').removeClass('active');
    $('.announcInfo-body').slideUp();
    $('#c-0').parent('div').toggleClass('active');
    $('#c-0').slideToggle(function(){
		$('.preloader-2').attr('style', 'display:none !important');
		$('#announcmentModal').modal('show');
	});
}	
$(document).on('click','.openAnnouncInfo',function(){
    if(!$(this).parent('div').hasClass('active')){
        $('.announcInfo').removeClass('active');
        $('.announcInfo-body').slideUp();
    }
    $(this).parent('div').toggleClass('active');
    $id = $(this).data('target');
    $($id).slideToggle();
});	
/* End Broadcast */