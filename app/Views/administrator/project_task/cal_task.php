<div id="page-wrapper">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">List project task</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Project Task</a></li>
                <li class="active">List Project Task</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
               <!-- partial:index.partial.html -->
<?php 
	//echo "<pre>"; print_r($get_project_task);echo "</pre>"; 
	$arr=array();
	if(isset($get_project_task) && !empty($get_project_task)){
		$i=0;
		foreach($get_project_task as $task){
			
			$arr[$i]['title']= $task->title;
			$arr[$i]['description']= $task->description;
			$arr[$i]['start']= $task->deadline_date;
			$arr[$i]['end']= $task->deadline_date;
			$arr[$i]['className']= 'fc-bg-default';
			$arr[$i]['icon']='circle';
		$i++;	//$arr[]=$task;
		}
	}
	//echo json_encode($arr);
	//echo "<pre>";print_r($arr); echo "</pre>";
?>
<div id="get_project_task" data-json-data='<?php echo json_encode($arr); ?>'></div>
<div class="p-5">
  <h2 class="mb-4">Task Calendar</h2>
  <div class="card">
    <div class="card-body p-0">
      <div id="calendar"></div>
    </div>
  </div>
</div>

<!-- calendar modal -->
<div id="modal-view-event" class="modal modal-top fade calendar-modal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body">
			<!-- <h4 class="modal-title"><span class="event-icon"></span><span class="event-title"></span></h4>
			<div class="event-body"></div> -->
			<h4 class="modal-title"><h2 class="_title task-project">Task Name - Project Name</h2></h4>
			<div class="_model">
          <div class="demo">
            <div class="form-group _content">
              <p class="control-label col-sm-12">Details:</p>
              <div class="col-sm-12">
                  <p class="details_text">Enter text</p>
              </div>
          </div>
					</div>         
          <form class="form-horizontal" action="/action_page.php"> 
            <div class="demo">
                    <div class="form-group _content">
                      <p class="control-label col-sm-12">Proiority:</p>
                        <div class="col-sm-12">
                          <p class="proiority_text">Enter text</p>
                        </div>
                    </div>
					          <div class="form-group _content">
                      <p class="control-label col-sm-12">Devloper:</p>
                        <div class="col-sm-12">
                          <p class="devloper_text">Enter text</p>
                        </div>
                    </div>
            </div>	
            <div class="demo">
                    <div class="form-group _content">
                      <p class="control-label col-sm-12">Type:</p>
                        <div class="col-sm-12">
                          <p class="type_text">Enter text</p>
                        </div>
                    </div>
                    <div class="form-group _content">
                      <p class="control-label col-sm-12">Status:</p>
                        <div class="col-sm-12">
                          <p class="status_text">Enter text</p>
                        </div>
                    </div>
            </div>
            <div class="demo">
                    <div class="form-group _content">
                      <p class="control-label col-sm-12">Time:</p>
                      <div class="col-sm-12">
                        <p class="text_time">Enter text</p>
                      </div>
                    </div>
                    <div class="form-group _content">
                      <p class="control-label col-sm-12">Deadline Date:</p>
                      <div class="col-sm-12">
                        <p class="deadline_date">Enter text</p>
                      </div>
                    </div>
            </div>
          </form>
				<div class="modal-footer">
          <a href="" class="btn btn-default _view-more" id="view_more">View More</a>
					<button type="button" class="btn btn-primary _close" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
</div>

<div id="modal-view-event-add" class="modal modal-top fade calendar-modal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="add-event">
        <div class="modal-body">
        <h4>Add Event Detail</h4>        
          <div class="form-group">
            <label>Event name</label>
            <input type="text" class="form-control" name="ename">
          </div>
          <div class="form-group">
            <label>Event Date</label>
            <input type='text' class="datetimepicker form-control" name="edate" id="edate">
          </div>        
          <div class="form-group">
            <label>Event Description</label>
            <textarea class="form-control" name="edesc"></textarea>
          </div>
          <div class="form-group">
            <label>Event Color</label>
            <select class="form-control" name="ecolor">
              <option value="fc-bg-default">fc-bg-default</option>
              <option value="fc-bg-blue">fc-bg-blue</option>
              <option value="fc-bg-lightgreen">fc-bg-lightgreen</option>
              <option value="fc-bg-pinkred">fc-bg-pinkred</option>
              <option value="fc-bg-deepskyblue">fc-bg-deepskyblue</option>
            </select>
          </div>
          <div class="form-group">
            <label>Event Icon</label>
            <select class="form-control" name="eicon">
              <option value="circle">circle</option>
              <option value="cog">cog</option>
              <option value="group">group</option>
              <option value="suitcase">suitcase</option>
              <option value="calendar">calendar</option>
            </select>
          </div>        
      </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary" >Save</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>        
      </div>
      </form>
    </div>
  </div>
</div>
            </div>
        </div>
    </div>
</div>
