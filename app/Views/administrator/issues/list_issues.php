<div id="page-wrapper">
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">List issues</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">issues</a></li>
                <li class="active">List issues</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

 <div class="container">
              <div class="row">
                <div class="col-md-12 ">
                     <div class="white-box">
                  <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link active" id="nav-pending-tab" data-toggle="tab" href="#nav-pending" role="tab" aria-controls="nav-pending" aria-selected="true">Pending</a>
                      <a class="nav-item nav-link" id="nav-development-tab" data-toggle="tab" href="#nav-development" role="tab" aria-controls="nav-development" aria-selected="false">In Development</a>
                      <a class="nav-item nav-link" id="nav-completed-tab" data-toggle="tab" href="#nav-completed" role="tab" aria-controls="nav-completed" aria-selected="false">Completed</a>
                    
                    </div>
                  </nav>
                  <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade in show active" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                       <div class="table-responsive">
                       
                       <table id="example" class="table table-striped table-bordered task-pending" style="width:100%">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project</th>
                                    <th>Task Title</th>                                
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <div class="tab-pane fade" id="nav-development" role="tabpanel" aria-labelledby="nav-development-tab">
                       <div class="table-responsive">
                   <table id="example" class="table table-striped table-bordered task-in-progress" style="width:100%">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Project</th>
                                <th>Task Title</th>                                
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                    </div>
                    <div class="tab-pane fade" id="nav-completed" role="tabpanel" aria-labelledby="nav-completed-tab">
                       <div class="table-responsive">
                   <table id="example" class="table table-striped table-bordered task-in-completed" style="width:100%">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Project</th>
                                <th>Task Title</th>                                
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                    </div>
                    <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                      Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet duis do nisi duis veniam non est eiusmod tempor incididunt tempor dolor ipsum in qui sit. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore. Duis reprehenderit occaecat anim ullamco ad duis occaecat ex.
                    </div>
                  </div>
                </div>
                </div>
              </div>
        </div>
      </div>
</div>

    
</div>
<script type="text/javascript">
jQuery(document).ready(function ($) {
    jQuery("#name1").change(function(){
        alert("The text has been changed.");
    });
});
</script>