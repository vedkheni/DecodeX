<?php
// defined('BASEPATH') OR exit('No direct script access allowed');
namespace App\Controllers;
use App\Controllers\BaseController;


class Login extends BaseController {

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
	public function index()
	{
		/* $set_session = array( 
			// 'username' => $gmail_account,
			'username' => 'Sagar S',
			'gender' => 'male',
			'useremail' => "sagargeek435@gmail.com",
			'id' => 15,
			'user_role' => "admin",
			'profile_image' => '',
		); 
		$this->session->set($set_session); */
		$user_session=$this->session->get('id');
		if($user_session){
			return redirect()->to(base_url('dashboard'));	
		}
		$data=array();
		$data['error_massage'] = '';
		/* $this->load->model('Employee_Model');
		$this->load->model('Designation_Model'); */
		$data['designation']= $this->Designation_Model->get_designation();
		$data['page_title']="Login Employee";
		$user_ip =  $this->get_user_ip_addr();
		$current_date = date('Y-m-d H:i:s');
		if(!empty($this->request->getPost())){
			// $this->load->model('login_Model');
			$useremail = $this->request->getPost("email");
			$userpass = trim($this->request->getPost("password"));
			/* $this->form_validation->reset();
			$this->form_validation->setRule('password','Password','required');
			$this->form_validation->setRule('email', 'Username Or Email', 'required'); */
			$attempt_check_data = array();
			$rules = [
				"password" => [
					"rules" => "required",
					"label" => "Password",
				],
				"email" => [
					"rules" => "required",
					"label" => "Username Or Email",
				],
			];
			if (!$this->validate($rules)) {
				$this->session->setFlashdata('message', $this->validator->listErrors());
				$massage = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' . $this->validator->listErrors() . '</p></div></div></div>';
				$data['error_massage'] = $massage;
				return view('administrator/employee_login', $data);
			} else {
				/* $attempt_check_data = $this->login_Model->attempt_check($user_ip);
			$user_temp_block=false;
			if($attempt_check_data){
				$attempts_status = $attempt_check_data->status;
				if($attempts_status){
					$last_attempted_date = $attempt_check_data->last_attempted_date;
					$block_mins = round(abs(strtotime($current_date) - strtotime($last_attempted_date)) / 60);
					if($block_mins >= USER_BLOCK_TIME_MIN){
						$this->login_Model->attempt_delete($user_ip);
					} else {
						$user_temp_block = true;
					}
				}
			}else{
				$attempt_check_data=array();
			} */
				$decode = md5($userpass);
				$data1 = array(
					'email' => $useremail,
					'password' => $decode
				);
				$login = $this->login_Model->login($data1);
				//echo "<pre>"; print_r($login->row()); echo "</pre>";
				//die;
				$messages_set_d = "";
				$messages_set = "";
				//&& !$user_temp_block
				if ($login->getNumRows() > 0) {

					/* if ($this->request->getPost('recaptcha_response')) {

					// Build POST request:
					$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
					$recaptcha_secret = SECRET_KEY;
					$recaptcha_response = $this->request->getPost('recaptcha_response');

					// Make and decode POST request:
					$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
					$recaptcha = json_decode($recaptcha);

					if ($recaptcha->score >= 0.5) { */
					$login_status = $this->login_Model->login_status($data1);
					if ($login_status->getNumRows() > 0) {
						//echo "sdd";
						//die;

						$row = $login->getRow();
						if (!empty($row->credential)) {
							$json_decode = json_decode($row->credential);
							$gmail_account = $json_decode->gmail->gmail_account;
						} else {
							$gmail_account = $row->email;
						}
						// echo "<pre>";
						// print_r($row);
						// print_r($json_decode);
						// die;
						$set_session = array(
							// 'username' => $gmail_account,
							'username' => $row->fname,
							'gender' => $row->gender,
							'useremail' => $gmail_account,
							'id' => $row->id,
							'user_role' => $row->user_role,
							'profile_image' => $row->profile_image,
						);
						$this->session->set($set_session);
						if ($attempt_check_data) {
							$this->login_Model->attempt_delete($user_ip);
						}
						$arr = array(
							'employee_id' => $row->id,
							'datetime' => date('Y-m-d h:i:s'),
							'ip_address' => $user_ip,
						);
						$this->login_Model->logsInsert($arr);
						return redirect()->to(base_url() . 'dashboard');
					} else {
						//echo "dsdsd";
						$this->session->setFlashdata('messages', '<div class="msg-box error-box box2"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text text2"><p><span class="error_Success">Your account deactivated, please contact administrator</span></p></div></div></div>');
						return redirect()->to(base_url());
					}
					/* }
				else{
					$captch_error='<div class="msg-box error-box box2"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text text2"><p><span class="error_Success">Sorry Google reCAPTCHA Unsuccessful!!</span></p></div></div></div>';
					$this->session->setFlashdata('messages', $captch_error);
					return redirect()->to(base_url());
					
				}
				} */
				} else {
					/* $attempt_check_data = $this->login_Model->attempt_check($user_ip);
				$attempts_info = array();
				if(isset($attempt_check_data) && count(json_decode($attempt_check_data->attempt))){
					$attempts_info_db = $attempt_check_data->attempt;
						$id = $attempt_check_data->id;
						$attempts_info =json_decode($attempts_info_db);
						$attempts_info_count = count(json_decode($attempt_check_data->attempt));

						if($attempts_info_count < LOGIN_ATTEMPT){
							$remaining_attempt = LOGIN_ATTEMPT-$attempts_info_count;
							$attempt_info = array("username"=>$useremail, "password"=>$userpass);
							array_push($attempts_info, $attempt_info);
							$attempts_info_data =json_encode($attempts_info);
							
							
							$attemp_data = array(
							'attempt'=> $attempts_info_data,
							'last_attempted_date'=> $current_date,
							);
							$this->login_Model->attempt_update($attemp_data, $id);
							 $messages_set = '</br><span class="error_Success">'.$remaining_attempt.' attempts remaining.</span>';
							
						} else {

							$attempts_status = $attempt_check_data->status;
							if($attempts_status){
								//Blocked IP check time tracking
								
								// die
								$last_attempted_date = $attempt_check_data->last_attempted_date;
								
								$block_mins = round(abs(strtotime($current_date) - strtotime($last_attempted_date)) / 60);
								$remaining_block_mins = USER_BLOCK_TIME_MIN- $block_mins;
								$attemp_data = array(
								'status'=> '1',
							);
							$this->login_Model->attempt_update($attemp_data, $id);	
								$messages_set = '</br><span class="error_Success">You are temporarily blocked. Please try after '.$remaining_block_mins.' minutes</span>';
							}else{
									$attempt_info = array("username"=>$useremail, "password"=>$userpass);
							array_push($attempts_info, $attempt_info);
							$attempts_info_data =json_encode($attempts_info);
							
							
							$attemp_data = array(
							'status'=> '1',
							'attempt'=> $attempts_info_data,
							'last_attempted_date'=> $current_date,
							);
							$this->login_Model->attempt_update($attemp_data, $id);

							}
						}

				}else{
					$attempt_info = array("username"=>$useremail, "password"=>$userpass);
						array_push($attempts_info, $attempt_info);
						$attempts_info_data =json_encode($attempts_info);
						$remaining_attempt = LOGIN_ATTEMPT;
						$attemp_data = array(
						'ip' => $user_ip,
						'attempt'=> $attempts_info_data,
						'last_attempted_date'=> $current_date,
						'created_date'=> $current_date
						);
				//rint_r($attemp_data);
			//die;
					 $this->login_Model->attempt_insert($attemp_data);
					 $messages_set = '</br><span class="error_Success">'.$remaining_attempt.' attempts remaining.</span>';

						if(!$user_temp_block){
							$messages_set_d = '<span class="error_Success">Invalid Email Address Or Password</span>';
						}
					
				} */

					$messages_set_d = '<span class="error_Success">Invalid Email Address Or Password</span>';
					$this->session->setFlashdata('message',
						$messages_set_d . $messages_set
					);
					$massage = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Invalid email address or password</p></div></div></div>';
					$data['error_massage'] = $massage;
					return view('administrator/employee_login', $data);
				}
			}
		}else{
			return view('administrator/employee_login', $data);	
		}
	}
	public function sendForgotPass(){
		$data = array();
		$email = $this->request->getPost('email');
		if($email){
			$existsEmployee = $this->Employee_Model->get_exists_employee($email);
			if(!empty($existsEmployee)){
				$data_form = array("email" => $email);
				$api_url = API_URL."forgot_password.php";
				$api_data = $this->allfunction->curlPost($api_url,$data_form);
				if($api_data){
					if(isset($api_data['status']) && isset($api_data['message']))
					$data['error_code'] = ($api_data['status'] == 0)? 1 : 0;
					$data['message'] =  $api_data['message'];
				}
			}else{
				$data['error_code'] = 1;
				$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>User data not found</p></div></div></div>';
			}
		}else{
			$data['error_code'] = 1;
			$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>E-Mail address not found</p></div></div></div>';
		}
		echo json_encode($data);
	}
	public function forgotPass(){
		$uid = $this->uri->getSegment(2);
		$token = $this->uri->getSegment(3);
		$api_url = API_URL."forgot_password.php";
		
		$form = array("id" => $uid, "user_token" => $token, "vaidate_token" => 1);
		$token_data = $this->allfunction->curlPost($api_url,$form);
		if($token_data){			
			if(isset($token_data['status']) && isset($token_data['message']) && $token_data['status'] == "0")
			{	
				$data['token_expired']['status'] = "fail";
				$data['token_expired']['title'] = "You don't have any valid codes at the moment.";
				$data['token_expired']['message'] = $token_data['message'].'<a data-toggle="modal" data-target="#forgotPass"> Link</a>';
				$data['vaidate_token']=0;
			}else{
				$data['vaidate_token']=1;
			}
		}
		$data['uid'] = $uid;
		$data['token'] = $token;
		$data['error_massage'] = '';
		$data['designation']= $this->Designation_Model->get_designation();
		$data['page_title']="Login Employee";
		$this->session->setFlashdata('messages', $token_data['message']);
		return view('administrator/employee_login', $data);
		
		/* if($data['vaidate_token'] == 1){
		}else{
			// $this->session->setFlashdata('messages', $token_data['message']);
			// return redirect()->to(base_url());
		} */
	}
	public function resetPass(){
		$data = array();
		$api_url = API_URL."forgot_password.php";
		if($this->request->getPost()){		
			$password = $this->request->getPost('new_password');
			$com_password = $this->request->getPost('confirm_password');
			$token = $this->request->getPost('token');
			$uid = $this->request->getPost('uid');
			if(!empty($uid) && !empty($token) && !empty($password) && !empty($com_password)){
				
				if(trim($password) == trim($com_password)){
					$data_form = array(
						"id" => $uid,
						"user_token" => $token,
						"password" => $password,
					);
					
					$api_data = $this->allfunction->curlPost($api_url,$data_form);
	
					if($api_data){
						if(isset($api_data['status']) && $api_data['status'] == '1')
						{
							$data['token_expired']['status'] = "success";
							$data['token_expired']['title'] = "Success!";
							$data['token_expired']['message'] = $api_data['message'];
						}else{
							$data['error'] = $api_data['message'];
						}
					}
				}else{
					$data['error'] = "These passwords don't match. Try again?";
				}
			}
		}
		echo json_encode($data);exit;
	}
	public function sign_up(){
		$data=array();
		$this->load->model('Designation_Model');
		$data['designation']= $this->Designation_Model->get_designation();
		return view('administrator/employee_add',$data);
	}
	public function insert_data()
	{
		$data=array();
		// $this->load->model('Employee_Model');
		$this->load->model('Designation_Model');
		$data['designation']= $this->Designation_Model->get_designation();

		$fname = $this->request->getPost("fname");
		$lname = $this->request->getPost("lname");
		$email = $this->request->getPost("email");
		
		$password = "GeekWeb123*";
		$phone_number = $this->request->getPost("phone_number");
		$date_of_birth = $this->request->getPost("birth_date");
		
		$gender = $this->request->getPost("gender");
		$address = $this->request->getPost("address");
		$designation = $this->request->getPost("designation");
		$joining_date= $this->request->getPost("joining_date");
		
		/* $skype_account = $this->request->getPost("skype_account");
		$skype_password = $this->request->getPost("skype_password");
		$gmail_account = $this->request->getPost("gmail_account");
		$gmail_password = $this->request->getPost("gmail_password"); */
		
		/* $crendt=array(
			"gmail"=>array('gmail_account'=>$gmail_account,'gmail_password'=>$gmail_password),
			"skype"=>array('skype_account'=>$skype_account,'skype_password'=>$skype_password),
		); */
		//$credentials=json_encode($crendt);
		  $credentials="";
		
		$this->form_validation->setRule('fname','First Name','required');
		$this->form_validation->setRule('lname','Last Name','required');
		/* $this->form_validation->setRule('gmail_account','Gmail Account','required|valid_email');
		$this->form_validation->setRule('gmail_password','Gmail Password','required');
		$this->form_validation->setRule('skype_account','Skype Account','required|valid_email');
		$this->form_validation->setRule('skype_password','Skype Password','required'); */
		$this->form_validation->setRule('email','Email','required|valid_email|is_unique[employee.email]');
		$this->form_validation->setRule('designation','Designation','required');
		$this->form_validation->setRule('phone_number','Phone No','required');
		$this->form_validation->setRule('birth_date','Date of Birth','required');
		$this->form_validation->setRule('gender', 'Gender', 'required');
		$this->form_validation->setRule('address', 'Address', 'required');
		$this->form_validation->setRule('joining_date', 'Joining Date', 'required');
		// $this->load->model('Employee_Model');

		if($this->form_validation->run() == false)
		{
			$this->session->setFlashdata('message', $this->form_validation->listErrors());
			// return redirect()->to(base_url('login/sign_up'));
			return view('administrator/employee_login',$data);
		}else{
			// $recaptchaResponse = trim($this->request->getPost('g-recaptcha-response'));

			// 	$userIp=$this->input->ip_address();

			// 	$user_ip =  $this->get_user_ip_addr();

			// 	$current_date = date('Y-m-d H:i:s');

			// 	$secret = $this->config->item('google_secret');

			// 	$url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;

			// 	$ch = curl_init(); 

			// 	curl_setopt($ch, CURLOPT_URL, $url); 

			// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

			// 	$output = curl_exec($ch); 

			// 	curl_close($ch);      

			// 	$status= json_decode($output, true);

			/* if ($this->request->getPost('recaptcha_response')) {

				// Build POST request:
				$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
				$recaptcha_secret = SECRET_KEY;
				$recaptcha_response = $this->request->getPost('recaptcha_response');

				// Make and decode POST request:
				$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
				$recaptcha = json_decode($recaptcha);
				if ($recaptcha->score >= 0.5) { */
				// if ($status['success']) {
					
					$decode = md5($password);
					$arr=array(
					'fname' => $fname,
					'lname' => $lname,
					'email' => $email,
					'password' => $decode,
					'gender' => $gender,
					'phone_number' => $phone_number,
					'date_of_birth' => Format_date($date_of_birth),
					'address' => $address,
					'designation' => $designation,
					'joining_date' => Format_date($joining_date),
					'credential'=>$credentials,
					'status' => '0',
				);
			/* 	echo "<pre>";
				print_r($arr);
				die; */
			
					$insert_employee= $this->Employee_Model->insert_employee($arr);
					if($insert_employee){
						$user_exist_error='<div class="msg-box success-box box2">
						<div class="msg-content">
							<div class="msg-icon"><i class="fas fa-check"></i></div>
							<div class="msg-text text2"><p>Sign Up Successfully</p></div>
						</div>
					</div>';
						$this->session->setFlashdata('messages', $user_exist_error);
						return redirect()->to(base_url());
					}
					
				/*  }else{
					$captch_error='<div class="msg-box error-box box2">
					<div class="msg-content">
						<div class="msg-icon"><i class="fas fa-times"></i></div>
						<div class="msg-text text2"><p>Sorry Google reCAPTCHA Unsuccessful!!</p></div>
						</div>
					</div>';
					$this->session->setFlashdata('messages', $captch_error);
					// return redirect()->to(base_url('login/sign_up'));
					return view('administrator/employee_login',$data);
					
				 }
			}	*/
		}
	}
	public function do_logout(){
		
        $this->session->sess_destroy();
        return redirect()->to(base_url());
    }
	public function js_validation(){
		$data = array();
		$user_session=$this->session->set('id');
		if($user_session){
			return redirect()->to(base_url('dashboard'));	
		}
		$useremail = $this->request->getPost("email");
		$userpass = trim($this->request->getPost("password"));
		/* $this->form_validation->reset();
		$this->form_validation->setRule('password','Password','required');
		$this->form_validation->setRule('email', 'Username Or Email', 'required'); */

		$rules = [
			"password" => [
			  "rules" => "required",
			  "label" => "Password",
			],
			"email" => [
			  "rules" => "required",
			  "label" => "Username Or Email",
			],
		  ];
		if(!$this->validate($rules))
		{		
			$this->session->setFlashdata('message', $this->validator->listErrors());
			$data['error_code'] = 1;
			$data['massage'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>'.$this->validator->listErrors().'</p></div></div></div>';
		}else{
			$decode = md5($userpass);
			$data1 = array( 
				'email' => $useremail, 
				'password' => $decode 
			);
			$login= $this->login_Model->login($data1);
            if($login->getNumRows()>0){
				$data['error_code'] = 0;
				$data['massage'] = '';
			}else{
				$data['error_code'] = 1;
				$data['massage'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Invalid email address or password</p></div></div></div>';
            }
		}	
		echo json_encode($data);
    }
}
