<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Designation extends BaseController {
	//designation
	public function __construct()
	{
		parent::__construct();
		$user_session=$this->session->get('id');
		if(!$user_session){
			return redirect()->to(base_url());	
		}
	}
	public function index()
	{	
		$user_session=$this->session->get('id');
		if(!$user_session){
			return redirect()->to(base_url('admin'));	
		}
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$data=array();
		$data['page_title']="Designation";
		$data['js_flag']="designation_js";
		$data['menu']="designation";
		$this->lib->view('administrator/designation/list_designation',$data);
	}
	public function employee_pagination()
	{
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		//Designation_Model
		$user_role=$this->session->get('user_role');
		$columns = array( 
                            0 =>'id', 
                            1 =>'Name',
                            2 =>'action', 
                        );
		
		$limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];
  
        $totalData = $this->Designation_Model->allposts_count();
        $totalFiltered = $totalData; 
            
        if(empty($this->request->getPost('search')['value']))
        {            
            $posts = $this->Designation_Model->allposts($limit,$start,$order,$dir);
        }
        else {
            $search = $this->request->getPost('search')['value'] ; 

            $posts =  $this->Designation_Model->posts_search($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Designation_Model->posts_search_count($search);
		}
          $data = array();
        if(!empty($posts))
        {
		 foreach ($posts as $post)
            {
            	$nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
               
                $nestedData['action'] ='<button type="button" data-id="'.$post->id.'" class="btn btn-outline-secondary edit-employee" >Edit</button>  <button type="button" data-id="'.$post->id.'" class="btn btn-danger delete-employee">Delete</button>';
                // $nestedData['action'] ='<a href="'.base_url('designation/add').'/'.$post->id.'" class="btn btn-outline-secondary" >Edit</a>  <button data-id="'.$post->id.'" class="btn btn-outline-danger delete-employee">Delete</button>';
              	$data[] = $nestedData;

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
		$user_session=$this->session->get('id');
		if(!$user_session){
			return redirect()->to(base_url('admin'));	
		}
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$data=array();
		// if($this->uri->segment(3)){
		if($this->request->getPost("e_id")){
			$data['page_title']="Edit Designation";
			$id=$this->request->getPost("e_id");
			$data['list_data']= $this->Designation_Model->getDesignation_byId($id);
		}else{
			$data['page_title']="Add Designation";
			$data['list_data']="";
		}
		$data['js_flag']="designation_js";
		$data['menu']="designation_add";
		echo json_encode($data);
		// $this->lib->view('administrator/designation/add_designation',$data);
	}
	public function delete_employee(){
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$id = $this->request->getPost("id");
		$delete_employee= $this->Designation_Model->deleteDesignation($id);
	
	}
	public function insert_data()
	{	
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$id = $this->request->getPost("e_id");
		$designation = $this->request->getPost("designation");
		$skills = $this->request->getPost("skills");
		$this->form_validation->reset();
		$this->form_validation->setRule('designation', 'Designation', 'required');
		$this->form_validation->setRule('skills', 'Skills', 'required');
		
		if($this->validate($this->form_validation->getRules()) == false)
		{
			$this->session->setFlashdata('message', $this->validator->listErrors());
			$data['message'] = '<p class="error-message">'.$this->validator->listErrors().'</p>';
			// return redirect()->to(base_url('designation/add'));

		}else{
			if(!isset($id) || empty($id)){
				
				
				$arr=array(
					'name' => $designation,
					'skills' => $skills,
				);
				$insert_employee= $this->Designation_Model->insertDesignation($arr);
				// $insert_employee= true;
				if($insert_employee){
					$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Designation added.</p></div></div></div>';
					// return redirect()->to(base_url('designation'));
				}else{
					$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Designation failed to add!</p></div></div></div>';
				}

			}else{
				
				$arr=array(
					'id' => $id,
					'name' => $designation,
					'skills' => $skills,
					'updated_date' => date('Y-m-d h:i:s')
					
				);

				$insert_employee= $this->Designation_Model->updateDesignation($arr);
				// $insert_employee= true;
				if($insert_employee){
					$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Designation updated.</p></div></div></div>';
					// return redirect()->to(base_url('designation'));
				}else{
					$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Designation failed to update!</p></div></div></div>';
				}			
			}
		}
		echo json_encode($data);
	}

}
