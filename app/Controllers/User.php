<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class User extends BaseController {
	public function __construct()
	{
		parent::__construct();
		$this->image = \Config\Services::image();
		$user_session=$this->session->get('id');
		if(!$user_session){
			return redirect()->to(base_url());	
		}
	}
	
	public function index()
	{
		
		$data=array();
		$user_session=$this->session->get('id');
		$user_role=$this->session->get('user_role');
		if(!$user_session){
			return redirect()->to(base_url('login'));	
		}
	}
	public function profile_image_change(){
		// $url = $_SERVER['DOCUMENT_ROOT'].'/assets/profile_image';
		$url = $_SERVER['DOCUMENT_ROOT'].'/assets/profile_image';
		$picture="";
		if(!empty($_FILES['profile_image']['name'])){

			$file = $this->request->getFile("profile_image");

			$profile_image = date('dmYhis').$file->getName();
			$this->form_validation->reset();
			$this->form_validation->setRule('profile_image', 'Profile Image', "uploaded[profile_image]|max_size[profile_image,8192]|mime_in[profile_image,image/jpg,image/jpeg,image/png]");
			if($this->form_validation->withRequest($this->request)->run() == false){
				$this->session->setFlashdata('message','<span class="error_Success">'.$this->form_validation->listErrors().'</sapn>');
				return redirect()->to(base_url().'profile');
			}else{
				if($file->move($url, $profile_image)) {
					$uploadData = $file;
                	$picture = $uploadData->getName();
					$source_path = $url.'/'.$picture;
					for ($i=0; $i < 3 ; $i++) {
						if($i == 0){
							$imageMove = $_SERVER['DOCUMENT_ROOT'].'/assets/profile_image32x32/'.$picture;
							$this->image->withFile($source_path)->resize(200, 200, true, 'height')->save($imageMove);
						}elseif($i == 1){
							$imageMove = $_SERVER['DOCUMENT_ROOT'].'/assets/profile_image256x256/'.$picture;
							$this->image->withFile($source_path)->resize(256, 256, true, 'height')->save($imageMove);
						}elseif($i == 2){
							$imageMove = $_SERVER['DOCUMENT_ROOT'].'/assets/profile_image512x512/'.$picture;
							$this->image->withFile($source_path)->resize(512, 512, true, 'height')->save($imageMove); 
						}
					}
					$user_session=$this->session->get('id');
					$arr=array(
					   'id' => $user_session,
					   'profile_image' => $picture,
				   );
				   $insert_admin= $this->Administrator_Model->update_user($arr);
					if($insert_admin){
						return redirect()->to(base_url('profile'));
					}				
				} else {
					$this->session->setFlashdata('message','<span class="error_Success">'.$this->form_validation->listErrors().'</sapn>');
					if(!isset($id) || empty($id)){
						return redirect()->to(base_url('profile'));
					}
					else{
						return redirect()->to(base_url().'profile');
					}
					return redirect()->to(base_url('profile'));
				}
			}
		}
	}
	public function profile_detail_change(){
		$data=array();
		$user_session=$this->session->get('id');
		$data['designation']= $this->Designation_Model->get_designation();
		$data['menu']="admin_profile";
		$data['page_title']="Profile";
		$admin_detail=$this->Administrator_Model->admin_profile($user_session);
		$data['profile']=$admin_detail;
		$data['js_flag']="";
		
		$detail_type = $this->request->getPost("detail_type");
		$id = $this->request->getPost("user_id");
		$fname = $this->request->getPost("username");
		$email = $this->request->getPost("email");
		$phone_number = $this->request->getPost("phone_number");
		$gender = $this->request->getPost("gender");
		$pass = $this->request->getPost("pass");
		$old_password = $this->request->getPost("old_password");
		$new_password = $this->request->getPost("new_password");
		$confirm_password = $this->request->getPost("confirm_password");
		
		$this->form_validation->reset();
		$this->form_validation->setRule('username','User Name','required');
		$this->form_validation->setRule('email','Email','required|valid_email');
		$this->form_validation->setRule('phone_number','Phone No','required');
		$this->form_validation->setRule('gender', 'Gender', 'required');

		if(!empty($new_password) && !empty($confirm_password)){
			$this->form_validation->setRule('new_password', 'Password', 'required');
			$this->form_validation->setRule('confirm_password', 'Confirm password', 'required|matches[new_password]');
		}

		if($this->form_validation->withRequest($this->request)->run() == false)
		{
			$this->session->setFlashdata('message', $this->form_validation->listErrors());
			// $this->lib->view('administrator/admin_profile',$data);
			return redirect()->to(base_url('profile'));

		}else{
			$arr = array();
			//die;
			if(!isset($id) || empty($id)){
				
				}else{
					$decode = '';
					if(!empty($old_password) && !empty($new_password) && !empty($confirm_password)){
						if(md5($old_password) == $pass){
							$decode = md5($new_password);
							$arr=array(
								'id' => $id,
								'username' => $fname,
								'email' => $email,
								'password' => $decode,
								'gender' => $gender,
								'phone_number' => $phone_number,
							);
						}else{
							$this->session->setFlashdata('messages', '<div class="msg-box error-box box2"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text text2"><p>Old Password Not Match!</p></div></div></div>');
							// $this->lib->view('administrator/admin_profile',$data);
							return redirect()->to(base_url('profile'));
						}
					}else{
						$arr=array(
							'id' => $id,
							'username' => $fname,
							'email' => $email,
							'gender' => $gender,
							'phone_number' => $phone_number,
						);	
					}
					// $insert_employee = true;
				$insert_employee = $this->Administrator_Model->update_user($arr);
				if($insert_employee){
					// $this->lib->view('administrator/admin_profile',$data);
					$this->session->setFlashdata('messages', '<div class="msg-box success-box box2"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text text2"><p>User Data Updated.</p></div></div></div>');
					return redirect()->to(base_url('profile'));
					
				}			
			}
		}
	}	
}