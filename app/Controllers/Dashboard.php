<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;

class Dashboard extends BaseController {

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
		// $this->cachePage(60);
		$user_session=$this->session->get('id');
		$user_role=$this->session->get('user_role');
		if(!$user_session){
			return redirect()->to(base_url());	
		}
		$data=array();
		$data['terms_and_condition']=$this->Terms_Condition_Model->get_terms_and_condition(1);

		$data['page_title']="Dashboard";
		$data['js_flag']="dashboard_js";
		$data['header']['js_flag']="dashboard_js";
		$data['footer']['js_flag']="dashboard_js";
		$data['menu']="dashboard";

        $data['designation_list'] = $this->Designation_Model->get_designation();
		$data['holiday_all'] = $this->Holiday_Model->get_holiday_all();
		$data['get_employee_attedance']=$this->Dashboard_Model->get_employee_attedance();
		$data['get_current_date_attedance_status']=$this->Dashboard_Model->get_current_date_attedance_status();
		$data['get_employee']=$this->Employee_Model->get_employee_list(1);
		$data['get_employee_joining_date']=$this->Dashboard_Model->get_employee_joining_date();
		$data['get_interview_schedule'] = $this->Candidate_Model->get_interview_schedule();
		$data['this_month_leave']=$this->Dashboard_Model->this_month_leave();
		
		$st_date = '2012-07-20';
		$ed_date = '2012-07-27';
		
		if($user_role != "admin"){
			$arr=array();
			$arr['employee_id']=$user_session;
			$data['get_employee_increment']=$this->Employee_Increment_Model->get_employee_increment_data($user_session,'approved');

			// $employee_paid_leaves=$this->Leave_Report_Model->employee_paid_leaves($user_session);
			$employee_detail=$this->Employee_Model->get_employee($user_session);
			$employee_paid_leaves=$this->Leave_Report_Model->get_employee_paid_leaves(array('id' => $user_session,'year'=> date('Y')));
			$paid_leavesCount=($employee_detail[0]->employee_status == 'employee')?count($this->Leave_Report_Model->get_year_employee_paid_leaves(array('id' => $user_session))):'';
			$get_pc=$this->Pc_Issue_Model->getPc_id($user_session);
			$data['employee_paid_leaves']=$employee_paid_leaves;
			$data['get_employee_data']=$employee_detail;
			$data['get_pc_data']=$get_pc;
			$data['get_employee_total_bonus']=$this->Dashboard_Model->get_employee_total_bonus();
			$data['paid_leavesCount'] = $paid_leavesCount;
			$data['leave_count'] = $this->allfunction->employee_leave_count($arr);
			$data['profile']=$employee_detail;
			$decode_credentials=json_decode($employee_detail[0]->credential);
			$user_session=$this->session->get('id');
			$this->session->set('user_id',$employee_detail[0]->id);
			$this->session->set('username',$employee_detail[0]->fname);
			$this->session->set('useremail',$employee_detail[0]->email);
			$this->session->set('profile_image',$employee_detail[0]->profile_image);
			$this->lib->view('administrator/index',$data);
		}else{
			$data['get_pc_issue']=$this->Pc_Issue_Model->get_pcIssue_all();
			$data['new_pc_issue']=$this->Pc_Issue_Model->get_pcIssue_all('new');
			$data['pending_pc_issue']=$this->Pc_Issue_Model->get_pcIssue_all('pending');
			$data['inprogress_pc_issue']=$this->Pc_Issue_Model->get_pcIssue_all('inprogress');
			$data['get_employee_increment']=$this->Employee_Increment_Model->get_employee_increment('pending');
			//echo $this->db->last_query();
			$user_session=$this->session->get('id');
			$admin_detail=$this->Administrator_Model->admin_profile($user_session);
			$user_session=$this->session->get('id');
			$this->session->set('username',$admin_detail[0]->username);
			$this->session->set('useremail',$admin_detail[0]->email);
			$this->session->set('profile_image',$admin_detail[0]->profile_image);
			$this->lib->view('administrator/dashboard',$data);
		}
		
		
		//$this->load->view('welcome_message');
	}
	public function update_increment_status(){
		$id=$this->request->getPost('id');
		$increment_status=$this->request->getPost('increment_status');
		
		$get_employee=$this->Employee_Model->get_employee_details($id);
		$get_employee_increment_row=$this->Employee_Increment_Model->get_employee_increment_row($id);
		
		if(!empty($get_employee_increment_row)){
			echo json_encode($get_employee_increment_row);
		}else{
			if(!empty($get_employee)){
				echo json_encode($get_employee);
			}else{
				echo "0";
			}
		}
	}
	public function insert_increment_rejected(){
	//	print_r($_POST);
		$increment_status=$this->request->getPost('rejected_increment_status');
		if(trim($increment_status) == "Pending"){
			$id=$this->request->getPost('rejected_emp_id');
			$increment_date= Format_date($this->request->getPost('rejected_increment_date'));
			$get_employee_increment_row=$this->Employee_Increment_Model->get_increment_row($id);
			//print_r($get_employee_increment_row);
			//die;
			if(!empty($get_employee_increment_row)){
				//update
				
				$curdate=strtotime(date('Y-m-d'));
				$mydate=strtotime($increment_date);
				if($curdate > $mydate)
				{
					echo '<span class="status expired">Expired</span>';
				}  
				//print_r($get_employee_increment_row);
				$arr=array(
				'id' => $id,
				'increment_date' => $increment_date,
				'next_increment_date' => "0000-00-00",
				'amount' => "0",
				'status' => 'pending',
				'updated_date' => date('Y-m-d h:i:s'),
				);
				$insert_employee=$this->Employee_Increment_Model->update_data($arr);
				if($insert_employee){
					echo "update";
				}
			}else{
				 /* insert */
				/* $emp_id=$this->request->getPost('rejected_emp_id');
				$increment_date=$this->request->getPost('rejected_increment_date');
			
				$arr=array(
				'increment_date' => $increment_date,
				'employee_id' => $emp_id,
				'next_increment_date' => "0000-00-00",
				'amount' => "0",
				'status' => 'pending',
				'created_date' => date('Y-m-d h:i:s'),
				);
				$insert_employee=$this->Employee_Increment_Model->insert_data($arr);
				//echo $this->db->last_query();			
				if($insert_employee){
					echo "insert";
				} */
			} 
		}	
		//die;
	}
	public function insert_increment(){
		$data = array();
		$increment_status=$this->request->getPost('increment_status');
		if(trim($increment_status) == "Approved"){
			$emp_id=$this->request->getPost('emp_id');
			$id=$this->request->getPost('id');
			$increment_date= Format_date($this->request->getPost('increment_date'));	
			$increment_amount= $this->request->getPost('increment_amount');
			$next_increment_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($increment_date)) . " + 1 year"));
			if($this->request->getPost('next_increment_amount') != ""){
				$next_increment_date= Format_date($this->request->getPost('next_increment_amount'));
			}
			$list_data = $this->Employee_Model->get_employee($emp_id);
			$get_employee_increment_row=$this->Employee_Increment_Model->get_employee_increment_data($emp_id,'pending');
			$get_employee_row=$this->Employee_Increment_Model->get_employee_increment_row($emp_id);
			/* print_r($get_employee_increment_row);
			print_r($get_employee_row);
			die; */
			if(!empty($get_employee_increment_row)){
				$arr=array(
					'id' => $get_employee_increment_row[0]->id,
					'increment_date' => $increment_date,
					//'employee_id' => $emp_id,
					'amount' => $increment_amount,
					'status' => 'approved',
					'updated_date' => date('Y-m-d h:i:s'),
				);
				$insert_employee=$this->Employee_Increment_Model->update_data($arr);
				if($insert_employee){
					$arr=array(
						'increment_date' => $next_increment_date,
						'employee_id' => $emp_id,
						'amount' => 0,
						'status' => 'pending',
						'created_date' => date('Y-m-d h:i:s'),
					);
					$this->Employee_Increment_Model->insert_data($arr);
					$employed_date = '';
					if($list_data[0]->employed_date == '' || $list_data[0]->employed_date == '0000-00-00'){
						$employed_date = date('Y-m-d');
					}else{
						$employed_date = Format_date($list_data[0]->employed_date);
					}
					$arr1=array(
						'id' => $emp_id,
						'salary' => ($get_employee_row->salary+$increment_amount),
						'salary_deduction' => 0,
						'employee_status' => 'employee',
						'employed_date' => $employed_date,
						'updated_date' => date('Y-m-d h:i:s'),
					);
					$update_emp = $this->Employee_Model->update_employee($arr1);
					if($list_data[0]->personal_email){
						$mail_data = array();
						$content = $this->Mail_Content_Model->mail_content_by_slug('salary_increment_mail');
						$variables = array(
							"{{date}}" => dateFormat($increment_date),
							"{{amount}}" => $increment_amount,
							"{{new_salary}}" => ($get_employee_row->salary+$increment_amount),
						);
						$message = $content[0]->content;
						foreach ($variables as $key => $value){
							$message = str_replace($key, $value, $message);
						}
						$mail_data = array(
							'mail_type' => 'salary_increment',
							'subject' => 'Salary Increment Mail from Geek Web Solution '.date('M, Y',strtotime($increment_date)),
							'title' => 'Increment Mail '.date('M, Y',strtotime($increment_date)),
							'greeting' => 'Dear',
							'img_name' => 'increment.png',
							'message' => $message,
							'name' => $list_data[0]->fname.' '.$list_data[0]->lname,
							'to' => $list_data[0]->personal_email,
							'base_url' => base_url(),
						);
						/* $data1['mail_type'] = 'salary_pay';
						$data1['subject'] = 'Salary Increment from Geek Web Solution '.date('M, Y',strtotime($increment_date));
						$data1['title'] = date('M, Y',strtotime($increment_date)).' Salary Increment';
						$data1['greeting'] = 'Dear';
						$data1['img_name'] = 'salary-paid.png';
						$data1['message'] = $message;
						$data1['name'] = $list_data[0]->fname.' '.$list_data[0]->lname;
						$data1['to'] = $list_data[0]->personal_email;
						$data1['salary'] = ($get_employee_row->salary+$increment_amount);
						$data1['base_url'] = base_url(); */
						$mail_send_code = $this->mailfunction->mail_send($mail_data);
						if($mail_send_code){
							$data['error_code'] = 0;
							$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Increment Added.</p></div></div></div>';
						}else{
							$data['error_code'] = 1;
							$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">Mail not sended.</p></div></div></div>';
							echo json_encode($data);exit;
						}
						// $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Bank status successfully updated.</p></div></div></div>';
					}else{
						$data['error_code'] = 1;
						$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">Employee personal email not found</p></div></div></div>';
					}
					// $data['error_code'] = 0;
					// $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Insert increment successfully.</p></div></div></div>';
				}
			}
				// insert
				/* $arr=array(
				'increment_date' => $increment_date,
				'employee_id' => $emp_id,
				'next_increment_date' => $next_increment_date,
				'amount' => $increment_amount,
				'status' => strtolower($increment_status),
				'created_date' => date('Y-m-d h:i:s'),
				);
				$insert_employee=$this->Employee_Increment_Model->insert_data($arr); */
			
			
		}
		echo json_encode($data);exit;
	}
	
	public function checkPassword(){
		$id=$this->request->getPost('id');
		$data = array();
		$employee_detail = $this->Employee_Model->get_employee($id);
		$decode = md5('DecodeX@217');
		if($employee_detail[0]->password == $decode){
			$data['status'] = 'match';
		}else{
			$data['status'] = "not_match";
		}
		$data['employee_detail'] = $employee_detail;
		echo json_encode($data);
	}
	
	public function changePassword(){
		$data=array();
		
		$id = $this->request->getPost("id");
		$pass = $this->request->getPost("pass");
		$old_password = $this->request->getPost("old_password");
		$new_password = $this->request->getPost("new_password");
		$confirm_password = $this->request->getPost("confirm_password");
		
		$this->form_validation->reset();
		
		if(!empty($new_password) && !empty($confirm_password)){
			$this->form_validation->setRule('new_password', 'Password', 'required');
			$this->form_validation->setRule('confirm_password', 'Confirm password', 'required|matches[new_password]');
		}

		if($this->validate($this->form_validation->getRules()) == false)
		{
			$data['error_code'] = 1;
			$data['message'] = '<div class="msg-box error-box box2"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text text2"><p>'.$this->validator->listErrors().'</p></div></div></div>';
			echo json_encode($data);exit;
		}else{
			$arr = array();
			//die;
			if(!isset($id) || empty($id)){
				$data['error_code'] = 1;
				$data['message'] = '<div class="msg-box error-box box2"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text text2"><p>User id not match!</p></div></div></div>';
				echo json_encode($data);exit;
			}else{
				$decode = '';
				if(!empty($old_password) && !empty($new_password) && !empty($confirm_password)){
					if(md5($old_password) == $pass){
						if($new_password == 'DecodeX@217*' || $new_password == 'Decodex@217*' || $new_password == 'decodex@217' || $new_password == 'DecodeX217@'){
							$data['error_code'] = 1;
							$data['message'] = '<div class="msg-box error-box box2"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text text2"><p>You used a common password. Please choose a different one!</p></div></div></div>';
							echo json_encode($data);exit;
						}else{
							$decode = md5($new_password);
							$arr=array(
								'id' => $id,
								'password' => $decode,
							);
						}
					}else{
						$data['error_code'] = 1;
						$data['message'] = '<div class="msg-box error-box box2"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text text2"><p>Old Password Not Match!</p></div></div></div>';
						echo json_encode($data);exit;
					}
				}
				// $insert_employee = true;
				$insert_employee = $this->Employee_Model->update_employee($arr);
				if($insert_employee){
					$data['error_code'] = 0;
					$data['message'] = '<div class="msg-box success-box box2"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text text2"><p>Password changed.</p></div></div></div>';
					echo json_encode($data);exit;
					
				}			
			}
		}
	}	
	
	public function log_time(){
		$get_log_time=$this->Dashboard_Model->get_log_time();
	}

	public function employee_list(){
		$user_role=$this->session->get('user_role');
	}

	public function create_table(){
		/* $q="CREATE TABLE `employee_increment` (
		  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
		  `employee_id` int(11) NOT NULL,
		  `increment_date` date NOT NULL,
		  `next_increment_date` date NOT NULL,
		  `amount` int(11) NOT NULL,
		  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
		  `updated_date` datetime DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1";
		//$u="UPDATE `employee_increment` SET `employee_id` = '4' WHERE `employee_increment`.`id` = 3;";
		echo $this->db->query($q);
		echo "hello"; */
		/* $q="ALTER TABLE `employee_increment` CHANGE `status` `status` ENUM('approved','rejected') NOT NULL;";
		//$u="UPDATE `employee_increment` SET `employee_id` = '4' WHERE `employee_increment`.`id` = 3;";
		echo $this->db->query($q);
		echo "hello"; */
					
	}
}
