jQuery(document).ready(function ($) {
	var currentYear = new Date().getFullYear();
	var redDateTime = new Date(currentYear, 2, 13).getTime();
	// var circleDateTime = new Date(currentYear, 1, 20).getTime();
	var borderDateTime = new Date(currentYear, 0, 12).getTime();
	var data_holiday=$(".calendar").attr("data-holiday-date");
	var obj = jQuery.parseJSON(data_holiday);
	var jsonObj = [];
	if(data_holiday != ""){
		$.each(obj, function(k,v) {
			// value.id,value.title,value.holiday_date
			 var d = new Date(v.holiday_date);
					  var date1 = d.getDate();
					  var month = d.getMonth() + 1; // Since getMonth() returns month from 0-11 not 1-12
					  var year = d.getFullYear();
				  var circleDateTime = new Date(year, month-1, date1).getTime();
			item = {}
			item ["id"] = v.id;
			item ["name"] = v.holiday_date;
			item ["location"] = v.title;
			item ["startDate"] = circleDateTime;
			item ["endDate"] = circleDateTime;
			if(v.date_of_birth == 'true'){
				item ["color"] = '#43D397';
			}else{
				item ["color"] = '#FF8382';
			}

			jsonObj.push(item);
		});	

	}
	
	/* customDayRenderer: function(element, date) {
			$.each(obj, function(key,value) {
			  //console.log(value.id);
			  //console.log(value.title);
			  var d = new Date(value.holiday_date);
				  var date1 = d.getDate();
				  var month = d.getMonth() + 1; // Since getMonth() returns month from 0-11 not 1-12
				  var year = d.getFullYear();
			  var circleDateTime = new Date(year, month-1, date1).getTime();
			  if(date.getTime() == circleDateTime) {
				$(element).css('background-color', 'green');
				$(element).css('color', 'white');
				$(element).css('border-radius', '15px');
			  }
			});
		}, */
		/* customDayRenderer: function(element, date) {
		 	$.each(obj, function(key,value) {
			  //console.log(value.id);
			  // console.log(value.title);
			  console.log(value);
			  var d = new Date(value.holiday_date);
				  var date1 = d.getDate();
				  var month = d.getMonth() + 1; // Since getMonth() returns month from 0-11 not 1-12
				  var year = d.getFullYear();
			  var circleDateTime = new Date(year, month-1, date1).getTime();
			  if(value.date_of_birth == 'true'){
				  if(date.getTime() == circleDateTime){
					$(element).css('border', '2px solid blue');
				  }
			  }else{
			  	if(date.getTime() == circleDateTime){
					$(element).css('border', '2px solid #28a745');
				  }
			  }
			});
        },*/
	// var dataSource=[];
	$('#calendar').calendar({
		// disabledWeekDays: [0],
		mouseOnDay: function(e) {

			if(e.events.length > 0) {
				var content = '';
				
				for(var i in e.events) {
					content += '<div class="event-tooltip-content">'
								+ '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
								+ '<div class="event-location">' + e.events[i].location + '</div>'
							+ '</div>';
				}
			
				$(e.element).popover({
					trigger: 'manual',
					container: 'body',
					html:true,
					content: content,
					placement: 'bottom',
				});
				
				$(e.element).popover('show');
				var attr = $('div.popover.fade.in').attr('style');
				var res = attr.replace('display: block; opacity: 1;','');
				$('div.popover.fade.in').attr('style', res+' opacity:1');
				$('div.popover.fade.in').addClass('holiday-popover');
			}
		},
		mouseOutDay: function(e) {
			if(e.events.length > 0){
				$(e.element).popover('hide');
				// var attr = $('div.popover.fade.right.in').attr('style');
				// $('popover.fade.right.in').attr('style',attr+' opecity:0');
			}
		},
		dayContextMenu: function(e) {
			$(e.element).popover('hide');
		},
		dataSource: jsonObj,
	});
});