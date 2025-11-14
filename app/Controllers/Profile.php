<?php
namespace App\Controllers;
use App\Controllers\BaseController;


class Profile extends BaseController {
	public function __construct(){
		parent::__construct();
		$this->image = \Config\Services::image();
		$user_session=$this->session->get('id');
		if(!$user_session){
			return redirect()->to(base_url());	
		}
	}

	public function get_User_Ip_Addr(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			//ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//ip pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	public function index(){
		
		$data=array();
		$user_session=$this->session->get('id');
		$user_role=$this->session->get('user_role');
		if(!$user_session){
			return redirect()->to(base_url('login'));	
		}

		$data['designation']= $this->Designation_Model->get_designation();
		$data['menu']="admin_profile";
		if($user_role == 'admin'){
			//$data=array();
			$data['page_title']="Profile";
			$user_session=$this->session->get('id');
			$admin_detail=$this->Administrator_Model->admin_profile($user_session);
			$data['profile']=$admin_detail;
			$data['js_flag']="admin_profile_js";
			$user_session=$this->session->get('id');
			$this->session->set('username',$admin_detail[0]->username);
			$this->session->set('useremail',$admin_detail[0]->email);
			$this->session->set('profile_image',$admin_detail[0]->profile_image);
			$this->lib->view('administrator/admin_profile',$data);
		}else{
			$employee_detail=$this->Employee_Model->get_employee($user_session);
			$emergency_contact=$this->Employee_Model->get_emergencyContactDetail($user_session);
			$data['profile']=$employee_detail;
			$data['emergency_contact']=$emergency_contact;
			//echo "<pre/>";
			//print_r($employee_detail);
			$decode_credentials=json_decode($employee_detail[0]->credential);
			$user_session=$this->session->get('id');
			$this->session->set('user_id',$employee_detail[0]->id);
			$this->session->set('username',$employee_detail[0]->fname);
			$this->session->set('useremail',$employee_detail[0]->email);
			$this->session->set('profile_image',$employee_detail[0]->profile_image);
			$data['page_title']="Profile";
			//$data['js_flag']="emp_js";
			$data['js_flag']="profile_js";
			$this->lib->view('administrator/employee/profile',$data);
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
					$insert_employee= $this->Employee_Model->update_employee($arr);
					if($insert_employee){
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
		
		/* if(!empty($_FILES['profile_image']['name'])){
			$config['upload_path'] = $url;
            // $config['allowed_types'] = '*';
			$config['allowed_types'] = 'jpeg|png|jpg';
			$config['max_size']   = '8192';
			//$config['max_size']   = '1024';
            $config['file_name'] = date('dmYhis').$_FILES['profile_image']['name'];
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
          	if($this->upload->do_upload('profile_image')){
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name'];
                $org_image_size = $uploadData['image_width'].'x'.$uploadData['image_height']; 
                 
                $source_path = $url.'/'.$picture;
                for ($i=0; $i < 3 ; $i++) {
                	if($i == 0){
		                $thumb_path = 'assets/profile_image32x32';
		                $thumb_width = 200; 
		                $thumb_height = 200; 
                	}elseif($i == 1){
                	    $thumb_path = 'assets/profile_image256x256';
		                $thumb_width = 256; 
		                $thumb_height = 256; 
                	}elseif($i == 2){
                	    $thumb_path = 'assets/profile_image512x512';
		                $thumb_width = 512; 
		                $thumb_height = 512; 
                	}
                 
	                $config1['image_library']    = 'gd2'; 
	                $config1['source_image']     = $source_path; 
	                $config1['new_image']        = $thumb_path; 
	                $config1['create_thumb']     = FALSE;
					$config1['maintain_ratio']   = TRUE;
	                $config1['width']            = $thumb_width; 
	                $config1['height']           = $thumb_height; 

	                $this->image_lib->clear();
	                $this->image_lib->initialize($config1);
	                $this->image_lib->resize();
                }
                 $user_session=$this->session->get('id');
                 $arr=array(
					'id' => $user_session,
					'profile_image' => $picture,
				);
				$insert_employee= $this->Employee_Model->update_employee($arr);
				if($insert_employee){
					return redirect()->to(base_url('profile'));
				}				
            }else{
				 $this->session->setFlashdata('message','<span class="error_Success">'.$this->upload->display_errors().'</sapn>');
				if(!isset($id) || empty($id)){
					return redirect()->to(base_url('profile'));
				}
				else{
					return redirect()->to(base_url().'profile');
				}
				return redirect()->to(base_url('profile'));
			}
		} */

	}

	public function update_profile(){
		$user_session=$this->session->get('id');
		if(!$user_session){
			return redirect()->to(base_url('login'));	
		}
		$data=array();
		if($this->uri->getSegment(3)){
			$id=$this->uri->getSegment(3);
			$data['designation']= $this->Designation_Model->get_designation();
			$data['list_data']= $this->Employee_Model->get_employee($user_session);
		}else{
			$data['list_data']="";
		}
		//$data['menu']="profile";
		$this->lib->view('administrator/employee/edit_profile',$data);
	}

	public function test_download(){
		$data=array();
		$user_session=$this->session->get('id');
		$data['employee_details']= $this->Employee_Model->get_employee($user_session);
        $filename="test_file";
        $html = $this->load->view('administrator/employee/download',$data,true);
        $this->mpdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
        
    }

	public function test_csrf(){
		$user_session=$this->session->get('id');
		if(!$user_session){
			return redirect()->to(base_url('login'));	
		}
		$data=array();
		if($this->uri->getSegment(3)){
			$id=$this->uri->getSegment(3);
			$data['designation']= $this->Designation_Model->get_designation();
			$data['list_data']= $this->Employee_Model->get_employee($user_session);
		}else{
			$data['list_data']="";
		}
		$data['js_flag']="profile_js";
		$this->lib->view('administrator/test_csrf',$data);
	}

	public function insert_csrf(){

			echo "<pre>"; print_r($_POST);
		die;
		
	}

	public function insert_data(){	
		//echo "<script>alert('data goes here');</script>";
		$user_role=$this->session->get('user_role');
		$detail_type = $this->request->getPost("detail_type");
		$id = $this->request->getPost("e_id");

		if($detail_type == 'basic_detail'){
			$fname = $this->request->getPost("fname");
			$lname = $this->request->getPost("lname");
			$email = $this->request->getPost("email");
			$personal_email = $this->request->getPost("personal_email");
			$password = $this->request->getPost("password");
			$phone_number = $this->request->getPost("phone_number");
			//$date_of_birth = $this->request->getPost("date_of_birth");
			$gender = $this->request->getPost("gender");
			$address = $this->request->getPost("address");
			$designation = $this->request->getPost("designation");
		}
		if($detail_type == 'id_proof'){
			$id_proof_name = $this->request->getPost("id_proof_name");
		}
		if($detail_type == 'emp_signature'){
			$emp_signature_name = $this->request->getPost("emp_signature_name");
		}
		if($detail_type == 'bank_detail'){
			$bank_name = $this->request->getPost("bank_name");
			$account_number = $this->request->getPost("account_number");
			//echo $account_number;
			//die;
			$ifsc_number = $this->request->getPost("ifsc_number");
		}
		if($detail_type == 'payment_method'){
			$upi_type = $this->request->getPost("upi_type");
			$upi_id = $this->request->getPost("upi_id");
			$qrcode_name = $this->request->getPost("qrcode_name");
		}
		if($detail_type == 'credentials_detail'){
			$skype_account = $this->request->getPost("skype_account");
			$skype_password = $this->request->getPost("skype_password");
			$gmail_account = $this->request->getPost("gmail_account");
			$gmail_password = $this->request->getPost("gmail_password");
			$crendt=array(
				"gmail"=>array('gmail_account'=>$gmail_account,'gmail_password'=>$gmail_password),
				"skype"=>array('skype_account'=>$skype_account,'skype_password'=>$skype_password),
			);
			//echo "<pre/>";
			//print_r($crendt);
			
			$credentials=json_encode($crendt);
		}
		//echo $credentials;
		//die;
		//$joining_date1 = $this->request->getPost("joining_date");
		if($detail_type == 'basic_detail'){
			$date_of_birth="";
			$birth_date = $this->request->getPost("birth_date");
			if(!empty($birth_date)){
				$date_of_birth = Format_date($birth_date);
			}
			$joining_date="";
			$joining_date = $this->request->getPost("joining_date");
			if(!empty($joining_date)){
				$joining_date = Format_date($joining_date);
			}
		}
		
		if($detail_type == 'id_proof'){
			// $url = $_SERVER['DOCUMENT_ROOT'].'/assets/id_proof';
			$url = $_SERVER['DOCUMENT_ROOT'].'/assets/id_proof';
			$picture="";
			if(!empty($_FILES['id_proof']['name'])){
				$file = $this->request->getFile("id_proof");

				$id_proof = date('dmYhis').$file->getName();
				
				$validated = $this->validate([
					'id_proof' => [
						'uploaded[id_proof]',
						'mime_in[id_proof,image/jpg,image/jpeg,image/png]',
						'max_size[id_proof,8192]',
					],
				]);
				if(!$validated){
					$this->session->setFlashdata('message','<span class="error_Success">'.$this->validator->listErrors().'</sapn>');
					return redirect()->to(base_url().'profile');
				}else{
					if($file->move($url, $id_proof)){
						$uploadData = $file;
						$picture = $file->getName();
						$source_path = $url.'/'.$picture; 
						for ($i=0; $i < 3 ; $i++) {
							if($i == 0){
								$thumb_path = $_SERVER['DOCUMENT_ROOT'].'/assets/id_proof32x32/'.$picture;
								$this->image->withFile($source_path)->resize(200, 200, true, 'height')->save($thumb_path);
							}elseif($i == 1){
								$thumb_path = $_SERVER['DOCUMENT_ROOT'].'/assets/id_proof256x256/'.$picture;
								$this->image->withFile($source_path)->resize(256, 256, true, 'height')->save($thumb_path);
							}elseif($i == 2){
								$thumb_path = $_SERVER['DOCUMENT_ROOT'].'/assets/id_proof512x512/'.$picture;
								$this->image->withFile($source_path)->resize(512, 512, true, 'height')->save($thumb_path);
							}
						}
					}else{
						$this->session->setFlashdata('message','<span class="error_Success">Failed to upload id proof.</sapn>');
						if(!isset($id) || empty($id)){
							return redirect()->to(base_url('profile#id-proof-details'));
						}
						else{
							return redirect()->to(base_url().'profile#id-proof-details');
						}
						return redirect()->to(base_url('profile#id-proof-details'));
					}
				}
			}else{
				$this->session->setFlashdata('message','<span class="error_Success">Please select your id proof.</sapn>');
				return redirect()->to(base_url('profile'));
			}
			if(!isset($id) || empty($id)){
				$picture="";
			}else{
				if(isset($picture) && !empty($picture)){
					$picture=$picture;
				}else{
					$picture=$id_proof_name;
				}
			}
			/* $url = $_SERVER['DOCUMENT_ROOT'].'/assets/id_proof';
			$picture="";
			if(!empty($_FILES['id_proof']['name'])){
				$validated = $this->validate([
					'id_proof' => [
						'uploaded[id_proof]',
						'mime_in[id_proof,image/jpg,image/jpeg,image/png]',
						'max_size[id_proof,8192]',
					],
				]);
				$config['upload_path'] = $url;
				$config['allowed_types'] = 'jpeg|png|jpg';
				$config['max_size']   = '8192';
	            $config['file_name'] = date('dmYhis').$_FILES['id_proof']['name'];
	            // $this->load->library('upload',$config);
	            $this->upload->initialize($config);
				if($this->upload->do_upload('id_proof')){
	                $uploadData = $this->upload->data();
					$picture = $uploadData['file_name'];
					$source_path = $url.'/'.$picture; 
					for ($i=0; $i < 3 ; $i++) {
						if($i == 0){
							$thumb_path = 'assets/id_proof32x32';
			                $thumb_width = 200; 
			                $thumb_height = 200; 
	                	}elseif($i == 1){
							$thumb_path = 'assets/id_proof256x256';
			                $thumb_width = 256; 
			                $thumb_height = 256; 
	                	}elseif($i == 2){
							$thumb_path = 'assets/id_proof512x512';
			                $thumb_width = 512; 
			                $thumb_height = 512; 
	                	}
						
		                $config1['image_library']    = 'gd2'; 
		                $config1['source_image']     = $source_path; 
		                $config1['new_image']        = $thumb_path; 
		                $config1['create_thumb']     = FALSE;
						$config1['maintain_ratio']   = TRUE;
		                $config1['width']            = $thumb_width; 
		                $config1['height']           = $thumb_height; 
						
		                $this->image_lib->clear();
		                $this->image_lib->initialize($config1);
						$this->image_lib->resize();
	                }
	            }else{
					$this->session->setFlashdata('message','<span class="error_Success">'.$this->upload->display_errors().'</sapn>');
					if(!isset($id) || empty($id)){
						return redirect()->to(base_url('profile#id-proof-details'));
					}
					else{
						return redirect()->to(base_url().'profile#id-proof-details');
					}
					return redirect()->to(base_url('profile#id-proof-details'));
				}
			}else{
				$this->session->setFlashdata('message','<span class="error_Success">Please select your id proof.</sapn>');
				return redirect()->to(base_url('profile'));
			}
			if(!isset($id) || empty($id)){
				$picture="";
			}else{
				if(isset($picture) && !empty($picture)){
					$picture=$picture;
				}else{
					$picture=$id_proof_name;
				}
			} */
		}
		
		if($detail_type == 'payment_method'){
			// $url = $_SERVER['DOCUMENT_ROOT'].'/assets/id_proof';
			$url = $_SERVER['DOCUMENT_ROOT'].'/assets/upload/qrcode';
			$picture="";
			if(!empty($_FILES['qrcode']['name'])){
				$file = $this->request->getFile("qrcode");

				$qrcode = date('dmYhis').$file->getName();
				
				$validated = $this->validate([
					'qrcode' => [
						'uploaded[qrcode]',
						'mime_in[qrcode,image/jpg,image/jpeg,image/png]',
						'max_size[qrcode,8192]',
					],
				]);
				if(!$validated){
					$this->session->setFlashdata('message','<span class="error_Success">'.$this->validator->listErrors().'</sapn>');
					return redirect()->to(base_url().'profile');
				}else{
					if($file->move($url, $qrcode)){
						$qrcode_picture = $file->getName();
					}else{
						$this->session->setFlashdata('message','<span class="error_Success">Failed to upload QR code.</sapn>');
						return redirect()->to(base_url('profile'));
					}
				}
			}else{
				if($qrcode_name == ''){
					$this->session->setFlashdata('message','<span class="error_Success">Please select your QR code.</sapn>');
					return redirect()->to(base_url('profile'));
				}else{
					$qrcode_picture = $qrcode_name;
				}
			}
		}

		if($detail_type == 'emp_signature'){
			// $url = $_SERVER['DOCUMENT_ROOT'].'/assets/signature';
			$url = $_SERVER['DOCUMENT_ROOT'].'/assets/signature';
			$emp_sign="";
			if(!empty($_FILES['emp_signature']['name'])){
				$file = $this->request->getFile("emp_signature");

				$signature = date('dmYhis').$file->getName();
				
				$validated = $this->validate([
					'emp_signature' => [
						'uploaded[emp_signature]',
						'mime_in[emp_signature,image/jpg,image/jpeg,image/png]',
						'max_size[emp_signature,8192]',
					],
				]);
				if(!$validated){
					$this->session->setFlashdata('message','<span class="error_Success">'.$this->validator->listErrors().'</sapn>');
					return redirect()->to(base_url().'profile');
				}else{
					if($file->move($url, $signature)){
						$uploadData = $file;
						$emp_sign = $uploadData->getName();
						$source_path = $url.'/'.$emp_sign; 
						for ($i=0; $i < 3 ; $i++) {
							if($i == 0){
								$thumb_path = $_SERVER['DOCUMENT_ROOT'].'/assets/signature32x32/'.$emp_sign;
								$this->image->withFile($source_path)->resize(200, 200, true, 'height')->save($thumb_path);
							}elseif($i == 1){
								$thumb_path = $_SERVER['DOCUMENT_ROOT'].'/assets/signature256x256/'.$emp_sign;
								$this->image->withFile($source_path)->resize(256, 256, true, 'height')->save($thumb_path);
							}elseif($i == 2){
								$thumb_path = $_SERVER['DOCUMENT_ROOT'].'/assets/signature512x512/'.$emp_sign;
								$this->image->withFile($source_path)->resize(512, 512, true, 'height')->save($thumb_path);
							}
						}
					}else{
						$this->session->setFlashdata('message','<span class="error_Success">Failed to upload signature.</sapn>');
						if(!isset($id) || empty($id)){
							return redirect()->to(base_url('profile'));
						}
						else{
							return redirect()->to(base_url().'profile');
						}
						return redirect()->to(base_url('profile'));
					}
				}
			}else{
				$this->session->setFlashdata('message','<span class="error_Success">Please select your signature.</sapn>');
				return redirect()->to(base_url().'profile');
			}
			/* $url = $_SERVER['DOCUMENT_ROOT'].'/assets/signature';
			$emp_sign="";
			if(!empty($_FILES['emp_signature']['name'])){
				$config['upload_path'] = $url;
	            $config['allowed_types'] = 'jpeg|png|jpg';
				$config['max_size']   = '8192';
	            $config['file_name'] = date('dmYhis').$_FILES['emp_signature']['name'];
	            $this->load->library('upload',$config);
	            $this->upload->initialize($config);
	          	if($this->upload->do_upload('emp_signature')){
	                $uploadData = $this->upload->data();
	                 $emp_sign = $uploadData['file_name'];
	                 $source_path = $url.'/'.$emp_sign; 
	                 for ($i=0; $i < 3 ; $i++) {
	                	if($i == 0){
			                $thumb_path = 'assets/signature32x32';
			                $thumb_width = 200; 
			                $thumb_height = 200; 
	                	}elseif($i == 1){
	                	    $thumb_path = 'assets/signature256x256';
			                $thumb_width = 256; 
			                $thumb_height = 256; 
	                	}elseif($i == 2){
	                	    $thumb_path = 'assets/signature512x512';
			                $thumb_width = 512; 
			                $thumb_height = 512; 
	                	}
	                 
		                $config1['image_library']    = 'gd2'; 
		                $config1['source_image']     = $source_path; 
		                $config1['new_image']        = $thumb_path; 
		                $config1['create_thumb']     = FALSE;
						$config1['maintain_ratio']   = TRUE;
		                $config1['width']            = $thumb_width; 
		                $config1['height']           = $thumb_height; 

		                $this->image_lib->clear();
		                $this->image_lib->initialize($config1);
						$this->image_lib->resize();
	                }
	            }else{
					 $this->session->setFlashdata('message','<span class="error_Success">'.$this->upload->display_errors().'</sapn>');
					if(!isset($id) || empty($id)){
						return redirect()->to(base_url('profile'));
					}
					else{
						return redirect()->to(base_url().'profile');
					}
					return redirect()->to(base_url('profile'));
				}
			}else{
				$this->session->setFlashdata('message','<span class="error_Success">Please select your signature.</sapn>');
				return redirect()->to(base_url('profile'));
			} */
			if(!isset($id) || empty($id)){
				$emp_sign="";
			}else{
				if(isset($emp_sign) && !empty($emp_sign)){
					$emp_sign=$emp_sign;
				}else{
					$emp_sign=$emp_signature_name;
				}
			}
		}
			$this->form_validation->reset();
		if($detail_type == 'basic_detail'){
			$this->form_validation->setRule('fname','FIrst Name','required');
			$this->form_validation->setRule('lname','Last Name','required');
			$this->form_validation->setRule('email','Email','required|valid_email');
			$this->form_validation->setRule('personal_email','Personal Email','required|valid_email');
			$this->form_validation->setRule('birth_date', 'Bith Date', 'required');
			$this->form_validation->setRule('phone_number','Phone No','required');
			// $this->form_validation->setRule('birth_month', 'Birth Month', 'required');
			// $this->form_validation->setRule('birth_year', 'Birth Year', 'required');
			if($user_role == 'admin') $this->form_validation->setRule('joining_date', 'Joining Date', 'required');
			// $this->form_validation->setRule('joining_month', 'Joining Month', 'required');
			// $this->form_validation->setRule('joining_year', 'Joining Year', 'required');
			$this->form_validation->setRule('gender', 'Gender', 'required');
			$this->form_validation->setRule('address', 'Address', 'required');
			$this->form_validation->setRule('designation', 'Designation', 'required');
		}
		if($detail_type == 'credentials_detail'){
			$this->form_validation->setRule('gmail_account','Gmail Account','required|valid_email');
			$this->form_validation->setRule('gmail_password','Gmail Password','required');
			$this->form_validation->setRule('skype_account','Skype Account','required|valid_email');
			$this->form_validation->setRule('skype_password','Skype Password','required');
		}
		// if(!isset($id) || empty($id)){
		// 	$this->form_validation->setRule('password','Password','required');
		// }
		//$this->form_validation->setRule('date_of_birth','Date of Birth','required');
		if($detail_type == 'bank_detail'){
			$this->form_validation->setRule('bank_name', 'Bank Name', 'required');
			$this->form_validation->setRule('account_number', 'Bank Account Number', 'required|min_length[9]|max_length[18]');
			$this->form_validation->setRule('ifsc_number', 'IFSC Number', 'required');
		}
		if($detail_type == 'payment_method'){
			$this->form_validation->setRule('upi_type', 'UPI Type', 'required');
			// $this->form_validation->setRule('account_number', 'Bank Account Number', 'required|min_length[9]|max_length[18]');
			$this->form_validation->setRule('upi_id', 'UPI ID', 'required');
		}
			// $this->form_validation->setRule('id_proof', 'Id Proof', 'required');
		if($detail_type == 'id_proof'){
			$this->form_validation->setRule('e_id', 'Id Proof', 'required');
		}
		if($detail_type == 'emp_signature'){
			$this->form_validation->setRule('e_id', 'Employee Signature', 'required');
		}
		if($this->form_validation->withRequest($this->request)->run() == false)
		{
			$this->session->setFlashdata('message', $this->form_validation->listErrors());
			// return redirect()->to(base_url('profile#id-proof-details'));
			return redirect()->to(base_url('profile'));

		}else{
			//die;
			if(!isset($id) || empty($id)){
				
			}else{
				// $decode = md5("GeekWeb123*");
				if($detail_type == 'basic_detail' && $user_role == 'admin'){
					$arr=array(
						'id' => $id,
						'fname' => $fname,
						'lname' => $lname,
						'email' => $email,
						'personal_email' => $personal_email,
						// 'password' => $decode,
						'gender' => $gender,
						'phone_number' => $phone_number,
						'date_of_birth' => Format_date($date_of_birth),
						'address' => $address,
						'designation' => $designation,
						'joining_date' => Format_date($joining_date),
						'status' => '1',
					);
				}elseif($detail_type == 'basic_detail'){
					$arr=array(
						'id' => $id,
						'fname' => $fname,
						'lname' => $lname,
						'email' => $email,
						'personal_email' => $personal_email,
						// 'password' => $decode,
						'gender' => $gender,
						'phone_number' => $phone_number,
						'date_of_birth' => Format_date($date_of_birth),
						'address' => $address,
						'designation' => $designation,
						'status' => '1',
					);
				}
				if($detail_type == 'bank_detail'){
					$arr=array(
						'id' => $id,
						// 'password' => $decode,
						'bank_name' => $bank_name,
						'account_number' => $account_number,
						'ifsc_number' => $ifsc_number,
						'status' => '1',
					);
				}
				if($detail_type == 'payment_method'){
					$arr=array(
						'id' => $id,
						'upi_type' => $upi_type,
						// 'account_number' => $account_number,
						'upi_id' => $upi_id,
						'qr_code' => $qrcode_picture,
					);
				}
				if($detail_type == 'credentials_detail'){
					$arr=array(
						'id' => $id,
						// 'password' => $decode,
						'credential'=>$credentials,
						'status' => '1',
					);
				}
				if($detail_type == 'id_proof'){
					$arr=array(
						'id' => $id,
						// 'password' => $decode,
						'id_proof' => $picture,
						'status' => '1',
					);
					$url1 = $_SERVER['DOCUMENT_ROOT'].'/assets/id_proof';
					$full_url1 =  $url1.'/'.$this->request->getPost('id_proof_name'); 
					$demo_url1 = $_SERVER['DOCUMENT_ROOT'].'/assets/temp/id_proof/'.$this->request->getPost('id_proof_name');
                    if(file_exists($full_url1) && $this->request->getPost('id_proof_name') != ''){
						rename($full_url1,$demo_url1);
					}
				}
				if($detail_type == 'emp_signature'){
					$arr=array(
						'id' => $id,
						// 'password' => $decode,
						'signature' => $emp_sign,
						'status' => '1',
					);
					$url_s = $_SERVER['DOCUMENT_ROOT'].'/assets/signature';
					$full_url =  $url_s.'/'.$this->request->getPost('emp_signature_name'); 
					$demo_url = $_SERVER['DOCUMENT_ROOT'].'/assets/temp/signature/'.$this->request->getPost('emp_signature_name');
					if(file_exists($full_url) && $this->request->getPost('emp_signature_name') !=  ''){
						rename($full_url,$demo_url);
					}
				}
				$insert_employee = $this->Employee_Model->update_employee($arr);
				if($insert_employee){
					$slug = $this->request->getPost("slug");
					return  (empty($slug)) ? redirect()->to(base_url('profile')) : redirect()->to(base_url().$slug.'/'.$id);
					
				}			
			}
		}
	}	

	public function add_employee_attendance(){
		$user_session=$this->session->get('id');
		if(!$user_session){
			return redirect()->to(base_url('admin'));
		}
		$data=array();
		$data['menu']="employee_add_attendance";
		$data['page_title']="Add Employee Attendance";
		$data['js_flag']="employee_attendance_profile_js";
		$data['get_employee_attendance']= $this->Employee_Attendance_Model->get_employee_attendance_date();
		$this->lib->view('administrator/employee/employee_attendance',$data);
	}

	public function insert_employee_attendance_new(){
		$attendance_date = $this->request->getPost("datepicker");
		$user_session=$this->session->get('id');
		$user_ip =  $this->get_user_ip_addr();
		$data = array();
		if(date('D',strtotime($attendance_date)) != 'Sat' && date('D',strtotime($attendance_date)) != 'Sun'){
			$insert_daily_work1 = '';
			$get_employee_attendance = $this->Employee_Attendance_Model->get_employee_attendance_date();
			
			$employee_in_time = $this->request->getPost("employee_in");
			
			// last only attendance_type update
			$attendance_type = $this->request->getPost("attendance_type");
			$in_out_time_count = $this->request->getPost("in_out_time_count");
			/**/
			$daily_work = trim($this->request->getPost("daily_work"));
			$attend_date=Format_date($attendance_date);
			$holiday_date1= $this->Holiday_Model->get_exists_holiday_date_formate($attend_date);
			$holiday_date=$holiday_date1[0]['numrows'];
			if(isset($holiday_date) && $holiday_date>0){
				$exist_date=date('j F Y',strtotime($attendance_date));
				$data['error_code'] = 1;
				$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>It was a official holiday on ('.$exist_date.')</p></div></div></div>';
				echo json_encode($data);exit;
			}
			$checkLeave = $this->Leave_Request_Model->get_employee_attendance_date($user_session,$attend_date);
			if(isset($checkLeave) && count($checkLeave) > 0){
				$exist_date=date('j F Y',strtotime($attendance_date));
				$data['error_code'] = 1;
				$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>You can`t add your attendance, First delete your leave on '.$exist_date.' before add your attendance</p></div></div></div>';
				echo json_encode($data);exit;
			}
			/**/
			if($in_out_time_count == 4){
				if(isset($get_employee_attendance) && !empty($get_employee_attendance)){
					foreach ($get_employee_attendance as $key1 => $value1) {
						$arr=array(
							'id' => $value1->id,
							'attendance_type' => $attendance_type,
						);
						$attendance_type_update= $this->Employee_Attendance_Model->update_employee($arr);
					}
					if($attendance_type_update){
						return redirect()->to(base_url('profile/add_employee_attendance'));
					}
				}
			}
			$employee_in="";
			if(!empty($employee_in_time)){
				
				$d2=date_create(CURRENT_TIME); 
				$current_time=date_format($d2,'Y-m-d H:i:s');
				$employee_in=$current_time;
				
				/* if($employee_in_time == 1){
					//in 
				}else if($employee_in_time == 2){
					// out
				}else if($employee_in_time == 3){
					//in
				}else if($employee_in_time == 4){
					//out
				} */
				
			}
			
			$this->form_validation->setRule('employee_in','In','required');
			$this->form_validation->setRule('attendance_type','Attendance','required');
			if($this->form_validation->withRequest($this->request)->run() == false)
			{
				$this->session->setFlashdata('message', $this->form_validation->listErrors());
				return redirect()->to(base_url('profile/add_employee_attendance'));

			}else{ 
				$log_time=array(
					'employee_id' => $user_session,
					'datetime' => date('Y-m-d h:i:s'),
					'ip_address' => $user_ip,
				);
				if(isset($get_employee_attendance) && !empty($get_employee_attendance)){
					$i=1;
					$c=count($get_employee_attendance);
					// echo "<pre>"; print_r($get_employee_attendance);
					// echo $c;exit;
					foreach ($get_employee_attendance as $key => $value) {
						if($c >= 1){
							$arr=array(
								'id' => $value->id,
								'attendance_type' => $attendance_type,
							);
							$insert_employee= $this->Employee_Attendance_Model->update_employee($arr);
						}
						if($c == 1){
							$employee_out=$value->employee_out;
							if($employee_out == ""){
								//update
								$arr=array(
									'id' => $value->id,
									'employee_out' => $employee_in,
									'attendance_type' => $attendance_type,
								);
								if($attendance_type == 'half_day' && $daily_work != ''){
									$arr1=array(
										'employee_id' => $user_session,
										'attendance_date' => $attend_date,
										'daily_work' => $daily_work,
									);	
									$insert_daily_work = $this->Employee_Attendance_Model->insert_daily_work($arr1);
								}elseif($daily_work != ''){
									$arr1=array(
										'employee_id' => $user_session,
										'attendance_date' => $attend_date,
										'daily_work' => $daily_work,
									);	
									$insert_daily_work = $this->Employee_Attendance_Model->insert_daily_work($arr1);
								}elseif($attendance_type == 'half_day' && $daily_work == ''){
									$data['error_code'] = 1;
									$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Attendance failed to add.</p></div></div></div>';
									$insert_daily_work = false;
								}elseif($attendance_type == 'full_day'){
									$insert_daily_work = true;
								}
								if($insert_daily_work){
									// echo "if 1";
									$insert_employee= $this->Employee_Attendance_Model->update_employee($arr);
									$data['error_code'] = 0;
									$this->db->table('login_logs')->insert($log_time);
								}
							}else{
								// second insert row
								$arr=array(
									'employee_in' => $employee_in,
									'employee_id' => $user_session,
									'attendance_type' => $attendance_type,
								);
								$insert_employee=$this->Employee_Attendance_Model->insert_employee($arr);
								$data['error_code'] = 0;
								$this->db->table('login_logs')->insert($log_time);
								// 	echo "else 2";
							}
						}
						if($c == 2){
							if($i == $c){
								$employee_out2=$value->employee_out;
								if($employee_out2 != "0000-00-00 00:00:00" || $employee_out2 != ""){
									// update
									$arr=array(
										'id' => $value->id,
										'employee_out' => $employee_in,
										'attendance_type' => $attendance_type,
									);
									// echo  $employee_in;
									// echo "if 2";
									$daily_work_list = $this->Employee_Attendance_Model->get_work_by_date($attend_date,$user_session);
									if(count($daily_work_list) > 0){
										$arr1=array(
											'id' => $daily_work_list[0]->id,
											'employee_id' => $user_session,
											'attendance_date' => $attend_date,
											'daily_work' => $daily_work,
											'updated_date' => date('Y-m-d h:i:s'),
										);	
										$insert_daily_work1 = $this->Employee_Attendance_Model->update_daily_work($arr1);
									}elseif($daily_work != ''){
										$arr1=array(
											'employee_id' => $user_session,
											'attendance_date' => $attend_date,
											'daily_work' => $daily_work,
										);
										$insert_daily_work1 = $this->Employee_Attendance_Model->insert_daily_work($arr1);
									}else{
										$insert_daily_work1 = '';
										$data['error_code'] = 1;
										$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Attendance failed to add.</p></div></div></div>';
									}
									if($insert_daily_work1){
										// echo "if 1";
										$insert_employee= $this->Employee_Attendance_Model->update_employee($arr);
										$data['error_code'] = 0;
										$this->db->table('login_logs')->insert($log_time);
									}
								}
							}
						}
					$i++; }
					

					
				}else{
					//echo "else 2";
					$arr=array(
						'employee_in' => $employee_in,
						'employee_id' => $user_session,
						'attendance_type' => $attendance_type,
					);
					$insert_employee= $this->Employee_Attendance_Model->insert_employee($arr);
					$data['error_code'] = 0;
					$this->db->table('login_logs')->insert($log_time);
					
				}
				
			}
			$data['daily_work_list'] = $this->Employee_Attendance_Model->get_work_by_date($attend_date,$user_session);
		}
		echo json_encode($data);exit;
		//die();
		// if($insert_employee){
			//return redirect()->to(base_url('profile/add_employee_attendance'));
		// }
	}

	public function insert_employee_attendance(){
		$user_session=$this->session->get('id');
		$user_ip =  $this->get_user_ip_addr();
		
		$get_employee_attendance= $this->Employee_Attendance_Model->get_employee_attendance_date();
		
		$employee_in_time = $this->request->getPost("employee_in");
		
		// last only attendance_type update
		$attendance_type = $this->request->getPost("attendance_type");
		$in_out_time_count = $this->request->getPost("in_out_time_count");
		/**/
		$attendance_date = $this->request->getPost("datepicker");
		$attend_date=Format_date($attendance_date);
		$holiday_date1= $this->Holiday_Model->get_exists_holiday_date_formate($attend_date);
		$holiday_date=$holiday_date1[0]['numrows'];
		if(isset($holiday_date) && $holiday_date>0){
			$exist_date=date('j F Y',strtotime($attendance_date));
			$error_msg="<p Class='text-center' style='color:red;'>It was a official holiday on (".$exist_date.")</p>";
			$this->session->setFlashdata('message',$error_msg);
			return redirect()->to(base_url('profile/add_employee_attendance'));
		}
		/**/
		if($in_out_time_count == 4){
			if(isset($get_employee_attendance) && !empty($get_employee_attendance)){
				foreach ($get_employee_attendance as $key1 => $value1) {
					$arr=array(
						'id' => $value1->id,
						'attendance_type' => $attendance_type,
					);
					$attendance_type_update= $this->Employee_Attendance_Model->update_employee($arr);
				}
				if($attendance_type_update){
					return redirect()->to(base_url('profile/add_employee_attendance'));
				}
			}
		}
		$employee_in="";
		if(!empty($employee_in_time)){
			
			$d2=date_create(CURRENT_TIME); 
			$current_time=date_format($d2,'Y-m-d H:i:s');
			$employee_in=$current_time;
			
			/* if($employee_in_time == 1){
				//in 
			}else if($employee_in_time == 2){
				// out
			}else if($employee_in_time == 3){
				//in
			}else if($employee_in_time == 4){
				//out
			} */
			
		}
		 
		$this->form_validation->setRule('employee_in','In','required');
		 $this->form_validation->setRule('attendance_type','Attendance','required');
		if($this->form_validation->run() == false)
		{
			$this->session->setFlashdata('message', validation_errors());
			return redirect()->to(base_url('profile/add_employee_attendance'));

		}else{ 
			$log_time=array(
				'employee_id' => $user_session,
				'datetime' => date('Y-m-d h:i:s'),
				'ip_address' => $user_ip,
			);
			if(isset($get_employee_attendance) && !empty($get_employee_attendance)){
				$i=1;
				$c=count($get_employee_attendance);
				foreach ($get_employee_attendance as $key => $value) {
					if($c == 1){
						$employee_out=$value->employee_out;
						if($employee_out == ""){
							//update
							$arr=array(
								'id' => $value->id,
								'employee_out' => $employee_in,
								'attendance_type' => $attendance_type,
							);
							//echo "if 1";
							$insert_employee= $this->Employee_Attendance_Model->update_employee($arr);
							$this->db->table('login_logs')->insert($log_time);
						}else{
							// second insert row
							$arr=array(
								'employee_in' => $employee_in,
								'employee_id' => $user_session,
								'attendance_type' => $attendance_type,
							);
							$insert_employee=$this->Employee_Attendance_Model->insert_employee($arr);
							$this->db->table('login_logs')->insert($log_time);
							//echo "else 2";
						}
					}
					if($c == 2){
						if($i == $c){
						$employee_out2=$value->employee_out;
						if($employee_out2 != "0000-00-00 00:00:00" || $employee_out2 != ""){
							// update
							$arr=array(
								'id' => $value->id,
								'employee_out' => $employee_in,
								'attendance_type' => $attendance_type,
							);
							//echo  $employee_in;
							//echo "if 2";
							$insert_employee= $this->Employee_Attendance_Model->update_employee($arr);
							$this->db->table('login_logs')->insert($log_time);
						}
						}
					}
				$i++; }
			}else{
				//echo "else 2";
				$arr=array(
					'employee_in' => $employee_in,
					'employee_id' => $user_session,
					'attendance_type' => $attendance_type,
				);
				$insert_employee= $this->Employee_Attendance_Model->insert_employee($arr);
				$this->db->table('login_logs')->insert($log_time);
				
			}
			
		}
		//die();
		if($insert_employee){
			return redirect()->to(base_url('profile/add_employee_attendance'));
		}
	}

	public function getAttendance(){
		$data = array();
		$user_session=$this->session->get('id');
		$attendance_date = $this->request->getPost("datepicker");
		if(date('D',strtotime($attendance_date)) != 'Sat' && date('D',strtotime($attendance_date)) != 'Sun'){
			$attend_date=Format_date($attendance_date);
			$data['get_employee_attendance']= $this->Employee_Attendance_Model->get_employee_attendance_date();
			$data['daily_work_list'] = $this->Employee_Attendance_Model->get_work_by_date($attend_date,$user_session);
		}
		echo json_encode($data); 
	}

	public function insert_today_task(){
		$data = array();
		$user_session=$this->session->get('id');
		$attendance_type = $this->request->getPost("attendance_type");
		$attendance_date = $this->request->getPost("datepicker");
		$attend_date=Format_date($attendance_date);
		$daily_work = $this->request->getPost("daily_work");
		$get_employee_attendance= $this->Employee_Attendance_Model->get_employee_attendance_date();
		
		foreach ($get_employee_attendance as $key => $value) {
			$arr=array(
				'id' => $value->id,
				'attendance_type' => $attendance_type,
			);
			$insert_employee = $this->Employee_Attendance_Model->update_employee($arr);
		}
		$daily_work_list = $this->Employee_Attendance_Model->get_work_by_date($attend_date,$user_session);
		if(count($daily_work_list) > 0){
			$arr1=array(
				'id' => $daily_work_list[0]->id,
				'employee_id' => $user_session,
				'attendance_date' => $attend_date,
				'daily_work' => $daily_work,
				'updated_date' => date('Y-m-d h:i:s'),
			);	
			$insert_daily_work1 = $this->Employee_Attendance_Model->update_daily_work($arr1);
		}else{
			$arr1=array(
				'employee_id' => $user_session,
				'attendance_date' => $attend_date,
				'daily_work' => $daily_work,
			);
			$insert_daily_work1 = $this->Employee_Attendance_Model->insert_daily_work($arr1);
		}
		if($insert_daily_work1){
			$data['error_code'] = 0;
			$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Task update added.</p></div></div></div>';
		}else{
			$data['error_code'] = 1;
			$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Task update failed to add!</p></div></div></div>';
		}
		echo json_encode($data);
	}
	
	public function download_join_letter(){
		
		$data=array();
		$user_session=$this->session->get('id');
		$data['employee_details']= $this->Employee_Model->get_employee($user_session);
		if(isset($data['employee_details'][0]) && !empty($data['employee_details'][0])){
         $filename=$data['employee_details'][0]->fname."_joining_letter";
    	}else{
    		$filename="joining_letter";
    	}
		$html = $this->load->view('administrator/employee/download_salary_slip', $data, true);

		$this->mpdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
	}

	public function download_salary_slip(){
		$data=array();
		$user_session=$this->session->get('id');
		$data['employee_details']= $this->Employee_Model->get_employee($user_session);
		$data['page_title']="Salary Slip";
		if(isset($data['employee_details'][0]) && !empty($data['employee_details'][0])){
         $filename=$data['employee_details'][0]->fname."_joining_letter";
    	}else{
    		$filename="joining_letter";
    	}
		$data['js_flag']="salary_slip_js";
		$data['menu']="salary_slip";
		$this->lib->view('administrator/employee/salary_slip',$data,true);
	}

	public function emp_salary_detail(){
		$data=array();
		$user_session=$this->session->get('id');
		$year = $this->request->getPost("select_year");
		$employee_details = $this->Employee_Model->get_employee($user_session);
		$data['emp_salary_month'] = array();
		$data['salary_month_num'] = array();
		if($year >= date('Y',strtotime($employee_details[0]->employed_date))){
			foreach(MONTH_NAME as $key =>$month_name){
				// $emp_day_all=$this->Employee_Attendance_Model->salary_count_day($key+1,$year,$user_session);
				$emp_day_all=$this->Leave_Request_Model->get_salary_pay($user_session,$key+1,$year);
				if(!empty($emp_day_all)){
					array_push($data['emp_salary_month'],$month_name);
					array_push($data['salary_month_num'],($key+1));
				}
			}
		}
		echo json_encode($data);
	}

	public function uploadAgreement(){
		$user_role=$this->session->get('user_role');
		if($user_role == 'admin'){
			$id = $this->request->getPost("e_id");
			$url = $_SERVER['DOCUMENT_ROOT'].'/assets/agreement';
			$picture="";
			$full_url1 =  $url.'/agreement_'.$id.'.pdf'; 
			$demo_url1 = $_SERVER['DOCUMENT_ROOT'].'/assets/temp/agreement/agreement_'.$id.'.pdf';
			if(file_exists($full_url1)){	
				rename($full_url1,$demo_url1);
			}
			if(!empty($_FILES['agreement']['name'])){
				$file = $this->request->getFile("agreement");

				$agreement = 'agreement_'.$id.'.pdf';
				
				$validated = $this->validate([
					'agreement' => [
						'uploaded[agreement]',
						'mime_in[agreement,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword]',
						'max_size[agreement,8192]',
					],
				]);
				if(!$validated){
					$data['error_code'] = 1;
					$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">'.$this->validator->listErrors().'</div></div></div>';
					echo json_encode($data);exit;
				}else{
					if($file->move($url, $agreement)){
						$data['error_code'] = 0;
						$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Agreement uploaded.</p></div></div></div>';
						echo json_encode($data);exit;
					}else{
						$data['error_code'] = 1;
						$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Failed to upload agreement.</p></div></div></div>';
						echo json_encode($data);exit;
					}
				}
			}else{
				$data['error_code'] = 1;
				$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please select your agreement.</p></div></div></div>';
				echo json_encode($data);exit;
			}
		}
	}

	public function uploadPhoto(){
		/* $insert_employee = $this->Employee_Model->update_employee($arr); */
		$user_role=$this->session->get('user_role');
		if($user_role == 'admin'){
			$id = $this->request->getPost("e_id");
			$url = $_SERVER['DOCUMENT_ROOT'].'/assets/upload/passport_photo';
			$picture="";
			if(!empty($_FILES['passportPhoto']['name'])){
				$file = $this->request->getFile("passportPhoto");

				$passportPhoto = date('dmYhis').$file->getName();

				$validated = $this->validate([
					'passport photo' => [
						'uploaded[passportPhoto]',
						'mime_in[passportPhoto,image/jpg,image/jpeg,image/png]',
						'max_size[passportPhoto,200]',
					],
				]);
				if(!$validated){
					$data['error_code'] = 1;
					$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">'.$this->validator->listErrors().'</div></div></div>';
					echo json_encode($data);exit;
				}else{
					if($file->move($url, $passportPhoto)){
						
						$arr=array(
							'id' => $id,
							// 'password' => $decode,
							'passport_photo' => $passportPhoto,
							'status' => '1',
						);
						$insert_employee = $this->Employee_Model->update_employee($arr);
						if($insert_employee){
							$url_s = $_SERVER['DOCUMENT_ROOT'].'/assets/upload/passport_photo';
							$full_url =  $url_s.'/'.$this->request->getPost('passportPhoto_name'); 
							$demo_url = $_SERVER['DOCUMENT_ROOT'].'/assets/temp/passport_photo/'.$this->request->getPost('passportPhoto_name');
							if(file_exists($full_url) && $this->request->getPost('passportPhoto_name') !=  ''){
								rename($full_url,$demo_url);
							}
							$data['error_code'] = 0;
							$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Passport size Photo uploaded.</p></div></div></div>';
							echo json_encode($data);exit;
						}else{
							$data['error_code'] = 1;
							$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Failed to upload passport size photo.</p></div></div></div>';
							echo json_encode($data);exit;
						}
					}else{
						$data['error_code'] = 1;
						$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Failed to upload passport size photo.</p></div></div></div>';
						echo json_encode($data);exit;
					}
				}
			}else{
				$data['error_code'] = 1;
				$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Please select your passport size photo.</p></div></div></div>';
				echo json_encode($data);exit;
			}
		}
	}

	public function insert_emergency_detail(){
		//echo "<script>alert('data goes here');</script>";
		$user_role=$this->session->get('user_role');
		$id = $this->request->getPost("emergency_contact_id");
		$employee_id = $this->request->getPost("e_id");

		$name = $this->request->getPost("emergency_contact_name");
		$phone_number = $this->request->getPost("emergency_contact_number");
		$email = $this->request->getPost("emergency_contact_email");
		$address = $this->request->getPost("emergency_contact_address");

		$this->form_validation->reset();
		$this->form_validation->setRule('emergency_contact_name','Emergency Contact Name','required');
		$this->form_validation->setRule('emergency_contact_number','Emergency Contact Phone No','required');
		$this->form_validation->setRule('emergency_contact_email','Emergency Contact Email','required|valid_email');
		$this->form_validation->setRule('emergency_contact_address', 'Emergency Contact Address', 'required');

		if($this->form_validation->withRequest($this->request)->run() == false)
		{
			$this->session->setFlashdata('message', $this->form_validation->listErrors());
			// return redirect()->to(base_url('profile#id-proof-details'));
			$slug = $this->request->getPost("slug");
			return  (empty($slug)) ? redirect()->to(base_url('profile')) : redirect()->to(base_url().$slug.'/'.$id);

		}else{
			//die;
			if(!isset($id) || empty($id)){
				$arr=array(
					'employee_id' => $employee_id,
					'name' => $name,
					'email' => $email,
					'phone_number' => $phone_number,
					'address' => $address,
				);
				$insert_employee = $this->Employee_Model->insert_emergencyContactDetail($arr);
			}else{
				$arr=array(
					'id' => $id,
					'employee_id' => $employee_id,
					'name' => $name,
					'email' => $email,
					'phone_number' => $phone_number,
					'address' => $address,
					'updated_date' => date('Y-m-d H:i:s'),
				);
				$insert_employee = $this->Employee_Model->update_emergencyContactDetail($arr);
			}
			if($insert_employee){
				$slug = $this->request->getPost("slug");
				return  (empty($slug)) ? redirect()->to(base_url('profile')) : redirect()->to(base_url().$slug.'/'.$employee_id);
				
			}			
		}
	}
}

?>