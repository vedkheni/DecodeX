<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Terms_and_condition extends BaseController
{
	public function index()
	{
		$data=array();
		$user_session=$this->session->get('id');
		$user_role=$this->session->get('user_role');
		if(!$user_session){
			return redirect()->to(base_url('login'));	
		}

		$data['designation']= $this->Designation_Model->get_designation();
		$data['menu']="terms_and_condition";		
		$data['terms_and_condition']=$this->Terms_Condition_Model->get_terms_and_condition(1);
		if($user_role == 'admin'){
			$data['page_title']="Terms & Condition";
			$user_session=$this->session->get('id');
			$admin_detail=$this->Administrator_Model->admin_profile($user_session);
			$data['profile']=$admin_detail;
			$data['js_flag']="terms_and_condition";
			$user_session=$this->session->get('id');
			$this->session->set('username',$admin_detail[0]->username);
			$this->session->set('useremail',$admin_detail[0]->email);
			$this->session->set('profile_image',$admin_detail[0]->profile_image);
			$this->lib->view('administrator/terms_and_condition',$data);
		}else{
			$employee_detail=$this->Employee_Model->get_employee($user_session);
			$data['profile']=$employee_detail;
			//echo "<pre/>";
			//print_r($employee_detail);
			$decode_credentials=json_decode($employee_detail[0]->credential);
			$user_session=$this->session->get('id');
			$this->session->set('user_id',$employee_detail[0]->id);
			$this->session->set('username',$employee_detail[0]->fname);
			$this->session->set('useremail',$employee_detail[0]->email);
			$this->session->set('profile_image',$employee_detail[0]->profile_image);
			$data['page_title']="Terms & Condition";
			//$data['js_flag']="emp_js";
			$data['js_flag']="terms_and_condition";
			$this->lib->view('administrator/employee/terms_and_condition',$data);
		}

	}
	public function agree_terms(){
		$agree=$this->request->getPost('agree');
		$emp_id=$this->request->getPost('emp_id');
		$this->db->table('employee')->where('id',$emp_id);
		$this->db->update(array('agree_terms_conditions' => $agree));
	}
	public function update_terms()
	{
		$description=$this->request->getPost('terms_and_condition');

		$get_terms_and_condition=$this->Terms_Condition_Model->get_terms_and_condition(1);
		if(!empty($get_terms_and_condition)){
			echo "update";
			$arr=array(
				'id' => 1,
				'description' => $description,
				'updated_date' => date('Y-m-d h:i:s'),
			);
			$update_employee=$this->Terms_Condition_Model->update_employee($arr);
		}else{
			echo "insert";
			$arr=array(
				'description' => $description,
				'created_date' => date('Y-m-d h:i:s'),
			);
			$insert_employee=$this->Terms_Condition_Model->insert_employee($arr);
			
		}
	}
}

