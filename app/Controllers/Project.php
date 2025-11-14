<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$user_session=$this->session->userdata('id');
		if(!$user_session){
			redirect(base_url());	
		}
	}
	//designation
	public function index()
	{
		$user_role=$this->session->userdata('user_role');
		if($user_role != 'admin'){
			redirect('dashboard');	
		}
		$data=array();
		$data['page_title']="Project";
		$data['js_flag']="project_js";
		$data['menu']="project";
		$this->lib->view('administrator/project/list_project',$data);
	}
	public function employee_pagination()
	{
		$user_role=$this->session->userdata('user_role');
		if($user_role != 'admin'){
			redirect('dashboard');	
		}
		//Designation_Model
		$this->load->model('employee_Model');
		$this->load->model('Designation_Model');
		$this->load->model('Project_Model');
		$user_role=$this->session->userdata('user_role');
		$columns = array( 
                            0 =>'id', 
                            1 =>'title',
                            2 =>'client_name',
                            3 =>'action', 
                        );
		
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Project_Model->allposts_count();
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $posts = $this->Project_Model->allposts($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value'] ; 

            $posts =  $this->Project_Model->posts_search($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Project_Model->posts_search_count($search);
        }
		
          $data = array();
        if(!empty($posts))
        {
		 foreach ($posts as $post)
            {
            	$nestedData['id'] = "<span>".$post->id ."</span>";
                $nestedData['title'] = $post->title;
                $nestedData['client_name'] = $post->client_name;
               
                $nestedData['action'] ='<a href="'.base_url('project/add').'/'.$post->id.'" class="btn btn-danger waves-effect waves-light">Edit</a> <a data-id="'.$post->id.'" class="btn btn-danger waves-effect waves-light  delete-employee">Delete</a>';
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
		$user_role=$this->session->userdata('user_role');
		if($user_role != 'admin'){
			redirect('dashboard');	
		}
		$this->load->model('Designation_Model');
		$this->load->model('Project_Model');
		$this->load->model('employee_Model');
		$data=array();
		if($this->uri->segment(3)){
			$data['page_title']="Edit Project";
			$id=$this->uri->segment(3);
			$data['list_data']= $this->Project_Model->get_employee($id);
		}else{
			$data['page_title']="Add Project";
			$data['list_data']="";
		}
		$data['get_developer']= $this->employee_Model->get_developer();

		$data['js_flag']="project_js";
		$data['menu']="project_add";
		$this->lib->view('administrator/project/add_project',$data);
	}
	public function delete_employee(){
		$user_role=$this->session->userdata('user_role');
		if($user_role != 'admin'){
			redirect('dashboard');	
		}
		$this->load->model('Designation_Model');
		$this->load->model('Project_Model');

		$id = $this->input->post("id");
		$delete_employee= $this->Project_Model->delete_employee($id);
	
	}
	public function insert_data()
	{	
		$user_role=$this->session->userdata('user_role');
		if($user_role != 'admin'){
			redirect('dashboard');	
		}
		$id = $this->input->post("e_id");
		$title = $this->input->post("title");
		$client_name = $this->input->post("client_name");
		$admin_credential = $this->input->post("admin_credential");
		$developer_credential = $this->input->post("developer_credential");
		$developer = $this->input->post("developer");
		$start_date = $this->input->post("start_date");
		$end_date = $this->input->post("end_date");
		
		$this->form_validation->set_rules('title', 'Title', 'required');
		
		$this->load->model('Designation_Model');
		$this->load->model('Project_Model');

		if($this->form_validation->run() == false)
		{
			$this->session->set_flashdata('message', validation_errors());
			redirect(base_url('project/add'));

		}else{
			
			if($developer==""){
				$dev="";
			}
			else{
				$dev=implode(',', $developer);
			}
			if(!isset($id) || empty($id)){
				$arr=array(
					'title' => $title,
					'client_name' => $client_name,
					'admin_credential' => $admin_credential,
					'developer_credential' => $developer_credential,
					'developer' => $dev,
					'start_date' => $start_date,
					'end_date' => $end_date,

				);
				$insert_employee= $this->Project_Model->insert_employee($arr);
				if($insert_employee){
					redirect(base_url('project'));
				}

			}else{
				
				$arr=array(
					'id' => $id,
					'title' => $title,
					'client_name' => $client_name,
					'admin_credential' => $admin_credential,
					'developer_credential' => $developer_credential,
					'developer' => $dev,
					'start_date' => $start_date,
					'end_date' => $end_date,
				);
				$insert_employee= $this->Project_Model->update_employee($arr);
				if($insert_employee){
					redirect(base_url('project'));
				}				
			}
		}
	}
}
