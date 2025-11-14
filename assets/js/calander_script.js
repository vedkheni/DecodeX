jQuery(document).ready(function(){
  jQuery('.datetimepicker').datepicker({
      timepicker: true,
      language: 'en',
      range: true,
      multipleDates: true,
		  multipleDatesSeparator: " - "
    });
  jQuery("#add-event").submit(function(){
      alert("Submitted");
      var values = {};
      $.each($('#add-event').serializeArray(), function(i, field) {
          values[field.name] = field.value;
      });
      console.log(
        values
      );
  });
});

(function () {    
    'use strict';
    // ------------------------------------------------------- //
    // Calendar
    // ------------------------------------------------------ //
	jQuery(function() {
		// page is ready
		var get_project_task = $("#get_project_task").data('json-data');
		var base_url = $("#js_data").data('base-url');
			//events: get_project_task,
		jQuery('#calendar').fullCalendar({
			themeSystem: 'bootstrap4',
			// emphasizes business hours
			businessHours: false,
			defaultView: 'month',
			// event dragging & resizing
			//editable: true,
			// header
			header: {
				left: 'title',
				center: 'month,agendaWeek,agendaDay',
				right: 'today prev,next'
			},
			events: {
				url: base_url+'project_task/task_json_data',
			},
			eventRender: function(event, element) {
				if(event.icon){
					element.find(".fc-title").prepend("<i class='fa fa-"+event.icon+"'></i>");
				}
			  },
			/* dayClick: function() {
				jQuery('#modal-view-event-add').modal();
			}, */
			eventClick: function(event, jsEvent, view) {
					var id=event.id
					console.log(id);
			        jQuery('.event-icon').html("<i class='fa fa-"+event.icon+"'></i>");
					jQuery('.event-title').html(event.title);
					jQuery('.event-body').html(event.description);
					jQuery('.proiority_text').html(event.priority);
					jQuery('.type_text').html(event.type);
					jQuery('.status_text').html(event.status_task);
					jQuery('.text_time').html(event.minute);
					jQuery('.deadline_date').html(event.deadline_date);
					jQuery('.details_text').html(event.description);
					jQuery('.eventUrl').attr('href',event.url);
					jQuery('#view_more').attr('href',base_url+"project_task/view/"+id);
					jQuery('.task-project').html(event.task_project_title);
					jQuery('.devloper_text').html(event.devloper_name);
					jQuery('#modal-view-event').modal();
			},
		})
	});
  
})(jQuery);