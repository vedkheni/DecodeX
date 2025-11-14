<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Candidates extends BaseController {

    public function __construct()
    {   
        parent::__construct();
        $user_session = $this->session->get('id');
        if (!$user_session)
        {
            return redirect()->to(base_url());
        }
    }

	public function index()
	{
		$user_role = $this->session->get('user_role');
        if ($user_role != 'admin')
        {
            return redirect()->to('dashboard');
        }
        $user_session = $this->session->get('id');
        if (!$user_session)
        {
            return redirect()->to(base_url('admin'));
        }

        $data = array();
		$data['designation'] = $this->Designation_Model->get_designation();
        $data['page_title'] = "Candidates";
        $data['js_flag'] = "candidates_js";
        $data['menu'] = "candidates";
		$data['candidates']  = $this->Candidate_Model->get_candidates_all();

        $this->lib->view('administrator/candidates/list_candidates', $data);
	}
	 public function list_candidates(){
       
        $designation = $this->request->getPost('designation');
        $schedule_type = $this->request->getPost('schedule_type');
        $interviewDate = Format_date($this->request->getPost('interviewDate'));
        // echo $interviewDate;exit;

        $designation_list = $this->Designation_Model->get_designation();
		$user_role=$this->session->get('user_role');
		$columns = array( 
                            0 => 'candidates.id',
                            1 => 'candidates.name',
                            2 => 'candidates.designation',
                            3 => 'candidates.interview_status',
                            4 => 'candidates.location',
                            5 => 'interview_schedule.interview_date',
                            6 => 'candidates.skills',
                        );
		
		$limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];
  
        $totalData = $this->Candidate_Model->allposts_count($designation,$schedule_type,$interviewDate);
        $totalFiltered = $totalData; 
            
        if(empty($this->request->getPost('search')['value']))
        {            
            $posts = $this->Candidate_Model->allposts($designation,$schedule_type,$interviewDate,$limit,$start,$order,$dir);
        }
        else {
            $search = $this->request->getPost('search')['value'] ; 

            $posts =  $this->Candidate_Model->posts_search($designation,$schedule_type,$interviewDate,$limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Candidate_Model->posts_search_count($designation,$schedule_type,$interviewDate,$search);
        }
        $data = array();
        if(!empty($posts))
        {
		 $i=0;
		 foreach ($posts as $post)
            {
                foreach ($designation_list as $key => $value) { if($value->id == $post->designation){ $d = ucwords($value->name); } }
                $d = (isset($d) && !empty($d))? $d : '' ;
                $list_interview_schedule = $this->Candidate_Model->interview_schedule($post->id);
                if($schedule_type == 'unscheduled'){
                    // echo "IF1";exit;
                    if(!isset($list_interview_schedule[0]->interview_date) || $post->interview_status == 'unscheduled'){
                        $interview_date = '';
                        $schedule_id = '';
                        $title = 'Schedule Interview';
                        $class = 'btn-interview-schedule';
                        $button = '';
                        $edit_btn = '<button type="button" data-id="'.$post->id.'" class="btn btn-outline-danger ml-2 editCandidate_detail" title="Edit">Edit</button>';
                        $action = '<button type="button" data-id="'.$post->id.'" data-schedule="" data-date="'.$interview_date.'" class="btn sec-btn sec-btn-outline '.$class.' interview_schedule" title="'.$title.'">'.$title.'</button>'.$button.$edit_btn;
                        $i++;
                    }
                }elseif($schedule_type == 'fixed'){
                    // echo "IF2";exit;
                    if(isset($list_interview_schedule[0]->interview_date) && $list_interview_schedule[0]->interview_date != '0000-00-00'){
                        $interview_date = dateFormat($list_interview_schedule[0]->interview_date);
                        $interview_time = date('h:i A',(strtotime($list_interview_schedule[0]->interview_time)));
                        $schedule_id = $list_interview_schedule[0]->id;
                        $title = 'View Schedule';
                        $class = 'btn-view-schedule';
                        $button = '<button type="button" data-id="'.$post->id.'" data-schedule="'.$schedule_id.'" data-date="'.$interview_date.'" data-time="'.$interview_time.'" data-designation="'.$d.'" data-name="'.$post->name.'" class="btn sec-btn sec-btn-outline mail_send mx-2" title="Send Mail">Send Mail</button>';
                       
                        $action = '<button type="button" data-id="'.$post->id.'" data-schedule="'.$list_interview_schedule[0]->id.'" data-date="'.$interview_date.'" class="btn sec-btn sec-btn-outline '.$class.' interview_schedule" title="'.$title.'">'.$title.'</button>'.$button;
                        
                        $i++;
                    }
                }elseif($schedule_type == 'inprocess'){
                    // echo "IF3";exit;
                    if(isset($list_interview_schedule[0]->interview_date) && $list_interview_schedule[0]->interview_date != '0000-00-00' && isset($list_interview_schedule[0]->interview_status)){
                        $interview_date = dateFormat($list_interview_schedule[0]->interview_date);
                        $interview_time = date('h:i A',(strtotime($list_interview_schedule[0]->interview_time)));
                        $schedule_id = $list_interview_schedule[0]->id;
                        $title = 'View Schedule';
                        $class = 'btn-view-schedule';
                        $button = '<button type="button" data-id="'.$post->id.'" data-schedule="'.$schedule_id.'" data-date="'.$interview_date.'" data-time="'.$interview_time.'" data-designation="'.$d.'" data-name="'.$post->name.'" class="btn sec-btn sec-btn-outline mail_send mx-2" title="Send Mail">Send Mail</button>';
                        $action = '<button type="button" data-id="'.$post->id.'" data-schedule="'.$list_interview_schedule[0]->id.'" data-date="'.$interview_date.'" class="btn sec-btn sec-btn-outline '.$class.' interview_schedule" title="'.$title.'">'.$title.'</button>'.$button;
                        $i++;
                    }
                }elseif($schedule_type == 'all_candidate' || $schedule_type == 'reject' || $schedule_type == 'pending'){
                    // echo "IF4";exit;
                    if(isset($list_interview_schedule[0]->interview_date) && $list_interview_schedule[0]->interview_date != '0000-00-00'){
                        $interview_date = dateFormat($list_interview_schedule[0]->interview_date);
                        $interview_time = (empty($list_interview_schedule[0]->interview_time)) ? '' : date('h:i A',(strtotime($list_interview_schedule[0]->interview_time)));
                        $schedule_id = $list_interview_schedule[0]->id;
                        $title = 'View Schedule';
                        $class = 'btn-view-schedule';
                        $button = '<button type="button" data-id="'.$post->id.'" data-schedule="'.$schedule_id.'" data-date="'.$interview_date.'" data-time="'.$interview_time.'" data-designation="'.$d.'" data-name="'.$post->name.'" class="btn sec-btn sec-btn-outline mail_send mx-2" title="Send Mail">Send Mail</button>';
                        $edit_btn = '';
                        $action = '<button type="button" data-id="'.$post->id.'" data-schedule="'.$schedule_id.'" data-date="'.$interview_date.'" class="btn sec-btn sec-btn-outline '.$class.' interview_schedule" title="'.$title.'">'.$title.'</button>'.$button.$edit_btn;
                    }else{
                        $schedule_id = '';
                        $interview_date = '';
                        $title = 'Schedule Interview';
                        $class = 'btn-interview-schedule';
                        $button = '';
                        $edit_btn = '<button type="button" data-id="'.$post->id.'" class="btn btn-outline-danger ml-2 editCandidate_detail" title="Edit">Edit</button>';
                        $action = '<button type="button" data-id="'.$post->id.'" data-schedule="'.$schedule_id.'" data-date="'.$interview_date.'" class="btn sec-btn sec-btn-outline '.$class.' interview_schedule" title="'.$title.'">'.$title.'</button>'.$button.$edit_btn;
                    }
                    if($schedule_type == 'reject' && isset($post->interview_status) && $post->interview_status == 'reject'){
                        $i++;
                    }elseif($schedule_type == 'all_candidate' || $schedule_type == 'pending'){
                        $i++;
                    }
                }
                $nestedData['#'] = '<input type="checkbox" name="chek1" class="candidate_check" value="'.$post->id.'">';
                $nestedData['id'] = "<span>".$i ."</span>";
                $nestedData['name'] = $post->name;
                $nestedData['designation'] = $d; 
                $nestedData['status'] = ucwords($post->interview_status); 
                $nestedData['location'] = ucwords($post->location);
                $nestedData['interview_date'] = (isset($list_interview_schedule[0]->interview_date) && $list_interview_schedule[0]->interview_date != '0000-00-00')? dateFormat($list_interview_schedule[0]->interview_date) :' - '; 
                $nestedData['action']=$action;
                /*  <button type="button" data-id="'.$post->id.'" data-schedule="'.$schedule_id.'" class="btn btn-outline-danger ml-2 delete_candidate" title="Delete">Delete</button> */
                $data[] = $nestedData;
                /* <a class="btn sec-btn sec-btn-outline login-employee" href="'.base_url('candidates/add/'.$post->id).'" title="Edit">Edit</a> */  
            }
        }
        $json_data = array(
                    "draw"            => intval($this->request->getPost('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    ); 
       echo json_encode($json_data); 

    }

	public function add()
	{
		$data=array();
		$user_session=$this->session->get('id');
		$user_role=$this->session->get('user_role');
		if(!$user_session){
			return redirect()->to(base_url('login'));	
		}

		$data['designation']= $this->Designation_Model->get_designation();
		$data['menu']="candidates_add";		
		if($user_role == 'admin'){
			$data['page_title']="Candidates";
			$user_session=$this->session->get('id');
			$admin_detail=$this->Administrator_Model->admin_profile($user_session);
			$data['profile']=$admin_detail;
			$data['js_flag']="candidates_js";
			$user_session=$this->session->get('id');
			$get_candidates="";
            $candidatesid = $this->uri->getSegment(2)?$this->uri->getSegment(3):'';
			if($candidatesid){
				$get_candidates = $this->Candidate_Model->get_candidates($candidatesid);
			}
			$data['list_data']=$get_candidates;
			$this->lib->view('administrator/candidates/add_candidates',$data);
		}else{
			$employee_detail=$this->employee_Model->get_employee($user_session);
			$data['profile']=$employee_detail;
			//echo "<pre/>";
			//print_r($employee_detail);
			$decode_credentials=json_decode($employee_detail[0]->credential);
			$user_session=$this->session->get('id');
			$this->session->set('user_id',$employee_detail[0]->id);
			$this->session->set('username',$employee_detail[0]->fname);
			$this->session->set('useremail',$employee_detail[0]->email);
			$this->session->set('profile_image',$employee_detail[0]->profile_image);
			$data['page_title']="Team & Condition";
			//$data['js_flag']="emp_js";
			$data['js_flag']="team_and_condition";
			$this->lib->view('administrator/employee/team_and_condition',$data);
		}

	}
	public function insert_data(){
		$user_role = $this->session->get('user_role');
        if ($user_role != 'admin')
        {
            return redirect()->to('profile');
        }
		/* candidates_upload_resume */
		$id = $this->request->getPost("id");
		$name = $this->request->getPost("name");
		$designation = $this->request->getPost("designation");
		$email = $this->request->getPost("email");
		$gender = $this->request->getPost("gender");
		$experience = $this->request->getPost("experience");
		$phone_number = $this->request->getPost("phone_number");
		$address = $this->request->getPost("address");
		$current_salary = $this->request->getPost("current_salary");
		$expected_salary = $this->request->getPost("expected_salary");
		$upload_resume_name = $this->request->getPost("upload_resume_name");
		$skills = $this->request->getPost("skills");
		/* $interview_date = $this->request->getPost("interview_date");
		$interview_status = $this->request->getPost("interview_status");
		$feedback = $this->request->getPost("feedback"); */
		
        $this->form_validation->reset();
        $this->form_validation->setRule('name', 'Name', 'required');
        $this->form_validation->setRule('experience', 'Experience', 'required');
        $this->form_validation->setRule('phone_number', 'Phone Number', 'required');
        $this->form_validation->setRule('address', 'Address', 'required');
        $this->form_validation->setRule('current_salary', 'Current Salary', 'required');
        $this->form_validation->setRule('expected_salary', 'Expected Salary', 'required');
		$this->form_validation->setRule('email', 'Email', 'required|valid_email');
        $this->form_validation->setRule('designation', 'Designation', 'required');
        $this->form_validation->setRule('gender', 'Gender', 'required');
        $this->form_validation->setRule('skills', 'Skills', 'required');
        /* $this->form_validation->setRule('interview_date', 'interview_date', 'required');
        $this->form_validation->setRule('interview_status', 'interview_status', 'required'); 
        $this->form_validation->setRule('feedback', 'feedback', 'required'); */
        if ($this->validate( $this->form_validation->getRules()) == false)
        {
            $this->session->setFlashdata('message', $this->validator->listErrors());
            return redirect()->to(base_url('candidates/add'));

        }
        else
        {
            // $url = $_SERVER['DOCUMENT_ROOT'].'/assets/upload/candidates_upload_resume';
            // $url = $_SERVER['DOCUMENT_ROOT'].'/assets/upload/candidates_upload_resume';
            $url = $_SERVER['DOCUMENT_ROOT'].'/assets/upload/candidates_upload_resume';
            /* $config['upload_path'] = $url;
            $config['allowed_types'] = 'pdf|jpg|jpeg|png|docx'; */
            /* $config['max_size'] = 2000;
            $config['max_width'] = 1500;
            $config['max_height'] = 1500; */

            // $this->load->library('upload', $config);
            $file = $this->request->getFile("upload_resume");
            $profile_image = $file->getName();
            $upload_resume="";
            $this->form_validation->reset();
            $this->form_validation->setRule('upload_resume', 'Upload Resume', "uploaded[upload_resume]|mime_in[upload_resume,file,image/jpg,image/jpeg,image/png,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword]");
            if($this->validate( $this->form_validation->getRules()) == false){
                if($id == ""){
                    $this->session->setFlashdata('message',$this->validator->listErrors());
                    return redirect()->to(base_url().'candidates/add');
                }else{
                    $this->session->setFlashdata('message',$this->validator->listErrors());
                    return redirect()->to(base_url().'candidates/add/'.$id);
                }
            }else{
                // if(!$this->upload->do_upload('upload_resume')) {
                if(!$file->move($url, $profile_image)) {
                    //$error = array('error' => $this->upload->display_errors());
                    if($id == ""){
                        $this->session->setFlashdata('message','<span class="error_Success">Failed to move file</sapn>');
                        return redirect()->to(base_url().'candidates/add');
                    }else{
                        if($upload_resume_name == ""){
                            $this->session->setFlashdata('message','<span class="error_Success">Failed to move file</sapn>');
                            return redirect()->to(base_url().'candidates/add/'.$id);
                        }else{
                            $upload_resume=$upload_resume_name;
                        }
                    }
                } else {
                    $data = $file;
                    $upload_resume=$data->getClientName();
                    //print_r($data);
                    //die;
                }   
            }
			if(empty($id)){
			$arr = array(
                    'name' => $name,
                    'email' => $email,
                    'phone_number' => $phone_number,
                    'designation' => $designation,
                    'gender' => $gender,
                    'experience' => $experience,
                    'current_salary' => $current_salary,
                    'expected_salary' => $expected_salary,
                    'upload_resume' => $upload_resume,
                    /* 'interview_date' => date('Y-m-d h:i:s', strtotime($interview_date)) ,
                    'interview_status' => $interview_status, */
                    'location' => $address,
                    /* 'feedback' => $feedback, */
                    'skills' => $skills,
                    'interview_status' => 'unscheduled',
                    'created_date' => date('Y-m-d h:i:s'),
                );
				$insert_employee = $this->Candidate_Model->insert_candidate($arr);
			}else{
				$arr = array(
					'id' => $id,
                    'name' => $name,
                    'email' => $email,
                    'phone_number' => $phone_number,
                    'designation' => $designation,
                    'gender' => $gender,
                    'experience' => $experience,
                    'current_salary' => $current_salary,
                    'expected_salary' => $expected_salary,
                    'upload_resume' => $upload_resume,
                    /* 'interview_date' => date('Y-m-d h:i:s', strtotime($interview_date)) ,
                    'interview_status' => $interview_status, */
                    'location' => $address,
                    /* 'feedback' => $feedback, */
                    'skills' => $skills,
                    'created_date' => date('Y-m-d h:i:s'),
                );
				$update_employee = $this->Candidate_Model->update_candidate($arr);
			}
			//echo "<br>";
			//echo $this->db->last_query();
			return redirect()->to(base_url().'candidates');
		}
    }
    public function get_candidates(){
        $data = array();
        $data['designation']= $this->Designation_Model->get_designation();
        if($this->request->getPost('id')){
            $candidatesid = $this->request->getPost('id');
            $list_interview_schedule = $this->Candidate_Model->interview_schedule($candidatesid);
            if($list_interview_schedule){
                $list_interview_schedule[0]->hr_skill = unserialize($list_interview_schedule[0]->hr_skill);
                $list_interview_schedule[0]->interview_date = dateFormat($list_interview_schedule[0]->interview_date);
                $list_interview_schedule[0]->joining_date = dateFormat($list_interview_schedule[0]->joining_date);
                $list_interview_schedule[0]->technical_skill = unserialize($list_interview_schedule[0]->technical_skill);
            }
            $data['list_interview_schedule'] = $list_interview_schedule;
            $list_data = $this->Candidate_Model->get_candidates($candidatesid);
            if($list_data){
                // $image1=$_SERVER['DOCUMENT_ROOT']."/assets/upload/candidates_upload_resume/".$list_data[0]->upload_resume;
                $image1=$_SERVER['DOCUMENT_ROOT']."/assets/upload/candidates_upload_resume/".$list_data[0]->upload_resume;
                if(file_exists($image1)){
                    $list_data[0]->upload_resume = $list_data[0]->upload_resume;
                }else{
                    $list_data[0]->upload_resume = '';
                }
            }
            $data['list_data'] = $list_data;
        }
        echo json_encode($data);
    }
    public function update(){
        $data = array();
        $id = $this->request->getPost("id");
		$name = $this->request->getPost("name");
		$designation = $this->request->getPost("designation");
		$email = $this->request->getPost("email");
		$gender = $this->request->getPost("gender");
		$experience = $this->request->getPost("experience");
		$phone_number = $this->request->getPost("phone_number");
		$address = $this->request->getPost("address");
		$current_salary = $this->request->getPost("current_salary");
		$expected_salary = $this->request->getPost("expected_salary");
		$upload_resume_name = $this->request->getPost("upload_resume_name");
        $skills = $this->request->getPost("skills");
        $i_s_id = $this->request->getPost("i_s_id");
        
        $this->form_validation->reset();
        $this->form_validation->setRule('name', 'Name', 'required');
        $this->form_validation->setRule('experience', 'Experience', 'required');
        $this->form_validation->setRule('phone_number', 'Phone Number', 'required');
        $this->form_validation->setRule('address', 'Address', 'required');
        $this->form_validation->setRule('current_salary', 'Current Salary', 'required');
        $this->form_validation->setRule('expected_salary', 'Expected Salary', 'required');
		$this->form_validation->setRule('email', 'Email', 'required|valid_email');
        $this->form_validation->setRule('designation', 'Designation', 'required');
        $this->form_validation->setRule('gender', 'Gender', 'required');
        $this->form_validation->setRule('skills', 'Skills', 'required');

        if($this->request->getPost('data_type') == 'schedule_detail'){
            $interview_date = Format_date($this->request->getPost("interview_date"));
            $this->form_validation->setRule('interview_date', 'Interview Date', 'required');
        }
        
        if($this->validate( $this->form_validation->getRules()) == false){
            $data['error_code'] = 1;
            $html = '';
            /* $error_mg = explode('</p>',$this->validator->listErrors());
            foreach($error_mg as $key => $value){
                if($key != (count($error_mg)-1)){
                    $html .= '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">'.$value.'</p></div></div></div>';
                }
            } */
            $html .= '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">'.$this->validator->listErrors().'</p></div></div></div>';
            $data['message'] = $html;
        }else{
            // $url = $_SERVER['DOCUMENT_ROOT'].'/assets/upload/candidates_upload_resume';
            $url = $_SERVER['DOCUMENT_ROOT'] . '/assets/upload/candidates_upload_resume';
            $file = $this->request->getFile("upload_resume");
            $profile_image = $file->getName();
            $upload_resume = "";
            $this->form_validation->reset();
            $this->form_validation->setRule('upload_resume', 'Upload Resume', "uploaded[upload_resume]|mime_in[upload_resume,image/jpg,image/jpeg,image/png,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword]");
            if ($this->validate( $this->form_validation->getRules()) == false) {
                $upload_resume=$upload_resume_name;
            } else {
                $upload_resume="";
                if (!$file->move($url, $profile_image)) {
                    $upload_resume=$upload_resume_name;
                } else {
                    // $data = $file;
                    $upload_resume = $file->getClientName();
                }
            }
            $arr = array(
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'phone_number' => $phone_number,
                'designation' => $designation,
                'gender' => $gender,
                'experience' => $experience,
                'current_salary' => $current_salary,
                'expected_salary' => $expected_salary,
                'upload_resume' => $upload_resume,
                'location' => $address,
                'skills' => $skills,
                'updated_date' => date('Y-m-d h:i:s'),
            );
            $update_employee = $this->Candidate_Model->update_candidate($arr);
            if($this->request->getPost('data_type') == 'schedule_detail'){
                if($i_s_id){
                    $arr1 = array(
                        'id' => $i_s_id,
                        'candidate_id' => $id,
                        'interview_date' => $interview_date,
                    );
                    $insert_hrround_detail = $this->Candidate_Model->update_hrround_detail($arr1);
                    $insert_hrround_detail = $i_s_id;
                }else{
                    $arr1 = array(
                        'candidate_id' => $id,
                        'traning_period' => '',
                        'interview_date' => $interview_date,
                    );
                    $insert_hrround_detail = $this->Candidate_Model->insert_hrround_detail($arr1);
                }
                $arr_1 = array(
                    'id' => $id,
                    'interview_status' => 'fixed',
                );
            }else{
                $insert_hrround_detail = true;
                $arr_1 = array(
                    'id' => $id,
                    'interview_status' => 'unscheduled',
                );
            }
            $update = $this->Candidate_Model->update_candidate($arr_1);
            if(!empty($update_employee) && !empty($insert_hrround_detail)){
                $data['insert_id'] = $insert_hrround_detail;
                $data['upload_resume'] = $upload_resume;
                $data['error_code'] = 0;
                $data['message'] = '<div class="msg-box success-box">
                <div class="msg-content">
                <div class="msg-icon"><i class="fas fa-check"></i></div>
                <div class="msg-text"><p>Interview Schedule Fixed successfully.</p></div>
                </div>
                </div>';
            } else {
                $data['upload_resume'] = $upload_resume;
                $data['error_code'] = 1;
                $data['message'] = '<div class="msg-box error-box">
                    <div class="msg-content">
                    <div class="msg-icon"><i class="fas fa-times"></i></div>
                            <div class="msg-text"><p>Interview Schedule Fixed field!</p></div>
                            </div>
                            </div>';
            }
        }
            // $update_employee = true;
            echo json_encode($data);
    }
    public function update_hrround_detail(){
        $data = array();
        $hr_skills_arr = array(0 => 'Good Communication',1 => 'Interpersonal Skills',2 => 'Time Management',);
        // $hr_skills_arr = array(0 => 'Good Communication',1 => 'Screening',2 => 'Sourcing',3 => 'Interpersonal Skills',4 => 'Selection Process',5 => 'Time Management',6 => 'Hiring',7 => 'Recruitment',8 => 'Convincing Power',);
        $hrround_id = $this->request->getPost("hrround_id");
        $candidate_id = $this->request->getPost("candidate_id");
        $interview_date = Format_date($this->request->getPost("interview_date"));
        $interview_status = $this->request->getPost("interview_status");
        $hr_feedback = $this->request->getPost("hr_feedback");
        $hr_skills_rate = explode(',',$this->request->getPost("hr_skills"));
        $this->form_validation->reset();
        $this->form_validation->setRule('interview_status', 'Interview Status', 'required');
        $this->form_validation->setRule('hr_feedback', 'Hr Feedback', 'required');
        $this->form_validation->setRule('hr_skills', 'Skills Set', 'required');
        
        if($this->validate( $this->form_validation->getRules()) == false)
        {
            $data['error_code'] = 1;
            $html = '';
            $error_mg = explode('</p>',$this->validator->listErrors());
            foreach($error_mg as $key => $value){
                if($key != (count($error_mg)-1)){
                    $html .= '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">'.$value.'</p></div></div></div>';
                }
            }
            $data['message'] = $html;
        }else{
            $hr_skills_arr1 = array();
            for($i = 0; $i < count($hr_skills_arr);$i++){
                $hr_skills_arr1[str_replace(' ','_',strtolower($hr_skills_arr[$i]))] = $hr_skills_rate[$i];
            }
            $hr_skill = serialize($hr_skills_arr1);
            if($hrround_id){
                $arr = array(
                    'id' => $hrround_id,
                    'candidate_id' => $candidate_id,
                    'interview_date' => $interview_date,
                    'interview_status' => $interview_status,
                    'hr_skill' => $hr_skill,
                    'hr_feedback' => $hr_feedback,
                    'updated_date' => date('Y-m-d h:i:s'),
                );
                $update_hrround_detail = $this->Candidate_Model->update_hrround_detail($arr);
                if($interview_status != 'select'){
                    $arr1 = array(
                        'id' => $candidate_id,
                        'interview_status' => $interview_status,
                    );   
                }else{
                    $arr1 = array(
                        'id' => $candidate_id,
                        'interview_status' => 'inprocess',
                    );
                }
                $update_employee = $this->Candidate_Model->update_candidate($arr1);
                // $update_hrround_detail = true;
                if($update_hrround_detail){
                    $data['error_code'] = 0;
                    $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>HR Round Cleared.</p></div></div></div>';
                }else{
                    $data['error_code'] = 1;
                    $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Hr round detail updated field!</p></div></div></div>';
                }
            }   
        }
        echo json_encode($data);
    }
    public function update_tcround_detail(){
        $data = array();
        $tcround_id = $this->request->getPost("tcround_id");
        $candidate_id = $this->request->getPost("c_id");
        $tc_skills_arr = explode(', ',$this->request->getPost("skill"));
        $taken_by = $this->request->getPost("taken_by");
        $tc_feedback = $this->request->getPost("technical_feedback");
        $tc_skills_rate = explode(',',$this->request->getPost("technical_skill"));
        $this->form_validation->reset();
        $this->form_validation->setRule('technical_feedback', 'Technical Feedback', 'required');
        $this->form_validation->setRule('taken_by', 'Taken By', 'required');
        $this->form_validation->setRule('technical_skill', 'Technical Skills Set', 'required');
        
        if($this->validate( $this->form_validation->getRules()) == false)
        {
            $data['error_code'] = 1;
            $html = '';
            $error_mg = explode('</p>',$this->validator->listErrors());
            foreach($error_mg as $key => $value){
                if($key != (count($error_mg)-1)){
                    $html .= '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">'.$value.'</p></div></div></div>';
                }
            }
            $data['message'] = $html;
        }else{
            $tc_skills_arr1 = array();
            for($i = 0; $i < count($tc_skills_arr);$i++){
                    $tc_skills_arr1[str_replace(' ','_',str_replace('?','',strtolower($tc_skills_arr[$i])))] = $tc_skills_rate[$i];
            }
            $tc_skill = serialize($tc_skills_arr1);

            $arr = array(
                'id' => $tcround_id,
                'candidate_id' => $candidate_id,
                'taken_by' => $taken_by,
                'technical_skill' => $tc_skill,
                'technical_feedback' => $tc_feedback,
                'updated_date' => date('Y-m-d h:i:s'),
            );
            $update_tcround_detail = $this->Candidate_Model->update_hrround_detail($arr);
            // $update_tcround_detail = true;
            if($update_tcround_detail){
                $data['error_code'] = 0;
                $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Technical Round Cleared.</p></div></div></div>';
            }else{
                $data['error_code'] = 1;
                $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Technical round detail updated field!</p></div></div></div>';
            }   
        }
        echo json_encode($data);
    }
    public function update_fround_detail(){
        $data = array();
        $fround_id = $this->request->getPost("fround_id");
        $candidate_id = $this->request->getPost("c1_id");
        $salary = $this->request->getPost("salary");
        $traning_period = $this->request->getPost("traning_period");
        $employee_status = $this->request->getPost("employee_status");
        $joining_date = Format_date($this->request->getPost("joining_date"));
        $remark = $this->request->getPost("remark");
        $final_satus = $this->request->getPost("final_satus");
        $this->form_validation->reset();
        if($final_satus != 'reject'){
            $this->form_validation->setRule('salary', 'Salary', 'required');
            $this->form_validation->setRule('employee_status', 'Employee Status', 'required');
            $this->form_validation->setRule('joining_date', 'Joining Date', 'required');
            $this->form_validation->setRule('remark', 'Remark', 'required');
        }
        $this->form_validation->setRule('final_satus', 'Satus', 'required');
        
        if($this->validate( $this->form_validation->getRules()) == false)
        {
            $data['error_code'] = 1;
            $html = '';
            $error_mg = explode('</p>',$this->validator->listErrors());
            foreach($error_mg as $key => $value){
                if($key != (count($error_mg)-1)){
                    $html .= '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">'.$value.'</p></div></div></div>';
                }
            }
            $data['message'] = $html;
        }else{
            if($final_satus != 'reject'){
                $arr = array(
                    'id' => $fround_id,
                    'candidate_id' => $candidate_id,
                    'salary' => $salary,
                    'joining_date' => $joining_date,
                    'employee_status' => $employee_status,
                    'traning_period' => $traning_period,
                    'remark' => $remark,
                    'status' => $final_satus,
                    'updated_date' => date('Y-m-d h:i:s'),
                );
            }else{
                $arr = array(
                    'id' => $fround_id,
                    'candidate_id' => $candidate_id,
                    'status' => $final_satus,
                    'updated_date' => date('Y-m-d h:i:s'),
                );
            }
            $final_satus1 = ($final_satus == 'onhold')?'inprocess':$final_satus;
            $final_satus1 = ($final_satus == 'select')?'complete':$final_satus;
            $arr1 = array(
                'id' => $candidate_id,
                'interview_status' => $final_satus1,
            );
            $update_employee = $this->Candidate_Model->update_candidate($arr1);
            $update_tcround_detail = $this->Candidate_Model->update_hrround_detail($arr);
            // $update_tcround_detail = true;
            if($update_tcround_detail){
                $data['error_code'] = 0;
                $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Technical Round Cleared.</p></div></div></div>';
            }else{
                $data['error_code'] = 1;
                $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Technical round detail updated field!</p></div></div></div>';
            }   
        }
        echo json_encode($data);
    }
    public function delete_candidate(){
        $data = array();
        $id = $this->request->getPost("id");
        $all_date=explode(',',$id);
        if($id)
        {
            // $id = $this->request->getPost("id");
            for($i = 0; $i < count($all_date); $i++)
            {
                $candidate = $this->Candidate_Model->delete_candidate($all_date[$i]);
                $schedule = $this->Candidate_Model->delete_schedule($all_date[$i]);
                // $delete_employee = $this->employee_Model->delete_employee($id[$i]);
            }
            if($candidate){
                $data['error_code'] = 0;
                $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Candidate deleted.</p></div></div></div>';
            }else{
                $data['error_code'] = 1;
                $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Candidate field to delete!</p></div></div></div>'; 
            }
        }else{
            $data['error_code'] = 1;
            $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Candidate not Found!</p></div></div></div>';  
        }
        
        /* $schedule_id = $this->request->getPost("schedule_id");
        if($schedule_id){
            $candidate = $this->Candidate_Model->delete_candidate($id);
            $schedule = $this->Candidate_Model->delete_schedule($schedule_id,$id);
            if($candidate && $schedule){
                $data['error_code'] = 0;
                $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Candidate Deleted successfully.</p></div></div></div>'; 
            }else{
                $data['error_code'] = 1;
                $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Candidate Deleted field!</p></div></div></div>'; 
            }
        }else{
            $candidate = $this->Candidate_Model->delete_candidate($id); 
            if($candidate){
                $data['error_code'] = 0;
                $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Candidate Deleted successfully.</p></div></div></div>';
            }else{
                $data['error_code'] = 1;
                $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Candidate Deleted field!</p></div></div></div>'; 
            }
        } */
        echo json_encode($data);
    }
    public function send_mail(){
        $data = array();
        $id = $this->request->getPost("id");
        $schedule_id = $this->request->getPost("schedule_id");
        $time = $this->request->getPost("time");
        $interview_date = $this->request->getPost("interview_date");
        $position = $this->request->getPost("designation");
        $candidate = $this->Candidate_Model->get_candidates($id); 
        $schedule = $this->Candidate_Model->interview_schedule_by_id($schedule_id);
        // $schedule_detail = $this->Mail_Content_Model->interview_schedule_by_id($schedule_id);
        $data1 = array();
        // echo '<pre>'; print_r( $schedule ); echo '</pre>';exit;
        if(isset($schedule[0]->mail) && $schedule[0]->mail == 1){
            $content = $this->Mail_Content_Model->mail_content_by_slug('reminder_interview_mail');
            $variables = array(
                "{{date}}" => $interview_date,
                "{{time}}" => $time,
           );
           $data1['mail_type'] = 'reminder_interview_mail';
           $data1['subject'] = 'Reminder Interview Mail';
           $data1['title'] = 'Reminder Interview Schedule';
           $data1['img_name'] = 'interview-reminder.png';
        }else{
            $content = $this->Mail_Content_Model->mail_content_by_slug('interview_schedule_mail');
            $variables = array(
                "{{date}}" => $interview_date,
                "{{time}}" => $time,
                "{{position}}" => $position,
           );
           $data1['mail_type'] = 'interview_schedule_mail';
           $data1['subject'] = 'scheduling the interview for the '.$position.' position at Geek Web Solution';
           $data1['title'] = 'Interview Schedule Fixed';
           $data1['img_name'] = 'interview-schedule.png';
        }
       $message = $content[0]->content;
        foreach ($variables as $key => $value){
            $message = str_replace($key, $value, $message);
        }

        $data1['greeting'] = 'Dear';
        $data1['message'] = $message;
        $data1['name'] = $candidate[0]->name;
        $data1['to'] = $candidate[0]->email;
        $data1['base_url'] = base_url();
        
        $arr = array(
            'id' => $schedule_id,
            'mail' => '1',
            'interview_time' => date('h:i A',(strtotime($time))),
            'updated_date' => date('Y-m-d h:i:s'),
        );   
        $mail_send = $this->Candidate_Model->mail_send_status($arr);
        // $mail_send = true;
        if($mail_send){
            $mail_send_code = $this->mailfunction->mail_send($data1);
            if($mail_send_code == 1){
                $data['error_code'] = 0;
                $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Interview mail sent.</p></div></div></div>';   
            }else{
                $data['error_code'] = 2;
                $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Interview mail field to send!</p></div></div></div>';
            }
        }else{
            $data['error_code'] = 1;
            $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Interview mail field send!</p></div></div></div>';
        }
        echo json_encode($data);

    }

    public function upload_excel(){
        $data=array();
		$user_session=$this->session->get('id');
		$user_role=$this->session->get('user_role');
		if(!$user_session){
			return redirect()->to(base_url().'login');	
		}

		$data['designation']= $this->Designation_Model->get_designation();
		$data['menu']="candidates_add";	
        $data['page_title']="Candidates";
			$user_session=$this->session->get('id');
			$admin_detail=$this->Administrator_Model->admin_profile($user_session);
			$data['profile']=$admin_detail;
			$data['js_flag']="candidates_js";
			$user_session=$this->session->get('id');
			$get_candidates="";
			if($this->uri->getSegment(3)){
				$candidatesid = $this->uri->getSegment(3);
				$get_candidates = $this->Candidate_Model->get_candidates($candidatesid);
			}
			$data['list_data']=$get_candidates;
        $this->lib->view('administrator/candidates/add_candidates',$data);
    }
    public function import_excel(){
        $this->load->library('exportexcel');
        $data = array();
        $data1 = array();
        $designation_list= $this->Designation_Model->get_designation();
        if(isset($_FILES["docx"]["name"]))
		{
			$path = $_FILES["docx"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
            $arr = range('A','Z');
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();

				for($row=2; $row<=$highestRow; $row++)
				{
                    $name = $phone_number = $designation = $email = $experience = $current_salary = $expected_salary = $link = $status = $remark = $interview_date = '';
                    for($row1=0; $row1<=24; $row1++){
                        if($worksheet->getCellByColumnAndRow($row1, 1)->getValue() == 'Name'){
                            $name .= $worksheet->getCellByColumnAndRow($row1, $row)->getValue();
                        }
                        if($worksheet->getCellByColumnAndRow($row1, 1)->getValue() == 'Mobile'){
                            $phone_number .= $worksheet->getCellByColumnAndRow($row1, $row)->getValue();
                        }
                        if($worksheet->getCellByColumnAndRow($row1, 1)->getValue() == 'Post'){
                            $designation .= $worksheet->getCellByColumnAndRow($row1, $row)->getValue();
                        }
                        if($worksheet->getCellByColumnAndRow($row1, 1)->getValue() == 'Email'){
                            $email .= $worksheet->getCellByColumnAndRow($row1, $row)->getValue();
                        }
                        if($worksheet->getCellByColumnAndRow($row1, 1)->getValue() == 'Exp'){
                            $experience .= $worksheet->getCellByColumnAndRow($row1, $row)->getValue();
                        }
                        if($worksheet->getCellByColumnAndRow($row1, 1)->getValue() == 'C.Salary'){
                            $current_salary .= $worksheet->getCellByColumnAndRow($row1, $row)->getValue();
                        }
                        if($worksheet->getCellByColumnAndRow($row1, 1)->getValue() == 'Ex.Salary'){
                            $expected_salary .= $worksheet->getCellByColumnAndRow($row1, $row)->getValue();
                        }
                        if($worksheet->getCellByColumnAndRow($row1, 1)->getValue() == 'CV Link'){
                            $link .= $worksheet->getCellByColumnAndRow($row1, $row)->getValue();
                        }

                        /* === === */
                        if($worksheet->getCellByColumnAndRow($row1, 1)->getValue() == 'Status'){
                            $status .= $worksheet->getCellByColumnAndRow($row1, $row)->getValue();
                        }
                        if($worksheet->getCellByColumnAndRow($row1, 1)->getValue() == 'Remark'){
                            $remark .= $worksheet->getCellByColumnAndRow($row1, $row)->getValue();
                        }
                        if($worksheet->getCellByColumnAndRow($row1, 1)->getValue() == 'Interview Date'){
                            $interview_date .= $worksheet->getCellByColumnAndRow($row1, $row)->getValue();
                        }
                    }
                    /* $name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $phone_number = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $designation = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $email = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $experience = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $current_salary = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $expected_salary = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $link = $worksheet->getCellByColumnAndRow(10, $row)->getValue(); */
                    $phone_number = explode(', ',$phone_number);

                    if($name != ''){
                        $filename = str_replace('__','_',preg_replace('/[^A-Za-z0-9\-]/', '_', strtolower($name))).'.pdf';
                        // $filename = substr($link, strrpos($link, '/') + 1);
                        // file_put_contents($_SERVER['DOCUMENT_ROOT'].'/assets/temp_resume/'.$filename, file_get_contents($link));
                        $skills = '';
                        foreach($designation_list as $key => $d){
                            if( $d->name == $designation){
                                $skills = $d->skills;
                                $designation = $d->id;
                            }
                        }
                       $data[] = array(
                            'name' => $name,
                            'email' => $email,
                            'phone_number' => $phone_number[0],
                            'designation' => $designation,
                            'gender' => '',
                            'experience' => $experience,
                            'current_salary' => $current_salary,
                            'expected_salary' => $expected_salary,
                            'upload_resume' => $filename,
                            'location' => '',
                            'skills' => $skills,
                            'created_date' => date('Y-m-d h:i:s'),
                        );
                        $data1[] = array(
                            'interview_date' => $interview_date,
                            'status' => $status,
                            'remark' => $remark,
                        );
                    }
                   /*  $status = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $interview_date = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $remark = $worksheet->getCellByColumnAndRow(11, $row)->getValue(); */
                    /* $data1[] = array(
                        'interview_date' => $interview_date,
                        'status' => $status,
                        'remark' => $remark,
                    ); */
				}
			}
            echo '<pre>'; print_r( $data ); echo '</pre>';
            echo '<pre>'; print_r( $data1 ); echo '</pre>';exit;
		}else{
            return redirect()->to(base_url().'candidates/upload_excel');
        }
    }
    
    function apache_request_headers() {
		static $arrHttpHeaders;
		if (!$arrHttpHeaders) {

			// Based on: http://www.iana.org/assignments/message-headers/message-headers.xml#perm-headers
			$arrCasedHeaders = array(
				// HTTP
				'Dasl'             => 'DASL',
				'Dav'              => 'DAV',
				'Etag'             => 'ETag',
				'Mime-Version'     => 'MIME-Version',
				'Slug'             => 'SLUG',
				'Te'               => 'TE',
				'Www-Authenticate' => 'WWW-Authenticate',
				// MIME
				'Content-Md5'      => 'Content-MD5',
				'Content-Id'       => 'Content-ID',
				'Content-Features' => 'Content-features',
			);
			$arrHttpHeaders = array();

			foreach($_SERVER as $strKey => $mixValue) {
				if('HTTP_' !== substr($strKey, 0, 5)) {
					continue;
				}

				$strHeaderKey = strtolower(substr($strKey, 5));

				if(0 < substr_count($strHeaderKey, '_')) {
					$arrHeaderKey = explode('_', $strHeaderKey);
					$arrHeaderKey = array_map('ucfirst', $arrHeaderKey);
					$strHeaderKey = implode('-', $arrHeaderKey);
				}
				else {
					$strHeaderKey = ucfirst($strHeaderKey);
				}

				if(array_key_exists($strHeaderKey, $arrCasedHeaders)) {
					$strHeaderKey = $arrCasedHeaders[$strHeaderKey];
				}

				$arrHttpHeaders[$strHeaderKey] = $mixValue;
			}

			/** in case you need authorization and your hosting provider has not fixed this for you:
				* VHOST-Config: 
				* FastCgiExternalServer line needs    -pass-header Authorization
				*
				* .htaccess or VHOST-config file needs: 
				* SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1
				* to add the Authorization header to the environment for further processing
			 */
			if (isset($arrHttpHeaders['Authorization']) && $arrHttpHeaders['Authorization']) {
				// in case of Authorization, but the values not propagated properly, do so :)
				if (!isset($_SERVER['PHP_AUTH_USER'])) {
					list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':' , base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
				}
			}
		}
		return $arrHttpHeaders;
	}
    public function test_importdata(){
        $arr = json_decode(file_get_contents("php://input"), true);
        echo '<pre>'; print_r( get_api_header() ); echo '</pre>';exit;
        // echo '<pre>'; print_r( $arr ); echo '</pre>';exit;
        echo '<pre>'; print_r( $this->apache_request_headers() ); echo '</pre>';exit;
        echo '<pre>'; print_r( get_headers() ); echo '</pre>';exit;
        $headers = apache_request_headers();
        if(isset($headers['Authorization'])){
            echo '<pre>'; print_r( $headers['Authorization'] ); echo '</pre>';
            $matches = array();
            preg_match('/Token token="(.*)"/', $headers['Authorization'], $matches);
            if(isset($matches[1])){
                $token = $matches[1];
                echo '<pre>'; print_r( $token ); echo '</pre>';exit;
            }
        } 
        $designation_list= $this->Designation_Model->get_designation();
        $candidate_data = $this->Candidate_Model->get_exxel_data('all_designation');
        
        $data = array();
        $data1 = array();
        $skills = array();
        $designation = array();
        
        foreach($designation_list as $key => $d){
            $skills[$d->name] = $d->skills;
            $designation[$d->name] = $d->id;
        }
        
        $unique = array();
        foreach($candidate_data as $keys => $val){
            $number = $val->phone_number;
            $unique[] = $number;
        }

        foreach($arr as $k => $value) {
            if(!in_array($value['phone_number'],$unique)){
                /* $status = '';
                if($value['status'] == 'Rejected'){
                    $status = 'reject';
                }elseif($value['status'] == 'Selected'){
                    $status = 'select';
                }elseif($value['status'] == 'Pending'){
                    $status = 'onhold';
                } */
                $location = ($value['location'] != '')?$value['location'] :'Surat';
                $filename = preg_replace("/\s+/", "_",preg_replace("/[^a-zA-Z0-9_ .]/s","_",$value['upload_resume']));
                
                // $filename = substr($value['resume_data'], strrpos($value['resume_data'], '/') + 1);
                if($filename != ""){
                    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/assets/upload/candidates_upload_resume/'.$filename, file_get_contents(urldecode($value['resume_data'])));
                }
                $designation1 = (in_array($value['designation'],array_keys($designation)))?$designation[$value['designation']]:''; 
                $skills1 = (in_array($value['designation'],array_keys($skills)))?$skills[$value['designation']]:'';
                $data = array(
                    'name' => $value['name'],
                    'email' => $value['email'],
                    'phone_number' => $value['phone_number'],
                    'designation' => $designation1,
                    'gender' => '',
                    'experience' => $value['experience'],
                    'current_salary' => $value['current_salary'],
                    'expected_salary' => $value['expected_salary'],
                    'upload_resume' => $filename,
                    'location' => $location,
                    'skills' => $skills1,
                    'created_date' => date('Y-m-d h:i:s',strtotime(Format_date($value['created_date']))),
                );
               // echo $filename;
                $insert_employee = $this->Candidate_Model->insert_candidate($data);
               //$insert_employee = true;
                /* if($insert_employee){
                    $data1 = array(
                        'candidate_id' => $insert_employee,
                        'interview_date' => Format_date($value['interview_date']),
                        'status' => strtolower($status),
                        'remark' => $value['remark'],
                    );
                   $insert_hrround_detail = $this->Candidate_Model->insert_hrround_detail($data1);
                }  */                   
                if($insert_employee){
                    echo "Data added.";
                }else{
                    echo "Data field to add.";
                }
            }
        }
        // echo json_encode($data);
        /* echo '<pre>'; print_r( $data ); echo '</pre>';
        echo '<pre>'; print_r( $data1 ); echo '</pre>';exit; */ 
        // echo '<pre>'; print_r( $arr ); echo '</pre>';exit;
    }

    public function importdata(){
        $arr = json_decode(file_get_contents("php://input"), true);
        // echo '<pre>'; print_r( $arr ); echo '</pre>';exit;
        $designation_list= $this->Designation_Model->get_designation();
        // $candidate_data = $this->Candidate_Model->get_exxel_data('all_designation');
        $candidate_data = $this->Candidate_Model->get_candidates_all();
        
        $data = array();
        $data1 = array();
        $skills = array();
        $designation = array();
        
        foreach($designation_list as $key => $d){
            $skills[$d->name] = $d->skills;
            $designation[$d->name] = $d->id;
        }
        
        $unique = array();
        foreach($candidate_data as $keys => $val){
            $number = $val->phone_number;
            if(!empty($number) && $number != ' ' ){
                array_push($unique,$number);
            }
        }
        
        foreach($arr as $k => $value) {
            if(!in_array($value['phone_number'],$unique)){
                /* $status = '';
                if($value['status'] == 'Rejected'){
                    $status = 'reject';
                }elseif($value['status'] == 'Selected'){
                    $status = 'select';
                }elseif($value['status'] == 'Pending'){
                    $status = 'onhold';
                } */
                $location = ($value['location'] != '')?$value['location'] :'Surat';
                $filename = preg_replace("/\s+/", "_",preg_replace("/[^a-zA-Z0-9_ .]/s","_",$value['upload_resume']));
                
                // $filename = substr($value['resume_data'], strrpos($value['resume_data'], '/') + 1);
                if($filename != ""){
                    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/assets/upload/candidates_upload_resume/'.$filename, file_get_contents(urldecode($value['resume_data'])));
                }
                $designation1 = (in_array($value['designation'],array_keys($designation)))?$designation[$value['designation']]:''; 
                $skills1 = (in_array($value['designation'],array_keys($skills)))?$skills[$value['designation']]:'';
                $num = 0;
                if(empty($value['email']) || empty($value['phone_number'])){
                    $num++;
                }
                if(empty($designation1)){
                    $num++;
                }
                if(empty(str_replace('  ', ' ',preg_replace("/[^a-zA-Z0-9_ ]/s",' ',$value['name'])))){
                    $num++;
                }
                if(empty($value['gender'])){
                    $num++;
                }
                if(empty($skills1)){
                    $num++;
                }
                if($num == 0){

                    $data = array(
                        'name' => str_replace('  ', ' ',preg_replace("/[^a-zA-Z0-9_ ]/s",' ',$value['name'])),
                        'email' => $value['email'],
                        'phone_number' => $value['phone_number'],
                        'designation' => $designation1,
                        'gender' => strtolower($value['gender']),
                        'experience' => $value['experience'],
                        'current_salary' => $value['current_salary'],
                        'expected_salary' => $value['expected_salary'],
                        'upload_resume' => $filename,
                        'location' => $location,
                        'skills' => $skills1,
                        'created_date' => date('Y-m-d h:i:s',strtotime(Format_date($value['created_date']))),
                    );
                    // echo $filename;
                    $insert_employee = $this->Candidate_Model->insert_candidate($data);
                }
                    //$insert_employee = true;
                /* if($insert_employee){
                    $data1 = array(
                        'candidate_id' => $insert_employee,
                        'interview_date' => Format_date($value['interview_date']),
                        'status' => strtolower($status),
                        'remark' => $value['remark'],
                    );
                   $insert_hrround_detail = $this->Candidate_Model->insert_hrround_detail($data1);
                }  */                   
                if($insert_employee){
                    echo "Data added.";
                }else{
                    echo "Data field to add.";
                }
            }else{
                echo "Candidate already exist.";
            }
        }
        // echo json_encode($data);
        // echo '<pre>'; print_r( $data ); echo '</pre>';exit;
        // echo '<pre>'; print_r( $arr ); echo '</pre>';exit;
    }
    
	public function create_table(){
        // echo $this->db->query("ALTER TABLE `candidates` CHANGE `interview_status` `interview_status` ENUM('unscheduled','fixed','inprocess','reject','pending','complete') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'unscheduled'");
       // echo $this->db->query("ALTER TABLE `candidates` CHANGE `gender` `gender` ENUM('','male','female') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
       /* echo $this->db->query("CREATE TABLE `daily_work` ( `id` int(11) PRIMARY KEY AUTO_INCREMENT, `employee_id` INT(11) NOT NULL, `attendance_date` date NOT NULL, `daily_work` LONGTEXT NOT NULL, `created_date` datetime NOT NULL DEFAULT current_timestamp(), `updated_date` datetime DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1");
       echo $this->db->query("CREATE TABLE `interview_schedule` ( `id` int(11) PRIMARY KEY AUTO_INCREMENT, `candidate_id` INT(11) NOT NULL, `interview_date` date NOT NULL, `interview_status` enum('select', 'pending', 'reject') NOT NULL, `hr_skill` LONGTEXT NOT NULL, `hr_feedback` LONGTEXT NOT NULL, `technical_skill` LONGTEXT NOT NULL, `technical_feedback` LONGTEXT NOT NULL, `taken_by` varchar(100) NOT NULL, `salary` varchar(100) NOT NULL, `joining_date` date NOT NULL, `employee_status` enum('training', 'employee') NOT NULL, `traning_period` varchar(255) NOT NULL, `remark` LONGTEXT NOT NULL, `status` enum('select', 'onhold', 'reject') NOT NULL, `mail` enum('0', '1') NOT NULL, `interview_time` varchar(100) NOT NULL, `created_date` datetime NOT NULL DEFAULT current_timestamp(), `updated_date` datetime DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1");
       echo $this->db->query("CREATE TABLE `candidates` ( `id` int(11) PRIMARY KEY AUTO_INCREMENT, `name` varchar(50) NOT NULL, `email` varchar(50) NOT NULL, `phone_number` varchar(50) NOT NULL, `gender` varchar(50) NOT NULL, `designation` varchar(50) NOT NULL, `experience` varchar(50) NOT NULL, `current_salary` DECIMAL(10,2) NOT NULL, `expected_salary` DECIMAL(10,2) NOT NULL, `upload_resume` varchar(100) NOT NULL, `interview_status` enum('pending','reject','complete') NOT NULL, `location` LONGTEXT NOT NULL, `skills` LONGTEXT NOT NULL, `created_date` datetime NOT NULL DEFAULT current_timestamp(), `updated_date` datetime DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1");
       echo $this->db->query("CREATE TABLE `mail_content` ( `id` int(11) PRIMARY KEY AUTO_INCREMENT, `name` varchar(50) NOT NULL, `content` LONGTEXT NOT NULL, `slug` varchar(50) NOT NULL, `created_date` datetime NOT NULL DEFAULT current_timestamp(), `updated_date` datetime DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1"); */
       /*  echo $this->db->query("CREATE TABLE `daily_work` (
            `id` int(11) PRIMARY KEY AUTO_INCREMENT,
            `employee_id` INT(11) NOT NULL,
            `attendance_date` date NOT NULL,
            `daily_work` LONGTEXT NOT NULL,
            `created_date` datetime NOT NULL DEFAULT current_timestamp(),
            `updated_date` datetime DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"); */
        //   echo $this->db->last_query();
        //   echo $this->db->query("TRUNCATE TABLE `daily_work`");
           
        // ALTER TABLE `candidates` CHANGE `feedback` `skills` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
		/* echo $this->db->query("ALTER TABLE `candidates` CHANGE `feedback` `skills` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL");
		echo $this->db->query("ALTER TABLE `candidates` CHANGE `address` `location` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL"); */
		//echo $this->db->query("ALTER TABLE `candidates` MODIFY COLUMN `interview_date` DATE");
        /* echo $this->db->query("ALTER TABLE `interview_schedule` ADD `candidate_id` INT(11) NULL AFTER `id`"); */
        /* echo $this->db->query("ALTER TABLE `interview_schedule` ADD `salary` varchar(100) NULL AFTER `taken_by`");
        echo $this->db->query("ALTER TABLE `interview_schedule` ADD `joining_date` date NOT NULL AFTER `salary`");
        echo $this->db->query("ALTER TABLE `interview_schedule` ADD `employee_status` enum('training', 'employee') NOT NULL AFTER `joining_date`");
        echo $this->db->query("ALTER TABLE `interview_schedule` ADD `traning_period` varchar(255) NULL AFTER `employee_status`");
        echo $this->db->query("ALTER TABLE `interview_schedule` ADD `remark` LONGTEXT NOT NULL AFTER `traning_period`");
        echo $this->db->query("ALTER TABLE `interview_schedule` ADD `status` enum('select', 'onhold', 'reject') NOT NULL AFTER `remark`"); */
        // echo $this->db->query("ALTER TABLE `interview_schedule` ADD `mail` enum('0', '1') NOT NULL AFTER `status`");
        // echo $this->db->query("ALTER TABLE `interview_schedule` ADD `interview_time` time NOT NULL AFTER `mail`");
		// echo $this->db->query("ALTER TABLE `interview_schedule` MODIFY COLUMN `interview_time` varchar(100)");
        // echo $this->db->query("TRUNCATE TABLE `interview_schedule`");
        /* echo $this->db->query("CREATE TABLE `mail_content` (
            `id` int(11) PRIMARY KEY AUTO_INCREMENT,
            `name` varchar(50) NOT NULL,
            `content` LONGTEXT NOT NULL,
            `slug` varchar(50) NOT NULL,
            `created_date` datetime NOT NULL DEFAULT current_timestamp(),
            `updated_date` datetime DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
         */
        /* echo $this->db->query("CREATE TABLE `candidates` (
		  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
		  `name` varchar(50) NOT NULL,
		  `email` varchar(50) NOT NULL,
		  `phone_number` varchar(50) NOT NULL,
		  `gender` varchar(50) NOT NULL,
		  `designation` varchar(50) NOT NULL,
		  `experience` varchar(50) NOT NULL,
		  `current_salary` DECIMAL(10,2) NOT NULL,
		  `expected_salary` DECIMAL(10,2) NOT NULL,
		  `upload_resume` varchar(100) NOT NULL,
		  `interview_status` enum('pending','reject','complete') NOT NULL,
		  `location` LONGTEXT NOT NULL,
		  `skills` LONGTEXT NOT NULL,
		  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
		  `updated_date` datetime DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"); */
        
        /* echo $this->db->query("CREATE TABLE `interview_schedule` (
		  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
		  `candidate_id` INT(11) NOT NULL,
		  `interview_date` date NOT NULL,
		  `interview_status` enum('select', 'pending', 'reject') NOT NULL,
		  `hr_skill` LONGTEXT NOT NULL,
		  `hr_feedback` LONGTEXT NOT NULL,
		  `technical_skill` LONGTEXT NOT NULL,
		  `technical_feedback` LONGTEXT NOT NULL,
          `taken_by` varchar(100) NOT NULL,
          `salary` varchar(100) NOT NULL,
          `joining_date` date NOT NULL,
          `employee_status` enum('training', 'employee') NOT NULL,
          `traning_period` varchar(255) NOT NULL,
          `remark` LONGTEXT NOT NULL,
          `status` enum('select', 'onhold', 'reject') NOT NULL,
          `mail` enum('0', '1') NOT NULL,
          `interview_time` varchar(100) NOT NULL,
		  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
		  `updated_date` datetime DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"); */

        /* echo $this->db->query("CREATE TABLE `mail_content` (
            `id` int(11) PRIMARY KEY AUTO_INCREMENT,
            `name` varchar(50) NOT NULL,
            `content` LONGTEXT NOT NULL,
            `slug` varchar(50) NOT NULL,
            `created_date` datetime NOT NULL DEFAULT current_timestamp(),
            `updated_date` datetime DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
         */
        /* echo $this->db->query("CREATE TABLE `candidates` (
		  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
		  `name` varchar(50) NOT NULL,
		  `email` varchar(50) NOT NULL,
		  `phone_number` varchar(50) NOT NULL,
		  `gender` varchar(50) NOT NULL,
		  `designation` varchar(50) NOT NULL,
		  `experience` varchar(50) NOT NULL,
		  `current_salary` DECIMAL(10,2) NOT NULL,
		  `expected_salary` DECIMAL(10,2) NOT NULL,
		  `upload_resume` varchar(100) NOT NULL,
		  `interview_status` enum('pending','reject','complete') NOT NULL,
		  `location` LONGTEXT NOT NULL,
		  `skills` LONGTEXT NOT NULL,
		  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
		  `updated_date` datetime DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"); */
        
        /* echo $this->db->query("CREATE TABLE `interview_schedule` (
		  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
		  `candidate_id` INT(11) NOT NULL,
		  `interview_date` date NOT NULL,
		  `interview_status` enum('select', 'pending', 'reject') NOT NULL,
		  `hr_skill` LONGTEXT NOT NULL,
		  `hr_feedback` LONGTEXT NOT NULL,
		  `technical_skill` LONGTEXT NOT NULL,
		  `technical_feedback` LONGTEXT NOT NULL,
          `taken_by` varchar(100) NOT NULL,
          `salary` varchar(100) NOT NULL,
          `joining_date` date NOT NULL,
          `employee_status` enum('training', 'employee') NOT NULL,
          `traning_period` varchar(255) NOT NULL,
          `remark` LONGTEXT NOT NULL,
          `status` enum('select', 'onhold', 'reject') NOT NULL,
          `mail` enum('0', '1') NOT NULL,
          `interview_time` varchar(100) NOT NULL,
		  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
		  `updated_date` datetime DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"); */
        
	}
}


?>