<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Admin extends BaseController {
	public function index()
	{
		
// 		$this->db = \Config\Database::connect();
// 		echo  $this->db->table('user')->where('id', 1)->update(array('password' => '25f9e794323b453885f5181f1b624d0b' ,'email' => 'sagargeek435@gmail.com'));
// 		// echo $this->db->simpleQuery("");
// 		echo "hello";
// 		die;
		$user_session=$this->session->get('id');
		if($user_session){
			return redirect()->to(base_url('dashboard'));	
		}
		$data['page_title']="Admin Login";
		$data['error_massage'] = '';
		$useremail = $this->request->getPost("email");
		$userpass = trim($this->request->getPost("password"));
		$this->form_validation->reset();
		$this->form_validation->setRule('password','Password','required');
		$this->form_validation->setRule('email', 'Username Or Email', 'required');
		if(!$this->validate($this->form_validation->getRules()))
		{
			$this->session->setFlashdata('message', $this->validator->listErrors());
			return view('administrator/login');
			
		}
		else
		{
			$decode = md5($userpass);
			$data1 = array( 
					'email' => $useremail, 
					'password' => $decode 
				 );
			$login= $this->Administrator_Model->login($data1);
				if($login->getNumRows()==1){
					/*if ($this->request->getPost('recaptcha_response')) {

						// Build POST request:
						$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
						$recaptcha_secret = SECRET_KEY;
						$recaptcha_response = $this->request->getPost('recaptcha_response');

						// Make and decode POST request:
						$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
						$recaptcha = json_decode($recaptcha);
						
						if ($recaptcha->score >= 0.5) {*/
							$row=$login->getRow();
							$set_session = array( 
								'username' => $row->username,
								'useremail' => $row->email,
								'gender' => $row->gender,
								'id' => $row->id,
								// 'admin_id' => $row->id,
								'user_role' => $row->user_role,
								'profile_image' => $row->profile_image,
								);
							$this->session->set($set_session);
							return redirect()->to(base_url('dashboard'));
						/*}
						else
						{
							$captch_error='<div class="msg-box error-box box2">
							<div class="msg-content">
								<div class="msg-icon"><i class="fas fa-times"></i></div>
								<div class="msg-text text2"><p><span class="error_Success">Sorry Google reCAPTCHA Unsuccessful!!</span></p></div>
								</div>
							</div>';
							$this->session->setFlashdata('messages', $captch_error);
							return redirect()->to(base_url().'admin');
							
						}
					}*/
						
					}else{
				$this->session->setFlashdata('message', '<span class="error_Success">Invalid username  or password</span>');
				$massage = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Invalid email address or password</p></div></div></div>';
				$data['error_massage'] = $massage;
				return view('administrator/login',$data);
			}
		}
		
		return view('welcome_message');
	}
	
	public function do_logout(){
		
        $this->session->destroy();
        delete_cookie('menu');
        return redirect()->to(base_url());
	}
	public function js_validation(){
		$data = array();
		$user_session=$this->session->get('id');
		if($user_session){
			return redirect()->to(base_url('dashboard'));	
		}
		$useremail = $this->request->getPost("email");
		$userpass = trim($this->request->getPost("password"));
		$this->form_validation->reset();
		$this->form_validation->setRule('password','Password','required');
		$this->form_validation->setRule('email', 'Username Or Email', 'required');
		if(!$this->validate($this->form_validation->getRules()))
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
			$login= $this->Administrator_Model->login($data1);
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
	
	public function view_data(){
		$employee_id=20;
		echo "<pre>";
		echo "prof_tax function : ". $this->salarypayfunction->prof_tax('10000');
		echo "<br>";
		echo "working_holiday_days function : ";
		$working_holiday_days=$this->salarypayfunction->working_holiday_days(array('month' => '4','year' => '2021'));
		print_r($working_holiday_days);
		echo "<br>";

		echo "employee_present_days function : ";
		$employee_present_days=$this->salarypayfunction->employee_present_days(array('month' => '4','year' => '2021','employee_id' => $employee_id));
		print_r($employee_present_days);
		echo "<br>";
		
		echo "employee_paid_leaves function : ";
		$employee_paid_leaves=$this->salarypayfunction->employee_paid_leaves(array('employee_id' => '13'));
		print_r($employee_paid_leaves);
		echo "<br>";
		
		echo "employee_leaves function : ";
		$employee_leaves=$this->salarypayfunction->employee_leaves(array('month' => '4','year' => '2021','employee_id' => $employee_id));
		print_r($employee_leaves);
		echo "<br>";
		
		echo "employee_basicDetails function : ";
		$employee_basicDetails=$this->salarypayfunction->employee_basicDetails(array('employee_id' => $employee_id));
		print_r($employee_basicDetails);
		echo "<br>";
		
		echo "employee_salary_calculation function : ";
		$employee_salary_calculation=$this->salarypayfunction->employee_salary_calculation(array('month' => '4','year' => '2021','employee_id' => $employee_id));
		print_r($employee_salary_calculation);
		echo "<br>";
		
		echo "employee_salaryDeduction function : ";
		$employee_salaryDeduction=$this->salarypayfunction->employee_salaryDeduction(array('month' => '4','year' => '2021','employee_id' => $employee_id));
		print_r($employee_salaryDeduction);
		echo "<br>";
		
		echo "salary_pay function : ";
		$salary_pay=$this->salarypayfunction->salary_pay(array('month' => '4','year' => '2021','employee_id' => $employee_id));
		print_r($salary_pay);
		echo "<br>";
	}
}
