<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Internship extends BaseController {
	public function __construct()
	{
		parent::__construct();
		$user_session=$this->session->get('id');
		if(!$user_session){
			return redirect()->to(base_url());	
		}

		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
	}

	public function index(){
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$data=array();
		$data['js_flag']="internship_js";
		$data['page_title']="Internship";

		// $get_employee_internship_data= $this->Employee_Internship_Model->get_employee_internship_data($id,'');
		// $data['get_employee_internship_data']=$get_employee_internship_data;
		$json = file_get_contents(base_url('assets/json/surat-colleges.json'));
		$data['colleges'] = json_decode($json);

		$data['menu']="internship";
        $this->lib->view('administrator/internship/internship',$data);
	}

	public function insert_intern(){
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$id=$this->request->getPost('id');
		$data = array();
		$data['error_code'] = 0;
		$name=$this->request->getPost('name');
		$contact_number=$this->request->getPost('contact_number');
		$email=$this->request->getPost('email');
		$address=$this->request->getPost('address');
		$college_or_university=$this->request->getPost('college_or_university');
		$course=$this->request->getPost('course');
		$internship_start_date=$this->request->getPost('internship_start_date');
		$internship_end_date=$this->request->getPost('internship_end_date');
		$feedback=$this->request->getPost('feedback');
		$feedback_status=$this->request->getPost('feedback_status');

		$this->form_validation->reset();
		$this->form_validation->setRule('name','Name','required');
		$this->form_validation->setRule('email','Email','required|valid_email|max_length[254]');
		$this->form_validation->setRule('contact_number','Contact Number','required|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->setRule('address','Address','required');
		$this->form_validation->setRule('college_or_university','College/University','required');
		$this->form_validation->setRule('course','Course','required');
		$this->form_validation->setRule('internship_start_date','Internship Start Date','required');

        if ($this->validate($this->form_validation->getRules()) == false) {
            $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' . $this->validator->listErrors() . '</p></div></div></div>';
		}else{
			$arr=array(
				"id" => $id,
				"name" => $name,
				"contact_number" => $contact_number,
				"email" => $email,
				"address" => $address,
				"college_or_university" => $college_or_university,
				"course" => $course,
				"internship_start_date" => date('Y-m-d', strtotime($internship_start_date)),
				"internship_end_date" => !empty($internship_end_date) ? date('Y-m-d', strtotime($internship_end_date)) : '',
				"feedback" => $feedback,
				"feedback_status" => $feedback_status,
			); 

			if(!empty($id)){
				$intern=$this->Internship_Model->update_intern($arr);
				if($intern){
					$data['error_code'] = 0;
					$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Intern detail updated.</p></div></div></div>';
				}else{
					$data['error_code'] = 1;
					$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Intern detail failed to update!</p></div></div></div>';
				}
			}else{
				$intern=$this->Internship_Model->insert_intern($arr);
				if($intern){
					$data['error_code'] = 0;
					$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Intern detail added.</p></div></div></div>';
				}else{
					$data['error_code'] = 1;
					$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Intern detail failed to add!</p></div></div></div>';
				}
			}
		}
		echo json_encode($data);
		
	}
	public function intern_list(){
	
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}

		$columns = array( 
			0 =>'id', 
			1 =>'name',
			2 =>'contact_number', 
			3 =>'email',
			4 =>'address',
			5 =>'college_or_university',
			6 =>'course',
			7 =>'internship_start_date',
			8 =>'internship_end_date',
			9 =>'feedback',
			10 =>'feedback_status',
		);
		
		$limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];
  
        $totalData = $this->Internship_Model->allposts_count();
            
        $totalFiltered = $totalData; 
            
        if(empty($this->request->getPost('search')['value']))
        {            
            $posts = $this->Internship_Model->allposts($limit,$start,$order,$dir);
        }
        else {
            $search = $this->request->getPost('search')['value'] ; 

            $posts =  $this->Internship_Model->posts_search($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Internship_Model->posts_search_count($search);
        }
		
          $data = array();
        if(!empty($posts))
        {
		 $i=1;
		 foreach ($posts as $post)
            {
				$post->internship_start_date = date('d M, Y',strtotime($post->internship_start_date));
            	$post->internship_end_date = !empty($post->internship_end_date) && $post->internship_end_date == '0000-00-00' ? date('d M, Y',strtotime($post->internship_end_date)) : '';
            	$nestedData['id'] = "<span>".$i ."</span>";
                $nestedData['name'] = $post->name;
                $nestedData['contact_number'] = $post->contact_number;
				$nestedData['email'] = $post->email;
				$nestedData['course'] = $post->course;
                $nestedData['internship_start_date'] = $post->internship_start_date;
				$nestedData['feedback_status'] = $post->feedback_status;
				$nestedData['action']='<button data-id="'.$post->id.'" class="show-intern-detail btn btn-outline-primary">Detail</button><button data-id="'.$post->id.'" class="edit-intern-detail m-l-5 btn btn-outline-secondary">Edit</button><button data-id="'.$post->id.'" class="btn btn-outline-danger m-l-5 delete-intern">Delete</button>';
              	$data[] = $nestedData;
				$i++;
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

	public function get_intern_detail(){
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$data = array();
		$id = $this->request->getPost("id");
		if($id){
			$data['error_code'] = 0;
			$data['detail'] = $this->Internship_Model->get_intern($id);
			$data['detail'][0]->start_date = date('d M, Y',strtotime($data['detail'][0]->internship_start_date));
            $data['detail'][0]->end_date = !empty($data['detail'][0]->internship_end_date) && $data['detail'][0]->internship_end_date == '0000-00-00' ? date('d M, Y',strtotime($data['detail'][0]->internship_end_date)) : '';
		}else{
			$data['error_code'] = 1;
			$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Intern id not found!</p></div></div></div>';
		}
		echo json_encode($data, true);exit;
	}
	
	function delete_intern(){
		$id=$this->request->getPost('id');
		if($id){
			$res = ($id) ? $this->db->table('internship')->where('id',$id)->delete() : '';

			echo ($res) ? '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Intern detail deleted.</p></div></div></div>' : '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Intern detail failed to delete!</p></div></div></div>';exit;
		}else{
			echo '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Intern id not found!</p></div></div></div>';exit;
		}
	}
}
