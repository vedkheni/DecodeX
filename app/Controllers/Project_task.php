<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_task extends CI_Controller {
	//designation
	public function __construct()
	{
		parent::__construct();
		$user_session=$this->session->userdata('id');
		if(!$user_session){
			redirect(base_url());	
		}
	}
	public function hoursandmins($time, $format = '%02d:%02d')
	{
	    if ($time < 1) {
	        return;
	    }
	    $hours = floor($time / 60);
	    $minutes = ($time % 60);
	    return sprintf($format, $hours, $minutes);
	}
	public function index()
	{
		$user_session=$this->session->userdata('id');
		if(!$user_session){
			redirect(base_url('admin'));	
		}
		$data=array();
		$data['page_title']="Project Task";
		$data['js_flag']="project_task_js";
		$data['menu']="task";
		$this->lib->view('administrator/project_task/list_task',$data);
	}
	public function task_design()
	{
		$user_session=$this->session->userdata('id');
		if(!$user_session){
			redirect(base_url('admin'));	
		}
		$this->load->model('Project_Task_Model');
		$data=array();
		$data['page_title']="Project Task";
		$data['js_flag']="task_design";
		$data['menu']="task";
		$data['get_project_task']=$this->Project_Task_Model->get_project_task();
		$this->lib->view('administrator/project_task/cal_task',$data);
	}
	public function employee_pagination()
	{
		//Designation_Model
		$this->load->model('employee_Model');
		$this->load->model('Designation_Model');
		$this->load->model('Project_Task_Model');
		$user_role=$this->session->userdata('user_role');
		$columns = array( 
                            0 =>'id', 
                            1 =>'title',
                            2 =>'project_id',
                            3 =>'description',
                            4 =>'action', 
                        );
		
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Project_Task_Model->allposts_count();
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->Project_Task_Model->allposts($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value'] ; 

            $posts =  $this->Project_Task_Model->posts_search($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Project_Task_Model->posts_search_count($search);
        }
		
          $data = array();
        if(!empty($posts))
        {
		 foreach ($posts as $post)
            {
            	$nestedData['id'] = "<span>".$post->id ."</span>";
                $nestedData['title'] = $post->title;
                $nestedData['project_id'] = $post->project_title;
                $x  = $post->description;
				$length = 120;
				 if(strlen($x)<=$length)
				  {
					$nestedData['description'] = $x;
				  }
				  else
				  {
					$y=substr($x,0,$length) . '...';
					$nestedData['description'] = $y;
				  }
				$nestedData['action'] ='<a href="'.base_url('project_task/add').'/'.$post->id.'" class="btn btn-danger waves-effect waves-light">Edit</a> <a data-id="'.$post->id.'" class="btn btn-danger waves-effect waves-light  delete-employee">Delete</a>';
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    ); 
       echo json_encode($json_data); 
	}
	public function add()
	{
		$user_session=$this->session->userdata('id');
		if(!$user_session){
			redirect(base_url('admin'));	
		}
		$this->load->model('Designation_Model');
		$this->load->model('Project_Task_Model');
		$this->load->model('employee_Model');
		$this->load->model('Project_Model');

		$data=array();

		if($this->uri->segment(3)){
			$data['page_title']="Edit task";
			$id=$this->uri->segment(3);
			$data['list_data']= $this->Project_Task_Model->get_employee($id);
		}else{
			$data['page_title']="Add task";
			$data['list_data']="";
		}
		$data['get_developer']= $this->employee_Model->get_developer();
		$data['get_project']= $this->Project_Model->get_project();

		$data['js_flag']="project_task_js";
		$data['menu']="task_add";
		$user_role=$this->session->userdata('user_role'); 
		if($user_role == 'admin'){
			$this->lib->view('administrator/project_task/add_admin_task',$data);
		}else{
			$this->lib->view('administrator/project_task/add_task',$data);	
		}
		
	}
	public function delete_employee(){
		$this->load->model('Designation_Model');
		$this->load->model('Project_Task_Model');

		$id = $this->input->post("id");
		$delete_employee= $this->Project_Task_Model->delete_employee($id);
	
	}
	public function insert_data()
	{	
		$user_session=$this->session->userdata('id');
		$this->load->model('Administrator_Model');
		$admin_detail=$this->Administrator_Model->admin_profile($user_session);
		$user_name=$admin_detail[0]->username;
		$user_mail=$admin_detail[0]->email;
		$this->load->model('Employee_Model');
		$id = $this->input->post("e_id");
		$project = $this->input->post("project");
		$title = $this->input->post("title");
		$description = $this->input->post("description");
		$minute = $this->input->post("minute");
		$hour = $this->input->post("hour");
		$status = $this->input->post("status");
		$tag = $this->input->post("json_tag");
		$bug = $this->input->post("json_bug");	
		$time = date('Y-m-d H:i:s');
		$developer = $this->input->post("developer");
		/* $subject = "Subject Testing";
		$massege = "Massage Testing"; */
		/* echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		 */
		
		$developer_data="";
		if(!empty($developer)){
			$developer_data=implode(',', $developer);
		}
		
		//die();
		$deadline_date = $this->input->post("deadline");
		$developer = $this->input->post("developer");
		$priority = $this->input->post("priority");
		$type = $this->input->post("type");
		//$attachments = $this->input->post("attachments");
		$complete_hidden = $this->input->post("complete_hidden");
		$start_hidden = $this->input->post("start_hidden");
		$end_hidden = $this->input->post("end_hidden");

		$complete_per = array_filter($this->input->post("complete_per"));
		$start_date = array_filter($this->input->post("start_date"));
		$end_date = array_filter($this->input->post("end_date"));
		$start_hidden_arr=explode(',',$start_hidden[0]);
		$end_hidden_arr=explode(',',$end_hidden[0]);
		$complete_hidden_arr=explode(',',$complete_hidden[0]);
		$final_array_complete_per=array_merge($complete_hidden_arr,$complete_per);
		$final_array_start_date=array_merge($start_hidden_arr,$start_date);
		$final_array_end_date=array_merge($end_hidden_arr,$end_date);
		$final_array_complete_per1 = $final_array_start_date1 = $final_array_end_date1 ="";
		$this->load->model('Project_Task_Model');
		$project_detail=$this->Project_Task_Model->get_project_details($project);
		$project_title=$project_detail[0]->title;
		 /* echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		die();  */
		
		if(!empty(array_filter($final_array_complete_per))){
			$final_array_complete_per1=json_encode(array_filter($final_array_complete_per));
		}
		if(!empty(array_filter($final_array_start_date))){
			$final_array_start_date1=json_encode(array_filter($final_array_start_date));
		}
		if(!empty(array_filter($final_array_end_date))){
			$final_array_end_date1=json_encode(array_filter($final_array_end_date));
		}
		$this->form_validation->set_rules('project', 'Project', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('hour', 'Hour', 'required');
		$this->form_validation->set_rules('minute', 'Minute', 'required');
		//$this->form_validation->set_rules('developer', 'Developer', 'required');
		
		$this->load->model('Designation_Model');
		$this->load->model('Project_Model');
		$this->load->model('Project_Task_Model');
		$url = $_SERVER['DOCUMENT_ROOT'].'/assets/attachments';
		
		$picture="";
		$attachments = $this->input->post("attachments");
		if($this->form_validation->run() == false)
		{
			
			$this->session->set_flashdata('message', validation_errors());
			redirect(base_url('project_task/add'));

		}else{
			$reminder=0;
					if(!empty($_FILES['attachments']['name'])){
						$config['upload_path'] = $url;
						$config['allowed_types'] = '*';
						//$config['max_size']   = '1024';
						$config['file_name'] = date('dmYhis').$_FILES['attachments']['name'];
						$this->load->library('upload',$config);
						$this->upload->initialize($config);
						if($this->upload->do_upload('attachments')){
							$uploadData = $this->upload->data();
							$picture = $uploadData['file_name'];
						}else{
							 $this->session->set_flashdata('message','<span class="error_Success">'.$this->upload->display_errors().'</sapn>');
							if(!isset($id) || empty($id)){
								redirect(base_url('project_task/add'));
							}
							 else{
								redirect(base_url().'project_task/add/'.$id);
							}
							redirect(base_url('project_task/add')); 
						}
					}
					if($this->input->post("reminder")=="yes")
					{
				
							$reminder = 1;
							$cc_emails="";
							$cc="";
							$cc_counter=0;
							$cc_date="";
							$count_dev=count($developer);
							foreach($developer as $dev)
							{
								$myresult = $this->Employee_Model->get_employee_by_id($dev);
								$email = $myresult[0]->email;
								if($count_dev>1){
									if(!empty($email)){
										$to = $email;
										$cc_emails.=$email.',';
										$cc=rtrim($cc_emails, ',');
										$cc_counter=1;
										
									}	
									
								}
								else{
									if(!empty($email)){
										$to = $email;
										$cc_emails.="";
										$cc="";
										$cc_date="";
										$cc_counter=0;
									}	
									
								}

							}
							$data                  = array();
							//$to                    = $email;
							$success_msg           = "";
							$msg                   = "";
							$usermsg               = "Hello geek webians, This is a task assigned to you please check description of task and other details!";
							$subject               = "Task Assigned By Admin";
							$usermail              = $user_mail;           
							$subject = $subject . " : http://staff.geekwebsolution.com";
							$headers = "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
							$headers .= "From: $usermail\r\n";
							if($cc_counter==1){
								$headers .= "Cc: $cc";
							}
							$msg .= "Project: ".$project_title."<br/>";
							$msg .= "Task name: ".$title."<br/>";
							$msg .= "Task description: ".$description."<br/>";
							$msg .= "Time to complete task: ".$hour." hrs ".$minute." mns<br/>";
							$msg .= "Deadline: ".$deadline_date."<br/>";
							$msg .= "Message: " . $usermsg . "<br/>";
							//mail($to, $subject, $msg, $headers);
							if(!isset($id) || empty($id)){
								$min=($hour*60)+$minute;
								$arr=array(
									'project_id' => $project,
									'title' => $title,
									'description' => $description,
									'minute' => $min,
									'developer' => $developer_data,
									'status' => $status,
									'task_tag' => $tag,
									'task_bug' => $bug,
									'created_date' => $time,
									'reminder_message' => $reminder,
									'deadline_date' => $deadline_date,
									'priority' => $priority,
									'type' => $type,
									'attachments' => $picture,
									'complete_percentage' => $final_array_complete_per1,
									'start_date' => $final_array_start_date1,
									'end_date' => $final_array_end_date1,
									
								);
								$insert_employee= $this->Project_Task_Model->insert_employee($arr);
								if($insert_employee){
									if(mail($to, $subject, $msg, $headers)){			
										redirect(base_url('project_task'));			
									}
									else{
										redirect(base_url('project_task/add'));
									}
										
								}

							}else{
				
								$min=($hour*60)+$minute;
								$arr=array(
									'id' => $id,
									'project_id' => $project,
									'title' => $title,
									'description' => $description,
									'minute' => $min,
									'developer' => $developer_data,
									'status' => $status,
									'task_tag' => $tag,
									'task_bug' => $bug,
									'reminder_message' => $reminder,
									'deadline_date' => $deadline_date,
									'priority' => $priority,
									'type' => $type,
									'attachments' => $picture,
									'complete_percentage' => $final_array_complete_per1,
									'start_date' => $final_array_start_date1,
									'end_date' => $final_array_end_date1,
								);
								echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		die(); 

								$insert_employee= $this->Project_Task_Model->update_employee($arr);
									
								if($insert_employee){
									if(mail($to, $subject, $msg, $headers)){			
												redirect(base_url('project_task'));			
									}
									else{
										redirect(base_url('project_task/add'));	
									}
										
								}
							}
						}
						else
						{
							$reminder = 0;
							if(!isset($id) || empty($id)){
								$min=($hour*60)+$minute;
								$arr=array(
									'project_id' => $project,
									'title' => $title,
									'description' => $description,
									'minute' => $min,
									'developer' => $developer_data,
									'status' => $status,
									'task_tag' => $tag,
									'task_bug' => $bug,
									'created_date' => $time,
									'reminder_message' => $reminder,
									'deadline_date' => $deadline_date,
									'priority' => $priority,
									'type' => $type,
									'attachments' => $picture,
									'complete_percentage' => $final_array_complete_per1,
									'start_date' => $final_array_start_date1,
									'end_date' => $final_array_end_date1,
									
								);
								$insert_employee= $this->Project_Task_Model->insert_employee($arr);
								if($insert_employee){
									redirect(base_url('project_task'));		
								}

							}else{
				
								$min=($hour*60)+$minute;
								$arr=array(
									'id' => $id,
									'project_id' => $project,
									'title' => $title,
									'description' => $description,
									'minute' => $min,
									'developer' => $developer_data,
									'status' => $status,
									'task_tag' => $tag,
									'task_bug' => $bug,
									'reminder_message' => $reminder,
									'deadline_date' => $deadline_date,
									'priority' => $priority,
									'type' => $type,
									'attachments' => $picture,
									'complete_percentage' => $final_array_complete_per1,
									'start_date' => $final_array_start_date1,
									'end_date' => $final_array_end_date1,
								);

								$insert_employee= $this->Project_Task_Model->update_employee($arr);
									
								if($insert_employee){
									edirect(base_url('project_task'));			
								}
							}
						}
						
					} 
	}
	public function task_json_data(){
	$arr=array();
	$this->load->model('Project_Task_Model');
	$this->load->model('Employee_Model');
	$get_project_task=$this->Project_Task_Model->get_project_task();
	//echo "<pre>"; print_r($get_project_task); echo "</pre>";
		if(isset($get_project_task) && !empty($get_project_task)){
			$i=0;
			
			foreach($get_project_task as $task){
				$employes_name=array();
				if(!empty($task->developer)){
					$explode[$i]=explode(',',$task->developer);
					foreach($explode[$i] as $dev){
						$devloper_name=$this->Employee_Model->get_employee($dev);
						$employes_name[$dev]=$devloper_name[0]->fname ." (". $devloper_name[0]->name .")";
					}
				}
				$hours = $minute = 0;
				if(!empty($task->minute)){
				   $minutes=$task->minute;
				   $hours = floor($minutes / 60);
				   $minute=($minutes -   floor($minutes / 60) * 60);
				}
				
				$arr[$i]['id']= ucwords($task->id);
				$arr[$i]['title']= ucwords($task->title);
				$arr[$i]['description']= (strlen($task->description) > 200) ? substr($task->description,0,200)."..." : $task->description;
				$arr[$i]['start']= $task->deadline_date;
				$arr[$i]['end']= $task->deadline_date;
				$arr[$i]['className']= 'fc-bg-default';
				$arr[$i]['icon']='circle';
				$arr[$i]['developer']='circle';
				$arr[$i]['devloper_name']=implode(' , ',$employes_name);
				$arr[$i]['priority']= ucwords($task->priority);
				$arr[$i]['type']= $task->type;
				$arr[$i]['status_task']= ucwords($task->status);
				$arr[$i]['minute']= $hours." Hours ".$minute." Minute";
				$arr[$i]['deadline_date']= $task->deadline_date;
				$arr[$i]['task_tag']= $task->task_tag;
				$arr[$i]['task_project_title']= ucwords($task->title) . " in " . ucwords($task->project_title); 
				$i++;	
				
			}
			echo json_encode($arr);
		} 
	}
	public function view($id){
		$user_role=$this->session->userdata('user_role');
		if($user_role != 'admin'){
			redirect('dashboard');	
		}
		$data=array();
	    $this->load->model('Project_Task_Model');
		$this->load->model('Employee_Model');
		if(isset($id) && !empty($id)){
			$data['get_project_task']=$this->Project_Task_Model->get_employee_task($id);
		}else{
			redirect('project_task/task_design');
		}
		$data['page_title']="Task View";
		$data['js_flag']="project_js";
		$data['menu']="View";
		$this->lib->view('administrator/project_task/task_view',$data);
		//echo "task view page";
	}
}
