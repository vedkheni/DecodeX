<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team_and_condition extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data=array();
		$user_session=$this->session->userdata('id');
		$user_role=$this->session->userdata('user_role');
		if(!$user_session){
			redirect(base_url('login'));	
		}
		$this->load->model('Designation_Model');
		$this->load->model('Team_Condition_Model');

		$data['designation']= $this->Designation_Model->get_designation();
		$data['menu']="team_and_condition";		
		$data['team_and_condition']=$this->Team_Condition_Model->get_team_and_condition(1);
		if($user_role == 'admin'){
			$data['page_title']="Team & Condition";
			$user_session=$this->session->userdata('id');
			$this->load->model('Administrator_Model');
			$admin_detail=$this->Administrator_Model->admin_profile($user_session);
			$data['profile']=$admin_detail;
			$data['js_flag']="team_and_condition";
			$user_session=$this->session->userdata('id');
			$this->session->set_userdata('username',$admin_detail[0]->username);
			$this->session->set_userdata('useremail',$admin_detail[0]->email);
			$this->session->set_userdata('profile_image',$admin_detail[0]->profile_image);
			$this->lib->view('administrator/team_and_condition',$data);
		}else{
			$this->load->model('employee_Model');
			$employee_detail=$this->employee_Model->get_employee($user_session);
			$data['profile']=$employee_detail;
			//echo "<pre/>";
			//print_r($employee_detail);
			$decode_credentials=json_decode($employee_detail[0]->credential);
			$user_session=$this->session->userdata('id');
			$this->session->set_userdata('user_id',$employee_detail[0]->id);
			$this->session->set_userdata('username',$employee_detail[0]->fname);
			$this->session->set_userdata('useremail',$employee_detail[0]->email);
			$this->session->set_userdata('profile_image',$employee_detail[0]->profile_image);
			$data['page_title']="Team & Condition";
			//$data['js_flag']="emp_js";
			$data['js_flag']="team_and_condition";
			$this->lib->view('administrator/employee/team_and_condition',$data);
		}

	}
	public function agree_team(){
		$agree=$this->input->post('agree');
		$emp_id=$this->input->post('emp_id');
		$this->db->table('employee')->where('id',$emp_id);
		$this->db->update(array('agree_terms_conditions' => $agree));
	}
	public function update_team()
	{
		$this->load->model('Team_Condition_Model');
		$description=$this->input->post('team_and_condition');

		$get_team_and_condition=$this->Team_Condition_Model->get_team_and_condition(1);
		if(!empty($get_team_and_condition)){
			echo "update";
			$arr=array(
				'id' => 1,
				'description' => $description,
				'updated_date' => date('Y-m-d h:i:s'),
			);
			$update_employee=$this->Team_Condition_Model->update_employee($arr);
		}else{
			echo "insert";
			$arr=array(
				'description' => $description,
				'created_date' => date('Y-m-d h:i:s'),
			);
			$insert_employee=$this->Team_Condition_Model->insert_employee($arr);
			
		}
	}
}
