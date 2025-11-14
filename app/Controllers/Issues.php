<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Issues extends CI_Controller {
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
		$data['page_title']="Issues";
		$data['menu']="issues";
		$data['js_flag']="task-issues";
		$this->lib->view('administrator/issues/list_issues',$data);
	}
	public function employee_pagination()
	{
		//Designation_Model
		$this->load->model('employee_Model');
		$this->load->model('Designation_Model');
		$this->load->model('Project_Task_Model');
		$this->load->model('Issues_Task_Model');

		$user_role=$this->session->userdata('user_role');
		$columns = array( 
                            0 =>'id', 
                            1 =>'title',
                            2 =>'project_id',
                            3 =>'status',
                            4 =>'action', 
                        );
		
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Issues_Task_Model->allposts_count_pending();
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->Issues_Task_Model->allposts_pending($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value'] ; 

            $posts =  $this->Issues_Task_Model->posts_search_pending($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Issues_Task_Model->posts_search_count_pending($search);
        }
		
          $data = array();
        if(!empty($posts))
        { 
		 foreach ($posts as $post)
            {
            	$nestedData['id'] = $post->id;
                $nestedData['title'] = $post->title;
                $nestedData['project_id'] = $post->project_title;
                $nestedData['status'] =ucwords($post->status);
				$nestedData['action'] ='<select class="form-control form-control-line update-status" name="status"
                                         id="status" data-id="'.$post->id.'">
                                        <option  value=""></option>
                                        <option  value="in development">In Development</option>
                                        <option  value="complete">Complete</option>
                                        </select>';
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
	public function employee_pagination_in_progress()
	{
		//Designation_Model
		$this->load->model('employee_Model');
		$this->load->model('Designation_Model');
		$this->load->model('Project_Task_Model');
		$this->load->model('Issues_Task_Model');

		$user_role=$this->session->userdata('user_role');
		$columns = array( 
                            0 =>'id', 
                            1 =>'title',
                            2 =>'project_id',
                            3 =>'status',
                            4 =>'action', 
                        );
		
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Issues_Task_Model->allposts_count_in_progress();
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->Issues_Task_Model->allposts_in_progress($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value'] ; 

            $posts =  $this->Issues_Task_Model->posts_search_in_progress($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Issues_Task_Model->posts_search_count_in_progress($search);
        }
		
          $data = array();
        if(!empty($posts))
        {
		 foreach ($posts as $post)
            {
            	$nestedData['id'] = $post->id;
                $nestedData['title'] = $post->title;
                $nestedData['project_id'] = $post->project_title;
                $nestedData['status'] = ucwords($post->status);
				$nestedData['action'] ='<select class="form-control form-control-line update-status" name="status"
                                         id="status" data-id="'.$post->id.'">
                                        <option  value=""></option>
                                        <option  value="pending">Pending</option>
                                        <option  value="complete">Complete</option>
                                        </select>';
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
	public function employee_pagination_completed()
	{
		//Designation_Model
		$this->load->model('employee_Model');
		$this->load->model('Designation_Model');
		$this->load->model('Project_Task_Model');
		$this->load->model('Issues_Task_Model');

		$user_role=$this->session->userdata('user_role');
		$columns = array( 
                            0 =>'id', 
                            1 =>'title',
                            2 =>'project_id',
                            3 =>'status',
                            4 =>'action', 
                        );
		
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Issues_Task_Model->allposts_count_completed();
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->Issues_Task_Model->allposts_completed($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value'] ; 

            $posts =  $this->Issues_Task_Model->posts_search_completed($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Issues_Task_Model->posts_search_count_completed($search);
        }
		
          $data = array();
        if(!empty($posts))
        {
		 foreach ($posts as $post)
            {
            	$nestedData['id'] = $post->id;
                $nestedData['title'] = $post->title;
                $nestedData['project_id'] = $post->project_title;
                $nestedData['status'] = ucwords($post->status);
				$nestedData['action'] ='<select class="form-control form-control-line update-status" name="status"
                                         id="status" data-id="'.$post->id.'">
                                        <option  value=""></option>
                                        <option  value="pending">Pending</option>
                                        <option  value="in development">In Development</option>
                                        </select>';
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

		$data['js_flag']="task-issues";
		$data['menu']="issues_add";
		$this->lib->view('administrator/project_task/add_designation',$data);
	}
	public function delete_employee(){
		$this->load->model('Designation_Model');
		$this->load->model('Project_Task_Model');

		$id = $this->input->post("id");
		$delete_employee= $this->Project_Task_Model->delete_employee($id);
	
	}
	public function update_status(){
		print_r($_POST);
		$status = $this->input->post('status');
		$id = $this->input->post('id');
		$arr=array(
			'status' => $status
		);
		$this->db->table('project_task')->where('id',$id);
		$this->db->update($arr);
	}
	public function insert_data()
	{	
		
		$id = $this->input->post("e_id");
		$project = $this->input->post("project");
		$title = $this->input->post("title");
		$description = $this->input->post("description");
		$minute = $this->input->post("minute");
		$hour = $this->input->post("hour");
		$status = $this->input->post("status");
		$developer = $this->input->post("developer");

		$deadline_date = $this->input->post("deadline");
		$developer = $this->input->post("developer");
		$priority = $this->input->post("priority");
		$type = $this->input->post("type");
		$attachments = $this->input->post("attachments");
		$complete_per = $this->input->post("complete_per");
		$start_date = $this->input->post("start_date");
		$end_date = $this->input->post("end_date");
		
		$this->form_validation->set_rules('project', 'Project', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('hour', 'Hour', 'required');
		$this->form_validation->set_rules('minute', 'Minute', 'required');
		//$this->form_validation->set_rules('developer', 'Developer', 'required');
		
		$this->load->model('Designation_Model');
		$this->load->model('Project_Model');
		$this->load->model('Project_Task_Model');

		if($this->form_validation->run() == false)
		{
			$this->session->set_flashdata('message', validation_errors());
			redirect(base_url('project_task/add'));

		}else{
			if(!isset($id) || empty($id)){
				$min=($hour*60)+$minute;
				$arr=array(
					'project_id' => $project,
					'title' => $title,
					'description' => $description,
					'minute' => $min,
					'developer' => implode(',', $developer),
					'status' => $status,
					'deadline_date' => $deadline_date,
					'priority' => $priority,
					'type' => $type,
					'attachments' => $attachments,
					'complete_percentage' => $complete_per,
					'start_date' => $start_date,
					'end_date' => $end_date,
					
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
					'developer' => implode(',', $developer),
					'status' => $status,
					'deadline_date' => $deadline_date,
					'priority' => $priority,
					'type' => $type,
					'attachments' => $attachments,
					'complete_percentage' => json_encode($complete_per),
					'start_date' => json_encode($start_date),
					'end_date' => json_encode($end_date),
				);

				$insert_employee= $this->Project_Task_Model->update_employee($arr);
				if($insert_employee){
					
					redirect(base_url('project_task'));
				}				
			}
		}
	}

}
