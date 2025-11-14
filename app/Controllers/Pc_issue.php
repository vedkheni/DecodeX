<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Pc_issue extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $user_session = $this->session->get('id');
        if (!$user_session)
        {
            return redirect()->to(base_url());
        }
    }

	public function index(){
		$user_role = $this->session->get('user_role');
        $user_session = $this->session->get('id');
        if (!$user_session)
        {
            return redirect()->to(base_url('admin'));
        }
        
        $data = array();
        $data['page_title'] = "Pc Issue";
        $data['js_flag'] = "pc_issue_js";
        $data['menu'] = "pc_issue";
        $data['get_pc_data']=$get_pc=$this->Pc_Issue_Model->getPc_id($user_session);
        $data['pc_issue']  = $this->Pc_Issue_Model->get_pcIssue_all();
        if($user_role == 'admin'){
            $data['employee_list'] = $this->Employee_Model->get_employee_list(1);
        }

        $this->lib->view('administrator/pc_issue/list_pc_issue', $data);
	}

	public function list_pcIssue(){

        $employee_list = $this->Employee_Model->get_employee_list(1);
		$user_role=$this->session->get('user_role');
        if($user_role == 'admin'){
            $id='';
        }else{
            $id=$this->session->get('id');
        }
		$columns = array( 
            0 => 'id',
            1 => 'issue',
            2 => 'description',
            3 => 'pc_id',
            4 => 'status',
        );
		
		$limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];
        $totalData = $this->Pc_Issue_Model->allposts_count($id);
        
        $totalFiltered = $totalData; 
        
        $posts = $this->Pc_Issue_Model->allposts($id,$limit,$start,$order,$dir);
        if(empty($this->request->getPost('search')['value'])){            
            $search = '';
        }else {
            $search = strtolower($this->request->getPost('search')['value']); 
            if(!empty($posts))$totalFiltered = count($posts);
            else $totalFiltered = 0;
            // $posts =  $this->Pc_Issue_Model->posts_search($id,$limit,$start,$search,$order,$dir);
            
            // $totalFiltered = $this->Pc_Issue_Model->posts_search_count($id,$search);
        }
        $data = array();
        $i=$num=0;
        if(!empty($posts))
        {
		 foreach ($posts as $post)
            {
                foreach ($employee_list as $key => $value){if($value->id == $post->employee_id){ $name = ucwords($value->fname).' '.ucwords($value->lname); } }
                $issue = '';
                if($post->issue == 'software'){
                    $screenshort = explode(',',$post->screenshorts);
                    foreach ($screenshort as $k => $v){ $issue .= '<a href="'.base_url().'assets/upload/issue_ss/'.$v.'" data-fancybox="image_group'.$i.'" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>'; }
                    // foreach ($screenshort as $k => $v){ $issue .= '<a target="_blank" class="view_resume" title="View Resume" href="'.base_url('assets/upload/issue_ss/').$v.'"><i class="fas fa-eye"></i></a>'; }
                }else{
                    $issue = preg_replace( '/ /', ', ', ucwords(preg_replace( '/,/', ' ', $post->hardware_part)));
                }
                if (empty($search) || strpos(strtolower($name), $search) !== false || strpos(strtolower($issue), $search) !== false || strpos(strtolower($post->issue), $search) !== false || strpos(strtolower($post->pc_id), $search) !== false || strpos(strtolower($post->description), $search) !== false) {
                    if($user_role != 'admin'){
                        $nestedData['#'] = "<span>".($i+1) ."</span>";
                        $nestedData['type_issue'] = ucwords($post->issue);
                        $nestedData['issue'] = $issue;
                        $nestedData['description'] = '<button type="button" class="view_description btn sec-btn sec-btn-outline" data-description="'.ucwords($post->description).'" >View Description</button>';
                        $nestedData['pc_id'] = 'System Id - '. $post->pc_id;
                        $nestedData['status'] = '<span class="'.$post->status.'">'.ucwords($post->status).'</span>';
                        $nestedData['action']='<button data-id="'.$post->id.'" data-pc_id="'.$post->pc_id.'" class="btn sec-btn sec-btn-outline edit" >Edit</button>';
                        // $nestedData['action']='<button type="button" data-id="'.$post->id.'" data-pc_id="'.$post->pc_id.'" class="btn sec-btn sec-btn-outline" title="Edit">Edit</button>';
                        /* <button type="button" data-id="'.$post->id.'" data-schedule="'.$schedule_id.'" class="btn btn-outline-danger ml-2 delete_candidate" title="Delete">Delete</button> */
                    }else{
                        $nestedData['#'] = "<span>".($i+1) ."</span>";
                        $nestedData['employee'] = $name;
                        $nestedData['type_issue'] = ucwords($post->issue);
                        $nestedData['issue'] = $issue;
                        // $nestedData['description'] = $post->description.'<button type="button" class="view_description btn sec-btn sec-btn-outline" data-description="'.ucwords($post->description).'" >View Description</button>';
                        $nestedData['description'] = '<button type="button" class="view_description btn sec-btn sec-btn-outline" data-description="'.ucwords($post->description).'" >View Description</button>';
                        $nestedData['pc_id'] = 'System Id -'. $post->pc_id;
                        $nestedData['status'] = '<button type="button" class="change_status btn sec-btn sec-btn-outline '.$post->status.'" data-status="'.$post->status.'" data-id="'.$post->id.'" >'.ucwords($post->status).'</button>';
                        $nestedData['action']='<button data-id="'.$post->id.'" data-pc_id="'.$post->pc_id.'" class="btn sec-btn sec-btn-outline edit_pc_issue" >Edit</button><button type="button" data-id="'.$post->id.'" class="btn btn-outline-danger ml-2 delete_pc_issue" title="Delete">Delete</button> ';
                        // $nestedData['action']='<a href="'.base_url('pc_issue/add').'/'.$post->id.'" data-id="'.$post->id.'" data-pc_id="'.$post->pc_id.'" class="btn sec-btn sec-btn-outline" title="Edit">Edit</a><button type="button" data-id="'.$post->id.'" class="btn btn-outline-danger ml-2 delete_pc_issue" title="Delete">Delete</button> ';
                    }
                    $data[] = $nestedData;
                    $i++;
                }else{
                    $num++;
                }
            }
        }
        $totalFiltered -= $num;
        $json_data = array(
            "draw"            => intval($this->request->getPost('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        ); 
       echo json_encode($json_data);exit;

    }

	public function add(){
		$data=array();
		$user_session=$this->session->get('id');
		$user_role=$this->session->get('user_role');
        $admin_detail=$this->Administrator_Model->admin_profile($user_session);
		if(!$user_session){
            return redirect()->to(base_url('login'));	
		}
        
		$data['menu']="add_pc_issue";
        $data['page_title']="Add Pc Issue";
        $data['profile']=$admin_detail;
        $data['get_pc_data']=$get_pc=$this->Pc_Issue_Model->getPc_id($user_session);
        $data['js_flag']="pc_issue_js";

        $get_pc_issue="";
        if($this->uri->getSegment(3)){
            $issueid = $this->uri->getSegment(3);
            $get_pc_issue = $this->Pc_Issue_Model->get_pcIssue($issueid);
        }
        $data['list_data']=$get_pc_issue;
        if($user_role == 'admin' && !$this->uri->getSegment(3)){
            $data['employee_list'] = $this->Employee_Model->get_employee_list(1);
            $this->lib->view('administrator/pc_issue/add_pc_id',$data);
        }else{
            $this->lib->view('administrator/pc_issue/add_pc_issue',$data);
        }

	}

    public function getIssue(){
		$data=array();
		$user_session=$this->session->get('id');

		if(!$user_session){
            return redirect()->to(base_url('login'));	
		}

        $data['get_pc_data']=$this->Pc_Issue_Model->getPc_id($user_session);
        $get_pc_issue="";
        if($this->request->getPost('id')){
            $issueid = $this->request->getPost('id');
            $get_pc_issue = $this->Pc_Issue_Model->get_pcIssue($issueid);
        }
        $data['list_data']=$get_pc_issue;
        echo json_encode($data);
	}

    public function changPC_id(){
        $data = array();
		$emp_id = $this->request->getPost("emp_id");
		$pc_id = $this->request->getPost("pc_id");
        
        $this->form_validation->reset();
        $this->form_validation->setRule('emp_id', 'Employee Id', 'required');
        $this->form_validation->setRule('pc_id', 'PC Id', 'required|is_unique[pc_connection.pc_id]');
        if ($this->validate($this->form_validation->getRules()) == false)
        {
            // $this->session->set_flashdata('message', $this->form_validation->listErrors());
            // return redirect()->to(base_url($url));
            $data['error_code'] = 1;
            /* $html = '';
            $error_mg = explode('</p>',$this->form_validation->listErrors());
            foreach($error_mg as $key => $value){
                if($key != (count($error_mg)-1)){
                    $html .= '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">'.$value.'</p></div></div></div>';
                }
            } */
            $html = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">'.$this->validator->listErrors().'</p></div></div></div>';
            $data['message'] = $html;
        }
        else
        {
            $pc = $this->Pc_Issue_Model->getPc_id($emp_id);
            if(isset($pc) && !empty($pc)){
                $arr = array(
                    'id' => $pc[0]->id,
                    'employee_id' => $emp_id,
                    'pc_id' => $pc_id,
                    'updated_date' => date('Y-m-d'),
                );
                $insert_pcid = $this->Pc_Issue_Model->update_pcid($arr);
                if($insert_pcid){
                    $data['error_code'] = 0;
                    $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Your PC id is added.</p></div></div></div>';
                }else{
                    $data['error_code'] = 1;
                    $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Your PC id is field to add!</p></div></div></div>'; 
                }
            }else{
                $arr = array(
                    'employee_id' => $emp_id,
                    'pc_id' => $pc_id,
                    'created_date' => date('Y-m-d h:i:s'),
                );
                $insert_pcid = $this->Pc_Issue_Model->insert_pcid($arr);
                if($insert_pcid){
                    $data['error_code'] = 0;
                    $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Your PC id is changed.</p></div></div></div>';
                }else{
                    $data['error_code'] = 1;
                    $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Your PC id is field to change!</p></div></div></div>'; 
                }
            }
        }
        echo json_encode($data);exit;
    }

    public function getPC_id(){
        $data = array();
        $emp_id = $this->request->getPost("emp_id");
        $data['pc_data'] = $this->Pc_Issue_Model->getPc_id($emp_id);
        echo json_encode($data);
    }

	public function insert_data(){
        $user_role = $this->session->get('user_role');
        $data = array();
		/* candidates_upload_resume */
		$emp_id = $this->request->getPost("employee_id");
		$id = $this->request->getPost("id");
		$issue = $this->request->getPost("issue");
        if($user_role == 'admin'){
            $status = $this->request->getPost("status");
        }else{
            $status = 'new';
        }
		$ss = $this->request->getPost("ss");
        $issue_description = $this->request->getPost("issue_description");
        $pc_id = $this->request->getPost("pc_id");

        $this->form_validation->reset();
        $this->form_validation->setRule('issue', 'Issue', 'required');
        $this->form_validation->setRule('issue_description', 'Issue Description', 'required');
		if(!empty($issue) && $issue == 'hardware'){
            $parts = $this->request->getPost("parts");
            $this->form_validation->setRule('h_parts', 'Hardware Parts', 'required');
        }else{
            $parts = null;
        }
        if ($this->form_validation->withRequest($this->request)->run() == false)
        {
            $data['error_code'] = 1;
            $html = '';
            $error_mg = explode('</p>',$this->form_validation->listErrors());
            foreach($error_mg as $key => $value){
                if($key != (count($error_mg)-1)){
                    $html .= '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">'.$value.'</p></div></div></div>';
                }
            }
            $data['message'] = $html;
            // $this->session->set_flashdata('message', $this->form_validation->listErrors());
            // return redirect()->to(base_url('pc_issue/add'));
        }
        else
        {
            $arr = array();
            if(!empty($issue) && $issue == 'software'){
                $oldssCount = !empty($ss)?count(explode(',',$ss)):0;
                $newssCount = !empty($_FILES['screenshorts']['name'][0])?count($this->request->getFileMultiple('screenshorts')):0;
                $count_images = $newssCount+$oldssCount;
                $num = 1;
                if($count_images > 5){
                    $data['error_code'] = 1;
                    $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>You can select only 5 images</p></div></div></div>';
                    echo json_encode($data);exit;
                    // $this->session->set_flashdata('message', '<p>You Can Select Only 5 Images</p>');
                    // return redirect()->to(base_url('pc_issue/add').'/'.$id);
                }else{
                    if(!empty($_FILES['screenshorts']['name'][0])){
                        $this->form_validation->reset();
                        $this->form_validation->setRule('screenshorts', 'Screenshorts', "uploaded[screenshorts]|max_size[screenshorts,50000]|mime_in[screenshorts,image/jpg,image/jpeg,image/png,image/gif]");
                        if ($this->form_validation->withRequest($this->request)->run() == false) {
                            $data['error_code'] = 1;
                            $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>'.$this->form_validation->listErrors().'</p></div></div></div>';
                            echo json_encode($data);exit;
                            /*  $this->session->setFlashdata('message', '<span class="error_Success">' . $this->form_validation->listErrors() . '</sapn>');
                            return redirect()->to(base_url('pc_issue')); */
                        } else {
                            foreach($this->request->getFileMultiple('screenshorts') as $file){
                                if(!empty($file->getName())){
                                    $ext = pathinfo($file->getName(), PATHINFO_EXTENSION);
                                    $name = $num . '_' . md5(time()) . '.' . $ext;
                                    // $url = $_SERVER['DOCUMENT_ROOT'].'/assets/upload/issue_ss';
                                    $url = $_SERVER['DOCUMENT_ROOT'].'/assets/upload/issue_ss';
                                    
                                    if($file->move($url, $name)){
                                        $uploadData = $file;
                                        $arr[] = $uploadData->getName();
                                    }
                                }
                                $num++;
                            }
                        }
                    }
                   /*  for($i=0;$i<$count_images;$i++){
                        if(!empty($_FILES['screenshorts']['name'][$i])){
                            $ext = pathinfo($_FILES['screenshorts']['name'][$i], PATHINFO_EXTENSION);
                            $name = $num . '_' . md5(time()) . '.' . $ext;
                            // $_FILES['file']['name'] = $name;
                            // $_FILES['file']['type'] = $_FILES['screenshorts']['type'][$i];
                            // $_FILES['file']['tmp_name'] = $_FILES['screenshorts']['tmp_name'][$i];
                            // $_FILES['file']['error'] = $_FILES['screenshorts']['error'][$i];
                            // $_FILES['file']['size'] = $_FILES['screenshorts']['size'][$i];
                            
                            $url = $_SERVER['DOCUMENT_ROOT'].'/assets/upload/issue_ss';
                            $file = $this->request->getFile("file");
                            
                            $file_image = $file->getName();
                            
                            $this->form_validation->reset();
                            $this->form_validation->setRule('file', 'Screenshorts', "uploaded[file]|max_size[file,50000]|mime_in[file,image/*]");
                            
                            // $config['upload_path'] = $url; 
                            // $config['allowed_types'] = 'jpg|jpeg|png|gif';
                            // $config['max_size'] = '50000';
                            // $config['file_name'] = $name;
                    
                            // $this->load->library('upload',$config); 
                            if ($this->form_validation->withRequest($this->request)->run() == false) {
                                $this->session->setFlashdata('message', '<span class="error_Success">' . $this->form_validation->listErrors() . '</sapn>');
                                return redirect()->to(base_url('pc_issue'));
                            } else {
                                if($file->move($url, $file_image)){
                                    $uploadData = $file;
                                    $arr[] = $uploadData->getClientName();
                                }
                            }
                        }
                        $num++;
                    } */
                    $file_name = '';
                    if(isset($arr) && !empty($arr)){
                        if($ss != ''){
                            $ss = explode(',',$ss);
                            $file_name = implode(",",array_merge($arr,$ss));
                        }else{
                            $file_name = implode(",",$arr);
                        }
                    }else{
                        if($file_name == '' && $ss == ''){
                            // $this->session->set_flashdata('message', '<p>Screenshorts Is Required</p>');
                            // return redirect()->to(base_url('pc_issue/add').'/'.$id);
                            $data['error_code'] = 1;
                            $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Screenshorts is required</p></div></div></div>';
                        }else if($file_name == '' && $ss != ''){
                            $file_name = $ss;
                        }
                    }
                }
            }else{
                $file_name = null;
            }
            // $config['upload_path'] = $url;
            // $config['allowed_types'] = 'pdf|jpg|jpeg|png|docx';
            // /* $config['max_size'] = 2000;
            // $config['max_width'] = 1500;
            // $config['max_height'] = 1500; */

            // $this->load->library('upload', $config);
            // $upload_resume="";
            // if (!$this->upload->do_upload('upload_resume')) {
            //     //$error = array('error' => $this->upload->display_errors());
            //     // if($id == ""){
            //         $this->session->set_flashdata('message','<span class="error_Success">'.$this->upload->display_errors().'</sapn>');
            //         return redirect()->to(base_url('pc_issue/add'));
            //     // }else{
            //     //     if($upload_resume_name == ""){
            //     //         $this->session->set_flashdata('message','<span class="error_Success">'.$this->upload->display_errors().'</sapn>');
            //     //         return redirect()->to(base_url('candidates/add/'.$id));
            //     //     }else{
            //     //         $upload_resume=$upload_resume_name;
            //     //     }
            //     // }
            // } else {
            //     $data = $this->upload->data();
            //     $upload_resume=$data['file_name'];
            //     //print_r($data);
            //     //die;
            // }
            if(empty($id)){
			$arr = array(
                    'pc_id' => $pc_id,
                    'employee_id' => $emp_id,
                    'issue' => $issue,
                    'hardware_part' => $parts,
                    'description' => $issue_description,
                    'screenshorts' => $file_name,
                    'status' => $status,
                    'created_date' => date('Y-m-d h:i:s'),
                );
				$insert_pcIssue = $this->Pc_Issue_Model->insert_pcIssue($arr);
                if($insert_pcIssue){
                    $data['error_code'] = 0;
                    $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Your PC issue added.</p></div></div></div>';
                }else{
                    $data['error_code'] = 1;
                    $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Your PC issue field to add!</p></div></div></div>';
                }
                
			}else{
				$arr = array(
					'id' => $id,
                    'pc_id' => $pc_id,
                    'employee_id' => $emp_id,
                    'issue' => $issue,
                    'hardware_part' => $parts,
                    'description' => $issue_description,
                    'screenshorts' => $file_name,
                    'status' => $status,
                    'created_date' => date('Y-m-d h:i:s'),
                );
				$update_pcIssue = $this->Pc_Issue_Model->update_pcIssue($arr);
                if($update_pcIssue){
                    $data['error_code'] = 0;
                    $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Your PC issue updated.</p></div></div></div>';
                }else{
                    $data['error_code'] = 1;
                    $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Your PC issue field to update!</p></div></div></div>';
                }
			}
			//echo "<br>";
			//echo $this->db->last_query();
			/* $this->session->set_flashdata('message', $data['message']);
            return redirect()->to(base_url('pc_issue')); */
		}
        echo json_encode($data);exit;
    }

    public function changeStatus(){
        $data = array();
		$id = $this->request->getPost("id");
		$status = $this->request->getPost("status");
		
        $arr = array(
            'id' => $id,
            'status' => $status,
            'created_date' => date('Y-m-d h:i:s'),
        );
        $pcIssue_status = $this->Pc_Issue_Model->update_pcIssue($arr);
        if($pcIssue_status){
            $data['error_code'] = 0;
            $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>PC issue status changed.</p></div></div></div>';
        }else{
            $data['error_code'] = 1;
            $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>PC issue status field to change!</p></div></div></div>'; 
        }
        echo json_encode($data);

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
                $image1=$_SERVER['DOCUMENT_ROOT']."/assets/candidates_upload_resume/".$list_data[0]->upload_resume;
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

    public function delete_pcIssue(){
        $data = array();
        $id = $this->request->getPost("id");

        if($id)
        {
            $pc_issue = $this->Pc_Issue_Model->delete_pcIssue($id);
            if($pc_issue){
                $data['error_code'] = 0;
                $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>PC issue deleted.</p></div></div></div>';
            }else{
                $data['error_code'] = 1;
                $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>PC issue field to delete!</p></div></div></div>'; 
            }
        }else{
            $data['error_code'] = 1;
            $data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>PC issue not found!</p></div></div></div>';  
        }
        echo json_encode($data);
    }

	public function create_table(){
       /* echo $this->db->query("CREATE TABLE `daily_work` ( `id` int(11) PRIMARY KEY AUTO_INCREMENT, `employee_id` INT(11) NOT NULL, `attendance_date` date NOT NULL, `daily_work` LONGTEXT NOT NULL, `created_date` datetime NOT NULL DEFAULT current_timestamp(), `updated_date` datetime DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1");
       echo $this->db->query("CREATE TABLE `interview_schedule` ( `id` int(11) PRIMARY KEY AUTO_INCREMENT, `candidate_id` INT(11) NOT NULL, `interview_date` date NOT NULL, `interview_status` enum('select', 'pending', 'reject') NOT NULL, `hr_skill` LONGTEXT NOT NULL, `hr_feedback` LONGTEXT NOT NULL, `technical_skill` LONGTEXT NOT NULL, `technical_feedback` LONGTEXT NOT NULL, `taken_by` varchar(100) NOT NULL, `salary` varchar(100) NOT NULL, `joining_date` date NOT NULL, `employee_status` enum('training', 'employee') NOT NULL, `traning_period` varchar(255) NOT NULL, `remark` LONGTEXT NOT NULL, `status` enum('select', 'onhold', 'reject') NOT NULL, `mail` enum('0', '1') NOT NULL, `interview_time` varchar(100) NOT NULL, `created_date` datetime NOT NULL DEFAULT current_timestamp(), `updated_date` datetime DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1");
       echo $this->db->query("CREATE TABLE `candidates` ( `id` int(11) PRIMARY KEY AUTO_INCREMENT, `name` varchar(50) NOT NULL, `email` varchar(50) NOT NULL, `phone_number` varchar(50) NOT NULL, `gender` varchar(50) NOT NULL, `designation` varchar(50) NOT NULL, `experience` varchar(50) NOT NULL, `current_salary` DECIMAL(10,2) NOT NULL, `expected_salary` DECIMAL(10,2) NOT NULL, `upload_resume` varchar(100) NOT NULL, `interview_status` enum('pending','reject','complete') NOT NULL, `location` LONGTEXT NOT NULL, `skills` LONGTEXT NOT NULL, `created_date` datetime NOT NULL DEFAULT current_timestamp(), `updated_date` datetime DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1");
       echo $this->db->query("CREATE TABLE `mail_content` ( `id` int(11) PRIMARY KEY AUTO_INCREMENT, `name` varchar(50) NOT NULL, `content` LONGTEXT NOT NULL, `slug` varchar(50) NOT NULL, `created_date` datetime NOT NULL DEFAULT current_timestamp(), `updated_date` datetime DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1"); */
       /* For PC Issue */
        /* echo $this->db->query("CREATE TABLE `pc_issue` ( `id` int(11) PRIMARY KEY AUTO_INCREMENT, `pc_id` int(11) NOT NULL, `employee_id` int(11) NOT NULL, `issue` enum('hardware','software') NOT NULL, `hardware_part` varchar(200) NULL, `description` LONGTEXT NULL, `screenshorts` varchar(500) NULL, `status` enum('new','pending','inprogress','resolved') NOT NULL, `created_date` datetime NOT NULL DEFAULT current_timestamp(), `updated_date` datetime DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1"); */
        /* echo $this->db->query("CREATE TABLE `pc_connection` ( `id` int(11) PRIMARY KEY AUTO_INCREMENT, `employee_id` INT(11) NOT NULL, `pc_id` INT(11) NOT NULL, `created_date` datetime NOT NULL DEFAULT current_timestamp(), `updated_date` datetime DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1"); */
       
        /* echo $this->db->query("CREATE TABLE `pc_issue` (
		  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
		  `pc_id` int(11) NOT NULL,
		  `employee_id` int(11) NOT NULL,
		  `issue` enum('hardware','software') NOT NULL,
		  `hardware_part` varchar(200) NULL,
		  `description` LONGTEXT NULL,
		  `screenshorts` varchar(500) NULL,
		  `status` enum('new','pending','inprogress','resolve') NOT NULL,
		  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
		  `updated_date` datetime DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
        echo $this->db->last_query(); */
        // echo $this->db->query("ALTER TABLE `pc_issue` CHANGE `status` `status` ENUM('new','pending','inprogress','resolved') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;");
        
        /* echo $this->db->query("CREATE TABLE `pc_connection` (
            `id` int(11) PRIMARY KEY AUTO_INCREMENT,
            `employee_id` INT(11) NOT NULL,
            `pc_id` INT(11) NOT NULL,
            `created_date` datetime NOT NULL DEFAULT current_timestamp(),
            `updated_date` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"); 
            echo $this->db->last_query(); */
            
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