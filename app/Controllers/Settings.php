<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$user_session=$this->session->userdata('id');
		if(!$user_session){
			redirect(base_url());	
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
	public function index()
	{
		
		$data=array();
		$user_session=$this->session->userdata('id');
		$user_role=$this->session->userdata('user_role');
		if(!$user_session){
			redirect(base_url('login'));	
		}
		$this->load->model('Designation_Model');

		$data['designation']= $this->Designation_Model->get_designation();
		$data['menu']="admin_settings";
		if($user_role == 'admin'){
			//$data=array();
			$data['page_title']="Profile";
			$user_session=$this->session->userdata('id');
			$this->load->model('Administrator_Model');
			$admin_settings=$this->Administrator_Model->admin_settings();
			$admin_detail=$this->Administrator_Model->admin_profile($user_session);
			$data['profile']=$admin_settings;
			$data['js_flag']="";
			$user_session=$this->session->userdata('id');
			$this->session->set_userdata('username',$admin_detail[0]->username);
			$this->session->set_userdata('useremail',$admin_detail[0]->email);
			$this->session->set_userdata('profile_image',$admin_detail[0]->profile_image);
			$this->lib->view('administrator/admin_settings',$data);
		}else{
			redirect(base_url('dashboard'));
		}
	}
	
	public function update_setting()
	{
		/*  $q="CREATE TABLE `settings` (
			  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
			  `chnage_date` date NOT NULL,
			  `official_time` varchar(50) NOT NULL,
			  `lunch_time` varchar(50) NOT NULL,
			  `working_days` varchar(100) NOT NULL,
			  `created_date` datetime DEFAULT current_timestamp(),
			  `updated_date` datetime DEFAULT NULL
			)";
		echo $this->db->query($q); 

		die; */
		$user_session=$this->session->userdata('id');
		if(!$user_session){
			redirect(base_url('admin'));	
		}
		
			
		$this->form_validation->set_rules('chnage_date', 'date', 'required');
        $this->form_validation->set_rules('official_time', 'Official Time', 'required');
        $this->form_validation->set_rules('lunch_time', 'Lunch Time', 'required');
        //$this->form_validation->set_rules('working_day', 'Working Days', 'required');
		if ($this->form_validation->run() == false)
        {
			$this->session->set_flashdata('message', validation_errors());
        }else{
			$chnage_date = $this->input->post("chnage_date");
			$official_time = $this->input->post("official_time");
			$lunch_time = $this->input->post("lunch_time");
			$working_day = $this->input->post("working_day");
			$new_create = $this->input->post("new_create");
			$sid = $this->input->post("sid");
			if(!empty($new_create ) && $new_create  == '1'){
				$arr=array(
					'chnage_date' => Format_date($chnage_date)),
					'official_time' => $official_time,
					'lunch_time' => $lunch_time,
					'working_days' => implode(',',$working_day),
					'created_date' => date('Y-m-d h:i:s')
				);
				$this->db->table('settings')->insert($arr);
			}else{
				$arr=array(
					'chnage_date' => Format_date($chnage_date)),
					'official_time' => $official_time,
					'lunch_time' => $lunch_time,
					'working_days' => implode(',',$working_day),
					'updated_date' => date('Y-m-d h:i:s')
				);
				$this->db->table('settings')->where('id',$sid);
				$this->db->update($arr);

			}
			
		}
		 redirect(base_url('settings'));
	}
	
}
