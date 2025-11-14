<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Change_role extends BaseController {
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
		
		$data=array();
		$user_session=$this->session->get('id');
		$data['profile']=$this->Employee_Model->get_employee($user_session);
		if(!$user_session){
			return redirect()->to(base_url('admin'));	
		}
		$data['page_title']="Profile";
		$data['js_flag']="emp_js";
		$this->lib->view('administrator/employee/profile',$data);
	}
	 public function employee_login(){
	 	$user_session=$this->session->get('id');
		$user_user_role=$this->session->get('user_role');
		$id=$this->uri->getSegment(3);
		//$edit['id']=$id;
		//echo $id;
		$user_data=$this->Employee_Model->get_employee($id);
		
		if($user_user_role!='admin')
		{
			return redirect()->to(base_url());
			//die;
		}
		$data = array( 
					'username' => $user_data[0]->email,
					'useremail' => $user_data[0]->email,
					'gender' => $user_data[0]->gender,
					'id' => $user_data[0]->id,
					'user_role' => $user_data[0]->user_role,
					'admin_id' => $user_session,
					); 
					
					$this->session->set($data);
					return redirect()->to(base_url('dashboard'));
					// return redirect()->to(base_url('profile'));
	 }
	  public function admin_login(){
	  	$user_session=$this->session->get('id');
		$admin_id=$this->session->get('admin_id');
		$user_data=$this->Employee_Model->get_employee($user_session);
		$admin_data=$this->Employee_Model->get_admin($admin_id);
		if($admin_data[0]->user_role!='admin')
		{
			return redirect()->to(base_url());
			die;
		}
						
			$data = array( 
					'username' => $admin_data[0]->username,
					'useremail' => $admin_data[0]->email,
					'profile_image' => $admin_data[0]->profile_image,
					'id' => $admin_data[0]->id,
					'user_role' => $admin_data[0]->user_role,
					'admin_id' => ''
					); 
					$this->session->set($data);
					return redirect()->to(base_url('employee'));
	  }

}
